
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
                                    <h5 class="card-title mb-0 text-black">Generate Bulk Invoice</h5>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body border-bottom-dashed border-bottom">
                        <form id="order_filters" class="mb-5" action="<?php echo base_url('Orderportal/Invoice/generateBulkInvoice') ?>" method="post">
                            <div class="row g-3">
                           <div class=" col-xl-3">
                                   
                         <div class="custom_date_schedule">
                           <label>Start Date:<span>*</span></label>
                         <input type="text" name="start_date" required class="form-control flatpickr-input active startDate"  data-provider="flatpickr" data-date-format="d-m-Y" placeholder="Start date" readonly>
                         </div>
                         </div>
                       <div class=" col-xl-3">
                        <div class="custom_date_schedule">
                            <label>End Date:<span>*</span></label>
                      <input type="text" name="end_date"  required class="form-control flatpickr-input active endDate" data-provider="flatpickr" data-date-format="d-m-Y"  placeholder="End date" readonly>
                      </div>
                      </div>
                      
                      
                       <!-- <div class="col-12 col-md-3 col-lg-2 mb-2"> 
                         <label>Floors :<span>*</span></label>
                            <select class="form-select" name="department"  >
							     <option value="">-- Select Department --</option>
							     
							    <?php foreach($departments as $department){   ?>	  
							    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
							    <?php } ?>
							</select>
                    </div> -->
                                
                       <div class="col-xl-2 ">
                       <button type="submit"  class="btn btn-success btn-md shadow-none mt-4 "><i class="mdi mdi-refresh"></i> Generate</button>
                       </div>
                              
                                
                            </div>
                            <!--end row-->
                        </form>
                        
                        
                        
                        <div class="table-responsive table-card mb-1">
                                
                                <table class="table align-middle " id="orderTable">
                                    <thead class="table-dark text-white">
                                        <tr>
                                            <th class="sort" data-sort="order_id">Invoice No</th>
                                            <th class="sort" data-sort="date">Order Date From</th>
                                            <th class="sort" data-sort="date">Order Date Date</th>
                                            <th class="sort" data-sort="date"> Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 0; if(!empty($invoiceLists)){ ?>
                                    <tbody class="list form-check-all" id="formRow">
    <?php foreach($invoiceLists as $orderList): 
        // Set the status text and success class based on the status value
        if ($orderList['status'] == 0) {
            $statustext = 'Pending';
            $sucessClass = 'bg-danger-subtle text-danger';
        } else {
            $statustext = 'Paid';
            $sucessClass = 'bg-success-subtle text-success';
        }
    ?>
    <tr class="ordertableRow">
        <td class="order_id"><?php echo $orderList['invoice_no'] ?></td>
        <td class="date"><?php echo date('d-m-Y', strtotime($orderList['date_from'])) ?></td>
        <td class="date"><?php echo date('d-m-Y', strtotime($orderList['date_to'])) ?></td>
        
        
     <td class="status">
            <span class="badge <?php echo $sucessClass ?>  text-uppercase statusLabel">
                <?php echo $statustext ?>
            </span>
        </td>
        <td>
            <div class="d-flex gap-2">
               
                
              <a href="<?php echo base_url('Orderportal/Invoice/download_invoice/'.$orderList['invoice_no']); ?>" class="btn btn-sm btn-secondary" target="_blank">
                   <i class=" ri-file-list-3-line label-icon align-middle fs-12 me-2"></i>View Invoice</a>
                    
                <?php if ($orderList['status'] == 0): // Only show Mark Paid for pending invoices ?>
                <a onclick="markPaid(this,'<?php echo $orderList['id'] ?>')" class="btn btn-sm btn-lightpink">
                    <i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid</a>
                <?php endif; ?>
                
                <a class="btn btn-brickpink btn-sm" id="SendInvoiceBtn"  data-invno="<?php echo $orderList['invoice_no'] ?>"><i class="ri-mail-check-line label-icon align-middle fs-12 me-2"></i> Send Invoice</a>
                <a class="btn btn-dark btn-sm" data-invno="<?php echo $orderList['invoice_no'] ?>"id="SendPaymentLink"><i class="ri-mail-check-line label-icon align-middle fs-12 me-2"></i> Send Payment Link</a>
                
                <?php if ($orderList['status'] == 0): // Only show Cancel for pending invoices ?>
                <a onclick="cancelInvoices(this,'<?php echo $orderList['id'] ?>')" class="btn btn-sm btn-danger">
                    <i class="bx bx-trash label-icon align-middle fs-12 me-2"></i>Cancel</a>
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
                                                                    <input type="email" class="form-control" id="emailInputforInv" placeholder="Enter email to send invoice to">
                                                                </div>
                                                             
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                                                        <input type="hidden" id="invDownloadNo" >
                                                                        <a class="btn btn-success btn-sm" onclick="sendInvoiceEmail(this)"><i class="ri-mail-check-line align-middle me-1"></i> Send Email</a>
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


<div class="modal fade" id="sendPaymentModal" tabindex="-1" aria-labelledby="sendInvoiceModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalgridLabel">Send Payment Link</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="javascript:void(0);">
                                                            <div class="row g-3">
                                                                <div class="">
                                                                    <label for="emailInput" class="form-label">Email</label>
                                                                    <input type="email" class="form-control" id="emailInputForPaymentlink" placeholder="Enter email to send invoice to">
                                                                </div>
                                                             
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                                                        <input type="hidden" id="invPaymentDownloadNo" >
                                                                        <a class="btn btn-success btn-sm" onclick="sendPaymentEmail(this)"><i class="ri-mail-check-line align-middle me-1"></i> Send Payment Link</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

<style>
.spinner-border-sm {
    width: 0.875rem;
    height: 0.875rem;
    border-width: 0.1em;
}

.spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.15em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
    to { transform: rotate(360deg); }
}

