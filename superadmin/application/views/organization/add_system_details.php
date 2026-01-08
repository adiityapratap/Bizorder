<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<?php if($form_type == 'view'){ $disable = 'disabled'; }else{ $disable = ''; }?>
<div class="main-content">

    <div class="page-content">
            <?php $this->load->view('general/listpageTopBg'); ?>       
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <?php if($form_type == 'add'){ ?>
                        <form action="<?php echo base_url(); ?>index.php/organization/add_system" method="post" class="form-horizontal">
                    <?php }else{ ?>
                        <form action="<?php echo base_url(); ?>index.php/organization/edit_system" method="post" class="form-horizontal">
                    <?php } ?>
                        <div class="card-header border-bottom-dashed">
    
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0 text-uppercase fw-bold"><?php echo $form_type; ?> System</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div>
                                       <?php if($form_type == 'add'){ ?>
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        <?php } else if($form_type == 'edit'){ ?>
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        <?php }else{} ?>
                                        <input type="hidden" name="id" id="id" class ='form-control' value="<?php echo (isset($record[0]->system_details_id)? $record[0]->system_details_id: ''); ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                    <div class="card-body">
                        <div>
                           
                            <div class="row">
                                <div class="col-md-4 mb-4">  
                                    <div class="control-group">
                                      <label class="control-label">System Name</label>
                                      <div class="controls">
                                        <input required type="text" name="system_name" id="system_name" class ='form-control' <?php echo $disable; ?> value="<?php echo (isset($record[0]->system_name)? $record[0]->system_name : ''); ?>" >
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-2 mb-4">  
                                    <div class="control-group">
                                       
                                      <label class="control-label">System Slug</label>
                                      <div class="controls">
                                        <input required <?php echo (isset($record[0]->slug)? 'readonly' : ''); ?> type="text" name="slug" id="slug" class ='form-control' <?php echo $disable; ?> value="<?php echo (isset($record[0]->slug)? $record[0]->slug : ''); ?>" >
                                      </div>
                                       <small>Name of folder under Modules, it will be accessed using this in URL</small>
                                    </div>
                                  </div>
                                  
                                   <div class="col-md-2 mb-4">  
                                    <div class="control-group">
                                      <label class="control-label">System Icon</label>
                                      <div class="controls">
                                        <input  type="text" name="system_icon" id="system_icon" class ='form-control' <?php echo $disable; ?> value="<?php echo (isset($record[0]->system_icon)? $record[0]->system_icon : ''); ?>" >
                                      <small> for example bx bxl-shopify</small>
                                      </div>
                                    </div>
                                  </div>
                                   <div class="col-md-4 mb-4">  
                                    <div class="control-group">
                                      <label class="control-label">System Color</label>
                                      <div class="controls">
                                        <input  type="text" name="system_color" id="system_color" class ='form-control' <?php echo $disable; ?> value="<?php echo (isset($record[0]->system_color)? $record[0]->system_color : ''); ?>" >
                                     <small> This is color code , that will be applied on users side dashboard</small>
                                      </div>
                                    </div>
                                  </div>
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

 
