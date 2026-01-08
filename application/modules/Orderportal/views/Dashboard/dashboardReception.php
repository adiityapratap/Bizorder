<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="format-detection" content="telephone=no">
    <title>Bizorder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@100;200;300;400;500;600;700;800;900&family=Inter:wght@100;200;300;500;600;700;800;900&display=swap">
    <style>
        body {
            font-family: 'Albert Sans', 'Inter', sans-serif !important;
        }
        .fa, .fas, .far, .fal, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
        }
        ::-webkit-scrollbar {
            display: none;
        }
        html, body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Custom scrollbar for suites container */
        #suites-container::-webkit-scrollbar {
            display: block !important;
            width: 6px;
        }
        #suites-container::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }
        #suites-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        #suites-container::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        #suites-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        #suites-container::-webkit-scrollbar {
            width: 6px;
            display: block;
        }
        #suites-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        #suites-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        #suites-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* 🆕 SPECIAL ITEMS FEATURE - Orange highlighting for high-allergy patients */
        .main-suite-btn.high-allergy,
        .clientLists.high-allergy {
            border: 3px solid #ff8c00 !important;
            background: linear-gradient(135deg, #fff5e6 0%, #ffffff 100%) !important;
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3) !important;
        }
        
        .main-suite-btn.high-allergy:hover,
        .clientLists.high-allergy:hover {
            border-color: #ff6500 !important;
            box-shadow: 0 6px 16px rgba(255, 140, 0, 0.4) !important;
            transform: translateY(-2px) scale(1.05);
        }
        
        /* Allergy warning badge */
        .allergy-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ff8c00;
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        #warning-modal:not(.hidden) #warning-modal-content {
            transform: scale-100;
            opacity: 100;
        }
        #pin-modal:not(.hidden) #pin-modal-content {
            transform: scale-100;
            opacity: 100;
        }
        #comment-modal:not(.hidden) #comment-modal-content {
            /* Allow JavaScript to control transform and opacity for animations */
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }
        
        #comment-modal.modal-opening #comment-modal-content {
            transform: scale(1) !important;
            opacity: 1 !important;
        }
        
        /* Comment button specific styles */
        .comment-btn {
            z-index: 10;
            position: relative;
            pointer-events: auto;
        }
        
        .comment-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        /* Custom CSS overrides */
        .px-4 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        .max-w-7xl {
            max-width: 86rem !important;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: "#f0f9ff",
                            100: "#e0f2fe",
                            200: "#bae6fd",
                            300: "#7dd3fc",
                            400: "#38bdf8",
                            500: "#0ea5e9",
                            600: "#162945",
                            700: "#0369a1",
                            800: "#075985",
                            900: "#0c4a6e"
                        },
                        secondary: {
                            50: "#f0fdfa",
                            100: "#ccfbf1",
                            200: "#99f6e4",
                            300: "#5eead4",
                            400: "#2dd4bf",
                            500: "#14b8a6",
                            600: "#0d9488",
                            700: "#0f766e",
                            800: "#115e59",
                            900: "#134e4a"
                        },
                        warning: "#f59e0b",
                        success: "#10b981",
                        danger: "#ef4444",
                        gray: {
                            50: "#f9fafb",
                            100: "#f3f4f6",
                            200: "#e5e7eb",
                            300: "#d1d5db",
                            400: "#9ca3af",
                            500: "#6b7280",
                            600: "#4b5563",
                            700: "#374151",
                            800: "#1f2937",
                            900: "#111827"
                        }
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <!-- Clean Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <!-- Left section: Mobile menu button + Logo -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Toggle Button -->
                <button id="toggle-sidebar" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- BizOrder Logo -->
                <div class="flex items-center">
                    <img src="<?php echo base_url('theme-assets/images/logo/logo1.png'); ?>" 
                         alt="BizOrder" 
                         class="h-8 w-auto">
                </div>
            </div>

            <!-- Right section: Date info -->
            <div class="flex items-center space-x-4">
                <!-- Date info -->
                
                
                <!-- Department info -->
                <div class="hidden md:flex items-center space-x-2 bg-gray-50 rounded-lg px-3 py-2">
                    <i class="fa-solid fa-building text-gray-500"></i>
                    <span class="text-sm font-medium text-gray-700">
                        <?php echo $department_name = fetchDepartmentNameFromId($this->tenantDb, $this->session->userdata('department_id')); ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="flex h-screen pt-16">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden"></div>
        
        <!-- Sidebar - COMMENTED OUT for Reception Dashboard (can be re-enabled if needed) -->
        <?php /* SIDEBAR COMMENTED OUT - UNCOMMENT BELOW TO RE-ENABLE
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 fixed h-full hidden z-40" style="top: 64px; height: calc(100vh - 64px);">
            <div class="p-6 h-full flex flex-col">
                <div class="mb-6 flex-shrink-0">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Suites</h2>
                        <button id="close-sidebar" class="md:hidden text-gray-500 hover:text-gray-700 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mb-6 flex-shrink-0">
                    <div class="relative">
                        <input type="text" id="suite-search" placeholder="Search Suites" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700" autocomplete="off">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-6 flex-shrink-0">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-gray-100 border border-gray-300 rounded mr-3"></div>
                            <span class="text-gray-700">Vacant</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-blue-200 rounded mr-3"></div>
                            <span class="text-blue-600">Occupied</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-5 h-5 bg-green-200 rounded mr-3"></div>
                            <span class="text-green-600">Order Placed</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        END SIDEBAR COMMENT */ ?>

        <!-- Main Content -->
        <main id="main-content" class="ml-0 flex-1 overflow-y-auto h-full">
            
            <!-- Pending Orders Notification -->
            <div id="pending-orders-notification" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded-r-lg shadow-lg animate-pulse">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800" id="notification-title">Pending Orders Alert</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p id="notification-message">Some suites have not placed orders for tomorrow yet.</p>
                            <div id="notification-details" class="mt-2 text-xs"></div>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-red-100 rounded-md p-1.5 text-red-500 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-100 focus:ring-red-500" onclick="dismissNotification()">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Welcome Screen (shown initially) -->
            <div id="welcome-screen" class="max-w-7xl mx-auto px-6 sm:px-8 py-4 sm:py-6">
                
                <!-- NEW: Date Picker Section - MOVED ABOVE METRICS -->
                <div class="mb-6 bg-white rounded-xl shadow-md border border-gray-200 p-4 mx-2 overflow-visible">
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Icon & Title -->
                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <i class="fas fa-calendar-alt text-base text-white"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">Order Date:</span>
                        </div>
                        
                        <!-- Date Picker - NO TODAY, only tomorrow onwards, SELECTION ONLY -->
                        <div class="flex-shrink-0">
                            <input type="date" 
                                   id="order-date-picker" 
                                   class="px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm font-medium text-gray-800 cursor-pointer hover:border-blue-500 transition-all bg-white w-auto min-w-[150px]"
                                   min="<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>"
                                   max="<?php echo get_australia_date_offset(7); ?>"
                                   value="<?php echo get_australia_tomorrow(); ?>"
                                   onkeydown="return false;"
                                   onkeypress="return false;"
                                   onpaste="return false;"
                                   ondrop="return false;"
                                   autocomplete="off">
                        </div>
                        
                        <!-- Reset Button -->
                        <button type="button" onclick="resetToTomorrow()" 
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium text-sm flex items-center space-x-1.5 whitespace-nowrap flex-shrink-0">
                            <i class="fas fa-redo text-xs"></i>
                            <span>Reset</span>
                        </button>
                        
                        <!-- Divider -->
                        <div class="hidden lg:block h-6 w-px bg-gray-300 flex-shrink-0"></div>
                        
                        <!-- Currently Viewing -->
                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <i class="fas fa-eye text-blue-500 text-sm"></i>
                            <span class="text-xs text-gray-600 whitespace-nowrap">Viewing:</span>
                            <span id="selected-date-display" class="text-sm font-bold text-blue-600 whitespace-nowrap">
                                <?php $this->load->helper('custom'); echo format_australia_date(get_australia_tomorrow(), 'D, M d, Y'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Header Section with Hello User and Steps in one row -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8 px-2 gap-4 sm:gap-0">
                    <!-- Left side - Hello User -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800"><span class="text-blue-600"><?php echo $this->session->userdata('first_name') ?: 'User'; ?></span></h1>
                        <p class="text-gray-600 mt-1">Welcome to the Client Portal.</p>
                        
                        <!-- Order Summary -->
                        <?php if (isset($order_summary)): ?>
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <div id="metric-total-patients" class="text-blue-600 font-semibold"><?php echo $order_summary['total_patients']; ?></div>
                                <div class="text-blue-800">Total Patients</div>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <div id="metric-orders-placed" class="text-green-600 font-semibold"><?php echo $order_summary['patients_with_orders']; ?></div>
                                <div class="text-green-800">Orders Placed</div>
                            </div>
                            <div class="bg-orange-50 p-3 rounded-lg">
                                <div id="metric-pending-orders" class="text-orange-600 font-semibold"><?php echo $order_summary['patients_pending_orders']; ?></div>
                                <div class="text-orange-800">Pending Orders</div>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <div id="metric-occupied-suites" class="text-purple-600 font-semibold"><?php echo $order_summary['total_occupied_suites']; ?></div>
                                <div class="text-purple-800">Occupied Suites</div>
                            </div>
                        </div>
                        
                        <!-- CUTOFF TIME WARNING -->
                        <?php 
                        $userRole = $this->ion_auth->get_users_groups()->row()->id;
                        $this->load->helper('custom'); $currentTime = australia_date('H:i');
                        $isPastCutoff = ($userRole == 6 || $userRole == 4) && $currentTime >= '10:30';
                        ?>
                        <?php if ($isPastCutoff): ?>
                        <div class="mt-4 p-4 bg-red-100 border-2 border-red-400 rounded-lg animate-pulse">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="text-red-800 font-bold">⏰ Order Cutoff Time Passed!</h3>
                                    <p class="text-red-700 text-sm">Orders for tomorrow must be placed before 10:30 AM. Current time: <?php echo $currentTime; ?></p>
                                    <p class="text-red-600 text-xs mt-1">Contact a nurse for urgent orders.</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php endif; ?>
                    </div>
                    
                    <!-- Right side - Step Indicators -->
                    <div class="flex items-center space-x-6">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-search text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-semibold text-gray-800">Step 1</div>
                                <div class="text-xs text-gray-600">Search Suites</div>
                            </div>
                        </div>
                        
                        <!-- Dotted connector line -->
                        <div class="flex items-center">
                            <div class="w-8 border-t-2 border-dashed border-blue-300"></div>
                        </div>
                        
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                <i class="fas fa-utensils text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-semibold text-gray-800">Step 2</div>
                                <div class="text-xs text-gray-600">Place Order</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suite Selection Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6 mb-6 sm:mb-8 mx-2">
                    <!-- Title Section -->
                    <div class="text-left mb-4 sm:mb-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Select a suite</h2>
                        <p class="text-gray-600 text-sm sm:text-base">to start placing orders for the selected date!</p>
                    </div>

                    <!-- Search and Legend Row -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4 sm:gap-0">
                        <!-- Search Box -->
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <input type="text" id="suite-search-main" placeholder="Search Suites" 
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base"
                                       autocomplete="off" autocapitalize="off" spellcheck="false" 
                                       data-form-type="other" data-lpignore="true">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Suite Status Legend -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-end gap-3 sm:gap-4 lg:gap-8">
                            <div class="flex items-center">
                                <div class="w-4 h-4 sm:w-5 sm:h-5 bg-gray-200 border border-gray-300 rounded-md mr-2 sm:mr-3"></div>
                                <span class="text-xs sm:text-sm text-gray-600">Vacant</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 sm:w-5 sm:h-5 bg-green-300 rounded-md mr-2 sm:mr-3"></div>
                                <span class="text-xs sm:text-sm text-gray-600">Order Placed</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 sm:w-5 sm:h-5 bg-blue-300 rounded-md mr-2 sm:mr-3"></div>
                                <span class="text-xs sm:text-sm text-gray-600">Occupied</span>
                            </div>
                        </div>
                    </div>

                    <!-- Suite Grid -->
                    <div id="main-suite-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    <?php 
                    // Create a sample grid exactly matching the image - 5 rows of 5 suites each
                    $sampleSuites = [];
                    for ($i = 101; $i <= 125; $i++) {
                        // Set specific statuses to match the image pattern
                        if (in_array($i, [105, 106, 108, 113, 118, 123])) {
                            $status = 'order_placed';
                        } elseif (in_array($i, [111, 116, 121, 125])) {
                            $status = 'occupied';
                        } else {
                            $status = 'vacant';
                        }
                        
                        $sampleSuites[] = [
                            'id' => $i,
                            'bed_no' => $i,
                            'status' => $status
                        ];
                    }
                    
                    if (isset($bedLists) && !empty($bedLists)) {
                        foreach ($bedLists as $bedList) {
                            // SKIP suites with empty bed_no to prevent "Suite-Unknown" cards
                            if (empty($bedList['bed_no']) || trim($bedList['bed_no']) === '') {
                                continue;
                            }
                            
                            // Use is_vaccant field: 1 = vacant, 0 = occupied
                            $isVacant = !empty($bedList['is_vaccant']);
                            $occupied = !$isVacant ? 'true' : 'false';
                            $hasOrder = in_array($bedList['id'], $bedsWithOrders ?? []) ? 'true' : 'false';
                            
                            // 🆕 SPECIAL ITEMS FEATURE: Check for high allergies
                            $hasHighAllergies = !empty($bedList['has_high_allergies']);
                            $allergyCount = $bedList['allergy_count'] ?? 0;
                            $highAllergyClass = $hasHighAllergies ? 'high-allergy' : '';
                            
                            // Determine suite status and styling to match the exact image
                            if ($hasOrder === 'true') {
                                $bgClass = 'bg-green-200 border-2 border-green-400 text-green-800';
                                $statusText = 'Order Placed';
                            } elseif ($occupied === 'true') {
                                $bgClass = 'bg-blue-200 border-2 border-blue-400 text-blue-800';
                                $statusText = 'Occupied';
                            } else {
                                $bgClass = 'bg-white border-2 border-gray-400 text-gray-800';
                                $statusText = 'Vacant';
                            }
                            ?>
                            <button class="main-suite-btn min-h-20 p-3 <?php echo $bgClass; ?> <?php echo $highAllergyClass; ?> rounded-lg font-normal transition-all hover:scale-105 hover:shadow-md flex flex-col items-center justify-center relative" 
                                    data-occupied="<?php echo $occupied; ?>" 
                                    data-ordered="<?php echo $hasOrder; ?>" 
                                    data-bed-id="<?php echo $bedList['id']; ?>" 
                                    data-is-occupied="<?php echo $bedList['is_occupied'] ? 'true' : 'false'; ?>"
                                    data-allergy-count="<?php echo $allergyCount; ?>"
                                    data-has-high-allergies="<?php echo $hasHighAllergies ? 'true' : 'false'; ?>"
                                    title="<?php echo $statusText; ?><?php echo $hasHighAllergies ? ' - ' . $allergyCount . ' Allergies' : ''; ?>">
                                <?php if ($hasHighAllergies): ?>
                                    <span class="allergy-badge"><?php echo $allergyCount; ?> Allergies</span>
                                <?php endif; ?>
                                <div class="text-sm font-medium">
                                    <?php echo htmlspecialchars($bedList['bed_no']); ?>
                                </div>
                                <div class="text-xs mt-1"><?php echo $statusText; ?></div>
                            </button>
                    <?php }
                    } else {
                        // Show sample suites matching the image exactly
                        foreach ($sampleSuites as $suite) {
                            if ($suite['status'] == 'order_placed') {
                                $bgClass = 'bg-green-200 border-2 border-green-400 text-green-800';
                                $statusText = 'Order Placed';
                            } elseif ($suite['status'] == 'occupied') {
                                $bgClass = 'bg-blue-200 border-2 border-blue-400 text-blue-800';
                                $statusText = 'Occupied';
                            } else {
                                $bgClass = 'bg-white border-2 border-gray-400 text-gray-800';
                                $statusText = 'Vacant';
                            }
                            ?>
                            <button class="main-suite-btn h-16 p-3 <?php echo $bgClass; ?> rounded-lg font-normal transition-all hover:scale-105 hover:shadow-md flex flex-col items-center justify-center" 
                                    data-occupied="<?php echo $suite['status'] == 'occupied' ? 'true' : 'false'; ?>" 
                                    data-ordered="<?php echo $suite['status'] == 'order_placed' ? 'true' : 'false'; ?>" 
                                    data-bed-id="<?php echo $suite['id']; ?>" 
                                    title="<?php echo $statusText; ?>">
                                <div class="text-sm font-medium">Suite <?php echo $suite['bed_no']; ?></div>
                                <div class="text-xs mt-1"><?php echo $statusText; ?></div>
                            </button>
                    <?php }
                    } ?>
                    </div>
                </div>
            </div>
             
            <!-- Flash Messages - Always visible -->
            <div class="max-w-5xl mx-auto">
                <div class="successMessageSection">
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('success')) { ?>
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <div id="order-content" class="max-w-7xl mx-auto px-6 sm:px-8 py-4 sm:py-6" style="display: none;">

                <!-- Actions Bar -->
                <div id="content-area" class="hidden min-h-screen">
                    <!-- Header with suite info and back button -->
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <div class="flex flex-col">
                        <div class="flex items-center">
                            <button type="button" id="back-to-suites" class="mr-3 sm:mr-4 p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                            </button>
                            <div class="flex items-center space-x-3">
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800" id="selectedSuite">Suite 201</h1>
                                <!-- Print icon hidden for reception dashboard -->
                                <!-- <button type="button" 
                                        onclick="printMealSelection(event)" 
                                        class="p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 transition-all duration-200 shadow-sm hover:shadow-md"
                                        title="Print Meal Selection">
                                    <i class="fas fa-print text-xl"></i>
                                </button> -->
                                </div>
                            </div>
                            <div class="ml-2 sm:ml-3 mt-1">
                                <span id="order-date-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700 border border-green-200">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    Order Date: <span id="order-date-display"><?php echo date('D, M d, Y', strtotime('+1 day')); ?></span>
                                </span>
                            </div>
                        </div>
                        <!-- Room Service Checkbox and Override Button -->
                        <div class="flex items-center gap-4">
                            <!-- Room Service Checkbox -->
                            <div id="room-service-container" class="bg-gradient-to-r from-white to-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 ease-in-out">
                                <label class="flex items-center justify-between cursor-pointer" onclick="event.preventDefault();">
                                    <div class="flex items-center space-x-4">
                                        <input type="checkbox" id="room-service-checkbox" 
                                               class="w-6 h-6 text-green-600 border-2 border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:ring-offset-2 cursor-pointer transition-all hover:border-green-400" 
                                               onclick="handleRoomServiceClick(event)">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="text-xs font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 px-2.5 py-1 rounded-full shadow-sm">RS</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-concierge-bell text-2xl transition-all duration-300" id="room-service-icon"></i>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- Override Button -->
                            <button type="button" id="nurse-override-btn" 
                                    onclick="handleNurseOverrideClick()"
                                    class="bg-gradient-to-r from-white to-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 ease-in-out flex items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-white bg-gradient-to-r from-purple-500 to-purple-600 px-2.5 py-1 rounded-full shadow-sm">NO</span>
                                    <span class="text-sm font-medium text-gray-700">Override</span>
                                </div>
                                <i class="fas fa-user-nurse text-2xl text-gray-400 transition-all duration-300" id="nurse-override-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Order Status and Calories Info -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-0">
                        <div id="order-status-info" class="flex items-center bg-blue-50 px-4 py-2 rounded-lg" style="display: none;">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="text-blue-800 text-sm">Order already exists for this suite (<span class="order-count">0</span> items). You can modify or update the existing order.</span>
                        </div>
                        <div class="text-right pr-4 sm:pr-6" style="display: none;">
                            <div class="text-lg font-semibold text-gray-800">
                                Total Calories: <span id="suite-calories" class="text-blue-600">0 Kcal</span>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo base_url('Orderportal/Order/placeOrder'); ?>" id="placeOrder" method="post" class="form-horizontal" onsubmit="document.getElementById('nurse-override-field').value = (sessionStorage.getItem('nurseOverrideActive') === 'true') ? '1' : '0';">
                        <input type="hidden" name="selectedBed" id="selected-bed">
                        <input type="hidden" name="buttonType" id="button-type" value="sendorder">
                        <input type="hidden" name="nurseOverride" id="nurse-override-field" value="0">
                        <input type="hidden" name="orderDate" id="order-date-field" value="<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>">
                        
                        
                        
                        
                        
                        
                        
                        
                        <!-- Menu Status Information -->
                        <div id="menu-status-info" class="mb-4" style="display: none;">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                    <span class="text-yellow-800 text-sm font-medium">
                                        No published menu found for tomorrow. Showing all available menu items.
                                    </span>
                                </div>
                            </div>
                        </div>




                        <!-- Meal Sections -->
                        <div id="meal-sections" class="space-y-6"></div>

                        <!-- Notes Section -->
                        <div id="notes-section" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8 mt-5" style="display: none;">
                            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-note-sticky text-2xl text-primary-500 mr-3"></i>
                                    <h2 class="text-xl font-semibold">NOTES & ALLERGENS</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <textarea class="w-full h-24 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-500 transition-all" 
                                          id="notes-textarea" 
                                          name="notes" 
                                          placeholder="Enter any special notes or allergens..." 
                                          aria-label="Notes and allergens"><?php echo isset($orderCommentBedWise[$selectedBed]) ? htmlspecialchars($orderCommentBedWise[$selectedBed]) : ''; ?></textarea>
                                <div class="mt-2 text-right text-sm text-gray-500">
                                    <span id="char-count">0/500 characters</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Send Order Button -->
                        <div class="sticky bottom-4 bg-white rounded-xl shadow-lg border border-gray-200 p-6 mt-6 z-50">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">Ready to place your order?</h3>
                                    <p class="text-gray-600 text-sm md:text-base">Review your selections and submit your order for tomorrow.</p>
                                </div>
                                <button type="submit" class="save-order flex items-center justify-center px-6 md:px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm text-lg font-semibold w-full md:w-auto" aria-label="Send Order">
                                    <i class="fa-solid fa-paper-plane mr-3"></i>
                                    <span>Send Order</span>
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </main>

        <!-- PIN Verification Modal -->
        <div id="pin-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300 z-50">
            <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="pin-modal-content">
                <div class="flex items-center justify-center mb-4">
                    <i class="fa-solid fa-lock text-3xl text-success mr-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Enter PIN to Access Suite</h2>
                </div>
                <div class="mb-6">
                    <label for="pin-input" class="block text-sm font-medium text-gray-700 mb-2">4-Digit PIN</label>
                    <input type="password" id="pin-input" maxlength="4" class="w-full p-3 border border-gray-300 rounded-md text-center text-2xl tracking-widest" placeholder="••••" 
                           autocomplete="off" autocapitalize="off" spellcheck="false" 
                           data-form-type="other" data-lpignore="true" value="">
                </div>
                <div class="flex space-x-3">
                    <button type="button" id="cancel-pin" class="flex-1 py-2 px-4 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors duration-200">Cancel</button>
                    <button type="button" id="submit-pin" class="flex-1 py-2 px-4 bg-success text-white rounded-md hover:bg-primary-700 transition-colors duration-200">Submit</button>
                </div>
            </div>
        </div>

        <!-- Warning Modal -->
        <div id="warning-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300 z-50">
            <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="warning-modal-content">
                <div class="flex items-center justify-center mb-4">
                    <i class="fa-solid fa-exclamation-circle text-3xl text-warning mr-2"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Warning</h2>
                </div>
                <p id="warning-message" class="mb-6 text-gray-600 text-sm leading-relaxed"></p>
                <div class="flex justify-end">
                    <button type="button" id="close-warning" onclick="closeWarningModal()" class="py-2 px-4 bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition-colors duration-200">Close</button>
                </div>
            </div>
        </div>


        <!-- Description Modal -->
        <div id="description-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300 z-50">
            <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0 border border-gray-200" id="description-modal-content">
                <div class="flex items-center mb-6">
                    <i class="fa-solid fa-circle-info text-2xl text-blue-600 mr-3"></i>
                    <h2 class="text-xl font-bold text-gray-900">Item Description</h2>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-gray-800 text-base leading-relaxed" id="modalDescription"></p>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="close-description" onclick="closeDescriptionModal()" class="py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">Close</button>
                </div>
        </div>
    </div>

        <!-- Comment Modal -->
        <div id="comment-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300 z-50">
            <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0 border border-gray-200" id="comment-modal-content">
                <div class="flex items-center mb-6">
                    <i class="fa-solid fa-comment text-2xl text-orange-600 mr-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Add Comment</h3>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Suite:</strong> <span id="comment-suite-info"></span>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Menu:</strong> <span id="comment-menu-info"></span>
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        <strong>Item:</strong> <span id="comment-item-info"></span>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="comment-text" class="block text-sm font-medium text-gray-700 mb-2">Comment:</label>
                    <textarea id="comment-text" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none"
                              placeholder="Enter your comment for this menu item..."></textarea>
                    <div class="text-xs text-gray-500 mt-1">This comment will be visible to nurses and chefs.</div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" 
                            id="cancel-comment" 
                            onclick="console.log('Cancel onclick fired'); closeCommentModal(); return false;"
                            class="px-6 py-2.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 hover:border-gray-400 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-gray-300">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="button" 
                            id="save-comment" 
                            onclick="console.log('Save onclick fired'); saveMenuItemComment(); return false;"
                            class="px-6 py-2.5 bg-orange-600 text-white border border-orange-600 rounded-lg hover:bg-orange-700 hover:border-orange-700 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-300 shadow-sm">
                        <i class="fas fa-save mr-2"></i>Save Comment
                    </button>
                </div>
            </div>
        </div>

        <!-- Allergen Disclaimer Modal -->
        <div id="allergen-disclaimer-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden transition-opacity duration-300 z-50">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-2xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="allergen-disclaimer-modal-content">
                <div class="flex items-center justify-center mb-6">
                    <i class="fa-solid fa-triangle-exclamation text-4xl text-red-600 mr-3"></i>
                    <h2 class="text-2xl font-bold text-gray-900">ALLERGEN WARNING</h2>
                </div>
                
                <div class="mb-6 text-gray-700 space-y-4 max-h-96 overflow-y-auto px-2">
                    <p class="text-base leading-relaxed">
                        At <strong>Cafe Zenn</strong>, your wellbeing is our priority. While we take every precaution to minimise allergen cross-contamination, our kitchen handles ingredients containing common allergens. As such, we cannot guarantee that any menu item is completely free from allergens.
                    </p>
                    
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="font-semibold text-red-900 mb-2">Common allergens present in our kitchen include, but are not limited to:</p>
                        <p class="text-red-800">
                            Seafood, Fish, Crustacea, Egg, Gluten, Peanuts, Tree Nuts, Sesame, Dairy, Soy, Milk, Lupin, and Cereals containing gluten (such as wheat, rye, barley, oats, and spelt).
                        </p>
                    </div>
                    
                    <p class="text-base leading-relaxed">
                        If you have any food allergies or sensitivities, please notify your nursing staff, or a member of our staff, prior to ordering and we will endeavour to source a remedy. Otherwise we strongly suggest you seek professional advice from your healthcare provider before ordering.
                    </p>
                    
                    <p class="text-base leading-relaxed font-semibold">
                        By proceeding with your order, you acknowledge and accept this conditional circumstances.
                    </p>
                    
                    <p class="text-base leading-relaxed text-center italic">
                        Thank you for choosing <strong>Cafe Zenn</strong>.
                    </p>
                </div>
                
                <div class="flex justify-center space-x-4 mt-6">
                    <button type="button" 
                            id="allergen-accept-btn"
                            onclick="acceptAllergenDisclaimer()"
                            class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-green-300 shadow-lg">
                        <i class="fas fa-check mr-2"></i>I Understand & Accept
                    </button>
                </div>
            </div>
        </div>

        <!-- Loader Overlay -->
        <div id="loader" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary-600"></div>
        </div>
    </div>

    <script>
        // Global variables for comment modal - declared at the top
        let currentCommentData = {};
        let currentBedId = ''; // Global variable for current selected bed/suite ID
        // Removed allergenDisclaimerAccepted flag - always show disclaimer for every suite
        let pendingBedElement = null; // Store the bed element while waiting for disclaimer acceptance
        
        // NEW: Global variable for selected order date (Reception Dashboard)
        // Check if we're in the same session (navigating back from order submission)
        // If yes, restore the selected date. If fresh load, default to tomorrow.
        // Reception CANNOT select today, only tomorrow onwards (min date is tomorrow)
        let selectedOrderDate;
        
        // Check if this is a navigation within the same session
        const isNavigatingBack = sessionStorage.getItem('receptionNavigating') === 'true';
        if (isNavigatingBack) {
            // Restore from session storage if available
            selectedOrderDate = sessionStorage.getItem('receptionSelectedOrderDate') || '<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>';
        } else {
            // Fresh page load - default to tomorrow
            selectedOrderDate = '<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>';
        }
        
        // Clear the navigation flag
        sessionStorage.removeItem('receptionNavigating');
        
        let bedLists = <?php echo json_encode($bedLists ?? []); ?>; // Changed to let for dynamic updates
        let bedsWithOrders = <?php echo json_encode($bedsWithOrders ?? []); ?>; // Track orders dynamically
        const categoryListData = <?php echo json_encode($categoryListData ?? []); ?>;
        const menuLists = <?php echo json_encode($menuLists ?? []); ?>;
        const patientOrderData = <?php echo json_encode($patientOrderData ?? []); ?>;
        
        // Close description modal function
        function closeDescriptionModal() {
            const modal = document.getElementById('description-modal');
            const modalContent = document.getElementById('description-modal-content');
            if (modal && modalContent) {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }
        
        // Auto-refresh dashboard at 5 AM and 4 PM Australian time
        function scheduleNextRefresh() {
            // Get current time in Australian timezone
            const now = new Date();
            const australiaTime = new Date(now.toLocaleString('en-US', { timeZone: 'Australia/Sydney' }));
            
            // Get current hours and minutes
            const currentHours = australiaTime.getHours();
            const currentMinutes = australiaTime.getMinutes();
            const currentSeconds = australiaTime.getSeconds();
            
            // Calculate next refresh time (5 AM or 4 PM)
            let nextRefreshHours;
            let nextRefreshDate = new Date(australiaTime);
            
            if (currentHours < 5) {
                // Before 5 AM - refresh at 5 AM today
                nextRefreshHours = 5;
            } else if (currentHours < 16) {
                // Between 5 AM and 4 PM - refresh at 4 PM today
                nextRefreshHours = 16;
            } else {
                // After 4 PM - refresh at 5 AM tomorrow
                nextRefreshHours = 5;
                nextRefreshDate.setDate(nextRefreshDate.getDate() + 1);
            }
            
            // Set the next refresh time
            nextRefreshDate.setHours(nextRefreshHours, 0, 0, 0);
            
            // Calculate milliseconds until next refresh
            const timeUntilRefresh = nextRefreshDate.getTime() - australiaTime.getTime();
            
            // Format next refresh time for logging
            const nextRefreshTimeStr = nextRefreshDate.toLocaleString('en-AU', { 
                timeZone: 'Australia/Sydney',
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            
            
            // Set timeout for next refresh
            setTimeout(function() {
                
                // Show toast notification before refresh
                showAutoRefreshToast();
                
                // Wait 3 seconds, then reload
                setTimeout(function() {
                    location.reload();
                }, 3000);
            }, timeUntilRefresh);
        }
        
        // Initialize the scheduled refresh
        scheduleNextRefresh();
        
        // Function to show auto-refresh toast notification
        function showAutoRefreshToast() {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] flex items-center space-x-3 animate-slide-in';
            toast.innerHTML = `
                <i class="fas fa-sync-alt fa-spin text-2xl"></i>
                <div>
                    <div class="font-bold">Auto-Refresh in Progress</div>
                    <div class="text-sm">Dashboard will reload in 3 seconds...</div>
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
        
        // NEW: Date Picker Functions for Reception Dashboard
        function resetToTomorrow() {
            const tomorrow = '<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>';
            document.getElementById('order-date-picker').value = tomorrow;
            handleDateChange(tomorrow);
        }
        
        function handleDateChange(newDate) {
            selectedOrderDate = newDate;
            
            // Store in sessionStorage for persistence during navigation (like after sending order)
            sessionStorage.setItem('receptionSelectedOrderDate', newDate);
            
            // Update all date displays
            updateDateDisplays(newDate);
            
            // Update hidden form field
            const orderDateField = document.getElementById('order-date-field');
            if (orderDateField) {
                orderDateField.value = newDate;
            }
            
            // Show loading indicator
            showDateChangeLoader();
            
            // UPDATED: Refresh suite status for the new date (like Nurse Dashboard)
            refreshSuiteStatusForDate(newDate);
            
            // If a suite is currently open, close it and return to suite selection
            if (document.getElementById('order-content').style.display !== 'none') {
                document.getElementById('order-content').style.display = 'none';
                document.getElementById('welcome-screen').style.display = 'block';
                document.getElementById('sidebar').classList.add('hidden');
                document.getElementById('main-content').classList.remove('lg:ml-72');
                document.getElementById('main-content').classList.add('ml-0');
            }
        }
        
        function updateDateDisplays(dateStr) {
            // Format date for compact display (e.g., "Mon, Jan 15, 2024")
            const date = new Date(dateStr + 'T00:00:00');
            const optionsShort = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
            const formattedShort = date.toLocaleDateString('en-US', optionsShort);
            
            // Update display
            const selectedDateDisplay = document.getElementById('selected-date-display');
            if (selectedDateDisplay) selectedDateDisplay.textContent = formattedShort;
            
            // Update order date badge in suite header
            const orderDateDisplay = document.getElementById('order-date-display');
            if (orderDateDisplay) orderDateDisplay.textContent = formattedShort;
        }
        
        function showDateChangeLoader() {
            // Show a loading toast
            const toast = document.createElement('div');
            toast.id = 'date-change-loader';
            toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] flex items-center space-x-3';
            toast.innerHTML = `
                <i class="fas fa-calendar-check text-2xl"></i>
                <div>
                    <div class="font-bold">Date Updated</div>
                    <div class="text-sm">Orders will be placed for selected date</div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 2 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 300);
                }
            }, 2000);
        }
        
        // NEW: Refresh suite status for selected date (Reception)
        function refreshSuiteStatusForDate(dateStr) {
            
            // Call backend to get updated suite status for the selected date
            fetch('<?php echo base_url('Orderportal/Home/getSuiteStatusForDate'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'order_date=' + encodeURIComponent(dateStr)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateSuiteStatusDisplay(data.bedLists, data.bedsWithOrders || []);
                    
                    // Update metrics if provided
                    if (data.metrics) {
                        updateMetricsDisplay(data.metrics);
                    }
                    
                    // Hide loader after a short delay
                    setTimeout(() => {
                        const loader = document.getElementById('date-change-loader');
                        if (loader && loader.parentNode) {
                            loader.style.opacity = '0';
                            setTimeout(() => {
                                if (loader.parentNode) {
                                    loader.parentNode.removeChild(loader);
                                }
                            }, 300);
                        }
                    }, 500);
                    
                    showSuccessToast('Suite status updated for ' + dateStr);
                } else {
                    console.error('❌ Reception: Failed to fetch suite status:', data.message);
                    showErrorToast('Failed to update suite status');
                }
            })
            .catch(error => {
                console.error('❌ Reception: Error fetching suite status:', error);
                showErrorToast('Error updating suite status');
            });
        }
        
        // NEW: Update suite status display (Reception)
        function updateSuiteStatusDisplay(bedListsData, bedsWithOrdersData) {
            // Update global variables with new data
            bedLists = bedListsData;
            bedsWithOrders = bedsWithOrdersData;
            
            // Update both sidebar and main grid
            updateSidebarSuites(bedListsData, bedsWithOrdersData);
            updateMainGridSuites(bedListsData, bedsWithOrdersData);
        }
        
        // NEW: Update metrics display (Reception)
        function updateMetricsDisplay(metrics) {
            // Update each metric with animation
            const metricElements = {
                'metric-total-patients': metrics.total_patients,
                'metric-orders-placed': metrics.patients_with_orders,
                'metric-pending-orders': metrics.patients_pending_orders,
                'metric-occupied-suites': metrics.total_occupied_suites
            };
            
            Object.keys(metricElements).forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    // Add a brief animation
                    element.style.transform = 'scale(1.2)';
                    element.style.transition = 'transform 0.3s ease';
                    
                    setTimeout(() => {
                        element.textContent = metricElements[id];
                        element.style.transform = 'scale(1)';
                    }, 150);
                }
            });
            
        }
        
        // NEW: Update sidebar suites (Reception)
        function updateSidebarSuites(bedListsData, bedsWithOrdersData) {
            const suitesContainer = document.getElementById('suites-container');
            if (!suitesContainer) return;
            
            // Clear and rebuild sidebar suites
            suitesContainer.innerHTML = '';
            
            bedListsData.forEach(bedList => {
                if (!bedList.bed_no || bedList.bed_no.trim() === '') return;
                
                const isVacant = bedList.is_vaccant == 1;
                const hasOrder = bedsWithOrdersData.includes(parseInt(bedList.id)) || 
                                 bedsWithOrdersData.includes(String(bedList.id)) ||
                                 bedsWithOrdersData.includes(bedList.id);
                
                // 🆕 SPECIAL ITEMS FEATURE: Check for high allergies
                const hasHighAllergies = bedList.has_high_allergies === true || bedList.has_high_allergies === 1;
                const allergyCount = bedList.allergy_count || 0;
                const highAllergyClass = hasHighAllergies ? 'high-allergy' : '';
                
                let bgClass, statusText;
                if (hasOrder) {
                    bgClass = 'bg-green-200 text-gray-800 border-green-300';
                    statusText = 'Order Placed';
                } else if (!isVacant) {
                    bgClass = 'bg-blue-200 text-blue-800 border-blue-300';
                    statusText = 'Occupied';
                } else {
                    bgClass = 'bg-white text-gray-700 border-gray-300';
                    statusText = 'Vacant';
                }
                
                const button = document.createElement('button');
                button.id = `suite-${bedList.id}`;
                button.className = `clientLists w-full px-4 py-3 ${bgClass} ${highAllergyClass} rounded-lg border transition-all hover:shadow-md flex flex-col items-center justify-center text-center min-h-20 relative`;
                button.setAttribute('data-occupied', !isVacant ? 'true' : 'false');
                button.setAttribute('data-ordered', hasOrder ? 'true' : 'false');
                button.setAttribute('data-bed-id', bedList.id);
                button.setAttribute('data-is-occupied', bedList.is_occupied ? 'true' : 'false');
                button.setAttribute('data-allergy-count', allergyCount);
                button.setAttribute('data-has-high-allergies', hasHighAllergies ? 'true' : 'false');
                button.setAttribute('title', `${statusText}${bedList.patient_name ? ' - Patient: ' + bedList.patient_name : ''}${hasHighAllergies ? ' - ' + allergyCount + ' Allergies' : ''}`);
                
                button.innerHTML = `
                    ${hasHighAllergies ? `<span class="allergy-badge">${allergyCount} Allergies</span>` : ''}
                    <div class="font-semibold text-base">Suite ${bedList.bed_no}</div>
                    ${bedList.patient_name ? `<div class="text-xs text-blue-600 font-medium truncate w-full px-1" title="${bedList.patient_name}">${bedList.patient_name}</div>` : ''}
                    <div class="text-sm text-gray-600 mt-1">${statusText}</div>
                `;
                
                button.addEventListener('click', function() {
                    handleSuiteSelection(this);
                });
                
                suitesContainer.appendChild(button);
            });
        }
        
        // NEW: Update main grid suites (Reception)
        function updateMainGridSuites(bedListsData, bedsWithOrdersData) {
            const mainGrid = document.getElementById('main-suite-grid');
            if (!mainGrid) return;
            
            // Clear and rebuild main grid suites
            mainGrid.innerHTML = '';
            
            bedListsData.forEach(bedList => {
                if (!bedList.bed_no || bedList.bed_no.trim() === '') return;
                
                const isVacant = bedList.is_vaccant == 1;
                const hasOrder = bedsWithOrdersData.includes(parseInt(bedList.id)) || 
                                 bedsWithOrdersData.includes(String(bedList.id)) ||
                                 bedsWithOrdersData.includes(bedList.id);
                
                // 🆕 SPECIAL ITEMS FEATURE: Check for high allergies
                const hasHighAllergies = bedList.has_high_allergies === true || bedList.has_high_allergies === 1;
                const allergyCount = bedList.allergy_count || 0;
                const highAllergyClass = hasHighAllergies ? 'high-allergy' : '';
                
                let bgClass, statusText;
                if (hasOrder) {
                    bgClass = 'bg-green-200 border-2 border-green-400 text-green-800';
                    statusText = 'Order Placed';
                } else if (!isVacant) {
                    bgClass = 'bg-blue-200 border-2 border-blue-400 text-blue-800';
                    statusText = 'Occupied';
                } else {
                    bgClass = 'bg-white border-2 border-gray-400 text-gray-800';
                    statusText = 'Vacant';
                }
                
                const button = document.createElement('button');
                button.className = `main-suite-btn min-h-20 p-3 ${bgClass} ${highAllergyClass} rounded-lg font-normal transition-all hover:scale-105 hover:shadow-md flex flex-col items-center justify-center relative`;
                button.setAttribute('data-occupied', !isVacant ? 'true' : 'false');
                button.setAttribute('data-ordered', hasOrder ? 'true' : 'false');
                button.setAttribute('data-bed-id', bedList.id);
                button.setAttribute('data-is-occupied', bedList.is_occupied ? 'true' : 'false');
                button.setAttribute('data-allergy-count', allergyCount);
                button.setAttribute('data-has-high-allergies', hasHighAllergies ? 'true' : 'false');
                button.setAttribute('title', `${statusText}${bedList.patient_name ? ' - Patient: ' + bedList.patient_name : ''}${hasHighAllergies ? ' - ' + allergyCount + ' Allergies' : ''}`);
                
                button.innerHTML = `
                    ${hasHighAllergies ? `<span class="allergy-badge">${allergyCount} Allergies</span>` : ''}
                    <div class="text-sm font-medium">${bedList.bed_no}</div>
                    ${bedList.patient_name ? `<div class="text-xs text-blue-600 font-medium truncate w-full px-1" title="${bedList.patient_name}">${bedList.patient_name}</div>` : ''}
                    <div class="text-xs mt-1">${statusText}</div>
                `;
                
                // Add click event listener
                button.addEventListener('click', function() {
                    handleSuiteSelection(this);
                });
                
                mainGrid.appendChild(button);
            });
        }
        
        const savedMenuWithoutOptions = <?php echo json_encode($savedMenuWithoutOptions ?? []); ?>;
        const savedMenuWithOptions = <?php echo json_encode($savedMenuWithOptions ?? []); ?>;
        const hasPublishedMenu = <?php echo json_encode($hasPublishedMenu ?? true); ?>;
        const orderCommentBedWise = <?php echo json_encode($orderCommentBedWise ?? []); ?>;
        
        // Global function to force clear all cached inputs and reset UI
        window.forceClearReceptionDashboard = function() {
            
            // Clear all input fields
            const inputs = document.querySelectorAll('input[type="text"], input[type="password"], textarea');
            inputs.forEach(input => {
                input.value = '';
                input.defaultValue = '';
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                }
            });
            
            // Reset all suite displays
            const allSuiteButtons = document.querySelectorAll('#main-suite-grid .main-suite-btn, #suites-container .clientLists');
            allSuiteButtons.forEach(button => {
                button.style.display = '';
                button.style.display = button.classList.contains('main-suite-btn') ? 'block' : 'flex';
                button.classList.remove('ring-4', 'ring-blue-300', 'ring-2', 'ring-blue-500', 'ring-offset-2', 'shadow-lg', 'scale-105');
                button.style.transform = '';
                button.style.boxShadow = '';
                button.style.border = '';
                button.style.backgroundColor = '';
            });
            
            // Clear any form selections
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => radio.checked = false);
            
            // Clear browser form data
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Aggressively clear ALL cached input values on page load
            const suiteSearch = document.getElementById('suite-search');
            const suiteSearchMain = document.getElementById('suite-search-main');
            const pinInput = document.getElementById('pin-input');
            
            // Function to clear all inputs
            function clearAllInputs() {
                // Clear sidebar search
                if (suiteSearch) {
                    suiteSearch.value = '';
                    suiteSearch.defaultValue = '';
                    suiteSearch.removeAttribute('readonly');
                }
                
                // Clear main search input
                if (suiteSearchMain) {
                    suiteSearchMain.value = '';
                    suiteSearchMain.defaultValue = '';
                    suiteSearchMain.removeAttribute('readonly');
                }
                
                // Clear PIN input
                if (pinInput) {
                    pinInput.value = '';
                    pinInput.defaultValue = '';
                }
                
                // Reset all suite displays to be visible
                const allSuiteButtons = document.querySelectorAll('#main-suite-grid .main-suite-btn, #suites-container .clientLists');
                allSuiteButtons.forEach(button => {
                    button.style.display = '';
                    button.style.display = button.classList.contains('main-suite-btn') ? 'block' : 'flex';
                    button.classList.remove('ring-4', 'ring-blue-300', 'ring-2', 'ring-blue-500', 'ring-offset-2', 'shadow-lg', 'scale-105');
                    button.style.transform = '';
                    button.style.boxShadow = '';
                    button.style.border = '';
                    button.style.backgroundColor = '';
                });
                
            }
            
            // Multiple clearing attempts with different timings
            clearAllInputs();
            
            // Clear after a small delay to handle browser autofill
            setTimeout(clearAllInputs, 100);
            
            // Clear again after page is more loaded
            setTimeout(clearAllInputs, 500);
            
            // Clear once more to ensure everything is clean
            setTimeout(clearAllInputs, 1000);
            
            // NEW: Initialize date picker with tomorrow's date
            const datePicker = document.getElementById('order-date-picker');
            if (datePicker) {
                datePicker.value = selectedOrderDate;
                updateDateDisplays(selectedOrderDate);
                
                // Add change event listener
                datePicker.addEventListener('change', function() {
                    const newDate = this.value;
                    if (newDate) {
                        handleDateChange(newDate);
                    }
                });
                
            }
            
            // Additional clearing on window load
            window.addEventListener('load', clearAllInputs);
            
            // Clear when page becomes visible (handles browser back/forward)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    clearAllInputs();
                }
            });
            
            // Clear on page show event (handles browser cache)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    clearAllInputs();
                }
            });
            
            // Clear on focus events for inputs (backup)
            if (suiteSearch) {
                suiteSearch.addEventListener('focus', function() {
                    if (this.value && this.value.length > 0) {
                        this.value = '';
                        clearAllInputs();
                    }
                });
            }
            
            if (suiteSearchMain) {
                suiteSearchMain.addEventListener('focus', function() {
                    if (this.value && this.value.length > 0) {
                        this.value = '';
                        clearAllInputs();
                    }
                });
            }
            
            // Update character count for notes
            const notesTextarea = document.getElementById('notes-textarea');
            const charCount = document.getElementById('char-count');
            function updateCharCount() {
                const length = notesTextarea.value.length;
                charCount.textContent = `${length}/500 characters`;
            }
            notesTextarea.addEventListener('input', updateCharCount);

            // Suite search functionality for main grid
            document.getElementById('suite-search-main').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const suiteButtons = document.querySelectorAll('#main-suite-grid .main-suite-btn');
                
                suiteButtons.forEach(button => {
                    const suiteText = button.textContent.toLowerCase();
                    if (suiteText.includes(searchTerm)) {
                        button.style.display = 'block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            });
            
            // Add clear button functionality for main search
            document.getElementById('suite-search-main').addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    clearAllInputs();
                }
            });

            // Main suite grid selection
            // currentBedId is now declared globally at the top of the script
            
            // Handle both sidebar and main grid suite selection
            function handleSuiteSelection(bedElement) {
                const newBedId = bedElement.getAttribute('data-bed-id');
                
                if (!newBedId) {
                    return;
                }
                
                // Check if suite is occupied - only allow orders for occupied suites
                const isOccupied = bedElement.getAttribute('data-is-occupied') === 'true';
                
                if (!isOccupied) {
                    // Show error message for vacant suites
                    const bed = bedLists.find(b => b.id == newBedId);
                    const suiteNumber = bed?.bed_no || newBedId;
                    
                    // Create and show error modal
                    showVacantSuiteError(suiteNumber);
                    return;
                }
                
                // Clear any stale success data when switching suites
                sessionStorage.removeItem('orderSuccess');
                
                // Reset form state when switching suites
                if (currentBedId !== newBedId && currentBedId !== '') {
                    resetOrderForm();
                }
                
                currentBedId = newBedId;
                
                const bed = bedLists.find(b => b.id == currentBedId);
                const suiteNumber = bed?.bed_no || newBedId;
                
                document.getElementById('selectedSuite').textContent = `Suite No : ${suiteNumber}`;

                // RECEPTION: Show PIN modal for verification
                showPinModal(bedElement);
            }
            
            // Show error message for vacant suites
            function showVacantSuiteError(suiteNumber) {
                // Create error modal HTML
                const errorModal = document.createElement('div');
                errorModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                errorModal.innerHTML = `
                    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md mx-4 transform transition-all duration-300 ease-in-out">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                            <h3 class="text-lg font-bold text-red-800">Suite Not Available</h3>
                        </div>
                        <div class="mb-6">
                            <p class="text-gray-700 mb-3">
                                <strong>Suite ${suiteNumber}</strong> is currently vacant.
                            </p>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Orders can only be placed for occupied suites with patients. 
                                Please select an occupied suite to place an order.
                            </p>
                        </div>
                        <div class="flex justify-center">
                            <button id="understood-btn" 
                                    class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-red-300">
                                <i class="fas fa-check mr-2"></i>Understood
                            </button>
                        </div>
                    </div>
                `;
                
                // Add to page
                document.body.appendChild(errorModal);
                
                // Store reference for closing
                window.currentErrorModal = errorModal;
                
                // Add click event listener to the button
                const understoodBtn = errorModal.querySelector('#understood-btn');
                if (understoodBtn) {
                    understoodBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        closeVacantSuiteError();
                    });
                }
                
                // Also allow clicking outside the modal to close it
                errorModal.addEventListener('click', function(e) {
                    if (e.target === errorModal) {
                        closeVacantSuiteError();
                    }
                });
                
                // Auto-close after 8 seconds (increased time)
                setTimeout(() => {
                    if (window.currentErrorModal) {
                        closeVacantSuiteError();
                    }
                }, 8000);
            }
            
            // Close vacant suite error modal
            function closeVacantSuiteError() {
                if (window.currentErrorModal) {
                    // Add fade-out animation
                    window.currentErrorModal.style.opacity = '0';
                    window.currentErrorModal.style.transition = 'opacity 0.3s ease-out';
                    
                    // Remove after animation completes
                    setTimeout(() => {
                        if (window.currentErrorModal) {
                            window.currentErrorModal.remove();
                            window.currentErrorModal = null;
                        }
                    }, 300);
                }
            }
            
            // RECEPTION: Show PIN Modal for suite verification
            function showPinModal(bedElement) {
                // Store bed element for after PIN success
                window.currentBedElementForPin = bedElement;
                
                // Show PIN modal
                document.getElementById('pin-modal').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('pin-modal-content').classList.add('scale-100', 'opacity-100');
                    document.getElementById('pin-input').focus();
                }, 10);
                
                // Handle PIN submission
                document.getElementById('submit-pin').onclick = function() {
                    const pin = document.getElementById('pin-input').value;
                    if (pin.length !== 4) {
                        alert('Please enter a 4-digit PIN');
                        return;
                    }
                    
                    document.getElementById('loader').classList.remove('hidden');
                    fetch('<?php echo base_url('Orderportal/Order/verifyPin'); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'bed_id=' + encodeURIComponent(currentBedId) + '&pin=' + encodeURIComponent(pin)
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loader').classList.add('hidden');
                        if (data.success) {
                            // PIN verified successfully
                            closePinModal();
                            
                            // Now show allergen disclaimer AFTER PIN success
                            openSuiteInterface(window.currentBedElementForPin);
                        } else {
                            alert('Invalid PIN. Please try again.');
                            document.getElementById('pin-input').value = '';
                            document.getElementById('pin-input').focus();
                        }
                    })
                    .catch(error => {
                        document.getElementById('loader').classList.add('hidden');
                        alert('Error verifying PIN. Please try again.');
                        document.getElementById('pin-input').value = '';
                    });
                };
            }
            
            // Close PIN modal
            function closePinModal() {
                document.getElementById('pin-modal').classList.add('hidden');
                document.getElementById('pin-input').value = '';
                document.getElementById('pin-modal-content').classList.remove('scale-100', 'opacity-100');
            }
            
            // Function to open suite interface after PIN verification
            // Opens menu screen first, then shows allergen modal
            function openSuiteInterface(bedElement) {
                // Open the menu screen immediately after PIN success
                proceedToOpenSuite(bedElement);
                
                // THEN show allergen disclaimer INSIDE the menu screen EVERY TIME for ALL suites
                // Store the bed element
                pendingBedElement = bedElement;
                // Delay slightly to let menu screen render first
                setTimeout(() => {
                    showAllergenDisclaimerModal();
                }, 300);
            }
            
            // Function to actually open the suite (called after disclaimer acceptance)
            function proceedToOpenSuite(bedElement) {
                // Update main grid selection
                document.querySelectorAll('#main-suite-grid .main-suite-btn').forEach(b => {
                    b.classList.remove('ring-4', 'ring-blue-300');
                });
                bedElement.classList.add('ring-4', 'ring-blue-300');
                
                // Hide welcome screen and show order content
                document.getElementById('welcome-screen').style.display = 'none';
                document.getElementById('order-content').style.display = 'block';
                document.getElementById('content-area').classList.remove('hidden');
                
                // RECEPTION: No sidebar (removed), keep main content at ml-0
                document.getElementById('selected-bed').value = currentBedId;
                
                // NEW: Update the hidden order date field with the selected date
                document.getElementById('order-date-field').value = selectedOrderDate;
                
                // Check if order already exists for this bed (with selected date)
                checkExistingOrder(currentBedId, selectedOrderDate);
                
                // Check update permissions
                checkUpdatePermissions(currentBedId);
                        
                // NEW: Render meal sections with the selected date (dynamic menu loading)
                renderMealSections(currentBedId, selectedOrderDate);
                updateCharCount();
                
                // Restore Override UI if active
                const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                if (nurseOverrideActive) {
                    const nurseName = sessionStorage.getItem('nurseOverrideName') || 'Nurse';
                    updateNurseOverrideUI(true, nurseName);
                }
                
                updateSuiteCalories(currentBedId);
                
                // NEW: Load Room Service status with the selected date
                loadRoomServiceStatus(selectedOrderDate);
                
                // Setup event listeners after rendering
                setTimeout(() => {
                    setupMenuEventListeners();
                    updateChoiceCounters();
                    updateCategoryCalories();
                    
                    // Additional delays to ensure all elements are rendered
                    setTimeout(() => {
                        updateCategoryCalories();
                    }, 300);
                    
                    setTimeout(() => {
                        updateCategoryCalories();
                    }, 500);
                    
                    setTimeout(() => {
                        updateCategoryCalories();
                    }, 1000);
                }, 100);
            }
            
            // Keep original PIN logic for potential future use or other user types
            function handleSuiteSelectionWithPIN(bedElement) {
                document.getElementById('pin-modal').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('pin-modal-content').classList.add('scale-100', 'opacity-100');
                }, 10);
                
                document.getElementById('submit-pin').onclick = function() {
                    const pin = document.getElementById('pin-input').value;
                    if (pin.length === 4) {
                        document.getElementById('loader').classList.remove('hidden');
                        fetch('<?php echo base_url('Orderportal/Order/verifyPin'); ?>', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'bed_id=' + encodeURIComponent(currentBedId) + '&pin=' + encodeURIComponent(pin)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('pin-modal').classList.add('hidden');
                                document.getElementById('pin-input').value = '';
                                document.getElementById('pin-modal-content').classList.remove('scale-100', 'opacity-100');
                                
                                // REMOVED: No special "selected" styling for sidebar - only show order status colors
                                // Green = Order Placed, Blue = Occupied, White = Vacant
                                
                                // Update main grid selection
                                document.querySelectorAll('#main-suite-grid .main-suite-btn').forEach(b => {
                                    b.classList.remove('ring-4', 'ring-blue-300');
                                });
                                bedElement.classList.add('ring-4', 'ring-blue-300');
                                
                                // Hide welcome screen and show order content
                                document.getElementById('welcome-screen').style.display = 'none';
                                document.getElementById('order-content').style.display = 'block';
                                document.getElementById('content-area').classList.remove('hidden');
                                
                                // Show sidebar when in order mode
                                document.getElementById('sidebar').classList.remove('hidden');
                                document.getElementById('sidebar').classList.add('lg:block');
                                document.getElementById('main-content').classList.remove('ml-0');
                                document.getElementById('main-content').classList.add('lg:ml-72');
                                document.getElementById('selected-bed').value = currentBedId;
                                
                                // Check if order already exists for this bed
                                checkExistingOrder(currentBedId);
                                
                                // Check update permissions
                                checkUpdatePermissions(currentBedId);
                                        
                                renderMealSections(currentBedId);
                                updateCharCount();
                                
                                // Restore Override UI if active
                                const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                                if (nurseOverrideActive) {
                                    const nurseName = sessionStorage.getItem('nurseOverrideName') || 'Nurse';
                                    updateNurseOverrideUI(true, nurseName);
                                }
                                updateSuiteCalories(currentBedId);
                                
                                // Setup event listeners after rendering
                                setTimeout(() => {
                                    setupMenuEventListeners();
                                    updateChoiceCounters();
                                    updateCategoryCalories();
                                    
                                    // Additional delays to ensure all elements are rendered
                                    setTimeout(() => {
                                        updateCategoryCalories();
                                    }, 300);
                                    
                                    setTimeout(() => {
                                        updateCategoryCalories();
                                    }, 500);
                                    
                                    setTimeout(() => {
                                        updateCategoryCalories();
                                    }, 1000);
                                }, 100);
                            } else {
                                document.getElementById('warning-message').textContent = 'Invalid PIN. Please try again.';
                                document.getElementById('warning-modal').classList.remove('hidden');
                                setTimeout(() => {
                                    document.getElementById('warning-modal-content').classList.add('scale-100', 'opacity-100');
                                }, 10);
                            }
                            document.getElementById('loader').classList.add('hidden');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('warning-message').textContent = 'An error occurred. Please try again.';
                            document.getElementById('warning-modal').classList.remove('hidden');
                            setTimeout(() => {
                                document.getElementById('warning-modal-content').classList.add('scale-100', 'opacity-100');
                            }, 10);
                            document.getElementById('loader').classList.add('hidden');
                        });
                    } else {
                        document.getElementById('warning-message').textContent = 'Please enter a 4-digit PIN.';
                        document.getElementById('warning-modal').classList.remove('hidden');
                        setTimeout(() => {
                            document.getElementById('warning-modal-content').classList.add('scale-100', 'opacity-100');
                        }, 10);
                    }
                };
            }
            
            // Sidebar bed selection
            document.querySelectorAll('#sidebar .clientLists').forEach(bed => {
                bed.addEventListener('click', function() {
                    handleSuiteSelection(this);
                });
            });
            
            // Main grid suite selection - use event delegation to handle dynamically generated buttons
            const mainSuiteGrid = document.getElementById('main-suite-grid');
            if (mainSuiteGrid) {
                mainSuiteGrid.addEventListener('click', function(e) {
                    const button = e.target.closest('.main-suite-btn');
                    if (button) {
                        handleSuiteSelection(button);
                    }
                });
            }

            // Cancel PIN modal
            document.getElementById('cancel-pin').addEventListener('click', () => {
                document.getElementById('pin-modal').classList.add('hidden');
                document.getElementById('pin-input').value = '';
                document.getElementById('pin-modal-content').classList.remove('scale-100', 'opacity-100');
                
                // Hide sidebar and show welcome screen when PIN is cancelled
                document.getElementById('sidebar').classList.add('hidden');
                document.getElementById('sidebar').classList.remove('lg:block');
                document.getElementById('main-content').classList.add('ml-0');
                                document.getElementById('main-content').classList.remove('lg:ml-72');
                document.getElementById('welcome-screen').style.display = 'block';
                document.getElementById('order-content').style.display = 'none';
                
                // Remove selection highlights
                document.querySelectorAll('#main-suite-grid .main-suite-btn').forEach(b => {
                    b.classList.remove('ring-4', 'ring-blue-300');
                });
            });

            // Clear PIN input when modal is closed by any means
            document.getElementById('pin-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    document.getElementById('pin-input').value = '';
                    document.getElementById('pin-modal').classList.add('hidden');
                    document.getElementById('pin-modal-content').classList.remove('scale-100', 'opacity-100');
                    
                    // Hide sidebar and show welcome screen when clicking outside modal
                    document.getElementById('sidebar').classList.add('hidden');
                    document.getElementById('sidebar').classList.remove('lg:block');
                    document.getElementById('main-content').classList.add('ml-0');
                                document.getElementById('main-content').classList.remove('lg:ml-72');
                    document.getElementById('welcome-screen').style.display = 'block';
                    document.getElementById('order-content').style.display = 'none';
                    
                    // Remove selection highlights
                    document.querySelectorAll('#main-suite-grid .main-suite-btn').forEach(b => {
                        b.classList.remove('ring-4', 'ring-blue-300');
                    });
                }
            });

            // Back to suites button functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('#back-to-suites')) {
                    // Hide order content and show welcome screen
                    document.getElementById('order-content').style.display = 'none';
                    document.getElementById('welcome-screen').style.display = 'block';
                    
                    // Hide sidebar
                    document.getElementById('sidebar').classList.add('hidden');
                    document.getElementById('sidebar').classList.remove('lg:block');
                    document.getElementById('main-content').classList.add('ml-0');
                                document.getElementById('main-content').classList.remove('lg:ml-72');
                    
                    // Remove selection highlights
                    document.querySelectorAll('#main-suite-grid .main-suite-btn').forEach(b => {
                        b.classList.remove('ring-4', 'ring-blue-300');
                    });
                    document.querySelectorAll('#sidebar .clientLists').forEach(b => {
                        b.classList.remove('ring-4', 'ring-blue-300');
                    });
                }
            });

            // Suite search functionality
            document.getElementById('suite-search').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const suiteButtons = document.querySelectorAll('#suites-container .clientLists');
                
                suiteButtons.forEach(button => {
                    const suiteText = button.textContent.toLowerCase();
                    if (suiteText.includes(searchTerm)) {
                        button.style.display = 'flex';
                    } else {
                        button.style.display = 'none';
                    }
                });
            });

            // Update choice counters
            function updateChoiceCounters() {
                document.querySelectorAll('[data-group]').forEach(group => {
                    updateChoiceCounter(group);
                });
            }

            // Check if order already exists for this bed (Reception - with date)
            function checkExistingOrder(bedId, orderDate) {
                // Use provided date or fall back to selectedOrderDate
                const dateToCheck = orderDate || selectedOrderDate;
                
                fetch('<?php echo base_url('Orderportal/Order/checkExistingOrder'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'bed_id=' + encodeURIComponent(bedId) + '&order_date=' + encodeURIComponent(dateToCheck)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.has_existing_order) {
                        // Show existing order warning (only the header one)
                        const orderStatusInfo = document.getElementById('order-status-info');
                        if (orderStatusInfo) {
                            orderStatusInfo.style.display = 'flex';
                            orderStatusInfo.querySelector('.order-count').textContent = data.order_count;
                        }
                    } else {
                        // Hide existing order warning
                        const orderStatusInfo = document.getElementById('order-status-info');
                        if (orderStatusInfo) {
                            orderStatusInfo.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking existing order:', error);
                });
            }

            // Check update permissions
            function checkUpdatePermissions(bedId) {
                fetch('<?php echo base_url('Orderportal/Order/checkUpdatePermission'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'bed_id=' + encodeURIComponent(bedId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (!data.can_update) {
                            // Show restriction message
                            showUpdateRestriction(data.message, data.reason);
                            // Disable form inputs
                            disableOrderForm();
                        } else {
                            // Hide restriction message and enable form
                            hideUpdateRestriction();
                            enableOrderForm();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking update permissions:', error);
                });
            }

            // Show update restriction message
            function showUpdateRestriction(message, reason) {
                let restrictionDiv = document.getElementById('update-restriction');
                if (!restrictionDiv) {
                    restrictionDiv = document.createElement('div');
                    restrictionDiv.id = 'update-restriction';
                    restrictionDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg';
                    
                    const contentArea = document.getElementById('content-area');
                    contentArea.insertBefore(restrictionDiv, contentArea.firstChild);
                }
                
                let iconClass = 'fas fa-lock';
                let colorClass = 'text-red-600';
                
                if (reason === 'nurse_sent') {
                    iconClass = 'fas fa-paper-plane';
                } else if (reason === 'date_passed') {
                    iconClass = 'fas fa-calendar-times';
                }
                
                restrictionDiv.innerHTML = `
                    <div class="flex items-center">
                        <i class="${iconClass} ${colorClass} mr-3"></i>
                        <div>
                            <h3 class="text-red-800 font-semibold">Update Restricted</h3>
                            <p class="text-red-700 text-sm mt-1">${message}</p>
                        </div>
                    </div>
                `;
                restrictionDiv.style.display = 'block';
            }

            // Hide update restriction message
            function hideUpdateRestriction() {
                const restrictionDiv = document.getElementById('update-restriction');
                if (restrictionDiv) {
                    restrictionDiv.style.display = 'none';
                }
            }

            // Disable order form
            function disableOrderForm() {
                const form = document.getElementById('placeOrder');
                const inputs = form.querySelectorAll('input, textarea, button[type="submit"]');
                inputs.forEach(input => {
                    input.disabled = true;
                    if (input.type !== 'submit') {
                        input.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
            }

            // Enable order form
            function enableOrderForm() {
                const form = document.getElementById('placeOrder');
                const inputs = form.querySelectorAll('input, textarea, button[type="submit"]');
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            }
            
            // Reset order form when switching between suites
            function resetOrderForm() {
                // Clear all form inputs
                const form = document.getElementById('placeOrder');
                if (form) {
                    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
                    const radios = form.querySelectorAll('input[type="radio"]');
                    const textareas = form.querySelectorAll('textarea');
                    
                    checkboxes.forEach(cb => cb.checked = false);
                    radios.forEach(radio => radio.checked = false);
                    textareas.forEach(textarea => textarea.value = '');
                    
                    // Reset calories display
                    document.getElementById('suite-calories').textContent = '0 Kcal';
                    
                    // Update choice counters
                    updateChoiceCounters();
                    
                    // Hide any existing warnings or messages
                    const warnings = document.querySelectorAll('#existing-order-warning, #update-restriction');
                    warnings.forEach(warning => {
                        if (warning) warning.style.display = 'none';
                    });
                }
            }

            // FAILSAFE: Update override field value every second
            // This ensures the field is always up-to-date regardless of when form is submitted
            setInterval(function() {
                const nurseOverrideField = document.getElementById('nurse-override-field');
                if (nurseOverrideField) {
                    const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                    nurseOverrideField.value = nurseOverrideActive ? '1' : '0';
                }
            }, 1000);

            // Handle form submission
            document.getElementById('placeOrder').addEventListener('submit', function(e) {
                const selectedBed = document.getElementById('selected-bed').value;
                
                if (!selectedBed || selectedBed === '') {
                    e.preventDefault();
                    alert('Please select a suite first before placing an order.');
                    return false;
                }
                
                // NEW: Set navigation flag so date persists when coming back
                sessionStorage.setItem('receptionNavigating', 'true');
                
                // NEW: Set order date field value from selectedOrderDate
                const orderDateField = document.getElementById('order-date-field');
                if (orderDateField) {
                    orderDateField.value = selectedOrderDate;
                }
                
                // Set override field value from sessionStorage
                const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                const nurseOverrideField = document.getElementById('nurse-override-field');
                
                if (nurseOverrideField) {
                    nurseOverrideField.value = nurseOverrideActive ? '1' : '0';
                }
                
                // Clear any existing success data to prevent cross-contamination
                sessionStorage.removeItem('orderSuccess');
                
                // Show loading state
                const submitButton = e.target.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Placing Order...';
                }
            });

            // Clear any stale sessionStorage data on page load
            window.addEventListener('load', function() {
                sessionStorage.removeItem('orderSuccess');
            });

            // Show order success screen
            function showOrderSuccess(data) {
                document.getElementById('success-suite-name').textContent = data.suiteName;
                document.getElementById('success-order-date').textContent = data.orderDate;
                document.getElementById('success-item-count').textContent = data.itemCount;
                document.getElementById('success-calories').textContent = data.calories;
                document.getElementById('order-success-screen').style.display = 'flex';
            }

            // Success screen removed - using server-side flash messages instead

            // Prevent form submission when clicking on suite info
            document.addEventListener('click', function(e) {
                if (e.target.closest('.clientLists') && !e.target.closest('form')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });


            // Close modal when clicking outside
            document.getElementById('description-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDescriptionModal();
                }
            });

            // Toggle sidebar on mobile
            document.getElementById('toggle-sidebar').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                // Toggle sidebar visibility
                sidebar.classList.toggle('hidden');
                overlay.classList.toggle('hidden');
            });

            // Close sidebar when clicking overlay
            document.getElementById('sidebar-overlay').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            });

            // Close sidebar when clicking close button
            document.getElementById('close-sidebar').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            });

            

            // Send order button animation - orders now go directly to chef
            document.getElementsByClassName('save-order')[0].addEventListener('click', function(e) {
                // Check cutoff time (10:30 AM) - ONLY for reception (role 6) and patient (role 4) users
                // Nurses (role 3) can place orders at any time
                const userRole = <?php echo $this->ion_auth->get_users_groups()->row()->id; ?>;
                
                // Check if override is active
                const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                
                // Check cutoff time for reception/patient users (unless override is active)
                if ((userRole == 6 || userRole == 4) && !nurseOverrideActive) { // Reception or Patient (no override)
                    // Use Australia timezone for cutoff check
                    const now = new Date();
                    const australiaTime = new Date(now.toLocaleString("en-US", {timeZone: "Australia/Sydney"}));
                    const currentHour = australiaTime.getHours();
                    const currentMinute = australiaTime.getMinutes();
                    const currentTime = currentHour * 60 + currentMinute; // Convert to minutes
                    const cutoffTime = 10 * 60 + 30; // 10:30 AM in minutes
                    
                    // Only block if it's past 10:30 AM Australia time
                    if (currentTime >= cutoffTime) {
                        e.preventDefault();
                        alert('⏰ Order cutoff time has passed!\n\nOrders for tomorrow must be placed before 10:30 AM Australia time.\n\nPlease use "Override" button to place orders after cutoff.');
                        return false;
                    }
                }
                // Nurses (role 3) bypass cutoff time check completely
                // Also bypass if override is active
                
                document.getElementById('loader').classList.remove('hidden');
                document.getElementById('button-type').value = 'sendorder'; // Auto-send to chef
                this.innerHTML = '<i class="fa-solid fa-check mr-2"></i><span>Sent to Chef!</span>';
                this.classList.remove('bg-primary-600');
                this.classList.add('bg-success');
                setTimeout(() => {
                    this.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i><span>Send Order</span>';
                    this.classList.remove('bg-success');
                    this.classList.add('bg-primary-600');
                }, 2000);
            });

            // Send order button , needed in nurse portal
            // document.getElementById('send-order-button').addEventListener('click', function() {
            //     document.getElementById('button-type').value = 'send';
            //     const unoccupiedOrderedSuites = [];
            //     document.querySelectorAll('#sidebar .clientLists[data-occupied="true"]').forEach(btn => {
            //         if (btn.getAttribute('data-ordered') === 'false') {
            //             const suiteNo = btn.querySelector('span:not(.text-white)').textContent;
            //             unoccupiedOrderedSuites.push(suiteNo);
            //         }
            //     });

            //     if (unoccupiedOrderedSuites.length > 0) {
            //         const suiteList = unoccupiedOrderedSuites.join(', ');
            //         document.getElementById('warning-message').textContent = `The following occupied suites have no orders selected: ${suiteList}. Please place orders before sending.`;
            //         document.getElementById('warning-modal').classList.remove('hidden');
            //         setTimeout(() => {
            //             document.getElementById('warning-modal-content').classList.add('scale-100', 'opacity-100');
            //         }, 10);
            //         return;
            //     }

            //     document.getElementById('placeOrder').submit();
            // });

            // Render meal sections dynamically - NOW WITH DYNAMIC MENU LOADING
            function renderMealSections(bedId, orderDate) {
                // Use provided date or fall back to selectedOrderDate
                const dateToUse = orderDate || selectedOrderDate;
                
                // NEW: Fetch menu data for the selected date from backend
                fetchMenuDataForDate(bedId, dateToUse);
            }
            
            // NEW: Fetch menu data for a specific date (Reception)
            function fetchMenuDataForDate(bedId, orderDate) {
                
                // Show loading indicator
                const mealSections = document.getElementById('meal-sections');
                mealSections.innerHTML = '<div class="flex justify-center items-center py-12"><i class="fas fa-spinner fa-spin text-4xl text-blue-600 mr-4"></i><span class="text-lg text-gray-600">Loading menu for selected date...</span></div>';
                
                fetch('<?php echo base_url('Orderportal/Home/getMenuDataForDate'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'bed_id=' + encodeURIComponent(bedId) + '&order_date=' + encodeURIComponent(orderDate)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {            
                        // Render using the data from backend
                        renderMealSectionsWithData(bedId, data);
                    } else {
                        mealSections.innerHTML = '<div class="p-6 text-center text-red-500"><i class="fas fa-exclamation-triangle mr-2"></i>' + (data.message || 'Failed to load menu') + '</div>';
                    }
                })
                .catch(error => {
                    mealSections.innerHTML = '<div class="p-6 text-center text-red-500"><i class="fas fa-exclamation-triangle mr-2"></i>Error loading menu</div>';
                });
            }
            
            // NEW: Render meal sections with fetched data (Reception)
            function renderMealSectionsWithData(bedId, menuData) {
                const mealSections = document.getElementById('meal-sections');
                mealSections.innerHTML = '';
                document.getElementById('notes-textarea').value = menuData.orderComment || '';
                
                // Set Room Service checkbox based on backend data
                const roomServiceCheckbox = document.getElementById('room-service-checkbox');
                if (roomServiceCheckbox && menuData.roomServiceEnabled !== undefined) {
                    roomServiceCheckbox.checked = menuData.roomServiceEnabled;
                }
                
                const bed = bedLists.find(b => b.id == bedId);
                const dietaryRestrictions = bed && bed.dietary_restrictions ? bed.dietary_restrictions.split(',') : [];

                // Use data from backend
                const categoryList = menuData.categories || [];
                const menuList = menuData.menus || [];
                const savedWithoutOptions = menuData.savedMenuWithoutOptions || {};
                const savedWithOptions = menuData.savedMenuWithOptions || {};
                const patientOrders = menuData.patientOrderData || {};
                const hasMenu = menuData.hasPublishedMenu || false;
                

                // Show menu status info if no published menu
                const menuStatusInfo = document.getElementById('menu-status-info');
                if (!hasMenu) {
                    menuStatusInfo.style.display = 'block';
                    mealSections.innerHTML = '<div class="p-6 text-center text-gray-500">No published menu available for selected date</div>';
                    return;
                } else {
                    menuStatusInfo.style.display = 'none';
                }

                // FIXED: Use data from menuData parameter, not global variables
                if (!categoryList || categoryList.length === 0) {
                    mealSections.innerHTML = '<div class="p-6 text-center text-gray-500">No categories available</div>';
                    return;
                }

                if (!menuList || menuList.length === 0) {
                    mealSections.innerHTML = '<div class="p-6 text-center text-gray-500">No menu items available</div>';
                    return;
                }

                categoryList.forEach(category => {
                    
                    // First check if there are saved menus for this category
                    let categoryMenus = menuList.filter(m => 
                        m.category_ids && m.category_ids.includes(category.id) && 
                        ((savedWithoutOptions[category.id] || []).includes(m.menu_id) || 
                         (savedWithOptions[category.id]?.[m.menu_id] || []).length > 0)
                    );
                    
                    
                    // If no saved menus and we have a published menu, show all available menus for this category
                    if (categoryMenus.length === 0 && hasMenu) {
                        categoryMenus = menuList.filter(m => m.category_ids && m.category_ids.includes(category.id));
                    }
                    
                    if (categoryMenus.length === 0) {
                        return;
                    }

                    const section = document.createElement('div');
                    section.id = `category-${category.id}-section`;
                    section.className = 'mb-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden';

                    const categoryIcon = {
                        'Breakfast': 'fa-mug-hot',
                        'Morning Tea': 'fa-mug-hot',
                        'Lunch': 'fa-utensils',
                        'Afternoon Tea': 'fa-cookie',
                        'Dinner': 'fa-plate-wheat'
                    }[category.name] || 'fa-utensils';

                    section.innerHTML = `
                        <div class="flex items-center justify-between px-6 py-4 bg-blue-50 border-b border-blue-100">
                            <div class="flex items-center">
                                <i class="fa-solid ${categoryIcon} text-lg text-blue-600 mr-3"></i>
                                <h2 class="text-lg font-semibold text-gray-800">${htmlspecialchars(category.name)} ${category.time ? htmlspecialchars(category.time) : ''}</h2>
                            </div>
                            <div class="flex items-center pr-4 sm:pr-6" style="display: none;">
                                <span class="text-sm text-blue-600 font-medium">Total Calories: <span class="category-calories">0 Kcal</span></span>
                            </div>
                        </div>
                        <div class="p-6">
                            ${categoryMenus.map(menu => {
                                const isGlutenFree = dietaryRestrictions.includes('Gluten Free');
                                const containsGluten = menu.contains_gluten == '1';
                                const disabled = isGlutenFree && containsGluten ? 'disabled' : '';
                                const disabledClass = isGlutenFree && containsGluten ? 'opacity-50 cursor-not-allowed' : '';
                                const menuIcon = {
                                    'Toast': 'fa-bread-slice',
                                    'Condiments': 'fa-jar',
                                    'Beverages': 'fa-mug-saucer',
                                    'Cereal': 'fa-bowl-food'
                                }[menu.menu_name] || 'fa-utensils';

                                if (menu.menu_options && menu.menu_options.length > 0 && savedWithOptions[category.id]?.[menu.menu_id]) {
                                    const menuPlannerOptions = savedWithOptions[category.id][menu.menu_id] || [];
                                    
                                    // Calculate allergy filtering for warning display
                                    const bed = bedLists.find(b => b.id == bedId);
                                    const allOptionsInPlan = menu.menu_options.filter(opt => menuPlannerOptions.includes(String(opt.option_id)));
                                    let safeOptionsCount = allOptionsInPlan.length;
                                    let allergyWarning = '';
                                    
                                    if (bed && bed.patient_allergies && bed.patient_allergies !== 'null' && bed.patient_allergies !== '[]') {
                                        try {
                                            const patientAllergies = JSON.parse(bed.patient_allergies);
                                            if (patientAllergies && patientAllergies.length > 0) {
                                                safeOptionsCount = allOptionsInPlan.filter(option => {
                                                    const itemAllergens = option.allergenValues ? JSON.parse(option.allergenValues) : [];
                                                    if (!itemAllergens || itemAllergens.length === 0) return true;
                                                    const hasConflict = patientAllergies.some(pa => itemAllergens.some(ia => String(pa) === String(ia)));
                                                    return !hasConflict;
                                                }).length;
                                                
                                                const hiddenCount = allOptionsInPlan.length - safeOptionsCount;
                                                if (hiddenCount > 0) {
                                                    allergyWarning = `
                                                        <div class="mb-3 p-3 bg-amber-50 border-l-4 border-amber-400 rounded flex items-start">
                                                            <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 mr-2"></i>
                                                            <div class="text-sm text-amber-800">
                                                                <strong>Allergy Alert:</strong> ${hiddenCount} item${hiddenCount > 1 ? 's' : ''} hidden due to patient allergies
                                                            </div>
                                                        </div>
                                                    `;
                                                }
                                            }
                                        } catch (e) {
                                            console.error('Allergy warning calculation error:', e);
                                        }
                                    }
                                    
                                    return `
                                        <div class="mb-6">
                                            <h3 class="text-base font-semibold text-gray-800 flex items-center mb-4">
                                                ${htmlspecialchars(menu.menu_name)}
                                                <span class="ml-2 text-sm font-normal text-gray-500" id="count-${category.id}-${menu.menu_id}">
                                                    (Choose up to ${menu.inputType === 'radio' ? 1 : menu.max_selections || 2} - Selected: 0)
                                                </span>
                                            </h3>
                                            ${allergyWarning}
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 menu-options-grid" data-group="${category.id}_${menu.menu_id}" data-max="${menu.inputType === 'radio' ? 1 : 2}">
                                                ${menu.menu_options
                                                    .filter(option => menuPlannerOptions.includes(String(option.option_id)))
                                                    .filter(option => {
                                                        const bed = bedLists.find(b => b.id == bedId);
                                                        if (!bed) return true;
                                                        
                                                        // CUISINE FILTERING: Show items that match patient dietary preferences
                                                        let matchesCuisine = true;
                                                        if (bed.patient_dietary_preferences && bed.patient_dietary_preferences !== 'null' && bed.patient_dietary_preferences !== '[]' && bed.patient_dietary_preferences !== null) {
                                                            try {
                                                                const patientCuisinesParsed = JSON.parse(bed.patient_dietary_preferences);
                                                                // Ensure patientCuisines is an array
                                                                const patientCuisines = Array.isArray(patientCuisinesParsed) ? patientCuisinesParsed : [];
                                                                if (patientCuisines && patientCuisines.length > 0) {
                                                                    // Parse item cuisines - handle both string JSON and array formats
                                                                    let itemCuisinesParsed = [];
                                                                    if (option.cuisineValues) {
                                                                        if (typeof option.cuisineValues === 'string') {
                                                                            try {
                                                                                itemCuisinesParsed = JSON.parse(option.cuisineValues);
                                                                            } catch (e) {
                                                                                itemCuisinesParsed = [];
                                                                            }
                                                                        } else {
                                                                            itemCuisinesParsed = option.cuisineValues;
                                                                        }
                                                                    }
                                                                    // Ensure itemCuisines is an array
                                                                    const itemCuisines = Array.isArray(itemCuisinesParsed) ? itemCuisinesParsed : [];
                                                                    // CUISINE FILTERING LOGIC (MULTI-SELECT SUPPORTED):
                                                                    // - If patient has dietary preferences, show ONLY items that match those preferences
                                                                    // - Items with NO cuisines assigned are HIDDEN when patient has preferences (strict filtering)
                                                                    // - Items with cuisines are shown only if at least ONE patient cuisine matches at least ONE item cuisine
                                                                    if (itemCuisines && itemCuisines.length > 0) {
                                                                        // MULTI-SELECT MATCHING: Check if ANY patient cuisine matches ANY item cuisine
                                                                        matchesCuisine = patientCuisines.some(patientCuisineId => 
                                                                            itemCuisines.some(itemCuisineId => 
                                                                                String(patientCuisineId) === String(itemCuisineId)
                                                                            )
                                                                        );
                                                                    } else {
                                                                        // Item has NO cuisines assigned - HIDE it when patient has preferences (strict filtering)
                                                                        // This ensures patients with specific dietary needs (e.g., Vegan) only see items explicitly tagged
                                                                        matchesCuisine = false;
                                                                    }
                                                                }
                                                            } catch (e) {
                                                                console.error('Cuisine filtering error:', e, 'bed.patient_dietary_preferences:', bed.patient_dietary_preferences, 'option:', option);
                                                                matchesCuisine = false; // On error, hide item to be safe
                                                            }
                                                        }
                                                        
                                                        // ALLERGEN FILTERING: Hide items that conflict with patient allergies
                                                        let matchesAllergen = true;
                                                        if (bed.patient_allergies && bed.patient_allergies !== 'null' && bed.patient_allergies !== '[]') {
                                                            try {
                                                                const patientAllergies = JSON.parse(bed.patient_allergies);
                                                                if (patientAllergies && patientAllergies.length > 0) {
                                                                    const itemAllergens = option.allergenValues ? JSON.parse(option.allergenValues) : [];
                                                                    if (itemAllergens && itemAllergens.length > 0) {
                                                                        // Check for conflict: does item contain something patient is allergic to?
                                                                        const hasConflict = patientAllergies.some(patientAllergyId => 
                                                                            itemAllergens.some(itemAllergenId => 
                                                                                String(patientAllergyId) === String(itemAllergenId)
                                                                            )
                                                                        );
                                                                        matchesAllergen = !hasConflict; // Show only if NO conflict
                                                                    }
                                                                }
                                                            } catch (e) {
                                                                console.error('Allergy filtering error:', e, option);
                                                                matchesAllergen = true; // On error, show item (fail-safe)
                                                            }
                                                        }
                                                        
                                                        // Show item only if it matches cuisine preferences AND doesn't conflict with allergens
                                                        return matchesCuisine && matchesAllergen;
                                                    })
                                                    .map(option => {
                                                        const optionId = String(option.option_id);
                                                        const menuOptionCalorie = String(option.menu_option_calorie);
                                                        const inputName = menu.inputType === 'radio' ? `${category.id}_${menu.menu_id}` : `${category.id}_${menu.menu_id}[]`;
                                                        const selectedForMenu = patientOrders[`${bedId}_${category.id}_${menu.menu_id}`] || [];
                                                        
                                                        // Convert all selected IDs to strings for type-safe comparison
                                                        const selectedIds = selectedForMenu.map(id => String(id));
                                                        const isChecked = selectedIds.includes(optionId) ? 'checked' : '';
                                                        return `
                                                            <div class="relative">
                                                                <input type="${menu.inputType}" 
                                                                       id="option_${bedId}_${category.id}_${menu.menu_id}_${optionId}" 
                                                                       name="${inputName}" 
                                                                       data-calorie="${menuOptionCalorie}"
                                                                       value="${optionId}" 
                                                                       class="peer absolute inset-0 opacity-0 menu-option-checkbox" 
                                                                       ${isChecked} ${disabled} 
                                                                       aria-label="${htmlspecialchars(option.menu_option_name)}">
                                                                <div class="p-2 border border-gray-200 rounded-lg hover:border-blue-300 ${isChecked ? 'bg-blue-100 border-blue-500' : ''} transition-all cursor-pointer ${disabledClass}">
                                                                    <div class="flex items-center justify-between">
                                                                        <div class="flex items-center space-x-1.5">
                                                                            <div class="relative flex-shrink-0">
                                                                                <div class="h-4 w-4 border-2 border-gray-300 rounded ${isChecked ? 'bg-blue-500 border-blue-500' : ''} transition-colors"></div>
                                                                                ${isChecked ? '<i class="fa-solid fa-check text-white text-xs absolute top-0.5 left-0.5"></i>' : ''}
                                                                            </div>
                                                            <span class="text-sm font-medium text-gray-800">${htmlspecialchars(option.menu_option_name)}</span>
                                                            ${option.menu_option_description && option.menu_option_description.trim() !== '' ? `
                                                                <button type="button" 
                                                                        class="ml-2 text-gray-400 hover:text-blue-600 transition-colors info-icon-btn relative z-10 p-2 rounded-full hover:bg-gray-100"
                                                                        data-description="${htmlspecialchars(option.menu_option_description)}"
                                                                        title="${htmlspecialchars(option.menu_option_description)}"
                                                                        onclick="event.stopPropagation(); window.showMenuDescriptionModal(this.getAttribute('data-description')); return false;">
                                                                    <i class="fas fa-info-circle text-lg"></i>
                                                                </button>
                                                            ` : ''}
                                                            <button type="button" 
                                                                    class="ml-2 text-gray-400 hover:text-orange-600 transition-colors comment-btn p-2 rounded-full hover:bg-gray-100"
                                                                    data-bed-id="${bedId}"
                                                                    data-suite-no="${bed ? bed.bed_no || bedId : bedId}"
                                                                    data-menu-id="${menu.menu_id}"
                                                                    data-option-id="${optionId}"
                                                                    data-menu-name="${htmlspecialchars(menu.menu_name)}"
                                                                    data-option-name="${htmlspecialchars(option.menu_option_name)}"
                                                                    title="Add comment for this item"
                                                                    style="z-index: 20; position: relative; pointer-events: auto; display: none;"
                                                                    onclick="handleCommentButtonClick(event, this);">
                                                                <i class="fas fa-comment text-lg" style="pointer-events: none;"></i>
                                                            </button>
                                                        </div>
                                                        <span class="text-xs text-gray-500" style="display: none;">${menuOptionCalorie > 0 ? menuOptionCalorie + ' Kcal' : ''}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                                    }).join('')}
                                            </div>
                                        </div>
                                    `;
                                } else if ((savedWithoutOptions[category.id] || []).includes(menu.menu_id)) {
                                    const isChecked = patientOrders[`${bedId}_${category.id}_${menu.menu_id}`] ? 'checked' : '';
                                    return `
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div class="relative">
                                                <input type="${menu.inputType}" 
                                                       id="menu_${bedId}_${category.id}_${menu.menu_id}" 
                                                       name="${category.id}_${menu.menu_id}" 
                                                       value="${menu.menu_id}" 
                                                       class="peer absolute h-5 w-5 opacity-0 cursor-pointer" 
                                                       ${isChecked} ${disabled} 
                                                       aria-label="${htmlspecialchars(menu.menu_name)}">
                                                <div class="h-5 w-5 border-2 border-gray-300 rounded peer-checked:bg-blue-500 peer-checked:border-blue-500 transition-colors ${disabledClass}"></div>
                                                <i class="fa-solid fa-check text-white text-xs absolute top-1 left-1 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                            </div>
                                            <label for="menu_${bedId}_${category.id}_${menu.menu_id}" class="cursor-pointer ${disabledClass}">
                                                ${htmlspecialchars(menu.menu_name)}
                                            </label>
                                            ${disabled ? `<span class="ml-2 text-sm text-danger">Contains gluten</span>` : ''}
                                            ${menu.description ? `
                                                <a class="view-more ml-2 cursor-pointer" 
                                                   data-menuname="${htmlspecialchars(menu.menu_name)}"
                                                   data-cuisine_type="${htmlspecialchars(menu.cuisine_type || '')}"
                                                   data-menu_type="${htmlspecialchars(menu.menu_type || '')}"
                                                   data-description="${htmlspecialchars(menu.description)}">
                                                   <i class="fa-solid fa-circle-info text-gray-400 cursor-help" title="View details"></i>
                                                </a>
                                            ` : ''}
                                        </div>
                                    `;
                                }
                                return '';
                            }).join('')}
                        </div>
                    `;
                    mealSections.appendChild(section);
                });

                // All sections are always expanded - no collapse/expand functionality needed
                
                // Update calories immediately after rendering
                updateCategoryCalories();
                
                // Setup choice counters after rendering
                setTimeout(() => {
                    setupChoiceCounters();
                    // Also update all counters to ensure they show correct initial values
                    updateChoiceCounters();
                }, 100);

                // Add event listeners for view-more links
                document.querySelectorAll('.view-more').forEach(link => {
                    link.addEventListener('click', function() {
                        const modal = document.getElementById('description-modal');
                        const modalContent = document.getElementById('description-modal-content');
                        
                        document.getElementById('menuNameModal').textContent = this.getAttribute('data-menuname');
                        document.getElementById('cuisineType').textContent = this.getAttribute('data-cuisine_type') ? `Cuisine: ${this.getAttribute('data-cuisine_type')}` : '';
                        document.getElementById('menuType').textContent = this.getAttribute('data-menu_type') ? `Type: ${this.getAttribute('data-menu_type')}` : '';
                        document.getElementById('modalDescription').textContent = this.getAttribute('data-description');
                        
                        if (modal && modalContent) {
                            // Remove initial classes first
                            modalContent.classList.remove('scale-95', 'opacity-0');
                            modal.classList.remove('hidden');
                            
                            setTimeout(() => {
                                modalContent.classList.add('scale-100', 'opacity-100');
                            }, 10);
                        }
                    });
                });

                // Toggle section visibility
                document.addEventListener('click', function(e) {
                    if (e.target.closest('#meal-sections button[aria-label*="Toggle"]')) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const button = e.target.closest('button');
                        const section = button.closest('div[id$="-section"]');
                        const content = section.querySelector('div.p-6');
                        const icon = button.querySelector('i');
                        
                        if (content.style.display === 'none' || content.classList.contains('hidden')) {
                            content.style.display = 'block';
                            content.classList.remove('hidden');
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        } else {
                            content.style.display = 'none';
                            content.classList.add('hidden');
                            icon.classList.remove('fa-chevron-down');
                            icon.classList.add('fa-chevron-up');
                        }
                    }
                });

                // Update selection counts
                function updateSelectionCounts() {
                    document.querySelectorAll('[data-group]').forEach(group => {
                        const groupId = group.dataset.group;
                        const checkedInputs = group.querySelectorAll('input:checked');
                        const countSpan = document.querySelector(`#count-${groupId.replace('_', '-')} .selected-count`);
                        if (countSpan) {
                            countSpan.textContent = checkedInputs.length;
                        }
                    });
                }

                // Setup menu option event listeners with proper delegation
                function setupMenuEventListeners() {
                    // Use event delegation on the meal-sections container
                    const mealSections = document.getElementById('meal-sections');
                    if (mealSections) {
                        // Remove any existing listeners to prevent duplicates
                        mealSections.removeEventListener('change', handleMenuOptionChange);
                        mealSections.addEventListener('change', handleMenuOptionChange);
                        
                        // Add click listener for card clicks only (info icons now have inline onclick)
                        mealSections.removeEventListener('click', handleCardClicks);
                        mealSections.addEventListener('click', handleCardClicks);
                        
                        // Add hover listeners for info icons
                        mealSections.removeEventListener('mouseover', handleInfoIconHover);
                        mealSections.addEventListener('mouseover', handleInfoIconHover);
                    }
                }
                
                // Handle card clicks for menu selection (excluding info icons)
                function handleCardClicks(e) {
                    // Skip if it's an info icon or its children
                    if (e.target.closest('.info-icon-btn')) {
                        return;
                    }
                    
                    // Handle card clicks for menu selection
                    const cardDiv = e.target.closest('.p-2.border.border-gray-200.rounded-lg');
                    if (cardDiv) {
                        const container = cardDiv.closest('.relative');
                        if (container) {
                            const input = container.querySelector('.menu-option-checkbox');
                            if (input && !input.disabled) {
                                // Toggle the checkbox
                                input.checked = !input.checked;
                                // Trigger change event
                                input.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        }
                    }
                }
                
                // Handle info icon hover to show tooltip
                function handleInfoIconHover(e) {
                    const infoBtn = e.target.closest('.info-icon-btn');
                    if (infoBtn) {
                        const description = infoBtn.getAttribute('data-description');
                        if (description) {
                            // Update title for native tooltip
                            infoBtn.title = description;
                        }
                    }
                }
                
                // Show menu description modal - make it global
                window.showMenuDescriptionModal = function(description) {
                    const modal = document.getElementById('description-modal');
                    const content = document.getElementById('modalDescription');
                    const modalContent = document.getElementById('description-modal-content');
                    
                    if (content) {
                        content.textContent = description;
                    }
                    
                    if (modal && modalContent) {
                        // Remove initial classes first
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modal.classList.remove('hidden');
                        
                        // Then add visible classes with animation
                        setTimeout(() => {
                            modalContent.classList.add('scale-100', 'opacity-100');
                        }, 10);
                    }
                }
                
                function handleMenuOptionChange(e) {
                    // Don't handle if it's an info icon click
                    if (e.target.closest('.info-icon-btn')) {
                        return;
                    }
                    
                    const input = e.target;
                    if (!input.classList.contains('menu-option-checkbox')) return;
                    
                    // Handle checkbox limits BEFORE visual updates
                    if (input.type === 'checkbox') {
                        const group = input.closest('[data-group]');
                        if (group) {
                            const max = parseInt(group.dataset.max) || Infinity;
                            const checkedInputs = group.querySelectorAll('input[type="checkbox"]:checked');
                            if (checkedInputs.length > max && input.checked) {
                                input.checked = false;
                                showSelectionLimitModal(`You can select up to ${max} options in this group.`);
                                return;
                            }
                        }
                    }
                    
                    // Handle radio button groups
                    if (input.type === 'radio' && input.checked) {
                        const groupName = input.name;
                        document.querySelectorAll(`input[name="${groupName}"]`).forEach(radio => {
                            if (radio !== input) {
                                radio.checked = false;
                                updateVisualState(radio, false);
                            }
                        });
                    }
                    
                    // Update visual state for current input
                    updateVisualState(input, input.checked);
                    
                    // Update counters and calories
                    updateChoiceCounters();
                    updateSuiteCalories(currentBedId);
                    updateCategoryCalories();
                    updateSuiteStatus();
                }
                
                function updateVisualState(input, isChecked) {
                    const container = input.closest('.relative');
                    if (!container) return;
                    
                    const card = container.querySelector('.p-2'); // Fixed: Changed from p-3 to p-2
                    const visualCheckbox = container.querySelector('.h-4.w-4');
                    let checkIcon = container.querySelector('.fa-check');
                    
                    if (isChecked) {
                        if (card) {
                            card.classList.add('bg-blue-100', 'border-blue-500');
                            card.classList.remove('border-gray-200');
                        }
                        if (visualCheckbox) {
                            visualCheckbox.classList.add('bg-blue-500', 'border-blue-500');
                            visualCheckbox.classList.remove('border-gray-300');
                        }
                        if (!checkIcon && visualCheckbox) {
                            checkIcon = document.createElement('i');
                            checkIcon.className = 'fa-solid fa-check text-white text-xs absolute top-0.5 left-0.5';
                            visualCheckbox.parentElement.appendChild(checkIcon);
                        }
                        if (checkIcon) {
                            checkIcon.style.display = 'block';
                        }
                    } else {
                        if (card) {
                            card.classList.remove('bg-blue-100', 'border-blue-500');
                            card.classList.add('border-gray-200');
                        }
                        if (visualCheckbox) {
                            visualCheckbox.classList.remove('bg-blue-500', 'border-blue-500');
                            visualCheckbox.classList.add('border-gray-300');
                        }
                        if (checkIcon) {
                            checkIcon.style.display = 'none';
                        }
                    }
                }
                
                function updateSuiteStatus() {
                    const suiteButton = document.querySelector(`#sidebar .clientLists[data-bed-id="${currentBedId}"]`);
                    if (!suiteButton) return;
                    
                    const hasOrder = document.querySelectorAll('#meal-sections input:checked').length > 0 || notesTextarea.value.trim().length > 0;
                    const isOccupied = suiteButton.dataset.occupied === "true";
                    
                    suiteButton.dataset.ordered = hasOrder ? "true" : "false";
                    const statusIcon = suiteButton.querySelector('span span');
                    const statusI = statusIcon ? statusIcon.querySelector('i') : null;
                    
                    if (statusIcon && statusI) {
                        // Remove all existing classes
                        statusIcon.classList.remove('bg-blue-500', 'bg-green-500', 'bg-gray-400');
                        statusI.classList.remove('fa-utensils', 'fa-user', 'fa-bed');
                        
                        // Apply new classes based on status
                        if (hasOrder) {
                            statusIcon.classList.add('bg-blue-500');
                            statusI.classList.add('fa-utensils');
                            suiteButton.className = 'clientLists flex items-center justify-between w-full px-4 py-3 bg-blue-50 text-blue-800 border-blue-200 rounded-lg font-medium transition-all hover:bg-primary-100 border';
                        } else if (isOccupied) {
                            statusIcon.classList.add('bg-green-500');
                            statusI.classList.add('fa-user');
                            suiteButton.className = 'clientLists flex items-center justify-between w-full px-4 py-3 bg-green-50 text-green-800 border-green-200 rounded-lg font-medium transition-all hover:bg-primary-100 border';
                        } else {
                            statusIcon.classList.add('bg-gray-400');
                            statusI.classList.add('fa-bed');
                            suiteButton.className = 'clientLists flex items-center justify-between w-full px-4 py-3 bg-gray-50 text-gray-700 border-gray-200 rounded-lg font-medium transition-all hover:bg-primary-100 border';
                        }
                    }
                }
                
                // Function to show selection limit modal
                function showSelectionLimitModal(message) {
                    const warningModal = document.getElementById('warning-modal');
                    const warningMessage = document.getElementById('warning-message');
                    if (warningMessage) {
                        warningMessage.textContent = message;
                    }
                    if (warningModal) {
                        warningModal.classList.remove('hidden');
                        setTimeout(() => {
                            const modalContent = document.getElementById('warning-modal-content');
                            if (modalContent) {
                                modalContent.classList.add('scale-100', 'opacity-100');
                            }
                        }, 10);
                    }
                }
                
                // Initialize event listeners
                setupMenuEventListeners();

                // Hide success or error message after 5 seconds
                setTimeout(function() {
                    document.querySelectorAll('.successMessageSection').forEach(el => {
                        el.classList.add('hidden');
                    });
                }, 5000);
            }
          function updateSuiteCalories(bedId) {
              
                let totalCalories = 0;
                document.querySelectorAll(`#meal-sections .menu-option-checkbox`).forEach(input => {
                    if (input.checked && input.id.startsWith(`option_${bedId}_`)) {
                        const calorie = parseInt(input.getAttribute('data-calorie')) || 0;
                        totalCalories += calorie;
                    }
                });
                
                document.getElementById('suite-calories').textContent = totalCalories + ' Kcal';
            }

            function updateCategoryCalories() {
                // Update calories for each meal category
                document.querySelectorAll('.category-calories').forEach(calorieSpan => {
                    const categorySection = calorieSpan.closest('.bg-white.rounded-xl.shadow-sm.border');
                    if (categorySection) {
                        let categoryCalories = 0;
                        
                        // Calculate calories for this specific category
                        categorySection.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').forEach(input => {
                            const calories = parseInt(input.getAttribute('data-calorie')) || 0;
                            categoryCalories += calories;
                        });
                        
                        calorieSpan.textContent = `${categoryCalories} Kcal`;
                    }
                });
            }
            
            // Helper function for HTML escaping
            function htmlspecialchars(string) {
                if (typeof string !== 'string') return '';
                return string
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }
        });
        
     
  const hours = new Date().getHours();
  let greeting = "Hello";

  if (hours < 12) {
    greeting = "Good Morning";
  } else if (hours < 17) {
    greeting = "Good Afternoon";
  } else {
    greeting = "Good Evening";
  }

  document.getElementById("greeting").textContent = greeting;

  // Menu item description tooltip and modal functions
  let tooltip = null;

  function showTooltip(element, description) {
      
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

  function showMenuDescription(description) {
      
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
                  <button onclick="document.body.removeChild(this.closest('.modal'))" style="
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
      
      modal.className = 'modal';
      
      // Close on backdrop click
      modal.addEventListener('click', function(e) {
          if (e.target === modal) {
              document.body.removeChild(modal);
          }
      });
      
      document.body.appendChild(modal);
  }

        // Simple function to handle comment button click
        function handleCommentButtonClick(event, button) {
            
            // Stop event propagation
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            
            // Get data from button
            const bedId = button.getAttribute('data-bed-id');
            const suiteNo = button.getAttribute('data-suite-no');
            const menuId = button.getAttribute('data-menu-id');
            const optionId = button.getAttribute('data-option-id');
            const menuName = button.getAttribute('data-menu-name');
            const optionName = button.getAttribute('data-option-name');
            
            
            // Store current comment data
            currentCommentData = {
                bed_id: bedId,
                menu_id: menuId,
                option_id: optionId,
                menu_name: menuName,
                option_name: optionName
            };
            
            // Update modal info - use suite number
            document.getElementById('comment-suite-info').textContent = suiteNo || bedId;
            document.getElementById('comment-menu-info').textContent = menuName || 'Unknown Menu';
            document.getElementById('comment-item-info').textContent = optionName || 'Unknown Item';
            
            // Show modal
            const modal = document.getElementById('comment-modal');
            const modalContent = document.getElementById('comment-modal-content');
            
            if (modal && modalContent) {
                // Reset modal state first
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
                
                // Reset animation states
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
                
                // Trigger opening animation
                setTimeout(() => {
                    modal.classList.add('modal-opening');
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                }, 10);
                
                // Set up event listeners immediately after opening modal
                setupCommentModalEventListeners();
                
                // Load existing comment
                loadExistingComment();
                
            } else {
                alert('Comment modal not found. Please refresh the page.');
            }
            
            return false;
        }

        // Function to open comment modal - GLOBAL SCOPE
        function openMenuItemCommentModal(button) {
            
            const bedId = button.getAttribute('data-bed-id');
            const menuId = button.getAttribute('data-menu-id');
            const optionId = button.getAttribute('data-option-id');
            const menuName = button.getAttribute('data-menu-name');
            const optionName = button.getAttribute('data-option-name');
            
            if (!bedId || !menuId || !optionId) {
                return;
            }
            
            // Store current comment data
            currentCommentData = {
                bed_id: bedId,
                menu_id: menuId,
                option_id: optionId,
                menu_name: menuName,
                option_name: optionName
            };
            
            // Update modal info
            const suiteInfo = document.getElementById('comment-suite-info');
            const menuInfo = document.getElementById('comment-menu-info');
            const itemInfo = document.getElementById('comment-item-info');
            
            if (suiteInfo) suiteInfo.textContent = `Suite ${bedId}`;
            if (menuInfo) menuInfo.textContent = menuName || 'Unknown Menu';
            if (itemInfo) itemInfo.textContent = optionName || 'Unknown Item';
            
            // Load existing comment
            loadExistingComment();
            
            // Show modal
            const modal = document.getElementById('comment-modal');
            if (modal) {
                modal.classList.remove('hidden');
                
                // Force modal to be visible
                modal.style.display = 'flex';
            }
        }

        // Function to load existing comment - GLOBAL SCOPE
        function loadExistingComment() {
            fetch('<?php echo base_url("Orderportal/Order/getMenuItemComment"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(currentCommentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.comment) {
                    document.getElementById('comment-text').value = data.comment;
                } else {
                    document.getElementById('comment-text').value = '';
                }
            })
            .catch(error => {
                console.error('Error loading comment:', error);
                document.getElementById('comment-text').value = '';
            });
        }

        // Function to show success toast notification
        function showSuccessToast(message) {
            // Remove any existing toast
            const existingToast = document.querySelector('.success-toast');
            if (existingToast) {
                existingToast.remove();
            }
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'success-toast fixed bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300';
            toast.style.cssText = 'top: 90px; right: 20px; z-index: 10000;';
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <div class="font-bold text-lg">Success!</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                </div>
            `;
            
            // Add to page
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.transform = 'translateX(full)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // Function to show error toast notification
        function showErrorToast(message) {
            // Remove any existing toast
            const existingToast = document.querySelector('.error-toast');
            if (existingToast) {
                existingToast.remove();
            }
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'error-toast fixed bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300';
            toast.style.cssText = 'top: 90px; right: 20px; z-index: 10000;';
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <div>
                        <div class="font-bold text-lg">Error!</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                </div>
            `;
            
            // Add to page
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto remove after 4 seconds (longer for error messages)
            setTimeout(() => {
                toast.style.transform = 'translateX(full)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 4000);
        }

        // Function to save comment - GLOBAL SCOPE
        function saveMenuItemComment() {
            const comment = document.getElementById('comment-text').value.trim();
            
            const requestData = {
                ...currentCommentData,
                comment: comment
            };
            
            fetch('<?php echo base_url("Orderportal/Order/saveMenuItemComment"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    updateCommentButtonAppearance(currentCommentData, comment !== '');
                    
                    // Close modal
                    closeCommentModal();
                    
                    // Show success toast notification
                    showSuccessToast(comment !== '' ? 'Comment saved successfully!' : 'Comment deleted successfully!');
                } else {
                    showErrorToast('Error saving comment: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error saving comment:', error);
                showErrorToast('Error saving comment. Please try again.');
            });
        }

        // Function to update comment button appearance - GLOBAL SCOPE
        function updateCommentButtonAppearance(commentData, hasComment) {
            const buttons = document.querySelectorAll(`[data-bed-id="${commentData.bed_id}"][data-menu-id="${commentData.menu_id}"][data-option-id="${commentData.option_id}"].comment-btn`);
            buttons.forEach(button => {
                if (hasComment) {
                    button.classList.add('text-orange-600');
                    button.classList.remove('text-gray-400');
                } else {
                    button.classList.add('text-gray-400');
                    button.classList.remove('text-orange-600');
                }
            });
        }

        // Function to close comment modal - GLOBAL SCOPE
        function closeCommentModal() {
            const modal = document.getElementById('comment-modal');
            const commentText = document.getElementById('comment-text');
            
            if (modal) {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
            
            if (commentText) {
                commentText.value = '';
            }
            
            currentCommentData = {};
        }

        // Function to setup comment modal event listeners - GLOBAL SCOPE
        function setupCommentModalEventListeners() {
            
            // Save button event listener
            const saveButton = document.getElementById('save-comment');
            if (saveButton) {
                saveButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    saveMenuItemComment();
                });
            }
            
            // Cancel button event listener
            const cancelButton = document.getElementById('cancel-comment');
            if (cancelButton) {
                cancelButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeCommentModal();
                });
            }
            
            // Close modal when clicking outside
            const modal = document.getElementById('comment-modal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeCommentModal();
                    }
                });
            }
        }

        // Function to load existing comment indicators
        function loadExistingCommentIndicators() {
            // Get all comment buttons and check if they have existing comments
            const commentButtons = document.querySelectorAll('.comment-btn');
            
            commentButtons.forEach(button => {
                const bedId = button.getAttribute('data-bed-id');
                const menuId = button.getAttribute('data-menu-id');
                const optionId = button.getAttribute('data-option-id');
                
                // Check if comment exists for this item
                fetch('<?php echo base_url("Orderportal/Order/getMenuItemComment"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        bed_id: bedId,
                        menu_id: menuId,
                        option_id: optionId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.comment && data.comment.trim() !== '') {
                        button.classList.add('text-orange-600');
                        button.classList.remove('text-gray-400');
                    }
                })
                .catch(error => {
                    console.error('Error checking comment:', error);
                });
            });
        }

        // Function to update choice counter
        function updateChoiceCounter(groupElement) {
            const groupId = groupElement.getAttribute('data-group');
            const maxChoices = parseInt(groupElement.getAttribute('data-max')) || 2;
            
            // Count checked inputs in this group
            const checkedInputs = groupElement.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked');
            const selectedCount = checkedInputs.length;
            
            // Try different counter ID formats to find the element
            const possibleIds = [
                `count-${groupId}`,
                `count-${groupId.replace('_', '-')}`,
                `count-${groupId.replace(/_/g, '-')}`
            ];
            
            let counterElement = null;
            for (const id of possibleIds) {
                counterElement = document.getElementById(id);
                if (counterElement) break;
            }
            
            // If not found by ID, try to find it within the group's parent section
            if (!counterElement) {
                const parentSection = groupElement.closest('.mb-6, .mb-4, .menu-section');
                if (parentSection) {
                    counterElement = parentSection.querySelector('.choice-counter, [class*="count-"]');
                }
            }
            
            if (counterElement) {
                counterElement.textContent = `(Choose up to ${maxChoices} - Selected: ${selectedCount})`;
                
                // Update styling based on selection status
                if (selectedCount >= maxChoices) {
                    counterElement.className = 'ml-2 text-sm font-normal text-green-600';
                } else if (selectedCount > 0) {
                    counterElement.className = 'ml-2 text-sm font-normal text-orange-600';
                } else {
                    counterElement.className = 'ml-2 text-sm font-normal text-gray-500';
                }
            }
        }

        // Function to setup choice counter listeners
        function setupChoiceCounters() {
            // Initialize counters for all groups
            updateChoiceCounters();
            
            // Add event listeners to all menu option groups
            document.querySelectorAll('[data-group]').forEach(group => {
                const inputs = group.querySelectorAll('input[type="checkbox"], input[type="radio"]');
                inputs.forEach(input => {
                    input.addEventListener('change', function() {
                        updateChoiceCounter(group);
                    });
                });
                
                // Initialize counter
                updateChoiceCounter(group);
            });
        }

        // Test function to open modal directly
        function testOpenModal() {
            const modal = document.getElementById('comment-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
                document.getElementById('comment-suite-info').textContent = 'Test Suite';
                document.getElementById('comment-menu-info').textContent = 'Test Menu';
                document.getElementById('comment-item-info').textContent = 'Test Item';
            }
        }

        // Initialize comment system when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            
            // Set up comment modal event listeners immediately
            setupCommentModalEventListeners();
            
            // Setup choice counters after menu items are loaded
            setTimeout(() => {
                setupChoiceCounters();
                // Ensure all counters are updated with correct initial values
                updateChoiceCounters();
            }, 1000);
            
            // Load comment indicators after menu items are loaded
            setTimeout(() => {
                loadExistingCommentIndicators();
                
                // Add a test button to the page
                const testBtn = document.createElement('button');
                testBtn.textContent = 'Test Comment Modal';
                testBtn.style.cssText = 'position: fixed; top: 10px; right: 10px; z-index: 9999; background: red; color: white; padding: 10px; border: none; cursor: pointer;';
                testBtn.onclick = testOpenModal;
                document.body.appendChild(testBtn);
            }, 2000);
        });
        
        // Also initialize when the page is fully loaded (backup)
        window.addEventListener('load', function() {
            setupCommentModalEventListeners();
        });
        
        // Function to close comment modal - GLOBAL SCOPE
        function closeCommentModal() {
            const modal = document.getElementById('comment-modal');
            const modalContent = document.getElementById('comment-modal-content');
            
            if (modal && modalContent) {
                // Remove opening class and start closing animation
                modal.classList.remove('modal-opening');
                modalContent.style.transform = 'scale(0.95)';
                modalContent.style.opacity = '0';
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    
                    // Reset form and data
                    const commentTextarea = document.getElementById('comment-text');
                    if (commentTextarea) {
                        commentTextarea.value = '';
                    }
                    currentCommentData = {};
                    
                    // Reset modal content styles for next opening
                    setTimeout(() => {
                        modalContent.style.transform = 'scale(0.95)';
                        modalContent.style.opacity = '0';
                    }, 50);
                }, 300);
                
            }
        }
        
        // Function to setup comment modal event listeners - GLOBAL SCOPE
        function setupCommentModalEventListeners() {
            
            // Wait a bit for modal to fully render
            setTimeout(() => {
                // Save button
                const saveBtn = document.getElementById('save-comment');
                if (saveBtn) {
                    // Remove any existing listeners by cloning
                    const newSaveBtn = saveBtn.cloneNode(true);
                    saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
                    
                    newSaveBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        saveMenuItemComment();
                    });
                }
                
                // Cancel button
                const cancelBtn = document.getElementById('cancel-comment');
                if (cancelBtn) {
                    // Remove any existing listeners by cloning
                    const newCancelBtn = cancelBtn.cloneNode(true);
                    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                    
                    newCancelBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeCommentModal();
                    });
                }
                
                // Close on background click
                const modal = document.getElementById('comment-modal');
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeCommentModal();
                        }
                    });
                }
            }, 100);
        }

        // Notification system for pending orders
        function checkPendingOrderNotifications() {
            fetch('<?php echo base_url('Orderportal/Order/getPendingOrderNotifications'); ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications && data.notifications.length > 0) {
                        showPendingOrderNotification(data.notifications[0]);
                    }
                })
                .catch(error => {
                    console.log('Error checking notifications:', error);
                });
        }

        function showPendingOrderNotification(notification) {
            const notificationEl = document.getElementById('pending-orders-notification');
            const titleEl = document.getElementById('notification-title');
            const messageEl = document.getElementById('notification-message');
            const detailsEl = document.getElementById('notification-details');

            titleEl.textContent = notification.title;
            messageEl.textContent = notification.message;

            // Build details list
            let detailsHtml = '';
            if (notification.suites_without_orders && notification.patient_names) {
                detailsHtml = '<strong>Suites without orders:</strong><br>';
                notification.suites_without_orders.forEach(suite => {
                    const patientName = notification.patient_names[suite.id] || 'Unknown Patient';
                    detailsHtml += `• Suite ${suite.bed_no}: ${patientName}<br>`;
                });
            }
            detailsEl.innerHTML = detailsHtml;

            notificationEl.classList.remove('hidden');
            
            // Add flashing effect
            setInterval(() => {
                notificationEl.classList.toggle('animate-pulse');
            }, 2000);
        }

        function dismissNotification() {
            document.getElementById('pending-orders-notification').classList.add('hidden');
        }

        // Check for notifications every 5 minutes and on page load
        checkPendingOrderNotifications();
        setInterval(checkPendingOrderNotifications, 5 * 60 * 1000); // 5 minutes

        // Room Service Checkbox Functionality (Reception - with date)
        function loadRoomServiceStatus(orderDate) {
            if (!currentBedId) return;
            
            // Use provided date or fall back to selectedOrderDate
            const dateToUse = orderDate || selectedOrderDate;
            
            fetch('<?php echo site_url('Orderportal/Order/getRoomServiceStatus'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                body: 'suite_id=' + encodeURIComponent(currentBedId) + '&order_date=' + encodeURIComponent(dateToUse)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const checkbox = document.getElementById('room-service-checkbox');
                    checkbox.checked = data.is_done;
                    updateRoomServiceUI(data.is_done);
                }
            })
            .catch(error => {
                console.error('Error loading room service status:', error);
            });
        }
        
        // Update Room Service UI based on status
        function updateRoomServiceUI(isDone) {
            const icon = document.getElementById('room-service-icon');
            const container = document.getElementById('room-service-container');
            
            if (isDone) {
                // Checked state - beautiful green with glow
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-green-500', 'drop-shadow-lg');
                container.classList.remove('border-gray-200', 'from-white', 'to-gray-50');
                container.classList.add('border-green-400', 'from-green-50', 'to-white', 'shadow-green-200/50');
            } else {
                // Unchecked state - subtle gray
                icon.classList.remove('text-green-500', 'drop-shadow-lg');
                icon.classList.add('text-gray-400');
                container.classList.remove('border-green-400', 'from-green-50', 'to-white', 'shadow-green-200/50');
                container.classList.add('border-gray-200', 'from-white', 'to-gray-50');
            }
        }
        
        // Print Meal Selection Function
        function printMealSelection(event) {
            event.preventDefault();
            event.stopPropagation();
            
            // Get the current suite information
            const suiteName = document.getElementById('selectedSuite')?.textContent || 'Suite';
            const mealSections = document.getElementById('meal-sections');
            const notesSection = document.getElementById('notes-section');
            const roomServiceCheckbox = document.getElementById('room-service-checkbox');
            const isRoomService = roomServiceCheckbox?.checked || false;
            
            // Get patient name from bedLists
            const currentBed = bedLists.find(bed => bed.id == currentBedId);
            const patientName = currentBed?.patient_name || '';
            
            if (!mealSections) {
                alert('No meal selection to print');
                return;
            }
            
            // Build the print content
            let printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Meal Selection - ${suiteName}</title>
                    <style>
                        * {
                            margin: 0 !important;
                            padding: 0 !important;
                            box-sizing: border-box;
                        }
                        html {
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        body {
                            margin: 0 !important;
                            padding: 5px !important;
                            font-family: Arial, sans-serif;
                            line-height: 1.4;
                            color: #333;
                        }
                        @page { 
                            margin: 0.2cm;
                            size: A4;
                        }
                        .header {
                            text-align: center;
                            border-bottom: 2px solid #2563eb;
                            padding-bottom: 8px !important;
                            margin-bottom: 12px !important;
                            margin-top: 0 !important;
                        }
                        .header h1 {
                            color: #2563eb;
                            margin: 0 !important;
                            padding: 0 0 3px 0 !important;
                            font-size: 22px;
                        }
                        .header .date {
                            color: #666;
                            font-size: 11px;
                            margin: 0 !important;
                        }
                        .rs-badge {
                            display: inline-block;
                            background: #2563eb;
                            color: white;
                            padding: 3px 10px !important;
                            border-radius: 12px;
                            font-size: 10px;
                            font-weight: bold;
                            margin: 3px 0 0 0 !important;
                        }
                        .meal-content {
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        .meal-category {
                            margin: 0 0 12px 0 !important;
                            padding: 0 !important;
                            page-break-inside: avoid;
                        }
                        .meal-category-header {
                            background: #eff6ff;
                            padding: 6px 10px !important;
                            border-left: 3px solid #2563eb;
                            margin: 0 0 6px 0 !important;
                        }
                        .meal-category-title {
                            font-size: 15px;
                            font-weight: bold;
                            color: #1e40af;
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        .meal-section {
                            margin: 0 0 8px 0 !important;
                            padding: 0 0 0 10px !important;
                        }
                        .menu-title {
                            font-size: 13px;
                            font-weight: bold;
                            color: #374151;
                            margin: 0 0 4px 0 !important;
                            padding: 0 !important;
                        }
                        .menu-options {
                            list-style: none;
                            padding: 0 0 0 12px !important;
                            margin: 0 0 6px 0 !important;
                        }
                        .menu-option {
                            padding: 2px 0 !important;
                            margin: 0 !important;
                            border-bottom: 1px dotted #d1d5db;
                            font-size: 12px;
                        }
                        .menu-option:last-child {
                            border-bottom: none;
                        }
                        .option-selected {
                            color: #059669;
                            font-weight: 600;
                        }
                        .option-selected::before {
                            content: "✓ ";
                            font-weight: bold;
                        }
                        .notes-section {
                            margin: 12px 0 0 0 !important;
                            padding: 8px !important;
                            background: #fef3c7;
                            border-left: 3px solid #f59e0b;
                            page-break-inside: avoid;
                        }
                        .notes-title {
                            font-size: 13px;
                            font-weight: bold;
                            color: #92400e;
                            margin: 0 0 4px 0 !important;
                            padding: 0 !important;
                        }
                        .notes-content {
                            color: #78350f;
                            white-space: pre-wrap;
                            font-size: 12px;
                            margin: 0 !important;
                            padding: 0 !important;
                        }
                        .footer {
                            margin: 10px 0 0 0 !important;
                            padding: 8px 0 0 0 !important;
                            border-top: 1px solid #e5e7eb;
                            text-align: center;
                            font-size: 9px;
                            color: #6b7280;
                        }
                        @media print {
                            * {
                                margin: 0 !important;
                                padding: 0 !important;
                            }
                            html, body { 
                                margin: 0 !important;
                                padding: 0 !important;
                            }
                            body {
                                padding: 3px !important;
                            }
                            .no-print {
                                display: none;
                            }
                            .header {
                                margin: 0 0 8px 0 !important;
                                padding: 0 0 6px 0 !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>${suiteName}</h1>
                        ${patientName ? `<div class="patient-name" style="color: #1e40af; font-size: 14px; font-weight: 600; margin: 3px 0 0 0 !important; padding: 0 !important;">Patient: ${patientName}</div>` : ''}
                        <div class="date">Meal Selection - ${new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</div>
                        ${isRoomService ? '<div class="rs-badge">Room Service</div>' : ''}
                    </div>
                    
                    <div class="meal-content">
            `;
            
            // Process meal sections
            const categories = mealSections.querySelectorAll('[id$="-section"]');
            categories.forEach(category => {
                const categoryHeader = category.querySelector('.bg-blue-50');
                const categoryTitle = categoryHeader?.querySelector('h2')?.textContent || '';
                
                if (categoryTitle) {
                    printContent += `
                        <div class="meal-category">
                            <div class="meal-category-header">
                                <div class="meal-category-title">${categoryTitle}</div>
                            </div>
                    `;
                    
                    // Process each menu within the category
                    const menus = category.querySelectorAll('.mb-6');
                    menus.forEach(menu => {
                        const menuTitle = menu.querySelector('h3')?.textContent?.split('(')[0].trim() || '';
                        
                        if (menuTitle) {
                            printContent += `
                                <div class="meal-section">
                                    <div class="menu-title">${menuTitle}</div>
                                    <ul class="menu-options">
                            `;
                            
                            // Get all options in this menu
                            const options = menu.querySelectorAll('.menu-option-checkbox');
                            options.forEach(option => {
                                const optionLabel = option.closest('.relative')?.querySelector('span.text-sm')?.textContent || '';
                                const isChecked = option.checked;
                                
                                if (optionLabel) {
                                    printContent += `
                                        <li class="menu-option ${isChecked ? 'option-selected' : ''}">${optionLabel}</li>
                                    `;
                                }
                            });
                            
                            printContent += `
                                    </ul>
                                </div>
                            `;
                        }
                    });
                    
                    printContent += `
                        </div>
                    `;
                }
            });
            
            // Add notes if any
            const notesTextarea = document.getElementById('notes-textarea');
            if (notesTextarea && notesTextarea.value.trim()) {
                printContent += `
                    <div class="notes-section">
                        <div class="notes-title">Special Instructions / Notes:</div>
                        <div class="notes-content">${notesTextarea.value}</div>
                    </div>
                `;
            }
            
            printContent += `
                    </div>
                    
                    <div class="footer">
                        Printed on ${new Date().toLocaleString('en-US')}
                    </div>
                </body>
                </html>
            `;
            
            // Create a hidden iframe for printing
            let printFrame = document.getElementById('print-frame');
            if (!printFrame) {
                printFrame = document.createElement('iframe');
                printFrame.id = 'print-frame';
                printFrame.style.position = 'absolute';
                printFrame.style.width = '0';
                printFrame.style.height = '0';
                printFrame.style.border = 'none';
                document.body.appendChild(printFrame);
            }
            
            // Write content to iframe
            const frameDoc = printFrame.contentWindow || printFrame.contentDocument;
            if (frameDoc.document) frameDoc.document.open();
            else frameDoc.open();
            
            frameDoc.document.write(printContent);
            frameDoc.document.close();
            
            // Wait for content to load, then print
            setTimeout(() => {
                try {
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                } catch (e) {
                    console.error('Print error:', e);
                    alert('Unable to print. Please try again.');
                }
            }, 250);
        }
        
        // Handle Room Service checkbox click
        function handleRoomServiceClick(event) {
            // Don't prevent default - let checkbox toggle naturally
            // event.preventDefault();
            event.stopPropagation();
            
            const checkbox = document.getElementById('room-service-checkbox');
            const isChecked = checkbox.checked; // Current state after click
            
            // Show existing PIN modal - if PIN fails, we'll revert the checkbox
            showRoomServicePinModal(isChecked);
        }
        
        // Show PIN modal for Room Service
        function showRoomServicePinModal(isChecked) {
            const pinModal = document.getElementById('pin-modal');
            const pinModalContent = document.getElementById('pin-modal-content');
            const pinInput = document.getElementById('pin-input');
            const submitBtn = document.getElementById('submit-pin');
            const cancelBtn = document.getElementById('cancel-pin');
            
            // Capture current bed ID at the time modal is shown
            const suiteId = currentBedId;
            
            if (!suiteId) {
                showWarning('Please select a suite first.');
                return;
            }
            
            // 🔥 CRITICAL FIX: Clear the suite selection onclick handler to prevent allergen modal
            // The suite selection sets submitBtn.onclick which would trigger openSuiteInterface()
            // We need to clear it so ONLY room service handlers run
            submitBtn.onclick = null;
            
            // Update modal title
            const modalTitle = pinModalContent.querySelector('h2');
            modalTitle.textContent = isChecked ? 'Enter PIN to Mark Room Service' : 'Enter PIN to Unmark Room Service';
            
            // Clear previous input
            pinInput.value = '';
            
            // Show modal
            pinModal.classList.remove('hidden');
            setTimeout(() => {
                pinModalContent.classList.add('scale-100', 'opacity-100');
                pinInput.focus();
            }, 10);
            
            // Create new handlers for Room Service
            const handleRoomServicePinSubmit = function() {
                const pin = pinInput.value.trim();
                
                if (pin.length !== 4) {
                    showWarning('Please enter a 4-digit PIN.');
                    return;
                }
                
                // 🔧 FIX: Verify Nurse PIN instead of suite PIN (like override does)
                // Step 1: Verify Nurse PIN
                fetch('<?php echo base_url("Orderportal/Order/verifyAnyNursePin"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    body: 'pin=' + encodeURIComponent(pin)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Nurse PIN verified - now update Room Service status
                        const requestBody = 'suite_id=' + encodeURIComponent(suiteId) + 
                              '&is_done=' + (isChecked ? '1' : '0') +
                              '&order_date=' + encodeURIComponent(selectedOrderDate) +
                              '&nurse_name=' + encodeURIComponent(data.nurse_name || 'Nurse');
                        
                        // Step 2: Update Room Service status (no PIN needed since already verified)
                        return fetch('<?php echo site_url('Orderportal/Order/updateRoomServiceStatus'); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                            },
                            body: requestBody
                        });
                    } else {
                        // Invalid Nurse PIN
                        throw new Error('PIN is wrong');
                    }
                })
                .then(response => {
                    if (!response) return; // Error already thrown above
                    return response.json();
                })
                .then(data => {
                    if (!data) return; // Error already thrown above
                    
                    if (data.success) {
                        // Update UI with animation
                        updateRoomServiceUI(isChecked);
                        
                        // Close modal
                        closeRoomServicePinModal();
                        
                        // Show success message
                        showWarning(isChecked ? 'Room Service marked as done ✓' : 'Room Service unmarked');
                    } else {
                        // Update failed - revert checkbox
                        console.error('❌ Update failed:', data.message);
                        const checkbox = document.getElementById('room-service-checkbox');
                        checkbox.checked = !isChecked; // Revert to previous state
                        
                        showWarning(data.message || 'Failed to update Room Service status');
                    }
                })
                .catch(error => {
                    const checkbox = document.getElementById('room-service-checkbox');
                    checkbox.checked = !isChecked;
                    showWarning(error.message || 'An error occurred. Please try again.');
                    pinInput.value = '';
                    pinInput.focus();
                });
            };
            
            const handleRoomServicePinCancel = function() {
                // User cancelled - revert checkbox to previous state
                const checkbox = document.getElementById('room-service-checkbox');
                checkbox.checked = !isChecked;
                closeRoomServicePinModal();
            };
            
            const closeRoomServicePinModal = function() {
                pinModal.classList.add('hidden');
                pinModalContent.classList.remove('scale-100', 'opacity-100');
                pinInput.value = '';
                
                // Remove event listeners
                submitBtn.removeEventListener('click', handleRoomServicePinSubmit);
                cancelBtn.removeEventListener('click', handleRoomServicePinCancel);
                pinInput.removeEventListener('keypress', handleRoomServicePinKeypress);
            };
            
            const handleRoomServicePinKeypress = function(e) {
                if (e.key === 'Enter') {
                    handleRoomServicePinSubmit();
                }
            };
            
            // Attach event listeners
            submitBtn.addEventListener('click', handleRoomServicePinSubmit);
            cancelBtn.addEventListener('click', handleRoomServicePinCancel);
            pinInput.addEventListener('keypress', handleRoomServicePinKeypress);
        }
        
        // Show warning function
        function showWarning(message) {
            const warningModal = document.getElementById('warning-modal');
            const warningModalContent = document.getElementById('warning-modal-content');
            const warningMessage = document.getElementById('warning-message');
            
            warningMessage.textContent = message;
            warningModal.classList.remove('hidden');
            setTimeout(() => {
                warningModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        // Close warning modal function
        function closeWarningModal() {
            const modal = document.getElementById('warning-modal');
            const modalContent = document.getElementById('warning-modal-content');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Allergen Disclaimer Modal Functions
        function showAllergenDisclaimerModal() {
            const modal = document.getElementById('allergen-disclaimer-modal');
            const modalContent = document.getElementById('allergen-disclaimer-modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function closeAllergenDisclaimerModal() {
            const modal = document.getElementById('allergen-disclaimer-modal');
            const modalContent = document.getElementById('allergen-disclaimer-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
        
        // Handle allergen disclaimer acceptance
        function acceptAllergenDisclaimer() {
            closeAllergenDisclaimerModal();
            
            pendingBedElement = null;
        }

        // ============================================
        // OVERRIDE FUNCTIONS
        // ============================================
        
        // Initialize override UI on page load
        
        // Handle Override button click
        function handleNurseOverrideClick() {
            const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
            
            if (nurseOverrideActive) {
                // Already active - clicking again will deactivate
                if (confirm('Override is currently active. Do you want to deactivate it?')) {
                    deactivateNurseOverride();
                }
            } else {
                // Not active - show PIN modal to activate
                showNurseOverridePinModal();
            }
        }
        
        // Show PIN modal for Override
        function showNurseOverridePinModal() {
            const pinModal = document.getElementById('pin-modal');
            const pinModalContent = document.getElementById('pin-modal-content');
            const pinInput = document.getElementById('pin-input');
            const submitBtn = document.getElementById('submit-pin');
            const cancelBtn = document.getElementById('cancel-pin');
            
            // Update modal title
            const modalTitle = pinModalContent.querySelector('h2');
            modalTitle.textContent = 'Enter Nurse PIN to Override Cutoff Time';
            
            // Clear previous input
            pinInput.value = '';
            
            // Show modal
            pinModal.classList.remove('hidden');
            setTimeout(() => {
                pinModalContent.classList.add('scale-100', 'opacity-100');
                pinInput.focus();
            }, 10);
            
            // Clear previous onclick handler
            submitBtn.onclick = null;
            
            // Create new handler for Override PIN
            const handleNurseOverridePinSubmit = function() {
                const pin = pinInput.value.trim();
                
                if (pin.length !== 4) {
                    showWarning('Please enter a 4-digit PIN.');
                    return;
                }
                
                // Show loader
                document.getElementById('loader').classList.remove('hidden');
                
                // Verify PIN against any nurse in the system
                fetch('<?php echo base_url("Orderportal/Order/verifyAnyNursePin"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    body: 'pin=' + encodeURIComponent(pin)
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loader').classList.add('hidden');
                    
                    if (data.success) {
                        // PIN verified successfully - activate override
                        // Store in sessionStorage
                        sessionStorage.setItem('nurseOverrideActive', 'true');
                        sessionStorage.setItem('nurseOverrideName', data.nurse_name || 'Nurse');
                        
                        // Update UI
                        updateNurseOverrideUI(true, data.nurse_name);
                        
                        // Close modal
                        closeNurseOverridePinModal();
                        
                        // Show success message
                        showSuccessToast('Override activated by ' + (data.nurse_name || 'Nurse') + '! Orders can now be placed after cutoff time.');
                    } else {
                        // PIN verification failed
                        showWarning(data.message || 'Invalid Nurse PIN. Please try again.');
                        pinInput.value = '';
                        pinInput.focus();
                    }
                })
                .catch(error => {
                    document.getElementById('loader').classList.add('hidden');
                    showWarning('An error occurred. Please try again.');
                    pinInput.value = '';
                });
            };
            
            const handleNurseOverridePinCancel = function() {
                closeNurseOverridePinModal();
            };
            
            const closeNurseOverridePinModal = function() {
                pinModal.classList.add('hidden');
                pinModalContent.classList.remove('scale-100', 'opacity-100');
                pinInput.value = '';
                
                // Remove event listeners
                submitBtn.removeEventListener('click', handleNurseOverridePinSubmit);
                cancelBtn.removeEventListener('click', handleNurseOverridePinCancel);
                pinInput.removeEventListener('keypress', handleNurseOverridePinKeypress);
            };
            
            const handleNurseOverridePinKeypress = function(e) {
                if (e.key === 'Enter') {
                    handleNurseOverridePinSubmit();
                }
            };
            
            // Attach event listeners
            submitBtn.addEventListener('click', handleNurseOverridePinSubmit);
            cancelBtn.addEventListener('click', handleNurseOverridePinCancel);
            pinInput.addEventListener('keypress', handleNurseOverridePinKeypress);
        }
        
        // Update Override UI
        function updateNurseOverrideUI(isActive, nurseName = 'Nurse') {
            const button = document.getElementById('nurse-override-btn');
            const icon = document.getElementById('nurse-override-icon');
            
            if (isActive) {
                // Active state - green with glow
                button.classList.remove('border-gray-200', 'from-white', 'to-gray-50');
                button.classList.add('border-green-400', 'from-green-50', 'to-white', 'shadow-green-200/50', 'ring-2', 'ring-green-300');
                
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-green-500', 'drop-shadow-lg');
                
                // Update button text to show nurse name
                const textSpan = button.querySelector('.text-sm');
                if (textSpan) {
                    textSpan.innerHTML = `Override Active<br><span class="text-xs text-green-600">${nurseName}</span>`;
                }
            } else {
                // Inactive state - gray
                button.classList.remove('border-green-400', 'from-green-50', 'to-white', 'shadow-green-200/50', 'ring-2', 'ring-green-300');
                button.classList.add('border-gray-200', 'from-white', 'to-gray-50');
                
                icon.classList.remove('text-green-500', 'drop-shadow-lg');
                icon.classList.add('text-gray-400');
                
                // Reset button text
                const textSpan = button.querySelector('.text-sm');
                if (textSpan) {
                    textSpan.textContent = 'Override';
                }
            }
        }
        
        // Deactivate Override
        function deactivateNurseOverride() {
            // Clear sessionStorage
            sessionStorage.removeItem('nurseOverrideActive');
            sessionStorage.removeItem('nurseOverrideName');
            
            // Update UI
            updateNurseOverrideUI(false);
            
            // Show message
            showSuccessToast('Override deactivated. Normal cutoff time rules now apply.');
        }

        // Restore Override UI on page load AND Initialize Date Picker
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure DOM is fully rendered
            setTimeout(function() {
                const nurseOverrideActive = sessionStorage.getItem('nurseOverrideActive') === 'true';
                if (nurseOverrideActive) {
                    const nurseName = sessionStorage.getItem('nurseOverrideName') || 'Nurse';
                    updateNurseOverrideUI(true, nurseName);
                }
            }, 100);
            
            // NEW: Initialize date picker (Reception)
            const datePicker = document.getElementById('order-date-picker');
            if (datePicker) {
                // Set the date picker to the current selectedOrderDate (restored from session or default tomorrow)
                datePicker.value = selectedOrderDate;
                updateDateDisplays(selectedOrderDate);
                
                // Add change event listener
                datePicker.addEventListener('change', function() {
                    const selectedDate = this.value;
                    if (selectedDate) {
                        handleDateChange(selectedDate);
                    }
                });
            }
        });

</script>


</body>
</html>
</html>