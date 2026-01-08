<style>
@media print {
    /* Ensure all tabs are displayed */
    .tab-content > .tab-pane {
        display: block !important; /* Show all tab panes */
        visibility: visible !important;
        height: auto !important;
        opacity: 1 !important;
    }

    /* Hide tab headers if they are not needed in print */
    .nav-tabs,
    .nav-pills {
        display: none !important;
    }

    /* Hide buttons and other non-essential elements */
    button,.printhide,
    .btn {
        display: none !important;
    }

    /* Style the inputs and layout for printing */
    input,
    select,
    textarea {
        border: none;
        background: transparent;
        color: black;
        font-size: 14px;
    }

    /* Adjust page margins */
    body {
        margin: 0;
        padding: 0;
    }

    /* Remove any additional margins/padding from forms or containers */
    form {
        margin: 0;
        padding: 0;
    }
}

</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
               <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                 <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0 text-black printhide">Create Recipe</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                                <button onclick="history.back()" class="btn btn-danger btn-sm"><i class="ri-arrow-go-back-line me-2"></i> Back</button>
                                 <button class="btn btn-success btn-sm" id="printButton"> <i class="ri-printer-line me-2"></i> Print Recipe</button>
                                 </div>
                            </div>
                        </div>
                    </div>
                                <div class="card-body checkout-tab">

                                
                                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3 active" id="recipe-info-tab" data-bs-toggle="pill" data-bs-target="#recipe-info" type="button" role="tab" aria-controls="recipe-info" aria-selected="true">
                                                        <i class="bx bx-bowl-hot fs-16 p-2 bg-soft-primary text-white rounded-circle align-middle me-2"></i> Recipe Details</button>
                                                   </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3" id="pills-ingredient-tab" data-bs-toggle="pill" data-bs-target="#pills-ingredient" type="button" role="tab" aria-controls="pills-ingredient"
                                                     aria-selected="false"><i class="bx bx-food-tag fs-16 p-2 bg-soft-primary text-white rounded-circle align-middle me-2"></i> Ingredient Details</button>
                                                        
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link fs-15 p-3" id="preparation-step-tab" data-bs-toggle="pill" data-bs-target="#preparation-step" type="button" role="tab" aria-controls="preparation-step"
                                                        aria-selected="false"><i class="bx bx-food-menu fs-16 p-2 bg-soft-primary text-white rounded-circle align-middle me-2"></i> Preparation Steps</button>
                                                </li>
                                                
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="recipe-info" role="tabpanel"
                                                aria-labelledby="recipe-info-tab">
                                                <div>
                                                    <h5 class="mb-1 text-black">Recipe Details</h5>
                                                    <p class="text-black mb-4 printhide">Please fill all information below</p>
                                                </div>

                  <form id="recipeForm">
                 <input type="hidden" class="recipeId" name="recipeId" value="<?php echo isset($recipeInfo['id']) ? $recipeInfo['id'] : ''; ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="recipeName" class="form-label">Recipe Name</label>
                            <input type="text" class="form-control" name="recipeName" id="recipeName" placeholder="Enter recipe name" 
                                   value="<?php echo isset($recipeInfo['recipeName']) ? htmlspecialchars($recipeInfo['recipeName'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="servingSize" class="form-label">Serving Size</label>
                            <input type="text" class="form-control" name="servingSize" id="servingSize" placeholder="Enter serving size" 
                                   value="<?php echo isset($recipeInfo['servingSize']) ? htmlspecialchars($recipeInfo['servingSize'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="preparationTime" class="form-label">Preparation Time</label>
                            <input type="text" class="form-control" id="preparationTime" name="preparationTime" placeholder="Enter preparation time" 
                                   value="<?php echo isset($recipeInfo['preparationTime']) ? htmlspecialchars($recipeInfo['preparationTime'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="cookingTime" class="form-label">Cooking Time</label>
                            <input type="text" class="form-control" name="cookingTime" id="cookingTime" placeholder="Enter cooking time" 
                                   value="<?php echo isset($recipeInfo['cookingTime']) ? htmlspecialchars($recipeInfo['cookingTime'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="totalTime" class="form-label">Total Time</label>
                            <input type="text" class="form-control" id="totalTime" name="totalTime" placeholder="Enter total time" 
                                   value="<?php echo isset($recipeInfo['totalTime']) ? htmlspecialchars($recipeInfo['totalTime'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <input type="text" class="form-control" name="difficulty" id="difficulty" placeholder="Enter difficulty" 
                                   value="<?php echo isset($recipeInfo['difficulty']) ? htmlspecialchars($recipeInfo['difficulty'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mt-3">
                    <?php if(isset($recipeInfo['id'])) { ?>
                    <button type="button" class="btn btn-danger btn-label right ms-auto nexttab saveRecipeForm" data-nexttab="pills-ingredient-tab"><i class="bx bx-food-tag label-icon align-middle fs-16 ms-2"></i>
                        Update</button>
                    <?php } ?>
                    <button type="button" class="btn btn-success nexttab saveRecipeForm" data-nexttab="pills-ingredient-tab">Proceed to add ingredients <i class="bx bx-food-tag align-middle ms-2"></i></button>
                </div>
            </form>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-ingredient" role="tabpanel" aria-labelledby="pills-ingredient-tab">
                                             <div class="d-flex mb-3">
                                                    <h5 class="mb-1 text-black">Ingredient Details</h5>
