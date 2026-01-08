<style>
	.table-sm th, .table-sm td{
		font-size:0.9em;
		padding:5px;
	}
</style>
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
							<h1>Reports</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Reports
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
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Report</h3>
							</div>
							<div class="card-body">
								<table class="table table-sm table-striped table-responsive">
									<thead>
										<tr>
											<th>Order #</th>
											<th>Order Date</th>
											<th>Delivery Date</th>
											<th>Customer</th>
											<th>Department</th>
											<th>Company</th>
											<!--<th>Username</th>-->
											<th>Phone</th>
											<th>Email</th>
											<th>Subtotal</th>
											<th>Delivery Fee</th>
											<th>Surcharge</th>
											<th>Late Fee</th>
											<th>Discount</th>
											<th>GST</th>
											<th>Total</th>
											<th>Status</th>
											<th>Paid Comment</th>
											<th>Paid Date</th>
										</tr>
									</thead>
										<tbody>
										<?php if(empty($data)){
											echo "<tr><td colspan=\"14\">No results with current parameters. Please change parameters in previous page and try again.</td></tr>";
										}
										else{
										    
											$subtotalAllOrders=0.0;
											$deliveryTotalAllOrders=0.0;
											$lateFeeTotalAllOrders=0.0;
											$surchargeTotalAllOrders=0.0;
											$discountTotalAllOrders=0.0;
											$grandTotalAllOrders=0.0;
											$gstTotalAllOrders=0.0;

											
											foreach($data as $key=>$row){
											 //   $x = $row->oc_order_id?$row->oc_order_id.'-1800INV':$row->order_id.'-1800HC';
											 
											  
												echo "<tr>";
												echo "<td>".$row->order_id."</td>";
												echo "<td>".date('d-m-Y',strtotime($row->order_date_added))."</td>";
												if(isset($row->delivery_date)){
												   
												   	echo "<td>".date("d-m-Y",strtotime($row->delivery_date))."</td>"; 
												}else{
												  
												  	echo "<td>".date("d-m-Y",strtotime($row->delivery_date_time))."</td>";  
												}
											   	if(isset($row->customer_order_name)){
											   	echo "<td>".$row->customer_order_name."</td>";
											   	}else{
											   	echo "<td>".$row->firstname." ".$row->lastname."</td>";    
											   	}
												
												if(!isset($row->department_name)){
												    echo "<td>".$row->dept_name."</td>";
												}else{
												    echo "<td>".$row->customer_department_name."</td>";
												}
												
												echo "<td>".$row->customer_company_name."</td>";
												echo "<td>";
												if(isset($row->customer_order_telephone) && !empty($row->customer_order_telephone))
												{
														echo $row->customer_order_telephone;
												}else{
														echo $row->telephone;
												}
												echo "</td>";
												echo "<td>";
												if(isset($row->customer_order_email) && !empty($row->customer_order_email))
												{
													echo $row->customer_order_email;	
													$email=$row->customer_order_email;
												}else{
													echo $row->email;	
													$email=$row->email;
												}
												echo "</td>";
												
												 
											
		if(isset($frontend_order_totals) && !empty($frontend_order_totals) && array_key_exists($row->order_id,$frontend_order_totals)) {
							                 
							
												   $newArray = array();
												    foreach($frontend_order_totals[$row->order_id] as $key_ot => $frontend_order_total){
												    
												      $newArray[$frontend_order_total['code']] = $frontend_order_total['value'];

												        if($frontend_order_total['code'] == 'total'){
												            $gst = number_format($frontend_order_total['value']/11,2, '.', '');
												        }
												    }
												    if(isset($newArray['sub_total'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['sub_total'],2, '.', '');
        												    echo "</td>";
        												    $subtotalAllOrders += (float)$newArray['sub_total'];
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    if(isset($newArray['shipping'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['shipping'],2, '.', '');
        												    echo "</td>";
        												     $deliveryTotalAllOrders += (float)$newArray['shipping'];
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    if(isset($newArray['holiday_weekend_charges'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['holiday_weekend_charges'],2, '.', '');
        												    echo "</td>";
        												    $surchargeTotalAllOrders += (float)$newArray['holiday_weekend_charges'];
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    
												    if(isset($newArray['late_fee'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['late_fee'],2, '.', '');
        												    echo "</td>";
        											 $lateFeeTotalAllOrders += (float)$newArray['late_fee'];	    
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    
												    if(isset($newArray['coupon'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['coupon'],2, '.', '');
        												    echo "</td>";  
        											$discountTotalAllOrders += (float)$newArray['coupon'];	    
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    echo "<td>$".$gst."</td>";
												    $gstTotalAllOrders += (float)$gst;
												    
												    if(isset($newArray['total'])){
												            echo "<td>";
        												    echo "$". number_format($newArray['total'],2, '.', '');
        												    echo "</td>";  
        											 $grandTotalAllOrders += (float)$newArray['total'];
        												    
												    }else{
												       echo "<td>$0.00</td>";
												       
												    }
												    
												    
												    if($row->order_status_id==0){
											         $status="Cancelled";
											        }
												   elseif($row->order_status_id == 2){
												    $status="Paid";
												    } else if($row->order_status_id==4){
														$status= "Awaiting approval";
												    }else if($row->order_status_id == 7){
												    $status= "Approved";
												  }else if($row->order_status_id == 1){
												    $status= "New Order";
												  }else if($row->order_status_id == 8){
												    $status= "Rejected";
												  }else if($row->order_status_id == 9){
												    $status= "Modified";
												  }
												  
										echo "<td>".$status."</td>";
										
												    
												  echo "<td>";
												 if(isset($row->mark_paid_comment) && $row->mark_paid_comment != ''){
												   echo $row->mark_paid_comment;  
												 } 
												     echo "</td>"; 
												    if($row->order_status_id == 2){
												    echo "<td>";
												    echo $row->date_modified;;
												    echo "</td>"; 
												    }
												} else {
												    
					
												    
				     $ord_sub_total = (isset($row->order_total) && !is_null($row->order_total) && $row->order_total != '' ?  $row->order_total : 0.00);
				     $subtotalAllOrders += $ord_sub_total;
				     
				     $del_fee = (isset($row->delivery_fee) && !is_null($row->delivery_fee) && $row->delivery_fee != '' ?  $row->delivery_fee : 0.00);
				     $deliveryTotalAllOrders += $del_fee;
				     
				      $lateFee = (isset($row->late_fee) && !is_null($row->late_fee) && $row->late_fee != '' ?  $row->late_fee : 0.00);
				     $lateFeeTotalAllOrders += $lateFee;
				     
				      $surcharge = (isset($row->surcharge) && !is_null($row->surcharge) && $row->surcharge != '' ?  $row->surcharge : 0.00);
				     $surchargeTotalAllOrders += $surcharge;
				     
				     
				     $order_totalForCouponDiscount=$row->order_total + $lateFee + $del_fee + $surcharge;
				     if(!is_null($row->coupon_id) || $row->coupon_id !=''){
						if($row->type=='F')
						$discount=$order_info->coupon_discount;
						else{
						    
						$discount=($order_totalForCouponDiscount*$row->coupon_discount)/100;
						}
					   } else $discount=0;
					
					   
					 $order_total=$row->order_total + $lateFee + $del_fee + $surcharge - $discount;
				     $grandTotalAllOrders += $order_total;
				     
				     $gst = ($order_total/11);
				     $gstTotalAllOrders += $gst;
				     
				   
					 
				
				
					   
					   
					 	
					                           echo "<td>$".number_format($ord_sub_total,2, '.', '')."</td>";
												echo "<td>$".number_format($del_fee,2, '.', '')."</td>";
												echo "<td>$".number_format($surcharge,2, '.', '')."</td>";
												echo "<td>$".number_format($lateFee,2, '.', '')."</td>";
											    echo "<td>";
												if(empty($row->coupon_id)){
													echo "$0.00";
													$discount=0;
												}
												else{
													if($row->type=='F'){
														$discount=$row->coupon_discount;
														echo "$".$row->coupon_discount;
													}
													else if($row->type=='P'){
														$discount=($order_total*$row->coupon_discount/100);
														echo "$".number_format(($order_total*$row->coupon_discount/100),2, '.', '');
													}
												}
												echo "</td>";
												echo "<td>$".number_format(($order_total)/11,2, '.', '')."</td>";
												echo "<td>$".number_format($order_total,2, '.', '')."</td>";
												    
											
											if($row->order_status==0){
											    
											     echo "<td>";
												    echo "Cancelled";
												    echo "</td>";
												    $status="Cancelled";
											}
											elseif($row->order_status == 8){
												         echo "<td>";
												    echo "Rejected";
												    echo "</td>";
												    $status="Rejected";
												    } 
											else if($row->order_status ==7) {
												    echo "<td>Approved</td>";
												    
												}	
											else if($row->order_status==1){
													echo "<td>New</td>";
												}
											else if($row->order_status==2){
													echo "<td>Paid</td>";
												}
											else if($row->order_status==4)
											echo "<td>Waiting for Approval</td>";
												
											 echo "<td>";
												 if(isset($row->mark_paid_comment) && $row->mark_paid_comment != ''){
												   echo $row->mark_paid_comment;  
												 }
										    echo "</td>"; 
												    
										if(isset($row->order_status) &&  $row->order_status == 2){
												    echo "<td>";
												    echo $row->date_modified;
												    echo "</td>";
												}
											}
												
												echo "</tr>";
										
											
											}
											
										
											echo "<thead><tr><th colspan=\"7\">&nbsp;</th><th>Total</th>
											<th>$".number_format($subtotalAllOrders,2, '.', '')."</th><th>$".number_format($deliveryTotalAllOrders,2, '.', '')."</th><th>$".number_format($surchargeTotalAllOrders,2, '.', '')."</th>
											<th>$".number_format($lateFeeTotalAllOrders,2, '.', '')."</th><th>$".number_format($discountTotalAllOrders,2, '.', '')."</th><th>$".number_format($gstTotalAllOrders,2, '.', '')."</th><th>$".number_format($grandTotalAllOrders,2, '.', '')."</th><th>&nbsp;</th></tr></thead>";
											echo "<tr><td colspan=\"15\" class=\"text-center\">
											<form action=\"".base_url()."index.php/orders/get_report_csv\" method=\"POST\">
											<input type=\"hidden\" name=\"date_from\" value=\"".$params['date_from']."\">
											<input type=\"hidden\" name=\"date_to\" value=\"".$params['date_to']."\">
											
											<input type=\"hidden\" name=\"added_date_from\" value=\"".$params['added_date_from']."\">
											<input type=\"hidden\" name=\"added_date_to\" value=\"".$params['added_date_to']."\">
											
										
										
											<input type=\"hidden\" name=\"company\" value=\"".$params['company']."\">
											<input type=\"hidden\" name=\"status\" value=\"".$params['status']."\">
											<input type=\"hidden\" name=\"locations\" value=\"".$params['locations']."\">
											<button class=\"btn btn-info\" type=\"submit\">Download <i class=\"fa fa-download\">
											</i></button></form></td></tr>";
											
											
											
											
										}
										?>
									</tbody>
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
