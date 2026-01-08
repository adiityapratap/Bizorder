<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menuplanner extends MY_Controller {
    function __construct() {
		parent::__construct();
	    $this->load->model('configfoodmenu_model');
	    $this->selected_location_id = $this->session->userdata('location_id');
	   !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
	    $this->load->model('menu_model');
	    $this->load->model('common_model');
	    $this->load->helper('custom'); // Load custom helper for Australia timezone functions
	    
	    $role = $this->ion_auth->get_users_groups()->row();
        $this->role_id = $role ? $role->id : null;
        $this->department_id = $this->session->userdata('department_id');
	   
	}
    
    /**
     * Get current date in Australia/Sydney timezone (YYYY-MM-DD format)
     * CRITICAL: Use this for all date operations to prevent timezone mismatches
     * Handles both Y-m-d and d-m-Y date formats to prevent parsing errors
     */
    private function getAustraliaDate($dateString = null) {
        $timezone = new DateTimeZone('Australia/Sydney');
        if ($dateString) {
            // First try Y-m-d format (database format)
            $date = DateTime::createFromFormat('Y-m-d', $dateString, $timezone);
            
            // If that fails, try d-m-Y format (display format from frontend)
            if ($date === false) {
                $date = DateTime::createFromFormat('d-m-Y', $dateString, $timezone);
            }
            
            // If both fail, let DateTime try to parse it automatically
            if ($date === false) {
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
     * Get date N days from today in Australia/Sydney timezone
     */
    private function getAustraliaDateOffset($days = 0) {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        if ($days != 0) {
            $date->modify($days > 0 ? "+{$days} days" : "{$days} days");
        }
        return $date->format('Y-m-d');
    }
	
    function commonData(){
        $returnData =array();
         $conditions['listtype'] = 'floor';
        $returnData['floorList'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        return $returnData;
    }

  public function list(){
       
        $commonData = $this->commonData();
        $data['departmentList'] = $commonData['floorList'];
        
        // AUTO-PUBLISH: Check for unpublished menus 4 days before their date
        // COMMENTED OUT: Automatic menu planner generation disabled per user request
        // $this->autoPublishUpcomingMenus();
       
      $conditionsMP = ['status' => [1, 2]];
      if($this->role_id ==3 ){
          // NURSE ROLE: Only show published menus (status = 2), not saved ones (status = 1)
          // Also filter by their department
          // NURSE RESTRICTION: Show ONLY today and tomorrow's menus
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $conditionsMP = [
            'department_id' => [0, $this->department_id],
            'status' => 2,  // Only published menus for nurses
            'date >=' => $this->getAustraliaDate(),  // From today onwards
            'date <=' => $this->getAustraliaTomorrow()  // Until tomorrow
        ];
      }
      
      // Past menu lists - also filter for nurses
      // 🔧 FIX: Exclude deleted menu planners (status = 0) from past menus
      // CRITICAL FIX: Use Australia/Sydney timezone for date operations
      $conditionsPML = [];
      $conditionsPML['date <'] = $this->getAustraliaDate();
      $conditionsPML['status !='] = 0; // Exclude deleted menu planners
      if($this->role_id == 3) {
          // Nurses should NOT see past menus - only today and tomorrow
          // Set empty condition to return no past menus for nurses
          $conditionsPML = ['id' => 0]; // No past menus for nurses
      }
      // Limit initial display to last 30 records for better performance
      $data['pastMenuPlannerLists'] = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsPML,'date DESC', 30);
      
      if($this->role_id != 3) {
          // For non-nurses, show all future menus
          // CRITICAL FIX: Use Australia/Sydney timezone for date operations
          $conditionsMP['date >='] = $this->getAustraliaDate();
      }
      $data['menuPlannerLists'] = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsMP,'date DESC');
      
      // Check if orders exist for each menu planner date
      // This prevents accidental deletion of published menus that have orders
      $datesWithOrders = [];
      
      // Check daily menu planners
      if (!empty($data['menuPlannerLists'])) {
          foreach ($data['menuPlannerLists'] as $menuPlanner) {
              // 🔒 FIX: Only count ACTIVE orders (status != 0), exclude cancelled
              $this->tenantDb->where('date', $menuPlanner['date']);
              $this->tenantDb->where('status !=', 0); // Exclude cancelled orders
              $orderCount = $this->tenantDb->count_all_results('orders');
              
              if ($orderCount > 0) {
                  $datesWithOrders[$menuPlanner['date']] = $orderCount;
              }
          }
      }
      
      // Check past menu planners
      if (!empty($data['pastMenuPlannerLists'])) {
          foreach ($data['pastMenuPlannerLists'] as $menuPlanner) {
              // 🔒 FIX: Only count ACTIVE orders (status != 0), exclude cancelled
              $this->tenantDb->where('date', $menuPlanner['date']);
              $this->tenantDb->where('status !=', 0); // Exclude cancelled orders
              $orderCount = $this->tenantDb->count_all_results('orders');
              
              if ($orderCount > 0) {
                  $datesWithOrders[$menuPlanner['date']] = $orderCount;
              }
          }
      }
      
      $data['datesWithOrders'] = $datesWithOrders;
      
      
    //   echo "<pre>"; print_r($data['pastMenuPlannerLists']); exit;
       
       
      $conditionsWMP = ['status' => 1];
      $data['weeklyMenuPlannerLists'] = $this->common_model->fetchRecordsDynamically('weeklyMenuPlannerList', '', $conditionsWMP,'id DESC');
       
       
    //   $conditionsMP = ['status' => [1, 2]];
    //   $data['menuPlannerLists'] = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsMP);
    //  echo "<pre>"; print_r($data['menuPlannerLists']); exit;
     $this->load->view('general/landingPageHeader');
     $this->load->view('Menuplanner/list',$data);
      $this->load->view('general/landingPageFooter');
    
       
  }
   
   function fetchPlannedMenuList(){
       
       $result = $this->menu_model->fetchMenuDetails('',true);
      
        // echo "<pre>"; print_r($result); exit;

    //     $groupedMenus = [];
    //     foreach ($result as $menu) {
    //     $category = $menu['category_name'];

    //     // Initialize the category array if not set
    //     if (!isset($groupedMenus[$category])) {
    //         $groupedMenus[$category] = [];
    //     }

    //     // Add menu to the corresponding category
    //     $groupedMenus[$category][] = [
    //         'menu_name' => $menu['menu_name'],
    //         'displayOnDashbord' => $menu['displayOnDashbord'],
    //         'menu_id' => $menu['menu_id'],
    //         'description' => $menu['description'],
    //         'cuisine_type' => $menu['cuisine_type'],
    //         'menu_type' => $menu['menu_type'],
    //         'menu_options' => $menu['menu_options']
    //     ];
    // }
    return $result;
   }
   
   public function createMenuPlanner(){
      
       // SECURITY: Nurses cannot create or edit menu planners
       if($this->role_id == 3) {
           $this->session->set_flashdata('error', 'You do not have permission to create menu planners.');
           redirect('Orderportal/Menuplanner/list');
           return;
       }
      
       $commonData = $this->commonData();
       $data['departmentListData'] = $commonData['floorList'];
       
        $conditions['listtype'] = 'category';
        $conditions['is_deleted'] = '0';
        $data['categories']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
       $data['menuLists'] = $this->fetchPlannedMenuList();
       
       // Fetch allergen names for tooltip display
       $conditions2['listtype'] = 'allergen';
       $conditions2['is_deleted'] = 0;
       $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions2);
       
    //   echo "<pre>"; print_r( $data['menuLists']); exit;
        $data['isPublished'] = false;
      
        $data['isDailyMenuPlanner'] = true;
       
       $this->load->view('general/landingPageHeader');
      $this->load->view('Menuplanner/viewMenuPlanner',$data);
      $this->load->view('general/landingPageFooter');
   }
   
   function validateMenuPlanner($postedData,$date){
      // ═══════════════════════════════════════════════════════════════════════
      // COMPREHENSIVE LOGGING for Menu Planner Validation
      // ═══════════════════════════════════════════════════════════════════════
      
      log_message('info', "MENU PLANNER VALIDATION: Checking date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
      
      $isValidated = true;
      
      // For "All Floors" approach, always check for department_id = 0
      $deptId = 0;
      
      // 🔒 CRITICAL VALIDATION: Check for ANY published menu (status = 2) for this date
      // Only ONE published menu allowed per date - this is a strict business rule
      $this->tenantDb->where('date', $date);
      $this->tenantDb->where('department_id', $deptId);
      $this->tenantDb->where('status', 2); // Only check published menus
      $publishedMenu = $this->tenantDb->get('menuPlanner')->row();
      
      if ($publishedMenu) {
          // Published menu exists - block creation/update
          log_message('warning', "MENU PLANNER VALIDATION FAILED: Published menu already exists for date={$date}, Menu ID={$publishedMenu->id}, Status={$publishedMenu->status}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
          $isValidated = false;
      } else {
          log_message('info', "MENU PLANNER VALIDATION: No published menu found for date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
      }
      
      // Check for existing menu planner for this date (All Floors approach)
      // Exclude soft-deleted menus (status = 0)
      $conditions = ['date' => $date, 'department_id' => $deptId, 'status !=' => 0];
      $existingData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
      
      if (!empty($existingData)) {
          $existingCount = count($existingData);
          $existingIds = array_column($existingData, 'id');
          $existingStatuses = array_column($existingData, 'status');
          log_message('info', "MENU PLANNER VALIDATION: Found {$existingCount} existing menu planner(s) for date={$date}. IDs=[" . implode(', ', $existingIds) . "], Statuses=[" . implode(', ', $existingStatuses) . "], User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
      } else {
          log_message('info', "MENU PLANNER VALIDATION: No existing menu planner found for date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
      }
      
      // If published menu check failed above, existingData will still be populated for reference
      // But we've already set $isValidated = false, so this is just for returning data

      log_message('info', "MENU PLANNER VALIDATION RESULT: Date={$date}, Validated=" . ($isValidated ? 'YES' : 'NO') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
     
      $result['isValidated'] = $isValidated;
      $result['existingData'] = $existingData;
      return $result;
     
   }
   

  // this is for saving data from  daily menu planner 
   public function saveDailyMenuPlanner() {
    // ═══════════════════════════════════════════════════════════════════════
    // COMPREHENSIVE LOGGING for Menu Planner Save/Update Operations
    // This helps track mysterious deletions and data changes
    // ═══════════════════════════════════════════════════════════════════════
    
    // Check authentication first for AJAX requests
    if($this->input->is_ajax_request() && !$this->ion_auth->logged_in()) {
        log_message('warning', "MENU PLANNER SAVE BLOCKED: Unauthenticated AJAX request from IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please login again.']);
        return;
    }
    
    // SECURITY: Nurses cannot save or publish menu planners
    if($this->role_id == 3) {
        log_message('warning', "MENU PLANNER SAVE BLOCKED: Nurse attempted save. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . " IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to save or publish menu planners.']);
        return;
    }
      
    $deptId = $this->input->post('department_id') !== FALSE && $this->input->post('department_id') !== '' ? $this->input->post('department_id') : 0;
    
    // For "All Floors" approach, always use department_id = 0
    $deptId = 0;
    $optionMenus = $this->input->post('optionMenus');
     $noOptionMenus = $this->input->post('noOptionMenus');

    // CRITICAL FIX: Validate date input
    $dateInput = $this->input->post('date');
    if (empty($dateInput)) {
        log_message('error', "MENU PLANNER SAVE FAILED: No date provided. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . " IP=" . $this->input->ip_address() . " at " . australia_datetime());
        if($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Date is required.']);
            return;
        } else {
            redirect('Orderportal/Menuplanner/List');
        }
    }
    
    // CRITICAL FIX: Use Australia/Sydney timezone for date parsing to prevent timezone conversion issues
    // This ensures dates are stored correctly regardless of server timezone
    $date = $this->getAustraliaDate($dateInput);
    
    // CRITICAL FIX: Validate date parsing
    if (!$date || $date === '1970-01-01') {
        log_message('error', "MENU PLANNER SAVE FAILED: Invalid date format: {$dateInput}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . " IP=" . $this->input->ip_address() . " at " . australia_datetime());
        if($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid date format. Please select a valid date.']);
            return;
        } else {
            redirect('Orderportal/Menuplanner/List');
        }
    }
    
    // 🔒 CRITICAL VALIDATION: Save/create only works for future dates (including today)
    // Past dates cannot be created/updated - preserve historical records
    $today = $this->getAustraliaDate();
    if ($date < $today) {
        log_message('warning', "MENU PLANNER SAVE BLOCKED: Attempted to save past date {$date} (today={$today}). User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        if($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot create or update menu for past dates. Please select today or a future date.']);
            return;
        } else {
            redirect('Orderportal/Menuplanner/List');
        }
    }
    
    $menuPlannerId = $this->input->post('menuPlannerId') ?? ''; 
    $menuPlannerRecordId = $this->input->post('menuPlannerRecordId') ?? ''; // The actual menuPlanner table ID
    $isWeeklyMenuPlanner = $this->input->post('isWeeklyMenuPlanner') ?? ''; 
    $saveType = $this->input->post('saveTypeBtn'); // 1 for save, 2 for publish
    
    // CRITICAL FIX: Validate saveType
    if (empty($saveType) || !in_array($saveType, [1, 2])) {
        log_message('error', "MENU PLANNER SAVE FAILED: Invalid saveType: {$saveType}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . " IP=" . $this->input->ip_address() . " at " . australia_datetime());
        if($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid save type. Please try again.']);
            return;
        } else {
            redirect('Orderportal/Menuplanner/List');
        }
    }
    
    $isCreate = false;
    
    // 🔒 COMPREHENSIVE LOGGING: Log operation start with ALL parameters
    log_message('info', "MENU PLANNER SAVE INITIATED: Date={$date}, Menu Planner ID=" . ($menuPlannerId ?: 'NEW') . ", Record ID=" . ($menuPlannerRecordId ?: 'NONE') . ", Save Type=" . ($saveType == 2 ? 'PUBLISH' : 'SAVE') . " (saveType={$saveType}), Department ID={$deptId}, Is Weekly=" . ($isWeeklyMenuPlanner ?: 'NO') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Option Menus Count=" . (is_array($optionMenus) ? count($optionMenus) : 0) . ", No Option Menus Count=" . (is_array($noOptionMenus) ? count($noOptionMenus) : 0) . ", POST Data Keys=" . json_encode(array_keys($_POST)) . ", Timestamp=" . australia_datetime());
    // in case of updating menuplanner we do not need to validate this case ,i.e if a menuplanner exist for a particular date
     if($menuPlannerId==''){
     $result = $this->validateMenuPlanner($_POST,$date);   
     $isValidated = $result['isValidated'];
     $existingData = $result['existingData'];
     
     }else{
      $isValidated = true;   
     }
    
    
    if($isValidated){
        // Validation passed - check if menus are selected
        if((isset($optionMenus) && !empty($optionMenus)) || (isset($noOptionMenus) && !empty($noOptionMenus))){
            // Menus are selected, process them
            
            // CRITICAL FIX: Default to CREATE to prevent wrong updates
            $isCreate = true;
            $actualMenuPlannerRecordId = null;
            
            // PRIORITY 1: Check if we have the actual menuPlanner record ID (most reliable)
            // 🔒 CRITICAL FIX: MUST verify the record ID matches the date being saved!
            // Without this check, wrong records get updated when date input is wrong (timezone bug)
            if($menuPlannerRecordId != '' && $menuPlannerRecordId != '0'){
                // CRITICAL: Verify this record ID actually belongs to the date we're saving
                $this->tenantDb->where('id', $menuPlannerRecordId);
                $this->tenantDb->where('date', $date); // MUST match the date!
                $verifiedRecord = $this->tenantDb->get('menuPlanner')->row();
                
                if($verifiedRecord) {
                    // Record ID matches the date - safe to update
                    $actualMenuPlannerRecordId = $menuPlannerRecordId;
                    $isCreate = false;
                    log_message('info', "MENU PLANNER UPDATE MODE: Verified menuPlannerRecordId={$actualMenuPlannerRecordId} matches date={$date} at " . australia_datetime());
                } else {
                    // Record ID doesn't match the date - this is WRONG! Don't update it, create new instead
                    log_message('error', "MENU PLANNER UPDATE BLOCKED: menuPlannerRecordId={$menuPlannerRecordId} does NOT match date={$date}. This would update the wrong record! Creating new record instead. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    // Check what date this record actually belongs to
                    $this->tenantDb->where('id', $menuPlannerRecordId);
                    $wrongRecord = $this->tenantDb->get('menuPlanner')->row();
                    if($wrongRecord) {
                        log_message('error', "MENU PLANNER DATE MISMATCH: Record ID={$menuPlannerRecordId} belongs to date={$wrongRecord->date}, but trying to save date={$date}. BLOCKED to prevent date corruption!");
                    }
                    // Force CREATE instead of UPDATE to prevent wrong record update
                    $isCreate = true;
                    $actualMenuPlannerRecordId = null;
                }
                
            // PRIORITY 2: Check if menuPlannerId exists AND matches the current date
            } else if($menuPlannerId != '' && $menuPlannerId != '0'){
                // CRITICAL FIX: Must verify the menuPlannerId is for THIS SPECIFIC DATE
                // Without date check, wrong records get updated!
                $conditions = [
                    'dailyMenuPlannerId' => $menuPlannerId,
                    'date' => $date  // ⚠️ MUST match the date we're saving!
                ];
                $existingMenuPlanner = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
                
                if(!empty($existingMenuPlanner)) {
                    // Found existing menuPlanner record FOR THIS DATE
                    // 🔒 CRITICAL PROTECTION: Check if record is published - published records cannot be modified!
                    if (isset($existingMenuPlanner[0]['status']) && $existingMenuPlanner[0]['status'] == 2) {
                        log_message('error', "MENU PLANNER UPDATE BLOCKED: Record ID={$existingMenuPlanner[0]['id']} is PUBLISHED (status=2) and cannot be modified! Date={$date}. Published records are immutable. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                        echo json_encode(['status' => 'error', 'message' => 'This menu has been published and cannot be modified. Please delete it first if you need to make changes.']);
                        return;
                    }
                    // Record exists and is NOT published - safe to update
                    $actualMenuPlannerRecordId = $existingMenuPlanner[0]['id'];
                    $isCreate = false;
                    log_message('info', "MENU PLANNER UPDATE MODE: Found existing record ID={$actualMenuPlannerRecordId} for date={$date} at " . australia_datetime());
                } else {
                    // No menuPlanner exists for THIS date - CREATE NEW
                    $isCreate = true;
                    log_message('info', "MENU PLANNER CREATE MODE: No record found for date={$date}, creating new at " . australia_datetime());
                }
                
            // PRIORITY 3: Re-check database for existing record BY DATE (fresh check)
            } else {
                // CRITICAL FIX: Do a FRESH database check, don't trust $existingData from validation
                // $existingData might be from a different date or stale
                $freshCheck = ['date' => $date, 'department_id' => $deptId, 'status !=' => 0];
                $freshExistingData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $freshCheck);
                
                if(!empty($freshExistingData)) {
                    // Found existing record for this specific date
                    // 🔒 CRITICAL PROTECTION: Check if record is published - published records cannot be modified!
                    if (isset($freshExistingData[0]['status']) && $freshExistingData[0]['status'] == 2) {
                        log_message('error', "MENU PLANNER UPDATE BLOCKED: Record ID={$freshExistingData[0]['id']} is PUBLISHED (status=2) and cannot be modified! Date={$date}. Published records are immutable. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                        echo json_encode(['status' => 'error', 'message' => 'This menu has been published and cannot be modified. Please delete it first if you need to make changes.']);
                        return;
                    }
                    // Record exists and is NOT published - safe to update
                    $actualMenuPlannerRecordId = $freshExistingData[0]['id'];
                    $isCreate = false;
                    log_message('info', "MENU PLANNER UPDATE MODE: Fresh check found record ID={$actualMenuPlannerRecordId} for date={$date} at " . australia_datetime());
                } else {
                    // Definitely no record exists for this date - CREATE NEW
                    $isCreate = true;
                    log_message('info', "MENU PLANNER CREATE MODE: Fresh check confirms no record for date={$date} at " . australia_datetime());
                }
            }
            
            // 🔒 CRITICAL PROTECTION: Check if record is published BEFORE preparing update data
            // If updating an existing record, check current status FIRST to prevent status downgrade
            $finalStatus = $saveType; // Default to saveType for new records
            if (!$isCreate) {
                // We're updating - check current status BEFORE preparing update data
                $checkRecordId = $actualMenuPlannerRecordId ?? null;
                if ($checkRecordId) {
                    $this->tenantDb->where('id', $checkRecordId);
                    $currentRecord = $this->tenantDb->get('menuPlanner')->row();
                    if ($currentRecord && $currentRecord->status == 2) {
                        // Record is PUBLISHED - NEVER allow status downgrade!
                        // Published status (2) is IMMUTABLE - it can only be deleted, never changed to saved (1)
                        log_message('error', "MENU PLANNER STATUS PROTECTION: Record ID={$checkRecordId} is PUBLISHED (status=2). Attempted to update with saveType={$saveType}, but published status cannot be downgraded! Date={$currentRecord->date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                        echo json_encode(['status' => 'error', 'message' => 'This menu has been published and cannot be modified. Published menus are immutable. Please delete it first if you need to make changes.']);
                        return;
                    }
                    // If not published, use the saveType as-is
                    $finalStatus = $saveType;
                } else {
                    // No record ID yet - do fresh check by date
                    $freshStatusCheck = ['date' => $date, 'department_id' => $deptId, 'status !=' => 0];
                    $statusCheckData = $this->common_model->fetchRecordsDynamically('menuPlanner', ['id', 'status'], $freshStatusCheck);
                    if (!empty($statusCheckData) && isset($statusCheckData[0]['status']) && $statusCheckData[0]['status'] == 2) {
                        // Found published record for this date - BLOCK update
                        log_message('error', "MENU PLANNER STATUS PROTECTION: Found PUBLISHED record (ID={$statusCheckData[0]['id']}, status=2) for date={$date}. Cannot update published menus! User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                        echo json_encode(['status' => 'error', 'message' => 'A published menu already exists for this date and cannot be modified. Published menus are immutable.']);
                        return;
                    }
                    $finalStatus = $saveType;
                }
            }
            
            // Prepare menu planner data
            $serializedOptionMenus = serialize($optionMenus);
            $serializedNoOptionMenus = serialize($noOptionMenus);
            
            // 🔒 CRITICAL: Date field is IMMUTABLE after creation - never update it!
            // Prepare data for CREATE (includes date) and UPDATE (excludes date) separately
            $menuPlannerDataForCreate = [
                'department_id' => $deptId,
                'menuWithOptions' => $serializedOptionMenus,
                'menuWithoutOptions' => $serializedNoOptionMenus,  
                'status' => $saveType,
                'date' => $date,  // Only for CREATE - date is set once and never changes
            ];
            
            $menuPlannerDataForUpdate = [
                'department_id' => $deptId,
                'menuWithOptions' => $serializedOptionMenus,
                'menuWithoutOptions' => $serializedNoOptionMenus,  
                'status' => $finalStatus, // Use finalStatus which has been validated
                // ❌ NO DATE FIELD - Date is IMMUTABLE after creation!
            ];    
         
            if($isCreate === true){
                // CREATE NEW RECORD
                log_message('info', "MENU PLANNER CREATE: Creating new menu planner. Date={$date}, Status={$saveType}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                
                // ✅ SIMPLIFIED: No need to check for deleted menus - we use hard delete now
                // If menu was deleted, it's already gone from database
                
                // First, create entry in dailyMenuPlannerList if needed
                if(!$menuPlannerId || $menuPlannerId == '' || $menuPlannerId == '0') {
                    $saveDMPData = [
                        'date' => $date,
                        'department_id' => $deptId,
                        'status' => 1, 
                    ]; 
                    $menuPlannerId = $this->common_model->commonRecordCreate('dailyMenuPlannerList', $saveDMPData);
                    log_message('info', "MENU PLANNER CREATE: Created dailyMenuPlannerList ID={$menuPlannerId} for date={$date} at " . australia_datetime());
                }
                
                // Add dailyMenuPlannerId for new records
                $menuPlannerDataForCreate['dailyMenuPlannerId'] = $menuPlannerId;
                
                // FIX: Handle duplicate key error (race condition protection)
                try {
                    // 🔒 COMPREHENSIVE LOGGING: Log CREATE data before insert
                    log_message('info', "MENU PLANNER CREATE DATA: Date={$date}, Status={$saveType}, Department ID={$deptId}, Daily Menu Planner ID={$menuPlannerId}, Option Menus Count=" . (is_array($optionMenus) ? count($optionMenus) : 0) . ", No Option Menus Count=" . (is_array($noOptionMenus) ? count($noOptionMenus) : 0) . ", Menu Options Length=" . strlen($serializedOptionMenus) . ", Menu Without Options Length=" . strlen($serializedNoOptionMenus) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                    
                    $result = $this->common_model->commonRecordCreate('menuPlanner', $menuPlannerDataForCreate);
                    $actualMenuPlannerRecordId = $this->tenantDb->insert_id();
                    
                    // 🔒 COMPREHENSIVE LOGGING: Log CREATE success with inserted ID
                    log_message('info', "MENU PLANNER CREATE SUCCESS: ID={$actualMenuPlannerRecordId}, Date={$date}, Status={$saveType}, Department ID={$deptId}, Daily Menu Planner ID={$menuPlannerId}, Insert ID={$actualMenuPlannerRecordId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                } catch (Exception $e) {
                    $errorMsg = $e->getMessage();
                    
                    // Check if it's a duplicate key error (Error 1062)
                    if(strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false) {
                        // Another process created the same record, switch to UPDATE
                        log_message('warning', "MENU PLANNER CREATE: Duplicate key detected during INSERT for date={$date}, switching to UPDATE. Error: {$errorMsg}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                        
                        // Fetch the existing record that was just created by another process
                        $freshCheck = ['date' => $date, 'department_id' => $deptId, 'status !=' => 0];
                        $freshExistingData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $freshCheck);
                        
                        if(!empty($freshExistingData)) {
                            // 🔒 CRITICAL PROTECTION: Check if record is published - published records cannot be modified!
                            if (isset($freshExistingData[0]['status']) && $freshExistingData[0]['status'] == 2) {
                                log_message('error', "MENU PLANNER UPDATE BLOCKED: Record ID={$freshExistingData[0]['id']} is PUBLISHED (status=2) and cannot be modified! Date={$date}. Published records are immutable. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                                echo json_encode(['status' => 'error', 'message' => 'This menu has been published and cannot be modified. Please delete it first if you need to make changes.']);
                                return;
                            }
                            $actualMenuPlannerRecordId = $freshExistingData[0]['id'];
                            
                            // 🔒 COMPREHENSIVE LOGGING: Log BEFORE update state (duplicate key path)
                            log_message('info', "MENU PLANNER UPDATE BEFORE (DUPLICATE KEY): Record ID={$actualMenuPlannerRecordId}, Date={$date}, Current Status={$freshExistingData[0]['status']}, Current Department ID={$freshExistingData[0]['department_id']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                            
                            // Use direct update to check affected rows - CRITICAL: Don't update date field!
                            // 🔒 CRITICAL PROTECTION: Explicitly remove date field if it somehow got included
                            unset($menuPlannerDataForUpdate['date']);
                            
                            // 🔒 COMPREHENSIVE LOGGING: Log UPDATE data (duplicate key path)
                            $statusChangeDup = ($freshExistingData[0]['status'] != $finalStatus) ? "STATUS CHANGE: {$freshExistingData[0]['status']} -> {$finalStatus}" : "STATUS UNCHANGED: {$finalStatus}";
                            log_message('info', "MENU PLANNER UPDATE DATA (DUPLICATE KEY): Record ID={$actualMenuPlannerRecordId}, Date={$date} (IMMUTABLE - preserved), {$statusChangeDup}, New Department ID={$deptId}, Update Fields=" . json_encode(array_keys($menuPlannerDataForUpdate)) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                            
                            // 🔒 FINAL SAFETY CHECK: Double-check status hasn't changed to published (race condition protection)
                            $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                            $finalStatusCheck = $this->tenantDb->get('menuPlanner')->row();
                            if ($finalStatusCheck && $finalStatusCheck->status == 2) {
                                log_message('error', "MENU PLANNER RACE CONDITION DETECTED: Status changed to PUBLISHED (2) between check and update! Record ID={$actualMenuPlannerRecordId}, Date={$date}. BLOCKING update to prevent status downgrade. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                                echo json_encode(['status' => 'error', 'message' => 'This menu was just published and cannot be modified. Please refresh the page.']);
                                return;
                            }
                            
                            // 🔒 CRITICAL PROTECTION: Add date to WHERE clause to prevent updating wrong records
                            $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                            $this->tenantDb->where('date', $date); // Extra safety: ensure date matches
                            $this->tenantDb->update('menuPlanner', $menuPlannerDataForUpdate);
                            $affectedRows = $this->tenantDb->affected_rows();
                            
                            // 🔒 COMPREHENSIVE LOGGING: Log AFTER update state (duplicate key path)
                            if ($affectedRows > 0) {
                                $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                                $updatedRecordDup = $this->tenantDb->get('menuPlanner')->row();
                                if ($updatedRecordDup) {
                                    log_message('info', "MENU PLANNER UPDATE AFTER (DUPLICATE KEY): Record ID={$actualMenuPlannerRecordId}, Date={$updatedRecordDup->date}, New Status={$updatedRecordDup->status}, New Department ID={$updatedRecordDup->department_id}, Status Changed=" . ($freshExistingData[0]['status'] != $updatedRecordDup->status ? 'YES (' . $freshExistingData[0]['status'] . ' -> ' . $updatedRecordDup->status . ')' : 'NO') . ", Affected Rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                                }
                            }
                            log_message('info', "MENU PLANNER UPDATE (DUPLICATE KEY): Updated menu planner ID={$actualMenuPlannerRecordId} after duplicate detection. Date={$date} (preserved), Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                        } else {
                            log_message('error', "MENU PLANNER CREATE CRITICAL ERROR: Duplicate key error but cannot find record for date={$date}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " IP=" . $this->input->ip_address() . " at " . australia_datetime());
                            if($this->input->is_ajax_request()) {
                                echo json_encode(['status' => 'error', 'message' => 'Database synchronization error. Please refresh and try again.']);
                                return;
                            }
                        }
                    } else {
                        // Different error, log and re-throw
                        log_message('error', "MENU PLANNER CREATE DATABASE ERROR: {$errorMsg}. Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                        if($this->input->is_ajax_request()) {
                            echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again.']);
                            return;
                        }
                    }
                }
                
            } else {
                // UPDATE EXISTING RECORD
                
                // Double-check we have a valid record ID
                if(!$actualMenuPlannerRecordId || $actualMenuPlannerRecordId == '0') {
                    log_message('error', "MENU PLANNER UPDATE CRITICAL ERROR: Attempting to update with invalid ID for date={$date}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                    echo json_encode(['status' => 'error', 'message' => 'Invalid record ID for update']);
                    return;
                }
                
                // 🔒 CRITICAL: Verify the existing record's date matches - date is IMMUTABLE!
                $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                $existingRecord = $this->tenantDb->get('menuPlanner')->row();
                
                if (!$existingRecord) {
                    log_message('error', "MENU PLANNER UPDATE FAILED: Record ID={$actualMenuPlannerRecordId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    echo json_encode(['status' => 'error', 'message' => 'Menu planner not found.']);
                    return;
                }
                
                // 🔒 CRITICAL PROTECTION: Published records (status = 2) CANNOT be modified!
                // Published menus are immutable - they cannot be updated, only deleted
                if ($existingRecord->status == 2) {
                    log_message('error', "MENU PLANNER UPDATE BLOCKED: Record ID={$actualMenuPlannerRecordId} is PUBLISHED (status=2) and cannot be modified! Date={$existingRecord->date}. Published records are immutable. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                    echo json_encode(['status' => 'error', 'message' => 'This menu has been published and cannot be modified. Please delete it first if you need to make changes.']);
                    return;
                }
                
                // 🔒 CRITICAL PROTECTION: Date field is IMMUTABLE - verify it hasn't changed
                if ($existingRecord->date != $date) {
                    log_message('error', "MENU PLANNER UPDATE BLOCKED: Date mismatch! Existing date={$existingRecord->date}, Attempted date={$date}. Date field is IMMUTABLE and cannot be changed! Record ID={$actualMenuPlannerRecordId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    echo json_encode(['status' => 'error', 'message' => 'Cannot change menu planner date. Date is immutable after creation.']);
                    return;
                }
                
                // 🔒 COMPREHENSIVE LOGGING: Log BEFORE update state
                log_message('info', "MENU PLANNER UPDATE BEFORE: Record ID={$actualMenuPlannerRecordId}, Date={$date}, Current Status={$existingRecord->status}, Current Department ID={$existingRecord->department_id}, Current Menu Options Length=" . strlen($existingRecord->menuWithOptions ?? '') . ", Current Menu Without Options Length=" . strlen($existingRecord->menuWithoutOptions ?? '') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                
                // 🔒 COMPREHENSIVE LOGGING: Log what will be updated
                $statusChange = ($existingRecord->status != $finalStatus) ? "STATUS CHANGE: {$existingRecord->status} -> {$finalStatus}" : "STATUS UNCHANGED: {$finalStatus}";
                log_message('info', "MENU PLANNER UPDATE DATA: Record ID={$actualMenuPlannerRecordId}, Date={$date} (IMMUTABLE - preserved), {$statusChange}, New Department ID={$deptId}, New Menu Options Count=" . (is_array($optionMenus) ? count($optionMenus) : 0) . ", New Menu Without Options Count=" . (is_array($noOptionMenus) ? count($noOptionMenus) : 0) . ", Update Fields=" . json_encode(array_keys($menuPlannerDataForUpdate)) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                
                // 🔒 CRITICAL FIX: Use direct database update to check affected rows
                // CRITICAL: Use $menuPlannerDataForUpdate which EXCLUDES the date field
                // Date field is IMMUTABLE after creation - never update it!
                try {
                    // 🔒 CRITICAL PROTECTION: Explicitly remove date field if it somehow got included
                    unset($menuPlannerDataForUpdate['date']);
                    
                    // 🔒 FINAL SAFETY CHECK: Double-check status hasn't changed to published (race condition protection)
                    $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                    $finalStatusCheck = $this->tenantDb->get('menuPlanner')->row();
                    if ($finalStatusCheck && $finalStatusCheck->status == 2) {
                        log_message('error', "MENU PLANNER RACE CONDITION DETECTED: Status changed to PUBLISHED (2) between check and update! Record ID={$actualMenuPlannerRecordId}, Date={$date}. BLOCKING update to prevent status downgrade. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                        echo json_encode(['status' => 'error', 'message' => 'This menu was just published and cannot be modified. Please refresh the page.']);
                        return;
                    }
                    
                    // 🔒 CRITICAL PROTECTION: Add date to WHERE clause to prevent updating wrong records
                    // This ensures we only update records matching BOTH id AND date
                    $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                    $this->tenantDb->where('date', $date); // Extra safety: ensure date matches
                    $this->tenantDb->update('menuPlanner', $menuPlannerDataForUpdate);
                    
                    $affectedRows = $this->tenantDb->affected_rows();
                    $dbError = $this->tenantDb->error();
                    
                    // 🔒 COMPREHENSIVE LOGGING: Log AFTER update state
                    if ($affectedRows > 0) {
                        // Fetch updated record to verify changes
                        $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                        $updatedRecord = $this->tenantDb->get('menuPlanner')->row();
                        if ($updatedRecord) {
                            log_message('info', "MENU PLANNER UPDATE AFTER: Record ID={$actualMenuPlannerRecordId}, Date={$updatedRecord->date}, New Status={$updatedRecord->status}, New Department ID={$updatedRecord->department_id}, Status Changed=" . ($existingRecord->status != $updatedRecord->status ? 'YES (' . $existingRecord->status . ' -> ' . $updatedRecord->status . ')' : 'NO') . ", Affected Rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                        }
                    }
                    
                    // Check for database errors
                    if (!empty($dbError['message'])) {
                        log_message('error', "MENU PLANNER UPDATE DATABASE ERROR: " . $dbError['message'] . ". Error Code=" . ($dbError['code'] ?? 'N/A') . ", Menu Planner ID={$actualMenuPlannerRecordId}, Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                        
                        // Check if it's a constraint violation
                        if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'unique_date_dept_active') !== false) {
                            log_message('error', "MENU PLANNER UPDATE CONSTRAINT ERROR: Unique constraint still exists! Please run REMOVE_CONSTRAINT_SQL.sql. Menu Planner ID={$actualMenuPlannerRecordId}, Date={$date} at " . australia_datetime());
                            if($this->input->is_ajax_request()) {
                                echo json_encode(['status' => 'error', 'message' => 'Database constraint error. Please contact administrator to remove the unique constraint.']);
                                return;
                            } else {
                                redirect('Orderportal/Menuplanner/List');
                            }
                        } else {
                            if($this->input->is_ajax_request()) {
                                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $dbError['message']]);
                                return;
                            } else {
                                redirect('Orderportal/Menuplanner/List');
                            }
                        }
                    }
                    
                    if ($affectedRows > 0) {
                        log_message('info', "MENU PLANNER UPDATE SUCCESS: ID={$actualMenuPlannerRecordId}, Date={$date}, Status={$saveType}, Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                    } else {
                        // Check if menu still exists
                        $this->tenantDb->where('id', $actualMenuPlannerRecordId);
                        $checkMenu = $this->tenantDb->get('menuPlanner')->row();
                        
                        if (!$checkMenu) {
                            log_message('error', "MENU PLANNER UPDATE FAILED: Menu ID={$actualMenuPlannerRecordId} not found (may have been deleted). Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                            if($this->input->is_ajax_request()) {
                                echo json_encode(['status' => 'error', 'message' => 'Menu planner not found. It may have been deleted. Please refresh the page.']);
                                return;
                            } else {
                                redirect('Orderportal/Menuplanner/List');
                            }
                        } else {
                            log_message('warning', "MENU PLANNER UPDATE: No rows affected for ID={$actualMenuPlannerRecordId} (data may be unchanged). Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                            // Still consider it success if menu exists (data might be the same)
                        }
                    }
                } catch (Exception $e) {
                    log_message('error', "MENU PLANNER UPDATE EXCEPTION: " . $e->getMessage() . ". Menu Planner ID={$actualMenuPlannerRecordId}, Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
                    if($this->input->is_ajax_request()) {
                        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
                        return;
                    } else {
                        redirect('Orderportal/Menuplanner/List');
                    }
                }
            }
            
            // Return success response
            if($this->input->is_ajax_request()) {
                $message = ($saveType == 2) ? 'Menu published successfully!' : 'Menu saved successfully!';
                $operation = ($isCreate) ? 'CREATE' : 'UPDATE';
                log_message('info', "MENU PLANNER SAVE COMPLETED: Operation={$operation}, Record ID=" . ($actualMenuPlannerRecordId ?: 'NONE') . ", Date={$date}, Status={$saveType}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
                echo json_encode(['status' => 'success', 'message' => $message]);
                return;
            } else {
                redirect('Orderportal/Menuplanner/List');
            }
        
        } else {
            // No menus selected
            log_message('warning', "MENU PLANNER SAVE FAILED: No menus selected. Date={$date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            if($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Please select at least one menu item before saving.']);
                return;
            } else {
                redirect('Orderportal/Menuplanner/List');
            }
        }
        
    } else {
        // Validation failed - published menu exists
        log_message('warning', "MENU PLANNER SAVE BLOCKED: Validation failed - published menu already exists for date={$date}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        if($this->input->is_ajax_request()) {
            $message = "This menu has already been published and cannot be modified. Please delete the existing published menu first before creating a new one.";
            echo json_encode(['status' => 'error', 'message' => $message]);
            return;
        } else {
            redirect('Orderportal/Menuplanner/List');
        }   
    }
         
        

   
}

public function recreateMenuPlanner() {
    // ═══════════════════════════════════════════════════════════════════════
    // COMPREHENSIVE LOGGING for Menu Planner Recreate Operations
    // ═══════════════════════════════════════════════════════════════════════
    
    log_message('info', "MENU PLANNER RECREATE INITIATED: User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
    
    // SECURITY: Nurses cannot recreate menu planners
    if($this->role_id == 3) {
        log_message('warning', "MENU PLANNER RECREATE BLOCKED: Nurse attempted recreate. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to recreate menu planners.']);
        return;
    }
    
    $menuPlannerId = $this->input->post('menuPlannerId');
    $dateInput = $this->input->post('date');
    
    // 🔒 CRITICAL FIX: Validate inputs
    if (empty($menuPlannerId) || empty($dateInput)) {
        log_message('error', "MENU PLANNER RECREATE FAILED: Missing required parameters. Menu Planner ID=" . ($menuPlannerId ?: 'EMPTY') . ", Date=" . ($dateInput ?: 'EMPTY') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu planner ID and date are required.']);
        return;
    }
    
    log_message('info', "MENU PLANNER RECREATE: Original Menu Planner ID={$menuPlannerId}, New Date Input={$dateInput}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
    
    // 🔒 CRITICAL FIX: Validate date format - Use Australia/Sydney timezone to prevent timezone conversion issues
    $newDate = $this->getAustraliaDate($dateInput);
    if (!$newDate || $newDate === '1970-01-01') {
        log_message('error', "MENU PLANNER RECREATE FAILED: Invalid date format: {$dateInput}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Invalid date format. Please select a valid date.']);
        return;
    }
    
    // 🔒 CRITICAL VALIDATION: Recreate only works for future dates (including today)
    // Past dates cannot be recreated - preserve historical records
    $today = $this->getAustraliaDate();
    if ($newDate < $today) {
        log_message('warning', "MENU PLANNER RECREATE BLOCKED: Attempted to recreate past date {$newDate} (today={$today}). User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Cannot recreate menu for past dates. Please select today or a future date.']);
        return;
    }

    // Fetch existing menu planner data
    $conditions = ['id' => $menuPlannerId, 'status !=' => 0];
    $existingMenuPlanner = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);

    if (empty($existingMenuPlanner)) {
        log_message('error', "MENU PLANNER RECREATE FAILED: Original Menu Planner ID={$menuPlannerId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu planner not found.']);
        return;
    }

    $existingData = $existingMenuPlanner[0];
    $originalDate = $existingData['date'];
    
    // 🔒 COMPREHENSIVE LOGGING: Log RECREATE before state
    log_message('info', "MENU PLANNER RECREATE BEFORE: Original Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, Original Status={$existingData['status']}, Original Department ID={$existingData['department_id']}, Original Menu Options Length=" . strlen($existingData['menuWithOptions'] ?? '') . ", Original Menu Without Options Length=" . strlen($existingData['menuWithoutOptions'] ?? '') . ", New Date={$newDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());

    // 🔒 CRITICAL FIX: Validate if a menu planner already exists for the new date
    // Fix: Pass array format, not object
    $validationResult = $this->validateMenuPlanner([], $newDate);
    if (!$validationResult['isValidated']) {
        log_message('warning', "MENU PLANNER RECREATE BLOCKED: Menu planner already exists for new date={$newDate}. Original Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Already exists menuPlanner for the selected date.']);
        return;
    }

    // Prepare data for recreation
    $deptId = $existingData['department_id'];
    
    // 🔒 CRITICAL FIX: Handle unserialize errors (corrupted data)
    $optionMenus = @unserialize($existingData['menuWithOptions']);
    $noOptionMenus = @unserialize($existingData['menuWithoutOptions']);
    
    if ($optionMenus === false && $existingData['menuWithOptions'] !== 'N;') {
        log_message('error', "MENU PLANNER RECREATE FAILED: Corrupted menuWithOptions data for ID={$menuPlannerId}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu data is corrupted. Cannot recreate this menu.']);
        return;
    }
    
    if ($noOptionMenus === false && $existingData['menuWithoutOptions'] !== 'N;') {
        log_message('error', "MENU PLANNER RECREATE FAILED: Corrupted menuWithoutOptions data for ID={$menuPlannerId}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu data is corrupted. Cannot recreate this menu.']);
        return;
    }
    
    // Handle empty serialized data
    if ($optionMenus === false) $optionMenus = [];
    if ($noOptionMenus === false) $noOptionMenus = [];
    
    $saveType = $existingData['status'];

    // Create new dailyMenuPlannerList entry if needed
    $newMenuPlannerId = '';
    $saveDMPData = [
        'date' => $newDate,
        'department_id' => $deptId,
        'status' => 1,
    ];
    
    log_message('info', "MENU PLANNER RECREATE: Creating dailyMenuPlannerList entry for date={$newDate}, Department ID={$deptId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
    $newMenuPlannerId = $this->common_model->commonRecordCreate('dailyMenuPlannerList', $saveDMPData);
    
    if (!$newMenuPlannerId) {
        log_message('error', "MENU PLANNER RECREATE FAILED: Failed to create dailyMenuPlannerList entry for date={$newDate}. Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Failed to create daily menu planner entry.']);
        return;
    }
    
    log_message('info', "MENU PLANNER RECREATE: Created dailyMenuPlannerList ID={$newMenuPlannerId} for date={$newDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());

    $serializedOptionMenus = serialize($optionMenus);
    $serializedNoOptionMenus = serialize($noOptionMenus);
    
    $optionMenusCount = is_array($optionMenus) ? count($optionMenus) : 0;
    $noOptionMenusCount = is_array($noOptionMenus) ? count($noOptionMenus) : 0;
    
    log_message('info', "MENU PLANNER RECREATE: Prepared menu data. Option Menus Count={$optionMenusCount}, No Option Menus Count={$noOptionMenusCount}, Original Menu Planner ID={$menuPlannerId}, New Date={$newDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());

    $menuPlannerData = [
        'department_id' => $deptId,
        'menuWithOptions' => $serializedOptionMenus,
        'menuWithoutOptions' => $serializedNoOptionMenus,
        'status' => 1,
        'dailyMenuPlannerId' => $newMenuPlannerId,
        'date' => $newDate,
    ];
    
    // 🔒 COMPREHENSIVE LOGGING: Log RECREATE data before insert
    log_message('info', "MENU PLANNER RECREATE DATA: Original Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, Original Status={$existingData['status']}, New Date={$newDate}, New Status=1 (SAVED), New Department ID={$deptId}, Option Menus Count={$optionMenusCount}, No Option Menus Count={$noOptionMenusCount}, Daily Menu Planner ID={$newMenuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());

    // ✅ SIMPLIFIED: No need to check for deleted menus - we use hard delete now
    // If menu was deleted, it's already gone from database
    
    // Insert the recreated menu planner with duplicate protection
    try {
        log_message('info', "MENU PLANNER RECREATE: Attempting to insert new menu planner. New Date={$newDate}, Daily Menu Planner ID={$newMenuPlannerId}, Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        
        $result = $this->common_model->commonRecordCreate('menuPlanner', $menuPlannerData);
        $newRecordId = $this->tenantDb->insert_id();
        
        // 🔒 COMPREHENSIVE LOGGING: Log RECREATE success with all details
        if ($result && $newRecordId) {
            log_message('info', "MENU PLANNER RECREATE SUCCESS: New Record ID={$newRecordId}, Original Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, Original Status={$existingData['status']}, New Date={$newDate}, New Status=1 (SAVED), New Department ID={$deptId}, Daily Menu Planner ID={$newMenuPlannerId}, Option Menus Count={$optionMenusCount}, No Option Menus Count={$noOptionMenusCount}, Insert ID={$newRecordId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
            echo json_encode(['status' => 'success', 'message' => 'Menu planner recreated successfully.', 'menuPlannerId' => $newMenuPlannerId]);
        } else {
            log_message('error', "MENU PLANNER RECREATE FAILED: Database insert returned false or no insert_id for date={$newDate}. Result=" . ($result ? 'TRUE' : 'FALSE') . ", Insert ID=" . ($newRecordId ?: 'NONE') . ", Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'Failed to recreate menu planner.']);
        }
    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
        log_message('error', "MENU PLANNER RECREATE EXCEPTION: {$errorMsg} for date={$newDate}. Original Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, Stack trace: " . $e->getTraceAsString() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        
        if(strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false) {
            log_message('warning', "MENU PLANNER RECREATE DUPLICATE: Menu planner already exists for date={$newDate}. Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            echo json_encode(['status' => 'error', 'message' => 'A menu planner already exists for this date.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to recreate menu planner: ' . $errorMsg]);
        }
    }
}

public function getExistingMenuDates() {
    // Check authentication
    if (!$this->ion_auth->logged_in()) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please login again.']);
        return;
    }

    $dates = $this->input->post('dates'); // Array of dates to check
    
    if (empty($dates) || !is_array($dates)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        return;
    }

    $existingDates = [];
    
    foreach ($dates as $dateStr) {
        // CRITICAL FIX: Use Australia/Sydney timezone for date parsing to prevent timezone conversion issues
        $checkDate = $this->getAustraliaDate($dateStr);
        
        // Check if ANY menu planner exists for this date (both saved and published)
        $deptId = 0; // For "All Floors" approach
        $conditions = ['date' => $checkDate, 'department_id' => $deptId, 'status !=' => 0];
        $existingData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
        
        if (!empty($existingData)) {
            $existingDates[] = $dateStr;
        }
    }

    echo json_encode([
        'status' => 'success', 
        'existingDates' => $existingDates,
        'hasConflicts' => !empty($existingDates)
    ]);
}

public function recreateMenuPlannerMultiple() {
    // ═══════════════════════════════════════════════════════════════════════
    // COMPREHENSIVE LOGGING for Menu Planner Multiple Recreate Operations
    // ═══════════════════════════════════════════════════════════════════════
    
    log_message('info', "MENU PLANNER RECREATE MULTIPLE INITIATED: User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
    
    // Check authentication
    if (!$this->ion_auth->logged_in()) {
        log_message('warning', "MENU PLANNER RECREATE MULTIPLE BLOCKED: Unauthenticated request from IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please login again.']);
        return;
    }
    
    // SECURITY: Nurses cannot recreate menu planners
    if($this->role_id == 3) {
        log_message('warning', "MENU PLANNER RECREATE MULTIPLE BLOCKED: Nurse attempted recreate. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to recreate menu planners.']);
        return;
    }

    $menuPlannerId = $this->input->post('menuPlannerId');
    $dates = $this->input->post('dates'); // Array of dates
    $skipExistingDates = $this->input->post('skipExistingDates') === 'true';

    // Validate input
    if (empty($menuPlannerId) || empty($dates) || !is_array($dates)) {
        log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Invalid input. Menu Planner ID=" . ($menuPlannerId ?: 'EMPTY') . ", Dates=" . (is_array($dates) ? count($dates) : 'NOT_ARRAY') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        return;
    }
    
    log_message('info', "MENU PLANNER RECREATE MULTIPLE: Original Menu Planner ID={$menuPlannerId}, Dates Count=" . count($dates) . ", Skip Existing=" . ($skipExistingDates ? 'YES' : 'NO') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());

    // Fetch existing menu planner data
    $conditions = ['id' => $menuPlannerId, 'status !=' => 0];
    $existingMenuPlanner = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);

    if (empty($existingMenuPlanner)) {
        log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Original Menu Planner ID={$menuPlannerId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu planner not found.']);
        return;
    }
    
    $originalDate = $existingMenuPlanner[0]['date'];
    log_message('info', "MENU PLANNER RECREATE MULTIPLE: Found original menu planner. Original Date={$originalDate}, Original Status={$existingMenuPlanner[0]['status']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());

    $existingData = $existingMenuPlanner[0];
    
    // Prepare data for recreation
    $deptId = $existingData['department_id'];
    
    // 🔒 CRITICAL FIX: Handle unserialize errors (corrupted data)
    $optionMenus = @unserialize($existingData['menuWithOptions']);
    $noOptionMenus = @unserialize($existingData['menuWithoutOptions']);
    
    if ($optionMenus === false && $existingData['menuWithOptions'] !== 'N;') {
        log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Corrupted menuWithOptions data for Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu data is corrupted. Cannot recreate this menu.']);
        return;
    }
    
    if ($noOptionMenus === false && $existingData['menuWithoutOptions'] !== 'N;') {
        log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Corrupted menuWithoutOptions data for Menu Planner ID={$menuPlannerId}, Original Date={$originalDate}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
        echo json_encode(['status' => 'error', 'message' => 'Menu data is corrupted. Cannot recreate this menu.']);
        return;
    }
    
    // Handle empty serialized data
    if ($optionMenus === false) $optionMenus = [];
    if ($noOptionMenus === false) $noOptionMenus = [];

    $successCount = 0;
    $skippedCount = 0;
    $errorCount = 0;
    $errors = [];

    $today = $this->getAustraliaDate();
    
    foreach ($dates as $dateStr) {
        // CRITICAL FIX: Use Australia/Sydney timezone for date parsing to prevent timezone conversion issues
        $newDate = $this->getAustraliaDate($dateStr);
        
        // Validate date format
        if (!$newDate || $newDate === '1970-01-01') {
            log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Invalid date format: {$dateStr} for Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $errors[] = "Invalid date format: $dateStr";
            $errorCount++;
            continue;
        }
        
        // 🔒 CRITICAL VALIDATION: Recreate only works for future dates (including today)
        // Past dates cannot be recreated - preserve historical records
        if ($newDate < $today) {
            log_message('warning', "MENU PLANNER RECREATE MULTIPLE BLOCKED: Attempted to recreate past date {$newDate} (today={$today}). Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $errors[] = "Cannot recreate menu for past date: " . date('d-m-Y', strtotime($newDate)) . " (today: " . date('d-m-Y', strtotime($today)) . ")";
            $errorCount++;
            continue;
        }

        // Check if menu planner already exists for this date
        $validationResult = $this->validateMenuPlanner([], $newDate);
        
        if (!$validationResult['isValidated']) {
            log_message('info', "MENU PLANNER RECREATE MULTIPLE: Menu planner already exists for date={$newDate}, Skip Existing=" . ($skipExistingDates ? 'YES' : 'NO') . ", Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            if ($skipExistingDates) {
                $skippedCount++;
                continue;
            } else {
                $errors[] = "Menu planner already exists for " . date('d-m-Y', strtotime($newDate));
                $errorCount++;
                continue;
            }
        }

        try {
            // Create new dailyMenuPlannerList entry
            log_message('info', "MENU PLANNER RECREATE MULTIPLE: Creating dailyMenuPlannerList entry for date={$newDate}, Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
            
            $saveDMPData = [
                'date' => $newDate,
                'department_id' => $deptId,
                'status' => 1,
            ];
            $newMenuPlannerId = $this->common_model->commonRecordCreate('dailyMenuPlannerList', $saveDMPData);

            if (!$newMenuPlannerId) {
                log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Failed to create dailyMenuPlannerList entry for date={$newDate}. Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                $errors[] = "Failed to create daily menu planner for " . date('d-m-Y', strtotime($newDate));
                $errorCount++;
                continue;
            }
            
            log_message('info', "MENU PLANNER RECREATE MULTIPLE: Created dailyMenuPlannerList ID={$newMenuPlannerId} for date={$newDate}, Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());

            // Prepare menu planner data
            $menuPlannerData = [
                'department_id' => $deptId,
                'menuWithOptions' => serialize($optionMenus),
                'menuWithoutOptions' => serialize($noOptionMenus),
                'status' => 1, // Always save as draft initially
                'dailyMenuPlannerId' => $newMenuPlannerId,
                'date' => $newDate,
            ];

            // Insert the recreated menu planner
            // 🔧 FIX: Add duplicate protection here too
            try {
                log_message('info', "MENU PLANNER RECREATE MULTIPLE: Attempting to create menu planner for date={$newDate}, Daily Menu Planner ID={$newMenuPlannerId}, Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                
                $result = $this->common_model->commonRecordCreate('menuPlanner', $menuPlannerData);
                $newRecordId = $this->tenantDb->insert_id();
                
                if ($result && $newRecordId) {
                    log_message('info', "MENU PLANNER RECREATE MULTIPLE SUCCESS: New Record ID={$newRecordId}, Date={$newDate}, Daily Menu Planner ID={$newMenuPlannerId}, Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    $successCount++;
                } else {
                    log_message('error', "MENU PLANNER RECREATE MULTIPLE FAILED: Database insert returned false or no insert_id for date={$newDate}. Result=" . ($result ? 'TRUE' : 'FALSE') . ", Insert ID=" . ($newRecordId ?: 'NONE') . ", Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    $errors[] = "Failed to recreate menu planner for " . date('d-m-Y', strtotime($newDate));
                    $errorCount++;
                }
            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
                log_message('error', "MENU PLANNER RECREATE MULTIPLE EXCEPTION: {$errorMsg} for date={$newDate}. Original Menu Planner ID={$menuPlannerId}, Stack trace: " . $e->getTraceAsString() . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                
                if(strpos($errorMsg, 'Duplicate entry') !== false || strpos($errorMsg, '1062') !== false) {
                    // Duplicate detected - already exists
                    log_message('warning', "MENU PLANNER RECREATE MULTIPLE DUPLICATE: Menu planner already exists for date={$newDate}, skipping. Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                    $skippedCount++;
                } else {
                    $errors[] = "Failed to recreate menu planner for " . date('d-m-Y', strtotime($newDate)) . ": " . $errorMsg;
                    $errorCount++;
                }
            }

        } catch (Exception $e) {
            log_message('error', "MENU PLANNER RECREATE MULTIPLE EXCEPTION: Error processing date={$newDate}. Exception: " . $e->getMessage() . ", Stack trace: " . $e->getTraceAsString() . ", Original Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
            $errors[] = "Error processing " . date('d-m-Y', strtotime($newDate)) . ": " . $e->getMessage();
            $errorCount++;
        }
    }

    // Prepare response message
    $message = '';
    if ($successCount > 0) {
        $message .= "Successfully recreated menu planner for $successCount date(s). ";
    }
    if ($skippedCount > 0) {
        $message .= "Skipped $skippedCount existing date(s). ";
    }
    if ($errorCount > 0) {
        $message .= "Failed to process $errorCount date(s). ";
    }

    // Determine overall status
    if ($successCount > 0 && $errorCount === 0) {
        $status = 'success';
    } else if ($successCount > 0 && $errorCount > 0) {
        $status = 'partial';
        $message .= "Some errors occurred: " . implode(', ', array_slice($errors, 0, 3));
        if (count($errors) > 3) {
            $message .= " and " . (count($errors) - 3) . " more...";
        }
    } else {
        $status = 'error';
        $message = "Failed to recreate menu planner. " . implode(', ', array_slice($errors, 0, 3));
    }

    // CRITICAL: Return ONLY ONE response - no multiple messages
    log_message('info', "MENU PLANNER RECREATE MULTIPLE COMPLETED: Original Menu Planner ID={$menuPlannerId}, Success={$successCount}, Skipped={$skippedCount}, Errors={$errorCount}, Total=" . count($dates) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
    
    echo json_encode([
        'status' => $status,
        'message' => trim($message),
        'details' => [
            'success' => $successCount,
            'skipped' => $skippedCount,
            'errors' => $errorCount,
            'total' => count($dates)
        ]
    ]);
    return; // Explicit return to prevent any further execution
}

    public function viewMenuPlanner($id=''){
       
      
        $data['menuLists'] = $this->fetchPlannedMenuList();
        $conditions['listtype'] = 'category';
        $conditions['is_deleted'] = '0';
        $data['categories']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        // Fetch allergen names for tooltip display
        $conditions2['listtype'] = 'allergen';
        $conditions2['is_deleted'] = 0;
        $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions2);
        
        $commonData = $this->commonData();
        $data['departmentListData'] = $commonData['floorList'];
        
        if($id){
            // First try to find by menuPlanner ID
            $conditionsM = array('id' => $id);    
            $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM);
            
            // If not found, try to find by dailyMenuPlannerId (in case the ID passed is from dailyMenuPlannerList)
            // 🔒 CRITICAL FIX: Add date check to prevent finding wrong records
            // If dailyMenuPlannerId exists for multiple dates, we need to find the most recent one
            if(empty($savedData)) {
                $conditionsM = array('dailyMenuPlannerId' => $id);    
                $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM, 'date DESC', 1);
                // If multiple records exist, log a warning
                if(!empty($savedData) && count($savedData) > 1) {
                    log_message('warning', "MENU PLANNER VIEW: Found multiple records for dailyMenuPlannerId={$id}. Using most recent date={$savedData[0]['date']}. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                }
            }
        }else{
            // 🔒 CRITICAL FIX: Use Australia/Sydney timezone instead of server timezone
            // Using date('Y-m-d') uses server timezone which could be UTC, causing wrong date lookup
            $conditionsM = array('date' => $this->getAustraliaDate());     
            $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM);
        }
        
        $savedMenus = [];
       $selectedDepartments = [];
       if (!empty($savedData)) {
        // Deserialize the saved menu data
        $savedMenuWithoutOptions = unserialize($savedData[0]['menuWithoutOptions']);
        $savedMenuWithOptions = unserialize($savedData[0]['menuWithOptions']);
        $selectedDepartments = $savedData[0]['department_id']; 
        $isPublished = (isset($savedData[0]['status']) && $savedData[0]['status'] == 2 ? true : false);
      }
    //  
      $data['savedMenuWithoutOptions'] = $savedMenuWithoutOptions;
      $data['savedMenuWithOptions'] = $savedMenuWithOptions;
    //   $data['date'] = date('d-m-Y',strtotime($savedData[0]['date']));
      $data['selectedDate'] = $savedData[0]['date'];
      $data['selectedDepartments'] = $selectedDepartments;
      $data['isPublished'] = $isPublished;
    //   echo "<pre>"; print_r($data['savedMenuWithOptions']);  print_r($data['savedMenuWithoutOptions']); exit;
      // Always pass the actual menuPlanner record ID for proper updates
      $data['menuPlannerRecordId'] = $savedData[0]['id']; // This is the actual menuPlanner table ID
      
      if(isset($savedData[0]['dailyMenuPlannerId']) && $savedData[0]['dailyMenuPlannerId'] !=''){
       $data['menuPlannerId'] = $savedData[0]['dailyMenuPlannerId'];
       $data['isWeeklyMenuPlanner'] = false;
      }else if(isset($savedData[0]['weeklyMenuPlannerId']) && $savedData[0]['weeklyMenuPlannerId'] !=''){
       $data['menuPlannerId'] = $savedData[0]['weeklyMenuPlannerId'];   
       $data['isWeeklyMenuPlanner'] = true;
      }else{
       // If neither dailyMenuPlannerId nor weeklyMenuPlannerId exists, use the record ID
       $data['menuPlannerId'] = $savedData[0]['id'];   
       $data['isWeeklyMenuPlanner'] = false;
      }
     
      $this->load->view('general/header');
      $this->load->view('Menuplanner/viewMenuPlanner',$data);
      $this->load->view('general/footer');
   }
   
   public function deleteMenuPlanner(){
      // ═══════════════════════════════════════════════════════════════════════
      // HARD DELETE: Permanently deletes menu planner from database
      // PROTECTION: Checks for active orders before deletion
      // AUDIT LOGGING: Tracks all delete attempts for security
      // ═══════════════════════════════════════════════════════════════════════
      
      $menuPlannerId = $this->input->post('id'); 
      
      // Comprehensive logging for audit trail
      log_message('info', "MENU PLANNER DELETE ATTEMPT: Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      
      // Check if orders exist for this menu planner date
      $this->tenantDb->select('id, date, department_id, status, menuWithOptions, menuWithoutOptions');
      $this->tenantDb->where('id', $menuPlannerId);
      $menuPlanner = $this->tenantDb->get('menuPlanner')->row();
      
      // 🔒 COMPREHENSIVE LOGGING: Log what will be deleted
      if ($menuPlanner) {
          log_message('info', "MENU PLANNER DELETE BEFORE: Record ID={$menuPlannerId}, Date={$menuPlanner->date}, Status={$menuPlanner->status}, Department ID={$menuPlanner->department_id}, Menu Options Length=" . strlen($menuPlanner->menuWithOptions ?? '') . ", Menu Without Options Length=" . strlen($menuPlanner->menuWithoutOptions ?? '') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      }
      
      if ($menuPlanner) {
          // CRITICAL FIX: Only count ACTIVE orders (status != 0), exclude cancelled orders
          // Order status: 0=Cancelled, 1=Pending, 2=Paid, 3=Ready, 4=Delivered
          $this->tenantDb->where('date', $menuPlanner->date);
          $this->tenantDb->where('status !=', 0); // Exclude cancelled orders
          $orderCount = $this->tenantDb->count_all_results('orders');
          
          if ($orderCount > 0) {
              log_message('warning', "MENU PLANNER DELETE BLOCKED: {$orderCount} active order(s) exist for date={$menuPlanner->date}. Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
              echo json_encode([
                  'status' => 'error',
                  'message' => 'Cannot delete this menu! ' . $orderCount . ' active order(s) exist for ' . date('d-m-Y', strtotime($menuPlanner->date)) . '. Please cancel all orders first.'
              ]);
              return;
          }
      } else {
          log_message('error', "MENU PLANNER DELETE FAILED: Menu Planner ID {$menuPlannerId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
          echo json_encode([
              'status' => 'error',
              'message' => 'Menu planner not found.'
          ]);
          return;
      }
      
      // No active orders found, proceed with HARD deletion (permanent delete)
      // ✅ SIMPLIFIED: Hard delete instead of soft delete - cleaner and simpler
      // ✅ PROTECTION: Already checked for active orders above, safe to delete
      try {
          // Hard delete the menu planner record
          $this->tenantDb->where('id', $menuPlannerId);
          $this->tenantDb->delete('menuPlanner');
          
          $affectedRows = $this->tenantDb->affected_rows();
          $dbError = $this->tenantDb->error();
          
          // Check for database errors
          if (!empty($dbError['message'])) {
              log_message('error', "MENU PLANNER DELETE DATABASE ERROR: " . $dbError['message'] . ". Error Code=" . ($dbError['code'] ?? 'N/A') . ", Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
              echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $dbError['message']]);
              return;
          }
          
          if ($affectedRows > 0) {
              // 🔒 COMPREHENSIVE LOGGING: Log DELETE success with details
              log_message('info', "MENU PLANNER DELETE SUCCESS: Menu planner ID={$menuPlannerId} permanently deleted (hard delete). Deleted Date={$menuPlanner->date}, Deleted Status={$menuPlanner->status}, Deleted Department ID={$menuPlanner->department_id}, Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
              echo json_encode(['status' => 'success', 'message' => 'Menu deleted successfully']);
          } else {
              // Check if menu still exists (might have been deleted already)
              $this->tenantDb->where('id', $menuPlannerId);
              $checkMenu = $this->tenantDb->get('menuPlanner')->row();
              
              if (!$checkMenu) {
                  log_message('warning', "MENU PLANNER DELETE: Menu planner ID={$menuPlannerId} not found (may have been deleted already). User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                  echo json_encode(['status' => 'error', 'message' => 'Menu planner not found. It may have been deleted already.']);
              } else {
                  log_message('error', "MENU PLANNER DELETE FAILED: Database delete returned 0 affected rows for ID={$menuPlannerId}. Current menu status={$checkMenu->status}, Date={$checkMenu->date}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                  echo json_encode(['status' => 'error', 'message' => 'Failed to delete menu. No rows were deleted. Please try again or refresh the page.']);
              }
          }
      } catch (Exception $e) {
          log_message('error', "MENU PLANNER DELETE EXCEPTION: " . $e->getMessage() . ". Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Stack trace: " . $e->getTraceAsString() . " at " . australia_datetime());
          echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
      }
   }
   
   function publishMenuPlanner(){
      // ═══════════════════════════════════════════════════════════════════════
      // COMPREHENSIVE LOGGING for Menu Planner Publish Operations
      // ═══════════════════════════════════════════════════════════════════════
      
      log_message('info', "MENU PLANNER PUBLISH INITIATED: User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      
      // 🔒 CRITICAL FIX: Validate input
      $menuPlannerId = $this->input->post('id');
      
      if (empty($menuPlannerId)) {
          log_message('error', "MENU PLANNER PUBLISH FAILED: No menu planner ID provided. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
          echo json_encode(['status' => 'error', 'message' => 'Menu planner ID is required.']);
          return;
      }
      
      log_message('info', "MENU PLANNER PUBLISH: Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      
      // CRITICAL FIX: Check if menu exists
      $conditions = ['id' => $menuPlannerId, 'status !=' => 0];
      $existingMenu = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditions);
      
      if (empty($existingMenu)) {
          log_message('error', "MENU PLANNER PUBLISH FAILED: Menu planner ID={$menuPlannerId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
          echo json_encode(['status' => 'error', 'message' => 'Menu planner not found.']);
          return;
      }
      
      $menuData = $existingMenu[0];
      
      // 🔒 COMPREHENSIVE LOGGING: Log PUBLISH before state
      log_message('info', "MENU PLANNER PUBLISH BEFORE: Record ID={$menuPlannerId}, Date={$menuData['date']}, Current Status={$menuData['status']}, Current Department ID={$menuData['department_id']}, Menu Options Length=" . strlen($menuData['menuWithOptions'] ?? '') . ", Menu Without Options Length=" . strlen($menuData['menuWithoutOptions'] ?? '') . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      
      // CRITICAL FIX: Check if already published
      if ($menuData['status'] == 2) {
          log_message('warning', "MENU PLANNER PUBLISH: Menu planner ID={$menuPlannerId} already published. Date={$menuData['date']}, Current Status={$menuData['status']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
          echo json_encode(['status' => 'warning', 'message' => 'This menu is already published.']);
          return;
      }
      
      // CRITICAL FIX: Check for duplicate published menu for same date
      $this->tenantDb->where('date', $menuData['date']);
      $this->tenantDb->where('department_id', $menuData['department_id']);
      $this->tenantDb->where('status', 2);
      $this->tenantDb->where('id !=', $menuPlannerId);
      $duplicatePublished = $this->tenantDb->get('menuPlanner')->row();
      
      if ($duplicatePublished) {
          log_message('warning', "MENU PLANNER PUBLISH BLOCKED: Duplicate published menu exists ID={$duplicatePublished->id} for date={$menuData['date']}. Menu Planner ID={$menuPlannerId}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
          echo json_encode(['status' => 'error', 'message' => 'A published menu already exists for this date. Please delete it first.']);
          return;
      }
      
      // 🔒 CRITICAL: Date field is IMMUTABLE - only update status, never the date!
      $menuPlannerData = ['status' => 2];  // Only status field - date field is NEVER updated!
      
      // 🔒 COMPREHENSIVE LOGGING: Log PUBLISH data
      log_message('info', "MENU PLANNER PUBLISH DATA: Record ID={$menuPlannerId}, Date={$menuData['date']} (IMMUTABLE - preserved), STATUS CHANGE: {$menuData['status']} -> 2 (PUBLISHED), Update Fields=" . json_encode(array_keys($menuPlannerData)) . ", User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
      
      // 🔒 CRITICAL FIX: Use direct database update to check affected rows
      // CRITICAL: $menuPlannerData only contains 'status' - date field is IMMUTABLE and never updated!
      try {
          $this->tenantDb->where('id', $menuPlannerId);
          $this->tenantDb->update('menuPlanner', $menuPlannerData);
          
          $affectedRows = $this->tenantDb->affected_rows();
          $dbError = $this->tenantDb->error();
          
          // 🔒 COMPREHENSIVE LOGGING: Log PUBLISH after state
          if ($affectedRows > 0) {
              $this->tenantDb->where('id', $menuPlannerId);
              $publishedRecord = $this->tenantDb->get('menuPlanner')->row();
              if ($publishedRecord) {
                  log_message('info', "MENU PLANNER PUBLISH AFTER: Record ID={$menuPlannerId}, Date={$publishedRecord->date}, New Status={$publishedRecord->status}, Status Changed=" . ($menuData['status'] != $publishedRecord->status ? 'YES (' . $menuData['status'] . ' -> ' . $publishedRecord->status . ')' : 'NO') . ", Affected Rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
              }
          }
          
          // Check for database errors
          if (!empty($dbError['message'])) {
              log_message('error', "MENU PLANNER PUBLISH DATABASE ERROR: " . $dbError['message'] . ". Error Code=" . ($dbError['code'] ?? 'N/A') . ", Menu Planner ID={$menuPlannerId}, Date={$menuData['date']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
              
              // Check if it's a constraint violation
              if (strpos($dbError['message'], 'Duplicate entry') !== false || strpos($dbError['message'], 'unique_date_dept_active') !== false) {
                  log_message('error', "MENU PLANNER PUBLISH CONSTRAINT ERROR: Unique constraint still exists! Please run REMOVE_CONSTRAINT_SQL.sql. Menu Planner ID={$menuPlannerId}, Date={$menuData['date']} at " . australia_datetime());
                  echo json_encode(['status' => 'error', 'message' => 'Database constraint error. Please contact administrator to remove the unique constraint.']);
              } else {
                  echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $dbError['message']]);
              }
              return;
          }
          
          if ($affectedRows > 0) {
              // Log already added above in the comprehensive logging section
              log_message('info', "MENU PLANNER PUBLISH SUCCESS: Menu planner ID={$menuPlannerId} status set to 2 (PUBLISHED). Date={$menuData['date']}, Status Changed from {$menuData['status']} to 2, Affected rows={$affectedRows}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", Timestamp=" . australia_datetime());
              // $email_content = $this->load->view('Email/menuplanner',$data,TRUE);
              // $mailResult = $this->sendEmail($mailto,'Menuplanner Published', $email_content,$from='info@bizadmin.com.au','','Bizorder');
              
              echo json_encode(['status' => 'success', 'message' => 'Menu published successfully!']);
          } else {
              // Check if menu still exists
              $this->tenantDb->where('id', $menuPlannerId);
              $checkMenu = $this->tenantDb->get('menuPlanner')->row();
              
              if (!$checkMenu) {
                  log_message('error', "MENU PLANNER PUBLISH FAILED: Menu planner ID={$menuPlannerId} not found. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
                  echo json_encode(['status' => 'error', 'message' => 'Menu planner not found.']);
              } else {
                  log_message('warning', "MENU PLANNER PUBLISH: No rows affected for ID={$menuPlannerId} (may already be published). Date={$menuData['date']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . " at " . australia_datetime());
                  echo json_encode(['status' => 'warning', 'message' => 'Menu may already be published.']);
              }
          }
      } catch (Exception $e) {
          log_message('error', "MENU PLANNER PUBLISH EXCEPTION: " . $e->getMessage() . ". Menu Planner ID={$menuPlannerId}, Date={$menuData['date']}, User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", User ID=" . ($this->session->userdata('user_id') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
          echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
      }
   }
   
   
//   WEEKLY MENU PLANNER ===========================================================================

   /**
    * ⚠️ DISABLED: Weekly Menu Planner Create Function
    * 
    * This function has been DISABLED to prevent use of weekly menu planner feature.
    * Weekly menu planner was causing automatic updates of existing daily menu planners.
    * 
    * Users should use daily menu planner functions instead.
    */
   public function createWeeklyPlanner(){
       // 🔒 DISABLED: Weekly menu planner is disabled
       log_message('error', "WEEKLY MENU CREATE BLOCKED: Weekly menu planner function is DISABLED. User attempted to access it. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
       redirect('Orderportal/Menuplanner/list');
       return;
       
       // NOTE: Original code removed to prevent accidental execution
       // If you need to re-enable, see git history for the original implementation
   }
   
   /**
    * ⚠️ DISABLED: Weekly Menu Planner Save Function
    * 
    * This function has been DISABLED to prevent automatic updates of existing daily menu planners.
    * It was the ONLY function that automatically updated existing records, which could cause date corruption.
    * 
    * Users should use daily menu planner functions instead:
    * - saveMenuPlanner() - Save/update individual daily menu planners
    * - recreateMenuPlanner() - Recreate menu planners for specific dates
    * 
    * If you need to re-enable this, uncomment the code below and ensure date immutability is maintained.
    */
   public function saveWeeklyMenu(){
       // 🔒 DISABLED: Weekly menu planner is disabled to prevent automatic updates
       log_message('error', "WEEKLY MENU SAVE BLOCKED: Weekly menu planner function is DISABLED. User attempted to use it. User=" . ($this->session->userdata('username') ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . " at " . australia_datetime());
       echo json_encode(['status' => 'error', 'message' => 'Weekly menu planner is disabled. Please use daily menu planner instead.']);
       return;
       
       // NOTE: Original code removed to prevent accidental execution
       // If you need to re-enable, see git history for the original implementation
       // Original code was at lines 1350-1454 before being disabled
   }

   function viewWeeklyMenuPlanner($id){
       
       $conditions['listtype'] = 'department';
       $data['departmentListData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
       
       
        $groupedMenus = $this->fetchPlannedMenuList();
        $data['menuLists'] = $groupedMenus;
        $data['weeklyMenuPlannerId'] = $id;
        
        $conditionsM = array('id' => $id);     
        $weeklyMenuPlannerId = $this->common_model->fetchRecordsDynamically('weeklyMenuPlannerList','',$conditionsM);
        
        if(isset($weeklyMenuPlannerId) && !empty($weeklyMenuPlannerId)){
         $conditionsWMP = array('weeklyMenuPlannerId' => $weeklyMenuPlannerId[0]['id']);     
         $data['savedData'] = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsWMP);   
         $data['start_date'] = $weeklyMenuPlannerId[0]['start_date'];
         $data['end_date'] = $weeklyMenuPlannerId[0]['end_date'];
         }
       
        // echo "<pre>"; print_r($data['start_date']); exit;
         $this->load->view('general/landingPageHeader');
      $this->load->view('Menuplanner/viewWeeklyMenuPlanner',$data);
      $this->load->view('general/landingPageFooter');
   }
   
   /**
    * AUTO-GENERATE & AUTO-PUBLISH: Automatically create and publish menus for upcoming dates
    * 
    * ⚠️ DISABLED: This method has been completely disabled per user request.
    * Automatic menu generation was causing issues and has been removed.
    * 
    * If you need to re-enable this functionality, uncomment the method call in list() function
    * and uncomment this entire method below.
    */
   /*
   private function autoPublishUpcomingMenus() {
       // ═══════════════════════════════════════════════════════════════════════
       // SAFE AUTO-PUBLISH with Enhanced Logging & Protection
       // Business Need: Auto-generate menus for upcoming dates
       // Safety: Only affects OLD saved drafts (>24 hours) + Duplicate prevention
       // ═══════════════════════════════════════════════════════════════════════
       
       // Only check for non-nurse roles (nurses can't publish)
       if($this->role_id == 3) {
           return;
       }
       
       // CRITICAL FIX: Use Australia/Sydney timezone for date operations
       $today = $this->getAustraliaDate();
       $fourDaysFromNow = $this->getAustraliaDateOffset(4);
       
       $createdCount = 0;
       $publishedCount = 0;
       $skippedFreshDrafts = 0;
       
       log_message('info', "🔄 AUTO-PUBLISH STARTED: Checking dates {$today} to {$fourDaysFromNow}");
       
       // Check each date from today to +4 days
       for ($i = 0; $i <= 4; $i++) {
           $checkDate = $this->getAustraliaDateOffset($i);
           
           // 🔒 CRITICAL: Use FOR UPDATE to prevent race conditions
           $this->tenantDb->where('date', $checkDate);
           $this->tenantDb->where('department_id', 0); // All Floors
           $this->tenantDb->where_in('status', [1, 2]); // Saved or Published (not deleted)
           $existingMenu = $this->tenantDb->get('menuPlanner')->row_array();
           
           if (empty($existingMenu)) {
               // No active menu exists - CREATE ONE
               log_message('info', "   📅 Date {$checkDate}: No menu found, attempting auto-generate");
               
               // 🔒 SAFETY: Double-check no menu exists (race condition protection)
               $this->tenantDb->where('date', $checkDate);
               $this->tenantDb->where('department_id', 0);
               $this->tenantDb->where('status !=', 0);
               $doubleCheck = $this->tenantDb->get('menuPlanner')->row_array();
               
               if (!empty($doubleCheck)) {
                   log_message('warning', "   ⚠️ RACE CONDITION PREVENTED: Menu appeared for {$checkDate} - Skipping");
                   continue;
               }
               
               // Try to copy from 7 days ago (same day of previous week)
               // CRITICAL FIX: Use Australia/Sydney timezone for date operations
               $timezone = new DateTimeZone('Australia/Sydney');
               $copyFromDateObj = DateTime::createFromFormat('Y-m-d', $checkDate, $timezone);
               $copyFromDateObj->modify('-7 days');
               $copyFromDate = $copyFromDateObj->format('Y-m-d');
               
               $this->tenantDb->where('date', $copyFromDate);
               $this->tenantDb->where('department_id', 0);
               $this->tenantDb->where('status', 2); // Only copy from published menus
               $templateMenu = $this->tenantDb->get('menuPlanner')->row_array();
               
               // Prepare menu data - but ONLY if template has actual menu items
               if (!empty($templateMenu)) {
                   // Check if template has actual menu items (not empty)
                   $menuWithOptions = @unserialize($templateMenu['menuWithOptions']);
                   $menuWithoutOptions = @unserialize($templateMenu['menuWithoutOptions']);
                   
                   $hasMenuItems = false;
                   
                   // Check if there are any menu items
                   if (is_array($menuWithOptions) && !empty($menuWithOptions)) {
                       foreach ($menuWithOptions as $category => $menus) {
                           if (is_array($menus) && count($menus) > 0) {
                               $hasMenuItems = true;
                               break;
                           }
                       }
                   }
                   
                   if (!$hasMenuItems && is_array($menuWithoutOptions) && !empty($menuWithoutOptions)) {
                       foreach ($menuWithoutOptions as $category => $menus) {
                           if (is_array($menus) && count($menus) > 0) {
                               $hasMenuItems = true;
                               break;
                           }
                       }
                   }
                   
                   if ($hasMenuItems) {
                       // Template has menu items - copy it
                       $menuData = [
                           'date' => $checkDate,
                           'department_id' => 0,
                           'menuWithOptions' => $templateMenu['menuWithOptions'],
                           'menuWithoutOptions' => $templateMenu['menuWithoutOptions'],
                           'status' => 2, // Auto-publish immediately
                       ];
                       
                       // 🔒 SAFETY: Use TRY-CATCH to handle duplicate key errors gracefully
                       try {
                           $newMenuId = $this->common_model->commonRecordCreate('menuPlanner', $menuData);
                           
                           if ($newMenuId) {
                               $createdCount++;
                               log_message('info', "AUTO-CREATE MENU SUCCESS: Auto-created Menu ID={$newMenuId} for Date={$checkDate} from template Date={$copyFromDate}, Timestamp=" . australia_datetime());
                           }
                       } catch (Exception $e) {
                           $errorMsg = $e->getMessage();
                           if(strpos($errorMsg, 'Duplicate entry') !== false) {
                               log_message('warning', "AUTO-CREATE MENU DUPLICATE PREVENTED: Menu for Date={$checkDate} already exists (race condition), Timestamp=" . australia_datetime());
                           } else {
                               log_message('error', "AUTO-CREATE MENU FAILED: Failed to create menu for Date={$checkDate}, Error={$errorMsg}, Timestamp=" . australia_datetime());
                           }
                       }
                   } else {
                       // Template exists but has no menu items - skip
                       log_message('info', "⚠️ SKIPPED AUTO-GENERATE for {$checkDate}: Template from {$copyFromDate} has no menu items");
                   }
               } else {
                   // No template found - skip (don't create empty menus)
                   log_message('info', "⚠️ SKIPPED AUTO-GENERATE for {$checkDate}: No template found from {$copyFromDate}");
               }
               
           } elseif ($existingMenu['status'] == 1) {
               // ═══════════════════════════════════════════════════════════════════════
               // 🔒 CRITICAL SAFETY: Only auto-publish OLD saved drafts (>24 hours)
               // This prevents auto-publishing freshly saved drafts that users are working on
               // ═══════════════════════════════════════════════════════════════════════
               
               log_message('info', "   📋 Date {$checkDate}: Found SAVED menu (ID: {$existingMenu['id']})");
               
               // Check if menu has a created_date or modified_date column
               // If not, check if the date is in the past (safe to auto-publish)
               $canAutoPublish = false;
               $reason = '';
               
               // Strategy 1: If menu date is in the past, safe to auto-publish
               if (strtotime($checkDate) < strtotime($today)) {
                   $canAutoPublish = true;
                   $reason = "Date is in the past ({$checkDate} < {$today})";
               }
               // Strategy 2: If menu date is 4+ days in future, likely a template, safe to auto-publish
               elseif ($i >= 4) {
                   $canAutoPublish = true;
                   $reason = "Date is 4+ days in future";
               }
               // Strategy 3: For near-future dates (0-3 days), DON'T auto-publish to avoid conflicts
               else {
                   $canAutoPublish = false;
                   $reason = "Date is within 3 days - may be actively edited";
                   $skippedFreshDrafts++;
                   log_message('info', "   ⏸️ SKIPPED AUTO-PUBLISH for {$checkDate}: {$reason}");
               }
               
               if ($canAutoPublish) {
                   $this->tenantDb->where('id', $existingMenu['id']);
                   $updateResult = $this->tenantDb->update('menuPlanner', ['status' => 2]);
                   
                   if ($updateResult) {
                       $publishedCount++;
                       log_message('info', "AUTO-PUBLISH MENU SUCCESS: Auto-published Menu ID={$existingMenu['id']} for Date={$checkDate}, Reason={$reason}, Timestamp=" . australia_datetime());
                   } else {
                       log_message('error', "AUTO-PUBLISH MENU FAILED: Failed to publish Menu ID={$existingMenu['id']} for Date={$checkDate}, Timestamp=" . australia_datetime());
                   }
               }
           } else {
               // Status = 2 (already published), do nothing
               log_message('debug', "   ✓ Date {$checkDate}: Already published (ID: {$existingMenu['id']})");
           }
       }
       
       // Log summary
       log_message('info', "🔄 AUTO-PUBLISH COMPLETED: Created={$createdCount}, Published={$publishedCount}, Skipped={$skippedFreshDrafts}");
       
       // Set flash message
       if ($createdCount > 0 || $publishedCount > 0) {
           $message = '';
           if ($createdCount > 0) {
               $message .= $createdCount . ' menu(s) were automatically created and published';
           }
           if ($publishedCount > 0) {
               if ($message) $message .= ', and ';
               $message .= $publishedCount . ' menu(s) were automatically published';
           }
           $message .= ' for upcoming dates (within 4 days)';
           
           if ($skippedFreshDrafts > 0) {
               $message .= ". {$skippedFreshDrafts} recent draft(s) were preserved for editing.";
           }
           
           $this->session->set_flashdata('auto_publish_message', $message);
       }
   }
   */
	
}
	?>