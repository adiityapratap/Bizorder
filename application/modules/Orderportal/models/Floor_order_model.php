<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Floor_order_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
    }
    
    /**
     * Check if floor consolidation is enabled for a specific floor
     */
    public function isFloorConsolidationEnabled($floorId) {
        $this->tenantDb->select('is_consolidation_enabled');
        $this->tenantDb->from('floor_consolidation_config');
        $this->tenantDb->where('floor_id', $floorId);
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->is_consolidation_enabled == 1;
        }
        
        // Default to enabled if no configuration exists
        return true;
    }
    
    /**
     * Get or create floor order for a specific date and floor
     */
    public function getOrCreateFloorOrder($floorId, $orderDate, $userId) {
        // Check for existing floor order
        $existingOrder = $this->getFloorOrder($floorId, $orderDate);
        
        if ($existingOrder) {
            return $existingOrder['order_id'];
        }
        
        // Create new floor order
        return $this->createFloorOrder($floorId, $orderDate, $userId);
    }
    
    /**
     * Get existing floor order for a specific date and floor
     */
    public function getFloorOrder($floorId, $orderDate) {
        $this->tenantDb->select('order_id, workflow_status, total_suites, participating_suites');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('floor_id', $floorId);
        $this->tenantDb->where('date', $orderDate);
        $this->tenantDb->where('is_floor_consolidated', 1);
        $this->tenantDb->where('status', 1); // Active orders only
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }
    
    /**
     * Create a new floor order
     */
    public function createFloorOrder($floorId, $orderDate, $userId) {
        // 🔒 CRITICAL FIX: Check for existing order before creating (constraint protection)
        $existingOrder = $this->getFloorOrder($floorId, $orderDate);
        
        if ($existingOrder) {
            log_message('warning', "⚠️ [createFloorOrder] Floor order already exists ID={$existingOrder['order_id']} for floor={$floorId}, date={$orderDate}. Returning existing order.");
            return $existingOrder['order_id'];
        }
        
        // Get department settings
        $configData = $this->common_model->fetchRecordsDynamically('departmentSettings', ['daily_budget', 'daily_limit'], '');
        
        $orderData = [
            'date' => $orderDate,
            'status' => 1,
            'added_by' => $userId,
            'dept_id' => $floorId,
            'floor_id' => $floorId,
            'is_floor_consolidated' => 1,
            'total_suites' => 0,
            'participating_suites' => json_encode([]),
            'workflow_status' => 'floor_draft',
            'buttonType' => 'sendorder',  // CRITICAL FIX: All orders go directly to chef
            'budget' => isset($configData[0]['daily_budget']) ? $configData[0]['daily_budget'] : 0,
            'limits' => isset($configData[0]['daily_limit']) ? $configData[0]['daily_limit'] : 0
        ];
        
        // 🔒 CRITICAL FIX: Handle duplicate key errors (race condition protection)
        try {
            $orderId = $this->common_model->commonRecordCreate('orders', $orderData);
            
            if ($orderId) {
                // Log the order creation
                $this->logOrderStatusChange($orderId, null, 'floor_draft', 'Floor order created for Floor ' . $floorId);
                log_message('info', "✅ [createFloorOrder] Floor order created successfully: ID={$orderId}, Floor={$floorId}, Date={$orderDate}");
            }
            
            return $orderId;
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            
            // Check if it's a duplicate key error (Error 1062)
            if (strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'idx_unique_floor_date_active') !== false) {
                // Another process created the same order, get existing one
                log_message('warning', "⚠️ [createFloorOrder] Duplicate key detected, fetching existing order. Error: {$errorMsg}");
                
                $existingOrder = $this->getFloorOrder($floorId, $orderDate);
                if ($existingOrder) {
                    log_message('info', "✅ [createFloorOrder] Found existing order ID={$existingOrder['order_id']} after duplicate detection");
                    return $existingOrder['order_id'];
                } else {
                    log_message('error', "❌ [createFloorOrder] Duplicate key error but can't find existing order for floor={$floorId}, date={$orderDate}");
                    return false;
                }
            } else {
                // Different error, re-throw
                log_message('error', "❌ [createFloorOrder] Database error creating floor order: {$errorMsg}");
                throw $e;
            }
        }
    }
    
    /**
     * Add a suite to an existing floor order
     */
    public function addSuiteToFloorOrder($floorOrderId, $suiteId, $suiteNumber, $orderComment, $userId) {
        // Check if suite is already in this order
        $existing = $this->getSuiteOrderDetail($floorOrderId, $suiteId);
        if ($existing) {
            // Update existing suite order detail
            return $this->updateSuiteOrderDetail($existing['id'], $orderComment, $userId);
        }
        
        // ✅ PATIENT ID FIX: Get patient ID for this suite at order time
        // First get the order date from the floor order
        $floorOrder = $this->tenantDb->get_where('orders', ['order_id' => $floorOrderId])->row();
        $orderDate = $floorOrder ? $floorOrder->date : australia_date_only();
        
        // Get current patient for this suite on the order date
        $currentPatient = $this->tenantDb->query("
            SELECT id FROM people 
            WHERE suite_number = ? AND status = 1
            AND (date_of_discharge IS NULL OR date_of_discharge >= ?)
            ORDER BY date_onboarded DESC
            LIMIT 1
        ", [$suiteId, $orderDate])->row();
        
        // Create new suite order detail
        $suiteDetailData = [
            'floor_order_id' => $floorOrderId,
            'suite_id' => $suiteId,
            'suite_number' => $suiteNumber,
            'patient_id' => $currentPatient ? $currentPatient->id : null, // ✅ Store patient ID
            'order_comment' => $orderComment,
            'added_by' => $userId,
            'status' => 'active'
        ];
        
        $suiteDetailId = $this->common_model->commonRecordCreate('suite_order_details', $suiteDetailData);
        
        // REMOVED: Don't update suite counts here - it's too early (before menu items are added)
        // The count will be updated after menu items are added in Order.php
        
        return $suiteDetailId;
    }
    
    /**
     * Get suite order detail
     */
    public function getSuiteOrderDetail($floorOrderId, $suiteId) {
        $this->tenantDb->select('*');
        $this->tenantDb->from('suite_order_details');
        $this->tenantDb->where('floor_order_id', $floorOrderId);
        $this->tenantDb->where('suite_id', $suiteId);
        $this->tenantDb->where('status', 'active');
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }
    
    /**
     * ✅ CRITICAL FIX: Get suite order detail WITH ROW-LEVEL LOCK
     * This prevents race conditions when multiple users/tabs update same suite
     * 
     * @param int $floorOrderId The floor order ID
     * @param int $suiteId The suite ID
     * @return array|null Suite order detail or null if not found
     */
    public function getSuiteOrderDetailWithLock($floorOrderId, $suiteId) {
        // ✅ CRITICAL: Use FOR UPDATE to lock row and prevent concurrent modifications
        $query = $this->tenantDb->query("
            SELECT * FROM suite_order_details 
            WHERE floor_order_id = ? 
            AND suite_id = ? 
            AND status = 'active'
            FOR UPDATE
        ", [$floorOrderId, $suiteId]);
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }
    
    /**
     * Update suite order detail
     */
    public function updateSuiteOrderDetail($suiteDetailId, $orderComment, $userId) {
        $updateData = [
            'order_comment' => $orderComment,
            'added_by' => $userId
        ];
        
        $this->common_model->commonRecordUpdate('suite_order_details', 'id', $suiteDetailId, $updateData);
        return $suiteDetailId; // Return the ID to indicate success
    }
    
    /**
     * ✅ CRITICAL SAFETY: Prevent deletion of suite_order_details that have menu items
     * This prevents accidental data loss
     * 
     * @param int $suiteDetailId The suite order detail ID to check
     * @return bool True if safe to delete (no menu items), False if has menu items
     */
    public function canDeleteSuiteOrderDetail($suiteDetailId) {
        $menuItemCount = $this->tenantDb->where('suite_order_detail_id', $suiteDetailId)
            ->count_all_results('orders_to_patient_options');
        
        if ($menuItemCount > 0) {
            log_message('error', "Floor Order: BLOCKED deletion of suite_order_detail_id={$suiteDetailId} - Has {$menuItemCount} menu items. This would cause data loss!");
            return false;
        }
        
        return true;
    }
    
    /**
     * Update floor order's participating suites count and list
     * 
     * ✅ CRITICAL FIX: This function now handles orphaned menu items gracefully.
     * If suite_order_details records are missing but menu items exist, it will
     * count those suites too to prevent data loss.
     */
    public function updateFloorOrderSuites($floorOrderId) {
        // ✅ PERMANENT FIX: Validate order_id BEFORE processing
        if (empty($floorOrderId) || !is_numeric($floorOrderId) || $floorOrderId <= 0) {
            log_message('error', "🚨 CRITICAL: updateFloorOrderSuites called with INVALID order_id: " . var_export($floorOrderId, true) . ". BLOCKING update to prevent data loss!");
            return false;
        }
        
        // ✅ PERMANENT FIX: Verify order exists BEFORE updating
        $orderExists = $this->tenantDb->select('order_id, date, dept_id')
            ->from('orders')
            ->where('order_id', $floorOrderId)
            ->get()
            ->row();
        
        if (!$orderExists) {
            log_message('error', "🚨 CRITICAL: updateFloorOrderSuites called for NON-EXISTENT order_id={$floorOrderId}. BLOCKING update to prevent data loss!");
            return false;
        }
        
        log_message('info', "✅ SAFE: updateFloorOrderSuites called for VALID order_id={$floorOrderId}, date={$orderExists->date}, dept_id={$orderExists->dept_id}");
        
        // ✅ CRITICAL FIX: Include ALL suite_order_details, even if they have no menu items
        // This prevents suites from being excluded when menu items are missing
        // UNION query to get:
        // 1. All suite_order_details for this order (even if no menu items)
        // 2. All suites with menu items (even if no suite_order_details - orphaned)
        // ✅ CRITICAL FIX: Filter out NULL/empty suite_id values at database level to prevent JSON corruption
        $query = "
            SELECT DISTINCT 
                sd.suite_id,
                COALESCE(sd.suite_number, '') as suite_number
            FROM suite_order_details sd
            WHERE sd.floor_order_id = ? 
            AND sd.status = 'active'
            AND sd.suite_id IS NOT NULL 
            AND sd.suite_id > 0
            
            UNION
            
            SELECT DISTINCT 
                opo.bed_id as suite_id,
                COALESCE(sd.suite_number, '') as suite_number
            FROM orders_to_patient_options opo
            LEFT JOIN suite_order_details sd ON opo.suite_order_detail_id = sd.id AND sd.status = 'active'
            WHERE opo.order_id = ? 
            AND (sd.id IS NULL OR opo.suite_order_detail_id IS NULL OR opo.suite_order_detail_id = 0)
            AND opo.bed_id IS NOT NULL 
            AND opo.bed_id > 0
            AND (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL)
        ";
        $result = $this->tenantDb->query($query, [$floorOrderId, $floorOrderId]);
        
        $suites = $result->result_array();
        $suiteIds = array_column($suites, 'suite_id');
        
        // ✅ CRITICAL FIX: Filter out NULL, empty, and non-numeric suite IDs to prevent JSON corruption
        // This prevents corrupted JSON like ["9","5",,,,,] when suite_id values are NULL/empty
        $suiteIds = array_filter($suiteIds, function($id) {
            return !empty($id) && is_numeric($id) && $id > 0;
        });
        
        // ✅ CRITICAL FIX: Convert all values to integers to ensure consistent JSON encoding
        // This prevents string/number mixing issues: ["1","3"] vs [1,3]
        $suiteIds = array_map('intval', $suiteIds);
        
        // ✅ CRITICAL FIX: Remove duplicates and sort for consistency
        $suiteIds = array_unique($suiteIds);
        sort($suiteIds, SORT_NUMERIC);
        
        // Re-index array to ensure sequential keys (removes gaps from filtered values)
        $suiteIds = array_values($suiteIds);
        
        // ✅ FINAL SAFETY CHECK: Verify all values are still valid integers after processing
        foreach ($suiteIds as $id) {
            if (!is_int($id) || $id <= 0) {
                log_message('error', "🚨 CRITICAL: Invalid suite ID detected after filtering: " . var_export($id, true) . " for order_id={$floorOrderId}. BLOCKING update!");
                return false;
            }
        }
        
        // ✅ CRITICAL LOGGING: Log which suites are included
        log_message('info', "Floor Order: updateFloorOrderSuites for order_id={$floorOrderId} - Found " . count($suiteIds) . " valid suite(s): " . implode(', ', $suiteIds));
        
        // ✅ CRITICAL SAFETY: Log warning if orphaned menu items detected
        $orphanedCount = 0;
        $orphanedSuites = [];
        foreach ($suites as $suite) {
            if (empty($suite['suite_number']) || !isset($suite['suite_number'])) {
                $orphanedCount++;
                $orphanedSuites[] = $suite['suite_id'];
                log_message('warning', "Floor Order: Orphaned menu items detected for floor_order_id={$floorOrderId}, suite_id={$suite['suite_id']}. Suite_order_details record may be missing!");
            }
        }
        
        if ($orphanedCount > 0) {
            log_message('error', "Floor Order: CRITICAL - {$orphanedCount} suite(s) have menu items but missing suite_order_details records for floor_order_id={$floorOrderId}. Affected suites: " . json_encode($orphanedSuites) . ". This indicates data loss!");
            
            // ✅ AUTO-RECOVERY: Attempt to recreate missing suite_order_details records
            // This helps recover from accidental deletions
            foreach ($orphanedSuites as $suiteId) {
                $suiteDetailId = $this->recreateMissingSuiteOrderDetail($floorOrderId, $suiteId);
                
                // ✅ CRITICAL FIX: Link orphaned menu items IMMEDIATELY after recreating suite_order_details
                // This ensures menu items are properly linked so trigger can protect them
                if ($suiteDetailId) {
                    $linkedCount = $this->tenantDb->where('order_id', $floorOrderId)
                        ->where('bed_id', $suiteId)
                        ->where('(suite_order_detail_id IS NULL OR suite_order_detail_id = 0)', null, false)
                        ->update('orders_to_patient_options', ['suite_order_detail_id' => $suiteDetailId]);
                    
                    if ($linkedCount > 0) {
                        log_message('info', "Floor Order: AUTO-RECOVERY - Linked {$linkedCount} orphaned menu items to suite_order_detail_id={$suiteDetailId} for floor_order_id={$floorOrderId}, suite_id={$suiteId}");
                    }
                }
            }
        }
        
        // ✅ CRITICAL FIX: Use filtered suiteIds count, not original suites count
        // This ensures total_suites matches the actual valid suite IDs in participating_suites
        $updateData = [
            'total_suites' => count($suiteIds),
            'participating_suites' => json_encode($suiteIds, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ];
        
        // ✅ CRITICAL VALIDATION: Verify JSON encoding succeeded
        $encodedJson = $updateData['participating_suites'];
        $decodedCheck = json_decode($encodedJson, true);
        if ($decodedCheck === null && json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', "🚨 CRITICAL: JSON encoding FAILED for order_id={$floorOrderId}! JSON Error: " . json_last_error_msg() . ", Suite IDs: " . print_r($suiteIds, true));
            return false;
        }
        
        // ✅ CRITICAL VALIDATION: Verify decoded JSON matches original suite IDs
        if ($decodedCheck !== $suiteIds) {
            log_message('error', "🚨 CRITICAL: JSON encoding mismatch for order_id={$floorOrderId}! Original: " . print_r($suiteIds, true) . ", Decoded: " . print_r($decodedCheck, true));
            return false;
        }
        
        // ✅ PERMANENT FIX: Double-check order_id before updating
        // This prevents updating wrong order if $floorOrderId was corrupted
        $result = $this->common_model->commonRecordUpdate('orders', 'order_id', $floorOrderId, $updateData);
        
        // ✅ PERMANENT FIX: Verify update affected correct order
        $updatedOrder = $this->tenantDb->select('order_id, date, dept_id, participating_suites')
            ->from('orders')
            ->where('order_id', $floorOrderId)
            ->get()
            ->row();
        
        if ($updatedOrder) {
            log_message('info', "✅ VERIFIED: updateFloorOrderSuites successfully updated order_id={$floorOrderId}, date={$updatedOrder->date}, participating_suites=" . substr($updatedOrder->participating_suites, 0, 100));
        } else {
            log_message('error', "🚨 CRITICAL: updateFloorOrderSuites updated order_id={$floorOrderId} but verification query returned NULL! Possible data corruption!");
        }
        
        return $result;
    }
    
    /**
     * ✅ AUTO-RECOVERY: Recreate missing suite_order_details record for orphaned menu items
     * This helps recover from accidental deletions
     * 
     * @param int $floorOrderId The floor order ID
     * @param int $suiteId The suite ID
     * @return int|false The suite_order_detail_id if created, false on failure
     */
    private function recreateMissingSuiteOrderDetail($floorOrderId, $suiteId) {
        // Check if suite_order_details already exists
        $existing = $this->getSuiteOrderDetail($floorOrderId, $suiteId);
        if ($existing) {
            return $existing['id']; // Already exists, return it
        }
        
        // Get order date
        $floorOrder = $this->tenantDb->get_where('orders', ['order_id' => $floorOrderId])->row();
        if (!$floorOrder) {
            log_message('error', "Floor Order: Cannot recreate suite_order_detail - Order {$floorOrderId} not found");
            return false;
        }
        
        $orderDate = $floorOrder->date;
        
        // Get suite number
        $suite = $this->tenantDb->get_where('suites', ['id' => $suiteId])->row();
        $suiteNumber = $suite ? $suite->bed_no : "Suite-{$suiteId}";
        
        // Get patient ID
        $currentPatient = $this->tenantDb->query("
            SELECT id FROM people 
            WHERE suite_number = ? AND status = 1
            AND (date_of_discharge IS NULL OR date_of_discharge >= ?)
            ORDER BY date_onboarded DESC
            LIMIT 1
        ", [$suiteId, $orderDate])->row();
        
        // Get user ID from menu items (use added_by from order if available)
        $menuItem = $this->tenantDb->select('order_id')
            ->from('orders_to_patient_options')
            ->where('order_id', $floorOrderId)
            ->where('bed_id', $suiteId)
            ->limit(1)
            ->get()
            ->row();
        
        $orderInfo = $this->tenantDb->get_where('orders', ['order_id' => $floorOrderId])->row();
        $userId = $orderInfo ? $orderInfo->added_by : 14; // Default to 14 if not found
        
        // Create suite_order_details record
        $suiteDetailData = [
            'floor_order_id' => $floorOrderId,
            'suite_id' => $suiteId,
            'patient_id' => $currentPatient ? $currentPatient->id : null,
            'suite_number' => $suiteNumber,
            'order_comment' => '',
            'added_by' => $userId,
            'status' => 'active'
        ];
        
        $suiteDetailId = $this->common_model->commonRecordCreate('suite_order_details', $suiteDetailData);
        
        if ($suiteDetailId) {
            // Update menu items to link to the new suite_order_detail_id
            $this->tenantDb->where('order_id', $floorOrderId)
                ->where('bed_id', $suiteId)
                ->where('suite_order_detail_id IS NULL OR suite_order_detail_id = 0', null, false)
                ->update('orders_to_patient_options', ['suite_order_detail_id' => $suiteDetailId]);
            
            log_message('info', "Floor Order: AUTO-RECOVERY - Recreated suite_order_details record ID={$suiteDetailId} for floor_order_id={$floorOrderId}, suite_id={$suiteId}");
        } else {
            log_message('error', "Floor Order: AUTO-RECOVERY FAILED - Could not recreate suite_order_details for floor_order_id={$floorOrderId}, suite_id={$suiteId}");
        }
        
        return $suiteDetailId;
    }
    
    /**
     * Add menu items to a suite within a floor order
     */
    public function addMenuItemsToSuite($floorOrderId, $suiteDetailId, $menuItems) {
        // ✅ CRITICAL VALIDATION: Ensure suiteDetailId is valid
        if (empty($suiteDetailId) || !is_numeric($suiteDetailId) || $suiteDetailId <= 0) {
            log_message('error', "Floor Order: Invalid suiteDetailId={$suiteDetailId} - Cannot add menu items! floor_order_id={$floorOrderId}");
            return false;
        }
        
        // ✅ CRITICAL VALIDATION: Verify suite_order_details exists AND belongs to correct order
        $suiteDetail = $this->tenantDb->get_where('suite_order_details', [
            'id' => $suiteDetailId,
            'floor_order_id' => $floorOrderId  // ✅ CRITICAL: Verify it's for THIS order!
        ])->row();
        if (!$suiteDetail) {
            log_message('error', "Floor Order: suite_order_details ID={$suiteDetailId} not found or doesn't belong to order {$floorOrderId} - Cannot add menu items!");
            return false;
        }
        
        // ✅ PATIENT ID FIX: Get patient_id from suite_order_details
        $patientId = $suiteDetail->patient_id;
        
        $bulkOptionsData = [];
        
        foreach ($menuItems as $item) {
            $bulkOptionsData[] = [
                'order_id' => $floorOrderId,
                'suite_order_detail_id' => $suiteDetailId,
                'bed_id' => $item['bed_id'], // Keep for backward compatibility
                'patient_id' => $patientId, // ✅ Store patient ID
                'category_id' => $item['category_id'] ?? null,
                'menu_id' => $item['menu_id'],
                'option_id' => $item['option_id'],
                'quantity' => $item['quantity'] ?? 1
            ];
        }
        
        if (!empty($bulkOptionsData)) {
            return $this->common_model->commonBulkRecordCreate('orders_to_patient_options', $bulkOptionsData);
        }
        
        return true;
    }
    
    /**
     * Remove existing menu items for a suite
     * 
     * @param int $floorOrderId The floor order ID
     * @param int $suiteId The suite ID (bed_id)
     * @param int|null $suiteDetailId Optional: If provided, use this instead of querying
     * @return bool
     */
    public function removeExistingMenuItems($floorOrderId, $suiteId, $suiteDetailId = null) {
        // ✅ CRITICAL FIX: Use provided suiteDetailId if available (more reliable)
        // This prevents race conditions where getSuiteOrderDetail might not find the just-created suite
        if ($suiteDetailId !== null) {
            $suiteDetailIdToUse = $suiteDetailId;
        } else {
            // Fallback: Get suite detail ID from database
            $suiteDetail = $this->getSuiteOrderDetail($floorOrderId, $suiteId);
            if (!$suiteDetail) {
                log_message('error', "🚨 BLOCKED: Cannot remove menu items - Suite detail not found for floor_order_id={$floorOrderId}, suite_id={$suiteId}. This prevents data loss!");
                return false;
            }
            $suiteDetailIdToUse = $suiteDetail['id'];
        }
        
        // ✅ CRITICAL SAFETY: Validate suiteDetailId is not NULL/empty
        if (empty($suiteDetailIdToUse) || !is_numeric($suiteDetailIdToUse) || $suiteDetailIdToUse <= 0) {
            log_message('error', "🚨 BLOCKED: Invalid suite_detail_id={$suiteDetailIdToUse} for floor_order_id={$floorOrderId}, suite_id={$suiteId}. Aborting deletion to prevent data loss.");
            return false;
        }
        
        // ✅ CRITICAL FIX: Verify suite_order_details record still exists BEFORE deleting menu items
        // This prevents deletion if suite_order_details was deleted (which would allow trigger to pass)
        $suiteDetailExists = $this->tenantDb->where('id', $suiteDetailIdToUse)
            ->where('floor_order_id', $floorOrderId)
            ->where('status', 'active')
            ->count_all_results('suite_order_details');
            
        if (!$suiteDetailExists) {
            log_message('error', "🚨 BLOCKED: Cannot delete menu items - suite_order_detail_id={$suiteDetailIdToUse} doesn't exist or is not active for floor_order_id={$floorOrderId}, suite_id={$suiteId}. This prevents orphaned deletions!");
            return false;
        }
        
        // ✅ CRITICAL DEBUG: Log what's being deleted
        $beforeCount = $this->tenantDb->where('order_id', $floorOrderId)
            ->where('suite_order_detail_id', $suiteDetailIdToUse)
            ->count_all_results('orders_to_patient_options');
        log_message('info', "Floor Order: About to delete {$beforeCount} items for floor_order_id={$floorOrderId}, suite_id={$suiteId}, suite_order_detail_id={$suiteDetailIdToUse}");
        
        // ✅ CRITICAL FIX: Delete by BOTH suite_order_detail_id AND bed_id
        // This catches items with WRONG suite_order_detail_id (from different orders)
        // We delete by bed_id to ensure ALL items for this suite are removed, even if they have wrong suite_order_detail_id
        $conditions = [
            'order_id' => $floorOrderId,
            'bed_id' => $suiteId  // ✅ CRITICAL: Delete by bed_id to catch wrong links!
        ];
        
        // Also check for items with the correct suite_order_detail_id (for logging)
        $correctLinkCount = $this->tenantDb->where('order_id', $floorOrderId)
            ->where('suite_order_detail_id', $suiteDetailIdToUse)
            ->count_all_results('orders_to_patient_options');
        
        // Check for items with WRONG suite_order_detail_id (different order!)
        $wrongLinkCount = $this->tenantDb->where('order_id', $floorOrderId)
            ->where('bed_id', $suiteId)
            ->where('suite_order_detail_id !=', $suiteDetailIdToUse)
            ->where('suite_order_detail_id IS NOT NULL', null, false)
            ->where('suite_order_detail_id !=', 0)
            ->count_all_results('orders_to_patient_options');
        
        if ($wrongLinkCount > 0) {
            log_message('error', "Floor Order: CRITICAL - Found {$wrongLinkCount} items with WRONG suite_order_detail_id for floor_order_id={$floorOrderId}, suite_id={$suiteId}! These will be deleted.");
        }
        
        $result = $this->common_model->commonRecordDeleteMultipleConditions('orders_to_patient_options', $conditions);
        
        // ✅ CRITICAL DEBUG: Verify deletion was suite-specific
        $afterCount = $this->tenantDb->where('order_id', $floorOrderId)
            ->where('suite_order_detail_id', $suiteDetailIdToUse)
            ->count_all_results('orders_to_patient_options');
        
        // Check if other suites still have items (safety check)
        $allSuitesAfter = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
            ->from('orders_to_patient_options')
            ->where('order_id', $floorOrderId)
            ->group_by('bed_id')
            ->get()
            ->result_array();
        log_message('info', "Floor Order: AFTER deletion - floor_order_id={$floorOrderId} has items for suites: " . json_encode($allSuitesAfter));
        
        if ($afterCount > 0) {
            log_message('warning', "Floor Order: Deletion incomplete. {$afterCount} items still exist for suite_order_detail_id={$suiteDetailIdToUse}");
        }
        
        return $result;
    }
    
    /**
     * Get floor order summary with suite details
     */
    public function getFloorOrderSummary($floorOrderId) {
        // Get main order details
        $this->tenantDb->select('*');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('order_id', $floorOrderId);
        $orderQuery = $this->tenantDb->get();
        
        if ($orderQuery->num_rows() == 0) {
            return null;
        }
        
        $orderData = $orderQuery->row_array();
        
        // Get suite details
        $this->tenantDb->select('sod.*, s.bed_no');
        $this->tenantDb->from('suite_order_details sod');
        $this->tenantDb->join('suites s', 's.id = sod.suite_id', 'left');
        $this->tenantDb->where('sod.floor_order_id', $floorOrderId);
        $this->tenantDb->where('sod.status', 'active');
        $this->tenantDb->order_by('s.bed_no', 'ASC');
        $suitesQuery = $this->tenantDb->get();
        
        $orderData['suites'] = $suitesQuery->result_array();
        
        // Get menu items count (excluding cancelled items)
        $this->tenantDb->select('COUNT(*) as total_items');
        $this->tenantDb->from('orders_to_patient_options');
        $this->tenantDb->where('order_id', $floorOrderId);
        $this->tenantDb->group_start();
        $this->tenantDb->where('is_cancelled', 0);
        $this->tenantDb->or_where('is_cancelled IS NULL');
        $this->tenantDb->group_end();
        $itemsQuery = $this->tenantDb->get();
        $orderData['total_menu_items'] = $itemsQuery->row()->total_items;
        
        return $orderData;
    }
    
    /**
     * Update floor order workflow status
     */
    public function updateFloorOrderStatus($floorOrderId, $newStatus, $userId, $comments = '') {
        // Get current status
        $this->tenantDb->select('workflow_status');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('order_id', $floorOrderId);
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() == 0) {
            return false;
        }
        
        $currentStatus = $query->row()->workflow_status;
        
        // Update order status
        $updateData = ['workflow_status' => $newStatus];
        $result = $this->common_model->commonRecordUpdate('orders', 'order_id', $floorOrderId, $updateData);
        
        if ($result) {
            // Log status change
            $this->logOrderStatusChange($floorOrderId, $currentStatus, $newStatus, $comments, $userId);
        }
        
        return $result;
    }
    
    /**
     * Log order workflow status changes
     */
    public function logOrderStatusChange($orderId, $fromStatus, $toStatus, $comments = '', $userId = null) {
        $logData = [
            'order_id' => $orderId,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'changed_by' => $userId ?: $this->session->userdata('user_id'),
            'comments' => $comments
        ];
        
        return $this->common_model->commonRecordCreate('order_workflow_history', $logData);
    }
    
    /**
     * Check if user can modify floor order based on workflow status and role
     */
    public function canModifyFloorOrder($floorOrderId, $userRole) {
        // Get the specific floor order
        $this->tenantDb->select('workflow_status');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('order_id', $floorOrderId);
        $query = $this->tenantDb->get();
        
        if ($query->num_rows() == 0) {
            // If no order exists yet, allow creation for reception and patients
            return in_array($userRole, [1, 2, 3, 4, 6]); // All roles can create new orders
        }
        
        $status = $query->row()->workflow_status ?? 'floor_draft';
        
        switch ($userRole) {
            case 6: // Reception
            case 4: // Patient
                // Allow reception and patients to modify orders in more states
                return in_array($status, ['floor_draft', 'patient_draft', 'floor_submitted', 'nurse_approved']);
                
            case 3: // Nurse
                return in_array($status, ['floor_draft', 'patient_draft', 'floor_submitted', 'nurse_reviewing', 'nurse_approved']);
                
            case 1: // Admin
            case 2: // Chef
                return true; // Admin and Chef can always modify
                
            default:
                return false;
        }
    }
    
    /**
     * Get workflow status options based on current status and user role
     */
    public function getAvailableStatusTransitions($currentStatus, $userRole) {
        $transitions = [
            'floor_draft' => [
                6 => ['floor_submitted'], // Reception can submit
                4 => ['floor_submitted'], // Patient can submit
                3 => ['nurse_approved'], // Nurse can approve directly
                1 => ['floor_submitted', 'nurse_approved', 'chef_preparing'] // Admin can do anything
            ],
            'floor_submitted' => [
                3 => ['nurse_approved', 'nurse_reviewing'], // Nurse can approve or review
                1 => ['nurse_approved', 'chef_preparing'] // Admin can do anything
            ],
            'nurse_reviewing' => [
                3 => ['nurse_approved'], // Nurse can approve
                1 => ['nurse_approved', 'chef_preparing'] // Admin can do anything
            ],
            'nurse_approved' => [
                6 => ['nurse_approved'], // Reception can keep adding suites (no status change needed)
                4 => ['nurse_approved'], // Patient can keep adding suites (no status change needed)
                3 => ['nurse_approved'], // Nurse can keep adding suites (no status change needed)
                2 => ['chef_preparing', 'chef_completed'], // Chef can start/complete
                1 => ['chef_preparing', 'chef_completed', 'delivered'] // Admin can do anything
            ],
            'chef_preparing' => [
                2 => ['chef_completed'], // Chef can complete
                1 => ['chef_completed', 'delivered'] // Admin can do anything
            ],
            'chef_completed' => [
                2 => ['delivered'], // Chef can mark as delivered
                3 => ['delivered'], // Nurse can mark as delivered
                1 => ['delivered'] // Admin can mark as delivered
            ]
        ];
        
        return $transitions[$currentStatus][$userRole] ?? [];
    }
    
    /**
     * Check if all categories in floor order are packaged and update order status
     * @param int $order_id The floor order ID
     * @return bool True if order is fully packaged, false otherwise
     */
    public function checkAndUpdateFloorOrderStatus($order_id) {
        $CI = &get_instance();
        
        // Get all categories that should be in this floor order using direct query
        // SOFT DELETE: Exclude cancelled items from category calculation
        $categorySql = "SELECT DISTINCT m2c.category_id 
                        FROM orders_to_patient_options opo 
                        LEFT JOIN menu_to_category m2c ON m2c.menu_id = opo.menu_id 
                        WHERE opo.order_id = ?
                        AND (opo.is_cancelled = 0 OR opo.is_cancelled IS NULL)";
        $categoryQuery = $CI->tenantDb->query($categorySql, [$order_id]);
        $orderCategories = $categoryQuery->result_array();
        
        if (empty($orderCategories)) {
            return false;
        }
        
        // Check how many categories are marked as packaged
        $packagedCategories = $CI->common_model->fetchRecordsDynamically(
            'order_to_category_packagestatus',
            ['category_id'],
            ['order_id' => $order_id, 'status' => 1]
        );
        
        // If all categories are packaged, mark order as delivered (status 4)
        if (count($packagedCategories) >= count($orderCategories)) {
            // Update order status to delivered (status 4)
            $updateData = [
                'status' => 4,
                'workflow_status' => 'delivered',
                'delivered_date' => australia_datetime(),
                'is_delivered' => 1
            ];
            $CI->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $updateData);
            
            // Log the status change
            $this->logOrderStatusChange(
                $order_id, 
                null, 
                'delivered', 
                'All categories packaged - floor order delivered', 
                $CI->session->userdata('user_id')
            );
            
            // NOTIFICATION: Floor Order Delivered
            $userName = $CI->session->userdata('username') ?: 'System';
            $msg = "🎉 Floor Order Delivered: Order #{$order_id} has been fully packaged and delivered by {$userName}.";
            
            // Check if createNotification function exists
            if (function_exists('createNotification') && isset($CI->tenantDb) && isset($CI->selected_location_id)) {
                createNotification($CI->tenantDb, 1, $CI->selected_location_id, 'success', $msg);
            }
            
            return true;
        }
        
        return false;
    }
}
?>
