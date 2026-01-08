<?php 
// application/core/MY_Controller.php
require APPPATH . "third_party/MX/Controller.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH.'third_party/phpmailer/src/Exception.php';
require APPPATH.'third_party/phpmailer/src/PHPMailer.php';
require APPPATH.'third_party/phpmailer/src/SMTP.php';

class MY_Controller extends MX_Controller
{
    protected $tenantDbConfig;
    public $tenantDb;

    public function __construct()
    {
        parent::__construct();
        //  redirect('home/landing');
         // FIX: Get only the first segment (tenant identifier), not the full URI
         $tenantIdentifier = $this->uri->segment(1);
          // Cookie valid for 20 Yrs

         if($tenantIdentifier != '' && $tenantIdentifier != null){
             
        // we are doing this so that to match if /cjs or /zouki are valid tenat identifier dont remove this code
         $query = $this->db->query("SELECT tenant_identifier FROM organization_list WHERE  tenant_identifier ='".$tenantIdentifier."'");
         $result =  $query->row(); 
     
        if(!empty($result)){ 
            $tenantIdentifier = $result->tenant_identifier;
            $this->session->set_userdata('tenantIdentifier',$tenantIdentifier); 
            setcookie('tenant_identifier', $tenantIdentifier, time() + (86400 * 365 * 20), '/');
        }else{
            
         if(isset($_COOKIE['tenant_identifier'])){
            $tenantIdentifier = $_COOKIE['tenant_identifier'];;
           }else if($this->session->userdata('tenantIdentifier') != ''){
            $tenantIdentifier =   $this->session->userdata('tenantIdentifier'); 
            }else{
            //   $this->errorMessage(); 
            //   exit;
            }

         $query = $this->db->query("SELECT tenant_identifier FROM organization_list WHERE  tenant_identifier ='".$tenantIdentifier."'");
         $result =  $query->row(); 
        
        if(!empty($result)){ 
         $this->session->set_userdata('tenantIdentifier',$tenantIdentifier);
        setcookie('tenant_identifier', $tenantIdentifier, time() + (86400 * 365 * 20), '/');
        } else{
        //   $this->errorMessage(); 
        //       exit;   
        }
            
        }  
          
         }
         else{
         if(isset($_COOKIE['tenant_identifier'])){
            $tenantIdentifier = $_COOKIE['tenant_identifier'];;
           }else if($this->session->userdata('tenantIdentifier') != ''){
            $tenantIdentifier =   $this->session->userdata('tenantIdentifier'); 
            }else{
                // No tenant identifier found - this is the main website landing page
                // Don't set tenantIdentifier, allow Home controller to handle it
                $tenantIdentifier = null;
            }
              
        // Only try to validate tenant if we have one
        if($tenantIdentifier != null && $tenantIdentifier != ''){
         $query = $this->db->query("SELECT tenant_identifier FROM organization_list WHERE  tenant_identifier ='".$tenantIdentifier."'");
         $result =  $query->row(); 
        if(!empty($result)){ 
         $this->session->set_userdata('tenantIdentifier',$tenantIdentifier);
        setcookie('tenant_identifier', $tenantIdentifier, time() + (86400 * 365 * 20), '/');
        }else{
        // Invalid tenant identifier - clear it
        $tenantIdentifier = null;
        }
        }
      
             
         }
       
       // Only initialize tenant DB if we have a valid tenant identifier
       // Otherwise, let the Home controller handle the main landing page
       if($this->session->userdata('tenantIdentifier') != ''){
        $this->initializeTenantDbConfig();
       }
        // form validation 
       $this->load->library('MY_Form_validation');
      

       $this->form_validation->setControllerInstance($this);
       $_SERVER['common_footer'] = APPPATH . 'views/general/footer.php';
     //=========================================================================================
     // This code is for below purpose
     // if user open multiple system in multiple tabs than menus shld not get overlap, and user shld see the corresponsing menus of that system as 
     // we are updating the session everytime user access a url
       
       $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $parsedUrl = parse_url($currentURL);
       $pathParts = explode('/', $parsedUrl['path']);
     
        $systemSlugName = $pathParts[1]; 
        $systemQuery = $this->db->query("SELECT system_details_id as system_id FROM system_details WHERE slug ='".$systemSlugName."'");
        $row = $systemQuery->row();
        if ($row) {
          $system_id = $row->system_id;
          $this->session->set_userdata('system_id',$system_id);
       }
 //=================================================================================================
    
    }
   
