var checkAll = document.getElementById("checkAll");
if (checkAll) {
    checkAll.onclick = function () {
        var checkboxes = document.querySelectorAll('.form-check-all input[type="checkbox"]');
        if (checkAll.checked == true) {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
                checkbox.closest("tr").classList.add("table-active");
            });
        } else {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
                checkbox.closest("tr").classList.remove("table-active");
            });
        }
    };
}
var perPage = 10;

//Table
var options = {
    valueNames: [
        "leave_id",
        "emp_name",
        "company_name",
        "branch_name",
        "leave_type",
        "leave_certificate",
        "leave_start_date",
        "leave_end_date",
        "new_nominated_person",
        "new_nominated_person_id",
        "manager_comment",
        "leave_status",
        "leave_status_change",
    ],
    page: perPage,
    pagination: true,
    plugins: [
        ListPagination({
            left: 2,
            right: 2,
        }),
    ],
};

// Init list
var tasksList = new List("tasksList", options).on("updated", function (list) {
    list.matchingItems.length == 0 ?
        (document.getElementsByClassName("noresult")[0].style.display = "block") :
        (document.getElementsByClassName("noresult")[0].style.display = "none");
    var isFirst = list.i == 1;
    var isLast = list.i > list.matchingItems.length - list.page;

    document.querySelector(".pagination-prev.disabled") ?
        document.querySelector(".pagination-prev.disabled").classList.remove("disabled") : "";
    document.querySelector(".pagination-next.disabled") ?
        document.querySelector(".pagination-next.disabled").classList.remove("disabled") : "";
    if (isFirst)
        document.querySelector(".pagination-prev").classList.add("disabled");
    if (isLast)
        document.querySelector(".pagination-next").classList.add("disabled");
    if (list.matchingItems.length <= perPage)
        document.querySelector(".pagination-wrap").style.display = "none";
    else
        document.querySelector(".pagination-wrap").style.display = "flex";
    if (list.matchingItems.length == perPage)
        document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click()
    if (list.matchingItems.length > 0)
        document.getElementsByClassName("noresult")[0].style.display = "none";
    else
        document.getElementsByClassName("noresult")[0].style.display = "block";
});

