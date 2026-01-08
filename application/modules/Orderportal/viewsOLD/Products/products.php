<?php if($form_type == 'view'){ $disabled = 'disabled'; }else{ $disabled = ''; } ?>
                   <?php
                  
                     $paramsToEncrypt = ($form_type == 'edit' ? $record[0]['product_id'] : 'new').'|'.$supplierName.'|'.$isPARLevelRequired;
                     $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                     $encodedParams = urlencode(urlencode(urlencode($encryptedParams)));
                      ?>  
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                   <div class="card-body">
                                        <form  id="productForm" class="needs-validation" action="/Supplier/manage_products/<?php echo $form_type; ?>/<?php echo $encodedParams; ?>" method="post" novalidate>
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-uppercase fw-bold text-black"><?php echo $form_type; ?> Product</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end gap-2">
                                     <a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                                
                                                        <?php if($form_type == 'add'){ ?>
                                                            <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Save</span></button>
                                                        <?php }else if($form_type == 'edit'){ ?>
                                                            <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-refresh-line label-icon align-middle fs-16 me-2"></i><span>Update</span></button>
                                                        <?php } ?>
                           
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-lg-4">
                                                        <label for="categoryNameInput" class="form-label">Supplier *</label>
                                                        <select class="js-example-basic-single" required name="supplier_id" id="categoryNameInput" <?php echo $disabled; ?>>
                                                            <option value=""><?php echo ($form_type == 'view' ? '' : 'Select Option'); ?></option>
                                                            <?php if(!empty($suppliers)){ 
                                                                foreach($suppliers as $sup){
                                                                if($sup['supplier_id'] == $record[0]['supplier_id'] || $sup['supplier_id'] == $suppID){ ?>
                                                                <option value="<?php echo $sup['supplier_id']; ?>" selected><?php echo $sup['supplier_name']; ?></option>
                                                                <?php } else{ ?>
                                                                <option value="<?php echo $sup['supplier_id']; ?>"><?php echo $sup['supplier_name']; ?></option>
                                                                
                                                            <?php }}} ?>
                                                            </select>
                                            <div class="invalid-feedback">Please choose a supplier name.</div>
                                            </div>
                                            </div>
                                            <div class="row mt-3">
                                              
                                                <div class="col-lg-3 col-md-3 mb-4">
                                                    <div>
                                                        <label for="categoryNameInput" class="form-label">Product Code</label>
                                                        <input type="text" class="form-control" autocomplete="off"  name="product_code" id="categoryNameInput" placeholder="Product Code" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['product_code']) ? $record[0]['product_code'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 mb-4">
                                                    <div>
                                                        <label for="categoryNameInput" class="form-label">Product Name *</label>
                                                        <input type="text" class="form-control" autocomplete="off"  required name="product_name" id="categoryNameInput" placeholder="Product Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['product_name']) ? $record[0]['product_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                               <div class="col-lg-3 col-md-3 mb-4">
                                                 <label for="categoryNameInput" autocomplete="off" class="form-label">Product Price *</label>
                                                <input type="text" class="form-control" required name="price" id="categoryNameInput" placeholder="Product Price" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['price']) ? $record[0]['price'] : ''); ?>">
                                                </div>  
                                                
                                                <div class="col-lg-3 col-md-3 mb-4">
                                                  
                                                        <label for="categoryNameInput" class="form-label">Product Category</label>
                                                        <select class="js-example-basic-single"  name="product_category_id" id="category_id" <?php echo $disabled; ?> >
                                                           <option value=""><?php echo ($form_type == 'view' ? '' : 'Select Option'); ?></option>
                                                            <option value="addnew" class="fw-bold"><?php echo ($form_type == 'view' ? '+ Add new' : '+ Add New'); ?></option>
                                                        <?php if(!empty($product_category)){ 
                                                                foreach($product_category as $product_cat){
                                                                    if($product_cat['product_category_id'] == $record[0]['product_category_id']){
                                                            ?>
                                                                <option value="<?php echo $product_cat['product_category_id']; ?>" selected><?php echo $product_cat['product_category_name']; ?></option>
                                                                <?php } else{ ?>
                                                                <option value="<?php echo $product_cat['product_category_id']; ?>"><?php echo $product_cat['product_category_name']; ?></option>
                                                            <?php }}} ?>
                                                            </select>
                                                   
                                                </div>
                                                </div> 
                                              <div class="row mt-3">  
                                              <?php if($isPARLevelRequired == 1){  ?>
                                              <input type="hidden" name="isPARLevelRequired" value="<?php echo $isPARLevelRequired; ?>">
                                               <div class="col-lg-4">
                                                     <label for="categoryNameInput" class="form-label">Product UOM Type</label>
                                                <select class="form-select" required name="tier_type" id="product_tier_type" <?php echo $disabled; ?>>
                                                    <option value="">Select Option</option>
                                                    <option value="t1" <?php echo  (isset($record[0]['tier_type']) && $record[0]['tier_type'] == 't1' ? 'selected' : '') ?>>UOM (Example: EACH) </option>
                                                    <option value="t2" <?php echo  (isset($record[0]['tier_type']) && $record[0]['tier_type'] == 't2' ? 'selected' : '') ?>>UOM (Example: BOX, EACH) </option>
                                                    <option value="t3" <?php echo  (isset($record[0]['tier_type']) && $record[0]['tier_type'] == 't3' ? 'selected' : '') ?>>UOM (Example: BOX, SLEEVE, EACH)</option>
                                                </select>     
                                                 </div>
                                                 <?php }else { ?>
                                                 <div class="col-lg-4">
                                                     <label for="categoryNameInput" class="form-label">Product UOM Type</label>
                                                <select class="form-select" required name="tier_type" id="product_tier_type" <?php echo $disabled; ?>>
                                         <option value="t1" <?php echo  (isset($record[0]['tier_type']) && $record[0]['tier_type'] == 't1' ? 'selected' : '') ?>>UOM (Example: EACH) </option>
                                                </select>     
                                                 </div>
                                                 <?php } ?>
                                                 </div>
                 <!--------------------------------         TIER 1,2,3  START     ------------------------------------------------------------------>
              <div class="row mt-3">  
               <div class="col-lg-2 col-md-2 t2 t3 uom">
                      <label for="categoryNameInput" class="form-label">Cafe Unit UOM *</label>
                       <select class="js-example-basic-single uomDropdown uomValidate"  name="cafe_unit_uom" id="cafe_unit_uom" <?php echo $disabled; ?>>
                      <option value=""><?php echo ($form_type == 'view' ? '' : 'Select Option'); ?></option>
                    <option value="addnew" class="fw-bold"><?php echo ($form_type == 'view' ? '+ Add new' : '+ Add New'); ?></option>
                      <?php if(!empty($product_UOM)){ 
                         foreach($product_UOM as $proUOM){
                        if($proUOM['product_UOM_id'] == (isset($record[0]['cafe_unit_uom']) ? $record[0]['cafe_unit_uom'] : '')){ ?>
                         <option value="<?php echo $proUOM['product_UOM_id']; ?>" selected><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php } else{ ?>
                       <option value="<?php echo $proUOM['product_UOM_id']; ?>"><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php }}} ?>
                      </select>
                     <div class="invalid-feedback">Please choose Cafe Unit UOM.</div>                                
                          </div>  
                          
                          
              <div class="col-lg-2 col-md-2 mb-4 t2 t3 uom">
                          <label for="categoryNameInput" autocomplete="off" class="form-label">Cafe Unit UOM Quantity *</label>
                          <input type="text" class="form-control uomValidate"  name="cafe_unit_uomQty" id="cafe_unit_uomQty" placeholder="Quantity Per UOM" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['cafe_unit_uomQty']) ? $record[0]['cafe_unit_uomQty'] : ''); ?>">
                          <small>Example: How many pieces in a bag</small> 
                          </div> 
               <!--------------------------------         TIER 2 START    ------------------------------------------------------------------>                                  
                
                                                 
                    <div class="col-lg-3 col-md-3 mb-4 t3 uom">
                      <label for="categoryNameInput" class="form-label">Inner Unit UOM *</label>
                       <select class="js-example-basic-single uomDropdown uomValidate" required name="inner_unit_uom" id="inner_unit_uom" <?php echo $disabled; ?>>
                      <option value=""><?php echo ($form_type == 'view' ? '' : 'Select Option'); ?></option>
                    <option value="addnew" class="fw-bold"><?php echo ($form_type == 'view' ? '+ Add new' : '+ Add New'); ?></option>
                      <?php if(!empty($product_UOM)){ 
                         foreach($product_UOM as $proUOM){
                        if($proUOM['product_UOM_id'] == (isset($record[0]['inner_unit_uom']) ?  $record[0]['inner_unit_uom'] :'')){ ?>
                         <option value="<?php echo $proUOM['product_UOM_id']; ?>" selected><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php } else{ ?>
                       <option value="<?php echo $proUOM['product_UOM_id']; ?>"><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php }}} ?>
                      </select>
                     <div class="invalid-feedback">Please choose Inner Unit UOM.</div>  
                      </div> 
                    <div class="col-lg-2 col-md-2 mb-4 t3 uom">
                    <label for="categoryNameInput" autocomplete="off" class="form-label"> Inner Unit UOM Quantity *</label>
                    <input type="text" class="form-control uomValidate"  name="inner_unit_uomQty" id="inner_unit_uomQty" placeholder="Count" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['inner_unit_uomQty']) ? $record[0]['inner_unit_uomQty'] : ''); ?>">
                    <small>Example: How many lids in a sleeve</small> 
                    </div>
                    

                <!--------------------------------         TIER 2,3 START     ------------------------------------------------------------------>           
                 

                
                    
                        <div class="col-lg-3 col-md-3 mb-4 t1 t2 t3  uom">
                      <label for="categoryNameInput" class="form-label">Each Unit UOM *</label>
                       <select class="js-example-basic-single uomDropdown uomValidate" required name="each_unit_uom" id="each_unit_uom" <?php echo $disabled; ?>>
                      <option value=""><?php echo ($form_type == 'view' ? '' : 'Select Option'); ?></option>
                    <option value="addnew" class="fw-bold"><?php echo ($form_type == 'view' ? '+ Add new' : '+ Add New'); ?></option>
                      <?php if(!empty($product_UOM)){ 
                         foreach($product_UOM as $proUOM){
                        if($proUOM['product_UOM_id'] == (isset($record[0]['each_unit_uom']) ? $record[0]['each_unit_uom'] : '')){ ?>
                         <option value="<?php echo $proUOM['product_UOM_id']; ?>" selected><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php } else{ ?>
                       <option value="<?php echo $proUOM['product_UOM_id']; ?>"><?php echo $proUOM['product_UOM_name']; ?></option>
                        <?php }}} ?>
                      </select>
                  <div class="invalid-feedback">Please choose Each Unit UOM.</div>    
                     </div>
                   
                                                   
                  </div>                               
                                                
                                                
                   <!--------------------------------         TIER 3 END     ------------------------------------------------------------------>                                 
                                                
                      <div class="col-md-12">
                        <h4 class="card-title mb-0">   PAR Level</h4>
                       <div class="table-responsive">
                                            <div class="form-check form-check-success mb-3">
                                                            <input class="form-check-input" type="checkbox" id="sameStockforAllDays" name= "sameStockforAllDays" <?php echo (isset($record[0]['is_sameOnAllDays']) && $record[0]['is_sameOnAllDays'] == 1 ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="sameStockforAllDays">
                                                            PAR Level on all days
                                                            </label>
                                                        </div>
                                      
                                         
                                         <div class="col-lg-2 col-md-2 mb-4 sameOnAllDayDiv">                
                                           <input type="text" class="form-control sameOnAllDayInput" name="PARLevelQty" placeholder="PAR Level Quantity" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['PARLevelQty']) ? $record[0]['PARLevelQty'] : ''); ?>" > 
                                            </div>
                                         
                                            <table class="table table-bordered table-nowrap align-middle mb-0 diffOnAllDayDiv">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <?php 
                                                        foreach (DaysOfWeek as $day) { ?>
                                                         <th><?php echo $day; ?></th>    
                                                       <?php  }?>
   
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <tr>
                                                       <?php  foreach (DaysOfWeek as $day) { ?>
                                                       <?php $product_stockQty = ( isset($record[0]['AllDaysPARLevelQty']) && !empty($record[0]['AllDaysPARLevelQty']) ? unserialize($record[0]['AllDaysPARLevelQty']) : '') ?>
                                                       <td><input type="text" class="form-control <?php echo$day  ?>_stockChkClass" name="<?php echo $day ?>_stockQty" value="<?php echo (isset($product_stockQty[$day.'_stockQty']) ? $product_stockQty[$day.'_stockQty'] : ''); ?>"></td>
                                                       <?php } ?>
                                                    </tr>
                                                    
                                                </tbody><!-- end tbody -->
                                               
                                            </table>
                                           
                                            <!-- end table -->
                                        </div><!-- end table responsive -->
                                 
                              
                            </div><!-- end col -->
                            
                     <div class="row">
