<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['company_id']) && is_numeric($_POST['company_id']) && !empty($_POST['day'])) {
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: text/html;charset=utf-8');
		require '../../mysql/query.php';
		$day = sqlEscape($_POST['day']);
		$times = sqlSelect("SELECT * FROM `schedule` WHERE company_id = {$_POST['company_id']} AND DATE(timestamp) = '{$day}';");
		if ($times)
			echo json_encode($times, JSON_UNESCAPED_UNICODE);
	}
}

?>