/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: tasks-kanaban  init js
*/

var tasks_list = [
    document.getElementById("kanbanboard"),
    document.getElementById("unassigned-task"),
    document.getElementById("todo-task"),
    document.getElementById("inprogress-task"),
    document.getElementById("reviews-task"),
    document.getElementById("completed-task"),
    document.getElementById("new-task")
];
const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
    
    var json_records = JSON.parse(this.responseText);
    // console.log('emplist '+json_records.completedTask);
    
    $('#total-todo-task').html(json_records.totalNewTasks);
    $('#total-inprogress-task').html(json_records.totalInprogressTasks);
    $('#total-completed-task').html(json_records.totalCompletedTasks);
    
    if(json_records.totalCompletedTasks > 2){
        $('.ComTaskViewAllBtn').css('display','block');
    }
    
    var htmlcompletedTask = '';
    var htmlinprogressTask = '';
    var htmlnewTask = '';
    if(json_records.completedTask){
    json_records.completedTask.forEach(raw => {
        
        var imgHtml = `<div class="avatar-group rightAlign">`;
        
        raw.task_assignee.forEach(function (task_assi) {
            imgHtml += `<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="`+task_assi.task_assignee_name+`"><div class="rounded-circle avatar-xxs"><i class="ri-user-fill"></i></div></a>`;
        });
        imgHtml += `</div>`;
        
        htmlcompletedTask += '<div class="card tasks-box" id="'+raw.id+'"><div class="card-body">';
        htmlcompletedTask += '<div class="d-flex mb-2"><div class="flex-grow-1"><h6 class="fs-15 mb-0 text-truncate"><a href="employeeTaskDetails/'+raw.id+'" class="text-body">'+raw.title+'</a></h6></div></div>';
        htmlcompletedTask += '<p class="text-muted">'+raw.description+'</p><div class="d-flex align-items-center">'+imgHtml+'</div></div>';
        htmlcompletedTask += '<div class="card-footer border-top-dashed"><div class="d-flex"><div class="flex-grow-1"><span class="text-muted"><i class="ri-time-line align-bottom"></i> '+fomateDate(raw.start)+' - '+fomateDate(raw.end)+'</span></div></div>';
        htmlcompletedTask += '<div class="my-3"><a class="btn btn-soft-info w-100" href="employeeTaskDetails/'+raw.id+'">View</a></div></div></div>'; 
       
    });
    }
    if(json_records.inprogressTask){
    json_records.inprogressTask.forEach(raw => {
        
        var imgHtml = `<div class="avatar-group rightAlign">`;
        
        raw.task_assignee.forEach(function (task_assi) {
            imgHtml += `<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="`+task_assi.task_assignee_name+`"><div class="rounded-circle avatar-xxs"><i class="ri-user-fill"></i></div></a>`;
        });
        imgHtml += `</div>`;
        
        htmlinprogressTask += '<div class="card tasks-box" id="'+raw.id+'"><div class="card-body">';
        htmlinprogressTask += '<div class="d-flex mb-2"><div class="flex-grow-1"><h6 class="fs-15 mb-0 text-truncate"><a href="employeeTaskDetails/'+raw.id+'" class="text-body">'+raw.title+'</a></h6></div></div>';
        htmlinprogressTask += '<p class="text-muted">'+raw.description+'</p><div class="d-flex align-items-center">'+imgHtml+'</div></div>';
        htmlinprogressTask += '<div class="card-footer border-top-dashed"><div class="d-flex"><div class="flex-grow-1"><span class="text-muted"><i class="ri-time-line align-bottom"></i> '+fomateDate(raw.start)+' - '+fomateDate(raw.end)+'</span></div></div>';
        htmlinprogressTask += '<div class="my-3"><a class="btn btn-soft-info w-100" href="employeeTaskDetails/'+raw.id+'">View</a></div></div></div>'; 
       
    });
    }
    if(json_records.newTask){
    json_records.newTask.forEach(raw => {
        
        var imgHtml = `<div class="avatar-group rightAlign">`;
        
        raw.task_assignee.forEach(function (task_assi) {
            imgHtml += `<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="`+task_assi.task_assignee_name+`"><div class="rounded-circle avatar-xxs"><i class="ri-user-fill"></i></div></a>`;
        });
        imgHtml += `</div>`;
        
        htmlnewTask += '<div class="card tasks-box" id="'+raw.id+'"><div class="card-body">';
        htmlnewTask += '<div class="d-flex mb-2"><div class="flex-grow-1"><h6 class="fs-15 mb-0 text-truncate"><a href="employeeTaskDetails/'+raw.id+'" class="text-body">'+raw.title+'</a></h6></div></div>';
        htmlnewTask += '<p class="text-muted">'+raw.description+'</p><div class="d-flex align-items-center">'+imgHtml+'</div></div>';
        htmlnewTask += '<div class="card-footer border-top-dashed"><div class="d-flex"><div class="flex-grow-1"><span class="text-muted"><i class="ri-time-line align-bottom"></i> '+fomateDate(raw.start)+' - '+fomateDate(raw.end)+'</span></div></div>';
        htmlnewTask += '<div class="my-3"><a class="btn btn-soft-info w-100" href="employeeTaskDetails/'+raw.id+'">View</a></div></div></div>'; 
       
    });
    }
    //  console.log(htmlcompletedTask);
    $('#todo-task').html(htmlnewTask);
    $('#inprogress-task').html(htmlinprogressTask);
    $('#completed-task').html(htmlcompletedTask);
}
xhttp.open("GET", "/empTasksListController");
xhttp.send();


