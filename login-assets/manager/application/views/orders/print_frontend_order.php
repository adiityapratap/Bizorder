
<style>.borderless tr td, .borderless tr th {border: none;padding-top:0;padding-bottom:0;}.table-bordered .delivery_info_labels{
    font-weight:600 !important;
} </style>
<!-- header_End -->
<!-- Content_right -->
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- Section -->
			<div class="container-fluid">
			        <div class="row"><div class="col-md-12">
			             <button class="btn"  style="margin-left: 14px;background-color:black !important;border:1px solid black;float:right;" onclick="window.print()"><font color="#fff">Print Invoice</font></button>
			            	<button onclick="printContent('<?php echo $order_info[0]->order_id;?>','<?php echo$order_info[0]->customer_id;?>')" class="btn" style="margin-left: 614px;background-color:black !important;border:1px solid black;float:right;"><font color="#fff">Download Invoice PDF </font></button>
                   </div></div>
				<div class="row" id="div1">
					<!--Report widget start-->
					<div class="col-12">
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
										foreach($order_products as $product){
									
								
								
									
											echo "<tr><td colspan=\"4\"></td></tr>";
											echo "<tr>";
											echo "<td width=\"70%\">".$product['name']."<br>";
							                
											echo htmlspecialchars_decode(stripslashes($product['descr'][0]['description'])); 
										
										
											echo "</td>";
											
											
if(isset($product['addons']) && $product['addons'] == 'Yes' ){
    
											     echo "<td width=\"10%\">".$product['quantity']."</td>";
											     
											}else 
											{
											
											if(!empty($product['option'])){
											    $tot_qty = 0;
											    foreach($product['option'] as $opo_qty){
												    
												    $tot_qty += $opo_qty->option_qty;
												}
												
											    echo "<td width=\"10%\">".$tot_qty."</td>";
											    
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
											echo "<td width=\"10%\">$".$total."</td>";  
											}
											
											echo "</tr>";
											if(!empty($product['option'])){
												foreach($product['option'] as $opo){
												    
													//if($product['order_product_id']==$opo->order_product_id)
													{
													    $opt_total = $opo->price * $opo->option_qty;
														echo "<tr>";
														echo "<td colspan='4'>
														<table width='100%' border='0'>
														<tr>
														    <td width='20%'>Option: <br> Value: <br> Quantity:  <br> Price:  <br> Total: </td>
														    <td>";
														    
														  echo   $opo->value;
														   echo  "<br>";
														   
														   echo $opo->name;
														    
														    echo "<br>";
                                                             if(isset($product['addons']) && $product['addons'] == 'Yes' ){
														        
														         echo   $product['quantity'];
														         
														    }else{
														        
														        echo   $opo->option_qty; 
														    }
														    
														    
														   echo  "<br>
														    
														    $".number_format($opo->price,2, '.', '')."<br>
														    $".number_format($opt_total,2, '.', '')."<br></td>
														    
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
											<th colspan="4">Comments</th>
										</tr>
									</thead>
									<tr>
										<td colspan="4"><?php echo trim($order_info[0]->comment)==''?"&nbsp;":$order_info[0]->comment;?></td>
									</tr>
									<?php
									
									
										if(!empty($order_totals)){  
										foreach ($order_totals as $order_total) {  ?> 
										<?php 
                                             if($order_total['title']=='Total'){ 
                                             $totals = number_format($order_total['text'],2, '.', '');
                                             ?>
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
                                             
                                             
								
								<?php if($order_info[0]->order_status_id==2){?>
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
				window.open("<?php echo base_url();?>index.php/orders/print_order/"+order_id+"/"+<?php echo "'".$fingerprint."'";?>);
			}
			
								function printContent(order_id,cust_id){   
							    
			window.open("<?php echo base_url();?>index.php/orders/front_end_order_inv_download/"+order_id+"/"+ cust_id + "/"+ <?php echo "'".$fingerprint."'";?>);
							    
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