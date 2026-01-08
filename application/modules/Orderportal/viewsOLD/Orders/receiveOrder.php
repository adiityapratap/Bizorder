<style>
        .kbw-signature { width: 350px; height: 150px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
<div class="main-content">
<div class="page-content">
<div class="container-fluid">
   
   <div class="alert alert-success shadow d-none" role="alert">
                       <strong> Success !</strong> Order Received succesfully .
                       </div>
                       <div class="alert alert-danger shadow mb-xl-0 d-none" role="alert">
                         <strong> Something went wrong! </strong> Please try after some time!
                         </div>
                        <div class="row d-flex align-items-stretch">
                            <?php if(isset($configData['showInvoice']) && $configData['showInvoice'] == 1 ) { 
                                $className = 'col-xl-7 col-lg-7';
                             }else{
                                 $className = 'col-xl-12 col-lg-12';
                             }
                             ?>
                            <div class="<?php echo $className; ?>">
                                <div class="card">
                                    <div class="card-header">
                                         <p><h5 class="text-black mx-4"><?php echo ucfirst($supplierName); ?></h5></p>
                                       <div class="d-flex align-items-center gap-2">
                                          
                                            <h5 class="card-title flex-grow-1 mb-0 text-black">P.O Number #<?php if(isset($orderData) && !empty($orderData)) { echo $orderData[0]['id']; $orderId = $orderData[0]['id']; }?></h5>
                                            <div class="flex-shrink-0">
                                              <a onclick="window.print()" class="btn btn-success"><i class="ri-printer-line align-middle me-1"></i>Print</a>
                                            </div>
                                            <div class="flex-shrink-0">
                                              <a  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class=" ri-add-line align-middle me-1"></i>Add Product</a>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table table-nowrap align-middle table-bordereless mb-0">
                                                <thead class="table-light text-white px-2">
                                                    <tr>
                                                      <th scope="col" class="text-white">Product Code</th>
                                                       <th scope="col" class="text-white">Product Name</th>
                                                      <th scope="col" class="text-white">Order Quantity</th>
                                                      <th scope="col" class="text-white">Product Check</th>
                                                      <th scope="col" class="text-white">Action</th>
                                                    </tr>
                                                  </thead>
                                                <tbody class="px-2">
                                                    <?php $count =1; if(isset($orderData) && !empty($orderData)) { ?>
                                                    <?php foreach($orderData as $orderInfo){  ?>
                                                    <?php $orderTotal = (isset($orderInfo['order_total']) ? $orderInfo['order_total'] : ''); ?>
                                                    
                                                    <?php $requireTC = (isset($orderInfo['requireTC']) ? $orderInfo['requireTC'] : ''); ?>
                                                    <?php $supplier_name = (isset($orderInfo['supplier_name']) ? $orderInfo['supplier_name'] : ''); ?>
                                                    <?php $supplier_id = (isset($orderInfo['supplier_id']) ? $orderInfo['supplier_id'] : ''); ?>
                                                     <?php $order_comments = (isset($orderInfo['order_comments']) ? $orderInfo['order_comments'] : ''); ?>
                                                     <?php $delivery_info = (isset($orderInfo['delivery_info']) ? $orderInfo['delivery_info'] : ''); ?> 
                                                      <?php $delivery_date = (isset($orderInfo['delivery_date']) ? date('d-m-Y',strtotime($orderInfo['delivery_date'])) : ''); ?>  
                                                   
                                                    <tr class="product_row_<?php echo $orderInfo['product_id'] ?> productNewRow">
                                                        <input type="hidden" class="orderId" value="<?php echo $orderId; ?>">
                                                        <td><?php echo $orderInfo['product_code']; ?></td>
                                                        <td><?php echo $orderInfo['product_name']; ?></td>
                                                        <td>
                                                       <div class="input-step step-success cartQtyChange">
                                                      <input class="itemUnitPrice" type="hidden" value="<?php echo $orderInfo['product_unit_price']; ?>">
                                                       <button type="button" class="minus shadow" onclick="addNewProductToOrder(this,'<?php echo $orderInfo['product_code']; ?>','<?php echo $orderInfo['product_name']; ?>','<?php echo $orderInfo['product_id']; ?>','<?php echo $orderInfo['product_unit_price']; ?>','minus')">–</button>
                                                       <input type="number" min="0" max="100000" class="product-quantity" name="orderQty_<?php echo $orderInfo['product_id']; ?>" value="<?php echo $orderInfo['qty']; ?>" oninput="addNewProductToOrder(this,'<?php echo $orderInfo['product_code']; ?>','<?php echo $orderInfo['product_name']; ?>','<?php echo $orderInfo['product_id']; ?>','<?php echo $orderInfo['price']; ?>')">
                                                       <button type="button" class="plus shadow" onclick="addNewProductToOrder(this,'<?php echo $orderInfo['product_code']; ?>','<?php echo $orderInfo['product_name']; ?>','<?php echo $orderInfo['product_id']; ?>','<?php echo $orderInfo['product_unit_price']; ?>','add')">+</button>
                                                       </div>     
                                                            
                                                            </td>
                                                        
                                                        <td>
                             <div class="form-check form-switch form-switch-success">
                            <input class="form-check-input updateStatus" type="checkbox" rel-id="<?php echo $orderInfo['product_id']; ?>" role="switch" id="is_unapprove_<?php echo $orderInfo['product_id']; ?>" <?php echo($orderInfo['is_approved'] == '1' ? 'checked' : '' ); ?>>
                           </div></td>
                           
                           <td>
                            <ul class="list-inline hstack gap-2 mb-0">
                              <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                <a class="text-danger d-inline-block remove-item-btn" onclick="deleteProduct(<?php echo $orderInfo['product_id']; ?>)" href="#deleteOrder">
                                <i class="ri-delete-bin-5-fill fs-16"></i> </a>
                                </li>
                            </ul>
                            </td>
                             </tr>
                                                  
                                                   <?php $count++; } } ?>
                                                   
                                                   <!-----------SUBTOTAL FOOTER START--------->
                                                  
                                                    <tr>
                                             </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        
                                       
                                  
				    	   <div class="row mt-3">
                  <h5 class="card-title flex-grow-1 mb-4 text-black mt-4">Receiving Details</h5>   
                   
				    		
				    		<?php if(isset($requireTC) && $requireTC == 1){ ?>
				    		<div class="col-md-3 col-lg-3 col-sm-6">
				    			<label for="temp_record" class="form-label">Temperature Recording <span style="color:red">*</span></label>
				    			<input type="number" class="form-control" id="temp_record" required="" value="">
				    		</div>
				    		<?php }  ?>
				    		
				    		
				    		
				    		<div class="col-md-3 col-lg-3 col-sm-6">
				    			<label for="date_created" class="form-label">Order Date </label>
				    			<input id="date_created" type="text" readonly class="form-control" value="<?php echo (isset($orderData[0]['date_created']) ? date('d-m-Y',strtotime($orderData[0]['date_created'])) : '') ?>">
				    		</div>
				    		
				    	 <div class="col-md-3 col-lg-3 col-sm-6">
				    			<label for="delivery_date" class="form-label">Delivery Date </label>
				    			<input type="text" id="delivery_date" readonly class="form-control" value="<?php echo (isset($orderData[0]['delivery_date']) ? date('d-m-Y',strtotime($orderData[0]['delivery_date'])) : '') ?>">
				    		</div>
				    		<div class="col-md-3 col-lg-3 col-sm-6">
				    		<div class="form-check form-switch form-switch-success mt-4">
				    		    <label for="paid_in_cash" class="form-label">Paid In Cash</label>
                            <input class="form-check-input" type="checkbox" id="paid_in_cash" role="switch"  <?php echo (isset($orderInfo[0]['paid_in_cash']) && $orderInfo[0]['paid_in_cash'] == '1' ? 'checked' : '' ); ?>>
                           </div>
				    		 </div>
				    		</div>
				    	
				    	<div class="row mt-4">
				    	   <?php if(isset($order_comments) && $order_comments !='') {  ?>
				      <div class="col-md-6 col-lg-6 col-sm-12">
				       <h6 class="card-title mb-0 text-black"><i class=" ri-message-3-fill me-4 align-middle me-1 text-black"></i>Order Comments</h6>	
				       <ul class="list-unstyled vstack gap-2 fs-13 mt-2">
                        <li class="fw-medium fs-14"><?php echo $order_comments; ?></li>
                        </ul>
				       </div>
				    <?php } ?>
				    <?php if(isset($orderData[0]['supplierComments']) && $orderData[0]['supplierComments'] !='') {  ?>	
				    	<div class="col-md-6 col-lg-6 col-sm-12">
				     <h6 class="card-title mb-0 text-black"><i class="ri-message-fill me-4 align-middle me-1 text-black"></i>Supplier Comments</h6>
				     <ul class="list-unstyled vstack gap-2 fs-13 mt-2">
                        <li class="fw-medium fs-14"><?php echo $orderData[0]['supplierComments']; ?></li>
                        </ul>
				     </div>
				     <?php } ?>
				    	</div>
				    	
				    	<div class="row mt-3">	
				    	<div class="col-md-5 col-lg-5 col-sm-12">
				    		<div class="form-check form-switch form-switch-success mt-4">
				    		    <label for="any_damaged_goods" class="form-label">Any Damaged Goods ?</label>
                            <input class="form-check-input" type="checkbox" id="any_damaged_goods" role="switch"  <?php echo (isset($orderInfo[0]['any_damaged_goods']) && $orderInfo[0]['any_damaged_goods'] == '1' ? 'checked' : '' ); ?>>
                           </div>
				    		 </div>	
				    		 
				    	 <div class="col-md-6 col-lg-6 col-sm-12">
				    			<label for="receiving_person" class="form-label">Receiving Person <span style="color:red">*</span></label>
				    			<input  type="text" class="form-control" id="receiving_person" required="" value="">
				    		</div>	 
				    	 
				    	 	
				    	 </div>
				    	 
				    <div class="row mt-3">	 
                        <div class="col-md-6 col-lg-6 col-sm-12">
				    	    
				    	  <?php  if(isset($orderData[0]['damaged_goods_attachment']) && $orderData[0]['damaged_goods_attachment'] !=''){   ?>  
									<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['damaged_goods_attachment'];?>" target="_blank">View File</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="damaged_goods_attachment" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['damaged_goods_attachment'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
									
									     <?php }else{ ?>   
                                          <form action="<?php echo base_url('/Supplier/Orders/uploadInvoice/damaged_goods_attachment/'.$orderId);?>" class="dropzone" id="myDropzone">
                                          <div class="dz-message needsclick fs-10">
                                          <div class="mb-3">
                                          <i class="display-4 text-black ri-upload-cloud-2-fill"></i>
                                          </div>
                                          <h6 class="text-black">Drop your images here or click to upload.</h6>
                                          </div>
                                           </form>
                                       <?php } ?>  
				    	    
				    	    
				    	</div>	
				    	
				    	<div class="col-md-6 col-lg-6 col-sm-12">
				       <label for="signature64" class="form-label">Receiving Person Signature</label>	    
				    	<div id="sig" ></div></br>
				    	<textarea id="signature64" name="receiver_sign" style="display: none"></textarea>
                         <button class="btn btn-sm btn-danger mt-3 clearSign"><i class=" ri-close-fill me-2 align-middle"></i>Clear Signature</button>
				    	</div>   
				    	</div>  
                     <div class="row mt-2 text-end">         
                           <a href="#" class="btn btn-success btn-md btnAfterAjax" onclick="receiveOrder()"><i class="ri-shopping-basket-line align-middle me-1"></i>Receive Order</a>
                                              <button type="button" class="btn btn-blue btn-load btnBeforeAjax">
                                                            <span class="d-flex align-items-center">
                                                                <span class="spinner-grow flex-shrink-0" role="status">
                                                                    <span class="visually-hidden">Saving...</span>
                                                                </span>
                                                                <span class="flex-grow-1 ms-2">
                                                                    Saving...
                                                                </span>
                                                            </span>
                                                        </button>    
                           </div>   
                              </div>
                                </div><!--end card-->
                             
                            </div>
                             <?php if(isset($configData['showInvoice']) && $configData['showInvoice'] == 1 ) { ?>
                              <div class="col-xl-5 col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        
                                       <div class="d-flex align-items-center">
                                            <h5 class="card-title flex-grow-1 mb-0 text-black">Invoices</h5>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                     <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#inv" role="tab" aria-selected="false">
                                                Invoice
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#inv1" role="tab" aria-selected="false">
                                                Invoice 1
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#inv2" role="tab" aria-selected="false">
                                                Invoice 2
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#inv3" role="tab" aria-selected="true">
                                                Invoice 3
                                            </a>
                                        </li>
                                    </ul>
                                      <div class="tab-content  text-black">
                                          
                                        <div class="tab-pane active" id="inv" role="tabpanel">
                                            
                                         <?php  if(isset($orderData[0]['invoice']) && $orderData[0]['invoice'] !=''){   ?>  
									<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php }else{ ?>   
									     
									     
                                          <form action="<?php echo base_url('/Supplier/Orders/uploadInvoice/invoice/'.$orderId);?>" class="dropzone dropzoneInv">
                                          <div class="dz-message needsclick">
                                          <div class="mb-3">
                                          <i class="display-4 text-black ri-upload-cloud-2-fill"></i>
                                          </div>
                                          <h4 class="text-black">Drop your images here or click to upload.</h4>
                                          </div>
                                           </form>
                                       <?php } ?>
                                            
                                        </div>
                                         <div class="tab-pane " id="inv1" role="tabpanel">
                                            
                                         <?php  if(isset($orderData[0]['invoice1']) && $orderData[0]['invoice1'] !=''){   ?>  
								<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice1'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice1" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice1'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice1'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php }else{ ?>   
                                          <form action="<?php echo base_url('/Supplier/Orders/uploadInvoice/invoice1/'.$orderId);?>" class="dropzone" id="myDropzone">
                                          <div class="dz-message needsclick">
                                          <div class="mb-3">
                                          <i class="display-4 text-black ri-upload-cloud-2-fill"></i>
                                          </div>
                                          <h4 class="text-black">Drop your images here or click to upload.</h4>
                                          </div>
                                           </form>
                                       <?php } ?>
                                            
                                        </div> 
                                         <div class="tab-pane" id="inv2" role="tabpanel">
                                            
                                         <?php  if(isset($orderData[0]['invoice2']) && $orderData[0]['invoice2'] !=''){   ?>  
									<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice2'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice2" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice2'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice2'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php }else{ ?>   
                                          <form action="<?php echo base_url('/Supplier/Orders/uploadInvoice/invoice2/'.$orderId);?>" class="dropzone" id="myDropzone">
                                          <div class="dz-message needsclick">
                                          <div class="mb-3">
                                          <i class="display-4 text-black ri-upload-cloud-2-fill"></i>
                                          </div>
                                          <h4 class="text-black">Drop your images here or click to upload.</h4>
                                          </div>
                                           </form>
                                       <?php } ?>
                                            
                                        </div>
                                         <div class="tab-pane" id="inv3" role="tabpanel">
                                            
                                 <?php  if(isset($orderData[0]['invoice3']) && $orderData[0]['invoice3'] !=''){   ?>  
								   <div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice3'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice3" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice3'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>	
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice3'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php }else{ ?>   
                                          <form action="<?php echo base_url('/Supplier/Orders/uploadInvoice/invoice3/'.$orderId);?>" class="dropzone" id="myDropzone">
                                          <div class="dz-message needsclick">
                                          <div class="mb-3">
                                          <i class="display-4 text-black ri-upload-cloud-2-fill"></i>
                                          </div>
                                          <h4 class="text-black">Drop your images here or click to upload.</h4>
                                          </div>
                                           </form>
                                       <?php } ?>
                                            
                                        </div>
                                        
                                         </div>
                                    </div>
                                </div>
                             
                            </div>
                            <?php }  ?>
                        </div><!--end row-->
                       
                       
                    </div>
                    </div>
                     </div>
                     
                      <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Add Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                               
                                                              <div class="table-responsive table-card mt-4">
                                        <table class="table table-bordered align-middle mb-0 customtable" id="newProductTable">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th  scope="col">Product Code</th>
                                                    <th  scope="col">Product Name</th>
                                                    <th scope="col" >Qty</th>
                                                    <th scope="col" ></th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody class="prdctWithZeroOrderQty">
                                           <?php if(isset($suppProducts) && !empty($suppProducts)) {  ?>
                                           <?php foreach($suppProducts as $suppProduct) { ?>
                                           <tr class="productNewRow">
                                           <td><?php echo $suppProduct['product_code']; ?></td>
                                           <td><?php echo $suppProduct['product_name']; ?></td>
                                           <td>
                                         <div class="input-step step-success cartQtyChange">
                                          <input class="itemUnitPrice" type="hidden" value="<?php echo $suppProduct['price']; ?>">
                                          <button type="button" class="minus shadow">–</button>
                                          <input type="number" min="0" max="100000" class="product-quantity" name="orderQty_<?php echo $suppProduct['product_id']; ?>" value="1" oninput="addNewProductToOrder(this,'<?php echo $suppProduct['product_code']; ?>','<?php echo $suppProduct['product_name']; ?>','<?php echo $suppProduct['product_id']; ?>','<?php echo $suppProduct['price']; ?>')">
                                           <button type="button" class="plus shadow">+</button>
                                           </div>      
                                           </td>
                                           <td>
 <a  class="btn btn-primary" href="#" onclick="addNewProductToOrder(this,'<?php echo $suppProduct['product_code']; ?>','<?php echo $suppProduct['product_name']; ?>','<?php echo $suppProduct['product_id']; ?>','<?php echo $suppProduct['price']; ?>')">
                                          <i class=" ri-shopping-basket-2-fill align-middle me-1"></i>+
                                          </a>
                                          </td>
                                           </tr>
                                           <?php } ?>
                                             <?php } ?>   
                                               
                                            </tbody>
                                            </table>
                                                                  </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                               
                                                            </div>
        
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->     
               
<script>

$(document).on('click', '.plus', function() {
    let input = $(this).parent().find('.product-quantity');
    let currentValue = parseInt(input.val());
    let currentQty = parseInt(input.val());
     input.val(currentValue + 1); 
    
    // let itemUnitPrice = $(this).parent().find('.itemUnitPrice').val(); 
    // let itemUpdatedPrice = itemUnitPrice * currentQty; 
   
    
});

$(document).on('click', '.minus', function() {
    var input = $(this).parent().find('.product-quantity');
    var currentValue = parseInt(input.val());
    input.value = currentValue;
     if (currentValue >= 1) {
        input.val(currentValue - 1);
    }
});

$(document).ready(function () {
          $(".btnBeforeAjax").hide();
     });
let approvedProducts = localStorage.getItem('approvedProducts') ? JSON.parse(localStorage.getItem('approvedProducts')) : [];

$(document).on("change", ".updateStatus" , function() {   
    let productId = $(this).attr('rel-id');
   
    if ($(this).prop('checked')) {
        if (approvedProducts.indexOf(productId) === -1) {
            approvedProducts.push(productId);
        }
    } else {
        approvedProducts = approvedProducts.filter(function(item) {
            return item !== productId;
        });
    }

    localStorage.setItem('approvedProducts', JSON.stringify(approvedProducts));
});

function getApprovedProducts() {
    return JSON.parse(localStorage.getItem('approvedProducts')) || [];
}
    function receiveOrder(){
         
      let orderId = $(".orderId").val();
      let temperature = $("#temp_record").val();
      let any_damaged_goods = $("#any_damaged_goods").prop('checked');
      let paid_in_cash = $("#paid_in_cash").prop('checked');
      let receiving_person = $("#receiving_person").val();
      let receiver_sign = sig.signature('toDataURL');
     
      if((temperature && temperature.length > 0 && temperature =='') || receiving_person == ''){
          alert("Please enter required fields before receiving order");
          return false;
      }
      
      let updatedApprovedProducts = getApprovedProducts();
    
      
       $(".btnBeforeAjax").show();
        $(".btnAfterAjax").hide(); 
            $.ajax({
                url: '/Supplier/Orders/receiveOrder',
                type: 'POST',
                data: { 
                    order_id: orderId,
                    temp: temperature,
                    any_damaged_goods: any_damaged_goods,
                    paid_in_cash: paid_in_cash,
                    receiving_person: receiving_person,
                    updatedApprovedProducts:JSON.stringify(updatedApprovedProducts),
                    receiver_sign: receiver_sign
                    
                },
                success: function(response) {
                    $(".btnBeforeAjax").hide();$(".btnAfterAjax").show();
                    $(".alert-success").removeClass('d-none');
                    localStorage.removeItem('approvedProducts');
                    window.location.href = '/Supplier/<?php echo $this->session->userdata('system_id'); ?>';
                }
            });
}

 var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('.clearSign').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
    
//   Dropzone.autoDiscover = false; // To prevent Dropzone from automatically discovering the dropzone elements on the page
// for more info see cafeadmin supplier receiver order page Js

    var dropzone = document.querySelectorAll('.dropzone');
      // Loop through each element and initialize Dropzone
      dropzone.forEach(function(element) {
       new Dropzone(element, {
        // Your Dropzone configuration options go here
        maxFilesize: 5, // MB
        acceptedFiles: 'image/*',
        dictDefaultMessage: 'Drop your images here or click to upload',
        success: function(file, response) {
            location.reload();
        }
       });
     });

    
    
    
    	function delete_row(el,orderId,fileName){
	   
	    let invoiceType = $(el).attr("data-filename"); 
	     console.log(invoiceType);
       if(confirm('Are you sure you   want to delete file')){
	      $.ajax({
				type: "POST",
		    	url: '/Supplier/Orders/deleteInvoice',
				data: {order_id: orderId, invoiceType: invoiceType,fileName:fileName},
				success: function(data){
					location.reload();
					
				}
			});   
}	
	}
	
	function deleteProduct(product_id){
	    let orderId = $(".orderId").val();
	    if(confirm('Are you sure you   want to delete this product')){
	      $.ajax({
				type: "POST",
		    	url: '/Supplier/Orders/deleteOrderProduct',
				data: {order_id: orderId, product_id: product_id},
				success: function(data){
				    $(".product_row_"+product_id).remove();
					
				}
			});   
}	
	}
	
	function addNewProductToOrder(obj,code,name,product_id,price,addOrMinus=''){
	    let orderId = $(".orderId").val();
	    
	    let input = $(obj).parents(".productNewRow").find('.product-quantity');
        let product_qty = parseInt(input.val());
        if(addOrMinus !=''){
	    $(obj).html('..');
	    if(addOrMinus == 'add'){
	    product_qty = product_qty + 1;    
	    }else{
	     product_qty = product_qty - 1;    
	    }
	   
	    }else{
	     $(obj).html('Adding....');
	    }
	    $.ajax({
				type: "POST",
		    	url: '/Supplier/Orders/addNewProductToOrder',
				data: {order_id: orderId, product_id: product_id, product_price: price,product_name: name,product_code: code,product_qty: product_qty},
				success: function(data){
				 location.reload();	
				}
			});  
	}
</script>
              
          