<div class="main">
	<div class="section pt-2">
		<div class="container">
			<form action="" method="POST">
			<h2 class="section-title">Profile</h2>
			<div class="row">
				<div class="col-12 col-md-6">
					First Name
					<input type="text" class="form-control" name="firstname" value="<?php echo $firstname;?>" required>
				</div>
				<div class="col-12 col-md-6">
					Last Name
					<input type="text" class="form-control" name="lastname" value="<?php echo $lastname;?>" required>
				</div>
				<div class="col-12 col-md-6 mt-2">
					Email ID
					<input type="email" class="form-control" name="email" value="<?php echo $customer_email;?>" disabled>
				</div>
				<div class="col-12 col-md-6 mt-2">
					Phone
					<input type="text" class="form-control" name="phone" value="<?php echo $customer_phone;?>">
				</div>
			</div>

		</div>
	</div>
</div>
