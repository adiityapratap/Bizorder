
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
							<h1>Customers</h1>
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
									Customers
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
					<div class="col-12 col-md-4" id="almost_top">
						<div class="card card-shadow mb-4">
							<div class="card-header">
								<h3>Step 1: Pick a Company</h3>
							</div>
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-12">
										<input type="text" id="search_company" class="form-control" placeholder="Search for company">
									</div>
								</div>
								<div class="list-group">
									<button class="list-group-item list-group-item-action bg-info text-white" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
										New Company
									</button>
									<div class="collapse" id="collapseExample">
										<div class="card card-body">
											<form action="<?php echo base_url();?>index.php/general/new_company" method="POST">
												<div class="row">
													<div class="col-12">
														<label class="control-label">Company Name</label>
														<input type="text" class="form-control mb-3" name="company_name" required>
													</div>
													<div class="col-12">
														<label class="control-label">Company ABN</label>
														<input type="text" class="form-control mb-3" name="company_abn">
													</div>
													<div class="col-12">
														<label class="control-label">Company Phone</label>
														<input type="text" class="form-control mb-3" name="company_phone">
													</div>
													<div class="col-12">
														<label class="control-label">Company Address</label>
														<textarea class="form-control" name="company_address"></textarea>
													</div>
													<div class="col-12"><input type="submit" class="btn btn-info" value="Add"></div>
												</div>
											</form>
										</div>
									</div>
									<?php if(!empty($companies)){
									    
									   // echo "<pre>";
									   // print_r($companies);
									   // exit;
										foreach($companies as $company){
											$data=$company->company_phone;
											if(  preg_match( '/^(\d{4})(\d{3})(\d{3})$/', $data,  $matches ) )
											{
												$phone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
											}
											else if(  preg_match( '/^(\d{3})(\d{3})(\d{3})$/', $data,  $matches ) )
											{
												$phone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
											}
											else if(  preg_match( '/^(\d{2})(\d{2})(\d{2})$/', $data,  $matches ) )
											{
												$phone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3];
											}
											else if(  preg_match( '/^(\d{4})(\d{4})$/', $data,  $matches ) )
											{
												$phone = $matches[1] . ' ' .$matches[2];
											}
											else $phone=$company->company_phone;
											echo "<button class=\"list-group-item list-group-item-action company ".$company->company_name."\" onclick=\"select_company(".$company->company_id.")\" id=\"company_button_".$company->company_id."\"> <strong>".$company->company_name."</strong><br><i class=\"fa fa-phone\"></i> ".$phone."<br><i class=\"fa fa-building\"></i> ".$company->company_address." <button class=\"btn btn-sm company ".$company->company_name." btn-info\" onclick=\"edit_company(".$company->company_id.")\">Edit ".$company->company_name."</button></button>";
										}
									}?>
								</div>
							</div>
						</div>
					</div>
					<div id="department_card" class="col-12 col-md-4">
						<div class="col-12">
							<div class="card card-shadow mb-4">
								<div class="card-header">
									<a href="#department_card" id="department_trigger"><h3>Step 2: Pick a Department</h3></a>
								</div>
								<div class="card-body">
									<div class="list-group" id="department_grid">
									    
									    
									    <div class="row mb-3"><div class="col-12"><input type="text" id="search_department" class="form-control" placeholder="Search for Department"></div></div>
										<?php if(!empty($departments)){
											foreach($departments as $department){
												echo "<button class=\"list-group-item list-group-item-action department ".$department->department_name."\" onclick=\"select_department(".$department->company_id.",".$department->department_id.")\" id=\"department_button_".$department->department_id."\"><strong>".$department->department_name."</strong></button>";
											}
										}?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="customer_card" class="col-12 col-md-4">
						<div class="col-12">
							<div class="card card-shadow mb-4">
								<div class="card-header">
									<a href="#customer_card" id="customer_trigger"><h3>Step 3: Pick a Customer</h3></a>
								</div>
								<div class="card-body">
									<div class="list-group" id="customer_grid">
									    
									    	<div class="row mb-3"><div class="col-12"><input type="text" id="search_customer" class="form-control" placeholder="Search for Customer"></div></div>
										<?php if(!empty($customers)){
											foreach($customers as $customer){
												echo "<button class=\"list-group-item list-group-item-action customer ".$customer->firstname.$customer->lastname."\"> <strong>".$customer->firstname." ".$customer->lastname."</strong><br><i class=\"fa fa-phone\"></i> ".(empty($customer->telephone)?'':$customer->telephone)."<br><i class=\"fa fa-envelope\"></i> ".(empty($customer->email)?'':$customer->email)."<button class=\"btn btn-info btn-sm ".$customer->firstname.$customer->lastname." customer\" onclick=\"edit_customer(".$customer->customer_id.")\">View/Edit ".$customer->firstname."</button></button>";
											}
										}?>
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

