<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bizadmin</title>
	<link rel="shortcut icon" href="https://bizadmin.com.au/login-assets/img/favicon.jpeg" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script src="<?php echo base_url(""); ?>theme-assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/plugins.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/layout.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/prismjs/prism.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/form-validation.init.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/password-addon.init.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/js/pages/select2.init.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/libs/list.js/list.min.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/libs/list.pagination.js/list.pagination.min.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/js/pages/listjs.init.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/modal.init.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/app.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/nouislider/nouislider.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/wnumb/wNumb.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/range-sliders.init.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/libs/swiper/swiper-bundle.min.js"></script>
   <script src="<?php echo base_url(""); ?>theme-assets/js/pages/swiper.init.js"></script>
   <script src="<?php echo base_url(""); ?>login-assets/js/custom.js"></script>
   
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="<?php echo base_url(""); ?>login-assets/js/custom.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/jquery.signature.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="<?php echo base_url(""); ?>theme-assets/js/pages/form-pickers.init.js"></script>
      <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
      <script src="<?php echo base_url(""); ?>theme-assets/libs/apexcharts/apexcharts.min.js"></script>
     <script  src="<?php echo base_url(""); ?>theme-assets/js/pages/dashboard-crm.init.js"></script>
    <!--css           -->
   <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
   <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/glightbox/css/glightbox.min.css">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(""); ?>theme-assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/style.css" rel="stylesheet" type="text/css" />
     <link href="<?php echo base_url(""); ?>theme-assets/css/jquery.signature.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/@simonwep/pickr/themes/classic.min.css"/> 
    <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/@simonwep/pickr/themes/monolith.min.css"/> 
    <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/@simonwep/pickr/themes/nano.min.css"/>
   <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/nouislider/nouislider.min.css">
   <link href="<?php echo base_url(""); ?>theme-assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
   <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
   
 <style>
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none; /* Hide initially */
        }

        .spinner-border {
            width: 8rem;
            height: 8rem;
            border-width: 0.4rem;
            top: 50%;
            left: 50%;
            position: absolute;
        }
.logo-lg img{
    height: 50px;
    width: 139px;
    margin-left: 100px;
}
        }
  .navbar-header .navbar-menu{
    background: transparent !important;
    padding: 0 !important;
    position: relative !important;
    width: unset !important;
    display: flex !important;
    align-items: center !important;    
        }
    </style>
</head>
<body style="background-color: #f3f6f905;">
    
 <header id="page-topbar" style="left: 0;">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="#" class="logo logo-dark">
                        <span class="logo-lg">
                          <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="50">
                        </span>
                    </a>
                </div>
               
<div class="app-menu navbar-menu" style="background: transparent;left: 60%;border-right: 1px solid #212529; padding: 0;position: relative;width: unset;display: flex; align-items: center;">
   
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu" class="text-white fs-24 fw-bold"> <?php echo (isset($headerTitle) && $headerTitle !='' ? $headerTitle : ''); ?></div>
          </div>
        <!-- Sidebar -->
    </div>
</div>
 </div>
 </div>
    </div>
</header>   
    
    
    
    
    
    
    
   
    <div class="main-content" style="margin-left: 0 !important;">
  <div class="page-content">
     <div class="loader-container" id="loaderContainer">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
</div>

	