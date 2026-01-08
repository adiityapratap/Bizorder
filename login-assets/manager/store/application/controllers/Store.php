<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('store_model');
	}
	public function home()
	{
		if(!empty($this->session->userdata('customer_id')))
		{
			$data['categories']=$this->store_model->fetch_categories();
			$data['best_sellers']=$this->store_model->fetch_best_sellers();
			$data['whats_new']=$this->store_model->fetch_whats_new();
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('store/home',$data);
			$this->load->view('general/footer');
		}
		else
		{
			redirect('general/index');
		}
	}
	public function all_products($page=1,$cat=1)
	{
		//echo "<pre>".print_r($this->session->userdata('cart'),1);exit;
		if(!empty($this->session->userdata('customer_id')))
		{
			$data['categories']=$this->store_model->fetch_categories();
			$data['products']=$this->store_model->fetch_all_products($page,$cat);
			$data['page']=$page;
			$data['cat']=$cat;
			$total_count=0;
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				foreach($header_data['cart_items'] as $item){
					$total_count+=$item['quantity'];
				}
			}
			else $header_data=array();
			$header_data['item_count']=$total_count;
			$data['max_pages']=$this->store_model->fetch_max_pages($cat);
			$this->load->view('general/header',$header_data);
			$this->load->view('store/all_products',$data);
			$this->load->view('general/footer');
		}
		else
		{
			redirect('general/index');
		}
	}
	public function fetch_product($product_id)
	{
		$data['product']=$this->store_model->fetch_product($product_id)[0];
		$data['options']=$this->store_model->fetch_options($product_id);
		echo json_encode($data);
	}
	public function add_to_cart()
	{
		$item=array();
		if(!empty($this->session->userdata('cart')))
		{
			$cart=$this->session->userdata('cart');
		}
		else{
			$cart=[];
		}
		//Check if exists; update quantity and total if yes
		if(!empty($cart[$_POST['product_id']])){
			$cart[$_POST['product_id']]['quantity']+=$_POST['quantity'];
			$cart[$_POST['product_id']]['total']+=$_POST['total'];
		}
		else
		{
			$item['product_name']=$_POST['product_name'];
			$item['product_minimum']=$_POST['product_minimum'];
			$item['product_id']=$_POST['product_id'];
			$item['price']=$_POST['price'];
			$item['quantity']=$_POST['quantity'];
			$item['total']=$_POST['total'];
			$cart[$item["product_id"]]=$item;
		}
		$this->session->set_userdata('cart',$cart);
	}
	public function remove_from_cart($item)
	{
		if(!empty($this->session->userdata('cart')))
		{
			$cart=$this->session->userdata('cart');
		}
		else{
			$cart=[];
		}
		unset($cart[$item]);
		$this->session->set_userdata('cart',$cart);
	}
	public function remove_option_from_cart($item,$option)
	{
		if(!empty($this->session->userdata('cart')))
		{
			$cart=$this->session->userdata('cart');
		}
		else{
			$cart=[];
		}
		//Find this option's total
		$option_total=$cart[$item]['options'][$option]['option_total'];
		//Set this product's total to total-option_total
		$cart[$item]['total']-=$option_total;
		unset($cart[$item]['options'][$option]);
		//If this was the last option, remove the product entirely
		if(count($cart[$item]['options'])==0)
			unset($cart[$item]);
		$this->session->set_userdata('cart',$cart);
	}
	public function add_to_cart_options()
	{
		//Check if qty != 0 || qty ! empty
		if($_POST['option_qty']!=0&&!empty($_POST['option_qty']))
		{		
			$item=array();
			if(!empty($this->session->userdata('cart')))
			{
				$cart=$this->session->userdata('cart');
			}
			else{
				$cart=[];
			}
			if(empty($cart[$_POST['product_id']]))
			{
				$item['product_name']=$_POST['product_name'];
				$item['product_minimum']=$_POST['product_minimum'];
				$item['product_id']=$_POST['product_id'];
				$item['price']=$_POST['price'];
				$cart[$item["product_id"]]=$item;
			}
			if(!empty($cart[$_POST['product_id']])){
				//This product exists, check if this option is there
				if(!empty($cart[$_POST['product_id']]['options'][$_POST['option_id']])){
					//This option exists, update
					if(!empty($cart[$_POST['product_id']]['total'])){
						$total=$cart[$_POST['product_id']]['total']+($_POST['option_qty']*$_POST['option_price']);
					}
					else
						$total=$_POST['option_qty']*$_POST['option_price'];
					if(!empty($cart[$_POST['product_id']]['quantity']))
						$qty=$cart[$_POST['product_id']]['quantity']+$_POST['option_qty'];
					else $qty=$_POST['option_qty'];
					//This option doesn't yet exist
					$item['option_name']=$_POST['option_name'];
					$item['option_price']=$_POST['option_price'];
					$item['po_id']=$_POST['option_id'];
					$item['option_qty']=($_POST['option_qty']+$cart[$_POST['product_id']]['options'][$_POST['option_id']]['option_qty']);
					$item['option_total']=($_POST['option_qty']+$cart[$_POST['product_id']]['options'][$_POST['option_id']]['option_qty'])*$_POST['option_price'];
					$cart[$_POST['product_id']]['total']=$total;
					$cart[$_POST['product_id']]['quantity']=$qty;
					$cart[$_POST['product_id']]['options'][$_POST['option_id']]=$item;
				}
				else{
					//Check if total and qty are set for product
					if(!empty($cart[$_POST['product_id']]['total'])){
						$total=$cart[$_POST['product_id']]['total']+($_POST['option_qty']*$_POST['option_price']);
					}
					else
						$total=$_POST['option_qty']*$_POST['option_price'];
					if(!empty($cart[$_POST['product_id']]['quantity']))
						$qty=$cart[$_POST['product_id']]['quantity']+$_POST['option_qty'];
					else $qty=$_POST['option_qty'];
					//This option doesn't yet exist
					$item['option_name']=$_POST['option_name'];
					$item['option_price']=$_POST['option_price'];
					$item['option_total']=$_POST['option_qty']*$_POST['option_price'];
					$item['option_qty']=$_POST['option_qty'];
					$item['po_id']=$_POST['option_id'];
					$cart[$_POST['product_id']]['total']=$total;
					$cart[$_POST['product_id']]['quantity']=$qty;
					$cart[$_POST['product_id']]['options'][$_POST['option_id']]=$item;
				}
			}
			$this->session->set_userdata('cart',$cart);
			echo "<pre>".print_r($_POST,1);exit;
		}
	}
	public function checkout()
	{
		if(!empty($this->session->userdata('customer_id')))
		{		
			$data['cart']=$this->session->userdata('cart');
			$data['customer']=$this->store_model->fetch_customer($this->session->userdata('customer_id'));
			$total_count=0;
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				foreach($header_data['cart_items'] as $item){
					$total_count+=$item['quantity'];
				}
			}
			else $header_data=array();
			$header_data['item_count']=$total_count;
			$header_data['page']='checkout';
			$this->load->view('general/header',$header_data);
			$this->load->view('store/checkout',$data);
			$this->load->view('general/footer');
		}
		else{
			redirect('general/index');
		}
	}
	public function update_product($product,$qty)
	{	
		$cart=$this->session->userdata('cart');
		if(!empty($cart[$product])){
			$cart[$product]['quantity']=$qty;
			$cart[$product]['total']=($qty*$cart[$product]['price']);
		}
		$this->session->set_userdata('cart',$cart);
	}
	public function update_item_options($product,$po_id,$qty)
	{
		$cart=$this->session->userdata('cart');
		if(!empty($cart[$product])){
			//Update qty and total
			$old_qty=$cart[$product]['options'][$po_id]['option_qty'];
			$old_total=$cart[$product]['options'][$po_id]['option_total'];
			$cart[$product]['options'][$po_id]['option_qty']=$qty;
			$cart[$product]['options'][$po_id]['option_total']=$qty*$cart[$product]['options'][$po_id]['option_price'];
			//Also update product total and qty
			$cart[$product]['quantity']-=$old_qty;
			$cart[$product]['quantity']+=$qty;
			$cart[$product]['total']-=$old_total;
			$cart[$product]['total']+=$cart[$product]['options'][$po_id]['option_total'];
		}
		$this->session->set_userdata('cart',$cart);
	}
	public function move_to_payment()
	{
		$cart=$this->session->userdata('cart');
		$order_total=0.0;
		foreach($cart as $c){
			$order_total+=$c['total'];
		}
		//First, add order to db with order_status 11
		//Then, if payment_radio==1, send email to manager and treat as normal waiting for approval
		//Else if payment_radio==2, send to securepay
		$customer_id=$_POST['customer_id'];
		$shipping_method=$_POST['shipping_method'];
		$delivery_notes=$_POST['delivery_notes'];
		$delivery_address=$_POST['delivery_address'];
		$delivery_phone=$_POST['phone'];
		$delivery_email=$_POST['email'];
		if($_POST['payment_radio']==3)
			$order_status=11;
		else
			$order_status=13;
		$delivery_datetime=date("Y-m-d H:i",strtotime($_POST['delivery_datetime']));
		$selected_location=0;
		$standing_order=0;
		$cost_centre=$_POST['cost_centre'];
		$order_comments=$_POST['order_comments'];
		$order_id=$this->store_model->add_new_order($customer_id,$shipping_method,$delivery_notes,$order_status,$delivery_datetime,$selected_location,$standing_order,$cost_centre,$order_comments,$order_total,$delivery_address,$delivery_phone,$delivery_email);
		foreach($cart as $c){
			$op_id=$this->store_model->add_product($order_id,$c['product_id'],$c['quantity'],$c['price']);
			if(!empty($c['options'])){
				foreach($c['options'] as $o){
					$this->store_model->add_option($op_id,$o['po_id'],$o['option_qty'],$o['option_price'],$o['option_total']);
				}
			}
		}
		if($_POST['payment_radio']==3){
			//Process securepay
			$elem="<form id=\"securepay_form\" action=\"https://payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
			$elem.="<input type=\"hidden\" name=\"bill_name\" value=\"transact\">";
			$elem.="<input type=\"hidden\" name=\"merchant_id\" value=\"2Q40331\">";
			$elem.="<input type=\"hidden\" name=\"primary_ref\" value=\"".$order_id."\">";
			$elem.="<input type=\"hidden\" name=\"fp_timestamp\" value=\"".gmdate("YmdHis")."\">";
			$elem.="<input type=\"hidden\" name=\"fingerprint\" value=\"".sha1('2Q40331|Roberta123|0|'.$order_id."|".(int)($order_total*100)."|".gmdate("YmdHis"))."\">";
			$elem.="<input type=\"hidden\" name=\"amount\" value=\"".(int)($order_total*100)."\">";
			$elem.="<input type=\"hidden\" name=\"txn_type\" value=\"0\">";
			$elem.="<input type=\"hidden\" name=\"currency\" value=\"AUD\">";
			$elem.="<input type=\"hidden\" name=\"return_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"return_url_target\" value=\"parent\">";
			$elem.="<input type=\"hidden\" name=\"cancel_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"callback_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"template\" value=\"default\">";
			$elem.="<input type=\"hidden\" name=\"display_receipt\" value=\"no\">";
			$elem.="<input type=\"hidden\" name=\"display_cardholder_name\" value=\"no\">";
			$elem.="</form>";
			$data['elem']=$elem;
			$this->load->view('store/process_payment',$data);
		}
		else{
			//Clear cart
			unset($_SESSION['cart']);
			//Send purchase order
			$o=$this->store_model->get_order($order_id)[0];
			$auth_token=sha1($o->firstname."|".$o->lastname."|".$o->order_id."|".$o->order_total);
			$email=$delivery_email;
			$config['protocol'] = 'sendmail';
			$config['smtp_host'] = 'localhost';
			$config['smtp_user'] = '';
			$config['smtp_pass'] = '';
			$config['smtp_port'] = 25;
			$this->load->library('email', $config);
			$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
			$this->email->to($email);
			$this->email->subject('Purchase Order for Order #'.$order_id.' at Hospital Caterings');
			$this->email->message("The purchase order for your order at Hospital Caterings (Order #".$order_id.") can be viewed at: http://hospitalcaterings.com.au/ipswich/index.php/orders/print_order/".$order_id."/".$auth_token."\r\nThank you, and have a great day!\r\nRegards,\r\nTeam Hospital Caterings");
			$this->email->send();
			
			$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
			$this->email->to('jackie@cafeonthehilltop.com.au');
			$this->email->subject('New order');
			$this->email->message("A new order has been placed: \r\nOrder ID: ".$order_id."\r\n"."http://hospitalcaterings.com.au/ipswich/index.php/orders/edit_order/".$order_id);
			$this->email->send();
			//Move to success page
			$data['paid']=0;
			$data['order_id']=$order_id;
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('store/order_success',$data);
			$this->load->view('general/footer');
		}
	}
	public function payment_process()
	{
		if($_POST['rescode']=='00'||$_POST['rescode']=='08'||$_POST['rescode']=='11')
		{
			//Remove cart
			unset($_SESSION['cart']);
			//Success, update status to paid
			$this->store_model->mark_paid($_POST['refid']);
			//Send invoice
			$o=$this->store_model->get_order($_POST['refid'])[0];
			$order_id=$o->order_id;
			$auth_token=sha1($o->firstname."|".$o->lastname."|".$o->order_id."|".$o->order_total);
			$email=$o->delivery_email;
			$config['protocol'] = 'sendmail';
			$config['smtp_host'] = 'localhost';
			$config['smtp_user'] = '';
			$config['smtp_pass'] = '';
			$config['smtp_port'] = 25;
			$this->load->library('email', $config);
			$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
			$this->email->to($email);
			$this->email->subject('Purchase Order for Order #'.$order_id.' at Hospital Caterings');
			$this->email->message("The purchase order for your order at Hospital Caterings (Order #".$order_id.") can be viewed at: http://hospitalcaterings.com.au/ipswich/index.php/orders/print_order/".$order_id."/".$auth_token."\r\nThank you, and have a great day!\r\nRegards,\r\nTeam Hospital Caterings");
			$this->email->send();
			
			$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
			$this->email->to('jackie@cafeonthehilltop.com.au');
			$this->email->subject('New order');
			$this->email->message("A new order has been placed: \r\nOrder ID: ".$order_id."\r\n"."http://hospitalcaterings.com.au/ipswich/index.php/orders/edit_order/".$order_id);
			$this->email->send();
			//Move to success page
			$data['paid']=1;
			$data['order_id']=$order_id;
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('store/order_success',$data);
			$this->load->view('general/footer');
		}
		else
		{
			//Remove order from db
			$this->store_model->remove_order($_POST['refid']);	
			$data['cart']=$this->session->userdata('cart');
			$data['customer']=$this->store_model->fetch_customer($this->session->userdata('customer_id'));
			$total_count=0;
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				foreach($header_data['cart_items'] as $item){
					$total_count+=$item['quantity'];
				}
			}
			else $header_data=array();
			$header_data['item_count']=$total_count;
			$header_data['page']='checkout';
			$data['fail']='1';
			$this->load->view('general/header',$header_data);
			$this->load->view('store/checkout',$data);
			$this->load->view('general/footer');
		}
	}
	public function logout()
	{
		session_destroy();
		redirect(base_url());
	}
	public function securepay_link($order_id)
	{
		$o=$this->store_model->get_order($order_id)[0];
		print_r($o);
		exit;
		if(empty($o->coupon_id))
			$discount=0;
		else{
			if($o->type=='F')
				$discount=$o->coupon_discount;
			else $discount=($o->order_total+$o->delivery_fee)*$o->coupon_discount/100;
		}
		$total=(int)(($o->order_total+$o->delivery_fee-$discount)*100);
		echo $total;
            $elem="<form id=\"securepay_form\" action=\"https://payment.securepay.com.au/secureframe/invoice\" method=\"post\">";
			$elem.="<input type=\"hidden\" name=\"bill_name\" value=\"transact\">";
			$elem.="<input type=\"hidden\" name=\"merchant_id\" value=\"2Q40331\">";
			$elem.="<input type=\"hidden\" name=\"primary_ref\" value=\"".$order_id."\">";
			$elem.="<input type=\"hidden\" name=\"fp_timestamp\" value=\"".gmdate("YmdHis")."\">";
			$elem.="<input type=\"hidden\" name=\"fingerprint\" value=\"".sha1('2Q40331|Roberta123|0|'.$order_id."|".(int)($order_total*100)."|".gmdate("YmdHis"))."\">";
			$elem.="<input type=\"hidden\" name=\"amount\" value=\"".(int)($order_total*100)."\">";
			$elem.="<input type=\"hidden\" name=\"txn_type\" value=\"0\">";
			$elem.="<input type=\"hidden\" name=\"currency\" value=\"AUD\">";
			$elem.="<input type=\"hidden\" name=\"return_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"return_url_target\" value=\"parent\">";
			$elem.="<input type=\"hidden\" name=\"cancel_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"callback_url\" value=\"".base_url()."index.php/store/payment_process\">";
			$elem.="<input type=\"hidden\" name=\"template\" value=\"default\">";
			$elem.="<input type=\"hidden\" name=\"display_receipt\" value=\"no\">";
			$elem.="<input type=\"hidden\" name=\"display_cardholder_name\" value=\"no\">";
			$elem.="</form>";
			$data['elem']=$elem;
		$data['elem']=$elem;
		$this->load->view('store/process_payment',$data);
	}
}
