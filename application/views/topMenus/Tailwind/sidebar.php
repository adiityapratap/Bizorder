 <?php 
                $roleId = $this->ion_auth->get_users_groups()->row()->id;
                $allMenus = fetch_render_menu($this->session->userdata('system_id'), $this->session->userdata('user_id'), $roleId, 'frontSites');
                ?>

    
     <nav class="hidden md:flex items-center justify-center space-x-1 flex-1 mx-10">
          <?php if (!empty($allMenus)) { ?>
                    <?php foreach ($allMenus as $allMenu) { ?>
                        <?php if (isset($allMenu->sub_menu) && !empty($allMenu->sub_menu) && isset($allMenu->selected) && $allMenu->selected != '') { ?>
                         <div class="relative group">
                    <span class="px-3 py-2 text-sm font-medium hover:bg-blue-800 rounded transition flex items-center cursor-pointer">
                        <a href="#sidebar-<?php echo str_replace(' ', '-', $allMenu->menu_name); ?>"><?php echo strtoupper($allMenu->menu_name); ?></a>
                        <i class="fa-solid fa-chevron-down ml-1 text-xs"></i>
                    </span>
                   
                    <div class="absolute left-0 mt-1 w-48 bg-white rounded-md shadow-lg hidden group-hover:block z-50">
                         <?php foreach ($allMenu->sub_menu as $subMenu) { ?>
                     <?php if (isset($subMenu->selected) && $subMenu->selected != '') { ?>
                        <span class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"><a href="<?php echo base_url($subMenu->sub_menu_url); ?>"><?php echo strtoupper($subMenu->sub_menu_name); ?></a></span>
                    <?php } ?>
                    <?php } ?>
                    </div>
                </div>
                        
                        
                        
                         <?php }else{  ?>
                        <span class="px-3 py-2 text-sm font-medium hover:bg-blue-800 rounded transition cursor-pointer"><a href="<?php echo base_url($allMenu->menu_url); ?>"><?php echo strtoupper($allMenu->menu_name); ?></a></span> 
                         <?php } ?>
                        <?php } ?>
                <?php } ?>
               
               
            </nav>