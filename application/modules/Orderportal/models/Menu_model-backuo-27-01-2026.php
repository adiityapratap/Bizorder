<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends CI_Model{
	
    protected $menuDetailsTable = 'menuDetails';
    protected $suitesTable = 'suites';
    protected $clientsTable = 'people';
    protected $menuOptionsTable = 'menu_options';
    protected $menuDetailsToOptionsTable = 'menu_details_to_menu_options';
    protected $foodMenuConfigTable = 'foodmenuconfig';
    private $menuToCategoryTable = 'menu_to_category';
    protected $menuPlannerTable = 'menuPlanner';
    
	function __construct() {
		parent::__construct();
		$this->load->helper('custom'); // Load custom helper for Australia timezone functions
	}
   public function fetchAllBedDetails($show_deleted = false){
     // Use DISTINCT to prevent duplicate suite records
     $this->tenantDb->distinct();
     $this->tenantDb->select('s.bed_no, s.floor, s.is_vaccant, s.id as suite_id, s.is_deleted, p.name as patient_name');
     $this->tenantDb->from($this->suitesTable . ' as s');
     $this->tenantDb->join('people as p', 's.id = p.suite_number AND (p.date_of_discharge IS NULL OR p.date_of_discharge >= CURDATE()) AND p.status = 1', 'left');
     $this->tenantDb->where('s.status', 1);

     if ($show_deleted) {
         // Show only deleted suites
         $this->tenantDb->where('s.is_deleted', 1);
     } else {
         // Show only active suites (default)
         $this->tenantDb->where('(s.is_deleted IS NULL OR s.is_deleted = 0)');
     }

     // Order by suite number for consistent display
     $this->tenantDb->order_by('s.bed_no', 'ASC');

     $query = $this->tenantDb->get();
     return $query->result_array();
}

public function fetchMenuDetails($fetchAllColumns = '', $isDashboard = false) {
    // Check if cuisineValues column exists
    $cuisineValuesColumn = '';
    try {
        $columns = $this->tenantDb->query("SHOW COLUMNS FROM `{$this->menuOptionsTable}` LIKE 'cuisineValues'")->result();
        if (!empty($columns)) {
            $cuisineValuesColumn = 'mo.cuisineValues';
        } else {
            // Column doesn't exist, use NULL or fallback to old cuisine column
            $cuisineValuesColumn = 'NULL';
        }
    } catch (Exception $e) {
        // On error, default to NULL
        $cuisineValuesColumn = 'NULL';
    }
    
    if ($fetchAllColumns == '') {
        $this->tenantDb->select('
            md.id AS menu_id,
            md.name AS menu_name,
            md.is_single_select AS is_single_select,
            md.is_main_menu AS is_main_menu,
            md.inputType,
            md.nutritionValues,
            md.nutritionPerServing,
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    "option_id", mo.id,
                    "menu_option_name", mo.menu_option_name,
                    "menu_option_calorie", mo.nutritionValues,
                    "menu_option_description", mo.description,
                    "allergenValues", mo.allergenValues,
                    "cuisineValues", ' . $cuisineValuesColumn . ',
                    "is_special_item", mo.is_special_item
                )
            ) AS menu_options,
            md.displayOnDashbord AS displayOnDashbord,
            md.description AS description,
            GROUP_CONCAT(DISTINCT fc1.id ORDER BY fc1.sort_order) AS category_ids,
            fc2.name AS cuisine_type,
            fc3.name AS diet_type
        ');
    } else {
        $this->tenantDb->select('
            md.*,
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    "option_id", mo.id,
                    "menu_option_name", mo.menu_option_name,
                    "menu_option_calorie", mo.nutritionValues,
                    "menu_option_description", mo.description,
                    "allergenValues", mo.allergenValues,
                    "cuisineValues", ' . $cuisineValuesColumn . ',
                    "is_special_item", mo.is_special_item
                )
            ) AS menu_options,
            GROUP_CONCAT(DISTINCT fc1.id ORDER BY fc1.sort_order) AS category_ids,
            fc2.name AS cuisine_type,
            fc3.name AS diet_type
        ');
    }

    $this->tenantDb->from("{$this->menuDetailsTable} md");

    // Join for categories
    $this->tenantDb->join("{$this->menuToCategoryTable} mtc", 'mtc.menu_id = md.id', 'left');
    $this->tenantDb->join("{$this->foodMenuConfigTable} fc1", 'mtc.category_id = fc1.id AND fc1.listtype = "category"', 'left');

    // Join for menu options
    $this->tenantDb->join("{$this->menuDetailsToOptionsTable} mdto", 'mdto.main_menu_id = md.id', 'left');
    
    $this->tenantDb->join("{$this->menuOptionsTable} mo", 'mdto.menu_option_id = mo.id AND mo.status = 1 AND mo.is_deleted = 0', 'left');
   
    // Join for cuisine
    $this->tenantDb->join("{$this->foodMenuConfigTable} fc2", 'md.cuisine = fc2.id AND fc2.listtype = "cuisine"', 'left');
    
    // Join for diet/nutrition type
    $this->tenantDb->join("{$this->foodMenuConfigTable} fc3", 'md.classification = fc3.id AND fc3.listtype = "nutrition"', 'left');

   
   
   
 
   // uncomment original code condition on 27th on new menu entry is done
  
  if ($isDashboard) {
        $this->tenantDb->where('md.displayOnDashbord', 1);
    }
 
  $this->tenantDb->where('md.status', 1); 
    
    
    
    
    
    $this->tenantDb->where('md.is_deleted', 0);

    $this->tenantDb->group_by('md.id');
    $this->tenantDb->order_by('md.sort_order', 'ASC');

    $query = $this->tenantDb->get();
    $results = $query->result_array();
