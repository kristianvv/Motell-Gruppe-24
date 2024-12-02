<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set the base URL relative to the root
$base_url = '/Motell-Gruppe-24'; // This is the root relative path from the web server's document root
?>

<!DOCTYPE html>
<html>
<head>
    <title>Motell-Gruppe-24</title>
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
        <!-- Use the base URL for linking -->
        <a href="<?php echo $base_url; ?>/index.php" class="w3-bar-item w3-button w3-red w3-mobile">
            <i class="fa fa-bed w3-margin-right"></i>Motell-Gruppe-24
        </a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- If the user is logged in -->
            <!-- If the logged-in user is an admin, display the admin panel -->
            <?php if ($_SESSION['user_role'] == 'Admin'): ?>
                <a href="<?php echo $base_url; ?>/views/admin_view.php" class="w3-bar-item w3-button w3-right w3-mobile">Administrator</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/views/user_view.php" class="w3-bar-item w3-button w3-right w3-mobile">Min bruker</a>
            <a href="<?php echo $base_url; ?>/includes/logout.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Logg ut</a>
            <?php include 'session_check.php'; ?>
        <?php else: ?>
            <!-- If the user is not logged in -->
            <a href="<?php echo $base_url; ?>/views/registration.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Register</a>
            <a href="<?php echo $base_url; ?>/views/login.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Login</a>
        <?php endif; ?>
    </div>
</body>
</html>