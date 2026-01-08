
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
.py-2\.5 {
    padding-top: 0.625rem !important;
    padding-bottom: 0.625rem !important;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Force white icons in suite cards - Override all global styles */
.suite-card-icon {
    color: #ffffff !important;
    fill: #ffffff !important;
}

.suite-card-icon i,
.suite-card-icon .fas,
.suite-card-icon .fa,
.suite-card-icon svg,
.suite-card-icon svg path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

/* Target FontAwesome SVG specifically */
.suite-card-icon .svg-inline--fa,
.suite-card-icon .svg-inline--fa path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

/* Force specific colors for small icons */
.suite-small-icon-blue,
.suite-small-icon-blue svg,
.suite-small-icon-blue svg path,
.suite-small-icon-blue .svg-inline--fa,
.suite-small-icon-blue .svg-inline--fa path {
    color: #1976d2 !important;
    fill: #1976d2 !important;
}

.suite-small-icon-green,
.suite-small-icon-green svg,
.suite-small-icon-green svg path,
.suite-small-icon-green .svg-inline--fa,
.suite-small-icon-green .svg-inline--fa path {
    color: #198754 !important;
    fill: #198754 !important;
}

.suite-small-icon-red,
.suite-small-icon-red svg,
.suite-small-icon-red svg path,
.suite-small-icon-red .svg-inline--fa,
.suite-small-icon-red .svg-inline--fa path {
    color: #dc3545 !important;
    fill: #dc3545 !important;
}

.suite-small-icon-orange,
.suite-small-icon-orange svg,
.suite-small-icon-orange svg path,
.suite-small-icon-orange .svg-inline--fa,
.suite-small-icon-orange .svg-inline--fa path {
    color: #f57c00 !important;
    fill: #f57c00 !important;
}

/* Fix all button icons to be white */
button i,
button svg,
button svg path,
button .svg-inline--fa,
button .svg-inline--fa path {
    color: inherit !important;
    fill: currentColor !important;
}

/* Specific button color fixes */
.bg-blue-600 i,
.bg-blue-600 svg,
.bg-blue-600 svg path,
.bg-blue-600 .svg-inline--fa,
.bg-blue-600 .svg-inline--fa path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

.bg-primary-600 i,
.bg-primary-600 svg,
.bg-primary-600 svg path,
.bg-primary-600 .svg-inline--fa,
.bg-primary-600 .svg-inline--fa path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

.bg-green-600 i,
.bg-green-600 svg,
.bg-green-600 svg path,
.bg-green-600 .svg-inline--fa,
.bg-green-600 .svg-inline--fa path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

/* Edit and delete button icons */
.edit-suite-btn i,
.edit-suite-btn svg,
.edit-suite-btn svg path,
.edit-suite-btn .svg-inline--fa,
.edit-suite-btn .svg-inline--fa path {
    color: #16a34a !important;
    fill: #16a34a !important;
}

.delete-suite-btn i,
.delete-suite-btn svg,
.delete-suite-btn svg path,
.delete-suite-btn .svg-inline--fa,
.delete-suite-btn .svg-inline--fa path {
    color: #dc2626 !important;
    fill: #dc2626 !important;
}

.reactivate-suite-btn i,
.reactivate-suite-btn svg,
.reactivate-suite-btn svg path,
.reactivate-suite-btn .svg-inline--fa,
.reactivate-suite-btn .svg-inline--fa path {
    color: #2563eb !important;
    fill: #2563eb !important;
}

.transfer-suite-btn i,
.transfer-suite-btn svg,
.transfer-suite-btn svg path,
.transfer-suite-btn .svg-inline--fa,
.transfer-suite-btn .svg-inline--fa path {
    color: #f57c00 !important;
    fill: #f57c00 !important;
}

/* Transfer modal button styling */
#confirm-transfer-suite {
    background-color: #f57c00 !important;
    color: #ffffff !important;
    border: none !important;
}

#confirm-transfer-suite:hover {
    background-color: #e65100 !important;
    color: #ffffff !important;
}

#confirm-transfer-suite:disabled {
    background-color: #ccc !important;
    color: #666 !important;
}

#confirm-transfer-suite i,
#confirm-transfer-suite svg,
#confirm-transfer-suite svg path,
#confirm-transfer-suite .svg-inline--fa,
#confirm-transfer-suite .svg-inline--fa path {
    color: #ffffff !important;
    fill: #ffffff !important;
}

