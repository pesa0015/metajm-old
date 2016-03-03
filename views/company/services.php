<?php
$admin = sqlSelect("SELECT admin FROM companies_employers WHERE id = {$_SESSION['me']['id']} AND company_id = {$_SESSION['company']['id']}");
if ($admin[0]['admin'] == 1): ?>
<form action="mobile_api/post/add_service" method="post" id="manage-services">
		<h1>Redigera tjänster</h1>
		<table id="service">
			<tr>
				<th>Kategori</th>
				<th>Beskrivning</th>
				<th>Pris (sek)</th>
				<th>Tid (h)</th>
			</tr>
			<?php
			$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company']['id']} ORDER BY id;");
			$i = 0;
			if ($services) {
				foreach ($services as $service) { ?>
				<tr>
					<input type="hidden" name="existing_service[<?=$i; ?>]['service_id']" value="<?=$service['id']; ?>">
					<td><input type="text" id="<?=$service['category_name']; ?>" class="existing-service category" name="existing_service[<?=$i; ?>]['category']" value="<?=$service['category_id']; ?>"></td>
					<td><input type="text" class="existing-service" name="existing_service[<?=$i; ?>]['description']" value="<?=$service['service_name']; ?>"></td>
					<td><input type="text" class="existing-service" name="existing_service[<?=$i; ?>]['price']" value="<?=$service['price']; ?>"></td>
					<td><input type="text" class="existing-service time" name="existing_service[<?=$i; ?>]['time']" value="<?=$service['time']; ?>"></td>
					<td><a href="mobile_api/post/remove_service?service_id=<?=$service['id']; ?>">Ta bort</a></td>
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
	<script>var rowNr = <?=count($services); ?>+2;</script>
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
			<table>
				<tr>
					<th>Kategori</th>
					<th>Beskrivning</th>
					<th>Pris (sek)</th>
					<th>Tid (h)</th>
				</tr>
			<?php
			foreach ($services as $service) {
				$category = sqlSelect("SELECT category.id, category.name FROM category INNER JOIN services ON category.id = services.category_id WHERE services.category_id = {$service['category_id']};");
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
				<?php } ?>
			</table>
			<?php } else { ?>
			<p>Ni har inga tjänster.</p>
		<?php } ?>
		</div>
		<div id="my_services">
			<h1>Mina tjänster</h1>
			<?php
			if ($my_services) { ?>
				<table>
					<tr>
						<th>Kategori</th>
						<th>Beskrivning</th>
						<th>Pris (sek)</th>
						<th>Tid (h)</th>
					</tr>
					<?php foreach($my_services as $my_service) { ?>
					<tr>
						<td><?=$my_service['category_name']; ?></td>
						<td><?=$my_service['service_name']; ?></td>
						<td><?=$my_service['price']; ?></td>
						<td><?=$my_service['time']; ?></td>
						<td><a href="mobile_api/post/remove_my_service.php?service_id=<?=$my_service['id']; ?>">Ta bort</a></td>
					</tr>
					<?php }
			}
			else { ?>
				<p>Du har inga tjänster.</p>
			<?php } ?>
		</div>