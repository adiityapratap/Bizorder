<style>
    /* Fix View button icon alignment */
    .btn i.ri-eye-line,
    .btn-soft-primary i,
    .btn .ri-eye-line {
        vertical-align: middle !important;
        margin-top: -3px !important;
        display: inline-block !important;
    }
    
    /* Override pagination purple/indigo color to gray */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:active,
    .dataTables_wrapper .dataTables_paginate span .current,
    .pagination .page-item.active .page-link,
    .page-item.active .page-link {
        background-color: #6c757d !important;
        background: #6c757d !important;
        border-color: #6c757d !important;
        color: #ffffff !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:not(.disabled):hover {
        background-color: #e9ecef !important;
        background: #e9ecef !important;
        border-color: #dee2e6 !important;
        color: #495057 !important;
    }
    
    /* Ensure badge text is always visible */
    .badge.bg-primary,
    .badge.bg-success {
        color: #ffffff !important;
    }
    
    .badge.bg-primary {
        background-color: #0d6efd !important;
    }
    
    .badge.bg-success {
        background-color: #198754 !important;
    }
    
    /* Ensure table cell text is visible */
    .table td,
    .table th {
        color: #212529 !important;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order Reports</h4>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filter Orders</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('Orderportal/Reports/index'); ?>" method="POST">
                                <div class="row">
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
                                    
                                    <!-- Filter Button -->
                                    <div class="col-md-3 col-sm-6 mb-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="ri-filter-3-line"></i> Filter
                                        </button>
                                        <button type="button" 
                                                class="btn btn-success me-2" 
                                                onclick="exportOrders()">
                                            <i class="ri-file-excel-line"></i> Export Orders
                                        </button>
                                        <button type="button" 
                                                class="btn btn-info" 
                                                onclick="exportBedsServiced()">
                                            <i class="ri-file-excel-line"></i> Export Beds
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
                    <div class="card border-0 shadow" style="background: #5156be; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-receipt" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Total Orders
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1;">
                                        <?php echo isset($total_orders) ? $total_orders : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow" style="background: #3577f1; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-food-menu" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Total Items
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1;">
                                        <?php echo isset($total_items) ? $total_items : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow" style="background: #0ab39c; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-calendar" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Date Range
                                    </p>
                                    <h6 class="mb-0" style="color: #ffffff; font-size: 14px; font-weight: 600; line-height: 1.3;">
                                        <?php echo date('d M', strtotime($from_date)) . ' - ' . date('d M', strtotime($to_date)); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow" style="background: #f7b84b; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-line-chart" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Avg Items
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1;">
                                        <?php 
                                            $avg = $total_orders > 0 ? round($total_items / $total_orders, 1) : 0;
                                            echo $avg;
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow" style="background: #e74c3c; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-home" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Beds This Month
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1;">
                                        <?php echo isset($total_beds_month) ? number_format($total_beds_month) : 0; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card border-0 shadow" style="background: #9b59b6; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle" style="background: rgba(255,255,255,0.25); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bx bx-bed" style="font-size: 26px; color: #ffffff;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1" style="color: rgba(255,255,255,0.85); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Total Beds (Range)
                                    </p>
                                    <h3 class="mb-0" style="color: #ffffff; font-size: 32px; font-weight: 700; line-height: 1;">
                                        <?php 
                                            $total_beds_range = 0;
                                            if (!empty($beds_per_day)) {
                                                foreach ($beds_per_day as $day) {
                                                    $total_beds_range += (int)$day['beds_count'];
                                                }
                                            }
                                            echo number_format($total_beds_range);
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Beds Serviced Per Day Section -->
            <?php if (!empty($beds_per_day)): ?>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card" id="beds-serviced-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Beds (Suites) Serviced Per Day</h5>
                            <button type="button" class="btn btn-sm btn-primary" onclick="printBedsServicedCard()">
                                <i class="ri-printer-line me-1"></i> Print
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50%; color: #212529; font-weight: 600;">Date</th>
                                            <th style="width: 50%; color: #212529; font-weight: 600;">Beds Serviced</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_beds_all_days = 0;
                                        foreach ($beds_per_day as $day): 
                                            $total_beds_all_days += $day['beds_count'];
                                        ?>
                                            <tr>
                                                <td style="color: #212529;">
                                                    <strong style="color: #212529;"><?php echo date('d M Y', strtotime($day['order_date'])); ?></strong>
                                                    <span class="text-muted" style="color: #6c757d !important;">(<?php echo date('l', strtotime($day['order_date'])); ?>)</span>
                                                </td>
                                                <td style="color: #212529;">
                                                    <span class="badge bg-primary" style="font-size: 14px; padding: 6px 12px; color: #ffffff !important; background-color: #0d6efd !important; border: none;">
                                                        <?php echo $day['beds_count']; ?> <?php echo $day['beds_count'] == 1 ? 'bed' : 'beds'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th style="color: #212529; font-weight: 600;">Total</th>
                                            <th style="color: #212529; font-weight: 600;">
                                                <span class="badge bg-success" style="font-size: 14px; padding: 6px 12px; color: #ffffff !important; background-color: #198754 !important; border: none;">
                                                    <?php echo number_format($total_beds_all_days); ?> beds across <?php echo count($beds_per_day); ?> <?php echo count($beds_per_day) == 1 ? 'day' : 'days'; ?>
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <script>
            function printBedsServicedCard() {
                // Get the table element only (not the card header)
                const card = document.getElementById('beds-serviced-card');
                if (!card) {
                    alert('Card not found');
                    return;
                }
                
                // Get only the table from the card body
                const table = card.querySelector('table');
                if (!table) {
                    alert('Table not found');
                    return;
                }
                
                // Create a new window for printing
                const printWindow = window.open('', '_blank');
                
                // Get the table HTML only
                const tableHTML = table.outerHTML;
                
                // Create the print document with only the table
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Beds (Suites) Serviced Per Day</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                                padding: 0;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin: 0;
                            }
                            th, td {
                                padding: 0.75rem;
                                text-align: left;
                                border: 1px solid #dee2e6;
                            }
                            thead th {
                                background-color: #f8f9fa;
                                font-weight: 600;
                                color: #212529;
                            }
                            tbody tr:nth-child(even) {
                                background-color: #f8f9fa;
                            }
                            tfoot th {
                                background-color: #f8f9fa;
                                font-weight: 600;
                                color: #212529;
                            }
                            .badge {
                                display: inline-block;
                                padding: 0.375rem 0.75rem;
                                font-size: 0.875rem;
                                font-weight: 600;
                                border-radius: 0.375rem;
                            }
                            .bg-primary {
                                background-color: #0d6efd !important;
                                color: #ffffff !important;
                            }
                            .bg-success {
                                background-color: #198754 !important;
                                color: #ffffff !important;
                            }
                            @media print {
                                body {
                                    margin: 0;
                                    padding: 10px;
                                }
                                @page {
                                    margin: 1cm;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        ${tableHTML}
                    </body>
                    </html>
                `);
                
                printWindow.document.close();
                
                // Wait for content to load, then print
                printWindow.onload = function() {
                    setTimeout(function() {
                        printWindow.print();
                    }, 250);
                };
            }
            </script>
            
            <!-- Orders Table -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Orders List</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($orders)): ?>
                                <div class="table-responsive">
                                    <table id="ordersTable" class="table table-bordered dt-responsive nowrap align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="color: #212529; font-weight: 600;">Order ID</th>
                                                <th style="color: #212529; font-weight: 600;">Date</th>
                                                <th style="color: #212529; font-weight: 600;">Type</th>
                                                <th style="color: #212529; font-weight: 600;">Status</th>
                                                <th style="color: #212529; font-weight: 600;">Items</th>
                                                <th style="color: #212529; font-weight: 600;">Created By</th>
                                                <th style="color: #212529; font-weight: 600;">Created At</th>
                                                <th style="color: #212529; font-weight: 600;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td style="color: #212529;"><strong style="color: #212529;">#<?php echo $order['order_id']; ?></strong></td>
                                                    <td style="color: #212529;"><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                                    <td style="color: #212529;">
                                                        <?php if ($order['is_floor_consolidated'] == 1): ?>
                                                            <span class="badge bg-info-subtle text-info" style="color: #0dcaf0 !important;">Floor Order</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary-subtle text-secondary" style="color: #6c757d !important;">Legacy</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="color: #212529;">
                                                        <?php if ($order['workflow_status']): ?>
                                                            <span class="badge bg-primary-subtle text-primary" style="color: #0d6efd !important;">
                                                                <?php echo ucfirst(str_replace('_', ' ', $order['workflow_status'])); ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary-subtle text-secondary" style="color: #6c757d !important;">
                                                                Status <?php echo $order['status']; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="color: #212529;"><?php echo $order['item_count']; ?> items</td>
                                                    <td style="color: #212529;"><?php echo $order['created_by_name'] ?: $order['created_by_username']; ?></td>
                                                    <td style="color: #212529;"><?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></td>
                                                    <td style="color: #212529;">
                                                        <a href="<?php echo base_url('Orderportal/Reports/orderDetail/' . $order['order_id']); ?>" 
                                                           class="btn btn-sm btn-soft-primary" style="color: #0d6efd !important;">
                                                            <i class="ri-eye-line"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info text-center" style="color: #0c5460 !important;">
                                    <i class="ri-information-line me-2"></i>
                                    <span style="color: #0c5460 !important;">No orders found for the selected date range.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable with basic configuration (no buttons extension needed)
    if ($.fn.DataTable && $('#ordersTable').length) {
        $('#ordersTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            responsive: true,
            language: {
                search: "Search orders:",
                lengthMenu: "Show _MENU_ orders per page",
                info: "Showing _START_ to _END_ of _TOTAL_ orders",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    }
    
    // Add custom export buttons manually
    if ($('#ordersTable').length) {
        $('.dt-buttons').remove(); // Remove if exists
        const buttonHtml = `
            <div class="d-flex gap-2 mb-3">
                <button onclick="exportTableToExcel()" class="btn btn-sm btn-success">
                    <i class="ri-file-excel-line"></i> Excel
                </button>
                <button onclick="window.print()" class="btn btn-sm btn-info">
                    <i class="ri-printer-line"></i> Print
                </button>
            </div>
        `;
        $('#ordersTable').closest('.card-body').prepend(buttonHtml);
    }
});

function exportTableToExcel() {
    const fromDate = document.querySelector('input[name="from_date"]').value;
    const toDate = document.querySelector('input[name="to_date"]').value;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo base_url('Orderportal/Reports/exportOrders'); ?>';
    
    const fromInput = document.createElement('input');
    fromInput.type = 'hidden';
    fromInput.name = 'from_date';
    fromInput.value = fromDate;
    form.appendChild(fromInput);
    
    const toInput = document.createElement('input');
    toInput.type = 'hidden';
    toInput.name = 'to_date';
    toInput.value = toDate;
    form.appendChild(toInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function exportOrders() {
    exportTableToExcel();
}

function exportBedsServiced() {
    const fromDate = document.querySelector('input[name="from_date"]').value;
    const toDate = document.querySelector('input[name="to_date"]').value;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo base_url('Orderportal/Reports/exportBedsServiced'); ?>';
    
    const fromInput = document.createElement('input');
    fromInput.type = 'hidden';
    fromInput.name = 'from_date';
    fromInput.value = fromDate;
    form.appendChild(fromInput);
    
    const toInput = document.createElement('input');
    toInput.type = 'hidden';
    toInput.name = 'to_date';
    toInput.value = toDate;
    form.appendChild(toInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

// Add custom styles for report cards
const style = document.createElement('style');
style.textContent = `
    /* Compact card hover effect */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Fix icon alignment in View button */
    .btn i.ri-eye-line,
    .btn-soft-primary i {
        vertical-align: middle !important;
        margin-top: -3px !important;
        display: inline-block !important;
    }
    
    /* Change pagination active button from purple to gray */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
    .dataTables_wrapper .dataTables_paginate span .current,
    .pagination .active .page-link,
    .page-item.active .page-link {
        background-color: #6c757d !important;
        background: #6c757d !important;
        border-color: #6c757d !important;
        color: white !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #e9ecef !important;
        background: #e9ecef !important;
        border-color: #dee2e6 !important;
        color: #495057 !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 4px !important;
    }
    
    /* Print styles */
    @media print {
        .btn, .breadcrumb, .card:not(.card:has(#ordersTable)) {
            display: none !important;
        }
        .card {
            border: none;
            box-shadow: none;
        }
        #ordersTable {
            font-size: 12px;
        }
    }
`;
document.head.appendChild(style);
</script>

