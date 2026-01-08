<?php
    $paramsToEncrypt = $supplier_id.'|'.$supplierName.'|'.$isPARLevelRequired;
    $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
    $encodedParams = urlencode(urlencode(urlencode($encryptedParams)));
    ?>
<div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        
                        <div class="alert alert-success shadow d-none" role="alert">
                       <strong> Success !</strong> Product deleted succesfully .
                       </div>
                       <?php
                       if(isset($imported) && $imported !=''){ ?>
                       <div class="alert alert-success shadow alertImportSuccess d-none" role="alert">
                       <strong> Success !</strong> <?php echo $imported; ?>
                       </div>
                        <?php } ?>
                     
                     <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  

                                    <div class="card-body">
                                    
                                    <div class="row g-4" style="float:right">
        <form action="<?= base_url('Supplier/Product/importProduct'); ?>" method="post" enctype="multipart/form-data" class="mt-4 d-flex gap-3">
            <div class="col-sm">
            <input type="file" name="file" id="file" class="form-control" required>
            <input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>" class="form-control" required>
            <input type="hidden" name="supplier_name" value="<?php echo $supplierName; ?>" class="form-control" required>
            <input type="hidden" name="isPARLevelRequired" value="<?php echo $isPARLevelRequired; ?>" class="form-control" required>
         </div> 
         <div class="col-sm">
          <button type="submit" class="btn btn-success btn-sm"><i class="ri-file-excel-fill me-1 align-bottom"></i>Import</button>
            </div>       
              </form>
            </div>
            
                                     <form id="bulkUpdateForm" action="/Supplier/Product/bulkUpdate/<?php echo $encodedParams; ?>" method="POST">      
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-black">Supplier Products [<?php echo $supplierName; ?>]</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <?php
                                                    $paramsToEncrypt = $supplier_id.'|'.$supplierName.'|'.$isPARLevelRequired;
                                                    $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                                                    $encodedParamsAdd = urlencode(urlencode(urlencode($encryptedParams)));
                                                    ?>
                                                        <div class="d-flex justify-content-sm-end gap-2">
         <a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light btn-sm"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                            
        <a href="/Supplier/manage_products/add/<?php echo $encodedParamsAdd; ?>" class="btn btn-primary btn-label view-item-btn btn-sm"><i class="ri-add-fill label-icon align-middle fs-16 me-2"></i><span>Add New</span></a>
        <a href="#" class="btn btn-success btn-label view-item-btn btn-sm" onclick="sumitBulkOrder()"><i class="ri-save-line label-icon align-middle fs-16 me-2"></i><span> Update</span> </a>
        <a href="/Supplier/Product/downloadSampleProduct/<?php echo $supplier_id; ?>"  class="btn bg-warning btn-sm waves-effect btn-label waves-light"><i class="ri-file-download-fill label-icon align-middle fs-16 me-2"></i><span>Download Sample</span></a>                                                          
                                                        </div>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                           
                                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Delivered active" data-bs-toggle="tab"
                                                    href="#activeProductsTab" role="tab" aria-selected="false">
                                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Active
                                                </a>
                                            </li>
                                           
                                           
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" 
                                                    href="#inActiveProductsTab" role="tab" aria-selected="false">
                                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Inactive
                                                </a>
                                            </li>
                                        </ul>  
                                               
                                           <div class="tab-content  mb-1">
                                              
                                        <div class="tab-pane table-responsive  active show" role="tabpanel"  id="activeProductsTab">
                                          <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                       <tr>
                                                            <th class="sort" data-sort="product_code">Product Code</th>
                                                            <th class="sort" data-sort="product_name">Product Name</th>
                                                            <th class="sort" data-sort="price">Price</th>
                                                             <th class="sort" data-sort="price">Category</th>
                                                            <th class="sort" data-sort="approve">Status</th>
                                                            <th class="no-sort" width="200">Action</th>
                                                     </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all" id="sortable">
                                                        <?php if(!empty($record)) {  ?>
                                                        
                                                        <?php foreach($record as $row){  ?>
                                      <tr id="row_<?php echo  $row['product_id']; ?>" >
                        <td class="product_code">
                         <input  class="form-input form-control-icon" name="<?php echo  $row['product_id']; ?>[]" value="<?php echo $row['product_code']; ?>">
                        </td>
                        
                        <td class="product_name"><?php echo $row['product_name']; ?></td>
                        
                         <td class="price">
                            <div class="form-icon">
                          <input  class="form-input form-control-icon" name="<?php echo  $row['product_id']; ?>[]" value="<?php echo number_format($row['price'],2); ?>">
                            <i class="bx bx-dollar"></i>
                           </div>                             
                          </td>
                          
                           <td class="category"><?php echo $row['product_category_name']; ?></td>
                          <td class="approve">
                           <div class="form-check form-switch form-switch-success">
                            <input class="form-check-input updateStatus" type="checkbox" rel-id="<?php echo $row['product_id']; ?>" role="switch" id="is_unapprove_<?php echo $row['product_id']; ?>" <?php echo($row['product_status'] == '1' ? 'checked' : '' ); ?>>
                           </div>
                           </td>
                      
                      <td>
                     <?php
                 
                     
                      $paramsToEncrypt = $row['product_id'].'|'.$supplierName.'|'.$isPARLevelRequired;
                     $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                     $encodedParams = urlencode(urlencode(urlencode($encryptedParams)));
                      ?>      
                      <ul class="list-inline hstack gap-2 mb-0">
                        <!--<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">-->
                        <!-- <a href="/Supplier/manage_products/view/<?php // echo $encodedParams; ?>" class="text-primary d-inline-block">-->
                        <!-- <i class="ri-eye-fill fs-16"></i>-->
                        <!--</a>-->
                        <!--</li>-->
                        <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                         <a class="text-success"  href="/Supplier/manage_products/edit/<?php echo $encodedParams; ?>"  class="text-primary d-inline-block edit-item-btn">
                         <i class="ri-pencil-fill fs-16"></i>
                         </a>
                         </li>
                         <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                          <a class="text-danger d-inline-block remove-item-btn"  href="#deleteOrder" data-rel-id="<?php echo  $row['product_id']; ?>">
                         <i class="ri-delete-bin-5-fill fs-16"></i>
                         </a>
                         </li>
                        </ul>
                        </td>    
                          </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                               
                                               </div>
                                              
                                     <div class="tab-pane  table-responsive " role="tabpanel"  id="inActiveProductsTab">
                                       <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="sort" data-sort="product_code">Product Code</th>
                                                            <th class="sort" data-sort="product_name">Product Name</th>
                                                            <!--<th class="sort" data-sort="product_name">UOM</th>-->
                                                            <th class="sort" data-sort="price">Price</th>
                                                             <th class="sort" data-sort="price">Category</th>
                                                            <th class="sort" data-sort="approve">Status</th>
                                                            <th class="no-sort" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all">
                                                        <?php if(!empty($inactiveRecord)) {  ?>
                                                        
                                                        <?php foreach($inactiveRecord as $row){  ?>
                                                        <tr id="row_<?php echo  $row['product_id']; ?>" >
                                                            <td class="product_code"><?php echo $row['product_code']; ?></td>
                                                            <td class="product_name"><?php echo $row['product_name']; ?></td>
                                                             <!--<td class="product_name"><?php $product_uom_id = $row['product_uom_id']; $uomName = array_filter($product_UOM, function ($value) use ($product_uom_id) { return $value['product_UOM_id'] == $product_uom_id;}); echo(isset($uomName[0]['product_UOM_name']) ? $uomName[0]['product_UOM_name'] : '') ; ?></td>-->
                                                            <td class="price"><?php echo "$".number_format($row['price'],2); ?></td>
                                                            <td class="category"><?php echo $row['product_category_name']; ?></td>
                                                           
                                                            <td class="approve">
                                                                <!-- Switches Color -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input updateStatus" type="checkbox" rel-id="<?php echo $row['product_id']; ?>" role="switch" id="is_unapprove_<?php echo $row['product_id']; ?>" <?php echo($row['product_status'] == '1' ? 'checked' : '' ); ?>>
                                                                </div>
                                                            </td>
                                                               
                                                        <td>
                                                    <?php 
                       
                         $paramsToEncrypt = $row['product_id'].'|'.$supplierName.'|'.$isPARLevelRequired;
                        $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                        $encodedParamsInactiveS = urlencode(urlencode(urlencode($encryptedParams)));
                      ?>           
                                                            
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <!--<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"-->
                                                                <!--    data-bs-placement="top" title="View">-->
                                                                <!--    <a href="/Supplier/manage_products/view/<?php // echo $encodedParamsInactiveS; ?>" class="text-primary d-inline-block">-->
                                                                <!--        <i class="ri-eye-fill fs-16"></i>-->
                                                                <!--    </a>-->
                                                                <!--</li>-->
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
                                                                    <a href="/Supplier/manage_products/edit/<?php echo $encodedParamsInactiveS; ?>"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $row['product_id']; ?>">
                                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>    
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
                                                         
                                                           
                                                        </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
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
          
        <script type="text/javascript">
        function sumitBulkOrder(){
            
             $("#bulkUpdateForm").submit();
            
        }
        $(document).ready(function(){
          let supplier_id = "<?php echo $supplier_id; ?>";
          let imported = "<?php echo $imported; ?>";
           localStorage.removeItem('suppId');
           localStorage.setItem('suppId', supplier_id);
           if(imported !=''){
            $('.alertImportSuccess').removeClass('d-none');
            setTimeout(function() {
            $('.alertImportSuccess').fadeOut();
            }, 3000);
           }
        })
        
      $('#customerTable').DataTable({
    "bLengthChange": false,
    "pageLength": 100,
    "order": [],
    "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
    "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false
    }]
});
            $(document).on("click", ".remove-item-btn" , function() {
                var id = $(this).attr('data-rel-id');
            
                    Swal.fire({
                      title: "Are you sure?",
                      icon: "warning",
                      showCancelButton: !0,
                      confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                      cancelButtonClass: "btn btn-danger w-xs mt-2",
                      confirmButtonText: "Yes, delete it!",
                      buttonsStyling: !1,
                      showCloseButton: !0,
                  }).then(function (e) {
                      if (e.value) {
                        $.ajax({
                            type: "POST",
                            url: "/Supplier/productDelete",
                            data:'id='+id,
                            success: function(data){
                               $(".alert-success").removeClass('d-none');
                              $('#row_'+id).remove();
                              
                            }
                        });
                      }
                  })
            });
            
            $(document).on("change", ".updateStatus" , function() {
                var id = $(this).attr('rel-id');
                let product_status = 0;
                if($(this).is(":checked")){
                     product_status = 1;
                }
                else{
                     product_status = 0;
                }
                    $.ajax({
                        type: "POST",
                        url: "/Supplier/productStatus",
                        data:'id='+id+'&product_status='+product_status,
                        success: function(data){
                        //   location.reload();
                        }
                    });
                
            });
            $(function() {
    // Make the table rows sortable
    $("#sortable").sortable({
      
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });

            $.ajax({
                url: "/Supplier/productUpdateSortOrder",
                type: "POST",
                data: { order: sortOrder },
                success: function(response) {
                    console.log("Order updated successfully");
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
        }
    });
    
});
            
          
        </script>
 