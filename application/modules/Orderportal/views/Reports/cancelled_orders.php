<style>
    /* Override pagination purple/indigo color to gray */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:active {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        color: #ffffff !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:not(.disabled):hover {
        background-color: #e9ecef !important;
        border-color: #dee2e6 !important;
        color: #495057 !important;
    }
    
    /* Cancelled badge styling */
    .badge-cancelled {
        background-color: #dc3545 !important;
        color: #ffffff !important;
    }
    
    .badge-discharge {
        background-color: #6c757d !important;
        color: #ffffff !important;
    }
    
    /* Table responsive styling */
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Summary card styling */
    .summary-card {
        border-radius: 8px;
        transition: transform 0.2s;
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            <i class="ri-delete-bin-line text-danger me-2"></i>
                            Cancelled Orders Report
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('Orderportal/Reports'); ?>">Reports</a></li>
                                <li class="breadcrumb-item active">Cancelled Orders</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-filter-3-line me-1"></i>
                                Filter Cancelled Orders
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('Orderportal/Reports/cancelledOrders'); ?>" method="GET">
                                <div class="row align-items-end">
                                    <!-- From Date -->
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="from_date" 
                                               value="<?php echo $from_date; ?>" 
                                               required>
                                    </div>
                                    
                                    <!-- To Date -->
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="date" 
                                               class="form-control" 
                                               name="to_date" 
                                               value="<?php echo $to_date; ?>" 
                                               required>
                                    </div>
                                    
                                    <!-- Reason Filter -->
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">Cancel Reason</label>
                                        <select class="form-select" name="reason">
                                            <option value="">All Reasons</option>
                                            <?php foreach ($cancel_reasons as $reason): ?>
                                                <option value="<?php echo htmlspecialchars($reason); ?>" 
                                                        <?php echo ($reason_filter === $reason) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($reason); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <!-- Filter Buttons -->
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="ri-filter-3-line"></i> Filter
                                        </button>
                                        <button type="button" 
                                                class="btn btn-success" 
                                                onclick="exportCancelledOrders()">
                                            <i class="ri-file-excel-line"></i> Export CSV
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Summary Cards -->
            <div class="row g-3 mb-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow summary-card" style="background: #dc3545;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ri-delete-bin-line" style="font-size: 24px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase;">
                                        Items Cancelled
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 28px; font-weight: 700;">
                                        <?php echo isset($summary['total_cancelled_items']) ? number_format($summary['total_cancelled_items']) : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow summary-card" style="background: #6c757d;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ri-file-list-3-line" style="font-size: 24px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase;">
                                        Orders Affected
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 28px; font-weight: 700;">
                                        <?php echo isset($summary['affected_orders']) ? number_format($summary['affected_orders']) : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow summary-card" style="background: #0d6efd;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ri-hotel-bed-line" style="font-size: 24px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase;">
                                        Suites Affected
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 28px; font-weight: 700;">
                                        <?php echo isset($summary['affected_suites']) ? number_format($summary['affected_suites']) : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow summary-card" style="background: #ffc107;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="ri-user-heart-line" style="font-size: 24px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(0,0,0,0.7); font-size: 12px; font-weight: 500; text-transform: uppercase;">
                                        Patients Affected
                                    </p>
                                    <h3 class="mb-0" style="color: #212529; font-size: 28px; font-weight: 700;">
                                        <?php echo isset($summary['affected_patients']) ? number_format($summary['affected_patients']) : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cancelled Orders Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="ri-list-check text-danger me-1"></i>
                                    Cancelled Order Items
                                </h5>
                                <span class="badge bg-secondary">
                                    <?php echo count($cancelled_items); ?> items
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($cancelled_items)): ?>
                                <div class="text-center py-5">
                                    <i class="ri-checkbox-circle-line text-success" style="font-size: 48px;"></i>
                                    <h5 class="mt-3">No Cancelled Orders</h5>
                                    <p class="text-muted">No order items were cancelled in the selected date range.</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table id="cancelledOrdersTable" class="table table-bordered table-striped table-hover nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Cancelled At</th>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Suite</th>
                                                <th>Floor</th>
                                                <th>Patient (Snapshot)</th>
                                                <th>Category</th>
                                                <th>Menu Item</th>
                                                <th>Option</th>
                                                <th>Qty</th>
                                                <th>Reason</th>
                                                <th>Cancelled By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cancelled_items as $item): ?>
                                                <tr>
                                                    <td>
                                                        <?php if (!empty($item['cancelled_at'])): ?>
                                                            <span class="text-danger">
                                                                <?php echo date('d M Y', strtotime($item['cancelled_at'])); ?>
                                                            </span>
                                                            <br>
                                                            <small class="text-muted">
                                                                <?php echo date('H:i', strtotime($item['cancelled_at'])); ?>
                                                            </small>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url('Orderportal/Reports/viewOrderDetail/' . $item['order_id']); ?>" 
                                                           class="fw-medium text-primary">
                                                            #<?php echo $item['order_id']; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php echo !empty($item['order_date']) ? date('d M Y', strtotime($item['order_date'])) : 'N/A'; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            <?php echo htmlspecialchars($item['suite_name_snapshot'] ?: $item['suite_number'] ?: 'N/A'); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($item['floor_name'] ?: 'N/A'); ?></td>
                                                    <td>
                                                        <?php if (!empty($item['patient_name_snapshot'])): ?>
                                                            <i class="ri-user-line text-muted me-1"></i>
                                                            <?php echo htmlspecialchars($item['patient_name_snapshot']); ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            <?php echo htmlspecialchars($item['category_name'] ?: 'N/A'); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($item['menu_name'] ?: 'N/A'); ?></td>
                                                    <td><?php echo htmlspecialchars($item['menu_option_name'] ?: 'N/A'); ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-danger"><?php echo $item['quantity']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($item['cancel_reason'])): ?>
                                                            <span class="badge badge-discharge" title="<?php echo htmlspecialchars($item['cancel_reason']); ?>">
                                                                <?php 
                                                                    $reason = $item['cancel_reason'];
                                                                    echo strlen($reason) > 30 ? htmlspecialchars(substr($reason, 0, 30)) . '...' : htmlspecialchars($reason);
                                                                ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlspecialchars($item['cancelled_by_name'] ?: 'System'); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Info Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title text-info">
                                <i class="ri-information-line me-1"></i>
                                About Cancelled Orders
                            </h5>
                            <p class="card-text mb-2">
                                Order items are automatically cancelled when a patient is discharged from a suite. The cancellation follows these rules:
                            </p>
                            <ul class="mb-0">
                                <li><strong>Before 11:00 AM:</strong> Lunch and Dinner for that day are cancelled</li>
                                <li><strong>Before 2:00 PM (but after 11am):</strong> Only Dinner for that day is cancelled</li>
                                <li><strong>After 2:00 PM:</strong> No same-day cancellation (meals already served)</li>
                                <li><strong>Future orders:</strong> All orders for dates after discharge are always cancelled</li>
                                <li>Patient name and suite information are preserved as snapshots for audit purposes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Export Form (hidden) -->
<form id="exportForm" action="<?php echo base_url('Orderportal/Reports/exportCancelledOrders'); ?>" method="POST" style="display: none;">
    <input type="hidden" name="from_date" value="<?php echo $from_date; ?>">
    <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
    <input type="hidden" name="reason" value="<?php echo htmlspecialchars($reason_filter); ?>">
</form>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        if ($('#cancelledOrdersTable').length && $('#cancelledOrdersTable tbody tr').length > 0) {
            $('#cancelledOrdersTable').DataTable({
                ordering: true,
                order: [[0, 'desc']], // Sort by cancelled date descending
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                responsive: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ cancelled items",
                    infoEmpty: "No cancelled items found",
                    infoFiltered: "(filtered from _MAX_ total items)"
                }
            });
        }
    });
    
    // Export cancelled orders
    function exportCancelledOrders() {
        document.getElementById('exportForm').submit();
    }
</script>