/* Status circle icons */
.text-red-500 i,
.text-red-500 svg,
.text-red-500 svg path,
.text-red-500 .svg-inline--fa,
.text-red-500 .svg-inline--fa path {
    color: #ef4444 !important;
    fill: #ef4444 !important;
}

.text-green-500 i,
.text-green-500 svg,
.text-green-500 svg path,
.text-green-500 .svg-inline--fa,
.text-green-500 .svg-inline--fa path {
    color: #22c55e !important;
    fill: #22c55e !important;
}

/* Modal close button */
.text-gray-600 i,
.text-gray-600 svg,
.text-gray-600 svg path,
.text-gray-600 .svg-inline--fa,
.text-gray-600 .svg-inline--fa path {
    color: #4b5563 !important;
    fill: #4b5563 !important;
}

/* Filter panel animations */
#filter-panel {
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

/* Filter button transitions */
#filter-toggle {
    transition: all 0.2s ease-in-out;
}

/* Ensure consistent height for all filter form elements */
#filter-panel select,
#filter-panel input[type="text"],
#filter-panel button {
    height: 40px !important;
    line-height: 1.25 !important;
    box-sizing: border-box !important;
}

#filter-panel select {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

#filter-panel input[type="text"] {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

/* Beautiful Status Radio Buttons */
.status-radio {
    width: 18px !important;
    height: 18px !important;
    cursor: pointer;
    border: 2px solid #dee2e6 !important;
    transition: all 0.3s ease;
    margin: 0 !important;
    flex-shrink: 0;
}

.status-label {
    cursor: pointer;
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    background: transparent;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    min-width: 70px;
    text-align: center;
    line-height: 1;
}

.status-label:hover {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 20px;
}

/* All Radio Button Styling */
.status-radio-all {
    border-color: #0d6efd !important;
}

