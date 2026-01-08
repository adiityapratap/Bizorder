<?php
require 'vendor/autoload.php';
class Survey extends CI_Controller{
    
    function __construct() {
		parent::__construct();
		$this->load->library('pagination'); 
		$this->load->model('orders_model');
		$this->load->library('session');
		$this->load->library('email');
	}
	
		public function survey_submit()
	{
		header("Access-Control-Allow-Origin: *");
       $rest_json = file_get_contents("php://input");
       $_POST = json_decode($rest_json, true);
      
       $this->db->insert('survey', $_POST);
   
		$user = $this->orders_model->fetch_user_info($_POST['location_id']);
		 $manager_email = $user[0]->email;
      $config=array(
            'charset'=>'utf-8',
            'wordwrap'=> TRUE,
            'mailtype' => 'html'
            );
            $this->email->initialize($config);
            // $toemail = array("kaushika_jinna@yahoo.com",$manager_email);
             $toemail = array("kaushika_jinna@yahoo.com","adityakohli467@gmail.com");
            $this->email->to($toemail);
            $this->email->from('info@1800mycatering.com.au', 'Hospitalcatering ');
            $this->email->subject('New Survey Submitted');
            $this->email->message("Dear Manager,<p>New survey submitted , Please check portal for details.</p>");
            $mail = $this->email->send();
            if($mail) {
                echo 'Ok';
            } else {
                echo 'not ok';
            }
            

	}
		public function fetch_survey(){
		    $all_survey = $this->orders_model->fetch_survey();
		    $data['all_survey'] = $all_survey;
		    $this->load->view('general/header');
			$this->load->view('orders/survey',$data);
			$this->load->view('general/footer');
		 
		}
		
			public function view_survey($id){
		    $survey_detail = $this->orders_model->fetch_survey($id);
		    $this->load->view('general/header');
		  //  $data['survey_detail'] = $survey_detail;
		
			foreach($survey_detail[0] as $field_name => $value){
			    $data[$field_name] = $value;
			}
// 			echo "<pre>";print_r($data);exit;
			$this->load->view('general/header');
		    $this->load->view('orders/survey_detail',$data);
			$this->load->view('general/footer');
		}
    
    
    
}