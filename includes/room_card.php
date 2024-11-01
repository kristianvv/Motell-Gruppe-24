<div class="w3-third w3-margin-bottom">
    <img src="<?php echo htmlspecialchars($room['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($room['title'] ?? 'Room Image'); ?>" style="width:100%">
    <div class="w3-container w3-white">
        <h3><?php echo htmlspecialchars($room['title'] ?? 'Room Title'); ?></h3>
        <h6 class="w3-opacity">From <?php echo htmlspecialchars($room['price'] ?? 'N/A'); ?></h6>
        <p><?php echo htmlspecialchars($room['description'] ?? 'No description available.'); ?></p>
        <p class="w3-large">
            <i class="fa fa-bath"></i> 
            <i class="fa fa-phone"></i> 
            <i class="fa fa-wifi"></i>
        </p>
        <a href="/views/room_details.php?roomId=<?php echo htmlspecialchars($room['id'] ?? ''); ?>&title=<?php echo urlencode($room['title']); ?>&description=<?php echo urlencode($room['description']); ?>&image=<?php echo urlencode($room['image']); ?>&price=<?php echo urlencode($room['price']); ?>&roomType=Standard&nrAdults=2&nrChildren=0&roomAttributes=WiFi,Pool" class="w3-button w3-block w3-black w3-margin-bottom">Choose Room</a>
    </div>
</div>
