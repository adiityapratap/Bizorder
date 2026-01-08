<?php 
// application/core/MY_Controller.php

require APPPATH . "third_party/MX/Controller.php";
class MY_Controller extends MX_Controller
{
    protected $tenantDbConfig;
    public $tenantDb;

    public function __construct()
    {
        parent::__construct();
        $this->initializeTenantDbConfig();
        // form validation 
       $this->load->library('MY_Form_validation');
       $this->form_validation->setControllerInstance($this);
       $_SERVER['common_footer'] = APPPATH . 'views/general/footer.php';
        // echo "<pre>"; print_r($this->tenantDb); exit;  
       // session
    //   $this->load->library('MY_Session');
    // $this->session->setControllerInstance($this);
    
    }
   
    public function dbDetailsCreate($tenantCredentials){
       
        return $config = [
            'hostname' => (isset($tenantCredentials['db_host']) ? $tenantCredentials['db_host'] : 'localhost'),
            'username' => $tenantCredentials['db_username'],
            'password' => $tenantCredentials['db_pass'],
            'database' => $tenantCredentials['db_name'],
            'dbdriver' => 'mysqli',
            ];
            
    }
  
    public function switchDatabase($tenantCredentials)
    {
        
       $config = $this->dbDetailsCreate($tenantCredentials);

        // Close the existing connection (if any)
        if ($this->tenantDb) {
            $this->tenantDb->close();
        }
      $this->session->set_userdata('dynamic_db_config', $tenantCredentials);
       
        $this->tenantDb = $this->load->database($config, true);
    }

    private function initializeTenantDbConfig()
    {  
       if ($this->session->userdata('dynamic_db_config')) {
           $config = $this->dbDetailsCreate($this->session->userdata('dynamic_db_config'));
            $this->tenantDb = $this->load->database($config, true);
        } else {
          
        $this->db->reconnect();
        }
    }
}


?>
