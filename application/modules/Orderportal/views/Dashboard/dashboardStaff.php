<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal - BizOrder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Logout Button (Top Right) -->
    <a href="<?php echo base_url('auth/logout'); ?>" class="logout-btn inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
        <i class="fas fa-sign-out-alt mr-2"></i>
        Logout
    </a>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-5xl w-full">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-6 shadow-lg">
                    <i class="fas fa-user-tie text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl font-bold text-gray-900 mb-3">Staff Portal</h1>
                <p class="text-xl text-gray-600">Production Management & Labels</p>
            </div>

            <!-- Main Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Production Form Card -->
                <a href="<?php echo base_url('Orderportal/Order/viewProductionForm'); ?>" class="card-hover bg-white rounded-2xl p-10 shadow-lg border-2 border-transparent hover:border-blue-500 group">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-xl transition-shadow">
                            <i class="fas fa-clipboard-list text-white text-4xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Production Form</h2>
                        <p class="text-gray-600 mb-6">Manage daily production orders and track completion status</p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            <span class="mr-2">Open Form</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </div>
                    </div>
                </a>

                <!-- Today's Labels Card - Shows all floors -->
                <div class="bg-white rounded-2xl p-10 shadow-lg">
                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <i class="fas fa-tags text-white text-4xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Today's Labels</h2>
                        <p class="text-gray-600 mb-6">Select a floor to view and print delivery labels</p>
                    </div>
                    
                    <!-- Floor Selection -->
                    <div class="space-y-3">
                        <?php if (!empty($departmentListData)): ?>
                            <?php foreach ($departmentListData as $department): ?>
                                <a href="javascript:void(0);" 
                                   onclick="checkFloorOrders(<?php echo $department['id']; ?>, '<?php echo htmlspecialchars($department['name'], ENT_QUOTES); ?>')"
                                   class="block w-full bg-gradient-to-r from-green-50 to-green-100 hover:from-green-500 hover:to-green-600 text-gray-800 hover:text-white px-6 py-4 rounded-xl font-semibold transition-all duration-300 group border-2 border-green-200 hover:border-green-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-building text-green-600 group-hover:text-white text-xl"></i>
                                            <span class="text-lg"><?php echo htmlspecialchars($department['name']); ?></span>
                                        </div>
                                        <i class="fas fa-arrow-right text-green-600 group-hover:text-white group-hover:translate-x-2 transition-transform"></i>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-4">No floors available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Info Bar -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-day text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Today's Date</p>
                            <p class="text-xl font-bold text-gray-900"><?php $this->load->helper('custom'); echo australia_date('d M Y'); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Current Time</p>
                            <p class="text-xl font-bold text-gray-900" id="current-time"><?php echo australia_date('H:i'); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Access Status</p>
                            <p class="text-xl font-bold text-green-600">Active</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update time every second
        function updateTime() {
            // CRITICAL FIX: Use Australia/Sydney timezone for accurate time display
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Australia/Sydney',
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            });
            const parts = formatter.formatToParts(now);
            const hours = parts.find(part => part.type === 'hour').value.padStart(2, '0');
            const minutes = parts.find(part => part.type === 'minute').value.padStart(2, '0');
            document.getElementById('current-time').textContent = hours + ':' + minutes;
        }
        
        setInterval(updateTime, 1000);
        updateTime();
        
        // Check if floor has orders before navigating
        function checkFloorOrders(floorId, floorName) {
            // Show loading
            showLoadingModal();
            
            // Make AJAX call to check if orders exist for this floor
            fetch('<?php echo base_url("Orderportal/Order/checkFloorHasOrders"); ?>/' + floorId)
                .then(response => response.json())
                .then(data => {
                    hideLoadingModal();
                    
                    if (data.hasOrders) {
                        // Redirect to delivery page
                        window.location.href = '<?php echo base_url("Orderportal/Order/viewOrderPatientwise/delivery/"); ?>' + floorId;
                    } else {
                        // Show friendly message
                        showNoOrdersModal(floorName);
                    }
                })
                .catch(error => {
                    hideLoadingModal();
                    console.error('Error:', error);
                    // If error, still redirect (fallback to old behavior)
                    window.location.href = '<?php echo base_url("Orderportal/Order/viewOrderPatientwise/delivery/"); ?>' + floorId;
                });
        }
        
        function showLoadingModal() {
            const modal = document.createElement('div');
            modal.id = 'loading-modal';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center;">
                    <div style="background: white; padding: 30px; border-radius: 16px; text-align: center;">
                        <i class="fas fa-spinner fa-spin text-5xl text-blue-500 mb-4"></i>
                        <p style="font-size: 18px; font-weight: 600; color: #374151;">Checking orders...</p>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function hideLoadingModal() {
            const modal = document.getElementById('loading-modal');
            if (modal) {
                modal.remove();
            }
        }
        
        function showNoOrdersModal(floorName) {
            const modal = document.createElement('div');
            modal.id = 'no-orders-modal';
            modal.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10000; display: flex; align-items: center; justify-content: center;" onclick="this.remove()">
                    <div style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3);" onclick="event.stopPropagation()">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-info-circle" style="font-size: 40px; color: #D97706;"></i>
                        </div>
                        <h2 style="font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 16px;">No Orders Available</h2>
                        <p style="font-size: 16px; color: #6B7280; margin-bottom: 24px; line-height: 1.6;">
                            There are no orders for <strong>${floorName}</strong> today (${getTodayDate()}).<br>
                            Orders must be placed before labels can be printed.
                        </p>
                        <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px; text-align: left;">
                            <p style="font-size: 14px; color: #92400E; margin: 0; font-weight: 500;">
                                <i class="fas fa-lightbulb" style="margin-right: 8px;"></i>
                                <strong>What to do next:</strong>
                            </p>
                            <ul style="font-size: 14px; color: #92400E; margin: 8px 0 0 24px; padding-left: 0;">
                                <li>Ensure orders have been placed for today</li>
                                <li>Check if the menu planner is published</li>
                                <li>Try again once orders are submitted</li>
                            </ul>
                        </div>
                        <button onclick="document.getElementById('no-orders-modal').remove()" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none; padding: 12px 32px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                            Got It
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function getTodayDate() {
            // CRITICAL FIX: Use Australia/Sydney timezone for accurate date display
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-AU', {
                timeZone: 'Australia/Sydney',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            return formatter.format(now);
        }
        
        function getTomorrowDate() {
            // CRITICAL FIX: Use Australia/Sydney timezone for accurate date display
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
            
            const formatter = new Intl.DateTimeFormat('en-AU', {
                timeZone: 'Australia/Sydney',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            return formatter.format(tomorrowDate);
        }
    </script>
</body>
</html>

