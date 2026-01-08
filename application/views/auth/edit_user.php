<div class="container-fluid" style="margin-top: 0 !important;">
   <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Edit User</h4>
                                        <div class="flex-shrink-0">
                                            <a type="button" class="btn bg-orange add-btn" 
                                                id="create-btn" href="<?php echo base_url('auth/userListing') ?>"><i
                                                    class="ri-arrow-go-back-fill align-bottom me-1"></i> Back
                                                </a>
                                            <button class="btn btn-success" type="button" onclick="document.getElementById('editUserForm').submit()">
                                                 <span class="icon-on"><i class="ri-folder-user-line align-bottom me-1"></i> Update</span>
                                                 </button>   
                                           <button type="button" class="btn btn-secondary custom-toggle active" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
    <span class="icon-on"><i class="ri-add-line align-bottom me-1"></i> Configure Menu</span>
     
    <span class="icon-off"><i class="ri-user-unfollow-line align-bottom me-1"></i> Configure Menu</span>
</button>          
                                        </div>
                                    </div><!-- end card header -->
        
        
        <div class="card-body mt-2">
        <div id="infoMessage" class="mb-3"><?php echo $message;?></div>
        <div class="col-md-12 col-sm-4">
             <form class="row g-3 needs-validation" id="editUserForm" novalidate action="<?php echo base_url("auth/edit_user/".$user->id) ?>" method="post">
                 <input type="hidden" class="user_id_being_edited" value="<?php echo $user->id; ?>">
                             <div class="row row-inner mb-3">
                                     <div class="col-md-4">
                                                    <label for="first_name" class="form-label fw-semibold required">Full Name</label>
                                                    <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo (isset($first_name) ? $first_name : '') ?>" required minlength="2" maxlength="100">
                                                    <div class="valid-feedback">Looks good!</div>
                                                    <div class="invalid-feedback">Please enter a valid full name (2-100 characters).</div>
                                                </div>
                                        <div class="col-md-4">
                                                    <label for="email" class="form-label fw-semibold required">Email</label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo (isset($email) ? $email : '') ?>" aria-describedby="inputGroupPrepend" required maxlength="255">
                                                    <div class="valid-feedback">Looks good!</div>
                                                     <div class="invalid-feedback">Please enter a valid email address.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="username" class="form-label fw-semibold required">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo (isset($username) ? $username : '') ?>" required minlength="3" maxlength="50" pattern="[a-zA-Z0-9_]+">
                                                   <div class="invalid-feedback">Please enter a unique username (3-50 characters, letters, numbers, underscore only).</div> 
                                                </div>
                                                
                                </div>       
                                         <div class="row row-inner mb-3">       
                                                <div class="col-md-4">
                                                   
                                                <label class="form-label fw-semibold" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup has-validation">
                                                    <input type="password" name="password" class="form-control pe-5" placeholder="Leave blank to keep current password" id="password-input" minlength="8" maxlength="50" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]" title="Password must contain: at least 8 characters, one uppercase letter (A-Z), one lowercase letter (a-z), one number (0-9), and one special character (@$!%*?&)">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                 <div class="valid-feedback">Strong password!</div>
                                               <div class="invalid-feedback">Password must contain: at least 8 characters, one uppercase (A-Z), one lowercase (a-z), one number (0-9), and one special character (@$!%*?&).</div>
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="ri-information-line"></i> <strong>Requirements:</strong> 8+ characters, uppercase, lowercase, number, and special character (@$!%*?&). Leave blank to keep current password.
                                                </small>
                                            </div>
                                            
                                            <div class="col-md-4" id="pin-field" style="display: none;">
                                                <label class="form-label fw-semibold" for="pin-input">PIN <span class="text-danger">*</span></label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="text" name="pin" class="form-control pe-5" placeholder="Enter 4-digit PIN" id="pin-input" maxlength="4" pattern="[0-9]{4}" value="<?php echo isset($user->pin) && $user->pin != '' ? htmlspecialchars($user->pin) : '1234'; ?>">
                                                    <div class="invalid-feedback">Please enter a valid 4-digit PIN.</div>
                                                </div>
                                                <small class="text-muted">4-digit PIN for order verification (default: 1234)</small>
                                            </div>
                                            
                                            
                                             <div class="col-md-3">
                                                    <label for="role_id" class="form-label fw-semibold">User Default location</label>
                                                    <select class="form-select" id="default_location_id" name="default_location_id" required>
                                                        <option   value="">Select Default Location</option>
                                                        <?php if(!empty($locations)) {  ?>
                                                        <?php  foreach ($locations as $location) {  ?>
        <option <?php echo ($default_location_id == $location['location_id']) ? 'selected="selected"' : null; ?> value="<?php echo  $location['location_id']; ?>"><?php echo $location['location_name'] ?></option>
                                                        <?php  } ?>
                                                        <?php  } ?>
                                                    </select>
                                            <div class="invalid-feedback">Please select a valid location.</div>
                                                        
                                                </div>   
            <?php if ($this->ion_auth->is_admin()): ?>
             <div class="col-md-3">
            <label for="role_id" class="form-label fw-semibold">Roles</label>
         <select class="form-select" id="role_id" name="role_id" required>
         <?php foreach ($groups as $group):?>
  <option value="<?php echo $group['id'];?>" <?php echo ($group['id'] == (isset($currentGroups[0]['id']) ? $currentGroups[0]['id'] : 0)) ? 'selected="selected"' : null; ?>  value="1"><?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?></option>
         <?php endforeach?>
          </select>
           <div class="invalid-feedback">Please select a valid role.</div>
        </div> 
        
         <div class="col-md-3">
                                                    <label for="department_id" class="form-label fw-semibold">Floor</label>
                                                    <select class="form-select" id="department_id" name="department_id" >
                                                        <option <?php echo ($department_id == 0) ? 'selected="selected"' : null; ?>  value="0">All Floors</option>
                                                        <?php if(!empty($departmentListData)) {  ?>
                                                        <?php  foreach ($departmentListData as $department) {  ?>
                                                        <option value="<?php echo  $department['id']; ?>" <?php echo ($department['id'] == $department_id) ? 'selected="selected"' : null; ?>><?php echo $department['name'] ?></option>
                                                        <?php  } ?>
                                                        <?php  } ?>
                                                    </select>
                                            <div class="invalid-feedback">Please select a valid department for nurse.</div>
                                                        
                                                </div>   
     <?php endif ?>
                          </div>
                 <div class="row row-inner mb-3">
                     
                  <?php if(!empty($locations)){  ?>   
                              <div class="col-lg-6">
                                            <h6 class="fw-semibold text-black">Location Access *</h6>
                                            <select class="js-example-basic-multiple" name="locationIds[]" multiple="multiple">
                                               <?php foreach($locations as $location){ ?>
                                               <?php if(in_array((int)$location['location_id'],$selected_location_ids)) { ?>
                                                 <option value="<?php echo $location['location_id']; ?> "  selected="selected"> <?php echo $location['location_name']; ?> </option>
                                                  <?php }else { ?>
                                                <option value="<?php echo $location['location_id']; ?> "> <?php echo $location['location_name']; ?>   </option>   
                                                   <?php } ?>
                                                  <?php } ?>
                                            </select>
                                        <small> click in the box to view and select multiple locations</small>    
                                        </div>
                                           <?php } ?> 
                                           
                                             <?php if(!empty($prepAreas)){  ?>   
                              <div class="col-lg-6">
                                            <h6 class="fw-semibold text-black">Prep Areas </h6>
                                            
                                            <select class="js-example-basic-multiple" name="prepIds[]" multiple="multiple">
                                               <?php foreach($prepAreas as $prepArea){ ?>     
                                               <?php if(in_array((int)$prepArea['id'],$selected_prep_ids)) { ?>
                                                 <option value="<?php echo $prepArea['id']; ?> "  selected="selected"> <?php echo $prepArea['prep_name']; ?> </option>
                                                  <?php }else { ?>
                                                <option value="<?php echo $prepArea['id']; ?> "> <?php echo $prepArea['prep_name']; ?>   </option>   
                                                   <?php } ?>
                                                  <?php } ?>
                                            </select>
                                            
     <small>In case of timesheet user, please select the prep areas this timesheet user will see after login,so that employee can click on that prep area to clockin their time</small>    
                                        </div>
                                           <?php } ?>
                                           
                             <?php if(!empty($system_details)){  $i =0 ?>   
                              <div class="col-lg-6">
                                            <h6 class="fw-semibold text-black">System Access *</h6>
                                            <select class="js-example-basic-multiple" name="systemIds[]" multiple="multiple">
                                               <?php foreach($system_details as $system){ ?>
                                                <?php if(in_array($system['system_id'],$selected_system_ids)) { ?>
                                                 <option value="<?php echo $system['system_id']; ?>" selected="selected"><?php echo $system['system_name']; ?> </option>
                                                    <?php }else { ?>
                                    <option value="<?php echo $system['system_id']; ?>"><?php echo $system['system_name']; ?> </option>
                                                       <?php } ?>
                                                  <?php } ?>
                                            </select>
                                 <small> click in the box to view and select multiple systems</small>    
                                  </div>
                                           <?php } ?> 
        
                     </div>
                    
                      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?> 
                      </form>
                </div> 
        </div>
                </div> 
                </div>
                </div>
                </div>

