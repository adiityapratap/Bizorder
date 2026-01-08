<?php
// Helper function to convert allergen IDs to names
function getAllergenNames($allergenValues, $allergies) {
    if (empty($allergenValues)) {
        return '';
    }
    
    // Parse allergen IDs (handle JSON or CSV format)
    $allergenIds = [];
    if (is_string($allergenValues)) {
        $decoded = json_decode($allergenValues, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $allergenIds = $decoded;
        } else {
            $allergenIds = array_map('trim', explode(',', $allergenValues));
        }
    }
    
    // Convert IDs to names
    $allergenNames = [];
    foreach ($allergies as $allergy) {
        if (in_array($allergy['id'], $allergenIds)) {
            $allergenNames[] = $allergy['name'];
        }
    }
    
    return !empty($allergenNames) ? implode(', ', $allergenNames) : '';
}

// Helper function to convert cuisine IDs to comma-separated names
function getCuisineNames($cuisineValues, $cuisines) {
    if (empty($cuisineValues)) {
        return '';
    }
    
    // Parse cuisine IDs (handle JSON array format)
    $cuisineIds = [];
    if (is_string($cuisineValues)) {
        $decoded = json_decode($cuisineValues, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $cuisineIds = $decoded;
        } else {
            // Fallback: try comma-separated format
            $cuisineIds = array_map('trim', explode(',', $cuisineValues));
            $cuisineIds = array_filter($cuisineIds, 'is_numeric');
        }
    } elseif (is_array($cuisineValues)) {
        $cuisineIds = $cuisineValues;
    }
    
    // Convert IDs to names
    $cuisineNames = [];
    foreach ($cuisines as $cuisine) {
        if (in_array($cuisine['id'], $cuisineIds)) {
            $cuisineNames[] = $cuisine['name'];
        }
    }
    
    return !empty($cuisineNames) ? implode(', ', $cuisineNames) : '';
}
?>
<style>
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loader {
    border: 4px solid #f3f3f3; /* Light grey border */
    border-top: 4px solid #3498db; /* Blue spinner */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div>
                <?php if ($this->session->userdata('sucess_msg')): ?>
                    <div class='hideMe'>
                        <p class="alert alert-success"><?php echo $this->session->flashdata('sucess_msg'); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->userdata('error_msg')): ?>
                    <div class='hideMe'>
                        <p class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-content-inner">
                        <div class="card" id="menuOptionList">
                          <div class="card-header border-bottom-dashed">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="me-3">
            <h5 class="card-title mb-0 text-black"><?php echo htmlspecialchars($title); ?></h5>
            <p class="text-dark small mb-0">Manage your item options</p>
        </div>

        <div class="w-100 w-md-50 w-lg-25">
            <input type="text" id="table-search" class="form-control py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Search by name, cuisine, or allergies...">
        </div>

        <div class="ms-auto">
            <a class="btn btn-success btn" href="<?php echo site_url('Orderportal/Configfoodmenu/manage_menu_option'); ?>">
                <i class="ri-add-line align-bottom me-1"></i> Add New item Option
            </a>
        </div>
    </div>
</div>


                            <div class="card-body">
                                
                                <!-- Table -->
                                <div class="table-responsive table-card">
                                    <table class="table align-middle" id="menuOptionTable">
                                        <thead class="table-dark text-white">
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Cuisine Type</th>
                                                <th>Nutrition Values</th>
                                                <th>Select Allergies</th>
                                                <th><i class="fa-solid fa-star text-warning"></i> Type</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($menu_options as $option): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($option['menu_option_name']); ?></td>
                                                    <td><?php 
                                                        // Use cuisineValues (multi-select) if available, otherwise fallback to cuisine_name (single select)
                                                        $cuisineDisplay = '';
                                                        if (!empty($option['cuisineValues'])) {
                                                            $cuisineDisplay = getCuisineNames($option['cuisineValues'], $cuisines);
                                                        }
                                                        // Fallback to old single cuisine field if cuisineValues is empty
                                                        if (empty($cuisineDisplay) && !empty($option['cuisine_name'])) {
                                                            $cuisineDisplay = $option['cuisine_name'];
                                                        }
                                                        echo htmlspecialchars($cuisineDisplay); 
                                                    ?></td>
                                                    <td><span class="badge bg-success"><?php echo htmlspecialchars($option['nutritionValues']); ?></span></td>
                                                    <td><?php echo htmlspecialchars(getAllergenNames($option['allergenValues'], $allergies)); ?></td>
                                                    <td>
                                                        <?php if (isset($option['is_special_item']) && $option['is_special_item'] == 1): ?>
                                                            <span class="badge" style="background: #ff8c00; color: white; font-size: 11px;">
                                                                <i class="fa-solid fa-star"></i> SPECIAL
                                                            </span>
                                                            <br><small class="text-muted" style="font-size: 9px;">3+ allergies only</small>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary" style="font-size: 11px;">
                                                                <i class="fa-solid fa-utensils"></i> REGULAR
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="<?php echo site_url('Orderportal/Configfoodmenu/manage_menu_option/' . $option['id']); ?>" class="btn btn btn-secondary">
                                                                <i class="ri-edit-2-line align-middle me-1"></i>View/Edit
                                                            </a>
                                                            <a href="<?php echo site_url('Orderportal/Configfoodmenu/delete_menu_option/' . $option['id']); ?>" class="btn btn btn-danger" onclick="return confirm('Are you sure?')">
                                                                <i class="ri-delete-bin-line align-middle me-1"></i> Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($menu_options)): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No menu options found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality for the menu options table
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('table-search');
    const table = document.getElementById('menuOptionTable');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase().trim();

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const cuisine = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const allergies = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (name.includes(filter) || cuisine.includes(filter) || allergies.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update "No menu options found" message visibility
        const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none').length;
        const noResultsRow = table.querySelector('tbody tr td[colspan="6"]');
        if (noResultsRow) {
            noResultsRow.parentElement.style.display = visibleRows === 0 && rows.length > 0 ? '' : 'none';
        }
    });
});
</script>