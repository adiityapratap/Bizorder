<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('location_model');
		$this->load->model('general_model');
	}
	public function menu_list($system_id){
	    if($this->session->userdata('IsUserLogged')){
	        
	        $res=$this->general_model->fetchAllRecord('menu',$system_id,'menu_for','array','sort');
	       
	        
	        $data['record'] = $res;
	        $data['controller_add'] = 'menu/add'; 
	        $data['controller_edit'] = 'menu/edit'; 
	        $data['controller_view'] = 'menu/view'; 
	        
	        $data['page_title'] = 'Menus';
	       
	        $data['system_id'] = $system_id;
	      
            
	        $data['table_action'] = array('view','edit','delete');
	        
	        $this->load->view('general/header');
    		$this->load->view('menu/listing',$data);
    		$this->load->view('general/footer');
		
	    }else{
	        redirect('auth');
	    }
	    
		
	}
	
	public function add(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	           $postData= array(
	               'menu_name' => $_POST['menuName'],
	               'menu_url' => $_POST['menuUrl'],
	               'menu_for' => $_POST['system_id'],
	               );
	             
	           $res=$this->general_model->add('menu',$postData);
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
	public function addSubMenu(){
	     $subMenus = $this->input->post('subMenuNames'); 
	     $subMenuUrl = $this->input->post('subMenuUrl');
         $parent_menu_id = $this->input->post('parent_menu_id');
        $postData= array('is_deleted' => 1);
	    $res=$this->general_model->update('sub_menu',$parent_menu_id,$postData,'parent_menu_id');
	           
        $data = array();
        $counter =0;
        foreach ($subMenus as $subMenusInput) {
            $data[] = array(
                'sub_menu_name' => $subMenusInput, 
                'sub_menu_url' => $subMenuUrl[$counter],
                'parent_menu_id' => $parent_menu_id,
                'sort_order' => $counter
            );
            $counter++;
        }

        $res = $this->db->insert_batch('sub_menu', $data);
     echo "success";
	}
	public function fetchSubmenuFromMenuID(){
	  $parent_menu_id = $_POST['parent_menu_id'];
	   $res=$this->general_model->fetchAllRecord('sub_menu',$parent_menu_id,'parent_menu_id','array');
	   echo json_encode($res);
	}
	public function updateMenu(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	           $postData= array(
	               'menu_name' => $_POST['menuName'],
	               'menu_url' => $_POST['menuUrl'],
	               );
	          $id =$_POST['id'];
	        
	            $res=$this->general_model->update('menu',$id,$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record updated successfully');
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
	               'status' => $_POST['status'],
	               );
	          $id =$_POST['id'];
	            $res=$this->general_model->update('menu',$id,$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record updated successfully');
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
	           $res=$this->general_model->update('menu',$id,$postData);
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
