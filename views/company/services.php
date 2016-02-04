<?php if (isset($_GET['manage']) && empty($_GET['manage'])) { ?>
	<form action="mobile_api/post/add_service" method="post">
		<h1>Tjänster</h1>
		<table id="service">
			<tr>
				<th>Kategori</th>
				<th>Beskrivning</th>
				<th>Pris (sek)</th>
				<th>Tid (h)</th>
			</tr>
			<?php
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
	<?php }
	if (isset($_GET['show']) && !isset($_GET['manage']) && $_GET['show'] === 'services') {
		$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company_id']} ORDER BY id;");
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
	<script>var rowNr = <?=count($services); ?>+2;</script>
	<?php } ?>