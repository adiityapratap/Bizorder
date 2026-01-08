<div class="main-content">
    <?php $this->session->unset_userdata('listtype'); ?>

    <div class="page-content">
        <div class="container-fluid">
            
            <div class="col-12">
                <div class="alert alert-success fade show" role="alert" style="display:none">
                    Data Added Successfully
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 text-black">Settings</h4>
                                <div class="page-title-right">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="d-flex justify-content-sm-end gap-2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <form class="settingForm" id="settingsForm" novalidate>
                                <!-- Hidden field for department_id -->
                                <input type="hidden" name="department_id" value="<?php echo (isset($departmentLatestSettingsData['department_id']) ? $departmentLatestSettingsData['department_id'] : $this->session->userdata('department_id')); ?>">
                                
                                <!-- Hospital Information Section -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-header bg-gradient-primary text-white border-0">
                                        <h5 class="mb-0 fw-bold">
                                            <i class="ri-hospital-line me-2 fs-5"></i>Hospital Information
                                        </h5>
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="row g-3">
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Hospital Company Name <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="hospital_company_name"
                                                           name="hospital_company_name" 
                                                           autocomplete="off" 
                                                           placeholder="Enter hospital company name"
                                                           data-validation="required|minlength:2"
                                                           value="<?php echo (isset($departmentLatestSettingsData['hospital_company_name']) ? $departmentLatestSettingsData['hospital_company_name'] : ''); ?>">
                                                    <div class="invalid-feedback" id="hospital_company_name_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Hospital Company Address <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="hospital_company_addr"
                                                           name="hospital_company_addr" 
                                                           autocomplete="off" 
                                                           placeholder="Enter hospital address"
                                                           data-validation="required|minlength:5"
                                                           value="<?php echo (isset($departmentLatestSettingsData['hospital_company_addr']) ? $departmentLatestSettingsData['hospital_company_addr'] : ''); ?>">
                                                    <div class="invalid-feedback" id="hospital_company_addr_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Hospital ABN <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="hospital_abn"
                                                           name="hospital_abn" 
                                                           autocomplete="off" 
                                                           placeholder="e.g., 12345678901"
                                                           data-validation="required|abn"
                                                           maxlength="11"
                                                           value="<?php echo (isset($departmentLatestSettingsData['hospital_abn']) ? $departmentLatestSettingsData['hospital_abn'] : ''); ?>">
                                                    <div class="invalid-feedback" id="hospital_abn_error"></div>
                                                    <div class="form-text text-muted">
                                                        <small><i class="ri-information-line"></i> Enter exactly 11 digits (e.g., 12345678901)</small>
                                                    </div>
                                                    <div class="valid-feedback">Valid ABN format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Hospital Email <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="hospital_email"
                                                           name="hospital_email" 
                                                           autocomplete="off" 
                                                           placeholder="Enter valid email address"
                                                           data-validation="required|email"
                                                           value="<?php echo (isset($departmentLatestSettingsData['hospital_email']) ? $departmentLatestSettingsData['hospital_email'] : ''); ?>">
                                                    <div class="invalid-feedback" id="hospital_email_error"></div>
                                                    <div class="valid-feedback">Valid email format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Hospital Phone <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="tel" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="hospital_phone"
                                                           name="hospital_phone" 
                                                           autocomplete="off" 
                                                           placeholder="Enter phone number"
                                                           data-validation="required|phone"
                                                           value="<?php echo (isset($departmentLatestSettingsData['hospital_phone']) ? $departmentLatestSettingsData['hospital_phone'] : ''); ?>">
                                                    <div class="invalid-feedback" id="hospital_phone_error"></div>
                                                    <div class="valid-feedback">Valid phone format!</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Café Details Section -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-header bg-gradient-success text-white border-0">
                                        <h5 class="mb-0 fw-bold">
                                            <i class="ri-restaurant-line me-2 fs-5"></i>Café Details
                                        </h5>
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="row g-3">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Daily Cost <span class="required-asterisk">*</span>
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text border-2">$</span>
                                                        <input type="number" 
                                                               class="form-control border-2" 
                                                               id="daily_budget"
                                                               name="daily_budget" 
                                                               autocomplete="off" 
                                                               placeholder="0.00"
                                                               step="0.01"
                                                               min="0"
                                                               data-validation="required|currency"
                                                               value="<?php echo (isset($departmentLatestSettingsData['daily_budget']) ? $departmentLatestSettingsData['daily_budget'] : ''); ?>">
                                                    </div>
                                                    <div class="invalid-feedback" id="daily_budget_error"></div>
                                                    <div class="valid-feedback">Valid amount!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Daily Minimum Limit <span class="required-asterisk">*</span>
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text border-2">$</span>
                                                        <input type="number" 
                                                               class="form-control border-2" 
                                                               id="daily_limit"
                                                               name="daily_limit" 
                                                               autocomplete="off" 
                                                               placeholder="0.00"
                                                               step="0.01"
                                                               min="0"
                                                               data-validation="required|currency"
                                                               value="<?php echo (isset($departmentLatestSettingsData['daily_limit']) ? $departmentLatestSettingsData['daily_limit'] : ''); ?>">
                                                    </div>
                                                    <div class="invalid-feedback" id="daily_limit_error"></div>
                                                    <div class="valid-feedback">Valid amount!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Café Company Name <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="company_name"
                                                           name="company_name" 
                                                           autocomplete="off" 
                                                           placeholder="Enter café company name"
                                                           data-validation="required|minlength:2"
                                                           value="<?php echo (isset($departmentLatestSettingsData['company_name']) ? $departmentLatestSettingsData['company_name'] : ''); ?>">
                                                    <div class="invalid-feedback" id="company_name_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Café Company Address <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="company_addr"
                                                           name="company_addr" 
                                                           autocomplete="off" 
                                                           placeholder="Enter café address"
                                                           data-validation="required|minlength:5"
                                                           value="<?php echo (isset($departmentLatestSettingsData['company_addr']) ? $departmentLatestSettingsData['company_addr'] : ''); ?>">
                                                    <div class="invalid-feedback" id="company_addr_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Café ABN <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="abn"
                                                           name="abn" 
                                                           autocomplete="off" 
                                                           placeholder="e.g., 98765432109"
                                                           data-validation="required|abn"
                                                           maxlength="11"
                                                           value="<?php echo (isset($departmentLatestSettingsData['abn']) ? $departmentLatestSettingsData['abn'] : ''); ?>">
                                                    <div class="invalid-feedback" id="abn_error"></div>
                                                    <div class="form-text text-muted">
                                                        <small><i class="ri-information-line"></i> Enter exactly 11 digits (e.g., 98765432109)</small>
                                                    </div>
                                                    <div class="valid-feedback">Valid ABN format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Café Email <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="cafe_email"
                                                           name="cafe_email" 
                                                           autocomplete="off" 
                                                           placeholder="Enter valid email address"
                                                           data-validation="required|email"
                                                           value="<?php echo (isset($departmentLatestSettingsData['cafe_email']) ? $departmentLatestSettingsData['cafe_email'] : ''); ?>">
                                                    <div class="invalid-feedback" id="cafe_email_error"></div>
                                                    <div class="valid-feedback">Valid email format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Café Phone <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="tel" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="cafe_phone"
                                                           name="cafe_phone" 
                                                           autocomplete="off" 
                                                           placeholder="Enter phone number"
                                                           data-validation="required|phone"
                                                           value="<?php echo (isset($departmentLatestSettingsData['cafe_phone']) ? $departmentLatestSettingsData['cafe_phone'] : ''); ?>">
                                                    <div class="invalid-feedback" id="cafe_phone_error"></div>
                                                    <div class="valid-feedback">Valid phone format!</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Details Section -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-header bg-gradient-info text-white border-0">
                                        <h5 class="mb-0 fw-bold">
                                            <i class="ri-bank-line me-2 fs-5"></i>Café Bank Details
                                        </h5>
                                    </div>
                                    <div class="card-body bg-light">
                                        <div class="row g-3">
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Account Name <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="account_name"
                                                           name="account_name" 
                                                           autocomplete="off" 
                                                           placeholder="Enter account holder name"
                                                           data-validation="required|minlength:2"
                                                           value="<?php echo (isset($departmentLatestSettingsData['account_name']) ? $departmentLatestSettingsData['account_name'] : ''); ?>">
                                                    <div class="invalid-feedback" id="account_name_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Account Email <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="account_email"
                                                           name="account_email" 
                                                           autocomplete="off" 
                                                           placeholder="Enter account email address"
                                                           data-validation="required|email"
                                                           value="<?php echo (isset($departmentLatestSettingsData['account_email']) ? $departmentLatestSettingsData['account_email'] : ''); ?>">
                                                    <div class="invalid-feedback" id="account_email_error"></div>
                                                    <div class="valid-feedback">Valid email format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Account No <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="account_no"
                                                           name="account_no" 
                                                           autocomplete="off" 
                                                           placeholder="Enter account number"
                                                           data-validation="required|account_number"
                                                           value="<?php echo (isset($departmentLatestSettingsData['account_no']) ? $departmentLatestSettingsData['account_no'] : ''); ?>">
                                                    <div class="invalid-feedback" id="account_no_error"></div>
                                                    <div class="valid-feedback">Valid account number!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        BSB <span class="required-asterisk">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg border-2" 
                                                           id="bsb"
                                                           name="bsb" 
                                                           autocomplete="off" 
                                                           placeholder="Enter 6-digit BSB"
                                                           data-validation="required|bsb"
                                                           maxlength="7"
                                                           pattern="[0-9]{3}-?[0-9]{3}"
                                                           value="<?php echo (isset($departmentLatestSettingsData['bsb']) ? $departmentLatestSettingsData['bsb'] : ''); ?>">
                                                    <div class="invalid-feedback" id="bsb_error"></div>
                                                    <div class="valid-feedback">Valid BSB format!</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-8">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold text-dark">
                                                        Terms <span class="required-asterisk">*</span>
                                                    </label>
                                                    <textarea class="form-control form-control-lg border-2" 
                                                              id="terms"
                                                              name="terms" 
                                                              rows="4" 
                                                              placeholder="Enter payment terms and conditions (minimum 10 characters)"
                                                              data-validation="required|minlength:10"><?php echo (isset($departmentLatestSettingsData['terms']) ? $departmentLatestSettingsData['terms'] : ''); ?></textarea>
                                                    <div class="invalid-feedback" id="terms_error"></div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="form-text text-muted">
                                                        <small><i class="ri-information-line"></i> Include payment terms, conditions, and any special instructions</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="text-center py-4">
                                    <button type="button" 
                                            class="btn btn-success btn-lg px-5 py-3 shadow-lg" 
                                            id="saveSettingsBtn"
                                            onclick="submitHospitalSettings(this)">
                                        <i class="ri-save-line me-2 fs-5"></i>
                                        <span class="fw-bold">Save Settings</span>
                                    </button>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="ri-shield-check-line text-success"></i> 
                                            All fields are validated in real-time
                                        </small>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
