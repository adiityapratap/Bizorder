// add remove clone new row on button click
$(document).ready(function() {
  
  $(document).on('click', '.btn-clone', function() {
    var $inputRow = $(this).closest('.input-row');
    var $clonedRow = $inputRow.clone(true); 
    $clonedRow.find('input').val(''); 
    $inputRow.after($clonedRow); 
  });

  $(document).on('click', '.btn-declone', function() {
    var $inputRow = $(this).closest('.input-row');
    if ($('.input-row').length > 1) {
      $inputRow.remove();
    }
  });
  
   $('.systemsChange').change(function() {
        let system_id = $(this).val();
        let user_id = $(".user_id").val() !='' ? $(".user_id").val() : '';  
        let role_id = $(".role_id").val() !='' ? $(".role_id").val() : ''; 

            $.ajax({
                type: 'POST',
                url: '/General/fetchMenuFromHelperForSettingPage',
                data: {
                    system_id: system_id,
                    user_id: user_id,
                    role_id: role_id,
                },
                success: function(response) {
                  let jsonData = JSON.parse(response);
                  console.log(jsonData) ;

        let menuList ='<small> Click on specific menu to view its submenus</small>'; 
        let count = 0;
          jsonData.forEach(function(menu) {
             
       let menuSelected = menu.selected == 1 || (menu.sub_menu && menu.sub_menu.length > 0) ? 'checked="checked"' : '';
        // by default open those tabs wch has submenus , keep rest ones closed
        let classShow = menu.sub_menu && menu.sub_menu.length > 0 ? 'show' : '';
        let classCollapse = menu.sub_menu && menu.sub_menu.length > 0 ? '' : 'collapsed';
        let classParentMenu = menu.sub_menu && menu.sub_menu.length > 0 ? 'parentMenu' : '';
        let disabledParentMenu = menu.sub_menu && menu.sub_menu.length > 0 ? '' : '';
       
        
         menuList +='<div class="accordion custom-accordionwithicon accordion-info mb-1" id="accordionWithicon">';
          menuList +='  <div class="accordion-item ">';
          menuList +='   <h2 class="accordion-header" id="accordionwithiconExample1">';
            menuList +='    <button class="accordion-button '+classCollapse+'" type="button" data-bs-toggle="collapse" data-bs-target="#menuCollapseBtn'+count+'" aria-expanded="true" aria-controls="accor_iconExamplecollapse1">';
             menuList +='   <i class="ri-menu-fill px-2"></i> ' + menu.menu_name + '</button>';
            menuList +='  </h2>';
            menuList +='    <div id="menuCollapseBtn'+count+'" class="accordion-collapse  '+classShow+'" aria-labelledby="accordionwithiconExample1" data-bs-parent="#accordionWithicon">';
            menuList +='       <div class="accordion-body">';
            
            menuList +='<div class="form-check form-check-primary mb-3">';
            menuList +='<input class="form-check-input '+classParentMenu+'" '+disabledParentMenu+' value="' + menu.menu_id + '" name="menuIds[]" type="checkbox" id="' + menu.menu_id + '" '+menuSelected+'>';
            menuList +='<label class="form-check-label" for="' + menu.menu_id + '"><b>' + menu.menu_name + '</b></label></div>';
            if (menu.sub_menu && menu.sub_menu.length > 0) {
               menu.sub_menu.forEach(function(subMenu) {
            let subMenuSelected = subMenu.selected == 1 ? 'checked="checked"' : '';
            menuList +='<div class="form-check form-check-secondary mb-3 px-5">';
            menuList +='<input class="form-check-input" value="' + subMenu.id + '" name="subMenuIds[]" type="checkbox" id="' + subMenu.id + '" '+subMenuSelected+'>';
            menuList +='<label class="form-check-label" for="' + subMenu.id + '">' + subMenu.sub_menu_name + '</label></div>';
           });
           }

           menuList +='</div>';
           menuList +='</div>';
           menuList +=' </div>';
           menuList +=' </div>';

    count++;
    
});

          $('.menuAccess').html('');
           $('.menuAccess').append(menuList);
         

                },
                error: function(xhr, status, error) {
                    console.error('Error fetching menu:', error);
                }
            });
       
    });
    
});
$(document).ready(function() {
    $('.checklisttoggle-demo').on('change', function() {
        var checkbox = $(this);
        var isChecked = checkbox.prop('checked');
        var id = checkbox.data('id');
         let tablename = checkbox.data('tablename');
       
        // Send AJAX request to updateStatus method
        $.ajax({
            url: '/General/updateTableStatus',
            type: 'POST',
            data: {
                id: id,
                status: isChecked ? 1 : 0,
                table_name : tablename
            },
            success: function(response) {
                // Handle success response if needed
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error if needed
                console.error(error);
            }
        });
    });
    
    
  
    $("#saveMenuForThisUser").click(function() {
        // Serialize the form data
        $(".parentMenu").removeAttr('disabled');
        var formData = $("#menuSubMenuForm").serialize();
        $(this).html('<i class="ri-save-3-line label-icon align-middle fs-16 me-2"></i>Saving...');
        $.ajax({
            type: "POST",
            url: "/Auth/SaveMenu", 
            data: formData,
            success: function(response) {
            $("#saveMenuForThisUser").html('<i class="ri-save-3-line label-icon align-middle fs-14 me-2"></i>  Menu Saved Succesfully');
            setTimeout(function() {
                $("#saveMenuForThisUser").html('');
            $("#saveMenuForThisUser").html('<i class="ri-save-3-line label-icon align-middle fs-16 me-2"></i> Save Menu');
            $(".parentMenu").attr('disabled', 'disabled');
            
              }, 2000); 
                                         
            },
            error: function(error) {
                // Handle errors if necessary
            }
        });
    });
    
   console.log("From Custom.js");

});

 function getCurrentTime() {
    let currentDate = new Date();
    let hours = currentDate.getHours();
    let minutes = currentDate.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // Handle midnight (12:00 AM)
    let formattedTime = hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
    return formattedTime;
}


