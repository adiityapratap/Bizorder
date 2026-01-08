<?php $referrer=explode("/",$_SERVER['PATH_INFO'])[2];


$userId = $this->session->userdata('user_id');
?>
<style>
    table#table {
    margin-top: 0 !important;
}
.fixed-table-header {
    display: none !important;
}
@media(min-width: 1024px){
    table.dataTable {
        width: 100% !important;
        max-width: 100%;
    }
    .dataTables_wrapper {
        width: 100% !important;
    }
    .table-responsive {
        overflow-x: unset;
    }
    table.dataTable.no-footer {
        border-bottom: 0 !important;
    }
}
.overlay{
  position: absolute;
  top:0px;
  left:0px;
  width: 100%;
  height: 100%;
  background: black;
  opacity: .7;
  z-index: 999999;
}
.loader6 {
  display:inline-block;
  width: 30px;
	height:30px;
	left: 50%;
    top: 45%;
	position:absolute;
	border-left: 2px solid transparent;
	border-right: 2px solid transparent;
	border-bottom: 2px solid #d70010;
  border-top: 2px solid #d70010;
  -webkit-animation: loader6 1.8s ease-in-out infinite alternate;
  animation: loader6 1.8s ease-in-out infinite alternate;
}

.loader6:before {
  content: " ";
  position: absolute;
  z-index: -1;
  top: 5px;
  left: 0px;
  right: 0px;
  bottom: 5px;
  border-left: 2px solid #d70010;
  border-right: 2px solid #d70010;
}

@keyframes loader6 {
   from {transform: rotate(0deg);}
   to {transform: rotate(720deg);}
}
@-webkit-keyframes loader6 {
   from {-webkit-transform: rotate(0deg);}
   to {-webkit-transform: rotate(720deg);}
}
</style>
<link rel="stylesheet" type="text/css" href="https://www.cafeadmin.com.au/assets/css/jquery.dataTables.css">
<script type="text/javascript" src="https://www.cafeadmin.com.au/assets/js/jquery.dataTables.min.js"></script>
<!-- header_End -->
<!-- Content_right -->
<div class="overlay loading-image" style="display:none">
 <div class="loader6"></div>
 </div>
