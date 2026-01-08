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
                                    <h4 class="mb-sm-0 text-black">Menuplanners List </h4>
    
                                    <div class="page-title-right">
                                        <div class="d-flex justify-content-sm-end ">
                                         <?php if($this->ion_auth->get_users_groups()->row()->id != 3){ ?>
                                            <div class="d-flex justify-content-sm-end gap-2 align-items-center">
                                                <!-- Weekday Filter Dropdown -->
                                                <div class="d-flex align-items-center gap-2">
                                                    <select class="form-select form-select-sm" id="weekdayFilter" style="min-width: 140px;">
                                                        <option value="">All Days</option>
                                                        <option value="Sunday">Sunday</option>
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                        <option value="Saturday">Saturday</option>
                                                    </select>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="clearAllFilters" title="Clear all filters">
                                                        <i class="ri-refresh-line"></i>
                                                    </button>
                                                </div>
                                                
                                                <a class="btn btn-danger btn" href="<?php echo base_url('/Orderportal/Menuplanner/createMenuPlanner') ?>"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Daily Menu</a>

                                            </div>
                                            <?php }  ?>
                                        </div>
                                    </div>
    
                                      </div>
                                      </div>

                                    <div class="card-body">
                                   <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                       
                                      <li class="nav-item">
                                      <a class="nav-link py-3 active" data-bs-toggle="tab" href="#TabDailyMenu" role="tab" aria-selected="true">
                                      <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Daily Menuplanner</a>
                                      </li>  
                                      
                                      <!--<li class="nav-item">-->
                                      <!--<a class="nav-link py-3" data-bs-toggle="tab" href="#TabWeeklyMenu" role="tab" aria-selected="false">-->
                                      <!--<i class="ri-checkbox-circle-line me-1 align-bottom"></i> Weekly Menuplanner</a>-->
                                      <!--</li> -->
                                      
                                      <li class="nav-item">
                                      <a class="nav-link py-3" data-bs-toggle="tab" href="#TabPastMenu" role="tab" aria-selected="true">
                                      <i class="ri-checkbox-circle-line me-1 align-bottom"></i>Past Menuplanner</a>
                                      </li> 
                                      
                                     </ul>           
                      
                                        
                                           <div class="tab-content mb-1"> 
                                          <div class="tab-pane table-responsive active show" role="tabpanel"  id="TabDailyMenu"> 
                                          <div class="table-responsive  mb-1">
                                                <table class="table align-middle table-nowrap listDatatable" >
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th class="sort" data-sort="category_name">Date </th>
                                                            <th class="sort" data-sort="category_name">Floor Name </th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all">
                                                        <?php if(!empty($menuPlannerLists)) {  ?>
                                                        <?php foreach($menuPlannerLists as $menuPlannerList){  ?>
                                                        <?php  
                                                        if($menuPlannerList['department_id'] =='0'){
                                                            $departmentNames = ['All'];
                                                        }else{
                                                         $menuPlannerListDepartmentId = explode(',', $menuPlannerList['department_id']);
                                                          $departmentNames = [];

                                                           foreach ($menuPlannerListDepartmentId as $id) {
                                                           // Use array_filter to find the department by ID
                                                           $filtered = array_filter($departmentList, function ($department) use ($id) {
                                                                   return $department['id'] == $id; // Check for ID match
                                                                  });

                                                         if (!empty($filtered)) {
                                                              $departmentNames[] = reset($filtered)['name'];
                                                            }
                                                            }   
                                                        }

                                                        ?>
                                                        <tr id="row_<?php echo  $menuPlannerList['id']; ?>"  class="parentRow">
                                                            <td class="name"><?php 
                                                            // CRITICAL FIX: Use Australia/Sydney timezone for date display to prevent timezone conversion issues
                                                            $timezone = new DateTimeZone('Australia/Sydney');
                                                            $dateObj = DateTime::createFromFormat('Y-m-d', $menuPlannerList['date'], $timezone);
                                                            if ($dateObj === false) {
                                                                $dateObj = new DateTime($menuPlannerList['date'], $timezone);
                                                            }
                                                            echo $dateObj->format('d-m-Y') . ' (' . $dateObj->format('l') . ')'; 
                                                            ?></td>
                                                            <td class="name"><?php echo implode(", ", $departmentNames); ?></td>
                                                            <td class="status"><?php echo ($menuPlannerList['status'] == 1 ? 'Saved' : 'Published'); ?></td>
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                                    <div class="edit">
                                                                        <?php if($this->session->userdata('role_id') == 3) { 
                                                                            // Nurse role - View only button
                                                                        ?>
                                                                        <a href="<?php echo base_url('Orderportal/Menuplanner/viewMenuPlanner/'.$menuPlannerList['id']) ?>" class="btn btn btn-info">
                                                                            <i class="ri-eye-line label-icon align-middle fs-12 me-2"></i>View</a>
                                                                        <?php } else { 
                                                                            // Admin/Chef role - View/Edit button
                                                                        ?>
                                                                        <a href="<?php echo base_url('Orderportal/Menuplanner/viewMenuPlanner/'.$menuPlannerList['id']) ?>" class="btn btn btn-secondary edit-item-btn">
                                                                            <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php 
                                                                    // hide for nurse role
                                                                    if($this->session->userdata('role_id') !=3) { 
                                                                        $hasOrders = isset($datesWithOrders[$menuPlannerList['date']]);
                                                                        $orderCount = $hasOrders ? $datesWithOrders[$menuPlannerList['date']] : 0;
                                                                    ?>
                                                                    <div class="remove">
                                                                        <?php if ($hasOrders) { ?>
                                                                            <button class="btn btn btn-secondary" disabled title="Cannot delete: <?php echo $orderCount; ?> order(s) exist for this date" style="cursor: not-allowed; opacity: 0.6;">
                                                                                <i class="ri-lock-line label-icon align-middle fs-12 me-2"></i>Remove
                                                                            </button>
                                                                        <?php } else { ?>
                                                                            <button class="btn btn btn-danger remove-item-btn "  data-rel-id="<?php echo  $menuPlannerList['id']; ?>">
                                                                                <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                    
                                                                     <div class="publish">
                                                                        <?php if($menuPlannerList['status'] == 2) { ?>
                                                                            <button class="btn btn btn-info" disabled>
                                                                                <i class="ri-check-double-line label-icon align-middle fs-12 me-2"></i>Published
                                                                            </button>
                                                                        <?php } else { ?>
                                                                            <button class="btn btn btn-success" onclick="publish(this,<?php echo  $menuPlannerList['id']; ?>)">
                                                                                <i class="ri-survey-fill label-icon align-middle fs-12 me-2"></i>Publish
                                                                            </button>
                                                                        <?php } ?>
                                                                    </div>
                                                                    
                                                                    <div class="recreate">
                            <button 
                                type="button" 
                                class="btn btn btn-primary recreate-btn" 
                                data-id="<?php echo $menuPlannerList['id']; ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#recreateModal">
                                <i class="ri-refresh-line me-1"></i> Recreate
                            </button>
                                                                    </div>
                                                                    <?php } ?>
                                                                    
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                       <p class="text-muted mb-0">We did not find any record for you search.</p>
                                                    </div>
                                                </div>
                                            </div>
                                           </div>
                                          
                                         
                                          
                                          <div class="tab-pane table-responsive" role="tabpanel"  id="TabPastMenu">  
                                          
                                          <!-- Filter Section for Past Menu -->
                                          <div class="card mb-3">
                                              <div class="card-body">
                                                  <div class="row g-3">
                                                      <div class="col-md-4">
                                                          <label class="form-label">Start Date</label>
                                                          <input type="text" class="form-control" id="pastMenuStartDate" 
                                                                 placeholder="Select start date" readonly>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <label class="form-label">End Date</label>
                                                          <input type="text" class="form-control" id="pastMenuEndDate" 
                                                                 placeholder="Select end date" readonly>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <label class="form-label">Status</label>
                                                          <select class="form-select" id="pastMenuStatus">
                                                              <option value="">All Status</option>
                                                              <option value="Saved">Saved</option>
                                                              <option value="Published">Published</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="row mt-3">
                                                      <div class="col-md-6">
                                                          <input type="text" class="form-control" id="pastMenuSearch" 
                                                                 placeholder="Search by date or floor name...">
                                                      </div>
                                                      <div class="col-md-6">
                                                          <button type="button" class="btn btn-primary me-2" onclick="filterPastMenus()">
                                                              <i class="ri-search-line me-1"></i>Filter
                                                          </button>
                                                          <button type="button" class="btn btn-secondary" onclick="clearPastMenuFilters()">
                                                              <i class="ri-refresh-line me-1"></i>Clear
                                                          </button>
                                                          <span class="text-muted ms-3" id="pastMenuResultCount"></span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="alert alert-info mb-3">
                                              <i class="ri-information-line me-1"></i>
                                              <strong>Note:</strong> Showing the latest 30 past menu records by default. Use filters above to search for specific dates or records.
                                          </div>
                                          
                                          <div class="table-responsive  mb-1">
                                                <table class="table align-middle table-nowrap listDatatable" >
                                                    <thead class="table-dark">
                                                        <tr>
                                                            
                                                           <th class="sort" data-sort="category_name">Date </th>
                                                            <th class="sort" data-sort="category_name">Floor Name </th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                                  <tbody class="list form-check-all" id="pastMenuTableBody">
    <?php if (!empty($pastMenuPlannerLists)) : ?>
        <?php foreach ($pastMenuPlannerLists as $pastMenuPlanner) : ?>
            <?php  
            if ($pastMenuPlanner['department_id'] == '0') {
                $departmentNames = ['All'];
            } else {
                $menuPlannerListDepartmentId = explode(',', $pastMenuPlanner['department_id']);
                $departmentNames = [];

                foreach ($menuPlannerListDepartmentId as $id) {
                    $filtered = array_filter($departmentList, function ($department) use ($id) {
                        return $department['id'] == $id;
                    });
                    if (!empty($filtered)) {
                        $departmentNames[] = reset($filtered)['name'];
                    }
                }
            }
            ?>
            <tr id="row_<?php echo $pastMenuPlanner['id']; ?>" class="parentRow">
                <td class="name"><?php 
                // CRITICAL FIX: Use Australia/Sydney timezone for date display to prevent timezone conversion issues
                $timezone = new DateTimeZone('Australia/Sydney');
                $dateObj = DateTime::createFromFormat('Y-m-d', $pastMenuPlanner['date'], $timezone);
                if ($dateObj === false) {
                    $dateObj = new DateTime($pastMenuPlanner['date'], $timezone);
                }
                echo $dateObj->format('d-m-Y') . ' (' . $dateObj->format('l') . ')'; 
                ?></td>
                <td class="name"><?php echo implode(", ", $departmentNames); ?></td>
                <td class="status"><?php echo ($pastMenuPlanner['status'] == 1 ? 'Saved' : 'Published'); ?></td>
                <td>
                    <div class="d-flex gap-2">
                        <div class="edit">
                            <?php if($this->session->userdata('role_id') == 3) { 
                                // Nurse role - View only button
                            ?>
                            <a href="<?php echo base_url('Orderportal/Menuplanner/viewMenuPlanner/' . $pastMenuPlanner['id']); ?>" class="btn btn btn-info">
                                <i class="ri-eye-line label-icon align-middle fs-12 me-2"></i>View</a>
                            <?php } else { 
                                // Admin/Chef role - View/Edit button
                            ?>
                            <a href="<?php echo base_url('Orderportal/Menuplanner/viewMenuPlanner/' . $pastMenuPlanner['id']); ?>" class="btn btn btn-secondary edit-item-btn">
                                <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>View/Edit
                            </a>
                            <?php } ?>
                        </div>
                        <?php if($this->session->userdata('role_id') != 3) { 
                            // Hide Recreate button for nurses
                        ?>
                        <div class="recreate">
                            <button 
                                type="button" 
                                class="btn btn btn-primary recreate-btn" 
                                data-id="<?php echo $pastMenuPlanner['id']; ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#recreateModal">
                                <i class="ri-refresh-line me-1"></i> Recreate
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>

 </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                       <p class="text-muted mb-0">We did not find any record for you search.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                          </div>
                                      </div>
                                    </div><!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                        </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            </div>
            
        <!-- Enhanced Modal for Recreate with Multi-Date Selection -->
<div class="modal fade" id="recreateModal" tabindex="-1" aria-labelledby="recreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="recreateModalLabel">
                    <i class="ri-refresh-line me-2"></i>Recreate Menu Planner
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ri-information-line me-1"></i>
                    <strong>Note:</strong> You can select multiple dates to recreate the same menu planner for different days.
                </div>
                
                <form id="recreateForm">
                    <input type="hidden" name="menuPlannerId" id="recreateMenuPlannerId">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="recreateDate" class="form-label">
                                    <i class="ri-calendar-line me-1"></i>Select Date(s) <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control flatpickr-input"
                                    placeholder="Select one or multiple dates"
                                    data-date-format="d-m-Y" 
                                    data-provider="flatpickr"
                                    data-minDate="today"
                                    id="recreateDate" name="dates" required readonly>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple dates</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="ri-list-check me-1"></i>Selected Dates
                                </label>
                                <div id="selectedDatesList" class="border rounded p-2 bg-light" style="min-height: 100px; max-height: 150px; overflow-y: auto;">
                                    <p class="text-muted mb-0 text-center">No dates selected</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="recreateSubmitBtn">
                            <i class="ri-refresh-line me-1"></i>Recreate Menu Planner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Modal for Conflict Warnings -->
<div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="customModalLabel">
                    <i class="ri-error-warning-line me-2"></i>Error
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2" id="customModalBody">
                <!-- Dynamic content will be inserted here -->
            </div>
        </div>
    </div>
</div>

<style>
.date-remove-btn {
    width: 18px;
    height: 18px;
    border: none;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    line-height: 1;
    padding: 0;
    cursor: pointer;
    transition: all 0.2s ease;
    margin: 0;
}

.date-remove-btn:hover {
    background: #dc3545 !important;
    color: white !important;
    transform: scale(1.1);
}

.date-remove-btn:active {
    transform: scale(0.9);
}

.date-remove-btn:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.3);
}

/* Improve badge spacing and alignment */
.badge.bg-primary-subtle {
    font-size: 0.875rem;
    font-weight: 500;
    line-height: 1.2;
}
</style>

<script>
// Global variables for recreate functionality
let selectedDates = [];
let flatpickrInstance = null;

$(document).ready(function() {
    // Initialize multi-date picker when document is ready
    initializeMultiDatePicker();
    
    // Handle recreate button clicks
    $('.recreate-btn').on('click', function() {
        let menuPlannerId = $(this).data('id');
        // console.log('Selected menu planner ID:', menuPlannerId);
        $('#recreateMenuPlannerId').val(menuPlannerId);
        
        // Reset form state
        resetRecreateForm();
    });

    // Handle form submission
    $('#recreateForm').on('submit', function(e) {
        e.preventDefault();
        handleRecreateSubmission();
    });
    
    // Initialize past menu filtering
    initializePastMenuFiltering();
    
    // Initialize weekday filtering
    initializeWeekdayFiltering();
});

function initializeMultiDatePicker() {
    try {
        flatpickrInstance = flatpickr('#recreateDate', {
            mode: 'multiple',
            dateFormat: 'd-m-Y',
            minDate: 'today',
            conjunction: ', ',
            onChange: function(selectedDateObjects, dateStr, instance) {
                selectedDates = selectedDateObjects.map(date => {
                    return flatpickr.formatDate(date, 'Y-m-d');
                });
                updateSelectedDatesList();
                // console.log('Selected dates:', selectedDates);
            }
        });
    } catch (error) {
        console.error('Error initializing flatpickr:', error);
    }
}

function resetRecreateForm() {
    selectedDates = [];
    updateSelectedDatesList();
    if (flatpickrInstance) {
        flatpickrInstance.clear();
    }
}

function handleRecreateSubmission() {
    if (selectedDates.length === 0) {
        showModalAlert('warning', 'Please select at least one date to recreate the menu planner.');
        return;
    }
    
    // First check for existing dates
    checkExistingDates(selectedDates);
}

function checkExistingDates(dates) {
    // console.log('Checking existing dates:', dates);
    
    var $button = $('#recreateSubmitBtn');
    var originalText = $button.html();
    
    // Show checking state
    $button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking dates...').prop('disabled', true);

    $.ajax({
        url: '<?php echo base_url('Orderportal/Menuplanner/getExistingMenuDates'); ?>',
        type: 'POST',
        data: { dates: dates },
        dataType: 'json',
        success: function(response) {
            // console.log('Date check response:', response);
            
            if (response.status === 'success') {
                if (response.hasConflicts && response.existingDates.length > 0) {
                    // Show conflict warning and allow user to deselect or skip
                    // console.log('Conflicts found for dates:', response.existingDates);
                    showConflictWarning(response.existingDates, $button, originalText);
                } else {
                    // No conflicts, proceed with recreation
                    // console.log('No conflicts found, proceeding with recreation');
                    proceedWithRecreation($button, originalText);
                }
            } else {
                console.error('Date check failed:', response.message);
                showModalAlert('error', response.message || 'Failed to check existing dates.');
                $button.html(originalText).prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            console.error('Date check AJAX error:', error);
            console.error('XHR response:', xhr.responseText);
            showModalAlert('error', 'Failed to check existing dates. Please try again.');
            $button.html(originalText).prop('disabled', false);
        }
    });
}

function showConflictWarning(existingDates, $button, originalText) {
    $button.html(originalText).prop('disabled', false);
    
    const formattedDates = existingDates.map(date => formatDateForDisplay(date)).join(', ');
    const message = `
        <div class="mb-3">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="ri-alert-line me-2"></i>
                <div>
                    <strong>Cannot recreate menu!</strong><br>
                    Menu planners already exist for the selected dates.
                </div>
            </div>
        </div>
        <div class="mb-3">
            <strong>Existing menu dates:</strong>
            <div class="mt-2 p-3 bg-danger-subtle border border-danger rounded">
                <i class="ri-calendar-line me-1"></i>${formattedDates}
            </div>
        </div>
        <div class="mb-3">
            <strong>Please choose an option:</strong>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-outline-danger" onclick="deselectConflictingDates(${JSON.stringify(existingDates).replace(/"/g, '&quot;')})">
                <i class="ri-close-line me-1"></i>Remove These Dates
            </button>
            <button type="button" class="btn btn-secondary" onclick="hideConflictModal()">
                <i class="ri-arrow-left-line me-1"></i>Cancel
            </button>
        </div>
    `;
    
    showCustomModal('Menu Already Exists', message, false);
}

function deselectConflictingDates(conflictingDates) {
    // Remove conflicting dates from selectedDates array
    selectedDates = selectedDates.filter(date => !conflictingDates.includes(date));
    
    // Update the display
    updateSelectedDatesList();
    
    // Update flatpickr
    if (flatpickrInstance) {
        try {
            const dateObjects = selectedDates.map(dateStr => new Date(dateStr));
            flatpickrInstance.setDate(dateObjects, false);
        } catch (error) {
            console.error('Error updating flatpickr:', error);
        }
    }
    
    hideConflictModal();
    
    if (selectedDates.length === 0) {
        showAlert('info', 'All conflicting dates have been deselected. Please select new dates to continue.');
    } else {
        showAlert('success', `Conflicting dates removed. ${selectedDates.length} date(s) remaining.`);
    }
}


function hideConflictModal() {
    $('#customModal').modal('hide');
}

function proceedWithRecreation($button, originalText) {
    // Show recreating state
    $button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Recreating...').prop('disabled', true);

    var formData = {
        menuPlannerId: $('#recreateMenuPlannerId').val(),
        dates: selectedDates,
        skipExistingDates: false // Always false since we prevent duplicates upfront
    };
    
    // console.log('Submitting recreate request:', formData);

    $.ajax({
        url: '<?php echo base_url('Orderportal/Menuplanner/recreateMenuPlannerMultiple'); ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            // console.log('Response:', response);
            handleRecreateResponse(response, $button, originalText);
        },
        error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            showModalAlert('error', 'An error occurred. Please try again.');
            $button.html(originalText).prop('disabled', false);
        }
    });
}

function handleRecreateResponse(response, $button, originalText) {
    if (response.status === 'success' || response.status === 'partial') {
        // Show success message on main screen and close modal
        showAlert(response.status === 'success' ? 'success' : 'warning', response.message);
        $('#recreateModal').modal('hide');
        
        // Reload after a short delay
        setTimeout(function() {
            location.reload();
        }, 2000);
    } else {
        // Show error message in modal
        showModalAlert('error', response.message);
    }
    $button.html(originalText).prop('disabled', false);
}

function updateSelectedDatesList() {
    const container = $('#selectedDatesList');
    
    if (selectedDates.length === 0) {
        container.html('<p class="text-muted mb-0 text-center">No dates selected</p>');
        return;
    }
    
    let html = '<div class="d-flex flex-wrap gap-2">';
    selectedDates.forEach((date, index) => {
        const formattedDate = formatDateForDisplay(date);
        html += `
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 d-inline-flex align-items-center gap-2">
                <i class="ri-calendar-line"></i>
                <span>${formattedDate}</span>
                <button type="button" class="date-remove-btn" onclick="removeDate(${index}, event)">
                    <i class="ri-close-line"></i>
                </button>
            </span>
        `;
    });
    html += '</div>';
    html += `<small class="text-muted mt-2 d-block">${selectedDates.length} date(s) selected</small>`;
    
    container.html(html);
}

function removeDate(index, event) {
    // Prevent event propagation to avoid modal closing
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    if (index >= 0 && index < selectedDates.length) {
        selectedDates.splice(index, 1);
        updateSelectedDatesList();
        
        // Update flatpickr
        if (flatpickrInstance) {
            try {
                const dateObjects = selectedDates.map(dateStr => new Date(dateStr));
                flatpickrInstance.setDate(dateObjects, false);
            } catch (error) {
                console.error('Error updating flatpickr:', error);
            }
        }
    }
}

function formatDateForDisplay(dateStr) {
    try {
        const date = new Date(dateStr);
        const options = { 
            day: '2-digit', 
            month: 'short', 
            year: 'numeric',
            weekday: 'short'
        };
        return date.toLocaleDateString('en-GB', options);
    } catch (error) {
        console.error('Error formatting date:', error);
        return dateStr;
    }
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      type === 'info' ? 'alert-info' : 'alert-danger';
    
    const iconClass = type === 'success' ? 'check-circle' : 
                      type === 'warning' ? 'alert' : 
                      type === 'info' ? 'information' : 'error-warning';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="ri-${iconClass}-line me-1"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Remove existing alerts
    $('.alert').remove();
    
    // Add new alert at the top of the page
    $('.container-fluid').prepend(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}

function showCustomModal(title, content, showFooter = true) {
    $('#customModalLabel').html(`<i class="ri-error-warning-line me-2"></i>${title}`);
    $('#customModalBody').html(content);
    
    // Show the modal
    $('#customModal').modal('show');
}

function showModalAlert(type, message) {
    // Remove any existing modal alerts
    $('#recreateModal .modal-alert').remove();
    
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      type === 'info' ? 'alert-info' : 'alert-danger';
    
    const iconClass = type === 'success' ? 'check-circle' : 
                      type === 'warning' ? 'alert' : 
                      type === 'info' ? 'information' : 'error-warning';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show modal-alert" role="alert">
            <i class="ri-${iconClass}-line me-1"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Add alert at the top of the modal body
    $('#recreateModal .modal-body').prepend(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('#recreateModal .modal-alert').alert('close');
    }, 5000);
}

// Initialize past menu filtering functionality
function initializePastMenuFiltering() {
    // Store all rows when page loads
    const tableBody = document.getElementById('pastMenuTableBody');
    if (tableBody) {
        allPastMenuRows = Array.from(tableBody.querySelectorAll('tr'));
        updatePastMenuResultCount(allPastMenuRows.length);
    }
    
    // Real-time search
    const searchInput = document.getElementById('pastMenuSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterPastMenus);
    }
    
    // Initialize date pickers with validation
    initializeDatePickers();
}
</script>

<script>
// Past Menu Filtering Functionality
let allPastMenuRows = [];

function initializeDatePickers() {
    try {
        // Initialize start date picker
        const startDatePicker = flatpickr('#pastMenuStartDate', {
            dateFormat: "d-m-Y",
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Update end date picker's minDate when start date changes
                if (selectedDates.length > 0) {
                    endDatePicker.set('minDate', selectedDates[0]);
                } else {
                    endDatePicker.set('minDate', null);
                }
            }
        });
        
        // Initialize end date picker
        const endDatePicker = flatpickr('#pastMenuEndDate', {
            dateFormat: "d-m-Y",
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Update start date picker's maxDate when end date changes
                if (selectedDates.length > 0) {
                    startDatePicker.set('maxDate', selectedDates[0]);
                } else {
                    startDatePicker.set('maxDate', null);
                }
            }
        });
        
        // Store references globally for clearing
        window.startDatePickerInstance = startDatePicker;
        window.endDatePickerInstance = endDatePicker;
    } catch (error) {
        console.error('Error initializing date pickers:', error);
    }
}

