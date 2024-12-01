<?php
include '../includes/dbconnect.inc.php';  // Koble til databasen
include '../includes/navbar.php';         // Inkluder navigasjonsbaren

// Hent romdetaljer fra GET-parameterne (i tilfelle omdirigering etter booking)
$roomType = htmlspecialchars($_GET['roomType'] ?? 'enkeltrom');  // Velg romtype, standard er 'enkeltrom'
$checkin = htmlspecialchars($_GET['checkin'] ?? '');  // Hent innsjekkingsdato
$checkout = htmlspecialchars($_GET['checkout'] ?? '');  // Hent utsjekkingsdato
$image = htmlspecialchars($_GET['image'] ?? 'public/images/default.jpg');  // Hent bilde, standard er default-bildet
$image = '/' . ltrim($image, '/');  // Sørg for at bildet starter fra rotkatalogen
$bookingFailed = isset($_GET['bookingFailed']) ? (int)$_GET['bookingFailed'] : 0;  // Hvis bestillingen mislyktes, vis en feilmelding
?>

<div class="w3-content" style="max-width:1200px; margin: 100px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red" style="border-radius: 8px; padding: 20px;">
        <h2>Book et rom</h2>  <!-- Tittel for bookingseksjonen -->
        <p>Vennligst velg romtype og datoene for booking.</p>  <!-- Forklaringstekst -->
    </header>

    <div class="w3-row-padding" style="margin-top: 40px;">
        <!-- Seksjon for rombilde -->
        <div class="w3-half">
            <img src="<?php echo $image; ?>" alt="Room Image" style="width:100%; margin-top: 20px; border-radius: 8px;">
        </div>

        <!-- Seksjon for bookingformular -->
        <div class="w3-half">
            <div class="w3-card w3-white w3-hover-shadow" style="margin-top: 20px; padding: 30px; border-radius: 8px; height: 381px;"> <!-- Økt høyde med 20px -->
                <h3>Romdetaljer</h3>  <!-- Tittel for romdetaljer -->
                <p><strong>Romtype:</strong> <?php echo htmlspecialchars($roomType); ?></p>  <!-- Vis romtype -->

                <!-- Bookingformular -->
                <form method="POST" action="/includes/process_booking.php" onsubmit="return validateDates()">
                    <input type="hidden" name="roomType" value="<?php echo htmlspecialchars($roomType); ?>"> <!-- Skjult felt for romtype -->

                    <div class="w3-margin-top" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                        <label for="checkin">Innsjekkingsdato:</label>
                        <input type="date" id="checkin" name="checkin" class="w3-input w3-border" value="<?php echo htmlspecialchars($checkin); ?>" required style="border-radius: 8px; height: 35px;">
                    </div>
                    <div class="w3-margin-top" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                        <label for="checkout">Utsjekkingsdato:</label>
                        <input type="date" id="checkout" name="checkout" class="w3-input w3-border" value="<?php echo htmlspecialchars($checkout); ?>" required style="border-radius: 8px; height: 35px;">
                    </div>
                    <button type="submit" class="w3-button w3-red w3-margin-top" style="border-radius: 8px; padding: 10px 20px;">Book dette rommet</button>
                </form>

                <!-- Vis melding hvis ingen rom er tilgjengelig (popup når booking feiler) -->
                <?php if ($bookingFailed): ?>
                    <div id="noRoomsModal" class="w3-modal" style="display: block;">
                        <div class="w3-modal-content w3-animate-top">
                            <header class="w3-container w3-red">
                                <span onclick="document.getElementById('noRoomsModal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                <h2>Ingen rom tilgjengelig</h2>
                            </header>
                            <div class="w3-container">
                                <p>Ingen rom er tilgjengelige for den valgte typen og datoene. Vennligst prøv med andre datoer eller romtype.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
// Funksjon for å validere at utsjekkingsdato er etter innsjekkingsdato, og at innsjekkingsdato er i fremtiden
function validateDates() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;

    // Sjekk at utsjekkingsdato er etter innsjekkingsdato
    if (new Date(checkin) >= new Date(checkout)) {
        alert('Utsjekkingsdato må være senere enn innsjekkingsdato.');
        return false;
    }

    // Sjekk at innsjekkingsdato er i fremtiden
    if (new Date(checkin) < new Date()) {
        alert('Innsjekkingsdato må være i fremtiden.');
        return false;
    }

    return true;
}
</script>
