<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;} .table-bordered .delivery_info_labels{
    font-weight:600 !important;
}</style>
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
							<h1>Orders</h1>
						</div>
					</div>
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
							view
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
										<button class="btn btn-warning" onclick="print_window(<?php echo $order_info[0]->order_id;?>)">Print <i class="fa fa-print"></i></button>
										<button class="btn btn-warning" onclick="open_modal()">Send Invoice <i class="fa fa-send"></i></button>
										<?php if($order_info[0]->order_status!=2){
											$coupon_discount = 0;
											$amt=number_format($order_info[0]->total+(isset($order_info[0]->delivery_fee) ? $order_info[0]->delivery_fee : 0)-$coupon_discount,2, '.', '')*100;
										?>
										
											<?php $orders_identity = "frontend";	?>
											
											<?php }?>
									<a class="btn btn-warning" href="<?php echo base_url();?>index.php/orders/securepay_link/<?php echo $order_info[0]->order_id ?>/<?php echo $orders_identity; ?>">Payment <i class="fa fa-credit-card"></i></a>

											<button class="btn btn-warning" onclick="open_modal_link()">Send Payment Link <i class="fa fa-send"></i></button>
											<button class="btn btn-warning buttonContentFeedback" onclick="send_feedback_form(<?php echo $order_info[0]->order_id; ?>)">Feedback Mail <i class="fa fa-send"></i></button>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-shadow mb-4">
								<table class="table table-bordered" style="font-size:18px;">
									<thead>
										<tr>
										<th colspan="4" class="text-center bg-warning text-light"><?php if($order_info[0]->order_status!=2) echo "Tax Invoice";else echo "Tax Invoice";?></th>
										</tr>
									</thead>
									<tr>
										<td colspan="2" width="50%">
											<strong class="mr-2">Order ID: </strong><?php echo $order_info[0]->order_id;?><br>
											<strong class="mr-2">Delivery: </strong><?php echo date('g:i A, l - d M Y',strtotime($order_info[0]->delivery_date));?><br>
											<strong class="mr-2">Name: </strong><?php echo $order_info[0]->firstname." ".$order_info[0]->lastname;?><br>
											<strong class="mr-2">Email: </strong><span id="customerOrderEmail"><?php echo $order_info[0]->email;?></span><br>
											<strong class="mr-2">Phone: </strong><?php echo $order_info[0]->telephone;?><br>
										</td>
										<td colspan="2" width="50%">
										<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info[0]->comment;?><br>
										<?php
										if($order_info[0]->shipping_method == 'Pickup'){
										    $text = 'Pick Up/Delivery Inside the Premises';
										}else{
										  $text   = $order_info[0]->shipping_method;
										}
										?>
										<strong class="mr-2">Shipping Method: </strong><?php echo $text; ?></br>
									<strong class="mr-2">Delivery/Pickup Location: </strong>	
										<?php 
											if($order_info[0]->shipping_method == 'Delivery'){
											   $addr = $order_info[0]->shipping_address_1.','.$order_info[0]->shipping_address_2.' '.$order_info[0]->shipping_city.','.$order_info[0]->shipping_postcode;
											}else if($order_info[0]->shipping_method == 'pickup.pickup' || $order_info[0]->shipping_method == 'delivery.delivery'){
											  $addr = $order_info[0]->shipping_address_1;
											}else{
											   $addr = $order_info[0]->shipping_address_1;
											}
											$addDetails = '';
											($order_info[0]->shipping_gate_number != '' ? $addDetails .= '<span class="delivery_info_labels">Gate no : </span>'.$order_info[0]->shipping_gate_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_building_number != '' ? $addDetails .= '<span class="delivery_info_labels">Building number : </span>'.$order_info[0]->shipping_building_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_department_name != '' ? $addDetails .= '<span class="delivery_info_labels">Department name: </span>'.$order_info[0]->shipping_department_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_level_of_building != '' ? $addDetails .= '<span class="delivery_info_labels">Level of building : </span>'.$order_info[0]->shipping_level_of_building.'</br>' : '</br>');
										    ($order_info[0]->shipping_room_number != '' ? $addDetails .= '<span class="delivery_info_labels">Room number : </span>'.$order_info[0]->shipping_room_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_business_name != '' ? $addDetails .= '<span class="delivery_info_labels">Business name :</span> '.$order_info[0]->shipping_business_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_street_number != '' ? $addDetails .= '<span class="delivery_info_labels">Street number : </span>'.$order_info[0]->shipping_street_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_delivery_contact_name != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact name :</span> '.$order_info[0]->shipping_delivery_contact_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_delivery_contact_number != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact number : </span>'.$order_info[0]->shipping_delivery_contact_number.'</br>' : '</br>');
										    ($order_info[0]->account_number != '' ? $addDetails .= '<span class="delivery_info_labels">Account Number : </span>'.$order_info[0]->account_number.'</br>' : '</br>');

											
											?>
											<?php  echo $addr;?><br>
											<?php  echo $addDetails;?>
										</td>
									</tr>
								
									
								</table>
								<table class="table table-bordered table-sm">
									<thead>
										<tr class="bg-warning text-light">
											<th>Product Name</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<?php 
