<div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="alert alert-success shadow d-none" role="alert">
                       <strong> Success !</strong> Order Sent Succesfully .
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
                            <div class="card px-3 py-3" id="orderList">
                               
                                 <form id="orderForm">
                               
                                    <div class="row">
    <div class="col-lg-4 mb-4">
        <label for="categoryNameInput" class="form-label">Supplier Name</label>
        <input type="hidden" name="subcategory_id" value="<?php echo (isset($selectedSupDetails[0]['category_id']) ? $selectedSupDetails[0]['category_id'] : '') ?>">
        <select class="js-example-basic-single" required name="supplier_id" id="supplierNameInput" <?php echo $disabled; ?>>
            <option value="">Select</option>
            <?php if(!empty($suppliers_list)){ 
                foreach($suppliers_list as $sup){ ?>
                    <option value="<?php echo $sup['supplier_id']; ?>"><?php echo $sup['supplier_name']; ?></option>
                <?php }} ?>
        </select>
    </div>
    
     <div class="col-lg-4 mt-4">
        <button type="button" class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="ri-add-line label-icon align-bottom fs-16 ms-2 mt-1"></i> Add New Product
        </button>
          <a  target="_blank" class="btn btn-secondary d-none viewStockSummary">
            <i class="ri-fridge-fill label-icon align-bottom fs-16 ms-2 mt-1"></i> View Stock Summary
        </a>
    </div>
    
  

    <!-- Second additional column -->
    <div class="col-lg-4 mt-5 text-end">
    <p>  <b>Minimum Order : </b> <span class="minOrder"><?php echo '$'.(isset($selectedSupDetails[0]['min_order']) ? number_format($selectedSupDetails[0]['min_order'], 2, '.', ',') : '0.00') ?></span></p>
      <p> <b>Remaining Budget : </b> <?php echo "$".number_format($budgetRemaining, 2, '.', ','); ?> </p> 
    </div>

    <!-- Add the 'Add to Cart' button back to its original position -->
   
