<?php
include '../includes/dbconnect.inc.php';  // Inkluderer databaseforbindelsen
include '../includes/navbar.php';         // Inkluderer navigasjonsmenyen
include '../classes/Room.php';

// Sørg for at brukeren er logget inn
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<p class="w3-text-red">Du må være logget inn for å booke et rom.</p>';  // Viser melding hvis brukeren ikke er logget inn
    exit;  // Stopper videre scriptutførelse
}

$userId = $_SESSION['user_id'];  // Henter bruker-ID fra sesjonen

// Hent romdetaljer fra POST- eller GET-forespørselen
$roomType = htmlspecialchars($_POST['roomType'] ?? ($_GET['roomType'] ?? 'enkeltrom'));  // Standard romtype er "enkeltrom"
$checkin = htmlspecialchars($_POST['checkin'] ?? ($_GET['checkin'] ?? ''));  // Innsjekkingsdato
$checkout = htmlspecialchars($_POST['checkout'] ?? ($_GET['checkout'] ?? ''));  // Utsjekkingsdato

// Definer romnumre basert på databasekonfigurasjon
$roomRanges = [
    'enkeltrom' => range(1, 10),  // Rom 1 til 10
    'dobbeltrom' => range(11, 20),  // Rom 11 til 20
    'juniorsuite' => range(21, 25)  // Rom 21 til 25
];

// Valider romtype
if (!array_key_exists($roomType, $roomRanges)) {
    echo '<p class="w3-text-red">Invalid room type: ' . htmlspecialchars($roomType) . '</p>';
    exit;
}

$roomIds = $roomRanges[$roomType];  // Henter listen over tilgjengelige rom-ID-er for den valgte romtypen

// Valider innsjekkings- og utsjekkingsdatoer
if (empty($checkin) || empty($checkout)) {
    echo '<p class="w3-text-red">Både check-in og check-out datoer er nødvendig.</p>';  // Feilmelding ved manglende datoer
    exit;
}

$currentDate = new DateTime();  // Henter dagens dato
if (new DateTime($checkin) < $currentDate || new DateTime($checkout) <= new DateTime($checkin)) {
    echo '<p class="w3-text-red">Feil dato. Check-in må være i framtiden, og check-out må være etter check-in.</p>';  // Feilmelding ved ugyldige datoer
    exit;
}

// Sett standardbilde basert på romtypen
$image = '/public/images/' . $roomType . '.jpg';  // Genererer bildesti dynamisk

// Prøv å booke rommet ved å sjekke tilgjengelighet
$bookingSuccessful = false;

foreach ($roomIds as $roomId) {
    // Sjekk om rommet er tilgjengelig via admin og brukerdatoer
    $isRoomAvailable = Room::is_room_available($pdo, $roomId, $checkin, $checkout);

    if ($isRoomAvailable) {
        // Sjekk om rommet allerede er booket i perioden
        $stmt = $pdo->prepare("SELECT * FROM Booking WHERE roomID = :roomID AND checkInDate < :checkout AND checkOutDate > :checkin");
        $stmt->execute([
            ':roomID' => $roomId,
            ':checkin' => $checkin,
            ':checkout' => $checkout
        ]);

        $existingBooking = $stmt->fetch();  // Hent eksisterende booking

        if (!$existingBooking) {
            // Hvis rommet er ledig, gjennomfør booking
            $stmt = $pdo->prepare("INSERT INTO Booking (roomID, userID, checkInDate, checkOutDate)
                                   VALUES (:roomID, :userID, :checkin, :checkout)");
            $stmt->execute([
                ':roomID' => $roomId,
                ':userID' => $userId,
                ':checkin' => $checkin,
                ':checkout' => $checkout
            ]);

            // Hent booking-ID fra databasen
            $bookingId = $pdo->lastInsertId();

            // Omdiriger til bekreftelsessiden med bookingdetaljer
            header("Location: ../views/booking_confirmed.php?bookingId=" . urlencode($bookingId) . "&roomId=" . urlencode($roomId) . "&checkin=" . urlencode($checkin) . "&checkout=" . urlencode($checkout) . "&image=" . urlencode($image));
            exit;  // Stopp scriptutførelse etter omdirigering

            $bookingSuccessful = true;  // Marker at booking var vellykket
            break;  // Avslutt loopen etter vellykket booking
        }
    }
}

// Hvis booking feilet, omdiriger tilbake til romdetaljsiden med en feilmelding
if (!$bookingSuccessful) {
    header("Location: ../views/room_details.php?roomType=" . urlencode($roomType) . "&checkin=" . urlencode($checkin) . "&checkout=" . urlencode($checkout) . "&image=" . urlencode($image) . "&bookingFailed=1");
    exit;  // Stopp scriptutførelse her
}
?>
