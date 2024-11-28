<?php
// Start session om det ikke allerede er startet

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>W3.CSS Template</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" />
    <style>
        body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
        /* Container for centering the form */
        .center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            padding: 16px;
        }
        /* Set maximum width for form */
        .login-form-container {
            max-width: 500px;
            width: 100%;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        .w3-display-container img {
            object-fit: cover;
            width: 100%;
            height: auto;
            max-height: 800px;
        }
    </style>
</head>
<body class="w3-light-grey">
    <div class="w3-bar w3-white w3-large">
        <a href="/Motell-Gruppe-24/index.php" class="w3-bar-item w3-button w3-red w3-mobile">
            <i class="fa fa-bed w3-margin-right"></i>Motel Booking
        </a>
        <?php if (isset($_SESSION['user_name']) && !isset($_SESSION['flash_message'])): ?>
            <!-- Display if the user is logged in -->
            <a href="/Motell-Gruppe-24/index.php#rooms" class="w3-bar-item w3-button w3-mobile">Rooms</a>
            <a href="/Motell-Gruppe-24/index.php#about" class="w3-bar-item w3-button w3-mobile">Contact</a>
            <a href="/Motell-Gruppe-24/views/user_view.php" class="w3-bar-item w3-button w3-right w3-mobile">My Account</a> <!-- Fine from index, not from views/userview -->
            <a href="/Motell-Gruppe-24/includes/logout.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Logout</a>
            <?php include 'includes/session_check.php'; ?>
        <?php else: ?>
            <!-- Display if the user is logged in -->
            <a href="/Motell-Gruppe-24/index.php#rooms" class="w3-bar-item w3-button w3-mobile">Rooms</a>
            <a href="/Motell-Gruppe-24/index.php#about" class="w3-bar-item w3-button w3-mobile">Contact</a>
            <a href="/Motell-Gruppe-24/views/registration.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Register</a>
            <a href="/Motell-Gruppe-24/views/login.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Login</a>
        <?php endif; ?>
    </div>
</body>


