<style>
#loading{
    
    position: absolute;
    z-index: 1000;
       top: 500px;
    left: 600px;
}
label {
    color: #000;
    font-weight: 500;
}
label span{
    color: #ff1515;
    font-weight: 700;
}

</style>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			 <!--breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1> <?php if($form_type == 'add'){ echo "Add"; } else if($form_type == 'edit') { echo "Edit"; } else{ echo 'View'; } ?> Supplier</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Suppliers</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
								<?php if($form_type == 'add'){ echo "Add"; } else if($form_type == 'edit') { echo "Edit"; } else{ echo 'View'; } ?> Supplier
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			 <!--breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
			    <?php if($form_type == 'add'){ ?>
				<form action="<?php echo base_url();?>index.php/orders/add_supplier" method="POST" id="new_order_form">
				<?php }else if($form_type == 'edit'){ ?>
				<form action="<?php echo base_url();?>index.php/orders/edit_supplier/" method="POST" id="new_order_form">
				  <?php }else{ } ?>
					<div class="row mb-4">
						<!--Report widget start-->
						
							<div class="col-12">
								<div class="card card-shadow">
									
							        
									<div class="card-body">
									    <div class="row ">
									        <?php if($form_type == 'edit'){ ?>
								                <input type="hidden" name="supplier_id" value="<?php echo $supplier[0]->supplier_id; ?>">
								            <?php } ?>
								            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3 ">
								                <label>Supplier Name </label>
								                <input type="text" class="form-control" id="supplier_name" name="supplier_name" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->supplier_name; ?>">
								            </div> 
								            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3 ">
								                <label>Email</label>
								                <input type="text" class="form-control" id="email_address" name="email_address" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->email_address; ?>" >
								            </div>
								            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-3 ">
								                <label>contact number </label>
								                <input type="text" class="form-control" id="contact_number" name="contact_number" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->contact_number; ?>" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Address Line 1</label>
								                <input type="text" class="form-control" id="supplier_address" name="supplier_address" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->supplier_address; ?>" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Suburb</label>
								                <input type="text" class="form-control" id="suburb" name="suburb" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->suburb; ?>" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>State </label>
								                <input type="text" class="form-control" id="state" name="state" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->state; ?>" >
								            </div>
								            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mt-3 ">
								                <label>Pincode</label>
								                <input type="text" class="form-control" id="pincode" name="pincode" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $supplier[0]->pincode; ?>" >
								            </div>
								            
								        </div>
								       
										<?php if($form_type != 'view'){ ?>
									        <div class="text-end mt-3"><button type="submit" name="submit_btn" class="btn btn-info submit-button"><?php if($form_type == 'edit'){ echo "Update"; }else{ echo "Save"; } ?></button></div>
									    <?php } ?>
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
	

