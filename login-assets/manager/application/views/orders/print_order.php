
<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;} 

@media print {
    .hiddenbtn{
      display: none;
    }
    
}
@media(max-width: 567px){
.orderviewtable td{
    word-break: break-all;
    font-size: 12px;
  } 
   .orderviewtable th{
       font-size:14px;
   }
   button.btn,a.btn {
    margin-bottom: 3px;
}
}
</style>
<!-- header_End -->
<!-- Content_right -->
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- Section -->
			<div class="container-fluid">
			        <div class="row hiddenbtn"><div class="col-md-12">	
			        <button onclick="printContent('<?php echo $order_info->order_id;?>','<?php echo $order_info->customer_id;?>','')" class="btn" style="margin-left: 14px;background-color:black !important;border:1px solid black;float:right;">
			            <font color="#fff">Download Invoice PDF </font>
			            </button>
			            <?php if(isset($user_id) && $user_id != '') {  ?>
			            <button onclick="printContent('<?php echo $order_info->order_id;?>','<?php echo $order_info->customer_id;?>','creditnote')" class="btn" style="margin-left: 14px;background-color:black !important;border:1px solid black;float:right;">
			            <font color="#fff">Download Credit Note </font>
			            </button>
			            <?php } ?>
			            <button class="btn" style="margin-left: 614px;background-color:black !important;border:1px solid black;float:right;" onclick="window.print()"><font color="#fff">Print Invoice</font></button>
                  </div></div>
				<div class="row" id="div1">
					<!--Report widget start-->
					<div class="col-12">
						<div class="card card-shadow mb-4">
							<table class="table table-bordered orderviewtable">
								<thead>
									<tr>
										<th colspan="4" class="text-center bg-warning text-light"><?php if($order_info->order_status!=3) echo "Tax Invoice";else echo "Tax Invoice";?></th>
									</tr>
								</thead>
								<tr>
									<td colspan="2" width="50%">
										<strong class="mr-2">Order ID: </strong>#<?php echo $order_info->order_id;?><br>
										<strong class="mr-2">Delivery: </strong><?php echo date("h:i A, d M Y",strtotime($order_info->delivery_date_time));?>
									</td>
										<td colspan="2" width="50%">
											<strong class="mr-2">Name: </strong><?php echo $order_info->customer_order_name;?><br>
											<strong class="mr-2">Email: </strong><?php echo $order_info->customer_order_email;?><br>
												<?php if(isset($order_info->accounts_email) && $order_info->accounts_email !='') {  ?>
											<strong class="mr-2">Account Email: </strong><?php echo $order_info->accounts_email;?><br>
											<?php  } ?>
											<strong class="mr-2">Phone: </strong>
											<?php if(isset($order_info->customer_order_telephone) && $order_info->customer_order_telephone !='') {
											    $phone = $order_info->customer_order_telephone;
											    echo $order_info->customer_order_telephone;
											}
											?><br><hr>
											<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info->pickup_delivery_notes;?><br>
											<strong class="mr-2">Delivery Contact: </strong>
											<?php if(isset($order_info->delivery_phone) && $order_info->delivery_phone !='') {
											    $phone = $order_info->delivery_phone;
											echo $order_info->delivery_phone;
											}
											?><br>
											<strong class="mr-2">Shipping Method: </strong><?php echo $order_info->shipping_method==1?"Delivery":"Pickup";?>
										</td>
								</tr>
							<thead>
										<tr>
											<?php if ($order_info->company_name === ''): ?>
											<th colspan="2" width="50%">Company Information</th>
											<th colspan="2" width="50%">Delivery/Pickup Address</th>
											<?php endif; ?>
										   <th colspan="2" width="50%">Company Information</th>
											<th colspan="2" width="50%">Delivery/Pickup Address</th>
										</tr>
									</thead>
									<tr>
										<td colspan="2">
									
											<?php echo $order_info->customer_company_name?><br>
											<?php echo $order_info->customer_company_addr;?>
									
										</td>
										<td colspan="2">
										   <?php if(is_null($order_info->delivery_address)) echo $order_info->company_address; else echo nl2br($order_info->delivery_address);?><br>
											<?php if(!empty($order_info->postcode)) {echo $order_info->postcode.'<br>';}?>
											<?php if(!is_null($phone)) echo "<i class=\"fa fa-phone\"></i> ".$phone;?>
										</td>
									</tr>
								</table>
								<table class="table table-bordered table-sm table-responsive">
									<thead>
										<tr class="bg-warning text-light">
											<th>Product Name</th>
											<th>Product Comment</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<?php
									
								

									if(!empty($order_products)){
									    $PrdctExcludedFromGST_DeductItsPrice =0;
										foreach($order_products as $product){
										    
											$product=(array)$product;
											
											if(!empty($product['heading'])&&$product['heading']!=$header)
											
											
												echo "<tr><td colspan=\"4\"><strong>".$product['heading']."</strong></td></tr>";
												
											echo "<tr>";
											
											echo "<td width=\"50%\">".$product['product_name']."<br>";
											
											echo nl2br($product['product_description']);
											
											echo "<ul>";
											
											for($i=1;$i<=5;$i++){
											    
												if(!empty($product['product_desc_'.$i])){
												    
													echo "<li>".nl2br($product['product_desc_'.$i])."</li>";
												}
											}
											echo "</ul>";
											
											echo "</td>";
											
											echo "<td width=\"20%\">".$product['order_product_comment']."</td>";
											
									    	if(!empty($product['options']) || $product['price'] > 0){
											echo "<td width=\"10%\">".$product['quantity']."</td>";
									    	}else{
											    if($product['quantity'] > 0){
											  	echo "<td width=\"10%\">".$product['quantity']."</td>";  
											    }else{
											         echo "<td width=\"10%\"></td>";
											    }
											    
											}
											
											$num1 = $product['quantity'];
											
											$num2 = number_format($product['price'],2, '.', '');
											
											
											$total = $num1 * $num2;
												if($product['exclude_GST'] ==1){
											   $PrdctExcludedFromGST_DeductItsPrice +=  $total;
											}
											
											
											if(!empty($product['options'])){
											    
											    
											    $prices = 0;
											    $tot = 0;
											    	foreach($product['options'] as $optt){
											    	    
											    	    $prices   +=  $optt->option_price;
											    	     $tot +=       ($optt->option_price*$optt->option_quantity);   
											    	    
											    	}
											    
											    
											    
											    
											    
											echo "<td width=\"10%\">$".number_format($prices,2, '.', '')."</td>";
											echo "<td width=\"10%\">$".number_format($tot,2, '.', '')."</td>";
											    
											    
											    
											}else if($product['price'] > 0){
											    
											  echo "<td width=\"10%\">$".number_format($product['price'],2, '.', '')."</td>";
											echo "<td width=\"10%\">$".number_format($total,2, '.', '')."</td>";  
											}else{
											    
											    echo "<td width=\"10%\"></td>";
											  echo "<td width=\"10%\"></td>";
											}
											
											
											echo "</tr>";
											if(!empty($product['options'])){
												foreach($product['options'] as $opo){
												    
													//if($product['order_product_id']==$opo->order_product_id)
													{
													    
														echo "<tr>";
														echo "<td colspan='5'>
														<table width='100%' border='0'>
														<tr>
														    <td width='20%'>Option: <br> Value: <br> Quantity:  <br> Price:  <br> Total: </td>
														    <td>".$opo->option_value."<br>
														    ".$opo->option_name."<br>
														    ".$opo->option_quantity."<br>
														    $".number_format($opo->option_price,2, '.', '')."<br>
														    $".number_format($opo->option_total,2, '.', '')."<br></td>
														    
														</tr>
														</table>
														</td>";
														//echo "<td>".$opo->option_quantity."</td>";
														//echo "<td>".$opo->option_price_prefix." $".number_format((float)$opo->option_price,2, '.', '')."</td>";
													//	echo "<td>".$opo->option_price_prefix." $".number_format($opo->option_quantity*(float)($opo->option_price_prefix.$opo->option_price),2, '.', '')."</td>";
														echo "</tr>";
													}
											      //  echo "order_product_id".$product['order_product_id'].'==opo order_product_id'.$opo->order_product_id.'<br>';
												}
											}
											$header=$product['heading'];
										}
									}?>
									<thead>
										<tr class="bg-warning text-light">
											<th colspan="5">Comments</th>
										</tr>
									</thead>
									<tr>
										<td colspan="5"><?php echo trim($order_info->order_comments)==''?"&nbsp;":$order_info->order_comments;?></td>
									</tr>
									<tr>
										<td width="70%">&nbsp;</td>
										<td colspan="3" width="20%"><strong>Subtotal (Incl. GST)</strong></td>
										<td>$<?php echo number_format($order_info->order_total,2, '.', '');?></td>
									</tr>
									<tr>
										<td width="70%">&nbsp;</td>
										<td colspan="3" width="20%"><strong>Delivery Charges</strong></td>
											<?php $delivery_fee = $order_info->delivery_fee; ?>
										<td>$<?php echo number_format($order_info->delivery_fee,2, '.', '');?></td>
									</tr>
										<?php if(isset($order_info->late_fee) && $order_info->late_fee !=0){ ?>
									<tr>
										<td width="70%">&nbsp;</td>
										<td colspan="3" width="20%"><strong>Late Fee</strong></td>
										<td>$<?php echo number_format($order_info->late_fee,2, '.', '');?></td>
									</tr>
									<?php } ?>
									<?php if(!is_null($order_info->coupon_id)){
										if($order_info->type=='F')
											$coupon_discount=$order_info->coupon_discount;
										else{
											$total_so_far=$order_info->order_total+$order_info->late_fee+$order_info->delivery_fee;
											$coupon_discount=($order_info->coupon_discount*($order_info->order_total+$order_info->late_fee+$order_info->delivery_fee))/100;
										}
										?>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Coupon Discount</strong></td>
											<td>$<?php echo number_format($coupon_discount,2, '.', '');?></td>
										</tr>
										<?php } else $coupon_discount=0;?>
											<tr>
											<td width="70%">&nbsp;</td>
											
												<?php // if($order_info->order_id == 11826 || $order_info->order_id == 11758 || $order_info->order_id == 11701 || $order_info->order_id == 11628 || $order_info->order_id == 11557 || $order_info->order_id == 10536 ){ ?>
                                                <!--one means gst removed for the order-->
											    <?php if($order_info->GST_status == 1){ ?>
												    <td colspan="3" width="20%"><strong>GST (0%)</td>
												    <td>$<?php echo number_format(0,2, '.', '');?></td>
												<?php }else{ ?>
												    <td colspan="3" width="20%"><strong>GST (10%)</td>
												    <td>$<?php echo number_format(($order_info->order_total-$PrdctExcludedFromGST_DeductItsPrice+$order_info->late_fee+$order_info->delivery_fee-$coupon_discount)/11,2, '.', '');?></td>
											    <?php } ?>
											</tr>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Total (Incl. GST)</strong></td>
											<td>$<?php echo number_format($order_info->order_total+$order_info->late_fee+$order_info->delivery_fee-$coupon_discount,2, '.', '');?></td>
										</tr>
									
											
										<?php if($order_info->order_status==2){?>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Amount Paid</strong></td>
											<td>$<?php echo number_format($order_info->order_total+$order_info->late_fee+$delivery_fee-$coupon_discount,2, '.', '');?></td>
										</tr>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Balance Due</strong></td>
											<td>$0.00</td>
										</tr>
										<?php }?>
										</table>
										<table class="table table-sm mt-3">
											<tr class="bg-warning text-light">
												<td width="50%">
												
													</table>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<!--Report widget end-->
							</div>
						</div>
						<!-- Section_End -->
					</div>
				</div>
			</div>
		</div>
		<script>
			function print_window(order_id)
			{
				window.open("<?php echo base_url();?>index.php/orders/print_order/"+order_id+"/"+<?php echo "'".(isset($fingerprint)? $fingerprint : '')."'";?>);
			}
			
		function printContent(order_id,cust_id,invType){   
							    
		 	window.open("<?php echo base_url();?>index.php/orders/order_inv_download/"+order_id+"/"+ cust_id + "/"+ invType);
				
				    }
               
		</script>
		<style>
		    @media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
		</style>