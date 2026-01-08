<style>
.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;} 
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
							<h1>View Order</h1>
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
									View Order
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
									    <?php if($is_customer == 0){ ?>
			            <button class="btn" style="background-color:black !important;border:1px solid black;float:left;width:130px" onclick="printDiv()"><font color="#fff">Print </font></button>


										<?php } ?>
										<?php if($order_info->order_status!=3&&$order_info->order_status!=14){
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
											  
											<?php }?>
										
										
										</div>
									</div>
								</div>
							</div>
							<div class="card card-shadow mb-4">
							    <div id="print_div">
								<table class="table table-bordered orderviewtable" style="font-size:18px;">
									<thead>
										<tr>
										<th colspan="4" class="text-center bg-warning text-light">Production</th>
										</tr>
									</thead>
									<tr>
										<td colspan="2" width="50%">
											<strong class="mr-2">Order ID: </strong><?php echo $order_info->order_id;?><br>
											<strong class="mr-2">Name: </strong><?php echo $order_info->customer_order_name;?><br>
											<strong class="mr-2">Email: </strong><?php echo $order_info->customer_order_email;?><br>
											<strong class="mr-2">Phone: </strong><?php  $phone = $order_info->customer_order_telephone;
											echo $order_info->customer_order_telephone;
											?><br>
											 <strong class="mr-2">Delivery Date: </strong><?php echo date('g:i A, l - d M Y',strtotime($order_info->delivery_date_time));?><br>
										
										</td>
										<td colspan="2" width="50%">
										   <strong class="mr-2">Shipping Method: </strong><?php echo $order_info->shipping_method==1?"Delivery":"Pickup";?><br>
											<hr>
											<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info->pickup_delivery_notes;?><br>
										    <strong class="mr-2">Delivery Contact No: </strong><?php if(isset($order_info->delivery_phone) && $order_info->delivery_phone !='') {
											echo $order_info->delivery_phone;
											}else{
											    echo '';
											}
											?><br>
											
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
								<table class="table table-bordered " >
									<thead>
										<tr class="bg-warning text-light">
										    <th>Quantity</th>
											<th>Product Name</th>
											<th>Product Comment</th>
											
										</tr>
									</thead>
									<?php
								if(!empty($order_products)){
									    $PrdctExcludedFromGST_DeductItsPrice = 0;
										foreach($order_products as $product){
										    
											$product=(array)$product;
											
											if(!empty($product['heading'])&&$product['heading']!=$header)
											
											
												echo "<tr><td colspan=\"2\"><strong>".$product['heading']."</strong></td></tr>";
												
											echo "<tr>";
											
												if(!empty($product['options']) || $product['price'] > 0){
											echo "<td width=\"30%\">".$product['quantity']."</td>";
											}else{
											    if($product['quantity'] > 0){
											  	echo "<td width=\"30%\">".$product['quantity']."</td>";  
											    }else{
											         echo "<td width=\"30%\"></td>";
											    }
											    
											}
											
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
														    ".$opo->option_name."
														    
														    </td>
														    
														</tr>
														</table>
														</td>";
														echo "</tr>";
													}
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