<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../mysql/query.php';

	$company = sqlEscape($_POST['company']);
	$password = sqlEscape($_POST['password']);

	$company_exists = sqlSelect("SELECT id, Bolagsnamn, password FROM companies WHERE Bolagsnamn = 'Testfrisör';");

	if ($company_exists) {
		$pwd = $company_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			$_SESSION['company_id'] = $company_exists[0]['id'];
			$_SESSION['company'] = $company_exists[0]['Bolagsnamn'];
			header('Location: ../../company?show=services');
		}
	}
}

?>