<div class="container_full bg_img_banner mt-5">
	<div class="content_wrapper">
		<div class="container-fluid">
			<!-- breadcrumb -->
			<div class="page-heading">
				<div class="row d-flex align-items-center">
					<div class="col-md-6">
						<div class="page-breadcrumb">
							<h1>View Customer's Feedbacks</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Customer's  Feedbacks</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Customer's Feedbacks
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
							    	<div class="row">
							  <div class="col-2">
								<h3 class="card-title">Filters</h3>
							</div>
							<div class="col-10" style="justify-content: flex-end;display: flex;">
							<button class="btn btn-primary" onclick="downloadsreport()">Download report</button>
							</div>
								</div>		
							</div>
							
							<div class="card-body">
								<form id="order_filters">
									<div class="row">
									 
										<div class="col-12 col-md-2">
											<input class="form-control" id="improvement_on" type="text" placeholder="Improvement On">
										</div>
											<!--<div class="col-auto">-->
											<div class="col-12 col-md-1">
												<button class="btn btn-primary">Filter</button>
											</div>
												<div class="col-12 col-md-1">
												<button class="btn btn-primary">Reset</button>
											</div>
											
										<!--</div>-->
									</div>
								</form>
									
							</div>
						</div>
						<div class="card card-shadow mb-4">
							<div class="table-responsive">
								<table id="customers_feedback" class="table table-sm table-bordered">
									<thead>
										<tr>
											<th>Order </th>
											<th>Customer</th>
											<th>Company</th>
											<th>Website Experience</th>
											<!--<th>FOOD</th>-->
											<!--<th>PRICING</th>-->
											<!--<th>MENU</th>-->
											<!--<th>WEBSITE EXPERIENCE</th>-->
											<!--<th>DELIVERY</th>-->
											<!--<th>PACKAGING</th>-->
											<!--<th>CUSTOMER SERVICE</th>-->
											<th>Was the order delivered on time?</th>
											<th class="sort">IMPROVEMENT ON </th>
											<th>Suggestions</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($orderfeedback_info)){
											foreach($orderfeedback_info as $orderfeedbackinfo)
											{
                                              $newtext = wordwrap($orderfeedbackinfo->suggestions, 40, "<br />\n");
												echo "<tr>"; 
												
												echo "<td>".$orderfeedbackinfo->order_id."</td>";
												echo "<td>".$orderfeedbackinfo->cname."</td>";
												echo "<td>".$orderfeedbackinfo->company_name."</td>";
												echo "<td>".$orderfeedbackinfo->website_experience."</td>";
											 //   echo "<td>".$orderfeedbackinfo->FOOD."</td>";
											 //   echo "<td>".$orderfeedbackinfo->PRICING."</td>";
											 //   echo "<td>".$orderfeedbackinfo->MENU."</td>";
											 //   echo "<td>".$orderfeedbackinfo->EXPERIENCE."</td>";
											 //   echo "<td>".$orderfeedbackinfo->DELIVERY."</td>";
											 //   echo "<td>".$orderfeedbackinfo->PACKAGING."</td>";
											 //   echo "<td>".$orderfeedbackinfo->SERVICE."</td>";
											    echo "<td>".$orderfeedbackinfo->deliveredOnTime."</td>";
											    echo "<td>".$orderfeedbackinfo->commentText."</td>";
											    echo "<td style='word-break: break-all'>".$newtext."</td>";
											     echo " <td>
             <button type='button' class='btn btn-danger' onclick='deleteFeedback($orderfeedbackinfo->order_id)'><i class='fa fa-trash'></i></button>
            </td>";
												echo "</tr>";
											}
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


<div id="modalTable" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 1177px !important;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Customer Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="table" data-toggle="table" data-height="299">
         
          <tbody id="feedback_data">
           
            
        
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="trigger_modal" data-toggle="modal" data-target="#modalTable">

<script>
  var $table = $('#table')
$(document).ready(function () {
    $('#customers_feedback').DataTable({
         paging: false,
         info: false,
         searching: false,
         order: [[0, 'desc']],
    });
});
 function downloadsreport(){
     window.location.href = "<?php echo base_url();?>index.php/orders/view_all_feedback_report";
  }
  function deleteFeedback(order_id){
      $('.loading-image').show();
  $.ajax({
		url:"<?php echo base_url();?>index.php/orders/delete_feedback/"+order_id,
		method:"POST",
		success:function(data){
		location.reload();
			}
		})
}
  
  $(function() {
    $('#modalTable').on('shown.bs.modal', function () {
      $table.bootstrapTable('resetView')
    })
  })
  
  function get_feedfback(order_id){
     
    $('#trigger_modal').trigger( "click" );
      	                           $.ajax({
									url:"<?php echo base_url();?>index.php/orders/view_order_feedback/"+order_id,
									method:"POST",
									
									success:function(data){
								
					$('#feedback_data').html(data);
                        
                
									}
								})
  }
  
$(function(){
	$(".datepicker").datetimepicker({
		format:'YYYY-MM-DD'
	})
	$(".timepicker").datetimepicker({
		format:'hh:mm a'
	})
		$("#order_filters").on('submit',function(e){
		e.preventDefault();
		if($.trim($("#date_from").val())=='')
			date_from='unset';
		else date_from=$("#date_from").val();
		if($.trim($("#date_to").val())=='')
			date_to='unset';
		else date_to=$("#date_to").val();
		if($.trim($("#improvement_on").val())=='')
			improvement_on='unset';
		else improvement_on=$("#improvement_on").val();
		
		
		//If current page is order_history
	window.location.href="<?php echo base_url();?>index.php/orders/view_all_feedback/"+date_from+"/"+date_to+"/"+improvement_on;
	})
	

})

</script>
