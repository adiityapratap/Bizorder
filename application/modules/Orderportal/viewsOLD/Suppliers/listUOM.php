 <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                       

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  

                                    <div class="card-body">
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                          <h4 class="card-title mb-0 text-black">Product UOM</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <div class="px-2 search-box ms-2">
                                                            <input type="text" class="form-control search" placeholder="Search...">
                                                            <i class="ri-search-line search-icon"></i>
                                                        </div> 
                                                        <div class="d-flex justify-content-sm-end">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#flipModal" class="btn btn-primary btn-label view-item-btn"><i class="ri-add-fill label-icon align-middle fs-16 me-2"></i><span>Add New</span></a>
                                                        </div>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="table-responsive table-card mt-3 mb-1">
                                                <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            
                                                            <th class="sort" data-sort="customer_name">Product UOM Name</th>
                                                            <!--<th class="sort" data-sort="status">Change Status</th>-->
                                                            <th class="no-sort" data-sort="action" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all">
                                                        <?php if(!empty($record)) {  ?>
                                                        <?php foreach($record as $row){  ?>
                                                        <tr id="row_<?php echo  $row['product_UOM_id']; ?>" >
                                                           
                                                            <td class="customer_name"><?php echo $row['product_UOM_name']; ?></td>
                                                           <!--  <td><div class="form-check form-switch form-switch-custom form-switch-success">-->
                                                           <!-- <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $row['product_UOM_id']; ?>" <?php if(isset($row['product_UOM_status']) && $row['product_UOM_status']  == '1'){ echo 'checked'; }?>>-->
                                                           <!-- </div>-->
                                                           <!--</td>-->
                                                           
                                                            <td>
                                                                 <ul class="list-inline hstack gap-2 mb-0">
                                                             <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">        
                                                             <a href="#" onclick="showEditModal('<?php echo $row['product_UOM_name']; ?>',<?php echo $row['product_UOM_id']; ?>)" class="edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
                                                             </li>
                                                             
                                                               <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit"> 
                                                                <a href="#" class="remove-item-btn "  data-rel-id="<?php echo  $row['product_UOM_id']; ?>"> <i class="ri-delete-bin-5-fill fs-16 text-danger"></i></a>
                                                                 </li>     
                                                                      </ul>
                                                          
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                          <?php } ?>
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                 
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
             
            </div>
            <!-- end main content-->
            
            
             <div id="flipModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add UOM</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                
                                                                <div>
                                                                    <label for="name-field" class="form-label">Uom Name</label>
                                                                    <input type="text"  name="product_UOM_name" id="product_UOM_name" class="form-control" placeholder="Enter Uom name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Uom name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addUom()">Add </button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Uom</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                <div class="text-center">
                                                                    <div class="position-relative d-inline-block">
                                                                        <div class="position-absolute  bottom-0 end-0">
                                                                            <input class="form-control d-none" value="" id="customer-image-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                        </div>
                                                                        <div class="avatar-lg p-1">
                                                                            <div class="avatar-title bg-light rounded-circle">
                                                                                <img src="/theme-assets/images/users/user-dummy-img.jpg" id="customer-img" class="avatar-md rounded-circle object-cover">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label for="name-field" class="form-label">Uom Name</label>
                                                                    <input type="hidden" id="uomIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_uom_name" class="form-control" placeholder="Enter UOM name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter UOM name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonTill" onclick="updateUom()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>

        <script type="text/javascript">
        function showEditModal(name,Id){
            $("#edited_input_uom_name").val(name);
            $("#uomIdToUpdate").val(Id)
           $("#flipEditModal").modal('show');
        }
        function addUom(){
            let uomName = $("#product_UOM_name").val()
            if(uomName == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_product_UOM/add",
                 data:'product_UOM_name='+uomName,
                 success: function(data){
                    location.reload();
                }
                });
        }
        function updateUom(){
            let uomName = $("#edited_input_uom_name").val();
          
            let id = $("#uomIdToUpdate").val()
            if(uomName == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_product_UOM/edit",
                 data:'product_UOM_name='+uomName+'&id='+id,
                 success: function(data){
                    location.reload();
                }
                });
        }
        
        $('.toggle-demo').on('change',function() {
         let uom_id = $(this).attr('id');
        
        let status = 1;
     if($(this).prop('checked')){
          status = 1;
     }else{
          status = 0;
         
     }
      console.log("status",status)
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
        url: "/Supplier/product_UOM_delete",
        data: {"status":status,"id":uom_id},
        success: function(data){
                 console.log(data);
         
        }
    });
    
    
    })   
            $(document).on("click", ".remove-item-btn" , function() {
                var id = $(this).attr('data-rel-id');
            
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
                            url: "/Supplier/product_UOM_delete",
                            data: {"status":'delete',"id":id},
                            success: function(data){
                                Swal.fire({
                                  title: "Deleted!",
                                  icon: "success",
                                  showCancelButton: !1,
                                  confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                                  cancelButtonClass: "btn btn-danger w-xs mt-2",
                                  buttonsStyling: !1,
                                  showCloseButton: !0,
                              });
                             $('#row_'+id).remove();
                              
                            }
                        });
                        
                    
                          
                      }
                  })
                
                
            });
        </script>
