<?php

session_start();
if (!isset($_SESSION['company']['id']))
	header('Location: /');
else {
	require 'mysql/query.php';
	require substr($_SERVER['REQUEST_URI'],1) . '.php';
	require 'company.php';
}

?>