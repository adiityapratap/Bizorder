<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Order Detail Report #<?php echo $order['order_id']; ?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('Reports'); ?>">Reports</a></li>
                                <li class="breadcrumb-item active">Order #<?php echo $order['order_id']; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Information -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Order Information</h5>
                        </div>
                        <div class="card-body" style="background: #f8f9fa;">
                            <div class="row g-3">
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-hashtag me-1"></i>Order ID
                                        </p>
                                        <h4 class="text-primary mb-0"><strong>#<?php echo $order['order_id']; ?></strong></h4>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-calendar-line me-1"></i>Order Date
                                        </p>
                                        <h5 class="mb-0 text-dark"><?php echo date('d M Y', strtotime($order['date'])); ?></h5>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-file-list-line me-1"></i>Order Type
                                        </p>
                                        <h6 class="mb-0">
                                            <?php if ($order['is_floor_consolidated'] == 1): ?>
                                                <span class="badge bg-info text-white fs-6 px-3 py-2">Floor Consolidated</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-white fs-6 px-3 py-2">Single Order</span>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-checkbox-circle-line me-1"></i>Status
                                        </p>
                                        <h6 class="mb-0">
                                            <?php if (!empty($order['workflow_status'])): ?>
                                                <span class="badge bg-primary text-white fs-6 px-3 py-2">
                                                    <?php echo ucfirst(str_replace('_', ' ', $order['workflow_status'])); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary text-white fs-6 px-3 py-2">
                                                    Status <?php echo $order['status']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-send-plane-line me-1"></i>Button Type
                                        </p>
                                        <h6 class="mb-0">
                                            <?php if ($order['buttonType'] == 'sendorder'): ?>
                                                <span class="badge bg-success text-white fs-6 px-3 py-2">Send Order</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">Save Draft</span>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-user-line me-1"></i>Created By
                                        </p>
                                        <h6 class="mb-0 text-dark">
                                            <?php if (!empty($order['created_by_name'])): ?>
                                                <strong><?php echo $order['created_by_name']; ?></strong>
                                            <?php elseif (!empty($order['created_by_username'])): ?>
                                                <strong><?php echo $order['created_by_username']; ?></strong>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                    <div class="p-3 bg-white rounded shadow-sm h-100">
                                        <p class="text-dark mb-2 fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">
                                            <i class="ri-shopping-cart-line me-1"></i>Total Items
                                        </p>
                                        <h6 class="mb-0">
                                            <span class="badge bg-dark text-white fs-6 px-3 py-2"><?php echo count($order_items); ?> items</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Order Items</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($order_items)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 20%;">Patient / Suite</th>
                                                <th style="width: 15%;">Floor / Bed</th>
                                                <th style="width: 25%;">Menu Item</th>
                                                <th style="width: 8%;">Qty</th>
                                                <th style="width: 27%;">Special Instructions / Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $itemNumber = 0;
                                            foreach ($order_items as $item): 
                                                $itemNumber++;
                                            ?>
                                                <tr>
                                                    <td class="fw-bold"><?php echo $itemNumber; ?></td>
                                                    <td>
                                                        <?php if (!empty($item['patient_name'])): ?>
                                                            <i class="ri-user-line text-primary me-1"></i>
                                                            <strong><?php echo htmlspecialchars($item['patient_name']); ?></strong>
                                                        <?php elseif (!empty($item['bed_no'])): ?>
                                                            <span class="text-muted fst-italic">Suite: <?php echo htmlspecialchars($item['bed_no']); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted fst-italic">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($item['floor']) || !empty($item['bed_no'])): ?>
                                                            <span class="badge bg-info-subtle text-info">
                                                                <i class="ri-hotel-bed-line me-1"></i>
                                                                Floor <?php echo $item['floor'] ?: '-'; ?> / <?php echo $item['bed_no'] ?: '-'; ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($item['menu_name'])): ?>
                                                            <strong style="color: #000 !important;"><?php echo htmlspecialchars($item['menu_name']); ?></strong>
                                                            <?php if (!empty($item['menu_description'])): ?>
                                                                <br><small style="color: #333 !important; background: transparent !important;"><?php echo htmlspecialchars($item['menu_description']); ?></small>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Menu ID: #<?php echo $item['menu_id']; ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success fs-6">
                                                            <?php echo $item['qty'] ?: 1; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($item['special_instructions'])): ?>
                                                            <small class="text-dark"><?php echo nl2br(htmlspecialchars($item['special_instructions'])); ?></small>
                                                        <?php elseif (!empty($item['description'])): ?>
                                                            <small class="text-muted fst-italic"><?php echo htmlspecialchars($item['description']); ?></small>
                                                        <?php else: ?>
                                                            <small class="text-muted">-</small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="4" class="text-end fw-bold">Total Items:</td>
                                                <td class="text-center">
                                                    <span class="badge bg-dark fs-6">
                                                        <?php 
                                                            $totalQty = 0;
                                                            foreach ($order_items as $item) {
                                                                $totalQty += ($item['qty'] ?: 1);
                                                            }
                                                            echo $totalQty;
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="fw-bold">
                                                    <?php echo count($order_items); ?> line items
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center mb-0">
                                    <i class="ri-alert-line me-2 fs-4"></i>
                                    <strong>No items found for this order.</strong>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <a href="<?php echo base_url('Reports'); ?>" class="btn btn-secondary btn-lg">
                                <i class="ri-arrow-left-line me-1"></i> Back to Reports
                            </a>
                            <button onclick="window.print()" class="btn btn-primary btn-lg">
                                <i class="ri-printer-line me-1"></i> Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

