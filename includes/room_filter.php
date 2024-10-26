<!-- <link rel="stylesheet" type="text/css" href="./public/css/room_filter.css"> -->

<!-- FIRST ROW -->
<div class="w3-row-padding">
    <div class="w3-col m3">
        <label><i class="fa fa-calendar-o"></i> Check In</label> <!-- Check In Date -->
        <input class="w3-input w3-border" type="text" placeholder="DD MM YYYY">
    </div>
    <div class="w3-col m3">
        <label><i class="fa fa-calendar-o"></i> Check Out</label> <!-- Check Out Date -->
        <input class="w3-input w3-border" type="text" placeholder="DD MM YYYY">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-male"></i> Adults</label> <!-- Number of Adults -->
        <input class="w3-input w3-border" type="number" placeholder="1" min="1" max="6">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-child"></i> Children</label> <!-- Number of Children -->
        <input class="w3-input w3-border" type="number" placeholder="0" min="1" max="6">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-bed"></i> Room Nr.</label> <!-- Room Number -->
        <input class="w3-input w3-border" type="search" name="searchTerm" placeholder="101">
    </div>
</div>
<br>
<!-- SECOND ROW -->
<div class="w3-row-padding">
    <div class="w3-col m2">
        <label><i class="fa fa-child"></i> Room Type</label> <!-- Room Type Filter -->
        <select class="w3-input w3-border" name="filterTerm">
            <option value="">All</option>
            <option value="single">Single</option>
            <option value="double">Double</option>
            <option value="family">Family</option>
            <option value="suite">Suite</option>
        </select>
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-child"></i> Availability</label> <!-- Availability -->
        <select class="w3-input w3-border" name="availability">
            <option value="">All</option>
            <option value="open" selected>Open</option>
            <option value="booked">Booked</option>
        </select>
    </div>
    <div class="w3-col m2">
        <label> Floor Nr.</label> <!-- Floor Number -->
        <input class="w3-input w3-border" type="number" name="floor" placeholder="Floor Number" min="0">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-bed"></i> Bedspaces (Adult)</label> <!-- Adult Bedspaces -->
        <input class="w3-input w3-border" type="number" name="bedspacesAdult" placeholder="Min Adult Beds" min="0">
    </div>
    <div class="w3-col m2">
        <label><i class="fa fa-bed"></i> Bedspaces (Child)</label> <!-- Child Bedspaces -->
        <input class="w3-input w3-border" type="number" name="bedspacesChild" placeholder="Min Child Beds" min="0">
    </div>
    <div class="w3-col m2">
        <label for="nearElevator"><i class="fa fa-level-up"></i> Near Elevator</label> <!-- Near Elevator Checkbox -->
        <input class="w3-input w3-border" type="checkbox" name="nearElevator" value="1">
    </div>
</div>
<br>
<!-- THIRD ROW -->
    <div class="w3-row-padding">
    <div class="w3-container">
        <label><h4>Price Range</h4></label> <!-- Price Range Slider -->
        <div class="slider-container" id="slider"></div>
        <div class="value-container">
            <input type="text" id="minValue" value="0" readonly class="w3-input w3-border value">
            <input type="text" id="maxValue" value="1000" readonly class="w3-input w3-border value">
        </div>
    </div>
</div>
<br>
<!-- FOURTH ROW -->
<div class="w3-col m2" id="filter-search">
    <label><i class="fa fa-search"></i> Search</label> <!-- Submit Search Button -->
    <button class="w3-button w3-block w3-black">Search</button>
</div>

<!-- Price Range Slider Function -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>
<script>
    const slider = document.getElementById('slider');
    const minValueInput = document.getElementById('minValue');
    const maxValueInput = document.getElementById('maxValue');

    noUiSlider.create(slider, {
        start: [0, 1000],
        connect: true,
        range: {
            'min': 0,
            'max': 1000
        }
    });

    slider.noUiSlider.on('update', function (values, handle) {
        if (handle === 0) {
            minValueInput.value = Math.round(values[0]);
        } else {
            maxValueInput.value = Math.round(values[1]);
        }
    });
</script>


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