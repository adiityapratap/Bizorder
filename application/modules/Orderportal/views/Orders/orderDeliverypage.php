<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}

/* Custom accordion styles for better appearance */
.accordion-item {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    margin-bottom: 1rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.accordion-button {
    background-color: #ffffff;
    border: 1px solid #e5e7eb;
    padding: 1rem 1.25rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    position: relative;
}

.accordion-button:not(.collapsed) {
    background-color: #f0f9ff;
    border-color: #0ea5e9;
    color: #0c4a6e;
    box-shadow: none;
}

.accordion-button:hover {
    background-color: #f9fafb;
    color: #374151;
}

.accordion-button:not(.collapsed):hover {
    background-color: #e0f2fe;
    color: #0c4a6e;
}

/* Mark Completed switch styling - positioned at far right */
.mark-completed-wrapper {
    position: absolute;
    right: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    z-index: 10;
}

.mark-completed-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    margin: 0;
    white-space: nowrap;
}

.accordion-button:not(.collapsed) .mark-completed-label {
    color: #0c4a6e;
}

/* Custom switch styling */
.custom-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.custom-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #e5e7eb;
    transition: .3s;
    border-radius: 24px;
    border: 1px solid #d1d5db;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

input:checked + .switch-slider {
    background-color: #0ea5e9;
    border-color: #0284c7;
}

input:checked + .switch-slider:before {
    transform: translateX(26px);
}

.accordion-button:focus {
    box-shadow: none;
    border-color: transparent;
}

.accordion-body {
    padding: 1.25rem;
    background-color: #fff;
}

.table-responsive {
    border-radius: 0.35rem;
    overflow: hidden;
}

