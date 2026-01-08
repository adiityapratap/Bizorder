<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
  
    
    <style>
        ::-webkit-scrollbar { display: none;}
        
        /* Status badge styles - Match screenshot exactly */
        .status-delivered, .status-completed {
            background-color: #dcfce7 !important;
            color: #166534 !important;
            padding: 4px 10px !important;
            border-radius: 12px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .status-in-transit, .status-in-progress {
            background-color: #fef3c7 !important;
            color: #d97706 !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .status-ready {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .status-not-started, .status-pending {
            background-color: #fee2e2 !important;
            color: #dc2626 !important;
            padding: 4px 10px !important;
            border-radius: 12px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .status-unsent {
            background-color: #e9d5ff !important;
            color: #7c3aed !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .status-no-orders {
            background-color: #f3f4f6 !important;
            color: #6b7280 !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        /* Day tabs styling to match screenshot exactly */
        .date-toggle {
            background: #f8f9fa !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 16px 12px !important;
            margin: 0 6px !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            min-height: 80px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #374151 !important;
        }
        
        /* Active day tab - same color as Today's Orders header */
        .date-toggle.bg-emerald-800, 
        .date-toggle[style*="background-color: #065f46"],
        .date-toggle[id="current-date"] {
            background-color: #DBEFFE !important;
            color: #000000 !important;
            border-color: #DBEFFE !important;
        }
        
        /* Active day tab text */
        .date-toggle.bg-emerald-800 div,
        .date-toggle[style*="background-color: #065f46"] div,
        .date-toggle[id="current-date"] div {
            color: #000000 !important;
        }
        
        /* Inactive day tabs */
        .date-toggle.bg-gray-100 {
            background-color: #f8f9fa !important;
            color: #374151 !important;
            border-color: #e5e7eb !important;
        }
        
        .date-toggle.bg-gray-100 div {
            color: #374151 !important;
        }
        
        /* All day tab text styling */
        .date-toggle div {
            color: #374151 !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
        }
        
        /* Ultra-specific active day tab text override */
        .date-toggle.bg-emerald-800 div,
        .date-toggle[style*="background-color: #DBEFFE"] div,
        .date-toggle[id="current-date"] div,
        button.date-toggle[style*="background-color: #DBEFFE"] div,
        button.date-toggle[id="current-date"] div,
        .date-toggle.bg-emerald-800 .today-text,
        .date-toggle[style*="background-color: #DBEFFE"] .today-text,
        .date-toggle[id="current-date"] .today-text {
            color: #000000 !important;
            text-shadow: none !important;
        }
        
        /* Day tabs container */
        .flex.pb-2.mb-4.gap-1.w-full.justify-between {
            gap: 8px !important;
            margin-bottom: 24px !important;
        }
        
        /* Weekly Menu Plan Header */
        #weekly-menu {
            background: white !important;
            border-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Sidebar styling to match Figma */
        #todays-order, #todays-delivery {
            background: white !important;
            border-radius: 12px !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
        }
        
        .sidebar-header {
            background-color: #DBEFFE !important;
            color: #000000 !important;
            padding: 16px 20px !important;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600 !important;
        }
        
        .sidebar-header i {
            color: #000000 !important;
        }
        
        .sidebar-header * {
            color: #000000 !important;
        }
        
        /* Menu item cards */
        .category-container {
            background: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            margin-bottom: 16px !important;
            overflow: hidden !important;
        }
        
        /* Production Form button - no hover effects */
        .production-form-btn {
            background-color: #3b82f6 !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            width: 100% !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .production-form-btn:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        /* Add Menu button - no hover effects */
        .add-menu-btn:hover {
            background-color: #4285f4 !important;
            color: white !important;
        }
        
        /* Table styling for sidebar */
        .sidebar-table {
            width: 100%;
        }
        
        .sidebar-table th {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            font-weight: 500 !important;
            font-size: 11px !important;
            padding: 12px 16px !important;
            text-align: left !important;
            border-bottom: 1px solid #e2e8f0 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
        }
        
        .sidebar-table td {
            padding: 14px 16px !important;
            font-size: 13px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155 !important;
            vertical-align: middle !important;
        }
        
        .sidebar-table tr {
            background-color: white !important;
        }
        
        .sidebar-table tr:last-child td {
            border-bottom: none !important;
        }
        
        .view-details-link {
            color: #3b82f6 !important;
            font-size: 12px !important;
            text-decoration: none !important;
        }
        
        .view-details-link:hover {
            color: #1d4ed8 !important;
            text-decoration: underline !important;
        }
    </style>
    
    <script>tailwind.config = {
  "theme": {
    "extend": {
      "colors": {
        "navy": "#1A237E",
        "emerald": "#10B981",
        "coral": "#F97316",
        "lightBg": "#FAFAFA"
      },
      "fontFamily": {
        "poppins": [
          "Poppins",
          "sans-serif"
        ],
        "sans": [
          "Inter",
          "sans-serif"
        ]
      }
    }
  }
};</script>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;500;600;700;800;900&amp;display=swap">

  
  </head>
<body class="bg-gray-50 font-sans">
    <div class="flex flex-col lg:flex-row min-h-screen mt-5">
        <!-- Sidebar -->
        

        <!-- Main Content -->
        <main id="main-content" class="flex-1 p-4 lg:p-6">
                
                <style>
                /* Remove the 3rem margin-top for this screen only */
                .mt-5 {
                    margin-top: 0 !important;
                }
                
                
                /* Override all conflicting day tab text colors */
                .date-toggle div,
                .date-toggle .today-text,
                .date-toggle[style*="background-color: #DBEFFE"] div,
                .date-toggle[style*="background-color: #DBEFFE"] .today-text,
                .date-toggle[id="current-date"] div,
                .date-toggle[id="current-date"] .today-text {
                    color: #000000 !important;
                }
                
                /* Inactive day tabs text */
                .date-toggle[style*="background-color: #f8f9fa"] div,
                .date-toggle.bg-gray-100 div {
                    color: #374151 !important;
                }
                
                /* Ensure day buttons fit properly */
                .date-toggle {
                    min-height: 70px;
                    width: calc(100% / 7 - 4px);
                    max-width: calc(100% / 7 - 4px);
                    overflow: hidden;
                    word-wrap: break-word;
                    flex-shrink: 0;
                    line-height: 1.1;
                    font-size: 11px;
                }
                
                /* Better text visibility */
                .date-toggle div {
                    margin: 1px 0;
                }
                
                /* Ensure proper contrast */
                .bg-gray-100 {
                    background-color: #f3f4f6 !important;
                    color: #1f2937 !important;
                }
                
                .bg-emerald-800 {
                    background-color: #065f46 !important;
                    color: white !important;
                }
                
                /* Mobile-only fixes for day navigation - Complete overhaul */
                @media (max-width: 768px) {
                    /* Make the container scrollable if needed */
                    .flex.pb-2.mb-4.gap-1 {
                        gap: 4px !important;
                        padding-bottom: 16px !important;
                        overflow-x: auto !important;
                        -webkit-overflow-scrolling: touch !important;
                    }
                    
                    .date-toggle {
                        min-height: 80px !important;
                        min-width: 80px !important;
                        padding: 12px 8px !important;
                        font-size: 14px !important;
                        margin: 0 !important;
                        border-radius: 12px !important;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
                        flex-shrink: 0 !important;
                        display: flex !important;
                        flex-direction: column !important;
                        justify-content: center !important;
                        align-items: center !important;
                    }
                    
                    .date-toggle div {
                        line-height: 1.2 !important;
                        margin-bottom: 4px !important;
                        text-align: center !important;
                        width: 100% !important;
                    }
                    
                    .date-toggle div:first-child {
                        font-weight: 800 !important;
                        font-size: 12px !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.5px !important;
                    }
                    
                    .date-toggle div:nth-child(2) {
                        font-size: 12px !important;
                        font-weight: 600 !important;
                        margin-top: 2px !important;
                    }
                    
                    .today-text {
                        font-size: 10px !important;
                        margin-top: 4px !important;
                        font-weight: 700 !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.3px !important;
                    }
                }
                
                /* Very small screens */
                @media (max-width: 480px) {
                    .date-toggle {
                        min-width: 70px !important;
                        min-height: 75px !important;
                        padding: 10px 6px !important;
                    }
                    
                    .date-toggle div:first-child {
                        font-size: 10px !important;
                    }
                    
                    .date-toggle div:nth-child(2) {
                        font-size: 11px !important;
                    }
                    
                    .today-text {
                        font-size: 9px !important;
                    }
                }
                </style>

            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Left Column (Menu View) -->
                <div id="menu-view" class="w-full lg:w-2/3 order-1">
                    <!-- Summary Cards -->
                  

                  <div id="weekly-menu" class="bg-white rounded-xl shadow-sm mb-6" style="padding: 24px;">
    <div class="flex justify-between items-center" style="margin-bottom: 20px;">
        <h2 class="text-xl font-bold text-gray-900">Weekly Menu Plan</h2>
        <div class="flex space-x-3">
            <a href="<?php echo base_url('Orderportal/Menuplanner/list'); ?>" class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg text-decoration-none add-menu-btn" style="background-color: #4285f4; color: white; border-radius: 8px;">
                <svg class="w-4 h-4 mr-2" fill="white" viewBox="0 0 20 20">
                    <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                </svg>
                Add Menu
            </a>
            <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg" style="background-color: white; color: #6b7280; border: 1px solid #d1d5db; border-radius: 8px;" onclick="toggleFilterPanel();">
                <svg class="w-4 h-4 mr-2" fill="#6b7280" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                </svg>
                Filter
            </button>
        </div>
    </div>

    <!-- Filter Panel (Hidden by default) -->
    <div id="filter-panel" class="bg-gray-50 border rounded-lg p-4 mb-4" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Day</label>
                <select id="filter-day" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Days</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meal Type</label>
                <select id="filter-meal" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Meals</option>
                    <?php if(isset($categories) && !empty($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo strtoupper(htmlspecialchars($category['name'])); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="flex items-end">
                <div class="w-full space-y-2">
                    <button onclick="applyFilters()" class="w-full px-4 py-2 bg-emerald-800 text-white rounded-md text-sm hover:bg-emerald-900 transition-colors" style="background-color: #065f46 !important; color: white !important;">
                        Apply Filters
                    </button>
                    <button onclick="clearFilters()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 transition-colors">
                        Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Days of the week tabs - Updated for compact view - No parentheses around Today -->
<div class="flex pb-2 mb-4 gap-1 w-full justify-between">
    <?php if (isset($currentWeekdateRange) && !empty($currentWeekdateRange)) : ?>
        <?php foreach ($currentWeekdateRange as $date) : 
            $dayFull = date('l', strtotime($date)); // Full day name (Monday, Tuesday, etc.)
            $dateFormatted = date('M j', strtotime($date)); // Format: Jan 15, Feb 3, etc.
            $isToday = ($date === date('Y-m-d'));
            $btnClasses = $isToday 
                ? "px-1 py-2 bg-emerald-800 rounded-lg flex-1 text-center text-xs font-medium"
                : "px-1 py-2 bg-gray-100 rounded-lg flex-1 text-center text-xs font-medium";
            $btnStyle = $isToday ? 'style="background-color: #DBEFFE !important; color: #000000 !important;"' : 'style="background-color: #f8f9fa !important; color: #374151 !important;"';
        ?>
            <button 
                class="<?= $btnClasses ?> date-toggle" 
                data-date="<?= $date ?>" 
                <?= $isToday ? 'id="current-date"' : '' ?>
                <?= $btnStyle ?>>
                <div style="<?= $isToday ? 'color: #000000 !important;' : 'color: #374151 !important;' ?>"><?= $dayFull ?></div>
                <div style="<?= $isToday ? 'color: #000000 !important;' : 'color: #374151 !important;' ?>"><?= $dateFormatted ?></div>
                <?= $isToday ? '<div class="text-xs today-text" style="color: #000000 !important;">(Today)</div>' : '' ?>
            </button>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Meal slots -->

<div id="meal-slots" class="space-y-3">
    <?php if (isset($categories) && !empty($categories)) : ?>
        <?php foreach ($categories as $category) : ?>
            <div class="border border-gray-200 rounded-lg p-3 category-container" data-category="<?php echo htmlspecialchars($category['name']); ?>">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full flex items-center justify-center mr-3" style="background-color: #DBEFFE !important; color: #6B7280;">
                            <i data-fa-i2svg="">
                                <svg class="svg-inline--fa fa-utensils" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="utensils" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M416 0C400 0 288 32 288 176V288c0 35.3 28.7 64 64 64h32V480c0 17.7 14.3 32 32 32s32-14.3 32-32V352 240 32c0-17.7-14.3-32-32-32zM64 16C64 7.8 57.9 1 49.7 .1S34.2 4.6 32.4 12.5L2.1 148.8C.7 155.1 0 161.5 0 167.9c0 45.9 35.1 83.6 80 87.7V480c0 17.7 14.3 32 32 32s32-14.3 32-32V255.6c44.9-4.1 80-41.8 80-87.7c0-6.4-.7-12.8-2.1-19.1L191.6 12.5c-1.8-8-9.3-13.3-17.4-12.4S160 7.8 160 16V150.2c0 5.4-4.4 9.8-9.8 9.8c-5.1 0-9.3-3.9-9.8-9L127.9 14.6C127.2 6.3 120.3 0 112 0s-15.2 6.3-15.9 14.6L83.7 151c-.5 5.1-4.7 9-9.8 9c-5.4 0-9.8-4.4-9.8-9.8V16zm48.3 152l-.3 0-.3 0 .3-.7 .3 .7z"></path>
                                </svg>
                            </i>
                        </div>
                        <h3 class="font-semibold text-gray-800 text-sm"><?php echo htmlspecialchars($category['name']); ?></h3>
                    </div>
                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full"><?php echo isset($category['time_range']) ? $category['time_range'] : ''; ?></span>
                </div>
                <?php foreach ($currentWeekdateRange as $date) : ?>
                    <div class="space-y-4 dateWiseMenuPlanner" 
                         data-currentdate="<?php echo $date ?>" 
                         style="display: <?php echo $date === date('Y-m-d') ? 'block' : 'none'; ?>">
                        <?php
                        $hasMenus = false;
                        if (isset($savedMenuWithOptions[$date][$category['id']])) {
                            foreach ($menuLists as $menu) {
                                $menuId = $menu['menu_id'];
                                if (isset($savedMenuWithOptions[$date][$category['id']][$menuId])) {
                                    $hasMenus = true;
                                    ?>
                                    <!-- Modern Chef-Friendly Menu Card -->
                                    <div class="bg-gradient-to-r from-white to-gray-50 border border-gray-200 rounded-xl p-4 mb-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <!-- Menu Header (Icons Removed) -->
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center space-x-2">
                                                    <div>
                                                        <h4 class="font-bold text-gray-800 text-base"><?php echo htmlspecialchars($menu['menu_name']); ?></h4>
                                                        <p class="text-xs text-gray-500">Menu Item</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Modern Options Grid -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <?php
                                            foreach ($menu['menu_options'] as $menu_option) {
                                                if (in_array($menu_option['option_id'], $savedMenuWithOptions[$date][$category['id']][$menuId])) {
                                                    // Get calories from the individual menu option, not the menu category
                                                    $calories = htmlspecialchars($menu_option['menu_option_calorie'] ?? 'N/A');
                                                    $optionName = htmlspecialchars($menu_option['menu_option_name']);
                                                    ?>
                                                    <div class="bg-white border border-gray-100 rounded-lg p-3 flex items-center justify-between hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                                                        <div class="flex items-center space-x-2">
                                                            <span class="font-medium text-gray-800 text-sm"><?php echo $optionName; ?></span>
                                                            
                                                            <?php
                                                            // Get allergen names
                                                            $allergenNames = [];
                                                            if (!empty($menu_option['allergenValues'])) {
                                                                $allergenIds = json_decode($menu_option['allergenValues'], true);
                                                                if (is_array($allergenIds) && !empty($allergenIds) && isset($allergensData)) {
                                                                    foreach ($allergenIds as $allergenId) {
                                                                        foreach ($allergensData as $allergen) {
                                                                            if ($allergen['id'] == $allergenId) {
                                                                                $allergenNames[] = $allergen['name'];
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $allergenText = !empty($allergenNames) ? implode(', ', $allergenNames) : '';
                                                            
                                                            // Get cuisine type from option's cuisineValues
                                                            $cuisineNames = [];
                                                            if (!empty($menu_option['cuisineValues'])) {
                                                                $cuisineIds = json_decode($menu_option['cuisineValues'], true);
                                                                if (is_array($cuisineIds) && !empty($cuisineIds) && isset($cuisineData)) {
                                                                    foreach ($cuisineIds as $cuisineId) {
                                                                        foreach ($cuisineData as $cuisine) {
                                                                            if ($cuisine['id'] == $cuisineId) {
                                                                                $cuisineNames[] = $cuisine['name'];
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $cuisineText = !empty($cuisineNames) ? implode(', ', $cuisineNames) : '';
                                                            ?>
                                                            
                                                            <?php if (!empty($menu_option['menu_option_description']) && trim($menu_option['menu_option_description']) !== ''): ?>
                                                                <button type="button" 
                                                                        class="info-icon-btn w-4 h-4 bg-blue-100 hover:bg-blue-200 rounded-full flex items-center justify-center transition-colors duration-200 cursor-pointer ml-1"
                                                                        onclick="showMenuDescription('<?php echo htmlspecialchars(trim($menu_option['menu_option_description']), ENT_QUOTES); ?>')"
                                                                        onmouseover="showTooltip(this, '<?php echo htmlspecialchars(trim($menu_option['menu_option_description']), ENT_QUOTES); ?>')"
                                                                        onmouseout="hideTooltip()"
                                                                        title="Click to view description">
                                                                    <svg class="w-2.5 h-2.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <?php if (!empty($allergenText)): ?>
                                                                <button type="button" 
                                                                        class="allergen-icon-btn w-4 h-4 bg-red-100 hover:bg-red-200 rounded-full flex items-center justify-center transition-colors duration-200 cursor-pointer ml-1 text-red-600 text-xs font-bold"
                                                                        onclick="showAllergens('<?php echo htmlspecialchars($allergenText, ENT_QUOTES); ?>')"
                                                                        onmouseover="showTooltip(this, '<?php echo htmlspecialchars($allergenText, ENT_QUOTES); ?>')"
                                                                        onmouseout="hideTooltip()"
                                                                        title="Allergens: <?php echo htmlspecialchars($allergenText, ENT_QUOTES); ?>">
                                                                    A
                                                                </button>
                                                            <?php endif; ?>
                                                            
                                                            <?php if (!empty($cuisineText)): ?>
                                                                <button type="button" 
                                                                        class="cuisine-icon-btn w-4 h-4 bg-green-100 hover:bg-green-200 rounded-full flex items-center justify-center transition-colors duration-200 cursor-pointer ml-1 text-green-600 text-xs font-bold"
                                                                        onclick="showCuisine('<?php echo htmlspecialchars($cuisineText, ENT_QUOTES); ?>')"
                                                                        onmouseover="showTooltip(this, '<?php echo htmlspecialchars($cuisineText, ENT_QUOTES); ?>')"
                                                                        onmouseout="hideTooltip()"
                                                                        title="Cuisine Type: <?php echo htmlspecialchars($cuisineText, ENT_QUOTES); ?>">
                                                                    D
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex items-center space-x-1">
                                                            <span class="font-bold text-orange-600 text-sm"><?php echo $calories; ?></span>
                                                            <span class="text-orange-500 text-xs font-medium">cal</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        if (!$hasMenus) : ?>
                            <div class="text-center text-gray-500 text-sm">No menus available for this date</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="text-center text-gray-500 text-sm">No categories available</div>
    <?php endif; ?>
</div>

<!-- JavaScript for date toggling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateButtons = document.querySelectorAll('.date-toggle');
    const menuPlanners = document.querySelectorAll('.dateWiseMenuPlanner');

    dateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedDate = this.getAttribute('data-date');

            // Update button styles
            dateButtons.forEach(btn => {
                btn.classList.remove('bg-emerald-800', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-800');
                btn.style.backgroundColor = '#f3f4f6';
                btn.style.color = '#1f2937';
                // Update all text elements in unselected buttons
                const allDivs = btn.querySelectorAll('div');
                allDivs.forEach(div => {
                    div.style.color = '#1f2937'; // dark gray for light background
                });
            });
            this.classList.remove('bg-gray-100', 'text-gray-800');
            this.classList.add('bg-emerald-800', 'text-white');
            this.style.backgroundColor = '#065f46';
            this.style.color = 'white';
            // Update all text elements in selected button
            const selectedDivs = this.querySelectorAll('div');
            selectedDivs.forEach(div => {
                div.style.color = 'white'; // white for dark background
            });

            // Show/hide menu planners
            menuPlanners.forEach(planner => {
                if (planner.getAttribute('data-currentdate') === selectedDate) {
                    planner.style.display = 'grid';
                } else {
                    planner.style.display = 'none';
                }
            });
        });
    });

    // Trigger click on today's date button by default
    const todayButton = document.querySelector('#current-date');
    if (todayButton) {
        todayButton.click();
    }
});

// Filter functionality
function toggleFilterPanel() {
    const panel = document.getElementById('filter-panel');
    const button = document.querySelector('.filter-btn');
    
    if (panel.style.display === 'none' || panel.style.display === '') {
        panel.style.display = 'block';
        button.classList.remove('bg-gray-100', 'text-gray-600');
        button.classList.add('bg-emerald-800', 'text-white');
        button.style.backgroundColor = '#065f46';
        button.style.color = 'white';
    } else {
        panel.style.display = 'none';
        button.classList.remove('bg-emerald-800', 'text-white');
        button.classList.add('bg-gray-100', 'text-gray-600');
        button.style.backgroundColor = '';
        button.style.color = '';
    }
}

function applyFilters() {
    const filterDay = document.getElementById('filter-day').value;
    const filterMeal = document.getElementById('filter-meal').value;
    
    // Get all date buttons and menu planners
    const dateButtons = document.querySelectorAll('.date-toggle');
    const menuPlanners = document.querySelectorAll('.dateWiseMenuPlanner');
    const categoryContainers = document.querySelectorAll('.category-container');
    
    // Filter by day
    if (filterDay) {
        dateButtons.forEach(button => {
            const buttonDate = button.getAttribute('data-date');
            const buttonDayName = new Date(buttonDate).toLocaleDateString('en-US', { weekday: 'long' });
            
            if (buttonDayName === filterDay) {
                // Show this day
                button.style.display = 'block';
                // Click this button to show its content
                button.click();
            } else {
                // Hide other days
                button.style.display = 'none';
            }
        });
        
        // Hide menu planners for non-matching days
        menuPlanners.forEach(planner => {
            const plannerDate = planner.getAttribute('data-currentdate');
            const plannerDayName = new Date(plannerDate).toLocaleDateString('en-US', { weekday: 'long' });
            
            if (plannerDayName !== filterDay) {
                planner.style.display = 'none';
            }
        });
    } else {
        // Show all days
        dateButtons.forEach(button => {
            button.style.display = 'block';
        });
    }
    
    // Filter by meal type
    if (filterMeal) {
        categoryContainers.forEach(container => {
            const categoryName = container.querySelector('h3').textContent.trim().toUpperCase();
            
            if (categoryName.includes(filterMeal.toUpperCase())) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        });
    } else {
        // Show all meal types
        categoryContainers.forEach(container => {
            container.style.display = 'block';
        });
    }
    
    // Show feedback
    showFilterFeedback(filterDay, filterMeal);
}

function clearFilters() {
    // Reset all filter dropdowns
    document.getElementById('filter-day').value = '';
    document.getElementById('filter-meal').value = '';
    
    // Show all elements
    const dateButtons = document.querySelectorAll('.date-toggle');
    const categoryContainers = document.querySelectorAll('.category-container');
    
    dateButtons.forEach(button => {
        button.style.display = 'block';
    });
    
    categoryContainers.forEach(container => {
        container.style.display = 'block';
    });
    
    // Click today's button to reset view
    const todayButton = document.querySelector('#current-date');
    if (todayButton) {
        todayButton.click();
    }
    
    // Hide filter panel
    toggleFilterPanel();
    
    console.log('All filters cleared');
}

function showFilterFeedback(day, meal) {
    const filters = [];
    if (day) filters.push(`Day: ${day}`);
    if (meal) filters.push(`Meal: ${meal}`);
    
    if (filters.length > 0) {
        console.log('Filters applied:', filters.join(', '));
        
        // You could add a visual indicator here
        const filterButton = document.querySelector('.filter-btn');
        filterButton.innerHTML = `<i class="mr-1 fas fa-filter"></i> Filter (${filters.length})`;
    } else {
        const filterButton = document.querySelector('.filter-btn');
        filterButton.innerHTML = `<i class="mr-1 fas fa-filter"></i> Filter`;
    }
}
</script>


</div>


                </div>

                <!-- Right Column (Orders & Delivery) -->
                <div id="orders-delivery" class="w-full lg:w-1/3 order-2">
                    

                    <!-- Today's Orders -->
                    <div id="todays-orders" class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                        <div class="sidebar-header flex justify-between items-center">
                            <h3 class="text-white font-semibold flex items-center">
                                <i class="fa-solid fa-shopping-cart mr-2"></i>
                                Today's Orders - <?php echo date('d/m/Y'); ?>
                            </h3>
                            <button class="text-white hover:text-green-200">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="p-0">
                            <div class="overflow-x-auto">
                                <table class="sidebar-table">
                                    <thead>
                                        <tr>
                                            <th>Floor</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($todaysOrder) && !empty($todaysOrder)) {  ?>
                                        <?php foreach($todaysOrder as $order) {  ?>
                                        <?php 
                                        // Get the floor/department name
                                        $deptInfo = null;
                                        if (isset($departmentListData)) {
                                            foreach ($departmentListData as $dept) {
                                                if ($dept['id'] == $order['dept_id']) {
                                                    $deptInfo = $dept;
                                                    break;
                                                }
                                            }
                                        }
                                        $floorName = $deptInfo ? $deptInfo['name'] : 'Floor ' . $order['dept_id'];
                                        
                                        // Get dynamic status for this floor
                                        $deliveryStatus = $deptInfo['delivery_status'] ?? 'unknown';
                                        $deliveryDetails = $deptInfo['delivery_details'] ?? '';
                                        
                                        // Map status to display
                                        switch($deliveryStatus) {
                                            case 'delivered':
                                                $statusClass = 'bg-emerald-100 text-emerald-700';
                                                $statusText = 'Delivered';
                                                break;
                                            case 'ready_for_delivery':
                                                $statusClass = 'bg-blue-100 text-blue-700';
                                                $statusText = 'Ready for Delivery';
                                                break;
                                            case 'in_progress':
                                                $statusClass = 'bg-orange-100 text-orange-700';
                                                $statusText = 'In Progress';
                                                break;
                                            case 'not_started':
                                                $statusClass = 'bg-gray-100 text-gray-700';
                                                $statusText = 'Not Started';
                                                break;
                                            case 'unsent_orders':
                                                $statusClass = 'status-unsent';
                                                $statusText = 'Unsent Orders';
                                                break;
                                            case 'no_orders':
                                                $statusClass = 'bg-gray-50 text-gray-500';
                                                $statusText = 'No Orders';
                                                break;
                                            default:
                                                $statusClass = 'bg-yellow-100 text-yellow-700';
                                                $statusText = 'Pending';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($floorName); ?></td>
                                            <td>
                                                <span class="px-2 py-1 text-xs rounded-full <?php echo $statusClass; ?>" title="<?php echo htmlspecialchars($deliveryDetails); ?>">
                                                    <?php echo $statusText; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a class="view-details-link" href="<?php echo base_url('Orderportal/Order/viewOrderPatientwise/chef/'.$order['dept_id']) ?>">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }  ?>
                                         <?php }  ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 border-t border-gray-200">
                                <a class="production-form-btn text-decoration-none" href="<?php echo base_url('Orderportal/Order/viewProductionForm')  ?>">
                                    <i class="fa-solid fa-file-alt mr-2"></i>
                                    Production Form
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Labels -->
                    <div id="todays-delivery" class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                        <div class="sidebar-header flex justify-between items-center">
                            <h3 class="text-white font-semibold flex items-center">
                                <i class="fa-solid fa-truck mr-2"></i>
                                Today's Labels - <?php echo date('d/m/Y'); ?>
                            </h3>
                            <button class="text-white hover:text-green-200">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="p-0">
                            <div class="overflow-x-auto">
                                <table class="sidebar-table">
                                    <thead>
                                        <tr>
                                            <th>Floor</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($departmentListData) && !empty($departmentListData)) { ?>
                                        <?php foreach($departmentListData as $index => $department) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($department['name']); ?></td>
                                            <td>
                                                <?php 
                                                $status = $department['delivery_status'] ?? 'no_orders';
                                                $details = $department['delivery_details'] ?? 'No status available';
                                                
                                                // Set CSS classes and display text based on actual status
                                                switch($status) {
                                                    case 'delivered':
                                                        $cssClass = 'status-delivered';
                                                        $displayText = 'Delivered';
                                                        break;
                                                    case 'ready_for_delivery':
                                                        $cssClass = 'status-ready';
                                                        $displayText = 'Ready for Delivery';
                                                        break;
                                                    case 'in_progress':
                                                        $cssClass = 'status-in-progress';
                                                        $displayText = 'In Progress';
                                                        break;
                                                    case 'not_started':
                                                        $cssClass = 'status-not-started';
                                                        $displayText = 'Not Started';
                                                        break;
                                                    case 'unsent_orders':
                                                        $cssClass = 'status-unsent';
                                                        $displayText = 'Unsent Orders';
                                                        break;
                                                    case 'no_orders':
                                                        $cssClass = 'status-no-orders';
                                                        $displayText = 'No Orders';
                                                        break;
                                                    default:
                                                        $cssClass = 'status-in-transit';
                                                        $displayText = 'In Transit';
                                                }
                                                ?>
                                                <span class="px-3 py-1 text-xs font-medium rounded-full <?php echo $cssClass; ?>" 
                                                      title="<?php echo htmlspecialchars($details); ?>">
                                                    <?php echo $displayText; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a class="view-details-link" href="<?php echo base_url('Orderportal/Order/viewOrderPatientwise/delivery/'.$department['id']) ?>">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <tr>
                                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">No delivery data available</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        
        // Toggle menu sections
        function toggleSection(id) {
            const content = document.getElementById(id);
            const iconId = id.replace('content', 'icon');
            const icon = document.getElementById(iconId);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('transform', 'rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('transform', 'rotate-180');
            }
        }

        // Mobile menu toggle (only if button exists)
        const mobileMenuBtn = document.getElementById('mobile-menu-button');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const nav = document.querySelector('aside nav');
                if (nav) {
                    nav.classList.toggle('hidden');
                }
            });
        }
        
        // Simple functionality - no complex JavaScript needed

        // Simple tooltip and modal functions
        let tooltip = null;
        
        function showTooltip(element, description) {
            console.log('Showing tooltip:', description);
            
            if (!tooltip) {
                tooltip = document.createElement('div');
                tooltip.style.cssText = `
                    position: fixed;
                    background: rgba(0, 0, 0, 0.9) !important;
                    color: white !important;
                    padding: 8px 12px;
                    border-radius: 6px;
                    font-size: 12px;
                    z-index: 10000;
                    max-width: 250px;
                    word-wrap: break-word;
                    pointer-events: none;
                    font-family: Arial, sans-serif;
                    line-height: 1.4;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
                `;
                document.body.appendChild(tooltip);
            }
            
            const displayText = description.length > 80 ? 
                description.substring(0, 80) + '... (click for more)' : 
                description;
            
            // Ensure text is white
            tooltip.textContent = displayText;
            tooltip.style.color = 'white !important';
            tooltip.style.background = 'rgba(0, 0, 0, 0.9) !important';
            
            const rect = element.getBoundingClientRect();
            tooltip.style.left = (rect.left + rect.width / 2) + 'px';
            tooltip.style.top = (rect.top - 10) + 'px';
            tooltip.style.transform = 'translateX(-50%) translateY(-100%)';
            tooltip.style.display = 'block';
        }
        
        function hideTooltip() {
            if (tooltip) {
                tooltip.style.display = 'none';
            }
        }
        
        function showAllergens(allergens) {
            console.log('Showing allergens:', allergens);
            
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'allergen-modal-backdrop';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 20000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            `;
            
            const closeModal = function() {
                if (modal && modal.parentNode) {
                    modal.parentNode.removeChild(modal);
                }
            };
            
            modal.innerHTML = `
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 24px;
                    max-width: 500px;
                    width: 100%;
                    max-height: 80vh;
                    overflow-y: auto;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                ">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #dc2626;">Allergens</h3>
                        <button type="button" style="
                            background: none;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                            color: #6b7280;
                            padding: 0;
                            width: 24px;
                            height: 24px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">&times;</button>
                    </div>
                    <div style="color: #374151; line-height: 1.6; font-size: 14px;">
                        ${allergens || 'No allergens listed'}
                    </div>
                </div>
            `;
            
            // Add close button event listener
            const closeBtn = modal.querySelector('button');
            closeBtn.addEventListener('click', closeModal);
            
            modal.onclick = function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            };
            
            document.body.appendChild(modal);
        }
        
        function showCuisine(cuisine) {
            console.log('Showing cuisine:', cuisine);
            
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'cuisine-modal-backdrop';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 20000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            `;
            
            const closeModal = function() {
                if (modal && modal.parentNode) {
                    modal.parentNode.removeChild(modal);
                }
            };
            
            modal.innerHTML = `
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 24px;
                    max-width: 500px;
                    width: 100%;
                    max-height: 80vh;
                    overflow-y: auto;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                ">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #16a34a;">Cuisine Type</h3>
                        <button type="button" style="
                            background: none;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                            color: #6b7280;
                            padding: 0;
                            width: 24px;
                            height: 24px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">&times;</button>
                    </div>
                    <div style="color: #374151; line-height: 1.6; font-size: 14px;">
                        ${cuisine || 'No cuisine type listed'}
                    </div>
                </div>
            `;
            
            // Add close button event listener
            const closeBtn = modal.querySelector('button');
            closeBtn.addEventListener('click', closeModal);
            
            modal.onclick = function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            };
            
            document.body.appendChild(modal);
        }
        
        function showMenuDescription(description) {
            console.log('Showing modal:', description);
            
            // Create modal
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 20000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            `;
            
            const closeModal = function() {
                if (modal && modal.parentNode) {
                    modal.parentNode.removeChild(modal);
                }
            };
            
            modal.innerHTML = `
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 24px;
                    max-width: 500px;
                    width: 100%;
                    max-height: 80vh;
                    overflow-y: auto;
                    position: relative;
                ">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                        <h3 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0;">Menu Item Description</h3>
                        <button type="button" style="
                            background: none;
                            border: none;
                            font-size: 24px;
                            color: #6b7280;
                            cursor: pointer;
                            padding: 4px;
                            line-height: 1;
                        ">&times;</button>
                    </div>
                    <div style="color: #374151; line-height: 1.6; font-size: 14px;">${description}</div>
                </div>
            `;
            
            modal.className = 'description-modal-backdrop';
            
            // Add close button event listener
            const closeBtn = modal.querySelector('button');
            closeBtn.addEventListener('click', closeModal);
            
            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            document.body.appendChild(modal);
        }

        // Auto-refresh chef dashboard every 15 minutes
        function scheduleAutoRefresh() {
            const refreshInterval = 15 * 60 * 1000; // 15 minutes in milliseconds
            
            // Set interval to refresh every 15 minutes
            setInterval(function() {
                // Show toast notification before refresh
                showAutoRefreshToast();
                
                // Wait 3 seconds, then reload
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }, refreshInterval);
        }
        
        // Function to show auto-refresh toast notification
        function showAutoRefreshToast() {
            // Create toast element
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #3b82f6;
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 12px;
                animation: slideIn 0.3s ease-out;
            `;
            
            toast.innerHTML = `
                <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <div>
                    <div style="font-weight: 600; margin-bottom: 4px;">Auto-Refresh in Progress</div>
                    <div style="font-size: 14px; opacity: 0.9;">Dashboard will reload in 3 seconds...</div>
                </div>
            `;
            
            // Add animation styles if not already present
            if (!document.getElementById('toast-animation-styles')) {
                const style = document.createElement('style');
                style.id = 'toast-animation-styles';
                style.textContent = `
                    @keyframes slideIn {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes spin {
                        to { transform: rotate(360deg); }
                    }
                    .animate-spin {
                        animation: spin 1s linear infinite;
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Append to body
            document.body.appendChild(toast);
        }
        
        // Initialize auto-refresh on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                scheduleAutoRefresh();
            });
        } else {
            scheduleAutoRefresh();
        }

        // ============================================
        // LATE ORDER NOTIFICATION SYSTEM (DATABASE-BACKED)
        // ============================================
        
        // Global variable to cache dismissed suites from database
        let dismissedSuitesCache = {};

        // Load dismissed suites from database
        async function loadDismissedSuitesFromDB() {
            try {
                const response = await fetch('<?php echo base_url('Orderportal/Order/getDismissedSuites'); ?>');
                const data = await response.json();
                
                if (data.success) {
                    dismissedSuitesCache = data.dismissals || {};
                    return dismissedSuitesCache;
                } else {
                    return {};
                }
            } catch (error) {
                return {};
            }
        }

        // Save dismissed suites to database
        async function saveDismissedSuitesToDB(lateOrders) {
            try {
                const response = await fetch('<?php echo base_url('Orderportal/Order/saveDismissedSuites'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ lateOrders: lateOrders })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    console.log(`✅ Dismissed ${data.inserted || 0} suite(s) successfully`);
                    // ✅ CRITICAL FIX: Update cache IMMEDIATELY and wait for it to complete
                    // This ensures dismissed suites are loaded before next check runs
                    await loadDismissedSuitesFromDB();
                    console.log('✅ Dismissed suites cache refreshed');
                } else {
                    console.error('❌ Failed to save dismissed suites:', data.error);
                }
            } catch (error) {
                console.error('❌ Error saving dismissed suites:', error);
            }
        }

        // Check for late orders and show notification
        async function checkAndShowLateOrders() {
            // ✅ CRITICAL FIX: Always reload dismissed suites from database before checking
            // This ensures we have the latest dismissal data, even if cache was stale
            const dismissed = await loadDismissedSuitesFromDB();
            console.log('📋 Loaded dismissed suites:', Object.keys(dismissed).length, 'orders');
            
            fetch('<?php echo base_url('Orderportal/Order/checkLateOrders'); ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success === false) {
                    return;
                }
                
                if (data.success && data.hasLateOrders) {
                    // dismissed is already loaded at the start of the async function
                    
                    // Filter at SUITE level - only show NEW or MODIFIED suites since last dismissal
                    const newLateOrders = [];
                    
                    data.lateOrders.forEach(order => {
                        const dismissedSuites = dismissed[order.order_id] || {};
                        
                        // Filter suites: only show if not dismissed OR modified after dismissal
                        const newSuites = order.suites.filter(suite => {
                            const dismissedTime = dismissedSuites[suite.suite_number];
                            
                            // ✅ CRITICAL FIX: Normalize times for comparison (trim whitespace, handle null/undefined)
                            const normalizedDismissedTime = dismissedTime ? String(dismissedTime).trim() : null;
                            const normalizedSuiteTime = suite.time ? String(suite.time).trim() : null;
                            
                            // Show suite if:
                            // 1. Never dismissed before (no dismissedTime), OR
                            // 2. Activity time is DIFFERENT (indicating modification after dismissal)
                            // 
                            // IMPORTANT: If dismissedTime exists and matches suite.time, suite was already dismissed.
                            // Only show again if time changed (suite was updated after dismissal).
                            const isNew = !normalizedDismissedTime || normalizedDismissedTime !== normalizedSuiteTime;
                            
                            if (isNew) {
                                if (normalizedDismissedTime) {
                                    console.log(`  ✓ Suite ${suite.suite_number} is modified after dismissal (dismissed: ${normalizedDismissedTime}, current: ${normalizedSuiteTime})`);
                                } else {
                                    console.log(`  ✓ Suite ${suite.suite_number} is new/modified (action: ${suite.action})`);
                                }
                            } else {
                                console.log(`  ⏭️ Suite ${suite.suite_number} already dismissed at ${normalizedDismissedTime} (matches current time: ${normalizedSuiteTime})`);
                            }
                            
                            return isNew;
                        });
                        
                        // Only include order if it has new/modified suites
                        if (newSuites.length > 0) {
                            newLateOrders.push({
                                ...order,
                                suites: newSuites,
                                total_late_suites: newSuites.length
                            });
                        }
                    });
                    
                    if (newLateOrders.length > 0) {
                        // ✅ CRITICAL FIX: Check if modal already exists before showing
                        // Also check if modal is visible (not just exists in DOM)
                        const existingModal = document.getElementById('late-order-alert-modal');
                        const isModalVisible = existingModal && existingModal.offsetParent !== null;
                        
                        if (!existingModal || !isModalVisible) {
                            // Remove any stale modal first
                            if (existingModal) {
                                existingModal.remove();
                            }
                            console.log(`🚨 Showing alert for ${newLateOrders.length} late orders`);
                            showLateOrderAlert(newLateOrders, data.cutoffTime);
                        } else {
                            console.log('⏭️ Late order alert already visible, skipping duplicate');
                        }
                    } else {
                        console.log('ℹ️ No new late orders to show (all dismissed)');
                        // ✅ CRITICAL FIX: Remove modal if no new late orders (all dismissed)
                        const existingModal = document.getElementById('late-order-alert-modal');
                        if (existingModal) {
                            existingModal.remove();
                        }
                    }
                }
            })
            .catch(error => {
                // Silent error handling
            });
        }

        // Show flashing alert with sound for late orders
        function showLateOrderAlert(lateOrders, cutoffTime) {
            // ✅ CRITICAL FIX: Prevent showing multiple modals at once
            // Check if modal already exists and is visible - if so, don't show another one
            const existingModal = document.getElementById('late-order-alert-modal');
            const isModalVisible = existingModal && existingModal.offsetParent !== null;
            
            if (existingModal && isModalVisible) {
                console.log('⏭️ Late order alert modal already visible, skipping duplicate');
                return;
            }
            
            // Remove any stale/hidden modal before creating new one
            if (existingModal) {
                existingModal.remove();
            }
            // Create continuous siren sound
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            let sirenOscillator = null;
            let sirenGainNode = null;
            let sirenAnimationFrame = null;
            let sirenStartTime = null;
            let voiceInterval = null;
            
            function startSiren() {
                // Create oscillator for siren
                sirenOscillator = audioContext.createOscillator();
                sirenGainNode = audioContext.createGain();
                
                sirenOscillator.connect(sirenGainNode);
                sirenGainNode.connect(audioContext.destination);
                
                sirenOscillator.type = 'sine';
                sirenGainNode.gain.value = 0.25; // Volume level
                
                sirenStartTime = audioContext.currentTime;
                sirenOscillator.start();
                
                // Create frequency modulation for siren effect (rising and falling pitch)
                function updateSirenFrequency() {
                    if (!sirenOscillator) return;
                    
                    const currentTime = audioContext.currentTime - sirenStartTime;
                    // Siren pattern: frequency oscillates between 600Hz and 1200Hz
                    // Cycle every 1 second (rising for 0.5s, falling for 0.5s)
                    const cycleTime = currentTime % 1.0;
                    let frequency;
                    
                    if (cycleTime < 0.5) {
                        // Rising: 600Hz to 1200Hz
                        frequency = 600 + (cycleTime / 0.5) * 600;
                    } else {
                        // Falling: 1200Hz to 600Hz
                        frequency = 1200 - ((cycleTime - 0.5) / 0.5) * 600;
                    }
                    
                    sirenOscillator.frequency.setValueAtTime(frequency, audioContext.currentTime);
                    sirenAnimationFrame = requestAnimationFrame(updateSirenFrequency);
                }
                
                updateSirenFrequency();
            }
            
            function speakLateOrder() {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance('Late order');
                    utterance.volume = 0.8;
                    utterance.rate = 0.9;
                    utterance.pitch = 1.0;
                    // Try to use a more alert-like voice
                    const voices = speechSynthesis.getVoices();
                    // Prefer female voices for better alert sound
                    const preferredVoice = voices.find(voice => 
                        voice.name.includes('Female') || 
                        voice.name.includes('Karen') || 
                        voice.name.includes('Samantha') ||
                        voice.name.includes('Victoria')
                    ) || voices.find(voice => voice.lang.startsWith('en'));
                    if (preferredVoice) {
                        utterance.voice = preferredVoice;
                    }
                    speechSynthesis.speak(utterance);
                }
            }
            
            function startVoiceAnnouncement() {
                // Speak immediately
                speakLateOrder();
                // Then repeat every 3 seconds
                voiceInterval = setInterval(speakLateOrder, 3000);
            }
            
            function stopSiren() {
                if (sirenAnimationFrame) {
                    cancelAnimationFrame(sirenAnimationFrame);
                    sirenAnimationFrame = null;
                }
                if (sirenOscillator) {
                    try {
                        sirenOscillator.stop();
                    } catch(e) {}
                    sirenOscillator = null;
                }
                if (sirenGainNode) {
                    try {
                        sirenGainNode.disconnect();
                    } catch(e) {}
                    sirenGainNode = null;
                }
                // Stop voice announcement
                if (voiceInterval) {
                    clearInterval(voiceInterval);
                    voiceInterval = null;
                }
                if ('speechSynthesis' in window) {
                    speechSynthesis.cancel();
                }
            }
            
            // Start continuous siren sound
            startSiren();
            
            // Start voice announcement
            // Wait for voices to load if needed
            if ('speechSynthesis' in window) {
                if (speechSynthesis.onvoiceschanged !== undefined) {
                    speechSynthesis.onvoiceschanged = () => {
                        startVoiceAnnouncement();
                    };
                } else {
                    startVoiceAnnouncement();
                }
            }
            
            // Group orders by type
            const todaysOrders = lateOrders.filter(o => o.type === 'today');
            const tomorrowsOrders = lateOrders.filter(o => o.type === 'tomorrow');
            
            // Build order list HTML with suite-level details
            let orderListHTML = '';
            
            if (todaysOrders.length > 0) {
                const totalSuites = todaysOrders.reduce((sum, order) => sum + order.total_late_suites, 0);
                // 🔧 FIX: Use the actual order date instead of system date
                const orderDate = todaysOrders[0].date; // Get date from first order (all are same date)
                const todayDate = new Date(orderDate).toLocaleDateString('en-AU', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
                orderListHTML += `
                    <div style="margin-bottom: 20px;">
                        <div style="background: #dc2626; color: white; padding: 12px; border-radius: 8px; font-size: 18px; font-weight: bold; margin-bottom: 12px; text-align: center;">
                            🚨 ${totalSuites} LATE SUITE ORDER${totalSuites > 1 ? 'S' : ''} FOR TODAY<br>
                            <span style="font-size: 14px; font-weight: normal; margin-top: 4px; display: inline-block;">${todayDate}</span>
                        </div>
                        ${todaysOrders.map(order => `
                            <div style="background: #fee2e2; border: 2px solid #dc2626; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                                <div style="background: white; padding: 10px; border-radius: 6px; margin-bottom: 8px; border-left: 4px solid #dc2626;">
                                    <strong style="font-size: 18px; color: #dc2626;">📍 ${order.floor}</strong>
                                    <span style="font-size: 14px; color: #666; margin-left: 10px;">(${order.total_late_suites} suite${order.total_late_suites > 1 ? 's' : ''} after ${cutoffTime})</span>
                                </div>
                                ${order.suites.map(suite => `
                                    <div style="background: white; padding: 8px 12px; margin-bottom: 6px; border-radius: 4px; border-left: 3px solid ${suite.action === 'NEW ORDER' ? '#dc2626' : '#f59e0b'};">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                            <div>
                                                <span style="font-size: 16px; font-weight: bold; color: #1f2937;">Suite ${suite.suite_number}</span>
                                                <span style="margin-left: 10px; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; background: ${suite.action === 'NEW ORDER' ? '#dc2626' : '#f59e0b'}; color: white;">
                                                    ${suite.action}
                                                </span>
                                            </div>
                                            <div style="text-align: right; font-size: 13px; color: #666;">
                                                <div style="font-size: 11px;">by ${suite.by}</div>
                                            </div>
                                        </div>
                                        ${suite.items && suite.items.length > 0 ? `
                                            <div style="background: #fef2f2; padding: 8px; border-radius: 4px; margin-top: 6px; border: 1px solid #fecaca;">
                                                <div style="font-size: 12px; font-weight: bold; color: #dc2626; margin-bottom: 4px;">📋 Items Ordered:</div>
                                                ${suite.items.map(item => `
                                                    <div style="font-size: 12px; color: #374151; padding: 2px 0; padding-left: 10px;">
                                                        • <strong>${item.item_name}</strong> ${item.quantity > 1 ? `(×${item.quantity})` : ''} 
                                                        <span style="color: #6b7280; font-size: 10px;">[${item.category}]</span>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        ` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `).join('')}
                    </div>
                `;
            }
            
            if (tomorrowsOrders.length > 0) {
                const totalSuites = tomorrowsOrders.reduce((sum, order) => sum + order.total_late_suites, 0);
                // 🔧 FIX: Use the actual order date instead of system date
                const orderDate = tomorrowsOrders[0].date; // Get date from first order (all are same date)
                const tomorrowDate = new Date(orderDate).toLocaleDateString('en-AU', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
                orderListHTML += `
                    <div style="margin-bottom: 20px;">
                        <div style="background: #ea580c; color: white; padding: 12px; border-radius: 8px; font-size: 18px; font-weight: bold; margin-bottom: 12px; text-align: center;">
                            ⚠️ ${totalSuites} LATE SUITE ORDER${totalSuites > 1 ? 'S' : ''} FOR TOMORROW<br>
                            <span style="font-size: 14px; font-weight: normal; margin-top: 4px; display: inline-block;">${tomorrowDate}</span>
                        </div>
                        ${tomorrowsOrders.map(order => `
                            <div style="background: #fff7ed; border: 2px solid #ea580c; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                                <div style="background: white; padding: 10px; border-radius: 6px; margin-bottom: 8px; border-left: 4px solid #ea580c;">
                                    <strong style="font-size: 18px; color: #ea580c;">📍 ${order.floor}</strong>
                                    <span style="font-size: 14px; color: #666; margin-left: 10px;">(${order.total_late_suites} suite${order.total_late_suites > 1 ? 's' : ''} after ${cutoffTime})</span>
                                </div>
                                ${order.suites.map(suite => `
                                    <div style="background: white; padding: 8px 12px; margin-bottom: 6px; border-radius: 4px; border-left: 3px solid ${suite.action === 'NEW ORDER' ? '#ea580c' : '#f97316'};">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                            <div>
                                                <span style="font-size: 16px; font-weight: bold; color: #1f2937;">Suite ${suite.suite_number}</span>
                                                <span style="margin-left: 10px; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; background: ${suite.action === 'NEW ORDER' ? '#ea580c' : '#f97316'}; color: white;">
                                                    ${suite.action}
                                                </span>
                                            </div>
                                            <div style="text-align: right; font-size: 13px; color: #666;">
                                                <div style="font-size: 11px;">by ${suite.by}</div>
                                            </div>
                                        </div>
                                        ${suite.items && suite.items.length > 0 ? `
                                            <div style="background: #fff7ed; padding: 8px; border-radius: 4px; margin-top: 6px; border: 1px solid #ffedd5;">
                                                <div style="font-size: 12px; font-weight: bold; color: #ea580c; margin-bottom: 4px;">📋 Items Ordered:</div>
                                                ${suite.items.map(item => `
                                                    <div style="font-size: 12px; color: #374151; padding: 2px 0; padding-left: 10px;">
                                                        • <strong>${item.item_name}</strong> ${item.quantity > 1 ? `(×${item.quantity})` : ''} 
                                                        <span style="color: #6b7280; font-size: 10px;">[${item.category}]</span>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        ` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `).join('')}
                    </div>
                `;
            }
            
            // Create modal overlay
            const modal = document.createElement('div');
            modal.id = 'late-order-alert-modal';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.85);
                z-index: 99999;
                display: flex;
                justify-content: center;
                align-items: center;
                animation: flashBackground 1s infinite;
            `;
            
            // Create modal content
            const modalContent = document.createElement('div');
            modalContent.style.cssText = `
                background: white;
                border-radius: 16px;
                padding: 32px;
                max-width: 700px;
                width: 90%;
                max-height: 85vh;
                overflow-y: auto;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                animation: pulseScale 1s infinite;
            `;
            
            modalContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="font-size: 64px; margin-bottom: 16px; animation: shake 0.5s infinite;">⚠️</div>
                    <h1 style="font-size: 32px; font-weight: bold; color: #dc2626; margin: 0; text-transform: uppercase;">
                        LATE ORDER ALERT!
                    </h1>
                    <p style="font-size: 16px; color: #666; margin-top: 8px;">
                        Suite orders placed/updated after ${cutoffTime}
                    </p>
                </div>
                
                ${orderListHTML}
                
                <div style="text-align: center; margin-top: 24px;">
                    <button id="dismiss-late-orders-btn" style="
                        background: #dc2626;
                        color: white;
                        border: none;
                        padding: 16px 48px;
                        border-radius: 8px;
                        font-size: 18px;
                        font-weight: bold;
                        cursor: pointer;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        transition: all 0.3s;
                    ">
                        ✓ OK - I'VE NOTED ALL LATE SUITES
                    </button>
                </div>
            `;
            
            modal.appendChild(modalContent);
            document.body.appendChild(modal);
            
            // Add animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes flashBackground {
                    0%, 100% { background: rgba(0, 0, 0, 0.85); }
                    50% { background: rgba(220, 38, 38, 0.3); }
                }
                
                @keyframes pulseScale {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.02); }
                }
                
                @keyframes shake {
                    0%, 100% { transform: rotate(0deg); }
                    25% { transform: rotate(-10deg); }
                    75% { transform: rotate(10deg); }
                }
                
                #dismiss-late-orders-btn:hover {
                    background: #991b1b !important;
                    transform: scale(1.05);
                }
            `;
            document.head.appendChild(style);
            
            // Handle dismiss button
            document.getElementById('dismiss-late-orders-btn').addEventListener('click', async function() {
                // Stop the continuous siren sound
                stopSiren();
                
                // ✅ CRITICAL FIX: Save dismissed suites and wait for completion
                await saveDismissedSuitesToDB(lateOrders);
                
                // ✅ CRITICAL FIX: Remove modal and style, and mark as dismissed
                modal.remove();
                style.remove();
                
                // ✅ CRITICAL FIX: Clear any intervals to prevent re-showing
                if (voiceInterval) {
                    clearInterval(voiceInterval);
                    voiceInterval = null;
                }
                
                console.log('✅ Late order alert dismissed and saved to database');
            });
        }

        // ✅ ENABLED: Late orders notification
        // Check for late orders immediately on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(checkAndShowLateOrders, 2000);
            });
        } else {
            setTimeout(checkAndShowLateOrders, 2000);
        }

        // ✅ ENABLED: Schedule late order checks every 2 minutes
        function scheduleLateOrderChecks() {
            const lateOrderCheckInterval = 2 * 60 * 1000; // 2 minutes in milliseconds
            setInterval(function() {
                // ✅ CRITICAL FIX: Don't check if modal is already visible
                const existingModal = document.getElementById('late-order-alert-modal');
                const isModalVisible = existingModal && existingModal.offsetParent !== null;
                if (!isModalVisible) {
                    checkAndShowLateOrders();
                } else {
                    console.log('⏸️ Skipping late order check - modal already visible');
                }
            }, lateOrderCheckInterval);
            console.log('✅ Late orders check is enabled (checking every 2 minutes)');
        }

        // Initialize late order checks on page load (separate from refresh cycle)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                scheduleLateOrderChecks();
            });
        } else {
            scheduleLateOrderChecks();
        }

    </script>
</body></html>
