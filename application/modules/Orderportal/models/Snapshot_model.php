<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Snapshot Model
 * 
 * Creates and manages immutable historical snapshots of orders, suites, patients, and menu items.
 * This ensures that historical data remains accurate regardless of future changes to live data.
 * 
 * Key Features:
 * - Captures complete order state at the moment of creation
 * - Stores patient information, suite assignments, and menu details permanently
 * - Locks prices and menu item details at order time
 * - Provides audit trail for compliance and reporting
 * 
 * @package    OrderPortal
 * @subpackage Models
 * @category   Snapshot
 * @author     BizOrder
 * @created    2025-01-09
 */
class Snapshot_model extends CI_Model {
    
    public function __construct() {
		parent::__construct();
		$this->load->helper('custom'); // Load custom helper for Australia timezone functions
	}
	
	/**
	 * Get tenantDb connection - lazy load from controller if not already set
	 * This ensures tenantDb is available even if model constructor runs before controller fully initializes
	 * Sets $this->tenantDb so all existing code continues to work
	 */
	private function getTenantDb() {
		// If already set and valid, return it
		if (isset($this->tenantDb) && !empty($this->tenantDb)) {
			return $this->tenantDb;
		}
		
		// Try to get from controller instance (works in CodeIgniter/MX)
		$CI = &get_instance();
		if (isset($CI->tenantDb) && !empty($CI->tenantDb)) {
			$this->tenantDb = $CI->tenantDb;
			return $this->tenantDb;
		}
		
		// Last resort: Try direct access (some CodeIgniter/MX setups allow this)
		// This handles cases where CodeIgniter/MX automatically provides access
		if (property_exists($this, 'tenantDb') && isset($this->tenantDb) && !empty($this->tenantDb)) {
			return $this->tenantDb;
		}
		
		// If all else fails, log error with details
		$errorDetails = "Controller tenantDb: " . (isset($CI->tenantDb) ? (empty($CI->tenantDb) ? 'exists but empty' : 'exists and set') : 'does not exist');
		log_message('error', "Snapshot: tenantDb not available - Cannot access database. " . $errorDetails);
		return null;
	}
    
