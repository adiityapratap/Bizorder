
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
							<h1>New Quote</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Quote</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									New Quote
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
			   
				<form action="<?php echo base_url();?>index.php/orders/new_quote_save" method="POST" id="new_order_form" novalidate>
					<div class="row mb-4">
						<!--Report widget start-->
						<div class="col-lg-6 col-sm-12 col-12 mb-4">
							<div class="card card-shadow">
								<div class="card-header">
									<h3 class="card-title">Customer Details</h3>
									<button type="button" class="btn btn-primary" onclick="add_customer()" style="float:right">Add Customer</button>
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
									
								    <input type="hidden" name="customer_from" id="customerFrom">
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
								
									<?php if($userId == 1){  ?>
											<div class="row mt-3">
										<div class="col-12 col-md-3">Locations</div>
										<div class="col-12 col-md-9">
										
											<select class="form-control" id="locations" name="location_id">
												<option value="0" selected>All Locations</option>
												<?php if(!empty($users)){ 
													foreach($users as $user){
													 if($user->user_id == 1 || $user->user_id == 2){
											echo "<option value=\"".$user->user_id."\">".ucfirst($user->login_username)."</option>";
													    }
													}
												}?>
											</select>
										</div>
									</div>
									<?php } ?>
										
									
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-sm-12 col-12 mb-4">
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
										<div class="col-12 col-md-3">Account Email</div>
										<div class="col-12 col-md-9">
										   	<input type="text" class="form-control" name="accounts_email" id="accounts_email" value="<?php echo !empty($accounts_email)?$accounts_email:'';?>"> 
										
										</div>
									</div>
										<div class="row mt-3">
										<div class="col-12 col-md-3">Delivery Contact Number</div>
										<div class="col-12 col-md-9">
											<input type="text" class="form-control " placeholder="Delivery contact" name="delivery_contact" id="delivery_contact" value="<?php echo !empty($delivery_contact)?$delivery_contact:'';?>">
											<div class="invalid-feedback">Please enter delivery contact</div>
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
										<div class="col-12 col-md-9"><textarea class="form-control" name="delivery_address" id="delivery_address" rows="4">
										<?php echo !empty($pre_delivery_address)?$pre_delivery_address :'
