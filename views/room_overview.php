<?php include('../includes/dir_navbar.php'); ?>

<?php require('../includes/authorize_admin.php'); ?>

<?php include '../includes/dbconnect.inc.php'; ?>

<?php include '../classes/Room.php'; $rooms = Room::get_all_rooms($pdo); ?>

<div class="w3-content" style="max-width:1200px; margin: 20px auto;">
    <header class="w3-container w3-center w3-padding-32 w3-red">
        <h2>Room Overview</h2>
        <p>Here you can view all rooms and their details</p>
    </header>

    <?php if (!empty($rooms)) : ?>
        <div class="w3-row-padding">
            <?php foreach ($rooms as $index => $room) : ?>
                <!-- Start a new row for every 5 rooms -->
                <?php if ($index % 3 == 0 && $index != 0) : ?>
                    </div><div class="w3-row-padding w3-margin-top">
                <?php endif; ?>

                <!-- Room card -->
                <div class="w3-col l4 m6 s12 w3-padding">
                    <div class="w3-card w3-white w3-padding">
                        <h3 class="w3-text-red">Room Details</h3>
                        <p><strong>Room Number:</strong> <?php echo $room->getRoomID(); ?></p>
                        <p><strong>Room Type:</strong> <?php echo $room->getRoomType(); ?></p>
                        <p><strong>Max Adults:</strong> <?php echo $room->getNrAdults(); ?></p>
                        <p><strong>Max Children:</strong> <?php echo $room->getNrChildren(); ?></p>
                        <p>
                            <strong>Description:</strong> 
                            <?php
                            $description = $room->getDescription();
                            if (strlen($description) > 200) {
                                echo htmlspecialchars(substr($description, 0, 200)) . '...';
                                echo '<a href="edit_room.php?roomID=' . $room->getRoomID() . '" class="w3-text-blue"> Read More</a>';
                            } else {
                                echo htmlspecialchars($description);
                            }
                            ?>
                        </p>
                        <p><strong>Price per Night:</strong> <?php echo $room->getPrice(); ?> NOK</p>
                        <a href="edit_room.php?roomID=<?php echo $room->getRoomID(); ?>" class="w3-button w3-red w3-round w3-small">Edit</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="w3-container w3-center w3-padding-32">
            <p>No rooms found</p>
        </div>
    <?php endif; ?>
</div>
