<?php 
$userId = $this->session->userdata('user_id');
$is_customer = $this->session->userdata('is_customer');
?>
<style>
    table#table {
    margin-top: 0 !important;
}
.fixed-table-header {
    display: none !important;
}

table.dataTable thead th, table.dataTable thead td {
    padding: 12px 6px;
    border-top: 1px solid #ebebe9;
    line-height: 1.43;
}
table.dataTable, table.dataTable th, table.dataTable td {
    -webkit-box-sizing: border-box !important;
    box-sizing: border-box !important;
}
.toggle.btn {
    min-width: 6.7rem !important;
    min-height: 2.15rem !important;
}
@media(min-width: 1024px){
    table.dataTable {
        width: 100%;
        max-width: 100%;
    }
    .dataTables_wrapper {
        width: 100%;
    }
}
.icon-padding{
        padding: 2px 6px;
}

</style>
<link rel="stylesheet" type="text/css" href="https://www.cafeadmin.com.au/assets/css/jquery.dataTables.css">
<script type="text/javascript" src="https://www.cafeadmin.com.au/assets/js/jquery.dataTables.min.js"></script>
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
									<a class="parent-item" href="index.html">Customers</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Customers
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
			    <div class="card card-shadow mb-4" style="padding: 15px;">
				    <div class="row">
    				    <div class="col-lg-12 text-right mb-4">
    				        <button type="button" class="btn btn-primary" onclick="add_customer()"><i class="fa fa-plus icon-padding"></i>Add Customer</button>
    				         
    				        </div>
    					<!--Report widget start-->
    					<div class="col-12">
						
							<div class="table-responsive">
							   
							    <nav>
                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link <?php echo $currentActiveClass2; ?>" id="nav-profile-tab" data-toggle="tab" href="#nav-cost-center" role="tab" aria-controls="nav-profile" aria-selected="false">Partner Accounts</a>
                                    <a class="nav-item nav-link <?php echo $currentActiveClass1; ?>" id="nav-home-tab" data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-home" aria-selected="true">Customers</a>
                                  </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show <?php echo $currentActiveShowClass1; ?> mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                                     <table id="customers" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    									<thead> 
    										<tr>
    											<th>Customer Name</th>
    											<th>Email</th>
    											<th>Contact</th>
    											<th>Company Name</th>
    											<th>Action</th>
    										</tr>
    									</thead>
    									<tbody>
    										<?php if(!empty($customers)){
    										    $rowNumber = 0;
    											foreach($customers as $customer){ ?>
    											<tr>
    											    <td><?php echo $customer->firstname." ".$customer->lastname; ?></td>
    											    <td><?php echo $customer->email; ?></td>
    											    <td><?php echo $customer->telephone; ?></td>
    											      <?php if(!empty($companies)){
    								foreach($companies as $company){ 
    								if($company->company_id == $customer->company_id){ 	?>
    								<td><?php echo $company->company_name; ?></td>
    							<?php } } }?>
    								<td><button class="btn btn-info btn-sm " onclick="edit_customer(<?php echo $customer->customer_id; ?>,<?php echo $rowNumber; ?>)">Edit</button> <button class="btn btn-danger btn-sm " onclick="del_customer(<?php echo $customer->customer_id; ?>)">Delete</button></td>
    											</tr>
    											
                                            <?php $rowNumber++; } } ?>
    									</tbody>
    								</table>
                                    </div>
                        	<div class="tab-pane fade <?php echo $currentActiveShowClass2; ?> mt-3" id="nav-cost-center" role="tabpanel" aria-labelledby="nav-costcenter-tab">
				                <table id="customers" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Customer Name</th>
											<th>Company Name</th>
											<th>Department Name</th>
											<th>Email</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($costcenter)){
											foreach($costcenter as $costcenterCustomer){ ?>
											<tr>
											    <td><?php echo $costcenterCustomer->firstname; ?></td>
											    <td><?php echo $costcenterCustomer->company_name; ?></td>
											    <td><?php echo $costcenterCustomer->department; ?></td>
											    <td><?php echo $costcenterCustomer->email; ?></td>
											    <td><input type="checkbox" onchange="approve_cost_center(<?php echo $costcenterCustomer->customer_id; ?>,this)" <?php echo ($costcenterCustomer->approved == 0 ? '' : 'checked'); ?>  data-on="Approved" data-off="Inactive" data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger"></td>
											    <td><button class="btn btn-info btn-sm " onclick="fetchCostCenterData(<?php echo $costcenterCustomer->customer_id; ?>)">View</button>
											    <button class="btn btn-success btn-sm " onclick="edit_row(<?php echo $costcenterCustomer->customer_id; ?>)">Edit</button>
											    <button class="btn btn-danger btn-sm " onclick="del_row(<?php echo $costcenterCustomer->customer_id; ?>)">Delete</button>
											    </td>
											</tr>
                                        <?php } } ?>
									</tbody>
								</table>
					    
	</div>
	</div>
	</div>
					    </div>
					</div>
				</div>
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
    		<form action="<?php echo base_url();?>index.php/general/add_new_customer" id="addNewCustomerForm" method="POST">
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
        					<input type="email" class="form-control " name="email" id="email-input" placeholder="Email">
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
<div class="modal fade rounded-0 border-0" id="customer_modal" tabindex="-1" role="dialog" aria-labelledby="customer_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0">
    			<h5 class="modal-title text-white" id="customer_modal_title">Edit Customer</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    			<form id="customer_info">
    			    <div class="input-group mt-3">
        					<span class="input-group-addon"><i class="fa fa-building"></i></span>
        					<select class="form-control companyIDList" name="company_id" id="company_id" onchange="fetch_departments(this)" required>
        					    </select>
        					 
        			</div> 
    				<div class="input-group mt-3 department_wrap" style="display:none;" >
    					<span class="input-group-addon"><i class="fa fa-building"></i></span>
    					<select class="form-control deptList" name="department_id" id="department_id">
    				    </select>
    				</div> 
    			    <div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-user"></i></span>
    					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
    				</div>
    				
    				
    				<div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-user"></i></span>
    					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
    				</div>
    				
    				<div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-phone"></i></span>
    					<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
    				</div>
    				
    				<div class="input-group mt-3">
    					<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
    					<input type="email" class="form-control" name="email" id="email" placeholder="Email">
    					<input type="hidden" name="currentEmail" id="currentEmail">
    				</div>
    			
    				<input type="hidden" name="customer_id" id="customer_id">
    				
    				<div class="input-group mt-3">
    					<span<label>Activate </span>
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

