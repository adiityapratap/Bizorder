<!DOCTYPE html>
<html lang="en">
<?php 
$userId = $this->session->userdata('user_id');
$userID = $this->session->userdata('userID');
?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Healthy Choices Catering</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/ionicons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/simple-line-icons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link href="<?php echo base_url();?>assets/css/jquery.auto-complete.css" rel="stylesheet">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" >
	 
     <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
     <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
    <link href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
    


	<style>
		.bg-custom-warning{
			background:none;
			background-color:#ffb056;
		}
		
      .notification-badge .badge{
        background-color: #4caf50 !important ;
        display: inline-block !important;
        color: #fff;
        padding: 2px 5px;
        border-radius: 5px;
        line-height: normal;
        min-width: 16px;
      }
      .notification-badge i{
          margin-right: 2px !important;
      }
  
	</style>
	<script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}

$(document).ready(function(){
   $(".menu_sub").on("click",function(){
      $(this).find(".down_menu").toggle();
  })   
})

  $(document).ready(function() {
      // Initialize the date picker
      $(".datepicker").flatpickr({
        enableTime: false,
        dateFormat: "d-m-Y",
      });

      // Initialize the time picker
      $(".timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
         dateFormat: "h:i K",
        time_24hr: false,
      });
    });


	</script>
</head>
<body>
    <?php  

$CI =& get_instance();
$CI->load->model('Orders_model');

$notifications = $CI->Orders_model->fetch_manager_notifications();  
$notifications_count = $CI->Orders_model->fetch_notifications_count();


