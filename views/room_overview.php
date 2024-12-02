<?php include('../includes/navbar.php'); ?>

<?php require('../includes/authorize_admin.php'); ?>

<?php include '../includes/dbconnect.inc.php'; ?>

<?php include '../classes/Room.php'; $rooms = Room::get_all_rooms($pdo); ?>

<div class="w3-content" style="max-width:1200px; margin: 20px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red">
        <h2>Romoversikt</h2>
        <p>Her kan du se alle rom og detaljer</p>
    </header>

    <?php if (!empty($rooms)) : ?>
        <div class="w3-row-padding">
            <?php foreach ($rooms as $index => $room) : ?>
                <!-- Starter ny rad for hvert tredje rom -->
                <?php if ($index % 3 == 0 && $index != 0) : ?>
                    </div><div class="w3-row-padding w3-margin-top">
                <?php endif; ?>

                <!-- Rom -->
                <div class="w3-col l4 m6 s12 w3-padding">
                    <div class="w3-card w3-white w3-padding">
                        <h3 class="w3-text-red">Romdetaljer</h3>
                        <p><strong>Romnummer: </strong> <?php echo $room->getRoomID(); ?></p>
                        <p><strong>Romtype: </strong> <?php echo $room->getRoomType(); ?></p>
                        <p><strong>Sengeplasser voksne: </strong> <?php echo $room->getNrAdults(); ?></p>
                        <p><strong>Sengeplasser barn: </strong> <?php echo $room->getNrChildren(); ?></p>
                        <p>
                            <strong>Description:</strong> 
                            <?php
                            $description = $room->getDescription();

                            //Hvis beskrivelsen er lengre enn 200 tegn, viser vi bare de første 200 tegnene
                            if (strlen($description) > 200) {
                                echo htmlspecialchars(substr($description, 0, 200)) . '...';
                                echo '<a href="edit_room.php?roomID=' . $room->getRoomID() . '" class="w3-text-blue"> Read More</a>';
                            } else {
                                echo htmlspecialchars($description);
                            }
                            ?>
                        </p>
                        <p><strong>Pris per natt:</strong> <?php echo $room->getPrice(); ?> NOK</p>
                        <a href="edit_room.php?roomID=<?php echo $room->getRoomID(); ?>" class="w3-button w3-red w3-round w3-small">Rediger</a>
                        <a href="room_unavailable.php?roomID=<?php echo $room->getRoomID(); ?>" class="w3-button w3-red w3-round w3-small">Se utilgjengelighet</a>
                        <a href="room_add_unavailable.php?roomID=<?php echo $room->getRoomID(); ?>" class="w3-button w3-red w3-round w3-small">Endre utilgjengelighet</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="w3-container w3-center w3-padding-32">
            <p>Ingen rom funnet</p>
        </div>
    <?php endif; ?>
</div>
