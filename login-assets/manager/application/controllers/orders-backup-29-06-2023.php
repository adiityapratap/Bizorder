<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Orders extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination'); 
		$this->load->model('orders_model');
		$this->load->helper('url');
// 		$this->load->library('session');
		$this->load->helper('notification');
		$this->load->library('email');
		$this->fromEmail = 'catering@healthychoicescatering.com.au';
// 		ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	}
	public function index()
	{
	  
	$this->load->view('general/login');
	}
	public function update_GST_status($id,$status){
	    
	    $result=$this->orders_model->update_GST_status($id,$status);
	   
	    if($result){
	        echo "success";
	    }else{
	        echo "error";
	    }
	}
	
	public function customer_cost_center(){
	  
		  $locations=$this->orders_model->fetchLocations('0');
		  $result=$this->orders_model->fetch_customer_cost_center();
		  $data['costcenter'] = $result;
		  $data['locations'] = $locations;
		   $this->load->view('general/header');
		$this->load->view('general/customer_cost_center',$data);
		$this->load->view('general/footer');
		 
		}
	    
	public function catering_checkList($order_id,$ofrom,$prev_URL=''){
	   
	    $result=$this->orders_model->fetch_catering_checkList($order_id);
	     if($ofrom == 'frontend'){
		$data['order_info'] = $this->orders_model->getOrder($order_id);
		 }else{
		$data['order_info'] =$this->orders_model->fetch_order_info($order_id)[0];
	  
		     }

	
	    $data['catering_checkList'] = $result;
	    $data['order_id'] = $order_id;
	    $data['ofrom'] = $ofrom;
	    $data['prev_URL'] = $prev_URL;
	   
        $this->load->view('general/header');
        $this->load->view('orders/catering_checkList',$data);	
        $this->load->view('general/footer');
	   
	}
	public function submit_catering_checkList(){
	    
	    $checklist_status = 0;
	    $checklistSection1 = 0;
	    $checklistSection2 = 0;
	    $checklistSection3 = 0;
	    $checklistSection4 = 0;
	    $ofrom = $_POST['ofrom'];
	    $prev_URL = $_POST['prev_URL'];
	    if($_POST['catering_location'] == '1'){ $data['catering_location'] = $_POST['catering_location'];  $checklistSection1++;
	    }else{ $data['catering_location'] = '';  }
	    
	    if($_POST['catering_time'] == '1'){ $data['catering_time'] = $_POST['catering_time'];  $checklistSection1++;
	    }else{ $data['catering_time'] = ''; }
	    
	    if($_POST['catering_people'] == '1'){ $data['catering_people'] = $_POST['catering_people'];  $checklistSection1++;
	    }else{ $data['catering_people'] = ''; }
	    
	    if($_POST['catering_delivery_instructions'] == '1'){ $data['catering_delivery_instructions'] = $_POST['catering_delivery_instructions'];  $checklistSection1++;
	    }else{ $data['catering_delivery_instructions'] = ''; }
	    
	    if($_POST['catering_dietary_req'] == '1'){ $data['catering_dietary_req'] = $_POST['catering_dietary_req'];  $checklistSection1++;
	    }else{ $data['catering_dietary_req'] = ''; }
	    
	    if($_POST['day_before_location'] == '1'){ $data['day_before_location'] = $_POST['day_before_location'];  $checklistSection2++;
	    }else{ $data['day_before_location'] = ''; }
	    
	    if($_POST['day_before_time'] == '1'){ $data['day_before_time'] = $_POST['day_before_time'];  $checklistSection2++;
	    }else{ $data['day_before_time'] = ''; }
	    
	    if($_POST['day_before_people'] == '1'){ $data['day_before_people'] = $_POST['day_before_people'];  $checklistSection2++;
	    }else{ $data['day_before_people'] = ''; }
	    
	    if($_POST['day_before_delivery_instructions'] == '1'){ $data['day_before_delivery_instructions'] = $_POST['day_before_delivery_instructions'];  $checklistSection2++;
	    }else{ $data['day_before_delivery_instructions'] = ''; }
	    
	    if($_POST['day_before_dietary_req'] == '1'){ $data['day_before_dietary_req'] = $_POST['day_before_dietary_req'];  $checklistSection2++;
	    }else{ $data['day_before_dietary_req'] = ''; }
	    
	    
	    if($_POST['delivery_day_check_everything'] == '1'){ $data['delivery_day_check_everything'] = $_POST['delivery_day_check_everything'];  $checklistSection3++;
	    }else{ $data['delivery_day_check_everything'] = ''; }
	    
	    if($_POST['delivery_day_others'] == '1'){ $data['delivery_day_others'] = $_POST['delivery_day_others'];  $checklistSection3++;
	    }else{ $data['delivery_day_others'] = ''; }
	    
	    if($_POST['delivery_day_start_packing'] == '1'){ $data['delivery_day_start_packing'] = $_POST['delivery_day_start_packing'];  $checklistSection3++;
	    }else{ $data['delivery_day_start_packing'] = ''; }
	    
	    if($_POST['delivery_day_call_customer'] == '1'){ $data['delivery_day_call_customer'] = $_POST['delivery_day_call_customer'];  $checklistSection3++;
	    }else{ $data['delivery_day_call_customer'] = ''; }
	    
	    if($_POST['kitchen_catering_labels'] == '1'){ $data['kitchen_catering_labels'] = $_POST['kitchen_catering_labels'];  $checklistSection4++;
	    }else{ $data['kitchen_catering_labels'] = ''; }
	    
	    if($_POST['kitchen_check_dietary'] == '1'){ $data['kitchen_check_dietary'] = $_POST['kitchen_check_dietary'];  $checklistSection4++;
	    }else{ $data['kitchen_check_dietary'] = ''; }
	    
	    if($_POST['kitchen_check_all_items'] == '1'){ $data['kitchen_check_all_items'] = $_POST['kitchen_check_all_items'];  $checklistSection4++;
	    }else{ $data['kitchen_check_all_items'] = ''; }
	    
	    if($_POST['kitchen_staff_name'] != ''){ $data['kitchen_staff_name'] = $_POST['kitchen_staff_name']; 
	    }else{ $data['kitchen_staff_name'] = ''; }
	    
	    $checklistSectionCount = 0;
	    if($checklistSection1 == 5){
	        $checklistSectionCount++;
	    }
	    if($checklistSection2 == 5){
	        $checklistSectionCount++;
	    }
	    if($checklistSection3 == 4){
	        $checklistSectionCount++;
	    }
	    if($checklistSection4 == 3){
	        $checklistSectionCount++;
	    }
	    if($checklistSectionCount == 1){
            $checklist_status = 1;
        }elseif($checklistSectionCount == 2){
            $checklist_status = 2;
        }elseif($checklistSectionCount == 3){
            $checklist_status = 3;
        }elseif($checklistSectionCount == 4){
            $checklist_status = 4;
        }
	    $order_id = $_POST['order_id'];
	    $res=$this->orders_model->check_order_id($order_id); 
	    
	    if(!empty($res)){
	      
	        $result=$this->orders_model->update_catering_checkList($order_id,$data,$checklist_status,$ofrom);
	    }else{
	        $data['order_id'] = $order_id;
	       // echo "<pre>";print_r($data);exit;
	        $result=$this->orders_model->submit_catering_checkList($data,$checklist_status,$ofrom);
	    }
	    if($prev_URL == 'dashboard'){
		    redirect('orders/open_dash/'.$this->session->userdata('branch_id'));
	    }else{ 
	        redirect('orders/production');
	    }
	}
	
	public function unapprovedQuotesNotification(){
		$unapprovedQuotes=$this->orders_model->unapprovedQuotes();
		foreach($unapprovedQuotes as $unapprovedQuote){
		    $this->sendWarningMailUnapprovedStatus($unapprovedQuote->customer_order_email,$unapprovedQuote->customer_order_name,$unapprovedQuote->order_id,$unapprovedQuote->order_total,$unapprovedQuote->customer_id,'warningApprove');
		}
	
	}
    public function TodayDeliveryNotification(){
	    
		$TodayDeliveryNQuotes=$this->orders_model->TodayDeliveryNotification();
		foreach($TodayDeliveryNQuotes as $Quote){
		    $this->sendWarningMailUnapprovedStatus($Quote->customer_order_email,$Quote->customer_order_name,$Quote->order_id,$Quote->order_total,$Quote->customer_id,'todayDelivery');
		}
	
	}
	public function sevenDaysDelayNotification(){

		$sevenDaysDelayQuotes=$this->orders_model->sevenDaysDelayNotification();
		foreach($sevenDaysDelayQuotes as $Quote){
		    $this->sendWarningMailUnapprovedStatus($Quote->customer_order_email,$Quote->customer_order_name,$Quote->order_id,$Quote->order_total,$Quote->customer_id,'sevenDayDelay');
		}
	}
	public function fourteenDaysDelayNotification(){

		$fourteenDaysDelaynQuotes=$this->orders_model->fourteenDaysDelayNotification();
		foreach($fourteenDaysDelaynQuotes as $Quote){
		    $this->sendWarningMailUnapprovedStatus($Quote->customer_order_email,$Quote->customer_order_name,$Quote->order_id,$Quote->order_total,$Quote->customer_id,'sevenDayDelay');
		}
	}
	
	public function sendWarningMailUnapprovedStatus($customerMailID,$customerName,$order_id,$order_total,$customer_id,$mailType='')
	{ 
            $customerDetails=$this->orders_model->getCustomerFromCustomerId($customer_id);
		    $toemail = $customerMailID;
		    $data['customer_name'] = $customerName;
            $data['order_id'] = $order_id;
           	$regen_auth=sha1($customerDetails[0]->firstname."|".$customerDetails[0]->lastname."|".$order_id."|".$order_total);
 
            $data['auth_token'] = $regen_auth;
            if($mailType=='warningApprove'){
              $body = $this->load->view('orders/warning_quoteApproveMail', $data,TRUE);  
            }
           if($mailType=='todayDelivery'){
               $body = $this->load->view('orders/todayDeliveryInfoMail', $data,TRUE);    
            }
            if($mailType=='sevenDayDelay'){
               $body = $this->load->view('orders/sevenDayDelayMail', $data,TRUE);    
            }
            
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering ');
            $this->email->message($body);
            $mail = $this->email->send();
            
	}
	
	
	
	
	public function view_all_feedback($date_from='',$date_to='',$textFilter='')
	{
		if(!empty($this->session->userdata('username')))
		{
			$params=array();
			
			 //$data = $conditions = array(); 
        $uriSegment = 3; 
         
        // Get record count 
          $conditions['returnType'] = 'count'; 
        
			if($date_from!=''&&$date_from!='unset')
				$params['date_from']=$date_from;
				
			if($date_to!=''&&$date_to!='unset')
				$params['date_to']=$date_to;
				
			if($textFilter!=''&&$textFilter!='unset')
				$params['textFilter']=$textFilter;
				
		$totalRec=	$this->orders_model->fetch_all_feedback($conditions);
	    
		$config['base_url']    = base_url().'orders/view_all_feedback/'; 
        $config['uri_segment'] = $uriSegment; 
        $config['total_rows']  = $totalRec[0]->count; 
        $config['per_page']    = (!empty($this->perPage) ? $this->perPage : ''); 
		$this->pagination->initialize($config); 
		
		 $page = $this->uri->segment($uriSegment); 
        $offset = !$page?0:$page; 
        
         $data['orderfeedback_info' ]= $this->orders_model->fetch_all_feedback($params);
			$this->load->view('general/header');
			$this->load->view('orders/view_all_feedback',$data);
			$this->load->view('general/footer');	
			
		}
		else redirect('general/index');
	}
	public function production($order_date='',$order_no='')
	{
	    	$this->load->model('general_model');
// 	    		  ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	    	
		if(!empty($this->session->userdata('username')))
		{
			$params=array();
			
		       if($order_no!='' && $order_no!='unset')
				$params['order_no']=$order_no;
				if($order_date!=''&& $order_date!='unset')
				$params['order_date']=$order_date;
				
			$data['customers']=$this->general_model->fetch_customers();
			$data['companies']=$this->general_model->fetch_companies();
			$data['backend_orders']=$this->orders_model->production_fetch_order_history($params,'future_order',true);
		 	$data['frontend_orders']=$this->orders_model->production_frontend_Orders($params,'future_order',true);
		    $data['orders'] = array_merge($data['backend_orders'],$data['frontend_orders']);
		    $data['orders']  = json_decode(json_encode($data['orders']), True);
	       	 
	        $keys = array_column($data['orders'], 'order_id');
		    foreach ($data['orders'] as $key => $part) {
             $sort[$key] = strtotime($part['delivery_date_time']);
              }
              array_multisort($sort, SORT_ASC, $data['orders']);
              $data['orders'] = json_decode(json_encode($data['orders']));
              
            //   echo "<pre>";
            //   print_r($data['orders']);
            //   exit;
			$this->load->view('general/header');
			$this->load->view('orders/production',$data);
			$this->load->view('general/footer');	
		}
		else redirect('general/index');
	}
	public function open_dash($branch_id='')
	{ 
// 	    ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

		if(!empty($this->session->userdata('username')))
		{
		    if($this->session->userdata('is_customer') == 1){
		        redirect('orders/order_history');
		    }else{
		        
		    $this->load->model('general_model');
		    $this->session->set_userdata('user_id',(int)$branch_id);
			$this->session->set_userdata('branch_id',(int)$branch_id);
			$dashboardDataForOrders =$this->general_model->fetch_dash_data();
			$data['deliveries_today'] = $dashboardDataForOrders['deliveries_today'];
// 			$data['tommorowDeliveries'] = $dashboardDataForOrders['tommorowAllDeliveries'];
			$data['upcomingWeekDelivery'] = $dashboardDataForOrders['upcomingWeekDelivery'];
			$data['total_unpaid'] = $dashboardDataForOrders['total_unpaid'];
			$anyunApprovedcustomers =$this->general_model->checkUnApprovedcustomers();
		if($anyunApprovedcustomers){
		    $data['unapprovedCustomerClassName'] = 'border-red';
		}else{
		   $data['unapprovedCustomerClassName'] = ''; 
		}
// 			fetch dashboard orders
			$backend_orders_curr =$this->general_model->fetch_backend_order_curr();
			$backend_orders_tommorow =$this->general_model->fetch_backend_order_curr('tommorow');
			$backend_orders_upcomingWeek =$this->general_model->fetch_backend_order_curr('week');
		
			
			$frontend_orders=$this->general_model->getOrders_curr();
			$frontend_orders_tommorow=$this->general_model->getOrders_curr('tommorow');
			$frontend_orders_upcomingWeek=$this->general_model->getOrders_curr('week');
			
			
			 $data['orders'] = array_merge($backend_orders_curr['last_five'],$frontend_orders);
			
		    $data['orders']  = json_decode(json_encode($data['orders']), True);
	       	 
	        $keys = array_column($data['orders'], 'order_id');
		    foreach ($data['orders'] as $key => $part) {
             $sort[$key] = strtotime($part['delivery_date_time']);
              }
              array_multisort($sort, SORT_ASC, $data['orders']);
              
              $data['last_five'] = json_decode(json_encode($data['orders']));
             
              $data['tommorowOrders'] = array_merge($backend_orders_tommorow['last_five'],$frontend_orders_tommorow);
              $data['upcomingWeekOrders'] = array_merge($backend_orders_upcomingWeek['last_five'],$frontend_orders_upcomingWeek);
              
              $data['upcomingWeekOrders']  = json_decode(json_encode($data['upcomingWeekOrders']), True);
              $keys = array_column($data['upcomingWeekOrders'], 'order_id');
              foreach ($data['upcomingWeekOrders'] as $key => $part) {
             $sort[$key] = strtotime($part['delivery_date_time']);
              }
              array_multisort($sort, SORT_ASC, $data['upcomingWeekOrders']);
              
              
              $data['upcomingWeekOrders'] = json_decode(json_encode($data['upcomingWeekOrders']));
        $query=$this->db->query("SELECT MONTHNAME(delivery_date_time) as month,YEAR(delivery_date_time) as year,sum(order_total) as order_count FROM orders o JOIN customer c on o.customer_id=c.customer_id join company co on co.company_id=c.company_id WHERE delivery_date_time>'".date("Y-m-d",strtotime('first day of this month last year'))."' GROUP BY year,month");
		$data['company_order']=$query->result();

     
// 	echo "<pre>";print_r($query->result());exit;
    			$this->load->view('general/header');
    			$this->load->view('orders/dash',$data);
    			$this->load->view('general/footer');
		    
		    }
			
		}
		else redirect('general/index');
	}
	
	
	
	public function order_history($date_from='',$date_to='',$order_date='',$company=0,$dept=0,$customer=0,$sort_order='',$order_no ='',$location=0)
	{
// 	  ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
        // echo $this->session->userdata('branch_id'); exit;

	     if(!empty($this->session->userdata('username')))
		{
			$params=array();
			if($date_from!=''&&$date_from!='unset')
				$params['date_from']=$date_from;
				
			if($date_to!=''&&$date_to!='unset')
				$params['date_to']=$date_to;
		
			if($order_date!=''&& $order_date!='unset')
				$params['order_date']=$order_date;	
				
			if($company!=0)
				$params['company']=$company;
				
			if($dept!=0)
				$params['department']=$dept;	
			if($customer!=0)
				$params['customer']=$customer;
				if($location!=0)
				$params['location']=$location;
			if($sort_order!='')
				$params['sort_order']=$sort_order;
				
				if($order_no!='')
				$params['order_no']=$order_no;
			$this->load->model('general_model');
	        $data['backend_orders']=$this->orders_model->fetch_order_history($params,'future_order');
			if($company!=0){
	       	$data['orders'] = json_decode(json_encode($data['backend_orders']), True);
	       	}else{
	       	$data['frontend_orders']=$this->orders_model->getOrders($params,'future_order');
		    $data['orders'] = array_merge($data['backend_orders'],$data['frontend_orders']);
		    $data['orders']  = json_decode(json_encode($data['orders']), True);
	       		}
	$keys = array_column($data['orders'], 'order_id');
       $userId = $this->session->userdata('branch_id');
       
      
       
       if($sort_order =='' || $sort_order == 3 ){
       
        foreach ($data['orders'] as $key => $part) {
             $sort[$key] = $part['delivery_date_time'];
              }
              array_multisort($sort, SORT_ASC, $data['orders']);
		}

        //   if($sort_order !='' && $sort_order == 0){
             
            
        //   foreach ($data['orders'] as $key => $part) {
        //      $sort[$key] = strtotime($part['delivery_date_time']);
        //       }
        //       array_multisort($sort, SORT_ASC, $data['orders']);
        //         }
        //   if($sort_order == 1){
              
        //   foreach ($data['orders'] as $key => $part) {
        //       $sort[$key] = strtotime($part['delivery_date_time']);
        //       }
        //       array_multisort($sort, SORT_DESC, $data['orders']);
  
 
        //       }
        //   if($sort_order == 2){
              
        //   foreach ($data['orders'] as $key => $part) {
        //      $sort[$key] = $part['delivery_date_time'];
        //       }
        //       array_multisort($sort, SORT_ASC, $data['orders']);
  
 
        //       }  
              
              
       
// convert array to object not required but as used on view file so....
       
      $data['orders'] = json_decode(json_encode($data['orders']));

	
			$data['customers']= $this->general_model->fetch_customers();
			$data['users' ]= $this->orders_model->fetch_all_user();
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			
		
			
			$this->load->view('general/header');
			$this->load->view('orders/order_history',$data);
			$this->load->view('general/footer');	
			
		}
		else redirect('general/index');
	}
	

	
	
	
	public function past_orders($date_from='',$date_to='',$order_date='',$company=0,$dept =0,$customer=0,$sort_order=0,$order_no ='',$location=0)
	{
		if(!empty($this->session->userdata('username')))
		{
			$params=array();
			
			if($order_date!=''&& $order_date!='unset')
				$params['order_date']=$order_date;
				
			if($date_from!=''&&$date_from!='unset')
				$params['date_from']=$date_from;
			if($date_to!=''&&$date_to!='unset')
				$params['date_to']=$date_to;
			if($company!=0)
				$params['company']=$company;
			if($dept!=0)
				$params['department']=$dept;
			if($customer!=0)
				$params['customer']=$customer;
			if($sort_order!='')
				$params['sort_order']=$sort_order;
				if($location!=0)
				$params['location']=$location;
				
				if($order_no!='')
				$params['order_no']=$order_no;
				
			$this->load->model('general_model');
				
				
			$data['backend_orders']=$this->orders_model->fetch_order_history($params,'past_orders');
			

		
	       		if($company!=0){
	       		    
	       		    $data['orders'] = json_decode(json_encode($data['backend_orders']), True);
	       		    
	       		}else{
	       		    
	       		  $data['frontend_orders']=$this->orders_model->getOrders($params,'past_orders');
			
		          $data['orders'] = array_merge($data['backend_orders'],$data['frontend_orders']);
		          
		          $data['orders']  = json_decode(json_encode($data['orders']), True);
	       		    
	       		}
		

       $keys = array_column($data['orders'], 'order_id');
       $userId = $this->session->userdata('branch_id');
       if($sort_order =='' || $sort_order == 3 ){
       
        foreach ($data['orders'] as $key => $part) {
             $sort[$key] = $part['delivery_date_time'];
              }
              array_multisort($sort, SORT_DESC, $data['orders']);
		}

          if($sort_order !='' && $sort_order == 0){
             
            
           foreach ($data['orders'] as $key => $part) {
             $sort[$key] = strtotime($part['delivery_date']);
              }
              array_multisort($sort, SORT_ASC, $data['orders']);
                }
          if($sort_order == 1){
              
           foreach ($data['orders'] as $key => $part) {
               
            $sort[$key] = strtotime($part['delivery_date']);
       
              }
              array_multisort($sort, SORT_DESC, $data['orders']);
  
 
              }
          if($sort_order == 2){
              
           foreach ($data['orders'] as $key => $part) {
             $sort[$key] = $part['order_id'];
              }
              array_multisort($sort, SORT_ASC, $data['orders']);
  
 
              }  
      
      // convert array to object not required but as used on view file so....
       
       $data['orders'] = json_decode(json_encode($data['orders']));
       
       if(!empty($params)){
           
          $data['paid_tab']  = $data['orders'][0]->order_status;
       }
      
       
      
			$data['customers']=$this->general_model->fetch_customers();
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			
			$this->load->view('general/header');
			$this->load->view('orders/past_orders',$data);
			$this->load->view('general/footer');			
		}
		else redirect('general/index');
	}
	
	
	
	
	
		public function view_quote($order_id)
	{
	    
	    $order_infoo =$this->orders_model->fetch_quote_info($order_id)[0];
		$data['order_info']= $order_infoo;
      	$user_info = $this->orders_model->getUserInfo($order_infoo->user_id);
		$data['company_name'] = $order_infoo->company_name;
		$data['company_abn'] = $order_infoo->company_abn;

	
		if($data['order_info']->postcode!=0){
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		} else {
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);

		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		}
		
		$auth=sha1($data['order_info']->firstname."|".$data['order_info']->lastname."|".$data['order_info']->order_id."|".$data['order_info']->order_total);
        $data['header'] = '';
		$data['fingerprint']=$auth;
		$this->load->view('general/header');
		$this->load->view('orders/view_quote',$data); 
		$this->load->view('general/footer');
		
	   
	}
	
	public function view_order($order_id,$isProduction=false)
	{  

	    $ofrom = $this->input->get('ofrom', TRUE);
	     $data['ofrom'] = $ofrom;
	    if($ofrom == 'frontend'){
	        
	        if (isset($order_id)) {
	            
			$data['order_info'] = $this->orders_model->getOrder($order_id);
			
		     }
		   
	         $data['order_products'] = array();

			$products = $this->orders_model->getOrderProducts($order_id);
			
		   $order_option_val =  array();
           $ar = array();
			foreach ($products as $product) {
			    
			   
			    
			       $order_prod_descr = 	$this->orders_model->getOrderProductsDescrption($product->product_id);
			   
			       $prod_cat_id = $this->orders_model->getProductCategory($product->product_id);
			    
			    	$order_option_values = 	$this->orders_model->getOrderOptions($order_id, $product->order_product_id);
			    	
			    	$order_option_values  = json_decode(json_encode($order_option_values), True);
			    	
			    
			    $i =0;
			    if(!empty($order_option_values)) {
				foreach ($order_option_values as $order_option_value) {
				    $ar[] =  $this->orders_model->getOrderOptions_value($order_option_value['product_option_id'], $order_option_value['product_option_value_id']);
				    
				    $ar  = json_decode(json_encode($ar), True);
				$order_option_values[$i]['price'] = (isset($ar[0][0]['price']) ? $ar[0][0]['price'] : '');
				unset($ar);
				  $i++;
				}
				}
				
				//convert array back to stdclass obj 
		
		$order_option_values  = json_decode(json_encode($order_option_values));

     $order_prod_descr  = json_decode(json_encode($order_prod_descr), True);
			    
				$data['order_products'][] = array(
					'product_id' => (isset($product->product_id) ? $product->product_id : ''),
					'name'       => (isset($product->name) ? $product->name : ''),
					'model'      => (isset($product->model) ? $product->model : ''),
					'descr'     =>  $order_prod_descr,
					'option'     => $order_option_values,
					'quantity'   => (isset($product->quantity) ? $product->quantity : ''),
					'price'      => (isset($product->price) ? $product->price : ''),
					'total'      => (isset($product->total) ? $product->total : ''),
					'reward'     => (isset($product->reward) ? $product->reward : ''),
					'cat_id'     => (isset($prod_cat_id[0]->category_id) ? $prod_cat_id[0]->category_id : '' ),
					'addons'     =>''
				);
				}



	       $order_totals = $this->orders_model->getOrderTotals($order_id);
	
	
			foreach ($order_totals as $order_total) {
				$data['order_totals'][] = array(
					'title' => $order_total->title,
					'text'  => $order_total->value
				);
			}
	        
	      
	   
		
	    $auth=sha1($data['order_info'][0]->firstname."|".$data['order_info'][0]->lastname."|".$data['order_info'][0]->order_id."|".$data['order_info'][0]->total);
		$data['fingerprint']=$auth;
		$this->load->view('general/header');
		if($isProduction){
		$this->load->view('orders/view_frontend_production_order',$data);    
		}else{
	  $this->load->view('orders/view_frontend_order',$data);	    
		}
		
		$this->load->view('general/footer');
	        
	        
	    }else{
	    
	    
		$order_infoo =$this->orders_model->fetch_order_info($order_id)[0];
// 		echo "<pre>"; print_r($order_infoo); exit;
		$data['order_info']= $order_infoo;
      	$user_info = $this->orders_model->getUserInfo($order_infoo->user_id);
		$data['company_name'] = $order_infoo->company_name;
		$data['company_abn'] = $order_infoo->company_abn;

	
		if($data['order_info']->postcode!=0){
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		} else {
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);

		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		}
		$data['header'] = '';
		$auth=sha1($data['order_info']->customer_order_name."|".$data['order_info']->customer_order_name."|".$data['order_info']->order_id."|".$data['order_info']->order_total);
		$data['fingerprint']=$auth;
		$this->load->view('general/header');
		if($isProduction){
		$this->load->view('orders/view_production_order',$data);    
		}else{
	  	$this->load->view('orders/view_order',$data);    
		}
	
		$this->load->view('general/footer');
		
	    }
	}
	
