<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-content-inner">
                        <div class="card" id="userList">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0 text-black">Menus</h5>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" href="<?php echo base_url('Orderportal/Configfoodmenu/manage_menu') ?>"><i class="ri-add-line align-bottom me-1"></i> Add Menu</a>
                                            <a class="btn btn-secondary add-btn" href="<?php echo base_url('Orderportal/Configfoodmenu/menu_options') ?>"><i class="ri-add-line align-bottom me-1"></i>Menu Options</a>
                                            <button type="button" class="btn btn-warning add-btn" id="viewInactiveItemsBtn"><i class="ri-eye-off-line align-bottom me-1"></i> View Inactive Items</button>
                                            <a class="btn btn-dark add-btn" href="<?php echo base_url('Orderportal/Configfoodmenu/downloadMenu') ?>"><i class="ri-save-line align-bottom me-1"></i> Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom-dashed border-bottom">
                                <form id="menu_filters">
                                    <div class="row g-3">
                                        <div class="col-xl-2">
                                            <input class="form-control" id="category" type="text" placeholder="Category">
                                        </div>
                                        <div class="col-xl-2">
                                            <input class="form-control" id="cuisine" type="text" placeholder="Cuisine">
                                        </div>
                                        <div class="col-xl-2">
                                            <input class="form-control" id="menu" type="text" placeholder="Menu name">
                                        </div>
                                       
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div>
                                    <?php if ($this->session->flashdata('sucess_msg')) { ?>
                                        <div class='hideMe'>
                                            <p class="alert alert-success"><?php echo $this->session->flashdata('sucess_msg'); ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if ($this->session->flashdata('error_msg')) { ?>
                                        <div class='hideMe'>
                                            <p class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <style>
                                    /* Enhanced category styling */
                                    .category-header {
                                        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%) !important;
                                        border-left: 4px solid #2196f3 !important;
                                        box-shadow: 0 2px 4px rgba(33, 150, 243, 0.1) !important;
                                    }
                                    
                                    .category-header strong {
                                        color: #1565c0 !important;
                                        font-weight: 600 !important;
                                        font-size: 16px !important;
                                        text-transform: uppercase !important;
                                        letter-spacing: 0.5px !important;
                                    }
                                    
                                    /* Menu item rows styling with drag handle */
                                    .menu-item-row {
                                        transition: background-color 0.2s ease;
                                        cursor: grab;
                                        position: relative;
                                    }
                                    
                                    .menu-item-row:hover {
                                        background-color: #f8f9fa !important;
                                    }
                                    
                                    .menu-item-row:active {
                                        cursor: grabbing;
                                    }
                                    
                                    /* Simple drag handle in dedicated column */
                                    .menu-item-row td:first-child::after {
                                        content: "☰";
                                        display: block;
                                        text-align: center;
                                        color: #999;
                                        font-size: 16px;
                                        cursor: grab;
                                        line-height: 1;
                                    }
                                    
                                    .menu-item-row:active td:first-child::after {
                                        cursor: grabbing;
                                        color: #666;
                                    }
                                    
                                    /* Item Name column styling */
                                    .item-name {
                                        background: #ffffff !important;
                                        color: #374151 !important;
                                        font-weight: 600 !important;
                                        font-size: 14px !important;
                                        padding: 12px 15px !important;
                                        border-radius: 6px !important;
                                        border-left: 3px solid #e5e7eb !important;
                                        position: relative !important;
                                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                                        transition: all 0.2s ease !important;
                                    }
                                    
                                    .menu-item-row:hover .item-name {
                                        background: #f8f9fa !important;
                                        color: #1f2937 !important;
                                        transform: translateX(2px) !important;
                                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
                                    }
                                    
                                    
                                    /* Compact Item Options column styling */
                                    .menu-item-row td.text-sm {
                                        color: #616161 !important;
                                        font-size: 12px !important;
                                        line-height: 1.3 !important;
                                        padding: 12px 15px !important;
                                    }
                                    
                                    /* Menu Options Grid Layout */
                                    .menu-options-cell {
                                        padding: 8px !important;
                                    }
                                    
                                    .menu-options-grid {
                                        display: grid;
                                        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                                        gap: 6px;
                                    }
                                    
                                    .menu-option-card {
                                        display: flex;
                                        align-items: flex-start;
                                        background: #ffffff;
                                        border: 1px solid #e3e6f0;
                                        border-radius: 8px;
                                        padding: 10px 12px;
                                        transition: all 0.2s ease;
                                        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                                        min-height: 45px;
                                    }
                                    
                                    .menu-option-card:hover {
                                        background: #f8f9fa;
                                        border-color: #28a745;
                                        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
                                        transform: translateY(-1px);
                                    }
                                    
                                    .option-indicator {
                                        width: 8px;
                                        height: 8px;
                                        background: #28a745;
                                        border-radius: 50%;
                                        margin-right: 8px;
                                        margin-top: 4px;
                                        flex-shrink: 0;
                                    }
                                    
                                    .option-content {
                                        display: flex;
                                        align-items: center;
                                        width: 100%;
                                        min-width: 0;
                                    }
                                    
                                    .option-name {
                                        font-size: 12px;
                                        font-weight: 500;
                                        color: #333;
                                        flex: 1;
                                        word-wrap: break-word;
                                        line-height: 1.3;
                                    }
                                    
                                    
                                    .no-options {
                                        color: #6c757d;
                                        font-style: italic;
                                        font-size: 12px;
                                        text-align: center;
                                        padding: 12px;
                                        background: #f8f9fa;
                                        border-radius: 6px;
                                        border: 1px dashed #dee2e6;
                                    }
                                    
                                    /* Responsive adjustments */
                                    @media (max-width: 768px) {
                                        .menu-options-grid {
                                            grid-template-columns: 1fr;
                                        }
                                    }
                                    
                                    /* Action column styling */
                                    .menu-item-row td:last-child {
                                        padding: 8px 15px !important;
                                    }
                                    
                                    /* Status column styling */
                                    .menu-item-row td.status {
                                        text-align: center !important;
                                        padding: 12px 15px !important;
                                    }
                                    
                                    /* Overall table improvements */
                                    #menuTable {
                                        border-collapse: separate !important;
                                        border-spacing: 0 2px !important;
                                    }
                                    
                                    .menu-item-row td {
                                        border: none !important;
                                        vertical-align: middle !important;
                                    }
                                    
                                    .menu-item-row td:first-child {
                                        border-top-left-radius: 6px !important;
                                        border-bottom-left-radius: 6px !important;
                                    }
                                    
                                    .menu-item-row td:last-child {
                                        border-top-right-radius: 6px !important;
                                        border-bottom-right-radius: 6px !important;
                                    }
                                    
                                    /* Section header styling if exists */
                                    .section-header {
                                        background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%) !important;
                                        border-left: 4px solid #4caf50 !important;
                                        padding: 15px 20px !important;
                                        margin: 10px 0 !important;
                                    }
                                    
                                    .section-header h4 {
                                        color: #2e7d32 !important;
                                        font-weight: 700 !important;
                                        margin: 0 !important;
                                        font-size: 18px !important;
                                        text-transform: uppercase !important;
                                        letter-spacing: 1px !important;
                                    }
                                </style>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle text-sm" id="menuTable">
                                        <thead class="table-dark text-white">
                                            <tr>
                                                <th style="width: 30px;"></th>
                                                <th>Item Name</th>
                                                <th>Item Options</th>
                                                <th style="text-align: center;">Display On Dashboard</th>
                                                <th width="120" style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <?php if (!empty($menuLists) && !empty($categories)) { ?>
                                            <?php foreach ($categories as $category) { ?>
                                                <tbody class="list form-check-all category-<?php echo $category['id']; ?> sortable">
                                                    <tr>
                                                        <th colspan="5" class="category-header text-dark w-100" style="padding: 12px 15px;">
                                                            <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                                        </th>
                                                    </tr>
                                                    <?php
                                                    $hasMenus = false;
                                                    foreach ($menuLists as $menu) {
                                                        if (in_array($category['id'], $menu['category_ids'] ?? [])) {
                                                            $hasMenus = true;
                                                    ?>
                                                            <tr id="row_<?php echo $menu['menu_id']; ?>" class="menu-item-row" data-categories="<?php echo htmlspecialchars(implode(',', $menu['category_ids'] ?? [])); ?>">
                                                                <td style="width: 30px;"></td>
                                                                <td class="menuName item-name"><?php echo htmlspecialchars($menu['menu_name']); ?></td>

                                                                <td class="text-sm menu-options-cell">
                                                                    <div class="menu-options-grid">
                                                                        <?php 
                                                                        if (!empty($menu['menu_options'])) {
                                                                            foreach($menu['menu_options'] as $option) {
                                                                                $optionName = htmlspecialchars($option['menu_option_name'] ?? '');
                                                                                echo '<div class="menu-option-card">';
                                                                                echo '<div class="option-indicator"></div>';
                                                                                echo '<div class="option-content">';
                                                                                echo '<span class="option-name">' . $optionName . '</span>';
                                                                                echo '</div>';
                                                                                echo '</div>';
                                                                            }
                                                                        } else {
                                                                            echo '<div class="no-options">No options available</div>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                                <td class="status">
                                                                    <div class="form-check form-switch form-switch-custom form-switch-success">
                                                                        <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo $menu['menu_id']; ?>" <?php echo (isset($menu['displayOnDashbord']) && $menu['displayOnDashbord'] == '1') ? 'checked' : ''; ?>>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <div class="edit">
                                                                            <a href="<?php echo base_url('Orderportal/Configfoodmenu/manage_menu/' . $menu['menu_id']); ?>" class="btn btn-sm btn-secondary edit-item-btn">
                                                                                <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit
                                                                            </a>
                                                                        </div>
                                                                        <?php /* Remove button hidden
                                                                        <div class="remove">
                                                                            <button class="btn btn-sm btn-danger remove-item-btn" data-rel-id="<?php echo $menu['menu_id']; ?>">
                                                                                <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove
                                                                            </button>
                                                                        </div>
                                                                        */ ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    if (!$hasMenus) {
                                                    ?>
                                                        <tr>
                                                            <td colspan="7" class="text-center">No menus in this category</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tbody>
                                                <tr>
                                                    <td colspan="7" class="text-center">No menus found</td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-2" id="modalTitle">Item Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDescription">
                <!-- Full description will be inserted here -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    // When any input field or select changes, filter the table
    $('#menu_filters input, #menu_filters select').on('keyup change', function () {
        filterTable();
    });

    function filterTable() {
        // Get filter input values
        let cuisine = $('#cuisine').val().toLowerCase();
        let category = $('#category').val().toLowerCase();
        let menu = $('#menu').val().toLowerCase();
        let menuType = $('#menuType').val().toLowerCase();

        // Loop through each category section
        $('#menuTable tbody').each(function () {
            let tbody = $(this);
            let categoryId = tbody.attr('class').match(/category-\d+/);
            let showTbody = category === '';

            // Check if category filter matches the category name in the header
            if (categoryId) {
                let categoryName = tbody.find('th').text().toLowerCase();
                if (categoryName.includes(category)) {
                    showTbody = true;
                }
            }

            // Show or hide the entire tbody (category section)
            if (showTbody) {
                tbody.show();
                // Filter individual rows within this tbody
                tbody.find('tr[id^="row_"]').each(function () {
                    let row = $(this);
                    let rowCuisine = row.find('.menuCuisine').text().toLowerCase();
                    let rowMenuName = row.find('.menuName').text().toLowerCase();
                    let rowMenuType = row.find('.menuType').text().toLowerCase();

                    // Check if the row matches the filters
                    if (
                        rowCuisine.includes(cuisine) &&
                        rowMenuName.includes(menu) &&
                        (menuType === '' || rowMenuType.includes(menuType))
                    ) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            } else {
                tbody.hide();
            }
        });
    }
});

// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function () {
    // Select all 'View More' links
    const viewMoreLinks = document.querySelectorAll('.view-more');

    viewMoreLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const fullDescription = this.getAttribute('data-description');
            document.getElementById('modalDescription').textContent = fullDescription;
        });
    });
});


