<style>
  /* Define your regular styles here */
  .hidden-print {
    display: none; /* Hide elements with this class by default */
  }

  /* Define your print styles here */
  @media print {
    .visible-print {
      display: table-cell !important; /* Show elements with this class when printing */
    }
  }
</style>
<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                  
                   <form  action="/Supplier/internalorder/updateInternalOrder"  method="POST" id="updateInternalOrderForm"> 
                           <input type="hidden" name="order_id" class="order_id" value="<?php echo $order_id;  ?>">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">

                           <div class="row">
                            <div class="col-xxl-7 col-lg-8 col-md-12 col-sm-12">
                              
                            <div class="card mt-2">
                                
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">#<?php echo $order_id ?> Sub Location : <?php echo $subLocationName; ?> </h5>
                                        <div class="flex-shrink-0">
<a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                                
                               
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                   <table class="table table-nowrap align-middle" id="orderDatatable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th class="sort" data-sort="Name">Category Name</th>
                                                       <th class="sort" data-sort="Name">Product Name</th>
                                                       <th class="sort" data-sort="Name">UOM</th>
                                                         <th class="sort" data-sort="Name">Price</th>
                                                        <th class="sort hidden-print" data-sort="Status">Quantity</th>
                                                        <th class="sort visible-print" data-sort="Quantity">Quantity</th>
                                                        <th class="sort" data-sort="Name">Total</th>
                                                     
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                  <?php if(isset($internalOrderProducts) && !empty($internalOrderProducts)) {  ?>  
                                                 <?php foreach($internalOrderProducts as $product) {  ?> 
                                                 
                                                  <tr id="row_<?php echo  $product['id']; ?>" class="innerparemt">
                                                     <input type="hidden" name="productID[]" value="<?php echo  $product['id'].'_'.$product['price']; ?>">
                                                      <td class="name"><?php echo (isset($product['category_name']) ? $product['category_name'] : ''); ?></td>
                                                    <td class="name"><?php echo (isset($product['name']) ? $product['name'] : ''); ?></td>
                                                     <?php $key = array_search($product['uom'], array_column($uomLists, 'product_UOM_id'));  ?>
                                                     <td><?php echo ($key !== false) ? $uomLists[$key]['product_UOM_name'] : ""; ?></td>
                                                 
                                                    <td class="price"><?php echo (isset($product['price']) ? "$".$product['price'] : ''); ?></td>
                                                    <td ><input type="text" name="qtyToMake[]" class="form-control" value="<?php echo (isset($product['orderQty']) ? $product['orderQty'] :'') ?>" /></td>
                                                    <td class="d-none"><?php echo (isset($product['orderQty']) ? $product['orderQty'] :'') ?></td>
                                                    <td class="total"><?php echo (isset($product['price']) ? "$".$product['price']* $product['orderQty'] : ''); ?></td>
                                                  
                                                   
                                                  </tr>
                                                  
                                                  <?php }  } ?>
                                                    
                                                    
                                                    </tbody>
                                                    </table>
                                      </div>
                                        
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                         <div class="col-xxl-5 col-lg-4 col-md-12 col-sm-12">
                              <div class="card mt-2">
                                <div class="card-body">
                                    <div class="row">
                            <div class="col-lg-6 kitchenOptions">
                              <label for="name-field" class="form-label">Temperature</label> 
                            <input type="text" value="<?php echo $internalOrderData[0]['temp'] ?? ''; ?>" class="form-control" readonly="readonly">
                             </div>
                          <div class="col-lg-6 kitchenOptions">
                              <label for="name-field" class="form-label">Attachment</label> 
                             <?php $attachmentFiles = isset($internalOrderData[0]['attachment'])  ? unserialize($internalOrderData[0]['attachment'])  : '';?>
                             <?php if(!empty($attachmentFiles)){ ?>
                             <?php foreach($attachmentFiles as $attachmentFile) { ?>
        <a target="blank_" href='<?php echo base_url("uploaded_files/".$this->tenantIdentifier."/Supplier/InternalOrderAttachments/".$attachmentFile ?? ''); ?>' class="btn btn-sm btn-success">View</a>                     
                             <?php } ?>
                             <?php } ?>
                            
                        </div>      
                            <div class="col-lg-6 kitchenOptions">
                              <label for="name-field" class="form-label">Delivery Date</label> 
                            <input type="text" name="delivery_date" value="<?php echo date('d M, Y',strtotime($internalOrderData[0]['delivery_date'])); ?>" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d M, Y" placeholder="Select date" readonly="readonly">
                             </div> 
                             <div class="col-lg-6 kitchenOptions " >
                              <label for="name-field" class="form-label">Order Total</label>
                                <input type="text" value="<?php echo $internalOrderData[0]['order_total']; ?>" class="form-control">
                              </div>   
                              <div class="col-lg-12 kitchenOptions">
                              <label for="name-field" class="form-label">Driver Comments</label> 
                            <input type="text" value="<?php echo $internalOrderData[0]['driversComment'] ?? ''; ?>" class="form-control" readonly="readonly">
                             </div>
                              
        <div class="col-lg-12 kitchenOptions mt-3">  
         <button type="button" class="btn btn-success btn-label waves-effect waves-light updateOrderBtn" onclick="updateOrder()">Update Order</button> 
          </div>
                                 </div>
                                    
                          </div>
                           </div>
                            </div>
                          </div>
                            </div>
                        <!--end col-->

                      
                        <!--end col-->
                    </div>
                    </form>
                    
                    </div>
                     </div>
                      </div>
 <script>
 function updateOrder(){
     $(".updateOrderBtn").html("Updating...")
   $("#updateInternalOrderForm").submit();  
 }
 $(document).ready(function() {
 new DataTable("#orderDatatable", {
    pageLength: 100,
    dom: "Bfrtip",
    buttons: [
      { extend: "print", className: "btn btn-yellow" , title:'Internal Orders', text: "<i class='fas fa-print'></i> Print",
      exportOptions: {
           columns: ':visible'//Your Column value those you want
               }
      }
    ]
  });
});
</script>