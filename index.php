<?php 

include 'includes/header.php'; ?>

<!-- Header with background image -->
<header class="w3-display-container w3-content" style="max-width:1500px;">
    <img class="w3-image" src="./public/images/bg-hotel.jpg" alt="The Hotel" style="min-width:1000px" width="1500" height="800">
    <div class="w3-display-left w3-padding w3-col l6 m8">
        <div class="w3-container w3-red">
            <h2><i class="fa fa-bed w3-margin-right"></i>Le Fabuleux Motel</h2>
        </div>
        <div class="w3-container w3-white w3-padding-16">
            <form action="/action_page.php" target="_blank">
                <!-- Check-in, Check-out, and guest selection form -->
                <?php include 'includes/room_filter.php'; ?>
            </form>
        </div>
    </div>
</header>

<!-- Room Cards Section -->
<div class="w3-content" style="max-width:1532px;">
    <div class="w3-container w3-margin-top" id="rooms">
        <h3>Rooms</h3>
        <p>Make yourself at home is our slogan. We offer the best beds in the industry. Sleep well and rest well.</p>
    </div>
    <div class="w3-row-padding w3-padding-16">
        <?php 
            // Sample room data. In a real scenario, this could come from a database.
            $rooms = [
                ["image" => "./public/images/single-room.jpg", "title" => "Single Room", "price" => "$99", "description" => "Single bed, 15m2"],
                ["image" => "./public/images/double-room.jpg", "title" => "Double Room", "price" => "$149", "description" => "Queen-size bed, 25m2"],
                ["image" => "./public/images/deluxe-room.jpg", "title" => "Deluxe Room", "price" => "$199", "description" => "King-size bed, 40m2"]
            ];
            
            foreach($rooms as $room) {
                include 'includes/room_card.php';
            }
        ?>
    </div>
</div>

<!-- Include the footer -->
<?php include 'includes/footer.php'; ?>