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
div#orderTable_length label {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
div#orderTable_filter label {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
div#orderTable_length label select {
    width: 100px !important;
    margin: 0 5px;
}
.dataTables_wrapper .dataTables_filter input {
    width: 200px;
    margin: 0 5px;
}
div#orderTable_filter {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
div#orderTable_wrapper {
    padding: 15px;
}
.bg-grey {
    background: #fdfdfd!important;
    border-bottom: 1px solid #eee;
}
.dataTables_wrapper>.row {
    margin-bottom: 15px !important;
}
</style>
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
							<h1>View Offers</h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Offers</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									View Offers
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
								<h3 class="card-title">Offers</h3>
							</div>
							<div class="table-responsive">
							   
							    
								<table class="table table-sm table-striped" id="orderTable">
									<thead class="bg-grey">
										<tr>
										    <!--<th></th>-->
											<th>Supplier Name</th>
											<th>Email</th>
											<th>Order Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($orders)){
											foreach($orders as $order)
											{
                                         echo "<tr>";
												
								// 		echo "<td><label class=\"control control-solid control-solid-info control--checkbox\"><input type=\"checkbox\" class=\"running_sheet_check\" id=\"backend_".$order->order_id."\"><span class=\"control__indicator\"></span></label></td>";

												echo "<td class=\"sup_name_".$order->order_id."\" rel=\"".$order->supplier_name."\">".$order->supplier_name."</td>";
												echo "<td>".$order->email_address."</td>";
											 echo "<td>". date('g:i A, l - d M Y',strtotime($order->order_date))."</td>";
											
										
												
									        if($order->order_status == 1){
											    echo "<td><div class=\"badge badge-info\">New</td>";
											}
											if($order->order_status == 2){
											    echo "<td><div class=\"badge badge-danger\">Sent</td>";
											}
											if($order->order_status == 3){
											    echo "<td><div class=\"badge badge-primary\">Viewed</td>";
											}
											elseif($order->order_status == 4){
											    echo "<td><div class=\"badge badge-success\">Confirmed by the Supplier</div></td>";
											}
										
										echo "<td>";
										$orders_identity = 'backend';
            							echo "<a href=\"".base_url()."index.php/orders/view_quote/".$order->order_id."\" class=\"btn btn-primary btn-sm mr-1\">View</a>&nbsp;&nbsp;";			
            							echo "<a href=\"".base_url()."index.php/orders/update_quote/".$order->order_id."\" class=\"btn btn-secondary btn-sm mr-1\">Edit</a>&nbsp;&nbsp;";			
            				// 			echo "<a href=\"".base_url()."index.php/orders/send_offer_mail/".$order->order_id."\" class=\"btn btn-primary btn-sm mr-1\">Send Mail</a>&nbsp;&nbsp;";			
            							echo "<button class=\"btn btn-warning btn-sm\" onclick=\"open_modal('".$order->order_id."')\">Send Email</button>&nbsp;&nbsp;";			
                                
												
							            echo "<button class=\"btn btn-danger btn-sm mr-1\" onclick=\"delete_order('".$order->order_id."','".$referrer."','".$orders_identity."')\">Cancel</button>";
											
												
												echo "</td>";
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

<div class="modal fade" id="order_comment_modal" tabindex="-1" role="dialog" aria-labelledby="order_comment_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mark_paid_title">Order Comments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/order_comment" method="POST" id="order_comment_form">
					<input type="hidden" name="order_id" id="order_comment_id">
					<input type="hidden" name="referrer" id="order_comment_referrer">
					<input type="hidden" name="ofrom" id="ORDER_COMMENT_MADE_FROM">
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="order_comment" required></textarea>
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Add Order Comment</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="delete_order_modal" tabindex="-1" role="dialog" aria-labelledby="delete_order_title" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="delete_order_title">Are you sure, You want to delete this order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>index.php/orders/delete_order" method="POST" id="delete_order_form">
					<input type="hidden" name="order_id" id="delete_order_id">
					<input type="hidden" name="referrer" id="delete_order_referrer">
					<input type="hidden" name="ofrom" id="delete_order_order_made_from">
					
					<div class="row">
						<div class="col-12">
							<label>Comments</label>
							<textarea class="form-control" name="cancel_comments" required></textarea>
						</div>
					</div>
					<div class="row mt-2">
						<div class='col-12'>
							<button type="submit" class="btn btn-info">Delete</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="email_modal" tabindex="-1" role="dialog" aria-labelledby="email_modal_title">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-auto">
							Please enter the email ID to send to:
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<input type="email" class="form-control" id="email"><div class="invalid-feedback">Please enter an email address!</div>
							<input type="hidden" id="modal_order_id">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					<button type="button" onclick="send_mail()" class="btn btn-primary">
						Send Mail
					</button>
				</div>
			</div>
		</div>
	</div>

<input type="hidden" id="trigger_modal" data-toggle="modal" data-target="#modalTable">

<script>
  var $table = $('#table')

  $(function() {
    $('#modalTable').on('shown.bs.modal', function () {
      $table.bootstrapTable('resetView')
    })
  })

  
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
		
		if($.trim($("#order_date").val())=='')
			order_date='unset';
		else order_date=$("#order_date").val();
		
		
		if($.trim($("#date_to").val())=='')
			date_to='unset';
		else date_to=$("#date_to").val();
		if($.trim($("#cost_centre").val())=='')
			cost_centre='unset';
		else cost_centre=$("#cost_centre").val();
		if($.trim($("#company").val())=='')
			company='unset';
		else company=$("#company").val();
		if($.trim($("#department").val())=='')
			department='unset';
		else department=$("#department").val();
		if($.trim($("#customer").val())=='')
			customer='unset';
		else customer=$("#customer").val();
		
		if($.trim($("#order_id").val())=='')
			order_id='unset';
		else order_id=$("#order_id").val();
		sort_order=$("[name='sort_order']:checked").val();
		
		
		//If current page is order_history
		if(window.location.href.indexOf('order_history')!=-1)
			window.location.href="<?php echo base_url();?>index.php/orders/quote_history/"+date_from+"/"+date_to+"/"+order_date+"/"+company+"/"+department+"/"+customer+"/"+sort_order+"/"+order_id+"/"+$("#locations").val();
		else
			window.location.href="<?php echo base_url();?>index.php/orders/quote_history/"+date_from+"/"+date_to+"/"+order_date+"/"+company+"/"+department+"/"+customer+"/"+sort_order+"/"+order_id+"/"+$("#locations").val();
	})
	
	$("#check_all").on('change',function(e){
		if($("#check_all").is(":checked")){
			$(".running_sheet_check").prop('checked',true);
		}
		else{
			$(".running_sheet_check").prop('checked',false);
		}
	});
	
	$("#company").on('change',function(e){
		$.ajax({
									url:"<?php echo base_url();?>index.php/orders/get_dept/"+$(this).val(),
									method:"POST",
									
									success:function(data){
								
						var data =	JSON.parse(data);
                         $("#department").html('');
                 $.each(data, function(index, item) {
            
            $('#department').append($("<option></option>").attr("value",item.department_id).text(item.department_name)); 
                      
                       });
									}
								})
	})
	
})
function download_running(name)
{	
    var running_sheet=[];
    var late_fee_orders=[];


	
	if(name=="mark_paid"){
	    
          $("#group_mark_paid_modal").modal('show');
	    
	  
    }else if(name=="add_late_fee"){
        var late_fee = $("#late_fee").val();
        	$(".running_sheet_check").each(function(){
	      
		if($(this).is(':checked')){
			late_fee_orders.push($(this).prop('id').split('_')[1]);
		}
	    })
	 
	 	late_fee_orders=late_fee_orders.join('.');
        
        $.ajax({
		url:'<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee,
		method:"POST",
		success:function(data){
		    
$(".late_fee_text").show();
$(".late_fee_text").fadeOut(3000);
         }
	})
        
        
        
	 	
        // window.open('<?php echo base_url();?>index.php/orders/add_late_fee/'+late_fee_orders+'/'+late_fee);
        
        
    }else{
        $(".running_sheet_check").each(function(){
	      
		if($(this).is(':checked')){
			running_sheet.push($(this).prop('id').split('_')[1]);
		}
	    })
	 
	 	running_sheet=running_sheet.join('.');
	 	
        window.open('<?php echo base_url();?>index.php/orders/running_sheet/'+running_sheet);
        
    }
	
	
}


