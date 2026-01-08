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
    "emp_id",
    "first_name",
    "company_name",
    "company_size",
    "email",
    "phone",
    "role",
    "empType",
    "empDepartment",
    "effectiveStartDate",
    "vaccinated",
    "emailView",
    "status",
  ],
  page: perPage,
  pagination: true,
  plugins: [
    ListPagination({
      left: 2,
      right: 2
    })
  ]
};
// Init list
var employeeList = new List("employeeList", options).on("updated", function (list) {
    // console.log(list);
  list.matchingItems.length == 0 ?
    (document.getElementsByClassName("noresult")[0].style.display = "block") :
    (document.getElementsByClassName("noresult")[0].style.display = "none");
  var isFirst = list.i == 1;
  var isLast = list.i > list.matchingItems.length - list.page;
  // make the Prev and Nex buttons disabled on first and last pages accordingly
  (document.querySelector(".pagination-prev.disabled")) ? document.querySelector(".pagination-prev.disabled").classList.remove("disabled"): '';
  (document.querySelector(".pagination-next.disabled")) ? document.querySelector(".pagination-next.disabled").classList.remove("disabled"): '';
  if (isFirst) {
    document.querySelector(".pagination-prev").classList.add("disabled");
  }
  if (isLast) {
    document.querySelector(".pagination-next").classList.add("disabled");
  }
  if (list.matchingItems.length <= perPage) {
    document.querySelector(".pagination-wrap").style.display = "none";
  } else {
    document.querySelector(".pagination-wrap").style.display = "flex";
  }

  if (list.matchingItems.length == perPage) {
    document.querySelector(".pagination.listjs-pagination").firstElementChild.children[0].click()
  }

  if (list.matchingItems.length > 0) {
    document.getElementsByClassName("noresult")[0].style.display = "none";
  } else {
    document.getElementsByClassName("noresult")[0].style.display = "block";
  }
});
var fetchStatus = 1;
const xhttp = new XMLHttpRequest();
xhttp.onload = function () {
  var json_records = JSON.parse(this.responseText);
  console.log(json_records);
  json_records.forEach(raw => {
     if(raw.effective_start_date != '' && raw.effective_start_date != null){ var effective_start_date = fomateDate(raw.effective_start_date); }else{ var effective_start_date = ''; }
    //  console.log(st);
   employeeList.add({
      emp_id: '<a href="javascript:void(0);" class="fw-medium link-primary">'+raw.user_id+"</a>",
      company_name: raw.company_name,
      first_name: raw.user_name,
      company_size: raw.company_size,
      email: raw.user_email,
      phone: raw.phone,
      status: isStatus(raw.user_status),
    });
    employeeList.sort('emp_id', { order: "desc" });
    refreshCallbacks();
  });
  employeeList.remove("emp_id", '<a href="javascript:void(0);" class="fw-medium link-primary">01</a>');
}
xhttp.open("GET", "userListController?role=2");
xhttp.send();


isCount = new DOMParser().parseFromString(
  employeeList.items.slice(-1)[0]._values.emp_id,
  "text/html"
);


var isValue = isCount.body.firstElementChild.innerHTML;

var idField = document.getElementById("id-field"),
  employeeFirstNameField = document.getElementById("firstname-field"),
  emailField = document.getElementById("email-field"),
  phoneField = document.getElementById("phone-field"),
  companyNameField = document.getElementById("company-field"),
  companySizeField = document.getElementById("companySize-field"),
  addBtn = document.getElementById("add-btn"),
  editBtn = document.getElementById("edit-btn"),
  removeBtns = document.getElementsByClassName("remove-item-btn"),
  editBtns = document.getElementsByClassName("edit-item-btn");
   viewBtns = document.getElementsByClassName("view-item-btn");
refreshCallbacks();

function filterContact(isValue) {
  var values_status = isValue;
  employeeList.filter(function (data) {
    var statusFilter = false;
    matchData = new DOMParser().parseFromString(
      data.values().status,
      "text/html"
    );
    var status = matchData.body.firstElementChild.innerHTML;
    if (status == "All" || values_status == "All") {
      statusFilter = true;
    } else {
      statusFilter = status == values_status;
    }
    return statusFilter;
  });

  employeeList.update();
}

function updateList() {
  var values_status = document.querySelector("input[name=status]:checked").value;

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
    document.getElementById("exampleModalLabel").innerHTML = "Edit Company Information";
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
    document.getElementById("add-btn").style.display = "none";
    document.getElementById("edit-btn").style.display = "block";
  } else if (e.relatedTarget.classList.contains("add-btn")) {
    document.getElementById("exampleModalLabel").innerHTML = "Add Comapny";
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
    document.getElementById("edit-btn").style.display = "none";
    document.getElementById("add-btn").style.display = "block";
  } else {
    document.getElementById("exampleModalLabel").innerHTML = "List Company";
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
  }
});
ischeckboxcheck();

