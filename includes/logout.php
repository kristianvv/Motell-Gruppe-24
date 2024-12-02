<?php

//Start session
session_start();

//Fjerne alle session variabler
$_SESSION = [];

//Kjør session_destroy for å slette session data
session_destroy();

header("Location: /Motell-Gruppe-24/index.php"); // redirect etter utlogging 
exit();
?>
