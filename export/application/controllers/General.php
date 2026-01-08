<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('general_model');
		
		$this->load->model('orders_model');
	}
	public function index()
	{
		$this->load->view('general/login');
	}
	public function login()
	{
	    


		$username=$_POST["username"];
		$password=$_POST["password"];
		$res=$this->general_model->validateLogin($username,$password);
	
		if(empty($res))
		{
			//Login failed
			$data['login_error']=1;
			$this->load->view('general/login',$data);
		}
		else
		{
			//Login successful, open dashboard
		
			$this->session->set_userdata('username',$res[0]->username);
			$this->session->set_userdata('email',$res[0]->email);
			$this->session->set_userdata('user_id',3);
			$this->session->set_userdata('branch_id',3);
			$this->session->set_userdata('is_customer',$res[0]->is_customer);
			
			$this->session->set_userdata('account_uid',$res[0]->account_uid);
			$this->session->set_userdata('guid',$res[0]->guid);
				
			$this->session->set_userdata('auth_level',$res[0]->auth_level);
			$this->session->set_userdata('merchant_id',$res[0]->merchant_id);
			$this->session->set_userdata('merchant_pass',$res[0]->merchant_pass);
			$this->session->set_userdata('abn',$res[0]->abn);
			
			$this->session->set_userdata('company_name',$res[0]->company_name);
			$this->session->set_userdata('account_name',$res[0]->account_name);
			$this->session->set_userdata('account_number',$res[0]->account_number);
			$this->session->set_userdata('bsb',$res[0]->bsb);
			$this->session->set_userdata('user_com_addr',$res[0]->user_com_addr);
			
			redirect('orders/open_dash');
// 			$this->load->view('general/header');
// 			$this->load->view('general/branches');
// 			$this->load->view('general/footer');
		}
	}
	
	


	public function products($page=1)
	{
		if(!empty($this->session->userdata('username')))
		{
			$products['products']=$this->general_model->fetch_products($page);
			$products['page']=$page;
			$products['max_page']=$this->general_model->fetch_max_pages('product');
			$products['categories']=$this->general_model->fetch_categories();
//			echo "<pre>".print_r($products,1);exit;
			$this->load->view('general/header');
			$this->load->view('general/products',$products);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	
	 function delete_product($productId){
	    $this->orders_model->deleteProduct($productId);
	    redirect('general/products/1');
	}
	public function fetch_products_for_category($category){
		$products=$this->general_model->fetch_products_for_category($category);
		$res='';
		if(!empty($products)){
			foreach($products as $product){
				$res.="<input type=\"hidden\" id=\"price-".$product->product_id."\" value=\"".$product->product_price."\">";
				if(!empty($product->heading)&&$heading!=$product->heading){
					$res.="<tr><td colspan=\"5\"><strong>".$product->heading."</strong></td></tr>";
				}
				$res.="<tr id=\"product-row-".$product->product_id."\" data-heading=\"".$product->heading."\">";
				$res.="<td>".$product->product_name."</td>";
				$res.="<td>".ucwords($product->category_name)."</td>";
				$res.="<td>$".number_format($product->product_price,2)."</td>";
				$res.="<td>";
				if(empty($product->options)){
					$res.="<input class=\"form-control\" type=\"text\" id=\"qty-".$product->product_id."\" placeholder=\"0\">";
				}
				else{
					$res.="<button type=\"button\" class=\"btn btn-primary\" onclick=\"open_modal(".$product->product_id.")\">Options</button>";
				}
				$res.="</td>";
				$res.="<td>";
				if(empty($product->options))
					$res.="<button type=\"button\" class=\"btn btn-info new-product-form\" id=\"new-product-".$product->product_id."\">Add</button>";
				$res.="</td>";
				$res.="</tr>";
				$heading=$product->heading;
			}
		}
		echo $res;
	}
	

	
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('general/index');
	}

	


}
