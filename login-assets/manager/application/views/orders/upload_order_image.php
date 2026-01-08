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
.del_btn{
    margin-left:5px;
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
							<h1>Upload Image</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Order Images
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
								<h3 class="card-title">Images</h3>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url();?>index.php/orders/upload_order_image" enctype="multipart/form-data" method="POST" id="order_comment_form">
                					<input type="hidden" name="order_id" id="upload_image_id" value="<?php echo $order_id; ?>">
                					<input type="hidden" name="referrer" id="upload_image_referrer">
                					<input type="hidden" name="ofrom" id="upload_image_form">
                					<input type="hidden" value="viewOrder" name="listing_type">
                					<div class="parentWrap">
                    					<div class="row mt-2 rowWrap">
                    						<div class="col-8">
                    							<input type="file" class="form-control" name="hc_image[]" required style="font-size: 11px;">
                    						</div>
                    						<div class="col-4">
                    						    <button type="button" class="add_btn btn btn-info">Add Row</button>
                    						</div>
                    					</div>
                    					<div class="row mt-2">
                    						<div class='col-12'>
                    							<button type="submit" class="btn btn-info">Save Image</button>
                    						</div>
                    					</div>
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

<div class="modal fade" id="view_image_modal" tabindex="-1" role="dialog" aria-labelledby="view_image_modal_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="view_image_modal_title">View Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			    <div class="row">
						<div class="col-12">
							<img src="" id="view_image" style="max-width:100%;">
							<p id="view_image_error" style="display:none;">No image found</p>
						</div>
					</div>
				
				
			</div>
		</div>
	</div>
</div>


<script>
 
    var parentWrap = $('.parentWrap');
       $(parentWrap).on('click', '.add_btn',function(){
        var thisRow = $(this).closest('.rowWrap')[0];
        
        $(thisRow).clone().insertAfter(thisRow).find('input:file').val('');
        
        var thisRowAddbtn = $(thisRow).next('.rowWrap').find('.add_btn');
        if (!$(thisRow).has(".del_btn").length) {
       $('<button type="button" class="del_btn btn btn-danger">Delete Row</button>').insertAfter(thisRowAddbtn);
        } 
    
    });
    $(document).on("click", ".del_btn" , function() {
    
        $(this).parent().parents('.rowWrap').remove();
    });
    
</script>
<script>
    $(document).ready(function() {
    
    <?php if($this->session->flashdata('msg')){ ?>
    alert('<?php echo $this->session->flashdata('msg'); ?>');
    <?php } ?>
});
</script>
