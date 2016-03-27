<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../mysql/query.php';
	$data = json_decode($_POST['service']);
	if (count($data) > 0) {
		$response = array();
		$category_id = 0;
		if ((int)$data->service_id > 0) {
			$category_id = (int)$data->service_id;
		}
		else {
			$category_id = sqlAction("INSERT INTO category (name) VALUES ('{$data->service_id}');", true);
		}
		if (sqlAction("UPDATE services SET name = '{$data->category}', price = {$data->price}, time = {$data->time}, category_id = {$category_id} WHERE id = {$data->id} AND company_id = {$_SESSION['company']['id']};")){
			echo json_encode(array(1,null));
			die;
		}
	}
}

?>