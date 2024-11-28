<?php include '../includes/navbar.php'; ?>
<div class="center-container w3-padding">
    <div class="login-form-container w3-padding">
        <div class="w3-container w3-red">
            <h2><i class="fa fa-envelope w3-margin-right"></i>Tilbakestill Passord</h2>
        </div>
        <div class="w3-container w3-padding-16 w3-light-grey">
            <form action="../includes/mail/request_new_password.php" method="post">
                <div class="w3-margin-bottom">
                    <label for="email" class="w3-text-dark-grey"><strong>E-postadresse:</strong></label>
                    <input class="w3-input w3-border" type="email" id="email" name="email" placeholder="Skriv din e-postadresse her" required>
                </div>
                <div class="w3-margin-bottom">
                    <input class="w3-button w3-block w3-red w3-hover-pale-red" type="submit" value="Send">
                </div>
                <?php 
                if (isset($_GET['message'])) {
                    echo '<p class="w3-text-red">' . htmlspecialchars($_GET['message']) . '</p>';
                }
                ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>