<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover-active" data-sidebar-image="none" data-preloader="disable">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>BIZORDER</title>
  <link rel="shortcut icon" href="<?php echo base_url();?>login-assets/img/favicon.jpeg" />
  

    
   <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
 // we have a common header to import all css for all the Apps like HR, Cash , Supplier etc
     $common_view_path = APPPATH . 'views/general/header.php';
      $canvas_view_path = APPPATH . 'views/general/systemCanvasForTabView.php';
     include($common_view_path);
     
?>
   
  

</head>
<body data-base-url="<?php echo base_url(); ?>">
<?php include($canvas_view_path); ?>

    <div id="layout-wrapper">
        <style>
    div#notificationWrap a.dropdown-item {
        display: flex;
        align-items: flex-start;
        white-space: break-spaces;
        font-size: 13px;
    }
    div#notificationWrap {
        min-width: 320px;
    }
    #notificationWrap i {
        color: #864868 !important;
    }
    
    /* Notification Text Visibility Fix */
    .dropdown-menu h6,
    .dropdown-menu p,
    .dropdown-menu span,
    .dropdown-menu .text-black {
        color: #000000 !important;
        opacity: 1 !important;
        font-weight: bold !important;
    }

    .dropdown-menu .fs-18,
    .dropdown-menu .fs-16,
    .dropdown-menu .fs-13,
    .dropdown-menu .fs-11 {
        color: #000000 !important;
        font-weight: bold !important;
    }

    .dropdown-menu .text-center h6 {
        color: #000000 !important;
        font-weight: bold !important;
        opacity: 1 !important;
    }
    
    /* Notification header should remain white */
    .dropdown-head h6.text-white {
        color: #ffffff !important;
    }
    
    /* Navigation tabs styling */
    .nav-tabs .nav-link {
        color: #ffffff !important;
    }
    
    .nav-tabs .nav-link.active {
        color: #000000 !important;
        background-color: #ffffff !important;
    }
</style>
<header id="page-topbar" style="background-color: #152a45;">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO - EXACT SAME AS ORDERPORTAL -->
                <div class="flex items-center ">
                <div class="text-xl font-bold tracking-wider flex items-center">
                    <a href="/Orderportal">  <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="60" width="110"></a>
                </div>
            </div>

                <!-- Navigation Menu -->
                <?php 
                $common_view_path = APPPATH . 'views/topMenus/sidebar.php';
                include($common_view_path);
                ?>
                
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <!-- Home Icon -->
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <a href="/Orderportal"><i class='bx bxs-home fs-22 text-white'></i></a>
                    </button>
                </div>
                
                <!-- Notification Bell - SAME AS ORDERPORTAL -->
                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22 text-white'></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" style="width:340px" aria-labelledby="page-header-notifications-dropdown">
                        
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold" style="color: #ffffff !important; font-weight: bold !important;"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                    id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#alerts-tab" role="tab"
                                            aria-selected="false" style="color: #000000 !important; font-weight: bold !important;">
                                            Alerts
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="tab-content" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="alerts-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="/theme-assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base" style="color: #000000 !important; font-weight: bold !important;">Hey! You have no any notifications</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown - EXACT SAME AS ORDERPORTAL -->
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="/theme-assets/images/users/user-dummy-img.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 text-white fw-medium user-name-text"><?php echo ($this->session->userdata('username') !='' ? $this->session->userdata('username') : '') ; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-white user-name-sub-text">
                                   <?php if($this->session->userdata('system_id') !=''){ ?>
                                    <i class="bx bx-map"></i> <?php echo fetchSystemNameFromId($this->session->userdata('system_id')); ?>
                                    <?php } ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end bg-primary">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?php echo ($this->session->userdata('username') !='' ? $this->session->userdata('username') :''); ?>!</h6>
                        
                        <?php if ($this->ion_auth->in_group('admin')): ?>
                           <a class="dropdown-item" href="<?= base_url('auth/group_listing') ?>">
                             <i class="mdi mdi-account-plus text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Roles</span>
                           </a>
                           <a class="dropdown-item" href="<?= base_url('auth/userListing') ?>">
                             <i class="mdi mdi-account-multiple-plus text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Users</span>
                           </a>
                           <a class="dropdown-item" href="<?= base_url($this->session->userdata('tenantIdentifier') . '/Orderportal/Settings') ?>">
                             <i class="mdi mdi-store-cog text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white">CONFIG</span>
                           </a>
                        <?php endif ?>
                        
                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                            <i class="mdi mdi-logout text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
</div>

 <div class="container-fluid" style="margin-top: 0 !important;">
 <div class="container-fluid" style="margin-top: 0 !important;">