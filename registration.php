<?php
// Include db connection file and user
// include 'includes/dbconnect.inc.php';
include 'includes/User.php';
include 'includes/navbar.php'; 
include 'includes/modal_login.php'
?>

<header class="w3-display-container w3-content" style="max-width:1500px;"> <!-- Overarching container for background image -->
    <img class="w3-image" src="./public/images/bg-hotel.jpg" alt="The Hotel" style="min-width:1000px" width="1500" height="800">
    <div class="w3-display-left w3-padding w3-col l6 m8"> <!-- Container for registration form -->
        <div class="w3-container w3-red"> <!-- Title container -->
            <h2><i class="fa fa-bed w3-margin-right"></i>Registration</h2>
        </div>
        <div class="w3-container w3-white w3-padding-16"> <!-- Fields container -->
            <!-- Form goes here -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="w3-row-padding">
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="username">First Name:</label>
                        <input class="w3-input w3-border" type="text" id="fname" name="fname" placeholder="John">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="username">Last Name:</label>
                        <input class="w3-input w3-border" type="text" id="lnamee" name="lname" placeholder="Galt">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="email">Email:</label>
                        <input class="w3-input w3-border" type="email" id="email" name="email" placeholder="john.galt@gmail.com">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="tel">Mobile Number:</label>
                        <input class="w3-input w3-border" type="tel" id="tel" name="tel" placeholder="8 digits">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="password">New Password:</label>
                        <input class="w3-input w3-border" type="password" id="password" name="password">
                    </div> 
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="password">Confirm New Password:</label>
                        <input class="w3-input w3-border" type="password" id="password" name="password">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <br>
                        <input class="w3-input w3-border" type="submit" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>

<?php
// Check if form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitising POST data by trimming and removing special characters from input fields

    foreach ($_POST as &$posts) {
        $posts = trim(htmlspecialchars(($posts)));
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate fields
    if (empty($username) || empty($email) || empty($password)) {
        echo 'Please fill in all fields';
    } else {
        $user = new User($username, $email, $password); // Create new User
        $stmt = $pdo->prepare("SELECT email FROM userdata WHERE email = ?"); // Check DB for user based on email
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo 'Email already exists';
        } else {
            // Call the register method to store the user in the database
            $user->register($pdo);
            echo 'Registration successful';
        }
    }
}
?>

<!-- HTML registration form -->
