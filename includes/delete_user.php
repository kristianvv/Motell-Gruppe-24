<?php require ('authorize_admin.php'); ?>

<?php

//set error_reporting to show all errors and warnings
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../includes/dbconnect.inc.php';
    require '../classes/User.php';
    
    $userID = trim(htmlspecialchars($_POST['id']));
    $email = trim(htmlspecialchars($_POST['email']));
    
    if ($userID == $_SESSION['user_id']) {
        header("Location: ../views/admin_administration.php?message=Du kan ikke slette deg selv!!");
        exit();
    } else {
        User::delete_user($pdo, $userID);
        header("Location: ../views/admin_administration.php?message=Bruker med email: $email slettet");
        exit();
    }
   
}