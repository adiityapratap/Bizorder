

var start_date = document.getElementById("task-start-date");
var end_date = document.getElementById("task-end-date");
// var timepicker1 = document.getElementById("timepicker1");
// var timepicker2 = document.getElementById("timepicker2");
var date_range = null;
var T_check = null; 
document.addEventListener("DOMContentLoaded", function () {
    // flatPickrInit();
    var addEvent = new bootstrap.Modal(document.getElementById('event-modal'), {
        keyboard: false
    });
    document.getElementById('event-modal');
    var modalTitle = document.getElementById('modal-title');
    var formEvent = document.getElementById('form-event');
    var selectedEvent = null;
    var forms = document.getElementsByClassName('needs-validation');
    /* initialize the calendar */

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var defaultEvents = '';
    var Draggable = FullCalendar.Draggable;
    var externalEventContainerEl = document.getElementById('external-events');
    const xhttp = new XMLHttpRequest();
                 xhttp.open("GET", "/employeeTaskListController");
                xhttp.onload = function() {
                    // console.log(this.responseText); 
                    var defaultEvents = JSON.parse(this.responseText);
                    // defaultEvents.forEach((value,index) =>{
                    //   delete  value.task_assignee
                    // //   delete  value.task_status
                    
                        
                    // })
                var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'local',
        editable: true,
        droppable: true,
        selectable: true,
        navLinks: true,
        initialView: getInitialView(),
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        windowResize: function (view) {
            var newView = getInitialView();
            calendar.changeView(newView);
        },
        eventClick: function (info) {
            document.getElementById("edit-event-btn").removeAttribute("hidden");
            document.getElementById('btn-save-event').setAttribute("hidden", true);
            document.getElementById("edit-event-btn").setAttribute("data-id", "edit-event");
            document.getElementById("edit-event-btn").innerHTML = "Edit";
            eventClicked();
            // flatPickrInit();
            flatpicekrValueClear();
            addEvent.show();
            formEvent.reset();
            selectedEvent = info.event;

            // First Modal
            document.getElementById("modal-title").innerHTML = "";
            // document.getElementById("event-location-tag").innerHTML = selectedEvent.extendedProps.location === undefined ? "No Location" : selectedEvent.extendedProps.location;
            document.getElementById("event-description-tag").innerHTML = selectedEvent.extendedProps.description === undefined ? "No Description" : selectedEvent.extendedProps.description;

            // Edit Modal
            document.getElementById("event-title").value = selectedEvent.title;
            // document.getElementById("event-location").value = selectedEvent.extendedProps.location === undefined ? "No Location" : selectedEvent.extendedProps.location;
            document.getElementById("event-description").value = selectedEvent.extendedProps.description === undefined ? "No Description" : selectedEvent.extendedProps.description;
            document.getElementById("eventid").value = selectedEvent.id;

            // if (selectedEvent.classNames[0]) {
            //     eventCategoryChoice.destroy();
            //     eventCategoryChoice = new Choices("#event-category", {
            //         searchEnabled: false
            //     });
            //     eventCategoryChoice.setChoiceByValue(selectedEvent.classNames[0]);
            // }
            var st_date = selectedEvent.start;
            var ed_date = selectedEvent.end;
            var date_r = function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();
                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;
                return [year, month, day].join('-');
            };
            var r_date = ed_date == null ? (str_dt(st_date)) : (str_dt(st_date));
            var e_date = ed_date == null ? (str_dt(st_date)) : (str_dt(ed_date));
            var er_date = ed_date == null ? (date_r(st_date)) : (date_r(st_date)) + ' to ' + (date_r(ed_date));

            
            document.getElementById("task-start-date-tag").innerHTML = r_date;
            document.getElementById("task-end-date-tag").innerHTML = e_date;

            modalTitle.innerText = selectedEvent.title;

            // formEvent.classList.add("view-event");
            document.getElementById('btn-delete-event').removeAttribute('hidden');
        },
        dateClick: function (info) {
            addNewEvent(info);
        },
        events: defaultEvents,
        eventReceive: function (info) {
            var newEvent = {
                id: Math.floor(Math.random() * 11000),
                title: info.event.title,
                start: info.event.start,
                allDay: info.event.allDay,
                className: info.event.classNames[0]
            };
            defaultEvents.push(newEvent);
            // upcomingEvent(defaultEvents);
        },
        eventDrop: function (info) {
            var indexOfSelectedEvent = defaultEvents.findIndex(function (x) {
                return x.id == info.event.id
            });
            if (defaultEvents[indexOfSelectedEvent]) {
                defaultEvents[indexOfSelectedEvent].title = info.event.title;
                defaultEvents[indexOfSelectedEvent].start = info.event.start;
                defaultEvents[indexOfSelectedEvent].end = (info.event.end) ? info.event.end : null;
                defaultEvents[indexOfSelectedEvent].allDay = info.event.allDay;
                defaultEvents[indexOfSelectedEvent].className = info.event.classNames[0];
                defaultEvents[indexOfSelectedEvent].description = (info.event._def.extendedProps.description) ? info.event._def.extendedProps.description : '';
                // defaultEvents[indexOfSelectedEvent].location = (info.event._def.extendedProps.location) ? info.event._def.extendedProps.location : '';
            }
            // upcomingEvent(defaultEvents);
        }
    });

    calendar.render();
                        
                }
                xhttp.send();
                    
    // init draggable
    new Draggable(externalEventContainerEl, {
        itemSelector: '.external-event',
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText,
                start: new Date(),
                className: eventEl.getAttribute('data-class')
            };
        }
    });

    var calendarEl = document.getElementById('calendar');

    function addNewEvent(info) {
         console.log('event called');
        
        document.getElementById('form-event').reset();
        document.getElementById('btn-delete-event').setAttribute('hidden', true);
        addEvent.show();
        formEvent.classList.remove("was-validated");
        formEvent.reset();
        selectedEvent = null;
        modalTitle.innerText = 'Add Task';
        newEventData = info;
        document.getElementById("edit-event-btn").setAttribute("data-id", "new-event");
        document.getElementById('edit-event-btn').click();
        document.getElementById("edit-event-btn").setAttribute("hidden", true);
        const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
        if(info){
        var d = new Date(info.dateStr);
        var curr_date = d.getDate();
        var curr_month = monthNames[d.getMonth()];
        var curr_year = d.getFullYear();
        var selectedDate = curr_date+' '+curr_month+', '+curr_year;
        document.getElementById('task-start-date').value = selectedDate;
        }
        
       
        
        
        
        
         var optionhtml = '';
         var optiona = '';
         var i = 0;
        // get asigne list
         const xhttp = new XMLHttpRequest();
                 xhttp.open("GET", "/employeeListController?fetchStatus=1");
                 xhttp.onload = function() {
                    // console.log(this.responseText);
                    
                     var json_records = JSON.parse(this.responseText);
                      
                    json_records.forEach(raw => {
                     optionhtml += '<option value="'+raw.emp_id+'" data-origin-disabled="false">'+raw.first_name+' '+raw.last_name+'</option>';
                     optiona += '<a tabindex="0" class="item" role="button" data-value="'+raw.emp_id+'" multi-index="'+i+'">'+raw.first_name+' '+raw.last_name+'</a>';
                     
                     i++;
                    });
                   
                   $('.non-selected-wrapper').append(optiona);
                   $('#asignee').append(optionhtml);
                }
                xhttp.send();
    }

    function getInitialView() {
        if (window.innerWidth >= 768 && window.innerWidth < 1200) {
            return 'timeGridWeek';
        } else if (window.innerWidth <= 768) {
            return 'listMonth';
        } else {
            return 'dayGridMonth';
        }
    }

    // var eventCategoryChoice = new Choices("#event-category", {
    //     searchEnabled: false
    // });
      console.log("defaultEvents");
  console.log(defaultEvents);
   

    // upcomingEvent(defaultEvents);
    /*Add new event*/
    // Form to add new event
    formEvent.addEventListener('submit', function (ev) {
     
        ev.preventDefault();
       
        var e_id = defaultEvents.length + 1;

        // validation
        if (forms[0].checkValidity() === false) {
            forms[0].classList.add('was-validated');
        } else {
          
            //form submit
            
                  var form = $('#form-event')[0];
                  var Fdata = new FormData(form);
          
                 const xhttp = new XMLHttpRequest();
                 xhttp.open("POST", "/employeeTaskAddController");
                 xhttp.onload = function() {
                    // console.log(this.responseText);
                      if(this.responseText == 'success'){
                          var msgIcon = 'success';
                          var msgTitle = 'New task added successfully!';
                      }
                      else{
                          var msgIcon = 'error';
                          var msgTitle = 'Something went wrong!';
                      }
                        Swal.fire({
                          position: 'center',
                          icon: msgIcon,
                          title: msgTitle,
                          showConfirmButton: false,
                          timer: 2000,
                          showCloseButton: false
                        });
                        location.reload();
                    
                }
                xhttp.send(Fdata);
            addEvent.hide();
        }
    });

    document.getElementById("btn-delete-event").addEventListener("click", function (e) {
        if (selectedEvent) {
            for (var i = 0; i < defaultEvents.length; i++) {
                if (defaultEvents[i].id == selectedEvent.id) {
                    defaultEvents.splice(i, 1);
                    i--;
                }
            }
            // upcomingEvent(defaultEvents);
            selectedEvent.remove();
            selectedEvent = null;
            addEvent.hide();
        }
    });
    document.getElementById("btn-new-event").addEventListener("click", function (e) {
        flatpicekrValueClear();
        // flatPickrInit();
        addNewEvent();
        document.getElementById("edit-event-btn").setAttribute("data-id", "new-event");
        document.getElementById('edit-event-btn').click();
        document.getElementById("edit-event-btn").setAttribute("hidden", true);
    });
});