    /**
     * Check if snapshot tables exist in database
     * This prevents errors if tables haven't been created yet
     * 
     * @return bool
     */
    private function tablesExist() {
        try {
            // ✅ CRITICAL: Get tenantDb (lazy load if needed) - sets $this->tenantDb
            if (!$this->getTenantDb()) {
                log_message('error', "Snapshot: tenantDb is not available - Cannot check if tables exist");
                return false;
            }
            
            // Check if order_snapshots table exists
            $query = $this->tenantDb->query("SHOW TABLES LIKE 'order_snapshots'");
            $exists = $query->num_rows() > 0;
            
            if (!$exists) {
                log_message('warning', "Snapshot: order_snapshots table does not exist in database - Snapshots will be skipped. Please run CREATE_ORDER_SNAPSHOT_TABLES.sql");
            }
            
            return $exists;
        } catch (Exception $e) {
            log_message('error', "Snapshot: Exception checking if tables exist - " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update or create order snapshot when order is updated
     * Preserves existing snapshots - creates new one only if it doesn't exist
     * 
     * @param int $orderId The order_id from the orders table
     * @return int|false The order_snapshot_id if successful, false on failure
     */
    public function updateOrderSnapshot($orderId) {
        try {
            // ✅ CRITICAL: Get tenantDb (lazy load if needed) - sets $this->tenantDb
            if (!$this->getTenantDb()) {
                log_message('error', "Snapshot: tenantDb not available - Cannot update snapshot for Order ID: $orderId");
                return false;
            }
            
            // ✅ PERMANENT FIX: Keep ALL historical snapshots - DO NOT DELETE old snapshots!
            // This preserves complete order history and prevents any risk of data loss
            // Each update creates a NEW snapshot, keeping all previous snapshots intact
            
            // Check if snapshot already exists
            $existingSnapshots = $this->tenantDb->select('id, created_at, total_suites, total_items')
                ->from('order_snapshots')
                ->where('order_id', $orderId)
                ->order_by('created_at', 'DESC')
                ->get()
                ->result_array();
            
            if (!empty($existingSnapshots)) {
                $latestSnapshot = $existingSnapshots[0];
                $snapshotCount = count($existingSnapshots);
                log_message('info', "Snapshot: Found {$snapshotCount} existing snapshot(s) for Order ID: $orderId. Latest snapshot ID: {$latestSnapshot['id']}, Created: {$latestSnapshot['created_at']}, Suites: {$latestSnapshot['total_suites']}, Items: {$latestSnapshot['total_items']}. Creating NEW snapshot to preserve history.");
            } else {
                log_message('info', "Snapshot: No existing snapshots found for Order ID: $orderId. Creating first snapshot.");
            }
            
            // ✅ CRITICAL: Create NEW snapshot WITHOUT deleting old ones
            // This preserves complete order history and prevents data loss
            $newSnapshotId = $this->createOrderSnapshot($orderId);
            if ($newSnapshotId) {
                log_message('info', "Snapshot: Created fresh snapshot ID: $newSnapshotId for Order ID: $orderId");
            }
            return $newSnapshotId;
        } catch (Exception $e) {
            log_message('error', "Snapshot: Failed to update snapshot for Order ID: $orderId - " . $e->getMessage() . ", Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
    
    /**
     * Create complete order snapshot when order is placed
     * 
     * This is the main entry point - call this after an order is successfully created.
     * It captures:
     * - Order header (date, floor, creator, status)
     * - All suites in the order
     * - Patient information for each suite (permanent snapshot)
     * - All menu items with prices locked at order time
     * 
     * @param int $orderId The order_id from the orders table
     * @return int|false The order_snapshot_id if successful, false on failure
     */
    public function createOrderSnapshot($orderId) {
        try {
            // ✅ CRITICAL: Get tenantDb (lazy load if needed) - sets $this->tenantDb
            if (!$this->getTenantDb()) {
                log_message('error', "Snapshot: tenantDb not available - Cannot create snapshot for Order ID: $orderId");
                return false;
            }
            
            // 0. Check if snapshot tables exist (graceful degradation)
            if (!$this->tablesExist()) {
                log_message('warning', "Snapshot: Tables not created yet - Skipping snapshot for Order ID: $orderId. Run CREATE_ORDER_SNAPSHOT_TABLES.sql to enable snapshots.");
                return false; // Fail gracefully - don't break order creation
            }
            
            // 1. Get order details
            $orderQuery = $this->tenantDb->get_where('orders', ['order_id' => $orderId]);
            if (!$orderQuery || $orderQuery->num_rows() == 0) {
                log_message('error', "Snapshot: Order not found - ID: $orderId");
                return false;
            }
            $order = $orderQuery->row_array();
            
            // 2. Get floor details
            $floorQuery = $this->tenantDb->get_where('foodmenuconfig', [
                'id' => $order['dept_id'],
                'listtype' => 'floor'
            ]);
            $floor = ($floorQuery && $floorQuery->num_rows() > 0) ? $floorQuery->row_array() : null;
            
            // 3. Get creator details - Handle gracefully if table doesn't exist
            $creator = null;
            try {
                // Query Global_users from tenant database
                $creatorQuery = $this->tenantDb->get_where('Global_users', ['id' => $order['added_by']]);
                if ($creatorQuery && $creatorQuery->num_rows() > 0) {
                    $creator = $creatorQuery->row_array();
                }
            } catch (Exception $e) {
                // Table doesn't exist or query failed - use fallback values
                log_message('debug', "Snapshot: Could not fetch creator from Global_users, using fallback - " . $e->getMessage());
            }
            
            // 4. Count suites and items
            $suiteCount = $this->tenantDb->query("
                SELECT COUNT(DISTINCT bed_id) as total 
                FROM orders_to_patient_options 
                WHERE order_id = ?
            ", [$orderId])->row();
            
            $itemCount = $this->tenantDb->query("
                SELECT SUM(quantity) as total 
                FROM orders_to_patient_options 
                WHERE order_id = ?
            ", [$orderId])->row();
            
            // 5. Create order snapshot (immutable header)
            $orderSnapshot = [
                'order_id' => $orderId,
                'order_date' => $order['date'],
                'floor_id' => $order['dept_id'],
                'floor_name' => $floor['name'] ?? 'Unknown Floor',
                'created_by_user_id' => $order['added_by'],
                'created_by_user_name' => trim(($creator['first_name'] ?? '') . ' ' . ($creator['last_name'] ?? '')) ?: 'Unknown User',
                'order_type' => $order['buttonType'],
                'workflow_status' => $order['workflow_status'] ?? 'pending',
                'total_suites' => $suiteCount->total ?? 0,
                'total_items' => $itemCount->total ?? 0,
                'is_floor_consolidated' => $order['is_floor_consolidated'] ?? 0,
                'order_notes' => '',
                'created_at' => australia_datetime(),
                'status' => 1
            ];
            
            $this->tenantDb->insert('order_snapshots', $orderSnapshot);
            $orderSnapshotId = $this->tenantDb->insert_id();
            
            if (!$orderSnapshotId) {
                log_message('error', "Snapshot: Failed to create order snapshot for Order ID: $orderId");
                return false;
            }
            
            // 6. Create suite and menu item snapshots
            try {
                $this->createSuiteSnapshots($orderSnapshotId, $orderId, $order);
            } catch (Exception $e) {
                log_message('warning', "Snapshot: Suite snapshot creation failed - " . $e->getMessage() . " - Order snapshot header saved successfully");
            }
            
            log_message('info', "Snapshot: Created successfully - Snapshot ID: $orderSnapshotId for Order ID: $orderId");
            
            return $orderSnapshotId;
            
        } catch (Exception $e) {
            log_message('error', "Snapshot: Exception - " . $e->getMessage() . " at line " . $e->getLine() . " - Order placement will continue");
            return false;
        }
    }
    
    /**
     * Create suite-level snapshots with patient information
     * 
     * @param int $orderSnapshotId
     * @param int $orderId
     * @param array $order Original order data
     */
    private function createSuiteSnapshots($orderSnapshotId, $orderId, $order) {
        try {
            // Get all suites in this order
            $suitesQuery = $this->tenantDb->query("
                SELECT DISTINCT opo.bed_id
                FROM orders_to_patient_options opo
                WHERE opo.order_id = ?
            ", [$orderId]);
            
            if (!$suitesQuery || $suitesQuery->num_rows() == 0) {
                log_message('warning', "Snapshot: No suites found for Order ID: $orderId");
                return;
            }
            
            $suites = $suitesQuery->result_array();
        } catch (Exception $e) {
            log_message('error', "Snapshot: Failed to fetch suites - " . $e->getMessage());
            return;
        }
        
        foreach ($suites as $suite) {
            try {
                $bedId = $suite['bed_id'];
                
                // Get suite details
                $suiteDetailsQuery = $this->tenantDb->get_where('suites', ['id' => $bedId]);
                $suiteDetails = ($suiteDetailsQuery && $suiteDetailsQuery->num_rows() > 0) ? $suiteDetailsQuery->row_array() : [];
            
            // ✅ CRITICAL: Get patient from orders_to_patient_options FIRST (patient at time of order)
            // This ensures we capture the patient who was actually in the suite when the order was placed
            // even if they've since been transferred
            $patient = null;
            $orderPatientQuery = $this->tenantDb->query("
                SELECT DISTINCT opo.patient_id
                FROM orders_to_patient_options opo
                WHERE opo.order_id = ? AND opo.bed_id = ? AND opo.patient_id IS NOT NULL
                LIMIT 1
            ", [$orderId, $bedId]);
            
            if ($orderPatientQuery && $orderPatientQuery->num_rows() > 0) {
                $orderPatientId = $orderPatientQuery->row()->patient_id;
                // Get full patient details from people table using the patient_id from order
                $patient = $this->tenantDb->query("
                    SELECT * FROM people 
                    WHERE id = ?
                    LIMIT 1
                ", [$orderPatientId])->row_array();
            }
            
            // Fallback: If no patient found in order, get current active patient
            // This handles cases where order was placed without patient assignment
            if (empty($patient)) {
                $patient = $this->tenantDb->query("
                    SELECT * FROM people 
                    WHERE suite_number = ? AND status = 1
                    AND (date_of_discharge IS NULL OR date_of_discharge >= CURDATE())
                    ORDER BY date_onboarded DESC
                    LIMIT 1
                ", [$bedId])->row_array();
            }
            
            // Get floor name for this suite
            $suiteFloor = $this->tenantDb->get_where('foodmenuconfig', [
                'id' => $suiteDetails['floor'] ?? $order['dept_id'],
                'listtype' => 'floor'
            ])->row_array();
            
            // Get order comments for this suite (from suite_order_details if floor consolidated)
            $orderComment = '';
            if (!empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
                $commentResult = $this->tenantDb->query("
                    SELECT order_comment FROM suite_order_details 
                    WHERE suite_id = ? AND floor_order_id = ?
                    AND status = 'active'
                    LIMIT 1
                ", [$bedId, $orderId])->row();
                $orderComment = $commentResult->order_comment ?? '';
            }
            
            // Count items for this suite
            $itemCount = $this->tenantDb->query("
                SELECT SUM(quantity) as total 
                FROM orders_to_patient_options 
                WHERE order_id = ? AND bed_id = ?
            ", [$orderId, $bedId])->row();
            
            // Create suite snapshot (permanent patient data)
            $suiteSnapshot = [
                'order_snapshot_id' => $orderSnapshotId,
                'order_id' => $orderId,
                'suite_id' => $bedId,
                'suite_number' => $suiteDetails['bed_no'] ?? 'Unknown',
                'floor_name' => $suiteFloor['name'] ?? 'Unknown Floor',
                'patient_id' => $patient['id'] ?? null,
                'patient_name' => $patient['name'] ?? null,
                'patient_allergies' => $patient['allergies'] ?? null,
                'patient_special_instructions' => $patient['special_instructions'] ?? null,
                'patient_photo_path' => $patient['photo_path'] ?? null,
                'patient_onboarded_date' => $patient['date_onboarded'] ?? null,
                'order_comment' => $orderComment,
                'room_service_enabled' => 0, // Can be enhanced to detect room service
                'total_items' => $itemCount->total ?? 0,
                'created_at' => australia_datetime(),
                'status' => 'active'
            ];
            
                $this->tenantDb->insert('suite_order_snapshots', $suiteSnapshot);
                $suiteSnapshotId = $this->tenantDb->insert_id();
                
                if ($suiteSnapshotId) {
                    // Create menu item snapshots for this suite
                    try {
                        $this->createMenuItemSnapshots($suiteSnapshotId, $orderId, $bedId);
                    } catch (Exception $e) {
                        log_message('warning', "Snapshot: Menu item snapshot failed for suite $bedId - " . $e->getMessage());
                    }
                }
            } catch (Exception $e) {
                log_message('warning', "Snapshot: Suite snapshot failed for bed_id $bedId - " . $e->getMessage() . " - Continuing with other suites");
                continue;
            }
        }
    }
    
    /**
     * Create menu item snapshots with locked prices
     * 
     * @param int $suiteSnapshotId
     * @param int $orderId
     * @param int $bedId
     */
    private function createMenuItemSnapshots($suiteSnapshotId, $orderId, $bedId) {
        // ✅ DEBUG: Log what we're looking for
        log_message('info', "📸 Snapshot: Creating menu item snapshots - Suite Snapshot ID: $suiteSnapshotId, Order ID: $orderId, Bed ID: $bedId");
        
        // Get all menu items for this suite with complete details
        try {
            // ✅ DEBUG: First check if items exist in orders_to_patient_options
            $checkQuery = $this->tenantDb->query("
                SELECT COUNT(*) as count FROM orders_to_patient_options 
                WHERE order_id = ? AND bed_id = ?
            ", [$orderId, $bedId]);
            $checkCount = $checkQuery ? $checkQuery->row()->count : 0;
            log_message('info', "📸 Snapshot: Found $checkCount records in orders_to_patient_options for Order ID: $orderId, Bed ID: $bedId");
            
            if ($checkCount == 0) {
                log_message('warning', "📸 Snapshot: No records in orders_to_patient_options for Order ID: $orderId, Bed ID: $bedId - Cannot create menu item snapshots");
                return;
            }
            
            $itemsQuery = $this->tenantDb->query("
                SELECT 
                    opo.*,
                    md.name as menu_name,
                    md.description as menu_description,
                    md.inputType as menu_type,
                    mo.menu_option_name,
                    mo.prices as price,
                    mo.nutritionValues as calories,
                    mo.allergenValues,
                    -- ✅ CRITICAL: Use category_id from orders_to_patient_options (the actual category selected at order time)
                    -- Fallback to menu_to_category only if opo.category_id is NULL
                    COALESCE(opo.category_id, m2c.category_id, 0) as category_id,
                    COALESCE(
                        (SELECT fmc1.name FROM foodmenuconfig fmc1 WHERE fmc1.id = opo.category_id AND fmc1.listtype = 'category' LIMIT 1),
                        fmc.name,
                        'Uncategorized'
                    ) as category_name,
                    COALESCE(
                        (SELECT fmc1.sort_order FROM foodmenuconfig fmc1 WHERE fmc1.id = opo.category_id AND fmc1.listtype = 'category' LIMIT 1),
                        fmc.sort_order,
                        999
                    ) as category_sort_order,
                    mic.comment as item_comment
                FROM orders_to_patient_options opo
                LEFT JOIN menuDetails md ON md.id = opo.menu_id
                LEFT JOIN menu_options mo ON mo.id = opo.option_id
                LEFT JOIN menu_to_category m2c ON m2c.menu_id = opo.menu_id
                LEFT JOIN foodmenuconfig fmc ON fmc.id = m2c.category_id AND fmc.listtype = 'category'
                LEFT JOIN menu_item_comments mic ON mic.order_id = opo.order_id 
                    AND mic.bed_id = opo.bed_id 
                    AND mic.menu_id = opo.menu_id 
                    AND mic.option_id = opo.option_id
                WHERE opo.order_id = ? AND opo.bed_id = ?
                ORDER BY category_sort_order, menu_name, option_id
            ", [$orderId, $bedId]);
            
            if (!$itemsQuery) {
                $error = $this->tenantDb->error();
                log_message('error', "📸 Snapshot: Query failed for Suite ID: $bedId in Order ID: $orderId - " . print_r($error, true));
                return;
            }
            
            $itemCount = $itemsQuery->num_rows();
            log_message('info', "📸 Snapshot: Query returned $itemCount menu items for Suite ID: $bedId in Order ID: $orderId");
            
            if ($itemCount == 0) {
                log_message('warning', "📸 Snapshot: No menu items found in query result for Suite ID: $bedId in Order ID: $orderId");
                return;
            }
            
            $items = $itemsQuery->result_array();
        } catch (Exception $e) {
            log_message('error', "📸 Snapshot: Exception fetching menu items - " . $e->getMessage() . " at line " . $e->getLine());
            return;
        }
        
        $savedCount = 0;
        $failedCount = 0;
        foreach ($items as $item) {
            try {
                // Extract numeric calories from nutritionValues (e.g., "67 kcal" -> 67)
                $caloriesValue = 0;
                if (!empty($item['calories'])) {
                    // Extract first number from string (handles "67 kcal", "67", etc.)
                    if (preg_match('/\d+/', $item['calories'], $matches)) {
                        $caloriesValue = (int)$matches[0];
                    }
                }
                
                $menuSnapshot = [
                    'suite_order_snapshot_id' => $suiteSnapshotId,
                    'order_id' => $orderId,
                    'category_id' => $item['category_id'] ?? 0,
                    'category_name' => $item['category_name'] ?? 'Unknown Category',
                    'category_sort_order' => $item['category_sort_order'] ?? 999,
                    'menu_id' => $item['menu_id'],
                    'menu_name' => $item['menu_name'] ?? 'Unknown Menu',
                    'menu_description' => $item['menu_description'] ?? '',
                    'menu_type' => $item['menu_type'] ?? '',
                    'option_id' => $item['option_id'] ?? null,
                    'option_name' => $item['menu_option_name'] ?? '',
                    'option_price' => $item['price'] ?? 0.00,
                    'option_calories' => $caloriesValue,
                    'option_allergens' => $item['allergenValues'] ?? null,
                    'quantity' => $item['quantity'] ?? 1,
                    'item_comment' => $item['item_comment'] ?? '',
                    'is_completed' => $item['status'] ?? 0,
                    'completed_at' => null,
                    'created_at' => australia_datetime() // CRITICAL: Use Australia/Sydney timezone for snapshot timestamps
                ];
                
                $insertResult = $this->tenantDb->insert('menu_item_snapshots', $menuSnapshot);
                if ($insertResult) {
                    $savedCount++;
                } else {
                    $failedCount++;
                    $error = $this->tenantDb->error();
                    log_message('error', "📸 Snapshot: Failed to insert menu item - " . print_r($error, true) . " - Menu ID: " . ($item['menu_id'] ?? 'N/A') . ", Option ID: " . ($item['option_id'] ?? 'N/A'));
                }
            } catch (Exception $e) {
                $failedCount++;
                log_message('error', "📸 Snapshot: Exception inserting menu item - " . $e->getMessage() . " - Menu ID: " . ($item['menu_id'] ?? 'N/A'));
            }
        }
        
        log_message('info', "📸 Snapshot: Saved $savedCount menu items, Failed: $failedCount for Suite Snapshot ID: $suiteSnapshotId");
    }
    
    /**
     * Retrieve complete order snapshot by snapshot ID
     * 
     * @param int $orderSnapshotId
     * @return array|null Complete snapshot with suites and items
     */
    public function getOrderSnapshot($orderSnapshotId) {
        // Get order header
        $order = $this->tenantDb->get_where('order_snapshots', ['id' => $orderSnapshotId])->row_array();
        
        if (empty($order)) {
            return null;
        }
        
        // Get suites
        $order['suites'] = $this->tenantDb->get_where('suite_order_snapshots', [
            'order_snapshot_id' => $orderSnapshotId
        ])->result_array();
        
        // Get menu items for each suite
        foreach ($order['suites'] as &$suite) {
            $suite['items'] = $this->tenantDb->query("
                SELECT * FROM menu_item_snapshots
                WHERE suite_order_snapshot_id = ?
                ORDER BY category_sort_order, menu_name
            ", [$suite['id']])->result_array();
        }
        
        return $order;
    }
    
    /**
     * Get menu items for a specific suite snapshot
     * 
     * @param int $suiteSnapshotId
     * @return array Menu items
     */
    public function getMenuItemsForSuite($suiteSnapshotId) {
        return $this->tenantDb->query("
            SELECT * FROM menu_item_snapshots
            WHERE suite_order_snapshot_id = ?
            ORDER BY category_sort_order, menu_name
        ", [$suiteSnapshotId])->result_array();
    }
    
    /**
     * Get order snapshot by original order ID
     * Returns the LATEST snapshot if multiple exist (for viewing current state)
     * 
     * @param int $orderId
     * @return array|null
     */
    public function getOrderSnapshotByOrderId($orderId) {
        // ✅ FIX: Get LATEST snapshot if multiple exist (order by created_at DESC)
        $orderSnapshot = $this->tenantDb->select('id')
            ->from('order_snapshots')
            ->where('order_id', $orderId)
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->get()
            ->row_array();
        
        if (empty($orderSnapshot)) {
            return null;
        }
        
        return $this->getOrderSnapshot($orderSnapshot['id']);
    }
    
    /**
     * Check if snapshot exists for an order
     * 
     * @param int $orderId
     * @return bool
     */
    public function snapshotExists($orderId) {
        try {
            // ✅ CRITICAL: Get tenantDb (lazy load if needed) - sets $this->tenantDb
            if (!$this->getTenantDb()) {
                log_message('error', "Snapshot: tenantDb not available - Cannot check if snapshot exists for Order ID: $orderId");
                return false;
            }
            
            $count = $this->tenantDb->where('order_id', $orderId)
                                    ->count_all_results('order_snapshots');
            return $count > 0;
        } catch (Exception $e) {
            log_message('error', "Snapshot: Exception checking if snapshot exists - " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get all order snapshots with filters
     * 
     * @param string $fromDate Start date (Y-m-d)
     * @param string $toDate End date (Y-m-d)
     * @param int|null $floorId Optional floor filter
     * @return array List of snapshots with summary data
     */
    public function getAllSnapshots($fromDate = null, $toDate = null, $floorId = null) {
        try {
            // Check if tables exist
            if (!$this->tablesExist()) {
                return [];
            }
            
            $this->tenantDb->select('
                os.id as snapshot_id,
                os.order_id,
                os.order_date,
                os.floor_id,
                os.floor_name,
                os.created_by_user_name,
                os.workflow_status,
                os.total_suites,
                os.total_items,
                os.is_floor_consolidated,
                os.created_at,
                COUNT(DISTINCT sos.id) as actual_suite_count
            ');
            $this->tenantDb->from('order_snapshots os');
            $this->tenantDb->join('suite_order_snapshots sos', 'sos.order_snapshot_id = os.id', 'left');
            
            // Apply date filters
            if ($fromDate) {
                $this->tenantDb->where('os.order_date >=', $fromDate);
            }
            if ($toDate) {
                $this->tenantDb->where('os.order_date <=', $toDate);
            }
            
            // Apply floor filter
            if ($floorId) {
                $this->tenantDb->where('os.floor_id', $floorId);
            }
            
            $this->tenantDb->where('os.status', 1); // Only active snapshots
            $this->tenantDb->group_by('os.id');
            $this->tenantDb->order_by('os.created_at', 'DESC');
            
            $query = $this->tenantDb->get();
            
            if ($query && $query->num_rows() > 0) {
                return $query->result_array();
            }
            
            return [];
            
        } catch (Exception $e) {
            log_message('error', "Snapshot: Failed to fetch all snapshots - " . $e->getMessage());
            return [];
        }
    }
}

