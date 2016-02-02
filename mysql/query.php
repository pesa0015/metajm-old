<?php

require 'connect.php';

function sqlSelect($query) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$db->set_charset('utf8');
	$stmt = $db->query($query);
	$resultArray = array();
	if ($stmt) {
		while ($row = $stmt->fetch_assoc())
			$resultArray[] = $row;
	}

	return $resultArray;

	$stmt->closeCursor();
	$db = null;
}

function sqlAction($query, $getLastId = false) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// $db->set_charset('utf8');
	if ($db->query($query)) {
		if ($getLastId)
			return $db->insert_id;
		return true;
	}
	return false;

	$stmt->closeCursor();
	$db = null;
}

function sqlEscape($string) {
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$escaped_string = $db->real_escape_string($string);

	return $escaped_string;
}

?>