<?php include 'includes/navbar.php'; ?>

<header class="w3-display-container w3-content" style="max-width:1500px; border-radius: 8px;">
    <!-- Valgfritt header bilde -->
</header>

<!-- Søkeskjema-seksjon med kortdesign -->
<div class="w3-container w3-padding-32">
    <div class="w3-card-4 w3-margin-top w3-round-large" style="max-width: 800px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border: 8px solid #d9534f; border-radius: 12px; padding: 40px; background-color: white;">
        <div class="w3-container w3-center" style="padding: 20px;">
            <h2 class="w3-text-dark-grey" style="font-size: 36px; font-weight: bold;">Motell Gruppe 24</h2>
            <p class="w3-text-dark-grey" style="font-size: 20px; font-weight: bold;">
                <br>Finn ditt utrolige rom!<br>
            </p>
        </div>
        <form method="post" action="#rooms">
            <!-- Sentralisering av feltene og justering av input-størrelse -->
            <div class="w3-padding-32 w3-center">
                <label for="adults" class="w3-text-dark-grey" style="font-size: 20px; font-weight: bold;"><i class="fa fa-male w3-text-dark-grey"></i> Sengeplasser Voksne</label>
                <input class="w3-input w3-border w3-round-large" type="number" id="adults" name="adults" value="<?php echo htmlspecialchars($_POST['adults'] ?? 1); ?>" min="1" max="4" required style="padding: 8px; width: 60%; font-size: 18px; margin: 10px auto;">
            </div>

            <div class="w3-padding-32 w3-center">
                <label for="children" class="w3-text-dark-grey" style="font-size: 20px; font-weight: bold;"><i class="fa fa-child w3-text-dark-grey"></i> Sengeplasser Barn</label>
                <input class="w3-input w3-border w3-round-large" type="number" id="children" name="children" value="<?php echo htmlspecialchars($_POST['children'] ?? 0); ?>" min="0" max="4" required style="padding: 8px; width: 60%; font-size: 18px; margin: 10px auto;">
            </div>

            <div class="w3-padding-32 w3-center">
                <button class="w3-button w3-block w3-red w3-large w3-round-large" type="submit" style="padding: 12px; font-weight: bold; font-size: 18px;">Finn Rom</button>
            </div>
        
        </form>

    </div>
</div>

<!-- Linje under 'Finn Rom' knappen -->
<hr style="border: 1px solid #000000; margin: 20px 0;">

<!-- Tilgjengelige Rom Seksjon -->
<div id="rooms">
    <?php 
    # Sørg for at skjemaet er sendt og at input er tilgjengelig
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adults'], $_POST['children'])) {

        $adults = (int)$_POST['adults'];
        $children = (int)$_POST['children'];

        # Logikk for romfiltrering
        $rooms = [
            ["id" => 1, "image" => "./public/images/enkeltrom.jpg", "title" => "'Enkeltrom", "description" => "Enkelt seng, 15m2", "type" => "enkeltrom"],
            ["id" => 2, "image" => "./public/images/dobbeltrom.jpg", "title" => "Dobbeltrom", "description" => "Queen-size seng, 25m2", "type" => "dobbeltrom"],
            ["id" => 3, "image" => "./public/images/juniorsuite.jpg", "title" => "Junior Suite", "description" => "King-size seng, 40m2", "type" => "juniorsuite"]
        ];

        $filtered_rooms = [];

        # Logikk for romfiltrering basert på voksne og barn
        if ($adults === 1 && $children <= 0) {
            # 1 voksen og 0 barn eller færre, vis kun enkeltrom
            $filtered_rooms = array_filter($rooms, fn($room) => $room['type'] === 'enkeltrom');
        } elseif (($adults === 1 && $children >= 1) || ($adults === 2 && $children <= 2)) {
            # 1 voksen og 2 barn eller 2 voksne og 2 barn, vis dobbeltrom eller juniorsuite
            $filtered_rooms = array_filter($rooms, fn($room) => in_array($room['type'], ['dobbeltrom', 'juniorsuite']));
        } elseif ($adults > 2 || $children > 2) {
            # Mer enn 2 voksne eller barn, vis kun juniorsuite
            $filtered_rooms = array_filter($rooms, fn($room) => $room['type'] === 'juniorsuite');
        }

        # Hvis ingen rom passer, vis en melding
        if (empty($filtered_rooms)) {
            echo '<p class="w3-text-red">Fant ingen rom som samsvarer med dine kriterier.</p>';
        } else {
            # Inkluder romkort når du søker
            echo '<div class="w3-row w3-row-padding">';
            foreach ($filtered_rooms as $room) {
                include 'includes/room_card.php';
            }
            echo '</div>';
        }
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Auto scroll til rom etter søk
document.querySelector('form').onsubmit = function() {
    // Smooth scroll til romseksjonen
    document.getElementById('rooms').scrollIntoView({behavior: 'smooth'});
};
</script>
