<?php

$css = array();

$js = array('https://code.jquery.com/jquery-2.1.4.min.js', 'vendor/jquery.noty.packaged.min.js', 'js/company.opening_hours.js');

setlocale(LC_ALL, 'sv_SE');

$page = 'opening_hours.php';

$last_day = sqlSelect("SELECT start FROM `opening_hours` WHERE company_id = {$_SESSION['company']['id']} AND employer_id = {$_SESSION['me']['id']} ORDER BY start DESC LIMIT 1;");

// require '../company.php';

?>