<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use Mpdf\Mpdf;

class Order extends MY_Controller
{
    public function __construct() 
    {   
      	parent::__construct();
   	     $this->load->model('configfoodmenu_model');
   	     $this->load->model('common_model');
   	      $this->load->model('order_model');
   	      $this->load->model('menu_model');
   	      $this->load->model('floor_order_model'); // Load the new floor order model
   	      $this->load->helper('custom'); // Load custom helper for Australia timezone functions
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->selected_location_id = $this->session->userdata('default_location_id');
        
    }
    
    /**
     * Get current date in Australia/Sydney timezone (YYYY-MM-DD format)
     * CRITICAL: Use this for all date operations to prevent timezone mismatches
     */
    private function getAustraliaDate($dateString = null) {
        $timezone = new DateTimeZone('Australia/Sydney');
        if ($dateString) {
            $date = DateTime::createFromFormat('Y-m-d', $dateString, $timezone);
            if ($date === false) {
                // Try alternative parsing
                $date = new DateTime($dateString, $timezone);
            }
        } else {
            $date = new DateTime('now', $timezone);
        }
        return $date->format('Y-m-d');
    }
    
    /**
     * Get tomorrow's date in Australia/Sydney timezone (YYYY-MM-DD format)
     */
    private function getAustraliaTomorrow() {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        $date->modify('+1 day');
        return $date->format('Y-m-d');
    }
    
    /**
     * Get datetime with offset in Australia/Sydney timezone (Y-m-d H:i:s format)
     * CRITICAL: Use this for date calculations with time offsets
     */
    private function getAustraliaDateTimeOffset($modify = '+0 minutes') {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        $date->modify($modify);
        return $date->format('Y-m-d H:i:s');
    }
    
    /**
     * Get date with offset in Australia/Sydney timezone (Y-m-d format)
     * @param int $days Number of days offset (0 = today, 1 = tomorrow, -1 = yesterday)
     * @return string Date in Y-m-d format
     */
    private function getAustraliaDateOffset($days = 0) {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        if ($days != 0) {
            $date->modify($days > 0 ? "+{$days} days" : "{$days} days");
        }
        return $date->format('Y-m-d');
    }
    
