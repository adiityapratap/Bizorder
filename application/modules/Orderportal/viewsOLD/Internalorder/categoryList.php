<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Category </h5>
                                        <div class="flex-shrink-0">
 <a href="#" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#flipModal"><i id="create-btn" class="ri-add-line align-bottom me-1"></i> Add
                                               Category </a>
                                           </div>
                                    </div>
                                </div>
                                
                                 <div class="card-body pt-0">
                                
                                 <table id="category-datatables" class="display table " style="width:100%">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th class="sort" data-sort="Name">Category Id</th>
                                                        <th class="sort" data-sort="Name">Category Name</th>
                                                        <th class="sort" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all" id="sortable">
                                                      <?php if(!empty($categoryLists)) {  ?>
                                                        <?php foreach($categoryLists as $category){  ?>
                                                      
                                                    <tr id="row_<?php echo  $category['id']; ?>">
                                                        <td class="name"><?php echo (isset($category['id']) ? $category['id'] : ''); ?></td>
                                                        <td class="name"><?php echo (isset($category['category_name']) ? $category['category_name'] : ''); ?></td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
<a  class="text-success" href="#" onclick="showEditModal('<?php echo $category['category_name']; ?>',<?php echo $category['id']; ?>)"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $category['id']; ?>">
                                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                    </a>
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
                                  </div>
                                   </div>
                                    </div>
                                     </div>
                                      </div>
                                      
                                       <div id="flipModal" class="modal fade flip modal-lg" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off" id="categoryForm">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                <label for="name-field" class="form-label">Category Name</label>
                                                                    <input type="text"  name="category_name" id="category_name" class="form-control" placeholder="Enter Category name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Category name
                                                                    </div>
                                                            </div>
                                                      </div>      

                                               </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addCategory()">Add </button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                         <form class="tablelist-form" id="updateCatForm" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                               <label for="name-field" class="form-label">Category Name</label>
                                                                    <input type="hidden" id="catIdToUpdate" name="id" value="">
                                                                    <input type="text" name="category_name" id="edited_category_name" class="form-control" placeholder="Enter Category Name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Category Name
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="updateProduct()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
                                                
         <script type="text/javascript">
     
        $(document).ready(function(){
  new DataTable("#category-datatables", {
    dom: "Bfrtip",
     "pageLength": 100,
    buttons: [
      { extend: "excel", className: "btn btn-success", text: "<i class='fas fa-file-excel'></i> Export Categories" },
    ]
  });
        });
        function showEditModal(name,Id){
           // fetch product data like sub and par Lebel
          $("#catIdToUpdate").val(Id); 
         $("#edited_category_name").val(name); 
         $("#flipEditModal").modal('show');
        }
        function addCategory(){
            let data1 = $('#categoryForm').serialize();
            $(".submitButtonLoader").html("Saving...")
            $.ajax({
            type: "POST",
        	enctype: 'multipart/form-data',
        	url: '/Supplier/internalorder/addCategory',
        	data: data1,
        	success: function(response){
            $(".submitButtonLoader").html("Add");
            if(response=='success'){
             location.reload();   
            }
            
        	}
        });
        }
        
        function updateProduct(){
            let data1 = $('#updateCatForm').serialize();
            $(".submitButtonLoader").html("Saving...")
            $.ajax({
            type: "POST",
        	enctype: 'multipart/form-data',
        	url: '/Supplier/internalorder/updateCategory',
        	data: data1,
        	success: function(response){
            $(".submitButtonLoader").html("Add");
            if(response=='success'){
             location.reload();   
            }
        	}
        });
        }
        
       
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
                            url: "/Supplier/internalorder/product_delete",
                            data: {"status":'delete',"id":id,"table":'SUPPLIERS_internalOrderCategory'},
                            success: function(data){
                               
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
                url: "/Supplier/internalorder/productUpdateSortOrder",
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
                                
                                