<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../mysql/query.php';

	$success = false;
	$noChangesToExistingServices = false;
	$noNewServices = false;
	$update_description = false;
	$update_price = false;
	$update_time = false;
	$update_category = false;

	// echo '<pre>';
	// print_r($_POST['new_service']);
	// echo '</pre>';

	if (!empty($_POST['new_service'])) {
		$newServiceFirstKey = current($_POST['new_service']);
		$firstKey = key($_POST['new_service']);
		end($_POST['new_service']);
		$lastKey = key($_POST['new_service']);
		reset($_POST['new_service']);
	}
	
	if (!empty($newServiceFirstKey["'category'"])) {
		$insert_services = "INSERT INTO services (name, price, time, category_id, company_id) VALUES ";
		// $insert_companies_services = "INSERT INTO companies_services (company_id, service_id) VALUES ";
		// $services = sqlSelect("SELECT services.id, name, price, time, category_id FROM services INNER JOIN companies_services ON services.id = companies_services.service_id WHERE companies_services.company_id = {$_SESSION['company_id']};");
		for ($i = $firstKey; $i <= $lastKey; $i++) {
			$description = sqlEscape($_POST['new_service'][$i]["'description'"]);
			$price = sqlEscape($_POST['new_service'][$i]["'price'"]);
			$time = sqlEscape($_POST['new_service'][$i]["'time'"]);
			if (!is_numeric($_POST['new_service'][$i]["'category'"])) {
				$c = sqlEscape($_POST['existing_service'][$i]["'category'"]);
				$new_category = sqlAction("INSERT INTO category (name) VALUES ('{$c}');", true);
				// $new_service = sqlAction("('{$description}', '{$price}', '{$time}', {$new_category}, {$_SESSION['company_id']}), ");
				$insert_services .= "('{$description}', {$price}, {$time}, {$new_category}, {$_SESSION['company']['id']}), ";
				// $insert_companies_services .= "({$_SESSION['company_id']}, )";
			}
			else {
				$new_category = $_POST['new_service'][$i]["'category'"];
				$insert_services .= "('{$description}', {$price}, {$time}, {$new_category}, {$_SESSION['company']['id']}), ";
			}
		}
		$insert_services = rtrim($insert_services, ', ');
		$insert_services .= ';';

		// echo $insert_services;
		// die;

		if (sqlAction($insert_services))
			$success = true;
		// echo $success;
		// die;
		
	}
	if (!empty($_POST['existing_service'])) {
		$serviceArray = '';
		foreach($_POST['existing_service'] as $a) {
				$serviceArray .= $a["'service_id'"] . ',';
		}
		$serviceArray = rtrim($serviceArray, ',');
		$check_services = sqlSelect("SELECT id, name, price, time, category_id FROM services WHERE id IN ({$serviceArray});");
		$update_description_text = '';
		$update_price_text = '';
		$update_time_text = '';
		$update_category_text = '';
		
		$current = 0;
		$rowsToUpdate = '';

	// 	echo '<pre>';
	// print_r($_POST['existing_service']);
	// echo '</pre>';
	// echo '<pre>';
	// print_r($check_services);
	// echo '</pre>';
	// echo "SELECT id, name, price, time, category_id FROM services WHERE id IN ({$serviceArray});";
	// echo count($_POST['existing_service']);
	// die;

		for ($i = 0; $i < count($_POST['existing_service']); $i++) {
			$current = $i+1;
			// echo $i;
			// echo $check_services[$i]['category_id'];
			if (!is_numeric($_POST['existing_service'][$i]["'category'"])) {
				$c = sqlEscape($_POST['existing_service'][$i]["'category'"]);
				$new_category = sqlAction("INSERT INTO category (name) VALUES ('{$c}');", true);
				$update_category_text .= " WHEN $current THEN {$new_category}";
				$rowsToUpdate .= $current . ',';
				$update_category = true;
			}
			// else {
				if (is_numeric($_POST['existing_service'][$i]["'category'"]) && $_POST['existing_service'][$i]["'category'"] !== $check_services[$i]['category_id']) {
					$new_category = $_POST['existing_service'][$i]["'category'"];
					$update_category_text .= " WHEN $current THEN {$new_category}";
					$rowsToUpdate .= $current . ',';
					$update_category = true;
				}
				if ($_POST['existing_service'][$i]["'description'"] !== $check_services[$i]['name']) {
					$new_description = sqlEscape($_POST['existing_service'][$i]["'description'"]);
					$update_description_text .= " WHEN $current THEN '{$new_description}'";
					$rowsToUpdate .= $current . ',';
					$update_description = true;
				}
				if ($_POST['existing_service'][$i]["'price'"] !== $check_services[$i]['price']) {
					$new_price = sqlEscape($_POST['existing_service'][$i]["'price'"]);
					$update_price_text .= " WHEN $current THEN {$new_price}";
					$rowsToUpdate .= $current . ',';
					$update_price = true;
				}
				if ($_POST['existing_service'][$i]["'time'"] !== $check_services[$i]['time']) {
					$new_time = sqlEscape($_POST['existing_service'][$i]["'time'"]);
					$update_time_text .= " WHEN $current THEN {$new_time}";
					$rowsToUpdate .= $current . ',';
					$update_time = true;
				}
			// }
		}
		if ($update_description || $update_price || $update_time || $update_category) {
			$update = "UPDATE services SET ";
			if ($update_description) {
				$update .= "name = CASE id {$update_description_text} END, ";
			}
			if ($update_price) {
				$update .= "price = CASE id {$update_price_text} END, ";
			}
			if ($update_time) {
				$update .= "time = CASE id {$update_time_text} END, ";
			}
			if ($update_category) {
				$update .= "category_id = CASE id {$update_category_text} END, ";
			}
			$update = rtrim($update, ', ');
			$rowsToUpdate = rtrim($rowsToUpdate, ',');
			$update .= " WHERE id IN ({$rowsToUpdate});";
			// echo $update;
			// die;
			if (sqlAction($update))
				$success = true;
		}
	}
	if (empty($newServiceFirstKey["'category'"]))
		$noNewServices = true;
	if (!$update_description && !$update_price && !$update_time && !$update_category)
		$noChangesToExistingServices = true;
	if ($success || $noNewServices && $noChangesToExistingServices)
		header('Location: ../../company?show=services');
}

?>