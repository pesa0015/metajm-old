<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])){
		require '../../mysql/query.php';
		$day = sqlEscape($_POST['day']);
		$times = sqlSelect("SELECT id, booked_at, start, end, invoice, webpay, in_place FROM `bookings` WHERE DATE(`start`) = '{$day}' AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};");
		if ($times)
			echo json_encode($times);
		else
			echo 0;
		die;
	}
}

?>