<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['company_id']) && is_numeric($_POST['company_id'])) {
		header('Content-Type: text/html;charset=utf-8');
		require '../../mysql/query.php';
		$s = sqlSelect("SELECT services.id, services.name AS description, price, time, category.name AS category_name FROM `companies_employers_services` INNER JOIN companies_employers INNER JOIN services INNER JOIN category ON companies_employers_services.service_id = services.id AND services.category_id = category.id WHERE companies_employers.company_id = {$_POST['company_id']} GROUP BY services.id ORDER BY services.category_id;");
		// $s = sqlSelect("SELECT services.id, services.name, price, time, category.name AS category_name FROM `services` INNER JOIN category ON services.category_id = category.id WHERE company_id = {$_POST['company_id']};");
		if ($s)
			echo json_encode($s, JSON_UNESCAPED_UNICODE);
	}
}

?>