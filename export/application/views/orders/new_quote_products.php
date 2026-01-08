<style>
#loading{
    
    position: absolute;
    z-index: 1000;
       top: 500px;
    left: 600px;
}
</style>
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1>New Quotessasasa</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Quote</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									New Quote
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<form action="<?php echo base_url();?>index.php/orders/new_quote_products" method="POST" id="new_order_form" novalidate>
					<div class="row mb-4">
						<!--Report widget start-->
						<div class="col-6">
							<div class="card card-shadow">
								<div class="card-header">
									<p class="card-title" style="display:inline;">Products</p>
									<?php if($_SESSION['auth_level']==1){?><button class="btn btn-danger pull-right" type="button" data-toggle="modal" data-target="#newProductModal">New Product</button><?php }?>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											Filters:
										</div>
										<div>
										<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']?>">
										</div>
										<div class="col-12">
											<div class="row">
												<div class="col-12 col-md-4">
													<select id="category" class="form-control">
														<option value="0" selected>All categories</option>
														<?php if(!empty($categories)){
															foreach($categories as $category){
																if(is_null($category->parent_category_id))
																	echo "<option value=\"".$category->category_id."\">".ucwords($category->category_name)."</option>";
															}
														}?>
													</select>
												</div>
												<div class="col-12 col-md-4">
													<select id="subcategory" class="form-control">
														<option value="0">All subcategories</div>
														</select>
													</div>
													<div class="col-12 col-md-4">
														<input type="text" class="form-control" id="search" placeholder="Search for products">
													</div>
												</div>
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-12">
												<div class="table-responsive">
													<table class="table table-striped table-sm">
														<thead>
															<tr>
																<th>Product Name</th>
																<th>Category</th>
																<th>Price</th>
																<th>Quantity</th>
																<th>Add</th>
															</tr>
														</thead>
														<tbody id="products_list">
															<?php if(!empty($products)){
																foreach($products as $product){
																	echo "<input type=\"hidden\" id=\"price-".$product->product_id."\" value=\"".$product->product_price."\">";
																	if(!empty($product->heading)&&$heading!=$product->heading){
																		echo "<tr><td colspan=\"5\"><strong>".$product->heading."</strong></td></tr>";
																	}
																	echo "<tr id=\"product-row-".$product->product_id."\" data-heading=\"".$product->heading."\">";
																	echo "<td>".$product->product_name."</td>";
																	echo "<td>".ucwords($product->category_name)."</td>";
																	echo "<td>$".number_format($product->product_price,2)."</td>";
																	echo "<td>";
																	if(empty($product->options)){
																		echo "<input class=\"form-control\" type=\"text\" id=\"qty-".$product->product_id."\" placeholder=\"0\">";
																	}
																	else{
																		echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"open_modal(".$product->product_id.")\">Options</button>";
																	}
																	echo "</td>";
																	echo "<td>";
																	if(empty($product->options))
																		echo "<button type=\"button\" class=\"btn btn-info new-product-form\" id=\"new-product-".$product->product_id."\">Add</button>";
																	echo "</td>";
																	echo "</tr>";
																	$heading=$product->heading;
																}
															}?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card card-shadow">
									<div class="card-header">
									</div>
									<div class="card-body">
								
										<table class="table table-striped table-sm mt-2">
											<thead>
												<tr>
													<th>Product</th>
													<th>Quantity</th>
													<th>Total</th>
													<th>Product Comment</th>
												</tr>
											</thead>
											<tbody>
												<form id="add_new_order">
													<tr id="coupon_id">
														<td>Coupon Code</td>
														<td colspan="3"><input type="text" class="form-control" id="coupon_code" name="coupon_code" data-discount="0" data-type="F"><div class="invalid-feedback">Invalid coupon code!</div></td>
													</tr>
													<tr>
														<td>Total</td>
														<td colspan="3" id="total-cart"></td>
													</tr>
													<tr>
														<td>Order Comments</td>
														<td colspan="3"><input type="text" class="form-control" name="order_comments"></td>
													</tr>
													<tr>
														<td>Standing Order?</td>
														<td colspan="3">
															<label class="control control-solid control-solid-info control--checkbox">
																<input type="checkbox" name="standing_order"/>
																<span class="control__indicator"></span>
															</label>
														</td>
													</tr>
													<tr id="submit-button-row">
														<td colspan="4" class="text-right"><button type="submit" class="btn btn-info submit-button" disabled>Proceed</button></td>
													</tr>
												</form>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!--Report widget end-->
						</div>
						<input type="hidden" name="company" value="<?php echo $company;?>">
						<input type="hidden" name="location_id" value="<?php echo $location_id;?>">
						<input type="hidden" name="customer" value="<?php echo $customer;?>">
						<input type="hidden" name="phone" value="<?php echo $phone;?>">
						<input type="hidden" name="email" value="<?php echo $email;?>">
						<input type="hidden" name="delivery_date_time" value="<?php echo $delivery_date;?>">
						<input type="hidden" name="delivery_notes" value="<?php echo $delivery_notes;?>">
						<input type="hidden" name="shipping_method" value="<?php echo $shipping_method;?>">
						<input type="hidden" name="delivery_fee" value="<?php echo $delivery_fee;?>">
						<?php if($shipping_method==1){?>
							<input type="hidden" name="delivery_address" value="<?php echo $delivery_address;?>">
							<?php } else {?>
								<input type="hidden" name="pickup_location" value="<?php echo $pickup_location;?>">
								<input type="hidden" name="delivery_address" value="<?php echo $delivery_address;?>">
								<?php }?>
							</form>
						</div>
						<!-- Section_End -->
					</div>
				</div>
			</div>
			<!-- Content_right_End -->
		
		<div class="modal fade options-modal" tabindex="-1" role="dialog" aria-labelledby="options-modal-title" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="options-modal-title">Product Options</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-2">Product: </div><div class="col-10 product_name_modal"></div>
						</div>
						<div class="options_grid">
							<table class="table table-striped table-sm mt-3">
								<thead>
									<tr>
										<th id="option-title"></th>
										<th>Base Price Modifier</th>
										<th>Quantity</th>
									</tr>
								</thead>
								<tbody id="options-table"></tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary" onclick="add_options_to_cart()">
							Save changes
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="product-modal-title" aria-hidden="true">
			<div class="modal-dialog modal-lg loader_backkground">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="product-modal-title">New Product</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
							<form id="new_product">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Product Name</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_name" placeholder="New Product" required>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Product Price</label>
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">$</span>
											<input type="text" class="form-control" name="amount" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Quantity to add</label>
									<div class="col-sm-9">
											<input type="text" class="form-control" id="new-product-qty" required>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Category</label>
									<div class="col-sm-9">
										<select class="form-control" name="category" id="category">
											<?php if(!empty($categories)){
												foreach($categories as $cat){
													echo "<option value=\"".$cat->category_id."\">".ucwords($cat->category_name)."</option>";
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
										<textarea class="form-control" name="product_description" placeholder="Description"></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Bullet Description 1</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_desc_1">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Bullet Description 2</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_desc_2">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Bullet Description 3</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_desc_3">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Bullet Description 4</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_desc_4">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Bullet Description 5</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="product_desc_5">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Product Minimum</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="minimum" value="1" required>
									</div>
								</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary" id="product_add" onclick="add_new_product_to_cart()">
							Save changes
						</button>
					</div>
					
				
				</div>
			</div>
				<div id="loading" style="display:none;">
  <p><img  style="height: 30px; width: 304px;" src="<?php echo base_url();?>assets/images/ajax-loader.gif" /></p>
</div>
		</div>	
		
		
		
		
		
		
		
		<script>
		
		
			$(function(){
				var base_item_price=0;
				var base_item_id=0;
				var base_item_name='';
				opt_required=0;
				category_map=<?php echo json_encode($categories);?>;
				$("#category").on('change',function(){
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
							url:'<?php echo base_url();?>index.php/general/fetch_products_for_category/'+$("#category option:selected").val(),
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
							url:'<?php echo base_url();?>index.php/general/fetch_products_for_category/'+$("#subcategory option:selected").val(),
							method:"POST",
							success:function(data){
								$("#products_list").html(data);
								$(".pagination").empty();
							}
						})
					}
				})
				$(".page-link").on('click',function(e){
					e.preventDefault();
					fetch_next_page($(this).attr('href'));
				})
				rebind_submit();
				bind_search();
				$("#coupon_code").on('change',function(){
					//Check coupon code validity
					$("#coupon_code").removeClass('is-invalid');
					$.ajax({
						url:'<?php echo base_url();?>index.php/general/check_coupon/'+$("#coupon_code").val(),
						method:"POST",
						success:function(data){
							console.log(data);
							if(data=="0"){
								$("#coupon_code").addClass('is-invalid');
								$("#coupon_code").data('discount',0);
								$("#coupon_code").data('type','F');
								calculate_total();
							}
							else{
								$("#coupon_code").removeClass('is-invalid');
								data=JSON.parse(data);
								$("#coupon_code").data('discount',data[0].coupon_discount);
								$("#coupon_code").data('type',data[0].type);
								calculate_total();
								console.log(data[0]);
							}
						}
					})
				})
				calculate_total();
			})
			function calculate_total()
			{
				var total=0.0;
				if($("[id*='cart-product-']").length!=0){
					$("[id*='cart-product-']").each(function(){
						if($.trim($(this).find('td:nth-child(3)').html())!='')
						{
							var val=parseFloat($(this).find('td:nth-child(3)').html().split('$')[1]);
							if($(this).find('td:nth-child(3)').html().split('$')[0]=='-')
								total-=val;
							else 
								total+=val;
						}
					})
				}
					//Coupon exists too, factor in to total
					if($("#coupon_code").data('type')=='F')
					{
						total=total-parseFloat($("#coupon_code").data('discount'));
						console.log(parseFloat($("#coupon_code").data('discount')));
					}
					else{
						discount=total*parseFloat($("#coupon_code").data('discount'))/100;
						total=total-discount;
						console.log(discount);
					}
				$("#total-cart").html('$'+total.toFixed(2));
			}
			function fetch_next_page(var_url){
				$.ajax({
					url:var_url,
					method:"POST",
					success:function(data){
						data=JSON.parse(data);
						$("#products_list").html(data[0]);
						$(".pagination").html(data[1]);
						$(".page-link").on('click',function(e){
							e.preventDefault();
							fetch_next_page($(this).attr('href'));
						})
					}
				})
			}
			function rebind_submit()
			{
				
				$("body").on('click','.new-product-form',function(e){
					var id=$(this).prop('id');
					console.log("id= "+id);
					var prod_id=id.split('-')[2];
					
					$("#qty-"+prod_id).removeClass('is-invalid');
					var qty=parseInt($("#qty-"+prod_id).val());
					console.log("qty = "+qty);
					if(qty<=0||isNaN(qty)){
						$("#qty-"+prod_id).addClass('is-invalid');
						return false;
					}
					var prod_name=$("#product-row-"+prod_id).find('td').first().html();
					var prod_heading=$("#product-row-"+prod_id).data("heading");
					if(prod_heading!=''){
						prod_heading=prod_heading+" - ";
					}
					var price=parseFloat($("#price-"+prod_id).val());
					var total=qty*price;
					
					//Check if product is already added; If it is, update quantity and total
					if($("#cart-product-"+prod_id).length!=0){
						//Product already in cart
						var prod_total=parseFloat($("#cart-product-"+prod_id).find('td:nth-child(3)').html().split('$')[1]);
						var old_qty=parseInt($("#cart-product-"+prod_id).find('td:nth-child(2)').html());
						var new_total=total+prod_total;
						var new_qty=qty+old_qty;
						qty=new_qty;
						$("#cart-product-"+prod_id).find('td:nth-child(2)').html(new_qty);
						$("#cart-product-"+prod_id).find('td:nth-child(3)').html('$'+new_total.toFixed(2));

						
					}
					else{
						$("#coupon_id").before("<tr id=\"cart-product-"+prod_id+"\"><td>"+prod_heading+prod_name+"</td><td>"+qty+"</td><td>$"+total.toFixed(2)+"</td><td><p><input type=\"text\" class=\"form-control\" name=\"order_product_comment["+prod_id+"]\"></p></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart("+prod_id+")\"><i class=\"fa fa-remove\"></i></button></td></tr>");
					}
					$("#qty-"+prod_id).val('');
					//Add the product and qty as input type="hidden" fields
					$("#new_order_form").append("<input type=\"hidden\" name=\"qty["+prod_id+"]\" value=\""+qty+"\" id=\"hidden-product-"+prod_id+"\">");
					//Remove disabled if one value is entered
					$(".submit-button").prop('disabled',false);
					calculate_total();
				})
			}
			function bind_search()
			{
				$("#search").on('keyup',function(){
					if($("#search").val().length>=3){
						//At least 3 characters, trigger search
						$.ajax({
							url:"<?php echo base_url();?>index.php/general/search_products/"+$("#search").val(),
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
			}
			function remove_product_from_cart(prod_id){
		prod_id=prod_id.toString();
		if(prod_id.indexOf("_")==-1)
		{
			//If it is parent, remove options too
			prod_id=prod_id.split("_")[0];
			$("[id^='hidden-product-"+prod_id+"']").each(function(){$(this).remove()});
			$("[id^='cart-product-"+prod_id+"']").each(function(){$(this).remove()});
		}
		//Check if it has a parent product which is not a base qty
		if(prod_id.indexOf("_")!=-1&&prod_id.indexOf('_base_qty')==-1){
			//It is a child product without a parent in display
			//Find the parent and update qty to current-deletedQty
			parent_prod_id=prod_id.split("_")[0];
			current_val=$("#hidden-product-"+parent_prod_id).val();
			deleted_val=$("#hidden-product-"+prod_id).val();
			$("#hidden-product-"+parent_prod_id).val(current_val-deleted_val);
		}
		//Finally, rmeove the options themselves
		$("#hidden-product-"+prod_id).remove();
		$("#cart-product-"+prod_id).remove();
		calculate_total();
	}
			function open_modal(product_id){
				base_item_id=product_id;
				$("#options-table").html('');
				$.ajax({
					url:"<?php echo base_url();?>index.php/general/fetch_product_options/"+product_id,
					method:"POST",
					success:function(data){
						data=JSON.parse(data);
						console.log(data);
						$(".product_name_modal").html(data[0].product_name);
						$("#option-title").html(data[0].option_title);
						base_item_price=data[0].product_price;
						base_item_name=data[0].product_name;
						base_item_heading=data[0].heading;
						var elem='';
						if(data[0].option_required==0){
							elem+="<tr>";
							elem+="<td>Base Quantity</td>";
							elem+="<td>&nbsp;</td>";
							elem+="<td><input type=\"text\" class=\"form-control option-input\" id=\"base_qty\" data-name=\"Base Quantity\" data-price=\""+base_item_price+"\"></td>";
							elem+="</tr>";
						}
						else{
							opt_required=1;
						}
						for(var i=0;i<data.length;i++){
							elem+="<tr>";
							elem+="<td>"+data[i].option_name+"</td>";
							elem+="<td>"+data[i].option_price_prefix+" $"+(parseFloat(data[i].option_price).toFixed(2))+"</td>";
							elem+="<td><input type=\"text\" class=\"form-control option-input\" id=\""+data[i].option_value_id+"\" data-name=\""+data[i].option_name+"\" data-prefix=\""+data[i].option_price_prefix+"\" data-price=\""+data[i].option_price+"\" data-productoption=\""+data[i].product_option_id+"\"></td>";
							elem+="</tr>";
						}

						$("#options-table").append(elem);
						$('.options-modal').modal('show');
					}
				})
			}
			function add_options_to_cart()
			{
				var total_qty=0;
				console.log(base_item_id,base_item_name,base_item_heading,base_item_price);
				$(".option-input").each(function(){
					if($(this).val()!=0||$.trim($(this).val())!='')
					{
						console.log($(this).val());
						total_qty+=parseInt($(this).val());
					}
				})
				//Append base item
				console.log((parseInt(total_qty)*((parseFloat($(this).data('prefix')+base_item_price)))).toFixed(2));
				base_item_heading=($.trim(base_item_heading)!='')?$.trim(base_item_heading)+" - ":'';
				$("#coupon_id").before("<tr id=\"cart-product-"+base_item_id+"\"><td>"+base_item_heading+base_item_name+"</td><td>"+total_qty+"</td><td>$"+(parseInt(total_qty)*(parseFloat(base_item_price))).toFixed(2)+"</td><td><p><input type=\"text\" class=\"form-control\" name=\"order_product_comment["+base_item_id+"]\"></p></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart('"+base_item_id+"')\"><i class=\"fa fa-remove\"></i></button></td></tr>");
				$(".option-input").each(function(){
					if($(this).val()!=0||$.trim($(this).val())!='')
					{
						//Add to cart AND hidden elems
						//Price is (base_item_price+(option_price_prefix+option_price))*qty
						var temp_prefix=$(this).data('prefix');
						var temp_price=temp_prefix=='-'?parseFloat($(this).data('price'))*(-1):parseFloat($(this).data('price'));
						$("#coupon_id").before("<tr id=\"cart-product-"+base_item_id+"_"+$(this).prop('id')+"\"><td>"+$(this).data('name')+"</td><td>"+$(this).val()+"</td><td>"+temp_prefix+"$"+(parseInt($(this).val())*((parseFloat($(this).data('price'))))).toFixed(2)+"</td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart('"+base_item_id+"_"+$(this).prop('id')+"')\"><i class=\"fa fa-remove\"></i></button></td></tr>");
						$("#new_order_form").append("<input type=\"hidden\" name=\"option["+$(this).data('productoption')+"]\" value=\""+$(this).val()+"\" id=\"hidden-product-"+base_item_id+"_"+$(this).prop('id')+"\">");
						
						//Close modal
						
						$(".submit-button").prop('disabled',false);
						$(".options-modal").modal('hide');
					}
				})
				if($("#hidden-product-"+base_item_id).length==0)
					$("#new_order_form").append("<input type=\"hidden\" name=\"qty["+base_item_id+"]\" value=\""+total_qty+"\" id=\"hidden-product-"+base_item_id+"\">");
				else
					$("#hidden-product-"+base_item_id).val(parseInt($("#hidden-product-"+base_item_id).val())+total_qty);
				calculate_total();
				base_item_heading='';
			}
			function add_new_product_to_cart()
			{
				//Add new product to db
				$("#new-product-qty").removeClass('is-invalid');
				var qty=parseInt($("#new-product-qty").val());
			
				if(qty==0||isNaN(qty)){
					$("#new-product-qty").addClass('is-invalid');
					return false;
				}
				else{
					$.ajax({
						url:'<?php echo base_url();?>index.php/general/add_new_product_from_modal',
						method:"POST",
						data:$("#new_product").serialize(),
						beforeSend: function(){
						  $(".loader_backkground").css('opacity','0.1') ;
						  $("#loading").css('opacity','1');
						  $("#product_add").attr("disabled", true);
                          $("#loading").show();
                          
                                },
						success:function(data){
						    
							data=JSON.parse(data);
							var prod_id=data.product_id;
							var qty=parseInt($("#new-product-qty").val());
							var prod_name=data.product_name;
							var price=parseFloat(data.product_price);
							var total=qty*price;
							//Check if product is already added; If it is, update quantity and total
							$("#coupon_id").before("<tr id=\"cart-product-"+prod_id+"\"><td>"+prod_name+"</td><td>"+qty+"</td><td>$"+total.toFixed(2)+"</td><td><p><input type=\"text\" class=\"form-control\" name=\"order_product_comment["+prod_id+"]\"></p></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart('"+prod_id+"')\"><i class=\"fa fa-remove\"></i></button></td></tr>");
							$("#new_order_form").append("<input type=\"hidden\" name=\"qty["+prod_id+"]\" value=\""+qty+"\" id=\"hidden-product-"+prod_id+"\">");
							//Remove disabled if one value is entered
							$(".submit-button").prop('disabled',false);
							$("#newProductModal").modal('hide');
						},
						complete:function(data){
   
                        $("#loading").hide();
                         $(".loader_backkground").css('opacity','1');
                         $("#product_add").attr("disabled", false);
                             }
					})
				}
				calculate_total();
			}
			</script>
