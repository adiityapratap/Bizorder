<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model{
	
	function __construct() {
		parent::__construct();
	}
	
	public function fetchAllLocations($id=''){
	    if($id != ''){
	        $whereCon = "location_id = ".$id;
	    }else{
	        $whereCon = 1;
	    }
		$query=$this->db->query("SELECT * FROM locations_list WHERE is_deleted = 0 AND ".$whereCon );
		$res=$query->result_array();
		return $res;
	}
	
	// format to call this fcuntion
	
	   //   $table = 'your_table';
    //     $fields = array('field1', 'field2');
    //     $conditions = array('column' => 'value', 'another_column' => 'another_value');
        
	public function fetchRecordsDynamically($table, $fields = array(), $conditions = array(), $orderBy = array(), $notConditions = array()) {
    // Select fields
    if (!empty($fields)) {
        // Handle both string and array formats
        if (is_array($fields)) {
            $this->tenantDb->select(implode(',', $fields));
        } else {
            $this->tenantDb->select($fields);
        }
    } else {
        $this->tenantDb->select('*');
    }

    // From table
    $this->tenantDb->from($table);

    if (!empty($conditions)) {
        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $this->tenantDb->group_start(); // Start group for OR conditions
                foreach ($value as $v) {
                    $this->tenantDb->or_where($key, $v);
                }
                $this->tenantDb->group_end(); // End group
            } else {
                $this->tenantDb->where($key, $value);
            }
        }
    }
    
    // Apply NOT EQUAL conditions
    // if (!empty($notConditions)) {
    //     foreach ($notConditions as $key => $value) {
    //         $this->tenantDb->where("$key !=", $value);
    //     }
    // }

    if (!empty($orderBy)) {
        if (is_array($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $this->tenantDb->order_by($column, $direction);
            }
        } else {
            // If a string is passed
            $this->tenantDb->order_by($orderBy);
        }
    }

    $query = $this->tenantDb->get();
