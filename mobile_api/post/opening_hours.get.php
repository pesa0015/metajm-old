<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])){
		require '../../mysql/query.php';
		$day = sqlEscape($_POST['day']);
		$open = sqlSelect("SELECT start, close FROM `opening_hours` WHERE DATE(`start`) = '{$day}' AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};");
		if ($open)
			echo json_encode($open);
		else
			echo 0;
		die;
	}
}

?>