function flatpicekrValueClear() {
    start_date.flatpickr().clear();
    // timepicker1.flatpickr().clear();
    // timepicker2.flatpickr().clear();
}


function eventClicked() {
    document.getElementById('form-event').classList.add("view-event");
    document.getElementById("event-title").classList.replace("d-block", "d-none");
    // document.getElementById("event-category").classList.replace("d-block", "d-none");
    document.getElementById("task-start-date").parentNode.classList.add("d-none");
    document.getElementById("task-start-date").classList.replace("d-block", "d-none"); 
    document.getElementById("task-end-date").parentNode.classList.add("d-none");
    document.getElementById("task-end-date").classList.replace("d-block", "d-none");
    // document.getElementById('event-time').setAttribute("hidden", true);
    // document.getElementById("timepicker1").parentNode.classList.add("d-none");
    // document.getElementById("timepicker1").classList.replace("d-block", "d-none");
    // document.getElementById("timepicker2").parentNode.classList.add("d-none");
    // document.getElementById("timepicker2").classList.replace("d-block", "d-none");
    // document.getElementById("event-location").classList.replace("d-block", "d-none");
    document.getElementById("event-description").classList.replace("d-block", "d-none");
    document.getElementById("task-start-date-tag").classList.replace("d-none", "d-block");
    document.getElementById("task-end-date-tag").classList.replace("d-none", "d-block");
    // document.getElementById("event-timepicker1-tag").classList.replace("d-none", "d-block");
    // document.getElementById("event-timepicker2-tag").classList.replace("d-none", "d-block");
    // document.getElementById("event-location-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-description-tag").classList.replace("d-none", "d-block");
    document.getElementById('btn-save-event').setAttribute("hidden", true);
}

