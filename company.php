<?php

// session_start();

// if (!isset($_SESSION['company']))
// 	header('Location: /');

// require 'mysql/query.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<base href="../">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<?php foreach($css as $file): ?>
		<link rel="stylesheet" type="text/css" href="<?=$file; ?>">
	<?php endforeach; ?>
	<link rel="stylesheet" type="text/css" href="css/company.css">
</head>
<body>
	<header>
		<div id="company-name"><span><?=$_SESSION['company']['name']; ?></span><span><i class="ion-person"></i><?=$_SESSION['me']['first_name'] . ' ' . $_SESSION['me']['last_name']; ?></span></div>
		<nav id="nav">
			<a href="company/todo">Att göra</a>
			<a href="company/times">Tider</a>
			<a href="company/services">Hantera tjänster</a>
			<a href="company/opening_hours">Öppettider</a>
			<a href="company/profile">Min sida</a>
			<a href="company/logout">Logga ut <i class="ion-log-out"></i></a>
		</nav>
	</header>
	<?php require "views/company/$page"; ?>
	<?php
	switch (@$_GET['show']) {
		// case 'times':
			// $schedule = sqlSelect("SELECT schedule.id, timestamp, booked, customers.first_name, customers.last_name, customers.mail FROM `schedule` LEFT JOIN customers ON schedule.customer_id = customers.id WHERE DATE(`timestamp`) = CURDATE() AND company_id = {$_SESSION['company']['id']};");
			// $times = array();
			// foreach($schedule as $a) {
			// 	array_push($times, $a['timestamp']);
			// 	// array_push($times, date('H:i:s', strtotime($a['timestamp'])));
			// }
			// $newTimes = array(0 => '09:00:00', 1 => '09:30:00', 2 => '10:00:00', 3 => '10:30:00', 4 => '11:00:00', 5 => '11:30:00', 6 => '12:00:00', 7 => '12:30:00', 8 => '13:00:00', 9 => '13:30:00', 10 => '14:00:00', 11 => '14:30:00', 12 => '15:00:00', 13 => '15:30:00', 14 => '16:00:00', 15 => '16:30:00');
			// require 'views/company/times.php';
			// $script = array('https://code.jquery.com/jquery-2.1.4.min.js', 'http://momentjs.com/downloads/moment.js', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/sv.js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js', 'js/company.times.js');
			// break;
		// case 'services':
		// 	require 'views/company/services.php';
		// 	$script = array('https://code.jquery.com/jquery-2.1.4.min.js', '//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js', 'js/company.services.js');
		// 	break;
		// case 'opening_hours':
			// setlocale(LC_ALL, 'sv_SE');
			// $last_day = sqlSelect("SELECT start FROM `opening_hours` WHERE company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']} ORDER BY start DESC LIMIT 1;");
			// require 'views/company/opening_hours.php';
			// $script = array('https://code.jquery.com/jquery-2.1.4.min.js', 'vendor/jquery.noty.packaged.min.js', 'js/company.opening_hours.js');
			// break;
		// case 'profile':
		// 	require 'views/company/profile.php';
		// 	$script = array('js/company.profile.js');
		// 	break;
		// case 'test':
		// 	echo 1;
		// 	break;
	}
	?>
	<!--<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
	<?php foreach($js as $file): ?>
		<script src="<?=$file; ?>"></script>
	<?php endforeach; ?>
</body>
</html>