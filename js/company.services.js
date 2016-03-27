		function addSelect2(category) {
	  		$(category).select2({
	  			width: 'resolve',
	  			containerCssClass: 'tpx-select2-container',
  				dropdownCssClass: 'tpx-select2-drop',
		  		tags: true,
		  		maximumSelectionSize: 1,
		  		tokenSeparators: [","],
			    ajax: {
			       	url: 'mobile_api/post/search.php',
			       	type: 'POST',
			       	dataType: 'json',
			       	minimumInputLength: 1,
			       	data: function (term, search) {
			           	return {
			             	term: term,
			             	search: 'category'
			           	};
			       	},
			       	results: function (data) {
       					var myResults = [];
			            if (data) {
				            $.each(data, function (index, item) {
				            	if (isNaN(item.id)) {
				            		myResults.push({
					                    'id': item.id,
					                    'text': item.name + ' (Ny)'
					                });
				            	}
				            	else {
					                myResults.push({
					                    'id': item.id,
					                    'text': item.name
					                });
				                }
				            });
				            return {
				                results: myResults
				            };
			        	}
			        }
			    }
			});
	  	}
	  	var newService = document.getElementById('add-new-service');
	  	var showServiceTable = document.getElementById('show-service-table');
	  	var serviceTable = document.getElementById('new-services');
	  	var existingServices = document.getElementsByClassName('existing-service category');
	  	var existingServicesTime = document.getElementsByClassName('existing-service time');
	  	var rowNr = 0;
		var updateButton = document.getElementById('update-services');
		newService.addEventListener('click', function() {
			if (updateButton.style.display == 'none')
				updateButton.style.display = 'inline-block';
			var row = serviceTable.insertRow(rowNr);
			var category = row.insertCell(0).innerHTML = '<input type="text" id="category-' + rowNr + '" class="new-service category" name="new_service[][\'category\']">';
			var description = row.insertCell(1).innerHTML = '<input type="text" id="description-' + rowNr + '" class="new-service description form-control" name="new_service[][\'description\']">';
			var price = row.insertCell(2).innerHTML = '<input type="text" id="price-' + rowNr + '" class="new-service price form-control" name="new_service[][\'price\']">';
			var time = row.insertCell(3).innerHTML = '<select id="time-' + rowNr + '" class="new-service time form-control" name="new_service[][\'time\']"><option value="0" selected>Välj tid</option><option value="1">1</option><option value="1.5">1,5</option><option value="2">2</option><option value="2.5">2,5</option><option value="3">3</option></select>';
			addSelect2($('#category-' + rowNr));
			rowNr++;
		});
