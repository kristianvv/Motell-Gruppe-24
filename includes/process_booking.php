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

<?php
include '../includes/dbconnect.inc.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $roomId = isset($_POST['roomId']) ? $_POST['roomId'] : 3;
    $checkinDate = isset($_POST['checkin']) ? $_POST['checkin'] : null;
    $checkoutDate = isset($_POST['checkout']) ? $_POST['checkout'] : null;
    $adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 0;
    $children = isset($_POST['children']) ? (int)$_POST['children'] : 0;

    // Check for required fields
    if ($roomId === null || $roomId === '') {
        echo "Room ID is empty. Please go back and select a room.";
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("INSERT INTO bookings (roomId, checkin_date, checkout_date, adults, children) VALUES (?, ?, ?, ?, ?)");
    
    // Execute the statement with form data
    if ($stmt->execute([$roomId, $checkinDate, $checkoutDate, $adults, $children])) {
        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Booking successful!</h2>";
        echo "<p>Room ID: " . htmlspecialchars($roomId) . "</p>";
        echo "<p>Check-in Date: " . htmlspecialchars($checkinDate) . "</p>";
        echo "<p>Check-out Date: " . htmlspecialchars($checkoutDate) . "</p>";
        echo "<p>Number of Adults: " . htmlspecialchars($adults) . "</p>";
        echo "<p>Number of Children: " . htmlspecialchars($children) . "</p>";
        
        // Go Back button
        echo "<button onclick='window.history.back();' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;'>Go Back</button>";
        echo "</div>";
    } else {
        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Error in booking.</h2>";
        echo "<button onclick='window.history.back();' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;'>Go Back</button>";
        echo "</div>";
    }
}
?>

</body>
</html>
