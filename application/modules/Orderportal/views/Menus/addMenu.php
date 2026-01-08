<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
input[type=checkbox], input[type=radio] {
    margin: 9px 10px 9px 0;
}
</style>
<div class="main-content">

    <div class="page-content">
                
    <div class="container-fluid">
     <div class="row">
        <div class="col-lg-12">
            <div class="page-content-inner">
                <div class="card" id="userList">
                    <form action="<?php echo base_url('Orderportal/Configfoodmenu/submitMenu') ?>" id="menu_add" method="post" class="form-horizontal" >
                    <div class="card-header border-bottom-dashed">

                        <div class="row g-4 align-items-center">
                            <div class="col-sm ">
                                <div>
                                    <h5 class="card-title mb-0 text-black">
                                      Add/Update New Menu
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div>
                    <a class="btn btn-danger add-btn" href="<?php echo base_url('Orderportal/Configfoodmenu/menus') ?>"><i class="mdi mdi-reply align-bottom me-1"></i> Back</a>
                                    
                   <?php if(isset($menuDetails['id'])){  ?>
                    <input type="hidden" class="form-control" name="menuId" value="<?php echo $menuDetails['id']; ?>" >
                    <input type="submit" class="btn btn-success" value="Update Menu">
                    <?php }else{ ?>
                    <input type="submit" class="btn btn-success" value="Save Menu">
                     <?php } ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                  
                    <div class="card-body">
                        
                        <div class="accordion" id="default-accordion-example">
                                            <div class="accordion-item shadow">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                       Menu Details
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse  show" aria-labelledby="headingOne" data-bs-parent="#default-accordion-example">
                                                    <div class="accordion-body">
                                                      <div class="row">
                                                          
                     <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label class="text-black">Menu Name :<span>*</span></label>
                        <input type="text" class="form-control" required name="name"  autocomplete="off" value="<?php echo ($menuDetails['name'] !='' ? $menuDetails['name'] : '') ?>" >
                    </div>
                     
                     <div class="col-12 col-md-3 col-lg-2 mb-2"> 
                         <label class="text-black">Category :</label>
                            <select class="form-select" name="category"  >
							     <option value="">-- Select Menu Category --</option>
							     
							    <?php foreach($categories as $category){   	  
							    if($category['id'] == $menuDetails['category']){ ?>
							        <option value="<?php echo $category['id']; ?>" selected><?php echo $category['name']; ?></option>
							    <?php }else{ ?>
							        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
							    <?php } } ?>
							</select>
                    </div>
                    
                    <div class="col-12 col-md-3 col-lg-2 mb-2">
                         <label class="text-black"> Cuisine :</label>
                            <select class="form-select" name="cuisine" >
							     <option value="">-- Select Menu Cuisine --</option>
							    <?php foreach($cuisines as $cuisine){  
							    if($cuisine['id'] == $menuDetails['cuisine']){ ?>
							        <option value="<?php echo $cuisine['id']; ?>" selected><?php echo $cuisine['name']; ?></option>
							    <?php }else{ ?>
							        <option value="<?php echo $cuisine['id']; ?>"><?php echo $cuisine['name']; ?></option>
							    <?php } } ?>
							</select>
                    </div>
                    
                     
                    <div class="col-12  col-md-3 mb-2">
                         <label class="text-black"> Item Type :</label>
                            <select class="form-select" name="menuType" >
							     <option value="">-- Select Item Type --</option>
							    <?php foreach($menutypes as $menutype){  
							    if($menutype['id'] == $menuDetails['menuType']){ ?>
							        <option value="<?php echo $menutype['id']; ?>" selected><?php echo $menutype['name']; ?></option>
							    <?php }else{ ?>
							        <option value="<?php echo $menutype['id']; ?>"><?php echo $menutype['name']; ?></option>
							    <?php } } ?>
							</select>
                    </div> 
                    
                    
                  <div class="col-12 col-md-3 col-lg-2 mb-2">
                        <label class="text-black">Menu Description :<span>*</span></label>
                        <textarea  class="form-control" required name="description"  autocomplete="off" ><?php echo ($menuDetails['description'] !='' ? $menuDetails['description'] : '') ?></textarea>
                    </div>   
                    
                      </div> 
                                                     <div class="row" id="menuOptionsContainer">
                                                         <?php if(isset($menuOptionsDetails) && !empty($menuOptionsDetails)) {  ?>
                                                         <?php foreach($menuOptionsDetails as $menuOptionsDetail)  { ?>
                                                     <div class="col-12 col-md-3 col-lg-2 mb-2 d-flex align-items-end menu-option-row">
        <div class="w-100">
            <label class="text-black">Menu options</label>
            <input type="text" class="form-control" required name="menu_options[]" autocomplete="off" value="<?php echo  $menuOptionsDetail['menu_option_name'] ?>">
        </div>
      
         <button type="button" class="btn btn-danger ms-2 remove-menu-option">-</button>
    </div>    
                                                         
                                                         <?php } ?>
                                                         <?php } ?>
    <div class="col-12 col-md-3 col-lg-2 mb-2 d-flex align-items-end menu-option-row">
        <div class="w-100">
            <label class="text-black">Menu options</label>
            <input type="text" class="form-control"  name="menu_options[]" autocomplete="off">
        </div>
        <button type="button" class="btn btn-success ms-2 add-menu-option">+</button>
    </div>
