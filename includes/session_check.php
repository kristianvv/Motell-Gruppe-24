<?php
// Start a session if one is not already running
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set denne ned når prosjektet er ferdig, brukes kún for testing
$timeout_duration = 3600;

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Check if the session has timed out
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
        // Session expired
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session
        header("Location: ../views/login.php?message=Session expired, please log in again.");
        exit();
    }
    // Update last activity time
    $_SESSION['last_activity'] = time();
} else {
    // User is not logged in, redirect to login page
    header("Location: ../views/login.php?message=Please log in to access this page.");
    exit();
}
?>