public function get_dept($company_id){
   $this->load->model('general_model');
   
   	$departments =$this->general_model->fetch_departments($company_id);
   	
   	$data  = json_encode($departments);
   	
   	echo $data;
				
    
}

		
	public function active_coupons()
	{
		if(!empty($this->session->userdata('username')))
		{
			$data['coupons']=$this->orders_model->fetch_active_coupons();
			$data['archivedcoupons']=$this->orders_model->fetch_archived_coupons();
			$data['title']="Active Coupons";
			$this->load->view('general/header');
			$this->load->view('general/coupons',$data);
			$this->load->view('general/footer');	
		}
		else redirect('general/index');
	}
	
	public function archive_coupon($coupon_id)
	{
		if(!empty($this->session->userdata('username')))
		{
			$this->orders_model->archive_coupon($coupon_id);
			redirect('orders/active_coupons');
		}
		else redirect('general/index');
	}
	public function activate_coupon($coupon_id)
	{
		if(!empty($this->session->userdata('username')))
		{
			$this->orders_model->activate_coupon($coupon_id);
			redirect('orders/active_coupons');
		}
		else redirect('general/index');
	}

	
	
// 	Quote
	public function new_quote($company='',$customer='',$phone='',$email='',$cost_centre='',$delivery_date='',$delivery_notes='',$shipping_method='',$delivery_address='',$pickup_location='',$delivery_fee='')
	{
		
		if(!empty($this->session->userdata('username')))
		{
			$data=array(
				'pre_company'=>$company,
				'pre_customer'=>$customer,
				'pre_phone'=>$phone,
				'pre_email'=>$email,
				'pre_cost_centre'=>$cost_centre,
				'pre_delivery_date'=>$delivery_date,
				'pre_delivery_notes'=>$delivery_notes,
				'pre_shipping_method'=>$shipping_method,
				'pre_delivery_address'=>$delivery_address,
				'pre_pickup_location'=>$pickup_location,
				'pre_delivery_fee'=>$delivery_fee
			);
			$this->load->model('general_model');
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			$backendCustomers=$this->general_model->fetch_customers();
			$frontendCustomers=$this->general_model->fetchAllFrontendCustomers();
			$data['customers']= array_merge($backendCustomers,$frontendCustomers);
		
			$data['users' ]= $this->orders_model->fetch_all_user();
		
			$data['stores']=$this->general_model->fetch_pickup_stores();
			$this->load->view('general/header');
			$this->load->view('orders/new_quote',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function new_quote_save()
	{
		if(!empty($this->session->userdata('username')))
		{
		     
		    if($_POST['customer_from'] == 'frontend'){
		        $customerDetails=$this->orders_model->getFrontendCustomers($_POST['customer_id']);
		    }else{
		        $customerDetails=$this->orders_model->getCustomerFromCustomerId($_POST['customer_id']);
		    }
		     
			$data['company']=htmlspecialchars($_POST['company_id']);
			 if(isset($_POST['location_id']) && $_POST['location_id'] !=''){
	       	$data['location_id']=$_POST['location_id'];
	        }else{
	       	$data['location_id']=$this->session->userdata('user_id');
	        }
			$data['customer']=htmlspecialchars($_POST['customer_id']);
			$data['accounts_email']=htmlspecialchars($_POST['accounts_email']);
			$data['customer_order_name']=htmlspecialchars($customerDetails[0]->firstname." ".$customerDetails[0]->lastname);
			$data['customer_from']=empty($customerDetails[0]->customer_from)? '' : htmlspecialchars($customerDetails[0]->customer_from);
			$data['customer_order_phone']=empty($_POST['phone'])?'null':htmlspecialchars($_POST['phone']);
			$data['customer_order_email']=empty($_POST['email'])?'null':htmlspecialchars($_POST['email']);
			$data['delivery_contact']=empty($_POST['delivery_contact'])?'null':htmlspecialchars($_POST['delivery_contact']);
			$data['phone']=empty($_POST['phone'])?'null':htmlspecialchars($_POST['phone']);
			$data['email']=empty($_POST['email'])?'null':htmlspecialchars($_POST['email']);
			$data['delivery_date']=empty($_POST['delivery_date']." ".$_POST['delivery_time'])?'null':$_POST['delivery_date']." ".$_POST['delivery_time'];
			$data['delivery_notes']=empty($_POST['delivery_notes'])?'null':htmlspecialchars($_POST['delivery_notes']);
			$data['shipping_method']=empty($_POST['shipping_method'])?'null':htmlspecialchars($_POST['shipping_method']);
			
			if(!empty($_POST['customer_pickup_address'])){
			   $data['delivery_address'] = htmlspecialchars($_POST['customer_pickup_address']);
			}else{
			    $data['delivery_address'] = htmlspecialchars($_POST['delivery_address']);
			}
			$data['pickup_location']=empty($_POST['pickup_location'])?'null':htmlspecialchars($_POST['pickup_location']);
			$data['delivery_fee']=empty($_POST['delivery_fee'])?0:$_POST['delivery_fee'];
		

			//First 20 products that aren't blank and don't start with a '*'
			$this->load->model('general_model');
			$data['products']=$this->general_model->fetch_products(1);
			$data['page']=1;
			$data['max_page']=$this->general_model->fetch_max_pages('product');
			$data['categories']=$this->general_model->fetch_categories();
			$this->load->view('general/header');
			$this->load->view('orders/new_quote_products',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	
	public function new_quote_products()
	{
	    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
		 
	   if(isset($_POST['location_id']) && $_POST['location_id'] !=''){
	       	$data['user_id']=$_POST['location_id'];
	   }else{
	       	$data['user_id']=$this->session->userdata('user_id');
	   }
	
	   
		$data['company']=$_POST['company'];
		$data['customer']=$_POST['customer'];
		$data['customer_from']=$_POST['customer_from'];
		$data['phone']=$_POST['phone'];
		$data['email']=$_POST['email'];
		
		$data['customer_order_name']=$_POST['customer_order_name'];
		$data['accounts_email']=$_POST['accounts_email'];
		$data['customer_order_phone']=$_POST['customer_order_phone'];
		$data['customer_order_email']=$_POST['customer_order_email'];
		$data['delivery_contact']=$_POST['delivery_contact'];
		
		
		$data['delivery_date_time']=$_POST['delivery_date_time'];
		$data['delivery_notes']=$_POST['delivery_notes'];
		$data['shipping_method']=$_POST['shipping_method'];
		$data['delivery_fee']=$_POST['delivery_fee']; 
	
		$data['coupon']=empty($_POST['coupon_code'])?'null':$_POST['coupon_code'];
		
		$data['order_comments']=empty($_POST['order_comments'])?'null':$_POST['order_comments'];
		
		
		$data['standing_order']=empty($_POST['standing_order'])?0:1;
		if(!empty($_POST['option'])){
			$data['option']=$_POST['option'];
		}
		
		
		if($data['shipping_method']==1){
			$data['delivery_address']=$_POST['delivery_address'];
		}
		else{
			$data['pickup_location']=$_POST['pickup_location'];
			
			$data['delivery_address']=$_POST['delivery_address'];
		
		}
	
	
		if(!empty($_POST['qty'])) $data['products']=$_POST['qty'];
		else $data['products']=null;
		if(!empty($_POST['order_product_comment'])) $data['order_product_comment']=$_POST['order_product_comment'];
		 else $data['order_product_comment']=null;

		$order_id=$this->orders_model->new_quote($data);
	
     	redirect('orders/quote_history');	
	
// 		$this->resend_mail($order_id);
	
	}
	public function quote_history($date_from='',$date_to='',$order_date='',$company=0,$dept=0,$customer=0,$quote_status='all',$sort_order='',$order_no ='',$location=0)
	{
	   
	    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
		if(!empty($this->session->userdata('username')))
		{
			$params=array();
			if($date_from!=''&&$date_from!='unset')
				$params['date_from']=$date_from;
				
			if($date_to!=''&&$date_to!='unset')
				$params['date_to']=$date_to;
		
			if($order_date!=''&& $order_date!='unset')
				$params['order_date']=$order_date;	
				
			if($company!=0)
				$params['company']=$company;
				
			if($dept!=0)
				$params['department']=$dept;	
			if($customer!=0)
				$params['customer']=$customer;
				
			if($quote_status!='all')
				$params['status']=$quote_status;
				
			if($location!=0)
				$params['location']=$location;
			if($sort_order!='')
				$params['sort_order']=$sort_order;
				
				if($order_no!='')
				$params['order_no']=$order_no;
			$this->load->model('general_model');
	        $AllQuotes=$this->orders_model->fetch_quote_history($params);
	      
	        $data['orders'] = json_decode(json_encode($AllQuotes), true);
	     
		
	  $keys = array_column($data['orders'], 'order_id');
       $userId = $this->session->userdata('branch_id');
       
       
       
             foreach ($data['orders'] as $key => $part) {
             $sort[$key] = strtotime((isset($part['delivery_date']) ? $part['delivery_date'] : ''));
              }
              if(!empty($sort)){
                array_multisort($sort, SORT_ASC, $data['orders']);
              }
          
         
              
              
       
// convert array to object not required but as used on view file so....
       
            $data['orders'] = json_decode(json_encode($data['orders']));

	
			$data['customers']= $this->general_model->fetch_customers();
			$data['users' ]= $this->orders_model->fetch_all_user();
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			
		    
			$this->load->view('general/header');
			$this->load->view('orders/quote_history',$data);
			$this->load->view('general/footer');	
			
		}
		else redirect('general/index');
	}
	public function edit_quote($order_id,$ostatus='')
	{
	    
	    $ofrom = $this->input->get('ofrom', TRUE);
	     if($ofrom =='frontend'){
	       
	       $this->load->model('general_model');
	       $data['order_info'] = $this->orders_model->getOrder($order_id);
	       $data['ostatus']=$ostatus;
	       
	       $data['products']=$this->general_model->fetch_products(1);
	       //echo "<pre>";
	       //print_r($data['order_info']);
	       //exit;
	     
    	     $data['page']=1;
    		    $data['max_page']=$this->general_model->fetch_max_pages('product');
    // 		$data['categories']=$this->general_model->fetch_categories();
    		$this->load->view('general/header');
    		$this->load->view('orders/edit_frontend_order',$data);
    		$this->load->view('general/footer');
    	       
    	       
    	   }else{
    		$data['order_product_options']=$this->orders_model->fetch_all_op_details($order_id);
    		$data['order_info']=$this->orders_model->fetch_quote_info($order_id)[0];
    
    		
    		$data['delivery_date']=$data['order_info']->delivery_date;
    		$this->load->model('general_model');
    		$data['products']=$this->general_model->fetch_products(1);
    		$data['ostatus']= $ostatus;
    
    		$data['page']=1;
    		$data['max_page']=$this->general_model->fetch_max_pages('product');
    		$data['categories']=$this->general_model->fetch_categories();
    		$this->load->view('general/header');
    		$this->load->view('orders/edit_quote',$data);
    		$this->load->view('general/footer');
    		
    	}   
	}
	public function edit_quote_process($order_id)
	{
	    $qty_comment = array();
	    
	    if(!empty($_POST['qty'])){
	        
	        foreach($_POST['qty'] as $prod=>$qty){
				 $qty_comment[$prod]['qty'] = $qty;
				 
			}
	        
	        
	    }
	    
	    
	    if(!empty($_POST['order_product_comment'])){
	        
	        foreach($_POST['order_product_comment'] as $prod=>$val){
				 $qty_comment[$prod]['order_product_comment'] = $val;
				 
			}
	            }
	    
	    
	    
		if(!empty($_POST['delete_option'])){
			foreach($_POST['delete_option'] as $option){
				$this->orders_model->delete_option_from_order(explode("_",$option)[1]);
			}
		}
		
		if(!empty($_POST['delete'])){
			foreach($_POST['delete'] as $product){
				$this->orders_model->delete_product_from_order($product);
			}
		}
		
		
		if(!empty($_POST['existing_qty'])){
			foreach($_POST['existing_qty'] as $product=>$qty){
				$this->orders_model->update_product_quantities($product,$qty);
			}
		}
		
		
			if(isset($_POST['existing_order_product_comment']) && !empty($_POST['existing_order_product_comment'])){
			    
			foreach($_POST['existing_order_product_comment'] as $product_com=>$comment){
			    
			    if(!empty($comment)){
			       
			      	$this->orders_model->update_product_comment($product_com,$comment);  
			    }
			
			 }
		      }
		 
		if(!empty($_POST['existing_option'])){
			foreach($_POST['existing_option'] as $option=>$qty){
				$this->orders_model->update_option_quantities($option,$qty);
			}
		}
	
	
		if(!empty($_POST['option'])){
		    
			foreach($_POST['option'] as $option=>$qty){
			   // echo $option;
				$this->orders_model->add_option_to_order($order_id,$option,$qty); 
				
			}
		}
		
		
			if(!empty($qty_comment)){
			foreach($qty_comment as $key=>$val){
			  
				$this->orders_model->add_product_to_order($order_id,$key,$val['qty'],$val['order_product_comment']);
			}
		}

		//Recalculate Total
		$this->orders_model->recalculate_total($order_id,'quote');
		
		$cust_id =empty($_POST['cust_id'])?'null':$_POST['cust_id'];
		
		$customer_order_name =empty($_POST['customer_order_name'])?'null':$_POST['customer_order_name'];
		$accounts_email =empty($_POST['accounts_email'])?'null':$_POST['accounts_email'];
		
		$customer_order_email = empty($_POST['customer_order_email'])?'null':$_POST['customer_order_email'];
		
		$customer_order_telephone =empty($_POST['customer_order_telephone'])?'null':$_POST['customer_order_telephone'];
		
		$delivery_telephone =empty($_POST['delivery_telephone'])?'null':$_POST['delivery_telephone'];
		
		$delivery_addr =empty($_POST['delivery_addr'])?'null':$_POST['delivery_addr'];
		
		$delivery_addr =empty($_POST['delivery_addr'])?'null':$_POST['delivery_addr'];

		$company_id =empty($_POST['comp_addr_id'])?'null':$_POST['comp_addr_id'];
		
		$company_name =empty($_POST['company_name'])?'null':$_POST['company_name'];
		
		$comp_addr =empty($_POST['comp_addr'])?'null':$_POST['comp_addr'];
		
		$department_name =empty($_POST['department_name'])?'null':$_POST['department_name'];
	
		$coupon_code=empty($_POST['coupon_code'])?'null':$_POST['coupon_code'];
		$delivery_date=$_POST['delivery_date']." ".$_POST['delivery_time'];
		$delivery_notes=empty($_POST['delivery_notes'])?'null':$_POST['delivery_notes'];
		$order_comments=empty($_POST['order_comments'])?'null':$_POST['order_comments'];
		$cost_centre=empty($_POST['cost_centre'])?'null':$_POST['cost_centre'];
		$delivery_fee=empty($_POST['delivery_fee'])?0:$_POST['delivery_fee'];
		$standing_order=empty($_POST['standing_order'])?0:1;
		
		
		$this->orders_model->update_quote_details($company_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_notes,$order_comments,$delivery_fee,$standing_order,$customer_order_name,$customer_order_email,$customer_order_telephone,$delivery_telephone,$delivery_addr,$comp_addr,$accounts_email);
		
// 		add_notification($order_id);
	
		redirect('orders/quote_history/');
	}
	public function delete_quote($order_id='',$referrer='',$ofrom='')
	{
	    
	       $referrer = $_POST['referrer'];
	   
	        $this->orders_model->delete_order($_POST['order_id'],$_POST['ofrom'], $_POST['cancel_comments'],'quote');
	    
		  
			redirect('orders/quote_history');
	}
	
	public function chefApprove($order_id)
	{
	       
	   $this->db->query("UPDATE orders SET updatedAfterApproved= 0 , date_modified = '".date("Y-m-d H:i:s",strtotime("now"))."' WHERE order_id=".$order_id);
     	echo "success";
	}
	
	public function chefApproveFrontend($order_id)
	{
	 $opencartdb = $this->load->database('opecart', TRUE); 
	 $queryUpdateApproved = "UPDATE oc_order SET updatedAfterApproved= 1 , date_modified = '".date("Y-m-d H:i:s",strtotime("now"))."' WHERE order_id=".$order_id;
     $opencartdb->query($queryUpdateApproved);
    
	echo "success";
	}
	public function convertToInvoice($order_id){
	    $quote = $this->orders_model->convertToInvoice($order_id);
	    redirect('orders/quote_history');
	}
	public function convertApprovedQuoteToInvoice($order_id){
	    $quote = $this->orders_model->convertToInvoice($order_id);
	     return true;
	}
	
// 	quote ends
	public function upload_order_image(){
	    
	    $order_id = $_POST['order_id'];
	   $data = [];
   
      $count = count($_FILES['hc_image']['name']);
    
      for($i=0;$i<$count;$i++){
    
        if(!empty($_FILES['hc_image']['name'][$i])){
    
          $_FILES['file']['name'] = $_FILES['hc_image']['name'][$i];
          $_FILES['file']['type'] = $_FILES['hc_image']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['hc_image']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['hc_image']['error'][$i];
          $_FILES['file']['size'] = $_FILES['hc_image']['size'][$i];
  
          $config['upload_path'] = './uploaded_filesHC/';
          $config['allowed_types'] = 'jpg|jpeg|png|gif';
          $config['max_size'] = '5000';
          $config['file_name'] = $_FILES['hc_image']['name'][$i];
   
          $this->load->library('upload',$config); 
    
          if($this->upload->do_upload('file')){
            $uploadData = $this->upload->data();
            $filename = $uploadData['file_name'];
            $result = $this->orders_model->save_order_image($order_id,$filename);
          $this->session->set_flashdata('msg', 'Image successfully uploaded for OrderId: '.$order_id);
          
          }else{
              $error = array('error' => $this->upload->display_errors());
               $this->session->set_flashdata('msg', 'Error: Failed to upload image for OrderId: '.$order_id);
          }
        }
   
      }
	  if($_POST['listing_type'] == 'viewOrder'){
       redirect('orders/order_history');
        }else{
      redirect('orders/past_orders');
       } 
	    
	    }
	public function uploadOrderImage($order_id){
	    $data['order_id'] = $order_id;
	    $this->load->view('general/header');
    		$this->load->view('orders/upload_order_image',$data);
    		$this->load->view('general/footer');
	}
	public function viewOrderImage($order_id){
	    $data['order_id'] = $order_id;
	    $data['orderImages'] = $this->orders_model->get_order_image($order_id);
	   // echo "<pre>";print_r($data['orderImages']);exit;
	    $this->load->view('general/header');
    		$this->load->view('orders/viewOrderImage',$data);
    		$this->load->view('general/footer');
	}
	public function new_order_customer_details($company='',$customer='',$phone='',$email='',$cost_centre='',$delivery_date='',$delivery_notes='',$shipping_method='',$delivery_address='',$pickup_location='',$delivery_fee='')
	{
		
		if(!empty($this->session->userdata('username')))
		{
			$data=array(
				'pre_company'=>$company,
				'pre_customer'=>$customer,
				'pre_phone'=>$phone,
				'pre_email'=>$email,
				'pre_cost_centre'=>$cost_centre,
				'pre_delivery_date'=>$delivery_date,
				'pre_delivery_notes'=>$delivery_notes,
				'pre_shipping_method'=>$shipping_method,
				'pre_delivery_address'=>$delivery_address,
				'pre_pickup_location'=>$pickup_location,
				'pre_delivery_fee'=>$delivery_fee
			);
			$this->load->model('general_model');
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			
		   
			
			$data['customers']=$this->general_model->fetch_customers();
			$data['users' ]= $this->orders_model->fetch_all_user();
		
			$data['stores']=$this->general_model->fetch_stores();
			$this->load->view('general/header');
			$this->load->view('orders/new_order_page',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function new_order()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$data['company']=htmlspecialchars($_POST['company_id']);
			$data['location_id']=htmlspecialchars($_POST['location_id']);
			$data['customer']=htmlspecialchars($_POST['customer_id']);
			$data['phone']=empty($_POST['phone'])?'null':htmlspecialchars($_POST['phone']);
			$data['email']=empty($_POST['email'])?'null':htmlspecialchars($_POST['email']);
			$data['cost_centre']=empty($_POST['cost_centre'])?'null':htmlspecialchars($_POST['cost_centre']);
			$data['delivery_date']=empty($_POST['delivery_date']." ".$_POST['delivery_time'])?'null':$_POST['delivery_date']." ".$_POST['delivery_time'];
			$data['delivery_notes']=empty($_POST['delivery_notes'])?'null':htmlspecialchars($_POST['delivery_notes']);
			
			$data['shipping_method']=empty($_POST['shipping_method'])?'null':htmlspecialchars($_POST['shipping_method']);
			
			if(!empty($_POST['customer_pickup_address'])){
			   $data['delivery_address'] = htmlspecialchars($_POST['customer_pickup_address']);
			    
			}else{
			    $data['delivery_address'] = htmlspecialchars($_POST['delivery_address']);
			    
			}
		
			$data['pickup_location']=empty($_POST['pickup_location'])?'null':htmlspecialchars($_POST['pickup_location']);
			
			$data['delivery_fee']=empty($_POST['delivery_fee'])?0:$_POST['delivery_fee'];
			
			
			//First 20 products that aren't blank and don't start with a '*'
			$this->load->model('general_model');
			$data['products']=$this->general_model->fetch_products(1);
			$data['page']=1;
			$data['max_page']=$this->general_model->fetch_max_pages('product');
			$data['categories']=$this->general_model->fetch_categories();
			$this->load->view('general/header');
			$this->load->view('orders/new_order_products',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function fetch_products_page($page)
	{
		$res=[];
		$res[0]='';
		$this->load->model('general_model');
		$max_page=$this->general_model->fetch_max_pages('product');
		$products=$this->general_model->fetch_products($page);
		if(!empty($products)){
			foreach($products as $product){
				$res[0].="<input type=\"hidden\" id=\"price-".$product->product_id."\" value=\"".$product->product_price."\">";
				if(!empty($product->heading)&&$heading!=$product->heading){
					$res[0].="<tr><td colspan=\"5\"><strong>".$product->heading."</strong></td></tr>";
				}
				$res[0].="<tr id=\"product-row-".$product->product_id."\" data-heading=\"".$product->heading."\">";
				$res[0].="<td>".$product->product_name."</td>";
				$res[0].="<td>".ucwords($product->category_name)."</td>";
				$res[0].="<td>$".number_format($product->product_price,2)."</td>";
				$res[0].="<td>";
				if(empty($product->options)){
					$res[0].="<input class=\"form-control\" type=\"text\" id=\"qty-".$product->product_id."\" placeholder=\"0\">";
				}
				else{
					$res[0].="<button type=\"button\" class=\"btn btn-primary\" onclick=\"open_modal(".$product->product_id.")\">Options</button>";
				}
				$res[0].="</td>";
				$res[0].="<td>";
				if(empty($product->options))
					$res[0].="<button type=\"button\" class=\"btn btn-info new-product-form\" id=\"new-product-".$product->product_id."\">Add</button>";
				$res[0].="</td>";
				$res[0].="</tr>";
				$heading=$product->heading;
			}
			$res[1]='';
			if($page!=1&&$page!=2){
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page-1)."\">Previous</a></li>";
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page-2)."\">".($page-2)."</a></li>";
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page-1)."\">".($page-1)."</a></li>";
			} else if($page!=1){
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page-1)."\">Previous</a></li>";
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page-1)."\">".($page-1)."</a></li>";
			} else {
				$res[1].="<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" disabled>Previous</a></li>";
			}
			$res[1].="<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">".$page."</a></li>";
			if($page!=$max_page&&$page!=$max_page-1){
				$res[1].="<li class=\"page_item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page+1)."\">".($page+1)."</a></li>";
				$res[1].="<li class=\"page_item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page+2)."\">".($page+2)."</a></li>";
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page+1)."\">Next</a></li>";
			} else if($page!=$max_page){
				$res[1].="<li class=\"page_item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page+1)."\">".($page+1)."</a></li>";
				$res[1].="<li class=\"page-item\"><a class=\"page-link\" href=\"".base_url()."index.php/orders/fetch_products_page/".($page+1)."\">Next</a></li>";
			} else {
				$res[1].="<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" disabled>Next</a></li>";
			}
		}
		echo json_encode($res);
	}
	public function new_order_products()
	{
	    
		 
	   if(isset($_POST['location_id']) && $_POST['location_id'] !=''){
	       	$data['user_id']=$_POST['location_id'];
	   }else{
	       	$data['user_id']=$_POST['user_id'];
	   }
	
	   
		$data['company']=$_POST['company'];
	
		$data['customer']=$_POST['customer'];
		$data['phone']=$_POST['phone'];
		$data['email']=$_POST['email'];
		$data['delivery_date']=$_POST['delivery_date'];
		$data['delivery_notes']=$_POST['delivery_notes'];
		$data['shipping_method']=$_POST['shipping_method'];
		$data['delivery_fee']=$_POST['delivery_fee']; 
	
		$data['coupon']=empty($_POST['coupon_code'])?'null':$_POST['coupon_code'];
		
		$data['order_comments']=empty($_POST['order_comments'])?'null':$_POST['order_comments'];
		
		
		$data['standing_order']=empty($_POST['standing_order'])?0:1;
		if(!empty($_POST['option'])){
			$data['option']=$_POST['option'];
		}
		
		
		
		if($data['shipping_method']==1){
			$data['delivery_address']=$_POST['delivery_address'];
		}
		else{
			$data['pickup_location']=$_POST['pickup_location'];
			
			$data['delivery_address']=$_POST['delivery_address'];
		
		}
		$data['cost_centre']=$_POST['cost_centre'];
	
		if(!empty($_POST['qty'])) $data['products']=$_POST['qty'];
		else $data['products']=null;
		
		
			if(!empty($_POST['order_product_comment'])) $data['order_product_comment']=$_POST['order_product_comment'];
		else $data['order_product_comment']=null;
		
	
		$order_id=$this->orders_model->new_order($data);
		
	redirect('orders/order_history');	
	
// 		$this->resend_mail($order_id);
	
	}
	public function edit_order($order_id,$ostatus='')
	{
	    
	    $ofrom = $this->input->get('ofrom', TRUE);
	     if($ofrom =='frontend'){
	       
	       $this->load->model('general_model');
	       $data['order_info'] = $this->orders_model->getOrder($order_id);
	       $data['ostatus']=$ostatus;
	       
	       $data['products']=$this->general_model->fetch_products(1);
	       //echo "<pre>";
	       //print_r($data['order_info']);
	       //exit;
	     
	     $data['page']=1;
		$data['max_page']=$this->general_model->fetch_max_pages('product');
// 		$data['categories']=$this->general_model->fetch_categories();
		$this->load->view('general/header');
		$this->load->view('orders/edit_frontend_order',$data);
		$this->load->view('general/footer');
	       
	       
	   }else{
		$data['order_product_options']=$this->orders_model->fetch_all_op_details($order_id);
		$data['order_info']=$this->orders_model->fetch_order_info($order_id)[0];

		$data['delivery_date']=$data['order_info']->delivery_date;
		$this->load->model('general_model');
		$data['products']=$this->general_model->fetch_products(1);
		$data['ostatus']= $ostatus;

		$data['page']=1;
		$data['max_page']=$this->general_model->fetch_max_pages('product');
		$data['categories']=$this->general_model->fetch_categories();
		$this->load->view('general/header');
		$this->load->view('orders/edit_order',$data);
		$this->load->view('general/footer');
		
	}
	}
	public function edit_fronteend_orders($order_id){
	   
	  $cust_id =empty($_POST['cust_id'])?'null':$_POST['cust_id'];
		
		$cust_firstname =empty($_POST['cust_firstname'])?'null':$_POST['cust_firstname'];
		
		$purchase_order_no =empty($_POST['purchase_order_no'])?'null':$_POST['purchase_order_no'];
		
		$cust_email = empty($_POST['cust_email'])?'null':$_POST['cust_email'];
		
		$cust_telephone =empty($_POST['cust_telephone'])?'null':$_POST['cust_telephone'];
		
		$delivery_addr = empty($_POST['delivery_addr'])?'null':$_POST['delivery_addr'];
		

	
		$coupon_code=empty($_POST['coupon_code'])?'null':$_POST['coupon_code'];
		$delivery_time= $_POST['delivery_time'];
		$delivery_date=$_POST['delivery_date'];
		$delivery_notes=empty($_POST['delivery_notes'])?'null':$_POST['delivery_notes'];
		$order_comments=empty($_POST['order_comments'])?'null':$_POST['order_comments'];
		$cost_centre=empty($_POST['cost_centre'])?'null':$_POST['cost_centre'];
		$delivery_fee=empty($_POST['delivery_fee'])?0:$_POST['delivery_fee'];
		
		$shipping_gate_number=empty($_POST['comp_addr'])?'null':$_POST['comp_addr'];
		$shipping_building_number=empty($_POST['shipping_building_number'])?'null':$_POST['shipping_building_number'];
		$shipping_department_name=empty($_POST['shipping_department_name'])?'null':$_POST['shipping_department_name'];
		$shipping_level_of_building=empty($_POST['shipping_level_of_building'])?'null':$_POST['shipping_level_of_building'];
		$shipping_room_number=empty($_POST['shipping_room_number'])?'null':$_POST['shipping_room_number'];
		$shipping_business_name=empty($_POST['shipping_business_name'])?'null':$_POST['shipping_business_name'];
		$shipping_street_number=empty($_POST['shipping_street_number'])?'null':$_POST['shipping_street_number'];
		$shipping_delivery_contact_name=empty($_POST['shipping_delivery_contact_name'])?'null':$_POST['shipping_delivery_contact_name'];
		$shipping_delivery_contact_number=empty($_POST['shipping_delivery_contact_number'])?'null':$_POST['shipping_delivery_contact_number'];
		
		
		
	 $this->orders_model->update_frontend_order_details($purchase_order_no,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_time,$delivery_notes,$order_comments,$cost_centre,$delivery_fee,$cust_firstname,$cust_email,$cust_telephone,$delivery_addr,$shipping_gate_number,$shipping_building_number,$shipping_department_name,$shipping_level_of_building,$shipping_room_number,$shipping_business_name,$shipping_street_number,$shipping_delivery_contact_name,$shipping_delivery_contact_number);
   
	    redirect('orders/view_order/'.$order_id."?ofrom=frontend");
	}
	public function edit_order_process($order_id)
	{
	    $qty_comment = array();
	    
	    if(!empty($_POST['qty'])){
	        foreach($_POST['qty'] as $prod=>$qty){
			$qty_comment[$prod]['qty'] = $qty;
			}
	    }
	    
	    
	    if(!empty($_POST['order_product_comment'])){
	        foreach($_POST['order_product_comment'] as $prod=>$val){
				 $qty_comment[$prod]['order_product_comment'] = $val;
			}
	            }
	    
	    
	    
		if(!empty($_POST['delete_option'])){
			foreach($_POST['delete_option'] as $option){
				$this->orders_model->delete_option_from_order(explode("_",$option)[1]);
			}
		}
		
		if(!empty($_POST['delete'])){
			foreach($_POST['delete'] as $product){
				$this->orders_model->delete_product_from_order($product);
			}
		}
		
		
		if(!empty($_POST['existing_qty'])){
			foreach($_POST['existing_qty'] as $product=>$qty){
				$this->orders_model->update_product_quantities($product,$qty);
			}
		}
		
		
			if(isset($_POST['existing_order_product_comment']) && !empty($_POST['existing_order_product_comment'])){
			    
			foreach($_POST['existing_order_product_comment'] as $product_com=>$comment){
			    
			    if(!empty($comment)){
			      	$this->orders_model->update_product_comment($product_com,$comment);  
			    }
			 }
		      }
		 
		if(!empty($_POST['existing_option'])){
			foreach($_POST['existing_option'] as $option=>$qty){
				$this->orders_model->update_option_quantities($option,$qty);
			}
		}
	
	
		if(!empty($_POST['option'])){
			foreach($_POST['option'] as $option=>$qty){
				$this->orders_model->add_option_to_order($order_id,$option,$qty); 
			}
		}
		
		
			if(!empty($qty_comment)){
			foreach($qty_comment as $key=>$val){
				$this->orders_model->add_product_to_order($order_id,$key,$val['qty'],$val['order_product_comment']);
			}
		}

		//Recalculate Total
		$this->orders_model->recalculate_total($order_id);
		
		$cust_id =empty($_POST['cust_id'])?'null':$_POST['cust_id'];
		
		$customer_order_name =empty($_POST['customer_order_name'])?'null':$_POST['customer_order_name'];
		
		$customer_order_email = empty($_POST['customer_order_email'])?'null':$_POST['customer_order_email'];
		
		$accounts_email = empty($_POST['accounts_email'])?'null':$_POST['accounts_email'];
		
		$customer_order_telephone =empty($_POST['customer_order_telephone'])?'null':$_POST['customer_order_telephone'];
		
		$delivery_telephone =empty($_POST['delivery_telephone'])?'null':$_POST['delivery_telephone'];
		
		$delivery_addr =empty($_POST['delivery_addr'])?'null':$_POST['delivery_addr'];
		
		$delivery_addr =empty($_POST['delivery_addr'])?'null':$_POST['delivery_addr'];

		$company_id =empty($_POST['comp_addr_id'])?'null':$_POST['comp_addr_id'];
		
		$company_name =empty($_POST['company_name'])?'null':$_POST['company_name'];
		
		$comp_addr =empty($_POST['comp_addr'])?'null':$_POST['comp_addr'];
		
		$department_name =empty($_POST['department_name'])?'null':$_POST['department_name'];
	
		$coupon_code=empty($_POST['coupon_code'])?'null':$_POST['coupon_code'];
		$delivery_date=$_POST['delivery_date']." ".$_POST['delivery_time'];
		$delivery_notes=empty($_POST['delivery_notes'])?'null':$_POST['delivery_notes'];
		$order_comments=empty($_POST['order_comments'])?'null':$_POST['order_comments'];
		$cost_centre=empty($_POST['cost_centre'])?'null':$_POST['cost_centre'];
		$delivery_fee=empty($_POST['delivery_fee'])?0:$_POST['delivery_fee'];
		$standing_order=empty($_POST['standing_order'])?0:1;
		
		$this->orders_model->update_order_details($_POST['ostatus'],$company_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_notes,$order_comments,$delivery_fee,$standing_order,$customer_order_name,$customer_order_email,$customer_order_telephone,$delivery_telephone,$delivery_addr,$comp_addr,$accounts_email);
		
// 		add_notification($order_id);
	
		redirect('orders/view_order/'.$order_id);
	}
	public function chnage_product_sort_order()
     	{
        	$i = 0;
        	foreach ($_POST['cart-existing-item'] as $value) {
     
        
        $this->db->query("UPDATE order_product SET sort_order=".$i." WHERE order_product_id=".$value);
         $i++;
      
         }
     	}
	
	public function RemoveBS($Str) {  
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {    
    $CharNo = ord($Char);
    if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £ 
    if ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;    
    }
  }  
  return $NewStr;
}


   function add_late_fee($orders,$latefee){
       ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
       $orders = explode(".",$orders);
     
       for($index = 0; $index < sizeof($orders); $index++){
          $orderDetailposted = explode("_",$orders[$index]);
           if($orderDetailposted[0] == 'backend'){
             
          $this->db->query("UPDATE orders SET late_fee=".$latefee." WHERE order_id=".$orderDetailposted[1]);     
           }else{
    $opencartdb = $this->load->database('opecart', TRUE); 
    
    $deletesql = "Delete  FROM `oc_order_total` WHERE order_id = ".$orderDetailposted[1]." And code='late_fee'";
	 $queryDelete=$opencartdb->query($deletesql);
	  
    $qyerrr = "INSERT INTO `oc_order_total` (`order_id`, `code`, `title`, `value`, `sort_order`) VALUES (".$orderDetailposted[1].", 'late_fee', 'Late Fee', ".$latefee.", '7')";
    $opencartdb->query($qyerrr); 
    
     $selectsql = "SELECT total FROM `oc_order` WHERE order_id = ".$orderDetailposted[1];
	 $queryCust=$opencartdb->query($selectsql);
 	$custResult=$queryCust->result();
 	
 	$selectsqlOT = "SELECT value FROM `oc_order_total` WHERE code='total' AND  order_id = ".$orderDetailposted[1];
	 $queryCustOT=$opencartdb->query($selectsqlOT);
 	$OTResult=$queryCustOT->result();
 	$finalOT = $OTResult[0]->value + $latefee;

    $finalTotal = $custResult[0]->total + $latefee;
   
    $queryUpdateApproved = "UPDATE oc_order SET total= ".$finalTotal.", updatedAfterApproved= 1 , date_modified = '".date("Y-m-d H:i:s",strtotime("now"))."' WHERE order_id=".$orderDetailposted[1];
     $opencartdb->query($queryUpdateApproved);
     
     $queryAddLateFeeInOT = "UPDATE oc_order_total SET value= ".$finalOT." WHERE code='total' AND order_id=".$orderDetailposted[1];
     $opencartdb->query($queryAddLateFeeInOT);
           }
       }
      echo "success";
      
   }
    function running_sheet($orders){
          
	   //  ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
	     
	  	$orders = explode(".",$orders);
	  	
		$reports_details = $this->orders_model->fetch_running_sheet($orders);
	
		$frontend_data = $this->orders_model->fetch_running_sheet_for_frontend_orders($orders);
			
			if(!empty($frontend_data)){
			    $reports_details  = json_decode(json_encode($reports_details), True);
			    $frontend_data  = json_decode(json_encode($frontend_data), True);
			    $reports_details = array_merge($reports_details,$frontend_data);
			    $reports_details  = json_decode(json_encode($reports_details));
			}
		

          $size = sizeof($reports_details);
          $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

          $sheet = $spreadsheet->getActiveSheet();
          $sheet->getStyle("A2:J2")->getFont()->setBold(true);
          $sheet->getStyle("D1")->getFont()->setBold(true);
          $sheet->getStyle("D1")->getFont()->setSize(20);
          $sheet->getStyle('A2:B9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('B2:B9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('C2:C9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('D2:D9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('E2:E9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('F2:H9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('H2:G9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('I2:I9999')->getAlignment()->setWrapText(true);
          $sheet->getStyle('J2:J9999')->getAlignment()->setWrapText(true);
          
          $sheet->getColumnDimensionByColumn('A1')->setWidth(70);
          $sheet->getColumnDimension('B')->setWidth(30);
          $sheet->getColumnDimension('C')->setWidth(30);
          $sheet->getColumnDimension('D')->setWidth(30);
          $sheet->getColumnDimension('E')->setWidth(30);
         
          $sheet->getColumnDimension('F')->setWidth(30);
          $sheet->getColumnDimension('G')->setWidth(30);
          $sheet->getColumnDimension('I')->setWidth(30);
          $sheet->getColumnDimension('J')->setWidth(30);
          //set heading of excel
       $sheet->setCellValue('D1', 'Running sheet HC');
       $sheet->setCellValue('A2', 'Order ID'); $sheet->setCellValue('B2', 'Delivery Date');  $sheet->setCellValue('C2', 'Delivery Adrress'); $sheet->setCellValue('D2', 'Delivery Notes'); 
       $sheet->setCellValue('E2', 'Customer Information'); $sheet->setCellValue('F2', 'Product'); 
       $sheet->setCellValue('G2', 'Options/ Description'); $sheet->setCellValue('H2', 'Quantity');  $sheet->setCellValue('I2', 'Product comments');   $sheet->setCellValue('J2', 'Order Comments'); 
      
        $symbol = "$";
        $count = 0;
        $y = '';

        for($x = 3; $count < $size; $x++){
      
          if(isset($reports_details[$count]->delivery_date)){
              $deliverydate =  date('d-m-Y h:i A', strtotime($reports_details[$count]->delivery_date)); 
          }else{
              $deliverydate = '';
          }
       
        if(isset($reports_details[$count]->pickup_delivery_notes)){
            $pickup_delivery_notes = preg_replace('/\s+/', '', $reports_details[$count]->pickup_delivery_notes);
        }else{
          $pickup_delivery_notes ='';  
        }
        if(isset($reports_details[$count]->delivery_address)){
            $delivery_address =  $reports_details[$count]->delivery_address;
        }else{
          $delivery_address = ''; 
        }
         if(isset($reports_details[$count]->customer_company_name)){
          $customer_company_name = $reports_details[$count]->customer_company_name;   
         }else{
          $customer_company_name ='';
         }
         
         if(isset($reports_details[$count]->telephone)){
             $telephone = $reports_details[$count]->telephone;
         }else{
             $telephone ='';
         }
         
        
        $sheet->setCellValue('A'.$x, $reports_details[$count]->order_id);
        $sheet->setCellValue('B'.$x, $deliverydate);
        $sheet->setCellValue('c'.$x, $delivery_address);
        $sheet->setCellValue('D'.$x, $pickup_delivery_notes);
        $sheet->setCellValue('E'.$x, $reports_details[$count]->firstname.' '.$reports_details[$count]->lastname.','.$customer_company_name.' , '.$telephone);
         
        if(!empty($reports_details[$count]->products)){
             
            // echo "=============".$reports_details[$count]->order_id;
            
            // echo "<pre>";
            // print_r($reports_details[$count]->products);
            // exit;
	         $loop_count = 0;
	   
			foreach($reports_details[$count]->products as $product){
			      $product_count = $x;
			 if(isset($product->product_name)){
				     $prd_name = $product->product_name;
					}else{
					$prd_name = $product->name;
						}
						
				
				    $sheet->setCellValue('F'.$x, $prd_name);  
				    
				    if(!empty($product->options)){ 
				        
							foreach($product->options as $option){
						
							    if(isset($option->option_quantity)){
							        $opt_qty = $option->option_quantity;
							    }else{
							        $opt_qty = $option->option_qty; 
							    }
							    if(isset($option->option_name)){
							        $option_name = $option->option_name."( ".$option->option_value." )";
							    }else{
							        $option_name = $option->name."( ".$option->value." )";
							    }
							    
							    $sheet->setCellValue('G'.$x, $option_name);
							    $sheet->setCellValue('H'.$x, $opt_qty);
								$x++;
							    }
				             }
						if(isset($product->product_description) && !empty($product->product_description)){
						  $sheet->setCellValue('G'.$x, $product->product_description);
						    $x++;
					      }
					    
						if(isset($product->product_desc_1) && !empty($product->product_desc_1)){
					
					     $sheet->setCellValue('G'.$x, $product->product_desc_1);
						 $x++;
						if(!empty($product->product_desc_2)){
			
						 $sheet->setCellValue('G'.$x, $product->product_desc_2);
						    $x++;
						}
						
						if(!empty($product->product_desc_3)){
		
						 $sheet->setCellValue('G'.$x, $product->product_desc_3);
						    $x++;
						}
						
						
						if(!empty($product->product_desc_4)){
				
						 $sheet->setCellValue('G'.$x, $product->product_desc_4);
						    $x++;
						}
					
						if(!empty($product->product_desc_5)){
					
							 $sheet->setCellValue('G'.$x, $product->product_desc_5);
						    $x++;
						}
					
						}
						else if(isset($product->desc) && !empty($product->desc)){
					
						   if(!empty($product->desc[0]->desc_1)){
							$sheet->setCellValue('G'.$x, $product->desc_1);
						    $x++;
						   }
						if(!empty($product->desc[0]->desc_2)){
							$sheet->setCellValue('G'.$x, $product->desc_2);
						    $x++;
						   }
						if(!empty($product->desc[0]->desc_3)){
							$sheet->setCellValue('G'.$x, $product->desc_3);
						    $x++;
						   }
						if(!empty($product->desc[0]->desc_4)){
						$sheet->setCellValue('G'.$x, $product->desc_4);
						 $x++;
						   }
					   if(!empty($product->desc[0]->desc_5)){
						$sheet->setCellValue('G'.$y, $product->desc_5);
						 $x++;
						   }
						}
						
						if(isset($product->order_product_comment)){
	                     $sheet->setCellValue('I'.$product_count, $product->order_product_comment);
	                    }
	                 
						if(empty($product->options) && empty($product->product_description) && empty($product->product_desc_1)){
						    $sheet->setCellValue('G'.$product_count, '');
						   $sheet->setCellValue('H'.$product_count, $product->quantity);
						  $x++;
						}elseif(empty($product->options) && (!empty($product->product_description) || !empty($product->product_desc_1))){
						   
						   $sheet->setCellValue('H'.$product_count, $product->quantity);
						   
						}
					
					  }
	                }
	                
	               
	      
	         if(isset($reports_details[$count]->order_comments)){
	       //   $own_index = $product_count-1;
	          $sheet->setCellValue('J'.$product_count, $reports_details[$count]->order_comments);
	         }
	         
	           
	         
	       //  $styleArray = array(
        //     'borders' => array(
        //      'outline' => array(
        //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //     'color' => array('argb' => '663300'),
        //      ),
        //      ),
        //      'fill' => array(
        //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //         'startColor' => array('argb' => '404040')
        //     )
        //      );
             
            $count++;
            //   $x = $x+1;
            // $sheet ->getStyle('A'.$x.':J'.$x)->applyFromArray($styleArray);
                }
           
         
        $writer = new Xlsx($spreadsheet); 
        $filename = 'Running sheet HC';
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
         $writer->save('php://output');
        exit;

	    
	}
	
		public function print_quote($order_id,$auth_token='')
	{
	      $data['user_id']= $this->session->userdata('user_id');
	  
		    
		
		$order_infoo =$this->orders_model->fetch_quote_info($order_id)[0];
		$data['order_info']= $order_infoo;
      	$user_info = $this->orders_model->getUserInfo($order_infoo->user_id);
		$data['company_name'] = $user_info[0]->company_name;
		$data['company_abn'] = $user_info[0]->abn;
		
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		
	
		//Fingerprinting auth
		//sha1 hash of firstname|lastname|order_id|total
		$auth=sha1($data['order_info']->firstname."|".$data['order_info']->lastname."|".$data['order_info']->order_id."|".$data['order_info']->order_total);
		
		
	
// 		if($auth==$auth_token){
			$this->load->view('general/header_print');
			$this->load->view('orders/print_quote',$data);
			$this->load->view('general/footer_print');
// 		}
// 		else echo "Oops! You do not have the correct authentication token to see this invoice. Please get in touch with us at the earliest to resolve this issue.";
}
	
	public function print_order($order_id,$auth_token,$ofrom='')
	{
	      $data['user_id']= $this->session->userdata('user_id');
	   //   echo $data['user_id']; exit;
	    if($ofrom == 'frontend'){
	        
	     
	        if (isset($order_id)) {
			$data['order_info'] = $this->orders_model->getOrder($order_id);
			
			
		}
	        
	     
	        
	        $data['order_products'] = array();

			$products = $this->orders_model->getOrderProducts($order_id);
			
		   $order_option_val =  array();
           $ar = array();
			foreach ($products as $product) {
			    
			   
			    
			       $order_prod_descr = 	$this->orders_model->getOrderProductsDescrption($product->product_id);
			       
			        $prod_cat_id = $this->orders_model->getProductCategory($product->product_id);
			   
			    	$order_option_values = 	$this->orders_model->getOrderOptions($order_id, $product->order_product_id);
			    	
			    	$order_option_values  = json_decode(json_encode($order_option_values), True);
			    	
			    
			    $i =0;
			    if(!empty($order_option_values)) {
				foreach ($order_option_values as $order_option_value) {
				    $ar[] =  $this->orders_model->getOrderOptions_value($order_option_value['product_option_id'], $order_option_value['product_option_value_id']);
				    
				    $ar  = json_decode(json_encode($ar), True);
				$order_option_values[$i]['price'] = $ar[0][0]['price'];
				unset($ar);
				  $i++;
				}
				}
				
				//convert array back to stdclass obj 
		
		$order_option_values  = json_decode(json_encode($order_option_values));

     $order_prod_descr  = json_decode(json_encode($order_prod_descr), True);
			    
				$data['order_products'][] = array(
					'product_id' => $product->product_id,
					'name'       => $product->name,
					'model'      => $product->model,
					'descr'     =>  $order_prod_descr,
					'option'     => $order_option_values,
					'quantity'   => $product->quantity,
					'price'      => $product->price,
					'total'      => $product->total,
					'reward'     => $product->reward,
					'cat_id'     =>$prod_cat_id[0]->category_id,
						'addons'     =>$product->addons
				);
				
			
				
			}



	       $order_totals = $this->orders_model->getOrderTotals($order_id);
	
	
			foreach ($order_totals as $order_total) {
				$data['order_totals'][] = array(
					'title' => $order_total->title,
					'text'  => $order_total->value
				);
			}
	        
	      
	        
	   $auth=sha1($data['order_info'][0]->firstname."|".$data['order_info'][0]->lastname."|".$data['order_info'][0]->order_id."|".$data['order_info'][0]->total);
	   
		
		
		if($auth==$auth_token){
		    
		  //  echo "<pre>";print_r($data);exit;
	
			$this->load->view('general/header_print');
			$this->load->view('orders/print_frontend_order',$data);
			$this->load->view('general/footer_print');
		}
		  
	        
	    }
		else{
		    
		$company_name = '';
	        $abn = ''; 
			$order_infoo =$this->orders_model->fetch_order_info($order_id)[0];
		
		$data['order_info']= $order_infoo;
      	$user_info = $this->orders_model->getUserInfo($order_infoo->user_id);
      	if($order_infoo->companyID != ''){
		$company_det = $this->orders_model->fetch_company_info($order_infoo->companyID);
      	if(!empty($company_det)){
	        $company_name = $company_det[0]->company_name;
	        $abn = $company_det[0]->company_abn;
	    }
      	    
      	}
	        
	    
		 $data['company_name'] = $company_name;
		$data['company_abn'] = $abn;
		
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		
	
		//Fingerprinting auth
		//sha1 hash of firstname|lastname|order_id|total
		$auth=sha1($data['order_info']->customer_order_name."|".$data['order_info']->customer_order_name."|".$data['order_info']->order_id."|".$data['order_info']->order_total);
		
		
	
		if($auth==$auth_token){
			$this->load->view('general/header_print');
			$this->load->view('orders/print_order',$data);
			$this->load->view('general/footer_print');
		}
// 		else echo "Oops! You do not have the correct authentication token to see this invoice. Please get in touch with us at the earliest to resolve this issue.";
	}}
	public function mark_as_paid($order_id='',$referrer='',$ofrom='')
	{
	    $this->orders_model->mark_paid($_POST['order_id'],$_POST['mark_paid_comments'],$_POST['ofrom']);
		if(isset($_POST['referrer']) && $_POST['referrer'] !=''){
		     redirect('orders/'.$_POST['referrer'].'?id=2');
		     }else{
		    	redirect('orders/order_history');
		   }
		
        }
        public function mark_as_completed($order_id='',$referrer='',$ofrom='',$orderTotal='',$status='')
	   { 
	       $userId = $this->session->userdata('user_id');
	       ($userId == 1 || $userId == 2 ? $uid = 1 : $uid = $userId);
	       
	       // if not paid send payment link else send invoice link
	       $this->orders_model->mark_as_completed($order_id,$ofrom);
	      
	       if($status ==3 || $status ==2){
		if(isset($referrer) && $referrer !=''){
		    $this->sendEmailInvoiceToPaidOrders($order_id,$ofrom);
		     redirect('orders/'.$referrer.'/'.$uid);
		     }else{
		    	redirect('orders/order_history');
		   }
	       }else{
	    $this->send_link($order_id,$orderTotal,$ofrom);
	           redirect('orders/'.$referrer.'/'.$uid);
	   }
		
        }
        

       
   	public function order_comment()
	{
	   
	   $this->orders_model->add_order_comment($_POST['order_id'],$_POST['order_comment'],$_POST['ofrom']);
	      
	     // commented for a while to stop sending the email.
	    
		  // $this->send_mark_paid_email($_POST['order_id'],$_POST['ofrom']);
     
		if(isset($_POST['referrer']) && $_POST['referrer'] !=''){
		     redirect('orders/'.$_POST['referrer']);
		     
		     }else{
		      
		    	redirect('orders/order_history');
		   }
		
        }     
         	
         		
    public function group_mark_as_paid($orders,$comment,$referrer)
    {
	   
	   
	   if(!empty($orders))
		{
		    
			$orders=explode(".",$orders);
			
			
			
		$this->orders_model->group_mark_as_paid($orders,$comment);
		
			
		}
	   	 
	      
		redirect('orders/'.$referrer);
	
		
         	}
         	
         
	
	
		public function delete_order()
	{
	       $referrer = $_POST['referrer'];
	       
	   
	        $this->orders_model->delete_order($_POST['order_id'],$_POST['ofrom'], $_POST['cancel_comments'],'');
	    
		  
			redirect('orders/'.$referrer);
	}
	
	public function payment_process()
	{
	   // ini_set('display_errors', 1); 
	  
	  $order_infoo =$this->orders_model->fetch_order_info($_POST['refid'])[0];
	  if(empty($order_infoo)){
	    $ofrom = 'frontend';  
	  }else{
	     $ofrom = 'backend';  
	  }
	 
		if($_POST['rescode']=='00'||$_POST['rescode']=='08'||$_POST['rescode']=='11'){

			$this->orders_model->mark_paid($_POST['refid'],'',$ofrom);
			
			$res = $this->send_mark_paid_email($_POST['refid'],$ofrom);
			
			
			redirect('orders/order_history');
		}
		else{
		  
// 			Payment failed, show failure page
			$this->load->view('general/header');
			$this->load->view('general/payment_error');
			$this->load->view('general/footer');
		}
	}
	
	
		public function payment_process_customer()
	{
	    
// 	    ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$order_infoo =$this->orders_model->fetch_order_info($_POST['refid'])[0];
	  if(empty($order_infoo)){
	    $ofrom = 'frontend';  
	  }else{
	     $ofrom = 'backend';  
	  }
	  
		if($_POST['rescode']=='00'||$_POST['rescode']=='08'||$_POST['rescode']=='11'){
		    
			$this->orders_model->mark_paid($_POST['refid'],'',$ofrom);
			$result = $this->send_mark_paid_email($_POST['refid'],$ofrom);
			if($result){
	     	header('location: https://healthychoicescatering.com.au/externalRedirect.html');	    
			}
		 	
		}
		else{
		  

			$this->load->view('orders/pay_error');
// 			$this->load->view('orders/footer');
		}
	}
	
	
	public function reports()
	{
		if(!empty($this->session->userdata('username')))
		{
			$this->load->model('general_model');
			$data['companies']=$this->general_model->fetch_companies();
			$this->load->view('general/header');
			$this->load->view('orders/report',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function generate_report()
	{
// 	    ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// 	    ini_set('display_startup_errors', 1); 
		if(!empty($this->session->userdata('username')))
		{
		    //echo '<pre>';
		    //print_r($this->session->userdata);
		   // exit;
		   
		   if(isset($_POST["added_date_from"]))
				$added_date_from=trim($_POST["added_date_from"])==''?"1000-01-01":date("Y-m-d",strtotime($_POST["added_date_from"]));
			else $added_date_from=1;
			if(isset($_POST["added_date_to"]))
				$added_date_to=trim($_POST["added_date_to"])==''?"9999-12-31":date("Y-m-d",strtotime($_POST["added_date_to"]));
			else $added_date_to=1;
			
			if(isset($_POST["date_from"]))
				$date_from=trim($_POST["date_from"])==''?"1000-01-01":date("Y-m-d",strtotime($_POST["date_from"]));
			else $date_from=1;
			if(isset($_POST["date_to"]))
				$date_to=trim($_POST["date_to"])==''?"9999-12-31":date("Y-m-d",strtotime($_POST["date_to"]));
			else $date_to=1;
			
			
		
			
			$company=(isset($_POST["company"]) ? $_POST["company"] : '');
			$status=(isset($_POST["status"]) ? $_POST["status"] : '');
			$locations = (isset($_POST["locations"]) ? $_POST["locations"] : '');
		
		
			$res['data']=$this->orders_model->generate_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations);	
			
	
			$res['frontend_data'] = $this->orders_model->generate_frontend_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations);
			
			
			
		
			
		   foreach($res['frontend_data'] as $all_frontend_order){
		       
		       $res['frontend_order_totals'][$all_frontend_order->order_id] = $this->orders_model->getOrderTotals($all_frontend_order->order_id);
		       
		   }
		   
		 ksort($res['frontend_order_totals']);
	
      // convert array to object not required but as used on view file so....
       
        $res['frontend_order_totals']  = json_decode(json_encode($res['frontend_order_totals']), True);
        
        
		   
      
		$res['data'] = array_merge($res['data'],$res['frontend_data']);
		
// 		$userId = $this->session->userdata('branch_id');
		$userId = $this->session->userdata('user_id');
		$user = $this->orders_model->fetch_user_info($userId);
                 $username = $user[0]->username;
                 
                 $res['username'] = $username;
			
			
// 		$data['orders']  = json_decode(json_encode($data['orders']), True);
		
			$data=$res['data'];
			$csvStr="Order #,Order Date,Delivery Date,Customer,Company,Cost Centre,Phone,Email,Subtotal,Discount,Delivery,Total,GST,Status\n";
			$res['params']['date_from']=$date_from;
			$res['params']['date_to']=$date_to;
			
			$res['params']['added_date_from']=$added_date_from;
			$res['params']['added_date_to']=$added_date_to;
			
			
		
			
			$res['params']['company']=$company;
			$res['params']['status']=$status; 
				$res['params']['locations']=$locations;
				// echo "<pre>";print_r($res);exit;
			$this->load->view('general/header');
			$this->load->view('orders/generated_report',$res);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
		public function view_all_feedback_report()
	{
	   
	      
	
	     $conditions['returnType'] = 'count'; 
        
		$all_feedback =	$this->orders_model->fetch_all_feedback();
    
		
	
// 			$csvStr="OrderID #,Customer,Delivery Date,Company,FOOD,PRICING,MENU,WEBSITE EXPERIENCE,DELIVERY,PACKAGING,CUSTOMER SERVICE,WHERE DID YOU HEAR ABOUT US,SUGGESTION\n";
			$csvStr="OrderID #,Customer,Delivery Date,Company,WHERE DID YOU HEAR ABOUT US,IMPROVEMENT ON,SUGGESTION\n";
   	       	if(!empty($all_feedback)){
		     $i = 0;
			foreach($all_feedback as $row){
// 			$csvStr.="\"".$row->order_id."\",\"".$row->cname."\",\"".date("d-m-Y",strtotime($row->delivery_date))."\",\"".$row->company_name." ".$row->FOOD."\",\"".$row->PRICING."\",\"".$row->MENU."\",\"".$row->EXPERIENCE."\",\"".$row->DELIVERY."\",\"".$row->PACKAGING."\",\"".$row->SERVICE."\",\"".$row->deliveredOnTime."\",\"".$row->commentText."\",\"".$row->suggestions."\"\n";
				$csvStr.="\"".$row->order_id."\",\"".$row->cname."\",\"".date("d-m-Y",strtotime($row->delivery_date))."\",\"".$row->company_name." \",\"".$row->deliveredOnTime."\",\"".$row->commentText."\",\"".$row->suggestions."\"\n";
			 
			 
			}
			
		  header("Content-type: application/octet-stream");
			    header("Content-Disposition: attachment; filename=\"Feedback_Report ".date("d-m-Y",strtotime("today")).".csv\"");
			    echo $csvStr;
			
		}
	}
public function get_report_csv($status = '',$cron='')
	{
// 	    ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
		if(isset($_POST["date_from"]))
			$date_from=trim($_POST["date_from"])==''?"1000-01-01":date("Y-m-d",strtotime($_POST["date_from"]));
		else $date_from=1;
		if(isset($_POST["date_to"]))
			$date_to=trim($_POST["date_to"])==''?"9999-12-31":date("Y-m-d",strtotime($_POST["date_to"]));
		else $date_to=1;
		
		
		 if(isset($_POST["added_date_from"]))
		$added_date_from=trim($_POST["added_date_from"])==''?"1000-01-01":date("Y-m-d",strtotime($_POST["added_date_from"]));
		else $added_date_from=1;
		if(isset($_POST["added_date_to"]))
		$added_date_to=trim($_POST["added_date_to"])==''?"9999-12-31":date("Y-m-d",strtotime($_POST["added_date_to"]));
		else $added_date_to=1;
		
		
		
		
		$cost_centre=$_POST["cost_centre"];
		$cost_centre_list=empty($_POST["cost_centre_list"])?'null':$_POST['cost_centre_list'];
		$company=$_POST["company"];
		if(isset($_POST["status"])){
		   	$status=$_POST["status"]; 
		}else{
		    	$status=$status;
		}
		
		if(isset($_POST["locations"])){
		   	$locations = $_POST["locations"]; 
		}

		$res['data']=$this->orders_model->generate_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations);
// 		echo $this->db->last_query();exit;

		
		$res['frontend_data'] = $this->orders_model->generate_frontend_report($added_date_from,$added_date_to,$date_from,$date_to,$company,$status,$locations);
		
		foreach($res['frontend_data'] as $all_frontend_order){
		       
		       $res['frontend_order_totals'][$all_frontend_order->order_id] = $this->orders_model->getOrderTotals($all_frontend_order->order_id);
		       
		   }
		   
		 ksort($res['frontend_order_totals']);
		
		
		$res['frontend_order_totals']  = json_decode(json_encode($res['frontend_order_totals']), True);
		
		$res['data'] = array_merge($res['data'],$res['frontend_data']);
		

// 		echo "<pre>"; print_r($res['data']); exit;
		
		
     	$data=$res['data'];
     
	
	
		if($cron ==''){
		 		$csvStr="Order #,Order Date,Delivery Date,Customer,Department,Company,Phone,Email,Subtotal,Discount,Delivery,Surcharge,Late Fee,GST,Total,Status,Paid Comment,Paid Date\n";
   	       }else{
   	        $csvStr ="Order #,Order Date,Delivery Date,Customer,Department,Company,Phone,Email,Subtotal,Discount,Delivery,Surcharge,Late Fee,GST,Total,Status,Paid Comment,Paid Date,Username\n";  
   	       }
   	       
   	     
   	            // echo "<pre>";print_r($data);exit;
		if(!empty($data)){
		    $i = 0;
			foreach($data as $row){
				if(empty($row->delivery_phone))
					$phone=$row->telephone;
				else 
					$phone=$row->delivery_phone;
				if(empty($row->email))
					$email=$row->email;
				else
					$email=$row->email;
				if(empty($row->coupon_id)){
					$discount=0;
				}  
					if(isset($row->department_name)){
				    $dept_name = $row->department_name;
				}else{
				   $dept_name =  $row->dept_name;
				}
				
			if(isset($res['frontend_order_totals']) && !empty($res['frontend_order_totals']) && array_key_exists($row->order_id,$res['frontend_order_totals'])) {
			 
		        $newArray = array();
			   foreach($res['frontend_order_totals'][$row->order_id] as $key_ot => $frontend_order_total){
												    
					$newArray[$frontend_order_total['code']] = $frontend_order_total['value'];

					if($frontend_order_total['code'] == 'total'){
					 $gst = number_format($frontend_order_total['value']/11,2, '.', '');
						 }
				 }
			$lateFee = (isset($newArray['late_fee']) ? $newArray['late_fee'] : 0);
			$ord_sub_total = (isset($newArray['sub_total']) ? $newArray['sub_total'] : 0);
			$del_fee = (isset($newArray['shipping']) ? $newArray['shipping'] : 0);
			$surcharge = (isset($newArray['holiday_weekend_charges']) ? $newArray['holiday_weekend_charges'] : 0);
			$discount = (isset($newArray['coupon']) ? $newArray['coupon'] : 0);
			$order_total = (isset($newArray['total']) ? $newArray['total'] : 0);
            $gst = ($order_total/11);
			}else{
			    
			    	   if(!is_null($row->coupon_id)){
						if($row->type=='F')
						$discount=$order_info->coupon_discount;
						else{
						
						$discount=($row->coupon_discount*($row->order_total+$row->late_fee+$row->delivery_fee))/100;
						}
					   } else $discount=0;
					  
					  
					  
					 $ord_sub_total = $row->order_total;
					 $del_fee = $row->delivery_fee;
					 $lateFee = $row->late_fee;
					 $surcharge = $row->surcharge;
					 $order_total=$row->order_total+$row->late_fee+$row->delivery_fee - $discount;  
					 $gst = ($order_total/11);
					   
					   
			}

			if(isset($row->order_status_id)){
			    
			                                  if($row->order_status_id == 0){
												        
												    $status="Cancelled";
												    } 
				                                  else if($row->order_status_id == 2){
												        
												    $status="Paid";
												    } else{
												        
												        if($order->order_status_id==1 ){
																
																	$status= "New";
																}else{
												         
												        
												        if($row->order_status_id == 5){
												            
												            $status= "Complete";
												             
												         }
												         
												         if($row->order_status_id == 4){
												            ;
												             $status= "Awaiting Approval";
												             
												         }
												         
												         if($row->order_status_id == 7){
												            
												        $status= "New Order";
												             
												         }
												         
												         
												    }
												        
												    }
			}else{
			    
			                            if($row->order_status == 0){
												        
												    $status="Cancelled";
												    } 
			    		
											else if($row->order_status==4 ){
												 $status= "Awaiting approval";
												}
												else if($row->order_status==1){
													 $status = "New";
												}
												else if($row->order_status==2){
												 $status = "Paid";
												}
											   
			    
			}
				
			
				
				
				
			
			
				
				
				
				if(isset($row->mark_paid_comment) && $row->mark_paid_comment != ''){
				    
				    $comment  = $row->mark_paid_comment;
				}else{
				    
				    $comment  = '';
				}
				
				if(isset($row->order_status_id) &&  $row->order_status_id == 2){
				     
	                 $paid_date = $row->date_modified;
	                  
				    }else{
				       $paid_date = ''; 
				        
				    }
				    
				    if(isset($row->order_status) &&  $row->order_status == 2){
				     
	                 $paid_date = $row->date_modified;
	                  
				    }else{
				        
				          $paid_date = ''; 
				    }
				
				if(isset($row->delivery_date)){
				    
				    $del_dat = $row->delivery_date;
				}else{
				    
				    $del_dat = $row->delivery_date_time;
				}
				
				$csvStr.="\"".$row->order_id."\",\"".date('d-m-Y',strtotime($row->order_date_added))."\",\"".date("d-m-Y",strtotime($del_dat))."\",\"".$row->firstname." ".$row->lastname."\",\"".$dept_name."\",\"".$row->company_name."\",\"".$phone."\",\"".$email."\",\"$".number_format($ord_sub_total,2)."\",\"$".number_format($discount,2)."\",\"$".number_format($del_fee,2)."\",\"$".number_format($surcharge,2)."\",\"$".number_format($lateFee,2)."\",\"$".number_format($gst,2)."\",\"$".number_format($order_total,2)."\",\"".$status."\",\"".$comment ."\",\"".$paid_date."\"\n";
			 
		
			}
	
			if($cron ==''){
			    header("Content-type: application/octet-stream");
			    header("Content-Disposition: attachment; filename=\"Report ".date("d-m-Y",strtotime("today")).".csv\"");
			    echo $csvStr;
			 }else{
			     

 
        
			}
			
		}else{
		    echo "No Record found";
		}
	}
	
		public function send_quote_email($order_id,$auth_token)
	{

		
		    $toemail = $_POST["email"];
		    
		    $data['customer_name'] = $_POST["customer_name"];
		   
            $data['order_id'] = $order_id;
          
            $data['auth_token'] = $auth_token;
            $body = $this->load->view('orders/quote_email', $data,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering Quote');
            $this->email->message($body);
            $mail = $this->email->send();
            if($mail) {
                echo 'Ok';
                	$this->db->query("UPDATE quote SET order_status=4 WHERE order_id=".$order_id);
            } else {
                echo 'not ok';
            }
            
			
	}
	
		public function sendEmailInvoiceToPaidOrders($order_id,$ofrom)
	{
           if($ofrom=='backend'){
            $order_info = $this->orders_model->fetch_order_info($order_id)[0];
             $accounts_email = $order_info->accounts_email;
             $customer_order_email = $order_info->customer_order_email; 
             $toEmail = array($customer_order_email,$accounts_email);
             $data['customer_name'] = $order_info->customer_order_name;
             $auth_token=sha1($order_info->customer_order_name."|".$order_info->customer_order_name."|".$order_info->order_id."|".$order_info->order_total);
           }else{
               
               $order_info =   $this->orders_model->getOrder($order_id);
              $customer_info = $this->orders_model->getCostCenterById($order_info[0]->customer_id);
               $toemail = $customer_info[0]->email;
               $manager_email = $customer_info[0]->accounts_contact_email;
               $data['customer_name'] = $order_info[0]->firstname;
               if(isset($customer_info[0]->accounts_contact_email) && $customer_info[0]->accounts_contact_email !=''){
               $list = array($toemail,$manager_email);    
               }else{
               $list = array($toemail);     
               }
               $auth_token=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);
           }
		     
	         
		
		
		    
		    
		    $data['ofrom'] = $ofrom;
            $data['order_id'] = $order_id;
            $data['auth_token'] = $auth_token;
            $body = $this->load->view('orders/order_email', $data,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            $this->email->to($toEmail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering');
            $this->email->subject('Healthy Choices Catering');
            $this->email->message($body);
            $mail = $this->email->send();
            
            return true;
            
            
			
	}
	public function send_email($order_id,$auth_token,$neworderid='')
	{

		
		    $toemail = $_POST["email"];
		    
		    $data['customer_name'] = $_POST["customer_name"];
		    if(isset($_POST["ofrom"]) && $_POST["ofrom"] != '')
		    {
		         $data['ofrom'] = $_POST["ofrom"];
		        
		    }else{
		        
		        $data['ofrom'] = 'backend';
		    }
            $data['order_id'] = $order_id;
            $data['order_id1'] = $neworderid;
            $data['auth_token'] = $auth_token;
            $body = $this->load->view('orders/order_email', $data,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering');
            $this->email->message($body);
            $mail = $this->email->send();
            if($mail) {
                echo 'Ok';
            } else {
                echo 'not ok';
            }   
            
            
			
	}
	
	public function send_mark_paid_email($order_id,$ofrom='')
	{

          if($ofrom == 'frontend'){
              $order_info =   $this->orders_model->getOrder($order_id);
              $customer_info = $this->orders_model->getCostCenterById($order_info[0]->customer_id);
              $auth=sha1($order_info[0]->firstname."|".$order_info[0]->lastname."|".$order_info[0]->order_id."|".$order_info[0]->order_total);
               $toemail = $customer_info[0]->email;
               $manager_email = $customer_info[0]->accounts_contact_email;
                $auth_token=$auth;
               $data['customer_name'] = $order_info[0]->firstname;
               if(isset($customer_info[0]->accounts_contact_email) && $customer_info[0]->accounts_contact_email !=''){
               $list = array($toemail,$manager_email);    
               }else{
               $list = array($toemail);     
               }
              
               
          }else{
              $order_info = $this->orders_model->fetch_order_info($order_id)[0];
              $manager_email = $order_info->accounts_email;
              $toemail = $order_info->customer_order_email;
              $auth_token=sha1($order_info->customer_order_name."|".$order_info->customer_order_name."|".$order_info->order_id."|".$order_info->order_total);
		   
		      $data['customer_name'] = $order_info->customer_order_name;
		    
		     $list = array($toemail,$manager_email);
		    
          }
		    if(isset($ofrom) && $ofrom != '')
		    {
		         $data['ofrom'] = $ofrom;
		        
		    }else{
		        $data['ofrom'] = 'backend';
		    }
            $data['order_id'] = $order_id;
            $data['order_id1'] = '';
            $data['auth_token'] = $auth_token;
            $body = $this->load->view('orders/order_email', $data,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html',
            );
            
            $this->email->initialize($config);
            
            // $this->email->to($toemail,$manager_email);
            
           
    
            $this->email->to($list);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering');
            $this->email->message($body);
            $mail = $this->email->send();
           
            if($mail) {
                return true;
            }else{
                return false;
            }
            
			
	}
	
	
	
	
	
	public function order_approval($order_id,$auth)
	{
	  $company_name = '';
	        $abn = '';
		$order_info=$this->orders_model->fetch_quote_info($order_id)[0];
	
	   $regen_auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);
	
		if($regen_auth!=$auth)
			die("Oops! You do not have permission to view that page. If you think this is an error, please get in touch with us.");
		$data['order_info']=$order_info;
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$data['order_product_options']=$this->orders_model->fetch_order_product_options($order_id);
		
		if($order_info->company_id != ''){
		$company_det = $this->orders_model->fetch_company_info($order_info->company_id);
	    if(!empty($company_det)){
	        $company_name = $company_det[0]->company_name;
	        $abn = $company_det[0]->company_abn;
	    }
	    }
	 
		 $data['company_name'] = $company_name;
		$data['abn'] = $abn;
		$this->load->view('general/header_print');
		$this->load->view('orders/order_approval',$data);
		$this->load->view('general/footer');
	}
	public function approve()
	{
		$comments=$_POST['approval_comments'];
		$order_id =$_POST['order_id'];
		$status_name =$_POST['status_name'];
		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	
	   if($status_name =="approve"){
	      $order_status_value = 7;
	      $msg = "Thank you, the order has been approved";
	      
	    }elseif($status_name =="reject"){
	        $order_status_value = 8;
	        $msg = "The order is now cancelled. Please email us if you have any queries. Thank you for your time.";
	    }else{
	         $order_status_value = 9;
	         $msg = "Thank you for your comments, one of our managers will get back to you shortly with the modified quote.";
	    }
		
	
		$val = $this->orders_model->approve_quote($order_id,$comments,$order_status_value);

		
		 
		 if($order_status_value == 7){
		    $this->send_mail_manager($order_id,'sendMail',$msg);
		 $res = $this->convertApprovedQuoteToInvoice($order_id);   
		}
	   echo $msg;
		        exit;
	
	}
	
	

	
	
	public function resend_mail($order_id='')
	{
	    $new_order_email = false;
	    if(isset($_POST['order_id']) && $_POST['order_id'] !=''){
	        $order_id =  $_POST['order_id'];
	    }else if(isset($order_id) && $order_id != ''){
	        $order_id  = $order_id;
	        
	        $new_order_email = true;
	    }else{
	        return false;
	    }
	    
	    if(isset($_POST['resend_mail_comments']) && $_POST['resend_mail_comments'] !=''){
	        
	        $data['resend_mail_comments'] = $_POST['resend_mail_comments'];
	    }
	    
	   
	        $order_info=$this->orders_model->fetch_order_info($order_id)[0];
	        
	      
	        
	      
		    $auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);;
		    $toemail = $order_info->email;
            $data['order_id'] = $order_info->order_id;
             $data['customer_name']   = $order_info->firstname;
            $data['order_id1'] = '';
           
         

            $data['auth_token'] = $auth;
            $body = $this->load->view('orders/reorder_email', $data,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering ');
            $this->email->message($body);
            $mail = $this->email->send();		
            
           
            if($new_order_email == true){
                // $this->send_mail_manager($order_id);
                	redirect('orders/view_order/'.$order_id);
                	
            }else{
                 redirect('orders/'.$_POST['referrer']);
                 
            }
           
	}
	
	public function send_mail_manager($order_id='',$type='',$msg= '')
	{
	    if($order_id == ''){
	       return false;
	    }
	    
	  
	   
	        $order_info=$this->orders_model->fetch_quote_info($order_id)[0];
	   $userId = (isset($order_info->order_user_id) && $order_info->order_user_id !='' ? $order_info->order_user_id : $order_info->user_id);

	        $user_info = $this->orders_model->fetch_user_info($userId);
          
         
          
          $manager_email = $user_info[0]->email;
	        
	      
		    $auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);;
		    $toemail = $manager_email;
            $data['order_id'] = $order_info->order_id;
           $data['customer_name']   = $order_info->firstname;
            $data['order_id1'] = '';
           
         
if(isset($type) && ($type =='approve' || $type == 'sendMail')){
    
     $body = "Hello Manager,\r\nOrder Id   (Order #".$order_id.") has been approved by customer";
}else{
    
     $body = "Hello Manager,\r\nYou received an order  (Order #".$order_id.")";
}
            $data['auth_token'] = $auth;
           
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering ');
            $this->email->message($body);
            
            $mail = $this->email->send();
          
            if($type == 'sendMail'){
               return true;
            }
            else if($type =='approve'){
          	$regen_auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);;
          	
           		redirect('orders/order_approval/'.trim($order_id)."/".trim($regen_auth));
            }else{
                 redirect('orders/view_order/'.$order_id);
            }
           
	}
	public function send_link($order_id,$total,$ofrom="")
	{
	    if($ofrom=='frontend'){
	        $order_info = $this->orders_model->getOrder($order_id);
	        $data['customer_name']   = $order_info[0]->firstname;
	        $data['ofrom']   = 'frontend';
	        $data['download_link']   =  SITEURL.'index.php?route=account/order/order_inv_download&oid='. $order_id.'&cus_id='.$order_info[0]->customer_id;
	         $delivery_date = $order_info[0]->delivery_date;
	         $location_id = $order_info[0]->user_id;
	        $company_name = '';
	         $emailTo = $order_info[0]->email;
	        $customer_info = $this->orders_model->getCostCenterById($order_info[0]->customer_id);
	         $accountsEmail = $customer_info[0]->accounts_contact_email;
	         $total = $order_info[0]->total;
	    }else{
	      $order_info=$this->orders_model->fetch_order_info($order_id)[0];  
	      $data['customer_name']   = $order_info->firstname;
	      $data['ofrom']   = 'backend';
	      $data['download_link']   =  base_url().'index.php/orders/order_inv_download/'.$order_id.'/'.$customer_id.'/';
	     
	       $delivery_date = date("d-m-Y", strtotime($order_info->delivery_date) );
	        $company_name = $order_info->customer_company_name;
	        $location_id = $order_info->user_id;
	        $emailTo = $order_info->email;
	        $accountsEmail = $order_info->accounts_email;
	    }
	    
	  
	    $details = array(
	        'delivery_date' => $delivery_date,
	        'company_name' => $company_name,
	        'cname' => $data['customer_name'],
	        'order_id' => $order_id,
	        'location_id' => $location_id
	        );
	        $encoded = urlencode(serialize($details));
	        
	        	$data['encoded'] = $encoded;
	
		
		if(isset($_POST["email_payment"]) && $_POST["email_payment"] !=''){
		    $emailToList = array($_POST["email_payment"]);
		}else{
		  $emailToList = array($emailTo,$accountsEmail);
		}
		$data['order_id'] = $order_id;
		$data['total'] = $total;
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
// 		$this->load->library('email', $config);
		$config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
// 		$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
          $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
		$this->email->to($emailToList);
		
		 $body = $this->load->view('orders/Emails/payment_link_email', $data,TRUE);
		$this->email->subject('Healthy Choices Catering - '.$order_id);
		$this->email->message($body);
		$this->email->send();
	}
	public function send_feedback_form()
	{
	    $order_id = $_POST['order_id'];
	    
	   if(isset($_POST['ofrom']) && $_POST['ofrom']=='frontend'){
	        $order_info = $this->orders_model->getOrder($order_id);
	        $data['customer_name']   = $order_info[0]->firstname;
	        $data['ofrom']   = 'frontend';
	       $email = $order_info[0]->email;
	    }else{
	       
	      $order_info=$this->orders_model->fetch_order_info($order_id)[0];   
	      $data['customer_name']   = $order_info->firstname;
	      $data['ofrom']   = 'backend';
	       $email = $order_info->email;
	      
	    }
	    $order_det = $this->orders_model->fetch_order_info($order_id);
	    if(empty($order_det)){
	        
	      $order_det = $this->orders_model->fetch_order_infofrontendorders($order_id); 
	      $delivery_date = $order_det[0]->delivery_date;
	      $location_id = $order_det[0]->user_id;
	      $company_name = '';
	    }else{
	        $delivery_date = date("d-m-Y", strtotime($order_det[0]->delivery_date) );
	        $company_name = $order_det[0]->customer_company_name;
	        $location_id = $order_det[0]->user_id;
	    }
	   
	   
	    
	    $details = array(
	        'delivery_date' => $delivery_date,
	        'company_name' => $company_name,
	        'cname' => $data['customer_name'],
	        'order_id' => $order_id,
	        'location_id' => $location_id
	        );
	        $encoded = urlencode(serialize($details));
	        
	        	$data['encoded'] = $encoded;
// 		$email=$_POST["email_payment"];
		$data['order_id'] = $order_id;
	
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
// 		$this->load->library('email', $config);
		$config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
// 		$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
          $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
			$this->email->to($email);
// 		$this->email->to('mqaddarkasikandar@gmail.com');
		
		 $body = $this->load->view('orders/send_feedback_form', $data,TRUE);
		$this->email->subject('Healthy Choices Catering - '.$order_id);
		$this->email->message($body);
		if($this->email->send()){
		    echo "sent";
		}
		else{
		   
		    echo "email error";
		}
	}
		public function feedback_form($orderdetail='')
	{
	    $var = unserialize(urldecode($_GET['data']));
	  
	    $data['delivery_date']   =  date('Y-m-d',strtotime($var['delivery_date']));
	    $data['company_name']   =  $var['company_name'];
	     $data['cname']   =  $var['cname'];
	     $data['order_id']   =  $var['order_id'];
	     $data['location_id']   =  $var['location_id'];
	     $data['ofrom']   =  $var['ofrom'];
	    $this->load->view('orders/feedback_form',$data); 
	}
	
	public function feedback_form_submit()
	{
	   
	    $data['customer_name']   =  $_POST['cname'];
	   // echo "<pre>";
	   // print_r($_POST);
	   // exit;
	     $res = $this->orders_model->insert_feedback($_POST);
	     
	   //  if($res){
	   //      $order_id = $_POST['order_id'];
	         
    // 	        if(isset($_POST['ofrom']) && $_POST['ofrom']=='frontend'){
    //     	        $order_info = $this->orders_model->getOrder($order_id);
    //     	        $data['customer_name']   = $order_info[0]->firstname;
    //     	        $data['ofrom']   = 'frontend';
    //     	       $email = $order_info[0]->email;
    //     	    }else{
        	       
    //     	      $order_info=$this->orders_model->fetch_order_info($order_id)[0];   
    //     	      $data['customer_name']   = $order_info->firstname;
    //     	      $data['ofrom']   = 'backend';
    //     	       $email = $order_info->email;
        	      
    //     	    }
	        
	   //  }
	    $this->load->view('orders/feedback_form_submit',$data); 
	}
	public function delete_feedback($order_id){
	    $res = $this->orders_model->delete_feedback($order_id);
	}
		public function feedback_form_frontend($orderdetail='')
	{
	    $var = unserialize(urldecode($_GET['data']));
	  
	    $data['delivery_date']   =  date('Y-m-d',strtotime($var['delivery_date']));
	    $data['company_name']   =  $var['company_name'];
	     $data['cname']   =  $var['cname'];
	     $data['order_id']   =  $var['order_id'];
	     $data['location_id']   =  $var['location_id'];
	     $data['ofrom']   =  $var['ofrom'];
	    $this->load->view('orders/feedback_form_frontend',$data); 
	}
	public function feedback_form_frontend_submit()
	{
	   
	    $data['customer_name']   =  $_POST['cname'];
	   // echo "<pre>";
	   // print_r($_POST);
	   // exit;
	     $res = $this->orders_model->insert_feedback($_POST);
	     
	     if($res){
	         $order_id = $_POST['order_id'];
	         
    	        if(isset($_POST['ofrom']) && $_POST['ofrom']=='frontend'){
        	        $order_info = $this->orders_model->getOrder($order_id);
        	        $this->orders_model->UpdateCustomerFeedbackStatus($order_info[0]->customer_id);
        	        $data['customer_name']   = $order_info[0]->firstname;
        	        $data['ofrom']   = 'frontend';
        	       $email = $order_info[0]->email;
        	        $thisCustomerGiven =  $this->orders_model->checkCustomerOldFeedbackStatus($order_info[0]->customer_id);
        	       $thisCustomerGivenFeedback =  $thisCustomerGiven[0]->is_feedback_given;
        	    }else{
        	       
        	      $order_info=$this->orders_model->fetch_order_info($order_id)[0];   
        	      $data['customer_name']   = $order_info->firstname;
        	      $data['ofrom']   = 'backend';
        	       $email = $order_info->email;
        	      $thisCustomerGivenFeedback = true;
        	    }
        	   
        	    
        	    if(!$thisCustomerGivenFeedback){
        	      $config['protocol'] = 'sendmail';
        		$config['smtp_host'] = 'localhost';
        		$config['smtp_user'] = '';
        		$config['smtp_pass'] = '';
        		$config['smtp_port'] = 25;
        		$this->load->library('email', $config);
        		$config=array(
                    'charset'=>'utf-8',
                    'wordwrap'=> TRUE,
                    'mailtype' => 'html'
                    );
                    
                    $this->email->initialize($config);
                  $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
        			$this->email->to($email);
        // 		$this->email->to('mqaddarkasikandar@gmail.com');
        		
        		 $body = $this->load->view('orders/Emails/send_coupon_code', $data,TRUE);
        		$this->email->subject('Healthy Choices Catering - '.$order_id);
        		$this->email->message($body);
        		$this->email->send();  
        	    }
	         

	     }
	    $this->load->view('orders/feedback_form_submit',$data); 
	}
	public function view_order_feedback($order_id)
	{
	 
	    $orderfeedback_info = $this->orders_model->getOrder_feedback($order_id);
	    if(!empty($orderfeedback_info)){
	        
	   
	    $table ='<tr>';
	    
               $table .='<td>'.$orderfeedback_info[0]->cname.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->order_id.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->FOOD.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->PRICING.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->MENU.'</td>'; 
                $table .='<td>'.$orderfeedback_info[0]->EXPERIENCE.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->DELIVERY.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->PACKAGING.'</td>'; 
               $table .='<td>'.$orderfeedback_info[0]->SERVICE.'</td>';
               $table .='<td>'.$orderfeedback_info[0]->deliveredOnTime.'</td>';
               $table .='<td>'.$orderfeedback_info[0]->commentText.'</td>'; 
            $table .='<td>'.$orderfeedback_info[0]->suggestions.'</td>';
                
         $table .='</tr>';
	    }else{
	     $table ='<tr>';
	    
               $table .='<td colspan="9">No Feedback given by this customer</td>';  
                $table .='</tr>';
	    }
	     echo $table;
	     exit;
	}
	

		public function securepay_link($order_id,$ofrom='')
	{
	    	$mid =	'';
			$mpass=	'';
		
		
	    if(isset($ofrom) && $ofrom=='frontend'){
	        
	        $order_info = $this->orders_model->getOrder($order_id);
	        $total   = (int)(($order_info[0]->total)*100);
	         $useeInfo=$this->orders_model->fetch_user_info($order_info[0]->user_id);
	         $mid = $useeInfo[0]->merchant_id;
	         $mpass= $useeInfo[0]->merchant_pass;
	      

	    }else{
	        $o=$this->orders_model->fetch_order_info($order_id)[0];
	         $userId = (isset($o->order_user_id) && $o->order_user_id !='' ? $o->order_user_id : $o->user_id);
	         $useeInfo=$this->orders_model->fetch_user_info($userId);
	         $mid = $useeInfo[0]->merchant_id;
	         $mpass= $useeInfo[0]->merchant_pass;
	       
	
		if(empty($o->coupon_id))
			$discount=0;
		else{
			if($o->type=='F')
				$discount=$o->coupon_discount;
			else $discount=($o->order_total+$o->late_fee+$o->delivery_fee)*$o->coupon_discount/100;
		}
		$total=(int)(($o->order_total+$o->late_fee+$o->delivery_fee-$discount)*100);
	
	        
	        
	    }
// 			$mid=	'ABC0001';
// 			$mpass=	'abc123';   
			
// 		$elem="<form id=\"securepay_form\" action=\"https://test.payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
		$elem="<form id=\"securepay_form\" action=\"https://payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
		$elem.="<input type=\"hidden\" name=\"bill_name\" value=\"transact\">";
		$elem.="<input type=\"hidden\" name=\"merchant_id\" value=\"".$mid."\">";
		$elem.="<input type=\"hidden\" name=\"primary_ref\" value=\"".$order_id."\">";
		$elem.="<input type=\"hidden\" name=\"fp_timestamp\" value=\"".gmdate("YmdHis")."\">";
		$elem.="<input type=\"hidden\" name=\"fingerprint\" value=\"".sha1($mid."|".$mpass."|0|".$order_id."|".$total."|".gmdate("YmdHis"))."\">";
		$elem.="<input type=\"hidden\" name=\"amount\" value=\"".$total."\">";
		$elem.="<input type=\"hidden\" name=\"txn_type\" value=\"0\">";
		$elem.="<input type=\"hidden\" name=\"currency\" value=\"AUD\">";
		$elem.="<input type=\"hidden\" name=\"return_url\" value=\"".base_url()."index.php/orders/payment_process\">";
		$elem.="<input type=\"hidden\" name=\"return_url_target\" value=\"parent\">";
		$elem.="<input type=\"hidden\" name=\"cancel_url\" value=\"".base_url()."index.php/orders/payment_process\">";
		$elem.="<input type=\"hidden\" name=\"callback_url\" value=\"".base_url()."index.php/orders/payment_process\">";
		$elem.="<input type=\"hidden\" name=\"template\" value=\"default\">";
		$elem.="<input type=\"hidden\" name=\"card_types\" value=\"VISA|MASTERCARD|AMEX\">";
		$elem.="<input type=\"hidden\" name=\"display_receipt\" value=\"no\">";
		$elem.="<input type=\"hidden\" name=\"display_cardholder_name\" value=\"no\">";
		$elem.="</form>";
		$data['elem']=$elem;
		$this->load->view('orders/process_payment',$data); 
	}
	
	
	
	
	public function securepay_customer_link($order_id,$ofrom='')
	{
	    
	    if(isset($ofrom) && $ofrom=='frontend'){
	        
	        $order_info = $this->orders_model->getOrder($order_id);
	        $total   = (int)(($order_info[0]->total)*100);
	         $useeInfo=$this->orders_model->fetch_user_info($order_info[0]->user_id);
	         $mid = $useeInfo[0]->merchant_id;
	         $mpass= $useeInfo[0]->merchant_pass;
	        
	    }else{
	        $o=$this->orders_model->fetch_order_info($order_id)[0];
	        $userId = (isset($o->order_user_id) && $o->order_user_id !='' ? $o->order_user_id : $o->user_id);
	         $useeInfo=$this->orders_model->fetch_user_info($userId);
	         $mid = $useeInfo[0]->merchant_id;
	         $mpass= $useeInfo[0]->merchant_pass;
	       
	
		if(empty($o->coupon_id))
			$discount=0;
		else{
			if($o->type=='F')
				$discount=$o->coupon_discount;
			else $discount=($o->order_total+$o->late_fee+$o->delivery_fee)*$o->coupon_discount/100;
		}
		$total=(int)(($o->order_total+$o->late_fee+$o->delivery_fee-$discount)*100);
		echo $total;
	        
	        
	    }
// 			$mid=	'ABC0001';
// 			$mpass=	'abc123';   
			
// 		$elem="<form id=\"securepay_form\" action=\"https://test.payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
		$elem="<form id=\"securepay_form\" action=\"https://payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
		$elem.="<input type=\"hidden\" name=\"bill_name\" value=\"transact\">";
		$elem.="<input type=\"hidden\" name=\"merchant_id\" value=\"".$mid."\">";
		$elem.="<input type=\"hidden\" name=\"primary_ref\" value=\"".$order_id."\">";
		$elem.="<input type=\"hidden\" name=\"fp_timestamp\" value=\"".gmdate("YmdHis")."\">";
		$elem.="<input type=\"hidden\" name=\"fingerprint\" value=\"".sha1($mid."|".$mpass."|0|".$order_id."|".$total."|".gmdate("YmdHis"))."\">";
		$elem.="<input type=\"hidden\" name=\"amount\" value=\"".$total."\">";
		$elem.="<input type=\"hidden\" name=\"txn_type\" value=\"0\">";
		$elem.="<input type=\"hidden\" name=\"currency\" value=\"AUD\">";
		$elem.="<input type=\"hidden\" name=\"return_url\" value=\"".base_url()."index.php/orders/payment_process_customer\">";
		$elem.="<input type=\"hidden\" name=\"return_url_target\" value=\"parent\">";
		$elem.="<input type=\"hidden\" name=\"cancel_url\" value=\"".base_url()."index.php/orders/payment_process_customer\">";
		$elem.="<input type=\"hidden\" name=\"callback_url\" value=\"".base_url()."index.php/orders/payment_process_customer\">";
		$elem.="<input type=\"hidden\" name=\"template\" value=\"default\">";
		$elem.="<input type=\"hidden\" name=\"card_types\" value=\"VISA|MASTERCARD|AMEX\">";
		$elem.="<input type=\"hidden\" name=\"display_receipt\" value=\"no\">";
		$elem.="<input type=\"hidden\" name=\"display_cardholder_name\" value=\"no\">";
		$elem.="</form>";
		$data['elem']=$elem;
		$this->load->view('orders/process_payment',$data); 
	}
	
		public function borderpdf($pdf){
	     $width=$pdf->GetPageWidth(); // Width of Current Page
        $height=$pdf->GetPageHeight(); // Height of Current Page
        $edge=2; // Gap between line and border , change this value
        $pdf->Line($edge, $edge,$width-$edge,$edge); // Horizontal line at top
        $pdf->Line($edge, $height-$edge,$width-$edge,$height-$edge); // Horizontal line at bottom
        $pdf->Line($edge, $edge,$edge,$height-$edge); // Vetical line at left 
        $pdf->Line($width-$edge, $edge,$width-$edge,$height-$edge); // Vetical line at Right
	}
	 public function order_inv_download($order_id,$cust_id='',$invType='')
    {
    //   ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $order_info =$this->orders_model->fetch_order_info($order_id);
		$order_info=(array)$order_info[0];
		$order_prods = $this->orders_model->fetch_order_products($order_id);
	   
	    $user_info = $this->orders_model->getUserInfo($order_info['order_user_id']);
	    

		$order_product_options =$this->orders_model->fetch_order_product_options($order_id);
        $addd_text = $user_info[0]->company_name.' | ABN : '. trim($user_info[0]->abn);
        
         $company_name = '';
	        $abn = '';
      
	    
       // Start generating the PDF
        $this->load->library('CustomFPDF');
        $pdf = $this->customfpdf->getInstance('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        // to draw border on page side
        $this->borderpdf($pdf);
        // Logo
        $pdf->Ln(-5);
        $pdf->Image('/home/healthychoicesca/public_html/manager/assets/images/logo.png',10, 6, 50);

        
        //$pdf->SetFont('Arial', 'B', 15);
        define('FPDF_FONTPATH', APPPATH . 'third_party/font/');
        $pdf->AddFont('Montserrat', '', 'montserrat.php');
        $pdf->AddFont('MontserratB', '', 'Montserrat-Bold.php');
        $pdf->SetTopMargin(2);
        $pdf->setFont('Montserrat', '', 8);
        // $pdf->Cell(185,7, $company_name.'  | ABN: '.$abn ,0,0,'R'); $pdf->Ln();
        $pdf->Cell(185 ,3,$addd_text ,0,0,'R'); $pdf->Ln(5);
        
        $pdf->setFont('MontserratB', '', 14);
        if($invType == 'creditnote'){
        $pdf->Cell(190, 10, ' Credit Note', 0, 0, 'C');    
        }else{
        $pdf->Cell(190, 10, ' Tax Invoice #'.$order_id, 0, 0, 'C');    
        }
        
        
        $pdf->Ln(10);
        $pdf->setFont('Montserrat', '', 14);

        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        // Header
        $pdf->SetFillColor(153, 230, 255);
        $pdf->SetTextColor(0,0,0);
        $pdf->setFont('MontserratB', '', 10);

       $pdf->Cell(95, 8, "Order Details", 0, 0, 'L', true);
$pdf->Cell(94, 8, "Customer Information", 0, 1, 'R', true);

$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->ln(16);

$pdf->SetFont("MontserratB", '', 8.5);
$pdf->Cell(25, 4, " ", 0, 0);

$pdf->SetFont("MontserratB", '', 8.5);
$pdf->Cell(150, 5, 'Deliver To', 0, 0, 'R');
$pdf->SetFont("Montserrat", '', 8.5);
$pdf->Cell(180, 5, $order_info['customer_order_name'].' |  '.$order_info['customer_order_telephone'], 0, 1, 'R');

$encodedString = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $order_info['delivery_address']);
$pdf->MultiCell(180, 5, ltrim($encodedString), 0, 'R');

$pdf->SetLeftMargin(10);

$length_del_addr = strlen($order_info['delivery_address']);
if ($length_del_addr > 49) {
    $pdf->Ln(-20);
} else {
    $pdf->Ln(-15);
}

$pdf->SetFont("MontserratB", '', 8.5);
$pdf->Cell(25, 4, "Invoice ID : ", 0, 0);
$pdf->SetFont("Montserrat", '', 9);
$pdf->Cell(10, 4, '      '.$order_id, 0, 1);

$pdf->SetFont("MontserratB", '', 8.5);
$pdf->Cell(25, 4, "Order Date : ", 0, 0, 'L', true);
$pdf->SetFont("Montserrat", '', 8.5);
$orderdate = date('g:i A, l - d M Y', strtotime($order_info['date_added']));
$pdf->Cell(35, 4, '      '.$orderdate, 0, 1);

if ($order_info['order_status'] == 3) {
    $paiddate = date('g:i A, l - d M Y', strtotime($order_info['date_modified']));
    $pdf->SetFont("MontserratB", '', 8.5);
    $pdf->Cell(25, 4, "Paid Date : ", 0, 0, 'L', true);
    $pdf->setFont("Montserrat", '', 8.5);
    $pdf->Cell(35, 4, '      '.$paiddate, 0, 1);
}

        if($order_info['shipping_method'] == 1){
         $sm =  "Delivery";
         }else{
         $sm =  "Pickup";
         }
     if($order_info['order_status'] == 3){
       $pm =  "Credit Card";
        }else{
       $pm = '';  
        }
        
        
        if($pm !=''){
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Payment Type : ", 0, 0, 'L', true);

        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $pm, 0, 0, 'L', true);
        $pdf->ln(5);
        }
        
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(30, 4, "Shipping Type : ", 0, 0, 'L', true);
         
         
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $sm, 0, 0, 'L', true);
        $pdf->ln(5);
       
        $delivery_date = date('g:i A, l - d M Y',strtotime($order_info['delivery_date_time']));
        $pdf->SetFont("MontserratB", '', 9);
        
        $pdf->Cell(30, 4, "Delivery Date :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, $delivery_date , 0, 0, 'L', true);
        
        
        if(isset($order_info['pickup_delivery_notes']) && $order_info['pickup_delivery_notes'] !=''){
        $pdf->ln();
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 8, "Delivery Notes :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $foo_pickup_delivery_notes = preg_replace('/\s+/', ' ', $order_info['pickup_delivery_notes']);
        $pdf->left_vcell(10, 8, $x_axis,$foo_pickup_delivery_notes);
        }
        
        if(isset($order_info['order_comments']) && $order_info['order_comments'] != '')
        {  $pdf->ln();
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 8, "Order Comments :", 0, 0, 'L', true);
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $pdf->left_vcell(10, 8, $x_axis,trim($order_info['order_comments']));
        $pdf->ln(-10);
        }
        
       $pdf->ln(32);

        // Colors, line width and bold font
        $pdf->SetFillColor(153, 230, 255);
        $pdf->SetTextColor(0,0,0);
        
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(.1);
        $pdf->SetFont('MontserratB', '');
        // Header
        // $header = ['Iten Name', 'Description','Comments','Qty','Price','Total'];
        $header = ['Item Name', 'Comments','Qty','Price','Total'];
        $w = array(64,  74, 18, 18,18);
        for ($i = 0; $i < count($header); $i++){
            if($i == 4 || $i == 3){
            //   to allign right the last header
            $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', true);
            }else{
               $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', true);
            }
        }
         $pdf->Ln();
        // // Color and font restoration
        $pdf->SetFillColor(255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Montserrat', '',8.5);
     
      $PrdctExcludedFromGST_DeductItsPrice = 0;
		foreach($order_prods as $order_prod){
		        $ordPrd = (array)$order_prod;
		        $mini_desc = "";
		        	
											
											
			    if(!empty($order_prod->product_description)){
                   $mini_desc .= '-- '.$order_prod->product_description;
                   $mini_desc .= "\n";  
                      }
             
            if(isset($order_prod->product_desc_1) && !empty($order_prod->product_desc_1)){
                   
                   for ($i = 1; $i < 6; $i++){
                       if($ordPrd['product_desc_'.$i] !=''){
                         $mini_desc .=  '-- '.$ordPrd['product_desc_'.$i];
			             $mini_desc .= "\n";  
                       }
                       } 
                       }
      
		    $allproducts[] = array(
		   'name' => $order_prod->product_name,
		   'order_product_comment' => $order_prod->order_product_comment,
		   'quantity' => $order_prod->quantity,
		   'price' => $order_prod->price,
		   'total' => $order_prod->total,
		   'option' => $order_prod->options,
		   'product_description'=> $mini_desc,
		   'exclude_GST'=> $order_prod->exclude_GST
		    
		    );
		   
		    unset($all_prod_descs);
		}
        $i= 1;   
         $pdf->SetWidths(array(64,74,18, 18,18));
	
        foreach ($allproducts as $p) {
            
            if($p['price'] == 0){
                $pdf->SetFont("Montserrat", '', 9);
                $qty = '';
                $price = '';
                $price_total= '';
            }else{
                $pdf->SetFont('Montserrat', '',8.5);
                $qty = $p['quantity'];
                if($invType=="creditnote"){
                 $price= "- $" . number_format($p['price'], 2);
                $price_total= "- $" .number_format($p['quantity']*$p['price'],2);  
                }else{
                 $price= "$" . number_format($p['price'], 2);
                $price_total= "$" .number_format($p['quantity']*$p['price'],2);  
                }
                
             }
               
             if($p['exclude_GST'] ==1){
               
						$PrdctExcludedFromGST_DeductItsPrice +=  $p['quantity']*$p['price'];
						
					}
              
            if($i % 2 == 0){
            $fill = true;
            }else{
             $fill = false;
            }
          $pdf->Row(array($p['name'],$p['order_product_comment'],$qty,$price,$price_total),$fill);
        
             if(!empty($p['option']) ){ 
                 
                $pdf->SetFont("Montserrat", '', 8.5);
                foreach ($p['option'] as $option) {
                $pdf->Ln(0.2);
                if($invType=="creditnote"){
          $pdf->Row(array('-- '.$option->option_name,'',$option->option_quantity,"-$" . number_format($option->option_price, 2),"-$" . number_format($option->option_price*$option->option_quantity, 2)));

                }else{
          $pdf->Row(array('-- '.$option->option_name,'',$option->option_quantity,"$" . number_format($option->option_price, 2),"$" . number_format($option->option_price*$option->option_quantity, 2)));
                }
                $pdf->Ln(1);
                }
                }

            if(!empty($p['product_description'])){
              $pdf->Ln(0.2);
            //   $pdf->Row(array($p['product_description'],'','','',''));
           
             $pdf->MultiCell(64, 5,$p['product_description'],0,'L');
               $len=  strlen($p['product_description']); 
            }
            $pdf->Ln(1);
            $i++;
           
        } 
       $pdf->SetFillColor(153, 230, 255);
        $pdf->Ln(4);
   

    if(!is_null($order_info['coupon_discount'])){
	if($order_info['type']=='F')
	$coupon_discount=$order_info['coupon_discount'];
	else{
	$total_so_far=$order_info['order_total']+$order_info['delivery_fee']+$order_info['late_fee'];
	$coupon_discount=($order_info['coupon_discount']*($total_so_far))/100;
	}
    }else{
     $coupon_discount = 0;
     }
       
        $tot = ($order_info['order_total'] + $order_info['delivery_fee'] + $order_info['late_fee']) - $coupon_discount;
        $gst = number_format(($tot-$PrdctExcludedFromGST_DeductItsPrice)/11,2, '.', '');
        
        // if(isset($len) && $len > 550){
        //     $pdf->Ln(7);
        // }
         $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(188, 0.5, "", 1, 1, 'C');
        $pdf->Ln(4);

        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Subtotal (inc GST): ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
         if($invType=="creditnote"){
             $minus_sign = '-';
         }else{
            $minus_sign = ''; 
         }
        $pdf->Cell($w[4]-2, 5, $minus_sign."$".number_format($order_info['order_total'],2), '', 1, 'R');
        
        if(isset($order_info['delivery_fee']) && $order_info['delivery_fee'] != 0 )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Delivery Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($order_info['delivery_fee'],2), '', 1, 'R');
        }else{
              $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Delivery Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$0.00", '', 1, 'R');
        }
        
        if(isset($order_info['late_fee']) && $order_info['late_fee'] != 0 )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Late Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($order_info['late_fee'],2), '', 1, 'R');
        }
        
        
        if(isset($coupon_discount) && $coupon_discount != '' )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Discount : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "-$".number_format($coupon_discount,2), '', 1, 'R');
        }
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "GST : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        // if($order_id == 11826 || $order_id == 11758 || $order_id == 11701 || $order_id == 11628 || $order_id == 11557 || $order_id == 10536 ){
        if($order_info['GST_status'] == 1){
             $pdf->Cell($w[4]-2, 5, "$".number_format(0, 2), '', 1, 'R');
        }else{
            $pdf->Cell($w[4]-2, 5, "$".number_format($gst, 2), '', 1, 'R');
        }

        if($order_info['order_status'] ==2){
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Amount Paid : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($tot, 2), '', 1, 'R');
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Balance Due : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$0", '', 1, 'R');
      
         }else{
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Total : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
      
        $pdf->Cell($w[4]-2, 5, $minus_sign."$".number_format($tot, 2), '', 1, 'R');
        $pdf->SetFont('Montserrat', '',6);
         }
         $pdf->SetFont('Montserrat', '',6);
         $pdf->Cell(170, 4, "All items are inclusive GST", '', 1, 'R');
         $pdf->SetFont('Montserrat', '',8.5);
         
         $pdf->Ln(4);
         $pdf->SetFillColor(153, 230, 255);
         $pdf->SetTextColor(0,0,0);
        
         $pdf->setFont('MontserratB', '', 10);

         $pdf->Cell(95, 8, "Payment Details", 0, 0, 'L', true);
         $pdf->Cell(94, 8, "Payment Terms", 0, 1, 'R', true);
         $pdf->SetFillColor(255);
          $pdf->SetTextColor(0);
         $pdf->Ln(4);
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "Account Number : ", 0, 0);

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '     '.$user_info[0]->account_number, 0, 0);
         
         $pdf->Ln(4);
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "BSB : ", 0, 0);
         

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '     '.$user_info[0]->bsb, 0, 0);
         $pdf->Ln(4);
          
          $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "Account Name : ", 0, 0);

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '      '.$user_info[0]->account_name, 0, 0);
         
         
        $pdf->Ln(-10);
        $pdf->SetFont("Montserrat", '', 8);
        $pdf->Cell(190, 6, "Payment must be made 7 days from the delivery date. Late payment fees will incur after 21 days.", 0, 0, 'R');
        
        $pdf->Ln(5);
        $email_length = strlen($user_info[0]->email);
        if($email_length > 30){
        $pdf->SetFont("Montserrat", '', 8);
        $pdf->Cell(123, 4, 'Please email the remittance to:   ', 0, 0,'R');
        $pdf->SetFont("MontserratB", '', 8);
        $pdf->Cell(67, 4,$user_info[0]->email, 0, 0,'R');     
        }else{
           $pdf->SetFont("Montserrat", '', 8);
        $pdf->Cell(138, 4, 'Please email the remittance to: ', 0, 0,'R');
        $pdf->SetFont("MontserratB", '', 8);
        $pdf->Cell(52, 4,$user_info[0]->email, 0, 0,'R');  
        }
       
        
        $pdf->Ln(4);
        $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(190, 4, 'Please ensure to add the Invoice Number in the Payment Reference', 0, 0,'R');
        

        $this->borderpdf($pdf);
        $pdf->Output();
    }
    	 public function quote_inv_download($order_id,$cust_id,$invType='')
    {
    //   ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
       
         $order_info =$this->orders_model->fetch_quote_info($order_id);
		$order_info=(array)$order_info[0];
		$order_prods = $this->orders_model->fetch_order_products($order_id);
	    $user_info = $this->orders_model->getUserInfo($order_info['order_user_id']);

		$order_product_options =$this->orders_model->fetch_order_product_options($order_id);
        $addd_text = $user_info[0]->user_com_addr;

       // Start generating the PDF
        $this->load->library('CustomFPDF');
        $pdf = $this->customfpdf->getInstance('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        // to draw border on page side
        $this->borderpdf($pdf);
        // Logo
        $pdf->Ln(-5);
        $pdf->Image('/home/healthychoicesca/public_html/manager/assets/images/logo.png',10, 6, 50);

        
        //$pdf->SetFont('Arial', 'B', 15);
        define('FPDF_FONTPATH', APPPATH . 'third_party/font/');
        $pdf->AddFont('Montserrat', '', 'montserrat.php');
        $pdf->AddFont('MontserratB', '', 'Montserrat-Bold.php');
        $pdf->SetTopMargin(2);
        $pdf->setFont('Montserrat', '', 8);
        $pdf->Cell(185,7, $user_info[0]->company_name.'  | ABN: '.$user_info[0]->abn ,0,0,'R'); $pdf->Ln();
        $pdf->Cell(185 ,3,$addd_text ,0,0,'R'); $pdf->Ln(5);
        
        $pdf->setFont('MontserratB', '', 14);
      $pdf->Cell(190, 10, ' Quote #'.$order_id, 0, 0, 'C'); 
        
        
        $pdf->Ln(10);
        $pdf->setFont('Montserrat', '', 14);

        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        // Header
        $pdf->SetFillColor(153, 230, 255);
         $pdf->SetTextColor(0,0,0);
       
        $pdf->setFont('MontserratB', '', 10);

        $pdf->Cell(95, 8, "Quote Details", 0, 0, 'L', true);
        
        $pdf->Cell(94, 8, "Customer Information", 0, 1, 'R', true);


        $pdf->SetFillColor(255);
 $pdf->SetTextColor(0);
        $pdf->ln("3");

        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, " ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      ', 0, 0);
        
        
        
        // right section in header start -------------------------start ---------------------------
        
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(154, 5, 'Bill To', 0, 1, 'R');
        $pdf->SetFont("Montserrat", '', 8.5);
        // $pdf->SetLeftMargin(70);
        $pdf->Cell(190, 5, $order_info['customer_order_name'].' |  '.$order_info['customer_order_telephone'], 0, 1, 'R');

       
        $pdf->Cell(190, 5, $order_info['customer_company_name'], 0, 1, 'R');
        // $x_axis=$pdf->getx();
        $pdf->Ln(0.1);
        $pdf->MultiCell(190, 5,$order_info['customer_company_addr'],0,'R');
        $pdf->Ln(5);
         
       
         
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(190, 5, 'Deliver To', 0, 1, 'R');
        $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(190, 5, $order_info['customer_order_name'].' |  '.$order_info['customer_order_telephone'], 0, 1, 'R');

      
        $pdf->MultiCell(190, 5,ltrim($order_info['delivery_address']),0,'R');
       
       
        $pdf->SetLeftMargin(10);
        
        //--- end--------------------------------------------------------------------------
       $length_del_addr =  strlen($order_info['delivery_address']);
       if($length_del_addr > 49){
           $pdf->Ln(-40);
       }else{
            $pdf->Ln(-30);
       }
       
      
       $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Quote ID : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_id, 0, 0);
         $pdf->ln(5);
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Quote Date : ", 0, 0, 'L', true);

        $pdf->SetFont("Montserrat", '', 8.5);
       
        $orderdate = date('g:i A, l - d M Y',strtotime($order_info['date_added']));
        $pdf->Cell(35, 4, '      '.$orderdate, 0, 0,'L',true);
        $pdf->ln(5);
        
        if($order_info['order_status'] == 2){
            
      
        $paiddate = date('g:i A, l - d M Y',strtotime($order_info['date_modified']));
       
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Paid Date : ", 0, 0, 'L', true);
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(35, 4, '      '.$paiddate, 0, 0, 'L', true);
        $pdf->ln(5);
        }
        
        if($order_info['shipping_method'] == 1){
         $sm =  "Delivery";
         }else{
         $sm =  "Pickup";
         }
     if($order_info['order_status'] == 2){
       $pm =  "Credit Card";
        }else{
       $pm = '';  
        }
        
        
        if($pm !=''){
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Payment Type : ", 0, 0, 'L', true);

        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $pm, 0, 0, 'L', true);
        $pdf->ln(5);
        }
        
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(30, 4, "Shipping Type : ", 0, 0, 'L', true);
         
         
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $sm, 0, 0, 'L', true);
        $pdf->ln(5);
       
        
       $delivery_date = date('d M Y h:i A',strtotime($order_info['delivery_date']));
        $pdf->SetFont("MontserratB", '', 9);
        
        $pdf->Cell(30, 4, "Delivery Date :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, $delivery_date , 0, 0, 'L', true);
        
        
        if(isset($order_info['pickup_delivery_notes']) && $order_info['pickup_delivery_notes'] !=''){
        $pdf->ln();
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 8, "Delivery Notes :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $pdf->left_vcell(10, 8, $x_axis,$order_info['pickup_delivery_notes']);
        }
        
        if(isset($order_info['order_comments']) && $order_info['order_comments'] != '')
        {  $pdf->ln();
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 8, "Quote  Comments :", 0, 0, 'L', true);
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $pdf->left_vcell(10, 8, $x_axis,$order_info['order_comments']);
        $pdf->ln(-10);
        }
        
       $pdf->ln(32);

        // Colors, line width and bold font
        $pdf->SetFillColor(153, 230, 255);
        $pdf->SetTextColor(0,0,0);
       
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(.1);
        $pdf->SetFont('MontserratB', '');
        // Header
        // $header = ['Iten Name', 'Description','Comments','Qty','Price','Total'];
        $header = ['Item Name', 'Comments','Qty','Price','Total'];
        $w = array(64,  74, 18, 18,18);
        for ($i = 0; $i < count($header); $i++){
            if($i == 4 || $i == 3){
            //   to allign right the last header
            $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', true);
            }else{
               $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', true);
            }
        }
         $pdf->Ln();
        // // Color and font restoration
        $pdf->SetFillColor(255);
         $pdf->SetTextColor(0);
        $pdf->SetFont('Montserrat', '',8.5);
     
      $PrdctExcludedFromGST_DeductItsPrice = 0;
		foreach($order_prods as $order_prod){
		        $ordPrd = (array)$order_prod;
		        $mini_desc = "";
		        	
											
											
			    if(!empty($order_prod->product_description)){
                   $mini_desc .= '-- '.$order_prod->product_description;
                   $mini_desc .= "\n";  
                      }
             
            if(isset($order_prod->product_desc_1) && !empty($order_prod->product_desc_1)){
                   
                   for ($i = 1; $i < 6; $i++){
                       if($ordPrd['product_desc_'.$i] !=''){
                         $mini_desc .=  '-- '.$ordPrd['product_desc_'.$i];
			             $mini_desc .= "\n";  
                       }
                       } 
                       }
      
		    $allproducts[] = array(
		   'name' => $order_prod->product_name,
		   'order_product_comment' => $order_prod->order_product_comment,
		   'quantity' => $order_prod->quantity,
		   'price' => $order_prod->price,
		   'total' => $order_prod->total,
		   'option' => $order_prod->options,
		   'product_description'=> $mini_desc,
		   'exclude_GST'=> $order_prod->exclude_GST
		    
		    );
		   
		    unset($all_prod_descs);
		}
        $i= 1;   
         $pdf->SetWidths(array(64,74,18, 18,18));
	
        foreach ($allproducts as $p) {
            
            if($p['price'] == 0){
                $pdf->SetFont("Montserrat", '', 9);
                $qty = '';
                $price = '';
                $price_total= '';
            }else{
                $pdf->SetFont('Montserrat', '',8.5);
                $qty = $p['quantity'];
                if($invType=="creditnote"){
                 $price= "- $" . number_format($p['price'], 2);
                $price_total= "- $" .number_format($p['quantity']*$p['price'],2);  
                }else{
                 $price= "$" . number_format($p['price'], 2);
                $price_total= "$" .number_format($p['quantity']*$p['price'],2);  
                }
                
             }
               
             if($p['exclude_GST'] ==1){
               
						$PrdctExcludedFromGST_DeductItsPrice +=  $p['quantity']*$p['price'];
						
					}
              
            if($i % 2 == 0){
            $fill = true;
            }else{
             $fill = false;
            }
          $pdf->Row(array($p['name'],$p['order_product_comment'],$qty,$price,$price_total),$fill);
        
             if(!empty($p['option']) ){ 
                 
                $pdf->SetFont("Montserrat", '', 8.5);
                foreach ($p['option'] as $option) {
                $pdf->Ln(0.2);
                if($invType=="creditnote"){
          $pdf->Row(array('-- '.$option->option_name,'',$option->option_quantity,"-$" . number_format($option->option_price, 2),"-$" . number_format($option->option_price*$option->option_quantity, 2)));

                }else{
          $pdf->Row(array('-- '.$option->option_name,'',$option->option_quantity,"$" . number_format($option->option_price, 2),"$" . number_format($option->option_price*$option->option_quantity, 2)));
                }
                $pdf->Ln(1);
                }
                }

            if(!empty($p['product_description'])){
              $pdf->Ln(0.2);
            //   $pdf->Row(array($p['product_description'],'','','',''));
           
             $pdf->MultiCell(64, 5,$p['product_description'],0,'L');
               $len=  strlen($p['product_description']); 
            }
            $pdf->Ln(1);
            $i++;
           
        } 
       $pdf->SetFillColor(153, 230, 255);
        $pdf->Ln(4);
   

    if(!is_null($order_info['coupon_discount'])){
	if($order_info['type']=='F')
	$coupon_discount=$order_info['coupon_discount'];
	else{
	$total_so_far=$order_info['order_total']+$order_info['delivery_fee'];
	$coupon_discount=($order_info['coupon_discount']*($order_info['order_total']+$order_info['delivery_fee']))/100;
	}
    }else{
     $coupon_discount = 0;
     }
       
        $tot = ($order_info['order_total'] + $order_info['delivery_fee'] + $order_info['late_fee']) - $coupon_discount;
        $gst = number_format(($tot-$PrdctExcludedFromGST_DeductItsPrice)/11,2, '.', '');
        
        // if(isset($len) && $len > 550){
        //     $pdf->Ln(7);
        // }
         $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(188, 0.5, "", 1, 1, 'C');
        $pdf->Ln(4);

        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Subtotal (inc GST): ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
         if($invType=="creditnote"){
             $minus_sign = '-';
         }else{
            $minus_sign = ''; 
         }
        $pdf->Cell($w[4]-2, 5, $minus_sign."$".number_format($order_info['order_total'],2), '', 1, 'R');
        
        if(isset($order_info['delivery_fee']) && $order_info['delivery_fee'] != 0 )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Delivery Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($order_info['delivery_fee'],2), '', 1, 'R');
        }else{
              $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Delivery Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$0.00", '', 1, 'R');
        }
        
        if(isset($order_info['late_fee']) && $order_info['late_fee'] != 0 )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Late Fee : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($order_info['late_fee'],2), '', 1, 'R');
        }
        
        
        if(isset($coupon_discount) && $coupon_discount != '' )
        {
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Discount : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "-$".number_format($coupon_discount,2), '', 1, 'R');
        }
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "GST : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($gst, 2), '', 1, 'R');

        if($order_info['order_status'] ==3){
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Amount Paid : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$".number_format($tot, 2), '', 1, 'R');
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Balance Due : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell($w[4]-2, 5, "$0", '', 1, 'R');
      
         }else{
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+$w[2]+14, 5, "Total : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
      
        $pdf->Cell($w[4]-2, 5, $minus_sign."$".number_format($tot, 2), '', 1, 'R');
        $pdf->SetFont('Montserrat', '',6);
         }
         $pdf->SetFont('Montserrat', '',6);
         $pdf->Cell(170, 4, "All items are inclusive GST", '', 1, 'R');
         $pdf->SetFont('Montserrat', '',8.5);
         
         $pdf->Ln(4);
         $pdf->SetFillColor(153, 230, 255);
         $pdf->SetTextColor(0,0,0);
         $pdf->setFont('MontserratB', '', 10);

        
        $this->borderpdf($pdf);
        $pdf->Output();
    }


	
	
	
	public function front_end_order_inv_download($order_id,$cust_id){
	    
	   // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	       if (isset($order_id)) {
	      
	       $order_info = $this->orders_model->getOrder($order_id);
	       $order_info =  (array)$order_info[0];
	     
           $user_info = $this->orders_model->getUserInfo($order_info['user_id']); 
           
	       $products = $this->orders_model->getOrderProducts($order_id);
		   $order_option_val =  array();
           $ar = array();
           
		 foreach ($products as $product) {
		  	        
		 $order_prod_descr = 	$this->orders_model->getOrderProductsDescrption($product->product_id);
			   
		 $order_option_values = 	$this->orders_model->getOrderOptions($order_id, $product->order_product_id);
		    	
	     $order_option_values  = json_decode(json_encode($order_option_values), True);
			    	
			    
			    $i =0;
			    if(!empty($order_option_values)) {
			        
				foreach ($order_option_values as $order_option_value) {
				    
				    $ar[] =  $this->orders_model->getOrderOptions_value($order_option_value['product_option_id'], $order_option_value['product_option_value_id']);
				    
				    $ar  = json_decode(json_encode($ar), True);
				$order_option_values[$i]['price'] = $ar[0][0]['price'];
				unset($ar);
				  $i++;
				}
				}
				
               $order_prod_descr  = json_decode(json_encode($order_prod_descr), True);
			    
				$allproducts[] = array(
					'product_id' => $product->product_id,
					'name'       => $product->name,
					'model'      => $product->model,
					'descr'     =>  $order_prod_descr,
					'option'     => $order_option_values,
					'quantity'   => $product->quantity,
					'price'      => $product->price,
					'total'      => $product->total,
					'reward'     => $product->reward,
					'addons'     => $product->addons
				);
				
			    }

	       $order_totals = $this->orders_model->getOrderTotals($order_id);
	      
			foreach ($order_totals as $order_total) {
				$curent_order_totals[] = array(
					'title' => $order_total->title,
					'text'  => $order_total->value
				);
			}
	         
	        
	    $this->load->library('CustomFPDF');
        $pdf = $this->customfpdf->getInstance('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        // to draw border on page side
        $this->borderpdf($pdf);
        
        $pdf->Ln(-5);
        $pdf->Image('/home/healthychoicesca/public_html/manager/assets/images/logo.png',10, 6, 50);
	    $addd_text = $user_info[0]->user_com_addr;
	    if (isset($order_id)) {
	        
	    $this->session->data['customer_id'] = $cust_id;
	    define('FPDF_FONTPATH', APPPATH . 'third_party/font/');
        $pdf->AddFont('Montserrat', '', 'montserrat.php');
        $pdf->AddFont('MontserratB', '', 'Montserrat-Bold.php');
        $pdf->SetTopMargin(2);
        $pdf->setFont('Montserrat', '', 8);
        $pdf->Cell(185,7,$user_info[0]->company_name.'  | ABN:  '.$user_info[0]->abn,0,0,'R');
        $pdf->Ln();
        $pdf->Cell(185 ,3,$addd_text ,0,0,'R'); $pdf->Ln(5);
        
        
        $pdf->setFont('MontserratB', '', 14);
        $pdf->Cell(190, 10, ' Tax Invoice #'.$order_id, 0, 0, 'C');
        
        $pdf->Ln(10);
        $pdf->setFont('Montserrat', '', 14);

        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
     // Header
       $pdf->SetFillColor(153, 230, 255);
       $pdf->SetTextColor(0,0,0);
        
        $pdf->setFont('MontserratB', '', 10);

        $pdf->Cell(95, 8, "Order Details", 0, 0, 'L', true);
        
        $pdf->Cell(94, 8, "Customer Information", 0, 1, 'R', true);


        $pdf->SetFillColor(255);
        $pdf->SetTextColor(0);
        $pdf->ln("3");

        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Invoice ID : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_id, 0, 0);
        
        // right section in header start -------------------------start ---------------------------
        
          $s_addr = $order_info['shipping_address_1'].' ' .$order_info['shipping_address_2'];
        
        $delivery_array = str_split($s_addr, 50);
        $size = sizeof($delivery_array);
        $address_del = '';
         for($i = 0;$i<$size;$i++){
             if($i > 0){
                  $address_del .= "\n".$delivery_array[$i]; 
             }else{
                  $address_del .= $delivery_array[$i]; 
             }
         }
       
        
        $pdf->SetFont("MontserratB", '', 8.5);
       
        $pdf->Cell(156, 5, 'Deliver To', 0, 1, 'R');
        $pdf->Ln(0.1);
         $pdf->SetFont("Montserrat", '', 8.5);
         
        $pdf->Cell(190, 5, $order_info['firstname']. ' '.$order_info['lastname'].' |  '.$order_info['telephone'], 0, 1, 'R'); 
        $pdf->Ln(0.5);
        $encodedString = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $address_del);
        $pdf->MultiCell(190, 5, ltrim($encodedString), 0, 'R');
       
        
        if($order_info['shipping_gate_number'] != ''){
            $pdf->MultiCell(190, 5,'Gate No: '.$order_info['shipping_gate_number'],0,'R');
        }
        if($order_info['shipping_building_number'] != ''){
            $pdf->MultiCell(190, 5,'Building number: '.$order_info['shipping_building_number'],0,'R');
        }
        if($order_info['shipping_department_name'] != ''){
            $pdf->MultiCell(190, 5,'Department name: '.$order_info['shipping_department_name'],0,'R');
        }
        if($order_info['shipping_level_of_building'] != ''){
            $pdf->MultiCell(190, 5,'Level of building: '.$order_info['shipping_level_of_building'],0,'R');
        }
        if($order_info['shipping_room_number'] != ''){
            $pdf->MultiCell(190, 5,'Room number: '.$order_info['shipping_room_number'],0,'R');
        }
        if($order_info['shipping_business_name'] != ''){
            $pdf->MultiCell(190, 5,'Business Name: '.$order_info['shipping_business_name'],0,'R');
        }
        if($order_info['shipping_street_number'] != ''){
            $pdf->MultiCell(190, 5,'Street Number: '.$order_info['shipping_street_number'],0,'R');
        }
        if($order_info['shipping_delivery_contact_name'] != ''){
            $pdf->MultiCell(190, 5,'Delivery contact name: '.$order_info['shipping_delivery_contact_name'],0,'R');
        }
        if($order_info['shipping_delivery_contact_number'] != ''){
            $pdf->MultiCell(190, 5,'Delivery contact number: '.$order_info['shipping_delivery_contact_number'],0,'R');
        }
       
        $pdf->SetLeftMargin(10);
        
        //--- end--------------------------------------------------------------------------
        
          $pdf->Ln(-10);
      
     
        $orderdate = date('g:i A, l - d M Y',strtotime($order_info['date_added']));
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Order Date : ", 0, 0, 'L', true);

        $pdf->SetFont("Montserrat", '', 8.5);
       
        $pdf->Cell(35, 4, '      '.$orderdate, 0, 0,'L',true);
        $pdf->ln(5);
        
        if($order_info['order_status'] == 2){
            
      
       $paiddate = date('g:i A, l - d M Y',strtotime($order_info['date_modified']));
       
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Paid Date : ", 0, 0, 'L', true);
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(35, 4, '      '.$paiddate, 0, 0, 'L', true);
        $pdf->ln(5);
        }
        
       if($order_info['shipping_method'] == 'Pickup'){
    
       $sm = "Pickup/Delivery Inside the Premises";  
        }else{
       $sm = $order_info['shipping_method'];
       }

       if($order_info['payment_method'] == 'Securepay'){
       $pm =  "Credit Card";
        }else{
        $pm = $order_info['payment_method'];
        }
        // echo $order_info['order_status']; exit;
        
        if($pm !=''){
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Payment Type : ", 0, 0, 'L', true);

        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $pm, 0, 0, 'L', true);
        $pdf->ln(5);
        }
        
        if($order_info['payment_method'] != 'Securepay'){
             $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Account Number : ", 0, 0, 'L', true);
           $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $order_info['account_number'], 0, 0, 'L', true);
        $pdf->ln(5);  
        }
        
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(30, 4, "Shipping Type : ", 0, 0, 'L', true);
         
         
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $sm, 0, 0, 'L', true);
        $pdf->ln(5);
        
      
        $delivery_date = date('g:i A, l - d M Y',strtotime($order_info['delivery_date']));
      
       
        $pdf->SetFont("MontserratB", '', 9);
        
        $pdf->Cell(30, 4, "Delivery Date :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, $delivery_date , 0, 0, 'L', true);
        
        
        if(isset($order_info['comment']) && $order_info['comment'] !=''){
        $pdf->ln();
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 8, "Delivery Notes :", 0, 0, 'L', true);
        
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $pdf->left_vcell(10, 8, $x_axis,$order_info['comment']);
        }
        
       
        
       $pdf->ln(10);
       
       // Colors, line width and bold font
        $pdf->SetFillColor(153, 230, 255);
        $pdf->SetTextColor(0,0,0);
       
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(.1);
        $pdf->SetFont('MontserratB', '');
        // Header
        // $header = ['Iten Name', 'Description','Comments','Qty','Price','Total'];
        $header = ['Item Name', 'Qty','Price','Total'];
        $w = array(130, 20, 20,20);
        for ($i = 0; $i < count($header); $i++){
            if($i == 2 || $i == 3){
            //   to allign right the last header
            $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'C', true);
            }else{
               $pdf->Cell($w[$i], 7, $header[$i], 0, 0, 'L', true);
            }
        }
         $pdf->Ln();
        // // Color and font restoration
        $pdf->SetFillColor(255);
         $pdf->SetTextColor(0);
        $pdf->SetFont('Montserrat', '',8.5);



}
   $i= 1;   $pdf->SetWidths(array(134,20, 20,20));
  foreach ($allproducts as $key=> $product) { 

      if($product['price'] == 0 && $product['quantity'] == 0){
                $pdf->SetFont("Montserrat", '', 9);
                $qty = '';
                $price = '';
                $price_total= '';
            }else{
                $pdf->SetFont('Montserrat', '',8.5);
                $qty = $product['quantity'];
               // for those option whch has no price added from admin very rare case like prdct id 331 chk
                if($product['price'] == 0){
                    $price = $product['total'] / $product['quantity'];
                    $price= "$" . number_format($price, 2);
                   $price_total= "$" .number_format($product['total'],2); 
                }else{
                    $price= "$" . number_format($product['price'], 2);
                  $price_total= "$" .number_format($product['quantity']*$product['price'],2);  
                }
             }
             
            if($i % 2 == 0){
            $fill = true;
            }else{
             $fill = false;
            }
            $pdf->SetWidths(array(134,20, 20,20));
             $pdf->Row(array($product['name'],$qty,$price,$price_total),$fill);
             
             if(!empty($product['option']) ){ 
                 $pdf->SetFont("Montserrat", '', 8.5);
                 $pdf->SetWidths(array(114,20, 20,20));
                
                foreach ($product['option'] as $option) {
                    
                       // to  display addons qty as addon qty is same prdct qty always
                    if((isset($product['addons']) && $product['addons'] =='Yes' ) || $option['option_qty'] == ''){
                       $extra_qty =  $qty;
                        $pdf->Ln(0.2);
                    $pdf->Row(array('-- '.htmlspecialchars_decode($option['name']).":".htmlspecialchars_decode(str_replace("-", " ", $option['value'])),'',$extra_qty," " ," "));
                    }else{
                        if($option['name'] == 'Package Comments'){
                            $pdf->Ln(0.2);
                            $pdf->Row(array('-- '.htmlspecialchars_decode($option['name'])." : ".htmlspecialchars_decode(str_replace("-", " ", $option['value'])) ));
                        }else{
                            $extra_qty =  $option['option_qty'];
                            $pdf->Ln(0.2);
                            $pdf->Row(array('-- '.htmlspecialchars_decode($option['name']).":".htmlspecialchars_decode(str_replace("-", " ", $option['value'])),'',$extra_qty,"$" . number_format($option['option_price'], 2),"$" . number_format($option['option_price']*$extra_qty, 2)));
                    
                        }
                        }
               
                $pdf->Ln(1);
                }
                }
           
                  if(isset($product['descr'])){
                       $pdf->SetWidths(array(114,20, 20,20));
                        for($i = 1;$i < 6; $i++){
                       
                         if(!empty($product['descr'][0]['desc_'.$i])){
                             
                             $prd_desc_dta .= "-- ".$product['descr'][0]['desc_'.$i];
                             $prd_desc_dta .= "\n"; 
                              }
                           }
                           
                           $pdf->Row(array($prd_desc_dta,'','','',''));
                            }
                      $pdf->Ln(-1);
                      $i++;
                } 
           
  $pdf->SetFillColor(255, 255, 255);
        $pdf->Ln(6.5);
     $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(188, 0.5, "", 1, 1, 'C');
        $pdf->Ln(4);
	     
