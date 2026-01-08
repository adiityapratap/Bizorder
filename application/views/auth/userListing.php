<div class="container-fluid" style="margin-top: 0 !important;">
 <div class="row" >
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Users</h5>
                                        <div class="flex-shrink-0">
                                            <a type="button" class="btn btn-primary add-btn" 
                                                id="create-btn" href="<?php echo base_url('auth/create_user') ?>"><i
                                                    class="ri-add-line align-bottom me-1"></i> Add User
                                                </a>
                                           
                                             <button class="btn btn-soft-danger fs-14" onClick="deleteMultipleChecklist()"><i class="ri-delete-bin-6-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border border-dashed border-end-0 border-start-0">
                                    <form>
                                        <div class="row g-3 justify-content-end">
                                            <div class="col-auto" style="min-width: 400px;">
                                                <div class="search-box">
                                                    <input type="text" class="form-control search"
                                                        placeholder="Search for User Id, Full name, Email or something...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <div class="card-body pt-0">
                                    <div>
                                        
                                       <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-3 active" data-bs-toggle="tab" href="#activeuserTab" role="tab" aria-selected="false">
                                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Active   
                                                </a>
                                               
                                                
                                            </li>
                                           
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab"
                                                    href="#cancelledUserTab" role="tab" aria-selected="false">
                                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Inactive
                                                </a>
                                            </li>
                                            
                                        </ul>
                                        
                                       
                                        
                                       
                                        
                                        <div class="tab-content  text-muted"> 
                                         <div class="tab-pane active" id="activeuserTab" role="tabpanel">
                                        <div class="table-responsive mb-1">
                                            <table class="table table-nowrap align-middle" id="activeUsersTable">
                                                <thead class="text-muted table-dark">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" class="no-sort" style="width: 25px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="id">User ID</th>
                                                        <th class="sort" data-sort="customer_name">Full name</th>
                                                        <th class="sort" data-sort="product_name">Locations</th>
                                                        <th class="sort" data-sort="date">Email</th>
                                                        <th class="sort" data-sort="role">Role</th>
                                                        <!--<th class="sort" data-sort="status">Status</th>-->
                                                        <th class="no-sort" data-sort="status">Status</th>
                                                        <th class="no-sort" data-sort="city">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php if(!empty($activeUsers)) {   ?>
                                                     <?php foreach($activeUsers as $allActiveUser) { ?>
                                                     <?php $locationNames = fetchLocationNamesFromIds(unserialize($allActiveUser->location_ids));  $locationNames = implode(', ', $locationNames);?>
                                                      <?php  $groups = $this->ion_auth->get_users_groups($allActiveUser->id)->result(); ?>
                                                     <?php $rolename =  (!empty($groups) ?  $groups[0]->name : ''); ?>
                                                    <tr class="recordRow">
                                                       <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="<?php echo $allActiveUser->id;  ?>">
                                                            </div>
                                                        </th>
                                                        <td class="id"><?php echo $allActiveUser->id;  ?></td>
                                                        <td class="customer_name"><?php echo $allActiveUser->first_name;  ?></td>
                                                        <td class="product_name"><?php echo $locationNames;  ?></td>
                                                        <td class="amount"><?php echo $allActiveUser->email;  ?></td>
                                                         <td class="amount"><?php echo $rolename;  ?></td>
                                                       <td>
                                                       <div class="form-check form-switch form-switch-custom form-switch-success">
                                                        <input class="form-check-input userlisttoggle-demo" type="checkbox" role="switch" data-value="<?php echo $allActiveUser->active; ?>" data-id="<?php echo  $allActiveUser->id; ?>" <?php echo ($allActiveUser->active ? 'checked' : '');  ?>>
                                                       </div>
                                                       </td>
                                                       
                                                        <!--<td class="status"><span class="badge bg-success-subtle text-success">Active</span>-->
                                                        </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="View">
                                                                    <a href="<?php echo base_url('auth/edit_user/'.$allActiveUser->id) ?>" class="text-primary d-inline-block">
                                                                        <i class="ri-eye-fill fs-16"></i>/<i class="ri-pencil-line fs-16"></i>
                                                                    </a>
                                                                </li>
                                                            <?php  if($rolename !='Admin') { ?>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                        <a class="text-danger d-inline-block remove-item-btn" data-rel-id="<?php echo $allActiveUser->id;  ?>" data-bs-toggle="modal"><i class="ri-delete-bin-5-fill fs-16"></i></a>
                                                                </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <?php }  ?>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#0ab39c"
                                                        style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted">We've searched /</p>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="tab-pane" id="cancelledUserTab" role="tabpanel">
                                         <div class="table-responsive table-card mb-1 cccc">
                                            <table class="table table-nowrap align-middle" id="inactiveUsersTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" class="no-sort" style="width: 25px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="id">User ID</th>
                                                        <th class="sort" data-sort="customer_name">Full name</th>
                                                        <th class="sort" data-sort="product_name">Username</th>
                                                        <th class="sort" data-sort="date">Email</th>
                                                        <th class="sort" data-sort="role">Role</th>
                                                        <th class="no-sort" data-sort="status">Status</th>
                                                        <th class="no-sort" data-sort="city">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php if(!empty($InActiveUsers)) {  ?>
                                                     <?php foreach($InActiveUsers as $allInactiveUser) {  ?>
                                                     <?php  $groups = $this->ion_auth->get_users_groups($allInactiveUser->id)->result(); ?>
                                                     <?php $rolename =  (!empty($groups) ?  $groups[0]->name : ''); ?>
                                                    <tr class="recordRow">
                                                       <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="<?php echo $allInactiveUser->id;  ?>">
                                                            </div>
                                                        </th>
                                                        <td class="id"><a href="apps-ecommerce-order-details.html" class="fw-medium link-primary"><?php echo $allInactiveUser->id;  ?></a></td>
                                                        <td class="customer_name"><?php echo $allInactiveUser->first_name;  ?></td>
                                                        <td class="product_name"><?php echo $allInactiveUser->username;  ?></td>
                                                       
                                                        <td class="amount"><?php echo $allInactiveUser->email;  ?></td>
                                                        <td class="amount"><?php echo $rolename;  ?></td>
                                                        <td class="status"><a href="#" onclick="revertTheUser(this,<?php echo $allInactiveUser->id; ?>)" class="revert-link"><span class="badge bg-warning text-dark text-uppercase">Revert</span></a>
                                                        </td>
                                                        <td>
                                                            
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="View">
                                                                    <a href="<?php echo base_url('auth/edit_user/'.$allInactiveUser->id) ?>" class="text-primary d-inline-block">
                                                                        <i class="ri-eye-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                            
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                          <a class="text-danger d-inline-block remove-item-btn" data-rel-id="<?php echo $allInactiveUser->id;  ?>" data-bs-toggle="modal">
                                                                        
                                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                               
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <?php }  ?>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#0ab39c"
                                                        style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted">We've searched /</p>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                         
                                    </div>
                                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="text-black">You are about to delete a User ?</h4>
                                                        <p class="text-black fs-15 mb-4">Deleting your user will remove
                                                            all of
                                                            the information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                                <input class="deletedRecordId" type="hidden">
                                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
</div>

<div class="modal fade flip" id="deleteMultipleChecklist" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="text-black">You are about to delete multiple Users </h4>
                                                        <p class="fs-15 mb-4 text-black">Deleting user will remove
                                                            all of
                                                            the information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                            <button class="btn btn-danger" value="" onclick="deleteMultipleCheckl()">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<script>
function deleteMultipleChecklist(){
  $("#deleteMultipleChecklist").modal('show');  
}

function deleteMultipleCheckl(){
    let selectedValues = [];
   $('.checkbox-item:checked').each(function() {
        selectedValues.push($(this).val());
    });
        
    if (selectedValues.length > 0) {
        $.ajax({
            url: '<?php echo base_url("auth/deleteMultiple"); ?>',
            type: 'POST',
            data: { 
                selected_values: selectedValues 
            },
            dataType: 'json',
            success: function(response) {
                $("#deleteMultipleChecklist").modal('hide');
                
                if (response.status === 'success') {
                    // Remove deleted rows from the table
                    for (var i = 0; i < selectedValues.length; i++) {
                        let id = selectedValues[i];
                        $('#row_'+id).remove();
                    }
                    
                    // Show success message
                    alert(response.message);
                    
                    // Reload page to refresh the list
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                $("#deleteMultipleChecklist").modal('hide');
                alert('Error deleting users: ' + error);
            }
        });
    } else {
        alert('No checkboxes selected.');
    }        
}

// STATUS SWITCH FUNCTIONALITY - WITH CONFIRMATION AND DYNAMIC UPDATES (Using Event Delegation)
$(document).off('change.statusOnly', '.userlisttoggle-demo').on('change.statusOnly', '.userlisttoggle-demo', function(e){
    // Stop any propagation to prevent interference
    e.stopPropagation();
    e.stopImmediatePropagation();
    
    console.log("Status switch clicked - isolated handler");
    
    let user_id = $(this).attr('data-id');
    let value = $(this).attr('data-value');
    let $currentRow = $(this).closest('tr');
    let $toggle = $(this);
    let methodName = '';
    let actionText = '';
    
    if(value == 1){
       methodName = 'deactivate';   
       actionText = 'deactivate';
    }else{
       methodName = 'activate';   
       actionText = 'activate';
    }
    
    // Show confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${actionText} this user?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Yes, ${actionText}!`,
        cancelButtonText: 'Cancel',
        confirmButtonColor: value == 1 ? '#dc3545' : '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with status change
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/auth/"+methodName+"/"+user_id,
                success: function(data){
                    console.log("user status updated");
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: `User has been ${actionText}d successfully.`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update the toggle data-value for next time
                    $toggle.attr('data-value', value == 1 ? 0 : 1);
                    
                    // Move user to appropriate tab dynamically
                    moveUserToTab($currentRow, user_id, value == 1 ? 'inactive' : 'active');
                },
                error: function(xhr, status, error) {
                    console.error("Error updating user status:", error);
                    // Revert the toggle if there was an error
                    $toggle.prop('checked', !$toggle.prop('checked'));
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update user status. Please try again.',
                        icon: 'error'
                    });
                }
            });    
        } else {
            // User cancelled - revert the toggle
            $toggle.prop('checked', !$toggle.prop('checked'));
        }
    });
});

       
function revertTheUser(obj,user_id){
    // Show confirmation dialog
    Swal.fire({
        title: 'Revert User?',
        text: 'Do you want to revert this user back to active status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, revert!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/auth/revertUser/"+user_id,
                success: function(){
                    console.log("user reverted");
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'User has been reverted to active status successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Move user from inactive tab to active tab dynamically
                    let $currentRow = $(obj).closest('tr');
                    moveUserToTab($currentRow, user_id, 'active');
                },
                error: function(xhr, status, error) {
                    console.error("Error reverting user:", error);
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to revert user. Please try again.',
                        icon: 'error'
                    });
                }
            });
        }
    });  
}

