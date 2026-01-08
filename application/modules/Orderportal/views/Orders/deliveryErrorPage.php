<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h4 class="card-title mb-0 text-white">
                                <i class="ri-error-warning-line me-2"></i>
                                <?php echo isset($error_title) ? $error_title : 'Service Not Available'; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <i class="ri-truck-line text-muted" style="font-size: 4rem;"></i>
                            </div>
                            
                            <p class="text-muted mb-4">
                                <?php echo isset($error_message) ? $error_message : 'The requested service is currently not available.'; ?>
                            </p>
                            
                            <?php if (isset($errors) && !empty($errors)): ?>
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">
                                        <i class="ri-information-line me-1"></i>
                                        Issues Found:
                                    </h6>
                                    <ul class="mb-0">
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="ri-lightbulb-line me-1"></i>
                                    What to do next:
                                </h6>
                                <ol class="mb-0">
                                    <li><strong>Create Today's Menu Plan:</strong> Go to Menu Planner and create/publish a menu for today's date</li>
                                    <li><strong>Place Orders:</strong> Ensure orders have been placed for today</li>
                                    <li><strong>Try Again:</strong> Once the above steps are completed, return to this page</li>
                                </ol>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="<?php echo base_url('Orderportal/Menuplanner/list'); ?>" class="btn btn-primary me-2">
                                    <i class="ri-calendar-line me-1"></i>
                                    Go to Menu Planner
                                </a>
                                <a href="<?php echo base_url('Orderportal/Order/orderList'); ?>" class="btn btn-secondary me-2">
                                    <i class="ri-list-check me-1"></i>
                                    View Orders
                                </a>
                                <a href="<?php echo base_url(); ?>" class="btn btn-outline-primary">
                                    <i class="ri-home-line me-1"></i>
                                    Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
