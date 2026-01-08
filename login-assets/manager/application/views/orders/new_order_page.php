
<!-- header_End -->
<!-- Content_right -->
<?php

$userId = $this->session->userdata('user_id');
?>
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1>New Order</h1>
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
									New Order
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<form action="<?php echo base_url();?>index.php/orders/new_order" method="POST" id="new_order_form" novalidate>
					<div class="row mb-4">
						<!--Report widget start-->
						<div class="col-6">
							<div class="card card-shadow">
								<div class="card-header">
									<h3 class="card-title">Customer Details</h3>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-md-3">Company</div>
										<div class="col-12 col-md-9">
											<select class="form-control" name="company_id" id="company_id">
												<option value="0" selected disabled>Select Company</option>
												<?php if(!empty($companies)){
													foreach($companies as $company){
														if(!empty($company)&&$pre_company==$company->company_id)
															echo "<option value=\"".$company->company_id."\" selected>".$company->company_name."</option>";
														else echo "<option value=\"".$company->company_id."\">".$company->company_name."</option>";
													}
												}?>
											</select>
										</div>
									</div>
									
								
									<div class="row mt-3">
										<div class="col-12 col-md-3">Department</div>
										<div class="col-12 col-md-9">
											<select class="form-control" name="department_id" id="department_id">
												<option value="0" selected>All Departments</option>
											</select>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Customer</div>
										<div class="col-12 col-md-9">
											<select class="form-control" name="customer_id" id="customer_id">
												<option value="0" selected disabled>Select Customer</option>
											</select>
											<div class="invalid-feedback">Please select a customer</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Phone</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control" name="phone" id="phone" value="<?php echo !empty($pre_phone)?$pre_phone:'';?>">
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Email</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control" name="email" id="email" value="<?php echo !empty($pre_email)?$pre_email:'';?>">
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Cost Centre</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control" name="cost_centre" id="cost_centre" value="<?php echo !empty($pre_cost_centre)?$pre_cost_centre:'';?>">
										</div>
									</div>
									
										<?php 
								
									
									if($userId == 8 || $userId == 9) { ?>
											<div class="row">
										<div class="col-12 col-md-3">Locations</div>
										<div class="col-12 col-md-9">
										
											<select class="form-control" id="locations" name="location_id">
												<option value="0" selected>All Locations</option>
												<?php if(!empty($users)){ 
													foreach($users as $user){
														echo "<option value=\"".$user->user_id."\">".$user->username."</option>";
													}
												}?>
											</select>
										</div>
									</div>
										
										<?php }  ?>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="card card-shadow">
								<div class="card-header">
									<h3 class="card-title">Delivery Details</h3>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-md-3">Delivery Date</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" value="<?php echo !empty($pre_delivery_date_time)?date('Y-m-d',strtotime($pre_delivery_date_time)):'';?>">
											<div class="invalid-feedback">Please enter a delivery date</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Delivery Time</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control timepicker" name="delivery_time" id="delivery_time" value="<?php echo !empty($pre_delivery_date_time)?$pre_delivery_date_time:'';?>">
											<div class="invalid-feedback">Please enter a delivery time</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Delivery Notes</div>
										<div class="col-12 col-md-9">
											<textarea name="delivery_notes" class="form-control"><?php echo !empty($pre_delivery_notes)?$pre_delivery_notes:'';?></textarea>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-12 col-md-3">Shipping Method</div>
										<div class="col-12 col-md-9">
											<label class="control control-solid control-solid-info control--radio">Delivery
												<input type="radio" name="shipping_method" class="shipping_radio" value="1" <?php echo !empty($pre_shipping_method)&&$pre_shipping_method==1?'checked':'';if(empty($pre_shipping_method)) echo 'checked';?>/>
												<span class="control__indicator"></span>
											</label>
											<label class="control control-solid control-solid-info control--radio">Pickup From Store
												<input type="radio" name="shipping_method" class="shipping_radio" value="2" <?php echo !empty($pre_shipping_method)&&$pre_shipping_method==2?'checked':'';?>/>
												<span class="control__indicator"></span>
											</label>
										</div>
									</div>
									<div class="row mt-3 delivery">
										<div class="col-12 col-md-3">Delivery Address</div>
										<div class="col-12 col-md-9"><textarea class="form-control" name="delivery_address" id="delivery_address"><?php echo !empty($pre_delivery_address)?$pre_delivery_address:'';?></textarea></div>
									</div>
									<div class="row mt-3 delivery">
										<div class="col-12 col-md-3">Delivery Fee</div>
										<div class="col-12 col-md-9"><input type="text" name="delivery_fee" id="delivery_fee" class="form-control" value="<?php echo !empty($pre_delivery_fee)?$pre_delivery_fee:''?>">
										<div class="invalid-feedback">Please enter numbers only!</div></div>
									</div>
									<div class="row mt-3 pickup">
										<div class="col-12 col-md-3">Pickup Location</div>
										<div class="col-12 col-md-9">
											<select class="form-control" name="pickup_location" id="pickup_location">
												<option value="0" selected disabled>Select Pickup Location</option>
												<?php if(!empty($stores)){
													foreach($stores as $store){
														if(!empty($pre_pickup_location)&&$pre_pickup_location==$store->location_id)
															echo "<option value=\"".$store->location_id."\" selected>".$store->location_name."</option>";
														else echo "<option value=\"".$store->location_id."\">".$store->location_name."</option>";
													}
												}?>
											</select>
										</div>
									</div>
									<div class="row mt-3 pickup">
										<div class="col-12 col-md-3">Pickup Address</div>
										<div class="col-12 col-md-9" id="pickup_address"></div>
										<input type="hidden"  value="" name="customer_pickup_address" id="customer_pickup_address">
									</div>
									<div class="row mt-3">
										<div class="col-12 text-right">
											<button type="submit" class="btn btn-info">Next Page <i class="fa fa-arrow-circle-right"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Report widget end-->
					</div>
				</form>
			</div>
			<!-- Section_End -->
		</div>
	</div>
