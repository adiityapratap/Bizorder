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
.td-actions{
	min-width:120px!important;
}
</style>
<div class="main mt-5 pt-5">
	<div class="section pt-2">
		<form id="checkout_form" action="<?php echo base_url();?>index.php/store/move_to_payment" method="POST">
			<div class="container">
				<?php if(isset($fail)){
					echo "<div class=\"col-12 mt-3\" id=\"alert-insufficient\"><div class=\"alert alert-danger\" role=\"alert\"><div class=\"container\"><div class=\"alert-icon\"><i class=\"now-ui-icons objects_support-17\"></i></div><strong>Oops!</strong> Something went wrong and the payment could not be processed. Please try again.<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"now-ui-icons ui-1_simple-remove\"></i></span></button></div></div></div>";
				}?>
				<h3 class="text-center">Review &amp; Checkout</h3>
				<div class="row">
					<div class="col-md-12 bg-primary text-white">
						<h4 class="my-2">Delivery Details</h4>
					</div>
					<div class="col-12 col-md-6 mt-5">
						First Name
						<input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $customer->firstname;?>" required>
					</div>
					<div class="col-12 col-md-6 mt-5">
						Last Name
						<input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $customer->lastname;?>" required>
					</div>
					<div class="col-12 col-md-6 mt-4">
						Email
						<input type="email" class="form-control" name="email" id="email" value="<?php echo $customer->customer_email;?>" required>
					</div>
					<div class="col-12 col-md-6 mt-4">
						Phone
						<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $customer->customer_telephone;?>" required>
					</div>
					<div class="col-12 col-md-6 mt-4">
						Delivery Date and Time
						<input type="text" class="form-control datetimepicker" name="delivery_datetime" id="delivery_datetime" value="<?php echo date("d-m-Y h:i A",strtotime("now +24 hours"));?>"><div class="invalid-feedback">Please give us at least 24 hours to prepare your order.</div>
					</div>
					<div class="col-12 col-md-6 mt-4">
						Shipping Method
						<select class="form-control" name="shipping_method" id="shipping_method"><option value="1">Delivery</option><option value="2">Pickup</option></select>
					</div>
					<div class="col-12 mt-4">
						Delivery Address
						<textarea id="delivery_address" name="delivery_address" class="form-control" required></textarea>
					</div>
					<div class="col-12 mt-4">
						Delivery Notes
						<textarea id="delivery_notes" name="delivery_notes" class="form-control"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 bg-primary text-white" id="review-cart-head">
						<h4 class="my-2">Review Cart</h4>
					</div>
					<div class="col-12 mt-4">
						<table class="table table-shopping">
							<thead class="">
								<th>
									Product
								</th>
								<th class="text-right">
									Price
								</th>
								<th class="text-right">
									Qty
								</th>
								<th class="text-right">
									Amount
								</th>
							</thead>
							<tbody>
								<?php
								if(!empty($cart)){
									$total=0.0;
									foreach($cart as $c){
										$total+=$c['total'];
										if(empty($c['options'])){?>
											<tr id="review-row-<?php echo $c['product_id'];?>">
												<td class="td-name">
													<?php echo $c['product_name'];?>
												</td>
												<td class="td-number">
													<small>$</small><?php echo number_format($c['price'],2);?>
												</td>
												<td class="td-number" style="width:10%;">
													<input type="number" class="form-control text-right" step="1" min="<?php echo $c['product_minimum'];?>" value="<?php echo $c['quantity'];?>">
												</td>
												<td class="td-number">
													<small>$</small><?php echo number_format($c['price']*$c['quantity'],2);?>
												</td>
												<td class="td-actions">
													<button type="button" rel="tooltip" data-placement="left" title="Update Item" class="btn btn-info btn-sm" onclick="update_item(<?php echo $c['product_id'];?>)">
														<i class="fas fa-sync-alt"></i>
													</button>
													<button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-danger btn-sm" onclick="remove_item(<?php echo $c['product_id'];?>)">
														<i class="fas fa-times"></i>
													</button>
												</td>
											</tr>
										<?php }
										else{?>
											<tr id="review-row-<?php echo $c['product_id'];?>">
												<td class="td-name">
													<?php echo $c['product_name'];?>
												</td>
												<td class="td-number">
													<?php if(!empty($c['price'])&&$c['price']!=0) echo "<small>$</small>".number_format($c['price'],2);
													else echo "&nbsp;";
													?>
												</td>
												<td class="td-number" style="width:10%;">
													<input type="number" class="form-control text-right" step="1" min="<?php echo $c['product_minimum'];?>" value="<?php echo $c['quantity'];?>" disabled>
												</td>
												<td class="td-number">
													<small>$</small><?php echo number_format($c['total'],2);?>
												</td>
												<td class="td-actions">
													<button type="button" rel="tooltip" data-placement="left" title="Update Item" class="btn btn-info btn-sm" onclick="update_item_options(<?php echo $c['product_id'];?>)">
														<i class="fas fa-sync-alt"></i>
													</button>
													<button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-danger btn-sm" onclick="remove_item(<?php echo $c['product_id'];?>)">
														<i class="fas fa-times"></i>
													</button>
												</td>
											</tr>
											<?php foreach($c['options'] as $o){?>
												<tr id="review-row-option-<?php echo $c['product_id'];?>-<?php echo $o['po_id'];?>">
													<td class="td-name">
														<?php echo $o['option_name'];?>
													</td>
													<td class="td-number">
														<?php if(!empty($c['price'])&&$c['price']!=0) echo "<small>+$</small>".number_format($o['option_price'],2);
														else echo "<small>$</small>".number_format($o['option_price'],2);
														?>
													</td>
													<td class="td-number" style="width:10%;">
														<input type="number" class="form-control text-right" step="1" value="<?php echo $o['option_qty'];?>">
													</td>
													<td class="td-number">
														<small>$</small><?php echo number_format($o['option_total'],2);?>
													</td>
													<td class="td-actions">
														<button type="button" rel="tooltip" data-placement="left" title="Remove item" class="btn btn-danger btn-sm" onclick="remove_option(<?php echo $o['po_id'];?>,<?php echo $c['product_id'];?>)">
															<i class="fas fa-times"></i>
														</button>
													</td>
												</tr>
											<?php }
										}
									}
								}
								?>
								<tr>
									<td colspan="2">
									</td>
									<td class="td-total">
										Total
									</td>
									<td class="td-price">
										<small>$</small><span id="total_amount"><?php echo number_format($total,2);?></span>
									</td>
									<td>
										&nbsp;
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-12 mt-2">
						Order Comments
						<textarea name="order_comments" class="form-control" placeholder="No sugar? No chillis? Let us know if you need anything!"></textarea>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-md-12 bg-primary text-white">
						<h4 class="my-2">Payment</h4>
					</div>

					<div class="col-12 mt-4">
						Cost Centre
						<input type="text" class="form-control" name="cost_centre" id="cost_centre">
					</div>
					<div class="col-12 mt-4">
						How would you like to complete payment for this order?
					</div>
					<div class="col-12 col-md-4 mt-2">
						<div class="form-check form-check-radio form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="payment_radio" id="payment_radio_1" value="1" checked> Order Approval Request
								<span class="form-check-sign"></span>
							</label>
						</div>
					</div>
					<div class="col-12 col-md-4 mt-2">
						<div class="form-check form-check-radio form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="payment_radio" id="payment_radio_1" value="2" checked> Cost Centre
								<span class="form-check-sign"></span>
							</label>
						</div>
					</div>
					<div class="col-12 col-md-4 mt-2">
						<div class="form-check form-check-radio form-check-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="radio" name="payment_radio" id="payment_radio_2" value="3"> Credit/Debit Card
								<span class="form-check-sign"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary btn-lg pull-right">Place order <i class="fas fa-truck"></i></button>
					</div>
				</div>
			</div>
			<input type="hidden" name="customer_id" value="<?php echo $customer->customer_id;?>">
		</form>
	</div>