Gate Number : 
Building Number :
Level :
Room Number/Name :';?></textarea></div>
									</div>
									<div class="row mt-3 delivery">
										<div class="col-12 col-md-3">Delivery Fee</div>
										<div class="col-12 col-md-9">
										    	<select class="form-control" name="delivery_fee" id="delivery_fee">
												<option value="" selected>-- Select delivery fee--</option>
												<option value="25" <?php echo !empty($pre_delivery_fee) && $pre_delivery_fee == 25 ? 'selected':'' ?>>$25.00</option>
												<option value="65" <?php echo !empty($pre_delivery_fee) && $pre_delivery_fee == 65 ? 'selected':'' ?>>$65.00</option>
												</select>
										</div>
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
												<div class="invalid-feedback">Please select branch</div>
										</div>
									</div>
									<div class="row mt-3 pickup">
										<div class="col-12 col-md-3">Pickup Address</div>
										<div class="col-12 col-md-9" id="pickup_address"></div>
										<input type="hidden"  value="" name="customer_pickup_address" id="customer_pickup_address">
									</div>
									<div class="row mt-3">
										<div class="col-12 text-right">
											<button type="submit" class="btn btn-info">Proceed <i class="fa fa-arrow-circle-right"></i></button>
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
<div class="modal fade rounded-0 border-0" id="customer_new_modal" tabindex="-1" role="dialog" aria-labelledby="customer_new_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0" style="display: inline; background-color: #464497 !important;">
    			<h7 class="modal-title text-white" id="customer_new_modal_title">Company and Department not listed ? Click button below.</h7>
    			  </br></br>
    			 <button type="button" class="btn btn-success" onclick="add_new_company()"><i class="fa fa-plus icon-padding"></i>Add Company</button>
    			 <button type="button" class="btn btn-danger" onclick="add_new_department()"><i class="fa fa-plus icon-padding"></i>Add Department</button>
    		</div>
    		 <?php $redirectURL = 'orders/new_quote'; $encoded = base64_encode(urlencode($redirectURL)); ?>
    		<form action="<?php echo base_url();?>index.php/general/add_new_customer/<?php echo $encoded; ?>" id="addNewCustomerForm" method="POST">
        		<div class="modal-body">
        		     <div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-building"></i></span>
        					<select class="form-control" name="user_id" id="user_id-input" required>
        					    <option value="">Select Location</option>
        					  <option value="1">Bendigo</option>
        					  <option value="2">Latrobe</option>
        					  <option value="3">Werribee</option>
        				    </select>
        				</div> 
        			    <div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-building"></i></span>
        					<select class="form-control companyIDList" name="company_id" id="company_id-input" onchange="fetch_departments(this)" required>
        					 
        					 <?php if(!empty($companies)){ ?> 
        					     <option value="">Select Company</option>
        					    <?php foreach($companies as $comp){ ?>
        					    <option value="<?php echo $comp->company_id; ?>"><?php echo $comp->company_name; ?></option>
        					 <?php } }else{ ?>
        					 <option value="">No Company Found</option>
        					 <?php } ?>
        				    </select>
        				</div> 
        				
        				<div class="input-group mt-3 department_wrap-input" style="display:none;" >
        					<span class="input-group-addon"><i class="fa fa-building"></i></span>
        					<select class="form-control deptList" name="department_id" id="department_id-input">
        				    </select>
        				</div> 
        				<div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-user"></i></span>
        					<input type="text" class="form-control" name="firstname" id="first_name-input" placeholder="First Name">
        				</div>
        				<div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-user"></i></span>
        					<input type="text" class="form-control" name="lastname" id="last_name-input" placeholder="Last Name">
        				</div>
        				
        				<div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
        					<input type="text" class="form-control" name="phone" id="phone-input" placeholder="Phone">
        				</div>
        				<div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        					<input type="email" class="form-control" name="email" id="email-input" placeholder="Email">
        					<div class="invalid-feedback" >Customer with this email already exist</div>
        				</div>
        			
        			
        		
        		</div>
        		<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">
        				Close
        			</button>
        			<button type="button" class="btn btn-primary" onclick="addNewCustomerForm()">
        				Save changes
        			</button>
        		</div>
    		</form>
    	</div>
    </div>
</div>

	<div class="modal fade rounded-0 border-0" id="new_company_modal" tabindex="-1" role="dialog" aria-labelledby="new_company_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0">
    			<h5 class="modal-title text-white" id="new_company_modal_title">Add Company</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    			<form id="new_company_info">
    			    
    			    	<div class="input-group">
    					<span class="input-group-addon">Name</span>
    					<input type="text" class="form-control"  name="company_name" id="newCompany" placeholder="Company Name">
    				</div>
    				</br>
    				<div class="input-group">
    					<span class="input-group-addon">ABN</span>
    					<input type="text" class="form-control" name="abn"  id="newCompanyAbn" placeholder="ABN">
    				</div>
    				<div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
    					<input type="email" class="form-control" name="company_phone" placeholder="Phone">
    				</div>
    				<div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-building"></i></span>
    					<textarea name="company_address" class="form-control" ></textarea>
    				</div>
    			
    			</form>
    		</div>
    		<div class="modal-footer">
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">
    				Cancel
    			</button>
    			<button type="button" class="btn btn-primary saveCompany" onclick="save_new_company()">
    				Add
    			</button>
    		</div>
    	</div>
    </div>

</div>
 <div class="modal fade rounded-0 border-0" id="new_department_modal" tabindex="-1" role="dialog" aria-labelledby="new_department_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0">
    			<h5 class="modal-title text-white" id="new_department_modal_title">New Department</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    			<form id="new_department_info">
    			    
    			    <div class="input-group">
    					<span class="input-group-addon">Company</span>
    					<select class="form-control companyIDList" name="company_id" id="newDeptComp">
    					    <?php if(!empty($companies)){
								foreach($companies as $company){ ?>
								<option value="<?php echo $company->company_id; ?>"><?php echo $company->company_name; ?></option>
							<?php } }?>
    					</select>
    				</div>
    				<div class="input-group mt-3">
    					<span class="input-group-addon">Department Name</span>
    					<input type="text" class="form-control" name="department_name" id="newDept" placeholder="department Name">
    				</div>
    				</br>
    				
    			</form>
    		</div>
    		<div class="modal-footer">
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">
    				Close
    			</button>
    			<button type="button" class="btn btn-primary saveDepartment" onclick="save_new_department()">
    				Add
    			</button>
    		</div>
    	</div>
    </div>