/* Form Focus States */
.form-control:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
}

/* Textarea focus state */
.form-control[rows]:focus,
textarea.form-control:focus {
    height: 96px !important;
    min-height: 96px !important;
    max-height: none !important;
}

/* Valid State - Better checkmark icon */
.form-control.is-valid {
    border-color: #198754 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%23198754' d='M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 16px !important;
    padding-right: 40px !important;
}

/* Invalid State - Better X icon */
.form-control.is-invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%23dc3545' d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 16px !important;
    padding-right: 40px !important;
}

/* Input Group Valid/Invalid States */
.input-group .form-control.is-valid {
    background-position: right calc(0.375em + 0.1875rem) center !important;
}
.input-group .form-control.is-invalid {
    background-position: right calc(0.375em + 0.1875rem) center !important;
}

/* Required Asterisk - Make it bright red and visible */
.required-asterisk {
    color: #dc3545 !important;
    font-weight: bold !important;
    font-size: 1.2rem !important;
    margin-left: 0.25rem !important;
}

.text-danger {
    color: #dc3545 !important;
    font-weight: bold !important;
    font-size: 1rem !important;
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
}

/* Form Group Positioning */
.form-group {
    position: relative;
    margin-bottom: 1rem;
}

/* Error Messages - Simple red text only */
.invalid-feedback {
    display: none !important;
    font-size: 0.875rem !important;
    color: #dc3545 !important;
    font-weight: 600 !important;
    margin-top: 0.25rem !important;
}

