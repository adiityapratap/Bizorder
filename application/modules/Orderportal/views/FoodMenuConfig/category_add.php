<?= $this->include('partials/main') ?>

    <head>
<!-- One of the following themes -->
        <link rel="stylesheet" href="/assets/libs/@simonwep/pickr/themes/classic.min.css"/> <!-- 'classic' theme -->
        <link rel="stylesheet" href="/assets/libs/@simonwep/pickr/themes/monolith.min.css"/> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="/assets/libs/@simonwep/pickr/themes/nano.min.css"/> <!-- 'nano' theme -->
        <?php echo view('partials/title-meta', array('title' => 'add Till')); ?>

        <!-- Sweet Alert css-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
 <?= $this->include('partials/head-css') ?>

    </head>
<?php if($form_type == 'view'){ $disabled = 'disabled'; }else{ $disabled = ''; } ?>
    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

           <?= $this->include('partials/menu') ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                       

                        <div class="row rowMarginNegative">
                            <div class="col-lg-12">
                                <div class="card">
                                  

                                    <div class="card-body">
                                        <form action="/Tills/add" method="POST">
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-uppercase fw-bold"><?php echo $form_type; ?> Tills</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <?php if($form_type == 'add'){ ?>
                                                            <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Save</span></button>
                                                        <?php }else if($form_type == 'edit'){ ?>
                                                            <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-refresh-line label-icon align-middle fs-16 me-2"></i><span>Update</span></button>
                                                            <input type="hidden" name="id" value>
                                                        <?php } ?>
                        <a href="/Tills" class="btn btn-success waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-4">
                                                
                                                <div class="col-lg-4 mb-4">
                                                    <div>
                                                        <label for="supplier_name" class="form-label">Till Name</label>
                                                        <input type="text" class="form-control" required name="till_name" id="till_name" placeholder="Till Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['supplier_name']) ? $record[0]['supplier_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                               
                                                
                                               
                                            </div>
                                        </div>
                                        </form>
                                    </div><!-- end card -->
                                    
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end col -->
                        </div>
                       

                       

                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                 <?= $this->include('partials/footer') ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        

      <?= $this->include('partials/customizer') ?>

        <?= $this->include('partials/vendor-scripts') ?>
       
      
    </body>

</html>