   function errorMessage(){
       $html='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Message</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

       
    </style>
</head>
<body>
    <div id="error-message">
    <p>
   Please enter the correct login URL for your business in the browser to access BIZORDER systems. 

    </p>
    
    <p>
    For example: bizorder.com.au/your business name.

    </p>
    
    <p>
    If the problem still persists, please contact BIZORDER admin team.
    </p>
    
    </div>
</body>
</html>
';
       
       echo $html; exit;
   }

    private function initializeTenantDbConfig()
    {  
      $this->load->database();
      $tenant = $this->session->userdata('tenantIdentifier'); 
      if($tenant == ''){
          //  FIXED: Use 'zeal' database instead of 'mainwebsite' as default
          //  Previous bug: 'mainwebsite' database was missing required tables
          //  causing login failures with error: Table 'bizordercom_mainwebsite.Global_userid_to_roles' doesn't exist
          //  Fix applied: 2025-11-10 - Changed from 'mainwebsite' to 'zeal'
       $this->tenantDb = $this->load->database('zeen', TRUE);   
      }else{
       $this->tenantDb = $this->load->database($tenant, TRUE);   
      }
     
    
      
    }
    
  
    // table name is Global_SmtpSettings
    // we call this method from home page of each system because email config will diff based on system and locations for each orz.
    public function configureSMTP($emailSettings) {
       $this->session->set_userdata('smtp_host',$emailSettings->smtp_host);
       $this->session->set_userdata('smtp_port',$emailSettings->smtp_port);
       $this->session->set_userdata('smtp_username',$emailSettings->smtp_username);
       $this->session->set_userdata('smtp_pass',$emailSettings->smtp_pass);
       $this->session->set_userdata('mail_protocol',$emailSettings->mail_protocol);

    }
    
