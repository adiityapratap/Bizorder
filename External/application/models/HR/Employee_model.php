<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	
	function update_employee($data_user,$id){
		 $this->tenantDb->where('emp_id',$id);
		 return $this->tenantDb->update('HR_employee',$data_user);
	}


}

?>