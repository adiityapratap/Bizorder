<div class="main mt-5 pt-5">
	<div class="section pt-2">
		<div class="container">
			<h3 class="text-center">Order Successful!</h3>
			<div class="row">
				<div class="col-12">
					Your order has been successfully placed
					<?php if($paid==1){?>
						and payment for this order has been received. Your order number is: <?php echo $order_id;?><br>Your invoice has been sent to the provided email ID. Thank you for eating healthy with us!
					<?php } else {?>
						.<br>This order has been approved. Your order number is: <?php echo $order_id;?><br>Your purchase order has been sent to the provided email ID. Thank you for eating healthy with us!
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>