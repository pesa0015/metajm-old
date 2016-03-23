<h1>Öppettider</h1>
<p>Ange tiderna du jobbar. Det är dessa som dina kunder kommer att kunna boka.</p>
<div id="abc">
	<div id="start">Från</div>
	<div id="end">Till</div>
</div>
<div id="days">
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Måndag</label>
		<?php $day = 'monday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Tisdag</label>
		<?php $day = 'tuesday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Onsdag</label>
		<?php $day = 'wednesday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Torsdag</label>
		<?php $day = 'thursday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Fredag</label>
		<?php $day = 'friday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open" checked>Lördag</label>
		<?php $day = 'saturday'; require 'views/opening_hours.select.php'; ?>
	</div>
	<div class="checkbox day">
		<label><input type="checkbox" class="is_open">Söndag</label>
		<?php $day = 'sunday'; require 'views/opening_hours.select.php'; ?>
	</div>
</div>
<div id="settings">
	<div id="settings-left">
		<p>Du har tider t.o.m. <?=strftime('%A', strtotime($last_day[0]['start'])) . ', ' . strftime('%e %B', strtotime($last_day[0]['start'])); ?></p>
		<div class="checkbox">
			<label><input type="checkbox" id="repeat-weeks" checked>Upprepa varje vecka</label>
		</div>
		<label>Ställ in antal veckor:</label><input type="number" min="1" class="form-control" value="4" style="width:60px;">
	</div>
	<div id="settings-right">
		<button type="submit" id="set-opening-hours" class="add-new-service">
			<i class="ion-edit" style="font-size:15px;"></i>
			<span>Spara</span>
		</button>
	</div>
</div>