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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        
        /* Header styling */
        #page-topbar {
            background-color: #1f2937 !important;
            border-bottom: 1px solid #374151;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 70px;
        }
        
        .layout-width {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .navbar-header {
    display: flex;
    align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        
        .d-flex {
            display: flex !important;
        }
        
        .align-items-center {
            align-items: center !important;
        }
        
        .ms-1 {
            margin-left: 0.25rem !important;
        }
        
        .ms-sm-3 {
            margin-left: 1rem !important;
        }
        
        .header-item {
            position: relative;
        }
        
        .btn-icon {
            padding: 0.5rem;
            border: none;
            background: transparent;
            color: white;
            border-radius: 50%;
            transition: background-color 0.2s;
        }
        
        .btn-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1000;
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
        
        .bg-primary {
            background-color: #3b82f6 !important;
        }
        
        .text-white {
    color: white !important;
        }
        
        .fs-22 {
            font-size: 1.375rem !important;
        }
        
        .fs-16 {
            font-size: 1rem !important;
        }
        
        .fs-18 {
            font-size: 1.125rem !important;
        }
        
        .fs-12 {
            font-size: 0.75rem !important;
        }
        
        .fw-semibold {
            font-weight: 600 !important;
        }
        
        .fw-medium {
            font-weight: 500 !important;
        }
        
        .m-0 {
            margin: 0 !important;
        }
        
        .p-3 {
            padding: 0.75rem !important;
        }
        
        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
        
        .ps-2 {
            padding-left: 0.5rem !important;
        }
        
        .pb-5 {
            padding-bottom: 1.25rem !important;
        }
        
        .mt-2 {
            margin-top: 0.5rem !important;
        }
        
        .me-1 {
            margin-right: 0.25rem !important;
        }
        
        .ms-xl-2 {
            margin-left: 0.5rem !important;
        }
        
        .d-none {
            display: none !important;
        }
        
        .d-xl-inline-block {
            display: inline-block !important;
        }
        
        .d-xl-block {
            display: block !important;
        }
        
        .text-start {
            text-align: left !important;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .text-muted {
            color: #6b7280 !important;
        }
        
        .text-black {
            color: #000000 !important;
        }
        
        .lh-base {
            line-height: 1.5 !important;
        }
        
        .rounded-circle {
            border-radius: 50% !important;
        }
        
        .header-profile-user {
            width: 32px;
            height: 32px;
        }
        
        .shadow-none {
            box-shadow: none !important;
        }
        
        .btn {
            display: inline-block;
    font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .dropdown-header {
            display: block;
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            color: #6c757d;
            white-space: nowrap;
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
        }
        
        .bg-pattern {
            background-image: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%), 
                              linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%), 
                              linear-gradient(45deg, transparent 75%, rgba(255,255,255,0.1) 75%), 
                              linear-gradient(-45deg, transparent 75%, rgba(255,255,255,0.1) 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
        
        .rounded-top {
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
        }
        
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
        
        .dropdown-menu-lg {
            min-width: 22rem;
        }
        
        .p-0 {
            padding: 0 !important;
        }
        
        .tab-content {
            padding: 0;
        }
        
        .tab-pane {
            display: none;
        }
        
        .tab-pane.active {
            display: block;
        }
        
        .fade {
            transition: opacity 0.15s linear;
        }
        
        .show {
            display: block !important;
        }
        
        .topbar-user {
            position: relative;
        }
        
        .user-name-text {
            color: white !important;
        }
        
        .user-name-sub-text {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Adjust main content for header */
        .flex.h-screen {
            margin-top: 70px !important;
            height: calc(100vh - 70px) !important;
        }
        
        /* Footer styling */
        .footer {
            background-color: #152a45 !important;
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
        
        .text-mute {
            color: #6c757d !important;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.5rem;
        }
        
        .col-lg-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 0.5rem;
        }
        
        .mb-0 {
            margin-bottom: 0 !important;
        }
        
        /* Print Styles */
        @media print {
            header, .topbar, #sidebar, #sidebar-overlay, nav, footer, .footer, 
            button[onclick*="printMealSelection"], .print-button, #toggle-sidebar, 
            #close-sidebar, .no-print, .btn, .fa-print, .sticky {
                display: none !important;
            }
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            .flex.h-screen {
                margin-top: 0 !important;
                height: auto !important;
            }
            .flex-1.overflow-auto {
                margin: 0 !important;
                padding: 15px !important;
                overflow: visible !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            input[type="checkbox"] {
                -webkit-appearance: checkbox !important;
                appearance: checkbox !important;
                display: inline-block !important;
            }
        }
        
        /* 🆕 SPECIAL ITEMS FEATURE - Orange highlighting for high-allergy patients */
        .suite-card.high-allergy {
            border: 3px solid #ff8c00 !important;
            background: linear-gradient(135deg, #fff5e6 0%, #ffffff 100%) !important;
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.3) !important;
        }
        
        .suite-card.high-allergy .suite-number {
            background: #ff8c00 !important;
            color: white !important;
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
        
        .suite-card.high-allergy .text-blue-600 {
            color: #ff8c00 !important;
        }
        
        .suite-card.high-allergy:hover {
            border-color: #ff6500 !important;
            box-shadow: 0 6px 16px rgba(255, 140, 0, 0.4) !important;
            transform: translateY(-2px);
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
    <!-- Actual System Header -->
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="flex items-center">
                        <div class="text-xl font-bold tracking-wider flex items-center">
                            <a href="/Orderportal">
                                <img src="/theme-assets/images/logo/BizAdminLogo_White.png" alt="" height="60" width="110">
                            </a>
            </div>
                </div>
                    
                    <!-- Home Button (Nurse) - Moved next to logo -->
                    <div class="ms-1 header-item" style="margin-left: 1rem;">
                        <a href="<?= base_url('Orderportal') ?>" class="btn btn-icon btn-topbar rounded-circle" title="Go to Home" style="display: flex !important; align-items: center; justify-content: center; width: 45px; height: 45px; background-color: #3b82f6;">
                            <i class='fas fa-home' style="font-size: 20px !important; color: #ffffff !important;"></i>
                        </a>
                </div>
                    
                    <!-- HOSPITAL ADMIN NAVIGATION -->
                    <div style="margin-left: 1rem; position: relative;">
                        <button id="nurseToolsBtn" class="btn text-white fw-bold" style="background: none; border: none; font-size: 1rem; cursor: pointer;" onclick="toggleNurseTools()">
                            <i class="fas fa-user-nurse me-2"></i>HOSPITAL ADMIN <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <div id="nurseToolsMenu" class="nurse-tools-menu" style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); min-width: 280px; z-index: 1000; border-radius: 8px; overflow: hidden;">
                            <a href="<?= base_url('Orderportal/Patient/Onboarding') ?>" class="nurse-menu-item" style="color: #374151; padding: 0.75rem 1rem; display: flex; align-items: center; text-decoration: none; transition: background-color 0.2s;">
                                <i class="fas fa-user-plus me-2 text-blue-600"></i>
                                <span>View Person Details</span>
                                <small class="text-muted ms-auto">Patient management</small>
                            </a>
                            <hr style="margin: 0; border-color: #e5e7eb;">
                            <a href="<?= base_url('Orderportal/Hospitalconfig/List') ?>" class="nurse-menu-item" style="color: #374151; padding: 0.75rem 1rem; display: flex; align-items: center; text-decoration: none; transition: background-color 0.2s;">
                                <i class="fas fa-hospital me-2 text-green-600"></i>
                                <span>Manage Suites</span>
                                <small class="text-muted ms-auto">Hospital suite management</small>
                            </a>
                            <hr style="margin: 0; border-color: #e5e7eb;">
                            <a href="<?= base_url('Orderportal/Menuplanner/list') ?>" class="nurse-menu-item" style="color: #374151; padding: 0.75rem 1rem; display: flex; align-items: center; text-decoration: none; transition: background-color 0.2s;">
                                <i class="fas fa-utensils me-2 text-orange-600"></i>
                                <span>Menu Planner</span>
                                <small class="text-muted ms-auto">Menu planning tools</small>
                            </a>
                        </div>
                    </div>
        </div>

                <div class="d-flex align-items-center">
                    <!-- User Menu -->
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn shadow-none" data-bs-toggle="dropdown">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="/theme-assets/images/users/avatar-1.jpg" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $this->session->userdata('username'); ?></span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                        <i class="bx bx-laptop"></i> orderportal
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="background-color: #ffffff; border: 1px solid #e5e7eb;">
                            <h6 class="dropdown-header" style="color: #374151;">Welcome <?php echo $this->session->userdata('username'); ?>!</h6>
                            <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" style="color: #374151;">
                                <i class="mdi mdi-logout fs-16 align-middle me-1" style="color: #374151;"></i> 
                                <span class="align-middle">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="flex h-screen">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 fixed h-full hidden z-40" style="top: 0; height: 100vh;">
            <div class="p-6 h-full flex flex-col">
                <!-- Header -->
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
                
                <!-- Search Box -->
                <div class="mb-6 flex-shrink-0">
                    <div class="relative">
                        <input type="text" id="suite-search" placeholder="Search Suites" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                               autocomplete="off" autocapitalize="off" spellcheck="false" 
                               data-form-type="other" data-lpignore="true">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Status Legend -->
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
                
                <!-- Suites List -->
                <div id="suites-container" class="space-y-2 overflow-y-auto flex-1 pr-2" style="scrollbar-width: thin; scrollbar-color: #cbd5e0 #f7fafc;">
                    <?php if (isset($bedLists) && !empty($bedLists)) {
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
                            
                            // Determine suite status and styling to match the image
                            if ($hasOrder === 'true') {
                                $bgClass = 'bg-green-200 text-gray-800 border-green-300';
                                $statusText = 'Order Placed';
                            } elseif ($occupied === 'true') {
                                $bgClass = 'bg-blue-200 text-blue-800 border-blue-300';
                                $statusText = 'Occupied';
                            } else {
                                $bgClass = 'bg-white text-gray-700 border-gray-300';
                                $statusText = 'Vacant';
                            }
                            ?>
                            <button id="suite-<?php echo $bedList['id']; ?>" 
                                    class="clientLists suite-card w-full px-4 py-3 <?php echo $bgClass; ?> <?php echo $highAllergyClass; ?> rounded-lg border transition-all hover:shadow-md flex flex-col items-center justify-center text-center min-h-20 relative" 
                                    data-occupied="<?php echo $occupied; ?>" 
                                    data-ordered="<?php echo $hasOrder; ?>" 
                                    data-bed-id="<?php echo $bedList['id']; ?>" 
                                    data-is-occupied="<?php echo $bedList['is_occupied'] ? 'true' : 'false'; ?>"
                                    title="<?php echo $statusText; ?><?php echo !empty($bedList['patient_name']) ? ' - Patient: ' . htmlspecialchars($bedList['patient_name']) : ''; ?>">
                                <?php if ($hasHighAllergies): ?>
                                    <div class="allergy-badge">⚠️ <?php echo $allergyCount; ?> Allergies</div>
                                <?php endif; ?>
                                <div class="font-semibold text-base suite-number">
                                    Suite <?php echo htmlspecialchars($bedList['bed_no']); ?>
                                </div>
                                <?php if (!empty($bedList['patient_name'])): ?>
                                    <div class="text-xs text-blue-600 font-medium truncate w-full px-1" title="<?php echo htmlspecialchars($bedList['patient_name']); ?>"><?php echo htmlspecialchars($bedList['patient_name']); ?></div>
<?php endif; ?>
                                <div class="text-sm text-gray-600 mt-1"><?php echo $statusText; ?></div>
                            </button>
                            <?php }
                    } else { ?>
                        <p class="text-gray-500 text-center">No suites available.</p>
                    <?php } ?>
                </div>
            </div>
        </aside>

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
                
                <!-- Date Picker Section - COMPACT -->
                <div class="mb-6 bg-white rounded-xl shadow-md border border-gray-200 p-4 mx-2 overflow-visible">
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Icon & Title -->
                        <div class="flex items-center space-x-2 flex-shrink-0">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <i class="fas fa-calendar-alt text-base text-white"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">Order Date:</span>
                        </div>
                        
                        <!-- Date Picker - SELECTION ONLY -->
                        <div class="flex-shrink-0">
                            <input type="date" 
                                   id="order-date-picker" 
                                   class="px-3 py-2 border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm font-medium text-gray-800 cursor-pointer hover:border-blue-500 transition-all bg-white w-auto min-w-[150px]"
                                   min="<?php $this->load->helper('custom'); echo get_australia_date(); ?>"
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
                                <?php echo date('D, M d, Y', strtotime('+1 day')); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Header Section with Hello User and Steps in one row -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8 px-2 gap-4 sm:gap-0">
                    <!-- Left side - Hello User -->
                    <div>    
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
                        
                        <!-- NURSE PORTAL INFO -->
                        <div class="mt-4 p-4 bg-blue-100 border-2 border-blue-400 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-user-nurse text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <p class="text-blue-700 text-sm">No cutoff time restrictions. Place orders for late admissions and urgent cases.</p>
                                    <p class="text-blue-600 text-xs mt-1">Orders will be sent directly to chef with notifications.</p>
                                </div>
                            </div>
                        </div>

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
                            <button class="main-suite-btn suite-card min-h-20 p-3 <?php echo $bgClass; ?> <?php echo $highAllergyClass; ?> rounded-lg font-normal transition-all hover:scale-105 hover:shadow-md flex flex-col items-center justify-center relative" 
                                    data-occupied="<?php echo $occupied; ?>" 
                                    data-ordered="<?php echo $hasOrder; ?>" 
                                    data-bed-id="<?php echo $bedList['id']; ?>"
                                    data-is-occupied="<?php echo $bedList['is_occupied'] ? 'true' : 'false'; ?>"
                                    data-allergy-count="<?php echo $allergyCount; ?>"
                                    data-has-high-allergies="<?php echo $hasHighAllergies ? 'true' : 'false'; ?>"
                                    title="<?php echo $statusText; ?><?php echo !empty($bedList['patient_name']) ? ' - Patient: ' . htmlspecialchars($bedList['patient_name']) : ''; ?><?php echo $hasHighAllergies ? ' - ' . $allergyCount . ' Allergies' : ''; ?>">
                                <?php if ($hasHighAllergies): ?>
                                    <span class="allergy-badge"><?php echo $allergyCount; ?> Allergies</span>
                                <?php endif; ?>
                                <div class="text-sm font-medium">
                                    <?php echo htmlspecialchars($bedList['bed_no']); ?>
                                </div>
                                <?php if (!empty($bedList['patient_name'])): ?>
                                    <div class="text-xs text-blue-600 font-medium truncate w-full px-1" title="<?php echo htmlspecialchars($bedList['patient_name']); ?>"><?php echo htmlspecialchars($bedList['patient_name']); ?></div>
                                <?php endif; ?>
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
            
            <div id="order-content" class="max-w-7xl mx-auto px-6 sm:px-8 py-4 sm:py-6 pb-32" style="display: none;">

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
                                <button type="button" 
                                        onclick="printMealSelection(event)" 
                                        class="p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 transition-all duration-200 shadow-sm hover:shadow-md"
                                        title="Print Meal Selection">
                                    <i class="fas fa-print text-xl"></i>
                                </button>
                                </div>
                            </div>
                            <div class="ml-2 sm:ml-3 mt-1">
                                <span id="order-date-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700 border border-green-200">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    Order Date: <span id="order-date-display"><?php echo date('D, M d, Y', strtotime('+1 day')); ?></span>
                                </span>
                            </div>
                        </div>
                        <!-- Room Service Checkbox -->
                        <div id="room-service-container" class="bg-gradient-to-r from-white to-gray-50 border-2 border-gray-200 rounded-xl px-5 py-4 shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300 ease-in-out">
                            <label class="flex items-center justify-between cursor-pointer" onclick="event.preventDefault();">
                                <div class="flex items-center space-x-4">
                                    <input type="checkbox" id="room-service-checkbox" 
                                           class="w-6 h-6 text-green-600 border-2 border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:ring-offset-2 cursor-pointer transition-all hover:border-green-400" 
                                           onclick="handleRoomServiceClickNurse(event)">
                                    <div class="flex items-center space-x-2.5">
                                        <span class="text-xs font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 px-2.5 py-1 rounded-full shadow-sm">RS</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-concierge-bell text-2xl transition-all duration-300" id="room-service-icon"></i>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Order Status and Calories Info -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-3 sm:gap-0">
                        <div id="order-status-info" class="flex items-center bg-blue-50 px-4 py-2 rounded-lg" style="display: none;">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            <span class="text-blue-800 text-sm">Order already exists for this suite (<span class="order-count">0</span> items). You can modify or update the existing order.</span>
                        </div>
                        <div class="text-right pr-4 sm:pr-6">
                            <div class="text-lg font-semibold text-gray-800">
                                Total Calories: <span id="suite-calories" class="text-blue-600">0 Kcal</span>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo base_url('Orderportal/Order/placeOrder'); ?>" id="placeOrder" method="post" class="form-horizontal">
                        <input type="hidden" name="selectedBed" id="selected-bed">
                        <input type="hidden" name="buttonType" id="button-type" value="sendorder">
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




                        <!-- Breakfast Selection Instructions -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6 shadow-sm">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-600 text-2xl mt-1"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Breakfast Selection Guide</h3>
                                    <p class="text-blue-800 text-base leading-relaxed">
                                        Please choose <span class="font-bold">any two items</span> from <span class="font-semibold">Toast, Yoghurt, Fruit Salad, Porridge, or Cereals</span>, or alternatively select <span class="font-bold">one Breakfast Option</span>.
                                    </p>
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
                                    <span>Send to Chef</span>
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
                    <button type="button" id="close-warning" class="py-2 px-4 bg-amber-100 text-amber-700 rounded-md hover:bg-amber-200 transition-colors duration-200">Close</button>
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
                    <p id="modalAllergens" class="text-sm text-red-600 font-medium mt-2"></p>
                    <p id="modalDietrycodes" class="text-sm text-green-600 font-medium mt-2"></p>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="close-description" class="py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">Close</button>
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
                            Seafood, Fish, Crustacea/Molluscs, Egg, Gluten, Peanuts, Tree Nuts, Sesame, Dairy, Soy, Milk, Lupin, Sulphites and Cereals containing gluten (such as wheat, rye, barley, oats, and spelt).
                        </p>
                    </div>
                    
                    <p class="text-base leading-relaxed">
                        If you have any food allergies or sensitivities, please notify your nursing staff, or a member of our staff, prior to ordering and we will endeavour to source a remedy. Otherwise we strongly suggest you seek professional advice from your healthcare provider before ordering.
                    </p>
                    
                    <p class="text-base leading-relaxed">
                        <strong>Café Zenn</strong> recommends for optimal safety and quality consuming all hot or perishable items immediately. <strong>Café Zenn</strong> wishes to advise that once food is served or collected, the customer assumes full responsibility for its safe handling and storage.
                    </p>
                    
                    <p class="text-base leading-relaxed font-semibold">
                        By proceeding with your order, you acknowledge and accept these conditional circumstances.
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
        
        // NEW: Global variable for selected order date
        // Try to restore from sessionStorage, otherwise default to tomorrow
        let selectedOrderDate = sessionStorage.getItem('nurseSelectedOrderDate') || '<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>';
        
        // Update the date picker and displays with the selected date on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Restore the last selected date from sessionStorage (if available)
            const storedDate = sessionStorage.getItem('nurseSelectedOrderDate');
            if (storedDate) {
                selectedOrderDate = storedDate;
            }
            
            const datePicker = document.getElementById('order-date-picker');
            if (datePicker) {
                datePicker.value = selectedOrderDate;
                updateDateDisplays(selectedOrderDate);
                
                // 🔧 FIX: Refresh suite status for the selected date on page load
                // This ensures that when user returns after placing an order, 
                // the suite status is loaded for their previously selected date
                refreshSuiteStatusForDate(selectedOrderDate);
            }
        });
        
        let bedLists = <?php echo json_encode($bedLists ?? []); ?>; // Changed to let for dynamic updates
        let bedsWithOrders = <?php echo json_encode($bedsWithOrders ?? []); ?>; // Track orders dynamically
        const categoryListData = <?php echo json_encode($categoryListData ?? []); ?>;
        const menuLists = <?php echo json_encode($menuLists ?? []); ?>;
        const patientOrderData = <?php echo json_encode($patientOrderData ?? []); ?>;
        const savedMenuWithoutOptions = <?php echo json_encode($savedMenuWithoutOptions ?? []); ?>;
        const savedMenuWithOptions = <?php echo json_encode($savedMenuWithOptions ?? []);  ?>;
        
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
        
        // NEW: Date Picker Functions
        function resetToTomorrow() {
            const tomorrow = '<?php $this->load->helper('custom'); echo get_australia_tomorrow(); ?>';
            document.getElementById('order-date-picker').value = tomorrow;
            handleDateChange(tomorrow);
        }
        
        function handleDateChange(newDate) {
            selectedOrderDate = newDate;
            
            // CRITICAL FIX: Update the hidden form field so it's submitted with the form
            const orderDateField = document.getElementById('order-date-field');
            if (orderDateField) {
                orderDateField.value = newDate;
            }
            
            // Store the selected date in sessionStorage so it persists across page refreshes
            sessionStorage.setItem('nurseSelectedOrderDate', newDate);
            
            // Update all date displays
            updateDateDisplays(newDate);
            
            // Show loading indicator
            showDateChangeLoader();
            
            // Refresh suite status for the new date
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
            
            // Update both displays
            const selectedDateDisplay = document.getElementById('selected-date-display');
            const orderDateDisplay = document.getElementById('order-date-display');
            
            if (selectedDateDisplay) selectedDateDisplay.textContent = formattedShort;
            if (orderDateDisplay) orderDateDisplay.textContent = formattedShort;
            
        }
        
        function showDateChangeLoader() {
            // Show a loading toast
            const toast = document.createElement('div');
            toast.id = 'date-change-loader';
            toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-2xl z-[9999] flex items-center space-x-3';
            toast.innerHTML = `
                <i class="fas fa-sync-alt fa-spin text-2xl"></i>
                <div>
                    <div class="font-bold">Updating...</div>
                    <div class="text-sm">Loading orders for selected date</div>
                </div>
            `;
            document.body.appendChild(toast);
        }
        
        function hideDateChangeLoader() {
            const loader = document.getElementById('date-change-loader');
            if (loader) {
                loader.remove();
            }
        }
        
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
                    
                    hideDateChangeLoader();
                    
                    // Show success toast
                    showSuccessToast('Suite status updated for ' + dateStr);
                } else {
                    console.error('❌ Failed to fetch suite status:', data.message);
                    hideDateChangeLoader();
                    showErrorToast('Failed to update suite status');
                }
            })
            .catch(error => {
                console.error('❌ Error fetching suite status:', error);
                hideDateChangeLoader();
                showErrorToast('Error updating suite status');
            });
        }
        
        function updateSuiteStatusDisplay(bedListsData, bedsWithOrdersData) { 
            // Update global variables with new data
            bedLists = bedListsData;
            bedsWithOrders = bedsWithOrdersData;
            
            // Update both sidebar and main grid
            updateSidebarSuites(bedListsData, bedsWithOrdersData);
            updateMainGridSuites(bedListsData, bedsWithOrdersData);
            
        }
        
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
        
        function updateSidebarSuites(bedListsData, bedsWithOrdersData) {
            const suitesContainer = document.getElementById('suites-container');
            if (!suitesContainer) return;
            
            // Clear and rebuild sidebar suites
            suitesContainer.innerHTML = '';
            
            bedListsData.forEach(bedList => {
                if (!bedList.bed_no || bedList.bed_no.trim() === '') return;
                
                const isVacant = bedList.is_vaccant == 1;
                // Try both string and number comparison for robustness
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
                button.className = `clientLists suite-card w-full px-4 py-3 ${bgClass} ${highAllergyClass} rounded-lg border transition-all hover:shadow-md flex flex-col items-center justify-center text-center min-h-20 relative`;
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
        
        function updateMainGridSuites(bedListsData, bedsWithOrdersData) {
            const mainGrid = document.getElementById('main-suite-grid');
            if (!mainGrid) return;
            
            // Clear and rebuild main grid suites
            mainGrid.innerHTML = '';
            
            bedListsData.forEach(bedList => {
                if (!bedList.bed_no || bedList.bed_no.trim() === '') return;
                
                const isVacant = bedList.is_vaccant == 1;
                // Try both string and number comparison for robustness
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
                button.className = `main-suite-btn suite-card min-h-20 p-3 ${bgClass} ${highAllergyClass} rounded-lg font-normal transition-all hover:scale-105 hover:shadow-md flex flex-col items-center justify-center relative`;
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
            // NEW: Setup date picker event listener
            const datePicker = document.getElementById('order-date-picker');
            if (datePicker) {
                datePicker.addEventListener('change', function() {
                    const selectedDate = this.value;
                    if (selectedDate) {
                        handleDateChange(selectedDate);
                    }
                });
            }
            
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

                // Check if suite is occupied - only allow orders for occupied suites (like reception)
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

                // BYPASS PIN POPUP - Auto-verify PIN in background for reception users
                autoVerifyPinAndOpenSuite(bedElement);
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
            
            // Auto-verify PIN function for reception users (bypasses popup)
            function autoVerifyPinAndOpenSuite(bedElement) {
                // For reception users, we'll use a default PIN or skip verification
                // This keeps the core PIN logic intact but bypasses the UI popup
                const defaultPin = '0000'; // Default PIN for reception access
                
                fetch('<?php echo base_url('Orderportal/Order/verifyPin'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'bed_id=' + encodeURIComponent(currentBedId) + '&pin=' + encodeURIComponent(defaultPin) + '&bypass_reception=1'
                })
                .then(response => response.json())
                .then(data => {
                    // Always proceed for reception users (PIN verification bypassed)
                    openSuiteInterface(bedElement);
                })
                .catch(error => {
                    // Even if PIN check fails, proceed for reception users
                    openSuiteInterface(bedElement);
                });
            }
            
            // Function to open suite interface after PIN verification
            // Opens menu screen first, then shows allergen modal
            function openSuiteInterface(bedElement) {
                // Open the menu screen immediately
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
                
                // NEW: Update the hidden order date field with the selected date
                document.getElementById('order-date-field').value = selectedOrderDate;
                
                // Check if order already exists for this bed
                checkExistingOrder(currentBedId, selectedOrderDate);
                
                // Check update permissions
                checkUpdatePermissions(currentBedId);
                        
                // NEW: Render meal sections with the selected date
                renderMealSections(currentBedId, selectedOrderDate);
                updateCharCount();
                updateSuiteCalories(currentBedId);
                
                // Load Room Service status with the selected date
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
            
            // Sidebar bed selection - use event delegation to handle dynamically generated buttons
            // 🔧 FIX: Changed from forEach to event delegation so it works after refreshSuiteStatusForDate()
            const suitesContainer = document.getElementById('suites-container');
            if (suitesContainer) {
                suitesContainer.addEventListener('click', function(e) {
                    const button = e.target.closest('.clientLists');
                    if (button) {
                        handleSuiteSelection(button);
                    }
                });
            }
            
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
                
                // Restore the selected date
                const datePicker = document.getElementById('order-date-picker');
                if (datePicker && selectedOrderDate) {
                    datePicker.value = selectedOrderDate;
                    updateDateDisplays(selectedOrderDate);
                }
                
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
                    
                    // Restore the selected date
                    const datePicker = document.getElementById('order-date-picker');
                    if (datePicker && selectedOrderDate) {
                        datePicker.value = selectedOrderDate;
                        updateDateDisplays(selectedOrderDate);
                    }
                    
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
                    
                    // IMPORTANT: Restore the selected date in the date picker
                    const datePicker = document.getElementById('order-date-picker');
                    if (datePicker && selectedOrderDate) {
                        datePicker.value = selectedOrderDate;
                        updateDateDisplays(selectedOrderDate);
                    }
                    
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

            // Check if order already exists for this bed
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

            // Handle form submission - NO MORE sessionStorage success logic
            document.getElementById('placeOrder').addEventListener('submit', function(e) {
                // Debug: Check if selectedBed is set
                const selectedBed = document.getElementById('selected-bed').value;
                
                if (!selectedBed || selectedBed === '') {
            e.preventDefault();
                    alert('Please select a suite first before placing an order.');
            return false;
        }
                
                // CRITICAL FIX: Ensure the order date field is set to the currently selected date before submission
                // This prevents the date from reverting to the default value if the date picker was changed
                const orderDateField = document.getElementById('order-date-field');
                if (orderDateField && selectedOrderDate) {
                    orderDateField.value = selectedOrderDate;
                    console.log('Setting order date field to:', selectedOrderDate);
                }
                
                // Clear any existing success data to prevent cross-contamination
                sessionStorage.removeItem('orderSuccess');
                
                // Show loading state
                const submitButton = e.target.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Placing Order...';
                }
                
                // Let form submit normally - success/error will be handled by server-side flash messages
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

            // Close warning modal
            document.getElementById('close-warning').addEventListener('click', function() {
                const modal = document.getElementById('warning-modal');
                const modalContent = document.getElementById('warning-modal-content');
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            });

            // Close description modal
            document.getElementById('close-description').addEventListener('click', function() {
                const modal = document.getElementById('description-modal');
                const modalContent = document.getElementById('description-modal-content');
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            });

            // Close modal when clicking outside
            document.getElementById('description-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    const modal = document.getElementById('description-modal');
                    const modalContent = document.getElementById('description-modal-content');
                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
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

            

            // Send order button animation - nurses always send to chef (no cutoff time)
            document.getElementsByClassName('save-order')[0].addEventListener('click', function(e) {
                // Nurses have no cutoff time restrictions - always allow form submission
                // Just do the animation and let the form submit naturally
                
                document.getElementById('loader').classList.remove('hidden');
                document.getElementById('button-type').value = 'sendorder'; // Auto-send to chef
                this.innerHTML = '<i class="fa-solid fa-check mr-2"></i><span>Sent to Chef!</span>';
                this.classList.remove('bg-blue-600');
                this.classList.add('bg-green-600');
                setTimeout(() => {
                    this.innerHTML = '<i class="fa-solid fa-paper-plane mr-2"></i><span>Send to Chef</span>';
                    this.classList.remove('bg-green-600');
                    this.classList.add('bg-blue-600');
                }, 2000);
                // Don't prevent default - let the form submit naturally
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

            // Render meal sections dynamically
            function renderMealSections(bedId, orderDate) {
                // Use provided date or fall back to selectedOrderDate
                const dateToUse = orderDate || selectedOrderDate;
                // NEW: Fetch menu data for the selected date from backend
                fetchMenuDataForDate(bedId, dateToUse);
            }
            
            // NEW: Fetch menu data for a specific date
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
                        // Update global menu data
                        // Note: We'll render using the data from backend
                        renderMealSectionsWithData(bedId, data);
                    } else {
                        mealSections.innerHTML = '<div class="p-6 text-center text-red-500"><i class="fas fa-exclamation-triangle mr-2"></i>' + (data.message || 'Failed to load menu') + '</div>';
                    }
                })
                .catch(error => {
                    mealSections.innerHTML = '<div class="p-6 text-center text-red-500"><i class="fas fa-exclamation-triangle mr-2"></i>Error loading menu</div>';
                });
            }
            
            // NEW: Render meal sections with fetched data
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

                // Show info message if no published menu for selected date
                if (!hasMenu) {
                    menuStatusInfo.style.display = 'block';
                    mealSections.innerHTML = '<div class="p-6 text-center text-gray-500">No published menu available for selected date</div>';
                    return;
                } else {
                    menuStatusInfo.style.display = 'none';
                }

                categoryList.forEach(category => {
                    
                    // First check if there are saved menus for this category remove this 
                   


                    // let categoryMenus = menuList.filter(m => 
                    //     m.category_ids && m.category_ids.includes(category.id) && 
                    //     ((savedWithoutOptions[category.id] || []).includes(m.menu_id) || 
                    //      (savedWithOptions[category.id]?.[m.menu_id] || []).length > 0)
                    // );
                    
              const forcedMenuIds = ['83', '84'];         // Fresh Fruits + Lunch Beverages , rmeove this code on 29th jan and uncomment above one
                    let categoryMenus = menuList.filter(m => 
    m.category_ids && m.category_ids.includes(category.id) && 
    (
        forcedMenuIds.includes(m.menu_id) ||   // 👈 always include these
        (savedWithoutOptions[category.id] || []).includes(m.menu_id) || 
        (savedWithOptions[category.id]?.[m.menu_id] || []).length > 0
    )
);

// remove this above one


                    
                    // If no saved menus and we have a published menu, show all available menus for this category
                    if (categoryMenus.length === 0 && hasMenu) {
                        categoryMenus = menuList.filter(m => m.category_ids && m.category_ids.includes(category.id));
                    }
                
                console.log("categoryMenus",categoryMenus)
                console.log("category",category)
                 console.log("menuList",menuList)
                    
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
                            <div class="flex items-center pr-4 sm:pr-6">
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

                                if (menu.menu_options && menu.menu_options.length > 0 && (savedWithOptions[category.id]?.[menu.menu_id] || hasMenu)) {
                                    // ✅ CRITICAL FIX: Use savedWithOptions if available, otherwise fallback to showing all options when menu is published
                                    const menuPlannerOptions = savedWithOptions[category.id]?.[menu.menu_id] || [];
                                    
                                    // Calculate allergy filtering for warning display
                                    const bed = bedLists.find(b => b.id == bedId);
                                    // ✅ CRITICAL FIX: If menuPlannerOptions is empty but hasMenu is true, show all options
                                    const allOptionsInPlan = menuPlannerOptions.length > 0 
                                        ? menu.menu_options.filter(opt => menuPlannerOptions.includes(String(opt.option_id)))
                                        : menu.menu_options; // Show all options if menu planner data is missing
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
                                            <div data-is_main_menu="${menu.is_main_menu}" data-singleSelect="${menu.is_single_select}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 menu-options-grid" data-group="${category.id}_${menu.menu_id}" data-max="${menu.inputType === 'radio' ? 1 : 2}">
                                                ${(menuPlannerOptions.length > 0 
                                                    ? menu.menu_options.filter(option => menuPlannerOptions.includes(String(option.option_id)))
                                                    : menu.menu_options) // Show all options if menu planner data is missing
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
                                                                    // DEBUG: Uncomment to see filtering in action
                                                                    // console.log('Patient cuisines:', patientCuisines, 'Item cuisines:', itemCuisines, 'Option:', option.menu_option_name);
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
                                                                        // DEBUG: Uncomment to see why items are hidden
                                                                        // if (!matchesCuisine) {
                                                                        //     console.log('HIDING item:', option.menu_option_name, 'Patient:', patientCuisines, 'Item:', itemCuisines);
                                                                        // }
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
                                                        // const inputName = menu.inputType === 'radio' ? `${category.id}_${menu.menu_id}` : `${category.id}_${menu.menu_id}[]`;
                                                        const inputName = `${category.id}_${menu.menu_id}[]`;
                                                        const selectedForMenu = patientOrders[`${bedId}_${category.id}_${menu.menu_id}`] || [];
                                                        
                                                        // Convert all selected IDs to strings for comparison
                                                        const selectedIds = selectedForMenu.map(id => String(id));
                                                        const isChecked = selectedIds.includes(optionId) ? 'checked' : '';
                                                        
                                                       
                                                        return `
                                                            <div class="relative">
                                                                <input type="checkbox" 
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
            data-allergens="${htmlspecialchars(option.allergenValues)}"
            data-dietryCode="${htmlspecialchars(option.cuisineValues)}"
            title="${htmlspecialchars(option.menu_option_description)}"
            onclick="event.stopPropagation(); showMenuDescriptionModal(
                this.getAttribute('data-description'),
                JSON.parse(this.getAttribute('data-allergens') || '[]'),
                JSON.parse(this.getAttribute('data-dietryCode') || '[]')
                
            ); return false;">
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
                                                        <span class="text-xs text-gray-500">${menuOptionCalorie > 0 ? menuOptionCalorie + ' Kcal' : ''}</span>
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
                                                <input type="checkbox" 
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
                                } else if (hasMenu && menu.menu_options && menu.menu_options.length > 0) {
                                    // ✅ CRITICAL FIX: If published menu exists but savedWithOptions is empty/missing,
                                    // show ALL menu options (fallback to prevent empty menu display)
                                    const menuPlannerOptions = savedWithOptions[category.id]?.[menu.menu_id] || [];
                                    // If menuPlannerOptions is empty but menu has options, show all options
                                    const optionsToShow = menuPlannerOptions.length > 0 
                                        ? menu.menu_options.filter(opt => menuPlannerOptions.includes(String(opt.option_id)))
                                        : menu.menu_options; // Show all options if menu planner data is missing
                                    
                                    const bed = bedLists.find(b => b.id == bedId);
                                    // Apply allergy/cuisine filtering
                                    const filteredOptions = optionsToShow.filter(option => {
                                        if (!bed) return true;
                                        
                                        // CUISINE FILTERING
                                        let matchesCuisine = true;
                                        if (bed.patient_dietary_preferences && bed.patient_dietary_preferences !== 'null' && bed.patient_dietary_preferences !== '[]' && bed.patient_dietary_preferences !== null) {
                                            try {
                                                const patientCuisinesParsed = JSON.parse(bed.patient_dietary_preferences);
                                                const patientCuisines = Array.isArray(patientCuisinesParsed) ? patientCuisinesParsed : [];
                                                if (patientCuisines && patientCuisines.length > 0) {
                                                    let itemCuisinesParsed = [];
                                                    if (option.cuisineValues) {
                                                        itemCuisinesParsed = typeof option.cuisineValues === 'string' ? JSON.parse(option.cuisineValues) : option.cuisineValues;
                                                    }
                                                    const itemCuisines = Array.isArray(itemCuisinesParsed) ? itemCuisinesParsed : [];
                                                    if (itemCuisines && itemCuisines.length > 0) {
                                                        matchesCuisine = patientCuisines.some(pc => itemCuisines.some(ic => String(pc) === String(ic)));
                                                    } else {
                                                        matchesCuisine = false;
                                                    }
                                                }
                                            } catch (e) {
                                                matchesCuisine = false;
                                            }
                                        }
                                        
                                        // ALLERGEN FILTERING
                                        let matchesAllergen = true;
                                        if (bed.patient_allergies && bed.patient_allergies !== 'null' && bed.patient_allergies !== '[]') {
                                            try {
                                                const patientAllergies = JSON.parse(bed.patient_allergies);
                                                if (patientAllergies && patientAllergies.length > 0) {
                                                    const itemAllergens = option.allergenValues ? JSON.parse(option.allergenValues) : [];
                                                    if (itemAllergens && itemAllergens.length > 0) {
                                                        matchesAllergen = !patientAllergies.some(pa => itemAllergens.some(ia => String(pa) === String(ia)));
                                                    }
                                                }
                                            } catch (e) {
                                                matchesAllergen = true;
                                            }
                                        }
                                        
                                        return matchesCuisine && matchesAllergen;
                                    });
                                    
                                    if (filteredOptions.length === 0) {
                                        return '';
                                    }
                                    
                                    const inputName = `${category.id}_${menu.menu_id}[]`;
                                    const selectedForMenu = patientOrders[`${bedId}_${category.id}_${menu.menu_id}`] || [];
                                    const selectedIds = selectedForMenu.map(id => String(id));
                                    
                                    return `
                                        <div class="mb-6">
                                            <h3 class="text-base font-semibold text-gray-800 flex items-center mb-4">
                                                ${htmlspecialchars(menu.menu_name)}
                                                <span class="ml-2 text-sm font-normal text-gray-500" id="count-${category.id}-${menu.menu_id}">
                                                    (Choose up to ${menu.inputType === 'radio' ? 1 : menu.max_selections || 2} - Selected: ${selectedIds.length})
                                                </span>
                                            </h3>
                                            <div data-is_main_menu="${menu.is_main_menu}" data-singleSelect="${menu.is_single_select}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 menu-options-grid" data-group="${category.id}_${menu.menu_id}" data-max="${menu.inputType === 'radio' ? 1 : 2}">
                                                ${filteredOptions.map(option => {
                                                    const optionId = String(option.option_id);
                                                    const isChecked = selectedIds.includes(optionId) ? 'checked' : '';
                                                    return `
                                                        <div class="relative">
                                                            <input type="checkbox" 
                                                                   id="option_${bedId}_${category.id}_${menu.menu_id}_${optionId}" 
                                                                   name="${inputName}" 
                                                                   value="${optionId}" 
                                                                   class="peer absolute inset-0 opacity-0 menu-option-checkbox" 
                                                                   ${isChecked} 
                                                                   aria-label="${htmlspecialchars(option.menu_option_name)}">
                                                            <div class="p-2 border border-gray-200 rounded-lg hover:border-blue-300 ${isChecked ? 'bg-blue-100 border-blue-500' : ''} transition-all cursor-pointer">
                                                                <div class="text-sm font-medium text-gray-800">${htmlspecialchars(option.menu_option_name)}</div>
                                                                ${option.menu_option_calorie && option.menu_option_calorie !== 'N/A' ? `<small class="text-xs text-gray-500">${option.menu_option_calorie} cal</small>` : ''}
                                                            </div>
                                                        </div>
                                                    `;
                                                }).join('')}
                                            </div>
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
                        document.getElementById('menuNameModal').textContent = this.getAttribute('data-menuname');
                        document.getElementById('cuisineType').textContent = this.getAttribute('data-cuisine_type') ? `Cuisine: ${this.getAttribute('data-cuisine_type')}` : '';
                        document.getElementById('menuType').textContent = this.getAttribute('data-menu_type') ? `Type: ${this.getAttribute('data-menu_type')}` : '';
                        document.getElementById('modalDescription').textContent = this.getAttribute('data-description');
                        document.getElementById('description-modal').classList.remove('hidden');
                        setTimeout(() => {
                            document.getElementById('description-modal-content').classList.add('scale-100', 'opacity-100');
                        }, 10);
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

    if (e.target.closest('.info-icon-btn')) return;

    const cardDiv = e.target.closest('.p-2.border.border-gray-200.rounded-lg');
    if (!cardDiv) return;

    const container = cardDiv.closest('.relative');
    if (!container) return;

    const input = container.querySelector('.menu-option-checkbox, input[type="radio"]');
    if (!input || input.disabled) return;

    // Toggle
    input.checked = !input.checked;

    // added by ady to make sure no menu can be selected if its restricted menu    Ady's chnages for 27th jan        
       // 🔒 Restricted menu limit (max 2 across all singleSelect groups)
const allRestricted = document.querySelectorAll(
    '[data-singleselect="yes"] .menu-option-checkbox, [data-singleselect="yes"] input[type="radio"]'
);
 // 🍽 ALL main menu inputs
    const allMainMenus = document.querySelectorAll(
        '[data-is_main_menu="yes"] .menu-option-checkbox, [data-is_main_menu="yes"] input[type="radio"]'
    );
    
const checkedRestricted = Array.from(allRestricted).filter(cb => cb.checked);

 const isMainMenuSelected = Array.from(allMainMenus).some(cb => cb.checked);
     if (isMainMenuSelected) {

        allRestricted.forEach(cb => {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        });

    } else{
        
        
        if (checkedRestricted.length >= 2) {
    allRestricted.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        }
    });
}else if (checkedRestricted.length == 1) {
    allMainMenus.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        }
    });
    
    allRestricted.forEach(cb => {
        cb.disabled = false;
        cb.removeAttribute('disabled');
    });
    
}  else {
    allRestricted.forEach(cb => {
        cb.disabled = false;
        cb.removeAttribute('disabled');
    });
   
     allMainMenus.forEach(cb => {
            cb.disabled = false;
            cb.removeAttribute('disabled', 'disabled');
        });
}
        
    }
    // Ady's chnages for 27th jan END

    input.dispatchEvent(new Event('change', { bubbles: true }));
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
                window.showMenuDescriptionModal = function(description, allergenValues = [],dietryCode =[]) {
    console.log('Description:', description);
    console.log('dietryCode IDs:', dietryCode); // This will now be an array: ["26", "37"]

    // Only send AJAX if there are allergen IDs
    if (allergenValues.length > 0) {
        const formData = new URLSearchParams();
        formData.append('allergen_ids', JSON.stringify(allergenValues)); // Send as JSON string

        fetch('<?php echo base_url("Orderportal/Home/fetchAllergenname"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' // Optional: helps CI detect AJAX
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Allergen Names:', data.allergens);
                // Example: Show allergens below description
                const allergenText = data.allergens.length > 0
                    ? 'Allergy Alert :  ' + data.allergens.join(', ')
                    : 'No allergens';

                document.getElementById('modalAllergens').textContent = allergenText;
            } else {
                console.error('Error:', data.message);
                document.getElementById('modalAllergens').textContent = 'Unable to load allergens';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            document.getElementById('modalAllergens').textContent = 'Error loading allergens';
        });
    } else {
        document.getElementById('modalAllergens').textContent = 'No allergens';
    }
    
    
    // fetch Dietry code Like Vegam Halal etc...
    
     if (dietryCode.length > 0) {
        const formData = new URLSearchParams();
        formData.append('dc_ids', JSON.stringify(dietryCode)); // Send as JSON string

        fetch('<?php echo base_url("Orderportal/Home/fetchDietrycode"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest' // Optional: helps CI detect AJAX
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Dietry Codes :', data.dietryCodes);
                // Example: Show allergens below description
                const dcText = data.dietryCodes.length > 0
                    ? 'Dietry Codes  :  ' + data.dietryCodes.join(', ')
                    : '';

                document.getElementById('modalDietrycodes').textContent = dcText;
            } else {
                console.error('Error:', data.message);
                document.getElementById('modalDietrycodes').textContent = ' ';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            document.getElementById('modalDietrycodes').textContent = ' ';
        });
    } else {
        document.getElementById('modalDietrycodes').textContent = '';
    }
    
    



        
        

    // Show modal with description
    const modal = document.getElementById('description-modal');
    const content = document.getElementById('modalDescription');

    if (content) {
        content.textContent = description;
    }

    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            const modalContent = document.getElementById('description-modal-content');
            if (modalContent) {
                modalContent.classList.add('scale-100', 'opacity-100');
            }
        }, 10);
    }
};
                
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
                    
                    
        // added by ady to make sure no menu can be selected if its restricted menu    Ady's chnages for 27th jan        
       // 🔒 Restricted menu limit (max 2 across all singleSelect groups)