</div>
                                     <div class="row">
                                                <div class="col-lg-8 mb-4">   
                                                 <table class="table-responsive customtable table align-middle table-nowrap mb-0 table-bordered " id="productListTable">
                                                      <thead class="table-light tableDynamicHeader">
                                                        <tr>
                                                            <th scope="col">Product Code</th>
                                                            <th scope="col">Product Name</th>
                                                            <th scope="col">UOM</th>
                                                            <th scope="col" class="stockTh">Order Quantity </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="suppliersProductsStock" id="sortable">
                                                        
                                                        </tbody>
                                                     </table>  
                                                </div>
                                                
                             <div class="col-lg-4 mt-5">
                                <div class="card">
                                    <div class="card-body pt-2">
                                       <div class="table-responsive table-card">
                                        <table class="table table-borderless customtable align-middle mb-0">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th  scope="col"> </th>
                                                     <th  scope="col">Delivery Info</th>
                                                    <th scope="col" ></th>
                                                </tr>
                                            </thead>
                                            <tbody class="cartProductSummary">
                                                <?php if(isset($selectedSupDetails[0]['requireDD']) && $selectedSupDetails[0]['requireDD'] == 1){ ?>
                                             <tr>
                                                 <td>Delivery Date </td>
                                    <td><input type="text" name="delivery_date" class="form-control flatpickr-input " data-provider="flatpickr" data-date-format="d M, Y"  placeholder="Select date" readonly="readonly"></td>                        
                                             </tr>  
                                             <?php }else{  ?>
                                        <tr class="requireDD">
                                                 <td>Delivery date </td>
                                    <td><input type="text" name="delivery_date" class="form-control flatpickr-input " data-provider="flatpickr" data-date-format="d M, Y"  placeholder="Select date" readonly="readonly"></td>                        
                                             </tr>      
                                             <?php } ?>
                                        <tr>
                                        <td>Delivery Information </td> 
                                       <td>
                                            <textarea  name="delivery_info" class="form-control delivery_info"  placeholder="Delivery Info"><?php echo (isset($selectedSupDetails[0]['delivery_info']) ? $selectedSupDetails[0]['delivery_info'] : '') ?></textarea>
                                         
                                           </td>           
                                        </tr>       
                                          <tr>
                                        <td>Order Comments  </td> 
                                       <td><textarea type="text" class="form-control" name="order_comments"></textarea></td>           
                                        </tr> 
                                         <tr>
                                        <td>Email  </td> 
                                       <td><input type="text" class="form-control supplier_email" name="supplier_email" value="<?php echo (isset($selectedSupDetails[0]['email']) ? $selectedSupDetails[0]['email'] : '') ?>"></td>           
                                        </tr> 
                                        <tr>
                                        <td>Cc Email  </td> 
                                       <td><input type="text" class="form-control supplier_CCemail" name="supplier_CCemail" value="<?php echo (isset($selectedSupDetails[0]['cc']) ? $selectedSupDetails[0]['cc'] : '') ?>"></td>           
                                        </tr> 
                                               
                                            </tbody>
                                            <tfoot >
                                              
                                                <tr class="table-active">
                                                    <input type="hidden" name="order_total" class="order_total">
                                                    <th colspan="1">Total (AUD) :
                                                    <span class="fw-semibold cartTotalAmount">
                                                      
                                                        </span></th>
                                                    <td class="text-end" colspan="2">
        <button type="button" class="btn btn-success btn-label waves-effect waves-light btnAfterAjax" id="sendOrder">
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
                                                    </td>
                                                </tr>   
                                            </tfoot>
                                                
                                        </table>

                                    </div>
                                    </div>
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
                                     
                                     
         <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Add Product</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                               
                                                              <div class="table-responsive table-card mt-4">
                                        <table class="table table-bordered align-middle mb-0 customtable" id="newProductTable">
                                            <thead class="table-light text-muted">
                                                <tr>
                                                    <th  scope="col">Product Code</th>
                                                    <th  scope="col">Product</th>
                                                     <th  scope="col">UOM</th>
                                                    <th scope="col" >Qty</th>
                                                    <th scope="col" ></th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody class="prdctWithZeroOrderQty">
                                           
                                                
                                               
                                            </tbody>
                                            </table>
                                                                  </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                               
                                                            </div>
        
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->     
         <div id="minOrderModal" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Warning !</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                          <p>
    Minimum Order for this supplier is <span class="minOrder"></span>. Please add more quantity of the product to meet the requirements.                                                          
                                                          </p>     
                                                           
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                               
                                                            </div>
        
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->                                          
          <div id="forceOrderModal" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Warning !</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                          <p>
    The supplier budget for this week has been exceeded. Would you like to still send the order?                                                        
                                                          </p>     
                                                           
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-success" onclick="sendOrder()">Yes</button>
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                               
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->                                          
          <div id="forceOrderModalForNotAllowedCase" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">Warning !</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                          <p>
    The order has exceeded the weekly budget. The order will be sent to the manager for approval and send it to the supplier                                                      
                                                          </p>     
                                                           
                                                            </div>
                                                            <div class="modal-footer">
                                                               <button type="button" class="btn btn-success" onclick="sendOrder()">Yes, Send Order</button>
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                               
                                                            </div>
        
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>                             
                                      <script>
// plusNew and minusNew is to handle products qty chnage in popup as, we do not inrcrz cart total on chnage of qty, of items from popup untill they are added in to cart
// we only change the qty thats it.
 

       $(document).on('click', '.plus, .plusNew', function() {
         updateProductQty($(this),'notManual')
       });
       $(document).on('input', '.product-quantity', function() {
         updateProductQty($(this),'manual');
          console.log("vall",$(this).val())
       });
       

