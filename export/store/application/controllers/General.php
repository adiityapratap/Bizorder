<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('general_model');
	}
	public function index($modal='')
	{
		$data['modal']=$modal;
		$this->load->view('general/login',$data);
	}
	public function signup()
	{
		$this->load->view('general/signup');
	}
	public function signup_process()
	{
		//If username is empty, use the part before the "@" in email
		if(empty($_POST['username'])){
			$username=explode("@",$_POST['email'])[0];
		}
		else $username=$_POST['username'];
		$password=sha1($_POST['password']);
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$email=$_POST['email'];
		$this->general_model->create_user($username,$password,$firstname,$lastname,$email);
		$modal="1";
		redirect('general/index/'.$modal);
	}
	public function verify_email($email,$auth)
	{
		$regen_auth=$this->general_model->get_auth($email);
		if($auth==$regen_auth)
		{
			$this->general_model->set_active($email);
			redirect('general/index/2');
		}
	}
	public function check_email_exists($email)
	{
		echo $this->general_model->check_email_exists($email);
	}
	public function login_process()
	{
		$username=$_POST['username'];
		$password=sha1($_POST['password']);
		$user=$this->general_model->check_login($username,$password);
		if(empty($user)){
			redirect('general/index/3');
		}
		else{
			//Set session variables here
			$this->session->set_userdata('username',$user[0]->username);
			$this->session->set_userdata('customer_id',$user[0]->customer_id);
			$this->session->set_userdata('firstname',$user[0]->firstname);
			$this->session->set_userdata('lastname',$user[0]->lastname);
			redirect('store/home');
		}
	}
	public function past_orders()
	{
		if(!empty($this->session->userdata('customer_id'))){
			$data['orders']=$this->general_model->fetch_orders_by_customer($this->session->userdata('customer_id'));
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('general/past_orders',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function profile()
	{
		if(!empty($this->session->userdata('customer_id'))){
			$data=$this->general_model->fetch_customer($this->session->userdata('customer_id'));
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('general/profile',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function forgot_password()
	{
		$email=$_POST['email'];
		$auth=$this->general_model->get_auth($email);
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
		$this->load->library('email', $config);
		$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
		$this->email->to($email);
		$this->email->subject('Account Verification');
		$this->email->message("Hello\r\nA password reset request was sent for this email address. Please click the link below to reset your password.\r\n".base_url()."index.php/general/reset_password/".$email."/".$auth."\r\nIf this was not you, you can safely ignore this email.\r\nLooking forward to serving you fresh and healthy meals again!\r\nTeam Hospital Caterings");
		$this->email->send();
		redirect('general/index/4');
	}
	public function healthy_choices()
	{
		if(!empty($this->session->userdata('customer_id'))){
			$data['orders']=$this->general_model->fetch_orders_by_customer($this->session->userdata('customer_id'));
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('general/healthy_choices',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function contact_us()
	{
		if(!empty($this->session->userdata('customer_id'))){
			$data['orders']=$this->general_model->fetch_orders_by_customer($this->session->userdata('customer_id'));
			if(!empty($this->session->userdata('cart')))
			{
				$header_data['cart_items']=$this->session->userdata('cart');
				$header_data['count']=count($this->session->userdata('cart'));
			}
			else $header_data=array();
			$this->load->view('general/header',$header_data);
			$this->load->view('general/contact_us',$data);
			$this->load->view('general/footer');
		}
		else redirect('general/index');
	}
	public function reset_password($email,$auth)
	{
		$check_auth=$this->general_model->get_auth($email);
		if($auth==$check_auth){
			//They match
			$data['email']=$email;
			$this->load->view('general/reset_password',$data);
		}
		else{
			die('Oops! Access denied.');
		}
	}
	public function reset_password_process()
	{
		$this->general_model->change_password($_POST['email'],sha1($_POST['password']));
		redirect('general/index/5');
	}
	public function contact()
	{
		$email='jackie@cafeonthehilltop.com.au';
		$auth=$this->general_model->get_auth($email);
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
		$this->load->library('email', $config);
		$this->email->from('noreply@hospitalcaterings.com.au','Hospital Caterings');
		$this->email->to($email);
		$this->email->reply_to($_POST['email'], $_POST['name']);
		$this->email->subject('New message from contact form');
		$this->email->message("Hello\r\nUser ".$_POST['name']." left a message on the contact form:\r\nName: ".$_POST['name']."\r\nEmail: ".$_POST['email']."\r\nPhone: ".$_POST['phone']."\r\nMessage: ".$_POST['message']."\r\n");
		$this->email->send();
		echo "1";
	}
	public function faqs()
	{
		$data['orders']=$this->general_model->fetch_orders_by_customer($this->session->userdata('customer_id'));
		if(!empty($this->session->userdata('cart')))
		{
			$header_data['cart_items']=$this->session->userdata('cart');
			$header_data['count']=count($this->session->userdata('cart'));
		}
		else $header_data=array();
		$this->load->view('general/header',$header_data);
		$this->load->view('general/faqs',$data);
		$this->load->view('general/footer');
	}
}
