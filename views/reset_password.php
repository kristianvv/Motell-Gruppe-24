<?php include '../includes/navbar.php'; ?>

<div class="center-container w3-padding">
    <div class="login-form-container w3-padding">
        <!-- Header -->
        <div class="w3-container w3-red">
            <h2><i class="fa fa-key w3-margin-right"></i>Tilbakestill Passord</h2>
        </div>

        <!-- Form Section -->
        <div class="w3-container w3-padding-16 w3-light-grey">
            <form method="POST" action="update_password.php">
                <!-- New Password Input -->
                <div class="w3-margin-bottom">
                    <label for="new_password" class="w3-text-dark-grey"><strong>Nytt passord:</strong></label>
                    <input class="w3-input w3-border w3-round" type="password" name="new_password" id="new_password" placeholder="Skriv inn nytt passord" required>
                </div>
                
                <!-- Confirm Password Input -->
                <div class="w3-margin-bottom">
                    <label for="confirm_password" class="w3-text-dark-grey"><strong>Bekreft passord:</strong></label>
                    <input class="w3-input w3-border w3-round" type="password" name="confirm_password" id="confirm_password" placeholder="Bekreft ditt nye passord" required>
                </div>
                
                <!-- Submit Button -->
                <div class="w3-margin-bottom">
                    <button type="submit" class="w3-button w3-block w3-red w3-hover-pale-red w3-round">
                        Oppdater passord
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>


<?php

//DEBUGGING
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_GET['token'])) {
    exit('Ingen token funnet.');
}

$token = $_GET['token'];

require '../includes/dbconnect.inc.php';
require '../classes/User.php';
require '../includes/validator.inc.php';

// Validate the token against the database
$user = User::fetch_user_by_token($pdo, $token);

if ($user == null || $user['token_expiration'] < time()) {
    exit('Tokenet er ugyldig eller har utløpt.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];

    if ($new_password != $_POST['confirm_password']) {
        exit('Passordene stemmer ikke overens.');
    }

    if (!validator::validate($new_password, 'passord')) {
        exit('Passordet må inneholde minst 9 tegn, hvorav minst 2 tall, 1 stor bokstav og 1 spesialtegn.');
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    User::update_password($pdo, $user['email'], $hashed_password);

    // Invalidate the token
    User::invalidate_reset_token($pdo, $user['email']);

    echo 'Passordet ditt har blitt oppdatert!';
    exit;
}
?>
