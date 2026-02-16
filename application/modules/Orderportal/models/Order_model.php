<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model{
	

	function __construct() {
		parent::__construct();
		$this->load->helper('custom'); // Load custom helper for Australia timezone functions
	}
	
	function fetchSuiteDetails($conditions=array()){
	   $this->tenantDb->distinct();
	   $this->tenantDb->select('s.id, s.bed_no, s.status,s.is_vaccant,s.floor');
       $this->tenantDb->from('suites s');
       $this->tenantDb->where('s.floor', $this->session->userdata('department_id')); 
       $query = $this->tenantDb->get();

        return $result = $query->result_array();
     

	}
	
public function getSuiteSummary()
{
    $this->tenantDb->select('
        s.id AS suite_id,
        s.bed_no,
        s.floor,
        p.name AS person_name,
        p.special_instructions
    ');
    $this->tenantDb->from('suites s');

    // Keep LEFT JOIN intact
    $this->tenantDb->join(
        'people p',
        'p.suite_number = s.id AND p.status = 1',
        'left'
    );

    $this->tenantDb->where('s.is_deleted', 0);
    $this->tenantDb->where('s.is_vaccant', 0);

   
    $this->tenantDb->where('p.special_instructions IS NOT NULL', null, false);
    $this->tenantDb->where("TRIM(p.special_instructions) != ''", null, false);

    $query = $this->tenantDb->get()->result_array();

    $output = [];

    foreach ($query as $row) {
        $suiteId = $row['suite_id'];

        if (!isset($output[$suiteId])) {
            $output[$suiteId] = [
                'floor'     => $row['floor'],
                'bed_no'    => $row['bed_no'],
                'people'    => []
            ];
        }

        if (!empty(trim($row['special_instructions']))) {
            $output[$suiteId]['people'][] = [
                // 'name' => $row['person_name'],
                'instructions' => $row['special_instructions']
            ];
        }
    }

    return $output;
}




   
function fetchOrderForChef($date = null, $orderId = null) {
    // CRITICAL FIX: Use Australia/Sydney timezone for date operations
    // Use provided date or default to today in Australia/Sydney timezone
    if (empty($date)) {
        $timezone = new DateTimeZone('Australia/Sydney');
        $dateObj = new DateTime('now', $timezone);
        $date = $dateObj->format('Y-m-d');
    }
    
    // FIXED: Use category_id from orders_to_patient_options to get accurate counts per meal period
    // This prevents counting items from multiple meal categories (Breakfast + Lunch + Dinner)
    // IMPORTANT: md.name (menuDetails) is the subcategory (Toast, Condiments, etc.)
    $this->tenantDb->select('
        COALESCE(opo.category_id, 0) as category_id,
        COALESCE(fmc.name, "Unknown Category") as category_name,
        COALESCE(fmc.sort_order, 999) as category_sort_order,
        md.id as menu_id,
        md.name as menu_item_name,
        md.sort_order as menu_item_sort_order,
        opo.option_id,
        mo.menu_option_name,
        mo.menu_color,
        md.name as food_category_name,
        SUM(CASE WHEN opo.status = 0 THEN opo.quantity ELSE 0 END) as total_qty,
        SUM(CASE WHEN opo.status = 1 THEN opo.quantity ELSE 0 END) as completed_qty,
        SUM(opo.quantity) as all_qty,
        COUNT(DISTINCT opo.bed_id) as bed_count,
        GROUP_CONCAT(DISTINCT CONCAT(opo.bed_id, ":", opo.quantity, ":", opo.status) SEPARATOR "|") as bed_quantities,
        MAX(opo.status) as is_completed
    ');
    
    $this->tenantDb->from('orders as o');
    $this->tenantDb->join('orders_to_patient_options as opo', 'o.order_id = opo.order_id', 'INNER');
    $this->tenantDb->join('menuDetails as md', 'md.id = opo.menu_id', 'INNER');
    $this->tenantDb->join('menu_options as mo', 'mo.id = opo.option_id', 'INNER');
    
    // Join to get category name from opo.category_id (the actual meal period ordered)
    // LEFT JOIN to handle edge cases where category_id might be NULL after migration
    $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = opo.category_id', 'LEFT');

    if ($orderId) {
        $this->tenantDb->where('opo.order_id', $orderId);
    } else {
        $this->tenantDb->where('DATE(o.date)', $date);
        $this->tenantDb->where('o.buttonType', 'sendorder');
    }

    // SOFT DELETE: Exclude cancelled order items from production counts
    $this->tenantDb->group_start();
    $this->tenantDb->where('opo.is_cancelled', 0);
    $this->tenantDb->or_where('opo.is_cancelled IS NULL');
    $this->tenantDb->group_end();

    // FIXED: Include items with category_id (skip orphaned items without menu_id)
    // This is more forgiving for the migration period
    $this->tenantDb->where('opo.menu_id IS NOT NULL');
    
    // Group by the stored category_id + menu_id + option_id
    // Use raw field names - COALESCE is handled in SELECT
    $this->tenantDb->group_by(['opo.category_id', 'md.id', 'opo.option_id']);
    
    // Only show items with quantity > 0
    $this->tenantDb->having('all_qty >', 0);
    
    // Order by category, then by menu item (which is the subcategory), then by option
    $this->tenantDb->order_by('category_sort_order', 'ASC');
    $this->tenantDb->order_by('menu_item_sort_order', 'ASC');

    $query = $this->tenantDb->get();
    // Debug: Production form query
    // error_log('Production Form SQL Query: ' . $this->tenantDb->last_query());
    return $query->result_array();
}

// FIXED: Fetch special order notes with proper date logic and better data
   function fetchOrderWithOrderNotes($date = null){
       // CRITICAL FIX: Use Australia/Sydney timezone for date operations
       // Use provided date or default to today in Australia/Sydney timezone
       if (empty($date)) {
           $timezone = new DateTimeZone('Australia/Sydney');
           $dateObj = new DateTime('now', $timezone);
           $date = $dateObj->format('Y-m-d');
       }
       
   // FIXED: Use consistent date logic with fetchOrderForChef
   $this->tenantDb->select('order_id,buttonType');
   $this->tenantDb->from('orders');
   $this->tenantDb->where('DATE(date)', $date); 
   $this->tenantDb->where('buttonType', 'sendorder');
   $todaysOrder = $this->tenantDb->get()->result_array();

   $orderIds = array_column($todaysOrder, 'order_id');

   if (!empty($orderIds)) {
       // FIXED: Query BOTH orders_to_comments (legacy) AND suite_order_details (floor consolidated)
       $this->tenantDb->select('
           op.order_id, 
           op.bed_id, 
           op.order_comment,
           bd.bed_no,
           fmc.name as floor,
           bd.notes as bed_notes
       ');
       $this->tenantDb->from('orders_to_comments as op');
       $this->tenantDb->join('suites as bd', 'bd.id = op.bed_id', 'INNER');
       $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = bd.floor', 'LEFT');
       $this->tenantDb->where('op.order_comment IS NOT NULL');
       $this->tenantDb->where('op.order_comment !=', ''); 
       $this->tenantDb->where_in('op.order_id', $orderIds); 
       $this->tenantDb->group_by('op.bed_id');
       $legacyResults = $this->tenantDb->get()->result_array();
       
       // Also get floor consolidated order notes from suite_order_details
       $this->tenantDb->select('
           sod.floor_order_id as order_id, 
           sod.suite_id as bed_id, 
           sod.order_comment,
           bd.bed_no,
           fmc.name as floor,
           bd.notes as bed_notes
       ');
       $this->tenantDb->from('suite_order_details as sod');
       $this->tenantDb->join('suites as bd', 'bd.id = sod.suite_id', 'INNER');
       $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = bd.floor', 'LEFT');
       $this->tenantDb->where('sod.order_comment IS NOT NULL');
       $this->tenantDb->where('sod.order_comment !=', ''); 
       $this->tenantDb->where_in('sod.floor_order_id', $orderIds);
       $this->tenantDb->where('sod.status', 'active');
       $this->tenantDb->group_by('sod.suite_id');
       $this->tenantDb->order_by('fmc.sort_order', 'ASC');
       $this->tenantDb->order_by('bd.bed_no', 'ASC');
       $floorResults = $this->tenantDb->get()->result_array();
       
       // Merge both results
       $result = array_merge($legacyResults, $floorResults);
       // Debug: Special notes query
       // error_log('Special Notes Query - Legacy: ' . count($legacyResults) . ', Floor: ' . count($floorResults));
       return $result;
   } else {
       return []; 
   }
   }

   // New method to fetch item-specific comments for production form
   function fetchItemSpecificComments($date = null) {
       // CRITICAL FIX: Use Australia/Sydney timezone for date operations
       // Use provided date or default to today in Australia/Sydney timezone
       if (empty($date)) {
           $timezone = new DateTimeZone('Australia/Sydney');
           $dateObj = new DateTime('now', $timezone);
           $date = $dateObj->format('Y-m-d');
       }
       
       // Get orders for selected date
       $this->tenantDb->select('order_id');
       $this->tenantDb->from('orders');
       $this->tenantDb->where('DATE(date)', $date); 
       $this->tenantDb->where('buttonType', 'sendorder');
       $todaysOrders = $this->tenantDb->get()->result_array();
       
       if (empty($todaysOrders)) {
           // If no orders exist for today, also check for comments created yesterday for today
           // This handles the case where reception adds comments for tomorrow's orders
           $this->tenantDb->select('
               mic.menu_id,
               mic.option_id,
               mic.bed_id,
               mic.comment,
               mic.added_by_role,
               s.bed_no,
               fmc.name as floor_name,
               mo.menu_option_name
           ');
           $this->tenantDb->from('menu_item_comments as mic');
           $this->tenantDb->join('suites as s', 's.id = mic.bed_id', 'INNER');
           $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = s.floor', 'LEFT');
           $this->tenantDb->join('menu_options as mo', 'mo.id = mic.option_id', 'LEFT');
           
           // Look for comments with order_id=0 created yesterday (for today's delivery)
           $this->tenantDb->where('mic.order_id', 0);
           // CRITICAL FIX: Use Australia/Sydney timezone for date operations
           $timezone = new DateTimeZone('Australia/Sydney');
           $yesterdayObj = new DateTime('now', $timezone);
           $yesterdayObj->modify('-1 day');
           $yesterdayDate = $yesterdayObj->format('Y-m-d');
           $this->tenantDb->where('DATE(mic.created_at)', $yesterdayDate);
           $this->tenantDb->where('mic.comment IS NOT NULL');
           $this->tenantDb->where('mic.comment !=', '');
           $this->tenantDb->order_by('fmc.sort_order', 'ASC');
           $this->tenantDb->order_by('s.bed_no', 'ASC');
           
           $result = $this->tenantDb->get()->result_array();
           // Debug: Item comments query
           // error_log('Item Comments (no orders) SQL Query: ' . $this->tenantDb->last_query());
           
           // Group comments by menu_id and option_id
           $groupedComments = [];
           foreach ($result as $row) {
               $key = $row['menu_id'] . '_' . $row['option_id'];
               if (!isset($groupedComments[$key])) {
                   $groupedComments[$key] = [];
               }
               $groupedComments[$key][] = [
                   'bed_id' => $row['bed_id'],
                   'bed_no' => $row['bed_no'],
                   'floor_name' => $row['floor_name'],
                   'comment' => $row['comment'],
                   'added_by_role' => $row['added_by_role'],
                   'menu_option_name' => $row['menu_option_name']
               ];
           }
           
           return $groupedComments;
       }
       
       $orderIds = array_column($todaysOrders, 'order_id');
       
       // Fetch item-specific comments from menu_item_comments table
       $this->tenantDb->select('
           mic.menu_id,
           mic.option_id,
           mic.bed_id,
           mic.comment,
           mic.added_by_role,
           s.bed_no,
           fmc.name as floor_name,
           mo.menu_option_name
       ');
       $this->tenantDb->from('menu_item_comments as mic');
       $this->tenantDb->join('suites as s', 's.id = mic.bed_id', 'INNER');
       $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = s.floor', 'LEFT');
       $this->tenantDb->join('menu_options as mo', 'mo.id = mic.option_id', 'LEFT');
       
       // FIXED: Look for comments associated with today's orders (regardless of when comments were created)
       // This handles the workflow where reception adds comments and then creates orders
       $this->tenantDb->group_start();
       $this->tenantDb->where_in('mic.order_id', $orderIds);
       $this->tenantDb->or_group_start();
       // Also include unassociated comments from yesterday (for today's delivery)
       $this->tenantDb->where('mic.order_id', 0);
       // CRITICAL FIX: Use Australia/Sydney timezone for date operations
       $timezone = new DateTimeZone('Australia/Sydney');
       $yesterdayObj = new DateTime('now', $timezone);
       $yesterdayObj->modify('-1 day');
       $yesterdayDate = $yesterdayObj->format('Y-m-d');
       $this->tenantDb->where('DATE(mic.created_at)', $yesterdayDate);
       $this->tenantDb->group_end();
       $this->tenantDb->group_end();
       
       $this->tenantDb->where('mic.comment IS NOT NULL');
       $this->tenantDb->where('mic.comment !=', '');
       $this->tenantDb->order_by('fmc.sort_order', 'ASC');
       $this->tenantDb->order_by('s.bed_no', 'ASC');
       
       $result = $this->tenantDb->get()->result_array();
       // Debug: Item comments query
       // error_log('Item Comments SQL Query: ' . $this->tenantDb->last_query());
       
       // Group comments by menu_id and option_id
       $groupedComments = [];
       foreach ($result as $row) {
           $key = $row['menu_id'] . '_' . $row['option_id'];
           if (!isset($groupedComments[$key])) {
               $groupedComments[$key] = [];
           }
           $groupedComments[$key][] = [
               'bed_id' => $row['bed_id'],
               'bed_no' => $row['bed_no'],
               'floor_name' => $row['floor_name'],
               'comment' => $row['comment'],
               'added_by_role' => $row['added_by_role'],
               'menu_option_name' => $row['menu_option_name']
           ];
       }
       
       return $groupedComments;
   }
   
   
   
   function fetchOrderAndMenuOptions($orderId = null){
    
   // FIXED: Fetch both menu options AND standalone comments (notes without menu items)
   // First, get all menu options with their comments, allergen information, and item-specific comments
   $this->tenantDb->distinct();
   $this->tenantDb->select('opo.order_id, opo.menu_id, opo.option_id, opo.bed_id, mo.menu_option_name,mo.menu_color, mo.allergenValues, m2c.category_id,o2c.order_comment,o2c.order_data, mic.comment as item_comment');
   $this->tenantDb->from('orders_to_patient_options as opo');
   $this->tenantDb->join('menu_options as mo', 'opo.option_id = mo.id', 'LEFT');
   $this->tenantDb->join('orders_to_comments as o2c', 'o2c.bed_id = opo.bed_id AND o2c.order_id = opo.order_id', 'LEFT');
   $this->tenantDb->join('menu_item_comments as mic', 'mic.bed_id = opo.bed_id AND mic.order_id = opo.order_id AND mic.menu_id = opo.menu_id AND mic.option_id = opo.option_id', 'LEFT');
   $this->tenantDb->join('menu_details_to_menu_options as md2mo', 'mo.id = md2mo.menu_option_id', 'LEFT');
   $this->tenantDb->join('menu_to_category as m2c', 'm2c.menu_id = opo.menu_id', 'LEFT');
   $this->tenantDb->where('opo.order_id', $orderId);
   // SOFT DELETE: Exclude cancelled order items
   $this->tenantDb->group_start();
   $this->tenantDb->where('opo.is_cancelled', 0);
   $this->tenantDb->or_where('opo.is_cancelled IS NULL');
   $this->tenantDb->group_end();
   
   $menuOptionsData = $this->tenantDb->get()->result_array();
   
   // Now get comments/notes that don't have menu options (standalone notes)
   // Using '0' instead of NULL to avoid breaking existing code that concatenates these values
   $this->tenantDb->select('o2c.order_id, 0 as menu_id, 0 as option_id, o2c.bed_id, "" as menu_option_name, "" as allergenValues, 0 as category_id, o2c.order_comment, o2c.order_data, "" as item_comment');
   $this->tenantDb->from('orders_to_comments as o2c');
   $this->tenantDb->where('o2c.order_id', $orderId);
   $this->tenantDb->where('o2c.order_comment IS NOT NULL');
   $this->tenantDb->where('o2c.order_comment !=', '');
   // Only get comments where there's NO corresponding entry in orders_to_patient_options
   $this->tenantDb->where("NOT EXISTS (SELECT 1 FROM orders_to_patient_options opo2 WHERE opo2.order_id = o2c.order_id AND opo2.bed_id = o2c.bed_id)", null, false);
   
   $standaloneComments = $this->tenantDb->get()->result_array();
   
   // Merge both results
   $result = array_merge($menuOptionsData, $standaloneComments);
   
   return $result;
   }
   
   /**
    * Fetch floor order and menu options for floor consolidated orders
    */
   function fetchFloorOrderAndMenuOptions($orderId = null){
    
    // First, let's debug what we have in the database
    // Debug: Floor order fetch
    // error_log('fetchFloorOrderAndMenuOptions called with orderId: ' . $orderId);
    
    // Check if suite_order_detail_id exists and is populated
    $this->tenantDb->select('COUNT(*) as count');
    $this->tenantDb->from('orders_to_patient_options');
    $this->tenantDb->where('order_id', $orderId);
    $this->tenantDb->where('suite_order_detail_id IS NOT NULL');
    $countWithSuiteDetailId = $this->tenantDb->get()->row()->count;
    // Debug: Suite detail ID count
    // error_log('Orders with suite_order_detail_id for order ' . $orderId . ': ' . $countWithSuiteDetailId);
    
    if ($countWithSuiteDetailId > 0) {
        // Use the original query if suite_order_detail_id is populated
        $this->tenantDb->distinct();
        $this->tenantDb->select('
            opo.order_id, 
            opo.menu_id, 
            opo.option_id, 
            sod.suite_id as bed_id, 
            mo.menu_option_name, 
            mo.menu_color, 
            mo.allergenValues,
            m2c.category_id,
            sod.order_comment,
            "" as order_data,
            mic.comment as item_comment
        ');
        $this->tenantDb->from('orders_to_patient_options as opo');
        $this->tenantDb->join('suite_order_details as sod', 'opo.suite_order_detail_id = sod.id', 'INNER');
        $this->tenantDb->join('menu_options as mo', 'opo.option_id = mo.id', 'LEFT');
        $this->tenantDb->join('menu_item_comments as mic', 'mic.bed_id = sod.suite_id AND mic.order_id = opo.order_id AND mic.menu_id = opo.menu_id AND mic.option_id = opo.option_id', 'LEFT');
        $this->tenantDb->join('menu_details_to_menu_options as md2mo', 'mo.id = md2mo.menu_option_id', 'LEFT');
        $this->tenantDb->join('menu_to_category as m2c', 'm2c.menu_id = opo.menu_id', 'LEFT');
        $this->tenantDb->where('opo.order_id', $orderId);
        $this->tenantDb->where('sod.status', 'active');
        // SOFT DELETE: Exclude cancelled order items
        $this->tenantDb->group_start();
        $this->tenantDb->where('opo.is_cancelled', 0);
        $this->tenantDb->or_where('opo.is_cancelled IS NULL');
        $this->tenantDb->group_end();
        
        $result = $this->tenantDb->get()->result_array();
        // Debug: Query result count
        // error_log('Query result count: ' . count($result));
        //  echo $this->tenantDb->last_query(); exit;
        return $result;
    } else {
        // Fallback: try to get data using bed_id if suite_order_detail_id is not populated
        // Debug: Fallback query (suite_order_detail_id not populated)
        
        $this->tenantDb->distinct();
        $this->tenantDb->select('
            opo.order_id, 
            opo.menu_id, 
            opo.option_id, 
            opo.bed_id, 
            mo.menu_option_name, 
            mo.allergenValues,
            m2c.category_id,
            "" as order_comment,
            "" as order_data,
            mic.comment as item_comment
        ');
        $this->tenantDb->from('orders_to_patient_options as opo');
        $this->tenantDb->join('menu_options as mo', 'opo.option_id = mo.id', 'LEFT');
        $this->tenantDb->join('menu_item_comments as mic', 'mic.bed_id = opo.bed_id AND mic.order_id = opo.order_id AND mic.menu_id = opo.menu_id AND mic.option_id = opo.option_id', 'LEFT');
        $this->tenantDb->join('menu_to_category as m2c', 'm2c.menu_id = opo.menu_id', 'LEFT');
        $this->tenantDb->where('opo.order_id', $orderId);
        // SOFT DELETE: Exclude cancelled order items
        $this->tenantDb->group_start();
        $this->tenantDb->where('opo.is_cancelled', 0);
        $this->tenantDb->or_where('opo.is_cancelled IS NULL');
        $this->tenantDb->group_end();
        
        $result = $this->tenantDb->get()->result_array();
       
        // Debug: Fallback result count
        // error_log('Fallback query result count: ' . count($result));
        return $result;
    }
   }
   
   function orderList($groupByDate=false){
       
    $this->tenantDb->select('o.order_id,o.dept_id, fmc.name,o.date,o.status');
    $this->tenantDb->from('orders as o');
    $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = o.dept_id', 'LEFT');
    if($groupByDate){
     $this->tenantDb->group_by('o.date');    
    }
    
    $this->tenantDb->order_by('o.date', 'DESC');
    return $this->tenantDb->get()->result_array();
   }
   
   /**
    * FIXED: Get actual daily invoices, not just orders
    * Only shows invoices for delivered orders
    */
   function getDailyInvoices() {
       $this->tenantDb->select('
           di.id as invoice_id,
           di.order_date as date,
           di.order_id,
           di.invoice_number,
           di.status,
           di.total_amount,
           di.generated_date,
           di.payment_date,
           fmc.name as floor_name,
           o.dept_id,
           o.is_delivered
       ');
       $this->tenantDb->from('daily_invoices as di');
       $this->tenantDb->join('orders as o', 'o.order_id = di.order_id', 'INNER');
       $this->tenantDb->join('foodmenuconfig as fmc', 'fmc.id = o.dept_id', 'LEFT');
       $this->tenantDb->where('di.status !=', 3); // Exclude cancelled invoices
       $this->tenantDb->order_by('di.order_date', 'DESC');
       
       return $this->tenantDb->get()->result_array();
   }
   
   /**
    * Generate invoices for all delivered orders that don't have invoices yet
    * UPDATED FOR FLOOR CONSOLIDATION SYSTEM
    * UPDATED: Generate ONE invoice per day (not per floor)
    */
   function generateMissingInvoices() {
       // Load status compatibility model
       $this->load->model('status_compatibility_model');
       
       // UPDATED: Find dates that have delivered orders but no invoice
       // Step 1: Get all unique dates with delivered orders
       $this->tenantDb->distinct();
       $this->tenantDb->select('o.date');
       $this->tenantDb->from('orders as o');
       $this->tenantDb->where('o.buttonType', 'sendorder');
       $this->tenantDb->where('o.is_delivered', 1);
       $this->tenantDb->where('o.status', 4);
       $datesWithDeliveredOrders = $this->tenantDb->get()->result_array();
       
       $generated = 0;
       
       foreach ($datesWithDeliveredOrders as $dateRow) {
           $order_date = $dateRow['date'];
           
           // Check if invoice already exists for this date
           $existing_invoice = $this->common_model->fetchRecordsDynamically(
               'daily_invoices',
               ['id', 'invoice_number'],
               ['order_date' => $order_date]
           );
           
           if (!empty($existing_invoice)) {
               // Invoice already exists for this date
               continue;
           }
           
           // Check if ALL orders for this date are delivered
           $all_orders = $this->common_model->fetchRecordsDynamically(
               'orders',
               ['order_id', 'status', 'is_delivered'],
               [
                   'date' => $order_date,
                   'buttonType' => 'sendorder'
               ]
           );
           
           if (empty($all_orders)) {
               continue;
           }
           
           // Check if all orders are fully delivered
           $all_delivered = true;
           foreach ($all_orders as $order) {
               if ($order['status'] != 4 || $order['is_delivered'] != 1) {
                   $all_delivered = false;
                   break;
               }
           }
           
           if (!$all_delivered) {
               // Not all orders for this date are delivered yet
               log_message('info', "Skipping invoice for {$order_date} - not all orders delivered");
               continue;
           }
           
           // ALL orders delivered - Generate ONE consolidated invoice for this date
           // CRITICAL FIX: Use Australia/Sydney timezone for date formatting
           $timezone = new DateTimeZone('Australia/Sydney');
           $dateObj = DateTime::createFromFormat('Y-m-d', $order_date, $timezone);
           if ($dateObj === false) {
               $dateObj = new DateTime($order_date, $timezone);
           }
           $invoice_number = 'INV' . $dateObj->format('dmY');
           
           $invoice_data = [
               'order_date' => $order_date,
               'dept_id' => 0, // 0 indicates consolidated invoice for all floors
               'order_id' => $all_orders[0]['order_id'], // Reference first order
               'generated_date' => australia_datetime(),
               'status' => 1, // Generated
               'invoice_number' => $invoice_number
           ];
           
           $this->common_model->commonRecordCreate('daily_invoices', $invoice_data);
           $generated++;
           
           log_message('info', "✅ Generated consolidated invoice {$invoice_number} for {$order_date} (" . count($all_orders) . " floor orders)");
       }
       
       return $generated;
   }
   
   
   function fetchOrderForInvoice($orderDate) {
       
    // UPDATED: Return consolidated data for ALL floors on this date
    // Count total UNIQUE suites across ALL floor orders for the day
    // Use orders_to_patient_options as it always has bed_id populated
    
    $this->tenantDb->select('
        o.date,
        COUNT(DISTINCT opo.bed_id) AS total_bed_serviced,
        GROUP_CONCAT(DISTINCT fmc.name ORDER BY fmc.name SEPARATOR ", ") AS floors_serviced
    ');
    $this->tenantDb->from('orders AS o');
    $this->tenantDb->join('orders_to_patient_options AS opo', 'opo.order_id = o.order_id', 'left');
    $this->tenantDb->join('foodmenuconfig AS fmc', 'fmc.id = o.dept_id', 'left');
    $this->tenantDb->where('o.date', $orderDate);
    $this->tenantDb->where('o.status', 4); // Only delivered orders
    $this->tenantDb->where('o.is_delivered', 1);
    $this->tenantDb->group_by('o.date');
    
    $result = $this->tenantDb->get()->result_array();
    
    // Log query for debugging
    log_message('debug', 'Daily Invoice Query: ' . $this->tenantDb->last_query());
    
    // Return as array with single consolidated row
    return !empty($result) ? $result : [['date' => $orderDate, 'total_bed_serviced' => 0, 'floors_serviced' => '']];
     
//   echo $lastQuery = $this->tenantDb->last_query(); exit;
   }
   
   function fetchmenuDetailsFromId($menuIds){
       $menuIds = array_values($menuIds);
       $this->tenantDb->select('name');
       $this->tenantDb->from('menuDetails');
       $this->tenantDb->where_in('id', $menuIds);
       $query = $this->tenantDb->get();
       return $result = $query->result_array();
       
   }
   
   function generateBulkInvoice($startDate,$endDate){
       
// Count DISTINCT suites (bed_id) from orders_to_patient_options
// This table always has bed_id when menu items are selected
// NOTE: We don't fetch limits and budget from orders table anymore
// They should come from departmentSettings in the controller
$this->tenantDb->select('o.date, 
    COALESCE(COUNT(DISTINCT opo.bed_id), 0) as totalPatients');
$this->tenantDb->from('orders as o');
$this->tenantDb->join('orders_to_patient_options as opo', 'opo.order_id = o.order_id', 'LEFT');
$this->tenantDb->where("o.date BETWEEN '$startDate' AND '$endDate'");
$this->tenantDb->group_by('o.date');
$query = $this->tenantDb->get();

// Log query for debugging
log_message('debug', 'Bulk Invoice Query: ' . $this->tenantDb->last_query());

return $query->result_array();


   
   

   }

	
}
?>
