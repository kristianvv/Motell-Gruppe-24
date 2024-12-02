<?php

session_start();

?>

<div class="w3-third w3-margin-bottom">
    <img src="<?php echo htmlspecialchars($room['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($room['title'] ?? 'Rom Bilde'); ?>" style="width:100%">
    <div class="w3-container w3-white">
        <h3><?php echo htmlspecialchars($room['title'] ?? 'Rom Tittel'); ?></h3>
        <p><?php echo htmlspecialchars($room['description'] ?? 'Ingen beskrivelse.'); ?></p>
        <p class="w3-large">
            <i class="fa fa-bath"></i> 
            <i class="fa fa-phone"></i> 
            <i class="fa fa-wifi"></i>
        </p>

        <!-- Debugging: Show room type to check if it's being set correctly -->
        <p>Room Type: <?php echo htmlspecialchars(trim(strtolower($room['type'] ?? 'Ingen romtype er satt'))); ?></p>

        <?php
        $roomType = strtolower(trim($room['type'] ?? ''));

        # max capasitet på rom.
        $maxCapacity = '';
        switch ($roomType) {
            case 'enkeltrom':
                $maxCapacity = 'Maksimalt 1 voksen, ingen barn';
                break;
            case 'dobbeltrom':
                $maxCapacity = 'Maksimalt 2 voksne, 2 barn';
                break;
            case 'juniorsuite':
                $maxCapacity = 'Maksimalt 4 voksne, 4 barn';
                break;
            default:
                $maxCapacity = 'Ukjent kapasitet';
                break;
        }
        ?>

        <p><strong><?php echo htmlspecialchars($maxCapacity); ?></strong></p>
        <a href="views/room_details.php?roomId=<?php echo urlencode($room['id']); ?>&title=<?php echo urlencode($room['title']); ?>&description=<?php echo urlencode($room['description']); ?>&image=<?php echo urlencode($room['image']); ?>&roomType=<?php echo urlencode($room['type'] ?? 'Standard'); ?>" class="w3-button w3-block w3-black w3-margin-bottom">Velg rom</a>
    </div>
</div>