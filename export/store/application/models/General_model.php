<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model{	
	function __construct() {
		parent::__construct();
	}
	public function create_user($username,$password,$firstname,$lastname,$email)
	{
		$username=$this->db->escape($username);
		$firstname=$this->db->escape($firstname);
		$lastname=$this->db->escape($lastname);
		$email=$this->db->escape($email);
		$this->db->query("INSERT INTO user VALUES (null,".$username.",'".$password."',3)");
		$user_id=$this->db->insert_id();
		$this->db->query("INSERT INTO customer VALUES (null,".$firstname.",".$lastname.",".$email.",null,null,'".date("Y-m-d H:i",strtotime("now"))."',1,0,null,null,0,".$user_id.")");
		$customer=$this->db->insert_id();
		$query=$this->db->query("SELECT * FROM customer WHERE customer_id=".$customer);
		$res=$query->result()[0];
		//Send authentication mail, with auth token = sha1(firstname|lastname|email)
		$auth=sha1($res->firstname."|".$res->lastname."|".$res->customer_email);
		$email=$res->customer_email;
		$config['protocol'] = 'sendmail';
		$config['smtp_host'] = 'localhost';
		$config['smtp_user'] = '';
		$config['smtp_pass'] = '';
		$config['smtp_port'] = 25;
		$this->load->library('email', $config);
		$this->email->from('noreply@hospitalcaterings.com.au', 'Hospital Caterings');
		$this->email->to($email);
		$this->email->subject('Account Verification');
		$this->email->message("Hello\r\nAn account has been created for this email ID at Hospital Caterings. Please click on the link below, or copy and paste it into your browser to verify your email ID.\r\n".base_url()."index.php/general/verify_email/".$res->customer_email."/".$auth."\r\n\r\nThank you for signing up, and looking forward to serving you healthy meals!\r\n\r\nTeam Hospital Caterings");
			$this->email->send();
	}
	public function get_auth($email)
	{
		$query=$this->db->query("SELECT * FROM customer WHERE customer_email='".$email."'");
		$res=$query->result()[0];
		$auth=sha1($res->firstname."|".$res->lastname."|".$res->customer_email);
		return $auth;
	}
	public function set_active($email)
	{
		$this->db->query("UPDATE customer SET status=1 WHERE customer_email='".$email."'");
	}
	public function check_email_exists($email)
	{
		$query=$this->db->query("SELECT * FROM customer WHERE customer_email='".$email."'");
		if(!empty($query->result()))
			return "1";
		else return "0";
	}
	public function check_login($username,$password)
	{
		$query=$this->db->query("SELECT * FROM user u JOIN customer c ON u.user_id=c.user_id WHERE (username='".$username."' OR customer_email='".$username."') AND password='".$password."' AND auth_level=3 AND status=1");
		$res=$query->result();
		return $res;
	}
	public function fetch_orders_by_customer($customer_id)
	{
		$query=$this->db->query("SELECT * FROM orders o join customer c on o.customer_id=c.customer_id where o.customer_id=".$customer_id." order by order_id desc");
		return $query->result();
	}
	public function fetch_customer($customer_id)
	{
		$query=$this->db->query("SELECT * FROM customer where customer_id=".$customer_id);
		return $query->result()[0];
	}
	public function change_password($email,$password)
	{
		$query=$this->db->query("UPDATE user SET password='".$password."' WHERE user_id=(select user_id from customer where customer_email='".$email."')");
	}
}
?>