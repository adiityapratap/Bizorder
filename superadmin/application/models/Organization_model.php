<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Organization_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	
    public function fetchDbDetails($id=''){
	    if($id != ''){
	        $whereCon = 'o.orz_db_details_id = '.$id;
	    }else{
	        $whereCon = 1;
	    }
	   // echo "SELECT * FROM orz_db_details as o  LEFT JOIN organization_list as org ON o.orz_id = org.organization_list_id  WHERE org.is_deleted = 0 AND ".$whereCon; exit;
		$query=$this->db->query("SELECT * FROM orz_db_details as o  LEFT JOIN organization_list as org ON o.orz_id = org.organization_list_id  WHERE org.is_deleted = 0 AND ".$whereCon );
		$res=$query->result();
		return $res;
	}
}
