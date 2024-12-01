<?php include '../includes/navbar.php'; ?>

<div class="w3-container w3-center" style="margin-top: 50px;">
    <h2>Booking Overview</h2>
    <p>View all bookings made by guests.</p>

        <?php
        
        require '../includes/dbconnect.inc.php';
        require '../classes/Booking.php';

        $bookings = Booking::fetch_all_bookings($pdo);

        echo $bookings;

        foreach ($bookings as $booking) {
            echo '<p>' . $booking->get_adults() . '</p>';
        }

        ?>