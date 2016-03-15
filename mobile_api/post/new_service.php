<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	// require '../../mysql/query.php';
	echo json_encode($_POST);
	die;
}

?>