<script src="https://cdn.tailwindcss.com"></script>
    <script> window.FontAwesomeConfig = { autoReplaceSvg: 'nest'};</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { display: none;}
        
        /* Print styles */
        @media print {
            /* Remove browser default headers and footers */
            @page {
                margin: 0.5cm;
            }
            
            body { 
                font-size: 12px;
                margin: 0;
                padding: 0;
            }
            
            .no-print { display: none !important; }
            .hide-for-print { display: none !important; }
            #header { padding: 1rem 1.5rem !important; margin-top: 0 !important; page-break-after: avoid; }
            #header h1 { font-size: 22px !important; }
            #print-category-title { display: block !important; border-bottom: 3px solid #000; margin-bottom: 20px; padding: 10px 0; page-break-after: avoid; }
            #print-category-title h2 { font-size: 28px; font-weight: bold; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
            #main-content { grid-template-columns: 1fr !important; }
            .bg-white { background: white !important; }
            .shadow-sm { box-shadow: none !important; }
            .border { border: 1px solid #e5e7eb !important; }
            .rounded-lg { border-radius: 0 !important; }
            .max-h-\[calc\(100vh-260px\)\] { max-height: none !important; }
            .max-h-\[calc\(100vh-320px\)\] { max-height: none !important; }
            .overflow-y-auto { overflow: visible !important; }
            .overflow-auto { overflow: visible !important; }
            .grid-cols-1 { grid-template-columns: 1fr !important; }
            .md\:grid-cols-2 { grid-template-columns: 1fr !important; }
            .px-6 { padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
            .py-4 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        }
        
        /* Item completed styling */
        .item-completed {
            background-color: #f0f9ff !important;
            border-left: 3px solid #10b981 !important;
            opacity: 0.9;
        }
        
        /* 🔧 HIDE count badges in production form - keep logic for future use */
        .progress-circle-container,
        .simple-number-container {
            display: none !important;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kitchen: {
                            primary: '#16a399',
                            secondary: '#0d7c76',
                            light: '#e6f7f6',
                            dark: '#064e4a'
                        },
                        status: {
                            notStarted: '#f3f4f6',
                            inProgress: '#fef3c7',
                            complete: '#d1fae5'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- ✅ CRITICAL FIX: Define handleProductionDateChange EARLY in a separate script block -->
    <!-- This ensures it's available before the HTML element with onchange handler is rendered -->
    <script>
        function handleProductionDateChange(newDate) {
            if (!newDate) return;
            
            // Redirect to the production form with the new date
            window.location.href = '<?php echo base_url('Orderportal/Order/viewProductionForm/'); ?>' + newDate;
        }
    </script>

  <header id="header" class="bg-white border-b border-gray-200 px-6 py-4 mt-5 flex justify-between items-center">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800"> Production Form</h1>
            <div class="ml-6 flex items-center text-gray-600">
                <i class="mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-calendar" aria-hidden="true" focusable="false" data-prefix="far" data-icon="calendar" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg></i>
                <span class="font-medium"><?php $this->load->helper('custom'); echo format_australia_date($selectedDate, 'l, F d, Y'); ?></span>
            </div>
        </div>
        <div class="flex items-center gap-3 no-print">
            <!-- Date Picker -->
            <div class="flex items-center bg-gray-100 rounded-lg px-4 py-2 gap-2.5">
                <i class="fas fa-calendar text-gray-600"></i>
                <span class="text-sm font-medium text-gray-700 whitespace-nowrap">Select Date:</span>
                <input type="date" 
                       id="production-date-picker" 
                       class="px-3 py-1.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-kitchen-primary focus:border-kitchen-primary text-sm font-medium text-gray-800 cursor-pointer bg-white"
                       min="<?php $this->load->helper('custom'); echo get_australia_date(); ?>"
                       max="<?php echo get_australia_date_offset(7); ?>"
                       value="<?php echo $selectedDate; ?>"
                       onkeydown="return false;"
                       onchange="handleProductionDateChange(this.value)">
            </div>
            
            <button onclick="showLateOrdersSummary()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md flex items-center transition duration-200">
                <i class="fas fa-clock mr-2"></i>
                Late Orders Summary
            </button>
            
            
            <button onclick="openSuiteSummary()"
    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition duration-200">
    <i class="fas fa-list mr-2"></i>
    View Summary
</button>

            
            <button onclick="printProductionForm()" class="bg-kitchen-primary hover:bg-kitchen-secondary text-white px-4 py-2 rounded-md flex items-center transition duration-200">
                <i class="mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-print" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93-3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"></path></svg></i>
                Print 
            </button>
        </div>
    </header>
    
    <!-- Metrics Section -->
    <div class="px-6 py-4 bg-gray-50 no-print">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Total Patients -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-700 mb-1">Total Patients</p>
                        <p class="text-3xl font-bold text-blue-900"><?php echo $metrics['total_patients']; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Suites With Orders -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-700 mb-1">Orders Placed</p>
                        <p class="text-3xl font-bold text-green-900"><?php echo $metrics['suites_with_orders']; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Suites Without Orders -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-orange-700 mb-1">No Orders Yet</p>
                        <p class="text-3xl font-bold text-orange-900"><?php echo $metrics['suites_without_orders']; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Occupied Suites -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-purple-700 mb-1">Occupied Suites</p>
                        <p class="text-3xl font-bold text-purple-900"><?php echo $metrics['occupied_suites']; ?></p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-bed text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Read-Only Banner for Future Dates -->
    <?php if (isset($isReadOnly) && $isReadOnly): ?>
    <div class="px-6 py-3 bg-blue-50 border-b border-blue-200 no-print">
        <div class="flex items-center justify-center gap-2 text-blue-800">
            <i class="fas fa-info-circle"></i>
            <span class="font-semibold">Viewing Tomorrow's Orders - Read-Only Mode</span>
            <span class="text-sm">(Mark Complete is disabled for future dates)</span>
        </div>
    </div>
    <?php endif; ?>

    <!-- Meal Tabs Navigation -->
    <div id="meal-tabs" class="bg-white px-6 py-4 border-b border-gray-200 no-print">
        <div class="flex space-x-2">
            <?php foreach ($categories as $index => $category): ?>
                <button class="meal-tab px-6 py-2 rounded-full <?php echo $index === 0 ? 'bg-kitchen-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?> font-medium transition duration-200" data-category-id="<?php echo $category['id']; ?>" data-category-name="<?php echo htmlspecialchars($category['name']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Print-only Category Title (Hidden on screen, shown in print) -->
    <div id="print-category-title" class="hidden print:block px-6 py-4 border-b-2 border-gray-800" style="display: none;">
        <h2 class="text-2xl font-bold text-gray-900"></h2>
    </div>

    <!-- Main Content Grid - Full width (Special Order Notes section hidden) -->
    <div id="main-content" class="px-6 py-4 grid grid-cols-1 gap-5">
        <!-- Left Panel: Dish Summary -->
        <div id="dish-summary" class="bg-white rounded-lg shadow-sm">
            
            <div class="p-2 space-y-2">
                <?php
                $card_index = 1;
                $hasOrders = false;
                foreach ($categories as $category) {
                    // FIXED: Flatten hierarchical structure (category > subcategory > items) for view compatibility
                    if (!isset($orders[$category['id']]) || empty($orders[$category['id']])) {
                        // Show empty category with 0 quantity
                        $items = [];
                        $subcategories = [];
                        $total_qty = 0;
                        $completed_total_qty = 0;
                        $all_total_qty = 0;
                    } else {
                        $categoryData = $orders[$category['id']];
                        $subcategories = $categoryData['subcategories'] ?? [];
                        
                        // Flatten all items from all subcategories for total calculations
                        $items = [];
                        foreach ($subcategories as $subcatName => $subcatData) {
                            foreach ($subcatData['items'] as $item) {
                                $items[] = $item;
                            }
                        }
                        
                        $total_qty = array_sum(array_column($items, 'qty')); // Pending quantity
                        $completed_total_qty = array_sum(array_column($items, 'completed_qty')); // Completed quantity
                        $all_total_qty = array_sum(array_column($items, 'all_qty')); // Total quantity
                        
                        $hasOrders = true;
                    }
                    
                    // FIXED: Dynamic status based on actual order completion
                    if (empty($items)) {
                        $status = 'notStarted';
                    } else {
                        // Check completion status for this category
                        $hasPendingItems = false;
                        $hasCompletedItems = false;
                        
                        foreach ($items as $item) {
                            if ($item['qty'] > 0) {
                                $hasPendingItems = true;
                            }
                            if ($item['completed_qty'] > 0) {
                                $hasCompletedItems = true;
                            }
                        }
                        
                        if ($hasPendingItems) {
                            $status = $hasCompletedItems ? 'inProgress' : 'inProgress';
                        } else {
                            $status = $hasCompletedItems ? 'complete' : 'notStarted';
                        }
                    }
                    $status_colors = [
                        'complete' => 'bg-status-complete text-green-800',
                        'inProgress' => 'bg-status-inProgress text-yellow-800',
                        'notStarted' => 'bg-status-notStarted text-gray-600'
                    ];
                    $display = $card_index === 1 ? '' : 'hidden';
                    ?>
                    <div id="dish-group-<?php echo $category['id']; ?>" class="dish-group <?php echo $display; ?>" data-category-id="<?php echo $category['id']; ?>">
                        <div id="dish-card-<?php echo $card_index; ?>" class="border border-gray-200 rounded-lg hover:shadow-md transition duration-200">
                            <div class="p-4 flex justify-between items-center cursor-pointer" >
                                <div>
                                    <div class="flex items-center">
                                        <!-- Removed meal time category display as we now show menu categories on individual items -->
                                        <?php
                                        foreach ($items as $item) {
                                            $name = strtolower($item['menu_option_name']);
                                           
                                        }
                                        ?>
                                    </div>
                                    <div class="flex mt-1 space-x-2">
                                        <span class="px-3 py-1 <?php echo $status_colors[$status]; ?> text-xs rounded-full font-medium">
                                            <?php echo ucfirst(str_replace('notStarted', 'Not Started', $status)); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <!-- Progress Container (with completed/total) - Hidden when no completed items -->
                                    <div class="progress-circle-container relative w-16 h-16 flex items-center justify-center mr-3" style="<?php echo $completed_total_qty > 0 ? '' : 'display: none;'; ?>">
                                        <!-- Background shadow circle for depth -->
                                        <div class="absolute inset-0 bg-gray-100 rounded-full shadow-inner"></div>
                                        
                                        <!-- SVG Circle (without green progress) -->
                                        <svg class="w-14 h-14 transform -rotate-90 relative z-10" viewBox="0 0 56 56">
                                            <!-- Background circle only -->
                                            <circle cx="28" cy="28" r="24" stroke="#f1f5f9" stroke-width="4" fill="none"/>
                                        </svg>
                                        
                                        <!-- Center content -->
                                        <div class="absolute inset-0 flex flex-col items-center justify-center z-20">
                                            <span class="text-sm font-black text-gray-800 leading-none"><?php echo $completed_total_qty; ?></span>
                                            <div class="w-3 h-0.5 bg-gray-300 rounded-full my-0.5"></div>
                                            <span class="text-xs font-bold text-gray-500 leading-none"><?php echo ($total_qty + $completed_total_qty); ?></span>
                                        </div>
                                        
                                        <!-- Completion percentage badge -->
                                        <?php 
                                        if ($completed_total_qty > 0) {
                                            $percentage = ($completed_total_qty / ($total_qty + $completed_total_qty)) * 100;
                                            if ($percentage >= 100): ?>
                                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center z-30">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                            <?php elseif ($percentage >= 75): ?>
                                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center z-30">
                                                    <span class="text-white text-xs font-bold">!</span>
                                                </div>
                                            <?php endif;
                                        } ?>
                                    </div>
                                    
                                    <!-- Simple Container (just total number) - Shown when no completed items -->
                                    <div class="simple-number-container flex items-center mr-3" style="<?php echo $completed_total_qty > 0 ? 'display: none;' : ''; ?>">
                                        <div class="w-16 h-16 bg-gradient-to-br from-kitchen-light to-kitchen-primary/10 rounded-full flex items-center justify-center shadow-sm border-2 border-kitchen-primary/20">
                                            <span class="text-2xl font-black text-kitchen-primary"><?php echo $total_qty; ?></span>
                                        </div>
                                    </div>
                                    
                                    <i class="fa-solid fa-chevron-down ml-3 text-gray-400"></i>
                                </div>
                            </div>
                            <div id="dish-<?php echo $card_index; ?>-details" class="px-4 pb-4 border-t border-gray-100 ">
                                <div class="mt-3 space-y-2">
                                    <?php if (empty($items)): ?>
                                        <div class="text-center py-4 text-gray-500">
                                            <i class="fa-solid fa-utensils text-2xl mb-2"></i>
                                            <p>No orders for this category today</p>
                                        </div>
                    <?php else: ?>
                        <?php // FIXED: Use subcategories from database instead of manual grouping ?>
                        <?php foreach ($subcategories as $subcategoryName => $subcategoryData): ?>
                            <?php $categoryItems = $subcategoryData['items']; ?>
                            <!-- Subcategory Header (test, toast, condiments, etc.) -->
                            <div class="mb-3">
                                <div class="flex items-center mb-2">
                                    <div class="w-1 h-5 bg-gradient-to-b from-kitchen-primary to-kitchen-secondary rounded-full mr-3"></div>
                                    <h4 class="text-lg font-bold text-gray-800 tracking-wide">
                                        <?php echo htmlspecialchars($subcategoryName); ?>
                                    </h4>
                                    <div class="flex-1 ml-3 h-0.5 bg-gradient-to-r from-kitchen-primary/30 to-transparent"></div>
                                </div>
                                
                                <?php foreach ($categoryItems as $item): ?>
                                    <?php 
                                    // Determine if this item is completed
                                    $isCompleted = (int)$item['is_completed'] === 1;
                                    $completedClass = $isCompleted ? 'item-completed' : '';
                                    $completedAttr = $isCompleted ? 'true' : 'false';
                                    ?>
                                    <div class="production-item-container mb-2" data-qty="<?php echo $item['all_qty']; ?>">
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md hover:border-kitchen-primary/20 transition-all duration-300 overflow-hidden <?php echo $completedClass; ?>" 
                                         data-section-id="<?php echo $category['id']; ?>" 
                                         data-item-id="<?php echo $item['option_id']; ?>"
                                         data-completed="<?php echo $completedAttr; ?>">
                                        <div class="px-3 py-2">
                                        
                                        <!-- Item Header with Name (without category prefix) -->
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-1">
                                                    <div class="w-2 h-2 bg-kitchen-primary rounded-full"></div>
                                                    
                                                    <span
  class="w-3.5 h-3.5 rounded-sm border border-gray-400"
  style="background-color: <?= htmlspecialchars($item['menu_colour']) ?>;">
</span>

                                                    <span class="text-lg font-bold text-gray-800 item-name tracking-wide">
                                                        <?php echo htmlspecialchars($item['menu_option_name']); ?>
                                                    </span>
                                                    
                                                    
                                                </div>
                                    <?php 
                                    // Check for item-specific comments
                                    $commentKey = $item['option_id']; // Using option_id as key
                                    $hasComments = false;
                                    $itemSpecificComments = [];
                                    
                                    // Look for comments for this specific item using exact menu_id_option_id match
                                    $lookupKey = $item['menu_id'] . '_' . $item['option_id'];
                                    $receptionComments = []; // Comments from reception/nurse/client
                                    $chefComments = []; // Comments from chef
                                    
                                    foreach ($itemComments as $key => $comments) {
                                        // Exact match: menu_id_option_id
                                        if ($key === $lookupKey) {
                                            $hasComments = true;
                                            // Separate comments by role
                                            foreach ($comments as $comment) {
                                                if ($comment['added_by_role'] === 'chef') {
                                                    $chefComments[] = $comment;
                                                } else {
                                                    $receptionComments[] = $comment;
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    
                                    <?php if (!empty($receptionComments)): ?>
                                        <div class="mb-1 bg-orange-50 border-l-4 border-orange-400 p-2 rounded-r-md">
                                            <h6 class="text-xs font-semibold text-orange-800 mb-1">Comments:</h6>
                                            <div class="space-y-1">
                                                <?php foreach ($receptionComments as $comment): ?>
                                                    <div class="text-xs text-orange-700">
                                                        <?php echo htmlspecialchars($comment['comment']); ?>
                                                        <span class="text-orange-500 ml-1">(Suite <?php echo htmlspecialchars($comment['bed_no']); ?>)</span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Quantity Display (right aligned in header) -->
                                    <div class="text-right">
                                        <?php if ($item['qty'] > 0): ?>
                                            <span class="text-2xl font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-lg border border-orange-200"><?php echo $item['qty']; ?></span>
                                        <?php else: ?>
                                            <span class="text-2xl font-bold text-green-600 bg-green-50 px-3 py-1 rounded-lg border border-green-200"><?php echo $item['all_qty']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                        <!-- Notes and Action Section -->
                                        <?php if ($item['qty'] > 0): ?>
                                            <div class="mt-2 space-y-2 border-t border-gray-100 pt-2">
                                                <!-- Notes/Comments box -->
                                                <div class="w-full" style="display: none;">
                                                    <textarea 
                                                        id="notes_<?php echo $category['id']; ?>_<?php echo $item['option_id']; ?>" 
                                                        placeholder="Add special instructions..." 
                                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-kitchen-primary/50 focus:border-kitchen-primary transition-all duration-200 resize-none bg-gray-50 focus:bg-white"
                                                        rows="2"></textarea>
                                                </div>
                                                <!-- Complete button with proper spacing -->
                                                <?php if (!isset($isReadOnly) || !$isReadOnly): ?>
                                                <div class="flex justify-end no-print">
                                                    <button class="complete-btn bg-kitchen-primary hover:bg-kitchen-secondary text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-all duration-200" onclick="markCompleted(this, '<?php echo $category['id']; ?>', '<?php echo $item['option_id']; ?>')">
                                                        <i class="fas fa-check mr-2"></i>Mark Complete
                                                    </button>
                                                </div>
                                                <?php else: ?>
                                                <div class="flex justify-end no-print">
                                                    <div class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                                                        <i class="fas fa-lock mr-2"></i>Read-Only Mode
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <!-- Show completed status with chef notes only -->
                                            <div class="mt-2 border-t border-gray-100 pt-2">
                                                <?php if (!empty($chefComments)): ?>
                                                    <div class="mb-2 bg-green-50 border-l-4 border-green-400 p-2 rounded-r-md">
                                                        <h6 class="text-xs font-semibold text-green-800 mb-1">Chef Notes:</h6>
                                                        <div class="space-y-1">
                                                            <?php foreach ($chefComments as $comment): ?>
                                                                <div class="text-xs text-green-700 font-medium">
                                                                    <?php echo htmlspecialchars($comment['comment']); ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex justify-end no-print">
                                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center cursor-not-allowed" disabled>
                                                        <i class="fas fa-check-circle mr-2"></i>Completed
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                    </div>
                                <?php endforeach; // End items in category ?>
                            </div>
                        <?php endforeach; // End food categories ?>
                    <?php endif; ?>
                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $card_index++;
                }
                ?>
            </div>
        </div>

        <!-- Right Panel: Special Order Notes (Hidden for now - will use in future) -->
        <div id="special-orders" class="bg-white rounded-lg shadow-sm flex flex-col" style="display: none;">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Special Order Notes</h2>
                <div class="mt-2 relative no-print">
                    <input type="text" id="searchSpecialOrders" placeholder="Search special orders..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-kitchen-primary focus:border-transparent">
                </div>
            </div>
            <div class="overflow-auto flex-grow max-h-[calc(100vh-320px)]">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-600 sticky top-0">
                        <tr>
                           
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Floor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Suite No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Special Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(isset($orderWithNotes) && !empty($orderWithNotes)) {  ?>
                        <?php foreach($orderWithNotes as $orderWithNote)  { ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                           
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($orderWithNote['floor'] ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($orderWithNote['bed_no'] ?? 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <?php if (!empty($orderWithNote['order_comment'])): ?>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full font-medium">
                                           <?php echo htmlspecialchars($orderWithNote['order_comment']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                           No special notes
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                         <?php } ?>
                      <?php } else { ?>
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="text-gray-500 flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-clipboard-list text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium">No special order notes for today</p>
                                    <p class="text-sm mt-1 opacity-75">All orders are standard with no special requirements</p>
                                </div>
                            </td>
                        </tr>
                      <?php } ?>
                   
                    </tbody>
                </table>
            </div>
            <!-- Footer Stats -->
           
        </div>
    </div>
 
 
 <!-- Suite Summary Modal -->
<div id="suiteSummaryModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    
    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-5xl p-6 overflow-y-auto max-h-[90vh]">
        
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
                Suite Special Instructions Summary
            </h2>
            <button onclick="closeSuiteSummary()" class="text-gray-500 hover:text-gray-700">
                ✕
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                       
                        <th class="px-4 py-2 border">Floor</th>
                        <th class="px-4 py-2 border">Suite</th>
                        <th class="px-4 py-2 border">Special Instructions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($suiteSummary)) : ?>
                    <?php foreach ($suiteSummary as $suite) : ?>
                        <tr class="hover:bg-gray-50 align-top">
                           
                            <td class="px-4 py-2 border">
                                <?= htmlspecialchars($suite['floor']) ?>
                            </td>
                            <td class="px-4 py-2 border">
                                <?= htmlspecialchars($suite['bed_no']) ?>
                            </td>
                            <td class="px-4 py-2 border">
                                <?php if (!empty($suite['people'])) : ?>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <?php foreach ($suite['people'] as $person) : ?>
                                            <li>
                                               
                                                <?= htmlspecialchars($person['instructions']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <span class="text-gray-400 italic">No special instructions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            No suite data found
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function openSuiteSummary() {
    document.getElementById('suiteSummaryModal').classList.remove('hidden');
    document.getElementById('suiteSummaryModal').classList.add('flex');
}

function closeSuiteSummary() {
    document.getElementById('suiteSummaryModal').classList.add('hidden');
    document.getElementById('suiteSummaryModal').classList.remove('flex');
}
</script>

    <script>
       const categoryIdToName = {
    <?php foreach ($categories as $category) {
        echo "'{$category['id']}': '".htmlspecialchars($category['name'], ENT_QUOTES)."',";
    } ?>
};

function switchTab(categoryId, element) {
    // Update tab styles
    document.querySelectorAll('.meal-tab').forEach(tab => {
        tab.classList.remove('bg-kitchen-primary', 'text-white');
        tab.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    });
    element.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
    element.classList.add('bg-kitchen-primary', 'text-white');

    // Hide all groups
    document.querySelectorAll('.dish-group').forEach(group => {
        group.classList.add('hidden');
    });

    // Show only selected group
    const selectedGroup = document.getElementById(`dish-group-${categoryId}`);
    if (selectedGroup) {
        selectedGroup.classList.remove('hidden');
    }

    // Category switched successfully
}


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.meal-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            switchTab(this.getAttribute('data-category-id'), this);
        });
    });

    // Show first category by default
    const firstTab = document.querySelector('.meal-tab[data-category-id="<?php echo $categories[0]['id']; ?>"]');
    if (firstTab) {
        switchTab(<?php echo $categories[0]['id']; ?>, firstTab);
    }

    // Search functionality for Special Order Notes
    const searchInput = document.getElementById('searchSpecialOrders');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const tableRows = document.querySelectorAll('#special-orders tbody tr');
            
            tableRows.forEach(row => {
                const floor = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const suiteNo = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const notes = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                const isMatch = floor.includes(searchTerm) || 
                               suiteNo.includes(searchTerm) || 
                               notes.includes(searchTerm);
                
                row.style.display = isMatch ? '' : 'none';
            });
        });
    }
});


        

        // Note: handleProductionDateChange moved to top of script for global scope access

        function printProductionForm() {
            // Get the currently visible dish group (active tab)
            const visibleGroup = $('.dish-group:visible');
            const activeCategoryId = visibleGroup.data('category-id');
            
            // Get the active tab name
            const activeTab = $('.meal-tab[data-category-id="' + activeCategoryId + '"]');
            const categoryName = activeTab.data('category-name');
            
            // Set the print title
            $('#print-category-title h2').text(categoryName);
            $('#print-category-title').show();
            
            // Hide all dish groups except the active one
            $('.dish-group').each(function() {
                if ($(this).data('category-id') !== activeCategoryId) {
                    $(this).addClass('hide-for-print');
                }
            });
            
            // Hide all meal tabs except the active one
            $('.meal-tab').each(function() {
                if ($(this).data('category-id') !== activeCategoryId) {
                    $(this).addClass('hide-for-print');
                }
            });
            
            // Print
            window.print();
            
            // Restore visibility after print dialog closes
            setTimeout(function() {
                $('.hide-for-print').removeClass('hide-for-print');
                $('#print-category-title').hide();
            }, 100);
        }

        // ============================================
        // AUTO-PRINT FUNCTIONALITY AT 10:30 AM AEST FOR TOMORROW'S ORDERS
        // ============================================

        // Function to print all categories sequentially WITHOUT disrupting UI
        function printAllCategories() {
            const allCategories = Object.keys(categoryIdToName);
            let currentIndex = 0;
            
            // Store original visibility state of each dish group
            const originalHiddenStates = {};
            $('.dish-group').each(function() {
                const categoryId = $(this).data('category-id');
                originalHiddenStates[categoryId] = $(this).hasClass('hidden');
            });
            
            function printNextCategory() {
                if (currentIndex >= allCategories.length) {
                    // Final cleanup - restore ALL groups to their original hidden state
                    $('.dish-group').each(function() {
                        const $group = $(this);
                        const categoryId = $group.data('category-id');
                        $group.removeClass('hide-for-print');
                        
                        // Restore original hidden state
                        if (originalHiddenStates[categoryId]) {
                            $group.addClass('hidden');
                        } else {
                            $group.removeClass('hidden');
                        }
                    });
                    return;
                }
                
                const categoryId = allCategories[currentIndex];
                const categoryName = categoryIdToName[categoryId];
                
                // STEP 1: Remove 'hidden' class from ALL groups (so content is accessible for print)
                $('.dish-group').removeClass('hidden');
                
                // STEP 2: Mark ALL groups as hide-for-print
                $('.dish-group').addClass('hide-for-print');
                
                // STEP 3: Only remove hide-for-print from the category we want to print
                const $currentGroup = $('#dish-group-' + categoryId);
                $currentGroup.removeClass('hide-for-print');
                
                // Mark all tabs to hide in print EXCEPT the current one
                $('.meal-tab').addClass('hide-for-print');
                $('.meal-tab[data-category-id="' + categoryId + '"]').removeClass('hide-for-print');
                
                // Set print title
                $('#print-category-title h2').text(categoryName);
                $('#print-category-title').show();
                
                // AUTO-PRINT: Trigger print immediately
                // Note: Browsers require user interaction for print dialogs (security feature)
                // To enable auto-print without dialog, configure browser settings:
                // Chrome: Settings > Site Settings > Additional Permissions > Print > Allow
                // Or use browser flags: --kiosk-printing (for kiosk mode)
                window.print();
                
                // Clean up after print - restore hidden classes to screen display
                setTimeout(function() {
                    $('#print-category-title').hide();
                    
                    // Restore the 'hidden' class to groups that should be hidden on screen
                    $('.dish-group').each(function() {
                        const $group = $(this);
                        const gid = $group.data('category-id');
                        if (originalHiddenStates[gid]) {
                            $group.addClass('hidden');
                        }
                    });
                    
                    currentIndex++;
                    
                    // Print next category after 2 second delay
                    if (currentIndex < allCategories.length) {
                        setTimeout(printNextCategory, 2000);
                    } else {
                        // Last cleanup after all prints complete
                        $('.hide-for-print').removeClass('hide-for-print');
                    }
                }, 500);
            }
            
            // Start printing the first category
            printNextCategory();
        }

        // Function to check if it's 10:30 AM in Australian Eastern Time and print TOMORROW'S orders
        // CRITICAL: Multiple safety checks to ensure 100% reliability - never miss the print
        function checkAutoPrintTime() {
            // CRITICAL FIX: Get current time in Australia/Sydney timezone with seconds
            // Use Intl.DateTimeFormat for accurate timezone conversion
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Australia/Sydney',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false
            });
            const parts = formatter.formatToParts(now);
            const hours = parseInt(parts.find(part => part.type === 'hour').value);
            const minutes = parseInt(parts.find(part => part.type === 'minute').value);
            const seconds = parseInt(parts.find(part => part.type === 'second').value);
            
            // Calculate total seconds since midnight for precise comparison
            const totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
            const targetSeconds = (10 * 3600) + (30 * 60); // 10:30:00 = 37800 seconds
            
            // Debug: Log current time (only log during target window to reduce console spam)
            const currentTimeStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            // ✅ FIX: Only log during target window (10:29:50 to 10:35:00) to reduce console spam
            const isExtendedWindow = (totalSeconds >= (targetSeconds - 10) && totalSeconds <= (targetSeconds + 300)); // 10:29:50 to 10:35:00
            if (isExtendedWindow) {
                console.log(`[Auto Print Check] Current Australia/Sydney time: ${currentTimeStr} (${totalSeconds}s)`);
            }
            
            // Also get the date in Australia timezone for accurate date calculation
            const dateFormatter = new Intl.DateTimeFormat('en-CA', {
                timeZone: 'Australia/Sydney',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            const australiaDateStr = dateFormatter.format(now);
            
            // CRITICAL FIX: Multiple safety checks to ensure 100% reliability
            // Check 1: Exact minute match (10:30:XX) - triggers during entire 10:30 minute
            // Check 2: Extended time window (10:29:50 to 10:35:00) - catches edge cases and late page loads
            // Check 3: Seconds-based comparison (37800-38100 seconds) - covers 10:30:00 to 10:35:00
            const isTargetMinute = (hours === 10 && minutes === 30);
            // isExtendedWindow already declared above for logging check
            const isExactTime = (totalSeconds >= targetSeconds && totalSeconds <= targetSeconds + 300); // 10:30:00 to 10:35:00
            
            // Trigger if ANY check passes (maximum reliability)
            if (isTargetMinute || isExtendedWindow || isExactTime) {
                // Get today's date and tomorrow's date in YYYY-MM-DD format (Australia timezone)
                const todayStr = australiaDateStr; // Already in YYYY-MM-DD format
                const todayParts = todayStr.split('-');
                const tomorrowDate = new Date(parseInt(todayParts[0]), parseInt(todayParts[1]) - 1, parseInt(todayParts[2]));
                tomorrowDate.setDate(tomorrowDate.getDate() + 1);
                const tomorrowStr = tomorrowDate.toISOString().split('T')[0];
                
                // 🔒 CRITICAL: Check if we've already printed today for tomorrow's orders
                // This ensures it triggers ONLY ONCE per day after 10:30 AM
                const lastPrintDate = localStorage.getItem('lastAutoPrintDateForTomorrow');
                
                // Only trigger if we haven't printed today yet
                if (lastPrintDate !== todayStr) {
                    console.log(`[Auto Print] ✅ Triggered at ${currentTimeStr} - Date: ${todayStr}, Tomorrow: ${tomorrowStr}`);
                    console.log(`[Auto Print] Last print date: ${lastPrintDate || 'Never'}`);
                    
                    // 🔒 Mark as printed IMMEDIATELY to prevent duplicate triggers
                    // This must happen BEFORE navigation/print to ensure only one trigger
                    localStorage.setItem('lastAutoPrintDateForTomorrow', todayStr);
                    
                    // Get the currently selected date from the date picker
                    const selectedDate = document.getElementById('production-date-picker')?.value;
                    
                    // If we're not already viewing tomorrow's production form, navigate to it
                    if (selectedDate !== tomorrowStr) {
                        // Log navigation (no alert in production)
                        console.log(`[Auto Print] 🔄 Navigating to tomorrow's form: ${tomorrowStr}`);
                        
                        // Navigate to tomorrow's production form
                        // The print will be triggered after page loads (see below)
                        window.location.href = '<?php echo base_url('Orderportal/Order/viewProductionForm/'); ?>' + tomorrowStr + '?autoPrint=true';
                    } else {
                        // We're already on tomorrow's form, just print
                        console.log(`[Auto Print] ✅ Already on tomorrow's form, starting print`);
                        
                        // Start printing all categories (silent in production)
                        printAllCategories();
                    }
                } else {
                    console.log(`[Auto Print] ⏭️ Already printed today (${lastPrintDate}), skipping - will not trigger again`);
                }
            }
        }
        
        // Check if we need to auto-print after page load (when redirected with autoPrint parameter)
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('autoPrint') === 'true') {
                // 🔒 CRITICAL: Double-check localStorage to prevent duplicate prints
                // Get today's date in Australia timezone
                const now = new Date();
                const dateFormatter = new Intl.DateTimeFormat('en-CA', {
                    timeZone: 'Australia/Sydney',
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
                const todayStr = dateFormatter.format(now);
                const lastPrintDate = localStorage.getItem('lastAutoPrintDateForTomorrow');
                
                // Only proceed if we haven't printed today (safety check)
                if (lastPrintDate !== todayStr) {
                    // Mark as printed BEFORE printing to prevent duplicates
                    localStorage.setItem('lastAutoPrintDateForTomorrow', todayStr);
                    
                    // Remove the autoPrint parameter from URL
                    window.history.replaceState({}, document.title, window.location.pathname);
                    
                    // Wait 2 seconds for page to fully load, then start printing
                    // AUTO-PRINT: Try to print without dialog (if printer is connected)
                    setTimeout(function() {
                        console.log('[Auto Print] ✅ Page loaded with autoPrint=true, starting print');
                        console.log('[Auto Print] 📅 Printing tomorrow\'s orders for date:', document.getElementById('production-date-picker')?.value);
                        
                        // Verify we're printing tomorrow's orders (safety check)
                        const selectedDate = document.getElementById('production-date-picker')?.value;
                        const now = new Date();
                        const dateFormatter = new Intl.DateTimeFormat('en-CA', {
                            timeZone: 'Australia/Sydney',
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                        });
                        const todayStr = dateFormatter.format(now);
                        const todayParts = todayStr.split('-');
                        const tomorrowDate = new Date(parseInt(todayParts[0]), parseInt(todayParts[1]) - 1, parseInt(todayParts[2]));
                        tomorrowDate.setDate(tomorrowDate.getDate() + 1);
                        const tomorrowStr = tomorrowDate.toISOString().split('T')[0];
                        
                        if (selectedDate === tomorrowStr) {
                            console.log('[Auto Print] ✅ Confirmed: Printing tomorrow\'s orders (' + tomorrowStr + ')');
                            printAllCategories();
                        } else {
                            console.error('[Auto Print] ❌ ERROR: Wrong date selected! Expected tomorrow (' + tomorrowStr + '), but got (' + selectedDate + ')');
                            // Still print, but log the error
                            printAllCategories();
                        }
                    }, 2000);
                } else {
                    console.log('[Auto Print] ⏭️ Already printed today, skipping auto-print on page load');
                    // Remove the autoPrint parameter from URL even if skipping
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        });

        // CRITICAL FIX: Check every 5 seconds for maximum reliability (never miss 10:30 AM)
        // Reduced to 5 seconds to ensure 100% catch rate - checks 12 times per minute
        setInterval(checkAutoPrintTime, 5000);
        
        // BACKUP: Additional check every 1 second during extended window (10:29:50 to 10:35:00)
        // This ensures we catch it even if the 5-second check misses, and handles late page loads
        setInterval(function() {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Australia/Sydney',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false
            });
            const parts = formatter.formatToParts(now);
            const hours = parseInt(parts.find(part => part.type === 'hour').value);
            const minutes = parseInt(parts.find(part => part.type === 'minute').value);
            const seconds = parseInt(parts.find(part => part.type === 'second').value);
            const totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
            const targetSeconds = (10 * 3600) + (30 * 60); // 10:30:00
            
            // Extended window: 10:29:50 to 10:35:00 (5 minutes + 10 seconds buffer)
            // This handles late page loads and ensures we don't miss the print
            if (totalSeconds >= (targetSeconds - 10) && totalSeconds <= (targetSeconds + 300)) {
                checkAutoPrintTime();
            }
        }, 1000);

        // CRITICAL: Multiple immediate checks when page loads (in case page is loaded at 10:30 AM)
        // Check immediately, then after 1s, 2s, 3s to ensure we catch it - never miss
        $(document).ready(function() {
            checkAutoPrintTime(); // Immediate check
            setTimeout(checkAutoPrintTime, 1000); // After 1 second
            setTimeout(checkAutoPrintTime, 2000); // After 2 seconds
            setTimeout(checkAutoPrintTime, 3000); // After 3 seconds
        });

        // ============================================
        // AUTO-REFRESH EVERY 15 MINUTES
        // ============================================

        // Auto-refresh Production Form page every 15 minutes
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
            toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] flex items-center space-x-3 animate-slide-in';
            toast.innerHTML = `
                <i class="fas fa-sync-alt fa-spin text-2xl"></i>
                <div>
                    <div class="font-bold">Auto-Refresh in Progress</div>
                    <div class="text-sm">Production Form will reload in 3 seconds...</div>
                </div>
            `;
            
            // Add animation styles if not already present
            if (!document.getElementById('toast-animation-styles')) {
                const style = document.createElement('style');
                style.id = 'toast-animation-styles';
                style.textContent = `
                    @keyframes slide-in {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    .animate-slide-in {
                        animation: slide-in 0.3s ease-out;
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Append to body
            document.body.appendChild(toast);
        }

        // Initialize auto-refresh on page load
        $(document).ready(function() {
            scheduleAutoRefresh();
        });

        // Function to update progress indicator in real-time
        function updateProgressIndicator() {
            // FIXED: Sum QUANTITIES, not item counts, for the visible category only
            let completedQty = 0;
            let pendingQty = 0;
            
            // Find the currently visible dish group
            const visibleGroup = $('.dish-group:visible');
            
            // Sum quantities ONLY in the visible category
            visibleGroup.find('.production-item-container').each(function() {
                const itemDiv = $(this).find('[data-completed]');
                const qty = parseInt($(this).attr('data-qty')) || 0;
                
                if (itemDiv.length > 0 && qty > 0) {
                    if (itemDiv.attr('data-completed') === 'true') {
                        completedQty += qty;
                    } else {
                        pendingQty += qty;
                    }
                }
            });
            
            // Calculate total quantity (completed + pending)
            const totalQty = completedQty + pendingQty;
            
            // Find the progress containers within the visible group using unique class names
            const progressContainer = visibleGroup.find('.progress-circle-container').first();
            const simpleContainer = visibleGroup.find('.simple-number-container').first();
            
            if (completedQty > 0) {
                // Show circular progress indicator when there are completed items
                const percentage = (completedQty / totalQty) * 100;
                
                // Hide simple display, show progress display
                simpleContainer.hide();
                progressContainer.show();
                
                // Update center numbers (completed / total)
                progressContainer.find('.text-sm.font-black').text(completedQty);
                progressContainer.find('.text-xs.font-bold').text(totalQty);
                
                // Update completion badge
                progressContainer.find('.absolute.-top-1.-right-1').remove();
                
                if (percentage >= 100) {
                    progressContainer.append(`
                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center z-30">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    `);
                } else if (percentage >= 75) {
                    progressContainer.append(`
                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center z-30">
                            <span class="text-white text-xs font-bold">!</span>
                        </div>
                    `);
                }
            } else if (pendingQty > 0) {
                // Show simple number display (total quantity, not item count)
                progressContainer.hide();
                simpleContainer.show();
                simpleContainer.find('.text-2xl.font-black').text(pendingQty);
            }
        }
        
        // Initialize progress indicator on page load
        $(document).ready(function() {
            updateProgressIndicator();
        });

        function markCompleted(obj, categoryId, optionId) {
            // Prevent double-clicking
            if ($(obj).prop('disabled')) return;
            
            // Validate parameters
            if (!categoryId || !optionId) {
                alert('Error: Missing category ID (' + categoryId + ') or option ID (' + optionId + ')');
                return;
            }
            
            // Get the notes/comments from the textarea
            const notesTextarea = document.getElementById('notes_' + categoryId + '_' + optionId);
            const notes = notesTextarea ? notesTextarea.value.trim() : '';
            
            $(obj).html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');
            $(obj).prop('disabled', true);
            
            // Update UI immediately for better UX
            const row = $(obj).closest('.production-item');
            row.addClass('item-completed');
            row.attr('data-completed', 'true');
            
            // Get the current order ID from today's orders
            $.ajax({
                url: '<?php echo base_url("Orderportal/Order/getCurrentOrderId"); ?>',
                type: 'POST',
                data: {
                    category_id: categoryId,
                    option_id: optionId  // FIXED: Pass option_id to find the correct order
                },
                dataType: 'json',
                success: function(orderRes) {
                    if (orderRes.status === 'success' && orderRes.order_id) {
                        // Now mark the food as completed
                        $.ajax({
                            url: '<?php echo base_url("Orderportal/Order/markFoodCompleted"); ?>',
                            type: 'POST',
                            data: {
                                order_id: orderRes.order_id,
                                option_id: optionId, // Changed from menu_id to option_id
                                notes: notes // Include the notes from textarea
                            },
                            dataType: 'json',
                            success: function(res) {
                                
                                                if (res.status === 'success') {
                                    // Update item's completion status
                                    const itemContainer = $(obj).closest('.production-item-container');
                                    itemContainer.find('[data-completed]').attr('data-completed', 'true');
                                    itemContainer.find('[data-completed]').addClass('item-completed');
                                    
                                    // Update the qty badge to show completed (green instead of orange)
                                    const qtyBadge = itemContainer.find('.text-2xl.font-bold');
                                    if (qtyBadge.length > 0) {
                                        const qtyValue = qtyBadge.text();
                                        qtyBadge.removeClass('text-orange-600 bg-orange-50 border-orange-200');
                                        qtyBadge.addClass('text-green-600 bg-green-50 border-green-200');
                                    }
                                    
                                    // Transform UI to completed state
                                    const actionSection = $(obj).closest('.mt-2.space-y-2');
                                    
                                    // Create completed state HTML
                                    let completedHTML = '<div class="mt-2 border-t border-gray-100 pt-2">';
                                    
                                    // Add chef notes if they exist
                                    if (notes && notes.trim()) {
                                        completedHTML += `
                                            <div class="mb-2 bg-green-50 border-l-4 border-green-400 p-2 rounded-r-md">
                                                <h6 class="text-xs font-semibold text-green-800 mb-1">Chef Notes:</h6>
                                                <div class="space-y-1">
                                                    <div class="text-xs text-green-700 font-medium">
                                                        ${notes}
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    }
                                    
                                    // Add completed button
                                    completedHTML += `
                                        <div class="flex justify-end">
                                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center cursor-not-allowed" disabled>
                                                <i class="fas fa-check-circle mr-2"></i>Completed
                                            </button>
                                        </div>
                                    </div>`;
                                    
                                    // Replace the action section with completed state
                                    actionSection.replaceWith(completedHTML);
                                    
                                    // Update progress indicator immediately
                                    updateProgressIndicator();
                                    
                                    // DEBUG: Commented out for production
                                    // // console.log('Item marked as completed successfully' + (notes ? ' with notes: ' + notes : ''));
                                } else {
                                    // Handle error response
                                    revertUIChanges(obj, row);
                                    alert('Error: ' + (res.message || 'Failed to mark item as completed'));
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error in markFoodCompleted:', xhr.responseText);
                                revertUIChanges(obj, row);
                                alert('Network error: Could not complete item. Please try again.');
                            }
                        });
                    } else {
                        revertUIChanges(obj, row);
                        alert('Error: Could not find order ID for today - ' + (orderRes.message || ''));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error in getCurrentOrderId:', xhr.responseText);
                    revertUIChanges(obj, row);
                    alert('Error: Could not get order information. Please try again.');
                }
            });
        }
        
        function revertUIChanges(obj, row) {
            // Revert UI changes on any error
            row.removeClass('item-completed');
            row.attr('data-completed', 'false');
            $(obj).html('<i class="fas fa-check mr-2"></i>Complete');
            $(obj).prop('disabled', false);
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
                    console.log(`📋 Loaded ${data.total_records || 0} dismissal records for ${data.total_orders || 0} orders`);
                    // ✅ DEBUG: Log dismissal details
                    if (Object.keys(dismissedSuitesCache).length > 0) {
                        Object.keys(dismissedSuitesCache).forEach(orderId => {
                            const suites = dismissedSuitesCache[orderId];
                            console.log(`  Order ${orderId}: ${Object.keys(suites).length} dismissed suites:`, Object.keys(suites));
                        });
                    }
                    return dismissedSuitesCache;
                } else {
                    console.error('❌ Failed to load dismissed suites:', data.error);
                    return {};
                }
            } catch (error) {
                console.error('❌ Error loading dismissed suites:', error);
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
        async function checkAndShowLateOrdersProduction() {
            console.log('🔍 [PRODUCTION] checkAndShowLateOrdersProduction called');
            // ✅ CRITICAL FIX: Always reload dismissed suites from database before checking
            // This ensures we have the latest dismissal data, even if cache was stale
            const dismissed = await loadDismissedSuitesFromDB();
            console.log('📋 [PRODUCTION] Loaded dismissed suites:', Object.keys(dismissed).length, 'orders');
            
            console.log('🔍 [PRODUCTION] Fetching late orders from:', '<?php echo base_url('Orderportal/Order/checkLateOrders'); ?>');
            fetch('<?php echo base_url('Orderportal/Order/checkLateOrders'); ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('🔍 [PRODUCTION] Response received:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('🔍 [PRODUCTION] Late Orders Check Response:', data);
                if (data.success === false) {
                    console.error('❌ [PRODUCTION] Late orders check failed:', data.error);
                    return;
                }
                
                if (data.success && data.hasLateOrders) {
                    console.log('✅ [PRODUCTION] Found late orders:', data.lateOrders);
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
                            showLateOrderAlertProduction(newLateOrders, data.cutoffTime);
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
                console.error('❌ [PRODUCTION] Error checking late orders:', error);
            });
        }

        // Show flashing alert with sound for late orders
        function showLateOrderAlertProduction(lateOrders, cutoffTime) {
            console.log('🚨 [PRODUCTION] showLateOrderAlertProduction called with', lateOrders.length, 'late orders');
            // ✅ CRITICAL FIX: Prevent showing multiple modals at once
            // Check if modal already exists and is visible - if so, don't show another one
            const existingModal = document.getElementById('late-order-alert-modal');
            const isModalVisible = existingModal && existingModal.offsetParent !== null;
            
            if (existingModal && isModalVisible) {
                console.log('⏭️ [PRODUCTION] Late order alert modal already visible, skipping duplicate');
                return;
            }
            
            // Remove any stale/hidden modal before creating new one
            if (existingModal) {
                console.log('🧹 [PRODUCTION] Removing stale modal');
                existingModal.remove();
            }
            
            console.log('✅ [PRODUCTION] Creating new late order alert modal');
            
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
                    <button id="dismiss-late-orders-btn-production" style="
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
                
                #dismiss-late-orders-btn-production:hover {
                    background: #991b1b !important;
                    transform: scale(1.05);
                }
            `;
            document.head.appendChild(style);
            
            // Handle dismiss button
            document.getElementById('dismiss-late-orders-btn-production').addEventListener('click', async function() {
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
        console.log('🔍 [PRODUCTION] Setting up late order checks');
        console.log('🔍 [PRODUCTION] checkAndShowLateOrdersProduction function exists:', typeof checkAndShowLateOrdersProduction);
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🔍 [PRODUCTION] DOMContentLoaded fired, scheduling check');
                setTimeout(function() {
                    console.log('🔍 [PRODUCTION] Calling checkAndShowLateOrdersProduction');
                    checkAndShowLateOrdersProduction();
                }, 2000);
            });
        } else {
            console.log('🔍 [PRODUCTION] Document already loaded, scheduling check');
            setTimeout(function() {
                console.log('🔍 [PRODUCTION] Calling checkAndShowLateOrdersProduction');
                checkAndShowLateOrdersProduction();
            }, 2000);
        }

        // ✅ ENABLED: Schedule late order checks every 2 minutes
        function scheduleLateOrderChecksProduction() {
            const lateOrderCheckInterval = 2 * 60 * 1000; // 2 minutes in milliseconds
            setInterval(function() {
                // ✅ CRITICAL FIX: Don't check if modal is already visible
                const existingModal = document.getElementById('late-order-alert-modal');
                const isModalVisible = existingModal && existingModal.offsetParent !== null;
                if (!isModalVisible) {
                    checkAndShowLateOrdersProduction();
                } else {
                    console.log('⏸️ Skipping late order check - modal already visible');
                }
            }, lateOrderCheckInterval);
            console.log('✅ Late orders check is enabled (checking every 2 minutes)');
        }

        // Initialize late order checks on page load (separate from refresh cycle)
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                scheduleLateOrderChecksProduction();
            });
        } else {
            scheduleLateOrderChecksProduction();
        }

        // Keep the original 15-minute auto-refresh (no late order check before refresh)
        const originalProductionScheduleAutoRefresh = scheduleAutoRefresh;
        scheduleAutoRefresh = function() {
            const refreshInterval = 15 * 60 * 1000;
            
            // Set interval to refresh every 15 minutes
            setInterval(function() {
                showAutoRefreshToast();
                
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }, refreshInterval);
        };
        
        // ============================================
        // LATE ORDERS SUMMARY BUTTON (ON-DEMAND)
        // ============================================
        
        function showLateOrdersSummary() {
            // Fetch late orders data
            $.ajax({
                url: '<?php echo base_url('Orderportal/Order/checkLateOrders'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success === false) {
                        alert('No late orders found.');
                        return;
                    }
                    
                    if (response.success && response.hasLateOrders) {
                        displayLateOrdersSummary(response.lateOrders, response.cutoffTime);
                    } else {
                        alert('✓ No late orders! All orders were placed before ' + (response.cutoffTime || '10:30 AM'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error fetching late orders. Please try again.');
                }
            });
        }
        
        function displayLateOrdersSummary(lateOrders, cutoffTime) {
            // Group orders by type
            const todaysOrders = lateOrders.filter(o => o.type === 'today');
            const tomorrowsOrders = lateOrders.filter(o => o.type === 'tomorrow');
            
            // Build order list HTML
            let orderListHTML = '';
            
            if (todaysOrders.length > 0) {
                const totalSuites = todaysOrders.reduce((sum, order) => sum + order.total_late_suites, 0);
                const orderDate = todaysOrders[0].date;
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
                const orderDate = tomorrowsOrders[0].date;
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
            
            // Create modal
            const modal = document.createElement('div');
            modal.id = 'late-orders-summary-modal';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.75);
                z-index: 99999;
                display: flex;
                justify-content: center;
                align-items: center;
            `;
            
            const modalContent = document.createElement('div');
            modalContent.style.cssText = `
                background: white;
                border-radius: 16px;
                padding: 32px;
                max-width: 800px;
                width: 90%;
                max-height: 85vh;
                overflow-y: auto;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            `;
            
            modalContent.innerHTML = `
                <div style="text-align: center; margin-bottom: 24px;">
                    <div style="font-size: 48px; margin-bottom: 12px;">⏰</div>
                    <h1 style="font-size: 28px; font-weight: bold; color: #dc2626; margin: 0;">
                        LATE ORDERS SUMMARY
                    </h1>
                    <p style="font-size: 14px; color: #666; margin-top: 8px;">
                        Orders placed/updated after ${cutoffTime}
                    </p>
                </div>
                
                ${orderListHTML}
                
                <div style="text-align: center; margin-top: 24px;">
                    <button id="close-late-summary-btn" style="
                        background: #16a399;
                        color: white;
                        border: none;
                        padding: 12px 32px;
                        border-radius: 8px;
                        font-size: 16px;
                        font-weight: bold;
                        cursor: pointer;
                        transition: all 0.3s;
                    ">
                        ✓ Close
                    </button>
                </div>
            `;
            
            modal.appendChild(modalContent);
            document.body.appendChild(modal);
            
            // Close button handler
            document.getElementById('close-late-summary-btn').addEventListener('click', function() {
                modal.remove();
            });
            
            // Close on background click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }

    </script>
