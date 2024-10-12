<?php 

    /* Extends User. Handles admin-specific functions: Room management, Grant privileges, Manage discounts. */
    class Admin extends User {

        // Initialise user admin attributes
        public function __construct($name, $email, $password) {
            parent::__construct($name, $email, $password, 'Admin');
        }

        // Make room unavailable between specific dates
        public function makeRoomUnavailable($roomId, $from, $to) { // HIGH PRIORITY
            // Logic 
        }

        // Activate discounts for a customer
        public function activateDiscount($userId) {
            // Logic
        }

        // Assign admin role to a user
        public function grantAdminPrivileges($userId) { // HIGH PRIORITY
            // Logic
        }

        // Update room details
        public function updateRoomDetails($roomId, $newDetails) {
            // Logic
        }

        // Add new room
        public function addRoom($roomType, $nrAdults, $nrChildren, $description, $availability, $locationDetails, $roomAttributes) {
            // Logic
        }
    }
?>