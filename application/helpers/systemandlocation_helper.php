<?php
if (!function_exists('fetchSystemNameFromId')) {
    // This method is to fetch system for Admin only i.e Orz level
    function fetchSystemNameFromId($system_id) {
        // Make sure the $db parameter is an instance of CI_DB_driver (Database Library)
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('system_details', array('system_details_id' => $system_id));

if ($query === false) {
    $error = $db->error();
    // echo "Query Error: " . $error['message'];
} else {
    if ($query->num_rows() > 0) {
        $result = $query->row(); // Get the first row
        return $system_name = $result->system_name;
    
    } else {
       return '';
    }
}
    }
    }
// This method is to fetch location for Non-Admin only i.e specific level
    // $singleLocation = pass this true if u want to fetch just location name by pasing specific location_id
    // eg. $location_ids = array(12,11);
function fetchLocationNamesFromIds($location_ids ,$singleLocation=false) {
    $CI = &get_instance();
    $CI->load->database();
   
    $CI->db->select('location_id, location_name');
    $CI->db->where_in('location_id', $location_ids);
    $query = $CI->db->get('locations_list');
    
    if ($query === false) { 
        $error = $CI->db->error();
    } else {
        $location_map = array(); // Initialize the result array
        
         if($singleLocation){
       foreach ($query->result() as $row) {
            $location_map = $row->location_name;
        } 
         }else{
      foreach ($query->result() as $row) {
            $location_map[$row->location_id] = $row->location_name;
        }       
         }
        

        return $location_map;
    }

    return array(); // Return an empty array if there's an error
}
function fetchSystemDetailsFromSystem_id($system_id) {
        // Make sure the $db parameter is an instance of CI_DB_driver (Database Library)
        $CI = &get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('system_details', array('system_details_id' => $system_id));

if ($query === false) {
    $error = $db->error();
    // echo "Query Error: " . $error['message'];
} else {
    if ($query->num_rows() > 0) {
        $result = $query->row(); // Get the first row
        return $system_name = $result;
    
    } else {
       return '';
    }
}
    }

if (!function_exists('get_system_details_for_user')) {
    function get_system_details_for_user($user_id, $tenantDb, $defaultDb) {
        $tenantQuery = $tenantDb->query("SELECT system_ids FROM Global_users WHERE id = '".$user_id."' AND active = 1");
        
        if (!empty($tenantQuery->result_array()[0]['system_ids'])) {
            $system_ids_array = unserialize($tenantQuery->result_array()[0]['system_ids'] ?? '') ?: [];
            $systemIds = implode(",", $system_ids_array);

            
            $systemQuery = $defaultDb->query("SELECT system_details_id as system_id, system_name, system_icon, system_color, slug,custom_redirect_url FROM system_details WHERE system_details_id IN (".$systemIds.")");
            
            return $systemQuery->result_array();
        } else {
            return array();
        }
    }
}


// department name from department id

function fetchDepartmentNameFromId($tenantDb,$floor_id) {
    
   
    $tenantDb->select('name');
    $tenantDb->where_in('id', $floor_id);
    $tenantDb->where('listtype', 'floor');
    $query = $tenantDb->get('foodmenuconfig');
    $department_name = ''; 
    if ($query === false) { 
        $error = $tenantDb->error();
    } else {
        // Initialize the result array
       foreach ($query->result() as $row) {
            $department_name = $row->name;
        } 

        return $department_name;
    }

    return array(); // Return an empty array if there's an error
}
