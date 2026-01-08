<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('general_model');
		$this->load->model('orders_model');
		$this->load->library('email');
		$this->fromEmail = 'catering@healthychoicescatering.com.au';
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
		
			$this->session->set_userdata('is_customer',$res[0]->is_customer);
			$this->session->set_userdata('userID',$res[0]->user_id);
			$this->session->set_userdata('account_uid',$res[0]->account_uid);
			$this->session->set_userdata('guid',$res[0]->guid);
			$this->session->set_userdata('auth_level',$res[0]->auth_level);
			$this->session->set_userdata('abn',$res[0]->abn);
			
			$this->session->set_userdata('company_name',$res[0]->company_name);
			$this->session->set_userdata('account_name',$res[0]->account_name);
			$this->session->set_userdata('account_number',$res[0]->account_number);
			$this->session->set_userdata('bsb',$res[0]->bsb);
			$this->session->set_userdata('user_com_addr',$res[0]->user_com_addr);
			
			redirect('general/branches');
			

		}
	}
	public function fetchCostCenterData(){
	    $customer_id= $_POST['customer_id'];
	    $CDetails = $this->orders_model->getCostCenterById($customer_id);
	    echo json_encode($CDetails);
	}
	public function approve_cost_center()
	{
	    $customer_id=$_POST['customer_id'];
	    $approve=$_POST['approve'];
	  
      $response = $this->orders_model->approve_cost_center($customer_id,$approve);
      $Maildata['mail_text'] = 'Your account has been approved by our catering manager';

      $CDetails = $this->orders_model->getCostCenterById($customer_id);
      $Maildata['customer_name'] = $CDetails[0]->fullname;
      $toemail = $CDetails[0]->email;
       $Maildata['account_number'] = $CDetails[0]->account_number;
       $Maildata['account_pin'] = $CDetails[0]->account_pin;
     
      if($response=='true'){
       $this->sendMail('cost_center_account_approval',$Maildata,$toemail);
       echo "Mail sent";
      }
     
      echo "success";
	
	}
	
		public function updateCostCenter()
	{
	    $cost_center_id=$_POST['cost_center_id'];
	    $accountNo=($_POST['account_number'] == ' Not Generated Yet '? '' : $_POST['account_number']);
	    $accountPin=($_POST['account_pin'] == ' Not Generated Yet '? '' :$_POST['account_pin']);
	    $fullname=$_POST['fullname'];
	    $location_id=$_POST['location_id'];
	    $email=$_POST['email'];
	    $telephone=$_POST['telephone'];
	    $company_name=$_POST['company_name'];
	    $department_name=$_POST['department_name'];
	    $accounts_contact_number=$_POST['accounts_contact_number'];
	    $accounts_point_of_contact=$_POST['accounts_point_of_contact'];
	    $location_name=$_POST['location_name'];
	  
      
      $Maildata['account_number'] = $accountNo;
      $Maildata['account_pin'] = $accountPin;
      $Maildata['mail_text'] = 'Your account number and pin has been reset.';
      $response = $this->orders_model->updateCostCenter($cost_center_id,$accountNo,$accountPin,$fullname,$location_id,$email,$telephone,$company_name,$department_name,$accounts_contact_number,$accounts_point_of_contact,$location_name);
      $CDetails = $this->orders_model->getCostCenterById($cost_center_id);
      $Maildata['customer_name'] = $CDetails[0]->fullname;
      $toemail = $CDetails[0]->email;
     
      if(($CDetails[0]->account_pin !=$accountPin) || ($CDetails[0]->account_number != $accountNo)){
      $this->sendMail('cost_center_account_approval',$Maildata,$toemail);
       echo "Mail sent";
      }
     
      echo "success";
	
	}
	
	public function sendMail($mailTemplateName='',$data='',$toemail){
	    
	    $body = $this->load->view('orders/Emails/'.$mailTemplateName, $data,TRUE);
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
	public function branches(){
	    $res=$this->general_model->fetchBranches($username,$password);
	    $data['branches']=$res;
	    $this->load->view('general/branches',$data);
		$this->load->view('general/footer');
	}
	public function customers()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$data['companies']=$this->general_model->fetch_companies();
			
			$data['departments']=$this->general_model->fetch_departments();
			
			$data['customers']=$this->general_model->fetch_all_customers();
			
			$this->load->view('general/header');
			$this->load->view('general/customers',$data);
			$this->load->view('general/footer');			
		}
		else redirect('general/index');
	}
	public function fetchCompaniesAndDepartment(){
	  $data['companies'] = $this->general_model->fetch_companies();
	  $data['departments'] = $this->general_model->fetch_departments();
	  echo  json_encode($data);
	}
	public function customers_listing($fromDashboard='')
	{
		if(!empty($this->session->userdata('username')))
		{
		   
			$data['companies']=$this->general_model->fetch_companies();
			$data['departments']=$this->general_model->fetch_departments();
			$data['customers']=$this->general_model->fetch_all_customers();
		  $locations=$this->orders_model->fetchLocations('0');
		  $result=$this->orders_model->fetch_FronteendCustomers();
		  $data['costcenter'] = $result;
		  $data['locations'] = $locations;
		  if($fromDashboard == ''){
		   $data['currentActiveClass1'] = 'active';
		   $data['currentActiveClass2'] = '';
		   
		   $data['currentActiveShowClass1'] = 'active show';
		   $data['currentActiveShowClass2'] = '';
		  }else{
		     $data['currentActiveClass1'] = '';
		   $data['currentActiveClass2'] = 'active'; 
		   
		   $data['currentActiveShowClass1'] = '';
		   $data['currentActiveShowClass2'] = 'active show';
		  }
		  
		
			$this->load->view('general/header');
			$this->load->view('general/customers_listing',$data);
			$this->load->view('general/footer');			
		}
		else redirect('general/index');
	}
	public function department_listing()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$data['companies']=$this->general_model->fetch_companies();
			
			$data['departments']=$this->general_model->fetch_departments();
			
			$data['customers']=$this->general_model->fetch_all_customers();
			
			$this->load->view('general/header');
			$this->load->view('general/department_listing',$data);
			$this->load->view('general/footer');			
		}
		else redirect('general/index');
	}
	public function company_listing()
	{
		if(!empty($this->session->userdata('username')))
		{
		    
			$data['companies']=$this->general_model->fetch_companies();
			
			$data['departments']=$this->general_model->fetch_departments();
			
			$data['customers']=$this->general_model->fetch_all_customers();
			
			$this->load->view('general/header');
			$this->load->view('general/company_listing',$data);
			$this->load->view('general/footer');			
		}
		else redirect('general/index');
	}
	public function new_company()
	{   
		if(!empty($this->session->userdata('username')))
		{
		  	$company=$_POST['company_name'];
			$phone=empty($_POST['company_phone'])?'null':$_POST['company_phone'];
			$abn=empty($_POST['company_abn'])?'null':$_POST['company_abn'];
			$address=empty($_POST['company_address'])?'null':$_POST['company_address'];
			$company_id  =	$this->general_model->new_company($company,$phone,$abn,$address);
			if($company_id){
			  redirect('general/company_listing');  
			}else{
			    redirect('general/company_listing');
			}
			}
		
	}
	
	public function new_department()
	{   
		if(!empty($this->session->userdata('username')))
		{
			$this->general_model->new_department($_POST['company_id'],$_POST['department_name']);
			
		}
		redirect('general/department_listing');
		
	}
	public function new_customer($company_id,$department_id=0)
	{
		if(!empty($this->session->userdata('username')))
		{
			$firstname=$_POST['firstname'];
			$lastname=$_POST['lastname'];
			$email=empty($_POST['email'])?'null':$_POST['email'];
			$phone=empty($_POST['phone'])?'null':$_POST['phone'];
			$fax=empty($_POST['fax'])?'null':$_POST['fax'];
			$address=empty($_POST['address'])?'null':$_POST['address'];
			$cost_centre=empty($_POST['cost_centre'])?'null':$_POST['cost_centre'];
			
			if($company_id == '' && $department_id == 0){
			    $company_id=$_POST['company_id'];
			    $department_id=$_POST['department_id'];
			}
			$this->general_model->new_customer($firstname,$lastname,$email,$phone,$fax,$address,$company_id,$department_id,$cost_centre);
			
		}
	}