</div>


                    
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="accordion-item shadow">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Other details
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse " aria-labelledby="headingThree" data-bs-parent="#default-accordion-example">
                                                    <div class="accordion-body">
                                                        
                                                       <div class="row recipeInputBox mt-4">
    <div class="col-12">
        <div class="field-row no-border">
            <h4 class="text-black">Nutrition per serving</h4>
        </div>
    </div>
    <?php if (isset($nutritions) && !empty($nutritions)) { ?>
        <?php foreach ($nutritions as $nutrition) { $nId  = $nutrition['id']; ?>
            <div class="col-12 col-md-3 mb-3">
                <div class="field-row d-flex align-items-center">
                    <label class="me-2 w-25"><?php echo $nutrition['name']; ?></label>
                    <input 
                        type="text" 
                        class="form-control w-75" 
                        name="nutritionPerServing[<?php echo $nutrition['id']; ?>]" 
                        placeholder="Enter value"
                        value="<?php echo (isset($nutritionPerServing->$nId) ? $nutritionPerServing->$nId : '' ) ?>"
                        >
                        
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>


     <div class="row recipeInputBox mt-4">
    <div class="col-12">
        <div class="field-row no-border">
            <h4 class="text-black">Nutrition per 100 gram</h4>
        </div>
    </div>
    <?php if (isset($nutritions) && !empty($nutritions)) { ?>
        <?php foreach ($nutritions as $nutrition) { $nId  = $nutrition['id']; ?>
            <div class="col-12 col-md-3 mb-3">
                <div class="field-row d-flex align-items-center">
                    <label class="me-2 w-25"><?php echo $nutrition['name']; ?></label>
                    <input 
                        type="text" 
                        class="form-control w-75" 
                        name="nutritionPerGram[<?php echo $nutrition['id']; ?>]" 
                        placeholder="Enter value"
                        value="<?php echo (isset($nutritionPerGram->$nId) ? $nutritionPerGram->$nId : '' ) ?>"
                        >
                        
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

     <div class="row recipeInputBox mt-4">
    <div class="col-12">
        <div class="field-row no-border">
            <h4 class="text-black">Prices </h4>
        </div>
    </div>
    <?php if (isset($sizes) && !empty($sizes)) { ?>
        <?php foreach ($sizes as $size) { $nId  = $size['id']; ?>
            <div class="col-12 col-md-3 mb-3">
                <div class="field-row d-flex align-items-center">
                    <label class="me-2 w-25"><?php echo $size['name']; ?></label>
                    <input 
                        type="text" 
                        class="form-control w-75" 
                        name="prices[<?php echo $size['id']; ?>]" 
                        placeholder="Enter value"
                        value="<?php echo (isset($prices->$nId) ? $prices->$nId : '' ) ?>"
                        >
                        
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

     <div class="row recipeInputBox mt-4">
    <div class="col-12">
        <div class="field-row no-border">
            <h4 class="text-black">Classification </h4>
        </div>
    </div>
    <?php if (isset($sizes) && !empty($sizes)) { ?>
        <?php foreach ($sizes as $size) { $nId  = $size['id']; ?>
            <div class="col-12 col-md-3 mb-3">
                <div class="field-row d-flex align-items-center">
                    <label class="me-2 w-25"><?php echo $size['name']; ?></label>
                    <div class="form-check form-radio-danger mb-3">
    <input id="red_<?php echo $size['id']; ?>" class="form-check-input" type="radio" name="classification[<?php echo $size['id']; ?>]" value="red" <?php echo (isset($classificationValues->$nId) && $classificationValues->$nId == 'red') ? 'checked' : ''; ?>>
                    <label class="form-check-label me-2 mt-2" for="red_<?php echo $size['id']; ?>"> Red</label>
                    </div>
                    
                    <div class="form-check form-radio-warning mb-3">
                    <input id="amber_<?php echo $size['id']; ?>" class="form-check-input" type="radio" name="classification[<?php echo $size['id']; ?>]" value="amber" <?php echo (isset($classificationValues->$nId) && $classificationValues->$nId == 'amber') ? 'checked' : ''; ?>>
                    <label class="form-check-label me-2 mt-2" for="amber_<?php echo $size['id']; ?>"> Amber</label>
                    </div>
                    
                     <div class="form-check form-radio-success mb-3">
                    <input id="green_<?php echo $size['id']; ?>" class="form-check-input" type="radio" name="classification[<?php echo $size['id']; ?>]" value="green" <?php echo (isset($classificationValues->$nId) && $classificationValues->$nId == 'green') ? 'checked' : ''; ?>>
                    <label class="form-check-label me-2 mt-2" for="green_<?php echo $size['id']; ?>"> Green</label>
                    </div>
                   
                    
                    
                        
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

     <div class="row recipeCheckbox mt-4"> 
                      <div class="col-12 col-md-12 ">
                      <div class="field-row no-border"> <label> Allergens</label></div>
                     </div>
                     <?php if(isset($allergens) && !empty($allergens)) { ?>
                     <?php foreach($allergens as $allergen){ $allergenId = $allergen['id'];  ?> 
                     <div class="col-12 col-md-2 ">
                     <div class="field-row">
                 <input id="<?php echo $allergen['id']; ?>" value="<?php echo $allergen['id']; ?>" type="checkbox" name="allergens[]" <?php echo (isset($allergenValues) && in_array($allergenId,$allergenValues) ? 'checked' : '') ?>>
                     <label for="<?php echo $allergen['id']; ?>"> <?php echo $allergen['name']; ?></label>
                     </div>
                     </div>
                      <?php } } ?>
                      </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
    
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <!--end col-->
     </div>
        <!--end row-->
       
        
        
    </div>
            <!-- container-fluid -->
    </div>
        <!-- End Page-content -->

        
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->



<script type="text/javascript">
	$(document).ready(function() { 
	    $("#menu_add").validate({
	      	ignore: "input[type='text']:hidden",
		    rules: {
			
	        menu: {
	        	required:true
            
            },
	       // regular: {
	       //         required:true
	       //     },
	       // large: {
	       //         required:true
	       //     }   
			},		
			messages: {
			    
	        menu: {
	        
                 required:"Please Provide the menu name"
                 },
	       // regular: {
	       //        required:"Please Provide the regular value"
	       //     },
	       // large: {
	       //       required:"Please Provide the large value"
	       //     }   
			}

	    });	
	});
	
	
	function fetchMenuCategory(obj){
        var category_id = $(obj).val();
        var menuOptions='';
        if(category_id == ''){
                var selectmenuwrap=$("#subCategorywrap"); 
                selectmenuwrap.css('display','none');
        }
        else{
            $.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
		    url: "<?php echo base_url(); ?>index.php/menuplanner/fetchMenuCategory",
		    data: {"category_id":category_id},
		    success: function(data){
                 // console.log(data);
                 if(data != 'No record'){
                     var data1=JSON.parse(data)
                     menuOptions+='<option value="">Select Category</option>';
                 $.each(data1, function(i, value) {
                     menuOptions+='<option value="'+value.subcategory_id+'">'+value.subcategory_name+'</option>';
                     
                     
                });
                
                 }
                 else{
                     menuOptions+='<option value="">No Category</option>';
                 }
                 // console.log(menuOptions);
                var selectmenuwrap=$("#subCategorywrap");
                var selectmenu=$("#subCategory");
                selectmenu.html(menuOptions);
                selectmenuwrap.css('display','block');
		    }
		});
        }
    }
    
    
    
</script>

<script>
$(document).ready(function() {
    // Add new row
    $('#menuOptionsContainer').on('click', '.add-menu-option', function() {
        const newRow = `
        <div class="col-12 col-md-3 col-lg-2 mb-2 d-flex align-items-end menu-option-row">
            <div class="w-100">
                <label class="text-black">Menu options</label>
                <input type="text" class="form-control"  name="menu_options[]" autocomplete="off">
            </div>
            <button type="button" class="btn btn-danger ms-2 remove-menu-option">−</button>
        </div>
        `;
        $('#menuOptionsContainer').append(newRow);
    });

    // Remove row
    $('#menuOptionsContainer').on('click', '.remove-menu-option', function() {
        $(this).closest('.menu-option-row').remove();
    });
});
</script>
