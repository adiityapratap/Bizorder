<div class="main">
	<div class="section pt-2">
		<div class="container">
			<h2 class="section-title">Past Orders</h2>
			<div class="row">
				<div class="col-md-12">
					<table class="table">
						<thead>
							<tr>
								<th>Order #</th>
								<th>Order Date</th>
								<th>Delivery Date</th>
								<th>Order Total</th>
								<th>Invoice</th>
							</tr>
						</thead>
						<?php foreach($orders as $o){
							$auth_token=sha1($o->firstname."|".$o->lastname."|".$o->order_id."|".$o->order_total);?>
							<tr>
								<td><?php echo $o->order_id;?></td>
								<td><?php echo date("d-m-Y, h:i A",strtotime($o->date_added));?></td>
								<td><?php echo date("d-m-Y, h:i A",strtotime($o->delivery_date_time));?></td>
								<td>$<?php echo number_format($o->order_total,2);?></td>
								<td><a href="http://hospitalcaterings.com.au/ipswich/index.php/orders/print_order/<?php echo $o->order_id."/".$auth_token;?>">View</a></td>
							</tr>
						<?php }?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
