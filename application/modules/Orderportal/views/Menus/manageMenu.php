<!--<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">-->

<script>
// ✅ DEFINE HANDLER FUNCTION FIRST - Before checkboxes are rendered
var selectedMenuOptions = [];

function handleCheckboxChange(checkbox) {
    console.log('🎯 CHECKBOX CHANGED! ID:', checkbox.dataset.id);
    
    const id = parseInt(checkbox.dataset.id);
    const name = checkbox.dataset.name;
    const nutrition = checkbox.dataset.nutrition;
    
    let itemIndex = selectedMenuOptions.findIndex(item => item.id === id);
    
    if (checkbox.checked && itemIndex === -1) {
        selectedMenuOptions.push({ id, name, nutrition });
        console.log('✅ Added:', name);
        
        // Hide from available list
        const availableItem = checkbox.closest('.allMenuOptionsList');
        if (availableItem) availableItem.classList.add('hidden');
    } else if (!checkbox.checked && itemIndex !== -1) {
        selectedMenuOptions.splice(itemIndex, 1);
        console.log('❌ Removed:', name);
        
        // Show back in available list
        const availableItem = checkbox.closest('.allMenuOptionsList');
        if (availableItem) availableItem.classList.remove('hidden');
    }
    
    // Re-render selected items
    renderSelectedItems();
}

function renderSelectedItems() {
    const selectedItemsContainer = document.getElementById('selected-items');
    if (!selectedItemsContainer) return;
    
    selectedItemsContainer.innerHTML = '';
    const selectedCount = document.getElementById('selected-count');
    
    console.log('📋 Rendering', selectedMenuOptions.length, 'items');
    
    selectedMenuOptions.forEach(option => {
        const div = document.createElement('div');
        div.className = 'selected-item-container flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-all duration-200 group';
        div.innerHTML = `
            <div class="ml-1 flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-0">${option.name}</p>
                    </div>
                </div>
                ${option.nutrition && option.nutrition !== '0 Kcal' && option.nutrition.trim() !== '' ? `
                <div class="flex mt-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">${option.nutrition}</span>
                </div>` : ''}
            </div>
            <button class="ml-2 w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-700 transition-all duration-200 remove-btn opacity-70 hover:opacity-100" data-id="${option.id}" title="Remove item">
                <i class="fa-solid fa-times text-xs"></i>
            </button>
        `;
        
        div.querySelector('.remove-btn').addEventListener('click', () => {
            const removedId = parseInt(div.querySelector('.remove-btn').dataset.id);
            selectedMenuOptions = selectedMenuOptions.filter(item => item.id != removedId);
            
            // Uncheck the corresponding checkbox
            const checkbox = document.querySelector(`.checkbox-option[data-id="${removedId}"]`);
            if (checkbox) checkbox.checked = false;
            
            // Show the item back in Available Options
            const availableItem = document.querySelector(`.allMenuOptionsList[data-id="${removedId}"]`);
            if (availableItem) availableItem.classList.remove('hidden');
           
            renderSelectedItems();
        });
        
        selectedItemsContainer.appendChild(div);
    });
    
    if (selectedCount) {
        selectedCount.innerHTML = `<i class="fa-solid fa-check-circle mr-1 text-xs"></i>${selectedMenuOptions.length} items`;
    }
}

console.log('✅ Handler functions defined');
</script>

<style>
/* Beautiful close button animations */
.remove-btn {
    transition: all 0.2s ease-in-out;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.remove-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
}

.remove-btn:active {
    transform: scale(0.95);
}

/* Selected item container improvements */
.selected-item-container {
    transition: all 0.2s ease-in-out;
}

.selected-item-container:hover .remove-btn {
    opacity: 1;
}

/* Available options selection improvements */
.allMenuOptionsList {
    user-select: none;
}

.allMenuOptionsList:hover {
    transform: translateY(-1px);
}

.allMenuOptionsList:active {
    transform: translateY(0);
}

/* Checkbox styling improvements */
.checkbox-option:checked {
    background-color: #3b82f6 !important;
    border-color: #3b82f6 !important;
}

.checkbox-option:hover {
    border-color: #60a5fa !important;
}

/* Label cursor improvements */
label {
    cursor: pointer !important;
}

/* Selected items count beautification */
#selected-count {
    animation: pulse-subtle 2s infinite;
    transition: all 0.3s ease;
}

#selected-count:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

@keyframes pulse-subtle {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

/* Form validation styling */
.border-red-500 {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 1px #ef4444 !important;
}

.focus\:border-red-500:focus {
    border-color: #ef4444 !important;
}

.focus\:ring-red-500:focus {
    --tw-ring-color: rgba(239, 68, 68, 0.5) !important;
}

/* Error message animations and styling */
.text-red-500:not(.hidden), 
#menu-name-error:not(.hidden),
#category-error:not(.hidden) {
    animation: slideInError 0.3s ease-out;
    color: #ef4444 !important;
}

#menu-name-error i,
#category-error i {
    color: #ef4444 !important;
}

