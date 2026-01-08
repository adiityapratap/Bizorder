<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	} 
	
	public function fetch_FronteendCustomers(){
	  $opencartdb = $this->load->database('opecart', TRUE);
	  $userId = $this->session->userdata('user_id');
	  if($userId ==1 || $userId == 2){
       $userId = '1,2'; 
      }
	  $sql = "SELECT * FROM oc_customer where location_id IN (".$userId.") and cost_center = 'true'";
	 
	  $query=$opencartdb->query($sql);
		$cost_centres=$query->result();
	   return $cost_centres;
	}
	public function getCostCenterById($customer_id){
	    $opencartdb = $this->load->database('opecart', TRUE);
	    $sql = "SELECT * FROM oc_customer where customer_id=".$customer_id;
	  $query=$opencartdb->query($sql);
	  $cost_centreCustomerDetails=$query->result();
	  return $cost_centreCustomerDetails;
	}
	
	public function approve_cost_center($customer_id,$approvestatus){
	  $opencartdb = $this->load->database('opecart', TRUE);
	  $cost_centreDetails = $this->getCostCenterById($customer_id);
	 
	 
	  if(is_null($cost_centreDetails[0]->account_number) && is_null($cost_centreDetails[0]->account_pin)){
	  $sqlUpdate = "Update oc_customer set approved=".(int)$approvestatus." where customer_id=".(int)$customer_id;
	  $queryUpdate=$opencartdb->query($sqlUpdate);
	  $resMail = 'true';
	  }else{
	   $sqlUpdate = "Update oc_customer set approved=".(int)$approvestatus." where customer_id=".$customer_id;
	  $queryUpdate=$opencartdb->query($sqlUpdate);
	  if($approvestatus == 1){
	     $resMail = 'true'; 
	  }else{
	    $resMail = 'false';  
	  }
	  
	  }
		
	 return $resMail;
	}
     public function updateCostCenter($customer_id,$accountNo,$accountPin,$fullname,$location_id,$email,$telephone,$company_name,$department_name,$accounts_contact_number,$accounts_point_of_contact,$location_name){
	  $opencartdb = $this->load->database('opecart', TRUE);
	  $sqlUpdate = "Update oc_customer set location_name ='".$location_name."',accounts_point_of_contact ='".$accounts_point_of_contact."',accounts_contact_number ='".$accounts_contact_number."',company_name ='".$company_name."',department ='".$department_name."',account_number ='".$accountNo."',account_pin='".$accountPin."',firstname='".$fullname."',email='".$email."',telephone='".$telephone."' where customer_id=".(int)$customer_id;
	  $queryUpdate=$opencartdb->query($sqlUpdate);
	  
	  $resMail = 'true';
	  
		
	 return $resMail;
	}
	public function fetchLocations($isdelivery){
	  $opencartdb = $this->load->database('opecart', TRUE);
	    $query=$opencartdb->query("SELECT * FROM zelocations where status = '1' AND is_delivery =".$isdelivery);  
	  return $query->result();
	}
	
public function fetch_survey($id=''){
 $userId = $this->session->userdata('user_id');
 if($id ==''){
   $query=$this->db->query("SELECT * FROM survey where location_id =".$userId);  
   	return $query->result();
 }else{
  
    $query=$this->db->query("SELECT * FROM survey where location_id =".$userId." AND id =".$id);
    // echo "SELECT * FROM survey s LEFT JOIN store st ON (s.location_id = st.location_id) where s.location_id =".$userId." AND s.id =".$id;exit;
    return $query->result_array();
 }


 
}

public function unapprovedQuotes(){
   
    $dayaftertommrowDate = $date = date('Y-m-d', strtotime("+2 day"));
     $query=$this->db->query("SELECT * FROM quote where  and order_status NOT IN(2,7,0,8) AND delivery_date_time LIKE '%".$dayaftertommrowDate."%'");  
   	return $query->result();
}

public function TodayDeliveryNotification(){
    $TodayDate = $date = date('Y-m-d');
     $query=$this->db->query("SELECT * FROM quote where  order_status NOT IN(0,8) AND delivery_date_time LIKE '%".$TodayDate."%'");  
   	return $query->result();
}

public function sevenDaysDelayNotification(){
    $weekPrevoiusDate = $date = date('Y-m-d', strtotime("-7 day"));
     $query=$this->db->query("SELECT * FROM quote where  order_status  IN(7) AND delivery_date_time LIKE '%".$weekPrevoiusDate."%'");  
   	return $query->result();
}
public function fourteenDaysDelayNotification(){
    $weekPrevoiusDate = $date = date('Y-m-d', strtotime("-14 day"));
     $query=$this->db->query("SELECT * FROM quote where  order_status  IN(7) AND delivery_date_time LIKE '%".$weekPrevoiusDate."%'");  
   	return $query->result();
}
public function update_GST_status($id,$status){
    
    $query=$this->db->query("UPDATE orders SET GST_status=".$status." WHERE order_id=".$id);
    
    if($query){
        return true;
    }else{
        return false;
    }
    
}	
	public function insert_feedback($data){
	   if($data['ofrom'] == 'frontend'){
	       $this->db->query("INSERT INTO customer_feedback(order_id,cname,company_name,delivery_date,website_experience,location_id) VALUES (".$data['order_id'].",'".$data['cname']."','".$data['company_name']."','".$data['delivery_date']."','".$data['website_experience']."',".$data['location_id'].")");
	   }else{
	       $this->db->query("INSERT INTO customer_feedback(order_id,cname,company_name,delivery_date,deliveredOnTime,commentText,suggestions,location_id) VALUES (".$data['order_id'].",'".$data['cname']."','".$data['company_name']."','".$data['delivery_date']."','".$data['deliveredOnTime']."','".$data['commentText']."','".$data['suggestions']."',".$data['location_id'].")");
	   }
	    //echo "INSERT INTO customer_feedback(order_id,cname,company_name,delivery_date,FOOD,PRICING,MENU,EXPERIENCE,DELIVERY,PACKAGING,SERVICE,hearfrom,commentText) VALUES (".$data['order_id'].",'".$data['cname']."','".$data['company_name']."','".$data['delivery_date']."',".$data['FOOD'].",".$data['PRICING'].",".$data['MENU'].",".$data['EXPERIENCE'].",".$data['DELIVERY'].",".$data['PACKAGING'].",".$data['SERVICE'].",'".$data['hearfrom']."','".$data['commentText']."')"; exit;
	    
	     return true;
	    
	}
	public function checkCustomerOldFeedbackStatus($customer_id){
	    $opencartdb = $this->load->database('opecart', TRUE);
	    $sql = "SELECT is_feedback_given FROM oc_customer where customer_id=".$customer_id;
	  $query=$opencartdb->query($sql);
	  $customerfeedbakstatus=$query->result();
	  return $customerfeedbakstatus;
	}
	
		public function UpdateCustomerFeedbackStatus($customer_id){
	     $opencartdb = $this->load->database('opecart', TRUE);
	        $sql = "Update oc_customer set is_feedback_given=1 where customer_id=".$customer_id;
	        $query=$opencartdb->query($sql);
	}
	public function getOrder_feedback($oid=''){
	  if($oid != ''){
	      $condition="where order_id = ".$oid;
	  }
	     $query=$this->db->query("SELECT * FROM customer_feedback ".$condition);
	     return $query->result();
	}
	public function getCustomerFromCustomerId($customerId){
	    if($customerId != ''){
	      $condition="where customer_id = ".$customerId;
	  }
	
	 
	     $query=$this->db->query("SELECT * FROM customer ".$condition);
	     return $query->result(); 
	}
	public function getFrontendCustomers($customerId){
	   
	    $opecartdb = $this->load->database('opecart', TRUE);
		$sql = "SELECT * FROM oc_customer WHERE customer_id = ".$customerId;
	 	 $queryCust=$opecartdb->query($sql);
	 	 $custResult=$queryCust->result();
	 	 	return $custResult;
	}
	
	public function fetch_all_feedback($params=''){
	    
	    
	     $userId = $this->session->userdata('user_id');
	   if($userId ==1 || $userId == 2){
           $userId = '1,2'; 
        }
	  	if(!empty($params['date_to']) &&  !empty($params['date_from']) && $params['date_from'] == $params['date_to']){
			   
			    $fromWhere="AND cf.delivery_date LIKE '%".date("Y-m-d",strtotime($params['date_from']))."%'";
			    $toWhere="";
			    
			}elseif(!empty($params['date_to']) &&  !empty($params['date_from']) && $params['date_from'] != $params['date_to']){
			    $fromWhere=" AND cf.delivery_date BETWEEN '".date("Y-m-d",strtotime($params['date_from']))."' AND '".date("Y-m-d",strtotime($params['date_to']))."'";
			}
			else{
			if(!empty($params['date_from']))
				$fromWhere=" AND cf.delivery_date >='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere="";
			
			if(!empty($params['date_to']))
				$toWhere="AND cf.delivery_date <='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="";
			}
			
			if(!empty($params['textFilter']))
				$likePercent="AND cf.commentText LIKE '%".$params['textFilter']."%'";
			else $likePercent="";
			
        
         if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
           $query=$this->db->query("SELECT COUNT(order_id) as count FROM customer_feedback as cf LEFT JOIN store as s ON s.location_id = cf.location_id where s.user_id IN (".$userId.") ".$fromWhere.$toWhere.$likePercent);
          
        }else{ 
            
	     $query=$this->db->query("SELECT * FROM customer_feedback as cf LEFT JOIN store as s ON s.location_id = cf.location_id where s.user_id IN (".$userId.") ".$fromWhere.$toWhere.$likePercent);
        }
	     return $query->result();
        
	}
	
	
	public function filter_sample_query($type=''){
	    
	    if($type=='delete_duplicate'){ 
	         $query=$this->db->query("DELETE e.*
FROM sample e
WHERE OrderID IN
 (SELECT OrderID
   FROM (SELECT MIN(OrderID) as id
          FROM sample e2
          GROUP BY BillingEmail
          HAVING COUNT(*) > 1) x);");
	return $query->result();
	    }else{
	         $query=$this->db->query("SELECT * FROM sample where Quantity > 1 ");
	    	return $query->result();
	    }
	     
	}

	
	public function fetch_all_order($order_id='',$userId='',$guid=''){

	    

	$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id WHERE   (o.branch_id = ".$userId." ) and (o.delivery_date_time < CURDATE()) and (o.order_status !=3)");

	return $query->result();
	}
	
	public function fetch_all_user($user_id=''){
	    
	    if(isset($user_id) && $user_id != ''){
	       
	        $query=$this->db->query("SELECT * FROM user  where user_id = ".$user_id); 
	    }else{
	        
	        $query=$this->db->query("SELECT * FROM user"); 
	    }
	    
	     
	     	return $query->result();
	}
	
	
	public function fetch_unpaid_orders(){
	    
	    
	        $qry="select o.order_id,o.order_total,c.email,c.firstname from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  where  o.order_status != 3 and o.order_status != 0 and o.date_added <= CURRENT_DATE() - INTERVAL 1 MONTH order BY o.date_added DESC";

      $query = $this->db->query($qry);
			

			return $query->result();
	    
	    
	}
	
	
	public function fetch_order_history($params='',$order_date='',$isProduction=false)
	{      	
	   //echo $userId; exit;
	   $userId = $this->session->userdata('branch_id');
	   $branch_id = $this->session->userdata('branch_id');
       
	    
		if(empty($params))
		{
       if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= "'.date('y-m-d').'"';
        
    }else if($order_date =='past_orders'){
        
        $sqll = 'o.delivery_date_time < "'.date('y-m-d').'"';
        
    }
   
   			$qry="select o.*,c.*,v.* from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  
LEFT JOIN coupon v ON o.coupon_id=v.coupon_id 
LEFT JOIN company co ON c.company_id=co.company_id 
LEFT JOIN user_postcode up on o.postcode = up.postal_code 
where  $sqll and o.order_status != 0  and o.branch_id=$branch_id ORDER BY o.order_id desc";

            $query = $this->db->query($qry);
			return $query->result();
	}
		else{
		    
		 $sqll = 1;
		if(empty($params['date_from']) && empty($params['date_to'])){    
		    
	if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= CURDATE()';
    }else if($order_date =='past_orders'){
        $sqll = 'o.delivery_date_time < CURDATE()';
    }
		}	   
			
			if(!empty($params['sort_order'])){
				if($params['sort_order']==0){
					$order_by='o.delivery_date_time asc';
				}
				else if($params['sort_order']==1){
					$order_by='o.delivery_date_time desc';
				}
				else if($params['sort_order']==2){
					$order_by='o.order_id asc';
				}
				else $order_by='o.order_id desc';
			}
			else $order_by='o.delivery_date_time asc';
			
			if(!empty($params['order_date']) && $isProduction){ 	
			    $orderdateWhere="o.delivery_date_time LIKE '%".date("Y-m-d",strtotime($params['order_date']))."%'";
			}
			 else if(!empty($params['order_date'])){
			   $orderdateWhere="o.date_added LIKE '%".date("Y-m-d",strtotime($params['order_date']))."%'";   
			 }  
			else{
			     $orderdateWhere="1";
			}
			
		
			if(!empty($params['date_to']) &&  !empty($params['date_from']) && $params['date_from'] == $params['date_to']){
			   
			    $fromWhere="o.delivery_date_time BETWEEN '".date("Y-m-d",strtotime($params['date_from']))." 00:00:01' AND '".date("Y-m-d",strtotime($params['date_from']))." 23:59:59'";
			    $toWhere="1";
			    
			}else{
			if(!empty($params['date_from']))
				$fromWhere="o.delivery_date_time >='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere=$sqll;
			
			if(!empty($params['date_to']))
				$toWhere="o.delivery_date_time<='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="1";
			}
			if(isset($params['company']))
				$companyWhere="c.company_id=".$params['company'];
			else $companyWhere="1";
		
			if(isset($params['customer']))
				$cWhere="c.customer_id=".$params['customer'];
			else $cWhere="1";
			
			if(isset($params['location']))
				$userWhere="o.user_id=".$params['location'];
			else $userWhere="1";
			if(isset($params['order_no']) && $params['order_no'] !='unset')
				$orderidwhere="o.order_id=".$params['order_no'];
			else $orderidwhere="1";
			
// echo 	"SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department WHERE ".$orderdateWhere." AND ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$orderidwhere." AND ".$cWhere." and  o.order_status != 0  and o.branch_id=$branch_id ORDER BY ".$order_by;

			$query=$this->db->query("SELECT * FROM orders o LEFT JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department_id WHERE ".$orderdateWhere." AND ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$orderidwhere." AND ".$cWhere." and  o.order_status != 0  and o.branch_id=$branch_id ORDER BY ".$order_by);
   
   	return $query->result();
		}
	}
	
		public function production_fetch_order_history($params='',$order_date='',$isProduction=false)
	{      	
	   //echo $userId; exit;
	   $userId = $this->session->userdata('branch_id');
	   $branch_id = $this->session->userdata('branch_id');
       
	    
		if(empty($params))
		{
       if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= CURDATE()';
        
    }
    
   			$qry="select o.*,c.*,v.*,co.* from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  
LEFT JOIN coupon v ON o.coupon_id=v.coupon_id 
LEFT JOIN company co ON c.company_id=co.company_id 

where  $sqll and o.order_status != 0  and o.branch_id=$branch_id ORDER BY o.delivery_date_time ASC";

            $query = $this->db->query($qry);
			return $query->result();
	}
		else{
		    
		    
	if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= CURDATE()';
    }
		 
			if(!empty($params['order_date'])){ 	
			    $orderdateWhere="delivery_date_time LIKE '%".date("Y-m-d",strtotime($params['order_date']))."%'";
			} else{
			     $orderdateWhere="1";
			}
			if(!empty($params['order_no'])){ 	
			    $orderidwhere ="order_id =".$params['order_no'];
			}else{
			     $orderidwhere="1";
			}
			
			$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department_id WHERE ".$orderdateWhere." AND ".$orderidwhere." AND  o.order_status != 0  and o.branch_id=$branch_id ORDER BY o.delivery_date_time ASC");
	    	return $query->result();
		}
	}
	
	
	public function production_frontend_Orders($data = array(),$order_date='',$isProduction=false) {
    
    $userId = $this->session->userdata('branch_id');
    if($userId ==1 || $userId == 2){
       $userId = '1,2'; 
    }
    	if(!isset($data['order_no']) || (isset($data['order_no']) && $data['order_no'] == 'unset')) {
				   
				if($order_date == 'future_order')
                {
                $sqll = 'o.delivery_date >= CURDATE()';
                }else if($order_date =='past_orders'){
                $sqll = 'o.delivery_date < CURDATE()';
                }
		    	}
		    	else{
			   $sqll = 1;   
			   }
			   if($isProduction == true){
			    $status =  'o.order_status_id != 0 and o.order_status_id != 3 and o.order_status_id !=1';
			    
			   }else{
			   $status =  'o.order_status_id != 0 and o.order_status_id != 3';    
			   }

     $opencartdb = $this->load->database('opecart', TRUE); 
$sql = "SELECT o.order_id,o.payment_code,o.order_status_id as order_status ,o.total,o.order_made_from, o.shipping_method, o.email,o.telephone,o.shipping_zone_id, o.firstname , o.lastname , o.shipping_code, o.total, o.currency_code, o.currency_value, o.is_catering_checklist_added, o.date_added , o.date_modified, o.delivery_date as delivery_date_time FROM `oc_order` o  where $sqll and o.user_id IN ($userId) and $status";

         if(!empty($data['order_date'])){
			   $sql .= " AND o.delivery_date ='".date("Y-m-d",strtotime($data['order_date']))."'";   
			 } 
		
			if(isset($data['order_no']) && $data['order_no'] != 'unset') {
					$sql .= "  AND o.order_id  =". $data['order_no'];
			}
			if(isset($data['location'])) {
				$sql .= " AND o.user_id  =". $data['location'];
			}
			
	    $sql .=' ORDER BY  o.delivery_date asc';
		$query=$opencartdb->query($sql);
		$orders_info=$query->result();
	   return $orders_info;
		
		
	}
	
