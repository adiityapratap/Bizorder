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
    
    /* Fix specific notification text visibility issues */
    .dropdown-menu h6,
    .dropdown-menu .fs-16,
    .dropdown-menu .fs-18,
    .dropdown-menu .fs-13,
    .dropdown-menu .fs-11,
    .dropdown-menu .text-black,
    .dropdown-menu .nav-link,
    .dropdown-menu .text-center h6 {
        color: #000000 !important;
        font-weight: bold !important;
        opacity: 1 !important;
    }
    
    /* Ensure "Notifications" header is visible */
    .dropdown-head h6.text-white {
        color: #ffffff !important;
    }
    
    /* Ensure "Alerts" tab text is visible */
    .nav-tabs .nav-link {
        color: #ffffff !important;
    }
    
    /* Active tab should have black text on white background */
    .nav-tabs .nav-link.active {
        color: #000000 !important;
        background-color: #ffffff !important;
    }
    
    /* Ensure notification content text is visible */
    .dropdown-menu .text-faded {
        color: #333333 !important;
    }
    
    /* Fix "Mark all as read" link - target exact HTML structure */
    p.mx-3 a.link-danger,
    p.mx-3 a.link-danger.link-offset-2.text-decoration-underline,
    p.mx-3 a.link-danger.link-underline-opacity-25,
    .mx-3 .link-danger,
    a.link-danger.link-offset-2.text-decoration-underline,
    .link-danger.link-offset-2.text-decoration-underline,
    .link-danger.link-underline-opacity-25,
    .link-danger {
        color: #000000 !important;
        text-decoration: underline !important;
    }
    
    /* Also target the paragraph containing the link */
    p.mx-3,
    p.mx-3 a,
    .mx-3 a {
        color: #000000 !important;
    }
    
    /* Fix notification description text - target exact classes */
    .fs-13.text-faded,
    .fs-13.text-faded p,
    .fs-13.text-faded p.mb-1,
    div.fs-13.text-faded,
    div.fs-13.text-faded p {
        color: #000000 !important;
    }
    
    /* Fix all notification content in the specific structure */
    .text-reset.notification-item.d-block.dropdown-item .flex-1,
    .text-reset.notification-item.d-block.dropdown-item .flex-1 *,
    .notification-item .flex-1 div.fs-13.text-faded,
    .notification-item .flex-1 div.fs-13.text-faded p {
        color: #000000 !important;
    }
    
    /* Override any remaining white text in tab content */
    .tab-content .text-faded,
    .tab-content .text-faded *,
    #notificationItemsTabContent .text-faded,
    #notificationItemsTabContent .text-faded * {
        color: #000000 !important;
    }
    
    /* Fix time text visibility - target exact HTML structure */
    p.mb-0.fs-11.fw-medium.text-uppercase,
    p.mb-0.fs-11.fw-medium.text-uppercase span,
    p.mb-0.fs-11.fw-medium.text-uppercase span i,
    .mb-0.fs-11.fw-medium.text-uppercase,
    .mb-0.fs-11.fw-medium.text-uppercase *,
    .fs-11.fw-medium.text-uppercase,
    .fs-11.fw-medium.text-uppercase *,
    .notification-item p.mb-0,
    .notification-item p.mb-0 *,
    .notification-item .fs-11,
    .notification-item .fs-11 * {
        color: #000000 !important;
        font-weight: bold !important;
        opacity: 1 !important;
    }
    
    /* Force visibility on clock icon and time text */
    .mdi-clock-outline,
    i.mdi-clock-outline,
    span i.mdi-clock-outline {
        color: #000000 !important;
    }
    
    /* ULTRA-SPECIFIC TARGETING - FORCE BLACK COLOR ON ALL NOTIFICATION TEXT */
    div#notificationWrap div.dropdown-menu div.tab-content div.tab-pane div[data-simplebar] div.simplebar-content p.mx-3 a.link-danger,
    div#notificationWrap p.mx-3 a,
    div#notificationWrap .mx-3 a,
    div#notificationWrap a.link-danger,
    #notificationWrap p.mx-3,
    #notificationWrap p.mx-3 *,
    #notificationWrap .link-danger,
    #notificationWrap .link-danger * {
        color: #000000 !important;
        text-decoration: underline !important;
    }
    
    /* ULTRA-SPECIFIC TIME TEXT TARGETING */
    div#notificationWrap div.notification-item p.mb-0.fs-11.fw-medium.text-uppercase,
    div#notificationWrap div.notification-item p.mb-0.fs-11.fw-medium.text-uppercase *,
    div#notificationWrap p.mb-0,
    div#notificationWrap p.mb-0 *,
    div#notificationWrap .fs-11,
    div#notificationWrap .fs-11 *,
    #notificationWrap p[style*="color: #000000"],
    #notificationWrap p[style*="color: #000000"] *,
    #notificationWrap span,
    #notificationWrap span * {
        color: #000000 !important;
        font-weight: bold !important;
        opacity: 1 !important;
    }
    
    /* FORCE OVERRIDE ANY BOOTSTRAP/THEME COLORS */
    [id="notificationWrap"] * {
        color: #000000 !important;
    }
    
    /* EXCLUDE HEADER AREA FROM BLACK COLOR */
    [id="notificationWrap"] .dropdown-head,
    [id="notificationWrap"] .dropdown-head *,
    [id="notificationWrap"] .bg-primary,
    [id="notificationWrap"] .bg-primary * {
        color: #ffffff !important;
    }
