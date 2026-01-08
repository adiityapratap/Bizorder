<?php

class Config extends MY_Controller
{
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $config_model;
	public $POST;
	
    public function __construct() 
    {   
        parent::__construct();
        $this->load->model('config_model');
       !$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
        $this->POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }
    
    function configureAddUpdate(){
       	if(!empty($this->POST)){
        	    $mailTypeList = array();
        	     $resultArray = array();

      foreach ($this->POST['mailType'] as $index => $mailType) {
      if (!isset($resultArray[$mailType])) {
        $resultArray[$mailType] = array(
            'cronMailNotificationConfigId' => (isset($this->POST['cronMailNotificationConfigId']) ? $this->POST['cronMailNotificationConfigId'] : ''),
            'time_of_notification' => array(),
            'emailTo' => array(),
            'configureFor' => $mailType
          
        );
       }
     $resultArray[$mailType]['emailTo'][] = trim($this->POST['emailTo'][$index]);
     $resultArray[$mailType]['time_of_notification'] = $this->POST['time_of_notification'][$index];
     }
   
            $resultArray = array_values($resultArray);
            $allConfigIds = (isset($this->POST['cronMailNotificationConfigId']) ? $this->POST['cronMailNotificationConfigId'] : '');
  
                 foreach ($resultArray as $keyConfigId=> $configMailData) {
                 $timeOfnotification[$configMailData['configureFor']] = $configMailData['time_of_notification'];
        	      $configData = array( 
						'data' => serialize($configMailData['emailTo']),
						'configureFor' => $configMailData['configureFor'],
						'metaData'=> 'cronNotificationMail',
						'methodName' => $configMailData['configureFor'],
						'time_of_notification' => serialize($timeOfnotification),
					);
					
					if(isset($this->POST['cronMailNotificationConfigId'][$keyConfigId])){
					$id =  $this->POST['cronMailNotificationConfigId'][$keyConfigId];
					unset($allConfigIds[$keyConfigId]);
					}else{
					    $id ='';
					}
					$result = $this->config_model->configureAutomatedNotificationsubmit($configData,$id); 	 
                 }
                
                 if(isset($allConfigIds) && !empty($allConfigIds)){
                foreach ($allConfigIds as $configId) {
                $result = $this->config_model->deleteConfig($configId);     
                 }     
                 }
               return redirect(base_url('Config/configureAddUpdate'));
		    
		    
           }
        else{
            
        $mailConfigurationData = $this->config_model->getConfiguration('','cronNotificationMail');
      
	 	if(isset($mailConfigurationData) && !empty($mailConfigurationData)){ 
		   $data['mailConfigData'] = $mailConfigurationData;  
		 }else{
		    $data['mailConfigData'] = '';
		 }

          $this->load->view('general/landingPageHeader');
          $this->load->view('Configure/configuration',$data);
         $this->load->view('general/landingPageFooter');     
        }   
    }
    
    
}