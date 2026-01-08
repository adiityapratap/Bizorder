<!-- Order Snapshot View - Historical Order Display -->
<?php 
// Initialize allergenMap if not set
if (!isset($allergenMap)) {
    $allergenMap = [];
}
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-between">
                        <h4 class="mb-sm-0">📸 Historical Order Snapshot</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('Orderportal/Reports'); ?>">Reports</a></li>
                                <li class="breadcrumb-item active">Order Snapshot</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Box -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="ri-information-line me-2"></i>
                <strong>Historical Snapshot:</strong> This is a permanent record of the order as it was at the time of placement. 
                Changes to menus, patients, or suites do not affect this historical data.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Order Header Card -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0" style="color: #212529 !important;">
                        <i class="ri-file-list-3-line me-2"></i>
                        Order Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Snapshot ID:</strong><br><?php echo $snapshot['id']; ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Order ID:</strong><br><?php echo $snapshot['order_id']; ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Order Date:</strong><br><?php echo date('d-m-Y', strtotime($snapshot['order_date'])); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Status:</strong><br>
                                <span class="badge bg-success"><?php echo ucfirst($snapshot['workflow_status'] ?? 'completed'); ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <p><strong>Floor:</strong><br><?php echo htmlspecialchars($snapshot['floor_name']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Created By:</strong><br><?php echo htmlspecialchars($snapshot['created_by_user_name']); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Total Suites:</strong><br><?php echo $snapshot['total_suites']; ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Total Items:</strong><br><?php echo $snapshot['total_items']; ?></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Snapshot Created:</strong> <?php echo date('d-m-Y H:i:s', strtotime($snapshot['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suites and Menu Items -->
            <?php if (!empty($snapshot['suites'])): ?>
                <?php foreach ($snapshot['suites'] as $suite): ?>
                    <?php 
                    // Debug: Check items structure
                    $itemsCount = isset($suite['items']) && is_array($suite['items']) ? count($suite['items']) : 0;
                    ?>
                    <div class="card mt-3">
                        <div class="card-header" style="background-color: #f8f9fa;">
                            <h5 class="card-title mb-0">
                                <i class="ri-home-4-line me-2"></i>
                                Suite <?php echo htmlspecialchars($suite['suite_number']); ?>
                                <small class="text-muted">(<?php echo htmlspecialchars($suite['floor_name']); ?>)</small>
                                <?php if ($itemsCount > 0): ?>
                                    <span class="badge bg-success ms-2"><?php echo $itemsCount; ?> items loaded</span>
                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Patient Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6><i class="ri-user-line me-2"></i>Patient Information</h6>
                                    <?php if ($suite['patient_name']): ?>
                                        <p><strong>Name:</strong> <?php echo htmlspecialchars($suite['patient_name']); ?></p>
                                        
                                        <?php if ($suite['patient_allergies']): ?>
                                            <?php 
                                            $allergies = json_decode($suite['patient_allergies'], true);
                                            if (!is_array($allergies)) {
                                                $allergies = explode(',', $suite['patient_allergies']);
                                            }
                                            
                                            // Convert allergy IDs to names
                                            $allergyNames = [];
                                            if (!empty($allergenMap)) {
                                                foreach ($allergies as $allergyId) {
                                                    $allergyId = trim($allergyId);
                                                    if (isset($allergenMap[$allergyId])) {
                                                        $allergyNames[] = $allergenMap[$allergyId];
                                                    } else {
                                                        // If ID not found, show ID as fallback
                                                        $allergyNames[] = 'ID: ' . $allergyId;
                                                    }
                                                }
                                            } else {
                                                // Fallback if allergenMap not available
                                                $allergyNames = $allergies;
                                            }
                                            ?>
                                            <p>
                                                <strong>Allergies:</strong><br>
                                                <?php if (!empty($allergyNames)): ?>
                                                    <?php foreach ($allergyNames as $allergyName): ?>
                                                        <span class="badge bg-warning text-dark me-1 mb-1" style="color: #212529 !important;">
                                                            <i class="ri-alert-line"></i> 
                                                            <?php echo htmlspecialchars($allergyName); ?>
                                                        </span>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">None</span>
                                                <?php endif; ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if ($suite['patient_special_instructions']): ?>
                                            <p><strong>Special Instructions:</strong><br>
                                                <span class="text-info"><?php echo nl2br(htmlspecialchars($suite['patient_special_instructions'])); ?></span>
                                            </p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No patient assigned at time of order</p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6><i class="ri-file-list-2-line me-2"></i>Order Details</h6>
                                    <p><strong>Total Items:</strong> <?php echo $suite['total_items']; ?></p>
                                    
                                    <?php 
                                    // Calculate items per category
                                    $categoryTotals = [];
                                    if (!empty($suite['items'])) {
                                        foreach ($suite['items'] as $item) {
                                            $catName = $item['category_name'] ?? 'Uncategorized';
                                            if (!isset($categoryTotals[$catName])) {
                                                $categoryTotals[$catName] = 0;
                                            }
                                            $categoryTotals[$catName] += $item['quantity'];
                                        }
                                    }
                                    ?>
                                    
                                    <?php if (!empty($categoryTotals)): ?>
                                        <p><strong>Items by Category:</strong><br>
                                            <?php foreach ($categoryTotals as $catName => $count): ?>
                                                <span class="badge bg-primary text-white me-1 mb-1" style="color: #ffffff !important;">
                                                    <?php echo htmlspecialchars($catName); ?>: <?php echo $count; ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <p><strong>Status:</strong> <span class="badge bg-info"><?php echo ucfirst($suite['status']); ?></span></p>
                                    
                                    <?php if ($suite['order_comment']): ?>
                                        <p><strong>Notes:</strong><br>
                                            <span class="text-muted"><?php echo nl2br(htmlspecialchars($suite['order_comment'])); ?></span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <?php 
                            // Check if items exist and are properly structured
                            $hasItems = false;
                            $itemsArray = [];
                            
                            if (isset($suite['items']) && is_array($suite['items'])) {
                                $itemsArray = $suite['items'];
                                $hasItems = count($itemsArray) > 0;
                            }
                            
                            // If total_items > 0 but items array is empty, try to fetch directly
                            if (!$hasItems && isset($suite['total_items']) && $suite['total_items'] > 0 && isset($suite['id'])) {
                                // Try to fetch items directly from database
                                $this->load->model('Snapshot_model');
                                $directItems = $this->Snapshot_model->getMenuItemsForSuite($suite['id']);
                                if (!empty($directItems) && is_array($directItems)) {
                                    $itemsArray = $directItems;
                                    $hasItems = true;
                                }
                            }
                            ?>
                            
                            <?php if ($hasItems): ?>
                                <h6 class="mt-4"><i class="ri-restaurant-line me-2"></i>Menu Items (Historical - Locked)</h6>
                                
                                <?php 
                                // Group items by category
                                $itemsByCategory = [];
                                foreach ($itemsArray as $item) {
                                    // Handle both array and object formats
                                    $catName = 'Uncategorized';
                                    if (is_array($item)) {
                                        $catName = $item['category_name'] ?? $item['categoryName'] ?? 'Uncategorized';
                                    } elseif (is_object($item)) {
                                        $catName = $item->category_name ?? $item->categoryName ?? 'Uncategorized';
                                    }
                                    
                                    // Skip if category name is empty
                                    if (empty($catName) || $catName === 'Uncategorized') {
                                        $catName = 'Uncategorized';
                                    }
                                    
                                    if (!isset($itemsByCategory[$catName])) {
                                        $itemsByCategory[$catName] = [];
                                    }
                                    $itemsByCategory[$catName][] = $item;
                                }
                                
                                // If no categories found but items exist, show them under "All Items"
                                if (empty($itemsByCategory) && !empty($itemsArray)) {
                                    $itemsByCategory['All Items'] = $itemsArray;
                                }
                                ?>
                                
                                <?php foreach ($itemsByCategory as $categoryName => $categoryItems): ?>
                                    <div class="card mb-3" style="border-left: 4px solid #0066cc;">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="ri-restaurant-2-line me-2"></i>
                                                <strong><?php echo htmlspecialchars($categoryName); ?></strong>
                                                <span class="badge bg-primary text-white ms-2" style="color: #ffffff !important;"><?php echo count($categoryItems); ?> item(s)</span>
                                            </h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 5%; color: #212529 !important;">#</th>
                                                            <th style="width: 20%; color: #212529 !important;">Menu Item</th>
                                                            <th style="width: 20%; color: #212529 !important;">Option</th>
                                                            <th style="width: 12%; color: #212529 !important;">Price (Locked)</th>
                                                            <th style="width: 8%; color: #212529 !important;">Qty</th>
                                                            <th style="width: 10%; color: #212529 !important;">Calories</th>
                                                            <th style="width: 15%; color: #212529 !important;">Allergens</th>
                                                            <th style="width: 10%; color: #212529 !important;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $itemNumber = 0;
                                                        foreach ($categoryItems as $item): 
                                                            $itemNumber++;
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $itemNumber; ?></td>
                                                                <td>
                                                                    <?php 
                                                                    // Handle both array and object access
                                                                    $menuName = is_array($item) ? ($item['menu_name'] ?? 'Unknown') : ($item->menu_name ?? 'Unknown');
                                                                    $menuDesc = is_array($item) ? ($item['menu_description'] ?? '') : ($item->menu_description ?? '');
                                                                    ?>
                                                                    <strong><?php echo htmlspecialchars($menuName); ?></strong>
                                                                    <?php if ($menuDesc): ?>
                                                                        <br><small class="text-muted"><?php echo htmlspecialchars($menuDesc); ?></small>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    $optionName = is_array($item) ? ($item['option_name'] ?? '-') : ($item->option_name ?? '-');
                                                                    $itemComment = is_array($item) ? ($item['item_comment'] ?? '') : ($item->item_comment ?? '');
                                                                    ?>
                                                                    <?php echo htmlspecialchars($optionName ?: '-'); ?>
                                                                    <?php if ($itemComment): ?>
                                                                        <br><small class="text-info">
                                                                            <i class="ri-message-2-line"></i> <?php echo htmlspecialchars($itemComment); ?>
                                                                        </small>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    $optionPrice = is_array($item) ? ($item['option_price'] ?? 0) : ($item->option_price ?? 0);
                                                                    ?>
                                                                    <strong style="color: #28a745;">
                                                                        $<?php echo number_format((float)$optionPrice, 2); ?>
                                                                    </strong>
                                                                    <br><small class="text-muted" style="color: #6c757d !important;">🔒 Locked</small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <strong>
                                                                        <?php 
                                                                        $quantity = is_array($item) ? ($item['quantity'] ?? 1) : ($item->quantity ?? 1);
                                                                        echo $quantity; 
                                                                        ?>
                                                                    </strong>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php 
                                                                    $calories = is_array($item) ? ($item['option_calories'] ?? null) : ($item->option_calories ?? null);
                                                                    if ($calories): ?>
                                                                        <?php echo $calories; ?> cal
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    // Convert allergen IDs to names
                                                                    $optionAllergens = is_array($item) ? ($item['option_allergens'] ?? null) : ($item->option_allergens ?? null);
                                                                    if ($optionAllergens && !empty($allergenMap)) {
                                                                        $itemAllergens = json_decode($optionAllergens, true);
                                                                        if (!is_array($itemAllergens)) {
                                                                            $itemAllergens = explode(',', $optionAllergens);
                                                                        }
                                                                        $itemAllergenNames = [];
                                                                        foreach ($itemAllergens as $allergenId) {
                                                                            $allergenId = trim($allergenId);
                                                                            if (isset($allergenMap[$allergenId])) {
                                                                                $itemAllergenNames[] = $allergenMap[$allergenId];
                                                                            }
                                                                        }
                                                                        if (!empty($itemAllergenNames)) {
                                                                            foreach ($itemAllergenNames as $allergenName) {
                                                                                echo '<span class="badge bg-warning text-dark me-1 mb-1" style="color: #212529 !important;"><i class="ri-alert-line"></i> ' . htmlspecialchars($allergenName) . '</span>';
                                                                            }
                                                                        } else {
                                                                            echo '<span class="text-muted">None</span>';
                                                                        }
                                                                    } else {
                                                                        echo '<span class="text-muted">None</span>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php 
                                                                    $isCompleted = is_array($item) ? ($item['is_completed'] ?? 0) : ($item->is_completed ?? 0);
                                                                    if ($isCompleted): ?>
                                                                        <span class="badge bg-success">✓ Complete</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-secondary">Pending</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="4" class="text-end"><strong>Category Total:</strong></td>
                                                            <td class="text-center"><strong><?php echo count($categoryItems); ?></strong></td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning mt-4">
                                    <i class="ri-alert-line me-2"></i>
                                    <strong>No menu items found for this suite.</strong>
                                    <?php if (isset($suite['total_items']) && $suite['total_items'] > 0): ?>
                                        <br><small>
                                            Note: Total items shows <?php echo $suite['total_items']; ?>, but detailed items are not available in the snapshot.
                                            <?php if (isset($suite['id'])): ?>
                                                <br>Suite Snapshot ID: <?php echo $suite['id']; ?>
                                            <?php endif; ?>
                                        </small>
                                    <?php endif; ?>
                                    <?php if (isset($suite['items']) && is_array($suite['items'])): ?>
                                        <br><small>Items array exists but is empty. Count: <?php echo count($suite['items']); ?></small>
                                    <?php else: ?>
                                        <br><small>Items array not found in suite data.</small>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="ri-alert-line me-2"></i>
                    No suite information available for this snapshot.
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <a href="<?php echo base_url('Orderportal/Reports'); ?>" class="btn btn-secondary text-white" style="color: #ffffff !important;">
                        <i class="ri-arrow-left-line me-1"></i> Back to Reports
                    </a>
                    <button onclick="window.print()" class="btn btn-primary text-white" style="color: #ffffff !important;">
                        <i class="ri-printer-line me-1"></i> Print Snapshot
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    /* Force black text for table headers in normal view */
    .table-light th,
    .table thead th,
    .table thead.table-light th {
        color: #212529 !important;
    }
    
    /* Specifically target Allergens column */
    .table thead th:nth-child(7),
    .table-light th:nth-child(7) {
        color: #212529 !important;
    }
    
    /* Force black text for allergen badges */
    .badge.bg-warning,
    .badge.bg-warning.text-dark,
    .badge.bg-warning * {
        color: #212529 !important;
    }
    
    @media print {
        .page-title-right,
        .btn,
        .alert-dismissible .btn-close,
        header,
        .topbar,
        nav,
        footer {
            display: none !important;
        }
        
        body {
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        
        .card {
            page-break-inside: avoid;
            border: 1px solid #dee2e6 !important;
            margin-bottom: 15px;
            box-shadow: none !important;
        }
        
        .card-header {
            background-color: #f8f9fa !important;
            border-bottom: 2px solid #dee2e6 !important;
        }
        
        .badge {
            border: 1px solid #000;
            padding: 2px 6px;
            font-size: 10px;
        }
        
        table {
            font-size: 11px;
        }
        
        table th {
            background-color: #f8f9fa !important;
            color: #000 !important;
            font-weight: bold;
            padding: 8px 4px !important;
        }
        
        table td {
            padding: 6px 4px !important;
            border: 1px solid #dee2e6 !important;
        }
        
        .table-light {
            background-color: #f8f9fa !important;
        }
        
        /* Force black text for all table headers */
        .table-light th,
        .table thead th {
            color: #212529 !important;
        }
        
        /* Force black text for Allergens column specifically */
        .table-light th:nth-child(7),
        .table thead th:nth-child(7) {
            color: #212529 !important;
        }
        
        h4, h5, h6 {
            color: #000 !important;
        }
        
        .text-muted {
            color: #6c757d !important;
        }
        
        /* Ensure all text is black for printing */
        * {
            color: #000 !important;
        }
        
        .bg-primary, .bg-success, .bg-info, .bg-warning, .bg-secondary {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

