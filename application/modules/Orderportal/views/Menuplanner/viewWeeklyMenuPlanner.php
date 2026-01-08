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
            <form action="<?php echo base_url('Orderportal/Menuplanner/saveWeeklyMenu'); ?>" method="POST">  
            <input type="hidden" name="weeklyMenuPlannerId" value="<?php echo $weeklyMenuPlannerId; ?>">
            <div class="card">
    <div class="card-header align-items-center d-flex flex-wrap gap-3">
    <!-- Title with Date -->
    <h4 class="card-title mb-0 flex-grow-1 text-faded">Weekly Menu Planner <?php echo $date; ?></h4>

    <!-- Date Inputs -->
    <div class="d-flex flex-column flex-md-row gap-3 col-md-6 col-12">
        <div class="custom_date_schedule mt-2">
            <label class="form-label mb-0 fw-semibold">Start Date</label>
            <input type="text" 
                   required 
                   value="<?php echo isset($start_date) ? date('d-m-Y', strtotime($start_date)) : ''; ?>" 
                   class="form-control flatpickr-input active" 
                   data-provider="flatpickr" 
                   data-date-format="d-m-Y" 
                   data-minDate="today"
                   name="start_date" 
                   placeholder="Select date" 
                   readonly>
        </div>

        <div class="custom_date_schedule mt-2">
            <label class="form-label mb-0 fw-semibold">End Date</label>
            <input type="text" 
                   required 
                 value="<?php echo isset($end_date) ? date('d-m-Y', strtotime($end_date)) : ''; ?>" 
                   class="form-control flatpickr-input active" 
                   data-provider="flatpickr" 
                   data-date-format="d-m-Y" 
                   data-minDate="today"
                   name="end_date" 
                   placeholder="Select date" 
                   readonly>
        </div>
    </div>

    <!-- Department Dropdown -->
    <div class="flex-shrink-0 me-2">
           <select class="form-select" name="department_id" id="department_id">
                <option> All Departments </option>
            <option  value="0" <?php echo ($selectedDepartments === '0' || $selectedDepartments == '') ? 'selected' : ''; ?> > All</option>    
              <?php foreach ($departmentListData as $department) { ?>   
             <option  value="<?php echo $department['id']; ?>" <?php echo ($selectedDepartments === $department['id']) ? 'selected' : ''; ?> > <?php echo $department['name']; ?></option>
             <?php } ?>
            </select>
        </div>

    <!-- Save Button -->
    <div class="flex-shrink-0 me-2">
        <a href="<?php echo base_url('Orderportal/Menuplanner/list'); ?>" class="btn btn-md btn-orange">Back</a>
          <button type="submit" class="btn btn-md btn-success">Save</button>
    </div>

    
</div>


    <div class="card-body">
        
          <?php   $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; ?>
           <div class="table-responsive table-card">
            <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
                <thead class="table-dark">
            <tr class="text-muted">
                
           <?php  foreach ($daysOfWeek as $day) { ?>
             <th scope="col"><?php echo $day; ?></th>
             <?php }    ?>
             
        </tr>
       </thead>
        <tbody class="day_<?php echo $day; ?>">
            <tr class="text-muted">
       <?php  foreach ($savedData as $savedWeekData) { 
       $targetDate = new DateTime($savedWeekData['date']);
       $day  = $targetDate->format('l');  
       $savedMenus  = unserialize($savedWeekData['menuData']);
       ?>
       <td>
        <div class="table-responsive table-card">
            <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
               
               <?php foreach ($menuLists as $categoryName => $menus) { ?>
    <tbody class="menu_<?php echo $categoryName; ?> tbodySite">
        <tr>
            <th colspan="3" class="text-black w-100" style="background-color: #dff0fa;">
                <b><?php echo $categoryName; ?></b>
            </th>
        </tr>
        <?php foreach ($menus as $menu) { 
       
            $isChecked = in_array($menu['menu_id'], $savedMenus); // Check if saved
        ?>
            <tr>
                <td>
                    <div class="form-check form-check-success fs-15">
                        <input class="form-check-input" type="checkbox"
                               id="menu_<?php echo $day; ?>_<?php echo $menu['menu_id']; ?>"
                               value="<?php echo $menu['menu_id']; ?>"
                               name="menuName[<?php echo $day; ?>][]"
                               <?php echo $isChecked ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="menu_<?php echo $day; ?>_<?php echo $menu['menu_id']; ?>">
                            <?php echo $menu['menu_name']; ?>
                        </label>
                    </div>
                </td>
                <td></td>
                <td></td>
            </tr>
        <?php } ?>
    </tbody>
<?php } ?>

            </table>
        </div>
        </td>
        <?php }    ?>
        </tr>
         </tbody>
        
        </table>
        </div>
        
    
    </div>
</div>
             </form> 
                         
                </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
          
        </div>
        
                            
                                            
      
          <script>
          
         
    





          </script>
         