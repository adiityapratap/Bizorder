<div class="container-fluid" style="margin-top: 0 !important;">
   <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
           <form class="row needs-validation" novalidate action="<?php echo current_url(); ?>" method="post">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1 text-black">Update Role</h4>
                                        <div class="flex-shrink-0">
                                            <a type="button" class="btn bg-orange add-btn" 
                                                id="create-btn" href="<?php echo base_url('auth/group_listing') ?>"><i
                                                    class="ri-arrow-go-back-fill align-bottom me-1"></i> Back
                                                </a>
                                              <button class="btn btn-success" type="submit">Update Role</button>
                                           <button type="button" class="btn btn-info custom-toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
    <i class="ri-settings-3-line align-bottom me-1"></i> Configure Menu
</button>         

                                        </div>
                                    </div><!-- end card header -->
        
        
        <div class="card-body">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
                             <div class="row row-inner mb-3">
                                     <div class="col-md-4">
                                                    <label for="group_name" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?php echo htmlspecialchars($group_name); ?>" name="group_name" <?php echo ($group_name == 'Admin' || $group_name == 'Manager' ||  $group_name == 'Staff' || $group_name == 'Chef' || $group_name == 'Nurse' || $group_name == 'Patient' ? 'readonly' : '') ?> class="form-control" id="group_name" required minlength="2" maxlength="50" pattern="^[a-zA-Z0-9\s\-_]+$" title="Only letters, numbers, spaces, hyphens and underscores are allowed">
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">
                                                        <strong>Role Name is required.</strong><br>
                                                        • Must be 2-50 characters long<br>
                                                        • Only letters, numbers, spaces, hyphens (-) and underscores (_) allowed<br>
                                                        • Special characters like @#$%^&* are not allowed
                                                    </div>
                                                    <small class="text-muted">Examples: Admin, Chef Assistant, Data_Entry, HR-Manager</small>
                                                    <div class="char-count text-muted mt-1"></div>
                                                </div>
                                                
                                                 <div class="col-md-4" style="display:none">
                                                    <label for="displayName" class="form-label fw-semibold">Role Display Name</label>
                                                    <input type="text" value="<?php echo htmlspecialchars($displayName); ?>" name="displayName" class="form-control" id="displayName" >
                                                    <div class="valid-feedback"> Looks good! </div>
                                                    <div class="invalid-feedback">Please enter role name.</div> 
                                                </div>
                                        
                                        <div class="col-md-4">
                                                    <label for="group_description" class="form-label fw-semibold">Description</label>
                                                    <textarea class="form-control" id="group_description" name="group_description" rows="3" maxlength="255" placeholder="Optional: Brief description of the role's responsibilities"><?php echo htmlspecialchars($group_description); ?></textarea>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">Description must be less than 255 characters.</div>
                                                    <small class="text-muted">Optional field. Maximum 255 characters.</small>
                                                    <div class="char-count text-muted mt-1"></div>
                                                </div>
                                </div>       
        </div>
                </div> 
                </form>
                
                </div>
                </div>
                </div>

<style>
/* Ensure asterisk and error messages are red */
.text-danger {
    color: #dc3545 !important;
}

.invalid-feedback {
    color: #dc3545 !important;
}