function filterPastMenus() {
    const startDate = document.getElementById('pastMenuStartDate').value;
    const endDate = document.getElementById('pastMenuEndDate').value;
    const status = document.getElementById('pastMenuStatus').value.toLowerCase();
    const searchTerm = document.getElementById('pastMenuSearch').value.toLowerCase();
    
    const filteredRows = allPastMenuRows.filter(row => {
        const dateCell = row.querySelector('td:first-child').textContent.trim();
        const floorNameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
        const statusCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();
        
        // Extract date from "07-09-2025 (Monday)" format
        const dateMatch = dateCell.match(/(\d{2}-\d{2}-\d{4})/);
        const rowDate = dateMatch ? dateMatch[1] : '';
        
        // Date range filter
        if (startDate && !isDateInRange(rowDate, startDate, endDate)) {
            return false;
        }
        
        // Status filter
        if (status && !statusCell.includes(status)) {
            return false;
        }
        
        // Search term filter
        if (searchTerm && !dateCell.toLowerCase().includes(searchTerm) && 
            !floorNameCell.includes(searchTerm)) {
            return false;
        }
        
        return true;
    });
    
    // Update table display
    const tableBody = document.getElementById('pastMenuTableBody');
    tableBody.innerHTML = '';
    
    if (filteredRows.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">No records found matching the filter criteria.</td></tr>';
    } else {
        filteredRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));
    }
    
    updatePastMenuResultCount(filteredRows.length);
}

