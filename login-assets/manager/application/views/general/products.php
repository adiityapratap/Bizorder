
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
								<li class="active">
									Products List
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
								<p class="card-title" style="display:inline">Products</p>
								<span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>index.php/general/new_product">New Product</a></span>
							</div>
							<div class="card-body">
							    <div class="row">
											
													<div class="col-12 col-md-4 mb-3">
														<input type="text" class="form-control" id="search" placeholder="Search for products">
													</div>
													</div>
								<div class="table-responsive">
								<table class="table table-sm table-striped">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Options</th>
										
											<th>Price</th>
											<th>Minimum Quantity</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody id="products_list">
										<?php foreach($products as $product){
											if(!empty($product->heading)&&$product->heading!=$header)
												echo "<tr><td colspan=\"7\"><strong>".$product->heading."</strong></td></tr>";
											echo "<tr>";
											echo "<td width=\"20%\">".$product->product_name."</td>";
											echo "<td width=\"20%\">";
											echo nl2br($product->product_description);
											if(!empty($product->product_desc_1)||!empty($product->product_desc_2)||!empty($product->product_desc_3)||!empty($product->product_desc_4)||!empty($product->product_desc_5))
											{
												echo "<ul>";
												for($i=1;$i<=5;$i++){
													$prod_str='product_desc_'.$i;
													if(!empty($product->$prod_str))
														echo "<li>".nl2br($product->$prod_str)."</li>";
												}
												echo "</ul>";
											}
											echo "</td>";
											echo "<td width=\"20%\">";
											if(empty($product->options)) echo "No options";
											if(!empty($product->options)){
												foreach($product->options as $option){
													echo $option->name."<br><hr>";
												}
											}
											echo "</td>";
										
											echo "<td width=\"5%\">$".number_format($product->product_price,2)."</td>";
											echo "<td width=\"5%\">".$product->product_minimum."</td>";
											echo "<td width=\"25%\"><a href=\"".base_url()."index.php/general/edit_product/".$product->product_id."\" class=\"btn btn-info btn-sm mb-1 m-sm-100\">Edit</a>
											<a href=\"".base_url()."index.php/general/delete_product/".$product->product_id."\" class=\"btn btn-danger btn-sm mb-1 m-sm-100\">Delete</a></td>";
											echo "</tr>";
											$header=$product->heading;
										}?>
									</tbody>
								</table>
								</div>
								<div class="d-flex justify-content-center">
									<ul class="pagination">
										<?php if($page!=1&&$page!=2){?>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page-1);?>">Previous</a></li>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page-2);?>"><?php echo ($page-2);?></a></li>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page-1);?>"><?php echo ($page-1);?></a></li>
										<?php } else if($page!=1){?>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page-1);?>">Previous</a></li>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page-1);?>"><?php echo ($page-1);?></a></li>
										<?php } else {?>
											<li class="page-item disabled"><a class="page-link" href="#" disabled>Previous</a></li>
										<?php }?>
										<li class="page-item active"><a class="page-link" href=""><?php echo $page;?></a></li>
										<?php if($page!=$max_page&&$page!=$max_page-1){?>
											<li class="page_item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page+1);?>"><?php echo ($page+1);?></a></li>
											<li class="page_item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page+2);?>"><?php echo ($page+2);?></a></li>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page+1);?>">Next</a></li>
										<?php } else if($page!=$max_page){?>
											<li class="page_item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page+1);?>"><?php echo ($page+1);?></a></li>
											<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/general/products/<?php echo ($page+1);?>">Next</a></li>
										<?php } else {?>
											<li class="page-item disabled"><a class="page-link" href="#" disabled>Next</a></li>
										<?php }?>
									</ul>
								</div>
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
			$(function(){
				var base_item_price=0;
				var base_item_id=0;
				var base_item_name='';
				opt_required=0;
				category_map=<?php echo json_encode($categories);?>;
				$("#category").on('change',function(){
				    //alert('11');
					//Clear subcategory
					$("#subcategory").html("<option value=\"0\" selected>All subcategories</option>");
					//Populate Subcategory
					for(var i=0;i<category_map.length;i++){
						if(category_map[i].parent_category_id==$("#category option:selected").val()){
							$("#subcategory").append("<option value=\""+category_map[i].category_id+"\">"+category_map[i].category_name+"</option>");
						}
						//Bind subcategory to same function as category
						$("#subcategory").on('change',function(){
							if($("#subcategory option:selected").val()=="0"){
								fetch_next_page("<?php echo base_url();?>index.php/orders/fetch_products_page/1");
							}
						})
					}
					//Load products in this category
					//If category==0, fetch_next_page for page 1
					//Else fetch products in this category
					if($("#category option:selected").val()=="0"){
						fetch_next_page("<?php echo base_url();?>index.php/orders/fetch_products_page/1");
					}
					else{
						$.ajax({
							url:'<?php echo base_url();?>index.php/general/fetch_products_for_category2/'+$("#category option:selected").val(),
							method:"POST",
							success:function(data){
								$("#products_list").html(data);
								$(".pagination").empty();
							}
						})
					}
				})
				$("#subcategory").on('change',function(){
					if($("#subcategory option:selected").val()=="0"){
						fetch_next_page("<?php echo base_url();?>index.php/orders/fetch_products_page/1");
					}
					else{
						$.ajax({
							url:'<?php echo base_url();?>index.php/general/fetch_products_for_category2/'+$("#subcategory option:selected").val(),
							method:"POST",
							success:function(data){
								$("#products_list").html(data);
								$(".pagination").empty();
							}
						})
					}
				})
				
				$("#search").on('keyup',function(){
					if($("#search").val().length>=3){
						//At least 3 characters, trigger search
						$.ajax({
							url:"<?php echo base_url();?>index.php/general/search_products2/"+$("#search").val(),
							method:"GET",
							success:function(data){
								$("#products_list").html(data);
								$(".pagination").empty();
							}
						})
					}
					else if($.trim($("#search").val()=='')){
						//Empty string, bring back original + pagination
						fetch_next_page("<?php echo base_url();?>index.php/orders/fetch_products_page/1");
					}
				})

				})
				</script>
