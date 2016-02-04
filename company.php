<?php

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
	<?php if (isset($_GET['show']) && $_GET['show'] == 'times') { ?>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.css">
	<?php } if (isset($_GET['show']) && $_GET['show'] == 'services') { ?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css">
	<?php } ?>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1><?=$_SESSION['company']; ?></h1>
	<a href="logout">Logga ut</a><a href="company?show=times">Tider</a><a href="company?show=services">Prislista</a><a href="company?show=services&manage">Hantera tjänster</a>
	<?php
	switch ($_GET['show']) {
		case 'times':
			// $times = sqlSelect("SELECT id, timestamp, booked, customer_person_nr, customer_first_name, customer_last_name FROM `schedule` WHERE DATE(`timestamp`) = CURDATE();");
			$times = false;
			require 'views/company/times.php';
			$script = array('https://code.jquery.com/jquery-2.1.4.min.js', 'http://momentjs.com/downloads/moment.js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js', 'js/company.times.js');
			break;
		case 'services':
			require 'views/company/services.php';
			$script = array('//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js', 'js/company.services.js');
			break;
		case 'profile':
			require 'views/company/profile.php';
			break;
	}
	?>
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<?php foreach($script as $file): ?>
		<script src="<?=$file; ?>"></script>
	<?php endforeach; ?>
</body>
</html>