?> 
<?php $is_customer = $this->session->userdata('is_customer'); ?>
	<div class="wrapper">
		<!-- header -->
		<header class="main-header">
			<div class="container_header">
				<div class="logo d-flex align-items-center"> 
					<a href="<?php echo base_url();?>index.php/general/branches"><span class="logo-default"> <img src="<?php echo base_url();?>assets/images/logo.png" alt="" style="max-width:200px;"> </span> </a>
					<div class="icon_menu full_menu"  onclick="openNav()">
						<a href="#" class="menu-toggler sidebar-toggler" ></a>
					</div>
				</div>
				
				<div id="mySidepanel" class="sidepanel">
				    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
	                    <ul id="dc_accordion" class="sidebar-menu tree">
	                                   <?php if($is_customer == 1){ ?>
	                                        <li class="menu_sub">
											    <a href="<?php echo base_url();?>index.php/orders/order_history">Future Orders</a>
											</li>
	                                   <?php }else{ ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/orders/open_dash/<?php echo $this->session->userdata('branch_id'); ?>"> <i class="fa fa-home"></i> <span>Dashboard</span></a>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-shopping-cart"></i> <span>Quotes</span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    <li>
													<a href="<?php echo base_url();?>index.php/orders/new_quote">Place a Quote</a>
												</li>
											    <li>
													<a href="<?php echo base_url();?>index.php/orders/quote_history">View Quotes</a>
												</li>
												
											</ul>
										</li>
										<!--<li class="menu_sub">-->
    						<!--					<a href="<?php echo base_url();?>index.php/orders/production"> <i class="fa fa-cutlery"></i> <span>Production</span></a>-->
    						<!--			</li>-->
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-shopping-cart"></i> <span>Orders </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    <?php if($userId !=8 and $_SESSION['username'] != 'footscraychef' ) { ?>
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/orders/new_order_customer_details">Place Orders</a>-->
												<!--</li>-->
												<?php } ?>
													<li>
													<a href="<?php echo base_url();?>index.php/orders/order_history">Future Orders</a>
												</li>
												 <?php if($_SESSION['username'] != 'footscraychef' ) { ?>
												<li>
													<a href="<?php echo base_url();?>index.php/orders/past_orders">Past Orders</a>
												</li>
													<?php } ?>
											
												<!-- <?php if($userId !=8 and $_SESSION['username'] != 'footscraychef' ) { ?>-->
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/orders/standing_orders">Standing Orders</a>-->
												<!--</li>-->
												
												<!--	<?php } ?>-->
												
												
											</ul>
										</li>
										
										<?php if($userID != 4){ ?>
										<!--<li class="menu_sub">-->
    						<!--					<a href="<?php echo base_url();?>index.php/orders/production"> <i class="fa fa-cutlery"></i> <span>Production</span></a>-->
    						<!--			</li>-->
									
										
											
									
										<!--<li class="menu_sub">-->
										<!--	<a href="<?php echo base_url();?>index.php/general/products"> <i class="fa fa-cutlery"></i> <span>Products</span></a>-->
											
										<!--</li>-->
										<?php } ?>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-users"></i> <span>Customers</span> <span class="arrow"></span> </a>
											<ul class="down_menu">
												<li>
													<a href="<?php echo base_url();?>index.php/general/customers_listing">Customers</a>
												</li>
												<li>
													<a href="<?php echo base_url();?>index.php/general/company_listing">Company</a>
												</li>
												<li>
													<a href="<?php echo base_url();?>index.php/general/department_listing">Department</a>
												</li>
												<li>
													<a href="<?php echo base_url();?>index.php/orders/view_all_feedback">Customer's Feedbacks</a>
												</li>
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/survey/fetch_survey">Survey</a>-->
												<!--</li>-->
											
												<li>
													<a href="<?php echo base_url();?>index.php/orders/active_coupons">Coupons</a>
												</li>
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/orders/archived_coupons">Archived Coupons</a>-->
												<!--</li>-->
        											
											</ul>
										</li>
										
									
    										    <li class="menu_sub">
													 <a href="<?php echo base_url();?>index.php/orders/reports"><i class="fa fa-edit"></i> <span>Reports</span></a>
												</li>
											
										<?php } ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/general/logout"> <i class="fa fa-sign-out"></i> <span>Logout</span></a>
										</li>
									<!--<?php if($is_customer == 0){ ?>-->
									<!--	<li class="menu_sub notification-badge">-->
											
											
									<!--		<a href="#"> <i class="fa fa-bell"></i> <span class="badge badge-info" style="background-color: #4caf50;"><?php echo (!empty( $notifications_count[0]['total_count']) ?  $notifications_count[0]['total_count'] : ''); ?></span> </a>-->
									<!--		<ul class="down_menu">-->
									<!--			<li>-->
									<!--				 <?php  if(!empty($notifications)) { foreach($notifications as $notification){  ?>-->
         <!--                                               <li  ><a href=""><?php  echo $notification->description;    ?></a></li>-->
         <!--                                           <?php  } } ?>-->
									<!--			</li>-->
												
									<!--		</ul>-->
									<!--	</li>-->
									<!--<?php } ?>-->
									</ul>
                </div>

				<div class="right_detail" id="menu_bar_header">
					<div class="row d-flex align-items-center min-h pos-md-r">
						<div class="col-xl-12 col-12 d-flex justify-content-end">
							<div class="right_bar_top d-flex align-items-center">
								<div class="navigation scroll_auto">
									<ul id="dc_accordion" class="sidebar-menu tree">
									    <?php if($is_customer == 1){ ?>
	                                        <li class="menu_sub">
											    <a href="<?php echo base_url();?>index.php/orders/order_history">Future Orders</a>
											</li>
	                                   <?php }else{ ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/orders/open_dash/<?php echo $this->session->userdata('branch_id'); ?>"> <i class="fa fa-home"></i> <span>Dashboard</span></a>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-sticky-note"></i> <span>Quotes </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/new_quote">Place a Quote</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/quote_history">View Quotes</a>
												</li>
											
												
											
											</ul>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-shopping-cart"></i> <span>Orders </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											  
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/orders/new_order_customer_details">Place Orders</a>-->
												<!--</li>-->
											
													<li>
												    
													<a href="<?php echo base_url();?>index.php/orders/order_history">Future Orders</a>
												</li>
											   
												<li>
													<a href="<?php echo base_url();?>index.php/orders/past_orders">Past Orders</a>
												</li>
												
											
												<!--<li>-->
												<!--	<a href="<?php echo base_url();?>index.php/orders/standing_orders">Standing Orders</a>-->
												<!--</li>-->
												
												
												
												
											</ul>
										</li>
										<?php if($userID != 4){ ?>
    										<!--<li class="menu_sub">-->
        						<!--					<a href="<?php echo base_url();?>index.php/orders/production"> <i class="fa fa-cutlery"></i> <span>Production</span></a>-->
        						<!--			</li>-->
    									
    										<!--<li class="menu_sub">-->
    										<!--	<a href="<?php echo base_url();?>index.php/general/products"> <i class="fa fa-cutlery"></i> <span>Products</span></a>-->
    											
    										<!--</li>-->
    									<?php } ?>
										
											<li class="menu_sub">
											
    											<a href="#"> <i class="fa fa-users"></i> <span>Customers</span> <span class="arrow"></span> </a>
    											<ul class="down_menu">
    												<li>
    													<a href="<?php echo base_url();?>index.php/general/customers_listing">Customers</a>
    												</li>
    												<li>
    													<a href="<?php echo base_url();?>index.php/general/company_listing">Company</a>
    												</li>
    												<li>
    													<a href="<?php echo base_url();?>index.php/general/department_listing">Department</a>
    												</li>
    												<li>
    													<a href="<?php echo base_url();?>index.php/orders/view_all_feedback">Customer's Feedbacks</a>
    												</li>
    												
    												<!--	<li>-->
    												<!--	<a href="<?php echo base_url();?>index.php/orders/customer_cost_center">Customer Cost Center</a>-->
    												<!--</li>-->
    												
    												<!--<li>-->
    												<!--	<a href="<?php echo base_url();?>index.php/survey/fetch_survey">Survey</a>-->
    												<!--</li>-->
    												
    												<li>
    													<a href="<?php echo base_url();?>index.php/orders/active_coupons">Coupons</a>
    												</li>
    												<!--<li>-->
    												<!--	<a href="<?php echo base_url();?>index.php/orders/archived_coupons">Archived Coupons</a>-->
    												<!--</li>-->
            										
    											</ul>
    										</li>
										
    										    <li class="menu_sub">
													 <a href="<?php echo base_url();?>index.php/orders/reports"><i class="fa fa-bar-chart"></i> <span>Reports</span></a>
												</li>
											
										<?php } ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/general/logout"> <i class="fa fa-sign-out"></i> <span>Logout</span></a>
										</li>
										<!--<?php if($is_customer == 0){ ?>-->
										<!--<li class="menu_sub notification-badge">-->
											
											
										<!--	<a href="#"> <i class="fa fa-bell"></i> <span class="badge badge-info" style="background-color: #4caf50;display:block"><?php echo (!empty( $notifications_count[0]['total_count']) ?  $notifications_count[0]['total_count'] : '0'); ?></span> </a>-->
										<!--	<ul class="down_menu">-->
										<!--		<li>-->
										<!--			 <?php  if(!empty($notifications)) { foreach($notifications as $notification){  ?>-->
          <!--                                              <li  ><a href=""><?php  echo $notification->description;    ?></a></li>-->
          <!--                                          <?php  } } ?>-->
										<!--		</li>-->
												
										<!--	</ul>-->
										<!--</li>-->
										<!--<?php } ?>	-->
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</header>