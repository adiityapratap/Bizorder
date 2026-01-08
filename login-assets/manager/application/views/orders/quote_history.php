<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];
$userId = $this->session->userdata('user_id');
?>
<style>
    table#table {
    margin-top: 0 !important;
}
.fixed-table-header {
    display: none !important;
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
							<h1>View Quotes</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Quote</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Quotes
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
									    
									 <!--   <div class="col-12 col-md-2 mb-3">-->
										<!--	<input class="form-control datepicker" id="order_date" type="text" placeholder="Quote Date ">-->
										<!--</div>-->

										<div class="col-12 col-md-2 mb-3">
											<input class="form-control datepicker" id="date_from" type="text" placeholder="Delivery Date From">
										</div>
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control datepicker" id="date_to" type="text" placeholder="Delivery Date To">
										</div>
										<div class="col-12 col-md-2 mb-3">
											<input class="form-control " id="order_id" type="text" placeholder="Quote Id">
										</div>
										<!--<div class="col-12 col-md-2 mb-3">-->
										<!--	<select class="form-control" id="company">-->
										<!--		<option value="0" selected>All Companies</option>-->
												<?php if(!empty($companies)){
													foreach($companies as $company){
												// 		echo "<option value=\"".$company->company_id."\">".$company->company_name."</option>";
													}
												}?>
										<!--	</select>-->
										<!--</div>-->
											<?php if($userId == 8 || $userId == 9) { ?>
											<div class="col-12 col-md-2 mb-3">
										
											<select class="form-control" id="locations">
												<option value="0" selected>All Locations</option>
												<?php if(!empty($users)){
													foreach($users as $user){
														echo "<option value=\"".$user->user_id."\">".$user->username."</option>";
													}
												}?>
											</select>
										
										</div>
										<?php }  ?>
										
										<!--<div class="col-12 col-md-4 mb-3">-->
										<!--	<select class="form-control" id="department">-->
										<!--		<option value="0" selected>All Departments</option>-->
												<?php // if(!empty($departments)){
													// foreach($departments as $department){
													//	echo "<option value=\"".$department->department_id."\">".$department->department_name."</option>";
												//	}
											 //	}?>
										<!--	</select>-->
										<!--</div>-->
										
									
										<div class="col-12 col-md-2 mb-3">
											<select class="form-control" id="customer">
												<option value="0" selected>All Customers</option>
												<?php if(!empty($customers)){
													foreach($customers as $customer){
														echo "<option value=\"".$customer->customer_id."\">".$customer->firstname." ".$customer->lastname."</option>";
													}
												}?>
											</select>
										</div>
										<div class="col-12 col-md-2 mb-3">
											<select class="form-control" id="quote_status">
												<option value="all" selected>Status</option>
												<option value="1">New</option>
												<option value="0">Cancelled</option>
												<option value="8">Rejected</option>
											</select>
										</div>
										<div class="col-auto mb-3">
											<div class="col-12 col-md-1">
												<button class="btn btn-primary">Go</button>
											</div>
										</div>
										<!--<div class="col-12 col-md-2">-->
										<!--	<input class="form-control " id="late_fee" type="text" placeholder="Enter Late Fee">-->
										<!--</div>-->
										<!--<div class="col-12 col-md-2">-->
										<!--	<input class="btn btn-primary" id="late_fee_submit" type="button" onclick="download_running('add_late_fee')" value="Add Late Fee">-->
										<!-- <span class="badge badge-success late_fee_text" style="display:none;font-size: 15px !important;">Late Fee Adeed Succesfully</span>-->
										<!--</div>-->
										
									</div>
									
									<!--<div class="row">-->
									<!--	<div class="col-12 mb-3"><p><strong>Sort By:</strong></p></div>-->
									<!--</div>-->
									<!--<div class="row">-->
									<!--	<div class="col-auto mb-3">-->
									<!--		<label class="control control-solid control--radio control-solid-info">Delivery Date (Ascending)-->
									<!--			<input type="radio" name="sort_order" checked="checked" value="0">-->
									<!--			<span class="control__indicator"></span>-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="col-auto mb-3">-->
									<!--		<label class="control control-solid control--radio control-solid-info">Delivery Date (Descending)-->
									<!--			<input type="radio" name="sort_order" value="1">-->
									<!--			<span class="control__indicator"></span>-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="col-auto mb-3">-->
									<!--		<label class="control control-solid control--radio control-solid-info">Order # (Ascending)-->
									<!--			<input type="radio" name="sort_order" value="2">-->
									<!--			<span class="control__indicator"></span>-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="col-auto mb-3">-->
									<!--		<label class="control control-solid control--radio control-solid-info">Order # (Descending)-->
									<!--			<input type="radio" name="sort_order" value="3">-->
									<!--			<span class="control__indicator"></span>-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="col-auto mb-3">-->
									<!--		<div class="col-12 col-md-1">-->
									<!--			<button class="btn btn-primary">Go</button>-->
									<!--		</div>-->
									<!--	</div>-->
									<!--</div>-->
								</form>
							</div>
						</div>
						<div class="card card-shadow mb-4">
							<div class="table-responsive">
							   
							    
								<table class="table table-sm table-bordered">
									<thead>
										<tr>
										    <th></th>
											<th>Quote ID </th>
											<th>Customer</th>
											<th>Delivery Date &amp; Time</th>
											<th>Balance</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($orders)){
											foreach($orders as $order)
											{
                                         echo "<tr>";
												
										echo "<td><label class=\"control control-solid control-solid-info control--checkbox\"><input type=\"checkbox\" class=\"running_sheet_check\" id=\"backend_".$order->order_id."\"><span class=\"control__indicator\"></span></label></td>";

												echo "<td>".$order->order_id."</td>";
												if($order->customer_order_name != ''){
												    $custName = $order->customer_order_name;
												}else{
												    $custName = $order->firstname." ".$order->lastname;
												}
												echo "<td>".$custName."</td>";
											 echo "<td>". date('d M Y h:i A',strtotime($order->delivery_date_time))."</td>";
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
												
											
											if($order->order_status!=3){	
											    
											echo "<td>$".number_format($order->order_total+$order->late_fee+$delivery_fee-$coupon_discount,2, '.', '')."</td>";					
											}
											else {
											    
											    echo "<td>$0.00</td>";
											}
												
									        if($order->order_status == 1){
											    echo "<td>New</td>";
											}
											if($order->order_status == 0){
											    echo "<td>Cancelled</td>";
											}
											if($order->order_status == 2){
											    echo "<td>Paid</td>";
											}
											if($order->order_status == 7){
											    echo "<td>Approved</td>";
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
										$orders_identity = 'backend';
							echo "<a href=\"".base_url()."index.php/orders/view_quote/".$order->order_id."\" class=\"btn btn-primary btn-sm ml-1 mb-1 m-sm-100\">View</a>";	
								if(($order->order_status==3||$order->order_status==4||$order->order_status==1||$order->order_status==2||$order->order_status==11||$order->order_status==12||$order->order_status==13||$order->order_status==9||$order->order_status==8)){
									echo "<a href=\"".base_url()."index.php/orders/edit_quote/".$order->order_id."/".$order->order_status."?ofrom=".$orders_identity."\" class=\"btn btn-success btn-sm ml-1 mb-1 m-sm-100\">Edit</a>";
													
												}
												// if(($order->order_status==3||$order->order_status==4)){
												// 	echo "<a href=\"".base_url()."index.php/orders/edit_quote/".$order->order_id."/".$order->order_status."?ofrom=".$orders_identity."\" class=\"btn btn-success btn-sm ml-1 mb-1 m-sm-100\">Edit</a>";
												// }
												
                                        echo "<a href=\"".base_url()."index.php/orders/convertToInvoice/".$order->order_id."\" class=\"btn btn-info btn-sm ml-1 mb-1 m-sm-100\">Convert to Invoice</a>";
											
										
											    if($order->order_status != 0){
							            echo "<button class=\"btn btn-danger btn-sm ml-1 mb-1 m-sm-100\" onclick=\"delete_order('".$order->order_id."','".$referrer."','".$orders_identity."')\">Cancel</button>";
											} 
												
												if($order->order_status==1||$order->order_status==8||$order->order_status==9)
												// echo "<button class=\"btn btn-danger btn-sm ml-1 mb-1 m-sm-100\" onclick=\"resend_mail('".$order->order_id."','".$referrer."')\">Approve Mail</button>";
												
												// echo $order->order_status; exit;
											
												
											
												
						
												
												echo "</td>";
												echo "</tr>";
											}
										}?>
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
					<input type="hidden" name="ofrom" id="ORDER_COMMENT_MADE_FROM">
					
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
				<form action="<?php echo base_url();?>index.php/orders/delete_quote" method="POST" id="delete_order_form">
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




<input type="hidden" id="trigger_modal" data-toggle="modal" data-target="#modalTable">

<script>
  var $table = $('#table')

  $(function() {
    $('#modalTable').on('shown.bs.modal', function () {
      $table.bootstrapTable('resetView')
    })
  })

  
$(function(){

		$("#order_filters").on('submit',function(e){
		e.preventDefault();
		if($.trim($("#date_from").val())=='')
			date_from='unset';
		else date_from=$("#date_from").val();
		
// 		if($.trim($("#order_date").val())=='')
			order_date='unset';
// 		else order_date=$("#order_date").val();
		
		
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
		
		if($.trim($("#quote_status").val())=='')
			quote_status='unset';
		else quote_status=$("#quote_status").val();
		
		if($.trim($("#order_id").val())=='')
			order_id='unset';
		else order_id=$("#order_id").val();
		sort_order=$("[name='sort_order']:checked").val();
		
		
		//If current page is order_history
		if(window.location.href.indexOf('order_history')!=-1)
			window.location.href="<?php echo base_url();?>index.php/orders/quote_history/"+date_from+"/"+date_to+"/"+order_date+"/"+company+"/"+department+"/"+customer+"/"+quote_status+"/"+sort_order+"/"+order_id+"/"+$("#locations").val();
		else
			window.location.href="<?php echo base_url();?>index.php/orders/quote_history/"+date_from+"/"+date_to+"/"+order_date+"/"+company+"/"+department+"/"+customer+"/"+quote_status+"/"+sort_order+"/"+order_id+"/"+$("#locations").val();
	})
	
	$("#check_all").on('change',function(e){
		if($("#check_all").is(":checked")){
			$(".running_sheet_check").prop('checked',true);
		}
		else{
			$(".running_sheet_check").prop('checked',false);
		}
	});
	
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
	
})
function download_running(name)
{	
    var running_sheet=[];
    var late_fee_orders=[];


	
	if(name=="mark_paid"){
	    
          $("#group_mark_paid_modal").modal('show');
	    
	  
    }else if(name=="add_late_fee"){
        var late_fee = $("#late_fee").val();
        	$(".running_sheet_check").each(function(){
	      
		if($(this).is(':checked')){
			late_fee_orders.push($(this).prop('id').split('_')[1]);
		}
	    })
	 
	 	late_fee_orders=late_fee_orders.join('.');
        
        $.ajax({
		url:'<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee,
		method:"POST",
		success:function(data){
		    
$(".late_fee_text").show();
$(".late_fee_text").fadeOut(3000);
         }
	})
        
        
        
	 	
        // window.open('<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee);
        
        
    }else{
        $(".running_sheet_check").each(function(){
	      
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

		
function order_comment(order_id,referrer,ofrom){
			$("#order_comment_id").val(order_id);
			$("#order_comment_referrer").val(referrer);
			$("#order_comment_made_from").val(ofrom);
			$("#order_comment_modal").modal('show');
		}	
	
		
		function delete_order(order_id,referrer,ofrom){
			$("#delete_order_id").val(order_id);
			$("#delete_order_referrer").val(referrer);
			$("#delete_order_order_made_from").val(ofrom);
			$("#delete_order_modal").modal('show');
		}
</script>