.status-radio-all:checked {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

.status-label-all {
    color: #0d6efd !important;
    font-weight: 500;
}

.status-radio-all:checked + .status-label-all {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 1px solid #0d6efd;
    color: #0d6efd !important;
    font-weight: 600;
}

/* Occupied Radio Button Styling */
.status-radio-occupied {
    border-color: #198754 !important;
}

.status-radio-occupied:checked {
    background-color: #198754 !important;
    border-color: #198754 !important;
}

.status-label-occupied {
    color: #198754 !important;
    font-weight: 500;
}

.status-radio-occupied:checked + .status-label-occupied {
    background: linear-gradient(135deg, #e8f5e8 0%, #c3e6c3 100%);
    border: 1px solid #198754;
    color: #198754 !important;
    font-weight: 600;
}

/* Vacant Radio Button Styling */
.status-radio-vacant {
    border-color: #dc3545 !important;
}

.status-radio-vacant:checked {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.status-label-vacant {
    color: #dc3545 !important;
    font-weight: 500;
}

.status-radio-vacant:checked + .status-label-vacant {
    background: linear-gradient(135deg, #fdeaea 0%, #f8d7da 100%);
    border: 1px solid #dc3545;
    color: #dc3545 !important;
    font-weight: 600;
}

/* Radio button focus states */
.status-radio:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.status-radio-occupied:focus {
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
}

.status-radio-vacant:focus {
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-12">
                    </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 text-black">
                                    <?php if (isset($show_deleted) && $show_deleted): ?>
                                        Deleted Suites
                                    <?php else: ?>
                                        Manage Suites
                                    <?php endif; ?>
                                </h4>
                                <div class="page-title-right">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="d-flex justify-content-sm-end gap-2">
                                            <?php if (isset($show_deleted) && $show_deleted): ?>
                                                <a class="btn btn-outline-primary btn" href="<?php echo base_url('Orderportal/Hospitalconfig/List') ?>">
                                                    <i class="fas fa-eye me-1"></i>View Active Suites
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-outline-warning btn" href="<?php echo base_url('Orderportal/Hospitalconfig/List?show_deleted=1') ?>">
                                                    <i class="fas fa-trash-restore me-1"></i>View Deleted Suites
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!isset($show_deleted) || !$show_deleted): ?>
                                                <a class="btn btn-danger btn" href="<?php echo base_url('Orderportal/Hospitalconfig/addBed') ?>">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Suite
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">


                <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600"></div>
                </div>

                <section id="suites-section">
                    <!-- Mobile-first responsive filter layout -->
                    <div class="row g-3 mb-4 align-items-center">
                        <!-- Status Radio Buttons - Full width on mobile, auto on larger screens -->
                        <div class="col-12 col-lg-auto">
                            <div class="d-flex flex-wrap align-items-center gap-3 justify-content-center justify-content-lg-start">
                                <!-- All Radio Button -->
                                <div class="form-check d-flex align-items-center m-0">
                                    <input class="form-check-input status-radio status-radio-all me-2" type="radio" name="statusFilter" id="statusAll" value="all" checked>
                                    <label class="form-check-label status-label status-label-all mb-0" for="statusAll">
                                        <span class="fw-medium">All</span>
                                    </label>
                                </div>
                                
                                <!-- Occupied Radio Button -->
                                <div class="form-check d-flex align-items-center m-0">
                                    <input class="form-check-input status-radio status-radio-occupied me-2" type="radio" name="statusFilter" id="statusOccupied" value="occupied">
                                    <label class="form-check-label status-label status-label-occupied mb-0" for="statusOccupied">
                                        <span class="fw-medium">Occupied</span>
                                    </label>
                                </div>
                                
                                <!-- Vacant Radio Button -->
                                <div class="form-check d-flex align-items-center m-0">
                                    <input class="form-check-input status-radio status-radio-vacant me-2" type="radio" name="statusFilter" id="statusVacant" value="vacant">
                                    <label class="form-check-label status-label status-label-vacant mb-0" for="statusVacant">
                                        <span class="fw-medium">Vacant</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Controls - Responsive layout -->
                        <div class="col-12 col-lg">
                            <div class="row g-2 align-items-center justify-content-center justify-content-lg-end">
                                <!-- Floor Filter -->
                                <div class="col-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="floor-filter" class="text-sm font-medium text-gray-700 mb-0 text-nowrap">Floor:</label>
                                        <select id="floor-filter" class="form-select form-select-sm" style="min-width: 120px;">
                                            <option value="">All Floors</option>
                                            <?php if (!empty($floorLists)) : ?>
                                                <?php foreach ($floorLists as $floorList) : ?>
                                                    <option value="<?php echo htmlspecialchars($floorList['id']); ?>">
                                                        <?php echo htmlspecialchars($floorList['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Suite Number Search -->
                                <div class="col-auto">
                                    <input type="text" id="suite-search" placeholder="Search by suite number..." class="form-control form-control-sm" style="min-width: 200px;">
                                </div>

                                <!-- Clear Button -->
                                <div class="col-auto">
                                    <button id="clear-filters" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Suite Statistics Cards -->
                    <div class="row mb-4">
                        <!-- Total Suites Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card card-animate" style="background: linear-gradient(135deg, #f8faff 0%, #f1f5ff 100%); border: 1px solid #e3f2fd; border-radius: 16px; box-shadow: 0 4px 20px rgba(33, 150, 243, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(63, 81, 181, 0.1) 100%); border-radius: 50%;"></div>
                                <div class="card-body" style="padding: 2rem; position: relative;">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center justify-content-center suite-card-icon" style="width: 64px; height: 64px; background: linear-gradient(135deg, #2196f3 0%, #3f51b5 100%); border-radius: 16px; box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);">
                                            <i class="fas fa-building suite-card-icon" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="text-end">
                                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #1976d2; letter-spacing: 1px;">
                                                <?php if (isset($show_deleted) && $show_deleted): ?>
                                                    Deleted Suites
                                                <?php else: ?>
                                                    Total Suites
                                    <?php endif; ?>
                                            </p>
                                            <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #ffffff; background: linear-gradient(135deg, #2196f3, #1976d2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 2px 4px rgba(33, 150, 243, 0.3); line-height: 1;"><?php echo count($bedLists); ?></h2>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center" style="color: #1976d2;">
                                        <i class="fas fa-chart-line me-2 suite-small-icon-blue" style="font-size: 0.875rem;"></i>
                                        <span style="font-size: 0.875rem; font-weight: 500;">All available suites</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vacant Suites Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card card-animate" style="background: linear-gradient(135deg, #fdeaea 0%, #f8d7da 100%); border: 1px solid #f5c6cb; border-radius: 16px; box-shadow: 0 4px 20px rgba(220, 53, 69, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(200, 35, 51, 0.1) 100%); border-radius: 50%;"></div>
                                <div class="card-body" style="padding: 2rem; position: relative;">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center justify-content-center suite-card-icon" style="width: 64px; height: 64px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 16px; box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);">
                                            <i class="fas fa-door-open suite-card-icon" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="text-end">
                                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #c82333; letter-spacing: 1px;">Vacant Suites</p>
                                            <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #ffffff; background: linear-gradient(135deg, #dc3545, #c82333); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 2px 4px rgba(220, 53, 69, 0.3); line-height: 1;">
                                                <?php echo count(array_filter($bedLists, function($bed) { 
                                                    return $bed['is_vaccant'] == 1; 
                                                })); ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center" style="color: #c82333;">
                                        <i class="fas fa-check-circle me-2 suite-small-icon-red" style="font-size: 0.875rem;"></i>
                                        <span style="font-size: 0.875rem; font-weight: 500;">Ready for occupancy</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Occupied Suites Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card card-animate" style="background: linear-gradient(135deg, #e8f5e8 0%, #c3e6c3 100%); border: 1px solid #c8e6c9; border-radius: 16px; box-shadow: 0 4px 20px rgba(25, 135, 84, 0.1); transition: all 0.3s ease; position: relative; overflow: hidden;">
                                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%); border-radius: 50%;"></div>
                                <div class="card-body" style="padding: 2rem; position: relative;">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center justify-content-center suite-card-icon" style="width: 64px; height: 64px; background: linear-gradient(135deg, #198754 0%, #20c997 100%); border-radius: 16px; box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);">
                                            <i class="fas fa-users suite-card-icon" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="text-end">
                                            <p class="text-uppercase fw-bold mb-1" style="font-size: 0.75rem; color: #198754; letter-spacing: 1px;">Occupied Suites</p>
                                            <h2 class="fw-bold mb-0" style="font-size: 2.5rem; color: #ffffff; background: linear-gradient(135deg, #198754, #20c997); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 2px 4px rgba(25, 135, 84, 0.3); line-height: 1;">
                                                <?php 
                                                    echo isset($bedLists) && is_array($bedLists) 
                                                        ? count(array_filter($bedLists, function($bed) { return $bed['is_vaccant'] == 0; })) 
                                                        : 0; 
                                                ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center" style="color: #198754;">
                                        <i class="fas fa-user-check me-2 suite-small-icon-green" style="font-size: 0.875rem;"></i>
                                        <span style="font-size: 0.875rem; font-weight: 500;">Currently in use</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Suite Statistics Cards -->

                    <div id="suites-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                        <?php if (!empty($bedLists)) : ?>
                            <?php foreach ($bedLists as $index => $bedList) : ?>
                                <?php
                             
                                // Use array_filter to find the floor name based on floor ID
                                $floor = array_filter($floorLists, function ($fl) use ($bedList) {
                                    return $fl['id'] == $bedList['floor'];
                                });
                                $floorName = !empty($floor) ? reset($floor)['name'] : 'Unknown Floor';
                                ?>
                                <div id="suite-card-<?php echo $index; ?>" class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 relative overflow-hidden" data-floor="<?php echo $bedList['floor'] ?>">
                                    <!-- Card Content -->
                                    <div class="p-6">
                                        <!-- Row 1: Status + Action Buttons -->
                                        <div class="flex items-center justify-between mb-4">
                                            <?php if (isset($show_deleted) && $show_deleted): ?>
                                                <!-- Deleted suite status -->
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                    <i class="fa-solid fa-trash text-gray-500 text-xs mr-2"></i>
                                                    Deleted
                                                </span>
                                                
                                                <div class="flex space-x-2">
                                                    <button class="reactivate-suite-btn bg-white text-blue-600 hover:bg-blue-600 hover:text-white w-8 h-8 rounded-full shadow-sm border border-gray-200 flex items-center justify-center transition-all duration-200" data-suite-id="<?php echo $bedList['suite_id']; ?>" data-suite-name="Suite <?php echo htmlspecialchars($bedList['bed_no']); ?>" title="Reactivate Suite">
                                                        <i class="fa-solid fa-undo text-sm"></i>
                                        </button>
                                    </div>
                                            <?php else: ?>
                                                <!-- Active suite status -->
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                                    <i class="fa-solid fa-circle <?php echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'text-red-500' : 'text-green-500' ?> text-xs mr-2"></i>
                                            <?php echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'Vacant' : 'Occupied' ?>
                                        </span>
                                                
                                                <div class="flex space-x-2">
                                                    <?php if (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 0) { ?>
                                                        <!-- Transfer icon only for occupied suites -->
                                                        <button class="transfer-suite-btn bg-white text-orange-600 hover:bg-orange-600 hover:text-white w-8 h-8 rounded-full shadow-sm border border-gray-200 flex items-center justify-center transition-all duration-200" data-suite-id="<?php echo $bedList['suite_id']; ?>" data-suite-number="<?php echo htmlspecialchars($bedList['bed_no']); ?>" title="Transfer Client">
                                                            <i class="fa-solid fa-exchange-alt text-sm"></i>
                                                        </button>
                                                    <?php } ?>
                                                    <button class="edit-suite-btn bg-white text-green-600 hover:bg-green-600 hover:text-white w-8 h-8 rounded-full shadow-sm border border-gray-200 flex items-center justify-center transition-all duration-200" data-suite-id="<?php echo $bedList['suite_id']; ?>">
                                                        <i class="fa-solid fa-edit text-sm"></i>
                                                    </button>
                                                    <?php 
                                                    // ✅ FIX: Hide delete button for nurses (role 3)
                                                    $userRole = isset($userRole) ? $userRole : 0;
                                                    if ($userRole != 3): ?>
                                                    <button class="delete-suite-btn bg-white text-red-600 hover:bg-red-600 hover:text-white w-8 h-8 rounded-full shadow-sm border border-gray-200 flex items-center justify-center transition-all duration-200" data-suite-id="<?php echo $bedList['suite_id']; ?>">
                                                        <i class="fa-solid fa-trash text-sm"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Row 2: Bed Icon + Suite Name -->
                                        <div class="flex items-center space-x-3 mb-4">
                                            <?php if (isset($show_deleted) && $show_deleted): ?>
                                                <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-bed text-gray-500 text-lg"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-lg <?php echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'bg-red-50' : 'bg-green-50' ?> flex items-center justify-center">
                                                    <i class="fa-solid fa-bed <?php echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'text-red-500' : 'text-green-500' ?> text-lg"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900">
                                                    Suite <?php echo htmlspecialchars($bedList['bed_no']); ?>
                                                </h3>
                                                <?php if (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 0 && !empty($bedList['patient_name'])): ?>
                                                    <div class="text-base font-bold text-gray-700 mt-1">
                                                        <?php echo htmlspecialchars($bedList['patient_name']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Row 3: Floor Information -->
                                        <div class="mb-6 p-3 bg-gray-50 rounded-lg border-l-4 <?php 
                                            if (isset($show_deleted) && $show_deleted) {
                                                echo 'border-gray-400';
                                            } else {
                                                echo (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) ? 'border-red-400' : 'border-green-400';
                                            }
                                        ?>">
                                            <div class="flex items-center">
                                                <i class="fa-solid fa-building text-gray-600 mr-2"></i>
                                                <span class="text-gray-700 font-medium">Floor: <?php echo htmlspecialchars($floorName); ?></span>
                                            </div>
                                        </div>

                                        <!-- Row 4: Action Buttons -->
                                        <?php if (isset($show_deleted) && $show_deleted): ?>
                                            <!-- Deleted suite actions -->
                                            <div class="space-y-3">
                                                <button class="reactivate-suite-btn w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center" data-suite-id="<?php echo $bedList['suite_id']; ?>" data-suite-name="Suite <?php echo htmlspecialchars($bedList['bed_no']); ?>">
                                                    <i class="fa-solid fa-undo mr-2"></i>Reactivate Suite
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <!-- Active suite actions -->
                                            <div class="space-y-3">
                                                <?php if (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 0) { ?>
                                                    <!-- Show View Details only for occupied suites -->
                                                    <a href="/Orderportal/Hospitalconfig/viewSuite/<?php echo $bedList['suite_id']; ?>" class="block">
                                                        <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center">
                                                            <i class="fa-solid fa-eye mr-2"></i>View Details
                                                        </button>
                                                    </a>
                                                <?php } ?>
                                                <?php if (isset($bedList['is_vaccant']) && $bedList['is_vaccant'] == 1) { ?>
                                                    <!-- Show Onboard Client only for vacant suites -->
                                                    <a href="/Orderportal/Patient/onboardingForm/<?php echo $bedList['suite_id']; ?>/suite" class="block">
                                                        <button class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center justify-center">
                                                            <i class="fa-solid fa-user-plus mr-2"></i>Onboard Client
                                                        </button>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p class="text-center text-gray-500">No suites available.</p>
                        <?php endif; ?>
                    </div>
                </section>
                        </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- Edit Suite Modal - Removed as we now use full form -->

            <!-- Delete Confirmation Modal -->
            <div id="delete-suite-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Confirm Delete</h3>
                        <button id="close-delete-modal" class="text-gray-600 hover:text-gray-800">
                            <i class="fa-solid fa-times text-xl"></i>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete this suite?</p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancel-delete-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">Cancel</button>
                        <button id="confirm-delete-suite" class="px-4 py-2 bg-danger text-white rounded-md hover:bg-danger text-sm">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Transfer Client Modal -->
            <div id="transfer-suite-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Transfer Client</h3>
                        <button id="close-transfer-modal" class="text-gray-600 hover:text-gray-800">
                            <i class="fa-solid fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Transfer client from:</p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center">
                                <i class="fa-solid fa-bed text-blue-600 mr-2"></i>
                                <span class="font-medium text-blue-800" id="current-suite-name">Suite 301</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Select destination suite:</p>
                        <select id="destination-suite-select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a vacant suite...</option>
                        </select>
                    </div>
                    <div class="flex justify-end items-center">
                        <div class="flex space-x-3">
                            <button id="cancel-transfer-modal" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">Cancel</button>
                            <button id="confirm-transfer-suite" class="px-4 py-2 text-white rounded-md text-sm flex items-center font-medium" style="background-color: #f57c00; border: none;">
                                <i class="fa-solid fa-exchange-alt mr-2"></i>Transfer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const floorSelect = document.getElementById('floors');
    const suiteCards = document.querySelectorAll('#suites-grid [id^="suite-card-"]');

    floorSelect.addEventListener('change', function() {
        const selectedFloor = this.value;

        suiteCards.forEach(card => {
            const cardFloor = card.getAttribute('data-floor');
            if (selectedFloor === '0' || selectedFloor === cardFloor) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Suite Button - Redirect to full form
    document.querySelectorAll('.edit-suite-btn').forEach(button => {
        button.addEventListener('click', function () {
            const suiteId = this.getAttribute('data-suite-id');
            // console.log("suiteId", suiteId);
            
            // Redirect to the full add/edit form with the suite ID
            window.location.href = '<?php echo site_url('Orderportal/Hospitalconfig/addBed/'); ?>' + suiteId;
        });
    });

    // Modal-related code removed as we now use full form

    // Delete Suite Button
    let deleteSuiteId = null;
    document.querySelectorAll('.delete-suite-btn').forEach(button => {
        button.addEventListener('click', function () {
            deleteSuiteId = this.getAttribute('data-suite-id');
            
            document.getElementById('delete-suite-modal').classList.remove('hidden');
        });
    });

    // Close Delete Modal
    document.getElementById('close-delete-modal').addEventListener('click', function () {
        document.getElementById('delete-suite-modal').classList.add('hidden');
    });
    document.getElementById('cancel-delete-modal').addEventListener('click', function () {
        document.getElementById('delete-suite-modal').classList.add('hidden');
    });

    // Confirm Delete
    document.getElementById('confirm-delete-suite').addEventListener('click', function () {
        if (deleteSuiteId) {
            fetch('<?php echo site_url('Orderportal/Hospitalconfig/deleteBed'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                body: 'id=' + encodeURIComponent(deleteSuiteId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('delete-suite-modal').classList.add('hidden');
                    window.location.reload(); // Reload to update the suite list
                } else {
                    alert('Failed to delete suite: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error deleting suite:', error);
                alert('An error occurred while deleting the suite.');
            });
        }
    });

    // Reactivate Suite Button
    document.querySelectorAll('.reactivate-suite-btn').forEach(button => {
        button.addEventListener('click', function () {
            const suiteId = this.getAttribute('data-suite-id');
            const suiteName = this.getAttribute('data-suite-name') || 'Suite';
            
            Swal.fire({
                title: 'Reactivate Suite?',
                text: `Are you sure you want to reactivate ${suiteName}? It will become available for use again.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reactivate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Reactivating...',
                        text: 'Please wait while we reactivate the suite.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch('<?php echo site_url('Orderportal/Hospitalconfig/reactivateSuite'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                        body: 'id=' + encodeURIComponent(suiteId)
                    })
                    .then(response => {
                        // Check if response is ok
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Server returned non-JSON response: ' + contentType);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message || 'Suite reactivated successfully',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                window.location.reload(); // Reload to update the suite list
                            });
                        } else {
                            Swal.fire({
                                title: 'Reactivation Failed',
                                text: data.message || 'Unknown error occurred',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error reactivating suite:', error);
                        Swal.fire({
                            title: 'Network Error',
                            text: 'Failed to connect to server. Please check your connection and try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                            footer: 'Error details: ' + error.message
                        });
                    });
                }
            });
        });
    });

    // Filter Functionality
    const statusRadios = document.querySelectorAll('input[name="statusFilter"]');
    const floorFilter = document.getElementById('floor-filter');
    const suiteSearch = document.getElementById('suite-search');
    const clearFilters = document.getElementById('clear-filters');

    // Apply filters function
    function applyFilterFunction() {
        // Get selected radio button value
        const selectedStatusRadio = document.querySelector('input[name="statusFilter"]:checked');
        const statusValue = selectedStatusRadio ? selectedStatusRadio.value : 'all';
        const floorValue = floorFilter ? floorFilter.value : '';
        const searchValue = suiteSearch ? suiteSearch.value.toLowerCase() : '';
        
        const suiteCards = document.querySelectorAll('#suites-grid > div');
        let visibleCount = 0;
        
        suiteCards.forEach(card => {
            let showCard = true;
            
            // Status filter
            if (statusValue && statusValue !== 'all') {
                const statusBadge = card.querySelector('.inline-flex');
                if (statusBadge) {
                    const isVacant = statusBadge.textContent.trim().toLowerCase().includes('vacant');
                    const isOccupied = statusBadge.textContent.trim().toLowerCase().includes('occupied');
                    
                    if (statusValue === 'vacant' && !isVacant) showCard = false;
                    if (statusValue === 'occupied' && !isOccupied) showCard = false;
                }
            }
            
            // Floor filter
            if (floorValue && showCard) {
                const cardFloor = card.getAttribute('data-floor');
                if (cardFloor !== floorValue) showCard = false;
            }
            
            // Suite number search
            if (searchValue && showCard) {
                const suiteTitle = card.querySelector('h3');
                if (suiteTitle) {
                    const suiteNumber = suiteTitle.textContent.toLowerCase();
                    if (!suiteNumber.includes(searchValue)) showCard = false;
                }
            }
            
            // Show/hide card
            if (showCard) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update statistics based on visible cards
        updateFilteredStatistics();
    }

    // Update statistics for filtered results
    function updateFilteredStatistics() {
        const visibleCards = document.querySelectorAll('#suites-grid > div[style="display: block"], #suites-grid > div:not([style*="display: none"])');
        let totalVisible = 0;
        let vacantVisible = 0;
        let occupiedVisible = 0;
        
        visibleCards.forEach(card => {
            if (card.style.display !== 'none') {
                totalVisible++;
                const statusBadge = card.querySelector('.inline-flex');
                if (statusBadge && statusBadge.textContent.trim().toLowerCase().includes('vacant')) {
                    vacantVisible++;
                } else {
                    occupiedVisible++;
                }
            }
        });
        
        // Update the statistics cards (optional - you can uncomment if you want filtered stats)
        // document.querySelector('.col-xl-4:nth-child(1) h2').textContent = totalVisible;
        // document.querySelector('.col-xl-4:nth-child(2) h2').textContent = vacantVisible;
        // document.querySelector('.col-xl-4:nth-child(3) h2').textContent = occupiedVisible;
    }

    // Clear all filters
    function clearAllFilters() {
        // Reset radio buttons to "All"
        const allRadio = document.getElementById('statusAll');
        if (allRadio) allRadio.checked = true;
        
        if (floorFilter) floorFilter.value = '';
        if (suiteSearch) suiteSearch.value = '';
        
        // Show all cards
        const suiteCards = document.querySelectorAll('#suites-grid > div');
        suiteCards.forEach(card => {
            card.style.display = 'block';
        });
        
        updateFilteredStatistics();
    }

    // Event listeners
    if (clearFilters) {
        clearFilters.addEventListener('click', clearAllFilters);
    }
    
    // Real-time search for suite number
    if (suiteSearch) {
        suiteSearch.addEventListener('input', function() {
            applyFilterFunction();
        });
    }
    
    // Auto-apply when radio buttons change
    statusRadios.forEach(radio => {
        radio.addEventListener('change', applyFilterFunction);
    });
    
    // Auto-apply when floor dropdown changes
    if (floorFilter) {
        floorFilter.addEventListener('change', applyFilterFunction);
    }

    // Transfer Suite Functionality
    let transferSuiteId = null;
    let transferSuiteNumber = null;

    // Transfer Suite Button
    document.querySelectorAll('.transfer-suite-btn').forEach(button => {
        button.addEventListener('click', function () {
            transferSuiteId = this.getAttribute('data-suite-id');
            transferSuiteNumber = this.getAttribute('data-suite-number');
            
            // Update modal with current suite info
            document.getElementById('current-suite-name').textContent = 'Suite ' + transferSuiteNumber;
            
            // Debug button removed
            
            // Load vacant suites
            loadVacantSuites();
            
            // Show modal
            document.getElementById('transfer-suite-modal').classList.remove('hidden');
        });
    });

    // Debug functionality removed

    // Close Transfer Modal
    document.getElementById('close-transfer-modal').addEventListener('click', function () {
        document.getElementById('transfer-suite-modal').classList.add('hidden');
        resetTransferModal();
    });
    
    document.getElementById('cancel-transfer-modal').addEventListener('click', function () {
        document.getElementById('transfer-suite-modal').classList.add('hidden');
        resetTransferModal();
    });

    // Load vacant suites for dropdown
    function loadVacantSuites() {
        fetch('<?php echo site_url('Orderportal/Hospitalconfig/getVacantSuites'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            body: 'current_suite_id=' + encodeURIComponent(transferSuiteId)
        })
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('destination-suite-select');
            select.innerHTML = '<option value="">Select a vacant suite...</option>';
            
            if (data.status === 'success' && data.suites) {
                data.suites.forEach(suite => {
                    const option = document.createElement('option');
                    option.value = suite.id;
                    option.textContent = 'Suite ' + suite.bed_no + ' (Floor: ' + suite.floor_name + ')';
                    select.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No vacant suites available';
                option.disabled = true;
                select.appendChild(option);
            }
        })
        .catch(error => {
            console.error('Error loading vacant suites:', error);
            const select = document.getElementById('destination-suite-select');
            select.innerHTML = '<option value="">Error loading suites</option>';
        });
    }

    // Reset transfer modal
    function resetTransferModal() {
        transferSuiteId = null;
        transferSuiteNumber = null;
        document.getElementById('destination-suite-select').innerHTML = '<option value="">Select a vacant suite...</option>';
    }

    // Confirm Transfer
    document.getElementById('confirm-transfer-suite').addEventListener('click', function () {
        const destinationSuiteId = document.getElementById('destination-suite-select').value;
        
        if (!destinationSuiteId) {
            alert('Please select a destination suite');
            return;
        }
        
        if (!transferSuiteId) {
            alert('Source suite not found');
            return;
        }
        
        // Show loading state
        const transferBtn = document.getElementById('confirm-transfer-suite');
        const originalText = transferBtn.innerHTML;
        transferBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Transferring...';
        transferBtn.disabled = true;
        
        // Perform transfer
        fetch('<?php echo site_url('Orderportal/Hospitalconfig/transferClient'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            body: 'source_suite_id=' + encodeURIComponent(transferSuiteId) + 
                  '&destination_suite_id=' + encodeURIComponent(destinationSuiteId)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Close modal
                document.getElementById('transfer-suite-modal').classList.add('hidden');
                resetTransferModal();
                
                // Show success message
                Swal.fire({
                    title: 'Transfer Successful!',
                    text: data.message || 'Client has been transferred successfully',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    // Reload the page to update the suite statuses
                    window.location.reload();
                });
            } else {
                // Show detailed error message
                let errorMessage = data.message || 'Unknown error occurred';
                if (data.debug) {
                    errorMessage += '\n\nDebug Info:\n';
                    if (data.debug.client_id) errorMessage += 'Client ID: ' + data.debug.client_id + '\n';
                    if (data.debug.destination_suite_id) errorMessage += 'Destination Suite: ' + data.debug.destination_suite_id + '\n';
                    if (data.debug.db_error) errorMessage += 'Database Error: ' + JSON.stringify(data.debug.db_error) + '\n';
                }
                
                Swal.fire({
                    title: 'Transfer Failed',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    width: '600px'
                });
            }
        })
        .catch(error => {
            console.error('Error transferring client:', error);
            Swal.fire({
                title: 'Network Error',
                text: 'Failed to connect to server. Please check your connection and try again.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        })
        .finally(() => {
            // Reset button state
            transferBtn.innerHTML = originalText;
            transferBtn.disabled = false;
        });
    });
});
</script>