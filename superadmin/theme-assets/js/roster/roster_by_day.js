
function fetchRole(obj){
 
    // $('#emp_slt').removeClass('border-danger');
    // $('.emperror').remove();
    var emp_id = $(obj).val();
    var rowIdEmp = $('#rowIdEmp').val();
      
    var employeeIdSelected = $('#'+rowIdEmp).find("#employeeIdSelected");
    var empRoleId = $('#'+rowIdEmp).find(".empRoleId");
    var empRoleName = $('#'+rowIdEmp).find(".empRoleName");
    var empName = $('#'+rowIdEmp).find(".empName");
	 	 
        employeeIdSelected.val(emp_id);
    //   console.log($(obj).html());
     
          $.ajax({
            url:"/HR/index.php/admin/fetch_emp_role", 
    		method:"POST", 
    		data:{emp_id:emp_id},
    	    success:function(resp){
    	       var prePopulat = JSON.parse(resp);
    	       
            	 empRoleId.val('');
            	 empRoleName.val('');
            	 empName.val('');
            	 
            	 empRoleId.val(prePopulat[0]['role']);
            	 empRoleName.html(prePopulat[0]['role_name']); 
            	 empName.html(prePopulat[0]['first_name']+' '+prePopulat[0]['last_name']);
                 $("#empRoleNameModal").val(prePopulat[0]['role_name']);
                 $("#emp_availability_details").css('display','none');
                 $("#append_employee_availability").html('');
                 
                 if(typeof prePopulat[0]['rate'] != "undefined" && prePopulat[0]['rate'] !== null){
        	           if(prePopulat[0]['rate'] != '' && prePopulat[0]['rate'] != null){ var rate = '$'+prePopulat[0]['rate']; }else{ var rate = ''; }
            	       if(prePopulat[0]['Saturday_rate'] != '' && prePopulat[0]['Saturday_rate'] != null){ var Saturday_rate = '$'+prePopulat[0]['Saturday_rate']; }else{ var Saturday_rate = ''; }
            	       if(prePopulat[0]['Sunday_rate'] != '' && prePopulat[0]['Sunday_rate'] != null){ var Sunday_rate = '$'+prePopulat[0]['Sunday_rate']; }else{ var Sunday_rate = ''; }
            	       if(prePopulat[0]['holiday_rate'] != '' && prePopulat[0]['holiday_rate'] != null){ var holiday_rate = '$'+prePopulat[0]['holiday_rate']; }else{ var holiday_rate = ''; }
            	       
            	       var tablehtml = '<table><tr><td>Weekdays Rate:</td><td>'+rate+'</td></tr><tr><td>Saturday Rate:</td><td>'+Saturday_rate+'</td></tr><tr><td>Sunday Rate:</td><td>'+Sunday_rate+'</td></tr><tr><td>Holiday Rate:</td><td>'+holiday_rate+'</td></tr></table>';
        	         
                        $("#payRatesetails").html(tablehtml);
                        $("#empPopupCol").addClass('col-lg-8');
                        $("#empPopupCol").removeClass('col-lg-12');
                        $("#empRatesCol").css('display','block');
                 }
                 else{
                    $("#empPopupCol").removeClass('col-lg-8');
                    $("#empPopupCol").addClass('col-lg-12');
                    $("#empRatesCol").css('display','none');
                 }
    
    			}
    	});  

      
}
//  For getting employee availability in add , edit and recreate roster

