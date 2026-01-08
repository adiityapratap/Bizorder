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
							<h1>Department</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Department</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Department
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
    				    <div class="col-lg-12 text-right mb-4"><button type="button" class="btn btn-primary" onclick="add_new_department()">Add Department</button></div>
    					<!--Report widget start-->
    					<div class="col-12">
						
							<div class="table-responsive">
							   
							    
								<table id="customers" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Department Name</th>
											<th>Company Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($departments)){
										   
											foreach($departments as $department){ ?>
											<tr>
											    <td><?php echo $department->department_name; ?></td>
											     <?php if(!empty($companies)){
								foreach($companies as $company){ 
								if($company->company_id == $department->company_id){ 	?>
								<td><?php echo $company->company_name; ?></td>
							<?php } } }?>
											     
											    
											    <td><button class="btn btn-info btn-sm " onclick="edit_department(<?php echo $department->department_id; ?>)">Edit</button> <button class="btn btn-danger btn-sm " onclick="del_row(<?php echo $department->department_id; ?>,'department')">Delete</button></td>
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

<div class="modal fade rounded-0 border-0" id="department_modal" tabindex="-1" role="dialog" aria-labelledby="department_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0">
    			<h5 class="modal-title text-white" id="department_modal_title">Edit Department</h5>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
    		</div>
    		<div class="modal-body">
    			<form id="department_info">
    			    
    			    	<div class="input-group">
    					<span class="input-group-addon">Name</span>
    					<input type="text" class="form-control" name="dept_name" id="department_name" placeholder="department Name">
    				</div>
    				</br>
    				
    				<input type="hidden" name="dept_id" id="department_id">
    			</form>
    		</div>
    		<div class="modal-footer">
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">
    				Close
    			</button>
    			<button type="button" class="btn btn-primary" onclick="update_department()">
    				Save changes
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
    					<select class="form-control" name="company_id">
    					    <?php if(!empty($companies)){
								foreach($companies as $company){ ?>
								<option value="<?php echo $company->company_id; ?>"><?php echo $company->company_name; ?></option>
							<?php } }?>
    					</select>
    				</div>
    				<div class="input-group mt-3">
    					<span class="input-group-addon">Department Name</span>
    					<input type="text" class="form-control" name="department_name" placeholder="department Name">
    				</div>
    				</br>
    				
    			</form>
    		</div>
    		<div class="modal-footer">
    			<button type="button" class="btn btn-secondary" data-dismiss="modal">
    				Close
    			</button>
    			<button type="button" class="btn btn-primary" onclick="save_new_department()">
    				Add
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
	company_map=<?php echo json_encode($companies);?>;
	
	
	department_map=<?php echo json_encode($departments);?>;

	customer_map=<?php echo json_encode($customers);?>;

})

function edit_department(department_id){
// $("#department_modal_title").html('');
	$("#department_id").val('');
	$("#department_name").val('');
	
	
	for(var i=0;i<department_map.length;i++){
		if(department_map[i].department_id==department_id){
// 			$("#department_modal_title").html(department_map[i].department_name);
			$("#department_name").val(department_map[i].department_name);
			$("#department_id").val(department_map[i].department_id);
			$("#department_modal").modal('show');
		}
	}
}
function update_department(){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/update_dept',
		method:"POST",
		data:$("#department_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}
function add_new_department(){
	$("#department_name").val('');
	$("#new_department_modal").modal('show');
}
function save_new_department(){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/new_department',
		method:"POST",
		data:$("#new_department_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}
function del_row(department_id,tablenamme){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/del_row',
		method:"POST",
		data:'department_id='+department_id+'&table_name='+tablenamme,
		success:function(data){
			location.reload();
		}
	})
	
}
</script>