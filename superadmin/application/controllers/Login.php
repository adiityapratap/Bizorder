<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
	}
	public function index(){
	  
	    if(isset($_POST["email"]) && isset($_POST["password"])){
	        $email=$_POST["email"];
    		$password=$_POST["password"];
    		$res=$this->auth_model->validateLogin($email,$password);
    	
    		if(empty($res))
    		{
    			//Login failed
    			$data['login_error']=1;
    		    $this->load->view('general/login_header');
        		$this->load->view('auth/login'); 
        		$this->load->view('general/login_footer');
    		}
    		else
    		{ 
    			//Login successful, open dashboard
    			$this->session->set_userdata('username',$res[0]->name);
    			$this->session->set_userdata('useremail',$res[0]->email);
    			$this->session->set_userdata('IsUserLogged','1');
    			redirect('organization');
    		}
	    }
	    else{
	       
            $this->load->view('general/login_header');
    		$this->load->view('auth/login');
    		$this->load->view('general/login_footer');
	    }
		
	}


}
