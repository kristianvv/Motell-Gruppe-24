<?php
// Retrieve previous values if they exist
$check_in = htmlspecialchars($_POST['check_in'] ?? '');
$check_out = htmlspecialchars($_POST['check_out'] ?? '');
$adults = htmlspecialchars($_POST['adults'] ?? 1);
$children = htmlspecialchars($_POST['children'] ?? 0);
?>

<form action="" method="post">
    <div class="w3-row-padding">
        <div class="w3-col m3">
            <label><i class="fa fa-calendar-o"></i> Check In</label>
            <input class="w3-input w3-border" type="date" name="check_in" value="<?php echo $check_in; ?>" required>
        </div>
        <div class="w3-col m3">
            <label><i class="fa fa-calendar-o"></i> Check Out</label>
            <input class="w3-input w3-border" type="date" name="check_out" value="<?php echo $check_out; ?>" required>
        </div>
        <div class="w3-col m2">
            <label><i class="fa fa-male"></i> Adults</label>
            <input class="w3-input w3-border" type="number" name="adults" value="<?php echo $adults; ?>" min="1" max="6" required>
        </div>
        <div class="w3-col m2">
            <label><i class="fa fa-child"></i> Children</label>
            <input class="w3-input w3-border" type="number" name="children" value="<?php echo $children; ?>" min="0" max="6" required>
        </div>
        <div class="w3-col m2" id="filter-search">
            <label><i class="fa fa-search"></i> Search</label>
            <button class="w3-button w3-block w3-black" type="submit">Search</button>
        </div>
    </div>
</form>


<style>
    .slider-container {
        width: 80%;
        margin: 20px auto;
    }
    .value-container {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    .value {
        width: 50px;
        text-align: center;
    }

    div#filter-search {
        justify-content: center; /* Horizontally */
        align-items: center; /* Vertically */
        margin: 20px 0; /* Spacing */
    }
</style>