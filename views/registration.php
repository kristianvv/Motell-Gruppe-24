<?php include '../includes/dir_navbar.php'; ?>
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
                    <!-- Skal mobilnummer være med? Ser at det ikke ligger i bruker-objektet
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="tel">Mobile Number:</label>
                        <input class="w3-input w3-border" type="tel" id="tel" name="tel" placeholder="8 digits">
                    </div>
                    -->
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="password">New Password:</label>
                        <input class="w3-input w3-border" type="password" id="password" name="password">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input class="w3-input w3-border" type="password" id="confirm_password" name="confirm_password">
                    </div>
                    <div class="w3-col s12 m12 l12 w3-margin-bottom">
                        <br>
                        <input class="w3-input w3-border" type="submit" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

            <!-- PHP Form Validation and Processing -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($_POST as &$posts) {
                    $posts = trim(htmlspecialchars($posts));
                }

                $name = $_POST['fname'] . ' ' . $_POST['lname'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (empty($name) || empty($email) || empty($password)) {
                    echo '<p class="w3-text-red">Please fill in all fields</p>';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo '<p class="w3-text-red">Invalid email</p>';
                } elseif ($password != $_POST['confirm_password']) {
                    echo '<p class="w3-text-red">Passwords do not match</p>';
                } else {
                    require_once '../includes/User.php';
                    require_once '../includes/dbconnect.inc.php';

                    if (User::fetch_user_by_email($pdo, $email)) {
                        echo '<p class="w3-text-red">User with this email already exists</p>';
                    } else {
                        $user = new User($name, $email, $password);
                        $user->register($pdo);
                        echo '<p class="w3-text-green">User registered successfully</p>';
                    }
                }
            }
            ?>
        </div>
    </div>
</header>
</body>
</html>