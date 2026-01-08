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
                                        <h5 class="card-title mb-0 flex-grow-1 text-black">Stock Count  <i class="fas fa-info-circle" title="Please select supplier from dropdown to show all products,Than enter the stock count info in corresponding area"></i></h5>
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
                                       <select class="js-example-basic-single" required name="supplier_id" id="supplierNameInput" <?php echo $disabled; ?>>
                                          <option value="">Select Supplier</option>
                                          <?php if(!empty($suppliers_list)){ 
                                            foreach($suppliers_list as $sup){ ?>
                                           <option value="<?php echo $sup['supplier_id']; ?>_<?php echo $sup['requirePL']; ?>"><?php echo $sup['supplier_name']; ?></option>
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
                                             <th colspan="2">Cafe Unit UOM</th>
                                             <th colspan="2">Inner Unit UOM</th>
                                             <th colspan="1" class="eachUnitTH">Each Unit UOM</th>
                                             <th rowspan="2" class="hideIfNotPARLevelRequired">PAR Level</th>
                                              <th rowspan="2" class="hideIfNotPARLevelRequired">Total Stock Count</th>
                                              <th rowspan="2" class="hideIfNotPARLevelRequired">Order Qty</th>
                                             </tr>
          
                                         <tr class="areaList">
                                          <th>Unit</th> 
                                          <th>Count</th> 
          
                                            <th>Unit</th> 
                                            <th>Count</th> 
                                              
                                              <th>Unit</th> 
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
                 url: "/Supplier/fetchSupplierItems",
                 data:'supplier_id='+supId,
                 success: function(suppProducts){
                    let response = JSON.parse(suppProducts);
    let allproducts = response['productDetails'] || []; 
    let productsStockQty = response['productStockQty'] || [];
    let allAreas = response['areaAssigned'] || [];
    let htmlC = '';
    let trForDynamicHeader = $('.areaList');
    let loopCount = 0;
    let stockTh = trForDynamicHeader.find('.stockTh');
    stockTh.remove();
   
  
    allproducts.forEach(function (value, index) {
  
   let stockQtyForTodayForThisProduct = value?.PARLevelQty !='' ? value?.PARLevelQty : unserializePhpArray(value?.AllDaysPARLevelQty);
   let cafe_unit_uomQty = value?.cafe_unit_uomQty ? value?.cafe_unit_uomQty : 0;
   let inner_unit_uomQty = value?.inner_unit_uomQty ? value?.inner_unit_uomQty : 0;
   let tier_type = value?.tier_type ? value?.tier_type : '';
  
   let foundUOM = allUOM.find(obj => obj.product_UOM_id === value?.cafe_unit_uom);
   let cafe_unit_uomName = foundUOM ? foundUOM.product_UOM_name : '';
  
   let foundInnerUOM = allUOM.find(obj => obj.product_UOM_id === value?.inner_unit_uom);
   let inner_unit_uomName = foundInnerUOM ? foundInnerUOM.product_UOM_name : '';
  
   let foundEachUOM = allUOM.find(obj => obj.product_UOM_id === value?.each_unit_uom);
   let each_unit_uomName = foundEachUOM ? foundEachUOM.product_UOM_name : '';
  
  
   let orderQty = stockQtyForTodayForThisProduct;
  
   
   htmlC += '<tr class="row_'+value?.product_id+'">';
  
   htmlC += '<th scope="row"><input type="hidden" name="product_id[]" value="' + (value?.product_id || '') + '">' + (value?.product_code || '') + '</th>';
   htmlC += '<td>'+ (value?.product_name || '') +'</td>';
   htmlC += '<input type="hidden" class="tierTypeValue" name="tierTypeValue[]" value="' + tier_type  + '">';
   htmlC += '<input type="hidden" class="cafe_unit_uomQty" name="cafe_unit_uomQty[]" value="' + cafe_unit_uomQty  + '">';
   htmlC += '<input type="hidden" class="inner_unit_uomQty" name="inner_unit_uomQty[]" value="' + inner_unit_uomQty + '">';
  
   htmlC += '<td>';
   htmlC += '<input type="text" class="form-control" readonly name="cafe_unit_uomName[]"  value="' + (cafe_unit_uomName || '') + '">';
   htmlC += '</td>';

   htmlC += '<td>';
   htmlC += '<input type="text" class="form-control cafe_unit_uomCount" value="' + (value?.cafe_unit_uomCount !== null && value?.cafe_unit_uomCount !== undefined && parseInt(value.cafe_unit_uomCount) !== 0 ? value.cafe_unit_uomCount : '') + '" name="cafe_unit_uomCount[]" ' + (tier_type === 't1' ? 'readonly' : '') + ' oninput="createTotalStockCount(this,'+value?.product_id+')">';
   htmlC += '</td>';

  
   htmlC += '<td>';
   htmlC += '<input type="text" class="form-control" readonly name="inner_unit_uomName[]" value="' + (inner_unit_uomName || '') + '">';
   htmlC += '</td>';

   htmlC += '<td>';
   htmlC += '<input type="text" class="form-control inner_unit_uomCount"  value="' + (value?.inner_unit_uomCount !== null && value?.inner_unit_uomCount !== undefined && parseInt(value.inner_unit_uomCount) !== 0 ? value.inner_unit_uomCount : '') + '" '+ (tier_type === 't1' || tier_type === 't2' ? 'readonly' : '') +' name="inner_unit_uomCount[]" oninput="createTotalStockCount(this,'+value?.product_id+')">';
   htmlC += '</td>';
  
   htmlC += '<td>';
   htmlC += '<input type="text" readonly class="form-control" name="each_unit_uomName[]" value="' + (each_unit_uomName || '') + '">';
   htmlC += '</td>';

   let areaCount = 1;
   allAreas.forEach(function (areaName, areaIdIndex) {
    let Stockqty = productsStockQty.filter((PSQvalue) => {
      return PSQvalue?.product_id === (value?.product_id || '') && PSQvalue.area_id === (areaName?.id || '');
    });
    areaCount++;
    console.log("Stockqty",Stockqty);
   
    if(loopCount < 1){
     $(".eachUnitTH").attr('colspan', areaCount);
     let newTh = $('<th class="stockTh">' + areaName?.name + '</th>');
    trForDynamicHeader.append(newTh);
    
    }
    
   
    // console.log("orderQty",orderQty); console.log("qtyAreaWise",qtyAreaWise); console.log("qty",qty);
     htmlC += '<td>';
     htmlC += '<input type="text" value="'+(Stockqty[0]?.area_count || '')+'" class="form-control areaCountValue_' + value?.product_id + '"  name="' + (value?.product_id || '') + '_' + (areaName?.id || '') + '" oninput="createTotalStockCount(this, ' + value?.product_id + ')">';
    htmlC += '</td>';
   });
   
    if(isPARLevelReqiured == 1){
     htmlC += '<td><input type="hidden" class="PARLevelQty" value="'+stockQtyForTodayForThisProduct+'">'+ (stockQtyForTodayForThisProduct || '') +'</td>';
    htmlC += '<input type="hidden" name="totalStockCountTotalValue[]" class="totalStockCountTotalValue" value="'+(value?.totalStockCountTotalValue || '')+'"><td class="totalStockCountTotalValue_' + value?.product_id + '">'+(value?.totalStockCountTotalValue || '')+'</td>';
    htmlC += '<input type="hidden" name="orderQtyValue[]" class="orderQtyValue" value="'+(value?.orderQty || '')+'"><td class="orderQtyValue_' + value?.product_id + '">'+(value?.orderQty || '')+'</td>';
    $(".hideIfNotPARLevelRequired").show();
    }else{
    $(".hideIfNotPARLevelRequired").hide();
    } 
   
    htmlC += '</tr>';
    loopCount++;
   });


                   $('.Ajaxloader-demo-box').toggleClass('d-none');
                   $(".suppliersProductsStock").html("");
                    $(".suppliersProductsStock").html(htmlC);
                    
                    // console.log(unserializedData);
                }
                });  
    
}

