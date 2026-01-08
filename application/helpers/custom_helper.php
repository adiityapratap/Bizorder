<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function custom_encode($param1, $param2='') {
    // Combine the parameters with a delimiter
    if($param2 !=''){
      $combined_params = "{$param1}|{$param2}"; 
    }else{
       $combined_params =  $param1;
    }
   
$encoded_params = urlencode($combined_params);
    // Encode the combined string
    return $encoded_params;
}

// GET role of logged in user i.e role_id and role_name pass $this->ion_auth as first parameter
if (!function_exists('get_logged_in_user_role')) {
    function get_logged_in_user_role($ion_auth_instance,$type='id') {
        if ($ion_auth_instance->logged_in()) {
            $user_id = $ion_auth_instance->get_user_id();
            $user_roles = $ion_auth_instance->get_users_groups($user_id)->result_array();
//  echo "<pre>"; print_r($user_roles); exit;
            if (!empty($user_roles)) {
                if($type=='id'){
                  return $user_roles[0]['id'];   
                }else{
                     return $user_roles[0]['name'];  
                }
               
            }
        }

        return null; // Handle the case where the user is not logged in or has no roles
    }
}
// get_all_roles_of_currrent_location
if (!function_exists('get_all_roles')) {
    function get_all_roles($ion_auth_instance,$location_id) {
        if ($ion_auth_instance->logged_in()) {
              $CI = &get_instance();
              $CI->load->database();
              $CI->load->model('ion_auth_model');
           $roles = $CI->ion_auth_model
                      ->where('location_id', $location_id)
                      ->orWhere('location_id', 0)
                       ->groups()
                      ->result_array();
       
       
           
            if (!empty($roles)) {
               return $roles; 
               
            }
        }

        return null; // Handle the case where the user is not logged in or has no roles
    }
}

if (!function_exists('get_all_datesBetween')) {
   function get_all_datesBetween($fromDate, $toDate) {
    $fromDate = new DateTime($fromDate);
    $toDate = new DateTime($toDate);

    $dates = array();

    while ($fromDate <= $toDate) {
        $dates[] = $fromDate->format('Y-m-d'); // Change the format as needed
        $fromDate->modify('+1 day');
    }

    return $dates;
}
}

if (!function_exists('mergeArrayBasedOnCommonKey')) {
    function mergeArrayBasedOnCommonKey($array1,$array2) {
        
        $lookup = array_reduce($array2, function ($carry, $item) {
    $carry[$item->checklist_id] = $item;
    return $carry;
}, []);

// Merge the arrays based on the common identifier
$mergedArray = array_map(function ($item1) use ($lookup) {
    // Check if there is a match in Array 2 using the identifier
    if (isset($lookup[$item1->id])) {
        // Merge data from both arrays
        return (object) array_merge((array) $item1, (array) $lookup[$item1->id]);
    }
    // If no match is found, return the item from Array 1 as-is
    return $item1;
}, $array1);

return $mergedArray;
        
    }
    
}



if (!function_exists('is_serialized')) {
    function is_serialized($data) {
        // If it isn't a string, it isn't serialized
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (!preg_match('/^([adObis]):/', $data, $badions)) {
            return false;
        }
        switch ($badions[1]) {
            case 'a':
            case 'O':
            case 's':
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data)) {
                    return true;
                }
                break;
            case 'b':
            case 'i':
            case 'd':
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data)) {
                    return true;
                }
                break;
        }
        return false;
    }
}

/**
 * Get current date in Australia/Sydney timezone (YYYY-MM-DD format)
 * CRITICAL: Use this for all date operations to prevent timezone mismatches
 */
if (!function_exists('get_australia_date')) {
    function get_australia_date($dateString = null) {
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
}

/**
 * Get tomorrow's date in Australia/Sydney timezone (YYYY-MM-DD format)
 */
if (!function_exists('get_australia_tomorrow')) {
    function get_australia_tomorrow() {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        $date->modify('+1 day');
        return $date->format('Y-m-d');
    }
}

/**
 * Get date N days from today in Australia/Sydney timezone (YYYY-MM-DD format)
 */
if (!function_exists('get_australia_date_offset')) {
    function get_australia_date_offset($days = 0) {
        $timezone = new DateTimeZone('Australia/Sydney');
        $date = new DateTime('now', $timezone);
        if ($days != 0) {
            $date->modify($days > 0 ? "+{$days} days" : "{$days} days");
        }
        return $date->format('Y-m-d');
    }
}

/**
 * Format date/time in Australia/Sydney timezone
 * CRITICAL: Use this instead of date() to ensure Australia/Sydney timezone
 * 
 * @param string $format PHP date format (e.g., 'Y-m-d H:i:s', 'd/m/Y')
 * @param string|int|null $timestamp Optional timestamp or date string. If null, uses current time
 * @return string Formatted date/time string
 */
if (!function_exists('australia_date')) {
    function australia_date($format, $timestamp = null) {
        $timezone = new DateTimeZone('Australia/Sydney');
        
        if ($timestamp === null) {
            $date = new DateTime('now', $timezone);
        } elseif (is_numeric($timestamp)) {
            // Unix timestamp
            $date = new DateTime('@' . $timestamp);
            $date->setTimezone($timezone);
        } else {
            // Date string - try to parse
            $date = new DateTime($timestamp, $timezone);
        }
        
        return $date->format($format);
    }
}

/**
 * Get current date/time in Australia/Sydney timezone (Y-m-d H:i:s format)
 * CRITICAL: Use this instead of date('Y-m-d H:i:s')
 */
if (!function_exists('australia_datetime')) {
    function australia_datetime() {
        return australia_date('Y-m-d H:i:s');
    }
}

/**
 * Get current date in Australia/Sydney timezone (Y-m-d format)
 * CRITICAL: Use this instead of date('Y-m-d')
 */
if (!function_exists('australia_date_only')) {
    function australia_date_only() {
        return australia_date('Y-m-d');
    }
}

/**
 * Format date string in Australia/Sydney timezone
 * CRITICAL: Use this for formatting dates from database or user input
 * 
 * @param string $dateString Date string (e.g., 'Y-m-d' format)
 * @param string $format Output format (default: 'd-m-Y')
 * @return string Formatted date string
 */
if (!function_exists('format_australia_date')) {
    function format_australia_date($dateString, $format = 'd-m-Y') {
        if (empty($dateString)) {
            return '';
        }
        
        $timezone = new DateTimeZone('Australia/Sydney');
        
        // Try to parse the date string
        $date = DateTime::createFromFormat('Y-m-d', $dateString, $timezone);
        if ($date === false) {
            // Try alternative parsing
            $date = new DateTime($dateString, $timezone);
        }
        
        return $date->format($format);
    }
}



