<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
/* Statistics Cards Styling - Matching Production Form Design */
.stat-card {
    padding: 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 8px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon i {
    font-size: 28px;
    color: white !important;
}

/* Allergen Info Styling */
.allergen-info {
    color: #856404 !important;
    background-color: #fff3cd;
    padding: 3px 6px;
    border-radius: 3px;
    display: inline-block;
    margin-top: 3px;
}

/* Item Comment Info Styling */
.item-comment-info {
    color: #0c5460 !important;
    background-color: #d1ecf1;
    padding: 3px 6px;
    border-radius: 3px;
    display: block;
    margin-top: 3px;
    border-left: 3px solid #17a2b8;
    font-style: italic;
}

/* Comments Row - Hide on screen, show in print */
.comments-row {
    display: none;
}

.suite-comments {
    background-color: #e7f3ff;
    border-left: 4px solid #2196F3;
    padding: 10px;
    margin: 5px 0;
}

.suite-comments strong {
    color: #1976D2;
    font-size: 11px;
}

.suite-comments p {
    margin: 5px 0 0 0;
    color: #424242;
    font-size: 10px;
    line-height: 1.4;
}

/* Print Styles */
@media print {
    @page {
        size: landscape;
        margin: 0.5cm;
    }
    
    /* Hide elements that shouldn't be printed */
    header, .topbar, #sidebar, #sidebar-overlay, nav, footer, .footer,
    button, .btn, .no-print {
        display: none !important;
    }
    
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
    }
    
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .page-content {
        margin: 0 !important;
        padding: 10px !important;
    }
    
    .container-fluid {
        padding: 0 !important;
        max-width: 100% !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-body {
        padding: 5px !important;
    }
    
    /* Preserve colors for printing */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    /* Show comments row in print */
    .comments-row {
        display: table-row !important;
        page-break-inside: avoid !important;
    }
    
    .comments-cell {
        border: 1px solid #dee2e6 !important;
        padding: 8px !important;
        background-color: #f8f9fa !important;
    }
    
    .suite-comments {
        background-color: #e7f3ff !important;
        border-left: 4px solid #2196F3 !important;
        padding: 8px !important;
        margin: 0 !important;
        page-break-inside: avoid !important;
    }
    
    .suite-comments strong {
        color: #1976D2 !important;
        font-size: 10px !important;
        font-weight: bold !important;
    }
    
    .suite-comments p {
        margin: 5px 0 0 0 !important;
        color: #424242 !important;
        font-size: 9px !important;
        line-height: 1.4 !important;
    }
    
    /* Allergen info styling for print */
    .allergen-info {
        color: #856404 !important;
        background-color: #fff3cd !important;
        padding: 2px 4px !important;
        border-radius: 2px !important;
        font-size: 8px !important;
        display: block !important;
        margin-top: 2px !important;
    }
    
    /* Item comment styling for print */
    .item-comment-info {
        color: #0c5460 !important;
        background-color: #d1ecf1 !important;
        padding: 2px 4px !important;
        border-radius: 2px !important;
        font-size: 8px !important;
        display: block !important;
        margin-top: 2px !important;
        border-left: 3px solid #17a2b8 !important;
    }
    
    /* Statistics Cards Print Styling */
    .order-statistics-summary {
        margin-bottom: 15px !important;
        page-break-inside: avoid !important;
    }
    
    .order-statistics-summary .row {
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 10px !important;
    }
    
    .order-statistics-summary .col-md-4 {
        flex: 1 !important;
        max-width: 33.33% !important;
    }
    
    .stat-card {
        padding: 12px 15px !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2) !important;
        page-break-inside: avoid !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
    }
    
    .stat-label {
        font-size: 10px !important;
        font-weight: 500 !important;
        margin-bottom: 4px !important;
    }
    
    .stat-number {
        font-size: 24px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
    }
    
    .stat-icon {
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .stat-icon i {
        font-size: 20px !important;
        color: white !important;
    }
    
    /* Make table fit better on print - landscape orientation */
    .table-responsive {
        overflow: visible !important;
    }
    
    .table {
        font-size: 9px !important;
        width: 100% !important;
        min-width: auto !important;
        table-layout: fixed !important;
    }
    
    .table th,
    .table td {
        padding: 4px 3px !important;
        font-size: 9px !important;
        line-height: 1.2 !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }
    
    /* First column (Suite + Patient Info) - wider to accommodate patient name and allergies */
    .table th:first-child,
    .table td:first-child {
        width: 100px !important;
        min-width: 100px !important;
        font-size: 8px !important;
        line-height: 1.3 !important;
        vertical-align: top !important;
    }
    
    /* Patient name styling in print */
    .table td:first-child .ri-user-line {
        font-size: 8px !important;
    }
    
    /* Patient allergies styling in print */
    .table td:first-child span[style*="background-color: #fff3cd"] {
        background-color: #fff3cd !important;
        color: #856404 !important;
        padding: 2px 4px !important;
        border-radius: 2px !important;
        font-size: 7px !important;
        display: block !important;
        margin-top: 2px !important;
        line-height: 1.2 !important;
    }
    
    .table td:first-child span[style*="background-color: #fff3cd"] .ri-alert-line {
        font-size: 7px !important;
    }
    
    /* Meal columns - equal width */
    .category-cell {
        width: auto !important;
        max-width: none !important;
        padding: 3px !important;
    }
    
    /* Reduce spacing in food items */
    .selected-menu-item {
        margin-bottom: 5px !important;
        padding-left: 4px !important;
    }
    
    .menu-category-header h6 {
        font-size: 8px !important;
        margin-bottom: 3px !important;
    }
    
    .selected-option {
        margin-bottom: 3px !important;
        padding: 2px !important;
    }
    
    .option-name {
        font-size: 8px !important;
        line-height: 1.1 !important;
    }
    
    .selected-option small {
        font-size: 7px !important;
    }
    
    /* Header styling */
    .card-title {
        font-size: 12px !important;
        margin-bottom: 5px !important;
    }
    
    h4.text-black {
        font-size: 14px !important;
        margin-bottom: 5px !important;
    }
    
    /* Hide button container */
    .col-sm-auto {
        display: none !important;
    }
    
    /* Remove extra spacing */
    .row {
        margin: 0 !important;
    }
    
    .col-sm {
        padding: 0 !important;
    }
}

input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}