$(function() {
    $('.toggle-demo').on('change', function() {
        var menuID = $(this).attr('id');
        let status = $(this).prop('checked') ? 1 : 0;
        var toggleElement = $(this);
        
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '<?php echo base_url("Orderportal/Configfoodmenu/update_menu_displayStatus"); ?>',
            data: { "displayOnDashbord": status, "menuID": menuID },
            success: function(data) {
                if (status === 0) {
                    // Item is now inactive, hide all rows with this menu_id
                    $('tr[id="row_' + menuID + '"]').fadeOut(300, function() {
                        $(this).remove();
                    });
                    
                    // Show toast notification
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Menu item hidden',
                        text: 'Use "View Inactive Items" to re-enable it.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    // Item is now active
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Menu item is now visible on dashboard',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            },
            error: function() {
                // Revert toggle on error
                toggleElement.prop('checked', !status);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update menu item status. Please try again.'
                });
            }
        });
    });
});

$(function() {
    $(".sortable").sortable({
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });
            $.ajax({
                url: '<?php echo base_url("Orderportal/Configfoodmenu/updateMenuSortOrder"); ?>',
                type: "POST",
                data: { order: sortOrder },
                success: function(response) {
                    // console.log("Order updated successfully");
                },
                error: function() {
                    // console.log("Error updating order");
                }
            });
        }
    });

    // Filter functionality
    function filterMenus() {
        const categoryFilter = document.getElementById('category').value.toLowerCase();
        const cuisineFilter = document.getElementById('cuisine').value.toLowerCase();
        const menuFilter = document.getElementById('menu').value.toLowerCase();
        
        // Get all menu rows
        const menuRows = document.querySelectorAll('.menu-item-row');
        const categoryHeaders = document.querySelectorAll('.category-header');
        
        menuRows.forEach(function(row) {
            const menuName = row.querySelector('.item-name').textContent.toLowerCase();
            const optionTags = row.querySelectorAll('.option-tag');
            let optionsText = '';
            optionTags.forEach(tag => {
                optionsText += tag.textContent.toLowerCase() + ' ';
            });
            
            // Get category from the row's data attribute or parent tbody
            const categoryId = row.dataset.categories;
            let categoryName = '';
            const tbody = row.closest('tbody');
            if (tbody) {
                const categoryHeader = tbody.querySelector('.category-header strong');
                if (categoryHeader) {
                    categoryName = categoryHeader.textContent.toLowerCase();
                }
            }
            
            // Check if row matches all filters
            const matchesCategory = !categoryFilter || categoryName.includes(categoryFilter);
            const matchesCuisine = !cuisineFilter || optionsText.includes(cuisineFilter) || menuName.includes(cuisineFilter);
            const matchesMenu = !menuFilter || menuName.includes(menuFilter);
            
            if (matchesCategory && matchesCuisine && matchesMenu) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Hide/show category headers based on visible items
        categoryHeaders.forEach(function(header) {
            const tbody = header.closest('tbody');
            const visibleRows = tbody.querySelectorAll('.menu-item-row[style=""], .menu-item-row:not([style*="display: none"])');
            
            if (visibleRows.length === 0) {
                header.closest('tr').style.display = 'none';
            } else {
                header.closest('tr').style.display = '';
            }
        });
    }
    
    // Add event listeners to filter inputs
    document.getElementById('category').addEventListener('input', filterMenus);
    document.getElementById('cuisine').addEventListener('input', filterMenus);
    document.getElementById('menu').addEventListener('input', filterMenus);
    
    // Clear filters function
    function clearFilters() {
        document.getElementById('category').value = '';
        document.getElementById('cuisine').value = '';
        document.getElementById('menu').value = '';
        filterMenus();
    }
    
    // Add clear button if it doesn't exist
    if (!document.getElementById('clearFilters')) {
        const filterForm = document.getElementById('menu_filters');
        const clearButton = document.createElement('div');
        clearButton.className = 'col-xl-2';
        clearButton.innerHTML = '<button type="button" id="clearFilters" class="btn btn-outline-secondary">Clear Filters</button>';
        filterForm.querySelector('.row').appendChild(clearButton);
        
        document.getElementById('clearFilters').addEventListener('click', clearFilters);
    }
});
</script>

