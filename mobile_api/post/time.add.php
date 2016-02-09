<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	if (isset($_SESSION['company_id']) && is_numeric($_SESSION['company_id']) && isset($_POST['timestamp'])) {
		$timestamp = sqlEscape($_POST['timestamp']);
		
		$insert = sqlAction("INSERT INTO schedule (timestamp, booked, company_id) VALUES ('{$timestamp}', 0, {$_SESSION['company_id']});", true);
		if (is_numeric($insert))
			echo $insert;
	}
}

?>