<a href="<?= base_url("Orderportal/Recipe/Config") ?>" class="btn btn-danger btn-sm btn-label right ms-auto float-end printhide"><i class="bx bx-plus label-icon align-middle fs-16 ms-2"></i>Add New Ingredient</a>
                                                </div>
                                                <form id="ingredientForm">
                                                    <input type="hidden" class="recipeId" name="recipeId" value="<?php echo isset($recipeInfo['id']) ? $recipeInfo['id'] : ''; ?>">
                                                <div id="ingredient-form">
                                                 <?php if(isset($recipeInfo['ingredients']) && !empty($recipeInfo['ingredients'])) {   ?>   
                                                 <?php foreach($recipeInfo['ingredients'] as $recipeIngredients) {  ?>
                                                <div class="row mb-3 align-items-center ingredientRow">
            
                                     <div class="col-md-3">
                 <label for="ingredientName" class="form-label">Ingredient Name </label>
                <select class="form-select ingredientName" name="ingredientName[]">
                    <option  disabled>Choose Ingredient Name </option>
                    <?php if(isset($ingredients) && !empty($ingredients)) {  ?>
                    <?php foreach($ingredients as $ingredient) {  ?>
                    <option <?php echo ($recipeIngredients['ingredientId'] == $ingredient['id'] ? 'selected' : '')  ?> value="<?php echo $ingredient['id'] ?>"><?php echo $ingredient['name'] ?></option>
                    <?php } ?>
                     <?php } ?>
                    
                </select>
            </div>
                                       <div class="col-md-2">
                 <label for="ingredientUom" class="form-label" >Recipe UOM </label>
                <select class="form-select ingredientUom" name="ingredientUom[]">
                   <option value="<?php echo $recipeIngredients['uom'] ?>"><?php echo $recipeIngredients['UOMName'] ?> </option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="ingredientQty" class="form-label" >Recipe UOM QTY </label>
                <input type="text" class="form-control ingredientQty" name="ingredientQty[]" placeholder="Enter Qty Eg. 1000,5000 etc" value="<?php echo $recipeIngredients['qty'] ?>">
            </div>
            <div class="col-md-3">
                <label for="totalIngredientCost" class="form-label" >Cost </label>
             <div class="input-group ">
              <span class="input-group-text">$</span>
              <?php $totalCost =  $recipeIngredients['qty']/( $recipeIngredients['ingredientUOMqty']* $recipeIngredients['cost']) ;?>
               <input type="text" class="form-control totalIngredientCost" name="ingredientCost[]" readonly  aria-label="Cost" value="<?php echo $recipeIngredients['cost'] ?>">
               <input type="hidden" class="form-control ingredientCostValue" value="<?php echo $recipeIngredients['ingredientCost'] ?>">
               <input type="hidden" class="form-control ingredientUOMqtyValue" value="<?php echo $recipeIngredients['ingredientUOMqty'] ?>">
              </div>   
            </div>
            <div class="col-md-1 text-center mt-3 buttonParent">
                <button type="button" class="btn btn-success btn-sm add-row"><i class="bx bx-plus"></i></button>
                 <button type="button" class="btn btn-danger btn-sm remove-row"><i class="bx bx-minus"></i></button>
                
            
            </div>
        </div>
                                                  <?php }  ?>
                                                   <?php }else {  ?>
                                                 <div class="row mb-3 align-items-center ingredientRow">
            
                                     <div class="col-md-3">
                 <label for="ingredientName" class="form-label">Ingredient Name </label>
                <select class="form-select ingredientName" name="ingredientName[]">
                    <option selected disabled>Choose Ingredient Name </option>
                    <?php if(isset($ingredients) && !empty($ingredients)) {  ?>
                    <?php foreach($ingredients as $ingredient) {  ?>
                    <option value="<?php echo $ingredient['id'] ?>"><?php echo $ingredient['name'] ?></option>
                    <?php } ?>
                     <?php } ?>
                    
                </select>
            </div>
                                       <div class="col-md-2">
                 <label for="ingredientUom" class="form-label" >Ingredient UOM </label>
                <select class="form-select ingredientUom" name="ingredientUom[]">
                   
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="ingredientQty" class="form-label" >Ingredient Qty </label>
                <input type="text" class="form-control ingredientQty" name="ingredientQty[]" placeholder="Enter Qty Eg. 1000,5000 etc">
            </div>
            <div class="col-md-3">
                <label for="totalIngredientCost" class="form-label" >Cost </label>
             <div class="input-group ">
              <span class="input-group-text">$</span>
               <input type="text" class="form-control totalIngredientCost" name="ingredientCost[]" readonly  aria-label="Cost">
               <input type="hidden" class="form-control ingredientCostValue" >
               <input type="hidden" class="form-control ingredientUOMqtyValue">
              </div>   
            </div>
            <div class="col-md-1 text-center mt-3 buttonParent">
                <button type="button" class="btn btn-success btn-sm add-row"><i class="bx bx-plus"></i></button>
            </div>
        </div>  
                                                    <?php }  ?>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                <!-- <button type="button" class="btn btn-light btn-label previestab" id="recipe-info-tab" data-bs-target="#recipe-info" data-previous="recipe-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Recipe Details</button> -->
                 <?php if(isset($recipeInfo['id'])) { ?>
                   <button type="button" class="btn btn-danger btn-label right ms-auto nexttab saveIngredientForm" data-nexttab="preparation-step-tab"><i  class="bx bx-food-menu label-icon align-middle fs-16 ms-2"></i>Update</button>
                    <?php } ?> 
                <button type="button" class="btn btn-success nexttab saveIngredientForm" data-nexttab="preparation-step-tab">Proceed to add preparation steps <i class="bx bx-food-menu align-middle ms-2"></i></button>
                                              </div>
                                              </form>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="preparation-step" role="tabpanel" aria-labelledby="preparation-step-tab">
                                                
                                                <div>
                                                    <h5 class="mb-1 text-black">Preparation Steps</h5>
                                                    <p class="text-black mb-4 printhide">Please write all the steps to prepare this recipe</p>
                                                        
                                                </div>
                                               <form id="prepForm">
                                                   <input type="hidden" class="recipeId" name="recipeId" value="<?php echo isset($recipeInfo['id']) ? $recipeInfo['id'] : ''; ?>">
                                                <div class="mb-3">
                                                        <label for="preparationSteps" class="form-label printhide">Preparation Steps </label>
                                                        <textarea class="form-control" id="preparationSteps" name="preparationSteps"  placeholder="Enter steps" rows="4"><?php echo isset($recipeInfo['prepSteps']) ? htmlspecialchars($recipeInfo['prepSteps'], ENT_QUOTES) : ''; ?></textarea>
                                                    </div>

                                                <div class="d-flex align-items-start gap-3 mt-4">
        <!-- <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-ingredient-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Ingredients</button> -->
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab savePrepForm" data-nexttab="pills-finish-tab"><i class=" bx bx-list-check label-icon align-middle fs-16 ms-2"></i>Finish</button>
                                                           
                                                </div>
                                                </form>
                                            </div>
                                            <!-- end tab pane -->

                                         
                                        </div>
                                        <!-- end tab content -->
                                   
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                       
                        </div>
                        <!-- end col -->
                    </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.saveRecipeForm').click(function () {
        let formData = $('#recipeForm').serialize();
        $.ajax({
            url: '<?= base_url("Orderportal/Recipe/saveRecipeDetails") ?>', 
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $(".recipeId").val(response);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while saving the recipe.');
            }
        });
    });
    
     $('.saveIngredientForm').click(function () {
        let formData = $('#ingredientForm').serialize();
        $.ajax({
            url: '<?= base_url("Orderportal/Recipe/saveIngredientDetails") ?>', 
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response) {
                 
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while saving the recipe.');
            }
        });
    });
    
    $('.savePrepForm').click(function () {
        $(this).html("Saving....");
        let formData = $('#prepForm').serialize();
        $.ajax({
            url: '<?= base_url("Orderportal/Recipe/savePrepSteps") ?>', 
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                 window.location.href = '<?= base_url("Orderportal/Recipe/buildRecipe") ?>';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while saving the recipe.');
            }
        });
    });
    
    
    
});


