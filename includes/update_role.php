<?php include '../includes/authorize_admin.php'; ?>

<?php

//set error_reporting to show all errors and warnings
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../includes/dbconnect.inc.php';
    require '../classes/User.php';

    $userID = trim(htmlspecialchars($_POST['id']));
    $email = trim(htmlspecialchars($_POST['email']));
    $new_role = trim(htmlspecialchars($_POST['role']));

    if ($userID == $_SESSION['user_id']) {
        header("Location: ../views/admin_administration.php?message=You cannot change your own role!!");
        exit();
   
    } else {
        
        User::update_role($pdo, $userID, $new_role);
        header("Location: ../views/admin_administration.php?message=Role for user with email: $email updated successfully");
        exit();
    }
   
}