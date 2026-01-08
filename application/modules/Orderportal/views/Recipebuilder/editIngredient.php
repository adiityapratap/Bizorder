<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
               <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                  <div class="card-header">
                                      
                                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 text-black">Update Ingredient </h4>
    
                                    <div class="page-title-right">
                                        <div class="d-flex justify-content-sm-end ">
                                         
                                            <div class="d-flex justify-content-sm-end gap-2">
                                               
                                                <a href="#" onclick="history.back()" class="btn btn-danger btn-sm" > <i class="ri-arrow-go-back-line fs-12 align-bottom me-1"></i>Back</a> 
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
    
                                      </div>
                                      </div>
                                <div class="card-body checkout-tab">

                                
                                
                                <form class="tablelist-form" method="post" action="<?php echo base_url('Orderportal/Recipe/updateIngredient') ?>">
    <div class="modal-body">
        <input type="hidden" id="id-field"  name="id" value="<?php echo isset($ingredientData[0]['id']) ? $ingredientData[0]['id'] : ''; ?>">
        <div class="row g-3">
            <div class="col-lg-12">
                <label for="name-field" class="form-label modalLabel">Ingredient Name</label>
                <input type="text" name="name" id="ingredient_name" class="form-control" 
                    value="<?php echo isset($ingredientData[0]['name']) ? $ingredientData[0]['name'] : ''; ?>" required>
                <div class="invalid-feedback configNameError" style="display:none">Please enter ingredient name </div>
            </div>
        </div>
        
        <div class="row g-3 mt-2">
            <div class="col-lg-12">
                <label for="categoryId" class="form-label">Category</label>
                <select class="form-select" id="categoryId" name="category_id">
                    <option value="">Select Category</option>
                    <?php if (isset($catListData) && !empty($catListData)) {  
                        foreach ($catListData as $catList) { 
                            $selected = isset($ingredientData[0]['category_id']) && $ingredientData[0]['category_id'] == $catList['id'] ? 'selected' : '';
                            ?>
                            <option value="<?php echo $catList['id']; ?>" <?php echo $selected; ?>>
                                <?php echo $catList['name']; ?>
                            </option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        
        <div class="row g-3 mt-2">
            <div class="col-lg-12">
                <label for="uomId" class="form-label">UOM</label>
                <select class="form-select" id="uomId" name="uom">
                    <option value="">Select UOM</option>
                    <?php if (isset($uomListData) && !empty($uomListData)) {  
                        foreach ($uomListData as $uomList) { 
                            $selected = isset($ingredientData[0]['uom']) && $ingredientData[0]['uom'] == $uomList['id'] ? 'selected' : '';
                            ?>
                            <option value="<?php echo $uomList['id']; ?>" <?php echo $selected; ?>>
                                <?php echo $uomList['name']; ?>
                            </option>
                    <?php } } ?>
                </select>
            </div>
        </div>
        
          <div class="row g-3 mt-2">
            <div class="col-lg-12">
                <label for="uomqty" class="form-label modalLabel">UOM Qty</label>
                <input type="text" readonly name="uomqty" id="uomqty" class="form-control" 
                    value="<?php echo isset($ingredientData[0]['uomqty']) ? $ingredientData[0]['uomqty'] : ''; ?>">
             
            </div>
        </div>
        
        <div class="row g-3 mt-2">
            <div class="col-lg-12">
                <label for="ingredient_cost" class="form-label modalLabel">Ingredient Cost</label>
                <input type="text" name="cost" id="ingredient_cost" class="form-control" 
                    value="<?php echo isset($ingredientData[0]['cost']) ? $ingredientData[0]['cost'] : ''; ?>" required>
                <div class="invalid-feedback configNameError" style="display:none">Please enter ingredient cost </div>
            </div>
        </div>
    </div>
    <div class="modal-footer mt-3" >
        <div class="hstack gap-2 justify-content-end">
            <input type="hidden" name="listtype" id="menuListType">
            <!--<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>-->
            <button type="submit" class="btn btn-green submitButtoncategory" >Update</button>
        </div>
    </div>
</form>

                                       
                                   
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
document.querySelector('.tablelist-form').addEventListener('submit', function (e) {
    let isValid = true;

    // Get form fields
    const ingredientName = document.getElementById('ingredient_name');
    const categoryId = document.getElementById('categoryId');
    const uomId = document.getElementById('uomId');
    const ingredientCost = document.getElementById('ingredient_cost');

    // Clear any previous error messages
    document.querySelectorAll('.invalid-feedback').forEach(function (el) {
        el.style.display = 'none';
    });

    // Validate Ingredient Name
    if (ingredientName.value.trim() === '') {
        isValid = false;
        ingredientName.nextElementSibling.style.display = 'block';
    }

    // Validate Category
    if (categoryId.value.trim() === '') {
        isValid = false;
        alert('Please select a category.');
    }

    // Validate UOM
    if (uomId.value.trim() === '') {
        isValid = false;
        alert('Please select a UOM.');
    }
   

    // Validate Ingredient Cost
    if (ingredientCost.value.trim() === '' || isNaN(ingredientCost.value)) {
        isValid = false;
        ingredientCost.nextElementSibling.style.display = 'block';
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
