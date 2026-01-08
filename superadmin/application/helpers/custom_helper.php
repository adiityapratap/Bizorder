<?php


// application/helpers/custom_helper.php

if (!function_exists('get_user_id_by_organization_id')) {
    function get_user_id_by_organization_id($newDBConn,$organization_id) {
      
       
        $table_name = 'Global_users';

        // Query to fetch the user ID based on location ID
        $newDBConn->select('id');
        $newDBConn->where('company', $organization_id);
        $query = $newDBConn->get($table_name);

        // Check if a row with the location ID exists
        if ($query !== FALSE && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        } else {
            return null; // Return null if no user found for the given location ID
        }
    }
}

?>