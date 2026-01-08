<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
/* Loader Overlay */
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

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
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
                        <h2 class="text-xl font-semibold text-white">Onboard New Client</h2>
                        <p class="text-sm text-white">Fill in the details below</p>
                    </div>

                    <form id="suite-form" class="p-6" action="<?php echo base_url('Orderportal/Patient/save_person') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="personId" name="personId" value="<?php echo ($patientDetails['id'] != '' ? $patientDetails['id'] : '') ?>">
                        <!-- Hidden fields to ensure Floor Name and Suite Number values are submitted when disabled -->
                        <?php 
                        $floorDisabled = !isset($enableFloorAndSuite) || !$enableFloorAndSuite;
                        $suiteDisabled = !isset($enableFloorAndSuite) || !$enableFloorAndSuite;
                        
                        $floorValue = (isset($patientDetails['floor_number']) && $patientDetails['floor_number'] != '') 
                            ? $patientDetails['floor_number'] 
                            : (isset($selectedFloor[0]['floor']) ? $selectedFloor[0]['floor'] : '');
                        $suiteValue = (isset($patientDetails['suite_number']) && $patientDetails['suite_number'] != '') 
                            ? $patientDetails['suite_number'] 
                            : (isset($selected_suite) ? $selected_suite : '');
                        ?>
                        <?php if ($floorDisabled): ?>
                            <input type="hidden" id="floor_number_hidden" name="floor_number" value="<?php echo htmlspecialchars($floorValue); ?>">
                        <?php endif; ?>
                        <?php if ($suiteDisabled): ?>
                            <input type="hidden" id="suite_number_hidden" name="suite_number" value="<?php echo htmlspecialchars($suiteValue); ?>">
                        <?php endif; ?>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Name Field -->
                            <div id="name-field" class="form-group">
                                <label for="name" class="block text-sm text-gray-600 mb-1">
                                    Name <span class="required-asterisk text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white transition-colors duration-200" 
                                       value="<?php echo ($patientDetails['name'] != '' ? $patientDetails['name'] : '') ?>" 
                                       placeholder="Enter full name"
                                       data-validation-message="Name is required">
                                <div class="error-message hidden text-red-500 text-xs mt-1 font-medium"></div>
                            </div>

                            <!-- Floor Name Field -->
                            <div id="floor-field" class="form-group">
                                <label for="floor_number" class="block text-sm text-gray-600 mb-1">
                                    Floor Name <span class="required-asterisk text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <?php 
                                    $floorDisabled = !isset($enableFloorAndSuite) || !$enableFloorAndSuite;
                                    $floorClasses = $floorDisabled 
                                        ? "w-full px-4 py-2 border border-gray-300 rounded-lg appearance-none bg-gray-100 cursor-not-allowed transition-colors duration-200"
                                        : "w-full px-4 py-2 border border-gray-300 rounded-lg appearance-none bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200";
                                    $floorStyle = $floorDisabled ? "background-color: #f3f4f6; color: #6b7280;" : "";
                                    ?>
                                    <select id="floor_number" name="floor_number" required <?php echo $floorDisabled ? 'disabled' : ''; ?>
                                            class="<?php echo $floorClasses; ?>"
                                            data-validation-message="Please select a floor"
                                            style="<?php echo $floorStyle; ?>">
                                        <option value="">Select Floor</option>
                                        <?php foreach ($floor_numbers as $floor): ?>
                                            <?php
                                            $isSelected = (isset($patientDetails['floor_number']) && $patientDetails['floor_number'] === $floor['id']) || 
                                                          (isset($selectedFloor[0]['floor']) && $selectedFloor[0]['floor'] == $floor['id']) ? 'selected' : '';
                                            ?>
                                            <option value="<?= htmlspecialchars($floor['id']) ?>" <?= $isSelected ?>>
                                                <?= htmlspecialchars($floor['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="error-message hidden text-red-500 text-xs mt-1 font-medium"></div>
                            </div>

                            <!-- Suite Number Field -->
                            <div id="suite-number-field" class="form-group">
                                <label for="suite_number" class="block text-sm text-gray-600 mb-1">
                                    Suite Number <span class="required-asterisk text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <?php 
                                    $suiteDisabled = !isset($enableFloorAndSuite) || !$enableFloorAndSuite;
                                    $suiteClasses = $suiteDisabled 
                                        ? "w-full px-4 py-2 border border-gray-300 rounded-lg appearance-none bg-gray-100 cursor-not-allowed transition-colors duration-200"
                                        : "w-full px-4 py-2 border border-gray-300 rounded-lg appearance-none bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200";
                                    $suiteStyle = $suiteDisabled ? "background-color: #f3f4f6; color: #6b7280;" : "";
                                    ?>
                                    <select id="suite_number" name="suite_number" required <?php echo $suiteDisabled ? 'disabled' : ''; ?>
                                            class="<?php echo $suiteClasses; ?>" 
                                            data-validation-message="Suite number is required"
                                            style="<?php echo $suiteStyle; ?>">
                                        <option value="">Select Suite</option>
                                        <?php if (isset($suites) && !empty($suites)): ?>
                                            <?php foreach ($suites as $suite): ?>
                                                <option value="<?= $suite['id'] ?>" <?= ((isset($patientDetails['suite_number']) && $patientDetails['suite_number'] == $suite['id']) || (isset($selected_suite) && $selected_suite == $suite['id'])) ? 'selected' : '' ?>>
                                                    <?= $suite['bed_no'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div id="suite-warning" class="form-text text-red-500 text-xs mt-1 hidden font-medium">
                                    A person is already assigned to this suite and has not been discharged.
                                </div>
                                <div class="error-message hidden text-red-500 text-xs mt-1 font-medium"></div>
                            </div>

                            <!-- Allergies Dropdown -->
                          <div id="allergies-field" class="form-group relative">
    <label for="allergies" class="block text-sm text-gray-600 mb-1">Dietary Restrictions</label>

    <?php 
    $selected_allergies = [];
    if (!empty($patientDetails['allergies'])) {
        $selected_allergies = is_array(json_decode($patientDetails['allergies'], true)) 
            ? json_decode($patientDetails['allergies'], true) 
            : explode(',', $patientDetails['allergies']);
    }
    ?>

    <!-- Dropdown trigger -->
    <button type="button" id="allergiesDropdownBtn" 
        class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        <span id="allergiesSelectedText" class="text-gray-700 text-sm">
            <?= !empty($selected_allergies) ? count($selected_allergies) . " selected" : "Select Diet Restrictions" ?>
        </span>
        <i class="fa-solid fa-chevron-down text-gray-500 ml-2"></i>
    </button>

    <!-- Dropdown menu -->
    <div id="allergiesDropdown"  class="absolute hidden mt-1 w-full max-h-48 overflow-y-auto border border-gray-300 rounded-lg bg-white shadow-lg" style="z-index: 999;">
        <?php foreach ($allergies as $allergy): ?>
            <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                <input 
                    type="checkbox" 
                    name="allergies[]" 
                    value="<?= $allergy['id'] ?>" 
                    class="form-checkbox h-4 w-4 text-primary-600"
                    <?= in_array($allergy['id'], $selected_allergies) ? 'checked' : '' ?>
                >
                <span class="ml-2 text-gray-700 text-sm"><?= $allergy['name'] ?></span>
            </label>
        <?php endforeach; ?>
    </div>

   
</div>

                            <!-- Dietary Preferences Dropdown -->
                          <div id="dietary-preferences-field" class="form-group relative">
    <label for="dietary_preferences" class="block text-sm text-gray-600 mb-1">Dietary Preferences</label>

    <?php 
    $selected_cuisines = [];
    if (!empty($patientDetails['dietary_preferences'])) {
        $selected_cuisines = is_array(json_decode($patientDetails['dietary_preferences'], true)) 
            ? json_decode($patientDetails['dietary_preferences'], true) 
            : explode(',', $patientDetails['dietary_preferences']);
    }
    
    // Fetch cuisines for dietary preferences
    $conditions_cuisine['listtype'] = 'cuisine';
    $conditions_cuisine['is_deleted'] = 0;
    $cuisines = $this->common_model->fetchRecordsDynamically('foodmenuconfig',['id','name'],$conditions_cuisine);
    ?>

    <!-- Dropdown trigger -->
    <button type="button" id="dietaryPreferencesDropdownBtn" 
        class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        <span id="dietaryPreferencesSelectedText" class="text-gray-700 text-sm">
            <?= !empty($selected_cuisines) ? count($selected_cuisines) . " selected" : "Select Dietary Preferences" ?>
        </span>
        <i class="fa-solid fa-chevron-down text-gray-500 ml-2"></i>
    </button>

    <!-- Dropdown menu -->
    <div id="dietaryPreferencesDropdown"  class="absolute hidden mt-1 w-full max-h-48 overflow-y-auto border border-gray-300 rounded-lg bg-white shadow-lg" style="z-index: 999;">
        <?php if (!empty($cuisines)): ?>
            <?php foreach ($cuisines as $cuisine): ?>
                <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="dietary_preferences[]" 
                        value="<?= $cuisine['id'] ?>" 
                        class="form-checkbox h-4 w-4 text-primary-600"
                        <?= in_array($cuisine['id'], $selected_cuisines) ? 'checked' : '' ?>
                    >
                    <span class="ml-2 text-gray-700 text-sm"><?= $cuisine['name'] ?></span>
                </label>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="px-4 py-2 text-gray-500 text-sm">No cuisine types available</div>
        <?php endif; ?>
    </div>
    
    <!-- Message below Dietary Preferences -->
    <div class="mt-2 text-sm italic font-medium" style="color: #ea580c !important;">
        <i class="fa-solid fa-info-circle mr-1" style="color: #f97316 !important;"></i>
        <span style="color: #ea580c !important;">If customer doesn't want to comply, please do not select any preferences</span>
    </div>

   
</div>

                            <!-- Date Onboarded -->
                            <div id="date-onboarded-field" class="form-group">
                                <label for="onboard_date" class="block text-sm text-gray-600 mb-1">
                                    Date Onboarded <span class="required-asterisk text-red-500">*</span>
                                </label>
                                <div class="relative">
                                   <input type="text" id="onboard_date" name="onboard_date" required
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white transition-colors duration-200" 
                                          value="<?= htmlspecialchars(isset($patientDetails['date_onboarded']) && $patientDetails['date_onboarded'] != '' ? $patientDetails['date_onboarded'] : date('Y-m-d')) ?>"
                                          data-validation-message="Date onboarded is required">
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fa-solid fa-calendar-alt text-gray-500"></i>
                                    </div>
                                </div>
                                <div class="error-message hidden text-red-500 text-xs mt-1 font-medium"></div>
                            </div>

                            <!-- Date of Discharge -->
                            <div id="date-discharge-field" class="form-group">
                                <label for="discharge_date" class="block text-sm text-gray-600 mb-1">Date of Discharge</label>
                                <div class="relative">
                                    <input type="text" id="discharge_date" name="discharge_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white" 
                                           value="<?= htmlspecialchars(isset($patientDetails['date_of_discharge']) && $patientDetails['date_of_discharge'] != '' ? $patientDetails['date_of_discharge'] : '') ?>" placeholder="Select discharge date">
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <i class="fa-solid fa-calendar-alt text-gray-500"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Instructions -->
                            <div id="special-instructions-field" class="form-group md:col-span-2">
                                <label for="instructions" class="block text-sm text-gray-600 mb-1">Special Instructions</label>
                                <textarea id="instructions" name="instructions" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                                          placeholder="Enter any special instructions or notes"><?php echo ($patientDetails['special_instructions'] != '' ? $patientDetails['special_instructions'] : '') ?></textarea>
                            </div>

                            <!-- Patient Photo Upload -->
                            <div id="patient-photo-field" class="form-group md:col-span-2">
                                <label for="patient_photo" class="block text-sm text-gray-600 mb-1">
                                    Patient Photo <span class="text-gray-400 text-xs">(Max 2MB, displayed on delivery labels)</span>
                                </label>
                                
                                <?php if (!empty($patientDetails['photo_path'])): ?>
                                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img src="<?php echo base_url($patientDetails['photo_path']); ?>" 
                                                 alt="Current Photo" 
                                                 class="w-16 h-16 rounded-lg object-cover border border-gray-300 mr-3">
                                            <div>
                                                <p class="text-sm text-gray-700 font-medium">Current Photo</p>
                                                <p class="text-xs text-gray-500">Upload a new photo to replace</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="existing_photo_path" value="<?php echo $patientDetails['photo_path']; ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-primary-400 transition-colors">
                                    <input type="file" 
                                           id="patient_photo" 
                                           name="patient_photo" 
                                           accept="image/jpeg,image/jpg,image/png" 
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                           onchange="previewPatientPhoto(this)">
                                    
                                    <div id="upload-placeholder" class="text-center pointer-events-none">
                                        <i class="fa-solid fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600 font-medium">Click to upload or drag and drop</p>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG • Max 2MB</p>
                                    </div>
                                    
                                    <div id="photo-preview" class="hidden">
                                        <div class="flex items-center justify-center">
                                            <img id="preview-image" 
                                                 src="" 
                                                 alt="Photo Preview" 
                                                 class="max-h-48 rounded-lg border border-gray-300 shadow-sm">
                                        </div>
                                        <div class="mt-3 text-center">
                                            <p id="preview-filename" class="text-sm text-gray-700 font-medium"></p>
                                            <p id="preview-filesize" class="text-xs text-gray-500"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="photo-error" class="hidden mt-2 text-red-500 text-xs font-medium"></div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div id="form-buttons" class="flex justify-between mt-8">
                            <?php 
                            // For nurses (role_id == 3), back button goes to Suites page
                            // For others, back button goes to Onboarding list
                            $backUrl = ($this->session->userdata('role_id') == 3) 
                                ? base_url('Orderportal/Hospitalconfig/List') 
                                : base_url('Orderportal/Patient/Onboarding');
                            ?>
                            <a href="<?php echo $backUrl; ?>"><button type="button" id="back-button" class="px-6 py-2 border-2 border-red-500 text-danger rounded-lg flex items-center hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Back
                            </button></a>
                            <button type="submit" id="submit-button" class="px-6 py-2 bg-green-600 text-white rounded-lg flex items-center hover:bg-green-700 transition-colors" style="color: white;">
                                Submit <i class="fa-solid fa-check ml-2" style="color: white !important;"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize date pickers
    // Check if we have existing patient data to determine date restrictions
    const hasExistingPatient = <?php echo (!empty($patientDetails) && isset($patientDetails['id'])) ? 'true' : 'false'; ?>;
    
    flatpickr("#onboard_date", {
        dateFormat: "Y-m-d",
        allowInput: true,
        altInput: true,
        altFormat: "d M, Y",
        minDate: hasExistingPatient ? null : "today"  // Allow past dates for existing patients
    });

    flatpickr("#discharge_date", {
        dateFormat: "Y-m-d",
        allowInput: true,
        altInput: true,
        altFormat: "d M, Y",
        minDate: "today"  // Always restrict past dates for discharge
    });

    // Function to check suite occupancy
    async function isSuiteOccupied(suiteId) {
       let personId =  $('#personId').val();
        if (suiteId == '' || personId !='') return true; // No suite selected, treat as invalid but don't show warning
        try {
            const response = await fetch("<?php echo base_url('Orderportal/Patient/is_suite_occupied') ?>", {
                method: "POST",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: "suite_number=" + encodeURIComponent(suiteId)
            });
            const data = await response.json();
            const warning = document.getElementById('suite-warning');
            if (data.length > 0) {
                warning.classList.remove('hidden');
                return false; // Suite is occupied
            } else {
                warning.classList.add('hidden');
                return true; // Suite is available
            }
        } catch (error) {
            console.error('Error checking suite availability:', error);
            return false; // Treat errors as occupied to prevent submission
        }
    }

    // 🔒 Populate suites based on floor selection - ENABLED only for new patients (Add Person)
    <?php if (isset($enableFloorAndSuite) && $enableFloorAndSuite): ?>
    $('#floor_number').on('change', function () {
        let floorId = $(this).val();
        if (floorId) {
            // Show loading state
            $('#suite_number').prop('disabled', true).html('<option value="">Loading suites...</option>');
            
            $.ajax({
                url: '<?php echo base_url('Orderportal/Patient/getbedno') ?>',
                type: 'POST',
                data: { floor_id: floorId },
                dataType: 'json',
                success: function (response) {
                    $('#suite_number').prop('disabled', false).empty().append('<option value="">Select Suite</option>');
                    if (response && response.length > 0) {
                        $.each(response, function (index, bed) {
                            $('#suite_number').append('<option value="' + bed.id + '">' + bed.bed_no + '</option>');
                        });
                    } else {
                        $('#suite_number').append('<option value="">No vacant suites available</option>');
                    }
                    // Check occupancy of the newly selected suite
                    isSuiteOccupied($('#suite_number').val());
                },
                error: function() {
                    console.error('Error fetching suites for floor');
                    $('#suite_number').prop('disabled', false).html('<option value="">Error loading suites</option>');
                }
            });
        } else {
            $('#suite_number').html('<option value="">Select Suite</option>');
        }
    });
    <?php endif; ?>

    // Form submission handler
    const form = document.getElementById('suite-form');
    const submitButton = document.getElementById('submit-button');
    const loader = document.getElementById('loader');
    let isSubmitting = false; // Flag to prevent duplicate submissions
    
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        
        // Prevent duplicate submissions
        if (isSubmitting) {
            return;
        }
        
        // Show loader and disable submit button
        loader.classList.remove('hidden');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Submitting...';
        isSubmitting = true;
        
        // Use the new comprehensive validation system
        let isValid = validateAllFields(true);
        
        // Check discharge date validation
        const onboardDate = document.getElementById('onboard_date').value;
        const dischargeDate = document.getElementById('discharge_date').value;
        
        if (onboardDate && dischargeDate) {
            const onboard = new Date(onboardDate);
            const discharge = new Date(dischargeDate);
            
            if (discharge < onboard) {
                alert('Error: Discharge date cannot be earlier than onboarding date. Please select a valid discharge date.');
                isValid = false;
            }
        }

        // Check suite occupancy for new patients only
        const personId = document.getElementById('personId').value;
        const suiteNumber = document.getElementById('suite_number').value;
        
        if (suiteNumber && !personId) { // Only check for new patients
            const isSuiteAvailable = await isSuiteOccupied(suiteNumber);
            if (!isSuiteAvailable) {
                isValid = false;
            }
        } else if (!suiteNumber) {
            isValid = false; // No suite selected
        }

        if (isValid) {
            // Submit form after validation passes
            setTimeout(() => {
                form.submit();
            }, 200);
        } else {
            // Reset form if validation fails
            loader.classList.add('hidden');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Submit <i class="fa-solid fa-check ml-2"></i>';
            isSubmitting = false;
        }
    });

    // Enhanced Dynamic Validation System
    function initializeDynamicValidation() {
        const allFields = form.querySelectorAll('input, select, textarea');
        
        allFields.forEach(field => {
            // Track user interaction
            let hasInteracted = false;
            
            // Event listeners for different field types
            const events = ['input', 'change', 'blur', 'focus'];
            
            events.forEach(eventType => {
                field.addEventListener(eventType, function(e) {
                    if (eventType === 'focus') {
                        // Mark as interacted when user focuses
                        hasInteracted = true;
                        field.setAttribute('data-user-interacted', 'true');
                    }
                    
                    if (eventType === 'input' || eventType === 'change') {
                        // Clear validation state immediately on input
                        clearFieldValidation(field);
                        
                        // Validate immediately on change if user has interacted
                        if (hasInteracted) {
                            setTimeout(() => validateField(field, true), 100); // Quick validation on change
                        }
                    }
                    
                    if (eventType === 'blur' && hasInteracted) {
                        // Also validate on blur for completeness
                        validateField(field, true);
                    }
                });
            });
        });
    }
    
    function clearFieldValidation(field) {
        // Remove error styling
        field.classList.remove('border-red-500', 'border-red-400');
        field.classList.add('border-gray-300');
        
        // Hide error message completely
        const errorMsg = getErrorMessageElement(field);
        if (errorMsg) {
            errorMsg.classList.add('hidden');
            errorMsg.textContent = '';
            errorMsg.style.display = 'none';
        }
        
        // Reset asterisk color to normal red
        const label = field.closest('.form-group')?.querySelector('label');
        if (label) {
            const asterisk = label.querySelector('.required-asterisk');
            if (asterisk) {
                asterisk.classList.remove('text-red-600', 'text-red-700');
                asterisk.classList.add('text-red-500');
            }
        }
    }
    
    function validateField(field, showErrors = true) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const hasInteracted = field.hasAttribute('data-user-interacted');
        
        // Don't show errors until user has interacted
        if (!hasInteracted && !showErrors) {
            return true;
        }
        
        let isValid = true;
        let errorMessage = '';
        
        // Required field validation - show error immediately when field is empty after interaction
        if (isRequired && !value && hasInteracted) {
            isValid = false;
            errorMessage = field.getAttribute('data-validation-message') || 'This field is required';
        }
        
        // Email validation
        if (value && field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }
        
        // Phone validation
        if (value && field.type === 'tel') {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number';
            }
        }
        
        // Name validation (no numbers)
        if (value && field.name === 'name') {
            const nameRegex = /^[a-zA-Z\s\-\.\']+$/;
            if (!nameRegex.test(value)) {
                isValid = false;
                errorMessage = 'Name should only contain letters, spaces, hyphens, dots, and apostrophes';
            }
        }
        
        // Apply validation styling
        if (!isValid && showErrors) {
            showFieldError(field, errorMessage);
        } else {
            clearFieldValidation(field);
        }
        
        return isValid;
    }
    
    function showFieldError(field, message) {
        // Add error styling to field
        field.classList.remove('border-gray-300');
        field.classList.add('border-red-500');
        
        // Show error message with strong red styling
        const errorMsg = getErrorMessageElement(field);
        if (errorMsg) {
            errorMsg.textContent = message;
            errorMsg.classList.remove('hidden');
            errorMsg.style.display = 'block';
            errorMsg.style.color = '#ef4444 !important';
            errorMsg.style.fontWeight = '500';
            errorMsg.style.fontSize = '0.75rem';
            errorMsg.style.marginTop = '0.25rem';
            
            // Force red color with classes as well
            errorMsg.classList.add('text-red-500');
            errorMsg.classList.remove('text-gray-500', 'text-black');
        }
        
        // Make asterisk darker when there's an error
        const label = field.closest('.form-group')?.querySelector('label');
        if (label) {
            const asterisk = label.querySelector('.required-asterisk');
            if (asterisk) {
                asterisk.classList.remove('text-red-500');
                asterisk.classList.add('text-red-600');
            }
        }
    }
    
    function getErrorMessageElement(field) {
        // Try to find error message in parent or parent's parent
        return field.parentElement.querySelector('.error-message') || 
               field.parentElement.parentElement.querySelector('.error-message');
    }
    
    function validateAllFields(showErrors = true) {
        let allValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            field.setAttribute('data-user-interacted', 'true'); // Force interaction for validation
            const isValid = validateField(field, showErrors);
            if (!isValid) {
                allValid = false;
            }
        });
        
        return allValid;
    }
    
    // Initialize clean form state
    function initializeCleanForm() {
        // Hide all error messages by default
        const allErrorMessages = form.querySelectorAll('.error-message');
        allErrorMessages.forEach(errorMsg => {
            errorMsg.classList.add('hidden');
            errorMsg.style.display = 'none';
            errorMsg.textContent = '';
        });
        
        // Reset all field borders to normal
        const allFields = form.querySelectorAll('input, select, textarea');
        allFields.forEach(field => {
            field.classList.remove('border-red-500', 'border-red-400');
            field.classList.add('border-gray-300');
        });
        
        // Ensure all asterisks are normal red
        const allAsterisks = form.querySelectorAll('.required-asterisk');
        allAsterisks.forEach(asterisk => {
            asterisk.classList.remove('text-red-600', 'text-red-700');
            asterisk.classList.add('text-red-500');
        });
    }
    
    // Initialize clean form first, then dynamic validation
    initializeCleanForm();
    initializeDynamicValidation();

    // Trigger suite occupancy check on page load if a suite is pre-selected
    const suiteNumber = document.getElementById('suite_number').value;
    if (suiteNumber) {
        isSuiteOccupied(suiteNumber);
    }
});

