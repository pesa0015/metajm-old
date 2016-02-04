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
	  		// var preload_data = [{ id: 1, text: 'Disabled User'}];
	  		// $(existingServices[i]).css('width', '300px');
	  		// var data = [{id: "CA", text: "California"},{id:"MA", text: "Massachusetts"}];
	  		// insert(existingServices[i].value, existingServices[i].id);
// 	  		var data = [{
//     id: 1,
//     text: "A"
// }, {
//     id: 2,
//     text: "B"
// }, {
//     id: 3,
//     text: "C"
// }];
		// console.log(existingServices[i].id);
		$(existingServices[i]).select2({width: '100%', tags: true, maximumSelectionSize: 1, data: [{id: existingServices[i].value, text: existingServices[i].id}]});
		$(existingServices[i]).on('select2-removed', function(e) {
			// e.val = 'färg';
			
			// console.log(e.target.id);
			// addSelect2($(existingServices[i]), false);
			// console.log(e);
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
	  		// $(existingServices[i]).select2({data: data});
	  		// console.log($(existingServices)[i]);
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
			var category = row.insertCell(0).innerHTML = '<input type="text" id="category-' + rowNr + '" class="new-service" name="new_service[' + rowNr + '][\'category\']">';
			var description = row.insertCell(1).innerHTML = '<input type="text" id="description-' + rowNr + '" class="new-service" name="new_service[' + rowNr + '][\'description\']">';
			var price = row.insertCell(2).innerHTML = '<input type="text" id="price-' + rowNr + '" class="new-service" name="new_service[' + rowNr + '][\'price\']">';
			var time = row.insertCell(3).innerHTML = '<input type="text" id="time-' + rowNr + '" class="new-service" name="new_service[' + rowNr + '][\'time\']">';
			addSelect2($('#category-' + rowNr), $('#time-' + rowNr));
			rowNr++;
			rowNr++;
			// var td = '<td><input type="text" class="new_service select2-false" name="new_service[]"></td>';
			// var input = '<tr>' + td + td + td + td + td + '</tr>';
			// document.getElementById('service').innerHTML += input;
			// addSelect2(document.getElementsByClassName('new-service select2-false'));
			// addSelect2($('#category-' + rowNr), $('#time-' + rowNr));
		});