foreach($curent_order_totals as $key => $order_total){
   if($order_total['title'] == 'Total'){
        $tot = $order_total['text'];
        $gst =  number_format(($order_total['text']/11),2);
    
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "GST : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".$gst, '', 1, 'R');
        
    }
   $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, $order_total['title']." : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".number_format($order_total['text'],2), '', 1, 'R');
  

   
    
    $c++;
    
}

if($order_info['order_status_id']==2){
    
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "Amount Paid : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".number_format($tot, 2), '', 1, 'R');
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "Balance Due : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$0", '', 1, 'R');


}
       
        
         $pdf->SetFont('Montserrat', '',6);
         $pdf->Cell(165, 4, "All items are inclusive GST", '', 1, 'R');
         $pdf->SetFont('Montserrat', '',8.5);
         
        $pdf->SetAutoPageBreak(true,0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Ln(4);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(188, 0.5, "", 1, 1, 'C');
        $pdf->Ln(4);
         $pdf->Ln(4);
         $pdf->Ln(4);
         $pdf->SetFillColor(153, 230, 255);
           $pdf->SetTextColor(0,0,0);
         $pdf->setFont('MontserratB', '', 10);

         $pdf->Cell(95, 8, "Payment Details", 0, 0, 'L', true);
         $pdf->Cell(94, 8, "Payment Terms", 0, 1, 'R', true);
         $pdf->SetFillColor(255);
           $pdf->SetTextColor(0);
         $pdf->Ln(4);
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "Account Number : ", 0, 0);

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '     '.$user_info[0]->account_number, 0, 0);
         
         $pdf->Ln(4);
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "BSB : ", 0, 0);
         

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '     033 157'.$user_info[0]->bsb, 0, 0);
         $pdf->Ln(4);
          
          $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(25, 4, "Account Name : ", 0, 0);

         $pdf->SetFont("Montserrat", '', 9);
         $pdf->Cell(10, 4, '     '.$user_info[0]->account_name, 0, 0);
         
         
        $pdf->Ln(-10);
        $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(190, 4, "Payment must be made within 7 days from the Order Date", 0, 0, 'R');
        
        $pdf->Ln(4);
        $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(125, 4, 'Please email the remittance to: ', 0, 0,'R');
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(65, 4, $user_info[0]->email, 0, 0,'R');
        
        
        
        $pdf->Ln(4);
        $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(190, 4, 'Please ensure to add the Invoice Number in the Payment Reference', 0, 0,'R');
        

   
        $this->borderpdf($pdf);
        $pdf->Output();
	
	
	}
	
}


	
	
	
	public function get_order_by_user($user_id,$toemail)
	{
	    
	   $all_users_orders = $this->orders_model->getall_user_order($user_id); 
	   
	   $frontend_all_users_orders = $this->orders_model->getall_user_order_frontend($user_id);
	   
	      
	   $all_users_orders = array_merge($all_users_orders,$frontend_all_users_orders);
	 
	   
	    
	    if(!empty($all_users_orders)){
	       
	        
	        $i = 0;
	        foreach($all_users_orders as $row){
	            
	            if(isset($row->delivery_phone) && empty($row->delivery_phone))
					$phone=$row->telephone;
				else 
					$phone=$row->delivery_phone;
				if(isset($row->email) && empty($row->email))
					$email=$row->email;
				else
					$email=$row->email;
				if(isset($row->coupon_id) && empty($row->coupon_id)){
				
				if(empty($row->coupon_id))
			$discount=0;
		else{
			if($row->type=='F')
				$discount=$row->coupon_discount;
			else $discount=($row->order_total+$row->late_fee+$row->delivery_fee)*$row->coupon_discount/100;
		}
		$total=(int)(($row->order_total+$row->late_fee+$row->delivery_fee-$discount)*100);
				} 
				if(isset($row->order_total)){
				    $order_total =$row->order_total; 
				    
				}else{
				    
				     $order_total =$row->total; 
				}
	           
	           $gst = $order_total/11;
	           
	           
				 if(isset($row->order_status_id) &&  $row->order_status_id == 3){
				     
	                 $paid_date = $row->date_modified;
	                  
				    }else{
				       $paid_date = ''; 
				        
				    }
				    
				    if(isset($row->order_status) &&  $row->order_status == 3){
				     
	                 $paid_date = $row->date_modified;
	                  
				    }else{
				        
				          $paid_date = ''; 
				    }
	           
	           
	           
	           
	           
	           
	           
	            
	           
			 if($i==0){
			     
			 $path=$_SERVER["DOCUMENT_ROOT"];
	       
	          $file = '/home/healthychoicesca/public_html/manager/paid_orders.csv';
			
                 header("Content-Description: File Transfer");
                 header("Content-Disposition: attachment; filename= paid_orders.csv");
                 header("Content-Type: application/csv; ");
          
                $files = fopen($file, 'w');
                $status = 'Paid';
                
                fputcsv($files,array("Order #","Order Date","Customer","Department","Company","Cost Centre","Phone","Email","Subtotal","Discount","Delivery","Total","GST","Status","Paid Comment","Paid Date","Username"));
               }
	    
			 $i++;
			 
			 fputcsv($files,array($row->order_id,$row->date_added,$row->firstname,$row->lastname,$row->company_name,$row->cost_centre,$phone,$email,"$".number_format($order_total,2),"$".number_format($discount,2),"$".number_format($del_fee,2),"$".number_format($order_total,2),"$".number_format($gst,2),$status,$comment,$paid_date,$row->username));
	    }
	    
			  
			    
			}else{
			    return false;
			}
			
			
			   fclose($files);
        
		  $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            
           
             $date_today = date('d-m-Y');
             
           
             
            $this->email->initialize($config);
            $this->email->to($toemail);
            $this->email->from($this->fromEmail, 'Healthy Choices Catering');
            $this->email->subject('Healthy Choices Catering');
            $this->email->message("Paid orders ( ".$date_today." )");
             $this->email->attach($file);
            
            $mail = $this->email->send();
            if($mail) {
               echo "Mail sent";
            } 
	 
	    
	}
	
	

}
