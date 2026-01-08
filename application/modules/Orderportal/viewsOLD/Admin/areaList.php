<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Storage Locations </h5>
                                        <div class="flex-shrink-0">
 <a href="#" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#flipModal"><i id="create-btn" class="ri-add-line align-bottom me-1"></i> Add
                                                Storage Location </a>
                                           
                                           
                                          
                                        </div>
                                    </div>
                                </div>
                                
                                 <div class="card-body pt-0">
                                
                                <table class="table table-nowrap align-middle table-responsive" id="SupplierDataTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                      
                                                    
                                                        <th class="sort" data-sort="Name">Storage Location Name</th>
                                                         <th class="sort" data-sort="Name">Supplier Name</th>
                                                        <th class="sort" data-sort="Status">Status</th>
                                                        <th class="sort" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                      <?php if(!empty($areaList)) {  ?>
                                                        <?php foreach($areaList as $area){  ?>
                                                        <?php $sids = unserialize($area['supplier_ids']);  ?>
                                                    <tr id="row_<?php echo  $area['id']; ?>">
                                                        
                                                      
                                                        <td class="name"><?php echo (isset($area['name']) ? $area['name'] : ''); ?></td>
                                                         <td class="name">
                                                             <?php if(!empty($suppliers_list)){ ?>
                                                                <?php foreach($suppliers_list as $sup) {  ?>
                                                          <?php if(is_array($sids) && in_array($sup['supplier_id'],$sids)) {   
                                                          echo $sup['supplier_name'].",";
                                                          ?>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } ?>
                                                         </td>
                                                         <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $area['id']; ?>" <?php if(isset($area['status']) && $area['status']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                              
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
                                                                    <a  class="text-success" href="#" onclick="showEditModal('<?php echo $area['name']; ?>',<?php echo $area['id']; ?>)"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $area['id']; ?>">
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Storage Location</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                               
                                                                <div>
                                                                    <label for="name-field" class="form-label">Storage Location Name</label>
                                                                    <input type="text"  name="storageAreaName" id="storageAreaName" class="form-control" placeholder="Enter Storage Location name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Storage Location name
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                  
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonLoader" onclick="addArea()">Add </button>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Storage Location</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                               <label for="name-field" class="form-label">Storage Location Name</label>
                                                                    <input type="hidden" id="areaIdToUpdate" value="">
                                                                    <input type="text" id="edited_input_uom_name" class="form-control" placeholder="Enter Area name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Storage Location name
                                                                    </div>
                                                            </div>
                                                            
                                                    <!--<div class="col-lg-12 col-md-12">-->
                                                    <!--    <div class="mb-3">-->
                                                    <!--        <label for="choices-multiple-remove-button" class="form-label text-black">Assign Suppliers</label>-->
                                                    <!--       <p class="text-black">  <small>click in the box or type the name of suppliers</small></p>-->
                                                    <!--        <select class="form-control"  name="supplier_ids[]" id="supplier_ids" data-choices data-choices-removeItem name="choices-multiple-remove-button"  multiple>-->
                                                    <!--             <?php if(!empty($suppliers_list)){ ?>-->
                                                    <!--            <?php foreach($suppliers_list as $sup) {  ?>-->
                                                    <!--            <option value="<?php echo $sup['supplier_id']; ?>"><?php echo $sup['supplier_name']; ?></option>-->
                                                    <!--              <?php }} ?>-->
                                                    <!--        </select>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                            
                                                           
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-green submitButtonTill" onclick="updateArea()">Save </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
                                                
         <script type="text/javascript">
        function showEditModal(name,Id){
            $("#edited_input_uom_name").val(name);
            $("#areaIdToUpdate").val(Id)
           $("#flipEditModal").modal('show');
          
        }
        function addArea() {
    let areaName = $("#storageAreaName").val();
    let supplierIds = $('#supplier_idsAdd').val(); 

    if (areaName == '') {
        $(".nameError").show();
        return false;
      } else {
        $(".submitButtonLoader").html("Loading...");
    }

      $.ajax({
        type: "POST",
        url: "/Supplier/save_area/add",
        data: {
            name: areaName,
            supplier_ids: supplierIds
        },
        success: function(data) {
            location.reload();
        }
    });
    }

        function updateArea(){
            let areaName = $("#edited_input_uom_name").val();
            let supplierIds = $('#supplier_ids').val();
          console.log("supplierIds",supplierIds)
            let id = $("#areaIdToUpdate").val()
            if(areaName == ''){
               $(".nameError").show();
               return false;
            }else{
                $(".submitButtonLoader").html("Loading...")
            }
            $.ajax({
                 type: "POST",
                 url: "/Supplier/save_area/edit",
                 data: {
                 name: areaName,
                 id:id,
                 supplier_ids: supplierIds
                 },
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
        url: "/Supplier/area_delete",
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
                            url: "/Supplier/area_delete",
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
                                
                                