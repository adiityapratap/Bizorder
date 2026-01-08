<!DOCTYPE html>
<html lang="en">
<?php $userId = $this->session->userdata('user_id'); ?>
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
	<link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/jquery.auto-complete.css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <link href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
	<style>
	body {
        background-color: #ffffff;
    }
    .p-4 {
        padding: 1.5rem!important;
    }
    .align-items-center {
        -webkit-box-align: center!important;
        -ms-flex-align: center!important;
        align-items: center!important;
    }
    .justify-content-center {
        -webkit-box-pack: center!important;
        -ms-flex-pack: center!important;
        justify-content: center!important;
    }
    .h-100 {
        height: 100%!important;
    }
    .w-100 {
        width: 100%!important;
    } 
    .d-flex {
        display: -webkit-box!important;
        display: -ms-flexbox!important;
        display: flex!important;
    }
		.bg-custom-warning{
			background:none;
			background-color:#ffb056;
		}

     .customBranchRow {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 60px;
    }
    .logo-default{
        margin-bottom:54px;
        margin-top:2rem;
    }
    .customBranchRow a .card{
        background-color: transparent;
    }   
    .customBranchRow a {
        display:block;
        font-weight:700;
        box-shadow: 0 3px 3px rgb(56 65 74 / 14%);
    }
    .mb-2{
        margin-bottom: 15px;
    }
    h1.pagetitle {
        font-size: 24px;
        margin-bottom: 26px;
        font-weight: 700;
    }
    .btn-soft-success {
        color: #fff;
        background-color: #00c87c !important;;
        border-color: transparent;
    }
    .btn-soft-danger {
            color: #ffffff;
    background-color: #e84c2b!important;
    }
    .btn-soft-secondary {
        color: #ffffff;
        background-color: #3577f1 !important;
        border-color: transparent;
    }
    .btn-soft-danger:active, .btn-soft-danger:focus, .btn-soft-danger:hover {
        color: #fff!important;
        background-color: #f06548!important;
        border-color: transparent;
    }
    .btn-soft-success:active, .btn-soft-success:focus, .btn-soft-success:hover {
        color: #fff!important;
        background-color: #45cb85!important;
        border-color: transparent;
    }
    .btn-soft-secondary:active, .btn-soft-secondary:focus, .btn-soft-secondary:hover {
        color: #fff!important;
        background-color: #3577f1!important;
        border-color: transparent;
    }
	</style>
</head>
<body>
 
	<div class="wrapper">
	    <div class="container">
	        <div class="row customBranchRow">
    	        <div class="col-lg-12 text-center">
    	            <div class="logo-default"> <img src="<?php echo base_url();?>assets/images/logo.png" alt="" style="max-height:67px;"> </div>
                    <h1 class="pagetitle">Locations</h1>    	        
    	        </div>
    	        
    	        <?php if(!empty($branches)){
    	            $colorBg = array('success','secondary','danger');
    	            $i=0;
    	            foreach($branches as $branch){
    	        ?>
        	        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2">
        	            <a href="<?php echo base_url();?>index.php/orders/open_dash/<?php echo $branch->location_id; ?>" class="btn btn-lg btn-soft-<?php echo $colorBg[$i]; ?> p-4 w-100 h-100 d-flex justify-content-center align-items-center"><?php echo $branch->location_name; ?></a>
        	        </div>
    	        <?php $i++; } } ?>
    	        
	        </div>
		</div>