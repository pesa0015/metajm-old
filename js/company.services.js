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
	  	var serviceTable = document.getElementById('service');
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
		newService.addEventListener('click', function() {
			var row = serviceTable.insertRow(rowNr);
			rowNr--;
			var category = row.insertCell(0).innerHTML = '<input type="text" id="category-' + rowNr + '" class="new-service category" name="new_service[' + rowNr + '][\'category\']">';
			var description = row.insertCell(1).innerHTML = '<input type="text" id="description-' + rowNr + '" class="new-service description form-control" name="new_service[' + rowNr + '][\'description\']">';
			var price = row.insertCell(2).innerHTML = '<input type="text" id="price-' + rowNr + '" class="new-service price form-control" name="new_service[' + rowNr + '][\'price\']">';
			// var time = row.insertCell(3).innerHTML = '<input type="text" id="time-' + rowNr + '" class="new-service time" name="new_service[' + rowNr + '][\'time\']">';
			var time = row.insertCell(3).innerHTML = '<select id="time-' + rowNr + '" class="new-service time form-control" name="new_service[' + rowNr + '][\'time\']"><option value="0" selected>Välj tid</option><option value="1">1</option><option value="1.5">1,5</option><option value="2">2</option><option value="2.5">2,5</option><option value="3">3</option></select>';
			addSelect2($('#category-' + rowNr));
			rowNr++;
			rowNr++;
		});
var xhttp = new XMLHttpRequest();
function sendData() {
	xhttp.onreadystatechange = function() {
    	if (xhttp.readyState == 4 && xhttp.status == 200) {
    		console.log(xhttp.responseText);
    		if (parseInt(xhttp.responseText) == 1) {
    			callback(value);
    		}
    	}
  	}
	xhttp.open('POST', 'form/' + file, true);
  	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  	xhttp.send(data);
}
document.getElementById('update-services').addEventListener('click', function() {
	var categoryArray = new Array();
	var descriptionArray = new Array();
	var priceArray = new Array();
	var timeArray = new Array();
	var categoriesInput = document.getElementsByClassName('new-service category');
	var start = parseInt(rowNr-categoriesInput.length);
	console.log(categoriesInput);
});