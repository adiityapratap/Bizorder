<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    function __construct() {
		parent::__construct();
		
	
	}
	
	 public function index(){
	     $this->load->view('general/homepage');
	   
	 }
	
}