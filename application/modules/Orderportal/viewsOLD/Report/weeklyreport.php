<div class="main-content">

            <div class="page-content">
                
                <div class="container-fluid">
                  <div class="row">
                   <div class="col-lg-6 align-items-center" style="text-align: left;">
                   <h4 class="flex-grow-1 text-black">Weekly Report</h4>
                    </div>       
                  </div> 
                  <div class="card card-animate">
                      <div class="card-body">
                     <form id="supplierRecordFilterForm" action="/Supplier/filterReportWeekly" method="POST">       
                        <div class="row">
                    <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                      <label class="form-label mb-0 fw-semibold">Delivery Date From</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y" id="from_delivery_date"   name="from_delivery_date"   placeholder="Select date" readonly="readonly">         
                    </div>
                    
                      <div class="col-md-3 col-lg-2 col-sm-6 mt-2 ">
                      <label class="form-label mb-0 fw-semibold">Delivery Date To</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y"  id="to_delivery_date"  name="to_delivery_date"   placeholder="Select date" readonly="readonly">         
                    </div>
                    
                     <div class="col-md-3 col-lg-3 col-sm-6 mt-4">
        <div class="dropdown">
         <button class="form-select" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Sub Category </button>
          <ul class="dropdown-menu dropdown-menusubcat w-100" aria-labelledby="dropdownMenuButton1">
          </ul>
          <strong class="selectedSubMenuCat"></strong>
        </div>
       <input type="hidden" id="selectedSubCategories" name="selectedSubCategories">
    </div>
    
    
        <div class="col-md-3 col-lg-3 col-sm-6 mt-4 d-none">
        <div class="dropdown">
         <button class="form-select" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">Main Category </button>
          <ul class="dropdown-menu  dropdown-menucat w-100" aria-labelledby="dropdownMenuButton2">
          </ul>
          <strong class="selectedMenuCat"></strong>
        </div>
       <input type="hidden" id="selectedMainCategories" name="selectedMainCategories">
    </div>
                     <div class="col-md-2 col-lg-2 col-sm-3 mt-4">
                     <button type="button" class="btn btn-success" onclick="submitFilterForm()">
                     <i class=" ri-filter-2-line align-bottom me-1"></i> Filter
                      </button>
                       </div>
                      </div><!--end row-->
                       </form>
                                
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0 text-black">Reports</h5>
                                </div>
                                <div class="card-body">
                                    <table id="reports-datatables" class="display table table-bordered" style="width:100%">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th>Delivery Date</th>
                                                <th>Main Category</th>
                                                <th>Sub  Category</th>
                                                <th>Weekly Budget</th>
                                                <th>Weekly Spent</th>
                                                <th>Weekly Remaining</th>
                                                <th>%</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totalWeeklyBudget = 0; $totalWeeklySpent = 0; $totalWeeklyRemaining = 0; $totalWeeklyPercentage = 0;?>
                                            <?php if(isset($filteredReportResult) && !empty($filteredReportResult)){ ?>
                                            <?php  foreach($filteredReportResult as $filteredReportWeekWise) { ?>
                                            <?php if(isset($filteredReportWeekWise) && !empty($filteredReportWeekWise)){ ?>
                                             <?php  foreach($filteredReportWeekWise as $filteredReport) { ?>
                                             <?php $totalWeeklyBudget = $totalWeeklyBudget +  (float)(isset($filteredReport['weeklyBudget']) ? $filteredReport['weeklyBudget'] : 0); ?>
                                             <?php $totalWeeklySpent = $totalWeeklySpent +  (float)(isset($filteredReport['weeklySpent']) ? $filteredReport['weeklySpent'] : 0); ?>
                                             <?php $totalWeeklyRemaining = $totalWeeklyRemaining +  (float)(isset($filteredReport['weeklyRemaining']) ? $filteredReport['weeklyRemaining'] : 0); ?>
                                             <?php $totalWeeklyPercentage = $totalWeeklyPercentage +  (float)(isset($filteredReport['weeklyPercentage']) ? $filteredReport['weeklyPercentage'] : 0); ?>
                                              <tr class="<?php echo ($filteredReport['isBudgetExceeded'] == 'yes' ? 'bg-danger-subtle' : '') ?>">
                                                <td><?php echo date('d-m-Y',strtotime($filteredReport['delivery_date'])) ?></td>
                                                <td><?php echo $filteredReport['mainCategoryName'] ?></td>
                                                <td><?php echo $filteredReport['subCategoryName'] ?></td>
                                                <td><?php echo '$'.number_format((isset($filteredReport['weeklyBudget']) ? $filteredReport['weeklyBudget'] : 0.00), 2, '.', ','); ?></td>
                                                <td><?php echo '$'.number_format((isset($filteredReport['weeklySpent']) ? $filteredReport['weeklySpent'] : 0), 2, '.', ','); ?></td>
                                                <td><?php echo '$'.number_format((isset($filteredReport['weeklyRemaining']) ? $filteredReport['weeklyRemaining'] : 0), 2, '.', ','); ?></td>
                                                <td><?php echo (isset($filteredReport['weeklyPercentage']) ? $filteredReport['weeklyPercentage'] : '').'%' ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php } ?>
                                            <?php } ?>
                                            <?php } ?>
                                            <tr class="bg-light fw-bold"> 
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td><?php echo '$'.number_format($totalWeeklyBudget, 2, '.', ','); ?></td>
                                            <td><?php echo '$'.number_format($totalWeeklySpent, 2, '.', ','); ?></td>
                                            <td><?php echo '$'.number_format($totalWeeklyRemaining, 2, '.', ','); ?></td>
                                            <td><?php echo  $totalWeeklyPercentage.'%'; ?></td>
                                            
                                            </tr>
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
                                </div>
                               
 <script>
 
$(document).ready(function(){
  new DataTable("#reports-datatables", {
    dom: "Bfrtip",
    buttons: [
      { extend: "excel", className: "btn btn-success", text: "<i class='fas fa-file-excel'></i> Excel" },
      { extend: "print", className: "btn btn-yellow" , text: "<i class='fas fa-print'></i> Print" }
    ]
  });
  
  let from_delivery_date = localStorage.getItem('Weekly_from_delivery_date'); 
  if(typeof from_delivery_date != undefined || from_delivery_date != undefined){
    $("#from_delivery_date").val(from_delivery_date)  
  }
  let to_delivery_date = localStorage.getItem('Weekly_to_delivery_date');
  
  if(typeof to_delivery_date != undefined || to_delivery_date != undefined){
    $("#to_delivery_date").val(to_delivery_date)  
  }
    

  const options = JSON.parse('<?php echo json_encode($supplier_Subcategories); ?>');

  const dropdownMenu = $(".dropdown-menusubcat");
  const selectedSubCategoriesInput = $("#selectedSubCategories");
  
  $.each(options, function(index, option) {
    const checkbox = $("<input class='form-check-input'>").attr("type", "checkbox").attr("id", `option-${option.id}`).val(option.id+'-'+option.category_name); // Use option.id for ID and option.name for value
    const label = $("<label class='form-check-label mx-2'>").attr("for", checkbox.attr("id")).text(option.category_name);
    const li = $("<li class='px-3'>").append(checkbox).append(label);
    dropdownMenu.append(li);
  });
   
  dropdownMenu.on("click", "input[type='checkbox']", function() { 
      $(".selectedSubMenuCat").html('');
     const selectedValues = dropdownMenu.find("input:checked").map(function() {
      let selectVal = $(this).val();
      let parts = selectVal.split("-");
      let subCatId = parts[0];
      let subCatName = parts[1]+','; 
      $(".selectedSubMenuCat").append(subCatName)
      return subCatId;
    }).get().join(",");
    
    selectedSubCategoriesInput.val(selectedValues);
  });
  
  
   const maincategories = JSON.parse('<?php echo json_encode($supplier_Maincategories); ?>');
   const selectedMainCategories = $("#selectedMainCategories");
   const dropdownMenucat = $(".dropdown-menucat");
   
   $.each(maincategories, function(index, optionCat) {
    const checkbox = $("<input class='form-check-input'>").attr("type", "checkbox").attr("id", `option-${optionCat.id}`).val(optionCat.id+'-'+optionCat.category_name); // Use option.id for ID and option.name for value
    const label = $("<label class='form-check-label mx-2'>").attr("for", checkbox.attr("id")).text(optionCat.category_name);
    const li = $("<li class='px-3'>").append(checkbox).append(label);
    console.log("optionCat",optionCat)
    dropdownMenucat.append(li);
  });
   
  dropdownMenucat.on("click", "input[type='checkbox']", function() { 
      $(".selectedMenuCat").html('');
    const selectedValues = dropdownMenucat.find("input:checked").map(function() {
        
      let selectVal = $(this).val();
      let parts = selectVal.split("-");
      let catId = parts[0];
      let catName = parts[1]+','; 
      $(".selectedMenuCat").append(catName)
      
      return catId;
    }).get().join(",");
    selectedMainCategories.val(selectedValues);
  });


     
 })
 
 function submitFilterForm(){
     localStorage.setItem('Weekly_from_delivery_date', $("#from_delivery_date").val());
     localStorage.setItem('Weekly_to_delivery_date', $("#to_delivery_date").val());
     $("#supplierRecordFilterForm").submit();
 }


</script>                                
                             
                                
                                