    public function fetchSmtpSettingsAtRunTimeForCronJobs(){
	    $query = $this->tenantDb->query("SELECT smtp_host,mail_protocol,mail_from,reply_to, smtp_port,smtp_username, smtp_pass FROM Global_SmtpSettings WHERE  id = 1");
        return $query->row();
    	}
    function setSmtpSettingsAtRunTimeForCronJobs(){
	    $emailSettings = $this->fetchSmtpSettingsAtRunTimeForCronJobs();
	    $this->session->set_userdata('mail_protocol',$emailSettings->mail_protocol);
	    $this->session->set_userdata('mail_from',$emailSettings->mail_from);
	    $this->phpmailer = new PHPMailer(true);
       
        $this->phpmailer->isSMTP();
        $this->phpmailer->SMTPDebug = 0; // Set to 2 for debugging
        $this->phpmailer->Host = $emailSettings->smtp_host;
        $this->phpmailer->Port = $emailSettings->smtp_port;
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Username = $emailSettings->smtp_username;
        $this->phpmailer->Password = $emailSettings->smtp_pass;
        $this->phpmailer->SMTPSecure = 'tls';
        $this->phpmailer->CharSet = 'UTF-8'; 
	}
    public function setSmtpSettings(){
        $this->phpmailer = new PHPMailer(true);
       
        $this->phpmailer->isSMTP();
        $this->phpmailer->SMTPDebug = 0; // Set to 2 for debugging
        $this->phpmailer->Host = $this->session->userdata('smtp_host');
        $this->phpmailer->Port = $this->session->userdata('smtp_port');
        $this->phpmailer->SMTPAuth = true;
        $this->phpmailer->Username = $this->session->userdata('smtp_username');
        $this->phpmailer->Password = $this->session->userdata('smtp_pass');
        $this->phpmailer->SMTPSecure = 'tls';
        $this->phpmailer->CharSet = 'UTF-8';  
        
    }
    // $to = ['recipient1@example.com', 'recipient2@example.com'];
    public function sendEmail($to, $subject, $message,$from='info@bizadmin.com.au',$cc='',$fromName='Bizorder',$attachment='') {
    
        if ($this->session->userdata('mail_protocol') == 'smtp') {
           $this->setSmtpSettings(); 
            
           
            // Receipent
            if (is_array($to)) {
               
             foreach ($to as $recipient) {
                $this->phpmailer->addAddress($recipient);
             }
              } else {
            
            $mailTo = explode(",",$to);
            if (is_array($mailTo)) {
             foreach ($mailTo as $recipient) {
                $this->phpmailer->addAddress($recipient);
             }
            }

           }
           
           //CC
           
           if($cc !=''){
             if (is_array($cc)) {
             foreach ($cc as $CCrecipient) {
                $this->phpmailer->addCC($CCrecipient);
             }
              } else {
            $this->phpmailer->addCC($cc);
           }
             
           }
        //   echo $from; exit;
            // $this->phpmailer->setFrom($from);
            $this->phpmailer->setFrom($from, $fromName);
            $this->phpmailer->isHTML(true); 
            $this->phpmailer->Subject = $subject;
            $this->phpmailer->Body = $message;
            
            if($attachment !=''){
             // Attach the PDF
            $this->phpmailer->addAttachment($attachment);   
            }
            

            if ($this->phpmailer->send()) {
                // echo "success mail sent"; exit;
                return true; // Email sent successfully
            } else {
                // echo "failed"; exit;
                return false; // Email sending failed
            }
        } else {
            // Fallback to CodeIgniter's Email library for mail protocol
            $this->load->library('email');

            // $this->email->from('your-email@example.com', 'Your Name');
            if (is_array($to)) {
            foreach ($to as $recipient) {
                $this->email->to($recipient);
            }
             } else {
            $this->email->to($to);
           }
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                return true; // Email sent successfully
            } else {
                return false; // Email sending failed
            }
        }
    }
    
    public function sendEmailAtRunTimeForCronJobs($to, $subject, $message,$cc='') {
     
        if ($this->session->userdata('mail_protocol') == 'smtp') {
         $this->setSmtpSettingsAtRunTimeForCronJobs();

            // Receipent
            if (is_array($to)) {
             foreach ($to as $recipient) {
                $this->phpmailer->addAddress($recipient);
             }
              } else {
            $this->phpmailer->addAddress($to);
           }
           
           //CC
           
           if($cc !=''){
             if (is_array($cc)) {
             foreach ($cc as $CCrecipient) {
                $this->phpmailer->addCC($CCrecipient);
             }
              } else {
            $this->phpmailer->addCC($cc);
           }
             
           }
            if($this->session->userdata('mail_from') !=''){
             $this->phpmailer->setFrom($this->session->userdata('mail_from'));   
            }
            
            $this->phpmailer->isHTML(true); 
            $this->phpmailer->Subject = $subject;
            $this->phpmailer->Body = $message;

            if ($this->phpmailer->send()) {
                echo "success mail sent"; exit;
                return true; // Email sent successfully
            } else {
                echo "failed"; exit;
                return true; // Email sending failed
            }
        } else {
            // Fallback to CodeIgniter's Email library for mail protocol
            $this->load->library('email');

            // $this->email->from('your-email@example.com', 'Your Name');
            if (is_array($to)) {
            foreach ($to as $recipient) {
                $this->email->to($recipient);
            }
             } else {
            $this->email->to($to);
           }
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) { 
                return true; // Email sent successfully
            } else {
               
                return false; // Email sending failed
            }
        }
    }
}


?>
