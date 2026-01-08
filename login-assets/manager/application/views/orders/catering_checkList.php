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
table.catering_checklist_table {
    width: 100%;
}
table.catering_checklist_table th {
    background-color: #edededbd;
    padding-left: 12px;
    padding-right: 15px;
}
table.catering_checklist_table td {
    padding: 10px 15px;
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
							<h1>Order No : <?php echo $order_id; ?></h1>
						</div>
					</div>
					<div class="col-md-6 justify-content-md-end d-md-flex">
						<div class="breadcrumb_nav">
							<ol class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a class="parent-item" href="index.html">Production</a>
									<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">
									CATERING CHECKLIST
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
								<h3 class="card-title">COMUNICATION WITH THE CUSTOMER</h3>
								<div style="width:200px; float:right; display:flex">
								    <a onclick="display_checlist_info()" class="btn btn-orange btn-sm  m-sm-100 ml-1" target="_blank">Checklist Info</a>
								   	<a target="_blank" href="<?php echo base_url(); ?>index.php/orders/edit_order/<?php echo $order_id; ?>/<?php echo $order_info->order_status; ?>/<?php echo ''; ?>?ofrom=<?php echo $ofrom ?>" class="btn btn-dark btn-sm  m-sm-100 ml-1">Edit Order</a>
								    </div>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url();?>index.php/orders/submit_catering_checkList" method="post">
								    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
								    <input type="hidden" name="ofrom" value="<?php echo $ofrom; ?>">
								    <input type="hidden" name="prev_URL" value="<?php echo $prev_URL; ?>">
								    <table class="table table-stripped catering_checklist_table">
								        <tr>
								            <th colspan="2">CATERING ORDER IS FIRST RECEIVED - CALL PERSON WHO PLACED ORDER  TO CONFIRM</th>
								            <th></th>
								        </tr>
								        <tr>
								            <td colspan="2">Location</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['catering_location']){ echo "checked"; } ?> name="catering_location"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Time</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['catering_time']){ echo "checked"; } ?> name="catering_time"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">How many people </td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['catering_people']){ echo "checked"; } ?> name="catering_people"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Delivery instructions -Eg Enter gate 4, left uphill etc</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['catering_delivery_instructions']){ echo "checked"; } ?> name="catering_delivery_instructions"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Confirm all dietary requirements</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['catering_dietary_req']){ echo "checked"; } ?> name="catering_dietary_req"><span class="control__indicator"></span></label></td>
								        </tr>
								        <!--next question-->
								        <tr>
								            <th colspan="2">DAY BEFORE DELIVERY - CALL PERSON WHO PLACED THE ORDER TO CONFIRM</th>
								            <th></th>
								        </tr>
								        <tr>
								            <td colspan="2">Location</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['day_before_location']){ echo "checked"; } ?> name="day_before_location"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Time</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['day_before_time']){ echo "checked"; } ?> name="day_before_time"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">How many people </td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['day_before_people']){ echo "checked"; } ?> name="day_before_people"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Delivery instructions -Eg Enter gate 4, left uphill etc</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['day_before_delivery_instructions']){ echo "checked"; } ?> name="day_before_delivery_instructions"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Confirm all dietary requirements</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['day_before_dietary_req']){ echo "checked"; } ?> name="day_before_dietary_req"><span class="control__indicator"></span></label></td>
								        </tr>
								            <!--next question-->
								        <tr>
								            <th colspan="2">DAY OF DELIVERY</th>
								            <th></th>
								        </tr>
								        <tr>
								            <td colspan="2">Double check everything on catering form before going to deliver.</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['delivery_day_check_everything']){ echo "checked"; } ?> name="delivery_day_check_everything"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Cutlery, Napkins, Tongs etc.  </td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['delivery_day_others']){ echo "checked"; } ?> name="delivery_day_others"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Start packing van 45min before delivery time.</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['delivery_day_start_packing']){ echo "checked"; } ?> name="delivery_day_start_packing"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Call customer when leaving hospital, request they meet you.</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['delivery_day_call_customer']){ echo "checked"; } ?> name="delivery_day_call_customer"><span class="control__indicator"></span></label></td>
								        </tr>
								       
								            <!--next question-->
								        <tr>
								            <th colspan="2">HEALTHY FILLINGS / KITCHEN</th>
								            <th></th>
								        </tr>
								        <tr>
								            <td colspan="2">Label all catering boxes with gluten free, vegan, vegetarian, halal etc.</td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['kitchen_catering_labels']){ echo "checked"; } ?> name="kitchen_catering_labels"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Check all Dietary requirements are in separate boxes. </td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['kitchen_check_dietary']){ echo "checked"; } ?> name="kitchen_check_dietary"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td colspan="2">Check all items match the catering order – 2 people to check. </td>
								            <td><label class="control control-solid control-solid-info control--checkbox"><input type="checkbox" value="1" <?php if($catering_checkList[0]['kitchen_check_all_items']){ echo "checked"; } ?> name="kitchen_check_all_items"><span class="control__indicator"></span></label></td>
								        </tr>
								        <tr>
								            <td width="275">NAMES OF STAFF WHO CHECKED 
								            <td><input type="text" class="form-control" name="kitchen_staff_name" value="<?php echo $catering_checkList[0]['kitchen_staff_name']; ?>"></td>
								            <td></td>
								        </tr>
								       
								            
								    </table> 
								    <button type="submit" class="btn btn-primary">Submit</button>
								</form>
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