function updateProductQty(obj,entryType){
  let input = $(obj).parent().find('.product-quantity');
    let currentValue = parseInt(input.val()) || 0;
    let maxValue = parseInt(input.attr('max'));
    if(entryType=='notManual'){
     if (currentValue < maxValue) {
        input.val(currentValue + 1);
    }   
    }
    
    let currentQty = parseInt(input.val() || 0);
    let itemPrice = $(obj).parent().find('.itemPrice').val(); 
    let cartTotal = $(".cartTotalAmount").html().replace(/\$/g, ''); 
    let updatedCartTotal = 0;
   
    
    let itemUnitPrice = $(obj).parent().find('.itemUnitPrice').val(); 
    let itemUpdatedPrice = itemUnitPrice * currentQty; 
    $(obj).parent().find('.itemPrice').val(itemUpdatedPrice)
        
    if (!$(obj).hasClass('plusNew')) {
       if (itemPrice != '' && cartTotal != '' && !$(obj).hasClass('plusNew')) { 
        updatedCartTotal = parseFloat(cartTotal) - parseFloat(itemPrice);
       } else {
        updatedCartTotal = parseFloat(cartTotal);
       }
       
        updatedCartTotal = parseFloat(updatedCartTotal) + parseFloat(itemUpdatedPrice); 
        $(".cartTotalAmount").html('$' + updatedCartTotal.toFixed(2))
        $(".order_total").val(updatedCartTotal.toFixed(2));
    }  
}
$(document).on('click', '.minus, .minusNew', function() {
    var input = $(this).parent().find('.product-quantity');
    var currentValue = parseInt(input.val());
    input.value = currentValue;
     if (currentValue >= 1) {
        input.val(currentValue - 1);
    }
    let currentQty = currentValue;
    if(currentQty > 0){
    currentQty = parseInt(input.val());
    let itemUnitPrice = $(this).parent().find('.itemUnitPrice').val(); 
    let itemUpdatedPrice = itemUnitPrice * currentQty; 
  
    $(this).parent().find('.itemPrice').val(itemUpdatedPrice)
    
    if (!$(this).hasClass('minusNew')) {
        
    let cartTotal = $(".cartTotalAmount").html().replace(/\$/g, '');    
    let updatedCartTotal = parseFloat(cartTotal);    
    updatedCartTotal = parseFloat(updatedCartTotal) - parseFloat(itemUnitPrice); 
    $(".cartTotalAmount").html('$'+updatedCartTotal.toFixed(2));
    $(".order_total").val(updatedCartTotal.toFixed(2));
    
    }
    }
    
     
   
});
                                  
                                      
$(document).ready(function () {
         $(".btnBeforeAjax").hide();
         let selectedSuppId = '<?php echo $suppId; ?>';
         let isMonthlyStockOrder = '<?php echo $isMonthlyStockOrder; ?>';

          selectedSuppId = selectedSuppId.split("_");
          selectedSuppId = selectedSuppId[0];
           
    if (typeof selectedSuppId !== 'undefined' && selectedSuppId !== null && selectedSuppId.trim() !== '') {
         
        selectedSuppId = selectedSuppId.split("_");
        let suppId = selectedSuppId[0];
        $("#supplierNameInput").val(suppId); 
        $('.Ajaxloader-demo-box').toggleClass('d-none');
        fetchItemOfSupplier(suppId);
      }
          let product_UOM = '<?php echo json_encode($product_UOM); ?>';
           let allUOM = JSON.parse(product_UOM);
  
    var productListTable = $('#productListTable').DataTable({
        "paging": false,
        "info": false,
        "order" :[],
        "lengthChange": false
    });
    var deletedProductListTable = $('#newProductTable').DataTable({
        "paging": false,
        "info": false,
        "order" :[],
        "lengthChange": false
    });

    $('#supplierNameInput').on('change', function () {
        $('.Ajaxloader-demo-box').toggleClass('d-none');
        let supId = $(this).val();
       window.location.href = '/Supplier/placeOrder/'+supId+'_0_0';     
  // Added 0 0 because function being called from multiple place accept the argument in above fomrat only     
    });
  
  function fetchItemOfSupplier(supId){
       let currentStock = [];
       $.ajax({
            type: "POST",
            url: "/Supplier/fetchSupplierItems",
            data: 'supplier_id=' + supId,
            success: function (suppProducts) {
                let response = JSON.parse(suppProducts);
                let allproducts = response['productDetails'] || [];
                let suppDetails = response['suppDetails'] || [];
                let htmlC = '';
                let htmlD = '';
                let trForDynamicHeader = $('thead.tableDynamicHeader tr');
                let loopCount = 0;
                let stockTh = trForDynamicHeader.find('.stockTh');
                let productWithZeroOrderQty = [];
                let orderTotal = 0;
                stockTh.nextAll('th').remove();
                
                // Clear existing data in the DataTable
                productListTable.clear();
                deletedProductListTable.clear();
                if(suppDetails[0]?.requireSC == "1"){
                $(".viewStockSummary").removeClass('d-none');
                let dynamicUrl = '/Supplier/stockupdate/'+supId+'_'+suppDetails[0]?.requirePL;
                $(".viewStockSummary").attr('href', dynamicUrl);
                }else{
                 if (!$(".viewStockSummary").hasClass('d-none')) {
                 $(".viewStockSummary").addClass('d-none');       
                 }
                   
                }
                if(suppDetails[0]?.min_order){
                  $(".minOrder").html('$'+suppDetails[0]?.min_order)  
                }else{
                    $(".minOrder").html('');
                }
                // if(suppDetails[0]?.requireDD == 1){
                //     $(".requireDD").removeClass('d-none');
                // }else{
                //   $(".requireDD").addClass('d-none');  
                // } 
                
                if(suppDetails[0]?.delivery_date_type == "dateWise"){
                    let currentDate = new Date();
                    let numberOfDays = suppDetails[0]?.deliveryDateFreq ? suppDetails[0]?.deliveryDateFreq : 0;
                    currentDate.setDate(currentDate.getDate() + parseInt(numberOfDays));
                     let formattedDate = currentDate.toLocaleDateString('en-US', {
                     day: 'numeric',
                     month: 'short',
                     year: 'numeric'
                     });
                  document.querySelector('input[name="delivery_date"]').value = formattedDate;
                    console.log("Date after adding 2 days: ", currentDate);
                    
                }else if(suppDetails[0]?.delivery_date_type == "dayWise"){
                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']; 
                    const currentDate = new Date();
                    let dayName = suppDetails[0]?.deliveryDayFreq ? suppDetails[0]?.deliveryDayFreq : '';
                    const desiredDayIndex = daysOfWeek.indexOf(dayName);
                    const currentDayIndex = currentDate.getDay();
                    let dayDifference = desiredDayIndex - currentDayIndex;
                    if (dayDifference <= 0) {
                      dayDifference += 7;
                    }
                     const nextDayDate = new Date(currentDate);
                     nextDayDate.setDate(currentDate.getDate() + dayDifference);
                     
                   const formattedDate = nextDayDate.toLocaleDateString('en-US', {
                   day: 'numeric',
                   month: 'short',
                   year: 'numeric'
                   })
                   document.querySelector('input[name="delivery_date"]').value = formattedDate;
                } else{
                    
                }
                
                if(suppDetails[0]?.delivery_info !=''){
                    $(".delivery_info").html(suppDetails[0]?.delivery_info)
                }else{
                    $(".delivery_info").html('');
                } 
                
                if(suppDetails[0]?.email !=''){
                    $(".supplier_email").val(suppDetails[0]?.email)
                }else{
                    $(".supplier_email").val('');
                } 
                
                if(suppDetails[0]?.email !=''){
                    $(".supplier_CCemail").val(suppDetails[0]?.cc)
                }else{
                    $(".supplier_CCemail").val('');
                }
                
                
       
          allproducts.forEach(function (value, index) {
   
           let stockQtyForTodayForThisProduct = value?.totalStockCountTotalValue || 0;
           let uomName = '';
  
           let tier_type = value?.tier_type ? value?.tier_type : '';
           if(tier_type == 't2' || tier_type == 't3'){
           let foundUOM = allUOM.find(obj => obj.product_UOM_id === value?.cafe_unit_uom);
           uomName = foundUOM ? foundUOM.product_UOM_name : '';  
           }else {
           let foundEachUOM = allUOM.find(obj => obj.product_UOM_id === value?.each_unit_uom);
           uomName = foundEachUOM ? foundEachUOM.product_UOM_name : '';   
         }
  
   
   
  let orderQty = value?.orderQty || 0;
  orderTotal = parseFloat(orderTotal) + parseFloat(orderQty*value?.price);
 
 if(((suppDetails[0]?.requireSC == "1" || suppDetails[0]?.requirePL == "1") && parseInt(orderQty) > 0) || (suppDetails[0]?.requireSC == "0" && suppDetails[0]?.requirePL == "0") || (suppDetails[0]?.requireSC == "1" && suppDetails[0]?.requirePL == "0") || (isMonthlyStockOrder == 1)){
       
  htmlC += '<tr id="row_'+value?.product_id+'">';
  htmlC += '<td scope="row"><input type="hidden"  value="' + (value?.product_code || '') + '">' + (value?.product_code || '') + '</td>';
  htmlC += '<td scope="row" class="product_name"><input type="hidden" class="product_price" value="' + (value?.price || 0) + '"><input type="hidden" name="product_id[]" value="' + (value?.product_id || '') + '">' + (value?.product_name || '') + '</td>';
  htmlC += '<td scope="row" class="product_uom"><input type="hidden" name="product_uom_id[]"  value="' + (value?.product_uom_id || '') + '">' + uomName + '</td>';
  htmlC +='<input type="hidden" name="product_unit_price[]"  value="' + (value?.price || '') + '">';
  
  htmlC += '<td scope="row" style="width: 18%;" class="deleteTD">';
  htmlC += '<div class="input-step step-success cartQtyChange"><input class="itemPrice" type="hidden"  value="' + (orderQty*value?.price || 0) + '">';
  htmlC += '<input class="itemUnitPrice" type="hidden"  value="' + (value?.price || '') + '">';
  htmlC += '<button type="button" class="minus shadow">–</button>';
  htmlC += '<input type="number" min="0" max="100000"  class="product-quantity" name=orderQty_' + (value?.product_id || '') + ' value="' + (orderQty < 1 ? 0 : orderQty) + '">';
  htmlC += '<button type="button" class="plus shadow">+</button>';
  htmlC += '</div>';
  htmlC += '<a class="text-danger d-inline-block remove-item-btn mx-4"  href="#">';
  htmlC += '<i class="ri-delete-bin-5-fill fs-22"></i>';
  htmlC += '</a></td>';   
 
  htmlC += '</tr>';
  loopCount++;
 }else{
     // append all the products whose order qty is 0 based on stock count required or not and PAR Level required or not for this supp. to a popup of "Add new product"
  htmlD += '<tr id="row_'+value?.product_id+'">';
  htmlD += '<td scope="row"><input type="hidden"  value="' + (value?.product_code || '') + '">' + (value?.product_code || '') + '</td>';
  htmlD += '<td scope="row" class="product_name"><input type="hidden" class="product_price" value="' + (value?.price || 0) + '"><input type="hidden" name="product_id[]" value="' + (value?.product_id || '') + '">' + (value?.product_name || '') + '</td>';
  htmlD += '<td scope="row" class="product_uom"><input type="hidden" name="product_uom_id[]"  value="' + (value?.product_uom_id || '') + '">' + uomName + '</td>';
  htmlD +='<input type="hidden" name="product_unit_price[]"  value="' + (value?.price || '') + '">';
  
  htmlD += '<td scope="row" style="width: 18%;" class="deleteTD">';
  htmlD += '<div class="input-step step-success cartQtyChange"><input class="itemPrice" type="hidden"  value="' + (orderQty*value?.price || 0) + '">';
  htmlD += '<input class="itemUnitPrice" type="hidden"  value="' + (value?.price || '') + '">';
  htmlD += '<button type="button" class="minusNew shadow">–</button>';
  htmlD += '<input type="number" min="0" max="100000"  class="product-quantity" name=orderQty_' + (value?.product_id || '') + ' value="' + (orderQty < 1 ? 0 : orderQty) + '">';
  htmlD += '<button type="button" class="plusNew shadow">+</button>';
  htmlD += '</div></td>';
  htmlD += '<td class="addToCart"><div class="flex-shrink-0 avatar-xs"><div class="avatar-title bg-success rounded-circle shadow">';
  htmlD += '<a href="#"><i class="ri-shopping-cart-2-fill text-muted" title="Click to add to cart"></i></a>';
  htmlD += '</div></div></td>';
  htmlD += '</tr>';
     productWithZeroOrderQty.push(value)
 }
});

$(".prdctWithZeroOrderQty").append(htmlD)

$(".cartTotalAmount").html('$'+orderTotal.toFixed(2))
$(".order_total").val(orderTotal.toFixed(2));
             
                productListTable.rows.add($(htmlC)).draw();
                deletedProductListTable.rows.add($(htmlD)).draw();

                // Continue with other code

                $('.Ajaxloader-demo-box').toggleClass('d-none');
            }
        });
  }

    $('#productListTable').on('click', '.remove-item-btn', function (e) {
    productListTable.clear();
    deletedProductListTable.clear();
   
    let tbody = $(".prdctWithZeroOrderQty");
    tbody.find("tr:has(td:only-child)").remove();
    e.preventDefault();
    let row = $(this).closest('tr'); // Find the closest row to the clicked delete icon
    let addToCartIcon = '<td class="addToCart"><div class="flex-shrink-0 avatar-xs "><div class="avatar-title bg-success rounded-circle shadow"><a href="#"><i class="ri-shopping-cart-2-fill text-muted" title="Click to add to cart"></i></a></div></div></td>';
    let itemPrice = row.find('.itemPrice').val();
    row.find('.plus').removeClass('plus').addClass('plusNew');
    row.find('.minus').removeClass('minus').addClass('minusNew');
    row.find('.remove-item-btn').replaceWith(addToCartIcon); 
    row.find("td:only-child").remove();
    row.detach(); // Remove the row from the current table
    
    $('.prdctWithZeroOrderQty').append(row); 
    let updatedRows = $(".prdctWithZeroOrderQty").html();
    // let updatedRowsProductTable = $(".suppliersProductsStock").html();
    deletedProductListTable.rows.add($(updatedRows)).draw();
    // productListTable.rows.add($(updatedRowsProductTable)).draw();
    
    let cartTotal = $(".cartTotalAmount").html().replace(/\$/g, '');
    let updatedCartTotal = parseFloat(cartTotal) - parseFloat(itemPrice);
    // console.log("cartTotal",cartTotal)
    
    // console.log("itemPrice",itemPrice)
    $(".cartTotalAmount").html('$'+updatedCartTotal.toFixed(2))
     $(".orderTotal").val(updatedCartTotal.toFixed(2));
});

    $('.prdctWithZeroOrderQty').on('click', '.addToCart', function (e) {
     productListTable.clear();
     deletedProductListTable.clear();
     let tbody = $(".suppliersProductsStock");
      tbody.find("tr:has(td:only-child)").remove();
      e.preventDefault();
    let row = $(this).closest('tr');
    row.find('.plusNew').removeClass('plusNew').addClass('plus'); // because when item is in popup, on change of qty, we dont incrz cart price untill added to cart
    row.find('.minusNew').removeClass('minusNew').addClass('minus');
    let itemPrice = row.find('.itemPrice').val();
    let deleteIcon = '<a class="text-danger d-inline-block remove-item-btn mx-4"  href="#"><i class="ri-delete-bin-5-fill fs-22"></i></a>';
    row.find('.addToCart').remove();
    row.find('.deleteTD').append(deleteIcon);
   
    row.detach(); 
  
    $('.suppliersProductsStock').append(row);
    
    // let qtyValue = row.find('.product-quantity').val();
    // tbody.find('.product-quantity').val(qtyValue)
    //   

    let updatedRows = $(".prdctWithZeroOrderQty").html();
    let updatedRowsProductTable = $(".suppliersProductsStock").html();
  
    // deletedProductListTable.rows.add($(updatedRows)).draw();
    // productListTable.rows.add($(updatedRowsProductTable)).draw();
    
    let cartTotal = $(".cartTotalAmount").html().replace(/\$/g, '');
    
    let updatedCartTotal = parseFloat(cartTotal ? cartTotal : 0) + parseFloat(itemPrice ? itemPrice : 0);
    $(".cartTotalAmount").html('$'+updatedCartTotal.toFixed(2))
    $(".orderTotal").val(updatedCartTotal.toFixed(2));
});





});