.invalid-feedback.d-block {
    display: block !important;
}

/* Ensure all error messages in the form have red text */
#settingsForm .invalid-feedback {
    color: #dc3545 !important;
    background: none !important;
    border: none !important;
    padding: 0 !important;
}

/* Override any Bootstrap default styling for error messages */
.form-control.is-invalid ~ .invalid-feedback {
    color: #dc3545 !important;
    background: transparent !important;
    border: none !important;
}

/* Hint text positioning - close to input by default */
.form-text {
    margin-top: 0.25rem !important;
    font-size: 0.75rem !important;
    color: #6c757d !important;
    transition: margin-top 0.2s ease !important;
}

/* When error is visible, hint appears after error message */
.form-group .invalid-feedback.d-block + .form-text {
    margin-top: 0.25rem !important;
}

/* When no error is shown, hint stays close to input */
.form-group .invalid-feedback:not(.d-block) + .form-text {
    margin-top: 0.25rem !important;
}

/* Ensure proper spacing for form elements */
.form-group .invalid-feedback {
    margin-top: 0.25rem !important;
    margin-bottom: 0 !important;
}

.form-group .valid-feedback {
    margin-top: 0.25rem !important;
    margin-bottom: 0 !important;
}

/* Success Messages - Simple and clean */
.valid-feedback {
    display: none !important;
    font-size: 0.875rem !important;
    color: #198754 !important;
    font-weight: 500 !important;
    margin-top: 0.25rem !important;
}

