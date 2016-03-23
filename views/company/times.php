<?php
$my_services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.name AS category_name FROM `companies_employers_services` INNER JOIN services INNER JOIN category ON companies_employers_services.service_id = services.id AND services.category_id = category.id WHERE companies_employers_services.employer_id = {$_SESSION['me']['id']};");
?>
<h1>Tider</h1>
<div id="calendar"></div>
<input type="hidden" id="today" value="<?=date('Y-m-d'); ?>">
<div id="times">
</div>
<div class="md-modal md-effect-12" id="modal-12">
	<div class="md-content">
		<button class="md-button" onClick="document.getElementById('modal-12').className = 'md-modal md-effect-12';"><i class="ion-close-round"></i></button>
		<!-- <h3 id="time-to-book">Tid</h3> -->
		<input type="hidden" id="customer_id">
		<div id="md-top">
			<div id="left">
				<span class="ion-ios-calendar-outline"></span>
				<span id="md-date">2016-03-22</span>
			</div>
			<div id="right">
				<span class="ion-ios-clock-outline"></span>
				<span id="md-time">08:00</span>
			</div>
		</div>
		<div>
			<div id="md-middle">
				<label>Personnr</label>
				<input type="text" id="personnr" class="form-control" max-length="11" style="width:110px;display:inline-block;margin-left:24px;">
			</div>
			<div id="customer-information">
				<label>Förnamn</label><input type="text" id="fname" class="form-control" style="width:200px;">
				<label>Efternamn</label><input type="text" id="lname" class="form-control" style="width:200px;">
				<label>Mail</label><input type="text" id="mail" class="form-control" style="width:200px;">
				<label>Tel</label><input type="text" id="tel" class="form-control" style="width:200px;">
			</div>
			<label>Tjänst</label><input type="text" id="select2" style="width:200px;">
			<button id="book" class="md-button">Spara</button>
		</div>
	</div>
</div>
<div class="md-overlay"></div>