<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Sub  Locations </h5>
                                        <div class="flex-shrink-0">
 <a href="#" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#flipModal"><i id="create-btn" class="ri-add-line align-bottom me-1"></i> Add
                                                Sub Location </a>
                                             
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="card-body pt-0">
                                
                                <table class="table table-nowrap align-middle table-responsive" id="SupplierDataTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                     <th class="sort" data-sort="Name">Sublocation Name</th>
                                                          <th class="sort" data-sort="Name">Is Production</th>
                                                        <th class="sort" data-sort="Status">Status</th>
                                                        <th class="sort" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                      <?php if(!empty($locationList)) {  ?>
                                                        <?php foreach($locationList as $sublocation){  ?>
                                                    <tr id="row_<?php echo  $sublocation['id']; ?>">
                                                        
                                                        <td class="name"><?php echo (isset($sublocation['name']) ? $sublocation['name'] : ''); ?></td>
                                                         <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-kitchen" type="checkbox" role="switch" id="<?php echo  $sublocation['id']; ?>" <?php if(isset($sublocation['is_kitchen']) && $sublocation['is_kitchen']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                         <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $sublocation['id']; ?>" <?php if(isset($sublocation['status']) && $sublocation['status']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                              
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
<a  class="text-success" href="#" onclick="showEditModal('<?php echo $sublocation['name']; ?>',<?php echo $sublocation['id']; ?>,<?php echo $sublocation['is_kitchen']; ?>,'<?php echo $sublocation['email']; ?>','<?php echo $sublocation['ccemail']; ?>','<?php echo $sublocation['comments']; ?>',<?php echo $sublocation['requireDD']; ?>,<?php echo $sublocation['location_id']; ?>)"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $sublocation['id']; ?>">
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
                                      
                                       <div id="flipModal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Sub Location</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                <label for="name-field" class="form-label">Sub Location Name</label>
                                                                    <input type="text"  name="storageAreaName" id="storageAreaName" class="form-control" placeholder="Enter Sub Location name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Sub Location name
                                                                    </div>
                                                            </div>
                              <div class="col-lg-12">
                                 <label for="name-field" class="form-label">Main Location Name</label>
                                <select class="form-select mb-3" name="mainLocationId" id="mainLocationId">
                                <option selected="">Select Main Location </option>       
                                 <?php if(!empty($mainLocationList)) { ?>
                                 <?php foreach($mainLocationList as $loc_id=>$location_name)  {   ?>       
                                 <option value="<?php echo $loc_id; ?>"><?php echo $location_name; ?> </option>
                                 <?php } ?>
                                 <?php } ?>
                                 </select>
                                 <div class="invalid-feedback mainLocationIdError" style="display:none">
                                  Please enter Main Location name
                                   </div>
                                  </div>
                                  <div class="col-lg-12">
                                  <label for="name-field" class="form-label">Is Production ?</label>
                                  <div class="form-check form-switch form-switch-custom form-switch-success">
                                  <input class="form-check-input" type="checkbox" role="switch" id="is_kitchenAdd" >
                                   </div> 
                                   </div> 
                                    <div class="col-lg-12 kitchenOptions">
                                     <label for="name-field" class="form-label">Require Delivery Date ?</label>
                                     <div class="form-check form-switch form-switch-custom form-switch-success">
                                     <input class="form-check-input" type="checkbox" role="switch" id="requireDD" >
                                     </div> 
                                     </div> 
                                     <div class="col-lg-12 kitchenOptions">
                                     <label for="name-field" class="form-label">Email</label>
                                      <input type="text"  name="email" id="email" class="form-control" placeholder="Enter Email" required="">
                                      <div class="invalid-feedback nameError" style="display:none">Please enter Email </div>
                                      </div>               
                                                             <div class="col-lg-12 kitchenOptions">
                                                                <label for="name-field" class="form-label">Cc Email</label>
                                                                    <input type="text"  name="ccemail" id="ccemail" class="form-control" placeholder="Enter Cc Email">
                                                            </div>  
                                                            
                                                            <div class="col-lg-12 kitchenOptions">
                                                                <label for="name-field" class="form-label">Comments</label>
                                                                    <input type="text"  name="comments" id="comments" class="form-control" placeholder="Enter Comments">
                                                                
                                                            </div>  
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addSubLocation()">Add </button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Sub Location</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                               <label for="name-field" class="form-label">Sub Location Name</label>
                                                                    <input type="hidden" id="areaIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_uom_name" class="form-control" placeholder="Enter Sub Location Name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Location Location Name
                                                                    </div>
                                                            </div>
                                                            
                                <div class="col-lg-12">
                                 <label for="name-field" class="form-label">Main Location Name</label>
                                <select class="form-select mb-3" name="mainLocationId" id="mainLocationIdUpdate">
                                <option>Select Main Location </option>       
                                 <?php if(!empty($mainLocationList)) { ?>
                                 <?php foreach($mainLocationList as $loc_id=>$location_name)  {   ?>       
                                 <option value="<?php echo $loc_id; ?>"><?php echo $location_name; ?> </option>
                                 <?php } ?>
                                 <?php } ?>
                                 </select>
                                 <div class="invalid-feedback mainLocationIdError" style="display:none">
                                  Please enter Main Location name
                                   </div>
                                  </div>
                                                            
                                                  <div class="col-lg-12 kitchenOptions">
                                                                 <label for="name-field" class="form-label">Require Delivery Date ?</label>
                                                           <div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="requireDD" >
                                                            </div> 
                                                             </div> 
                                                             
                                                             <div class="col-lg-12 kitchenOptions">
                                                                <label for="name-field" class="form-label">Email</label>
                                                                    <input type="text"  name="email" id="edited_email" class="form-control" placeholder="Enter Email" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Email
                                                                    </div>
                                                            </div>               
                                                             <div class="col-lg-12 kitchenOptions">
                                                                <label for="name-field" class="form-label">Cc Email</label>
                                                                    <input type="text"  name="ccemail" id="edited_ccemail" class="form-control" placeholder="Enter Cc Email">
                                                            </div>  
                                                            
                                                            <div class="col-lg-12 kitchenOptions">
                                                                <label for="name-field" class="form-label">Comments</label>
                                                                    <input type="text"  name="comments" id="edited_comments" class="form-control" placeholder="Enter Comments">
                                                                
                                                            </div>             
                                     </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="updateArea()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
                                                
         <script type="text/javascript">
         $(document).ready(function(){
            $(".kitchenOptions").hide();  
             
         })
        function showEditModal(name,Id,is_kitchen,email,ccemail,comments,requireDD,locationId){
            $("#edited_input_uom_name").val(name);
           if(is_kitchen){
                $(".kitchenOptions").show();
            $("#edited_email").val(email);
            $("#edited_ccemail").val(ccemail);
            $("#edited_comments").val(comments);
           }
           
            $('#mainLocationIdUpdate option[value="' + locationId + '"]').prop('selected', true);
            $("#areaIdToUpdate").val(Id)
           $("#flipEditModal").modal('show');
          
        }
        
        $('#is_kitchenAdd').on('change',function() {
        let is_kitchen = '';
     if($(this).prop('checked')){
         $(".kitchenOptions").show();
     }else{
         $(".kitchenOptions").hide();
         
     }
     
        });
        function addSubLocation() {
    let areaName = $("#storageAreaName").val();
    let email = $("#email").val();
    let mainLocationId = $("#mainLocationId").val();
    let ccemail = $("#ccemail").val();
    let comments = $("#comments").val();
    let requireDD = $("#requireDD").prop('checked') ? 1 : 0;
    let is_kitchen = $("#is_kitchenAdd").prop('checked') ? 1 : 0;
    
   
    if (areaName == '') {
        $(".nameError").show();
        return false;
      } else {
        $(".submitButtonLoader").html("Saving...");
    }

      $.ajax({
        type: "POST",
        url: "/Supplier/internalorder/save_sublocation/add",
        data: {
            name: areaName,
            email: email,
            location_id: mainLocationId,
            ccemail: ccemail,
            comments: comments,
            requireDD: requireDD,
            is_kitchen: is_kitchen
        },
        success: function(data) {
            location.reload();
        }
    });
    }
    
     $('.toggle-kitchen').on('change',function() {
         let sublocation_id = $(this).attr('id');
        
        let is_kitchen = '';
     if($(this).prop('checked')){
          is_kitchen = 1;
     }else{
          is_kitchen = 0;
         
     }
      console.log("status",status)
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
       url: "/Supplier/internalorder/save_sublocation/edit",
        data: {"is_kitchen":is_kitchen,"id":sublocation_id},
        success: function(data){
                 console.log(data);
         
        }
    });
    
    
    }) 

        function updateArea(){
             let areaName = $("#edited_input_uom_name").val();
             let email = $("#edited_email").val();
             let ccemail = $("#edited_ccemail").val();
             let comments = $("#edited_comments").val();
             let requireDD = $("#requireDD").prop('checked') ? 1 : 0;
             let is_kitchen = $("#is_kitchenAdd").prop('checked') ? 1 : 0;
             let mainLocationId = $("#mainLocationIdUpdate").val();
             let id = $("#areaIdToUpdate").val();
            
           
            
            if(areaName == ''){
            $(".nameError").show();
            return false;
            }else{
            $(".submitButtonLoader").html("Saving...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/internalorder/save_sublocation/edit",
                 data: {
                 name: areaName,
                 id:id,
                 email: email,
                 location_id: mainLocationId,
                 ccemail: ccemail,
                 comments: comments,
                 requireDD: requireDD
                 },
                 success: function(data){
                    location.reload();
                }
                });
        }
        
        $('.toggle-demo').on('change',function() {
         let sublocation_id = $(this).attr('id');
        
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
        url: "/Supplier/internalorder/location_delete",
        data: {"status":status,"id":sublocation_id},
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
                            url: "/Supplier/internalorder/location_delete",
                            data: {"status":'delete',"id":id},
                            success: function(data){
                               
                             $('#row_'+id).remove();
                              
                            }
                        });
                        
                    
                          
                      }
                  })
                
                
            });
        </script>                                        
                                
                                