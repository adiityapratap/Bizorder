<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Hospital Caterings | Sign up
	</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200|Open+Sans+Condensed:700" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<!-- CSS Files -->
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/css/now-ui-kit.css?v=1.2.2" rel="stylesheet" />
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
<body class="signup-page">
	<div class="page-header header-filter" filter-color="black">
		<div class="page-header-image" style="background-image:url(<?php echo base_url();?>assets/img/bg18.jpg)"></div>
		<div class="content mt-5">
			<div class="container">
				<div class="row">
					<div class="col-md-10 ml-auto mr-auto">
						<div class="card card-signup">
							<div class="card-body">
								<h4 class="card-title text-center">Register</h4>
								<form class="form" method="POST" action="<?php echo base_url();?>index.php/general/signup_process" id="new_user_form" novalidate>
									<div class="row">
										<div class="col-6">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons users_single-02"></i></span>
												</div>
												<input type="text" class="form-control" placeholder="First Name" id="firstname" name="firstname" autocomplete="firstname">
											</div>										
										</div>
										<div class="col-6">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons users_single-02"></i></span>
												</div>
												<input type="text" class="form-control" placeholder="Last Name" id="lastname" name="lastname" autocomplete="lastname">
											</div>										
										</div>
										<div class="col-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons ui-1_email-85"></i></span>
												</div>
												<input type="text" class="form-control" placeholder="Email ID" id="email" name="email" autocomplete="email">
											</div>
											<div class="invalid-feedback exists mb-2">This email ID is already registered. Forgot your password? <a href="#!">Click here</a> to reset it!</div>
										</div>
										<hr>
										<div class="col-4">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons users_circle-08"></i></span>
												</div>
												<input type="text" class="form-control" placeholder="Username" id="username" name="username" autocomplete="username">
											</div>
										</div>
										<div class="col-4">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons ui-1_lock-circle-open"></i></span>
												</div>
												<input type="password" class="form-control" name="password" id="password" placeholder="Password...">
											</div>
										</div>
										<div class="col-4">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="now-ui-icons objects_key-25"></i></span>
												</div>
												<input type="password" class="form-control" id="confirm_password" placeholder="Confirm password">
											</div>
											<div class="invalid-feedback confirm">Passwords do not match!</div>
										</div>
										<div class="col-12">
											<span class="form-text text-black text-center">Password must be at least 6 characters long, have a number, an uppercase character and a lowercase character.</span>
										</div>
									</div>
									<div class="card-footer text-center">
										<button class="btn btn-primary btn-round btn-lg" type="submit">Get Started</a>
									</div>
									<div class="pull-right text-dark">
										<h6>Have an account?
											<a href="<?php echo base_url();?>index.php/general" class="link footer-link">Login</a>
										</h6>
									</div>
								</form>
							</div>
						</div>
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
				$("#new_user_form").on('submit',function(e){
					//Validate
					var flag=0;
					$("#password").removeClass('is-invalid');
					$("#confirm_password").removeClass('is-invalid');
					$(".invalid-feedback.password").hide();
					$(".invalid-feedback.confirm").hide();
					$("#firstname").removeClass('is-invalid');
					$("#lastname").removeClass('is-invalid');
					$("#email").removeClass('is-invalid');
					$(".invalid-feedback.exists").hide();
					var regexp=/(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.+[0-9])[a-zA-Z0-9!@#$%^&*]+/;
					if(!regexp.test($("#password").val())||$("#password").val().length<6){
						$("#password").addClass('is-invalid');
						$(".invalid-feedback.password").show();
						flag=1;
					}
					if($.trim($("#firstname").val())==''){
						$("#firstname").addClass('is-invalid');
						flag=1;
					}
					if($.trim($("#lastname").val())==''){
						$("#lastname").addClass('is-invalid');
						flag=1;
					}
					var email_regex=/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
					if($.trim($("#email").val())==''||!email_regex.test($("#email").val())){
						$("#email").addClass('is-invalid');
						flag=1;
					}
					//Also check if email exists; Need to use asynch:false in this ajax
					$.ajax({
						url:'<?php echo base_url();?>index.php/general/check_email_exists/'+$("#email").val(),
						method:"POST",
						async:false,
						success:function(data){
							if(data=="1"){
								//email exists
								$("#email").addClass('is-invalid');
								$(".invalid-feedback.exists").show();
								flag=1;
							}
						}
					})
					if($("#confirm_password").val()!=$("#password").val()){
						$("#confirm_password").addClass("is-invalid");
						$(".invalid-feedback.confirm").show();
						flag=1;
					}
					if(flag==1)
						e.preventDefault();
				})
				
			})
		</script>
	</body>

	</html>