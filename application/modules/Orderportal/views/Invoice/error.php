<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="ri-file-warning-line display-1 text-warning"></i>
                            </div>
                            <h3 class="text-dark mb-3"><?php echo isset($error_title) ? $error_title : 'Invoice Error'; ?></h3>
                            <p class="text-muted mb-4">
                                <?php echo isset($error_message) ? $error_message : 'An error occurred while processing your request.'; ?>
                            </p>
                            <?php if (isset($invoice_no)): ?>
                            <div class="alert alert-info">
                                <strong>Invoice Number:</strong> <?php echo htmlspecialchars($invoice_no); ?>
                            </div>
                            <?php endif; ?>
                            <div class="mt-4">
                                <a href="<?php echo base_url('Orderportal/Invoice/bulkInvoice'); ?>" class="btn btn-primary me-2">
                                    <i class="ri-arrow-left-line me-1"></i> Back to Invoices
                                </a>
                                <a href="<?php echo base_url('Orderportal/Home'); ?>" class="btn btn-secondary">
                                    <i class="ri-home-line me-1"></i> Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
