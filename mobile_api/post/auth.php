<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../mysql/query.php';

	$mail = sqlEscape($_POST['mail']);
	$password = sqlEscape($_POST['password']);

	// $company_exists = sqlSelect("SELECT id, Bolagsnamn, password FROM companies WHERE Bolagsnamn = 'Testfrisör';");

	$user_exists = sqlSelect("SELECT companies_employers.id, first_name, last_name, mail, companies_employers.password, companies.id AS company_id, companies.Bolagsnamn FROM `companies_employers` INNER JOIN companies ON companies_employers.company_id = companies.id WHERE mail = '{$mail}';");

	if ($user_exists) {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			$_SESSION['me'] = array(
								'id' => $user_exists[0]['id'], 
								'first_name' => $user_exists[0]['first_name'], 
								'last_name' => $user_exists[0]['last_name'], 
								'mail' => $user_exists[0]['mail']
								);
			$_SESSION['company'] = array(
									'id' => $user_exists[0]['company_id'],
									'name' => $user_exists[0]['Bolagsnamn']
									);
			// $_SESSION['company_id'] = $company_exists[0]['id'];
			// $_SESSION['company'] = $company_exists[0]['Bolagsnamn'];
			header('Location: ../../company?show=times');
		}
		else
			header('Location: ../../login');
	}
	else
		header('Location: ../../login');
}

?>