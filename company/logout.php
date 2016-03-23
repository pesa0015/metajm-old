<?php

unset($_SESSION['me']);
unset($_SESSION['company']);
session_destroy();
header('Location: ../');

?>