<div class="modal fade rounded-0 border-0" id="dept_modal" tabindex="-1" role="dialog" aria-labelledby="dept_modal_title" aria-hidden="true">
<div class="modal-dialog rounded-0 border-0" role="document">
	<div class="modal-content rounded-0 border-0">
		<div class="modal-header bg-info rounded-0">
			<h5 class="modal-title text-white" id="customer_modal_title"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="dept_info">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-bank"></i></span>
					<input type="hidden" class="form-control" name="dept_id" id="dept_id" placeholder="department">
					<input type="text" class="form-control" name="dept_name" id="dept_name" placeholder="department">
				</div>
			
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				Close
			</button>
			<button type="button" class="btn btn-primary" onclick="update_dept()">
				Save changes
			</button>
		</div>
	</div>
</div>
</div>



<div class="modal fade rounded-0 border-0" id="customer_modal" tabindex="-1" role="dialog" aria-labelledby="customer_modal_title" aria-hidden="true">
<div class="modal-dialog rounded-0 border-0" role="document">
	<div class="modal-content rounded-0 border-0">
		<div class="modal-header bg-info rounded-0">
			<h5 class="modal-title text-white" id="customer_modal_title"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="customer_info">
			    
			    <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-profile"></i></span>
					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
				</div>
				</br>
				
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-profile"></i></span>
					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
				</div>
				
				</br>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
					<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
				</div>
				</br>
				<div class="input-group mt-3">
					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					<input type="email" class="form-control" name="email" id="email" placeholder="Email">
				</div>
				<div class="input-group mt-3">
					<span class="input-group-addon"><i class="fa fa-bank"></i></span>
					<input type="text" class="form-control" name="cost_centre" id="cost_centre" placeholder="Cost Centre">
				</div>
				<input type="hidden" name="customer_id" id="customer_id">
				
				<div class="input-group mt-3">
					<span<label>Activate</span>
					<input type="checkbox" class="form-controll" name="customer_status" id="customer_status" value="1">
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				Close
			</button>
			<button type="button" class="btn btn-primary" onclick="update_customer()">
				Save changes
			</button>
		</div>
	</div>
</div>
</div>
<div class="modal fade rounded-0 border-0" id="company_modal" tabindex="-1" role="dialog" aria-labelledby="company_modal_title" aria-hidden="true">
    
    
    
   
<div class="modal-dialog rounded-0 border-0" role="document">
	<div class="modal-content rounded-0 border-0">
		<div class="modal-header bg-info rounded-0">
			<h5 class="modal-title text-white" id="company_modal_title"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="company_info">
			    
			    	<div class="input-group">
					<span class="input-group-addon">Name</span>
					<input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
				</div>
				</br>
				<div class="input-group">
					<span class="input-group-addon">ABN</span>
					<input type="text" class="form-control" name="abn" id="abn" placeholder="ABN">
				</div>
				<div class="input-group mt-3">
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
					<input type="email" class="form-control" name="company_phone" id="company_phone" placeholder="Phone">
				</div>
				<div class="input-group mt-3">
					<span class="input-group-addon"><i class="fa fa-building"></i></span>
					<textarea name="company_address" class="form-control" id="company_address"></textarea>
				</div>
				<input type="hidden" name="company_id" id="company_id">
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				Close
			</button>
			<button type="button" class="btn btn-primary" onclick="update_company()">
				Save changes
			</button>
		</div>
	</div>
