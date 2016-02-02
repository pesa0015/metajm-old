<?php

session_start();
unset($_SESSION['company']);
session_destroy();
header('Location: /');

?>