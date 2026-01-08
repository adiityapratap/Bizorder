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
                                        <div class="d-flex justify-content-end">
                                            <!-- Mobile-First Responsive Button Layout -->
                                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-sm-end menu-config-buttons">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick="showModal('category','Category')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Category
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" onclick="showModal('cuisine','Cuisine')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Cuisine
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" onclick="showModal('allergen','Allergen')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Allergen
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" onclick="showModal('nutrition','Nutrition')" style="color: black !important;">
                                                    <i class="ri-add-line fs-12 align-bottom me-1" style="color: black !important;"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Nutrition
                                                </button>
                                                <button type="button" class="btn btn-lightpurple btn-sm" data-bs-toggle="modal" onclick="showModal('classification','Classification')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Classification
                                                </button>
                                                <button type="button" class="btn btn-brickpink btn-sm" data-bs-toggle="modal" onclick="showModal('size','Size')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Size
                                                </button>
                                                <!--<button type="button" class="btn btn-parrot btn-sm" data-bs-toggle="modal" onclick="showModal('department','Department')"> <i class="ri-add-line fs-12 align-bottom me-1"></i>Add Department</button> -->
                                                <button type="button" class="btn btn-yellowlight btn-sm" data-bs-toggle="modal" onclick="showModal('floor','Floor')">
                                                    <i class="ri-add-line fs-12 align-bottom me-1"></i>
                                                    <span class="d-none d-sm-inline">Add </span>Floor
                                                </button>
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
                                            <div class="table-responsive  mb-1">
                                                <table class="table align-middle table-nowrap listDatatable" >
                                                    <thead class="table-dark">
                                                        <tr>
                                                            
                                                            <th class="sort" data-sort="category_name"><?php echo $moduleData['label'] ?> </th>
                                                            <!--<th class="sort" data-sort="status">Status</th>-->
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all sortable" id="sortable">
                                                        <?php if(!empty($moduleData['tableData'])) {  ?>
                                                        <?php foreach($moduleData['tableData'] as $listtableData){  ?>
                                                        <tr id="row_<?php echo  $listtableData['id']; ?>" >
                                                            <td class="name"><?php echo $listtableData['name']; ?></td>
                                                            
                                                            
                                                            
                                            <!--                <td><div class="form-check form-switch form-switch-custom form-switch-success">-->
                                            <!--        <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $category['id']; ?>" <?php if(isset($category['status']) && $category['status']  == '1'){ echo 'checked'; }?>>-->
                                                    
                                            <!--    </div>-->
                                            <!--</td>-->
                                            
                                            
                                                           
                                                            <td>
                                                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                                    <a onclick="showEditModal('<?php echo $listtableData['name']; ?>',<?php echo $listtableData['id']; ?>, '<?php echo $modulename ?>','<?php echo $listtableData['inputType']; ?>')" 
                                                                       class="btn btn-sm btn-secondary edit-item-btn" title="Edit">
                                                                        <i class="ri-edit-box-line align-middle fs-12"></i>
                                                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                                                    </a>
                                                                    <button class="btn btn-sm btn-danger remove-item-btn" 
                                                                            data-listtype="<?php echo $modulename; ?>" 
                                                                            data-rel-id="<?php echo $listtableData['id']; ?>" 
                                                                            title="Remove">
                                                                        <i class="ri-delete-bin-line align-middle fs-12"></i>
                                                                        <span class="d-none d-md-inline ms-1">Remove</span>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                                
                                                <style>
                                                /* Mobile-First Responsive Improvements for Menu Configurations */
                                                
                                                /* Base styles for menu config buttons */
                                                .menu-config-buttons {
                                                    max-width: 100%;
                                                }
                                                
                                                .menu-config-buttons .btn {
                                                    white-space: nowrap;
                                                    border-radius: 6px;
                                                    font-weight: 500;
                                                }
                                                
                                                /* Hide any display:none buttons from grid layout */
                                                .menu-config-buttons .btn[style*="display:none"],
                                                .menu-config-buttons .btn[style*="display: none"] {
                                                    display: none !important;
                                                }
                                                
                                                @media (max-width: 991.98px) {
                                                    /* Large tablet and below - 3 columns */
                                                    .menu-config-buttons {
                                                        display: grid !important;
                                                        grid-template-columns: repeat(3, 1fr);
                                                        gap: 0.5rem;
                                                        width: 100%;
                                                        justify-content: center;
                                                    }
                                                    
                                                    .menu-config-buttons .btn {
                                                        font-size: 0.75rem;
                                                        padding: 0.5rem 0.25rem;
                                                        text-align: center;
                                                        min-width: auto;
                                                    }
                                                }
                                                
                                                @media (max-width: 767.98px) {
                                                    /* Mobile - 2 columns */
                                                    .menu-config-buttons {
                                                        grid-template-columns: repeat(2, 1fr);
                                                        gap: 0.4rem;
                                                    }
                                                    
                                                    .menu-config-buttons .btn {
                                                        font-size: 0.7rem;
                                                        padding: 0.4rem 0.2rem;
                                                    }
                                                    
                                                    .page-title-right {
                                                        width: 100%;
                                                    }
                                                    
                                                    .page-title-right .d-flex {
                                                        justify-content: center !important;
                                                    }
                                                    
                                                    /* Table action buttons */
                                                    .table td {
                                                        padding: 0.5rem 0.25rem !important;
                                                    }
                                                    
                                                    .table .btn-sm {
                                                        padding: 0.25rem 0.375rem;
                                                        font-size: 0.75rem;
                                                        min-width: 35px;
                                                    }
                                                    
                                                    /* Make table horizontally scrollable */
                                                    .table-responsive {
                                                        overflow-x: auto;
                                                    }
                                                    
                                                    /* Ensure buttons don't break */
                                                    .d-flex.flex-wrap.gap-1 {
                                                        gap: 0.25rem !important;
                                                        justify-content: center !important;
                                                    }
                                                }
                                                
                                                @media (max-width: 575.98px) {
                                                    /* Very small screens - still 2 columns but smaller */
                                                    .menu-config-buttons {
                                                        grid-template-columns: repeat(2, 1fr);
                                                        gap: 0.3rem;
                                                        max-width: 300px;
                                                        margin: 0 auto;
                                                    }
                                                    
                                                    .menu-config-buttons .btn {
                                                        font-size: 0.65rem;
                                                        padding: 0.35rem 0.15rem;
                                                        line-height: 1.2;
                                                    }
                                                    
                                                    /* Table action buttons - icon only */
                                                    .table .btn-sm {
                                                        min-width: 30px;
                                                        padding: 0.25rem;
                                                    }
                                                }
                                                
                                                @media (max-width: 400px) {
                                                    /* Extra small screens - single column */
                                                    .menu-config-buttons {
                                                        grid-template-columns: 1fr;
                                                        max-width: 200px;
                                                    }
                                                    
                                                    .menu-config-buttons .btn {
                                                        font-size: 0.7rem;
                                                        padding: 0.4rem 0.5rem;
                                                    }
                                                }
                                                
                                                /* Better button spacing */
                                                .gap-1 {
                                                    gap: 0.25rem !important;
                                                }
                                                
                                                .gap-2 {
                                                    gap: 0.5rem !important;
                                                }
                                                
                                                /* Ensure tooltips work on mobile */
                                                .btn[title] {
                                                    position: relative;
                                                }
                                                
                                                /* Fix Nutrition button text color - Force override Bootstrap */
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"],
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"] *,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"] i,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"] span {
                                                    color: #000000 !important;
                                                    text-shadow: none !important;
                                                }
                                                
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:hover,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:focus,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:active,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:hover *,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:focus *,
                                                button.btn.btn-warning.btn-sm[onclick*="nutrition"]:active * {
                                                    color: #000000 !important;
                                                    text-shadow: none !important;
                                                }
                                                </style>
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
                                                                    <label for="name-field" class="form-label modalLabel">Name</label>
                                                                    <input type="text"  name="input_config_name" id="input_config_name" class="form-control" required="">
                                                                <div class="invalid-feedback configNameError" style="display:none">
                                                                    Please enter name
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
                                                    <h5 class="modal-title editModalTitle" id="exampleModalLabel">Update Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                
                                                                <div>
                                                                    <label for="name-field" class="form-label editModalLabel">Category Name</label>
                                                                    <input type="hidden" id="configIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_config_name" class="form-control" placeholder="Enter category name" required="">
                                                                <div class="invalid-feedback configNameError" style="display:none">
                                                                    Please enter category name
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
                                                </div><!-- /.modal -->

     
      
       
        <script>
        
        function ucfirst(str) {
        if (!str) return str;
       return str.charAt(0).toUpperCase() + str.slice(1);
      }
    
    function showModal(listType,label){
        $(".modal-title").html('Add '+label)
        $(".modalLabel").html(label+' Name');
        $("#menuListType").val(listType);
       $("#flipModal").modal('show'); 
       
       
    }    
     $(document).on("click", ".remove-item-btn" , function() {
                let id = $(this).attr('data-rel-id');
                let listType = $(this).attr('data-listtype');
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
                           url: '<?php echo base_url("Orderportal/Configfoodmenu/delete"); ?>',
                            data: 'listtype=' + listType+'&id='+id+'&tableName=foodmenuconfig',
                            success: function(data){
                              $('#row_'+id).remove();
                            }
                        });
                      }
                  })
                
                
            });
            
    //   $('.listDatatable').DataTable({
    //             pageLength: 100,
    //             bPaginate: false,
    //             bInfo : false,
    //             lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
    //             "columnDefs": [ {
    //               "targets"  : 'no-sort',
    //               "orderable": false
    //             }]
    //     });
        
        function showEditModal(configName,configId,listtype,inputType){
            $(".editModalTitle").html('Update '+ucfirst(listtype))
            $(".editModalLabel").html(ucfirst(listtype)+' Name');
            $("#edited_input_config_name").val(configName);
            $("#menuListTypeEdit").val(listtype);
            $("#configIdToUpdate").val(configId);
            $(".editinputType").val(inputType);
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
            
            let inputType='';
            if($("#inputType").val() !=''){
              inputType =   $("#inputType").val();
            }
            
            $.ajax({
                 type: "POST",
                 url: "Configfoodmenu/add",
                 data: 'name=' + configName + '&listtype=' + listType+'&inputType='+inputType, 
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
            let inputType='';
            if($("#updatedInputType").val() !=''){
              inputType =   $("#updatedInputType").val();
            }
            $.ajax({
                 type: "POST",
                 url: "Configfoodmenu/updateConfig",
                  data: 'name=' + configName + '&listtype=' + listType+'&id='+id+'&inputType='+inputType,
                 success: function(data){
                    location.reload();
                }
                });
        }
        
        $(document).ready(()=>{
            setTimeout(()=>{
              $(".alert-success").fadeOut();   
            },7000);
            
            // Ensure first tab is always active on page load
            ensureFirstTabActive();
        })
        
        // Function to ensure the first tab is always active
        function ensureFirstTabActive() {
            // Check immediately
            if ($('.nav-tabs .nav-link.active').length === 0) {
                // console.log('No active tab found, activating first tab...');
                activateFirstTab();
            }
            
            // Also check after a small delay to handle any async loading
            setTimeout(() => {
                if ($('.nav-tabs .nav-link.active').length === 0) {
                    // console.log('Still no active tab after delay, activating first tab...');
                    activateFirstTab();
                }
                
                // Ensure corresponding tab content is also active
                if ($('.tab-content .tab-pane.active').length === 0) {
                    // console.log('No active tab content, activating first tab content...');
                    $('.tab-content .tab-pane:first').addClass('active show');
                }
            }, 100);
        }
        
        // Function to activate the first tab
        function activateFirstTab() {
            // Remove any existing active classes
            $('.nav-tabs .nav-link').removeClass('active').attr('aria-selected', 'false');
            $('.tab-content .tab-pane').removeClass('active show');
            
            // Activate first tab and content
            $('.nav-tabs .nav-link:first').addClass('active').attr('aria-selected', 'true');
            $('.tab-content .tab-pane:first').addClass('active show');
            
            // console.log('First tab activated successfully');
        }
        
        // Additional safety check on window load
        $(window).on('load', function() {
            setTimeout(() => {
                ensureFirstTabActive();
            }, 200);
        });
        $('.toggle-demo').on('change',function() {
         let category_id = $(this).attr('id');
        
        let status = 1;
     if($(this).prop('checked')){
          status = 1;
     }else{
          status = 0;
         
     }
      // console.log("status",status)
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
        url: "Configfoodmenu/change_status",
        data: {"status":status,"id":category_id},
        success: function(data){
                 // console.log(data);
                //  location.reload();
        }
    });
    
    
    })   
    
    $(function() {
    // Make the table rows sortable
    $(".sortable").sortable({
      
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });

            $.ajax({
                url: "Configfoodmenu/updateSortOrder",
                type: "POST",
                data: { order: sortOrder },
                success: function(response) {
                    // console.log("Order updated successfully");
                },
                error: function() {
        
                    // console.log("Error updating order");
                }
            });
        }
    });
    
});
        </script>
 