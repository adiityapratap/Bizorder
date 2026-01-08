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
</style>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    
                    <a href="/Supplier/<?php echo $this->session->userdata('system_id'); ?>" class="logo logo-dark">
                        
                        <span class="logo-lg">
                            <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="50">
                        </span>
                    </a>

                    <a href="/Supplier/<?php echo $this->session->userdata('system_id'); ?>" class="logo logo-light">
                       
                        <span class="logo-lg">
                            <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="50">
                        </span>
                    </a>
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
                        <a href="/auth/checklist"><i class='bx bxs-home fs-22 text-white'></i></a>
                    </button>
                </div>

              
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
                        
                       
                       <?php if ($this->session->userdata('is_admin')){ ?>
                        
                          <a class="dropdown-item" target="_blank" href="<?= base_url('Supplier/configuresubmit') ?>"><i
                                class="mdi mdi-store-cog text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>   
                                
                       <?php  }  ?>
                        
                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