/* Fix text wrapping for all table content */
.table-responsive {
    overflow-x: auto;
}

.table-responsive table {
    table-layout: fixed;
    width: 100%;
    min-width: 800px;
}

.table-responsive td,
.table-responsive th {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    vertical-align: top;
    padding: 8px;
    line-height: 1.3;
}

/* Specific column widths */
.table-responsive th:first-child,
.table-responsive td:first-child {
    width: 80px;
    min-width: 80px;
}

.table-responsive th:last-child,
.table-responsive td:last-child {
    width: 180px;
    min-width: 150px;
}

/* Category cells - meal columns */
.category-cell {
    width: 150px;
    min-width: 120px;
    max-width: 150px;
}

/* Fix text wrapping for menu items and allergen info */
.menu-item-card,
.menu-item-header,
.allergen-info,
.item-details {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    line-height: 1.3;
}

/* Notes column specific styling */
.notes-column {
    max-width: 180px;
}

.note-content {
    max-width: 100%;
    overflow-wrap: break-word;
    word-wrap: break-word;
    hyphens: auto;
    line-height: 1.4;
}

/* Fix text wrapping for all text elements */
.table-responsive small,
.table-responsive .text-muted,
.table-responsive .small,
.table-responsive span,
.table-responsive div {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    line-height: 1.3;
}

/* Prevent any element from extending beyond container */
.table-responsive * {
    max-width: 100%;
    box-sizing: border-box;
}

/* Enhanced Menu Item Styling */
.menu-item-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 8px;
    margin-bottom: 12px;
}

.menu-item-header h5 {
    color: #2c3e50 !important;
    font-size: 1.1rem;
    margin-bottom: 4px;
}

.menu-item-header .badge {
    font-size: 0.75rem;
    margin-right: 5px;
}

.form-check {
    transition: all 0.2s ease;
}

.form-check:hover {
    background-color: #e3f2fd !important;
    transform: translateX(2px);
}

.option-details .option-name {
    font-weight: 500;
    color: #495057;
}

.option-details small {
    font-size: 0.8rem;
    color: #6c757d;
}

.option-actions .view-more {
    text-decoration: none;
    padding: 2px 6px;
    border-radius: 3px;
    transition: background-color 0.2s ease;
}

.option-actions .view-more:hover {
    background-color: #e3f2fd;
}

