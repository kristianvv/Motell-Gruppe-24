

<?php 

    /* Manages room-related operations, such as checking room availability, 
    retrieving room details, and updating availability. */ 
    class Room {
    private int $roomId;
    private roomType $roomType; // Single, Double, Suite
    private string $description;
    private int $nrAdults; // Max number based on roomType
    private int $nrChildren; // Max number based on roomType
    private bool $availability; // Available, Booked
    private locationDetails $locationDetails; // Floor, closeToElevator, closeToFireEscape, etc.
    private roomAttributes $roomAttributes; // e.g., Room service, bathroom type (shower/bath)
    
    // Initialise room attributes
    public function __construct($roomId, $roomType, $nrAdults, $nrChildren, $description, $availability, $locationDetails, $roomAttributes) {
        $this->roomId = $roomId;
        $this->roomType = $roomType;
        $this->nrAdults = $nrAdults;
        $this->nrChildren = $nrChildren;
        $this->description = $description;
        $this->availability = $availability; // Standard "available".
        $this->locationDetails = $locationDetails;
        $this->roomAttributes = $roomAttributes;
    }

    // Availability status between two dates (returns current status if optional params null)
    public function isAvailable($roomId, $from = null, $to = null) {
        // Logic
    }

    // Set availability status (Admin)
    public function setAvailability() {
        // Logic
    }

    // Get room details (retrieve all room details if optional param is null)
    public function getRoomInfo(int $roomId = null) {
        // Logic
    }

    // Update description of room
    public function updateDescription($roomId, $newDescription) {
        // retrieve room from database and....
        $this->description = $newDescription;
    }

    // Update room attributes
    public function updateRoomAttributes($roomId, $newAttributes) {
        // Logic
    }
}


// what is file orange?
?>