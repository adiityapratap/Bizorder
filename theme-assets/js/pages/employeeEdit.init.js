/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Form wizard Js File
*/

// user profile img file upload
if (document.querySelector("#profile-img-file-input"))
    document.querySelector("#profile-img-file-input").addEventListener("change", function () {
        var preview = document.querySelector(".user-profile-image");
        var file = document.querySelector(".profile-img-file-input").files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file)
            reader.readAsDataURL(file);
    });

if (document.querySelectorAll(".form-steps"))
    document.querySelectorAll(".form-steps").forEach(function (form) {

        // next tab
        if (form.querySelectorAll(".nexttab"))
            form.querySelectorAll(".nexttab").forEach(function (nextButton) {
                var tabEl = form.querySelectorAll('button[data-bs-toggle="pill"]');
                tabEl.forEach(function (item) {
                    item.addEventListener('show.bs.tab', function (event) {
                        event.target.classList.add('done');
                    });
                });
                nextButton.addEventListener("click", function () {
                    
                    var form_type = $('#form_type').val();
                    var nextTab = nextButton.getAttribute('data-nexttab');
                    
                    if(form_type != 'view'){
                    //form submit
                    var error = 0;
                    var submittedForm = nextButton.getAttribute('rel');
                    
                    $('.requiredField').css('border-color','#ced4da');
                    $('#errorAlert').css('display','none');
                            
                    $.each($('#'+submittedForm+' .requiredField'), function(index, item) {
                        
                        if($(item).val() == ''){
                            
                            $(item).css('border-color','#f00');
                            $('#errorAlert').css('display','block');
                            error = 1;
                        }
                    });
                    if(submittedForm == 'taxDetailsForm'){
                        if($('input[name=job_type]').attr('checked', 'checked')){}else{
                            $('#errorAlert').css('display','block');
                            error = 1;
                        }
                    }
                    if(error == 0){
                    
                    
                    var emp_id = $('#emp_id').val();
                    
                   
                    var form = $('#'+submittedForm)[0];
                    var Fdata = new FormData(form);
                  
                        const xhttp = new XMLHttpRequest();
                        if(form_type == 'onboarding'){
                             xhttp.open("POST", "/onboarding_process_submit/"+emp_id);
                        }else{
                         xhttp.open("POST", "/employeeUpdateController/"+emp_id);
                        }
                        xhttp.onload = function() {
                            // console.log(this.responseText);
                            if(this.responseText == 'success'){
                                // proceed to next tab
                                
                                
                                
                                if(form_type == 'onboarding' && nextTab == 'Finish'){
                                    Swal.fire({
                                      position: 'center',
                                      icon: 'success',
                                      title: 'Thank you for submitting your onboarding application. You will receive an email shortly with the Task Management portal login process. Please contact your manager if any issues.',
                                      showConfirmButton: true,
                                      showCloseButton: false
                                    }).then(function (result) {
                                        if (result.value) {
                                            window.location.href = "https://blaque.com.au/";
                                        }
                                    });
                                }else if(form_type != 'onboarding' && nextTab == 'Finish'){
                                    Swal.fire({
                                      position: 'center',
                                      icon: 'success',
                                      title: 'Details Successfully Uploaded.',
                                      showConfirmButton: true,
                                      showCloseButton: false
                                    }).then(function (result) {
                                        if (result.value) {
                                            window.location.href = "https://blaque.com.au/employeeList";
                                        }
                                    });
                                }else{
                                    var prevTab = nextButton.getAttribute('data-prevtab');
                                    $('.tab-pane').removeClass('active');
                                    $('.tab-pane').removeClass('show');
                                    $('.nav-link').removeClass('active');
                                    document.getElementById(nextTab).click();
                                    $('.'+prevTab).addClass('done');
                                    $('.'+nextTab).addClass('active');
                                }
                            }
                            else{
                                Swal.fire({
                                  position: 'center',
                                  icon: 'error',
                                  title: 'Form not submitted. Please Try again.',
                                  showConfirmButton: true,
                                  showCloseButton: false
                                });
                            }
                        }
                        xhttp.send(Fdata);
                    }
                    
                    }else{
                        var prevTab = nextButton.getAttribute('data-prevtab');
                                    $('.tab-pane').removeClass('active');
                                    $('.tab-pane').removeClass('show');
                                    $('.nav-link').removeClass('active');
                                    document.getElementById(nextTab).click();
                                    $('.'+prevTab).addClass('done');
                                    $('.'+nextTab).addClass('active');
                    }
                    
                });
            });
            if (form.querySelectorAll(".mobPrevtab"))
            form.querySelectorAll(".mobPrevtab").forEach(function (mobPrevtab) {
                var tabEl = form.querySelectorAll('button[data-bs-toggle="pill"]');
                tabEl.forEach(function (item) {
                    item.addEventListener('show.bs.tab', function (event) {
                        event.target.classList.add('done');
                    });
                });
                mobPrevtab.addEventListener("click", function () {
                     $('.nav-link').removeClass('active');
                    var currTabNumber = parseInt(mobPrevtab.getAttribute('data-tab-number')) + 1;
                    
                    var totalDoneTab = $(".custom-mb-nav .done").length;
                    console.log('totalDoneTab'+totalDoneTab);
                    console.log('currTabNumber'+currTabNumber);
                    for(var i=currTabNumber; i <= totalDoneTab; i++){
                        $('[data-tab-number='+i+']').removeClass('done');
                    }
                    
                
                    
                });
            });

        //Pervies tab
        if (form.querySelectorAll(".previestab"))
            form.querySelectorAll(".previestab").forEach(function (prevButton) {

                prevButton.addEventListener("click", function () {
                    var prevTab = prevButton.getAttribute('data-previous');
                    var totalDone = prevButton.closest("form").querySelectorAll(".custom-nav .done").length;
                    for (var i = totalDone - 1; i < totalDone; i++) {
                        (prevButton.closest("form").querySelectorAll(".custom-nav .done")[i]) ? prevButton.closest("form").querySelectorAll(".custom-nav .done")[i].classList.remove('done'): '';
                    }
                    document.getElementById(prevTab).click();
                });
            });

        // Step number click
        var tabButtons = form.querySelectorAll('button[data-bs-toggle="pill"]');
        if (tabButtons)
            tabButtons.forEach(function (button, i) {
                button.setAttribute("data-position", i);
                button.addEventListener("click", function () {
                    var getProgressBar = button.getAttribute("data-progressbar");
                    if (getProgressBar) {
                        var totalLength = document.getElementById("custom-progress-bar").querySelectorAll("li").length - 1;
                        var current = i;
                        var percent = (current / totalLength) * 100;
                        document.getElementById("custom-progress-bar").querySelector('.progress-bar').style.width = percent + "%";
                    }
                    (form.querySelectorAll(".custom-nav .done").length > 0) ?
                    form.querySelectorAll(".custom-nav .done").forEach(function (doneTab) {
                        doneTab.classList.remove('done');
                    }): '';
                    for (var j = 0; j <= i; j++) {
                        tabButtons[j].classList.contains('active') ? tabButtons[j].classList.remove('done') : tabButtons[j].classList.add('done');
                    }
                });
            });
    });