.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>

<script type="text/javascript">

$(document).on('click', '#SendInvoiceBtn', function () {
    let invNo = $(this).data('invno');
    $("#sendInvoiceModal").modal('show');
    $('#invDownloadNo').val(invNo);
});


$(document).on('click', '#SendPaymentLink', function () {
    let invNo = $(this).data('invno');
    $("#sendPaymentModal").modal('show');
    $('#invPaymentDownloadNo').val(invNo);
});


document.getElementById("order_filters").addEventListener("submit", function(event) {
    // Prevent default form submission
    event.preventDefault();
    
    // Get form fields
    const startDate = document.querySelector(".startDate").value;
    const endDate = document.querySelector(".endDate").value;

    // Initialize error flag
    let hasError = false;
    let errorMessage = "";

    // Validate start date
    if (!startDate) {
        hasError = true;
        errorMessage += "Start date is required.\n";
    }

    // Validate end date
    if (!endDate) {
        hasError = true;
        errorMessage += "End date is required.\n";
    }

    // Validate that end date is not earlier than start date
    if (startDate && endDate) {
        const start = new Date(startDate.split("-").reverse().join("-")); // Convert to yyyy-mm-dd
        const end = new Date(endDate.split("-").reverse().join("-"));
        if (start > end) {
            hasError = true;
            errorMessage += "End date cannot be earlier than the start date.\n";
        }
    }

    // If there's an error, show SweetAlert
    if (hasError) {
        Swal.fire({
            icon: 'error',
            title: 'Form Validation Error',
            text: errorMessage,
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    // If validation passes, submit via AJAX
    generateBulkInvoiceAjax();
});

function generateBulkInvoiceAjax() {
    const startDate = document.querySelector(".startDate").value;
    const endDate = document.querySelector(".endDate").value;
    const generateBtn = document.querySelector('button[type="submit"]');
    
    // Set loading state
    generateBtn.disabled = true;
    generateBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2" role="status"></i>Generating...';
    
    $.ajax({
        url: '<?= base_url("Orderportal/Invoice/generateBulkInvoiceAjax") ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            try {
                if (response.status === 'success') {
                    // Show success message and reload page to show new invoice
                    Swal.fire({
                        icon: 'success',
                        title: 'Invoice Generated Successfully!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload page to show the new invoice in the table
                        window.location.reload();
                    });
                } else if (response.status === 'error') {
                    // Show error message on the same page
                    Swal.fire({
                        icon: 'error',
                        title: 'No Orders Found',
                        text: response.message,
                        confirmButtonColor: '#d33'
                    });
                } else {
                    throw new Error('Unexpected response format');
                }
            } catch (e) {
                console.error('Response parsing error:', e, response);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'An unexpected error occurred. Please try again.',
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'An error occurred while generating the invoice. Please try again.',
                confirmButtonColor: '#d33'
            });
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // Reset button state
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="mdi mdi-refresh"></i> Generate';
        }
    });
}

