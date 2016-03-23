<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id']) && is_numeric($_POST['id'])){
		require '../../mysql/query.php';
		$start = sqlEscape($_POST['start']);
		if (sqlAction("DELETE FROM bookings WHERE id = {$_POST['id']} AND start = '{$start}';")) {
			echo 1;
			die;
		}
		else {
			echo 0;
			die;
		}
		// $times = sqlSelect("SELECT id, booked_at, start, end, invoice, webpay, in_place FROM `bookings` WHERE DATE(`start`) = '{$day}' AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};");
		// if ($times)
		// 	echo json_encode($times);
		// else
		// 	echo 0;
		// die;
	}
}

?>