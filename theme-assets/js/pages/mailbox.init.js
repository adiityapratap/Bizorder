
let url = window.location.origin + "/theme-assets/json/";
var allmaillist = '';

//mail list by json
let getJSON = function(jsonurl, callback) {
    $.ajax({
        // url: url + jsonurl,
        url: '/HR/memo/fetchMemoList',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            callback(null, response);
        },
        error: function(xhr, status, error) {
            callback(status, xhr.responseJSON);
        }
    });
};


// load mail data
function loadMailData(datas) {
    var triggerEl = document.querySelector('#mail-filter-navlist button[data-bs-target="#pills-primary"]')
    triggerEl.click()
    document.querySelector("#mail-list").innerHTML = '';

    datas.forEach(function (mailData, index) {

        let checkReaded = '';
        let mailcounted = mailData.counted ? '(' + mailData.counted + ')' : "";
        const message = mailData?.message;
        const strippedMessage = message.replace(/<[^>]*>/g, '');
        document.querySelector("#mail-list").innerHTML +=
           `<li class="${checkReaded}">
    <div class="col-mail col-mail-1">
        <div class="form-check checkbox-wrapper-mail fs-14">
            <input class="form-check-input" type="checkbox" value="${mailData.memo_id}" id="checkbox-${mailData.memo_id}">
            <label class="form-check-label" for="checkbox-${mailData.memo_id}"></label>
        </div>
       
        <a href="javascript:void(0);" class="title">
            <span class="title-name">${mailData?.subject}</span> ${mailcounted}
        </a>
    </div>
    <div class="col-mail col-mail-2">
        <a href="javascript:void(0);" class="subject">
            <span class="teaser">${strippedMessage.substring(0, 80)}...</span>
            <span  class="messageMemoBody d-none">${mailData?.message}</span>
             <span  class="currentMemoId d-none">${mailData?.memo_id}</span>
        </a>
        <div class="date">${formatDate(mailData.date_added)}</div>
    </div>
</li>`;


        
        emailDetailShow();
        emailDetailChange();
        checkBoxAll();
    });
}


// get json
getJSON("mail-list.init.json", function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        allmaillist = data;
        console.log("allmaillist",allmaillist)
        loadMailData(allmaillist);
       
    }
});


// mail list click event
document.querySelectorAll('.mail-list a').forEach(function (mailTab) {
       mailTab.addEventListener("click", function () {
        var chatUserList = document.querySelector(".mail-list a.active");
        if (chatUserList) chatUserList.classList.remove("active");
        mailTab.classList.add('active');

        if (mailTab.querySelector('.mail-list-link').hasAttribute('data-type')) {
            var tabname = mailTab.querySelector('.mail-list-link').innerHTML;
            var filterData = allmaillist.filter(maillist => maillist.labeltype === tabname);
        } else {
            var tabname = mailTab.querySelector('.mail-list-link').innerHTML;
            document.getElementById("mail-list").innerHTML = '';
            if (tabname != 'All') {
                var filterData = allmaillist.filter(maillist => maillist.tabtype === tabname);
            } else {
                
            }
            if (tabname != 'All' && tabname != 'Inbox') {
                document.getElementById("mail-filter-navlist").style.display = "none";
            } else {
                document.getElementById("mail-filter-navlist").style.display = "block";
            }
        }
        loadMailData(filterData);
       
    });
})



// emailDetailShow
function emailDetailShow() {
    var bodyElement = document.getElementsByTagName('body')[0];
    document.querySelectorAll(".message-list a").forEach(function (item) {
        item.addEventListener("click", function (event) {
            bodyElement.classList.add("email-detail-show");
            document.querySelectorAll(".message-list li.unread").forEach(function (element) {
                if (element.classList.contains("unread")) {
                    event.target.closest('li').classList.remove("unread");
                }
            });
        });
    });

    document.querySelectorAll(".close-btn-email").forEach(function (item) {
        item.addEventListener("click", function () {
            bodyElement.classList.remove("email-detail-show");
        });
    });

   let isShowMenu = false;
let emailMenuSidebar = [...document.getElementsByClassName('email-menu-sidebar')];

document.querySelectorAll(".email-menu-btn").forEach(function (item) {
    item.addEventListener("click", function () {
        // Loop through each element in the array
        emailMenuSidebar.forEach(function (elm) {
            elm.classList.add("menubar-show");
            isShowMenu = true;
        });
    });
});


    window.addEventListener('click', function (e) {
        if (document.querySelector(".email-menu-sidebar").classList.contains('menubar-show')) {
            if (!isShowMenu) {
                document.querySelector(".email-menu-sidebar").classList.remove("menubar-show");
            }
            isShowMenu = false;
        }
    });
    
}



