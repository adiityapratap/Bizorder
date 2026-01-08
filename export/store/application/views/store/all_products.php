<style>
.td-name{
	font-size:1.1em!important;
}
td img{
	max-width:120px;
}
thead th{
	font-weight: bold!important;
}
.nav-pills:not(.nav-pills-icons):not(.nav-pills-just-icons) .nav-item .nav-link{
	border-radius:5px;
}
</style>
<div class="main">
	<div class="section pt-2">
		<div class="container">
			<h2 class="section-title">Find what you need</h2>
			<div class="row">
				<div class="col-md-3">
					<div class="collapse-panel">
						<div class="card-body p-0">
							<div class="card card-refine card-plain">
								<div class="card-header" role="tab" id="headingTwo">
									<h4>Categories</h4>
								</div>
								<div id="category_collapse">
									<div class="card-body p-0">
										<ul class="nav nav-pills nav-pills-primary flex-column">
											<?php if(!empty($categories))
											{
												foreach($categories as $category)
												{
													if($cat==$category->category_id)
													{
														echo "<li class=\"nav-item\"><a class=\"nav-link active\" href=\"".base_url()."index.php/store/all_products/1/".$category->category_id."\">".$category->category_name."</a></li>";
													}
													else
													{
														echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"".base_url()."index.php/store/all_products/1/".$category->category_id."\">".$category->category_name."</a></li>";
													}
												}
											}?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-plain">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-shopping">
											<thead class="text-primary">
												<th class="text-center">
												</th>
												<th>
													Product
												</th>
												<th class="text-right">
													Price
												</th>
												<th>Add</th>
											</thead>

											<tbody>
												<?php
												foreach($products as $p){?>
													<?php if(!empty($p->heading)&&$heading!=$p->heading&&empty($p->image)) echo "<tr class=\"parent-row\"><td colspan=\"4\" class=\"td-name\"><span style=\"cursor:pointer\"><strong>".$p->heading." <i class=\"now-ui-icons arrows-1_minimal-down\"></i> <small><strong>(Click to expand)</strong></small></a></strong></td></tr>";else if(!empty($p->heading)&&$heading!=$p->heading&&!empty($p->image)) echo "<tr class=\"parent-row\"><td colspan=\"4\" class=\"td-name\"><span style=\"cursor:pointer\"><img src=\"http://bendigo.hospitalcaterings.com.au/".$p->image."\" class=\"mr-3\"><strong>".$p->heading." <i class=\"now-ui-icons arrows-1_minimal-down\"></i> <small><strong>(Click to expand)</strong></small></a></strong></td></tr>";?>
													<?php if(empty($p->heading)){?>
													<tr class="parent-row">
														<td class="td-name" colspan="2">
															<?php if(!empty($p->product_image)){?>
															<img src="http://bendigo.hospitalcaterings.com.au/<?php echo $p->product_image;?>" alt="..." class="mr-3">
															<?php }?>
															<a href="#!"><strong><?php echo $p->product_name;?></strong></a>
														</td>
														<td class="td-number">
															<?php echo ($p->product_price==0)?($p->option_price==0?("<small>$</small>".number_format($p->product_price,2)):("<small>From $</small> ".number_format($p->option_price,2))):("<small>$</small>".number_format($p->product_price,2));?>
														</td>
														<td class="td-actions">
															<button class="btn btn-danger pull-right" onclick="open_modal('<?php echo $p->product_id;?>')">
																View <i class="now-ui-icons ui-1_simple-add"></i>
															</button>
														</td>
													</tr>
													<?php } else {?>
													<tr class="child-row">
														<?php if(!empty($p->product_image)){?>
															<td class="td-name" colspan="2"><div>
																<img src="http://bendigo.hospitalcaterings.com.au/<?php echo $p->product_image;?>" alt="..." class="mr-3">
																<a href="#!"><strong><?php echo $p->product_name;?></strong></a>
																</div>
															</td>
														<?php } else {?>
															<td class="td-name" colspan="2"><div>
																<a href="#!"><strong><?php echo $p->product_name;?></strong></a>
															</td></div>
														<?php }?>
														<td class="td-number"><div>
															<?php echo ($p->product_price==0)?($p->option_price==0?("<small>$</small>".number_format($p->product_price,2)):("<small>From $</small> ".number_format($p->option_price,2))):("<small>$</small>".number_format($p->product_price,2));?>
														</td></div>
														<td class="td-actions"><div>
															<button class="btn btn-danger pull-right" onclick="open_modal('<?php echo $p->product_id;?>')">
																View <i class="now-ui-icons ui-1_simple-add"></i>
															</button>
														</td></div>
													</tr>
													<?php }
													$heading=$p->heading;
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_label" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-3">
						<img id="product_modal_image" class="rounded" max-height="300px">
						Product Minimum: <span id="product_minimum"></span>
					</div>
					<div class="col-9">
						<div class="row">
							<div class="col-12">
								<h5 class="modal-title" id="product_modal_label" style="display: inline">Product Name</h5>
								<div class='col-12 col-md-2 pull-right text-right'><a href="#!" data-dismiss="modal"><i class="fas fa-times"></i></a></div>	
							</div>
							<div class="col-12" id="product_modal_description"></div>
						</div>
					</div>
				</div>
				<div class="row" id="modal_options"></div>
			</div>
			<div class="modal-footer" id="only_if_no_options">
				<div class="row" style="width:100%;">
					<div class='col-9 col-md-10 text-right'>
						<form class="form-inline pull-right" id="add_to_cart">
							Quantity: <input type="number" id='quantity' class='form-control ml-1' min="0" step="1" required><button type="submit" class="btn btn-primary pull-right ml-3">Add to Cart</button>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="only_if_options">
				<div class="row" style="width:100%;">
					<div class='col-9 col-md-10 text-right'>
						<button type="submit" class="btn btn-primary pull-right ml-3" id="submit_with_options">Add to Cart</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$(".child-row").children().children().slideUp();
		$(".child-row").children().css('padding','0');
		$(".child-row").children().css('border','none');
		$("#only_if_options").hide();
		//Animate child rows
		$(".parent-row").find('td').on('click',function(e){
			//What is the current state?
			console.log($(this).parent("tr").data('state'));
			console.log($(this));
			if($(this).parent("tr").data('state')=='1'){
				//Expanded
				$(this).parent("tr").nextUntil('.parent-row').each(function(){
					$(this).children().children().slideUp();
					$(this).children().animate({'padding':'0','border':'none'});
				})
				$(this).parent("tr").data('state','0');
			}
			else{
				//Collapsed
				//Find all child rows till next parent
				$(this).parent("tr").nextUntil('.parent-row').each(function(){
					$(this).children().children().hide().slideDown();
					$(this).children().animate({'padding-top':'12px','padding-bottom':'12px','padding-left':'7px','padding-right':'7px','border-top':'1px solid #dee2e6'});
				})
				$(this).parent("tr").data('state','1');
			}
		})
		$("#add_to_cart").on('submit',function(e){
			e.preventDefault();
			//Check if options are present
			if($("#product_modal_label").data('options')==0){
				//Check if no_results is present
				if($("#no_results").length==1){
					//If yes, remove it
					$("#no_results").remove();
					//Add a Total row
					$("#cart_header").append("<tr id=\"cart_total_row\"><td>&nbsp;</td><td>Total</td><td>$0.00</td><td>&nbsp;</td></tr><tr><td colspan=\"4\"><a href=\"<?php echo base_url();?>index.php/store/checkout\" class=\"btn btn-primary pull-right\" style=\"font-size:1em\"><i class=\"fas fa-shopping-bag\"></i> Review &amp; Checkout</a></td></tr>");
				}
				//Check if the element already exists; Update quantity and totals if yes
				if($("#item-row-"+$("#product_modal_label").data('product')).length==1){
					var old_qty=parseInt($("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(2)").html());
					var old_total=parseFloat($("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(3)").html().split("$")[1].replace(",",""));
					var new_qty=old_qty+parseInt($("#quantity").val());
					var new_total=old_total+(parseFloat($("#product_modal_label").data('price'))*parseInt($("#quantity").val()));
					$("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(2)").html(new_qty);
					$("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(3)").html("$"+(new_total).toFixed(2));
				}
				else{
					//Generate element for product for cart (without options)
					var elem="<tr id=\"item-row-"+$("#product_modal_label").data('product')+"\"><td>"+$("#product_modal_label").html()+"</td><td>"+$("#quantity").val()+"</td><td>$"+(parseFloat($("#product_modal_label").data('price'))*parseInt($("#quantity").val())).toFixed(2)+"</td><td><button class=\"btn btn-danger btn-icon btn-round\" onclick=\"removeItem('"+$("#product_modal_label").data('product')+"')\"><i class=\"fas fa-times ml-auto mr-auto\"></i></button></td></tr>";
					//Add current product and qty to cart in header
					$("#cart_total_row").before(elem);
					//Also add to the cart in the session using ajax?
					//Todo: Ajax Call
				}
				$.ajax({
					url:'<?php echo base_url();?>index.php/store/add_to_cart',
					method:'POST',
					data:{"product_name":$("#product_modal_label").html(),"product_id":$("#product_modal_label").data('product'),"quantity":$("#quantity").val(),"total":(parseFloat($("#product_modal_label").data('price'))*parseInt($("#quantity").val())),"price":parseFloat($("#product_modal_label").data('price')),"product_minimum":$("#product_minimum").html()},
					success:function(data){
						console.log(data);
					}
				})

				//To-do: Cart total
				calculate_total();
				//To-do: qty_total
				cart_count();

				//Close modal
				$("#product_modal").modal('hide');
			}
		})
	})
	function nl2br (str, is_xhtml) {
		var breakTag = '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}
	function open_modal(product_id){
			//Fetch product, options, etc
			//If options are present, also make it required
			$.ajax({
				url:"<?php echo base_url();?>index.php/store/fetch_product/"+product_id,
				method:"POST",
				success:function(data)
				{
					data=JSON.parse(data);
					console.log(data);
					$("#product_modal_label").html(data.product.heading===null?data.product.product_name:data.product.heading+" - "+data.product.product_name);
					$("#product_modal_image").prop('src','http://bendigo.hospitalcaterings.com.au/'+(data.product.product_image===null?(data.product.image===null?'store/assets/img/filler_image.jpg':data.product.image):data.product.product_image));
					var elem='';
					if(data.product.product_description===null)
						elem+='';
					else elem+=nl2br(data.product.product_description);
					if(data.product.product_desc_1!==null||data.product.product_desc_2!==null||data.product.product_desc_3!==null||data.product.product_desc_4!==null||data.product.product_desc_5!==null)
					{
						//If any one has value
						elem+="<ul>";
						if(data.product.product_desc_1!==null) elem+="<li>"+nl2br(data.product.product_desc_1)+"</li>";
						if(data.product.product_desc_2!==null) elem+="<li>"+nl2br(data.product.product_desc_2)+"</li>";
						if(data.product.product_desc_3!==null) elem+="<li>"+nl2br(data.product.product_desc_3)+"</li>";
						if(data.product.product_desc_4!==null) elem+="<li>"+nl2br(data.product.product_desc_4)+"</li>";
						if(data.product.product_desc_5!==null) elem+="<li>"+nl2br(data.product.product_desc_5)+"</li>";
						elem+="</ul>";
					}
					$("#product_modal_label").data('product',data.product.product_id);
					$("#product_modal_label").data('price',data.product.product_price);
					$("#product_minimum").html(data.product.product_minimum);
					$("#product_modal_description").html(elem);
					$("#product_modal_label").data('options',0);
					//If options
					if(data.options.length!=0){
						//Has options
						var sub_elem="<div class='col-12'><form id=\"add_to_cart_options\"><div class=\"row\"><div class=\"col-12\">Options: </div></div>";
						for(var i=0;i<data.options.length;i++)
						{
							sub_elem+="<div class=\"row mt-2\"><div class=\"col-12 col-md-4 text-right\">"+data.options[i].name+" ($"+parseFloat(data.options[i].option_price).toFixed(2)+")</div><div class=\"col-12 col-md-8\"><input type=\"number\" class=\"form-control\" id=\"quantity-"+data.product.product_id+"_"+data.options[i].product_option_id+"\" data-name=\""+data.options[i].name+"\" data-id=\""+data.options[i].product_option_id+"\" data-price=\""+data.options[i].option_price+"\" min=\"0\" step=\"1\" placeholder=\"0\"></div></div>";
						}
						sub_elem+="<input type=\"submit\" value=\"submit\" style=\"display:none\"></form></div>";
						$("#modal_options").html(sub_elem);
						$("#only_if_no_options").hide();
						$("#only_if_options").show();
						$("#product_modal_label").data('options',1);
						$("#submit_with_options").on('click',function(){
							$("#add_to_cart_options").submit();
						})
						$("#add_to_cart_options").on('submit',function(e){
							e.preventDefault();
							//options present, handle this
							//Check if minimum quantity is met
							var qty=0;
							var flag=0;
							$("[id*='quantity-']").each(function(){
								if($.trim($(this).val())!='')
									qty+=parseInt($(this).val());
							})
							if(qty>=$("#product_modal_label").data('minimum'))
							{
								var total=0.0;
								var qty=0;
								var total_qty=0;
								var price=0;
								//Process each option
								$("[id*='quantity-']").each(function(){
									if($.trim($(this).val())!='')
									{									
										qty=parseInt($(this).val());
										total_qty+=qty;
										price=parseFloat($(this).data('price'));
										total+=qty*price;
										if($.trim($(this).val()!='')){
											$.ajax({
												url:'<?php echo base_url();?>index.php/store/add_to_cart_options',
												method:"POST",
												data:{"product_name":$("#product_modal_label").html(),"product_id":$("#product_modal_label").data('product'),"quantity":$("#quantity").val(),"option_name":$(this).data('name'),"option_id":$(this).data('id'),"option_qty":$(this).val(),"option_price":$(this).data('price'),"price":parseFloat($("#product_modal_label").data('price')),"product_minimum":$("#product_minimum").html()},
												success:function(data)
												{
													console.log(data);
												}
											})
										}
									}
								})
								console.log(total,total_qty,qty,price);
								//Add to header
							}
							else{
								flag=1;
								//Error
								alert('error');
							}
							if(flag==0){
								$("#product_modal").modal('hide');
								if($("#no_results").length==1){
									$("#no_results").remove();
									$("#cart_header").append("<tr id=\"cart_total_row\"><td>&nbsp;</td><td>Total</td><td>$0.00</td><td>&nbsp;</td></tr><tr><td colspan=\"4\"><a href=\"<?php echo base_url();?>index.php/store/checkout\" class=\"btn btn-primary pull-right\" style=\"font-size:1em\"><i class=\"fas fa-shopping-bag\"></i> Review &amp; Checkout</a></td></tr>");
								}
								if($("#item-row-"+$("#product_modal_label").data('product')).length==1){
									var old_qty=parseInt($("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(2)").html());
									var old_total=parseFloat($("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(3)").html().split("$")[1].replace(',',''));
									var new_qty=old_qty+total_qty;
									var new_total=old_total+total;
									$("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(2)").html(new_qty);
									$("#item-row-"+$("#product_modal_label").data('product')).find("td:nth-child(3)").html("$"+(new_total).toFixed(2));
								}
								else{
									var elem="<tr id=\"item-row-"+$("#product_modal_label").data('product')+"\"><td>"+$("#product_modal_label").html()+"</td><td>"+total_qty+"</td><td>$"+total.toFixed(2)+"</td><td><button class=\"btn btn-danger btn-icon btn-round\" onclick=\"removeItem('"+$("#product_modal_label").data('product')+"')\"><i class=\"fas fa-times ml-auto mr-auto\"></i></button></td></tr>";
									$("#cart_total_row").before(elem);
								}
								calculate_total();
								cart_count();
							}
						})
					}
					if($("#item-row-"+data.product.product_id).length==0)
						$("#quantity").prop('min',data.product.product_minimum);
					else
						$("#quantity").prop('min',1);
					$("#product_modal_label").data('minimum',data.product.product_minimum);
					$("#product_modal").modal('show');
				}
			})
}
function calculate_total()
{
	var total=0.0;
	$("[id*='item-row-']").each(function(){
		console.log(parseFloat($(this).find("td:nth-child(3)").html().split("$")[1].replace(',','')));
		total+=parseFloat($(this).find("td:nth-child(3)").html().split("$")[1].replace(',',''));
	})
	$("#cart_total_row").find("td:nth-child(3)").html('$'+total.toFixed(2));
	console.log(total);
}
function cart_count()
{
	var count=0;
	$("[id*='item-row-']").each(function(){
		count+=parseInt($(this).find("td:nth-child(2)").html());
	})
	$("#item_count").html(count);
}
function removeItem(item)
{
	$("#item-row-"+item).remove();
		//Ajax Call
		$.ajax({
			url:"<?php echo base_url();?>index.php/store/remove_from_cart/"+item,
			method:"POST",
			success:function()
			{
				//Do nothing
			}
		})
		calculate_total();
		//asdf
		cart_count();
	}
</script>
