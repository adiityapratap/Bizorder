<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];?>
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
							<h1>Dashboard</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="#!">Home</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Dashboard
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- breadcrumb_End -->

			<!-- Section -->
			<section class="chart_section">
				<div class="row">
					<div class="col-xl-3 col-sm-6 mb-4">
						<div class="card border-0 text-light">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-rocket" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Today's Order</h4>
												<h3><?php echo $deliveries_today;?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 mb-4">
						<div class="card border-0 text-light">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-rocket" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Received Orders</h4>
												<h3><?php echo $deliveries_this_month;?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 mb-4">
						<div class="card border-0 text-light">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-dollar" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Cancelled Orders</h4>
												<h3><?php echo "$".number_format($revenue_this_month,2);?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 mb-4">
						<div class="card border-0 text-light">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-dollar" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Supplier Cost</h4>
											<h3><span class="single-count"><?php echo "$".number_format($total_unpaid,2);?></span></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-xl-12 mb-4">
						<div class="card card-shadow">
							<div class="card-header">
								<div class="card-title">
									Recent Orders
								</div>
							</div>
							<div class="card-body">
									<div class="table-responsive">
									<table class="table table-sm table-bordered">
										<thead class="bg-info text-white">
											<tr>
											
												<th>Order #</th>
												<th>Customer</th>
												<th>Order Date</th>
												<th>Total</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($last_five)){
												foreach($last_five as $order)
												{
												    if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													 $orders_identity = $order->order_made_from;
													}else{
													 $orders_identity = 'backend'; 
													}
													echo "<tr>";
												
													echo "<td>".$order->order_id."</td>";
													echo "<td>".$order->firstname." ".$order->lastname."</td>";
													
													echo "<td>".date("h:i A, d M Y",strtotime($order->delivery_date_time))."</td>";
													echo "<td>$".number_format($order->order_total,2)."</td>";
														if(isset($order->cost_centre) && $order->cost_centre !='' && $order->order_status !=3 && $order->express_order ='') {
												    echo "<td>Approved</td>";
												    
												}	
											else if($order->order_status==1 || $order->order_status=='' || $order->order_status==7 || $order->order_status==0){
													echo "<td>Awaiting approval</td>";
												}
												else if($order->order_status==2){
													echo "<td>Approved</td>";
												}
												else if($order->order_status==3){
													echo "<td>Paid</td>";
												}
												else if($order->order_status==8){
													echo "<td>Rejected</td>";
												}
												else if($order->order_status==9){
													echo "<td>Modify</td>";
												}
												
												else if($order->order_status==5 || $order->order_status==15)
													echo "<td>Complete</td>";
													
												else if($order->order_status==11)
													echo "<td>Waiting for payment</td>";
												else if($order->order_status==12)
													echo "<td>Waiting for Approval</td>";
												else if($order->order_status==13)
													echo "<td>Approved</td>";
													
												else if($order->order_status==14)
													echo "<td>Paid</td>";
													echo "<td>";
												echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm\">View</a>&nbsp;&nbsp;";
													if($order->order_status==15){
														echo "<a href=\"".base_url()."index.php/orders/edit_order/".$order->order_id."\" class=\"btn btn-primary btn-sm ml-1\">Edit</a>";
														?>
														<form action="https://payment.securepay.com.au/secureframe/invoice" method="POST" style="display:inline">
															<input type="hidden" name="bill_name" value="transact">
															<input type="hidden" name="merchant_id" value="2Q40231">
															<input type="hidden" name="txn_type" value="0">
															<input type="hidden" name="amount" value="<?php echo (int)($order->order_total*100);?>">
															<input type="hidden" name="primary_ref" value="<?php echo $order->order_id;?>">
															<input type="hidden" name="fp_timestamp" value="<?php echo gmdate("YmdHis");?>">
												<input type="hidden" name="card_types" value="VISA|MASTERCARD|AMEX">
															<input type="hidden" name="fingerprint" value="<?php echo sha1("2Q40231|Roberta123|0|".$order->order_id."|".(int)($order->order_total*100)."|".gmdate("YmdHis"));?>">
															<input type="hidden" name="return_url" value="<?php echo base_url();?>index.php/orders/payment_process">
															<input type="hidden" name="return_url_text" value="Continue">
															<button class="btn btn-success btn-sm" type="submit">Payment</button>
														</form>
														<?php
														echo "<a href=\"".base_url()."index.php/orders/mark_as_paid/".$order->order_id."/".$referrer."\" class=\"btn btn-danger btn-sm ml-1\">Mark Paid</a>";
													}
													if($order->standing_order==1){
														echo "<button class=\"btn btn-dark btn-sm ml-1\" onclick=\"reorder('".$order->order_id."')\">Reorder</button>";
//														echo "<a href=\"".base_url()."index.php/orders/reorder/".$order->order_id."\" class=\"btn btn-dark btn-sm ml-1\">Reorder</a>";
													}
													echo "</td>";
													echo "</tr>";
												}
											}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				

				

			</section>
			<!-- Section_End -->

		</div>
	</div>
