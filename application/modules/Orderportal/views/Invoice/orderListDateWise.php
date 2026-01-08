
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
                                    <h5 class="card-title mb-0 text-black">Daily Invoices</h5>
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
                                
                             
                                <!--end col-->
                               
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
                                            <th class="sort" data-sort="date">Order Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 0; if(!empty($orderLists)){ ?>
                                    <tbody class="list form-check-all" id="formRow">
    <?php foreach($orderLists as $orderList): 
        // Set the status text and success class based on the status value
        if ($orderList['status'] == 1) {
            $statustext = 'Pending';
            $sucessClass = 'bg-danger-subtle text-danger';
        } else {
            $statustext = 'Paid';
            $sucessClass = 'bg-success-subtle text-success';
        }
    ?>
    <tr class="ordertableRow">
        <td class="order_id"><?php echo isset($orderList['invoice_id']) ? $orderList['invoice_id'] : $orderList['order_id'] ?></td>
        <td class="date"><?php echo date('d-m-Y', strtotime($orderList['date'])) ?></td>
        
        
     <td class="status">
            <span class="badge <?php echo $sucessClass ?>  text-uppercase statusLabel">
                <?php echo $statustext ?>
            </span>
        </td>
        <td>
            <div class="d-flex gap-2">
                
                <?php if (isset($orderList['invoice_number'])): ?>
                    <!-- New invoice system -->
                    <a href="<?php echo base_url('Orderportal/Invoice/viewInvoice/'.$orderList['date']); ?>" class="btn btn btn-secondary" target="_blank">
                        <i class=" ri-file-list-3-line label-icon align-middle fs-12 me-2"></i>View Invoice</a>
                        
                    <?php if ($orderList['status'] == 1): // Only show Mark Paid for pending invoices ?>
                        <a onclick="markPaidInvoice(this,'<?php echo $orderList['invoice_id'] ?>')" class="btn btn btn-lightpink"><i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid</a>
                    <?php endif; ?>
                    
                    <a class="btn btn-brickpink btn" data-bs-toggle="modal" data-bs-target="#sendInvoiceModal" onclick="setInvoiceData('<?php echo $orderList['invoice_id'] ?>', '<?php echo $orderList['invoice_number'] ?>')"><i class="ri-mail-check-line label-icon align-middle fs-12 me-2"></i> Send Email</a>
                <?php else: ?>
                    <!-- Legacy order system -->
                    <a href="<?php echo base_url('Orderportal/Invoice/viewInvoice/'.$orderList['date']); ?>" class="btn btn btn-secondary" target="_blank">
                        <i class=" ri-file-list-3-line label-icon align-middle fs-12 me-2"></i>View Invoice</a>
                        
                    <?php if ($orderList['status'] == 1): // Only show Mark Paid for pending invoices ?>
                        <a onclick="markPaid(this,'<?php echo $orderList['date'] ?>')" class="btn btn btn-lightpink"><i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid</a>
                    <?php endif; ?>
                    
                    <a class="btn btn-brickpink btn" data-bs-toggle="modal" data-bs-target="#sendInvoiceModal" onclick="setInvoiceData('<?php echo $orderList['order_id'] ?>', 'INV_<?php echo str_replace('-', '_', $orderList['date']) ?>')"><i class="ri-mail-check-line label-icon align-middle fs-12 me-2"></i> Send Email</a>
                <?php endif; ?>
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
                                                                    <input type="email" class="form-control" id="emailInput" placeholder="Enter email to send payment link to">
                                                                </div>
                                                             
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-danger btn" data-bs-dismiss="modal">Close</button>
                                                                        <a class="btn btn-success btn" onclick="sendPaymentLink()"><i class="ri-mail-check-line align-middle me-1"></i> Send Email</a>
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


<style>
.sending {
    position: relative;
    pointer-events: none;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    opacity: 0.8 !important;
}

.btn-loading {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: white !important;
    position: relative;
}

.btn-loading .loading-text {
    color: white !important;
    font-weight: bold;
}

.btn-loading::before {
    content: "⏳";
    margin-right: 8px;
    font-size: 14px;
    animation: pulse 1s ease-in-out infinite alternate;
}

@keyframes pulse {
    from { opacity: 0.5; }
    to { opacity: 1; }
}

.btn:disabled {
    opacity: 0.65 !important;
    cursor: not-allowed !important;
}

/* Fallback spinner */
.simple-spinner {
    display: inline-block;
    width: 12px;
    height: 12px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: simple-spin 1s linear infinite;
    margin-right: 8px;
    vertical-align: middle;
}

@keyframes simple-spin {
    to { transform: rotate(360deg); }
}
</style>

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
    
    // When any input field changes, filter the table
    $('#order_filters input').on('keyup', function () {
        filterTable();
    });
    
    $('#order_filters select').on('change', function () {
        filterTable();
    });
    

    function filterTable() {
        // Get filter input values
        
        let order_id = $('#order_id').val();
       
        
        let startDate = $('.startDate').val();
        let endDate = $('.endDate').val();
        
   
        let startDateObj = startDate ? new Date(startDate.split('-').reverse().join('-')) : null;
        let endDateObj = endDate ? new Date(endDate.split('-').reverse().join('-')) : null;

        // Loop through all table rows to filter based on inputs
        $('#orderTable tbody tr').each(function () {
            let row = $(this);
            let roworder_id = row.find('.order_id').text().toLowerCase();
            let rowDate = row.find('.date').text().toLowerCase();
          
            
            let rowDateObj = new Date(rowDate.split('-').reverse().join('-'));

        // Check if the row matches the filters
        let dateMatch = (!startDateObj || rowDateObj >= startDateObj) && (!endDateObj || rowDateObj <= endDateObj);
            
            
            // Check if the row matches the filters
            if (roworder_id.includes(order_id) &&  dateMatch ) {
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



 function markPaid(obj,order_date){
         
          $(obj).html("Loading...");
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markPaid") ?>',
        type: 'POST',
        data: {
            order_date: order_date
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

// NEW: Mark invoice as paid (for new invoice system)
function markPaidInvoice(obj, invoice_id){
    $(obj).html("Loading...");
    $.ajax({
        url: '<?= base_url("Orderportal/Order/markPaid") ?>',
        type: 'POST',
        data: {
            invoice_id: invoice_id
        },
        success: function(response) {
            let res = JSON.parse(response)
          
            if (res.status == 'success') {
                $(obj).parents(".ordertableRow").find(".statusLabel").html("Paid");
                $(obj).parents(".ordertableRow").find(".statusLabel").removeClass("bg-danger-subtle text-danger").addClass("bg-success-subtle text-success")
                $(obj).removeAttr('onclick');
                $(obj).html('<i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Paid');
            } else {
                 $(obj).html('<i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid');
                alert(res.message);
            }
        },
        error: function() {
            alert('An error occurred while marking invoice as paid.');
        }
    }); 
} 
      
     

// Set invoice data for the modal
function setInvoiceData(invoiceId, invoiceNumber) {
    $('#sendInvoiceModal').data('invoice-id', invoiceId);
    $('#sendInvoiceModal').data('invoice-number', invoiceNumber);
}

function sendPaymentLink(obj){
    let invoiceId = $('#sendInvoiceModal').data('invoice-id');
    let invoiceNumber = $('#sendInvoiceModal').data('invoice-number');
    let mailto = $('#emailInput').val().trim();
    
    // Validation
    if (!mailto) {
        alert('Please enter an email address');
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(mailto)) {
        alert('Please enter a valid email address');
        return;
    }
    
    if (!invoiceId) {
        alert('Invoice ID not found');
        return;
    }
    
    // Prevent multiple clicks
    if ($(obj).hasClass('sending')) {
        return;
    }
    
    // Set VERY visible loading state
    // console.log('🔄 Starting email send...');
    $(obj).addClass('sending btn-loading');
    $(obj).prop('disabled', true);
    
    // Store original state
    const originalText = $(obj).html();
    const originalBg = $(obj).css('background-color');
    const originalColor = $(obj).css('color');
    
    // Make button VERY visible while loading
    $(obj).css({
        'background-color': '#28a745 !important',
        'border-color': '#28a745 !important',
        'color': 'white !important',
        'font-weight': 'bold'
    });
    
    // Set loading content with spinner
    $(obj).html('<span class="simple-spinner"></span> Sending Email...');
    
    // Add visual feedback to the row
    $(obj).closest('tr').css({
        'background-color': '#f0f8f0',
        'border-left': '4px solid #28a745'
    });
    
    // Start blinking animation for extra visibility
    let blinkCount = 0;
    const blinkInterval = setInterval(function() {
        if (blinkCount % 2 === 0) {
            $(obj).css('opacity', '0.7');
        } else {
            $(obj).css('opacity', '1');
        }
        blinkCount++;
    }, 300);
    
    $(obj).data('blink-interval', blinkInterval);
    
    $.ajax({
        url: '<?= base_url("Orderportal/Invoice/sendPaymentLink") ?>',
        type: 'POST',
        data: {
            invoice_id: invoiceNumber, // Use invoice number for file lookup
            mailto: mailto
        },
        success: function(response) {
            try {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    // Success - show success message and close modal
                    $("#sendInvoiceModal").modal('hide');
                    $('#emailInput').val(''); // Clear email field
                    
                    // Show success toast/alert
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email Sent!',
                            text: res.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        alert('✓ ' + res.message);
                    }
                } else {
                    // Error from server
                    alert('Error: ' + res.message);
                }
            } catch (e) {
                // JSON parse error
                alert('Unexpected response from server');
                console.error('Response parsing error:', e, response);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while sending the email. Please try again.');
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // console.log('✅ Email send complete - resetting UI');
            
            // Clear all loading animations
            const blinkInterval = $(obj).data('blink-interval');
            if (blinkInterval) {
                clearInterval(blinkInterval);
            }
            
            // Show completion state briefly
            $(obj).css({
                'background-color': '#007bff !important',
                'opacity': '1'
            });
            $(obj).html('✓ Complete');
            
            // Reset everything after a short delay
            setTimeout(function() {
                // Reset button state
                $(obj).removeClass('sending btn-loading');
                $(obj).prop('disabled', false);
                $(obj).css({
                    'background-color': '',
                    'border-color': '',
                    'color': '',
                    'font-weight': '',
                    'opacity': ''
                });
                $(obj).html(originalText);
                
                // Reset row styling
                $(obj).closest('tr').css({
                    'background-color': '',
                    'border-left': ''
                });
            }, 1500); // 1.5 second delay
        }
    }); 
}



</script> 
