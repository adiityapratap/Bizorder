<div class="main-content">

            <div class="page-content">
                
                <div class="container-fluid">
                  
                  <div class="card card-animate">
                      <div class="card-body">
                     <form id="supplierRecordFilterForm" action="/Supplier/filterRecords" method="POST">       
                        <div class="row">
                                
                    <div class="col-md-3 col-lg-2 col-sm-6 mt-2">
                      <label class="form-label mb-0 fw-semibold">Delivery Date From</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y"   name="from_delivery_date"   placeholder="Select date" readonly="readonly">         
                    </div>
                    
                      <div class="col-md-3 col-lg-2 col-sm-6 mt-2 ">
                      <label class="form-label mb-0 fw-semibold">Delivery Date To</label>
                      <input type="text" required class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="d-m-Y"   name="to_delivery_date"   placeholder="Select date" readonly="readonly">         
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
    
    
                     <div class="col-md-3 col-lg-3 col-sm-6 mt-4">
        <div class="dropdown">
         <button class="form-select" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">Category </button>
          <ul class="dropdown-menu  dropdown-menucat w-100" aria-labelledby="dropdownMenuButton2">
          </ul>
          <strong class="selectedMenuCat"></strong>
        </div>
       <input type="hidden" id="selectedMainCategories" name="selectedMainCategories">
    </div>
                     <div class="col-md-2 col-lg-2 col-sm-3 mt-4">
                     <button type="submit" class="btn btn-success">
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
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th>Sub  category</th>
                                                <th>Main category</th>
                                                <th>Supplier name</th>
                                                <th>Delivery date</th>
                                                <th>Weekly budget</th>
                                                <th>Weekly spent</th>
                                                <th>Weekly remaining</th>
                                                <th>%</th>
                                                <th>Monthly budget </th>
                                                <th>Monthly spent</th>
                                                <th>Monthly remaining</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <tr>
                                                <td>Aditya</td>
                                                <td>Developer</td>
                                                <td>Developer</td>
                                                <td>Developer</td>
                                                <td>Developer</td>
                                                <td>Developer</td>
                                                <td>Sydney</td>
                                                <td>Sydney</td>
                                                <td>Sydney</td>
                                                <td>23</td>
                                                <td>2030/09/20</td>
                                                <td>$85,600</td>
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
 new DataTable("#buttons-datatables", {
        dom: "Bfrtip",
        buttons: [ "excel", "print"],
         // This disables the search bar
        // buttons: ["copy", "csv", "excel", "print", "pdf"]
    }); 
    

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


</script>                                
                             
                                
                                