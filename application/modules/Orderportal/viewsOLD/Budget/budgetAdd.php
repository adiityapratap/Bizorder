<style>
.customBudgetInput{
    height: 38px;
    font-weight: 500;
    font-family: Inter,sans-serif;
    font-size: 1.421875rem;   
}
input[readonly] {
    background-color: #ffffff59 !important;
}
</style>

<?php
$currentDate = new DateTime();
$weekStartDate = $currentDate->modify('this week')->format('d-m-Y');
$weekEndDate = $currentDate->modify('this week +6 days')->format('d-m-Y');
$monthStartDate = $currentDate->format('01-m-Y');
$monthEndDate = $currentDate->format('t-m-Y');


?>
<div class="main-content">

            <div class="page-content">
                <form id="supplierBudgetForm" action="/Supplier/budgetrecordsave" method="POST"> 
                <div class="container-fluid">
                  
                  
                  <div class="row">
                 <div class="col-lg-6 align-items-center" style="text-align: left;">
                   <h4 class="flex-grow-1 text-black">Budget Management</h4>
                          
               <div class="d-flex gap-3">    
                   <div class="info-box">
                <span class="info-box-icon bg-danger">
                </span>
                   <div class="info-box-content">
                     <span class="info-box-text">Multiple Supplier</span>
                    </div>
                 </div>

                <div class="info-box">
                 <span class="info-box-icon bg-success">
                  </span>
               <div class="info-box-content">
                 <span class="info-box-text">Single Supplier</span>
   
                     </div>
                      </div>
                       </div>
                   
                   
                      </div>
                        <div class="col-lg-6 flex-shrink-0 mb-3" style="text-align: right;">
                          <button  class="btn btn-blue add-btn"><i id="create-btn" class="ri-exchange-dollar-fill align-bottom me-1"></i> Save Budget</button>
                         
                         </div>     
                  <div class="col-xxl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex mb-1">
                                             <div class="flex-grow-1">
                                                <a href="javascript:void(0);" class="badge bg-danger fs-14">Location Budget  </a>
                                            </div>
                                            <div class="flex-shrink-0">
                                        <i class="ri-exchange-dollar-line fs-24" ></i>        
                                            </div>
                                        </div> 
                                     <div class="d-flex gap-2"> 
                                       <div class="flex-grow-1 ">     
                                     <div class="form-icon mb-2">          
                                    <input type="number" class="form-input form-control-icon w-100 customBudgetInput weeklyLocationBudget" name="weeklyLocationBudget" value="<?php echo (isset($locationBudgetDetails->weeklyLocationBudget) ? $locationBudgetDetails->weeklyLocationBudget : '') ?>" data-target="<?php echo (isset($locationBudgetDetails->weeklyLocationBudget) ? $locationBudgetDetails->weeklyLocationBudget : '') ?>">
                                     <i class="bx bx-dollar fs-22"></i> 
                                      </div> 
                                    <h6 class="text-black mb-0">Weekly</h6>
                                          </div> 
                                       <div class="flex-grow-1 ">     
                                       <div class="form-icon mb-2">          
                                    <input type="number" class="form-input form-control-icon w-100 customBudgetInput monthlyLocationBudget" name="monthlyLocationBudget" value="<?php echo (isset($locationBudgetDetails->monthlyLocationBudget) ? $locationBudgetDetails->monthlyLocationBudget : '') ?>" data-target="<?php echo (isset($locationBudgetDetails->monthlyLocationBudget) ? $locationBudgetDetails->monthlyLocationBudget : '') ?>">
                                     <i class="bx bx-dollar fs-22"></i> 
                                      </div> 
                                        <h6 class="text-black mb-0">Monthly</h6>
                                          </div>       
                                         </div> 
                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                   <div class="col-xxl-3 col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            
                                            <div class="flex-grow-1">
                                                <a href="javascript:void(0);" class="badge bg-blue fs-14">Allocated Budget </a>
                                            </div>
                                            <div class="flex-shrink-0 ">
                                                 <i class="ri-exchange-dollar-line fs-24" ></i>     
                                            </div>
                                        </div> 
                                        <div class="d-flex">
                                       <div class="flex-grow-1">     
                                        <h3 class="mb-2 text-black">$<span class="counter-value counter-valueWeekly text-black" data-target="<?php echo (isset($locationBudgetDetails->weeklyAllocatedBudget) ? $locationBudgetDetails->weeklyAllocatedBudget : '') ?>"><?php echo (isset($locationBudgetDetails->weeklyAllocatedBudget) ? $locationBudgetDetails->weeklyAllocatedBudget : '') ?></span></h3>
                                        <input type="hidden" name="weeklyAllocatedBudget" class="weeklyAllocatedBudget" value="<?php echo (isset($locationBudgetDetails->weeklyAllocatedBudget) ? $locationBudgetDetails->weeklyAllocatedBudget : '') ?>" >
                                        <h6 class="text-black mb-0">Weekly</h6>
                                          </div> 
                                       <div class="flex-grow-1">     
                                        <h3 class="mb-2 text-black">$<span class="counter-value counter-valueMonthly text-black" data-target="<?php echo (isset($locationBudgetDetails->monthlyAllocatedBudget) ? $locationBudgetDetails->monthlyAllocatedBudget : '') ?>"><?php echo (isset($locationBudgetDetails->monthlyAllocatedBudget) ? $locationBudgetDetails->monthlyAllocatedBudget : '') ?></span></h3>
                                         <input type="hidden" name="monthlyAllocatedBudget" class="monthlyAllocatedBudget" value="<?php echo (isset($locationBudgetDetails->monthlyAllocatedBudget) ? $locationBudgetDetails->monthlyAllocatedBudget : '') ?>">
                                        <h6 class="text-black mb-0">Monthly</h6>
                                          </div>       
                                         </div> 
                                    </div>
                                </div><!--end card-->
                            </div><!--end col--> 
                             
                    </div>
                    
                  
                     <div class="row">
                        
                         
                          <div class="col-lg-12">
                            <div class="card" id="orderList">
                                <div class="card-body ">
                                  <div class="tab-content mb-1">
                                     <table class="table-responsive table align-middle  mb-0 table-bordered" id="SupplierDataTable">
                                         
                                         
      <thead class="table-light tableDynamicHeader text-center w-100">
    <tr>
        <th rowspan="2">Category Name</th>
        <th colspan="4">Weekly ( <?php echo $weekStartDate .' to '.$weekEndDate ?> ) </th>
        <th colspan="4">Monthly ( <?php echo $monthStartDate .' to '.$monthEndDate ?> )</th>
        <th rowspan="2" colspan="1">Action</th>
    </tr>
    <tr class="areaList">
        <th>Budget</th>
        <th>Spent</th>
        <th>Remaining</th>
        <th>%</th>
        
        <th>Budget</th>
        <th>Spent</th>
        <th>Remaining</th>
         <th>%</th>
    </tr>
