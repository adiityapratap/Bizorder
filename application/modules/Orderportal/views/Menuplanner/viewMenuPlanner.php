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
?>
<div class="main-content">
     <style>
    .dropdown-menu {
      max-height: 300px;
      overflow-y: auto;
    }
    .dropdown-menu label {
      width: 100%;
      padding: 0.25rem 1.5rem;
      cursor: pointer;
    }
    /* Tooltip styles for info and allergy icons */
    .menu-icon-wrapper {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 6px;
        position: relative;
    }
    .menu-info-icon, .menu-allergy-icon {
        position: relative;
        cursor: help;
        font-size: 14px;
        transition: all 0.2s ease;
        display: inline-block;
    }
    .menu-info-icon {
        color: #3b82f6; /* Blue */
    }
    .menu-info-icon:hover {
        color: #1d4ed8;
        transform: scale(1.1);
    }
    .menu-allergy-icon {
        color: #ef4444; /* Red */
        animation: pulse-warning 2s ease-in-out infinite;
    }
    .menu-allergy-icon:hover {
        color: #dc2626;
        transform: scale(1.15);
    }
    @keyframes pulse-warning {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .menu-tooltip {
        position: absolute;
        bottom: 100%;
        right: 0;
        transform: translateY(-8px);
        background-color: #1f2937 !important;
        color: #ffffff !important;
        padding: 10px 14px !important;
        border-radius: 8px;
        font-size: 13px !important;
        font-weight: 500;
        line-height: 1.5;
        min-width: 200px;
        max-width: 300px;
        white-space: normal;
        word-wrap: break-word;
        z-index: 9999 !important;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
        pointer-events: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), 0 6px 12px rgba(0, 0, 0, 0.3);
        text-align: left;
    }
    .menu-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        right: 15px;
        border: 7px solid transparent;
        border-top-color: #1f2937;
    }
    .menu-info-icon:hover .menu-tooltip,
    .menu-allergy-icon:hover .menu-tooltip {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(-12px);
    }
    .allergy-tooltip {
        min-width: 220px;
        max-width: 300px;
        line-height: 1.6;
        background-color: #991b1b !important;
        border: 2px solid #fbbf24;
    }
    .allergy-tooltip::after {
        border-top-color: #991b1b !important;
        right: 15px;
    }
    .allergy-tooltip strong {
        display: block;
        margin-bottom: 6px;
        color: #fbbf24 !important;
        font-size: 14px !important;
        font-weight: 700 !important;
    }
  </style>
