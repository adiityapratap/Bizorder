<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;} 
@media(max-width: 567px){
.orderviewtable td{
    word-break: break-all;
    font-size: 12px;
  } 
   .orderviewtable th{
       font-size:14px;
   }
   button.btn, a.btn {
    margin-bottom: 3px;
}
}
</style>
<?php $is_customer = $this->session->userdata('is_customer'); ?>
<!-- header_End -->
<!-- Content_right -->
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1>Production</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Production
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<div class="row">
					<!--Report widget start-->
					<div class="col-12">
						<div class="card card-shadow mb-4">
							<div class="card-header">
								<p class="card-title">Actions</p>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
									   
										<button class="btn btn-warning" onclick="print_window(<?php echo $order_info->order_id;?>)">Print <i class="fa fa-print"></i></button>
										<button class="btn btn-warning" onclick="open_modal()">Send Invoice <i class="fa fa-send"></i></button>
										
										<?php if($order_info->order_status!=2){
											if(!is_null($order_info->coupon_id)){
												if($order_info->type=='F')
													$coupon_discount=$order_info->coupon_discount;
												else{
													$total_so_far=$order_info->order_total+$order_info->late_fee+$order_info->delivery_fee;
													$coupon_discount=($order_info->coupon_discount*($order_info->order_total+$order_info->late_fee+$order_info->delivery_fee))/100;
												}
											} else $coupon_discount=0;
											$amt=number_format($order_info->order_total+$order_info->late_fee+$order_info->delivery_fee-$coupon_discount,2, '.', '')*100;
										?>	
												<?php 
													if(isset($order_info->order_made_from) && $order_info->order_made_from=='frontend'){ 
													 $orders_identity = $order->order_made_from;
													}else{
													 $orders_identity = 'backend'; 
													}
														
														?>
											
											<a class="btn btn-warning" href="<?php echo base_url();?>index.php/orders/securepay_link/<?php echo $order_info->order_id ?>/<?php echo $orders_identity; ?>">Payment <i class="fa fa-credit-card"></i></a>
											<?php }?>
											<button class="btn btn-warning" onclick="open_modal_link()">Send Payment Link <i class="fa fa-send"></i></button>
											 <button class="btn btn-warning buttonContentFeedback" onclick="send_feedback_form(<?php echo $order_info->order_id; ?>)">Feedback Mail <i class="fa fa-send"></i></button>
										
										
										</div>
									</div>
								</div>
							</div>
							<div class="card card-shadow mb-4">
								<table class="table table-bordered orderviewtable" style="font-size:18px;">
									<thead>
										<tr>
										<th colspan="4" class="text-center bg-warning text-light"><?php if($order_info->order_status!=3) echo "Tax Invoice";else echo "Tax Invoice";?></th>
										</tr>
									</thead>
									<tr>
										<td colspan="2" width="50%">
											<strong class="mr-2">Order ID: </strong><?php echo $order_info->order_id;?><br>
											<strong class="mr-2">Delivery: </strong><?php echo date('g:i A, l - d M Y',strtotime($order_info->delivery_date_time));?><br>
                                        <?php if($order_info->approval_comments !=''){ ?>
							<strong class="mr-2">Approval Mail Comments: </strong><?php echo $order_info->approval_comments;?><br>
                             <?php }  ?>
										</td>
										<td colspan="2" width="50%">
											<strong class="mr-2">Name: </strong><?php echo $order_info->customer_order_name;?><br>
											<strong class="mr-2">Email: </strong><span id="customerOrderEmail"><?php echo $order_info->customer_order_email;?></span><br>
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
									    $PrdctExcludedFromGST_DeductItsPrice = 0;
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
														echo "<td colspan='4'>
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
										<!--td>$<?php //echo $subtotal;// number_format($order_info->order_total,2, '.', '');?></td-->
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
											$total_so_far=$order_info->order_total+$order_info->late_fee+$delivery_fee;
											$coupon_discount=($order_info->coupon_discount*($order_info->order_total+$order_info->late_fee+$delivery_fee))/100;
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
											    <td colspan="3" width="20%"><strong>GST (0%)</strong></td>
											    <td>$<?php echo number_format(0,2, '.', '');?></td>
											<?php } else{ ?>
											    <td colspan="3" width="20%"><strong>GST (10%)</strong></td>
											    <td>$<?php echo number_format(($order_info->order_total+$order_info->late_fee+$delivery_fee-$coupon_discount-$PrdctExcludedFromGST_DeductItsPrice)/11,2, '.', '');?></td>
											<?php } ?>
										</tr>
										<tr>
											<td width="70%">&nbsp;</td>
											<td colspan="3" width="20%"><strong>Total (Incl. GST)</strong></td>
											<td>$<?php echo number_format($order_info->order_total+$order_info->late_fee+$delivery_fee-$coupon_discount,2, '.', '');?></td>
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
					
								</div>
							</div>
							<!--Report widget end-->
						</div>
					</div>
					<!-- Section_End -->
				</div>
			</div>
		</div>
		<!-- Content_right_End -->
		
	<div class="modal fade" id="email_modal" tabindex="-1" role="dialog" aria-labelledby="email_modal_title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Send Invoice</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-auto">
							Please enter the email ID to send to:
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<input type="email" class="form-control" id="email"><div class="invalid-feedback">Please enter an email address!</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					<button type="button" onclick="send_mail()" class="btn btn-primary buttonContent">
						Send Mail
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="payment_link" tabindex="-1" role="dialog" aria-labelledby="email_modal_title" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Send payment link</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<div class="col-auto">
					 Please enter the email ID to send to:
					</div>
					</div>
					<div class="row">
						<div class="col-12">
							<input type="email" class="form-control" id="email_payment"><div class="invalid-feedback">Please enter an email address!</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					<button type="button" onclick="send_link()" class="btn btn-primary buttonContent">
						Send Mail
					</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function print_window(order_id)
		{
			window.open("<?php echo base_url();?>index.php/orders/print_order/"+order_id+"/<?php echo $fingerprint;?>/<?php echo $ofrom;?>");
		}
		function open_modal()
		{  
		     $("#email").val($("#customerOrderEmail").html())
			$("#email_modal").modal('show');
		}
		function send_mail()
		{
		   
		   
			$("#email").removeClass('is-invalid');
			if($.trim($("#email").val())=='')
			{
				$("#email").addClass('is-invalid');
				return 0;
			}else{
			    $(".buttonContent").html('<i class="fa fa-spinner fa-spin"></i>In progress...');
			}
			$.ajax({
				url:'<?php echo base_url();?>index.php/orders/send_email/<?php echo $order_info->order_id;?>/<?php echo $fingerprint;?>/<?php $f = $order_info->oc_order_id?$order_info->oc_order_id.'-1800INV':$order_info->order_id.'-1800HC'; echo $f;?>',
				method:"POST",
				data:{
					"email":$("#email").val(),
                     "customer_name":'<?php echo ($order_info->firstname == '' ? $order_info->customer_order_name : $order_info->firstname);?>'
				  },
				 complete:function(){
				 $(".buttonContent").html('Mail Sent');
				 $("#email_modal").modal('hide');
				}
			})
		}
		function open_modal_link()
		{
		    $("#email_payment").val($("#customerOrderEmail").html())
			$("#payment_link").modal('show');
		}
		function send_link()
		{   
		     
		     
			$("#email_payment").removeClass('is-invalid');
			if($.trim($("#email_payment").val())=='')
			{
				$("#email_payment").addClass('is-invalid');
				return 0;
			}else{
			    $(".buttonContent").html('<i class="fa fa-spinner fa-spin"></i>In progress...');
			}
			$.ajax({
				url:'<?php echo base_url();?>index.php/orders/send_link/<?php echo $order_info->order_id;?>/<?php echo str_replace(',','',number_format($order_info->order_total+$order_info->late_fee+$order_info->delivery_fee-$coupon_discount,2, '.', ''));?>',
				method:"POST",
				data:{"email_payment":$("#email_payment").val()},
				complete:function(){
				 $(".buttonContent").html('Mail Sent');
				 $("#payment_link").modal('hide');
				},
				
			})
		}
		function send_feedback_form(order_id){
		     $(".buttonContentFeedback").html('<i class="fa fa-spinner fa-spin"></i>In progress...');
    	$.ajax({
    		url:"<?php echo base_url();?>index.php/orders/send_feedback_form/",
    		method:"POST",
    		data: {"order_id":order_id},
    		success:function(data){
    			if(data=='sent'){
    				alert("Feedback mail sent for OrderId: "+order_id);
    				 $(".buttonContentFeedback").html(' Mail Sent <i class="fa fa-check"></i>');
    			}else{
    			    alert("Feedback mail not sent.");
    			}
    		}
    	});
    }
		</script>