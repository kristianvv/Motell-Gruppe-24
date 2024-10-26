<!-- includes/header.php -->
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
    </style>
</head>
<body class="w3-light-grey">
    <!-- Navigation Bar -->
    <div class="w3-bar w3-white w3-large">
        <a href="./index.php" class="w3-bar-item w3-button w3-red w3-mobile">
            <i class="fa fa-bed w3-margin-right"></i>Motel Booking
        </a>
        <a href="./index.php#rooms" class="w3-bar-item w3-button w3-mobile">Rooms</a>
        <a href="#about" class="w3-bar-item w3-button w3-mobile">Contact</a>
        <a href="./registration.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Register</a>
        <!-- Button to open the modal login form in modal_login.php -->
        <a onclick="document.getElementById('id01').style.display='block'" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Login</a>
    </div>
