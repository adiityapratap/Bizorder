<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;} </style>
<!-- header_End -->
<!-- Content_right -->
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- Section -->
			<div class="container-fluid">
			
				<div class="row mt-5" >

					<!--Report widget start-->
					<div class="col-12" >

						<div class="card card-shadow mb-4 col-12">
							<div class="card-body">
								<div class="row">
<!--								<div<button onclick="printContent('<?php echo $order_info->order_id;?>','<?php echo $order_info->customer_id;?>')" class="btn" style="margin-left: 1080px;background-color:#CCBADC !important;border:1px solid white;float:right;">Download Invoice Pdf </button>-->
<!--</div>-->
									<div class="col-12">

										<?php if($order_info->order_status==4){?>
										<form id="approval_form" method="post">
											<label>Comments</label>
											<textarea name="approval_comments" class="form-control" placeholder="If you see anything that needs to be changed in the order, please make a note here. The manager handling the order will make the required changes."></textarea>
											<input type="hidden" name="order_id" value="<?php echo $order_info->order_id; ?>">
											<input  type="hidden" name="status_name" id="status_name" value="">
											<button class="btn btn-warning mt-2 submit" type="submit" id="approve">Approve <i class="fa fa-rocket"></i></button>
											<button class="btn btn-warning mt-2 submit" type="submit" id="reject">Reject <i class="fa fa-rocket"></i></button>
											<button class="btn btn-warning mt-2 submit" type="submit" id="modify">Modify the Order <i class="fa fa-rocket"></i></button>
											</form>
										
											
										<?php } else if($order_info->order_status==7){?>
											Your order has been approved, and will be updated soon.
										<?php } else if($order_info->order_status==8){?>
											Thank you, this quote has been rejected.
										<?php } else if($order_info->order_status==9){ ?>
										Thank you for your comments, one of our managers will get back to you shortly with the modified quote.
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="card card-shadow mb-4 col-12" id="div1">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th colspan="4" class="text-center bg-warning text-light"><?php if($order_info->order_status!=3) echo "QUOTE";else echo "Tax Invoice";?></th>
									</tr>
								</thead>
								<tr>
									<td colspan="2" width="50%">
										<strong class="mr-2">Order ID: </strong>#<?php echo $order_info->order_id; ?><br>
										<strong class="mr-2">Delivery: </strong><?php echo date("h:i A, d M Y",strtotime($order_info->delivery_date_time));?>
									</td>
									<td colspan="2" width="50%">
										<strong class="mr-2">Name: </strong><?php echo $order_info->customer_order_name;?><br>
										<strong class="mr-2">Email: </strong><?php echo $order_info->customer_order_email;?><br>
											<?php if(isset($order_info->accounts_email) && $order_info->accounts_email !='') {  ?>
											<strong class="mr-2">Account Email: </strong><?php echo $order_info->accounts_email;?><br>
											<?php  } ?>
										<strong class="mr-2">Phone: </strong><?php echo $order_info->customer_order_telephone;?><br><hr>
										<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info->pickup_delivery_notes;?><br>
										<strong class="mr-2">Delivery Contact: </strong><?php echo (isset($order_info->delivery_phone) ? $order_info->delivery_phone : '');?><br><hr>
										<strong class="mr-2">Shipping Method: </strong><?php echo $order_info->shipping_method==1?"Delivery":"Pickup";?>
									</td>
								</tr>
								<thead>
									<tr>
										<th colspan="2" width="50%">Company Information</th>
										<th colspan="2" width="50%">Delivery/Pickup Location</th>
									</tr>
								</thead>
								<tr>
									<td colspan="2">
										<?php echo $order_info->customer_company_name?><br>
										<?php echo $order_info->customer_company_addr;?>
									</td>
									<td colspan="2">
									
										<?php if(is_null($order_info->delivery_address)) echo $order_info->company_address; else echo nl2br($order_info->delivery_address);?><br>
									</td>
								</tr>
							</table>
							<div class="table-responsive">
							<table class="table table-bordered table-sm">
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
									    
										foreach($order_products as $product){
										    
											$product=(array)$product;
											
								// 			if(!empty($product['heading'])&&$product['heading']!=$header)
											
											
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
											echo "<td width=\"10%\">".$product['quantity']."</td>";
											
											$num1 = $product['quantity'];
											
											$num2 = number_format($product['price'],2, '.', '');
											
											
											$total = $num1 * $num2;
											
											
											
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
									
								</table>
								</div>
								<div class="table-responsive">
							<table class="table table-bordered table-sm">
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
										<td colspan="3" width="20%"><strong>Subtotal</strong></td>
									<td>$<?php echo number_format($order_info->order_total,2, '.', '');?></td>
								</tr>
								<tr>
									<td width="70%">&nbsp;</td>
										<td colspan="3" width="20%"><strong>Delivery Charges</strong></td>
									<td>$<?php echo number_format($order_info->delivery_fee,2, '.', '');?></td>
								</tr>
								<?php if(!is_null($order_info->coupon_id)){
									if($order_info->type=='F')
										$coupon_discount=$order_info->coupon_discount;
									else{
										$total_so_far=$order_info->order_total+$order_info->delivery_fee;
										$coupon_discount=($order_info->coupon_discount*($order_info->order_total+$order_info->delivery_fee))/100;
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
										<td colspan="3" width="20%"><strong>GST (10%)</td>
										<td>$<?php echo number_format(($order_info->order_total+$order_info->delivery_fee-$coupon_discount)/11,2, '.', '');?></td>
								    </tr>
									<tr>
										<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Total (Incl. GST)</strong></td>
										<td>$<?php echo number_format($order_info->order_total+$order_info->delivery_fee-$coupon_discount,2, '.', '');?></td>
									</tr>
									
											
										<?php if($order_info->order_status==3){?>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Amount Paid</strong></td>
											<td>$<?php echo number_format($order_info->order_total+$delivery_fee-$coupon_discount,2, '.', '');?></td>
										</tr>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Balance Due</strong></td>
											<td>$0.00</td>
										</tr>
										<?php }?>
										</table>
										</div>
										<table class="table table-sm mt-3">
											<tr class="bg-warning text-light">
												<td width="50%">
													<table class="borderless bg-warning">
														<!--<tr>
															<td class="text-right"><strong>Account Name:</strong></td>
															<td>Hoscat Pty Ltd</td>
														</tr>
														<tr>
														<td class="text-right"><strong>BSB:</strong></td>
														<td>033 157</td>
														</tr>
														<tr>
														<td class="text-right"><strong>Account Number:</strong></td>
														<td>538 432</td>
														</tr>
														<tr>
														<td class="text-right"><strong>Reference:</strong></td>
														<td>&lt;Company Name&gt; &lt;Order Id&gt;</td>
														</tr>
														<tr>
														<td class="text-right"><strong>Payment Terms:</strong></td>
														<td>Please Pay within 7 days</td>
														</tr>-->
<!--<tr><td><strong>Company Name: </strong></td><td><?php echo $company_name; ?></td></tr><tr><td><strong>ABN</strong></td><td><?php echo $abn; ?></td></tr>-->
</table>
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
		
		$(".submit").on('click',function(){
		
	var method_name = $(this).attr('id');
	var link = "<?php echo base_url();?>index.php/orders/approve";
	$("#approval_form").attr('action',link);
	$("#status_name").val(method_name);
	$("#approval_form").submit() 
		    
		});
			function print_window(order_id)
			{
				window.open("<?php echo base_url();?>index.php/orders/print_order/"+order_id+"/"+<?php echo "'".$fingerprint."'";?>);
			}
							function printContent(order_id,cust_id){   
							    
							   	window.open("<?php echo base_url();?>index.php/orders/order_inv_download/"+order_id+"/"+ cust_id + "/"+ <?php echo "'".$fingerprint."'";?>);
							    
							    
				    // var restorepage = document.body.innerHTML;    
				    // var printcontent = document.getElementById(el).innerHTML;    
				    // document.body.innerHTML = printcontent;   
				    // var curURL = window.location.href;
        //             history.replaceState(history.state, '', '/');
				    // window.print();
				    // history.replaceState(history.state, '', curURL);
				    //document.body.innerHTML = restorepage;   
				    }
               
			</script>
			
			<style>
		    @media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
		</style>
