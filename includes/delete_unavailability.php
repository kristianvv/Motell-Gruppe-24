<?php include 'authorize_admin.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    require 'dbconnect.inc.php';
    require '../classes/Room.php';
    
    $roomID = trim(htmlspecialchars($_POST['roomID']));
    $fromDate = trim(htmlspecialchars($_POST['fromDate']));
    $toDate = trim(htmlspecialchars($_POST['toDate']));
    
    if (Room::delete_unavailability($pdo,  $fromDate, $toDate, $roomID)) {
        header("Location: ../views/room_unavailable.php?roomID=$roomID&message=Utilgjengelighet slettet");
        exit();
    } else {
        header("Location: ../views/room_unavailable.php?roomID=$roomID&message=Kunne ikke slette utilgjengelighet");
        exit();
    }
}  