<?php include '../includes/navbar.php'; ?>
<?php include '../includes/authorize_admin.php'; ?>

<div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
    <h2 class="w3-wide">Brukeroversikt</h2>
    <p class="w3-opacity"><i>Søk på brukere i systemet for tilordning av roller eller sletting</i></p>
    <div class="w3-row w3-padding-32">
        <div class="w3-card w3-padding w3-light-grey">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="w3-container w3-margin-bottom">
                <label for="search" class="w3-text-dark-grey"><b>Søk:</b></label>
                <input type="text" name="search" id="search" class="w3-input w3-border w3-round" placeholder="Skriv inn navn eller epost">
                <button type="submit" class="w3-button w3-blue w3-margin-top w3-round">Søk</button>
            </form>

            <?php 
            require_once '../classes/User.php'; 
            require_once '../includes/dbconnect.inc.php';

            // Sjekker om det er sendt inn et søk
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Om det er sendt inn et søk, henter vi ut resultatet med 'search_users' metoden
                $searchQuery = trim($_POST['search'] ?? '');
                if (!empty($searchQuery)) {
                    $result = User::search_users($pdo, $searchQuery);
                } else {
                    // Hvis søkefeltet er tomt, henter vi ut alle brukere
                    $result = User::fetch_all($pdo);
                }
            } else {
                // I utgangspunktet hentes alle brukere
                $result = User::fetch_all($pdo);
            }

            // Skriver ut meldinger fra GET
            foreach ($_GET as $key => $value) {
                if ($key == 'message') {
                    echo '<p class="w3-text-red">' . trim(htmlspecialchars($value) . '</p>');
                }
            }

            //Sjekker om det er noen brukere i resultatet, opppretter i så fall en tabell
            if (!empty($result)) : ?>
                <div class="w3-responsive">
                    <table class="w3-table-all w3-centered w3-hoverable w3-striped">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>Navn</th>
                                <th>Epost</th>
                                <th>Rolle</th>
                                <th>Slett</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Skriver ut brukerene i tabellen med en foreach løkke-->
                            <?php foreach ($result as $bruker) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bruker['name']); ?></td>
                                    <td><?php echo htmlspecialchars($bruker['email']); ?></td>
                                    <td>
                                        <form action="../includes/update_role.php" method="POST" class="w3-container">
                                        <input type="hidden" name="id" value="<?php echo $bruker['userID']; ?>">
                                        <input type="hidden" name="email" value="<?php echo $bruker['email']; ?>">
                                        <select name="role" class="w3-select w3-border w3-round" onchange="this.form.submit()">
                                            <option value="Admin" <?php echo $bruker['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="Guest" <?php echo $bruker['role'] == 'Guest' ? 'selected' : ''; ?>>Guest</option>
                                        </select>
                                        </form>
                                    <td>
                                        <!-- Sletteknapp som sender brukerens ID til delete_user.php -->
                                        <form action="../includes/delete_user.php" method="POST" class="w3-container">
                                            <input type="hidden" name="id" value="<?php echo $bruker['userID']; ?>">
                                            <input type="hidden" name="email" value="<?php echo $bruker['email']; ?>">
                                            <button type="submit" name="delete" class="w3-button w3-red w3-round w3-small">Slett</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="w3-text-red">Ingen brukere funnet</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>    
</html>