$(document).ready(function () {
    
         let budgetRemaining = '<?php echo $budgetRemaining; ?>';
         let actualBudget = '<?php echo $actualBudget; ?>';
         let allowForceOrder = '<?php echo $allowForceOrder; ?>';

    $("#orderForm").on("submit", function (e) {
       
        e.preventDefault(); // Prevent the default form submission
       $('.Ajaxloader-demo-box').toggleClass('d-none');
        var formData = $(this).serialize();
        let isOrderBudgetExceeded = 'no';
        
       if (localStorage.getItem('orderBudgetExceeded') !== null) {
        isOrderBudgetExceeded = 'Yes';
         }

        $.ajax({
            type: "POST",
            url: "/Supplier/sendOrder/"+isOrderBudgetExceeded,
            data: formData,
            success: function (orderId) {
               $(".btnBeforeAjax").hide();$(".btnAfterAjax").show();
               $('.alert-success').toggleClass('d-none');
               setTimeout(function() {
                $('.alert-success').removeClass('d-none');
                }, 5000); 
                localStorage.removeItem("minOrderInfoRead");
              if (isOrderBudgetExceeded == 'Yes') {
               notifyManagerAboutBudgetExceededOrder(orderId);
               localStorage.removeItem('orderBudgetExceeded');
               
               }else{
              window.location.href = '/Supplier/<?php echo $this->session->userdata('system_id'); ?>';      
               }  
              
            },
            error: function (xhr, status, error) {
                // Handle any errors (if needed)
                console.error(xhr, status, error);
                 $('.alert-danger').toggleClass('d-none');
               setTimeout(function() {
                $('.alert-success').removeClass('d-none');
                }, 5000); 
            }
        });
    });
    
    $("#sendOrder").on("click", function (e) {
        let cartTotal = $(".cartTotalAmount").html().replace(/\$/g, '');
        console.log("cartTotal",cartTotal)
         $(".order_total").val(cartTotal);
        let minOrder = $(".minOrder").html().replace(/\$/g, '');
        
        let validationResult = validateOrderBeforePlacing(cartTotal);
        if(validationResult){
          return false;  
        }
        //  return false; 
        let isUserreadWarningMessage = '';
        if (localStorage.getItem('minOrderInfoRead') !== null) {
             isUserReadWarningMessage =  localStorage.getItem('minOrderInfoRead');
        }
        
  
        if((parseFloat(cartTotal) < parseFloat(minOrder)) && isUserReadWarningMessage !='Yes'){
        $("#minOrderModal").modal('show');
        return false;
        }else{
        $(".btnBeforeAjax").show();
        $(".btnAfterAjax").hide();
        e.preventDefault(); 
        $("#orderForm").submit();      
        }
        
    });
    localStorage.setItem('minOrderInfoRead', 'No');
  $('#minOrderModal').on('hidden.bs.modal', function (e) {
    // This code will be executed when the modal is closed
    localStorage.setItem('minOrderInfoRead', 'Yes');
    // Add your logic here to determine if the user read the message
});  

function validateOrderBeforePlacing(cartTotal){
    let inputDateStr = $('input[name="delivery_date"]').val(); 
    let isNextWeek = isDateFromNextWeekOrFuture(inputDateStr);
  
    if(allowForceOrder == 1){
     console.log("isNextWeek",isNextWeek)
     if(isNextWeek =='past Dates'){
      alert("Date cannot be in the past."); 
      return true;
      }
    
      if(isNextWeek && (parseFloat(cartTotal) > parseFloat(actualBudget))){
       $("#forceOrderModal").modal('show');
        return true;     
      }else if((parseFloat(cartTotal) > parseFloat(budgetRemaining)) && isNextWeek == false){
       $("#forceOrderModal").modal('show');
        return true; 
     }   
    }else{
      if(parseFloat(cartTotal) > parseFloat(budgetRemaining)){
        localStorage.setItem('orderBudgetExceeded','Yes');
        $("#forceOrderModalForNotAllowedCase").modal('show');
        return true;
     }else{
         localStorage.removeItem('orderBudgetExceeded');
     }  
    }
    
}
  

function isDateFromNextWeekOrFuture(dateStr) {
  // Parse the date string to a Date object
   
  const dateObj = new Date(dateStr);
  let result = '';
 
  const today = new Date();
  
  if (dateObj < today) {
    return 'past Dates'; // Indicate invalid date
  }

  // Calculate next Monday (considering week begins on Monday)
  const nextMonday = new Date(today.getFullYear(), today.getMonth(), today.getDate() + (7 - (today.getDay() + 6) % 7));

  result =  dateObj >= nextMonday;
  return result;
}
  
function notifyManagerAboutBudgetExceededOrder(orderId){
  let supplierId = $("#supplierNameInput").val();
        $.ajax({
            type: "POST",
            url: "/Supplier/notifyManagerAboutBudgetExceededOrder",
            data: 'order_id='+orderId+'&supplierId='+supplierId,
            success: function () {
      window.location.href = '/Supplier/<?php echo $this->session->userdata('system_id'); ?>';
            }
            
        });  
    
    
    
}   
    
});

function sendOrder(){
      $("#orderForm").submit();
  } 
  $(function() {
    // Make the table rows sortable
    $("#sortable").sortable({
      
        update: function(event, ui) {
            let sortOrder = $(this).sortable("toArray", { attribute: "id" });

            $.ajax({
                url: "/Supplier/productUpdateSortOrder",
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
       

 </script>
                                
                                