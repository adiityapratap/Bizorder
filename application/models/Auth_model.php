<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	
	}
	public function validateLogin($email,$password)
	{   
	
		$query=$this->tenantDb->query("SELECT * FROM Global_users WHERE email = '" . $email . "' AND password='".sha1($password)."'");
		$res=$query->result();
		return $res;
	}
	
	public function fetchTenantDbDetails($tenantIdentifier)
	{   
	  
		$query=$this->db->query("SELECT db_host,db_username,db_pass,db_name FROM organization_list WHERE tenant_identifier = '".$tenantIdentifier."'");
		$res=$query->result_array();
		return $res;
	}
	
	public function fetchLocationsFromUserId($userdId)
	{   
	 
		$query=$this->tenantDb->query("SELECT location_ids FROM Global_users WHERE id = '".$userdId."' And active = 1");
	
		if(!empty($query->result_array()[0]['location_ids'])){
		 $locationIds = implode(",", unserialize($query->result_array()[0]['location_ids']));

		 $query=$this->db->query("SELECT location_id,location_name FROM locations_list WHERE location_id IN ( ".$locationIds.")");
		 $res = $query->result_array();
		}else{
		  $res = array();  
		}
		
		return $res;
	}
	
	
	

}