// Function to move user between active and inactive tabs dynamically
function moveUserToTab($row, userId, targetTab) {
    // Get all user data from the current row
    let userData = extractUserDataFromRow($row);
    
    // Remove the row from current tab with animation
    $row.fadeOut(300, function() {
        $(this).remove();
        
        // Add the row to the target tab
        if (targetTab === 'active') {
            // Convert inactive row to active row format
            let activeRowHtml = createActiveUserRow(userData);
            $('#activeUsersTable tbody').prepend(activeRowHtml);
            $('#activeUsersTable tbody tr:first').hide().fadeIn(300);
            
            // Reinitialize DataTable and tooltips for new row
            setTimeout(function() {
                initializeUserTables();
                // removeDuplicatePagination(); // Temporarily disabled
                initializeTooltips();
            }, 400);
            
        } else if (targetTab === 'inactive') {
            // Convert active row to inactive row format
            let inactiveRowHtml = createInactiveUserRow(userData);
            $('#inactiveUsersTable tbody').prepend(inactiveRowHtml);
            $('#inactiveUsersTable tbody tr:first').hide().fadeIn(300);
            
            // Reinitialize DataTable and tooltips for new row
            setTimeout(function() {
                initializeUserTables();
                // removeDuplicatePagination(); // Temporarily disabled
                initializeTooltips();
            }, 400);
        }
    });
}

