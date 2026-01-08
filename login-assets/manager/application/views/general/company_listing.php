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
							<h1>Company</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Company</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Company
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
    				    <div class="col-lg-12 text-right mb-4"><button type="button" class="btn btn-primary" onclick="add_new_company()">Add Company</button></div>
    					<!--Report widget start-->
    					<div class="col-12">
						
							<div class="table-responsive">
							   
							    
								<table id="customers" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Company Name</th>
											<th>Contact</th>
											<th>Address</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($companies)){
											foreach($companies as $company){ ?>
											<tr>
											    <td><?php echo $company->company_name; ?></td>
											    
											    <?php 

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
											    ?>
											    <td><?php echo $phone; ?></td>
											    <td><?php if($company->company_address != 'null' && $company->company_address != ''){ echo $company->company_address; } ?></td>
											    <td><button class="btn btn-info btn-sm " onclick="edit_company(<?php echo $company->company_id; ?>)">Edit</button> <button class="btn btn-danger btn-sm " onclick="del_row(<?php echo $company->company_id; ?>,'company')">Delete</button></td>
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

<div class="modal fade rounded-0 border-0" id="company_modal" tabindex="-1" role="dialog" aria-labelledby="company_modal_title" aria-hidden="true">
    <div class="modal-dialog rounded-0 border-0" role="document">
    	<div class="modal-content rounded-0 border-0">
    		<div class="modal-header bg-info rounded-0">
    			<h5 class="modal-title text-white" id="company_modal_title">Edit Company</h5>
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
    					<input type="text" class="form-control" name="company_name" placeholder="Company Name">
    				</div>
    				</br>
    				<div class="input-group">
    					<span class="input-group-addon">ABN</span>
    					<input type="text" class="form-control" name="abn" placeholder="ABN">
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
    			<button type="button" class="btn btn-primary" onclick="save_new_company()">
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

function edit_company(company_id){
// $("#company_modal_title").html('');
	$("#company_id").val('');
	$("#company_name").val('');
	$("#company_phone").val('');
	$("#company_address").html('');
	$("#abn").val('');
	
	
	for(var i=0;i<company_map.length;i++){
		if(company_map[i].company_id==company_id){
// 			$("#company_modal_title").html(company_map[i].company_name);
			$("#company_name").val(company_map[i].company_name);
			$("#company_id").val(company_map[i].company_id);
			$("#company_phone").val(company_map[i].company_phone);
			$("#company_address").html(company_map[i].company_address);
			$("#abn").val(company_map[i].company_abn);
			$("#company_modal").modal('show');
		}
	}
}
function add_new_company(){
	$("#company_name").val('');
	$("#company_phone").val('');
	$("#company_address").html('');
	$("#abn").val('');
	$("#new_company_modal").modal('show');
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
function save_new_company(){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/new_company',
		method:"POST",
		data:$("#new_company_info").serialize(),
		success:function(data){
			location.reload();
		}
	})
}
function del_row(company_id,tablenamme){
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/del_row',
		method:"POST",
		data:'company_id='+company_id+'&table_name='+tablenamme,
		success:function(data){
			location.reload();
		}
	})
	
}
</script>