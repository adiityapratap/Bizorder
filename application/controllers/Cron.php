<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
class Cron extends MX_Controller {
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $cron_model;

    public function __construct() {
        parent::__construct();
        $this->load->model('cron_model');
        // Load the CodeIgniter database library
        $this->load->database();
        
    }
 
    function fetchAllCurrentSystemOfAllTenant(){
        $dbInstance = $this->load->database('default', TRUE); 
        $colmsToFetch = 'tenant_identifier,system_ids,location_ids';
        $results = $this->cron_model->fetchRecord($dbInstance,'organization_list','',$colmsToFetch);
        $arrayWithTenantDetails = array();
        foreach($results as $result){
           $arrayWithTenantDetails[$result->tenant_identifier]['system_id'] = unserialize($result->system_ids);
           $arrayWithTenantDetails[$result->tenant_identifier]['location_id'] = unserialize($result->location_ids);
          
        }
        return $arrayWithTenantDetails;
    }
    function executeNotificationCron(){
          
        //  mention all system and its method that will be called usig cron job for notification
        // if we add further notification in any system that needs to be executed using cron job, please put that here using comma seprated
        // for eg :  $listOfNotificationSystemWise['102'] = array('shiftNotStartedMail','shiftNotEndedMail');
        
        // NOTE : Please make sure option value name and method defined here is same, for eg in cash site setting page notificatipon option value
        // and method name define here on this page is "shiftNotStartedMail" and "shiftNotEndedMail"
        $globalNotifications = array('MSchecklistNotification_mail','ASchecklistNotification_mail','ESchecklistNotification_mail');
        
        $listOfNotificationSystemWise['102'] = array('shiftNotStartedMail','shiftNotEndedMail');
        $listOfNotificationSystemWise['109'] = array('uncompleted_equipTempMail');
        $listOfNotificationSystemWise['110'] = array('uncompleted_cleanTaskMail');

        $arrayWithTenantDetails = $this->fetchAllCurrentSystemOfAllTenant();
        $current_time = date('h:i A');
        $current_time = strtotime($current_time);
        
        foreach($arrayWithTenantDetails as $tenant_identifier => $tenantData){
         $this->tenantDb = $this->load->database($tenant_identifier, TRUE);
         $allLocations = $tenantData['location_id'];
         $allSystemAllocatedToThisTenant = $tenantData['system_id'];
         if(isset($allLocations) && !empty($allLocations)){
        foreach($allLocations as $locationId){
           
             // send notification which are global i.e not belong to any particular system like checklist
          $query = $this->tenantDb->query("SELECT data,time_of_notification,methodName as configureFor FROM Global_configuration WHERE metaData ='cronNotificationMail' AND  location =".$locationId);    
          $allGlobalNotifications = $query->result_array();
         
          if(isset($allGlobalNotifications) && !empty($allGlobalNotifications)){
          foreach ($globalNotifications as $globalNotificationMethodName) {
              
              $resultArrayGlobalNotification = array_filter($allGlobalNotifications, function ($item) use ($globalNotificationMethodName) {
               return  $item['configureFor'] == $globalNotificationMethodName;
             });
           $resultArrayGlobalNotification = reset($resultArrayGlobalNotification);
           $current_time = date('h:i A');
           $current_time = strtotime($current_time);
           $resultArraytime_of_notification = (isset($resultArrayGlobalNotification['time_of_notification']) ? unserialize($resultArrayGlobalNotification['time_of_notification']) : '');
        //   echo "<pre>"; print_r($resultArraytime_of_notification); exit;
            if(isset($resultArraytime_of_notification[$globalNotificationMethodName]) && $current_time == strtotime($resultArraytime_of_notification[$globalNotificationMethodName])){
           $sendNotificationEmailTo =  unserialize($resultArrayGlobalNotification['data']);
           $this->$globalNotificationMethodName($sendNotificationEmailTo, $locationId,$resultArraytime_of_notification[$globalNotificationMethodName]);  
         } 
          }
          }
           
          foreach($allSystemAllocatedToThisTenant as $systemId){
              
            $query = $this->tenantDb->query("SELECT data,time_of_notification,configureFor FROM NotificationEmailConfiguration WHERE  system_id = ".$systemId." AND location =".$locationId);
            $allNotificationOfThisSystem = $query->result_array();
           
            if(isset($allNotificationOfThisSystem) && !empty($allNotificationOfThisSystem)){

            $notificationTocallMethodNames = (isset($listOfNotificationSystemWise[$systemId]) ? $listOfNotificationSystemWise[$systemId] : '');
          
            // this foreach, because one system might have more than one notification to be executed using cron job
        
            if(isset($notificationTocallMethodNames) && is_array($notificationTocallMethodNames) && !empty($notificationTocallMethodNames)){
            foreach ($notificationTocallMethodNames as $notificationTocallMethodName) {
            //      echo $systemId;
            
              $resultArray = array_filter($allNotificationOfThisSystem, function ($item) use ($notificationTocallMethodName) {
                  if(isset($item['configureFor'])){
                   return $item['configureFor'] == $notificationTocallMethodName;   
                  }else{
                   return false;   
                  }
             
             });
             $resultArray = reset($resultArray);
             
               
             // echo "<pre>"; print_r($notificationTocallMethodName);  print_r($allNotificationOfThisSystem); 
              $current_time = date('h:i A');
              $current_timestamp = strtotime($current_time);
            //   echo "<pre>"; print_r($allNotificationOfThisSystem); print_r($resultArray['time_of_notification']); echo "</br>";
            //   echo "time = ".date('h:i A');  echo "</br>";
            //   echo "timeSTMP = ".($resultArray['time_of_notification']);  echo "</br>";
             // To send cron job notification on specified time;  
                if(isset($resultArray['time_of_notification']) && $current_timestamp == strtotime($resultArray['time_of_notification'])){
                    
                  $sendNotificationEmailTo =  unserialize($resultArray['data']); 
                   $this->$notificationTocallMethodName($sendNotificationEmailTo, $locationId);  
                }
         
             }
    
            }
      
            } 

          }

         }     
         }
         
         
        }
         
    }
    
