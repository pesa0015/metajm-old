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
			$schedule = sqlSelect("SELECT schedule.id, timestamp, booked, customers.first_name, customers.last_name, customers.mail FROM `schedule` LEFT JOIN customers ON schedule.customer_id = customers.id WHERE DATE(`timestamp`) = CURDATE() AND company_id = {$_SESSION['company_id']};");
			$times = array();
			foreach($schedule as $a) {
				array_push($times, $a['timestamp']);
				// array_push($times, date('H:i:s', strtotime($a['timestamp'])));
			}
			// echo '<pre>';
			// print_r($times);
			// echo '</pre>'; 
			$newTimes = array(0 => '09:00:00', 1 => '09:30:00', 2 => '10:00:00', 3 => '10:30:00', 4 => '11:00:00', 5 => '11:30:00', 6 => '12:00:00', 7 => '12:30:00', 8 => '13:00:00', 9 => '13:30:00', 10 => '14:00:00', 11 => '14:30:00', 12 => '15:00:00', 13 => '15:30:00', 14 => '16:00:00', 15 => '16:30:00');
			// echo '<pre>';
			// print_r($newTimes);
			// echo '</pre>'; 
			require 'views/company/times.php';
			$script = array('https://code.jquery.com/jquery-2.1.4.min.js', 'http://momentjs.com/downloads/moment.js', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/sv.js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js', 'js/company.times.js');
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
	<!--<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
	<?php foreach($script as $file): ?>
		<script src="<?=$file; ?>"></script>
	<?php endforeach; ?>
</body>
</html>