</style>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="flex items-center ">
                <div class="text-xl font-bold tracking-wider flex items-center">
                    
                  <a href="/Orderportal">  <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="60" width="110"></a>
                </div>
            </div>
               
                 <?php 
                 $common_view_path = APPPATH . 'views/topMenus/sidebar.php';
                 include($common_view_path);
                 ?>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                
            </div>

            <div class="d-flex align-items-center">
            

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"   class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <a href="/Orderportal"><i class='bx bxs-home fs-22 text-white'></i></a>
                    </button>
                </div>
                
                <!-- Order Snapshots Button (Admin Only) -->
                <?php if($this->ion_auth->in_group('admin')) { ?>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" 
                            title="📸 Order Snapshots - View Historical Records (Orders, Patients, Menu Prices - All Locked Forever)"
                            style="position: relative;">
                        <a href="<?php echo base_url('Orderportal/Reports/snapshots'); ?>" style="text-decoration: none;">
                            <i class='ri-database-2-line fs-22 text-white'></i>
                        </a>
                        <!-- Optional: Add a small badge to indicate it's a special feature -->
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" 
                              style="font-size: 8px; padding: 2px 4px;">
                            📸
                        </span>
                    </button>
                </div>
                <?php } ?>
                
         <?php
         
         $result = fetchAllUnreadNotification($this->tenantDb,1,1);
	     $resultRead = fetchAllUnreadNotification($this->tenantDb,1,0);
        $allNotifications = (isset($result['result']) ? $result['result'] : ''); 
        $allNotificationsCount = (isset($result['total_count']) ? $result['total_count'] : ''); 
        // $data['readNotifications'] = (isset($resultRead['result']) ? $resultRead['result'] : '');
      
        ?>
             
                 
                 <?php if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('chef')) {   ?>
                 <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22 text-white'></i>
                        <?php if(isset($allNotificationsCount) && $allNotificationsCount !='') { ?>
                        <span  class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                            <?php echo $allNotificationsCount; ?><span class="visually-hidden">unread messages</span>
                            </span>
                                <?php } ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" style="width:340px" aria-labelledby="page-header-notifications-dropdown">
                        

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold" style="color: #ffffff !important; font-weight: bold !important;"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> <?php echo (isset($allNotificationsCount) && $allNotificationsCount !='' ? $allNotificationsCount.' New' : '') ?> </span>
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
                                   <?php if(!empty($allNotifications)) {  ?>
                                   <p class="mx-3" style="color: #000000 !important;"><a href="#" class="link-danger link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover" onclick="markAllread('alert')" style="color: #000000 !important; text-decoration: underline !important;">Mark all as read</a></p>
                                   <?php foreach($allNotifications as $allNotification) { ?>
                                     
                                     <input type="hidden" id="notification_Alert" name="notification_Alert[]" value="<?php echo $allNotification['id'] ?>">
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                           <div class="avatar-xs me-3 flex-shrink-0">
                                                <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                    <i class="bx bx-message-square-dots"></i>
                                                </span>
                                            </div>
                                           <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold" style="color: #000000 !important; font-weight: bold !important;"><?php echo fetchSystemNameFromId($allNotification['system_id']);  ?></h6>
                                                </a>
                                                <div class="fs-13 text-faded" style="color: #000000 !important;">
                                                    <p class="mb-1" style="color: #000000 !important;">
                                        <?php echo $allNotification['title']; ?>                
                                                        </p>
                                                </div>
                                                <!-- HIDDEN: Timestamp below notification (user requested to hide) -->
                                                <!-- <p class="mb-0 fs-11 fw-medium text-uppercase" style="color: #000000 !important; font-weight: bold !important;">
                                                    <span style="color: #000000 !important;"><i class="mdi mdi-clock-outline" style="color: #000000 !important;"></i> <?php 
                                                    // CRITICAL FIX: Use Australia/Sydney timezone for notification timestamp display
                                                    // The date/time stored in DB is already in Australia/Sydney, but we need to parse it correctly
                                                    $timezone = new DateTimeZone('Australia/Sydney');
                                                    // Parse the stored date and time, treating it as Australia/Sydney timezone
                                                    $dateStr = $allNotification['date']; // Y-m-d format (e.g., 2025-11-21)
                                                    $timeStr = $allNotification['time']; // h:i A format (e.g., 04:41 PM)
                                                    // Create DateTime object treating the stored values as Australia/Sydney timezone
                                                    $notificationDateTime = DateTime::createFromFormat('Y-m-d h:i A', $dateStr . ' ' . $timeStr, $timezone);
                                                    if ($notificationDateTime) {
                                                        echo $notificationDateTime->format('d-m-Y h:i A');
                                                    } else {
                                                        // Fallback: use stored values directly (they're already in correct format)
                                                        echo date('d-m-Y', strtotime($dateStr)) . ' ' . $timeStr;
                                                    }
                                                    ?></span>
                                                    
                                                </p> -->
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <?php  } ?>
                                    
                                       
                                  <?php } else{  ?>
                                  
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                    <img src="/theme-assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                </div>
                                <div class="text-center pb-5 mt-2">
                                    <h6 class="fs-18 fw-semibold lh-base" style="color: #000000 !important; font-weight: bold !important;">Hey! You have no any notifications </h6>
                                </div>
                                <?php } ?>

                                  <div class="my-3 text-center d-none">
                                        <a href="/notification/notification" class="btn btn-soft-success waves-effect waves-light">View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i></a>
                                    </div>
                                   
                                </div>

                            </div>

                          <div class="tab-pane fade  py-2 ps-2" id="messages-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                   <?php if(!empty($allNotifications)) {  ?>
                                   <p class="mx-3" style="color: #000000 !important;"><a href="#" class="link-danger link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover" onclick="markAllread('msg')" style="color: #000000 !important; text-decoration: underline !important;">Mark all as read</a></p>
                                   <?php foreach($allNotifications as $allNotification) { ?>
                                     <?php if(!empty($allNotification['notification_type'] == 'msg')) {  ?>
                                      <input type="hidden" id="notification_Msg" name="notification_Msg[]" value="<?php echo $allNotification['id'] ?>">
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                           <div class="avatar-xs me-3 flex-shrink-0">
                                                <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                    <i class="bx bx-message-square-dots"></i>
                                                </span>
                                            </div>
                                           <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold text-black"> <?php echo fetchSystemNameFromId($allNotification['system_id']);  ?></h6>
                                                </a>
                                                <div class="fs-13 text-faded" style="color: #000000 !important;">
                                                    <p class="mb-1" style="color: #000000 !important;">
                                        <?php echo $allNotification['title']; ?>                
                                                        </p>
                                                </div>
                                                <!-- HIDDEN: Timestamp below notification (user requested to hide) -->
                                                <!-- <p class="mb-0 fs-11 fw-medium text-uppercase" style="color: #000000 !important; font-weight: bold !important;">
                                                    <span style="color: #000000 !important;"><i class="mdi mdi-clock-outline" style="color: #000000 !important;"></i> <?php 
                                                    // CRITICAL FIX: Use Australia/Sydney timezone for notification timestamp display
                                                    // The date/time stored in DB is already in Australia/Sydney, but we need to parse it correctly
                                                    $timezone = new DateTimeZone('Australia/Sydney');
                                                    // Parse the stored date and time, treating it as Australia/Sydney timezone
                                                    $dateStr = $allNotification['date']; // Y-m-d format (e.g., 2025-11-21)
                                                    $timeStr = $allNotification['time']; // h:i A format (e.g., 04:41 PM)
                                                    // Create DateTime object treating the stored values as Australia/Sydney timezone
                                                    $notificationDateTime = DateTime::createFromFormat('Y-m-d h:i A', $dateStr . ' ' . $timeStr, $timezone);
                                                    if ($notificationDateTime) {
                                                        echo $notificationDateTime->format('d-m-Y h:i A');
                                                    } else {
                                                        // Fallback: use stored values directly (they're already in correct format)
                                                        echo date('d-m-Y', strtotime($dateStr)) . ' ' . $timeStr;
                                                    }
                                                    ?></span>
                                                    
                                                </p> -->
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <?php } } ?>
                                    
                                       
                                  <?php } else{  ?>
                                  
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                    <img src="/theme-assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                </div>
                                <div class="text-center pb-5 mt-2">
                                    <h6 class="fs-18 fw-semibold lh-base" style="color: #000000 !important; font-weight: bold !important;">Hey! You have no any notifications </h6>
                                </div>
                                <?php } ?>

                                  <div class="my-3 text-center">
                                        <a href="/notification/notification" class="btn btn-soft-success waves-effect waves-light">View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i></a>
                                    </div>
                                   
                                </div>

                            </div>
                           
                        </div>
                    </div>
                </div>
                 <?php } ?>

              
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="/theme-assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo ($this->session->userdata('username') !='' ? $this->session->userdata('username') : '') ; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                   <?php if($this->session->userdata('location_name') !=''){ ?>
                                    <i class="bx bx-map"></i> <?php echo $this->session->userdata('location_name') ; ?>
                                    <?php } ?>
                                </span>
                                 <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                   <?php if($this->session->userdata('system_id') !=''){ ?>
                                    <i class=" bx bx-laptop"></i> <?php echo fetchSystemNameFromId($this->session->userdata('system_id')); ?>
                                    <?php } ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end bg-primary">
                        <!-- item-->
                    
                        <h6 class="dropdown-header">Welcome <?php echo ($this->session->userdata('username') !='' ? $this->session->userdata('username') :''); ?>!</h6>
                        <!--<a class="dropdown-item" href="/profile/<?php echo ($this->session->userdata('user_id') !='' ? $this->session->userdata('user_id') :''); ?>"><i-->
                        <!--        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span-->
                        <!--        class="align-middle">Profile</span></a>-->
                        <?php if ($this->ion_auth->in_group('admin')): ?>
                           <a class="dropdown-item"  href="<?= base_url('auth/group_listing') ?>">
                             <i class="mdi mdi-account-plus text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Roles</span>
                          </a>
                        
                         <a class="dropdown-item" href="<?= base_url('auth/userListing') ?>">
                             <i class="mdi mdi-account-multiple-plus text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Users</span>
                        </a>

                          <a class="dropdown-item" href="<?= base_url($this->session->userdata('tenantIdentifier') . '/Orderportal/Settings') ?>">
                           <i class="mdi mdi-store-cog text-white fs-16 align-middle me-1 "></i> <span class="align-middle text-white">CONFIG</span>
                          </a>
                        <?php endif  ?>
                        
               <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i  class="mdi mdi-logout text-white fs-16 align-middle me-1"></i> <span class="align-middle text-white" data-key="t-logout">Logout</span>
                               
                                
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>


