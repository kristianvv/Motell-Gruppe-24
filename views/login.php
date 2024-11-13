<?php include '../includes/dir_navbar.php'; ?>

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

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                // Initialize failed attempts and last attempt time if not set
                if (!isset($_SESSION['failed_attempts'])) {
                    $_SESSION['failed_attempts'] = 0;
                    $_SESSION['last_failed_attempt'] = time(); 
                }

                // Check if too many failed attempts occurred within the last hour
                if ($_SESSION['failed_attempts'] >= 3 && (time() - $_SESSION['last_failed_attempt'] < 3600)) {
                    echo '<p>For mange mislykkede innloggingsforsøk. Vennligst prøv igjen om en time.</p>';
                    exit();
                } elseif (time() - $_SESSION['last_failed_attempt'] >= 30) {
                    // Reset failed attempts after one hour
                    $_SESSION['failed_attempts'] = 0;
                    $_SESSION['last_failed_attempt'] = time();
                }

                // Sanitize input data
                foreach ($_POST as &$posts) {
                    $posts = trim(htmlspecialchars($posts));
                }
                $email = $_POST['email'];
                $password = $_POST['pw'];

                // Check if the user exists in the database
                require '../includes/dbconnect.inc.php';
                require '../includes/User.php';
                $userdata = User::fetch_user_by_email($pdo, $email);

                if ($userdata == null || !password_verify($password, $userdata['password'])) {
                    // Increment failed attempts and set the last failed attempt time
                    $_SESSION['failed_attempts']++;
                    $_SESSION['last_failed_attempt'] = time();
                    echo '<p>Invalid login credentials.</p>';
                    exit();
                }

                
                $_SESSION['failed_attempts'] = 0; 
                $_SESSION['user_id'] = $userdata['userID'];
                $_SESSION['user_email'] = $userdata['email'];
                $_SESSION['user_name'] = $userdata['name'];
                $_SESSION['user_role'] = $userdata['role'];
                
                // Redirect based on user role
                if ($_SESSION['user_role'] == 'Admin') {
                    header("Location: admin_view.php");
                    exit();
                } elseif ($_SESSION['user_role'] == 'Guest') {
                    header("Location: user_view.php");
                    exit();
                }

                echo '<h1>Login successful</h1>';
                echo '<p>Welcome ' . $_SESSION['user_name'] . '</p>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