<!-- Include Global Form Validation Script -->
<script src="<?php echo base_url('theme-assets/js/form-validation.js'); ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    const pinField = document.getElementById('pin-field');
    const pinInput = document.getElementById('pin-input');
    
    // Function to toggle PIN field visibility
    function togglePinField() {
        const selectedRole = roleSelect.value;
        // Role ID 3 is for Nurse
        if (selectedRole === '3') {
            pinField.style.display = 'block';
            pinInput.required = true;
            // Set default value if empty
            if (!pinInput.value || pinInput.value.trim() === '') {
                pinInput.value = '1234';
            }
        } else {
            pinField.style.display = 'none';
            pinInput.required = false;
            pinInput.value = ''; // Clear PIN for non-nurses
        }
    }
    
    // Initial check when page loads
    togglePinField();
    
    // Listen for role changes
    roleSelect.addEventListener('change', togglePinField);
    
    // PIN input validation - only allow numbers
    pinInput.addEventListener('keypress', function(e) {
        // Allow only numbers
        if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Enter'].includes(e.key)) {
            e.preventDefault();
        }
    });
    
    // PIN input validation - ensure 4 digits
    pinInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, ''); // Remove non-digits
        if (value.length > 4) {
            value = value.slice(0, 4); // Limit to 4 digits
        }
        e.target.value = value;
    });
    
    // Password strength indicator with custom validation message
    const passwordInput = document.getElementById('password-input');
    if (passwordInput) {
        // Set custom validation message
        passwordInput.addEventListener('invalid', function() {
            if (this.validity.patternMismatch) {
                this.setCustomValidity('Password must contain: at least 8 characters, one uppercase letter (A-Z), one lowercase letter (a-z), one number (0-9), and one special character (@$!%*?&)');
            } else if (this.validity.tooShort) {
                this.setCustomValidity('Password must be at least 8 characters long');
            } else if (this.validity.valueMissing) {
                this.setCustomValidity('Please enter a password');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Clear custom message and validate on input
        passwordInput.addEventListener('input', function() {
            this.setCustomValidity('');
            
            const password = this.value;
            
            // If empty, remove validation classes (password is optional in edit)
            if (password.length === 0) {
                this.classList.remove('is-valid', 'is-invalid');
                return;
            }
            
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);
            const isLongEnough = password.length >= 8;
            
            if (hasUpper && hasLower && hasNumber && hasSpecial && isLongEnough) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    }
});
</script>
                
            	<?php 
	 $menuConfigureCanvas = APPPATH . 'views/auth/MenuConfigureCanvas.php';
     include($menuConfigureCanvas);
     ?>    
        <!--js used for this page is in "login-assets/js/custom.js"      -->
