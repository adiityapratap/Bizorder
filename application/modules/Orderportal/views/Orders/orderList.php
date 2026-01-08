
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
                                <div>
                                    <h5 class="card-title mb-0 text-black">Order History</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <!--<a class="btn btn-success add-btn btn" href="<?php echo base_url('Orderportal/Patient/addCustomer') ?>"><i class="ri-add-line align-bottom me-1"></i> Add Client</a>-->
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form id="order_filters">
                            <div class="row g-3">
                    <div class="d-flex flex-column flex-md-row gap-2 col-xl-3">
                                   
                      <div class="custom_date_schedule">
                      <input type="text" required class="form-control flatpickr-input active startDate"  data-provider="flatpickr" data-date-format="d-m-Y" placeholder="Start date" readonly>
                      </div>

                     <div class="custom_date_schedule">
                      <input type="text"  required class="form-control flatpickr-input active endDate" data-provider="flatpickr" data-date-format="d-m-Y"  placeholder="End date" readonly>
                      </div>
                      </div>
                                
                              <!--  <div class="col-xl-2">
                                    <?php if(isset($departmentListData) && !empty($departmentListData))  { ?>
                                    <select class="form-select" name="department_name" id="department_name">
                                    <option value="all" selected >All Departments</option>
                                    <?php foreach($departmentListData as $departmentList) {  ?>
                                     <option value="<?php echo $departmentList['name'] ?>"><?php echo $departmentList['name'] ?></option>
                                    <?php  } ?>
                                    </select>
                                     <?php } ?>
                                </div> -->
                                <!--end col-->
                               
                                <div class="col-xl-2">
                                  <select class="form-select" name="order_status" id="order_status">
                                  <option value="all" selected>All</option>
                                  <option value="cancelled">Cancelled</option>
                                  <option value="pending">Pending</option>
                                  <option value="paid">Paid</option>
                                  <option value="ready">Ready for Delivery</option>
                                  <option value="delivered">Delivered</option>
                                 </select>
                                </div>
                               
                                <!--end col-->
                                <div class="col-xl-2">
                                     <input class="form-control " id="order_id" type="text" placeholder="Order Id">
                                </div>
                               
                               <div class="col-xl-2">
                             <a class="btn btn-danger shadow-none resetFilter" style="padding: 0.5rem 1rem !important; width: auto !important; display: inline-flex !important; align-items: center !important; gap: 0.5rem !important;"><i class="mdi mdi-refresh" style="color: white !important;"></i> Reset Filter</a>
                                </div>
                                
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                    
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-1">
                                
                                <table class="table align-middle " id="orderTable">
                                    <thead class="table-dark text-white">
                                        <tr>
                                            <th class="sort" data-sort="order_id">Order Id</th>
                                            <th class="sort" data-sort="date">Order Date</th>
                                           <th class="sort" data-sort="name">Floor</th>
                                           <th class="sort" data-sort="status">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 0; if(!empty($orderLists)){ ?>
                                    <tbody class="list form-check-all" id="formRow">
    <?php foreach($orderLists as $orderList): 
        // Enhanced status display with proper workflow states - UPDATED FOR FLOOR CONSOLIDATION
        $this->load->model('status_compatibility_model');
        $displayStatus = $this->status_compatibility_model->getDisplayStatus($orderList);
        
        $statustext = $displayStatus['text'];
        $sucessClass = $displayStatus['class'];
        
        // Show additional info for floor orders
        $isFloorOrder = isset($orderList['is_floor_consolidated']) && $orderList['is_floor_consolidated'] == 1;
        $suiteInfo = '';
        if ($isFloorOrder && isset($orderList['total_suites']) && $orderList['total_suites'] > 0) {
            $suiteInfo = " ({$orderList['total_suites']} suites)";
        }
    ?>
    <tr class="ordertableRow">
        <td class="order_id"><?php echo $orderList['order_id'] ?></td>
        <td class="date"><?php echo date('d-m-Y', strtotime($orderList['date'])) ?></td>
        <td class="department_name"><?php echo $orderList['name'] . $suiteInfo ?></td>
        <td class="status"><span class="badge <?php echo $sucessClass ?>  text-uppercase statusLabel" style="<?php echo (strpos($sucessClass, 'bg-success') !== false || strpos($sucessClass, 'bg-primary') !== false || strpos($sucessClass, 'bg-info') !== false) ? 'color: #fff !important;' : ''; ?>"><?php echo $statustext ?> </span> </td>
         <td>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Always show View Order -->
                <a href="<?php echo base_url('Orderportal/Order/viewHistoricalOrder/'.$orderList['order_id'].'/'.$orderList['date'].'/'.$orderList['dept_id']); ?>" class="btn btn-sm btn-outline-primary">
                    <i class="ri-eye-line me-1"></i>View Order</a>
                
                <?php 
                // Check if order date is today or tomorrow for Chef View button
                $orderDate = strtotime($orderList['date']);
                $today = strtotime(date('Y-m-d'));
                $tomorrow = strtotime(date('Y-m-d', strtotime('+1 day')));
                $showChefView = ($orderDate == $today || $orderDate == $tomorrow);
                ?>
                
                <!-- Show Chef View only for today's and tomorrow's orders -->
                <?php if ($showChefView): ?>
                    <a href="<?php echo base_url('Orderportal/Order/viewProductionForm/'.$orderList['date']); ?>" class="btn btn-sm btn-outline-info">
                        <i class="ri-chef-hat-line me-1"></i>Chef View</a>
                <?php endif; ?>
                
                <!-- Show different actions based on status -->
                <?php if ($orderList['status'] == 3): // Ready for Delivery ?>
                    <a href="<?php echo base_url('Orderportal/Order/viewOrderPatientwise/delivery/'.$orderList['dept_id']) ?>/true" class="btn btn-sm btn-outline-warning">
                        <i class="ri-truck-line me-1"></i>Delivery</a>
                        
                <?php elseif ($orderList['status'] == 4): // Delivered ?>
                    <button onclick="markOrderPaid(<?php echo $orderList['order_id']; ?>)" class="btn btn-sm btn-outline-success">
                        <i class="ri-money-dollar-circle-line me-1"></i>Mark Paid</button>
                        
                <?php elseif ($orderList['status'] == 2): // Paid ?>
                    <a href="<?php echo base_url('Orderportal/Invoice/viewInvoice/'.$orderList['date']); ?>" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="ri-file-text-line me-1"></i>Invoice</a>
                <?php endif; ?>
                
                <!-- Order Status History -->
                <button onclick="showOrderHistory(<?php echo $orderList['order_id']; ?>)" class="btn btn-sm btn-outline-dark" title="Order History">
                    <i class="ri-history-line"></i></button>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

                                    <?php } ?>
                                </table>
                                
                                
                               
                            </div>
                       
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
                                                                        <button type="button" class="btn btn-danger btn" data-bs-dismiss="modal">Close</button>
                                                                        <a class="btn btn-success btn"><i class="ri-mail-check-line align-middle me-1"></i> Send Email</a>
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

