#!/usr/bin/php
<?php
/**
 * CRON JOB 1: Handle Nurse Missed Submissions at 11:00 PM daily
 * 
 * This script automatically converts orders with buttonType='save' to buttonType='sendorder'
 * for TOMORROW'S ORDERS ONLY, ensuring chef will see all orders in the morning (5-6 AM).
 * This handles cases where nurses forget to press the "Send Order" button.
 * 
 * 🔒 CRITICAL SAFEGUARD: Only processes orders with date = TOMORROW
 * This ensures we never interfere with today's completed workflow.
 * 
 * Setup Instructions:
 * 1. Make this file executable: chmod +x cron_auto_send_orders.php
 * 2. Add to crontab: crontab -e
 * 3. Add this line: 0 23 * * * /path/to/bizorder/well-known2/cron_auto_send_orders.php
 * 
 * This runs at 11:00 PM every day (end of day processing)
 */

// Set timezone
date_default_timezone_set('Australia/Melbourne');
exit;
// Define paths
define('BASEPATH', TRUE);
$system_path = 'system';
$application_folder = 'application';

// Set the current directory correctly
chdir(dirname(__FILE__));

// Bootstrap CodeIgniter
require_once $system_path.'/core/CodeIgniter.php';

// Load CodeIgniter instance
$CI =& get_instance();

// Load the Order controller
$CI->load->library('session');
$CI->load->model('common_model');

// Include the Order controller
require_once APPPATH.'modules/Orderportal/controllers/Order.php';

// Create instance and run the auto-send function
$orderController = new Order();

echo "=== Auto-Send Cron Job Started ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";
echo "Timezone: " . date_default_timezone_get() . "\n";
echo "=====================================\n";

// Execute the auto-send function
$orderController->autoSendUnsentOrders();

echo "=== Auto-Send Cron Job Completed ===\n";
?>
