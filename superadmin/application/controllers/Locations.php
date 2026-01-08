<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('location_model');
		$this->load->model('general_model');
	}
	public function index(){
	    if($this->session->userdata('IsUserLogged')){
	        
	        $res=$this->location_model->fetchAllRecord();
	       // echo "<pre>"; print_r($res); exit;
	        $data['record'] = $res;
	        $data['controller_add'] = 'locations/add'; 
	        $data['controller_edit'] = 'locations/edit'; 
	        $data['controller_view'] = 'locations/view'; 
	        
	        $data['page_title'] = 'Locations List';
	        $data['table_name'] = 'locations_list';
	      
            
	        $data['table_action'] = array('view','edit','delete');
	        
	        $this->load->view('general/header');
    		$this->load->view('locations/listing',$data);
    		$this->load->view('general/footer');
		
	    }else{
	        redirect('auth');
	    }
	    
		
	}
	
	public function add(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	            $filename = ''; 
	           
	           $postData= array(
	               'location_name' => $_POST['locationName'],
	               'date_added' => date('Y-m-d'),
	               );
	           $res=$this->general_model->add('locations_list',$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record added successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to add record');
	           }
	           redirect('organization');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }	
	}
	public function updateLocations(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	         
	           
	           $postData= array(
	               'location_name' => $_POST['locationName'],
	               'date_added' => date('Y-m-d'),
	               );
	          $id =$_POST['id'];
	            $res=$this->location_model->update($id,$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record added successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to add record');
	           }
	           redirect('organization');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }	
	}
	public function changeStatus(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){

	           $postData= array(
	               'location_list_status' => $_POST['status'],
	               );
	          $id =$_POST['id'];
	            $res=$this->location_model->update($id,$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record added successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to add record');
	           }
	          
	        }
	        
		
	    }else{
	        echo "error";
	    }	
	}
	public function delete(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	           $postData= array(
	               'is_deleted' => 1,
	               );
	          $id =$_POST['id'];
	            $res=$this->location_model->update($id,$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record deleted successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to delete record');
	           }
	          
	        }
	        
		
	    }else{
	        echo "error";
	    }	
	}
}
