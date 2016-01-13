<?php

header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require '../../mysql/query.php';

	$lat = sqlEscape($_POST['lat']);
	$lng = sqlEscape($_POST['lng']);

	function checkUtf8($array) {
		$new_array = array();

		foreach($array as $item) {
			$json = json_encode($item);
			if (json_last_error() === JSON_ERROR_UTF8) {
				$item['Bolagsnamn'] = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($item['Bolagsnamn']));
				$item['Postort'] = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($item['Postort']));
				$item['id'] = $item['id'];
				$item['lat'] = $item['lat'];
				$item['lng'] = $item['lng'];
				$item['distance'] = $item['distance'];
				array_push($new_array, $item);
			}
			else {
				array_push($new_array, $item);
			}
		}
		return $new_array;
	}
	$companies = sqlSelect("SELECT id, Bolagsnamn, Postort, lat, lng, ( 3959 * acos( cos( radians({$lat}) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( lat ) ) ) ) AS distance FROM companies HAVING distance < 1;");
	echo json_encode(checkUtf8($companies));
	
}

?>