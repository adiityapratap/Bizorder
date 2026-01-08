<div class="main-content">
     <style>
    .dropdown-menu {
      max-height: 300px;
      overflow-y: auto;
    }
    .dropdown-menu label {
      width: 100%;
      padding: 0.25rem 1.5rem;
      cursor: pointer;
    }
  </style>
<div class="page-content">
                <div class="container-fluid">
                <div class="row">
                 <small class="text-danger fw-semibold"><i>* Once the menu is published, no further changes can be made. Please delete and add another one if any edits needs to be made to the menu.</i></small>           
           <!--form start-->
           
           
           
            <div id="menu-planner-container" class="max-w-6xl mx-auto px-4 py-6">
        <form id="menuPlannerForm" action="https://bizorder.com.au/Orderportal/Menuplanner/saveDailyMenuPlanner" method="post">
       
        <input type="hidden" id="menuPlannerId" value="<?php echo (isset($menuPlannerId) ? $menuPlannerId : ''); ?>">
        <input type="hidden" id="isWeeklyMenuPlanner" value="<?php echo (isset($isWeeklyMenuPlanner) ? $isWeeklyMenuPlanner : false); ?>">
        
       <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
  <h2 class="text-xl font-bold text-gray-800 mr-4">Daily Menu Plan</h2>

  <div class="flex items-center gap-4">
    <!-- Date Picker -->
    <div class="relative">
      <input type="text" name="date" id="menuPlannerDate" class="bg-white border border-gray-300 rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-chef-purple focus:border-transparent flatpickr-input" placeholder="Select date" readonly>
      <i class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512">
          <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/>
        </svg>
      </i>
    </div>

    <!-- Floor Selector -->
    <select id="floor-selector" name="department_id" class="bg-white border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-chef-purple focus:border-transparent">
      <option value="0" <?= ($selectedDepartments === '0' || $selectedDepartments == '') ? 'selected' : ''; ?>>All Floors</option>
      <?php foreach ($departmentListData as $department) { ?>
        <option value="<?= $department['id']; ?>" <?= ($selectedDepartments === $department['id']) ? 'selected' : ''; ?>>
          <?= $department['name']; ?>
        </option>
      <?php } ?>
    </select>

    <!-- Back Button -->
    <a href="<?= base_url('Orderportal/Menuplanner/list'); ?>" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-md transition-colors">
        <i class="mr-2" data-fa-i2svg=""><svg class="svg-inline--fa fa-arrow-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"></path></svg></i>
        Back</a>
   

    <!-- Save / Update / Published -->
    <?php if(isset($isPublished) && !$isPublished) { ?>
      <?php if(isset($menuPlannerId) && $menuPlannerId !='') { ?>
        <button class="w-full sm:w-auto bg-chef-green hover:bg-green-600 text-white px-6 py-2.5 rounded-md transition-colors" onclick="save(this,'Save')"><i class="fa-solid fa-save mr-2"></i> Update</button>
      <?php } else { ?>
        <button class="w-full sm:w-auto bg-chef-green hover:bg-green-600 text-white px-6 py-2.5 rounded-md transition-colors" onclick="save(this,'Save')"> <i class="fa-solid fa-save mr-2"></i> Save</button>
      <?php } ?>
    <?php } else { ?>
      <button class="w-full sm:w-auto bg-chef-green hover:bg-green-600 text-white px-6 py-2.5 rounded-md transition-colors" disabled>Published</button>
    <?php } ?>

    <!-- Publish Button -->
    <?php if(isset($isPublished) && !$isPublished) { ?>
      <button class="w-full sm:w-auto bg-chef-purple hover:bg-purple-700 text-white px-6 py-2.5 rounded-md transition-colors" onclick="save(this,'Publish')">  <i class="fa-solid fa-paper-plane mr-2"></i> Publish</button>
    <?php } ?>
  </div>
