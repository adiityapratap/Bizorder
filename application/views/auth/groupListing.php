<div class="container-fluid" style="margin-top: 0 !important;">
            
                       <div class="row ">
                            <div class="col-lg-12">
                             
                                
                                 <div class="card">
                                  <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Roles</h5>
                                        <div class="flex-shrink-0">
                                            <a type="button" class="btn btn-primary add-btn" 
                                                id="create-btn" href="<?php echo base_url('auth/create_group') ?>"><i
                                                    class="ri-add-line align-bottom me-1"></i> Create Role
                                                </a>
                                           
                                          
                                        </div>
                                    </div>
                                </div>

                                    <div class="card-body">
                                        
                                        <!-- Search Section - Right aligned -->
                                        <div class="mb-3 d-flex justify-content-end">
                                            <form>
                                                <div class="row g-3">
                                                    <div class="col-auto" style="min-width: 350px;">
                                                        <div class="search-box">
                                                            <input type="text" class="form-control search" id="roleSearch"
                                                                placeholder="Search for Role name, Description or Status...">
                                                            <i class="ri-search-line search-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div id="tillList">
                                            <div class="table-responsive mb-1">
                                                <table class="table align-middle table-nowrap" id="tillListDatatable">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            
                                                            <th class="sort" data-sort="customer_name">Role Name</th>
                                                            <th class="sort" data-sort="customer_name">Description</th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                                     <tbody class="list form-check-all">
                                                        <?php if(!empty($groups)) {  ?>
                                                        <?php foreach($groups as $group){  ?>
                                                        <tr id="row_<?php echo  $group['id']; ?>" >
                                                        <td class="customer_name"><?php echo $group['name']; ?></td>
                                                        <td class="description"><?php echo $group['description']; ?></td>    
                                                            
                                                            
                                                            <td class="text-start">
                                            <?php if (!in_array($group['id'], [1, 2, 3, 4])) { ?>
                                                <div class="form-check form-switch form-switch-custom form-switch-success">
                                                    <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $group['id']; ?>" <?php if(isset($group['status']) && $group['status']  == '1'){ echo 'checked'; }?>>
                                                </div>
                                                 <?php } else { ?>
                                                    <span class="badge bg-success-subtle text-success">Active</span>
                                                 <?php } ?>
                                            </td>
                                            
                                            
                                                           
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                                    <div class="edit">
                                                                        <a  href="<?php echo base_url('auth/edit_group/'.$group['id']) ?>" class="btn btn-sm btn-info edit-item-btn">Edit</a>
                                                                    </div>
                                                                    <?php if (!in_array($group['id'], [1, 2, 3, 4])) { ?>
                                                                    <div class="remove">
                                                                        <button class="btn btn-sm btn-danger remove-item-btn " onclick="deleteThisRole(this,<?php echo  $group['id']; ?>)">Remove</button>
                                                                    </div>
                                                                    <?php } ?>
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
                                    </div><!-- end card -->
                                </div>
                                 </div>
                        </div>

                        
                        </div>
 <div class="modal fade flip" id="deleteRolelist" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="text-black">You are about to delete a Role ?</h4>
                                                        <p class="fs-15 mb-4 text-black">Deleting role will remove
                                                            all of
                                                            the information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                            <button class="btn btn-danger" value="" id="delete-record">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                  
       
        <script>
function deleteThisRole(obj,roleId){
    $("#deleteRolelist").modal('show');
    $("#delete-record").val(roleId);
    
}
 $(document).on("click", "#delete-record" , function() {
     let id = $(this).val();
       $.ajax({
         type: "POST",
         url: "/auth/delete_group",
         data:'id='+id,
          success: function(data){
          $('#row_'+id).remove();
          $("#deleteRolelist").modal('hide');
           }
          });
            });
            
      var table = $('#tillListDatatable').DataTable({
                pageLength: 100,
                bPaginate: false,
                bInfo : false,
                dom: 'rt', // Remove default search box
                lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
        
        // Custom search functionality
        $('#roleSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
        
        function clearSearch() {
            $('#roleSearch').val('');
            table.search('').draw();
        }
        
        function showEditModal(tillName,tillId){
            $("#edited_input_name").val(tillName);
            $("#tillIdToUpdate").val(tillId)
           $("#flipEditModal").modal('show');
        }
        function addTill(){
            let tillName = $("#input_name").val()
            if(tillName == ''){
               $(".tillNameError").show();
               return false;
            }else{
                $(".submitButtonTill").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "Tills/add",
                 data:'name='+tillName,
                 success: function(data){
                    location.reload();
                }
                });
        }
        function updateTill(){
            let tillName = $("#edited_input_name").val();
            // console.log("edited_input_name",edited_input_name)
            let id = $("#tillIdToUpdate").val()
            if(tillName == ''){
               $(".tillNameError").show();
               return false;
            }else{
                $(".submitButtonTill").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "Tills/updateTill",
                 data:'name='+tillName+'&id='+id,
                 success: function(data){
                    location.reload();
                }
                });
        }
        
        $(document).ready(()=>{
            setTimeout(()=>{
              $(".alert-success").fadeOut();   
            },7000);
        })
        $('.toggle-demo').on('change',function() {
         let role_id = $(this).attr('id');
         let status = 1;
         if($(this).prop('checked')){
          status = 1;
          }else{
          status = 0;
         }
     
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
        url: "/General/updateChecklistStatus",
        data: {
            id: role_id,
            status: status,
            table_name : 'Global_roles'
            },
        success: function(data){
        // console.log(data);
        }
    });
    
    
    })   
        </script>
 