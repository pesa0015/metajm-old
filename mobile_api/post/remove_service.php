<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	session_start();
	if (isset($_SESSION['company_id']) && isset($_GET['service_id'])) {
		if (is_numeric($_SESSION['company_id']) && is_numeric($_GET['service_id'])) {
			require '../../mysql/query.php';
			if (sqlAction("DELETE FROM companies_services WHERE company_id = {$_SESSION['company_id']} AND service_id = {$_GET['service_id']};") && sqlAction("INSERT INTO activities (company_id, type, data, service_id, time) VALUES ({$_SESSION['company_id']}, 'removed_service', null, {$_GET['service_id']}, now());"))
				header('Location: ../../company?show=services');
		}
	}
}

?>