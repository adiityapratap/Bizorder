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
							<h1> <?php if($form_type == 'add'){ echo "Add"; } else if($form_type == 'edit') { echo "Edit"; } else{ echo 'View'; } ?> Category</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Category</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
								<?php if($form_type == 'add'){ echo "Add"; } else if($form_type == 'edit') { echo "Edit"; } else{ echo 'View'; } ?> Category
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
				<form action="<?php echo base_url();?>index.php/orders/add_category" method="POST" id="new_order_form">
				<?php }else if($form_type == 'edit'){ ?>
				<form action="<?php echo base_url();?>index.php/orders/edit_category/" method="POST" id="new_order_form">
				  <?php }else{ } ?>
					<div class="row mb-4">
						<!--Report widget start-->
						
							<div class="col-12">
								<div class="card card-shadow">
									
							        
									<div class="card-body">
									    
									    <div class="row">
									        <div class="col-lg-4">
									        </div>
									        <div class="col-lg-4">
        									    <div class="row ">
        									        <?php if($form_type == 'edit'){ ?>
        								                <input type="hidden" name="category_id" value="<?php echo $record[0]->category_id; ?>">
        								            <?php } ?>
        								            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 ">
        								                <label>Category Name </label>
        								                <input type="text" class="form-control" id="category_name" name="category_name" <?php if($form_type == 'view'){ echo "disabled"; } ?> value="<?php echo $record[0]->category_name; ?>">
        								            </div> 
        								            
        								            
        								        </div>
        								       
        										<?php if($form_type != 'view'){ ?>
        									        <div class="text-end mt-3"><button type="submit" name="submit_btn" class="btn btn-info submit-button"><?php if($form_type == 'edit'){ echo "Update"; }else{ echo "Save"; } ?></button></div>
        									    <?php } ?>
        									    
									        </div>
								        </div>
								    	    
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
	

