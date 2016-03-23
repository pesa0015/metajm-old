<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// if (isset($_POST['company_id']) && is_numeric($_POST['company_id'])) {
		// require '../../mysql/query.php';
	$test = json_decode($_POST['days']);
	// echo json_encode($test);
	// echo $test[0]->start;
	// echo $test->mon->start;
	if (!$test->sun->start)
		echo 1;
	// else
	// 	echo 0;
	// echo $test->sun->start;
	die;
		echo json_encode($_POST['monday']);
	// echo $_POST;
	// }
}

?>