function markAllread(typeOfNotification){
    var values = [];
   
    if(typeOfNotification == 'msg'){
     $('input[name="notification_Msg[]"]').each(function() {
       values.push($(this).val());
       });   
    }else{
     $('input[name="notification_Alert[]"]').each(function() {
       values.push($(this).val());
       });   
    }
      
           $.ajax({
            type: "POST",
            url: "/Auth/markAllNotificationAsread", // Replace with your controller's URL
            data: { values: values },
            success: function (response) {
               location.reload();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
}

// MOBILE MENU TOGGLE FUNCTIONALITY
$(document).ready(function() {
    // Create mobile menu if it doesn't exist
    if (window.innerWidth <= 768 && !$('.mobile-menu').length) {
        createMobileMenu();
    }
    
    // Handle window resize
    $(window).on('resize', function() {
        if (window.innerWidth <= 768 && !$('.mobile-menu').length) {
            createMobileMenu();
        } else if (window.innerWidth > 768) {
            $('.mobile-menu').remove();
        }
    });
    
    // Toggle mobile menu
    $(document).on('click', '#topnav-hamburger-icon', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (window.innerWidth <= 768) {
            if (!$('.mobile-menu').length) {
                createMobileMenu();
            }
            $('.mobile-menu').toggleClass('show');
        }
    });
    
    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.mobile-menu, #topnav-hamburger-icon').length) {
            $('.mobile-menu').removeClass('show');
        }
    });
    
    // Close menu when clicking on a menu item
    $(document).on('click', '.mobile-menu .nav-link', function() {
        $('.mobile-menu').removeClass('show');
    });
    
    function createMobileMenu() {
        // Get menu items from the original menu
        var menuItems = [];
        $('#navbar-nav .nav-item').each(function() {
            var $link = $(this).find('.nav-link');
            if ($link.length) {
                menuItems.push({
                    text: $link.text().trim(),
                    href: $link.attr('href') || '#'
                });
            }
        });
        
        // Create mobile menu HTML
        var mobileMenuHTML = '<div class="mobile-menu"><div class="nav-items">';
        
        // Add hierarchical menu items if no items found
        if (menuItems.length === 0) {
            menuItems = [
                { text: 'MENU PLANNER', href: '/Orderportal/Recipe', type: 'main' },
                { text: 'SUITES', href: '/Orderportal/Recipe/suites', type: 'main' },
                { text: 'RECIPES', href: '#', type: 'main' },
                { text: 'ADMIN', href: '/Orderportal/Recipe/recipes', type: 'sub', parent: 'RECIPES' },
                { text: 'CREATE RECIPES', href: '/Orderportal/Recipe/createRecipes', type: 'sub', parent: 'RECIPES' },
                { text: 'MENU CREATION', href: '#', type: 'main' },
                { text: 'ADMIN', href: '/Orderportal/Recipe/menuAdmin', type: 'sub', parent: 'MENU CREATION' },
                { text: 'CREATE MENU', href: '/Orderportal/Recipe/createMenu', type: 'sub', parent: 'MENU CREATION' },
                { text: 'ORDERS', href: '/Orderportal/orders', type: 'main' },
                { text: 'INVOICES', href: '#', type: 'main' },
                { text: 'DAILY INVOICES', href: '/Orderportal/Invoice/dailyInvoice', type: 'sub', parent: 'INVOICES' },
                { text: 'BULK INVOICE', href: '/Orderportal/Invoice/bulkInvoice', type: 'sub', parent: 'INVOICES' }
            ];
        }
        
        menuItems.forEach(function(item) {
            var itemClass = item.type === 'main' ? 'nav-item main-menu' : 'nav-item sub-menu';
            var linkClass = item.type === 'main' ? 'nav-link main-link' : 'nav-link sub-link';
            mobileMenuHTML += '<div class="' + itemClass + '"><a href="' + item.href + '" class="' + linkClass + '">' + item.text + '</a></div>';
        });
        
        mobileMenuHTML += '</div></div>';
        
        // Add mobile menu to header
        $('#page-topbar .layout-width').append(mobileMenuHTML);
    }
});
</script>

