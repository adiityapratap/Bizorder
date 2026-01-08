<style>

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

/* Enhanced form validation styling */
.form-group {
    position: relative;
}

/* Required asterisk styling */
.text-red-500 {
    color: #ef4444 !important;
    font-weight: bold;
}

/* Error message styling */
.error-message {
    font-size: 0.75rem;
    margin-top: 0.25rem;
    color: #ef4444 !important;
    font-weight: 500;
}

/* Force red color on all error messages - Multiple selectors for maximum specificity */
.error-message,
.error-message *,
div.error-message,
div[id="name-error"],
div[id="description-error"],
div[id="nutrition-error"] {
    color: #ef4444 !important;
    background: transparent !important;
}

/* Override any text color classes */
.text-red-500,
.text-danger,
div[id*="-error"] {
    color: #ef4444 !important;
}

/* Ultra-specific selectors to override Bootstrap/Tailwind */
div#name-error.error-message,
div#description-error.error-message,
div#nutrition-error.error-message {
    color: #ef4444 !important;
    font-weight: 500 !important;
}

/* Override any inherited text colors */
.form-group .error-message,
.form-group div[id*="-error"] {
    color: #ef4444 !important;
}

/* Input field error state */
.border-red-500 {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 1px #ef4444 !important;
}

/* Input field focus state when valid */
input:focus:not(.border-red-500),
textarea:focus:not(.border-red-500) {
    border-color: #10b981;
    box-shadow: 0 0 0 1px #10b981;
}

/* Success state for valid fields */
.border-green-500 {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 1px #10b981 !important;
}

