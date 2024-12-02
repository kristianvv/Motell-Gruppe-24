<?php include '../includes/navbar.php'; ?>
<?php include '../includes/authorize_admin.php'; ?>

<div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
    <h2 class="w3-wide">Bookingoversikt</h2>

    <!-- Search Form -->
    <form method="POST" class="w3-margin-bottom">
        <input type="text" name="search" placeholder="Søk etter bestillings ID eller romnummer" 
               value="<?php echo htmlspecialchars($_POST['search'] ?? ''); ?>" 
               class="w3-input w3-border w3-round">
        <button type="submit" class="w3-button w3-red w3-round w3-margin-top">Søk</button>
    </form>

    <div class="w3-row w3-padding-32">
        <div class="w3-card w3-padding w3-light-grey">
            <?php 
            require '../classes/Booking.php'; 
            require '../includes/dbconnect.inc.php';

            // Fetch search query from POST
            $searchQuery = $_POST['search'] ?? '';

            // Fetch search results or all bookings
            if (!empty($searchQuery)) {
                // Search for bookings by booking ID or room ID
                $result = Booking::search_bookings($pdo, $searchQuery);
            } else {
                // Fetch all bookings if no search query
                $result = Booking::fetch_all_bookings($pdo);
            }

            // Display messages from GET (e.g., success or error messages)
            foreach ($_GET as $key => $value) {
                if ($key == 'message') {
                    echo '<p class="w3-text-red">' . trim(htmlspecialchars($value)) . '</p>';
                }
            }

            // Check if there are any bookings to display
            if (!empty($result)) : ?>
                <div class="w3-responsive">
                    <table class="w3-table-all w3-centered w3-hoverable w3-striped">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>Bestillingsnummer</th>
                                <th>Romnummer</th>
                                <th>Bruker ID</th>
                                <th>Innsjekk</th>
                                <th>Utsjekk</th>
                                <th>Mer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Display bookings in the table -->
                            <?php foreach ($result as $booking) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getRoomId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getUserId()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getFromDate()); ?></td>
                                    <td><?php echo htmlspecialchars($booking->getToDate()); ?></td>
                                    <td>
                                        <a href="booking_details.php?bookingID=<?php echo $booking->getId(); ?>" 
                                           class="w3-button w3-blue w3-round w3-small">Detaljer</a>

                                        <form action="../includes/cancel_booking.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="bookingID" value="<?php echo $booking->getId(); ?>">
                                            <input type="hidden" name="checkInDate" value="<?php echo $booking->getFromDate(); ?>">
                                            <button type="submit" class="w3-button w3-red w3-round w3-small">Kanseller</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="w3-text-red">Ingen bookinger funnet</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>    
</html>
