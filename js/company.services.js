$('#select2').select2({
	  		tags: true,
		    ajax: {
		       	url: 'mobile_api/post/search.php',
		       	type: 'POST',
		       	dataType: 'json',
		       	minimumInputLength: 1,
		       	data: function (term, search) {
		           	return {
		             	term: term,
		             	search: 'existing_services'
		           	};
		       	},
		       	results: function (data) {
		            var myResults = [];
		            $.each(data, function (index, item) {
		                myResults.push({
		                    'id': item.id,
		                    'text': item.category_name + ', ' + item.name + ' ' + item.price + ':-, ' + item.time + 'hr'
		                });
		            });
		            return {
		                results: myResults
		            };
		        }
		    }
	  	});
	  	var data = [{ id: 0.5, text: '0.5' }, { id: 1, text: '1' }, { id: 1.5, text: '1.5' }, { id: 2, text: '2' }, { id: 2.5, text: '2.5' }, { id: 3, text: '3' }];
	  	function addSelect2(category, time) {
	  		$(category).select2({
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
		  	$(time).select2({
		  		data: data
			});
	  	}
	  	var newService = document.getElementById('add-new-service');
	  	var showServiceTable = document.getElementById('show-service-table');
	  	var serviceTable = document.getElementById('new-services');
	  	var existingServices = document.getElementsByClassName('existing-service category');
	  	var existingServicesTime = document.getElementsByClassName('existing-service time');
	  	function sendValue(element) {

	  	}
	  	for (var i = 0; i <= existingServices.length-1; i++) {
	  		$(existingServicesTime[i]).select2({
	  			width: '100%',
	  			data: data
	  		});
	  	$(existingServices[i]).select2({width: '100%', tags: true, maximumSelectionSize: 1, data: [{id: existingServices[i].value, text: existingServices[i].id}]});
		$(existingServices[i]).on('select2-removed', function(e) {
			$(e.target).select2({
				width: '100%',
				tokenSeparators: [","],
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
			});
	  	}
	  	// var category = document.getElementsByClassName('new_service select2-false')[0];
	  	// 	var time = document.getElementsByClassName('new_service select2-false')[4];
	  	// 	var data = [{ id: 0, text: '0.5' }, { id: 1, text: '1' }, { id: 2, text: '1.5' }, { id: 3, text: '2' }, { id: 4, text: '2.5' }, { id: 5, text: '3' }];
	  	// 	$(time).select2({
		  // 		data: data
		  // 	});
		// if (rowNr.length === 0)
			// addSelect2($('#category-1'), $('#time-1'));
		// showServiceTable.addEventListener('click', function() {
	  		// serviceTable.style.display = 'block';
	  		// addSelect2($('#category-1'), $('#time-1'));
	  	// });
		var rowNr = 0;
		var updateButton = document.getElementById('update-services');
		newService.addEventListener('click', function() {
			if (updateButton.style.display == 'none')
				updateButton.style.display = 'inline-block';
			var row = serviceTable.insertRow(rowNr);
			// rowNr--;
			var category = row.insertCell(0).innerHTML = '<input type="text" id="category-' + rowNr + '" class="new-service category" name="new_service[][\'category\']">';
			var description = row.insertCell(1).innerHTML = '<input type="text" id="description-' + rowNr + '" class="new-service description form-control" name="new_service[][\'description\']">';
			var price = row.insertCell(2).innerHTML = '<input type="text" id="price-' + rowNr + '" class="new-service price form-control" name="new_service[][\'price\']">';
			var time = row.insertCell(3).innerHTML = '<select id="time-' + rowNr + '" class="new-service time form-control" name="new_service[][\'time\']"><option value="0" selected>Välj tid</option><option value="1">1</option><option value="1.5">1,5</option><option value="2">2</option><option value="2.5">2,5</option><option value="3">3</option></select>';
			addSelect2($('#category-' + rowNr));
			// rowNr++;
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
function sendData(file, data, callback, value) {
	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
    		// console.log(xhttp.responseText);
    		if (parseInt(xhttp.responseText) == 1) {
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
	// var categoriesInput = document.getElementsByClassName('new-service category');
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
		sendData('post/new_service.php', 'services=' + JSON.stringify(array), newServiceAdded);
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
			sendData('post/use_service.php', 'service_id=' + this.getAttribute('data-id'), useServiceChecked, this);
		else
			sendData('post/dont_use_service.php', 'service_id=' + this.getAttribute('data-id'), dontUseServiceChecked, this);
	});
}