</div>
</div>
<script>
$(document).on('click', 'a[href^="#"]', function(e) {
	// target element id
	var id = $(this).attr('href');
	console.log(id);
	// target element
	var $id = $(id);
	if ($id.length === 0) {
		return;
	}

	// prevent standard hash navigation (avoid blinking in IE)
	e.preventDefault();

	// top position relative to the document
	var pos = $id.offset().top;

	// animated top scrolling
	$('body, html').animate({scrollTop: pos});
});
$(function(){
	company_map=<?php echo json_encode($companies);?>;
	
	
	department_map=<?php echo json_encode($departments);?>;

	customer_map=<?php echo json_encode($customers);?>;

	$("#search_company").on('keyup',function(){
		if($.trim($("#search_company").val())!=''){
			$(".company").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_company").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".company").show();
	})
	
		$("#search_department").on('keyup',function(){
		if($.trim($("#search_department").val())!=''){
			$(".department").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_department").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".department").show();
	})
	$("#search_customer").on('keyup',function(){
		if($.trim($("#search_customer").val())!=''){
			$(".customer").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_customer").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".customer").show();
	})
})
function select_company(company_id){
    
    department_map=<?php echo json_encode($departments);?>;
	//Remove active marker from company list
	$("#almost_top").find('.active').removeClass('active');
	//Add active 
	$("#company_button_"+company_id).addClass('active');
	//Clear other departments
	$("#department_grid").empty();
	//Clear other customers
	$("#customer_grid").empty();
	//First element will be new department element
	var new_dep="<div class=\"row mb-3\"><div class=\"col-12\"><input type=\"text\" id=\"search_department\" class=\"form-control\" placeholder=\"Search for Department\"></div></div>";
	new_dep+="<button class=\"list-group-item list-group-item-action bg-info text-white\" type=\"button\" data-toggle=\"collapse\" data-target=\"#department_collapse\" aria-expanded=\"false\" aria-controls=\"department_collapse\">New Department</button><div class=\"collapse\" id=\"department_collapse\"><div class=\"card card-body\"><form action=\"<?php echo base_url();?>index.php/general/new_department/"+company_id+"\" method=\"POST\"><div class=\"row\"><div class=\"col-12\"><label class=\"control-label\">Department Name</label><input type=\"text\" class=\"form-control mb-3\" name=\"department_name\" required></div><div class=\"col-12\"><input type=\"submit\" class=\"btn btn-info\" value=\"Add\"></div></div></form></div></div>";
	$("#department_grid").append(new_dep);
	for(var i=0;i<department_map.length;i++){
	    
		if(department_map[i].company_id==company_id){
			var elem="<button class=\"list-group-item list-group-item-action department "+department_map[i].department_name+"\" onclick=\"select_department("+company_id+","+department_map[i].department_id+")\" id=\"department_button_"+department_map[i].department_id+"\"> <strong>"+department_map[i].department_name+"</strong><button class=\"btn btn-info btn-sm\" onclick=\"edit_department("+department_map[i].department_id+")\">View/Edit "+department_map[i].department_name+"</button></button>";
			$("#department_grid").append(elem);
		}
	}
	var new_cust="<div class=\"row mb-3\"><div class=\"col-12\"><input type=\"text\" id=\"search_customer\" class=\"form-control\" placeholder=\"Search for Customer\"></div></div>";
	new_cust+="<button class=\"list-group-item list-group-item-action bg-info text-white\" type=\"button\" data-toggle=\"collapse\" data-target=\"#customer_collapse\" aria-expanded=\"false\" aria-controls=\"customer_collapse\">New Customer</button><div class=\"collapse\" id=\"customer_collapse\"><div class=\"card card-body\"><form action=\"<?php echo base_url();?>index.php/general/new_customer/"+company_id+"\" method=\"POST\"><div class=\"row\"><div class=\"col-12\"><label class=\"control-label\">First Name</label><input type=\"text\" class=\"form-control mb-3\" name=\"firstname\" required></div><div class=\"col-12\"><label class=\"control-label\">Last Name</label><input type=\"text\" class=\"form-control mb-3\" name=\"lastname\" required></div><div class=\"col-12\"><label class=\"control-label\">Cost Centre</label><input type=\"text\" class=\"form-control mb-3\" name=\"cost_centre\"></div><div class=\"col-12\"><label class=\"control-label\">Email</label><input type=\"email\" class=\"form-control mb-3\" name=\"email\"></div><div class=\"col-12\"><label class=\"control-label\">Phone</label><input type=\"text\" class=\"form-control mb-3\" name=\"phone\"></div><div class=\"col-12\"><label class=\"control-label\">Fax</label><input type=\"text\" class=\"form-control mb-3\" name=\"fax\"></div><div class=\"col-12\"><label class=\"control-label\">Address</label><input type=\"text\" class=\"form-control mb-3\" name=\"address\"></div><div class=\"col-12\"><input type=\"submit\" class=\"btn btn-info\" value=\"Add\"></div></div></form></div></div>";
	$("#customer_grid").append(new_cust);
	for(var i=0;i<customer_map.length;i++){
		if(customer_map[i].company_id==company_id){
			var elem="<button class=\"list-group-item list-group-item-action customer "+customer_map[i].firstname+customer_map[i].lastname+"\"> <strong>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</strong><br><i class=\"fa fa-phone\"></i> "+(customer_map[i].telephone===null?'':customer_map[i].telephone)+"<br><i class=\"fa fa-envelope\"></i> "+(customer_map[i].email===null?'':customer_map[i].email)+"<button class=\"btn btn-info btn-sm\" onclick=\"edit_customer("+customer_map[i].customer_id+")\">View/Edit "+customer_map[i].firstname+"</button></button>";
			$("#customer_grid").append(elem);
		}
	}
	$("#department_trigger").trigger('click');
	$("#search_department").on('keyup',function(){
		if($.trim($("#search_department").val())!=''){
			$(".department").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_department").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".department").show();
	})
	$("#search_customer").on('keyup',function(){
		if($.trim($("#search_customer").val())!=''){
			$(".customer").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_customer").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".customer").show();
	})
}
function select_department(company_id,department_id){
	$("#customer_grid").empty();
	$("#department_grid").find('.active').removeClass('active');
	$("#department_button_"+department_id).addClass('active');
	var new_cust="<div class=\"row mb-3\"><div class=\"col-12\"><input type=\"text\" id=\"search_customer\" class=\"form-control\" placeholder=\"Search for Customer\"></div></div>";
	new_cust+="<button class=\"list-group-item list-group-item-action bg-info text-white\" type=\"button\" data-toggle=\"collapse\" data-target=\"#customer_collapse\" aria-expanded=\"false\" aria-controls=\"customer_collapse\">New Customer</button><div class=\"collapse\" id=\"customer_collapse\"><div class=\"card card-body\"><form action=\"<?php echo base_url();?>index.php/general/new_customer/"+company_id+"/"+department_id+"\" method=\"POST\"><div class=\"row\"><div class=\"col-12\"><label class=\"control-label\">First Name</label><input type=\"text\" class=\"form-control mb-3\" name=\"firstname\" required></div><div class=\"col-12\"><label class=\"control-label\">Last Name</label><input type=\"text\" class=\"form-control mb-3\" name=\"lastname\" required></div><div class=\"col-12\"><label class=\"control-label\">Cost Centre</label><input type=\"text\" class=\"form-control mb-3\" name=\"cost_centre\"></div><div class=\"col-12\"><label class=\"control-label\">Email</label><input type=\"email\" class=\"form-control mb-3\" name=\"email\"></div><div class=\"col-12\"><label class=\"control-label\">Phone</label><input type=\"text\" class=\"form-control mb-3\" name=\"phone\"></div><div class=\"col-12\"><label class=\"control-label\">Fax</label><input type=\"text\" class=\"form-control mb-3\" name=\"fax\"></div><div class=\"col-12\"><label class=\"control-label\">Address</label><input type=\"text\" class=\"form-control mb-3\" name=\"address\"></div><div class=\"col-12\"><input type=\"submit\" class=\"btn btn-info\" value=\"Add\"></div></div></form></div></div>";
	$("#customer_grid").append(new_cust);
	for(var i=0;i<customer_map.length;i++){
		if(customer_map[i].department==department_id&&customer_map[i].company_id==company_id){
			var elem="<button class=\"list-group-item list-group-item-action customer "+customer_map[i].firstname+customer_map[i].lastname+"\"> <strong>"+customer_map[i].firstname+" "+customer_map[i].lastname+"</strong><br><i class=\"fa fa-phone\"></i> "+(customer_map[i].telephone===null?'':customer_map[i].telephone)+"<br><i class=\"fa fa-envelope\"></i> "+(customer_map[i].email===null?'':customer_map[i].email)+"<button class=\"btn btn-info btn-sm\" onclick=\"edit_customer("+customer_map[i].customer_id+")\">View/Edit "+customer_map[i].firstname+"</button></button>";
			$("#customer_grid").append(elem);
		}
	}
	$("#customer_trigger").trigger('click');
	$("#search_customer").on('keyup',function(){
		if($.trim($("#search_customer").val())!=''){
			$(".customer").each(function(){
				if($(this).attr('class').split(' ')[3].toLowerCase().indexOf($("#search_customer").val().toLowerCase())==-1)
					$(this).hide();
				else $(this).show();
			})	
		}
		else $(".customer").show();
	})
}
function edit_customer(customer_id){
	$("#customer_modal_title").html('');
	$("#customer_id").val('');
	$("#phone").val('');
	$("#email").val('');
	$("#cost_centre").val('');
	$("#first_name").val('');
	$("#last_name").val('');
	
	
	
	for(var i=0;i<customer_map.length;i++){
	    
		if(customer_map[i].customer_id==customer_id){
		    
			$("#customer_modal_title").html(customer_map[i].firstname+" "+customer_map[i].lastname);
			$("#customer_id").val(customer_map[i].customer_id);
			
			$("#first_name").val(customer_map[i].firstname);
			$("#last_name").val(customer_map[i].lastname);
		
			
			
			$("#phone").val(customer_map[i].telephone);
			$("#email").val(customer_map[i].email);
			$("#cost_centre").val(customer_map[i].customer_cost_centre);
// 			$("#customer_status").val(customer_map[i].status);
			
			if(customer_map[i].status == 1){
        $("#customer_status").attr("checked", "checked");
    }
			$("#customer_modal").modal('show');
		}
	}
}

function edit_department(department_id){


	$("#dept_name").val('');

	for(var i=0;i<department_map.length;i++){
	    
		if(department_map[i].department_id==department_id){
		    
			$("#dept_name").val(department_map[i].department_name);
			$("#dept_id").val(department_map[i].department_id);
			
			$("#dept_modal").modal('show');
		}
	}
	
	$("#dept_modal").modal('show');
}


function update_dept(){
    
    
    
    
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/update_dept',
		method:"POST",
		data:$("#dept_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}



function update_customer(){
    
    
    
    
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/update_customer',
		method:"POST",
		data:$("#customer_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}
function edit_company(company_id)
{
    
    
    
	$("#company_modal_title").html('');
	$("#company_id").val('');
		$("#company_name").val('');
	$("#company_phone").val('');
	$("#company_address").html('');
	$("#abn").val('');
	
	
	for(var i=0;i<company_map.length;i++){
		if(company_map[i].company_id==company_id){
			$("#company_modal_title").html(company_map[i].company_name);
			$("#company_name").val(company_map[i].company_name);
			$("#company_id").val(company_map[i].company_id);
			$("#company_phone").val(company_map[i].company_phone);
			$("#company_address").html(company_map[i].company_address);
			$("#abn").val(company_map[i].company_abn);
			$("#company_modal").modal('show');
		}
	}
}
function update_company(){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/update_company',
		method:"POST",
		data:$("#company_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}
</script>