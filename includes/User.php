<?php 

//echo "Hello World! I am the User class" . "<br>"; (for testing purposes)

/* The base class for users. Contains login logic and profile management.*/
class User {
    protected $userId;
    protected $name;
    protected $email;
    protected $password;
    protected $role; // 'Guest', 'Customer', 'Admin'

    // Initialise user 
    public function __construct($name, $email, $password, $role = 'Guest') {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT); 
        $this->role = $role;
    }

    // User registration
    public function register($pdo) {
        $stmt = $pdo->prepare("INSERT INTO User (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->name, $this->email, $this->password, $this->role]);
    }

    // Update user profile
    public function updateProfile($name, $email, $password) {
        
    }
    
    // Fetch profile information
    public function getProfile() {
        // Logic
    }

    // User logout
    public function logout() {
        // End session logic
    }

    public static function brukersøk($search, $pdo) {
        if (isset($search)) {
        
            $search = trim(htmlspecialchars($search));
            $search = "%$search%";

            $stmt = $pdo->prepare("SELECT * FROM User WHERE name LIKE :search OR email LIKE :search OR role LIKE :search");
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result != null) {
                return $result;
            }
        }
        else return null;
    }

    // Fetch user by id
    public static function fetch_user_by_id($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function fetch_user_by_email($pdo, $email) {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}

?>