<div class="modal fade" id="viewCostCenter"  tabindex="-1" role="dialog" aria-labelledby="email_modal_title">
		<div class="modal-dialog" role="document" style="max-width:1000px">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Cost center account details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
					    	<div class="col-4">
					    <p id="account_full_name"></p>
					    	</div>
					    	<div class="col-4">
					    <p id="account_number"></p>
					    	</div>
					    	<div class="col-4">
					    <p id="account_pin"></p>
					    	</div>
					    	
					    
					</div>
					
					<div class="row" mt="20">
					    		<div class="col-4">
					    <p id="account_location"></p>
					    	</div>
					    		<div class="col-4">
					    <p id="account_email"></p>
					    	</div>
					    		<div class="col-4">
					    <p id="account_telephone"></p>
					    	</div>
					    	</div>
					    	
					    	
					   <div class="row">
					    
					    		<div class="col-4">
					    <p id="account_company_name"></p>
					    	</div>
					    		<div class="col-4">
					    <p id="account_department_name"></p>
					    	</div>
					    	<div class="col-4">
					    <p id="accounts_contact_name"></p>
					    	</div>
					    	
					    	</div>
					    	 <div class="row">
					    	     <div class="col-4">
					    <p id="accounts_contact_email"></p>
					    	</div>
					    		<div class="col-4">
					    <p id="accounts_point_of_contact"></p>
					    	</div>
					    		</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="editCostCenter" tabindex="-1" role="dialog" aria-labelledby="email_modal_title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Edit cost center</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
					    <div class="col-lg-6 col-sm-12 mb-3">
    					    <p><b>Name : </b> <input type="text" id="account_name_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
    					    <p><b>Account Number : </b> <input type="text" id="account_number_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Account Pin : </b><input type="text" id="account_pin_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Location : </b><select id="account_location_edit" class="form-control"></select></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Email : </b><input type="text" id="account_email_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Telephone : </b><input type="text" id="account_telephone_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Company name : </b><input type="text" id="company_name_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Department name : </b><input type="text" id="department_name_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Account Contact Name : </b><input type="text" id="account_contact_name_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Account Contact Email : </b><input type="text" id="account_contact_email_edit" class="form-control"></p>
				    	</div>
				    	<div class="col-lg-6 col-sm-12 mb-3">
				            <p><b>Account Contact Number : </b><input type="text" id="account_contact_number_edit" class="form-control"></p>
				    	</div>
				        <input type="hidden" id="edit_cost_center_id">	
					</div>
					
				</div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateCostCenter()">
						Update
					</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					
				</div>
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
$(document).ready(function () {
    $('#customers').DataTable({
        pageLength: 500,
        lengthMenu: [0, 5, 10, 20, 30, 40, 50, 100, 200, 500],
        
    });
});

