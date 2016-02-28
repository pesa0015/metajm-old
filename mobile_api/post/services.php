<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['company_id']) && is_numeric($_POST['company_id'])) {
		header('Content-Type: text/html;charset=utf-8');
		require '../../mysql/query.php';
		$s = sqlSelect("SELECT services.id, services.name, price, time, category.name AS category_name FROM `services` INNER JOIN category ON services.category_id = category.id WHERE company_id = {$_POST['company_id']};");
		if ($s)
			echo json_encode($s, JSON_UNESCAPED_UNICODE);
	}
}

?>