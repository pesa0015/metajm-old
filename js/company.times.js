// var hours = Math.abs(future - test) / 36e5;
// var xxx = 1;
// function f() {
//     xxx = 2;
// }
// f();
// console.log(xxx);
function firstToUpperCase( str ) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
}
function JsonContainsTime(json, time) {
    for (var i = 0; i < json.length; i++) {
        // console.log(json[i].start.substring(11,16));
        // console.log(time.substr(11));
        // console.log(json[i].substr(11));
        // console.log(time.substring(11,16));
        // if (time == json[i].timestamp.substr(11)) {
        // if (time.substring(11,16) == json[i].substr(11)) {
        if (json[i].start.substring(11,16) == time.substr(11)) {
            return json[i];
        }
    }
    return false;
}
var timesDiv = document.getElementById('times');
function bookedComplete(value) {
    // JSON.parse(value);
}
function timeTrueNoIcon(time, id) {
    var x = document.getElementById(id).firstChild;
    var divTimes = document.createElement('div');
    // div.innerHTML = data.timestamp.substring(11,16) + ' <span class="ion-android-remove"></span>';
    divTimes.innerHTML = time;
    // div.setAttribute('id', time.id);
    // div.setAttribute('class', 'timestamp minus');
    // div.setAttribute('value', data.timestamp.substr(11));
    // div.setAttribute('value', time);
    // div.addEventListener('click', time, false);
    // div.addEventListener('click', removeBookedTime, false);
    x.appendChild(divTimes);
}
function timeTrue(time) {
    var x = document.getElementById('times');
    var divMain = document.createElement('div');
    var divTimes = document.createElement('div');
    var divTimesInner = document.createElement('div');
    var divCustomer = document.createElement('div');
    var service = document.createElement('span');
    var customer = document.createElement('span');
    // div.innerHTML = data.timestamp.substring(11,16) + ' <span class="ion-android-remove"></span>';
    service.innerHTML = time.name;
    customer.innerHTML = time.first_name + ' ' + time.last_name;
    divTimes.setAttribute('class', 'times');
    divTimesInner.innerHTML = time.start.substring(11,16);
    divCustomer.setAttribute('class', 'customer');
    divMain.setAttribute('id', time.booking_id);
    divMain.setAttribute('class', 'timestamp minus');
    // div.setAttribute('value', data.timestamp.substr(11));
    divMain.setAttribute('value', time.start.substring(11,16));
    // div.addEventListener('click', time, false);
    divMain.addEventListener('click', manageTime, false);
    // div.addEventListener('click', removeBookedTime, false);
    divCustomer.appendChild(service);
    divCustomer.appendChild(customer);
    divTimes.appendChild(divTimesInner);
    divMain.appendChild(divTimes);
    divMain.appendChild(divCustomer);
    x.appendChild(divMain);
    return time.booking_id;
}
function timeFalse(time) {
    var timesDiv = document.getElementById('times');
    var div = document.createElement('div');
    // div.innerHTML = time.substring(11) + ' <span class="ion-ios-plus-outline"></span>';
    div.innerHTML = time + ' <span class="ion-ios-plus-outline"></span>';
    div.setAttribute('class', 'timestamp plus');
    div.setAttribute('value', time);
    div.addEventListener('click', manageTime, false);
    // div.addEventListener('click', bookTime, false);
    timesDiv.appendChild(div);
}
// var day = document.getElementById('today');
// day.innerHTML = '<span class="ion-android-time"></span><div id="middle">' + firstToUpperCase(moment(day.getAttribute('value')).format('dddd, D MMMM')) + '</div>';
var calendar = document.getElementsByClassName('fc-day-number');
var timeToManage = document.getElementsByClassName('timestamp');
function getDay() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    } 

    if (mm < 10) {
        mm = '0' + mm;
    }
    return yyyy + '-' + mm + '-' + dd;
}
function renderOpeningHours(value) {
    var data = JSON.parse(value);
}
function renderTimes(value) {

}
function personNrResult(value) {
    console.log(JSON.parse(value));
}
var xhttp = new XMLHttpRequest();
function sendData(file, data, callback, value) {
    // var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
            // if (parseInt(xhttp.responseText) == 1) {
                callback(value);
            // }
        }
    }
    xhttp.open('POST', 'mobile_api/' + file, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(data);
}
// sendData('post/opening_hours.get.php', 'day=' + getDay(), renderOpeningHours, xhttp.responseText);
// sendData('post/bookings.get.php', 'day=' + getDay(), renderTimes, xhttp.responseText);
function getHoursInterval(day, open, timesBooked) {
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var hours = JSON.parse(xhttp.responseText);
            // console.log(hours);
            while (timesDiv.hasChildNodes()) {
                timesDiv.removeChild(timesDiv.firstChild);
            }
            if (isNaN(timesBooked)) {
                var data = JSON.parse(timesBooked);
                // console.log(data);
                for (var i = 0; i < hours.length; i++) {
                    var time = JsonContainsTime(data, hours[i]);
                    // console.log(time);
                    // if (data[i]) {
                    //     console.log(data[i].start);
                    //     timeTrue(data[i].start);
                    // }
                    // else {
                    //     console.log(hours[i]);
                    //     timeFalse(hours[i]);
                    // }
                    // var time = JsonContainsTime(hours, data[i].start);
                    if (time) {
                        var start = new Date(time.start);
                        var end = new Date(time.end);
                        var hourDiff = Math.abs(start - end) / 36e5;
                        // console.log(hourDiff);
                        var findDiv = timeTrue(time);
                        for (var booked = 1; booked < hourDiff*2; booked++) {
                            i++;
                            // console.log(hours[i].substring(11));
                            // timeTrue(hours[i].substring(11));
                            timeTrueNoIcon(hours[i].substring(11),findDiv);
                        }
                    }
                    else {
                        timeFalse(hours[i].substring(11));
                        // timeFalse(times[i].time);
                    }
                    // // console.log(time);
                }

            
            // if (isNaN(parseInt(xhttp.responseText))) {
            //     var data = JSON.parse(xhttp.responseText);
                // for (var i = 0; i < times.length; i++) {
                //     var time = JsonContainsTime(data, times[i].time);
                //     if (time) {
                //         timeTrue(time);
                //     }
                //     else {
                //         timeFalse(times[i].time);
                //     }
                //     // console.log(time);
                // }
            }
            else {
                for (var i = 0; i < hours.length; i++) {
                    // timeFalse(times[i].time);
                    timeFalse(hours[i].substring(11));
                }
                // timeFalse(JSON.parse(xhttp.responseText));
                // var hours = JSON.parse(open)[0];
                // console.log(hours.start);
                // console.log(hours.close);
                // console.log(hours);
            }
            // console.log(JSON.parse(xhttp.responseText)[0]);
            // console.log(timesBooked);
        }
    }
    xhttp.open('POST', 'mobile_api/post/hours.interval.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('open=' + JSON.parse(open)[0].start + '&close=' + JSON.parse(open)[0].close);
}
function getTimesBooked(day, open) {
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // console.log(xhttp.responseText);
            // console.log(day);
            // console.log(open);
            // console.log(xhttp.responseText);
            getHoursInterval(day, open, xhttp.responseText);
        }
    }
    xhttp.open('POST', 'mobile_api/post/bookings.get.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('day=' + day);
}
function getOpeningHours(day) {
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            console.log(xhttp.responseText);
            if (isNaN(parseInt(xhttp.responseText)))
                getTimesBooked(day, xhttp.responseText);
            else {
                timesDiv.innerHTML = '<h3>Du har stängt den här dagen.</h3>';
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/opening_hours.get.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('day=' + day);
}
getOpeningHours(getDay());
var dateChanged = function(){
    var currentDate = $('#calendar').fullCalendar('getDate');
    $('.fc-toolbar .fc-left h2').text(firstToUpperCase(currentDate.locale('sv').format('ddd D MMM, YYYY')));
}
$('#calendar').fullCalendar({
    lang: 'sv',
    weekNumbers: true,
    weekNumberTitle: 'V.',
    height: 550,
    header: {
        left: 'title',
        right: 'prev,next'
    },
    eventAfterAllRender: dateChanged, 
    dayClick: function(date, jsEvent, view) {
        $('.fc-toolbar .fc-left h2').text(firstToUpperCase(date.locale('sv').format('ddd D MMM, YYYY')));
        getOpeningHours(date.format('YYYY-MM-DD'));
        var day = document.getElementById('today');
        day.setAttribute('value', date.format('YYYY-MM-DD'));
        // console.log(date.format('YYYY-MM-DD'));
        // xhttp.onreadystatechange = function() {
        // if (xhttp.readyState == 4 && xhttp.status == 200) {
        //     var times = [{id: 0, time: '09:00:00'}, {id: 1, time: '09:30:00'}, {id: 2, time: '10:00:00'}, {id: 3, time: '10:30:00'}, {id: 4, time: '11:00:00'}, {id: 5, time: '11:30:00'}, {id: 6, time: '12:00:00'}, {id: 7, time: '12:30:00'}, {id: 8, time: '13:00:00'}, {id: 9, time: '13:30:00'}, {id: 10, time: '14:00:00'}, {id: 11, time: '14:30:00'}, {id: 12, time: '15:00:00'}, {id: 13, time: '15:30:00'}, {id: 14, time: '16:00:00'}, {id: 15, time: '16:30:00'}];
        //     var x = document.getElementById('times');
        //     var day = document.getElementById('today');
        //     // var d = moment(date.format()).format('dddd, D MMMM');
        //     day.setAttribute('value', date.format('YYYY-MM-DD'));
        //     // day.innerHTML = firstToUpperCase(d);
        //     $('.fc-toolbar .fc-left h2').text(firstToUpperCase(date.locale('sv').format('ddd D MMM, YYYY')));
        //     x.innerHTML = '';
        //     x.appendChild(day);
        //     if (isNaN(parseInt(xhttp.responseText))) {
        //         var data = JSON.parse(xhttp.responseText);
        //         for (var i = 0; i < times.length; i++) {
        //             var time = JsonContainsTime(data, times[i].time);
        //             if (time) {
        //                 timeTrue(time);
        //             }
        //             else {
        //                 timeFalse(times[i].time);
        //             }
        //         }
        //     }
        //     else {
        //         for (var i = 0; i < times.length; i++) {
        //             timeFalse(times[i].time);
        //         }
        //     }
        // }
    // }
    // xhttp.open('POST', 'mobile_api/post/search.php', true);
    // xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xhttp.send('search=timestamp&timestamp=' + date.format('YYYY-MM-DD'));
    },
    eventAfterRender: function() {
        // $('.fc-week').css('height','10px');
    }
});
document.getElementsByClassName('fc-content-skeleton')[0].style.marginTop = '0px';
$('.fc-row.fc-week.fc-widget-content').css('height', '76px');
// var arrowLeft = document.createElement('div');
// var arrowRight = document.createElement('div');
// arrowLeft.setAttribute('class', 'ion-android-arrow-dropleft-circle');
// arrowRight.setAttribute('class', 'ion-android-arrow-dropright-circle');
// var fcButtonGroup = document.getElementsByClassName('fc-button-group')[0];
// $('.fc-today-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right.fc-state-disabled').remove();
// $('.fc-icon.fc-icon-left-single-arrow').remove();
// $('.fc-prev-button.fc-button.fc-state-default.fc-corner-left').remove();
// $('.fc-next-button.fc-button.fc-state-default.fc-corner-right').remove();
// $('.fc-icon.fc-icon-right-single-arrow').remove();
// fcButtonGroup.appendChild(arrowLeft);
// fcButtonGroup.appendChild(arrowRight);

document.getElementsByClassName('fc-prev-button fc-button fc-state-default fc-corner-left')[0].className += ' ion-android-arrow-dropleft-circle';
document.getElementsByClassName('fc-next-button fc-button fc-state-default fc-corner-right')[0].className += ' ion-android-arrow-dropright-circle';
// document.getElementsByClassName('fc-button-group')[0].removeAttribute('class');
// var fcButton = document.getElementsByClassName('fc-button-group');
// var fcButton = document.getElementsByClassName('fc-button');
// console.log(fcButton[1].className);
// fcButton[0].className = 'ion-android-arrow-dropleft-circle';
// console.log(fcButton[0]);
// fcButton[1].className = 'ion-android-arrow-dropright-circle';
var removeTime = function() {
    // console.log(this);
    var day = document.getElementById('today').getAttribute('value');
    var value = this.getAttribute('value');
    var html = this.parentNode.previousSibling;
    id = this.previousSibling.id;
    var removeElement = this.parentNode;
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            if (xhttp.responseText == 1) {
                // html.innerHTML = value + ' <span class="ion-ios-plus-outline"></span>';
                // html.removeAttribute('id');
                // html.className = 'timestamp plus';
                // $(removeElement).remove();
                location.reload(true);
            }
        }
    }
    // xhttp.open('POST', 'mobile_api/post/time.remove.php', true);
    xhttp.open('POST', 'mobile_api/post/booking.remove.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xhttp.send('id=' + this.id + '&timestamp=' + day + ' ' + this.getAttribute('value'));
    xhttp.send('id=' + this.id + '&start=' + day + ' ' + this.getAttribute('value'));
}
var removeConfirm = function() {
    // console.log(this);
    this.parentNode.previousSibling.className = 'timestamp minus';
    this.parentNode.previousSibling.setAttribute('id', this.previousSibling.id);
    this.parentNode.previousSibling.innerHTML = this.parentNode.previousSibling.getAttribute('value') + ' <span class="ion-android-remove"></span>';
    $(this).parent().remove();
}
function confirmRemoveTime(element, day, timestamp) {
    // console.log(this);
    var div = document.createElement('div');
    var text = document.createElement('span');
    text.innerHTML = 'Ta bort tid?';
    var yes = document.createElement('span');
    yes.setAttribute('id', element.id);
    yes.setAttribute('class', 'yes');
    yes.setAttribute('value', timestamp);
    var no = document.createElement('span');
    no.setAttribute('id', 'cancel-' + element.id);
    no.setAttribute('class', 'no');
    div.setAttribute('id', 'remove-' + element.id);
    div.setAttribute('class', 'remove');
    element.removeAttribute('id');
    element.className = 'timestamp confirm-remove';
    yes.innerHTML = 'Ja, ta bort <span class="ion-trash-a"></span>';
    no.innerHTML = 'Nej <span class="ion-ios-close"></span>';
    div.appendChild(text);
    div.appendChild(yes);
    div.appendChild(no);
    var el = {div: div, remove: yes, cancel: no};
    element.parentNode.insertBefore(div, element.nextSibling);
    return el;
}
function addTime(element, day, timestamp) {
    var day = document.getElementById('today').getAttribute('value');
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            if (!isNaN(xhttp.responseText)) {
                element.id = xhttp.responseText;
                element.className = 'timestamp minus';
                element.setAttribute('value', timestamp);
                element.innerHTML = timestamp + ' <span class="ion-android-remove"></span>';
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/time.add.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('timestamp=' + day + ' ' + timestamp);
}
// document.getElementById('modal-12').className += ' md-show';
document.getElementById('personnr').addEventListener('input', function() {
    if (this.value.length == 12) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var customer = JSON.parse(xhttp.responseText)[0];
                document.getElementById('customer-information').style.opacity = '1';
                if (isNaN(parseInt(xhttp.responseText))) {
                    document.getElementById('customer_id').value = customer.id;
                    document.getElementById('fname').value = customer.first_name;
                    document.getElementById('lname').value = customer.last_name;
                    document.getElementById('mail').value = customer.mail;
                    document.getElementById('tel').value = customer.tel;
                }
                else {
                    document.getElementById('customer_id').value = 0;
                    document.getElementById('fname').value = '';
                    document.getElementById('lname').value = '';
                    document.getElementById('mail').value = '';
                    document.getElementById('tel').value = '';
                }
                // console.log(xhttp.responseText);
                
            }
        }
        xhttp.open('POST', 'mobile_api/post/search.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('term=' + this.value + '&search=personnr');
    }
        // xhttp.responseText = null;
        // sendData('post/search.php', 'term=' + this.value + '&search=personnr', personNrResult, xhttp.responseText);
    // }
});
function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true && JSON.stringify(obj) === JSON.stringify({});
}
// var booking = {};
// booking.test = 1;
// booking.now = 2;
// for (var k in booking) {
//     if (booking.hasOwnProperty(k)) {
//         console.log(k);
//         delete booking.k;
//     }
// }
// delete booking;
// booking = null;
// console.log(booking);
var timeToBook = null;
var modalDialog = document.getElementById('modal-12');
function book() {
    var booking = {};
        booking.datetime = timeToBook;
        booking.customer_id = document.getElementById('customer_id').value;
        booking.personnr = document.getElementById('personnr').value;
        booking.fname = document.getElementById('fname').value;
        booking.lname = document.getElementById('lname').value;
        booking.mail = document.getElementById('mail').value;
        booking.tel = document.getElementById('tel').value;
        booking.service = parseInt(document.getElementById('select2').value);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                console.log(xhttp.responseText);
                console.log(booking);
                if (isNaN(parseInt(xhttp.responseText))) {
                    var error = JSON.parse(xhttp.responseText);
                    var n = noty({layout:'center',type:'error',text:'Det gick inte att boka kl ' + error.start + '-' + error.end + ' eftersom ' + error.timeBooked[0].start.substring(11,16) + ' är upptaget'});
                }
                else {
                    // location.reload(true);
                    getOpeningHours(timeToBook.substring(0,10));
                    $(modalDialog).removeClass('md-show');
                    var n = noty({layout:'center',type:'success',text:'Bokning genomförd<i class="ion-checkmark-circled" style="margin-left:5px;"></i>'});
                }
            }
        }
        xhttp.open('POST', 'mobile_api/post/bookings.set.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('booking=' + JSON.stringify(booking));
}
function bookTime(timestamp) {
    var date = timestamp.substring(0,10);
    var time = timestamp.substring(11);
    timeToBook = date + ' ' + time;
    modalDialog.className += ' md-show';
    document.getElementById('md-date').innerHTML = date;
    document.getElementById('md-time').innerHTML = time;
    document.getElementById('book').addEventListener('click', book, false);
}
var manageTime = function() {
    // console.log(1);
    var day = document.getElementById('today').getAttribute('value');
    id = parseInt(this.id);
    if (isNaN(id) && this.className !== 'timestamp confirm-remove') { 
        // addTime(this, day, this.getAttribute('value'));
        // console.log(this.getAttribute('value'));
        // bookTime(this, day, this.getAttribute('value'));
        bookTime(document.getElementById('today').value + ' ' + this.getAttribute('value'));
        // console.log(this.getAttribute('value'));
    }
    else {
        if (this.className !== 'timestamp confirm-remove') {
            var t = confirmRemoveTime(this, day, this.getAttribute('value'));
            t.remove.addEventListener('click', removeTime, false);
            t.cancel.addEventListener('click', removeConfirm, false);
        }
    }
};
for (var i = 0; i < timeToManage.length; i++) {
    // timeToManage[i].addEventListener('click', manageTime, false);
    // console.log(timeToManage[i]);
    // timeToManage[i].addEventListener('click', function() {
    //     console.log(this);
    // });
}
$('#select2').select2({
            tags: true,
            maximumSelectionSize: 1,
            ajax: {
                url: 'mobile_api/post/search.php',
                type: 'POST',
                dataType: 'json',
                minimumInputLength: 1,
                data: function (term, search) {
                    return {
                        term: term,
                        search: 'my_services'
                    };
                },
                results: function (data) {
                    var myResults = [];
                    $.each(data, function (index, item) {
                        myResults.push({
                            'id': item.id,
                            'text': item.category_name + ', ' + item.service_name + ' ' + item.price + ':-, ' + item.time + 'hr'
                        });
                    });
                    return {
                        results: myResults
                    };
                }
            }
        });