<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_role'])) {
        header("Location: ../views/403.php");
        exit();
    } 
?>