   public function sendMail($to,$subject,$message,$cc=''){
        // exit;
        $this->phpmailer = new PHPMailer(true);
       
        $this->phpmailer->isSMTP();
        $this->phpmailer->SMTPDebug = 2; // Set to 2 for debugging
        $this->phpmailer->Host = 'smtp.office365.com';
        $this->phpmailer->Port = '25';
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Username = 'info@bizadmin.com.au';
        $this->phpmailer->Password = '1800@Footscray123!';
        $this->phpmailer->SMTPSecure = 'tls';
        $this->phpmailer->CharSet = 'UTF-8';
        $this->phpmailer->IsHTML(true);
        // $this->sendEmailAtRunTimeForCronJobs('adityakohli467@gmail.com','TEST ADY CRONN','ADYYYYYCRONN','',1);
        // Receipent
         if(isset($to[0])){
         $mailTo = explode(",",$to[0]);   
         }else{
           $mailTo = 'kaushika@kjcreate.com.au';  
         }
      
            if (is_array($mailTo)) {
             foreach ($mailTo as $recipient) {
                $this->phpmailer->addAddress($recipient);
             }
              } else {
            $this->phpmailer->addAddress($mailTo);
           }
           
           if($cc !=''){
             if (is_array($cc)) {
             foreach ($cc as $CCrecipient) {
                $this->phpmailer->addCC($CCrecipient);
             }
              } else {
            $this->phpmailer->addCC($cc);
           }
             
           }
        $this->phpmailer->setFrom('info@bizadmin.com.au','Bizadmin Notification');
        $this->phpmailer->Subject = $subject;
        $this->phpmailer->Body = $message;
        $this->phpmailer->send();
        
    }
   public function checklistNotifyMail($res,$sendGlobalNotificationEmailTo,$currentLocationID){
      
        $result = array_filter($res, function ($item) {
          return !isset($item->is_completed) || $item->is_completed == 0;
        });
        
        $LocationGroupedresult = [];
      if(!empty($result)){
      foreach ($result as $item) {
      $locationId = $item->location_id;
      if (!isset($LocationGroupedresult[$locationId])) {
        $LocationGroupedresult[$locationId] = [];
      }
      $LocationGroupedresult[$locationId][] = $item;
      }    
      }
      
     if(!empty($LocationGroupedresult)){
      foreach ($LocationGroupedresult as $locationID => $LocationWiseData) {
       if(!empty($sendGlobalNotificationEmailTo) && $locationID == $currentLocationID){

         $data['LocationWiseDataOfChecklists'] = $LocationWiseData;
         $data['locationName'] = fetchLocationNamesFromIds($currentLocationID,true);
      $mailContent = $this->load->view('Mail/inCompletedChecklistList',$data,TRUE);
     
      $this->sendMail($sendGlobalNotificationEmailTo, 'CHECKLIST NOT COMPLETED', $mailContent,'kaushika@kjcreate.com.au');
    //   echo "<pre>"; print_r($maildIds); exit;
        }
           
      }
     }   
   }
   // morning shift checklist notification(MSchecklistNotification_mail)
   public function MSchecklistNotification_mail($sendGlobalNotificationEmailTo,$currentLocationID,$deadlineTime=''){
        
      $res = $this->cron_model->incompletedChecklist($this->tenantDb,$deadlineTime);
      $this->checklistNotifyMail($res,$sendGlobalNotificationEmailTo,$currentLocationID);   
    }
    // Afternoon shift checklist notification(ASchecklistNotification_mail)
   public function ASchecklistNotification_mail($sendGlobalNotificationEmailTo,$currentLocationID,$deadlineTime=''){
      $res = $this->cron_model->incompletedChecklist($this->tenantDb,$deadlineTime);
      $this->checklistNotifyMail($res,$sendGlobalNotificationEmailTo,$currentLocationID);
   } 
    // Evening shift checklist notification(ASchecklistNotification_mail)
   public function ESchecklistNotification_mail($sendGlobalNotificationEmailTo,$currentLocationID,$deadlineTime=''){
      $res = $this->cron_model->incompletedChecklist($this->tenantDb,$deadlineTime);
      $this->checklistNotifyMail($res,$sendGlobalNotificationEmailTo,$currentLocationID);
   }  
   
    
    function fetchTempEquipNotRecorded($locationId) {
     $sql = "SELECT 
    TEMP_eqipment.*, 
    TEMP_prepArea.site_id, 
    TEMP_prepArea.prep_name, 
    TEMP_eqipment.prep_id
FROM 
    TEMP_eqipment
LEFT JOIN 
    TEMP_prepArea ON TEMP_prepArea.id = TEMP_eqipment.prep_id
LEFT JOIN 
    TEMP_sites ON TEMP_sites.id = TEMP_prepArea.site_id
WHERE 
    TEMP_eqipment.is_deleted = 0
    " . ($locationId ? "AND TEMP_eqipment.location_id = " . $locationId : "") . "
    AND TEMP_eqipment.status = 1
    AND TEMP_eqipment.id NOT IN(
    SELECT TEMP_eqipment.id FROM TEMP_eqipment LEFT JOIN TEMP_record_tempHistory on TEMP_eqipment.id = TEMP_record_tempHistory.equip_id WHERE DATE(TEMP_record_tempHistory.date_entered) = CURDATE()
    )
    AND (
        (TEMP_eqipment.schedule_at = 0)
        OR (
            TEMP_eqipment.schedule_at = 1 
            AND (
                DAYOFWEEK(CURDATE()) = DAYOFWEEK(TEMP_eqipment.schedule_date)
            )
        )
        OR (
            TEMP_eqipment.schedule_at = 2 
            AND (
                DAYOFMONTH(CURDATE()) = DAYOFMONTH(TEMP_eqipment.schedule_date)
            )
        )
    )";
    $query = $this->tenantDb->query($sql);
   
    
   
    return $query;
}
    function fetchNonCompletedCleanTask($locationId){
        
        $currentDayOfWeek = date('w');
        $currentDayOfMonth = date('d');
        $currentWeekNumber = ceil($currentDayOfMonth / 7);
        $currentMonth = date('m');
        $currentYear = date('Y');
        $currentDayName = date('l');
       
      $this->tenantDb->select('Ct.task_name, Ct.task_time, Ct.location_id, CLEAN_prepArea.site_id, CLEAN_prepArea.prep_name, Ct.prep_id');
     $this->tenantDb->from('CLEAN_tasks as Ct');
$this->tenantDb->join('CLEAN_prepArea', 'CLEAN_prepArea.id = Ct.prep_id', 'left');
$this->tenantDb->join('CLEAN_sites', 'CLEAN_sites.id = CLEAN_prepArea.site_id', 'left');
$this->tenantDb->where('NOT EXISTS (SELECT 1 FROM CLEAN_record_History WHERE CLEAN_record_History.task_id = Ct.id AND DATE(CLEAN_record_History.date_entered) = CURDATE())', NULL, FALSE);
 $this->tenantDb->where('Ct.is_deleted', 0);
 $this->tenantDb->where('Ct.status', 1);
 $this->tenantDb->where('Ct.location_id', $locationId);
$this->tenantDb->group_start();

        // Check for dynamic day
        $this->tenantDb->or_where("(Ct.schedule_at = 2 AND Ct.schedule_type = 'day' AND Ct.schedule_dayName = '$currentDayName' AND Ct.repeatWhichWeek = $currentWeekNumber AND Ct.schedule_date <= NOW())");

        // Check for weekly date-based schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 1  AND Ct.schedule_date <= NOW() AND TIMESTAMPDIFF(DAY, Ct.schedule_date, NOW()) % 7 = 0)");

        // Check for monthly date-based schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 2 AND Ct.schedule_type = 'date' AND Ct.schedule_date <= NOW() AND DAY(Ct.schedule_date) = DAY(NOW()))");
        
        // Check for quarterly schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 3  AND Ct.schedule_date <= NOW() AND TIMESTAMPDIFF(MONTH, Ct.schedule_date, NOW()) % 3 = 0)");
        
         // Check for every 4 months schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 4  AND Ct.schedule_date <= NOW() AND TIMESTAMPDIFF(MONTH, Ct.schedule_date, NOW()) % 4 = 0)");

        // Check for semi-annual schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 5  AND Ct.schedule_date <= NOW() AND TIMESTAMPDIFF(MONTH, Ct.schedule_date, NOW()) % 6 = 0)");

        // Check for daily schedule
        $this->tenantDb->or_where("(Ct.schedule_at = 0)");
        
       

        $this->tenantDb->group_end();

       $query = $this->tenantDb->get();


        return $query;
    }
    