// Extract user data from a table row
function extractUserDataFromRow($row) {
    return {
        id: $row.find('.id').text() || $row.find('td:nth-child(2)').text(),
        fullName: $row.find('.customer_name').text() || $row.find('td:nth-child(3)').text(),
        username: $row.find('.product_name').text() || $row.find('td:nth-child(4)').text(),
        email: $row.find('.amount').first().text() || $row.find('td:nth-child(5)').text(),
        role: $row.find('.amount').last().text() || $row.find('td:nth-child(6)').text(),
        locations: 'Epping' // Default, could be extracted if needed
    };
}

// Create active user row HTML
function createActiveUserRow(userData) {
    return `
        <tr class="recordRow">
            <th scope="row">
                <div class="form-check">
                    <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="${userData.id}">
                </div>
            </th>
            <td class="id">${userData.id}</td>
            <td class="customer_name">${userData.fullName}</td>
            <td class="product_name">${userData.locations}</td>
            <td class="amount">${userData.email}</td>
            <td class="amount">${userData.role}</td>
            <td>
                <div class="form-check form-switch form-switch-custom form-switch-success">
                    <input class="form-check-input userlisttoggle-demo" type="checkbox" role="switch" data-value="1" data-id="${userData.id}" checked>
                </div>
            </td>
            <td>
                <ul class="list-inline hstack gap-2 mb-0">
                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                        <a href="<?php echo base_url('auth/edit_user/'); ?>${userData.id}" class="text-primary d-inline-block">
                            <i class="ri-eye-fill fs-16"></i>/<i class="ri-pencil-line fs-16"></i>
                        </a>
                    </li>
                    ${userData.role !== 'Admin' ? `
                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                        <a class="text-danger d-inline-block remove-item-btn" data-rel-id="${userData.id}" data-bs-toggle="modal">
                            <i class="ri-delete-bin-5-fill fs-16"></i>
                        </a>
                    </li>
                    ` : ''}
                </ul>
            </td>
        </tr>
    `;
}

