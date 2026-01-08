<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Patient extends MY_Controller
{
    public function __construct() 
    {   
      	parent::__construct();
   	     $this->load->model('configfoodmenu_model');
   	     $this->load->model('common_model');
   	      $this->load->model('menu_model');
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->selected_location_id = $this->session->userdata('default_location_id');
       
    }
    
  
    function Config(){
        
    }
    
    
    // for adding patient
    function addPatient(){
        
        $data['floor'] = array(); 
        $data['departments'] = array();
        
         $conditions['listtype'] = 'department';
         $conditions['is_deleted'] = '0';
         $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $conditions['listtype'] = 'floor';
        $conditions['is_deleted'] = '0';
        $floorListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $data['departments'] = $departmentListData;
        $data['floorLists'] = $floorListData;
      	$this->load->view('general/landingPageHeader');
        $this->load->view('Patient/addPatient',$data);
        $this->load->view('general/landingPageFooter');     
    }
    

	
	// new code start here ignore aobve code
	
	function Onboarding(){
	    

	$data['customerLists'] = $this->common_model->fetchRecordsDynamically('people'); 
	
    $conditions['listtype'] = 'floor';
    $conditions['is_deleted'] = '0';
    $data['floors']  = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions);
    
    unset($conditions['is_deleted']);
    $conditions['listtype'] = 'allergen';
    $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions);
    
    $conditionsB['status'] = '1';
    $conditionsB['is_deleted'] = '0';      // Exclude deleted suites
    $data['suites'] = $this->common_model->fetchRecordsDynamically('suites',['bed_no','id'],$conditionsB);
    // echo "<pre>"; print_r($data['customerLists']);exit;
    
    $this->load->view('general/landingPageHeader');
    $this->load->view('Patient/patientList',$data);
    $this->load->view('general/landingPageFooter');  
    
	}
	function onboardingForm($id='',$idType='person'){
	   
    $conditions['listtype'] = 'floor';
    $conditions['is_deleted'] = '0';
    $data['floor_numbers']  = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
    
    unset($conditions['is_deleted']);
    $conditions['listtype'] = 'allergen';
    $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions);
    
    // Fetch cuisines for dietary preferences
    $conditions_cuisine['listtype'] = 'cuisine';
    $conditions_cuisine['is_deleted'] = 0;
    $data['cuisines'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions_cuisine);
    
    // 🔒 CRITICAL: Determine if floor and suite fields should be enabled
    // Enable ONLY when: New patient from "Add Person" button (no ID, no idType='suite')
    // Disable when: Coming from suite list (idType='suite') OR editing existing patient (idType='person')
    $enableFloorAndSuite = (empty($id) && $idType != 'suite');
    $data['enableFloorAndSuite'] = $enableFloorAndSuite;
    
    $conditionsB['status'] = '1';
    $conditionsB['is_deleted'] = '0';  // Exclude deleted suites
    
    if($id !='' && $idType=='person'){
        // Editing existing patient - get patient details
        $conditionsP =  array('id' => $id);
        $patientDetails = $this->common_model->fetchRecordsDynamically('people','',$conditionsP); 
        $data['patientDetails'] = (isset($patientDetails[0]) && !empty($patientDetails) ? reset($patientDetails) : array());   
        $conditionsB['floor'] = $patientDetails[0]['floor_number'];
        // When editing, show only vacant suites OR current suite
        $conditionsB['is_vaccant'] = '1';  // Only show vacant/available suites
    } else {
        $data['patientDetails'] = array();
        
        if($id !='' && $idType =='suite'){
            // Coming from suite list - get suite details
            $data['selected_suite'] = $id;  
            $conditionsSuites['id'] = $id;
            $data['selectedFloor'] = $this->common_model->fetchRecordsDynamically('suites',['floor'],$conditionsSuites);
            $conditionsB['floor'] = $data['selectedFloor'][0]['floor'] ?? '';
        }
        
        // For new patient (Add Person), show all vacant suites (no floor filter initially)
        // For suite selection, show vacant suites for that floor
        $conditionsB['is_vaccant'] = '1';  // Only show vacant/available suites
    }
    
    // Get vacant suites
    $vacant_suites = $this->common_model->fetchRecordsDynamically('suites',['bed_no','id','floor'],$conditionsB);
    
    // If editing an existing patient, also include their current suite (even if occupied)
    if($id !='' && $idType=='person' && !empty($data['patientDetails']['suite_number'])){
        $current_suite_id = $data['patientDetails']['suite_number'];
        
        // Check if current suite is already in the list
        $suite_ids = array_column($vacant_suites, 'id');
        if(!in_array($current_suite_id, $suite_ids)){
            // Add current suite to the list
            $conditionsCurrentSuite = array(
                'id' => $current_suite_id,
                'status' => '1',
                'is_deleted' => '0'
            );
            $current_suite = $this->common_model->fetchRecordsDynamically('suites',['bed_no','id','floor'],$conditionsCurrentSuite);
            if(!empty($current_suite)){
                $vacant_suites = array_merge($current_suite, $vacant_suites);
            }
        }
    }
    
    $data['suites'] = $vacant_suites;
   
       	$this->load->view('general/landingPageHeader');
        $this->load->view('Patient/OnboardingForm',$data);
        $this->load->view('general/landingPageFooter');  
       
	}
	
	public function save_person() {
    // Load helper for Australia timezone functions
    $this->load->helper('custom');
    
    // Collect allergies as array
    $allergies = $this->input->post('allergies');
    
    // Save as JSON (preferred)
    $allergies_value = !empty($allergies) ? json_encode($allergies) : json_encode([]);
    
    // Collect dietary preferences (cuisines) as array
    $dietary_preferences = $this->input->post('dietary_preferences');
    
    // Save as JSON (preferred)
    $dietary_preferences_value = !empty($dietary_preferences) ? json_encode($dietary_preferences) : json_encode([]);

    $suite_number = $this->input->post('suite_number');
    $person_id = $this->input->post('personId');
    $discharge_date = $this->input->post('discharge_date');
    $onboard_date = $this->input->post('onboard_date');
    $patient_name = $this->input->post('name');
    $today = date('Y-m-d');
    
    // Log operation start
    $isNewPatient = empty($person_id);
    log_message('info', "PATIENT " . ($isNewPatient ? 'ONBOARD' : 'UPDATE') . ": Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", Person ID=" . ($person_id ?: 'NEW') . ", Suite Number=" . ($suite_number ?: 'NONE') . ", Onboard Date=" . ($onboard_date ?: 'NONE') . ", Discharge Date=" . ($discharge_date ?: 'NONE') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());

    // Server-side validation: Check for duplicate active patients in same suite (for new patients only)
    if (empty($person_id) && !empty($suite_number)) {
        $existing_conditions = array(
            'suite_number' => $suite_number,
            'status' => 1 // Active patients only
        );
        $existing_patients = $this->common_model->fetchRecordsDynamically('people', '', $existing_conditions);
        
        // Filter out patients with past discharge dates (keep same-day patients as active)
        $active_patients = array();
        if (!empty($existing_patients)) {
            foreach ($existing_patients as $patient) {
                $patient_discharge = $patient['date_of_discharge'];
                // Keep patients active if discharge date is today or in the future
                if (empty($patient_discharge) || $patient_discharge >= $today) {
                    $active_patients[] = $patient;
                }
            }
        }
        
        if (!empty($active_patients)) {
            log_message('warning', "PATIENT ONBOARD BLOCKED: Suite {$suite_number} is already occupied by another active patient. Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error_msg', 'This suite is already occupied by another client. Please select a different suite.');
            redirect('Orderportal/Patient/onboardingForm/' . $suite_number . '/suite');
            return;
        }
    }

    // Handle patient photo upload
    $photo_path = $this->input->post('existing_photo_path'); // Keep existing photo by default
    
    if (!empty($_FILES['patient_photo']['name'])) {
        // Configure upload settings
        $upload_path = './uploaded_files/patient_photos/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }
        
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB in KB
        $config['encrypt_name'] = TRUE; // Encrypt filename for security
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('patient_photo')) {
            $upload_data = $this->upload->data();
            $photo_path = 'uploaded_files/patient_photos/' . $upload_data['file_name'];
            
            // Delete old photo if exists and is different from new one
            $old_photo = $this->input->post('existing_photo_path');
            if (!empty($old_photo) && file_exists('./' . $old_photo)) {
                @unlink('./' . $old_photo);
            }
        } else {
            // Upload failed - set error message
            $upload_error = $this->upload->display_errors('', '');
            log_message('error', "PATIENT " . ($isNewPatient ? 'ONBOARD' : 'UPDATE') . " PHOTO UPLOAD FAILED: " . $upload_error . ". Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", Person ID=" . ($person_id ?: 'NEW') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $this->session->set_flashdata('error_msg', 'Photo upload failed: ' . $upload_error);
            redirect('Orderportal/Patient/onboardingForm/' . ($person_id ?: $suite_number . '/suite'));
            return;
        }
    }
    
    $save_data = [
        'name' => $this->input->post('name'),
        'floor_number' => $this->input->post('floor_number'),
        'suite_number' => $suite_number,
        'allergies' => $allergies_value,
        'dietary_preferences' => $dietary_preferences_value,
        'special_instructions' => $this->input->post('instructions'),
        'photo_path' => $photo_path,
        'date_onboarded' => $onboard_date,
        'date_of_discharge' => $discharge_date ?: NULL,
        'status' => 1 // Default to active status
    ];

    // Improved discharge date logic
    $should_be_discharged = false;
    
    if (!empty($discharge_date)) {
        // Compare dates properly using strtotime for accurate comparison
        $discharge_timestamp = strtotime($discharge_date);
        $today_timestamp = strtotime($today);
        $onboard_timestamp = strtotime($onboard_date);
        
        // If discharge date is in the past (before today), patient should be discharged
        // If discharge date is same as onboard date AND same as today, keep patient active for the day
        // Only discharge if discharge date is actually in the past
        if ($discharge_timestamp < $today_timestamp) {
            $should_be_discharged = true;
        }
        // Special case: if discharge date is today but onboard date is in the past, discharge
        elseif ($discharge_timestamp == $today_timestamp && $onboard_timestamp < $today_timestamp) {
            $should_be_discharged = true;
        }
    }
    
    if ($should_be_discharged) {
        // Mark suite as vacant and patient as discharged
        $bedData['is_vaccant'] = 1;
        $save_data['status'] = 2; // Set patient status to discharged
    } else {
        // Mark suite as occupied (only if patient is active)
        $bedData['is_vaccant'] = 0;
    }
    
    // IMPORTANT: If updating an existing patient, check if suite number changed
    $old_suite_number = null;
    $old_patient_status = null;
    if (!empty($person_id)) {
        // Get the patient's current suite number and status before updating
        $current_patient = $this->common_model->fetchRecordsDynamically('people', ['suite_number', 'status'], ['id' => $person_id]);
        if (!empty($current_patient)) {
            $old_suite_number = $current_patient[0]['suite_number'];
            $old_patient_status = $current_patient[0]['status'];
        }
    }
    
    // Update NEW suite status
    $this->common_model->commonRecordUpdate('suites','id',$suite_number,$bedData);  

    // If patient moved from one suite to another AND was previously active (occupied), mark the OLD suite as vacant
    if (!empty($old_suite_number) && $old_suite_number != $suite_number && $old_patient_status == 1) {
        $old_suite_data['is_vaccant'] = 1; // Mark old suite as vacant
        $this->common_model->commonRecordUpdate('suites','id',$old_suite_number,$old_suite_data);
        log_message('info', "SUITE STATUS UPDATE: Marked old suite {$old_suite_number} as vacant after moving active patient to suite {$suite_number}. Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", Person ID={$person_id}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
    }

    // Check if dietary/allergens changed (for update notifications)
    $dietaryOrAllergenChanged = false;
    if (!empty($person_id)) {
        // Get old patient data to compare
        $oldPatient = $this->common_model->fetchRecordsDynamically('people', ['allergies', 'dietary_preferences'], ['id' => $person_id]);
        if (!empty($oldPatient)) {
            $oldAllergies = $oldPatient[0]['allergies'] ?? '';
            $oldDietary = $oldPatient[0]['dietary_preferences'] ?? '';
            // Check if allergies or dietary preferences changed
            if ($oldAllergies !== $allergies_value || $oldDietary !== $dietary_preferences_value) {
                $dietaryOrAllergenChanged = true;
            }
        }
    }
    
    // Save or update patient record
    if (empty($person_id)) {
        $save_data['date_added'] = australia_datetime();      
        $actionid = $this->common_model->commonRecordCreate('people',$save_data);
        
        log_message('info', "PATIENT ONBOARD SUCCESS: Patient ID={$actionid}, Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", Suite Number={$suite_number}, Onboard Date={$onboard_date}, Discharge Date=" . ($discharge_date ?: 'NONE') . ", Status=" . ($should_be_discharged ? 'DISCHARGED' : 'ACTIVE') . ", Suite Status=" . ($should_be_discharged ? 'VACANT' : 'OCCUPIED') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // SIMPLIFIED NOTIFICATION 1: Suite Added - New patient onboarded
        $patientName = $save_data['name'] ?: 'Unknown Patient';
        $suiteNo = $save_data['suite_number'] ?: 'Unknown Suite';
        
        // SIMPLIFIED: Suite Added notification (timestamp below shows when created)
        $msg = "Suite Added: Suite {$suiteNo} - onboarded new patient {$patientName}";
        $this->load->helper('notification');
        createNotification($this->tenantDb, 1, $this->selected_location_id, 'alert', $msg);
    } else {
        $save_data['date_modified'] = australia_datetime();
        $this->common_model->commonRecordUpdate('people','id',$person_id,$save_data);
        
        log_message('info', "PATIENT UPDATE SUCCESS: Patient ID={$person_id}, Patient Name=" . ($patient_name ?: 'UNKNOWN') . ", Suite Number={$suite_number}, Old Suite Number=" . ($old_suite_number ?: 'NONE') . ", Onboard Date={$onboard_date}, Discharge Date=" . ($discharge_date ?: 'NONE') . ", Status=" . ($should_be_discharged ? 'DISCHARGED' : 'ACTIVE') . ", Suite Status=" . ($should_be_discharged ? 'VACANT' : 'OCCUPIED') . ", Dietary/Allergen Changed=" . ($dietaryOrAllergenChanged ? 'YES' : 'NO') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // SIMPLIFIED NOTIFICATION 2: Patient Updated - Only if dietary/allergens changed
        if ($dietaryOrAllergenChanged) {
            $patientName = $save_data['name'] ?: 'Unknown Patient';
            
            // SIMPLIFIED: Patient Updated notification (timestamp below shows when created)
            $msg = "Patient Updated: {$patientName} - dietary or allergens updated";
            $this->load->helper('notification');
            createNotification($this->tenantDb, 1, $this->selected_location_id, 'notice', $msg);
        }
    }
    
    // Set success message with debug info
    $action = empty($person_id) ? 'onboarded' : 'updated';
    $status_text = $should_be_discharged ? 'discharged' : 'active';
    $suite_status = $should_be_discharged ? 'vacant' : 'occupied';
    
    $this->session->set_flashdata('sucess_msg', 'Client ' . $action . ' successfully! Status: ' . $status_text . ', Suite: ' . $suite_status);
    
    // Get current user role
    $userRole = $this->ion_auth->get_users_groups()->row()->id;
    
    // Redirect based on user role
    // Nurses (role 3) and Chefs (role 5) go back to suites page
    if ($userRole == 3 || $userRole == 5) {
        redirect('/Orderportal/Hospitalconfig/List');
    } else {
        // Other roles (admin, reception) go to onboarding list
        redirect('Orderportal/Patient/Onboarding');
    }
}

    
    public function is_suite_occupied() {
        
       $suite_number =  $this->input->post('suite_number');
       $conditions = array('id' => $suite_number,  'is_vaccant' => 0); 
        $result = $this->common_model->fetchRecordsDynamically('suites',['id'],$conditions);

       echo json_encode($result);
    }
    
    public function getbedno() {
    $floor_id = $this->input->post('floor_id');

    $conditionsB['floor'] = $floor_id;
    $conditionsB['status'] = '1';          // Only active suites
    $conditionsB['is_deleted'] = '0';      // Exclude deleted suites
    $conditionsB['is_vaccant'] = '1';      // Only show vacant/available suites
    $suites = $this->common_model->fetchRecordsDynamically('suites',['bed_no','id','floor'],$conditionsB);

    echo json_encode($suites);
}

    /**
     * Update patient status (active/discharged)
     * Called via AJAX from patient list discharge toggle
     */
    public function updateStatus() {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        $patient_id = $this->input->post('id');
        $status = $this->input->post('status');
        
        // Validate input
        if (empty($patient_id)) {
            log_message('error', "PATIENT STATUS UPDATE FAILED: No patient ID provided. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Patient ID is required']);
            return;
        }
        
        if (!in_array($status, ['active', 'discharged'])) {
            log_message('error', "PATIENT STATUS UPDATE FAILED: Invalid status={$status}. Patient ID={$patient_id}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
            return;
        }
        
        // Convert status to numeric value
        // 1 = active, 2 = discharged
        $status_value = ($status == 'discharged') ? 2 : 1;
        
        // Get patient details to update suite if being discharged
        $patient_conditions = array('id' => $patient_id);
        $patient_details = $this->common_model->fetchRecordsDynamically('people', '', $patient_conditions);
        
        if (empty($patient_details)) {
            log_message('error', "PATIENT STATUS UPDATE FAILED: Patient ID={$patient_id} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Patient not found']);
            return;
        }
        
        $patient = $patient_details[0];
        $old_status = $patient['status'];
        
        log_message('info', "PATIENT STATUS UPDATE: Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", Old Status=" . ($old_status == 1 ? 'ACTIVE' : ($old_status == 2 ? 'DISCHARGED' : 'UNKNOWN')) . ", New Status=" . strtoupper($status) . ", Suite Number=" . ($patient['suite_number'] ?: 'NONE') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // Update patient status
        $update_data = array(
            'status' => $status_value,
            'date_modified' => australia_datetime()
        );
        
        // If discharging, set actual discharge date if not already set
        if ($status == 'discharged' && empty($patient['date_of_discharge'])) {
            $update_data['date_of_discharge'] = australia_date_only();
        }
        
        $result = $this->common_model->commonRecordUpdate('people', 'id', $patient_id, $update_data);
        
        if ($result) {
            // If patient is being discharged, make their suite available
            if ($status == 'discharged' && !empty($patient['suite_number'])) {
                $suite_update = array('is_vaccant' => 1);
                $this->common_model->commonRecordUpdate('suites', 'id', $patient['suite_number'], $suite_update);
                log_message('info', "SUITE STATUS UPDATE: Suite {$patient['suite_number']} marked as VACANT after patient discharge. Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            }
            
            log_message('info', "PATIENT STATUS UPDATE SUCCESS: Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", Status changed to " . strtoupper($status) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Client status updated successfully',
                'new_status' => $status
            ]);
        } else {
            log_message('error', "PATIENT STATUS UPDATE FAILED: Database update failed for Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Failed to update client status']);
        }
    }
    
    /**
     * Fix existing patients that might not have status set
     * This method can be called once to update legacy data
     */
    public function fixPatientStatus() {
        // Only allow admin users to run this
        if (!$this->ion_auth->is_admin()) {
            show_error('Access denied');
            return;
        }
        
        // Get all patients without status or with NULL status
        $conditions = array('status' => NULL);
        $patients_without_status = $this->common_model->fetchRecordsDynamically('people', '', $conditions);
        
        if (empty($patients_without_status)) {
            echo "No patients found without status. All patients already have status set.";
            return;
        }
        
        $updated_count = 0;
        foreach ($patients_without_status as $patient) {
            $update_data = array('status' => 1); // Set to active by default
            $result = $this->common_model->commonRecordUpdate('people', 'id', $patient['id'], $update_data);
            if ($result) {
                $updated_count++;
            }
        }
        
        echo "Updated status for $updated_count patients out of " . count($patients_without_status) . " patients without status.";
    }
    
    /**
     * Delete patient and free up their suite
     * Called via AJAX from patient list
     */
    public function deletePatient() {
        $this->load->helper('custom'); // Load custom helper for Australia timezone functions
        
        $patient_id = $this->input->post('id');
        
        // Validate input
        if (empty($patient_id)) {
            log_message('error', "PATIENT DELETE FAILED: No patient ID provided. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Patient ID is required']);
            return;
        }
        
        // Get patient details to free up suite if needed
        $patient_conditions = array('id' => $patient_id);
        $patient_details = $this->common_model->fetchRecordsDynamically('people', '', $patient_conditions);
        
        if (empty($patient_details)) {
            log_message('error', "PATIENT DELETE FAILED: Patient ID={$patient_id} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Patient not found']);
            return;
        }
        
        $patient = $patient_details[0];
        
        log_message('info', "PATIENT DELETE: Attempting to delete Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", Suite Number=" . ($patient['suite_number'] ?: 'NONE') . ", Status=" . ($patient['status'] == 1 ? 'ACTIVE' : ($patient['status'] == 2 ? 'DISCHARGED' : 'UNKNOWN')) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        // Delete the patient record
        $this->common_model->commonRecordDelete('people', $patient_id, 'id');
        
        // Check if deletion was successful
        if ($this->tenantDb->affected_rows() > 0) {
            // If patient was in a suite, make it vacant
            if (!empty($patient['suite_number'])) {
                $suite_update = array('is_vaccant' => 1);
                $this->common_model->commonRecordUpdate('suites', 'id', $patient['suite_number'], $suite_update);
                log_message('info', "SUITE STATUS UPDATE: Suite {$patient['suite_number']} marked as VACANT after patient deletion. Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            }
            
            log_message('info', "PATIENT DELETE SUCCESS: Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", Suite Number=" . ($patient['suite_number'] ?: 'NONE') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            
            echo json_encode([
                'status' => 'success', 
                'message' => 'Client deleted successfully'
            ]);
        } else {
            log_message('error', "PATIENT DELETE FAILED: Database deletion returned 0 affected rows for Patient ID={$patient_id}, Patient Name=" . ($patient['name'] ?: 'UNKNOWN') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete client']);
        }
    }

    
}
    
    ?>