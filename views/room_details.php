<?php
include '../includes/dbconnect.inc.php';
include '../includes/navbar.php';

# Forsikre at brukeren er logget inn.
if (!isset($_SESSION['user_id'])) {
    echo '<p class="w3-text-red">You must be logged in to book a room.</p>';
    exit;
}

$userId = $_SESSION['user_id'];

# Få romdetaljer med $_GET request
$roomId = htmlspecialchars($_GET['roomId'] ?? '');
$title = htmlspecialchars($_GET['title'] ?? 'Room Title');
$description = htmlspecialchars($_GET['description'] ?? 'No description available.');
$image = htmlspecialchars('../' . ($_GET['image'] ?? './public/images/default.jpg'));
$price = htmlspecialchars($_GET['price'] ?? 'N/A');
$roomType = htmlspecialchars($_GET['roomType'] ?? 'Enkeltrom');

# handler FORM for booking!
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);

    try {
        # Gjør klar SQL med prepare
        $stmt = $pdo->prepare("INSERT INTO Booking (roomID, userID, checkInDate, checkOutDate)
                               VALUES (:roomID, :userID, :checkin, :checkout)");
        $stmt->execute([
            ':roomID' => $roomId,
            ':userID' => $userId,
            ':checkin' => $checkin,
            ':checkout' => $checkout
        ]);
        // Debug, kan få den til å REDIRECT til user_view eller noe. Dette er bare for testing! FJERN DENNE NÅR PROSJEKTET ER FERDIG!!
        echo '<p class="w3-text-green" style="font-size: 30px; font-weight: bold;">Booking successful! Your room has been reserved.</p>';
        } catch (Exception $e) {
            echo '<p class="w3-text-red" style="font-size: 30px; font-weight: bold;">An error occurred while processing your booking: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        
}
?>

<div class="w3-content" style="max-width:1200px; margin: 100px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red" style="border-radius: 8px; padding: 20px;">
        <h2><?php echo $title; ?></h2>
        <p><?php echo $description; ?></p>
    </header>

    <div class="w3-row-padding" style="margin-top: 40px;">
        <!-- Room Image Section -->
        <div class="w3-half">
            <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" style=" width:100%; margin-top: 20px; border-radius: 8px;">
        </div>

        <!-- Booking Form Section -->
        <div class="w3-half">
            <div class="w3-card w3-white w3-hover-shadow" style="margin-top: 20px; padding: 10px; border-radius: 8px;">
                <h3>Room Details</h3>
                <p><strong>Price per Night:</strong> <?php echo $price; ?></p>
                <p><strong>Room Type:</strong> <?php echo $roomType; ?></p>

                <form method="POST" onsubmit="return validateDates()">
                    <div class="w3-margin-top" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                        <label for="checkin">Check-in Date:</label>
                        <input type="date" id="checkin" name="checkin" class="w3-input w3-border" required style="border-radius: 8px; height: 35px;">
                    </div>
                    <div class="w3-margin-top" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                        <label for="checkout">Check-out Date:</label>
                        <input type="date" id="checkout" name="checkout" class="w3-input w3-border" required style="border-radius: 8px; height: 35px;">
                    </div>
                    <button type="submit" class="w3-button w3-red w3-margin-top" style="border-radius: 8px; padding: 10px 20px;">Book this Room</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Validerer om datoene er frem i tid og at check-out er etter check-in
function validateDates() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;

    if (new Date(checkin) >= new Date(checkout)) {
        alert('Check-out date must be later than the check-in date.');
        return false;
    }

    if (new Date(checkin) < new Date()) {
        alert('Check-in date must be in the future.');
        return false;
    }

    return true;
}
</script>



