<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details - Le Fabuleux Motel</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<!-- Room Details Section -->
<div class="w3-content" style="max-width:1200px; margin: 20px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red">
        <h2><?php echo htmlspecialchars($_GET['title'] ?? 'Room Title'); ?></h2>
        <p><?php echo htmlspecialchars($_GET['description'] ?? 'No description available.'); ?></p>
    </header>

    <div class="w3-row-padding">
        <!-- Room Image -->
        <div class="w3-half">
            <img src="<?php echo htmlspecialchars('../' . $_GET['image'] ?? './public/images/default.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($_GET['title'] ?? 'Room Image'); ?>" 
                 style="width:100%; border-radius: 8px;">
        </div>

        <!-- Room Information -->
        <div class="w3-half w3-padding-large w3-white">
            <h3>Room Details</h3>
            <p><strong>Price per Night:</strong> <?php echo htmlspecialchars($_GET['price'] ?? 'N/A'); ?></p>
            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($_GET['roomType'] ?? 'Standard'); ?></p>
            <p><strong>Max Adults:</strong> <?php echo htmlspecialchars($_GET['nrAdults'] ?? 1); ?></p>
            <p><strong>Max Children:</strong> <?php echo htmlspecialchars($_GET['nrChildren'] ?? 1); ?></p>
            <p><strong>Room Attributes:</strong> <?php echo implode(', ', explode(',', $_GET['roomAttributes'] ?? '')); ?></p>

            <form action="../includes/process_booking.php" method="POST" onsubmit="return validateDates()">
                <!-- Mock Room ID -->
                <input type="hidden" name="roomId" value="1"> <!-- Mock roomId set to 1 -->
                <div class="w3-margin-top">
                    <label for="checkin">Check-in Date:</label>
                    <input type="date" id="checkin" name="checkin" class="w3-input w3-border" required>
                </div>
                <div class="w3-margin-top">
                    <label for="checkout">Check-out Date:</label>
                    <input type="date" id="checkout" name="checkout" class="w3-input w3-border" required>
                </div>
                <div class="w3-margin-top">
                    <label for="adults">Number of Adults:</label>
                    <input type="number" id="adults" name="adults" min="1" 
                           max="<?php echo htmlspecialchars($_GET['nrAdults'] ?? 1); ?>" 
                           class="w3-input w3-border" required>
                </div>
                <div class="w3-margin-top">
                    <label for="children">Number of Children:</label>
                    <input type="number" id="children" name="children" min="0" 
                           max="<?php echo htmlspecialchars($_GET['nrChildren'] ?? 1); ?>" 
                           class="w3-input w3-border">
                </div>
                <button type="submit" class="w3-button w3-red w3-margin-top">Book this Room</button>
            </form>
        </div>
    </div>
</div>

<script>
    function validateDates() {
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const checkinDate = new Date(checkinInput.value);
        const checkoutDate = new Date(checkoutInput.value);
        const currentDate = new Date();

        // Set the current date to 00:00:00 for comparison
        currentDate.setHours(0, 0, 0, 0);

        // Set the maximum date for check-in (1 year from today)
        const maxCheckinDate = new Date();
        maxCheckinDate.setFullYear(currentDate.getFullYear() + 1);

        // Check if check-in date is valid
        if (checkinDate < currentDate) {
            alert("Check-in date must be in the future.");
            return false;
        }

        // Check if check-in date is within one year
        if (checkinDate > maxCheckinDate) {
            alert("Check-in date cannot be more than one year in advance.");
            return false;
        }

        // Check if checkout date is valid
        if (checkoutDate <= checkinDate) {
            alert("Check-out date must be after the check-in date.");
            return false;
        }

        return true; // All validations passed
    }
</script>

<?php include '../includes/footer.php'; ?>
</body>
</html>