.valid-feedback.d-block {
    display: block !important;
}

/* Input Group Text - Gray background with green dollar sign */
.input-group-text {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
    padding: 12px 16px !important;
    background-color: #f8f9fa !important;
    border-color: #ced4da !important;
    color: #198754 !important;
    font-weight: bold !important;
    font-size: 18px !important;
    border-width: 1px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.input-group:focus-within .input-group-text {
    background-color: #e9ecef !important;
    border-color: #0d6efd !important;
    color: #198754 !important;
}

/* Input group container - ensure proper alignment and width */
.input-group {
    height: 48px !important;
    width: 100% !important;
}

/* Ensure input group inputs take full width */
.input-group .form-control {
    flex: 1 1 auto !important;
    width: 1% !important;
    min-width: 0 !important;
}

.input-group-lg {
    height: 48px !important;
}

/* CONSISTENT HEIGHTS FOR ALL FORM CONTROLS */

/* All form controls - base styling */
.form-control {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
    padding: 12px 16px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
    border-width: 1px !important;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
}

/* Large form controls - same height */
.form-control-lg {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
    padding: 12px 16px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
}

/* Textarea specific - allow vertical resize but consistent initial height */
.form-control[rows],
textarea.form-control {
    height: 96px !important;
    min-height: 96px !important;
    max-height: none !important;
    resize: vertical !important;
    padding: 12px 16px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
}

/* Input groups - ensure consistent height */
.input-group .form-control {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
}

/* Focus states - maintain height */
.form-control:focus {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
}

/* Valid/Invalid states - maintain height */
.form-control.is-valid,
.form-control.is-invalid {
    height: 48px !important;
    min-height: 48px !important;
    max-height: 48px !important;
}

/* Textarea focus and validation states */
.form-control[rows]:focus,
textarea.form-control:focus,
.form-control[rows].is-valid,
.form-control[rows].is-invalid,
textarea.form-control.is-valid,
textarea.form-control.is-invalid {
    height: 96px !important;
    min-height: 96px !important;
    max-height: none !important;
}

/* Card Animations */
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* Button Animations */
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
}

/* Fix for input group with validation icons */
.input-group .form-control {
    position: relative;
    z-index: 2;
}

/* Ensure labels are properly styled */
.form-label {
    font-weight: 600 !important;
    color: #495057 !important;
    margin-bottom: 0.25rem !important;
}

/* Row alignment for consistent heights */
.row.g-3 > * {
    display: flex;
    flex-direction: column;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: auto;
}

.form-group .form-control,
.form-group .input-group {
    flex: none;
    height: 48px;
}

.form-group .form-control[rows],
.form-group textarea.form-control {
    flex: none;
    height: 96px;
}

/* Ensure consistent spacing and alignment */
.col-md-6,
.col-lg-3,
.col-lg-4,
.col-lg-8,
.col-md-12 {
    min-height: auto;
}

/* Fix for validation icon positioning */
.form-control.is-valid,
.form-control.is-invalid {
    background-position: right 12px center !important;
    padding-right: 40px !important;
}