</div>
<!-- Content_right_End -->

<script>
$(function(){
    
	 company_map=<?php echo json_encode($companies);?>;
	customer_map=<?php echo json_encode($customers);?>;
	department_map=<?php echo json_encode($departments);?>;
	pickup_locations=<?php echo json_encode($stores);?>;
	
	$(".datepicker").datetimepicker({
		format:'DD-MM-YYYY'
	})
	$(".timepicker").datetimepicker({
		format:'hh:mm a'
	})
	
	$(".pickup").hide();
	$(".shipping_radio").on('change',function(){
		if($(".shipping_radio:checked").val()==1){
			$(".pickup").hide();
			$(".delivery").show();
		}
		else{
			$(".delivery").hide();
			$(".pickup").show();
		}
	})

	
	if($("#company_id").val()!=0){
	    
		for(var i=0;i<customer_map.length;i++){
			if(customer_map[i].company_id==$("#company_id").val()){
				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
			}
		}
	}
	
	
	$("#company_id").on('change',function(){
		for(var i=0;i<company_map.length;i++)
		{
			if(company_map[i].company_id==$(this).val()){
				$("#delivery_address").html(company_map[i].company_address);
			}
		}
	
		
		
		$("#department_id").empty();
		$("#department_id").append("<option value=\"0\" selected>All Departments</option>");
		for(var i=0;i<department_map.length;i++){
		    
		
			console.log($(this).val());
			console.log(department_map[i].company_id);
			
			if(department_map[i].company_id==$(this).val()){
				$("#department_id").append("<option value=\""+department_map[i].department_id+"\">"+department_map[i].department_name+"</option>");
			}
		}
		
		
		//Also customers that don't have a department
		$("#customer_id").empty();
		$("#customer_id").append("<option value=\"0\" selected disabled>Select Customer</option>");
		for(var i=0;i<customer_map.length;i++){
			if(customer_map[i].company_id==$(this).val()){
				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
			}
		}
	})
	$("#department_id").on('change',function(){
		$("#customer_id").empty();
		$("#customer_id").append("<option value=\"0\" selected disabled>Select Customer</option>");
		for(var i=0;i<customer_map.length;i++){
			if(customer_map[i].department==$(this).val()&&customer_map[i].company_id==$("#company_id").val()){
				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
			}
		}
		if($(this).val()==0){
			for(var i=0;i<customer_map.length;i++){
				if(customer_map[i].company_id==$("#company_id").val()){
					if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
						$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
					else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
				}
			}
		}
	})
	$("#customer_id").on('change',function(){
		for(var i=0;i<customer_map.length;i++){
			if($(this).val()==customer_map[i].customer_id){
				$("#phone").val(customer_map[i].telephone);
				$("#email").val(customer_map[i].email);
				$("#cost_centre").val(customer_map[i].customer_cost_centre);
			}
		}
	})
	$("#pickup_location").on('change',function(){
		for(var i=0;i<pickup_locations.length;i++){
			if($(this).val()==pickup_locations[i].location_id){
				$("#pickup_address").html(pickup_locations[i].address);
				$("#customer_pickup_address").val(pickup_locations[i].address);
			}
		}
	})
	$("#new_order_form").on('submit',function(e){
		var flag=0;
		console.log($("#customer_id option").filter(':selected').val())
		$(".is-invalid").removeClass('is-invalid');
		if($("#customer_id option").filter(':selected').val()==0){
			$("#customer_id").addClass('is-invalid');
			flag=1;
		}
		if($.trim($("#delivery_date").val())=='')
		{
			$("#delivery_date").addClass('is-invalid');
			flag=1;
		}
		if($.trim($("#delivery_time").val())=='')
		{
			$("#delivery_time").addClass('is-invalid');
			flag=1;
		}
		var regexp=/^\d*$/;
		if(!regexp.test($("#delivery_fee").val())){
			flag=1;
			$("#delivery_fee").addClass("is-invalid");
		}
		if(flag===1){
			e.preventDefault();
		}
	})
})
</script>