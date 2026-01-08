<div class="main-content">
        <div class="page-content">
                <div class="container-fluid">
                
            <div class="row">
                 <h5 class="mb-3 text-black hide-on-print">Make Order  :  <?php echo date('l'); echo '  '.date('d M, Y');  ?></h5>  
                  <div class="col-lg-12">
                <div class="d-flex gap-3">    
                   <div class="info-box">
                <span class="info-box-icon bg-danger-subtle">
                </span>
                   <div class="info-box-content">
                     <span class="info-box-text hide-on-print">Quantity Updated</span>
                    </div>
                 </div>
                 </div> 
           <button class="buttons-print btn btn-warning hide-on-print" id="printButton"><span><i class="fas fa-print"></i> Print</span></button>    
                            <div class="card mt-2">
                 <div class="card-body"> 
               <div class="table-responsive"> 
               <input type="text" id="searchInput" class="form-control mb-2 w-25 hide-on-print" placeholder="Search Product">
                <table class="table table-nowrap align-middle table-responsive table-bordered" id="SupplierDataTable">
                   <thead class="text-muted table-light">
                     <tr class="text-uppercase">
                      <th class="sort" data-sort="Name">Product Name</th>
                      <th class="sort" data-sort="Name">UOM</th>
                     
                     <?php  if(isset($allInternalOrdersSubLocations) && !empty($allInternalOrdersSubLocations)) {  ?> 
                      <?php foreach($allInternalOrdersSubLocations as $allInternalOrdersSubLoc) {   ?>  
                      <th class="sort" data-sort="Name"><?php echo $allInternalOrdersSubLoc['name'] ?></th>
                       <?php } ?>
                    <?php } ?>
                      <th class="sort" data-sort="Status">Qty To Make</th>
                      <!--<th class="sort" data-sort="Status">Attachment</th>-->
                      <!--<th class="sort" data-sort="Status">Temperature</th>-->
                      <th class="sort hide-on-print" data-sort="Status">Action</th>
                      </tr>
                      </thead>
                      <tbody class="list form-check-all">
    <?php  if(isset($categoryLists) && !empty($categoryLists)) { ?>    
    <?php foreach($categoryLists as $categoryList) { ?>
    <?php $categoryHasProduct = array_filter($allInternalOrders, function($value) use($categoryList) { 
     return $value['category_id'] == $categoryList['id']; // Return true if the number is even
       }); ?>
       <?php if(isset($categoryHasProduct) && !empty($categoryHasProduct)) { ?>
      <th colspan="15" class="text-black w-100 <?php echo 'categoryHeader_'.$categoryList['id']; ?>" style="background-color: #dff0fa;" > 
         <div class="form-check form-check-success mb-3 ">
          <input class="form-check-input categoryCheckbox" type="checkbox" id="<?php echo $categoryList['id']; ?>" checked="">
         <label class="form-check-label" for="<?php echo $categoryList['id']; ?>">
         <b><?php echo $categoryList['category_name']; ?></b>
        </label>
        </div> 
          
          </th>                       
                     <?php  if(isset($allInternalOrders) && !empty($allInternalOrders)) { $productLoopedOn = array(); ?>      
                     <?php foreach($allInternalOrders as $loopType => $internalOrder) { 
                     if($categoryList['id'] == $internalOrder['category_id']) {   
                      $totalQtyToMake = 0;     
                     if (!in_array($internalOrder['product_id'], $productLoopedOn)) {   array_push($productLoopedOn, $internalOrder['product_id']);  ?>
                      <tr class="innerparemt <?php echo 'categoryHeader_'.$categoryList['id']; ?>">
                       <td><?php echo $internalOrder['product_name'] ?? ''; ?></td>
                        <?php $key = array_search($internalOrder['uom'], array_column($uomLists, 'product_UOM_id'));  ?>
                     <td><?php echo ($key !== false) ? $uomLists[$key]['product_UOM_name'] : ""; ?></td>
                     
                       <?php  if(isset($allInternalOrdersSubLocations) && !empty($allInternalOrdersSubLocations)) {  ?> 
                       
                      <?php 
                      foreach($allInternalOrdersSubLocations as $allInternalOrdersSubLoc) { 
                           
                       $filteredProductResult = array_filter($allInternalOrders, function($item) use ($internalOrder,$allInternalOrdersSubLoc) {
                         return $item['product_id'] == $internalOrder['product_id'] && $item['sublocation_id'] == $allInternalOrdersSubLoc['id'];
                        }); 
                        
                         if(isset($filteredProductResult) && !empty($filteredProductResult)) { 
                          $firstResult = reset($filteredProductResult);
                          
                          if(isset($firstResult['is_qtyUpdated']) && $firstResult['is_qtyUpdated']){
                           $classname ="bg-danger-subtle";   
                          }else{
                           $classname = '';   
                          }
                         $orderQTy= $firstResult['orderQty'];
                         
                        }else{
                         $orderQTy = '';
                         $classname = ''; 
                        }
                       $totalQtyToMake= $totalQtyToMake + $orderQTy; 
                        ?>
                      <td class="<?php echo $classname; ?>">
                      <?php  echo $orderQTy; ?>
                       </td>
                      <?php }  ?>
                      <?php } ?>
                      <td class="orderQty"><?php echo $totalQtyToMake; ?></td>
                     
                    <td class="hide-on-print">
                    <?php if($internalOrder['date_completed'] == date('Y-m-d')) { ?>
                  <button class="btn btn-success btn-sm hide-on-print" ><i class="bx bx-fork"></i> Completed</button>
                   <?php }else {  ?>
                 <button class="btn btn-orange btn-sm hide-on-print" onclick="markCompleted(this,<?php echo $internalOrder['order_id'] ?>,<?php echo $internalOrder['product_id'] ?>)"><i class="bx bx-bowl-rice"></i> Complete</button>
                  <?php  } ?>
                  
                 
                  
                   </td> 
                      </tr>
                       <?php }  ?>
                        <?php }  ?>
                       <?php }  ?>
                     <?php }  ?>
                     <?php }  ?>
                       <?php }  ?>
                      <?php }  ?>
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
<style>
/* Define styles for print */
@media print {
  .hide-on-print {
    display: none !important; 
  }
  table {
    width: 100%;
    font-size: 7pt; 
  }
  th {
    background-color: #dff0fa !important;
  }
  
  /* Allow table cells to break across pages */
  th, td {
    page-break-inside: auto;
    word-wrap: break-word;
  }
  
  /* Set margins to zero and specify page size */
  @page {
    margin: 0;
   size: A3;
  }
}
</style>