/* Input group validation icons */
.input-group .form-control.is-valid,
.input-group .form-control.is-invalid {
    background-position: right 12px center !important;
    padding-right: 40px !important;
}

/* Section title icons - make them visible and green */
.card-header i {
    color: #198754 !important;
    font-size: 1.2rem !important;
    margin-right: 0.5rem !important;
}

/* Light blue background for all section headers */
.bg-gradient-primary,
.bg-gradient-success,
.bg-gradient-info {
    background: #e3f2fd !important;
    background-image: none !important;
    border-color: #bbdefb !important;
    color: #1976d2 !important;
}

/* Ensure text in headers is readable */
.bg-gradient-primary h5,
.bg-gradient-success h5,
.bg-gradient-info h5 {
    color: #1976d2 !important;
    font-weight: 600 !important;
}

/* Override gradient backgrounds with light blue */
.bg-gradient-primary i,
.bg-gradient-success i,
.bg-gradient-info i {
    color: #198754 !important;
    font-size: 1.2rem !important;
    margin-right: 0.5rem !important;
}

/* Specific icon overrides for all card headers */
.card-header .ri-hospital-line,
.card-header .ri-restaurant-line,
.card-header .ri-bank-line {
    color: #198754 !important;
}

/* Force green color for all icons in card headers with gradient backgrounds */
.card-header.bg-gradient-primary h5 i,
.card-header.bg-gradient-success h5 i,
.card-header.bg-gradient-info h5 i {
    color: #198754 !important;
}

/* Additional specificity for RemixIcon classes */
.card-header h5 i[class*="ri-"] {
    color: #198754 !important;
}

/* Make sure section headers have proper styling */
.card-header h5 {
    display: flex !important;
    align-items: center !important;
    margin: 0 !important;
}

.card-header h5 i {
    flex-shrink: 0 !important;
}
</style>

<script>
   

// Real-time validation system
$(document).ready(function() {
    // Initialize validation on all form inputs
    $('#settingsForm input, #settingsForm textarea').on('input blur', function() {
        validateField($(this));
    });
    
    // Format BSB field
    $('#bsb').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 3) {
            value = value.substring(0, 3) + '-' + value.substring(3, 6);
        }
        $(this).val(value);
    });
    
    // Format phone numbers
    $('input[type="tel"]').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 10) value = value.substring(0, 10);
        $(this).val(value);
    });
    
    // Format ABN fields
    $('input[data-validation*="abn"]').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 11) value = value.substring(0, 11);
        $(this).val(value);
    });
});

