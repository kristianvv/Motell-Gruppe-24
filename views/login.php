<?php include '../includes/navbar.php'; ?>

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
                    <span class="psw">Forgot <a href="forgot_password.php">password?</a></span>
                </div>
            </form>

            <?php
            /*
            Setter error_reporting til å vise alle feil og varsler
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            */
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                // Initialiserer antall mislykkede innloggingsforsøk og tidspunktet for det siste mislykkede forsøket der det ikke er satt
                if (!isset($_SESSION['failed_attempts'])) {
                    $_SESSION['failed_attempts'] = 0;
                    $_SESSION['last_failed_attempt'] = time(); 
                }

                // Sjekker om det har vært for mange mislykkede innloggingsforsøk, 
                // og om det er mindre enn en time siden det siste mislykkede forsøket. Hvist ja, vis feilmelding og avslutt
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

                //Sjekker om brukeren eksisterer i databasen og om passordet er riktig
                require '../includes/dbconnect.inc.php';
                require '../classes/User.php';
                $userdata = User::fetch_user_by_email($pdo, $email);

                if ($userdata == null || !password_verify($password, $userdata['password'])) {
                    // Dersom brukeren ikke eksisterer eller passordet er feil, øker vi antall mislykkede forsøk og lagrer tidspunktet for det siste forsøket
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
                
                // Basert på brukerens rolle, redirectes brukeren til riktig side
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