const xhttp = new XMLHttpRequest();
xhttp.onload = function () {
    
    
    console.log(this.responseText);
    if(this.responseText){
        var leaveStatusChange = '';
        var json_records = JSON.parse(this.responseText);
        if(json_records){
      json_records.forEach(raw => {
          var pending ='';
          var rejected ='';
          var approved ='';
          var manager_comment = '';
          var leaveStatusChange ='';
          var new_nominated_person ='';
            if(raw.leave_status == 1){
                approved = "selected";
            }
            else if(raw.leave_status == 0){
                rejected = "selected";
            }
            else{
                pending = "selected";
            }
            var downloadCertificate = '';
            
            
            leaveStatusChange += '<select class="form-control" name="leaveStatus" rel="leave_status" onchange="leaveUpdate(this);" id="'+raw.leave_id+'" required />';
            leaveStatusChange += '<option value="2" '+pending+'>Pending</option><option value="1" '+approved+'>Approved</option><option value="0" '+rejected+'>Rejected</option></select>';
            if(raw.leave_certificate != '' && raw.leave_certificate != null){
                downloadCertificate = '<a href="/writable/uploads/'+raw.leave_certificate+'" class="btn btn-success btn-sm" download><i class="ri-download-2-fill"></i> Download</a>';
            } 
             
             
            if(raw.emp_id && raw.emp_id){
                if(raw.leave_comment != ''){
                    manager_comment = '<button class="btn btn-primary btn-sm view_comment_btn" data-id="'+raw.leave_id+'" data-popup="view" onclick="fetchEmpLeave(this)" data-bs-toggle="modal" data-bs-target="#viewCommentModal">View</button>';
                }else{
                    manager_comment = '<button class="btn btn-danger btn-sm view_comment_btn" data-id="'+raw.leave_id+'" data-popup="add" onclick="fetchEmpLeave(this)" data-bs-toggle="modal" data-bs-target="#viewCommentModal">Add</button>';
                }
                if(raw.new_nominated_person != '' && raw.new_nominated_person != 0){
                    new_nominated_person = '<a href="/employeeView/'+raw.new_nominated_person_id+'">'+raw.new_nominated_person+'</a>';
                }else{
                    new_nominated_person = '<button class="btn btn-danger btn-sm view_comment_btn" data-id="'+raw.leave_id+'" data-popup="addNominatedPerson" onclick="fetchEmpLeave(this)" data-bs-toggle="modal" data-bs-target="#viewCommentModal">Add</button>';
                }
                var emp_name = '<a href="/employeeView/'+raw.emp_id+'" id="emp_'+ raw.leave_id +'" rel="'+raw.emp_id+'">'+raw.emp_name+'</a>';
                
                tasksList.add({
                    leave_id: '<a href="apps-tasks-details" class="fw-medium link-primary">' + raw.leave_id + "</a>",
                    emp_name: emp_name,
                    company_name: raw.company_name,
                    branch_name: raw.branch_name,
                    leave_type: raw.leave_type,
                    leave_certificate: downloadCertificate,
                    new_nominated_person: new_nominated_person,
                    manager_comment: manager_comment,
                    leave_start_date: '<span id="startDate_'+ raw.leave_id +'">'+fomateDate(raw.leave_start_date)+'</span>',
                    leave_end_date: '<span id="endDate_'+ raw.leave_id +'">'+fomateDate(raw.leave_end_date)+'</span>',
                    leave_status: isStatus(raw.leave_status),
                    leave_status_change: leaveStatusChange,
                });
            }
            else{
                if(raw.leave_comment != ''){
                    manager_comment = '<button class="btn btn-danger btn-sm view_comment_btn" data-id="'+raw.leave_id+'" data-comment="view" onclick="fetchEmpLeave(this)" data-bs-toggle="modal" data-bs-target="#viewCommentModal">View</button>';
                }else{
                    manager_comment = '';
                }
                tasksList.add({
                    leave_id: '<a href="apps-tasks-details" class="fw-medium link-primary">' + raw.leave_id + "</a>",
                    leave_type: raw.leave_type,
                    leave_certificate: downloadCertificate,
                    manager_comment: manager_comment,
                    leave_start_date: fomateDate(raw.leave_start_date),
                    leave_end_date: fomateDate(raw.leave_end_date),
                    leave_status: isStatus(raw.leave_status),
                    
                });
            }
            
            tasksList.sort('leave_start_date', { order: "desc" });
            
            refreshCallbacks();
        });
        }
        tasksList.remove("leave_type", ``);
    }
}
xhttp.open("GET", "/employeeLeaveListController");
xhttp.send();
// console.log(tasksList);

// isCount = new DOMParser().parseFromString(
//     tasksList.items.slice(-1)[0]._values.leave_id,
//     "text/html"
// );
// console.log(isCount);
// var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("tasksId"),
    emp_group = document.getElementById("emp_group"),
    emp_id = document.getElementById("emp_id"),
    leave_type = document.getElementById("leave_type"),
    leave_medical_certificate = document.getElementById("leave-medical-certificate"),
    leave_start_date = document.getElementById("leave-start-date"),
    leave_end_date = document.getElementById("leave-end-date"),
    
    // new_nominated_person = document.getElementById("task-description"),
     assignedtoNameField = 'Demo Assign',
    //document.getElementById("assignedtoName-field"),
    taskStartDate = document.getElementById("task-start-date"),
     taskEndDate = document.getElementById("task-end-date"),
    priorityField = document.getElementById("priority-field"),
    statusField = document.getElementById("ticket-status"),
    addBtn = document.getElementById("add-btn"),
    removeBtns = document.getElementsByClassName("delBtn");
    // viewCommentBtns = document.getElementsByClassName("view_comment_btn");
refreshCallbacks();



//filterOrder("All");


