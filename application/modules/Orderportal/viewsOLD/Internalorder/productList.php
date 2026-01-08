<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Manage Products </h5>
                                        <div class="row d-flex">
    <div class="col-3">                                         
   <a href="<?php echo base_url('Supplier/internalorder/productsSample'); ?>" class="btn btn-warning add-btn"><i id="create-btn" class="ri-file-download-line align-bottom me-1"></i> Download Sample </a>
   </div><div class="col-4"> 
   <form action="<?= base_url('Supplier/internalorder/importProduct'); ?>" method="post" enctype="multipart/form-data" class="d-flex gap-3">
            <div class="col-sm">
            <input type="file" name="file" id="file" class="form-control" required>
         </div> 
         <div class="col-sm">
          <button type="submit" class="btn btn-success"><i class="ri-file-excel-fill me-1 align-bottom"></i>Import</button>
            </div>       
              </form>
          </div><div class="col-3">                                       
 <a href="#" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#flipModal"><i id="create-btn" class="ri-add-line align-bottom me-1"></i> Add
                                               Product </a>
                                               </div> 
                                          </div>
                                    </div>
                                </div>
                                
                                 <div class="card-body pt-0">
                                <div class=" table-responsive">
                                <table class="table table-nowrap align-middle" id="productDataTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                      
                                                         <th class="sort" data-sort="Name">Product Name</th>
                                                         <th class="sort" data-sort="UOM">UOM</th>
                                                         <th class="sort" data-sort="Name">Category Name</th>
                                                         <th class="sort" data-sort="Name">Price</th>
                                                          <th class="sort" data-sort="Name">Sub Location Name</th>
                                                          <th class="sort" data-sort="Name">PAR Level</th>
                                                        <th class="sort" data-sort="Status">Status</th>
                                                        <th class="sort" data-sort="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all" id="sortable">
                                                      <?php if(!empty($productList)) {  ?>
                                                        <?php foreach($productList as $product){  ?>
                                                      
                                                    <tr id="row_<?php echo  $product['id']; ?>">
                                                        
                                                      
                                                        <td class="name"><?php echo (isset($product['name']) ? $product['name'] : ''); ?></td>
                                                        <?php $key = array_search($product['uom'], array_column($uomLists, 'product_UOM_id'));  ?>
                                                        <td class="product_UOM_name"><?php echo ($key !== false) ? $uomLists[$key]['product_UOM_name'] : ""; ?></td>
                                                        <td class="category_name"><?php echo (isset($product['category_name']) ? $product['category_name'] : ''); ?></td> 
                                                        <td class="price"><?php echo (isset($product['price']) ? '$'.number_format($product['price'],2) : ''); ?></td> 
                                                          <?php $sublocIDSWithParLevel = json_decode($product['sublocation_id'],true);  ?>
                                                          <?php $idToNameMapping = array_column($locationList, 'name', 'id'); ?>
                                                          <?php
                                                          $sublocIDS = array_keys($sublocIDSWithParLevel);
                                                          $parLevels = implode(', ', array_values($sublocIDSWithParLevel));
                                                         
                                                          $namesForResultingArray = array_map(function ($id) use ($idToNameMapping) {
                                                            return isset($idToNameMapping[$id]) ? $idToNameMapping[$id] : 'Unknown';
                                                             }, $sublocIDS);
                                                          
                                                          ?>
                                                           <td class="name"><?php echo (isset($sublocIDS) && !empty($sublocIDS) ? implode(', ', $namesForResultingArray) : ''); ?></td>
                                                            <td class="name"><?php echo (isset($parLevels) ? $parLevels : ''); ?></td>
                                                         <td><div class="form-check form-switch form-switch-custom form-switch-success">
                                                            <input class="form-check-input toggle-demo" type="checkbox" role="switch" id="<?php echo  $product['id']; ?>" <?php if(isset($product['status']) && $product['status']  == '1'){ echo 'checked'; }?>>
                                                            </div>
                                                           </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                              
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Edit">
<a  class="text-success" href="#" onclick="showEditModal('<?php echo $product['name']; ?>',<?php echo $product['id']; ?>,<?php echo (isset($product['par_level']) ? $product['par_level'] :'0'); ?>,<?php echo $product['category_id']; ?>,<?php echo $product['price']; ?>)"  class="text-primary d-inline-block edit-item-btn">
                                                                        <i class="ri-pencil-fill fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                                    data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" 
                                                                        href="#deleteOrder" data-rel-id="<?php echo  $product['id']; ?>">
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
                                      </div>
                                      
                                       <div id="flipModal" class="modal fade flip modal-lg" tabindex="-1" aria-labelledby="flipModalLabel">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off" method="post" action="<?php echo base_url('/Supplier/internalorder/save_product/add') ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-4">
                                                                <label for="name-field" class="form-label">Product Name</label>
                                                                    <input type="text"  name="productName" id="productName" class="form-control" placeholder="Enter Product name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Product name
                                                                    </div>
                                                            </div>
                                             <div class="col-lg-2">
                                           <label for="category_idP" class="form-label fw-semibold">UOM</label>  
                                             <select class="form-select" name="uom" id="uom">
                                             <?php if(isset($uomLists) && !empty($uomLists)) {  ?>  
                                             <?php foreach($uomLists as $uomList) {  ?>
                                              <option  value="<?php echo $uomList['product_UOM_id'] ?>"><?php echo $uomList['product_UOM_name']; ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                             </select>
                                             </div>                
                                            <div class="col-lg-2">
                                            <label for="product_price" class="form-label">Product Price</label>
                                             <input type="text" name="price" id="product_price" class="form-control" required="">
                                             </div>                
                                            <div class="col-md-4">
                                              <label for="category_idP" class="form-label fw-semibold">Category *</label>  
                                             <select class="form-select" name="category_id" id="category_idP">
                                             <?php if(isset($categoryLists) && !empty($categoryLists)) {  ?>  
                                             <?php foreach($categoryLists as $category) {  ?>
                                              <option  value="<?php echo $category['id'] ?>"><?php echo $category['category_name']; ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                             </select>
                                            </div>
                                                           
                                                      </div>      
                                            <div class="row d-flex  mt-2"> 
                                            
                                            <div class="col-md-6">
                                              <label for="role_id" class="form-label fw-semibold">Sub Location *</label>  
                                             <select class="form-select ssss" name="subLocId[]">
                                             <?php if(isset($locationList) && !empty($locationList)) {  ?>  
                                             <?php foreach($locationList as $location) {  ?>
                                              <option  value="<?php echo $location['id'] ?>"><?php echo $location['name']; ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                             </select>
                                            </div>
                                              
                                             <div class="col-md-3">
                                               <label for="role_id" class="form-label fw-semibold">PAR Level *</label>     
                                              <input type="number" name="par_level[]" class="form-control" placeholder="PAR Level" autocomplete="off" required />   
                                            </div>  
                                            <div class="col-md-1">
                                            <button class="btn btn-success add-row mt-4" type="button">+</button>
                                               </div>               
                                                </div>  
                                            <div class="row mt-3">
                                                <div class="col-lg-6 col-sm-12">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" name="requireTemp" >
                                                        <label class="form-check-label" for="requireTemp">Require Temperature</label>
                                                    </div>  
                                                 </div> 
                                                 
                                                  <div class="col-lg-6 col-sm-12">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" name="requireAttach">
                                                        <label class="form-check-label" for="requireAttach">Require Attachment</label>
                                                    </div>  
                                                 </div>     
                                               </div>
                                               </div>
                                                    <div class="modal-footer" style="display: block;">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-green submitButtonLoader" >Add </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                                </div>
             <div id="flipEditModal" class="modal fade flip modal-lg"  role="dialog">
                                                   <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                         <form class="tablelist-form" id="updateProductForm" autocomplete="off" method="post" action="<?php echo base_url('/Supplier/internalorder/save_product/edit') ?>">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field">
                                                        <div class="row g-3">
                                                            <div class="col-lg-4">
                                                               <label for="name-field" class="form-label">Product Name</label>
                                                                    <input type="hidden" id="productIdToUpdate" name="productIdToUpdate" value="">
                                                                    <input type="text" name="productName" id="edited_input_uom_name" class="form-control" placeholder="Enter Product Name" required="">
                                                                <div class="invalid-feedback nameError" style="display:none">
                                                                    Please enter Product Name
                                                                    </div>
                                                            </div>
                                                             <div class="col-lg-2">
                                           <label for="category_idP" class="form-label fw-semibold">UOM</label>  
                                             <select class="form-select" name="uom" id="uom">
                                             <?php if(isset($uomLists) && !empty($uomLists)) {  ?>  
                                             <?php foreach($uomLists as $uomList) {  ?>
                                              <option  value="<?php echo $uomList['product_UOM_id'] ?>"><?php echo $uomList['product_UOM_name']; ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                             </select>
                                             </div>  
                                                            
                                                            <div class="col-lg-2">
                                                               <label for="edited_price" class="form-label">Product Price</label>
                                                                <input type="text" name="price" id="edited_price" class="form-control" required="">
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                              <label for="category_id_update" class="form-label fw-semibold">Category *</label>  
                                             <select class="form-select" name="category_id" id="category_id_update">
                                             <?php if(isset($categoryLists) && !empty($categoryLists)) {  ?>  
                                             <?php foreach($categoryLists as $category) {  ?>
                                              <option  value="<?php echo $category['id'] ?>"><?php echo $category['category_name']; ?></option>
                                             <?php } ?>
                                             <?php } ?>
                                             </select>
                                            </div>
                                                                 
                                                       <div class="appendSubLocPar">     
                                                 
                                                                           
                                                        </div>      
                                                          
                                                        </div>
                                                        
                                                        <div class="row mt-3">
                                                <div class="col-lg-6 col-sm-12">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requireTemp" name="requireTemp" >
                                                        <label class="form-check-label" for="requireSC">Require Temperature</label>
                                                    </div>  
                                                 </div> 
                                                 
                                                  <div class="col-lg-6 col-sm-12">  
                                               <div class="form-check form-switch  form-switch-success form-switch-lg" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="requireAttach" name="requireAttach">
                                                        <label class="form-check-label" for="requireMST">Require Attachment</label>
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
        $(document).ready(function () {
             locationList = <?php echo json_encode($locationList) ?>;
            // Add new row on plus button click
            $('form').on('click', '.add-row', function () {
    let newRow = '<div class="row d-flex  mt-2">';
    newRow += '<div class="col-md-6">';
    newRow += '<select class="form-select ssss" name="subLocId[]">';
    <?php if (isset($locationList) && !empty($locationList)) { ?>
        <?php foreach ($locationList as $location) { ?>
            newRow += '<option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>';
        <?php } ?>
    <?php } ?>
    newRow += '</select>';
    newRow += '</div>';
    newRow += '<div class="col-md-3"><input type="number" name="par_level[]" class="form-control" placeholder="PAR Level" autocomplete="off"  />';
    newRow += '</div><div class="col-md-3"><button type="button" class="btn btn-success add-row">+</button><a href="#" class="btn btn-danger removeCurrentrow mx-1">-</a></div></div>';
    $(this).closest('.row').after(newRow);
});

            // Remove row on minus button click
  $('form').on('click', '.removeCurrentrow', function (e) {
    e.stopPropagation(); // Prevent event propagation
    $(this).closest('.row').remove();
});

        });
         
        
        function showEditModal(name,Id,par_level,category_id,price){
           // fetch product data like sub and par Lebel
           
         $.ajax({
        type: "POST",
        url: "/Supplier/internalorder/fetchProductData",
        data: {
            id: Id,
        },
        success: function(response) {
            let jsonObject = JSON.parse(response);
           
            if (jsonObject[0].sublocation_id && typeof jsonObject[0].sublocation_id === 'string') {
                
            sublocation_idWithParLevel= JSON.parse(jsonObject[0].sublocation_id);
            
            $(".appendSubLocPar").html('');
         for (let subLocId in sublocation_idWithParLevel) {   
              let newRow = '<div class="row d-flex  mt-2"><div class="col-md-6">';
             newRow += '<select class="form-select ssss" name="subLocId[]">';
            
            let parLevel = sublocation_idWithParLevel[subLocId]; 
          
           locationList.forEach(locationData => { 
          
            if(locationData?.id == subLocId){
            newRow += '<option selected value="' + locationData?.id + '">' + locationData?.name + '</option>';    
            }else{
           newRow += '<option value="' + locationData?.id + '">' + locationData?.name + '</option>';     
            }
            
           });
           newRow += '</select>';
           newRow += '</div>';
           newRow += '<div class="col-md-3"><input type="number" name="par_level[]" value='+parLevel+' class="form-control" placeholder="PAR Level" autocomplete="off"  />';
           newRow += '</div><div class="col-md-3"><button type="button" class="btn btn-success add-row">+</button><button type="button" class="btn btn-danger removeCurrentrow mx-1">-</button></div></div>';
           $(".appendSubLocPar").append(newRow)        
            }
        
            }
            
            if (jsonObject[0].requireAttach && typeof jsonObject[0].requireAttach === 'string') {
                let isrequireAttach  = jsonObject[0].requireAttach;
              console.log("jsonObject attach",isrequireAttach);
              $('#requireAttach').prop('checked', isrequireAttach == 1 ? true : false);

            } 
            
             if (jsonObject[0].requireTemp && typeof jsonObject[0].requireTemp === 'string') {
              let requireTemp  = jsonObject[0].requireTemp;
              console.log("jsonObject requireTemp",requireTemp);
              $('#requireTemp').prop('checked', requireTemp == 1 ? true : false);
            }
           
            
        }
    });
        $('#category_id_update').each(function() {
        $(this).val(category_id).change();
        });
             
            $("#edited_input_uom_name").val(name);
            $("#edited_price").val(price);
            $("#edited_parlevel").val(par_level);
            // $('select[name="subLocIdSelected[]"]').val(selectedValues);
         
            $("#productIdToUpdate").val(Id)
           $("#flipEditModal").modal('show');
          
        }
        
        function updateProduct(){
             let areaName = $("#edited_input_uom_name").val();
            $(".submitButtonLoader").html("Saving...")
            if(areaName == ''){
               $(".nameError").show();
               $(".submitButtonLoader").html("Update")
               return false;
            }else{
                
                $("#updateProductForm").submit();
            }
            
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
        url: "/Supplier/internalorder/product_delete",
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
                            url: "/Supplier/internalorder/product_delete",
                            data: {"status":'delete',"id":id,"table":'SUPPLIERS_internalOrderProducts'},
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
 $(document).ready(function() {
        $('#productDataTable').DataTable({
            "columnDefs": [
                { "orderable": true, "targets": [2] } // Assuming Column 3 (index 2) is the third column you want to sort by
            ],
            "pageLength": 1000,
            "order": [[2, 'desc']] // Sort by Column 3 (index 2) in ascending order
        });
    });
        </script>                                        
                                
                                