<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (isset($_SESSION['company']['id']) && is_numeric($_SESSION['company']['id']) && isset($_SESSION['me']['id']) && is_numeric($_SESSION['me']['id'])){
		require '../../mysql/query.php';
		$day = sqlEscape($_POST['day']);
		$times = sqlSelect("SELECT bookings.id AS booking_id, booked_at, start, end, invoice, webpay, in_place, customers.id AS customer_id, customers.first_name, customers.last_name, category.name FROM `bookings` INNER JOIN customers INNER JOIN services INNER JOIN category ON bookings.customer_id = customers.id AND bookings.service_id = services.id AND services.category_id = category.id WHERE DATE(`start`) = '{$day}' AND bookings.company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};");
		// echo "SELECT id, booked_at, start, end, invoice, webpay, in_place, customers.id, customers.first_name, customers.last_name FROM `bookings` INNER JOIN customers ON bookings.customer_id = customers.id WHERE DATE(`start`) = '{$day}' AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};";
		// die;
		// echo "SELECT bookings.id AS booking_id, booked_at, start, end, invoice, webpay, in_place, customers.id AS customer_id, customers.first_name, customers.last_name, services.name FROM `bookings` INNER JOIN customers INNER JOIN services ON bookings.customer_id = customers.id AND bookings.service_id = services.id WHERE DATE(`start`) = '{$day}' AND company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']};";
		// die;
		if ($times)
			echo json_encode($times);
		else
			echo 0;
		die;
	}
}

?>