// echo $this->tenantDb->last_query();
// exit;
    $finalResult = [];
    foreach ($results as $row) {
        // Deduplicate menu options by option_id to avoid duplicates caused by joins across categories
        $decodedOptions = !empty($row['menu_options']) ? json_decode($row['menu_options'], true) : [];
        $uniqueOptionsMap = [];
        if (is_array($decodedOptions)) {
            foreach ($decodedOptions as $opt) {
                if (!isset($opt['option_id'])) { continue; }
                $uniqueOptionsMap[$opt['option_id']] = $opt;
            }
        }
        $uniqueOptions = array_values($uniqueOptionsMap);

        $finalResult[] = [
            'menu_id' => $row['menu_id'],
            'menu_name' => $row['menu_name'],
            'inputType' => $row['inputType'],
            'is_single_select' => $row['is_single_select'],
            'is_main_menu' => $row['is_main_menu'],
            'displayOnDashbord' => $row['displayOnDashbord'],
            'description' => $row['description'],
            'category_ids' => !empty($row['category_ids']) ? explode(',', $row['category_ids']) : [],
            'cuisine_type' => $row['cuisine_type'],
            'diet_type' => $row['diet_type'] ?? 'N/A',
            'calories' => $row['nutritionValues'] ?? 'N/A',
            'nutritionPerServing' => $row['nutritionPerServing'] ?? 'N/A',
            'menu_options' => $uniqueOptions
        ];
    }

    return $finalResult;
}





