<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];
$paid_tab = $this->input->get('id', TRUE);
$userId = $this->session->userdata('user_id');
?>
<!-- header_End -->
<!-- Content_right -->
<div class="container_full bg_img_banner mt-5">
    <style>
    table#table {
    margin-top: 0 !important;
}
.fixed-table-header {
    display: none !important;
}
</style>
    <input type="hidden" id="paid_chk" value="">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1>Past Orders</h1>
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
									Past Orders
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
								<h3 class="card-title">Filters</h3>
							</div>
							<div class="card-body">
								<form id="order_filters">
									<div class="row">
									    
								
										
										
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control datepicker" id="date_from" type="text" placeholder="Delivery Date From">
										</div>
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control datepicker" id="date_to" type="text" placeholder="Delivery Date To">
										</div>
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control " id="order_id" type="text" placeholder="Order Id">
										</div>
									
										
									
										<div class="col-auto mb-3">
											<div class="col-12 col-md-1">
												<button class="btn btn-primary">Filter</button>
											</div>
										</div>
										<div class="col-auto mb-3">
											<div class="col-12 col-md-1">
												<a href="<?php echo base_url().'index.php/orders/past_orders' ?>" class="btn btn-primary">Reset Filter</a>
											</div>
										</div>
										
										
									</div>
									
									<div class="row">
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control " id="late_fee" type="text" placeholder="Enter Late Fee">
										</div>
										<div class="col-12 col-md-2 mb-3">
											<input class="btn btn-primary" id="late_fee_submit" type="button" onclick="addLateFee('add_late_fee')" value="Add Late Fee">
										 <span class="badge badge-success late_fee_text" style="display:none;font-size: 15px !important;">Late Fee Adeed Succesfully</span>
										</div>
									</div>
									
								
								</form>
							</div>
						</div>
						<div class="card card-shadow mb-4">
							<div class="card-body">
								<div class="table-responsive">
									<ul class="nav nav-pills nav-pills-info mb-4 mt-3 ml-3"  id="myTab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="unpaid-tab" data-toggle="tab" href="#unpaid" role="tab" aria-controls="unpaid" aria-selected="false">Outstanding Orders</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="paid-tab" data-toggle="tab" href="#paid" role="tab" aria-controls="paid" aria-selected="true">Paid Orders</a>
										</li>
									</ul>
									<div class="tab-content" id="myTabContent">
										<div class="tab-pane fade show active" id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">
											<table class="table table-sm table-bordered">
												<thead>
													<tr>
										<th><label class="control control-solid control-solid-info control--checkbox mb-4" style="display:inline;"><input type="checkbox" id="check_all"><span class="control__indicator"></span></label></th>
														<th>Order #</th>
														<th>Delivery Date &amp; Time</th>
														<th>Customer</th>
														<th>Balance</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php if(!empty($orders)){
													  
														foreach($orders as $order)
														{
														   // $x = $order->oc_order_id?$order->oc_order_id.'-1800INV':$order->order_id.'-1800HC';
															if($order->order_status!=2)
															{ 
if($order->payment_code == 'cod'){
                                                       	echo "<tr style='background-color: #f4e389;'>"; 
                                                    }else if($order->payment_code == 'securepayapi'){
                                                       	echo "<tr style='background-color: #62bbff !important;'>"; 
                                                    } else if($order->updatedAfterApproved){
                                                   echo "<tr style='background-color: #DC3546;color:#fff'>"; 
                                                   } else {
                                                    echo "<tr>";   
                                                     }															    

										if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
	echo "<td><label class=\"control control-solid control-solid-info control--checkbox\"><input type=\"checkbox\" class=\"multi_check\" id=\"frontend_".$order->order_id."\"><span class=\"control__indicator\"></span></label></td>";

												}else{
echo "<td><label class=\"control control-solid control-solid-info control--checkbox\"><input type=\"checkbox\" class=\"multi_check\" id=\"backend_".$order->order_id."\"><span class=\"control__indicator\"></span></label></td>";
												    
												    
												}
															 
																echo "<td>".$order->order_id."</td>";	
																echo "<td>". date('d M Y h:i A',strtotime($order->delivery_date_time))."</td>";
																if($order->customer_order_name != ''){
																    $custName = $order->customer_order_name;
																}else{
																    $custName = $order->firstname." ".$order->lastname;
																}
																echo "<td>".wordwrap($custName,18,"<br>\n")."</td>";
																if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
															    	if($order->order_status!=2){
															    echo "<td>$".number_format($order->total,2, '.', '')."</td>";
															    	}else{
															    	    
															    	    echo "<td>$0.00</td>";
															    	}
															}else{
																
															
																
														if(isset($order->delivery_fee) && $order->delivery_fee != 0)	{
														    
														    $delivery_fee = number_format($order->delivery_fee,2, '.', '');
														}	else{
														    
														    $delivery_fee = 0;
														}
											
																
																if(!is_null($order->coupon_id)){
										if($order->type=='F')
											$coupon_discount=$order->coupon_discount;
										else{
											$total_so_far=$order->order_total+$order->late_fee+$delivery_fee;
											$coupon_discount=($order->coupon_discount*($order->order_total+$order->late_fee+$delivery_fee))/100;
										}
											
											}else{
											    $coupon_discount = 0;
											}
												
											
											if($order->order_status!=2){	
											    
											echo "<td>$".number_format($order->order_total+$order->late_fee+$delivery_fee-$coupon_discount,2, '.', '')."</td>";					
											}
											else {
											    
											    echo "<td>$0.00</td>";
											}
												
										}
																
													if($order->order_status == 1){
											    echo "<td>New</td>";
											}
											if($order->order_status == 7){
											    echo "<td>Approved</td>";
											}
											if($order->order_status == 2){
											    echo "<td>Paid</td>";
											}
											elseif($order->order_status == 8){
											    echo "<td>Rejected</td>";
											}
											else if($order->order_status==9){
											echo "<td>Modified</td>";
											}
											else if($order->order_status==4){
											echo "<td>Awaiting approval</td>";
										}
                                                              	echo "<td>";
																
														if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													   $orders_identity = $order->order_made_from;
														}else{
														   $orders_identity = 'backend'; 
														}
																
						echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm mb-1 m-sm-100 mr-2\">View</a>";
																
						
										if($order->order_status!=2){	?>
												<?php
							echo "<button class=\"btn btn-danger btn-sm mb-1 m-sm-100 mr-2\" onclick=\"mark_paid_trigger('".$order->order_id."','".$order->uid."','".$order->customer_uid."','".$order->order_total."','".$referrer."','".$orders_identity."')\">Mark Paid</button>";
							echo "<a href=\"".base_url()."index.php/orders/edit_order/".$order->order_id."/".$order->order_status."?ofrom=".$orders_identity."\" class=\"btn btn-primary btn-sm mb-1 m-sm-100 mr-2\">Edit</a>";
												}
												?>
												 <?php if($order->updatedAfterApproved){ ?>
                                             <button  class="btn btn-danger btn-sm mb-1 m-sm-100 mr-2" onclick="chefApprove(<?php  echo $order->order_id;  ?>,'<?php echo $orders_identity; ?>')">Acknowledged</a>
											<?php } ?>
													</td>
													</tr>	
													<?php		}	}	}?>
													
												</tbody>
											</table>
										</div>
										<div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab">
											<table class="table table-sm table-bordered">
												<thead>
													<tr>
														<th>Order #</th>
														<th>Delivery Date &amp; Time</th>
														<th>Customer</th>
														
														<th>Balance</th>
														<th>Status</th>
														<th>Paid Comment</th>
													
														<th>Action</th>
														
													</tr>
												</thead>
												<tbody>
													<?php if(!empty($orders)){
														foreach($orders as $order)
														{
                                        //  	$x = $order->oc_order_id?$order->oc_order_id.'-1800INV':$order->order_id.'-1800HC';
                                        
                                        if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													   $orders_identity = $order->order_made_from;
														}else{
														   $orders_identity = 'backend'; 
														}
														
                                        	if($order->order_status==2){
                                        	    
                                        	    
                                                
                                                	if($order->order_status<11)
                                                    if($order->express_order == 1){
                                                       	echo "<tr style='background-color: #8fc319;'>"; 
                                                    }else{
                                                     	echo "<tr>";   
                                                    }
																else echo "<tr class=\"bg-custom-warning text-white\">";
																echo "<td>".$order->order_id."</td>";
																
																if(isset($order->order_made_from) && $order->order_made_from=='frontend'){
																    
																    	$date = $order->delivery_date_time;
                                                                        $time = $order->delivery_time;
                                                                         $dt=  $date .' '. $time ;
                                                                         
												                     echo "<td>". date('g:i A, l - d M Y',strtotime($dt))."</td>";
																}else{
																    
												    echo "<td>". date('d M Y h:i A',strtotime($order->delivery_date_time))."</td>";
																}
																echo "<td>".wordwrap($order->firstname." ".$order->lastname,18,"<br>\n")."</td>";
												                
												                
												                
																
																
													if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
															    	if($order->order_status!=2){
															    echo "<td>$".number_format($order->total,2, '.', '')."</td>";
															    	}else{
															    	    echo "<td>$0.00</td>";
															    	}
															}else{
														if(isset($order->delivery_fee) && $order->delivery_fee != 0)	{
														    $delivery_fee = number_format($order->delivery_fee,2, '.', '');
														}	else{
														    $delivery_fee = 0;
														}
																if(!is_null($order->coupon_id)){
																		if($order->type=='F')
											$coupon_discount=$order->coupon_discount;
										else{
											$total_so_far=$order->order_total+$order->late_fee+$delivery_fee;
											$coupon_discount=($order->coupon_discount*($order->order_total+$order->late_fee+$delivery_fee))/100;
										}
											}else{
											    $coupon_discount = 0;
											}
											if($order->order_status!=2){	
											echo "<td>$".number_format($order->order_total+$order->late_fee+$delivery_fee-$coupon_discount,2)."</td>";					
																	}
											else {
											    echo "<td>$0.00</td>";
																}
										}
									
										if($order->order_status == 1){
											    echo "<td>New</td>";
											}
											if($order->order_status == 7){
											    echo "<td>Approved</td>";
											}
											if($order->order_status == 2){
											    echo "<td>Paid</td>";
											}
											elseif($order->order_status == 8){
											    echo "<td>Rejected</td>";
											}
											else if($order->order_status==9){
											echo "<td>Modified</td>";
											}
											else if($order->order_status==4){
											echo "<td>Awaiting approval</td>";
										}
													
																echo "<td>";
																$replaced = preg_replace('/\s\s+/', ' ', $order->mark_paid_comment);
																echo $replaced;
																echo "<span><i class='fa fa-pencil'></i><a href='#' onclick='return update_comment(\"$orders_identity\",".$order->order_id.",\"$replaced\");'>Edit</a></span>";
															   echo "</td>";
																
															
																echo "<td>";
																echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm mb-1 m-sm-100 mr-2\">View</a>";
																// echo "<button class=\"btn btn-danger btn-sm mb-1 m-sm-100 mr-2\" onclick=\"delete_order('".$order->order_id."','".$referrer."','".$orders_identity."')\">Cancel</button>";
	                                                           // echo "<a href=\"".base_url()."index.php/orders/uploadOrderImage/".$order->order_id."?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm mb-1 m-sm-100 mr-2\">Upload Image</a>";
// echo "<button class=\"btn btn-danger btn-sm ml-1\" onclick=\"resend_mail('".$order->order_id."','".$referrer."')\">Approve Mail</button>";
																if(($order->order_status==1||$order->order_status==2||$order->order_status==11||$order->order_status==12||$order->order_status==13) && $userId !=8){
													echo "<a href=\"".base_url()."index.php/orders/edit_order/".$order->order_id."?ofrom=".$orders_identity."\" class=\"btn btn-primary btn-sm mb-1 m-sm-100 mr-2\">Edit</a>";
													
			}
												if($order->order_status!=2){
													$mid=	$this->session->userdata('merchant_id');
													$mpass=	$this->session->userdata('merchant_pass');   	?>
															
																	<?php
																echo "<button class=\"btn btn-danger btn-sm ml-1 mb-1 m-sm-100\" onclick=\"mark_paid_trigger('".$order->order_id."','".$referrer."','".$orders_identity."')\">Mark Paid</button>";
																}
																// if($order->standing_order==1){
																// 	echo "<button class=\"btn btn-dark btn-sm mb-1 m-sm-100 mr-2\" onclick=\"reorder('".$order->order_id."')\">Reorder</button>";
																// }
																echo "</td>";
																echo "</tr>";	
															}
													}
													}?>
												</tbody>
											</table>
									</div>
								</div>
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

