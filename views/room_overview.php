<?php include ('../includes/dir_navbar.php'); ?>

<?php //require ('../includes/authorize_admin.php'); ?>

<?php include '../includes/dbconnect.inc.php'; ?>

<?php include '../classes/Room.php'; $rooms = Room::get_all_rooms($pdo);?>

<?php if (Room::get_all_rooms($pdo)) : ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <header class="w3-container w3-center w3-padding-32 w3-red">
            <h2>Room Overview</h2>
            <p>Here you can view all rooms and their details</p>
        </header>

        <?php foreach ($rooms as $room) : ?>
        <div class="w3-row-padding">
            <div class="w3-half w3-padding-large w3-white">
                <h3>Room Details</h3>
                <p><strong>Room Number:</strong> <?php echo $room->getRoomID(); ?></p>
                <p><strong>Room Type:</strong> <?php echo $room->getRoomType(); ?></p>
                <p><strong>Max Adults:</strong> <?php echo $room->getNrAdults(); ?></p>
                <p><strong>Max Children:</strong> <?php echo $room->getNrChildren(); ?></p>
                <p><strong>Room Attributes:</strong> <?php echo $room->getDescription(); ?></p>
                <p><strong>Price per Night:</strong> <?php echo $room->getPrice(); ?></p>
                <p><strong>Edit Room Attributes:</strong> <a href="edit_room.php?roomID=<?php echo $room->getRoomID(); ?>">Edit</a></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <header class="w3-container w3-center w3-padding-32 w3-red">
            <h2>Room Overview</h2>
            <p>No rooms found</p>
        </header>
    </div>
<?php endif; ?>
