<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])) {
		require '../../mysql/query.php';

		$open = sqlEscape($_POST['open']);
		$close = sqlEscape($_POST['close']);

		$start = new DateTime($open);
		$end = new DateTime($close);

		$hourDiff = $start->diff($end);

		if ($hourDiff->i == 30)
			$hourDiff->h++;

		$array = array();

		for ($i = 1; $i <= $hourDiff->h*2; $i++) {
			if ($start->format('Y-m-d H:i') != '2016-03-21 12:00' && $start->format('Y-m-d H:i') != '2016-03-21 12:30') {
				array_push($array,$start->format('Y-m-d H:i'));
			}
			$start = $start->modify('+30 minutes');
		}
		echo json_encode($array);
		die;
	}
}

?>