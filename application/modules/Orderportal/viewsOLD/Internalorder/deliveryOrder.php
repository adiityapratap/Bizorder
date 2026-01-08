<div class="main-content">
        <div class="page-content">
                <div class="container-fluid">
                
            <div class="row">
                 <h5 class="mb-3 text-black">Make Order  :  <?php echo date('l'); echo '  '.date('d M, Y');  ?></h5>  
                  <div class="col-lg-12">
                <div class="d-flex gap-3">    
                   <div class="info-box">
                <span class="info-box-icon bg-danger-subtle">
                </span>
                   <div class="info-box-content">
                     <span class="info-box-text">Quantity Updated</span>
                    </div>
                 </div>

                       </div>      
                            <div class="card mt-2">
                 <div class="card-body"> 
               <div class="table-responsive"> 
               <input type="text" id="searchInput" class="form-control mb-2 w-25" placeholder="Search Product">
                <table class="table table-nowrap align-middle table-responsive table-bordered" id="SupplierDataTable">
                   <thead class="text-muted table-light">
                     <tr class="text-uppercase">
                      <th class="sort" data-sort="Name">Product Name</th>
                     
                     <?php  if(isset($allInternalOrdersSubLocations) && !empty($allInternalOrdersSubLocations)) {  ?> 
                      <?php foreach($allInternalOrdersSubLocations as $allInternalOrdersSubLoc) {   ?>  
                      <th class="sort" data-sort="Name"><?php echo $allInternalOrdersSubLoc['name'] ?></th>
                       <?php } ?>
                    <?php } ?>
                      <th class="sort" data-sort="Status">Qty To Make</th>
                      <th class="sort" data-sort="Status">Attachment</th>
                      <th class="sort" data-sort="Status">Temperature</th>
                      <th class="sort" data-sort="Status">Action</th>
                      </tr>
                      </thead>
                      <tbody class="list form-check-all">
                     <?php  if(isset($allInternalOrders) && !empty($allInternalOrders)) { $productLoopedOn = array(); ?>      
                     <?php foreach($allInternalOrders as $loopType => $internalOrder) { 
                    $totalQtyToMake = 0;
                     if (!in_array($internalOrder['product_id'], $productLoopedOn)) {
                          array_push($productLoopedOn, $internalOrder['product_id']);
                          
                     ?>
                      <tr class="innerparemt ">
                       <td><?php echo $internalOrder['product_name']; ?></td>
                       <?php  if(isset($allInternalOrdersSubLocations) && !empty($allInternalOrdersSubLocations)) {  ?> 
                       
                      <?php 
                      foreach($allInternalOrdersSubLocations as $allInternalOrdersSubLoc) { 
                           
                       $filteredProductResult = array_filter($allInternalOrders, function($item) use ($internalOrder,$allInternalOrdersSubLoc) {
                         return $item['product_id'] == $internalOrder['product_id'] && $item['sublocation_id'] == $allInternalOrdersSubLoc['id'];
                        }); 
                        
                         if(isset($filteredProductResult) && !empty($filteredProductResult)) { 
                          $firstResult = reset($filteredProductResult);
                          
                          if(isset($firstResult['is_qtyUpdated']) && $firstResult['is_qtyUpdated']){
                           $classname ="bg-danger-subtle";   
                          }else{
                           $classname = '';   
                          }
                         $orderQTy= $firstResult['orderQty'];
                         
                        }else{
                         $orderQTy = '';
                         $classname = ''; 
                        }
                       $totalQtyToMake= $totalQtyToMake + $orderQTy; 
                        ?>
                      <td class="<?php echo $classname; ?>">
                      <?php  echo $orderQTy; ?>
                       </td>
                      <?php }  ?>
                      <?php } ?>
                      <td class="orderQty"><?php echo $totalQtyToMake; ?></td>
                     <?php if($internalOrder['requireAttach'] == 1) {  ?>
                    <td><i class="ri-attachment-2 align-bottom me-1 mx-3 fs-16 " style="color: red;" onclick="showAttachmentModal(<?php echo $internalOrder['order_id'] ?>,<?php echo $internalOrder['product_id'] ?>)"></i></td>
                    <?php } else {  ?>
                     <td> </td>
                    <?php }  ?>
                     <?php if($internalOrder['requireTemp'] == 1) {  ?>  
                    <td ><input type="number" class="form-control mt-2 foodOrderTemp w-75" name="foodOrderTemp" placeholder="Food temperature" value="<?php echo (isset($internalOrder['foodTemp']) ? $internalOrder['foodTemp'] : '') ?>" /></td>     
                      <?php } else {  ?>
                     <td> </td>
                    <?php }  ?>
                    <td >
                    <?php if($internalOrder['date_completed'] == date('Y-m-d')) { ?>
                  <button class="btn btn-success btn-sm " ><i class="bx bx-fork"></i> Completed</button>
                   <?php }else {  ?>
                 <button class="btn btn-orange btn-sm " onclick="markCompleted(this,<?php echo $internalOrder['order_id'] ?>,<?php echo $internalOrder['product_id'] ?>)"><i class="bx bx-bowl-rice"></i> Complete</button>
                  <?php  } ?>
                  
                  <?php if($internalOrder['is_delivered'] == 1) { ?>
                <button class="btn btn-success btn-sm " ><i class="bx bxs-truck"></i> Delivered</button>  
                   <?php }else {  ?>
                <button class="btn btn-orange btn-sm " onclick="markdelivered(this,<?php echo $internalOrder['order_id'] ?>,<?php echo $internalOrder['product_id'] ?>)"><i class="bx bxs-truck"></i> Deliver</button>   
                  <?php  } ?>
                  
                   </td> 
                      </tr>
                      
                     <?php }  ?>
                       <?php }  ?>
                      <?php }  ?>
                    </tbody>     
                   </table>
                </div>
                     </div>
                       </div>  
                          </div>   
                           </div>
                             </div>  
                               </div>  
                                 </div>  
         <div id="orderAttachmentInfoModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Attachments and Comments</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="attachmentUploadForm" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                     <div class="file-input-container">
                                                             <input type="file" id="userfile" name="userfile[]" class="form-control-file" multiple>
                                                        </div>
                                                        <input type="text" class="form-control mt-2" name="orderAttachmentComments" placeholder="Comments (Examples: any thing related to this product or order)" />
                                                       
                                                        <input type="hidden" id="orderId" name="orderId" value="">
                                                        <input type="hidden" id="product_id" name="product_id" value="">
                                                        </div>
                                                        </form>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-success uploadAttachmentButton">Upload</button>
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>                         
                                 <script>
