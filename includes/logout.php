<!-- Logout page -->
 <?php

if (session_status() == PHP_SESSION_ACTIVE) { // check for active session
    session_unset(); // unset all session variables. or with this => $_SESSION = [];
    session_destroy(); // terminate active session
}

session_start(); // Start new session for flash message
$_SESSION['flash_message'] = "You have been successfully logged out.";
header("Location: ../index.php"); // redirect after logout 
exit();
?>