<div class="modal fade" id="checklist_info_modal"  tabindex="-1" role="dialog" aria-labelledby="email_modal_title">
		<div class="modal-dialog" role="document" style="max-width:1000px">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="email_modal_title">Order Checklist Info</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
			<?php if($ofrom =='frontend') {  ?>
				<table class="table table-bordered" style="font-size:18px;">
								
									<tr>
										<td colspan="2" width="50%">
											<strong class="mr-2">Order ID: </strong><?php echo $order_info[0]->order_id;?><br>
											<strong class="mr-2">Delivery: </strong><?php echo date('g:i A, l - d M Y',strtotime($order_info[0]->delivery_date));?><br>
											<strong class="mr-2">Name: </strong><?php echo $order_info[0]->firstname." ".$order_info[0]->lastname;?><br>
											<strong class="mr-2">Email: </strong><?php echo $order_info[0]->email;?><br>
											<strong class="mr-2">Phone: </strong><?php echo $order_info[0]->telephone;?><br>
										</td>
										<td colspan="2" width="50%">
										<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info[0]->comment;?><br>
										<?php
										if($order_info[0]->shipping_method == 'Pickup'){
										    $text = 'Pick Up/Delivery Inside the Premises';
										}else{
										  $text   = $order_info[0]->shipping_method;
										}
										?>
										<strong class="mr-2">Shipping Method: </strong><?php echo $text; ?></br>
									<strong class="mr-2">Delivery/Pickup Location: </strong>	
										<?php 
											if($order_info[0]->shipping_method == 'Delivery'){
											   $addr = $order_info[0]->shipping_address_1.','.$order_info[0]->shipping_address_2.' '.$order_info[0]->shipping_city.','.$order_info[0]->shipping_postcode;
											}else if($order_info[0]->shipping_method == 'pickup.pickup' || $order_info[0]->shipping_method == 'delivery.delivery'){
											  $addr = $order_info[0]->shipping_address_1;
											}else{
											   $addr = $order_info[0]->shipping_address_1;
											}
											$addDetails = '';
											($order_info[0]->shipping_gate_number != '' ? $addDetails .= '<span class="delivery_info_labels">Gate no : </span>'.$order_info[0]->shipping_gate_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_building_number != '' ? $addDetails .= '<span class="delivery_info_labels">Building number : </span>'.$order_info[0]->shipping_building_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_department_name != '' ? $addDetails .= '<span class="delivery_info_labels">Department name: </span>'.$order_info[0]->shipping_department_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_level_of_building != '' ? $addDetails .= '<span class="delivery_info_labels">Level of building : </span>'.$order_info[0]->shipping_level_of_building.'</br>' : '</br>');
										    ($order_info[0]->shipping_room_number != '' ? $addDetails .= '<span class="delivery_info_labels">Room number : </span>'.$order_info[0]->shipping_room_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_business_name != '' ? $addDetails .= '<span class="delivery_info_labels">Business name :</span> '.$order_info[0]->shipping_business_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_street_number != '' ? $addDetails .= '<span class="delivery_info_labels">Street number : </span>'.$order_info[0]->shipping_street_number.'</br>' : '</br>');
										    ($order_info[0]->shipping_delivery_contact_name != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact name :</span> '.$order_info[0]->shipping_delivery_contact_name.'</br>' : '</br>');
										    ($order_info[0]->shipping_delivery_contact_number != '' ? $addDetails .= '<span class="delivery_info_labels">Delivery contact number : </span>'.$order_info[0]->shipping_delivery_contact_number.'</br>' : '</br>');
										    ($order_info[0]->account_number != '' ? $addDetails .= '<span class="delivery_info_labels">Account Number : </span>'.$order_info[0]->account_number.'</br>' : '</br>');

											
											?>
											<?php  echo $addr;?><br>
											<?php  echo $addDetails;?>
										</td>
									</tr>
								
									
								</table>
			<?php }  ?>
					    	
			<?php if($ofrom =='backend') {  ?>
			<table class="table table-bordered orderviewtable" style="font-size:18px;">
									<tr>
										<td colspan="2" width="50%">
											<strong class="mr-2">Order ID: </strong><?php echo $order_info->order_id;?><br>
											
											 <!-- <strong class="mr-2">Order ID: </strong>#<?php // $x = $order_info->oc_order_id?$order_info->oc_order_id.'-1800INV':$order_info->order_id.'-1800HC';
                                                                              echo $x;?> <br> -->
											<strong class="mr-2">Delivery: </strong><?php echo date('g:i A, l - d M Y',strtotime($order_info->delivery_date_time));?><br>
										
										</td>
										<td colspan="2" width="50%">
											<strong class="mr-2">Name: </strong><?php echo $order_info->customer_order_name;?><br>
											<strong class="mr-2">Email: </strong><?php echo $order_info->customer_order_email;?><br>
											<strong class="mr-2">Phone: </strong>
											<?php if(isset($order_info->customer_order_telephone) && $order_info->customer_order_telephone !='') {
											    $phone = $order_info->customer_order_telephone;
											    echo $order_info->customer_order_telephone;
											}
											?><br><hr>
											<strong class="mr-2">Delivery Notes: </strong><?php echo $order_info->pickup_delivery_notes;?><br>
											<strong class="mr-2">Delivery Contact: </strong>
											<?php if(isset($order_info->delivery_phone) && $order_info->delivery_phone !='') {
											    $phone = $order_info->delivery_phone;
											echo $order_info->delivery_phone;
											}
											?><br>
											<strong class="mr-2">Shipping Method: </strong><?php echo $order_info->shipping_method==1?"Delivery":"Pickup";?>
										</td>
									</tr>
									<thead>
										<tr>
											<?php if ($order_info->company_name === ''): ?>
											<th colspan="2" width="50%">Company Information</th>
											<th colspan="2" width="50%">Delivery/Pickup Address</th>
											<?php endif; ?>
										   <th colspan="2" width="50%">Company Information</th>
											<th colspan="2" width="50%">Delivery/Pickup Address</th>
										</tr>
									</thead>
									<tr>
										<td colspan="2">
									
											<?php echo $order_info->customer_company_name?><br>
											<?php echo $order_info->customer_company_addr;?>
									
										</td>
										<td colspan="2">
										   <?php if(is_null($order_info->delivery_address)) echo $order_info->company_address; else echo $order_info->delivery_address;?><br>
											<?php if(!empty($order_info->postcode)) {echo $order_info->postcode.'<br>';}?>
											<?php if(!is_null($phone)) echo "<i class=\"fa fa-phone\"></i> ".$phone;?>
										</td>
									</tr>
								</table>
			<?php }  ?>
					 
					    	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					
				</div>
			</div>
		</div>
	</div>

<script>
function display_checlist_info(){
// 	$("#department_name").val('');
	$("#checklist_info_modal").modal('show');
}
</script>
<!-- Content_right_End -->