// function filterOrder(isValue) {
//     var values_status = isValue;
//     tasksList.filter(function (data) {
//         var statusFilter = false;
//         matchData = new DOMParser().parseFromString(
//             data.values().status,
//             "text/html"
//         );
//         var status = matchData.body.firstElementChild.innerHTML;
//         if (status == "All" || values_status == "All") {
//             statusFilter = true;
//         } else {
//             statusFilter = status == values_status;
//         }
//         return statusFilter;
//     });
//     tasksList.update();
// }

function updateList() {
    var values_status = document.querySelector(
        "input[name=status]:checked"
    ).value;

    data = userList.filter(function (item) {
        var statusFilter = false;

        if (values_status == "All") {
            statusFilter = true;
        } else {
            statusFilter = item.values().sts == values_status;
        }
        return statusFilter;
    });

    userList.update();
}

document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
    if (e.relatedTarget.classList.contains("add-btn")) {
        document.getElementById("exampleModalLabel").innerHTML = "Add New Leave Request";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
        document.getElementById("add-btn").style.display = "block";
    } else {
        document.getElementById("exampleModalLabel").innerHTML = "List Task";
        document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
    }
});

document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
    clearFields();
});

document.querySelector("#tasksList").addEventListener("click", function () {
    refreshCallbacks();
    ischeckboxcheck();
});

// var table = document.getElementById("tasksTable");
// // save all tr
// var tr = table.getElementsByTagName("tr");
// var trlist = table.querySelectorAll(".list tr");

var count = 11;
addBtn.addEventListener("click", function (e) {
    e.preventDefault();
    
        //form submit
           $('.invalid-field').css('display','none');
            var empGroup = emp_group.value;
            
            var leaveType = leave_type.value;
            var leaveMedicalCertificate = leave_medical_certificate.value;
            var leaveStartDate = leave_start_date.value;
            var leaveEndDate = leave_end_date.value;
            
            var errFlag = 0;
            if(empGroup != 10){
                var empId = emp_id.value;
                if(empId =='' ){
                    errFlag = 1;
                    $('#err-empid-field').css('display','block');
                }
            }
            
            if(leaveType =='' ){
                errFlag = 1;
                $('#err-leavetype-field').css('display','block');
            }
            else{
                if(leaveType == 'Sick' && leaveMedicalCertificate =='' ){
                    errFlag = 1;
                    $('#err-leaveMedicalCertificate-field').css('display','block');
                }
            }
            if(leaveStartDate =='' ){
                errFlag = 1;
                $('#err-leavestartdate-field').css('display','block');
            }
            if(leaveEndDate =='' ){
                errFlag = 1;
                $('#err-leaveenddate-field').css('display','block');
            }
            
            if(errFlag == 0){
               var form = $('#form-event')[0];
                var Fdata = new FormData(form);
          
                const xhttp = new XMLHttpRequest();
                xhttp.open("POST", "/employeeLeaveAddController");
                xhttp.onload = function() {
                    console.log(this.responseText);
                      if(this.responseText == 'success'){
                          var msgIcon = 'success';
                          var msgTitle = 'Leave submitted successfully!';
                      }
                      else{
                          var msgTitle = 'Something went wrong. Try again!';
                          var msgIcon = 'error';
                         
                      }
                        Swal.fire({
                          position: 'center',
                          icon: msgIcon,
                          title: msgTitle,
                          showConfirmButton: true,
                        //   timer: 2000,
                          showCloseButton: false
                        });
                        location.reload();
                    
                }
                xhttp.send(Fdata); 
            }
            
                
           
});




// var example = new Choices(priorityField, {
//     searchEnabled: false,
// });

// var statusVal = new Choices(statusField, {
//     searchEnabled: false,
// });

function ClearFilterData() {
    window.location.reload();
}

