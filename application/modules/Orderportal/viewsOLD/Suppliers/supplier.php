<?php if($form_type == 'view'){ $disabled = 'disabled'; }else{ $disabled = ''; } ?>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="/Supplier/save_supplier/<?php echo $form_type.'/'.($form_type == 'edit' ? $record[0]['supplier_id'] : 'new'); ?>" method="POST">
                                        <div id="formPage">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                               <h4 class="card-title mb-0 text-uppercase fw-bold text-black"><?php echo $form_type; ?> Supplier</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end gap-2">
                        <a href="/Supplier/list/" class="btn bg-orange waves-effect btn-label waves-light "><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                
                                                        <?php if($form_type == 'add'){ ?>
                                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light ml-3"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Create</span></button>
                                                        <?php }else if($form_type == 'edit'){ ?>
                                                            <button type="submit" class="btn btn-green btn-label waves-effect waves-light ml-3"><i class="ri-refresh-line label-icon align-middle fs-16 me-2"></i><span>Update</span></button>
                                                            <input type="hidden" name="id" value>
                                                        <?php } ?>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-4">
                                                
                                                <div class="col-lg-4 mb-4">
                                                        <label for="category_id" class="form-label">Supplier Category</label>
                                                        <select class="js-example-basic-single" name="category_id" id="category_id" <?php echo $disabled; ?> >
                                                            <option value=""><?php echo ($form_type == 'view' ? '' : 'Select'); ?></option>
                                                            <option value="addnew" class="fw-bold"><?php echo ($form_type == 'view' ? '' : '+ Add New'); ?></option>
                                                        <?php if(!empty($supplier_Subcategories)){ 
                                                            foreach($supplier_Subcategories as $supCat){
                                                                if($supCat['id'] == $record[0]['category_id']){
                                                             ?>
                                                            <option value="<?php echo $supCat['id']; ?>" selected><?php echo $supCat['category_name']; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $supCat['id']; ?>"><?php echo $supCat['category_name']; ?></option>
                                                        <?php } } } ?>
                                                        </select>
                                                </div>
                                                
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="supplier_name" class="form-label">Supplier Name</label>
                                                        <input type="text" class="form-control" autocomplete="off" required name="supplier_name" id="supplier_name" placeholder="Supplier Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['supplier_name']) ? $record[0]['supplier_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="first_name" class="form-label">Contact Full Name</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="contact_full_name" id="contact_full_name" placeholder="Contact Full Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['contact_full_name']) ? $record[0]['contact_full_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="email" class="form-label">Supplier Email</label>
                                                        <input type="text" class="form-control" autocomplete="off" required name="email" id="email" placeholder="Email" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['email']) ? $record[0]['email'] : ''); ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="cc" class="form-label">Cc Email 1</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="cc" id="cc" placeholder="CC Email" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['cc']) ? $record[0]['cc'] : ''); ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="cc2" class="form-label">Cc Email 2</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="cc2" id="cc2" placeholder="CC Email" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['cc2']) ? $record[0]['cc2'] : ''); ?>">
                                                    </div>
                                                </div>
                                                  
                                                
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="mobile" class="form-label">Contact Number</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="mobile" id="mobile" placeholder="Contact Number" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['mobile']) ? $record[0]['mobile'] : ''); ?>">
                                                    </div>
                                                </div>
                                                
                                                 <div class="col-lg-4">
                                                  <label for="mobile" class="form-label">Budget Frequency</label>
                                                  <select class="form-select" aria-label="Budget Type" name="budget_type">
                                                    <option selected="" value="weekly">Select Budget Type</option>
                                                    <option value="weekly" <?php echo (isset($record[0]['budget_type']) && $record[0]['budget_type'] == 'weekly' ? 'selected' : 'selected'); ?>>Weekly</option>
                                                    <option value="monthly" <?php echo (isset($record[0]['budget_type']) && $record[0]['budget_type'] == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                                                </select>
                                              
                                                </div>
                                            
                                                <!--<div class="col-lg-4 mb-4 inputMonthly"> -->
                                                <!--    <div class="form-icon">-->
                                                <!--    <label for="budget" class="form-label">Monthly Budget</label>-->
                                                <!--    <input class="form-control form-control-icon" autocomplete="off" name="monthly_budget" id="monthly_budget" placeholder="Monthly budget" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['monthly_budget']) ? $record[0]['monthly_budget'] : ''); ?>">-->
                                                <!--   <i class="bx bx-dollar"></i>-->
                                                <!--   </div>-->
                                                <!--</div>-->
                                                
                                                <!--<div class="col-lg-4 mb-4 inputWeekly">-->
                                                <!--    <div class="form-icon">-->
                                                <!--    <label for="budget" class="form-label">Weekly Budget</label>-->
                                                <!--    <input class="form-control form-control-icon" autocomplete="off" name="weekly_budget" id="weekly_budget" placeholder="Weekly budget" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['weekly_budget']) ? $record[0]['weekly_budget'] : ''); ?>">-->
                                                <!--   <i class="bx bx-dollar"></i>-->
                                                <!--   </div>-->
                                                <!--</div>-->
                                         <div class="col-lg-2 col-md-2 mb-4">
                                         <label for="min_order" class="form-label">Minimum Order </label>
                                         <input type="text" class="form-control"  autocomplete="off" name="min_order" id="min_order" placeholder="Minimum Order Amount"  <?php echo $disabled; ?> value="<?php echo (isset($record[0]['min_order']) ? $record[0]['min_order'] : ''); ?>">
                                         </div>
                                         <div class="col-lg-2 col-md-2 mb-4">
                                        <label for="cutofftime" class="form-label">Cut Off Time</label>
                                        <input type="text" class="form-control JUItimepicker"  autocomplete="off" name="cutofftime" id="cutofftime"  <?php echo $disabled; ?> value="<?php echo (isset($record[0]['cutofftime']) ? $record[0]['cutofftime'] : ''); ?>">
                                        </div>
                                                <div class="col-lg-4">
                                                  <label for="mobile" class="form-label">Delivery Date Type</label>
                                                  <select class="form-select delivery_date_type" aria-label="Delivery Date Type" name="delivery_date_type">
                                                    <option selected="" >Select Delivery Date Type</option>
                                                    <option value="dayWise" <?php echo (isset($record[0]['delivery_date_type']) && $record[0]['delivery_date_type'] == 'dayWise' ? 'selected' : ''); ?>>Day Wise</option>
                                                    <option value="dateWise" <?php echo (isset($record[0]['delivery_date_type']) && $record[0]['delivery_date_type'] == 'dateWise' ? 'selected' : ''); ?>>Date Wise</option>
                                                </select>
                                                </div>
                                                
                                                <div class="col-lg-4 mb-4 inputDateFreq">
                                                <label for="deliveryDateFreq" class="form-label">Delivery Date Frequency</label>
                                                <input type="text" class="form-control" autocomplete="off" name="deliveryDateFreq" id="deliveryDateFreq" placeholder="Delivery Date Frequency" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['deliveryDateFreq']) ? $record[0]['deliveryDateFreq'] : ''); ?>">
                                                <small>Number of days after which supplier products will be delivered</small>
                                                </div>
                                                
                                                <div class="col-lg-4 mb-4 inputDayFreq">
                                                <label for="deliveryDayFreq" class="form-label">Delivery Day Frequency</label>
                                                <select class="form-select" data-rel="mandatory"  name="deliveryDayFreq">
                                                    <option value="Sun" <?php if($record[0]['deliveryDayFreq'] == 'Sun'){ echo "selected"; }?> >Sunday</option>
                                                    <option value="Mon" <?php if($record[0]['deliveryDayFreq'] == 'Mon'){ echo "selected"; }?> >Monday</option>
                                                    <option value="Tue" <?php if($record[0]['deliveryDayFreq'] == 'Tue'){ echo "selected"; }?> >Tuesday</option>
                                                    <option value="Wed" <?php if($record[0]['deliveryDayFreq'] == 'Wed'){ echo "selected"; }?> >Wednesday</option>
                                                    <option value="Thu" <?php if($record[0]['deliveryDayFreq'] == 'Thu'){ echo "selected"; }?> >Thursday</option>
                                                    <option value="Fri" <?php if($record[0]['deliveryDayFreq'] == 'Fri'){ echo "selected"; }?> >Friday</option>
                                                    <option value="Sat" <?php if($record[0]['deliveryDayFreq'] == 'Sat'){ echo "selected"; }?> >Saturday</option>
                                                </select>
                                                </div>
                                                

                                        <div class="col-lg-2 mb-4">
                                        <label for="SupplierStatus" class="form-label">Status</label>
                                        <select class="form-select" name="status" id="SupplierStatus" <?php echo $disabled; ?> >
                                        <option value=""><?php echo ($form_type == 'view' ? '' : 'Select'); ?></option>
                                        <option value="1" <?php echo (isset($record[0]['status']) && $record[0]['status'] != '2' ? 'selected' : 'selected'); ?>>Active</option>
                                        <option value="2" <?php echo (isset($record[0]['status']) && $record[0]['status'] == '2' ? 'selected' : ''); ?>>Inactive</option>
                                        </select>
                                        </div>
                                        
                                        
                                                
                                                 <div class="col-lg-4 col-md-4 mb-4">
                                                    <div>
                                                        <label for="delivery_info" class="form-label">Delivery Information </label>
                                                        <textarea  class="form-control"  autocomplete="off" name="delivery_info" id="delivery_info" placeholder="Delivery Information"  <?php echo $disabled; ?> ><?php echo (isset($record[0]['delivery_info']) ? $record[0]['delivery_info'] : ''); ?></textarea>
                                                    </div>
                                                </div>
                                                
                                                <?php 
                                              if(!empty($record[0]['mandatory_days'])){
                                              $mandatory_days = unserialize($record[0]['mandatory_days']); 
                                              }else{
                                             $mandatory_days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                                              }
                                              
                                              
                                              ?> 
                                            
                                                  <div class="col-lg-5 mandotryDaysDiv">
                                                  <label for="SupplierStatus" class="form-label">Mandatory Days Schedule</label>
                                                 <select class="js-example-basic-multiple form-control mandatorySelect" data-rel="mandatory"  name="mandatory_days[]" multiple>
                                                    <option value="Sun" <?php if(in_array('Sun',$mandatory_days)){ echo "selected"; }?> >Sunday</option>
                                                    <option value="Mon" <?php if(in_array('Mon',$mandatory_days)){ echo "selected"; }?> >Monday</option>
                                                    <option value="Tue" <?php if(in_array('Tue',$mandatory_days)){ echo "selected"; }?> >Tuesday</option>
                                                    <option value="Wed" <?php if(in_array('Wed',$mandatory_days)){ echo "selected"; }?> >Wednesday</option>
                                                    <option value="Thu" <?php if(in_array('Thu',$mandatory_days)){ echo "selected"; }?> >Thursday</option>
                                                    <option value="Fri" <?php if(in_array('Fri',$mandatory_days)){ echo "selected"; }?> >Friday</option>
                                                    <option value="Sat" <?php if(in_array('Sat',$mandatory_days)){ echo "selected"; }?> >Saturday</option>
                                                    </select>
                                                 </div> 
                                               
                                              
                                               <!-- <div class="col-lg-2 mt-5">-->
                                               <!-- <div class="form-check form-check-dark">-->
                                               <!--             <input class="form-check-input" type="checkbox" id="non_mandatory" name="non_mandatory"  <?php // echo (isset($record[0]['non_mandatory']) && $record[0]['non_mandatory'] == '1' ? 'checked' : ''); ?>>-->
                                               <!--             <label class="form-check-label" for="non_mandatory">-->
                                               <!--               Non mandatory -->
                                               <!--             </label>-->
                                               <!--         </div>-->
                                               <!--</div>-->
                                               <?php 
                                              if(!empty($record[0]['storageArea'])){
                                              $storageArea = unserialize($record[0]['storageArea']); 
                                              }else{
                                             $storageArea = [];
                                              }
                                              
                                              
                                              ?> 
                                                 <div class="col-lg-5 areaList">
                                                  <label for="SupplierStatus" class="form-label">Storage Locations</label>
                                                 <select class="js-example-basic-multiple form-control" data-rel="storageArea"  name="storageArea[]" multiple required>
                                                     <?php if(!empty($areaLists)) {  ?>
                                                      <?php foreach($areaLists as $areaList) {  ?>
                                                    <option value="<?php echo $areaList['id']; ?>" <?php if(in_array($areaList['id'],$storageArea)){ echo "selected"; }?>><?php echo $areaList['name']; ?></option>
                                                     <?php } ?>
                                                     <?php } ?>
                                                    </select>
                                                 </div>
                                                 <div class="row mt-3">
                                                <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requireSC" name="requireSC" <?php echo (isset($record[0]['requireSC']) && $record[0]['requireSC'] == 0 ? '' : 'checked') ?>>
                                                        <label class="form-check-label" for="requireSC">Require Stock Count</label>
                                                    </div>  
                                                 </div> 
                                                 
                                                  <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requireMST" name="requireMST" <?php echo (isset($record[0]['requireMST']) && $record[0]['requireMST'] == 1 ? 'checked' : '') ?>>
                                                        <label class="form-check-label" for="requireMST">Monthly Stock Take</label>
                                                    </div>  
                                                 </div> 
                                                 
                                               <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input"  id="requireTC" name="requireTC" <?php echo (isset($record[0]['requireTC']) && $record[0]['requireTC'] == 1 ? 'checked' : '') ?>>
                                                        <label class="form-check-label" for="requireTC">Require Temperature Check</label>
                                                    </div>  
                                                 </div> 
                                                 <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requireDD" name="requireDD" <?php echo (isset($record[0]['requireDD']) && $record[0]['requireDD'] == 0 ? '' : 'checked') ?>>
                                                        <label class="form-check-label" for="requireDD">Require Delivery Date</label>
                                                    </div>  
                                                 </div>  
                                                 
                                                 <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="allowForceOrder" name="allowForceOrder" <?php echo (isset($record[0]['allowForceOrder']) && $record[0]['allowForceOrder'] == 0 ? '' : 'checked') ?>>
                                                        <label class="form-check-label" for="allowForceOrder">Allow Force Order </label>
                                                    </div>  
                                                 </div>  
                                                 
                                                  <div class="col-lg-3 col-sm-6">  
                                               <div class="form-check form-switch form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requirePL" name="requirePL" <?php echo (isset($record[0]['requirePL']) && $record[0]['requirePL'] == 0 ? '' : 'checked') ?>>
                                                        <label class="form-check-label" for="requirePL">Require PAR Level</label>
                                                    </div>  
                                                 </div>  
                                               </div>
                                                 
                                               
                                               <!-- Inline & Block Element Collapse -->
                                               <div class="row mt-3">
