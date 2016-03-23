function test(value) {
	console.log(value);
}
var xhttp = new XMLHttpRequest();
function sendData(file, data, callback, value) {
	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
    		// console.log(xhttp.responseText);
    		callback(xhttp.responseText);
    		// callback(JSON.parse(xhttp.responseText));
    		if (parseInt(xhttp.responseText) == 1) {
    			callback(value);
    			// callback(JSON.parse(xhttp.responseText));
    			// callback(xhttp.responseText);
    		}
    	}
  	}
	xhttp.open('POST', 'mobile_api/' + file, true);
  	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  	xhttp.send(data);
}
document.getElementById('set-opening-hours').addEventListener('click', function() {
	var isOpen = document.getElementsByClassName('is_open');
	var monday = {};
	monday.start = false;
	if (isOpen[0].checked) {
		monday.start = document.getElementById('start-monday').value;
		monday.end = document.getElementById('end-monday').value;
	}
	var tuesday = {};
	tuesday.start = false;
	if (isOpen[1].checked) {
		tuesday.start = document.getElementById('start-tuesday').value;
		tuesday.end = document.getElementById('end-tuesday').value;
	}
	var wednesday = {};
	wednesday.start = false;
	if (isOpen[2].checked) {
		wednesday.start = document.getElementById('start-wednesday').value;
		wednesday.end = document.getElementById('end-wednesday').value;
	}
	var thursday = {};
	thursday.start = false;
	if (isOpen[3].checked) {
		thursday.start = document.getElementById('start-thursday').value;
		thursday.end = document.getElementById('end-thursday').value;
	}
	var friday = {};
	friday.start = false;
	if (isOpen[4].checked) {
		friday.start = document.getElementById('start-friday').value;
		friday.end = document.getElementById('end-friday').value;
	}
	var saturday = {};
	saturday.start = false;
	if (isOpen[5].checked) {
		saturday.start = document.getElementById('start-saturday').value;
		saturday.end = document.getElementById('end-saturday').value;
	}
	var sunday = {};
	sunday.start = false;
	if (isOpen[6].checked) {
		sunday.start = document.getElementById('start-sunday').value;
		sunday.end = document.getElementById('end-sunday').value;
	}
	// monday = (isOpen[0].checked) ? [{'start':document.getElementById('start-monday').value},{'end':document.getElementById('end-monday').value}] : 0;
	// var tuesday = (isOpen[1].checked) ? [{'start':document.getElementById('start-tuesday').value},{'end':document.getElementById('end-tuesday').value}] : 0;
	// var wednesday = (isOpen[2].checked) ? [{'start':document.getElementById('start-wednesday').value},{'end':document.getElementById('end-wednesday').value}] : 0;
	// var thursday = (isOpen[3].checked) ? [{'start':document.getElementById('start-thursday').value},{'end':document.getElementById('end-thursday').value}] : 0;
	// var friday = (isOpen[4].checked) ? [{'start':document.getElementById('start-friday').value},{'end':document.getElementById('end-friday').value}] : 0;
	// var saturday = (isOpen[5].checked) ? [{'start':document.getElementById('start-saturday').value},{'end':document.getElementById('end-saturday').value}] : 0;
	// var sunday = (isOpen[6].checked) ? [{'start':document.getElementById('start-sunday').value},{'end':document.getElementById('end-sunday').value}] : 0;
	var days = {};
	days.mon = monday;
	days.tue = tuesday;
	days.wed = wednesday;
	days.thu = thursday;
	days.fri = friday;
	days.sat = saturday;
	days.sun = sunday;
	// var days = [{'monday':monday},{'tuesday':tuesday},{'wednesday':wednesday},{'thursday':thursday},{'friday':friday},{'saturday':saturday},{'sunday':sunday}];
	// console.log(days);
	// if (isOpen[0].checked)
	// 	var monday = [{'start':document.getElementById('start-monday').value},{'end':document.getElementById('end-monday').value}];
	
	// console.log(JSON.stringify(monday));
	// sendData('post/opening_hours.set.php', 'monday=' + JSON.stringify(monday), test);
	// sendData('post/opening_hours.set.php', 'monday=' + JSON.stringify(monday), test);
	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
    		if (parseInt(xhttp.responseText) == 1) {
    			var n = noty({
					layout:'center',
					type:'information',
					text: 'noty - a jquery notification library!',
					buttons: [
					    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

					        // this = button element
					        // $noty = $noty element

					        $noty.close();
					        // noty({text: 'You clicked "Ok" button', type: 'success'});
					        sendData('post/opening_hours.change.php', '', test, 'days=' + JSON.stringify(days));
					      }
					    },
					    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
					        $noty.close();
					        // noty({text: 'You clicked "Cancel" button', type: 'error'});
					      }
					    }
					  ]
				});
    		}
    		else
    			sendData('post/opening_hours.set.php', '', test, 'days=' + JSON.stringify(days));
    	}
  	}
	xhttp.open('POST', 'mobile_api/post/opening_hours.check.php', true);
  	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  	xhttp.send('');
	// sendData('post/opening_hours.check.php', '', test, 'days=' + JSON.stringify(days));
	// var x = document.getElementsByClassName('is_open');
	// for (var i = 0; i < x.length; i++) {
	// 	console.log(x[i].checked);
	// }
});