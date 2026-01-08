 <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                                <div class="offcanvas-header border-bottom">
                                                  <h5 class="offcanvas-title text-black" id="offcanvasRightLabel">Assign Menus and Submenus</h5>
                                                  <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </div>
                                                <div class="offcanvas-body p-0 overflow-hidden">
                                                    <div data-simplebar style="height: calc(100vh - 112px);">
                                                         <form id="menuSubMenuForm">  
                                                          <input type="hidden" name="user_id" class="user_id" value="<?php echo (isset($user->id) ? $user->id : '') ?>">
                                                          <input type="hidden" name="role_id" class="role_id" value="<?php echo (isset($role_id) ? $role_id : '') ?>">
                                                        <div class="container" style="margin-top: 30px !important;">
                                                             <small class="color-black">*NOTE :  Please save menu for one system at a time.</small><p>
                                                          <small> Click on specific system to load menus assigned to this user  </small></p>
                                                          
                                                        <div class="row row-inner mb-3 mt-3">           
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                               <?php if(!empty($system_details)){  $i =0 ?>
                                                           <select class="form-select mb-3 systemsChange" name="system_id" aria-label="Default select example">
                                                        <option selected>Select System</option>
                                                         <?php foreach($system_details as $system){ ?>    
                                                        <option value="<?php echo $system['system_id']; ?>" data-systemid="<?php echo $system['system_id']; ?>"><?php echo $system['system_name']; ?></option>
                                                        <?php } ?>
                                                         </select>
                                                          </div>
                                                            <?php } ?> 
                                                            
                                                        
                                          <!-- Menu Accordions with Icons -->
<div class="col-lg-12 menuAccess mb-3 menuDiv">                                          
  
    </div>  
                                        
                                                 </div>
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                <div class="offcanvas-footer border p-3 text-center">
                                                    <small class="text-muted d-block mb-3">NOTE: Please save menu for one system at a time</small>
                                                    <button type="button" id="saveMenuForThisUser" class="btn btn-success btn-lg">
                                                        <i class="ri-save-3-line align-middle me-2"></i>Save Menu
                                                    </button>
                                                </div>
                                            </div>
                                 <!--js used for this page is in "login-assets/js/custom.js"      -->          
                                          