function GetEmpAvailData(obj){
    // 	var form = $("#hack_submit");
	   // var formdata =  form.serialize();
	   var start_date = $('#start_date').val();
	   var rowIdEmp = $('#rowIdEmp').val();
        var emp_id = $('#'+rowIdEmp).find("#employeeIdSelected").val();
	   // var emp_id = $(obj).closest('.hrsTag').find('#employeeIdSelected').val();
	    console.log('emp_id='+emp_id);
        // var emp_id = $(obj).prev("#employeeIdSelected").val();
        if(emp_id !=''){
             $.ajax({
        url:"/HR/index.php/employees/fetch_employee_availability_for_next_week",
		method:"POST",
// 		 data:formdata + '&employee_id=' + emp_id,
		 data:'start_date='+start_date + '&employee_id=' + emp_id,
	    success:function(resp){
	          
	        try { 
	       //  var dayName = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
	            var data = '<span role="button" class="emp_avai_btn text-primary fw-medium collapsed" data-bs-toggle="collapse" data-bs-target="#collapseinline" aria-expanded="false" aria-controls="collapseinline"><span id="availability_collapse_text_show">Show</span><span id="availability_collapse_text_hide">Hide</span> the availability of selected employee for next week.</span><div class="collapse" id="collapseinline"><div class="mb-0 mt-3" id="append_employee_availability"> <table class="table"> <tbody>';
	         
	            var employee_availability = JSON.parse(resp);
	            var unavailabletype = '';
	            $.each(employee_availability, function(i, value) {
	               unavailabletype=value.type;
	              if(unavailabletype =='all_day'){
                    data += '<tr><td>'+value.start_date+'</td> <td>Full Day </td></tr>';
	              }else{
                    data += '<tr><td>'+value.start_date+'</td> <td> '+value.start_time+'-'+value.end_time+'</td></tr>';
	              }
	                  
	              });
          
	          
	          data +=' </tbody></table></div></div>';
	           $("#emp_availability_details").html(data);
	           $("#emp_availability_details").css('display','block');
	          
	        }catch(e){
	       (resp =='error' ? alert('Please select the start date') : '' )
	        
	        }
	        }
	   
		
	});
        }else{
            alert('Please select the employee to view the availability');
        }
     
   
 
  }
  
  
  $(function() {
    $('.toggle-demo').on('change',function() {
         var id = $(this).attr('id')
     if($(this).prop('checked')){
         var status = 1;
     }else{
         var status = 0;
     }
     
      $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
        url: "<?php echo base_url(); ?>index.php/admin/update_roster_status",
        data: {"roster_status":status,"id":id},
        success: function(data){
                 console.log(data);
                //  location.reload();
        }
    });
    
    
    })
  });
  
  
  $(document).ready(function(){
	// Activate tooltip
// 	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody .custom-checkbox input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});

function addRoster(){
        $("#addRoster").addClass('show');
        $("#addRoster").css('display','block');
    }
    
    $('#addRosterClose').click(function(){
        $('#addRoster').find('.addHrs').css('display','flex');
        $('#addRoster').find('.approvedHrs').css('display','none');
    });
    
    function addRosterTime(that){
        var empID = $( that ).closest( '.employeeRole' ).find('#employeeIdSelected').val();
        if(empID == ''){
            Swal.fire({
              title: "Please select employee first.",
              icon: "warning",
              showCancelButton: !0,
              confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
              cancelButtonClass: "btn btn-danger w-xs mt-2",
              confirmButtonText: "Okay",
              buttonsStyling: !1,
              showCloseButton: !0,
          });
        }else{
            console.log('empID'+empID);
            var rowId= $(that).attr('data-rel-id');
            var rowrel= $(that).attr('rel');
            $("#addRosterTime").find('input').val('');
            $("#outletName").val('');
            $("#addRosterTime").addClass('show');
            $("#addRosterTime").css('display','block');
            $("#rowId").val(rowId);
            $("#addRosterTimeLabel").html('Add '+rowrel+' Hours');
            $("#addRosterTimeBtn").html('Add');
        }
    } 
    function editRosterTime(that){
        var rowId= $(that).attr('data-rel-id');
        var rowrel= $(that).attr('rel');
        $("#addRosterTime").addClass('show');
        $("#addRosterTime").css('display','block'); 
        $("#rowId").val(rowId);
        $("#addRosterTimeLabel").html('Update '+rowrel+' Hours');
        var startTime = $('#'+rowId).find('.startTimeInputValue').val();
        var finishTime = $('#'+rowId).find('.finishTimeInputValue').val();
        var breakDuration = $('#'+rowId).find('.breakTimeInputValue').val();
        var outletName = $('#'+rowId).find('.outletNameID').val();
        var break_start = $('#'+rowId).find('.'+rowrel+'_break_start').val();
        var break_finish = $('#'+rowId).find('.'+rowrel+'_break_finish').val();
        // var i = 0;
        // var breaktimehtml = '';
        // var diff = 0;
        // $(break_start).each(function(){
        //     var startTm = $(this).val();
        //     var endTm = $(break_finish[i]).val();
        //     if(startTm != '' && endTm != ''){
        //     diff = ( new Date("2023-02-01 " + endTm) - new Date("2023-02-01 " + startTm) ) / 1000 / 60;
        //     breaktimehtml += '<div class="breakTimeRow"><div class="align-items-center row g-2 "><div class="col-lg-5 col-sm-5 col-xs-12 mt-3"><label for="breakTimeStart" class="form-label">Break Time Start</label>';
        //     breaktimehtml += '<input type="text" class="form-control breakTimeStart" data-provider="timepickr" data-time-basic="true" placeholder="Break Time Start" value="'+startTm+'"></div>';
        //     breaktimehtml += '<div class="col-lg-5 col-sm-5 col-xs-12 mt-3"><label for="breakTimeFinish" class="form-label">Break Time Finish</label><input type="text"  value="'+endTm+'"class="form-control breakTimeFinish" data-provider="timepickr" data-time-basic="true" placeholder="Break Time Finish"></div>';
        //     breaktimehtml += '<div class="col-lg-2 col-sm-2 col-xs-12 mt-3"><label for="breakTimeDuration" class="form-label">Duration</label><input type="text" class="form-control breakTimeDuration" value="'+diff+'" readonly placeholder="Hours"></div></div>';
        //     breaktimehtml += '<p class="pointerCursor mt-2 mb-0 fw-medium text-end breakBtns"><span class="delBreakTimeBtn text-danger align-items-center justify-content-end d-flex"><i class="ri-delete-bin-5-fill px-1"></i> Del Break Time</span></p></div>';
        //     }
            
        //   i++;
        // });
        // $(breaktimehtml).insertBefore('.breakTimeRow');
        $("#startTime").val(startTime);
        $("#finishTime").val(finishTime);
        $(".breakTimeStart").val(break_start);
        $(".breakTimeFinish").val(break_finish);
        $(".breakTimeDuration").val(breakDuration);
        $("#outletName option").each(function()
            {
                if($(this).val() == outletName){
                    options += '<option value="'+$(this).val()+'" selected>'+$(this).text()+'</option>';
                }else{
                    if($(this).val() == 'add_outlet'){
                        options += '<option value="add_outlet" class="text-center text-primary fw-medium bg-soft-secondary py-1">+ Add New Outlet</option>';
                    }else{
                        options += '<option value="'+$(this).val()+'">'+$(this).text()+'</option>';
                    }
                }
            });
        $('#outletName').html(options);
        $("#addRosterTimeBtn").html('Update');
    } 
    $('#addRosterTimeClose').click(function(){
        $('#timealert').css('display','none');
    });
    
    function addtime(){
        var startTime = $("#startTime").val();
        var finishTime = $("#finishTime").val();
        var breakTimeStart = '';
        var breakTimeFinish = '';
        var html = '';
        var i;
        var outletid = $("#outletName").val();  
        var outletName = $("#outletName option:selected").text();
        var rowid = $("#rowId").val();
        var rowWeek = $('#'+rowid).attr('rel');
        if(startTime != '' && finishTime != ''){
            var timehours = ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:0","22:00","23:00"];
            
            for(i=0;i<23;i++){
                if(startTime <= timehours[i] &&  finishTime >= timehours[i]){
                    html = '<div class="day-shift"></div>';
                }
                else{
                    
                }
            }
            var totalBreakDuration = 0;
            $('.breakTimeDuration').each(function(){
                totalBreakDuration = totalBreakDuration + parseInt($(this).val());
            });
            var empID = $('#'+rowid).closest('.employeeRole').find('#employeeIdSelected').val();
            $('.breakTimeStart').each(function(){
                
                breakTimeStart = $(this).val();
                breakTimeFinish = $(this).closest('.row').find('.breakTimeFinish').val();
                html += '<input type="hidden" name="'+rowWeek+'_break_start['+empID+']['+startTime+'][]" class="'+rowWeek+'_break_start break_values" value="'+breakTimeStart+'"><input type="hidden" name="'+rowWeek+'_break_finish['+empID+']['+startTime+'][]" class="'+rowWeek+'_break_finish break_values" value="'+breakTimeFinish+'">';
                
            }); 
            
            // $('#'+rowid).find('.breakInOutTime').html(html);
            // $('#'+rowid).find('.startTimeInputValue').val(startTime);
            // $('#'+rowid).find('.startTimeValue').html(startTime);
            // $('#'+rowid).find('.finishTimeInputValue').val(finishTime);
            // $('#'+rowid).find('.finishTimeValue').html(finishTime);
            // $('#'+rowid).find('.breakTimeInputValue').val(totalBreakDuration);
            // $('#'+rowid).find('.breakTimeValue').html(totalBreakDuration);
            // $('#'+rowid).find('.outletNameValue').html(outletName);
            // $('#'+rowid).find('.outletNameID').val(outletid);
            // $('#'+rowid).find('.addHrs').css('display','none');
            // $('#'+rowid).find('.approvedHrs').css('display','block');
            // $("#addRosterTime").find('input').val('');
            // $("#addRosterTime").removeClass('show');
            // $("#addRosterTime").css('display','none');
            // $('#timealert').css('display','none');
        }else{
            $('#timealert').css('display','block');
        }
    }
    $(document).on( 'change', '.breakTimeStart, .breakTimeFinish', function () {
        breakTimeStart = $(this).closest('.row').find('.breakTimeStart').val();
        breakTimeFinish = $(this).closest('.row').find('.breakTimeFinish').val();
        var diff = ( new Date("2023-02-01 " + breakTimeFinish) - new Date("2023-02-01 " + breakTimeStart) ) / 1000 / 60;
        if(diff > 0){
            $(this).closest('.row').find('.breakTimeDuration').val(diff);
        }else{
            $(this).closest('.row').find('.breakTimeDuration').val('0')
        }
    });
    function addEmployee(that){
        var rowId= $(that).attr('data-rel-id');
        $("#addEmployeeModel").addClass('show');
        $("#addEmployeeModel").css('display','block');
        $("#rowIdEmp").val(rowId);
        $("#addEmployeeModelLabel").html('Add Employee');
        $("#addEmployeeBtn").html('Add');
    } 
    $('#addEmployeeClose').click(function(){
        if($("#addEmployeeBtn").html() == 'Add'){
            var rowId= $("#rowIdEmp").val();
            $("#"+rowId).find('.empInputs input').val('');
            $("#payRatesetails").html('');
            $("#empPopupCol").removeClass('col-lg-8');
            $("#empPopupCol").addClass('col-lg-12');
            $("#empRatesCol").css('display','none');
        }
        $('#emp_slt').removeClass('border-danger');
        $('.emperror').remove();
        $('#addEmployeeBtn').removeAttr('disabled');
        
    });
    function addEmployeeDetails(){
        var emp_slt = $("#emp_slt").val();
        // var empDept = $( "#empDept option:selected" ).text();
        // var empDeptId = $( "#empDept" ).val();
        var rowid = $("#rowIdEmp").val();
        if(emp_slt != ''){
            // console.log('empDeptId'+empDeptId);
            // if(empDeptId != ''){
            //     $('#'+rowid).find('.empDepartment').val(empDept);
            //     $('#'+rowid).find('.empDepartmentId').val(empDeptId);
            // }else{
            //     $('#'+rowid).find('.empDepartment').val('');
            //     $('#'+rowid).find('.empDepartmentId').val('');
            // }
            $('#'+rowid).find('.addemp').css('display','none');
            $('#'+rowid).find('.empDetails').css('display','block');
            $("#addEmployeeModel").find('.form-control').val('');
            $("#addEmployeeModel").removeClass('show');
            $("#addEmployeeModel").css('display','none');
            $('#empalert').css('display','none');
            $("#empPopupCol").removeClass('col-lg-8');
                $("#empPopupCol").addClass('col-lg-12');
                $("#empRatesCol").css('display','none');
                $('#emp_slt').removeClass('border-danger');
                $('.emperror').remove();
                $('#addEmployeeBtn').removeAttr('disabled');
        }else{
            $('#empalert').css('display','block');
        }
    }
    function editEmployee(that){
        var rowId= $(that).attr('data-rel-id');
        $("#addEmployeeModel").addClass('show');
        $("#addEmployeeModel").css('display','block');
        $("#rowIdEmp").val(rowId);
        $("#addEmployeeModelLabel").html('Edit Employee');
        $("#addEmployeeBtn").html('Update');
        $("#emp_availability_details").css('display','none');
        $("#append_employee_availability").html('');
        var emp_id = $('#'+rowId).find("#employeeIdSelected").val();
        // var empDeptId = $('#'+rowId).find(".empDepartmentId").val();
        var empRoleName = $('#'+rowId).find(".empRoleName").html();
        
        $("#empRoleNameModal").val(empRoleName);
        var options = '';
        $("#emp_slt option").each(function()
            {
                if($(this).val() == emp_id){
                    options += '<option value="'+$(this).val()+'" selected>'+$(this).text()+'</option>';
                }else{
                    options += '<option value="'+$(this).val()+'">'+$(this).text()+'</option>';
                }
            });
        $('#emp_slt').html(options);
        
        // var optionsDept = '';
        // $("#empDept option").each(function()
        //     {
        //         if($(this).val() == empDeptId){
        //             optionsDept += '<option value="'+$(this).val()+'" selected>'+$(this).text()+'</option>';
        //         }else{
        //             optionsDept += '<option value="'+$(this).val()+'">'+$(this).text()+'</option>';
        //         }
        //     });
        // $('#empDept').html(optionsDept);
        
    } 
       
    $('.ModalClose').click(function(){
        $(this).closest('.modal').removeClass('show');
        $(this).closest('.modal').css('display','none');
        $(this).closest('.modal').find('input, textarea').val('');
        $(this).closest('.modal').find('select').val('');
        $(this).closest('.modal').find('#emp_availability_details').css('display','none'); 
        $(this).closest('.modal').find('.alert').css('display','none');
    });
    
    // multiple break time
    $(document).on( 'click', '.addBreakTimeBtn', function () {
        
        var thisRow = $( this ).closest( '.breakTimeRow' );
        
        $( thisRow ).clone().insertAfter( thisRow ).find('.form-control').val( '' );
        $( thisRow ).find('.breakBtns').html('<span class="delBreakTimeBtn text-danger align-items-center justify-content-end d-flex"><i class="ri-delete-bin-5-fill px-1"></i> Del Break Time</span>');
        
    });
    $(document).on("click", ".delBreakTimeBtn" , function() {
        $(this).closest('.breakTimeRow').remove();
    });
    
    $(document).on("change", "#outletName" , function() {
        var outletval = $(this).val();
        if(outletval == 'add_outlet'){
            $(this).val('');
            Swal.fire({
                title: "Add New Outlet",
                html: '<div class="mt-3 text-start"><label for="input-outlet" class="form-label fs-13">Outlet Name</label><input type="text" class="form-control" id="input-outlet" placeholder="Enter Outlet Name"></div>',
                confirmButtonClass: "btn btn-primary w-xs mb-2",
                confirmButtonText: 'Create',
                buttonsStyling: !1,
                showCloseButton: !0,
            }).then(function (t) {
                if (t.value) {
                    var outletNameval = $('#input-outlet').val(); 
                    console.log(outletNameval); 
                    $.ajax({
                        url:"/HR/index.php/admin/saveOutlet", 
                		method:"POST", 
                		data:{outletNameval:outletNameval},
                	    success:function(resp){
	                        
                            if(resp != 'error'){
                               $('#outletName').append('<option value="'+resp+'" selected>'+outletNameval+'</option>');
                                Swal.fire({ title: "Outlet Saved!", icon: "success", confirmButtonClass: "btn btn-primary w-xs", buttonsStyling: !1 }); 
                            }else{
                                Swal.fire({ title: "Outlet not saved", icon: "info", confirmButtonClass: "btn btn-primary w-xs", buttonsStyling: !1 });
                            }
                            
                	    }
                    });
                }
            });
        }
    });
    



$('.remove-item-btn').click(function(){
    var id = $(this).attr('data-rel-id');
    Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: !0,
          confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
          cancelButtonClass: "btn btn-danger w-xs mt-2",
          confirmButtonText: "Yes, delete it!",
          buttonsStyling: !1,
          showCloseButton: !0,
      }).then(function (e) {
          if (e.value) {
              
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>index.php/admin/delete_roster",
                data:'id='+id,
                success: function(data){
                  location.reload();
                  
                }
            });
            
        
              
          }
      })
});


    	// clone row for wrap
    
    $(document).on( 'click', '.add_field_button', function () {
        
        var thisRow = $( this ).closest( '.employeeRole' );
        
        var RowCount = $( thisRow ).attr('data-count');
        $( thisRow ).clone().insertAfter( thisRow ).find('input, select').val( '' );
        $( thisRow ).next('.employeeRole').find('textarea').html('');
        $( thisRow ).next('.employeeRole').find('textarea').val('');
        $( thisRow ).next('.employeeRole').find('.break_values').remove();
        $( thisRow ).next('.employeeRole').find('.addHrs').css('display','flex');
        $( thisRow ).next('.employeeRole').find('.approvedHrs').css('display','none');
        $( thisRow ).next('.employeeRole').find('.addemp').css('display','flex');
        $( thisRow ).next('.employeeRole').find('.empDetails').css('display','none');
        
        var thisRowAddbtn = $( thisRow ).next('.employeeRole').find( '.add_field_wrap' );
        if (!$(thisRow).has(".remove_field_button").length) {
            $('<span><a href="#" class="btn btn-danger remove_field_button">-</a></span>').insertAfter(thisRowAddbtn);
        } 
        
        var RowCountnext = RowCount;
        var weekddays = ['mon','tues','wed','thus','fri','sat','sun'];
        var tempRow = $( thisRow ).nextAll( '.employeeRole' );
        tempRow.each(function() {
            RowCountnext = parseInt(RowCountnext) + 1;
            $( this ).attr('data-count',RowCountnext);
            $( this ).attr('id','empRosterRow_'+RowCountnext);
            $( this ).find('.addemp').attr('data-rel-id','empRosterRow_'+RowCountnext);
            
            for(var i=0;i<7;i++){
                $( this ).find('.'+weekddays[i]+'_col').attr('id','row_'+weekddays[i]+'_'+RowCountnext);
                $( this ).find('.'+weekddays[i]+'_col [rel = '+weekddays[i]+']').attr('data-rel-id','row_'+weekddays[i]+'_'+RowCountnext);
            }
        });
        
    });
    $(document).on("click", ".remove_field_button" , function() {
        $(this).closest('.employeeRole').remove();
    });
    
    function rosterFormSubmit(){
	
	var form = $("#rosterForm");
	var formdata =  form.serialize();
	
	     $.ajax({
				type: "POST",
		        url: "<?php echo base_url();?>index.php/admin/submit_roster",
		        data:formdata,
		      //  beforeSend: function(){
        //         $("#loader").show();
        //          },
        //         complete:function(data){
        //         $("#loader").hide();
        //          },
		        success: function(data){
		        console.log(data);
		        if(data=='Sucess'){
		        $msg = "Roster Added Succesfully";
		        $icon = "success";
		        }else if(data=='validation'){
		         $msg = "Ensure all mandatory fields are populated";
		         $icon = "warning";
		        }
		         <!--start 6Jan 2021 work-->
		         
		         // else if(data=='alreadyAssigned'){
		         // $msg = "Shift Timings are already assigned for the selected employee";
		         // $icon = "warning";
		        //  }
		        
		         <!--End 6Jan 2021 work-->
		        else if(data=='leaveValidation'){
		         $msg = "One of the employees is on leave during the selected shift time. Please ensure the employee is not rostered for the leave days.";
		         $icon = "warning";
		        }else{
		         $msg = "Shift Timings are overlapping for the employee selected";
		         $icon = "warning";
		        } 
		        Swal.fire({
		            
                text: $msg,
                 icon: $icon,
          }).then((value) => {
          if(data=='Sucess'){
       window.location = "<?php echo $link; ?>";
       }
       });
		  }
	       });
}