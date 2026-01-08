<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
class General extends MY_Controller {
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $general_model;
	public $auth_model;
	
    function __construct() {
		parent::__construct();
		$this->load->model('general_model');
		$this->load->model('auth_model');
	!$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '';
	}
	public function index(){
	    
	}
	// for fetching menus while creating or editing user
	public function fetchMenuFromHelper(){
	    $system_id = $this->input->post('system_id');
        $user_id = $this->input->post('user_id'); 
        if ($this->input->post('user_id') !== null || $this->input->post('role_id') !== null) {
            $menus = fetch_render_menu($system_id,$user_id,$this->input->post('role_id'));
        }else{
           $menus = fetch_render_menu($system_id); 
        }
	    
	   // echo "eee<pre>"; print_r($menus); exit;
	    echo json_encode($menus);
	}
	
	public function fetchMenuFromHelperForSettingPage(){
	    $system_id = $this->input->post('system_id');
        $user_id = $this->input->post('user_id'); 
        if ($this->input->post('user_id') !== null || $this->input->post('role_id') !== null) {
            $menus = fetch_render_menu_for_setting($system_id,$user_id,$this->input->post('role_id'));
        }else{
           $menus = fetch_render_menu_for_setting($system_id); 
        }
	    
	   // echo "eee<pre>"; print_r($menus); exit;
	    echo json_encode($menus);
	}
	
	
	
	function updateTableStatus(){
	  (!$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '');
	   $id = $this->input->post('id');
	   $table_name = $this->input->post('table_name');
	   $data =  array(
	       'status'=> $this->input->post('status')
	       );
	    $this->general_model->updateDataInOrzDb($table_name,'id',$id,$data);
	    echo "success";
	}
	
	function sendQueryMail(){
	    $data['name'] = $this->input->post('name');
	    $data['email'] =$this->input->post('email');
	    $data['phone'] =$this->input->post('phone');
	    $data['message'] = $this->input->post('message');

	    $email_content = $this->load->view('Mail/websitecontact',$data,TRUE);
        $mailResult = $this->sendEmail('kaushika@aaria.com.au','Website Query', $email_content,$from='info@bizadmin.com.au','','Bizorder');  
        echo 'success';
	}
	

	public function record_delete(){
	     (!$this->ion_auth->logged_in() ? redirect('auth/login', 'refresh') : '');
	    $id = $_POST["id"];
   	$table_name = $_POST["table_name"];
   	
   	// ═══════════════════════════════════════════════════════════════════════
        // CRITICAL SECURITY: Log ALL deletion attempts to prevent unauthorized deletions
        // Issue: Users were getting auto-deleted (is_deleted=1) without audit trail
        // ═══════════════════════════════════════════════════════════════════════
        $user_id = $this->ion_auth->get_user_id();
        $user = $this->ion_auth->user()->row();
        $username = $user->username ?? 'Unknown';
        $ip_address = $this->input->ip_address();
        
        log_message('error', "🗑️ DELETE ATTEMPT:");
        log_message('error', "   Table: {$table_name}");
        log_message('error', "   Record ID: {$id}");
        log_message('error', "   By User ID: {$user_id}");
        log_message('error', "   Username: {$username}");
        log_message('error', "   IP Address: {$ip_address}");
        log_message('error', "   Timestamp: " . date('Y-m-d H:i:s'));
        
        // ═══════════════════════════════════════════════════════════════════════
        // CRITICAL PROTECTION: Block deletion of protected tables
        // ═══════════════════════════════════════════════════════════════════════
        $protected_tables = [
            'menuDetails' => 'Menu items cannot be deleted. Use "Display On Dashboard" toggle to hide items.',
            'menu_options' => 'Menu options cannot be deleted. Use status toggle to disable them.',
            'orders' => 'Orders cannot be deleted for audit/compliance reasons.',
            'menuPlanner' => 'Menu planners cannot be deleted. Use status toggle to disable them.'
        ];
        
        if(array_key_exists($table_name, $protected_tables)) {
            log_message('error', "   🚨 BLOCKED: Cannot delete from protected table '{$table_name}'");
            log_message('error', "   Reason: {$protected_tables[$table_name]}");
            echo json_encode([
                'status' => 'error',
                'message' => $protected_tables[$table_name]
            ]);
            return;
        }
        
        // ═══════════════════════════════════════════════════════════════════════
        // CRITICAL PROTECTION: Block deletion of important users
        // ═══════════════════════════════════════════════════════════════════════
        if($table_name == 'Global_users'){
            // Get user details before deletion (FIX: Use tenantDb instead of db)
            $target_user = $this->tenantDb->get_where('Global_users', ['id' => $id])->row();
            
            if($target_user) {
                log_message('error', "   Target User: {$target_user->username} ({$target_user->email})");
                log_message('error', "   Target Role: " . $target_user->role_id);
                
                // BLOCK deletion of critical users (admin, chef, key personnel)
                $protected_users = ['admin', 'chefzenn', 'zennadmin', 'bizorder@gmail.com'];
                $is_protected = in_array($target_user->username, $protected_users) || 
                               in_array($target_user->email, $protected_users);
                
                if($is_protected) {
                    log_message('error', "   🚨 BLOCKED: Cannot delete protected user '{$target_user->username}'");
                    echo json_encode([
                        'status' => 'error',
                        'message' => "Cannot delete protected user '{$target_user->username}'. Please contact system administrator."
                    ]);
                    return;
                }
                
                // Log to audit table (FIX: Use tenantDb instead of db)
                try {
                    $audit_data = [
                        'table_name' => $table_name,
                        'record_id' => $id,
                        'action' => 'soft_delete',
                        'deleted_by_user_id' => $user_id,
                        'deleted_by_username' => $username,
                        'deleted_by_ip' => $ip_address,
                        'target_user_username' => $target_user->username,
                        'target_user_email' => $target_user->email,
                        'target_user_role' => $target_user->role_id,
                        'deleted_at' => date('Y-m-d H:i:s'),
                        'reason' => 'User initiated deletion via UI'
                    ];
                    
                    // Try to insert audit record (fails silently if table doesn't exist)
                    @$this->tenantDb->insert('user_deletion_audit', $audit_data);
                } catch (Exception $e) {
                    log_message('warning', "Audit table not found - please create user_deletion_audit table");
                }
            }
        }
   	
   	// Proceed with soft delete
   	$postData = array(
   	    'is_deleted' => 1,
   	    'deleted_at' => date('Y-m-d H:i:s'), // FIX: Use full datetime format
   	    );
   	 if($table_name =='Global_users'){
   	    $postData['active'] = 0;    
   	    }
	$res=$this->general_model->update($table_name,$id,$postData,'id');
       if($res){
          log_message('info', "   ✅ DELETE SUCCESS: Table={$table_name}, ID={$id}");
          echo "deleted";
       }else{
          log_message('error', "   ❌ DELETE FAILED: Table={$table_name}, ID={$id}");
          echo "error";
       }
	}

}
