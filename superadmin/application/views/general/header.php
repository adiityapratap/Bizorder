<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover-active" data-sidebar-image="none" data-preloader="disable">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>BIZORDER</title>
  <link rel="shortcut icon" href="<?php echo base_url();?>login-assets/img/favicon.jpeg" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- glightbox css -->
        <link rel="stylesheet" href="<?php echo base_url(""); ?>theme-assets/libs/glightbox/css/glightbox.min.css">
         <script src="<?php echo base_url(""); ?>login-assets/js/custom.js"></script>
    <!-- Sweet Alert css-->
    <link href="<?php echo base_url(""); ?>theme-assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Layout config Js -->
    <script src="<?php echo base_url(""); ?>theme-assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url(""); ?>theme-assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url(""); ?>theme-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url(""); ?>theme-assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo base_url(""); ?>theme-assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(""); ?>theme-assets/css/custom-style.css" rel="stylesheet" type="text/css" />

</head>
<body>

	<!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                   
                        <a href="<?php echo base_url(); ?>index.php/auth/dashboard" class="logo logo-dark">
                        
                        <span class="logo-sm">
                            <img src="<?php echo base_url() ?>theme-assets/images/logo/BizAdmin-Logo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url() ?>theme-assets/images/logo/BizAdmin-Logo.png" alt="" height="25">
                        </span>
                    </a>

                    
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>
            <div class="app-menu navbar-menu mx-3">
              
             <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                
                <!--menu for all users-->
                 <li class="nav-item">
                         <a href="<?php echo base_url(); ?>index.php/locations" class="nav-link" data-key="t-calendar"><i class="ri-store-2-line"></i><span data-key="t-landing">Location</span></a>
                        </li>
                           <li class="nav-item">
                         <a href="<?php echo base_url(); ?>index.php/organization/system_listing" class="nav-link" data-key="t-calendar"><i class="ri-function-line"></i><span data-key="t-landing">Systems</span></a>
                        </li>
                        <li class="nav-item">
                         <a href="<?php echo base_url(); ?>index.php/organization" class="nav-link" data-key="t-calendar"><i class="ri-store-3-line"></i><span data-key="t-landing">Organization</span></a>
                        </li>
                       
                       
                     
                       
                         
                        
                    
                       
                        
            </ul>        
            </div>
             <div class="d-flex align-items-center">
                <ul  class="navbar-nav dropdown ms-sm-3 header-item ">
                  
                    <li class="nav-item">
                           
                            <a class="nav-link menu-link" href="#userDropdown" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <span class="d-flex align-items-center">
                                    <i class="bx bxs-user-circle fs-24"></i>
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $this->session->userdata('username');?></span>
                                    </span>
                                </span>
                            </a>
                            <div class="collapse menu-dropdown dropdown-menu-end" id="userDropdown">
                                <ul class="nav nav-sm flex-column p-3">
                                  
                                    <li class="nav-item">
                                        <h6 class="dropdown-header">Welcome <?php echo $this->session->userdata('username');?>!</h6>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/auth/logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                                    </li>
                                </ul>
                            </div>
                    </li>
                    </ul>
                                    
                
            </div>
           
           
        </div>
     
    </div>
</header>
         <!-- ========== App Menu ========== -->
       
      