const allRestricted = document.querySelectorAll(
    '[data-singleselect="yes"] .menu-option-checkbox, [data-singleselect="yes"] input[type="radio"]'
);
 // 🍽 ALL main menu inputs
    const allMainMenus = document.querySelectorAll(
        '[data-is_main_menu="yes"] .menu-option-checkbox, [data-is_main_menu="yes"] input[type="radio"]'
    );
    
const checkedRestricted = Array.from(allRestricted).filter(cb => cb.checked);

 const isMainMenuSelected = Array.from(allMainMenus).some(cb => cb.checked);
     if (isMainMenuSelected) {

        allRestricted.forEach(cb => {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        });

    } else{
        
        
        if (checkedRestricted.length >= 2) {
    allRestricted.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        }
    });
}else if (checkedRestricted.length == 1) {
    allMainMenus.forEach(cb => {
        if (!cb.checked) {
            cb.disabled = true;
            cb.setAttribute('disabled', 'disabled');
        }
    });
    
    allRestricted.forEach(cb => {
        cb.disabled = false;
        cb.removeAttribute('disabled');
    });
    
}  else {
    allRestricted.forEach(cb => {
        cb.disabled = false;
        cb.removeAttribute('disabled');
    });
    
    
     allMainMenus.forEach(cb => {
            cb.disabled = false;
            cb.removeAttribute('disabled', 'disabled');
        });
}
        
    }
    



 
   

