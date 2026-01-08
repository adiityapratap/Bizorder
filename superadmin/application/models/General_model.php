<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	public function fetchAllRecord($table_name,$id='',$columnForWhereCond='',$resultType='',$sortby=''){
	    if($columnForWhereCond !=''){
	        $whereCon = $columnForWhereCond." = ".$id;    
	    }else
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
	    if($sortby !=''){
	     $sortBy ='ORDER BY `menu`.`sort_order` ASC';
	    }else{
	       $sortBy = '';
	    }
		$query=$this->db->query("SELECT * FROM ".$table_name." WHERE is_deleted = 0 AND ".$whereCon." ".$sortBy );
		return ($resultType == '' ? $query->result() : $query->result_array());
	
	}
	public function fetchRecord($table_name,$id=''){
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
		$query=$this->db->query("SELECT * FROM ".$table_name." WHERE ".$table_name."_status != 0 AND ".$whereCon );
		$res=$query->result();
		return $res;
	}
	public function add($table_name,$data){
		 $this->db->insert($table_name, $data);
	return	$this->db->insert_id();
	}
    public function update($table_name,$id,$data,$columnForWhereCond=''){
        if($columnForWhereCond !=''){
	        $idName = $columnForWhereCond;    
	    }else
	    if($id != ''){
	        $idName = $table_name."_id";
	    }else{
	        $idName = 0;
	    }
		$this->db->where($idName, $id);
        return $this->db->update($table_name, $data);
	}
}
