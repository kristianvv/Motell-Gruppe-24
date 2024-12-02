<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: ../includes/401.php");
    exit();
} 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../includes/dbconnect.inc.php';
    require '../classes/Booking.php';
    
    $bookingID = trim(htmlspecialchars($_POST['bookingID']));
    $checkInDate = trim(htmlspecialchars($_POST['checkInDate']));

    if (empty($bookingID) || empty($checkInDate)) {
        header("Location: ../views/my_bookings.php?message=Feil med å hente booking");
        exit();
    }

    if ($_SESSION['user_role'] == 'Guest') {

        // Sjekker om bookingen er i fortiden
        if ($checkInDate < date("Y-m-d")) {
            header("Location: ../views/my_bookings.php?message=Bookingen kan ikke slettes da den allerede har startet eller er gammel.");
            exit();
        }

        $sevenDaysAhead = date("Y-m-d", strtotime("+7 days"));  // 7 dager fra i dag
        if ($checkInDate <= $sevenDaysAhead) {
            header("Location: ../views/my_bookings.php?message=Bookingen kan ikke slettes da den starter om mindre enn 7 dager.");
            exit();
        }

        Booking::cancel_booking($pdo, $bookingID);
        header("Location: ../views/my_bookings.php?message=Bookingen er kansellert.");
    }
        

    //Bookings skal kunne slettes av admin uavhengig av tidspunkt
    if ($_SESSION['user_role'] == 'Admin') {
        Booking::cancel_booking($pdo, $bookingID);
        header("Location: ../views/booking_overview.php?message=Bookingen er kansellert.");
        exit();
    }
}
?>