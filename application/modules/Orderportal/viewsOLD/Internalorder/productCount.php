<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
              <div class="alert alert-danger shadow mb-xl-0 alertMessage d-none" role="alert">
                  <strong class="appendMessage"></strong>
                 </div>    
             <form  action="/Supplier/internalorder/saveInternalOrder" method="POST" id="orderForm"> 
             <input type="hidden" name="selectedSubLocationId" class="selectedSubLocationId" value="<?php echo (isset($selectedSubLoc) && $selectedSubLoc !='' ? $selectedSubLoc : '');  ?>">
             <input type="hidden" name="email" id="email">
            <input type="hidden" name="ccemail" id="ccemail" >
            <input type="hidden" name="comments" id="comments">        
            <input type="hidden" name="delivery_date" id="delivery_date">       
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                             <div class="card mt-2">
                             
                         <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Product Count </h5>
                                        <div class="flex-shrink-0">
                               <a href="#" onclick="history.back();" class="btn bg-orange waves-effect btn-label waves-light"><i class="ri-reply-fill label-icon align-middle fs-16 me-2"></i><span>Back</span></a>                                                
                                 <button type="button" name="saveAndReturn" onclick="saveAndReturnForm()" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Save & Return</span></button>
                                <button type="button" onclick="saveAndPlaceOrder()" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Finish Count</span></button>
                                </div>
                                    </div>
                                </div>     
                              
                              <div class="card-body">
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <?php if(isset($locationList) && !empty($locationList)) { $count = 0; ?>
                                        <?php foreach($locationList as $location) { ?>
                                       <?php 
                                        if(isset($selectedSubLoc) && $selectedSubLoc !=''){
                                         if($location['id'] == $selectedSubLoc){
                                           $className = 'active';   
                                         } else{
                                           $className = '';  
                                         }  
                                        }else if($count == 0){
                                         $className = 'active'; 
                                        }else{
                                        $className = '';    
                                        }
                                        ?>
                                        <li class="nav-item navItemForSubId" data-id="<?php echo $location['id']; ?>">
                                            <a class="navAnchor nav-link <?php echo $className; ?>" data-id="<?php echo $location['id']; ?>" data-bs-toggle="tab" href="#location<?php echo $location['id']; ?>" role="tab" aria-selected="false">
                                            <?php echo $location['name']; ?>     
                                            </a>
                                        </li>
                                        <?php $count++; } } ?>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content  text-muted">
                                        <?php if(isset($locationList) && !empty($locationList)) {   $count = 0; ?>
                                        <?php foreach($locationList as $location) { ?> 
                                        <?php
                                        if(isset($selectedSubLoc) && $selectedSubLoc !=''){
                                         if($location['id'] == $selectedSubLoc){
                                           $className = 'active';   
                                         } else{
                                           $className = '';  
                                         }  
                                        }else if($count == 0){
                                         $className = 'active'; 
                                        }else{
                                        $className = '';    
                                        }
                                        ?>
                                        <div class="tab-pane <?php echo $className; ?>" id="location<?php echo $location['id']; ?>" role="tabpanel">
        <div class="row">
        <div class="col">
            <input type="text" id="searchInput" class="form-control" placeholder="Search category...">
        </div>
       </div>
                                              <table class="table table-nowrap align-middle table-responsive">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                         <th class="sort" data-sort="Name">Product Name</th>
                                                         <th class="sort" data-sort="Name">UOM</th>
                                                          <th class="sort" data-sort="Name">PAR Level</th>
                                                          <th class="sort" data-sort="Name">Price</th>
                                                          <th class="sort" data-sort="Name">Remaining</th>
                                                        <th class="sort" data-sort="Status">Qty To Make</th>
                                                       
                                                    </tr>
                                                </thead>
                                                 <?php if(isset($categoryLists) && !empty($categoryLists)) {  ?>  
                                                 <?php foreach($categoryLists as $categoryList) {  ?> 
                                                <tbody class="list form-check-all sortable" id="sortable_<?php echo $count ?>">
                                                <?php  
                                                 if(isset($productList) && !empty($productList)){ 
                                                 $ifCategoryHasProducts = array_filter($productList, function ($element) use ($categoryList) {
                                                   return isset($element['category_id']) && $element['category_id'] == $categoryList['id'];
                                                  });
                                                 $ifCategoryHasProducts = reset($ifCategoryHasProducts);
                                              
                                                 }
                                                ?> 
                                                <?php if(isset($ifCategoryHasProducts) && !empty($ifCategoryHasProducts)) { ?>
                                                <th colspan="8" class="text-black w-100 categoryHeader" style="background-color: #dff0fa;"> <b><?php echo $categoryList['category_name']; ?></b></th>     
                                                 <?php } ?>
                                                 <?php if(isset($productList) && !empty($productList)) {  ?>  
                                                 <?php foreach($productList as $product) {  ?> 
                                                   <?php $sublocID = $product['subLoc_id']; ?>
                                                  <?php if(in_array($location['id'], $sublocID)){  ?>
                                                  
                                                  <?php 
                                                 $productIdToFind = $product['id'];
                                                 $sublocationIdToFind = $location['id'];
                                                 $foundElement = array();
                                                 
                                                if(isset($productCountData) && !empty($productCountData)){ 
                                                 $foundElements = array_filter($productCountData, function ($element) use ($productIdToFind, $sublocationIdToFind) {
                                                   return isset($element['product_id']) && $element['product_id'] == $productIdToFind &&
                                                   isset($element['sublocation_id']) && $element['sublocation_id'] == $sublocationIdToFind;
                                                  });
                                                 $foundElement = reset($foundElements);     
                                                 }
                                                 ?>
                                                  <?php if($product['category_id'] == $categoryList['id']){  ?>
                                                  <tr id="row_<?php echo  $product['id']; ?>" class="innerparemt">
                                                     <input type="hidden" name="productID[]" value="<?php echo  $product['id'].'_'.$location['id'].'_'.$product['price']; ?>">
                                                    <td class="name"><?php echo (isset($product['name']) ? $product['name'] : ''); ?></td>
                                                     <?php $key = array_search($product['uom'], array_column($uomLists, 'product_UOM_id'));  ?>
                                                    <td class="product_UOM_name"><?php echo ($key !== false) ? $uomLists[$key]['product_UOM_name'] : ""; ?></td>
                                                
                                                    <td class="name par_levelValue"><?php echo (isset($product['par_level'][$sublocationIdToFind]) ? $product['par_level'][$sublocationIdToFind] : ''); ?></td>
                                                   <td class="name"><?php echo (isset($product['price']) ? "$".number_format($product['price'],2) : ''); ?></td>
                                                    <td><input type="text" class="form-input dailtQtyNeed" name="dailtQtyNeed[]"  value="<?php echo (isset($foundElement['dailtQtyNeed']) ? $foundElement['dailtQtyNeed'] :'') ?>"/></td>
                                                     <td ><input type="text" readonly name="qtyToMake[]" class="form-input qtyToMake" value="<?php echo (isset($foundElement['qtyToMake']) ? $foundElement['qtyToMake'] :'') ?>" /></td>
                                                  </tr>
                                                  <?php } ?>
                                                  <?php } ?>
                                                  <?php }  } ?>
                                                    
                                                    
                                                    </tbody>
                                                <?php } } ?>
                                                    </table>
                                        </div>
                                        
                                          <?php  $count++;} } ?>
                                    
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->

                      
                        <!--end col-->
                    </div>
                    </form>
                    
                    </div>
                     </div>
                      </div>
                      
       <div id="placeOrderModal" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Place Order</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                          <div class="col-lg-12 col-md-12 col-sm-12">
                            
                               
                                    <div class="row">
                            <div class="col-lg-6 kitchenOptions">
                              <label for="name-field" class="form-label">Delivery Date</label> <?php $tomorrow = date('d M, Y', strtotime('+1 day')); ?>
              <input type="text" name="delivery_date" id="inputDelivery_date" value="<?php echo  $tomorrow ?>" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d M, Y" placeholder="Select date" readonly="readonly">
                             </div> 
                             <div class="col-lg-6 kitchenOptions " >
                              <label for="name-field" class="form-label">Email</label>
 <input type="text"  id="inputEmail" class="form-control" placeholder="Enter Email" value="<?php echo (isset($kithendetails['email']) ? $kithendetails['email'] : ''); ?>">
                              </div>   
                              
                                <div class="col-lg-6 kitchenOptions mt-3" >
                              <label for="name-field" class="form-label">Cc Email</label>
                                <input type="text" id="inputCcemail" class="form-control" placeholder="Enter Cc Email" value="<?php echo (isset($kithendetails['ccemail']) ? $kithendetails['ccemail'] : ''); ?>">
                              </div> 
                              
                              <div class="col-lg-12 kitchenOptions mt-3">
                               <label for="name-field" class="form-label">Comments</label>
                               <input type="text" id="inputComments" class="form-control" placeholder="Enter Comments">
                               </div>
                               </div>
                               </div>       
                                  </div>
                            <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="submitOrderForm()" class="btn btn-success btn-label waves-effect waves-light sendOrderBtn">
            <span>Send Order</span>
            <i class="ri-shopping-basket-line label-icon align-middle fs-16 me-2"></i>
        </button> 
         <button type="button" class="btn btn-success btn-load btnBeforeAjax" style="display: none;">
            <span class="d-flex align-items-center">
                <span class="spinner-grow flex-shrink-0" role="status">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span class="flex-grow-1 ms-2">Loading...</span>
            </span>
        </button>
                                                            </div>
        
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>                
                      
                      <script>