<div class="modal fade" id="reorder_modal" tabindex="-1" role="dialog" aria-labelledby="reorder_title" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="reorder_title">Delivery date and time</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form action="<?php echo base_url();?>index.php/orders/reorder" method="POST" id="reorder_form">
				<input type="hidden" name="order_id" id="reorder_id">
				<div class="row">
					<div class="col-12">
						<label>Delivery Date</label>
						<input type="text" class="form-control datepicker" name="delivery_date" required>
					</div>
					<div class="col-12 mt-3">
						<label>Delivery Time</label>
						<input type="text" class="form-control timepicker" name="delivery_time" required>
					</div>
				</div>
				<div class="row mt-2">
					<div class='col-12'>
						<button type="submit" class="btn btn-info">Proceed</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>


<div class="modal fade" id="mark_paid_modal" tabindex="-1" role="dialog" aria-labelledby="mark_paid_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mark_paid_title">Mark Paid Comments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/mark_as_paid" method="POST" id="mark_paid_form">
					<input type="hidden" name="order_id" id="mark_paid_id">
					<input type="hidden" name="referrer" id="mark_paid_referrer">
					<input type="hidden" name="ofrom" id="mark_paid_order_made_from">
			
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="mark_paid_comments" required></textarea>
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Mark Paid</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="delete_order_modal" tabindex="-1" role="dialog" aria-labelledby="delete_order_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="delete_order_title">Are you sure, You want to delete this order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/delete_order" method="POST" id="delete_order_form">
					<input type="hidden" name="order_id" id="delete_order_id">
					<input type="hidden" name="referrer" id="delete_order_referrer">
					<input type="hidden" name="ofrom" id="delete_order_order_made_from">
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="cancel_comments" required></textarea>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Delete</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="resend_email_modal" tabindex="-1" role="dialog" aria-labelledby="resend_email_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="resend_mail_title">Email Comments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/resend_mail" method="POST" id="resend_mail_form">
					<input type="hidden" name="order_id" id="resend_mail_id">
					<input type="hidden" name="referrer" id="resend_mail_referrer">
					<input type="hidden" name="ofrom" id="resend_mail_order_made_from">
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="resend_mail_comments" required></textarea>
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Approve mail</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="order_comment_modal" tabindex="-1" role="dialog" aria-labelledby="order_comment_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mark_paid_title">Order Comments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/order_comment" method="POST" id="order_comment_form">
					<input type="hidden" name="order_id" id="order_comment_id">
					<input type="hidden" name="referrer" id="order_comment_referrer">
					<input type="hidden" name="ofrom" id="order_comment_made_from">
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="order_comment" required></textarea>
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Add Order Comment</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="upload_image_modal" tabindex="-1" role="dialog" aria-labelledby="upload_image_modal_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="upload_image_modal_title">Upload Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			    
				<form action="<?php echo base_url();?>index.php/orders/upload_order_image" enctype="multipart/form-data" method="POST" id="order_comment_form">
					<input type="hidden" name="order_id" id="upload_image_id">
					<input type="hidden" name="referrer" id="upload_image_referrer">
					<input type="hidden" name="ofrom" id="upload_image_form">
					<input type="hidden" value="pastOrder" name="listing_type">
					<div class="row">
						<div class="col-12">
							<input type="file" class="form-control" name="hc_image" required style="font-size: 11px;">
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Save Image</button>
						</div>
					</div>
				</form>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="view_image_modal" tabindex="-1" role="dialog" aria-labelledby="view_image_modal_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="view_image_modal_title">View Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			    <div class="row">
						<div class="col-12">
							<img src="" id="view_image" style="max-width:100%;">
							<p id="view_image_error" style="display:none;">No image found</p>
						</div>
					</div>
				
				
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="trigger_modal" data-toggle="modal" data-target="#modalTable">

