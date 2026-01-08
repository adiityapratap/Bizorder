<div class="main-content">
<button type="button" data-toast="" data-toast-text="Stock Updated succesfully" data-toast-gravity="top" data-toast-position="center"
data-toast-classname="success" data-toast-duration="3000" class="btn btn-light w-xs d-none btnToastSuccess"></button>
<button type="button" data-toast="" data-toast-text="Error ! An error occurred." data-toast-gravity="top"
data-toast-position="center" data-toast-classname="danger" data-toast-duration="3000" class="btn btn-light w-xs btnToastErr">Error</button>
            <div class="page-content">
                <div class="container-fluid">
                    <div class="alert alert-success shadow d-none" role="alert">
                       <strong> Success !</strong> Stock Updated succesfully .
                       </div>
                       <div class="alert alert-danger shadow mb-xl-0 d-none" role="alert">
                         <strong> Something went wrong! </strong> Please try after some time!
                         </div>
                    <div class="Ajaxloader-demo-box d-none">
                        <div class="jumping-dots-loader">
                          <span></span>
                          <span></span>
                          <span></span>
                        </div>
                      </div>
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-header  border-0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Monthly Stock Count  <i class="fas fa-info-circle" title="Please select supplier from dropdown to show all products,Than enter the stock count info in corresponding area"></i></h5>
                                        <button type="button" class="btn btn-success btn-load btnBeforeAjax">
                                                            <span class="d-flex align-items-center">
                                                                <span class="spinner-grow flex-shrink-0" role="status">
                                                                    <span class="visually-hidden">Updating...</span>
                                                                </span>
                                                                <span class="flex-grow-1 ms-2">
                                                                    Updating...
                                                                </span>
                                                            </span>
                                                        </button>
                                          <button type="button" class="btn btn-success btn-label waves-effect waves-light btnAfterAjax" id="submitStockForm"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Save & return</span></button>
                                          <button type="button" class="btn btn-secondary btn-label waves-effect waves-light btnAfterAjax mx-3" id="completeStockForm"><i class="ri-save-3-fill label-icon align-middle fs-16 me-2"></i><span>Complete Stock Count</span></button>
                                    </div>
                                </div>
                                
                                
                                 <form id="stockCheckForm">
                                     <input type="hidden" name="is_completed" id="is_completed" value="0">
                                  <div class="card-body pt-0">
                                     <div class="row mt-4">
                                     <div class="col-lg-4 mb-4">
                                       <label for="categoryNameInput" class="form-label">Supplier Name</label>
                                       <select class="js-example-basic-single" required name="supplier_id" id="supplierNameInput">
                                          <option value="">Select Supplier</option>
                                          <?php if(!empty($suppliers_list)){ 
                                            foreach($suppliers_list as $sup){ ?>
                                           <option value="<?php echo $sup['supplier_id']; ?>_0"><?php echo $sup['supplier_name']; ?></option>
                                            <?php }} ?>
                                             </select>
                                                   
                                                </div>
                                                </div>
                                                 <div class="row mt-4">
                                                <div class="col-lg-12 mb-4">   
                                               
                                                <table class="table-responsive table align-middle table-nowrap mb-0 table-bordered">
                                            <thead class="table-light tableDynamicHeader">
                                              <tr>
                                             <th rowspan="2">Product Code</th>  
                                             <th rowspan="2">Product Name</th>
                                             <th rowspan="2" class="eachUnitTH">Unit of Measure</th>
                                             <th rowspan="2" class="openingStockCount">Opening Stock Count</th>
                                             <th rowspan="2" class="purchaseUnits">Purchase Units</th>
                                              <th colspan="1" class="closingStockCount">Closing Stock Count</th>
                                              <th rowspan="2" class="unitsSold">Units Sold Month </th>
                                             </tr>
          
                                         <tr class="areaList">
                                          
                                              
                                             
                                                 </tr>
                                                 
                                                </thead>       
                                                    
                                                    <tbody class="suppliersProductsStock">
                                                        </tbody>
                                                     </table>  
                                                   
                                                
                                                </div>
                                                </div>
                                                </div>
                                                  </form>
                                         </div>
                                 </div>
                                  </div>
                                   </div>
                                    </div>
                                     </div>
                                     
                                      <script>
     $(document).ready(function () {
          $(".btnBeforeAjax").hide();
          let product_UOM = '<?php echo json_encode($product_UOM); ?>';
          let selectedSuppId = '<?php echo $suppId; ?>';
          let allUOM = JSON.parse(product_UOM);
      $('#supplierNameInput').on('change', function () {
       $('.Ajaxloader-demo-box').toggleClass('d-none');
         let selectedSuppId = $(this).val();
         selectedSuppId = selectedSuppId.split("_");
         let  suppId = selectedSuppId[0];
         let isPARLevelReqiured = selectedSuppId[1]; 

         localStorage.setItem('suppId',suppId);
         fetchItemOfSelectedSupplier(suppId,allUOM,product_UOM,isPARLevelReqiured);
      });
      if(selectedSuppId==''){
      let selectedSuppId = localStorage.getItem('suppId');    
      }
        
    
     
      if (typeof selectedSuppId !== 'undefined' && selectedSuppId !== null && selectedSuppId.trim() !== '') {
         $("#supplierNameInput").val(selectedSuppId); 
          console.log("selectedSuppId_suppId",selectedSuppId)
         selectedSuppId = selectedSuppId.split("_");
         let  suppId = selectedSuppId[0];
         let isPARLevelReqiured = selectedSuppId[1];  
         
         $('.Ajaxloader-demo-box').toggleClass('d-none');
         fetchItemOfSelectedSupplier(suppId,allUOM,product_UOM,isPARLevelReqiured);
         
      }

});
function fetchItemOfSelectedSupplier(supId,allUOM,product_UOM,isPARLevelReqiured){
  let currentStock =[];
         $.ajax({
                 type: "POST",
                 url: "/Supplier/fetchSupplierItemsForMonthlyStockUpdate",
                 data:'supplier_id='+supId,
                 success: function(suppProducts){
                    let response = JSON.parse(suppProducts);
    let allproducts = response['productDetails'] || []; 
    let productsStockQty = response['productStockQty'] || [];
    console.log("allproducts",allproducts);
    
    let allAreas = response['areaAssigned'] || [];
    let htmlC = '';
    let trForDynamicHeader = $('.areaList');
    let loopCount = 0;
    let stockTh = trForDynamicHeader.find('.stockTh');
    stockTh.remove();
    let unitsSold = 0;
 
    allproducts.forEach(function (value, index) {
  
   let Stockqty = productsStockQty.filter((PSQvalue) => {
      return PSQvalue?.product_id === (value?.product_id || '');
    });
   let opening_stock_count =  Stockqty[0]?.opening_stock_count || 0;
   let purchase_unit =  value?.purchase_unit || '';
   let closing_stock_count =  Stockqty[0]?.closing_stock_count || 0;
   
   let tier_type = value?.tier_type ? value?.tier_type : '';

   let foundEachUOM = allUOM.find(obj => obj.product_UOM_id === value?.each_unit_uom);
   let each_unit_uomName = foundEachUOM ? foundEachUOM.product_UOM_name : '';
   unitsSold = parseInt(opening_stock_count) + parseInt(purchase_unit) - parseInt(closing_stock_count)
  
  
   
   htmlC += '<tr class="row_'+value?.product_id+'">';
  
   htmlC += '<th scope="row"><input type="hidden" name="product_id[]" value="' + (value?.product_id || '') + '">' + (value?.product_code || '') + '</th>';
   htmlC += '<td>'+ (value?.product_name || '') +'</td>';
   htmlC += '<input type="hidden" class="tierTypeValue" name="tierTypeValue[]" value="' + tier_type  + '">';
   
   htmlC += '<td>';
   htmlC += '<input type="text" readonly class="form-control" name="each_unit_uomName[]" value="' + (each_unit_uomName || '') + '">';
   htmlC += '</td>';
   
   htmlC += '<td>';
   htmlC += '<input type="text"  class="form-control" name="opening_stock_count[]" value="' + opening_stock_count  + '">';
   htmlC += '</td>';
 
   htmlC += '<td>';
   htmlC += '<input type="text" readonly class="form-control" name="purchase_units[]" value="' + purchase_unit  + '">';
   htmlC += '</td>';

   let areaCount = 1;
   allAreas.forEach(function (areaName, areaIdIndex) {
    
    if(loopCount < 1){
     $(".closingStockCount").attr('colspan', areaCount);
     let newTh = $('<th class="stockTh">' + areaName?.name + '</th>');
     trForDynamicHeader.append(newTh);
    
    }
   areaCount++;
   
   htmlC += '<td>';
   htmlC += '<input type="text" class="form-control" name="closing_stock_count[]" value="' + closing_stock_count  + '">';
   htmlC += '</td>';
    
   });

   htmlC += '<td>';
   htmlC += '<input type="text" readonly class="form-control" name="units_sold[]" value="' + unitsSold  + '">';
   htmlC += '</td>';
   htmlC += '</tr>';
   loopCount++;
   });

      $('.Ajaxloader-demo-box').toggleClass('d-none');
      $(".suppliersProductsStock").html("");
      $(".suppliersProductsStock").html(htmlC);
      
    }
    });  
    
}