/* Required field asterisks */
label span[style*="color: #ef4444"] {
    color: #ef4444 !important;
    font-weight: bold !important;
    font-size: 1.1em !important;
}

@keyframes slideInError {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Warning Modal Styling */
#warning-modal {
    backdrop-filter: blur(4px);
}

#warning-modal .transform {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Search input improvements */
#menu-search {
    background-image: none !important;
    background: white !important;
}

#menu-search:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    background-image: none !important;
    background: white !important;
}

#menu-search:hover {
    background-image: none !important;
    background: white !important;
}

/* Override any universal search styling for this specific input */
.search-box input[id="menu-search"] {
    background-image: none !important;
    background: white !important;
    padding-left: 2.5rem !important;
}

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
.py-2\.5 {
    padding-top: 0.625rem !important;
    padding-bottom: 0.625rem !important;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Searchable Dropdown Styles */
#cuisineSearch,
#allergensSearch {
    transition: all 0.2s ease;
}

#cuisineSearch:focus,
#allergensSearch:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Smooth scroll for options list */
#cuisineOptionsList,
#allergensOptionsList {
    scroll-behavior: smooth;
}

/* Custom scrollbar for dropdown */
#cuisineOptionsList::-webkit-scrollbar,
#allergensOptionsList::-webkit-scrollbar {
    width: 6px;
}

#cuisineOptionsList::-webkit-scrollbar-track,
#allergensOptionsList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#cuisineOptionsList::-webkit-scrollbar-thumb,
#allergensOptionsList::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

#cuisineOptionsList::-webkit-scrollbar-thumb:hover,
#allergensOptionsList::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Highlight options on hover */
.cuisine-option:hover,
.allergen-option:hover {
    background-color: #f3f4f6 !important;
}

/* Ensure dropdowns stay on top */
#cuisineDropdown,
#allergensDropdown {
    max-height: 350px;
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-content-inner">
                        <div class="card" id="menuForm">
                            <div class="card-header border-bottom-dashed">
                                <div class="row g-4 align-items-center">
                                    <div class="col-sm">
                                        <h5 class="card-title mb-0 text-black">Create item</h5>
                                        <p class="text-black mt-1 mb-0">Add a new item with options</p>
                                    </div>
                                    <div class="col-sm-auto">
                                        <div>
                                            <button id="cancel-btn" class="btn btn-outline-secondary me-2">
                                                <i class="ri-close-line align-bottom me-1"></i>Cancel
                                            </button>
                                            <button id="save-btn" class="btn btn-success">
                                                <i class="ri-save-line align-bottom me-1"></i>Save Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-green-600"></div>
                </div>
                
                <!-- Warning Modal -->
                <div id="warning-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden z-50">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900">Validation Warning</h3>
                                </div>

                            </div>
                            <div class="mb-4">
                                <p id="warning-message" class="text-sm text-gray-600"></p>
                            </div>
                            <div class="flex justify-end">
                                <button id="warning-ok-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    OK
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                                <!-- Form Content -->
                                <?php $menuId =  isset($menu['id']) ? '/'.htmlspecialchars($menu['id']) : ''; ?>
                                <form id="menu-form" action="<?php echo site_url('Orderportal/Configfoodmenu/manage_menu'.$menuId); ?>" method="post">
                                    <input type="hidden" name="id" value="<?php echo isset($menu['id']) ? htmlspecialchars($menu['id']) : ''; ?>">
                                    <!-- Hidden input to safely store preselected options as JSON -->
                                    <input type="hidden" id="preselected-menu-data" value="<?php 
                                    $preselected = array_map(function($option) {
                                        return [
                                            'id' => (int)($option['menu_option_id'] ?? 0),
                                            'name' => $option['menu_option_name'] ?? '',
                                            'nutrition' => $option['nutritionValues'] ?? '0 Kcal'
                                        ];
                                    }, $assigned_options ?? []);
                                    echo htmlspecialchars(json_encode($preselected), ENT_QUOTES, 'UTF-8');
                                    ?>">
                                    <!-- Basic Information Section -->
                                    <div id="basic-info-section">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Menu Name -->
                                            <div class="col-span-1">
                                                <label for="menu-name" class="block text-sm font-medium text-gray-700 mb-1">Item Name <span style="color: #ef4444 !important; font-weight: bold;">*</span></label>
                                                <div class="relative">
                                                    <input type="text" id="menu-name" name="menuName" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                                           value="<?php echo set_value('name', isset($menu['name']) ? htmlspecialchars($menu['name']) : ''); ?>" placeholder="e.g. Weekend Brunch Special" required>
                                                    <div id="menu-name-error" class="hidden text-xs mt-1" style="color: #ef4444 !important;">
                                                        <i class="fa-solid fa-exclamation-circle mr-1" style="color: #ef4444 !important;"></i>Item name is required
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-span-1">
    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categories <span style="color: #ef4444 !important; font-weight: bold;">*</span></label>
    <div class="relative">
        <!-- Hidden input to store selected category IDs -->
        <input type="hidden" name="category[]" id="selected-categories" value="<?php echo isset($menu['categories']) ? htmlspecialchars(implode(',', $menu['categories'])) : ''; ?>">
        <!-- Dropdown button -->
        <button id="category-dropdown-btn" type="button" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-left bg-white flex justify-between items-center">
            <span id="category-display">Select categories</span>
            <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
        </button>
        <!-- Dropdown menu -->
        <div id="category-dropdown" class="hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto z-50">
            <?php foreach ($categories as $category): ?>
                <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                    <input type="checkbox" 
                           class="category-checkbox form-checkbox h-4 w-4 text-primary-500" 
                           value="<?php echo htmlspecialchars($category['id']); ?>" 
                           <?php echo isset($menu['categories']) && in_array($category['id'], $menu['categories']) ? 'checked' : ''; ?>>
                    <span class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars($category['name']); ?></span>
                </label>
            <?php endforeach; ?>
        </div>
        <div id="category-error" class="hidden text-xs mt-1" style="color: #ef4444 !important;">
            <i class="fa-solid fa-exclamation-circle mr-1" style="color: #ef4444 !important;"></i>Please select at least one category
        </div>
    </div>