function SearchData() {
    var isstatus = document.getElementById("idStatus").value;
    var startDatepickerVal = document.getElementById("start-datepicker").value;
    var EndDatepickerVal = document.getElementById("end-datepicker").value;

    var Startdate1 = startDatepickerVal.split(" to ")[0];
    var Startdate2 = startDatepickerVal.split(" to ")[1];
    
    var Enddate1 = EndDatepickerVal.split(" to ")[0];
    var Enddate2 = EndDatepickerVal.split(" to ")[1];
   

    tasksList.filter(function (data) {
     
        matchData = new DOMParser().parseFromString(
            data.values().leave_status,
            "text/html"
        );
        
        var status = matchData.body.firstElementChild.innerHTML;
        var statusFilter = false;
        var dateFilter = false;

        if (status == "all" || isstatus == "all") {
            statusFilter = true;
        } else {
            statusFilter = status == isstatus;
        }

        if ((typeof Startdate2 === 'undefined') && (typeof Enddate2 === 'undefined')){
            console.log('entered onedate');
            if (
                (new Date(data.values().leave_start_date.slice(0, 12)) >= new Date(Startdate1) &&
                new Date(data.values().leave_start_date.slice(0, 12)) <= new Date(Enddate1) ) ||
                (new Date(data.values().leave_end_date.slice(0, 12)) >= new Date(Startdate1) &&
                new Date(data.values().leave_end_date.slice(0, 12)) <= new Date(Enddate1) ) 
            ) {
                dateFilter = true;
            } else {
                dateFilter = false;
            }
        }
        else{
      
            if (
                (new Date(data.values().leave_start_date.slice(0, 12)) >= new Date(Startdate1) &&
                new Date(data.values().leave_start_date.slice(0, 12)) <= new Date(Startdate2) ) ||
                (new Date(data.values().leave_end_date.slice(0, 12)) >= new Date(Enddate1) &&
                new Date(data.values().leave_end_date.slice(0, 12)) <= new Date(Enddate2) ) 
            ) {
                dateFilter = true;
            } else {
                dateFilter = false;
            }
        }
       
        if (statusFilter && dateFilter) {
            return statusFilter && dateFilter;
        } else if (statusFilter && startDatepickerVal == "" && EndDatepickerVal == "") {
            return statusFilter;
        } else if (dateFilter && startDatepickerVal == "" && EndDatepickerVal == "") {
            return dateFilter;
        }
    });
    tasksList.update();
}

function ischeckboxcheck() {
    document.getElementsByName("checkAll").forEach(function (x) {
        x.addEventListener("click", function (e) {
            if (e.target.checked) {
                e.target.closest("tr").classList.add("table-active");
            } else {
                e.target.closest("tr").classList.remove("table-active");
            }
        });
    });
}

function refreshCallbacks() {
    removeBtns.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.target.closest("tr").children[1].innerText;
            itemId = e.target.closest("tr").children[1].innerText;
            console.log(itemId);
            var itemValues = tasksList.get({
                leave_id: itemId,
            });

            
                   
                
        });
    });

//  viewBtns.forEach(function (btn) {
//     // console.log(btn);

// let TaskID = btn.closest("tr").children[1].innerText;
// console.log("TIDD = "+btn.closest("tr").children);
// btn.setAttribute('href', "employeeTaskDetails/"+TaskID);


//   });
 
    // editBtns.forEach(function (btn) {
        
    //     btn.addEventListener("click", function (e) {
          
    //         e.target.closest("tr").children[1].innerText;
    //         itemId = e.target.closest("tr").children[1].innerText;
                
    //         var itemValues = tasksList.get({
    //             id: itemId,
    //         });
          
    //         itemValues.forEach(function (x) {
               
  
    //             isid = new DOMParser().parseFromString(x._values.leave_id, "text/html");
                
                
    //              var selectedid = isid.body.firstElementChild.innerHTML;
             
    //             if (selectedid == itemId) {
    //                 // console.log('Id matched');
    //                 //  console.log("itemId  ===== "+itemId);
                     
    //                 // idField.value = selectedid;

                   
                    
                   
    //                 document.getElementById('leave_id').value = itemId;
    //                 document.getElementById('emp_name').value = x._values.emp_name;
    //                 document.getElementById('task-start-date').value = fomateDate(x._values.leave_start_date);
    //                 document.getElementById('task-end-date').value = fomateDate(x._values.leave_end_date);
                
    //             }
               
    //         });
      
    //     });
    // });

}

//  document.getElementById("delete-record").addEventListener("click", function () {
                        
//                         const xhttp = new XMLHttpRequest();
//                         xhttp.onload = function() {
//                             console.log(this.responseText);
                            