    // LIST OF METHODS TO BE CALLED BY CRON JOB FOR ALL THE SYSTEM WISE
    
    public function uncompleted_equipTempMail($mailToAdress,$locationId){
       
            $query = $this->fetchTempEquipNotRecorded($locationId);
            $data['locationName'] = fetchLocationNamesFromIds($locationId,true);
	        if ($query !== false) {
             $data['equipLists'] = $query->result();
             $mailContent = $this->load->view('Mail/TempEquipNotRecorded',$data,TRUE);
            //  echo "<pre>"; print_r($mailToAdress); exit;
             if($mailToAdress !='' && !empty($data['equipLists'])){
             $this->sendMail($mailToAdress,'Temperature not recorded for '.$data['locationName'],$mailContent);     
              }
            }
              
    }
    public function uncompleted_cleanTaskMail($mailToAdress,$locationId){
       
            $query = $this->fetchNonCompletedCleanTask($locationId);
            $data['locationName'] = fetchLocationNamesFromIds($locationId,true);
	        if ($query !== false) {
	        $data['taskLists'] = $query->result();
             $mailContent = $this->load->view('Mail/cleanTaskNotCompleted',$data,TRUE);
              if($mailToAdress !='' && !empty($data['taskLists'])){
              $this->sendMail($mailToAdress,'Cleaning Task not completed for '.$data['locationName'],$mailContent);     
              }
            }
              
    }
    
    
    
