<?php
session_start();
$lng = $_SESSION['Idioma'];
session_destroy();
$_SESSION['Idioma'] = $lng;
header("Location: index.php");
exit();
?>