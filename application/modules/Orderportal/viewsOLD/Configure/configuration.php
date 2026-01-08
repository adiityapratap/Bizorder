<button type="button" data-toast="" data-toast-text="Settings Updated succesfully" data-toast-gravity="top" data-toast-position="center"
data-toast-classname="success" data-toast-duration="3000" class="btn btn-light w-xs d-none btnToastSuccess"></button>
<button type="button" data-toast="" data-toast-text="Error ! An error occurred." data-toast-gravity="top"
data-toast-position="center" data-toast-classname="danger" data-toast-duration="3000" class="btn btn-light w-xs btnToastErr">Error</button>

<div class="main-content">
<div class="page-content">
                    <div class="container-fluid">
 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                
              <div class="card-body">
             <form method="post" class="form-horizontal mt-5" id="configForm">         
               <div class="row g-4 mb-3">
                  <div class="col-sm-auto">
                   <div>
                   <h4 class="card-title mb-0 text-uppercase fw-bold text-black">Settings</h4>
                   </div>
                   </div>
                   <div class="col-sm">
                   <div class="d-flex justify-content-sm-end gap-2">
                       <!--<a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                                -->
                          <?php if($configId == ''){ ?>
                       <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>submit</span></button>
                     <?php }else { ?>
                     <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-refresh-line label-icon align-middle fs-16 me-2"></i><span>Update</span></button>
                     <?php } ?>
                    </div>
                    </div>
                       </div>
              
                 
                  <input type="hidden" name="configId" value="<?php echo $configId; ?>">
                  <div class="row mb-4"> 
                   <div class="col-md-6 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="hideInvoiceSection" <?php echo (isset($configData['showInvoice']) && $configData['showInvoice'] == 1  ? 'checked' : '') ?> name="hideInvoiceSection">
                     <label class="form-check-label" for="hideInvoiceSection">Display Invoice Upload in the Receive Page</label>
                     </div>
                      </div>
                      </div>
                      <div class="row"> 
              <div class="col-md-4 col-sm-12">
                     <label for="sort_order" class="form-label fw-semibold">  Cafe Name</label>
      <input type="text" name="orzName" value="<?php echo (isset($configData['orzName']) && $configData['orzName'] !='' ? $configData['orzName'] : '') ?>" class="form-control">
                    </div> 
                    
                    <div class="col-md-4 col-sm-12">
                     <label for="sort_order" class="form-label fw-semibold">  Email</label>
      <input type="text" name="email" value="<?php echo (isset($configData['email']) && $configData['email'] !='' ? $configData['email'] : '') ?>" class="form-control">
                    <small>Add the email to display for supplier page </small> 
                    </div> 
                    
                       <div class="col-md-4 col-sm-12">
                     <label for="sort_order" class="form-label fw-semibold">  Approval Supplier Email</label>
      <input type="text" name="budgetExceedEmail" value="<?php echo (isset($configData['budgetExceedEmail']) && $configData['budgetExceedEmail'] !='' ? $configData['budgetExceedEmail'] : '') ?>" class="form-control">
                    <small>Add the email to send approval  mail for budget exceeded orders</small> 
                    </div> 
                    
                    <div class="col-md-3 col-sm-12">
                     <label for="sort_order" class="form-label fw-semibold">  Contact</label>
                    <input type="text" value="<?php echo (isset($configData['phone']) && $configData['phone'] !='' ? $configData['phone'] : '') ?>" class="form-control" name="phone" >
                 
                    </div> 
                    
                  </div> 
                  <h5 class="text-black label mt-4"> Dashboard Configuration </h5>
                   <div class="row mb-4"> 
                    <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showDashboardHeaderSection" <?php echo (isset($configData['showDashboardHeaderSection']) && $configData['showDashboardHeaderSection'] == 1  ? 'checked' : '') ?> name="showDashboardHeaderSection">
                     <label class="form-check-label" for="showDashboardHeaderSection">Display Dashboard Header</label>
                     </div>
                      </div>
                      
                   <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showTodayOrderSection" <?php echo (isset($configData['showTodayOrderSection']) && $configData['showTodayOrderSection'] == 1  ? 'checked' : '') ?> name="showTodayOrderSection">
                     <label class="form-check-label" for="showTodayOrderSection">Display Today's Order</label>
                     </div>
                      </div>
                      
                      <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showInternalOrder" <?php echo (isset($configData['showInternalOrder']) && $configData['showInternalOrder'] == 1  ? 'checked' : '') ?> name="showInternalOrder">
                     <label class="form-check-label" for="showInternalOrder">Display Internal Order on Dashboard</label>
                     </div>
                      </div>
                      
                       <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showDeliverySection" <?php echo (isset($configData['showDeliverySection']) && $configData['showDeliverySection'] == 1  ? 'checked' : '') ?> name="showDeliverySection">
                     <label class="form-check-label" for="showDeliverySection">Display Delivery Section</label>
                     </div>
                      </div>
                      
                        <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showInternalOrderDeliverySection" <?php echo (isset($configData['showInternalOrderDeliverySection']) && $configData['showInternalOrderDeliverySection'] == 1  ? 'checked' : '') ?> name="showInternalOrderDeliverySection">
                     <label class="form-check-label" for="showInternalOrderDeliverySection">Display Internal Order Delivery Section</label>
                     </div>
                      </div>
                      
                        <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showFooterGraphSection" <?php echo (isset($configData['showFooterGraphSection']) && $configData['showFooterGraphSection'] == 1  ? 'checked' : '') ?> name="showFooterGraphSection">
                     <label class="form-check-label" for="showFooterGraphSection">Display Footer Graph</label>
                     </div>
                      </div>
                      
                       <div class="col-md-4 col-sm-12">
                   <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="showFocusSupplierSection" <?php echo (isset($configData['showFocusSupplierSection']) && $configData['showFocusSupplierSection'] == 1  ? 'checked' : '') ?> name="showFocusSupplierSection">
                     <label class="form-check-label" for="showFocusSupplierSection">Display Focus Supplier</label>
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
                    <!-- container-fluid -->
                </div>
              
            </div>
            
            <script>
      $("#configForm").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/Supplier/configuresubmit",
            data: formData,
            success: function (response) {
              
                $('.btnToastSuccess').click();
           
            },
            error: function (xhr, status, error) {
                // Handle any errors (if needed)
                console.error(xhr, status, error);
                 $('.btnToastErr').click();
            }
        });
    });
            
            </script>
          