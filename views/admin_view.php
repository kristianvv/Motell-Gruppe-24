<?php include '../includes/dir_navbar.php'; ?>

<?php 
    if (!isset($_SESSION['user_role'])) {
        header("Location: ../views/403.php");
        exit();
    } elseif ($_SESSION['user_role'] != 'Admin') {
        header('views/401.php');
        exit();
    }
?>
    <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
        <h2 class="w3-wide">ADMINISTRATOR</h2>
        <p class="w3-opacity"><i>Administrator har tilgang til alle funksjoner</i></p>
        <div class="w3-row w3-padding-32">
            <div class="w3-third">
                <h2>Brukeroversikt</h2>
                <p>Søk på brukere i systemet</p>
                <div class="form-container">
            <form method="POST" action="">
                <label for="search">Søk:</label>
                <input type="text" name="search" id="search" required>
                <input type="submit" value="Søk">
            </form>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])): ?>
                <?php require_once '../includes/User.php'; ?>
                <?php require_once '../includes/dbconnect.inc.php'; ?>
                <?php $result = User::brukersøk($_POST['search'], $pdo); ?>
                <?php if ($result != null): ?>
                    <pre> <?php print_r($result, 1)?></pre>
                    <table border="1" cellpadding="10" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Navn</th>
                                <th>Epost</th>
                                <th>Rolle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Starter en foreachløkke hvor nøkkelen $brukkernavn-->
                            <?php foreach ($result as $bruker) : ?>
                                <tr>
                                    <!-- for hver gang løkken kjører skrives attributtene ut i en tabellrad med feltene nedenfor-->
                                    <td><?php echo ($bruker['name']); ?></td>
                                    <td><?php echo ($bruker['email']); ?></td>
                                    <td><?php echo ($bruker['role']); ?></td>

                                    <!-- knapp for å slette bruker
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $bruker['id']; ?>">
                                        <td><input type="submit" name="delete" value="Slett"></td>
                                    </form>
                                     -->
                                </tr>
                            <!-- avslutter foreach-->
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php else: ?>
                    <p class = 'error'>Ingen brukere funnet</p>
            <?php endif; ?>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</body>    
</html>