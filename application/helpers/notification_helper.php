<?php
if (!function_exists('createNotification')) {
    // This method is to fetch system for Admin only i.e Orz level
    function createNotification($tenantDb,$system_id,$location_id,$notifiType,$msg) {
        // Make sure the $db parameter is an instance of CI_DB_driver (Database Library)
        // CRITICAL FIX: Use Australia/Sydney timezone for date/time operations
        $timezone = new DateTimeZone('Australia/Sydney');
        $now = new DateTime('now', $timezone);
       
        $data = array(
         'system_id' => $system_id,
         'title' => $msg,
         'descr' => $msg,
         'location_id' => $location_id,
         'date' => $now->format('Y-m-d'),
         'time' => $now->format('h:i A'),
         'notification_type' => $notifiType,
      );
    
        $result = $tenantDb->insert('Global_notification', $data);
        $notification_id = $tenantDb->insert_id();
        
        // Log notification creation for debugging
        if ($result && $notification_id) {
            log_message('info', "NOTIFICATION CREATED: Notification ID={$notification_id}, System ID={$system_id}, Location ID={$location_id}, Type={$notifiType}, Message=" . substr($msg, 0, 100) . (strlen($msg) > 100 ? '...' : '') . ", Timestamp=" . $now->format('Y-m-d H:i:s'));
        } else {
            $db_error = $tenantDb->error();
            log_message('error', "NOTIFICATION CREATE FAILED: System ID={$system_id}, Location ID={$location_id}, Type={$notifiType}, Message=" . substr($msg, 0, 100) . ", Database Error=" . ($db_error['message'] ?? 'UNKNOWN') . ", Timestamp=" . $now->format('Y-m-d H:i:s'));
        }
        
        return $result;
    }
}


if (!function_exists('fetchAllUnreadNotification')) {
  
    function fetchAllUnreadNotification($tenantDb,$location_id,$status=1) {
      // Order by id DESC to show latest notifications first (newest on top)
      $tenantQuery = $tenantDb->query("SELECT * FROM Global_notification WHERE location_id = '".$location_id."' AND is_deleted = 0 AND status = ".$status." ORDER BY id DESC");
      $resultRows = $tenantQuery->result_array(); 
      $totalCount = $tenantQuery->num_rows(); 
      return ['result' => $resultRows, 'total_count' => $totalCount];

    
    }
}

if (!function_exists('markNotificationAsRead')) {
  
    function markNotificationAsRead($tenantDb,$notificationIds) {
      $timezone = new DateTimeZone('Australia/Sydney');
      $now = new DateTime('now', $timezone);
      
      $notificationIdsToUpdate = (is_array($notificationIds) ? $notificationIdsString = implode(',', $notificationIds) : $notificationIds);
      $notificationIdsArray = is_array($notificationIds) ? $notificationIds : explode(',', $notificationIds);
      $count = count($notificationIdsArray);
      
      log_message('info', "NOTIFICATION MARK AS READ: Marking {$count} notification(s) as read. Notification IDs=" . $notificationIdsString . ", Timestamp=" . $now->format('Y-m-d H:i:s'));
      
      $tenantQuery = $tenantDb->query("UPDATE Global_notification SET status = 0 WHERE id IN ($notificationIdsToUpdate)");
      $affected_rows = $tenantDb->affected_rows();
      
      if ($affected_rows > 0) {
          log_message('info', "NOTIFICATION MARK AS READ SUCCESS: Marked {$affected_rows} notification(s) as read. Notification IDs=" . $notificationIdsString . ", Timestamp=" . $now->format('Y-m-d H:i:s'));
      } else {
          log_message('warning', "NOTIFICATION MARK AS READ: No rows affected. Notification IDs=" . $notificationIdsString . ", Timestamp=" . $now->format('Y-m-d H:i:s'));
      }
      
      return true;
    }
}