function reorder(order_id){
	$("#reorder_id").val(order_id);
	$("#reorder_modal").modal('show');
}

		
function order_comment(order_id,referrer,ofrom){
			$("#order_comment_id").val(order_id);
			$("#order_comment_referrer").val(referrer);
			$("#order_comment_made_from").val(ofrom);
			$("#order_comment_modal").modal('show');
		}	
	
		
		function delete_order(order_id,referrer,ofrom){
			$("#delete_order_id").val(order_id);
			$("#delete_order_referrer").val(referrer);
			$("#delete_order_order_made_from").val(ofrom);
			$("#delete_order_modal").modal('show');
		}
		
    function open_modal(order_id){
        $('#modal_order_id').val(order_id);
        $("#email_modal").modal('show');
        
    }
    function send_mail(){
        var order_id = $("#modal_order_id").val();
        var supplier_name = $(".sup_name_"+order_id).attr('rel');
        $("#email").removeClass('is-invalid');
        if($.trim($("#email").val())==''){
            $("#email").addClass('is-invalid');return 0;
                
            }
            $.ajax({url:'<?php echo base_url();?>index.php/orders/send_offer_mail/'+order_id+'/'+supplier_name,
            method:"POST",
            data:{

			"email":$("#email").val(),

		  },
            success:function(data){
                $("#email_modal").modal('hide');
                location.reload();
            }
                
            })
        
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function () {
    $('#orderTable').DataTable( {
        pageLength: 50,
    lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
    });
    
});
</script>