<!-- INACTIVE MENU ITEMS MODAL -->
<div class="modal fade" id="inactiveItemsModal" tabindex="-1" aria-labelledby="inactiveItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="inactiveItemsModalLabel">
                    <i class="ri-eye-off-line me-2"></i>Inactive Menu Items
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="ri-information-line me-2"></i>
                    <strong>Note:</strong> These menu items are currently hidden from the dashboard. You can re-enable them by turning on the "Display On Dashboard" toggle.
                </div>
                
                <div id="inactiveItemsLoader" style="display: none; text-align: center; padding: 40px;">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Loading inactive menu items...</p>
                </div>
                
                <div id="inactiveItemsContent">
                    <!-- Content will be loaded here via AJAX -->
                </div>
                
                <div id="noInactiveItems" style="display: none; text-align: center; padding: 40px;">
                    <i class="ri-checkbox-circle-line" style="font-size: 64px; color: #28a745;"></i>
                    <h5 class="mt-3">No Inactive Items!</h5>
                    <p class="text-muted">All menu items are currently active and displayed on the dashboard.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// View Inactive Items Button Handler
document.getElementById('viewInactiveItemsBtn').addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('inactiveItemsModal'));
    modal.show();
    loadInactiveMenuItems();
});

// Load Inactive Menu Items via AJAX
function loadInactiveMenuItems() {
    const loader = document.getElementById('inactiveItemsLoader');
    const content = document.getElementById('inactiveItemsContent');
    const noItems = document.getElementById('noInactiveItems');
    
    // Show loader
    loader.style.display = 'block';
    content.style.display = 'none';
    noItems.style.display = 'none';
    
    // Fetch inactive menus
    fetch('<?php echo base_url("Orderportal/Configfoodmenu/get_inactive_menus"); ?>')
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
            
            if (data.status === 'success' && data.data.length > 0) {
                content.style.display = 'block';
                renderInactiveMenuItems(data.data);
            } else {
                noItems.style.display = 'block';
            }
        })
        .catch(error => {
            loader.style.display = 'none';
            content.innerHTML = `
                <div class="alert alert-danger">
                    <i class="ri-error-warning-line me-2"></i>
                    <strong>Error:</strong> Failed to load inactive menu items. Please try again.
                    <br><small class="mt-2">Details: ${error.message || 'Network error'}</small>
                </div>
            `;
            content.style.display = 'block';
            console.error('Error loading inactive menus:', error);
            console.error('Full error details:', error);
        });
}

