<?php include '../includes/navbar.php'; ?>
<?php require '../includes/authorize_admin.php'; ?>

<?php 

require '../includes/dbconnect.inc.php';
require '../classes/Booking.php';
require '../classes/Room.php';
require '../classes/User.php';

//Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_GET['bookingID'])) {
    $bookingID = trim(htmlspecialchars($_GET['bookingID']));
    $current_booking = Booking::get_booking_by_id($pdo, $bookingID);
} else {
    //redirect with error message
    header("Location: booking_overview.php?message=No booking selected");
    exit;
}

$user_id = $current_booking->getUserId(); // Fetch the user ID associated with this booking
$user = User::get_user_by_id($pdo, $user_id); // Get user details using the User class
?>

<?php if ($current_booking && $user) : ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <header class="w3-container w3-center w3-padding-32 w3-red">
            <h1>Bestillingsdetaljer</h1>
            <h3>Her kan du se detaljene til booking nummer <?php echo htmlspecialchars($current_booking->getId()); ?></h3>
        </header>

        <!-- Back Button --> 
        <a href="booking_overview.php" class="w3-button w3-red w3-margin-bottom">Tilbake til bestillingsoversikt</a>

        <form class="w3-container" action="update_booking.php" method="POST">
            <!-- Booking Information -->
            <h4><strong>Romdetaljer</strong></h4>
            <label for="roomType">Romtype</label>
            <select class="w3-select" name="roomType">
                <option value="Enkeltrom" <?php echo ($current_booking->getRoomType() == 'Enkeltrom') ? 'selected' : ''; ?>>Enkeltrom</option>
                <option value="Dobbeltrom" <?php echo ($current_booking->getRoomType() == 'Dobbeltrom') ? 'selected' : ''; ?>>Dobbeltrom</option>
                <option value="Juniorsuite" <?php echo ($current_booking->getRoomType() == 'Juniorsuite') ? 'selected' : ''; ?>>Juniorsuite</option>
            </select>

            <label for="fromDate">Innsjekk</label>
            <input class="w3-input" type="date" name="fromDate" value="<?php echo htmlspecialchars($current_booking->getFromDate()); ?>" required>

            <label for="toDate">Utsjekk</label>
            <input class="w3-input" type="date" name="toDate" value="<?php echo htmlspecialchars($current_booking->getToDate()); ?>" required>

            <label for="nrAdults">Antall voksne</label>
            <input class="w3-input" type="number" name="nrAdults" value="<?php echo $current_booking->getAdults(); ?>" required>

            <label for="nrChildren">Antall barn</label>
            <input class="w3-input" type="number" name="nrChildren" value="<?php echo $current_booking->getChildren(); ?>" required>

            <!-- User Information (Read-only) -->
            <h4><strong>Gjesteinformasjon</strong></h4>
            <p><strong>Navn:</strong> <?php echo htmlspecialchars($user->getName()); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user->getEmail()); ?></p>

            <button class="w3-button w3-red w3-section" type="submit">Lagre endringer</button>
        </form>
    </div>
<?php else : ?>
    <div class="w3-container w3-center w3-padding-32">
        <p class="w3-text-red">Bestilling eller bruker ikke funnnet</p>
    </div>
<?php endif; ?>

