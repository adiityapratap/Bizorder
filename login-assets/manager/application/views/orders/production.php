<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];
$userId = $this->session->userdata('user_id');
$is_customer = $this->session->userdata('is_customer');
?>
<style>
    table#table {
    margin-top: 0 !important;
}
.fixed-table-header {
    display: none !important;
}

table.dataTable thead th, table.dataTable thead td {
    padding: 12px 6px;
    border-top: 1px solid #ebebe9;
    line-height: 1.43;
}
table.dataTable, table.dataTable th, table.dataTable td {
    -webkit-box-sizing: border-box !important;
    box-sizing: border-box !important;
}
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
	background-color:#ff7000;
	border-color:#ff7000;
	color:#fff;
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
	background-color:#e79d00;
	border-color:#e79d00;
	color:#fff;
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
	background-color:#131070;
	border-color:#131070;
	color:#fff;
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
	background-color:#db1f5c;
	border-color:#db1f5c;
	color:#fff;
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
	background-color:#218838;
	border-color:#218838;
	color:#fff;
}
@media(min-width: 1024px){
    table.dataTable {
        width: 100%;
        max-width: 100%;
    }
    .dataTables_wrapper {
        width: 100%;
    }
}
.date-icon{
        font-size: 30px !important;
    margin-left: -39px !important;
    margin-top: 4px !important;
    font-weight: 200 !important;
}


</style>
<link rel="stylesheet" type="text/css" href="https://www.cafeadmin.com.au/assets/css/jquery.dataTables.css">
<script type="text/javascript" src="https://www.cafeadmin.com.au/assets/js/jquery.dataTables.min.js"></script>
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
							<h1>Production Orders</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Orders</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									Production Orders
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
					 
						<div class="card card-shadow mb-4">
							<div class="card-header">
								<h3 class="card-title">Filters</h3>
							</div>
							<div class="card-body">
								<form id="order_filters">
									    <div class="row">
									    <div class="col-12 col-md-3 mb-3 ">
									        <div class="date-container" style="display:flex">
                                  <input class="form-control datepicker" id="order_date" type="text" placeholder="Order Date ">
                                       <i class="date-icon fa fa-calendar" aria-hidden="true"></i>
                                           </div>
                                             </div>
										<div class="col-12 col-md-2 mb-3 ">
											<input class="form-control " id="order_id" type="text" placeholder="Order Id">
										</div>
										<div class="col-lg-2 col-md-3 col-4 mb-3 ">
        									 <button type="submit" class="btn btn-primary">Go</button>
        								</div>
										</div>
											
								</form>
							</div>
						</div>
					
						<div class="card card-shadow mb-4" style="padding: 15px;">
							<div class="table-responsive">
							   
							    
								<table  class="table  table-bordered table-sm" cellspacing="0" width="100%">
									<thead>
										<tr>
										   
											<th>Order Id </th>
											<th>Delivery Date &amp; Time</th>
											<th>Customer Name</th>
											<th>Any Updates</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($orders)){
										 
											foreach($orders as $order)
											{
											   if($order->updatedAfterApproved){
                                                echo "<tr style='background-color: #DC3546;color:#fff'>"; 
                                                } else {
                                                echo "<tr>";   
                                               }
												echo "<td>".$order->order_id."</td>";
											
											if($is_customer == 1){
											    echo "<td>". date('d M Y h:i A',strtotime($order->delivery_date_time))."</td>";
											}else{
    												echo "<td>". date('d M Y h:i A',strtotime($order->delivery_date_time))."</td>";
											}
												if($order->customer_order_name != ''){
												    $custName = $order->customer_order_name;
												}else{
												    $custName = $order->firstname." ".$order->lastname;
												}
												echo "<td>".$custName."</td>";
												
													if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
															    	if($order->order_status!=3){
															    echo "<td></td>";
															    	}else{
															    	    
															    echo "<td></td>";
															    	}
															}else{
											if($order->updatedAfterApproved){	
											    
											echo "<td>There is an update on this order </td>";					
											}
											else {
											    
											    echo "<td></td>";
											}
												
										}
												
											  
												
													echo "<td>";
													
													if(isset($order->order_made_from) && $order->order_made_from=='frontend'){ 
													 $orders_identity = $order->order_made_from;
													}else{
													 $orders_identity = 'backend'; 
													}
													
													

												echo "<a href=\"".base_url()."index.php/orders/view_order/".$order->order_id."/production?ofrom=".$orders_identity."\" class=\"btn btn-info btn-sm mb-1 m-sm-100 mr-2\">View</a>";
												
												if($order->is_catering_checklist_added == 1){
												    $btnColor = 'blue';
												}else if($order->is_catering_checklist_added == 2){
												    $btnColor = 'orange';
												}else if($order->is_catering_checklist_added == 3){
												    $btnColor = 'pink';
												}else if($order->is_catering_checklist_added == 4){
												    $btnColor = 'green';
												}else{
												    $btnColor = 'yellow';
												}
												    echo "<a href=\"".base_url()."index.php/orders/catering_checkList/".$order->order_id."/".$orders_identity."\" class=\"btn btn-".$btnColor." btn-sm mb-1 m-sm-100 mr-2\" target=\"_blank\">Catering Checklist </a>";
												
							                    ?>
							                  <?php if($order->updatedAfterApproved){ ?>
                                             <a  class="btn btn-danger btn-sm mb-1 m-sm-100 mr-2" onclick="chefApprove(<?php  echo $order->order_id;  ?>)">Acknowledged</a>
											<?php } ?>
											</td>
												</tr>
										<?php 	}
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





<script>

function chefApprove(order_id){
    	$.ajax({
			url:"<?php echo base_url();?>index.php/orders/chefApprove/"+order_id,
			method:"POST",
			success:function(){
			    location.reload();
			}
		});
}
  
  
$(function(){
	$(".datepicker").datetimepicker({
		format:'DD-MM-YYYY'
	})
	$(".timepicker").datetimepicker({
		format:'hh:mm a'
	})
		$("#order_filters").on('submit',function(e){
		e.preventDefault();
	
			date_from='unset';
		if($.trim($("#order_date").val())=='')
			order_date='unset';
		else order_date=$("#order_date").val();
			date_to='unset';
			cost_centre='unset';
			company='unset';
			department='unset';
			customer='unset';
		if($.trim($("#order_id").val())=='')
		order_id='unset';
		else order_id=$("#order_id").val();
		sort_order=$("[name='sort_order']:checked").val();
		
	  window.location.href="<?php echo base_url();?>index.php/orders/production/"+order_date+"/"+order_id;
		
	})
	
	})
$('.date-icon').on('click', function() {
    $('#order_date').focus();
  })
	

		
   
</script>
<script>
    $(document).ready(function() {
    
    <?php if($this->session->flashdata('msg')){ ?>
    alert('<?php echo $this->session->flashdata('msg'); ?>');
    <?php } ?>
    
    
    
    // $(document).ready(function () {
    //   $('#ordersTable').DataTable({
    //       "searching": false,
    //      "aaSorting": [],
    //         columnDefs: [{
    //         orderable: false,
    //         }]
    //   });
      
    //   $('.dataTables_length').addClass('bs-select');
    // });
});

</script>
