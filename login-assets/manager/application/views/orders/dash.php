<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];?>
<!-- header_End -->
<style>
    .btn-outline-orange:hover,
.btn-outline-orange:not([disabled]):not(.disabled).active,
.btn-outline-orange:not([disabled]):not(.disabled):active,
.btn-orange,
.card-orange,
.show>.btn-outline-orange.dropdown-toggle {
	border-color: #f98021;
	background-color: #f98021;
}
.btn-orange,.btn-yellow,.btn-blue,.btn-pink,.btn-green{
	color:#fff;
}
.btn-orange:hover{
	background-color:white;
	border-color:#ff7000;
	color:black;
}
.btn-outline-yellow:hover,
.btn-outline-yellow:not([disabled]):not(.disabled).active,
.btn-outline-yellow:not([disabled]):not(.disabled):active,
.btn-yellow,
.card-yellow,
.show>.btn-outline-yellow.dropdown-toggle {
	border-color: #ffbf36;
	background-color: #ffbf36;
}

.btn-yellow:hover{
	background-color:white !important;
	color:black !important;
}
.btn-red{
  border-color: red;
	background-color: red; 
	color:white;
}
.btn-red:hover{
  	background-color: white !important; 
	color:black !important;  
}
.btn-outline-blue:hover,
.btn-outline-blue:not([disabled]):not(.disabled).active,
.btn-outline-blue:not([disabled]):not(.disabled):active,
.btn-blue,
.card-blue,
.show>.btn-outline-blue.dropdown-toggle {
	border-color: #464497;
	background-color: #464497;
}

.btn-blue:hover{
	background-color:white !important;
	border-color:#131070;
	color:black !important;
}
.btn-outline-pink:hover,
.btn-outline-pink:not([disabled]):not(.disabled).active,
.btn-outline-pink:not([disabled]):not(.disabled):active,
.btn-pink,
.card-pink,
.show>.btn-outline-pink.dropdown-toggle {
	border-color: #ff518a;
	background-color: #ff518a;
}

.btn-pink:hover{
	background-color:white !important;
	border-color:#db1f5c;
	color:black !important;
}
.btn-outline-green:hover,
.btn-outline-green:not([disabled]):not(.disabled).active,
.btn-outline-green:not([disabled]):not(.disabled):active,
.btn-green,
.card-green,
.show>.btn-outline-green.dropdown-toggle {
	border-color: #28a745;
	background-color: #28a745;
}

