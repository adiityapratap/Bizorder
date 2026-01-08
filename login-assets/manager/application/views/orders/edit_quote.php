
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
							<h1>Edit Quote</h1>
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
									Edit Quote
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<div class="container-fluid">
				<form action="<?php echo base_url();?>index.php/orders/edit_quote_process/<?php echo $order_info->order_id;?>" method="POST" id="new_order_form" novalidate>
					<div class="row mb-4">
						<!--Report widget start-->
						<div class="col-7">
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
										<div class="col-12">
											<div class="row">
												<div class="col-12 col-md-9 mb-3">
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
															<?php if(!empty($products) && $ostatus != 3){
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
										<div class="col-12 d-flex justify-content-center">
											<ul class="pagination">
												<li class="page-item disabled"><a class="page-link" href="#" disabled>Previous</a></li>
												<li class="page-item active"><a class="page-link" href=""><?php echo $page;?></a></li>
												<li class="page_item"><a class="page-link" href="<?php echo base_url();?>index.php/orders/fetch_products_page/<?php echo ($page+1);?>"><?php echo ($page+1);?></a></li>
												<li class="page_item"><a class="page-link" href="<?php echo base_url();?>index.php/orders/fetch_products_page/<?php echo ($page+2);?>"><?php echo ($page+2);?></a></li>
												<li class="page-item"><a class="page-link" href="<?php echo base_url();?>index.php/orders/fetch_products_page/<?php echo ($page+1);?>">Next</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-5">
								<div class="card card-shadow">
									<div class="card-header">
										<h3 class="card-title">Cart</h3>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-12"><strong>Approval Comments</strong></div>
											<div class="col-12"><?php echo empty($order_info->approval_comments)?'No comments added':$order_info->approval_comments;?></div>
										</div>
										<?php
										
										if(isset($order_info->express_order_products) && $order_info->express_order_products !='') {  ?>
										<div class="row">
											<div class="col-12"><strong>Express Order Products</strong></div>
											<?php 
											$prod_list = explode(',', $order_info->express_order_products);
										
											
											?>
											
											<div class="col-12">
											<?php 
											
											echo "<ul>";
											
											for($i=0;$i< sizeof($prod_list);$i++){
											    
											echo "<li>".$prod_list[$i]."</li>";
											
											}
											echo "</ul>";
											
										    ?>
											
											
											</div>
										</div>
										<?php } ?>
										<table class="table table-striped table-sm mt-2 grid" id="sort">
											<thead>
												<tr>
													<th class='index'>Product</th>
													<th>Quantity</th>
													<th>Total</th>
													<th>Product Comment</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<form id="add_new_order">
													<?php 
														if(!empty($order_product_options)){
															foreach($order_product_options as $opo){
																echo "<tr id=\"cart-existing-item-".$opo->order_product_id."\">";
																if(!empty($product->heading)) $heading=$opo->heading." - ";
																else $heading='';
																echo "<td class='index'>".$heading.$opo->product_name."</td>";
																if(!empty($opo->options))
																if($ostatus == 3){
							echo "<td><input disabled type=\"text\" class=\"form-control\" id=\"existing-product-".$opo->order_product_id."\" value=\"".$opo->quantity."\" disabled required></td>";
				    
																}else{
							echo "<td><input type=\"text\" class=\"form-control\" id=\"existing-product-".$opo->order_product_id."\" value=\"".$opo->quantity."\" disabled required></td>";
  
																}
																else 
																
																	if($ostatus == 3){
							echo "<td><input disabled type=\"text\" class=\"form-control\" id=\"existing-product-".$opo->order_product_id."\" value=\"".$opo->quantity."\"  required></td>";
								echo "<td id=\"total-".$opo->order_product_id."\" data-price=\"".$opo->price."\">$".number_format($opo->total,2)."</td>";
																echo "<td><p><input disabled type=\"text\" class=\"form-control\" value=\"".$opo->order_product_comment."\" name=\"existing_order_product_comment[".$opo->order_product_id."]\"></p></td>";
																echo "<td><button disabled class=\"btn btn-danger\" type=\"button\" onclick=\"remove_from_cart(".$opo->order_product_id.")\"><i class=\"fa fa-remove\"></i></button></td>";
																echo "</tr>";
				    
																}else{
																	echo "<td><input type=\"text\" class=\"form-control\" id=\"existing-product-".$opo->order_product_id."\" value=\"".$opo->quantity."\" onkeyup=\"update_qty('".$opo->order_product_id."')\" required></td>";
																   	echo "<td id=\"total-".$opo->order_product_id."\" data-price=\"".$opo->price."\">$".number_format($opo->total,2)."</td>";
																echo "<td><p><input type=\"text\" class=\"form-control\" value=\"".$opo->order_product_comment."\" name=\"existing_order_product_comment[".$opo->order_product_id."]\"></p></td>";
																echo "<td><button class=\"btn btn-danger\" type=\"button\" onclick=\"remove_from_cart(".$opo->order_product_id.")\"><i class=\"fa fa-remove\"></i></button></td>";
																echo "</tr>";
																    
																}
															
																if(!empty($opo->options)){
																	foreach($opo->options as $option){
																		echo "<tr id=\"cart-existing-item-".$opo->order_product_id."_".$option->order_product_option_id."\">";
																		echo "<td class='index'>Option - ".$option->name."</td>";
																		echo "<td><input type=\"text\" class=\"form-control\" id=\"existing-option-".$opo->order_product_id."_".$option->order_product_option_id."\" value=\"".$option->option_quantity."\" onkeyup=\"update_qty('".$opo->order_product_id."_".$option->order_product_option_id."')\" required></td>";
																		echo "<td id=\"total-".$opo->order_product_id."_".$option->order_product_option_id."\" data-price=\"".$option->option_price."\" data-prefix=\"".$option->option_price_prefix."\">$".number_format($option->option_total,2)."</td>";
																		echo "<td><button class=\"btn btn-danger\" type=\"button\" onclick=\"remove_from_cart('".$opo->order_product_id."_".$option->order_product_option_id."')\"><i class=\"fa fa-remove\"></i></button></td>";
																		echo "</tr>";
																	}
																}
															}
															foreach($order_product_options as $opo){
																echo "<input type=\"hidden\" id=\"hidden-existing-item-".$opo->order_product_id."\" name=\"existing_qty[".$opo->order_product_id."]\" value=\"".$opo->quantity."\">";
																if(!empty($opo->options)){
																	foreach($opo->options as $option){
																		echo "<input type=\"hidden\" id=\"hidden-existing-item-".$opo->order_product_id."_".$option->order_product_option_id."\" name=\"existing_option[".$option->order_product_option_id."]\" value=\"".$option->option_quantity."\">";
																	}
																}
															}
														}
														?>
														
														
														
														<tr id="coupon_id">
															<td>Coupon Code</td>
															<td colspan="3"><input type="text" class="form-control" id="coupon_code" name="coupon_code" data-discount="<?php empty($order_info->coupon_discount)?0:$order_info->coupon_discount;?>" data-type="<?php empty($order_info->type)?'F':$order_info->type;?>" value="<?php echo $order_info->coupon_code;?>"><div class="invalid-feedback">Invalid coupon code!</div></td>
														</tr>
														
															<tr>
																<td>Customer Name</td>
																<td colspan="3"><input type="text" class="form-control name" name="customer_order_name" value="<?php echo $order_info->customer_order_name;?>">
																<input type="hidden" class="form-control name" name="cust_id" value="<?php echo $order_info->customer_id;?>">
																</tr>
																<tr>
																<td>Customer Email</td>
																<td colspan="3"><input type="text" class="form-control email" name="customer_order_email" value="<?php echo $order_info->customer_order_email;?>">
																</tr>
																
															<tr>
																<td>Customer Telephone</td>
																<td colspan="3"><input type="text" class="form-control telephone" name="customer_order_telephone" value="<?php echo $order_info->customer_order_telephone;?>">
																</tr>	
															<tr>
																<td>Delivery Contact Number</td>
																<td colspan="3"><input type="number" class="form-control " name="delivery_telephone" id="delivery_telephone" value="<?php echo !empty($order_info->delivery_phone)?$order_info->delivery_phone:'';?>"></td>
															</tr>
															<tr>
																<td>Account Email</td>
																<td colspan="3"><input type="email" class="form-control " name="accounts_email" id="accounts_email" value="<?php echo !empty($order_info->accounts_email)?$order_info->accounts_email:'';?>"></td>
															</tr>
														    <tr>
															<td>Delivery Date</td>
															<td colspan="3"><input type="text" class="form-control datepicker" name="delivery_date" value="<?php echo date("d-m-Y",strtotime($order_info->delivery_date_time));?>">
															</tr>
															<tr>
																<td>Delivery Time</td>
																<td colspan="3"><input type="text" class="form-control timepicker" name="delivery_time" value="<?php echo date("H:i",strtotime($order_info->delivery_date_time));?>">
																</tr>
																
																<tr>
																<td>Delivery Address</td>
																<td colspan="3">
																 
																    <textarea class="form-control" name="delivery_addr" id="delivery_address" rows="4">
										<?php echo !empty($order_info->delivery_address)? strip_tags(nl2br($order_info->delivery_address)) :'
Gate Number : 
Building Number :
Level :
Room Number/Name :';?></textarea>
																  
																</tr>
																
																	<tr>
																<td>Company Name</td>
																<td colspan="3"><input type="text" class="form-control addr" name="company_name" value="<?php echo $order_info->customer_company_name;?>">
																
																</tr>
																<tr>
																<td>Company Address</td>
																<td colspan="3"><input type="text" class="form-control addr" name="comp_addr" value="<?php echo $order_info->customer_company_addr	;?>">
																<input type="hidden" class="form-control addr" name="comp_addr_id" value="<?php echo $order_info->company_id;?>">
																</tr>
																
																<tr>
																<td>Department Name</td>
																<td colspan="3"><input type="text" class="form-control addr" name="department_name" value="<?php echo $order_info->customer_department_name;?>">
																
																</tr>
																
																<tr>
																	<td>Delivery Notes</td>
																	<td colspan="3"><input type="text" class="form-control" name="delivery_notes" value="<?php echo $order_info->pickup_delivery_notes;?>">
																	</tr>
																	<tr>
																		<td>Order Comments</td>
																		<td colspan="3"><input type="text" class="form-control" name="order_comments" value="<?php echo $order_info->order_comments;?>"></td>
																	</tr>
																	<!--<tr>-->
																	<!--	<td>Cost Centre</td>-->
																	<!--	<td colspan="3"><input type="text" class="form-control" name="cost_centre" value="<?php echo $order_info->cost_centre;?>"></td>-->
																	<!--</tr>-->
																	<tr>
																		<td>Delivery Fee</td>
																		<td colspan="3"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text">$</div></div><input type="text" class="form-control" name="delivery_fee" value="<?php echo number_format($order_info->delivery_fee,2);?>"></div></td>
																	</tr>
																	<!--<tr>-->
																	<!--	<td>Total</td>-->
																	<!--	<td colspan="3" id="total-cart"></td>-->
																	<!--</tr>-->
																	<!--<tr>-->
																	<!--	<td>Standing Order?</td>-->
																	<!--	<td colspan="3">-->
																	<!--		<label class="control control-solid control-solid-info control--checkbox">-->
																	<!--			<input type="checkbox" name="standing_order"/>-->
																	<!--			<span class="control__indicator"></span>-->
																	<!--		</label>-->
																	<!--	</td>-->
																	<!--</tr>-->
																	<tr id="submit-button-row">
																		<td colspan="4" class="text-right"><button type="submit" class="btn btn-info submit-button">Proceed</button></td>
																	</tr>
																</form>
															</tbody>
														</table>
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
					<div class="modal-dialog modal-lg">
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
								
								
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary loadingBtn" onclick="add_new_product_to_cart()">
									Save changes
								</button>
							</div>
						</div>
					</div>
				</div>
			 
  
				<script>
				
		 $('.grid tbody').sortable(); 
		 
		 $('.grid tbody').sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        
        var data = data.replace("cart-product", "cart-existing-item");
        
      
        

        // POST to server using $.post or $.ajax
      	                         $.ajax({
									url:"<?php echo base_url();?>index.php/orders/chnage_product_sort_order",
									method:"POST",
									data:data,
									success:function(data){
									console.log("position saved");
									}
								})
    }
});
				
					$(function(){
					   
					    
						$("tr[id*='product-row']").each(function()
						{
							console.log($(this).data('heading'));
						})
						
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
						if($("[id*='total-']").length!=0){
							$("[id*='total-']").each(function(){
								if($.trim($(this).html())!=''&&$(this).prop('id')!='total-cart')
								{
								    
								    
									var val=parseFloat($(this).html().split('$')[1]);
									
									total+=val;
								}
							})
							return false;
						}
						
					
						if($.trim($("#coupon_code").val()!=''))
						{
							//Coupon exists too, factor in to total
							if($("#coupon_code").data('type')=='F')
							{
								total=total-parseFloat($("#coupon_code").data('discount'));
							}
							else{
								if($("#coupon_code").data('discount')==0||total==0)
									discount=0;
								else discount=total*parseFloat($("#coupon_code").data('discount'))/100;
								total=total-discount;
							}
				
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
						console.log('rebind');
						$("body").on('click','.new-product-form',function(e){
							var id=$(this).prop('id');
							var prod_id=id.split('-')[2];
							$("#qty-"+prod_id).removeClass('is-invalid');
							var qty=parseInt($("#qty-"+prod_id).val());
							console.log(qty);
							if(qty==0||isNaN(qty)){
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
						$("#coupon_id").before("<tr id=\"cart-product-"+base_item_id+"\"><td>"+base_item_heading+base_item_name+"</td><td>"+total_qty+"</td><td id=\"total-"+base_item_id+"\">$"+(parseInt(total_qty)*(parseFloat(base_item_price))).toFixed(2)+"</td><td><p><input type=\"text\" class=\"form-control\" name=\"order_product_comment["+base_item_id+"]\"></p></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart('"+base_item_id+"')\"><i class=\"fa fa-remove\"></i></button></td></tr>");
						$(".option-input").each(function(){
							if($(this).val()!=0||$.trim($(this).val())!='')
							{
								//Add to cart AND hidden elems
								//Price is (base_item_price+(option_price_prefix+option_price))*qty
								var temp_prefix=$(this).data('prefix')=='-'?'-':'';
								var temp_price=temp_prefix=='-'?parseFloat($(this).data('price'))*(-1):parseFloat($(this).data('price'));
								$("#coupon_id").before("<tr id=\"cart-product-"+base_item_id+"_"+$(this).prop('id')+"\"><td>"+$(this).data('name')+"</td><td>"+$(this).val()+"</td><td id=\"total-"+$(this).prop('id')+"\">"+"$"+temp_prefix+(parseInt($(this).val())*((parseFloat($(this).data('price'))))).toFixed(2)+"</td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart('"+base_item_id+"_"+$(this).prop('id')+"')\"><i class=\"fa fa-remove\"></i></button></td></tr>");
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
					function remove_from_cart(prod_id){
						console.log(prod_id);
						console.log($("#hidden-existing-item-"+prod_id).val());
						//Check if it has options
						if($("[id^='hidden-existing-item-"+prod_id+"']").length>1)
						{
							//It is a parent with options
							//Add product to delete queue
							$("#new_order_form").append("<input type=\"hidden\" name=\"delete[]\" value=\""+prod_id+"\">");
							//Remove options and parent
							$("#cart-existing-item-"+prod_id).remove();
							$("[id^='cart-existing-item-"+prod_id+"']").each(function(){$(this).remove()});
							$("#hidden-existing-item-"+prod_id).remove();
							$("[id^='hidden-existing-item-"+prod_id+"']").each(function(){$(this).remove()});
						}
						//Else if it has no options but is not an option itself
						else if($("[id^='hidden-existing-item-"+prod_id+"']").length==1&&typeof prod_id=='number'){
							//Just remove this item frmo cart and hidden
							$("#cart-existing-item-"+prod_id).remove();
							$("#hidden-existing-item-"+prod_id).remove();
							$("#new_order_form").append("<input type=\"hidden\" name=\"delete[]\" value=\""+prod_id+"\">");
						}
						else{
							//It is an option itself, check if parent needs an option (denoted by 'disabled' on input qty)
							//Look for first part of prod_id before '_'
							var parent_prod_id=prod_id.split('_')[0];
							//Check if parent product is disabled
							if($("#existing-product-"+parent_prod_id).hasClass('disabled')){
								//Update qty in parent, where new_qty=old_qty-deleted_qty
								$("#existing-product-"+parent_prod_id).val(parseInt($("#existing-product-"+parent_prod_id).val())-parseInt($("#hidden-existing-item-"+prod_id).val()));
								$("#hidden-existing-item-"+parent_prod_id).val(parseInt($("#existing-product-"+parent_prod_id).val())-parseInt($("#hidden-existing-item-"+prod_id).val()));
								//Remove option from cart and hidden, mark for delete
								$("#cart-existing-item-"+prod_id).remove();
								$("#hidden-existing-item-"+prod_id).remove();
								$("#new_order_form").append("<input type=\"hidden\" name=\"delete_option[]\" value=\""+prod_id+"\">");
							}
							else{
								//Else just remove this option from cart, hidden and mark for delete
								$("#cart-existing-item-"+prod_id).remove();
								$("#hidden-existing-item-"+prod_id).remove();
								$("#new_order_form").append("<input type=\"hidden\" name=\"delete_option[]\" value=\""+prod_id+"\">");
							}
						}
						calculate_total();
					}
					function update_qty(input_id){
						//existing-product-input_id
						//existing-option-input_id
						if(input_id.indexOf("_")==-1){
							//Parent
							$("#hidden-existing-item-"+input_id).val($("#existing-product-"+input_id).val());
							//Also update total in row, iff $("#existing-product-"+input_id).val() !=''
							if($("#existing-product-"+input_id).val()!='')
								$("#total-"+input_id).html('$'+(parseInt($("#existing-product-"+input_id).val())*parseFloat($("#total-"+input_id).data('price'))).toFixed(2));
						}
						else{
							//option
							var parent_prod_id=input_id.split("_")[0];
							var regexp=/^\d+/;
							if($("#existing-product-"+parent_prod_id).prop('disabled')==true){
								console.log($("#existing-option-"+input_id).val());
								console.log($("#existing-option-"+input_id).data('prefix'));
								//if parent is disabled, update that too
								if(!regexp.test($("#existing-option-"+input_id).val()))
									$("#existing-option-"+input_id).val('0');
								$("#existing-product-"+parent_prod_id).val(parseInt($("#existing-product-"+parent_prod_id).val())-parseInt($("#hidden-existing-item-"+input_id).val())+parseInt($("#existing-option-"+input_id).val()));
								$("#hidden-existing-item-"+parent_prod_id).val($("#existing-product-"+parent_prod_id).val());
								$("#hidden-existing-item-"+input_id).val($("#existing-option-"+input_id).val());
								//Also update prices in row
								$("#total-"+input_id).html('$'+(parseInt($("#existing-option-"+input_id).val())*parseFloat($("#total-"+input_id).data('prefix')+$("#total-"+input_id).data('price'))).toFixed(2))
								console.log('$'+(parseInt($("#existing-option-"+input_id).val())*parseFloat($("#total-"+input_id).data('prefix')+$("#total-"+input_id).data('price'))).toFixed(2));
							}
							else{
								//just update current
								$("#hidden-existing-item-"+input_id).val($("#existing-option-"+input_id).val());
								//Also update total in row, iff $("#existing-product-"+input_id).val() !=''
								if($("#existing-product-"+input_id).val()!='')
									//Also update prices in row
									$("#total-"+input_id).html('$'+(parseInt($("#existing-option-"+input_id).val())*parseFloat($("#total-"+input_id).data('prefix')+$("#total-"+input_id).data('price'))).toFixed(2))
							}
						}
						calculate_total();
					}
					function add_new_product_to_cart()
					{
					    $(".loadingBtn").html("Adding...");
						//Add new product to db
						$("#new-product-qty").removeClass('is-invalid');
						var qty=parseInt($("#new-product-qty").val());
						console.log(qty);
						if(qty==0||isNaN(qty)){
							$("#new-product-qty").addClass('is-invalid');
							return false;
						}
						else{
							$.ajax({
								url:'<?php echo base_url();?>index.php/general/add_new_product_from_modal',
								method:"POST",
								data:$("#new_product").serialize(),
								success:function(data){
									data=JSON.parse(data);
									var prod_id=data.product_id;
									var qty=parseInt($("#new-product-qty").val());
									var prod_name=data.product_name;
									var price=parseFloat(data.product_price);
									var total=qty*price;
									//Check if product is already added; If it is, update quantity and total
									$("#coupon_id").before("<tr id=\"cart-product-"+prod_id+"\"><td>"+prod_name+"</td><td>"+qty+"</td><td>$"+total.toFixed(2)+"</td><td><p><input type=\"text\" class=\"form-control\" name=\"order_product_comment["+prod_id+"]\"></p></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"remove_product_from_cart("+prod_id+")\"><i class=\"fa fa-remove\"></i></button></td></tr>");
									$("#new_order_form").append("<input type=\"hidden\" name=\"qty["+prod_id+"]\" value=\""+qty+"\" id=\"hidden-product-"+prod_id+"\">");
									//Remove disabled if one value is entered
									$(".submit-button").prop('disabled',false);
									$("#newProductModal").modal('hide');
								}
							})
						}
						calculate_total();
					}
					</script>