</div>

<script>
$(function(){
    
	 company_map=<?php echo json_encode($companies);?>;
	customer_map=<?php echo json_encode($customers);?>;
	department_map=<?php echo json_encode($departments);?>;
	pickup_locations=<?php echo json_encode($stores);?>;
	
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
// 		for(var i=0;i<company_map.length;i++)
// 		{
// 			if(company_map[i].company_id==$(this).val()){
// 				$("#delivery_address").html(company_map[i].company_address);
// 			}
// 		}

		$("#department_id").empty();
		$("#department_id").append("<option value=\"0\" selected>All Departments</option>");
		for(var i=0;i<department_map.length;i++){
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
		    if(typeof customer_map[i].department_id === 'undefined') {
		        // because in frontend customer db we have column name as department_id and in backend we have it department
           if((customer_map[i].department==$(this).val()&&customer_map[i].company_id==$("#company_id").val()) || (customer_map[i].department_id==$(this).val())){
    				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
    					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    			}
          }else if(customer_map[i].department != ''){
    			if(customer_map[i].department_id==$(this).val()&&customer_map[i].company_id==$("#company_id").val()){
    				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
    					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    			}
		    }else{
		        if(customer_map[i].department==$(this).val()&&customer_map[i].company_id==$("#company_id").val()){
    				if($.trim(<?php echo empty($pre_customer)?"''":$pre_customer;?>)!=''&&<?php echo empty($pre_customer)?"''":$pre_customer;?>==customer_map[i].customer_id)
    					$("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\" selected>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    				else $("#customer_id").append("<option value=\""+customer_map[i].customer_id+"\">"+customer_map[i].firstname+" "+customer_map[i].lastname+"</option>");
    			}
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
				$("#customerFrom").val(customer_map[i].customer_from);
				// $("#cost_centre").val(customer_map[i].customer_cost_centre);
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
		if($.trim($("#delivery_contact").val())=='')
		{
			$("#delivery_contact").addClass('is-invalid');
			flag=1;
		}
		console.log("loccc",$('#locations').val())
		if($('#locations').val() == '0'){
        $("#locations").addClass('is-invalid');
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
function fetchCompaniesAndDepartment(){
     
     $.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCompaniesAndDepartment',
		method:"GET",
		success:function(data){
		    data = JSON.parse(data);
		    company_map = data['companies']
		    department_map = data['departments'];
		   
		   
		    let options = '<option value="" >Select Company</option>';
		    let deptOptions = '<option value="" >Select Department</option>';;
		    company_map.map((compDetails)=>{
		      options +='<option value="'+compDetails.company_id+'">'+compDetails.company_name+'</option>'  
		    });
		     department_map.map((deptDetails)=>{
		      deptOptions +='<option value="'+deptDetails.department_id+'">'+deptDetails.department_name+'</option>'  
		    });
		     console.log("deptOptions=",deptOptions);
		    
		   $("#company_id-input").html('');
		   $("#department_id-input").html('');
		   $(".companyIDList").html(options);
		   $(".deptList").html(deptOptions);
		    
		    $("#new_company_modal").modal('hide');
		    $("#new_department_modal").modal('hide');
		   $("#customer_new_modal").modal('show');
// 			location.reload();
		}
	})
 }
function fetch_departments(obj){
    var company_id = $(obj).val();
    var htmlOpt = '<option>Select Department</option>';
    var checkFlag=0;
    for(var i=0;i<department_map.length;i++){
	    
		if(department_map[i].company_id==company_id){
		    checkFlag=1;
		htmlOpt += '<option value="'+department_map[i].department_id+'">'+department_map[i].department_name+'</option>';
			
		}
	}
	if(checkFlag == 1){
	    $("#department_id-input").html(htmlOpt);
	    $(".department_wrap-input").css('display','flex');
	}else{
	    $("#department_id-input").html('<option value="">No department found</option>');
	    $(".department_wrap-input").css('display','none');
	}
	
}

</script>