</thead>


                                                    <?php if(!empty($allCatAndSubs)) { ?>
                                                        <?php foreach($allCatAndSubs as $mainCategoryIdAndNameIndex => $allCatAndSub){   ?>
                                                        <?php $mainCategoryIdAndName  = explode('_', $mainCategoryIdAndNameIndex); ?>
                                                        <?php $mainCategoryId = $mainCategoryIdAndName[0];  ?>
                                                        <?php $mainCategoryName = $mainCategoryIdAndName[1];  ?>
                                                        <?php  $totalWeeklyBudget = 0;   ?>
                                                        <?php  $totalMonthlyBudget = 0;   ?>
                                                        <?php  $totalWeeklyPercentage = 0;   ?>
                                                        <?php  $totalMonthlyPercentage = 0;   ?>
                                                        <?php  $totalWeeklyRemaining = 0;   ?>
                                                        <?php  $totalMonthlyRemaining = 0;   ?>
                                                         <?php  $totalWeeklySpent = 0;   ?>
                                                         <?php  $totalMonthlySpent = 0;   ?>
                                      <tbody class="list main-category-row" >                                    
                                           <th colspan="10" class="text-black w-100" style="background-color: #dff0fa;"> <b><?php echo $mainCategoryName; ?></b></th>
                                                          <?php if(!empty($allCatAndSub)) { ?>
                                                        <?php foreach($allCatAndSub as $subCatDetails){   ?>
                                                       <?php
$totalWeeklyBudget += $subCatDetails['weeklyBudget'] ?? 0;
$totalMonthlyBudget += $subCatDetails['monthlyBudget'] ?? 0;
$totalWeeklyPercentage += $subCatDetails['weeklyPercentage'] ?? 0;
$totalMonthlyPercentage += $subCatDetails['monthlyPercentage'] ?? 0;

$weeklyRemaining = $subCatDetails['weeklyBudget'] ?? 0;
$weeklyRemaining -= $subCatDetails['weeklySpent'] ?? 0;
$totalWeeklyRemaining += $weeklyRemaining;

$monthlyRemaining = $subCatDetails['monthlyBudget'] ?? 0;
$monthlyRemaining -= $subCatDetails['monthlySpent'] ?? 0;
$totalMonthlyRemaining += $monthlyRemaining;

$totalWeeklySpent += $subCatDetails['weeklySpent'] ?? 0;
$totalMonthlySpent += $subCatDetails['monthlySpent'] ?? 0;
?>
                                                <tr id="row_<?php echo  $subCatDetails['id']; ?>" class="parentRow">
                                                      <input type="hidden" class="mainCatId" value="<?php echo $mainCategoryId; ?>">
                                                      <input type="hidden" name="subCatId[]" value="<?php echo $subCatDetails['id']; ?>">
                                                       <td class="sub_category_name"><?php echo (isset($subCatDetails['category_name']) ? $subCatDetails['category_name'] : ''); ?></td>
                                                        
                                                        <td class="weeklybudget">
                                                         <div class="form-icon"> 
                                                        <input type="text" pattern="[0-9]+(\.[0-9]+)?" class="form-control form-control-icon weekly_budget w-75 " name="weekly_<?php echo  $subCatDetails['id']; ?>" value="<?php echo ((isset($subCatDetails['weeklyBudget']) ? $subCatDetails['weeklyBudget'] : '')); ?>">        
                                                         <i class="bx bx-dollar"></i>
                                                        </div>
                                                        </td>
                                                    
                                                  <td class="weeklySpent" ><?php echo (isset($subCatDetails['weeklySpent']) ? '$'.number_format($subCatDetails['weeklySpent'], 2, '.', ',') : '');  ?></td> 
                                               <td class="weeklyRemaining" ><?php echo '$'.number_format($weeklyRemaining, 2, '.', ','); ?></td>
                                              
    <input type="hidden" class="weeklyPercentage" name="weeklyPercentage_<?php echo $subCatDetails['id']; ?>" value="<?php echo ((isset($subCatDetails['weeklyPercentage']) ? $subCatDetails['weeklyPercentage'].'%' : '')); ?>">                              
                                               
                                               <td class="weeklyPercentageTd"><?php echo ((isset($subCatDetails['weeklyPercentage']) ? $subCatDetails['weeklyPercentage'].'%' : '')); ?></td>       

                                               
                                                     <td class="monthlybudget">
                                                       <div class="form-icon">     
                                                        <input type="text" pattern="[0-9]+(\.[0-9]+)?" name="monthly_<?php echo $subCatDetails['id']; ?>"  class="form-control form-control-icon monthly_budget w-75 " value="<?php echo ((isset($subCatDetails['monthlyBudget']) ? $subCatDetails['monthlyBudget'] : '')); ?>">        
                                                        <i class="bx bx-dollar"></i> 
                                                         </div>
                                                        </td>
                                               <td class="monthlySpent"><?php echo (isset($subCatDetails['monthlySpent']) ? '$'.number_format($subCatDetails['monthlySpent'], 2, '.', ',') : '');  ?></td> 
                                               <td class="monthlyRemaining"><?php echo '$'.number_format($monthlyRemaining, 2, '.', ','); ?></td>
                                               
    <input type="hidden" class="monthlyPercentage" name="monthlyPercentage_<?php echo $subCatDetails['id']; ?>" value="<?php echo ((isset($subCatDetails['monthlyPercentage']) ? $subCatDetails['monthlyPercentage'].'%' : '')); ?>">                                           
                                     <td class="monthlyPercentageTd"><?php echo ((isset($subCatDetails['monthlyPercentage']) ? $subCatDetails['monthlyPercentage'].'%' : '')); ?></td>    

                                    <td>
                                <?php $classNameBtn = (isset($subCatDetails['hasMultipleSupplier']) && $subCatDetails['hasMultipleSupplier'] == true ? 'btn-orange' : 'btn-success') ?>        
                               <button class="btn btn-sm <?php echo $classNameBtn; ?>" type="button"  aria-controls="offcanvasRight" onclick="fetchSupplierFromSubCatID(this,<?php echo $subCatDetails['id']; ?>)">Suppliers</button>         
                                </td>   
                                     </tr>
                                                      
                                                   <?php } ?>
                                                     <?php } ?>
                                        <tr style="background-color: #fff64463;" >
                                        <td><b>Total <?php echo $mainCategoryName; ?></b></td>
          <td>
         <div class="form-icon">  
        <input type="text" pattern="[0-9]+(\.[0-9]+)?" name="totalWeeklybudget_<?php echo $mainCategoryId ?>" readonly class="form-control mainCatTotal form-control-icon border-0 w-75 totalWeeklybudget_<?php echo $mainCategoryId ?>" value="<?php echo ((isset($totalWeeklyBudget) ? $totalWeeklyBudget : '')); ?>">
         <i class="bx bx-dollar"></i> 
        </div>
        </td>
     
     <td class="totalWeeklySpent"><?php echo '$'.number_format($totalWeeklySpent, 2, '.', ','); ?></td>  
     <td class="totalWeeklyRemaining"><?php echo '$'.number_format($totalWeeklyRemaining, 2, '.', ','); ?></td> 
    <td class="totalWeeklyPercentage_<?php echo $mainCategoryId; ?>"><?php echo ((isset($totalWeeklyPercentage) ? $totalWeeklyPercentage.'%' : '')); ?></td> 

    <td>
    <div class="form-icon">     
        <input type="text" pattern="[0-9]+(\.[0-9]+)?" name="totalMonthlybudget_<?php echo $mainCategoryId ?>" readonly class="form-control form-control-icon border-0 w-75 mainCatTotalMonthly totalMonthlybudget_<?php echo $mainCategoryId ?>" value="<?php echo ((isset($totalMonthlyBudget) ? $totalMonthlyBudget : '')); ?>">
     <i class="bx bx-dollar"></i> 
        </div>    
        </td>  
                                        <td class="totalMonthlySpent"><?php echo '$'.number_format($totalMonthlySpent, 2, '.', ',');  ?></td>  
                                        <td class="totalMonthlyRemaining"><?php echo  '$'.number_format($totalMonthlyRemaining, 2, '.', ','); ?></td>
                                      <td class="totalMonthlyPercentage_<?php echo $mainCategoryId; ?>"><?php echo ((isset($totalMonthlyPercentage) ? $totalMonthlyPercentage.'%' : '')); ?></td> 

                                        <td class="waste"></td>  
                                            </tr>    
                                            </tbody> 
                                                    <?php } ?>
                                                    <?php } ?>
                                            </table>
                                          </div>
                                </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
               
                </div>
                </form>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

          
        </div>
      
 <?php $this->load->view('supplierListWithBudgetCanvas'); ?>
