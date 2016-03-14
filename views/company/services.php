<?php
$admin = sqlSelect("SELECT admin FROM companies_employers WHERE id = {$_SESSION['me']['id']} AND company_id = {$_SESSION['company']['id']}");
if ($admin[0]['admin'] == 1): ?>
<?php endif; ?>
	<div id="existing_services">
		<h1>Nuvarande tjänster</h1>
	<?php
	$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company']['id']} ORDER BY id;");
	$my_services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.name AS category_name FROM `companies_employers_services` INNER JOIN services INNER JOIN category ON companies_employers_services.service_id = services.id AND services.category_id = category.id WHERE companies_employers_services.employer_id = {$_SESSION['me']['id']};");
	if ($my_services) {
		$myServicesArray = array();
		foreach($my_services as $my_service) {
			array_push($myServicesArray, $my_service['id']);
		}
	}
		// $services = sqlSelect("SELECT services.id, services.name, services.price, services.time, services.category_id FROM services INNER JOIN companies_services ON services.id = companies_services.service_id WHERE companies_services.company_id = {$_SESSION['company_id']};");
		if ($services) { ?>
			<table id="service">
				<tr>
					<th>Kategori</th>
					<th>Beskrivning</th>
					<th>Pris (sek)</th>
					<th>Tid (h)</th>
				</tr>
			<?php
			foreach ($services as $service) {
				$category = sqlSelect("SELECT category.id, category.name FROM category INNER JOIN services ON category.id = services.category_id WHERE services.category_id = {$service['category_id']};");
				$i = 0;
				?>
				<tr>
					<td><?=$service['category_name']; ?></td>
					<td><?=$service['service_name']; ?></td>
					<td><?=$service['price']; ?></td>
					<td><?=$service['time']; ?></td>
					<?php if ($my_services) {
						// foreach($my_services as $check_service) {
						if (in_array($service['id'], $myServicesArray)) { ?>
							<td><i class="ion-checkmark-round"></i></td>
					<?php } else { ?>
							<td><a href="mobile_api/post/add_my_service.php?service_id=<?=$service['id']; ?>">Använd</a></td>
					<?php }} else { ?>
						<td><a href="mobile_api/post/add_my_service.php?service_id=<?=$service['id']; ?>">Använd</a></td>
					<?php } ?>
				</tr>
				<?php $i++; } ?>
				<script>var rowNr = <?=count($services); ?>+1;</script>
			</table>
			<?php } else { ?>
			<p>Ni har inga tjänster.</p>
		<?php } ?>
			<div>
				<span id="add-new-service" class="add-new-service">
					<i class="ion-ios-plus-outline service"></i>
					<i class="ion-ios-plus service"></i>
					<span>Lägg till tjänst</span>
				</span>
				<script>
				// document.getElementById('add-new-service').addEventListener('mouseover',function(){
				// 	document.getElementsByClassName('ion-ios-plus-outline service')[0].style.display = 'none';
				// 	document.getElementsByClassName('ion-ios-plus service')[0].style.display = 'inline-block';
				// });
				// document.getElementById('add-new-service').addEventListener('mouseout',function(){
				// 	document.getElementsByClassName('ion-ios-plus service')[0].style.display = 'none';
				// 	document.getElementsByClassName('ion-ios-plus-outline service')[0].style.display = 'inline-block';
				// });
				</script>
				<button type="submit" class="add-new-service">
					<i class="ion-ios-checkmark-outline service"></i>
					<i class="ion-ios-checkmark service"></i>
					<span>Uppdatera</span>
				</button>
			</div>
		</div>