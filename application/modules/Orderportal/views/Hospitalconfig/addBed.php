<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
    
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

            <main class="container mx-auto px-4 flex-grow mb-8">
                <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-confirm"></div>
                </div>

                <div id="form-container" class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-primary p-4 text-white">
                        <h2 class="text-xl font-semibold text-white">
                            <?php echo isset($bedDetails['id']) ? 'Edit Suite' : 'Add New Suite'; ?>
                        </h2>
                        <p class="text-sm text-white">
                            <?php echo isset($bedDetails['id']) ? 'Update the suite information below' : 'Fill in the details below'; ?>
                        </p>
                    </div>

                    <form id="suite-form" class="p-6" action="<?php echo isset($bedDetails['id']) ? base_url('Orderportal/Hospitalconfig/updateSuite') : base_url('Orderportal/Hospitalconfig/submitSuite'); ?>" method="post">
                        <input type="hidden" name="bedId" value="<?php echo isset($bedDetails['id']) ? $bedDetails['id'] : ''; ?>">

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                           

                            <!-- Suite Number Field -->
                            <div id="suite-number-field" class="form-group">
                                <label for="bed_no" class="block text-sm text-gray-600 mb-1">Suite Number <span class="text-danger">*</span></label>
                                <input type="text" id="bed_no" name="bed_no" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                                       value="<?php echo isset($bedDetails['bed_no']) && $bedDetails['bed_no'] != '' ? htmlspecialchars($bedDetails['bed_no']) : ''; ?>" placeholder="Enter suite number" autocomplete="off">
                                <div id="suite-number-error" class="error-message hidden">Suite number is required</div>
                                <div id="duplicate-error" class="error-message hidden">This suite number already exists</div>
                                <div id="duplicate-success" class="success-message hidden">Suite number is available</div>
                            </div>

                            <!-- Floor Field -->
                            <div id="floor-field" class="form-group">
                                <label for="floor" class="block text-sm text-gray-600 mb-1">Floor <span class="text-danger">*</span></label>
                                <div class="relative">
                                    <select id="floor" name="floor" required class="w-full px-4 py-2 border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50">
                                        <option value="">-- Select Floor --</option>
                                        <?php if (isset($floorLists) && !empty($floorLists)) : ?>
                                            <?php foreach ($floorLists as $floorList) : ?>
                                                <option value="<?= htmlspecialchars($floorList['id']) ?>" <?= (isset($bedDetails['floor']) && $bedDetails['floor'] == $floorList['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($floorList['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div id="floor-error" class="error-message hidden">Please select a floor</div>
                            </div>

                            <!-- PIN Field -->
                            <div id="pin-field" class="form-group">
                                <label for="suite_pin" class="block text-sm text-gray-600 mb-1">Suite PIN <span class="text-danger">*</span></label>
                                <input type="text" id="suite_pin" name="suite_pin" required maxlength="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                                       value="<?php echo isset($bedDetails['suite_pin']) && $bedDetails['suite_pin'] != '' ? htmlspecialchars($bedDetails['suite_pin']) : '1234'; ?>" 
                                       placeholder="Enter suite PIN" autocomplete="off" pattern="[0-9]{4,6}">
                                <small class="text-gray-500">4-6 digit PIN for order delivery (default: 1234)</small>
                                <div id="pin-error" class="error-message hidden">PIN must be 4-6 digits</div>
                            </div>
                            
                             <div id="name-field" class="form-group">
                                <label for="notes" class="block text-sm text-gray-600 mb-1">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                                       placeholder="Enter any notes for this suite"><?php echo isset($bedDetails['notes']) && $bedDetails['notes'] != '' ? htmlspecialchars($bedDetails['notes']) : ''; ?></textarea>
                            </div>
                            
                        </div>

                        <!-- Form Buttons -->
                        <div id="form-buttons" class="flex justify-between mt-8">
                            <a href="<?php echo base_url('Orderportal/Hospitalconfig/List'); ?>">
                                <button type="button" id="back-button" class="px-6 py-2 border-2 border-red-500 text-danger rounded-lg flex items-center hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                                </button>
                            </a>
                            <button type="submit" id="submit-button" class="px-6 py-2 bg-green-600 text-white rounded-lg flex items-center hover:bg-green-700 transition-colors">
                                <?= isset($bedDetails['id']) ? 'Update' : 'Submit' ?> <i class="fa-solid fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
       
        
        
    </div>
            <!-- container-fluid -->
    </div>
        <!-- End Page-content -->

        
    </div>

<!-- END layout-wrapper -->



<script type="text/javascript">

document.addEventListener("DOMContentLoaded", function() {
        // Initialize Flatpickr with today's date
        const datePicker = document.getElementById('datePicker');
        flatpickr(datePicker, {
            defaultDate: new Date(), 
            dateFormat: "d M, Y",  
        });
    });
	$(document).ready(function() { 
	    $("#bed_add").validate({
	      	ignore: "input[type='text']:hidden",
		    rules: {
			bed_no: {
	                required:true
	            },
	        
	        
            floor: {
	        	required:true
            },
            suite_pin: {
                required: true,
                minlength: 4,
                maxlength: 6,
                digits: true
            },
	      
			},		
			messages: {
			bed_no: {
	                required:"Please provide the Bed No"
	            },
	          
	        floor: {
                 required:"Please select the Floor"
                 },
            suite_pin: {
                required: "Please provide a Suite PIN",
                minlength: "PIN must be at least 4 digits",
                maxlength: "PIN must be no more than 6 digits",
                digits: "PIN must contain only numbers"
            }
	       // large: {
	       //       required:"Please Provide the large value"
	       //     }   
			}

	    });	
	});
	
	

    
</script>

<style>
.text-danger {
    color: #dc3545 !important;
}
.text-success {
    color: #28a745 !important;
}

/* Additional validation styling */
.border-red-500 {
    border-color: #ef4444 !important;
}
.border-green-500 {
    border-color: #10b981 !important;
}
.text-red-500, .error-message {
    color: #ef4444 !important;
}
.text-green-500, .success-message {
    color: #10b981 !important;
}

/* Force error message styling */
div[id$="-error"], .error-message {
    color: #dc3545 !important;
    font-weight: 500 !important;
}

div[id$="-success"], .success-message {
    color: #28a745 !important;
    font-weight: 500 !important;
}
.bg-gray-400 {
    background-color: #9ca3af !important;
}
.cursor-not-allowed {
    cursor: not-allowed !important;
}
.cursor-pointer {
    cursor: pointer !important;
}

/* Error message animation */
.error-message, .success-message {
    transition: all 0.3s ease;
}
.error-message.hidden, .success-message.hidden {
    opacity: 0;
    max-height: 0;
    margin: 0;
}
.error-message:not(.hidden), .success-message:not(.hidden) {
    opacity: 1;
    max-height: 50px;
    margin-top: 0.25rem;
}

/* Specific error message IDs styling */
#suite-number-error, #duplicate-error, #floor-error, #pin-error {
    color: #dc3545 !important;
    font-weight: 500 !important;
    font-size: 12px !important;
}

#duplicate-success {
    color: #28a745 !important;
    font-weight: 500 !important;
    font-size: 12px !important;
}
</style>

