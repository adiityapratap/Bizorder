 <div class="container-fluid" style="margin-top: 130px !important;">
 <div class="row" >
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Notifications</h5>
                                        <div class="flex-shrink-0">
                                           
                                             <button class="btn btn-soft-danger fs-14" onClick="deleteMultipleNotification()"><i class="ri-delete-bin-6-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="card-body pt-0">
                               
                                        
                                       <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-3 Cancelled active" data-bs-toggle="tab"
                                                    href="#cancelledUserTab" role="tab" aria-selected="false">
                                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Read
                                                </a>
                                            </li>
                                            
                                            <li class="nav-item">
                                                <a class="nav-link py-3" data-bs-toggle="tab" href="#activeuserTab" role="tab" aria-selected="false">
                                                    <i class="ri-store-2-fill me-1 align-bottom"></i> UnRead   
                                                </a>
                                            </li>
                                           
                                           
                                            
                                        </ul>
                                        
                                          
                                        <div class="tab-content  text-muted"> 
                                         <div class="tab-pane " id="activeuserTab" role="tabpanel">
                                        <div class="table-responsive table-card mb-1">
                                            <table class="table table-nowrap align-middle" id="unreadNotificationTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" style="width: 25px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="id">Description</th>
                                                        <th class="sort" data-sort="customer_name">Location</th>
                                                        <th class="sort" data-sort="product_name">System</th>
                                                        <th class="sort" data-sort="date">Date & Time</th>
                                                        <th class="sort" data-sort="city">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php if(!empty($unreadNotifications)) {   ?>
                                                     <?php foreach($unreadNotifications as $unreadNotification) { ?>
                                                     <?php $locationNames = fetchLocationNamesFromIds($unreadNotification['location_id'],true);    ?>
                                                    <?php $systemName= fetchSystemNameFromId($unreadNotification['system_id']);  ?>
                                                   
                                                    <tr class="recordRow" data-delete-Id="<?php echo $unreadNotification['id'] ?>">
                                                       <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="<?php echo $unreadNotification['id'];  ?>">
                                                            </div>
                                                        </th>
                                                        <td class="id"><?php echo $unreadNotification['title'];  ?></td>
                                                        
                                                        <td class="product_name"><?php echo $locationNames;  ?></td>
                                                        <td class="product_name"><?php echo $systemName;  ?></td>
                                                        <td class="amount"><?php echo date('d-m-Y h:i A', strtotime($unreadNotification['date'] . ' ' . $unreadNotification['time']));  ?></td>

                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                               
                                                            <?php  if(isset($rolename) && $rolename !='Admin') { ?>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                        <a class="text-danger d-inline-block remove-item-btn"  data-bs-toggle="modal" data-rel-id="<?php echo $unreadNotification['id'];  ?>"><i class="ri-delete-bin-5-fill fs-16" ></i></a>
                                                                </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <?php }  ?>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                           
                                        </div>
                                        </div>
                                        <div class="tab-pane active" id="cancelledUserTab" role="tabpanel">
                                         <div class="table-responsive table-card mb-1 cccc">
                                            <table class="table table-nowrap align-middle" id="readNotificationTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" style="width: 25px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                         <th class="sort" data-sort="id">Description</th>
                                                        <th class="sort" data-sort="customer_name">Location</th>
                                                        <th class="sort" data-sort="product_name">System</th>
                                                        <th class="sort" data-sort="date">Date & Time</th>
                                                        <th class="sort" data-sort="city">Action</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php if(!empty($readNotifications)) {  ?>
                                                     <?php foreach($readNotifications as $readNotification) {  ?>
                                                     <?php $locationNames = fetchLocationNamesFromIds($readNotification['location_id'],true);  ?>
                                                    <?php $systemName= fetchSystemNameFromId($readNotification['system_id']);  ?>
                                                    <tr class="recordRow" data-delete-Id="<?php echo $readNotification['id'] ?>">
                                                       <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input checkAll checkbox-item" type="checkbox" name="checkAll" value="<?php echo $readNotification['id'];  ?>">
                                                            </div>
                                                        </th>
                                                        
                                                        <td class="customer_name"><?php echo $readNotification['title'];  ?></td>
                                                        <td class="product_name"><?php echo $locationNames;  ?></td>
                                                        <td class="product_name"><?php echo $systemName;  ?></td>
                                                        <td class="amount"><?php echo date('d-m-Y h:i A', strtotime($readNotification['date'] . ' ' . $readNotification['time']));  ?></td>
                                                        </td>
                                                       
                                                    </tr>
                                                    <?php }  ?>
                                                    <?php }  ?>
                                                </tbody>
                                            </table>
                                          
                                        </div>
                                        </div>
                                        </div>
                                         
                                    
                                   
                                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="text-black">You are about to delete a User ?</h4>
                                                        <p class="text-black fs-15 mb-4">Deleting your user will remove
                                                            all of
                                                            the information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                                <input class="deletedRecordId" type="hidden">
                                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
</div>

<div class="modal fade flip" id="deleteMultipleChecklist" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                        trigger="loop" colors="primary:#405189,secondary:#f06548"
                                                        style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="text-black">You are about to delete multiple notification </h4>
                                                        <p class="fs-15 mb-4 text-black">Deleting notification will remove
                                                            all of
                                                            the information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button
                                                                class="btn btn-link link-success fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal"><i
                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                            <button class="btn btn-danger" value="" onclick="deleteMultipleNotification()">Yes,
                                                                Delete It</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<script>

$('#readNotificationTable').DataTable({
                lengthChange: false,
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
        $('#unreadNotificationTable').DataTable({
                lengthChange: false,
                "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false
                }]
        });
function deleteMultipleNotification(){
  $("#deleteMultipleChecklist").modal('show');  
}

function deleteMultipleNotification(){
    let selectedValues = [];
   $('.checkbox-item:checked').each(function() {
            selectedValues.push($(this).val());
        });
        
      if (selectedValues.length > 0) {
            $.ajax({
                url: '/Checklist/deleteMultiple',
                type: 'POST',
                data: { 
                    table_name: 'Global_users', 
                    selected_values: selectedValues 
                },
                success: function(response) {
                  $("#deleteMultipleChecklist").modal('hide'); 
                  for (var i = 0; i < selectedValues.length; i++) {
                  let id = selectedValues[i];
                  $('#row_'+id).remove();
                  }
                   
                }
            });
        } else {
            alert('No checkboxes selected.');
        }        
          
}


       
function revertTheUser(obj,user_id){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/auth/revertUser/"+user_id,
                success: function(){
                 // console.log("user reverted");
                 $(obj).parents(".recordRow").remove();
                }
                });  
}

$('#delete-record').click(function(){
    
     let deleteId =  $(".deletedRecordId").val();
  
               $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/general/record_delete",
                data:'id='+deleteId+'&table_name=Global_notification',
                success: function(data){
                //   location.reload();
                  if(data == 'deleted'){
                    $("tr[data-delete-id='" + deleteId + "']").remove();
                  }
                   $("#deleteOrder").modal('hide');
                }
                });
   
    
});
$('.remove-item-btn').click(function(){
    $("#deleteOrder").modal('show');
    let id = $(this).attr('data-rel-id');
    // console.log("id",id)
    $(".deletedRecordId").val(id);
    $(this).closest('.recordRow').attr("data-delete-Id", id);
    
     
});
</script>