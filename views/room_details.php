<?php
include '../includes/dbconnect.inc.php';  // Database connection
include '../includes/navbar.php';         // Navbar

// Get room details from GET parameters
$roomType = htmlspecialchars($_GET['roomType'] ?? 'enkeltrom');
$checkin = htmlspecialchars($_GET['checkin'] ?? '');
$checkout = htmlspecialchars($_GET['checkout'] ?? '');
$image = htmlspecialchars($_GET['image'] ?? '/public/images/default.jpg');
$bookingFailed = isset($_GET['bookingFailed']) ? (int)$_GET['bookingFailed'] : 0;

// Ensure the image path starts from the root
$image = '/' . ltrim($image, '/');
?>

<div class="w3-content" style="max-width:1200px; margin: 100px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red" style="border-radius: 8px; padding: 20px;">
        <h2>Book a Room</h2>
        <p>Please select a room type and dates for booking.</p>
    </header>

    <div class="w3-row-padding" style="margin-top: 40px;">
        <div class="w3-half">
            <img src="<?php echo $image; ?>" alt="Room Image" style="width:100%; margin-top: 20px; border-radius: 8px;">
        </div>

        <div class="w3-half">
            <div class="w3-card w3-white w3-hover-shadow" style="margin-top: 20px; padding: 30px; border-radius: 8px; height: 380px;">
                <h3>Room Details</h3>
                <p><strong>Room Type:</strong> <?php echo htmlspecialchars($roomType); ?></p>
                <form method="POST" action="../includes/process_booking.php" onsubmit="return validateDates()">
                    <input type="hidden" name="roomType" value="<?php echo htmlspecialchars($roomType); ?>">
                    <div class="w3-margin-top">
                        <label for="checkin">Check-in Date:</label>
                        <input type="date" id="checkin" name="checkin" class="w3-input w3-border" value="<?php echo htmlspecialchars($checkin); ?>" required>
                    </div>
                    <div class="w3-margin-top">
                        <label for="checkout">Check-out Date:</label>
                        <input type="date" id="checkout" name="checkout" class="w3-input w3-border" value="<?php echo htmlspecialchars($checkout); ?>" required>
                    </div>
                    <button type="submit" class="w3-button w3-red w3-margin-top" style="border-radius: 8px;">Book this Room</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for "No Rooms Available" -->
    <?php if ($bookingFailed): ?>
        <div id="noRoomsModal" class="w3-modal" style="display: block;">
            <div class="w3-modal-content w3-animate-top" style="border-radius: 8px;">
                <header class="w3-container w3-red" style="border-radius: 8px 8px 0 0;">
                    <span onclick="document.getElementById('noRoomsModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2>No Rooms Available</h2>
                </header>
                <div class="w3-container" style="padding: 20px;">
                    <p>Sorry, no rooms are available for the selected type and dates. Please try again with different dates or room type.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function validateDates() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;

    if (new Date(checkin) >= new Date(checkout)) {
        alert('Check-out date must be later than check-in date.');
        return false;
    }

    if (new Date(checkin) < new Date()) {
        alert('Check-in date must be in the future.');
        return false;
    }

    return true;
}

// Automatically close the modal after 5 seconds
if (document.getElementById('noRoomsModal')) {
    setTimeout(() => {
        document.getElementById('noRoomsModal').style.display = 'none';
    }, 5000);
}
</script>