</div>
                                            
                                            <!-- Cuisine -->
                                            <div class="col-span-1">
                                                <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine Type</label>
                                                <div class="relative">
                                                    <select id="cuisine" name="cuisine" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                                        <option value="" disabled selected>Select a cuisine</option>
                                                        <?php foreach ($cuisines as $cuisine): ?>
                                                            <option value="<?php echo htmlspecialchars($cuisine['id']); ?>" <?php echo set_select('cuisine', $cuisine['id'], isset($menu['cuisine']) && $menu['cuisine'] == $cuisine['id']); ?>>
                                                                <?php echo htmlspecialchars($cuisine['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Allergens (Diet Restrictions) -->
                                            <div class="col-span-1 relative">
                                                <label for="allergens" class="block text-sm font-medium text-gray-700 mb-1">Allergens (Diet Restrictions)</label>
                                                <?php 
                                                $selected_allergens = isset($menu['allergens']) ? (is_array($menu['allergens']) ? $menu['allergens'] : json_decode($menu['allergens'], true)) : [];
                                                if (!is_array($selected_allergens)) {
                                                    $selected_allergens = [];
                                                }
                                                ?>
                                                <!-- Hidden input to store selected values -->
                                                <input type="hidden" id="allergens" name="allergens" value="<?php echo htmlspecialchars(json_encode($selected_allergens)); ?>">
                                                
                                                <!-- Dropdown trigger button -->
                                                <button type="button" id="allergensDropdownBtn" 
                                                    class="w-full flex justify-between items-center px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    <span id="allergensSelectedText" class="text-gray-700 text-sm">
                                                        <?= !empty($selected_allergens) ? count($selected_allergens) . " selected" : "Select allergens" ?>
                                                    </span>
                                                    <i class="fa-solid fa-chevron-down text-gray-500 ml-2 text-xs"></i>
                                                </button>

                                                <!-- Dropdown menu with search -->
                                                <div id="allergensDropdown" class="absolute hidden mt-1 w-full border border-gray-300 rounded-lg bg-white shadow-lg" style="z-index: 999;">
                                                    <!-- Search box -->
                                                    <div class="p-2 border-b border-gray-200 bg-gray-50">
                                                        <div class="relative">
                                                            <input 
                                                                type="text" 
                                                                id="allergensSearch" 
                                                                placeholder="Search allergens..." 
                                                                class="w-full px-3 py-2 pl-9 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                                autocomplete="off"
                                                            >
                                                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Options list -->
                                                    <div id="allergensOptionsList" class="max-h-48 overflow-y-auto p-2">
                                                        <?php if (!empty($allergens)): ?>
                                                            <?php foreach ($allergens as $allergen): ?>
                                                                <label class="allergen-option flex items-center px-3 py-2 hover:bg-gray-100 rounded cursor-pointer" data-name="<?= strtolower($allergen['name']) ?>">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        class="allergen-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                        value="<?= htmlspecialchars($allergen['id']) ?>"
                                                                        data-name="<?= htmlspecialchars($allergen['name']) ?>"
                                                                        <?= in_array($allergen['id'], $selected_allergens) ? 'checked' : '' ?>
                                                                    >
                                                                    <span class="ml-2 text-gray-700 text-sm"><?= htmlspecialchars($allergen['name']) ?></span>
                                                                </label>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="px-4 py-2 text-gray-500 text-sm">No allergens available</div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- No results message -->
                                                    <div id="allergensNoResults" class="hidden px-4 py-3 text-center text-gray-500 text-sm border-t border-gray-200">
                                                        <i class="fa-solid fa-search mr-2"></i>No allergens found
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Menu Type -->
                                            <div class="col-span-1">
                                                <label for="inputType" class="block text-sm font-medium text-gray-700 mb-1">Input Type</label>
                                                <div class="relative">
                                                    <select id="inputType" name="inputType" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                                        <option value="checkbox"  <?php echo set_select('inputType', 'checkbox', isset($menu['inputType']) && $menu['inputType'] == 'checkbox'); ?>>Checkbox</option>
                                                        <option value="radio" <?php echo set_select('inputType', 'radio', isset($menu['inputType']) && $menu['inputType'] == 'radio'); ?>>Radio</option>
                                                        
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                        <i class="fa-solid fa-chevron-down text-xs" ></i>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-span-1">
                                                <label for="is_single_select" class="block text-sm font-medium text-gray-700 mb-1">Restricted Menu</label>
                                                <div class="relative">
                                                    <select id="is_single_select" name="is_single_select" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                                        <option value="no" <?php echo set_select('is_single_select', 'no', isset($menu['is_single_select']) && $menu['is_single_select'] == 'no'); ?>>No</option>
                                                        <option value="yes" <?php echo set_select('is_single_select', 'yes', isset($menu['is_single_select']) && $menu['is_single_select'] == 'yes'); ?>>Yes</option>
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                                <small>Select Yes if you want user to order only one menu per category</small>
                                            </div>
                                            
                                            <div class="col-span-1">
                                                <label for="is_main_menu" class="block text-sm font-medium text-gray-700 mb-1">Is Main Menu</label>
                                                <div class="relative">
                                                    <select id="is_main_menu" name="is_main_menu" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                                        <option value="no" <?php echo set_select('is_main_menu', 'no', isset($menu['is_main_menu']) && $menu['is_main_menu'] == 'no'); ?>>No</option>
                                                        <option value="yes" <?php echo set_select('is_main_menu', 'yes', isset($menu['is_main_menu']) && $menu['is_main_menu'] == 'yes'); ?>>Yes</option>
                                                    </select>
                                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                                <small>Select Yes if you want no other restricted menu can be ordred along with this</small>
                                            </div>
                                            
                                            
                                            
                                            <!-- Price -->
                                          
                                            
                                            <!-- Status -->
                                            <div class="col-span-1">
                                                
                                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                <textarea id="description" name="description" rows="1" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                                         placeholder="Describe your menu..."><?php echo set_value('description', isset($menu['description']) ? htmlspecialchars($menu['description']) : ''); ?></textarea>
                                                <p class="text-xs text-gray-500 mt-1">Provide a brief description of this menu for your staff and customers.</p>
                                            </div>
                                          
                                            
                                            <!-- Description -->
                                            
                                        </div>
                                    </div>
                                    
                                    <!-- Menu Items Selection Section -->
                                    <div id="menu-items-section">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Item Options</h3>
                                        <p class="text-sm text-gray-600 mb-4">Select items to include in this menu from your available options.</p>
                                        
                                        <!-- Search and Filter Controls -->
                                        <div class="flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-4 mb-4">
                                            <div class="relative flex-1 search-box">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                                                </div>
                                                <input type="text" id="menu-search" class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:border-gray-300" placeholder="Search menu items...">
                                            </div>
                                        </div>
                                        
                                        <!-- Dual Listbox -->
                                        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                            <!-- Available Items -->
                                            <div class="flex-1 border border-gray-200 rounded-lg">
                                                <div class="p-3 bg-gray-50 border-b border-gray-200 rounded-t-lg">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="font-medium text-gray-700">Available Options</h4>
                                                        <div class="text-xs text-gray-500" id="available-count"><a class="btn btn-secondary add-btn btn-sm" href="<?php echo base_url('Orderportal/Configfoodmenu/manage_menu_option') ?>">
                                    <i class="ri-add-line align-bottom me-1"></i>Add Options</a></div>
                                                    </div>
                                                </div>
                                                <div class="p-2 h-[400px] overflow-y-auto" id="available-items">
                                                    <?php if(isset($menu_options) && !empty($menu_options)) {  ?>
                                                    <?php foreach ($menu_options as $option): 
                                                        $selectedMenuOptionsIds = array_column($assigned_options ?? [], 'menu_option_id');
                                                        
                                                        $isSelected = in_array($option['id'], $selectedMenuOptionsIds);
                                                        if($isSelected){ ?>
                                                        <input type="hidden" name="menu_options" value="<?php echo htmlspecialchars($option['id']); ?>">    
                                                     <?php    }
                                                    ?>
                                                        <div class="allMenuOptionsList flex items-center p-3 hover:bg-blue-50 hover:border-blue-200 border border-transparent rounded-lg cursor-pointer group transition-all duration-200 hover:shadow-sm <?php echo $isSelected ? 'hidden' : ''; ?>" data-id="<?php echo htmlspecialchars($option['id']); ?>" data-menuname="<?php echo htmlspecialchars($option['menu_option_name']); ?>">
                                                            <label class="flex items-center w-full cursor-pointer">
                                                                <input type="checkbox" class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 checkbox-option transition-all duration-200 cursor-pointer" 
                                                                       data-id="<?php echo htmlspecialchars($option['id']); ?>" 
                                                                       data-name="<?php echo htmlspecialchars($option['menu_option_name']); ?>" 
                                                                       data-nutrition="<?php echo htmlspecialchars($option['nutritionValues'] ?? '0 Kcal'); ?>"
                                                                       onchange="handleCheckboxChange(this)"
                                                                       <?php echo $isSelected ? 'checked' : ''; ?>>
                                                                <div class="ml-3 flex-1 cursor-pointer">
                                                                    <div class="flex items-center justify-between">
                                                                        <div>
                                                                            <p class="text-sm font-medium text-gray-800 mb-1 group-hover:text-blue-800 transition-colors duration-200"><?php echo htmlspecialchars($option['menu_option_name']); ?></p>
                                                                            <?php if (!empty($option['nutritionValues']) && $option['nutritionValues'] !== '0 Kcal' && trim($option['nutritionValues']) !== ''): ?>
                                                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 group-hover:bg-green-200 transition-colors duration-200"><?php echo htmlspecialchars($option['nutritionValues']); ?></span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <?php }  ?>
                                                    <!-- Dynamically populated -->
                                                </div>
                                            </div>
                                            
                                            <!-- Transfer Controls -->
                                            <div class="flex md:flex-col justify-center items-center md:w-10">
                                                <button type="button" class="p-1 rounded-full hover:bg-gray-100" id="add-selected">
                                                    <i class="fa-solid fa-chevron-right md:fa-chevron-up text-gray-500"></i>
                                                </button>
                                                <button type="button" class="p-1 rounded-full hover:bg-gray-100 mt-0 md:mt-2" id="remove-selected">
                                                    <i class="fa-solid fa-chevron-left md:fa-chevron-down text-gray-500"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Selected Items -->
                                            <div class="flex-1 border border-gray-200 rounded-lg">
                                                <div class="p-3 bg-gray-50 border-b border-gray-200 rounded-t-lg">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="font-medium text-gray-700">Selected Items</h4>
                                                        <div class="flex items-center">
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200" id="selected-count">
                                                                <i class="fa-solid fa-check-circle mr-1 text-xs"></i>
                                                                0 items
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-2 h-[400px] overflow-y-auto" id="selected-items">
                                                    <!-- Dynamically populated -->
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Selected Items Tags View -->
                                        <div class="mt-6">
                                            <div class="flex flex-wrap gap-2" id="selected-tags">
                                                <!-- Dynamically populated -->
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Actions -->
                                    <div class="mt-8 flex justify-end space-x-3">
                                        <button type="button" class="btn btn-sm btn-orange" id="form-cancel-btn">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-success" id="form-save-btn">
                                            <i class="fa-solid fa-save mr-2"></i>Save Menu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

   
</div>

  <script>
  console.log('🚀 MENU SCRIPT STARTING - Additional initialization...');
  
  // selectedMenuOptions is already declared at the top of the page

// INLINE HANDLER - Called directly from HTML onchange
function handleCheckboxChange(checkbox) {
    console.log('🎯 CHECKBOX CHANGED! ID:', checkbox.dataset.id, 'Checked:', checkbox.checked);
    toggleItem(checkbox);
}

function toggleItem(checkbox) {
    const id = parseInt(checkbox.dataset.id);
    const name = checkbox.dataset.name;
    const nutrition = checkbox.dataset.nutrition;
    console.log('Toggling item:', { id, name, nutrition }, 'Checked:', checkbox.checked);

    let itemIndex = selectedMenuOptions.findIndex(item => item.id === id);
    if (checkbox.checked && itemIndex === -1) {
        selectedMenuOptions.push({ id, name, nutrition });
        console.log('Added to selectedMenuOptions:', selectedMenuOptions);
        
        // Hide from available list
        const availableItem = checkbox.closest('.allMenuOptionsList');
        if (availableItem) {
            availableItem.classList.add('hidden');
        }
    } else if (!checkbox.checked && itemIndex !== -1) {
        selectedMenuOptions.splice(itemIndex, 1);
        console.log('Removed from selectedMenuOptions:', selectedMenuOptions);
        
        // Show back in available list
        const availableItem = checkbox.closest('.allMenuOptionsList');
        if (availableItem) {
            availableItem.classList.remove('hidden');
        }
    }
    renderSelectedItems();
}

function renderSelectedItems() {
    const selectedItemsContainer = document.getElementById('selected-items');
    selectedItemsContainer.innerHTML = ''; // Clear existing content
    const selectedCount = document.getElementById('selected-count');
    const tagCount = document.getElementById('tag-count');

    console.log('Rendering selected items, count:', selectedMenuOptions.length);
    selectedMenuOptions.forEach(option => {
        const div = document.createElement('div');
        div.className = 'selected-item-container flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-all duration-200 group';
        div.innerHTML = `
            <div class="ml-1 flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-0">${option.name}</p>
                    </div>
                </div>
                ${option.nutrition && option.nutrition !== '0 Kcal' && option.nutrition.trim() !== '' ? `
                <div class="flex mt-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">${option.nutrition}</span>
                </div>` : ''}
            </div>
            <button class="ml-2 w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-700 transition-all duration-200 remove-btn opacity-70 hover:opacity-100" data-id="${option.id}" title="Remove item">
                <i class="fa-solid fa-times text-xs"></i>
            </button>
        `;
         
        div.querySelector('.remove-btn').addEventListener('click', () => {
            const removedId = parseInt(div.querySelector('.remove-btn').dataset.id);
            selectedMenuOptions = selectedMenuOptions.filter(item => item.id != removedId);
            console.log('Removed ID:', removedId, 'New selectedMenuOptions:', selectedMenuOptions);
            
            // Uncheck the corresponding checkbox in Available Options
            const checkbox = document.querySelector(`.checkbox-option[data-id="${removedId}"]`);
            if (checkbox) {
                checkbox.checked = false;
            }
            
            // Show the item back in Available Options
            const availableItem = document.querySelector(`.allMenuOptionsList[data-id="${removedId}"]`);
            if (availableItem) {
                availableItem.classList.remove('hidden');
            }
           
            renderSelectedItems();
        });
        selectedItemsContainer.appendChild(div);
    });

    selectedCount.innerHTML = `<i class="fa-solid fa-check-circle mr-1 text-xs"></i>${selectedMenuOptions.length} items`;
    
    console.log('Selected items rendered, count:', selectedMenuOptions.length);
}

// Search filter
document.getElementById('menu-search').addEventListener('input', function(e) {
    const filter = e.target.value.toLowerCase().trim();
    const menuOptions = document.querySelectorAll('.allMenuOptionsList');

    menuOptions.forEach(item => {
        const menuName = item.dataset.menuname.toLowerCase();
        const isSelected = selectedMenuOptions.some(option => parseInt(item.dataset.id) === option.id);

        if (isSelected) {
            item.classList.add('hidden'); // Keep selected items hidden
        } else if (filter === '' || menuName.includes(filter)) {
            item.classList.remove('hidden'); // Show all or matched unselected items
        } else {
            item.classList.add('hidden'); // Hide non-matching unselected items
        }
    });
    // console.log('Search input:', filter, 'Filtered items updated');
});

// Add selected button (optional)
document.getElementById('add-selected').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('#available-items .checkbox-option:checked');
    checkboxes.forEach(checkbox => {
        const id = parseInt(checkbox.dataset.id);
        if (!selectedMenuOptions.some(item => item.id === id)) {
            const name = checkbox.dataset.name;
            const nutrition = checkbox.dataset.nutrition;
            selectedMenuOptions.push({ id, name, nutrition });
            console.log('Added via add button:', { id, name, nutrition }, 'New selectedMenuOptions:', selectedMenuOptions);
        }
    });
    renderSelectedItems();
});

// Remove selected button
document.getElementById('remove-selected').addEventListener('click', function() {
    selectedMenuOptions = [];
    const checkboxes = document.querySelectorAll('#available-items .checkbox-option');
    checkboxes.forEach(checkbox => checkbox.checked = false);
    
    // Show all items back in Available Options
    const allItems = document.querySelectorAll('.allMenuOptionsList');
    allItems.forEach(item => item.classList.remove('hidden'));
    
    renderSelectedItems();
    console.log('Cleared all selectedMenuOptions:', selectedMenuOptions);
});

// Warning Modal Functions
function showWarningModal(message) {
    document.getElementById('warning-message').textContent = message;
    document.getElementById('warning-modal').classList.remove('hidden');
}

function hideWarningModal() {
    document.getElementById('warning-modal').classList.add('hidden');
}

// Form validation function
function validateForm() {
    // console.log('Starting form validation...');
    let isValid = true;
    
    // Validate menu name
    const menuName = document.getElementById('menu-name');
    const menuNameError = document.getElementById('menu-name-error');
    
    if (!menuName.value.trim()) {
        menuNameError.classList.remove('hidden');
        menuName.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        menuName.classList.remove('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
        isValid = false;
    } else {
        menuNameError.classList.add('hidden');
        menuName.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        menuName.classList.add('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
    }
    
    // Validate categories
    const selectedCategories = document.getElementById('selected-categories');
    const categoryError = document.getElementById('category-error');
    const categoryBtn = document.getElementById('category-dropdown-btn');
    
    if (!selectedCategories.value.trim()) {
        categoryError.classList.remove('hidden');
        categoryBtn.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        categoryBtn.classList.remove('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
        isValid = false;
    } else {
        categoryError.classList.add('hidden');
        categoryBtn.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        categoryBtn.classList.add('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
    }
    
    // Validate selected items - show modal if no items selected
    if (selectedMenuOptions.length === 0) {
        // console.log('No items selected, showing warning modal');
        // Show warning modal
        showWarningModal('Please select at least one item option before saving.');
        isValid = false;
    }
    
    // console.log('Validation result:', isValid);
    return isValid;
}

// Form submission
document.getElementById('menu-form').addEventListener('submit', function(e) {
    // console.log('Form submit event triggered');
    e.preventDefault();
    
    if (!validateForm()) {
        // console.log('Validation failed, stopping submission');
        // Scroll to first error (modal will handle selected items validation)
        const firstError = document.querySelector('#menu-name-error:not(.hidden), #category-error:not(.hidden)');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    console.log('✅ Validation passed, proceeding with submission');
    console.log('📦 Selected options to save:', selectedMenuOptions);
    
    const loader = document.getElementById('loader');
    loader.classList.remove('hidden');

    // Remove existing hidden inputs
    this.querySelectorAll('input[name^="menu_options["]').forEach(el => el.remove());

    // Add new hidden inputs for selected IDs
    selectedMenuOptions.forEach((option, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `menu_options[${index}]`;
        input.value = option.id;
        this.appendChild(input);
        console.log(`➕ Added hidden input: menu_options[${index}] = ${option.id} (${option.name})`);
    });

    console.log('📝 Form data prepared, submitting...');
    console.log('🔢 Total hidden inputs created:', selectedMenuOptions.length);

    // Try immediate submission first, then fallback to setTimeout
    try {
        // console.log('Attempting immediate form submission...');
        this.submit();
    } catch (error) {
        // console.log('Immediate submission failed, trying with timeout:', error);
        setTimeout(() => {
            // console.log('Submitting form with timeout...');
            try {
                this.submit();
            } catch (timeoutError) {
                console.error('Form submission failed completely:', timeoutError);
                // Fallback: create a new form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.action;
                
                // Copy all form data
                const formData = new FormData(this);
                for (let [key, value] of formData.entries()) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
        }, 500);
    }
});

// Cancel and save buttons
document.getElementById('cancel-btn').addEventListener('click', () => {
    window.location.href = '<?php echo site_url('Orderportal/Configfoodmenu/menus'); ?>';
});
document.getElementById('form-cancel-btn').addEventListener('click', () => {
    window.location.href = '<?php echo site_url('Orderportal/Configfoodmenu/menus'); ?>';
});
document.getElementById('save-btn').addEventListener('click', () => {
    console.log('💾 Save button clicked');
    console.log('📋 Current selectedMenuOptions:', selectedMenuOptions);
    document.getElementById('menu-form').dispatchEvent(new Event('submit'));
});
document.getElementById('form-save-btn').addEventListener('click', () => {
    console.log('💾 Form save button clicked');
    console.log('📋 Current selectedMenuOptions:', selectedMenuOptions);
    document.getElementById('menu-form').dispatchEvent(new Event('submit'));
});

// Real-time validation
document.getElementById('menu-name').addEventListener('input', function() {
    const menuNameError = document.getElementById('menu-name-error');
    
    if (this.value.trim()) {
        menuNameError.classList.add('hidden');
        this.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        this.classList.add('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
    }
});

document.getElementById('menu-name').addEventListener('blur', function() {
    const menuNameError = document.getElementById('menu-name-error');
    
    if (!this.value.trim()) {
        menuNameError.classList.remove('hidden');
        this.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        this.classList.remove('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
    }
});

// Modal event listeners
document.getElementById('warning-ok-btn').addEventListener('click', hideWarningModal);
document.getElementById('warning-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideWarningModal();
    }
});

// ============ INITIALIZATION ============
console.log('📦 Initializing...');

// Load preselected items
try {
    const preselectedInput = document.getElementById('preselected-menu-data');
    if (preselectedInput && preselectedInput.value) {
        const parsed = JSON.parse(preselectedInput.value);
        if (Array.isArray(parsed)) {
            selectedMenuOptions = parsed;
            console.log('✅ Loaded', selectedMenuOptions.length, 'preselected items');
        }
    }
} catch (error) {
    console.error('❌ Error:', error);
    selectedMenuOptions = [];
}

// Initial render
renderSelectedItems();
console.log('✅ READY - Using inline onchange handlers');
  </script>
  <!--for multiselect category-->
  
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdownBtn = document.getElementById('category-dropdown-btn');
    const dropdownMenu = document.getElementById('category-dropdown');
    const displayText = document.getElementById('category-display');
    const hiddenInput = document.getElementById('selected-categories');
    const checkboxes = document.querySelectorAll('.category-checkbox');

    // Toggle dropdown visibility
    dropdownBtn.addEventListener('click', function () {
        dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    // Update display text and hidden input when checkboxes change
    function updateSelections() {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        // Update display text
        if (selected.length === 0) {
            displayText.textContent = 'Select categories';
        } else {
            const categoryNames = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.parentElement.querySelector('span').textContent);
            displayText.textContent = categoryNames.join(', ') || 'Select categories';
        }

        // Update hidden input with comma-separated values
        hiddenInput.value = selected.join(',');
        
        // Real-time validation for categories
        const categoryError = document.getElementById('category-error');
        const categoryBtn = document.getElementById('category-dropdown-btn');
        
        if (selected.length > 0) {
            categoryError.classList.add('hidden');
            categoryBtn.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            categoryBtn.classList.add('border-gray-300', 'focus:border-primary-500', 'focus:ring-primary-500');
        }
    }

    // Initialize display text on page load
    updateSelections();

    // Add change event listeners to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelections);
    });
});

// ============================================
// CUISINE TYPE SEARCHABLE DROPDOWN
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    const cuisineBtn = document.getElementById('cuisineDropdownBtn');
    const cuisineMenu = document.getElementById('cuisineDropdown');
    const cuisineSelectedText = document.getElementById('cuisineSelectedText');
    const cuisineInput = document.getElementById('cuisine');
    const cuisineSearchInput = document.getElementById('cuisineSearch');
    const cuisineOptionsList = document.getElementById('cuisineOptionsList');
    const cuisineNoResults = document.getElementById('cuisineNoResults');

    if (cuisineBtn && cuisineMenu) {
        // Toggle dropdown
        cuisineBtn.addEventListener('click', function () {
            cuisineMenu.classList.toggle('hidden');
            if (!cuisineMenu.classList.contains('hidden')) {
                cuisineSearchInput.focus();
                cuisineSearchInput.value = '';
                filterCuisineOptions('');
            }
        });

        // Search functionality
        cuisineSearchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            filterCuisineOptions(searchTerm);
        });

        function filterCuisineOptions(searchTerm) {
            const options = cuisineOptionsList.querySelectorAll('.cuisine-option');
            let visibleCount = 0;

            options.forEach(option => {
                const name = option.getAttribute('data-name');
                if (name.includes(searchTerm)) {
                    option.style.display = 'flex';
                    visibleCount++;
                } else {
                    option.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                cuisineNoResults.classList.remove('hidden');
            } else {
                cuisineNoResults.classList.add('hidden');
            }
        }

        // Handle option click
        cuisineOptionsList.addEventListener('click', function (e) {
            const option = e.target.closest('.cuisine-option');
            if (option) {
                const cuisineId = option.getAttribute('data-id');
                const cuisineName = option.querySelector('span').textContent;
                
                // Update hidden input and display text
                cuisineInput.value = cuisineId;
                cuisineSelectedText.textContent = cuisineName;
                
                // Close dropdown
                cuisineMenu.classList.add('hidden');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!cuisineBtn.contains(e.target) && !cuisineMenu.contains(e.target)) {
                cuisineMenu.classList.add('hidden');
            }
        });

        // Prevent dropdown close when clicking inside search input
        cuisineSearchInput.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }
});

// ============================================
// ALLERGENS SEARCHABLE MULTI-SELECT DROPDOWN
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    const allergensBtn = document.getElementById('allergensDropdownBtn');
    const allergensMenu = document.getElementById('allergensDropdown');
    const allergensSelectedText = document.getElementById('allergensSelectedText');
    const allergensInput = document.getElementById('allergens');
    const allergensSearchInput = document.getElementById('allergensSearch');
    const allergensOptionsList = document.getElementById('allergensOptionsList');
    const allergensNoResults = document.getElementById('allergensNoResults');
    const allergensCheckboxes = document.querySelectorAll('.allergen-checkbox');

    if (allergensBtn && allergensMenu) {
        // Toggle dropdown
        allergensBtn.addEventListener('click', function () {
            allergensMenu.classList.toggle('hidden');
            if (!allergensMenu.classList.contains('hidden')) {
                allergensSearchInput.focus();
                allergensSearchInput.value = '';
                filterAllergensOptions('');
            }
        });

        // Search functionality
        allergensSearchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            filterAllergensOptions(searchTerm);
        });

        function filterAllergensOptions(searchTerm) {
            const options = allergensOptionsList.querySelectorAll('.allergen-option');
            let visibleCount = 0;

            options.forEach(option => {
                const name = option.getAttribute('data-name');
                if (name.includes(searchTerm)) {
                    option.style.display = 'flex';
                    visibleCount++;
                } else {
                    option.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                allergensNoResults.classList.remove('hidden');
            } else {
                allergensNoResults.classList.add('hidden');
            }
        }

        // Update selected allergens
        function updateAllergensSelection() {
            const selected = Array.from(allergensCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            
            // Update hidden input
            allergensInput.value = JSON.stringify(selected);
            
            // Update display text
            if (selected.length === 0) {
                allergensSelectedText.textContent = 'Select allergens';
            } else {
                allergensSelectedText.textContent = selected.length + ' selected';
            }
        }

        // Add change event listeners to checkboxes
        allergensCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateAllergensSelection);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!allergensBtn.contains(e.target) && !allergensMenu.contains(e.target)) {
                allergensMenu.classList.add('hidden');
            }
        });

        // Prevent dropdown close when clicking inside search input
        allergensSearchInput.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Initialize display text on page load
        updateAllergensSelection();
    }
});
</script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