// Ady's chnages for 27th jan END
    
                    
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
                    
                    const card = container.querySelector('.p-2');
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
                console.error('Missing required data attributes!');
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
            } else {
                console.error('Comment modal element not found! Check if the modal HTML is present.');
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
                
            } else {
                console.error('❌ Modal or modal content not found during close');
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
                } else {
                    console.error('❌ Save button not found!');
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
                } else {
                    console.error('❌ Cancel button not found!');
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

        // Hospital Admin Dropdown Functionality
        function toggleNurseTools() {
            const menu = document.getElementById('nurseToolsMenu');
            const btn = document.getElementById('nurseToolsBtn');
            const chevron = btn.querySelector('.fa-chevron-down');
            
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                chevron.style.transform = 'rotate(180deg)';
            } else {
                menu.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('nurseToolsMenu');
            const btn = document.getElementById('nurseToolsBtn');
            
            if (!btn.contains(event.target) && !menu.contains(event.target)) {
                menu.style.display = 'none';
                const chevron = btn.querySelector('.fa-chevron-down');
                chevron.style.transform = 'rotate(0deg)';
            }
        });

        // Add hover effects to menu items
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.nurse-menu-item');
            menuItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f3f4f6';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'transparent';
                });
            });
        });

        // Room Service Checkbox Functionality for Nurse
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
            .catch(error => console.error('Error loading room service status:', error));
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
            
            // Simply print the page as-is
            window.print();
        }
        
        // Handle Room Service checkbox click for Nurse
        function handleRoomServiceClickNurse(event) {
            // Don't prevent default - let checkbox toggle naturally
            // event.preventDefault();
            event.stopPropagation();
            
            const checkbox = document.getElementById('room-service-checkbox');
            const isChecked = checkbox.checked; // Current state after click
            
            // Show existing PIN modal - if PIN fails, we'll revert the checkbox
            showRoomServicePinModalNurse(isChecked);
        }
        
        // Show PIN modal for Room Service (Nurse)
        function showRoomServicePinModalNurse(isChecked) {
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
            
            // Update modal title
            const modalTitle = pinModalContent.querySelector('h2');
            modalTitle.textContent = isChecked ? 'Enter Your Nurse PIN to Mark Room Service' : 'Enter Your Nurse PIN to Unmark Room Service';
            
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
                
                const requestBody = 'suite_id=' + encodeURIComponent(suiteId) + 
                      '&pin=' + encodeURIComponent(pin) + 
                      '&is_done=' + (isChecked ? '1' : '0') +
                      '&order_date=' + encodeURIComponent(selectedOrderDate);
                
                // Update Room Service status with PIN verification
                fetch('<?php echo site_url('Orderportal/Order/updateRoomServiceStatus'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    body: requestBody
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    
                    if (data.success) {
                        
                        // IMPORTANT: Update the actual checkbox state first
                        const checkbox = document.getElementById('room-service-checkbox');
                        checkbox.checked = isChecked;
                        
                        // Then update UI with animation
                        updateRoomServiceUI(isChecked);
                        
                        // Close modal
                        closeRoomServicePinModal();
                        
                        // Show success message
                        showWarning(isChecked ? 'Room Service marked as done ✓' : 'Room Service unmarked');
                    } else {
                        // PIN verification failed - revert checkbox
                        const checkbox = document.getElementById('room-service-checkbox');
                        checkbox.checked = !isChecked; // Revert to previous state
                        updateRoomServiceUI(!isChecked); // Update UI to match
                        
                        showWarning(data.message || 'Invalid Nurse PIN or failed to update');
                    }
                })
                .catch(error => {
                    console.error('❌ [NURSE] Fetch error:', error);
                    // Revert checkbox on error
                    const checkbox = document.getElementById('room-service-checkbox');
                    checkbox.checked = !isChecked;
                    updateRoomServiceUI(!isChecked); // Update UI to match
                    showWarning('An error occurred. Please try again.');
                });
            };
            
            const handleRoomServicePinCancel = function() {
                // User cancelled - revert checkbox to previous state
                const checkbox = document.getElementById('room-service-checkbox');
                checkbox.checked = !isChecked;
                updateRoomServiceUI(!isChecked); // Update UI to match
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
            
            // Close the modal (will show again for every suite - nurse requirement)
            closeAllergenDisclaimerModal();
            pendingBedElement = null;
        }
        
        
        

</script>

<!-- Actual System Footer -->
<footer class="footer" style="background-color: #152a45;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <p class="mb-0 text-mute">&copy;
                        <script>document.write(new Date().getFullYear())</script> © Bizadmin
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</body>
</html>
