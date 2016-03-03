<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	session_start();
	if (isset($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && isset($_GET['service_id'])) {
		if (is_numeric($_SESSION['company']['id']) && is_numeric($_SESSION['me']['id']) && is_numeric($_GET['service_id'])) {
			require '../../mysql/query.php';
			if (sqlAction("DELETE FROM companies_employers_services WHERE employer_id = {$_SESSION['me']['id']} AND service_id = {$_GET['service_id']};")) {
				header('Location: ../../company?show=services');
				die;
			}
		}
	}
}

?>