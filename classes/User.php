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

    public function getName() {
        return $this->name;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getRole() {
        return $this->role;
    }
    

    // User registration
    public function register(PDO $pdo) {
        $stmt = $pdo->prepare("INSERT INTO User (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->name, $this->email, $this->password, $this->role]);
    }

    public static function search_users($pdo, $search) {
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

    public static function fetch_user_by_token($pdo, $token) {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE password_reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public static function update_password($pdo, $email, $password) {
        $stmt = $pdo->prepare("UPDATE User SET password = ? WHERE email = ?");
        $stmt->execute([$password, $email]);
    }

    public static function update_role($pdo, $id, $role) {
        $stmt = $pdo->prepare("UPDATE User SET role = ? WHERE userID = ?");
        $stmt->execute([$role, $id]);
    }

    public static function invalidate_reset_token($pdo, $email) {
        $stmt = $pdo->prepare("UPDATE User SET password_reset_token = NULL, token_expiration = NULL WHERE email = ?");
        $stmt->execute([$email]);
    }

    public static function set_reset_token($pdo, $email, $token) {
        $stmt = $pdo->prepare("UPDATE User SET password_reset_token = ?, token_expiration = ? WHERE email = ?");
        $stmt->execute([$token, time() + 3600, $email]);
    }

    public static function get_all_emails($pdo) {
        $stmt = $pdo->prepare("SELECT email FROM User");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public static function delete_user($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM User WHERE userID = ?");
        $stmt->execute([$id]);
    }
    public static function fetch_all($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM User");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_user_by_id($pdo, $id): User|bool {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE userID = ?");
        $stmt->execute([$id]);
        $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userdata) {
            return new User(
                $userdata['name'],
                $userdata['email'],
                $userdata['password'],
                $userdata['role']
            );
        } else {
            return false;
        }
    }
}

?>