// check all
function checkBoxAll() {
    // checkbox-wrapper-mail
    document.querySelectorAll(".checkbox-wrapper-mail input").forEach(function (element) {
        element.addEventListener('click', function (el) {
            if (el.target.checked == true) {
                el.target.closest('li').classList.add("active");
            } else {
                el.target.closest('li').classList.remove("active");
            }
        });
    });

    // checkbox
    var checkboxes = document.querySelectorAll('.checkbox-wrapper-mail input');
    checkboxes.forEach(function (element) {
        element.addEventListener('click', function (event) {
            var checkboxes = document.querySelectorAll('.checkbox-wrapper-mail input');
            var checkall = document.getElementById('checkall');
            var checkedCount = document.querySelectorAll('.checkbox-wrapper-mail input:checked').length;
            checkall.checked = checkedCount > 0;
            checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;

            if (event.target.closest('li').classList.contains("active")) {
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            } else {
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            }
        });
    });

    document.getElementById("email-topbar-actions").style.display = 'none';

    // checkbox all
    checkall.addEventListener('click', function (event) {
        var checkboxes = document.querySelectorAll('.checkbox-wrapper-mail input');
        checkboxes.forEach(function (chkbox) {
            chkbox.checked = true;
            var checkedCount = document.querySelectorAll('.checkbox-wrapper-mail input:checked').length;
            event.checked = checkedCount > 0;
            event.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            if (chkbox.checked = true) {
                chkbox.parentNode.parentNode.parentNode.classList.add("active");
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            } else {
                chkbox.parentNode.parentNode.parentNode.classList.remove("active");
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            }
        });
        removeItems();
    });
}



// removeItems
function removeItems() {
    var removeItem = document.getElementById('removeItemModal');
    removeItem.addEventListener('show.bs.modal', function (event) {
        document.getElementById("delete-record").addEventListener("click", function () {
            document.querySelectorAll(".message-list li").forEach(function (element) {
                var filtered = '';
                if (element.classList.contains("active")) {

                    var getid = element.querySelector('.form-check-input').value;

                    function arrayRemove(arr, value) {
                        return arr.filter(function (ele) {
                            return ele.memo_id != value;
                        });
                    }

                    var filtered = arrayRemove(allmaillist, getid);

                    allmaillist = filtered;

                    element.remove();
                }
            });
            document.getElementById("btn-close").click();
            if (document.getElementById("email-topbar-actions"))
                document.getElementById("email-topbar-actions").style.display = 'none';
            checkall.indeterminate = false;
            checkall.checked = false;
        });
    })
}
removeItems();

document.getElementById("unreadConversations").style.display = "none";



var dummyUserImage = "/assets/images/users/user-dummy-img.jpg";

// email chat detail element
var mailChatDetailElm = false;
document.querySelectorAll(".email-chat-list a").forEach(function (item) {
    item.addEventListener("click", function (event) {
        document.getElementById("emailchat-detailElem").style.display = "block";
        mailChatDetailElm = true;

        // chat user list link active
        var chatUserList = document.querySelector(".email-chat-list a.active");
        if (chatUserList) chatUserList.classList.remove("active");
        this.classList.add("active");

        var currentChatId = "users-chat";
        scrollToBottom(currentChatId);

        //user Name and user Profile change on click
        var username = item.querySelector(".chatlist-user-name").innerHTML;
        var userProfile = item.querySelector(".chatlist-user-image img").getAttribute("src");

        document.querySelector(".email-chat-detail .profile-username").innerHTML = username;
        var conversationImg = document.getElementById("users-conversation");
        conversationImg.querySelectorAll(".left .chat-avatar").forEach(function (item) {
            if (userProfile) {
                item.querySelector("img").setAttribute("src", userProfile);
            } else {
                item.querySelector("img").setAttribute("src", dummyUserImage);
            }
        });
    });
});



// emailDetailChange
function emailDetailChange() {
    document.querySelectorAll(".message-list li").forEach(function (item) {
        item.addEventListener("click", function () {
            let subjectTitle = item.querySelector(".title-name").innerHTML;
            let memoId = item.querySelector(".currentMemoId").innerHTML;
            document.querySelector(".email-subject-title").innerHTML = subjectTitle;
            document.querySelector(".selectedMemo").value = memoId;
            
             let memoBody = item.querySelector(".messageMemoBody").innerHTML;
             document.querySelector(".memoBody").innerHTML = memoBody;

            var emailTitleLeftName = item.querySelector(".title-name").innerHTML;
            document.querySelectorAll(".accordion-item.left").forEach(function (subitem) {
                subitem.querySelector(".email-user-name").innerHTML = emailTitleLeftName;
                
            });

           
           
           
        });
    });
}

function formatDate(dateToFormat){
           
        const dateObject = new Date(dateToFormat);
        const day = dateObject.getDate().toString().padStart(2, '0');
        const month = (dateObject.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 to month since it's zero-based
        const year = dateObject.getFullYear();
        // Format the date
        const formattedDate = `${day}-${month}-${year}`;
        return formattedDate;
        } 