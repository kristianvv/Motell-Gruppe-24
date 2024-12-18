<?php include '../includes/navbar.php'; ?>
<?php require '../includes/authorize_admin.php'; ?>

<div class="w3-container w3-center" style="margin-top: 50px;">
    <!-- Admin Administration Box -->
    <div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 300px; padding: 20px; border-radius: 8px;">
        <i class="fa fa-user-circle w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>
        <h3>Brukeradministrasjon</h3>
        <a href="admin_administration.php" class="w3-button w3-red w3-margin-top">Gå til brukeradministrasjon</a>
    </div>

    <!-- Room Overview Box -->
    <div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 300px; padding: 20px; border-radius: 8px;">
        <i class="fa fa-building w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>
        <h3>Romoversikt</h3>
        <a href="room_overview.php" class="w3-button w3-red w3-margin-top">Se rom</a>
    </div>

    <!-- Booking Overview Box -->
    <div class="w3-card w3-white w3-hover-shadow" style="display: inline-block; margin: 20px; width: 300px; padding: 20px; border-radius: 8px;">
        <i class="fa fa-calendar-check-o w3-text-red" style="font-size: 50px; margin-bottom: 16px;"></i>
        <h3>Bestillingsoversikt</h3>
        <a href="booking_overview.php" class="w3-button w3-red w3-margin-top">Se bestillinger</a>
</div>