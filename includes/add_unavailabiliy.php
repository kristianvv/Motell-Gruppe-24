
<?php
require 'authorize_admin.php';
require 'dbconnect.inc.php';
require '../classes/Room.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $roomID = trim(htmlspecialchars($_POST['roomID']));
    $current_room = Room::get_room_by_id($roomID, $pdo);

    if (isset($_POST['fromDate']) && isset($_POST['toDate'])) {
        $fromDate = trim(htmlspecialchars($_POST['fromDate']));
        $toDate = trim(htmlspecialchars($_POST['toDate']));
        $description = empty(trim($_POST['description'])) ? 'N/A' : trim(htmlspecialchars($_POST['description']));

        $result = $current_room->make_unavailable($pdo, $fromDate, $toDate, $description);

        if ($result) {
            header("Location: room_unavailable.php?roomID=$roomID&message=Utilgjengelighet for rom $roomID lagt til");
            exit();
        } else {
            header("Location: room_unavailable.php?roomID=$roomID&message=Kunne ikke legge til utilgjengelighet");
            exit();
        }
    }

    if (Room::is_room_available($pdo, $fromDate, $toDate, $roomID)) {
        header("Location: room_unavailable.php?roomID=$roomID&message=Rommet er allerede utilgjengelig i denne perioden");
        exit();
    }


}
?>