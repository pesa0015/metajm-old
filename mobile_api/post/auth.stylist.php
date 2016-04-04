<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../mysql/query.php';

	$input = json_decode($_POST['login']);
	$user = sqlEscape($input->user);
	$password = sqlEscape($input->password);

	$user_exists = sqlSelect("SELECT companies_employers.id, first_name, last_name, mail, tel, companies_employers.password, companies.id AS company_id, companies.Bolagsnamn FROM `companies_employers` INNER JOIN companies ON companies_employers.company_id = companies.id WHERE mail = '{$user}' OR tel = '{$user}';");

	if ($user_exists) {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			$_SESSION['me'] = array('id' => $user_exists[0]['id'], 'first_name' => $user_exists[0]['first_name'], 'last_name' => $user_exists[0]['last_name'], 'mail' => $user_exists[0]['mail'], 'tel' => $user_exists[0]['tel']);
			$_SESSION['company'] = array('id' => $user_exists[0]['company_id'], 'name' => $user_exists[0]['Bolagsnamn']);
			echo 1;
		}
		else
			echo 'wrong password';
	}
	else
		echo 'wrong username';
}

?>