// Create inactive user row HTML
function createInactiveUserRow(userData) {
    return `
        <tr class="recordRow">
            <th scope="row">
                <div class="form-check">
                    <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="${userData.id}">
                </div>
            </th>
            <td class="id">
                <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">${userData.id}</a>
            </td>
            <td class="customer_name">${userData.fullName}</td>
            <td class="product_name">${userData.username}</td>
            <td class="amount">${userData.email}</td>
            <td class="amount">${userData.role}</td>
            <td class="status">
                <a href="#" onclick="revertTheUser(this,${userData.id})" class="revert-link">
                    <span class="badge bg-warning text-dark text-uppercase">Revert</span>
                </a>
            </td>
            <td>
                <ul class="list-inline hstack gap-2 mb-0">
                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                        <a href="<?php echo base_url('auth/edit_user/'); ?>${userData.id}" class="text-primary d-inline-block">
                            <i class="ri-eye-fill fs-16"></i>
                        </a>
                    </li>
                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                        <a class="text-danger d-inline-block remove-item-btn" data-rel-id="${userData.id}" data-bs-toggle="modal">
                            <i class="ri-delete-bin-5-fill fs-16"></i>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    `;
}

$('#delete-record').click(function(){
    
     let deleteId =  $(".deletedRecordId").val();
  
               $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/general/record_delete",
                data:'id='+deleteId+'&table_name=Global_users',
                success: function(data){
                //   location.reload();
                  if(data == 'deleted'){
                    $("tr[data-delete-id='" + deleteId + "']").remove();
                  }
                   $("#deleteOrder").modal('hide');
                }
                });
   
    
});
$('.remove-item-btn').click(function(){
    $("#deleteOrder").modal('show');
    let id = $(this).attr('data-rel-id');
    $(".deletedRecordId").val(id);
    $(this).closest('.recordRow').attr("data-delete-Id", id);
    
     
});

