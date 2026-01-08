<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
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
							<h1>Products</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Products</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Edit Product
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
					<div class="col-4">
						<div class="card">
							<div class="card-header">
								<p class="card-title">Edit Product</p>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url();?>index.php/general/update_product/<?php echo $product_id;?>" method="POST" enctype='multipart/form-data'>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="product_heading" id="heading" value="<?php echo $product->heading;?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="product_name" value="<?php echo $product->product_name;?>" required>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Price</label>
										<div class="col-sm-9">
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="text" class="form-control" name="amount" value="<?php echo number_format($product->product_price,2);?>" required>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Category</label>
										<div class="col-sm-9">
											<select class="form-control" name="category" id="category">
												<?php if(!empty($categories)){
													foreach($categories as $cat){
														if($cat->category_id==$product->category_id)
															echo "<option value=\"".$cat->category_id."\" selected>".ucwords($cat->category_name)."</option>";
														else echo "<option value=\"".$cat->category_id."\">".ucwords($cat->category_name)."</option>";
													}
												}?>
												<option value="0">Create New Category</option>
											</select>
										</div>
									</div>
									<div class="form-group row new_cat">
										<label class="col-sm-3 col-form-label">Category Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="category_name" placeholder="New Category Name">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" name="product_description" placeholder="Description"><?php echo nl2br($product->product_description);?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Image</label>
										<div class="col-9">
										<?php if(empty($product->product_image)&&empty($product->image)) echo "";
										else if(!empty($product->product_image)){
											echo "<a href=\"".base_url().$product->product_image."\" target=\"_blank\" class=\"btn btn-warning btn-sm\" style=\"height:auto;\">Open Image</a>";
										}
										else 
											echo "<a href=\"".base_url().$product->image."\" target=\"_blank\" class=\"btn btn-warning btn-sm\" style=\"height:auto;\">Open Image</a>";
										?>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Update/Change Image</label>
										<div class="col-sm-9" id="file">
											<div class="custom-file" id="customFile">
												<input type="file" class="custom-file-input" id="photo_upload" name="image_file" aria-describedby="fileHelp">
												<label class="custom-file-label" for="photo_upload" id="label_photo">
													Pick a file...
												</label>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Bullet Description 1</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_desc_1;?>" name="product_desc_1">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Bullet Description 2</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_desc_2;?>" name="product_desc_2">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Bullet Description 3</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_desc_3;?>" name="product_desc_3">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Bullet Description 4</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_desc_4;?>" name="product_desc_4">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Bullet Description 5</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_desc_5;?>" name="product_desc_5">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Minimum</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" value="<?php echo $product->product_minimum;?>" name="minimum" value="1" required>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-12 text-center">
											<button type="submit" class="btn btn-primary">Update Product</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-4">
							<div class="card">
								<div class="card-header">
									<p class="card-title">Current Options</p>
								</div>
								<div class="card-body">
									<table class="table table-sm table-striped">
										<thead>
											<tr>
												<th>Option Name</th>
												<th>Option Price</th>
												<th>Remove</th>
											</tr>
										</thead>
										<tbody id="current_product_options">
											<?php if(empty($options)){
												echo "<tr><td colspan=\"3\">No options currently assigned.</td></tr>";
											}
											else{
												foreach($options as $option){
													echo "<tr id=\"product_option_id_".$option->product_option_id."\">";
													echo "<td>".$option->option_name."</td>";
													echo "<td>".$option->option_price_prefix."$".$option->option_price."</td>";
													echo "<td><button class=\"btn btn-sm btn-danger\" type=\"button\" onclick=\"remove_option('".$option->product_option_id."')\"><i class=\"fa fa-remove\"></i></button></td>";
													echo "</tr>";
												}
											}
											?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>
					<div class="col-4">
						<div class="card">
							<div class="card-header">
								<p class="card-title">Options</p>
							</div>
							<div class="card-body">
								<table class="table table-striped" id="all-options">
									<thead>
										<tr>
											<th>Option Name</th>
											<th>Option Price</th>
											<th>Option Add</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($all_options as $option){
											echo "<tr>";
											echo "<td>".$option->name."</td>";
											echo "<td><input type=\"text\" class=\"form-control\" id=\"option-price-".$option->option_value_id."\"></td>";
											echo "<td><button class=\"btn btn-info btn-sm\" onclick=\"add_option('".$option->option_value_id."')\"><i class=\"fa fa-plus\"></i></button></td>";
											echo "</tr>";
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

<div class="modal fade" id="new-option-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel3">New Option</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="nof">

				<div class="row">
					<div class="col-12">
						Option Title
						<input type="text" name="option_title" id="option_title" class="form-control" placeholder="Size / Filling Etc">
					</div>
					<div class="col-12 mt-3">
						Option Title
						<input type="text" name="option_name" id="option_name" class="form-control" placeholder="Large / Regular / Oatmeal etc">
					</div>
					<div class="col-12 mt-3">
						<input type="submit" value="Add" class="btn btn-info">
					</div>
				</div>
			</div>
		</form>
		
	</div>
</div>
</div>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(function(){
	$(".new_cat").hide();
	$("#category").on('change',function(){
		if($("#category option:selected").val()==0){
			$(".new_cat").show();
		}
		else $(".new_cat").hide();
	})
	$("#all-options").DataTable({
		"pagingType": "simple"
	});
	$("input[name='options_required']").on('change',function(){
		if($("input[name='options_required']").is(':checked')){
			$.ajax({
				url:'<?php echo base_url();?>index.php/general/change_required_status/<?php echo $product_id;?>/1',
				method:"POST"
			})
		}
		else{
			$.ajax({
				url:'<?php echo base_url();?>index.php/general/change_required_status/<?php echo $product_id;?>/0',
				method:"POST"
			})
		}
	})

	$('#heading').autoComplete({
		source: function(term, response){
			$.getJSON('<?php echo base_url();?>index.php/general/fetch_product_headings', { q: term }, function(data){ response(data); });
		}
	});
	$("#nof").on('submit',function(e){
		e.preventDefault();
		var flag=0;
		$("#option_title").removeClass('is-invalid');
		$("#option_name").removeClass('is-invalid');
		//Check if option title and name are present
		if($.trim($("#option_title").val())==''){
			$("#option_title").addClass('is-invalid');
			flag=1;
		}
		if($.trim($("#option_name").val())==''){
			$("#option_name").addClass('is-invalid');
			flag=1;
		}

		if(flag==0){
			$.ajax({
				url:'<?php echo base_url();?>index.php/general/new_options',
				method:"POST",
				data:$("#nof").serialize(),
				success:function(data){
					data=JSON.parse(data);
					table.destroy();
					$("#all-options-tbody").empty();
					
					var elem='';
					for(var i=0;i<data.length;i++){
						elem+="<tr><td>"+data[i].name+"</td><td><input type=\"text\" class=\"form-control\" id=\"option-price-"+data[i].option_value_id+"\"></td><td><button class=\"btn btn-info btn-sm\" onclick=\"add_option('"+data[i].option_value_id+"','"+data[i].name+"','"+data[i].option_value_id+"')\"><i class=\"fa fa-plus\"></i></button></td></tr>";
					}
					$("#all-options-tbody").append(elem);
					table=$("#all-options").DataTable({
						"pagingType": "simple"
					});
					$("#new-option-modal").modal('hide');
				}
			})
		}
	})

	var input = $("#photo_upload").change(function(){
		document.getElementById('label_photo').innerHTML=(this.value.split("\\").pop());
	})
})
function remove_option(product_option_id)
{
$.ajax({
	url:'<?php echo base_url();?>index.php/general/remove_option/'+product_option_id,
	method:'POST',
	success:function(data){
		console.log(data);
		$("#product_option_id_"+data).remove();
	}
})
}
function add_option(option_value_id)
{
$("#option-price-"+option_value_id).removeClass('is-invalid');
var regexp=/^\-?\d+\.?\d*$/;
if(!regexp.test($("#option-price-"+option_value_id).val()))
{
	$("#option-price-"+option_value_id).addClass('is-invalid');
}
else
{
	var options_required=0;
	if($("input[name='options_required']").length!=0&&$("input[name='options_required']").is(':checked')){
		options_required=1;
	}
	$.ajax({
		url:'<?php echo base_url();?>index.php/general/add_product_option/<?php echo $product_id;?>/'+option_value_id+'/1',
		method:"POST",
		data:{"price":$("#option-price-"+option_value_id).val()},
		success:function(data){
			if($("#current_product_options").find("tr").first().find("td").html()=="No options currently assigned.")
			{
				$("#current_product_options").find("tr").first().remove();
			}
			if(data!=0)
				$("#current_product_options").append(data);
		}
	})
		
}
}
</script>