// Render Inactive Menu Items Table
function renderInactiveMenuItems(items) {
    const content = document.getElementById('inactiveItemsContent');
    
    let html = `
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>Item Name</th>
                        <th>Categories</th>
                        <th style="text-align: center; width: 200px;">Display On Dashboard</th>
                        <th style="text-align: center; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
    `;
    
    items.forEach(item => {
        html += `
            <tr id="inactive_row_${item.menu_id}">
                <td><strong>${item.menu_name}</strong></td>
                <td><span class="badge bg-info">${item.categories || 'N/A'}</span></td>
                <td style="text-align: center;">
                    <div class="form-check form-switch form-switch-custom form-switch-success d-inline-block">
                        <input class="form-check-input toggle-inactive-item" type="checkbox" role="switch" 
                               id="inactive_toggle_${item.menu_id}" 
                               data-menu-id="${item.menu_id}">
                    </div>
                </td>
                <td style="text-align: center;">
                    <a href="<?php echo base_url('Orderportal/Configfoodmenu/manage_menu/'); ?>${item.menu_id}" 
                       class="btn btn-sm btn-secondary">
                        <i class="ri-edit-box-line me-1"></i>View/Edit
                    </a>
                </td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    content.innerHTML = html;
    
    // Attach event listeners to all toggle switches
    document.querySelectorAll('.toggle-inactive-item').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const menuId = this.getAttribute('data-menu-id');
            const isChecked = this.checked;
            enableMenuItem(menuId, isChecked, this);
        });
    });
}

// Enable Menu Item (Update displayOnDashbord status)
function enableMenuItem(menuId, status, toggleElement) {
    const statusValue = status ? 1 : 0;
    
    // Show loading state
    toggleElement.disabled = true;
    
    $.ajax({
        type: "POST",
        url: '<?php echo base_url("Orderportal/Configfoodmenu/update_menu_displayStatus"); ?>',
        data: { 
            "displayOnDashbord": statusValue, 
            "menuID": menuId 
        },
        success: function(response) {
            toggleElement.disabled = false;
            
            if (statusValue === 1) {
                // Item is now active, remove from inactive list
                Swal.fire({
                    icon: 'success',
                    title: 'Menu Item Enabled!',
                    text: 'The menu item is now visible on the dashboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Remove row from inactive items table
                const row = document.getElementById('inactive_row_' + menuId);
                if (row) {
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        
                        // Check if table is empty now
                        const tbody = document.querySelector('#inactiveItemsContent tbody');
                        if (tbody && tbody.children.length === 0) {
                            document.getElementById('inactiveItemsContent').style.display = 'none';
                            document.getElementById('noInactiveItems').style.display = 'block';
                        }
                    }, 300);
                }
                
                // Refresh main page after 2 seconds to show the newly enabled item
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        },
        error: function() {
            toggleElement.disabled = false;
            toggleElement.checked = !status; // Revert toggle
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update menu item status. Please try again.'
            });
        }
    });
}
</script>