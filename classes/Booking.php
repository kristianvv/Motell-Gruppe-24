<?php 

    /* Manages bookings (creating, cancelling, fetching booking details) 
    for both customers and guests. */
    class Booking {
        private $roomId;
        private $userId;
        private $fromDate;
        private $toDate;

        // Initialise booking info
        public function __construct($roomId, $userId, $fromDate, $toDate) {
            
        }

        // Create booking entry
        public function createBooking() {
            // Logic
        }   

        // Cancel existing booking
        public function cancelBooking() {
            // Logic
        }

        // Return booking information
        public function getBookingDetails() {
            // Logic
        }
    }


?>