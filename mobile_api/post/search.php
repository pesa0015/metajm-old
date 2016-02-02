<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	session_start();
	require '../../mysql/query.php';
	// $input = sqlEscape($_POST['value']);
	// $search = sqlEscape($_POST['search']);

	$term = sqlEscape($_GET['term']);
	$search = sqlEscape($_GET['search']);

	if (isset($search)) {
		if ($search == 'existing_services') {
			$services = sqlSelect("SELECT services.id, category.name AS category_name, services.name, services.price, services.time FROM category INNER JOIN services LEFT JOIN companies_services ON category.id = services.category_id AND services.id = companies_services.service_id WHERE services.id NOT IN (SELECT companies_services.service_id FROM companies_services WHERE companies_services.company_id = {$_SESSION['company_id']}) AND category.name LIKE '%{$term}%' GROUP BY services.id;");
			if ($services)
				echo json_encode($services);
		}
	}
	if (isset($search)) {
		if ($search == 'category') {
			$services = sqlSelect("SELECT id, name FROM category WHERE name LIKE '%{$term}%';");
			if ($services)
				echo json_encode($services);
			else {
				// $services['id'] = 0;
				// $services['name'] = $term;
				// echo json_encode(array('id' => $services['id'], 'name' => $services['name']));
				// echo "{\"id\":\"{$services['id']}\",\"name\":\"{$services['name']}\"}";
				echo "[{\"id\":\"{$term}\",\"name\":\"{$term}\"}]";
			}
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	// $input = sqlEscape($_POST['value']);
	// $search = sqlEscape($_POST['search']);

	$term = sqlEscape($_POST['term']);
	$search = sqlEscape($_POST['search']);

	if (isset($search)) {
		if ($search == 'existing_services') {
			$services = sqlSelect("SELECT services.id, category.name AS category_name, services.name, services.price, services.time FROM category INNER JOIN services LEFT JOIN companies_services ON category.id = services.category_id AND services.id = companies_services.service_id WHERE services.id NOT IN (SELECT companies_services.service_id FROM companies_services WHERE companies_services.company_id = {$_SESSION['company_id']}) AND category.name LIKE '%{$term}%' GROUP BY services.id;");
			if ($services)
				echo json_encode($services);
		}
	}
	if (isset($search)) {
		if ($search == 'category') {
			$services = sqlSelect("SELECT id, name FROM category WHERE name LIKE '%{$term}%';");
			if ($services)
				echo json_encode($services);
			else {
				// echo json_encode(array($services['id'] = 0, $services['name'] = $term));
				$services['id'] = 0;
				$services['name'] = $term;
				echo "[{\"id\":\"{$term}\",\"name\":\"{$term}\"}]";
				// echo '[{"id":0,"name":"Test"}]';
				// echo json_encode(array('id' => $services['id'], 'name' => $services['name']));
			}
		}
	}
}

?>