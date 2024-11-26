<?php include '../includes/dir_navbar.php'; ?>

<?php include '../includes/authorize_admin.php'; ?>

<?php
    require '../includes/dbconnect.inc.php';
    require '../classes/Room.php';

    if (isset($_GET['roomID'])) {
        $roomID = trim(htmlspecialchars($_GET['roomID']));
        $current_room = Room::get_room_by_id($roomID, $pdo);
    } else {
        //redirect with error message
        header("Location: room_overview.php?message=No room selected");
        exit;
    }

?>

<?php if ($current_room) : ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <header class="w3-container w3-center w3-padding-32 w3-red">
            <h1>Edit Room</h1>
            <h3>Here you can edit the details of room number: <?php echo htmlspecialchars($roomID)?></h3>
        </header>

        <form class="w3-container" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
            <label for="roomType">Room Type</label>
            <input class="w3-input" type="text" name="roomType" value="<?php echo $current_room->getRoomType(); ?>">

            <label for="nrAdults">Max Adults</label>
            <input class="w3-input" type="number" name="nrAdults" value="<?php echo $current_room->getNrAdults(); ?>">

            <label for="nrChildren">Max Children</label>
            <input class="w3-input" type="number" name="nrChildren" value="<?php echo $current_room->getNrChildren(); ?>">

            <label for="description">Room description</label>
            <input class="w3-input" type="text" name="description" value="<?php echo $current_room->getDescription(); ?>">

            <label for="price">Price per Night</label>
            <input class="w3-input" type="number" name="price" value="<?php echo $current_room->getPrice(); ?>">

            <button class="w3-button w3-red w3-section" type="submit">Save Changes</button>
        </form>
<?php endif ?>

<?php

    require '../includes/validator.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Sanitize input data
        foreach ($_POST as &$posts) {
            $posts = trim(htmlspecialchars($posts));
        }
        //Om feltene er redigete, oppdateres de. Hvis ikke, beholdes de gamle verdiene
        $roomType = validator::validate_room_attributes($_POST['roomType'], 'roomType') ? $_POST['roomType'] : $current_room->getRoomType();
        $nrAdults = validator::validate_room_attributes($_POST['nrAdults'], 'nrAdults') ? $_POST['nrAdults'] : $current_room->getNrAdults();
        $nrChildren = validator::validate_room_attributes($_POST['nrChildren'], 'nrChildren') ? $_POST['nrChildren'] : $current_room->getNrChildren();
        $description = validator::validate_room_attributes($_POST['description'], 'description') ? $_POST['description'] : $current_room->getDescription();
        $price = validator::validate_room_attributes($_POST['price'], 'price') ? $_POST['price'] : $current_room->getPrice();

        $new_room = new Room($roomID, $roomType, $nrAdults, $nrChildren, $description, $price);
        $new_room->save($pdo);
        
        echo "<p style='color: green;'>Room updated successfully</p>";
    }

?>