</div>

         
    <!--// Men sections-->
   
        <input type="hidden" name="saveTypeBtn" id="saveTypeBtn">
    <?php if(isset($menuLists) && !empty($menuLists)) { ?>
      <div id="menu-sections" class="space-y-8">
           <?php foreach ($menuLists as $categoryName => $menus) { ?>
           <div id="<?php echo $categoryName; ?>-section" class="bg-white rounded-lg shadow-sm overflow-hidden mb-5">
                <div class="bg-blue-500 text-white px-6 py-3 flex justify-between items-center">
                    <h3 class="font-semibold text-lg text-white"><?php echo $categoryName; ?></h3>
                </div>
                <div class="p-6">
                    <?php if(isset($menus) && !empty($menus)) {  ?>
                    <?php foreach ($menus as $menu) { $menuId = $menu['menu_id']; ?>
                    <?php if(isset($menu['menu_options']) && !empty($menu['menu_options'])) { ?>
                    <div class="mb-6">
                        <h4 class="text-gray-800 font-semibold mb-3"><?php echo $menu['menu_name']; ?></h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <?php foreach ($menu['menu_options'] as $menu_options) { ?>
                          <div class="bg-gray-50 hover:bg-gray-100 transition-colors rounded-md p-3 flex items-center">
                                <input type="checkbox" id="<?php echo $menu_options['option_id'] ?>" name="optionMenus[<?php echo $menuId ?>][]" value="<?php echo $menu_options['option_id'] ?>" class="menu-option-checkbox h-5 w-5 text-chef-purple rounded border-gray-300 focus:ring-chef-purple mr-3">
                                <label for="<?php echo $menu_options['option_id'] ?>" class="text-gray-700 cursor-pointer"><?php echo $menu_options['menu_option_name'] ?></label>
                            </div>
                        <?php }  ?>
                        </div>
                    </div>
                   <?php }else {   ?>
                   <div class="mb-6">
                   <h4 class="text-gray-800 font-semibold mb-3"><?php echo $menu['menu_name']; ?></h4>
                   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div class="bg-gray-50 hover:bg-gray-100 transition-colors rounded-md p-3 flex items-center">
                      <input type="checkbox" id="<?php echo $menu['menu_id'] ?>" name="noOptionMenus[]" value="<?php echo $menu['menu_id'] ?>" class="h-5 w-5 text-chef-purple rounded border-gray-300 focus:ring-chef-purple mr-3">
                      <label for="<?php echo $menu['menu_id'] ?>" class="text-gray-700 cursor-pointer"><?php echo $menu['menu_name'] ?></label>
                      </div>
                    </div>
                    </div>
                    <?php }  ?>
                    <?php }  ?>
                  
                </div>
            </div>
          <?php }  ?>
           <?php }  ?>
              </div>
            <?php }  ?>
    


</form>
         </div>
         <!--form end-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
          
        </div>
        
                            
                                            
      
          <script>
         document.addEventListener('DOMContentLoaded', function () {
    // Initialize date pickers
    flatpickr("#menuPlannerDate", {
        dateFormat: "Y-m-d",
        allowInput: true,
        altInput: true,
        altFormat: "d M, Y"
    });
        });
         
    
  function save(obj,saveType = 'Save') {
      $(obj).html('Saving...');
      let selectedDepartments = [];
      let dept = $("#department_id").val();
      let menuPlannerDate = $("#menuPlannerDate").val();
      let isWeeklyMenuPlanner = $("#isWeeklyMenuPlanner").val();
        selectedDepartments.push(dept);
        $("#saveTypeBtn").val(saveType);
      $("#menuPlannerForm").submit();
      return false;

    let menuIds = []; // Collect all menu IDs without options in a single array
    document.querySelectorAll('input[name="noOptionMenus[]"]:checked').forEach(el => {
        menuIds.push(el.value);
    });
    
    let menuOptionIds = []; // Collect all menu IDs without options in a single array
   document.querySelectorAll('.menu-option-checkbox:checked').forEach(optionEl => {
    menuOptionIds.push(optionEl.value);
});

    let saveOrPublish = saveType === 'Publish' ? 2 : 1;
    console.log("menuId",menuIds);
    console.log("menuOptionIds",menuOptionIds);
    return false;
    $.ajax({
        url: '<?= base_url("Orderportal/Menuplanner/saveDailyMenuPlanner") ?>',
        type: 'POST',
        data: {
            departments: selectedDepartments,
            menuPlannerId: $("#menuPlannerId").val(),
            menuData: menuIds, // Send menu IDs without/o directly
            menuOptionIds: menuOptionIds, // Send menu IDs with/option directly
            saveTypeBtn: saveOrPublish,
            date: menuPlannerDate,
            isWeeklyMenuPlanner: isWeeklyMenuPlanner
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // $("#menuPlannerId").val(response?.menuPlannerId),
                // $(obj).html(saveType);
                alert('Menu saved successfully!');
                 window.location.href='<?= base_url("Orderportal/Menuplanner/list") ?>'
            } else {
                $(obj).html(saveType);
                alert(response.message);
            }
        },
        error: function() {
            alert('An error occurred while saving the menu.');
        }
    });
}



document.addEventListener('DOMContentLoaded', function () {
    const menuPlannerDatePicker = flatpickr('#menuPlannerDate', {
        dateFormat: "d M Y"
    });
    document.getElementById('calendarIcon').addEventListener('click', function () {
        menuPlannerDatePicker.open();
    });
});



          </script>
         