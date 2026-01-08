<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Configfoodmenu_model extends CI_Model{
	

	function __construct() {
		parent::__construct();
	}

	   public function addFoodMenuConfig($data){
	       // echo "<pre>"; print_r($data); exit;
	    return $this->tenantDb->insert('foodmenuconfig',$data);
		}


      function delete($id){	
     	$data = array(
		   'is_deleted' => 1,
		    'updated_date'=> date("Y-m-d")
		    );
		 
          $this->tenantDb->set($data);
          $this->tenantDb->where('id', $id);
          $this->tenantDb->update('foodmenuconfig');
         return true;
       } 
		
        public function get_category_by_id($id){

			$this->tenantDb->select('id,name,created_date');
			$this->tenantDb->where('id' , $id);
	       return	$query = $this->tenantDb->get('foodmenuconfig')->result_array;					 

		}

        public function updateMenuConfig($data){
			$Newdata = array(
	     	'name' => $data['name'],
	     	'inputType' => $data['inputType'],
	    	'updated_date'=> date("Y-m-d")
		      );

           $this->tenantDb->set($Newdata);
           $this->tenantDb->where('id', $data['id']);
           $this->tenantDb->update('foodmenuconfig');
         return true;
		}
}