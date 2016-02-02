<?php

/*

SELECT category.id, category.name, services.id, services.name, services.price, services.time FROM category INNER JOIN services INNER JOIN companies_services ON category.id = services.category_id AND services.id = companies_services.service_id WHERE companies_services.company_id = 3605

*/

session_start();

if (!isset($_SESSION['company']))
	header('Location: /');

require 'mysql/query.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1><?=$_SESSION['company']; ?></h1>
	<a href="logout">Logga ut</a><a href="company?show=services">Översikt</a><a href="company?show=services&manage">Hantera tjänster</a><a href="company?show=time">Tider</a>
	<?php if (isset($_GET['manage']) && empty($_GET['manage'])) { ?>
	<form action="mobile_api/post/add_service" method="post">
		<!--<p>Välj bland befintliga tjänster:</p>-->
		<!--<input type="text" id="select2" name="existing_services" style="width: 300px;">-->
		<!--<p id="show-service-table">Lägg till ny:</p>-->
		<h1>Tjänster</h1>
		<table id="service">
			<tr>
				<th>Kategori</th>
				<th>Beskrivning</th>
				<th>Pris (sek)</th>
				<th>Tid (h)</th>
			</tr>
			<?php
			// $services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM services INNER JOIN category INNER JOIN companies_services ON services.id = companies_services.service_id AND category.id = services.category_id WHERE companies_services.company_id = {$_SESSION['company_id']} ORDER BY id;");
			$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company_id']} ORDER BY id;");
			$i = 0;
			if ($services) {
				foreach ($services as $service) { ?>
				<tr>
					<input type="hidden" name="existing_service[<?=$i; ?>]['service_id']" value="<?=$service['id']; ?>">
					<td><input type="text" id="<?=$service['category_name']; ?>" class="existing-service category" name="existing_service[<?=$i; ?>]['category']" value="<?=$service['category_id']; ?>"></td>
					<td><input type="text" class="existing-service" name="existing_service[<?=$i; ?>]['description']" value="<?=$service['service_name']; ?>"></td>
					<td><input type="text" class="existing-service" name="existing_service[<?=$i; ?>]['price']" value="<?=$service['price']; ?>"></td>
					<td><input type="text" class="existing-service time" name="existing_service[<?=$i; ?>]['time']" value="<?=$service['time']; ?>"></td>
				</tr>
				<?php $i++; }} ?>
			<tr>
				<!-- <td><input type="text" id="category-1" class="new-service" name="new_service[<?=$i; ?>]['category']"></td>
				<td><input type="text" id="description-1" class="new-service" name="new_service[<?=$i; ?>]['description']"></td>
				<td><input type="text" id="price-1" class="new-service" name="new_service[<?=$i; ?>]['price']"></td>
				<td><input type="text" id="time-1" class="new-service" name="new_service[<?=$i; ?>]['time']"></td> -->
			</tr>
		</table>
		<input type="button" id="add-new-service" value="+">
		<input type="submit" value="Uppdatera">
	</form>
	<?php }
	if (isset($_GET['show']) && !isset($_GET['manage']) && $_GET['show'] === 'services') {
		$services = sqlSelect("SELECT services.id, services.name, services.price, services.time, services.category_id FROM services INNER JOIN companies_services ON services.id = companies_services.service_id WHERE companies_services.company_id = {$_SESSION['company_id']};");
		if ($services) { ?>
			<table>
				<tr>
					<th>Tjänst</th>
					<th>Pris (sek)</th>
					<th>Tid (min)</th>
				</tr>
			<?php
			foreach ($services as $service) {
				$category = sqlSelect("SELECT category.id, category.name FROM category INNER JOIN services ON category.id = services.category_id WHERE services.category_id = {$service['category_id']};");
				?>
				<tr>
					<td><?=$category[0]['name']; ?>, <?=$service['name']; ?></td>
					<td><?=$service['price']; ?></td>
					<td><?=$service['time']; ?></td>
					<!-- <td><a href="mobile_api/post/remove_service?service_id=<?=$service['id']; ?>">Ta bort</a></td> -->
				</tr>
				<?php } ?>
			</table>
			<?php }
		else { 
			if (!isset($_GET['manage'])) { ?>
			<p>Ni har inga tjänster. <a href="company?show=services&manage">Lägg till.</a></p>
		<?php }}
	?>
	<?php }
	/*else if (!isset($_GET)) {
		$activity = sqlSelect("SELECT type, time FROM activities WHERE company_id = {$_SESSION['company_id']};");
		if ($activity) {
			foreach ($activity as $event) { ?>
				<p><span style="font-weight: 700;"><?=$event['time']; ?></span> : <?=$event['type']; ?></p>
				<?php
			}
		}
	}*/
	?>
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js"></script>
	<script type="text/javascript">
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
		var rowNr = <?=count($services); ?>+2;
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
	</script>
</body>
</html>