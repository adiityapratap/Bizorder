<style>
    .table-card td:first-child, .table-card th:first-child {
    padding-left: 12px;
}
.table-card td:last-child, .table-card th:last-child {
    padding-right: 12px;
}
</style>
<?php $idName = $table_name.'_id'; ?>
<div class="main-content">

    <div class="page-content">
               <?php $this->load->view('general/listpageTopBg'); ?>    
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0"><?php echo $page_title; ?></h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#flipModal"> <i class="ri-add-line align-bottom me-1"></i>Add Location</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="card-body">
                       <div>
                             <?php if($this->session->flashdata('sucess_msg') != '') { ?>  
                            <div class='hideMeAlert'>
                                <p class="alert alert-success"><?php echo $this->session->flashdata('sucess_msg'); ?></p>
                            </div>
                            <?php } else if($this->session->flashdata('error_msg') != '') { ?>  
                            <div class='hideMeAlert'>
                                <p class="alert alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
                            </div>
                            <?php }else{} ?>
                        </div>
                           
                                
                                <table class="table table-striped nowrap align-middle" id="customerDataTable">
                                    <thead class="table-light">
                                                        <tr>
                                                             <th class="sort" data-sort="customer_name">ID</th>
                                                            <th class="sort" data-sort="customer_name">Location Name</th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="no-sort" >Action</th>
                                                            </tr>
                                                    </thead>
                                    <?php if(!empty($record)){ ?>
                                    <tbody class="list form-check-all">
                                        <?php foreach($record as $row){ ?>
                                        
                                         <tr id="row_<?php echo  $row['location_id']; ?>" >
                                         <td class="fs-14"><?php echo $row['location_id'] ?></td>
                                         <td class="fs-14"><?php echo $row['location_name'] ?></td>
                                         <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                    <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $row['location_id']; ?>" <?php if(isset($row['location_list_status']) && $row['location_list_status']  == '1'){ echo 'checked'; }?>>
                                                    
                                                </div>
                                            </td>
                                            
                                            
                                                           
                                                            <td>
                                                             <div class="d-flex gap-2">
                                                                    <div class="edit">
                                                                        <a  onclick="showEditModal('<?php echo $row['location_name']; ?>',<?php echo $row['location_id']; ?>)" class="btn btn-sm btn-primary edit-item-btn">View/Edit</a>
                                                                    </div>
                                                                    <!--<div class="remove">-->
                                                                    <!--    <button class="btn btn-sm btn-danger remove-item-btn "  data-rel-id="<?php echo  $row['location_id']; ?>">Remove</button>-->
                                                                    <!--</div>-->
                                                                </div>
                                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php } ?>
                                </table>
                                
                                <div class="noresult" <?php if(!empty($record)){ ?>style="display: none" <?php } else{ ?>style="display: block" <?php } ?> >
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We did not find any record for you search.</p>
                                    </div>
                                </div>
                               
                          
                           
                      
                       
                    </div>
                </div>
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
           
    </div>
       

        
    </div>
   
</div>
<div id="flipEditModal" class="modal fade flip"  role="dialog">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Location</h5>
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
                                                                    <label for="name-field" class="form-label">Location Name</label>
                                                                    <input type="hidden" id="locationIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_location_name" class="form-control" placeholder="Enter location name" required="">
                                                                <div class="invalid-feedback locationNameError" style="display:none">
                                                                    Please enter location name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-success submitButtonTill" onclick="updateLocation()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
<div id="flipModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true" style="display: none;">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Location</h5>
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
                                                                    <label for="name-field" class="form-label">Location Name</label>
                                                                    <input type="text"  name="location_name" id="location_name" class="form-control" placeholder="Enter location name" required="">
                                                                <div class="invalid-feedback locationNameError" style="display:none">
                                                                    Please enter location name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-success submitButtonTill" onclick="addLocation()">Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
<script type="text/javascript">
function showEditModal(locationName,locationId){
            $("#edited_input_location_name").val(locationName);
            $("#locationIdToUpdate").val(locationId)
           $("#flipEditModal").modal('show');
        }
function addLocation(){
            let locationName = $("#location_name").val()
            if(locationName == ''){
               $(".locationNameError").show();
               return false;
            }else{
                $(".submitButtonTill").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "Locations/add",
                 data:'locationName='+locationName,
                 success: function(data){
                    location.reload();
                }
                });
        }
 function updateLocation(){
            let locationName = $("#edited_input_location_name").val();
            
            let id = $("#locationIdToUpdate").val()
            if(locationName == ''){
               $(".locationNameError").show();
               return false;
            }else{
                $(".submitButtonTill").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "Locations/updateLocations",
                 data:'locationName='+locationName+'&id='+id,
                 success: function(data){
                    location.reload();
                }
                });
        }        
 $('.toggle-demo').on('change',function() {
         let id = $(this).attr('id');
        let status = 1;
     if($(this).prop('checked')){
          status = 1;
     }else{
          status = 0;
         
     }
     
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
         url: "Locations/changeStatus",
        data: {"status":status,"id":id},
        success: function(data){
                 console.log(data);
                 location.reload();
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
                            url: "Locations/delete",
                            data:'id='+id,
                            success: function(data){
                              $('#row_'+id).remove();
                            }
                        });
                      }
                  })
                
                
            });
    $(document).ready(function () {
            
    $('#customerDataTable').DataTable({
            pageLength: 100,
            lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
           "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
});
</script> 
<?php 
$this->session->unset_userdata('sucess_msg');
$this->session->unset_userdata('error_msg');
?>