.btn-deliver {
    background-color: #0ea5e9;
    border-color: #0ea5e9;
    color: white !important;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-deliver:hover {
    background-color: #0284c7;
    border-color: #0284c7;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
}

.btn-deliver i {
    color: white !important;
}

.btn-deliver:hover i {
    color: white !important;
}

.btn-deliver .mdi {
    color: white !important;
}

.btn-deliver:hover .mdi {
    color: white !important;
}

.btn-deliver .mdi-truck {
    color: white !important;
}

.btn-deliver:hover .mdi-truck {
    color: white !important;
}

.btn-deliver .mdi::before {
    color: white !important;
}

.btn-deliver:hover .mdi::before {
    color: white !important;
}

.btn-deliver:active {
    transform: translateY(0);
}

.btn-deliver:disabled {
    background-color: #9ca3af;
    border-color: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Improved table styling */
.table {
    margin-bottom: 0;
}

.table th {
    background-color: #f8fafc;
    color: #475569;
    font-weight: 600;
    border: 1px solid #e2e8f0;
    padding: 1rem 0.75rem;
    text-align: center;
    vertical-align: middle;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #e5e7eb;
    text-align: center;
    font-size: 0.875rem;
    color: #374151;
}

.table tbody tr:hover {
    background-color: #f9fafb;
}

.table tbody tr {
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:last-child {
    border-bottom: none;
}

/* Form styling */
.form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #374151;
    background-color: #ffffff;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-input:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    outline: 0;
}

.form-input::placeholder {
    color: #9ca3af;
}

/* Checkbox styling */
.form-check-input {
    margin-right: 0.5rem;
}

.form-check-label {
    font-size: 0.875rem;
    color: #374151;
    cursor: pointer;
}

/* Success button styling */
.btn-success {
    background-color: #10b981;
    border-color: #10b981;
    color: white;
    font-weight: 500;
}

/* Custom Confirmation Modal */
.confirmation-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.confirmation-modal.show {
    display: flex;
}

.confirmation-content {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.confirmation-modal.show .confirmation-content {
    transform: scale(1);
}

.confirmation-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.confirmation-icon {
    width: 48px;
    height: 48px;
    background-color: #fef3c7;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.confirmation-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.confirmation-message {
    color: #6b7280;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.confirmation-buttons {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.btn-confirm {
    background-color: #0ea5e9;
    border-color: #0ea5e9;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 0.375rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-confirm:hover {
    background-color: #0284c7;
}

.btn-cancel {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #374151;
    padding: 0.5rem 1.5rem;
    border-radius: 0.375rem;
    font-weight: 500;
    border: 1px solid #d1d5db;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background-color: #e5e7eb;
}

/* Accordion behavior */
.accordion-collapse {
    display: none;
}

.accordion-collapse.show {
    display: block !important;
}

/* Ensure proper spacing */
.accordion-item {
    overflow: hidden;
}

.accordion-body {
    display: block;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
        <?php 
        // Initialize packagedItemsData if not set
        if (!isset($packagedItemsData)) {
            $packagedItemsData = [];
        }
        
        // Get floor name for print labels
        $department_name = fetchDepartmentNameFromId($this->tenantDb, $deptId);
        $floor_name = $department_name; // Store for print function
        ?>
        <h4 class="text-black"><?php echo $department_name; ?></h4>
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card">
                   <div class="card-header align-items-center d-flex justify-content-between">
                      <div class="d-flex align-items-center gap-3">
                          <h4 class="card-title mb-0 text-dark" style="font-size: 1.25rem; font-weight: 600;">Order Package Information</h4>
                          
                          <!-- 🆕 DATE SELECTOR: Today/Tomorrow Toggle -->
                          <div class="btn-group" role="group" aria-label="Date selector">
                              <button type="button" 
                                      class="btn btn-sm <?php echo $isToday ? 'btn-primary' : 'btn-outline-primary'; ?>" 
                                      onclick="changeDateView('today')">
                                  <i class="ri-calendar-check-line"></i> Today
                              </button>
                              <button type="button" 
                                      class="btn btn-sm <?php echo $isTomorrow ? 'btn-primary' : 'btn-outline-primary'; ?>" 
                                      onclick="changeDateView('tomorrow')">
                                  <i class="ri-calendar-line"></i> Tomorrow
                              </button>
                          </div>
                          
                          <?php if ($isTomorrow): ?>
                              <span class="badge bg-warning text-dark fs-6" style="padding: 8px 12px;">
                                  <i class="ri-lock-line"></i> Read-Only Mode
                              </span>
                          <?php endif; ?>
                          
                          <span class="text-dark fw-bold" style="font-size: 1rem;">
                              (<?php echo date('d-m-Y', strtotime($date)); ?>)
                          </span>
                      </div>
                      <div class="d-flex gap-2">
                          <button onclick="bulkPrintAllLabels()" class="btn btn-primary btn-sm">
                              <i class="mdi mdi-printer-multiple me-1"></i> Bulk Print All
                          </button>
                          <a href="<?php echo base_url('Orderportal'); ?>" class="btn btn-secondary btn-sm">
                              <i class="ri-arrow-left-line me-1"></i> Back to Dashboard
                          </a>
                      </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="accordion" id="default-accordion-example">
               <?php $count = 0; if(isset($categoryListData) && !empty($categoryListData)) {  ?>
               <?php foreach($categoryListData as $categoryList){ 
                    // Check if this category is already completed
                    $isCategoryCompleted = isset($alreadyDeliveredCategory) && !empty($alreadyDeliveredCategory) && in_array($categoryList['id'], $alreadyDeliveredCategory);
               ?>
                <div class="accordion-item shadow">
                                                <h2 class="accordion-header text-dark" id="headingOne">
                                                    <button class="accordion-button <?php echo $isCategoryCompleted ? '' : ''; ?>" type="button" data-bs-target="#collapse<?php echo $categoryList['id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $categoryList['id'] ?>" style="<?php echo $isCategoryCompleted ? 'background-color: #f0fdf4; border-color: #10b981;' : ''; ?>">
                                         <strong><?php echo $categoryList['name'] ?></strong> 
                                         <div class="mark-completed-wrapper" onclick="event.stopPropagation();">
                                            <?php if($isCategoryCompleted): ?>
                                                <span class="badge bg-success" style="font-size: 14px; padding: 8px 16px; font-weight: 600;">
                                                    <i class="mdi mdi-check-circle me-1"></i> COMPLETED
                                                </span>
                                            <?php else: ?>
                                                <label class="mark-completed-label">Mark Completed</label>
                                                <div class="custom-switch" onclick="event.stopPropagation();">
                                                    <input type="checkbox" id="switch-<?php echo $categoryList['id']; ?>" onclick="event.stopPropagation(); markThisCategoryPackaged(this,<?php echo $orderId; ?>,<?php echo $categoryList['id'] ?>);">
                                                    <span class="switch-slider" onclick="event.stopPropagation(); document.getElementById('switch-<?php echo $categoryList['id']; ?>').click();"></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                          </button>
                                                </h2>
                 <div id="collapse<?php echo $categoryList['id'] ?>" class="accordion-collapse show" aria-labelledby="headingOne">
                  <div class="accordion-body">
                   <table class="table table-responsive table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Suite No.</th>
                            <th>Food Ordered</th>
                            <th>Order Notes</th>
                            <!-- <th> Notes</th> -->
                            <th>Temperature</th>
                            <th style="width: 200px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     

                         <?php if(isset($bedLists) && !empty($bedLists)) {  ?>
                        
                        <?php foreach($bedLists as $bedList){ ?>
                        <?php  $nameIndex = $bedList['id'] . '_' . $categoryList['id'];  ?>
                        <tr class="ordertableRow">
                         
                            <td>
                                Suite <?php echo $bedList['bed_no']; ?>
                                <?php 
                                // Show Room Service status
                                // Orders are placed today for tomorrow's delivery, so check tomorrow's date
                                $rsQuery = $this->tenantDb->query(
                                    "SELECT is_done FROM room_service_status WHERE suite_id = ? AND order_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)",
                                    [$bedList['id']]
                                );
                                $rsStatus = $rsQuery->row();
                                if ($rsStatus && $rsStatus->is_done): 
                                ?>
                                    <span class="badge bg-success ms-2 fw-bold" title="Room Service Completed" style="background-color: #10b981 !important; font-size: 0.85rem; padding: 0.4rem 0.6rem;">
                                        <i class="fas fa-check-circle"></i> RS DONE
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($bedList['patient_name'])): ?>
                                    <br><span style="color: #2563eb; font-weight: bold; font-size: 0.85rem;">👤 Name:</span> <span style="color: #374151; font-size: 0.85rem;"><?php echo htmlspecialchars($bedList['patient_name']); ?></span>
                                <?php endif; ?>
                                <?php 
                                // Display Patient Allergies (convert IDs to names)
                                $allergenNamesForDisplay = [];
                                if (!empty($bedList['patient_allergies']) && $bedList['patient_allergies'] !== 'null' && $bedList['patient_allergies'] !== '[]') {
                                    $allergenIds = json_decode($bedList['patient_allergies'], true);
                                    if (is_array($allergenIds) && !empty($allergenIds) && isset($allergensData)) {
                                        foreach ($allergenIds as $allergenId) {
                                            foreach ($allergensData as $allergen) {
                                                if ($allergen['id'] == $allergenId) {
                                                    $allergenNamesForDisplay[] = $allergen['name'];
                                                    break;
                                                }
                                            }
                                        }
                                        if (!empty($allergenNamesForDisplay)) {
                                            echo '<br><span style="color: #dc2626; font-weight: bold; font-size: 0.85rem;">⚠️ Allergies:</span> <span style="color: #374151; font-size: 0.85rem;">' . htmlspecialchars(implode(', ', $allergenNamesForDisplay)) . '</span>';
                                        }
                                    }
                                }
                                
                                // Display Patient Dietary Preferences (convert IDs to names)
                                $dietaryNamesForDisplay = [];
                                if (!empty($bedList['patient_dietary_preferences']) && $bedList['patient_dietary_preferences'] !== 'null' && $bedList['patient_dietary_preferences'] !== '[]') {
                                    $dietaryIds = json_decode($bedList['patient_dietary_preferences'], true);
                                    if (is_array($dietaryIds) && !empty($dietaryIds) && isset($cuisineData)) {
                                        foreach ($dietaryIds as $dietaryId) {
                                            foreach ($cuisineData as $cuisine) {
                                                if ($cuisine['id'] == $dietaryId) {
                                                    $dietaryNamesForDisplay[] = $cuisine['name'];
                                                    break;
                                                }
                                            }
                                        }
                                        if (!empty($dietaryNamesForDisplay)) {
                                            echo '<br><span style="color: #16a34a; font-weight: bold; font-size: 0.85rem;">🍽️ Dietary:</span> <span style="color: #374151; font-size: 0.85rem;">' . htmlspecialchars(implode(', ', $dietaryNamesForDisplay)) . '</span>';
                                        }
                                    }
                                }
                                
                                // Display Patient Special Instructions
                                if (!empty($bedList['patient_instructions']) && trim($bedList['patient_instructions']) !== '') {
                                    echo '<br><span style="color: #7c3aed; font-weight: bold; font-size: 0.85rem;">📋 Special Instructions:</span> <span style="color: #374151; font-size: 0.85rem;">' . htmlspecialchars($bedList['patient_instructions']) . '</span>';
                                }
                                ?>
                                <?php echo !empty($bedList['ward_no']) ? '<br>Ward No: ' . $bedList['ward_no'] : ''; ?>
                            </td> 
                            <td>
                            <?php 
                            // Track if this suite has any items ordered
                            $hasItems = false;
                            foreach($menuLists as $menu){ ?>
                            <?php 
                            // FIXED: For delivery page, show menus that were ORDERED, not just published
                            // Check if this menu was ordered by looking in patientOrderData
                            $menuWasOrdered = false;
                            $menuId = $menu['menu_id'] ?? $menu['id']; // Handle both field name formats
                            if (isset($patientOrderData[$nameIndex]) && in_array($menuId, $patientOrderData[$nameIndex])) {
                                $menuWasOrdered = true;
                            }
                            
                            // FIXED: Check if current category is in menu's category_ids (array)
                            $categoryMatch = false;
                            if (!empty($menu['category_ids']) && is_array($menu['category_ids'])) {
                                $categoryMatch = in_array($categoryList['id'], $menu['category_ids']);
                            }
                            ?>
                            <?php if($categoryMatch && ($menuWasOrdered || in_array($menuId, $savedMenus))) {  ?>
                            
                      <?php
                      if(isset($patientOrderData) && !empty($patientOrderData)){
                      // FIXED: Add safety check for nameIndex existence
                      $currentPatientOrderData = isset($patientOrderData[$nameIndex]) ? $patientOrderData[$nameIndex] : [];
                      if (!empty($currentPatientOrderData) && in_array($menuId, $currentPatientOrderData)){ 
                      $hasItems = true; // Mark that this suite has items
                      ?>
                 <?php
                 
                  $target_bed_id =    $bedList['id'];      $target_menu_id = $menuId;
                    // Filter and extract menu_option_name
                  $option_names = array_map(function ($item) {
                  return $item['menu_option_name'];
                  }, array_filter($orderMenuOptions, function ($item) use ($target_bed_id, $target_menu_id) {
                   return $item['bed_id'] == $target_bed_id && $item['menu_id'] == $target_menu_id;
                  }));

                 $commaSeparatedOptions = implode(', ', $option_names);
                 
                 ?>     
                 <div class="form-check form-check-success fs-12">
                 <input class="form-check-input " readonly type="checkbox" checked id="menu_<?php echo $bedList['id'].''.$menuId; ?>" value="<?php echo $menuId; ?>" name="<?php echo $nameIndex . '[]'; ?>" 
                 data-allergens="<?php 
                    // Get allergens for this menu's options
                    $menuAllergens = [];
                    if (isset($orderMenuOptions) && !empty($orderMenuOptions)) {
                        foreach ($orderMenuOptions as $opt) {
                            if ($opt['bed_id'] == $bedList['id'] && $opt['menu_id'] == $menuId && !empty($opt['allergenValues'])) {
                                $allergenIds = json_decode($opt['allergenValues'], true);
                                if (is_array($allergenIds) && !empty($allergenIds) && isset($allergensData)) {
                                    foreach ($allergenIds as $allergenId) {
                                        foreach ($allergensData as $allergen) {
                                            if ($allergen['id'] == $allergenId && !in_array($allergen['name'], $menuAllergens)) {
                                                $menuAllergens[] = $allergen['name'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo htmlspecialchars(implode(', ', $menuAllergens));
                 ?>"
                 data-item-comment="<?php 
                    // Get item-specific comment for this menu option
                    $itemComment = '';
                    if (isset($orderMenuOptions) && !empty($orderMenuOptions)) {
                        foreach ($orderMenuOptions as $opt) {
                            if ($opt['bed_id'] == $bedList['id'] && $opt['menu_id'] == $menuId && !empty($opt['item_comment'])) {
                                $itemComment = $opt['item_comment'];
                                break;
                            }
                        }
                    }
                    echo htmlspecialchars($itemComment);
                 ?>">
                 <label class="form-check-label" for="menu_<?php echo $bedList['id'].''.$menuId; ?>"> <?php echo $menu['menu_name'] ?? $menu['name']; ?></label>
                  </div>
                   <small class="text-secondary"><?php echo $commaSeparatedOptions ?></small>        
                <?php  } }  ?>      
                <?php } }  ?>
                  </td>

                 
                  <?php 
                    // Check if this item is packaged (individual item OR entire category is completed)
                    $isPackaged = (isset($alreadyDeliveredCategoryAndPatient) && !empty($alreadyDeliveredCategoryAndPatient) && in_array($nameIndex, $alreadyDeliveredCategoryAndPatient)) || $isCategoryCompleted;
                    $savedNotes = '';
                    $savedTemp = '';
                    if ($isPackaged && isset($packagedItemsData[$nameIndex])) {
                        $savedNotes = $packagedItemsData[$nameIndex]['notes'];
                        $savedTemp = $packagedItemsData[$nameIndex]['temperature'];
                    }
                  ?>
                  <td><textarea class="form-input" name="note_<?php echo $bedList['id']; ?>" <?php echo $isPackaged ? 'disabled' : ''; ?>><?php echo $isPackaged ? $savedNotes : (isset($orderCommentBedWise[$bedList['id']]) ? $orderCommentBedWise[$bedList['id']] : ''); ?></textarea></td>
                  <!-- <td><?php echo (isset($bednNotes[$bedList['id']]) ? $bednNotes[$bedList['id']] : '') ?></td> -->
                  <td><input type="text" class="form-input" name="temperature_<?php echo $bedList['id']; ?>" placeholder="°C" style="width: 80px;" value="<?php echo $savedTemp; ?>" <?php echo $isPackaged ? 'disabled' : ''; ?>></td> 
                  <?php if($hasItems) { // Only show buttons if suite has items to package ?>
                  <?php if($isPackaged) {  ?>
                 <td>
                     <div class="d-flex gap-1 flex-nowrap">
                         <a class="btn btn-success btn-sm shadow-none text-nowrap"><i class="mdi mdi-package-variant me-1"></i> Packaged</a>
                         <?php 
                             // Convert allergen IDs to names for print
                             $allergenNamesForPrint = '';
                             if (!empty($bedList['patient_allergies']) && $bedList['patient_allergies'] !== 'null' && $bedList['patient_allergies'] !== '[]') {
                                 $allergenIds = json_decode($bedList['patient_allergies'], true);
                                 if (is_array($allergenIds) && !empty($allergenIds) && isset($allergensData)) {
                                     $allergenNames = [];
                                     foreach ($allergenIds as $allergenId) {
                                         foreach ($allergensData as $allergen) {
                                             if ($allergen['id'] == $allergenId) {
                                                 $allergenNames[] = $allergen['name'];
                                                 break;
                                             }
                                         }
                                     }
                                     $allergenNamesForPrint = implode(', ', $allergenNames);
                                 }
                             }
                             
                             // Convert dietary preference IDs to names for print
                             $dietaryNamesForPrint = '';
                             if (!empty($bedList['patient_dietary_preferences']) && $bedList['patient_dietary_preferences'] !== 'null' && $bedList['patient_dietary_preferences'] !== '[]') {
                                 $dietaryIds = json_decode($bedList['patient_dietary_preferences'], true);
                                 if (is_array($dietaryIds) && !empty($dietaryIds) && isset($cuisineData)) {
                                     $dietaryNames = [];
                                     foreach ($dietaryIds as $dietaryId) {
                                         foreach ($cuisineData as $cuisine) {
                                             if ($cuisine['id'] == $dietaryId) {
                                                 $dietaryNames[] = $cuisine['name'];
                                                 break;
                                             }
                                         }
                                     }
                                     $dietaryNamesForPrint = implode(', ', $dietaryNames);
                                 }
                             }
                             
                             // Get special instructions for print
                             $specialInstructionsForPrint = !empty($bedList['patient_instructions']) ? htmlspecialchars($bedList['patient_instructions'], ENT_QUOTES, 'UTF-8') : '';
                         ?>
                        <a onclick="printOrderLabel('<?php echo addslashes($bedList['bed_no']); ?>', '<?php echo addslashes($bedList['patient_name'] ?? ''); ?>', <?php echo $bedList['id']; ?>, <?php echo $categoryList['id']; ?>, '<?php echo addslashes($categoryList['name']); ?>', '<?php echo $nameIndex; ?>', '<?php echo addslashes($bedList['patient_photo_path'] ?? ''); ?>', '<?php echo addslashes($floor_name); ?>')" 
                           data-patient-allergies="<?php echo htmlspecialchars($allergenNamesForPrint, ENT_QUOTES, 'UTF-8'); ?>"
                           data-patient-dietary="<?php echo htmlspecialchars($dietaryNamesForPrint, ENT_QUOTES, 'UTF-8'); ?>"
                           data-patient-instructions="<?php echo $specialInstructionsForPrint; ?>"
                           class="btn btn-info btn-sm shadow-none text-nowrap print-label-btn" title="Print Label"><i class="mdi mdi-printer me-1"></i> Print</a>
                     </div>
                 </td> 
                  <?php }  else {  ?>
           <td>
                <div class="d-flex gap-1 flex-nowrap">
                    <a onclick="packageItem(this,<?php echo $bedList['id'] ?>,<?php echo $categoryList['id'] ?>,<?php echo $orderId; ?>)" class="btn btn-deliver btn-sm shadow-none deliveredButton text-nowrap"><i class="mdi mdi-package-variant me-1"></i> Package</a>
                    <?php 
                        // Convert allergen IDs to names for print
                        $allergenNamesForPrint = '';
                        if (!empty($bedList['patient_allergies']) && $bedList['patient_allergies'] !== 'null' && $bedList['patient_allergies'] !== '[]') {
                            $allergenIds = json_decode($bedList['patient_allergies'], true);
                            if (is_array($allergenIds) && !empty($allergenIds) && isset($allergensData)) {
                                $allergenNames = [];
                                foreach ($allergenIds as $allergenId) {
                                    foreach ($allergensData as $allergen) {
                                        if ($allergen['id'] == $allergenId) {
                                            $allergenNames[] = $allergen['name'];
                                            break;
                                        }
                                    }
                                }
                                $allergenNamesForPrint = implode(', ', $allergenNames);
                            }
                        }
                        
                        // Convert dietary preference IDs to names for print
                        $dietaryNamesForPrint = '';
                        if (!empty($bedList['patient_dietary_preferences']) && $bedList['patient_dietary_preferences'] !== 'null' && $bedList['patient_dietary_preferences'] !== '[]') {
                            $dietaryIds = json_decode($bedList['patient_dietary_preferences'], true);
                            if (is_array($dietaryIds) && !empty($dietaryIds) && isset($cuisineData)) {
                                $dietaryNames = [];
                                foreach ($dietaryIds as $dietaryId) {
                                    foreach ($cuisineData as $cuisine) {
                                        if ($cuisine['id'] == $dietaryId) {
                                            $dietaryNames[] = $cuisine['name'];
                                            break;
                                        }
                                    }
                                }
                                $dietaryNamesForPrint = implode(', ', $dietaryNames);
                            }
                        }
                        
                        // Get special instructions for print
                        $specialInstructionsForPrint = !empty($bedList['patient_instructions']) ? htmlspecialchars($bedList['patient_instructions'], ENT_QUOTES, 'UTF-8') : '';
                    ?>
                    <a onclick="printOrderLabel('<?php echo addslashes($bedList['bed_no']); ?>', '<?php echo addslashes($bedList['patient_name'] ?? ''); ?>', <?php echo $bedList['id']; ?>, <?php echo $categoryList['id']; ?>, '<?php echo addslashes($categoryList['name']); ?>', '<?php echo $nameIndex; ?>', '<?php echo addslashes($bedList['patient_photo_path'] ?? ''); ?>', '<?php echo addslashes($floor_name); ?>', '<?php echo isset($viewDate) ? date('d/m/Y', strtotime($viewDate)) : date('d/m/Y', strtotime($date)); ?>')" 
                       data-patient-allergies="<?php echo htmlspecialchars($allergenNamesForPrint, ENT_QUOTES, 'UTF-8'); ?>"
                       data-patient-dietary="<?php echo htmlspecialchars($dietaryNamesForPrint, ENT_QUOTES, 'UTF-8'); ?>"
                       data-patient-instructions="<?php echo $specialInstructionsForPrint; ?>"
                       class="btn btn-info btn-sm shadow-none text-nowrap print-label-btn" title="Print Label"><i class="mdi mdi-printer me-1"></i> Print</a>
                </div>
            </td>
                 
                  <?php }   ?>
                  <?php } else { // No items - show empty cell ?>
                  <td>
                      <div class="d-flex gap-1 flex-nowrap">
                          <span class="text-muted" style="font-size: 12px; font-style: italic;">No items ordered</span>
                      </div>
                  </td>
                  <?php } ?>
                  
                  </tr>  
                        
                <?php }  } ?>
                    </tbody>
                </table>      
                     </div>
                       </div>
                  </div>
                <?php $count++; }  ?>
           <?php  }  ?>
                                           
          </div>
                                    
            </div><!-- end card-body -->
                            </div>
              
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
            <!-- container-fluid -->
    </div>
        <!-- End Page-content -->

        
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Custom Confirmation Modal -->
<div id="confirmationModal" class="confirmation-modal">
    <div class="confirmation-content">
        <div class="confirmation-header">
            <div class="confirmation-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20" class="text-yellow-600">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="confirmation-title">Mark as Completed</h3>
        </div>
        <p class="confirmation-message">
            Are you sure you want to mark this category as packaged? This action will remove it from the package list.
        </p>
        <div class="confirmation-buttons">
            <button type="button" class="btn-cancel" onclick="closeConfirmationModal()">Cancel</button>
            <button type="button" class="btn-confirm" onclick="confirmMarkCompleted()">Yes, Mark Packaged</button>
        </div>
    </div>
</div>



<script type="text/javascript">
 function markThisCategoryPackaged(checkbox,order_id,category_id){
      let confirmAction = confirm("This section will disappear from the page, Once confirmed. Are you sure you want to proceed?");   
      event.preventDefault();
    if(confirmAction){     
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markACategoryPackaged") ?>',
        type: 'POST',
        data: {
          
            category_id: category_id,
            order_id: order_id
        },
        success: function(response) {
        checkbox.checked = true;
        $(checkbox).parents(".accordion-item").remove();
        },
        error: function() {
            alert('An error occurred while saving the menu.');
        }
    }); 
      }  else{
          checkbox.checked = false;
          return false;
      }  
     }
   function packageItem(obj,bed_id,category_id,order_id){
         
          // Get temperature value and notes from the same row
          const temperature = $(obj).closest('tr').find('input[name="temperature_' + bed_id + '"]').val();
          const notes = $(obj).closest('tr').find('textarea[name="note_' + bed_id + '"]').val();
          
          $(obj).html("Saving...");
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markPackaged") ?>',
        type: 'POST',
        data: {
            bed_id: bed_id,
            category_id: category_id,
            order_id: order_id,
            temperature: temperature,
            notes: notes
        },
        success: function(response) {
            let res = JSON.parse(response)
            // console.log("response",JSON.parse(response));
            // console.log("response status",res.status)
            if (res.status == 'success') {
                $(obj).html('<i class="mdi mdi-package-variant me-1"></i> Packaged');
                $(obj).parents(".ordertableRow").find(".deliveredButton").removeClass("btn-secondary").addClass("btn-success")
                $(obj).removeAttr('onclick');
                // Disable temperature input and notes textarea after packaging
                $(obj).closest('tr').find('input[name="temperature_' + bed_id + '"]').prop('disabled', true);
                $(obj).closest('tr').find('textarea[name="note_' + bed_id + '"]').prop('disabled', true);
            } else {
                 $(obj).html("Package");
                alert(response.message);
            }
        },
        error: function() {
            alert('An error occurred while saving the menu.');
        }
    }); 
      }    

	
	

    
</script>

<script>
// Simple working accordion functionality
$(document).ready(function() {
    // Remove any existing Bootstrap accordion behavior to avoid conflicts
    $('.accordion-button').off('click');
    
    // Add our simple click handler
    $('.accordion-button').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $button = $(this);
        const targetId = $button.attr('data-bs-target');
        const $target = $(targetId);
        
        // Toggle this accordion
        if ($target.is(':visible')) {
            // Close this one
            $target.hide();
            $button.addClass('collapsed').attr('aria-expanded', 'false');
        } else {
            // Open this one (don't close others - allow multiple open)
            $target.show();
            $button.removeClass('collapsed').attr('aria-expanded', 'true');
        }
    });
    
    // No additional event handlers needed - using inline onclick with stopPropagation
    
    // Open ALL accordions by default
    $('.accordion-collapse').show();
    $('.accordion-button').removeClass('collapsed').attr('aria-expanded', 'true');
});

// Global variables for confirmation modal
let currentCheckbox = null;
let currentOrderId = null;
let currentCategoryId = null;

// Improved markThisCategoryPackaged function with custom modal
function markThisCategoryPackaged(checkbox, orderId, categoryId) {
    // console.log('Switch clicked:', checkbox.checked, 'OrderID:', orderId, 'CategoryID:', categoryId);
    
    if (checkbox.checked) {
        // Store current values for confirmation
        currentCheckbox = checkbox;
        currentOrderId = orderId;
        currentCategoryId = categoryId;
        
        // Show custom confirmation modal
        showConfirmationModal();
    } else {
        // console.log('Switch unchecked - no action needed');
    }
}

// Show custom confirmation modal
function showConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    modal.classList.add('show');
}

// Close confirmation modal
function closeConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    modal.classList.remove('show');
    
    // Reset checkbox if cancelled
    if (currentCheckbox) {
        currentCheckbox.checked = false;
    }
    
    // Clear global variables
    currentCheckbox = null;
    currentOrderId = null;
    currentCategoryId = null;
}

// Confirm mark completed action
function confirmMarkCompleted() {
    // console.log('User confirmed, sending AJAX request...');
    
    // Close modal first
    const modal = document.getElementById('confirmationModal');
    modal.classList.remove('show');
    
    // Send AJAX request
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markACategoryPackaged") ?>',
        type: 'POST',
        data: {
            category_id: currentCategoryId,
            order_id: currentOrderId
        },
        success: function(response) {
            // console.log('AJAX Success:', response);
            
            // Keep checkbox checked
            if (currentCheckbox) {
                currentCheckbox.checked = true;
            }
            
            // Instead of removing, update the section to show "Completed" state
            const $accordionItem = $(currentCheckbox).parents(".accordion-item");
            
            // Replace the switch with a "Completed" badge
            const $switchWrapper = $(currentCheckbox).closest('.mark-completed-wrapper');
            $switchWrapper.html(`
                <span class="badge bg-success" style="font-size: 14px; padding: 8px 16px; font-weight: 600;">
                    <i class="mdi mdi-check-circle me-1"></i> COMPLETED
                </span>
            `);
            
            // Find all rows in this category section
            const $categorySection = $accordionItem.find('.accordion-body');
            
            // Update all "Package" buttons to "Packaged" state
            $categorySection.find('.deliveredButton').each(function() {
                const $btn = $(this);
                if (!$btn.hasClass('btn-success')) {
                    // Change to packaged state
                    $btn.html('<i class="mdi mdi-package-variant me-1"></i> Packaged')
                        .removeClass('btn-deliver btn-secondary')
                        .addClass('btn-success')
                        .prop('disabled', true)
                        .removeAttr('onclick');
                }
            });
            
            // Disable all temperature inputs and notes textareas in this section
            $categorySection.find('input[name^="temperature_"]').prop('disabled', true);
            $categorySection.find('textarea[name^="note_"]').prop('disabled', true);
            
            // Add a visual indicator to the accordion header
            const $accordionButton = $accordionItem.find('.accordion-button');
            $accordionButton.css({
                'background-color': '#f0fdf4',
                'border-color': '#10b981'
            });
            
            // Show success message
            showNotification('Category marked as completed successfully!', 'success');
            
            // Clear global variables
            currentCheckbox = null;
            currentOrderId = null;
            currentCategoryId = null;
        },
        error: function(xhr, status, error) {
            // console.log('AJAX Error:', xhr, status, error);
            
            // Reset checkbox on error
            if (currentCheckbox) {
                currentCheckbox.checked = false;
            }
            
            showNotification('An error occurred while updating package status.', 'error');
            
            // Clear global variables
            currentCheckbox = null;
            currentOrderId = null;
            currentCategoryId = null;
        }
    });
}

// Enhanced packageItem function
function packageItem(obj, bed_id, category_id, order_id) {
    // Get temperature value and notes from the same row
    const temperature = $(obj).closest('tr').find('input[name="temperature_' + bed_id + '"]').val();
    const notes = $(obj).closest('tr').find('textarea[name="note_' + bed_id + '"]').val();
    
    $(obj).prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-1"></i>Saving...');
    
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markPackaged") ?>',
        type: 'POST',
        data: {
            bed_id: bed_id,
            category_id: category_id,
            order_id: order_id,
            temperature: temperature,
            notes: notes
        },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.status == 'success') {
                $(obj).html('<i class="mdi mdi-package-variant me-1"></i> Packaged')
                      .removeClass('btn-deliver btn-secondary')
                      .addClass('btn-success')
                      .prop('disabled', true)
                      .removeAttr('onclick');
                
                // Disable temperature input and notes textarea after packaging
                $(obj).closest('tr').find('input[name="temperature_' + bed_id + '"]').prop('disabled', true);
                $(obj).closest('tr').find('textarea[name="note_' + bed_id + '"]').prop('disabled', true);
                
                showNotification('Order packaged successfully!', 'success');
            } else {
                $(obj).prop('disabled', false).html('<i class="mdi mdi-package-variant me-1"></i> Package');
                showNotification(res.message || 'Failed to update package status', 'error');
            }
        },
        error: function() {
            $(obj).prop('disabled', false).html('<i class="mdi mdi-package-variant me-1"></i> Package');
            showNotification('An error occurred while updating package status.', 'error');
        }
    });
}