$(document).on('click', '.add-row', function () {
    // Clone the last row
    let newRow = $('.row.mb-3.align-items-center:last').clone();

    // Reset input values in the cloned row
    newRow.find('select').val('');
    newRow.find('input').val('');
    newRow.find('.totalIngredientCost').val('');
    newRow.find('.ingredientUom').empty(); 
    let removeButton = `<button type="button" class="btn btn-danger btn-sm remove-row"><i class="bx bx-minus"></i></button>`;
    let buttonParent = newRow.find('.buttonParent');
    if (!buttonParent.find('.remove-row').length) {
    buttonParent.append(removeButton);
    }

    // Append the cloned row after the last row
    $('.row.mb-3.align-items-center:last').after(newRow);
});

// Handle ingredient selection change
$(document).on('change', '.ingredientName', function () {
    fetchIngredientDetails(this);
});

// Handle quantity input changes to calculate cost
$(document).on('input', '.ingredientQty', function () {
    let currentRow = $(this).closest('.row');
    let qty = parseFloat($(this).val()) || 0;
    let costPerUnit = parseFloat(currentRow.find('.ingredientCost').val()) || 0;

    // Calculate total cost
    let totalCost = qty * costPerUnit;
    currentRow.find('.totalIngredientCost').val(totalCost.toFixed(2));
});