.btn-green:hover{
	background-color:white;
	border-color:#218838;
	color:black !important;
}
.border-red {
    border: 2px solid #eb0016 !important;
}
.text-black{
    color:black;
}
</style>
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
				<div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
					<div class="col col-lg mb-4">
						<div class="card border-0 text-light h-100">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Deliveries Due Today</h4>
												<h3><?php echo $deliveries_today;?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                     <div class="col  mb-4">
						<div class="card border-0 text-light h-100">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-truck" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Deliveries in next 7 days</h4>
												<h3><?php echo $upcomingWeekDelivery;?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="col  mb-4">
						<div class="card text-light h-100 <?php  echo $unapprovedQuotesClassName; ?>">
						     <a href="<?php echo base_url();?>index.php/orders/quote_history">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-dollar" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Quotes</h4>
													<h3><?php echo $unapprovedQuotes;?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class=" col  mb-4">
						<div class="card text-light h-100 <?php  echo $unapprovedCustomerClassName; ?>">
						     <a href="<?php echo base_url();?>index.php/general/customers_listing/1">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-hourglass-end" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Customer approvals</h4>
												<h3></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				
					<div class="col  mb-4">
						<div class="card border-0 text-light h-100">
						    <a href="<?php echo base_url();?>index.php/orders/order_history">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="homepage_single">
											<span class="sec_icon"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></span>
											<div class="homepage_fl_right">
												<h4 class="mt-0">Future Orders</h4>
											<h3><span class="single-count"></span></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-12 mb-4">
						<div class="card card-shadow">
							<div class="card-header">
								<div class="card-title">
									Today’s Orders 
								</div>
							</div>
							<div class="card-body">
									<div class="table-responsive">
									<table class="table table-sm table-bordered">
										<thead class=" text-black" style="background-color: #cdb4db!important;">
											<tr>
												<th>Order #</th>
												<th>Delivery Date &amp; Time</th>
												<th>Customer Name</th>
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
													echo "<td>".date("h:i A, d M Y",strtotime($order->delivery_date_time))."</td>";
												echo "<td>".(isset($order->customer_order_name)  ? $order->customer_order_name : $order->firstname.' '.$order->lastname)."</td>";
											       echo "<td>";
                                				echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."/production?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm  m-sm-100\">View</a>";
                                				if($order->is_catering_checklist_added == 1){
												    $btnColor = 'red';
												}else if($order->is_catering_checklist_added == 2){
												    $btnColor = 'orange';
												}else if($order->is_catering_checklist_added == 3){
												    $btnColor = 'pink';
												}else if($order->is_catering_checklist_added == 4){
												    $btnColor = 'green';
												}else{
												    $btnColor = 'yellow';
												}
												    echo "<a href=\"".base_url()."index.php/orders/catering_checkList/".$order->order_id."/".$orders_identity."/dashboard\" class=\"btn btn-".$btnColor." btn-sm  m-sm-100 ml-1\" target=\"_blank\">Catering Checklist </a>";
												
												if($order->is_completed != 1){
												    $total =  (isset($order->total) && $order->total !='' ? $order->total : $order->order_total);
				    echo "<a href=\"".base_url()."index.php/orders/mark_as_completed/".$order->order_id."/".$referrer."/".$orders_identity."/".$total."/".$order->order_status."\" class=\"btn btn-danger btn-sm ml-1\">Complete</a>";
				                                  }else{
		     	echo "<a  class=\"btn btn-green btn-sm ml-1\">Completed</a>";	    
				}
												    
												}
													echo "</td>";
													echo "</tr>";
												} ?>
										
										</tbody>
									</table>
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
									Tommorow’s Orders 
								</div>
							</div>
							<div class="card-body">
									<div class="table-responsive">
									<table class="table table-sm table-bordered">
										<thead class=" text-black" style="background-color: #ffc8dd !important;">
											<tr>
												<th>Order #</th>
												<th>Delivery Date &amp; Time</th>
												<th>Customer Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($tommorowOrders)){
												foreach($tommorowOrders as $order)
												{
												    if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													 $orders_identity = $order->order_made_from;
													}else{
													 $orders_identity = 'backend'; 
													}
													echo "<tr>";
												
													echo "<td>".$order->order_id."</td>";
													echo "<td>".date("h:i A, d M Y",strtotime($order->delivery_date_time))."</td>";
													echo "<td>".$order->firstname." ".$order->lastname."</td>";
												     echo "<td>";
				                                    echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."/production?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm  m-sm-100\">View</a>";
				
				
				                                if($order->is_catering_checklist_added == 1){
												    $btnColor = 'red';
												}else if($order->is_catering_checklist_added == 2){
												    $btnColor = 'orange';
												}else if($order->is_catering_checklist_added == 3){
												    $btnColor = 'pink';
												}else if($order->is_catering_checklist_added == 4){
												    $btnColor = 'green';
												}else{
												    $btnColor = 'yellow';
												}
												    echo "<a href=\"".base_url()."index.php/orders/catering_checkList/".$order->order_id."/".$orders_identity."/dashboard\" class=\"btn btn-".$btnColor." btn-sm  m-sm-100 ml-1\" target=\"_blank\">Catering Checklist </a>";
												
			   if($order->is_completed == 1){
				    echo "<a  class=\"btn btn-green btn-sm ml-1\">Completed</a>";
												}else if(date("Y/m/d",strtotime($order->delivery_date_time)) == date("Y/m/d")){
                                        $total =  (isset($order->total) && $order->total !='' ? $order->total : $order->order_total);
				    echo "<a href=\"".base_url()."index.php/orders/mark_as_completed/".$order->order_id."/".$referrer."/".$orders_identity."/".$total."/".$order->order_status."\" class=\"btn btn-danger btn-sm ml-1\">Complete</a>";
				                                  												}
			  }
													echo "</td>";
													echo "</tr>";
												} ?>
										</tbody>
									</table>
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
									Deliveries within next 7 days 
								</div>
							</div>
							<div class="card-body">
									<div class="table-responsive">
									<table class="table table-sm table-bordered">
										<thead class=" text-black" style="background-color: #bde0fe;">
											<tr>
												<th>Order #</th>
												<th>Delivery Date &amp; Time</th>
												<th>Customer Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php if(!empty($upcomingWeekOrders)){
												foreach($upcomingWeekOrders as $order)
												{
												    if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													 $orders_identity = $order->order_made_from;
													}else{
													 $orders_identity = 'backend'; 
													}
													echo "<tr>";
													echo "<td>".$order->order_id."</td>";
													echo "<td>".date("h:i A, d M Y",strtotime($order->delivery_date_time))."</td>";
													echo "<td>".$order->firstname." ".$order->lastname."</td>";
												    echo "<td>";
				                                echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."/production?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm  m-sm-100\">View</a>";
				                                if($order->is_catering_checklist_added == 1){
												    $btnColor = 'red';
												}else if($order->is_catering_checklist_added == 2){
												    $btnColor = 'orange';
												}else if($order->is_catering_checklist_added == 3){
												    $btnColor = 'pink';
												}else if($order->is_catering_checklist_added == 4){
												    $btnColor = 'green';
												}else{
												    $btnColor = 'yellow';
												}
												    echo "<a href=\"".base_url()."index.php/orders/catering_checkList/".$order->order_id."/".$orders_identity."/dashboard\" class=\"btn btn-".$btnColor." btn-sm  m-sm-100 ml-1\" target=\"_blank\">Catering Checklist </a>";
												
												if($order->is_completed == 1){
				    echo "<a  class=\"btn btn-green btn-sm ml-1\">Completed</a>";
												}else if(date("Y/m/d",strtotime($order->delivery_date_time)) == date("Y/m/d")){
 $total =  (isset($order->total) && $order->total !='' ? $order->total : $order->order_total);
				    echo "<a href=\"".base_url()."index.php/orders/mark_as_completed/".$order->order_id."/".$referrer."/".$orders_identity."/".$total."/".$order->order_status."\" class=\"btn btn-danger btn-sm ml-1\">Complete</a>";
				                                  												}
												    
												}
													echo "</td>";
													echo "</tr>";
												} ?>
										
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


</script>