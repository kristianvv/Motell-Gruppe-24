<?php require ('authorize_admin.php'); ?>

<?php

//set error_reporting to show all errors and warnings
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../includes/dbconnect.inc.php';
    require '../classes/User.php';

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    $userID = trim(htmlspecialchars($_POST['id']));

    if ($userID == $_SESSION['user_id']) {
        echo '<alert> You cannot delete yourself!!</alert>';
        exit();
    } else {
        User::delete_user($pdo, $userID);
        header("Location: ../views/admin_view.php?message=User deleted successfully");
        exit();
    }
   
}