// REPLACE WITH NEW CLEAN CHECKBOX - SAME DESIGN, CLEAN FUNCTIONALITY
$(document).ready(function() {
    
    // STEP 1: Hide the problematic original checkbox
    $('#checkAll').hide();
    
    // STEP 2: Create a brand new checkbox that looks identical
    const $headerCell = $('#checkAll').closest('th');
    const $formCheck = $('#checkAll').closest('.form-check');
    
    // Remove the button if it exists
    $('#workingSelectAll').remove();
    
    // Create new checkbox with identical styling
    if ($('#newCheckAll').length === 0) {
        $formCheck.append('<input class="form-check-input" type="checkbox" id="newCheckAll" value="option">');
    }
    
    // STEP 3: Apply the WORKING logic to the new checkbox
    $('#newCheckAll').off().on('change', function() {
        const isChecked = this.checked;
        console.log('New clean checkbox clicked:', isChecked);
        
        // Use the EXACT working logic from the button
        $('.table tbody tr').each(function() {
            const $row = $(this);
            
            // Get the first cell (th or td)
            const $firstCell = $row.find('th:first, td:first');
            
            // Find checkbox in first cell that has a numeric value (user ID)
            const $checkbox = $firstCell.find('input[type="checkbox"]').filter(function() {
                const value = $(this).val();
                return value && /^\d+$/.test(value); // Only numeric values (user IDs)
            });
            
            // Update only if we found a valid row selection checkbox
            if ($checkbox.length === 1) {
                console.log('Updating checkbox for user ID:', $checkbox.val());
                $checkbox.prop('checked', isChecked);
                
                if (isChecked) {
                    $row.addClass('selected');
                } else {
                    $row.removeClass('selected');
                }
            }
        });
    });
    
    // Handle individual row checkboxes (unchanged)
    $(document).on('change', '.table tbody input[type="checkbox"]', function(e) {
        // Only handle row selection checkboxes (numeric values)
        if ($(this).val() && /^\d+$/.test($(this).val()) && !$(this).hasClass('userlisttoggle-demo')) {
            const row = $(this).closest('tr');
            if (this.checked) {
                row.addClass('selected');
            } else {
                row.removeClass('selected');
            }
        }
    });
    
    console.log('New clean checkbox created with working logic');
    
    // SEARCH FUNCTIONALITY FOR BOTH TABS
    $('.search').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        
        // Search in Active tab
        $('#activeuserTab tbody tr').each(function() {
            const $row = $(this);
            const userId = $row.find('.id').text().toLowerCase();
            const fullName = $row.find('.customer_name').text().toLowerCase();
            const location = $row.find('.product_name').text().toLowerCase();
            const email = $row.find('.amount').first().text().toLowerCase();
            const role = $row.find('.amount').eq(1).text().toLowerCase();
            
            const isMatch = userId.includes(searchTerm) || 
                           fullName.includes(searchTerm) || 
                           location.includes(searchTerm) || 
                           email.includes(searchTerm) || 
                           role.includes(searchTerm);
            
            $row.toggle(isMatch);
        });
        
        // Search in Inactive tab
        $('#cancelledUserTab tbody tr').each(function() {
            const $row = $(this);
            const userId = $row.find('.id').text().toLowerCase();
            const fullName = $row.find('.customer_name').text().toLowerCase();
            const username = $row.find('.product_name').text().toLowerCase();
            const email = $row.find('.amount').first().text().toLowerCase();
            const role = $row.find('.amount').eq(1).text().toLowerCase();
            
            const isMatch = userId.includes(searchTerm) || 
                           fullName.includes(searchTerm) || 
                           username.includes(searchTerm) || 
                           email.includes(searchTerm) || 
                           role.includes(searchTerm);
            
            $row.toggle(isMatch);
        });
        
        // Show/hide "no results" message for each tab
        updateNoResultsMessage('#activeuserTab', searchTerm);
        updateNoResultsMessage('#cancelledUserTab', searchTerm);
    });
    
    // Function to show/hide "no results" message
    function updateNoResultsMessage(tabSelector, searchTerm) {
        const $tab = $(tabSelector);
        const $visibleRows = $tab.find('tbody tr:visible');
        const $noResultDiv = $tab.find('.noresult');
        
        if (searchTerm && $visibleRows.length === 0) {
            $noResultDiv.show();
            $noResultDiv.find('p').text(`We've searched for "${searchTerm}" but found no matching users.`);
        } else {
            $noResultDiv.hide();
        }
    }
    
    // Initialize and fix tooltips
    initializeTooltips();
    
    function initializeTooltips() {
        // Destroy existing tooltips first
        $('[data-bs-toggle="tooltip"]').tooltip('dispose');
        
        // Initialize tooltips with proper configuration
        $('[data-bs-toggle="tooltip"]').tooltip({
            container: 'body',
            placement: 'top',
            trigger: 'hover focus',
            delay: { "show": 300, "hide": 100 },
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
        });
        
        // Fix positioning issues by ensuring proper container
        $('[data-bs-toggle="tooltip"]').on('show.bs.tooltip', function() {
            $(this).tooltip('update');
        });
    }
    
    // Reinitialize tooltips when tab switches
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
        setTimeout(initializeTooltips, 100);
    });

    // Initialize DataTables for both Active and Inactive Users tables with sorting
    function initializeUserTables() {
        // Common DataTable configuration - Modified for Users (10 per page to show pagination)
        const dataTableConfig = {
            pageLength: 10,
            bPaginate: true,
            bInfo: true,
            bFilter: false, // Disable DataTables search since we have global search
            searching: false, // Disable search functionality
            lengthMenu: [10, 25, 50, 100],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false
                }
            ],
            "order": [[ 1, "asc" ]] // Default sort by User ID (column index 1)
        };

        // Initialize Active Users Table
        if ($.fn.DataTable.isDataTable('#activeUsersTable')) {
            $('#activeUsersTable').DataTable().destroy();
        }
        $('#activeUsersTable').DataTable(dataTableConfig);
        
        // Initialize Inactive Users Table - same config as Patient List
        if ($.fn.DataTable.isDataTable('#inactiveUsersTable')) {
            $('#inactiveUsersTable').DataTable().destroy();
        }
        $('#inactiveUsersTable').DataTable(dataTableConfig);

        // Final cleanup after both tables are initialized
        setTimeout(function() {
            removeDuplicatePagination();
        }, 100);
    }

    // Function to remove duplicate pagination controls (aggressive cleanup)
    function removeDuplicatePagination() {
        console.log('Starting pagination cleanup...');
        
        // Step 1: Remove any pagination controls outside of DataTables wrappers
        $('.dataTables_paginate').each(function() {
            const $paginate = $(this);
            const $wrapper = $paginate.closest('.dataTables_wrapper');
            
            if ($wrapper.length === 0) {
                console.log('Removing orphaned pagination control');
                $paginate.remove();
            }
        });
        
        // Step 2: For each DataTables wrapper, keep only the first pagination control
        $('.dataTables_wrapper').each(function(wrapperIndex) {
            const $wrapper = $(this);
            const $paginateControls = $wrapper.find('.dataTables_paginate');
            
            console.log(`Wrapper ${wrapperIndex}: Found ${$paginateControls.length} pagination controls`);
            
            if ($paginateControls.length > 1) {
                console.log(`Removing ${$paginateControls.length - 1} duplicate pagination controls from wrapper ${wrapperIndex}`);
                $paginateControls.not(':first').remove();
            }
        });
        
        // Step 3: Final check - should have exactly 2 pagination controls (one per table)
        const finalCount = $('.dataTables_paginate').length;
        console.log(`Final pagination control count: ${finalCount}`);
        
        if (finalCount > 2) {
            console.log(`Still too many (${finalCount}), removing excess`);
            $('.dataTables_paginate').slice(2).remove();
        }
        
        // Step 4: Hide any remaining duplicates with CSS as backup
        $('.dataTables_paginate').each(function(index) {
            if (index >= 2) {
                $(this).hide();
            }
        });
        
        console.log('Pagination cleanup complete. Final count:', $('.dataTables_paginate:visible').length);
    }

    // Initialize tables on page load
    initializeUserTables();


    // Global search functionality for both tables
    $('.search-box input.search').on('keyup', function() {
        let searchValue = this.value;
        
        // Apply search to both tables
        $('#activeUsersTable').DataTable().search(searchValue).draw();
        $('#inactiveUsersTable').DataTable().search(searchValue).draw();
    });

    // Reinitialize tables when switching tabs to ensure proper display
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        setTimeout(function() {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            // removeDuplicatePagination(); // Remove any duplicate pagination (temporarily disabled)
            initializeTooltips(); // Also reinitialize tooltips
        }, 100);
    });
});
</script>