<script>
                    
function markCompleted(obj,orderId,productId){
             let foodTemp = '';
               
               let foodTempElement = $(obj).parents('.innerparemt').find('.foodOrderTemp');
                if (foodTempElement.length > 0) {
                 foodTemp = $(obj).parents('.innerparemt').find('.foodOrderTemp').val(); 
                if(foodTemp == ''){
                alert("Please enter food temperature before completing."); 
                return false;
                }
                 }
                 $(obj).html('<i class="bx bx-bowl-rice"></i> In Progress...');
               $(obj).removeClass('btn-orange').addClass('btn-success');
               
                $.ajax({
                url: "/Supplier/internalorder/markCompleted",
                type: "POST",
                data: { orderId: orderId,productId:productId,foodTemp:foodTemp },
                success: function(response) {
                  $(obj).html('<i class="bx bx-fork"></i> Completed');
                },
                error: function() {
        
                    console.log("Error updating order");
                }
            });
            } 

          
            
    
    
    $(document).ready(function() {
        // Define function to handle filtering
        function filterProducts(searchText) {
            $('#SupplierDataTable tbody tr').each(function() {
                var productName = $(this).find('td:first-child').text().toLowerCase();
                if (productName.includes(searchText.toLowerCase())) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Add event listener to the search input
        $('#searchInput').on('input', function() {
            var searchText = $(this).val();
            filterProducts(searchText);
        });
    });
    
 $(document).ready(function() {
   $('#printButton').on('click', function() {
    $('.categoryCheckbox').each(function() {
    let checkboxId = $(this).attr('id');
    if (!$(this).is(':checked')) {
        $('.categoryHeader_' + checkboxId).addClass("hide-on-print");
    }
   });
  
   window.print()
  });
});
    
  </script>