.alreadyOrderedMenuItems {
    background-color: #d4edda !important;
    border-color: #28a745 !important;
}

.notalreadyOrderedMenuItems {
    background-color: #f8f9fa !important;
    border-color: #dee2e6 !important;
}

/* Table header styling */
.table-dark th {
    background-color: #495057 !important;
    color: white !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

/* Fix any white text issues - Force dark colors */
.category-cell,
.category-cell *,
.selected-menu-item,
.selected-menu-item *,
.selected-option,
.selected-option *,
.option-info,
.option-info * {
    color: #2c3e50 !important;
}

.menu-category-header h6 {
    color: #007bff !important;
    font-weight: 600 !important;
}

.option-name,
.option-name span {
    color: #2c3e50 !important;
    font-weight: 500 !important;
}

.selected-option small,
small.text-muted,
.text-muted small,
small,
.small {
    color: #6c757d !important;
}

/* Force ALL small text and calorie info to be visible */
small:not(.badge),
.d-block.text-muted,
.d-block small,
div small,
span small {
    color: #6c757d !important;
}

.text-muted.text-center {
    color: #adb5bd !important;
}

/* Ensure no white text anywhere in the table */
.table td,
.table td *:not(.text-muted) {
    color: #2c3e50 !important;
}

/* Suite cell styling */
td:first-child {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

/* Selected Menu Items Styling - CRITICAL: Text must stay in column */
.category-cell {
    vertical-align: top;
    padding: 10px;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    overflow: hidden;
    position: relative;
}

.selected-menu-item {
    border-left: 3px solid #007bff;
    padding-left: 8px;
    margin-bottom: 15px;
}

.menu-category-header h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #007bff !important;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.selected-option {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.selected-option:hover {
    background-color: #e3f2fd !important;
    transform: translateX(2px);
}

.option-name {
    font-size: 0.85rem;
    line-height: 1.3;
    color: #2c3e50 !important;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
    white-space: normal;
    display: block;
    width: 100%;
    max-width: 100%;
}

.selected-option small {
    font-size: 0.75rem;
    color: #6c757d !important;
}

/* Removed badge styling since we're not showing "Selected" text anymore */

/* No selection styling */
.text-muted.text-center {
    font-style: italic;
    color: #adb5bd !important;
}

/* Improve table cell spacing and prevent horizontal scroll */
.table td {
    padding: 10px 8px;
    vertical-align: top;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Make table responsive without horizontal scroll - CRITICAL FIX */
.table-responsive {
    overflow-x: auto !important;
    max-width: 100%;
}

.table {
    table-layout: fixed;
    width: 100%;
    min-width: 1200px; /* Minimum width to ensure readability */
}

/* Adjust column widths to prevent overflow - FIXED for text visibility */
.table th:first-child,
.table td:first-child {
    width: 120px;
    min-width: 120px;
}

.table th:not(:first-child):not(:last-child),
.table td:not(:first-child):not(:last-child) {
    width: calc((100% - 320px) / 6); /* More space for meal columns */
    min-width: 200px; /* Ensure minimum width for text visibility */
}

.table th:last-child,
.table td:last-child {
    width: 200px;
    min-width: 180px; /* Notes column */
}

/* Override any Bootstrap or framework white text */
.fw-bold,
.font-weight-bold,
span.fw-bold,
span.font-weight-bold {
    color: #2c3e50 !important;
}

.bg-light,
.bg-light *,
div.bg-light,
div.bg-light * {
    color: #2c3e50 !important;
}

/* Force all spans to be dark */
span:not(.badge):not(.text-muted) {
    color: #2c3e50 !important;
}

/* Universal text color fix - catch everything */
* {
    color: inherit;
}

.category-cell *:not(.text-muted):not(.badge) {
    color: #2c3e50 !important;
}

.category-cell .text-muted,
.category-cell small {
    color: #6c757d !important;
}

/* Better responsive behavior */
/* Notes Column Styling */
.notes-column {
    padding: 12px !important;
}

.notes-container {
    width: 100%;
}

.existing-notes .note-content {
    font-size: 0.85rem;
    line-height: 1.4;
    color: #495057 !important;
    background-color: #f8f9fa !important;
    border: 1px solid #dee2e6 !important;
}

@media (max-width: 1200px) {
    .table th:not(:first-child):not(:last-child),
    .table td:not(:first-child):not(:last-child) {
        width: calc((100% - 180px) / 6);
    }
    
    .notes-column {
        padding: 8px !important;
    }
    
    .option-name {
        font-size: 0.75rem;
    }
}


@media (max-width: 768px) {
    .table {
        min-width: 800px; /* Reduced for mobile but still readable */
    }
    
    .category-cell {
        padding: 8px;
    }
    
    .option-name {
        font-size: 0.75rem;
        color: #2c3e50 !important;
    }
    
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
         <h4 class="text-black"><?php echo  $department_name=  fetchDepartmentNameFromId($this->tenantDb, $deptId); ?></h4>
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                  
                    <div class="card-header border-bottom-dashed">

                       <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black">Date : <?php echo date('d-m-Y',strtotime($date)); ?></h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
          <div class="flex-shrink-0 me-2 d-flex gap-2">
           <button class="btn btn-primary btn" onclick="printPage()"><i class="mdi mdi-printer align-middle me-1"></i>Print</button>
           <a class="btn btn-danger btn" onclick="window.history.back()">Go Back</a>
           <!--<a href="<?php echo base_url('Orderportal/Order/viewInvoice/'.$orderId); ?>" class="btn btn-success btn"><i class="ri-download-2-fill align-middle me-1"></i>Download Invoice</a>-->
           <!--<a data-bs-toggle="modal" data-bs-target="#sendInvoiceModal" class="btn btn-danger btn"><i class="bx bx-mail-send align-middle me-1"></i>Send Invoice</a>-->
        </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Statistics Summary -->
                    <div class="card-body pb-3 pt-2 order-statistics-summary">
                        <?php
                        // ✅ FIX: Use metrics from controller (same calculation as Production Form)
                        // This ensures consistency between Production Form and Order Patientwise views
                        if (isset($metrics)) {
                            $totalOccupied = $metrics['occupied_suites'];
                            $totalOrdered = $metrics['suites_with_orders'];
                            $totalPending = $metrics['suites_without_orders'];
                        } else {
                            // Fallback to old calculation if metrics not provided (backward compatibility)
                            $totalOccupied = 0;
                            $totalOrdered = 0;
                            $totalPending = 0;
                            
                            if (isset($bedLists) && !empty($bedLists)) {
                                $occupiedSuites = [];
                                foreach ($bedLists as $bedList) {
                                    if (!empty($bedList['patient_name']) || !empty($bedList['ward_no'])) {
                                        $occupiedSuites[$bedList['id']] = true;
                                    }
                                }
                                $totalOccupied = count($occupiedSuites);
                                
                                $suitesWithOrders = [];
                                if (isset($patientOrderData) && !empty($patientOrderData)) {
                                    foreach ($patientOrderData as $orderKey => $orderOptions) {
                                        $parts = explode('_', $orderKey);
                                        if (isset($parts[0]) && isset($occupiedSuites[$parts[0]])) {
                                            $suitesWithOrders[$parts[0]] = true;
                                        }
                                    }
                                }
                                $totalOrdered = count($suitesWithOrders);
                            }
                            $totalPending = $totalOccupied - $totalOrdered;
                        }
                        ?>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="stat-card" style="background-color: #dbeafe;">
                                    <div class="stat-content">
                                        <div class="stat-label">Occupied Suites</div>
                                        <div class="stat-number"><?php echo $totalOccupied; ?></div>
                                    </div>
                    <div class="stat-icon" style="background-color: #3b82f6;">
                        <i class="mdi mdi-home-variant" style="color: white !important;"></i>
                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="stat-card" style="background-color: #d1fae5;">
                                    <div class="stat-content">
                                        <div class="stat-label">Suites Ordered</div>
                                        <div class="stat-number"><?php echo $totalOrdered; ?></div>
                                    </div>
                    <div class="stat-icon" style="background-color: #10b981;">
                        <i class="mdi mdi-check-circle" style="color: white !important;"></i>
                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="stat-card" style="background-color: #fed7aa;">
                                    <div class="stat-content">
                                        <div class="stat-label">Pending Suites</div>
                                        <div class="stat-number"><?php echo $totalPending; ?></div>
                                    </div>
                    <div class="stat-icon" style="background-color: #f97316;">
                        <i class="mdi mdi-clock-alert-outline" style="color: white !important;"></i>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   <div class="card-body table-responsive pt-0">
                        
                     <div class="row ">

                      <table class="table table-nowrap table-bordered table-striped mt-2">
                       <thead class="table-dark">
                        <tr>
                           <th>Suite </th>
                            <?php if(isset($categoryListData) && !empty($categoryListData)) {  ?>
                            <?php foreach($categoryListData as $categoryList){ ?>
                            <th><?php echo $categoryList['name'] ?></th>
                             <?php }  } ?>
                        </tr>
                      </thead>
                      <tbody>

                         <?php if(isset($bedLists) && !empty($bedLists)) {  ?>
                        <?php foreach($bedLists as $bedList){ ?>
                        
                        <tr>
                          <td>
                              <div style="line-height: 1.6;">
                                  <strong style="font-size: 1.1em; color: #2c3e50;">Suite <?php echo $bedList['bed_no']; ?></strong>
                                  
                                  <?php if (!empty($bedList['patient_name'])): ?>
                                      <br>
                                      <span style="color: #34495e; font-weight: 500;">
                                        <?php echo htmlspecialchars($bedList['patient_name']); ?>
                                      </span>
                                  <?php endif; ?>
                                  
                                  <?php 
                                  // Decode and display allergies
                                  if (!empty($bedList['patient_allergies'])) {
                                      $selected_allergies = [];
                                      if (is_array(json_decode($bedList['patient_allergies'], true))) {
                                          $selected_allergies = json_decode($bedList['patient_allergies'], true);
                                      } else {
                                          $selected_allergies = explode(',', $bedList['patient_allergies']);
                                      }
                                      
                                      // Get allergen names
                                      $allergyNames = [];
                                      if (!empty($allergensData) && is_array($allergensData)) {
                                          foreach ($allergensData as $allergy) {
                                              if (in_array($allergy['id'], $selected_allergies)) {
                                                  $allergyNames[] = $allergy['name'];
                                              }
                                          }
                                      }
                                      
                                      if (!empty($allergyNames)):
                                  ?>
                                      <br>
                                      <span style="background-color: #fff3cd; color: #856404; padding: 3px 8px; border-radius: 4px; font-size: 0.85em; display: inline-block; margin-top: 4px;">
                                          <i class="ri-alert-line"></i> <strong>Allergies:</strong> <?php echo htmlspecialchars(implode(', ', $allergyNames)); ?>
                                      </span>
                                  <?php 
                                      endif;
                                  } 
                                  ?>
                              </div>
                          </td>
                                
                     
                      

                        
        <?php if (isset($categoryListData) && !empty($categoryListData)) { ?>
    <?php foreach ($categoryListData as $categoryList) { ?>
        <td class="category-cell">
            <?php 
            $categoryID = $categoryList['id'];
            $hasOrdersInCategory = false;
            
            // Check if this bed has any orders in this category
            if (isset($patientOrderData) && !empty($patientOrderData)) {
                foreach ($patientOrderData as $orderKey => $orderOptions) {
                    if (strpos($orderKey, $bedList['id'] . '_' . $categoryID . '_') === 0) {
                        $hasOrdersInCategory = true;
                        break;
                    }
                }
            }
            
            if ($hasOrdersInCategory) {
                // Show selected items for this category
                foreach ($menuLists as $menu) {
                    if (is_array($menu['category_ids']) && in_array($categoryID, $menu['category_ids'])) {
                        $idIndex = $bedList['id'] . '_' . $categoryID . '_' . $menu['menu_id'];
                        
                        if (isset($patientOrderData[$idIndex]) && !empty($patientOrderData[$idIndex])) {
                            $selectedOptions = $patientOrderData[$idIndex];
                            ?>
                            <div class="selected-menu-item mb-3">
                                <div class="menu-category-header">
                                    <h6 class="text-primary mb-1"><?php echo htmlspecialchars($menu['menu_name']); ?></h6>
                                </div>
                                <div class="selected-options">
                                    <?php 
                                    if (isset($menu['menu_options']) && !empty($menu['menu_options'])) {
                                        foreach ($menu['menu_options'] as $menuOption) {
                                            if (in_array($menuOption['option_id'], $selectedOptions)) {
                                                ?>
                                                <div class="selected-option mb-2 p-2 bg-light rounded">
                                                    <div class="option-info">
                                                        <span class="option-name fw-bold text-dark"><?php echo htmlspecialchars($menuOption['menu_option_name']); ?></span>
                                                        <?php if (!empty($menuOption['menu_option_calorie']) && $menuOption['menu_option_calorie'] !== 'N/A') { ?>
                                                            <small class="d-block text-muted"><?php echo htmlspecialchars($menuOption['menu_option_calorie']); ?> cal</small>
                                                        <?php } ?>
                                                        <?php 
                                                        // Display allergens if available
                                                        if (!empty($menuOption['allergenValues'])) {
                                                            $allergenIds = json_decode($menuOption['allergenValues'], true);
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
                                                                if (!empty($allergenNames)) {
                                                                    ?>
                                                                    <small class="d-block text-warning allergen-info">
                                                                        ⚠️ <strong>Allergens:</strong> <?php echo htmlspecialchars(implode(', ', $allergenNames)); ?>
                                                                    </small>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                        // Display item-specific comment if available
                                                        if (isset($orderMenuOptions) && !empty($orderMenuOptions)) {
                                                            foreach ($orderMenuOptions as $opt) {
                                                                if ($opt['bed_id'] == $bedList['id'] && 
                                                                    $opt['menu_id'] == $menu['menu_id'] && 
                                                                    $opt['option_id'] == $menuOption['option_id'] && 
                                                                    !empty($opt['item_comment'])) {
                                                                    ?>
                                                                    <small class="d-block text-info item-comment-info" style="background-color: #d1ecf1; padding: 3px 6px; border-radius: 3px; margin-top: 3px; border-left: 3px solid #17a2b8;">
                                                                        💬 <strong>Note:</strong> <?php echo htmlspecialchars($opt['item_comment']); ?>
                                                                    </small>
                                                                    <?php
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            } else {
                // No orders in this category
                echo '<div class="text-muted text-center py-3"><i class="bx bx-minus"></i> No selection</div>';
            }
            ?>
        </td>
    <?php } ?>
<?php } ?>
                          
                        </tr>
                        
                        <?php 
                        // Add Comments/Notes row for this suite (for print)
                        if (isset($orderCommentBedWise[$bedList['id']]) && !empty(trim($orderCommentBedWise[$bedList['id']]))) {
                            $colspanCount = isset($categoryListData) && !empty($categoryListData) ? (1 + count($categoryListData)) : 1; // Suite column + all category columns
                            ?>
                            <tr class="comments-row print-only">
                                <td colspan="<?php echo $colspanCount; ?>" class="comments-cell" style="border: 1px solid #dee2e6; padding: 10px;">
                                    <div class="suite-comments">
                                        <strong>📝 Notes/Comments for Suite <?php echo $bedList['bed_no']; ?>:</strong>
                                        <p><?php echo nl2br(htmlspecialchars($orderCommentBedWise[$bedList['id']])); ?></p>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                        <?php }  } ?>
                    </tbody>
                </table> 
            
                    
                    </div>
                 
   

                       
                    </div>
                 
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


<div class="modal fade" id="sendInvoiceModal" tabindex="-1" aria-labelledby="sendInvoiceModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalgridLabel">Send Invoice</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="javascript:void(0);">
                                                            <div class="row g-3">
                                                                <div class="">
                                                                    <label for="emailInput" class="form-label">Email</label>
                                                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter email to send invoice to">
                                                                </div>
                                                             
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                        <a class="btn btn-success"><i class="ri-mail-check-line"></i> Send Email</a>
                                                                    </div>
                                                                </div>
                                                                <!--end col-->
                                                            </div>
                                                            <!--end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



<script type="text/javascript">

// Print Page Function
function printPage() {
    window.print();
}

// Auto-refresh Order Package Information page every 15 minutes
function scheduleAutoRefresh() {
    const refreshInterval = 15 * 60 * 1000; // 15 minutes in milliseconds
    
    console.log('🔄 Order Package Information Auto-Refresh: Enabled (Every 15 minutes)');
    console.log(`⏰ Next refresh scheduled in 15 minutes at ${new Date(Date.now() + refreshInterval).toLocaleTimeString('en-AU')}`);
    
    // Set interval to refresh every 15 minutes
    setInterval(function() {
        console.log('🔄 Auto-refreshing Order Package Information (15-minute interval)...');
        
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
            <div style="font-size: 14px; opacity: 0.9;">Order Package Information will reload in 3 seconds...</div>
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