/**
 * Preview patient photo before upload
 * Validates file size (max 2MB) and type (JPEG, PNG)
 */
function previewPatientPhoto(input) {
    const photoError = document.getElementById('photo-error');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const photoPreview = document.getElementById('photo-preview');
    const previewImage = document.getElementById('preview-image');
    const previewFilename = document.getElementById('preview-filename');
    const previewFilesize = document.getElementById('preview-filesize');
    
    // Reset error
    photoError.classList.add('hidden');
    photoError.textContent = '';
    
    // Check if file is selected
    if (!input.files || input.files.length === 0) {
        uploadPlaceholder.classList.remove('hidden');
        photoPreview.classList.add('hidden');
        return;
    }
    
    const file = input.files[0];
    
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        photoError.textContent = 'Invalid file type. Please upload JPG or PNG only.';
        photoError.classList.remove('hidden');
        input.value = ''; // Clear the file input
        uploadPlaceholder.classList.remove('hidden');
        photoPreview.classList.add('hidden');
        return;
    }
    
    // Validate file size (2MB = 2 * 1024 * 1024 bytes)
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (file.size > maxSize) {
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
        photoError.textContent = `File size (${fileSizeMB}MB) exceeds the 2MB limit. Please choose a smaller file.`;
        photoError.classList.remove('hidden');
        input.value = ''; // Clear the file input
        uploadPlaceholder.classList.remove('hidden');
        photoPreview.classList.add('hidden');
        return;
    }
    
    // Preview the image
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewFilename.textContent = file.name;
        const fileSizeKB = (file.size / 1024).toFixed(2);
        previewFilesize.textContent = `${fileSizeKB} KB`;
        
        uploadPlaceholder.classList.add('hidden');
        photoPreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