<style>
/* Improve Action Button Colors */
.list-inline-item a {
    transition: all 0.2s ease;
    padding: 4px 6px;
    border-radius: 4px;
}

.list-inline-item a:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* View/Edit button - blue color */
.list-inline-item a.text-primary {
    color: #0d6efd !important;
}

.list-inline-item a.text-primary:hover {
    color: #0b5ed7 !important;
    background-color: rgba(13, 110, 253, 0.1) !important;
}

/* Delete button - red color */
.list-inline-item a.text-danger {
    color: #dc3545 !important;
}

.list-inline-item a.text-danger:hover {
    color: #bb2d3b !important;
    background-color: rgba(220, 53, 69, 0.1) !important;
}

/* Revert Link Styling */
.revert-link {
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.revert-link:hover {
    text-decoration: underline !important;
    transform: translateY(-1px);
}

.revert-link .badge {
    transition: all 0.2s ease;
    cursor: pointer;
}

.revert-link:hover .badge {
    background-color: #ffc107 !important;
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
}

/* Keep original switch styling - removed custom colors */

/* Fix Status Column Visibility in Inactive Tab - More Specific Targeting */
#cancelledUserTab .status,
#cancelledUserTab .status a,
#cancelledUserTab .status a span,
#cancelledUserTab .status .revert-link,
#cancelledUserTab .status .badge,
#cancelledUserTab .status .badge-warning,
#cancelledUserTab .status .bg-warning {
    color: #000 !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    background-color: #ffc107 !important;
    border: 1px solid #ffc107 !important;
}

/* Force revert button to be always visible */
#cancelledUserTab tbody tr .status a span.badge {
    background-color: #ffc107 !important;
    color: #212529 !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    padding: 0.35em 0.65em !important;
    font-size: 0.75em !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    text-align: center !important;
    white-space: nowrap !important;
    vertical-align: baseline !important;
    border-radius: 0.375rem !important;
}