public function getOrders($data = array(),$order_date='',$isProduction=false) {
    
    $userId = $this->session->userdata('branch_id');
    if($userId ==1 || $userId == 2){
       $userId = '1,2'; 
    }
   
    	if(!isset($data['order_no']) || (isset($data['order_no']) && $data['order_no'] == 'unset')) {
				if(empty($params['date_from']) && empty($params['date_to'])){     
    				if($order_date == 'future_order')
                    {
                    $sqll = 'o.delivery_date >= CURDATE()';
                    }else if($order_date =='past_orders'){
                    $sqll = 'o.delivery_date < CURDATE()';
                    }
				}else{
				    $sqll = 1;
				}
		    	}else{
			   $sqll = 1;   
			   }
			   if($isProduction == true){
			    $status =  'o.order_status_id != 0 and o.order_status_id !=1';
			    
			   }else{
			   $status =  'o.order_status_id != 0';    
			   }
			   

     $opencartdb = $this->load->database('opecart', TRUE); 
// $sql = "SELECT o.order_id,o.payment_code,o.order_status_id as order_status ,o.total,o.order_made_from, o.shipping_method, o.email,o.telephone,o.shipping_zone_id, o.firstname , o.lastname , o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added , o.date_modified, o.delivery_date as delivery_date_time FROM `oc_order` o  where $sqll and o.user_id IN ($userId) and $status";
$sql = "SELECT o.order_id,o.payment_code,o.order_status_id as order_status ,o.total,o.order_made_from, o.shipping_method, o.email,o.telephone,o.shipping_zone_id, o.firstname , o.lastname , o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added , o.date_modified, o.delivery_date as delivery_date_time FROM `oc_order` o  where o.user_id IN ($userId) and $status";
// echo $sql; exit;

		if (isset($data['date_from']) && isset($data['date_to']) ) {
	            if($data['date_from'] == $data['date_to']){
    	            $sql .= " AND o.delivery_date BETWEEN '".date("Y-m-d",strtotime($data['date_from']))." 00:00:01' AND '".date("Y-m-d",strtotime($data['date_from']))." 23:59:59'";
    	          }else{
    	             $sql .= " AND o.delivery_date>='".date("Y-m-d",strtotime($data['date_from']))." 00:00:01'";
    				 $sql .=  "AND o.delivery_date<='".date("Y-m-d",strtotime($data['date_to']))." 23:59:59'";
    	              
    	          }
        	}else{
        	    $sql .= ' AND '.$sqll;
        	}
        	if($isProduction == true){
			     if(!empty($data['order_date'])){
			   $sql .= " AND o.delivery_date ='".date("Y-m-d",strtotime($data['order_date']))."'";   
			 } 
        	}
		
			if(isset($data['order_no']) && $data['order_no'] != 'unset') {
					$sql .= "  AND o.order_id  =". $data['order_no'];
			}
			
			if(isset($data['customer'])) {
				$sql .= " AND o.customer_id  =". $data['customer'];
			}
			
			if(isset($data['location'])) {
				$sql .= " AND o.user_id  =". $data['location'];
			}
			
			
			
		if(!empty($data['sort_order'])){
				if($data['sort_order']==0){
					$sql .=' ORDER BY  o.delivery_date asc';
				}
				else if($data['sort_order']==1){
					$sql .= ' ORDER BY  o.delivery_date desc';
				}
				else if($data['sort_order']==2){
					$sql .= ' ORDER BY  o.order_id asc';
				}
				else $sql .= ' ORDER BY  o.order_id desc';
			}else{
			    $sql .= ' ORDER BY  o.order_id desc';
			}
		
// echo $sql; exit;

		$query=$opencartdb->query($sql);
		
		$orders_info=$query->result();
		

		return $orders_info;
		
			

		
	}
	
	 public function getUserInfo($user_id) {
        
        
        	$query = $this->db->query("SELECT * FROM `user` WHERE user_id = '" . (int)$user_id ."'");

		return $query->result();
        
    }
	
    public function getOrder($order_id) {
    
    $opencartdb = $this->load->database('opecart', TRUE); 
    
       		$order_query = "SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM oc_customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM oc_order_status os WHERE os.order_status_id = o.order_status_id ) AS order_status FROM `oc_order` o WHERE o.order_id = '" . (int)$order_id . "' and o.order_status_id != 0 ";

    

        $query=$opencartdb->query($order_query);
		
		$orders_info=$query->result();
		
	
		
		if ($orders_info) {
		    
	 $order_customer_query = "SELECT * FROM `oc_customer` WHERE customer_id = '" . (int)$orders_info[0]->customer_id . "'";
$Customer_query = $opencartdb->query($order_customer_query);
 $customerr_info=$Customer_query->result();
		 $order_location_query = "SELECT * FROM `zelocations` WHERE location_id = '" . (int)$orders_info[0]->order_location_id . "'";

			$country_query = "SELECT * FROM `oc_country` WHERE country_id = '" . (int)$orders_info[0]->payment_country_id . "'";

           $query = $opencartdb->query($country_query);
           $location_query = $opencartdb->query($order_location_query);
           
           $country_info=$query->result();
           $order_location=$location_query->result();
        
			if ($country_info) {
				$payment_iso_code_2 = $country_info[0]->iso_code_2;
				$payment_iso_code_3 = $country_info[0]->iso_code_3;
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}
			
			if ($order_location) {
				$order_location_name = $order_location[0]->location_name;
			} else {
				$order_location_name = '';
				
			}
           
			$zone_query = "SELECT * FROM `oc_zone` WHERE zone_id = '" . (int)$orders_info[0]->payment_zone_id . "'";


             $query = $opencartdb->query($zone_query);
           
           $zone_info=$query->result();
           
           
          
           
			if ($zone_info) {
				$payment_zone_code = $zone_info[0]->code;
			} else {
				$payment_zone_code = '';
			}

			$shipping_country_query = "SELECT * FROM `oc_country` WHERE country_id = '" . (int)$orders_info[0]->shipping_country_id . "'";
              
            $query = $opencartdb->query($shipping_country_query);
           
           $shipping_country_info=$query->result();


           
			if (!empty($shipping_country_info)) {
				$shipping_iso_code_2 = $shipping_country_info[0]->iso_code_2;
				$shipping_iso_code_3 = $shipping_country_info[0]->iso_code_3;
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$reward = 0;

			$order_product_query = "SELECT * FROM oc_order_product WHERE order_id = '" . (int)$order_id . "'";
			
			$query = $opencartdb->query($order_product_query);
           
           $order_product_query =$query->result();

			foreach ($order_product_query as $product) {
				$reward += $product->reward;
			}
			
	

            $orders_info[0]->reward= $reward;
            $orders_info[0]->payment_iso_code_2= $payment_iso_code_2; 
            $orders_info[0]->payment_iso_code_3= $payment_iso_code_3; 
            $orders_info[0]->payment_zone_code= $payment_zone_code;
            $orders_info[0]->shipping_address_1= $order_location_name; 
            $orders_info[0]->shipping_zone_code= ''; 
            $orders_info[0]->shipping_iso_code_2= $shipping_iso_code_2; 
           $orders_info[0]->shipping_iso_code_3= $shipping_iso_code_3;
            $orders_info[0]->account_number =$customerr_info[0]->account_number;
           	

			return  $orders_info; 
		} else {
			return;
		}
	}	
	
	
	public function getOrderProducts($order_id) {
	    
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
		$query = "SELECT * FROM oc_order_product WHERE order_id = '" . (int)$order_id . "' order by sort_order asc";

         $query = $opencartdb->query($query);
           
           $order_product_query =$query->result();
           
		return $order_product_query;
	}
	
		public function getOrderProductsDescrption($product_id) {
	    
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
		$query = "SELECT * FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'";

         $query = $opencartdb->query($query);
           
           $order_product_descr =$query->result();
           
		return $order_product_descr;
	}
	
	
	public function getOrderOptions($order_id, $order_product_id) {
	    
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
		$query = "SELECT * FROM oc_order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'";

		$query = $opencartdb->query($query);
           
        $order_product_option_query =$query->result();
           
		return $order_product_option_query;
	}
	
	// get all the order option value price i.e mini,large etc's price
	
		public function getOrderOptions_value($product_option_id, $product_option_value_id) {
	    
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
		$query = "SELECT price FROM `oc_product_option_value` WHERE product_option_id = '" . (int)$product_option_id . "' AND product_option_value_id = '" . (int)$product_option_value_id . "'";

		$query = $opencartdb->query($query);
           
        $order_product_option_value_query =$query->result();
           
		return $order_product_option_value_query;
	}
	
	
	public function getProductCategory($product_id) {
	    
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
		$query = "SELECT category_id FROM `oc_product_to_category` WHERE product_id = '" . (int)$product_id . "' ";

		$query = $opencartdb->query($query);
           
        $order_product_option_value_query =$query->result();
           
		return $order_product_option_value_query;
	}
	
	
	
	
	public function getOrderTotals($order_id) {
	   
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
	   
	
		$query = "SELECT * FROM `oc_order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY order_id ASC";

	
		$query = $opencartdb->query($query);
           
        $order_total_query = $query->result();
        
       
           
		return $order_total_query;
	}
	
	
	public function fetch_past_orders($params)
	{
		if(empty($params))
		{
			$userId = $this->session->userdata('user_id');
		   $query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id WHERE delivery_date_time<'".date("Y-m-d",strtotime("now"))." 00:00:01"."' and o.branch_id = $userId ORDER BY o.order_id desc");
			return $query->result();
		}
		else{
			if(!empty($params['sort_order'])){
				if($params['sort_order']==0){
					$order_by='delivery_date_time desc';
				}
				else if($params['sort_order']==1){
					$order_by='delivery_date_time asc';
				}
				else if($params['sort_order']==2){
					$order_by='order_id asc';
				}
				else $order_by='order_id desc';
			}
			else{
				$order_by='delivery_date_time asc';
			}
			if(!empty($params['date_from']))
				$fromWhere="delivery_date_time>='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere="1=1";
			if(!empty($params['date_to']))
				$toWhere="delivery_date_time<='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="1=1";
			if(isset($params['company']))
				$companyWhere="c.company_id=".$params['company'];
			else $companyWhere="1=1";
			if(isset($params['customer']))
				$cWhere="c.customer_id='".$params['customer']."'";
			else $cWhere="1=1";
			$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id join company co ON c.company_id=co.company_id WHERE ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$cWhere." ORDER BY ".$order_by);
			return $query->result();
		}
	}
	public function fetch_catering_checkList($order_id){
    $query=$this->db->query("SELECT * FROM catering_checklist where order_id =".$order_id);
    return $query->result_array();
}
	public function fetch_order_info($order_id)
	{
    	$query=$this->db->query("SELECT o.*,v.*,co.*,d.*,c.firstname,c.lastname,c.email,c.telephone,c.user_id,o.user_id as order_user_id,c.department,co.company_id as companyID FROM orders o LEFT JOIN customer c ON o.customer_id=c.customer_id left JOIN department d on d.department_id = c.department left join coupon v on o.coupon_id=v.coupon_id LEFT JOIN company co ON co.company_id=c.company_id WHERE o.order_id=".$order_id);
    
    	$result = $query->result();
    	
    	if(!empty($result)){
    	   if($result[0]->customer_from == 'frontend'){
    	       $opencartdb = $this->load->database('opecart', TRUE); 
	    
        	    $querymain = "SELECT * FROM `oc_customer` WHERE customer_id = " . $result[0]->customer_id;
        
                   $query = $opencartdb->query($querymain);
                   
                   $resfrontuser = $query->result();
                   
                   $result[0]->firstname = $resfrontuser[0]->firstname;
                   $result[0]->lastname = $resfrontuser[0]->lastname;
                   $result[0]->email = $resfrontuser[0]->email;
                   $result[0]->telephone = $resfrontuser[0]->telephone;
                   return $result;
    	       
    	   }else{
    	       return $result;
    	   }
    	}
    		
	}
	public function fetch_order_infofrontendorders($order_id)
	{
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
	    $querymain = "SELECT * FROM `oc_order` WHERE order_id = " . $order_id;

           $query = $opencartdb->query($querymain);
           
           return $query->result();
        
			
	}
	
	// all old database order is fetched from here ==================================================================================
	
	
	
	public function fetch_old_order_info($order_id,$username ='')
	{
	   if(isset($username) && $username !=''){
	        $bendigodb = $this->load->database($username, TRUE); 
	   }else{
	         $bendigodb = $this->load->database($this->session->userdata('username'), TRUE);
	   }
	  
	     
	    
	$query="SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v on o.coupon_id=v.coupon_id LEFT JOIN company co ON co.company_id=c.company_id WHERE o.order_id=".$order_id;

       $query=$bendigodb->query($query);
		return $query->result();
		
	}
	
	
		public function fetch_old_order_products($order_id)
	{
		$userId = $this->session->userdata('user_id');
		  $bendigodb = $this->load->database($this->session->userdata('username'), TRUE);
		  
		$query="SELECT * FROM order_product op join product p on op.product_id=p.product_id left join heading_product hp on hp.product_id=p.product_id left join product_header ph on ph.heading_id=hp.heading_id where order_id=".$order_id." order by heading";
		$query=$bendigodb->query($query);
		return $query->result();

	}
	
	
		public function fetch_oldorder_product_options($order_id)
	{
	     $bendigodb = $this->load->database($this->session->userdata('username'), TRUE);
	     
		$query="SELECT * FROM order_product op join order_product_option opo on op.order_product_id=opo.order_product_id join product_option po on po.product_option_id=opo.product_option_id join option_value ov on ov.option_value_id=po.option_value_id where op.order_id=".$order_id;
		
		$query=$bendigodb->query($query);
		
		return $query->result();
	}
	
	
	

	
	

	
	//=================================================================================================code end here for old databse ====================================
	
	public function fetch_user_info($user_id,$ofrom='')
	{
	    
	    if($ofrom == 'frontend'){
	        $opencartdb = $this->load->database('opecart', TRUE); 
	        
	        $sql= "SELECT * FROM oc_user WHERE user_id=".$user_id;
	        $query = $opencartdb->query($sql);
	    }else{
	        $query=$this->db->query("SELECT * FROM user WHERE user_id=".$user_id);
	    }
		
		return $query->result();
		
	}
	
	public function fetch_order_products($order_id)
	{
		$userId = $this->session->userdata('user_id');
		
		$query=$this->db->query("SELECT * FROM order_product op  join product p on op.product_id=p.product_id
		left join heading_product hp on hp.product_id=p.product_id left join product_header ph
		on ph.heading_id=hp.heading_id where op.order_id=".$order_id." order by op.sort_order asc,heading");
		
		
		$products=$query->result();
		
		
		foreach($products as $key=>$value){
		    $qry="SELECT * FROM order_product_option where order_id=".$order_id." and order_product_id=".$value->order_product_id;
		    $query=$this->db->query($qry);
		    $options=$query->result();
		    $products[$key]->options=$options;
		    
		}
		
// 		echo "<pre>";
// 		print_r($products); exit;
		return $products;

	}
	public function fetch_order_products2($order_id)
	{
		
		$query=$this->db->query("SELECT * FROM order_product op join product p on op.product_id=p.product_id left join heading_product hp on hp.product_id=p.product_id left join product_header ph on ph.heading_id=hp.heading_id where order_id=".$order_id." order by heading,op.sort_order asc");
		$productList2= $query->result();
		//echo "<pre>";
		//print_r($productList2);

		$query=$this->db->query("SELECT * FROM order_product op where order_id=".$order_id." order by sort_order asc");
		$productList=$query->result();

		
		$opencartdb = $this->load->database('opecart', TRUE); 
		
		
		foreach($productList as $key=>$pl){
			$query="select * from oc_product p, oc_product_description pd  where p.product_id = ".$pl->product_id." and pd.product_id = p.product_id";
			$query=$opencartdb->query($query);
			$product_info=$query->result();
			$productList[$key]->product_name=$product_info[0]->name;
			$productList[$key]->product_description=$product_info[0]->description;
			$productList[$key]->product_desc_1=$product_info[0]->desc_1;
			$productList[$key]->product_desc_2=$product_info[0]->desc_2;
			$productList[$key]->product_desc_3=$product_info[0]->desc_3;
			$productList[$key]->product_desc_4=$product_info[0]->desc_4;
			$productList[$key]->product_desc_5=$product_info[0]->desc_5;
			$productList[$key]->product_image=$product_info[0]->image;
			$productList[$key]->product_price=$productList[$key]->price;
			$productList[$key]->product_date_available=$product_info[0]->date_available;
			$productList[$key]->product_minimum=$product_info[0]->product_minimum;
			$productList[$key]->product_status=$product_info[0]->status;
			$productList[$key]->product_date_added=$product_info[0]->date_added;
			$productList[$key]->product_date_modified=$product_info[0]->date_modified;
			$productList[$key]->heading=$product_info[0]->product_status;
			$productList[$key]->addons_option=$product_info[0]->product_status;
			$productList[$key]->heading_id=$product_info[0]->model;
			$productList[$key]->image=$product_info[0]->product_status;
			$productList[$key]->postal_code=$product_info[0]->postal_code;
			//echo "<pre>";
			//print_r($product_info);
			//exit;
		
		}
		
		
		return $productList;
		
	}
	public function fetch_order_product_options($order_id)
	{
	    
	 
		//$query=$this->db->query("SELECT * FROM order_product op join order_product_option opo on op.order_product_id=opo.order_product_id join product_option po on po.product_option_id=opo.product_option_id join option_value ov on ov.option_value_id=po.option_value_id where op.order_product_id=".$order_id);
		$query=$this->db->query("SELECT * FROM order_product op join order_product_option opo on op.order_product_id=opo.order_product_id left join product_option po on po.product_option_id=opo.product_option_id left join option_value ov on ov.option_value_id=po.option_value_id where op.order_product_id=".$order_id);
		return $query->result();
	}
	public function fetch_standing_order_history($params)
	{
	    
	    $userId = $this->session->userdata('user_id');
	    
	   
	    
		if(empty($params))
		{
			$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id WHERE standing_order=1 and order_status > 0 and o.user_id= ".$userId." ORDER BY order_id desc");
			return $query->result();
		}
		else{
			if(!empty($params['sort_order'])){
				if($params['sort_order']==0){
					$order_by='delivery_date_time asc';
				}
				else if($params['sort_order']==1){
					$order_by='delivery_date_time desc';
				}
				else if($params['sort_order']==2){
					$order_by='order_id asc';
				}
				else $order_by='order_id desc';
			}
			else{
				$order_by='delivery_date_time asc';
			}
			if(!empty($params['date_from']))
				$fromWhere="delivery_date_time>='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere="1";
			if(!empty($params['date_to']))
				$toWhere="delivery_date_time<='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="1";
			
				if(isset($params['company']))
				$companyWhere="c.company_id=".$params['company'];
			else $companyWhere="1";
			
			if(isset($params['customer']))
				$cWhere="c.customer_id=".$params['customer'];
			else $cWhere="1";
			
		
			
			
			
			$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id WHERE ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$cWhere." AND standing_order=1 and o.user_id= ".$userId." ORDER BY ".$order_by);
			return $query->result();
		}
	}
	public function fetch_active_coupons()
	{
		$query=$this->db->query("SELECT * FROM coupon WHERE status=1");
		return $query->result();
	}
	public function fetch_archived_coupons()
	{
		$query=$this->db->query("SELECT * FROM coupon WHERE status=0");
		return $query->result();
	}
	
	
	public function fetch_product_categories($prod_id)
	{
		$query=$this->db->query("SELECT * FROM product_category WHERE product_id =".$prod_id);
		return $query->result();
	}	
	
		public function fetch_all_products()
	{
	  
	    	$userId = $this->session->userdata('user_id');
		$query=$this->db->query("SELECT product_id,product_name,product_description FROM `product` where user_id =".$userId." and `product_id` > '2020-02-26 17:30:21'" );
		
// 		$query=$this->db->query("SELECT product_id,product_name,product_description FROM `product` where user_id = 0 " );
		return $query->result();
	}
	
	public function archive_coupon($coupon_id)
	{
		$query=$this->db->query("UPDATE coupon SET status=0 WHERE coupon_id=".$coupon_id);
	}
	public function activate_coupon($coupon_id)
	{
		$query=$this->db->query("UPDATE coupon SET status=1 WHERE coupon_id=".$coupon_id);		
	}
	