<script>

function chefApprove(order_id,ofrom){
    if(ofrom=='backend'){
      	$.ajax({
			url:"<?php echo base_url();?>index.php/orders/chefApprove/"+order_id,
			method:"POST",
			success:function(){
			    location.reload();
			}
		});    
    }else{
    	$.ajax({
			url:"<?php echo base_url();?>index.php/orders/chefApproveFrontend/"+order_id,
			method:"POST",
			success:function(){
			    location.reload();
			}
		});    
    }
    
}

function addLateFee(){
     let late_fee_orders = [];
          var late_fee = $("#late_fee").val();
        	$(".multi_check").each(function(){
	      
		if($(this).is(':checked')){
			late_fee_orders.push($(this).prop('id'));
		}
	    })
	 
	 	late_fee_orders=late_fee_orders.join('.');
        
        $.ajax({
		url:'<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee,
		method:"POST",
		success:function(data){
		    
location.reload();
         }
	})
}

var $table = $('#table')

  $(function() {
    $('#modalTable').on('shown.bs.modal', function () {
      $table.bootstrapTable('resetView')
    })
  })
  
   
  
$(document).ready(function(){
    
    var paid_tab = "<?php echo $paid_tab; ?>";
    
    var paid_chk = $("#paid_chk").val();

    
    if(paid_tab == 3 || paid_chk == 3){
      
      $('#paid-tab')[0].click();
      
    
    }
  
  
  $("#company").on('change',function(e){
		$.ajax({
									url:"<?php echo base_url();?>index.php/orders/get_dept/"+$(this).val(),
									method:"POST",
									
									success:function(data){
								
						var data =	JSON.parse(data);
                         $("#department").html('');
                 $.each(data, function(index, item) {
            
            $('#department').append($("<option></option>").attr("value",item.department_id).text(item.department_name)); 
                      
                       });
									}
								})
	})
    
});