/* Ensure all text in inactive tab is visible */
#cancelledUserTab tbody td {
    color: #000 !important;
    opacity: 1 !important;
}

/* Override any hover-only styles */
#cancelledUserTab .status a:not(:hover) span.badge {
    background-color: #ffc107 !important;
    color: #212529 !important;
    opacity: 1 !important;
    visibility: visible !important;
}

/* Additional force visibility rules */
.tab-pane#cancelledUserTab .status * {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Target the specific badge class structure */
#cancelledUserTab td.status a span {
    background-color: #ffc107 !important;
    color: #212529 !important;
    display: inline-block !important;
    opacity: 1 !important;
    visibility: visible !important;
    padding: 0.35em 0.65em !important;
    font-size: 0.75em !important;
    font-weight: 700 !important;
    border-radius: 0.375rem !important;
}

/* Nuclear option - force everything in status column to be visible */
div[id="cancelledUserTab"] td.status,
div[id="cancelledUserTab"] td.status a,
div[id="cancelledUserTab"] td.status a span {
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    background-color: #ffc107 !important;
    color: #212529 !important;
}

/* Icon improvements */
.ri-eye-fill, .ri-pencil-line {
    font-size: 14px !important;
}

.ri-delete-bin-5-fill {
    font-size: 14px !important;
}

/* Hover effects for better UX */
.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

/* Fix Tooltip Styling and Positioning */
.tooltip {
    z-index: 9999 !important;
    position: absolute !important;
}

.tooltip .tooltip-inner {
    background-color: #212529 !important;
    color: #ffffff !important;
    padding: 0.5rem 0.75rem !important;
    border-radius: 0.375rem !important;
    font-size: 0.875rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    text-align: center !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    max-width: 200px !important;
    word-wrap: break-word !important;
}

.tooltip.bs-tooltip-top .tooltip-arrow::before,
.tooltip.bs-tooltip-auto[x-placement^="top"] .tooltip-arrow::before {
    border-top-color: #212529 !important;
}

.tooltip.bs-tooltip-right .tooltip-arrow::before,
.tooltip.bs-tooltip-auto[x-placement^="right"] .tooltip-arrow::before {
    border-right-color: #212529 !important;
}

.tooltip.bs-tooltip-bottom .tooltip-arrow::before,
.tooltip.bs-tooltip-auto[x-placement^="bottom"] .tooltip-arrow::before {
    border-bottom-color: #212529 !important;
}

.tooltip.bs-tooltip-left .tooltip-arrow::before,
.tooltip.bs-tooltip-auto[x-placement^="left"] .tooltip-arrow::before {
    border-left-color: #212529 !important;
}

/* Force tooltip positioning to be relative to trigger element */
[data-bs-toggle="tooltip"] {
    position: relative !important;
}

/* Ensure tooltips don't get clipped */
.table-responsive {
    overflow: visible !important;
}

/* Alternative: If tooltips still misbehave, use custom tooltip positioning */
.list-inline-item {
    position: relative !important;
}

/* Fix any conflicting Bootstrap tooltip styles */
.tooltip-inner {
    background-color: #212529 !important;
    color: #fff !important;
    border: 1px solid #212529 !important;
}

.bs-tooltip-top .arrow::before,
.bs-tooltip-auto[x-placement^="top"] .arrow::before {
    border-top-color: #212529 !important;
}

.bs-tooltip-right .arrow::before,
.bs-tooltip-auto[x-placement^="right"] .arrow::before {
    border-right-color: #212529 !important;
}

.bs-tooltip-bottom .arrow::before,
.bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
    border-bottom-color: #212529 !important;
}

.bs-tooltip-left .arrow::before,
.bs-tooltip-auto[x-placement^="left"] .arrow::before {
    border-left-color: #212529 !important;
}

/* Fix show entries dropdown overlap - EXACT from Patient List */
.dataTables_length select {
    width: auto !important;
    min-width: 60px !important;
    padding-right: 30px !important;
    background-position: calc(100% - 8px) center !important;
    background-size: 12px !important;
}

.dataTables_length label {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 0 !important;
    font-weight: normal !important;
}

.dataTables_length select:focus {
    border-color: #80bdff !important;
    outline: 0 !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}

