<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	session_start();
	if (isset($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && isset($_GET['service_id'])) {
		if (is_numeric($_SESSION['company']['id']) && is_numeric($_SESSION['me']['id']) && is_numeric($_GET['service_id'])) {
			require '../../mysql/query.php';
			if (sqlAction("INSERT INTO companies_employers_services (employer_id, service_id) VALUES ({$_SESSION['me']['id']}, {$_GET['service_id']});")) {
				header('Location: ../../company?show=services');
				die;
			}
		}
	}
}

?>