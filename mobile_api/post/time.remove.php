<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_POST['id']) && is_numeric($_POST['id']) && !empty($_POST['timestamp'])) {
		$timestamp = sqlEscape($_POST['timestamp']);
		$schedule = sqlSelect("SELECT schedule.id, timestamp, booked, customers.first_name, customers.last_name, customers.mail FROM `schedule` LEFT JOIN customers ON schedule.customer_id = customers.id WHERE schedule.id = {$_POST['id']} AND timestamp = '{$timestamp}' AND company_id = {$_SESSION['company']['id']};");
		
		if ($schedule) {
			if (sqlAction("DELETE FROM schedule WHERE id = {$_POST['id']} AND timestamp = '{$timestamp}' AND company_id = {$_SESSION['company']['id']};")) {
				if ($schedule[0]['booked'] == 1) {

				}
				else
					echo 1;
			}
		}
	}
}

?>