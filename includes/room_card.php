<!-- includes/room_card.php -->
<div class="w3-third w3-margin-bottom">
    <img src="<?php echo $room['image']; ?>" alt="<?php echo $room['title']; ?>" style="width:100%">
    <div class="w3-container w3-white">
        <h3><?php echo $room['title']; ?></h3>
        <h6 class="w3-opacity">From <?php echo $room['price']; ?></h6>
        <p><?php echo $room['description']; ?></p>
        <p class="w3-large">
            <i class="fa fa-bath"></i> 
            <i class="fa fa-phone"></i> 
            <i class="fa fa-wifi"></i>
        </p>
        <button class="w3-button w3-block w3-black w3-margin-bottom">Choose Room</button>
    </div>
</div>
