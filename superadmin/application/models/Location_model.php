<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Location_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	public function fetchAllRecord($id=''){
	    if($id != ''){
	        $whereCon = "location_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
		$query=$this->db->query("SELECT * FROM locations_list WHERE is_deleted = 0 AND ".$whereCon );
		$res=$query->result_array();
		return $res;
	}
	
	public function update($id,$data){
		$this->db->where('location_id', $id);
         return $this->db->update('locations_list', $data);
        //  echo $this->db->last_query();
	}
	
    
}