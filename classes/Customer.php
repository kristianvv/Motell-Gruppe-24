<?php 

    /* Extends User. Contains customer-specific methods: Manage preferences, view loyalty points, previous bookings etc. */ 
    class Customer extends User {
    private $loyaltyPoints;
    private $preferences;

    // Initialise user customer attributes
    public function __construct($name, $email, $password) {
        parent::__construct($name, $email, $password, 'Customer');
        $this->loyaltyPoints = 0; // Starts at zero points
    }

    // Fetch customer’s previous bookings
    public function getPreviousBookings() {
        // Logic
    }

    // Save customer preferences
    public function updatePreferences($preferences) {
        // Logic
    }   
    
    // Add points to the customer’s loyalty program
    public function addLoyaltyPoints($points) {
        // Logic
    }
}


?>