// for calculation of order quantity that we need to place
function createTotalStockCount(obj,product_id){
    let cafe_unit_uomQty = $(".row_"+product_id).find('.cafe_unit_uomQty').val();
    let caffeUnitEnteredValue = $(".row_"+product_id).find('.cafe_unit_uomCount').val();
    caffeUnitEnteredValue = !caffeUnitEnteredValue || isNaN(caffeUnitEnteredValue) ? 0 : parseFloat(caffeUnitEnteredValue);
    let tierTypeOfThisProduct = $(".row_"+product_id).find('.tierTypeValue').val();
    let cafe_unitTotal  =  cafe_unit_uomQty*caffeUnitEnteredValue;
    let PARLevelOfThisProduct = $(".row_"+product_id).find('.PARLevelQty').val();
    let PRLevel = PARLevelOfThisProduct * cafe_unit_uomQty;
    let   orderQty = 0;
    
    // Inner Unit Total
     let inner_unit_uomQty = $(".row_"+product_id).find('.inner_unit_uomQty').val();
    let innerUnitEnteredValue = $(".row_"+product_id).find('.inner_unit_uomCount').val()
    innerUnitEnteredValue = !innerUnitEnteredValue || isNaN(innerUnitEnteredValue) ? 0 : parseFloat(innerUnitEnteredValue);
    let inner_unitTotal  =  inner_unit_uomQty*innerUnitEnteredValue;
    // All areas total entered value or each unit qty (individual count)
    let sumofAllAreas = 0;
    $(".areaCountValue_"+product_id).each(function() {
     sumofAllAreas += parseFloat($(this).val()) || 0;
        });
    
    let totalStockCount = parseFloat(cafe_unitTotal) +  parseFloat(sumofAllAreas) + parseFloat(inner_unitTotal);
    
    $(".totalStockCountTotalValue_"+product_id).html(totalStockCount);
    $(".row_"+product_id).find('.totalStockCountTotalValue').val(totalStockCount);
     
    if(tierTypeOfThisProduct == 't1'){
         orderQty = parseFloat(PARLevelOfThisProduct) - parseFloat(sumofAllAreas);
      
    }else if(tierTypeOfThisProduct == 't2'){
        if(sumofAllAreas !='' && sumofAllAreas > 0){
            
        orderQty = parseFloat(PARLevelOfThisProduct) - ((sumofAllAreas / cafe_unit_uomQty) + caffeUnitEnteredValue);    
        }else{
          orderQty   = parseFloat(PARLevelOfThisProduct) - caffeUnitEnteredValue;
        }
         
         
    }else if(tierTypeOfThisProduct == 't3'){
          let totalStockCountFinal = parseFloat(PRLevel) - parseFloat(totalStockCount)
             orderQty = (totalStockCountFinal / cafe_unit_uomQty);
    }

         orderQty = Math.ceil(orderQty);
         orderQty = (orderQty < 0) ? 0 : orderQty;
    $(".orderQtyValue_"+product_id).html(orderQty);
    $(".row_"+product_id).find('.orderQtyValue').val(orderQty);
    
    
}

function unserializePhpArray(serializedString) {
  let unserializedObject = {};

  // Use try-catch to handle potential errors during parsing
  try {
    // Use regular expressions to match and extract key-value pairs from the serialized string
    const matches = serializedString.match(/s:\d+:"[^"]+";s:\d+:"[^"]+";/g);

    if (matches) {
      matches.forEach((match) => {
        const parts = match.match(/s:\d+:"([^"]+)";s:\d+:"([^"]+)";/);
        if (parts && parts.length === 3) {
          const key = parts[1];
          const value = parts[2];
          unserializedObject[key] = value;
        }
      });
    }

    const currentDate = new Date();
    console.log("unserializedObject", unserializedObject);
    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const currentDayName = dayNames[currentDate.getDay()];
    const todaysStockQty = unserializedObject[`${currentDayName}_stockQty`];

    return todaysStockQty;
  } catch (error) {
    console.error("Error while unserializing PHP array:", error);
    return null; // Handle invalid data by returning null or taking other appropriate action
  }
}




$(document).ready(function () {
    $("#stockCheckForm").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/Supplier/updateStock",
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
                                
                                