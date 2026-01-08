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
                                                          <h4 class="card-title mb-0 text-black">Supplier  Category</h4>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                       
                                                        <div class="d-flex justify-content-sm-end gap-2">
      <a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                                          
        <a href="#" data-bs-toggle="modal" data-bs-target="#flipModal" class="btn btn-success btn-label view-item-btn"><i class="ri-add-fill label-icon align-middle fs-16 me-2"></i><span>Add New Sub Category</span></a>
                                                        </div>
                                                        
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="table-responsive table-card mt-3 mb-1">
                                                <table class="table align-middle table-nowrap" id="supplierSubCategory">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="sort" data-sort="MainCategory_name">Main Category Name</th>
                                                            <th class="sort" data-sort="category_name">Sub Category Name</th>
                                                            <th class="sort" data-sort="status"> Status</th>
                                                           
                                                            <th class="no-sort" data-sort="action" width="200">Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all" id="sortable">
                                                        <?php if(!empty($record)) {  ?>
                                                        <?php foreach($record as $row){  ?>
                                                        <tr id="row_<?php echo  $row['id']; ?>" >
                                                             <td class="MainCategory_name"><?php echo $row['mainCategoryName']; ?></td>
                                                            <td class="category_name"><?php echo $row['category_name']; ?></td>
                                                           
                                                            
                                                             <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $row['id']; ?>" <?php if(isset($row['status']) && $row['status']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                           
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                           <ul class="list-inline hstack gap-2 mb-0">
                                                             <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">           
                                                             <a href="#" onclick="showEditModal('<?php echo $row['category_name']; ?>',<?php echo $row['id']; ?>,<?php echo $row['category_id']; ?>)" class="edit-item-btn"> <i class="ri-pencil-fill fs-16"></i></a>
                                                             </li>
                                                            <li class="list-inline-item remove" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">             
                                                              <a href="#" class=" remove-item-btn text-danger"  data-rel-id="<?php echo  $row['id']; ?>">   <i class="ri-delete-bin-5-fill fs-16"></i></a>
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
                                                            
                                                              
                                                                    <label for="name-field" class="form-label">Sub Category Name</label>
                                                                    <input type="text"  name="category_name" id="category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter sub category name
                                                                    </div>
                                                               
                                                            </div>
                                                            
                                                             <div class="col-lg-12">
                                                            <label for="category_id" class="form-label">Supplier Category</label>
                                                        <select class="js-example-basic-single" name="category_id" id="addcategory_id" <?php echo $disabled; ?> >
                                                            <option value="">Select</option>
                                                            
                                                        <?php if(!empty($supplier_categories)){ 
                                                            foreach($supplier_categories as $supCat){ ?>
                                                               <option value="<?php echo $supCat['category_id']; ?>"><?php echo $supCat['category_name']; ?></option>
                                                        <?php } }  ?>
                                                        </select>
                                                               
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
                                                                <label for="name-field" class="form-label">Sub Category Name</label>
                                                                    <input type="hidden" id="categoryIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter sub category name
                                                                    </div>
                                                            </div>
                                                            
                                                              <div class="col-lg-12">
                                                            <label for="category_id" class="form-label">Supplier Category</label>
                                                        <select class="form-select" name="category_id" id="editcategory_id" <?php echo $disabled; ?> >
                                                            <option value="">Select category</option>
                                                            
                                                        <?php if(!empty($supplier_categories)){ 
                                                            foreach($supplier_categories as $supCat){ ?>
                                                               <option value="<?php echo $supCat['category_id']; ?>"><?php echo $supCat['category_name']; ?></option>
                                                        <?php } }  ?>
                                                        </select>
                                                               
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
        
        function showEditModal(name,Id,categoryId){
            $("#edited_input_category_name").val(name);
            $("#categoryIdToUpdate").val(Id);
            $("#editcategory_id").val(categoryId)
           $("#flipEditModal").modal('show');
        }
        function addCat(){
            let category_name = $("#category_name").val()
            let parentCategory_id = $("#addcategory_id").val()
            if(category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_Subcategory/add",
                 data:'category_name='+category_name+'&category_id='+parentCategory_id,
                 success: function(data){
                    location.reload();
                }
                });
        }
        function updateCat(){
            let edited_input_category_name = $("#edited_input_category_name").val();
             let editcategory_id = $("#editcategory_id").val();
          
            let id = $("#categoryIdToUpdate").val()
            if(edited_input_category_name == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_Subcategory/edit",
                 data:'category_name='+edited_input_category_name+'&id='+id+'&category_id='+editcategory_id,
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
        url: "/Supplier/supplierSubCategoryDelete",
        data: {"status":status,"id":uom_id},
        success: function(data){
                 console.log(data);
         
        }
    });
    
    
    })  
  
        $('#supplierSubCategory').DataTable({
                "bLengthChange":false,
                "pageLength": 100,
                "order": [],
                "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
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
                            url: "/Supplier/supplierSubCategoryDelete",
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
            
            $(function() {
    // Make the table rows sortable
    $("#sortable").sortable({
      
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });

            $.ajax({
                url: "/Supplier/supplierSubCatUpdateSortOrder",
                type: "POST",
                data: { order: sortOrder },
                success: function(response) {
                    console.log("Order updated successfully");
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
        }
    });
    
});  
        </script>
    </body>

</html>