<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Booking - Le Fabuleux Motel</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
include '../includes/dbconnect.inc.php';
session_start(); // Ensure session is started to retrieve user information

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $roomId = isset($_POST['roomId']) ? (int)$_POST['roomId'] : null;
    $checkinDate = isset($_POST['checkin']) ? $_POST['checkin'] : null;
    $checkoutDate = isset($_POST['checkout']) ? $_POST['checkout'] : null;
    $adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 0;
    $children = isset($_POST['children']) ? (int)$_POST['children'] : 0;

    // Get the logged-in user ID
    $userId = $_SESSION['user_id'] ?? null; // Ensure user_id is stored in session

    // Check for required fields
    if (!$userId) {
        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Error: You must be logged in to book a room.</h2>";
        echo "<a href='/login.php' style='padding: 10px 15px; background-color: red; color: white; text-decoration: none; border-radius: 5px;'>Log In</a>";
        echo "</div>";
        exit;
    }

    if (!$roomId || !$checkinDate || !$checkoutDate) {
        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Error: Missing booking details. Please try again.</h2>";
        echo "<button onclick='window.history.back();' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px;'>Go Back</button>";
        echo "</div>";
        exit;
    }

    try {
        // Validate room availability
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS count 
            FROM `Booking` 
            WHERE `roomID` = :roomId 
            AND (`checkInDate` < :checkoutDate AND `checkOutDate` > :checkinDate)
        ");
        $stmt->execute([
            ':roomId' => $roomId,
            ':checkinDate' => $checkinDate,
            ':checkoutDate' => $checkoutDate,
        ]);
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($availability['count'] > 0) {
            echo "<div style='text-align: center; margin: 20px;'>";
            echo "<h2>Error: The room is unavailable for the selected dates. Please choose different dates.</h2>";
            echo "<button onclick='window.history.back();' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px;'>Go Back</button>";
            echo "</div>";
            exit;
        }

        // Insert booking into database
        $stmt = $pdo->prepare("
            INSERT INTO `Booking` (`roomID`, `userID`, `checkInDate`, `checkOutDate`, `adults`, `children`) 
            VALUES (:roomId, :userId, :checkinDate, :checkoutDate, :adults, :children)
        ");
        $stmt->execute([
            ':roomId' => $roomId,
            ':userId' => $userId,
            ':checkinDate' => $checkinDate,
            ':checkoutDate' => $checkoutDate,
            ':adults' => $adults,
            ':children' => $children,
        ]);

        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Booking successful!</h2>";
        echo "<p>Room ID: " . htmlspecialchars($roomId) . "</p>";
        echo "<p>Check-in Date: " . htmlspecialchars($checkinDate) . "</p>";
        echo "<p>Check-out Date: " . htmlspecialchars($checkoutDate) . "</p>";
        echo "<p>Number of Adults: " . htmlspecialchars($adults) . "</p>";
        echo "<p>Number of Children: " . htmlspecialchars($children) . "</p>";
        echo "<button onclick='window.location.href=\"/dashboard.php\";' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px;'>Go to Dashboard</button>";
        echo "</div>";

    } catch (PDOException $e) {
        echo "<div style='text-align: center; margin: 20px;'>";
        echo "<h2>Error: Could not complete the booking. Please try again later.</h2>";
        echo "<p>Error Details: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<button onclick='window.history.back();' style='padding: 10px 15px; background-color: red; color: white; border: none; border-radius: 5px;'>Go Back</button>";
        echo "</div>";
    }
}
?>

</body>
</html>