    function shiftNotStartedMail($mailToAdress,$locationId){
        
      $res = $this->cron_model->shiftNotStartedMail($this->tenantDb,$locationId);  
      if(isset($res) && !empty($res)){
          $data['tills'] = $res;
          $data['locationName'] = fetchLocationNamesFromIds($locationId,true);
          $mailContent = $this->load->view('Mail/shiftNotStartedMail',$data,TRUE);
        
          if($mailToAdress !=''){
             $this->sendMail($mailToAdress,'Start Shift Incomplete for '.$data['locationName'],$mailContent);     
           }
      }
      
        
    }
    
    function shiftNotEndedMail($mailToAdress,$locationId){
      $res = $this->cron_model->shiftNotStartedAndEndedMail($this->tenantDb,$locationId);
    
      $data['locationName'] = fetchLocationNamesFromIds($locationId,true);
      if(isset($res) && !empty($res)){
          $data['tills'] = $res;
          $mailContent = $this->load->view('Mail/shiftNotEndedMail',$data,TRUE);
    if($mailToAdress !=''){
             $this->sendMail($mailToAdress,'End Shift Incomplete for '.$data['locationName'],$mailContent);     
           }      
      }
    }
    
    function updateMonthlyStockOpeningCount(){
      $arrayWithTenantDetails = $this->fetchAllCurrentSystemOfAllTenant();
        
        foreach($arrayWithTenantDetails as $tenant_identifier => $tenantData){
         $this->tenantDb = $this->load->database($tenant_identifier, TRUE);
          // Get the previous month and year
           $prev_month = date('F', strtotime('-1 month'));
           $prev_year = date('Y', strtotime('-1 month'));

         // Check if the previous month is December
          if ($prev_month == 'December') {
           // If previous month is December, fetch data from last year December
           $prev_year--;
           $prev_month = 'December';
           }

// Get the opening stock count from the previous month
$query = $this->tenantDb->select('supplier_id, location_id, product_id, closing_stock_count')
                ->from('SUPPLIERS_monthly_stockCount')
                ->where('month_name', $prev_month)
                ->where('year_name', $prev_year)
                ->get();

// Insert the opening stock count for the current month
    if ($query->num_rows() > 0) {
      $rows = $query->result_array();
      foreach ($rows as $row) {
        $data = array(
            'supplier_id' => $row['supplier_id'],
            'location_id' => $row['location_id'],
            'product_id' => $row['product_id'],
            'opening_stock_count' => $row['closing_stock_count'], 
            'month_name' => date('F'),
            'year_name' => date('Y'),
            'created_at' => date('Y-m-d'),
        );
        $this->tenantDb->insert('SUPPLIERS_monthly_stockCount', $data);
    }
}  
    } 
    }
    
