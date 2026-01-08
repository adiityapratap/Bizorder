<header id="header" class="bg-brand-blue text-white fixed top-0 left-0 right-0 z-50 shadow-md">
        <div class="container mx-auto px-4 flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="text-xl font-bold tracking-wider flex items-center">
                    
                    <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="50"  width="100">
                </div>
            </div>
            
            <!-- Navigation Items -->
           <?php 
                 $common_view_path = APPPATH . 'views/topMenus/Tailwind/sidebar.php';
                 include($common_view_path);
                 ?>
                 
                  <?php
         
         $result = fetchAllUnreadNotification($this->tenantDb,1,1);
	     $resultRead = fetchAllUnreadNotification($this->tenantDb,1,0);
        $allNotifications = (isset($result['result']) ? $result['result'] : ''); 
        $allNotificationsCount = (isset($result['total_count']) ? $result['total_count'] : ''); 
        // $data['readNotifications'] = (isset($resultRead['result']) ? $resultRead['result'] : '');
      
        ?>
            
            <!-- Right Side Icons -->
            <div class="flex items-center space-x-4">
    <!-- Bell Icon -->
    <button class="text-white relative">
        <i class="fa-solid fa-bell text-lg"></i>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
            <?php echo ($allNotificationsCount ?? '') ?>
        </span>
    </button>

    <!-- Home Icon -->
    <button class="text-white">
        <a href="/Orderportal"><i class="fa-solid fa-home text-lg"></i></a> 
    </button>

    <!-- User Avatar with Dropdown -->
    <div class="relative group">
        <div class="flex items-center space-x-2 border-l pl-4 border-blue-700 cursor-pointer">
            <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center text-white font-medium">
                <i class="fa-solid fa-utensils"></i>
            </div>
            <div class="hidden md:block">
                <div class="text-xs font-medium">
                    <?php echo $this->session->userdata('username') ?? ''; ?>
                </div>
                <?php if ($this->session->userdata('system_id') != ''): ?>
                <div class="text-xs text-blue-200">
                    <?php echo fetchSystemNameFromId($this->session->userdata('system_id')); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Dropdown -->
        <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg z-50 hidden group-hover:block">
            <?php if ($this->ion_auth->in_group('admin')): ?>
                <a href="<?= base_url('auth/group_listing') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="mdi mdi-account-plus mr-2 text-blue-600"></i> Roles
                </a>
                <a href="<?= base_url('auth/userListing') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="mdi mdi-account-multiple-plus mr-2 text-blue-600"></i> Users
                </a>
                <a href="<?= base_url($this->session->userdata('tenantIdentifier') . '/Orderportal/Settings') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="mdi mdi-store-cog mr-2 text-blue-600"></i> CONFIG
                </a>
            <?php endif; ?>
            <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="mdi mdi-logout mr-2 text-red-600"></i> Logout
            </a>
        </div>
    </div>
</div>

        </div>
    </header>