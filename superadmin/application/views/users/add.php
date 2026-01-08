<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php if($form_type == 'view'){ $disable = 'disabled'; }else{ $disable = ''; }?>
<style>
    .pointerCursor {
        cursor: pointer;
    }
    input[type="checkbox"].disabled {
        pointer-events: none;
    }
    .organizationLogo.avatar-lg {
    width: auto;
}
</style>
<div class="main-content">

    <div class="page-content">
       <?php $this->load->view('general/listpageTopBg'); ?>         
    <div class="container-fluid mb-10">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <?php if($form_type == 'add'){ ?>
                        <form id="orzForm" action="<?php echo base_url(); ?>index.php/users/add" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <?php }else{ ?>
                        <form id="orzForm" action="<?php echo base_url(); ?>index.php/users/edit" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <?php } ?>
                        <div class="card-header border-bottom-dashed">
    
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0 text-uppercase fw-bold"><?php echo $form_type; ?> Users</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div>
                                       <?php if($form_type == 'add'){ ?>
                                            <input type="button" class="btn btn-primary" value="Save" onclick="handleFormValidation()">
                                        <?php } else if($form_type == 'edit'){ ?>
                                            <input type="button" class="btn btn-primary" value="Update" onclick="handleFormValidation()">
                                        <?php }else{} ?>
                                        <input type="hidden" name="id" id="id" class ='form-control' value="<?php echo (isset($record[0]->organization_list_id)? $record[0]->organization_list_id: ''); ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                    <div class="card-body">
                        <div>
                           
                            <div class="row">
                                <div class="col-md-4 mb-4">  
                                    <div class="control-group">
                                      <label class="control-label">Full Name</label>
                                      <div class="controls">
                                        <input required type="text" name="orz_name" id="orz_name" class ='form-control required' <?php echo $disable; ?> value="<?php echo (isset($record[0]->orz_name)? $record[0]->orz_name : ''); ?>" >
                                     <div class="invalid-feedback">Please enter organization name.</div>
                                      </div>
                                    </div>
                                  </div>
                               
                                <div class="col-md-4 mb-4"> 
                                    <div class="control-group">
                                      <label class="control-label">Email</label>
                                      <div class="controls">
                                        <input required type="text" name="orz_email" id="orz_email" class ='form-control required' <?php echo $disable; ?> value="<?php echo (isset($record[0]->orz_email)? $record[0]->orz_email : ''); ?>">
                                      <div class="invalid-feedback">Please enter valid email.</div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4"> 
                                    <div class="control-group">
                                      <label class="control-label">Phone</label>
                                      <div class="controls">
                                        <input type="text" name="orz_phone" id="orz_phone" class ='form-control required' <?php echo $disable; ?> value="<?php echo (isset($record[0]->orz_phone)? $record[0]->orz_phone : ''); ?>">
                                      <div class="invalid-feedback">Please enter phone number.</div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4"> 
                                    <div class="control-group">
                                      <label class="control-label">Username</label>
                                      <div class="controls">
                                        <input type="text" name="orz_phone" id="orz_phone" class ='form-control required' <?php echo $disable; ?> value="<?php echo (isset($record[0]->orz_phone)? $record[0]->orz_phone : ''); ?>">
                                      <div class="invalid-feedback">Please enter unique username .</div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4"> 
                                    <div class="control-group">
                                      <label class="control-label">Status</label>
                                      <div class="controls">
                                        <select name="organization_list_status" id="organization_list_status" class ='form-control' <?php echo $disable; ?>>
                                            <?php if($form_type != 'view'){ ?><option value="">Select</option><?php } ?>
                                            <option value="1" <?php echo (isset($record[0]->orz_address) && $record[0]->organization_list_status == 1 ? 'selected' : ''); ?>>Enable</option>
                                            <option value="0" <?php echo (isset($record[0]->orz_address) && $record[0]->organization_list_status == 0 ? 'selected' : ''); ?>>Disable</option>
                                        </select>
                                      </div>
                                    </div>
                                </div>
                               
                                
                                
                                <?php if(!empty($system_details)){
                                    if(!empty($record[0]->system_ids)){
                                        $system_ids = unserialize($record[0]->system_ids);
                                    }else{
                                        $system_ids = [];
                                    }
                                ?>
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                                    <div class="control-group">
                                      <label class="control-label">System Access</label>
                                       <div class="controls row vclass">
                                            <?php foreach($system_details as $system){ ?>                                                                                                            
                                                <div class="checkbox col-lg-6 col-sm-12 mb-1">
                                                    <?php if(in_array($system->system_details_id,$system_ids)){ ?>
                                                        <input type="checkbox" class="<?php echo $disable; ?> system_id" name="system_ids[]" value="<?php echo $system->system_details_id; ?>" checked> <?php echo $system->system_name; ?> 
                                                    <?php }else{ ?>
                                                        <input type="checkbox" class="<?php echo $disable; ?> system_id" name="system_ids[]" value="<?php echo $system->system_details_id; ?>"> <?php echo $system->system_name; ?>  
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="invalid-feedback">Please select atleast one system .</div>
                                    </div>
                                </div>
                               <?php } ?>
                                
                            </div>
                             
                              
                        </div>
                       
                       
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
            <!-- container-fluid -->
    </div>
        <!-- End Page-content -->

        
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

 <script>
 function handleFormValidation(){
     let error = false;
     let anyChecked = false;
    
    $('.system_id').each(function() {
      if ($(this).prop('checked')) {
        anyChecked = true;
      }
    });
    $('.required').each(function() {
      if ($(this).val() == '') {
        error = true;
        $(this).next(".invalid-feedback").css("display","block");
      }else{
        $(this).next(".invalid-feedback").css("display","none");   
      }
    });
    
    if(anyChecked == false){
         error = true;
      $(".vclass").next().css("display","block");   
    }
    if(error){
       
        return false;
    }else{
       $("#orzForm").submit(); 
    }
    
 }
     function view_password(){
         var passwordType=$('#orz_password').attr('type');
         if(passwordType=="password"){
             $('#orz_password').attr('type','text');
         }else{
             $('#orz_password').attr('type','password');
             
         }
         
     }
 </script>