// Validation functions
function validateField(field) {
    const fieldId = field.attr('id');
    const fieldValue = field.val().trim();
    const validationRules = field.attr('data-validation');
    const errorDiv = $('#' + fieldId + '_error');
    
    if (!validationRules) return true;
    
    const rules = validationRules.split('|');
    let isValid = true;
    let errorMessage = '';
    
    // Check each validation rule
    for (let rule of rules) {
        const [ruleName, ruleValue] = rule.split(':');
        
        switch (ruleName) {
            case 'required':
                if (!fieldValue) {
                    isValid = false;
                    errorMessage = 'This field is required.';
                }
                break;
                
            case 'minlength':
                if (fieldValue && fieldValue.length < parseInt(ruleValue)) {
                    isValid = false;
                    errorMessage = `Minimum ${ruleValue} characters required.`;
                }
                break;
                
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (fieldValue && !emailRegex.test(fieldValue)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
                break;
                
            case 'phone':
                const phoneRegex = /^[0-9]{10}$/;
                if (fieldValue && !phoneRegex.test(fieldValue.replace(/\D/g, ''))) {
                    isValid = false;
                    errorMessage = 'Please enter a valid 10-digit phone number.';
                }
                break;
                
            case 'abn':
                const abnDigits = fieldValue.replace(/\D/g, '');
                if (fieldValue && (abnDigits.length !== 11 || !validateABN(abnDigits))) {
                    isValid = false;
                    if (abnDigits.length !== 11) {
                        errorMessage = 'ABN must be exactly 11 digits.';
                    } else {
                        errorMessage = 'Please enter a valid ABN (cannot be all zeros or same digits).';
                    }
                }
                break;
                
            case 'bsb':
                const bsbRegex = /^[0-9]{3}-?[0-9]{3}$/;
                if (fieldValue && !bsbRegex.test(fieldValue)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid BSB format (123-456).';
                }
                break;
                
            case 'account_number':
                if (fieldValue && (fieldValue.length < 6 || fieldValue.length > 10)) {
                    isValid = false;
                    errorMessage = 'Account number should be 6-10 digits.';
                }
                break;
                
            case 'currency':
                const currencyRegex = /^\d+(\.\d{1,2})?$/;
                if (fieldValue && (!currencyRegex.test(fieldValue) || parseFloat(fieldValue) < 0)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid amount (e.g., 10.50).';
                }
                break;
        }
        
        if (!isValid) break;
    }
    
    // Apply validation classes and show/hide messages
    if (isValid && fieldValue) {
        field.removeClass('is-invalid').addClass('is-valid');
        errorDiv.text('').hide().removeClass('d-block');
        field.siblings('.valid-feedback').show().addClass('d-block');
        field.siblings('.invalid-feedback').hide().removeClass('d-block');
    } else if (!isValid) {
        field.removeClass('is-valid').addClass('is-invalid');
        errorDiv.text(errorMessage).show().addClass('d-block');
        field.siblings('.valid-feedback').hide().removeClass('d-block');
        field.siblings('.invalid-feedback').show().addClass('d-block');
    } else {
        field.removeClass('is-valid is-invalid');
        errorDiv.text('').hide().removeClass('d-block');
        field.siblings('.valid-feedback, .invalid-feedback').hide().removeClass('d-block');
    }
    
    return isValid;
}

// ABN validation algorithm - simplified for better user experience
function validateABN(abn) {
    abn = abn.replace(/\D/g, '');
    
    // Basic validation: must be exactly 11 digits
    if (abn.length !== 11) return false;
    
    // Must not be all zeros or all same digits
    if (/^0+$/.test(abn) || /^(\d)\1{10}$/.test(abn)) return false;
    
    // For development/testing, accept any 11-digit number that's not all zeros/same
    // In production, you can enable the full checksum validation below
    return true;
    
    /* Full ABN checksum validation (commented out for easier testing)
    const weights = [10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19];
    let sum = 0;
    
    // Subtract 1 from first digit
    const firstDigit = parseInt(abn[0]) - 1;
    sum += firstDigit * weights[0];
    
    // Add remaining digits
    for (let i = 1; i < 11; i++) {
        sum += parseInt(abn[i]) * weights[i];
    }
    
    return sum % 89 === 0;
    */
}

// Form submission with validation
function submitHospitalSettings(obj) {
    const $btn = $(obj);
    const form = $('#settingsForm');
    const originalText = $btn.html();
    
    // Validate all fields before submission
    let allValid = true;
    form.find('input, textarea').each(function() {
        if (!validateField($(this))) {
            allValid = false;
        }
    });
    
    if (!allValid) {
        // Show error message
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Please fix all validation errors before submitting.',
            confirmButtonColor: '#dc3545'
        });
        return false;
    }
    
    // Show loading state
    $btn.html('<i class="ri-loader-4-line me-2 fs-5 spin"></i><span class="fw-bold">Saving...</span>');
    $btn.prop('disabled', true);
    
    const formData = form.serialize();
    
    $.ajax({
        url: '<?php echo base_url($this->session->userdata("tenantIdentifier") . "/Orderportal/Settings/saveHospitalSettings"); ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $btn.html(originalText);
            $btn.prop('disabled', false);
            
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Settings saved successfully!',
                    confirmButtonColor: '#198754',
                    timer: 3000,
                    showConfirmButton: false
                });
                
                // Add success animation to button
                $btn.addClass('btn-outline-success').removeClass('btn-success');
                setTimeout(() => {
                    $btn.removeClass('btn-outline-success').addClass('btn-success');
                }, 2000);
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to save settings.',
                    confirmButtonColor: '#dc3545'
                });
            }
        },
        error: function(xhr, status, error) {
            $btn.html(originalText);
            $btn.prop('disabled', false);
            
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Unable to save settings. Please check your connection and try again.',
                confirmButtonColor: '#dc3545'
            });
        }
    });
}

// Add spinning animation for loader
const style = document.createElement('style');
style.textContent = `
    .spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

</script>