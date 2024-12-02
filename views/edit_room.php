<?php include '../includes/navbar.php'; ?>

<?php include '../includes/authorize_admin.php'; ?>

<?php
    require '../includes/dbconnect.inc.php';
    require '../classes/Room.php';

    //Set error reporting
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);

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
            <h1>Rediger romdetaljer</h1>
            <h3>Her kan du endre romdetaljer og utilgjengelighet for rom nummer <?php echo htmlspecialchars($roomID)?></h3>
        </header>

        <!-- Back Button -->
        <a href="room_overview.php" class="w3-button w3-blue w3-margin-bottom">Tilbake</a>

        <form class="w3-container" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
            <label for="roomType">Romtype</la>
                <select class="w3-select" name="roomType">
                    <option value="Enkeltrom" <?php echo ($current_room->getRoomType() == 'Enkeltrom') ? 'selected' : ''; ?>>Enkeltrom</option>
                    <option value="Dobbeltrom" <?php echo ($current_room->getRoomType() == 'Dobbeltrom') ? 'selected' : ''; ?>>Dobbeltrom</option>
                    <option value="Juniorsuite" <?php echo ($current_room->getRoomType() == 'Juniorsuite') ? 'selected' : ''; ?>>Juniorsuite</option>
                </select>

            <label for="nrAdults">Sengeplasser voksne</label>
            <input class="w3-input" type="number" name="nrAdults" value="<?php echo $current_room->getNrAdults(); ?>">

            <label for="nrChildren">Sengeplasser barn</label>
            <input class="w3-input" type="number" name="nrChildren" value="<?php echo $current_room->getNrChildren(); ?>">

            <label for="description">Rombeskrivelse</label>
            <textarea class="w3-input" name="description" rows="4" placeholder="Enter a detailed room description"><?php echo $current_room->getDescription(); ?></textarea>

            <label for="price">Pris per natt</label>
            <input class="w3-input" type="number" name="price" value="<?php echo $current_room->getPrice(); ?>">
            

            <button class="w3-button w3-red w3-section" type="submit">Lagre endringer</button>
        </form>

    </div>
</div>


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

