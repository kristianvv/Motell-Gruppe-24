<?php include '../includes/navbar.php'; ?>
<?php require '../includes/authorize_admin.php'; ?>
<?php require '../includes/dbconnect.inc.php'; ?>
<?php require '../classes/Room.php';?>

<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    if (isset($_GET['roomID'])) {
        $roomID = $_GET['roomID'];
        $availability = Room::get_room_availability($pdo, $roomID);
    } else {
        header("Location: room_overview.php");
        exit();
    }
?>

<?php if ($availability): ?>
    <div class="w3-content" style="max-width:1200px; margin: 20px auto;">
        <header class="w3-container w3-center w3-padding-32 w3-red">
            <h1>Room unavailability</h1>
            <h3>Here you can view the unavailability of room number: <?php echo htmlspecialchars($roomID)?></h3>
        </header>

        <?php
            if (isset($_GET['message'])) {
                echo '<p class="w3-text-red">' . trim(htmlspecialchars($_GET['message'])) . '</p>';
            }
        ?>

        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
                <th>Unavailable from</th>
                <th>Unavailable to</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($availability as $date) : ?>
                <tr>
                    <td><?php echo $date['fromDate']; ?></td>
                    <td><?php echo $date['toDate']; ?></td>
                    <td><?php echo $date['description']?></td>
                    <td>
                        <form action="../includes/delete_unavailability.php" method="POST">
                            <input type="hidden" name="fromDate" value="<?php echo $date['fromDate']; ?>">
                            <input type="hidden" name="toDate" value="<?php echo $date['toDate']; ?>">
                            <input type="hidden" name="roomID" value="<?php echo $roomID; ?>">
                            <button type="submit" class="w3-button w3-red">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>