</div>
<script>
	$(function(){
		$('.datetimepicker').datetimepicker({
			format:"DD-MM-YYYY hh:mm A",
			icons: {
				time: "fa fa-clock",
				date: "fa fa-calendar",
				up: "fa fa-chevron-up",
				down: "fa fa-chevron-down",
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-remove'
			}
		});
		$("#shipping_method").on('change',function(){
			if($("#shipping_method").val()==1){
				$("#delivery_address").prop('required',true);
			}
			else $("#delivery_address").prop('required',false);
		})
		$("#checkout_form").on('submit',function(e){
			var current=moment([]).tz('Australia/Melbourne');
			var delivery=moment($("#delivery_datetime").val(),"DD-MM-YYYY hh:mm a");
			if(moment.duration(delivery.diff(current)).asDays()<1){
				e.preventDefault();
				$("#delivery_datetime").addClass('is-invalid');
			}
		})
		$("input[name='payment_radio']").on('change',function(){
			if($("input[name='payment_radio']:checked").val()==2)
				$("#cost_centre").prop('required',true);
			else $("#cost_centre").prop('required',false);
		})
	})
	function remove_option(po_id,product_id)
	{
		$.ajax({
			url:'<?php echo base_url();?>index.php/store/remove_option_from_cart/'+product_id+'/'+po_id,
			method:"POST",
			success:function(data){
				//Do nothing
			}
		})
		$("#review-row-option-"+product_id+"-"+po_id).remove();
		//Also remove corresponding tooltip
		$(".tooltip").remove();
		//Also check if parent product had any other options
		if($("[id*='review-row-option-"+product_id+"']").length==0){
			//Did not have options, so remove the product too
			$("#review-row-"+product_id).remove();
		}
		else{
			//Update this product's total and qty
			var total=0.0;
			var qty=0;
			$("[id*='review-row-option-"+product_id+"']").each(function(){
				var amt=parseFloat($(this).find("td:nth-child(4)").html().split('$</small>')[1].replace(",",""));
				var q=parseInt($(this).find("td:nth-child(3)").find('input').val());
				console.log(q);
				qty+=q;
				total+=amt;
			})
			$("#review-row-"+product_id).find("td:nth-child(4)").html('<small>$</small>'+total.toFixed(2));
			$("#review-row-"+product_id).find("td:nth-child(3)").find('input').val(qty);
		}
		calculate_total();
	}
	function remove_item(product_id)
	{
		$.ajax({
			url:'<?php echo base_url();?>index.php/store/remove_from_cart/'+product_id,
			method:"POST",
			success:function(data){
				//Do nothing
			}
		})
		$("#review-row-"+product_id).remove();
		$(".tooltip").remove();
		$("[id*='review-row-option-"+product_id+"-']").each(function(){
			$(this).remove();
		})
		calculate_total();
	}
	function calculate_total()
	{
		var total=0.0;
		$("[id*='review-row-']").each(function()
		{
			if($(this).prop('id').indexOf('option')==-1){
				var amt=parseFloat($(this).find("td:nth-child(4)").html().split('$</small>')[1].replace(',',''));
				total+=amt;
			}
		})
		$("#total_amount").html(total.toFixed(2));
	}
	function update_item(product_id)
	{
		$(".tooltip").remove();
		var qty=$("#review-row-"+product_id).find("td:nth-child(3)").find('input').val();
		qty=parseInt(qty);
		if(qty>=parseInt($("#review-row-"+product_id).find("td:nth-child(3)").find('input').prop('min'))){
			$.ajax({
				url:"<?php echo base_url();?>index.php/store/update_product/"+product_id+"/"+qty,
				method:"POST",
				success:function(data){
					// do nothing
				}
			})
			var amt=parseFloat($("#review-row-"+product_id).find("td:nth-child(2)").html().split('$</small>')[1].replace(",",""));
			$("#review-row-"+product_id).find("td:nth-child(4)").html("<small>$</small>"+(amt*qty).toFixed(2));
			calculate_total();
		}
		else{
			$("#review-row-"+product_id).find("td:nth-child(3)").find('input')[0].reportValidity();
		}
	}
	function update_item_options(product_id)
	{
		$(".tooltip").remove();
		//Total all the options
		var qty=0;
		$("[id*='review-row-option-"+product_id+"']").each(function(){
			qty+=parseInt($(this).find("td:nth-child(3)").find('input').val());
		})
		if(parseInt($("#review-row-"+product_id).find("td:nth-child(3)").find('input').prop('min'))<=qty){
			$("[id*='review-row-option-"+product_id+"']").each(function(){
				//Valid, process all
				$.ajax({
					url:"<?php echo base_url();?>index.php/store/update_item_options/"+product_id+"/"+$(this).prop('id').split('-')[4]+"/"+$(this).find("td:nth-child(3)").find('input').val(),
					method:"POST",
					success:function(data){
						// do nothing
					}
				})
				//Update each product's total
				$(this).find('td:nth-child(4)').html('<small>$</small>'+(parseFloat($(this).find("td:nth-child(2)").html().split('$</small>')[1].replace(",",""))*parseInt($(this).find("td:nth-child(3)").find('input').val())).toFixed(2));
			})
			//Update total
			var total=0.0;
			var qty=0;
			$("[id*='review-row-option-"+product_id+"']").each(function(){
				var amt=parseFloat($(this).find("td:nth-child(4)").html().split('$</small>')[1].replace(",",""));
				var q=parseInt($(this).find("td:nth-child(3)").find('input').val());
				console.log(q);
				qty+=q;
				total+=amt;
			})
			$("#review-row-"+product_id).find("td:nth-child(4)").html('<small>$</small>'+total.toFixed(2));
			$("#review-row-"+product_id).find("td:nth-child(3)").find('input').val(qty);
			//Calculate cart total
			calculate_total();
		}
		else{
			var elem="<div class=\"col-12 mt-3\" id=\"alert-insufficient\"><div class=\"alert alert-danger\" role=\"alert\"><div class=\"container\"><div class=\"alert-icon\"><i class=\"now-ui-icons objects_support-17\"></i></div><strong>Oops!</strong> Cannot update quantities to those because the product wouldn't meet minimum quantity requirement!<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\"><i class=\"now-ui-icons ui-1_simple-remove\"></i></span></button></div></div></div>";
			$("#review-cart-head").after(elem);
		}
	}
</script>