function showAttachmentModal(id,product_id){
 $("#orderId").val(id);
 $("#product_id").val(product_id);
 $("#orderAttachmentInfoModal").modal('show');
}                     
function markCompleted(obj,orderId,productId){
             let foodTemp = '';
               
               let foodTempElement = $(obj).parents('.innerparemt').find('.foodOrderTemp');
                if (foodTempElement.length > 0) {
                 foodTemp = $(obj).parents('.innerparemt').find('.foodOrderTemp').val(); 
                if(foodTemp == ''){
                alert("Please enter food temperature before completing."); 
                return false;
                }
                 }
                 $(obj).html('<i class="bx bx-bowl-rice"></i> In Progress...');
               $(obj).removeClass('btn-orange').addClass('btn-success');
               
                $.ajax({
                url: "/Supplier/internalorder/markCompleted",
                type: "POST",
                data: { orderId: orderId,productId:productId,foodTemp:foodTemp },
                success: function(response) {
                  $(obj).html('<i class="bx bx-fork"></i> Completed');
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
            } 

function markdelivered(obj,orderId,productId){
             let foodTemp = '';
               $(obj).html('<i class="bx bx-bowl-rice"></i> In Progress...');
               $(obj).removeClass('btn-orange').addClass('btn-success');
               
               
                $.ajax({
                url: "/Supplier/internalorder/markdelivered",
                type: "POST",
                data: { orderId: orderId,productId:productId},
                success: function(response) {
                  $(obj).html('<i class="bx bxs-truck"></i> Delivered');
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
            }             
            
$(".uploadAttachmentButton").on("click", function () {
        var formData = new FormData($("#attachmentUploadForm")[0]);
        $(".uploadAttachmentButton").html("Loading...");
        // Debugging: Output FormData object to console
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "/Supplier/internalorder/uploadOrderAttachment", 
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#orderAttachmentInfoModal").modal('hide');
                $(".uploadAttachmentButton").html("Upload");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });    
    
    $(document).ready(function() {
        // Define function to handle filtering
        function filterProducts(searchText) {
            $('#SupplierDataTable tbody tr').each(function() {
                var productName = $(this).find('td:first-child').text().toLowerCase();
                if (productName.includes(searchText.toLowerCase())) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Add event listener to the search input
        $('#searchInput').on('input', function() {
            var searchText = $(this).val();
            filterProducts(searchText);
        });
    });
    
  </script>