 <div class="live-preview">
                                       
                                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                                            <div class="offcanvas-header border-bottom">
                                                <h3 class="offcanvas-title text-black" id="offcanvasExampleLabel">All Systems </h3>
                                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                            </div>
                                            <div class="offcanvas-body p-0 overflow-hidden">
                                                <div data-simplebar style="height: calc(100vh - 112px);">
                                                   <div class="d-flex flex-column h-100 mx-2 mt-5">
                                    <div class="row">
                                         <?php if(!empty($systemAssignedToThisUser)) {  ?>
                                            <?php foreach($systemAssignedToThisUser as $system)  {  ?>  
                                            
                                        <div class="col-xl-6 col-md-6">
                                            <?php if(isset($system['custom_redirect_url']) && $system['custom_redirect_url'] !=''){ ?>
                                            <a href="<?php echo $system['custom_redirect_url']; ?>">
                                            <?php } else { ?>
                                            <a href="/<?php echo $system['slug']; ?>/<?php echo $system['system_id']; ?>">
                                            <?php } ?>
                                            
                                            <div class="card card-animate overflow-hidden" style="background-color: #282A53;">
                                                <div class="position-absolute start-0" style="z-index: 0;">
                                                    <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120" fill="">
                                                        <style>
                                                            .s0 {
                                                                opacity: .05;
                                                                fill: var(--vz-info)c
                                                            }
                                                        </style>
                                                        <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                                                    </svg>
                                                </div>
                                                <div class="card-body" style="z-index:1 ;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-uppercase fw-bold text-muted text-truncate mb-3"> <?php echo $system['system_name']; ?></p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                    <h4 class="fs-50 fw-semibold ff-secondary mb-0">
                                                    <i class="<?php echo (isset($system['system_icon']) && $system['system_icon'] !='' ? $system['system_icon'] : 'bx bx-laptop'); ?> fs-50" style="color:<?php echo $system['system_color']; ?>;font-size: 45px;"></i>
                                                     </h4>
                                                        </div>
                                                        
                                                </div><!-- end card body -->
                                            </div>
                                             </a>
                                        </div>
                                       
                                          <?php } ?>
                                            <?php } ?>  
                                       
                                    </div><!--end row-->
                                </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>