</script>

<script>
// for multiselect of allergens
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("allergiesDropdownBtn");
        const menu = document.getElementById("allergiesDropdown");
        const selectedText = document.getElementById("allergiesSelectedText");
        const checkboxes = menu.querySelectorAll("input[type=checkbox]");

        // Toggle dropdown
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });

        // Update selected text when user checks/unchecks
        checkboxes.forEach(cb => {
            cb.addEventListener("change", () => {
                const checked = [...checkboxes].filter(c => c.checked).length;
                selectedText.textContent = checked > 0 ? checked + " selected" : "Select Diet Restrictions";
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    });

// for multiselect of dietary preferences
    document.addEventListener("DOMContentLoaded", function () {
        const dietaryBtn = document.getElementById("dietaryPreferencesDropdownBtn");
        const dietaryMenu = document.getElementById("dietaryPreferencesDropdown");
        const dietarySelectedText = document.getElementById("dietaryPreferencesSelectedText");
        
        if (dietaryBtn && dietaryMenu) {
            const dietaryCheckboxes = dietaryMenu.querySelectorAll("input[type=checkbox]");

            // Toggle dropdown
            dietaryBtn.addEventListener("click", () => {
                dietaryMenu.classList.toggle("hidden");
            });

            // Update selected text when user checks/unchecks
            dietaryCheckboxes.forEach(cb => {
                cb.addEventListener("change", () => {
                    const checked = [...dietaryCheckboxes].filter(c => c.checked).length;
                    dietarySelectedText.textContent = checked > 0 ? checked + " selected" : "Select Dietary Preferences";
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", (e) => {
                if (!dietaryBtn.contains(e.target) && !dietaryMenu.contains(e.target)) {
                    dietaryMenu.classList.add("hidden");
                }
            });
        }
    });
</script>

<style>
/* Enhanced Dynamic Validation Styles */
.form-group {
    position: relative;
}

/* Red asterisk styling */
.required-asterisk {
    font-weight: bold;
    transition: color 0.2s ease;
    color: #ef4444 !important;
}

.required-asterisk.error {
    color: #dc2626 !important;
}

/* Error state styling */
.border-red-500 {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.border-red-500:focus {
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
}

/* Error message styling */
.error-message {
    display: flex;
    align-items: center;
    animation: slideDown 0.3s ease-out;
    color: #ef4444 !important;
    font-weight: 500;
}

.error-message.hidden {
    display: none !important;
}

/* Remove the warning icon by default */
.error-message:before {
    content: "";
    margin-right: 0;
}

/* Slide down animation for error messages */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Focus styling for better UX */
input:focus, select:focus, textarea:focus {
    outline: none;
    transition: all 0.2s ease;
}

/* Hover effects */
input:hover, select:hover, textarea:hover {
    border-color: #9ca3af;
    transition: border-color 0.2s ease;
}

/* Placeholder styling */
input::placeholder, textarea::placeholder {
    color: #9ca3af;
    font-style: italic;
}

/* Ensure error messages are properly styled */
.text-red-500 {
    color: #ef4444 !important;
}

.text-red-600 {
    color: #dc2626 !important;
}

/* Override any conflicting styles - Strong red color enforcement */
.error-message {
    color: #ef4444 !important;
    font-weight: 500 !important;
    font-size: 0.75rem !important;
    margin-top: 0.25rem !important;
    display: block !important;
}

.error-message.hidden {
    display: none !important;
    visibility: hidden !important;
}

/* Force red color on error messages */
.error-message.text-red-500,
.form-group .error-message,
div.error-message {
    color: #ef4444 !important;
}

/* Override any framework styles that might interfere */
.error-message * {
    color: inherit !important;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .error-message {
        font-size: 0.7rem !important;
    }
    
    .required-asterisk {
        font-size: 0.9em;
    }
    
    input, select, textarea {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}

/* Ensure submit button icon is white - target SVG paths specifically */
#submit-button {
    color: white !important;
}

#submit-button i,
#submit-button .fa-check,
#submit-button .fa-solid {
    color: white !important;
}

/* Target SVG elements directly - this is key for FontAwesome icons */
#submit-button svg,
#submit-button svg path {
    fill: white !important;
    color: white !important;
}

/* Override currentColor in SVG paths */
#submit-button i svg path,
#submit-button .fa-check svg path,
#submit-button .fa-solid svg path {
    fill: white !important;
}

/* Force white color on button and all children */
button#submit-button,
button#submit-button * {
    color: white !important;
}
</style>
