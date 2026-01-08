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
							<h1>View Survey</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Survey Report</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
							View Survey Report
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
							<div class="table-responsive">
								<table class="table table-sm table-bordered">
									<thead>
										<tr>
											<th>ID </th>
											<th>Name</th>
											<th>Email</th>
											<th>Date </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									 
										<?php if(!empty($all_survey)){
											foreach($all_survey as $survey)
											{
											 echo "<tr>";  
                                           echo "<td>".$survey->id."</td>";
                                           echo "<td>".$survey->person_name."</td>";
                                           echo "<td>".$survey->person_email."</td>";
                                           echo "<td>".date('d-m-y',strtotime($survey->date))."</td>";
                                           echo "<td>";
                         echo "<a href=\"".base_url()."index.php/survey/view_survey/".$survey->id."\"><i class='fa fa-eye'></i></a>";

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

<script>
  var $table = $('#table')

  $(function() {
    $('#modalTable').on('shown.bs.modal', function () {
      $table.bootstrapTable('resetView')
    })
  })
  
  
	
	
		
		function delete_order(order_id,referrer,ofrom){
			$("#delete_order_id").val(order_id);
			$("#delete_order_referrer").val(referrer);
			$("#delete_order_order_made_from").val(ofrom);
			$("#delete_order_modal").modal('show');
		}
</script>
