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
		$this->fromEmail = 'info@1800mycatering.com.au';
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
	    
	
	
	
	
	public function sample_query(){
	   //$records =  $this->orders_model->filter_sample_query('delete_duplicate');
	  
	    $records=$this->orders_model->filter_sample_query();
	    foreach($records as $record){
	        
	    $this->db->query("UPDATE sample SET quantity=1 WHERE OrderID=".$record->OrderID);
	   
	    }
	    
	    if(empty($records)){
	        
	         $query=$this->db->query("SELECT * FROM sample ");
	    	$records= $query->result();
	        $data['records'] = $records;
	    }
	    
	    
	    $this->load->view('orders/tabledata',$data);
	    
	   
	}
	
	
	
	
	
	
	public function view_all_feedback($date_from='',$date_to='')
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
			
		       if($order_no!='')
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
			$this->load->view('general/header');
			$this->load->view('orders/production',$data);
			$this->load->view('general/footer');	
		}
		else redirect('general/index');
	}
	public function open_dash($branch_id='')
	{ 
	    
		if(!empty($this->session->userdata('username')))
		{
		    if($this->session->userdata('is_customer') == 1){
		        redirect('orders/order_history');
		    }else{
		   
		      //  $this->session->set_userdata('branch_id',(int)$branch_id);
		      //  $this->session->set_userdata('user_id',(int)$branch_id);
		     
		        
// 		        ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// 		        $this->load->model('general_model');
//     						$par = array();
// 			$backend_orders =$this->general_model->fetch_dash_data();
// 			$data['deliveries_today'] = $backend_orders['deliveries_today'];
// 			$data['deliveries_this_month'] = $backend_orders['deliveries_this_month'];
// 			$data['revenue_this_month'] = $backend_orders['revenue_this_month'];
// 			$data['total_unpaid'] = $backend_orders['total_unpaid'];
			
// 			$frontend_orders=$this->orders_model->getOrders($par,'future_order');
			
// 			$data['orders'] = $data['frontend_orders'];
			
// 		$data['all_orders'] = array_merge($backend_orders['last_five'],$frontend_orders);
		
// 		$data['all_orders']  = json_decode(json_encode($data['all_orders']), True);
		

//       $keys = array_column($data['all_orders'], 'order_id');

//       array_multisort($keys, SORT_DESC, $data['all_orders']);
      
//       // convert array to object not required but as used on view file so....
       
//       $data['last_five'] = json_decode(json_encode($data['all_orders']));
     
		
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
             $sort[$key] = $part['order_id'];
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
	

	// just for test not in regular use
	public function insert_orders(){
	    
	    
	    $done = $this->orders_model->insert_orders();
	    
	    
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
             $sort[$key] = $part['order_id'];
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
	    $this->load->model('general_model');
	    $data['categories']=$this->general_model->fetch_categories();
		$data['suppliers']=$this->general_model->fetch_all_suppliers();
	    
	    $order_infoo =$this->orders_model->fetch_quote_info($order_id);
	    $data['order_products']=$this->orders_model->fetch_order_products($order_id);
	    
		$data['order_info'] = $order_infoo;
// 		echo "<pre>";print_r($data);exit;
		$this->load->view('general/header');
		$this->load->view('orders/view_quote',$data); 
		$this->load->view('general/footer');
		
	   
	}	
	
	public function send_offer_mail($order_id,$supplier_name)
	{
	    $email = $_POST['email'];
	   $supplier_name = str_replace("%20"," ",$supplier_name);
	    
		$mailData = array(
		    'order_id' => $order_id,
		    'supplier_name' => $supplier_name,
		    );
		$body = $this->load->view('orders/reorder_email', $mailData,TRUE);
            $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            $this->email->to($email);
            $this->email->from($this->fromEmail, 'Nach Food Co. ');
            $this->email->subject('Nach Food Co.');
            $this->email->message($body);
            $mail = $this->email->send();
            if($mail) {
                $this->orders_model->order_status_update($order_id,'2');
                redirect('orders/quote_history');
                	
            } else {
                redirect('orders/quote_history');
            }
		
	   
	}

	public function new_quote_save()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$this->load->model('general_model');
			$data['categories']=$this->general_model->fetch_categories();
			$data['suppliers']=$this->general_model->fetch_suppliers();
			$this->load->view('general/header');
			$this->load->view('orders/offer_request',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function suppliers()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$this->load->model('general_model');
			$data['suppliers']=$this->general_model->fetch_suppliers();
			$this->load->view('general/header');
			$this->load->view('orders/suppliers',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function add_supplier()
	{
		if(!empty($this->session->userdata('username')))
		{
		    if(isset($_POST['submit_btn'])){
		        
		       
		       $postData = array(
		           'supplier_name' => $_POST['supplier_name'],
		           'email_address' => $_POST['email_address'],
		           'contact_number' => $_POST['contact_number'],
		           'supplier_address' => $_POST['supplier_address'],
		           'suburb' => $_POST['suburb'],
		           'state' => $_POST['state'],
		           'pincode' => $_POST['pincode'],
		           );
		      $res = $this->orders_model->save_supplier($postData);
		      
		       redirect('orders/suppliers');
		    }else{
		        
		        $data['form_type'] = 'add';
		        $this->load->view('general/header');
    			$this->load->view('orders/add_supplier',$data);
    			$this->load->view('general/footer');
		    }
			
		}
		else redirect('general/index');
	}
	public function view_supplier($supplier_id)
	{
		if(!empty($this->session->userdata('username')))
		{
		    $this->load->model('general_model');
		    $data['supplier'] = $this->general_model->fetch_suppliers($supplier_id);
		    $data['form_type'] = 'view';
	        $this->load->view('general/header');
			$this->load->view('orders/add_supplier',$data);
			$this->load->view('general/footer');
		    
			
		}
		else redirect('general/index');
	}
	public function edit_supplier($supplier_id='')
	{
		if(!empty($this->session->userdata('username')))
		{
		    if(isset($_POST['submit_btn'])){
		       $supplier_id = $_POST['supplier_id'];
		       $postData = array(
		           'supplier_name' => $_POST['supplier_name'],
		           'email_address' => $_POST['email_address'],
		           'contact_number' => $_POST['contact_number'],
		           'supplier_address' => $_POST['supplier_address'],
		           'suburb' => $_POST['suburb'],
		           'state' => $_POST['state'],
		           'pincode' => $_POST['pincode'],
		      );
		      
		      $res = $this->orders_model->update_supplier($postData,$supplier_id);
		       
		       redirect('orders/suppliers');
		    }else{
		        $this->load->model('general_model');
		        $data['supplier'] = $this->general_model->fetch_suppliers($supplier_id);
		        $data['form_type'] = 'edit';
		        $this->load->view('general/header');
    			$this->load->view('orders/add_supplier',$data);
    			$this->load->view('general/footer');
		    }
			
		}
		else redirect('general/index');
	}
	public function saveSupplier()
	{   
	    $supplier_name = $_POST['supplierNameval'];
	    $supplier_address = $_POST['supplierAddressval'];
	    $this->load->model('general_model');
		$res = $this->general_model->save_suppliers($supplier_name,$supplier_address);
		if($res){
		    echo $res;
		}else{
		    echo "error";
		}
	}
	public function delete_supplier()
	{
        $this->orders_model->delete_supplier($_POST['supplier_id']);
        redirect('orders/suppliers');
	}
	
	public function fetch_suppliers()
	{   
	    $supplier_id = $_POST['supplierval'];
	     $this->load->model('general_model');
	    $suppliers=$this->general_model->fetch_suppliers($supplier_id);
	    echo json_encode($suppliers);
	}
	public function category_listing()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$this->load->model('general_model');
			$data['record']=$this->general_model->fetch_categories();
			$this->load->view('general/header');
			$this->load->view('orders/category_listing',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function add_category()
	{
		if(!empty($this->session->userdata('username')))
		{
		    if(isset($_POST['submit_btn'])){
		        
		       
		       $postData = array(
		           'category_name' => $_POST['category_name'],
		           'date_added' => date('Y-m-d'),
		           );
		      $this->load->model('general_model');
			  $this->general_model->save_category($postData);
		      
		       redirect('orders/category_listing');
		    }else{
		        
		        $data['form_type'] = 'add';
		        $this->load->view('general/header');
    			$this->load->view('orders/add_category',$data);
    			$this->load->view('general/footer');
		    }
			
		}
		else redirect('general/index');
	}
	public function view_category($category_id)
	{
		if(!empty($this->session->userdata('username')))
		{
		    $this->load->model('general_model');
		    $data['record'] = $this->general_model->fetch_categories($category_id);
		    $data['form_type'] = 'view';
	        $this->load->view('general/header');
			$this->load->view('orders/add_category',$data);
			$this->load->view('general/footer');
		    
			
		}
		else redirect('general/index');
	}
	public function edit_category($category_id='')
	{
		if(!empty($this->session->userdata('username')))
		{
		    if(isset($_POST['submit_btn'])){
		       $category_id = $_POST['category_id'];
		       $postData = array(
		           'category_name' => $_POST['category_name'],
		           'date_updated' => date('Y-m-d'),
		      );
		      
		        $this->load->model('general_model');
		        $this->general_model->update_category($postData,$category_id);
		       
		       redirect('orders/category_listing');
		    }else{
		        $this->load->model('general_model');
		        $data['record'] = $this->general_model->fetch_categories($category_id);
		        $data['form_type'] = 'edit';
		        $this->load->view('general/header');
    			$this->load->view('orders/add_category',$data);
    			$this->load->view('general/footer');
		    }
			
		}
		else redirect('general/index');
	}
	public function delete_category()
	{
        $this->load->model('general_model');
		$this->general_model->delete_category($_POST['category_id']);
        redirect('orders/category_listing');
	}
	public function save_new_quote(){
	    
	    $data['reference_number']=$_POST['reference_number'];
	
		$data['supplier']=$_POST['supplier'];
		$supplier_email_address=$_POST['supplier_email_address'];
		$data['order_date']=date("Y-m-d H:i",strtotime($_POST['date']));;
		$data['fob_fas']=$_POST['fob_fas'];
		$data['container_size']=$_POST['container_size'];
		$data['container_supply_qty']=$_POST['container_supply_qty'];
		$data['container_qty']=$_POST['container_qty'];
		$data['marks']=$_POST['marks']; 
		$data['port_loading']=$_POST['port_loading']; 
		$data['port_discharge']=$_POST['port_discharge']; 
		$data['final_destination']=$_POST['final_destination']; 
		$data['customer_name']=$_POST['customer_name']; 
		$data['request_number']=$_POST['request_number']; 
		$data['comments']=$_POST['comments'];
		$data['shipment_period']=$_POST['shipment_period'];
		$data['payment_terms']=$_POST['payment_terms'];
		$data['market']=serialize($_POST['market']);
		
		
		$product_name=$_POST['product_name']; 
		$product_volume=$_POST['product_volume']; 
		$category=$_POST['category']; 
		$product_comment=$_POST['product_comment']; 
		
		$count = count($product_name);
		for($i=0;$i<$count;$i++){
		    $productsData[] = array(
		        'product_name' => $product_name[$i],
		        'product_volume' => $product_volume[$i],
		        'category' => $category[$i],
		        'product_comment' => $product_comment[$i],
		        );
		}
		$data['products'] = $productsData;
// 		echo "<pre>";print_r($data);
		$order_id=$this->orders_model->save_new_quote($data);
		
// 		$order_id;
// 		$this->load->model('general_model');
// 	    $suppliers=$this->general_model->fetch_suppliers($_POST['supplier']);
	    
	    
// 		$mailData = array(
// 		    'order_id' => $order_id,
// 		    'supplier_name' => $suppliers[0]->supplier_name,
// 		    );
// 		$body = $this->load->view('orders/reorder_email', $mailData,TRUE);
//             $config=array(
//             'charset'=>'utf-8',
//             'wordwrap'=> TRUE,
//             'mailtype' => 'html'
//             );
            
//             $this->email->initialize($config);
            
//             $this->email->to($suppliers[0]->email_address);
//             $this->email->from($this->fromEmail, 'Nach Food Co. ');
//             $this->email->subject('Nach Food Co.');
//             $this->email->message($body);
//             $mail = $this->email->send();
//             if($mail) {
//                 redirect('orders/quote_history');
                	
//             } else {
                redirect('orders/quote_history');
//             }
	
	}
	public function update_quote($order_id='')
	{
		if(!empty($this->session->userdata('username')))
		{
		    if(isset($_POST['order_id']) && $_POST['order_id'] != ''){
		        $order_id = $_POST['order_id'];
		        $data['reference_number']=$_POST['reference_number'];
	
        		$data['supplier']=$_POST['supplier'];
        		$supplier_email_address=$_POST['supplier_email_address'];
        		$data['order_date']=date("Y-m-d H:i",strtotime($_POST['date']));;
        		$data['fob_fas']=$_POST['fob_fas'];
        		$data['container_size']=$_POST['container_size'];
        		$data['container_supply_qty']=$_POST['container_supply_qty'];
        		$data['container_qty']=$_POST['container_qty'];
        		$data['marks']=$_POST['marks']; 
        		$data['port_loading']=$_POST['port_loading']; 
        		$data['port_discharge']=$_POST['port_discharge']; 
        		$data['final_destination']=$_POST['final_destination']; 
        		$data['customer_name']=$_POST['customer_name']; 
        		$data['request_number']=$_POST['request_number']; 
        		$data['comments']=$_POST['comments'];
        		$data['shipment_period']=$_POST['shipment_period'];
        		$data['payment_terms']=$_POST['payment_terms'];
        		$data['market']=serialize($_POST['market']);
        		
        		$order_product_id =$_POST['order_product_id']; 
        		$product_name=$_POST['product_name']; 
        		$product_volume=$_POST['product_volume']; 
        		$category=$_POST['category']; 
        		$product_comment=$_POST['product_comment']; 
        		$count = count($order_product_id);
        		for($i=0;$i<$count;$i++){
        		    $productsData[] = array(
        		        'order_product_id' => $order_product_id[$i],
        		        'product_name' => $product_name[$i],
        		        'product_volume' => $product_volume[$i],
        		        'category' => $category[$i],
        		        'product_comment' => $product_comment[$i],
        		        );
        		}
        		$data['products'] = $productsData;
        		
        		$this->orders_model->update_quote($data,$order_id);
        		redirect('orders/quote_history');
		    }else{
    			$this->load->model('general_model');
        	    $data['categories']=$this->general_model->fetch_categories();
        		$data['suppliers']=$this->general_model->fetch_suppliers();
        	    
        	    $order_infoo =$this->orders_model->fetch_quote_info($order_id);
        	    $data['order_products']=$this->orders_model->fetch_order_products($order_id);
        	    
        		$data['order_info'] = $order_infoo;
    		
    			$this->load->view('general/header');
    			$this->load->view('orders/update_offer',$data);
    			$this->load->view('general/footer');
		    }
		}
		else redirect('general/index');
	}
	public function update_new_quote(){
	    
	    $order_id=$_POST['order_id'];
	    
		$order_product_id =$_POST['order_product_id']; 
		$amount = $_POST['amount'];
			
		$count = count($order_product_id);
		for($i=0;$i<$count;$i++){
		    $data[] = array(
		        'order_product_id' => $order_product_id[$i],
		        'amount' => $amount[$i],
		        );
		}
// 		echo "<pre>";print_r($data);
		$this->orders_model->update_new_quote($data);
		
		$this->orders_model->order_status_update($order_id,'4');
	
// 		$order_id;
// 		$this->load->model('general_model');
// 	    $suppliers=$this->general_model->fetch_suppliers($_POST['supplier']);
	    
	    
// 		$mailData = array(
// 		    'order_id' => $order_id,
// 		    'supplier_name' => $suppliers[0]->supplier_name,
// 		    );
// 		$body = $this->load->view('orders/reorder_email', $mailData,TRUE);
//             $config=array(
//             'charset'=>'utf-8',
//             'wordwrap'=> TRUE,
//             'mailtype' => 'html'
//             );
            
//             $this->email->initialize($config);
            
//             $this->email->to($suppliers[0]->email_address);
//             $this->email->from($this->fromEmail, 'Nach Food Co. ');
//             $this->email->subject('Nach Food Co.');
//             $this->email->message($body);
//             $mail = $this->email->send();
//             if($mail) {
//                 redirect('orders/quote_history');
                	
//             } else {
                redirect('general/index');
//             }
	
	}
	public function new_quote_products()
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
	public function quote_history($date_from='',$date_to='',$order_date='',$company=0,$dept=0,$customer=0,$sort_order='',$order_no ='',$location=0)
	{
	   
	    
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
	        $AllQuotes=$this->orders_model->fetch_quote_history($params);
	        $data['orders'] = json_decode(json_encode($AllQuotes), true);
	     
		
	  $keys = array_column($data['orders'], 'order_id');
       $userId = $this->session->userdata('branch_id');
       
       
       
       if($sort_order =='' || $sort_order == 3 ){
       
        foreach ($data['orders'] as $key => $part) {
             $sort[$key] = $part['order_id'];
              }
              if(!empty($sort)){
                array_multisort($sort, SORT_DESC, $data['orders']);
              }
		}

          if($sort_order !='' && $sort_order == 0){
             foreach ($data['orders'] as $key => $part) {
             $sort[$key] = strtotime($part['delivery_date']);
              }
              if(!empty($sort)){
                array_multisort($sort, SORT_ASC, $data['orders']);
              }
            }
          if($sort_order == 1){
              
           foreach ($data['orders'] as $key => $part) {
              $sort[$key] = strtotime($part['delivery_date']);
              }
              if(!empty($sort)){
                array_multisort($sort, SORT_DESC, $data['orders']);
              }
 
            }
          if($sort_order == 2){
              
           foreach ($data['orders'] as $key => $part) {
             $sort[$key] = $part['order_id'];
              }
              if(!empty($sort)){
                array_multisort($sort, SORT_ASC, $data['orders']);
              }
 
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
		
		$cust_firstname =empty($_POST['cust_firstname'])?'null':$_POST['cust_firstname'];
		
		$purchase_order_no =empty($_POST['purchase_order_no'])?'null':$_POST['purchase_order_no'];
		
		$cust_email = empty($_POST['cust_email'])?'null':$_POST['cust_email'];
		
		$cust_telephone =empty($_POST['cust_telephone'])?'null':$_POST['cust_telephone'];
		
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
		
		
		$this->orders_model->update_quote_details($purchase_order_no,$company_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_notes,$order_comments,$cost_centre,$delivery_fee,$standing_order,$cust_firstname,$cust_email,$cust_telephone,$delivery_addr,$comp_addr);
		
		add_notification($order_id);
	
		redirect('orders/quote_history/');
	}
	public function delete_order()
	{
	       $this->orders_model->delete_order($_POST['order_id'],$_POST['cancel_comments']);
	    
		  
			redirect('orders/quote_history');
	}
	
	public function chefApprove($order_id)
	{
	       
	   $this->db->query("UPDATE orders SET updatedAfterApproved= 0 , date_modified = '".date("Y-m-d H:i:s",strtotime("now"))."' WHERE order_id=".$order_id);
	      
			redirect('orders/production');
	}
	public function convertToInvoice($order_id){
	    $quote = $this->orders_model->convertToInvoice($order_id);
	    redirect('orders/quote_history');
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
	
	 $this->orders_model->update_frontend_order_details($purchase_order_no,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_time,$delivery_notes,$order_comments,$cost_centre,$delivery_fee,$cust_firstname,$cust_email,$cust_telephone,$delivery_addr);
   
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
		
		$cust_firstname =empty($_POST['cust_firstname'])?'null':$_POST['cust_firstname'];
		
		$purchase_order_no =empty($_POST['purchase_order_no'])?'null':$_POST['purchase_order_no'];
		
		$cust_email = empty($_POST['cust_email'])?'null':$_POST['cust_email'];
		
		$cust_telephone =empty($_POST['cust_telephone'])?'null':$_POST['cust_telephone'];
		
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
		
		$this->orders_model->update_order_details($_POST['ostatus'],$company_id,$company_name,$department_name,$cust_id,$order_id,$coupon_code,$delivery_date,$delivery_notes,$order_comments,$cost_centre,$delivery_fee,$standing_order,$cust_firstname,$cust_email,$cust_telephone,$delivery_addr,$comp_addr);
		
		add_notification($order_id);
	
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
	
	
	
	
	public function reorder()
	{
		$order_id=$_POST['order_id'];
		$date_time=date("Y-m-d H:i",strtotime($_POST['delivery_date']." ".$_POST['delivery_time']));
		$this->orders_model->reorder($order_id,$date_time);
		redirect('orders/standing_orders');
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
       $orders = explode(".",$orders);
      
       for($index = 0; $index <= sizeof($orders); $index++){
           $this->db->query("UPDATE orders SET late_fee=".$latefee." WHERE order_id=".$orders[$index]);
           
       }
      redirect('orders/order_history');
      
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
         
         if(isset($reports_details[$count]->customer_telephone)){
             $customer_telephone = $reports_details[$count]->customer_telephone;
         }else{
             $customer_telephone ='';
         }
         
        
        $sheet->setCellValue('A'.$x, $reports_details[$count]->order_id);
        $sheet->setCellValue('B'.$x, $deliverydate);
        $sheet->setCellValue('c'.$x, $delivery_address);
        $sheet->setCellValue('D'.$x, $pickup_delivery_notes);
        $sheet->setCellValue('E'.$x, $reports_details[$count]->firstname.' '.$reports_details[$count]->lastname.','.$customer_company_name.' , '.$customer_telephone);
         
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
	        
	      
	        
	   //$auth=sha1($data['order_info'][0]->firstname."|".$data['order_info'][0]->lastname."|".$data['order_info'][0]->order_id."|".$data['order_info'][0]->total);
	   
		
		
// 		if($auth==$auth_token){
		    
		    
	
			$this->load->view('general/header_print');
			$this->load->view('orders/print_frontend_order',$data);
			$this->load->view('general/footer_print');
// 		}
		  
	        
	    }
		else{
		    
		
			$order_infoo =$this->orders_model->fetch_order_info($order_id)[0];
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
			$this->load->view('orders/print_order',$data);
			$this->load->view('general/footer_print');
// 		}
// 		else echo "Oops! You do not have the correct authentication token to see this invoice. Please get in touch with us at the earliest to resolve this issue.";
	}}
	public function mark_as_paid($order_id,$referrer='',$ofrom='')
	{
	    
	    
	  
	   $this->orders_model->mark_paid($_POST['order_id'],$_POST['mark_paid_comments'],$_POST['ofrom']);
	   
     
		if(isset($_POST['referrer']) && $_POST['referrer'] !=''){
		     redirect('orders/'.$_POST['referrer'].'?id=3');
		     
		     }else{
		      
		    	redirect('orders/order_history');
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
         	
         
	
	
	
	public function payment_process()
	{
	   // ini_set('display_errors', 1); 
	    
		if($_POST['rescode']=='00'||$_POST['rescode']=='08'||$_POST['rescode']=='11'){

			$this->orders_model->mark_paid($_POST['refid'],'',$_GET['idn']);
			
			$this->send_mark_paid_email($_POST['refid']);
			
			
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
	    
	    
		if($_POST['rescode']=='00'||$_POST['rescode']=='08'||$_POST['rescode']=='11'){
			$this->orders_model->mark_paid($_POST['refid']);
			
			$this->send_mark_paid_email($_POST['refid']);
			
			$this->load->view('orders/pay_sucess');
			
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
    
		
	
			$csvStr="OrderID #,Customer,Delivery Date,Company,FOOD,PRICING,MENU,WEBSITE EXPERIENCE,DELIVERY,PACKAGING,CUSTOMER SERVICE,WHERE DID YOU HEAR ABOUT US,SUGGESTION\n";
   	       	if(!empty($all_feedback)){
		     $i = 0;
			foreach($all_feedback as $row){
			
				$csvStr.="\"".$row->order_id."\",\"".$row->cname."\",\"".date("d-m-Y",strtotime($row->delivery_date))."\",\"".$row->company_name." ".$row->FOOD."\",\"".$row->PRICING."\",\"".$row->MENU."\",\"".$row->EXPERIENCE."\",\"".$row->DELIVERY."\",\"".$row->PACKAGING."\",\"".$row->SERVICE."\",\"".$row->hearfrom."\",\"".$row->commentText."\"\n";
			 
			 
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

		$res['data']=$this->orders_model->generate_report($added_date_from,$added_date_to,$date_from,$date_to,$cost_centre,$cost_centre_list,$company,$status,$locations);
		

		
		$res['frontend_data'] = $this->orders_model->generate_frontend_report($added_date_from,$added_date_to,$date_from,$date_to,$cost_centre,$cost_centre_list,$company,$status,$locations);
		
		foreach($res['frontend_data'] as $all_frontend_order){
		       
		       $res['frontend_order_totals'][$all_frontend_order->order_id] = $this->orders_model->getOrderTotals($all_frontend_order->order_id);
		       
		   }
		   
		 ksort($res['frontend_order_totals']);
		
		
		$res['frontend_order_totals']  = json_decode(json_encode($res['frontend_order_totals']), True);
		
		$res['data'] = array_merge($res['data'],$res['frontend_data']);
		

		
		
		
     	$data=$res['data'];
     
	
	
		if($cron ==''){
		 		$csvStr="Order #,Order Date,Delivery Date,Customer,Department,Company,Cost Centre,Phone,Email,Subtotal,Discount,Delivery,Total,GST,Status,Paid Comment,Paid Date\n";
   	       }else{
   	        $csvStr ="Order #,Order Date,Delivery Date,Customer,Department,Company,Cost Centre,Phone,Email,Subtotal,Discount,Delivery,Total,GST,Status,Paid Comment,Paid Date,Username\n";  
   	       }
   	       
   	     
   	            
		if(!empty($data)){
		    $i = 0;
			foreach($data as $row){
				if(empty($row->delivery_phone))
					$phone=$row->telephone;
				else 
					$phone=$row->delivery_phone;
				if(empty($row->customer_email))
					$email=$row->email;
				else
					$email=$row->customer_email;
				if(empty($row->coupon_id)){
					$discount=0;
				}   
			if(isset($res['frontend_order_totals']) && !empty($res['frontend_order_totals']) && array_key_exists($row->order_id,$res['frontend_order_totals'])) {
			 
		
			    if(sizeof($res['frontend_order_totals'][$row->order_id]) < 4){
												       
												    $inserted[] = array(     
												    'order_total_id'=> $row->order_total_id +1,
                                                    'order_id' => $row->order_id,
                                                    'code' => 'coupon',
                                                    'title'=> 'Discount',
                                                    'value' => 0,
                                                     'sort_order'=> '4',
												       );
												      
												     array_splice($res['frontend_order_totals'][$row->order_id], 2, 0, $inserted);
												     
												     unset($inserted);
												     
												   }
												  
												   foreach($res['frontend_order_totals'][$row->order_id] as $key_ot => $frontend_order_total){
												      
												        if($frontend_order_total['code'] == 'shipping'){
												            //$delivery_total += $frontend_order_total['value'];
												             $current_deli_val  = $frontend_order_total['value'];
												        }
												        
												         if($frontend_order_total['code'] == 'coupon'){
												           
												            $discount  = $frontend_order_total['value'];
												        }
												        
												        if($frontend_order_total['code'] == 'total'){
												            
												            $ord_tot = $frontend_order_total['value'];
												        }
												        
												        if($frontend_order_total['code'] == 'sub_total'){
												            
												            $ord_sub_total = $frontend_order_total['value'];
												        }
												         
												    } 
			    
			    
			}else{
			    
			   if($row->type=='F')
						$discount=$row->coupon_discount;
					else if($row->type=='P')
						$discount=($row->order_total*$row->coupon_discount/100); 
			    
			    
			}
				
			
			if(isset($row->order_status_id)){
			    
			                                  if($row->order_status_id == 0){
												        
												    $status="Cancelled";
												    } 
				                                  else if($row->order_status_id == 3){
												        
												    $status="Paid";
												    } else{
												        
												        if($order->order_status_id==1 || $order->order_status_id==''  || $order->order_status_id==0){
																
																	$status= "Awaiting approval";
																}else{
												         if($row->order_status_id == 2){
												             
												             
												        $status= "Approved";
												         }
												        
												        if($row->order_status_id == 5){
												            
												            $status= "Complete";
												             
												         }
												         
												         if($row->order_status_id == 15){
												            ;
												             $status= "Out Standing";
												             
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
			    	elseif(isset($row->cost_centre) && $row->cost_centre !='' && $row->order_status !=3) {
												    $status = "Approved";
												   
												    
												}	
											else if($row->order_status==1 || $row->order_status=='' || $row->order_status==7 ){
												 $status= "Awaiting approval";
												}
												else if($row->order_status==2){
													 $status = "Approved";
												}
												else if($row->order_status==3){
												 $status = "Paid";
												}
												
												else if($row->order_status==5 || $row->order_status==15)
													
													 $status = "Complete";
													
												else if($row->order_status==11)
												
													 $status = "Waiting for payment";
												else if($row->order_status==12)
													
														 $status = "Waiting for Approval";
												else if($row->order_status==13)
													
													$status = "Approved";
													
												else if($row->order_status==14)
												
													$status = "Paid";
			    
			    
			    
			    
			    
			    
			}
				
				if(isset($row->department_name)){
				    $dept_name = $row->department_name;
				}else{
				   $dept_name =  $row->dept_name;
				}
				
				if(!isset($ord_sub_total)){
				    
				    $ord_sub_total = $row->order_total;
				}else{
				    
				    $ord_sub_total =  $ord_sub_total;
				    
				}
				
					if(isset($row->order_total)){
				    $order_total = $row->order_total;
				    $gst = ($order_total/11);
				    }else{
				    $order_total =  $ord_tot;
				    $gst = ($order_total/11);
				    }
				
				if(isset($row->delivery_fee)){
				    $del_fee = $row->delivery_fee;
				}else{
				   $del_fee =  $current_deli_val;
				}
				
				
				
				if(isset($row->mark_paid_comment) && $row->mark_paid_comment != ''){
				    
				    $comment  = $row->mark_paid_comment;
				}else{
				    
				    $comment  = '';
				}
				
				
			
				
				
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
				
				if(isset($row->delivery_date)){
				    
				    $del_dat = $row->delivery_date;
				}else{
				    
				    $del_dat = $row->delivery_date;
				}
				
				$csvStr.="\"".$row->order_id."\",\"".date('d-m-Y',strtotime($row->date_added))."\",\"".date("d-m-Y",strtotime($del_dat))."\",\"".$row->firstname." ".$row->lastname."\",\"".$dept_name."\",\"".$row->company_name."\",\"".$row->cost_centre."\",\"".$phone."\",\"".$email."\",\"$".number_format($order_total,2)."\",\"$".number_format($discount,2)."\",\"$".number_format($del_fee,2)."\",\"$".number_format($order_total,2)."\",\"$".number_format($gst,2)."\",\"".$status."\",\"".$comment ."\",\"".$paid_date."\"\n";
			 
			
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
              
            
               
              $user_info = $this->orders_model->fetch_user_info($order_info[0]->user_id,'frontend');
              
              $manager_email = $user_info[0]->email;
              
              $auth=sha1($order_info[0]->firstname."|".$order_info[0]->lastname."|".$order_info[0]->order_id."|".$order_info[0]->order_total);
              
               $toemail = $order_info[0]->email;
               
                $auth_token=$auth;
                
              
                
               $data['customer_name'] = $order_info[0]->firstname;
               
          }else{
              
              $order_info = $this->orders_model->fetch_order_info($order_id)[0];
             
              if(isset($order_info->user_id) && $order_info->user_id != ''){
                  $user_info = $this->orders_model->fetch_user_info($order_info->user_id,'backend');
                  $manager_email = $user_info[0]->email;
              }else
              {
                  $manager_email = 'catering@healthychoicescatering.com.au';
              }
              
              
              
          
        
         $auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);
         
		  $auth_token=$auth;
         
		    $toemail = $order_info->customer_email;
		    
		    $data['customer_name'] = $order_info->firstname;
		    
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
            'mailtype' => 'html'
            );
            
            $this->email->initialize($config);
            
            // $this->email->to($toemail,$manager_email);
            $list = array(
                
                
                $toemail,
                
                $manager_email
                
                );
            
            
            $this->email->to($list);

            $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
            $this->email->subject('Healthy Choices Catering');
            $this->email->message($body);
            $mail = $this->email->send();
            if($mail) {
                return true;
            } 
            
			
	}
	
	
	
	
	
	public function order_approval($order_id)
	{
	    $this->orders_model->order_status_update($order_id,'3');
		$data['order_info']=$this->orders_model->fetch_quote_info($order_id);
        $this->load->model('general_model');
		$data['categories']=$this->general_model->fetch_categories();
		$data['suppliers']=$this->general_model->fetch_all_suppliers();
		$data['order_products']=$this->orders_model->fetch_order_products($order_id);
		$this->load->view('general/header_print');
		$this->load->view('orders/order_approval',$data);
		$this->load->view('general/footer');
	}
	public function approve()
	{
		$comments=$_POST['approval_comments'];
		$order_id =$_POST['order_id'];
		$status_name =$_POST['status_name'];
		
	
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
		 $this->convertToInvoice($order_id);   
		}
	
		$this->send_mail_manager($order_id,'approve');
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
		    $toemail = $order_info->customer_email;
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
	
	public function send_mail_manager($order_id='',$type='')
	{
	    if(isset($order_id) && $order_id != ''){
	        $order_id  = $order_id;
	        
	    }else{
	        return false;
	    }
	    
	  
	   
	        $order_info=$this->orders_model->fetch_quote_info($order_id)[0];
	        
	        $user_info = $this->orders_model->fetch_user_info($order_info->user_id);
          
         
          
          $manager_email = $user_info[0]->email;
	        
	      
		    $auth=sha1($order_info->firstname."|".$order_info->lastname."|".$order_info->order_id."|".$order_info->order_total);;
		    $toemail = $manager_email;
            $data['order_id'] = $order_info->order_id;
           $data['customer_name']   = $order_info->firstname;
            $data['order_id1'] = '';
           
         
if(isset($type) && $type =='approve'){
    
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
            
            if($type =='approve'){
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
	        $data['download_link']   =  base_url().'index.php?route=account/order/order_inv_download&oid='. $order_id.'&cus_id='.$customer_id;
	    }else{
	        
	      $order_info=$this->orders_model->fetch_order_info($order_id)[0];  
	      $data['customer_name']   = $order_info->firstname;
	      $data['ofrom']   = 'backend';
	      $data['download_link']   =  base_url().'index.php/orders/order_inv_download/'.$order_id.'/'.$customer_id.'/';
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
		$email=$_POST["email_payment"];
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
		$this->email->to($email);
		
		 $body = $this->load->view('orders/payment_link_email', $data,TRUE);
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
	       $email = $order_info->customer_email;
	      
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
	  
	    $data['delivery_date']   =  $var['delivery_date'];
	    $data['company_name']   =  $var['company_name'];
	     $data['cname']   =  $var['cname'];
	     $data['order_id']   =  $var['order_id'];
	     $data['location_id']   =  $var['location_id'];
	    $this->load->view('orders/feedback_form',$data); 
	}
	
	public function feedback_form_submit()
	{
	   
	    $data['customer_name']   =  $customer_name;
	     $res = $this->orders_model->insert_feedback($_POST);
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
               $table .='<td>'.$orderfeedback_info[0]->hearfrom.'</td>';
               $table .='<td>'.$orderfeedback_info[0]->commentText.'</td>'; 
                
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
	    
	    if(isset($ofrom) && $ofrom=='frontend'){
	        
	        $order_info = $this->orders_model->getOrder($order_id);
	        
	        $user_info = $this->orders_model->fetch_user_info($order_info[0]->user_id);
	       
	        
	        $total   = (int)(($order_info[0]->total)*100);
	        echo $total;
	        
	    }else{
	        $o=$this->orders_model->get_order($order_id)[0];
	        
	        $user_info = $this->orders_model->fetch_user_info($o->user_id,$ofrom);
	
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
	    $mid=	$user_info[0]->merchant_id;
	   $mpass=	$user_info[0]->merchant_pass;
			
			
		
		$elem="<form id=\"securepay_form\" action=\"https://payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
		$elem.="<input type=\"hidden\" name=\"bill_name\" value=\"transact\">";
		$elem.="<input type=\"hidden\" name=\"merchant_id\" value=\".$mid.\">";
		$elem.="<input type=\"hidden\" name=\"primary_ref\" value=\"".$order_id."\">";
		$elem.="<input type=\"hidden\" name=\"fp_timestamp\" value=\"".gmdate("YmdHis")."\">";
		$elem.="<input type=\"hidden\" name=\"fingerprint\" value=\"".sha1($mid.'|'.$mpass.'|0|'.$order_id."|".$total."|".gmdate("YmdHis"))."\">";
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
	    	$mid =	$this->session->userdata('merchant_id');
			$mpass=	$this->session->userdata('merchant_pass');
		
	    if(isset($ofrom) && $ofrom=='frontend'){
	        
	        $order_info = $this->orders_model->getOrder($order_id);
	        $total   = (int)(($order_info[0]->total)*100);
	        echo $total;
	        
	    }else{
	        $o=$this->orders_model->fetch_order_info($order_id)[0];
	         $useeInfo=$this->orders_model->fetch_user_info($o->user_id);
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
	 public function order_inv_download($order_id,$cust_id,$invType='')
    {
    //   ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        $order_info =$this->orders_model->fetch_order_info($order_id);
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
        $pdf->SetFillColor(70, 68, 151);
        $pdf->SetTextColor(255,255,255);
        $pdf->setFont('MontserratB', '', 10);

        $pdf->Cell(95, 8, "Order Details", 0, 0, 'L', true);
        
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
        if(!in_array($order_id,array(8296,8317,8318,8319,8320,8332,8333,8334,8335,8336,8337,8338,8295,8404,8405,8406,8407,8410,8411,8412,8382,8408, 8383, 8384, 8385, 8386))) {
             $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['customer_telephone'], 0, 1, 'R');
        }else{
           $pdf->Cell(190, 5, $order_info['customer_telephone'], 0, 1, 'R');  
        }
       
        $pdf->Cell(190, 5, $order_info['customer_company_name'], 0, 1, 'R');
        // $x_axis=$pdf->getx();
        $pdf->Ln(0.1);
        $pdf->MultiCell(190, 5,$order_info['customer_company_addr'],0,'R');
        $pdf->Ln(5);
         
         $delivery_array = str_split($order_info['delivery_address'], 50);
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
        $pdf->Cell(190, 5, 'Deliver To', 0, 1, 'R');
        $pdf->SetFont("Montserrat", '', 8.5);
         if(!in_array($order_id,array(8296,8317,8318,8319,8320,8332,8333,8334,8335,8336,8337,8338,8295,8404,8405,8406,8407,8410,8411,8412,8382,8408, 8383, 8384, 8385, 8386))) {
               $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['customer_telephone'], 0, 1, 'R'); $pdf->Ln(0.1);
         }else{
               $pdf->Cell(190, 5, $order_info['customer_telephone'], 0, 1, 'R'); $pdf->Ln(0.1);
         }
      
        $pdf->MultiCell(190, 5,$address_del,0,'R');
       
       
        $pdf->SetLeftMargin(10);
        
        //--- end--------------------------------------------------------------------------
       $length_del_addr =  strlen($order_info['delivery_address']);
       if($length_del_addr > 49){
           $pdf->Ln(-40);
       }else{
            $pdf->Ln(-30);
       }
       
       if(isset($order_info['purchase_order_no']) && $order_info['purchase_order_no'] !=''){
          $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Purchase order no : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_info['purchase_order_no'], 0, 0);
       
        $pdf->ln(5); 
       }
       $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Invoice ID : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_id, 0, 0);
         $pdf->ln(5);
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Order Date : ", 0, 0, 'L', true);

        $pdf->SetFont("Montserrat", '', 8.5);
       
        $orderdate = date('d M Y',strtotime($order_info['date_added']));
        $pdf->Cell(35, 4, '      '.$orderdate, 0, 0,'L',true);
        $pdf->ln(5);
        
        if($order_info['order_status'] == 3){
            
      
        $paiddate = date('d M Y',strtotime($order_info['date_modified']));
       
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
        $pdf->Cell(30, 8, "Order Comments :", 0, 0, 'L', true);
        $pdf->setFont("Montserrat", '', 8.5);
        $x_axis=$pdf->getx();
        $pdf->left_vcell(10, 8, $x_axis,$order_info['order_comments']);
        $pdf->ln(-10);
        }
        
       $pdf->ln(32);

        // Colors, line width and bold font
        $pdf->SetFillColor(70, 68, 151);
        $pdf->SetTextColor(255,255,255);
        
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(.1);
        $pdf->SetFont('MontserratB', '');
        // Header
        // $header = ['Iten Name', 'Description','Comments','Qty','Price','Total'];
        $header = ['Iten Name', 'Comments','Qty','Price','Total'];
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
       $pdf->SetFillColor(70, 68, 151);
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
        // if($order_id == 11826 || $order_id == 11758 || $order_id == 11701 || $order_id == 11628 || $order_id == 11557 || $order_id == 10536 ){
        if($order_info['GST_status'] == 1){
             $pdf->Cell($w[4]-2, 5, "$".number_format(0, 2), '', 1, 'R');
        }else{
            $pdf->Cell($w[4]-2, 5, "$".number_format($gst, 2), '', 1, 'R');
        }

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
         $pdf->SetFillColor(70, 68, 151);
         $pdf->SetTextColor(255,255,255);
        
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
        $pdf->SetFillColor(70, 68, 151);
         $pdf->SetTextColor(255,255,255);
       
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
        if(!in_array($order_id,array(8296,8317,8318,8319,8320,8332,8333,8334,8335,8336,8337,8338,8295,8404,8405,8406,8407,8410,8411,8412,8382,8408, 8383, 8384, 8385, 8386))) {
             $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['customer_telephone'], 0, 1, 'R');
        }else{
           $pdf->Cell(190, 5, $order_info['customer_telephone'], 0, 1, 'R');  
        }
       
        $pdf->Cell(190, 5, $order_info['customer_company_name'], 0, 1, 'R');
        // $x_axis=$pdf->getx();
        $pdf->Ln(0.1);
        $pdf->MultiCell(190, 5,$order_info['customer_company_addr'],0,'R');
        $pdf->Ln(5);
         
         $delivery_array = str_split($order_info['delivery_address'], 50);
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
        $pdf->Cell(190, 5, 'Deliver To', 0, 1, 'R');
        $pdf->SetFont("Montserrat", '', 8.5);
         if(!in_array($order_id,array(8296,8317,8318,8319,8320,8332,8333,8334,8335,8336,8337,8338,8295,8404,8405,8406,8407,8410,8411,8412,8382,8408, 8383, 8384, 8385, 8386))) {
               $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['customer_telephone'], 0, 1, 'R'); $pdf->Ln(0.1);
         }else{
               $pdf->Cell(190, 5, $order_info['customer_telephone'], 0, 1, 'R'); $pdf->Ln(0.1);
         }
      
        $pdf->MultiCell(190, 5,$address_del,0,'R');
       
       
        $pdf->SetLeftMargin(10);
        
        //--- end--------------------------------------------------------------------------
       $length_del_addr =  strlen($order_info['delivery_address']);
       if($length_del_addr > 49){
           $pdf->Ln(-40);
       }else{
            $pdf->Ln(-30);
       }
       
       if(isset($order_info['purchase_order_no']) && $order_info['purchase_order_no'] !=''){
          $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Purchase order no : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_info['purchase_order_no'], 0, 0);
       
        $pdf->ln(5); 
       }
       $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Quote ID : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_id, 0, 0);
         $pdf->ln(5);
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Quote Date : ", 0, 0, 'L', true);

        $pdf->SetFont("Montserrat", '', 8.5);
       
        $orderdate = date('d M Y',strtotime($order_info['date_added']));
        $pdf->Cell(35, 4, '      '.$orderdate, 0, 0,'L',true);
        $pdf->ln(5);
        
        if($order_info['order_status'] == 3){
            
      
        $paiddate = date('d M Y',strtotime($order_info['date_modified']));
       
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
        $pdf->SetFillColor(70, 68, 151);
        $pdf->SetTextColor(255,255,255);
       
        $pdf->SetDrawColor(200, 200, 200);
        $pdf->SetLineWidth(.1);
        $pdf->SetFont('MontserratB', '');
        // Header
        // $header = ['Iten Name', 'Description','Comments','Qty','Price','Total'];
        $header = ['Iten Name', 'Comments','Qty','Price','Total'];
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
       $pdf->SetFillColor(70, 68, 151);
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
         $pdf->SetFillColor(70, 68, 151);
         $pdf->SetTextColor(255,255,255);
         $pdf->setFont('MontserratB', '', 10);

        
        $this->borderpdf($pdf);
        $pdf->Output();
    }


	
	
	
	public function front_end_order_inv_download($order_id,$cust_id){
	    
	   // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	       if (isset($order_id) && isset($cust_id)) {
	      
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
       $pdf->SetFillColor(70, 68, 151);
       $pdf->SetTextColor(255,255,255);
        
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
        
          $s_addr = $order_info['shipping_address_1'].' ' .$order_info['shipping_address_2'].' '.$order_info['shipping_postcode'];
        
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
        $pdf->Cell(154, 5, 'Bill To', 0, 1, 'R');
        $pdf->SetFont("Montserrat", '', 8.5);
        // $pdf->SetLeftMargin(70);
        $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['telephone'], 0, 1, 'R');
         $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(190, 5, 'Deliver To', 0, 1, 'R');
        $pdf->Ln(0.1);
         $pdf->SetFont("Montserrat", '', 8.5);
        $pdf->Cell(190, 5, $order_info['firstname'].' '.$order_info['lastname'].' |  '.$order_info['telephone'], 0, 1, 'R'); $pdf->Ln(0.1);
        $pdf->Ln(0.5);
        $pdf->MultiCell(190, 5,$address_del,0,'R');
     
       
        $pdf->SetLeftMargin(10);
        
        //--- end--------------------------------------------------------------------------
        
          $length_del_addr =  strlen($order_info['delivery_address']);
      if($length_del_addr > 49){
          $pdf->Ln(-30);
      }else{
            $pdf->Ln(-20);
      }
      
      if(isset($order_info['purchase_order_no']) && $order_info['purchase_order_no'] !=''){
          $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(30, 4, "Purchase order no : ", 0, 0);

        $pdf->SetFont("Montserrat", '', 9);
        $pdf->Cell(10, 4, '      '.$order_info['purchase_order_no'], 0, 0);
       
        $pdf->ln(5); 
       }
        $orderdate = date('d M Y',strtotime($order_info['date_added']));
        $pdf->SetFont("MontserratB", '', 8.5);
        $pdf->Cell(25, 4, "Order Date : ", 0, 0, 'L', true);

        $pdf->SetFont("Montserrat", '', 8.5);
       
        $pdf->Cell(35, 4, '      '.$orderdate, 0, 0,'L',true);
        $pdf->ln(5);
        
        if($order_info['order_status'] == 3){
            
      
       $paiddate = date('d M Y',strtotime($order_info['date_modified']));
       
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

       if($order_info['order_status'] == 3){
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
        
         $pdf->SetFont("MontserratB", '', 8.5);
         $pdf->Cell(30, 4, "Shipping Type : ", 0, 0, 'L', true);
         
         
        $pdf->setFont("Montserrat", '', 8.5);
        $pdf->Cell(10, 4, $sm, 0, 0, 'L', true);
        $pdf->ln(5);
        
       
        $delivery_date = $order_info['delivery_date']. ' '. $order_info['delivery_time'];
        $delivery_date = date('d M Y h:i a',strtotime($delivery_date));
       
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
        $pdf->SetFillColor(70, 68, 151);
        $pdf->SetTextColor(255,255,255);
       
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
                $pdf->Ln(0.2);
                $pdf->Row(array('-- '.$option['name'].":".$option['value'],'',$option['option_qty'],"$" . number_format($option['price'], 2),"$" . number_format($option['price']*$option['option_qty'], 2)));
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
   
   $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, $order_total['title']." : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".number_format($order_total['text'],2), '', 1, 'R');
  

   
    if($order_total['title'] == 'Total'){
        $tot = $order_total['text'];
    $gst =  number_format(($order_total['text']/11),2);
    }
    $c++;
    
}

if($order_info['order_status_id']==3){
    
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "Amount Paid : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".number_format($tot, 2), '', 1, 'R');
        
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "Balance Due : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$0", '', 1, 'R');


}
        $pdf->SetFont('MontserratB', '',8.5);
        $pdf->Cell($w[0]+$w[1]+16, 5, "GST : ", '', 0, 'R');
        $pdf->SetFont('Montserrat', '',8.5);
        $pdf->Cell(18, 5, "$".number_format($gst, 2), '', 1, 'R');
        
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
         $pdf->SetFillColor(70, 68, 151);
           $pdf->SetTextColor(255,255,255);
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

	public function cron_task()
	{
	      
	      
	   $all_users = $this->orders_model->getall_user();
	   
	  foreach($all_users as $all_user){
	      
	      
	      $this->get_order_by_user($all_user->user_id,$all_user->account_email);
	      
	  }
		

	
	}
	
	
		public function cron_task2()
	{
	    return false;
	    // fetch all unpaid orders thatvare 30 days or more than 30 days old
	    
	      $all_unpaid_orders = $this->orders_model->fetch_unpaid_orders(); 
	      
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
            
	      
	      foreach($all_unpaid_orders as $all_unpaid_order){
	          
	          $data['customer_name']   = $all_unpaid_order->firstname;
	          
	          $data['ofrom']   = 'backend';
	          
	         $data['order_id'] = $all_unpaid_order->order_id;
	         
	         $data['total'] = number_format($all_unpaid_order->order_total,2, '.', '');
	          
	          
	    $this->email->initialize($config);
        $this->email->from($this->fromEmail, 'Healthy Choices Catering ');
		$this->email->to($all_unpaid_order->customer_email);
		
		 $body = $this->load->view('orders/payment_link_email', $data,TRUE);
		$this->email->subject('Auto reminder');
		$this->email->message($body);
		
		 $this->email->send();
			
	   
	      

	
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
				if(isset($row->customer_email) && empty($row->customer_email))
					$email=$row->email;
				else
					$email=$row->customer_email;
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
