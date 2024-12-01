<?php
include '../includes/dbconnect.inc.php';
include '../includes/navbar.php';

// Get the booking details from URL parameters
$bookingId = $_GET['bookingId'] ?? null;
$roomId = $_GET['roomId'] ?? null;
$checkin = $_GET['checkin'] ?? null;
$checkout = $_GET['checkout'] ?? null;

if (!$bookingId || !$roomId || !$checkin || !$checkout) {
    echo '<p class="w3-text-red">Booking details are missing or invalid.</p>';
    exit;
}

// Fetch room details if necessary (optional)
$stmt = $pdo->prepare("SELECT * FROM Rooms WHERE roomID = :roomID");
$stmt->execute([':roomID' => $roomId]);
$roomDetails = $stmt->fetch();

if (!$roomDetails) {
    echo '<p class="w3-text-red">Room details not found.</p>';
    exit;
}
?>

<!-- Booking Confirmation Box -->
<div class="w3-container w3-padding-32" style="max-width: 700px; margin: 100px auto; border-radius: 10px; background-color: #f4f4f9; border: 1px solid #ddd; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <div class="w3-center w3-margin-bottom">
        <h2 class="w3-text-red" style="font-weight: bold;">Booking Confirmed!</h2>
    </div>
    
    <div style="background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <p><strong>Booking ID:</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($bookingId); ?></span></p>
        <p><strong>Room ID:</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($roomId); ?></span></p>
        <p><strong>Room Type:</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($roomDetails['roomType']); ?></span></p>
        <p><strong>Scheduled Date:</strong> <span class="w3-text-blue">From <?php echo htmlspecialchars($checkin); ?> to <?php echo htmlspecialchars($checkout); ?></span></p>
    </div>

    <div class="w3-center" style="margin-top: 20px;">
        <a href="../views/user_view.php" class="w3-button w3-red w3-large" style="border-radius: 8px; padding: 10px 30px;">Go to My Bookings</a>
    </div>
</div>
