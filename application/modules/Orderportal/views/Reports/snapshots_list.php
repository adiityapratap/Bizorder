<!-- Order Snapshots List - Comprehensive Historical View -->
<style>
    /* CRITICAL: Force black text for snapshot cards - MAXIMUM SPECIFICITY */
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 span,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 .counter-value,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h6,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body p,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 span,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 .counter-value,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h6,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body p {
        color: #212529 !important;
    }
    
    /* Override any white color rules */
    .card-animate .fs-22,
    .card-animate .fs-22 span,
    .card-animate .fs-22 .counter-value,
    .card-animate .fs-14,
    .card-animate .ff-secondary {
        color: #212529 !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">📸 Order Snapshots - Historical Records</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('Orderportal/Reports'); ?>">Reports</a></li>
                                <li class="breadcrumb-item active">Snapshots</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="ri-information-line me-2"></i>
                <strong>Historical Snapshots:</strong> These are permanent, immutable records of orders at the time they were placed. 
                All data shown here (patients, menus, prices) is locked and will never change, even if current data is modified or deleted.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Snapshots</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4" style="color: #212529 !important;">
                                        <span class="counter-value" data-target="<?php echo $total_snapshots; ?>" style="color: #212529 !important;">
                                            <?php echo $total_snapshots; ?>
                                        </span>
                                    </h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                        <i class="ri-file-list-3-line text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Unique Orders</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4" style="color: #212529 !important;">
                                        <span class="counter-value" data-target="<?php echo $total_orders; ?>" style="color: #212529 !important;">
                                            <?php echo $total_orders; ?>
                                        </span>
                                    </h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle rounded fs-3">
                                        <i class="ri-shopping-cart-line text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Date Range</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h6 class="fs-14 mb-0" style="color: #212529 !important;">
                                        <?php echo date('d/m/Y', strtotime($from_date)); ?><br>
                                        to<br>
                                        <?php echo date('d/m/Y', strtotime($to_date)); ?>
                                    </h6>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle rounded fs-3">
                                        <i class="ri-calendar-line text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Data Integrity</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4" style="color: #212529 !important;">
                                        <i class="ri-lock-line"></i> 100%
                                    </h4>
                                    <p class="mb-0" style="color: #212529 !important;">Immutable</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-filter-line me-2"></i>Filter Snapshots
                    </h5>
                </div>
                <div class="card-body">
                    <form method="get" action="<?php echo base_url('Orderportal/Reports/snapshots'); ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" 
                                       value="<?php echo $from_date; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" 
                                       value="<?php echo $to_date; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="floor_id" class="form-label">Floor</label>
                                <select class="form-select" id="floor_id" name="floor_id">
                                    <option value="">All Floors</option>
                                    <?php if (!empty($floors)): ?>
                                        <?php foreach ($floors as $floor): ?>
                                            <option value="<?php echo $floor['id']; ?>" 
                                                    <?php echo ($floor_id == $floor['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($floor['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ri-search-line me-1"></i> Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Snapshots Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-database-2-line me-2"></i>
                        Snapshot Records (<?php echo count($snapshots); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($snapshots)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Snapshot ID</th>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>Floor</th>
                                        <th>Created By</th>
                                        <th>Suites</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($snapshots as $snapshot): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    #<?php echo $snapshot['snapshot_id']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info">
                                                    Order #<?php echo $snapshot['order_id']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo date('d-m-Y', strtotime($snapshot['order_date'])); ?></strong>
                                            </td>
                                            <td>
                                                <i class="ri-building-line me-1"></i>
                                                <?php echo htmlspecialchars($snapshot['floor_name']); ?>
                                            </td>
                                            <td>
                                                <i class="ri-user-line me-1"></i>
                                                <?php echo htmlspecialchars($snapshot['created_by_user_name'] ?: 'System'); ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">
                                                    <?php echo $snapshot['actual_suite_count']; ?> suite(s)
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning" style="color: #212529 !important;">
                                                    <?php echo $snapshot['total_items']; ?> items
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $statusColors = [
                                                    'pending' => 'secondary',
                                                    'in_progress' => 'warning',
                                                    'completed' => 'success',
                                                    'delivered' => 'info',
                                                    'cancelled' => 'danger'
                                                ];
                                                $color = $statusColors[$snapshot['workflow_status']] ?? 'secondary';
                                                ?>
                                                <span class="badge bg-<?php echo $color; ?>">
                                                    <?php echo ucfirst($snapshot['workflow_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($snapshot['is_floor_consolidated'] == 1): ?>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        <i class="ri-building-4-line"></i> Floor
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-subtle text-secondary">
                                                        <i class="ri-home-4-line"></i> Legacy
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small style="color: #212529 !important;">
                                                    <?php echo date('d/m/Y H:i', strtotime($snapshot['created_at'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="hstack gap-2">
                                                    <a href="<?php echo base_url('Orderportal/Reports/viewOrderSnapshot/' . $snapshot['snapshot_id']); ?>" 
                                                       class="btn btn-sm btn-soft-info" title="View Complete Snapshot">
                                                        <i class="ri-eye-line"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                    <i class="ri-inbox-line"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">No Snapshots Found</h5>
                            <p class="text-muted">
                                No order snapshots found for the selected date range and filters.<br>
                                Snapshots are automatically created when orders are placed.
                            </p>
                            <p class="text-muted">
                                <strong>Note:</strong> If you haven't placed any orders yet, or if the snapshot tables haven't been created,
                                no snapshots will be available. Run <code>CREATE_ORDER_SNAPSHOT_TABLES.sql</code> to enable the system.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Information Panel -->
            <div class="card">
                <div class="card-header bg-success-subtle">
                    <h5 class="card-title text-success mb-0">
                        <i class="ri-shield-check-line me-2"></i>
                        What Data is Captured in Snapshots?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-primary"><i class="ri-file-list-3-line me-1"></i> Order Information</h6>
                            <ul class="list-unstyled text-muted">
                                <li><i class="ri-check-line text-success me-1"></i> Order date & time</li>
                                <li><i class="ri-check-line text-success me-1"></i> Floor name (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Creator name (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Order type & status</li>
                                <li><i class="ri-check-line text-success me-1"></i> Total suites & items</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-primary"><i class="ri-home-4-line me-1"></i> Suite Details</h6>
                            <ul class="list-unstyled text-muted">
                                <li><i class="ri-check-line text-success me-1"></i> Suite number (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Order comments</li>
                                <li><i class="ri-check-line text-success me-1"></i> Room service status</li>
                                <li><i class="ri-check-line text-success me-1"></i> Item counts</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-primary"><i class="ri-user-heart-line me-1"></i> Patient Information</h6>
                            <ul class="list-unstyled text-muted">
                                <li><i class="ri-check-line text-success me-1"></i> Patient name (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Allergies (locked)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Special instructions</li>
                                <li><i class="ri-check-line text-success me-1"></i> Patient photo path</li>
                                <li><i class="ri-check-line text-success me-1"></i> Onboarding date</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-primary"><i class="ri-restaurant-line me-1"></i> Menu Items</h6>
                            <ul class="list-unstyled text-muted">
                                <li><i class="ri-check-line text-success me-1"></i> Menu item names (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> Option names (permanent)</li>
                                <li><i class="ri-check-line text-success me-1"></i> <strong>PRICES 🔒 (LOCKED FOREVER)</strong></li>
                                <li><i class="ri-check-line text-success me-1"></i> Calories & allergens</li>
                                <li><i class="ri-check-line text-success me-1"></i> Quantities & notes</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="alert alert-warning mb-0">
                        <strong><i class="ri-alert-line me-1"></i> Important:</strong> 
                        Invoice snapshots are automatically created when invoices are generated (when orders are marked as delivered). 
                        They capture all financial data with locked amounts for permanent audit trails.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .card-animate {
        transition: all 0.3s ease;
    }
    .card-animate:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem;
    }
    
    /* CRITICAL: Force dark text for card values - MAXIMUM SPECIFICITY */
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 span,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 .counter-value,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body h6,
    body .main-content .container-fluid .row .col-md-3 .card.card-animate .card-body p,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 span,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h4 .counter-value,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body h6,
    body .page-content .container-fluid .row .col-md-3 .card.card-animate .card-body p {
        color: #212529 !important;
    }
    
    /* Force dark text for Created At column */
    body .main-content .container-fluid table.table tbody td small,
    body .page-content .container-fluid table.table tbody td small {
        color: #212529 !important;
    }
    
    /* Force dark text for Items column badge */
    body .main-content .container-fluid table.table tbody td .badge.bg-warning,
    body .page-content .container-fluid table.table tbody td .badge.bg-warning,
    table.table tbody td .badge.bg-warning {
        color: #212529 !important;
    }
    
    /* Override Bootstrap utility classes */
    .card-animate .fs-22,
    .card-animate .fs-22 *,
    .card-animate .fs-14,
    .card-animate .fs-14 *,
    .card-animate .ff-secondary,
    .card-animate .ff-secondary * {
        color: #212529 !important;
    }
</style>