function fomateDate(date) {
    var dateObj = new Date(date);
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][dateObj.getMonth()];
    return dateObj.getDate() + '/' + dateObj.getMonth() + '/' + dateObj.getFullYear();
}

if (tasks_list) {
    var myModalEl = document.getElementById('deleteRecordModal');
    if (myModalEl) {
        myModalEl.addEventListener('show.bs.modal', function (event) {
            document.getElementById('delete-record').addEventListener('click', function () {
                event.relatedTarget.closest(".tasks-box").remove();
                document.getElementById('btn-close').click();
            });
        });
        taskCounter();
    }

    function taskCounter() {
        task_lists = document.querySelectorAll("#kanbanboard .task-list");
        if (task_lists) {
            task_lists.forEach(function (element) {
                tasks = element.getElementsByClassName("task");
                tasks.forEach(function (ele) {
                    task_box = ele.getElementsByClassName("task-box");
                    task_counted = task_box.length;
                });
                badge = element.querySelector(".card-title .badge").innerText = "";
                badge = element.querySelector(".card-title .badge").innerText = task_counted;
            });
        }
    }
    var oldcardId;
    var newcardId;
    drake = dragula(tasks_list).on('drag', function (el) {
        el.className = el.className.replace('ex-moved', '');
        oldcardId = $(el).closest('.tasks').attr('id');
    }).on('drop', function (el) {
        
        el.className += ' ex-moved';
        newcardId = $(el).closest('.tasks').attr('id');
        var task_id = $(el).attr('id');
        // get previous vales
        var prevcount_oldcard = $('#total-'+oldcardId).html();
        var prevcount_newcard = $('#total-'+newcardId).html(); 
        
        newcount_oldcard = parseInt(prevcount_oldcard)-1;
        newcount_newcard = parseInt(prevcount_newcard)+1;
        
        // update new vales
        $('#total-'+oldcardId).html(newcount_oldcard);
        $('#total-'+newcardId).html(newcount_newcard);
        // console.log('dragged from '+oldcardId);
        
        if(newcardId == 'completed-task' && newcount_newcard > 2){
            $('.ComTaskViewAllBtn').css('display','block');
        }
        else if(oldcardId == 'completed-task' && newcount_oldcard <= 2){
            $('.ComTaskViewAllBtn').css('display','none');
        }
        
        if(newcardId == 'inprogress-task'){
            var task_status = 2;
        }
        else if(newcardId == 'completed-task'){
            var task_status = 1;
        }
        else{
            var task_status = 3;
        }
       var completedtaskListing = 1;
        // update status in db
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
                                
            var json_records = JSON.parse(this.responseText);
            // console.log('emplist '+json_records);
            
            var htmlcompletedTask = '';
            
            if(json_records){
                json_records.completedTask.forEach(raw => {
                    
                    var imgHtml = `<div class="avatar-group rightAlign">`;
                    
                    raw.task_assignee.forEach(function (task_assi) {
                        imgHtml += `<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="`+task_assi.task_assignee_name+`"><div class="rounded-circle avatar-xxs"><i class="ri-user-fill"></i></div></a>`;
                    });
                    imgHtml += `</div>`;
                    
                    htmlcompletedTask += '<div class="card tasks-box" id="'+raw.id+'"><div class="card-body">';
                    htmlcompletedTask += '<div class="d-flex mb-2"><div class="flex-grow-1"><h6 class="fs-15 mb-0 text-truncate"><a href="employeeTaskDetails/'+raw.id+'" class="text-body">'+raw.title+'</a></h6></div></div>';
                    htmlcompletedTask += '<p class="text-muted">'+raw.description+'</p><div class="d-flex align-items-center">'+imgHtml+'</div></div>';
                    htmlcompletedTask += '<div class="card-footer border-top-dashed"><div class="d-flex"><div class="flex-grow-1"><span class="text-muted"><i class="ri-time-line align-bottom"></i> '+fomateDate(raw.start)+' - '+fomateDate(raw.end)+'</span></div></div>';
                    htmlcompletedTask += '<div class="my-3"><a class="btn btn-soft-info w-100" href="employeeTaskDetails/'+raw.id+'">View</a></div></div></div>'; 
                   
                });
                $('#completed-task').html(htmlcompletedTask);
            }
        }
         xhttp.open("POST", "updateTaskStatus?task_id="+task_id+"&task_status="+task_status+"&completedtaskListing=1");
            xhttp.send();
        
    }).on('over', function (el, container) {
        container.className += ' ex-over';
    }).on('out', function (el, container) {
        container.className = container.className.replace('ex-over', '');
        taskCounter();
    });

    var kanbanboard = document.querySelectorAll('#kanbanboard');
    if (kanbanboard) {
        var scroll = autoScroll([
            document.querySelector("#kanbanboard"),
        ], {
            margin: 20,
            maxSpeed: 100,
            scrollWhenOutside: true,
            autoScroll: function () {
                return this.down && drake.dragging;
            }
        });
    }

    //Create a new kanban board
    var addNewBoard = document.getElementById('addNewBoard');
    if (addNewBoard) {
        document.getElementById("addNewBoard").addEventListener("click", newKanbanbaord);

        function newKanbanbaord() {
            var boardName = document.getElementById("boardName").value;
            var uniqueid = Math.floor(Math.random() * 100);
            var randomid = "remove_item_" + uniqueid;
            var dragullaid = "review_task_" + uniqueid;
            kanbanlisthtml =
                '<div class="tasks-list" id=' +
                randomid +
                ">" +
                '<div class="d-flex mb-3">' +
                '<div class="flex-grow-1">' +
                '<h6 class="fs-14 text-uppercase fw-semibold mb-0">' +
                boardName +
                '</h6>' +
                '</div>' +
                '<div class="flex-shrink-0">' +
                '<div class="dropdown card-header-dropdown">' +
                '<a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                '<span class="fw-medium text-muted fs-12">Priority<i class="mdi mdi-chevron-down ms-1"></i></span>' +
                '</a>' +
                '<div class="dropdown-menu dropdown-menu-end">' +
                '<a class="dropdown-item" href="#">Priority</a>' +
                '<a class="dropdown-item" href="#">Date Added</a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div data-simplebar class="tasks-wrapper px-3 mx-n3">' +
                '<div class="tasks" id="' + dragullaid + '" >' +
                '</div>' +
                '</div>' +
                '<div class="my-3">' +
                '<button class="btn btn-soft-info w-100" data-bs-toggle="modal" data-bs-target="#creatertaskModal">Add More</button>' +
                '</div>' +
                '</div>';

            var subTask = document.getElementById("kanbanboard");
            subTask.insertAdjacentHTML("beforeend", kanbanlisthtml);

            var link = document.getElementById("btn-close");
            link.click();

            drake.destroy();
            tasks_list.push(document.getElementById(dragullaid));
            drake = dragula(tasks_list);
            document.getElementById("boardName").value = "";
        }
    }

    // Add Members 
    var addMember = document.getElementById('addMember');
    if (addMember) {
        document.getElementById("addMember").addEventListener("click", newMemberAdd);

        //set membar profile 
        var profileField = document.getElementById("profileimgInput");
        var reader = new FileReader();
        profileField.addEventListener("change", function (e) {
            reader.readAsDataURL(profileField.files[0]);
            reader.onload = function () {
                var imgurl = reader.result;
                var dataURL = '<img src="' + imgurl + '" alt="profile" class="rounded-circle avatar-xs">';
                localStorage.setItem('kanbanboard-member', dataURL);
            };
        });

        function newMemberAdd() {
            var firstName = document.getElementById("firstnameInput").value;
            var getMemberProfile = localStorage.getItem('kanbanboard-member');

            newMembar = '<a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="' + firstName + '">' + getMemberProfile + '</a>';

            var subMemberAdd = document.getElementById("newMembar");
            subMemberAdd.insertAdjacentHTML("afterbegin", newMembar);

            var link = document.getElementById("btn-close-member");
            link.click();
        }
    }
}