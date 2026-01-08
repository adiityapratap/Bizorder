<div class="container-fluid" style="margin-top: 0 !important;">
   <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
           <form class="row needs-validation" novalidate action="<?php echo base_url("auth/create_group") ?>" method="post">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1 text-black">Add New Role</h4>
                                        <div class="flex-shrink-0">
                                            <a type="button" class="btn bg-orange add-btn" 
                                                id="create-btn" href="<?php echo base_url('auth/group_listing') ?>"><i
                                                    class="ri-arrow-go-back-fill align-bottom me-1"></i> Back
                                                </a>
                                              <button class="btn btn-success" type="submit">Submit </button>
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
                                                    <input type="text" name="group_name" class="form-control" id="group_name" required minlength="2" maxlength="50" pattern="^[a-zA-Z0-9\s\-_]+$" title="Only letters, numbers, spaces, hyphens and underscores are allowed">
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
                                                    <input type="text" name="displayName" class="form-control" id="displayName" >
                                                    <div class="valid-feedback"> Looks good! </div>
                                                    <div class="invalid-feedback">Please enter role display name.</div> 
                                                   
                                                </div>
                                        
                                        <div class="col-md-4">
                                                    <label for="description" class="form-label fw-semibold">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" maxlength="255" placeholder="Optional: Brief description of the role's responsibilities"></textarea>
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">Description must be less than 255 characters.</div>
                                                    <small class="text-muted">Optional field. Maximum 255 characters.</small>
                                                    <div class="char-count text-muted mt-1"></div>
                                                </div>
                                               
                                                
                                </div>       
        </div>
         </form>
                </div> 
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

<!-- Include Global Form Validation Script -->
<script src="<?php echo base_url('theme-assets/js/form-validation.js'); ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleNameInput = document.getElementById('group_name');
    const descriptionTextarea = document.getElementById('description');
    const form = document.querySelector('form');
    
    // Real-time validation for role name
    roleNameInput.addEventListener('input', function() {
        roleNameTouched = true; // Mark as touched when user starts typing
        const value = this.value;
        const pattern = /^[a-zA-Z0-9\s\-_]+$/;
        
        // Remove invalid characters as user types
        if (value && !pattern.test(value)) {
            this.value = value.replace(/[^a-zA-Z0-9\s\-_]/g, '');
        }
        
        // Show character count
        updateCharacterCount(this, 50);
        validateFormRealTime(); // Check form validity
    });
    
    // Character count for description
    descriptionTextarea.addEventListener('input', function() {
        descriptionTouched = true; // Mark as touched when user starts typing
        updateCharacterCount(this, 255);
        validateFormRealTime(); // Check form validity
    });
    
    function updateCharacterCount(element, maxLength) {
        const currentLength = element.value.length;
        const remaining = maxLength - currentLength;
        
        // Find or create character count display
        let countDisplay = element.parentNode.querySelector('.char-count');
        if (!countDisplay) {
            countDisplay = document.createElement('small');
            countDisplay.className = 'char-count text-muted';
            element.parentNode.appendChild(countDisplay);
        }
        
        countDisplay.textContent = `${currentLength}/${maxLength} characters`;
        
        // Change color based on remaining characters
        if (remaining < 10) {
            countDisplay.className = 'char-count text-warning';
        } else if (remaining < 0) {
            countDisplay.className = 'char-count text-danger';
        } else {
            countDisplay.className = 'char-count text-muted';
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
        
        let isValid = true;
        
        // Validate role name (only show validation if user has interacted)
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
        
        // Validate role name
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
            submitBtn.innerHTML = '<i class="ri-loader-2-line"></i> Creating Role...';
        }
    });
    
    // Initialize character counts and form validation
    updateCharacterCount(roleNameInput, 50);
    updateCharacterCount(descriptionTextarea, 255);
    
    // Initial button state (disabled until valid input)
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.remove('btn-success');
        submitBtn.classList.add('btn-secondary');
    }
});
</script>
                
            	<?php 
	 $menuConfigureCanvas = APPPATH . 'views/auth/MenuConfigureCanvas.php';
     include($menuConfigureCanvas);
     ?>
