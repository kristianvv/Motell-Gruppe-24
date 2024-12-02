<?php
include '../includes/dbconnect.inc.php';
include '../includes/navbar.php';

// Get the booking details from URL parameters
$bookingId = $_GET['bookingId'] ?? null;
$roomId = $_GET['roomId'] ?? null;
$checkin = $_GET['checkin'] ?? null;
$checkout = $_GET['checkout'] ?? null;

if (!$bookingId || !$roomId || !$checkin || !$checkout) {
    echo '<p class="w3-text-red">Bestillingsdetaljer mangler eller er ikke godkjente.</p>';
    exit;
}

// Fetch room details if necessary (optional)
$stmt = $pdo->prepare("SELECT * FROM Rooms WHERE roomID = :roomID");
$stmt->execute([':roomID' => $roomId]);
$roomDetails = $stmt->fetch();

if (!$roomDetails) {
    echo '<p class="w3-text-red">Romdetaljer ble ikke funnet</p>';
    exit;
}
?>

<!-- Booking Confirmation Box -->
<div class="w3-container w3-padding-32" style="max-width: 700px; margin: 100px auto; border-radius: 10px; background-color: #f4f4f9; border: 1px solid #ddd; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <div class="w3-center w3-margin-bottom">
        <h2 class="w3-text-red" style="font-weight: bold;">Bestilling bekreftet</h2>
    </div>
    
    <div style="background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <p><strong>Bestillingsnummer:</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($bookingId); ?></span></p>
        <p><strong>Romnummer:</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($roomId); ?></span></p>
        <p><strong>Romtype</strong> <span class="w3-text-blue"><?php echo htmlspecialchars($roomDetails['roomType']); ?></span></p>
        <p><strong>Innsjekk</strong> <span class="w3-text-blue">From <?php echo htmlspecialchars($checkin); ?> to <?php echo htmlspecialchars($checkout); ?></span></p>
    </div>

    <div class="w3-center" style="margin-top: 20px;">
        <a href="../views/user_view.php" class="w3-button w3-red w3-large" style="border-radius: 8px; padding: 10px 30px;">Se mine bestillinger</a>
    </div>
</div>