// Notification function
function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 3000);
}

// Print Order Label Function
function printOrderLabel(suiteNo, patientName, bedId, categoryId, categoryName, nameIndex, patientPhotoPath = '', floorName = '', orderDate = '') {
    console.log('=== Print Label Debug ===');
    console.log('Suite:', suiteNo, 'Patient:', patientName);
    console.log('BedId:', bedId, 'CategoryId:', categoryId, 'Category:', categoryName);
    console.log('NameIndex:', nameIndex);
    console.log('Patient Photo Path:', patientPhotoPath);
    console.log('Floor Name:', floorName);
    console.log('Order Date:', orderDate);
    
    // Get patient allergies, dietary preferences, and special instructions from the button's data attributes
    const patientAllergies = event.target.closest('a').getAttribute('data-patient-allergies') || '';
    const patientDietary = event.target.closest('a').getAttribute('data-patient-dietary') || '';
    const patientInstructions = event.target.closest('a').getAttribute('data-patient-instructions') || '';
    console.log('Patient Allergies:', patientAllergies);
    console.log('Patient Dietary:', patientDietary);
    console.log('Patient Instructions:', patientInstructions);
    
    // Determine category color based on meal type
    function getCategoryColor(categoryName) {
        const categoryLower = categoryName.toLowerCase();
        if (categoryLower.includes('breakfast')) {
            return { bg: '#FFA500', text: '#fff' }; // Orange for Breakfast
        } else if (categoryLower.includes('lunch')) {
            return { bg: '#10B981', text: '#fff' }; // Green for Lunch
        } else if (categoryLower.includes('dinner')) {
            return { bg: '#7C3AED', text: '#fff' }; // Purple for Dinner
        } else {
            return { bg: '#1e40af', text: '#fff' }; // Default Blue
        }
    }
    
    const categoryColor = getCategoryColor(categoryName);
    
    // Find the row using the nameIndex which appears in the checkbox names
    // nameIndex format: orderId_bedId_categoryId (e.g., "32_303_1")
    let targetRow = null;
    
    // Look for checkboxes with names that include the nameIndex
    $('input[type="checkbox"][name^="' + nameIndex + '"]').each(function() {
        targetRow = $(this).closest('tr');
        return false; // Found it, break
    });
    
    // Fallback: try to find by temperature input
    if (!targetRow || targetRow.length === 0) {
        console.log('Fallback: searching by temperature input');
        $('input[name="temperature_' + bedId + '"]').each(function() {
            const row = $(this).closest('tr');
            // Verify this is the right row by checking if it has the right category buttons
            const hasCorrectButtons = row.find('a[onclick*=",' + bedId + ',' + categoryId + ',"]').length > 0;
            if (hasCorrectButtons) {
                targetRow = row;
                return false;
            }
        });
    }
    
    if (!targetRow || targetRow.length === 0) {
        console.error('ERROR: Could not find row');
        alert('Error: Could not find order details to print');
        return;
    }
    
    console.log('Row found!');
    
    // Extract food items from this row
    // Find all checkboxes with the nameIndex pattern
    let foodItems = [];
    targetRow.find('input[type="checkbox"][name^="' + nameIndex + '"]').each(function() {
        const checkbox = $(this);
        // Only include checked items
        if (!checkbox.is(':checked')) {
            return; // Skip unchecked
        }
        
        const label = checkbox.next('label.form-check-label');
        const itemName = label.text().trim();
        
        // Get options - look for the small tag after the form-check div
        const formCheck = checkbox.closest('.form-check');
        const optionsElement = formCheck.next('small.text-secondary');
        const options = optionsElement.length > 0 ? optionsElement.text().trim() : '';
        
        // Get allergens from data attribute
        const allergens = checkbox.data('allergens') || '';
        
        // Get item-specific comment from data attribute
        const itemComment = checkbox.data('item-comment') || '';
        
        if (itemName) {
            foodItems.push({
                name: itemName,
                options: options,
                allergens: allergens,
                itemComment: itemComment
            });
        }
    });
    
    console.log('Food items extracted:', foodItems.length);
    console.log('Food items:', foodItems);
    
    // Get notes and temperature
    const notes = targetRow.find('textarea[name="note_' + bedId + '"]').val() || '';
    const temperature = targetRow.find('input[name="temperature_' + bedId + '"]').val() || '';
    
    console.log('Notes:', notes);
    console.log('Temperature:', temperature);
    
    // Create print content
    let printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Label - Suite ${suiteNo}</title>
            <style>
                @media print {
                    @page {
                        size: A4;
                        margin: 0.5cm;
                    }
                    body {
                        margin: 0;
                        padding: 0;
                    }
                }
                body {
                    font-family: Arial, sans-serif;
                    padding: 5px;
                    max-width: 100%;
                }
                .label-header {
                    text-align: center;
                    border-bottom: 2px solid #333;
                    padding-bottom: 5px;
                    margin-bottom: 8px;
                }
                .label-header h1 {
                    margin: 0;
                    font-size: 18px;
                    color: #000;
                    font-weight: bold;
                }
                .label-header h2 {
                    margin: 3px 0 0 0;
                    font-size: 12px;
                    color: #666;
                }
                .suite-floor-box {
                    background: #000 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    border: 2px solid #000;
                    padding: 10px;
                    border-radius: 4px;
                    margin-bottom: 8px;
                    text-align: center;
                }
                .suite-number {
                    font-size: 36px;
                    font-weight: bold;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    margin: 0;
                    line-height: 1;
                }
                .floor-name {
                    font-size: 14px;
                    font-weight: 600;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    margin: 5px 0 0 0;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .info-section {
                    margin-bottom: 8px;
                }
                .info-row {
                    display: flex;
                    margin-bottom: 4px;
                    border-bottom: 1px dashed #ccc;
                    padding-bottom: 3px;
                }
                .info-label {
                    font-weight: bold;
                    color: #333;
                    min-width: 80px;
                    font-size: 11px;
                }
                .info-value {
                    color: #555;
                    flex: 1;
                    font-size: 11px;
                }
                .category-badge {
                    background: ${categoryColor.bg} !important;
                    color: ${categoryColor.text} !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    padding: 6px 12px;
                    border-radius: 4px;
                    display: inline-block;
                    margin-bottom: 8px;
                    font-size: 14px;
                    font-weight: bold;
                }
                .patient-info-container {
                    display: flex;
                    gap: 8px;
                    margin-bottom: 8px;
                    align-items: flex-start;
                }
                .patient-photo {
                    flex-shrink: 0;
                }
                .patient-details {
                    flex: 1;
                }
                .allergies-inline {
                    background-color: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    border: 2px solid #ffc107;
                    padding: 4px 6px;
                    border-radius: 3px;
                    margin-top: 4px;
                }
                .allergy-label {
                    color: #dc3545 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-weight: bold;
                    font-size: 10px;
                }
                .allergy-content {
                    color: #dc3545 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-weight: bold;
                    font-size: 10px;
                }
                .dietary-inline {
                    margin-top: 6px;
                }
                .dietary-label {
                    color: #16a34a !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-weight: bold;
                    font-size: 10px;
                }
                .dietary-content {
                    color: #374151 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-size: 10px;
                }
                .instructions-inline {
                    margin-top: 6px;
                }
                .instructions-label {
                    color: #7c3aed !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-weight: bold;
                    font-size: 10px;
                }
                .instructions-content {
                    color: #374151 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    font-size: 10px;
                }
                .food-items {
                    background: #f8f9fa !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 6px;
                    border-radius: 3px;
                    margin-bottom: 8px;
                }
                .food-items h3 {
                    margin: 0 0 5px 0;
                    font-size: 12px;
                    color: #333;
                    border-bottom: 2px solid #000;
                    padding-bottom: 3px;
                }
                .food-item {
                    margin-bottom: 5px;
                    padding: 3px;
                    background: white;
                    border-left: 3px solid #000;
                    padding-left: 6px;
                }
                .food-item-name {
                    font-weight: bold;
                    color: #333;
                    font-size: 11px;
                }
                .food-item-options {
                    color: #666;
                    font-size: 9px;
                    margin-top: 1px;
                }
                .food-item-allergens {
                    color: #856404 !important;
                    background-color: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 2px 4px;
                    border-radius: 2px;
                    font-size: 8px;
                    margin-top: 2px;
                    display: inline-block;
                }
                .food-item-comment {
                    color: #0c5460 !important;
                    background-color: #d1ecf1 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 2px 4px;
                    border-radius: 2px;
                    font-size: 8px;
                    margin-top: 2px;
                    font-style: italic;
                    border-left: 2px solid #17a2b8;
                }
                .notes-section {
                    background: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    border-left: 3px solid #ffc107;
                    padding: 5px;
                    margin-bottom: 5px;
                }
                .notes-section h4 {
                    margin: 0 0 3px 0;
                    font-size: 10px;
                    color: #856404;
                }
                .notes-section p {
                    margin: 0;
                    font-size: 9px;
                    color: #856404;
                }
                .temperature-section {
                    background: #d1ecf1 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    border-left: 3px solid #17a2b8;
                    padding: 5px;
                    margin-bottom: 5px;
                }
                .temperature-section h4 {
                    margin: 0 0 3px 0;
                    font-size: 10px;
                    color: #0c5460;
                }
                .temperature-section p {
                    margin: 0;
                    font-size: 12px;
                    font-weight: bold;
                    color: #0c5460;
                }
                .footer {
                    text-align: center;
                    margin-top: 8px;
                    padding-top: 5px;
                    border-top: 2px solid #333;
                    font-size: 9px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="label-header">
                <h1>🍽️ Cafe Zenn</h1>
                <h2>Order Label</h2>
            </div>
            
            <div class="category-badge">${categoryName}</div>
            
            <div class="suite-floor-box">
                <div class="suite-number">Suite ${suiteNo}</div>
                ${floorName ? `<div class="floor-name">${floorName}</div>` : ''}
            </div>
            
            <div class="patient-info-container">
                ${patientPhotoPath ? `
                <div class="patient-photo">
                    <img src="<?php echo base_url(); ?>${patientPhotoPath}" 
                         alt="Patient Photo" 
                         style="width: 80px; height: 80px; border-radius: 4px; border: 1px solid #ddd; object-fit: cover;">
                </div>
                ` : ''}
                <div class="patient-details">
                    ${patientName ? `
                    <div class="info-row">
                        <span class="info-label">Patient:</span>
                        <span class="info-value">${patientName}</span>
                    </div>
                    ` : ''}
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span class="info-value">${orderDate || new Date().toLocaleDateString('en-AU', { day: '2-digit', month: '2-digit', year: 'numeric' })}</span>
                    </div>
                    ${patientAllergies && patientAllergies.trim() ? `
                    <div class="allergies-inline">
                        <span class="allergy-label" style="font-weight: bold; color: #dc2626;">⚠️ Allergies:</span>
                        <span class="allergy-content" style="color: #374151;">${patientAllergies}</span>
                    </div>
                    ` : ''}
                    ${patientDietary && patientDietary.trim() ? `
                    <div class="dietary-inline" style="margin-top: 8px;">
                        <span class="dietary-label" style="font-weight: bold; color: #16a34a; font-size: 10px;">🍽️ Dietary:</span>
                        <span class="dietary-content" style="color: #374151; font-size: 10px;">${patientDietary}</span>
                    </div>
                    ` : ''}
                    ${patientInstructions && patientInstructions.trim() ? `
                    <div class="instructions-inline" style="margin-top: 8px;">
                        <span class="instructions-label" style="font-weight: bold; color: #7c3aed; font-size: 10px;">📋 Special Instructions:</span>
                        <span class="instructions-content" style="color: #374151; font-size: 10px;">${patientInstructions}</span>
                    </div>
                    ` : ''}
                </div>
            </div>
            
            ${foodItems.length > 0 ? `
            <div class="food-items">
                <h3>Food Items:</h3>
                ${foodItems.map(item => `
                    <div class="food-item">
                        <div class="food-item-name">${item.name}</div>
                        ${item.options ? `<div class="food-item-options">${item.options}</div>` : ''}
                        ${item.allergens ? `<div class="food-item-allergens">⚠️ Allergens: ${item.allergens}</div>` : ''}
                        ${item.itemComment ? `<div class="food-item-comment">💬 Note: ${item.itemComment}</div>` : ''}
                    </div>
                `).join('')}
            </div>
            ` : ''}
            
            ${notes ? `
            <div class="notes-section">
                <h4>📝 Notes:</h4>
                <p>${notes}</p>
            </div>
            ` : ''}
            
            ${temperature ? `
            <div class="temperature-section">
                <h4>🌡️ Temperature:</h4>
                <p>${temperature}°C</p>
            </div>
            ` : ''}
            
            <div class="footer">
                <p>Thank you for choosing Cafe Zenn</p>
            </div>
        </body>
        </html>
    `;
    
    // Open print window
    const printWindow = window.open('', '_blank', 'width=400,height=600');
    printWindow.document.write(printContent);
    printWindow.document.close();
    
    // Wait for content to load, then print
    printWindow.onload = function() {
        printWindow.print();
        // Close after printing (optional)
        setTimeout(function() {
            printWindow.close();
        }, 500);
    };
}

// Bulk Print All Labels Function
function bulkPrintAllLabels() {
    console.log('=== Bulk Print All Labels ===');
    
    // ✅ FIX: Find ALL suites that have items, not just print buttons
    // This ensures we get suite 301 even if print button isn't visible
    let allLabelsContent = [];
    
    // Method 1: Find all print buttons (suites with items that have print buttons)
    let allPrintButtons = $('a[onclick*="printOrderLabel"]');
    console.log('Found ' + allPrintButtons.length + ' print buttons');
    
    // Method 2: Also scan ALL suite rows to find suites with items (checkboxes)
    // This catches suites that have items but print button might not be visible
    let suitesWithItems = new Set();
    $('.accordion-item').each(function() {
        const accordionItem = $(this);
        const categoryId = accordionItem.find('.accordion-collapse').attr('id').replace('collapse', '');
        
        accordionItem.find('tbody tr.ordertableRow').each(function() {
            const row = $(this);
            const suiteCell = row.find('td').first();
            const suiteNo = suiteCell.text().match(/Suite\s+(\d+)/);
            
            if (suiteNo) {
                const suiteNumber = suiteNo[1];
                const bedIdInput = row.find('input[name^="temperature_"], textarea[name^="note_"]').first();
                const bedId = bedIdInput.attr('name') ? bedIdInput.attr('name').match(/\d+/)[0] : '';
                
                // Check if this suite has checkboxes (items ordered)
                const hasCheckboxes = row.find('input[type="checkbox"][name*="' + bedId + '_' + categoryId + '"]').length > 0;
                
                if (hasCheckboxes) {
                    const key = suiteNumber + '_' + categoryId;
                    suitesWithItems.add(key);
                }
            }
        });
    });
    
    console.log('Found ' + suitesWithItems.size + ' suite-category combinations with items');
    
    // Process print buttons first
    allPrintButtons.each(function(index) {
        const button = $(this);
        const onclickAttr = button.attr('onclick');
        
        // Get patient allergies, dietary preferences, and special instructions from data attributes
        const patientAllergies = button.attr('data-patient-allergies') || '';
        const patientDietary = button.attr('data-patient-dietary') || '';
        const patientInstructions = button.attr('data-patient-instructions') || '';
        
        // Extract parameters from onclick
        // Format: printOrderLabel('303', 'Patient III', 3, 1, 'BREAKFAST 6.30 AM', '32_3_1', 'uploaded_files/patient_photos/photo.jpg', 'Floor Name', '09/11/2025')
        const match = onclickAttr.match(/printOrderLabel\('([^']*)',\s*'([^']*)',\s*(\d+),\s*(\d+),\s*'([^']*)',\s*'([^']*)'\s*(?:,\s*'([^']*)')?\s*(?:,\s*'([^']*)')?\s*(?:,\s*'([^']*)')?\)/);
        
        if (match) {
            const suiteNo = match[1];
            const patientName = match[2];
            const bedId = parseInt(match[3]);
            const categoryId = parseInt(match[4]);
            const categoryName = match[5];
            const nameIndex = match[6];
            const patientPhotoPath = match[7] || '';
            const floorName = match[8] || '';
            const orderDate = match[9] || ''; // 🔧 FIX: Capture order date
            
            // Determine category color based on meal type
            function getCategoryColor(categoryName) {
                const categoryLower = categoryName.toLowerCase();
                if (categoryLower.includes('breakfast')) {
                    return { bg: '#FFA500', text: '#fff' };
                } else if (categoryLower.includes('lunch')) {
                    return { bg: '#10B981', text: '#fff' };
                } else if (categoryLower.includes('dinner')) {
                    return { bg: '#7C3AED', text: '#fff' };
                } else {
                    return { bg: '#1e40af', text: '#fff' };
                }
            }
            
            const categoryColor = getCategoryColor(categoryName);
            
            // Find the row
            let targetRow = null;
            $('input[type="checkbox"][name^="' + nameIndex + '"]').each(function() {
                targetRow = $(this).closest('tr');
                return false;
            });
            
            if (!targetRow || targetRow.length === 0) {
                return;
            }
            
            // Extract food items
            let foodItems = [];
            const allCheckboxes = targetRow.find('input[type="checkbox"][name^="' + nameIndex + '"]');
            
            allCheckboxes.each(function() {
                const checkbox = $(this);
                // For bulk print, we want ALL items (checked or not) for completed orders
                
                const label = checkbox.next('label.form-check-label');
                const itemName = label.text().trim();
                const formCheck = checkbox.closest('.form-check');
                const optionsElement = formCheck.next('small.text-secondary');
                const options = optionsElement.length > 0 ? optionsElement.text().trim() : '';
                
                // Get allergens from data attribute
                const allergens = checkbox.data('allergens') || '';
                
                // Get item-specific comment from data attribute
                const itemComment = checkbox.data('item-comment') || '';
                
                if (itemName) {
                    foodItems.push({ name: itemName, options: options, allergens: allergens, itemComment: itemComment });
                }
            });
            
            // Skip if no items
            if (foodItems.length === 0) {
                return;
            }
            
            // Get notes and temperature
            const notes = targetRow.find('textarea[name="note_' + bedId + '"]').val() || '';
            const temperature = targetRow.find('input[name="temperature_' + bedId + '"]').val() || '';
            
            // Store label data
            allLabelsContent.push({
                suiteNo: suiteNo,
                patientName: patientName,
                patientAllergies: patientAllergies,
                patientDietary: patientDietary,
                patientInstructions: patientInstructions,
                patientPhotoPath: patientPhotoPath,
                floorName: floorName,
                categoryName: categoryName,
                categoryColor: categoryColor,
                foodItems: foodItems,
                notes: notes,
                temperature: temperature,
                bedId: bedId,
                categoryId: categoryId,
                orderDate: orderDate // 🔧 FIX: Include order date
            });
        }
    });
    
    // ✅ FIX: Also process suites that have items but might not have print buttons visible
    // Find suites with checkboxes that weren't already processed
    $('.accordion-item').each(function() {
        const accordionItem = $(this);
        const categoryName = accordionItem.find('.accordion-button strong').text().trim();
        const categoryId = accordionItem.find('.accordion-collapse').attr('id').replace('collapse', '');
        
        accordionItem.find('tbody tr.ordertableRow').each(function() {
            const row = $(this);
            const suiteCell = row.find('td').first();
            const suiteNo = suiteCell.text().match(/Suite\s+(\d+)/);
            
            if (suiteNo) {
                const suiteNumber = suiteNo[1];
                
                // Extract patient name - try multiple methods
                let patientName = '';
                
                // Method 1: Try to get from print button data attribute or onclick
                const printButton = row.find('a[onclick*="printOrderLabel"]').first();
                if (printButton.length > 0) {
                    const onclickAttr = printButton.attr('onclick');
                    const nameMatch = onclickAttr.match(/printOrderLabel\('([^']*)',\s*'([^']*)'/);
                    if (nameMatch && nameMatch[2]) {
                        patientName = nameMatch[2];
                    }
                }
                
                // Method 2: Extract from suite cell text after "Name:" or "👤 Name:"
                if (!patientName) {
                    const suiteCellText = suiteCell.text();
                    // Try to match "Name: Patient Name" or "👤 Name: Patient Name"
                    const nameMatch = suiteCellText.match(/(?:👤\s*)?Name:\s*([^\n\r]*?)(?:\n|⚠️|🍽️|📋|Ward|$)/);
                    if (nameMatch && nameMatch[1]) {
                        patientName = nameMatch[1].trim();
                    }
                }
                
                // Method 3: Try to find the span that comes after "Name:" label
                if (!patientName) {
                    let foundNameLabel = false;
                    suiteCell.find('span').each(function() {
                        const text = $(this).text();
                        if (text.includes('Name:') || text.includes('👤')) {
                            foundNameLabel = true;
                            // Get the next sibling span which should contain the actual name
                            const nextSpan = $(this).next('span');
                            if (nextSpan.length > 0) {
                                const nameText = nextSpan.text().trim();
                                if (nameText && !nameText.includes('Allergies') && !nameText.includes('Dietary') && !nameText.includes('Special Instructions')) {
                                    patientName = nameText;
                                    return false; // break
                                }
                            }
                        } else if (foundNameLabel && !patientName) {
                            // If we found the Name label, the next non-label span should be the name
                            if (!text.includes('Allergies') && !text.includes('Dietary') && !text.includes('Special Instructions') && !text.includes('Ward')) {
                                patientName = text.trim();
                                return false; // break
                            }
                        }
                    });
                }
                
                const bedIdInput = row.find('input[name^="temperature_"], textarea[name^="note_"]').first();
                const bedId = bedIdInput.attr('name') ? bedIdInput.attr('name').match(/\d+/)[0] : '';
                const nameIndex = bedId + '_' + categoryId;
                
                // Check if this suite-category combo was already processed
                const alreadyProcessed = allLabelsContent.some(function(label) {
                    return label.bedId == bedId && label.categoryId == categoryId;
                });
                
                // Check if suite has items (checkboxes)
                const hasCheckboxes = row.find('input[type="checkbox"][name*="' + nameIndex + '"]').length > 0;
                
                if (!alreadyProcessed && hasCheckboxes) {
                    // Suite has items but wasn't processed - add it manually
                    console.log('Adding suite ' + suiteNumber + ' for category ' + categoryName + ' (has items but no print button found)');
                    
                    // Determine category color
                    function getCategoryColor(categoryName) {
                        const categoryLower = categoryName.toLowerCase();
                        if (categoryLower.includes('breakfast')) {
                            return { bg: '#FFA500', text: '#fff' };
                        } else if (categoryLower.includes('lunch')) {
                            return { bg: '#10B981', text: '#fff' };
                        } else if (categoryLower.includes('dinner')) {
                            return { bg: '#7C3AED', text: '#fff' };
                        } else {
                            return { bg: '#1e40af', text: '#fff' };
                        }
                    }
                    
                    const categoryColor = getCategoryColor(categoryName);
                    
                    // Extract food items from checkboxes
                    let foodItems = [];
                    row.find('input[type="checkbox"][name*="' + nameIndex + '"]').each(function() {
                        const checkbox = $(this);
                        const label = checkbox.next('label.form-check-label');
                        const itemName = label.text().trim();
                        const formCheck = checkbox.closest('.form-check');
                        const optionsElement = formCheck.next('small.text-secondary');
                        const options = optionsElement.length > 0 ? optionsElement.text().trim() : '';
                        const allergens = checkbox.data('allergens') || '';
                        const itemComment = checkbox.data('item-comment') || '';
                        
                        if (itemName) {
                            foodItems.push({ name: itemName, options: options, allergens: allergens, itemComment: itemComment });
                        }
                    });
                    
                    // Get patient allergies, dietary preferences, and special instructions from suite cell
                    // Try to find print button in this row first (more reliable)
                    const printButton = row.find('a[onclick*="printOrderLabel"]').first();
                    let allergyText = '';
                    let dietaryText = '';
                    let instructionsText = '';
                    
                    if (printButton.length > 0) {
                        // Use data attributes from print button (most reliable)
                        allergyText = printButton.attr('data-patient-allergies') || '';
                        dietaryText = printButton.attr('data-patient-dietary') || '';
                        instructionsText = printButton.attr('data-patient-instructions') || '';
                    } else {
                        // Fallback: extract from suite cell text
                        const suiteCellText = suiteCell.text();
                        const allergyMatch = suiteCellText.match(/Allergies:\s*([^\n\r]*)/);
                        if (allergyMatch && allergyMatch[1]) {
                            allergyText = allergyMatch[1].trim();
                        }
                        
                        const dietaryMatch = suiteCellText.match(/Dietary:\s*([^\n\r]*)/);
                        if (dietaryMatch && dietaryMatch[1]) {
                            dietaryText = dietaryMatch[1].trim();
                        }
                        
                        const instructionsMatch = suiteCellText.match(/Special Instructions:\s*([^\n\r]*)/);
                        if (instructionsMatch && instructionsMatch[1]) {
                            instructionsText = instructionsMatch[1].trim();
                        }
                    }
                    
                    // Get notes and temperature
                    const notes = row.find('textarea[name="note_' + bedId + '"]').val() || '';
                    const temperature = row.find('input[name="temperature_' + bedId + '"]').val() || '';
                    
                    // Get floor name and order date
                    const floorName = $('h4.text-black').first().text().trim() || '';
                    const orderDateText = $('.btn-group').next().find('span.text-dark').text().trim();
                    const orderDate = orderDateText.match(/\(([^)]+)\)/) ? orderDateText.match(/\(([^)]+)\)/)[1] : '';
                    
                    // Get patient photo path (try to find from any print button for this suite)
                    const patientPhotoPath = '';
                    
                    // Add to labels
                    allLabelsContent.push({
                        suiteNo: suiteNumber,
                        patientName: patientName,
                        patientAllergies: allergyText,
                        patientDietary: dietaryText,
                        patientInstructions: instructionsText,
                        patientPhotoPath: patientPhotoPath,
                        floorName: floorName,
                        categoryName: categoryName,
                        categoryColor: categoryColor,
                        foodItems: foodItems,
                        notes: notes,
                        temperature: temperature,
                        bedId: parseInt(bedId),
                        categoryId: parseInt(categoryId),
                        orderDate: orderDate
                    });
                }
            }
        });
    });
    
    // Remove duplicates (same suite-category combination)
    const uniqueLabels = [];
    const seen = new Set();
    
    allLabelsContent.forEach(label => {
        const key = `${label.bedId}_${label.categoryId}`;
        if (!seen.has(key)) {
            seen.add(key);
            uniqueLabels.push(label);
        }
    });
    
    allLabelsContent = uniqueLabels;
    
    if (allLabelsContent.length === 0) {
        console.log('No suites with items found to print.');
        alert('No suites with items found to print.');
        return;
    }
    
    // ✅ FIX: Sort labels by category order (Breakfast → Lunch → Dinner)
    // Then by suite number within each category
    function getCategoryOrder(categoryName) {
        const categoryLower = categoryName.toLowerCase();
        if (categoryLower.includes('breakfast')) {
            return 1; // Breakfast first
        } else if (categoryLower.includes('lunch')) {
            return 2; // Lunch second
        } else if (categoryLower.includes('dinner')) {
            return 3; // Dinner third
        } else {
            return 4; // Other categories last
        }
    }
    
    allLabelsContent.sort(function(a, b) {
        // First sort by category order
        const categoryOrderA = getCategoryOrder(a.categoryName);
        const categoryOrderB = getCategoryOrder(b.categoryName);
        
        if (categoryOrderA !== categoryOrderB) {
            return categoryOrderA - categoryOrderB;
        }
        
        // If same category, sort by suite number
        const suiteA = parseInt(a.suiteNo) || 0;
        const suiteB = parseInt(b.suiteNo) || 0;
        return suiteA - suiteB;
    });
    
    console.log('Total labels to print: ' + allLabelsContent.length);
    console.log('Sorted order: ' + allLabelsContent.map(l => l.categoryName + ' - Suite ' + l.suiteNo).join(', '));
    
    console.log('Printing ' + allLabelsContent.length + ' labels');
    
    // Generate combined print content
    let combinedContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Bulk Order Labels</title>
            <style>
                @media print {
                    @page {
                        size: A4;
                        margin: 0.5cm;
                    }
                    body { 
                        margin: 0; 
                        padding: 0; 
                        overflow: visible;
                    }
                    .labels-wrapper {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        grid-auto-rows: auto;
                        gap: 8px;
                        width: 100%;
                        page-break-inside: avoid;
                        break-inside: avoid;
                        align-items: start;
                    }
                    .labels-wrapper:not(:last-of-type) {
                        page-break-after: always;
                        break-after: page;
                    }
                    .label-container {
                        min-height: 0;
                        min-width: 0;
                        page-break-inside: avoid;
                        break-inside: avoid;
                        overflow: visible;
                        height: auto;
                        width: 100%;
                    }
                    .label-content {
                        overflow: visible !important;
                    }
                    .food-items {
                        overflow: visible !important;
                    }
                    .food-items-list {
                        overflow: visible !important;
                    }
                }
                body {
                    font-family: Arial, sans-serif;
                    padding: 0;
                    margin: 0;
                    max-width: 100%;
                }
                .labels-wrapper {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    grid-auto-rows: auto;
                    gap: 8px;
                    padding: 5px;
                    width: 100%;
                    box-sizing: border-box;
                    align-items: start;
                }
                .label-container {
                    border: 1px solid #ddd;
                    background: #fff;
                    page-break-inside: avoid;
                    width: 100%;
                    min-height: 200px;
                    position: relative;
                    box-sizing: border-box;
                    overflow: visible;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    display: flex;
                    flex-direction: column;
                }
                .label-content {
                    position: relative;
                    padding: 6px;
                    display: flex;
                    flex-direction: column;
                    overflow: visible;
                    box-sizing: border-box;
                    width: 100%;
                    flex: 1;
                    min-height: 0;
                }
                .label-header {
                    text-align: center;
                    border-bottom: 1px solid #333;
                    padding-bottom: 1px;
                    margin-bottom: 2px;
                    flex-shrink: 0;
                }
                .label-header h1 {
                    margin: 0;
                    font-size: 14px;
                    color: #000;
                    font-weight: bold;
                    line-height: 1.2;
                }
                .label-header h2 {
                    margin: 0;
                    font-size: 10px;
                    color: #666;
                    line-height: 1.2;
                }
                .suite-floor-box {
                    background: #000 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    border: 1px solid #000;
                    padding: 4px;
                    border-radius: 2px;
                    margin-bottom: 3px;
                    text-align: center;
                    flex-shrink: 0;
                }
                .suite-number {
                    font-size: 20px;
                    font-weight: bold;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    margin: 0;
                    line-height: 1.2;
                }
                .floor-name {
                    font-size: 11px;
                    font-weight: 600;
                    color: #fff !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    margin: 1px 0 0 0;
                    text-transform: uppercase;
                    letter-spacing: 0.2px;
                    line-height: 1.2;
                }
                .patient-info-container {
                    display: flex;
                    gap: 3px;
                    margin-bottom: 2px;
                    align-items: flex-start;
                    overflow: visible;
                    flex-shrink: 0;
                }
                .patient-photo {
                    flex-shrink: 0;
                }
                .patient-photo img {
                    width: 40px !important;
                    height: 40px !important;
                }
                .patient-details {
                    flex: 1;
                    min-width: 0;
                    overflow: visible;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }
                .allergies-inline {
                    background-color: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    border: 1px solid #ffc107;
                    padding: 2px 4px;
                    border-radius: 2px;
                    margin-top: 2px;
                    margin-bottom: 2px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    display: block;
                    font-size: 8px;
                    line-height: 1.3;
                }
                .allergy-label {
                    color: #dc3545 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-weight: bold;
                    font-size: 8px;
                    display: inline-block;
                }
                .allergy-content {
                    color: #dc3545 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-weight: bold;
                    font-size: 8px;
                    display: inline;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }
                .dietary-inline {
                    margin-top: 2px;
                    margin-bottom: 2px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    display: block;
                    font-size: 8px;
                    line-height: 1.3;
                }
                .dietary-label {
                    color: #16a34a !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-weight: bold;
                    font-size: 8px;
                    display: inline-block;
                }
                .dietary-content {
                    color: #374151 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-size: 8px;
                    display: inline;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }
                .instructions-inline {
                    margin-top: 2px;
                    margin-bottom: 2px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    display: block;
                    font-size: 8px;
                    line-height: 1.3;
                }
                .instructions-label {
                    color: #7c3aed !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-weight: bold;
                    font-size: 8px;
                    display: inline-block;
                }
                .instructions-content {
                    color: #374151 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    color-adjust: exact;
                    font-size: 8px;
                    display: inline;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }
                .info-row {
                    display: flex;
                    margin-bottom: 2px;
                    border-bottom: 1px dashed #ccc;
                    padding-bottom: 1px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.3;
                }
                .info-label {
                    font-weight: bold;
                    color: #333;
                    min-width: 40px;
                    font-size: 8px;
                    flex-shrink: 0;
                }
                .info-value {
                    color: #555;
                    flex: 1;
                    font-size: 8px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    min-width: 0;
                }
                .food-items {
                    background: #f8f9fa !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 3px;
                    border-radius: 2px;
                    margin-bottom: 3px;
                    overflow: visible;
                    flex: 1;
                    min-height: 0;
                    display: flex;
                    flex-direction: column;
                }
                .food-items h3 {
                    margin: 0 0 2px 0;
                    font-size: 10px;
                    color: #333;
                    border-bottom: 1px solid #000;
                    padding-bottom: 2px;
                    flex-shrink: 0;
                    line-height: 1.2;
                }
                .food-items-list {
                    overflow: visible;
                    flex: 1;
                    min-height: 0;
                    display: flex;
                    flex-direction: column;
                }
                .food-item {
                    margin-bottom: 2px;
                    padding: 2px;
                    background: white;
                    border-left: 2px solid #000;
                    padding-left: 4px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    overflow: visible;
                    line-height: 1.3;
                }
                .food-item-name {
                    font-weight: bold;
                    color: #333;
                    font-size: 8px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    margin-bottom: 1px;
                    line-height: 1.3;
                }
                .food-item-options {
                    color: #666;
                    font-size: 7px;
                    margin-top: 1px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    display: block;
                    line-height: 1.3;
                }
                .food-item-allergens {
                    color: #856404 !important;
                    background-color: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 2px 4px;
                    border-radius: 2px;
                    font-size: 7px;
                    margin-top: 2px;
                    display: inline-block;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.3;
                }
                .food-item-comment {
                    color: #0c5460 !important;
                    background-color: #d1ecf1 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 2px 4px;
                    border-radius: 2px;
                    font-size: 7px;
                    margin-top: 2px;
                    font-style: italic;
                    border-left: 1px solid #17a2b8;
                    display: block;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.3;
                }
                .notes-section {
                    background: #fff3cd !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    border-left: 2px solid #ffc107;
                    padding: 1px;
                    margin-bottom: 1px;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    overflow: visible;
                    flex-shrink: 0;
                }
                .notes-section h4 {
                    margin: 0 0 2px 0;
                    font-size: 8px;
                    color: #856404;
                    line-height: 1.2;
                }
                .notes-section p {
                    margin: 0;
                    font-size: 7px;
                    color: #856404;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.3;
                }
                .temperature-section {
                    background: #d1ecf1 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    border-left: 2px solid #17a2b8;
                    padding: 2px;
                    margin-bottom: 2px;
                    overflow: visible;
                    flex-shrink: 0;
                }
                .temperature-section h4 {
                    margin: 0 0 2px 0;
                    font-size: 8px;
                    color: #0c5460;
                    line-height: 1.2;
                }
                .temperature-section p {
                    margin: 0;
                    font-size: 10px;
                    font-weight: bold;
                    color: #0c5460;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.3;
                }
                .footer {
                    text-align: center;
                    margin-top: 2px;
                    padding-top: 2px;
                    border-top: 1px solid #333;
                    font-size: 7px;
                    color: #666;
                    flex-shrink: 0;
                    line-height: 1.3;
                }
            </style>
        </head>
        <body>
            <div class="labels-wrapper">
    `;
    
    // Add each label in a 2-column grid with page breaks every 4 labels (2 columns x 2 rows)
    allLabelsContent.forEach(function(label, index) {
        const pageNumber = index + 1;
        const labelNumber = index + 1;
        
        // Add page break after every 4 labels (after labels 4, 8, 12, etc.)
        // This ensures exactly 4 labels per page (2 columns x 2 rows)
        // Break when index is 4, 8, 12, etc. (index % 4 === 0 and index > 0)
        if (index > 0 && index % 4 === 0) {
            combinedContent += `
            </div>
            <div class="labels-wrapper">
            `;
        }
        
        combinedContent += `
            <div class="label-container">
                <div class="label-content">
                    <div class="label-header">
                        <h1 style="margin: 0; font-size: 10px; line-height: 1.1;">🍽️ Cafe Zenn</h1>
                        <h2 style="margin: 1px 0 0 0; font-size: 7px; line-height: 1.1;">Label ${labelNumber}</h2>
                    </div>
                    
                    <div style="background: ${label.categoryColor.bg} !important; color: ${label.categoryColor.text} !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; padding: 2px 4px; border-radius: 2px; display: inline-block; margin-bottom: 3px; font-size: 8px; font-weight: bold; line-height: 1.1;">${label.categoryName}</div>
                
                <div class="suite-floor-box">
                    <div class="suite-number">Suite ${label.suiteNo}</div>
                    ${label.floorName ? `<div class="floor-name">${label.floorName}</div>` : ''}
                </div>
                
                <div class="patient-info-container">
                    ${label.patientPhotoPath ? `
                    <div class="patient-photo">
                        <img src="<?php echo base_url(); ?>${label.patientPhotoPath}" 
                             alt="Patient Photo" 
                             style="width: 35px; height: 35px; border-radius: 2px; border: 1px solid #ddd; object-fit: cover;">
                    </div>
                    ` : ''}
                    <div class="patient-details">
                        ${label.patientName ? `
                        <div class="info-row">
                            <span class="info-label">Patient:</span>
                            <span class="info-value">${label.patientName}</span>
                        </div>
                        ` : ''}
                        <div class="info-row">
                            <span class="info-label">Date:</span>
                            <span class="info-value">${label.orderDate || new Date().toLocaleDateString('en-AU', { day: '2-digit', month: '2-digit', year: 'numeric' })}</span>
                        </div>
                        ${label.patientAllergies && label.patientAllergies.trim() ? `
                        <div class="allergies-inline">
                            <span class="allergy-label">⚠️ Allergies:</span>
                            <span class="allergy-content">${label.patientAllergies}</span>
                        </div>
                        ` : ''}
                        ${label.patientDietary && label.patientDietary.trim() ? `
                        <div class="dietary-inline">
                            <span class="dietary-label">🍽️ Dietary:</span>
                            <span class="dietary-content">${label.patientDietary}</span>
                        </div>
                        ` : ''}
                        ${label.patientInstructions && label.patientInstructions.trim() ? `
                        <div class="instructions-inline">
                            <span class="instructions-label">📋 Special Instructions:</span>
                            <span class="instructions-content">${label.patientInstructions}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>
                
                ${label.foodItems.length > 0 ? `
                <div class="food-items">
                    <h3>Food Items:</h3>
                    <div class="food-items-list">
                        ${label.foodItems.map(item => `
                            <div class="food-item">
                                <div class="food-item-name">${item.name}</div>
                                ${item.options ? `<div class="food-item-options">${item.options}</div>` : ''}
                                ${item.allergens ? `<div class="food-item-allergens">⚠️ Allergens: ${item.allergens}</div>` : ''}
                                ${item.itemComment ? `<div class="food-item-comment">💬 Note: ${item.itemComment}</div>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
                
                ${label.notes ? `
                <div class="notes-section">
                    <h4>📝 Notes:</h4>
                    <p>${label.notes}</p>
                </div>
                ` : ''}
                
                ${label.temperature ? `
                <div class="temperature-section">
                    <h4>🌡️ Temperature:</h4>
                    <p>${label.temperature}°C</p>
                </div>
                ` : ''}
                
                <div class="footer">
                    <p>Thank you for choosing Cafe Zenn</p>
                </div>
                </div>
            </div>
        `;
    });
    
    combinedContent += `
            </div>
        </body>
        </html>
    `;
    
    // Open print window
    const printWindow = window.open('', '_blank', 'width=800,height=1000');
    printWindow.document.write(combinedContent);
    printWindow.document.close();
    
    // Wait for content to load, then print
    printWindow.onload = function() {
        printWindow.print();
        // Close after printing
        setTimeout(function() {
            printWindow.close();
        }, 1000);
    };
}

// 🆕 DATE SELECTOR: Change date view (Today/Tomorrow) - Simple Form Submit
// Use PHP server-side dates to avoid timezone issues
const SERVER_TODAY = '<?php echo date("Y-m-d"); ?>';
const SERVER_TOMORROW = '<?php echo date("Y-m-d", strtotime("+1 day")); ?>';

function changeDateView(dateType) {
    console.log('📅 Switching to:', dateType);
    
    // Use server-side dates (no timezone issues)
    let viewDate = (dateType === 'tomorrow') ? SERVER_TOMORROW : SERVER_TODAY;
    
    console.log('📅 Server date for', dateType, ':', viewDate);
    
    // Create a hidden form and submit it
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = window.location.href;
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'switch_to_date';
    input.value = viewDate;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

// Auto-refresh Order Delivery page every 15 minutes
function scheduleAutoRefresh() {
    const refreshInterval = 15 * 60 * 1000; // 15 minutes in milliseconds
    
    console.log('🔄 Order Delivery Page Auto-Refresh: Enabled (Every 15 minutes)');
    console.log(`⏰ Next refresh scheduled in 15 minutes at ${new Date(Date.now() + refreshInterval).toLocaleTimeString('en-AU')}`);
    
    // Set interval to refresh every 15 minutes
    setInterval(function() {
        console.log('🔄 Auto-refreshing Order Delivery Page (15-minute interval)...');
        
        // Show toast notification before refresh
        showAutoRefreshToast();
        
        // Wait 3 seconds, then reload
        setTimeout(function() {
            location.reload();
        }, 3000);
    }, refreshInterval);
}

// Function to show auto-refresh toast notification
function showAutoRefreshToast() {
    // Create toast element
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #3b82f6;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideIn 0.3s ease-out;
    `;
    
    toast.innerHTML = `
        <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <div>
            <div style="font-weight: 600; margin-bottom: 4px;">Auto-Refresh in Progress</div>
            <div style="font-size: 14px; opacity: 0.9;">Order Delivery Page will reload in 3 seconds...</div>
        </div>
    `;
    
    // Add animation styles if not already present
    if (!document.getElementById('toast-animation-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-animation-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            .animate-spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Append to body
    document.body.appendChild(toast);
    
    console.log('✅ Auto-refresh toast notification shown');
}

// 🆕 READ-ONLY MODE: Function to apply read-only restrictions
function applyReadOnlyMode() {
    console.log('📅 Applying read-only mode...');
    
    // 1. Disable all "Mark Completed" switches
    const markCompletedSwitches = document.querySelectorAll('.custom-switch input[type="checkbox"]');
    markCompletedSwitches.forEach(function(switchElem) {
        switchElem.disabled = true;
        switchElem.style.opacity = '0.5';
        switchElem.style.cursor = 'not-allowed';
        // Also disable the slider
        const slider = switchElem.nextElementSibling;
        if (slider && slider.classList.contains('switch-slider')) {
            slider.style.cursor = 'not-allowed';
            slider.style.opacity = '0.5';
        }
    });
    
    // 2. Disable all "Package" buttons
    const packageButtons = document.querySelectorAll('.deliveredButton');
    packageButtons.forEach(function(btn) {
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.5';
        btn.style.cursor = 'not-allowed';
        btn.title = 'Read-only mode - Cannot package tomorrow\'s orders';
    });
    
    // 3. Disable all Notes textareas
    const notesTextareas = document.querySelectorAll('textarea[name^="note_"]');
    notesTextareas.forEach(function(textarea) {
        textarea.disabled = true;
        textarea.style.backgroundColor = '#f5f5f5';
        textarea.style.cursor = 'not-allowed';
    });
    
    // 4. Disable all Temperature inputs
    const tempInputs = document.querySelectorAll('input[name^="temperature_"]');
    tempInputs.forEach(function(input) {
        input.disabled = true;
        input.style.backgroundColor = '#f5f5f5';
        input.style.cursor = 'not-allowed';
    });
    
    // 5. Show read-only indicator alert at top of page
    const cardBody = document.querySelector('.card-body');
    if (cardBody) {
        // Remove existing alert if any
        const existingAlert = cardBody.querySelector('.alert.alert-warning');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-warning d-flex align-items-center mb-3';
        alertDiv.style.cssText = 'border-left: 4px solid #ffc107; background-color: #fff3cd;';
        alertDiv.innerHTML = `
            <i class="ri-lock-line me-2" style="font-size: 24px; color: #856404;"></i>
            <div style="flex: 1;">
                <strong style="color: #856404;">Tomorrow's Orders - Read-Only Mode</strong>
                <br>
                <span style="color: #856404; font-size: 0.9rem;">
                    You can view and print tomorrow's orders, but cannot mark them as packaged or modify notes/temperature until the delivery date.
                </span>
            </div>
        `;
        cardBody.insertBefore(alertDiv, cardBody.firstChild);
    }
    
    console.log('✅ Read-only mode enabled successfully');
}

// 🆕 INITIAL PAGE LOAD: Apply read-only mode if viewing tomorrow
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($isTomorrow): ?>
        applyReadOnlyMode();
    <?php else: ?>
        console.log('📅 Today view - Normal edit mode active');
    <?php endif; ?>
});

// Initialize auto-refresh on page load (robust initialization like chef dashboard)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        scheduleAutoRefresh();
    });
} else {
    // DOM already loaded, call immediately
    scheduleAutoRefresh();
}
</script>