// Function to fetch ingredient details
function fetchIngredientDetails(obj) {
    const ingredientId = $(obj).closest(".row").find('.ingredientName').val(); // Get selected ingredient ID
    // console.log("select ingredient", ingredientId);
    if (ingredientId) {
        $.ajax({
            url: '<?= base_url("Orderportal/Recipe/fetchIngredientDetails") ?>',
            type: 'POST',
            data: { id: ingredientId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Populate the UOM dropdown
                    const uomDropdown = $(obj).closest(".row").find('.ingredientUom');
                    uomDropdown.empty();
                 let uomName = '';
                    response.data.uom_id.forEach(function (uomId, index) {
                         uomName = response.data.uom_name[index];
                        uomDropdown.append(`<option selected value="${uomId}">${uomName}</option>`);
                    });

                    // Set cost in the row
                    $(obj).closest(".row").find('.ingredientUOMqtyValue').val(response.data.uomqty);
                    $(obj).closest(".row").find('.ingredientCostValue').val(response.data.cost);
                    
                     $(obj).closest(".row .ingredientRow").find('.ingqtycost').html('');
                    $(obj).closest(".row .ingredientRow").append('<b class="ingqtycost"><small class="mb-0 text-bold mt-3 mx-3"> '+response.data.uomqty + ' '+ uomName +'  = $' + response.data.cost+'</small></b>');
                } else {
                    alert(response.message || 'No details found.');
                }
            },
            error: function () {
                alert('An error occurred while fetching ingredient details.');
            }
        });
    }
}






$(document).ready(function () {
    
    
    
   

    // Remove a row when the "-" button is clicked
    $(document).on('click', '.remove-row', function () {
        // Only remove if there is more than one row
        if ($('#ingredient-form .row').length > 1) {
            $(this).closest('.row').remove();
        } else {
            alert('At least one row is required.');
        }
    });
});

document.getElementById('printButton').addEventListener('click', function () {
    window.print();
});

$(document).ready(function () {
    $(document).on('input', '.ingredientQty', function () {
        let $row = $(this).closest('.ingredientRow');
        let ingredientQty = parseFloat($(this).val()) || 0;
        let ingredientUOMqtyValue = parseFloat($row.find('.ingredientUOMqtyValue').val()) || 1;
        let ingredientCostValue = parseFloat($row.find('.ingredientCostValue').val()) || 0; 
        
        let result = (ingredientQty / ingredientUOMqtyValue) * ingredientCostValue;
        
        $row.find('.totalIngredientCost').val(result.toFixed(2));
    });
});



</script>
