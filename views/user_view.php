<?php include '../includes/dir_navbar.php'; ?>

<?php 
//Sjekk om bruker er logget inn. Trenger ikke sjekke rolle da alle brukere skal kunne se denne siden
if (!isset($_SESSION['user_name'])) {
    header("Location: ../includes/403.php");
    exit();
}

?>
    <?php if (isset($_SESSION['user_name'])): ?>
        <h1>Velkommen til din side, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! </h1>
        <h3>Her kan du se dine bestillinger og endre brukerinformasjon</h3>
        <div class="form-container">
                <form action="" method="POST">
                    <label for="username">Rediger brukernavn</label>
                    <input type="text" step="any" id="username" name="username" placeholder="<?php echo $_SESSION['user_name'];?>" value="<?php echo $_SESSION['user_name'];?>" required>
                    <input type="submit" value="Oppdater navn">
                </form>
                    <br>
                <form action="" method="POST">
                    <label for="email">Rediger epostadresse</label>
                    <input type="email" step="any" id="email" name="email" placeholder ="<?php echo $_SESSION['user_email'];?>" value ="<?php echo $_SESSION['user_email'];?>" required>
                    <input type="submit" value="Oppdater epost">
                </form>
                    <br>

                    <!-- Ikke ferdig implementert 
                <form action="" method="POST">
                    <label for="password">Rediger Passord</label>
                    <input type="tlf" id="password" name="password" placeholder ="password" value ="password" required>
                    <input type="submit" value="Oppdater passord">
                </form>
                -->
            </div>
        <?php endif; ?>
    </body>
</html>
