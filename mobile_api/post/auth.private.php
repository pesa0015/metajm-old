<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../mysql/query.php';

	$input = json_decode($_POST['login']);
	$user = sqlEscape($input->user);
	$password = sqlEscape($input->password);

	$user_exists = sqlSelect("SELECT id, person_nr, first_name, last_name, mail, tel, password FROM customers WHERE person_nr = '{$user}' OR mail = '{$user}';");

	if ($user_exists) {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			$_SESSION['me'] = array('id' => $user_exists[0]['id'], 'personnr' => $user_exists[0]['person_nr'], 'first_name' => $user_exists[0]['first_name'], 'last_name' => $user_exists[0]['last_name'], 'mail' => $user_exists[0]['mail'], 'tel' => $user_exists[0]['id']);
			echo 1;
		}
		else
			echo 'wrong password';
	}
	else
		echo 'wrong username';
}

?>