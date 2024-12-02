<?php
include '../includes/navbar.php';
require '../includes/authorize_admin.php';
require '../includes/dbconnect.inc.php';
require '../classes/Room.php';

$roomID = trim(htmlspecialchars($_GET['roomID']));

if (!$roomID) {
    header("Location: room_overview.php");
    exit();
}

$current_room = Room::get_room_by_id($roomID, $pdo);


if ($current_room) : ?>
    <div class="w3-content" style="max-width:600px; margin: 20px auto;">
            <h4>Legg til Utillgjengelighet: <?php echo htmlspecialchars($roomID)?></h4>
        </header>

        <form class="w3-container" action="" method="POST">
            <input type="hidden" name="roomID" value="<?php echo $roomID; ?>">
            <label for="fromDate">Utillgjengelig fra</label>
            <input class="w3-input" type="date" name="fromDate" required>

            <label for="toDate">Utillgjengelig til</label>
            <input class="w3-input" type="date" name="toDate" required>

            <label for="description">Description</label>
            <textarea class="w3-input" name="description" rows="4" placeholder="Beskriv årsaken for utilgjengeligheten"></textarea>

            <button class="w3-button w3-red w3-section" type="submit">Gjør Utillgjengelig</button>
        </form>
    </div>
</div>
<?php else :?>
    <div class="w3-content" style="max-width:600px; margin: 20px auto;">
        <h4>Fant ikke det forespurte rommet</h4>
    </div>
<?php endif; 


if (isset($_POST['fromDate']) && isset($_POST['toDate'])) {
    $fromDate = trim(htmlspecialchars($_POST['fromDate']));
    $toDate = trim(htmlspecialchars($_POST['toDate']));
    $description = empty(trim($_POST['description'])) ? 'N/A' : trim(htmlspecialchars($_POST['description']));

    if (!$fromDate || !$toDate) {
        header("Location: room_unavailable.php?roomID=$roomID&message=Vennligst fyll ut alle feltene");
        exit();
    }

    if ($fromDate > $toDate or $fromDate < date('Y-m-d')) {
        header("Location: room_unavailable.php?roomID=$roomID&message=Datoenene kan ikke være i fortiden, og sluttdatoen kan ikke være før startdatoen");
        exit();
    }

    $result = $current_room->make_unavailable($pdo, $fromDate, $toDate, $description);

    if ($result) {
        header("Location: room_unavailable.php?roomID=$roomID&message=Utillgjengelighet lagt til");
        exit();
    } else {
        header("Location: room_unavailable.php?roomID=$roomID&message=Kunne ikke legge til utillgjengelighet");
        exit();
    }
}