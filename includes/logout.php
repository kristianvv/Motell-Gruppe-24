<?php

// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();
$_SESSION['flash_message'] = "You have been successfully logged out.";
header("Location: /Motell-Gruppe-24/index.php"); // redirect after logout 
exit();
?>
