<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {
    function __construct() {
		parent::__construct();
	    $this->load->model('configfoodmenu_model');
	    $this->selected_location_id = $this->session->userdata('location_id');
	   !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
	    $this->load->model('menu_model');
	    $this->load->model('common_model');
	    $this->load->model('order_model');
	}
	
	function index(){
	    
	    $hospitalSettingsData = $this->common_model->commonGetLatestRecord('departmentSettings','','');
            if(isset($hospitalSettingsData) && !empty($hospitalSettingsData)){
             $data['departmentLatestSettingsData']  = $hospitalSettingsData;
            }else{
              $data['departmentLatestSettingsData']  = array();  
            }
    // echo "<pre>"; print_r($data['departmentLatestSettingsData']); exit;
        $this->load->view('general/header');
        $this->load->view('Settings/configure',$data);
        $this->load->view('general/footer');
	}
	
    
    
    
    function saveHospitalSettings(){
        $data = $this->input->post();
        
        $todaysDate = date('Y-m-d');
      
        $hospitalSettingsData = $this->common_model->fetchRecordsDynamically('departmentSettings','','');
        
        
         $insertUpdateData = [
             
            'hospital_company_name' => $data['hospital_company_name'],
            'hospital_company_addr'        => $data['hospital_company_addr'] ?? null,
            'hospital_abn'         => $data['hospital_abn'] ?? null,
            'hospital_email'           => $data['hospital_email'] ?? null,
            'hospital_phone'           => $data['hospital_phone'] ?? null,
            
            'department_id' => $data['department_id'],
            'daily_budget'        => $data['daily_budget'] ?? null,
            'daily_limit'         => $data['daily_limit'] ?? null,
            'cafe_email'           => $data['cafe_email'] ?? null,
            'cafe_phone'           => $data['cafe_phone'] ?? null,
            'company_name'           => $data['company_name'] ?? null,
            'company_addr'           => $data['company_addr'] ?? null,
            'abn'           => $data['abn'] ?? null,
            'account_name'    => $data['account_name'] ?? null,
            'account_email'    => $data['account_email'] ?? null,
            'terms'    => $data['terms'] ?? null,
            'account_no'    => $data['account_no'] ?? null,
            'bsb'           => $data['bsb'] ?? null,
            'date_added'           => $todaysDate,
        ];
        
        if(isset($hospitalSettingsData) && !empty($hospitalSettingsData)){
         $settingsId =$hospitalSettingsData[0]['id'];
        $this->common_model->commonRecordUpdate('departmentSettings','id',$settingsId,$insertUpdateData);    
        $insertID = true;
       }else{
        $insertID = $this->common_model->commonRecordCreate('departmentSettings',$insertUpdateData);      
        }
      echo json_encode(['status' => 'success', 'message' => 'Settings saved successfully!']);    
    }
	
}