$(document).ready(function() {
   
    $('.dailtQtyNeed').on('input', function() {
        let enteredValue = $(this).val();
        let parLevel = $(this).parents('.innerparemt').find(".par_levelValue").text();
        let finalQtyToMake = '';
        // Check if the entered value is a valid number
        if ($.isNumeric(enteredValue)) {
            if(enteredValue !=''){
             finalQtyToMake = parseInt(parLevel) - parseInt(enteredValue);     
            }else{
            finalQtyToMake = '';
            }
        
            $(this).parents('.innerparemt').find(".qtyToMake").val(Math.max(0, finalQtyToMake));

        } else if(enteredValue !='') {
            alert('Please enter a valid number.'); return false;
        }else{
            $(this).parents('.innerparemt').find(".qtyToMake").val(''); 
        }
    });
    
    
   let dataId = $('.navAnchor.active').data('id');
    $(".selectedSubLocationId").val(dataId) 
   $('.navItemForSubId').on('click', function () {
        let dataId = $(this).data('id');
        $(".selectedSubLocationId").val(dataId)
       
      });  
     
});

function saveAndPlaceOrder(){
   $("#placeOrderModal").modal('show'); 
}

function submitOrderForm(){
    
    $("#email").val($("#inputEmail").val());
    $("#ccemail").val($("#inputCcemail").val())
    $("#comments").val($("#inputComments").val())
    $("#delivery_date").val($("#inputDelivery_date").val());
    $(".sendOrderBtn").html("Sending...");
    validateBeforePlacingOrder();
     
}

