<?php

$css = array();

$js = array(
		'js/company.todo.js'
	);

$page = 'todo.php';

// $todos = sqlSelect("SELECT schedule.id, timestamp, customers.first_name AS customer_f_name, customers.last_name AS customer_l_name, customers.mail, category.name, services.price, companies_employers.first_name AS stylists_f_name, companies_employers.last_name AS stylists_l_name FROM `schedule` INNER JOIN customers INNER JOIN services INNER JOIN category INNER JOIN companies_employers ON schedule.customer_id = customers.id AND schedule.service_id = category.id AND schedule.service_id = services.id AND schedule.employer_id = companies_employers.id WHERE DATE(`timestamp`) = CURDATE() AND schedule.company_id = {$_SESSION['company']['id']};");
$todos = sqlSelect("SELECT bookings.id AS booking_id, booked_at, start, end, invoice, webpay, in_place, customers.id AS customer_id, customers.first_name AS customer_f_name, customers.last_name AS customer_l_name, customers.mail, customers.tel, category.name, services.price, companies_employers.first_name AS stylists_f_name, companies_employers.last_name AS stylists_l_name FROM `bookings` INNER JOIN customers INNER JOIN services INNER JOIN category INNER JOIN companies_employers ON bookings.customer_id = customers.id AND bookings.service_id = services.id AND services.category_id = category.id AND bookings.employer_id = companies_employers.id WHERE DATE(`start`) = CURDATE() AND bookings.company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']} ORDER BY start ASC;");
$times = sqlSelect("SELECT timestamp FROM `schedule` WHERE DATE(`timestamp`) = CURDATE() AND company_id = {$_SESSION['company']['id']} ORDER BY `timestamp` ASC;");

// require '../company.php';

?>