    /**
     * DISABLED: HTTP Endpoint for Cron Job 1: Auto-send unsent orders
     * This can be called via curl from cPanel
     * NOT NEEDED ANYMORE since we fixed buttonType to always be 'sendorder'
     * CRON JOBS ARE NOT USED - COMMENTED OUT
     */
    /* DISABLED - CRON NOT USED
    public function autoSendUnsentOrders() {
        // Load the Orderportal Order controller
        require_once APPPATH.'modules/Orderportal/controllers/Order.php';
        $orderController = new Order();
        
        echo "<h3>Auto-Send Unsent Orders Cron Job</h3>";
        echo "<p><strong>NOTE:</strong> This cron job is NO LONGER NEEDED since we fixed the code to always use buttonType='sendorder'</p>";
        echo "<p>Started at: " . date('Y-m-d H:i:s') . "</p>";
        echo "<hr>";
        
        // Execute the auto-send function
        $orderController->autoSendUnsentOrders();
        
        echo "<hr>";
        echo "<p>Completed at: " . date('Y-m-d H:i:s') . "</p>";
    }
    */
    
    /**
     * DISABLED: HTTP Endpoint for Cron Job 2: Auto-update forgotten order statuses
     * This can be called via curl from cPanel
     * STILL USEFUL - Auto-completes today's orders to "delivered" status
     * CRON JOBS ARE NOT USED - COMMENTED OUT
     */
    /* DISABLED - CRON NOT USED
    public function autoUpdateForgottenOrderStatuses() {
        // Load the Orderportal Order controller
        require_once APPPATH.'modules/Orderportal/controllers/Order.php';
        $orderController = new Order();
        
        echo "<h3>Auto-Update Forgotten Order Statuses Cron Job</h3>";
        echo "<p>Purpose: Auto-complete today's orders to 'delivered' status if chef/delivery forgot to update</p>";
        echo "<p>Started at: " . date('Y-m-d H:i:s') . "</p>";
        echo "<hr>";
        
        // Execute the auto-update function
        $orderController->autoUpdateForgottenOrderStatuses();
        
        echo "<hr>";
        echo "<p>Completed at: " . date('Y-m-d H:i:s') . "</p>";
    }
    */

}