document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
  clearFields();
});

document.querySelector("#employeeList").addEventListener("click", function () {
  refreshCallbacks();
  ischeckboxcheck();
});

var table = document.getElementById("employeeTable");
// save all tr
var tr = table.getElementsByTagName("tr");
var trlist = table.querySelectorAll(".list tr");

function SearchData() {

  var isstatus = document.getElementById("idStatus").value;
//   var pickerVal = document.getElementById("datepicker-range").value;

//   var date1 = pickerVal.split(" to ")[0];
//   var date2 = pickerVal.split(" to ")[1];

  employeeList.filter(function (data) {
    matchData = new DOMParser().parseFromString(data.values().status, 'text/html');
    var status = matchData.body.firstElementChild.innerHTML;
    var statusFilter = false;
    var dateFilter = false;

    if (status == 'all' || isstatus == 'all') {
      statusFilter = true;
    } else {
      statusFilter = status == isstatus;
    }

    // if (new Date(data.values().date.slice(0, 12)) >= new Date(date1) && new Date(data.values().date.slice(0, 12)) <= new Date(date2)) {
    //   dateFilter = true;
    // } else {
    //   dateFilter = false;
    // }

    if (statusFilter && dateFilter) {
      return statusFilter && dateFilter
    } else if (statusFilter) {
      return statusFilter
    } 
  });
  employeeList.update();
}