<div class="page-content">
                <div class="container-fluid">
                <div class="row">
                 <?php if($this->session->userdata('role_id') == 3) { ?>
                     <div class="alert alert-info" role="alert">
                         <i class="ri-information-line me-2"></i>
                         <strong>View Only Mode:</strong> You are viewing this menu planner in read-only mode. You cannot make any changes.
                     </div>
                 <?php } else { ?>
                     <small class="text-danger fw-semibold"><i>* Once the menu is published, no further changes can be made. Please delete and add another one if any edits needs to be made to the menu.</i></small>
                 <?php } ?>           
           <!--form start-->
           
           
           
            <div id="menu-planner-container" class="max-w-6xl mx-auto px-4 py-6">
        <form id="menuPlannerForm" action="https://bizorder.com.au/Orderportal/Menuplanner/saveDailyMenuPlanner" method="post">
       
        <input type="hidden" id="menuPlannerId" value="<?php echo (isset($menuPlannerId) ? $menuPlannerId : ''); ?>">
        <input type="hidden" id="menuPlannerRecordId" value="<?php echo (isset($menuPlannerRecordId) ? $menuPlannerRecordId : ''); ?>">
        <input type="hidden" id="isWeeklyMenuPlanner" value="<?php echo (isset($isWeeklyMenuPlanner) ? $isWeeklyMenuPlanner : false); ?>">
        
       <!-- Mobile-First Responsive Header -->
       <div class="row g-3 mb-4 align-items-center">
           <!-- Title Section -->
           <div class="col-12 col-lg-auto">
               <h2 class="text-xl font-bold text-gray-800 mb-0">Daily Menu Plan</h2>
           </div>
           
           <!-- Controls Section -->
           <div class="col-12 col-lg">
               <div class="row g-2 align-items-center justify-content-lg-end">
                  <!-- Date Picker -->
                  <div class="col-12 col-sm-6 col-md-4 col-lg-auto">
                      <input type="text" name="date" id="menuPlannerDate"
                             class="form-control"
                             placeholder="Select date"
                             data-date-format="d-m-Y" 
                             data-provider="flatpickr" 
                             data-minDate="today"
                             readonly 
                             value="<?php 
                             // 🔒 CRITICAL FIX: Format date without timezone conversion
                             // $selectedDate is already in Y-m-d format from database
                             // Don't use strtotime() which interprets dates in server timezone!
                             if (isset($selectedDate) && !empty($selectedDate)) {
                                 // Parse date in Australia/Sydney timezone to prevent conversion
                                 $timezone = new DateTimeZone('Australia/Sydney');
                                 $dateObj = DateTime::createFromFormat('Y-m-d', $selectedDate, $timezone);
                                 if ($dateObj) {
                                     echo $dateObj->format('d-m-Y');
                                 } else {
                                     // Fallback: direct format conversion (safe since it's already Y-m-d)
                                     $parts = explode('-', $selectedDate);
                                     if (count($parts) == 3) {
                                         echo $parts[2] . '-' . $parts[1] . '-' . $parts[0]; // d-m-Y
                                     } else {
                                         echo '';
                                     }
                                 }
                             } else {
                                 echo '';
                             }
                             ?>"
                             <?php echo ($this->session->userdata('role_id') == 3) ? 'disabled style="background-color: #e9ecef; cursor: not-allowed;"' : ''; ?>>
                  </div>

                   <!-- Hidden Floor Selector (All Floors by default) -->
                   <input type="hidden" id="floor-selector" name="department_id" value="0">

                   <!-- Action Buttons -->
                   <div class="col-12 col-md-4 col-lg-auto">
                       <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-end">
                           <!-- Back Button -->
                           <a href="<?= base_url('Orderportal/Menuplanner/list'); ?>" class="btn btn-secondary">
                               <i class="ri-arrow-left-line align-bottom me-1"></i>Back
                           </a>
                           
                          <?php $isChecked = ''; ?>
                          
                          <!-- Save / Update / Published - HIDE FOR NURSES -->
                          <?php if($this->session->userdata('role_id') != 3) { 
                              // Only show Save/Publish buttons for non-nurse roles
                          ?>
                              <?php if(isset($isPublished) && !$isPublished) { ?>
                                  <?php if(isset($menuPlannerId) && $menuPlannerId !='') { ?>
                                      <button id="saveBtn" class="btn btn-success" onclick="save(this,'Save')">
                                          <i class="ri-save-line align-bottom me-1"></i>Update
                                      </button>
                                  <?php } else { $isChecked = 'checked'; ?>
                                      <button id="saveBtn" class="btn btn-success" onclick="save(this,'Save')" <?php echo !isset($selectedDate) || empty($selectedDate) ? 'disabled' : ''; ?>>
                                          <i class="ri-save-line align-bottom me-1"></i>Save
                                      </button>
                                  <?php } ?>
                              <?php } else { ?>
                                  <button class="btn btn-success" disabled>
                                      <i class="ri-check-line align-bottom me-1"></i>Published
                                  </button>
                              <?php } ?>

                              <!-- Publish Button -->
                              <?php if(isset($isPublished) && !$isPublished) { ?>
                                  <button id="publishBtn" class="btn btn-primary" onclick="save(this,'Publish')" <?php echo (!isset($menuPlannerId) || empty($menuPlannerId)) && (!isset($selectedDate) || empty($selectedDate)) ? 'disabled' : ''; ?>>
                                      <i class="ri-send-plane-line align-bottom me-1"></i>Publish
                                  </button>
                              <?php } ?>
                          <?php } else { 
                              // For nurses, show a read-only badge
                          ?>
                              <span class="badge bg-info-subtle text-info fs-12">
                                  <i class="ri-eye-line align-bottom me-1"></i>View Only
                              </span>
                          <?php } ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>

         
    <!--// Men sections-->
   
        <input type="hidden" name="saveTypeBtn" id="saveTypeBtn">
    <!-- Menu sections -->
                        <?php if (isset($menuLists) && !empty($menuLists) && isset($categories) && !empty($categories)) { ?>
                            <div id="menu-sections" class="space-y-4"> <!-- Reduced space-y-8 to space-y-4 -->
                                <?php foreach ($categories as $category) { ?>
                                    <div id="<?php echo htmlspecialchars($category['name']); ?>-section" class="bg-white rounded-lg shadow-sm overflow-hidden mb-3"> <!-- Reduced mb-5 to mb-3 -->
                                        <div class="bg-header text-white px-5 py-2 rounded-t-lg flex justify-between items-center"> <!-- Reduced padding -->
                                            <span class="font-semibold text-sm text-white text-base	"><?php echo htmlspecialchars($category['name']); ?></span> <!-- Reduced text-lg to text-base -->
                                        </div>
                                        <div class="p-4"> <!-- Reduced p-6 to p-4 -->
                                            <?php
                                            $hasMenus = false;
                                            foreach ($menuLists as $menu) {
                                                if (in_array($category['id'], $menu['category_ids'] ?? [])) {
                                                    $hasMenus = true;
                                                    $menuId = $menu['menu_id'];
                                                    $categoryId = $category['id'];
                                            ?>
                                                    <div class="mb-3"> <!-- Reduced mb-6 to mb-3 -->
                                                        <h5 class="text-gray-800 font-semibold text-sm mb-2"><?php echo htmlspecialchars($menu['menu_name']); ?></h5> <!-- Reduced text size, mb-3 to mb-2 -->
                                                        <?php if (isset($menu['menu_options']) && !empty($menu['menu_options'])) { ?>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"> <!-- Reduced gap-3 to gap-2 -->
                                                                <?php foreach ($menu['menu_options'] as $menu_option) { ?>
                                                                    <div class="bg-gray-50 hover:bg-gray-100 transition-colors rounded-md p-2 flex items-center"> <!-- Reduced p-3 to p-2 -->
                                                                        <?php
                                                                        if(isset($savedMenuWithOptions[$categoryId][$menuId]) && !empty(isset($savedMenuWithOptions[$categoryId][$menuId]))){
                                                                            $isChecked = in_array($menu_option['option_id'], $savedMenuWithOptions[$categoryId][$menuId]) ? 'checked' : $defaultAllChecked;
                                                                        }
                                                                        ?>
                                                                        <input type="checkbox" id="<?php echo $categoryId ?>_<?php echo $menu_option['option_id']; ?>" name="optionMenus[<?php echo $categoryId ?>][<?php echo $menuId; ?>][]" value="<?php echo $menu_option['option_id']; ?>" class="menu-option-checkbox h-4 w-4 text-chef-purple rounded border-gray-300 focus:ring-chef-purple mr-2" <?php echo $isChecked; ?> <?php echo ($this->session->userdata('role_id') == 3) ? 'disabled' : ''; ?>> <!-- Disabled for nurses -->
                                                                        <label for="<?php echo $categoryId ?>_<?php echo $menu_option['option_id']; ?>" class="text-gray-700 <?php echo ($this->session->userdata('role_id') == 3) ? 'cursor-not-allowed opacity-60' : 'cursor-pointer'; ?> text-sm"><?php echo htmlspecialchars($menu_option['menu_option_name']); ?></label>
                                                                        
                                                                        <!-- Info and Allergy Icons -->
                                                                        <span class="menu-icon-wrapper">
                                                                            <?php if (!empty($menu_option['menu_option_description'])): ?>
                                                                                <span class="menu-info-icon">
                                                                                    <i class="ri-information-line"></i>
                                                                                    <span class="menu-tooltip"><?php echo htmlspecialchars($menu_option['menu_option_description']); ?></span>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                            
                                                                            <?php 
                                                                            $allergenNames = getAllergenNames($menu_option['allergenValues'], $allergies);
                                                                            if (!empty($allergenNames)): 
                                                                            ?>
                                                                                <span class="menu-allergy-icon">
                                                                                    <i class="ri-alert-line"></i>
                                                                                    <span class="menu-tooltip allergy-tooltip">
                                                                                        <strong>⚠️ Contains Allergens:</strong>
                                                                                        <?php echo htmlspecialchars($allergenNames); ?>
                                                                                    </span>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <?php
                                                            if(isset($savedMenuWithoutOptions[$categoryId]) && !empty(isset($savedMenuWithoutOptions[$categoryId]))){
                                                                $isChecked = in_array($menuId, $savedMenuWithoutOptions[$categoryId]) ? 'checked' : $defaultAllChecked;
                                                            }
                                                            ?>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"> <!-- Reduced gap-3 to gap-2 -->
                                                                <div class="bg-gray-50 hover:bg-gray-100 transition-colors rounded-md p-2 flex items-center"> <!-- Reduced p-3 to p-2 -->
                                                                    <input type="checkbox" id="<?php echo $categoryId ?>_<?php echo $menuId; ?>" name="noOptionMenus[<?php echo $categoryId ?>][]" value="<?php echo $menuId; ?>" class="h-4 w-4 text-chef-purple rounded border-gray-300 focus:ring-chef-purple mr-2" <?php echo $isChecked; ?> <?php echo ($this->session->userdata('role_id') == 3) ? 'disabled' : ''; ?>> <!-- Disabled for nurses -->
                                                                    <label for="<?php echo $categoryId ?>_<?php echo $menuId; ?>" class="text-gray-700 <?php echo ($this->session->userdata('role_id') == 3) ? 'cursor-not-allowed opacity-60' : 'cursor-pointer'; ?> text-sm"><?php echo htmlspecialchars($menu['menu_name']); ?></label>
                                                                    
                                                                    <!-- Info Icon for menu description -->
                                                                    <?php if (!empty($menu['description'])): ?>
                                                                        <span class="menu-icon-wrapper">
                                                                            <span class="menu-info-icon">
                                                                                <i class="ri-information-line"></i>
                                                                                <span class="menu-tooltip"><?php echo htmlspecialchars($menu['description']); ?></span>
                                                                            </span>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            if (!$hasMenus) {
                                            ?>
                                                <div class="text-center text-gray-500 text-sm">No menus in this category</div> <!-- Added text-sm -->
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="text-center text-gray-500 text-sm">No menus available</div> <!-- Added text-sm -->
                        <?php } ?>
    


</form>
         </div>
         <!--form end-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
          
        </div>
        
                            
                                            
      
          <style>
/* Fix checkbox and label alignment issues */
.flex.items-center {
    display: flex !important;
    align-items: center !important;
}

.flex.items-center input[type="checkbox"] {
    margin-right: 8px !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    vertical-align: middle !important;
    flex-shrink: 0 !important;
}

.flex.items-center label {
    margin: 0 !important;
    line-height: 1.2 !important;
    vertical-align: middle !important;
    display: inline-block !important;
    flex: 1 !important;
}

/* Ensure checkbox size is consistent */
input[type="checkbox"].h-4 {
    width: 16px !important;
    height: 16px !important;
    min-width: 16px !important;
    min-height: 16px !important;
}

/* Fix any text visibility issues */
.text-gray-700 {
    color: #374151 !important;
    opacity: 1 !important;
}

/* Mobile-First Responsive Improvements */
@media (max-width: 767.98px) {
    .text-xl {
        font-size: 1.25rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .btn {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        white-space: nowrap;
    }
    
    .form-control, .form-select {
        font-size: 0.875rem;
    }
    
    /* Ensure buttons don't overflow on very small screens */
    .d-flex.flex-wrap.gap-2 {
        justify-content: center !important;
    }
    
    .d-flex.flex-wrap.gap-2 .btn {
        flex: 1 1 auto;
        min-width: 80px;
        max-width: 120px;
        text-align: center;
    }
}

@media (max-width: 575.98px) {
    /* Stack buttons vertically on very small screens */
    .d-flex.flex-wrap.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.flex-wrap.gap-2 .btn {
        flex: none;
        width: 100%;
        max-width: none;
    }
    
    /* Make form controls full width on mobile */
    .form-control, .form-select {
        width: 100% !important;
    }
}

/* Ensure proper spacing and alignment */
.row.g-3 > * {
    padding-right: calc(var(--bs-gutter-x) * 0.5);
    padding-left: calc(var(--bs-gutter-x) * 0.5);
}

/* Better button group spacing */
.gap-2 {
    gap: 0.5rem !important;
}

/* Floor selector button styling */
.btn.btn-outline-secondary.disabled {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
    font-weight: 500;
    opacity: 1;
}

.btn.btn-outline-secondary.disabled i {
    opacity: 0.7;
}

@media (max-width: 575.98px) {
    .btn.btn-outline-secondary.disabled {
        width: 100%;
        justify-content: center;
    }
}
</style>

          <script>
document.addEventListener('DOMContentLoaded', function () {
    // 🔒 CRITICAL FIX: Prevent accidental form submission via Enter key or natural form submit
    // This prevents published menus from being accidentally updated
    const menuPlannerForm = document.getElementById('menuPlannerForm');
    if (menuPlannerForm) {
        menuPlannerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission
            e.stopPropagation();
            
            // Only allow submission via the save() function (AJAX)
            // This prevents accidental submissions via Enter key
            const isPublished = <?php echo (isset($isPublished) && $isPublished) ? 'true' : 'false'; ?>;
            if (isPublished) {
                Swal.fire({
                    title: 'Error!',
                    text: 'This menu has been published and cannot be modified.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            
            // If form is submitted naturally (not via save button), show warning
            console.warn('Form submission prevented - use Save/Update button instead');
            Swal.fire({
                title: 'Warning!',
                text: 'Please use the Save or Update button to save changes.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        });
        
        // Also prevent Enter key submission in all form fields
        const formInputs = menuPlannerForm.querySelectorAll('input, textarea, select');
        formInputs.forEach(function(input) {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.type !== 'submit' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    e.stopPropagation();
                    // Don't submit - user must click Save button
                    return false;
                }
            });
        });
    }
    
    const menuPlannerDatePicker = flatpickr('#menuPlannerDate', {
        minDate: "today",  // Restrict past dates for menu planning
        onChange: function(selectedDates, dateStr, instance) {
            // Only enable/disable for new menus (when no menuPlannerId exists)
            const isNewMenu = !<?php echo isset($menuPlannerId) && !empty($menuPlannerId) ? 'true' : 'false'; ?>;
            if (isNewMenu) {
                const saveBtn = document.getElementById('saveBtn');
                const publishBtn = document.getElementById('publishBtn');
                
                if (dateStr && dateStr.trim() !== '') {
                    // Date selected - enable buttons
                    if (saveBtn) saveBtn.disabled = false;
                    if (publishBtn) publishBtn.disabled = false;
                } else {
                    // No date - disable buttons
                    if (saveBtn) saveBtn.disabled = true;
                    if (publishBtn) publishBtn.disabled = true;
                }
            }
        }
    });
    
    // Debug: Check for empty labels and fix alignment
    const checkboxContainers = document.querySelectorAll('.flex.items-center');
    checkboxContainers.forEach(function(container) {
        const label = container.querySelector('label');
        if (label && (!label.textContent || label.textContent.trim() === '')) {
            console.warn('Found empty label:', label);
            label.textContent = 'Missing Menu Name';
            label.style.color = '#ef4444'; // Red color to highlight issue
        }
    });
});


  function save(obj, saveType = 'Save') {
    // 🔒 CRITICAL PROTECTION: Check if menu is published before allowing save
    const isPublished = <?php echo (isset($isPublished) && $isPublished) ? 'true' : 'false'; ?>;
    if (isPublished) {
        Swal.fire({
            title: 'Error!',
            text: 'This menu has been published and cannot be modified. Please delete it first if you need to make changes.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    // Validate that at least one menu is selected
    let selectedMenus = $('input[type="checkbox"]:checked').length;
    if (selectedMenus === 0) {
        Swal.fire({
            title: 'Warning!',
            text: 'Please select at least one menu item before saving.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    let originalText = $(obj).html();
    $(obj).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...').prop('disabled', true);

    let dept = $("#floor-selector").val();
    let menuPlannerDate = $("#menuPlannerDate").val();
    let isWeeklyMenuPlanner = $("#isWeeklyMenuPlanner").val();
    let saveOrPublish = saveType === 'Publish' ? 2 : 1;
    let menuPlannerId = $("#menuPlannerId").val();
    let menuPlannerRecordId = $("#menuPlannerRecordId").val();

    // Collect form data
    let formData = $("#menuPlannerForm").serialize();
    formData += '&saveTypeBtn=' + saveOrPublish;
    
    // Add the menuPlannerRecordId if it exists (for proper updates)
    if (menuPlannerRecordId && menuPlannerRecordId !== '') {
        formData += '&menuPlannerRecordId=' + menuPlannerRecordId;
    }

    $.ajax({
        url: '<?= base_url('Orderportal/Menuplanner/saveDailyMenuPlanner'); ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    // Navigate to Menuplanners List page
                    window.location.href = '<?= base_url('Orderportal/Menuplanner/list'); ?>';
                });
            } else {
                // Show error message
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            // Show generic error message
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while saving the menu. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
        complete: function() {
            // Restore button state
            $(obj).html(originalText).prop('disabled', false);
        }
    });
}








          </script>
         