// 	code 10 April 2023
	public function add_new_customer($redirectTo='')
	{ 
	     $redirectTo=base64_decode($redirectTo);
	     $redirectTo = urldecode($redirectTo);
		if(!empty($this->session->userdata('username')))
		{
			$firstname=$_POST['firstname'];
			$lastname=$_POST['lastname'];
			$email=empty($_POST['email'])?'null':$_POST['email'];
			$phone=empty($_POST['phone'])?'null':$_POST['phone'];
			$fax=empty($_POST['fax'])?'null':$_POST['fax'];
			$address=empty($_POST['address'])?'null':$_POST['address'];
		    $company_id=(isset($_POST['company_id']) ? $_POST['company_id'] : '');
		    $user_id=(isset($_POST['user_id']) ? $_POST['user_id'] : '');
		    $department_id=(isset($_POST['department_id']) ? $_POST['department_id'] : '');
		    
		$custid =$this->general_model->new_customer($firstname,$lastname,$email,$phone,$address,$company_id,$department_id,$user_id);
			
			if($custid){
			    if($redirectTo !=''){
			       	redirect($redirectTo);  
			    }else{
			      	redirect('general/customers_listing');   
			    }
				    
			}
		
		}
	}
	public function validateCustomer()
	{ 
			
			$result = $this->general_model->checkExistinguser($_POST['customerEmail']);
			echo $result;
		
	}
	public function del_customer()
	{ 
			$customer_id=$_POST['customer_id'];
			$this->general_model->del_customer($customer_id);
		
	}
	public function delete_cost_center()
	{ 
			$cost_centre_id=$_POST['customer_id'];
			$this->general_model->delete_costCenter($cost_centre_id);
		    echo "success";
	}
	public function del_row()
	{
			
			$table_name=$_POST['table_name'];
			if($table_name == 'customers'){
			    $id=$_POST['customer_id'];
			}
			else if($table_name == 'company'){
			    $id=$_POST['company_id'];
			}
			else if($table_name == 'department'){
			    $id=$_POST['department_id'];
			}
			else{
			  $id=$_POST['cost_centre_id'];  
			}
			$this->general_model->del_row($id,$table_name);
		
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
	
	public function fetch_products_for_category2($category){
		$products=$this->general_model->fetch_products_for_category($category);
		$res='';
		if(!empty($products)){
			 foreach($products as $product){
											if(!empty($product->heading)&&$product->heading!=$header)
												echo "<tr><td colspan=\"7\"><strong>".$product->heading."</strong></td></tr>";
											echo "<tr>";
											echo "<td width=\"20%\">".$product->product_name."</td>";
											echo "<td width=\"20%\">";
											echo nl2br($product->product_description);
											if(!empty($product->product_desc_1)||!empty($product->product_desc_2)||!empty($product->product_desc_3)||!empty($product->product_desc_4)||!empty($product->product_desc_5))
											{
												echo "<ul>";
												for($i=1;$i<=5;$i++){
													$prod_str='product_desc_'.$i;
													if(!empty($product->$prod_str))
														echo "<li>".nl2br($product->$prod_str)."</li>";
												}
												echo "</ul>";
											}
											echo "</td>";
											echo "<td width=\"20%\">";
											if(empty($product->options)) echo "No options";
											if(!empty($product->options)){
												foreach($product->options as $option){
													echo $option->name."<br><hr>";
												}
											}
											echo "</td>";
											echo "<td width=\"20%\">".$product->category_name."</td>";
											echo "<td width=\"10%\">$".number_format($product->product_price,2)."</td>";
											echo "<td width=\"5%\">".$product->product_minimum."</td>";
											echo "<td width=\"5%\"><a href=\"".base_url()."index.php/general/edit_product/".$product->product_id."\" class=\"btn btn-danger btn-sm\">Edit</a></td>";
											echo "</tr>";
										$header=$product->heading;
		}
	}
	}
	public function search_products($string)
	{
		$products=$this->general_model->search_products($string);
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
	
	public function search_products2($string)
	{
		$products=$this->general_model->search_products($string);
		$res='';
		if(!empty($products)){
						 foreach($products as $product){
											if(!empty($product->heading)&&$product->heading!=$header)
												echo "<tr><td colspan=\"7\"><strong>".$product->heading."</strong></td></tr>";
											echo "<tr>";
											echo "<td width=\"20%\">".$product->product_name."</td>";
											echo "<td width=\"20%\">";
											echo nl2br($product->product_description);
											if(!empty($product->product_desc_1)||!empty($product->product_desc_2)||!empty($product->product_desc_3)||!empty($product->product_desc_4)||!empty($product->product_desc_5))
											{
												echo "<ul>";
												for($i=1;$i<=5;$i++){
													$prod_str='product_desc_'.$i;
													if(!empty($product->$prod_str))
														echo "<li>".nl2br($product->$prod_str)."</li>";
												}
												echo "</ul>";
											}
											echo "</td>";
											echo "<td width=\"20%\">";
											if(empty($product->options)) echo "No options";
											if(!empty($product->options)){
												foreach($product->options as $option){
													echo $option->name."<br><hr>";
												}
											}
											echo "</td>";
											echo "<td width=\"20%\">".$product->category_name."</td>";
											echo "<td width=\"10%\">$".number_format($product->product_price,2)."</td>";
											echo "<td width=\"5%\">".$product->product_minimum."</td>";
											echo "<td width=\"5%\"><a href=\"".base_url()."index.php/general/edit_product/".$product->product_id."\" class=\"btn btn-danger btn-sm\">Edit</a></td>";
											echo "</tr>";
											$header=$product->heading;
		}
		}
	}
	
	public function new_product()
	{
		if(!empty($this->session->userdata('username')))
		{
			$data['categories']=$this->general_model->fetch_categories();
			$data['all_options']=$this->general_model->fetch_all_options();
			
			$this->load->view('general/header');
			$this->load->view('general/new_product',$data);
			$this->load->view('general/footer');	
		}
		else redirect('general/index');
	}
	public function edit_product($product_id)
	{
		if(!empty($this->session->userdata('username')))
		{
			$data['categories']=$this->general_model->fetch_categories();
			$data['product']=$this->general_model->fetch_product($product_id)[0];
			$data['options']=$this->general_model->fetch_product_options($product_id);
			$data['all_options']=$this->general_model->fetch_all_options();
			$data['product_id']=$product_id;

			$this->load->view('general/header');
			$this->load->view('general/edit_product',$data);
			$this->load->view('general/footer');	
		}
		else redirect('general/index');
	}
	public function add_new_product()
	{
		$product_name=empty($_POST['product_name'])||trim($_POST['product_name'])==''?'null':$_POST['product_name'];
		$amount=$_POST['amount'];
		$category=$_POST['category'];
		if($category==0){
			$category=$this->general_model->new_category($_POST['category_name']);
		}
		$description=empty($_POST['product_description'])||trim($_POST['product_description']=='')?'null':$_POST['product_description'];
		$product_desc_1=empty($_POST['product_desc_1'])||trim($_POST['product_desc_1']=='')?'null':$_POST['product_desc_1'];
		$product_desc_2=empty($_POST['product_desc_2'])||trim($_POST['product_desc_2']=='')?'null':$_POST['product_desc_2'];
		$product_desc_3=empty($_POST['product_desc_3'])||trim($_POST['product_desc_3']=='')?'null':$_POST['product_desc_3'];
		$product_desc_4=empty($_POST['product_desc_4'])||trim($_POST['product_desc_4']=='')?'null':$_POST['product_desc_4'];
		$product_desc_5=empty($_POST['product_desc_5'])||trim($_POST['product_desc_5']=='')?'null':$_POST['product_desc_5'];
		$minimum=$_POST['minimum'];
		$heading=$_POST['product_heading'];

		$options=$_POST['option_value'];
		$product=$this->general_model->add_new_product($heading,$product_name,$amount,$category,$description,$product_desc_1,$product_desc_2,$product_desc_3,$product_desc_4,$product_desc_5,$minimum,$options);
		
		if(empty($product->heading_id)){
			//Has no heading, image bound to product
			$name='product_'.$product->product_id;
		}
		else{
			//Has heading, image bound to heading
			$name='heading_'.$product->heading_id;
		}
		$target_dir = "images/product_images/";
		$target_file = $target_dir . $name .".".pathinfo("/".$_FILES["image_file"]["name"])['extension'];
		$uploadOk = 1;
		if(move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)){
			//Upload Successful
			//Check if it's a heading or product image
			if(empty($product->heading_id)){
				//Product Image
				$this->general_model->set_image($target_file,'product','product_id='.$product->product_id);
			}
			else{
				//Heading image, append to respective tables
				$this->general_model->set_image($target_file,'product_header','heading_id='.$product->heading_id);
			}
		}
		
		redirect('general/products/1');
	}
	public function add_new_product_from_modal()
	{
		$product_name=empty($_POST['product_name'])||trim($_POST['product_name'])==''?'null':$_POST['product_name'];
		$amount=$_POST['amount'];
// 		$category=$_POST['category'];
// 		if($category==0){
// 			$category=$this->general_model->new_category($_POST['category_name']);
// 		}
// 		$description=empty($_POST['product_description'])||trim($_POST['product_description']=='')?'null':$_POST['product_description'];
// 		$product_desc_1=empty($_POST['product_desc_1'])||trim($_POST['product_desc_1']=='')?'null':$_POST['product_desc_1'];
// 		$product_desc_2=empty($_POST['product_desc_2'])||trim($_POST['product_desc_2']=='')?'null':$_POST['product_desc_2'];
// 		$product_desc_3=empty($_POST['product_desc_3'])||trim($_POST['product_desc_3']=='')?'null':$_POST['product_desc_3'];
// 		$product_desc_4=empty($_POST['product_desc_4'])||trim($_POST['product_desc_4']=='')?'null':$_POST['product_desc_4'];
// 		$product_desc_5=empty($_POST['product_desc_5'])||trim($_POST['product_desc_5']=='')?'null':$_POST['product_desc_5'];
// 		$minimum=$_POST['minimum'];
		$product=$this->general_model->add_new_product($product_name,$amount);
		
	   echo json_encode($product);
	}
	

	

	public function update_product($product_id)
	{
		$heading=$_POST['product_heading'];
		$product_name=empty($_POST['product_name'])||trim($_POST['product_name'])==''?'null':$_POST['product_name'];
		$amount=$_POST['amount'];
		$category=$_POST['category'];
		if($category==0){
			$category=$this->general_model->new_category($_POST['category_name']);
		}
		$description=empty($_POST['product_description'])||trim($_POST['product_description']=='')?'null':$_POST['product_description'];
		$product_desc_1=empty($_POST['product_desc_1'])||trim($_POST['product_desc_1']=='')?'null':$_POST['product_desc_1'];
		$product_desc_2=empty($_POST['product_desc_2'])||trim($_POST['product_desc_2']=='')?'null':$_POST['product_desc_2'];
		$product_desc_3=empty($_POST['product_desc_3'])||trim($_POST['product_desc_3']=='')?'null':$_POST['product_desc_3'];
		$product_desc_4=empty($_POST['product_desc_4'])||trim($_POST['product_desc_4']=='')?'null':$_POST['product_desc_4'];
		$product_desc_5=empty($_POST['product_desc_5'])||trim($_POST['product_desc_5']=='')?'null':$_POST['product_desc_5'];
		$minimum=$_POST['minimum'];
		$product=$this->general_model->update_product($product_id,$product_name,$amount,$category,$description,$product_desc_1,$product_desc_2,$product_desc_3,$product_desc_4,$product_desc_5,$minimum,$heading);
		if(empty($heading)){
			//Has no heading, image bound to product
			$name='product_'.$product->product_id;
		}
		else{
			//Has heading, image bound to heading
			$name='heading_'.$product->heading_id;
		}
		$target_dir = "images/product_images/";
		$target_file = $target_dir . $name .".".pathinfo($_FILES["image_file"]["name"])['extension'];
		$uploadOk = 1;
		if(move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)){
			//Upload Successful
			//Check if it's a heading or product image
			if(empty($product->heading_id)){
				//Product Image
				$this->general_model->set_image($target_file,'product','product_id='.$product->product_id);
			}
			else{
				//Heading image, append to respective tables
				$this->general_model->set_image($target_file,'product_header','heading_id='.$product->heading_id);
			}
		}
		redirect('general/products/1');
	}
	public function fetch_product_options($product_id)
	{
		$res=$this->general_model->fetch_product_options($product_id);
		echo json_encode($res);
	}
	public function check_coupon($code='')
	{
		$res=$this->general_model->check_coupon_code($code);
		if($res==0)
			echo $res;
		else echo json_encode($res);
	}
	public function new_coupon()
	{
		$res=$this->general_model->check_coupon_code($_POST['coupon_code']);
		if($res==0){
			$coupon_code=$_POST['coupon_code'];
			$coupon_desc=$_POST['coupon_description'];
			$coupon_discount=$_POST['coupon_discount'];
			$coupon_type=$_POST['coupon_type'];
			$this->general_model->new_coupon($coupon_code,$coupon_desc,$coupon_discount,$coupon_type);
		}
		$this->load->model('orders_model');
		$data['coupons']=$this->orders_model->fetch_active_coupons();
			$data['title']="Active Coupons";
			$this->load->view('general/header');
			$this->load->view('general/coupons',$data);
			$this->load->view('general/footer');	
	}
	public function update_customer()
	{

	    $company_id=$_POST['company_id'];
	    $department_id=$_POST['department_id'];
	    $customer_id=$_POST['customer_id'];
		$first_name=$_POST['first_name'];
	    $last_name =$_POST['last_name'];
	  	 $phone=$_POST['phone'];
		 $email=$_POST['email'];
		 $currentEmail=$_POST['currentEmail'];
		 $customer_status = isset($_POST['customer_status']) ? $_POST['customer_status'] : 0;

		$result = $this->general_model->update_customer($customer_id,$phone,$email,$currentEmail,$customer_status,$first_name,$last_name,$company_id,$department_id);
	
	    echo $result;
	}
	
	
	
     public function update_dept()
     
	{
	   	$dept_id=$_POST['dept_id'];
		$dept_name=$_POST['dept_name'];
	

		
		$this->general_model->update_dept($dept_id,$dept_name);
	}
	
	
	
	public function update_company()
	{
	    
		$company_id=$_POST['company_id'];
		$company_name=$_POST['company_name'];
		$company_phone=$_POST['company_phone'];
		$company_address=$_POST['company_address'];
		$abn=$_POST['abn'];
	
		$this->general_model->update_company($company_id,$company_name,$company_phone,$company_address,$abn);
	}
	public function remove_option($product_option_id)
	{
		$this->general_model->remove_option($product_option_id);
		echo $product_option_id;
	}
	public function add_product_option($product_id,$option_value_id,$options_required)
	{
		$price=$_POST['price'];
		$res=$this->general_model->add_new_product_option($product_id,$option_value_id,$price,$options_required);
		$res=$res[0];
		if($res!=0)
		{
			$return="<tr id=\"product_option_id_".$res->product_option_id."\"><td>".$res->name."</td><td>".$res->option_price_prefix."$".$res->option_price."</td><td><button class=\"btn btn-sm btn-danger\" type=\"button\" onclick=\"remove_option('".$res->product_option_id."')\"><i class=\"fa fa-remove\"></i></button></td></tr>";
			echo $return;	
		}
		else echo 0;
	}
	public function change_required_status($product_id,$status)
	{
		$this->general_model->change_required_status($product_id,$status);
	}
	public function new_options()
	{
		$option=$_POST['option_title'];
		$option_value=$_POST['option_name'];
		$this->general_model->add_option($option,$option_value);
		echo json_encode($this->general_model->fetch_all_options());
	}
	public function fetch_product_headings()
	{
		echo json_encode($this->general_model->fetch_product_headings());
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('general/index');
	}
	public function map_company()
	{
		$this->general_model->map_companies();
	}
	public function map_department()
	{
		$this->general_model->map_departments();
	}
	public function map_customer()
	{
		$this->general_model->map_customer();
	}
	public function map_product()
	{
		$this->general_model->map_product();
	}
	public function map_category()
	{
		$this->general_model->map_category();
	}
	public function map_product_category()
	{
		$this->general_model->map_product_category();
	}
	public function map_option()
	{
		$this->general_model->map_option();
	}
	public function map_option_value()
	{
		$this->general_model->map_option_value();
	}
	public function map_coupon()
	{
		$this->general_model->map_coupon();
	}
	public function map_product_option()
	{ 
		$this->general_model->map_product_option();
	}
	public function map_order()
	{
		$this->general_model->map_order();
	}
	public function map_order_product()
	{
		$this->general_model->map_order_product();
	}
	public function map_order_product_option()
	{
		$this->general_model->map_order_product_option();
	}
	public function map_locations()
	{
		$this->general_model->map_locations();
	}

}
