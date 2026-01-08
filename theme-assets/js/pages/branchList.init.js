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
        "id",
        "branch_id",
        "branch_name",
        "company_name",
        "branch_status",
        "branch_status_change",
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
    
    
    // console.log(this.responseText);
    if(this.responseText){
        
        var json_records = JSON.parse(this.responseText);
    if(json_records){
      json_records.forEach(raw => {
          var enable ='';
          var disable ='';
          var branchStatusChange ='';
          
            if(raw.branch_status == 1){
                enable = "selected";
            }
            else{
                disable = "selected";
            }
            
            branchStatusChange += '<select class="form-control" name="branchStatus" onchange="branchStatusChange(this);" id="'+raw.id+'" required />';
            branchStatusChange += '<option value="1" '+enable+'>Enable</option><option value="0" '+disable+'>Disable</option></select>';
            // console.log(branchStatusChange);
            tasksList.add({
                branch_id: '<a href="apps-tasks-details" class="fw-medium link-primary">' + raw.id + "</a>",
                branch_name: raw.branch_name,
                company_name: raw.company_name,
                branch_status: isStatus(raw.branch_status),
                branch_status_change: branchStatusChange,
                    
            });
            
            
            tasksList.sort('branch_id', { order: "desc" });
            
            refreshCallbacks();
        });
    }
        tasksList.remove("branch_id", `<a href="javascript:void(0);" class="fw-medium link-primary">01</a>`);
    }
}
xhttp.open("POST", "/fetchBranchlist");
xhttp.send();
// console.log(tasksList);

// isCount = new DOMParser().parseFromString(
//     tasksList.items.slice(-1)[0]._values.leave_id,
//     "text/html"
// );
// console.log(isCount);
// var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("branch_id"),
    branch_name = document.getElementById("branch_name"),
    
    // new_nominated_person = document.getElementById("task-description"),
     assignedtoNameField = 'Demo Assign',
    //document.getElementById("assignedtoName-field"),
    taskStartDate = document.getElementById("task-start-date"),
     taskEndDate = document.getElementById("task-end-date"),
    priorityField = document.getElementById("priority-field"),
    statusField = document.getElementById("ticket-status"),
    addBtn = document.getElementById("add-btn"),
    removeBtns = document.getElementsByClassName("delBtn");
    editBtn = document.getElementById("edit-btn"),
  editBtns = document.getElementsByClassName("edit-item-btn");
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
    if (e.relatedTarget.classList.contains("edit-item-btn")) {
    document.getElementById("exampleModalLabel").innerHTML = "Edit Branch";
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
    document.getElementById("add-btn").style.display = "none";
    document.getElementById("company_id_wrap").style.display = "none";
    document.getElementById("edit-btn").style.display = "block";
  } else if (e.relatedTarget.classList.contains("add-btn")) {
    document.getElementById("exampleModalLabel").innerHTML = "Add Branch";
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
    document.getElementById("edit-btn").style.display = "none";
    document.getElementById("add-btn").style.display = "block";
  } else {
    document.getElementById("exampleModalLabel").innerHTML = "List Branches";
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
            // var empGroup = emp_group.value;
            
            var branchName = branch_name.value;
            
            var errFlag = 0;
            
            if(branchName =='' ){
                errFlag = 1;
                $('#err-branch_name-field').css('display','block');
            }
           
            
            if(errFlag == 0){
               var form = $('#form-event')[0];
                var Fdata = new FormData(form);
          
                const xhttp = new XMLHttpRequest();
                xhttp.open("POST", "/branchAddController");
                xhttp.onload = function() {
                    console.log(this.responseText);
                      if(this.responseText == 'success'){
                          var msgIcon = 'success';
                          var msgTitle = 'Branch Added successfully!';
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
                          showCloseButton: false
                        }).then(function (result) {
                            if (result.value) {
                                location.reload();
                            }
                        });
                     
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
 
    editBtns.forEach(function (btn) {
      
    // let EmpyID = btn.closest("tr").children[1].innerText;
    //  btn.setAttribute('href', "employee-edit/"+EmpyID);
     
    btn.addEventListener("click", function (e) {
      e.target.closest("tr").children[0].innerText;
    
 
      itemId = e.target.closest("tr").children[0].innerText;
      var itemValues = tasksList.get({
        branch_id: itemId,
      });

      itemValues.forEach(function (x) {
         
        isid = new DOMParser().parseFromString(x._values.branch_id, "text/html");
      
        var selectedid = isid.body.firstElementChild.innerHTML;
        //  console.log('x selectedid'+itemId);
        if (selectedid == itemId) {
            // console.log('x valyes'+x._values.branch_name);
          idField.value = selectedid;
          branch_name.value = x._values.branch_name;
        
    

       
        }
      });
    });
  });

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
editBtn.addEventListener("click", function (e) {
  document.getElementById("exampleModalLabel").innerHTML = "Edit Branch";
  var editValues = tasksList.get({
    branch_id: idField.value,
  });
   $('.invalid-field').css('display','none');
   
   var branchName = branch_name.value;
            
            var errFlag = 0;
            
            if(branchName =='' ){
                errFlag = 1;
                $('#err-branch_name-field').css('display','block');
            }
    
    
    if(errFlag == 0){ 
        
       var form = $('#form-event')[0];
                var Fdata = new FormData(form);
          
                const xhttp = new XMLHttpRequest();
                xhttp.open("POST", "/branchAddController");
            xhttp.onload = function() {
            
            // console.log(this.responseText);
                
            if(this.responseText == 'success'){
                var msgIcon = 'success';
                var msgTitle = 'Branch updated successfully!';
              }
              else{
                  var msgIcon = 'error';
                  var msgTitle = 'Something went wrong!';
              }
            Swal.fire({
              position: 'center',
              icon: msgIcon,
              title: msgTitle,
              showConfirmButton: true,
              showCloseButton: false
            }).then(function (result) {
                if (result.value) {
                    location.reload();
                }
            });
            }
        
        
          xhttp.send(Fdata);
    }
 
});
function isStatus(val) {
    switch (val) {
        case "1":
            return ('<span class="badge badge-soft-success text-uppercase"> Enabled </span>');
        case "0":
            return ('<span class="badge badge-soft-danger text-uppercase"> Disabled </span>');
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