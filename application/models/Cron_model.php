<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}


	public function fetchAllRecord($dbInstance,$table_name,$id='',$result_type=''){
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
		$query=$this->$dbInstance->query("SELECT * FROM ".$table_name." WHERE ".$whereCon );
    	$res=	($result_type == '' ? $query->result() : $query->result_array());
	
		return $res;
	}
	public function fetchRecord($dbInstance,$table_name,$id='',$columnsToFetch=''){
	    $this->db = $dbInstance;
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
	    if($columnsToFetch==''){
	      $columnsToFetch = '*';  
	    }
		$query=$this->db->query("SELECT ".$columnsToFetch." FROM ".$table_name." WHERE ".$table_name."_status != 0 AND ".$whereCon );
		$res=$query->result();
		return $res;
	}
	
	function incompletedChecklist($dbInstance,$deadlineTime=''){
	    $this->tenantDb = $dbInstance;
	     $query = $this->tenantDb->query("SELECT DISTINCT
    GC.id,
    GC.title,
    GC.deadline_time,
    GC.descr,
    GC.system_id,
    GC.location_id,
    GCTDC.checklistComments,
    (
        SELECT JSON_ARRAYAGG(
            JSON_OBJECT(
                'subChecklistDescr', GSC.descr
            )
        )
        FROM Global_subchecklist GSC
        WHERE GC.id = GSC.parent_checklistId AND (GSC.is_completed IS NULL OR GSC.is_completed = 0)
    ) AS subchecklists
    
FROM Global_checklist GC
LEFT JOIN Global_subchecklist GSC ON GC.id = GSC.parent_checklistId
LEFT JOIN Global_checklistToDateCompleted GCTDC ON GC.id = GCTDC.checklist_id
WHERE
  (
    GC.is_deleted = 0 AND 
    GC.status = 1 AND
    STR_TO_DATE(GC.deadline_time, '%h:%i %p') < STR_TO_DATE('".$deadlineTime."', '%h:%i %p')
  )
  AND (
      (GC.schedule_at = 0)
      OR (GC.schedule_at = 1 AND DATE_ADD(GC.checklist_start_date, INTERVAL 1 WEEK) = CURDATE())
      OR (GC.schedule_at = 2 AND DATEDIFF(CURDATE(), GC.checklist_start_date) % 15 = 0)
      OR (GC.schedule_at = 3 AND DATE_ADD(GC.checklist_start_date, INTERVAL 1 MONTH) = CURDATE())
      OR (GC.schedule_at = 4 AND DATE_ADD(GC.checklist_start_date, INTERVAL 1 YEAR) = CURDATE())
      OR (
          (GC.checklist_end_date IS NULL AND CURDATE() = GC.checklist_start_date)
          OR
          (GC.checklist_end_date IS NOT NULL AND CURDATE() BETWEEN GC.checklist_start_date AND GC.checklist_end_date)
      )
  )
ORDER BY GC.sort_order ASC;
            ");
     $queryCK = $this->tenantDb->query("SELECT checklist_id,is_completed , date_completed  from Global_checklistToDateCompleted  where  date_completed = CURDATE()");
           
            
	    if ($query !== false) {
	       $res =  mergeArrayBasedOnCommonKey($query->result(),$queryCK->result());
         
        } else {
          $res = array();
        }     
        
        return $res;
            
	}
	
	function shiftNotStartedMail($dbInstance,$locationId){
	   $this->tenantDb = $dbInstance;
	     $query = $this->tenantDb->query("SELECT ct.id, ct.till_name, MAX(cd.created_date) AS created_date
        FROM `CASH_ci_tills` ct
        LEFT JOIN `CASH_ci_cash_deposit` cd ON ct.id = cd.till_id
        WHERE (cd.created_date IS NULL OR (cd.created_date IS NOT NULL AND cd.created_date < CURRENT_DATE()))
        AND ct.id NOT IN (
        SELECT ct.id FROM `CASH_ci_tills` ct JOIN `CASH_ci_cash_deposit` cd ON ct.id = cd.till_id WHERE cd.created_date IS NOT NULL AND DATE(cd.created_date) = CURRENT_DATE()
         )
        AND ct.location_id = ".$locationId." AND ct.status = 1 AND ct.deleted = 0 GROUP BY ct.id"); 
        
      return $query->result_array();
	    
	}
	
	function shiftNotStartedAndEndedMail($dbInstance,$locationId){
	    $this->tenantDb = $dbInstance;
	    
	     $query = $this->tenantDb->query("SELECT ct.id, ct.till_name, MAX(cd.created_date) AS created_date
        FROM `CASH_ci_tills` ct
        LEFT JOIN `CASH_ci_cash_deposit` cd ON ct.id = cd.till_id
        WHERE (cd.created_date IS NULL OR (cd.created_date IS NOT NULL AND cd.created_date < CURRENT_DATE()))
        AND ct.id NOT IN (
        SELECT ct.id FROM `CASH_ci_tills` ct JOIN `CASH_ci_cash_deposit` cd ON ct.id = cd.till_id WHERE cd.created_date IS NOT NULL AND DATE(cd.created_date) = CURRENT_DATE()
         )
        AND ct.location_id = ".$locationId." AND ct.status = 1 AND ct.deleted = 0 GROUP BY ct.id");
       $tillshifNotStarted =  $query->result_array();
        
	     $queryEnded = $this->tenantDb->query(
	    "SELECT ct.id, ct.till_name FROM `CASH_ci_tills` ct LEFT JOIN `CASH_ci_cash_deposit` cd ON ct.id = cd.till_id
          WHERE cd.created_date = CURRENT_DATE() AND cd.shiftEnded = 0 AND ct.location_id = ".$locationId." AND ct.status = 1 AND ct.deleted = 0");
          
    	$tillshifNotEnded = $queryEnded->result_array();
    	
    	
    	
    	if(is_array($tillshifNotStarted) && is_array($tillshifNotEnded) && !empty($tillshifNotEnded) && !empty($tillshifNotStarted)){
    	$result =  array_merge($tillshifNotStarted,$tillshifNotEnded);   
    	}else{
    	 $result =  $tillshifNotEnded;
    	}
    	
	    return $result;
	}
   
	
}
