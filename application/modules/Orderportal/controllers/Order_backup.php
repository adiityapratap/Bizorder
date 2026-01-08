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
   	      $this->load->model('status_compatibility_model'); // Load status compatibility model
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->selected_location_id = $this->session->userdata('default_location_id');
        
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

    public function checkExistingOrder() {
        $bed_id = $this->input->post('bed_id');
        
        if (!$bed_id) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Bed ID required']));
            return;
        }

        $floorId = $this->session->userdata('department_id');
        $orderDate = date('Y-m-d', strtotime('+1 day'));
        
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
        $currentDate = date('Y-m-d');
        $orderDate = date('Y-m-d', strtotime('+1 day'));
        
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

    
    
    function commonData($deptId){
        
        $result = array();

        $menuLists    = $this->menu_model->fetchMenuDetails('',true);
  
        $conditions = array('is_deleted' => 0,'floor'=>$deptId);
        $allSuites = $this->common_model->fetchRecordsDynamically('suites','',$conditions);
        
        // Keep all suites - we handle empty bed_no in the view now
        $bedLists = $allSuites;
        
        // Add patient information to each suite
        if (!empty($bedLists)) {
            foreach ($bedLists as &$suite) {
                // Get active patient for this suite
                $patientConditions = [
                    'suite_number' => $suite['id'],
                    'status' => 1 // Active patients only
                ];
                $patients = $this->common_model->fetchRecordsDynamically('people', ['name', 'allergies', 'special_instructions', 'date_onboarded', 'date_of_discharge'], $patientConditions);
                
                // Filter out patients with past discharge dates
                $activePatient = null;
                $today = date('Y-m-d');
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
                
                // Add patient info to suite data
                $suite['patient_name'] = $activePatient ? $activePatient['name'] : null;
                $suite['patient_allergies'] = $activePatient ? $activePatient['allergies'] : null;
                $suite['patient_instructions'] = $activePatient ? $activePatient['special_instructions'] : null;
                $suite['patient_onboarded'] = $activePatient ? $activePatient['date_onboarded'] : null;
                $suite['patient_discharge'] = $activePatient ? $activePatient['date_of_discharge'] : null;
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

        // Validate required POST data
        if (!isset($_POST['selectedBed']) || empty($_POST['selectedBed'])) {
            $this->session->set_flashdata('error', 'Suite selection is required.');
            redirect('Orderportal/Home/index');
            return;
        }

        $bedId = $_POST['selectedBed'];
        $floorId = $this->session->userdata('department_id');
        $userId = $this->session->userdata('user_id');
        $orderDate = date('Y-m-d', strtotime('+1 day'));
        
        // Check if floor consolidation is enabled
        $isFloorConsolidationEnabled = $this->floor_order_model->isFloorConsolidationEnabled($floorId);
        
        if ($isFloorConsolidationEnabled) {
            return $this->placeFloorConsolidatedOrder($bedId, $floorId, $userId, $orderDate);
        } else {
            return $this->placeLegacySuiteOrder($bedId);
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
        
        // Get or create floor order
        $floorOrderId = $this->floor_order_model->getOrCreateFloorOrder($floorId, $orderDate, $userId);
        
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
        
        // Process the suite order
        unset($_POST['selectedBed']);
        $orderComment = isset($_POST['notes']) ? $_POST['notes'] : '';
        
        // Add or update suite in the floor order
        $suiteDetailId = $this->floor_order_model->addSuiteToFloorOrder(
            $floorOrderId, 
            $bedId, 
            $suiteNumber, 
            $orderComment, 
            $userId
        );
        
        if (!$suiteDetailId) {
            $this->session->set_flashdata('error', 'Failed to add suite to floor order.');
            redirect('Orderportal/Home/index');
            return;
        }
        
        // Remove existing menu items for this suite
        $this->floor_order_model->removeExistingMenuItems($floorOrderId, $bedId);
        
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
                                'menu_id' => $menu_id,
                                'option_id' => $option_id,
                                'quantity' => 1
                            ];
                        }
                    } else {
                        // Handle single values (radio buttons)
                        $menuItems[] = [
                            'bed_id' => $bedId,
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
            $this->floor_order_model->addMenuItemsToSuite($floorOrderId, $suiteDetailId, $menuItems);
        }
        
        // Update workflow status based on button type and user role
        $buttonType = $_POST['buttonType'] ?? 'save';
        
        // FIXED: Client and Reception users always send orders directly to chef
        if ($userRole == 4 || $userRole == 6) { // Client (Patient) or Reception role
            $buttonType = 'sendorder';
        }
        
        $newStatus = $this->determineWorkflowStatus($buttonType, $userRole);
        
        if ($newStatus) {
            $this->floor_order_model->updateFloorOrderStatus(
                $floorOrderId, 
                $newStatus, 
                $userId, 
                "Order {$buttonType} for Suite {$suiteNumber}"
            );
        }
        
        // Send notifications
        $this->sendFloorOrderNotifications($floorOrderId, $buttonType, $suiteNumber, $userRole);
        
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
     */
    private function sendFloorOrderNotifications($floorOrderId, $buttonType, $suiteNumber, $userRole) {
        $userRoleNames = [4 => 'Patient', 6 => 'Reception', 3 => 'Nurse', 1 => 'Admin', 2 => 'Chef'];
        $roleName = $userRoleNames[$userRole] ?? 'User';
        $userName = $this->session->userdata('username') ?: 'Unknown User';
        $floorId = $this->session->userdata('department_id') ?: 'Unknown Floor';
        
        if ($buttonType === 'sendorder') {
            $msg = "Floor order updated: {$roleName} ({$userName}) added Suite {$suiteNumber} to Floor {$floorId} order. Ready for review.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
        } elseif ($buttonType === 'save') {
            $msg = "Floor order draft updated: {$roleName} ({$userName}) saved changes for Suite {$suiteNumber} on Floor {$floorId}.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
        }
    }
    
    /**
     * Legacy suite order method for backward compatibility
     */
    private function placeLegacySuiteOrder($bedId) {
        
        // Validate that the bed exists and belongs to the current department
        $bedConditions = [
            'id' => $bedId,
            'floor' => $this->session->userdata('department_id'),
            'is_deleted' => 0
        ];
        $bedExists = $this->common_model->fetchRecordsDynamically('suites', ['id', 'bed_no'], $bedConditions);
        
        if (empty($bedExists)) {
            $this->session->set_flashdata('error', 'Invalid suite selection.');
            redirect('Orderportal/Home/index');
            return;
        }

        $configData = $this->common_model->fetchRecordsDynamically('departmentSettings',['daily_budget','daily_limit'],'');

        $orderData['date'] = date('Y-m-d', strtotime('+1 day'));
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
        
        unset($_POST['selectedBed']); // remove from the array
        $orderArray = [ $bedId => $_POST ];
        
        // Add bed_id to order data for suite-specific tracking
        $orderData['bed_id'] = $bedId;
        $orderData['buttonType'] = $_POST['buttonType'];
        
        // FIXED: Client and Reception users always send orders directly to chef
        if ($userRole == 4 || $userRole == 6) { // Client (Patient) or Reception role
            $orderData['buttonType'] = 'sendorder';
        }

         // FIXED: Check for existing order for this specific bed and date
         $conditions = [
             'date' => date('Y-m-d', strtotime('+1 day')), 
             'dept_id' => $this->session->userdata('department_id'),
             'bed_id' => $bedId  // Make orders bed-specific
         ];
         
         $existingOrderData = $this->common_model->fetchRecordsDynamically('orders',['order_id','buttonType'],$conditions);
         
         // Also check for old orders without bed_id that might need to be converted
         if(empty($existingOrderData)) {
             $legacyConditions = [
                 'date' => date('Y-m-d', strtotime('+1 day')), 
                 'dept_id' => $this->session->userdata('department_id'),
                 'bed_id' => null  // Check for old orders without bed_id
             ];
             $legacyOrderData = $this->common_model->fetchRecordsDynamically('orders',['order_id','buttonType'],$legacyConditions);
             
             if(!empty($legacyOrderData)) {
                 // Convert legacy order to bed-specific by updating its bed_id
                 $legacyOrderId = $legacyOrderData[0]['order_id'];
                 $this->common_model->commonRecordUpdate('orders','order_id', $legacyOrderId, ['bed_id' => $bedId]);
                 $existingOrderData = $legacyOrderData;
             }
         }
         
         if(isset($existingOrderData) && !empty($existingOrderData)){
             
            $orderUpdateData['updated_by'] = $this->session->userdata('user_id');
            $orderUpdateData['buttonType'] = $_POST['buttonType'];
            
            // FIXED: Client and Reception users always send orders directly to chef
            if ($userRole == 4 || $userRole == 6) { // Client (Patient) or Reception role
                $orderUpdateData['buttonType'] = 'sendorder';
            }
             $order_id = reset($existingOrderData)['order_id'];  
           $successMessage = 'Order Updated Successfully for Suite ' . $bedExists[0]['bed_no'];
           
           
           // Delete existing records for this specific bed and order
           $conditionsDelete = ['order_id' => $order_id,'bed_id' => $bedId];
           $this->common_model->commonRecordDeleteMultipleConditions('orders_to_comments', $conditionsDelete);
           $this->common_model->commonRecordDeleteMultipleConditions('orders_to_patient_options', $conditionsDelete);

           $this->common_model->commonRecordUpdate('orders','order_id', $order_id, $orderUpdateData);
           
           // NOTIFICATION: Order Updated - notify chef/admin about late order updates
           if($_POST['buttonType'] == 'update' || $_POST['buttonType'] == 'sendorder'){
               $userRole = $this->ion_auth->get_users_groups()->row();
               $roleName = $userRole ? $userRole->name : 'User';
               $userName = $this->session->userdata('username') ?: 'Unknown User';
               $deptId = $this->session->userdata('department_id') ?: 'Unknown Floor';
               $bedNo = $bedExists[0]['bed_no'] ?: 'Unknown Suite';
               
               if($_POST['buttonType'] == 'update') {
                   $msg = "Late order update: {$roleName} ({$userName}) updated order for Suite {$bedNo} on Floor {$deptId}. Please ensure order is prepared.";
               } else {
                   $msg = "Order submitted: {$roleName} ({$userName}) sent order for Suite {$bedNo} on Floor {$deptId}. Ready for preparation.";
               }
               
               createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
           }
           
           // Update is successful - CodeIgniter will throw an exception if there's a database error
           
         }else{
           $order_id = $this->common_model->commonRecordCreate('orders', $orderData);   
           
           if (!$order_id) {
               $this->session->set_flashdata('error', 'Failed to create order. Please try again.');
               redirect('Orderportal/Home/index');
               return;
           }
           
           // Associate existing comments with this new order
           $this->associateCommentsWithOrder($order_id, $orderData['dept_id'], $orderData['date']);
           
           // Log initial order status
           $this->logOrderStatusChange($order_id, null, 1, 'Order created for Suite ' . $bedExists[0]['bed_no']);
           
           // NOTIFICATION: New Order Created - notify chef/admin about new order
           $userRole = $this->ion_auth->get_users_groups()->row();
           $roleName = $userRole ? $userRole->name : 'User';
           $userName = $this->session->userdata('username') ?: 'Unknown User';
           $deptId = $this->session->userdata('department_id') ?: 'Unknown Floor';
           $bedNo = $bedExists[0]['bed_no'] ?: 'Unknown Suite';
           
           if($_POST['buttonType'] == 'sendorder') {
               $msg = "New order received: {$roleName} ({$userName}) placed order for Suite {$bedNo} on Floor {$deptId}. Ready for preparation.";
               createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
           } elseif($_POST['buttonType'] == 'save') {
               $msg = "Order draft saved: {$roleName} ({$userName}) saved order draft for Suite {$bedNo} on Floor {$deptId}.";
               createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
           }
           
           $successMessage = 'Order placed successfully for Suite ' . $bedExists[0]['bed_no'];
         }
        
        $ordertoPatients = array();
        $result = [];
        $dbTransactionSuccess = true;
        
        // Start database transaction to ensure data consistency
        $this->db->trans_start();
        
        foreach($orderArray as $bedID => $orderMenu) {
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
                                'menu_id'    => $menu_id,
                                'option_id'  => $orderSelectedMenuOptionsValues,
                                'quantity'   => 1,
                                'status'     => 0,
                                'created_at' => date('Y-m-d')
                            );  
                        }
                    }
                } else {
                    // In case of radio button, where user select just one value
                    if (!empty($orderSelectedMenuOptions)) {
                        $bulkOptionsData[] = array(
                            'order_id'   => $order_id,
                            'bed_id'     => $bedID,
                            'menu_id'    => $menu_id,
                            'option_id'  => $orderSelectedMenuOptions,
                            'quantity'   => 1,
                            'status'     => 0,
                            'created_at' => date('Y-m-d')
                        ); 
                    }
                }
            }

            // Only insert if we have data to insert
            if (!empty($bulkOptionsData)) {
                $optionsResult = $this->common_model->commonBulkRecordCreate('orders_to_patient_options', $bulkOptionsData);
                if (!$optionsResult) {
                    $dbTransactionSuccess = false;
                    break;
                }
            }
        }
        
        // Complete database transaction
        $this->db->trans_complete();
        
        // Check if transaction was successful
        if ($this->db->trans_status() === FALSE || !$dbTransactionSuccess) {
            $this->session->set_flashdata('error', 'Failed to save order. Please try again.');
            redirect('Orderportal/Home/index');
            return;
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
        
        redirect('Orderportal/Home/index');  
        
    }
    
   // when nurse sends order from thoer portal 
   function placeOrderNursePortal() {
       
    //   echo "<pre>"; print_r($this->POST);exit;
    
    // TEMPORARILY DISABLED - Check cutoff time (10:30 AM) for next day orders (reception/patient users only)
    // if (!$this->isWithinOrderCutoffTime()) {
    //     $this->session->set_flashdata('error', 'Order cutoff time has passed. Orders for tomorrow must be placed before 10:30 AM today.');
    //     redirect('Orderportal/Home/index');
    //     return;
    // }
       
    // Fetch department settings
    $configData = $this->common_model->fetchRecordsDynamically('departmentSettings', ['daily_budget', 'daily_limit'], '');
    
    $orderData = [
        'date' => date('Y-m-d', strtotime('+1 day')),
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

    // Check for existing order
    $conditions = ['date' => date('Y-m-d', strtotime('+1 day')), 'dept_id' => $this->session->userdata('department_id')];
    $existingOrderData = $this->common_model->fetchRecordsDynamically('orders', ['order_id', 'buttonType'], $conditions);

    // Create or update order
    if (!empty($existingOrderData)) {
        $orderUpdateData = [
            'updated_by' => $this->session->userdata('user_id'),
            'buttonType' => $_POST['buttonType'] ?? '' // Default to empty if not set
        ];
        $order_id = reset($existingOrderData)['order_id'];
        $successMessage = 'Order Updated Successfully';
        $this->common_model->commonRecordUpdate('orders', 'order_id', $order_id, $orderUpdateData);
        
        // NOTIFICATION: Nurse Portal Order Update
        $userRole = $this->ion_auth->get_users_groups()->row();
        $roleName = $userRole ? $userRole->name : 'User';
        $userName = $this->session->userdata('username') ?: 'Unknown User';
        $deptId = $this->session->userdata('department_id') ?: 'Unknown Floor';
        
        if($_POST['buttonType'] == 'sendorder') {
            $msg = "Order updated via Nurse Portal: {$roleName} ({$userName}) updated order for Floor {$deptId}. Ready for preparation.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
        }
    } else {
        $order_id = $this->common_model->commonRecordCreate('orders', $orderData);
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Failed to create order.');
            redirect('Orderportal/Home/index');
        }
        
        // Associate existing comments with this new order
        $this->associateCommentsWithOrder($order_id, $orderData['dept_id'], $orderData['date']);
        
        // Log initial order status
        $this->logOrderStatusChange($order_id, null, 1, 'Order created via nurse portal');
        
        // NOTIFICATION: New Nurse Portal Order
        $userRole = $this->ion_auth->get_users_groups()->row();
        $roleName = $userRole ? $userRole->name : 'User';
        $userName = $this->session->userdata('username') ?: 'Unknown User';
        $deptId = $this->session->userdata('department_id') ?: 'Unknown Floor';
        
        if($_POST['buttonType'] == 'sendorder') {
            $msg = "New order via Nurse Portal: {$roleName} ({$userName}) placed order for Floor {$deptId}. Ready for preparation.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
        } elseif($_POST['buttonType'] == 'save') {
            $msg = "Order draft saved via Nurse Portal: {$roleName} ({$userName}) saved order draft for Floor {$deptId}.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
        }
        
        $successMessage = 'Order placed successfully';
    }

    $bulkOptionsData = [];
    $processedBeds = [];

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

            // Mark bed as processed
            $processedBeds[$bed_id] = true;

            // Delete existing records for this bed if updating
            if (!empty($existingOrderData)) {
                $conditionsDelete = ['order_id' => $order_id, 'bed_id' => $bed_id];
                $this->common_model->commonRecordDeleteMultipleConditions('orders_to_comments', $conditionsDelete);
                $this->common_model->commonRecordDeleteMultipleConditions('orders_to_patient_options', $conditionsDelete);
            }

            // Save menu options
            if (!empty($value)) {
                if (is_array($value)) {
                    foreach ($value as $option_id) {
                        if (!empty($option_id)) {
                            $bulkOptionsData[] = [
                                'order_id' => $order_id,
                                'bed_id' => $bed_id,
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

            // Save comment even if no menu options selected
            $ordertoComments = [
                'order_id' => $order_id,
                'bed_id' => $bed_id,
                'order_comment' => $value
            ];
            $this->common_model->commonRecordCreate('orders_to_comments', $ordertoComments);
        }
    }

    // Save menu options if any
    if (!empty($bulkOptionsData)) {
        $this->common_model->commonBulkRecordCreate('orders_to_patient_options', $bulkOptionsData);
    }

    $this->session->set_flashdata('success', $successMessage);
    redirect('Orderportal/Home/index');
}
    
  
    // production form
    public function viewProductionForm() {
        
    $ordersItemInfo = $this->order_model->fetchOrderForChef();
    
    // DEBUG: Log the data to see what we're getting
    // error_log('Production Form Data: ' . print_r(array_slice($ordersItemInfo, 0, 2), true));
    
    // FIXED: Handle both completed and non-completed items
    $output = [];

    foreach ($ordersItemInfo as $row) {
        $categoryId = $row['category_id'];
        $optionId   = $row['option_id'];

        // Initialize category if not set
        if (!isset($output[$categoryId])) {
            $output[$categoryId] = [];
        }
        
        // Store the already aggregated data from the model including completion status
        $output[$categoryId][$optionId] = [
            'menu_id'          => (int)$row['menu_id'], // Menu ID for comment association
            'option_id'        => $optionId,
            'menu_item_name'   => $row['menu_item_name'], // Main menu item name (e.g., "Juices")
            'menu_option_name' => $row['menu_option_name'], // Specific option name (e.g., "Apple Juice")
            'menu_category'    => $row['food_category_name'] ?? $row['menu_item_name'] ?? 'Other', // Food category name (e.g., "Freshly Squeezed Juices")
            'qty'              => (int)$row['total_qty'], // Pending quantity only
            'completed_qty'    => (int)$row['completed_qty'], // Completed quantity
            'all_qty'          => (int)$row['all_qty'], // Total quantity (pending + completed)
            'bed_count'        => (int)$row['bed_count'], // Number of beds ordering this item
            'bed_details'      => $row['bed_quantities'], // Detailed bed breakdown
            'is_completed'     => (int)$row['is_completed'] // 1 if all items are completed, 0 if any pending
        ];
    }


    $data['orders'] = $output;
    $data['orderWithNotes']  = $this->order_model->fetchOrderWithOrderNotes();
    $data['itemComments'] = $this->order_model->fetchItemSpecificComments();
    
    $conditionsC = array('is_deleted' => 0 ,'listtype' => 'category');
    $data['categories'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditionsC);
    
    // echo "<pre>"; print_r($data['orderWithNotes']); exit;
    $this->load->view('general/header');
    $this->load->view('Orders/viewPatientOrder', $data);
    $this->load->view('general/footer');
}

    
    public function viewOrderPatientwise($type = '', $deptId = null, $displayDeliveredInfo = false) {
    // Fetch common data
    $result = $this->commonData($deptId);
    $data = [
        'menuLists' => $result['menuLists'],
        'bedLists' => $result['bedLists'],
        'categoryListData' => $result['categoryListData'],
        'deptId' => $deptId,
        'date' => date('d-m-Y'),
        'displayDeliveredInfo' => $displayDeliveredInfo
    ];

    // Fetch menu planner for today - try published first, then saved
    // For "All Floors" approach, always use department_id = 0
    $deptId = 0;
    
    $conditionsM = [
        'date' => date('Y-m-d'),
        'department_id' => $deptId,
        'status' => 2
    ];
    $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);

    // If no published menu found, try saved menus (status = 1)
    if (empty($savedData)) {
        $conditionsM = [
            'date' => date('Y-m-d'),
            'department_id' => $deptId,
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

    // Fetch today's orders (orders were placed yesterday for today's delivery)
    $conditionsO = [
        'date' => date('Y-m-d'), // Use today's date for delivery day
        'buttonType' => 'sendorder' // Match dashboardChef's filter
    ];
    if ($deptId) {
        $conditionsO['dept_id'] = $deptId; // Filter by department if specified
    }
    
    $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', ['order_id', 'is_delivered', 'buttonType'], $conditionsO);

    $patientOrderData = [];
    $orderMenuOptions = [];
    $orderCommentBedWise = [];
    $BednNotes = [];
    $orderId = '';

    if (!empty($todaysOrders)) {
        $orderId = $todaysOrders[0]['order_id'];
        $orderMenuOptions = $this->order_model->fetchOrderAndMenuOptions($orderId);

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
        'date' => date('Y-m-d'), // Use today's date to match what markACategoryDelivered saves
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
            'date' => date('Y-m-d'),
            'order_id' => $orderId
        ];
        $alreadyPackagedCategoryData = $this->common_model->fetchRecordsDynamically('order_to_category_packagestatus', ['category_id'], $conditionsPackageO);
        $alreadyPackagedCategory = !empty($alreadyPackagedCategoryData) ? array_column($alreadyPackagedCategoryData, 'category_id') : [];
    }
    
    if ($this->tenantDb->table_exists('orders_to_packagestatus')) {
        $conditionsPackagePW = ['order_id' => $orderId];
        $alreadyPackagedCategoryPatientWise = $this->common_model->fetchRecordsDynamically('orders_to_packagestatus', ['category_id', 'bed_id'], $conditionsPackagePW);
        $alreadyPackagedCategoryPatientIds = array_map(function($item) {
            return $item['bed_id'] . '_' . $item['category_id'];
        }, $alreadyPackagedCategoryPatientWise);
    }
    
    // Merge delivered and packaged for backward compatibility
    $alreadyDeliveredCategory = array_unique(array_merge($alreadyDeliveredCategory, $alreadyPackagedCategory));
    $alreadyDeliveredCategoryPatientIds = array_unique(array_merge($alreadyDeliveredCategoryPatientIds, $alreadyPackagedCategoryPatientIds));

    // Validation: Don't allow access to delivery page if essential data is missing
    if ($type == 'delivery') {
        $errors = [];
        
        // Check if we have menu data for tomorrow (delivery date)
        if (empty($savedMenus)) {
            $errors[] = "No menu data found for tomorrow (" . date('d-m-Y', strtotime('+1 day')) . "). Please ensure a menu plan is created and published for tomorrow's delivery date.";
        }
        
        // Check if we have orders for tomorrow (package date)
        if (empty($todaysOrders)) {
            $errors[] = "No orders found for tomorrow (" . date('d-m-Y', strtotime('+1 day')) . "). Orders must be placed before package tracking can be used.";
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
            // First, check if records exist
            $existing_records = $this->common_model->fetchRecordsDynamically(
                'orders_to_patient_options',
                ['id', 'status'],
                [
                    'option_id' => $option_id,
                    'order_id' => $order_id
                ]
            );
            
            if (empty($existing_records)) {
                echo json_encode(['status' => 'error', 'message' => 'No matching records found for option_id=' . $option_id . ' and order_id=' . $order_id]);
                return;
            }
            
            // Update all records with this option_id and order_id to completed status
            $fields = array(
                'option_id' => $option_id,
                'order_id' => $order_id,
                'status' => 0 // Only update incomplete items
            );
            $update_data = array('status' => 1);
            
            $result = $this->common_model->commonRecordUpdateMultipleConditions('orders_to_patient_options', $fields, $update_data);   
            
            if ($result !== false) {
                // NOTIFICATION: Menu item completed by chef
                $this->createMenuItemCompletionNotification($order_id, $option_id, $notes);
                
                // Check if all items for this order are now complete
                $this->checkAndCompleteOrder($order_id);
                
                // If chef added notes, save them as a comment
                if (!empty($notes)) {
                    // Get the menu_id and bed_id for this option_id from the order
                    $orderItem = $this->common_model->fetchRecordsDynamically(
                        'orders_to_patient_options',
                        ['menu_id', 'bed_id'],
                        [
                            'order_id' => $order_id,
                            'option_id' => $option_id
                        ]
                    );
                    
                    if (!empty($orderItem)) {
                        $orderItem = $orderItem[0]; // Get first record
                        
                        // Save chef's notes as a comment
                        $commentData = [
                            'order_id' => $order_id,
                            'bed_id' => $orderItem['bed_id'],
                            'menu_id' => $orderItem['menu_id'],
                            'option_id' => $option_id,
                            'comment' => $notes,
                            'added_by' => $this->session->userdata('user_id') ?? 0,
                            'added_by_role' => 'chef',
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        $this->tenantDb->insert('menu_item_comments', $commentData);
                    }
                }
                
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Menu item completed successfully!' . (!empty($notes) ? ' Chef notes saved.' : ''),
                    'records_found' => count($existing_records),
                    'records_updated' => $result
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
            }
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
                'status' => 3, // Ready for Delivery
                'food_completed_date' => date('Y-m-d H:i:s')
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
                'beds', 
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
                'beds', 
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
        $log_data = [
            'order_id' => $order_id,
            'old_status' => $old_status,
            'new_status' => $new_status,
            'reason' => $reason,
            'changed_by' => $this->session->userdata('user_id'),
            'changed_date' => date('Y-m-d H:i:s')
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
        
        $this->common_model->commonRecordCreate('order_status_log', $log_data);
        
        // NOTIFICATION: Order Status Change - notify admin/chef about status updates
        if($new_status && $new_status != $old_status) {
            $userName = $this->session->userdata('username') ?: 'System';
            $statusText = $this->getOrderStatusText($new_status);
            $oldStatusText = $old_status ? $this->getOrderStatusText($old_status) : 'New';
            
            // Only notify for important status changes
            if(in_array($new_status, [3, 4, 5])) { // Ready for Delivery, Delivered, Complete
                $msg = "Order status updated: Order #{$order_id} changed from {$oldStatusText} to {$statusText} by {$userName}. {$reason}";
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
             $bedInfo = $this->common_model->fetchRecordsDynamically('beds', ['bed_no', 'dept_id'], ['id' => $bed_id]);
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
         $data['date'] = date('Y-m-d');
        
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
         $data['packaged_at'] = date('Y-m-d H:i:s'); // Timestamp when packaged
        
         // First check if table exists, if not create it
         if (!$this->tenantDb->table_exists('orders_to_packagestatus')) {
             $this->createPackageStatusTable();
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
         $data['date'] = date('Y-m-d');
         $data['packaged_at'] = date('Y-m-d H:i:s');
        
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
     * Check if all categories for an order are packaged and mark order as complete
     */
    function checkAndMarkOrderPackaged($order_id) {
        // Load required models
        $this->load->model('floor_order_model');
        $this->load->model('status_compatibility_model');
        
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
        // Get all categories that should be in this order
        $orderCategories = $this->common_model->fetchRecordsDynamically(
            'orders_to_patient_options opo', 
            ['DISTINCT m2c.category_id'],
            ['opo.order_id' => $order_id],
            '',
            '',
            '',
            'LEFT JOIN menu_to_category m2c ON m2c.menu_id = opo.menu_id'
        );
        
        if (empty($orderCategories)) {
            return false;
        }
        
        // Check how many categories are marked as packaged
        $packagedCategories = $this->common_model->fetchRecordsDynamically(
            'order_to_category_packagestatus',
            ['category_id'],
            ['order_id' => $order_id, 'status' => 1]
        );
        
        // If all categories are packaged, mark order as complete
        if (count($packagedCategories) >= count($orderCategories)) {
            $this->updateOrderStatus($order_id, 5, 'All categories packaged - order complete');
            
            // NOTIFICATION: Order Complete
            $userName = $this->session->userdata('username') ?: 'System';
            $msg = "🎉 Order Complete: Order #{$order_id} has been fully packaged and completed by {$userName}.";
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'success', $msg);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Send notifications to reception portal for users who haven't placed orders yet
     * Called at 10:00 AM daily via cron job
     */
    public function sendPendingOrderNotifications() {
        $currentTime = date('H:i');
        $notificationTime = '10:00';
        
        // Only run at 10:00 AM (allow 5 minute window for cron timing)
        if ($currentTime < '09:55' || $currentTime > '10:05') {
            log_message('info', 'Pending order notifications: Not the right time. Current: ' . $currentTime);
            return;
        }
        
        // Get all occupied suites
        $conditions = ['is_deleted' => 0, 'is_vaccant' => 0]; // Only occupied suites
        $occupiedSuites = $this->common_model->fetchRecordsDynamically('suites', '', $conditions);
        
        if (empty($occupiedSuites)) {
            log_message('info', 'Pending order notifications: No occupied suites found');
            return;
        }
        
        // Get today's orders for tomorrow's delivery
        $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
        $orderConditions = [
            'date' => $tomorrowDate,
            'buttonType' => 'sendorder'
        ];
        $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', ['bed_id'], $orderConditions);
        
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
                $today = date('Y-m-d');
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
            log_message('info', 'Pending order notifications: All occupied suites have placed orders');
            return;
        }
        
        // Create notification data
        $notificationData = [
            'type' => 'pending_orders',
            'title' => 'Pending Orders Alert',
            'message' => count($suitesWithoutOrders) . ' suites have not placed orders for tomorrow yet',
            'suites_without_orders' => $suitesWithoutOrders,
            'patient_names' => $patientNames,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')) // Notification expires in 30 minutes
        ];
        
        // Store notification in session for reception users
        // We'll create a notification table if it doesn't exist
        if (!$this->tenantDb->table_exists('pending_order_notifications')) {
            $this->createPendingOrderNotificationsTable();
        }
        
        // Clear old notifications first
        $this->common_model->commonRecordDelete('pending_order_notifications', date('Y-m-d H:i:s'), 'expires_at', '<');
        
        // Insert new notification
        $result = $this->common_model->commonRecordCreate('pending_order_notifications', $notificationData);
        
        if ($result) {
            log_message('info', 'Pending order notifications: Created notification for ' . count($suitesWithoutOrders) . ' suites without orders');
        } else {
            log_message('error', 'Pending order notifications: Failed to create notification');
        }
    }
    
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
            'expires_at >' => date('Y-m-d H:i:s')
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
     */
    private function isWithinOrderCutoffTime() {
        // Get current user role
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        
        // Nurses (role 3) can place orders at any time - no cutoff restriction
        if ($userRole == 3) {
            return true;
        }
        
        // For reception (role 6) and patients (role 4), apply 10:30 AM cutoff
        if ($userRole == 6 || $userRole == 4) {
            // Get current date and time
            $now = new DateTime();
            $currentDate = $now->format('Y-m-d');
            $currentTime = $now->format('H:i');
            
            // Get the order date (tomorrow)
            $orderDate = date('Y-m-d', strtotime('+1 day'));
            
            // If we're ordering for tomorrow and it's past 10:30 AM today, block it
            // But if it's early morning (before 10:30 AM), allow it
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
        $this->load->model('status_compatibility_model');
        
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
                'date' => date('Y-m-d')
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
                    'delivered_date' => date('Y-m-d H:i:s'),
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
                    'delivered_date' => date('Y-m-d H:i:s'),
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
        $order_date = $this->input->post('order_date');
        $invoice_id = $this->input->post('invoice_id'); // New: support invoice ID
        
        try {
            if ($invoice_id) {
                // FIXED: Mark invoice as paid (new system)
                $invoice_data = [
                    'status' => 2, // Paid
                    'payment_date' => date('Y-m-d H:i:s')
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
                    'payment_date' => date('Y-m-d H:i:s')
                ];
                $this->common_model->commonRecordUpdate('daily_invoices', 'order_date', $order_date, $invoice_data);
                
                echo json_encode(['status' => 'success', 'message' => 'Orders marked as paid successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invoice ID or order date is required']);
            }
            
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error updating payment status: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Auto-generate invoice for completed/delivered orders
     */
    function autoGenerateInvoice($order_id) {
        // Get order details
        $order_details = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['order_id', 'date', 'dept_id', 'status'], 
            ['order_id' => $order_id]
        );
        
        if (empty($order_details)) return false;
        
        $order = $order_details[0];
        $order_date = $order['date'];
        
        // Check if invoice already exists for this date and department
        $existing_invoice = $this->common_model->fetchRecordsDynamically(
            'daily_invoices', 
            ['id'], 
            [
                'order_date' => $order_date,
                'dept_id' => $order['dept_id']
            ]
        );
        
        if (empty($existing_invoice)) {
            // Create daily invoice record
            $invoice_data = [
                'order_date' => $order_date,
                'dept_id' => $order['dept_id'],
                'order_id' => $order_id,
                'generated_date' => date('Y-m-d H:i:s'),
                'status' => 1, // Generated
                'invoice_number' => 'INV' . date('dmY', strtotime($order_date)) . '_' . $order['dept_id']
            ];
            
            // Create daily_invoices table if it doesn't exist
            $this->db->query("CREATE TABLE IF NOT EXISTS daily_invoices (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_date DATE NOT NULL,
                dept_id INT NOT NULL,
                order_id INT NOT NULL,
                invoice_number VARCHAR(50) UNIQUE,
                generated_date DATETIME,
                status INT DEFAULT 1,
                total_amount DECIMAL(10,2) DEFAULT 0,
                INDEX idx_order_date (order_date),
                INDEX idx_dept_id (dept_id),
                INDEX idx_order_id (order_id)
            )");
            
            $this->common_model->commonRecordCreate('daily_invoices', $invoice_data);
        }
        
        return true;
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
            4 => 'Delivered',
            5 => 'Complete'
        ];
        
        return isset($status_map[$status]) ? $status_map[$status] : 'Unknown';
    }
    

    /**
     * AUTOMATIC STATUS CHANGE: Convert unsent orders to sent at 10:00 PM
     * This runs via cron job at 10:00 PM daily
     * UPDATED FOR FLOOR CONSOLIDATION SYSTEM
     */
    function autoSendUnsentOrders() {
        // Security: Only allow this to run from CLI or specific IP
        if (!$this->input->is_cli_request() && $this->input->server('REMOTE_ADDR') !== '127.0.0.1') {
            show_404();
            return;
        }
        
        // Load required models
        $this->load->model('floor_order_model');
        $this->load->model('status_compatibility_model');
        
        // Get current date and time
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
        
        // Log the execution
        log_message('info', "CRON JOB 1: Handle Nurse Missed Submissions started at {$currentDate} {$currentTime}");
        log_message('info', "🔒 SAFEGUARD: Only processing orders for TOMORROW ({$tomorrowDate})");
        
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
            log_message('info', "No unsent orders found for tomorrow ({$tomorrowDate})");
            if ($this->input->is_cli_request()) {
                echo "No unsent orders found for tomorrow ({$tomorrowDate})\n";
                echo "✅ SAFEGUARD: Only processing tomorrow's orders\n";
            }
            return;
        }
        
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
                
                log_message('info', "CRON JOB 1: Auto-sent order #{$order['order_id']} (" . ($isFloorConsolidated ? 'floor' : 'legacy') . ") for tomorrow ({$order['date']})");
            } else {
                $failCount++;
                log_message('error', "Failed to auto-send order #{$order['order_id']} from {$order['date']}");
            }
        }
        
        $message = "Auto-send completed: {$successCount} orders sent ({$floorOrderCount} floor, {$legacyOrderCount} legacy), {$failCount} failed";
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

    /**
     * AUTOMATIC STATUS UPDATE: Update forgotten order statuses at 10:00 PM
     * This runs via cron job at 10:00 PM daily to ensure invoices can be generated
     * UPDATED FOR FLOOR CONSOLIDATION SYSTEM
     * 
     * Status Flow:
     * - Floor orders: workflow_status → "delivered"
     * - Legacy orders: status → 4 (Delivered/Completed)
     */
    function autoUpdateForgottenOrderStatuses() {
        // Security: Only allow this to run from CLI or specific IP
        if (!$this->input->is_cli_request() && $this->input->server('REMOTE_ADDR') !== '127.0.0.1') {
            show_404();
            return;
        }
        
        // Load required models
        $this->load->model('floor_order_model');
        $this->load->model('status_compatibility_model');
        
        // Get current date and time
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        
        // Log the execution
        log_message('info', "CRON JOB 2: Handle Chef/Delivery Missed Updates started at {$currentDate} {$currentTime}");
        log_message('info', "🔒 SAFEGUARD: Only processing orders for TODAY ({$currentDate})");
        
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
            log_message('info', "No orders found for today ({$currentDate}) that need status updates");
            if ($this->input->is_cli_request()) {
                echo "No orders found for today ({$currentDate}) that need status updates\n";
                echo "✅ SAFEGUARD: Only processing today's orders\n";
            }
            return;
        }
        
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
                    $needsUpdate = true;
                    $floorOrderCount++;
                }
            } else {
                // Legacy order - check numeric status
                if ($order['status'] != 4 && $order['status'] != 0) { // Not delivered and not cancelled
                    $updateData['status'] = 4; // Delivered/Completed
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
                    } else {
                        $oldStatus = $order['status'];
                        $statusUpdates[] = "Legacy Order #{$order['order_id']} → Completed (was status {$oldStatus})";
                        $this->logOrderStatusChange($order['order_id'], $oldStatus, 4, "CRON JOB 2: Auto-completed legacy order at 11:00 PM");
                    }
                    
                    log_message('info', "CRON JOB 2: Auto-completed order #{$order['order_id']} (" . ($isFloorConsolidated ? 'floor' : 'legacy') . ") for today ({$currentDate})");
                } else {
                    log_message('error', "Failed to auto-complete order #{$order['order_id']} from today ({$currentDate})");
                }
            }
        }
        
        $message = "CRON JOB 2: Chef/Delivery missed updates completed: {$totalUpdated} orders updated ({$floorOrderCount} floor, {$legacyOrderCount} legacy) for today ({$currentDate})";
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
            echo "✅ SAFEGUARD: Only processed today's orders, never touched tomorrow's orders\n";
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

    /**
     * Get current order ID for today's orders
     */
    function getCurrentOrderId() {
        try {
            $category_id = $this->input->post('category_id');
            
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
                'date' => date('Y-m-d'),
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
                'date' => date('Y-m-d'),
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
                'date' => date('Y-m-d')
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
                'message' => 'No orders found for today. Session Dept ID: ' . ($dept_id ?: 'empty') . ', User ID: ' . $user_id . ', Date: ' . date('Y-m-d')
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
        echo "<h3>Production Form Debug Data</h3>";
        echo "<p>Date: " . date('Y-m-d') . "</p>";
        echo "<p>Session Department ID: '" . $this->session->userdata('department_id') . "'</p>";
        echo "<p>Session User ID: '" . $this->session->userdata('user_id') . "'</p>";
        echo "<p>Session Username: '" . $this->session->userdata('username') . "'</p>";
        
        // Show all session data
        echo "<h4>All Session Data:</h4>";
        echo "<pre>" . print_r($this->session->all_userdata(), true) . "</pre>";
        
        // Check all orders for today (no department filter)
        $all_orders = $this->common_model->fetchRecordsDynamically('orders', '*', ['date' => date('Y-m-d')]);
        echo "<h4>All Orders for Today (" . date('Y-m-d') . "):</h4>";
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
            
            // Use direct query for better error handling with tenant database
            $query = $this->tenantDb->query("
                SELECT old_status, new_status, reason, changed_date 
                FROM order_status_log 
                WHERE order_id = ? 
                ORDER BY changed_date ASC
            ", [$order_id]);
            
            if ($query) {
                $history = $query->result_array();
            }
            
            // If no history found, create one from current order status
            if (empty($history)) {
                $current_order_query = $this->tenantDb->query("
                    SELECT status, date, added_by 
                    FROM orders 
                    WHERE order_id = ?
                ", [$order_id]);
                
                if ($current_order_query && $current_order_query->num_rows() > 0) {
                    $current_order = $current_order_query->row_array();
                    
                    // Insert initial history entry
                    $this->tenantDb->query("
                        INSERT INTO order_status_log (order_id, old_status, new_status, reason, changed_by, changed_date) 
                        VALUES (?, NULL, ?, ?, ?, ?)
                    ", [
                        $order_id, 
                        $current_order['status'], 
                        'Order created (historical data)', 
                        $current_order['added_by'] ?? 1,
                        $current_order['date']
                    ]);
                    
                    // Return the created history
                    $history = [[
                        'old_status' => null,
                        'new_status' => $current_order['status'],
                        'reason' => 'Order created (historical data)',
                        'changed_date' => $current_order['date']
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
                    'changed_date' => date('Y-m-d H:i:s', strtotime('-2 hours'))
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 1,
                    'new_status' => 3,
                    'reason' => 'All menu items completed by chef',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => date('Y-m-d H:i:s', strtotime('-1 hour'))
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 3,
                    'new_status' => 4,
                    'reason' => 'All categories delivered to patient',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
                ],
                [
                    'order_id' => $order_id,
                    'old_status' => 4,
                    'new_status' => 2,
                    'reason' => 'Order marked as paid',
                    'changed_by' => $this->session->userdata('user_id'),
                    'changed_date' => date('Y-m-d H:i:s', strtotime('-10 minutes'))
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
        
       
        $result = $this->commonData($deptId);
        
        $conditionsM = array('date' => $orderDate,'status' => 2);
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM);

        $data['menuLists']   = $result['menuLists'];
        $data['bedLists']   = $result['bedLists'];
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
        $buttonType = $todaysOrder[0]['buttonType'];
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
                error_log("Associated {$affectedRows} comments (from {$commentDate}) with order #{$orderId} for {$orderDate}");
            } else {
                // Fallback: Also try to associate comments from the same day
                $this->tenantDb->query($sql, [$orderId, $orderDate, $deptId]);
                $affectedRows = $this->tenantDb->affected_rows();
                if ($affectedRows > 0) {
                    error_log("Associated {$affectedRows} comments (from {$orderDate}) with order #{$orderId}");
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
            $today = date('Y-m-d');
            $tomorrow = date('Y-m-d', strtotime('+1 day'));
            
            // Get today's order_id for proper association
            // Look for orders for today's delivery (which might be placed yesterday) OR tomorrow's delivery (placed today)
            $orderQuery = $this->tenantDb->query("
                SELECT order_id FROM orders 
                WHERE (DATE(date) = ? OR DATE(date) = ?) 
                AND dept_id = ? 
                ORDER BY order_id DESC LIMIT 1", 
                [$today, $tomorrow, $this->session->userdata('department_id')]
            );
            $orderResult = $orderQuery->row();
            $orderId = $orderResult ? $orderResult->order_id : 0;
            
            // Get current user role for proper attribution
            $userRole = $this->ion_auth->get_users_groups()->row()->id;
            $roleNames = [1 => 'admin', 2 => 'chef', 3 => 'nurse', 4 => 'patient', 6 => 'reception'];
            $addedByRole = $roleNames[$userRole] ?? 'user';
            
            if (empty($comment)) {
                // Delete comment if empty
                $sql = "DELETE FROM menu_item_comments 
                       WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND DATE(created_at) = ?";
                $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $today]);
            } else {
                // Check if comment exists for today
                $sql = "SELECT id FROM menu_item_comments 
                       WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND DATE(created_at) = ?";
                $query = $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $today]);
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
            
            // Use tenant database
            $today = date('Y-m-d');
            
            $sql = "SELECT comment FROM menu_item_comments 
                   WHERE bed_id = ? AND menu_id = ? AND option_id = ? AND DATE(created_at) = ?
                   ORDER BY created_at DESC LIMIT 1";
            
            $query = $this->tenantDb->query($sql, [$bedId, $menuId, $optionId, $today]);
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
    
}
    
    ?>