     public function verifyNursePin() {
        // Get PIN from POST data
        $pin = $this->input->post('pin', TRUE);
        $userEmail = $this->session->userdata('useremail');
        
        // Initialize response array
        $response = array('success' => false, 'message' => 'Invalid PIN');
        
        // Validate inputs
        if (empty($pin) || empty($userEmail)) {
            $response['message'] = 'Missing PIN or user email';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        // Check if PIN is a 4-digit number
        if (!preg_match('/^\d{4}$/', $pin)) {
            $response['message'] = 'PIN must be a 4-digit number';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        // Query conditions
        $conditions = array(
            'email' => $userEmail,
            'pin' => $pin
        );

        // Fetch records from Global_users table
        $userVerify = $this->common_model->fetchRecordsDynamically('Global_users', '', $conditions);

        // Check if record exists
        if (!empty($userVerify)) {
            $response['success'] = true;
            $response['message'] = 'PIN verified successfully';
        }

        // Return JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    /**
     * Verify if PIN belongs to ANY nurse in the system
     * Used for Nurse Override feature to bypass cutoff time
     */
    public function verifyAnyNursePin() {
        // Get PIN from POST data
        $pin = $this->input->post('pin', TRUE);
        
        // Initialize response array
        $response = array('success' => false, 'message' => 'Invalid PIN');
        
        // Validate PIN
        if (empty($pin)) {
            $response['message'] = 'PIN is required';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        // Check if PIN is a 4-digit number
        if (!preg_match('/^\d{4}$/', $pin)) {
            $response['message'] = 'PIN must be a 4-digit number';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }

        // Query: Find ANY user with nurse role (role_id = 3) and matching PIN
        // Note: role_id is stored directly in Global_users table
        try {
            // Find nurses with matching PIN in tenant database
            $query = $this->tenantDb->query(
                "SELECT id, first_name, last_name 
                 FROM Global_users 
                 WHERE pin = ? 
                 AND role_id = 3
                 AND active = 1
                 LIMIT 1",
                array($pin)
            );
            
            $nurse = $query->row_array();

            // Check if a nurse with this PIN exists
            if (!empty($nurse)) {
                $response['success'] = true;
                $response['message'] = 'Nurse PIN verified successfully';
                $response['nurse_name'] = trim($nurse['first_name'] . ' ' . $nurse['last_name']);
            }
        } catch (Exception $e) {
            log_message('error', 'Nurse Override: Database error - ' . $e->getMessage());
            $response['message'] = 'Database error occurred. Please try again.';
        }

        // Return JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function checkExistingOrder() {
        $bed_id = $this->input->post('bed_id');
        
        if (!$bed_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Bed ID required']));
            return;
        }

        $floorId = $this->session->userdata('department_id');
        // CRITICAL FIX: Accept orderDate or order_date from POST (both formats supported), default to tomorrow if not provided
        // Use Australia/Sydney timezone for date operations
        $orderDate = $this->input->post('orderDate') ?: $this->input->post('order_date');
        if (!$orderDate) {
            $orderDate = $this->getAustraliaTomorrow();
            log_message('warning', "ORDER CHECK EXISTING: No orderDate in POST, defaulting to tomorrow: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        } else {
            // Ensure date is in correct format (YYYY-MM-DD)
            $orderDate = $this->getAustraliaDate($orderDate);
            log_message('info', "ORDER CHECK EXISTING: Received orderDate from POST: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        }
        
        // Check if floor consolidation is enabled
        $isFloorConsolidationEnabled = $this->floor_order_model->isFloorConsolidationEnabled($floorId);
        
        if ($isFloorConsolidationEnabled) {
            // Check for floor consolidated orders
            $floorOrderConditions = [
                'date' => $orderDate,
                'floor_id' => $floorId,
                'is_floor_consolidated' => 1
            ];
            
            $floorOrder = $this->common_model->fetchRecordsDynamically('orders', ['order_id'], $floorOrderConditions);
            
            if (!empty($floorOrder)) {
                $floorOrderId = $floorOrder[0]['order_id'];
                
                // Check if this specific suite has orders in the floor order
                $suiteDetailConditions = [
                    'floor_order_id' => $floorOrderId,
                    'suite_id' => $bed_id,
                    'status' => 'active'
                ];
                
                $suiteDetail = $this->common_model->fetchRecordsDynamically('suite_order_details', ['id'], $suiteDetailConditions);
                
                if (!empty($suiteDetail)) {
                    // Check if suite has menu options
                    $suiteOrderConditions = [
                        'order_id' => $floorOrderId,
                        'suite_order_detail_id' => $suiteDetail[0]['id']
                    ];
                    
                    $bedOrders = $this->common_model->fetchRecordsDynamically('orders_to_patient_options', ['option_id'], $suiteOrderConditions);
                    
                    $response = [
                        'success' => true,
                        'has_existing_order' => !empty($bedOrders),
                        'order_count' => count($bedOrders),
                        'message' => !empty($bedOrders) ? 'Order already exists for this suite for tomorrow' : 'No existing order found'
                    ];
                } else {
                    $response = [
                        'success' => true,
                        'has_existing_order' => false,
                        'order_count' => 0,
                        'message' => 'No existing order found'
                    ];
                }
            } else {
                $response = [
                    'success' => true,
                    'has_existing_order' => false,
                    'order_count' => 0,
                    'message' => 'No existing order found'
                ];
            }
        } else {
            // Legacy suite-specific order check
            $conditions = [
                'date' => $orderDate,
                'dept_id' => $floorId,
                'bed_id' => $bed_id
            ];
            
            $existingOrder = $this->common_model->fetchRecordsDynamically('orders', ['order_id'], $conditions);
            
            if (!empty($existingOrder)) {
                $order_id = $existingOrder[0]['order_id'];
                
                // Check if this specific bed has orders in the options table
                $bedOrderConditions = [
                    'order_id' => $order_id,
                    'bed_id' => $bed_id
                ];
                
                $bedOrders = $this->common_model->fetchRecordsDynamically('orders_to_patient_options', ['option_id'], $bedOrderConditions);
                
                $response = [
                    'success' => true,
                    'has_existing_order' => !empty($bedOrders),
                    'order_count' => count($bedOrders),
                    'message' => !empty($bedOrders) ? 'Order already exists for this suite for tomorrow' : 'No existing order found'
                ];
            } else {
                $response = [
                    'success' => true,
                    'has_existing_order' => false,
                    'order_count' => 0,
                    'message' => 'No existing order found'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function checkUpdatePermission() {
        $bed_id = $this->input->post('bed_id');
        
        if (!$bed_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Bed ID required']));
            return;
        }

        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $currentDate = $this->getAustraliaDate();
        // CRITICAL FIX: Accept orderDate from POST (from date picker), default to tomorrow if not provided
        $orderDate = $this->input->post('orderDate') ?: $this->input->post('order_date');
        if (!$orderDate) {
            $orderDate = $this->getAustraliaTomorrow();
            log_message('warning', "ORDER CHECK UPDATE PERMISSION: No orderDate in POST, defaulting to tomorrow: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        } else {
            // Ensure date is in correct format (YYYY-MM-DD)
            $orderDate = $this->getAustraliaDate($orderDate);
            log_message('info', "ORDER CHECK UPDATE PERMISSION: Received orderDate from POST: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        }
        
        // FIXED: Check for existing orders for this specific bed
        $conditions = [
            'date' => $orderDate,
            'dept_id' => $this->session->userdata('department_id'),
            'bed_id' => $bed_id  // Make it bed-specific
        ];
        
        $existingOrder = $this->common_model->fetchRecordsDynamically('orders', ['workflow_status', 'date'], $conditions);
        
        $canUpdate = true;
        $message = 'You can update this order';
        $reason = '';
        
        if (!empty($existingOrder)) {
            $workflowStatus = $existingOrder[0]['workflow_status'] ?? 'patient_draft';
            
            // FIXED: Allow reception users to access different suites
            // Only block if trying to update the SAME suite that was already sent by nurse
            if ($userRole == 4 || $userRole == 6) { // Patient or Reception
                // Reception can always place orders for different suites
                // Only block if this specific suite's order was sent by nurse AND it's the same day
                if ($workflowStatus == 'nurse_sent' && $currentDate >= $orderDate) {
                    $canUpdate = false;
                    $message = 'Order has been sent to chef and delivery date has passed. Cannot update.';
                    $reason = 'nurse_sent';
                }
                // Allow updates if it's still before the delivery date
            } elseif ($userRole == 3) { // Nurse
                if ($workflowStatus == 'nurse_sent' && $currentDate >= $orderDate) {
                    $canUpdate = false;
                    $message = 'Order has been sent to chef and date has passed. Cannot update.';
                    $reason = 'date_passed';
                }
            }
        }
        
        $response = [
            'success' => true,
            'can_update' => $canUpdate,
            'message' => $message,
            'reason' => $reason,
            'workflow_status' => $existingOrder[0]['workflow_status'] ?? 'none',
            'user_role' => $userRole
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

     public function verifyPin() {
    $bed_id = $this->input->post('bed_id');
    $pin = $this->input->post('pin');
    $bypass_reception = $this->input->post('bypass_reception');
    
    // Validate input
    if (empty($bed_id) || empty($pin)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        return;
    }
    
    // Check if this is a reception user bypass request
    $userRole = $this->ion_auth->get_users_groups()->row()->id;
    if ($bypass_reception && ($userRole == 6 || $userRole == 4)) { // Reception or Patient role
        // Allow reception and patient users to bypass PIN verification
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'PIN verification bypassed for reception/patient user'
        ]);
        return;
    }
    
    // Get suite PIN from database
    $conditions = ['id' => $bed_id, 'is_deleted' => 0];
    $suite = $this->common_model->fetchRecordsDynamically('suites', '', $conditions);
    
    if (empty($suite)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Suite not found']);
        return;
    }
    
    $suite_pin = $suite[0]['suite_pin'];
    
    // Verify PIN matches
    $is_valid = ($pin === $suite_pin);
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $is_valid,
        'message' => $is_valid ? 'PIN verified successfully' : 'Invalid PIN'
    ]);
}

    
    
    function commonData($deptId, $orderId = null){
        
        $result = array();

        $menuLists    = $this->menu_model->fetchMenuDetails('',true);
  
        $conditions = array('is_deleted' => 0,'floor'=>$deptId);
        $allSuites = $this->common_model->fetchRecordsDynamically('suites','',$conditions);
        
        // Keep all suites - we handle empty bed_no in the view now
        $bedLists = $allSuites;
        
        // Add patient information to each suite
        if (!empty($bedLists)) {
            foreach ($bedLists as &$suite) {
                $activePatient = null;
                $skipCurrentPatientFallback = false; // Initialize flag
                
                // ✅ PATIENT ID FIX: If orderId is provided, get patient from order's patient_id
                // This ensures we show the ORIGINAL patient who was in the suite when the order was placed
                // even if the patient has since been transferred to another suite
                if (!empty($orderId)) {
                    // First check if this suite has any orders with patient_id
                    $hasOrderWithPatient = $this->tenantDb->query("
                        SELECT COUNT(*) as count
                        FROM orders_to_patient_options opo
                        WHERE opo.order_id = ? AND opo.bed_id = ? AND opo.patient_id IS NOT NULL
                        LIMIT 1
                    ", [$orderId, $suite['id']])->row();
                    
                    // Only get patient from order if patient_id exists (not NULL)
                    // If patient_id is NULL, it means no patient was there when order was placed
                    if ($hasOrderWithPatient && $hasOrderWithPatient->count > 0) {
                        $orderPatient = $this->tenantDb->query("
                            SELECT DISTINCT p.name, p.allergies, p.dietary_preferences, p.special_instructions, 
                                   p.date_onboarded, p.date_of_discharge, p.photo_path
                            FROM orders_to_patient_options opo
                            INNER JOIN people p ON p.id = opo.patient_id
                            WHERE opo.order_id = ? AND opo.bed_id = ? AND opo.patient_id IS NOT NULL
                            LIMIT 1
                        ", [$orderId, $suite['id']])->row_array();
                        
                        if ($orderPatient) {
                            $activePatient = $orderPatient;
                            // ✅ CRITICAL: Don't fall back to current patient if order has patient_id
                            // This ensures transferred patients don't show up in old orders
                            $skipCurrentPatientFallback = true;
                        }
                    }
                }
                
                // Fallback: Get current patient ONLY if no order OR order has NULL patient_id
                // This means no patient was there when order was placed
                if (empty($activePatient) && empty($skipCurrentPatientFallback)) {
                    $patientConditions = [
                        'suite_number' => $suite['id'],
                        'status' => 1 // Active patients only
                    ];
                    $patients = $this->common_model->fetchRecordsDynamically('people', ['name', 'allergies', 'dietary_preferences', 'special_instructions', 'date_onboarded', 'date_of_discharge', 'photo_path'], $patientConditions);
                    
                    // Filter out patients with past discharge dates
                    // CRITICAL FIX: Use Australia/Sydney timezone for date operations
                    $today = $this->getAustraliaDate();
                    if (!empty($patients)) {
                        foreach ($patients as $patient) {
                            $discharge_date = $patient['date_of_discharge'];
                            // Keep patients active if discharge date is today or in the future
                            if (empty($discharge_date) || $discharge_date >= $today) {
                                $activePatient = $patient;
                                break;
                            }
                        }
                    }
                }
                
                // Add patient info to suite data
                $suite['patient_name'] = $activePatient ? $activePatient['name'] : null;
                $suite['patient_allergies'] = $activePatient ? $activePatient['allergies'] : null;
                $suite['patient_dietary_preferences'] = $activePatient ? ($activePatient['dietary_preferences'] ?? null) : null;
                $suite['patient_instructions'] = $activePatient ? $activePatient['special_instructions'] : null;
                $suite['patient_onboarded'] = $activePatient ? $activePatient['date_onboarded'] : null;
                $suite['patient_discharge'] = $activePatient ? $activePatient['date_of_discharge'] : null;
                $suite['patient_photo_path'] = $activePatient ? $activePatient['photo_path'] : null;
            }
        }
        
        $conditionsC = array('is_deleted' => 0 ,'listtype' => 'category');
        $categoryListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditionsC);
        
        $result['categoryListData'] = $categoryListData;
        $result['bedLists'] = $bedLists;
        $result['menuLists'] = $menuLists;
        
        return $result;
        
    }
    // place order from patient portal - ENHANCED WITH FLOOR CONSOLIDATION
    
    function placeOrder(){
        // Check cutoff time (10:30 AM) for next day orders (reception/patient users only)
        if (!$this->isWithinOrderCutoffTime()) {
            $this->session->set_flashdata('error', 'Order cutoff time has passed. Orders for tomorrow must be placed before 10:30 AM today.');
            redirect('Orderportal/Home/index');
            return;
        }

        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        // Validate required POST data
        if (!isset($_POST['selectedBed']) || empty($_POST['selectedBed'])) {
            log_message('error', "ORDER PLACE FAILED: Suite selection validation failed. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error', 'Suite selection is required.');
            redirect('Orderportal/Home/index');
            return;
        }

        $bedId = $_POST['selectedBed'];
        $floorId = $this->session->userdata('department_id');
        $userId = $this->session->userdata('user_id');
        $username = $this->session->userdata('username') ?: 'UNKNOWN';
        
        // NEW: Accept orderDate from POST (from Nurse Dashboard date picker), default to tomorrow
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $orderDate = $this->input->post('orderDate');
        $postOrderDate = $orderDate; // Keep for logging
        
        // Log what we received
        log_message('info', "ORDER PLACE INITIATED: Bed ID={$bedId}, Floor ID={$floorId}, Order Date from POST=" . ($orderDate ?: 'NOT SET') . ", User={$username}, User ID={$userId}, IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        if (!$orderDate) {
            $orderDate = $this->getAustraliaTomorrow();
            log_message('warning', "ORDER PLACE: No orderDate in POST, defaulting to tomorrow: {$orderDate}. User={$username} at " . australia_datetime());
        } else {
            // Ensure date is in correct format (YYYY-MM-DD)
            $orderDate = $this->getAustraliaDate($orderDate);
            log_message('info', "ORDER PLACE: Received orderDate from POST: {$orderDate}. User={$username} at " . australia_datetime());
        }
        
        // Validate date range (today to +7 days) for Nurse Dashboard - use Australia/Sydney timezone
        $orderDateTime = strtotime($orderDate);
        $todayAustralia = $this->getAustraliaDate();
        $today = strtotime($todayAustralia);
        $maxDate = strtotime('+7 days', $today);
        
        if ($orderDateTime < $today || $orderDateTime > $maxDate) {
            log_message('error', "ORDER PLACE FAILED: Invalid order date: {$orderDate} (must be between today and +7 days). User={$username}, User ID={$userId}, IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error', 'Invalid order date. Please select a date between today and next 7 days.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // Check if floor consolidation is enabled
        $isFloorConsolidationEnabled = $this->floor_order_model->isFloorConsolidationEnabled($floorId);
        
        if ($isFloorConsolidationEnabled) {
            return $this->placeFloorConsolidatedOrder($bedId, $floorId, $userId, $orderDate);
        } else {
            return $this->placeLegacySuiteOrder($bedId, $orderDate);
        }
    }
    
    /**
     * Place order using the new floor consolidation system
     */
    private function placeFloorConsolidatedOrder($bedId, $floorId, $userId, $orderDate) {
        // Validate that the bed exists and belongs to the current department
        $bedConditions = [
            'id' => $bedId,
            'floor' => $floorId,
            'is_deleted' => 0
        ];
        $bedExists = $this->common_model->fetchRecordsDynamically('suites', ['id', 'bed_no'], $bedConditions);
        
        if (empty($bedExists)) {
            $this->session->set_flashdata('error', 'Invalid suite selection.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        $suiteNumber = $bedExists[0]['bed_no'];
        
        // CRITICAL CHECK: Prevent modifying delivered/paid orders (but allow new orders if cancelled)
        // Query ALL orders for this floor+date, regardless of status (don't use getFloorOrder which filters by status=1)
        $this->tenantDb->select('order_id, workflow_status, status, is_delivered, created_at');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('floor_id', $floorId);
        $this->tenantDb->where('date', $orderDate);
        $this->tenantDb->where('is_floor_consolidated', 1);
        $this->tenantDb->order_by('created_at', 'DESC'); // Get most recent first
        $existingOrderQuery = $this->tenantDb->get();
        
        // CRITICAL FIX: Check for duplicate floor orders
        if ($existingOrderQuery->num_rows() > 1) {
            log_message('error', "ORDER PLACE CRITICAL ERROR: Found {$existingOrderQuery->num_rows()} floor orders for floor_id={$floorId}, date={$orderDate}. This should not happen! User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            
            // Get all orders
            $allOrders = $existingOrderQuery->result_array();
            $activeOrders = array_filter($allOrders, function($order) {
                return $order['status'] != 0; // Not cancelled
            });
            
            if (count($activeOrders) > 1) {
                log_message('error', "CRITICAL: Multiple ACTIVE floor orders exist for same floor+date. Order IDs: " . implode(', ', array_column($activeOrders, 'order_id')));
                // Use the most recent active order
                $existingOrder = $activeOrders[0];
            } else if (count($activeOrders) == 1) {
                $existingOrder = $activeOrders[0];
            } else {
                // All orders cancelled, create new
                $floorOrderId = $this->floor_order_model->createFloorOrder($floorId, $orderDate, $userId);
            }
        } else if ($existingOrderQuery->num_rows() == 1) {
            $existingOrder = $existingOrderQuery->row_array();
        } else {
            // No existing order, create new
            $floorOrderId = $this->floor_order_model->createFloorOrder($floorId, $orderDate, $userId);
        }
        
        if (isset($existingOrder)) {
            $currentStatus = $existingOrder['workflow_status'] ?? '';
            $numericStatus = $existingOrder['status'] ?? 1;
            $isDelivered = $existingOrder['is_delivered'] ?? 0;
            
            // Block if delivered (workflow or numeric status or flag) or paid (status=2) - FINAL STATES
            if ($currentStatus === 'delivered' || $numericStatus == 4 || $isDelivered == 1 || $numericStatus == 2) {
                $statusMessage = ($numericStatus == 2) ? 'has been paid and is final' : 'has already been delivered';
                $this->session->set_flashdata('error', 'Cannot modify order. The order for this floor on ' . format_australia_date($orderDate, 'd/m/Y') . ' ' . $statusMessage . '.');
                redirect('Orderportal/Home/index');
                return;
            }
            
            // If cancelled (status=0 or workflow), create new order
            if ($currentStatus === 'cancelled' || $numericStatus == 0) {
                $floorOrderId = $this->floor_order_model->createFloorOrder($floorId, $orderDate, $userId);
            } else {
                // For all other statuses, use existing order (update)
                $floorOrderId = $existingOrder['order_id'];
            }
        }
        
        if (!$floorOrderId) {
            $this->session->set_flashdata('error', 'Failed to create floor order.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // Check user permissions
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        if (!$this->floor_order_model->canModifyFloorOrder($floorOrderId, $userRole)) {
            $this->session->set_flashdata('error', 'You do not have permission to modify this order.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // CRITICAL FIX: Force buttonType to 'sendorder' - ALL orders go directly to chef
        $originalButtonType = $_POST['buttonType'] ?? 'NOT SET';
        $_POST['buttonType'] = 'sendorder';
        log_message('info', "ORDER PLACE: Button type forced to 'sendorder' (was: {$originalButtonType}). Floor Order ID={$floorOrderId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        
        // Process the suite order
        unset($_POST['selectedBed']);
        $orderComment = isset($_POST['notes']) ? $_POST['notes'] : '';
        
        // ✅ CRITICAL FIX: Wrap entire operation in transaction to prevent race conditions
        // This ensures atomicity - either ALL operations succeed or ALL fail
        $this->tenantDb->trans_start();
        
        try {
            // ✅ CRITICAL FIX: Get suite order detail WITH LOCK to prevent concurrent modifications
            // This prevents race conditions when same user has multiple tabs open
            $existingSuiteDetail = $this->floor_order_model->getSuiteOrderDetailWithLock($floorOrderId, $bedId);
            
            if ($existingSuiteDetail) {
                // Suite already exists - use existing ID
                $suiteDetailId = $existingSuiteDetail['id'];
                
                // Update suite order detail comment if changed
                if ($existingSuiteDetail['order_comment'] != $orderComment) {
                    $this->floor_order_model->updateSuiteOrderDetail($suiteDetailId, $orderComment, $userId);
                }
            } else {
                // Suite doesn't exist - create new one
                $suiteDetailId = $this->floor_order_model->addSuiteToFloorOrder(
                    $floorOrderId, 
                    $bedId, 
                    $suiteNumber, 
                    $orderComment, 
                    $userId
                );
                
                if (!$suiteDetailId) {
                    throw new Exception("Failed to add suite to floor order");
                }
            }
            
            // Remove existing menu items for this suite
            // ✅ CRITICAL FIX: Pass suiteDetailId directly to prevent race conditions
            // Using the ID returned from addSuiteToFloorOrder is more reliable than querying again
            $this->floor_order_model->removeExistingMenuItems($floorOrderId, $bedId, $suiteDetailId);
            
            // Process menu items
            $menuItems = [];
            
            foreach ($_POST as $key => $value) {
                if (strpos($key, '_') !== false && !in_array($key, ['buttonType', 'notes'])) {
                    $keyParts = explode('_', $key);
                    
                    // Handle different key formats
                    if (count($keyParts) === 2 && is_numeric($keyParts[0]) && is_numeric($keyParts[1])) {
                        // Format: category_menu (e.g., "70_29")
                        $category_id = $keyParts[0];
                        $menu_id = $keyParts[1];
                    } elseif (count($keyParts) === 3 && is_numeric($keyParts[0])) {
                        // Format: bed_category_menu (e.g., "201_70_29")
                        $category_id = $keyParts[1];
                        $menu_id = $keyParts[2];
                    } else {
                        continue;
                    }
                    
                    if (!empty($value)) {
                        if (is_array($value)) {
                            foreach ($value as $option_id) {
                                $menuItems[] = [
                                    'bed_id' => $bedId,
                                    'category_id' => $category_id,
                                    'menu_id' => $menu_id,
                                    'option_id' => $option_id,
                                    'quantity' => 1
                                ];
                            }
                        } else {
                            // Handle single values (radio buttons)
                            $menuItems[] = [
                                'bed_id' => $bedId,
                                'category_id' => $category_id,
                                'menu_id' => $menu_id,
                                'option_id' => $value,
                                'quantity' => 1
                            ];
                        }
                    }
                }
            }
            
            // Add menu items to the suite
            if (!empty($menuItems)) {
                $addResult = $this->floor_order_model->addMenuItemsToSuite($floorOrderId, $suiteDetailId, $menuItems);
                
                if (!$addResult) {
                    throw new Exception("Failed to add menu items to suite");
                }
                
                // LATE ORDER TRACKING: Update suite_order_details.modified_at timestamp
                // This ensures any menu item changes after cutoff time are tracked as late orders
                $this->tenantDb->set('modified_at', 'NOW()', FALSE);
                $this->tenantDb->where('id', $suiteDetailId);
                $this->tenantDb->update('suite_order_details');
            }
            
            // CRITICAL: Update participating suites count AFTER menu items are added
            // This ensures the count only includes suites with actual menu items
            $this->floor_order_model->updateFloorOrderSuites($floorOrderId);
            
            // ✅ CRITICAL FIX: Complete transaction - commit all changes
            $this->tenantDb->trans_complete();
            
            // Check if transaction was successful
            if ($this->tenantDb->trans_status() === FALSE) {
                throw new Exception("Transaction failed - database error occurred");
            }
            
        } catch (Exception $e) {
            // ✅ CRITICAL FIX: Rollback transaction on any error
            $this->tenantDb->trans_rollback();
            log_message('error', "ORDER PLACE TRANSACTION FAILED: Floor Order ID={$floorOrderId}, Suite={$suiteNumber}, Error: " . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error', 'Failed to save order: ' . $e->getMessage() . '. Please try again.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // Update workflow status based on button type and user role
        // buttonType is already forced to 'sendorder' earlier in the function
        $buttonType = $_POST['buttonType'];
        
        $newStatus = $this->determineWorkflowStatus($buttonType, $userRole);
        
        // Only update status if it's different from current status
        if ($newStatus) {
            // Get current floor order status
            $currentFloorOrder = $this->floor_order_model->getFloorOrder($floorId, $orderDate);
            $currentStatus = $currentFloorOrder['workflow_status'] ?? 'floor_draft';
            
            // Only update if status is different or if it's a new order
            if ($newStatus !== $currentStatus) {
                $this->floor_order_model->updateFloorOrderStatus(
                    $floorOrderId, 
                    $newStatus, 
                    $userId, 
                    "Order {$buttonType} for Suite {$suiteNumber}"
                );
            }
        }
        
        // Send notifications
        $this->sendFloorOrderNotifications($floorOrderId, $buttonType, $suiteNumber, $userRole);
        
        // EMAIL NOTIFICATION: Send email to chef about the order
        if ($buttonType === 'sendorder') {
            // Get floor name
            $floorName = fetchDepartmentNameFromId($this->tenantDb, $floorId);
            $orderDateFormatted = format_australia_date($orderDate, 'd-m-Y');
            
            // Collect order items
            $orderItemsData = [];
            $menuLists = $this->menu_model->fetchMenuDetails('', true);
            $conditionsAllergen = ['listtype' => 'allergen'];
            $allergensData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsAllergen);
            
            foreach ($menuItems as $item) {
                $category_id = $item['category_id'];
                $menu_id = $item['menu_id'];
                $option_id = $item['option_id'];
                
                // Get category name
                $categoryData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['name'], ['id' => $category_id]);
                $categoryName = !empty($categoryData) ? $categoryData[0]['name'] : 'Unknown Category';
                
                if (!isset($orderItemsData[$categoryName])) {
                    $orderItemsData[$categoryName] = [];
                }
                
                // Find menu details
                foreach($menuLists as $menu) {
                    if ($menu['menu_id'] == $menu_id) {
                        foreach($menu['menu_options'] as $option) {
                            if ($option['option_id'] == $option_id) {
                                // Get allergens
                                $allergenNames = [];
                                if (!empty($option['allergenValues'])) {
                                    $allergenIds = json_decode($option['allergenValues'], true);
                                    if (is_array($allergenIds) && !empty($allergenIds)) {
                                        foreach ($allergenIds as $allergenId) {
                                            foreach ($allergensData as $allergen) {
                                                if ($allergen['id'] == $allergenId) {
                                                    $allergenNames[] = $allergen['name'];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                $orderItemsData[$categoryName][] = [
                                    'name' => $menu['menu_name'],
                                    'options' => $option['menu_option_name'],
                                    'allergens' => implode(', ', $allergenNames),
                                    'comment' => ''
                                ];
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            
            // For floor consolidation, always treat as new order (simplification)
            // Since floor orders are continuously updated throughout the day
            $isUpdate = false;
            
            // Send email ONLY for late orders (after 10:32 AM AND for today's orders)
            if ($this->shouldSendLateOrderNotification($orderDateFormatted)) {
                log_message('info', "EMAIL NOTIFICATION TRIGGERED: Sending late order email notification for Floor Order ID={$floorOrderId}, Suite={$suiteNumber}, Order Date={$orderDateFormatted}, Timestamp=" . australia_datetime());
                $this->sendOrderNotificationEmail(
                    $floorOrderId,
                    $floorName,
                    $suiteNumber,
                    $orderDateFormatted,
                    $isUpdate,
                    $orderItemsData
                );
            } else {
                log_message('info', "EMAIL NOTIFICATION SKIPPED: Not a late order (before 10:32 AM or not for today). Floor Order ID={$floorOrderId}, Suite={$suiteNumber}, Order Date={$orderDateFormatted}, Timestamp=" . australia_datetime());
            }
        }
        
        // ✅ HISTORICAL SNAPSHOT: Create or update immutable snapshot of order data
        // This ensures order history remains accurate even if menus, patients, or suites change
        if ($buttonType === 'sendorder' || $buttonType === 'update') {
            try {
                $this->load->model('Snapshot_model');
                // Update snapshot if order exists, create new if not
                $snapshotId = $this->Snapshot_model->updateOrderSnapshot($floorOrderId);
                if ($snapshotId) {
                    log_message('info', "ORDER SNAPSHOT CREATED: Snapshot ID={$snapshotId}, Floor Order ID={$floorOrderId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } else {
                    log_message('warning', "ORDER SNAPSHOT FAILED: Failed to create/update order snapshot for Floor Order ID={$floorOrderId}. Order still succeeded. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            } catch (Exception $e) {
                // Snapshot failure should not break the order flow
                log_message('error', "ORDER SNAPSHOT EXCEPTION: Floor Order ID={$floorOrderId}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
            }
        }
        
        // Set success message
        $action = ($buttonType === 'sendorder') ? 'submitted' : 'saved';
        $this->session->set_flashdata('success_msg', "Order {$action} successfully for Suite {$suiteNumber}");
        
        redirect('Orderportal/Home/index');
    }
    
    /**
     * Determine workflow status based on button type and user role
     */
    private function determineWorkflowStatus($buttonType, $userRole) {
        if ($buttonType === 'sendorder') {
            switch ($userRole) {
                case 4: // Patient
                case 6: // Reception
                    return 'floor_submitted';
                case 3: // Nurse
                    return 'nurse_approved';
                default:
                    return 'floor_submitted';
            }
        }
        
        // For 'save' button, keep current status or set to draft
        return null; // Don't change status for save
    }
    
    /**
     * Send notifications for floor order actions
     * SIMPLIFIED: Only send for new orders (sendorder button)
     */
    private function sendFloorOrderNotifications($floorOrderId, $buttonType, $suiteNumber, $userRole) {
        // Only send notification for new orders (sendorder), not for saves
        if ($buttonType === 'sendorder') {
            // Get order date for this floor order
            $floorOrder = $this->tenantDb->get_where('orders', ['order_id' => $floorOrderId])->row();
            $orderDate = $floorOrder ? $floorOrder->date : australia_date_only();
            $orderDateFormatted = format_australia_date($orderDate, 'd-m-Y');
            $currentDate = australia_date_only();
            $currentDateFormatted = format_australia_date($currentDate, 'd-m-Y');
            $currentTime = australia_date('H:i'); // Get current time in 24-hour format
            
            // SIMPLIFIED: New Order notification (for order date, on placement date/time)
            $msg = "New Order: Suite {$suiteNumber} - new order placed for suite {$suiteNumber} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
        }
        // No notification for save (draft) - only final orders
    }
    
    /**
     * Legacy suite order method for backward compatibility
     */
    private function placeLegacySuiteOrder($bedId, $orderDate = null) {
        // ═══════════════════════════════════════════════════════════════════════
        // COMPREHENSIVE ORDER LOGGING - START
        // ═══════════════════════════════════════════════════════════════════════
        $userId = $this->session->userdata('user_id');
        $username = $this->session->userdata('username') ?: 'Unknown';
        $deptId = $this->session->userdata('department_id');
        $buttonType = $_POST['buttonType'] ?? 'unknown';
        $ipAddress = $this->input->ip_address();
        
        log_message('info', "═══════════════════════════════════════════════════════════════");
        log_message('info', "📦 LEGACY SUITE ORDER - START");
        log_message('info', "   Function: placeLegacySuiteOrder()");
        log_message('info', "   Timestamp: " . australia_datetime());
        log_message('info', "   Suite/Bed ID: {$bedId}");
        log_message('info', "   Order Date: " . ($orderDate ?: 'NULL (will default to tomorrow)'));
        log_message('info', "   Floor/Dept ID: {$deptId}");
        log_message('info', "   User ID: {$userId}");
        log_message('info', "   Username: {$username}");
        log_message('info', "   Button Type: {$buttonType}");
        log_message('info', "   IP Address: {$ipAddress}");
        log_message('info', "═══════════════════════════════════════════════════════════════");
        
        // NEW: Default to tomorrow if no date provided - use Australia/Sydney timezone
        if (!$orderDate) {
            $orderDate = $this->getAustraliaTomorrow();
            log_message('warning', "ORDER PLACE LEGACY: No order date provided, defaulting to tomorrow: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        } else {
            // Ensure date is in correct format (YYYY-MM-DD)
            $orderDate = $this->getAustraliaDate($orderDate);
        }
        
        // Validate that the bed exists and belongs to the current department
        $bedConditions = [
            'id' => $bedId,
            'floor' => $this->session->userdata('department_id'),
            'is_deleted' => 0
        ];
        $bedExists = $this->common_model->fetchRecordsDynamically('suites', ['id', 'bed_no'], $bedConditions);
        
        if (empty($bedExists)) {
            log_message('error', "ORDER PLACE LEGACY FAILED: Invalid suite selection. Bed ID={$bedId}, Floor={$deptId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error', 'Invalid suite selection.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        $suiteNumber = $bedExists[0]['bed_no'] ?? 'Unknown';
        log_message('info', "ORDER PLACE LEGACY: Suite validated. Suite Number={$suiteNumber}, Suite ID={$bedId}, Order Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());

        $configData = $this->common_model->fetchRecordsDynamically('departmentSettings',['daily_budget','daily_limit'],'');

        $orderData['date'] = $orderDate; // Use the dynamic order date
        $orderData['status'] =  1;
        $orderData['added_by'] =  $this->session->userdata('user_id');
        $orderData['dept_id'] =  $this->session->userdata('department_id') ?? 0;
        $orderData['budget'] =  (isset($configData[0]['daily_budget']) ? $configData[0]['daily_budget'] : 0);
        $orderData['limits'] =  (isset($configData[0]['daily_limit']) ? $configData[0]['daily_limit'] : 0);
        
        // Set order workflow status based on user role
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        if ($userRole == 4) { // Patient
            $orderData['workflow_status'] = 'patient_draft'; // Patient can update
        } elseif ($userRole == 6) { // Reception
            $orderData['workflow_status'] = 'patient_draft'; // Same as patient for reception
        } elseif ($userRole == 3) { // Nurse
            $orderData['workflow_status'] = 'nurse_sent'; // Nurse sent to chef
        }
        
        // CRITICAL FIX: Force buttonType to 'sendorder' - ALL orders go directly to chef
        $_POST['buttonType'] = 'sendorder';
        
        unset($_POST['selectedBed']); // remove from the array
        $orderArray = [ $bedId => $_POST ];
        
        // Add bed_id to order data for suite-specific tracking
        $orderData['bed_id'] = $bedId;
        // buttonType is already forced to 'sendorder' earlier in the function
        $orderData['buttonType'] = $_POST['buttonType'];

         // FIXED: Check for existing order for this specific bed and date
         $conditions = [
             'date' => $orderDate, // Use dynamic order date
             'dept_id' => $this->session->userdata('department_id'),
             'bed_id' => $bedId  // Make orders bed-specific
         ];
         
         $existingOrderData = $this->common_model->fetchRecordsDynamically('orders',['order_id','buttonType','workflow_status','status','is_delivered'],$conditions);
         
         // 🔧 FIX: Also check for FLOOR-LEVEL orders (is_floor_consolidated=1, bed_id=NULL)
         // These are the main orders that should be updated when nurses/reception add suites
         if(empty($existingOrderData)) {
             $floorOrderConditions = [
                 'date' => $orderDate,
                 'dept_id' => $this->session->userdata('department_id'),
                 'is_floor_consolidated' => 1,
                 'bed_id' => null  // Floor orders have NULL bed_id
             ];
             $floorOrderData = $this->common_model->fetchRecordsDynamically('orders',['order_id','buttonType','workflow_status','status','is_delivered','is_floor_consolidated'],$floorOrderConditions);
             
             if(!empty($floorOrderData)) {
                 // Found existing FLOOR order - this should be updated, not create duplicate
                 $existingOrderData = $floorOrderData;
                 log_message('info', "ORDER PLACE LEGACY: Found existing floor order ID={$floorOrderData[0]['order_id']} for date={$orderDate}, floor={$this->session->userdata('department_id')}. Will UPDATE this order. Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
             } else {
                 // 🔧 FIX: Check for any active order for this date+floor (duplicate prevention)
                 $duplicateCheck = [
                     'date' => $orderDate,
                     'dept_id' => $this->session->userdata('department_id'),
                 ];
                 $this->tenantDb->where($duplicateCheck);
                 $this->tenantDb->where('workflow_status !=', 'cancelled');
                 $this->tenantDb->where('workflow_status !=', 'cancelled_duplicate');
                 $this->tenantDb->where('workflow_status !=', 'deleted');
                 $this->tenantDb->where('status !=', 0); // Not cancelled
                 $anyExistingOrder = $this->tenantDb->get('orders')->result_array();
                 
                 if(!empty($anyExistingOrder)) {
                     // There's an active order but not found by normal check - should UPDATE it
                     $existingOrderData = $anyExistingOrder;
                     log_message('warning', "ORDER PLACE LEGACY: Found existing order via duplicate check. Order ID={$anyExistingOrder[0]['order_id']}, Date={$orderDate}, Floor={$this->session->userdata('department_id')}, Suite={$suiteNumber}. Will UPDATE to prevent duplicate. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                 }
             }
         }
         
         // CRITICAL CHECK: Prevent modifying delivered/paid orders (but allow new order if cancelled)
         if(isset($existingOrderData) && !empty($existingOrderData)){
             $existingStatus = $existingOrderData[0]['status'] ?? 1;
             $existingWorkflowStatus = $existingOrderData[0]['workflow_status'] ?? '';
             $isDelivered = $existingOrderData[0]['is_delivered'] ?? 0;
             
             // Block if delivered (status=4 or is_delivered=1) or paid (status=2) - FINAL STATES
             if ($existingStatus == 4 || $isDelivered == 1 || $existingStatus == 2 || $existingWorkflowStatus === 'delivered') {
                $statusMessage = ($existingStatus == 2) ? 'has been paid and is final' : 'has already been delivered';
                $this->session->set_flashdata('error', 'Cannot modify order. The order for Suite ' . $bedExists[0]['bed_no'] . ' on ' . format_australia_date($orderDate, 'd/m/Y') . ' ' . $statusMessage . '.');
                 redirect('Orderportal/Home/index');
                 return;
             }
             
             // If cancelled (status=0), ignore it and proceed to create new order
             if ($existingStatus == 0 || $existingWorkflowStatus === 'cancelled') {
                 // Clear existingOrderData so a new order will be created below
                 $existingOrderData = [];
             }
         }
         
         if(isset($existingOrderData) && !empty($existingOrderData)){
             
            $orderUpdateData['updated_by'] = $this->session->userdata('user_id');
            // buttonType is already forced to 'sendorder' earlier in the function
            $orderUpdateData['buttonType'] = $_POST['buttonType'];
            // Use the date from date picker (POST) - this is what the user selected
            // The existing order lookup already found the order for this date, so we update it with the same date
            $order_id = reset($existingOrderData)['order_id'];
            $orderUpdateData['date'] = $orderDate; // Same date as lookup (should never change)
            
            // NOTE: Date should never change in normal flow - lookup finds order for the selected date
            log_message('info', "ORDER PLACE LEGACY UPDATE: Updating order ID={$order_id} for date={$orderDate}, Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            
           $successMessage = 'Order Updated Successfully for Suite ' . $bedExists[0]['bed_no'];
           
           // ✅ CRITICAL DEBUG: Log what exists BEFORE deletion
           $allSuitesBefore = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
               ->from('orders_to_patient_options')
               ->where('order_id', $order_id)
               ->group_by('bed_id')
               ->get()
               ->result_array();
           log_message('info', "ORDER UPDATE DEBUG: BEFORE deletion - Order {$order_id} has items for suites: " . json_encode($allSuitesBefore));
           
           // Delete existing records for this specific bed and order
           // Note: This is necessary when updating - delete old items, then insert new ones
           $conditionsDelete = ['order_id' => $order_id,'bed_id' => $bedId];
           log_message('info', "ORDER UPDATE DEBUG: About to delete items for order_id={$order_id}, bed_id={$bedId} (Suite {$suiteNumber})");
           
           $this->common_model->commonRecordDeleteMultipleConditions('orders_to_comments', $conditionsDelete);
           $this->common_model->commonRecordDeleteMultipleConditions('orders_to_patient_options', $conditionsDelete);
           
           // ✅ CRITICAL DEBUG: Log what exists AFTER deletion
           $allSuitesAfter = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
               ->from('orders_to_patient_options')
               ->where('order_id', $order_id)
               ->group_by('bed_id')
               ->get()
               ->result_array();
           log_message('info', "ORDER UPDATE DEBUG: AFTER deletion - Order {$order_id} has items for suites: " . json_encode($allSuitesAfter));

           // Update order - constraint will prevent duplicates if somehow date changes (edge case protection)
           try {
               $this->tenantDb->where('order_id', $order_id);
               $this->tenantDb->update('orders', $orderUpdateData);
               
               $affectedRows = $this->tenantDb->affected_rows();
               $dbError = $this->tenantDb->error();
               
               // Check for database errors (including constraint violations as edge case protection)
               if (!empty($dbError['message'])) {
                   log_message('error', "ORDER PLACE LEGACY UPDATE DATABASE ERROR: " . $dbError['message'] . ". Order ID={$order_id}, Date={$orderDate}, Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                   
                   // Check if it's a constraint violation (shouldn't happen in normal flow)
                   if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'idx_unique_floor_date_active') !== false) {
                       log_message('error', "ORDER PLACE LEGACY UPDATE CONSTRAINT VIOLATION: Unique constraint violated during order update. Order ID={$order_id}, Date={$orderDate}, Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                       $this->session->set_flashdata('error', 
                           'Cannot update order! An order already exists for this floor and date. Please edit the existing order instead.');
                       redirect('Orderportal/Home/index');
                       return;
                   } else {
                       $this->session->set_flashdata('error', 'Failed to update order: ' . $dbError['message']);
                       redirect('Orderportal/Home/index');
                       return;
                   }
               }
               
               if ($affectedRows > 0) {
                   log_message('info', "ORDER PLACE LEGACY UPDATE SUCCESS: Order ID={$order_id}, Date={$orderDate}, Suite={$suiteNumber}, Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
               } else {
                   log_message('warning', "ORDER PLACE LEGACY UPDATE: No rows affected for Order ID={$order_id}, Date={$orderDate}, Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
               }
           } catch (Exception $e) {
               log_message('error', "ORDER PLACE LEGACY UPDATE EXCEPTION: " . $e->getMessage() . ". Order ID={$order_id}, Date={$orderDate}, Suite={$suiteNumber}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
               if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                   $this->session->set_flashdata('error', 
                       'Cannot update order! An order already exists for this floor and date. Please edit the existing order instead.');
               } else {
                   $this->session->set_flashdata('error', 'An error occurred while updating order: ' . $e->getMessage());
               }
               redirect('Orderportal/Home/index');
               return;
           }
           
           // LATE ORDER TRACKING: Explicitly update orders.updated_at timestamp for legacy orders
           // This ensures any menu item changes after cutoff time are tracked as late orders
           $this->tenantDb->set('updated_at', 'NOW()', FALSE);
           $this->tenantDb->where('order_id', $order_id);
           $this->tenantDb->update('orders');
           
           // Get item count for logging
           $itemCountQuery = $this->tenantDb->query("
               SELECT COUNT(*) as count, SUM(quantity) as total_qty 
               FROM orders_to_patient_options 
               WHERE order_id = ? AND bed_id = ?
           ", [$order_id, $bedId]);
           $itemStats = $itemCountQuery->row();
           $itemCount = $itemStats->count ?? 0;
           $totalQty = $itemStats->total_qty ?? 0;
           
           // NOTIFICATION: Order Updated - notify chef/admin about late order updates
           if($_POST['buttonType'] == 'update' || $_POST['buttonType'] == 'sendorder'){
               // ═══════════════════════════════════════════════════════════════════════
               // ENHANCED LOGGING for Order Update
               // ═══════════════════════════════════════════════════════════════════════
               
               $updateWorkflowStatus = isset($orderUpdateData['workflow_status']) ? $orderUpdateData['workflow_status'] : 'N/A';
               
               log_message('info', "ORDER PLACE LEGACY UPDATE COMPLETE: Order ID={$order_id}, Order Date={$orderData['date']}, Floor/Dept ID={$orderData['dept_id']}, Suite={$suiteNumber} (ID={$bedId}), Workflow Status={$updateWorkflowStatus}, Total Menu Items={$itemCount}, Total Quantity={$totalQty}, User={$username}, User ID={$userId}, IP={$ipAddress}, Button Type=" . ($_POST['buttonType'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
               
               // SIMPLIFIED NOTIFICATION: Update Order
               $bedNo = $bedExists[0]['bed_no'] ?: 'Unknown Suite';
               $orderDateFormatted = format_australia_date($orderDate, 'd-m-Y');
               $currentDate = australia_date_only();
               $currentDateFormatted = format_australia_date($currentDate, 'd-m-Y');
               $currentTime = australia_date('H:i'); // Get current time in 24-hour format
               
               if($_POST['buttonType'] == 'update') {
                   // SIMPLIFIED: Update Order notification (for order date, on placement date/time)
                   $msg = "Update Order: Suite {$bedNo} - update order placed for suite {$bedNo} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
               } else {
                   // New order (shouldn't happen here, but handle it)
                   $msg = "New Order: Suite {$bedNo} - new order placed for suite {$bedNo} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
               }
               
               createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
           }
           
           // Update is successful - CodeIgniter will throw an exception if there's a database error
           
         }else{
          // 🔧 FIX: Check for existing order for this date+floor BEFORE creating
          // ═══════════════════════════════════════════════════════════════════════
          // ENHANCED LOGGING for Order Creation
          // Users reporting data loss - track every order creation attempt
          // ═══════════════════════════════════════════════════════════════════════
          
          log_message('info', "ORDER PLACE LEGACY CREATE ATTEMPT: Order Date={$orderData['date']}, Floor/Dept ID={$orderData['dept_id']}, Suite={$suiteNumber} (ID={$bedId}), User={$username}, User ID={$userId}, IP={$ipAddress}, Button Type={$buttonType}, Timestamp=" . australia_datetime());
          
          $duplicateCheck = [
              'date' => $orderData['date'],
              'dept_id' => $orderData['dept_id'],
          ];
           
           // Build WHERE clause to exclude cancelled/deleted orders
           $this->tenantDb->where($duplicateCheck);
           $this->tenantDb->where('workflow_status !=', 'cancelled');
           $this->tenantDb->where('workflow_status !=', 'cancelled_duplicate');
           $this->tenantDb->where('workflow_status !=', 'deleted');
           $existingOrder = $this->tenantDb->get('orders')->result_array();
           
          if(!empty($existingOrder)) {
              // Order already exists for this date+floor
              $existingOrderId = $existingOrder[0]['order_id'];
              $existingStatus = $existingOrder[0]['workflow_status'];
              
              log_message('warning', "ORDER PLACE LEGACY CREATE BLOCKED: Duplicate order detected. Existing Order ID={$existingOrderId}, Status={$existingStatus}, Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite={$suiteNumber}, User={$username}, User ID={$userId}, IP={$ipAddress} at " . australia_datetime());
              
              $this->session->set_flashdata('error', "An order (#{$existingOrderId}) already exists for this floor and date (status: {$existingStatus}). Please edit the existing order instead of creating a new one.");
              redirect('Orderportal/Home/index');
              return;
          }
          
          // No duplicate found, safe to create
          log_message('info', "ORDER PLACE LEGACY CREATE: No duplicate found, proceeding with order creation. Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite={$suiteNumber}, User={$username} at " . australia_datetime());
          
          // CRITICAL FIX: Handle race condition - two users creating at same time
          try {
              $order_id = $this->common_model->commonRecordCreate('orders', $orderData);
              
              if (!$order_id) {
                  $db_error = $this->tenantDb->error();
                  log_message('error', "ORDER PLACE LEGACY CREATE FAILED: Database returned false/null. Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite={$suiteNumber}, User={$username}, User ID={$userId}, IP={$ipAddress}, Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . " at " . australia_datetime());
                  $this->session->set_flashdata('error', 'Failed to create order. Please try again.');
                  redirect('Orderportal/Home/index');
                  return;
              }
              
              log_message('info', "ORDER PLACE LEGACY CREATE SUCCESS: Order ID={$order_id}, Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite={$suiteNumber}, User={$username}, User ID={$userId}, IP={$ipAddress}, Timestamp=" . australia_datetime());
          } catch (Exception $e) {
              $errorMsg = $e->getMessage();
              
              // Check if it's a duplicate key error (race condition caught by database)
              if (strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false || strpos($errorMsg, 'idx_unique_floor_date_active') !== false) {
                  log_message('warning', "ORDER PLACE LEGACY CREATE BLOCKED: Duplicate detected (race condition). Another user just created order for date={$orderData['date']}, floor={$orderData['dept_id']}, Suite={$suiteNumber}, User={$username}, User ID={$userId}, IP={$ipAddress} at " . australia_datetime());
                  log_message('warning', "   Error: {$errorMsg}");
                  
                  // Fetch the order that was just created by the other user
                  $this->tenantDb->where('date', $orderData['date']);
                  $this->tenantDb->where('dept_id', $orderData['dept_id']);
                  $this->tenantDb->where('is_floor_consolidated', isset($orderData['is_floor_consolidated']) ? $orderData['is_floor_consolidated'] : 0);
                  $this->tenantDb->where('status !=', 0); // Only active orders
                  $existingOrder = $this->tenantDb->get('orders')->row();
                  
                  // Race condition: Another user just created the order
                  log_message('warning', "ORDER CREATE BLOCKED: Duplicate order detected (race condition). Another user just created order for date={$orderData['date']}, floor={$orderData['dept_id']}, Suite=" . ($bedExists[0]['bed_no'] ?? 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                  $this->session->set_flashdata('error', 
                      'An order for this floor and date was just created by another user. Please refresh the page and edit the existing order.');
                  redirect('Orderportal/Home/index');
                  return;
              } else {
                  // Different error - re-throw or handle
                  log_message('error', "ORDER CREATE FAILED: Database error: {$errorMsg}. Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite=" . ($bedExists[0]['bed_no'] ?? 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                  $this->session->set_flashdata('error', 'Failed to create order: ' . $errorMsg);
                  redirect('Orderportal/Home/index');
                  return;
              }
          }
           
           log_message('info', "ORDER CREATE SUCCESS: Order ID={$order_id}, Order Date={$orderData['date']}, Floor={$orderData['dept_id']}, Suite=" . ($bedExists[0]['bed_no'] ?? 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
           
           // Associate existing comments with this new order
           $this->associateCommentsWithOrder($order_id, $orderData['dept_id'], $orderData['date']);
           
           // Log initial order status
           $this->logOrderStatusChange($order_id, null, 1, 'Order created for Suite ' . $bedExists[0]['bed_no']);
           
           // SIMPLIFIED NOTIFICATION: New Order Created
           $bedNo = $bedExists[0]['bed_no'] ?: 'Unknown Suite';
           $orderDateFormatted = format_australia_date($orderData['date'], 'd-m-Y');
           $currentDate = australia_date_only();
           $currentDateFormatted = format_australia_date($currentDate, 'd-m-Y');
           $currentTime = australia_date('H:i'); // Get current time in 24-hour format
           
           if($_POST['buttonType'] == 'sendorder') {
               // SIMPLIFIED: New Order notification (for order date, on placement date/time)
               $msg = "New Order: Suite {$bedNo} - new order placed for suite {$bedNo} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
               createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
           }
           // No notification for save (draft) - only final orders
           
           $successMessage = 'Order placed successfully for Suite ' . $bedExists[0]['bed_no'];
         }
        
        $ordertoPatients = array();
        $result = [];
        $dbTransactionSuccess = true;
        
        // Start database transaction to ensure data consistency
        $this->db->trans_start();
        
        foreach($orderArray as $bedID => $orderMenu) {
            // DEBUG: Log the entire POST structure
            // Debug: Order array structure
            // error_log("ORDER ARRAY FOR BED $bedID: " . print_r($orderMenu, true));
            
            // Validate bed ID matches the selected bed
            if ($bedID != $bedId) {
                $dbTransactionSuccess = false;
                break;
            }
            
            // Insert order comments bed wise and also order data in serialized format (remove later if unused)
            $ordertoComments['order_id'] = $order_id;
            $ordertoComments['bed_id'] = $bedId;
            $ordertoComments['order_data'] = serialize($orderMenu);
            $ordertoComments['order_comment'] = isset($orderMenu['notes']) ? $orderMenu['notes'] : '';

            $commentResult = $this->common_model->commonRecordCreate('orders_to_comments', $ordertoComments);
            
            if (!$commentResult) {
                $dbTransactionSuccess = false;
                break;
            }

            // ✅ PATIENT ID FIX: Get patient ID for this suite at order time
            $currentPatient = $this->tenantDb->query("
                SELECT id FROM people 
                WHERE suite_number = ? AND status = 1
                AND (date_of_discharge IS NULL OR date_of_discharge >= ?)
                ORDER BY date_onboarded DESC
                LIMIT 1
            ", [$bedId, $orderData['date']])->row();
            $patientId = $currentPatient ? $currentPatient->id : null;

            $bulkOptionsData = [];
            // Iterate over all menu selected by user and insert in orders_to_patient_options (remove later if not needed)
            foreach($orderMenu as $catAndMenuId => $orderSelectedMenuOptions) {
                // Skip 'notes' and 'buttonType' keys
                if (in_array($catAndMenuId, ['notes', 'buttonType'])) {
                    continue;
                }

                $CatMenuId = explode('_', $catAndMenuId); 
                if (count($CatMenuId) == 2) {
                    $category_id = $CatMenuId[0];
                    $menu_id = $CatMenuId[1];
                    
                    // DEBUG: Log what we extracted
                    // Debug: Legacy order save
                    // error_log("LEGACY ORDER SAVE: catAndMenuId=$catAndMenuId, category_id=$category_id, menu_id=$menu_id");
                    
                    // Validate that the menu_id exists and is valid
                    $menuExists = $this->common_model->fetchRecordsDynamically('menuDetails', ['id'], ['id' => $menu_id]);
                    if (empty($menuExists)) {
                        continue; // Skip invalid menu items
                    }
                }

                if(is_array($orderSelectedMenuOptions)) {
                    // For checkbox selection as it can be multiple options per menu user can select
                    foreach($orderSelectedMenuOptions as $orderSelectedMenuOptionsValues) {
                        if (!empty($orderSelectedMenuOptionsValues)) {
                            $bulkOptionsData[] = array(
                                'order_id'   => $order_id,
                                'bed_id'     => $bedID,
                                'patient_id' => $patientId, // ✅ Store patient ID
                                'category_id' => $category_id,
                                'menu_id'    => $menu_id,
                                'option_id'  => $orderSelectedMenuOptionsValues,
                                'quantity'   => 1,
                                'status'     => 0,
                                'created_at' => australia_date_only()
                            );  
                        }
                    }
                } else {
                    // In case of radio button, where user select just one value
                    if (!empty($orderSelectedMenuOptions)) {
                        $bulkOptionsData[] = array(
                            'order_id'   => $order_id,
                            'bed_id'     => $bedID,
                            'patient_id' => $patientId, // ✅ Store patient ID
                            'category_id' => $category_id,
                            'menu_id'    => $menu_id,
                            'option_id'  => $orderSelectedMenuOptions,
                            'quantity'   => 1,
                            'status'     => 0,
                            'created_at' => australia_date_only()
                        ); 
                    }
                }
            }

            // Only insert if we have data to insert
            if (!empty($bulkOptionsData)) {
                log_message('info', "ORDER UPDATE DEBUG: About to insert " . count($bulkOptionsData) . " items for order_id={$order_id}, bed_id={$bedID}");
                $optionsResult = $this->common_model->commonBulkRecordCreate('orders_to_patient_options', $bulkOptionsData);
                if (!$optionsResult) {
                    $dbTransactionSuccess = false;
                    break;
                }
            } else {
                log_message('warning', "ORDER UPDATE DEBUG: No items to insert for order_id={$order_id}, bed_id={$bedID}");
            }
        }
        
        // Complete database transaction
        $this->db->trans_complete();
        
        // ✅ CRITICAL DEBUG: Log what exists AFTER insertion
        $allSuitesFinal = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
            ->from('orders_to_patient_options')
            ->where('order_id', $order_id)
            ->group_by('bed_id')
            ->get()
            ->result_array();
        log_message('info', "ORDER UPDATE DEBUG: AFTER insertion - Order {$order_id} has items for suites: " . json_encode($allSuitesFinal));
        
        // Check if transaction was successful
        if ($this->db->trans_status() === FALSE || !$dbTransactionSuccess) {
            $this->session->set_flashdata('error', 'Failed to save order. Please try again.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // ✅ HISTORICAL SNAPSHOT: Create or update immutable snapshot of order data (Legacy Orders)
        // This ensures order history remains accurate even if menus, patients, or suites change
        if($_POST['buttonType'] == 'sendorder' || $_POST['buttonType'] == 'update') {
            try {
                $this->load->model('Snapshot_model');
                // Update snapshot if order exists, create new if not
                $snapshotId = $this->Snapshot_model->updateOrderSnapshot($order_id);
                if ($snapshotId) {
                    log_message('info', "ORDER SNAPSHOT CREATED: Snapshot ID={$snapshotId}, Legacy Order ID={$order_id}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } else {
                    log_message('warning', "ORDER SNAPSHOT FAILED: Failed to create/update order snapshot for Legacy Order ID={$order_id}. Order still succeeded. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            } catch (Exception $e) {
                // Snapshot failure should not break the order flow
                log_message('error', "ORDER SNAPSHOT EXCEPTION: Legacy Order ID={$order_id}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
            }
        }
        
        // Only set success message if DB operations were successful
        $this->session->set_flashdata('success', $successMessage);
        
        // Store suite-specific success data for display
        $this->session->set_userdata('order_success_data', [
            'suite_name' => 'Suite ' . $bedExists[0]['bed_no'],
            'suite_id' => $bedId,
            'order_id' => $order_id,
            'timestamp' => time()
        ]);
        
        // EMAIL NOTIFICATION: Send email to chef about new/updated order
        if($_POST['buttonType'] == 'sendorder') {
            // Determine if this is an update or new order
            $isUpdate = !empty($existingOrderData);
            
            // Get floor name
            $floorName = fetchDepartmentNameFromId($this->tenantDb, $this->session->userdata('department_id'));
            $suiteNumber = $bedExists[0]['bed_no'];
            $orderDate = format_australia_date($orderData['date'], 'd-m-Y');
            
            // Collect order items with full details
            $orderItemsData = [];
            
            // Fetch menu details for the order
            $menuLists = $this->menu_model->fetchMenuDetails('', true);
            
            // Get allergens data
            $conditionsAllergen = ['listtype' => 'allergen'];
            $allergensData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsAllergen);
            
            // Build items array from bulkOptionsData
            foreach($orderArray as $bedID => $orderMenu) {
                foreach($orderMenu as $catAndMenuId => $orderSelectedMenuOptions) {
                    if (in_array($catAndMenuId, ['notes', 'buttonType'])) {
                        continue;
                    }
                    
                    $CatMenuId = explode('_', $catAndMenuId);
                    if (count($CatMenuId) == 2) {
                        $category_id = $CatMenuId[0];
                        $menu_id = $CatMenuId[1];
                        
                        // Get category name
                        $categoryData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['name'], ['id' => $category_id]);
                        $categoryName = !empty($categoryData) ? $categoryData[0]['name'] : 'Unknown Category';
                        
                        if (!isset($orderItemsData[$categoryName])) {
                            $orderItemsData[$categoryName] = [];
                        }
                        
                        // Find menu details
                        foreach($menuLists as $menu) {
                            if ($menu['menu_id'] == $menu_id) {
                                foreach($menu['menu_options'] as $option) {
                                    if (in_array($option['option_id'], $orderSelectedMenuOptions)) {
                                        // Get allergens for this option
                                        $allergenNames = [];
                                        if (!empty($option['allergenValues'])) {
                                            $allergenIds = json_decode($option['allergenValues'], true);
                                            if (is_array($allergenIds) && !empty($allergenIds)) {
                                                foreach ($allergenIds as $allergenId) {
                                                    foreach ($allergensData as $allergen) {
                                                        if ($allergen['id'] == $allergenId) {
                                                            $allergenNames[] = $allergen['name'];
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                        $orderItemsData[$categoryName][] = [
                                            'name' => $menu['menu_name'],
                                            'options' => $option['menu_option_name'],
                                            'allergens' => implode(', ', $allergenNames),
                                            'comment' => '' // Item comments not available in this flow
                                        ];
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
            }
            
            // Send email notification ONLY for late orders (after 10:32 AM AND for today's orders)
            if ($this->shouldSendLateOrderNotification($orderDate)) {
                log_message('info', "EMAIL NOTIFICATION TRIGGERED: Sending late order email notification for Legacy Suite Order ID={$order_id}, Suite={$suiteNumber}, Order Date={$orderDate}, Timestamp=" . australia_datetime());
                $this->sendOrderNotificationEmail(
                    $order_id,
                    $floorName,
                    $suiteNumber,
                    $orderDate,
                    $isUpdate,
                    $orderItemsData
                );
            } else {
                log_message('info', "EMAIL NOTIFICATION SKIPPED: Not a late order (before 10:32 AM or not for today). Legacy Suite Order ID={$order_id}, Suite={$suiteNumber}, Order Date={$orderDate}, Timestamp=" . australia_datetime());
            }
        }
        
        redirect('Orderportal/Home/index');  
        
    }
    
   // when nurse sends order from thoer portal 
   function placeOrderNursePortal() {
       log_message('info', "🚀 placeOrderNursePortal() function called - START");
       
    //   echo "<pre>"; print_r($this->POST);exit;
    
    // TEMPORARILY DISABLED - Check cutoff time (10:30 AM) for next day orders (reception/patient users only)
    // if (!$this->isWithinOrderCutoffTime()) {
    //     $this->session->set_flashdata('error', 'Order cutoff time has passed. Orders for tomorrow must be placed before 10:30 AM today.');
    //     redirect('Orderportal/Home/index');
    //     return;
    // }
       
    // Fetch department settings
    $configData = $this->common_model->fetchRecordsDynamically('departmentSettings', ['daily_budget', 'daily_limit'], '');

    // CRITICAL FIX: Accept orderDate from POST (from Nurse Dashboard date picker), default to tomorrow
    // Use Australia/Sydney timezone for date validation
    $orderDate = $this->input->post('orderDate');
    $postOrderDate = $orderDate; // Keep original for logging
    if (!$orderDate) {
        $orderDate = $this->getAustraliaTomorrow();
        log_message('warning', "ORDER PLACE NURSE PORTAL: No orderDate in POST, defaulting to tomorrow: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
    } else {
        // Ensure date is in correct format (YYYY-MM-DD)
        $orderDate = $this->getAustraliaDate($orderDate);
        log_message('info', "ORDER PLACE NURSE PORTAL: Received orderDate from POST: {$orderDate}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
    }
    
    // Validate date range (today to +7 days) for Nurse Dashboard - use Australia/Sydney timezone
    $orderDateTime = strtotime($orderDate);
    $todayAustralia = $this->getAustraliaDate();
    $today = strtotime($todayAustralia);
    $maxDate = strtotime('+7 days', $today);
    
    if ($orderDateTime < $today || $orderDateTime > $maxDate) {
        log_message('error', "ORDER PLACE NURSE PORTAL FAILED: Invalid order date: {$orderDate} (must be between today and +7 days). User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        $this->session->set_flashdata('error', 'Invalid order date. Date must be between today and 7 days from now.');
        redirect('Orderportal/Home/index');
        return;
    }
    
    $orderData = [
        'date' => $orderDate, // Use the date from POST or default to tomorrow
        'status' => 1,
        'added_by' => $this->session->userdata('user_id'),
        'dept_id' => $this->session->userdata('department_id') ?? 0,
        'budget' => isset($configData[0]['daily_budget']) ? $configData[0]['daily_budget'] : 0,
        'limits' => isset($configData[0]['daily_limit']) ? $configData[0]['daily_limit'] : 0
    ];

    // Validate POST data
    if (empty($_POST)) {
        $this->session->set_flashdata('error', 'No order data provided.');
        redirect('Orderportal/Home/index');
    }

    // ═══════════════════════════════════════════════════════════════════════
    // COMPREHENSIVE ORDER LOGGING - START
    // ═══════════════════════════════════════════════════════════════════════
    $userId = $this->session->userdata('user_id');
    $username = $this->session->userdata('username') ?: 'Unknown';
    $deptId = $this->session->userdata('department_id');
    $buttonType = $_POST['buttonType'] ?? 'unknown';
    $ipAddress = $this->input->ip_address();
    
    log_message('info', "═══════════════════════════════════════════════════════════════");
    log_message('info', "📦 NURSE PORTAL ORDER - START");
    log_message('info', "   Function: placeOrderNursePortal()");
    log_message('info', "   Timestamp: " . australia_datetime());
    log_message('info', "   Order Date: {$orderDate}");
    log_message('info', "   Floor/Dept ID: {$deptId}");
    log_message('info', "   User ID: {$userId}");
    log_message('info', "   Username: {$username}");
    log_message('info', "   Button Type: {$buttonType}");
    log_message('info', "   IP Address: {$ipAddress}");
    log_message('info', "═══════════════════════════════════════════════════════════════");
    
    // CRITICAL FIX: Force buttonType to 'sendorder' - ALL orders go directly to chef
    $_POST['buttonType'] = 'sendorder';

    // Check for existing ACTIVE order (exclude cancelled/deleted orders)
    // Use the orderDate from POST, not hardcoded tomorrow
    
    log_message('info', "🔍 [placeOrderNursePortal] Checking for existing order: Date={$orderDate}, Floor={$deptId}");
    
    $this->tenantDb->where('date', $orderDate);
    $this->tenantDb->where('dept_id', $deptId);
    $this->tenantDb->where('is_floor_consolidated', 1);
    $this->tenantDb->where_not_in('workflow_status', ['cancelled', 'cancelled_duplicate', 'deleted']);
    $existingOrderData = $this->tenantDb->get('orders')->result_array();
    
    $foundCount = count($existingOrderData);
    log_message('info', "📋 [placeOrderNursePortal] Duplicate check result: Found {$foundCount} active order(s)");

    // Create or update order
    $order_id = null; // Initialize to ensure it's available in scope
    if (!empty($existingOrderData)) {
        // Found existing ACTIVE order - update it
        $order_id = $existingOrderData[0]['order_id'];
        $existingStatus = $existingOrderData[0]['workflow_status'];
        
        log_message('info', "ORDER PLACE NURSE PORTAL UPDATE: Updating existing order ID={$order_id}, Existing Status={$existingStatus}, Order Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // Use the date from date picker (POST) - this is what the user selected
        // The existing order lookup already found the order for this date, so we update it with the same date
        $existingOrderDate = $existingOrderData[0]['date'] ?? null;
        $orderUpdateData = [
            'updated_by' => $this->session->userdata('user_id'),
            'buttonType' => $_POST['buttonType'],
            'updated_at' => australia_datetime(),
            'date' => $orderDate // Use date picker date
        ];
        
        // NOTE: Date should never change in normal flow - lookup finds order for the selected date
        log_message('info', "ORDER PLACE NURSE PORTAL UPDATE: Updating order ID={$order_id} for date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        $successMessage = 'Order Updated Successfully';
        
        // 🔒 CRITICAL FIX: Use direct update with error handling
        try {
            $this->tenantDb->where('order_id', $order_id);
            $this->tenantDb->update('orders', $orderUpdateData);
            
            $affectedRows = $this->tenantDb->affected_rows();
            $dbError = $this->tenantDb->error();
            
            // Check for database errors
            if (!empty($dbError['message'])) {
                log_message('error', "ORDER PLACE NURSE PORTAL UPDATE DATABASE ERROR: " . $dbError['message'] . ". Order ID={$order_id}, Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                
                // Check if it's a constraint violation
                if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'idx_unique_floor_date_active') !== false) {
                    log_message('error', "ORDER PLACE NURSE PORTAL UPDATE CONSTRAINT VIOLATION: Unique constraint violated during order update. Order ID={$order_id}, Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    $this->session->set_flashdata('error', 
                        'Cannot update order! An order already exists for this floor and date. Please edit the existing order instead.');
                    redirect('Orderportal/Home/index');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to update order: ' . $dbError['message']);
                    redirect('Orderportal/Home/index');
                    return;
                }
            }
            
            if ($affectedRows > 0) {
                log_message('info', "ORDER PLACE NURSE PORTAL UPDATE SUCCESS: Order ID={$order_id}, Date={$orderDate}, Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            } else {
                log_message('warning', "ORDER PLACE NURSE PORTAL UPDATE: No rows affected for Order ID={$order_id}, Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            }
        } catch (Exception $e) {
            log_message('error', "ORDER PLACE NURSE PORTAL UPDATE EXCEPTION: " . $e->getMessage() . ". Order ID={$order_id}, Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
            $this->session->set_flashdata('error', 'An error occurred while updating order: ' . $e->getMessage());
            redirect('Orderportal/Home/index');
            return;
        }
        
        // Get item count for logging
        $itemCountQuery = $this->tenantDb->query("
            SELECT COUNT(*) as count, SUM(quantity) as total_qty 
            FROM orders_to_patient_options 
            WHERE order_id = ?
        ", [$order_id]);
        $itemStats = $itemCountQuery->row();
        $itemCount = isset($itemStats->count) ? $itemStats->count : 0;
        $totalQty = isset($itemStats->total_qty) ? $itemStats->total_qty : 0;
        
        $newWorkflowStatus = isset($orderUpdateData['workflow_status']) ? $orderUpdateData['workflow_status'] : 'N/A';
        log_message('info', "ORDER PLACE NURSE PORTAL UPDATE COMPLETE: Order ID={$order_id}, Order Date={$orderDate}, Floor/Dept ID={$deptId}, Workflow Status={$existingStatus} -> {$newWorkflowStatus}, Total Menu Items={$itemCount}, Total Quantity={$totalQty}, User={$username}, User ID={$userId}, IP={$ipAddress}, Button Type=" . ($_POST['buttonType'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
        
        // NOTIFICATION: Nurse Portal Order Update
        $userRole = $this->ion_auth->get_users_groups()->row();
        $roleName = $userRole ? $userRole->name : 'User';
        $userName = $this->session->userdata('username') ?: 'Unknown User';
        $deptId = $this->session->userdata('department_id') ?: 'Unknown Floor';
        
        // SIMPLIFIED NOTIFICATION: Update Order (Nurse Portal)
        if($_POST['buttonType'] == 'sendorder') {
            $bedNo = !empty($processedBeds) ? 'Multiple Suites' : 'Unknown Suite';
            if (count($processedBeds) == 1) {
                // Get suite number for single suite
                $bedInfo = $this->common_model->fetchRecordsDynamically('suites', ['bed_no'], ['id' => $processedBeds[0]]);
                $bedNo = !empty($bedInfo) ? $bedInfo[0]['bed_no'] : 'Unknown Suite';
            }
            $orderDateFormatted = format_australia_date($orderDate, 'd-m-Y');
            $currentDate = australia_date_only();
            $currentDateFormatted = format_australia_date($currentDate, 'd-m-Y');
            $currentTime = australia_date('H:i'); // Get current time in 24-hour format
            
            // SIMPLIFIED: Update Order notification (for order date, on placement date/time)
            $msg = "Update Order: Suite {$bedNo} - update order placed for suite {$bedNo} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
        }
        
        // ✅ HISTORICAL SNAPSHOT: Create or update immutable snapshot of order data (Nurse Portal - Update Order)
        // This ensures order history remains accurate even if menus, patients, or suites change
        if($_POST['buttonType'] == 'sendorder' || $_POST['buttonType'] == 'update') {
            try {
                $this->load->model('Snapshot_model');
                // Update snapshot if order exists, create new if not
                $snapshotId = $this->Snapshot_model->updateOrderSnapshot($order_id);
                if ($snapshotId) {
                    log_message('info', "ORDER SNAPSHOT CREATED: Snapshot ID={$snapshotId}, Nurse Portal Update Order ID={$order_id}, Order Date={$orderDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } else {
                    log_message('warning', "ORDER SNAPSHOT FAILED: Failed to create/update order snapshot for Nurse Portal Update Order ID={$order_id}, Order Date={$orderDate}. Order still succeeded. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            } catch (Exception $e) {
                // Snapshot failure should not break the order flow
                log_message('error', "ORDER SNAPSHOT EXCEPTION: Nurse Portal Update Order ID={$order_id}, Order Date={$orderDate}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
            }
        }
        
    } else {
        // No active order exists - create new one (with error handling for race conditions)
        log_message('info', "ORDER CREATE NURSE PORTAL: No active order found, creating new order. Order Date={$orderDate}, Floor/Dept ID={$deptId}, User={$username}, User ID={$userId}, IP={$ipAddress}, Button Type=" . ($_POST['buttonType'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
        
        try {
            $order_id = $this->common_model->commonRecordCreate('orders', $orderData);
            
            if (!$order_id) {
                $db_error = $this->tenantDb->error();
                log_message('error', "ORDER CREATE NURSE PORTAL FAILED: Database returned false/null. Order Date={$orderDate}, Floor/Dept ID={$deptId}, User={$username}, User ID={$userId}, IP={$ipAddress}, Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . " at " . australia_datetime());
                $this->session->set_flashdata('error', 'Failed to create order. Please try again.');
                redirect('Orderportal/Home/index');
                return;
            }
            
            // Get item count for logging
            $itemCountQuery = $this->tenantDb->query("
                SELECT COUNT(*) as count, SUM(quantity) as total_qty 
                FROM orders_to_patient_options 
                WHERE order_id = ?
            ", [$order_id]);
            $itemStats = $itemCountQuery->row();
            $itemCount = $itemStats->count ?? 0;
            $totalQty = $itemStats->total_qty ?? 0;
            
            $createWorkflowStatus = isset($orderData['workflow_status']) ? $orderData['workflow_status'] : 'N/A';
            $isFloorConsolidated = isset($orderData['is_floor_consolidated']) ? $orderData['is_floor_consolidated'] : 0;
            
            log_message('info', "ORDER CREATE NURSE PORTAL SUCCESS: Order ID={$order_id}, Order Date={$orderDate}, Floor/Dept ID={$deptId}, Workflow Status={$createWorkflowStatus}, Is Floor Consolidated={$isFloorConsolidated}, Total Menu Items={$itemCount}, Total Quantity={$totalQty}, User={$username}, User ID={$userId}, IP={$ipAddress}, Button Type=" . ($_POST['buttonType'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
            
            // Associate existing comments with this new order
            $this->associateCommentsWithOrder($order_id, $orderData['dept_id'], $orderData['date']);
            
            // Log initial order status
            $this->logOrderStatusChange($order_id, null, 1, 'Order created via nurse portal');
            
            // SIMPLIFIED NOTIFICATION: New Order (Nurse Portal)
            if($_POST['buttonType'] == 'sendorder') {
                $bedNo = !empty($processedBeds) ? 'Multiple Suites' : 'Unknown Suite';
                if (count($processedBeds) == 1) {
                    // Get suite number for single suite
                    $bedInfo = $this->common_model->fetchRecordsDynamically('suites', ['bed_no'], ['id' => $processedBeds[0]]);
                    $bedNo = !empty($bedInfo) ? $bedInfo[0]['bed_no'] : 'Unknown Suite';
                }
                $orderDateFormatted = format_australia_date($orderDate, 'd-m-Y');
                $currentDate = australia_date_only();
                $currentDateFormatted = format_australia_date($currentDate, 'd-m-Y');
                $currentTime = australia_date('H:i'); // Get current time in 24-hour format
                
                // SIMPLIFIED: New Order notification (for order date, on placement date/time)
                $msg = "New Order: Suite {$bedNo} - new order placed for suite {$bedNo} for {$orderDateFormatted} on {$currentDateFormatted} {$currentTime}";
                createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
            }
            // No notification for save (draft) - only final orders
            
            $successMessage = 'Order placed successfully';
            
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            
            // Check if it's a duplicate key error (race condition caught by database)
            if (strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false) {
                log_message('warning', "ORDER PLACE NURSE PORTAL CREATE BLOCKED: Duplicate order blocked by database constraint. Error={$errorMsg}, Order Date={$orderDate}, Floor/Dept ID={$deptId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                log_message('warning', "    This indicates a race condition was caught by the database UNIQUE key");
                $this->session->set_flashdata('error', 
                    'An order for this floor and date was just created by another user. Please refresh the page and edit the existing order.');
            } else {
                log_message('error', "ORDER PLACE NURSE PORTAL CREATE FAILED: Failed to create order. Error={$errorMsg}, Order Date={$orderDate}, Floor/Dept ID={$deptId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                $this->session->set_flashdata('error', 'Failed to create order. Please try again.');
            }
            
            redirect('Orderportal/Home/index');
            return;
        }
    }

    $bulkOptionsData = [];
    $processedBeds = [];
    
    // ✅ CRITICAL FIX: When updating, preserve existing suites that aren't in POST
    // Only delete items for suites that are explicitly being updated (in POST)
    $suitesToUpdate = []; // Track which suites are being updated via POST

    foreach ($this->POST as $key => $value) {
        // Handle menu selections
        if (strpos($key, '_') !== false && !in_array($key, ['buttonType']) && strpos($key, 'note_') !== 0) {
            $bedCatMenuIds = explode('_', $key);
            if (count($bedCatMenuIds) !== 3 || !is_numeric($bedCatMenuIds[0])) {
                continue; // Skip invalid keys
            }

            $bed_id = $bedCatMenuIds[0];
            $category_id = $bedCatMenuIds[1];
            $menu_id = $bedCatMenuIds[2];
            
            // DEBUG: Log the category_id being saved
            // Debug: Saving order
            // error_log("SAVING ORDER: bed_id=$bed_id, category_id=$category_id, menu_id=$menu_id");

            // Mark bed as processed
            $processedBeds[$bed_id] = true;
            
            // Track that this suite is being updated
            if (!isset($suitesToUpdate[$bed_id])) {
                $suitesToUpdate[$bed_id] = [];
            }

            // ✅ PATIENT ID FIX: Get patient ID for this bed at order time
            $currentPatient = $this->tenantDb->query("
                SELECT id FROM people 
                WHERE suite_number = ? AND status = 1
                AND (date_of_discharge IS NULL OR date_of_discharge >= ?)
                ORDER BY date_onboarded DESC
                LIMIT 1
            ", [$bed_id, $orderData['date']])->row();
            $patientId = $currentPatient ? $currentPatient->id : null;

            // Save menu options with category_id to track meal period
            // ✅ CRITICAL FIX: When updating a suite, delete ALL items for that suite first (suite-level deletion)
            // This ensures suite 309 update doesn't affect suites 301, 302, 303
            // Only delete once per suite (on first category encountered)
            if (!empty($value)) {
                // Track this suite as being updated
                if (!isset($suitesToUpdate[$bed_id])) {
                    $suitesToUpdate[$bed_id] = [];
                }
                $suitesToUpdate[$bed_id][] = $category_id;
                
                // ✅ CRITICAL FIX: Delete ALL items for this suite ONCE (suite-level deletion)
                // This ensures when updating suite 309, we replace all its items, but don't touch suites 301, 302, 303
                // Only delete on first category encountered for this suite
                if (!empty($existingOrderData) && count($suitesToUpdate[$bed_id]) == 1) {
                    // ✅ CRITICAL SAFETY CHECK: Verify bed_id is valid and suite is actually being updated
                    if (empty($bed_id) || !is_numeric($bed_id) || $bed_id <= 0) {
                        log_message('error', "ORDER UPDATE BLOCKED: Invalid bed_id={$bed_id} for order_id={$order_id}. Skipping deletion to prevent data loss.");
                        continue;
                    }
                    
                    // ✅ CRITICAL SAFETY CHECK: Verify suite is in POST data (being updated)
                    if (!isset($suitesToUpdate[$bed_id]) || empty($suitesToUpdate[$bed_id])) {
                        log_message('error', "ORDER UPDATE BLOCKED: Suite {$bed_id} is NOT in POST data for order_id={$order_id}. Skipping deletion to prevent data loss.");
                        continue;
                    }
                    
                    // ✅ CRITICAL DEBUG: Log ALL suites BEFORE deletion
                    $allSuitesBefore = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
                        ->from('orders_to_patient_options')
                        ->where('order_id', $order_id)
                        ->group_by('bed_id')
                        ->get()
                        ->result_array();
                    log_message('info', "ORDER UPDATE: BEFORE deletion - Order {$order_id} has items for suites: " . json_encode($allSuitesBefore));
                    
                    // Delete ALL items for this specific suite (all categories)
                    $conditionsDelete = ['order_id' => $order_id, 'bed_id' => $bed_id];
                    log_message('info', "ORDER UPDATE: Deleting ALL existing items for order_id={$order_id}, bed_id={$bed_id} (Suite) before inserting new items. Other suites will NOT be affected.");
                    $this->common_model->commonRecordDeleteMultipleConditions('orders_to_comments', $conditionsDelete);
                    $this->common_model->commonRecordDeleteMultipleConditions('orders_to_patient_options', $conditionsDelete);
                    
                    // ✅ CRITICAL DEBUG: Log ALL suites AFTER deletion
                    $allSuitesAfter = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
                        ->from('orders_to_patient_options')
                        ->where('order_id', $order_id)
                        ->group_by('bed_id')
                        ->get()
                        ->result_array();
                    log_message('info', "ORDER UPDATE: AFTER deletion - Order {$order_id} has items for suites: " . json_encode($allSuitesAfter));
                    
                    // ✅ CRITICAL SAFETY CHECK: Verify no other suites were deleted
                    $suitesBefore = array_column($allSuitesBefore, 'bed_id');
                    $suitesAfter = array_column($allSuitesAfter, 'bed_id');
                    $deletedSuites = array_diff($suitesBefore, $suitesAfter);
                    $expectedDeleted = [$bed_id];
                    $unexpectedDeleted = array_diff($deletedSuites, $expectedDeleted);
                    
                    if (!empty($unexpectedDeleted)) {
                        log_message('error', "ORDER UPDATE ERROR: Unexpected suites deleted! Order {$order_id} - Expected to delete only suite {$bed_id}, but suites " . implode(', ', $unexpectedDeleted) . " were also deleted!");
                        log_message('error', "ORDER UPDATE ERROR: This indicates a CRITICAL BUG - suites not in POST were deleted!");
                    }
                }
                if (is_array($value)) {
                    foreach ($value as $option_id) {
                        if (!empty($option_id)) {
                            $bulkOptionsData[] = [
                                'order_id' => $order_id,
                                'bed_id' => $bed_id,
                                'patient_id' => $patientId, // ✅ Store patient ID
                                'category_id' => $category_id,
                                'menu_id' => $menu_id,
                                'option_id' => $option_id,
                                'quantity' => 1
                            ];
                        }
                    }
                } else {
                    if (!empty($value)) {
                        $bulkOptionsData[] = [
                            'order_id' => $order_id,
                            'bed_id' => $bed_id,
                            'patient_id' => $patientId, // ✅ Store patient ID
                            'category_id' => $category_id,
                            'menu_id' => $menu_id,
                            'option_id' => $value,
                            'quantity' => 1
                        ];
                    }
                }
            }
        }
    }

    // Handle notes for all beds (including those with only notes)
    foreach ($this->POST as $key => $value) {
        if (strpos($key, 'note_') === 0) {
            $bed_id = str_replace('note_', '', $key);
            if (!is_numeric($bed_id)) {
                continue;
            }
            
            // Track that this suite is being updated (has a note)
            if (!isset($suitesToUpdate[$bed_id])) {
                $suitesToUpdate[$bed_id] = [];
            }

            // ✅ CRITICAL FIX: When updating, delete existing comment first, then insert new one
            if (!empty($existingOrderData)) {
                $conditionsDelete = ['order_id' => $order_id, 'bed_id' => $bed_id];
                $this->common_model->commonRecordDeleteMultipleConditions('orders_to_comments', $conditionsDelete);
            }

            // Save comment even if no menu options selected
            $ordertoComments = [
                'order_id' => $order_id,
                'bed_id' => $bed_id,
                'order_comment' => $value
            ];
            $this->common_model->commonRecordCreate('orders_to_comments', $ordertoComments);
        }
    }
    
    // ✅ CRITICAL FIX: Log which suites were updated vs preserved
    if (!empty($existingOrderData) && !empty($order_id)) {
        $allExistingSuites = $this->tenantDb->select('bed_id, COUNT(*) as item_count')
            ->from('orders_to_patient_options')
            ->where('order_id', $order_id)
            ->group_by('bed_id')
            ->get()
            ->result_array();
        $existingSuiteIds = array_column($allExistingSuites, 'bed_id');
        $updatedSuiteIds = array_keys($suitesToUpdate);
        $preservedSuites = array_diff($existingSuiteIds, $updatedSuiteIds);
        
        log_message('info', "ORDER UPDATE SUMMARY: Order {$order_id} - Updated suites: " . implode(', ', $updatedSuiteIds) . " | Preserved suites: " . implode(', ', $preservedSuites));
        
        if (!empty($preservedSuites)) {
            log_message('info', "ORDER UPDATE: Preserved " . count($preservedSuites) . " existing suite(s) that were not in POST data: " . implode(', ', $preservedSuites));
        }
    }

    // Save menu options if any
    if (!empty($bulkOptionsData)) {
        // DEBUG: Log what we're about to save
        // Debug: Bulk insert
        // error_log("BULK INSERT: " . count($bulkOptionsData) . " items. First item: " . json_encode($bulkOptionsData[0]));
        $this->common_model->commonBulkRecordCreate('orders_to_patient_options', $bulkOptionsData);
        
        // ✅ CRITICAL: Create snapshot IMMEDIATELY after menu items are saved
        // This ensures snapshot includes all menu items
        // Note: $order_id should be available from the loop above (line 1903)
        if(isset($order_id) && $order_id && isset($_POST['buttonType']) && ($_POST['buttonType'] == 'sendorder' || $_POST['buttonType'] == 'update')) {
            try {
                $this->load->model('Snapshot_model');
                // Update snapshot if order exists, create new if not
                $snapshotId = $this->Snapshot_model->updateOrderSnapshot($order_id);
                if ($snapshotId) {
                    $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                    log_message('info', "ORDER SNAPSHOT CREATED: Snapshot ID={$snapshotId}, Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } else {
                    $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                    log_message('warning', "ORDER SNAPSHOT FAILED: Failed to create/update order snapshot for Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}. Order still succeeded. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            } catch (Exception $e) {
                // Snapshot failure should not break the order flow
                $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                log_message('error', "ORDER SNAPSHOT EXCEPTION: Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
            }
        } else {
            // Debug: Log why snapshot wasn't created
            log_message('debug', "ORDER SNAPSHOT SKIPPED: order_id=" . (isset($order_id) ? $order_id : 'NOT SET') . ", buttonType=" . (isset($_POST['buttonType']) ? $_POST['buttonType'] : 'NOT SET') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        }
    }
    
    // ✅ PERMANENT FIX: Update participating_suites AFTER menu items are saved
    // This ensures participating_suites reflects the actual suites with menu items
    // ✅ CRITICAL: Only update if order_id is valid and we're actually updating an order
    if (!empty($order_id) && is_numeric($order_id) && $order_id > 0) {
        // ✅ PERMANENT FIX: Verify order_id matches the order we're processing
        // This prevents updating wrong order if $order_id was corrupted
        $verifyOrder = $this->tenantDb->select('order_id, date, dept_id')
            ->from('orders')
            ->where('order_id', $order_id)
            ->where('date', $orderDate) // ✅ CRITICAL: Verify date matches!
            ->where('dept_id', $deptId) // ✅ CRITICAL: Verify dept matches!
            ->get()
            ->row();
        
        if ($verifyOrder) {
            try {
                $this->load->model('Floor_order_model');
                $result = $this->floor_order_model->updateFloorOrderSuites($order_id);
                if ($result) {
                    log_message('info', "✅ VERIFIED: Updated participating_suites for Order ID={$order_id}, Date={$orderDate}, Dept={$deptId}");
                } else {
                    log_message('error', "🚨 CRITICAL: updateFloorOrderSuites returned FALSE for Order ID={$order_id}. Update was blocked to prevent data loss!");
                }
            } catch (Exception $e) {
                log_message('error', "🚨 CRITICAL: Exception updating participating_suites for Order ID={$order_id} - " . $e->getMessage() . ". Stack trace: " . $e->getTraceAsString());
            }
        } else {
            log_message('error', "🚨 CRITICAL: Cannot update participating_suites - Order ID={$order_id} verification FAILED! Order not found for date={$orderDate}, dept={$deptId}. BLOCKING update to prevent data loss!");
        }
    } else {
        log_message('warning', "⚠️ WARNING: Skipping updateFloorOrderSuites - Invalid order_id: " . var_export($order_id, true));
    }
    
    // ✅ CRITICAL: Create snapshot even if no menu items were saved (empty order)
    // This ensures snapshot is created for all orders, even those with no items
    if(isset($order_id) && $order_id && isset($_POST['buttonType']) && ($_POST['buttonType'] == 'sendorder' || $_POST['buttonType'] == 'update')) {
        // Check if snapshot was already created above (if bulkOptionsData was not empty)
        // Only create if it wasn't created already
        try {
            $this->load->model('Snapshot_model');
            $existingSnapshot = $this->Snapshot_model->snapshotExists($order_id);
            if (!$existingSnapshot) {
                // Snapshot wasn't created above, create it now
                $snapshotId = $this->Snapshot_model->updateOrderSnapshot($order_id);
                if ($snapshotId) {
                    $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                    log_message('info', "ORDER SNAPSHOT CREATED (EMPTY ORDER): Snapshot ID={$snapshotId}, Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } else {
                    $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                    log_message('warning', "ORDER SNAPSHOT FAILED (EMPTY ORDER): Failed to create snapshot for Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            }
        } catch (Exception $e) {
            $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
            log_message('error', "ORDER SNAPSHOT EXCEPTION (EMPTY ORDER): Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        }
    }

    // EMAIL NOTIFICATION: Send email to chef about nurse portal order
    if($_POST['buttonType'] == 'sendorder' && !empty($processedBeds)) {
        // Determine if this is an update or new order
        $isUpdate = !empty($existingOrderData);
        
        // Get floor name
        $floorName = fetchDepartmentNameFromId($this->tenantDb, $this->session->userdata('department_id'));
        $orderDate = format_australia_date($orderData['date'], 'd-m-Y');
        
        // Create a summary of all suites in this order
        $suiteSummary = 'Multiple Suites (' . count($processedBeds) . ' suites)';
        
        // Collect order items with full details
        $orderItemsData = [];
        
        // Fetch menu details for the order
        $menuLists = $this->menu_model->fetchMenuDetails('', true);
        
        // Get allergens data
        $conditionsAllergen = ['listtype' => 'allergen'];
        $allergensData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsAllergen);
        
        // Build items array from POST data
        foreach ($this->POST as $key => $value) {
            if (is_numeric($key) && is_array($value)) {
                foreach ($value as $catAndMenuId => $orderSelectedMenuOptions) {
                    if (in_array($catAndMenuId, ['notes', 'buttonType']) || !is_array($orderSelectedMenuOptions)) {
                        continue;
                    }
                    
                    $CatMenuId = explode('_', $catAndMenuId);
                    if (count($CatMenuId) == 2) {
                        $category_id = $CatMenuId[0];
                        $menu_id = $CatMenuId[1];
                        
                        // Get category name
                        $categoryData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['name'], ['id' => $category_id]);
                        $categoryName = !empty($categoryData) ? $categoryData[0]['name'] : 'Unknown Category';
                        
                        if (!isset($orderItemsData[$categoryName])) {
                            $orderItemsData[$categoryName] = [];
                        }
                        
                        // Find menu details
                        foreach($menuLists as $menu) {
                            if ($menu['menu_id'] == $menu_id) {
                                foreach($menu['menu_options'] as $option) {
                                    if (in_array($option['option_id'], $orderSelectedMenuOptions)) {
                                        // Get allergens for this option
                                        $allergenNames = [];
                                        if (!empty($option['allergenValues'])) {
                                            $allergenIds = json_decode($option['allergenValues'], true);
                                            if (is_array($allergenIds) && !empty($allergenIds)) {
                                                foreach ($allergenIds as $allergenId) {
                                                    foreach ($allergensData as $allergen) {
                                                        if ($allergen['id'] == $allergenId) {
                                                            $allergenNames[] = $allergen['name'];
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                        // Check if this item already exists to avoid duplicates
                                        $itemKey = $menu['menu_name'] . '|' . $option['menu_option_name'];
                                        $itemExists = false;
                                        foreach ($orderItemsData[$categoryName] as $existingItem) {
                                            if ($existingItem['name'] . '|' . $existingItem['options'] == $itemKey) {
                                                $itemExists = true;
                                                break;
                                            }
                                        }
                                        
                                        if (!$itemExists) {
                                            $orderItemsData[$categoryName][] = [
                                                'name' => $menu['menu_name'],
                                                'options' => $option['menu_option_name'],
                                                'allergens' => implode(', ', $allergenNames),
                                                'comment' => '' // Item comments not available in this flow
                                            ];
                                        }
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }
        
        // Send email notification ONLY for late orders (after 10:32 AM AND for today's orders)
        if ($this->shouldSendLateOrderNotification($orderDate)) {
            log_message('info', "EMAIL NOTIFICATION TRIGGERED: Sending late order email notification for Nurse Portal Order ID={$order_id}, Suite Summary={$suiteSummary}, Order Date={$orderDate}, Timestamp=" . australia_datetime());
            $this->sendOrderNotificationEmail(
                $order_id,
                $floorName,
                $suiteSummary,
                $orderDate,
                $isUpdate,
                $orderItemsData
            );
        } else {
            log_message('info', "EMAIL NOTIFICATION SKIPPED: Not a late order (before 10:32 AM or not for today). Nurse Portal Order ID={$order_id}, Suite Summary={$suiteSummary}, Order Date={$orderDate}, Timestamp=" . australia_datetime());
        }
    }
    
    // ✅ CRITICAL: Create snapshot RIGHT BEFORE redirect (ensures it runs for ALL orders)
    // This is the FINAL snapshot creation point - runs after all menu items are saved
    // DEBUG: Log all variables to diagnose issue
    log_message('debug', "ORDER SNAPSHOT DEBUG (FINAL): order_id=" . (isset($order_id) ? $order_id : 'NOT SET') . ", buttonType=" . (isset($_POST['buttonType']) ? $_POST['buttonType'] : 'NOT SET') . ", orderDate=" . (isset($orderDate) ? $orderDate : 'NOT SET') . ", orderData[date]=" . (isset($orderData['date']) ? $orderData['date'] : 'NOT SET') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
    
    if(isset($order_id) && $order_id && isset($_POST['buttonType']) && ($_POST['buttonType'] == 'sendorder' || $_POST['buttonType'] == 'update')) {
        try {
            $this->load->model('Snapshot_model');
            // Update snapshot if order exists, create new if not
            $snapshotId = $this->Snapshot_model->updateOrderSnapshot($order_id);
            if ($snapshotId) {
                $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                log_message('info', "ORDER SNAPSHOT CREATED (FINAL): Snapshot ID={$snapshotId}, Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            } else {
                $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
                log_message('warning', "ORDER SNAPSHOT FAILED (FINAL): Failed to create snapshot for Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            }
        } catch (Exception $e) {
            $orderDateForLog = isset($orderData['date']) ? $orderData['date'] : (isset($orderDate) ? $orderDate : 'UNKNOWN');
            log_message('error', "ORDER SNAPSHOT EXCEPTION (FINAL): Nurse Portal Order ID={$order_id}, Order Date={$orderDateForLog}, Exception=" . $e->getMessage() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
        }
    } else {
        // Debug: Log why snapshot wasn't created
        log_message('warning', "ORDER SNAPSHOT SKIPPED (FINAL): order_id=" . (isset($order_id) ? $order_id : 'NOT SET') . ", buttonType=" . (isset($_POST['buttonType']) ? $_POST['buttonType'] : 'NOT SET') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
    }
    
    $this->session->set_flashdata('success', $successMessage);
    redirect('Orderportal/Home/index');
}
    
  
    // production form
    public function viewProductionForm($selectedDate = '') {
    
        
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        // Check if auto-print is requested - if so, default to TOMORROW's date
        $autoPrint = $this->input->get('autoPrint') === 'true';
        
        if (empty($selectedDate)) {
            // If auto-print is requested, default to TOMORROW's orders (not today's)
            if ($autoPrint) {
                $selectedDate = $this->getAustraliaDateOffset(1); // Tomorrow's date
            } else {
                $selectedDate = $this->getAustraliaDate(); // Today's date (normal behavior)
            }
        } else {
            // Validate date format - ensure it's YYYY-MM-DD
            $selectedDate = $this->getAustraliaDate($selectedDate);
        }
        
        $ordersItemInfo = $this->order_model->fetchOrderForChef($selectedDate);
        // Fetch suite + people summary (special instructions)
       $data['suiteSummary'] = $this->order_model->getSuiteSummary();

        
        // FIXED: Organize by: Category (Breakfast) > Subcategory (test, toast, condiments) > Items
        $output = [];

        foreach ($ordersItemInfo as $row) {
            $categoryId = $row['category_id'];
            $subcategoryName = !empty($row['food_category_name']) ? $row['food_category_name'] : 'Other Items';
            $menuItemName = $row['menu_item_name'];
            $optionId = $row['option_id'];

            // Initialize category if not set
            if (!isset($output[$categoryId])) {
                $output[$categoryId] = [
                    'name' => $row['category_name'],
                    'subcategories' => []
                ];
            }
            
            // Initialize subcategory if not set
            if (!isset($output[$categoryId]['subcategories'][$subcategoryName])) {
                $output[$categoryId]['subcategories'][$subcategoryName] = [
                    'items' => []
                ];
            }
            
            // Store the item data
            $output[$categoryId]['subcategories'][$subcategoryName]['items'][$optionId] = [
                'menu_id'          => (int)$row['menu_id'],
                'option_id'        => $optionId,
                'menu_item_name'   => $menuItemName,
                'menu_option_name' => $row['menu_option_name'],
                'menu_colour' => $row['menu_color'],
                'subcategory_name' => $subcategoryName,
                'qty'              => (int)$row['total_qty'], // Pending quantity
                'completed_qty'    => (int)$row['completed_qty'], // Completed quantity
                'all_qty'          => (int)$row['all_qty'], // Total quantity
                'bed_count'        => (int)$row['bed_count'],
                'bed_details'      => $row['bed_quantities'],
                'is_completed'     => (int)$row['is_completed']
            ];
             
              
        }
        
     
             

        // Fetch metrics for the selected date (consolidated across all floors)
        $metrics = $this->getProductionFormMetrics($selectedDate);
        
        // Check if viewing future date (read-only mode) - use Australia/Sydney timezone
        $todayAustralia = $this->getAustraliaDate();
        $isReadOnly = (strtotime($selectedDate) > strtotime($todayAustralia));
        
        $data['orders'] = $output;
        $data['orderWithNotes']  = $this->order_model->fetchOrderWithOrderNotes($selectedDate);
        $data['itemComments'] = $this->order_model->fetchItemSpecificComments($selectedDate);
        $data['metrics'] = $metrics;
        $data['selectedDate'] = $selectedDate;
        $data['isReadOnly'] = $isReadOnly;
        
        $conditionsC = array('is_deleted' => 0 ,'listtype' => 'category');
        $data['categories'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditionsC);
        
        // echo "<pre>"; print_r($data['orderWithNotes']); exit;
        $this->load->view('general/header');
        $this->load->view('Orders/viewPatientOrder', $data);
        $this->load->view('general/footer');
    }
    
    /**
     * Get metrics for production form
     * Consolidated across all floors with 100% accuracy
     * @param string $date - The date to calculate metrics for
     * @param int|null $deptId - Optional department ID to filter by. If null, calculates for all departments
     */
    private function getProductionFormMetrics($date, $deptId = null) {
        // Total active patients in occupied suites for the selected date (1:1 relationship)
        // FIXED: Exclude patients being discharged ON this date (use > not >=)
        // ✅ FIX: Add department filter if provided
        $deptFilter = '';
        $deptParams = [];
        if ($deptId !== null) {
            $deptFilter = 'AND s.floor = ?';
            $deptParams[] = $deptId;
        }
        
      $totalPatients = $this->tenantDb
    ->where('is_vaccant', 0)
    ->where('is_deleted', 0)
    ->where('status', 1)
    ->count_all_results('suites');

        
        // Occupied suites for the selected date (should match total_patients)
        // Uses the SAME logic to ensure 1:1 accuracy
        $occupiedSuites = $totalPatients;
        
        // Count unique suites/patients that have placed orders for this date (across all floors or specific department)
        // ✅ CRITICAL FIX: Only count suites with valid suite_order_details to prevent orphaned items from inflating count
        // ✅ CRITICAL FIX: Exclude deleted suites (is_deleted = 1) and vacant suites (is_vaccant = 1)
        // ✅ CRITICAL FIX: Exclude orders from suites where patient is discharged on/before the order date
        // ✅ FIX: Add department filter if provided
        $orderDeptFilter = '';
        $orderDeptParams = [];
        if ($deptId !== null) {
            $orderDeptFilter = 'AND o.dept_id = ?';
            $orderDeptParams[] = $deptId;
        }
        
        $suitesWithOrders = $this->tenantDb->query("
            SELECT COUNT(DISTINCT opo.bed_id) as count
            FROM orders o
            INNER JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
            INNER JOIN suites s ON s.id = opo.bed_id
            INNER JOIN people p ON p.suite_number = s.id AND p.status = 1
            LEFT JOIN suite_order_details sod ON sod.id = opo.suite_order_detail_id
            WHERE o.date = ?
            AND o.buttonType = 'sendorder'
            AND o.status != 0
            -- ✅ CRITICAL: Exclude deleted suites
            AND s.is_deleted = 0
            -- ✅ CRITICAL: Exclude vacant suites (only count occupied suites)
            AND s.is_vaccant = 0
            -- ✅ CRITICAL: Only count active suites
            AND s.status = 1
            AND (p.date_of_discharge IS NULL OR p.date_of_discharge > ?)
            $orderDeptFilter
            AND (
                -- For non-floor-consolidated orders: count if suite_order_detail_id is NULL/0 (legacy) OR valid
                (o.is_floor_consolidated != 1 AND (
                    opo.suite_order_detail_id IS NULL 
                    OR opo.suite_order_detail_id = 0 
                    OR (sod.id IS NOT NULL AND sod.status = 'active')
                ))
                OR
                -- For floor-consolidated orders: MUST have valid suite_order_details
                (o.is_floor_consolidated = 1 AND sod.id IS NOT NULL AND sod.status = 'active' AND sod.floor_order_id = o.order_id AND sod.suite_id = opo.bed_id)
            )
            -- ✅ CRITICAL: Exclude orphaned items (items with wrong suite_order_detail_id)
            AND (
                opo.suite_order_detail_id IS NULL 
                OR opo.suite_order_detail_id = 0
                OR (sod.id IS NOT NULL AND sod.floor_order_id = o.order_id AND sod.suite_id = opo.bed_id)
            )
        ", array_merge([$date, $date], $orderDeptParams))->row()->count;
        
        // ✅ CRITICAL FIX: Ensure suitesWithoutOrders is never negative
        // Suites WITHOUT orders = Total Patients - Suites With Orders
        $suitesWithoutOrders = max(0, $totalPatients - $suitesWithOrders);
        
        return [
            'total_patients' => $totalPatients,
            'suites_with_orders' => $suitesWithOrders,
            'suites_without_orders' => $suitesWithoutOrders,
            'occupied_suites' => $occupiedSuites
        ];
    }

    
    public function viewOrderPatientwise($type = '', $deptId = null, $displayDeliveredInfo = false) {
    // 🆕 DATE SELECTOR FEATURE: Always default to today, only change if button clicked
    // CRITICAL FIX: Use Australia/Sydney timezone for date operations
    $viewDate = $this->getAustraliaDate(); // Always default to today in Australia/Sydney timezone
    
    // Check if user clicked a date button (only for this request)
    if ($this->input->post('switch_to_date')) {
        $viewDate = $this->getAustraliaDate($this->input->post('switch_to_date'));
    }
    
    // Determine if viewing tomorrow (for read-only mode) - use Australia/Sydney timezone
    $isTomorrow = ($viewDate === $this->getAustraliaTomorrow());
    $isToday = ($viewDate === $this->getAustraliaDate());
    
    // Fetch allergens data for displaying allergen information in print
    $conditionsAllergen = ['listtype' => 'allergen'];
    $allergensData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsAllergen);
    
    // Fetch cuisine data for displaying dietary preferences in print
    $conditionsCuisine = ['listtype' => 'cuisine', 'is_deleted' => '0'];
    $cuisineData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsCuisine);

    // Fetch menu planner for selected date - try published first, then saved
    // ✅ MENU IS ALWAYS COMMON FOR ALL: department_id = 0 is the common menu for all departments
    $requestedDeptId = $deptId; // preserve requested floor for display purposes
    
    $conditionsM = [
        'date' => $viewDate,
        'department_id' => 0, // Always use common menu (department_id = 0)
        'status' => 2
    ];
    $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);

    // If no published menu found, try saved menus (status = 1)
    if (empty($savedData)) {
        $conditionsM = [
            'date' => $viewDate,
            'department_id' => 0, // Always use common menu (department_id = 0)
            'status' => 1
        ];
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);
    }

    $savedMenus = [];
    $selectedDepartments = [];
    if (!empty($savedData)) {
        // Check if this is weekly menu data (stored in menuData field) or daily menu data (menuWithOptions field)
        if (!empty($savedData[0]['menuWithOptions'])) {
            // Daily menu planner data
            $savedMenus = unserialize($savedData[0]['menuWithOptions']) ?: [];
        } elseif (!empty($savedData[0]['menuData'])) {
            // Weekly menu planner data - needs transformation
            $weeklyMenuData = unserialize($savedData[0]['menuData']) ?: [];
            $savedMenus = $this->transformWeeklyMenuDataForOrders($weeklyMenuData);
        }
        $selectedDepartments = explode(',', $savedData[0]['department_id']) ?: [];
    }
    $data['savedMenus'] = $savedMenus;
    $data['selectedDepartments'] = $selectedDepartments;

    // Fetch orders for the selected date (orders placed for this date's delivery)
    $conditionsO = [
        'date' => $viewDate,
        'buttonType' => 'sendorder',
        'dept_id' => $requestedDeptId
    ];
    $todaysOrders = $this->common_model->fetchRecordsDynamically(
        'orders',
        ['order_id', 'is_delivered', 'buttonType', 'is_floor_consolidated'],
        $conditionsO
    );

    $patientOrderData = [];
    $orderMenuOptions = [];
    $orderCommentBedWise = [];
    $BednNotes = [];
    $orderId = '';

    if (!empty($todaysOrders)) {
        $orderId = $todaysOrders[0]['order_id'];
        $isFloorConsolidated = !empty($todaysOrders[0]['is_floor_consolidated']) && $todaysOrders[0]['is_floor_consolidated'] == 1;
        
        // Use appropriate fetch method based on order type
        if ($isFloorConsolidated) {
            $orderMenuOptions = $this->order_model->fetchFloorOrderAndMenuOptions($orderId);
        } else {
            $orderMenuOptions = $this->order_model->fetchOrderAndMenuOptions($orderId);
        }
    }
    
    // ✅ PATIENT ID FIX: Fetch common data WITH orderId so patient info comes from order
    $result = $this->commonData($deptId, $orderId);
    
    // 🔒 FILTER: Show only occupied suites (suites with patients)
    // This ensures we only display rows for suites that have patients assigned
    $bedLists = $result['bedLists'];
    $occupiedBedLists = [];
    if (!empty($bedLists)) {
        foreach ($bedLists as $bedList) {
            // Only include suites that have a patient_name (occupied suites)
            if (!empty($bedList['patient_name'])) {
                $occupiedBedLists[] = $bedList;
            }
        }
    }
    
    // ✅ FIX: Use the same metrics calculation as Production Form for consistency
    // Pass deptId to filter by department if viewing a specific department
    $metrics = $this->getProductionFormMetrics($viewDate, $deptId);
    
    $data = [
        'menuLists' => $result['menuLists'],
        'bedLists' => $occupiedBedLists, // 🔒 Only occupied suites
        'categoryListData' => $result['categoryListData'],
        'allergensData' => $allergensData,
        'cuisineData' => $cuisineData,
        'savedMenus' => $savedMenus, // ✅ FIX: Include savedMenus
        'selectedDepartments' => $selectedDepartments, // ✅ FIX: Include selectedDepartments
        'deptId' => $deptId,
        'date' => format_australia_date($viewDate, 'd-m-Y'),
        'viewDate' => $viewDate,
        'isTomorrow' => $isTomorrow,
        'isToday' => $isToday,
        'displayDeliveredInfo' => $displayDeliveredInfo,
        'metrics' => $metrics // ✅ FIX: Pass metrics to view for consistent calculation
    ];
    
    if (!empty($todaysOrders)) {

        foreach ($orderMenuOptions as $opt) {
            $orderData = unserialize($opt['order_data'] ?? '') ?: [];
            $orderCommentBedWise[$opt['bed_id']] = $opt['order_comment'] ?? '';
            // bedNote field doesn't exist in database, using order_comment for now
            $BednNotes[$opt['bed_id']] = $opt['order_comment'] ?? '';
            
            // FIXED: Create proper data structure based on the view type
            $bedId = $opt['bed_id'];
            $categoryId = $opt['category_id'];
            $menuId = $opt['menu_id'];
            
            if ($type == 'delivery') {
                // For delivery page: use bed_id_category_id format
                $nameIndex = $bedId . '_' . $categoryId;
                if (!isset($patientOrderData[$nameIndex])) {
                    $patientOrderData[$nameIndex] = [];
                }
                if (!in_array($menuId, $patientOrderData[$nameIndex])) {
                    $patientOrderData[$nameIndex][] = $menuId;
                }
            } else {
                // For chef production form: use bed_id_category_id_menu_id format
                $nameIndex = $bedId . '_' . $categoryId . '_' . $menuId;
                if (!isset($patientOrderData[$nameIndex])) {
                    $patientOrderData[$nameIndex] = [];
                }
                // Add option_id to the array
                if (!in_array($opt['option_id'], $patientOrderData[$nameIndex])) {
                    $patientOrderData[$nameIndex][] = $opt['option_id'];
                }
            }
            
            // Also merge any serialized order data from the database
            if (!empty($orderData)) {
                foreach ($orderData as $dataKey => $dataValue) {
                    if ($dataKey !== 'buttonType' && $dataKey !== 'notes') {
                        // Extract category_menu format like "70_29"
                        if (strpos($dataKey, '_') !== false && is_array($dataValue)) {
                            list($catId, $menuId) = explode('_', $dataKey);
                            // Create the correct nameIndex for this category
                            $serializedNameIndex = $bedId . '_' . $catId;
                            if (!isset($patientOrderData[$serializedNameIndex])) {
                                $patientOrderData[$serializedNameIndex] = [];
                            }
                            if (!in_array($menuId, $patientOrderData[$serializedNameIndex])) {
                                $patientOrderData[$serializedNameIndex][] = $menuId;
                            }
                        }
                    }
                }
            }
        }
    }

    // Fetch delivery status (legacy)
    $conditionsO = [
        'date' => $viewDate, // Use selected date to match what markACategoryDelivered saves
        'order_id' => $orderId
    ];
    $alreadyDeliveredCategory = $this->common_model->fetchRecordsDynamically('order_to_category_deliverystatus', ['category_id'], $conditionsO);
    $alreadyDeliveredCategory = !empty($alreadyDeliveredCategory) ? array_column($alreadyDeliveredCategory, 'category_id') : [];

    $conditionsDPW = ['order_id' => $orderId];
    $alreadyDeliveredCategoryPatientWise = $this->common_model->fetchRecordsDynamically('orders_to_deliverystatus', ['category_id', 'bed_id'], $conditionsDPW);
    $alreadyDeliveredCategoryPatientIds = array_map(function($item) {
        return $item['bed_id'] . '_' . $item['category_id'];
    }, $alreadyDeliveredCategoryPatientWise);
    
    // Fetch package status (new system)
    $alreadyPackagedCategory = [];
    $alreadyPackagedCategoryPatientIds = [];
    
    // Check if package tables exist before querying
    if ($this->tenantDb->table_exists('order_to_category_packagestatus')) {
        $conditionsPackageO = [
            'date' => $viewDate,
            'order_id' => $orderId
        ];
        $alreadyPackagedCategoryData = $this->common_model->fetchRecordsDynamically('order_to_category_packagestatus', ['category_id'], $conditionsPackageO);
        $alreadyPackagedCategory = !empty($alreadyPackagedCategoryData) ? array_column($alreadyPackagedCategoryData, 'category_id') : [];
    }
    
    // Fetch packaged items with temperature and notes
    $packagedItemsData = [];
    if ($this->tenantDb->table_exists('orders_to_packagestatus')) {
        $conditionsPackagePW = ['order_id' => $orderId];
        $alreadyPackagedCategoryPatientWise = $this->common_model->fetchRecordsDynamically('orders_to_packagestatus', ['category_id', 'bed_id', 'temperature', 'notes'], $conditionsPackagePW);
        $alreadyPackagedCategoryPatientIds = array_map(function($item) {
            return $item['bed_id'] . '_' . $item['category_id'];
        }, $alreadyPackagedCategoryPatientWise);
        
        // Create a lookup array for temperature and notes
        foreach ($alreadyPackagedCategoryPatientWise as $packagedItem) {
            $key = $packagedItem['bed_id'] . '_' . $packagedItem['category_id'];
            $packagedItemsData[$key] = [
                'temperature' => $packagedItem['temperature'] ?? '',
                'notes' => $packagedItem['notes'] ?? ''
            ];
        }
    }
    
    // Merge delivered and packaged for backward compatibility
    $alreadyDeliveredCategory = array_unique(array_merge($alreadyDeliveredCategory, $alreadyPackagedCategory));
    $alreadyDeliveredCategoryPatientIds = array_unique(array_merge($alreadyDeliveredCategoryPatientIds, $alreadyPackagedCategoryPatientIds));

    // Validation: Don't allow access to delivery page if essential data is missing
    if ($type == 'delivery') {
        $errors = [];
        
        // CRITICAL FIX: Check for TODAY's menu data (delivery date for staff)
        // Staff view delivery page to package TODAY's orders, not tomorrow's
        if (empty($savedMenus)) {
            $todayFormatted = format_australia_date($viewDate, 'd-m-Y');
            $errors[] = "No menu data found for today (" . $todayFormatted . "). Please ensure a menu plan is created and published for today's delivery date.";
        }
        
        // CRITICAL FIX: Check for TODAY's orders (package date for staff)
        if (empty($todaysOrders)) {
            $todayFormatted = format_australia_date($viewDate, 'd-m-Y');
            $errors[] = "No orders found for today (" . $todayFormatted . "). Orders must be placed before package tracking can be used.";
        }
        
        // Check if we have a valid order ID
        if (empty($orderId)) {
            $errors[] = "No valid order ID found. This is required for package tracking to function properly.";
        }
        
        // If there are any errors, show error page instead of broken package page
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $data['error_title'] = 'Order Package Information Not Available';
            $data['error_message'] = 'The package tracking system cannot be accessed at this time due to the following issues:';
            
            $this->load->view('general/header');
            $this->load->view('Orders/deliveryErrorPage', $data);
            $this->load->view('general/footer');
            return;
        }
    }

    // DEBUGGING: Log data structure for troubleshooting
    if (empty($patientOrderData)) {
        log_message('debug', 'Order Package Page: No patient order data found for order_id: ' . $orderId);
        log_message('debug', 'Order Menu Options count: ' . count($orderMenuOptions));
        if (!empty($orderMenuOptions)) {
            log_message('debug', 'First order menu option: ' . json_encode($orderMenuOptions[0]));
        }
    } else {
        log_message('debug', 'Order Package Page: Patient order data keys: ' . implode(', ', array_keys($patientOrderData)));
        log_message('debug', 'Order Package Page: Patient order data: ' . json_encode($patientOrderData));
    }
    

    // Assign data to view
    $data['orderId'] = $orderId;
    $data['orderMenuOptions'] = $orderMenuOptions;
    $data['patientOrderData'] = $patientOrderData;
    $data['orderCommentBedWise'] = $orderCommentBedWise;
    $data['bednNotes'] = $BednNotes;
    $data['alreadyDeliveredCategory'] = $alreadyDeliveredCategory;
    $data['alreadyDeliveredCategoryAndPatient'] = $alreadyDeliveredCategoryPatientIds;
    $data['packagedItemsData'] = $packagedItemsData; // Pass temperature and notes data

    // Load views
    $this->load->view('general/header');
    if ($type == 'delivery') {
        $this->load->view('Orders/orderDeliverypage', $data);
    } else {
        $this->load->view('Orders/viewOrderPatientwise', $data);
    }
    $this->load->view('general/footer');
}
    
    function markFoodCompleted(){
        $option_id = $this->input->post('option_id'); // Changed from menu_id to option_id
        $order_id = $this->input->post('order_id');
        $notes = $this->input->post('notes'); // Chef notes
        
        // Validation
        if (empty($option_id) || empty($order_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required parameters: option_id=' . $option_id . ', order_id=' . $order_id]);
            return;
        }
        
        try {
            // FIXED FOR CONSOLIDATED PRODUCTION FORM: Find ALL orders for today that have this option_id
            // This ensures when chef marks an item complete in consolidated view, it updates ALL floors
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            $today = $this->getAustraliaDate();
            $sql = "SELECT DISTINCT o.order_id 
                    FROM orders o
                    INNER JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
                    WHERE o.date = ?
                    AND o.buttonType = 'sendorder'
                    AND o.status != 0
                    AND opo.option_id = ?
                    AND opo.status = 0";
            
            $query = $this->tenantDb->query($sql, [$today, $option_id]);
            $all_orders = $query->result_array();
            
            if (empty($all_orders)) {
                echo json_encode(['status' => 'error', 'message' => 'No pending records found for option_id=' . $option_id . ' for today']);
                return;
            }
            
            $updated_orders = [];
            $total_records_updated = 0;
            
            // Update the item in ALL orders (all floors)
            foreach ($all_orders as $order) {
                $current_order_id = $order['order_id'];
                
                // Update all records with this option_id and order_id to completed status
                $fields = array(
                    'option_id' => $option_id,
                    'order_id' => $current_order_id,
                    'status' => 0 // Only update incomplete items
                );
                $update_data = array('status' => 1);
                
                $result = $this->common_model->commonRecordUpdateMultipleConditions('orders_to_patient_options', $fields, $update_data);
                
                if ($result !== false) {
                    $total_records_updated += $result;
                    $updated_orders[] = $current_order_id;
                    
                    // NOTIFICATION: Menu item completed by chef
                    $this->createMenuItemCompletionNotification($current_order_id, $option_id, $notes);
                    
                    // Check if all items for this order are now complete
                    $this->checkAndCompleteOrder($current_order_id);
                    
                    // If chef added notes, save them as a comment for this order
                    if (!empty($notes)) {
                        // Get the menu_id and bed_id for this option_id from the order
                        $orderItem = $this->common_model->fetchRecordsDynamically(
                            'orders_to_patient_options',
                            ['menu_id', 'bed_id'],
                            [
                                'order_id' => $current_order_id,
                                'option_id' => $option_id
                            ]
                        );
                        
                        if (!empty($orderItem)) {
                            $orderItem = $orderItem[0]; // Get first record
                            
                            // Save chef's notes as a comment
                            $commentData = [
                                'order_id' => $current_order_id,
                                'bed_id' => $orderItem['bed_id'],
                                'menu_id' => $orderItem['menu_id'],
                                'option_id' => $option_id,
                                'comment' => $notes,
                                'added_by' => $this->session->userdata('user_id') ?? 0,
                                'added_by_role' => 'chef',
                                'created_at' => australia_datetime()
                            ];
                            
                            $this->tenantDb->insert('menu_item_comments', $commentData);
                        }
                    }
                }
            }
            
            // Return success with info about all updated orders
            echo json_encode([
                'status' => 'success', 
                'message' => 'Menu item completed successfully for ALL floors!' . (!empty($notes) ? ' Chef notes saved.' : ''),
                'orders_updated' => count($updated_orders),
                'order_ids' => $updated_orders,
                'total_records_updated' => $total_records_updated
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Check if all menu items for an order are complete and update order status accordingly
     */
    function checkAndCompleteOrder($order_id) {
        // Check if all menu items for this order are complete
        $incomplete_items = $this->common_model->fetchRecordsDynamically(
            'orders_to_patient_options', 
            ['id'], 
            ['order_id' => $order_id, 'status' => 0]
        );
        
        if (empty($incomplete_items)) {
            // All items complete - mark order as ready for delivery
            $update_data = [
                'status' => 3 // Ready for Delivery
            ];
            $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $update_data);
            
            // NOTIFICATION: Order ready for delivery
            $this->createOrderReadyNotification($order_id);
            
            // Log the status change
            $this->logOrderStatusChange($order_id, 1, 3, 'All menu items completed by chef');
        }
    }
    
    /**
     * Create notification when a menu item is completed by chef
     */
    private function createMenuItemCompletionNotification($order_id, $option_id, $notes = '') {
        try {
            // Get order and menu item details
            $orderDetails = $this->common_model->fetchRecordsDynamically(
                'orders', 
                ['dept_id', 'bed_id', 'date'], 
                ['order_id' => $order_id]
            );
            
            if (empty($orderDetails)) return;
            
            $orderDetail = $orderDetails[0];
            
            // Get floor name
            $floorInfo = $this->common_model->fetchRecordsDynamically(
                'foodmenuconfig', 
                ['name'], 
                ['id' => $orderDetail['dept_id'], 'listtype' => 'floor']
            );
            $floorName = !empty($floorInfo) ? $floorInfo[0]['name'] : "Floor {$orderDetail['dept_id']}";
            
            // Get suite number
            $suiteInfo = $this->common_model->fetchRecordsDynamically(
                'suites', 
                ['bed_no'], 
                ['id' => $orderDetail['bed_id']]
            );
            $suiteNo = !empty($suiteInfo) ? $suiteInfo[0]['bed_no'] : $orderDetail['bed_id'];
            
            // Get menu item name
            $menuItemInfo = $this->common_model->fetchRecordsDynamically(
                'menu_options', 
                ['menu_option_name'], 
                ['id' => $option_id]
            );
            $menuItemName = !empty($menuItemInfo) ? $menuItemInfo[0]['menu_option_name'] : 'Menu Item';
            
            $userName = $this->session->userdata('username') ?: 'Chef';
            $notesText = !empty($notes) ? " with notes: \"{$notes}\"" : '';
            
            $msg = "Kitchen Update: {$userName} completed '{$menuItemName}' for Suite {$suiteNo} on {$floorName}{$notesText}.";
            
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'success', $msg);
            
        } catch (Exception $e) {
            error_log('Error creating menu item completion notification: ' . $e->getMessage());
        }
    }

    /**
     * Create notification when order is ready for delivery
     */
    private function createOrderReadyNotification($order_id) {
        try {
            // Get order details
            $orderDetails = $this->common_model->fetchRecordsDynamically(
                'orders', 
                ['dept_id', 'bed_id', 'date', 'is_floor_consolidated'], 
                ['order_id' => $order_id]
            );
            
            if (empty($orderDetails)) return;
            
            $orderDetail = $orderDetails[0];
            
            // Get floor name
            $floorInfo = $this->common_model->fetchRecordsDynamically(
                'foodmenuconfig', 
                ['name'], 
                ['id' => $orderDetail['dept_id'], 'listtype' => 'floor']
            );
            $floorName = !empty($floorInfo) ? $floorInfo[0]['name'] : "Floor {$orderDetail['dept_id']}";
            
            // Get suite number
            $suiteInfo = $this->common_model->fetchRecordsDynamically(
                'suites', 
                ['bed_no'], 
                ['id' => $orderDetail['bed_id']]
            );
            $suiteNo = !empty($suiteInfo) ? $suiteInfo[0]['bed_no'] : $orderDetail['bed_id'];
            
            // Count completed items
            $completedItems = $this->common_model->fetchRecordsDynamically(
                'orders_to_patient_options', 
                ['id'], 
                ['order_id' => $order_id, 'status' => 1]
            );
            $itemCount = count($completedItems);
            
            $orderType = !empty($orderDetail['is_floor_consolidated']) && $orderDetail['is_floor_consolidated'] == 1 
                ? 'Floor Order' : 'Suite Order';
            
            $msg = "🍽️ Ready for Delivery: {$orderType} #{$order_id} for Suite {$suiteNo} on {$floorName} is complete ({$itemCount} items). Awaiting delivery.";
            
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'warning', $msg);
            
        } catch (Exception $e) {
            error_log('Error creating order ready notification: ' . $e->getMessage());
        }
    }

    /**
     * Log order status changes for audit trail
     */
    function logOrderStatusChange($order_id, $old_status, $new_status, $reason = '') {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        $user_id = $this->session->userdata('user_id') ?: 0;
        $username = $this->session->userdata('username') ?: 'System';
        
        $log_data = [
            'order_id' => $order_id,
            'old_status' => $old_status,
            'new_status' => $new_status,
            'reason' => $reason,
            'changed_by' => $user_id,
            'changed_date' => australia_datetime()
        ];
        
        // Create order_status_log table if it doesn't exist (will fail silently if exists)
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS order_status_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            old_status INT,
            new_status INT,
            reason TEXT,
            changed_by INT,
            changed_date DATETIME,
            INDEX idx_order_id (order_id)
        )");
        
        $result = $this->common_model->commonRecordCreate('order_status_log', $log_data);
        $log_id = $this->tenantDb->insert_id();
        
        if ($result && $log_id) {
            log_message('info', "ORDER STATUS LOG CREATED: Log ID={$log_id}, Order ID={$order_id}, Old Status=" . ($old_status ?? 'NULL') . ", New Status={$new_status}, Reason=" . substr($reason, 0, 100) . (strlen($reason) > 100 ? '...' : '') . ", Changed By={$username} (ID={$user_id}), IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        } else {
            log_message('error', "ORDER STATUS LOG FAILED: Could not create status log for Order ID={$order_id}, Old Status=" . ($old_status ?? 'NULL') . ", New Status={$new_status}, Changed By={$username} (ID={$user_id}), IP=" . $this->input->ip_address() . " at " . australia_datetime());
        }
        
        // NOTIFICATION: Order Status Change - notify admin/chef about status updates
        if($new_status && $new_status != $old_status) {
            $statusText = $this->getOrderStatusText($new_status);
            $oldStatusText = $old_status ? $this->getOrderStatusText($old_status) : 'New';
            
            // Only notify for important status changes
            if(in_array($new_status, [3, 4, 5])) { // Ready for Delivery, Delivered, Complete
                $msg = "Order status updated: Order #{$order_id} changed from {$oldStatusText} to {$statusText} by {$username}. {$reason}";
                createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
            }
        }
    }
    
    // update if food has been delivered for a particular patient
    function markDelivered(){
         $bed_id = $this->input->post('bed_id');
         $category_id = $this->input->post('category_id');
         $order_id = $this->input->post('order_id');
         
         // Validation: Check if required data is present
         if (empty($order_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Order ID is required but not found. Please refresh the page and try again.']);
             return;
         }
         
         if (empty($bed_id) || empty($category_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Missing required delivery information.']);
             return;
         }
         
         $data['category_id'] = $category_id;
         $data['order_id'] = $order_id;
         $data['bed_id'] = $bed_id;
        
         $result = $this->common_model->commonRecordCreate('orders_to_deliverystatus', $data);
         
         if ($result) {
             // NOTIFICATION: Item Delivered - notify admin about delivery completion with floor info
             $bedInfo = $this->common_model->fetchRecordsDynamically('suites', ['bed_no', 'dept_id'], ['id' => $bed_id]);
             $categoryInfo = $this->common_model->fetchRecordsDynamically('categories', ['category_name'], ['id' => $category_id]);
             
             $bedNo = $bedInfo[0]['bed_no'] ?? 'Unknown Suite';
             $categoryName = $categoryInfo[0]['category_name'] ?? 'Unknown Category';
             $userName = $this->session->userdata('username') ?: 'Unknown User';
             
             // Get floor name
             $floorName = "Floor";
             if (!empty($bedInfo[0]['dept_id'])) {
                 $floorInfo = $this->common_model->fetchRecordsDynamically(
                     'foodmenuconfig', 
                     ['name'], 
                     ['id' => $bedInfo[0]['dept_id'], 'listtype' => 'floor']
                 );
                 $floorName = !empty($floorInfo) ? $floorInfo[0]['name'] : "Floor {$bedInfo[0]['dept_id']}";
             }
             
             $msg = "✅ Delivery Completed: {$userName} delivered '{$categoryName}' to Suite {$bedNo} on {$floorName}. Order #{$order_id} item completed.";
             createNotification($this->tenantDb, 1, $this->selected_location_id, 'success', $msg);
             
             echo json_encode(['status' => 'success', 'message' => 'Delivery status updated successfully!']);
         } else {
             echo json_encode(['status' => 'error', 'message' => 'Failed to update delivery status. Please try again.']);
         }
    }
    
    // like when breakfast or lunch or dinner has been delivered for all patients
    function markACategoryDelivered(){
         
         $category_id = $this->input->post('category_id');
         $order_id = $this->input->post('order_id');
         
         // Validation: Check if required data is present
         if (empty($order_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Order ID is required but not found. Please refresh the page and try again.']);
             return;
         }
         
         if (empty($category_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Category ID is required.']);
             return;
         }
         
         $data['category_id'] = $category_id;
         $data['order_id'] = $order_id;
         $data['status'] = 1;
         $data['date'] = australia_date_only();
        
         $result = $this->common_model->commonRecordCreate('order_to_category_deliverystatus', $data);
         
         if ($result) {
             // Check if all categories for this order are now delivered
             $this->checkAndMarkOrderDelivered($order_id);
             echo json_encode(['status' => 'success', 'message' => 'Category marked as delivered successfully!']);
         } else {
             echo json_encode(['status' => 'error', 'message' => 'Failed to mark category as delivered. Please try again.']);
         }
    }
    
    // New method for packaging items (replaces markDelivered)
    function markPackaged(){
         $bed_id = $this->input->post('bed_id');
         $category_id = $this->input->post('category_id');
         $order_id = $this->input->post('order_id');
         $temperature = $this->input->post('temperature');
         $notes = $this->input->post('notes');
         
         // Validation: Check if required data is present
         if (empty($order_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Order ID is required but not found. Please refresh the page and try again.']);
             return;
         }
         
         if (empty($bed_id) || empty($category_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Missing required package information.']);
             return;
         }
         
         $data['category_id'] = $category_id;
         $data['order_id'] = $order_id;
         $data['bed_id'] = $bed_id;
         $data['temperature'] = $temperature; // Store temperature
         $data['notes'] = $notes; // Store notes
         $data['packaged_at'] = australia_datetime(); // Timestamp when packaged
        
        // First check if table exists, if not create it
        if (!$this->tenantDb->table_exists('orders_to_packagestatus')) {
            $this->createPackageStatusTable();
        } else {
            // Check if notes column exists, if not add it
            $query = $this->tenantDb->query("SHOW COLUMNS FROM orders_to_packagestatus LIKE 'notes'");
            if ($query->num_rows() == 0) {
                $this->tenantDb->query("ALTER TABLE orders_to_packagestatus ADD COLUMN notes TEXT NULL AFTER temperature");
            }
        }
        
        $result = $this->common_model->commonRecordCreate('orders_to_packagestatus', $data);
         
         if ($result) {
             // NOTIFICATION: Item Packaged - notify admin about package completion with floor info
             $bedInfo = $this->common_model->fetchRecordsDynamically('suites', ['bed_no', 'floor'], ['id' => $bed_id]);
             $categoryInfo = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['name'], ['id' => $category_id]);
             
             $bedNo = $bedInfo[0]['bed_no'] ?? 'Unknown Suite';
             $categoryName = $categoryInfo[0]['name'] ?? 'Unknown Category';
             $userName = $this->session->userdata('username') ?: 'Unknown User';
             
             // Get floor name
             $floorName = "Floor";
             if (!empty($bedInfo[0]['floor'])) {
                 $floorInfo = $this->common_model->fetchRecordsDynamically(
                     'foodmenuconfig', 
                     ['name'], 
                     ['id' => $bedInfo[0]['floor'], 'listtype' => 'floor']
                 );
                 $floorName = !empty($floorInfo) ? $floorInfo[0]['name'] : "Floor {$bedInfo[0]['floor']}";
             }
             
            $tempText = !empty($temperature) ? " (Temperature: {$temperature}°C)" : "";
            $msg = "📦 Package Completed: {$userName} packaged '{$categoryName}' for Suite {$bedNo} on {$floorName}{$tempText}. Order #{$order_id} item packaged.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'success', $msg);
            
            // CRITICAL FIX: Check if all categories are now packaged and update order status
            $this->checkAndMarkOrderPackaged($order_id);
            
            echo json_encode(['status' => 'success', 'message' => 'Package status updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update package status. Please try again.']);
        }
   }
    
    // New method for marking entire category as packaged
    function markACategoryPackaged(){
         
         $category_id = $this->input->post('category_id');
         $order_id = $this->input->post('order_id');
         
         // Validation: Check if required data is present
         if (empty($order_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Order ID is required but not found. Please refresh the page and try again.']);
             return;
         }
         
         if (empty($category_id)) {
             echo json_encode(['status' => 'error', 'message' => 'Category ID is required.']);
             return;
         }
         
         $data['category_id'] = $category_id;
         $data['order_id'] = $order_id;
         $data['status'] = 1;
         $data['date'] = australia_date_only();
         $data['packaged_at'] = australia_datetime();
        
         // First check if table exists, if not create it
         if (!$this->tenantDb->table_exists('order_to_category_packagestatus')) {
             $this->createCategoryPackageStatusTable();
         }
         
         $result = $this->common_model->commonRecordCreate('order_to_category_packagestatus', $data);
         
         if ($result) {
             // Check if all categories for this order are now packaged
             $this->checkAndMarkOrderPackaged($order_id);
             echo json_encode(['status' => 'success', 'message' => 'Category marked as packaged successfully!']);
         } else {
             echo json_encode(['status' => 'error', 'message' => 'Failed to mark category as packaged. Please try again.']);
         }
    }
    
    // Create package status table if it doesn't exist
    private function createPackageStatusTable() {
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS orders_to_packagestatus (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            bed_id INT NOT NULL,
            category_id INT NOT NULL,
            temperature VARCHAR(10) NULL,
            notes TEXT NULL,
            packaged_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_order_bed_category (order_id, bed_id, category_id)
        )");
    }
    
    // Create category package status table if it doesn't exist
    private function createCategoryPackageStatusTable() {
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS order_to_category_packagestatus (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            category_id INT NOT NULL,
            status TINYINT DEFAULT 1,
            date DATE NOT NULL,
            packaged_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_order_category (order_id, category_id)
        )");
    }
    
    /**
     * Update order status with proper logging
     * 
     * @param int $order_id Order ID to update
     * @param int $new_status New status value (0=Cancelled, 1=Pending, 2=Paid, 3=Ready, 4=Delivered)
     * @param string $reason Reason for status change
     * @return bool Success status
     */
    private function updateOrderStatus($order_id, $new_status, $reason = '') {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        // Get current order status
        $order = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['status', 'date', 'floor_id'], 
            ['order_id' => $order_id]
        );
        
        if (empty($order)) {
            log_message('error', "ORDER STATUS UPDATE FAILED: Order ID={$order_id} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            return false;
        }
        
        $old_status = $order[0]['status'];
        $order_date = $order[0]['date'] ?? 'UNKNOWN';
        $floor_id = $order[0]['floor_id'] ?? 'UNKNOWN';
        
        log_message('info', "ORDER STATUS UPDATE: Order ID={$order_id}, Order Date={$order_date}, Floor ID={$floor_id}, Old Status={$old_status}, New Status={$new_status}, Reason={$reason}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // Prepare update data
        $update_data = ['status' => $new_status];
        
        // If marking as delivered (4), also update delivered_date and is_delivered
        if ($new_status == 4) {
            $update_data['delivered_date'] = australia_datetime();
            $update_data['is_delivered'] = 1;
        }
        
        // Update order
        $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $update_data);
        $affected_rows = $this->tenantDb->affected_rows();
        
        // Log the status change
        $this->logOrderStatusChange($order_id, $old_status, $new_status, $reason);
        
        if ($affected_rows > 0) {
            log_message('info', "ORDER STATUS UPDATE SUCCESS: Order ID={$order_id}, Status changed from {$old_status} to {$new_status}, Affected rows={$affected_rows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        } else {
            log_message('warning', "ORDER STATUS UPDATE: No rows affected for Order ID={$order_id}. Status may already be {$new_status}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
        }
        
        // Auto-generate invoice if status changed to Delivered (4)
        if ($new_status == 4) {
            log_message('info', "INVOICE AUTO-GENERATE: Attempting to auto-generate invoice for Order ID={$order_id}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            $invoice_result = $this->autoGenerateInvoice($order_id);
            if ($invoice_result) {
                log_message('info', "INVOICE AUTO-GENERATE SUCCESS: Invoice generated for Order ID={$order_id} at " . australia_datetime());
            } else {
                log_message('warning', "INVOICE AUTO-GENERATE FAILED: Could not generate invoice for Order ID={$order_id} at " . australia_datetime());
            }
        }
        
        return true;
    }
    
    /**
     * Check if all categories for an order are packaged and mark order as complete
     */
    function checkAndMarkOrderPackaged($order_id) {
        // Load required models
        $this->load->model('floor_order_model');
        
        // First, check if this is a floor consolidated order
        $order = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['is_floor_consolidated', 'workflow_status', 'status'], 
            ['order_id' => $order_id]
        );
        
        if (empty($order)) {
            return false;
        }
        
        $order = $order[0];
        
        // If it's a floor consolidated order, use the floor order model
        if (!empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
            return $this->floor_order_model->checkAndUpdateFloorOrderStatus($order_id);
        }
        
        // For regular orders, check category completion
        // Get all categories that should be in this order using direct query
        $categorySql = "SELECT DISTINCT m2c.category_id 
                        FROM orders_to_patient_options opo 
                        LEFT JOIN menu_to_category m2c ON m2c.menu_id = opo.menu_id 
                        WHERE opo.order_id = ?";
        $categoryQuery = $this->tenantDb->query($categorySql, [$order_id]);
        $orderCategories = $categoryQuery->result_array();
        
        log_message('info', "📊 ORDER STATUS CHECK for Order ID={$order_id}");
        log_message('info', "   Categories in order: " . count($orderCategories) . " - IDs: " . json_encode(array_column($orderCategories, 'category_id')));
        
        if (empty($orderCategories)) {
            log_message('warning', "   ⚠️ No categories found for order - cannot update status");
            return false;
        }
        
        // Check how many categories are marked as packaged
        $packagedCategories = $this->common_model->fetchRecordsDynamically(
            'order_to_category_packagestatus',
            ['category_id'],
            ['order_id' => $order_id, 'status' => 1]
        );
        
        log_message('info', "   Packaged categories: " . count($packagedCategories) . " - IDs: " . json_encode(array_column($packagedCategories, 'category_id')));
        
        // If all categories are packaged, mark order as delivered (status 4)
        if (count($packagedCategories) >= count($orderCategories)) {
            log_message('info', "ORDER STATUS CHECK: All categories packaged. Updating order ID={$order_id} status to DELIVERED (4). User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            $this->updateOrderStatus($order_id, 4, 'All categories packaged and delivered');
            
            // NOTIFICATION: Order Delivered
            $userName = $this->session->userdata('username') ?: 'System';
            $msg = "🎉 Order Delivered: Order #{$order_id} has been fully packaged and delivered by {$userName}.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'success', $msg);
            
            return true;
        } else {
            log_message('info', "   ⏳ NOT ALL CATEGORIES PACKAGED - Packaged: " . count($packagedCategories) . "/" . count($orderCategories));
        }
        
        return false;
    }
    
    /**
     * DISABLED: Send notifications to reception portal for users who haven't placed orders yet
     * Called at 10:00 AM daily via cron job
     * CRON JOBS ARE NOT USED - COMMENTED OUT
     */
    /* DISABLED - CRON NOT USED
    public function sendPendingOrderNotifications() {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        // CRITICAL FIX: Use Australia/Sydney timezone for time operations
        $currentTime = australia_date('H:i');
        $currentDate = australia_date_only();
        $notificationTime = '10:00';
        
        log_message('info', "NOTIFICATION CRON STARTED: Send Pending Order Notifications. Current Date={$currentDate}, Current Time={$currentTime}, Target Time={$notificationTime}, Timestamp=" . australia_datetime());
        
        // Only run at 10:00 AM (allow 5 minute window for cron timing)
        if ($currentTime < '09:55' || $currentTime > '10:05') {
            log_message('info', "NOTIFICATION CRON SKIPPED: Not the right time. Current Time={$currentTime}, Target Time={$notificationTime}, Timestamp=" . australia_datetime());
            return;
        }
        
        // Get all occupied suites
        $conditions = ['is_deleted' => 0, 'is_vaccant' => 0]; // Only occupied suites
        $occupiedSuites = $this->common_model->fetchRecordsDynamically('suites', '', $conditions);
        
        if (empty($occupiedSuites)) {
            log_message('info', "NOTIFICATION CRON: No occupied suites found. Current Date={$currentDate}, Timestamp=" . australia_datetime());
            return;
        }
        
        log_message('info', "NOTIFICATION CRON: Found " . count($occupiedSuites) . " occupied suites. Current Date={$currentDate}, Timestamp=" . australia_datetime());
        
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        // Get today's orders for tomorrow's delivery
        $tomorrowDate = $this->getAustraliaTomorrow();
        $orderConditions = [
            'date' => $tomorrowDate,
            'buttonType' => 'sendorder'
        ];
        $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', ['bed_id'], $orderConditions);
        
        log_message('info', "NOTIFICATION CRON: Found " . count($todaysOrders) . " orders for tomorrow ({$tomorrowDate}). Checking for suites without orders. Timestamp=" . australia_datetime());
        
        // Get list of suites that have already placed orders
        $suitesWithOrders = [];
        if (!empty($todaysOrders)) {
            foreach ($todaysOrders as $order) {
                if (!empty($order['bed_id'])) {
                    $suitesWithOrders[] = $order['bed_id'];
                }
            }
        }
        $suitesWithOrders = array_unique($suitesWithOrders);
        
        // Find suites without orders
        $suitesWithoutOrders = [];
        $patientNames = [];
        
        foreach ($occupiedSuites as $suite) {
            if (!in_array($suite['id'], $suitesWithOrders)) {
                // Get patient name for this suite
                $patientConditions = [
                    'suite_number' => $suite['id'],
                    'status' => 1 // Active patients only
                ];
                $patients = $this->common_model->fetchRecordsDynamically('people', ['name'], $patientConditions);
                
                $patientName = 'Unknown Patient';
                $today = australia_date_only();
                if (!empty($patients)) {
                    foreach ($patients as $patient) {
                        // Use first active patient found
                        $patientName = $patient['name'];
                        break;
                    }
                }
                
                $suitesWithoutOrders[] = $suite;
                $patientNames[$suite['id']] = $patientName;
            }
        }
        
        if (empty($suitesWithoutOrders)) {
            log_message('info', "NOTIFICATION CRON COMPLETED: All occupied suites have placed orders for tomorrow ({$tomorrowDate}). Total Occupied Suites=" . count($occupiedSuites) . ", Orders Found=" . count($todaysOrders) . ", Timestamp=" . australia_datetime());
            return;
        }
        
        log_message('info', "NOTIFICATION CRON: Found " . count($suitesWithoutOrders) . " suites without orders for tomorrow ({$tomorrowDate}). Creating notifications. Timestamp=" . australia_datetime());
        
        // Create notification data
        $notificationData = [
            'type' => 'pending_orders',
            'title' => 'Pending Orders Alert',
            'message' => count($suitesWithoutOrders) . ' suites have not placed orders for tomorrow yet',
            'suites_without_orders' => $suitesWithoutOrders,
            'patient_names' => $patientNames,
            'created_at' => australia_datetime(),
            'expires_at' => $this->getAustraliaDateTimeOffset('+30 minutes') // Notification expires in 30 minutes
        ];
        
        // Store notification in session for reception users
        // We'll create a notification table if it doesn't exist
        if (!$this->tenantDb->table_exists('pending_order_notifications')) {
            $this->createPendingOrderNotificationsTable();
        }
        
        // Clear old notifications first
        $this->common_model->commonRecordDelete('pending_order_notifications', australia_datetime(), 'expires_at', '<');
        
        // Insert new notification
        $result = $this->common_model->commonRecordCreate('pending_order_notifications', $notificationData);
        
        if ($result) {
            log_message('info', 'Pending order notifications: Created notification for ' . count($suitesWithoutOrders) . ' suites without orders');
        } else {
            log_message('error', 'Pending order notifications: Failed to create notification');
        }
    }
    */
    
    /**
     * Create table for storing pending order notifications
     */
    private function createPendingOrderNotificationsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS pending_order_notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            suites_without_orders TEXT NULL,
            patient_names TEXT NULL,
            created_at DATETIME NOT NULL,
            expires_at DATETIME NOT NULL,
            INDEX idx_expires (expires_at),
            INDEX idx_type (type)
        )";
        
        $this->tenantDb->query($sql);
        log_message('info', 'Created pending_order_notifications table');
    }
    
    /**
     * Clean up suites with empty bed numbers (admin function)
     */
    public function cleanupEmptySuites() {
        // Only allow admin users
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        if ($userRole != 1) {
            echo json_encode(['status' => 'error', 'message' => 'Access denied']);
            return;
        }
        
        // Find suites with empty bed_no
        $sql = "SELECT * FROM suites WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '') AND is_deleted = 0";
        $emptySuites = $this->tenantDb->query($sql)->result_array();
        
        $fixedCount = 0;
        $deletedCount = 0;
        
        foreach ($emptySuites as $suite) {
            // Generate a new bed number
            $newBedNo = 'Suite-' . $suite['id'];
            
            // Check if this bed number already exists
            $checkSql = "SELECT COUNT(*) as count FROM suites WHERE bed_no = ? AND is_deleted = 0 AND id != ?";
            $existingCount = $this->tenantDb->query($checkSql, [$newBedNo, $suite['id']])->row()->count;
            
            if ($existingCount == 0) {
                // Update with new bed number
                $updateSql = "UPDATE suites SET bed_no = ? WHERE id = ?";
                $this->tenantDb->query($updateSql, [$newBedNo, $suite['id']]);
                $fixedCount++;
            } else {
                // Mark as deleted if we can't generate a unique name
                $deleteSql = "UPDATE suites SET is_deleted = 1 WHERE id = ?";
                $this->tenantDb->query($deleteSql, [$suite['id']]);
                $deletedCount++;
            }
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => "Cleanup completed. Fixed: {$fixedCount}, Deleted: {$deletedCount}",
            'fixed' => $fixedCount,
            'deleted' => $deletedCount
        ]);
    }

    /**
     * Get active pending order notifications for reception portal
     */
    public function getPendingOrderNotifications() {
        if (!$this->tenantDb->table_exists('pending_order_notifications')) {
            echo json_encode(['notifications' => []]);
            return;
        }
        
        // Get active notifications (not expired)
        $conditions = [
            'expires_at >' => australia_datetime()
        ];
        $notifications = $this->common_model->fetchRecordsDynamically('pending_order_notifications', '', $conditions);
        
        // Process notification data
        $processedNotifications = [];
        foreach ($notifications as $notification) {
            $processedNotifications[] = [
                'id' => $notification['id'],
                'type' => $notification['type'],
                'title' => $notification['title'],
                'message' => $notification['message'],
                'suites_without_orders' => unserialize($notification['suites_without_orders']) ?: [],
                'patient_names' => unserialize($notification['patient_names']) ?: [],
                'created_at' => $notification['created_at']
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode(['notifications' => $processedNotifications]);
    }

    /**
     * Check if current time is within order cutoff time (before 10:30 AM)
     * Orders for tomorrow must be placed before 10:30 AM today
     * ONLY applies to reception (role 6) and patient (role 4) users
     * Nurses (role 3) can place orders at any time
     * Nurse Override also bypasses cutoff time restriction
     */
    private function isWithinOrderCutoffTime() {
        // Get current user role
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        
        // Check if nurse override is active (sent from frontend)
        $nurseOverride = $this->input->post('nurseOverride');
        
        if ($nurseOverride == '1') {
            return true;
        }
        
        // Nurses (role 3) can place orders at any time - no cutoff restriction
        if ($userRole == 3) {
            return true;
        }
        
        // For reception (role 6) and patients (role 4), apply 10:30 AM cutoff
        if ($userRole == 6 || $userRole == 4) {
            // Get current date and time in Australia timezone
            $now = new DateTime('now', new DateTimeZone('Australia/Sydney'));
            $currentTime = $now->format('H:i');
            
            // If we're ordering for tomorrow and it's past 10:30 AM today, block it
            if ($currentTime >= '10:30') {
                return false; // Past cutoff time
            }
            
            return true; // Before cutoff time
        }
        
        // For other roles (admin, chef), allow orders at any time
        return true;
    }
    
    /**
     * Check if all categories for an order are delivered and mark order as complete
     */
    function checkAndMarkOrderDelivered($order_id) {
        // Load required models
        $this->load->model('floor_order_model');
        
        // First, check if this is a floor consolidated order
        $order = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['is_floor_consolidated', 'workflow_status', 'status'], 
            ['order_id' => $order_id]
        );
        
        if (empty($order)) return;
        
        $isFloorConsolidated = !empty($order[0]['is_floor_consolidated']) && $order[0]['is_floor_consolidated'] == 1;
        
        // Get all categories that have items in this order
        $order_categories = $this->common_model->fetchRecordsDynamically(
            'orders_to_patient_options opo', 
            ['DISTINCT m2c.category_id'], 
            ['opo.order_id' => $order_id],
            '',
            '',
            'LEFT JOIN menuDetails md ON md.id = opo.menu_id LEFT JOIN menu_to_category m2c ON m2c.menu_id = opo.menu_id'
        );
        
        if (empty($order_categories)) return;
        
        $category_ids = array_column($order_categories, 'category_id');
        
        // Check how many categories are delivered
        $delivered_categories = $this->common_model->fetchRecordsDynamically(
            'order_to_category_deliverystatus', 
            ['category_id'], 
            [
                'order_id' => $order_id,
                'status' => 1,
                'date' => australia_date_only()
            ]
        );
        
        $delivered_category_ids = array_column($delivered_categories, 'category_id');
        
        // If all categories are delivered, mark order as complete
        if (count($category_ids) === count($delivered_category_ids) && 
            empty(array_diff($category_ids, $delivered_category_ids))) {
            
            if ($isFloorConsolidated) {
                // Floor consolidated order - update workflow status
                $update_data = [
                    'workflow_status' => 'delivered',
                    'delivered_date' => australia_datetime(),
                    'is_delivered' => 1
                ];
                $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $update_data);
                
                // Log the status change
                $this->floor_order_model->logOrderStatusChange(
                    $order_id, 
                    $order[0]['workflow_status'] ?? 'chef_ready', 
                    'delivered', 
                    'All categories delivered', 
                    $this->session->userdata('user_id') ?? 0
                );
            } else {
                // Legacy order - use old system
                $update_data = [
                    'status' => 4, // Delivered
                    'delivered_date' => australia_datetime(),
                    'is_delivered' => 1
                ];
                $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $update_data);
                
                // Log the status change
                $this->logOrderStatusChange($order_id, 3, 4, 'All categories delivered');
            }
            
            // Auto-generate invoice for delivered order
            $this->autoGenerateInvoice($order_id);
        }
    }
    
    function markPaid(){
        $order_id = $this->input->post('order_id'); // From order history
        $order_date = $this->input->post('order_date');
        $invoice_id = $this->input->post('invoice_id'); // New: support invoice ID
        
        try {
            if ($order_id) {
                // Mark specific order as paid (from order history)
                
                // Get current order status
                $order_details = $this->common_model->fetchRecordsDynamically('orders', ['status'], ['order_id' => $order_id]);
                if (empty($order_details)) {
                    echo json_encode(['status' => 'error', 'message' => 'Order not found']);
                    return;
                }
                
                $old_status = $order_details[0]['status'];
                
                // Update order status to Paid
                $order_data = [
                    'status' => 2 // Paid
                ];
                $result = $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $order_data);
                
                // Log status change
                $this->logOrderStatusChange($order_id, $old_status, 2, 'Order manually marked as paid');
                
                // Also mark corresponding invoice as paid if exists
                $invoice_data = [
                    'status' => 2,
                    'payment_date' => australia_datetime()
                ];
                $this->common_model->commonRecordUpdate('daily_invoices', 'order_id', $order_id, $invoice_data);
                
                echo json_encode(['status' => 'success', 'message' => 'Order marked as paid successfully!']);
                
            } else if ($invoice_id) {
                // FIXED: Mark invoice as paid (new system)
                $invoice_data = [
                    'status' => 2, // Paid
                    'payment_date' => australia_datetime()
                ];
                $result = $this->common_model->commonRecordUpdate('daily_invoices', 'id', $invoice_id, $invoice_data);
                
                // Also update the associated order
                $invoice_details = $this->common_model->fetchRecordsDynamically('daily_invoices', ['order_id'], ['id' => $invoice_id]);
                if (!empty($invoice_details)) {
                    $order_id = $invoice_details[0]['order_id'];
                    $order_data = [
                        'status' => 2 // Paid
                    ];
                    $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $order_data);
                    $this->logOrderStatusChange($order_id, 4, 2, 'Invoice marked as paid');
                }
                
                echo json_encode(['status' => 'success', 'message' => 'Invoice marked as paid successfully!']);
                
            } else if ($order_date) {
                // Legacy: Mark all orders for a specific date as paid
                $order_data = [
                    'status' => 2
                ];
                $result = $this->common_model->commonRecordUpdate('orders', 'date', $order_date, $order_data);
                
                // Also mark corresponding invoices as paid
                $invoice_data = [
                    'status' => 2,
                    'payment_date' => australia_datetime()
                ];
                $this->common_model->commonRecordUpdate('daily_invoices', 'order_date', $order_date, $invoice_data);
                
                echo json_encode(['status' => 'success', 'message' => 'Orders marked as paid successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Order ID, invoice ID, or order date is required']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error updating payment status: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Auto-generate invoice for completed/delivered orders
     * UPDATED: Generate ONE invoice per day only when ALL floor orders are delivered
     */
    function autoGenerateInvoice($order_id) {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        log_message('info', "INVOICE AUTO-GENERATE INITIATED: Order ID={$order_id}, Timestamp=" . australia_datetime());
        
        // Get order details
        $order_details = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['order_id', 'date', 'dept_id', 'status', 'is_delivered'], 
            ['order_id' => $order_id]
        );
        
        if (empty($order_details)) {
            log_message('error', "INVOICE AUTO-GENERATE FAILED: Order ID={$order_id} not found at " . australia_datetime());
            return false;
        }
        
        $order = $order_details[0];
        $order_date = $order['date'];
        
        // UPDATED: Check if invoice already exists for this DATE (not per floor)
        $existing_invoice = $this->common_model->fetchRecordsDynamically(
            'daily_invoices', 
            ['id', 'invoice_number'], 
            ['order_date' => $order_date]
        );
        
        if (!empty($existing_invoice)) {
            // Invoice already generated for this date
            log_message('info', "INVOICE AUTO-GENERATE: Invoice already exists for date {$order_date}, Invoice Number={$existing_invoice[0]['invoice_number']}, Order ID={$order_id} at " . australia_datetime());
            return true;
        }
        
        // UPDATED: Check if ALL orders for this date are delivered
        // Get all orders for this date
        $all_orders_today = $this->common_model->fetchRecordsDynamically(
            'orders',
            ['order_id', 'status', 'is_delivered', 'dept_id'],
            [
                'date' => $order_date,
                'buttonType' => 'sendorder' // Only sent orders
            ]
        );
        
        if (empty($all_orders_today)) {
            log_message('info', "INVOICE AUTO-GENERATE: No orders found for date {$order_date}, Order ID={$order_id} at " . australia_datetime());
            return false;
        }
        
        // Check if all orders are delivered
        $all_delivered = true;
        $total_orders = count($all_orders_today);
        $delivered_count = 0;
        
        foreach ($all_orders_today as $ord) {
            if ($ord['status'] == 4 && $ord['is_delivered'] == 1) {
                $delivered_count++;
            } else {
                $all_delivered = false;
            }
        }
        
        if (!$all_delivered) {
            log_message('info', "INVOICE AUTO-GENERATE: Not all orders delivered for {$order_date}. Delivered: {$delivered_count}/{$total_orders}. Invoice generation skipped. Order ID={$order_id} at " . australia_datetime());
            return false;
        }
        
        // ALL orders for this date are delivered - Generate ONE consolidated invoice
        log_message('info', "INVOICE AUTO-GENERATE: All {$total_orders} orders delivered for {$order_date}. Generating consolidated invoice. Order ID={$order_id} at " . australia_datetime());
        
        // UPDATED: Generate invoice number without dept_id (one per day)
        $invoice_number = 'INV' . date('dmY', strtotime($order_date));
        
        // Create daily invoice record
        $invoice_data = [
            'order_date' => $order_date,
            'dept_id' => 0, // 0 indicates consolidated invoice for all floors
            'order_id' => $order_id, // Store the last delivered order ID for reference
            'generated_date' => australia_datetime(),
            'status' => 1, // Generated
            'invoice_number' => $invoice_number
        ];
        
        // Create daily_invoices table if it doesn't exist
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS daily_invoices (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_date DATE NOT NULL,
            dept_id INT NOT NULL DEFAULT 0,
            order_id INT NOT NULL,
            invoice_number VARCHAR(50) UNIQUE,
            generated_date DATETIME,
            status INT DEFAULT 1,
            total_amount DECIMAL(10,2) DEFAULT 0,
            INDEX idx_order_date (order_date),
            INDEX idx_invoice_number (invoice_number)
        )");
        
        $result = $this->common_model->commonRecordCreate('daily_invoices', $invoice_data);
        $invoice_id = $this->tenantDb->insert_id();
        
        if ($result && $invoice_id) {
            log_message('info', "INVOICE AUTO-GENERATE SUCCESS: Invoice ID={$invoice_id}, Invoice Number={$invoice_number}, Order Date={$order_date}, Total Orders={$total_orders}, Order ID={$order_id} at " . australia_datetime());
            return true;
        } else {
            $db_error = $this->tenantDb->error();
            log_message('error', "INVOICE AUTO-GENERATE FAILED: Could not create invoice record. Invoice Number={$invoice_number}, Order Date={$order_date}, Order ID={$order_id}, Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . " at " . australia_datetime());
            return false;
        }
    }
    
    /**
     * Get order status text for display
     */
    function getOrderStatusText($status) {
        $status_map = [
            0 => 'Cancelled',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Ready for Delivery',
            4 => 'Delivered'
        ];
        
        return isset($status_map[$status]) ? $status_map[$status] : 'Unknown';
    }
    

    /**
     * DISABLED: AUTOMATIC STATUS CHANGE: Convert unsent orders to sent at 10:00 PM
     * This runs via cron job at 10:00 PM daily
     * UPDATED FOR FLOOR CONSOLIDATION SYSTEM
     * CRON JOBS ARE NOT USED - COMMENTED OUT
     */
    /* DISABLED - CRON NOT USED
    function autoSendUnsentOrders() {
        // Security: Only allow this to run from CLI or specific IP
        if (!$this->input->is_cli_request() && $this->input->server('REMOTE_ADDR') !== '127.0.0.1') {
            show_404();
            return;
        }
        
        // Load required models
        $this->load->model('floor_order_model');
        
        // Get current date and time
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $currentDate = $this->getAustraliaDate();
        $currentTime = australia_date('H:i:s');
        $tomorrowDate = $this->getAustraliaTomorrow();
        
        // Log the execution
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        log_message('info', "CRON JOB 1 STARTED: Handle Nurse Missed Submissions. Current Date={$currentDate}, Current Time={$currentTime}, Processing Date={$tomorrowDate}, Timestamp=" . australia_datetime());
        
        // 🔒 CRITICAL SAFEGUARD: Only process TOMORROW'S orders
        // Handle both legacy and floor consolidated orders
        $conditions = [
            'date' => $tomorrowDate, // ONLY tomorrow's orders
            'buttonType' => 'save',
            'status !=' => 0 // Not cancelled
        ];
        
        $unsentOrders = $this->common_model->fetchRecordsDynamically('orders', 
            ['order_id', 'date', 'dept_id', 'bed_id', 'is_floor_consolidated', 'workflow_status'], 
            $conditions
        );
        
        if (empty($unsentOrders)) {
            log_message('info', "CRON JOB 1: No unsent orders found for tomorrow ({$tomorrowDate}). Timestamp=" . australia_datetime());
            if ($this->input->is_cli_request()) {
                echo "No unsent orders found for tomorrow ({$tomorrowDate})\n";
                echo "SAFEGUARD: Only processing tomorrow's orders\n";
            }
            return;
        }
        
        log_message('info', "CRON JOB 1: Found " . count($unsentOrders) . " unsent orders for tomorrow ({$tomorrowDate}). Processing... Timestamp=" . australia_datetime());
        
        $successCount = 0;
        $failCount = 0;
        $floorOrderCount = 0;
        $legacyOrderCount = 0;
        
        foreach ($unsentOrders as $order) {
            $isFloorConsolidated = !empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1;
            
            if ($isFloorConsolidated) {
                // Floor consolidated order - update workflow status
                $updateData = [
                    'buttonType' => 'sendorder',
                    'workflow_status' => 'nurse_approved', // Nurse approved the order
                    'updated_by' => 0 // System update
                ];
                $floorOrderCount++;
            } else {
                // Legacy order - use old system
                $updateData = [
                    'buttonType' => 'sendorder',
                    'updated_by' => 0 // System update
                ];
                $legacyOrderCount++;
            }
            
            $result = $this->common_model->commonRecordUpdate('orders', 'order_id', $order['order_id'], $updateData);
            
            if ($result) {
                $successCount++;
                
                // Log the status change appropriately
                if ($isFloorConsolidated) {
                    $this->floor_order_model->logOrderStatusChange(
                        $order['order_id'], 
                        $order['workflow_status'] ?? 'floor_submitted', 
                        'nurse_approved', 
                        "CRON JOB 1: Auto-approved floor order at 11:00 PM", 
                        0
                    );
                } else {
                    $this->logOrderStatusChange($order['order_id'], null, 1, "CRON JOB 1: Auto-sent legacy order at 11:00 PM");
                }
                
                log_message('info', "CRON JOB 1 SUCCESS: Auto-sent order ID={$order['order_id']}, Type=" . ($isFloorConsolidated ? 'floor' : 'legacy') . ", Order Date={$order['date']}, Floor/Dept ID=" . ($order['dept_id'] ?? 'NONE') . ", Bed ID=" . ($order['bed_id'] ?? 'NONE') . ", Timestamp=" . australia_datetime());
            } else {
                $failCount++;
                $db_error = $this->tenantDb->error();
                log_message('error', "CRON JOB 1 FAILED: Failed to auto-send order ID={$order['order_id']}, Order Date={$order['date']}, Floor/Dept ID=" . ($order['dept_id'] ?? 'NONE') . ", Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
            }
        }
        
        $message = "CRON JOB 1 COMPLETED: Auto-send completed. Success={$successCount} orders sent ({$floorOrderCount} floor, {$legacyOrderCount} legacy), Failed={$failCount}, Processing Date={$tomorrowDate}, Timestamp=" . australia_datetime();
        log_message('info', $message);
        
        if ($this->input->is_cli_request()) {
            echo $message . "\n";
            echo "Floor consolidated orders: {$floorOrderCount}\n";
            echo "Legacy suite orders: {$legacyOrderCount}\n";
        } else {
            echo json_encode([
                'success' => true,
                'message' => $message,
                'sent' => $successCount,
                'failed' => $failCount,
                'floor_orders' => $floorOrderCount,
                'legacy_orders' => $legacyOrderCount
            ]);
        }
    }
    */

    /**
     * DISABLED: AUTOMATIC STATUS UPDATE: Update forgotten order statuses at 10:00 PM
     * This runs via cron job at 10:00 PM daily to ensure invoices can be generated
     * UPDATED FOR FLOOR CONSOLIDATION SYSTEM
     * CRON JOBS ARE NOT USED - COMMENTED OUT
     * 
     * Status Flow:
     * - Floor orders: workflow_status → "delivered"
     * - Legacy orders: status → 4 (Delivered/Completed)
     */
    /* DISABLED - CRON NOT USED
    function autoUpdateForgottenOrderStatuses() {
        // Security: Only allow this to run from CLI or with a secret token
        $cron_token = $this->input->get('token');
        $is_cli = $this->input->is_cli_request();
        $is_localhost = $this->input->server('REMOTE_ADDR') === '127.0.0.1';
        
        // Allow CLI, localhost, or requests with correct token
        if (!$is_cli && !$is_localhost && $cron_token !== 'bizorder_cron_2025') {
            show_404();
            return;
        }
        
        // Load required models
        $this->load->model('floor_order_model');
        
        // Get current date and time
        $currentDate = australia_date_only();
        $currentTime = australia_date('H:i:s');
        
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        // Log the execution
        log_message('info', "CRON JOB 2 STARTED: Handle Chef/Delivery Missed Updates. Current Date={$currentDate}, Current Time={$currentTime}, Processing Date={$currentDate}, Timestamp=" . australia_datetime());
        
        $totalUpdated = 0;
        $statusUpdates = [];
        $floorOrderCount = 0;
        $legacyOrderCount = 0;
        
        // 🔒 CRITICAL SAFEGUARD: Only process TODAY'S orders
        // Find orders that should be marked as completed/delivered
        // These are orders that have been sent to chef but chef/delivery forgot to update
        $todaysOrdersConditions = [
            'date' => $currentDate, // ONLY today's orders
            'buttonType' => 'sendorder' // Already sent to chef
        ];
        
        $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', 
            ['order_id', 'dept_id', 'bed_id', 'status', 'is_floor_consolidated', 'workflow_status'], 
            $todaysOrdersConditions
        );
        
        if (empty($todaysOrders)) {
            log_message('info', "CRON JOB 2: No orders found for today ({$currentDate}) that need status updates. Timestamp=" . australia_datetime());
            if ($this->input->is_cli_request()) {
                echo "No orders found for today ({$currentDate}) that need status updates\n";
                echo "SAFEGUARD: Only processing today's orders\n";
            }
            return;
        }
        
        log_message('info', "CRON JOB 2: Found " . count($todaysOrders) . " orders for today ({$currentDate}) that may need status updates. Processing... Timestamp=" . australia_datetime());
        
        foreach ($todaysOrders as $order) {
            $isFloorConsolidated = !empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1;
            $needsUpdate = false;
            $updateData = ['updated_by' => 0]; // System update
            
            if ($isFloorConsolidated) {
                // Floor consolidated order - check workflow status
                $currentWorkflowStatus = $order['workflow_status'] ?? 'floor_submitted';
                if (!in_array($currentWorkflowStatus, ['delivered', 'cancelled'])) {
                    // Auto-complete to delivered status
                    $updateData['workflow_status'] = 'delivered';
                    $updateData['delivered_date'] = australia_datetime(); // 🔧 FIX: Set delivered_date
                    $updateData['is_delivered'] = 1; // 🔧 FIX: Set is_delivered flag
                    $needsUpdate = true;
                    $floorOrderCount++;
                }
            } else {
                // Legacy order - check numeric status
                if ($order['status'] != 4 && $order['status'] != 0) { // Not delivered and not cancelled
                    $updateData['status'] = 4; // Delivered/Completed
                    $updateData['delivered_date'] = australia_datetime(); // Track delivery timestamp
                    $updateData['is_delivered'] = 1; // Mark as delivered
                    $needsUpdate = true;
                    $legacyOrderCount++;
                }
            }
            
            if ($needsUpdate) {
                $result = $this->common_model->commonRecordUpdate('orders', 'order_id', $order['order_id'], $updateData);
                
                if ($result) {
                    $totalUpdated++;
                    
                    if ($isFloorConsolidated) {
                        $oldStatus = $order['workflow_status'] ?? 'floor_submitted';
                        $statusUpdates[] = "Floor Order #{$order['order_id']} → delivered (was {$oldStatus})";
                        $this->floor_order_model->logOrderStatusChange(
                            $order['order_id'], 
                            $oldStatus, 
                            'delivered', 
                            "CRON JOB 2: Auto-completed floor order at 11:00 PM", 
                            0
                        );
                        
                        // FIX: Auto-generate invoice for floor orders too!
                        $invoice_result = $this->autoGenerateInvoice($order['order_id']);
                        if ($invoice_result) {
                            log_message('info', "CRON JOB 2: Invoice auto-generated successfully for Floor Order ID={$order['order_id']} at " . australia_datetime());
                        } else {
                            log_message('warning', "CRON JOB 2: Invoice auto-generation failed or skipped for Floor Order ID={$order['order_id']} at " . australia_datetime());
                        }
                    } else {
                        $oldStatus = $order['status'];
                        $statusUpdates[] = "Legacy Order #{$order['order_id']} → Delivered (was status {$oldStatus})";
                        $this->logOrderStatusChange($order['order_id'], $oldStatus, 4, "CRON JOB 2: Auto-completed legacy order at 11:00 PM");
                        
                        // Auto-generate invoice when cron marks as delivered
                        $invoice_result = $this->autoGenerateInvoice($order['order_id']);
                        if ($invoice_result) {
                            log_message('info', "CRON JOB 2: Invoice auto-generated successfully for Legacy Order ID={$order['order_id']} at " . australia_datetime());
                        } else {
                            log_message('warning', "CRON JOB 2: Invoice auto-generation failed or skipped for Legacy Order ID={$order['order_id']} at " . australia_datetime());
                        }
                    }
                    
                    log_message('info', "CRON JOB 2 SUCCESS: Auto-completed order ID={$order['order_id']}, Type=" . ($isFloorConsolidated ? 'floor' : 'legacy') . ", Order Date={$currentDate}, Floor/Dept ID=" . ($order['dept_id'] ?? 'NONE') . ", Bed ID=" . ($order['bed_id'] ?? 'NONE') . ", Timestamp=" . australia_datetime());
                } else {
                    $db_error = $this->tenantDb->error();
                    log_message('error', "CRON JOB 2 FAILED: Failed to auto-complete order ID={$order['order_id']}, Order Date={$currentDate}, Floor/Dept ID=" . ($order['dept_id'] ?? 'NONE') . ", Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . ", Timestamp=" . australia_datetime());
                }
            }
        }
        
        $message = "CRON JOB 2 COMPLETED: Chef/Delivery missed updates completed. Total Updated={$totalUpdated} orders ({$floorOrderCount} floor, {$legacyOrderCount} legacy), Processing Date={$currentDate}, Timestamp=" . australia_datetime();
        log_message('info', $message);
        
        if ($this->input->is_cli_request()) {
            echo $message . "\n";
            echo "Floor consolidated orders: {$floorOrderCount}\n";
            echo "Legacy suite orders: {$legacyOrderCount}\n";
            if (!empty($statusUpdates)) {
                echo "Status Updates:\n";
                foreach ($statusUpdates as $update) {
                    echo "- {$update}\n";
                }
            }
            echo "SAFEGUARD: Only processed today's orders, never touched tomorrow's orders\n";
        } else {
            echo json_encode([
                'success' => true,
                'message' => $message,
                'updated' => $totalUpdated,
                'updates' => $statusUpdates,
                'floor_orders' => $floorOrderCount,
                'legacy_orders' => $legacyOrderCount
            ]);
        }
    }
    */

    /**
     * Get current order ID for today's orders
     */
    function getCurrentOrderId() {
        try {
            $category_id = $this->input->post('category_id');
            $option_id = $this->input->post('option_id'); // Get option_id to find the right order
            
            // FIXED: If we have option_id, find the order that actually contains this option
            if (!empty($option_id)) {
                // Find the order_id that has this option_id for today
                $sql = "SELECT DISTINCT o.order_id, o.status, o.dept_id 
                        FROM orders o
                        INNER JOIN orders_to_patient_options opo ON opo.order_id = o.order_id
                        WHERE o.date = ?
                        AND o.buttonType = 'sendorder'
                        AND o.status != 0
                        AND opo.option_id = ?
                        ORDER BY o.order_id DESC
                        LIMIT 1";
                
                $query = $this->tenantDb->query($sql, [australia_date_only(), $option_id]);
                $orders = $query->result_array();
                
                if (!empty($orders)) {
                    echo json_encode(['status' => 'success', 'order_id' => $orders[0]['order_id']]);
                    return;
                }
            }
            
            // FALLBACK: If no option_id provided or not found, use the old logic
            // Get department ID from session or current user
            $dept_id = $this->session->userdata('department_id');
            $user_id = $this->session->userdata('user_id');
            
            // If no department_id in session, try to get it from user or use fallback
            if (empty($dept_id)) {
                // Try to get department from user groups or use 0 as fallback
                $user_groups = $this->ion_auth->get_users_groups($user_id)->result();
                if (!empty($user_groups)) {
                    // For now, we'll search without department filter
                    $dept_id = null;
                } else {
                    $dept_id = null;
                }
            }
            
            // Build base conditions
            $base_conditions = [
                'date' => australia_date_only(),
                'buttonType' => 'sendorder',
                'status !=' => 0 // Not cancelled
            ];
            
            // Add department filter only if we have a valid dept_id
            if (!empty($dept_id)) {
                $base_conditions['dept_id'] = $dept_id;
            }
            
            $orders = $this->common_model->fetchRecordsDynamically(
                'orders', 
                ['order_id', 'status', 'dept_id'], 
                $base_conditions,
                'order_id DESC',
                1
            );
            
            if (!empty($orders)) {
                echo json_encode([
                    'status' => 'success',
                    'order_id' => $orders[0]['order_id'],
                    'order_status' => $orders[0]['status'],
                    'dept_id' => $orders[0]['dept_id']
                ]);
                return;
            }
            
            // Fallback 1: Any order for today with sendorder buttonType
            $fallback1_conditions = [
                'date' => australia_date_only(),
                'buttonType' => 'sendorder'
            ];
            
            $fallback1_orders = $this->common_model->fetchRecordsDynamically(
                'orders', 
                ['order_id', 'status', 'buttonType', 'dept_id'], 
                $fallback1_conditions,
                'order_id DESC',
                1
            );
            
            if (!empty($fallback1_orders)) {
                echo json_encode([
                    'status' => 'success',
                    'order_id' => $fallback1_orders[0]['order_id'],
                    'order_status' => $fallback1_orders[0]['status'],
                    'dept_id' => $fallback1_orders[0]['dept_id'],
                    'note' => 'Using fallback - any sendorder for today'
                ]);
                return;
            }
            
            // Fallback 2: Any order for today
            $fallback2_conditions = [
                'date' => australia_date_only()
            ];
            
            $fallback2_orders = $this->common_model->fetchRecordsDynamically(
                'orders', 
                ['order_id', 'status', 'buttonType', 'dept_id'], 
                $fallback2_conditions,
                'order_id DESC',
                1
            );
            
            if (!empty($fallback2_orders)) {
                echo json_encode([
                    'status' => 'success',
                    'order_id' => $fallback2_orders[0]['order_id'],
                    'order_status' => $fallback2_orders[0]['status'],
                    'dept_id' => $fallback2_orders[0]['dept_id'],
                    'note' => 'Using fallback - any order for today (buttonType: ' . $fallback2_orders[0]['buttonType'] . ')'
                ]);
                return;
            }
            
            // No orders found at all
            echo json_encode([
                'status' => 'error',
                'message' => 'No orders found for today. Session Dept ID: ' . ($dept_id ?: 'empty') . ', User ID: ' . $user_id . ', Date: ' . australia_date_only()
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Debug endpoint to check production form data
     */
    function debugProductionData() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        
        echo "<h3>Production Form Debug Data</h3>";
        echo "<p>Date: " . australia_date_only() . "</p>";
        echo "<p>Session Department ID: '" . $this->session->userdata('department_id') . "'</p>";
        echo "<p>Session User ID: '" . $this->session->userdata('user_id') . "'</p>";
        echo "<p>Session Username: '" . $this->session->userdata('username') . "'</p>";
        
        // Show all session data
        echo "<h4>All Session Data:</h4>";
        echo "<pre>" . print_r($this->session->all_userdata(), true) . "</pre>";
        
        // Check all orders for today (no department filter)
        $all_orders = $this->common_model->fetchRecordsDynamically('orders', '*', ['date' => australia_date_only()]);
        echo "<h4>All Orders for Today (" . australia_date_only() . "):</h4>";
        echo "<pre>" . print_r($all_orders, true) . "</pre>";
        
        // Get production form data
        $ordersItemInfo = $this->order_model->fetchOrderForChef();
        echo "<h4>Production Form Data (fetchOrderForChef):</h4>";
        echo "<pre>" . print_r($ordersItemInfo, true) . "</pre>";
        
        // Check orders_to_patient_options for any order today
        if (!empty($all_orders)) {
            foreach ($all_orders as $order) {
                $order_id = $order['order_id'];
                $options = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options', 
                    '*', 
                    ['order_id' => $order_id]
                );
                echo "<h4>Order Options for Order ID {$order_id} (Dept: {$order['dept_id']}, ButtonType: {$order['buttonType']}):</h4>";
                echo "<pre>" . print_r($options, true) . "</pre>";
            }
        }
        
        // Test getCurrentOrderId logic
        echo "<h4>Testing getCurrentOrderId Logic:</h4>";
        $_POST['category_id'] = '1'; // Simulate a category ID
        ob_start();
        $this->getCurrentOrderId();
        $output = ob_get_clean();
        echo "<p>getCurrentOrderId() output: " . $output . "</p>";
    }
    
    /**
     * Initialize order status log table and create entries for existing orders (run once)
     */
    function initializeOrderHistory() {
        // Create table if it doesn't exist
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS order_status_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            old_status INT,
            new_status INT,
            reason TEXT,
            changed_by INT,
            changed_date DATETIME,
            INDEX idx_order_id (order_id)
        )");
        
        // Get all orders that don't have history entries
        $orders_without_history = $this->tenantDb->query("
            SELECT o.order_id, o.status, o.date, o.added_by 
            FROM orders o 
            LEFT JOIN order_status_log osl ON o.order_id = osl.order_id 
            WHERE osl.order_id IS NULL
        ")->result_array();
        
        $batch_data = [];
        foreach ($orders_without_history as $order) {
            $batch_data[] = [
                'order_id' => $order['order_id'],
                'old_status' => null,
                'new_status' => $order['status'],
                'reason' => 'Initial status (historical data)',
                'changed_by' => $order['added_by'],
                'changed_date' => $order['date']
            ];
        }
        
        if (!empty($batch_data)) {
            $this->tenantDb->insert_batch('order_status_log', $batch_data);
            echo json_encode([
                'status' => 'success', 
                'message' => 'Created history entries for ' . count($batch_data) . ' orders'
            ]);
        } else {
            echo json_encode([
                'status' => 'success', 
                'message' => 'All orders already have history entries'
            ]);
        }
    }
    
    /**
     * Get order status history for display
     */
    function getOrderHistory() {
        try {
            $order_id = $this->input->post('order_id');
            
            if (empty($order_id)) {
                echo json_encode(['status' => 'error', 'message' => 'Order ID is required']);
                return;
            }
            
            // Ensure the table exists first
            $this->ensureStatusLogTableExists();
            
            // Try to get order history from log table using tenant database
            $history = [];
            
            // Use direct query with user information
            $query = $this->tenantDb->query("
                SELECT 
                    osl.old_status, 
                    osl.new_status, 
                    osl.reason, 
                    osl.changed_date,
                    osl.changed_by,
                    CONCAT(u.first_name, ' ', u.last_name) as changed_by_name,
                    u.username as changed_by_username
                FROM order_status_log osl
                LEFT JOIN Global_users u ON u.id = osl.changed_by
                WHERE osl.order_id = ? 
                ORDER BY osl.changed_date ASC
            ", [$order_id]);
            
            if ($query) {
                $history = $query->result_array();
            }
            
            // If no history found, get order creation info and create initial entry
            if (empty($history)) {
                $current_order_query = $this->tenantDb->query("
                    SELECT 
                        o.status, 
                        o.date, 
                        o.added_by,
                        CONCAT(u.first_name, ' ', u.last_name) as created_by_name,
                        u.username as created_by_username
                    FROM orders o
                    LEFT JOIN Global_users u ON u.id = o.added_by
                    WHERE o.order_id = ?
                ", [$order_id]);
                
                if ($current_order_query && $current_order_query->num_rows() > 0) {
                    $current_order = $current_order_query->row_array();
                    
                    // Insert initial history entry with creator info
                    $this->tenantDb->query("
                        INSERT INTO order_status_log (order_id, old_status, new_status, reason, changed_by, changed_date) 
                        VALUES (?, NULL, ?, ?, ?, ?)
                    ", [
                        $order_id, 
                        $current_order['status'], 
                        'Order created', 
                        $current_order['added_by'] ?? 1,
                        $current_order['date']
                    ]);
                    
                    // Return the created history with user info
                    $history = [[
                        'old_status' => null,
                        'new_status' => $current_order['status'],
                        'reason' => 'Order created',
                        'changed_date' => $current_order['date'],
                        'changed_by' => $current_order['added_by'],
                        'changed_by_name' => $current_order['created_by_name'] ?? 'Unknown',
                        'changed_by_username' => $current_order['created_by_username'] ?? ''
                    ]];
                }
            }
            
            echo json_encode([
                'status' => 'success', 
                'data' => $history ?: []
            ]);
            
        } catch (Exception $e) {
            error_log('Order History Error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error', 
                'message' => 'Unable to load order history: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Admin function to manually update order status
     * Used when status was not updated automatically or by mistake
     */
    public function adminUpdateOrderStatus() {
        // Check if user is admin
        if (!$this->ion_auth->is_admin()) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Access denied. Only administrators can update order status.'
            ]);
            return;
        }
        
        $order_id = $this->input->post('order_id');
        $new_status = $this->input->post('new_status');
        $reason = $this->input->post('reason');
        
        // Validate inputs
        if (empty($order_id) || !isset($new_status) || empty($reason)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Order ID, status, and reason are required.'
            ]);
            return;
        }
        
        try {
            // Get current order status
            $order = $this->tenantDb->query("
                SELECT status, order_id 
                FROM orders 
                WHERE order_id = ?
            ", [$order_id])->row_array();
            
            if (empty($order)) {
                log_message('error', "ADMIN ORDER STATUS UPDATE FAILED: Order ID={$order_id} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Order not found.'
                ]);
                return;
            }
            
            $old_status = $order['status'];
            
            // Check if status is actually changing
            if ($old_status == $new_status) {
                log_message('warning', "ADMIN ORDER STATUS UPDATE: Order ID={$order_id} already in status {$new_status}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Order is already in this status.'
                ]);
                return;
            }
            
            $admin_name = $this->session->userdata('username') ?: 'Admin';
            $admin_id = $this->session->userdata('user_id') ?: 'UNKNOWN';
            
            log_message('info', "ADMIN ORDER STATUS UPDATE: Order ID={$order_id}, Old Status={$old_status}, New Status={$new_status}, Reason={$reason}, Admin={$admin_name}, Admin ID={$admin_id}, IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            
            // Update order status
            $update_data = ['status' => $new_status];
            
            // If marking as delivered, also update delivered_date and is_delivered
            if ($new_status == 4) {
                $update_data['delivered_date'] = australia_datetime();
                $update_data['is_delivered'] = 1;
            }
            
            $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $update_data);
            $affected_rows = $this->tenantDb->affected_rows();
            
            // Log the status change with admin note
            $full_reason = "ADMIN UPDATE by {$admin_name}: {$reason}";
            $this->logOrderStatusChange($order_id, $old_status, $new_status, $full_reason);
            
            if ($affected_rows > 0) {
                log_message('info', "ADMIN ORDER STATUS UPDATE SUCCESS: Order ID={$order_id}, Status changed from {$old_status} to {$new_status}, Affected rows={$affected_rows}, Admin={$admin_name} at " . australia_datetime());
            } else {
                log_message('warning', "ADMIN ORDER STATUS UPDATE: No rows affected for Order ID={$order_id}. Admin={$admin_name} at " . australia_datetime());
            }
            
            // Get status text for response
            $status_text = $this->getOrderStatusText($new_status);
            
            // IMPORTANT: Auto-generate invoice if status changed to Delivered (4)
            if ($new_status == 4) {
                log_message('info', "INVOICE AUTO-GENERATE: Attempting to auto-generate invoice for Order ID={$order_id} via admin status update, Admin={$admin_name} at " . australia_datetime());
                $invoice_result = $this->autoGenerateInvoice($order_id);
                if ($invoice_result) {
                    log_message('info', "INVOICE AUTO-GENERATE SUCCESS: Invoice generated for Order ID={$order_id} via admin status update at " . australia_datetime());
                } else {
                    log_message('warning', "INVOICE AUTO-GENERATE FAILED: Could not generate invoice for Order ID={$order_id} via admin status update at " . australia_datetime());
                }
            }
            
            // Create notification for important status changes
            if (in_array($new_status, [3, 4, 2, 0])) {
                $msg = "Order #{$order_id} status manually updated to {$status_text} by admin. Reason: {$reason}";
                createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
            }
            
            echo json_encode([
                'status' => 'success',
                'message' => "Order status updated to '{$status_text}' successfully." . ($new_status == 4 ? " Invoice generated automatically." : "")
            ]);
            
        } catch (Exception $e) {
            error_log('Admin Status Update Error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Ensure the order status log table exists
     */
    private function ensureStatusLogTableExists() {
        $this->tenantDb->query("CREATE TABLE IF NOT EXISTS order_status_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            old_status INT,
            new_status INT,
            reason TEXT,
            changed_by INT,
            changed_date DATETIME,
            INDEX idx_order_id (order_id)
        )");
    }
    
    /**
     * Test method to check database connectivity and table status
     */
    function testHistorySetup() {
        try {
            // Test tenant database connection
            $db_test = $this->tenantDb->query("SELECT 1 as test")->row_array();
            
            // Create table if needed
            $this->ensureStatusLogTableExists();
            
            // Test table existence
            $table_test = $this->tenantDb->query("SHOW TABLES LIKE 'order_status_log'")->row_array();
            
            // Get sample order for testing
            $sample_order = $this->tenantDb->query("SELECT order_id, status FROM orders LIMIT 1")->row_array();
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Database setup test completed',
                'data' => [
                    'db_connection' => !empty($db_test),
                    'table_exists' => !empty($table_test),
                    'sample_order' => $sample_order,
                    'tenant_db_config' => get_class($this->tenantDb)
                ]
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database test failed: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Simulate complete order lifecycle for testing (creates sample history data)
     */
    function simulateOrderLifecycle() {
        try {
            $order_id = $this->input->post('order_id');
            
            if (empty($order_id)) {
                echo json_encode(['status' => 'error', 'message' => 'Order ID is required']);
                return;
            }
            
            // Ensure table exists
            $this->ensureStatusLogTableExists();
            
            // Clear existing history for this order
            $this->tenantDb->query("DELETE FROM order_status_log WHERE order_id = ?", [$order_id]);
            
            // Create complete order lifecycle history
            $sample_history = [
                [
                    'order_id' => $order_id,
                    'old_status' => null,
                    'new_status' => 1,
                    'reason' => 'Order created by nurse for patient',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => $this->getAustraliaDateTimeOffset('-2 hours')
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 1,
                    'new_status' => 3,
                    'reason' => 'All menu items completed by chef',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => $this->getAustraliaDateTimeOffset('-1 hour')
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 3,
                    'new_status' => 4,
                    'reason' => 'All categories delivered to patient',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => $this->getAustraliaDateTimeOffset('-30 minutes')
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 4,
                    'new_status' => 2,
                    'reason' => 'Order marked as paid',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => $this->getAustraliaDateTimeOffset('-10 minutes')
                ]
            ];
            
            // Insert sample history
            $this->tenantDb->insert_batch('order_status_log', $sample_history);
            
            // Update the actual order status to paid
            $this->tenantDb->query("UPDATE orders SET status = 2 WHERE order_id = ?", [$order_id]);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Sample order lifecycle created successfully! Now click the history button to see the complete timeline.',
                'data' => [
                    'order_id' => $order_id,
                    'entries_created' => count($sample_history),
                    'lifecycle_stages' => [
                        'Step 1: Order Created (Pending)',
                        'Step 2: Chef Completed Food (Ready for Delivery)', 
                        'Step 3: Food Delivered (Delivered)',
                        'Step 4: Payment Processed (Paid)'
                    ]
                ]
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to create sample history: ' . $e->getMessage()
            ]);
        }
    }
    
   
    
    // Order List and Histroy and Invoice related code ==================================================================================
    
    
    function orderList(){
     
     $conditions['listtype'] = 'department';
     $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
     $data['departmentListData']  = $departmentListData;

     $orderList   = $this->order_model->orderList();
     $data['orderLists'] = (isset($orderList) && !empty($orderList) ? $orderList : array());
     $this->load->view('general/header');
     $this->load->view('Orders/orderList',$data);   
     $this->load->view('general/footer');
     
    }
    
    function viewOrderHistoryDetails($orderId,$orderDate,$deptId){
        
       
        // ✅ PATIENT ID FIX: Pass orderId to commonData so it uses patient_id from orders_to_patient_options
        // This ensures historical orders show the ORIGINAL patient, not the current patient in the suite
        $result = $this->commonData($deptId, $orderId);
        
        // 🔒 FILTER: Show only occupied suites (suites with patients)
        $bedLists = $result['bedLists'];
        $occupiedBedLists = [];
        if (!empty($bedLists)) {
            foreach ($bedLists as $bedList) {
                // Only include suites that have a patient_name (occupied suites)
                if (!empty($bedList['patient_name'])) {
                    $occupiedBedLists[] = $bedList;
                }
            }
        }
        
        $conditionsM = array('date' => $orderDate,'status' => 2);
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM);

        $data['menuLists']   = $result['menuLists'];
        $data['bedLists']   = $occupiedBedLists; // 🔒 Only occupied suites
        $data['categoryListData']   = $result['categoryListData'];
        
         if(empty($savedData)){
        $conditionsAll = array('date' => $orderDate,'status' => 2,'department_id'=> '0');
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsAll);     
        }
       

       if (!empty($savedData)) {
        // Deserialize the saved menu data
        $savedMenuWithoutOptions = unserialize($savedData[0]['menuWithoutOptions']);
        $savedMenuWithOptions = unserialize($savedData[0]['menuWithOptions']);
      }
    //  99 percent of time we will have menu with options, for case menu without options we can still menu itslef as menu options
      $data['savedMenuWithoutOptions'] = $savedMenuWithoutOptions; // menuplanner planned by chef for menu without options
      $data['savedMenuWithOptions'] = $savedMenuWithOptions;  // menuplanner planned by chef for menu with options
       
       
      
        // pass true to fetch order details based on order_id rather than dept_id
       
       $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', ['order_id','is_delivered','buttonType'], ['order_id' =>$orderId]);
       $patientOrderData = [];
      
       $bedOrderData = [];
      $buttonType ='';
      $orderCommentBedWise = [];
      if (isset($todaysOrders) && !empty($todaysOrders)) {
        $orderId =  $todaysOrders[0]['order_id'];
        $buttonType = $todaysOrders[0]['buttonType'];
        $selected_options = [];
        $todaysOrderData = $this->order_model->fetchOrderAndMenuOptions($orderId);
    //   echo "<pre>"; print_r($todaysOrderData);exit;
      foreach ($todaysOrderData as $opt) {

       $key = $opt['bed_id'] . '_' .$opt['category_id'] . '_' . $opt['menu_id'];
       $selected_options[$key][] = $opt['option_id'];
       $orderCommentBedWise[$opt['bed_id']] = $opt['order_comment'];

       }

     $data['patientOrderData'] = $selected_options; 
     
      }else{
      $bedOrderData = array();   
     }
       $data['buttonType'] = $buttonType;
       $data['orderCommentBedWise'] = $orderCommentBedWise;
     
        
        
      $data['orderId'] = $orderId;
  
      $data['date'] = $orderDate;
    //   echo "<pre>";print_r($data['patientOrderData']); exit;  
      $this->load->view('general/header');
      $this->load->view('Orders/viewOrderPatientwise',$data);   
      $this->load->view('general/footer');
        
    }
    
    /**
     * View historical order details - dedicated method for order history
     * This method works for any past order regardless of current date/timezone
     */
    function viewHistoricalOrder($orderId, $orderDate, $deptId) {
        // Validate inputs
        if (empty($orderId) || empty($orderDate) || empty($deptId)) {
            show_404();
            return;
        }
        
        // Convert date format if needed (handle both d-m-Y and Y-m-d formats)
        $formattedDate = $this->normalizeDate($orderDate);
        
        // Debug: Log the date processing
        log_message('debug', "viewHistoricalOrder - Original date: $orderDate, Formatted date: $formattedDate");
        
        // Get order details
        $orderDetails = $this->common_model->fetchRecordsDynamically('orders', 
            ['order_id', 'date', 'dept_id', 'workflow_status', 'buttonType', 'is_delivered', 'is_floor_consolidated'], 
            ['order_id' => $orderId]
        );
        
        if (empty($orderDetails)) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('Orderportal/Order/orderList');
            return;
        }
        
        $order = $orderDetails[0];
        
        // ✅ PATIENT ID FIX: Pass orderId to commonData so it uses patient_id from orders_to_patient_options
        // This ensures historical orders show the ORIGINAL patient, not the current patient in the suite
        $result = $this->commonData($deptId, $orderId);
        
        // 🔒 FILTER: Show only occupied suites (suites with patients)
        $bedLists = $result['bedLists'];
        $occupiedBedLists = [];
        if (!empty($bedLists)) {
            foreach ($bedLists as $bedList) {
                // Only include suites that have a patient_name (occupied suites)
                if (!empty($bedList['patient_name'])) {
                    $occupiedBedLists[] = $bedList;
                }
            }
        }
        
        // Get menu planner data for the order date
        $menuPlannerData = $this->getMenuPlannerForDate($formattedDate);
        
        // Get order menu options - use correct method based on order type
        $isFloorConsolidated = !empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1;
        if ($isFloorConsolidated) {
            
            $orderMenuOptions = $this->order_model->fetchFloorOrderAndMenuOptions($orderId);
        } else {
            
            $orderMenuOptions = $this->order_model->fetchOrderAndMenuOptions($orderId);
        }
        
        // echo "<pre>"; print_r($orderMenuOptions); exit;
        
        // Check if this is a chef view
        $isChefView = $this->input->get('view') === 'chef';
        
        // Process order data - use different structure for chef view vs regular view
        $patientOrderData = [];
        $orderCommentBedWise = [];
        
        if (!empty($orderMenuOptions)) {
            foreach ($orderMenuOptions as $opt) {
                if ($isChefView) {
                    // For chef view (orderDeliverypage): use bed_id_category_id format
                    $key = $opt['bed_id'] . '_' . $opt['category_id'];
                    if (!isset($patientOrderData[$key])) {
                        $patientOrderData[$key] = [];
                    }
                    if (!in_array($opt['menu_id'], $patientOrderData[$key])) {
                        $patientOrderData[$key][] = $opt['menu_id'];
                    }
                } else {
                    // For regular view: use bed_id_category_id_menu_id format
                    $key = $opt['bed_id'] . '_' . $opt['category_id'] . '_' . $opt['menu_id'];
                    $patientOrderData[$key][] = $opt['option_id'];
                }
                $orderCommentBedWise[$opt['bed_id']] = $opt['order_comment'];
            }
        }
        
        // CRITICAL FIX: Safely format display date using Australia/Sydney timezone
        $timezone = new DateTimeZone('Australia/Sydney');
        $dateObj = DateTime::createFromFormat('Y-m-d', $formattedDate, $timezone);
        if ($dateObj === false) {
            // Try alternative parsing
            $dateObj = new DateTime($formattedDate, $timezone);
            if ($dateObj === false) {
                // Last resort: use the original date
                $displayDate = $orderDate;
                log_message('error', "Failed to parse date: $formattedDate, using original: $orderDate");
            } else {
                $displayDate = $dateObj->format('d-m-Y');
            }
        } else {
            $displayDate = $dateObj->format('d-m-Y');
        }
        
        
        // Prepare data for view
        $data = [
            'orderId' => $orderId,
            'orderDate' => $formattedDate,
            'displayDate' => $displayDate,
            'date' => $orderDate, // Template expects $date variable (raw date for strtotime)
            'deptId' => $deptId,
            'order' => $order,
            'menuLists' => $result['menuLists'],
            'bedLists' => $occupiedBedLists, // 🔒 Only occupied suites
            'categoryListData' => $result['categoryListData'],
            'savedMenuWithOptions' => $menuPlannerData['menuWithOptions'],
            'savedMenuWithoutOptions' => $menuPlannerData['menuWithoutOptions'],
            'savedMenus' => array_keys($menuPlannerData['menuWithOptions']), // Delivery page expects savedMenus array
            'patientOrderData' => $patientOrderData,
            'orderCommentBedWise' => $orderCommentBedWise,
            'orderMenuOptions' => $orderMenuOptions, // Delivery page needs this for option names
            'buttonType' => $order['buttonType'],
            'isHistorical' => true, // Flag to indicate this is a historical view
            'isChefView' => $isChefView, // Flag to indicate if this is chef view
            'bednNotes' => [], // Empty array for bed notes
            'alreadyDeliveredCategoryAndPatient' => [] // Empty array for delivered items
        ];
        
        // echo "<pre>"; print_r($data); exit;
        
        // Load the appropriate view based on type
        $this->load->view('general/header');
        if ($isChefView) {
            $this->load->view('Orders/orderDeliverypage', $data); // Chef view uses delivery page with chef functionality
        } else {
            $this->load->view('Orders/viewOrderPatientwise', $data); // Regular view
        }
        $this->load->view('general/footer');
    }
    
    /**
     * Normalize date format to Y-m-d
     */
    private function normalizeDate($date) {
        // Handle different date formats
        if (strpos($date, '-') !== false) {
            $parts = explode('-', $date);
            if (count($parts) == 3) {
                // Check if it's d-m-Y format (day-month-year)
                if (strlen($parts[0]) <= 2 && strlen($parts[1]) <= 2 && strlen($parts[2]) == 4) {
                    return $parts[2] . '-' . $parts[1] . '-' . $parts[0]; // Convert d-m-Y to Y-m-d
                }
                // Check if it's already Y-m-d format
                if (strlen($parts[0]) == 4 && strlen($parts[1]) <= 2 && strlen($parts[2]) <= 2) {
                    return $date; // Already Y-m-d format
                }
            }
        }
        
        // CRITICAL FIX: If we can't determine the format, try to parse it using Australia/Sydney timezone
        $timezone = new DateTimeZone('Australia/Sydney');
        $dateObj = DateTime::createFromFormat('Y-m-d', $date, $timezone);
        if ($dateObj === false) {
            $dateObj = new DateTime($date, $timezone);
            if ($dateObj !== false) {
                return $dateObj->format('Y-m-d');
            }
        } else {
            return $dateObj->format('Y-m-d');
        }
        
        // Last resort: return as-is
        return $date;
    }
    
    /**
     * Get menu planner data for a specific date
     * ✅ MENU IS ALWAYS COMMON FOR ALL: department_id = 0 is the common menu for all departments
     */
    private function getMenuPlannerForDate($date) {
        // Try published menu first (status = 2) - always use common menu (department_id = 0)
        $conditions = [
            'date' => $date,
            'status' => 2,
            'department_id' => 0
        ];
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
        
        // If no published menu found, try saved menus (status = 1) - always use common menu (department_id = 0)
        if (empty($savedData)) {
            $conditions = [
                'date' => $date,
                'status' => 1,
                'department_id' => 0
            ];
            $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
        }
        
        $savedMenuWithoutOptions = [];
        $savedMenuWithOptions = [];
        
        if (!empty($savedData)) {
            $savedMenuWithoutOptions = unserialize($savedData[0]['menuWithoutOptions']) ?: [];
            $savedMenuWithOptions = unserialize($savedData[0]['menuWithOptions']) ?: [];
        }
        
        return [
            'menuWithoutOptions' => $savedMenuWithoutOptions,
            'menuWithOptions' => $savedMenuWithOptions
        ];
    }
    
    /**
     * Transform weekly menu data format for orders system
     * Weekly format: [menu_id1, menu_id2, ...]
     * Orders format: [category_id => [menu_id => [option_id1, option_id2, ...]]]
     */
    private function transformWeeklyMenuDataForOrders($weeklyMenuData) {
        if (empty($weeklyMenuData) || !is_array($weeklyMenuData)) {
            return [];
        }
        
        // Get menu details to structure data properly
        $menuDetails = $this->menu_model->fetchMenuDetails('', true);
        $structuredData = [];
        
        foreach ($weeklyMenuData as $menuId) {
            // Find the menu in our menu details
            foreach ($menuDetails as $menu) {
                if ($menu['menu_id'] == $menuId) {
                    // Get the first category for this menu
                    $categoryId = !empty($menu['category_ids']) ? $menu['category_ids'][0] : 1;
                    
                    // Initialize category if not exists
                    if (!isset($structuredData[$categoryId])) {
                        $structuredData[$categoryId] = [];
                    }
                    
                    // Add all menu options for this menu
                    $optionIds = [];
                    if (!empty($menu['menu_options'])) {
                        foreach ($menu['menu_options'] as $option) {
                            $optionIds[] = $option['option_id'];
                        }
                    }
                    $structuredData[$categoryId][$menuId] = $optionIds;
                    break;
                }
            }
        }
        
        return $structuredData;
    }
    
    // Associate existing menu item comments with a newly created order
    private function associateCommentsWithOrder($orderId, $deptId, $orderDate) {
        try {
            // FIXED: Associate comments that were created yesterday for today's order
            // This handles the workflow where reception adds comments for tomorrow's orders
            $orderDateObj = new DateTime($orderDate);
            $commentDate = $orderDateObj->modify('-1 day')->format('Y-m-d');
            
            $sql = "UPDATE menu_item_comments mic
                    JOIN suites s ON s.id = mic.bed_id 
                    SET mic.order_id = ? 
                    WHERE mic.order_id = 0 
                    AND DATE(mic.created_at) = ? 
                    AND s.floor = ?";
            
            $this->tenantDb->query($sql, [$orderId, $commentDate, $deptId]);
            
            $affectedRows = $this->tenantDb->affected_rows();
            if ($affectedRows > 0) {
                // Debug: Comment association
                // error_log("Associated {$affectedRows} comments (from {$commentDate}) with order #{$orderId} for {$orderDate}");
            } else {
                // Fallback: Also try to associate comments from the same day
                $this->tenantDb->query($sql, [$orderId, $orderDate, $deptId]);
                $affectedRows = $this->tenantDb->affected_rows();
                if ($affectedRows > 0) {
                    // Debug: Comment association fallback
                    // error_log("Associated {$affectedRows} comments (from {$orderDate}) with order #{$orderId}");
                }
            }
            
        } catch (Exception $e) {
            error_log('Error associating comments with order: ' . $e->getMessage());
        }
    }
    
    // Save menu item comment
    public function saveMenuItemComment() {
        try {
            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
                return;
            }
            
            $bedId = $input['bed_id'] ?? null;
            $menuId = $input['menu_id'] ?? null;
            $optionId = $input['option_id'] ?? null;
            $comment = trim($input['comment'] ?? '');
            
            if (!$bedId || !$menuId || !$optionId) {
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                return;
            }
            
            // Use tenant database
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            $today = $this->getAustraliaDate();
            $tomorrow = $this->getAustraliaTomorrow();
            
            // Get tomorrow's order_id for proper association (orders are placed today for tomorrow's delivery)
            $orderQuery = $this->tenantDb->query("
                SELECT order_id FROM orders 
                WHERE DATE(date) = ? 
                AND dept_id = ? 
                ORDER BY order_id DESC LIMIT 1", 
                [$tomorrow, $this->session->userdata('department_id')]
            );
            $orderResult = $orderQuery->row();
            $orderId = $orderResult ? $orderResult->order_id : 0;
            
            // Get current user role for proper attribution
            $userRole = $this->ion_auth->get_users_groups()->row()->id;
            $roleNames = [1 => 'admin', 2 => 'chef', 3 => 'nurse', 4 => 'patient', 6 => 'reception'];
            $addedByRole = $roleNames[$userRole] ?? 'user';
            
            if (empty($comment)) {
                // Delete comment if empty - use order_id to find comments for this order
                $sql = "DELETE FROM menu_item_comments 
                       WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND order_id = ?";
                $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $orderId]);
            } else {
                // Check if comment exists for this order
                $sql = "SELECT id FROM menu_item_comments 
                       WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND order_id = ?";
                $query = $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $orderId]);
                $existing = $query->row();
                
                if ($existing) {
                    // Update existing comment
                    $sql = "UPDATE menu_item_comments 
                           SET comment = ?, updated_at = NOW() 
                           WHERE id = ?";
                    $this->tenantDb->query($sql, [$comment, $existing->id]);
                } else {
                    // Insert new comment with proper order_id and role
                    $sql = "INSERT INTO menu_item_comments (order_id, bed_id, menu_id, option_id, comment, added_by, added_by_role, created_at, updated_at) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
                    $currentUserId = $this->ion_auth->user()->row()->id;
                    $this->tenantDb->query($sql, [$orderId, $bedId, $menuId, $optionId, $comment, $currentUserId, $addedByRole]);
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Comment saved successfully']);
            
        } catch (Exception $e) {
            error_log('Error saving menu item comment: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    
    // Get menu item comment
    public function getMenuItemComment() {
        try {
            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
                return;
            }
            
            $bedId = $input['bed_id'] ?? null;
            $menuId = $input['menu_id'] ?? null;
            $optionId = $input['option_id'] ?? null;
            
            if (!$bedId || !$menuId || !$optionId) {
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                return;
            }
            
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            // Use tenant database
            $tomorrow = $this->getAustraliaTomorrow();
            
            // Get tomorrow's order_id for proper association (orders are placed today for tomorrow's delivery)
            $orderQuery = $this->tenantDb->query("
                SELECT order_id FROM orders 
                WHERE DATE(date) = ? 
                AND dept_id = ? 
                ORDER BY order_id DESC LIMIT 1", 
                [$tomorrow, $this->session->userdata('department_id')]
            );
            $orderResult = $orderQuery->row();
            $orderId = $orderResult ? $orderResult->order_id : 0;
            
            // If no order exists for tomorrow, return empty comment (don't show old comments)
            if ($orderId == 0) {
                echo json_encode(['success' => true, 'comment' => '']);
                return;
            }
            
            $sql = "SELECT comment FROM menu_item_comments 
                   WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND order_id = ?
                   ORDER BY created_at DESC LIMIT 1";
            
            $query = $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $orderId]);
            $result = $query->row();
            
            if ($result) {
                echo json_encode(['success' => true, 'comment' => $result->comment]);
            } else {
                echo json_encode(['success' => true, 'comment' => '']);
            }
            
        } catch (Exception $e) {
            error_log('Error getting menu item comment: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Get Room Service status for a suite
     */
    public function getRoomServiceStatus() {
        $suiteId = $this->input->post('suite_id');
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $orderDate = $this->input->post('order_date') ?: $this->getAustraliaDate();
        if ($orderDate) {
            $orderDate = $this->getAustraliaDate($orderDate);
        }
        
        if (!$suiteId) {
            echo json_encode(['success' => false, 'message' => 'Suite ID is required']);
            return;
        }
        
        $query = $this->tenantDb->query(
            "SELECT * FROM room_service_status WHERE suite_id = ? AND order_date = ?",
            [$suiteId, $orderDate]
        );
        
        $status = $query->row_array();
        
        echo json_encode([
            'success' => true,
            'is_done' => $status ? (bool)$status['is_done'] : false,
            'marked_at' => $status['marked_at'] ?? null,
            'marked_by_role' => $status['marked_by_role'] ?? null
        ]);
    }
    
    /**
     * Update Room Service status for a suite
     */
    public function updateRoomServiceStatus() {
        $suiteId = $this->input->post('suite_id');
        $pin = $this->input->post('pin');
        $isDone = $this->input->post('is_done');
        $orderDate = $this->input->post('order_date') ?: australia_date_only();
        $nurseName = $this->input->post('nurse_name'); // 🔧 For pre-verified nurse PIN flow
        
        if (!$suiteId) {
            echo json_encode(['success' => false, 'message' => 'Suite ID is required']);
            return;
        }
        
        // Get current user info
        $userId = $this->ion_auth->user()->row()->id;
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        
        // 🔧 FIX: If nurse_name is provided, it means nurse PIN was already verified separately
        // This happens when reception uses Nurse PIN verification (like order override)
        if (!$nurseName) {
            // Original flow: Verify PIN based on role
            if ($pin === null) {
                echo json_encode(['success' => false, 'message' => 'PIN is required']);
                return;
            }
            
            if ($userRole == 6 || $userRole == 4) {
                // Reception/Client: Verify suite PIN
                $suiteQuery = $this->tenantDb->query(
                    "SELECT suite_pin FROM suites WHERE id = ?",
                    [$suiteId]
                );
                $suite = $suiteQuery->row();
                
                if (!$suite || $suite->suite_pin != $pin) {
                    echo json_encode(['success' => false, 'message' => 'PIN is wrong']);
                    return;
                }
            } elseif ($userRole == 3) {
                // Nurse: Verify nurse's own PIN from Global_users table
                $nurseQuery = $this->tenantDb->query(
                    "SELECT pin FROM Global_users WHERE id = ? AND active = 1",
                    [$userId]
                );
                $nurse = $nurseQuery->row();
                
                if (!$nurse || $nurse->pin != $pin) {
                    echo json_encode(['success' => false, 'message' => 'PIN is wrong']);
                    return;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Unauthorized role']);
                return;
            }
        }
        // If nurse_name is provided, PIN verification was already done via verifyAnyNursePin
        
        // Update or insert room service status
        $existingQuery = $this->tenantDb->query(
            "SELECT id FROM room_service_status WHERE suite_id = ? AND order_date = ?",
            [$suiteId, $orderDate]
        );
        
        if ($existingQuery->num_rows() > 0) {
            // Update existing record
            $this->tenantDb->query(
                "UPDATE room_service_status 
                SET is_done = ?, marked_by_user_id = ?, marked_by_role = ?, marked_at = NOW(), updated_at = NOW()
                WHERE suite_id = ? AND order_date = ?",
                [$isDone, $userId, $userRole, $suiteId, $orderDate]
            );
        } else {
            // Insert new record
            $this->tenantDb->query(
                "INSERT INTO room_service_status (suite_id, order_date, is_done, marked_by_user_id, marked_by_role, marked_at)
                VALUES (?, ?, ?, ?, ?, NOW())",
                [$suiteId, $orderDate, $isDone, $userId, $userRole]
            );
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Room Service status updated successfully',
            'is_done' => (bool)$isDone
        ]);
    }
    
    /**
     * Check if email notification should be sent (only for late orders)
     * 
     * Late orders are defined as:
     * - Current time is after 10:32 AM Australian time
     * - Order is for TODAY (not tomorrow)
     * 
     * @param string $orderDateFormatted Order date in d-m-Y format
     * @return bool True if notification should be sent
     */
    private function shouldSendLateOrderNotification($orderDateFormatted) {
        // Set Australia/Sydney timezone
        $timezone = new DateTimeZone('Australia/Sydney');
        $now = new DateTime('now', $timezone);
        
        // Check if current time is after 10:32 AM
        $cutoffTime = new DateTime('today 10:32:00', $timezone);
        $isAfterCutoff = $now > $cutoffTime;
        
        // Parse order date (format: d-m-Y, e.g., "24-10-2025")
        $orderDateParsed = DateTime::createFromFormat('d-m-Y', $orderDateFormatted, $timezone);
        if (!$orderDateParsed) {
            log_message('error', "Failed to parse order date: {$orderDateFormatted}");
            return false;
        }
        
        // Check if order is for TODAY
        $todayDate = $now->format('Y-m-d');
        $orderDate = $orderDateParsed->format('Y-m-d');
        $isForToday = ($orderDate === $todayDate);
        
        $result = $isAfterCutoff && $isForToday;
        
        log_message('info', "LATE ORDER CHECK: Time={$now->format('H:i')}, After 10:32={$isAfterCutoff}, Order Date={$orderDate}, Today={$todayDate}, IsForToday={$isForToday}, Send Email={$result}, Timestamp=" . australia_datetime());
        
        return $result;
    }
    
    /**
     * Send email notification to chef when order is placed or updated
     * 
     * @param int $orderId The order ID
     * @param string $floorName Floor name/ID
     * @param string $suiteNumber Suite number
     * @param string $orderDate Date for which order is placed
     * @param bool $isUpdate Whether this is an update (true) or new order (false)
     * @param array $orderItems Array of order items with menu details
     */
    private function sendOrderNotificationEmail($orderId, $floorName, $suiteNumber, $orderDate, $isUpdate = false, $orderItems = []) {
        try {
            // Chef email address
            $chefEmail = 'ggchef_kelum@zenncafe.com.au';
            
            // Email subject
            $orderType = $isUpdate ? 'ORDER UPDATED' : 'NEW ORDER RECEIVED';
            $subject = "{$orderType} - Suite {$suiteNumber} - {$orderDate}";
            
            // Ensure SMTP settings are loaded
            if (!$this->session->userdata('mail_protocol')) {
                $emailSettings = $this->fetchSmtpSettingsAtRunTimeForCronJobs();
                if ($emailSettings) {
                    $this->configureSMTP($emailSettings);
                }
            }
            
            // Get user information
            $userName = $this->session->userdata('username') ?: 'Unknown User';
            $userRole = $this->ion_auth->get_users_groups()->row();
            $roleName = $userRole ? $userRole->name : 'User';
            
            // Prepare data for email view (same as Invoice module)
            $emailData = [
                'floorName' => $floorName,
                'suiteNumber' => $suiteNumber,
                'orderDate' => $orderDate,
                'userName' => $userName,
                'roleName' => $roleName,
                'orderItems' => $orderItems,
                'isUpdate' => $isUpdate
            ];
            
            // Load email content from view (same approach as Invoice module)
            $email_content = $this->load->view('Email/orderNotification', $emailData, TRUE);
            
            // Try to send email using EXACT same method as Invoice module
            try {
                log_message('info', "EMAIL SEND ATTEMPT: Order ID={$orderId}, To={$chefEmail}, Subject={$subject}, Order Type=" . ($isUpdate ? 'UPDATE' : 'NEW') . ", Suite={$suiteNumber}, Order Date={$orderDate}, User={$userName}, Role={$roleName}, IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                
                $result = $this->sendEmail(
                    $chefEmail,
                    $subject,
                    $email_content,
                    'info@bizadmin.com.au',
                    '',
                    'Bizorder'
                );
                
                if ($result) {
                    log_message('info', "EMAIL SEND SUCCESS: Order ID={$orderId}, To={$chefEmail}, Subject={$subject}, Suite={$suiteNumber}, Order Date={$orderDate} at " . australia_datetime());
                } else {
                    log_message('warning', "EMAIL SEND FAILED: Order ID={$orderId}, To={$chefEmail}, Subject={$subject}, Suite={$suiteNumber}, Order Date={$orderDate}, Order saved successfully but email failed, User={$userName} at " . australia_datetime());
                }
            } catch (Exception $emailEx) {
                // Email failed but order is saved - log error and continue
                log_message('error', "EMAIL SEND EXCEPTION: Order ID={$orderId}, To={$chefEmail}, Subject={$subject}, Suite={$suiteNumber}, Order Date={$orderDate}, Error=" . $emailEx->getMessage() . ", User={$userName}, IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                $result = false;
            }
            
            // Return true anyway so order continues
            return true;
            
        } catch (Exception $e) {
            log_message('error', "EMAIL SEND EXCEPTION: Order ID={$orderId}, Exception=" . $e->getMessage() . ", Stack trace: " . $e->getTraceAsString() . ", Timestamp=" . australia_datetime());
            return false;
        }
    }
    
    /**
     * Simple test endpoint to verify routing
     */
    public function testEndpoint() {
        echo json_encode([
            'success' => true,
            'message' => 'Endpoint is accessible',
            'timestamp' => australia_datetime()
        ]);
    }
    
    /**
     * Check for late orders/suite updates placed/updated after 10:30 AM for today or tomorrow
     * Tracks suite-level changes within floor-consolidated orders
     * Called via AJAX from chef dashboard and production form
     */
    public function checkLateOrders() {
        // Enable error reporting temporarily
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // Basic test to ensure function is accessible
        if (!isset($this->tenantDb)) {
            echo json_encode([
                'success' => false,
                'error' => 'tenantDb not initialized',
                'message' => 'Database connection not available'
            ]);
            return;
        }
        
        try {
            // Get current Australian time
            $australiaTime = new DateTime('now', new DateTimeZone('Australia/Sydney'));
            $currentTime = $australiaTime->format('H:i:s');
            $currentDate = $australiaTime->format('Y-m-d');
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            $tomorrowDateObj = clone $australiaTime;
            $tomorrowDateObj->modify('+1 day');
            $tomorrowDate = $tomorrowDateObj->format('Y-m-d');
            
            // Define cutoff time (10:30 AM Australian time)
            $cutoffTime = '10:30:00';
            
            $lateOrderActivity = [];
            $debugInfo = [];
            
            // DEBUG: Log current time info
            $debugInfo['currentDate'] = $currentDate;
            $debugInfo['tomorrowDate'] = $tomorrowDate;
            $debugInfo['currentTime'] = $currentTime;
            $debugInfo['cutoffTime'] = $cutoffTime;
            
            // Check for late activity for TODAY's orders
            // For today's orders, cutoff was YESTERDAY at 10:30 AM Australia/Sydney time
            // Convert to UTC for database comparison (MySQL TIMESTAMP stores in UTC)
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            $yesterdayDateObj = clone $australiaTime;
            $yesterdayDateObj->modify('-1 day');
            $yesterdayDate = $yesterdayDateObj->format('Y-m-d');
            $yesterdayCutoffDateTime = new DateTime($yesterdayDate . ' ' . $cutoffTime, new DateTimeZone('Australia/Sydney'));
            $yesterdayCutoffDateTime->setTimezone(new DateTimeZone('UTC'));
            $yesterdayCutoff = $yesterdayCutoffDateTime->format('Y-m-d H:i:s');
            $debugInfo['todayCutoffUTC'] = $yesterdayCutoff;
            $debugInfo['todayCutoffAustralia'] = $yesterdayDate . ' ' . $cutoffTime;
            $this->checkLateSuiteActivity($currentDate, $yesterdayCutoff, $lateOrderActivity, 'today', $debugInfo);
            
            // Check for late activity for TOMORROW's orders
            // For tomorrow's orders, cutoff is TODAY at 10:30 AM Australia/Sydney time
            // Convert to UTC for database comparison (MySQL TIMESTAMP stores in UTC)
            $todayCutoffDateTime = new DateTime($currentDate . ' ' . $cutoffTime, new DateTimeZone('Australia/Sydney'));
            $todayCutoffDateTime->setTimezone(new DateTimeZone('UTC'));
            $todayCutoff = $todayCutoffDateTime->format('Y-m-d H:i:s');
            $debugInfo['tomorrowCutoffUTC'] = $todayCutoff;
            $debugInfo['tomorrowCutoffAustralia'] = $currentDate . ' ' . $cutoffTime;
            $this->checkLateSuiteActivity($tomorrowDate, $todayCutoff, $lateOrderActivity, 'tomorrow', $debugInfo);
            
            // Return response
            echo json_encode([
                'success' => true,
                'hasLateOrders' => !empty($lateOrderActivity),
                'lateOrders' => $lateOrderActivity,
                'currentTime' => $australiaTime->format('g:i A'),
                'cutoffTime' => '10:30 AM',
                'debug' => $debugInfo  // Include debug info
            ]);
        } catch (Exception $e) {
            // Return error details
            http_response_code(200); // Send 200 so AJAX success handler processes it
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    /**
     * Helper function to check for late suite activity
     * @param string $orderDate - The date of the order (e.g., '2025-10-28')
     * @param string $cutoffDateTime - The cutoff datetime (e.g., '2025-10-27 10:30:00')
     * @param array &$lateOrderActivity - Array to store late orders
     * @param string $orderType - 'today' or 'tomorrow'
     * @param array &$debugInfo - Debug information array
     */
    private function checkLateSuiteActivity($orderDate, $cutoffDateTime, &$lateOrderActivity, $orderType, &$debugInfo) {
        // cutoffDateTime is expected to be in UTC format for comparison with MySQL TIMESTAMP fields
        // MySQL TIMESTAMP fields are stored in UTC internally
        
        // Find all floor orders for the specified order date that were sent (not drafts)
        $this->tenantDb->select('orders.order_id, orders.date, orders.dept_id, orders.is_floor_consolidated, orders.created_at, orders.updated_at');
        $this->tenantDb->from('orders');
        $this->tenantDb->where('orders.date', $orderDate);
        $this->tenantDb->where('orders.buttonType', 'sendorder');
        
        // Execute query and check for errors
        $query = $this->tenantDb->get();
        if ($query === FALSE) {
            $error = $this->tenantDb->error();
            throw new Exception('Orders query failed: ' . $error['message'] . ' (Code: ' . $error['code'] . ')');
        }
        $floorOrders = $query->result_array();
        
        // DEBUG: Log query and results
        if (!isset($debugInfo[$orderType])) {
            $debugInfo[$orderType] = [];
        }
        $debugInfo[$orderType]['orderDate'] = $orderDate;
        $debugInfo[$orderType]['cutoffDateTime'] = $cutoffDateTime;
        $debugInfo[$orderType]['totalOrders'] = count($floorOrders);
        $debugInfo[$orderType]['orders'] = [];
        
        foreach ($floorOrders as $order) {
            $floorName = fetchDepartmentNameFromId($this->tenantDb, $order['dept_id']);
            $lateSuites = [];
            
            // DEBUG: Track each order
            $orderDebug = [
                'order_id' => $order['order_id'],
                'floor' => $floorName,
                'created_at' => $order['created_at'],
                'updated_at' => $order['updated_at'],
                'is_floor_consolidated' => $order['is_floor_consolidated']
            ];
            
            if ($order['is_floor_consolidated'] == 1) {
                // Floor-consolidated order: Check suite_order_details for late additions/updates
                $this->tenantDb->select('
                    sod.id,
                    sod.suite_number,
                    sod.added_at,
                    sod.modified_at,
                    sod.added_by,
                    gu.username as added_by_name
                ');
                $this->tenantDb->from('suite_order_details sod');
                $this->tenantDb->join('Global_users gu', 'gu.id = sod.added_by', 'left');
                $this->tenantDb->where('sod.floor_order_id', $order['order_id']);
                $this->tenantDb->where('sod.status', 'active');
                
                // Check if suite was added OR modified after the cutoff datetime
                // Session timezone is already set to Australia/Sydney, so direct comparison should work
                $this->tenantDb->group_start();
                $this->tenantDb->where('sod.added_at >', $cutoffDateTime);
                $this->tenantDb->or_where('sod.modified_at >', $cutoffDateTime);
                $this->tenantDb->group_end();
                
                // Execute query and check for errors
                $query = $this->tenantDb->get();
                if ($query === FALSE) {
                    $error = $this->tenantDb->error();
                    throw new Exception('Suite query failed: ' . $error['message'] . ' (Code: ' . $error['code'] . ')');
                }
                $suiteDetails = $query->result_array();
                
                // DEBUG: Track suite query results
                $orderDebug['suites_found'] = count($suiteDetails);
                $orderDebug['suites'] = [];
                
                foreach ($suiteDetails as $suite) {
                    $addedTime = strtotime($suite['added_at']);
                    $modifiedTime = strtotime($suite['modified_at']);
                    
                    // CRITICAL FIX: Determine if this is a new suite or an update using Australia/Sydney timezone
                    $timezone = new DateTimeZone('Australia/Sydney');
                    $addedDateObj = new DateTime('@' . $addedTime);
                    $addedDateObj->setTimezone($timezone);
                    $modifiedDateObj = new DateTime('@' . $modifiedTime);
                    $modifiedDateObj->setTimezone($timezone);
                    $isNewSuite = ($addedDateObj->format('Y-m-d H:i') === $modifiedDateObj->format('Y-m-d H:i'));
                    
                    // DEBUG: Track suite details
                    $orderDebug['suites'][] = [
                        'suite_number' => $suite['suite_number'],
                        'added_at' => $suite['added_at'],
                        'modified_at' => $suite['modified_at'],
                        'is_new' => $isNewSuite,
                        'qualified_as_late' => true
                    ];
                    
                    // 🔧 Get food items for this suite's late order
                    $foodItems = $this->getFoodItemsForSuite($order['order_id'], $suite['suite_number']);
                    
                    $lateSuites[] = [
                        'suite_number' => $suite['suite_number'],
                        'action' => $isNewSuite ? 'NEW ORDER' : 'ORDER UPDATED',
                        'time' => date('g:i A', $modifiedTime > $addedTime ? $modifiedTime : $addedTime),
                        'by' => $suite['added_by_name'] ?: 'Unknown User',
                        'items' => $foodItems // 🔧 Food items ordered
                    ];
                }
            } else {
                // Legacy suite-specific order: Check order creation/update time
                $this->tenantDb->select('orders.created_at, orders.updated_at, orders.bed_id');
                $this->tenantDb->from('orders');
                $this->tenantDb->where('orders.order_id', $order['order_id']);
                
                // Execute query and check for errors
                $query = $this->tenantDb->get();
                if ($query === FALSE) {
                    $error = $this->tenantDb->error();
                    throw new Exception('Legacy order query failed: ' . $error['message'] . ' (Code: ' . $error['code'] . ')');
                }
                $legacyOrder = $query->row_array();
                
                if ($legacyOrder) {
                    $createdTime = strtotime($legacyOrder['created_at']);
                    $updatedTime = strtotime($legacyOrder['updated_at']);
                    $latestTime = max($createdTime, $updatedTime);
                    $cutoffTimestamp = strtotime($cutoffDateTime);
                    
                    // Check if order was placed/updated after the cutoff datetime
                    if ($latestTime > $cutoffTimestamp) {
                        
                        // Get suite number
                        $this->tenantDb->select('bed_no');
                        $this->tenantDb->from('suites');
                        $this->tenantDb->where('id', $legacyOrder['bed_id']);
                        
                        // Execute query and check for errors
                        $query = $this->tenantDb->get();
                        if ($query === FALSE) {
                            $error = $this->tenantDb->error();
                            throw new Exception('Suite info query failed: ' . $error['message'] . ' (Code: ' . $error['code'] . ')');
                        }
                        $suiteInfo = $query->row_array();
                        
                        // 🔧 Get food items for this legacy suite's late order
                        $foodItems = $this->getFoodItemsForSuite($order['order_id'], $suiteInfo['bed_no'] ?? 'Unknown');
                        
                        $lateSuites[] = [
                            'suite_number' => $suiteInfo['bed_no'] ?? 'Unknown',
                            'action' => ($createdTime === $updatedTime) ? 'NEW ORDER' : 'ORDER UPDATED',
                            'time' => date('g:i A', $latestTime),
                            'by' => 'User',
                            'items' => $foodItems // 🔧 Food items ordered
                        ];
                    }
                }
            }
            
            // DEBUG: Add order debug info
            $orderDebug['late_suites_count'] = count($lateSuites);
            $debugInfo[$orderType]['orders'][] = $orderDebug;
            
            // If this floor has late suite activity, add to results
            if (!empty($lateSuites)) {
                $lateOrderActivity[] = [
                    'order_id' => $order['order_id'],
                    'date' => $order['date'],
                    'floor' => $floorName,
                    'floor_id' => $order['dept_id'],
                    'suites' => $lateSuites,
                    'type' => $orderType,
                    'total_late_suites' => count($lateSuites)
                ];
            }
        }
    }
    
    /**
     * Helper function to get food items for a specific suite's order
     * @param int $orderId - The floor order ID
     * @param string $suiteNumber - The suite number
     * @return array - Array of food items with category and details
     */
    private function getFoodItemsForSuite($orderId, $suiteNumber) {
        $foodItems = [];
        
        try {
            // First, get bed_id from suite number
            $this->tenantDb->select('id');
            $this->tenantDb->from('suites');
            $this->tenantDb->where('bed_no', $suiteNumber);
            $suiteQuery = $this->tenantDb->get();
            
            if (!$suiteQuery || $suiteQuery->num_rows() == 0) {
                return [];
            }
            
            $bedId = $suiteQuery->row_array()['id'];
            
            // Get food items from orders_to_patient_options
            $this->tenantDb->select('
                opo.option_id,
                opo.menu_id,
                opo.quantity,
                opo.category_id,
                mo.menu_option_name,
                md.name as menu_item_name,
                fmc.name as category_name
            ');
            $this->tenantDb->from('orders_to_patient_options opo');
            $this->tenantDb->join('menu_options mo', 'mo.id = opo.option_id', 'LEFT');
            $this->tenantDb->join('menuDetails md', 'md.id = opo.menu_id', 'LEFT');
            $this->tenantDb->join('foodmenuconfig fmc', 'fmc.id = opo.category_id', 'LEFT');
            $this->tenantDb->where('opo.order_id', $orderId);
            $this->tenantDb->where('opo.bed_id', $bedId);
            $this->tenantDb->where('opo.quantity >', 0);
            
            $itemsQuery = $this->tenantDb->get();
            
            if ($itemsQuery && $itemsQuery->num_rows() > 0) {
                foreach ($itemsQuery->result_array() as $item) {
                    $foodItems[] = [
                        'category' => $item['category_name'] ?? 'Unknown',
                        'item_name' => $item['menu_option_name'] ?? $item['menu_item_name'] ?? 'Unknown Item',
                        'quantity' => (int)$item['quantity']
                    ];
                }
            }
            
        } catch (Exception $e) {
            log_message('error', 'Error fetching food items for suite: ' . $e->getMessage());
        }
        
        return $foodItems;
    }
    
    /**
     * Get dismissed suites for current user from database
     * Returns: {order_id: {suite_number: dismissed_time}}
     */
    public function getDismissedSuites() {
        header('Content-Type: application/json');
        
        try {
            $userId = $this->session->userdata('user_id');
            
            if (!$userId) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                return;
            }
            
            // Get dismissals for last 7 days
            $this->tenantDb->select('order_id, suite_number, dismissed_time');
            $this->tenantDb->from('late_order_dismissals');
            $this->tenantDb->where('user_id', $userId);
            // CRITICAL FIX: Use Australia/Sydney timezone for date calculation
            $sevenDaysAgo = get_australia_date_offset(-7);
            $this->tenantDb->where('order_date >=', $sevenDaysAgo);
            $query = $this->tenantDb->get();
            
            $dismissals = [];
            if ($query && $query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    if (!isset($dismissals[$row['order_id']])) {
                        $dismissals[$row['order_id']] = [];
                    }
                    $dismissals[$row['order_id']][$row['suite_number']] = $row['dismissed_time'];
                }
            }
            
            echo json_encode([
                'success' => true,
                'dismissals' => $dismissals,
                'user_id' => $userId
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Save dismissed suites to database
     */
    public function saveDismissedSuites() {
        header('Content-Type: application/json');
        
        try {
            $userId = $this->session->userdata('user_id');
            
            if (!$userId) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                return;
            }
            
            $input = json_decode(file_get_contents('php://input'), true);
            $lateOrders = $input['lateOrders'] ?? [];
            
            if (empty($lateOrders)) {
                echo json_encode(['success' => false, 'error' => 'No orders to dismiss']);
                return;
            }
            
            $inserted = 0;
            foreach ($lateOrders as $order) {
                $orderId = $order['order_id'];
                $orderDate = $order['date'];
                
                foreach ($order['suites'] as $suite) {
                    $suiteNumber = $suite['suite_number'];
                    $dismissedTime = $suite['time'];
                    
                    // Insert or update dismissal
                    // ✅ CRITICAL FIX: Include order_date in duplicate check to match unique key idx_user_order_suite
                    $existing = $this->tenantDb->get_where('late_order_dismissals', [
                        'user_id' => $userId,
                        'order_id' => $orderId,
                        'suite_number' => $suiteNumber,
                        'order_date' => $orderDate
                    ])->row_array();
                    
                    if (!$existing) {
                        $this->tenantDb->insert('late_order_dismissals', [
                            'user_id' => $userId,
                            'order_id' => $orderId,
                            'suite_number' => $suiteNumber,
                            'dismissed_time' => $dismissedTime,
                            'order_date' => $orderDate
                        ]);
                        $inserted++;
                    } else {
                        // Update existing record if dismissed_time changed
                        if ($existing['dismissed_time'] != $dismissedTime) {
                            $this->tenantDb->where('user_id', $userId)
                                ->where('order_id', $orderId)
                                ->where('suite_number', $suiteNumber)
                                ->where('order_date', $orderDate)
                                ->update('late_order_dismissals', ['dismissed_time' => $dismissedTime]);
                        }
                    }
                }
            }
            
            echo json_encode([
                'success' => true,
                'message' => "Dismissed $inserted suite(s)",
                'inserted' => $inserted
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Check if a floor has orders for today (delivery date)
     * Used by staff dashboard to show friendly message if no orders exist
     * FIXED: Changed from tomorrow to today since staff check for today's delivery orders
     */
    public function checkFloorHasOrders($floorId) {
        header('Content-Type: application/json');
        
        try {
            // CRITICAL FIX: Use Australia/Sydney timezone for date operations
            // Get today's date (delivery date for staff)
            $todayDate = $this->getAustraliaDate();
            
            // Check if there are any orders for this floor for today
            // MATCH CHEF DASHBOARD: Show ALL orders regardless of status (like chef dashboard)
            // Only exclude cancelled/deleted orders via workflow_status so staff can view labels for any order status
            $this->tenantDb->select('order_id');
            $this->tenantDb->from('orders');
            $this->tenantDb->where('dept_id', $floorId);
            $this->tenantDb->where('date', $todayDate);
            $this->tenantDb->where('buttonType', 'sendorder');
            // Exclude only cancelled/deleted orders - show all other statuses (matching chef dashboard behavior)
            $this->tenantDb->where_not_in('workflow_status', ['cancelled', 'cancelled_duplicate', 'deleted']);
            // NO status filter - matches chef dashboard which shows orders regardless of status (Pending, Paid, Ready, Delivered)
            $this->tenantDb->limit(1);
            
            $query = $this->tenantDb->get();
            
            $hasOrders = ($query && $query->num_rows() > 0);
            
            echo json_encode([
                'success' => true,
                'hasOrders' => $hasOrders,
                'date' => $todayDate,
                'floorId' => $floorId
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'hasOrders' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
}
    
    ?>
