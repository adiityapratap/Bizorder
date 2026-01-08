<style>
.customBudgetInput{
    height: 38px;
    font-weight: 500;
    font-family: Inter,sans-serif;
    font-size: 1.421875rem;   
}
</style>
<div class="main-content">

            <div class="page-content">
              
                <div class="container-fluid">
                   
                     <div class="row">
                           <div class="col-lg-6 align-items-center" style="text-align: left;">
                   <h4 class="flex-grow-1 text-black">Manage Suppliers</h4>
                      </div>
                        <div class="col-lg-6 flex-shrink-0 mb-3" style="text-align: right;">
                         <a href="/Supplier/manage_supplier/add/new" class="btn btn-primary add-btn"><i id="create-btn" class="ri-add-line align-bottom me-1"></i> Add  Supplier</a>
                         </div>
                           
                            
                           
                           
                       
                    
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                
                                <div class="card-body pt-0">
                                    <div>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Delivered active" data-bs-toggle="tab"
                                                    href="#activeSuppliersTab" role="tab" aria-selected="false">
                                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Active
                                                </a>
                                            </li>
                                           
                                           
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" 
                                                    href="#inActiveSuppliersTab" role="tab" aria-selected="false">
                                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Inactive
                                                </a>
                                            </li>
                                        </ul>
                                       <div class="tab-content mb-1">
                                        <div class="tab-pane   active show table-responsive" role="tabpanel"  id="activeSuppliersTab">
                                            <table class="table table-nowrap align-middle" id="SupplierDataTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" style="width: 25px;">
                                                            Top 5
                                                        </th>
                                                       <th class="sort" data-sort="customer_name">Main Cat</th>
                                                        <th class="sort" data-sort="customer_name">Supplier Name</th>
                                                        <th class="sort" data-sort="customer_name">Category</th>
                                                        <th class="sort" data-sort="date">Budget Type</th>
                                                        <th class="sort" data-sort="amount">Weekly Budget</th>
                                                        <th class="sort" data-sort="payment">Monthly Budget</th>
                                                        <th class="sort" data-sort="payment">Products</th>
                                                        <th class="sort" data-sort="city">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all" id="sortable">
                                                     <?php if(!empty($suppliers_list)) { ?>
                                                        <?php foreach($suppliers_list as $suppliers){   ?>
                                                    <tr id="row_<?php echo  $suppliers['supplier_id']; ?>" class="parentRow">
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input topFiveCheckbox" type="checkbox" value="<?php echo  $suppliers['supplier_id']; ?>" <?php echo (isset($suppliers['isTopFive']) && $suppliers['isTopFive'] == 1 ? 'checked' : '') ?>>
                                                            </div>
                                                        </th>
                                                       <td class="main_category_name"><?php echo (isset($suppliers['main_category_name']) ? $suppliers['main_category_name'] : ''); ?></td>
                                                        <td class="supplier_name"><?php echo (isset($suppliers['supplier_name']) ? $suppliers['supplier_name'] : ''); ?></td>
                                                        <td class="category_name"><?php echo (isset($suppliers['supplier_category_name']) ? $suppliers['supplier_category_name'] : ''); ?></td>
                                                        <td class="budget_type"><?php echo (isset($suppliers['budget_type']) ? ucfirst($suppliers['budget_type']) : ''); ?></td>
                                                        <td class="weeklybudget">
                                                        <?php echo '$'.((isset($suppliers['weekly_budget']) ? $suppliers['weekly_budget'] : '')); ?>
                                                        </td>
                                                     <td class="monthlybudget">
                                                       <?php echo '$'.((isset($suppliers['monthly_budget']) ? $suppliers['monthly_budget'] : '')); ?>
                                                        </td>    
                                                        <td class="items">
                                                    <?php
                                                    $paramsToEncrypt = $suppliers['supplier_id'] . '|' . $suppliers['supplier_name'].'|'.$suppliers['requirePL'];
                                                    $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                                                   
                                                    $encodedParams = urlencode(urlencode(urlencode($encryptedParams)));
                                                    ?>        
                                                        <a href="/Supplier/supplier_item/<?php echo $encodedParams; ?>" class="link-success link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover">
                                                             Products  
                                                                    </a>
                                                        </td>
                                                        
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
                                                                  <!--<a href="/Supplier/manage_supplier/view/<?php // echo $suppliers['supplier_id']; ?>" class="text-primary d-inline-block">-->
                                                                  <!--      <i class="ri-eye-fill fs-16"></i>-->
                                                                  <!--  </a>/    -->
                                                                    <a class="text-success" href="/Supplier/manage_supplier/edit/<?php echo $suppliers['supplier_id']; ?>"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $suppliers['supplier_id']; ?>">
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
                                        <div class="tab-pane table-responsive" role="tabpanel"  id="inActiveSuppliersTab">
                                            <table class="table table-nowrap align-middle" id="SupplierInactiveDataTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" style="width: 25px;">
                                                           
                                                        </th>
                                                       
                                                        <th class="sort" data-sort="customer_name">Supplier Name</th>
                                                        <th class="sort" data-sort="customer_name">Supplier Category</th>
                                                        <th class="sort" data-sort="date">Budget Type</th>
                                                        <th class="sort" data-sort="amount">Weekly Budget</th>
                                                        <th class="sort" data-sort="payment">Monthly Budget</th>
                                                        <th class="sort" data-sort="payment">Products</th>
                                                        <th class="sort" data-sort="city">Action</th>
                                                </thead>
                                                 <tbody class="list form-check-all" id="sortable">
                                                     <?php if(!empty($inActiveSuppliers_list)) { ?>
                                                        <?php foreach($inActiveSuppliers_list as $inactiveSuppliers){  ?>
                                                    <tr id="row_<?php echo  $inactiveSuppliers['supplier_id']; ?>" class="parentRow">
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" >
                                                            </div>
                                                        </th>
                                                       
                                                        <td class="supplier_name"><?php echo (isset($inactiveSuppliers['supplier_name']) ? $inactiveSuppliers['supplier_name'] : ''); ?></td>
                                                         <td class="category_name"><?php echo (isset($inactiveSuppliers['supplier_category_name']) ? $inactiveSuppliers['supplier_category_name'] : ''); ?></td>
                                                        <td class="budget_type"><?php echo (isset($inactiveSuppliers['budget_type']) ? ucfirst($inactiveSuppliers['budget_type']) : ''); ?></td>
                                                        <td class="weeklybudget">
                                                        <?php echo ((isset($inactiveSuppliers['weekly_budget']) ? $inactiveSuppliers['weekly_budget'] : '')); ?>
                                                        </td>
                                                     <td class="monthlybudget">
                                                       <?php echo ((isset($inactiveSuppliers['monthly_budget']) ? $inactiveSuppliers['monthly_budget'] : '')); ?>
                                                        </td>    
                                                        <td class="items">
                                                    <?php
                                                    $paramsToEncrypt = $inactiveSuppliers['supplier_id'] . '|' . $inactiveSuppliers['supplier_name'].'|'.$inactiveSuppliers['requirePL'];
                                                    $encryptedParams = $this->encryption->encrypt($paramsToEncrypt);
                                                   
                                                    $encodedParams = urlencode(urlencode(urlencode($encryptedParams)));
                                                    ?>        
                                                        <a href="/Supplier/supplier_item/<?php echo $encodedParams; ?>" class="link-success link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover">
                                                             Products  
                                                                    </a>
                                                        </td>
                                                        
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
                                                                  <!--<a href="/Supplier/manage_supplier/view/<?php // echo $suppliers['supplier_id']; ?>" class="text-primary d-inline-block">-->
                                                                  <!--      <i class="ri-eye-fill fs-16"></i>-->
                                                                  <!--  </a>/    -->
                                                                    <a class="text-success" href="/Supplier/manage_supplier/edit/<?php echo $inactiveSuppliers['supplier_id']; ?>"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $inactiveSuppliers['supplier_id']; ?>">
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
                                 

                                    <!-- Modal -->
                                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4>You are about to delete a order ?</h4>
                                                        <p class="text-muted fs-15 mb-4">Deleting your order will remove
                                                            all of
                                                            your information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->
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
      

</body>
<script>
     function sumitBulkOrder(){
            
             $("#supplierBudgetForm").submit();
            
        }
       $(document).ready(function() {
            $('.monthly_budget').on('input', function() {
                let monthlyBudgetValue = $(this).val();
                let weeklyBudgetValue = monthlyBudgetValue/4;
                $(this).parents(".parentRow").find(".weekly_budget").val(weeklyBudgetValue);
                calculateAllocatedTotal();
            });
            
            $('.weekly_budget').on('input', function() {
                let weeklyBudgetValue = $(this).val();
                let monthlyBudgetValue = weeklyBudgetValue*4;
                $(this).parents(".parentRow").find(".monthly_budget").val(monthlyBudgetValue);
                calculateAllocatedTotal();
            });
            
           
            
          $(".topFiveCheckbox").on('change', function () {
         let countOftopFive = $('.topFiveCheckbox:checked').length;
    
         if (countOftopFive > 5) {
          alert("Maximum number is five.");
          $(this).prop('checked', false); // Uncheck the checkbox
          return false;
         }

         let suppId = $(this).val();
         let status = $(this).prop('checked') ? 1 : 0; // Set status based on checkbox state

        $.ajax({
        type: "POST",
        url: "/Supplier/markTopFive",
        data: { suppId: suppId, status: status },
        success: function (data) {
            // Handle success
        }
       });
     });

        });
        
         
        
           function calculateAllocatedTotal(){
    
                let newexistingWeeklyAllocatedValue = 0;
                 $('.weekly_budget').each(function() {
                  newexistingWeeklyAllocatedValue += parseFloat($(this).val()) || 0;
                 });
                let newWeeklyAllocatedValue = newexistingWeeklyAllocatedValue;
                let newMonthlyAllocatedValue = (newWeeklyAllocatedValue*4);
                $(".counter-valueWeekly").attr("data-target", newWeeklyAllocatedValue).text(newWeeklyAllocatedValue);
                $(".counter-valueWeekly").val(newWeeklyAllocatedValue);
                $(".counter-valueMonthly").attr("data-target", newMonthlyAllocatedValue).text(newMonthlyAllocatedValue);
                $(".counter-valueMonthly").val(newMonthlyAllocatedValue);
       }        
        
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
                            url: "/Supplier/SupplierDelete",
                            data:'id='+id,
                            success: function(data){
                                Swal.fire({
                                      title: "Deleted!",
                                      icon: "success",
                                      showCancelButton: !1,
                                      confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                                      cancelButtonClass: "btn btn-danger w-xs mt-2",
                                      buttonsStyling: !1,
                                      showCloseButton: !0,
                                });
                              $('#row_'+id).remove();
                            }
                        });
                        
                    
                          
                      }
                  })
                
                
            });
$('#SupplierDataTable').DataTable({
                "bLengthChange":false,
                "pageLength": 100,
                "order": [],
                "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
$('#SupplierInactiveDataTable').DataTable({
                "bLengthChange":false,
                pageLength: 100,
                lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
 $(function() {
    // Make the table rows sortable
    $("#sortable").sortable({
      
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });

            $.ajax({
                url: "/Supplier/supplierUpdateSortOrder",
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
</html>