<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends CI_Model{
	
    protected $menuDetailsTable = 'menuDetails';
    protected $menuOptionsTable = 'menu_options';
    protected $menuDetailsToOptionsTable = 'menu_details_to_menu_options';
    protected $foodMenuConfigTable = 'foodmenuconfig';
    private $menuToCategoryTable = 'menu_to_category';
    
	function __construct() {
		parent::__construct();
	}
//  commented on 12-07-2025
	
// 	 public function fetchMenuDetails($fetchAllColumns='',$isDashboard=false){
// 	     if($fetchAllColumns == ''){
// 	      $this->tenantDb->select('
//         md.name AS menu_name,
//         mdo.menu_option_name,
//         mdo.id as option_id,
//         md.displayOnDashbord AS displayOnDashbord,
//         md.id AS menu_id,
//         md.description AS description,
//         fc1.name AS category_name,
//         fc1.id AS category_id,
//         fc2.name AS cuisine_type,
//         fc3.name AS menu_type,
//          fc3.sort_order AS menu_type_sort_order
//     ');   
// 	     }else{
// 	      $this->tenantDb->select('
//         md.*,
//         mdo.menu_option_name,
//         mdo.id as option_id,
//         fc1.name AS category_name,
//         fc1.id AS category_id,
//         fc2.name AS cuisine_type,
//         fc3.name AS menu_type,
//          fc3.sort_order AS menu_type_sort_order
//     ');        
// 	     }
	   
//     $this->tenantDb->from('menuDetails md');

//     // Join for category
//     $this->tenantDb->join('foodmenuconfig fc1', 'md.category = fc1.id AND fc1.listtype = "category"', 'left');
    
//     // Join for menu option
//     $this->tenantDb->join('menu_details_to_menu_options mdo', 'mdo.menu_detail_id = md.id', 'left');
    
//     // Join for cuisine
//     $this->tenantDb->join('foodmenuconfig fc2', 'md.cuisine = fc2.id AND fc2.listtype = "cuisine"', 'left');
    
//     // Join for menu type
//     $this->tenantDb->join('foodmenuconfig fc3', 'md.menuType = fc3.id AND fc3.listtype = "itemtype"', 'left');
    
//     if($isDashboard){
//      $this->tenantDb->where('md.displayOnDashbord', 1);    
//     }
//     $this->tenantDb->order_by('fc1.sort_order', 'ASC');
//   $this->tenantDb->order_by('md.sort_order', 'ASC');

//     // Execute the query and get the result
//     $query = $this->tenantDb->get();
    
//     // Return the result as an array
//     $results =  $query->result_array();
    
//     // below code is to get the options details for menus
    
//     $grouped = [];

// foreach ($results as $row) {
//     $menuId = $row['menu_id'];

//     // If this menu_id not yet added, initialize it
//     if (!isset($grouped[$menuId])) {
//         $grouped[$menuId] = [
//             'menu_id' => $row['menu_id'],
//             'menu_name' => $row['menu_name'],
//             'displayOnDashbord' => $row['displayOnDashbord'],
//             'description' => $row['description'],
//             'category_name' => $row['category_name'],
//             'category_id' => $row['category_id'],
//             'cuisine_type' => $row['cuisine_type'],
//             'menu_type' => $row['menu_type'],
//             'menu_type_sort_order' => $row['menu_type_sort_order'],
//             'menu_options' => []
//         ];
//     }

//     // If there's an option, add it
//     if (!empty($row['menu_option_name'])) {
//         $grouped[$menuId]['menu_options'][] = [
//             'menu_option_name' => $row['menu_option_name'],
//             'option_id' => $row['option_id']
//         ];
//     }
// }

// // Reindex the result if you want a simple indexed array
// $finalResult = array_values($grouped);

// return $finalResult;

// 		}

// comented on 17-06-2025
// public function fetchMenuDetails($fetchAllColumns = '', $isDashboard = false) {
//         if ($fetchAllColumns == '') {
//             $this->tenantDb->select('
//                 md.id AS menu_id,
//                 md.name AS menu_name,
//                 mo.menu_option_name,
//                 mo.id AS option_id,
//                 md.displayOnDashbord AS displayOnDashbord,
//                 md.description AS description,
//                 fc1.name AS category_name,
//                 fc1.id AS category_id,
//                 fc2.name AS cuisine_type,
//                 fc3.name AS menu_type,
//                 fc3.sort_order AS menu_type_sort_order
//             ');
//         } else {
//             $this->tenantDb->select('
//                 md.*,
//                 mo.menu_option_name,
//                 mo.id AS option_id,
//                 fc1.name AS category_name,
//                 fc1.id AS category_id,
//                 fc2.name AS cuisine_type,
//                 fc3.name AS menu_type,
//                 fc3.sort_order AS menu_type_sort_order
//             ');
//         }

//         $this->tenantDb->from("{$this->menuDetailsTable} md");

//         // Join for category
//         $this->tenantDb->join("{$this->foodMenuConfigTable} fc1", 'md.category = fc1.id AND fc1.listtype = "category"', 'left');

//         // Join for menu options via menu_details_to_menu_options
//         $this->tenantDb->join("{$this->menuDetailsToOptionsTable} mdto", 'mdto.main_menu_id = md.id', 'left');
//         $this->tenantDb->join("{$this->menuOptionsTable} mo", 'mdto.menu_option_id = mo.id AND mo.status = 1 AND mo.is_deleted = 0', 'left');

//         // Join for cuisine
//         $this->tenantDb->join("{$this->foodMenuConfigTable} fc2", 'md.cuisine = fc2.id AND fc2.listtype = "cuisine"', 'left');

//         // Join for menu type
//         $this->tenantDb->join("{$this->foodMenuConfigTable} fc3", 'md.menuType = fc3.id AND fc3.listtype = "itemtype"', 'left');

//         if ($isDashboard) {
//             $this->tenantDb->where('md.displayOnDashbord', 1);
//         }

//         $this->tenantDb->where('md.status', 1);
//         $this->tenantDb->where('md.is_deleted', 0);
//         $this->tenantDb->order_by('fc1.sort_order', 'ASC');
//         $this->tenantDb->order_by('md.sort_order', 'ASC');

//         // Execute the query and get the result
//         $query = $this->tenantDb->get();

//         // Return the result as an array
//         $results = $query->result_array();

//         // Group the results to associate menu options with menus
//         $grouped = [];

//         foreach ($results as $row) {
//             $menuId = $row['menu_id'];

//             // If this menu_id not yet added, initialize it
//             if (!isset($grouped[$menuId])) {
//                 $grouped[$menuId] = [
//                     'menu_id' => $row['menu_id'],
//                     'menu_name' => $row['menu_name'],
//                     'displayOnDashbord' => $row['displayOnDashbord'],
//                     'description' => $row['description'],
//                     'category_name' => $row['category_name'],
//                     'category_id' => $row['category_id'],
//                     'cuisine_type' => $row['cuisine_type'],
//                     'menu_type' => $row['menu_type'],
//                     'menu_type_sort_order' => $row['menu_type_sort_order'],
//                     'menu_options' => []
//                 ];
//             }

//             // If there's an option, add it
//             if (!empty($row['menu_option_name'])) {
//                 $grouped[$menuId]['menu_options'][] = [
//                     'menu_option_name' => $row['menu_option_name'],
//                     'option_id' => $row['option_id']
//                 ];
//             }
//         }

//         // Reindex the result if you want a simple indexed array
//         $finalResult = array_values($grouped);

//         return $finalResult;
//     }


 public function fetchMenuDetails($fetchAllColumns = '', $isDashboard = false) {
        if ($fetchAllColumns == '') {
            $this->tenantDb->select('
                md.id AS menu_id,
                md.name AS menu_name,
                mo.menu_option_name,
                mo.id AS option_id,
                md.displayOnDashbord AS displayOnDashbord,
                md.description AS description,
                GROUP_CONCAT(fc1.id ORDER BY fc1.sort_order) AS category_ids,
                fc2.name AS cuisine_type,
                fc3.name AS menu_type,
                fc3.sort_order AS menu_type_sort_order
            ');
        } else {
            $this->tenantDb->select('
                md.*,
                mo.menu_option_name,
                mo.id AS option_id,
                GROUP_CONCAT(fc1.id ORDER BY fc1.sort_order) AS category_ids,
                fc2.name AS cuisine_type,
                fc3.name AS menu_type,
                fc3.sort_order AS menu_type_sort_order
            ');
        }

        $this->tenantDb->from("{$this->menuDetailsTable} md");

        // Join for categories via menu_to_category
        $this->tenantDb->join("{$this->menuToCategoryTable} mtc", 'mtc.menu_id = md.id', 'left');
        $this->tenantDb->join("{$this->foodMenuConfigTable} fc1", 'mtc.category_id = fc1.id AND fc1.listtype = "category"', 'left');

        // Join for menu options via menu_details_to_menu_options
        $this->tenantDb->join("{$this->menuDetailsToOptionsTable} mdto", 'mdto.main_menu_id = md.id', 'left');
        $this->tenantDb->join("{$this->menuOptionsTable} mo", 'mdto.menu_option_id = mo.id AND mo.status = 1 AND mo.is_deleted = 0', 'left');

        // Join for cuisine
        $this->tenantDb->join("{$this->foodMenuConfigTable} fc2", 'md.cuisine = fc2.id AND fc2.listtype = "cuisine"', 'left');

        // Join for menu type
        $this->tenantDb->join("{$this->foodMenuConfigTable} fc3", 'md.menuType = fc3.id AND fc3.listtype = "itemtype"', 'left');

        if ($isDashboard) {
            $this->tenantDb->where('md.displayOnDashbord', 1);
        }

        $this->tenantDb->where('md.status', 1);
        $this->tenantDb->where('md.is_deleted', 0);

        // Group by menu_id to aggregate categories
        $this->tenantDb->group_by('md.id');

        // Order by category sort order and menu sort order
        $this->tenantDb->order_by('md.sort_order', 'ASC');

        // Execute the query
        $query = $this->tenantDb->get();

        // Return the result as an array
        $results = $query->result_array();

        // Group the results to associate menu options and categories with menus
        $grouped = [];
        

        foreach ($results as $row) {
            $menuId = $row['menu_id'];

            // If this menu_id not yet added, initialize it
            if (!isset($grouped[$menuId])) {
                // Split category names and IDs into arrays
               
                $category_ids = !empty($row['category_ids']) ? explode(',', $row['category_ids']) : [];

                $grouped[$menuId] = [
                    'menu_id' => $row['menu_id'],
                    'menu_name' => $row['menu_name'],
                    'displayOnDashbord' => $row['displayOnDashbord'],
                    'description' => $row['description'],
                    'category_ids' => $category_ids,
                    'cuisine_type' => $row['cuisine_type'],
                    'menu_type' => $row['menu_type'],
                    'menu_type_sort_order' => $row['menu_type_sort_order'],
                    'menu_options' => []
                ];
            }

            // If there's an option, add it
            if (!empty($row['menu_option_name'])) {
                $grouped[$menuId]['menu_options'][] = [
                    'menu_option_name' => $row['menu_option_name'],
                    'option_id' => $row['option_id']
                ];
            }
        }

        // Reindex the result to return a simple indexed array
        $finalResult = array_values($grouped);
// echo "<pre>"; print_r($finalResult); exit;
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
            $data = array_map(function($optionId) use ($menuId) {
                return ['main_menu_id' => $menuId, 'menu_option_id' => $optionId];
            }, $optionIds);
            $this->tenantDb->insert_batch($this->menuDetailsToOptionsTable, $data);
        }
    }

    // Get all menu options for listing
    public function get_menu_options_list() {
        $this->tenantDb->select('id, menu_option_name, nutritionValues, status, date_created');
        $this->tenantDb->where('is_deleted', 0);
        $query = $this->tenantDb->get($this->menuOptionsTable);
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
        if ($id) {
            $this->tenantDb->where('id', $id);
            $this->tenantDb->update($this->menuOptionsTable, $data);
            return $this->tenantDb->affected_rows() > 0 ? $id : false;
        } else {
            $this->tenantDb->insert($this->menuOptionsTable, $data);
            return $this->tenantDb->insert_id();
        }
    }

    // Delete menu option (soft delete)
    public function delete_menu_option($id) {
        $data = ['is_deleted' => 1, 'date_updated' => date('Y-m-d H:i:s')];
        $this->tenantDb->where('id', $id);
        $this->tenantDb->update($this->menuOptionsTable, $data);
        return $this->tenantDb->affected_rows() > 0;
    }	
    
     // Save menu-to-category mappings
    public function save_menu_categories($menu_id, $category_ids) {
        // Delete existing mappings for this menu
        $this->tenantDb->where('menu_id', $menu_id);
        $this->tenantDb->delete($this->menuToCategoryTable);

        // Insert new mappings
        if (!empty($category_ids)) {
            $data = [];
            foreach ($category_ids as $category_id) {
                if (!empty($category_id)) {
                    $data[] = [
                        'menu_id' => $menu_id,
                        'category_id' => (int)$category_id
                    ];
                }
            }
            if (!empty($data)) {
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