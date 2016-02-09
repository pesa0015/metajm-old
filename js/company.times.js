$('#calendar').fullCalendar({
	height: 500,
	eventAfterRender: function() {
        $('.fc-week').css('height','10px');
    }
});
// var day = document.getElementsByClassName('fc-day');
// console.log(day.length);
// for (var i = 1; i <= day.length; i++) {
// 	day[i].addEventListener('click', function() {
		
// 	});
// }
function firstToUpperCase( str ) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
}
function JsonContainsTime(json, time) {
    for (var i = 0; i < json.length; i++) {
        if (time == json[i].timestamp.substr(11)) {
            // console.log(time);
            return json[i];
        }
    }
    // console.log(0);
    return false;
}
function timeTrue(data) {
    // console.log(data);
    var x = document.getElementById('times');
    var div = document.createElement('div');
    // console.log(data);
    // if (data.first_name == null && data.last_name == null) {
    // if (typeof data.first_name === 'undefined' && typeof data.last_name === 'undefined') {
        // var text = document.createTextNode(data.timestamp.substr(11) + ' - ' + data.first_name + ' ' + data.last_name);
        var text = document.createTextNode(data.timestamp.substr(11));
        // console.log(1);
    // }
    // else
        // var text = document.createTextNode(data.timestamp.substr(11) + ' - ' + data.first_name + ' ' + data.last_name);
    div.appendChild(text);
    div.setAttribute('id', data.id);
    div.setAttribute('class', 'timestamp');
    div.setAttribute('value', data.timestamp.substr(11));
    div.addEventListener('click', getTimeFromCalendar, false);
    div.addEventListener('click', manageTime, false);
    x.appendChild(div);
}
function timeFalse(time) {
    var x = document.getElementById('times');
    var div = document.createElement('div');
    var text = document.createTextNode(time + ' Lägg till');
    div.appendChild(text);
    div.setAttribute('class', 'timestamp');
    div.setAttribute('value', time);
    div.addEventListener('click', getTimeFromCalendar, false);
    div.addEventListener('click', manageTime, false);
    x.appendChild(div);
}
var calendar = document.getElementsByClassName('fc-day-number');
var timeToManage = document.getElementsByClassName('timestamp');
var xhttp = new XMLHttpRequest();

