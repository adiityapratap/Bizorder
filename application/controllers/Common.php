<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends MY_Controller {
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $common_model;
	public $location_id;
	
    function __construct() {
		parent::__construct();
		
		$this->load->model('common_model');
	    !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
		$this->location_id = $this->session->userdata('location_id');
	
	}
	
	function fetchRecordsDynamicallyAjax(){
	   
	 $postedData = json_decode($this->input->post('postData'), true);
	 $table = $postedData[0]['tableName'];
	 $fieldsToFetch = $postedData[0]['fields'];
	 $conditions = $postedData[0]['conditions'];

	 $result = $this->common_model->fetchRecordsDynamically($table,$fieldsToFetch,$conditions);   
	 echo json_encode($result);
	}
	
	
	
	
	
	
	
	
}