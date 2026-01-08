<?php 

function add_notification($orderID){
   
   $CI =& get_instance();
   	$CI->load->model('Orders_model');
   	
    
    $desc = 'order-'.$orderID.' edited on '.date('d-m-Y h:m:s');
    // echo "not".$desc;exit;
    
	    $data  = array(
	       'description' => $desc,
	       'orderID' => $orderID,
	       'userID' => $_SESSION['user_id'],
	       'date_added' => date('Y-m-d'),
	       'time_added' => date('h:m:s')
	       
	   );
	   
	     
	        $CI->Orders_model->add_notification($data);
	   
	    return true;
}

?>