<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	$data = json_decode($_POST['services']);
	if (count($data) > 0) {
		$insert = "INSERT INTO services (name, price, time, category_id, company_id) VALUES ";
		foreach($data as $service) {
			if ((int)$service->category > 0) 
				$category_id = $service->category;
			else 
				$category_id = sqlAction("INSERT INTO category (name) VALUES ('{$service->category}');", true);
			$insert .= "('{$service->description}', {$service->price}, {$service->time}, {$category_id}, {$_SESSION['company']['id']}), ";
		}
		$insert = rtrim($insert, ', ');
		$insert .= ';';
		if (sqlAction($insert))
			echo json_encode(array(1,null));
		else
			echo json_encode(array(0,null));
		die;
	}
}

?>