function clearPastMenuFilters() {
    document.getElementById('pastMenuStatus').value = '';
    document.getElementById('pastMenuSearch').value = '';
    
    // Clear flatpickr instances and reset date restrictions
    if (window.startDatePickerInstance) {
        window.startDatePickerInstance.clear();
        window.startDatePickerInstance.set('maxDate', null);
    }
    if (window.endDatePickerInstance) {
        window.endDatePickerInstance.clear();
        window.endDatePickerInstance.set('minDate', null);
    }
    
    // Restore all rows
    const tableBody = document.getElementById('pastMenuTableBody');
    tableBody.innerHTML = '';
    allPastMenuRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));
    
    updatePastMenuResultCount(allPastMenuRows.length);
}

function isDateInRange(dateStr, startDateStr, endDateStr) {
    if (!dateStr) return false;
    
    const date = parseDate(dateStr);
    const startDate = startDateStr ? parseDate(startDateStr) : null;
    const endDate = endDateStr ? parseDate(endDateStr) : null;
    
    if (startDate && date < startDate) return false;
    if (endDate && date > endDate) return false;
    
    return true;
}

function parseDate(dateStr) {
    // Parse "dd-mm-yyyy" format
    const parts = dateStr.split('-');
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function updatePastMenuResultCount(count) {
    const resultCount = document.getElementById('pastMenuResultCount');
    if (resultCount) {
        resultCount.textContent = `${count} record${count !== 1 ? 's' : ''} found`;
    }
}

// Weekday Filtering Functionality
let allDailyMenuRows = [];

function initializeWeekdayFiltering() {
    // Store all Daily Menu rows when page loads
    const dailyMenuTableBody = document.querySelector('#TabDailyMenu tbody');
    if (dailyMenuTableBody) {
        allDailyMenuRows = Array.from(dailyMenuTableBody.querySelectorAll('tr'));
    }
    
    // Handle weekday filter change
    const weekdayFilter = document.getElementById('weekdayFilter');
    if (weekdayFilter) {
        weekdayFilter.addEventListener('change', function() {
            const selectedWeekday = this.value;
            filterByWeekday(selectedWeekday);
        });
    }
    
    // Handle clear all filters button
    const clearAllFiltersBtn = document.getElementById('clearAllFilters');
    if (clearAllFiltersBtn) {
        clearAllFiltersBtn.addEventListener('click', function() {
            clearAllFiltersFunction();
        });
    }
}

function filterByWeekday(selectedWeekday) {
    // Filter Daily Menu Tab
    filterDailyMenuByWeekday(selectedWeekday);
    
    // Filter Past Menu Tab
    filterPastMenuByWeekday(selectedWeekday);
}

function filterDailyMenuByWeekday(selectedWeekday) {
    const dailyMenuTableBody = document.querySelector('#TabDailyMenu tbody');
    if (!dailyMenuTableBody) return;
    
    let filteredRows = allDailyMenuRows;
    
    if (selectedWeekday) {
        filteredRows = allDailyMenuRows.filter(row => {
            const dateCell = row.querySelector('td:first-child');
            if (!dateCell) return false;
            
            const dateText = dateCell.textContent.trim();
            // Extract weekday from "23-10-2025 (Thursday)" format
            const weekdayMatch = dateText.match(/\(([^)]+)\)/);
            const rowWeekday = weekdayMatch ? weekdayMatch[1] : '';
            
            return rowWeekday === selectedWeekday;
        });
    }
    
    // Update Daily Menu table display
    dailyMenuTableBody.innerHTML = '';
    
    if (filteredRows.length === 0) {
        const noResultsRow = `
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="ri-calendar-line fs-1 text-muted mb-2"></i>
                        <h6 class="text-muted">No menu planners found</h6>
                        <p class="text-muted mb-0">
                            ${selectedWeekday ? `No menu planners found for ${selectedWeekday}s` : 'No menu planners available'}
                        </p>
                    </div>
                </td>
            </tr>
        `;
        dailyMenuTableBody.innerHTML = noResultsRow;
    } else {
        filteredRows.forEach(row => {
            dailyMenuTableBody.appendChild(row.cloneNode(true));
        });
        
        // Re-bind event handlers for cloned elements
        rebindDailyMenuEventHandlers();
    }
}