<script>
// Enhanced Suite Form Validation
$(document).ready(function() {
    const bedNoInput = $('#bed_no');
    const floorSelect = $('#floor');
    const pinInput = $('#suite_pin');
    const submitButton = $('#submit-button');
    const bedId = $('input[name="bedId"]').val();
    
    let isDuplicateValid = true;
    let duplicateCheckInProgress = false;
    let bedNoTouched = false;
    let floorTouched = false;
    let pinTouched = false;
    
    // Initialize form - ensure submit button is always visible but may be disabled
    initializeForm();
    
    function initializeForm() {
        // Hide all error messages by default
        hideAllErrors();
        
        // For edit mode, check if we have valid existing data
        const isEditMode = bedId && bedId.trim() !== '';
        const hasValidData = bedNoInput.val().trim() && floorSelect.val() && isValidPin(pinInput.val());
        
        if (isEditMode && hasValidData) {
            // Enable submit button for edit mode with valid data
            enableSubmitButton();
        } else if (!isEditMode) {
            // For new entries, disable until fields are valid
            disableSubmitButton();
        }
    }
    
    // Real-time validation for suite number
    bedNoInput.on('input blur', function() {
        const value = $(this).val().trim();
        bedNoTouched = true;
        
        clearTimeout(this.duplicateTimer);
        
        if (!value) {
            showFieldError('bed_no', 'suite-number-error', 'Suite number is required');
            hideMessages(['duplicate-error', 'duplicate-success']);
            isDuplicateValid = false;
        } else {
            hideFieldError('bed_no', 'suite-number-error');
            
            // Check for duplicate after a delay
            this.duplicateTimer = setTimeout(function() {
                checkDuplicate(value);
            }, 500);
        }
        updateSubmitButton();
    });
    
    // Floor validation
    floorSelect.on('change blur', function() {
        const value = $(this).val();
        floorTouched = true;
        
        if (!value) {
            showFieldError('floor', 'floor-error', 'Please select a floor');
        } else {
            hideFieldError('floor', 'floor-error');
        }
        updateSubmitButton();
    });
    
    // PIN validation
    pinInput.on('input blur', function() {
        const value = $(this).val().trim();
        pinTouched = true;
        
        if (!value) {
            showFieldError('suite_pin', 'pin-error', 'Suite PIN is required');
        } else if (!isValidPin(value)) {
            showFieldError('suite_pin', 'pin-error', 'PIN must be 4-6 digits');
        } else {
            hideFieldError('suite_pin', 'pin-error');
        }
        updateSubmitButton();
    });
    
    // PIN input restriction - only allow numbers
    pinInput.on('keypress', function(e) {
        // Allow backspace, delete, tab, escape, enter
        if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
            // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true)) {
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    function isValidPin(pin) {
        return /^[0-9]{4,6}$/.test(pin);
    }
    
    function checkDuplicate(bedNo) {
        if (!bedNo) return;
        
        duplicateCheckInProgress = true;
        updateSubmitButton();
        
        $.ajax({
            url: '<?php echo base_url("Orderportal/Hospitalconfig/checkDuplicateSuite"); ?>',
            type: 'POST',
            data: { bed_no: bedNo, bed_id: bedId },
            dataType: 'json',
            success: function(response) {
                duplicateCheckInProgress = false;
                
                if (response.status === 'exists') {
                    showFieldError('bed_no', 'duplicate-error', response.message);
                    hideMessages(['duplicate-success']);
                    isDuplicateValid = false;
                } else if (response.status === 'available') {
                    showFieldSuccess('bed_no', 'duplicate-success', response.message);
                    hideMessages(['duplicate-error']);
                    isDuplicateValid = true;
                } else {
                    hideMessages(['duplicate-error', 'duplicate-success']);
                    isDuplicateValid = false;
                }
                updateSubmitButton();
            },
            error: function() {
                duplicateCheckInProgress = false;
                showFieldError('bed_no', 'duplicate-error', 'Error checking suite number availability');
                isDuplicateValid = false;
                updateSubmitButton();
            }
        });
    }
    
    function showFieldError(fieldId, errorId, message) {
        $('#' + fieldId).removeClass('border-gray-300 border-green-500').addClass('border-red-500');
        $('#' + errorId).text(message).removeClass('hidden');
    }
    
    function showFieldSuccess(fieldId, successId, message) {
        $('#' + fieldId).removeClass('border-gray-300 border-red-500').addClass('border-green-500');
        $('#' + successId).text(message).removeClass('hidden');
    }
    
    function hideFieldError(fieldId, errorId) {
        $('#' + fieldId).removeClass('border-red-500').addClass('border-gray-300');
        $('#' + errorId).addClass('hidden');
    }
    
    function hideMessages(elementIds) {
        elementIds.forEach(function(id) {
            $('#' + id).addClass('hidden');
        });
    }
    
    function hideAllErrors() {
        hideMessages(['suite-number-error', 'duplicate-error', 'duplicate-success', 'floor-error', 'pin-error']);
        bedNoInput.removeClass('border-red-500 border-green-500').addClass('border-gray-300');
        floorSelect.removeClass('border-red-500 border-green-500').addClass('border-gray-300');
        pinInput.removeClass('border-red-500 border-green-500').addClass('border-gray-300');
    }
    
    function updateSubmitButton() {
        const bedNoValue = bedNoInput.val().trim();
        const floorValue = floorSelect.val();
        const pinValue = pinInput.val().trim();
        
        const isBedNoValid = bedNoValue && isDuplicateValid && !duplicateCheckInProgress;
        const isFloorValid = !!floorValue;
        const isPinValid = isValidPin(pinValue);
        const isFormValid = isBedNoValid && isFloorValid && isPinValid;
        
        if (isFormValid) {
            enableSubmitButton();
        } else {
            // Only disable if user has interacted with fields
            if (bedNoTouched || floorTouched || pinTouched) {
                disableSubmitButton();
            }
        }
    }
    
    function enableSubmitButton() {
        submitButton.prop('disabled', false)
                   .removeClass('bg-gray-400 cursor-not-allowed')
                   .addClass('bg-green-600 hover:bg-green-700 cursor-pointer');
    }
    
    function disableSubmitButton() {
        submitButton.prop('disabled', true)
                   .removeClass('bg-green-600 hover:bg-green-700 cursor-pointer')
                   .addClass('bg-gray-400 cursor-not-allowed');
    }
    
    // Form submission validation
    $('#suite-form').on('submit', function(e) {
        const bedNoValue = bedNoInput.val().trim();
        const floorValue = floorSelect.val();
        const pinValue = pinInput.val().trim();
        
        // Mark fields as touched
        bedNoTouched = true;
        floorTouched = true;
        pinTouched = true;
        
        let isValid = true;
        let errorMessages = [];
        
        if (!bedNoValue) {
            isValid = false;
            errorMessages.push('Suite number is required');
            showFieldError('bed_no', 'suite-number-error', 'Suite number is required');
        } else if (!isDuplicateValid) {
            isValid = false;
            errorMessages.push('Suite number already exists or is invalid');
        }
        
        if (!floorValue) {
            isValid = false;
            errorMessages.push('Please select a floor');
            showFieldError('floor', 'floor-error', 'Please select a floor');
        }
        
        if (!pinValue) {
            isValid = false;
            errorMessages.push('Suite PIN is required');
            showFieldError('suite_pin', 'pin-error', 'Suite PIN is required');
        } else if (!isValidPin(pinValue)) {
            isValid = false;
            errorMessages.push('PIN must be 4-6 digits');
            showFieldError('suite_pin', 'pin-error', 'PIN must be 4-6 digits');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n• ' + errorMessages.join('\n• '));
            return false;
        }
        
        // Show loading state
        submitButton.prop('disabled', true)
                   .html('<i class="fa-solid fa-spinner fa-spin mr-2"></i>' + (bedId ? 'Updating...' : 'Submitting...'));
    });
});
</script>
</script>