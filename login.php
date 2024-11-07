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
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", Arial, Helvetica, sans-serif;
        }
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

    <!-- Navigation Bar -->
    <div class="w3-bar w3-white w3-large">
        <a href="./index.php" class="w3-bar-item w3-button w3-red w3-mobile">
            <i class="fa fa-bed w3-margin-right"></i>Motel Booking
        </a>
        <a href="./views/booking_view.php" class="w3-bar-item w3-button w3-mobile">Rooms</a>
        <a href="#about" class="w3-bar-item w3-button w3-mobile">Contact</a>
        <a href="./registration.php" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Register</a>
        <a onclick="document.getElementById('id01').style.display='block'" class="w3-bar-item w3-button w3-right w3-mobile w3-red">Login</a>
    </div>

    <header class="w3-display-container" style="max-width: 1500px;">
        <img class="w3-image" src="./public/images/bg-hotel.jpg" alt="The Hotel">
        <div class="center-container">
            <div class="login-form-container w3-padding">
                <div class="w3-container w3-red">
                    <h2><i class="fa fa-bed w3-margin-right"></i>Le Fabuleux Motel</h2>
                </div>
                <div class="w3-container w3-padding-16">
                    <form action="" method="post">
                        <div class="w3-margin-bottom">
                            <label for="email">Email:</label>
                            <input class="w3-input w3-border" type="email" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="w3-margin-bottom">
                            <label for="password">Password:</label>
                            <input class="w3-input w3-border" type="password" id="pw" name="pw" placeholder="Enter Password" required>
                        </div>
                        <div class="w3-margin-bottom">
                            <input class="w3-button w3-block w3-green" type="submit" value="Login">
                            <span class="psw">Forgot <a href="#">password?</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
</body>
</html>

<?php
    
    include 'dbconnect.inc.php';
    include 'classes/User.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       foreach ($_POST as &$posts) {
            $posts = trim(htmlspecialchars(($posts)));
            unset($posts);
        }

        $email = $_POST['email'];
        $password = $_POST['pw'];

        /*
        echo '<p>' . 'epost: '. $email . '</p>';
        echo '<p>' . 'passord: '. $password . '</p>';
        
        
        if (empty($email) || empty($password)) {
            echo "<script>alert('Please fill in all fields');</script>";
            exit();
        }
        */
        $user = new User('', $email, $password, '');
       
        echo '<pre>';
        print_r($user);
        echo '</pre>';

        $userdata = $user->fetch_user_by_email($pdo, $email);

        if ($userdata == null) {
            echo '<p>'. "invalid login credentials" . '</p>';
            exit();
        }
        
       if (password_verify($password, $userdata['password'])) {
            $_SESSION['user_id'] = $userdata['id'];
            $_SESSION['user_email'] = $userdata['email'];
            $_SESSION['user_name'] = $userdata['name'];
            $_SESSION['user_role'] = $userdata['role'];
            echo '<h1>' . "login successful" . '</h1>';
            //header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');

        } else {
            echo '<p>'. "invalid login credentials" . '</p>';
            exit();
        }
    }
?>