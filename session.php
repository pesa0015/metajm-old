<?php

session_start();
if (!isset($_SESSION['company']['id']))
	header('Location: /');
else {
	require 'mysql/query.php';
	require $_SERVER['REQUEST_URI'] . '.php';
	require 'company.php';
}

?>