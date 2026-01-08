
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
							<h1><?php echo $title;?></h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Coupons</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									<?php echo $title;?>
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
					<div class="col-12">
					   
						<div class="card">
						   
							<div class="card-body">
							 <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-activecoupons" role="tab" aria-controls="nav-home" aria-selected="true">Active Coupons</a>
  </div>
</nav>
</br>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-activecoupons" role="tabpanel" aria-labelledby="nav-customer-tab">
								<div class="row">
									<?php if(!empty($coupons)){
										foreach($coupons as $coupon){
											echo "<div class=\"col-xl-3 col-sm-6 mb-4\">";
											echo "<div class=\"card card-shadow bg-info text-white\">";
											echo "<div class=\"card-body\">";
											echo "<p class=\"f24\">".$coupon->coupon_code."</p>";
											echo "<h6 class=\"mb-0 pull-left text-white\">".$coupon->coupon_description."</h6>";
											if($coupon->status==1) echo "<a href=\"".base_url()."index.php/orders/archive_coupon/".$coupon->coupon_id."\" class=\"btn btn-dark pull-right\">Deactivate</a>";
											else echo "<a href=\"".base_url()."index.php/orders/activate_coupon/".$coupon->coupon_id."\" class=\"btn btn-light pull-right\">Activate</a>";
											echo "</div>";
											echo "</div>";
											echo "</div>";
										}
									}?>
									<?php if($title=="Active Coupons"){
										echo "<div class=\"col-xl-3 col-sm-6 mb-4\">";
										echo "<a href=\"#!\" id=\"new_coupon\">";
										echo "<div class=\"card card-shadow bg-info text-white\">";
										echo "<div class=\"card-body\">";
										echo "<h6 class=\"text-white\">New coupon...</h6>";
										echo "</div>";
										echo "</div>";
										echo "</a>";
										echo "</div>";
									}?>
								</div>
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

<div class="modal fade" id="new_coupon_modal" tabindex="-1" role="dialog" aria-labelledby="new_coupon_label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url();?>index.php/general/new_coupon" method="POST">
			<div class="modal-header">
				<h5 class="modal-title" id="new_coupon_label">New Coupon</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						Coupon Code
						<input type="text" class="form-control" name="coupon_code" required>
					</div>
					<div class="col-12">
						Coupon Description
						<input type="text" class="form-control" name="coupon_description" required>
					</div>
					<div class="col-12">
						Coupon Discount (Enter numbers ONLY)
						<input type="number" step="0.1" class="form-control" name="coupon_discount" required>
					</div>
					<div class="col-12">
						Type
						<select name="coupon_type" class="form-control">
							<option value="P">Percentage Discount</option>
							<option value="F">Fixed Discount</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					Close
				</button>
				<button type="submit" class="btn btn-primary">
					Save changes
				</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script>
	$("#new_coupon").on('click',function(e){
		e.preventDefault();
		$("#new_coupon_modal").modal('show');
	})
</script>