</div>
<!-- Content_right_End -->

<!-- Reorder modal -->
<div class="modal fade" id="reorder_modal" tabindex="-1" role="dialog" aria-labelledby="reorder_title" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="reorder_title">Delivery date and time</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form action="<?php echo base_url();?>index.php/orders/reorder" method="POST" id="reorder_form">
				<input type="hidden" name="order_id" id="reorder_id">
				<div class="row">
					<div class="col-12">
						<label>Delivery Date</label>
						<input type="text" class="form-control datepicker" name="delivery_date" required>
					</div>
					<div class="col-12 mt-3">
						<label>Delivery Time</label>
						<input type="text" class="form-control timepicker" name="delivery_time" required>
					</div>
				</div>
				<div class="row mt-2">
					<div class='col-12'>
						<button type="submit" class="btn btn-info">Proceed</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>

<!-- chart js -->
<script src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<?php $colors=array(
'January'=>'#ecb965',
'February'=>'#f8996e',
'March'=>'#fc7579',
'April'=>'#fc5a85',
'May'=>'#eb5892',
'June'=>'#b76da1',
'July'=>'#768fb2',
'August'=>'#44abbc',
'September'=>'#35b9be',
'October'=>'#35beb8',
'November'=>'#35beae',
'December'=>'#3bbea6'
);?>
<script>
$(function(){
$(".datepicker").datetimepicker({
	format:'YYYY-MM-DD'
})
$(".timepicker").datetimepicker({
	format:'hh:mm a'
})
})
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
	labels: [<?php $a=[];foreach($company_order as $c){$a[]="'".$c->month.", ".$c->year."'";}echo implode(",",$a);?>],
	datasets: [{
		label: 'Monthly sales',
		data: [<?php $a=[];foreach($company_order as $c){$a[]=$c->order_count;}echo implode(",",$a);?>],
		backgroundColor: [
			<?php foreach($company_order as $c) echo "'".$colors["$c->month"]."',";?>
		],
		borderWidth: 0
	}]
},
options: {
	maintainAspectRatio: false,
	legend: {
		display: true
	},
	scales: {
		xAxes: [{
			display: true
		}],
		yAxes: [{
			display: true
		}]
	},
	height:'300px',
	titles:{
		display:false
	}

}
});
function reorder(order_id){
	$("#reorder_id").val(order_id);
	$("#reorder_modal").modal('show');
}
$("#reorder_form").on('submit',function(){
	$("#reorder_modal").modal('hide');
})
function resend_mail(order_id){
	$.ajax({
		url:"<?php echo base_url();?>index.php/orders/resend_mail/"+order_id,
		method:"POST",
		success:function(data){
			if(data==true){
				alert("Approval mail re-sent.");
			}
		}
	})
}
</script>