$subtotal=0;
									if(!empty($order_products)){
									   //  echo "<pre>";
									   //  print_r($order_products);
									   //  exit;
								
										foreach($order_products as $product){
									
							
								        
												echo "<tr><td colspan=\"4\"></td></tr>";
											echo "<tr>";
											echo "<td width=\"70%\">".$product['name']."<br>";
							                 echo htmlspecialchars_decode(stripslashes($product['descr'][0]['description'])); 
											
								// 			echo "<ul>";
								// 			for($i=1;$i<=5;$i++){
								// 				if(!empty($product['descr'][0]['desc_'.$i])){
								// 					echo "<li>".nl2br($product['descr'][0]['desc_'.$i])."</li>";
								// 				}
								// 			}
								// 			echo "</ul>";
										
											echo "</td>";
											
	if(isset($product['addons']) && $product['addons'] == 'Yes' ){											    
											     echo "<td width=\"10%\">".$product['quantity']."</td>";
											     
											}else 
											{
											
											if(!empty($product['option'])){
											    $tot_qty = 0;
											    foreach($product['option'] as $opo_qty){
												    
												    $tot_qty += (isset($opo_qty->option_qty) ? $opo_qty->option_qty : 0);
												}
												if($tot_qty == 0){
												   echo "<td width=\"10%\">".$product['quantity']."</td>"; 
												}else{
												    echo "<td width=\"10%\">".$tot_qty."</td>"; 
												}
											   
											    
											}
											else{
											    
											    echo "<td width=\"10%\">".$product['quantity']."</td>";
											}
											
										}
											
											
											
											
											
											$num1 = $product['quantity'];
											$num2 = number_format($product['price'],2, '.', '');
											$total = $num1 * $num2;
											$subtotal+=$total;
											if(!empty($product['option'])){ 
											    
											    echo "<td width=\"10%\">$".number_format($product['price'],2, '.', '')."</td>";
											echo "<td width=\"10%\">$".number_format($total,2, '.', '')."</td>";
											    
											    
											    
											}else{
											    
											  echo "<td width=\"10%\">$".number_format($product['price'],2, '.', '')."</td>";
											echo "<td width=\"10%\">$".number_format($total,2, '.', '')."</td>";  
											}
											
											echo "</tr>";
											if(!empty($product['option'])){
												foreach($product['option'] as $opo){
												    
													//if($product['order_product_id']==$opo->order_product_id)
													{
													    $opt_total = (isset($opo->price) && $opo->price != '' ? $opo->price : 0) * (isset($opo->option_qty) && $opo->option_qty != '' ? $opo->option_qty : 0);
														echo "<tr>";
														echo "<td colspan='4'>
														<table width='100%' border='0'>
														<tr>";
														    if($opo->type !='textarea'){ 
														        echo "<td width='20%'>Option: <br> Value: <br> Quantity:  <br> Price:  <br> Total: </td>";
														    }
														   echo "<td>";
														   if($opo->type !='textarea'){ 
														  echo   $opo->value;
														   echo  "<br>";
														   
														   echo $opo->name;
														    
														    echo "<br>";
                                                            
														    echo $product['quantity'];
                                                            
														   echo  "<br>
														    $".number_format((isset($opo->price) && $opo->price !='' ? $opo->price : 0),2, '.', '')."<br>
														    $".number_format($opt_total,2, '.', '')."<br>";
														  }else{
														   echo  $opo->name;
														   echo "<br>";
														   echo $opo->value ;
														  }
														    echo "</td>
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
											$header= (isset($product['heading']) ? $product['heading'] : '');
										} 
									}?>
									<thead>
										<tr class="bg-warning text-light">
											<th colspan="4">Comments</th>
										</tr>
									</thead>
									<tr>
										<td colspan="4"><?php echo trim($order_info[0]->comment)==''?"&nbsp;":$order_info[0]->comment;?></td>
									</tr>
								
							
									<?php 
										if(!empty($order_totals)){  
										  (int)$totals = number_format($order_info[0]->total,2, '.', '');
										foreach ($order_totals as $order_total) {  ?>
										<?php 
                                             if($order_total['title']=='Total'){ ?>
                                                <tr>
        											<td width="70%">&nbsp;</td>
                										<td  width="70%"><strong>GST (10%)</strong></td>
                										<td colspan="2" width="20%">$<?php echo number_format(($totals)/11,2, '.', '');?></td>
            									</tr>
    										<?php } ?>
                                             <tr>
                                                 <td width="70%">&nbsp;</td>
                                    <td width="70%"><strong><?php echo $order_total['title']; ?></strong></td>
                                    <td colspan="2" width="20%"><?php echo "$".number_format($order_total['text'],2, '.', ''); ?></td>
                                        </tr>
                                        
                                             <?php 
                                            
                                             }} ?>
										
										<?php if($order_info[0]->order_status_id == 2){?>
										<tr>
											<td width="70%">&nbsp;</td>
											<td  width="70%"><strong>Amount Paid</strong></td>
											<td colspan="2" width="20%">$<?php echo $totals;?></td>
										</tr>
										<tr>
											<td width="70%">&nbsp;</td>
											<td  width="70%"><strong>Balance Due</strong></td>
											<td colspan="2" width="20%">$0.00</td>
										</tr>
										<?php }?>
									</table>
									<table class="table table-sm mt-3">
										<tr class="bg-warning text-light">
											<td width="50%">
											
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
							<input type="email" class="form-control" id="email">
							<input type="hidden" class="form-control" id="customer_name" value="<?php echo $order_info[0]->firstname; ?>">
							<div class="invalid-feedback">Please enter an email address!</div>
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
			window.open("<?php echo base_url();?>index.php/orders/print_order/"+order_id+"/"+<?php echo "'".$fingerprint."'";?>+"/frontend");
		}
		function open_modal()
		{  $("#email").val($("#customerOrderEmail").html())
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
				url:'<?php echo base_url();?>index.php/orders/send_email/<?php echo $order_info[0]->order_id;?>/<?php echo $fingerprint;?>/<?php $order_info[0]->order_id; ?>',
				method:"POST",
				data:{
				    
				    "email":$("#email").val(),
				    "customer_name":$("#customer_name").val(),
				    "ofrom":'frontend'
				    
				},
				complete:function(){
				 $(".buttonContent").html('Mail Sent');
				 $("#email_modal").modal('hide');
				}
			})
		}
		function open_modal_link()
		{  $("#email_payment").val($("#customerOrderEmail").html())
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
				url:'<?php echo base_url();?>index.php/orders/send_link/<?php echo $order_info[0]->order_id;?>/<?php echo str_replace(',','',number_format($order_info[0]->total,2, '.', ''));?>/frontend',
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
        		data: {"order_id":order_id,"ofrom":"frontend"},
        		success:function(data){
        			if(data=='sent'){
        			    $(".buttonContentFeedback").html(' Mail Sent <i class="fa fa-check"></i>');
        			}else{
        			    $(".buttonContentFeedback").html(' Mail Failed <i class="fa fa-close"></i>');
        			}
        		}
        	});
        }
		</script>