<div class="mb-3">
    <a href="#" class="link-secondary"  data-bs-toggle="collapse" data-bs-target="#collapseblock" aria-expanded="true" aria-controls="collapseblock"> More Options</a>
</div>
<div class="collapse collapse-horizontal" id="collapseblock">
    <div class="row">
   <div class="col-lg-4 mb-4">
                 <label for="haccp_expiry_date" class="form-label">Haccap Expiry Date </label>
                  <input type="text" class="form-control" name="haccp_expiry_date" autocomplete="off" id="haccp_expiry_date" data-date-format="d-m-Y" placeholder="dd-mm-yyyy" data-provider="flatpickr" data-date-format="d M, Y" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['haccp_expiry_date']) ? $record[0]['haccp_expiry_date'] : ''); ?>">
                 </div>
                 <div class="col-lg-4 mb-4">
                 <label for="cfr_expiry_date" class="form-label">CRF Expiry Date</label>
                 <input type="text" class="form-control" name="cfr_expiry_date" autocomplete="off" id="cfr_expiry_date" data-date-format="d-m-Y" placeholder="dd-mm-yyyy" data-provider="flatpickr" data-date-format="d M, Y" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['cfr_expiry_date']) ? $record[0]['cfr_expiry_date'] : ''); ?>">
                 </div>
                 <div class="col-lg-4 mb-4">
                 <label for="account_code" class="form-label">Account Code</label>
                  <input type="text" class="form-control" name="account_code" autocomplete="off" id="account_code" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['account_code']) ? $record[0]['account_code'] : ''); ?>">
                 </div>
                 </div>
          
