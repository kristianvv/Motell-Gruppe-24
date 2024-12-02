<?php include '../includes/navbar.php'; ?>

<?php

    if (!isset($_SESSION['user_id'])) {
        header("Location: 401.php");
        exit();
    } 
    
    require '../includes/dbconnect.inc.php';
    require '../classes/Booking.php';

    $bookings = Booking::get_bookings_by_user_id($pdo, $_SESSION['user_id']);

    foreach ($_GET as $key => $value) {
        if ($key == 'message') {
            echo '<p class="w3-text-red">' . trim(htmlspecialchars($value) . '</p>');
        }
    }

?>

<?php if (!empty($bookings)) : ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <div class="w3-container">
            <h2>My Bookings</h2>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                    <th>Room Number</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Booked on</th>
                    <th>Request cancellation</th>
                </tr>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td><?php echo $booking['roomID']; ?></td>
                        <td><?php echo $booking['checkInDate']; ?></td>
                        <td><?php echo $booking['checkOutDate']; ?></td>
                        <td><?php echo $booking['createdAt']; ?></td>
                        <td>
                            <form action="../includes/cancel_booking.php" method="POST">
                                <input type="hidden" name="checkInDate" value="<?php echo $booking['checkInDate']; ?>">
                                <input type="hidden" name="bookingID" value="<?php echo $booking['id']; ?>">
                                <button type="submit" class="w3-button w3-red">Cancel Booking</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>