<!DOCTYPE html>
<html lang="en">
<?php $userId = $this->session->userdata('user_id'); ?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nach Food Co.</title>
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
	<link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/jquery.auto-complete.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
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
   
      console.log($(this).find(".down_menu").attr("class"));
  })   
})


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
					<a href="#"><span class="logo-default"> <img src="<?php echo base_url();?>assets/images/logo.png" alt="" style="max-width:60px;"> </span> </a>
					<div class="icon_menu full_menu"  onclick="openNav()">
						<a href="#" class="menu-toggler sidebar-toggler" ></a>
					</div>
				</div>
				
				<div id="mySidepanel" class="sidepanel">
				    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
	                    <ul id="dc_accordion" class="sidebar-menu tree">
	                                   <?php if($is_customer == 1){ ?>
	                                        <li class="menu_sub">
											    <a href="<?php echo base_url();?>index.php/orders/order_history">View Orders</a>
											</li>
	                                   <?php }else{ ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/orders/open_dash/"> <i class="fa fa-home"></i> <span>Dashboard</span></a>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-shopping-cart"></i> <span>Offers</span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    <li>
													<a href="<?php echo base_url();?>index.php/orders/new_quote_save">Request for Offers</a>
												</li>
											    <li>
													<a href="<?php echo base_url();?>index.php/orders/quote_history">View Offers</a>
												</li>
												
											</ul>
										</li>
									    <li class="menu_sub">
											<a href="#"> <i class="fa fa-user"></i> <span>Suppliers </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/suppliers">View Suppliers</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/add_supplier">Add Supplier</a>
												</li>
											
												
											
											</ul>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-th"></i> <span>Category </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/category_listing">View Category</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/add_category">Add Category</a>
												</li>
											
												
											
											</ul>
										</li>
											
										<?php } ?>
										
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/general/logout"> <i class="fa fa-sign-out"></i> <span>Logout</span></a>
										</li>
									<?php if($is_customer == 0){ ?>
										<li class="menu_sub notification-badge">
											
											
											<a href="#"> <i class="fa fa-bell"></i> <span class="badge badge-info" style="background-color: #4caf50;"><?php echo (!empty( $notifications_count[0]['total_count']) ?  $notifications_count[0]['total_count'] : ''); ?></span> </a>
											<ul class="down_menu">
												<li>
													 <?php  if(!empty($notifications)) { foreach($notifications as $notification){  ?>
                                                        <li  ><a href=""><?php  echo $notification->description;    ?></a></li>
                                                    <?php  } } ?>
												</li>
												
											</ul>
										</li>
									<?php } ?>
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
											    <a href="<?php echo base_url();?>index.php/orders/order_history">View Orders</a>
											</li>
	                                   <?php }else{ ?>
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/orders/open_dash/"> <i class="fa fa-home"></i> <span>Dashboard</span></a>
										</li>
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-shopping-cart"></i> <span>Offers </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/new_quote_save">Request for Offer</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/quote_history">View Offers</a>
												</li>
											
												
											
											</ul>
										</li>
										
										<li class="menu_sub">
											<a href="#"> <i class="fa fa-user"></i> <span>Suppliers </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/suppliers">View Suppliers</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/add_supplier">Add Supplier</a>
												</li>
											
												
											
											</ul>
										</li>
    									<li class="menu_sub">
											<a href="#"> <i class="fa fa-th"></i> <span>Category </span> <span class="arrow"></span> </a>
											<ul class="down_menu">
											    	<li>
													<a href="<?php echo base_url();?>index.php/orders/category_listing">View Category</a>
												</li>
											   <li>
													<a href="<?php echo base_url();?>index.php/orders/add_category">Add Category</a>
												</li>
											
												
											
											</ul>
										</li>
											
										<?php } ?>
									
										<li class="menu_sub">
											<a href="<?php echo base_url();?>index.php/general/logout"> <i class="fa fa-sign-out"></i> <span>Logout</span></a>
										</li>
										<?php if($is_customer == 0){ ?>
										<li class="menu_sub notification-badge">
											
											
											<a href="#"> <i class="fa fa-bell"></i> <span class="badge badge-info" style="background-color: #4caf50;display:block"><?php echo (!empty( $notifications_count[0]['total_count']) ?  $notifications_count[0]['total_count'] : '0'); ?></span> </a>
											<ul class="down_menu">
												<li>
													 <?php  if(!empty($notifications)) { foreach($notifications as $notification){  ?>
                                                        <li  ><a href=""><?php  echo $notification->description;    ?></a></li>
                                                    <?php  } } ?>
												</li>
												
											</ul>
										</li>
										<?php } ?>	
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</header>