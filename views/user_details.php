<?php
include('../includes/navbar.php'); 
include('../includes/authorize.php'); 
include('../classes/User.php');
include('../includes/dbconnect.inc.php');

if (isset($_SESSION['user_id'])) {
    $id = intval($_SESSION['user_id']); //Henter bruker id fra session

    try {
        // Basert på innlogget bruker, hent brukerdata
        $userData = User::get_user_by_id($pdo, $id);

        if ($userData) {
            // Om brukeren ble funnet, vis brukerdata
            echo '<div class="w3-container w3-center" style="margin-top: 50px; max-width: 1200px; margin: 20px auto;">';

            // Presentasjon av brukerdata
            echo '<div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 350px; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease; margin-top: 100px;">';
            echo '<i class="fa fa-user w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>';
            echo '<h3 style="font-size: 1.8em; margin-bottom: 20px; color: #333;">User Details</h3>';
            echo '<p style="font-size: 1.1em; line-height: 1.6; color: #555;"><strong>ID:</strong> ' . htmlspecialchars($_SESSION['user_id']) . '</p>';
            echo '<p style="font-size: 1.1em; line-height: 1.6; color: #555;"><strong>Name:</strong> ' . htmlspecialchars($userData->getName()) . '</p>';
            echo '<p style="font-size: 1.1em; line-height: 1.6; color: #555;"><strong>Email:</strong> ' . htmlspecialchars($userData->getEmail()) . '</p>';
            echo '<p style="font-size: 1.1em; line-height: 1.6; color: #555;"><strong>Role:</strong> ' . htmlspecialchars($userData->getRole()) . '</p>';

            
            echo '<div class="w3-card w3-light-grey w3-margin-top" style="padding: 20px; border-radius: 8px; background-color: #f1f1f1; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: box-shadow 0.3s ease;">';
            echo '<i class="fa fa-lock w3-text-orange" style="font-size: 50px; margin-bottom: 16px;"></i>';
            echo '<h4 style="font-size: 1.4em; margin-bottom: 16px;">Change Password</h4>';
            echo '<p style="font-size: 1.1em; color: #555;">To change your password, click the button below.</p>';

            //Redirect til forgot_password.php
            echo '<a href="forgot_password.php" class="w3-button w3-orange w3-margin-top" style="background-color: #ff5722; color: #fff; border-radius: 5px; padding: 10px 20px; font-size: 1.1em; text-decoration: none; display: inline-block; margin-top: 10px; transition: background-color 0.3s ease;">Change Your Password</a>';
            echo '</div>'; 

            echo '</div>'; 

            echo '</div>';
        } else {
            //Hvis ikke brukeren ble funnet, gi beskjed
            echo "<p class='w3-text-red'>User not found.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='w3-text-red'>An error occurred: "; //Fjerner print av feilmeldinger til bruker . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p class='w3-text-red'>No user ID provided in session. Please log in.</p>";
}
?>