function filterPastMenuByWeekday(selectedWeekday) {
    // Apply weekday filter to existing past menu filtering logic
    if (!allPastMenuRows || allPastMenuRows.length === 0) return;
    
    let filteredRows = allPastMenuRows;
    
    if (selectedWeekday) {
        filteredRows = allPastMenuRows.filter(row => {
            const dateCell = row.querySelector('td:first-child');
            if (!dateCell) return false;
            
            const dateText = dateCell.textContent.trim();
            // Extract weekday from "29-09-2025 (Monday)" format
            const weekdayMatch = dateText.match(/\(([^)]+)\)/);
            const rowWeekday = weekdayMatch ? weekdayMatch[1] : '';
            
            return rowWeekday === selectedWeekday;
        });
    }
    
    // Apply other existing filters (date range, status, search) to the weekday-filtered results
    const startDate = document.getElementById('pastMenuStartDate').value;
    const endDate = document.getElementById('pastMenuEndDate').value;
    const status = document.getElementById('pastMenuStatus').value.toLowerCase();
    const searchTerm = document.getElementById('pastMenuSearch').value.toLowerCase();
    
    if (startDate || endDate || status || searchTerm) {
        filteredRows = filteredRows.filter(row => {
            const dateCell = row.querySelector('td:first-child').textContent.trim();
            const floorNameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
            const statusCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();
            
            // Extract date from "07-09-2025 (Monday)" format
            const dateMatch = dateCell.match(/(\d{2}-\d{2}-\d{4})/);
            const rowDate = dateMatch ? dateMatch[1] : '';
            
            // Date range filter
            if (startDate && !isDateInRange(rowDate, startDate, endDate)) {
                return false;
            }
            
            // Status filter
            if (status && !statusCell.includes(status)) {
                return false;
            }
            
            // Search term filter
            if (searchTerm && !dateCell.toLowerCase().includes(searchTerm) && 
                !floorNameCell.includes(searchTerm)) {
                return false;
            }
            
            return true;
        });
    }
    
    // Update Past Menu table display
    const pastMenuTableBody = document.getElementById('pastMenuTableBody');
    if (pastMenuTableBody) {
        pastMenuTableBody.innerHTML = '';
        
        if (filteredRows.length === 0) {
            const noResultsRow = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <div class="d-flex flex-column align-items-center">
                            <i class="ri-calendar-line fs-1 text-muted mb-2"></i>
                            <h6 class="text-muted">No past menu planners found</h6>
                            <p class="text-muted mb-0">
                                ${selectedWeekday ? `No past menu planners found for ${selectedWeekday}s with current filters` : 'No past menu planners match the current filter criteria'}
                            </p>
                        </div>
                    </td>
                </tr>
            `;
            pastMenuTableBody.innerHTML = noResultsRow;
        } else {
            filteredRows.forEach(row => {
                pastMenuTableBody.appendChild(row.cloneNode(true));
            });
        }
        
        updatePastMenuResultCount(filteredRows.length);
    }
}

function rebindDailyMenuEventHandlers() {
    // Re-bind remove button event handlers
    $('.remove-item-btn').off('click').on('click', function() {
        let id = $(this).attr('data-rel-id');
        
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
            cancelButtonClass: "btn btn-danger w-xs mt-2",
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: !1,
            showCloseButton: !0,
        }).then(function (e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url("Orderportal/Menuplanner/deleteMenuPlanner"); ?>',
                    data: 'id='+id,
                    success: function(data){
                        $('#row_'+id).remove();
                        // Update stored rows after deletion
                        allDailyMenuRows = allDailyMenuRows.filter(row => 
                            row.id !== 'row_' + id
                        );
                    }
                });
            }
        });
    });
    
    // Re-bind recreate button event handlers
    $('.recreate-btn').off('click').on('click', function() {
        let menuPlannerId = $(this).data('id');
        // console.log('Selected menu planner ID:', menuPlannerId);
        $('#recreateMenuPlannerId').val(menuPlannerId);
        
        // Reset form state
        resetRecreateForm();
    });
}

// Override the existing filterPastMenus function to work with weekday filtering
function filterPastMenus() {
    // Get current weekday filter
    const selectedWeekday = document.getElementById('weekdayFilter').value;
    
    // Apply weekday filter first, then other filters
    filterPastMenuByWeekday(selectedWeekday);
}

// Override the existing clearPastMenuFilters function to also clear weekday filter
function clearPastMenuFilters() {
    document.getElementById('pastMenuStatus').value = '';
    document.getElementById('pastMenuSearch').value = '';
    
    // Clear flatpickr instances and reset date restrictions
    if (window.startDatePickerInstance) {
        window.startDatePickerInstance.clear();
        window.startDatePickerInstance.set('maxDate', null);
    }
    if (window.endDatePickerInstance) {
        window.endDatePickerInstance.clear();
        window.endDatePickerInstance.set('minDate', null);
    }
    
    // Don't clear weekday filter here - let user clear it manually if needed
    
    // Apply current weekday filter (if any) to show all matching results
    const selectedWeekday = document.getElementById('weekdayFilter').value;
    filterPastMenuByWeekday(selectedWeekday);
}

// Clear all filters function
function clearAllFiltersFunction() {
    // Clear weekday filter
    document.getElementById('weekdayFilter').value = '';
    
    // Clear past menu filters
    document.getElementById('pastMenuStatus').value = '';
    document.getElementById('pastMenuSearch').value = '';
    
    // Clear flatpickr instances and reset date restrictions
    if (window.startDatePickerInstance) {
        window.startDatePickerInstance.clear();
        window.startDatePickerInstance.set('maxDate', null);
    }
    if (window.endDatePickerInstance) {
        window.endDatePickerInstance.clear();
        window.endDatePickerInstance.set('minDate', null);
    }
    
    // Reset Daily Menu table to show all rows
    const dailyMenuTableBody = document.querySelector('#TabDailyMenu tbody');
    if (dailyMenuTableBody && allDailyMenuRows.length > 0) {
        dailyMenuTableBody.innerHTML = '';
        allDailyMenuRows.forEach(row => {
            dailyMenuTableBody.appendChild(row.cloneNode(true));
        });
        rebindDailyMenuEventHandlers();
    }
    
    // Reset Past Menu table to show all rows
    const pastMenuTableBody = document.getElementById('pastMenuTableBody');
    if (pastMenuTableBody && allPastMenuRows.length > 0) {
        pastMenuTableBody.innerHTML = '';
        allPastMenuRows.forEach(row => {
            pastMenuTableBody.appendChild(row.cloneNode(true));
        });
        updatePastMenuResultCount(allPastMenuRows.length);
    }
}
</script>
            <script>
            
            $(document).on("click", ".remove-item-btn" , function() {
                let id = $(this).attr('data-rel-id');
               
                    Swal.fire({
                      title: "Are you sure?",
                      text: "You won't be able to revert this!",
                      icon: "warning",
                      showCancelButton: !0,
                      confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                      cancelButtonClass: "btn btn-danger w-xs mt-2",
                      confirmButtonText: "Yes, delete it!",
                      buttonsStyling: !1,
                      showCloseButton: !0,
                  }).then(function (e) {
                      if (e.value) {
                        $.ajax({
                            type: "POST",
                            url: '<?php echo base_url("Orderportal/Menuplanner/deleteMenuPlanner"); ?>',
                            data: 'id='+id,
                            dataType: 'json',
                            success: function(response){
                                if (response.status === 'success') {
                                    $('#row_'+id).remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Menu has been deleted successfully.",
                                        icon: "success",
                                        confirmButtonClass: "btn btn-primary w-xs mt-2",
                                        buttonsStyling: !1
                                    });
                                } else if (response.status === 'error') {
                                    Swal.fire({
                                        title: "Cannot Delete!",
                                        text: response.message,
                                        icon: "error",
                                        confirmButtonClass: "btn btn-primary w-xs mt-2",
                                        buttonsStyling: !1
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the menu.",
                                    icon: "error",
                                    confirmButtonClass: "btn btn-primary w-xs mt-2",
                                    buttonsStyling: !1
                                });
                            }
                        });
                      }
                  })
            });
            
            function publish(obj,id){
                $(obj).html("Publishing...");
                 $.ajax({
                            type: "POST",
                            url: '<?php echo base_url("Orderportal/Menuplanner/publishMenuPlanner"); ?>',
                            data: 'id='+id,
                            success: function(data){
                               $(obj).parents(".parentRow").find(".status").html("Published");
                                 $(obj).html("Published");
                            }
                        });
                
            }
            </script>