.is-invalid ~ .invalid-feedback {
    display: block !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleNameInput = document.getElementById('group_name');
    const descriptionTextarea = document.getElementById('group_description');
    const form = document.querySelector('form');
    
    // Real-time character filtering and validation for role name
    roleNameInput.addEventListener('input', function() {
        if (!this.hasAttribute('readonly')) {
            roleNameTouched = true; // Mark as touched when user starts typing
        }
        const value = this.value;
        const pattern = /^[a-zA-Z0-9\s\-_]+$/;
        
        // Only filter if the field is not readonly
        if (!this.hasAttribute('readonly') && value && !pattern.test(value)) {
            this.value = value.replace(/[^a-zA-Z0-9\s\-_]/g, '');
        }
        updateCharacterCount(this, 50);
        validateFormRealTime(); // Check form validity
    });
    
    // Real-time character count for description
    descriptionTextarea.addEventListener('input', function() {
        descriptionTouched = true; // Mark as touched when user starts typing
        updateCharacterCount(this, 255);
        validateFormRealTime(); // Check form validity
    });
    
    // Character count display function
    function updateCharacterCount(element, maxLength) {
        const currentLength = element.value.length;
        const countDisplay = element.parentElement.querySelector('.char-count');
        
        if (countDisplay) {
            countDisplay.textContent = currentLength + '/' + maxLength + ' characters';
            
            if (currentLength > maxLength * 0.9) {
                countDisplay.className = 'char-count text-danger mt-1';
            } else if (currentLength > maxLength * 0.7) {
                countDisplay.className = 'char-count text-warning mt-1';
            } else {
                countDisplay.className = 'char-count text-muted mt-1';
            }
        }
    }
    
    // Track if user has interacted with fields
    let roleNameTouched = false;
    let descriptionTouched = false;
    
    // Real-time form validation and button state management
    function validateFormRealTime() {
        const roleName = roleNameInput.value.trim();
        const description = descriptionTextarea.value.trim();
        const submitBtn = form.querySelector('button[type="submit"]');
        const isReadonly = roleNameInput.hasAttribute('readonly');
        
        let isValid = true;
        
        // Validate role name (only if not readonly and user has interacted)
        if (!isReadonly) {
            if (!roleName || roleName.length < 2 || roleName.length > 50 || !/^[a-zA-Z0-9\s\-_]+$/.test(roleName)) {
                isValid = false;
                if (roleNameTouched) {
                    roleNameInput.classList.add('is-invalid');
                    roleNameInput.classList.remove('is-valid');
                }
            } else {
                if (roleNameTouched) {
                    roleNameInput.classList.add('is-valid');
                    roleNameInput.classList.remove('is-invalid');
                }
            }
        } else {
            // For readonly fields, always consider valid
            roleNameInput.classList.remove('is-invalid', 'is-valid');
        }
        
        // Validate description (optional but check length if provided)
        if (description && description.length > 255) {
            isValid = false;
            if (descriptionTouched) {
                descriptionTextarea.classList.add('is-invalid');
                descriptionTextarea.classList.remove('is-valid');
            }
        } else if (description) {
            if (descriptionTouched) {
                descriptionTextarea.classList.add('is-valid');
                descriptionTextarea.classList.remove('is-invalid');
            }
        } else {
            if (descriptionTouched) {
                descriptionTextarea.classList.remove('is-invalid', 'is-valid');
            }
        }
        
        // For readonly role names, always allow submission (admin roles)
        if (isReadonly) {
            isValid = true;
        }
        
        // Enable/disable submit button
        if (submitBtn) {
            submitBtn.disabled = !isValid;
            if (isValid) {
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-success');
            } else {
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-secondary');
            }
        }
        
        return isValid;
    }
    
    // Enhanced form validation
    form.addEventListener('submit', function(e) {
        const roleName = roleNameInput.value.trim();
        const description = descriptionTextarea.value.trim();
        
        let isValid = true;
        let errorMessage = '';
        
        // Validate role name (only if not readonly)
        if (!roleNameInput.hasAttribute('readonly')) {
            if (!roleName) {
                isValid = false;
                errorMessage += 'Role Name is required.\n';
            } else if (roleName.length < 2) {
                isValid = false;
                errorMessage += 'Role Name must be at least 2 characters long.\n';
            } else if (roleName.length > 50) {
                isValid = false;
                errorMessage += 'Role Name must be less than 50 characters.\n';
            } else if (!/^[a-zA-Z0-9\s\-_]+$/.test(roleName)) {
                isValid = false;
                errorMessage += 'Role Name contains invalid characters. Only letters, numbers, spaces, hyphens (-) and underscores (_) are allowed.\n';
            }
        }
        
        // Validate description (optional but if provided, check length)
        if (description && description.length > 255) {
            isValid = false;
            errorMessage += 'Description must be less than 255 characters.\n';
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n' + errorMessage);
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri-loader-2-line"></i> Updating Role...';
        }
    });
    
    // Fix Configure Menu button clearing form values
    const configureMenuBtn = document.querySelector('[data-bs-target="#offcanvasRight"]');
    if (configureMenuBtn) {
        configureMenuBtn.addEventListener('click', function(e) {
            // Store current form values before opening offcanvas
            const currentRoleName = roleNameInput.value;
            const currentDescription = descriptionTextarea.value;
            
            // Restore values after a short delay (after offcanvas opens)
            setTimeout(function() {
                if (roleNameInput.value !== currentRoleName) {
                    roleNameInput.value = currentRoleName;
                }
                if (descriptionTextarea.value !== currentDescription) {
                    descriptionTextarea.value = currentDescription;
                }
            }, 100);
        });
    }
    
    // Initialize character counts
    updateCharacterCount(roleNameInput, 50);
    updateCharacterCount(descriptionTextarea, 255);
    
    // Initial button state - for edit, if readonly field exists, enable button
    const submitBtn = form.querySelector('button[type="submit"]');
    const isReadonly = roleNameInput.hasAttribute('readonly');
    if (submitBtn) {
        if (isReadonly) {
            // For readonly roles (Admin, etc.), always enable the button
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-success');
        } else {
            // For editable roles, check if current values are valid
            const roleName = roleNameInput.value.trim();
            const isValid = roleName && roleName.length >= 2 && roleName.length <= 50 && /^[a-zA-Z0-9\s\-_]+$/.test(roleName);
            submitBtn.disabled = !isValid;
            if (isValid) {
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-success');
            } else {
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-secondary');
            }
        }
    }
});
</script>
                
            	<?php 
	 $menuConfigureCanvas = APPPATH . 'views/auth/MenuConfigureCanvas.php';
     include($menuConfigureCanvas);
     ?>
