<?php
class Config_model extends CI_Model{
	
    function __construct() {
		parent::__construct();
		$this->selected_location_id = $this->session->userdata('location_id');
	}
    // Configuration of mail
    function configureAutomatedNotificationsubmit($data,$id=''){
	        $builder = $this->tenantDb;
	        $systemDetails = fetchSystemDetailsFromSystem_id($this->session->userdata('system_id'));
		    $data['location'] = $this->selected_location_id;
		    $data['system_id'] = $this->session->userdata('system_id'); 
		    $data['systemName'] = (isset($systemDetails->system_name) ? $systemDetails->system_name : '');
		    if($id){
		     
		      $builder->set($data);
              $builder->where('id', $id);
              $builder->update('Global_configuration'); 
            return true;
		    }else{
		    
		     $builder->insert('Global_configuration',$data);  
		     $id = $this->tenantDb->insert_id();
		     return true;   
		    }  
	    
	}
		public function deleteConfig($id){
		 $this->tenantDb->where('id', $id);
         $this->tenantDb->delete('Global_configuration');   
          return true;
		}
	 public function getConfiguration($configureFor,$metaData=''){
	     $conditions = array(
	         'location' => $this->selected_location_id,
	         );
	        ($configureFor !='' ? $conditions['configureFor'] = $configureFor : '');
	        ($metaData !='' ? $conditions['metaData'] = $metaData : '');
	       //(isset($metaData) && $metaData !='' ? $conditions['metaData'] = $metaData : '');
		   $builder = $this->tenantDb;
	       $query = $builder->select('id,data,configureFor,time_of_notification')
                     ->where($conditions)
                     ->get('Global_configuration');
                      if ($query === false) {
                         return  $resultData =  array();
                       } else {
                       $resultData = $query->result_array();
                       }
      
                     return $resultData;
		}	
    
}