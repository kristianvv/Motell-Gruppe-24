<?php include '../includes/navbar.php'; ?>

<?php 
//Sjekk om bruker er logget inn. Trenger ikke sjekke rolle da alle brukere skal kunne se denne siden
if (!isset($_SESSION['user_name'])) {
    header("Location: ../includes/401.php");
    exit();
}
?>
    <?php if (isset($_SESSION['user_name'])): ?>
        
        <div class="w3-container w3-center" style="margin-top: 50px;">
        
            <div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 300px; padding: 20px; border-radius: 8px;">
                <i class="fa fa-id-card w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>
                <h3>Brukerdetaljer</h3>
                <a href="user_details.php" class="w3-button w3-red w3-margin-top">Se brukerdetaljer</a>
            </div>

    
        <div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 300px; padding: 20px; border-radius: 8px;">
            <i class="fa fa-calendar w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>
            <h3>Mine bestillinger</h3>
            <a href="my_bookings.php" class="w3-button w3-red w3-margin-top">Se mine bestillinger</a>
        </div>
    </div>

        <?php endif; ?>
    </body>
</html>