<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;}.table-bordered .delivery_info_labels{
    font-weight:600 !important;
} </style>
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
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Production Order
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
			            <button class="btn" style="background-color:black !important;border:1px solid black;float:left;width:130px" onclick="printDiv()"><font color="#fff">Print </font></button>
										
										<?php if($order_info[0]->order_status!=3&&$order_info[0]->order_status!=14){
											$coupon_discount = 0;
											$amt=number_format($order_info[0]->total+(isset($order_info[0]->delivery_fee) ? $order_info[0]->delivery_fee : 0)-$coupon_discount,2, '.', '')*100;
										?>	
									
											<?php 
												$mid=	$this->session->userdata('merchant_id');
													$mpass=	$this->session->userdata('merchant_pass');
												   $orders_identity = "frontend";
														?>
										
											<?php }?>
										
										</div>
									</div>
								</div>
							</div>
							<div class="card card-shadow mb-4">
							    <div id="print_div">
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
											<strong class="mr-2">Email: </strong><?php echo $order_info[0]->email;?><br>
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
											$gateNumber = ($order_info[0]->shipping_gate_number != '' ? $addDetails .= '<span class="delivery_info_labels">Gate no : </span>'.$order_info[0]->shipping_gate_number.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_building_number != '' ? $addDetails .= '<span class="delivery_info_labels">Building number : </span>'.$order_info[0]->shipping_building_number.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_department_name != '' ? $addDetails .= '<span class="delivery_info_labels">Department name: </span>'.$order_info[0]->shipping_department_name.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_level_of_building != '' ? $addDetails .= '<span class="delivery_info_labels">Level of building : </span>'.$order_info[0]->shipping_level_of_building.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_room_number != '' ? $addDetails .= '<span class="delivery_info_labels">Room number : </span>'.$order_info[0]->shipping_room_number.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_business_name != '' ? $addDetails .= '<span class="delivery_info_labels">Business name :</span> '.$order_info[0]->shipping_business_name.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_street_number != '' ? $addDetails .= '<span class="delivery_info_labels">Street number : </span>'.$order_info[0]->shipping_street_number.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_delivery_contact_name != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact name :</span> '.$order_info[0]->shipping_delivery_contact_name.'</br>' : '</br>');
										    $gateNumber = ($order_info[0]->shipping_delivery_contact_number != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact number : </span>'.$order_info[0]->shipping_delivery_contact_number.'</br>' : '</br>');

											
											?>
											<?php  echo $addr;?><br>
											<?php  echo $addDetails;?>
										</td>
									</tr>
								
									
								</table>
								<table class="table table-bordered table-sm">
									<thead>
										<tr class="bg-warning text-light">
										    <th>Quantity</th>
											<th>Product Name</th>
										<th>Product Comment</th>
											
										</tr>
									</thead>
									<?php 
                                         $subtotal=0;
                                        //  echo "<pre>";
                                        //  print_r($order_products);
                                        //  exit;
									if(!empty($order_products)){
									  	foreach($order_products as $product){
									
							
								        
												echo "<tr><td colspan=\"3\"></td></tr>";
											echo "<tr>";
											echo "<td width=\"20%\">".$product['quantity']."</td>";
											echo "<td width=\"50%\"><strong>".$product['name']."</strong><br>";
							                 echo htmlspecialchars_decode(stripslashes($product['descr'][0]['description'])); 
											
											echo "</td>";
												echo "<td width=\"30%\"></td>";
											echo "</tr>";
											if(!empty($product['option'])){
												foreach($product['option'] as $opo){
													{
														echo "<tr>";
														echo "<td colspan='2'>
														<table width='100%' border='0'>
														<tr>
														    <td width='20%'>Option: <br> Value:   </td>
														    <td>";
														    
														  echo   $opo->name;
														   echo  "<br>";
														   
														   echo $opo->value;
														    
														  
                                                        //   echo   $product['quantity'];
														   echo  "</td></tr></table></td>";
													      echo "</tr>";
													}
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
								
									</table>
								</div>
							
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
		

	<script>
	function printDiv()
		{
			 var printContents = document.getElementById('print_div').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
		}
	
		</script>