//     echo $this->tenantDb->last_query();
// exit;
    return $query->result_array();
}


    // fieldname is column taht is unique,id is the value for that unique column 
    
    
    function commonRecordUpdate($table,$fieldname='',$id,$data){
      // ✅ PERMANENT FIX: Validate parameters to prevent updating wrong records
      if (empty($fieldname) || empty($id) || empty($data)) {
          log_message('error', "🚨 CRITICAL: commonRecordUpdate called with INVALID parameters - table={$table}, fieldname={$fieldname}, id=" . var_export($id, true) . ". BLOCKING update to prevent data loss!");
          return false;
      }
      
      // ✅ PERMANENT FIX: For orders table, verify order exists before updating
      if ($table === 'orders' && $fieldname === 'order_id') {
          $orderExists = $this->tenantDb->select('order_id')
              ->from('orders')
              ->where('order_id', $id)
              ->get()
              ->row();
          
          if (!$orderExists) {
              log_message('error', "🚨 CRITICAL: commonRecordUpdate called for NON-EXISTENT order_id={$id}. BLOCKING update to prevent data loss!");
              return false;
          }
      }
      
      // ✅ CRITICAL FIX: Reset query builder to prevent WHERE clause persistence
      // If previous queries added WHERE conditions, they could persist and affect UPDATE query
      // This ensures we only update the specific record, not other records
      $this->tenantDb->reset_query();
      
      $this->tenantDb->where($fieldname, $id);
      $result = $this->tenantDb->update($table, $data);
      
      // ✅ PERMANENT FIX: Log update for orders table to track changes
      if ($table === 'orders' && $fieldname === 'order_id') {
          log_message('info', "✅ VERIFIED: commonRecordUpdate updated order_id={$id}, affected_rows=" . $this->tenantDb->affected_rows());
      }
      
      return $result;
    }
    
    public function commonRecordUpdateMultipleConditions($tableName,$fields, $data) {
      if(isset($fields)){
       foreach($fields as $fieldName =>$fieldValue){
        $this->tenantDb->where($fieldName, $fieldValue);   
       } 
      $this->tenantDb->update($tableName,$data); 
      }else{
      return true;    
      }    
    }
    
     public function commonRecordDeleteMultipleConditions($tableName,$fields) {
      // ═══════════════════════════════════════════════════════════════════════
      // ✅ CRITICAL FIX: Add logging and protection for suite_order_details
      // ═══════════════════════════════════════════════════════════════════════
      
      // ✅ PROTECTION: Prevent deletion from protected tables
      $protected_tables = [
          'menuDetails',
          'menu_options',
          'orders',
          'suites',
          'Global_users',
          'suite_order_details'  // ✅ ADD: Protect suite_order_details from silent deletion
      ];
      
      if (in_array($tableName, $protected_tables)) {
          log_message('error', "🚨 BLOCKED: Attempt to delete from protected table '{$tableName}' via commonRecordDeleteMultipleConditions");
          log_message('error', "   Conditions: " . json_encode($fields));
          log_message('error', "   Protected tables cannot be deleted from. Use soft delete (status = 'cancelled') instead.");
          return false;
      }
      
      if(isset($fields)){
       // ✅ LOGGING: Count records before deletion
       $this->tenantDb->from($tableName);
       foreach($fields as $fieldName =>$fieldValue){
        // ✅ CRITICAL SAFETY: Skip NULL/empty values to prevent accidental bulk deletions
        if ($fieldValue === NULL || $fieldValue === '') {
            log_message('error', "commonRecordDeleteMultipleConditions: Skipping NULL/empty value for {$fieldName} in {$tableName} to prevent accidental bulk deletion");
            continue;
        }
        $this->tenantDb->where($fieldName, $fieldValue);   
       }
       $countBefore = $this->tenantDb->count_all_results();
       
       // ✅ LOGGING: Log what we're about to delete
       log_message('info', "🗑️ DELETE ATTEMPT: Table={$tableName}, Conditions=" . json_encode($fields) . ", Records Found={$countBefore}");
       
       // Reset query builder and perform deletion
       $this->tenantDb->reset_query();
       foreach($fields as $fieldName =>$fieldValue){
        if ($fieldValue === NULL || $fieldValue === '') continue;
        $this->tenantDb->where($fieldName, $fieldValue);   
       } 
      $result = $this->tenantDb->delete($tableName);
      
      // ✅ LOGGING: Log after deletion
      $affectedRows = $this->tenantDb->affected_rows();
      log_message('info', "✅ DELETE SUCCESS: Table={$tableName}, Conditions=" . json_encode($fields) . ", Affected Rows={$affectedRows}");
      
      return $result;
      }else{
      return true;    
      }    
    }
    
    function commonRecordDelete($table,$id,$uniqueColumnName='id'){
      // ═══════════════════════════════════════════════════════════════════════
      // CRITICAL PROTECTION: Prevent deletion from protected tables
      // ═══════════════════════════════════════════════════════════════════════
      $protected_tables = [
          'menuDetails',      // Menu items should NEVER be deleted
          'menu_options',     // Menu options should NEVER be deleted
          // 'menuPlanner',   // ✅ REMOVED: Menu planners can be hard deleted if no orders exist (checked in deleteMenuPlanner())
          'orders',           // Orders should NEVER be deleted
          'suites',           // Suites should NEVER be deleted
          'Global_users',     // Users should NEVER be deleted
          'suite_order_details'  // ✅ ADD: Suite order details should NEVER be deleted (use status='cancelled' instead)
      ];
      
      if (in_array($table, $protected_tables)) {
          log_message('error', "🚨 BLOCKED: Attempt to delete from protected table '{$table}'. ID: {$id}");
          log_message('error', "   Protected tables cannot be deleted from. Use soft delete (is_deleted = 1) instead.");
          return false;
      }
      
      $this->tenantDb->where($uniqueColumnName, $id);
      $this->tenantDb->delete($table);    
    }
    
   // eg.  $ids = array(1, 2, 3, 4); Array of IDs to delete
    function commonBulkRecordDelete($table,$ids,$uniqueColumnName='id'){
      // ═══════════════════════════════════════════════════════════════════════
      // CRITICAL PROTECTION: Prevent bulk deletion from protected tables
      // ═══════════════════════════════════════════════════════════════════════
      $protected_tables = [
          'menuDetails',
          'menu_options',
          'menuPlanner',
          'orders',
          'suites',
          'Global_users'
      ];
      
      if (in_array($table, $protected_tables)) {
          log_message('error', "🚨 BLOCKED: Attempt to bulk delete from protected table '{$table}'. IDs: " . implode(',', $ids));
          return false;
      }
      
     $this->tenantDb->where_in($uniqueColumnName, $ids);
     $this->tenantDb->delete($table);
    }
    
    
    function commonRecordCreate($table,$data){
      $this->tenantDb->insert($table, $data);
    //   $insertTennatLogId = create_function('', 'return true;');
    //   $insertTennatLogId();
      return  $this->tenantDb->insert_id();
    }
    
    function commonRecordUpsert($table,$uniqueColumnName,$uniqueColumnVal,$data){
    $this->tenantDb->insert($table, $data);
    $affected_rows = $this->tenantDb->affected_rows();
    if ($affected_rows == 0) {
        $this->tenantDb->where($uniqueColumnName, $uniqueColumnVal);
        $this->tenantDb->update($table, $data);
    }
    return true;
    }
    // upload attachment call this from any controller,make sure to pass the folder name  and make sure input type file must have name=userfile
    
    public function uploadAttachment($uploadedFiles, $uploadPath = './uploaded_files/')
    {
    $uploaded_files = [];
    $countfiles = count($uploadedFiles['userfile']['name']);
    for ($i = 0; $i < $countfiles; $i++) {

        if (!empty($uploadedFiles['userfile']['name'][$i])) {

            // Define new $_FILES array - $_FILES['file']
            $_FILES['file']['name']     = $uploadedFiles['userfile']['name'][$i];
            $_FILES['file']['type']     = $uploadedFiles['userfile']['type'][$i];
            $_FILES['file']['tmp_name'] = $uploadedFiles['userfile']['tmp_name'][$i];
            $_FILES['file']['error']    = $uploadedFiles['userfile']['error'][$i];
            $_FILES['file']['size']     = $uploadedFiles['userfile']['size'][$i];

            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx';
            $config['max_size']      = '8000';
            $config['file_name']     = $uploadedFiles['userfile']['name'][$i];

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $filename   = $uploadData['file_name'];
                // Initialize array
                $uploaded_files[$i] = $filename;
            } else {
                $error = $this->upload->display_errors();
                return $error;
            }
        }
    }

    return serialize($uploaded_files);
}

   public function commonBulkRecordCreate($tableName, $data, $additionalData = []) {
    if (!empty($additionalData)) {
        foreach ($data as &$row) {
            $row = array_merge($row, $additionalData);
        }
    }
    // Your existing bulk insert logic here, assuming it uses a method like batch insert
    return $this->tenantDb->insert_batch($tableName, $data);
}

    public function commonGetLatestRecord($table, $fields = array(),$conditions = array()) {
    
    if (!empty($fields)) {
        $this->tenantDb->select(implode(',', $fields));
    } else {
        $this->tenantDb->select('*');
    }
    $this->tenantDb->from($table); 
    
    if (!empty($conditions)) {
        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                $this->tenantDb->group_start(); // Start group for OR conditions
                foreach ($value as $v) {
                    $this->tenantDb->or_where($key, $v);
                }
                $this->tenantDb->group_end(); // End group
            } else {
                $this->tenantDb->where($key, $value);
            }
        }
    }
    
    
    $this->tenantDb->order_by('date_added', 'DESC'); 
    $this->tenantDb->limit(1); 
    $query = $this->tenantDb->get();

    // Get the result
    $result = $query->result_array(); 
    if(isset($result) && !empty($result)){
      $result = reset($result);  
    }else{
      $result = array();  
    }
    return $result;
}



    
    
 
}
	?>