function sendInvoiceEmail(obj){
    let invoiceId = $('#invDownloadNo').val();
    let mailto = $('#emailInputforInv').val().trim();
    
    // Validation
    if (!mailto) {
        Swal.fire({
            icon: 'error',
            title: 'Email Required',
            text: 'Please enter an email address',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(mailto)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email',
            text: 'Please enter a valid email address',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    if (!invoiceId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invoice ID not found',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    // Set loading state
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm me-2" role="status"></i>Sending...');
    
         $.ajax({
        url: '<?= base_url("Orderportal/Invoice/sendInvoiceEmail") ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            invoice_id: invoiceId,
             mailto: mailto
        },
        success: function(response) {
            // console.log('Raw response:', response);
            // console.log('Response type:', typeof response);
            
            try {
                // Check if response is already an object (jQuery parsed it)
                let res = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (res.status == 'success') {
                    $("#sendInvoiceModal").modal('hide');
                    $('#emailInputforInv').val(''); // Clear email field
                    
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Email Sent Successfully!',
                            text: res.message || 'Invoice has been sent successfully',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        // Fallback for when SweetAlert2 is not available
                        alert('✓ ' + (res.message || 'Email sent successfully'));
                    }
                } else if (res.status == 'failed' || res.status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Failed',
                        text: res.message || 'Failed to send email',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    // Unexpected response format
                    throw new Error('Unexpected response format');
                }
            } catch (e) {
                console.error('Response parsing error:', e, response);
                
                // Check if response contains HTML (login redirect)
                if (typeof response === 'string' && response.includes('<html>')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Session Expired',
                        text: 'Your session may have expired. Please refresh the page and try again.',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'Refresh Page'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    // Check if email might have been sent despite the error
                    Swal.fire({
                        icon: 'warning',
                        title: 'Response Error',
                        text: 'There was an issue processing the response, but the email may have been sent. Please check your email.',
                        confirmButtonColor: '#ffc107'
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'An error occurred while sending the email. Please try again.',
                confirmButtonColor: '#d33'
            });
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // Reset button state
            $(obj).prop('disabled', false);
            $(obj).html('<i class="ri-mail-check-line align-middle me-1"></i> Send Email');
        }
    }); 
}

function sendPaymentEmail(obj){
    let invoiceId = $('#invPaymentDownloadNo').val();
    let mailto = $('#emailInputForPaymentlink').val().trim();
    
    // Validation
    if (!mailto) {
        Swal.fire({
            icon: 'error',
            title: 'Email Required',
            text: 'Please enter an email address',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(mailto)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email',
            text: 'Please enter a valid email address',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    if (!invoiceId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invoice ID not found',
            confirmButtonColor: '#d33'
        });
        return;
    }
    
    // Set loading state
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm me-2" role="status"></i>Sending...');
    
         $.ajax({
        url: '<?= base_url("Orderportal/Invoice/sendPaymentLink") ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            invoice_id: invoiceId,
             mailto: mailto
        },
        success: function(response) {
            // console.log('Payment Link Raw response:', response);
            // console.log('Response type:', typeof response);
            
            try {
                // Check if response is already an object (jQuery parsed it)
                let res = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (res.status == 'success') {
                    $("#sendPaymentModal").modal('hide');
                    $('#emailInputForPaymentlink').val(''); // Clear email field
                    
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Payment Link Sent Successfully!',
                            text: res.message || 'Payment link has been sent successfully',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        // Fallback for when SweetAlert2 is not available
                        alert('✓ ' + (res.message || 'Payment link sent successfully'));
                    }
                } else if (res.status == 'failed' || res.status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Link Failed',
                        text: res.message || 'Failed to send payment link',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    // Unexpected response format
                    throw new Error('Unexpected response format');
                }
            } catch (e) {
                console.error('Response parsing error:', e, response);
                
                // Check if response contains HTML (login redirect)
                if (typeof response === 'string' && response.includes('<html>')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Session Expired',
                        text: 'Your session may have expired. Please refresh the page and try again.',
                        confirmButtonColor: '#ffc107',
                        confirmButtonText: 'Refresh Page'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    // Check if email might have been sent despite the error
                    Swal.fire({
                        icon: 'warning',
                        title: 'Response Error',
                        text: 'There was an issue processing the response, but the payment link may have been sent. Please check your email.',
                        confirmButtonColor: '#ffc107'
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'An error occurred while sending the payment link. Please try again.',
                confirmButtonColor: '#d33'
            });
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // Reset button state
            $(obj).prop('disabled', false);
            $(obj).html('<i class="ri-mail-check-line align-middle me-1"></i> Send Payment Link');
        }
    }); 
}

function cancelInvoices(obj,invoiceId){
    
    // Use SweetAlert2 for confirmation
    Swal.fire({
        title: 'Cancel Invoice?',
        text: 'Are you sure you want to cancel this invoice? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Cancel Invoice',
        cancelButtonText: 'Keep Invoice'
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        
        // Continue with the cancellation process
        processCancelInvoice(obj, invoiceId);
    });
}

function processCancelInvoice(obj, invoiceId){
    
    // Set loading state
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm me-2" role="status"></i>Cancelling...');
    
         $.ajax({
        url: '<?= base_url("Orderportal/Invoice/cancelBulkInvoice") ?>',
        type: 'POST',
        data: {
            invoice_id: invoiceId
        },
        success: function(response) {
            try {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    $(obj).parents(".ordertableRow").fadeOut(300, function() {
                        $(this).remove();
                    });
                    
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cancelled!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Fallback for when SweetAlert2 is not available
                        alert('✓ ' + res.message);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cancellation Failed',
                        text: res.message,
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Unexpected response from server',
                    confirmButtonColor: '#d33'
                });
                console.error('Response parsing error:', e, response);
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'An error occurred while cancelling the invoice. Please try again.',
                confirmButtonColor: '#d33'
            });
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // Reset button state (only if not removed)
            if ($(obj).length) {
                $(obj).prop('disabled', false);
                $(obj).html('<i class="bx bx-trash label-icon align-middle fs-12 me-2"></i>Cancel');
            }
        }
    }); 
    
}

function markPaid(obj, invoiceId){
    
    // Use SweetAlert2 for confirmation
    Swal.fire({
        title: 'Mark as Paid?',
        text: 'Are you sure you want to mark this invoice as paid?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Mark Paid',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }
        
        // Continue with the payment process
        processMarkPaid(obj, invoiceId);
    });
}

function processMarkPaid(obj, invoiceId){
    
    // Set loading state
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm me-2" role="status"></i>Processing...');
    
         $.ajax({
        url: '<?= base_url("Orderportal/Invoice/markPayBulkInvoice") ?>',
        type: 'POST',
        data: {
            invoice_id: invoiceId
        },
        success: function(response) {
            try {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    // Update status label
                    $(obj).parents(".ordertableRow").find(".statusLabel")
                        .removeClass("bg-danger-subtle text-danger")
                        .addClass("bg-success-subtle text-success")
                        .text('Paid');
                    
                    // Update button to show paid state
                    $(obj).removeClass('btn-lightpink').addClass('btn-success');
                    $(obj).removeAttr('onclick');
                    $(obj).prop('disabled', true);
                    $(obj).html('<i class="bx bx-check label-icon align-middle fs-12 me-2"></i>Paid');
                    
                    // Show success message
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Recorded!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Fallback for when SweetAlert2 is not available
                        alert('✓ ' + res.message);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: res.message,
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Unexpected response from server',
                    confirmButtonColor: '#d33'
                });
                console.error('Response parsing error:', e, response);
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'An error occurred while marking as paid. Please try again.',
                confirmButtonColor: '#d33'
            });
            console.error('AJAX error:', status, error);
        },
        complete: function() {
            // Reset button state if not successful
            if (!$(obj).hasClass('btn-success')) {
                $(obj).prop('disabled', false);
                $(obj).html('<i class="bx bx-dollar label-icon align-middle fs-12 me-2"></i>Mark Paid');
            }
        }
    }); 
    
}





</script> 
