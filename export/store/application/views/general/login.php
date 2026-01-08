<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Hospital Caterings | Bendigo
	</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200|Open+Sans+Condensed:700" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/css/now-ui-kit.css?v=1.2.2" rel="stylesheet"/>
	<style>
	.header-filter[filter-color="black"] {
		background: rgba(44, 44, 44, 0.2);
		/* For browsers that do not support gradients */
		background: -webkit-linear-gradient(90deg, rgba(44, 44, 44, 0.6), rgba(0, 0, 0, 0.7));
		/* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(90deg, rgba(44, 44, 44, 0.6), rgba(0, 0, 0, 0.7));
		/* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(90deg, rgba(44, 44, 44, 0.6), rgba(0, 0, 0, 0.7));
		/* For Firefox 3.6 to 15 */
		background: linear-gradient(0deg, rgba(44, 44, 44, 0.6), rgba(0, 0, 0, 0.8));
		/* Standard syntax */
	}
</style>
</head>

<body class="login-page">
	<div class="page-header header-filter" filter-color="black">
		<div class="page-header-image" style="background-image:url(<?php echo base_url();?>assets/img/header.jpg)"></div>
		<div class="content">
			<div class="container">
				<div class="col-md-5 ml-auto mr-auto">
					<div class="card card-login card-plain">
						<form class="form" method="POST" action="<?php echo base_url();?>index.php/general/login_process">
							<div class="card-header text-center">
								<div class="logo-container">
									<img src="<?php echo base_url();?>assets/img/new-logo.png">
								</div>
							</div>
							<div class="card-body pt-0">
								<h3>
									<span class="text-primary"><strong>H</strong></span>ospital <span class="text-primary"><strong>C</strong></span>aterings &amp; <span class="text-primary"><strong>H</strong></span>ealthy <span class="text-primary"><strong>C</strong></span>hoices
								</h3>
								<?php if(isset($modal)&&$modal==1) echo "Your account has been created and a verification email has been sent to your email ID. Please confirm your email ID before logging in.";?>
								<?php if(isset($modal)&&$modal==2) echo "Your account has been verified!";?>
								<?php if(isset($modal)&&$modal==3) echo "Oops, invalid username/password. Please try again.";?>
								<?php if(isset($modal)&&$modal==4) echo "Password reset email sent to the provided email ID.";?>
								<?php if(isset($modal)&&$modal==5) echo "Password reset successfully!";?>
								<div class="input-group no-border input-lg">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="now-ui-icons users_circle-08"></i></span>
									</div>
									<input type="text" class="form-control" name="username" placeholder="Username / Email">
								</div>
								<div class="input-group no-border input-lg">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="now-ui-icons objects_key-25"></i></span>
									</div>
									<input type="password" class="form-control" name="password" placeholder="Password">
								</div>
							</div>
							<div class="card-footer text-center">
								<button class="btn btn-primary btn-round btn-lg btn-block" type="submit">Login</button>
							</div>
							<div class="pull-left">
								<h6>Not signed up yet?</h6>
							</div>
							<div class="pull-right">
								<h6>
									<a href="<?php echo base_url();?>index.php/general/signup" class="link footer-link">Create Account</a>
								</h6>
							</div>
							<div class="pull-left">
								<h6>Trouble logging in?</h6>
							</div>
							<div class="pull-right">
								<h6>
									<a href="#!" id="forgot-password" class="link footer-link">Forgot Password</a>
								</h6>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<div class="copyright" id="copyright">
					&copy;
					<script>
						document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
					</script>, Hospital Caterings
				</div>
			</div>
		</footer>
	</div>
	<div class="modal fade" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="forgot-password-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="<?php echo base_url();?>index.php/general/forgot_password" method="POST">
					<div class="modal-header">
						<h5 class="modal-title" id="forgot-password-label">Forgot Password</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Please enter your registered email ID below:
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<!--   Core JS Files   -->
		<script src="<?php echo base_url();?>assets/js/core/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/js/core/popper.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/js/core/bootstrap.min.js" type="text/javascript"></script>
		<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
		<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-switch.js"></script>
		<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
		<script src="<?php echo base_url();?>assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
		<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
		<script src="<?php echo base_url();?>assets/js/plugins/moment.min.js"></script>
		<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
		<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-tagsinput.js"></script>
		<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
		<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-selectpicker.js" type="text/javascript"></script>
		<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
		<script src="<?php echo base_url();?>assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
		<!--  Google Maps Plugin    -->
		<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
		<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
		<script src="<?php echo base_url();?>assets/js/now-ui-kit.js?v=1.2.2" type="text/javascript"></script>
		<script>
			$(function(){
				$("#forgot-password").on('click',function(e){
					e.preventDefault();
					$("#forgot-password-modal").modal('show');
				})
			})
		</script>
	</body>

	</html>