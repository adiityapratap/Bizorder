<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Notification extends MY_Controller
{
	public $data = [];
	
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $auth_model;
	public $general_model;

	public function __construct()
	{
		parent::__construct();
	    $this->load->model('auth_model');
	    $this->load->model('general_model');
	    !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
	
	}
	
	public function notification(){
	    
	     $result = fetchAllUnreadNotification($this->tenantDb,$this->session->userdata('location_id'),1);
	     $resultRead = fetchAllUnreadNotification($this->tenantDb,$this->session->userdata('location_id'),0);
        $data['unreadNotifications'] = (isset($result['result']) ? $result['result'] : ''); 
        $data['readNotifications'] = (isset($resultRead['result']) ? $resultRead['result'] : '');
       
         $this->load->view('general/landingPageHeader',$data);
		$this->load->view('notificationListing',$data);
		 $this->load->view('general/landingPageFooter');
	}
	
}

?>