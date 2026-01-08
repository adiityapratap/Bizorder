<?php $userId = $this->session->userdata('user_id'); ?>
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
							<h1>Reports</h1>
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
									Reports
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
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Reports</h3>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url();?>index.php/orders/generate_report" method="POST">
								    
								    <div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Order Date From</label>
										<div class="col-sm-9">
											<input type="text" class="form-control datepicker" name="added_date_from">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Order Date To</label>
										<div class="col-sm-9">
											<input type="text" class="form-control datepicker" name="added_date_to">
										</div>
									</div>
								    
								    
									<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Delivery Date From</label>
										<div class="col-sm-9">
											<input type="text" class="form-control datepicker" name="date_from">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Delivery Date To</label>
										<div class="col-sm-9">
											<input type="text" class="form-control datepicker" name="date_to">
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Company</label>
										<div class="col-sm-9">
											<select class="form-control" name="company">
												<option value="0" selected>All Companies</option>
												<?php if(!empty($companies)){
													foreach($companies as $company){
														echo "<option value=\"".$company->company_id."\">".$company->company_name."</option>";
													}
												}?>
											</select>
										</div>
									</div>
								
									<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Status</label>
										<div class="col-sm-9">
											<select class="form-control" name="status">
							<!-- status 90 and 91 is just static used for filtering all minus and all minus cancelled orders in reports -->
												<option value="" selected>All Statuses</option>
												<option value="7">Approved</option>
												<option value="90">All minus paid</option>
												<option value="91">All minus cancelled</option>
												<option value="8">Rejected</option>
												<option value="0">Cancelled</option>
												<option value="2">Paid</option>
												<option value="4">Waiting for Approval</option>
												<!--<option value="99">Myob Orders</option>-->
													</select>
										</div>
									</div>
										<div class="form-group row">
										<label class="col-sm-3 col-form-label text-right">Location</label>
										<div class="col-sm-9">
											<select class="form-control" name="locations">
											    <option value="0" selected>All</option>
												<option value="1" >Bendigo</option>
												<option value="2">Latrobe</option>
											</select>
										</div>
									</div>
									<div class="form-group row d-flex justify-content-center">
										<button type="submit" class="btn btn-info">Generate <i class="fa fa-bar-chart"></i>
									</div>
								</form>
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