<div class="mb-3">
    <a href="#" class="link-secondary"  data-bs-toggle="collapse" data-bs-target="#collapseblock" aria-expanded="true" aria-controls="collapseblock"> More Options</a>
</div>
<div class="collapse" id="collapseblock">
    <div class="row">
  <div class="col-lg-4 mb-4">
     <label for="account_number" class="form-label">Account Number</label>
    <input type="text" class="form-control"  name="account_number" autocomplete="off" id="account_number" placeholder="Account Number" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['account_number']) ? $record[0]['account_number'] : ''); ?>">
    </div>
      <div class="col-lg-4 mb-4">
      <label for="account_name" class="form-label">Account Name</label>
      <input type="text" class="form-control"  name="account_name" autocomplete="off" id="account_name" placeholder="Account Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['account_name']) ? $record[0]['account_name'] : ''); ?>">
      </div>
      <div class="col-lg-4 mb-4">
      <label for="tax_code" class="form-label">Tax Code</label>
      <input type="text" class="form-control"  name="tax_code" autocomplete="off" id="tax_code" placeholder="Tax Code" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['tax_code']) ? $record[0]['tax_code'] : ''); ?>">
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                
                                                                <div>
                                                                    <label for="name-field" class="form-label">Category Name</label>
                                                                    <input type="text"  name="product_category_name" id="product_category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Category name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addCategory()">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
             <div id="UomModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add UOM</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                
                                                                <div>
                                                                    <label for="name-field" class="form-label">UOM Name</label>
                                                                    <input type="text"  name="product_UOM_name" id="product_UOM_name" class="form-control" placeholder="Enter UOM name" required="">
                                                                <div class="invalid-feedback" style="display:none">
                                                                    Please enter UOM name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addUom()">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>                                    
            <script>
        function addCategory(){
            let product_category_name = $("#product_category_name").val()
            if(product_category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/manage_product_categories/add/new",
                 data:'product_category_name='+product_category_name,
                 success: function(data){
                    location.reload();
                }
                });
        }    
        
        function addUom(){
            let uomName = $("#product_UOM_name").val()
            if(uomName == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_product_UOM/add",
                 data:'product_UOM_name='+uomName,
                 success: function(data){
                    location.reload();
                }
                });
        }
            $("#category_id").on('change',function(){
               let val = $(this).val();
               if(val=='addnew'){
               $("#flipModal").modal('show');    
               }
               
           });
           
            $(".uomDropdown").on('change',function(){
               let val = $(this).val();
               if(val=='addnew'){
               $("#UomModal").modal('show');    
               }
               
           });
            $(document).ready(function () {
                let isParLevelrequired = '<?php echo $isPARLevelRequired; ?>';
                let requireMonthlystockTake = '<?php echo $requireMonthlystockTake; ?>';
                let requireStockCount = '<?php echo $requireStockCount; ?>' 
     $('#sameStockforAllDays').on('change', function (e) {
         e.preventDefault();
          
        if (this.checked) { 
            $(".sameOnAllDayDiv").show();
            $(".diffOnAllDayDiv").hide();
            if(isParLevelrequired == 1 && requireMonthlystockTake == 0 && requireStockCount ==0){
            $(".sameOnAllDayInput").attr('required', 'required');    
            }
            
        $('.Sunday_stockChkClass, .Monday_stockChkClass, .Tuesday_stockChkClass, .Wednesday_stockChkClass, .Thursday_stockChkClass, .Friday_stockChkClass, .Saturday_stockChkClass').removeAttr('required');  
        } else { 
        $(".sameOnAllDayDiv").hide();$(".diffOnAllDayDiv").show(); 
        $(".sameOnAllDayInput").removeAttr('required');
         if(isParLevelrequired == 1 && requireMonthlystockTake == 0 && requireStockCount ==0){
       $('.Sunday_stockChkClass, .Monday_stockChkClass, .Tuesday_stockChkClass, .Wednesday_stockChkClass, .Thursday_stockChkClass, .Friday_stockChkClass, .Saturday_stockChkClass').attr('required', 'required');
       }
       }
    });
    
   
    $('.sameOnAllDayInput').on('input', function(e) {
        e.preventDefault();
    let value = $(this).val();         
     $('.Sunday_stockChkClass, .Monday_stockChkClass, .Tuesday_stockChkClass, .Wednesday_stockChkClass, .Thursday_stockChkClass, .Friday_stockChkClass, .Saturday_stockChkClass').val(value);    
    });
    
    $(".uom").hide();
     $(".uomValidate").removeAttr('required');
    // On page load , for edit and view product
    let className = $("#product_tier_type").val();
    if(className !=''){
    $("."+ className).show();
    $("."+ className+' select').attr('required', 'required');
    $("."+ className+' input').attr('required', 'required');    
    }
    
    let sameStockforAllDays = $("#sameStockforAllDays").prop("checked");
   
    if(sameStockforAllDays){
    $(".diffOnAllDayDiv").hide();    
    }else{
     $(".sameOnAllDayDiv").hide(); 
     if(isParLevelrequired == 1 && requireMonthlystockTake == 0 && requireStockCount ==0){
     $('.Sunday_stockChkClass, .Monday_stockChkClass, .Tuesday_stockChkClass, .Wednesday_stockChkClass, .Thursday_stockChkClass, .Friday_stockChkClass, .Saturday_stockChkClass').attr('required', 'required');    
    }
    }
    $("#product_tier_type").on('change',function(){
                let className = $(this).val();
                $(".uom").hide();
                $(".uomValidate").removeAttr('required');
                $("."+className).show();
                $("."+className+' select').attr('required', 'required');
                $("."+className+' input').attr('required', 'required');
           });
     });
     
     
    

            </script>
          

       