<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['company_id']) && is_numeric($_POST['company_id'])) {
		require '../../mysql/query.php';
		$data = sqlSelect("SELECT employers_visible FROM companies WHERE id = {$_POST['company_id']};");
		echo json_encode($data);
	}
}

?>