function update_comment(ofrom,id,comm){
    
   
    
    var referrer = "<?php echo $referrer; ?>";
    
    $("#mark_paid_modal").modal('show');
    $("#mark_paid_id").val(id);
    $("#mpc").val(comm);
    $("#mark_paid_referrer").val(referrer);
	$("#mark_paid_order_made_from").val(ofrom);
		$("#paid_chk").val(3);
	

	
			
    $("#mpu").css("display","block");
     $("#mp").css("display","none");
    
    
    
    
    
}

function order_comment(order_id,referrer,ofrom){
			$("#order_comment_id").val(order_id);
			$("#order_comment_referrer").val(referrer);
			$("#order_comment_made_from").val(ofrom);
			$("#order_comment_modal").modal('show');
		}
    
$(function(){

	$("#order_filters").on('submit',function(e){
		e.preventDefault();
		
		if($.trim($("#order_date").val())=='')
			order_date='unset';
		else order_date=$("#order_date").val();
		
		
		if($.trim($("#date_from").val())=='')
			date_from='unset';
		else date_from=$("#date_from").val();
		if($.trim($("#date_to").val())=='')
			date_to='unset';
		else date_to=$("#date_to").val();
		if($.trim($("#cost_centre").val())=='')
			cost_centre='unset';
		else cost_centre=$("#cost_centre").val();
		if($.trim($("#company").val())=='')
			company='unset';
		else company=$("#company").val();
		if($.trim($("#department").val())=='')
			department='unset';
		else department=$("#department").val();
		if($.trim($("#customer").val())=='')
			customer='unset';
		else customer=$("#customer").val();
		sort_order=$("[name='sort_order']:checked").val();
		if($.trim($("#order_id").val())=='')
			order_id='unset';
		else order_id=$("#order_id").val();
	
		window.location.href="<?php echo base_url();?>index.php/orders/past_orders/"+date_from+"/"+date_to+"/"+order_date+"/"+company+"/"+department+"/"+customer+"/"+sort_order+"/"+order_id+"/"+$("#locations").val();
	})
	$("#check_all_paid").on('change',function(e){
		if($("#check_all_paid").is(":checked")){
			$(".running_sheet_check_paid").prop('checked',true);
		}
		else{
			$(".running_sheet_check_paid").prop('checked',false);
		}
	})
	$("#check_all_unpaid").on('change',function(e){
		if($("#check_all_unpaid").is(":checked")){
			$(".running_sheet_check_unpaid").prop('checked',true);
		}
		else{
			$(".running_sheet_check_unpaid").prop('checked',false);
		}
	})
})
$(".removeGSTapproval").on('change',function(e){
	    var id = $(this).attr('data-orderId');
		if($(this).is(":checked")){
		    $(this).prop('checked',true);
			var status = 1;
		}
		else{
		    $(this).prop('checked',false);
		 var status = 0;
		}
		console.log("id"+id)
		console.log("status"+status)
		$.ajax({
			url:"<?php echo base_url();?>index.php/orders/update_GST_status/"+id+"/"+status,
			method:"POST",
			success:function(data){
			}
		});
	});