$(function(){
	company_map=<?php echo json_encode($companies);?>;
	department_map=<?php echo json_encode($departments);?>;
	customer_map=<?php echo json_encode($customers);?>;
   locations = <?php echo json_encode($locations);?>

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
function fetchCompaniesAndDepartment(){
     
     $.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCompaniesAndDepartment',
		method:"GET",
		success:function(data){
		    data = JSON.parse(data);
		    company_map = data['companies']
		    department_map = data['departments'];
		   
		    console.log("data=",company_map);
		    let options = '<option value="" >Select Company</option>';
		    let deptOptions = '<option value="" >Select Department</option>';;
		    company_map.map((compDetails)=>{
		      options +='<option value="'+compDetails.company_id+'">'+compDetails.company_name+'</option>'  
		    });
		     department_map.map((deptDetails)=>{
		      deptOptions +='<option value="'+deptDetails.department_id+'">'+deptDetails.department_name+'</option>'  
		    });
		    
		    
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

function edit_customer(customer_id,rowNumber=0){
// 	$("#customer_modal_title").html('');
	$("#customer_id").val('');
	$("#phone").val('');
	$("#email").val('');
	$("#cost_centre").val('');
	$("#first_name").val('');
	$("#last_name").val('');
	
	let selectedCompanyId = customer_map[rowNumber]?.company_id;
	let departmentId = customer_map[rowNumber]?.department;
	let customerStatus = customer_map[rowNumber]?.status;
	let firstname = customer_map[rowNumber]?.firstname;
	let lastname = customer_map[rowNumber]?.lastname;
	let telephone = customer_map[rowNumber]?.telephone;
	let email = customer_map[rowNumber]?.email;
	var htmlOptComp = '<option>Select Company</option>';
	for(let j=0;j<company_map.length;j++){
    
    
            
        		if(parseInt(company_map[j].company_id) == parseInt(selectedCompanyId)){
        		    htmlOptComp += '<option value="'+company_map[j].company_id+'" selected>'+company_map[j].company_name+'</option>';
        		}else{
        		    htmlOptComp += '<option value="'+company_map[j].company_id+'">'+company_map[j].company_name+'</option>';
        		}
	}
      
        	$("#company_id").html(htmlOptComp);

            var htmlOpt = '<option> Select Department</option>';
            var checkFlag=0;
            for(var i=0;i<department_map.length;i++){
        	    
        		if(department_map[i].company_id == selectedCompanyId){
        		    checkFlag=1;
        		    if(department_map[i].department_id == departmentId){
        		        htmlOpt += '<option value="'+department_map[i].department_id+'" selected>'+department_map[i].department_name+'</option>';
        		    }else{
        		        htmlOpt += '<option value="'+department_map[i].department_id+'">'+department_map[i].department_name+'</option>';
        		    }
        			
        		}
        	}
        	if(checkFlag == 1){
        	    $("#department_id").html(htmlOpt);
        	    $(".department_wrap").css('display','flex');
        	}else{
        	    $("#department_id").html('<option value="">No department found</option>');
        	    $(".department_wrap").css('display','none');
        	}
	    console.log("customerStatus",customerStatus)
	       console.log("firstname",firstname)
			$("#customer_id").val(customer_id);
			$("#first_name").val(firstname);
			$("#last_name").val(lastname);
			$("#phone").val(telephone);
			$("#email").val(email);
			$("#currentEmail").val(email);
// 			$("#customer_status").val(customer_map[i].status);
			
			if(customerStatus == 1){
           $("#customer_status").attr("checked", "checked");
           }
			$("#customer_modal").modal('show');
// 		}

}
function update_customer(){
    
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/update_customer',
		method:"POST",
		data:$("#customer_info").serialize(),
		success:function(response){
		    if(response == 'updated'){
		       location.reload(); 
		    }else{
		        alert(response)
		    }
			
		}
	})
}
function del_customer(customer_id){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/del_customer',
		method:"POST",
		data:'customer_id='+customer_id,
		success:function(data){
			location.reload();
		}
	})
	
}