function validateBeforePlacingOrder(){
if($("#delivery_date").val() ==''){
     alert("Please enter delivery date before placing order.");
     return false;
    }else{
    let  selectedSubLocationId = $(".selectedSubLocationId").val();
     $.ajax({
            type: "POST",
            url: "/Supplier/internalorder/validateOrderIfAlreadyPlacedToday", 
            data: "selectedSubLocationId="+selectedSubLocationId+'&deliveryDate='+$("#delivery_date").val(),
            success: function (response) {
            if(response =='success'){
             $("#orderForm").submit();    
            }else{
            $(".alertMessage").removeClass("d-none");
            $(".appendMessage").html(response)
            setTimeout(function(){
             $(".alertMessage").addClass("d-none");   
            },5000)
            }
              
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        }); 
        
    //    
    }     
}

function saveAndReturnForm(){
     $('#orderForm').attr('action', '/Supplier/internalorder/addProductCount');
     $("#orderForm").submit();
   
}




    
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchText = this.value.toLowerCase();
        var headers = document.querySelectorAll('.categoryHeader');
        
        headers.forEach(function(header) {
            var headerText = header.textContent.trim().toLowerCase();
            if (headerText.includes(searchText)) {
                header.closest('tbody').style.display = '';
            } else {
                header.closest('tbody').style.display = 'none';
            }
        });
    });
</script>