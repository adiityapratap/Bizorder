 <div class="main-content">
     <?php $this->session->unset_userdata('listtype');  ?>

                <div class="page-content">
                    <div class="container-fluid">
                    
           <div class="col-12">
               <div class="alert alert-success fade show" role="alert" style="display:none">
                  Data Added Succesfully
                    </div>
                    </div>
                      
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                   <div class="card-header">
                                      
                                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 text-black">Departments Settings </h4>
    
                                    <div class="page-title-right">
                                        <div class="d-flex justify-content-sm-end ">
                                         
                                            <div class="d-flex justify-content-sm-end gap-2">
                                                <!--<button type="button" class="btn btn-primary btn-sm" data-bs-atoggle="modal" onclick="showModal('category','Category')"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Category</button>-->
                                   
                                            </div>
                                        </div>
                                    </div>
    
                                      </div>
                                      </div>
                 <div class="card-body">
                                        
                                        <!--<div class="row">-->
                                        <!--<div class="col-lg-6"> -->
                                        <!--<div class="form-check form-radio-outline form-radio-danger mb-3">-->
                                        <!-- <input class="form-check-input" type="radio" name="configType" id="departWise" checked="">-->
                                        <!--  <label class="form-check-label" for="departWise">Department Wise Settings </label>-->
                                        <!--  </div>-->
                                          
                                        <!--  </div>  -->
                                        <!-- <div class="col-lg-6">-->
                                        <!-- <div class="form-check form-radio-outline form-radio-danger mb-3">-->
                                        <!-- <input class="form-check-input" type="radio" name="configType" id="hospitalWise" checked>-->
                                        <!--  <label class="form-check-label" for="hospitalWise">Hospital Wise Settings </label>-->
                                        <!--  </div>    -->
                                        <!-- </div>  -->
                                        <!--</div>  -->
                    
                    
                   <!--<div class="departWise mt-3">                     -->
                   <!-- <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">-->
                        
                   <!--     <?php if(isset($departmentListData) && !empty($departmentListData)) { $count = 1; ?>-->
                   <!--      <?php foreach($departmentListData as $departmentList) { -->
                   <!--      $classActive = '';-->
                   <!--      if(isset($selectedlisttype) && $selectedlisttype !=''){-->
                   <!--      if($selectedlisttype == $modulename){-->
                   <!--       $classActive = 'active';  -->
                   <!--      }   -->
                   <!--      }else{-->
                   <!--      $classActive = ($count == 1 ? 'active' : '');      -->
                   <!--      }    -->
                        
                   <!--     ?>-->
                   <!--    <li class="nav-item">-->
                   <!--    <a class="nav-link py-3 <?php echo $classActive; ?>" data-bs-toggle="tab" href="#Tab<?php echo $departmentList['id'];  ?>" role="tab" aria-selected="false">-->
                   <!--    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> <?php echo $departmentList['name'] ?></a>-->
                   <!--    </li>-->
                   <!--     <?php $count++; }  ?>-->
                   <!--     <?php }  ?>-->
                   <!--      </ul>   -->
                   <!-- <div class="tab-content mb-1"> -->
                   <!--       <?php if(isset($departmentListData) && !empty($departmentListData)) { $countD = 1; ?>      -->
                   <!--                 <?php foreach($departmentListData as $departmentList) {-->
                   <!--                    $classActiveShow = '';    -->
                   <!--                    $deptId = $departmentList['id'];-->
                   <!--                    if(isset($selectedlisttype) && $selectedlisttype !=''){-->
                   <!--                    if($selectedlisttype == $modulename){-->
                   <!--                     $classActiveShow = 'active show';  -->
                   <!--                     }   -->
                   <!--                    }else{-->
                   <!--                    $classActiveShow = ($countD == 1 ? 'active show' : '');      -->
                   <!--                   } -->
                                   
                   <!--                 ?> -->
                   <!--       <div class="tab-pane table-responsive <?php  echo $classActiveShow; ?>" role="tabpanel"  id="Tab<?php echo $departmentList['id'];  ?>">-->
                   <!--         <div class="table-responsive table-card mb-1">-->
                                
                   <!-- <form class="setting_<?php echo $deptId;  ?> mt-3 mx-3">            -->
                   <!--  <div class="row">-->
                   <!--  <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Daily Budget :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="daily_budget" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['daily_budget']) ? $departmentLatestSettingsData[$deptId]['daily_budget'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Daily Limit :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="daily_limit" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['daily_limit']) ? $departmentLatestSettingsData[$deptId]['daily_limit'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Company Name :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="company_name" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['company_name']) ? $departmentLatestSettingsData[$deptId]['company_name'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Company Address :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="company_addr" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['company_addr']) ? $departmentLatestSettingsData[$deptId]['company_addr'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>ABN :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="abn" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['abn']) ? $departmentLatestSettingsData[$deptId]['abn'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!--  <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Account Name :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="account_name" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['account_name']) ? $departmentLatestSettingsData[$deptId]['account_name'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Account Email :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="account_email" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['account_email']) ? $departmentLatestSettingsData[$deptId]['account_email'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Account No :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="account_no" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['account_no']) ? $departmentLatestSettingsData[$deptId]['account_no'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>BSB :<span>*</span></label>-->
                   <!--     <input type="text" class="form-control" required="" name="bsb" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['bsb']) ? $departmentLatestSettingsData[$deptId]['bsb'] : ''); ?>">-->
                   <!-- </div>-->
                    
                   <!-- <div class="col-12 col-md-3 col-lg-2 mb-2">-->
                   <!--     <label>Terms :<span>*</span></label>-->
                   <!--     <textarea  class="form-control" required="" name="terms"  ><?php echo  (isset($departmentLatestSettingsData[$deptId]['terms']) ? $departmentLatestSettingsData[$deptId]['terms'] : ''); ?></textarea>-->
                   <!-- </div>-->
                   <!--  </div>-->
                     
                   <!--  <div class="col-sm-auto">-->
                   <!--             <div>-->
                   
                   <!--  <input type="button" class="btn btn-success" value="Save" onclick="submitDepartmentSettings(this,<?php echo $departmentList['id'];  ?>)">-->
                                                        
                   <!--             </div>-->
                   <!--         </div>-->
                   <!-- </form>     -->
                         
                    
                   <!-- </div>   -->
                   <!--  </div> -->
                     
                   <!--  <?php $countD++; }  ?>-->
                   <!--   <?php }  ?>   -->
                                      
                                      
                   <!--  </div>  -->
                   <!--</div> -->
                   
                   <div class="hospitalWise mt-3">
                    <div class="table-responsive table-card mb-1">
                                
                    <form class="settingForm mt-3 mx-3">            
                     <div class="row">
                     <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Daily Budget :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="daily_budget" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['daily_budget']) ? $departmentLatestSettingsData['daily_budget'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Daily Limit :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="daily_limit" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['daily_limit']) ? $departmentLatestSettingsData['daily_limit'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Company Name :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="company_name" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['company_name']) ? $departmentLatestSettingsData['company_name'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Company Address :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="company_addr" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['company_addr']) ? $departmentLatestSettingsData['company_addr'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>ABN :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="abn" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['abn']) ? $departmentLatestSettingsData[$deptId]['abn'] : ''); ?>">
                    </div>
                    
                     <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Account Name :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="account_name" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData[$deptId]['account_name']) ? $departmentLatestSettingsData[$deptId]['account_name'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Account Email :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="account_email" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['account_email']) ? $departmentLatestSettingsData['account_email'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Account No :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="account_no" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['account_no']) ? $departmentLatestSettingsData['account_no'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>BSB :<span>*</span></label>
                        <input type="text" class="form-control" required="" name="bsb" autocomplete="off" value="<?php echo  (isset($departmentLatestSettingsData['bsb']) ? $departmentLatestSettingsData['bsb'] : ''); ?>">
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label>Terms :<span>*</span></label>
                        <textarea  class="form-control" required="" name="terms"  ><?php echo  (isset($departmentLatestSettingsData['terms']) ? $departmentLatestSettingsData['terms'] : ''); ?></textarea>
                    </div>
                     </div>
                     
                     <div class="col-sm-auto">
                                <div>
                   
                     <input type="button" class="btn btn-success" value="Save" onclick="submitHospitalSettings(this)">
                                                        
                                </div>
                            </div>
                    </form>     
                         
                    
                    </div>      
                     
                    </div>
                    </div>   
                     </div> 
                     </div>   
                     </div>  
                     
                     </div> 
                     </div>   
                     </div>    
                     <script>
    function submitDepartmentSettings(obj,departmentId) {
    // Select the form based on department ID
    $(obj).val('Saving...');
    const form = $(`.setting_${departmentId}`);
    
    // Serialize the form data
    const formData = form.serialize() + `&department_id=${departmentId}`;                 
                     
     $.ajax({
    url: '<?php echo base_url("Orderportal/Settings/saveDepartmentSettings"); ?>',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(response) {
        $(obj).val('Save');
        if (response.status === 'success') {
            
            alert(response.message);
            location.reload(); // Reload the page or update the UI
        } else {
            alert(response.message);
        }
    },
    error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
});

}

function submitHospitalSettings(obj){
     $(obj).val('Saving...');
    const form = $(`.settingForm`);
    const formData = form.serialize();                 
                     
     $.ajax({
    url: '<?php echo base_url("Orderportal/Settings/saveHospitalSettings"); ?>',
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(response) {
        $(obj).val('Save');
        if (response.status === 'success') {
            
            alert(response.message);
            location.reload(); // Reload the page or update the UI
        } else {
            alert(response.message);
        }
    },
    error: function(xhr, status, error) {
        alert('An error occurred: ' + error);
    }
});
}

$(document).ready(function () {
    if ($('#hospitalWise').is(':checked')) {
        $('.hospitalWise').show(); // Show Hospital Wise div
        $('.departWise').hide(); // Hide Department Wise div
    }
    
    
    $('input[name="configType"]').on('change', function () {
        if ($('#departWise').is(':checked')) {
            $('.departWise').show(); // Show Department Wise div
            $('.hospitalWise').hide(); // Hide Hospital Wise div
        } else if ($('#hospitalWise').is(':checked')) {
            $('.hospitalWise').show(); // Show Hospital Wise div
            $('.departWise').hide(); // Hide Department Wise div
        }
    });
});


                     </script>