function fetchCostCenterData(customer_id){
 
  	$.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCostCenterData',
		method:"POST",
		data:'customer_id='+customer_id,
		success:function(response){
		   let cost_center_data = JSON.parse(response);
           console.log(cost_center_data);
           $("#account_number").html('<b>Account Number : </b>  '+((cost_center_data[0]?.account_number === null) ? ' Not Generated Yet ' : cost_center_data[0]?.account_number));
           $("#account_pin").html('<b>Account Pin : </b>  '+((cost_center_data[0]?.account_pin === null) ? ' Not Generated Yet ' : cost_center_data[0]?.account_pin));
           $("#accounts_contact_name").html('<b>Account Contact Name : </b> '+cost_center_data[0]?.accounts_contact_number)
            $("#accounts_contact_email").html('<b>Account Contact Email : </b> '+cost_center_data[0]?.accounts_contact_email)
           $("#accounts_point_of_contact").html('<b>Account Contact Number : </b> '+cost_center_data[0]?.accounts_point_of_contact);
            $("#account_full_name").html('<b>Name : </b> '+cost_center_data[0]?.firstname);
            $("#account_email").html('<b>Email : </b> '+cost_center_data[0]?.email);
            $("#account_telephone").html('<b>Telephone : </b> '+cost_center_data[0]?.telephone);
            $("#account_location").html('<b>Location : </b> '+cost_center_data[0]?.location_name);
            $("#account_company_name").html('<b>Company name : </b> '+cost_center_data[0]?.company_name);
            $("#account_department_name").html('<b>Department name : </b> '+cost_center_data[0]?.department);
		}
	});
	setTimeout(()=>{
	   $("#viewCostCenter").modal('show');  
	},300)
	
}
function edit_row(customer_id){
   $("#edit_cost_center_id").val(customer_id)
  	$.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCostCenterData',
		method:"POST",
		data:'customer_id='+customer_id,
		success:function(response){
		   let cost_center_data = JSON.parse(response);
           $("#account_number_edit").val(((cost_center_data[0]?.account_number === null || cost_center_data[0]?.account_number === '') ? ' Not Generated Yet ' : cost_center_data[0]?.account_number));
            $("#account_pin_edit").val(((cost_center_data[0]?.account_pin === null || cost_center_data[0]?.account_pin === '') ? ' Not Generated Yet ' : cost_center_data[0]?.account_pin));
            $("#account_name_edit").val(((cost_center_data[0]?.firstname === null) ? '' : cost_center_data[0]?.firstname));
            var opthtml = '<option value="">Select Location</option>';
            for(var i=0;i<locations.length;i++){
		        if(locations[i].user_id==cost_center_data[0]?.location_id){
    			   opthtml += '<option value="'+locations[i].user_id+'" selected>'+locations[i].location_name+'</option>'
		        }else{
    			   opthtml += '<option value="'+locations[i].user_id+'">'+locations[i].location_name+'</option>'
                    
		        }
            }
            $("#account_location_edit").html(opthtml);
            $("#account_email_edit").val(((cost_center_data[0]?.email === null) ? '' : cost_center_data[0]?.email));
            $("#account_telephone_edit").val(((cost_center_data[0]?.telephone === null) ? '' : cost_center_data[0]?.telephone));
            $("#company_name_edit").val(((cost_center_data[0]?.company_name === null) ? '' : cost_center_data[0]?.company_name));
            $("#department_name_edit").val(((cost_center_data[0]?.department === null) ? '' : cost_center_data[0]?.department));
            $("#account_contact_name_edit").val(((cost_center_data[0]?.accounts_contact_number === null) ? '' : cost_center_data[0]?.accounts_contact_number));
            $("#account_contact_email_edit").val(((cost_center_data[0]?.accounts_contact_email === null) ? '' : cost_center_data[0]?.accounts_contact_email));
            $("#account_contact_number_edit").val(((cost_center_data[0]?.accounts_point_of_contact === null) ? '' : cost_center_data[0]?.accounts_point_of_contact));
            console.log(locations);
		}
	});
	setTimeout(()=>{
	   $("#editCostCenter").modal('show');  
	},300)
	
}
function updateCostCenter(){
   var location_name = $("#account_location_edit option:selected").text();
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/updateCostCenter',
		method:"POST",
		data:'cost_center_id='+$("#edit_cost_center_id").val()+'&account_number='+$("#account_number_edit").val()+'&account_pin='+$("#account_pin_edit").val()+'&fullname='+$("#account_name_edit").val()+'&location_id='+$("#account_location_edit").val()+'&email='+$("#account_email_edit").val()+'&telephone='+$("#account_telephone_edit").val()+'&company_name='+$("#company_name_edit").val()+'&department_name='+$("#department_name_edit").val()+'&accounts_contact_number='+$("#account_contact_name_edit").val()+'&accounts_point_of_contact='+$("#account_contact_number_edit").val()+'&location_name='+location_name,
		success:function(data){
// 			location.reload();
		}
	})
}
function approve_cost_center(customer_id,obj){
    if($(obj).prop("checked") == true){
     status=1
    }else{
     status=0
    }
   
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/approve_cost_center',
		method:"POST",
		data:'customer_id='+customer_id+'&approve='+status,
		success:function(data){
// 			location.reload();
		}
	})
}
function del_row(cost_centre_id,tablenamme){
    if (confirm("Delete Record?") == true) {
        
       $.ajax({
		url:'<?php echo base_url();?>index.php/general/delete_cost_center',
		method:"POST",
		data:'customer_id='+cost_centre_id,
		success:function(data){
			location.reload();
		}
	})
    } else {
        console.log("Cancelled by user");
      
    }
	
	
}
</script>