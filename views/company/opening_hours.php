<h1>Öppettider</h1>
<h3>Ange tiderna du jobbar. Det är dessa som dina kunder kommer att kunna boka.</h3>
<div id="abc">
	<div id="start">Från</div>
	<div id="end">Till</div>
</div>
<div id="days">
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Måndag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Tisdag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Onsdag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Torsdag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Fredag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Lördag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open">Söndag</label>
		<?php require 'views/opening_hours.select.php'; ?>
	</div>
</div>