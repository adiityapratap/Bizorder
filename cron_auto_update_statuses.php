#!/usr/bin/php
<?php
/**
 * CRON JOB 2: Handle Chef/Delivery Missed Updates at 11:00 PM daily
 * 
 * This script automatically updates order statuses that chef or delivery staff
 * may have forgotten to update for TODAY'S ORDERS ONLY, ensuring invoices can be generated.
 * 
 * 🔒 CRITICAL SAFEGUARD: Only processes orders with date = TODAY
 * This ensures we never interfere with tomorrow's orders that are still being prepared.
 * 
 * Status Flow:
 * - Send Order/In Progress → "Delivered/Completed" (status = 4)
 * 
 * Setup Instructions:
 * 1. Make this file executable: chmod +x cron_auto_update_statuses.php
 * 2. Add to crontab: crontab -e
 * 3. Add this line: 0 23 * * * /path/to/bizorder/well-known2/cron_auto_update_statuses.php
 * 
 * This runs at 11:00 PM every day (same time as Cron Job 1, but different logic)
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

// Create instance and run the auto-update function
$orderController = new Order();

echo "=== Auto-Update Status Cron Job Started ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n";
echo "Timezone: " . date_default_timezone_get() . "\n";
echo "Purpose: Update forgotten order statuses for invoice generation\n";
echo "=============================================\n";

// Execute the auto-update function
$orderController->autoUpdateForgottenOrderStatuses();

echo "=== Auto-Update Status Cron Job Completed ===\n";
?>