window.addEventListener("load", () => {
    let searchInput = document.getElementsByClassName("searchListKeyword")[0];
   
    if(searchInput !=undefined){
    searchInput.addEventListener("keyup", () => {
        let search = searchInput.value.toLowerCase();

        // Find the closest parent with the class '.tab-pane'
        let tabPane = searchInput.closest('.tab-pane');

        // Find all list items within the closest '.tab-pane'
        let itemList = tabPane.querySelectorAll(".listOfItems li");

        console.log("search", search);

        for (let i of itemList) {
            let item = i.querySelector(".itemName").innerHTML.toLowerCase();
            if (item.indexOf(search) == -1) {
                i.classList.add("d-none");
            } else {
                i.classList.remove("d-none");
            }
        }
    });
    }
    
     let searchInputAll = document.getElementsByClassName("searchListKeywordAll")[0];
     if(searchInputAll !=undefined){
      searchInputAll.addEventListener("keyup", () => {
        let search = searchInputAll.value.toLowerCase();

        // Find the closest parent with the class '.tab-pane'
        let tabPane = searchInputAll.closest('.tab-pane');

        // Find all list items within the closest '.tab-pane'
        let itemList = tabPane.querySelectorAll(".listOfItems li");

        console.log("search", search);

        for (let i of itemList) {
            let item = i.querySelector(".itemName").innerHTML.toLowerCase();
            if (item.indexOf(search) == -1) {
                i.classList.add("d-none");
            } else {
                i.classList.remove("d-none");
            }
        }
    });
     }
    
     let searchInputInternalLoc = document.getElementsByClassName("searchListKeywordAllInternalSubLoc")[0];
      if(searchInputInternalLoc !=undefined){
    searchInputInternalLoc.addEventListener("keyup", () => {
        let search = searchInputInternalLoc.value.toLowerCase();

        // Find the closest parent with the class '.tab-pane'
        let tabPane = searchInputInternalLoc.closest('.table-responsive');

        // Find all list items within the closest '.tab-pane'
        let itemList = tabPane.querySelectorAll(".listOfItems li");

        console.log("search", search);

        for (let i of itemList) {
            let item = i.querySelector(".itemName").innerHTML.toLowerCase();
            if (item.indexOf(search) == -1) {
                i.classList.add("d-none");
            } else {
                i.classList.remove("d-none");
            }
        }
    });
      }
});


