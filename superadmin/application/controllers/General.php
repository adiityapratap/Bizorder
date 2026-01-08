<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends MY_Controller {
    function __construct() {
		parent::__construct();
		$this->load->model('general_model');
	}
	public function index(){
	    
	}
	public function record_delete(){
	    $id = $_POST["id"];
    	$table_name = $_POST["table_name"];
    	
    	$postData = array(
    	    'is_deleted' => 1,
    	    'deleted_at' => date('Y-m-d'),
    	    );
    	$res=$this->general_model->update($table_name,$id,$postData);
        if($res){
           echo "deleted";
        }else{
           echo "error";
        }
	}

}
