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
@media(min-width: 1024px){
    table.dataTable {
        width: 100%;
        max-width: 100%;
    }
    .dataTables_wrapper {
        width: 100%;
    }
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
							<h1>Cost Center</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Cost Center</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Cost Center
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
    					<!--Report widget start-->
    					<div class="col-12">
						
							<div class="table-responsive">
							   
							    
								<table id="customers" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Customer Name</th>
											<th>Company Name</th>
											<th>Department Name</th>
											<th>Phone</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($costcenter)){
											foreach($costcenter as $costcenterCustomer){ ?>
											<tr>
											     <td><?php echo $costcenterCustomer->fullname; ?></td>
											      <td><?php echo $costcenterCustomer->company_name; ?></td>
											       <td><?php echo $costcenterCustomer->department; ?></td>
											      <td><?php echo $costcenterCustomer->telephone; ?></td>
											   
											    
											    
											    <td><input type="checkbox" onchange="approve_cost_center(<?php echo $costcenterCustomer->customer_id; ?>,this)" <?php echo ($costcenterCustomer->status == 0 ? '' : 'checked'); ?>  data-on="Approved" data-off="Inactive" data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-danger"></td>
											     
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
			<!-- Section_End -->
		</div>
	</div>
</div>
<!-- Content_right_End -->
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

<script>
$(document).ready(function () {
    $('#customers').DataTable({
        pageLength: 30,
        lengthMenu: [0, 5, 10, 20, 30, 40, 50, 100, 200, 500],
        
    });
});
$(function(){
locations = <?php echo json_encode($locations);?>
});
function fetchCostCenterData(cost_center_id){
 
  	$.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCostCenterData',
		method:"POST",
		data:'cost_center_id='+cost_center_id,
		success:function(response){
		   let cost_center_data = JSON.parse(response);
           console.log(cost_center_data);
           $("#account_number").html('<b>Account Number : </b>  '+((cost_center_data[0]?.account_number === null) ? ' Not Generated Yet ' : cost_center_data[0]?.account_number));
           $("#account_pin").html('<b>Account Pin : </b>  '+((cost_center_data[0]?.account_pin === null) ? ' Not Generated Yet ' : cost_center_data[0]?.account_pin));
           $("#accounts_contact_name").html('<b>Account Contact Name : </b> '+cost_center_data[0]?.accounts_contact_number)
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
function edit_row(cost_center_id){
   $("#edit_cost_center_id").val(cost_center_id)
  	$.ajax({
		url:'<?php echo base_url();?>index.php/general/fetchCostCenterData',
		method:"POST",
		data:'cost_center_id='+cost_center_id,
		success:function(response){
		   let cost_center_data = JSON.parse(response);
           $("#account_number_edit").val(((cost_center_data[0]?.account_number === null || cost_center_data[0]?.account_number === '') ? ' Not Generated Yet ' : cost_center_data[0]?.account_number));
            $("#account_pin_edit").val(((cost_center_data[0]?.account_pin === null || cost_center_data[0]?.account_pin === '') ? ' Not Generated Yet ' : cost_center_data[0]?.account_pin));
            $("#account_name_edit").val(((cost_center_data[0]?.firstname === null) ? '' : cost_center_data[0]?.firstname));
            var opthtml = '<option value="">Select Location</option>';
            console.log("locations",locations)
            for(var i=0;i<locations.length;i++){
		        if(locations[i].user_id==cost_center_data[0]?.user_id){
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
		data:'cost_center_id='+customer_id+'&status='+status,
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