$(document).ready(function () {
    $("#stockCheckForm").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/Supplier/monthlystockUpdate",
            data: formData,
            success: function (response) {
               $(".btnBeforeAjax").hide();$(".btnAfterAjax").show();
               let submitType = localStorage.getItem('submitType');
               if(submitType=='saveAndReturn'){
                $('.btnToastSuccess').click();    
               }else{
              window.location.href = '/Supplier/<?php echo $this->session->userdata('system_id'); ?>';    
               }
               
           
            },
            error: function (xhr, status, error) {
                // Handle any errors (if needed)
                console.error(xhr, status, error);
                 $('.btnToastErr').click();
            }
        });
    });
    
    $("#submitStockForm").on("click", function (e) {
        $(".btnBeforeAjax").show();$(".btnAfterAjax").hide();
        localStorage.setItem('submitType', 'saveAndReturn');
        e.preventDefault(); 
        $("#stockCheckForm").submit(); 
    });
    
    $("#completeStockForm").on("click", function (e) {
         $("#is_completed").val('1');
        $(".btnBeforeAjax").show();
        $(".btnAfterAjax").hide();
        e.preventDefault(); 
        localStorage.setItem('submitType', 'complete');
        $("#stockCheckForm").submit(); 
    });
    
});




                                      </script>
                                
                                