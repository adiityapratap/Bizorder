/**
 * Global Form Validation System
 * Handles validation for all forms across the application
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Form validation system initialized');
    
    // Initialize validation for all forms
    initializeAllFormValidation();
    
    // Initialize modal form validation
    initializeModalValidation();
});

function initializeAllFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Skip if already initialized
        if (form.hasAttribute('data-validation-initialized')) return;
        form.setAttribute('data-validation-initialized', 'true');
        
        console.log('Initializing form validation for:', form.id || 'unnamed form');
        
        // Add Bootstrap validation classes
        if (!form.classList.contains('needs-validation')) {
            form.classList.add('needs-validation');
        }
        form.setAttribute('novalidate', '');
        
        // Get all form inputs
        const inputs = form.querySelectorAll('input, select, textarea');
        
        // Add real-time validation to each input
        inputs.forEach(input => {
            // Track if user has interacted with this field
            let hasUserInteracted = false;
            
            // Mark as interacted when user starts typing or focuses
            input.addEventListener('focus', function() {
                hasUserInteracted = true;
                this.setAttribute('data-user-interacted', 'true');
            });
            
            input.addEventListener('input', function() {
                hasUserInteracted = true;
                this.setAttribute('data-user-interacted', 'true');
                
                // Only validate if user has interacted
                if (hasUserInteracted) {
                    validateField(this);
                }
            });
            
            input.addEventListener('blur', function() {
                // Only validate on blur if user has interacted with the field
                if (hasUserInteracted || this.hasAttribute('data-user-interacted')) {
                    validateField(this);
                }
            });
            
            input.addEventListener('change', function() {
                hasUserInteracted = true;
                this.setAttribute('data-user-interacted', 'true');
                validateField(this);
            });
        });
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Form submission attempted');
            
            if (validateForm(form)) {
                console.log('Form validation passed');
                
                // Add loading state to submit button
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;
                    
                    // Re-enable after 10 seconds as fallback
                    setTimeout(() => {
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                    }, 10000);
                }
                
                // Submit the form
                form.classList.add('was-validated');
                
                // For AJAX forms, prevent actual submission
                if (form.hasAttribute('data-ajax-form')) {
                    console.log('AJAX form detected, preventing default submission');
                    return false;
                } else {
                    // Allow normal form submission
                    form.removeEventListener('submit', arguments.callee);
                    form.submit();
                }
            } else {
                console.log('Form validation failed');
                form.classList.add('was-validated');
                
                // Focus on first invalid field
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
}

function initializeModalValidation() {
    // Handle modal forms specifically
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const form = this.querySelector('form');
            if (form && !form.hasAttribute('data-validation-initialized')) {
                console.log('Initializing modal form validation');
                initializeAllFormValidation();
            }
        });
    });
}

function validateField(field, forceValidation = false) {
    const value = field.value.trim();
    const fieldType = field.type;
    const isRequired = field.hasAttribute('required');
    const hasUserInteracted = field.hasAttribute('data-user-interacted') || forceValidation;
    
    // Don't show any validation messages if user hasn't interacted yet
    if (!hasUserInteracted && !forceValidation) {
        return true; // Assume valid until user interacts
    }
    
    // Remove existing validation classes
    field.classList.remove('is-valid', 'is-invalid');
    field.parentNode.classList.remove('has-error');
    
    // Hide all feedback messages first
    const feedbacks = field.parentNode.querySelectorAll('.invalid-feedback, .valid-feedback');
    feedbacks.forEach(feedback => {
        feedback.style.display = 'none';
        feedback.classList.remove('d-block', 'show');
    });
    
    // If field is empty and user just started interacting, don't show errors yet
    if (!value && !forceValidation) {
        return true;
    }
    
    let isValid = true;
    let errorMessage = '';
    
    // Check required fields - only show error if user has entered something and then cleared it, or on form submission
    if (isRequired && !value && (forceValidation || field.hasAttribute('data-had-value'))) {
        isValid = false;
        errorMessage = 'This field is required.';
    }
    // Email validation - only validate if there's a value
    else if (fieldType === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }
    }
    // Number validation - only validate if there's a value
    else if (fieldType === 'number' && value) {
        const num = parseFloat(value);
        const min = field.getAttribute('min');
        const max = field.getAttribute('max');
        
        if (isNaN(num)) {
            isValid = false;
            errorMessage = 'Please enter a valid number.';
        } else if (min !== null && num < parseFloat(min)) {
            isValid = false;
            errorMessage = `Value must be at least ${min}.`;
        } else if (max !== null && num > parseFloat(max)) {
            isValid = false;
            errorMessage = `Value must be no more than ${max}.`;
        }
    }
    // Pattern validation - only validate if there's a value
    else if (field.hasAttribute('pattern') && value) {
        const pattern = new RegExp(field.getAttribute('pattern'));
        if (!pattern.test(value)) {
            isValid = false;
            errorMessage = field.getAttribute('title') || 'Please match the requested format.';
        }
    }
    // Length validation - only validate if there's a value
    else if (value) {
        const minLength = field.getAttribute('minlength');
        const maxLength = field.getAttribute('maxlength');
        
        if (minLength && value.length < parseInt(minLength)) {
            isValid = false;
            errorMessage = `Must be at least ${minLength} characters long.`;
        } else if (maxLength && value.length > parseInt(maxLength)) {
            isValid = false;
            errorMessage = `Must be no more than ${maxLength} characters long.`;
        }
    }
    // Select validation - only show error if user has interacted or on form submission
    else if (field.tagName === 'SELECT' && isRequired && !value && (forceValidation || hasUserInteracted)) {
        isValid = false;
        errorMessage = 'Please select an option.';
    }
    
    // Track if field has had a value (for required field validation)
    if (value) {
        field.setAttribute('data-had-value', 'true');
    }
    
    // Apply validation state - ONLY show red error messages, never success messages
    if (!isValid && hasUserInteracted) {
        // Field is invalid and user has interacted - show RED ERROR ONLY
        field.classList.add('is-invalid');
        field.parentNode.classList.add('has-error');
        
        let invalidFeedback = field.parentNode.querySelector('.invalid-feedback');
        if (!invalidFeedback) {
            // Create error message if it doesn't exist
            invalidFeedback = document.createElement('div');
            invalidFeedback.className = 'invalid-feedback';
            field.parentNode.appendChild(invalidFeedback);
        }
        
        invalidFeedback.textContent = errorMessage;
        invalidFeedback.style.display = 'block';
        invalidFeedback.classList.add('d-block', 'show');
        
        console.log('Field validation failed:', field.name || field.id, errorMessage);
    } else {
        // Field is valid OR user hasn't interacted - CLEAR ALL MESSAGES (no success messages)
        field.classList.remove('is-valid', 'is-invalid');
        field.parentNode.classList.remove('has-error');
        
        // Hide ALL feedback messages (both error and success)
        feedbacks.forEach(feedback => {
            feedback.style.display = 'none';
            feedback.classList.remove('d-block', 'show');
        });
    }
    
    return isValid;
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    let formIsValid = true;
    
    console.log('Validating form with', inputs.length, 'fields');
    
    // Force validation on all fields during form submission
    inputs.forEach(input => {
        if (!validateField(input, true)) { // Force validation = true
            formIsValid = false;
        }
    });
    
    return formIsValid;
}

// Special validation for password strength
function validatePassword(passwordField) {
    const password = passwordField.value;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[@$!%*?&]/.test(password)
    };
    
    const isStrong = Object.values(requirements).every(req => req);
    
    if (password.length === 0) {
        passwordField.classList.remove('is-valid', 'is-invalid');
        return true; // Allow empty if not required
    }
    
    if (isStrong) {
        // Password is strong - CLEAR ALL MESSAGES (no success message)
        passwordField.classList.remove('is-invalid', 'is-valid');
        passwordField.parentNode.classList.remove('has-error');
        
        // Hide ALL feedback messages
        const allFeedbacks = passwordField.parentNode.querySelectorAll('.invalid-feedback, .valid-feedback');
        allFeedbacks.forEach(feedback => {
            feedback.style.display = 'none';
            feedback.classList.remove('d-block', 'show');
        });
        
        return true;
    } else {
        // Password is weak - SHOW RED ERROR ONLY
        passwordField.classList.remove('is-valid');
        passwordField.classList.add('is-invalid');
        passwordField.parentNode.classList.add('has-error');
        
        const invalidFeedback = passwordField.parentNode.querySelector('.invalid-feedback');
        if (invalidFeedback) {
            invalidFeedback.style.display = 'block';
            invalidFeedback.classList.add('d-block', 'show');
        }
        
        // Ensure no success messages show
        const validFeedback = passwordField.parentNode.querySelector('.valid-feedback');
        if (validFeedback) {
            validFeedback.style.display = 'none';
            validFeedback.classList.remove('d-block', 'show');
        }
        
        return false;
    }
}

// Initialize password validation for password fields
document.addEventListener('DOMContentLoaded', function() {
    const passwordFields = document.querySelectorAll('input[type="password"]');
    passwordFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.hasAttribute('pattern') && this.getAttribute('pattern').includes('(?=.*[a-z])')) {
                validatePassword(this);
            }
        });
    });
});

// Utility function to show custom error message
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.parentNode.classList.add('has-error');
    
    let invalidFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (!invalidFeedback) {
        invalidFeedback = document.createElement('div');
        invalidFeedback.className = 'invalid-feedback';
        field.parentNode.appendChild(invalidFeedback);
    }
    
    invalidFeedback.textContent = message;
    invalidFeedback.style.display = 'block';
    invalidFeedback.classList.add('d-block', 'show');
}

// Utility function to clear field error
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    field.parentNode.classList.remove('has-error');
    
    const invalidFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (invalidFeedback) {
        invalidFeedback.style.display = 'none';
        invalidFeedback.classList.remove('d-block', 'show');
    }
}

// Form clearing functionality
function clearForm(form) {
    console.log('Clearing form:', form.id || 'unnamed form');
    
    // Clear all input values
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.type === 'hidden') return; // Don't clear hidden inputs
        
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0; // Reset to first option
        } else {
            input.value = '';
        }
        
        // Clear validation states
        input.classList.remove('is-valid', 'is-invalid');
        
        // Clear interaction tracking
        input.removeAttribute('data-user-interacted');
        input.removeAttribute('data-had-value');
        
        // Clear parent validation states
        input.parentNode.classList.remove('has-error');
    });
    
    // Hide all validation messages
    const feedbacks = form.querySelectorAll('.invalid-feedback, .valid-feedback');
    feedbacks.forEach(feedback => {
        feedback.style.display = 'none';
        feedback.classList.remove('d-block', 'show');
    });
    
    // Remove form validation classes
    form.classList.remove('was-validated');
    
    console.log('Form cleared successfully');
}

function clearModal(modal) {
    console.log('Clearing modal:', modal.id || 'unnamed modal');
    
    const form = modal.querySelector('form');
    if (form) {
        clearForm(form);
    }
}

// Initialize modal clearing functionality
function initializeModalClearing() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        // Clear on modal hide
        modal.addEventListener('hidden.bs.modal', function() {
            clearModal(this);
        });
        
        // Clear on close button click
        const closeButtons = modal.querySelectorAll('.btn-close, [data-bs-dismiss="modal"]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                setTimeout(() => {
                    clearModal(modal);
                }, 100); // Small delay to ensure modal is closing
            });
        });
    });
}

// Initialize form reset functionality
function initializeFormReset() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Clear on reset
        form.addEventListener('reset', function() {
            setTimeout(() => {
                clearForm(this);
            }, 50); // Small delay to allow reset to complete
        });
        
        // Add reset functionality to cancel/back buttons
        const cancelButtons = form.querySelectorAll('.btn-light, .btn-secondary, [href*="back"], [href*="listing"]');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                clearForm(form);
            });
        });
    });
}

// Enhanced initialization
document.addEventListener('DOMContentLoaded', function() {
    console.log('Enhanced form validation system initialized');
    
    // Initialize all functionality
    initializeAllFormValidation();
    initializeModalValidation();
    initializeModalClearing();
    initializeFormReset();
    
    // Initialize on dynamic content
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check if new modals were added
                        if (node.classList && node.classList.contains('modal')) {
                            initializeModalClearing();
                        }
                        // Check if new forms were added
                        if (node.tagName === 'FORM' || node.querySelector('form')) {
                            initializeAllFormValidation();
                            initializeFormReset();
                        }
                    }
                });
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

// Export functions for global use
window.FormValidation = {
    validateField,
    validateForm,
    validatePassword,
    showFieldError,
    clearFieldError,
    clearForm,
    clearModal,
    initializeAllFormValidation
};
