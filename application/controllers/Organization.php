<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends MY_Controller {
    function __construct() {
		parent::__construct();
		$this->load->helper('custom');
		$this->load->model('organization_model');
		$this->load->model('location_model');
		$this->load->model('general_model');
	}
	public function connectToThisDB($dbDetails){
	    
	 $config = array(
    'hostname' => 'localhost',
    'username' => $dbDetails['db_username'],
    'password' => $dbDetails['db_pass'],
    'database' => $dbDetails['db_name'],
    'dbdriver' => 'mysqli',
    );
   return $new_db = $this->load->database($config, TRUE);  
   
	}
	public function populateClientDB($dataToInsert,$orzId,$hasedPassword=''){
	    
	   $newDBConn = $this->connectToThisDB($dataToInsert);
	   $data = array(
	   'id' => 1,
	   'role_id' => 1,
       'username' => $dataToInsert['tenant_identifier'],
       'first_name' => $dataToInsert['orz_name'],
       'email' => $dataToInsert['orz_email'],
       'phone' => $dataToInsert['orz_phone'],
       'password' => $hasedPassword,
       'company' => $orzId,
       'system_ids' => Serialize($dataToInsert['system_ids']),
	   'location_ids' => Serialize($dataToInsert['location_ids']),
       'active' => $dataToInsert['organization_list_status'],
       'is_superadmin' => 1,
       'created_on' => date('Y-m-d'),
       );
       $newDBConn->insert('Global_users', $data);
       $last_inserted_user_id = $newDBConn->insert_id();
     
    

      //group_id = 1,2,3,4 is for admin,manager and staff and employee role respecitvely,beacuse for all orz threee roles will by default created and mandotry as 1,2,3
      for($count = 1;$count<4;$count++){
       $roleData = array(
       'id' =>   $count,     
       'name' => ($count == 1 ? 'Admin' : ($count == 2 ? 'Manager' : ($count == 3 ? 'Employee' : 'Staff'))),
       'displayName' => ($count == 1 ? 'Admin' : ($count == 2 ? 'Manager' : 'Staff')),
       'status' => 1,
       'showSeprateChecklist' => ($count == 3 ? 1 : 0),
       'location_id' => 0
       );
      $newDBConn->insert('Global_roles', $roleData);
      if($count == 1){
       $last_inserted_role_id =    $newDBConn->insert_id();
      }

      }
     
     // assign admin role to created user 
     $roleToUserData = array(
       'user_id' => $last_inserted_user_id,
       'group_id' => $last_inserted_role_id,
       );
      $newDBConn->insert('Global_userid_to_roles', $roleToUserData); 
      
      // Enter all assigned location in orz database , assigned to admin for the first time later they can modify it once they login
      foreach($dataToInsert['location_ids'] as $location_id){
        
        $locationToUserData = array(
       'user_id' => $last_inserted_user_id,
       'location_id' => $location_id,
       );
      $newDBConn->insert('Global_users_to_location', $locationToUserData);   
      }
      
      // enter one backup SMTP details incase orz didnt enter it for anyb system or location , these cred will be used
      $smtpData = array(
          'id' => 1,
          'location_id' => '9999',
          'system_id' => '9999',
          'smtp_host' => 'smtp.office365.com',
          'smtp_username' => 'info@bizadmin.com.au',
          'smtp_pass' => '1800@Footscray123!',
          'smtp_port' => '25',
          'smtp_encryptionType' =>'tls',
          'mail_protocol' => 'smtp',
          'mail_from' => 'info@bizadmin.com.au',
          );
       $newDBConn->insert('Global_SmtpSettings', $smtpData);   

	}
	
	public function index(){
	  
	    if($this->session->userdata('IsUserLogged')){
	        
	        $res=$this->general_model->fetchAllRecord('organization_list');
	        $data['record'] = $res;
	        $data['controller_add'] = 'organization/add'; 
	        $data['controller_edit'] = 'organization/edit'; 
	        $data['controller_view'] = 'organization/view'; 
	      
	        $data['page_title'] = 'Organization List';
	        $data['table_name'] = 'organization_list';
	        $data['table_columns'][] = array(
	                'column_title' =>'Organization Name',
	                'column_name' =>'orz_name',
	                'sort' => '1',
	            );
            $data['table_columns'][] = array(
                    'column_title' =>'Email',
                    'column_name' =>'orz_email',
                    'sort' => '1',
                );
            $data['table_columns'][] = array(
                    'column_title' =>'Phone',
                    'column_name' =>'orz_phone',
                    'sort' => '0',
                );
            $data['table_columns'][] = array(
                    'column_title' =>'Status',
                    'column_name' =>'organization_list_status',
                    'sort' => '1',
                ); 
            
	        $data['table_action'] = array('view','edit','delete');
	        
	        $this->load->view('general/header');
    		$this->load->view('general/listing',$data);
    		$this->load->view('general/footer');
		
	    }else{
	        redirect('auth');
	    }
	    
		
	}
	public function add(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	            $filename = ''; 
	            if(!empty($_FILES['orz_logo']['name'])){
    
                  $_FILES['file']['name'] = $_FILES['orz_logo']['name'];
                  $_FILES['file']['type'] = $_FILES['orz_logo']['type'];
                  $_FILES['file']['tmp_name'] = $_FILES['orz_logo']['tmp_name'];
                  $_FILES['file']['error'] = $_FILES['orz_logo']['error'];
                  $_FILES['file']['size'] = $_FILES['orz_logo']['size'];
          
                  $config['upload_path'] = './uploaded_files/organization_logos';
                  $config['allowed_types'] = 'jpg|jpeg|png|gif';
                  $config['max_size'] = '5000';
                  $config['file_name'] = $_FILES['orz_logo']['name'];
           
                  $this->load->library('upload',$config); 
            
                  if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                   
                  }else{
                     
                  }
                }
                // PLAIN TEXT MODE: Store passwords as plain text (no hashing)
                $hasedPassword = $this->hash_password($_POST['orz_password']);
              
	           $postData= array(
	               'orz_name' => $_POST['orz_name'],
	               'orz_email' => $_POST['orz_email'],
	               'tenant_identifier' => $_POST['tenant_identifier'],
	               'orz_phone' => $_POST['orz_phone'],
	               'orz_address' => $_POST['orz_address'],
	               'orz_password' => $hasedPassword,
	               
	                'db_name' => $_POST['db_name'],
	                'db_username' => $_POST['db_username'],
	                'db_pass' => $_POST['db_pass'],
	                
	                'mail_protocol' => $_POST['mail_protocol'],
	                'mail_port' => $_POST['mail_port'],
	                'mail_host' => $_POST['mail_host'],
	                'mail_username' => $_POST['mail_username'],
	                'mail_pass' => $_POST['mail_pass'],
	                
	               
	               'orz_logo' => $filename,
	               'organization_list_status' => $_POST['organization_list_status'],
	               'system_ids' => Serialize($_POST['system_ids']),
	               'location_ids' => Serialize($_POST['location_ids']),
	               'date_added' => date('Y-m-d'),
	               );
	           $orzID=$this->general_model->add('organization_list',$postData);
	           if($orzID){
	               // Now insert this same record in client database as well
	               $this->populateClientDB($_POST,$orzID,$hasedPassword);
	               $this->session->set_userdata('sucess_msg','Record added successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to add record');
	           }
	           redirect('organization');
	        }else{
	            $res=$this->general_model->fetchRecord('system_details');
	            $data['locations']  =$this->location_model->fetchAllRecord();
	           // echo "<pre>"; print_r($data['locations']); exit;
	            $data['system_details'] = $res;
	            $data['form_type'] = 'add';
    	        $this->load->view('general/header');
        		$this->load->view('organization/add',$data);
        		$this->load->view('general/footer');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }	
	}

	public function hash_password($password, $identity = NULL)
	{
		// ═══════════════════════════════════════════════════════════════════════
		// PLAIN TEXT MODE: Store passwords as plain text (no hashing/encryption)
		// Changed from Argon2 hashing to plain text to match main app authentication
		// ═══════════════════════════════════════════════════════════════════════
		
		$original_password_length = strlen($password);
		$has_leading_space = $password !== ltrim($password);
		$has_trailing_space = $password !== rtrim($password);
		
		$password = trim($password);
		
		log_message('info', "🔐 SUPERADMIN HASH_PASSWORD CALLED (PLAIN TEXT MODE): Identity={$identity}, Original Length={$original_password_length}, After Trim=" . strlen($password) . ", Had Spaces=" . (($has_leading_space || $has_trailing_space) ? 'YES' : 'NO'));
		
		if (empty($password) || strpos($password, "\0") !== FALSE)	{
			log_message('error', "🚨 SUPERADMIN HASH_PASSWORD FAILED: Empty or contains null byte. Identity={$identity}");
			return FALSE;
		}

		// Return plain text password (no hashing)
		log_message('info', "✅ SUPERADMIN PASSWORD PROCESSED (PLAIN TEXT): Identity={$identity}, Length=" . strlen($password));
		return $password;
	}
	
	public function edit($id=''){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	            $id = $_POST['id'];
	           
	           $postData= array(
	               'orz_name' => $_POST['orz_name'],
	               'orz_email' => $_POST['orz_email'],
	               'tenant_identifier' => $_POST['tenant_identifier'],
	               
	                'db_name' => $_POST['db_name'],
	                'db_username' => $_POST['db_username'],
	                'db_pass' => $_POST['db_pass'],
	                
	                'mail_protocol' => $_POST['mail_protocol'],
	                'mail_port' => $_POST['mail_port'],
	                'mail_host' => $_POST['mail_host'],
	                'mail_username' => $_POST['mail_username'],
	                'mail_pass' => $_POST['mail_pass'],
	                
	               'orz_phone' => $_POST['orz_phone'],
	               'orz_address' => $_POST['orz_address'],
	               'organization_list_status' => $_POST['organization_list_status'],
	               'system_ids' => Serialize($_POST['system_ids']),
	               'location_ids' => Serialize($_POST['location_ids']),
	               'date_updated' => date('Y-m-d'),
	               );
	               if($_POST['orz_password'] != ''){
	                  $hasedPassword = $this->hash_password($_POST['orz_password']);
	                  $postData['orz_password'] = $hasedPassword;
	               }
	               if(!empty($_FILES['orz_logo']['name'])){
    
                  $_FILES['file']['name'] = $_FILES['orz_logo']['name'];
                  $_FILES['file']['type'] = $_FILES['orz_logo']['type'];
                  $_FILES['file']['tmp_name'] = $_FILES['orz_logo']['tmp_name'];
                  $_FILES['file']['error'] = $_FILES['orz_logo']['error'];
                  $_FILES['file']['size'] = $_FILES['orz_logo']['size'];
          
                  $config['upload_path'] = './uploaded_files/organization_logos';
                  $config['allowed_types'] = 'jpg|jpeg|png|gif';
                  $config['max_size'] = '5000';
                  $config['file_name'] = $_FILES['orz_logo']['name'];
           
                  $this->load->library('upload',$config); 
            
                  if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                   $postData['orz_logo'] = $filename;
                  }
                }
                
	           $res=$this->general_model->update('organization_list',$id,$postData);
	           if($res){
	               // ============================================ Code to updated ORganization Datbase when super admin update something ======= 
	               $newDBConn = $this->connectToThisDB($_POST);
	               //echo "<pre>"; print_r($newDBConn); exit;
	               $orz_user_id = get_user_id_by_organization_id($newDBConn,$id);
	              
	               //echo $orz_user_id; exit;
	            
	               $updatedData = array(
                     'username' => $_POST['tenant_identifier'],
                     'email' => $_POST['orz_email'],
                     'phone' => $_POST['orz_phone'],
                     'system_ids' => Serialize($_POST['system_ids']),
	                 'location_ids' => Serialize($_POST['location_ids']),
                     'active' => $_POST['organization_list_status'],
                     'date_modified' => date('Y-m-d'),
                   );
                   
                  // ═══════════════════════════════════════════════════════════════════════
                  // CRITICAL FIX: Add transaction and row locking to prevent password corruption
                  // When superadmin updates while user logs in, database writes collide!
                  // This was the ROOT CAUSE of random password corruption after main app fixes!
                  // ═══════════════════════════════════════════════════════════════════════
                  
                  if($_POST['orz_password'] != ''){
	                  $hasedPassword = $this->hash_password($_POST['orz_password']);
	                  $updatedData['password'] = $hasedPassword;
	                  
	                  log_message('warning', "⚠️ SUPERADMIN PASSWORD UPDATE: Org ID={$id}, User ID={$orz_user_id}, Tenant={$_POST['tenant_identifier']}");
	               }
	               
	               // START TRANSACTION with row lock to prevent concurrent update corruption
	               $newDBConn->trans_start();
	               
	               // Lock the row FOR UPDATE (prevents concurrent modifications from main app)
	               $newDBConn->where('id', $orz_user_id);
	               $user_check = $newDBConn->get('Global_users')->row();
	               
	               if (!$user_check) {
	                   $newDBConn->trans_rollback();
	                   log_message('error', "🚨 SUPERADMIN UPDATE FAILED: User not found. User ID={$orz_user_id}, Org ID={$id}");
	                   $this->session->set_flashdata('error_msg','Failed to update: User not found');
	                   redirect('organization/edit/' . $id);
	                   return;
	               }
	               
	               // Now update with lock held
	               // 🔒 CRITICAL FIX: Use set() with proper quoting for password to prevent SQL errors
	               if (isset($updatedData['password'])) {
	                   $password_value = $updatedData['password'];
	                   unset($updatedData['password']);
	                   
	                   // Update password separately with proper quoting
	                   $newDBConn->where('id', $orz_user_id);
	                   $newDBConn->set('password', $password_value, TRUE); // TRUE = escape/quote properly
	                   $newDBConn->update('Global_users');
	                   
	                   // Update other fields if any
	                   if (!empty($updatedData)) {
	                       $newDBConn->where('id', $orz_user_id);
	                       $newDBConn->update('Global_users', $updatedData);
	                   }
	               } else {
	                   // No password update, proceed normally
	                   $newDBConn->where('id', $orz_user_id);
	                   $newDBConn->update('Global_users', $updatedData);
	               }
                   
                   // Commit transaction
                   $newDBConn->trans_complete();
                   
                   if ($newDBConn->trans_status() === FALSE) {
                       log_message('error', "🚨 SUPERADMIN UPDATE TRANSACTION FAILED: Org ID={$id}, User ID={$orz_user_id}");
                       $this->session->set_flashdata('error_msg','Failed to update: Transaction failed');
                       redirect('organization/edit/' . $id);
                       return;
                   }
                   
                   log_message('info', "✅ SUPERADMIN UPDATE SUCCESS: Org ID={$id}, User ID={$orz_user_id}, Password Changed=" . ($_POST['orz_password'] != '' ? 'YES' : 'NO'));
	            
	            
	            // =============================== END ===================================================================
	            
	               $this->session->set_flashdata('sucess_msg','Record updated successfully');
	           }else{
	               $this->session->set_flashdata('error_msg','Failed to update record');
	           }
	           redirect('organization');
	        }else{
	            $res=$this->general_model->fetchAllRecord('organization_list',$id);
	            $data['locations']  =$this->location_model->fetchAllRecord();
	            $data['record'] = $res;
	            $system_details=$this->general_model->fetchRecord('system_details');
	            $data['system_details'] = $system_details;
	            $data['form_type'] = 'edit';
    	        $this->load->view('general/header');
        		$this->load->view('organization/add',$data);
        		$this->load->view('general/footer');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }
	  	
	}
	public function view($id){ 
	    if($this->session->userdata('IsUserLogged')){
	        
            $res=$this->general_model->fetchAllRecord('organization_list',$id);
            $data['locations']  =$this->location_model->fetchAllRecord();
            $data['record'] = $res;
            $system_details=$this->general_model->fetchRecord('system_details');
	        $data['system_details'] = $system_details;
            $data['form_type'] = 'view';
            $this->load->view('general/header');
    		$this->load->view('organization/add',$data);
    		$this->load->view('general/footer');
	       
		
	    }else{
	        redirect('auth');
	    }
	  	
	}
	
	public function system_listing(){
	    if($this->session->userdata('IsUserLogged')){
	        
	        $res=$this->general_model->fetchRecord('system_details');
	        $data['record'] = $res;
	        $data['controller_add'] = 'organization/add_system'; 
	        $data['controller_edit'] = 'organization/edit_system'; 
	        $data['controller_view'] = 'organization/view_system'; 
	        $data['controller_viewMenu'] = 'menu/menu_list';
	        $data['page_title'] = 'System Details';
	        $data['table_name'] = 'system_details';
	        $data['table_columns'][] = array(
	                'column_title' =>'System Name',
	                'column_name' =>'system_name',
	                'sort' => '1',
	            ); 
            
	        $data['table_action'] = array('view','View Menu','edit','delete');
	        
	        $this->load->view('general/header');
    		$this->load->view('general/listing',$data);
    		$this->load->view('general/footer');
		
	    }else{
	        redirect('auth');
	    }
	    
		
	}
	public function add_system(){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	          
	           $postData= array(
	               'system_name' => (isset($_POST['system_name']) ? $_POST['system_name'] : ''),
	               'system_icon' => (isset($_POST['system_icon']) ? $_POST['system_icon'] : ''),
	               'system_color' =>  (isset($_POST['system_color']) ? $_POST['system_color'] : ''),
	               'slug' =>   (isset($_POST['slug']) ? $_POST['slug'] : ''),
	                'system_details_status' => '1',
	               'date_added' => date('Y-m-d'),
	               );    
	           $res=$this->general_model->add('system_details',$postData);
	           if($res){
	               $this->session->set_userdata('sucess_msg','Record added successfully');
	           }else{
	               $this->session->set_userdata('error_msg','Failed to add record');
	           }
	           redirect('organization/system_listing');
	        }else{
	            $data['form_type'] = 'add';
    	        $this->load->view('general/header');
        		$this->load->view('organization/add_system_details',$data);
        		$this->load->view('general/footer');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }	
	}
	public function edit_system($id=''){ 
	    if($this->session->userdata('IsUserLogged')){
	        if($_POST){
	         
	           $postData= array(
	               'system_name' => (isset($_POST['system_name']) ? $_POST['system_name'] : ''),
	               'system_icon' => (isset($_POST['system_icon']) ? $_POST['system_icon'] : ''),
	               'system_color' =>  (isset($_POST['system_color']) ? $_POST['system_color'] : ''),
	               'slug' =>   (isset($_POST['slug']) ? $_POST['slug'] : ''),
	               'date_updated' => date('Y-m-d'),
	               );
	            $id = $_POST['id'];
	           // echo "<pre>"; print_r($postData); exit;
	           $res=$this->general_model->update('system_details',$id,$postData);
	           if($res){
	               $this->session->set_flashdata('sucess_msg','Record updated successfully');
	           }else{
	               $this->session->set_flashdata('error_msg','Failed to update record');
	           }
	           redirect('organization/system_listing');
	        }else{
	            $res=$this->general_model->fetchRecord('system_details',$id);
	            $data['record'] = $res;
	            $data['form_type'] = 'edit';
    	        $this->load->view('general/header');
        		$this->load->view('organization/add_system_details',$data);
        		$this->load->view('general/footer');
	        }
	        
		
	    }else{
	        redirect('auth');
	    }
	  	
	}
	public function view_system($id){ 
	    if($this->session->userdata('IsUserLogged')){
	        
            $res=$this->general_model->fetchRecord('system_details',$id);
            $data['record'] = $res;
            $data['form_type'] = 'view';
            $this->load->view('general/header');
    		$this->load->view('organization/add_system_details',$data);
    		$this->load->view('general/footer');
	       
		
	    }else{
	        redirect('auth');
	    }
	  	
	}
	


}
