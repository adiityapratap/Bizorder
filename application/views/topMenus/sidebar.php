<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu mx-5">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <?php 
        $userGroups = $this->ion_auth->get_users_groups()->row();
        $roleId = ($userGroups && isset($userGroups->id)) ? $userGroups->id : 1; // Default to role ID 1 if not found
        $allMenus = fetch_render_menu($this->session->userdata('system_id'),$this->session->userdata('user_id'),$roleId,'frontSites'); 
        ?>
     
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
         <!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu mx-5">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <?php 
        $userGroups = $this->ion_auth->get_users_groups()->row();
        $roleId = ($userGroups && isset($userGroups->id)) ? $userGroups->id : 1; // Default to role ID 1 if not found
        $allMenus = fetch_render_menu(
            $this->session->userdata('system_id'),
            $this->session->userdata('user_id'),
            $roleId,
            'frontSites'
        ); ?>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <?php 
                // Check if user is a nurse
                $currentRoleId = $this->session->userdata('role_id');
                $userGroups = $this->ion_auth->get_users_groups()->row();
                $alternativeRoleId = ($userGroups && isset($userGroups->id)) ? $userGroups->id : null;
                $isNurse = ($currentRoleId == 3 || $alternativeRoleId == 3);
                ?>

                <?php if ($isNurse) : ?>
                    <!-- Nurse-specific navigation - Show only Hospital Admin dropdown -->
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#nurse-menu-collapse"
                            data-bs-toggle="collapse"
                            role="button"
                            aria-expanded="true"
                            aria-controls="nurse-menu-collapse"
                            onclick="toggleNurseMenu(event)">
                            <i class="ri-nurse-line me-2"></i>
                            <span data-key="t-nurse-menu">Hospital Admin</span>
                            <i class="ri-arrow-down-s-line ms-auto"></i>
                        </a>

                        <div class="menu-dropdown show" id="nurse-menu-collapse">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?= base_url('Orderportal/Patient/Onboarding') ?>" class="nav-link">
                                        <i class="ri-user-add-line me-2"></i>
                                        <span>View Person Details</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Orderportal/Hospitalconfig/List') ?>" class="nav-link">
                                        <i class="ri-hospital-line me-2"></i>
                                        <span>Manage Suites</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Orderportal/Menuplanner/list') ?>" class="nav-link">
                                        <i class="ri-restaurant-line me-2"></i>
                                        <span>Menu Planner</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php else : ?>
                    <!-- Regular menu for non-nurse users -->
                    <?php if (!empty($allMenus)) : ?>
                        <?php foreach ($allMenus as $allMenu) : ?>
                            <?php
                            // Generate unique collapse ID
                            $collapseId = 'menu-collapse-' . $allMenu->menu_id;
                            ?>

                            <?php if (isset($allMenu->sub_menu) && !empty($allMenu->sub_menu) && !empty($allMenu->selected)) : ?>
                                <!-- Parent Menu with Sub Menu -->
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#<?= $collapseId ?>"
                                        data-bs-toggle="collapse"
                                        role="button"
                                        aria-expanded="<?= $allMenu->selected ? 'true' : 'false' ?>"
                                        aria-controls="<?= $collapseId ?>"
                                        onclick="toggleMenuDropdown(event, '<?= $collapseId ?>')">
                                        <span data-key="t-landing"><?= $allMenu->menu_name ?></span>
                                        <i class="ri-arrow-down-s-line ms-auto"></i>
                                    </a>

                                    <div class=" menu-dropdown <?= $allMenu->selected ? 'show' : '' ?>" id="<?= $collapseId ?>">
                                        <ul class="nav nav-sm flex-column">
                                            <?php foreach ($allMenu->sub_menu as $subMenu) : ?>
                                                <?php if (!empty($subMenu->selected)) : ?>
                                                    <li class="nav-item">
                                                        <a href="<?= base_url($subMenu->sub_menu_url) ?>" class="nav-link" data-key="t-calendar">
                                                            <?= $subMenu->sub_menu_name ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php elseif (!empty($allMenu->selected)) : ?>
                                <!-- Single Menu Item (No Submenu) -->
                                <li class="nav-item">
                                    <a href="<?= base_url($allMenu->menu_url) ?>" class="nav-link" data-key="t-calendar">
                                        <?= $allMenu->menu_name ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->


        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

<script>
// Custom function to handle Hospital Admin dropdown toggle
function toggleNurseMenu(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const menu = document.getElementById('nurse-menu-collapse');
    const link = event.currentTarget;
    
    if (menu.classList.contains('show')) {
        menu.classList.remove('show');
        link.setAttribute('aria-expanded', 'false');
    } else {
        menu.classList.add('show');
        link.setAttribute('aria-expanded', 'true');
    }
}

// Custom function to handle regular menu dropdown toggle
function toggleMenuDropdown(event, collapseId) {
    event.preventDefault();
    event.stopPropagation();
    
    const menu = document.getElementById(collapseId);
    const link = event.currentTarget;
    
    if (menu.classList.contains('show')) {
        menu.classList.remove('show');
        link.setAttribute('aria-expanded', 'false');
    } else {
        menu.classList.add('show');
        link.setAttribute('aria-expanded', 'true');
    }
}

// Prevent conflicts with other Bootstrap collapse elements
document.addEventListener('DOMContentLoaded', function() {
    // Handle Hospital Admin dropdown
    const nurseMenuLink = document.querySelector('[data-bs-toggle="collapse"][aria-controls="nurse-menu-collapse"]');
    if (nurseMenuLink) {
        // Remove Bootstrap data attributes to prevent conflicts
        nurseMenuLink.removeAttribute('data-bs-toggle');
        
        // Ensure the dropdown is visible by default for nurses
        const collapseElement = document.getElementById('nurse-menu-collapse');
        if (collapseElement) {
            collapseElement.classList.add('show');
            nurseMenuLink.setAttribute('aria-expanded', 'true');
        }
    }
    
    // Handle all regular menu dropdowns
    const menuLinks = document.querySelectorAll('[data-bs-toggle="collapse"]:not([aria-controls="nurse-menu-collapse"])');
    menuLinks.forEach(link => {
        // Remove Bootstrap data attributes to prevent conflicts
        link.removeAttribute('data-bs-toggle');
    });
});
</script>

<!-- Vertical Overlay-->