var getTimeFromCalendar = function() {
    var attribute = this.getAttribute('data-date');
    // console.log(attribute);
   //  var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
            var times = [{id: 0, time: '09:00:00'}, {id: 1, time: '09:30:00'}, {id: 2, time: '10:00:00'}, {id: 3, time: '10:30:00'}, {id: 4, time: '11:00:00'}, {id: 5, time: '11:30:00'}, {id: 6, time: '12:00:00'}, {id: 7, time: '12:30:00'}, {id: 8, time: '13:00:00'}, {id: 9, time: '13:30:00'}, {id: 10, time: '14:00:00'}, {id: 11, time: '14:30:00'}, {id: 12, time: '15:00:00'}, {id: 13, time: '15:30:00'}, {id: 14, time: '16:00:00'}, {id: 15, time: '16:30:00'}];
            var x = document.getElementById('times');
            var day = document.createElement('div');
            day.setAttribute('id', 'today');
            day.setAttribute('value', attribute);
            dayText = document.createTextNode(moment(attribute).format('dddd, D MMMM'));
            day.appendChild(dayText);
            day.innerHTML = firstToUpperCase(day.innerHTML);
            x.innerHTML = '';
            x.appendChild(day);
            // console.log(isNaN(xhttp.responseText));
            if (isNaN(xhttp.responseText)) {
                var data = JSON.parse(xhttp.responseText);
                console.log(data);
                for (var i = 0; i < times.length; i++) {
                    // console.log(times.length);
                    // console.log(times[i]);
                    // console.log(i);
                    // for (var x = 0; x < data.length; x++) {
                    //     // console.log(x);
                    //     if (times[i].time == data[x].timestamp.substr(11)) {
                    //         console.log(data[x]);
                    //         // console.log([x]);
                    //         timeTrue(data[x]);
                    //         break;
                    //     }
                    //     // else {
                    //     //     console.log(times[i].time);
                    //         timeFalse(times[i].time);
                    //         break;
                    //     // }
                    // }
                    // console.log(data[i]);
                    // if (typeof data[i] !== 'undefined') {
                    var time = JsonContainsTime(data, times[i].time);
                    // console.log(time);
                    if (time) {
                        timeTrue(time);
                        // console.log(time.timestamp.substr(11));
                    }
                    else {
                        timeFalse(times[i].time);
                    }
                        // if (JsonContainsTime(data, times[i].time)) {
                        //     timeTrue(times[i].time);
                        //     // console.log(data[i]);
                        // }
                        // else {
                        //     timeFalse(times[i].time); 
                        //     console.log(times[i].time);
                        // }
                    // }
                    // else {
                    //     timeFalse(times[i].time);
                    //     // console.log(times[i].time);
                    // }
                    // timeFalse(times[i].time);
                }
                // for (var i = 0; i < data.length; i++) {
                //     var div = document.createElement('div');
                //     if (data[i].first_name !== null && data[i].last_name !== null)
                //         var text = document.createTextNode(data[i].timestamp.substr(11) + ' - ' + data[i].first_name + ' ' + data[i].last_name);
                //     else
                //         var text = document.createTextNode(data[i].timestamp.substr(11));
                //     div.appendChild(text);
                //     div.setAttribute('id', data[i].id);
                //     div.setAttribute('class', 'timestamp');
                //     div.setAttribute('value', data[i].timestamp.substr(11));
                //     div.addEventListener('click', getTimeFromCalendar, false);
                //     div.addEventListener('click', manageTime, false);
                //     x.appendChild(div);
                // }
            }
            else {
                for (var i = 0; i < times.length; i++) {
                    // var div = document.createElement('div');
                    // var text = document.createTextNode(times[i].time + ' Lägg till');
                    // div.appendChild(text);
                    // div.setAttribute('class', 'timestamp');
                    // div.setAttribute('value', times[i].time);
                    // div.addEventListener('click', getTimeFromCalendar, false);
                    // div.addEventListener('click', manageTime, false);
                    // x.appendChild(div);
                    timeFalse(times[i].time);
                }
            }
    	}
    }
    xhttp.open('POST', 'mobile_api/post/search.php', true);
  	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  	xhttp.send('search=timestamp&timestamp=' + attribute);
    var x = document.getElementById('times');
    // for (var i = 0; i <= x.childNodes.length; i++) {
    //     x.removeChild(x.childNodes[i]);
    // }
    // x.innerHTML = '';
};
function removeTime(element, day, timestamp) {
    // console.log(this.id + ' ' + day + ' ' + this.getAttribute('value'));
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            if (xhttp.responseText == 1) {
                element.removeAttribute('id');
                element.innerHTML = timestamp + ' Lägg till';
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/time.remove.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('id=' + element.id + '&timestamp=' + day + ' ' + timestamp);
}
function addTime(element, day, timestamp) {
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            // console.log(xhttp.responseText);
            if (!isNaN(xhttp.responseText)) {
                element.id = xhttp.responseText;
                element.setAttribute('value', timestamp);
                element.innerHTML = timestamp;
            }
        }
    }
    xhttp.open('POST', 'mobile_api/post/time.add.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('timestamp=' + day + ' ' + timestamp);
}
var manageTime = function() {
    var day = document.getElementById('today').getAttribute('value');
    // console.log(this.getAttribute('value'));
    // console.log(this.id + ' ' + day + ' ' + this.getAttribute('value'));
    // xhttp.onreadystatechange = function() {
    //     if (xhttp.readyState == 4 && xhttp.status == 200) {
    //         console.log(xhttp.responseText);
    //     }
    // }
    // xhttp.open('POST', 'mobile_api/post/time.remove.php', true);
    // xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xhttp.send('id=' + this.id + '&timestamp=' + day + ' ' + this.getAttribute('value'));
    if (!this.id > 0) 
        addTime(this, day, this.getAttribute('value'));
    else
        removeTime(this, day, this.getAttribute('value'));
};

for (var i = 0; i < calendar.length; i++) {
    calendar[i].addEventListener('click', getTimeFromCalendar, false);
}
for (var i = 0; i < timeToManage.length; i++) {
    timeToManage[i].addEventListener('click', manageTime, false);
}