<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])){
		require '../../mysql/query.php';
		$data = json_decode($_POST['booking']);

		$start = new DateTime($data->datetime);
		$end = new DateTime($data->datetime);

		$numOfHours = sqlSelect("SELECT time FROM services WHERE id = {$data->service};");

		$numOfHours = $numOfHours[0]['time'];
		// $numOfHours = 1.5;

		// if (is_float($numOfHours))
		// 	$numOfHours = $numOfHours + 0.5;
		// echo $numOfHours;
		// die;

		$array = array();
		for ($i = 1; $i <= $numOfHours*2; $i++) {
			$end = $end->modify('+30 minutes');
			// echo 1;
		}
		$start = $start->modify('+1 minute');
		$end = $end->modify('-1 minute');
		
		// $timeAlreadyBooked = sqlSelect("SELECT start FROM bookings WHERE start >= '{$start->format('Y-m-d H:i')}' AND end <= '{$end->format('Y-m-d H:i')}';");
		$timeAlreadyBooked = sqlSelect("SELECT start FROM bookings WHERE (start BETWEEN '{$start->format('Y-m-d H:i')}' AND '{$end->format('Y-m-d H:i')}');");
		// echo "SELECT start FROM bookings WHERE (start BETWEEN '{$start->format('Y-m-d H:i')}' AND '{$end->format('Y-m-d H:i')}');";
		// die;

		// echo "SELECT start FROM bookings WHERE start >= '{$start->format('Y-m-d H:i')}' AND end <= '{$end->format('Y-m-d H:i')}';";
		// die;
		if ($timeAlreadyBooked) {
			$start = $start->modify('-1 minute');
			$end = $end->modify('+1 minute');
			echo json_encode(array('timeBooked' => $timeAlreadyBooked,'start' => $start->format('H:i'),'end' => $end->format('H:i')));
			die;
		}

		else {
			$customer_id = 0;
			if ($data->customer_id > 0) {
				// $customer = sqlSelect("SELECT customers.id AS customer_id, person_nr, services.id AS service_id FROM `customers` INNER JOIN services WHERE customers.id = {$data->customer_id} AND customers.person_nr = '{$data->personnr}' AND services.id = {$data->service};");
				$customer = sqlSelect("SELECT id FROM `customers` WHERE id = {$data->customer_id} AND person_nr = '{$data->personnr}';");
				$customer_id = $customer[0]['id'];
			}
			else
				$customer_id = sqlAction("INSERT INTO customers (person_nr, first_name, last_name, mail, tel) VALUES ('{$data->personnr}', '{$data->fname}', '{$data->lname}', '{$data->mail}', '{$data->tel}');", true);

			if ($customer_id) {
				$start = $start->modify('-1 minute');
				$end = $end->modify('+1 minute');
				if (sqlAction("INSERT INTO bookings (booked_at, start, end, invoice, webpay, in_place, company_id, employer_id, service_id, customer_id) VALUES (now(), '{$start->format('Y-m-d H:i:s')}', '{$end->format('Y-m-d H:i:s')}', 0, 0, 0, {$_SESSION['company']['id']}, {$_SESSION['me']['id']}, {$data->service}, {$customer_id});")) {
					echo 1;
					die;
				}
			}
		}

		// echo $end->format('Y-m-d H:i');
		// die;



		// $test = 1;
		// echo is_float($test);
		// die;

		// echo $numOfHours[0]['time'];
		// die;

		// echo json_encode($start);
		// die;
		// echo json_encode($data);
		// die;
	}
}

?>