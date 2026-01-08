<div class="main-content">
<div class="page-content">
<div class="container-fluid">
   
  
                        <div class="row">
                            <div class="col-xl-8 col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                       <div class="d-flex align-items-center">
                                            <h6 class="card-title flex-grow-1 mb-0 text-black">Purchase Order Number #<?php if(isset($orderId) ) { echo $orderId; }?></h6>
                                            <h6 class="card-title flex-grow-1 mb-0 text-black">Supplier Name  : <?php echo  (isset($orderData[0]['supplier_name']) ? $orderData[0]['supplier_name'] : ''); ?></h6>
                                            <div class="flex-shrink-0">
                                             <a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>    
                                                <a onclick="window.print()" class="btn btn-success"><i class="ri-printer-line align-middle me-1"></i>Print</a>
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
                                                      <?php $delivery_date = (isset($orderInfo['delivery_date']) && $orderInfo['delivery_date'] !='0000-00-00' ? date('d-m-Y',strtotime($orderInfo['delivery_date'])) : ''); ?>  
                                                   
                                                    <tr class="product_row_<?php echo $orderInfo['product_id'] ?>">
                                                        <input type="hidden" class="orderId" value="<?php echo $orderId; ?>">
                                                        <td><?php echo $orderInfo['product_code']; ?></td>
                                                        <td><?php echo $orderInfo['product_name']; ?></td>
                                                        <td>
                                                       <div class="input-step step-success cartQtyChange">
                                                       <input class="itemUnitPrice" type="hidden" value="<?php echo $orderInfo['product_unit_price']; ?>">
                                                       <button type="button" class="minus shadow">–</button>
                                                       <input type="number" min="0" max="100000" class="product-quantity" name="orderQty_<?php echo $orderInfo['product_id']; ?>" value="<?php echo $orderInfo['qty']; ?>">
                                                       <button type="button" class="plus shadow">+</button>
                                                       </div>     
                                                            
                                                    </td>
                                                        
                                                    <td>
                             <div class="form-check form-switch form-switch-success">
                            <input class="form-check-input updateStatus" type="checkbox" rel-id="<?php echo $orderInfo['product_id']; ?>" role="switch" id="is_unapprove_<?php echo $orderInfo['product_id']; ?>" <?php echo($orderInfo['is_approved'] == '1' ? 'checked' : '' ); ?>>
                           </div></td>
                           
                          
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
				    			<input type="number" readonly class="form-control" id="temp_record" required="" value="<?php echo (isset($orderData[0]['temp']) ? $orderData[0]['temp'] : '');?>">
				    		</div>
				    		<?php }  ?>
				    		
				    		
				    		
				    		<div class="col-md-3 col-lg-3 col-sm-6">
				    			<label for="temp_record" class="form-label">Order Date </label>
				    			<input type="text" readonly class="form-control" value="<?php echo (isset($orderData[0]['date_created']) ? date('d-m-Y',strtotime($orderData[0]['date_created'])) : '') ?>">
				    		</div>
				    		
				    	 <div class="col-md-3 col-lg-3 col-sm-6">
				    			<label for="temp_record" class="form-label">Delivery Date </label>
				    			<input type="text" readonly class="form-control" value="<?php echo (isset($orderData[0]['delivery_date']) ? date('d-m-Y',strtotime($orderData[0]['delivery_date'])) : '') ?>">
				    		</div>
				    		<div class="col-md-3 col-lg-3 col-sm-6">
				    		<div class="form-check form-switch form-switch-success mt-4">
				    		    <label for="paid_in_cash" class="form-label">Paid In Cash</label>
                            <input class="form-check-input updateStatus" type="checkbox" id="paid_in_cash" role="switch"  <?php echo (isset($orderData[0]['paid_in_cash']) && $orderData[0]['paid_in_cash'] == '1' ? 'checked' : '' ); ?>>
                           </div>
				    		 </div>
				    		</div>
				    	
				    
				    	<div class="row mt-3">	
				    	<div class="col-md-5 col-lg-5 col-sm-12">
				    		<div class="form-check form-switch form-switch-success mt-4">
				    		 <label for="any_damaged_goods" class="form-label">Any Damaged Goods ?</label> 
                            <input class="form-check-input updateStatus" type="checkbox" id="any_damaged_goods" role="switch"  <?php echo (isset($orderData[0]['any_damaged_goods']) && $orderData[0]['any_damaged_goods'] == '1' ? 'checked' : '' ); ?>>
                           </div>
				    		 </div>	
				    	<div class="col-md-6 col-lg-6 col-sm-12">
				    	    
				    	  <?php  if(isset($orderData[0]['damaged_goods_attachment']) && $orderData[0]['damaged_goods_attachment'] !=''){   ?>  
									<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['damaged_goods_attachment'];?>" target="_blank">View damaged goods attachment</a>
								   </div>
							<?php } ?>   
                             	</div>	 
				    	 	
				    	 </div>
				    	 
				    <div class="row mt-3">	 
                         <div class="col-md-6 col-lg-6 col-sm-12">
				    			<label for="temp_record" class="form-label">Receiving Person <span style="color:red">*</span></label>
				    			<input type="text" readonly class="form-control" id="receiving_person" required="" value="<?php echo (isset($orderData[0]['receiving_person']) ? $orderData[0]['receiving_person'] : '');?>">
				    		</div>
				    	
				    	<div class="col-md-6 col-lg-6 col-sm-12 mt-4">
				       <?php  if(isset($orderData[0]['receiver_sign']) && $orderData[0]['receiver_sign'] !=''){   ?>  
					    <div class="d-flex gap-2 mb-2 mt-2" >
						 <a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Orders/<?php echo $orderData[0]['receiver_sign'];?>" target="_blank">View Signature</a>
						 </div>
					  <?php } ?>
				    	</div>   
				    	</div>  
                                    </div>
                                </div><!--end card-->
                             
                            </div><!--end col-->
                            <div class="col-xl-4 col-lg-4">
                              
                                
                                <div class="card">
                                    <div class="card-header">
                                       <div class="d-flex">
                                            <h5 class="card-title flex-grow-1 mb-0 text-black">Customer Details</h5>
                                           
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0 vstack gap-3">
                                            <li>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="/theme-assets/images/users/user-dummy-img.jpg" alt="" class="avatar-sm rounded shadow">
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                       <h6 class="fs-14 text-black">Delivery Date : <?php echo $delivery_date; ?></h6>
                                                      
                                                    </div>
                                                </div>
                                            </li>
                                             
    <li><i class="ri-mail-line me-2 align-middle text-black fs-16"></i><b>Email :</b> <?php echo (isset($configData['email']) ? $configData['email']: '') ; ?></li>
    <li><i class="ri-phone-line me-2 align-middle text-black fs-16"></i><b>Phone : </b><?php echo (isset($configData['phone']) ? $configData['phone']: ''); ?></li>
                                        </ul>
                                    </div>
                                </div><!--end card-->
                                <?php if(isset($order_comments) && $order_comments !='') {  ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0 text-black"><i class="ri-message-3-fill me-4 align-middle me-1 text-black"></i>Order Comments</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                            <li class="fw-medium fs-14"><?php echo $order_comments; ?></li>
                                           
                                        </ul>
                                    </div>
                                </div>
                                <?php } ?>
                    <?php if(isset($orderData[0]['supplierComments']) && $orderData[0]['supplierComments'] !='') {  ?>	
				    	<div class="card">
				       <div class="card-header">
                      <h5 class="card-title mb-0 text-black"><i class="ri-message-fill me-4 align-middle me-1 text-black"></i>Supplier Comments</h5>
                       </div>
                    <div class="card-body">    
				     <ul class="list-unstyled vstack gap-2 fs-13 mt-2">
                        <li class="fw-medium fs-14"><?php echo $orderData[0]['supplierComments']; ?></li>
                     </ul>
				</div>
				</div>     
				     <?php } ?>
				     
                     <?php if(isset($delivery_info) && $delivery_info !='') {  ?>
                     <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0 text-black"><i class="ri-message-fill me-4 align-middle me-1 text-black"></i>Delivery Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                            <li class="fw-medium fs-14"><?php echo $delivery_info; ?></li>
                                        </ul>
                                    </div>
                                </div>
                    <?php } ?>
                    
                    <?php if(isset($configData['showInvoice']) && $configData['showInvoice'] == 1 ) { ?>
                            
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
									     <?php }  ?>

                                        </div>
                                         <div class="tab-pane " id="inv1" role="tabpanel">
                                            
                                         <?php  if(isset($orderData[0]['invoice1']) && $orderData[0]['invoice1'] !=''){   ?>  
								<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice1'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice1" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice1'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice1'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php } ?>
                                            
                                        </div> 
                                         <div class="tab-pane" id="inv2" role="tabpanel">
                                            
                                         <?php  if(isset($orderData[0]['invoice2']) && $orderData[0]['invoice2'] !=''){   ?>  
									<div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice2'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice2" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice2'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice2'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php } ?>
                                            
                                        </div>
                               <div class="tab-pane" id="inv3" role="tabpanel">
                                 <?php  if(isset($orderData[0]['invoice3']) && $orderData[0]['invoice3'] !=''){   ?>  
								   <div class="d-flex gap-2 mb-2 mt-2" >
									<a  class="btn btn-sm btn-success" href="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice3'];?>" target="_blank">View Invoice</a>
									<a type="button" class="btn btn-sm btn-danger" data-filename="invoice3" onClick="delete_row(this,'<?php echo  $orderId ?>','<?php echo $orderData[0]['invoice3'];?>');"><i class="ri-close-fill mt-2"></i> Delete</a>
								   </div>	
										<embed src="<?php echo base_url();?>uploaded_files/<?php echo $tenantIdentifier ?>/Supplier/Invoices/<?php echo $orderData[0]['invoice3'];?>" style="width:100%;min-height:400px;" alt="image1" class="upload-file">
									     <?php } ?>
                                        </div>
                                         </div>
                                    </div>
                                </div>
                             
                           
                            <?php }  ?>
                                 
                               

                              
                            </div><!--end col-->
                        </div><!--end row-->
                       
                    </div><!-- container-fluid -->
</div>  
</div>
<script>

    
</script>
              
          