var count = 11;
addBtn.addEventListener("click", function (e) {
    $('.invalid-field').css('display','none');
    var first_name = employeeFirstNameField.value;
    var company_name = companyNameField.value;
    var company_size = companySizeField.value;
    var email = emailField.value;
    var errFlag = 0;
    
    if(first_name =='' ){
        errFlag = 1;
        $('#err-firstname-field').css('display','block');
    }
    
    if(company_name =='' ){
        errFlag = 1;
        $('#err-company-field').css('display','block');
    }if(company_size =='' ){
        errFlag = 1;
        $('#err-company_size-field').css('display','block');
    }if(email =='' ){
        errFlag = 1;
        $('#err-email-field').css('display','block');
    }
    
    
    if(errFlag == 0){ 
        
        var form = $('#employeeForm')[0];
        var Fdata = new FormData(form);
                
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "/userSubmitController");
            xhttp.onload = function() {
            
            // console.log(this.responseText);
                
            if(this.responseText == 'success'){
                var msgIcon = 'success';
                var msgTitle = 'Company added successfully!';
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

editBtn.addEventListener("click", function (e) {
  document.getElementById("exampleModalLabel").innerHTML = "Edit Company Information";
  var editValues = employeeList.get({
    emp_id: idField.value,
  });
   $('.invalid-field').css('display','none');
    var first_name = employeeFirstNameField.value;
     var company_name = companyNameField.value;
     var company_size = companySizeField.value;
    var email = emailField.value;
    var phone = phoneField.value;
    var errFlag = 0;
    
    if(first_name =='' ){
        errFlag = 1;
        $('#err-firstname-field').css('display','block');
    }
    
    if(company_name =='' ){
        errFlag = 1;
        $('#err-company-field').css('display','block');
    }if(company_size =='' ){
        errFlag = 1;
        $('#err-company_size-field').css('display','block');
    }
    if(email =='' ){
        errFlag = 1;
        $('#err-email-field').css('display','block');
    }
    
    
    if(errFlag == 0){ 
        
        var form = $('#employeeForm')[0];
        var Fdata = new FormData(form);
                
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "/userSubmitController");
            xhttp.onload = function() {
            
            // console.log(this.responseText);
                
            if(this.responseText == 'success'){
                var msgIcon = 'success';
                var msgTitle = 'Record updated successfully!';
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

// var statusVal = new Choices(statusField);

function isStatus(val) {
      var status = '';
   if(val == 1){
        status = '<span class="badge badge-soft-success text-uppercase">Active</span>';
   }else{
        status = '<span class="badge badge-soft-warning text-uppercase">Inactive</span>';
   }
   return status;
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
      var itemValues = employeeList.get({
        emp_id: itemId,
      });
        var msgIcon='';
        var msgTitle='';
      itemValues.forEach(function (x) {
        deleteid = new DOMParser().parseFromString(x._values.emp_id, "text/html");

        var isElem = deleteid.body.firstElementChild;
        var isdeleteid = deleteid.body.firstElementChild.innerHTML;

        if (isdeleteid == itemId) {
          document.getElementById("delete-record").addEventListener("click", function () {
              
              const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    console.log(this.responseText);
                    
                      if(this.responseText == 'success'){
                          var msgIcon = 'success';
                          var msgTitle = 'Company deleted successfully!';
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
                
                  var emp_id = isdeleteid;
                  
                 
                  xhttp.open("GET", "userDeleteController?user_id="+emp_id+"&user_status=0&user_role=2");
                  xhttp.send(); 
              
            // employeeList.remove("id", isElem.outerHTML);
            document.getElementById("deleteRecordModal").click();
          });
        }
        // Swal.fire({
        //   position: 'center',
        //   icon: msgIcon,
        //   title: msgTitle,
        //   showConfirmButton: false,
        //   timer: 2000,
        //   showCloseButton: false
        // });
                    // location.reload();
      });
    });
  });
  
//   viewBtns.forEach(function (btn) {
    // console.log(btn);

// let EmpyID = btn.closest("tr").children[1].innerText;
// btn.setAttribute('href', "employeeView/"+EmpyID);


//   });

//  editBtns.forEach(function (btn) {
    // console.log(btn);

// let EmpyID = btn.closest("tr").children[1].innerText;
// btn.setAttribute('href', "employeeEdit/"+EmpyID);


//   });
  editBtns.forEach(function (btn) {
      
    // let EmpyID = btn.closest("tr").children[1].innerText;
    //  btn.setAttribute('href', "employee-edit/"+EmpyID);
     
    btn.addEventListener("click", function (e) {
      e.target.closest("tr").children[1].innerText;
    
 
      itemId = e.target.closest("tr").children[1].innerText;
      var itemValues = employeeList.get({
        emp_id: itemId,
      });

      itemValues.forEach(function (x) {
         
        isid = new DOMParser().parseFromString(x._values.emp_id, "text/html");
      console.log('x valyes'+x._values.email);
        var selectedid = isid.body.firstElementChild.innerHTML;
        if (selectedid == itemId) {
           
          idField.value = selectedid;
          employeeFirstNameField.value = x._values.first_name;
          companyNameField.value = x._values.company_name;
          companySizeField.value = x._values.company_size;
          emailField.value = x._values.email;
          phoneField.value = x._values.phone;
         let redirectPage = () => {
        const url = "employee-edit";
        window.location.href = url;
    }
                //  const xhttp = new XMLHttpRequest();
                //   xhttp.open("GET", "employee-edit?emp_id="+selectedid);
                //   xhttp.send(); 

       
        }
      });
    });
  });
}

function clearFields() {
  employeeFirstNameField.value = "";
  emailField.value = "";
  phoneField.value = "";
}
function fomateDate(date) {
    var dateObj = new Date(date);
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][dateObj.getMonth()];
    return dateObj.getDate() + ' ' + month + ', ' + dateObj.getFullYear();
}
function deleteMultiple() {
    console.log('del multiple');
  ids_array = [];
  var items = document.getElementsByName('chk_child');
  items.forEach(function (ele) {
    if (ele.checked == true) {
      var trNode = ele.parentNode.parentNode.parentNode;
      var emp_id = trNode.querySelector('.emp_id a').innerHTML;
      ids_array.push(emp_id);
    }
  });
  console.log('array emps'+ids_array);
  
  if (typeof ids_array !== 'undefined' && ids_array.length > 0) {
     
    
    $('#deleteRecordModal').modal('show');
       document.getElementById("delete-record").addEventListener("click", function () {
              
              const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    console.log(this.responseText);
                    
                      if(this.responseText != 0 && this.responseText >= 1){
                          var msgIcon = 'success';
                          var msgTitle = this.responseText+' record(s) deleted successfully!';
                      }else{
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
                
                //   var emp_id = isdeleteid;
                  
                 
                  xhttp.open("POST", "userMultipleDeleteController?user_id="+ids_array+"&user_status=0"+"&user_role=2");
                  xhttp.send(); 
              
            // employeeList.remove("id", isElem.outerHTML);
            
          });
      
      
  }else{
      Swal.fire({
          position: 'center',
          icon: 'warning',
          title: 'Please select atleast one Company',
          showConfirmButton: true,
        //   timer: 2000,
          showCloseButton: false
        });
  } 
      
}

document.querySelector(".pagination-next").addEventListener("click", function () {
  (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
  document.querySelector(".pagination.listjs-pagination").querySelector(".active").nextElementSibling.children[0].click(): '': '';
});
document.querySelector(".pagination-prev").addEventListener("click", function () {
  (document.querySelector(".pagination.listjs-pagination")) ? (document.querySelector(".pagination.listjs-pagination").querySelector(".active")) ?
  document.querySelector(".pagination.listjs-pagination").querySelector(".active").previousSibling.children[0].click(): '': '';
});