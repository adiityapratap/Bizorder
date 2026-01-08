<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Configfoodmenu extends MY_Controller
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
   	public function index(){
   	   
   	      //   $table = 'your_table';
    //     $fields = array('field1', 'field2');
        $conditions = array('location_id' => $this->selected_location_id, 'is_deleted' => 0);
        $orderBy = 'sort_order ASC';
        $conditions['listtype'] = 'category';
        $catListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        $conditions['listtype'] = 'cuisine';
        $cuisineListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        $conditions['listtype'] = 'allergen';
        $allergenListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        $conditions['listtype'] = 'nutrition';
        $nutritionListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        
        $conditions['listtype'] = 'classification';
        $classificationListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        
        $conditions['listtype'] = 'size';
        $sizeListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        
        // $conditions['listtype'] = 'department';
        // $departmentListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $conditions['listtype'] = 'floor'; 
        $floorListData = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions, $orderBy);
        
        // echo "<pre>"; print_r($catListData); exit;
        
        $modulesListData = array(
            'category' => array(
                'label' => 'Menu Category',
                'tableData' => $catListData,
                ),
                
            'cuisine' => array(
                'label' => 'Menu Cuisine',
                'tableData' => $cuisineListData,
                ),
                
            'allergen' => array(
                'label' => 'Allergens',
                'tableData' => $allergenListData,
                ), 
            
            'nutrition' => array(
                'label' => 'Nutrition',
                'tableData' => $nutritionListData,
                ),  
            
             'classification' => array(
                'label' => 'Classification',
                'tableData' => $classificationListData,
                ),
            
             'size' => array(
                'label' => 'Size',
                'tableData' => $sizeListData,
                ), 
                
            // 'department' => array(
            //     'label' => 'Department',
            //     'tableData' => $departmentListData,
            //     ),   
                
            'floor' => array(
                'label' => 'Floor',
                'tableData' => $floorListData,
                ),      
            
            );
        
        $data['modulesInfo']  = $modulesListData;
        if($this->session->userdata('listtype') ==''){
         $data['selectedlisttype'] = 'category';   
        }else{
        $data['selectedlisttype'] = $this->session->userdata('listtype');    
        }
			
		
	
			$this->load->view('general/header');
            $this->load->view('FoodMenuConfig/configList',$data);
            $this->load->view('general/footer');
		}
	public function add(){
			if(isset($this->POST['name'])){
					$category_data = array(
						'name' => $this->POST['name'],
						'listtype' => $this->POST['listtype'],
						'inputType' => $this->POST['inputType'],
						'location_id' => $this->session->userdata('default_location_id'),
						'created_date' => date('Y-m-d'),
					);
		$this->session->set_userdata('listtype', $this->POST['listtype']);
		$result = $this->configfoodmenu_model->addFoodMenuConfig($category_data);
		echo $result;
			}
			
			
		}
	function update_menu_displayStatus(){
	    // ═══════════════════════════════════════════════════════════════════════
	    // LOG MENU DISPLAY STATUS TOGGLE (Show/Hide on Dashboard)
	    // Users might think menus are "deleted" when they're just hidden
	    // ═══════════════════════════════════════════════════════════════════════
	    $menuID = $this->input->post('menuID');
	    $displayStatus = $this->POST['displayOnDashbord'];
	    
	    // Get menu name for better logging
	    $menu = $this->tenantDb->select('name')->where('id', $menuID)->get('menuDetails')->row();
	    $menuName = $menu ? $menu->name : 'Unknown';
	    
	    log_message('info', "👁️ MENU DISPLAY STATUS TOGGLE:");
	    log_message('info', "   Menu ID: {$menuID}");
	    log_message('info', "   Menu Name: {$menuName}");
	    log_message('info', "   New Status: " . ($displayStatus == 1 ? 'SHOWN (visible)' : 'HIDDEN (invisible)'));
	    log_message('info', "   User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
	    log_message('info', "   User ID: " . ($this->session->userdata('user_id') ?: 'UNKNOWN'));
	    log_message('info', "   IP: " . $this->input->ip_address());
	    
	    $menuData['displayOnDashbord'] = $displayStatus;
        $this->common_model->commonRecordUpdate('menuDetails','id', $menuID, $menuData);
        
        log_message('info', "   ✅ Display status updated successfully");
	}
   
    public function updateConfig(){
        $result = $this->configfoodmenu_model->updateMenuConfig($this->POST);
        $this->session->set_userdata('listtype', $this->POST['listtype']);    
		echo 'succcess';
		}
   
    // ═══════════════════════════════════════════════════════════════════════
    // DELETE FUNCTION: Protects menu items, allows floor soft delete
    // - menuDetails (menu items): BLOCKED - use Display On Dashboard toggle
    // - foodmenuconfig (floors/categories/allergens): ALLOWED - soft delete
    // ═══════════════════════════════════════════════════════════════════════
    
    public function delete(){
      $table_name = isset($this->POST['tableName']) ? $this->POST['tableName'] : 'UNKNOWN';
      $record_id = isset($this->POST['id']) ? $this->POST['id'] : 'UNKNOWN';
      $listtype = isset($this->POST['listtype']) ? $this->POST['listtype'] : '';
      
      // ═══════════════════════════════════════════════════════════════════════
      // COMPREHENSIVE DELETION LOGGING
      // ═══════════════════════════════════════════════════════════════════════
      log_message('info', "🗑️ DELETE ATTEMPT:");
      log_message('info', "   Table: {$table_name}");
      log_message('info', "   Record ID: {$record_id}");
      log_message('info', "   List Type: {$listtype}");
      log_message('info', "   User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
      log_message('info', "   User ID: " . ($this->session->userdata('user_id') ?: 'UNKNOWN'));
      log_message('info', "   IP: " . $this->input->ip_address());
      
      // BLOCK deletion of menu items (menuDetails table)
      if ($table_name === 'menuDetails') {
          log_message('error', "🚨 BLOCKED: Menu item deletion attempt!");
          log_message('error', "   ID: {$record_id} | User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
          echo json_encode([
              'status' => 'error', 
              'message' => 'Delete functionality is disabled for menu items. Use "Display On Dashboard" toggle to hide menu items.'
          ]);
          return;
      }
      
      // ALLOW soft delete for foodmenuconfig (floors, categories, allergens)
      if ($table_name === 'foodmenuconfig') {
          // Perform soft delete
          $this->tenantDb->where('id', $record_id);
          $result = $this->tenantDb->update($table_name, array(
              'is_deleted' => 1,
              'updated_date' => date('Y-m-d')
          ));
          
          if ($result) {
              log_message('info', "✅ Soft deleted {$listtype}: ID {$record_id}");
              echo json_encode(['status' => 'success', 'message' => 'Deleted successfully']);
          } else {
              log_message('error', "❌ Failed to delete {$listtype}: ID {$record_id}");
              echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
          }
          return;
      }
      
      // Unknown table
      log_message('error', "❌ Delete attempt on unknown table: {$table_name}");
      echo json_encode(['status' => 'error', 'message' => 'Invalid delete request']);
		}
		
	public function updateSortOrder(){
	 $newOrder = $this->input->post('order');
    // Update the database with the new sort order

    foreach ($newOrder as $index => $itemId) {
        $foodmenuconfigID = substr($itemId, 4);
        $this->tenantDb->set('sort_order', $index + 1);
        $this->tenantDb->where('id', $foodmenuconfigID);
        $this->tenantDb->update('foodmenuconfig');
    }
    echo "success";
	}  
	
	
	
		
    // MENU CREATION ======================================================================== START 	 MENU	  CREATION
    
    public function menus(){
        
        // Fetch only ACTIVE menu items (displayOnDashbord = 1) for main table
        $data['menuLists'] = $this->menu_model->fetchMenuDetails('', true);
        // echo "<pre>"; print_r($data['menuLists']); exit;
       
        $conditions['listtype'] = 'itemtype';
        $data['menutypes']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $conditions['listtype'] = 'category';
        $conditions['is_deleted'] = 0;
        $data['categories']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        // echo "<pre>"; print_r($data['menuLists']); exit;
        
      	$this->load->view('general/header');
        $this->load->view('Menus/listMenu',$data);
        $this->load->view('general/footer');
        
    }
    
    /**
     * AJAX endpoint to fetch INACTIVE menu items (displayOnDashbord = 0)
     * Used for the "View Inactive Items" modal
     */
    public function get_inactive_menus() {
        header('Content-Type: application/json');
        
        try {
            // Fetch INACTIVE menu items using the menu model approach for consistency
            $allMenus = $this->menu_model->fetchMenuDetails('', false); // Get ALL menus
            
            // Filter for inactive items
            $inactiveMenus = [];
            foreach ($allMenus as $menu) {
                if (isset($menu['displayOnDashbord']) && $menu['displayOnDashbord'] == 0) {
                    // Get category names for this menu
                    $categories = [];
                    if (!empty($menu['category_ids'])) {
                        foreach ($menu['category_ids'] as $catId) {
                            $catData = $this->common_model->fetchRecordsDynamically(
                                'foodmenuconfig', 
                                ['name'], 
                                ['id' => $catId, 'listtype' => 'category']
                            );
                            if (!empty($catData)) {
                                $categories[] = $catData[0]['name'];
                            }
                        }
                    }
                    
                    $inactiveMenus[] = [
                        'menu_id' => $menu['menu_id'],
                        'menu_name' => $menu['menu_name'],
                        'inputType' => $menu['inputType'],
                        'displayOnDashbord' => $menu['displayOnDashbord'],
                        'description' => $menu['description'],
                        'categories' => !empty($categories) ? implode(', ', $categories) : 'N/A'
                    ];
                }
            }
            
            echo json_encode([
                'status' => 'success',
                'data' => $inactiveMenus,
                'count' => count($inactiveMenus)
            ]);
        } catch (Exception $e) {
            log_message('error', 'get_inactive_menus error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch inactive menus: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    
    public function manage_menu($id = null) {
      
        
    $data['menu_options'] = $this->menu_model->get_all_menu_options(); 
 
       $categories = $this->input->post('category', TRUE);
        if (!is_array($categories[0])) {
            $categories = !empty($categories) ? explode(',', $categories[0]) : [];
        }
       
        $data['title'] = $id ? 'Edit Menu' : 'Add Menu';
    
        $conditions = array('location_id' => $this->selected_location_id, 'is_deleted' => 0);
        $conditions['listtype'] = 'category';
        $data['categories']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $conditions['listtype'] = 'cuisine';
        $data['cuisines']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $conditions['listtype'] = 'nutrition';
        $data['nutritions']   =  $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $conditions['listtype'] = 'size';
        $data['sizes']   =  $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        $conditions['listtype'] = 'allergen';
        $data['allergens']   =  $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);

    if ($id) {
        $data['menu'] = $this->menu_model->get_menu_details($id);
        $data['menu']['categories'] = $this->menu_model->get_menu_categories($id);
        if (empty($data['menu'])) {
            show_404();
        }
        $data['assigned_options'] = $this->menu_model->get_assigned_menu_options($id);
        // echo "<pre>"; print_r($data['assigned_options']); exit;
    }

    $this->form_validation->set_rules('menuName', 'Menu Name', 'trim|required');
    

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('general/header', $data);
        $this->load->view('Menus/manageMenu', $data);
        $this->load->view('general/footer');
    } else {
      
        // FIX: Remove TRUE to prevent double-encoding of & and other special characters
        // We encode at display time with htmlspecialchars, so don't encode on save
        $menu_data = [
            'name' => $this->security->xss_clean($this->input->post('menuName')),
            'inputType' => $this->input->post('inputType'),
            'cuisine' => $this->input->post('cuisine'),
            'description' => $this->input->post('description'),
            'status' => 1,
            'is_deleted' => 0,
            'date_updated' => date('Y-m-d')
        ];

        if (empty($id)) {
            $menu_data['date_created'] = date('Y-m-d');
        }
        
        // ═══════════════════════════════════════════════════════════════════════
        // LOG MENU SAVE/UPDATE OPERATION
        // ═══════════════════════════════════════════════════════════════════════
        log_message('info', "🍽️ MENU " . ($id ? 'UPDATE' : 'CREATE') . ":");
        log_message('info', "   Menu ID: " . ($id ?: 'NEW'));
        log_message('info', "   Menu Name: " . $menu_data['name']);
        log_message('info', "   Input Type: " . $menu_data['inputType']);
        log_message('info', "   User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
        log_message('info', "   User ID: " . ($this->session->userdata('user_id') ?: 'UNKNOWN'));
        log_message('info', "   IP: " . $this->input->ip_address());
     
        $menu_id = $this->menu_model->save_menu_details($menu_data, $id);

        if ($menu_id) {
            log_message('info', "   ✅ MENU SAVED SUCCESSFULLY: ID={$menu_id}");
            // Deduplicate option ids to avoid duplicate rows
            $option_ids = $this->input->post('menu_options') ?: [];
            if (!is_array($option_ids)) { $option_ids = [$option_ids]; }
            $option_ids = array_values(array_unique(array_filter($option_ids, function($v){return $v !== '' && $v !== null;})));
            $this->menu_model->save_menu_options_relationship($menu_id, $option_ids);
            
            // Save menu-to-category mappings
           // Deduplicate categories to avoid duplicate mappings
           $categories = array_values(array_unique(array_filter($categories, function($v){return $v !== '' && $v !== null;})));
           $this->menu_model->save_menu_categories($menu_id, $categories);
        
            $this->session->set_flashdata('success_msg', 'Menu saved successfully.');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed to save menu.');
        }
        redirect('Orderportal/Configfoodmenu/menus');
    }
}
    


    // Menu Options (List)
    public function menu_options() {
        $data['menu_options'] = $this->menu_model->get_menu_options_list();
        $data['title'] = 'Manage Item Options';
        
        // Fetch all allergens for display
        $conditions['listtype'] = 'allergen';
        $conditions['is_deleted'] = 0;
        $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions);
        
        // Fetch all cuisines for display
        $conditions_cuisine['listtype'] = 'cuisine';
        $conditions_cuisine['is_deleted'] = 0;
        $data['cuisines'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions_cuisine);
        
        $this->load->view('general/header', $data);
        $this->load->view('Menus/menuOptions', $data);
        $this->load->view('general/footer');
    }

    // Menu Options (Add/Edit)
    public function manage_menu_option($id = null) {
        $data['title'] = $id ? 'Edit Item Option' : 'Add Item Option';
        
         $conditions['listtype'] = 'allergen';
         $conditions['is_deleted'] = 0;  // Only show active allergens
         $data['allergies'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions);
    

        if ($id) {
            $data['menu_option'] = $this->menu_model->get_menu_option($id);
            if (empty($data['menu_option'])) {
                show_404();
            }
        }
       $conditions['listtype'] = 'cuisine';
        $data['cuisines']   = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
        
        $this->form_validation->set_rules('menu_option_name', 'Menu Option Name', 'trim|required');
     

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('general/header', $data);
            $this->load->view('Menus/manageMenuOption', $data);
            $this->load->view('general/footer');
            
        } else {
            // ═══════════════════════════════════════════════════════════════════════
            // LOG MENU OPTION SAVE/UPDATE OPERATION
            // Users reporting data loss during menu option creation
            // ═══════════════════════════════════════════════════════════════════════
            $allergies = $this->input->post('allergies');
            $allergies_value = !empty($allergies) ? json_encode($allergies) : json_encode([]);
            
            // Collect cuisines as array (multiple selection)
            $cuisines = $this->input->post('cuisines');
            $cuisines_value = !empty($cuisines) ? json_encode($cuisines) : json_encode([]);
            
            log_message('info', "🔧 MENU OPTION " . ($id ? 'UPDATE' : 'CREATE') . ":");
            log_message('info', "   Option ID: " . ($id ?: 'NEW'));
            log_message('info', "   Option Name: " . $this->input->post('menu_option_name'));
            log_message('info', "   User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
            log_message('info', "   User ID: " . ($this->session->userdata('user_id') ?: 'UNKNOWN'));
            log_message('info', "   IP: " . $this->input->ip_address());
            log_message('info', "   Allergens: " . (empty($allergies) ? 'None' : implode(',', $allergies)));
            log_message('info', "   Cuisines: " . (empty($cuisines) ? 'None' : implode(',', $cuisines)));
            log_message('info', "   Is Special Item: " . ($this->input->post('is_special_item') ? 'YES' : 'NO'));
            
            $option_data = [
                // FIX: Remove TRUE to prevent double-encoding of & and other special characters
                // We encode at display time with htmlspecialchars, so don't encode on save
                'menu_option_name' => $this->security->xss_clean($this->input->post('menu_option_name')),
                'cuisineValues' => $cuisines_value, // Store multiple cuisines as JSON
                'description' => $this->input->post('description'),
                'nutritionValues' => $this->input->post('nutritionValues'),
                'allergenValues' => $allergies_value,
                'location_id' => $this->selected_location_id,
                'status' => 1,
                'is_deleted' => 0,
                'nutritionPerServing' => $this->input->post('nutritionPerServing') ?? NULL,
                'nutritionPerGram' => $this->input->post('nutritionPerGram') ?? NULL,
                'prices' => $this->input->post('prices') ?? NULL,
                'classification' => $this->input->post('classification') ?? NULL,
                'displayOnDashbord' => $this->input->post('displayOnDashbord') ?? 0,
                'sort_order' => $this->input->post('sort_order') ?? 0,
                'is_special_item' => $this->input->post('is_special_item') ? 1 : 0, // 🆕 SPECIAL ITEMS FEATURE
                'date_updated' => date('Y-m-d')
            ];

            if (empty($id)) {
                $option_data['date_created'] = date('Y-m-d H:i:s');
            }

            $option_id = $this->menu_model->save_menu_option($option_data, $id);
            if ($option_id) {
                log_message('info', "   ✅ MENU OPTION SAVED SUCCESSFULLY: ID={$option_id}");
                $this->session->set_flashdata('success_msg', 'Menu option saved successfully.');
            } else {
                log_message('error', "   ❌ MENU OPTION SAVE FAILED: ID=" . ($id ?: 'NEW'));
                $this->session->set_flashdata('error_msg', 'Failed to save menu option.');
            }
            redirect('Orderportal/Configfoodmenu/menu_options');
        }
    }

    // Delete Menu Option
    public function delete_menu_option($id) {
        // ═══════════════════════════════════════════════════════════════════════
        // LOG MENU OPTION DELETION
        // ═══════════════════════════════════════════════════════════════════════
        
        // Get option name before deletion
        $option = $this->menu_model->get_menu_option($id);
        $optionName = $option ? $option['menu_option_name'] : 'Unknown';
        
        log_message('info', "🗑️ MENU OPTION DELETE ATTEMPT:");
        log_message('info', "   Option ID: {$id}");
        log_message('info', "   Option Name: {$optionName}");
        log_message('info', "   User: " . ($this->session->userdata('username') ?: 'UNKNOWN'));
        log_message('info', "   User ID: " . ($this->session->userdata('user_id') ?: 'UNKNOWN'));
        log_message('info', "   IP: " . $this->input->ip_address());
        
        if ($this->menu_model->delete_menu_option($id)) {
            log_message('info', "   ✅ MENU OPTION DELETED SUCCESSFULLY");
            $this->session->set_flashdata('success_msg', 'Menu option deleted successfully.');
        } else {
            log_message('error', "   ❌ MENU OPTION DELETE FAILED");
            $this->session->set_flashdata('error_msg', 'Failed to delete menu option.');
        }
        redirect('Orderportal/Configfoodmenu/menu_options');
    }
	
	public function updateMenuSortOrder(){
	 $newOrder = $this->input->post('order');
    // Update the database with the new sort order

    foreach ($newOrder as $index => $itemId) {
        $foodmenuconfigID = substr($itemId, 4);
        $this->tenantDb->set('sort_order', $index + 1);
        $this->tenantDb->where('id', $foodmenuconfigID);
        $this->tenantDb->update('menuDetails');
    }
    echo "success";
	}  
	  
    function downloadMenu() {
        // Fetch all menu data with options and categories (same as UI uses)
        $allMenus = $this->menu_model->fetchMenuDetails();

        // Fetch all categories to keep the UI order
        $conditions = array('listtype' => 'category', 'is_deleted' => 0);
        $orderBy = 'sort_order ASC';
        $categories = $this->common_model->fetchRecordsDynamically('foodmenuconfig', ['id','name'],$conditions, $orderBy);

        // Build category id -> name map
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat['id']] = $cat['name'];
        }

        // Group menus by category id(s) like the UI
        $menusByCategory = [];
        foreach ($allMenus as $menu) {
            $menuCategories = $menu['category_ids'] ?? [];
            if (empty($menuCategories)) {
                // Put menus with no category under 0
                $menusByCategory[0][] = $menu;
            } else {
                foreach ($menuCategories as $catId) {
                    $menusByCategory[$catId][] = $menu;
                }
            }
        }

        // Create spreadsheet in the same layout as the UI table
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Menus');

        // Header row like the UI
        $sheet->setCellValue('A1', 'Item Name');
        $sheet->setCellValue('B1', 'Item Options');
        $sheet->setCellValue('C1', 'Display On Dashboard');

        // Auto-size
        foreach (['A','B','C'] as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row = 2;

        // Iterate categories in UI order
        foreach ($categories as $cat) {
            $catId = $cat['id'];
            if (empty($menusByCategory[$catId])) {
                continue; // no menus in this category
            }

            // Category header row (merged)
            $sheet->mergeCells("A{$row}:C{$row}");
            $sheet->setCellValue("A{$row}", strtoupper($cat['name']));
            // simple styling
            $sheet->getStyle("A{$row}")->getFont()->setBold(true);
            $row++;

            // Menus inside this category
            foreach ($menusByCategory[$catId] as $menu) {
                $sheet->setCellValue("A{$row}", $menu['menu_name']);

                // Join option names in the same way they’re displayed
                $options = [];
                if (!empty($menu['menu_options'])) {
                    foreach ($menu['menu_options'] as $opt) {
                        if (!empty($opt['menu_option_name'])) {
                            $options[] = $opt['menu_option_name'];
                        }
                    }
                }
                $sheet->setCellValue("B{$row}", implode(', ', $options));

                $sheet->setCellValue("C{$row}", ((int)($menu['displayOnDashbord'] ?? 0) === 1) ? 'Yes' : 'No');

                $row++;
            }

            // Blank spacer row between categories
            $row++;
        }

        // If there were menus with no category (0), append them at the end
        if (!empty($menusByCategory[0])) {
            $sheet->mergeCells("A{$row}:C{$row}");
            $sheet->setCellValue("A{$row}", 'UNCATEGORIZED');
            $sheet->getStyle("A{$row}")->getFont()->setBold(true);
            $row++;
            foreach ($menusByCategory[0] as $menu) {
                $sheet->setCellValue("A{$row}", $menu['menu_name']);
                $options = [];
                if (!empty($menu['menu_options'])) {
                    foreach ($menu['menu_options'] as $opt) {
                        if (!empty($opt['menu_option_name'])) {
                            $options[] = $opt['menu_option_name'];
                        }
                    }
                }
                $sheet->setCellValue("B{$row}", implode(', ', $options));
                $sheet->setCellValue("C{$row}", ((int)($menu['displayOnDashbord'] ?? 0) === 1) ? 'Yes' : 'No');
                $row++;
            }
        }

        // Output the Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="menus_with_options.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    



}
