<?php
/**
 * Cron job to send pending order notifications at 10:00 AM daily
 * 
 * Add this to your crontab:
 * 0 10 * * * /usr/bin/php /path/to/your/project/cron_pending_orders.php
 * 
 * Or run every minute and let the function handle timing:
 * * * * * * /usr/bin/php /path/to/your/project/cron_pending_orders.php
 */

// Set the path to CodeIgniter
define('BASEPATH', TRUE);
$system_path = 'system';
$application_folder = 'application';
exit;

// Set error reporting
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

// Bootstrap CodeIgniter
require_once $system_path.'/core/CodeIgniter.php';

// Load CodeIgniter framework
$CI =& get_instance();
$CI->load->database();
$CI->load->model('common_model');

// Load the Order controller
require_once APPPATH.'modules/Orderportal/controllers/Order.php';

// Create instance and call the notification method
$order_controller = new Order();
$order_controller->sendPendingOrderNotifications();

echo "Pending order notifications cron job completed at " . date('Y-m-d H:i:s') . "\n";
?>