/* EXACT COPY from Patient List page pagination styling */
.dataTables_wrapper .dataTables_paginate .paginate_button,
.dataTables_wrapper .dataTables_paginate .paginate_button a {
    color: #495057 !important;
    background: #fff !important;
    border: 1px solid #dee2e6 !important;
    padding: 0.5rem 0.75rem !important;
    margin: 0 2px !important;
    border-radius: 0.375rem !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover a {
    color: #fff !important;
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current a {
    color: #fff !important;
    background: #0d6efd !important;
    border-color: #0d6efd !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled a {
    color: #6c757d !important;
    background: #fff !important;
    border-color: #dee2e6 !important;
    cursor: not-allowed !important;
    text-decoration: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover a {
    color: #6c757d !important;
    background: #fff !important;
    border-color: #dee2e6 !important;
}

/* Improve overall DataTables layout - Patient List style */
.dataTables_wrapper .dataTables_length {
    margin-bottom: 1rem;
}

/* Hide DataTables search since we use global search */
.dataTables_wrapper .dataTables_filter {
    display: none !important;
}

.dataTables_wrapper .dataTables_info {
    padding-top: 0.75rem;
    color: #6c757d;
}

.dataTables_wrapper .dataTables_paginate {
    padding-top: 0.75rem;
}

/* Ensure proper spacing */
.dataTables_wrapper .row {
    margin: 0;
}

.dataTables_wrapper .row > div {
    padding: 0 0.75rem;
}

/* Ensure default DataTables sorting icons work properly */
.dataTables_wrapper table.dataTable thead th {
    position: relative;
}

.dataTables_wrapper table.dataTable thead .sorting,
.dataTables_wrapper table.dataTable thead .sorting_asc,
.dataTables_wrapper table.dataTable thead .sorting_desc {
    cursor: pointer;
}

/* Let DataTables use its default sorting icons (same as Patient List) */
.dataTables_wrapper table.dataTable thead .sorting:before,
.dataTables_wrapper table.dataTable thead .sorting:after,
.dataTables_wrapper table.dataTable thead .sorting_asc:before,
.dataTables_wrapper table.dataTable thead .sorting_asc:after,
.dataTables_wrapper table.dataTable thead .sorting_desc:before,
.dataTables_wrapper table.dataTable thead .sorting_desc:after {
    position: absolute;
    bottom: 0.9em;
    display: block;
    opacity: 0.3;
}

.dataTables_wrapper table.dataTable thead .sorting_asc:before,
.dataTables_wrapper table.dataTable thead .sorting_desc:after {
    opacity: 1;
}

/* Override any theme conflicts for pagination current state - EXACT Patient List style */
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:focus,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:active,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:visited,
.dataTables_wrapper .dataTables_paginate .paginate_button.current a,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover a {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #fff !important;
    font-weight: normal !important;
    box-shadow: none !important;
    text-shadow: none !important;
    text-decoration: none !important;
}

/* Ensure pagination wrapper has proper styling */
.dataTables_wrapper .dataTables_paginate {
    float: right !important;
    text-align: right !important;
    padding-top: 0.75rem !important;
}

/* AGGRESSIVE duplicate pagination removal */
/* Hide any pagination controls beyond the first 2 globally */
.dataTables_paginate:nth-of-type(n+3) {
    display: none !important;
}

/* Hide duplicate pagination within same wrapper */
.dataTables_wrapper .dataTables_paginate + .dataTables_paginate {
    display: none !important;
}

/* Hide any pagination outside of proper wrappers */
body > .dataTables_paginate,
.container > .dataTables_paginate,
.tab-pane > .dataTables_paginate {
    display: none !important;
}

/* Ensure only one pagination per DataTable wrapper */
.dataTables_wrapper .dataTables_paginate:not(:first-of-type) {
    display: none !important;
}

/* Hide any floating or misplaced pagination controls */
.dataTables_paginate:not(.dataTables_wrapper .dataTables_paginate) {
    display: none !important;
}

/* Fix pagination button spacing and alignment */
.dataTables_wrapper .dataTables_paginate .pagination {
    margin: 0 !important;
}

.dataTables_wrapper .dataTables_paginate span {
    display: inline-flex !important;
    align-items: center !important;
    gap: 2px !important;
}

/* Ensure page number buttons are visible and clickable */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    cursor: pointer !important;
    user-select: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:not(.disabled) {
    pointer-events: auto !important;
}

/* Style for First, Last, Previous, Next buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button.first,
.dataTables_wrapper .dataTables_paginate .paginate_button.last,
.dataTables_wrapper .dataTables_paginate .paginate_button.previous,
.dataTables_wrapper .dataTables_paginate .paginate_button.next {
    background: #f8f9fa !important;
    border-color: #dee2e6 !important;
    color: #6c757d !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.first:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.last:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
    background: #e9ecef !important;
    border-color: #adb5bd !important;
    color: #495057 !important;
}

</style>