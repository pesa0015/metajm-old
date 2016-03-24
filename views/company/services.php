<?php
$admin = sqlSelect("SELECT admin FROM companies_employers WHERE id = {$_SESSION['me']['id']} AND company_id = {$_SESSION['company']['id']}");
?>
	<div id="existing_services">
		<h1>Hantera tjänster</h1>
	<?php
	$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company']['id']} ORDER BY category_name;");
	$my_services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.name AS category_name FROM `companies_employers_services` INNER JOIN services INNER JOIN category ON companies_employers_services.service_id = services.id AND services.category_id = category.id WHERE companies_employers_services.employer_id = {$_SESSION['me']['id']};");
	if ($my_services) {
		$myServicesArray = array();
		foreach($my_services as $my_service) {
			array_push($myServicesArray, $my_service['id']);
		}
	}
		// $services = sqlSelect("SELECT services.id, services.name, services.price, services.time, services.category_id FROM services INNER JOIN companies_services ON services.id = companies_services.service_id WHERE companies_services.company_id = {$_SESSION['company_id']};");
		if ($services) { ?>
			<table id="services">
				<tr>
					<?php if ($admin[0]['admin'] == 1): ?>
						<th>Ändra</th>
					<?php endif; ?>
					<th>Tjänst</th>
					<th>Kategori</th>
					<th>Pris (sek)</th>
					<th>Tid (h)</th>
					<th>Använd</th>
				</tr>
			<?php
			foreach ($services as $service) {
				$category = sqlSelect("SELECT category.id, category.name FROM category INNER JOIN services ON category.id = services.category_id WHERE services.category_id = {$service['category_id']};");
				$i = 0;
				?>
				<tr>
					<?php if ($admin[0]['admin'] == 1): ?>
						<td><i class="ion-edit"></i></td>
					<?php endif; ?>
					<td><?=$service['category_name']; ?></td>
					<td><?=$service['service_name']; ?></td>
					<td><?=$service['price']; ?></td>
					<td><?=$service['time']; ?></td>
					<?php if ($my_services) {
						// foreach($my_services as $check_service) {
						if (in_array($service['id'], $myServicesArray)) { ?>
							<td><input type="checkbox" class="service-checkbox" data-id="<?=$service['id']; ?>" checked></td>
					<?php } else { ?>
							<td><input type="checkbox" class="service-checkbox" data-id="<?=$service['id']; ?>"></td>
					<?php }} else { ?>
						<td><input type="checkbox" class="service-checkbox" data-id="<?=$service['id']; ?>"></td>
					<?php } ?>
				</tr>
				<?php $i++; } ?>
				<script>var rowNr = <?=count($services); ?>+1;</script>
			</table>
			<?php } else { ?>
			<p>Ni har inga tjänster.</p>
		<?php } ?>
			<div>
				<?php if ($admin[0]['admin'] == 1): ?>
				<span id="add-new-service" class="add-new-service">
					<i class="ion-ios-plus-outline service"></i>
					<i class="ion-ios-plus service"></i>
					<span>Lägg till tjänst</span>
				</span>
				<button type="submit" id="update-services" class="add-new-service" style="display:none;">
					<i class="ion-ios-checkmark-outline service"></i>
					<i class="ion-ios-checkmark service"></i>
					<span>Uppdatera</span>
				</button>
				<?php endif; ?>
			</div>
			<table id="new-services"></table>
		</div>
		<div id="add-service-instruction">
			<h3>Hur gör man?</h3>
			<div>Använd en tjänst</div>
			<p>När du kryssar i <input type="checkbox"> -check-knappen läggs den tjänsten till din <span class="italic">personliga</span> lista över tjänster som du erbjuder som anställd. Tjänsten blir alltså synlig och bokningsbar på startsidan.</p>
			<div>Ta bort en tjänst</div>
			<p>Om du inte vill erbjuda en tjänst kan du ta bort den genom att bocka ur <input type="checkbox" checked> -rutan.<br />Obs! Tjänsten kommer fortfarande finnas kvar för företaget, dvs dina kolleger kommer kunna använda den.</p>
			<div>Lägg till ny tjänst (endast administratör)</div>
		</div>