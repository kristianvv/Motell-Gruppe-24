<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_role'])) {
        header("Location: ../views/403.php");
        exit();
    } elseif ($_SESSION['user_role'] != 'Admin') {
        header('views/401.php');
        exit();
    }
?>