$(document).ready(function () {
    
    flatpickr(".startDate", {
        dateFormat: "d-m-Y",
        onChange: function () {
            filterTable();
        },
    });

    flatpickr(".endDate", {
        dateFormat: "d-m-Y",
        onChange: function () {
            filterTable();
        },
    });
    
    $('#order_filters input').on('keyup', function () {
        filterTable();
    });

    $('#order_filters select').on('change', function () {
        filterTable();
    });
    

   function filterTable() {
    // Get filter input values
    let order_id = $('#order_id').val();
    let order_status = $('#order_status').val().toLowerCase();
    // let department_name = $('#department_name').val().toLowerCase();

    let startDate = $('.startDate').val();
    let endDate = $('.endDate').val();

    let startDateObj = startDate ? new Date(startDate.split('-').reverse().join('-')) : null;
    let endDateObj = endDate ? new Date(endDate.split('-').reverse().join('-')) : null;

    // Loop through all table rows to filter based on inputs
    $('#orderTable tbody tr').each(function () {
        let row = $(this);
        let rowOrderID = row.find('.order_id').text().toLowerCase();
        let rowDate = row.find('.date').text().toLowerCase();
        let rowName = row.find('.department_name').text().toLowerCase();
        let rowStatus = row.find('.statusLabel').text().toLowerCase();
        // console.log("order_status",order_status)
         
        // if (department_name === 'all') {
        //     department_name = '';
        // }

        let rowDateObj = new Date(rowDate.split('-').reverse().join('-'));

        // Check if the row matches the filters
        let dateMatch = (!startDateObj || rowDateObj >= startDateObj) && (!endDateObj || rowDateObj <= endDateObj);
        let statusMatch = 
            (order_status === 'all') || 
            (order_status === 'cancelled' && rowStatus.includes('cancelled')) || 
            (order_status === 'pending' && rowStatus.includes('pending')) || 
            (order_status === 'paid' && rowStatus.includes('paid')) || 
            (order_status === 'ready' && rowStatus.includes('ready')) || 
            (order_status === 'delivered' && rowStatus.includes('delivered')) || 
            (order_status === 'paid' && rowStatus.includes('paid'));
          // console.log("statusMatch",statusMatch)
        // Final check for all filters
        if (
            rowOrderID.includes(order_id) &&
            dateMatch &&
            statusMatch
        ) {
            row.show(); // Show matching row
        } else {
            row.hide(); // Hide non-matching row
        }
    });
}

    
    
    $('.resetFilter').on('click', function () {
        $('#order_filters input').val('');
        $('#order_filters select').val('all');
       
        $(".startDate, .endDate").val("");
        $('#orderTable tbody tr').show();
    });
    
});



 function markPaid(obj,order_id){
         
          $(obj).html("Loading...");
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markPaid") ?>',
        type: 'POST',
        data: {
            order_id: order_id
        },
        success: function(response) {
            let res = JSON.parse(response)
          
            if (res.status == 'success') {
                $(obj).parents(".ordertableRow").find(".statusLabel").html("Paid");
                $(obj).parents(".ordertableRow").find(".statusLabel").removeClass("bg-danger-subtle text-danger").addClass("bg-success-subtle text-success")
                $(obj).removeAttr('onclick');
                $(obj).html('<i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid');
            } else {
                 $(obj).html('<i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid');
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
// Mark order as paid
function markOrderPaid(orderId) {
    if (confirm('Are you sure you want to mark this order as paid?')) {
        $.ajax({
            url: '<?php echo base_url("Orderportal/Order/markPaid"); ?>',
            type: 'POST',
            data: {
                order_id: orderId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Order marked as paid successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Failed to mark order as paid');
            }
        });
    }
}

// Show order status history
function showOrderHistory(orderId) {
    // console.log('Fetching history for order ID:', orderId);
    
    $.ajax({
        url: '<?php echo base_url("Orderportal/Order/getOrderHistory"); ?>',
        type: 'POST',
        data: {
            order_id: orderId
        },
        dataType: 'json',
        beforeSend: function() {
            // Show loading indicator if needed
            // console.log('Loading order history...');
        },
        success: function(response) {
            // console.log('History response:', response);
            
            if (response.status === 'success' && response.data && response.data.length > 0) {
                let historyHtml = '<div class="order-history">';
                historyHtml += '<h5 class="mb-4"><i class="ri-history-line me-2"></i>Order #' + orderId + ' Status History</h5>';
                
                // Get current order status from latest history entry
                const currentStatus = response.data[response.data.length - 1].new_status;
                
                // Add status update form for admin (check if user is admin)
                <?php if($this->ion_auth->is_admin()): ?>
                historyHtml += '<div class="status-update-section mb-4">';
                historyHtml += '<div class="alert alert-info mb-3">';
                historyHtml += '<strong><i class="ri-admin-line me-2"></i>Admin Control:</strong> Update order status if needed (e.g., if status was not updated automatically or by mistake)';
                historyHtml += '</div>';
                historyHtml += '<form id="updateStatusForm" class="status-update-form">';
                historyHtml += '<div class="row g-3 align-items-start">';
                historyHtml += '<div class="col-md-4">';
                historyHtml += '<label class="form-label fw-bold">New Status:</label>';
                historyHtml += '<select class="form-select" name="new_status" id="newStatusSelect" required>';
                historyHtml += '<option value="">-- Select Status --</option>';
                
                // Always show Pending and Cancelled
                historyHtml += '<option value="1">🟡 Pending - Order placed, waiting for chef to prepare</option>';
                historyHtml += '<option value="0">🔴 Cancelled - Order cancelled/rejected</option>';
                
                // Only show Ready for Delivery if not already Delivered or Paid
                if (currentStatus != 4 && currentStatus != 2) {
                    historyHtml += '<option value="3">🔵 Ready for Delivery - Chef completed all items, ready to deliver</option>';
                }
                
                // Only show Delivered if not already Delivered or Paid
                if (currentStatus != 4 && currentStatus != 2) {
                    historyHtml += '<option value="4">🟢 Delivered - Food delivered to patient (Invoice auto-generated)</option>';
                }
                
                // NEVER show Paid option - payment status is managed by payment system only
                
                historyHtml += '</select>';
                historyHtml += '</div>';
                historyHtml += '<div class="col-md-5">';
                historyHtml += '<label class="form-label fw-bold">Reason for Update:</label>';
                historyHtml += '<input type="text" class="form-control" name="reason" placeholder="E.g., Forgot to mark as delivered" required>';
                historyHtml += '</div>';
                historyHtml += '<div class="col-md-3">';
                historyHtml += '<label class="form-label fw-bold">&nbsp;</label>';
                historyHtml += '<button type="submit" class="btn btn-primary w-100 d-block"><i class="ri-refresh-line me-1"></i>Update Status</button>';
                historyHtml += '</div>';
                historyHtml += '</div>';
                
                // Show warning/note below the form
                historyHtml += '<div class="row mt-2">';
                historyHtml += '<div class="col-12">';
                if (currentStatus == 4 || currentStatus == 2) {
                    historyHtml += '<small class="text-danger"><strong>⚠️ Note:</strong> Order already ' + (currentStatus == 4 ? 'delivered' : 'paid') + '. Only reverse status changes (Pending/Cancelled) are available.</small>';
                } else {
                    historyHtml += '<small class="text-muted"><strong>💡 Note:</strong> Invoice is automatically generated when status changes to "Delivered"</small>';
                }
                historyHtml += '</div>';
                historyHtml += '</div>';
                historyHtml += '</form>';
                historyHtml += '</div>';
                <?php endif; ?>
                
                historyHtml += '<div class="timeline">';
                
                response.data.forEach(function(item, index) {
                    const statusText = getStatusText(item.new_status);
                    const oldStatusText = item.old_status ? getStatusText(item.old_status) : null;
                    const date = new Date(item.changed_date).toLocaleString();
                    const userName = item.changed_by_name || 'Unknown User';
                    const username = item.changed_by_username ? ' (@' + item.changed_by_username + ')' : '';
                    
                    // Determine status badge color
                    // Status flow: 1 (Pending) → 3 (Ready) → 4 (Delivered) → 2 (Paid)
                    let badgeClass = 'bg-secondary';
                    if (item.new_status == 1) badgeClass = 'bg-warning text-dark'; // Pending - Yellow
                    else if (item.new_status == 3) badgeClass = 'bg-info text-white'; // Ready - Blue
                    else if (item.new_status == 4) badgeClass = 'bg-primary text-white'; // Delivered - Primary Blue
                    else if (item.new_status == 2) badgeClass = 'bg-success text-white'; // Paid - Green
                    else if (item.new_status == 0) badgeClass = 'bg-danger text-white'; // Cancelled - Red
                    
                    historyHtml += '<div class="timeline-item">';
                    historyHtml += '<div class="timeline-marker ' + (index === 0 ? 'timeline-marker-start' : '') + '"></div>';
                    historyHtml += '<div class="timeline-content">';
                    
                    // Status change
                    if (oldStatusText) {
                        historyHtml += '<h6 class="mb-2"><span class="badge bg-light text-dark" style="color: #000 !important;">' + oldStatusText + '</span> ';
                        historyHtml += '<i class="ri-arrow-right-line mx-1"></i> ';
                        historyHtml += '<span class="badge ' + badgeClass + '" style="font-weight: 600;">' + statusText + '</span></h6>';
                    } else {
                        historyHtml += '<h6 class="mb-2"><span class="badge ' + badgeClass + '" style="font-weight: 600;">' + statusText + '</span></h6>';
                    }
                    
                    // User and date info
                    historyHtml += '<div class="d-flex align-items-center gap-3 mb-2">';
                    historyHtml += '<small class="history-user-text"><i class="ri-user-line me-1"></i><strong>' + userName + '</strong>' + username + '</small>';
                    historyHtml += '<small class="history-date-text"><i class="ri-time-line me-1"></i>' + date + '</small>';
                    historyHtml += '</div>';
                    
                    // Reason/notes
                    if (item.reason && item.reason !== 'Status updated') {
                        historyHtml += '<p class="mb-0 history-reason-text"><em><i class="ri-information-line me-1"></i>' + item.reason + '</em></p>';
                    }
                    
                    historyHtml += '</div></div>';
                });
                
                historyHtml += '</div></div>';
                
                // Show in a Bootstrap modal
                showHistoryModal(historyHtml, orderId);
            } else {
                alert('No status history available for this order yet.\n\nThis order may have been created before status logging was implemented.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            alert('Failed to load order history. Please try again.\n\nError: ' + error);
        }
    });
}

// Show history in a modal
function showHistoryModal(content, orderId) {
    // Create modal if it doesn't exist
    if (!$('#historyModal').length) {
        $('body').append(`
            <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Order History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="historyContent">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
    
    $('#historyContent').html(content);
    $('#historyModal').modal('show');
    
    // Attach form submit handler for admin status update
    $('#updateStatusForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        const newStatus = $(this).find('select[name="new_status"]').val();
        const reason = $(this).find('input[name="reason"]').val();
        const $submitBtn = $(this).find('button[type="submit"]');
        
        if (!newStatus || !reason) {
            showAlertModal('❌ Validation Error', 'Please select a status and provide a reason for the update.', 'error');
            return;
        }
        
        // Show confirmation modal
        showConfirmModal(
            '⚠️ Confirm Status Update',
            'Are you sure you want to update the order status?<br><br>This action will be logged in the order history.',
            function() {
                // User confirmed - proceed with update
                submitStatusUpdate(orderId, newStatus, reason, $submitBtn);
            }
        );
    });
}

// Function to actually submit the status update
function submitStatusUpdate(orderId, newStatus, reason, $submitBtn) {
    // Disable submit button to prevent double submission
    $submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line me-1 spinner-border spinner-border-sm"></i>Updating...');
    
    $.ajax({
        url: '<?php echo base_url("Orderportal/Order/adminUpdateOrderStatus"); ?>',
        type: 'POST',
        data: {
            order_id: orderId,
            new_status: newStatus,
            reason: reason
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                showAlertModal(
                    '✅ Success',
                    '<div class="text-center"><i class="ri-checkbox-circle-line text-success" style="font-size: 48px;"></i><br><br><strong>Order status updated successfully!</strong><br><br>' + response.message + '</div>',
                    'success',
                    function() {
                        $('#historyModal').modal('hide');
                        location.reload();
                    }
                );
            } else {
                showAlertModal('❌ Error', response.message, 'error');
                $submitBtn.prop('disabled', false).html('<i class="ri-refresh-line me-1"></i>Update Status');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            showAlertModal('❌ Error', 'Failed to update status. Please try again.<br><br>Error: ' + error, 'error');
            $submitBtn.prop('disabled', false).html('<i class="ri-refresh-line me-1"></i>Update Status');
        }
    });
}

// Get status text for display
function getStatusText(status) {
    const statusMap = {
        0: 'Cancelled',
        1: 'Pending',
        2: 'Paid',
        3: 'Ready for Delivery',
        4: 'Delivered'
    };
    return statusMap[status] || 'Unknown';
}

// Utility function to show alert modal
function showAlertModal(title, message, type, callback) {
    const iconClass = type === 'success' ? 'ri-checkbox-circle-line text-success' : 
                     type === 'error' ? 'ri-error-warning-line text-danger' : 
                     'ri-information-line text-info';
    
    const modalHtml = `
        <div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        ${message}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing alert modal
    $('#alertModal').remove();
    
    // Add new modal
    $('body').append(modalHtml);
    
    // Show modal
    $('#alertModal').modal('show');
    
    // Handle callback
    if (callback) {
        $('#alertModal').on('hidden.bs.modal', function() {
            callback();
            $(this).remove();
        });
    } else {
        $('#alertModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });
    }
}

// Utility function to show confirmation modal
function showConfirmModal(title, message, confirmCallback) {
    const modalHtml = `
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        ${message}
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing confirm modal
    $('#confirmModal').remove();
    
    // Add new modal
    $('body').append(modalHtml);
    
    // Show modal
    $('#confirmModal').modal('show');
    
    // Handle confirm button
    $('#confirmBtn').on('click', function() {
        $('#confirmModal').modal('hide');
        if (confirmCallback) {
            confirmCallback();
        }
    });
    
    // Clean up on close
    $('#confirmModal').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}
</script>

<style>
/* Order History Modal */
#historyModal .modal-body {
    overflow-x: hidden;
    max-width: 100%;
}

.order-history {
    max-height: 60vh;
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
}

.order-history h5 {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
    color: #2c3e50;
    font-weight: 600;
    word-wrap: break-word;
}

.order-history .d-flex {
    flex-wrap: wrap;
    gap: 8px;
}

/* Timeline Styling */
.timeline {
    position: relative;
    padding-left: 40px;
    padding-top: 10px;
    width: 100%;
    max-width: 100%;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
}

/* Timeline vertical line */
.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -28px;
    top: 20px;
    width: 3px;
    height: calc(100% - 10px);
    background: linear-gradient(to bottom, #4a90e2, #e9ecef);
}

/* Timeline marker (dot) */
.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 16px;
    height: 16px;
    background-color: #4a90e2;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #e3f2fd;
    z-index: 1;
    transition: all 0.3s ease;
}

.timeline-marker-start {
    background-color: #28a745 !important;
    box-shadow: 0 0 0 3px #d4edda !important;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 3px #d4edda;
    }
    50% {
        box-shadow: 0 0 0 6px rgba(40, 167, 69, 0.3);
    }
}

/* Timeline content */
.timeline-content {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    width: 100%;
    max-width: calc(100% - 40px);
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.timeline-content:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    transform: translateX(2px);
    border-color: #4a90e2;
}

.timeline-content h6 {
    margin-bottom: 10px;
    color: #2c3e50 !important;
    font-weight: 600;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.timeline-content .badge {
    font-size: 0.85rem;
    padding: 5px 10px;
    font-weight: 600;
    color: #ffffff !important;
    display: inline-block;
    max-width: 100%;
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}

.timeline-content .badge.bg-light {
    color: #000000 !important;
}

.timeline-content .badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000000 !important;
}

.timeline-content .badge.bg-secondary {
    background-color: #6c757d !important;
    color: #ffffff !important;
}

/* User and Date Text Styling */
.history-user-text,
.history-date-text,
.history-reason-text {
    color: #000000 !important;
    font-size: 0.9rem !important;
    display: inline-flex !important;
    align-items: center !important;
    word-wrap: break-word;
    overflow-wrap: break-word;
    max-width: 100%;
}

.history-user-text strong {
    font-weight: 700 !important;
    color: #000000 !important;
    word-wrap: break-word;
}

.history-date-text {
    color: #333333 !important;
    white-space: nowrap;
}

.history-reason-text {
    color: #444444 !important;
    font-style: italic;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.history-user-text i,
.history-date-text i,
.history-reason-text i {
    color: #666666 !important;
    opacity: 0.8;
    margin-right: 4px;
    flex-shrink: 0;
}

/* Fallback for any small tags */
.timeline-content small {
    font-size: 0.85rem;
    display: inline-flex;
    align-items: center;
    color: #000000 !important;
}

.timeline-content small i {
    opacity: 0.7;
    color: #666666 !important;
}

.timeline-content small strong {
    font-weight: 700;
    color: #000000 !important;
}

.timeline-content p {
    color: #000000 !important;
    font-size: 0.9rem;
}

.timeline-content em {
    color: #000000 !important;
}

/* Admin Status Update Form */
.status-update-section {
    background: #f8f9fa;
    border: 2px solid #0d6efd;
    border-radius: 8px;
    padding: 20px;
}

.status-update-section .alert {
    margin-bottom: 15px;
    border-left: 4px solid #0d6efd;
}

.status-update-form .form-label {
    color: #000000 !important;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.status-update-form small {
    color: #000000 !important;
    font-size: 0.85rem;
}

.status-update-form small.text-danger {
    color: #dc3545 !important;
}

.status-update-form small.text-muted {
    color: #6c757d !important;
}

.status-update-form .form-select,
.status-update-form .form-control {
    border: 1px solid #ced4da;
    color: #000000 !important;
    background-color: #ffffff;
}

.status-update-form .form-select option {
    color: #000000;
    padding: 8px;
}

.status-update-form .btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.status-update-form .btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

/* Status Badge Text Visibility - AGGRESSIVE OVERRIDES */
.statusLabel {
    font-weight: 600 !important;
    padding: 6px 12px !important;
}

.statusLabel.bg-yellow-100 {
    color: #854d0e !important;
    background-color: #fef3c7 !important;
}

/* Force white text on ALL Bootstrap color backgrounds */
.statusLabel.bg-primary,
.statusLabel.bg-info,
.statusLabel.bg-success,
.statusLabel.bg-danger,
.badge.bg-primary,
.badge.bg-info,
.badge.bg-success,
.badge.bg-danger,
span.bg-primary,
span.bg-info,
span.bg-success,
span.bg-danger {
    color: #ffffff !important;
    background-color: inherit !important;
}

/* Specific overrides for each status */
.statusLabel.bg-success,
.badge.bg-success,
span.badge.bg-success {
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.statusLabel.bg-primary,
.badge.bg-primary,
span.badge.bg-primary {
    background-color: #0d6efd !important;
    color: #ffffff !important;
}

.statusLabel.bg-info,
.badge.bg-info,
span.badge.bg-info {
    background-color: #17a2b8 !important;
    color: #ffffff !important;
}

/* Ensure text-white class always shows white */
.text-white,
span.text-white,
.badge.text-white {
    color: #ffffff !important;
}
</style> 