function addUseIcon(value) {
	var checkIcon = value.previousSibling;
	var removeIcon = value;
	var tableCell = value.parentNode;
	$(checkIcon).remove();
	$(removeIcon).remove();
	var el = $('<span class="use-service" data-id="' + value.getAttribute('data-id') + '">Använd</span>');
	$(tableCell).append(el);
	el[0].addEventListener('click', function() {
		sendData('post/use_service.php', 'service_id=' + this.getAttribute('data-id'), addRemoveIcon, this);
	});
}
function addRemoveIcon(value) {
	var serviceId = value.getAttribute('data-id');
	var tableCell = value.parentNode;
	$(value).remove();
	var check = $('<i class="ion-checkmark-round"></i>');
	var close = $('<i class="ion-ios-close-empty service" data-id="' + value.getAttribute('data-id') + '"></i>');
	$(tableCell).append(check);
	$(tableCell).append(close);
	close[0].addEventListener('click', function() {
		sendData('post/dont_use_service.php', 'service_id=' + this.getAttribute('data-id'), addUseIcon, this);
	});
}
function newServiceAdded() {
	location.reload(true);
}
var xhttp = new XMLHttpRequest();
function sendData(file, data, callback, value, xhttpAsCallback = false) {
	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
    		console.log(xhttp.responseText);
    		var result = JSON.parse(xhttp.responseText);
    		if (parseInt(result[0]) == 1) {
    			if (xhttpAsCallback)
    				callback(result[1]);
    			else
    				callback(value);
    		}
    	}
  	}
	xhttp.open('POST', 'mobile_api/' + file, true);
  	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  	xhttp.send(data);
}
updateButton.addEventListener('click', function() {
	var categoryArray = new Array();
	var descriptionArray = new Array();
	var priceArray = new Array();
	var timeArray = new Array();
	var categoriesInput = document.getElementsByName('new_service[][\'category\']');
	var descriptionInput = document.getElementsByName('new_service[][\'description\']');
	var priceInput = document.getElementsByName('new_service[][\'price\']');
	var timeInput = document.getElementsByName('new_service[][\'time\']');
	var start = parseInt(rowNr-categoriesInput.length);
	var array = [];
	var currentService = {};
	if (categoriesInput.length > 0) {
		for (var i = 0; i < categoriesInput.length; i++) {
			// if (parseInt(categoriesInput[i].value) > 0 || categoriesInput[i].value !== '' && descriptionInput[i].value !== '' && priceInput[i].value !== '' && parseInt(timeInput[i]).value >= 1 && parseInt(timeInput[i]).value <= 3) {
				var services = {};
				services.category = categoriesInput[i].value;
				services.description = descriptionInput[i].value;
				services.price = priceInput[i].value;
				services.time = timeInput[i].value;
				array.push(services);
			// }
		}
		sendData('post/service.add.php', 'services=' + JSON.stringify(array), newServiceAdded);
	}
	else {
		// console.log(0);
	}
});
function useServiceChecked(checkbox) {
	var n = noty({theme:'relax',layout:'topCenter',type:'alert',text:'Tjänsten har lagts till din lista'});
}
function dontUseServiceChecked(checkbox) {
	var n = noty({theme:'relax',layout:'topCenter',type:'information',text:'Tjänsten har <span class="bold">tagits bort</span> från din lista'});
}
var servicesCheckbox = document.getElementsByClassName('service-checkbox');
for (var i = 0; i < servicesCheckbox.length; i++) {
	servicesCheckbox[i].addEventListener('click', function() {
		if (this.checked)
			sendData('post/service.use.php', 'service_id=' + this.getAttribute('data-id'), useServiceChecked, this);
		else
			sendData('post/service.use_not.php', 'service_id=' + this.getAttribute('data-id'), dontUseServiceChecked, this);
	});
}
function showEditServiceInput(icon) {
	var serviceId = icon.getAttribute('data-service');
	var editServiceInput = document.getElementsByClassName('edit-service-' + serviceId);
	$('.service-' + serviceId).hide();
	$(editServiceInput).show();
	icon.style.display = 'none';
	var okButton = document.getElementById('edit-service-' + serviceId);
	okButton.style.display = 'block';
	var name = editServiceInput[0].getAttribute('data-name');
		$(editServiceInput[0]).select2({
			width: 'resolve',
			containerCssClass: 'tpx-select2-container',
  			dropdownCssClass: 'tpx-select2-drop',
			tags: true,
		  	maximumSelectionSize: 1,
		  	tokenSeparators: [','],
			ajax: {
			    url: 'mobile_api/post/search.php',
			    type: 'POST',
			    dataType: 'json',
			    minimumInputLength: 1,
			    data: function (term, search) {
			        return {
			            term: term,
			            search: 'category'
			        };
			    },
			    results: function (data) {
			       	var myResults = [];
			        if (data) {
				        $.each(data, function (index, item) {
				            if (isNaN(item.id)) {
				            	myResults.push({
					                'id': item.id,
					                'text': item.name + ' (Ny)'
					            });
				            }
				            else {
					            myResults.push({
					                'id': item.id,
					                'text': item.name
					            });
				            }
				        });
				        return {
				            results: myResults
				        };
			        }
			    }
			},
			initSelection: function (element, callback) {
			    var id = element[0].value;
			    var data = [];
        		data.push({
		            id: id,
		            text: name
		        });
		        callback(data[0]);
			}
		});
		okButton.addEventListener('click', function() {
			var service = {};
			service.id = serviceId;
			service.service_id = editServiceInput[1].value;
			service.service_name = $(editServiceInput[0]).select2('data')[0].text;
			service.category = editServiceInput[2].value;
			service.price = editServiceInput[3].value;
			service.time = editServiceInput[4].value;
			sendData('post/service.update.php', 'service=' + JSON.stringify(service), hideEditServiceInput, {service,icon,okButton});
		});
}
function hideEditServiceInput(value) {
	// var serviceId = value.service.id;
	// var editServiceInput = document.getElementsByClassName('edit-service-' + serviceId);
	// var textService = document.getElementsByClassName('service-' + serviceId);
	// textService[0].innerHTML = value.service.service_name;
	// textService[0].value = value.service.service_id;
	// textService[1].innerHTML = value.service.category;
	// textService[2].innerHTML = value.service.price;
	// textService[3].innerHTML = value.service.time;
	// $('.service-' + serviceId).show();
	// $(editServiceInput).hide();
	// editServiceInput[0].value = value.service.service_id;
	// editServiceInput[0].setAttribute('data-name', value.service.service_name);
	// value.icon.style.display = 'block';
	// value.icon.addEventListener('click', function() {
	// 	showEditServiceInput(value.icon);
	// });
	// value.okButton.style.display = 'none';
	location.reload(true);
}
var editService = document.getElementsByClassName('edit-service-btn');
for (var i = 0; i < editService.length; i++) {
	editService[i].addEventListener('click', function() {
		showEditServiceInput(this);
	});
}