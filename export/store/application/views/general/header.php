<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Hospital Caterings | Ipswich
	</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200|Open+Sans+Condensed:700" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/css/now-ui-kit.css?v=1.2.2" rel="stylesheet" />
	<script src="<?php echo base_url();?>assets/js/core/jquery.min.js" type="text/javascript"></script>
	<style>
		.navbar .navbar-nav .nav-link:not(.btn){
			font-size:0.8em;
		}
		.navbar .badge{
			font-size:1em;
		}
		@media screen and (max-width: 991px){
			.navbar .dropdown.show .dropdown-menu, .navbar .dropdown .dropdown-menu {
				height:auto;
			}
		}
	</style>
</head>

<body class="ecommerce-page">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg bg-primary fixed-top">
		<div class="container-fluid">
			<div class="navbar-translate">
				<a class="navbar-brand" href="<?php echo base_url();?>index.php/store/home"><h3 class="mb-0">Hospital Caterings</h3></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#example-navbar-primary" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-bar bar1"></span>
					<span class="navbar-toggler-bar bar2"></span>
					<span class="navbar-toggler-bar bar3"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="example-navbar-primary">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="<?php echo base_url();?>index.php/store/home">
							<i class="now-ui-icons objects_globe"></i>
							<p>Home</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>index.php/store/all_products">
							<i class="now-ui-icons education_paper"></i>
							<p><strong>Full Menu</strong></p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>index.php/general/healthy_choices">
							<i class="now-ui-icons travel_info"></i>
							<p>Healthy Choices</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>index.php/general/contact_us">
							<i class="now-ui-icons ui-2_chat-round"></i>
							<p>Contact Us</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url();?>index.php/general/faqs">
							<i class="now-ui-icons education_glasses"></i>
							<p>FAQs</p>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="profile_dropdown" data-toggle="dropdown">
							<i class="now-ui-icons users_circle-08" aria-hidden="true"></i>
							<p><?php echo $_SESSION['firstname'];?></p>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile_dropdown">
							<!-- <a class="dropdown-item" href="<?php echo base_url();?>index.php/general/profile">
								<i class="now-ui-icons users_single-02"></i> Profile
							</a> -->
							<a class="dropdown-item" href="<?php echo base_url();?>index.php/general/past_orders">
								<i class="now-ui-icons files_paper"></i> Past Orders
							</a>
							<a class="dropdown-item" href="<?php echo base_url();?>index.php/store/logout">
								<i class="now-ui-icons ui-1_lock-circle-open"></i> Logout
							</a>
						</div>
					</li>
					<?php if(empty($page)){?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="cart_dropdown" data-toggle="dropdown" href="#">
							<i class="now-ui-icons shopping_cart-simple"></i>
							<p>Cart  <span class="badge badge-neutral text-primary" id="item_count" style="margin-top:-2px;"><?php echo isset($item_count)?$item_count:0;?></span></p>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cart_dropdown">
							<table class="table dropdown-item">
								<thead>
									<tr>
										<th>Product</th>
										<th>Quantity</th>
										<th>Total</th>
										<th>Remove</th>
									</tr>
								</thead>
								<tbody id="cart_header">
									<?php if(!empty($cart_items)){
										$cart_total=0.0;
										foreach($cart_items as $item){
											echo "<tr id=\"item-row-".$item['product_id']."\">";
											echo "<td>".$item['product_name']."</td>";
											echo "<td>".$item['quantity']."</td>";
											echo "<td>$".number_format($item['total'],2)."</td>";
											echo "<td><button class=\"btn btn-danger btn-icon btn-round\" onclick=\"removeItem('".$item['product_id']."')\"><i class=\"fas fa-times ml-auto mr-auto\"></i></button></td>";
											echo "</tr>";
											$cart_total+=$item['total'];
										}
										echo "<tr id=\"cart_total_row\">";
										echo "<td>&nbsp;</td>";
										echo "<td>Total</td>";
										echo "<td>$".number_format($cart_total,2)."</td>";
										echo "<td>&nbsp;</td>";
										echo "</tr>";
										echo "<tr><td colspan=\"4\"><a href=\"".base_url()."index.php/store/checkout\" class=\"btn btn-primary pull-right\" style=\"font-size:1em\"><i class=\"fas fa-shopping-bag\"></i> Review &amp; Checkout</a></td></tr>";
									}
									else{
										echo "<tr id=\"no_results\"><td colspan=\"4\">Nothing in cart yet!</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</li>
					<?php }?>
				</ul>
			</div>
		</div>
	</nav>
	<!-- End Navbar -->
	<div class="wrapper">