

<?php 

    /* Manages room-related operations, such as checking room availability, 
    retrieving room details, and updating availability. */ 
    class Room {
    private $roomNumber;
    private $type; // Single, Double, Suite
    private $description;
    private $availability; // Available, Booked
    private $locationDetails; // Floor, closeToElevator, closeToFireEscape, etc.
    private $roomAttributes; // e.g., Room service, bathroom type (shower/bath)
    
    // Initialise room attributes
    public function __construct($roomNumber, $type, $description, $availability, $locationDetails, $roomAttributes) {
        // logic
    }

    // Return availability status
    public function getAvailability() {
        // logic
    }

    // Set availability status
    public function setAvailability($status) {
        // logic
    }

    // Check room availability between two dates
    public function isAvailableForBooking($from, $to) {
        // logic
    }
}

?>