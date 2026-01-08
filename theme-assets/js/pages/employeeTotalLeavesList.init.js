var leaveFilterField = localStorage.getItem("leaveFilterField");
// console.log('leaveFilterField : ',leaveFilterField);
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
        "total_leave_type",
        "leave_year",
        "leave_month",
        "emp_name",
        "branch_name",
        "company_name",
        "emp_id",
        "total_yearly_leaves",
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
        
        var json_records = JSON.parse(this.responseText);
      json_records.forEach(raw => {
          var empName = '<a href="/employeeView'+raw.emp_id+'">'+raw.emp_name+'</a>';
          
          if(leaveFilterField == 'yearly'){
            tasksList.add({
                leave_year: raw.leave_year,
                total_leave_type: raw.total_leave_type,
                emp_name: empName,
                branch_name: raw.branch_name,
                company_name: raw.company_name,
                total_yearly_leaves: raw.total_yearly_leaves,
            });
          }
          else{
              var leave_month_name = '';
              if(raw.leave_month == '1' || raw.leave_month == '01'){ leave_month_name = 'JAN';}
              if(raw.leave_month == '2' || raw.leave_month == '02'){ leave_month_name = 'FEB';}
              if(raw.leave_month == '3' || raw.leave_month == '03'){ leave_month_name = 'MAR';}
              if(raw.leave_month == '4' || raw.leave_month == '04'){ leave_month_name = 'APR';}
              if(raw.leave_month == '5' || raw.leave_month == '05'){ leave_month_name = 'MAY';}
              if(raw.leave_month == '6' || raw.leave_month == '06'){ leave_month_name = 'JUN';}
              if(raw.leave_month == '7' || raw.leave_month == '07'){ leave_month_name = 'JUL';}
              if(raw.leave_month == '8' || raw.leave_month == '08'){ leave_month_name = 'AUG';}
              if(raw.leave_month == '9' || raw.leave_month == '09'){ leave_month_name = 'SEP';}
              if(raw.leave_month == '10' || raw.leave_month == '10'){ leave_month_name = 'OCT';}
              if(raw.leave_month == '11' || raw.leave_month == '11'){ leave_month_name = 'NOV';}
              if(raw.leave_month == '12' || raw.leave_month == '12'){ leave_month_name = 'DEC';}
              
              tasksList.add({
                leave_year: raw.leave_year,
                total_leave_type: raw.total_leave_type,
                leave_month: leave_month_name,
                emp_name: empName,
                branch_name: raw.branch_name,
                company_name: raw.company_name,
                total_yearly_leaves: raw.total_yearly_leaves,
            });
          }
            tasksList.sort('leave_year', { order: "desc" });
            
            refreshCallbacks();
        });
        tasksList.remove("leave_year", ``);
    }
}
xhttp.open("GET", "/employeeTotalLeaveListController?leaveFilterField="+leaveFilterField);
xhttp.send();
// console.log(tasksList);

// isCount = new DOMParser().parseFromString(
//     tasksList.items.slice(-1)[0]._values.leave_id,
//     "text/html"
// );
// console.log(isCount);
// var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("tasksId"),
    emp_name = document.getElementById("emp_name"),
    // new_nominated_person = document.getElementById("task-description"),
     assignedtoNameField = 'Demo Assign',
    //document.getElementById("assignedtoName-field"),
    taskStartDate = document.getElementById("task-start-date"),
     taskEndDate = document.getElementById("task-end-date"),
    priorityField = document.getElementById("priority-field"),
    statusField = document.getElementById("ticket-status"),
    addBtn = document.getElementById("add-btn"),
    removeBtns = document.getElementsByClassName("delBtn");
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