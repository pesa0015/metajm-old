<?php

$css = array(
		'//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css',
		'vendor/font-awesome.min.css',
		'vendor/select2-skins.min.css'
	);

$js = array('https://code.jquery.com/jquery-2.1.4.min.js', '//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.js', 'vendor/jquery.noty.packaged.min.js', 'js/company.services.js');

$page = 'services.php';

$admin = sqlSelect("SELECT admin FROM companies_employers WHERE id = {$_SESSION['me']['id']} AND company_id = {$_SESSION['company']['id']}");

$services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.id AS category_id, category.name AS category_name FROM `services` INNER JOIN category ON category.id = services.category_id WHERE company_id = {$_SESSION['company']['id']} ORDER BY category_name;");
$my_services = sqlSelect("SELECT services.id, services.name AS service_name, price, time, category.name AS category_name FROM `companies_employers_services` INNER JOIN services INNER JOIN category ON companies_employers_services.service_id = services.id AND services.category_id = category.id WHERE companies_employers_services.employer_id = {$_SESSION['me']['id']};");
if ($my_services) {
	$myServicesArray = array();
	foreach($my_services as $my_service) {
		array_push($myServicesArray, $my_service['id']);
	}
}
$selectTimes = array(0.5,1,1.5,2,2.5,3);
// echo '<pre>';
// print_r($selectTimes);
// echo '</pre>';

// require '../company.php';

?>