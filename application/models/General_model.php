<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}

	
	public function deleteMultiple($table_name,$selected_values){
	    // ═══════════════════════════════════════════════════════════════════════
	    // CRITICAL SECURITY: Log bulk deletion attempts
	    // Issue: Users were getting auto-deleted without audit trail
	    // This function deletes MULTIPLE records at once - needs comprehensive logging!
	    // ═══════════════════════════════════════════════════════════════════════
	    
	    if($table_name == 'Global_users'){
	        // Log EACH user deletion individually for audit trail
	        foreach($selected_values as $user_id) {
	            $user = $this->tenantDb->get_where('Global_users', ['id' => $user_id])->row();
	            
	            if($user) {
	                // Get current user info
	                $CI =& get_instance();
	                $CI->load->library('ion_auth');
	                $current_user_id = $CI->ion_auth->get_user_id();
	                $current_user = $CI->ion_auth->user()->row();
	                $username = $current_user->username ?? 'Unknown';
	                $ip_address = $CI->input->ip_address();
	                
	                log_message('error', "🗑️ BULK DELETE ATTEMPT:");
	                log_message('error', "   Table: {$table_name}");
	                log_message('error', "   Target User ID: {$user_id}");
	                log_message('error', "   Target Username: {$user->username}");
	                log_message('error', "   By User ID: {$current_user_id}");
	                log_message('error', "   By Username: {$username}");
	                log_message('error', "   IP Address: {$ip_address}");
	                log_message('error', "   Timestamp: " . date('Y-m-d H:i:s'));
	                
	                // BLOCK deletion of protected users
	                $protected_users = ['admin', 'chefzenn', 'zennadmin', 'bizorder@gmail.com'];
	                if(in_array($user->username, $protected_users) || in_array($user->email, $protected_users)) {
	                    log_message('error', "   🚨 BLOCKED: Cannot delete protected user '{$user->username}'");
	                    continue; // Skip this user
	                }
	                
	                // Try to log to audit table
	                try {
	                    $audit_data = [
	                        'table_name' => $table_name,
	                        'record_id' => $user_id,
	                        'action' => 'bulk_soft_delete',
	                        'deleted_by_user_id' => $current_user_id,
	                        'deleted_by_username' => $username,
	                        'deleted_by_ip' => $ip_address,
	                        'target_user_username' => $user->username,
	                        'target_user_email' => $user->email,
	                        'target_user_role' => $user->role_id,
	                        'deleted_at' => date('Y-m-d H:i:s'),
	                        'reason' => 'Bulk deletion via UI'
	                    ];
	                    @$this->db->insert('user_deletion_audit', $audit_data);
	                } catch (Exception $e) {
	                    log_message('warning', "Audit table not found");
	                }
	            }
	        }
	        
	        $data['is_deleted'] = 1;
	        $data['active'] = 0;
	    }else{
	        log_message('info', "🗑️ BULK DELETE: Table={$table_name}, Count=" . count($selected_values));
	        $data['is_deleted'] = 1;
	    }
	    
	    $this->tenantDb->where_in('id', $selected_values)->update($table_name, $data);
	    
	    log_message('info', "✅ BULK DELETE SUCCESS: Table={$table_name}, Affected=" . count($selected_values));
	    return true;
	}
	public function fetchAllRecordForThisUser($table_name,$colName='',$id='',$fieldToRetrieve='',$result_type='',$sort=false){
	    if($id != '' && $colName !=''){
	        $whereCon = $colName." = ".$id;
	    }else{
	        $whereCon = 1;
	    }
	    
	    if($sort == true){
	     $sortBy = ' ORDER BY sort_order ASC';   
	    }else{
	       $sortBy = ''; 
	    }
	   $fieldToRetrieve  = ($fieldToRetrieve == '' ? '*' : $fieldToRetrieve);
	   
		$query=$this->tenantDb->query("SELECT ".$fieldToRetrieve." FROM ".$table_name." WHERE is_deleted = 0  AND ".$whereCon.$sortBy );
		if ($query !== false) {
         $res=	($result_type == '' ? $query->result() : $query->result_array());
  
       } else {
         $res = '';
          echo "Technical Error with location: ";
          exit;
       }
	    

		return $res;
	}
  
	
	public function fetchAllRecord($table_name,$id='',$result_type=''){
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
		$query=$this->db->query("SELECT * FROM ".$table_name." WHERE ".$whereCon );
    	$res=	($result_type == '' ? $query->result() : $query->result_array());
	
		return $res;
	}
	public function fetchRecord($table_name,$id='',$columnsToFetch=''){
	    if($id != ''){
	        $whereCon = $table_name."_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
	    if($columnsToFetch==''){
	      $columnsToFetch = '*';  
	    }
		$query=$this->db->query("SELECT ".$columnsToFetch." FROM ".$table_name." WHERE ".$table_name."_status != 0 AND ".$whereCon );
		$res=$query->result();
		return $res;
	}
	public function add($table_name,$data){
		return $this->db->insert($table_name, $data);
	}
	public function insertDataInOrzDb($table_name,$data){
		 $this->tenantDb->insert($table_name, $data);
		 return $this->tenantDb->insert_id();
	}
	public function updateDataInOrzDb($table_name,$columnName,$id,$data){
       
		$this->tenantDb->where($columnName, $id);
        return $this->tenantDb->update($table_name, $data);
	}
    public function update($table_name,$id,$data,$columnForWhereCond=''){
        if($columnForWhereCond !=''){
	        $idName = $columnForWhereCond;    
	    }else
	    if($id != ''){
	        $idName = $table_name."_id";
	    }else{
	        $idName = 0;
	    }
		$this->tenantDb->where($idName, $id);
         return $this->tenantDb->update($table_name, $data);
        // echo  $lastQuery = $this->db->last_query();
	}
	
		public function fetchSmtpSettings($location_id,$system_id){ 
	    $query = $this->tenantDb->query("SELECT smtp_host,mail_protocol,mail_from,reply_to, smtp_port,smtp_username, smtp_pass FROM Global_SmtpSettings WHERE  location_id =".$location_id." AND system_id = ".$system_id);
        //  echo  "SELECT smtp_host,mail_protocol, mail_port,smtp_username, smtp_pass FROM Global_SmtpSettings WHERE  location_id =".$location_id." AND system_id = ".$system_id; exit;
        return $query->row();
    	}
	
}
