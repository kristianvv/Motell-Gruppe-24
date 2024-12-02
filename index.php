<?php include 'includes/navbar.php';?>

<!-- Header with background image -->
<header class="w3-display-container w3-content" style="max-width:1500px;">
    <img class="w3-image" src="./public/images/bg-hotel.jpg" alt="The Hotel" style="min-width:1000px" width="1500" height="800">
    <div class="w3-display-left w3-padding w3-col l6 m8">
        <div class="w3-container w3-red">
            <h2><i class="fa fa-bed w3-margin-right"></i>Le Fabuleux Motel</h2>
        </div>
        <div class="w3-container w3-white w3-padding-16">
            <?php if (isset($_SESSION['user_role'])): ?>
                <form method="post" action="">
                    <!-- Check-in, Check-out, and guest selection form -->
                    <?php include 'includes/room_filter.php'; ?>
                </form>
            <?php else: ?>
                <p>You must be logged in to book a room.</p>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Room Cards Section -->
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adults'], $_POST['children'])): ?>
<div class="w3-content" style="max-width:1532px;">
    <div class="w3-container w3-margin-top" id="rooms">
        <h3>Available Rooms</h3>
        <p>Make yourself at home is our slogan. We offer the best beds in the industry. Sleep well and rest well.</p>
    </div>
    <div class="w3-row-padding w3-padding-16">
        <?php 
            $adults = (int)$_POST['adults'];
            $children = (int)$_POST['children'];

            // Room filtering logic
            $rooms = [
                ["id" => 1, "image" => "./public/images/enkeltrom.jpg", "title" => "Single Room", "price" => "$99", "description" => "Single bed, 15m2", "type" => "enkeltrom"],
                ["id" => 2, "image" => "./public/images/dobbeltrom.jpg", "title" => "Double Room", "price" => "$149", "description" => "Queen-size bed, 25m2", "type" => "dobbeltrom"],
                ["id" => 3, "image" => "./public/images/juniorsuite.jpg", "title" => "Junior Suite", "price" => "$199", "description" => "King-size bed, 40m2", "type" => "juniorsuite"]
            ];

            $filtered_rooms = [];

            if ($adults === 1 && $children <= 1) {
                $filtered_rooms = array_filter($rooms, fn($room) => $room['type'] === 'enkeltrom');
            } elseif ($adults === 2 && $children <= 2) {
                $filtered_rooms = array_filter($rooms, fn($room) => in_array($room['type'], ['dobbeltrom', 'juniorsuite']));
            } elseif ($adults > 2 || $children > 2) {
                $filtered_rooms = array_filter($rooms, fn($room) => $room['type'] === 'juniorsuite');
            }

            if (empty($filtered_rooms)) {
                echo '<p>No rooms match your criteria. Please adjust your search.</p>';
            } else {
                foreach ($filtered_rooms as $room) {
                    include 'includes/room_card.php';
                }
            }
        ?>
    </div>
</div>
<?php endif; ?>

<!-- Include the footer -->
<?php include 'includes/footer.php'; ?>