//                               if(this.responseText == 'success'){
//                                   var msgIcon = 'success';
//                                   var msgTitle = 'Leave deleted successfully!';
//                               }
//                               else{
//                                   var msgIcon = 'error';
//                                   var msgTitle = 'Something went wrong!';
//                               }
//                                 Swal.fire({
//                                   position: 'center',
//                                   icon: msgIcon,
//                                   title: msgTitle,
//                                   showConfirmButton: false,
//                                   timer: 1500,
//                                   showCloseButton: false
//                                 });
//                                 location.reload();
                            
//                             }
                        
//                           var leave_id = itemId;
                          
                         
//                           xhttp.open("POST", "employeeLeaveDeleteController?leave_id="+leave_id);
//                           xhttp.send(); 
                        
//                         // tasksList.remove("leave_id", isElem.outerHTML);
//                         document.getElementById("deleteOrder").click();
//                     });

function clearFields() {
    // projectNameField.value = "";
    // tasksTitleField.value = "";
    clientNameField.value = "";
    assignedtoNameField.value = "";
    leave_start_date.value = "";
     leave_start_date.value = "";
    if (example)
        example.destroy();
    example = new Choices(priorityField);

    if (statusVal)
        statusVal.destroy();
    statusVal = new Choices(statusField);
}

document.querySelector(".pagination-next").addEventListener("click", function () {
    document.querySelector(".pagination.listjs-pagination") ?
        document.querySelector(".pagination.listjs-pagination").querySelector(".active") ?
        document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click() : "" : "";
});

document.querySelector(".pagination-prev").addEventListener("click", function () {
    document.querySelector(".pagination.listjs-pagination") ?
        document.querySelector(".pagination.listjs-pagination").querySelector(".active") ?
        document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click() : "" : "";
});

function isStatus(val) {
    switch (val) {
        case "2":
            return ('<span class="badge badge-soft-warning text-uppercase"> Pending </span>');
        case "1":
            return ('<span class="badge badge-soft-success text-uppercase"> Approved </span>');
        case "0":
            return ('<span class="badge badge-soft-danger text-uppercase"> Rejected </span>');
    }
}



function fomateDate(date) {
    var dateObj = new Date(date);
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][dateObj.getMonth()];
    return dateObj.getDate() + ' ' + month + ', ' + dateObj.getFullYear();
}

function assignToUsers() {
    var assignedTo = document.querySelectorAll('input[name="assignedTo[]"]:checked');
    var assignedtousers = `<div class="avatar-group">`;

    if (assignedTo.length > 0) {
        assignedTo.forEach(function (ele) {
            assignedtousers += `<a href="javascript: void(0);" class="avatar-group-item" data-img="${ele.value}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Username">
                    <img src="/assets/images/users/${ele.value}" alt="" class="rounded-circle avatar-xxs" />
                </a>`;
        })
    } else {
        assignedtousers += `<a href="javascript: void(0);" class="avatar-group-item" data-img="https://icon-library.com/images/no-user-image-icon/no-user-image-icon-3.jpg" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Title">
                <img src="https://icon-library.com/images/no-user-image-icon/no-user-image-icon-3.jpg" alt="" class="rounded-circle avatar-xxs" />
            </a>`;
    }
    assignedtousers += `</div>`;
    return assignedtousers;
}

function deleteMultiple() {
    ids_array = [];
    var items = document.getElementsByName('chk_child');
    items.forEach(function (ele) {
        if (ele.checked == true) {
            var trNode = ele.parentNode.parentNode.parentNode;
            var id = trNode.querySelector('.id a').innerHTML;
            ids_array.push(id);
        }
    });
    if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
        if (confirm('Are you sure you want to delete this?')) {
            ids_array.forEach(function (id) {
                tasksList.remove("id", `<a href="apps-tasks-details" class="fw-medium link-primary">${id}</a>`);
            });
        } else {
            return false;
        }
        document.getElementById('checkAll').checked = false;
    } else {
        Swal.fire({
            title: 'Please select at least one checkbox',
            confirmButtonClass: 'btn btn-info',
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}