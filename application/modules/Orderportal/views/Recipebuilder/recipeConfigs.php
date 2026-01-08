 <div class="main-content">
     <?php $this->session->unset_userdata('listtype');  ?>

                <div class="page-content">
                    <div class="container-fluid">
                    
           <div class="col-12">
               <div class="alert alert-success fade show" role="alert" style="display:none">
                  Data Added Succesfully
                    </div>
                    </div>
                      
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  <div class="card-header">
                                      
                                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 text-black">Menu Configurations </h4>
    
                                    <div class="page-title-right">
                                        <div class="d-flex justify-content-sm-end ">
                                         
                                            <div class="d-flex justify-content-sm-end gap-2">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-atoggle="modal" onclick="showModal('category','Category')"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Category</button>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" onclick="showModal('uom','UOM')"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add UOM </button>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#flipIngredientModal" onclick="clearModalForm('#flipIngredientModal')"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Ingredient</button> 
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
    
                                      </div>
                                      </div>

                                    <div class="card-body">
                                        
                    <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        
                        <?php if(isset($modulesInfo) && !empty($modulesInfo)) { $count = 1; ?>
                         <?php foreach($modulesInfo as $modulename => $moduleData) { 
                         $classActive = '';
                         if(isset($selectedlisttype) && $selectedlisttype !=''){
                         if($selectedlisttype == $modulename){
                          $classActive = 'active';  
                         }   
                         }else{
                         $classActive = ($count == 1 ? 'active' : '');      
                         }    
                        
                        ?>
                       <li class="nav-item">
                       <a class="nav-link py-3 <?php echo $classActive; ?>" data-bs-toggle="tab" href="#Tab<?php echo $modulename;  ?>" role="tab" aria-selected="false">
                       <i class="ri-checkbox-circle-line me-1 align-bottom"></i> <?php echo $moduleData['label'] ?></a>
                       </li>
                        <?php $count++; }  ?>
                        <?php }  ?>
                         </ul>         
                                        
                                          
                      <div class="tab-content mb-1"> 
                                    <?php if(isset($modulesInfo) && !empty($modulesInfo)) { $countD = 1; ?>      
                                    <?php foreach($modulesInfo as $modulename => $moduleData) {
                                       $classActiveShow = '';    
                                       if(isset($selectedlisttype) && $selectedlisttype !=''){
                                       if($selectedlisttype == $modulename){
                                        $classActiveShow = 'active show';  
                                        }   
                                       }else{
                                       $classActiveShow = ($countD == 1 ? 'active show' : '');      
                                      } 
                                   
                                    ?> 
                                         
                                            <div class="tab-pane table-responsive <?php echo $classActiveShow ?>" role="tabpanel"  id="Tab<?php echo $modulename;  ?>">
                                            <div class="table-responsive mb-1">
                                                <table class="table align-middle table-nowrap listDatatable" >
                                                    <thead class="table-dark">
                                                        <tr>
                                                            
                                                            <th class="sort" data-sort="category_name"><?php echo $moduleData['label'] ?> </th>
                                                            <?php if($modulename == 'ingredient') { ?>
                                                            <th class="sort" data-sort="status">Category</th>
                                                            <th class="sort" data-sort="status">UOM</th>
                                                             <th class="sort" data-sort="status">Cost</th>
                                                            <?php } ?>
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all" id="sortable">
                                                        <?php if(!empty($moduleData['tableData'])) {  ?>
                                                        <?php foreach($moduleData['tableData'] as $listtableData){  ?>
                                                        <tr id="row_<?php echo  $listtableData['id']; ?>" >
                                                        <td class="name"><?php echo $listtableData['name']; ?></td>
                                                        
                                                           <?php if($modulename == 'ingredient') { ?>
                                                        <td class="category"><?php echo $listtableData['category_name']; ?></td>
                                                        <td class="uom"><?php echo $listtableData['uom_name']; ?></td>
                                                        <td class="cost"><?php echo '$'.number_format($listtableData['cost'],2); ?></td>
                                                            <?php } ?>
                                                            
                                                            
                                                            
                                            <!--                <td><div class="form-check form-switch form-switch-custom form-switch-success">-->
                                            <!--        <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $category['id']; ?>" <?php if(isset($category['status']) && $category['status']  == '1'){ echo 'checked'; }?>>-->
                                                    
                                            <!--    </div>-->
                                            <!--</td>-->
                                            
                                            
                                                           
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                                    <div class="edit">
                                                                        <?php if($modulename =='ingredient') {  ?>
                                                                        <a  href="<?= base_url('Orderportal/Recipe/editIngredient/' . $listtableData['id']) ?>" class="btn btn-sm btn-secondary edit-item-btn">
                                                                            <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>Edit</a>
                                                                            <?php }else {  ?>
                                                                      <a  onclick="showEditModal('<?php echo $listtableData['name']; ?>',<?php echo $listtableData['id']; ?>, '<?php echo $modulename ?>')" class="btn btn-sm btn-secondary edit-item-btn">
                                                                            <i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i>Edit</a>      
                                                                            <?php }  ?>
                                                                    </div>
                                                                    <div class="remove">
                                                                        <button class="btn btn-sm btn-danger remove-item-btn "  data-listtype="<?php echo  $modulename; ?>" data-rel-id="<?php echo  $listtableData['id']; ?>">
                                                                             <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Remove</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                       <p class="text-muted mb-0">We did not find any record for you search.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </div> 
                                            
                                     <?php $countD++; }  ?>
                                      <?php }  ?>        
                                           </div> 
                                           
                                     
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

               
            </div>
 
        

        <div id="flipModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add category </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    <label for="name-field" class="form-label modalLabel required">Name</label>
                                                                    <input type="text" name="input_config_name" id="input_config_name" class="form-control" required minlength="2" maxlength="100" pattern="[a-zA-Z0-9\s\-_]+" title="Please enter a valid name (2-100 characters, letters, numbers, spaces, hyphens, underscores only)">
                                                                <div class="invalid-feedback configNameError">
                                                                    Please enter a valid name (2-100 characters, letters, numbers, spaces, hyphens, underscores only)
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <input type="hidden" name="listtype" id="menuListType">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtoncategory" onclick="addMenuConfig()">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
                                                
                                                
        <div id="flipEditModal" class="modal fade flip"  role="dialog">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title editmodalTitle" id="exampleModalLabel">Update Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                
                                                                <div>
                                                                    <label for="name-field" class="form-label editmodalLabel required">Category Name</label>
                                                                    <input type="hidden" id="configIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_config_name" class="form-control" placeholder="Enter category name" required minlength="2" maxlength="100" pattern="[a-zA-Z0-9\s\-_]+" title="Please enter a valid name (2-100 characters, letters, numbers, spaces, hyphens, underscores only)">
                                                                <div class="invalid-feedback configNameError">
                                                                    Please enter a valid category name (2-100 characters)
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <input type="hidden" name="listtype" id="menuListTypeEdit">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonCategory" onclick="updateConfig()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
                                                
       <div id="flipIngredientModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Ingredient </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                             <label for="name-field" class="form-label modalLabel required">Ingredient Name</label>
                                                              <input type="text" name="ingredient_name" id="ingredient_name" class="form-control" required minlength="2" maxlength="100" pattern="[a-zA-Z0-9\s\-_]+" title="Please enter a valid ingredient name (2-100 characters, letters, numbers, spaces, hyphens, underscores only)">
                                                                <div class="invalid-feedback configNameError">Please enter a valid ingredient name (2-100 characters)</div>
                                                             </div>
                                                         </div>
                                                         
                                                         <div class="row g-3 mt-2">
                                                            <div class="col-lg-12">
                                                             <label for="categoryId" class="form-label modalLabel required">Category</label>
                                                             <select class="form-select" id="categoryId" required>
                                                                <option value="">Select Category</option>
                                                                <?php if(isset($catListData) && !empty($catListData)){  ?> 
                                                                <?php foreach($catListData as $catList) {  ?>
                                                                <option value="<?php echo $catList['id'] ?>"><?php echo $catList['name']; ?></option>
                                                                <?php } ?>
                                                                <?php } ?>
                                                              </select>
                                                              <div class="invalid-feedback configNameError">Please select a category</div>
                                                             </div>
                                                         </div>
                                                         
                                                         <div class="row g-3 mt-2">
                                                            <div class="col-lg-12">
                                                             <label for="uomId" class="form-label modalLabel required">UOM</label>
                                                             <select class="form-select" id="uomId" required>
                                                                <option value="">Select UOM</option>
                                                                <?php if(isset($uomListData) && !empty($uomListData)){  ?> 
                                                                <?php foreach($uomListData as $uomList) {  ?>
                                                                <option value="<?php echo $uomList['id'] ?>"><?php echo $uomList['name']; ?></option>
                                                                <?php } ?>
                                                                <?php } ?>
                                                              </select>
                                                              <div class="invalid-feedback configNameError">Please select a UOM</div>
                                                             </div>
                                                         </div>
                                                         
                                                          <div class="row g-3 mt-2">
                                                            <div class="col-lg-12">
                                                             <label for="ingredient_cost" class="form-label modalLabel required">Ingredient Cost</label>
                                                              <input type="number" name="cost" id="ingredient_cost" class="form-control" required min="0" step="0.01" max="99999.99" title="Please enter a valid cost between 0 and 99999.99">
                                                                <div class="invalid-feedback configNameError">Please enter a valid ingredient cost (0-99999.99)</div>
                                                             </div>
                                                         </div>
                                                          <div class="row g-3 mt-2">
            <div class="col-lg-12">
                <label for="uomqty" class="form-label modalLabel">UOM Qty</label>
                <input type="text" name="uomqty" id="uomqty" class="form-control" value="1000" readonly>
            </div>
        </div>
                                                         
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <input type="hidden" name="listtype" id="menuListType">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtoncategory" onclick="addIngredients(this)">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>

     
      
       
        <!-- Include Form Validation Script -->
        <script src="<?php echo base_url('theme-assets/js/form-validation.js'); ?>"></script>
        
        <script>
    
    function showModal(listType,label){
        // Clear the modal form before showing
        clearModalForm('#flipModal');
        
        $(".modal-title").html('Add '+label)
        $(".modalLabel").html(label+' Name');
        $("#menuListType").val(listType);
       $("#flipModal").modal('show'); 
       
    }
    
    // Function to clear modal form
    function clearModalForm(modalSelector) {
        const modal = $(modalSelector);
        const form = modal.find('form');
        
        if (form.length > 0) {
            // Clear all input values except hidden fields
            form.find('input:not([type="hidden"]), select, textarea').each(function() {
                if (this.type === 'checkbox' || this.type === 'radio') {
                    this.checked = false;
                } else if (this.tagName === 'SELECT') {
                    this.selectedIndex = 0;
                } else {
                    this.value = '';
                }
                
                // Clear validation states
                $(this).removeClass('is-valid is-invalid');
                $(this).parent().removeClass('has-error');
            });
            
            // Hide all validation messages
            form.find('.invalid-feedback, .valid-feedback').hide().removeClass('d-block show');
            
            // Remove form validation classes
            form.removeClass('was-validated');
            
            // Clear interaction tracking
            form.find('input, select, textarea').removeAttr('data-user-interacted data-had-value');
        }
    }
    
    // Add event listeners for modal clearing
    $(document).ready(function() {
        // Clear modals when they are hidden - works for ALL modals
        $('.modal').on('hidden.bs.modal', function() {
            clearModalForm('#' + $(this).attr('id'));
        });
        
        // Clear modals when close button is clicked - works for ALL modals
        $(document).on('click', '.btn-close, [data-bs-dismiss="modal"]', function() {
            const modal = $(this).closest('.modal');
            if (modal.length > 0) {
                setTimeout(() => {
                    clearModalForm('#' + modal.attr('id'));
                }, 100);
            }
        });
        
        // Handle dynamic buttons that might be added later
        $(document).on('click', '[data-bs-toggle="modal"]', function() {
            const targetModal = $(this).attr('data-bs-target');
            if (targetModal) {
                clearModalForm(targetModal);
            }
        });
        
        // Enhanced showModal function for dynamic buttons
        window.showModalWithClear = function(listType, label, modalId = '#flipModal') {
            clearModalForm(modalId);
            $(modalId + " .modal-title").html('Add ' + label);
            $(modalId + " .modalLabel").html(label + ' Name');
            $(modalId + " #menuListType").val(listType);
            $(modalId).modal('show');
        };
    });
     $(document).on("click", ".remove-item-btn" , function() {
                let id = $(this).attr('data-rel-id');
                let listType = $(this).attr('data-listtype');
                if(listType =='ingredient'){
                    tablename ='ingredients';
                }else{
                    tablename = 'recipebuilder_configs'
                }
                    Swal.fire({
                      title: "Are you sure?",
                      icon: "warning",
                      showCancelButton: !0,
                      confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                      cancelButtonClass: "btn btn-danger w-xs mt-2",
                      confirmButtonText: "Yes, delete it!",
                      buttonsStyling: !1,
                      showCloseButton: !0,
                  }).then(function (e) {
                      if (e.value) {
                        $.ajax({
                            type: "POST",
                           url: 'deleteRecipeConfigs',
                            data: 'id='+id+'&is_deleted=1&tablename='+tablename,
                            success: function(data){
                              $('#row_'+id).remove();
                            }
                        });
                      }
                  })
                
                
            });
            
            
            
      // DataTable initialization moved to document.ready with proper tab handling
      // $('.listDatatable').DataTable({ ... }) - now handled in document.ready
        
        function showEditModal(configName,configId,listtype){
            $("#edited_input_config_name").val(configName);
            let capitalizedlisttype = listtype[0].toUpperCase() + listtype.substring(1);
            $("#menuListTypeEdit").val(listtype);
            $(".editmodalTitle").html('Update  '+capitalizedlisttype);
             $(".editmodalLabel").html(capitalizedlisttype+' Name');
            $("#configIdToUpdate").val(configId)
           $("#flipEditModal").modal('show');
        }
        function addMenuConfig(){
            let configName = $("#input_config_name").val();
            let listType = $("#menuListType").val()
            if(configName == ''){
               $(".configNameError").show();
               return false;
            }else{
                $(".submitButtoncategory").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "saveConfigsdata",
                 data: 'name=' + configName + '&listtype=' + listType, 
                 success: function(data){
                    location.reload();
                }
                });
        }
        function updateConfig(){
            let configName = $("#edited_input_config_name").val();
            let listType = $("#menuListTypeEdit").val()
            let id = $("#configIdToUpdate").val();
            
            if(configName == ''){
               $(".configNameError").show();
               return false;
            }else{
                $(".submitButtonCategory").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "updateConfig",
                  data: 'name=' + configName + '&listtype=' + listType+'&id='+id,
                 success: function(data){
                    location.reload();
                }
                });
        }
        
        $(document).ready(()=>{
            // IMMEDIATE first tab activation (no delay)
            // console.log('Document ready - immediate tab check...');
            
            if ($('.nav-tabs .nav-link.active').length === 0) {
                // console.log('No active tab on document ready, activating first...');
                $('.nav-tabs .nav-link:first').addClass('active').attr('aria-selected', 'true');
                $('.tab-content .tab-pane:first').addClass('active show');
            }
            
            // AGGRESSIVE first tab activation with delay for safety
            setTimeout(() => {
                // console.log('Checking tab activation...');
                
                // Check if any tab is active
                const activeNavLinks = $('.nav-tabs .nav-link.active');
                const activeTabPanes = $('.tab-content .tab-pane.active');
                
                // console.log('Active nav links:', activeNavLinks.length);
                // console.log('Active tab panes:', activeTabPanes.length);
                
                // If no tab is active, force activate the first one
                if (activeNavLinks.length === 0 || activeTabPanes.length === 0) {
                    // console.log('No active tab found, activating first tab...');
                    
                    // Remove any existing active classes
                    $('.nav-tabs .nav-link').removeClass('active');
                    $('.tab-content .tab-pane').removeClass('active show');
                    
                    // Activate first tab
                    $('.nav-tabs .nav-link:first').addClass('active').attr('aria-selected', 'true');
                    $('.tab-content .tab-pane:first').addClass('active show');
                    
                    // console.log('First tab activated');
                }
                
                // Reinitialize DataTables for visible tabs
                $('.tab-pane.active .listDatatable').each(function() {
                    // console.log('Initializing DataTable for active tab...');
                    if (!$.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable({
                            pageLength: 100,
                            bPaginate: false,
                            bInfo: false,
                            lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                            "columnDefs": [{
                                "targets": 'no-sort',
                                "orderable": false
                            }],
                            "initComplete": function() {
                                $('.dataTables_filter input').attr('placeholder', 'Search items...');
                            }
                        });
                    }
                });
            }, 100);
            
            // Handle tab switching and reinitialize DataTables
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                const targetTab = $(e.target).attr('href');
                $(targetTab + ' .listDatatable').each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().columns.adjust().draw();
                    } else {
                        $(this).DataTable({
                            pageLength: 100,
                            bPaginate: false,
                            bInfo: false,
                            lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                            "columnDefs": [{
                                "targets": 'no-sort',
                                "orderable": false
                            }],
                            "initComplete": function() {
                                $('.dataTables_filter input').attr('placeholder', 'Search items...');
                            }
                        });
                    }
                });
            });
            
            setTimeout(()=>{
              $(".alert-success").fadeOut();   
            },7000);
        })
        
        
    function addIngredients(obj) {
    $(obj).html("Saving...");
    const ingredientName = $('#ingredient_name').val();
    const categoryId = $('#categoryId').val();
    const uomId = $('#uomId').val();
    const cost = $('#ingredient_cost').val();
     const uomqty = $('#uomqty').val();

  
    if (!ingredientName || !categoryId || !uomId || !cost) {
        alert('Please fill in all fields.');
        return;
    }
  // console.log("ingredientName",ingredientName)
    
    $.ajax({
        url: 'saveIngredients', 
        type: 'POST',
        data: {
            ingredient_name: ingredientName,
            category_id: categoryId,
            uom_id: uomId,
            cost: cost,
            uomqty: uomqty,
        },
        dataType: 'json',
        success: function(response) {
             location.reload();
            let res  = JSON.parse(response);
            if (res.success) {
                alert('Ingredient added successfully!');
                $('#flipIngredientModal').modal('hide'); // Close modal
                $(obj).html("Save");
            } else {
                alert(res.message || 'Failed to add ingredient.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
}

        
    
    
        </script>
 