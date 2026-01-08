<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Status Compatibility Model
 * Handles mapping between old and new status systems to ensure backward compatibility
 */
class Status_compatibility_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
    }
    
    /**
     * Map new workflow status to legacy numeric status for backward compatibility
     */
    public function mapWorkflowStatusToLegacyStatus($workflowStatus) {
        $statusMap = [
            'floor_draft' => 1,           // Pending
            'patient_draft' => 1,         // Pending
            'floor_submitted' => 1,       // Pending (awaiting nurse)
            'nurse_reviewing' => 1,       // Pending
            'nurse_approved' => 2,        // Approved
            'nurse_sent' => 2,           // Approved (legacy)
            'chef_preparing' => 2,        // Approved/In Progress
            'chef_completed' => 3,        // Ready for Delivery
            'delivered' => 4,             // Delivered
            'cancelled' => 0              // Cancelled
        ];
        
        return $statusMap[$workflowStatus] ?? 1; // Default to Pending
    }
    
    /**
     * Get display status for UI components
     */
    public function getDisplayStatus($order) {
        // Check if this is a floor-consolidated order
        if (isset($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
            return $this->getFloorOrderDisplayStatus($order);
        } else {
            return $this->getLegacyOrderDisplayStatus($order);
        }
    }
    
    /**
     * Get display status for floor-consolidated orders
     */
    private function getFloorOrderDisplayStatus($order) {
        $workflowStatus = $order['workflow_status'] ?? 'floor_draft';
        
        $statusMap = [
            'floor_draft' => [
                'text' => 'Draft',
                'class' => 'bg-gray-100 text-gray-700',
                'badge_class' => 'status-pending'
            ],
            'patient_draft' => [
                'text' => 'Draft',
                'class' => 'bg-gray-100 text-gray-700',
                'badge_class' => 'status-pending'
            ],
            'floor_submitted' => [
                'text' => 'Awaiting Approval',
                'class' => 'bg-yellow-100 text-yellow-700',
                'badge_class' => 'status-pending'
            ],
            'nurse_reviewing' => [
                'text' => 'Under Review',
                'class' => 'bg-blue-100 text-blue-700',
                'badge_class' => 'status-in-progress'
            ],
            'nurse_approved' => [
                'text' => 'Approved',
                'class' => 'bg-green-100 text-green-700',
                'badge_class' => 'status-ready'
            ],
            'chef_preparing' => [
                'text' => 'Preparing',
                'class' => 'bg-orange-100 text-orange-700',
                'badge_class' => 'status-in-progress'
            ],
            'chef_completed' => [
                'text' => 'Ready for Delivery',
                'class' => 'bg-blue-100 text-blue-700',
                'badge_class' => 'status-ready'
            ],
            'delivered' => [
                'text' => 'Delivered',
                'class' => 'bg-emerald-100 text-emerald-700',
                'badge_class' => 'status-delivered'
            ],
            'cancelled' => [
                'text' => 'Cancelled',
                'class' => 'bg-red-100 text-red-700',
                'badge_class' => 'status-cancelled'
            ]
        ];
        
        return $statusMap[$workflowStatus] ?? $statusMap['floor_draft'];
    }
    
    /**
     * Get display status for legacy orders
     * Status Flow: 1 (Pending) → 3 (Ready) → 4 (Delivered) → 2 (Paid)
     */
    private function getLegacyOrderDisplayStatus($order) {
        $status = $order['status'] ?? 1;
        
        $statusMap = [
            0 => [
                'text' => 'Cancelled',
                'class' => 'bg-red-100 text-red-700',
                'badge_class' => 'status-cancelled'
            ],
            1 => [
                'text' => 'Pending',
                'class' => 'bg-yellow-100 text-yellow-700',
                'badge_class' => 'status-pending'
            ],
            2 => [
                'text' => 'Paid',
                'class' => 'bg-success text-white',
                'badge_class' => 'status-paid'
            ],
            3 => [
                'text' => 'Ready for Delivery',
                'class' => 'bg-info text-white',
                'badge_class' => 'status-ready'
            ],
            4 => [
                'text' => 'Delivered',
                'class' => 'bg-primary text-white',
                'badge_class' => 'status-delivered'
            ]
        ];
        
        return $statusMap[$status] ?? $statusMap[1];
    }
    
    /**
     * Get delivery status for floor/department (used in chef dashboard)
     */
    public function getFloorDeliveryStatus($floorId, $orderDate = null) {
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        if (!$orderDate) {
            $orderDate = australia_date_only();
        }
        
        // Get floor order for the date
        $this->tenantDb->select('workflow_status, total_suites, participating_suites');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('floor_id', $floorId);
        $this->tenantDb->where('date', $orderDate);
        $this->tenantDb->where('is_floor_consolidated', 1);
        $this->tenantDb->where('status', 1); // Active orders only
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() == 0) {
            return [
                'status' => 'no_orders',
                'details' => 'No orders for today'
            ];
        }
        
        $floorOrder = $query->row_array();
        $workflowStatus = $floorOrder['workflow_status'];
        
        // Map workflow status to delivery status
        switch ($workflowStatus) {
            case 'floor_draft':
            case 'patient_draft':
                return [
                    'status' => 'unsent_orders',
                    'details' => 'Orders not yet submitted'
                ];
                
            case 'floor_submitted':
            case 'nurse_reviewing':
                return [
                    'status' => 'not_started',
                    'details' => 'Awaiting nurse approval'
                ];
                
            case 'nurse_approved':
                return [
                    'status' => 'not_started',
                    'details' => 'Approved, ready to start preparation'
                ];
                
            case 'chef_preparing':
                // Check completion progress
                $progress = $this->getFloorOrderProgress($floorOrder['order_id'] ?? 0);
                if ($progress['completed_items'] == 0) {
                    return [
                        'status' => 'not_started',
                        'details' => 'Preparation not started'
                    ];
                } elseif ($progress['completed_items'] < $progress['total_items']) {
                    return [
                        'status' => 'in_progress',
                        'details' => "Preparing ({$progress['completed_items']}/{$progress['total_items']} items ready)"
                    ];
                } else {
                    return [
                        'status' => 'ready_for_delivery',
                        'details' => 'All items prepared, ready for delivery'
                    ];
                }
                
            case 'chef_completed':
                return [
                    'status' => 'ready_for_delivery',
                    'details' => 'Food ready, awaiting delivery'
                ];
                
            case 'delivered':
                return [
                    'status' => 'delivered',
                    'details' => 'Food delivered to floor'
                ];
                
            default:
                return [
                    'status' => 'unknown',
                    'details' => 'Status unknown'
                ];
        }
    }
    
    /**
     * Get floor order preparation progress
     */
    private function getFloorOrderProgress($orderId) {
        if (!$orderId) {
            return ['total_items' => 0, 'completed_items' => 0];
        }
        
        // Get total items
        $this->tenantDb->select('COUNT(*) as total');
        $this->tenantDb->from('orders_to_patient_options');
        $this->tenantDb->where('order_id', $orderId);
        $totalQuery = $this->tenantDb->get();
        $totalItems = $totalQuery->row()->total ?? 0;
        
        // Get completed items
        $this->tenantDb->select('COUNT(*) as completed');
        $this->tenantDb->from('orders_to_patient_options');
        $this->tenantDb->where('order_id', $orderId);
        $this->tenantDb->where('status', 1); // Completed status
        $completedQuery = $this->tenantDb->get();
        $completedItems = $completedQuery->row()->completed ?? 0;
        
        return [
            'total_items' => $totalItems,
            'completed_items' => $completedItems
        ];
    }
    
    /**
     * Update legacy status when workflow status changes
     */
    public function syncLegacyStatus($orderId, $newWorkflowStatus) {
        $legacyStatus = $this->mapWorkflowStatusToLegacyStatus($newWorkflowStatus);
        
        $updateData = [
            'status' => $legacyStatus,
            'workflow_status' => $newWorkflowStatus
        ];
        
        return $this->common_model->commonRecordUpdate('orders', 'order_id', $orderId, $updateData);
    }
    
    /**
     * Get status transitions available for current user and order
     */
    public function getAvailableTransitions($order, $userRole) {
        if (isset($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
            // Use floor order model for consolidated orders
            $this->load->model('floor_order_model');
            return $this->floor_order_model->getAvailableStatusTransitions($order['workflow_status'], $userRole);
        } else {
            // Legacy order transitions
            return $this->getLegacyStatusTransitions($order['status'], $userRole);
        }
    }
    
    /**
     * Get legacy status transitions
     * Status Flow: 1 (Pending) → 3 (Ready) → 4 (Delivered) → 2 (Paid)
     */
    private function getLegacyStatusTransitions($currentStatus, $userRole) {
        $transitions = [
            1 => [ // Pending
                6 => [3], // Reception can mark ready
                4 => [3], // Patient can mark ready
                3 => [3], // Nurse can mark ready
                2 => [3, 4], // Chef can mark ready or deliver
                1 => [3, 4] // Admin can mark ready or deliver
            ],
            3 => [ // Ready for Delivery
                2 => [4], // Chef can deliver
                3 => [4], // Nurse can deliver
                1 => [4] // Admin can deliver
            ],
            4 => [ // Delivered
                1 => [2], // Only admin can mark paid
                3 => [2]  // Nurse can mark paid
            ],
            2 => [ // Paid (final status)
                // No further transitions
            ]
        ];
        
        return $transitions[$currentStatus][$userRole] ?? [];
    }
}
?>
