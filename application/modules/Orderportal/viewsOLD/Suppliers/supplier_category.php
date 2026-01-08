<?php if($form_type == 'view'){ $disabled = 'disabled'; }else{ $disabled = ''; } ?>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                       

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  

                                    <div class="card-body">
                                        <form action="/Supplier/save_category/<?php echo $form_type.'/'.($form_type == 'edit' ? $record[0]['category_id'] : 'new') ?>" method="POST">
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-uppercase fw-bold"><?php echo $form_type; ?> Supplier Category</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <?php if($form_type == 'add'){ ?>
                                                            <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Save</span></button>
                                                        <?php }else if($form_type == 'edit'){ ?>
                                                            <button type="submit" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-refresh-line label-icon align-middle fs-16 me-2"></i><span>Update</span></button>
                                                        <?php }else{ ?>
                                                            <a href="/Supplier/manage_categories/" class="btn btn-success waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-4">
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="categoryNameInput" class="form-label">Category Name</label>
                                                        <input type="text" class="form-control" required name="category_name" id="categoryNameInput" placeholder="Category Name" <?php echo $disabled; ?> value="<?php echo (isset($record[0]['category_name']) ? $record[0]['category_name'] : ''); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="categoryStatusSelect" class="form-label">Category Status</label>
                                                        <select class="form-control" required name="status" id="categoryStatusSelect" <?php echo $disabled; ?> >
                                                            <option value=""><?php echo ($form_type == 'view' ? '' : 'Select'); ?></option>
                                                            <option value="1" <?php echo (isset($record[0]['status']) && $record[0]['status'] == '1' ? 'selected' : ''); ?>>Enable</option>
                                                            <option value="2" <?php echo (isset($record[0]['status']) && $record[0]['status'] == '2' ? 'selected' : ''); ?>>Disable</option>
                                                        </select>
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
              
            </div>
          