</body>
<script>

       $(document).ready(function() {
          $('.saveBudgetDataAlert').hide();
          
          let sumOfMainCatweekly = 0;
          let sumOfMainCatmonthly = 0;
          $('.mainCatTotal').each(function() {
            sumOfMainCatweekly += parseFloat($(this).val()) || 0;
          });
          
          $('.mainCatTotalMonthly').each(function() {
            sumOfMainCatmonthly += parseFloat($(this).val()) || 0;
          });
          
          $(".counter-valueWeekly").html(sumOfMainCatweekly.toFixed(2));
          $(".weeklyAllocatedBudget").val(sumOfMainCatweekly.toFixed(2));
          $(".counter-valueMonthly").html(sumOfMainCatmonthly.toFixed(2));
          $(".monthlyAllocatedBudget").val(sumOfMainCatmonthly.toFixed(2));
          
        
            
             $('.monthlyLocationBudget').on('input', function() {
                let monthlyLocationBudget = $(this).val();
                let weeklyBudgetValue = monthlyLocationBudget/4;
                $(".weeklyLocationBudget").val(weeklyBudgetValue);
               
            });
            
            $('.weeklyLocationBudget').on('input', function() {
                let weeklyLocationBudget = $(this).val();
                let monthlyBudgetValue = weeklyLocationBudget*4;
                $(".monthlyLocationBudget").val(monthlyBudgetValue);
                
            });
           
            $('.monthly_budget').on('change', function() {
                let monthlyBudgetValue = $(this).val();
                let mainCatId = $(this).parents(".parentRow").find(".mainCatId").val();
                // let weeklyBudgetValue = monthlyBudgetValue/4;
                let totalMonthlybudget = 0;
                
                // $(this).parents(".parentRow").find(".weekly_budget").val(weeklyBudgetValue);
                
                 $(this).parents(".main-category-row").find(".parentRow").each(function(index, element) {
                let currentRowMonthlybudget =  $(this).find('.monthlybudget').find('.monthly_budget').val();
                totalMonthlybudget =  parseFloat(totalMonthlybudget) + parseFloat(currentRowMonthlybudget || 0);
                }); 
                
                
                 calculateTotalMonthly(this,mainCatId,totalMonthlybudget);
            });
            
            $('.weekly_budget').on('change', function() {
                let weeklyBudgetValue = $(this).val();
                // let monthlyBudgetValue = weeklyBudgetValue*4;
                let totalWeeklybudget = 0;
                
                // $(this).parents(".parentRow").find(".monthly_budget").val(monthlyBudgetValue);
                let mainCatId = $(this).parents(".parentRow").find(".mainCatId").val();
                
                $(this).parents(".main-category-row").find(".parentRow").each(function(index, element) {
                let currentRowWeeklybudget =  $(this).find('.weeklybudget').find('.weekly_budget').val();
                totalWeeklybudget =  parseFloat(totalWeeklybudget) + parseFloat(currentRowWeeklybudget || 0);
                });    
                
                calculateTotalWeekly(this,mainCatId,totalWeeklybudget);
            });
            
            // for supplier in right drawer
            
    //         // Use event delegation for dynamically generated elements
     $(document).on('input', '.weeklyBudgetvalSupplier', function() {
        let totalAllocatedtoSubCat = $(".selectedSubCatId").val();
        let weeklyBudgetInputs = $('.weeklyBudgetvalSupplier');
        let sumOfBudgetAllocatedToSuppliers = 0;

        weeklyBudgetInputs.each(function () {
        let inputValue = parseFloat($(this).val());
        if(inputValue === '' || isNaN(inputValue)){
        }else{
        sumOfBudgetAllocatedToSuppliers += inputValue;    
        }
        });
    let suppBudgetRemainingWeekly =  parseFloat(totalAllocatedtoSubCat) - parseFloat(sumOfBudgetAllocatedToSuppliers) 
    $(".suppBudgetRemainingWeekly").html('');
    $(".suppBudgetRemainingWeekly").html('$'+suppBudgetRemainingWeekly)  
      });

     $(document).on('input', '.monthlyBudgetvalSupplier', function() {
     let totalAllocatedtoSubCat = $(".selectedSubCatIdMonthly").val();
        let weeklyBudgetInputs = $('.monthlyBudgetvalSupplier');
        let sumOfBudgetAllocatedToSuppliers = 0;
     console.log("totalAllocatedtoSubCat",totalAllocatedtoSubCat)
        weeklyBudgetInputs.each(function () {
        let inputValue = parseFloat($(this).val());
        if(inputValue === '' || isNaN(inputValue)){
        }else{
        sumOfBudgetAllocatedToSuppliers += inputValue;    
        }
        });
    let suppBudgetRemainingMonthly =  parseFloat(totalAllocatedtoSubCat) - parseFloat(sumOfBudgetAllocatedToSuppliers) 
    $(".suppBudgetRemainingMonthly").html('');
    $(".suppBudgetRemainingMonthly").html('$'+suppBudgetRemainingMonthly) 
     });

        
           function calculateTotalWeekly(obj,mainCatId,totalWeeklybudget){
            //  let totalMonthlyBudget = totalWeeklybudget * 4;
             $(".totalWeeklybudget_"+mainCatId).val(totalWeeklybudget.toFixed(2)); 
            //  $(".totalMonthlybudget_"+mainCatId).val(totalMonthlyBudget.toFixed(2)); 
             
             calculatePercentage(obj,totalWeeklybudget,'weekly');
            
           } 
           
            function calculateTotalMonthly(obj,mainCatId,totalMonthlybudget){
        //   let totalWeeklybudget =   totalMonthlybudget / 4;     
           $(".totalMonthlybudget_"+mainCatId).val(totalMonthlybudget.toFixed(2)); 
        //   $(".totalWeeklybudget_"+mainCatId).val(totalWeeklybudget.toFixed(2));
           
           calculatePercentage(obj,totalMonthlybudget,'monthly');
           }
           
           function calculatePercentage(obj,totalBudget,type=''){
            //   var className = $('#exampleElement').attr('class');
            
             $(obj).parents(".main-category-row").find(".parentRow").each(function(index, element) {
            
             let currentRowWeeklybudget =  $(this).find('.weeklybudget').find('.weekly_budget').val();
             let currentRowMonthlybudget =  $(this).find('.monthlybudget').find('.monthly_budget').val();
             
             if(type=='weekly'){
             let weeklyPercentage = (currentRowWeeklybudget / totalBudget) * 100;
             if(typeof weeklyPercentage != undefined){
             $(this).find(".weeklyPercentage").val(weeklyPercentage.toFixed(2)+'%');
             $(this).find(".weeklyPercentageTd").html(weeklyPercentage.toFixed(2)+'%');
             }
             }else if(type=='monthly'){
             let monthlyPercentage = (currentRowMonthlybudget / totalBudget) * 100;
             if(typeof monthlyPercentage != undefined){
             $(this).find(".monthlyPercentage").val(monthlyPercentage.toFixed(2)+'%');
             $(this).find(".monthlyPercentageTd").html(monthlyPercentage.toFixed(2)+'%');
             }
             }
             
             });  
             
           }
           
          
           
           // Submit save budget for suppliers 
           
           $("#suppWithBudgetDataForm").on("submit", function (e) {
             e.preventDefault(); // Prevent the default form submission
             let formData = $(this).serialize();   
             console.log("vhjbvds",formData);
             $.ajax({
            type: "POST",
            url: "/Supplier/Budget/saveSupplierBudget",
            data: formData,
            success: function (orderId) {
              $('.saveBudgetDataAlert').show();
              $(".saveSuppBudgetDataBtn").html('<i class="ri-save-3-line label-icon align-middle fs-16 me-2"></i> Save')
              setTimeout(function() {
              $('.saveBudgetDataAlert').fadeOut();
              }, 4000);
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
            }
        });   
               
           });      
        });
        
    function fetchSupplierFromSubCatID(obj,subCatId) {
       $(obj).html('Loading...');
      let postData = [{
        "tableName": 'SUPPLIERS_suppliersList',
        "fields": ['supplier_id','supplier_name','weekly_budget','monthly_budget'],
        "conditions": {'category_id': subCatId} // Use curly braces for the conditions
    }];
    
    // Show how budget remaing to allocate now
    let totalAllocatedtoSubCatValue = $('input[name="weekly_'+subCatId+'"]').val();
    let totalAllocatedtoSubCatValueMonthly = $('input[name="monthly_'+subCatId+'"]').val();
    
    $.ajax({
        type: "POST",
        url: "/Common/fetchRecordsDynamicallyAjax",
        data: { 'postData': JSON.stringify(postData) }, // Use JSON.stringify to convert the postData to a JSON string
        success: function (suppData) {
         let suppliersData = JSON.parse(suppData);
         let noOfSupplierForSelectedSubCat = suppliersData.length;
         let weekly_budget = '';
         let monthly_budget = '';
         if(noOfSupplierForSelectedSubCat == 1){
          weekly_budget = $('input[name="weekly_' + subCatId + '"]').val();
          monthly_budget = $('input[name="monthly_' + subCatId + '"]').val();
         }
         
         let htmlForSupp ='<div class="row row-inner mb-3 mt-3 parentDivForSuppList">'; 
          htmlForSupp += '<input type="hidden" class="selectedSubCatId" value="'+totalAllocatedtoSubCatValue+'">';
          htmlForSupp += '<input type="hidden" class="selectedSubCatIdMonthly" value="'+totalAllocatedtoSubCatValueMonthly+'">';
          $(obj).html('Suppliers');
    let allocatedBudgetTosuppSoFarWeekly = 0;
    let allocatedBudgetTosuppSoFarMonthly = 0;
    suppliersData.forEach(function (value, index) {
    allocatedBudgetTosuppSoFarWeekly += parseFloat(value?.weekly_budget);
    allocatedBudgetTosuppSoFarMonthly += parseFloat(value?.monthly_budget);
    htmlForSupp += '<div class="col-lg-4 col-md-4 col-sm-12 mb-4 supplierName">';
    htmlForSupp += '<input type="hidden" name="supplier_id[]" value="' + (value?.supplier_id || '') + '">';
    htmlForSupp += '<input type="hidden" name="subCat_id" value="' + subCatId + '">';
    htmlForSupp += '<span>' + (value?.supplier_name || '') + '</span>';
    htmlForSupp += '</div>';
    htmlForSupp += '<div class="col-lg-4 col-md-4 col-sm-12 SuppWeeklyBudget mb-3">';
    htmlForSupp += '<div class="form-icon">';
    htmlForSupp += '<input type="text" name="weeklySuppBudget[]" class="form-control form-control-icon weeklyBudgetvalSupplier" value="' + (value?.weekly_budget || weekly_budget ) + '">';
    htmlForSupp += ' <i class="bx bx-dollar"></i>';
    htmlForSupp += '</div>';
    htmlForSupp += '</div>';
    htmlForSupp += '<div class="col-lg-4 col-md-4 col-sm-12 SuppMonthlyBudget mb-3">';
    htmlForSupp += '<div class="form-icon">';
    htmlForSupp += '<input type="text" name="monthlySuppBudget[]" class="form-control form-control-icon monthlyBudgetvalSupplier"  value="' + (value?.monthly_budget || monthly_budget) + '">';
    htmlForSupp += ' <i class="bx bx-dollar"></i>';
    htmlForSupp += '</div>';
    htmlForSupp += '</div>';
   
});

          
    htmlForSupp +='</div>';
    $(".suppWithBudgetData").html('');      
    $(".suppWithBudgetData").append(htmlForSupp);
    
    totalAllocatedtoSubCatValue = parseFloat(totalAllocatedtoSubCatValue) - parseFloat(allocatedBudgetTosuppSoFarWeekly);
    totalAllocatedtoSubCatValueMonthly = parseFloat(totalAllocatedtoSubCatValueMonthly) - parseFloat(allocatedBudgetTosuppSoFarMonthly);
    
    $(".suppBudgetRemainingWeekly").html('');
    $(".suppBudgetRemainingWeekly").html('$'+totalAllocatedtoSubCatValue) 
    
    $(".suppBudgetRemainingMonthly").html('');
    $(".suppBudgetRemainingMonthly").html('$'+totalAllocatedtoSubCatValueMonthly) 
   
     $('#offcanvasRight').offcanvas('show');
     
    
        },
        error: function (error) {
            // Handle errors here
        }
    });
}  
    
    function saveSuppBudgetData(obj){
       
      let totalAllocatedtoSubCat = $(".selectedSubCatId").val();  
      let budgetEnteredForAllSupplier = true;
       $('.parentDivForSuppList').each(function () {

        let weeklyBudgetInputs = $(this).find('.weeklyBudgetvalSupplier');
        let sumOfBudgetAllocatedToSuppliers = 0;

        weeklyBudgetInputs.each(function () {
        let inputValue = parseFloat($(this).val());
        console.log("inputValue",inputValue)
        if(inputValue === '' || isNaN(inputValue)){
        budgetEnteredForAllSupplier = false;
        }else{
        sumOfBudgetAllocatedToSuppliers += inputValue;    
        }
        });
        
        // Display or use the sum as needed
        if(budgetEnteredForAllSupplier == false){
         alert("The budget is a mandatory field when there are multiple suppliers. Please add 0 if the supplier has no budget.");  return false; 
        }else if(parseFloat(sumOfBudgetAllocatedToSuppliers) > parseFloat(totalAllocatedtoSubCat)){
          alert("This subcategory budget and the sum of the suppliers total budget must be equal. Please allocate budget accordingly."); return false;  
        }else{
             $(obj).html('<i class="ri-save-3-line label-icon align-middle fs-16 me-2"></i> Saving...');
         $("#suppWithBudgetDataForm").submit();   
        }
       
    }); 
    }
    

</script>
</html>