<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])){
	// if (isset($_SESSION['company']['id'])){
		require '../../mysql/query.php';
		$open = sqlSelect("SELECT id FROM `opening_hours` WHERE DATE(`start`) = CURDATE() AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};");
		if ($open)
			echo 1;
		else
			echo 0;
		die;
	}
}

?>