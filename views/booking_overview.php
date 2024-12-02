<?php include '../includes/navbar.php'; ?>
<?php include '../includes/authorize_admin.php'; ?>

<div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
    <h2 class="w3-wide">Booking Overview</h2>
    <p class="w3-opacity"><i>Manage bookings in the system</i></p>
    <div class="w3-row w3-padding-32">
        <div class="w3-card w3-padding w3-light-grey">
            <?php 
            require '../classes/Booking.php'; 
            require '../includes/dbconnect.inc.php';

            //Error reporting
            //ini_set('display_errors', 1);
            //ini_set('display_startup_errors', 1);

            //Henter alle bookinger fra databasen
            $result = Booking::fetch_all_bookings($pdo);

            //Skriver ut meldinger fra GET
            foreach ($_GET as $key => $value) {
                if ($key == 'message') {
                    echo '<p class="w3-text-red">' . trim(htmlspecialchars($value)) . '</p>';
                }
            }

            //Sjekker om det er noen bookinger i resultatet, oppretter i så fall en tabell
            if (!empty($result)) : ?>
                <div class="w3-responsive">
                    <table class="w3-table-all w3-centered w3-hoverable w3-striped">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>Booking ID</th>
                                <th>Room ID</th>
                                <th>User ID</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Skriver ut bookinger i tabellen med en foreach løkke-->
                            <?php foreach ($result as $booking) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getRoomId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getUserId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getFromDate()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getToDate()); ?></td>
                                    <td>
                                        <a href="booking_details.php?bookingID=<?php echo $booking->getId(); ?>" 
                                           class="w3-button w3-blue w3-round w3-small">Details</a>

                                        <form action="../includes/cancel_booking.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="bookingID" value="<?php echo $booking->getId(); ?>">
                                            <input type="hidden" name="checkInDate" value="<?php echo $booking->getFromDate(); ?>">
                                            <button type="submit" class="w3-button w3-red w3-round w3-small">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="w3-text-red">No bookings found</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>    
</html>
