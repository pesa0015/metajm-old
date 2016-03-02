<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	// $input = sqlEscape($_POST['value']);
	// $search = sqlEscape($_POST['search']);

	if (isset($_POST['term']))
		$term = sqlEscape($_POST['term']);
	$search = sqlEscape($_POST['search']);

	if (isset($search)) {
		if ($search == 'existing_services') {
			$services = sqlSelect("SELECT services.id, category.name AS category_name, services.name, services.price, services.time FROM category INNER JOIN services LEFT JOIN companies_services ON category.id = services.category_id AND services.id = companies_services.service_id WHERE services.id NOT IN (SELECT companies_services.service_id FROM companies_services WHERE companies_services.company_id = {$_SESSION['company_id']}) AND category.name LIKE '%{$term}%' GROUP BY services.id;");
			if ($services)
				echo json_encode($services);
		}
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
		if ($search == 'timestamp' && !empty($_POST['timestamp'])) {
			$date = sqlEscape($_POST['timestamp']);
			$times = sqlSelect("SELECT schedule.id, timestamp, booked, customers.first_name, customers.last_name, customers.mail FROM `schedule` LEFT JOIN customers ON schedule.customer_id = customers.id WHERE DATE(timestamp) = '{$date}' AND company_id = {$_SESSION['company']['id']} ORDER BY timestamp;");
			if ($times)
				echo json_encode($times);
			else
				echo 0;
		}
	}
}

?>