/* Smooth transitions */
input, textarea, select {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

/* Hide error messages by default */
.error-message.hidden {
    display: none !important;
}

/* Show error messages when needed */
.error-message:not(.hidden) {
    display: block !important;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
<main class="container mx-auto px-4 flex-grow mb-8">
    <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600"></div>
    </div>
    <div id="form-container" class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-primary p-4 text-white">
            <h2 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($title); ?></h2>
            <p class="text-sm text-white">Fill in the details below</p>
        </div>
        <?php $menuOptionId =  isset($menu_option['id']) ? '/'.htmlspecialchars($menu_option['id']) : ''; ?>
            <form id="menu-option-form" action="<?php echo site_url('Orderportal/Configfoodmenu/manage_menu_option'.$menuOptionId); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($menu_option['id']) ? htmlspecialchars($menu_option['id']) : ''; ?>">
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div id="name-field" class="form-group">
                    <label for="menu_option_name" class="block text-sm text-gray-600 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" id="menu_option_name" name="menu_option_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                           value="<?php echo set_value('menu_option_name', isset($menu_option['menu_option_name']) ? htmlspecialchars($menu_option['menu_option_name']) : ''); ?>" placeholder="Enter menu option name">
                    <div id="name-error" class="error-message hidden text-red-500 text-xs mt-1" style="color: #ef4444 !important;">Name is required</div>
                </div>
                
               
                 <!-- Cuisine Types Dropdown (Multiple Selection) -->
                 <div id="cuisine-field" class="form-group relative">
                                                <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine Types</label>
                                                
                                                <?php 
                                                $selected_cuisines = [];
                                                if (!empty($menu_option['cuisineValues'])) {
                                                    $selected_cuisines = is_array(json_decode($menu_option['cuisineValues'], true)) 
                                                        ? json_decode($menu_option['cuisineValues'], true) 
                                                        : (is_numeric($menu_option['cuisineValues']) ? [$menu_option['cuisineValues']] : []);
                                                } elseif (!empty($menu_option['cuisine'])) {
                                                    // Support legacy single cuisine field
                                                    $selected_cuisines = is_numeric($menu_option['cuisine']) ? [$menu_option['cuisine']] : [];
                                                }
                                                ?>

                                                <!-- Dropdown trigger -->
                                                <button type="button" id="cuisineDropdownBtn" 
                                                    class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    <span id="cuisineSelectedText" class="text-gray-700 text-sm">
                                                        <?= !empty($selected_cuisines) ? count($selected_cuisines) . " selected" : "Select Cuisine Types" ?>
                                                    </span>
                                                    <i class="fa-solid fa-chevron-down text-gray-500 ml-2"></i>
                                                </button>

                                                <!-- Dropdown menu -->
                                                <div id="cuisineDropdown" class="absolute hidden mt-1 w-full max-h-48 overflow-y-auto border border-gray-300 rounded-lg bg-white shadow-lg" style="z-index: 999;">
                                                    <?php foreach ($cuisines as $cuisine): ?>
                                                        <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                            <input 
                                                                type="checkbox" 
                                                                name="cuisines[]" 
                                                                value="<?= $cuisine['id'] ?>" 
                                                                class="form-checkbox h-4 w-4 text-primary-600"
                                                                <?= in_array($cuisine['id'], $selected_cuisines) ? 'checked' : '' ?>
                                                            >
                                                            <span class="ml-2 text-gray-700 text-sm"><?= $cuisine['name'] ?></span>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            
    <?php 
    $selected_allergies = [];
    if (!empty($menu_option['allergenValues'])) {
        $selected_allergies = is_array(json_decode($menu_option['allergenValues'], true)) 
            ? json_decode($menu_option['allergenValues'], true) 
            : explode(',', $menu_option['allergenValues']);
    }
    ?>
                                            
                 <button type="button" id="allergiesDropdownBtn" 
        class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        <span id="allergiesSelectedText" class="text-gray-700 text-sm">
            <?= !empty($selected_allergies) ? count($selected_allergies) . " selected" : "Select Allergies" ?>
        </span>
        <i class="fa-solid fa-chevron-down text-gray-500 ml-2"></i>
    </button>

    <!-- Dropdown menu -->
    <div id="allergiesDropdown"  class="absolute hidden mt-1 w-25 max-h-48 overflow-y-auto border border-gray-300 rounded-lg bg-white shadow-lg" style="z-index: 999;">
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
                            
                
                <div id="nutritionValues-field" class="form-group">
                    <label for="nutritionValues" class="block text-sm text-gray-600 mb-1">Nutrition Values <span class="text-red-500">*</span></label>
                    <input type="text" id="nutritionValues" name="nutritionValues" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                           value="<?php echo set_value('nutritionValues', isset($menu_option['nutritionValues']) ? htmlspecialchars($menu_option['nutritionValues']) : ''); ?>" placeholder="Enter Nutrition Values">
                    <div id="nutrition-error" class="error-message hidden text-red-500 text-xs mt-1" style="color: #ef4444 !important;">Nutrition values are required</div>
                </div>
                
                <div id="description-field" class="form-group">
                    <label for="description" class="block text-sm text-gray-600 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" 
                             placeholder="Enter description" ><?php echo set_value('description', isset($menu_option['description']) ? htmlspecialchars($menu_option['description']) : ''); ?></textarea>
                    <div id="description-error" class="error-message hidden text-red-500 text-xs mt-1" style="color: #ef4444 !important;">Description is required</div>
                </div>
                
            </div>
            
            <!-- 🆕 SPECIAL ITEMS FEATURE -->
            <div class="mt-6 p-4 bg-orange-50 border-2 border-orange-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex items-center h-5 mt-1">
                        <input 
                            id="is_special_item" 
                            name="is_special_item" 
                            type="checkbox" 
                            value="1"
                            <?php echo (isset($menu_option['is_special_item']) && $menu_option['is_special_item'] == 1) ? 'checked' : ''; ?>
                            class="w-5 h-5 text-orange-600 bg-white border-orange-300 rounded focus:ring-orange-500 focus:ring-2 cursor-pointer">
                    </div>
                    <div class="ml-3">
                        <label for="is_special_item" class="font-medium text-gray-900 cursor-pointer">
                            <i class="fa-solid fa-star text-orange-500"></i> Mark as Special Item
                        </label>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="fa-solid fa-info-circle text-orange-500"></i> 
                            Special items are <strong>ONLY visible to patients with 3 or more allergies</strong>
                        </p>
                        <div class="mt-2 text-xs text-gray-500 bg-white p-2 rounded border border-orange-200">
                            <div class="flex items-center mb-1">
                                <i class="fa-solid fa-check-circle text-green-500 mr-2"></i>
                                <span>Use this for: Gluten-free, Dairy-free, or other allergen-safe alternatives</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fa-solid fa-exclamation-triangle text-orange-500 mr-2"></i>
                                <span>Patients with less than 3 allergies will NOT see this item</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="form-buttons" class="flex justify-between mt-8">
                <a href="<?php echo site_url('Orderportal/Configfoodmenu/menu_options'); ?>"><button type="button" id="back-button" class="px-6 py-2 border-2 border-red-500 text-danger rounded-lg flex items-center hover:bg-red-50 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </button></a>
                <button type="submit" id="submit-button" class="px-6 py-2 bg-green-600 text-white rounded-lg flex items-center hover:bg-green-700 transition-colors">
                    Submit <i class="fa-solid fa-check ml-2"></i>
                </button>
            </div>
        </div>
        </form>
    </div>
</main>
 </div>
    </div>
      </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('menu-option-form');
    const submitButton = document.getElementById('submit-button');
    const loader = document.getElementById('loader');

    // Form fields and their error elements
    const fields = {
        'menu_option_name': {
            element: document.getElementById('menu_option_name'),
            error: document.getElementById('name-error'),
            required: true
        },
        'nutritionValues': {
            element: document.getElementById('nutritionValues'),
            error: document.getElementById('nutrition-error'),
            required: true
        },
        'description': {
            element: document.getElementById('description'),
            error: document.getElementById('description-error'),
            required: true
        }
    };

    // Function to show error
    function showError(fieldName) {
        const field = fields[fieldName];
        field.element.classList.add('border-red-500');
        field.element.classList.remove('border-gray-300');
        field.error.classList.remove('hidden');
    }

    // Function to hide error
    function hideError(fieldName) {
        const field = fields[fieldName];
        field.element.classList.remove('border-red-500');
        field.element.classList.add('border-gray-300');
        field.error.classList.add('hidden');
    }

    // Function to validate field
    function validateField(fieldName) {
        const field = fields[fieldName];
        const value = field.element.value.trim();
        
        if (field.required && value === '') {
            // Reset to original required message
            if (fieldName === 'menu_option_name') {
                field.error.textContent = 'Name is required';
            } else if (fieldName === 'nutritionValues') {
                field.error.textContent = 'Nutrition values are required';
            } else if (fieldName === 'description') {
                field.error.textContent = 'Description is required';
            }
            showError(fieldName);
            return false;
        } else {
            hideError(fieldName);
            return true;
        }
    }

    // Add real-time validation to each field
    Object.keys(fields).forEach(fieldName => {
        const field = fields[fieldName];
        
        // Validate on blur (when user leaves field)
        field.element.addEventListener('blur', function() {
            if (this.value.trim() !== '' || this.dataset.touched === 'true') {
                validateField(fieldName);
            }
        });
        
        // Validate on input (as user types) - but only after they've interacted
        field.element.addEventListener('input', function() {
            this.dataset.touched = 'true';
            // Always validate if user has interacted with field
            validateField(fieldName);
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        let isValid = true;
        Object.keys(fields).forEach(fieldName => {
            if (!validateField(fieldName)) {
                isValid = false;
            }
        });

        if (isValid) {
            loader.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            
            setTimeout(() => {
                form.submit();
            }, 200);
        } else {
            // Scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});
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
                selectedText.textContent = checked > 0 ? checked + " selected" : "Select Allergies";
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add("hidden");
            }
        });
    });

// for multiselect of cuisines
    document.addEventListener("DOMContentLoaded", function () {
        const cuisineBtn = document.getElementById("cuisineDropdownBtn");
        const cuisineMenu = document.getElementById("cuisineDropdown");
        const cuisineSelectedText = document.getElementById("cuisineSelectedText");
        const cuisineCheckboxes = cuisineMenu.querySelectorAll("input[type=checkbox]");

        // Toggle dropdown
        if (cuisineBtn) {
            cuisineBtn.addEventListener("click", () => {
                cuisineMenu.classList.toggle("hidden");
            });

            // Update selected text when user checks/unchecks
            cuisineCheckboxes.forEach(cb => {
                cb.addEventListener("change", () => {
                    const checked = [...cuisineCheckboxes].filter(c => c.checked).length;
                    cuisineSelectedText.textContent = checked > 0 ? checked + " selected" : "Select Cuisine Types";
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", (e) => {
                if (!cuisineBtn.contains(e.target) && !cuisineMenu.contains(e.target)) {
                    cuisineMenu.classList.add("hidden");
                }
            });
        }
    });
</script>