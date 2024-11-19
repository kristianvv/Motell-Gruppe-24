
<form action="process_booking.php">
<div class="w3-row-padding">
    <div class="w3-col m3">
        <label><i class="fa fa-calendar-o"></i> Check In</label> <!-- Check In Date -->
        <input class="w3-input w3-border" type="date" placeholder="DD MM YYYY">
    </div>
    <div class="w3-col m3">
        <label><i class="fa fa-calendar-o"></i> Check Out</label> <!-- Check Out Date -->
        <input class="w3-input w3-border" type="date" placeholder="DD MM YYYY">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-male"></i> Adults</label> <!-- Number of Adults -->
        <input class="w3-input w3-border" type="number" placeholder="1" min="1" max="6">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-child"></i> Children</label> <!-- Number of Children -->
        <input class="w3-input w3-border" type="number" placeholder="0" min="1" max="6">
    </div>
    <div class="w3-col m2" id="filter-search">
    <label><i class="fa fa-search"></i> Search</label> <!-- Submit Search Button -->
    <button class="w3-button w3-block w3-black">Search</button>
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