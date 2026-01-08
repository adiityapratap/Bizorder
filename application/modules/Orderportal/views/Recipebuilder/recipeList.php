<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="alert alert-success fade show" role="alert" style="display:none">
                    Data Added Successfully
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 text-black">Recipe Builder</h4>

                                <div class="page-title-right">
                                    <div class="d-flex justify-content-sm-end gap-2">
                                        <a href="<?= base_url('Orderportal/Recipe/newRecipeForm') ?>" class="btn btn-primary btn">
                                            <i class="ri-add-line fs-12 align-bottom me-1"></i>Add New Recipe 
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link py-3 active" data-bs-toggle="tab" href="#recipes" role="tab">
                                        Recipes Details
                                    </a>
                                </li>
                                
                              
                            </ul>

                            <div class="tab-content p-3">
                                <div class="tab-pane table-responsive  active" id="recipes" role="tabpanel">
                                  <div class="table-responsive mb-1">  
                                  <table class="table align-middle table-nowrap listDatatable" >
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Recipe name</th>
                                                <th>Cooking time</th>
                                                <th>Difficulty</th>
                                                <th>Cost</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable">
                                            <?php if (!empty($recipes)) : ?>
                                                <?php foreach ($recipes as $recipe) : ?>
                                                    <tr id="row_<?php echo  $recipe['id']; ?>">
                                                        <td><?= $recipe['id'] ?></td>
                                                        <td><?= $recipe['recipeName'] ?></td>
                                                        <td><?= $recipe['cookingTime'] ?></td>
                                                        <td><?= $recipe['difficulty'] ?></td>
                                                        <td>$<?= number_format($recipe['totalCost'],2) ?></td>
                                                        <td>
                                                            <a href="<?= base_url('Orderportal/Recipe/viewRecipe/' . $recipe['id']) ?>" class="btn btn btn-success"><i class=" ri-eye-line label-icon align-middle fs-12 me-2"></i> View Recipe</a>
                                                            <a href="<?= base_url('Orderportal/Recipe/editRecipe/' . $recipe['id']) ?>" class="btn btn btn-secondary"><i class="ri-edit-box-line label-icon align-middle fs-12 me-2"></i> Edit</a>
                                                             <button class="btn btn btn-danger remove-item-btn "  data-rel-id="<?php echo  $recipe['id']; ?>"> <i class="ri-delete-bin-line label-icon align-middle fs-12 me-2"></i>Delete</button>
                                           
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5">No recipes found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div>
        </div><!-- container-fluid -->
    </div><!-- End Page-content -->
</div>
<script>

 $('.listDatatable').DataTable({
    pageLength: 100,
    bPaginate: false,
    bInfo: false,
    lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
    ordering: false, // Disable DataTables' ordering
    "columnDefs": [
        {
            "targets": 'no-sort',
            "orderable": false
        }
    ]
});

        
         $(document).on("click", ".remove-item-btn" , function() {
                let id = $(this).attr('data-rel-id');
               
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
                            url: 'deleteRecipe',
                            data: 'id='+id+'&tableName=recipes',
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
                url: 'updateRecipeSortOrder',
                type: "POST",
                data: { order: sortOrder },
                success: function(response) {
                    // console.log("recipe order updated successfully");
                },
                error: function() {
        
                    // console.log("Error updating order");
                }
            });
        }
    });
    
});
    </script>