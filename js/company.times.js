function firstToUpperCase( str ) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
}
function JsonContainsTime(json, time) {
    for (var i = 0; i < json.length; i++) {
        if (time == json[i].timestamp.substr(11)) {
            return json[i];
        }
    }
    return false;
}
function timeTrue(data) {
    var x = document.getElementById('times');
    var div = document.createElement('div');
    div.innerHTML = data.timestamp.substr(11);
    div.setAttribute('id', data.id);
    div.setAttribute('class', 'timestamp');
    div.setAttribute('value', data.timestamp.substr(11));
    div.addEventListener('click', manageTime, false);
    x.appendChild(div);
}
function timeFalse(time) {
    var x = document.getElementById('times');
    var div = document.createElement('div');
    div.innerHTML = time + ' Lägg till';
    div.setAttribute('class', 'timestamp');
    div.setAttribute('value', time);
    div.addEventListener('click', manageTime, false);
    x.appendChild(div);
}
var calendar = document.getElementsByClassName('fc-day-number');
var timeToManage = document.getElementsByClassName('timestamp');
var xhttp = new XMLHttpRequest();

$('#calendar').fullCalendar({
    height: 550,
    dayClick: function(date, jsEvent, view) {
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var times = [{id: 0, time: '09:00:00'}, {id: 1, time: '09:30:00'}, {id: 2, time: '10:00:00'}, {id: 3, time: '10:30:00'}, {id: 4, time: '11:00:00'}, {id: 5, time: '11:30:00'}, {id: 6, time: '12:00:00'}, {id: 7, time: '12:30:00'}, {id: 8, time: '13:00:00'}, {id: 9, time: '13:30:00'}, {id: 10, time: '14:00:00'}, {id: 11, time: '14:30:00'}, {id: 12, time: '15:00:00'}, {id: 13, time: '15:30:00'}, {id: 14, time: '16:00:00'}, {id: 15, time: '16:30:00'}];
            var x = document.getElementById('times');
            var day = document.getElementById('today');
            var d = moment(date.format()).format('dddd, D MMMM');
            day.setAttribute('value', date.format());
            day.innerHTML = firstToUpperCase(d);
            x.innerHTML = '';
            x.appendChild(day);
            if (isNaN(xhttp.responseText)) {
                var data = JSON.parse(xhttp.responseText);
                for (var i = 0; i < times.length; i++) {
                    var time = JsonContainsTime(data, times[i].time);
                    if (time) {
                        timeTrue(time);
                    }
                    else {
                        timeFalse(times[i].time);
                    }
                }
            }
            else {
                for (var i = 0; i < times.length; i++) {
                    timeFalse(times[i].time);
                }
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/search.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('search=timestamp&timestamp=' + date.format());
    },
    eventAfterRender: function() {
        $('.fc-week').css('height','10px');
    }
});
var removeTime = function() {
    var day = document.getElementById('today').getAttribute('value');
    var value = this.getAttribute('value');
    var html = this.parentNode.previousSibling;
    id = this.previousSibling.id;
    var removeElement = this.parentNode;
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            if (xhttp.responseText == 1) {
                html.innerHTML = value + ' <span class="ion-android-add"></span>';
                html.removeAttribute('id');
                $(removeElement).remove();
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/time.remove.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('id=' + this.id + '&timestamp=' + day + ' ' + this.getAttribute('value'));
}
var removeConfirm = function() {
    this.parentNode.previousSibling.setAttribute('id', this.previousSibling.id);
    $(this).parent().remove();
}
function confirmRemoveTime(element, day, timestamp) {
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
                element.setAttribute('value', timestamp);
                element.innerHTML = timestamp + ' <span class="ion-android-remove"></span>';
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/time.add.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('timestamp=' + day + ' ' + timestamp);
}
var manageTime = function() {
    var day = document.getElementById('today').getAttribute('value');
    id = parseInt(this.id);
    if (isNaN(id)) 
        addTime(this, day, this.getAttribute('value'));
    else {
        var t = confirmRemoveTime(this, day, this.getAttribute('value'));
        t.remove.addEventListener('click', removeTime, false);
        t.cancel.addEventListener('click', removeConfirm, false);
    }
};
for (var i = 0; i < timeToManage.length; i++) {
    timeToManage[i].addEventListener('click', manageTime, false);
}