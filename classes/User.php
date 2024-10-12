<?php 

/* The base class for users. Contains login logic and profile management.*/
class User {
    protected $userId;
    protected $name;
    protected $email;
    protected $password;
    protected role $role; // 'Guest', 'Customer', 'Admin'

    // Initialise user 
    public function __construct($name, $email, $password, $role = 'Guest') {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT); 
        $this->role = $role;
    }

    // User registration
    public function register() {
        // Store to DB
    }

    // Update user profile
    public function updateProfile($name, $email, $password) {
        // Logic
    }

    // User login
    public function login($email, $password) {
        // Start session logic
        // Timer? => Call logout
    }

    // Fetch profile information
    public function getProfile() {
        // Logic
    }

    // User logout
    public function logout() {
        // End session logic
    }
}

?>
