<?php

class Float_model extends CI_Model{
	
    function __construct() {
		parent::__construct();
	
	}
	
	
         function officeBuildUpdate($data,$id){	
 
         $builder = $this->tenantDb;		 
         $builder->set($data);
         $builder->where('id', $id);
         $builder->update('CASH_ci_officeBuild');
        //  echo $queryyyy = $builder->getLastQuery(); exit;
         return true;
} 	
        
         public function getOfficeBuildByID($id){
	
		    $builder = $this->tenantDb;
	         $query = $builder->select('*')
                     ->where('id',$id)
                      ->get('CASH_ci_officeBuild');
                       if ($query === false) {
                          return $FrontOfficeBuild =  array();
                       } else {
                       $FrontOfficeBuild = $query->result_array();
                       }
                    
                     return $FrontOfficeBuild[0];
		}
	
	
	
}