public function get_all_menu_options() {
    $this->tenantDb->select('id, menu_option_name, prices,nutritionValues, status, is_deleted');
    $this->tenantDb->from('menu_options mo');
    $this->tenantDb->where('status', 1);
    $this->tenantDb->where('is_deleted', 0);
    $query = $this->tenantDb->get();
    return $query->result_array();
}
	 
	

    // Get menu details by ID
    public function get_menu_details($id) {
        $this->tenantDb->where('id', $id);
        $this->tenantDb->where('status', 1);
        $this->tenantDb->where('is_deleted', 0);
        $query = $this->tenantDb->get($this->menuDetailsTable);
        return $query->row_array();
    }

    // Get menu options assigned to a specific menu
    public function get_assigned_menu_options($menuId) {
        $this->tenantDb->select('mdo.menu_option_id, mo.menu_option_name, mo.nutritionValues,mo.prices');
        $this->tenantDb->from("{$this->menuDetailsToOptionsTable} as mdo");
        $this->tenantDb->join("{$this->menuOptionsTable} as mo", 'mdo.menu_option_id = mo.id', 'left');
        $this->tenantDb->where('mdo.main_menu_id', $menuId);
        $this->tenantDb->where('mo.status', 1);
        $this->tenantDb->where('mo.is_deleted', 0);
        $query = $this->tenantDb->get();
        return $query->result_array();
    }

    // Save or update menu details
    public function save_menu_details($data, $id = null) {
        if ($id) {
            $this->tenantDb->where('id', $id);
            $this->tenantDb->update($this->menuDetailsTable, $data);
            return $id;
        } else {
            $this->tenantDb->insert($this->menuDetailsTable, $data);
            return $this->tenantDb->insert_id();
        }
    }

    // Save menu details to menu options relationship
    public function save_menu_options_relationship($menuId, $optionIds) {
        $this->tenantDb->where('main_menu_id', $menuId);
        $this->tenantDb->delete($this->menuDetailsToOptionsTable);

        if (!empty($optionIds) && is_array($optionIds)) {
            $uniqueIds = array_values(array_unique(array_filter($optionIds, function($v){return is_numeric($v);}))); 
            if (!empty($uniqueIds)) {
                $data = array_map(function($optionId) use ($menuId) {
                    return ['main_menu_id' => $menuId, 'menu_option_id' => (int)$optionId];
                }, $uniqueIds);
                $this->tenantDb->insert_batch($this->menuDetailsToOptionsTable, $data);
            }
        }
    }

    // Get all menu options for listing
    public function get_menu_options_list() {
        // $this->tenantDb->select('id, menu_option_name,cuisine, nutritionValues, status, date_created');
        // $this->tenantDb->where('is_deleted', 0);
        // $query = $this->tenantDb->get($this->menuOptionsTable);
        // return $query->result_array();
        
        $this->tenantDb->select('md.id, md.menu_option_name, md.cuisine, md.cuisineValues, fc2.name AS cuisine_name, md.nutritionValues, md.status, md.date_created, md.allergenValues, md.is_special_item');
$this->tenantDb->from("{$this->menuOptionsTable} md");
$this->tenantDb->join("{$this->foodMenuConfigTable} fc2", 'md.cuisine = fc2.id AND fc2.listtype = "cuisine"', 'left');
$this->tenantDb->where('md.is_deleted', 0);
$this->tenantDb->where('md.status', 1);
$query = $this->tenantDb->get();
return $query->result_array();

    }

    // Get menu option by ID
    public function get_menu_option($id) {
        $this->tenantDb->where('id', $id);
        $this->tenantDb->where('is_deleted', 0);
        $query = $this->tenantDb->get($this->menuOptionsTable);
        return $query->row_array();
    }

    // Save or update menu option
    public function save_menu_option($data, $id = null) {
        // ═══════════════════════════════════════════════════════════════════════
        // COMPREHENSIVE LOGGING: Track all menu_options changes for audit trail
        // ═══════════════════════════════════════════════════════════════════════
        
        // SAFETY CHECK: Ensure status is explicitly set to prevent accidental disabling
        if (!isset($data['status'])) {
            $data['status'] = 1; // Default to enabled if not specified
            log_message('warning', '⚠️ Menu option status was not set, defaulting to 1 (enabled)');
        }
        
        // Get existing data for comparison (if updating)
        $old_data = null;
        if ($id) {
            $this->tenantDb->where('id', $id);
            $old_data = $this->tenantDb->get($this->menuOptionsTable)->row_array();
        }
        
        // Log the operation
        if ($id) {
            // UPDATE operation
            log_message('info', "📝 MENU OPTION UPDATE:");
            log_message('info', "   Option ID: {$id}");
            log_message('info', "   Option Name: " . ($data['menu_option_name'] ?? 'N/A'));
            
            // CRITICAL: Alert if status is being changed
            if ($old_data && isset($old_data['status']) && isset($data['status'])) {
                if ($old_data['status'] != $data['status']) {
                    $old_status = $old_data['status'] == 1 ? 'ENABLED' : 'DISABLED';
                    $new_status = $data['status'] == 1 ? 'ENABLED' : 'DISABLED';
                    log_message('warning', "   🚨 STATUS CHANGE: {$old_status} → {$new_status}");
                    
                    // ALERT: If being disabled
                    if ($data['status'] == 0) {
                        log_message('error', "   ⚠️ ALERT: Menu option is being DISABLED!");
                    }
                }
            }
            
            $this->tenantDb->where('id', $id);
            $this->tenantDb->update($this->menuOptionsTable, $data);
            $affected = $this->tenantDb->affected_rows();
            
            if ($affected > 0) {
                log_message('info', "   ✅ UPDATE SUCCESS: {$affected} row(s) affected");
            } else {
                log_message('info', "   ℹ️ No changes detected");
            }
            
            return $affected > 0 ? $id : false;
        } else {
            // INSERT operation
            log_message('info', "➕ MENU OPTION CREATE:");
            log_message('info', "   Option Name: " . ($data['menu_option_name'] ?? 'N/A'));
            log_message('info', "   Status: " . ($data['status'] == 1 ? 'ENABLED' : 'DISABLED'));
            
            $this->tenantDb->insert($this->menuOptionsTable, $data);
            $insert_id = $this->tenantDb->insert_id();
            
            if ($insert_id) {
                log_message('info', "   ✅ CREATE SUCCESS: New ID = {$insert_id}");
            } else {
                log_message('error', "   ❌ CREATE FAILED");
            }
            
            return $insert_id;
        }
    }

    // Delete menu option (soft delete)
    public function delete_menu_option($id) {
        // Get option details before deleting for audit trail
        $this->tenantDb->where('id', $id);
        $option = $this->tenantDb->get($this->menuOptionsTable)->row_array();
        
        if ($option) {
            log_message('warning', "🗑️ MENU OPTION SOFT DELETE:");
            log_message('warning', "   Option ID: {$id}");
            log_message('warning', "   Option Name: " . ($option['menu_option_name'] ?? 'N/A'));
            log_message('warning', "   Previous Status: " . ($option['status'] == 1 ? 'ENABLED' : 'DISABLED'));
        }
        
        $data = ['is_deleted' => 1, 'date_updated' => australia_datetime()];
        $this->tenantDb->where('id', $id);
        $this->tenantDb->update($this->menuOptionsTable, $data);
        $affected = $this->tenantDb->affected_rows() > 0;
        
        if ($affected) {
            log_message('warning', "   ✅ SOFT DELETE SUCCESS");
        } else {
            log_message('error', "   ❌ SOFT DELETE FAILED - No rows affected");
        }
        
        return $affected;
    }	
    
     // Save menu-to-category mappings
    public function save_menu_categories($menu_id, $category_ids) {
        // Delete existing mappings for this menu
        $this->tenantDb->where('menu_id', $menu_id);
        $this->tenantDb->delete($this->menuToCategoryTable);

        // Insert new mappings
        if (!empty($category_ids)) {
            $uniqueCats = array_values(array_unique(array_filter($category_ids, function($v){return is_numeric($v);}))); 
            if (!empty($uniqueCats)) {
                $data = [];
                foreach ($uniqueCats as $category_id) {
                    $data[] = [
                        'menu_id' => $menu_id,
                        'category_id' => (int)$category_id
                    ];
                }
                $this->tenantDb->insert_batch($this->menuToCategoryTable, $data);
            }
        }
    }

    // Get categories for a menu (for edit form)
    public function get_menu_categories($menu_id) {
        $this->tenantDb->select('category_id');
        $this->tenantDb->where('menu_id', $menu_id);
        $query = $this->tenantDb->get($this->menuToCategoryTable);
        return array_column($query->result_array(), 'category_id');
    }
    
    // for menu planner
    
     public function get_menu_data() {
        // Fetch your menu data (example implementation)
        // This should return the array structure you provided
        // You might need to adjust based on your database schema
        $query = $this->tenantDb->get('menuDetails'); // Assuming a menus table
        $menus = $query->result_array();

        $menu_data = [];
        foreach ($menus as $menu) {
            $section = $menu['section']; // e.g., 'Breakfast 6 AM'
            if (!isset($menu_data[$section])) {
                $menu_data[$section] = [];
            }

            $options = $this->get_assigned_menu_options($menu['id']);
            $menu_item = [
                'menu_name' => $menu['name'],
                'displayOnDashboard' => $menu['display_on_dashboard'],
                'menu_id' => $menu['id'],
                'description' => $menu['description'],
                'cuisine_type' => $menu['cuisine_type'],
                'menu_type' => $menu['menu_type'],
                'menu_options' => []
            ];

            foreach ($options as $option) {
                $menu_item['menu_options'][] = [
                    'menu_option_name' => $option['menu_option_name'],
                    'option_id' => $option['menu_option_id']
                ];
            }

            $menu_data[$section][] = $menu_item;
        }

        return $menu_data;
    }


	
}