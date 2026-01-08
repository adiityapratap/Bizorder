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
                                                          <h4 class="card-title mb-0 text-black">Main Supplier Category</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                       
                                                        <div class="d-flex justify-content-sm-end gap-2">
        <a href="#" data-bs-toggle="modal" data-bs-target="#flipModal" class="btn btn-success btn-label view-item-btn"><i class="ri-add-fill label-icon align-middle fs-16 me-2"></i><span>Add New</span></a>
        <a href="/Supplier/listSupplierSubCategory" class="btn btn-success btn-label view-item-btn"><i class="ri-eye-fill label-icon align-middle fs-16 me-2"></i><span>View Sub Categories</span></a>
                                                        </div>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="table-responsive table-card mt-3 mb-1">
                                                <table class="table align-middle table-nowrap" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            
                                                            <th class="sort" data-sort="customer_name">Supplier Category Name</th>
                                                            <th class="sort" data-sort="status">Change Status</th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="no-sort" data-sort="action" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all">
                                                        <?php if(!empty($record)) {  ?>
                                                        <?php foreach($record as $row){  ?>
                                                        <tr id="row_<?php echo  $row['category_id']; ?>" >
                                                            
                                                            <td class="customer_name"><?php echo $row['category_name']; ?></td>
                                                            <td class="status">
                                                                <?php if($row['status'] == 1){ ?>
                                                                    <span class="badge bg-success-subtle text-success text-uppercase">Enabled</span>
                                                                <?php }else{ ?>
                                                                    <span class="badge bg-danger-subtle text-danger text-uppercase">Disabled</span>
                                                                <?php } ?>
                                                            </td>
                                                            
                                                             <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $row['category_id']; ?>" <?php if(isset($row['status']) && $row['status']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                           
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                           <ul class="list-inline hstack gap-2 mb-0">
                                                             <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">           
                                                             <a href="#" onclick="showEditModal('<?php echo $row['category_name']; ?>',<?php echo $row['category_id']; ?>)" class="edit-item-btn"> <i class="ri-pencil-fill fs-16"></i></a>
                                                             </li>
                                                            <li class="list-inline-item remove" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">             
                                                              <a href="#" class=" remove-item-btn text-danger"  data-rel-id="<?php echo  $row['category_id']; ?>">   <i class="ri-delete-bin-5-fill fs-16"></i></a>
                                                              </li>
                                                                 
                                                                </div>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                            
                                                                <div>
                                                                    <label for="name-field" class="form-label">Category Name</label>
                                                                    <input type="text"  name="category_name" id="category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Category name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addCat()">Add </button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Supplier Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                               
                                                                <div>
                                                                    <label for="name-field" class="form-label">Category Name</label>
                                                                    <input type="hidden" id="categoryIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Category name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonTill" onclick="updateCat()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
        

        <script type="text/javascript">
        
        function showEditModal(name,Id){
            $("#edited_input_category_name").val(name);
            $("#categoryIdToUpdate").val(Id)
           $("#flipEditModal").modal('show');
        }
        function addCat(){
            let category_name = $("#category_name").val()
            if(category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_category/add",
                 data:'category_name='+category_name,
                 success: function(data){
                    location.reload();
                }
                });
        }
        function updateCat(){
            let edited_input_category_name = $("#edited_input_category_name").val();
          
            let id = $("#categoryIdToUpdate").val()
            if(edited_input_category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_category/edit",
                 data:'category_name='+edited_input_category_name+'&id='+id,
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
        url: "/Supplier/supplierCategoryDelete",
        data: {"status":status,"id":uom_id},
        success: function(data){
                 console.log(data);
         
        }
    });
    
    
    })  
    $('#customerTable').DataTable({
                "bLengthChange":false,
                pageLength: 100,
                lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
    
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
                            url: "/Supplier/supplierCategoryDelete",
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
    </body>

</html>