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
div#categoryTable_length label {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
div#categoryTable_filter label {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
div#categoryTable_length label select {
    width: 100px !important;
    margin: 0 5px;
}
.dataTables_wrapper .dataTables_filter input {
    width: 200px;
    margin: 0 5px;
}
div#categoryTable_filter {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
div#categoryTable_wrapper {
    padding: 15px;
}
.bg-grey {
    background: #fdfdfd!important;
    border-bottom: 1px solid #eee;
}
.dataTables_wrapper>.row {
    margin-bottom: 15px !important;
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
							<h1>Categories</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Category</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Categories
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
								<h3 class="card-title">Categories</h3>
							</div>
							<div class="table-responsive">
							   
							    
								<table class="table table-sm table-striped" id="categoryTable">
									<thead class="bg-grey">
										<tr>
											<th>Category Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($record)){
											foreach($record as $row)
											{
                                                echo "<tr>";
												echo "<td>".$row->category_name."</td>";
											
										
										        echo "<td>";
                    				// 			echo "<a href=\"".base_url()."index.php/orders/view_category/".$row->category_id."\" class=\"btn btn-primary btn-sm mr-1\">View</a>&nbsp;&nbsp;";			
                    							echo "<a href=\"".base_url()."index.php/orders/edit_category/".$row->category_id."\" class=\"btn btn-primary btn-sm mr-1\">Edit</a>&nbsp;&nbsp;";			
                    							echo "<button class=\"btn btn-danger btn-sm mr-1\" onclick=\"delete_category('".$row->category_id."')\">Delete</button>";
											
												
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

<div class="modal fade" id="delete_category_Modal" tabindex="-1" role="dialog" aria-labelledby="delete_category_Modal_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="delete_category_Modal_title">Are you sure, You want to delete this Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/delete_category" method="POST" id="delete_category_form">
					<input type="hidden" name="category_id" id="delete_category_id">
					
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



<script>

function delete_category(category_id){
	$("#delete_category_id").val(category_id);
	$("#delete_category_Modal").modal('show');
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function () {
    $('#categoryTable').DataTable( {
        pageLength: 50,
    lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
    });
    
});
</script>