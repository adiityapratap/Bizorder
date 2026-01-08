<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Internal Orders </h5>
                                        <div class="flex-shrink-0">
 
                                        </div>
                                    </div>
                                </div>
                                 <div class="card-body pt-0">
                                   
                        <div class="row">
                     <form id="orderFilterForm" action="/Supplier/internalorder/history" method="POST">     
                     <input type="hidden" name="sublocationId" id="subLocId">
                        <div class="row">
                    <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                      <label class="form-label mb-0 fw-semibold">Delivery Date From</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y" id="from_delivery_date"   name="date_from"   placeholder="Select date" readonly="readonly">         
                    </div>
                    
                      <div class="col-md-3 col-lg-2 col-sm-6 mt-2 ">
                      <label class="form-label mb-0 fw-semibold">Delivery Date To</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y"  id="to_delivery_date"  name="date_to"   placeholder="Select date" readonly="readonly">         
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-3 mt-4">
                     <button type="button" class="btn btn-success" onclick="submitFilterForm()">
                     <i class=" ri-filter-2-line align-bottom me-1"></i> Filter
                      </button>
                       </div>
                    </div>
                      </form>
                      </div><!--end row-->
                          <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <?php  if(isset($locationLists) && !empty($locationLists)) { $count = 1; ?>
                            <?php foreach($locationLists as $locationList) {  $classActive = ($count == 1 ? 'active' : ''); ?>
                            <li class="nav-item">
                            <a class="nav-link py-3 <?php echo $classActive; ?>" data-bs-toggle="tab" href="#Tab<?php echo $locationList['id'];  ?>" role="tab" aria-selected="false">
                            <i class="ri-checkbox-circle-line me-1 align-bottom"></i> <?php echo $locationList['name'];  ?>
                            </a>
                            </li>
                        <?php $count++; }  ?>
                        <?php }  ?>
                         </ul>    
                                 <div class="tab-content mb-1">
                                  <?php  if(isset($orders) && !empty($orders)) { $countD = 1; ?>
                                  <?php foreach($orders as $subLocationIdAndName => $orderData) {  $classActiveShow = ($countD == 1 ? 'active show' : ''); ?>   
<?php $subLocationIdName = explode("_", $subLocationIdAndName); $subLocationId =  (isset($subLocationIdName[0]) ? $subLocationIdName[0] : '');  $subLocationName =  (isset($subLocationIdName[1]) ? $subLocationIdName[1] : ''); ?>
                                 <div class="tab-pane <?php echo $classActiveShow ?> table-responsive" role="tabpanel"  id="Tab<?php echo $subLocationId;  ?>">
                                
                                <table class="table table-nowrap align-middle table-responsive orderDatatable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th class="sort" data-sort="total">Location Name</th>
                                                        <th class="sort" data-sort="order_id">Order number</th>
                                                        <th class="sort" data-sort="Order_date">Order date</th>
                                                        <th class="sort" data-sort="Delivery_date">Delivery date</th>
                                                        <th class="sort" data-sort="total">Order total</th>
                                                        
                                                        <!--<th class="sort" data-sort="Status">Status</th>-->
                                                        <th class="sort actionCol hidden" data-sort="action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                      <?php if(isset($orderData) && !empty($orderData)) {  ?>
                                                        <?php foreach($orderData as $order){  ?>
                                                      
                                                    <tr id="row_<?php echo  $order['id']; ?>">
                                                  <td class="status"><?php echo $subLocationName; ?></td> 
                                                   <td class="id"><?php echo (isset($order['id']) ? $order['id'] : ''); ?></td>
                                                  <td class="date_added"><?php echo (isset($order['date_added']) ? date('d-m-Y',strtoTime($order['date_added'])) : ''); ?></td>
                                                  <td class="delivery_date"><?php echo (isset($order['delivery_date']) ? date('d-m-Y',strtoTime($order['delivery_date'])) : ''); ?></td>
                                                 
                                                 <td class="order_total"><?php echo (isset($order['order_total']) ? "$".$order['order_total'] : ''); ?></td>
                                                 
                                                 <!--<td class="status"><?php echo (isset($order['status']) ? $order['status'] : ''); ?></td>-->
                                                        <td class="actionCol hidden">
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"  data-bs-placement="top" title="Edit">
<a  class="text-success" href="/Supplier/internalorder/editInternalOrder/<?php echo $order['id'] ?>/<?php echo $subLocationName; ?>"   class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $order['id']; ?>">
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
                                <?php $countD++; }  ?>
                                 <?php }  ?>
                                 
                                   </div>
                                    </div>
                                   </div>
                                  </div>
                                   </div>
                                    </div>
                                     </div>
                                      </div>
                                      
                                     
                                          
         <script type="text/javascript">
     
       
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
                            url: "/Supplier/internalorder/deleteOrder",
                            data: {"id":id},
                            success: function(data){
                               
                             $('#row_'+id).remove();
                              
                            }
                        });
                      }
                  })
            });
            
$(document).ready(function() {
    
    new DataTable(".orderDatatable", {
    columnDefs: [{ orderable: true, targets: [4] }],
    pageLength: 100,
    order: [[1, 'desc']],    
    dom: "Bfrtip",
    buttons: [
      { extend: "excel", className: "btn btn-success", text: "<i class='fas fa-file-excel'></i> Excel" },
      { extend: "print", className: "btn btn-yellow" , title:'Internal Orders', text: "<i class='fas fa-print'></i> Print",
      exportOptions: {
           columns: [ 0, 1, 2, 3, 4 ] //Your Column value those you want
               }
      }
    ]
  });
  
  let from_delivery_date = localStorage.getItem('Weekly_from_delivery_date'); 
  if(typeof from_delivery_date != undefined || from_delivery_date != undefined){
    $("#from_delivery_date").val(from_delivery_date)  
  }
  let to_delivery_date = localStorage.getItem('Weekly_to_delivery_date');
  
  if(typeof to_delivery_date != undefined || to_delivery_date != undefined){
    $("#to_delivery_date").val(to_delivery_date)  
  }
});

function submitFilterForm(){
       localStorage.setItem('Weekly_from_delivery_date', $("#from_delivery_date").val());
     localStorage.setItem('Weekly_to_delivery_date', $("#to_delivery_date").val());
     let activeHref = $('.nav-link.active').attr('href');
     let subLocationId = activeHref.replace(/\D/g, '');
     $("#subLocId").val(subLocationId);
     $("#orderFilterForm").submit();
 }

</script>
        </script>                                        
                                
                                