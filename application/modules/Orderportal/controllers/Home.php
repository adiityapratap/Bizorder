<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    function __construct() {
		parent::__construct();
	    $this->load->model('configfoodmenu_model');
	    $this->selected_location_id = $this->session->userdata('location_id');
	   !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
	    $this->load->model('menu_model');
	    $this->load->model('general_model');
	    $this->load->model('common_model');
	    $this->load->model('order_model');
	    $this->load->model('floor_order_model'); // Load floor order model
	    $this->load->helper('custom'); // Load custom helper for Australia timezone functions
	   
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
	
	public function index()
    {   
          
          
        $emailSettings = $this->general_model->fetchSmtpSettings('9999','9999');
        $this->configureSMTP($emailSettings);
          
        // 
        if($this->ion_auth->get_users_groups()->row()->id == 1){
// 			$this->load->view('Dashboard/dashboardAdmin',$data);
          // dashboardd for admin and chef are same
          $this->dashboardChef();
		}else if($this->ion_auth->get_users_groups()->row()->id == 2){
		    $this->dashboardChef();
		}else if($this->ion_auth->get_users_groups()->row()->id == 3){
		    $this->dashboardNurse();
			
		}else if($this->ion_auth->get_users_groups()->row()->id == 6){
		    // pass true to load reception screen*(where all patent can place order) rather than nurse portal
		    $this->dashboardNurse(true);
			
		}else if($this->ion_auth->get_users_groups()->row()->id == 4){
		    // Patient portal - use same interface as reception for now
		    $this->dashboardNurse(true);
		}else if($this->ion_auth->get_users_groups()->row()->id == 7){
		    // Staff role (ID 7) - restricted access to Production Form and Today's Labels only
		    $this->dashboardStaff();
		}
		
        

    }
    
    public function dashboardChef(){
        
        $currentHour = date('H'); // Get current hour (24-hour format)
         $data['greeting'] = ($currentHour >= 5 && $currentHour < 12) ? 'Good Morning' : (($currentHour >= 12 && $currentHour < 18) ? 'Good Afternoon' : 'Good Evening');
         
         // CRITICAL FIX: Use Australia/Sydney timezone for date operations
         $conditionsM = array('date' => $this->getAustraliaTomorrow(),'department_id !=' => 0 ,'status' => 1);
         $departmentWiseMenuplanner = $this->common_model->fetchRecordsDynamically('menuPlanner', ['department_id'], $conditionsM);
         $data['departmentWiseMenuplanner'] = $departmentWiseMenuplanner;
         
        $conditions = array('is_deleted' => 0 ,'listtype' => 'floor');
        $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        // Calculate actual delivery status for each floor using existing method
        $departmentListWithStatus = [];
        foreach ($departmentListData as $department) {
            $deptStatus = $this->calculateFloorDeliveryStatus($department['id']);
            $department['delivery_status'] = $deptStatus['status'];
            $department['delivery_details'] = $deptStatus['details'];
            $departmentListWithStatus[] = $department;
        }
        
        $data['departmentListData'] = $departmentListWithStatus;
        
        
        $conditions['listtype'] = 'category';
        $conditions['is_deleted'] = '0';
        $data['categories']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $data['menuLists']    = $this->menu_model->fetchMenuDetails('',true);
        
        // Fetch allergens and cuisine types for icons
        $conditionsAllergen = array('listtype' => 'allergen', 'is_deleted' => '0');
        $data['allergensData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsAllergen);
        
        $conditionsCuisine = array('listtype' => 'cuisine', 'is_deleted' => '0');
        $data['cuisineData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditionsCuisine);

        
        //  Find current Monday and Sunday
       $monday = date('Y-m-d', strtotime('monday this week'));
       $sunday = date('Y-m-d', strtotime('sunday this week'));

      // Create an array of all dates from Monday to Sunday
      $dateRange = [];
      $menuPlannerForWholeWeek = [];
      $current = strtotime($monday);
      $end = strtotime($sunday);

      while ($current <= $end) {
       $dateRange[] = date('Y-m-d', $current);
       $current = strtotime("+1 day", $current);
      }

     // Iterate over each date
     foreach ($dateRange as $date) {
        // For "All Floors" approach, always use department_id = 0
        $departmentId = 0;
        
        // Priority: Published (status=2) first, then Saved (status=1)
        $conditionsM = array(
            'date' => $date,
            'department_id' => $departmentId,
            'status' => 2
        );
        
        $savedData = array();
        $savedMenuWithOptions = array();
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);
   
        // If no published menu found, try saved menus (status = 1)
        if (empty($savedData)) {
            $conditionsM = array(
                'date' => $date,
                'department_id' => $departmentId,
                'status' => 1
            );
            $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);
        }
        
        // If we found multiple records, take the first one
        if (!empty($savedData)) {
            $savedData = array($savedData[0]); // Take first record
        }
   
     if (!empty($savedData)) {
        // Check if this is weekly menu data (stored in menuData field) or daily menu data (menuWithOptions field)
        if (!empty($savedData[0]['menuWithOptions'])) {
            // Daily menu planner data
            $savedMenuWithOptions = unserialize($savedData[0]['menuWithOptions']);
        } elseif (!empty($savedData[0]['menuData'])) {
            // Weekly menu planner data - transform to expected format
            $weeklyMenuData = unserialize($savedData[0]['menuData']);
            $savedMenuWithOptions = $this->transformWeeklyMenuData($weeklyMenuData);
        }
        $selectedDepartments = $savedData[0]['department_id']; 
      }
     // dont include menu without options as we will always have menu with options
     
      
    $menuPlannerForWholeWeek[$date] = $savedMenuWithOptions;
    
   }
   // Debug code removed - dashboard should now work properly

         $data['savedMenuWithOptions'] = $menuPlannerForWholeWeek;  
   
        $data['currentWeekdateRange'] = $dateRange;  
        $data['selectedDepartments'] = $selectedDepartments;
      
        // FIXED: Chef should see orders placed FOR today (which were placed yesterday)
        // Since orders are stored with delivery date, we look for today's date
        $conditionsO = array('date' => date('Y-m-d'),'buttonType' => 'sendorder');
        $data['todaysOrder'] = $this->common_model->fetchRecordsDynamically('orders','',$conditionsO);
        
        // echo "<pre>"; print_r($data['todaysOrder']); exit;
      
        
        $this->load->view('general/header');
        $this->load->view('Dashboard/dashboardChef',$data);
        $this->load->view('general/footer');
       
    }
    
    /**
     * Transform weekly menu data format to dashboard expected format
     * Weekly format: [menu_id1, menu_id2, ...]
     * Dashboard format: [category_id => [menu_id => [option_id1, option_id2, ...]]]
     */
    private function transformWeeklyMenuData($weeklyMenuData) {
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
    
    public function dashboardNurse($isReception=false){
        
        $conditions = array('is_deleted' => 0);
        $data['menuLists']    = $this->menu_model->fetchMenuDetails('',true);

        $conditions = array('is_deleted' => 0,'floor'=>$this->session->userdata('department_id'));
       $allSuites = $this->common_model->fetchRecordsDynamically('suites','',$conditions);
       
       // Filter out problematic suites - ONLY include suites with valid bed_no
       $data['bedLists'] = [];
       if (!empty($allSuites)) {
           foreach ($allSuites as $suite) {
               // STRICT: Only include suites that have a valid bed_no (no more "Suite-Unknown" cards)
               if (isset($suite['bed_no']) && trim($suite['bed_no']) !== '' && !empty($suite['bed_no'])) {
                   $data['bedLists'][] = $suite;
               }
           }
       }
       
       // AUTO-CLEANUP: Mark discharged patients as inactive (runs on every dashboard load)
       // This prevents stale records from causing vacant suites to appear occupied
       $this->autoMarkDischargedPatientsInactive();
       
       // Fetch patient information for each suite
       $patientData = [];
       if (!empty($data['bedLists'])) {
           foreach ($data['bedLists'] as &$suite) {
               // Get active patient for this suite
               $patientConditions = [
                   'suite_number' => $suite['id'],
                   'status' => 1 // Active patients only
               ];
               $patients = $this->common_model->fetchRecordsDynamically('people', ['name', 'allergies', 'dietary_preferences', 'special_instructions', 'date_onboarded', 'date_of_discharge'], $patientConditions);
               
            // Filter out patients with past discharge dates
            $activePatient = null;
            $today = date('Y-m-d');
            if (!empty($patients)) {
                foreach ($patients as $patient) {
                    $discharge_date = $patient['date_of_discharge'];
                    // FIXED: Keep patients active only if discharge date is in the FUTURE (not today)
                    // On discharge day, suite should not be shown as occupied for new orders
                    if (empty($discharge_date) || $discharge_date > $today) {
                        $activePatient = $patient;
                        break;
                    } else {
                        // LOG: Stale patient record found - should be marked inactive
                        log_message('warning', "Stale patient record: Suite {$suite['bed_no']} (ID: {$suite['id']}) has patient with past discharge date: {$discharge_date}. Patient status should be updated to inactive.");
                    }
                }
            }
            
            // LOG: If no active patient found but patients exist, log it
            if (empty($activePatient) && !empty($patients)) {
                log_message('info', "Suite {$suite['bed_no']} (ID: {$suite['id']}) has {". count($patients) ."} patient record(s) but all have past discharge dates. This may cause vacant suites to appear occupied.");
            }
               
               // Add patient info to suite data
               $suite['patient_name'] = $activePatient ? $activePatient['name'] : null;
               $suite['patient_allergies'] = $activePatient ? $activePatient['allergies'] : null;
               $suite['patient_dietary_preferences'] = $activePatient ? ($activePatient['dietary_preferences'] ?? null) : null;
               $suite['patient_instructions'] = $activePatient ? $activePatient['special_instructions'] : null;
               $suite['patient_onboarded'] = $activePatient ? $activePatient['date_onboarded'] : null;
               $suite['patient_discharge'] = $activePatient ? $activePatient['date_of_discharge'] : null;
               
               // 🆕 SPECIAL ITEMS FEATURE: Count patient allergies
               $allergyCount = 0;
               if ($activePatient && !empty($activePatient['allergies'])) {
                   // Allergies are stored as comma-separated IDs or JSON array
                   $allergiesData = $activePatient['allergies'];
                   
                   // Try to parse as JSON first
                   $allergyArray = json_decode($allergiesData, true);
                   if (json_last_error() === JSON_ERROR_NONE && is_array($allergyArray)) {
                       $allergyCount = count($allergyArray);
                   } else {
                       // Fallback: count comma-separated values
                       $allergyArray = explode(',', $allergiesData);
                       $allergyArray = array_filter(array_map('trim', $allergyArray)); // Remove empty values
                       $allergyCount = count($allergyArray);
                   }
               }
               
               $suite['allergy_count'] = $allergyCount;
               $suite['has_high_allergies'] = $allergyCount >= 2; // Flag for 3+ allergies
           }
           unset($suite); // CRITICAL: Unset reference to prevent accidental modification
       }
      

       // We'll sort the suites later after we have order data
       // Initial sort by bed number only
       usort($data['bedLists'], function($a, $b) {
        return $a['bed_no'] <=> $b['bed_no'];
       });

        
        $conditionsC = array('is_deleted' => 0 ,'listtype' => 'category');
        $data['categoryListData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditionsC);
        
        // UPDATED: Load tomorrow's menu by default
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        // ✅ MENU IS ALWAYS COMMON FOR ALL: department_id = 0 is the common menu for all departments
        $tomorrowDate = $this->getAustraliaTomorrow();
        $conditionsM = array('date' => $tomorrowDate,'status' => 2,'department_id'=> 0);
        
        $savedData = $this->common_model->fetchRecordsDynamically('menuPlanner','',$conditionsM);
       
        $result = $this->menu_model->fetchMenuDetails('',true);
        $data['menuLists'] = $result;
       

        $selectedDepartments = [];
        $isPublished = false;
     
       if (!empty($savedData)) {
        // Deserialize the saved menu data
        $savedMenuWithoutOptions = unserialize($savedData[0]['menuWithoutOptions']);
        $savedMenuWithOptions = unserialize($savedData[0]['menuWithOptions']);
        $selectedDepartments = $savedData[0]['department_id']; 
      } else {
        // If no menu planner exists, create default structure with all available menus
        $savedMenuWithoutOptions = [];
        $savedMenuWithOptions = [];
        
        // For reception, show all available menus organized by category
        if($isReception) {
            foreach($data['categoryListData'] as $category) {
                $categoryMenus = array_filter($data['menuLists'], function($menu) use ($category) {
                    return in_array($category['id'], $menu['category_ids']);
                });
                
                foreach($categoryMenus as $menu) {
                    if(!empty($menu['menu_options'])) {
                        // Menu with options - add all options
                        $optionIds = array_column($menu['menu_options'], 'option_id');
                        $savedMenuWithOptions[$category['id']][$menu['menu_id']] = $optionIds;
                    } else {
                        // Menu without options
                        $savedMenuWithoutOptions[$category['id']][] = $menu['menu_id'];
                    }
                }
            }
        }
      }
    //  99 percent of time we will have menu with options, for case menu without options we can still menu itslef as menu options
      $data['savedMenuWithoutOptions'] = $savedMenuWithoutOptions; // menuplanner planned by chef for menu without options
      $data['savedMenuWithOptions'] = $savedMenuWithOptions;  // menuplanner planned by chef for menu with options
      $data['hasPublishedMenu'] = !empty($savedData); // Flag to indicate if published menu exists
        
        //  echo "<pre>"; print_r($data['menuLists']);
        // // print_r($data['savedMenuWithoutOptions']);
        // echo "<pre>"; print_r($data['savedMenuWithOptions']);
        // exit;
       
      
      
      // UPDATED: Load tomorrow's orders by default (nurse can place orders for today and future dates)
      // CRITICAL FIX: Use Australia/Sydney timezone for date operations
      $orderConditions = [
          'date' => $this->getAustraliaTomorrow(), // Load tomorrow's orders by default
          'dept_id' => $this->session->userdata('department_id')
      ];
      $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', ['order_id','is_delivered','buttonType','bed_id','is_floor_consolidated'], $orderConditions);
      
      // REMOVED: Manual unsent orders alert - now handled by automatic status change at midnight
      
      $bedOrderData = [];
      $buttonType ='';
      $orderCommentBedWise = [];
      $selected_options = [];
      if (isset($todaysOrders) && !empty($todaysOrders)) {
          
      foreach ($todaysOrders as $order) {
        $orderId =  $order['order_id'];
        $buttonType = $order['buttonType'];
        
        if (!empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
            // For floor consolidated orders, get data from suite_order_details and linked menu options
            $todaysOrderData = $this->order_model->fetchFloorOrderAndMenuOptions($orderId);
        } else {
            // For legacy orders, use the existing method
            $todaysOrderData = $this->order_model->fetchOrderAndMenuOptions($orderId);
        }
    
      foreach ($todaysOrderData as $opt) {

       $key = $opt['bed_id'] . '_' .$opt['category_id'] . '_' . $opt['menu_id'];
       $selected_options[$key][] = $opt['option_id'];
       $orderCommentBedWise[$opt['bed_id']] = $opt['order_comment'];

       }
      }
    //  echo "<pre>"; print_r($selected_options);exit;
     $data['patientOrderData'] = $selected_options; 
     
      }else{
      $bedOrderData = array();   
     }
       $data['buttonType'] = $buttonType;
       $data['orderCommentBedWise'] = $orderCommentBedWise;
       
       // Create a list of bed IDs that have orders (any buttonType - save or sendorder)
       // This shows all suites with orders, regardless of status
       $bedsWithOrders = [];
       if (!empty($todaysOrders)) {
           foreach ($todaysOrders as $order) {
               if (!empty($order['bed_id'])) {
                   // Legacy suite-specific orders
                   $bedsWithOrders[] = $order['bed_id'];
               } elseif (!empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
                   // Floor consolidated orders - ONLY get suite IDs that have actual menu items
                   // Join with orders_to_patient_options to verify menu items exist
                   $query = "SELECT DISTINCT sd.suite_id 
                             FROM suite_order_details sd
                             INNER JOIN orders_to_patient_options opo ON opo.suite_order_detail_id = sd.id
                             WHERE sd.floor_order_id = ? AND sd.status = 'active'";
                   $result = $this->tenantDb->query($query, [$order['order_id']]);
                   
                   if ($result && $result->num_rows() > 0) {
                       foreach ($result->result_array() as $suite) {
                           $bedsWithOrders[] = $suite['suite_id'];
                       }
                   }
               }
           }
       }
       // Ensure bedsWithOrders is a proper indexed array with integer IDs
       $data['bedsWithOrders'] = array_map('intval', array_values(array_unique($bedsWithOrders)));
       
       // Add occupancy status to each suite for frontend use
       foreach ($data['bedLists'] as &$suite) {
           $hasPatient = !empty($suite['patient_name']);
           $suite['is_occupied'] = $hasPatient ? 1 : 0;
           $suite['is_vaccant'] = $hasPatient ? 0 : 1;
       }
       unset($suite); // CRITICAL: Unset reference to prevent accidental modification
       
       // Add order summary statistics (for tomorrow by default)
       // CRITICAL FIX: Use Australia/Sydney timezone for date operations
       $data['order_summary'] = $this->getOrderSummary($data['bedLists'], $this->getAustraliaTomorrow());
       
       // UPDATED SORT: Order Placed → Occupied → Vacant
       usort($data['bedLists'], function($a, $b) use ($bedsWithOrders) {
           $aHasOrder = in_array($a['id'], $bedsWithOrders);
           $bHasOrder = in_array($b['id'], $bedsWithOrders);
           $aOccupied = $a['is_occupied'] == 1;
           $bOccupied = $b['is_occupied'] == 1;
           
           // Priority: 1 = Order Placed, 2 = Occupied, 3 = Vacant
           $aPriority = $aHasOrder ? 1 : ($aOccupied ? 2 : 3);
           $bPriority = $bHasOrder ? 1 : ($bOccupied ? 2 : 3);
           
           // If same priority, sort by bed number
           if ($aPriority === $bPriority) {
               return $a['bed_no'] <=> $b['bed_no'];
           }
           
           return $aPriority <=> $bPriority;
       });
        //   echo "<pre>"; print_r($orderCommentBedWise);exit;
    
          // Handle order success data for better user experience
          $orderSuccessData = $this->session->userdata('order_success_data');
          if ($orderSuccessData) {
              // Check if success data is recent (within 30 seconds)
              $currentTime = time();
              $dataAge = $currentTime - ($orderSuccessData['timestamp'] ?? 0);
              
              if ($dataAge < 30) {
                  $data['recent_order_success'] = $orderSuccessData;
              }
              
              // Always remove the session data after checking
              $this->session->unset_userdata('order_success_data');
          }
          
          if($isReception){
           $this->load->view('Dashboard/dashboardReception',$data);   
          }else{
          $this->load->view('Dashboard/dashboardNurse',$data);
          }
          
    }
    
    /**
     * Direct database cleanup - Remove problematic suites
     */
    public function cleanupBadSuites() {
        // Only allow admin users
        $userRole = $this->ion_auth->get_users_groups()->row()->id;
        if ($userRole != 1) {
            echo json_encode(['status' => 'error', 'message' => 'Access denied']);
            return;
        }
        
        echo "<h2>Cleaning Up Bad Suite Records</h2>";
        
        // Find and delete suites with empty bed_no
        $sql = "SELECT * FROM suites WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '') AND is_deleted = 0";
        $badSuites = $this->tenantDb->query($sql)->result_array();
        
        echo "<p>Found " . count($badSuites) . " problematic suites:</p>";
        
        if (!empty($badSuites)) {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0; width: 100%;'>";
            echo "<tr style='background: #f2f2f2;'><th>ID</th><th>bed_no</th><th>floor</th><th>is_vaccant</th><th>status</th><th>Action</th></tr>";
            
            foreach ($badSuites as $suite) {
                echo "<tr style='background: #ffcccc;'>";
                echo "<td>" . ($suite['id'] ?? 'NULL') . "</td>";
                echo "<td>'" . ($suite['bed_no'] ?? 'NULL') . "'</td>";
                echo "<td>" . ($suite['floor'] ?? 'NULL') . "</td>";
                echo "<td>" . ($suite['is_vaccant'] ?? 'NULL') . "</td>";
                echo "<td>" . ($suite['status'] ?? 'NULL') . "</td>";
                echo "<td>WILL DELETE</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Delete all problematic suites
            $deleteSql = "UPDATE suites SET is_deleted = 1 WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '') AND is_deleted = 0";
            $this->tenantDb->query($deleteSql);
            
            $affectedRows = $this->tenantDb->affected_rows();
            echo "<p style='color: green; font-weight: bold;'>✅ Successfully marked $affectedRows problematic suites as deleted!</p>";
            
            // Also permanently delete them from database
            $permanentDeleteSql = "DELETE FROM suites WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '')";
            $this->tenantDb->query($permanentDeleteSql);
            
            $deletedRows = $this->tenantDb->affected_rows();
            echo "<p style='color: red; font-weight: bold;'>🗑️ Permanently deleted $deletedRows records from database!</p>";
            
        } else {
            echo "<p style='color: green;'>✅ No problematic suites found!</p>";
        }
        
        echo "<p><a href='" . base_url('Orderportal/Home/index') . "'>← Back to Dashboard</a></p>";
    }

    /**
     * Remove problematic suites with empty bed_no or missing id
     */
    public function removeProblematicSuites() {
        echo "<h2>Removing Problematic Suites</h2>";
        
        // Find suites with empty bed_no or null id
        $sql = "SELECT * FROM suites WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '' OR id IS NULL) AND is_deleted = 0";
        $problematicSuites = $this->tenantDb->query($sql)->result_array();
        
        echo "<p>Found " . count($problematicSuites) . " problematic suites:</p>";
        
        if (!empty($problematicSuites)) {
            echo "<ul>";
            foreach ($problematicSuites as $suite) {
                echo "<li>Suite ID: " . ($suite['id'] ?? 'NULL') . ", bed_no: '" . ($suite['bed_no'] ?? 'NULL') . "'</li>";
            }
            echo "</ul>";
            
            // Mark them as deleted instead of actually deleting (safer)
            $deleteSql = "UPDATE suites SET is_deleted = 1 WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '' OR id IS NULL) AND is_deleted = 0";
            $this->tenantDb->query($deleteSql);
            
            $affectedRows = $this->tenantDb->affected_rows();
            echo "<p><strong>Marked {$affectedRows} problematic suites as deleted.</strong></p>";
        } else {
            echo "<p>No problematic suites found.</p>";
        }
        
        echo "<p><strong>Refresh your dashboard now - the Suite-Unknown card should be gone!</strong></p>";
    }

    /**
     * Quick fix for empty suite numbers - accessible via URL
     */
    public function fixEmptySuites() {
        // Simple fix without complex CodeIgniter bootstrap issues
        
        // Get all suites with empty bed_no
        $sql = "SELECT * FROM suites WHERE (bed_no IS NULL OR bed_no = '' OR TRIM(bed_no) = '') AND is_deleted = 0";
        $emptySuites = $this->tenantDb->query($sql)->result_array();
        
        $fixedCount = 0;
        $results = [];
        
        foreach ($emptySuites as $suite) {
            $newBedNo = 'Suite-' . $suite['id'];
            
            // Check if this bed number already exists
            $checkSql = "SELECT COUNT(*) as count FROM suites WHERE bed_no = ? AND is_deleted = 0 AND id != ?";
            $existingCount = $this->tenantDb->query($checkSql, [$newBedNo, $suite['id']])->row()->count;
            
            if ($existingCount == 0) {
                // Update with new bed number
                $updateSql = "UPDATE suites SET bed_no = ? WHERE id = ?";
                $this->tenantDb->query($updateSql, [$newBedNo, $suite['id']]);
                $fixedCount++;
                $results[] = "Fixed suite ID {$suite['id']} -> {$newBedNo}";
            } else {
                // Try with a counter
                $counter = 1;
                do {
                    $newBedNo = 'Suite-' . $suite['id'] . '-' . $counter;
                    $existingCount = $this->tenantDb->query($checkSql, [$newBedNo, $suite['id']])->row()->count;
                    $counter++;
                } while ($existingCount > 0 && $counter < 10);
                
                if ($existingCount == 0) {
                    $updateSql = "UPDATE suites SET bed_no = ? WHERE id = ?";
                    $this->tenantDb->query($updateSql, [$newBedNo, $suite['id']]);
                    $fixedCount++;
                    $results[] = "Fixed suite ID {$suite['id']} -> {$newBedNo}";
                } else {
                    $results[] = "Could not fix suite ID {$suite['id']} - too many conflicts";
                }
            }
        }
        
        echo "<h2>Empty Suite Cleanup Results</h2>";
        echo "<p>Found " . count($emptySuites) . " suites with empty bed numbers</p>";
        echo "<p>Fixed: {$fixedCount} suites</p>";
        echo "<h3>Details:</h3>";
        echo "<ul>";
        foreach ($results as $result) {
            echo "<li>{$result}</li>";
        }
        echo "</ul>";
        echo "<p><strong>Refresh your dashboard now - the empty suite card should be gone!</strong></p>";
    }
    
    /**
     * Simple debug to check current data
     */
    public function debugCurrentData() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        $deptId = $this->session->userdata('department_id');
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $tomorrowDate = $this->getAustraliaTomorrow();
        
        echo "<h2>Debug Current Data</h2>";
        echo "<p><strong>Department ID:</strong> $deptId</p>";
        echo "<p><strong>Tomorrow's Date:</strong> $tomorrowDate</p>";
        
        // Check orders
        $orderConditions = [
            'date' => $tomorrowDate,
            'dept_id' => $deptId
        ];
        $orders = $this->common_model->fetchRecordsDynamically('orders', ['order_id', 'bed_id', 'buttonType', 'date'], $orderConditions);
        
        echo "<h3>Orders Found (" . count($orders) . "):</h3>";
        if (!empty($orders)) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Order ID</th><th>Bed ID</th><th>Button Type</th><th>Date</th></tr>";
            foreach ($orders as $order) {
                echo "<tr>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>" . $order['bed_id'] . "</td>";
                echo "<td>" . $order['buttonType'] . "</td>";
                echo "<td>" . $order['date'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No orders found!</p>";
        }
        
        // Check suites
        $suiteConditions = ['is_deleted' => 0, 'floor' => $deptId];
        $suites = $this->common_model->fetchRecordsDynamically('suites', ['id', 'bed_no', 'is_vaccant'], $suiteConditions);
        
        echo "<h3>Suites Found (" . count($suites) . "):</h3>";
        if (!empty($suites)) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Suite ID</th><th>Bed No</th><th>is_vaccant</th></tr>";
            foreach ($suites as $suite) {
                if (!empty($suite['bed_no']) && trim($suite['bed_no']) !== '') {
                    echo "<tr>";
                    echo "<td>" . $suite['id'] . "</td>";
                    echo "<td>" . $suite['bed_no'] . "</td>";
                    echo "<td>" . ($suite['is_vaccant'] ?? 'NULL') . "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        }
        
        // Check patients
        echo "<h3>Patients:</h3>";
        $patients = $this->common_model->fetchRecordsDynamically('people', ['id', 'name', 'suite_number', 'status'], ['status' => 1]);
        if (!empty($patients)) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Patient ID</th><th>Name</th><th>Suite Number</th></tr>";
            foreach ($patients as $patient) {
                echo "<tr>";
                echo "<td>" . $patient['id'] . "</td>";
                echo "<td>" . htmlspecialchars($patient['name']) . "</td>";
                echo "<td>" . $patient['suite_number'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No active patients found!</p>";
        }
    }

    /**
     * Debug order summary to see what's happening
     */
    public function debugOrderSummary() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        // Get the same data as the dashboard
        $conditions = array('is_deleted' => 0,'floor'=>$this->session->userdata('department_id'));
        $allSuites = $this->common_model->fetchRecordsDynamically('suites','',$conditions);
        
        // Filter out problematic suites
        $bedLists = [];
        if (!empty($allSuites)) {
            foreach ($allSuites as $suite) {
                if (isset($suite['bed_no']) && trim($suite['bed_no']) !== '' && !empty($suite['bed_no'])) {
                    $bedLists[] = $suite;
                }
            }
        }
        
        // Fetch patient information for each suite
        if (!empty($bedLists)) {
            foreach ($bedLists as &$suite) {
                $patientConditions = [
                    'status' => 1,
                    'suite_number' => $suite['id']
                ];
                $patientData = $this->common_model->fetchRecordsDynamically('people', ['name'], $patientConditions);
                $suite['patient_name'] = !empty($patientData) ? $patientData[0]['name'] : '';
            }
        }
        
        // Get tomorrow's orders
        // CRITICAL FIX: Use Australia/Sydney timezone for date operations
        $tomorrowDate = $this->getAustraliaTomorrow();
        $orderConditions = [
            'date' => $tomorrowDate,
            'buttonType' => 'sendorder'
        ];
        $tomorrowOrders = $this->common_model->fetchRecordsDynamically('orders', ['bed_id', 'order_id'], $orderConditions);
        
        echo "<h2>Order Summary Debug</h2>";
        echo "<p><strong>Tomorrow's date:</strong> $tomorrowDate</p>";
        echo "<p><strong>Found orders:</strong> " . count($tomorrowOrders) . "</p>";
        
        if (!empty($tomorrowOrders)) {
            echo "<h3>Orders found:</h3>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Order ID</th><th>Bed ID</th></tr>";
            foreach ($tomorrowOrders as $order) {
                echo "<tr><td>" . $order['order_id'] . "</td><td>" . $order['bed_id'] . "</td></tr>";
            }
            echo "</table>";
        }
        
        echo "<h3>Suite Analysis:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background: #f2f2f2;'><th>Suite ID</th><th>Bed No</th><th>is_vaccant</th><th>Patient Name</th><th>Has Order?</th><th>Should Count As</th></tr>";
        
        $suitesWithOrders = [];
        if (!empty($tomorrowOrders)) {
            foreach ($tomorrowOrders as $order) {
                if (!empty($order['bed_id'])) {
                    $suitesWithOrders[] = $order['bed_id'];
                }
            }
        }
        $suitesWithOrders = array_unique($suitesWithOrders);
        
        $totalOccupied = 0;
        $totalPatients = 0;
        $ordersPlaced = 0;
        $pendingOrders = 0;
        
        foreach ($bedLists as $suite) {
            $hasPatientName = !empty($suite['patient_name']);
            $isVacantField = isset($suite['is_vaccant']) ? $suite['is_vaccant'] : 0;
            $isOccupied = $hasPatientName || ($isVacantField == 0);
            $hasOrder = in_array($suite['id'], $suitesWithOrders);
            
            if ($isOccupied) $totalOccupied++;
            if ($hasPatientName) {
                $totalPatients++;
                if ($hasOrder) {
                    $ordersPlaced++;
                } else {
                    $pendingOrders++;
                }
            }
            
            $shouldCount = '';
            if ($hasPatientName && $hasOrder) {
                $shouldCount = 'PATIENT WITH ORDER';
            } elseif ($hasPatientName) {
                $shouldCount = 'PATIENT PENDING ORDER';
            } elseif ($isOccupied) {
                $shouldCount = 'OCCUPIED (no patient info)';
            } else {
                $shouldCount = 'VACANT';
            }
            
            $rowColor = $hasOrder ? 'background: #d4edda;' : ($hasPatientName ? 'background: #fff3cd;' : ($isOccupied ? 'background: #cce5ff;' : 'background: #f8f9fa;'));
            
            echo "<tr style='$rowColor'>";
            echo "<td>" . $suite['id'] . "</td>";
            echo "<td>" . htmlspecialchars($suite['bed_no']) . "</td>";
            echo "<td>" . ($suite['is_vaccant'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($suite['patient_name']) . "</td>";
            echo "<td>" . ($hasOrder ? 'YES' : 'NO') . "</td>";
            echo "<td><strong>$shouldCount</strong></td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>Summary Counts:</h3>";
        echo "<ul>";
        echo "<li><strong>Total Occupied Suites:</strong> $totalOccupied</li>";
        echo "<li><strong>Total Patients:</strong> $totalPatients</li>";
        echo "<li><strong>Orders Placed:</strong> $ordersPlaced</li>";
        echo "<li><strong>Pending Orders:</strong> $pendingOrders</li>";
        echo "</ul>";
        
        echo "<p><strong>Legend:</strong></p>";
        echo "<ul>";
        echo "<li style='background: #d4edda; display: inline-block; padding: 5px;'>Green = Has Order</li>";
        echo "<li style='background: #fff3cd; display: inline-block; padding: 5px; margin-left: 10px;'>Yellow = Patient Pending Order</li>";
        echo "<li style='background: #cce5ff; display: inline-block; padding: 5px; margin-left: 10px;'>Blue = Occupied (no patient)</li>";
        echo "<li style='background: #f8f9fa; display: inline-block; padding: 5px; margin-left: 10px;'>Gray = Vacant</li>";
        echo "</ul>";
    }

    /**
     * Get order summary statistics for dashboard
     */
    private function getOrderSummary($bedLists, $orderDate = null) {
        $summary = [
            'total_occupied_suites' => 0,
            'suites_with_orders' => 0,
            'suites_pending_orders' => 0,
            'total_patients' => 0,
            'patients_with_orders' => 0,
            'patients_pending_orders' => 0
        ];
        
        // Use the provided date or default to today
        $dateToCheck = $orderDate ?: date('Y-m-d');
        $conditions = array('date' => $dateToCheck, 'dept_id' => $this->session->userdata('department_id'));
        $todaysOrders = $this->common_model->fetchRecordsDynamically('orders', '', $conditions);
        
        // Create the SAME bedsWithOrders array as the main dashboard
        $suitesWithOrders = [];
        if (!empty($todaysOrders)) {
            foreach ($todaysOrders as $order) {
                // Include ALL orders (both save and sendorder types)
                if (!empty($order['bed_id'])) {
                    // Legacy suite-specific orders
                    $suitesWithOrders[] = $order['bed_id'];
                } elseif (!empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1) {
                    // Floor consolidated orders - ONLY get suite IDs that have actual menu items
                    // Join with orders_to_patient_options to verify menu items exist
                    $query = "SELECT DISTINCT sd.suite_id 
                              FROM suite_order_details sd
                              INNER JOIN orders_to_patient_options opo ON opo.suite_order_detail_id = sd.id
                              WHERE sd.floor_order_id = ? AND sd.status = 'active'";
                    $result = $this->tenantDb->query($query, [$order['order_id']]);
                    
                    if ($result && $result->num_rows() > 0) {
                        foreach ($result->result_array() as $suite) {
                            $suitesWithOrders[] = $suite['suite_id'];
                        }
                    }
                }
            }
        }
        $suitesWithOrders = array_unique($suitesWithOrders);
        
        // Count statistics
        foreach ($bedLists as $suite) {
            // A suite is considered occupied ONLY if it has a patient name
            // This ensures "Occupied Suites" matches "Total Patients"
            $hasPatientName = !empty($suite['patient_name']);
            
            // Count patients and occupied suites (same logic)
            if ($hasPatientName) {
                $summary['total_patients']++;
                $summary['total_occupied_suites']++;
                
                // Check if this suite has placed an order (any type)
                if (in_array($suite['id'], $suitesWithOrders)) {
                    $summary['patients_with_orders']++;
                    $summary['suites_with_orders']++;
                } else {
                    $summary['patients_pending_orders']++;
                    $summary['suites_pending_orders']++;
                }
            }
        }
        
        return $summary;
    }
    
    function fetchNotification(){
      $notifications =  fetchAllUnreadNotification($this->tenantDb,$this->selected_location_id);
      echo json_encode(['status' => 'success', 'message' => $notifications]);
     
    }
    
    /**
     * Comprehensive debug method to trace order status issues
     */
    function debugOrderStatusIssue() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        $conditions = array('is_deleted' => 0 ,'listtype' => 'floor');
        $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $debug_data = [];
        foreach ($departmentListData as $department) {
            $deptId = $department['id'];
            $deptName = $department['name'];
            
            // Step 1: Check for unsent orders (buttonType = 'save')
            $unsentOrderConditions = [
                'date' => date('Y-m-d'),
                'dept_id' => $deptId,
                'buttonType' => 'save'
            ];
            
            $unsentOrders = $this->common_model->fetchRecordsDynamically('orders', '*', $unsentOrderConditions);
            
            // Step 2: Check for sent orders (buttonType = 'sendorder')
            $orderConditions = [
                'date' => date('Y-m-d'),
                'dept_id' => $deptId,
                'buttonType' => 'sendorder'
            ];
            
            $orders = $this->common_model->fetchRecordsDynamically('orders', '*', $orderConditions);
            
            $floor_debug = [
                'floor_name' => $deptName,
                'floor_id' => $deptId,
                'delivery_date' => date('Y-m-d'),
                'unsent_orders_found' => count($unsentOrders),
                'sent_orders_found' => count($orders),
                'raw_unsent_orders' => $unsentOrders,
                'raw_sent_orders' => $orders
            ];
            
            if (!empty($unsentOrders)) {
                // If there are unsent orders, show details about them
                $unsentOrder = $unsentOrders[0];
                $floor_debug['order_details'] = [
                    'order_id' => $unsentOrder['order_id'],
                    'order_status' => $unsentOrder['status'],
                    'buttonType' => $unsentOrder['buttonType'],
                    'note' => 'This floor has UNSENT orders'
                ];
                $floor_debug['calculated_status'] = ['status' => 'unsent_orders', 'details' => 'Orders saved but not sent to chef'];
            } elseif (!empty($orders)) {
                $order = $orders[0];
                $orderId = $order['order_id'];
                
                // Step 2: Check order items
                $totalItems = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options',
                    '*',
                    ['order_id' => $orderId]
                );
                
                $completedItems = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options',
                    '*',
                    ['order_id' => $orderId, 'status' => 1]
                );
                
                $floor_debug['order_details'] = [
                    'order_id' => $orderId,
                    'order_status' => $order['status'],
                    'is_delivered' => $order['is_delivered'] ?? 0,
                    'total_items' => count($totalItems),
                    'completed_items' => count($completedItems),
                    'all_items' => $totalItems,
                    'completed_items_data' => $completedItems
                ];
                
                // Step 3: Calculate what status should be
                $calculatedStatus = $this->calculateFloorDeliveryStatus($deptId);
                $floor_debug['calculated_status'] = $calculatedStatus;
            } else {
                $floor_debug['order_details'] = 'No orders found';
                $floor_debug['calculated_status'] = ['status' => 'no_orders', 'details' => 'No orders'];
            }
            
            $debug_data[] = $floor_debug;
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Complete order status debug data',
            'current_time' => date('Y-m-d H:i:s'),
            'timezone' => date_default_timezone_get(),
            'current_date' => date('Y-m-d'),
            'data' => $debug_data
        ], JSON_PRETTY_PRINT);
    }
    
    /**
     * Quick debug to check specific floor orders
     */
    function debugGresellOrders() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        
        // First find Gresell department ID
        $conditions = array('is_deleted' => 0 ,'listtype' => 'floor', 'name' => 'Gresell');
        $gresellDept = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '*', $conditions);
        
        if (empty($gresellDept)) {
            echo "<h2>Gresell department not found. Available floors:</h2>";
            $allFloors = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '*', array('is_deleted' => 0 ,'listtype' => 'floor'));
            echo "<pre>" . print_r($allFloors, true) . "</pre>";
            return;
        }
        
        $gresellId = $gresellDept[0]['id'];
        echo "<h2>Found Gresell Department ID: {$gresellId}</h2>";
        
        // Check Gresell floor specifically (seems to be the one showing "Unsent")
        $gresellConditions = [
            'date' => date('Y-m-d'),
            'dept_id' => $gresellId,
        ];
        
        $allGresellOrders = $this->common_model->fetchRecordsDynamically('orders', '*', $gresellConditions);
        
        echo "<h2>All Gresell Orders for Today (" . date('Y-m-d') . "):</h2>";
        echo "<pre>" . print_r($allGresellOrders, true) . "</pre>";
        
        if (!empty($allGresellOrders)) {
            foreach ($allGresellOrders as $order) {
                echo "<h3>Order ID: {$order['order_id']} - ButtonType: {$order['buttonType']} - Status: {$order['status']}</h3>";
                
                // Check order items
                $items = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options', 
                    '*', 
                    ['order_id' => $order['order_id']]
                );
                echo "<h4>Order Items:</h4>";
                echo "<pre>" . print_r($items, true) . "</pre>";
            }
        }
        
        // Also check what calculateFloorDeliveryStatus returns
        $calculatedStatus = $this->calculateFloorDeliveryStatus($gresellId);
        echo "<h3>Calculated Status for Gresell:</h3>";
        echo "<pre>" . print_r($calculatedStatus, true) . "</pre>";
    }
    
    /**
     * Debug method to check what orders exist for floors
     */
    function debugFloorOrders() {
        // SECURITY: Only allow in development/testing environments
        if (ENVIRONMENT === 'production') {
            show_404();
            return;
        }
        $conditions = array('is_deleted' => 0 ,'listtype' => 'floor');
        $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $debug_data = [];
        foreach ($departmentListData as $department) {
            // Check today's orders
            $orderConditions = [
                'date' => date('Y-m-d'),
                'dept_id' => $department['id'],
                'buttonType' => 'sendorder'
            ];
            
            $orders = $this->common_model->fetchRecordsDynamically('orders', '*', $orderConditions);
            
            $debug_data[] = [
                'floor_name' => $department['name'],
                'floor_id' => $department['id'],
                'delivery_date' => date('Y-m-d'),
                'orders_found' => count($orders),
                'orders_data' => $orders
            ];
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Floor orders debug data',
            'data' => $debug_data
        ]);
    }
    
    /**
     * Calculate actual delivery status for a floor based on order data
     * UPDATED: Allow partial orders - chef can work on sent orders even if some suites haven't sent theirs
     */
    private function calculateFloorDeliveryStatus($departmentId) {
        // Check for sent orders first (buttonType = 'sendorder') - these take priority
        $sentOrderConditions = [
            'date' => date('Y-m-d'), // TODAY's orders (delivery date)
            'dept_id' => $departmentId,
            'buttonType' => 'sendorder',
            'status !=' => 0 // Not cancelled
        ];
        
        $sentOrders = $this->common_model->fetchRecordsDynamically(
            'orders', 
            ['order_id', 'status', 'is_delivered', 'is_floor_consolidated'], 
            $sentOrderConditions
        );
        
        // If there are sent orders, process them regardless of unsent orders
        if (!empty($sentOrders)) {
            $order = $sentOrders[0];
            $orderId = $order['order_id'];
            $orderStatus = $order['status'];
            $isFloorConsolidated = !empty($order['is_floor_consolidated']) && $order['is_floor_consolidated'] == 1;
            
            // Check food preparation status for sent orders
            // FIXED: For floor-consolidated orders, only count items from TODAY's active suite_order_details
            if ($isFloorConsolidated) {
                // Floor consolidated - count via suite_order_details join to avoid counting old items
                $totalItemsResult = $this->tenantDb->query("
                    SELECT COUNT(*) as total
                    FROM orders_to_patient_options opo
                    INNER JOIN suite_order_details sod ON sod.id = opo.suite_order_detail_id
                    WHERE sod.floor_order_id = ? AND sod.status = 'active'
                ", [$orderId]);
                $totalItems = [$totalItemsResult->row_array()];
                
                $completedItemsResult = $this->tenantDb->query("
                    SELECT COUNT(*) as completed
                    FROM orders_to_patient_options opo
                    INNER JOIN suite_order_details sod ON sod.id = opo.suite_order_detail_id
                    WHERE sod.floor_order_id = ? AND sod.status = 'active' AND opo.status = 1
                ", [$orderId]);
                $completedItems = [$completedItemsResult->row_array()];
            } else {
                // Legacy suite-specific orders - use existing logic
                $totalItems = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options',
                    ['COUNT(*) as total'],
                    ['order_id' => $orderId]
                );
                
                $completedItems = $this->common_model->fetchRecordsDynamically(
                    'orders_to_patient_options',
                    ['COUNT(*) as completed'],
                    ['order_id' => $orderId, 'status' => 1]
                );
            }
            
            $totalCount = $totalItems[0]['total'] ?? 0;
            $completedCount = $completedItems[0]['completed'] ?? 0;
            
            // Check if there are also unsent orders for this department from OCCUPIED suites only
            $this->tenantDb->select('o.order_id');
            $this->tenantDb->from('orders o');
            $this->tenantDb->join('suites s', 's.id = o.bed_id', 'INNER');
            $this->tenantDb->where('o.date', date('Y-m-d'));
            $this->tenantDb->where('o.dept_id', $departmentId);
            $this->tenantDb->where('o.buttonType', 'save');
            $this->tenantDb->where('o.status !=', 0);
            $this->tenantDb->where('s.is_vaccant', 0); // Only occupied suites
            $unsentOrdersQuery = $this->tenantDb->get();
            $unsentOrders = $unsentOrdersQuery->result_array();
            
            $hasUnsentOrders = !empty($unsentOrders);
            $unsentCount = count($unsentOrders);
            
            // Determine status based on sent order progression, with unsent order indicator
            if ($totalCount == 0) {
                $baseDetails = 'No items in sent orders';
            } elseif ($completedCount == 0) {
                $baseDetails = 'Food preparation not started';
            } elseif ($completedCount < $totalCount) {
                $baseDetails = "Preparing ({$completedCount}/{$totalCount} items ready)";
            } elseif ($orderStatus == 3) {
                $baseDetails = 'Food ready, awaiting delivery';
            } elseif ($orderStatus == 4 || $order['is_delivered'] == 1) {
                $baseDetails = 'Food delivered to floor';
            } else {
                $baseDetails = 'Food completed, ready for delivery';
            }
            
            // Add unsent orders indicator if applicable
            if ($hasUnsentOrders) {
                $baseDetails .= " (+{$unsentCount} unsent)";
            }
            
            // Return appropriate status based on sent orders progression
            if ($totalCount == 0) {
                return [
                    'status' => 'no_items',
                    'details' => $baseDetails
                ];
            } elseif ($completedCount == 0) {
                return [
                    'status' => 'not_started',
                    'details' => $baseDetails
                ];
            } elseif ($completedCount < $totalCount) {
                return [
                    'status' => 'in_progress',
                    'details' => $baseDetails
                ];
            } elseif ($orderStatus == 3) {
                return [
                    'status' => 'ready_for_delivery',
                    'details' => $baseDetails
                ];
            } elseif ($orderStatus == 4 || $order['is_delivered'] == 1) {
                return [
                    'status' => 'delivered',
                    'details' => $baseDetails
                ];
            } else {
                return [
                    'status' => 'ready_for_delivery',
                    'details' => $baseDetails
                ];
            }
        }
        
        // Only if there are NO sent orders, check for unsent orders from OCCUPIED suites only
        $this->tenantDb->select('o.order_id, o.status');
        $this->tenantDb->from('orders o');
        $this->tenantDb->join('suites s', 's.id = o.bed_id', 'INNER');
        $this->tenantDb->where('o.date', date('Y-m-d'));
        $this->tenantDb->where('o.dept_id', $departmentId);
        $this->tenantDb->where('o.buttonType', 'save');
        $this->tenantDb->where('o.status !=', 0);
        $this->tenantDb->where('s.is_vaccant', 0); // Only occupied suites
        $unsentOrdersQuery = $this->tenantDb->get();
        $unsentOrders = $unsentOrdersQuery->result_array();
        
        if (!empty($unsentOrders)) {
            return [
                'status' => 'unsent_orders',
                'details' => 'Orders saved but not sent to chef yet'
            ];
        }
        
        // If no sent orders and no unsent orders, then no orders for today
        return [
            'status' => 'no_orders',
            'details' => 'No orders placed for today'
        ];
    }
    
    /**
     * NEW: Get suite status for a specific date (for Nurse Dashboard date picker)
     */
    public function getSuiteStatusForDate() {
        // Validate date parameter
        $orderDate = $this->input->post('order_date');
        
        if (!$orderDate) {
            echo json_encode(['success' => false, 'message' => 'Order date is required']);
            return;
        }
        
        // Validate date format and range (today to +7 days)
        $orderDateTime = strtotime($orderDate);
        $today = strtotime(date('Y-m-d'));
        $maxDate = strtotime('+7 days', $today);
        
        if ($orderDateTime < $today || $orderDateTime > $maxDate) {
            echo json_encode(['success' => false, 'message' => 'Invalid date. Please select a date between today and next 7 days.']);
            return;
        }
        
        try {
            // AUTO-CLEANUP: Mark discharged patients as inactive
            $this->autoMarkDischargedPatientsInactive();
            
            // Fetch bed lists filtered by nurse's floor (same logic as dashboardNurse)
            $conditions = array('is_deleted' => 0, 'floor' => $this->session->userdata('department_id'));
            $allSuites = $this->common_model->fetchRecordsDynamically('suites', '', $conditions);
            
            // Filter out suites without valid bed_no
            $bedLists = [];
            if (!empty($allSuites)) {
                foreach ($allSuites as $suite) {
                    if (isset($suite['bed_no']) && trim($suite['bed_no']) !== '' && !empty($suite['bed_no'])) {
                        $bedLists[] = $suite;
                    }
                }
            }
            
            // Get patient details for each bed (same logic as dashboardNurse)
            foreach ($bedLists as &$suite) {
                // Get active patient for this suite
                $patientConditions = [
                    'suite_number' => $suite['id'],
                    'status' => 1 // Active patients only
                ];
                $patients = $this->common_model->fetchRecordsDynamically('people', ['name', 'allergies', 'dietary_preferences', 'special_instructions', 'date_onboarded', 'date_of_discharge'], $patientConditions);
                
                // Filter out patients with past discharge dates
                $activePatient = null;
                $today = date('Y-m-d');
                if (!empty($patients)) {
                    foreach ($patients as $patient) {
                        $discharge_date = $patient['date_of_discharge'];
                        if (empty($discharge_date) || $discharge_date > $today) {
                            $activePatient = $patient;
                            break;
                        } else {
                            // LOG: Stale patient record found
                            log_message('warning', "Dynamic Date - Stale patient record: Suite {$suite['bed_no']} (ID: {$suite['id']}) has patient with past discharge date: {$discharge_date}");
                        }
                    }
                }
                
                // LOG: If no active patient found but patients exist
                if (empty($activePatient) && !empty($patients)) {
                    log_message('info', "Dynamic Date - Suite {$suite['bed_no']} (ID: {$suite['id']}) has {". count($patients) ."} patient record(s) but all have past discharge dates");
                }
                
                // Add patient info to suite data
                $suite['patient_name'] = $activePatient ? $activePatient['name'] : null;
                $suite['patient_allergies'] = $activePatient ? $activePatient['allergies'] : null;
                $suite['patient_dietary_preferences'] = $activePatient ? ($activePatient['dietary_preferences'] ?? null) : null;
                $suite['patient_instructions'] = $activePatient ? $activePatient['special_instructions'] : null;
                $suite['patient_onboarded'] = $activePatient ? $activePatient['date_onboarded'] : null;
                $suite['patient_discharge'] = $activePatient ? $activePatient['date_of_discharge'] : null;
                
                // 🆕 SPECIAL ITEMS FEATURE: Count patient allergies
                $allergyCount = 0;
                if ($activePatient && !empty($activePatient['allergies'])) {
                    // Allergies are stored as comma-separated IDs or JSON array
                    $allergiesData = $activePatient['allergies'];
                    
                    // Try to parse as JSON first
                    $allergyArray = json_decode($allergiesData, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($allergyArray)) {
                        $allergyCount = count($allergyArray);
                    } else {
                        // Fallback: count comma-separated values
                        $allergyArray = explode(',', $allergiesData);
                        $allergyArray = array_filter(array_map('trim', $allergyArray)); // Remove empty values
                        $allergyCount = count($allergyArray);
                    }
                }
                
                $suite['allergy_count'] = $allergyCount;
                $suite['has_high_allergies'] = $allergyCount >= 2; // Flag for 3+ allergies
                
                // CRITICAL FIX: Update is_occupied based on active patient
                $suite['is_occupied'] = $activePatient ? 1 : 0;
                // is_vaccant is opposite of is_occupied
                $suite['is_vaccant'] = $activePatient ? 0 : 1;
            }
            unset($suite);
            
            // Get beds with orders for the selected date
            $bedsWithOrders = [];
            $orderConditions = array('date' => $orderDate, 'status !=' => 0);
            $ordersForDate = $this->common_model->fetchRecordsDynamically('orders', '', $orderConditions);
            
            foreach ($ordersForDate as $order) {
                if ($order['is_floor_consolidated'] == 1) {
                    // Floor consolidated orders - get suite IDs with actual menu items
                    $query = "SELECT DISTINCT sd.suite_id 
                              FROM suite_order_details sd
                              INNER JOIN orders_to_patient_options opo ON opo.suite_order_detail_id = sd.id
                              WHERE sd.floor_order_id = ? AND sd.status = 'active'";
                    $result = $this->tenantDb->query($query, [$order['order_id']]);
                    
                    if ($result && $result->num_rows() > 0) {
                        foreach ($result->result_array() as $suite) {
                            $bedsWithOrders[] = $suite['suite_id'];
                        }
                    }
                } else {
                    // Regular orders
                    $bedsWithOrders[] = $order['bed_id'];
                }
            }
            
            // SORT SUITES: Order Placed → Occupied → Vacant
            usort($bedLists, function($a, $b) use ($bedsWithOrders) {
                $aHasOrder = in_array($a['id'], $bedsWithOrders);
                $bHasOrder = in_array($b['id'], $bedsWithOrders);
                $aOccupied = $a['is_occupied'] == 1;
                $bOccupied = $b['is_occupied'] == 1;
                
                // Priority: 1 = Order Placed, 2 = Occupied, 3 = Vacant
                $aPriority = $aHasOrder ? 1 : ($aOccupied ? 2 : 3);
                $bPriority = $bHasOrder ? 1 : ($bOccupied ? 2 : 3);
                
                // If same priority, sort by bed number
                if ($aPriority === $bPriority) {
                    return $a['bed_no'] <=> $b['bed_no'];
                }
                
                return $aPriority <=> $bPriority;
            });
            
            // Calculate metrics for the selected date
            $metrics = $this->getOrderSummary($bedLists, $orderDate);
            
            // Ensure bedsWithOrders is a proper indexed array (not an object in JSON)
            $bedsWithOrdersArray = array_values(array_unique($bedsWithOrders));
            
            // Convert all IDs to integers for consistent comparison
            $bedsWithOrdersArray = array_map('intval', $bedsWithOrdersArray);
            
            echo json_encode([
                'success' => true,
                'bedLists' => $bedLists,
                'bedsWithOrders' => $bedsWithOrdersArray,
                'metrics' => $metrics
            ]);
            
        } catch (Exception $e) {
            log_message('error', 'Error in getSuiteStatusForDate: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error fetching suite status']);
        }
    }
    
    /**
     * NEW: Get menu data for a specific date (for Nurse Dashboard date picker)
     */
    public function getMenuDataForDate() {
        // Validate parameters
        $bedId = $this->input->post('bed_id');
        $orderDate = $this->input->post('order_date');
        
        if (!$bedId || !$orderDate) {
            echo json_encode(['success' => false, 'message' => 'Bed ID and order date are required']);
            return;
        }
        
        // Validate date format and range
        $orderDateTime = strtotime($orderDate);
        $today = strtotime(date('Y-m-d'));
        $maxDate = strtotime('+7 days', $today);
        
        if ($orderDateTime < $today || $orderDateTime > $maxDate) {
            echo json_encode(['success' => false, 'message' => 'Invalid date']);
            return;
        }
        
        try {
            // Fetch categories
            $conditions = array('listtype' => 'category', 'is_deleted' => '0');
            $categories = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditions);
            
            // 🆕 SPECIAL ITEMS FEATURE: Get patient allergy count
            $patientInfo = $this->common_model->fetchRecordsDynamically(
                'people',
                ['allergies'],
                ['suite_number' => $bedId, 'status' => 1]
            );
            
            $allergyCount = 0;
            $showSpecialItems = false;
            
            if (!empty($patientInfo)) {
                $allergiesData = $patientInfo[0]['allergies'];
                
                if (!empty($allergiesData)) {
                    // Try to parse as JSON first
                    $allergyArray = json_decode($allergiesData, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($allergyArray)) {
                        $allergyCount = count($allergyArray);
                    } else {
                        // Fallback: count comma-separated values
                        $allergyArray = explode(',', $allergiesData);
                        $allergyArray = array_filter(array_map('trim', $allergyArray));
                        $allergyCount = count($allergyArray);
                    }
                }
                
                // Show special items if patient has 3+ allergies
                $showSpecialItems = $allergyCount >= 2;
            }
            
            // Fetch all menu items
            $menus = $this->menu_model->fetchMenuDetails('', true);
            
            // 🆕 SPECIAL ITEMS FEATURE: Filter out special items if patient has < 3 allergies
            if (!$showSpecialItems) {
                foreach ($menus as &$menu) {
                    if (isset($menu['menu_options']) && is_array($menu['menu_options'])) {
                        $menu['menu_options'] = array_filter($menu['menu_options'], function($option) {
                            // Keep option if it's NOT a special item (is_special_item = 0 or null)
                            return empty($option['is_special_item']) || $option['is_special_item'] == 0;
                        });
                        // Re-index array to prevent gaps
                        $menu['menu_options'] = array_values($menu['menu_options']);
                    }
                }
                unset($menu); // Break reference
            }
            
            // Check if there's a published menu for this date
            // ✅ MENU IS ALWAYS COMMON FOR ALL: department_id = 0 is the common menu for all departments
            $conditionsM = array('date' => $orderDate, 'status' => 2, 'department_id' => 0);
            $publishedMenu = $this->common_model->fetchRecordsDynamically('menuPlanner', '', $conditionsM);
            
            $hasPublishedMenu = !empty($publishedMenu);
            
            // Get saved menus (with and without options) for this date
            $savedMenuWithoutOptions = [];
            $savedMenuWithOptions = [];
            
            if ($hasPublishedMenu) {
                foreach ($publishedMenu as $menuPlanner) {
                    // Deserialize menu data
                    $menuWithoutOpt = @unserialize($menuPlanner['menuWithoutOptions']);
                    $menuWithOpt = @unserialize($menuPlanner['menuWithOptions']);
                    
                    if ($menuWithoutOpt !== false && is_array($menuWithoutOpt)) {
                        foreach ($menuWithoutOpt as $categoryId => $menuIds) {
                            // ✅ CRITICAL FIX: Ensure keys are consistent (use strings for JSON compatibility)
                            $categoryIdKey = (string)$categoryId;
                            if (!isset($savedMenuWithoutOptions[$categoryIdKey])) {
                                $savedMenuWithoutOptions[$categoryIdKey] = [];
                            }
                            // Convert menu IDs to strings for consistency
                            $menuIdsAsStrings = array_map('strval', $menuIds);
                            $savedMenuWithoutOptions[$categoryIdKey] = array_merge(
                                $savedMenuWithoutOptions[$categoryIdKey],
                                $menuIdsAsStrings
                            );
                        }
                    }
                    
                    if ($menuWithOpt !== false && is_array($menuWithOpt)) {
                        foreach ($menuWithOpt as $categoryId => $menuData) {
                            // ✅ CRITICAL FIX: Ensure keys are consistent (use strings for JSON compatibility)
                            $categoryIdKey = (string)$categoryId;
                            if (!isset($savedMenuWithOptions[$categoryIdKey])) {
                                $savedMenuWithOptions[$categoryIdKey] = [];
                            }
                            foreach ($menuData as $menuId => $optionIds) {
                                // ✅ CRITICAL FIX: Ensure menu ID and option IDs are strings for consistent comparison
                                $menuIdKey = (string)$menuId;
                                if (!isset($savedMenuWithOptions[$categoryIdKey][$menuIdKey])) {
                                    $savedMenuWithOptions[$categoryIdKey][$menuIdKey] = [];
                                }
                                // Convert option IDs to strings for consistent comparison in JavaScript
                                $optionIdsAsStrings = array_map('strval', $optionIds);
                                $savedMenuWithOptions[$categoryIdKey][$menuIdKey] = array_merge(
                                    $savedMenuWithOptions[$categoryIdKey][$menuIdKey],
                                    $optionIdsAsStrings
                                );
                            }
                        }
                    }
                }
            }
            
            // Get existing order data for this bed and date
            // Check both floor-consolidated and legacy orders
            $patientOrderData = [];
            $orderComment = '';
            $roomServiceEnabled = false;
            
            // First, try to find a floor-consolidated order for this floor and date
            $floorId = null;
            $suiteInfo = $this->common_model->fetchRecordsDynamically('suites', '', array('id' => $bedId));
            if (!empty($suiteInfo)) {
                $floorId = $suiteInfo[0]['floor'];
            }
            
            $floorOrderConditions = array(
                'date' => $orderDate,
                'dept_id' => $floorId,
                'is_floor_consolidated' => 1,
                'status !=' => 0
            );
            $floorOrder = $this->common_model->fetchRecordsDynamically('orders', '', $floorOrderConditions);
            
            if (!empty($floorOrder)) {
                // Floor-consolidated order exists
                $orderId = $floorOrder[0]['order_id'];
                
                // Get suite_order_details for this specific suite
                $suiteOrderDetails = $this->common_model->fetchRecordsDynamically(
                    'suite_order_details',
                    '',
                    array('floor_order_id' => $orderId, 'suite_id' => $bedId, 'status' => 'active')
                );
                
                if (!empty($suiteOrderDetails)) {
                    $suiteOrderDetailId = $suiteOrderDetails[0]['id'];
                    $orderComment = $suiteOrderDetails[0]['comments'] ?? '';
                    $roomServiceEnabled = $suiteOrderDetails[0]['room_service'] == 1;
                    
                    // Get ordered items for this suite
                    $orderItems = $this->common_model->fetchRecordsDynamically(
                        'orders_to_patient_options',
                        '',
                        array('suite_order_detail_id' => $suiteOrderDetailId)
                    );
                    
                    foreach ($orderItems as $item) {
                        $key = $bedId . '_' . $item['category_id'] . '_' . $item['menu_id'];
                        if (!isset($patientOrderData[$key])) {
                            $patientOrderData[$key] = [];
                        }
                        // Convert to string for consistent comparison in frontend
                        // FIXED: Column name is 'option_id', not 'menu_option_id'
                        $patientOrderData[$key][] = (string)$item['option_id'];
                    }
                }
            } else {
                // Try legacy bed-specific order
                $orderConditions = array('bed_id' => $bedId, 'date' => $orderDate, 'status !=' => 0);
                $existingOrder = $this->common_model->fetchRecordsDynamically('orders', '', $orderConditions);
                
                if (!empty($existingOrder)) {
                    $orderId = $existingOrder[0]['order_id'];
                    $orderComment = $existingOrder[0]['comments'] ?? '';
                    $roomServiceEnabled = $existingOrder[0]['room_service'] == 1;
                    
                    // Get ordered items
                    $orderItems = $this->common_model->fetchRecordsDynamically(
                        'orders_to_patient_options',
                        '',
                        array('order_id' => $orderId)
                    );
                    
                    foreach ($orderItems as $item) {
                        $key = $bedId . '_' . $item['category_id'] . '_' . $item['menu_id'];
                        if (!isset($patientOrderData[$key])) {
                            $patientOrderData[$key] = [];
                        }
                        // Convert to string for consistent comparison in frontend
                        // FIXED: Column name is 'option_id', not 'menu_option_id'
                        $patientOrderData[$key][] = (string)$item['option_id'];
                    }
                }
            }
            
            // Log the data being returned for debugging
            log_message('debug', 'Menu data for bed ' . $bedId . ' on ' . $orderDate . ': ' . json_encode([
                'patientOrderData' => $patientOrderData,
                'hasPublishedMenu' => $hasPublishedMenu,
                'roomServiceEnabled' => $roomServiceEnabled
            ]));
            
            echo json_encode([
                'success' => true,
                'categories' => $categories,
                'menus' => $menus,
                'hasPublishedMenu' => $hasPublishedMenu,
                'savedMenuWithoutOptions' => $savedMenuWithoutOptions,
                'savedMenuWithOptions' => $savedMenuWithOptions,
                'patientOrderData' => $patientOrderData,
                'orderComment' => $orderComment,
                'roomServiceEnabled' => $roomServiceEnabled,
                'allergyCount' => $allergyCount, // 🆕 SPECIAL ITEMS FEATURE
                'hasHighAllergies' => $showSpecialItems // 🆕 SPECIAL ITEMS FEATURE
            ]);
            
        } catch (Exception $e) {
            log_message('error', 'Error in getMenuDataForDate: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error fetching menu data']);
        }
    }
    
    /**
     * AUTO-CLEANUP: Mark discharged patients as inactive
     * 
     * This method automatically marks patients as inactive when their discharge date has passed.
     * It runs on every dashboard load (Nurse/Reception) to ensure real-time accuracy.
     * 
     * MULTI-TENANT SAFE: Works with tenant database automatically via $this->tenantDb
     * 
     * @return void
     */
    private function autoMarkDischargedPatientsInactive() {
        try {
            $today = date('Y-m-d');
            
            // Count how many stale records exist (for logging)
            $this->tenantDb->select('COUNT(*) as stale_count');
            $this->tenantDb->from('people');
            $this->tenantDb->where('status', 1);
            $this->tenantDb->where('date_of_discharge <', $today);
            $this->tenantDb->where('date_of_discharge IS NOT NULL', null, false);
            $countQuery = $this->tenantDb->get();
            
            if ($countQuery && $countQuery->num_rows() > 0) {
                $staleCount = $countQuery->row_array()['stale_count'];
                
                if ($staleCount > 0) {
                    // Log the cleanup action
                    log_message('info', "Auto-Cleanup: Found {$staleCount} patient(s) with past discharge dates. Marking as inactive...");
                    
                    // Get details of patients being updated (for audit trail)
                    $this->tenantDb->select('p.id, p.name, s.bed_no as suite, p.date_of_discharge');
                    $this->tenantDb->from('people p');
                    $this->tenantDb->join('suites s', 's.id = p.suite_number', 'left');
                    $this->tenantDb->where('p.status', 1);
                    $this->tenantDb->where('p.date_of_discharge <', $today);
                    $this->tenantDb->where('p.date_of_discharge IS NOT NULL', null, false);
                    $this->tenantDb->limit(10); // Log first 10 for audit
                    $detailQuery = $this->tenantDb->get();
                    
                    if ($detailQuery && $detailQuery->num_rows() > 0) {
                        $patients = $detailQuery->result_array();
                        foreach ($patients as $patient) {
                            log_message('info', "  - Suite: {$patient['suite']}, Patient: {$patient['name']}, Discharge: {$patient['date_of_discharge']}");
                        }
                    }
                    
                    // Perform the update - mark as inactive
                    $this->tenantDb->set('status', 0);
                    $this->tenantDb->where('status', 1);
                    $this->tenantDb->where('date_of_discharge <', $today);
                    $this->tenantDb->where('date_of_discharge IS NOT NULL', null, false);
                    $updateResult = $this->tenantDb->update('people');
                    
                    if ($updateResult) {
                        $updatedCount = $this->tenantDb->affected_rows();
                        log_message('info', "Auto-Cleanup: Successfully marked {$updatedCount} patient(s) as inactive");
                    } else {
                        log_message('error', "Auto-Cleanup: Failed to update patient records - " . $this->tenantDb->error()['message']);
                    }
                }
            }
            
        } catch (Exception $e) {
            // Don't let cleanup errors break the dashboard
            log_message('error', 'Auto-Cleanup Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Staff Dashboard - Restricted access to Production Form and Today's Labels ONLY
     * For role ID 7 (staff) - emine@bizorder.com.au
     */
    public function dashboardStaff(){
        // Load minimal required data
        $data['greeting'] = 'Welcome';
        $data['user_role'] = 'staff';
        
        // Get all active floors/departments for today's labels
        $conditions = array('is_deleted' => 0, 'listtype' => 'floor');
        $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig', '', $conditions);
        $data['departmentListData'] = $departmentListData;
        
        // Load the restricted staff dashboard view
        $this->load->view('general/header');
        $this->load->view('Dashboard/dashboardStaff', $data);
        $this->load->view('general/footer');
    }
	
}