// 	Quote
	public function new_quote($data)
	{
	    $backend_order_id = $this->db->query("SELECT  MAX(order_id)  FROM `orderids_count`");
	    $backend_order_id = json_decode(json_encode($backend_order_id->result()), True);
	    
          if ($backend_order_id) {
				$backend_order_id = $backend_order_id[0]['MAX(order_id)'];
				 $order_id  = $backend_order_id +1;
			} 
	    
		$delivery_notes=empty($data['delivery_notes'])||$data['delivery_notes']=='null'?'null':$this->db->escape($data['delivery_notes']);
		
		$order_comments=empty($data['order_comments'])||$data['order_comments']=='null'?'null':$this->db->escape($data['order_comments']);
		$delivery_fee=empty($data['delivery_fee'])||$data['delivery_fee']=='null'?0:$data['delivery_fee'];
		$delivery_phone=empty($data['delivery_contact'])||$data['delivery_contact']=='null'?'null':$this->db->escape($data['delivery_contact']);
		$delivery_address=empty($data['delivery_address'])||$data['delivery_address']=='null'?'null':$this->db->escape($data['delivery_address']);
		$delivery_email=empty($data['email'])||$data['email']=='null'?'null':$this->db->escape($data['email']);
		
	
		if(empty($data['coupon'])||$data['coupon']=='null')
			$coupon_id='null';
		else
		{
			$code=$this->db->escape($data['coupon']);
			$query=$this->db->query("SELECT * FROM coupon WHERE coupon_code=".$code);
			if(empty($query->result()))
				$coupon_id='null';
			else $coupon_id=$query->result()[0]->coupon_id;
		}
		
		$date_added=date("Y-m-d H:i:s",strtotime("now"));
		if($data['company'] !=''){
		    if($data['customer_from'] == 'frontend'){
		        $opecartdb = $this->load->database('opecart', TRUE);
        		$sql = "SELECT * FROM oc_customer WHERE customer_id = ".$data['customer'];
        	 	 $queryCust=$opecartdb->query($sql);
        	 	 $custResult=$queryCust->result();
        	 	 if(!empty($custResult)){
        	 	     $query=$this->db->query("SELECT * FROM company WHERE company_id=".$custResult[0]->company_id);
        	 	     if(!empty($query->result())){
        	 	         $comp_name =empty($query->result()[0]->company_name)||$query->result()[0]->company_name =='null'?'null':$this->db->escape($query->result()[0]->company_name);
        	 	        $comp_addr =empty($query->result()[0]->company_address)||$query->result()[0]->company_address =='null'?'null':$this->db->escape($query->result()[0]->company_address );
        	 	     }else{
        	 	         $comp_name = 'null';
			             $comp_addr = 'null';
        	 	     }
        	 	     
        	 	     $query=$this->db->query("SELECT * FROM department WHERE department_id=".$custResult[0]->department_id);
        	 	     if(!empty($query->result())){
        	 	         $department_name=empty($query->result()[0]->department_name)||$query->result()[0]->department_name =='null'?'null':$this->db->escape($query->result()[0]->department_name);
        	 	     }else{
        	 	         $department_name = 'null'; 
        	 	     }
        	 	     
        	 	 }
		    }else{
		        $query=$this->db->query("SELECT * FROM company co left join customer cu on cu.company_id = co.company_id left join department d on d.department_id =cu.department WHERE cu.customer_id=".$data['customer']);
		        if(!empty($query->result()))
    			{
    			    $comp_name =empty($query->result()[0]->company_name)||$query->result()[0]->company_name =='null'?'null':$this->db->escape($query->result()[0]->company_name);
    			 	$department_name=empty($query->result()[0]->department_name)||$query->result()[0]->department_name =='null'?'null':$this->db->escape($query->result()[0]->department_name);
    			 	$comp_addr =empty($query->result()[0]->company_address)||$query->result()[0]->company_address =='null'?'null':$this->db->escape($query->result()[0]->company_address );
    			}else{
    			    $comp_name = 'null';
    			    $comp_addr = 'null';
    			    $department_name = 'null';
    			}   
		        
		    }
			
		}else{
		    $comp_name = 'null';
			    $comp_addr = 'null';
			    $department_name = 'null'; 
		}
		
		
        $branch_id = $this->session->userdata('branch_id');
        

        
		if($data['shipping_method']==1)
		{   
         $this->db->query("INSERT INTO quote (order_id,accounts_email,user_id,customer_order_name,customer_order_email,customer_order_telephone,customer_id,branch_id,customer_company_name,customer_company_addr,customer_department_name,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email,customer_from) VALUES ($order_id,'".$data['accounts_email']."',".$data['user_id'].",'".$data['customer_order_name']."','".$data['customer_order_email']."','".$data['customer_order_phone']."',".$data['customer'].",".$branch_id.",".$comp_name .",".$comp_addr .",".$department_name .",".$data['shipping_method'].",".$delivery_notes.",".(0).",1,'".$date_added."','".date("Y-m-d H:i:s",strtotime("now"))."','".date("Y-m-d H:i",strtotime($data['delivery_date_time']))."',".$order_comments.",".$coupon_id.",".$delivery_fee.",".$delivery_phone.",".$delivery_address.",".$delivery_email.",'".$data['customer_from']."')");
		}
		else
		{
		$this->db->query("INSERT INTO quote (order_id,accounts_email,user_id,customer_order_name,customer_order_email,customer_order_telephone,customer_id,branch_id,customer_company_name,customer_company_addr,customer_department_name,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email,selected_location,customer_from) VALUES ($order_id,'".$data['accounts_email']."',".$data['user_id'].",'".$data['customer_order_name']."','".$data['customer_order_email']."','".$data['customer_order_phone']."',".$data['customer'].",".$branch_id.",".$comp_name .",".$comp_addr .",".$department_name .",".$data['shipping_method'].",".$delivery_notes.",".(0).",1,'".$date_added."','".date("Y-m-d H:i:s",strtotime("now"))."','".date("Y-m-d H:i",strtotime($data['delivery_date_time']))."',".$order_comments.",".$coupon_id.",".$delivery_fee.",".$delivery_phone.",".$delivery_address.",".$delivery_email.",".$data['pickup_location'].",'".$data['customer_from']."')");
		}
	
		 $order_id=$this->db->insert_id();
		//insert the current order_id to new table so as to keep record of all order_ids
		 $this->db->query("INSERT INTO `orderids_count` (`order_id`, `date`) VALUES ('".$order_id."',  CURRENT_TIMESTAMP)");
		//Process products
		$total=0;
	
		if(!empty($data['products']))
		{
			foreach($data['products'] as $product=>$qty)
			{
				$query=$this->db->query("SELECT product_price from product where product_id=".$product);
				$res=$query->result();
				$res=$res[0]->product_price;  
				if(isset($data['order_product_comment'][$product]) && !empty($data['order_product_comment'][$product])){
				    $ordr_prd_comnt = $data['order_product_comment'][$product];
			  
				$this->db->query("INSERT INTO order_product(order_id,order_product_comment,product_id,quantity,price,total) VALUES (".$order_id.",'".$ordr_prd_comnt."',".$product.",".$qty.",".$res.",".($qty*$res).")");  
				
				}else{
				    
				$this->db->query("INSERT INTO order_product(order_id,product_id,quantity,price,total) VALUES (".$order_id.",".$product.",".$qty.",".$res.",".($qty*$res).")");
				
				}
			
				$total+=($qty*$res);			
			}
		}
		
		
	  
		
		if(!empty($data['option']))
		{
			//Options present, process those too
			foreach($data['option'] as $prod_opt=>$opt_qty)
			{
				$query=$this->db->query("SELECT * FROM product_option po JOIN option_value ov ON ov.option_value_id=po.option_value_id WHERE po.product_option_id=".$prod_opt);
				$res=$query->result();
				
				// take out option and their value (really a bad practice of code this is i know)
				
			$query=$this->db->query("SELECT o.name FROM product_option po JOIN option_value ov ON ov.option_value_id=po.option_value_id   JOIN options o ON o.option_id=ov.option_id WHERE po.product_option_id=".$prod_opt);
				$res_option_name =$query->result();
			
			
				
				//Find the product, update base price * opt_qty
				$q2=$this->db->query("SELECT * FROM product WHERE product_id=".$res[0]->product_id);
				$r2=$q2->result();
				//Check if order_product has entry for this product with this order number
				$q2=$this->db->query("SELECT * FROM order_product WHERE order_id=".$order_id." AND product_id=".$res[0]->product_id);
				$r_ord_prod=$q2->result();
				$order_product_id=$r_ord_prod[0]->order_product_id;
				

				$this->db->query("INSERT INTO order_product_option (order_id,order_product_id,product_option_id,option_name,option_value,option_quantity,option_price,option_total) VALUES 
    (".$order_id.",".$order_product_id.",".$res[0]->product_option_id.",'".$res_option_name[0]->name."','".$res[0]->name."',".$opt_qty.",".(float)($res[0]->option_price_prefix.$res[0]->option_price).",".($opt_qty*(float)($res[0]->option_price_prefix.$res[0]->option_price)).")");
				$total+=($opt_qty*(float)($res[0]->option_price_prefix.$res[0]->option_price));
			}
		}
		$this->db->query("UPDATE quote SET order_total=".$total." WHERE order_id=".$order_id);
		
	
		//send mail for approval
		//generate auth token: sha1(order_id|delivery_email o````````````n record|customer_id|date_added)
		$auth=sha1($order_id."|".$data['email']."|".$data['customer']);
		$email=$data['email'];
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
	
		
		return $order_id;
	}
		public function fetch_quote_history($params='',$order_date='')
	{      	
	   
	       $userId = $this->session->userdata('user_id');
	       $branch_id = $this->session->userdata('branch_id');
	    
		      if(empty($params))
		      { 

		        $qry="select q.*,v.*,c.firstname,c.lastname,c.company_id,co.company_name,co.company_abn from quote q LEFT JOIN coupon v ON q.coupon_id=v.coupon_id LEFT JOIN customer c ON q.customer_id=c.customer_id LEFT JOIN company co ON c.company_id=co.company_id where order_status != 2 AND order_status != 0  AND branch_id = $branch_id ORDER BY order_id desc";
                $query = $this->db->query($qry);
			    return $query->result();
             }else{
                 if(empty($params['date_from']) && empty($params['date_to'])){    
		    
		    if($order_date == 'future_order')
            {
                // $sqll = 'o.delivery_date_time >= CURDATE()';
                $sqll = 1;
                
            }else if($order_date =='past_orders'){
                
                // $sqll = 'o.delivery_date_time < CURDATE()';
                $sqll = 1;
                
            }else{
                // $sqll = 'o.delivery_date_time >= CURDATE()';
                $sqll = 1;
            }
            
        		}else{
        		  $sqll = 1;  
        		}	   
			
			if(!empty($params['sort_order'])){
				if($params['sort_order']==0){
					$order_by='delivery_date_time asc';
				}
				else if($params['sort_order']==1){
					$order_by='delivery_date_time desc';
				}
				else if($params['sort_order']==2){
					$order_by='order_id asc';
				}
				else $order_by='order_id desc';
			}
			else $order_by='delivery_date_time asc';
			
			if(!empty($params['order_date'])){ 	
			    $orderdateWhere="date_added LIKE '%".date("Y-m-d",strtotime($params['order_date']))."%'";
			   
			}else{
			     $orderdateWhere="1";
			}
			
		
			if(!empty($params['date_to']) &&  !empty($params['date_from']) && $params['date_from'] == $params['date_to']){
			   
			    $fromWhere="delivery_date_time LIKE '%".date("Y-m-d",strtotime($params['date_from']))."%'";
			    $toWhere="1";
			    
			}else{
			if(!empty($params['date_from']))
				$fromWhere="delivery_date_time >='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere=$sqll;
			
			if(!empty($params['date_to']))
				$toWhere="delivery_date_time<='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="1";
			}
			if(isset($params['company']))
				$companyWhere="c.company_id=".$params['company'];
			else $companyWhere="1";
			if(isset($params['department'] ) && $params['department'] !=0)
				$deptWhere="d.department_id=".$params['department'];
			else $deptWhere="1";
			if(isset($params['customer']))
				$cWhere="c.customer_id=".$params['customer'];
			else $cWhere="1";
			
			if(isset($params['status']))
				$statusWhere="o.order_status=".$params['status'];
			else $statusWhere ="1";
			
			if(isset($params['location']))
				$userWhere="o.user_id=".$params['location'];
			else $userWhere="1";
			if(isset($params['order_no']) && $params['order_no'] !='unset')
				$orderidwhere="o.order_id=".$params['order_no'];
			else $orderidwhere="1";
			
                 $query=$this->db->query("SELECT * FROM quote o LEFT JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department_id WHERE ".$orderdateWhere." AND ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$deptWhere." AND ".$cWhere." and o.branch_id = ". $userId." AND $orderidwhere AND $statusWhere ORDER BY ".$order_by);
             return $query->result();
                  
             }
	        
      	}
	public function fetch_quote_info($order_id)
	{
	$query=$this->db->query("SELECT o.*,v.*,co.*,d.*,c.firstname,c.lastname,c.email,c.telephone,c.user_id,o.user_id as order_user_id,c.department FROM quote o LEFT JOIN customer c ON o.customer_id=c.customer_id left JOIN department d on d.department_id = c.department left join coupon v on o.coupon_id=v.coupon_id LEFT JOIN company co ON co.company_id=c.company_id WHERE o.order_id=".$order_id);

		return $query->result();
		
	}
	public function fetch_company_info($company_id)
	{
	$query=$this->db->query("SELECT * FROM company WHERE company_id=".$company_id);

		return $query->result();
		
	}

		
		public function update_quote_details($comp_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date_time,$delivery_notes,$order_comments,$delivery_fee,$standing_order,$customer_order_name,$customer_order_email,$customer_order_telephone,$delivery_telephone,$delivery_addr,$comp_addr,$accounts_email)
	{
	    	
	    
	    $customer_order_name=empty($customer_order_name)||$customer_order_name=='null'?'null':$this->db->escape($customer_order_name);
	    
	    $accounts_email=empty($accounts_email)||$accounts_email=='null'?'null':$this->db->escape($accounts_email);
	    
	    $customer_order_email=empty($customer_order_email)||$customer_order_email=='null'?'null':$this->db->escape($customer_order_email);

	    $customer_order_telephone=empty($customer_order_telephone)||$customer_order_telephone=='null'?'null':$this->db->escape($customer_order_telephone);
	    
	    $delivery_telephone=empty($delivery_telephone)||$delivery_telephone=='null'?'null':$this->db->escape($delivery_telephone);
	    
	    $delivery_addr=empty($delivery_addr)||$delivery_addr=='null'?'null':$this->db->escape($delivery_addr);
	    
	    $company_name=empty($company_name)||$company_name=='null'?'null':$this->db->escape($company_name);
	    
	    $department_name =empty($department_name)||$department_name=='null'?'null':$this->db->escape($department_name);
	    
	    $comp_addr=empty($comp_addr)||$comp_addr=='null'?'null':$this->db->escape($comp_addr);
	    
		$delivery_notes=empty($delivery_notes)||$delivery_notes=='null'?'null':$this->db->escape($delivery_notes);
		
		$order_comments=empty($order_comments)||$order_comments=='null'?'null':$this->db->escape($order_comments);
		$delivery_fee=empty($delivery_fee)||$delivery_fee=='null'?0:$delivery_fee;
		if(empty($coupon_code)||$coupon_code=='null')
			$coupon_id='null';
		else
		{
			$code=$this->db->escape($coupon_code);
			$query=$this->db->query("SELECT * FROM coupon WHERE coupon_code=".$code);
			if(empty($query->result()))
			$coupon_id='null';
			else $coupon_id=$query->result()[0]->coupon_id;
		}
		$delivery_date_time=date("Y-m-d H:i",strtotime($delivery_date_time));

       
		$this->db->query("UPDATE quote SET  accounts_email=".$accounts_email.",customer_company_name = ".$company_name.", customer_company_addr= ".$comp_addr." , customer_order_name= ".$customer_order_name.", customer_order_email= ".$customer_order_email.", customer_order_telephone= ".$customer_order_telephone.", delivery_phone= ".$delivery_telephone." , customer_department_name = ".$department_name." , delivery_address=".$delivery_addr.",coupon_id=".$coupon_id.",delivery_date_time='".$delivery_date_time."',pickup_delivery_notes=".$delivery_notes.",order_comments=".$order_comments.",delivery_fee=".$delivery_fee.",standing_order=".$standing_order." WHERE order_id=".$order_id);
	}
	public function delete_feedback($order_id){
	    $this->db->query("DELETE FROM customer_feedback WHERE `order_id` = '".$order_id."'");
	}
	public function convertToInvoice($order_id){
	   // echo "INSERT INTO `orders` SELECT * FROM quote WHERE `quote`.`order_id` = '".$order_id."'";
	   //mail('adityakohli467@gmail.com','QUERY HC',"INSERT INTO `orders` SELECT * FROM quote WHERE `quote`.`order_id` = '".$order_id."'");
	    $query = $this->db->query("INSERT INTO `orders` SELECT * FROM quote WHERE `quote`.`order_id` = '".$order_id."'");
	   
	   $this->db->query("UPDATE orders SET order_status = '7' WHERE order_id=".$order_id);
	
	 
	    if($query){
	        $this->db->query("DELETE FROM quote WHERE `order_id` = '".$order_id."'");
	    }
	    return true;
	}
// 	Quote ends
public function save_order_image($order_id,$new_name){
     return $this->db->query("INSERT INTO `order_images` (`order_id`,`order_image`) VALUES ($order_id,'$new_name')");
    
}
public function get_order_image($order_id){
     $query = $this->db->query("SELECT * FROM `order_images` WHERE `order_id` = '".$order_id."'");
    $res = $query->result();
    return $res;
    // echo $this->db->last_query();
}
	public function new_order($data)
	{
	    
	    
	  
	    $backend_order_id = $this->db->query("SELECT  MAX(order_id)   FROM `orderids_count`");
	    
	    $backend_order_id = json_decode(json_encode($backend_order_id->result()), True);
	    
          if ($backend_order_id) {
				$backend_order_id = $backend_order_id[0]['MAX(order_id)'];
				 $order_id  = $backend_order_id +1;
			} 
	    
	  
 
		$delivery_notes=empty($data['delivery_notes'])||$data['delivery_notes']=='null'?'null':$this->db->escape($data['delivery_notes']);
	
		$order_comments=empty($data['order_comments'])||$data['order_comments']=='null'?'null':$this->db->escape($data['order_comments']);
		$delivery_fee=empty($data['delivery_fee'])||$data['delivery_fee']=='null'?0:$data['delivery_fee'];
		$delivery_phone=empty($data['phone'])||$data['phone']=='null'?'null':$this->db->escape($data['phone']);
		$delivery_address=empty($data['delivery_address'])||$data['delivery_address']=='null'?'null':$this->db->escape($data['delivery_address']);
		$delivery_email=empty($data['email'])||$data['email']=='null'?'null':$this->db->escape($data['email']);
		if(empty($data['coupon'])||$data['coupon']=='null')
			$coupon_id='null';
		else
		{
			$code=$this->db->escape($data['coupon']);
			$query=$this->db->query("SELECT * FROM coupon WHERE coupon_code=".$code);
			if(empty($query->result()))
				$coupon_id='null';
			else $coupon_id=$query->result()[0]->coupon_id;
		}
		
		$date_added=date("Y-m-d H:i:s",strtotime("now"));
		
	


		$query=$this->db->query("SELECT * FROM company co left join customer cu on cu.company_id = co.company_id left join department d on d.department_id =cu.department WHERE cu.customer_id=".$data['customer']);
			if(!empty($query->result()))
			{
		
			 
			 	$comp_name =empty($query->result()[0]->company_name)||$query->result()[0]->company_name =='null'?'null':$this->db->escape($query->result()[0]->company_name);
			 	
			 	$department_name=empty($query->result()[0]->department_name)||$query->result()[0]->department_name =='null'?'null':$this->db->escape($query->result()[0]->department_name);
			 		
			 	$comp_addr =empty($query->result()[0]->company_address)||$query->result()[0]->company_address =='null'?'null':$this->db->escape($query->result()[0]->company_address );
			 

			}else{
			    $comp_name = 'null';
			      $comp_addr = 'null';
			        $department_name = 'null';
			    
			}
		

	$branch_id = $this->session->userdata('branch_id');
		if($data['shipping_method']==1)
		{   

			//Insert 0 for total before calculating in backend
			$this->db->query("INSERT INTO orders (order_id,user_id,customer_id,branch_id,customer_company_name,customer_company_addr,	customer_department_name,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,standing_order,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email) VALUES ($order_id,".$data['user_id'].",".$data['customer'].",".$branch_id.",".$comp_name .",".$comp_addr .",".$department_name .",".$data['shipping_method'].",".$delivery_notes.",".(0).",1,'".$date_added."','".date("Y-m-d H:i:s",strtotime("now"))."','".date("Y-m-d H:i",strtotime($data['delivery_date_time']))."',".$data['standing_order'].",".$order_comments.",".$coupon_id.",".$delivery_fee.",".$delivery_phone.",".$delivery_address.",".$delivery_email.")");
		
		    
		}
		else
		{
		    
			$this->db->query("INSERT INTO orders (order_id,user_id,customer_id,branch_id,customer_company_name,customer_company_addr,	customer_department_name,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,standing_order,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email,selected_location) VALUES ($order_id,".$data['user_id'].",".$data['customer'].",".$branch_id.",".$comp_name .",".$comp_addr .",".$department_name .",".$data['shipping_method'].",".$delivery_notes.",".(0).",1,'".$date_added."','".date("Y-m-d H:i:s",strtotime("now"))."','".date("Y-m-d H:i",strtotime($data['delivery_date_time']))."',".$data['standing_order'].",".$order_comments.",".$coupon_id.",".$delivery_fee.",".$delivery_phone.",".$delivery_address.",".$delivery_email.",".$data['pickup_location'].")");
		}
		
		$order_id=$this->db->insert_id();
		
		//insert the current order_id to new table so as to keep record of all order_ids
	
		 $this->db->query("INSERT INTO `orderids_count` (`order_id`, `date`) VALUES ('".$order_id."',  CURRENT_TIMESTAMP)");
		//Process products
		$total=0;
	
		
		
		
		if(!empty($data['products']))
		{
			foreach($data['products'] as $product=>$qty)
			{
				$query=$this->db->query("SELECT product_price from product where product_id=".$product);
				$res=$query->result();
				$res=$res[0]->product_price;  
				if(isset($data['order_product_comment'][$product]) && !empty($data['order_product_comment'][$product])){
				    $ordr_prd_comnt = $data['order_product_comment'][$product];
			  
				$this->db->query("INSERT INTO order_product(order_id,order_product_comment,product_id,quantity,price,total) VALUES (".$order_id.",'".$ordr_prd_comnt."',".$product.",".$qty.",".$res.",".($qty*$res).")");  
				
				}else{
				    
				$this->db->query("INSERT INTO order_product(order_id,product_id,quantity,price,total) VALUES (".$order_id.",".$product.",".$qty.",".$res.",".($qty*$res).")");
				
				}
			
				$total+=($qty*$res);			
			}
		}
		
		
	  
		
		if(!empty($data['option']))
		{
			//Options present, process those too
			foreach($data['option'] as $prod_opt=>$opt_qty)
			{
				$query=$this->db->query("SELECT * FROM product_option po JOIN option_value ov ON ov.option_value_id=po.option_value_id WHERE po.product_option_id=".$prod_opt);
				$res=$query->result();
				
				// take out option and their value (really a bad practice of code this is i know)
				
			$query=$this->db->query("SELECT o.name FROM product_option po JOIN option_value ov ON ov.option_value_id=po.option_value_id   JOIN options o ON o.option_id=ov.option_id WHERE po.product_option_id=".$prod_opt);
				$res_option_name =$query->result();
			
			
				
				//Find the product, update base price * opt_qty
				$q2=$this->db->query("SELECT * FROM product WHERE product_id=".$res[0]->product_id);
				$r2=$q2->result();
				//Check if order_product has entry for this product with this order number
				$q2=$this->db->query("SELECT * FROM order_product WHERE order_id=".$order_id." AND product_id=".$res[0]->product_id);
				$r_ord_prod=$q2->result();
				$order_product_id=$r_ord_prod[0]->order_product_id;
				

				$this->db->query("INSERT INTO order_product_option (order_id,order_product_id,product_option_id,option_name,option_value,option_quantity,option_price,option_total) VALUES 
    (".$order_id.",".$order_product_id.",".$res[0]->product_option_id.",'".$res_option_name[0]->name."','".$res[0]->name."',".$opt_qty.",".(float)($res[0]->option_price_prefix.$res[0]->option_price).",".($opt_qty*(float)($res[0]->option_price_prefix.$res[0]->option_price)).")");
				$total+=($opt_qty*(float)($res[0]->option_price_prefix.$res[0]->option_price));
			}
		}
		$this->db->query("UPDATE orders SET order_total=".$total." WHERE order_id=".$order_id);
		
	
		//send mail for approval
		//generate auth token: sha1(order_id|delivery_email o````````````n record|customer_id|date_added)
		$auth=sha1($order_id."|".$data['email']."|".$data['customer']);
		$email=$data['email'];
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
		
			
		/*$this->load->library('email', $config);
		$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
		$this->email->to($email);
		$this->email->subject('Order approval request');
		$this->email->message("Hello,\r\nYour order at Hospital Caterings (Order #".$order_id.") is awaiting approval.\r\nClick the link below to view and approve your order:\r\n ".base_url()."index.php/orders/order_approval/".$order_id."/".$auth."\"\r\nIf the link does not work for you, please copy and paste the line above into your web browser\r\nThank you, and have a great day!\r\nRegards,\r\nTeam Hospital Caterings");
			$this->email->send();*/
			
		
		return $order_id;
	}
	public function add_product_to_order($order_id,$prod,$qty,$order_product_comment)
	{
		$query=$this->db->query("SELECT product_price from product where product_id=".$prod);
		$res=$query->result();
		$res=$res[0]->product_price;
	
		$this->db->query("INSERT INTO order_product(order_id,product_id,quantity,order_product_comment,price,total) VALUES (".$order_id.",".$prod.",".$qty.",'".$order_product_comment."',".$res.",".($qty*$res).")");
	}
	// insert new product order comment incase of edit order
	
		public function add_productcomment_to_order($order_id,$prod,$cmnt)
	{
	
		$this->db->query("INSERT INTO order_product(order_id,product_id,order_product_comment) VALUES (".$order_id.",".$prod.",'".$cmnt."')");
	}
	
	
	public function insert_postcodd($id,$range,$end){
	   
	    $opencartdb = $this->load->database('opecart', TRUE); 
	    
	    $no = $end - $range;
	    
	   $old_range = $range;
	   
	    for($i = 1; $i <= $no; $i++){
	      
	     
	       // $sql = "INSERT INTO oc_postcode_individual(state,postcode,location) VALUES (".$id.",".$old_range.",2)";
	       
	       // $sql = "INSERT INTO user_postcode(user_id,postal_code) VALUES (".$id.",".$old_range.")";
	       
	        $reslt= $opencartdb->query($sql);
	          $old_range = $range + $i ;
	         
	    }
	    
	    
	}
	
	  
	public function add_option_to_order($order_id,$option,$qty)
	{
		$query=$this->db->query("SELECT * FROM product_option po JOIN option_value ov ON ov.option_value_id=po.option_value_id WHERE po.product_option_id=".$option);
		$res=$query->result();
		//Find the product, update base price * opt_qty
		$q2=$this->db->query("SELECT * FROM product WHERE product_id=".$res[0]->product_id);
		$r2=$q2->result();
		//Check if order_product has entry for this product with this order number
// 		echo "SELECT * FROM order_product WHERE order_id=".$order_id." AND product_id=".$res[0]->product_id; 
		$q2=$this->db->query("SELECT * FROM order_product WHERE order_id=".$order_id." AND product_id=".$res[0]->product_id);
		$r_ord_prod=$q2->result();
		$order_product_id=$r_ord_prod[0]->order_product_id;
// 	echo "INSERT INTO order_product_option (order_product_id,order_id,product_option_id,option_quantity,option_price,option_total) VALUES (".$order_product_id.",".$order_id.",".$res[0]->product_option_id.",".$qty.",".(float)($res[0]->option_price_prefix.$res[0]->option_price).",".($qty*(float)($res[0]->option_price_prefix.$res[0]->option_price)).")"; 
		$this->db->query("INSERT INTO order_product_option (order_product_id,order_id,product_option_id,option_quantity,option_price,option_total) VALUES (".$order_product_id.",".$order_id.",".$res[0]->product_option_id.",".$qty.",".(float)($res[0]->option_price_prefix.$res[0]->option_price).",".($qty*(float)($res[0]->option_price_prefix.$res[0]->option_price)).")");
	}
	public function fetch_all_op_details($order_id)
	{
	    
		$query=$this->db->query("SELECT * FROM order_product op join product p on op.product_id=p.product_id left join heading_product hp on hp.product_id=p.product_id left join product_header ph on ph.heading_id=hp.heading_id where order_id=".$order_id." ORDER BY sort_order asc");
		$res=$query->result();
		foreach($res as $product){
			$query=$this->db->query("SELECT * FROM order_product op join order_product_option opo on op.order_product_id=opo.order_product_id join product_option po on po.product_option_id=opo.product_option_id join option_value ov on ov.option_value_id=po.option_value_id where op.order_product_id=".$product->order_product_id);
			$product->options=$query->result();
		}
		return $res;
	}
	public function delete_option_from_order($option){
	    
	    return false;
	    
		//Before delete, fetch details and update total
		$query=$this->db->query("SELECT * FROM order_product_option opo join order_product op ON op.order_product_id=opo.order_product_id join product_option po on po.product_option_id=opo.product_option_id where order_product_option_id=".$option);
		$res=$query->result();
		$total_update=$res[0]->option_total;
		//If option_required==1, also update order_product
		if($res[0]->option_required==1){
			$this->db->query("UPDATE order_product SET quantity=quantity-".$res[0]->option_quantity.", total=total-".$res[0]->price*$res[0]->option_quantity);
		}
		$this->db->query("DELETE FROM order_product_option WHERE order_product_option_id=".$option);
	}
	public function delete_product_from_order($product){
		$query=$this->db->query("SELECT * FROM order_product op left join order_product_option opo on op.order_product_id=opo.order_product_id where op.order_product_id=".$product);
		$res=$query->result();
		if(empty($res->order_product_option_id)){
			//No options, update total and delete
			$this->db->query("DELETE FROM order_product WHERE order_product_id=".$product);
		}
	}
	public function deleteProduct($productID){
	    $this->db->query("DELETE FROM product WHERE product_id=".$productID);
	}
	public function update_product_quantities($product,$qty)
	{
		$this->db->query("UPDATE order_product SET quantity=".$qty.",total=price*".$qty." WHERE order_product_id=".$product);
	}
	
	
	public function update_product_comment($product,$comment)
	{
	    
		$this->db->query("UPDATE order_product SET order_product_comment='".$comment."' WHERE order_product_id=".$product);
	}
	
	public function update_option_quantities($option,$qty)
	{
	   
		$this->db->query("UPDATE order_product_option SET option_quantity=".$qty.", option_total=option_price*".$qty." WHERE order_product_option_id=".$option);
	}
      public function update_frontend_order_details($purchase_order_no,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_time,$delivery_notes,$order_comments,$cost_centre,$delivery_fee,$cust_firstname,$cust_email,$cust_telephone,$delivery_addr,$shipping_gate_number,$shipping_building_number,$shipping_department_name,$shipping_level_of_building,$shipping_room_number,$shipping_business_name,$shipping_street_number,$shipping_delivery_contact_name,$shipping_delivery_contact_number)
     {
         
        $cust_firstname=empty($cust_firstname)||$cust_firstname=='null'?'null':$this->db->escape($cust_firstname);
        
        
         $purchase_order_no=empty($purchase_order_no)||$purchase_order_no=='null'?'null':$this->db->escape($purchase_order_no);
	    
	    $cust_email=empty($cust_email)||$cust_email=='null'?'null':$this->db->escape($cust_email);
	    
	    $cust_telephone=empty($cust_telephone)||$cust_telephone=='null'?'null':$this->db->escape($cust_telephone);
         
        $delivery_addr=empty($delivery_addr)||$delivery_addr=='null'?'null':$this->db->escape($delivery_addr);
        
        $coupon_code=empty($coupon_code)||$coupon_code=='null'? 0 :$this->db->escape($coupon_code);
 
        $delivery_notes=empty($delivery_notes)||$delivery_notes=='null'?'""':$this->db->escape($delivery_notes);
	
		$order_comments=empty($order_comments)||$order_comments=='null'?'""':$this->db->escape($order_comments);
        
        $shipping_gate_number=empty($shipping_gate_number)||$shipping_gate_number=='null'?'""':$this->db->escape($shipping_gate_number);
        $shipping_building_number=empty($shipping_building_number)||$shipping_building_number=='null'?'""':$this->db->escape($shipping_building_number);
        $shipping_department_name=empty($shipping_department_name)||$shipping_department_name=='null'?'""':$this->db->escape($shipping_department_name);
        $shipping_level_of_building=empty($shipping_level_of_building)||$shipping_level_of_building=='null'?'""':$this->db->escape($shipping_level_of_building);
        $shipping_room_number=empty($shipping_room_number)||$shipping_room_number=='null'?'""':$this->db->escape($shipping_room_number);
        $shipping_business_name=empty($shipping_business_name)||$shipping_business_name=='null'?'""':$this->db->escape($shipping_business_name);
        $shipping_street_number=empty($shipping_street_number)||$shipping_street_number=='null'?'""':$this->db->escape($shipping_street_number);
        $shipping_delivery_contact_name=empty($shipping_delivery_contact_name)||$shipping_delivery_contact_name=='null'?'""':$this->db->escape($shipping_delivery_contact_name);
        $shipping_delivery_contact_number=empty($shipping_delivery_contact_number)||$shipping_delivery_contact_number=='null'?'""':$this->db->escape($shipping_delivery_contact_number);
         
       
         
         $delivery_date=date("Y-m-d",strtotime($delivery_date));
         
        
         $updated_by_ip = $_SERVER['REMOTE_ADDR'];

        if(!empty($this->session->userdata('email'))){
            $updated_by=$this->session->userdata('email');
        }
        else{
            $updated_by='';
        }
         
         
             $opencartdb = $this->load->database('opecart', TRUE); 

             $query = "UPDATE oc_order SET  purchase_order_no = ". $purchase_order_no. ", firstname= " .$cust_firstname.",email= ".$cust_email.",telephone= ".$cust_telephone.", shipping_address_2=".$delivery_addr.",coupon_id=".$coupon_code.",delivery_date='".$delivery_date."',comment=".$delivery_notes.",order_comments=".$order_comments.", shipping_gate_number= " .$shipping_gate_number.", shipping_building_number= " .$shipping_building_number.", shipping_department_name= " .$shipping_department_name.", shipping_level_of_building= " .$shipping_level_of_building.", shipping_room_number= " .$shipping_room_number.", shipping_business_name= " .$shipping_business_name.", shipping_street_number= " .$shipping_street_number.", shipping_delivery_contact_name= " .$shipping_delivery_contact_name.", shipping_delivery_contact_number= " .$shipping_delivery_contact_number.", updated_by='".$updated_by."', updated_by_ip='".$updated_by_ip."' WHERE order_id=".$order_id;
	         $query = $opencartdb->query($query);
	         
     $queryUpdateApproved = "UPDATE oc_order SET updatedAfterApproved= 1 , date_modified = '".date("Y-m-d H:i:s",strtotime("now"))."' WHERE order_id=".$order_id;
    $opencartdb->query($queryUpdateApproved);
	        
    
    }
    
    public function check_order_id($order_id){
    $query=$this->db->query("SELECT * FROM catering_checklist where order_id =".$order_id);
    return $query->result_array();
}
public function update_catering_checkList($order_id,$data,$is_catering_checklist_added,$ofrom){
   
    $this->db->query("UPDATE catering_checklist SET catering_location='".$data['catering_location']."', catering_time='".$data['catering_time']."', catering_people='".$data['catering_people']."', catering_delivery_instructions='".$data['catering_delivery_instructions']."', catering_dietary_req='".$data['catering_dietary_req']."', day_before_location='".$data['day_before_location']."', day_before_time='".$data['day_before_time']."', day_before_people='".$data['day_before_people']."', day_before_delivery_instructions='".$data['day_before_delivery_instructions']."', day_before_dietary_req='".$data['day_before_dietary_req']."', delivery_day_check_everything='".$data['delivery_day_check_everything']."', delivery_day_others='".$data['delivery_day_others']."', delivery_day_start_packing='".$data['delivery_day_start_packing']."', delivery_day_call_customer='".$data['delivery_day_call_customer']."', kitchen_catering_labels='".$data['kitchen_catering_labels']."', kitchen_check_dietary='".$data['kitchen_check_dietary']."', kitchen_check_all_items='".$data['kitchen_check_all_items']."', kitchen_staff_name='".$data['kitchen_staff_name']."' where order_id =".$order_id);
    if($ofrom == 'frontend'){
        $opencartdb = $this->load->database('opecart', TRUE); 
        $sql = "UPDATE oc_order SET is_catering_checklist_added='".$is_catering_checklist_added."' where order_id =".$order_id;
		$reslt= $opencartdb->query($sql);
    }else{
        $this->db->query("UPDATE orders SET is_catering_checklist_added='".$is_catering_checklist_added."' where order_id =".$order_id);
    }
        
    }
public function submit_catering_checkList($data,$is_catering_checklist_added,$ofrom){
    
    $order_id = $data['order_id'];
    $catering_location = $data['catering_location'];
    $catering_time = $data['catering_time'];
    $catering_people = $data['catering_people'];
    $catering_delivery_instructions = $data['catering_delivery_instructions'];
    $catering_dietary_req = $data['catering_dietary_req'];
    $day_before_location = $data['day_before_location'];
    $day_before_time = $data['day_before_time'];
    $day_before_people = $data['day_before_people'];
    $day_before_delivery_instructions = $data['day_before_delivery_instructions'];
    $day_before_dietary_req = $data['day_before_dietary_req'];
    $delivery_day_check_everything = $data['delivery_day_check_everything'];
    $delivery_day_others = $data['delivery_day_others'];
    $delivery_day_start_packing = $data['delivery_day_start_packing'];
    $delivery_day_call_customer = $data['delivery_day_call_customer'];
    $kitchen_catering_labels = $data['kitchen_catering_labels'];
    $kitchen_check_dietary = $data['kitchen_check_dietary'];
    $kitchen_check_all_items = $data['kitchen_check_all_items'];
    $kitchen_staff_name = $data['kitchen_staff_name'];
    
    $this->db->query("Insert INTO catering_checklist(order_id,catering_location,catering_time,catering_people,catering_delivery_instructions,catering_dietary_req,day_before_location,day_before_time,day_before_people,day_before_delivery_instructions,day_before_dietary_req,delivery_day_check_everything,delivery_day_others,delivery_day_start_packing,delivery_day_call_customer,kitchen_catering_labels,kitchen_check_dietary,kitchen_check_all_items,kitchen_staff_name) 
    VALUES('".$order_id."','".$catering_location."','".$catering_time."','".$catering_people."','".$catering_delivery_instructions."','".$catering_dietary_req."','".$day_before_location."','".$day_before_time."','".$day_before_people."','".$day_before_delivery_instructions."','".$day_before_dietary_req."','".$delivery_day_check_everything."','".$delivery_day_others."','".$delivery_day_start_packing."','".$delivery_day_call_customer."','".$kitchen_catering_labels."','".$kitchen_check_dietary."','".$kitchen_check_all_items."','".$kitchen_staff_name."')");
    
    $new_id=$this->db->insert_id();
    if($new_id){
        if($ofrom == 'frontend'){
            $opencartdb = $this->load->database('opecart', TRUE); 
            $sql = "UPDATE oc_order SET is_catering_checklist_added='".$is_catering_checklist_added."' where order_id =".$order_id;
    		$reslt= $opencartdb->query($sql);
        }else{
            $this->db->query("UPDATE orders SET is_catering_checklist_added='".$is_catering_checklist_added."' where order_id =".$order_id);
        }
    }
}
	public function update_order_details($status,$comp_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date_time,$delivery_notes,$order_comments,$delivery_fee,$standing_order,$customer_order_name,$customer_order_email,$customer_order_telephone,$delivery_telephone,$delivery_addr,$comp_addr,$accounts_email)
	{
	    	
	    
	    $customer_order_name=empty($customer_order_name)||$customer_order_name=='null'?'null':$this->db->escape($customer_order_name);
	    $accounts_email=empty($accounts_email)||$accounts_email=='null'?'null':$this->db->escape($accounts_email);
	    
	    $customer_order_email=empty($customer_order_email)||$customer_order_email=='null'?'null':$this->db->escape($customer_order_email);

	    $customer_order_telephone=empty($customer_order_telephone)||$customer_order_telephone=='null'?'null':$this->db->escape($customer_order_telephone);
	    
	    $delivery_telephone=empty($delivery_telephone)||$delivery_telephone=='null'?'null':$this->db->escape($delivery_telephone);
	    
	    $delivery_addr=empty($delivery_addr)||$delivery_addr=='null'?'null':$this->db->escape($delivery_addr);
	    
	    $company_name=empty($company_name)||$company_name=='null'?'null':$this->db->escape($company_name);
	    
	    $department_name =empty($department_name)||$department_name=='null'?'null':$this->db->escape($department_name);
	    
	    $comp_addr=empty($comp_addr)||$comp_addr=='null'?'null':$this->db->escape($comp_addr);
	    
		$delivery_notes=empty($delivery_notes)||$delivery_notes=='null'?'null':$this->db->escape($delivery_notes);
		
		$order_comments=empty($order_comments)||$order_comments=='null'?'null':$this->db->escape($order_comments);
		$delivery_fee=empty($delivery_fee)||$delivery_fee=='null'?0:$delivery_fee;
		if(empty($coupon_code)||$coupon_code=='null')
			$coupon_id='null';
		else
		{
			$code=$this->db->escape($coupon_code);
			$query=$this->db->query("SELECT * FROM coupon WHERE coupon_code=".$code);
			if(empty($query->result()))
			$coupon_id='null';
			else $coupon_id=$query->result()[0]->coupon_id;
		}
		$delivery_date_time=date("Y-m-d H:i",strtotime($delivery_date_time));

        if($status == 7){
            $updatedAfterApproved = true;
        }else{
            $updatedAfterApproved = false;
        }
        
		$this->db->query("UPDATE orders SET accounts_email=".$accounts_email." , updatedAfterApproved = ". $updatedAfterApproved. ", customer_company_name = ".$company_name.", customer_company_addr= ".$comp_addr.", customer_order_name= ".$customer_order_name.", customer_order_email= ".$customer_order_email.", customer_order_telephone= ".$customer_order_telephone." , customer_department_name = ".$department_name." , delivery_address=".$delivery_addr.",coupon_id=".$coupon_id.",delivery_date_time='".$delivery_date_time."',delivery_phone=".$delivery_telephone.",pickup_delivery_notes=".$delivery_notes.",order_comments=".$order_comments.",delivery_fee=".$delivery_fee.",standing_order=".$standing_order." WHERE order_id=".$order_id);
	 
	}
	public function recalculate_total($order_id,$table='')
	{
		$total=0;
		$query=$this->db->query("SELECT * FROM order_product WHERE order_id=".$order_id);
		$res=$query->result();
		foreach($res as $row){
			$total+=$row->total;
			$q2=$this->db->query("SELECT * FROM order_product_option WHERE order_product_id=".$row->order_product_id);
			$r2=$q2->result();
			foreach($r2 as $opt){
				$total+=$opt->option_total;
			}
		}
		if($table == 'quote'){
		    	$this->db->query("UPDATE quote SET order_total=".$total." WHERE order_id=".$order_id);
		}
		else{
		    	$this->db->query("UPDATE orders SET order_total=".$total." WHERE order_id=".$order_id);
		}
	
	}
	public function reorder($order_id,$date_time)
	{
	    
	    
	    $backend_order_id = $this->db->query("SELECT  MAX(order_id)   FROM `orderids_count`");
	    
	    $backend_order_id = json_decode(json_encode($backend_order_id->result()), True);
	    
          if ($backend_order_id) {
				$backend_order_id = $backend_order_id[0]['MAX(order_id)'];
				 $current_order_id  = $backend_order_id +1;
			} 
	    
	  		 
	     $date_added = date("Y-m-d H:i:s",strtotime("now"));
		$this->db->query("INSERT INTO orders (customer_id,customer_company_name,customer_company_addr,customer_department_name,user_id,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,selected_location,standing_order,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email) SELECT customer_id,customer_company_name,customer_company_addr,customer_department_name,user_id, shipping_method,pickup_delivery_notes,order_total,1,'".$date_added."','".$date_added."','".date("Y-m-d H:i",strtotime($date_time))."',selected_location,standing_order,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email FROM orders WHERE order_id=".$order_id);
		

// 		$this->db->query("INSERT INTO orders (customer_id,customer_company_name,customer_company_addr,customer_department_name,user_id,shipping_method,pickup_delivery_notes,order_total,order_status,date_added,date_modified,delivery_date_time,selected_location,standing_order,cost_centre,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email) SELECT customer_id,customer_company_name,customer_company_addr,customer_department_name,user_id, shipping_method,pickup_delivery_notes,order_total,1,date_added,date_modified,'".date("Y-m-d H:i",strtotime($date_time))."',selected_location,standing_order,cost_centre,order_comments,coupon_id,delivery_fee,delivery_phone,delivery_address,delivery_email FROM orders WHERE order_id=".$order_id);
		
		$new_order_id=$this->db->insert_id();
		
		$this->db->query("UPDATE orders SET order_id=".$current_order_id." WHERE order_id=".$new_order_id);
		
		
		
		
		$this->db->query("INSERT INTO `orderids_count` (`order_id`, `date`) VALUES ('".$current_order_id."',  CURRENT_TIMESTAMP)");
		//Select all products and then the subproducts for $order_id and insert as $new_order_id
		//Can't do as above because then can't insert into order_product_options
		$query=$this->db->query("SELECT * FROM order_product WHERE order_id=".$order_id);
		$res=$query->result();
		foreach($res as $row){
			$this->db->query("INSERT INTO order_product (order_id,order_product_comment,product_id,quantity,price,total) VALUES (".$current_order_id.",'".$row->order_product_comment."',".$row->product_id.",".$row->quantity.",".$row->price.",".$row->total.")");
			$order_product_id=$this->db->insert_id();
			$query=$this->db->query("SELECT * FROM order_product_option WHERE order_product_id=".$row->order_product_id);
			$this->db->query("INSERT INTO order_product_option (order_product_id,product_option_id,option_quantity,option_price,option_total) SELECT ".$order_product_id.", product_option_id,option_quantity,option_price,option_total FROM order_product_option WHERE order_product_id=".$row->order_product_id);
		}
		//Mark older order as non standing
		$this->db->query("UPDATE orders SET standing_order=0 WHERE order_id=".$order_id);
	}
	public function fetch_running_sheet($orders)
	{
	    
	  
	      $all_order_ids = implode(',',$orders);   
		  $final_res = [];
	      $query=$this->db->query("SELECT * FROM orders o left JOIN customer c ON o.customer_id=c.customer_id left JOIN company co ON c.company_id=co.company_id LEFT JOIN store s ON s.location_id=o.selected_location WHERE o.order_id IN (".$all_order_ids .") order by delivery_date_time asc");
		  $results = $query->result();
         
			if(!empty($results)){
			    foreach($results as $result){
		
			$query=$this->db->query("SELECT * FROM order_product op join product p on op.product_id=p.product_id where order_id=".$result->order_id." order by sort_order asc");
			$result->products=$query->result();
			foreach($result->products as $product){
				$query=$this->db->query("SELECT * FROM order_product op join order_product_option opo on op.order_product_id=opo.order_product_id join product_option po on po.product_option_id=opo.product_option_id join option_value ov on ov.option_value_id=po.option_value_id where op.order_product_id=".$product->order_product_id);
				$product->options=$query->result();
		
			
// 			$final_res[]=$result;
			}
			}
		}
		return $results;
	}
	
	
		public function fetch_running_sheet_for_frontend_orders($orders)
	    {
	    $opencartdb = $this->load->database('opecart', TRUE); 
		$final_res=[];
		foreach($orders as $order)
		{
		$sql = "SELECT o.order_id,o.cost_centre,o.total,o.order_made_from, o.firstname , o.lastname ,o.email,o.telephone, o.delivery_date as delivery_date_time,o.comment as order_comments FROM `oc_order` o  where o.order_id = $order";
		
		$reslt= $opencartdb->query($sql);
		
		if(!empty($reslt))	{
		
		$res = $reslt->result();
		if(!empty($res)){
		$res=$res[0];	
		$query = "SELECT * FROM oc_order_product WHERE order_id = '" . (int)$order . "'";

        $query = $opencartdb->query($query);
           
        $res->products =$query->result();

		foreach($res->products as $product){
			    
		$query = "SELECT * FROM oc_order_option WHERE order_id = '" . (int)$order . "' AND order_product_id = '" . (int)$product->order_product_id . "'";

		$product_options = $opencartdb->query($query);   
		
		$product->options =$product_options->result();

		$query = "SELECT * FROM oc_product_description WHERE product_id = '" . (int)$product->product_id . "'";

        $product_desc = $opencartdb->query($query);
			    
		$product->desc =$product_desc->result();	    
				
			}
			$final_res[]=$res;
		}
		}
		}
		return $final_res;
	}
	
	
	public function group_mark_as_paid($orders,$referrer='')
	{
	    
	     $date_added = date("Y-m-d H:i:s",strtotime("now"));
	     
	   
	   foreach($orders as $order){
	      
      $tmp = explode('_', $order);

     $ofrom = $tmp[0];
     $order_id = $tmp[1];
     
	   
	     
	    if(isset($ofrom) && $ofrom =='frontend'){
	        
	        
	        $opencartdb = $this->load->database('opecart', TRUE); 
	        
    
		$orderupdate_query = "UPDATE `oc_order` SET order_status_id = 2, mark_paid_comment = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id;
	  
        $query = $opencartdb->query($orderupdate_query);
	        
	    }else if(isset($ofrom) && $ofrom =='backend'){
	        
	        $this->db->query("UPDATE orders SET order_status=2 , mark_paid_comment = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }else{
	        $this->db->query("UPDATE orders SET order_status= 2 , date_modified = '".$date_added."' WHERE order_id=".$order_id);

	        
	    }
	    
	   }
	   
		
	}
	
	
	public function mark_paid($order_id,$referrer='',$ofrom='')
	{
	    
	     $date_added = date("Y-m-d H:i:s",strtotime("now"));
	     
	   
	     
	    if(isset($ofrom) && $ofrom =='frontend'){
	    $opencartdb = $this->load->database('opecart', TRUE); 
		$orderupdate_query = "UPDATE `oc_order` SET order_status_id = 2, mark_paid_comment = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id;
        $query = $opencartdb->query($orderupdate_query);
	    }else if(isset($ofrom) && $ofrom =='backend'){
	     $this->db->query("UPDATE orders SET order_status=2, mark_paid_comment = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }else{
	      $this->db->query("UPDATE orders SET order_status=2 , date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }
	    
	   
		
	}
		public function mark_as_completed($order_id,$ofrom='')
	{
	    
	     $date_added = date("Y-m-d H:i:s",strtotime("now"));
	    if(isset($ofrom) && $ofrom =='frontend'){
	      
	     $opencartdb = $this->load->database('opecart', TRUE); 
		$orderupdate_query = "UPDATE `oc_order` SET is_completed = 1,  date_modified = '".$date_added."' WHERE order_id=".$order_id;
        $query = $opencartdb->query($orderupdate_query);
	    }else if(isset($ofrom) && $ofrom =='backend'){
	        $this->db->query("UPDATE orders SET is_completed=1,  date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }else{
	        $this->db->query("UPDATE orders SET is_completed= 1 , date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }
	    
	   
		
	}
	
	public function add_order_comment($order_id,$referrer='',$ofrom='')
	{
	    
	     $date_added = date("Y-m-d H:i:s",strtotime("now"));
	     
	   
	     
	    if(isset($ofrom) && $ofrom =='frontend'){
	        
	        
	        $opencartdb = $this->load->database('opecart', TRUE); 
	        
    
		$orderupdate_query = "UPDATE `oc_order` SET  comment = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id;
	  
        $query = $opencartdb->query($orderupdate_query);
	        
	    }else if(isset($ofrom) && $ofrom =='backend'){
	        
	        $this->db->query("UPDATE orders SET order_comments = '".$referrer."', date_modified = '".$date_added."' WHERE order_id=".$order_id);
	    }
	    
	   
		
	}
	
	
	
	
	
	
	public function delete_order($order_id,$ofrom='',$comments='',$table='')
	{
	    if($table == ''){
	        $table = 'orders';
	    }
	     $date_modified = date("Y-m-d H:i:s",strtotime("now"));
	    
	   
	    if(isset($ofrom) && $ofrom =='frontend'){
	        
	        
	        $opencartdb = $this->load->database('opecart', TRUE); 
	        
    
		$orderupdate_query = "UPDATE `oc_order` SET order_status_id = 0,  date_modified = '".$date_modified."', cancel_comment ='".$comments."' WHERE order_id=".$order_id;
	  
        $query = $opencartdb->query($orderupdate_query);
	        
	    }else if(isset($ofrom) && $ofrom =='backend'){
	       
	        $this->db->query("UPDATE ".$table." SET order_status= 0 ,  date_modified = '".$date_modified."', cancel_comment ='".$comments."' WHERE order_id=".$order_id);
	    }else{
	        $this->db->query("UPDATE ".$table." SET order_status= 0  , cancel_comment ='".$comments."'WHERE order_id=".$order_id);

	        
	    }
	    
		
	}
	
	public function generate_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations=0)
	{
	    
	    $userId = $this->session->userdata('user_id');
	    
	  	if($locations==0){
	  	    if($userId == 1){
	  	       	$userId = '1,2'; 
	  	    }else{
	  	       	$userId = $userId; 
	  	    }
		
		}
		else {
			$userId = $locations;
		}
	    
// 		$dateWhere="(delivery_date_time BETWEEN '".$date_from." 00:00:01' AND '".$date_to." 23:59:59')";
if($date_from == 1 || $date_to == 1){
     $dateWhere="1";
}
else if($date_from == $date_to){
    
     $dateWhere="o.delivery_date_time LIKE '%".date("Y-m-d",strtotime($date_from))."%'";
	 $date_to="1";
    
}else{
     $dateWhere="(o.delivery_date_time >= '".$date_from." 00:00:01' AND o.delivery_date_time <='".$date_to." 23:59:59')";
}


if($added_date_from == 1 || $added_date_to == 1){
     $added_dateWhere="1";
}
else if($added_date_from == $added_date_to){
    
     $added_dateWhere="o.date_added LIKE '%".date("Y-m-d",strtotime($added_date_from))."%'";
	 $added_date_to="1";
    
}else{
     $added_dateWhere="(o.date_added >= '".$added_date_from."' AND o.date_added <='".$added_date_to." 23:59:59')";
}

  
		if($company==0){
			$companyWhere="1";
		}
		else $companyWhere="c.company_id=".$company;
		
		 if($status==91){
		    $statusWhere="order_status != 0"; 
		}
		elseif($status==90){
		  $statusWhere="order_status != 2";  
		}
		elseif($status!='' && $status != 'null' && $status != null){
		  $statusWhere="order_status=".$status; 
		} else{
		    
		     $statusWhere = "1";
		}
	  $userIdWhere = " o.user_id IN (".$userId.")";

	  $query=$this->db->query("SELECT *,o.date_added as order_date_added FROM orders o left JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN user_postcode up on o.postcode = up.postal_code left JOIN company co ON c.company_id=co.company_id LEFT JOIN coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN department d ON c.department=d.department_id WHERE ".$added_dateWhere." AND ".$dateWhere." AND ".$companyWhere." AND ".$statusWhere ." AND ".$userIdWhere);  
  
		return $query->result();
	}
	
	
public function generate_frontend_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations=0)
	{
	    	$opencartdb = $this->load->database('opecart', TRUE); 	
	    	
		    $userId = $this->session->userdata('user_id');
		    
		 if($locations==0){
			$userId = $userId;
			$userIdWhere = "1";
		}
		else {
			$userId = $locations;
			$userIdWhere = " o.user_id IN (".$userId.")";
		}
		
// 		$dateWhere="(delivery_date BETWEEN '".$date_from."' AND '".$date_to." 23:59:59')";


if($date_from == 1 || $date_to == 1){
     $dateWhere="1";
}
else if($date_from == $date_to){
    
     $dateWhere="o.delivery_date LIKE '%".date("Y-m-d",strtotime($date_from))."%'";
	 $date_to="1";
    
}else{
     $dateWhere="(o.delivery_date >= '".$date_from."' AND o.delivery_date <='".$date_to." 23:59:59')";
}


if($added_date_from == 1 || $added_date_to == 1){
     $added_dateWhere="1";
}
else if($added_date_from == $added_date_to){
    
     $added_dateWhere="o.date_added LIKE '%".date("Y-m-d",strtotime($added_date_from))."%'";
	 $added_date_to="1";
    
}else{
     $added_dateWhere="(o.date_added >= '".$added_date_from."' AND o.date_added <='".$added_date_to." 23:59:59')";
}

		if($company==0){
			$companyWhere="1";
		}
		else $companyWhere="c.company_name=".$company;
		 if($status==90){
		    $statusWhere="order_status_id != 2"; 
		}
	   elseif($status==91){
		    	$statusWhere="order_status_id != 0";
		}
		elseif($status!='' && $status != 'null' && $status != null){
		  $statusWhere="order_status_id=".$status; 
		} else{
		    
		     $statusWhere = "1";
		}
	 
	
    $query = "SELECT o.order_id,o.mark_paid_comment,o.total,o.order_status_id,o.date_added as order_date_added,o.date_modified,o.delivery_date,o.firstname,o.lastname,d.dept_name,co.company_name,o.telephone,o.email,us.username FROM oc_order o  left join oc_user us on us.user_id = o.user_id left JOIN oc_customer c ON o.customer_id=c.customer_id left JOIN oc_companies co ON c.company_id=co.company_id LEFT JOIN oc_coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN oc_departments d ON c.department=d.dept_id WHERE ".$added_dateWhere." AND ".$dateWhere." AND ".$companyWhere." AND ".$statusWhere." AND ".$userIdWhere;    
// 	echo $query; exit;
	$query=$opencartdb->query($query);
	
		return $query->result();
	}
	
	public function approve_quote($order_id,$comments,$order_status_value="")
	{   
	   
		$this->db->query("UPDATE quote SET order_status=".$order_status_value.",approval_comments=".$this->db->escape($comments)." WHERE order_id=".$order_id);
		
		return true;
	}
	
	public function reject_order($order_id)
	{
		$this->db->query("UPDATE quote SET order_status=8  WHERE order_id=".$order_id);
	}
	public function modify_order($order_id)
	{
		$this->db->query("UPDATE quote SET order_status=9  WHERE order_id=".$order_id);
	}
	public function get_order($order_id)
	{
		$query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id WHERE order_id=".$order_id);
		return $query->result();
	}
	
	public function getall_user()
	{
	    
		$query=$this->db->query("SELECT * FROM `user`");
		
	
		return $query->result();
	}
	
	
		public function getall_user_order($userId='')
	{
	    
		$query=$this->db->query("SELECT * FROM orders o left JOIN user us on us.user_id = o.user_id left join customer c ON o.customer_id=c.customer_id LEFT JOIN user_postcode up on o.postcode = up.postal_code left JOIN company co ON c.company_id=co.company_id LEFT JOIN coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN department d ON c.department=d.department_id WHERE o.order_status = 3 and o.branch_id =" .$userId." AND DATE(o.date_modified) = CURDATE() - INTERVAL 1 DAY");   
		
// 		$query=$this->db->query("SELECT * FROM orders o left JOIN user us on us.user_id = o.user_id left join customer c ON o.customer_id=c.customer_id LEFT JOIN user_postcode up on o.postcode = up.postal_code left JOIN company co ON c.company_id=co.company_id LEFT JOIN coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN department d ON c.department=d.department_id WHERE o.order_status = 3");   
	
		return $query->result();
	}
	
		public function getall_user_order_frontend($userId ='')
	{
	    $opencartdb = $this->load->database('opecart', TRUE);
		
		$query = "SELECT o.order_id,o.mark_paid_comment,o.total,o.order_status_id,o.date_added,o.date_modified,o.delivery_date,o.firstname,o.lastname,d.dept_name,co.company_name,o.telephone,o.email,us.username FROM oc_order o  left join oc_user us on us.user_id = o.user_id left JOIN oc_customer c ON o.customer_id=c.customer_id left JOIN oc_companies co ON c.company_name=co.company_id LEFT JOIN oc_coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN oc_departments d ON c.department=d.dept_id WHERE o.order_status_id = 3 And o.branch_id = " .$userId ."  AND DATE(o.date_modified) = CURDATE() - INTERVAL 1 DAY";    
	
// 	$query = "SELECT o.order_id,o.mark_paid_comment,o.total,o.order_status_id,o.date_added,o.date_modified,o.delivery_date,o.firstname,o.lastname,d.dept_name,co.company_name,o.cost_centre,o.telephone,o.email,us.username FROM oc_order o  left join oc_user us on us.user_id = o.user_id left JOIN oc_customer c ON o.customer_id=c.customer_id left JOIN oc_companies co ON c.company_name=co.company_id LEFT JOIN oc_coupon cu ON o.coupon_id=cu.coupon_id LEFT JOIN oc_departments d ON c.department=d.dept_id WHERE o.order_status_id= 3";    	
	$query=$opencartdb->query($query);
		return $query->result();
	}
	
	public function fetch_all_order_history($params='',$order_date='')
	{      	
	   
	  // $userId = $this->session->userdata('user_id');
	     
	    
		if(empty($params))
		{
		  
	
    if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= CURDATE()';
        
    }else if($order_date =='past_orders'){
        
        $sqll = 'o.delivery_date_time < CURDATE()';
        
    }
  
  	$qry="select o.*,c.*,v.* from orders o 
left JOIN customer c ON o.customer_id=c.customer_id  
LEFT JOIN coupon v ON o.coupon_id=v.coupon_id 
LEFT JOIN company co ON c.company_id=co.company_id 
LEFT JOIN user_postcode up on o.postcode = up.postal_code 
where $sqll and o.order_status != 0  ORDER BY o.order_id desc";

			
			$query = $this->db->query($qry);
			

			return $query->result();

			
			
		}
		else{
		    
		  //  echo $params['department']; exit;
		if(empty($params['date_from']) && empty($params['date_to'])){    
		    
		    if($order_date == 'future_order')
    {
        $sqll = 'o.delivery_date_time >= CURDATE()';
        
    }else if($order_date =='past_orders'){
        
        $sqll = 'o.delivery_date_time < CURDATE()';
        
    }
    
		}	   
			
			if(!empty($params['sort_order'])){
				if($params['sort_order']==0){
					$order_by='delivery_date_time asc';
				}
				else if($params['sort_order']==1){
					$order_by='delivery_date_time desc';
				}
				else if($params['sort_order']==2){
					$order_by='order_id asc';
				}
				else $order_by='order_id desc';
			}
			else $order_by='delivery_date_time asc';
			
			if(!empty($params['date_to']) &&  !empty($params['date_from']) && $params['date_from'] == $params['date_to']){
			   
			    $fromWhere="delivery_date_time LIKE '%".date("Y-m-d",strtotime($params['date_from']))."%'";
			    $toWhere="1";
			    
			}else{
			if(!empty($params['date_from']))
				$fromWhere="delivery_date_time >='".date("Y-m-d",strtotime($params['date_from']))." 00:00:01'";
			else $fromWhere=$sqll;
			
			if(!empty($params['date_to']))
				$toWhere="delivery_date_time<='".date("Y-m-d",strtotime($params['date_to']))." 23:59:59'";
			else $toWhere="1";
			}
			if(isset($params['company']))
				$companyWhere="c.company_id=".$params['company'];
			else $companyWhere="1";
			if(isset($params['department'] ) && $params['department'] !=0)
				$deptWhere="d.department_id=".$params['department'];
			else $deptWhere="1";
			if(isset($params['customer']))
				$cWhere="c.customer_id=".$params['customer'];
			else $cWhere="1";
			
			if(isset($params['location']))
				$userWhere="o.user_id=".$params['location'];
			else $userWhere="1";
			if(isset($params['order_no']) && $params['order_no'] !='unset')
				$orderidwhere="o.order_id=".$params['order_no'];
			else $orderidwhere="1";
			
		
		
			
			
			    if(isset($orderidwhere) && $orderidwhere != 1){

		       $query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department_id WHERE ".$companyWhere." AND ".$deptWhere." AND ".$cWhere." and o.branch_id = ". $userId."  AND ".$orderidwhere. " AND o.order_status != 0   ORDER BY ".$order_by);
              }else{
   
			  $query=$this->db->query("SELECT * FROM orders o JOIN customer c ON o.customer_id=c.customer_id LEFT JOIN coupon v ON o.coupon_id=v.coupon_id left join company co ON c.company_id=co.company_id left join department d on c.department = d.department_id WHERE ".$fromWhere." AND ".$toWhere." AND ".$companyWhere." AND ".$deptWhere." AND ".$cWhere." and o.branch_id = ". $userId."  AND o.order_status != 0  ORDER BY ".$order_by);
               }
			    return $query->result();
		}
	}
	public function fetch_manager_notifications(){
		 
		$table ='notification';
// 		$condition = 'userID = '.$this->session->userdata('user_id');
$condition = 'userID = 3';
		$query = $this->db->query('SELECT * FROM '.$table.'  WHERE `date_added` BETWEEN DATE_SUB(NOW(), INTERVAL 16 DAY) AND NOW() AND '.$condition." order by id desc");
			return $query->result();
	}
    public function fetch_notifications_count(){
         	
    		$table ='notification';
    // 		$condition = 'userID = '.$this->session->userdata('user_id');
    $condition = 'userID = 3';
    		$query = $this->db->query('SELECT COUNT(id) as total_count FROM '.$table.'  WHERE `date_added` BETWEEN DATE_SUB(NOW(), INTERVAL 16 DAY) AND NOW() AND '.$condition);
    	
    			return $query->result_array();
    }
    function add_notification($data){
	   
	   if($this->db->insert('notification',$data)){
	       
	         return true;
	   }else{
	    return true;
	   }
	 
	}
}