function editEvent(data) {
    var data_id = data.getAttribute("data-id");
    // var eventDate = $(this).closest('td').attr('data-date');
    var eventDate = $(this).attr('class');
    console.log(data);
    if (data_id == 'new-event') {
        document.getElementById('modal-title').innerHTML = "";
        document.getElementById('modal-title').innerHTML = "Add Task";
        document.getElementById("btn-save-event").innerHTML = "Add Task";
        console.log('add new task');
        eventTyped();
    } else if (data_id == 'edit-event') {
        data.innerHTML = "Cancel";
        data.setAttribute("data-id", 'cancel-event');
        document.getElementById("btn-save-event").innerHTML = "Update Task";
        data.removeAttribute("hidden");
        eventTyped();
    } else {
        data.innerHTML = "Edit";
        data.setAttribute("data-id", 'edit-event');
        eventClicked();
    }
}

function eventTyped() {
    document.getElementById('form-event').classList.remove("view-event");
    document.getElementById("event-title").classList.replace("d-none", "d-block");
    // document.getElementById("event-category").classList.replace("d-none", "d-block");
    document.getElementById("task-start-date").parentNode.classList.remove("d-none");
    document.getElementById("task-start-date").classList.replace("d-none", "d-block");
    document.getElementById("task-end-date").parentNode.classList.remove("d-none");
    document.getElementById("task-end-date").classList.replace("d-none", "d-block");
    // document.getElementById("timepicker1").parentNode.classList.remove("d-none");
    // document.getElementById("timepicker1").classList.replace("d-none", "d-block");
    // document.getElementById("timepicker2").parentNode.classList.remove("d-none");
    // document.getElementById("timepicker2").classList.replace("d-none", "d-block");
    // document.getElementById("event-location").classList.replace("d-none", "d-block");
    document.getElementById("event-description").classList.replace("d-none", "d-block");
    document.getElementById("task-start-date-tag").classList.replace("d-block", "d-none");
    document.getElementById("task-end-date-tag").classList.replace("d-block", "d-none");
    // document.getElementById("event-timepicker1-tag").classList.replace("d-block", "d-none");
    // document.getElementById("event-timepicker2-tag").classList.replace("d-block", "d-none");
    // document.getElementById("event-location-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-description-tag").classList.replace("d-block", "d-none");
    document.getElementById('btn-save-event').removeAttribute("hidden");
}



function getTime(params) {
    params = new Date(params);
    if (params.getHours() != null) {
        var hour = params.getHours();
        var minute = (params.getMinutes()) ? params.getMinutes() : 00;
        return hour + ":" + minute;
    }
}

function tConvert(time) {
    var t = time.split(":");
    var hours = t[0];
    var minutes = t[1];
    var newformat = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return (hours + ':' + minutes + ' ' + newformat);
}

var str_dt = function formatDate(date) {
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var d = new Date(date),
        month = '' + monthNames[(d.getMonth())],
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day + " " + month, year].join(',');
};