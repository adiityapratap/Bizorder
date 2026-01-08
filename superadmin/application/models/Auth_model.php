<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	public function validateLogin($email,$password)
	{
		$query=$this->db->query("SELECT * FROM super_admin_cred WHERE email = '" . $email . "' AND password='".sha1($password)."'");
		$res=$query->result();
		return $res;
	}


}
