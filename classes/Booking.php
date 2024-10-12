<?php 

    /* Manages bookings (creating, cancelling, fetching booking details) 
    for both customers and guests. */
    class Booking {
        private int $roomId;
        private int $userId;
        private $fromDate;
        private $toDate;
        private int $adults; // limit based on roomType
        private int $children; // limit based on roomType
        private roomAttributes $preferences; // near elevator etc.

        // Initialise booking info
        public function __construct($roomId, $userId, $fromDate, $toDate, $adults, $children, $preferences) {
            $this->roomId = $roomId;
            $this->userId = $userId;
            $this->fromDate = $fromDate;
            $this->toDate = $toDate;
            $this->adults = $adults;
            $this->children = $children;
            $this->preferences = $preferences;
        }

        // Create booking entry
        public function bookRoom($roomId, $userId) { // HIGH PRIORITY
            // Logic
        }   

        // Cancel existing booking
        public function cancelBooking() { // HIGH PRIORITY
            // Logic
        }

        // Return booking information (Admin primarily, Customer for own booking)
        public function getBookingDetails() {
            // Logic
        }

        // Check if room available (return current status or when available from a particular date),
        public function isRoomAvailable($roomId, $from = null) { // HIGH PRIORITY
            // Logic
        }
        
    }

        // MIRROR LAST BOOKING FUNCTION

?>