function download_running(name)
{	
    var running_sheet=[];
    var late_fee_orders=[];


	
if(name=="add_late_fee"){
        var late_fee = $("#late_fee").val();
        	$(".running_sheet_check_unpaid").each(function(){
	      
		if($(this).is(':checked')){
			late_fee_orders.push($(this).prop('id').split('_')[1]);
		}
	    })
	 
	 	late_fee_orders=late_fee_orders.join('.');
	 	
        window.open('<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee);
        
        
    }
	
}

function download_running_paid()
{
	var running_sheet=[];

	$(".running_sheet_check_paid").each(function(){
		if($(this).is(':checked')){
			running_sheet.push($(this).prop('id').split('_')[1]);
		}
	})
	running_sheet=running_sheet.join('.');
	window.open('<?php echo base_url();?>index.php/orders/running_sheet/'+running_sheet);
 
}
function group_mark_paid(){
    
   comment = $("#group_mark_paid_comments").val();
   
    referrer = $("#referrer").val();
    
    var running_sheet=[];
    
      $(".running_sheet_check_unpaid").each(function(){
	      
		if($(this).is(':checked')){
			running_sheet.push($(this).prop('id'));
		}
	})
	 
	 	running_sheet=running_sheet.join('.');
	 	
	 
	    
       window.open('<?php echo base_url();?>index.php/orders/group_mark_as_paid/'+running_sheet+'/'+comment+'/'+referrer);
    
}
function download_running_unpaid(name)
{
	var running_sheet=[];
	
	if(name=="mark_paid"){
	    
          $("#group_mark_paid_modal").modal('show');
	    
	  
    }else{
	$(".running_sheet_check_unpaid").each(function(){
		if($(this).is(':checked')){
			running_sheet.push($(this).prop('id').split('_')[1]);
		}
	})
	running_sheet=running_sheet.join('.');
	window.open('<?php echo base_url();?>index.php/orders/running_sheet/'+running_sheet);
}
}
function reorder(order_id){
	$("#reorder_id").val(order_id);
	$("#reorder_modal").modal('show');
}
function resend_mail(order_id,referrer){
    
    $("#resend_email_modal").modal('show');
    $("#resend_mail_id").val(order_id);
    $("#resend_mail_referrer").val(referrer);
    

}
function mark_paid_trigger(order_id,referrer,ofrom){
    
			$("#mark_paid_id").val(order_id);
			$("#mark_paid_referrer").val(referrer);
			$("#mark_paid_order_made_from").val(ofrom);
			$("#mark_paid_modal").modal('show');
		}
		
	function delete_order(order_id,referrer,ofrom){
			$("#delete_order_id").val(order_id);
			$("#delete_order_referrer").val(referrer);
			$("#delete_order_order_made_from").val(ofrom);
			$("#delete_order_modal").modal('show');
		}
	

</script>
<script>
    $(document).ready(function() {
    
    <?php if($this->session->flashdata('msg')){ ?>
    alert('<?php echo $this->session->flashdata('msg'); ?>');
    <?php } ?>
});
</script>