</div>
     </div>                                           
              </div>
                                        </div>
                                        </form>
                                    </div><!-- end card -->
                                    
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                      </div>
                
                </div>
              
            </div>
              <div id="flipModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                            
                                                              
                                                                    <label for="name-field" class="form-label">Sub Category Name</label>
                                                                    <input type="text"  name="category_name" id="category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter sub category name
                                                                    </div>
                                                               
                                                            </div>
                                                            
                                                             <div class="col-lg-12">
                                                            <label for="category_id" class="form-label">Supplier Category</label>
                                                        <select class="js-example-basic-single" name="category_id" id="addcategory_id" <?php echo $disabled; ?> >
                                                            <option value="">Select</option>
                                                            
                                                        <?php if(!empty($supplier_Maincategories)){ 
                                                            foreach($supplier_Maincategories as $supCat){ ?>
                                                               <option value="<?php echo $supCat['category_id']; ?>"><?php echo $supCat['category_name']; ?></option>
                                                        <?php } }  ?>
                                                        </select>
                                                               
                                                            </div>
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addCat()">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
<script>
$(document).ready(function() {
   
    if ($('#non_mandatory').prop('checked')) {
        $('.mandotryDaysDiv').hide();
    }
    $('#non_mandatory').change(function() {
        if (this.checked) {
            $('.mandotryDaysDiv').hide(); 
        } else {
            $('.mandotryDaysDiv').show(); 
        }
    });
    
    $(".delivery_date_type").change(function() {
        let selectedValue = $(this).val();
        if (selectedValue === "dateWise") {
            $(".inputDateFreq").show();
            $(".inputDayFreq").hide();
        } else if (selectedValue === "dayWise") {
            $(".inputDateFreq").hide();
            $(".inputDayFreq").show();
        } else {
            $(".inputDateFreq").hide();
            $(".inputDayFreq").hide();
        }
    });
    
    let selectedValue = $('.delivery_date_type').val();
    if (selectedValue === "dateWise") {
            $(".inputDateFreq").show();
            $(".inputDayFreq").hide();
        } else if (selectedValue === "dayWise") {
            $(".inputDateFreq").hide();
            $(".inputDayFreq").show();
        } else {
            $(".inputDateFreq").hide();
            $(".inputDayFreq").hide();
        }
});

</script>

           <script>
           
           $("#category_id").on('change',function(){
               let val = $(this).val();
               if(val=='addnew'){
               $("#flipModal").modal('show');    
               }
               
           });
           function addCat(){
            let category_name = $("#category_name").val()
            let parentCategory_id = $("#addcategory_id").val()
            if(category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_Subcategory/add",
                 data:'category_name='+category_name+'&category_id='+parentCategory_id,
                 success: function(data){
                    location.reload();
                }
                });
        }
           </script>