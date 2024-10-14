<?php
// Include db connection file and user
include './includes/dbconnect.inc.php';
include './includes/User.php';

// Check if form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate fields
    if (empty($username) || empty($email) || empty($password)) {
        echo 'Please fill in all fields';
    } else {
        $user = new User($username, $email, $password); // Create new User
        $stmt = $pdo->prepare("SELECT email FROM userdata WHERE email = ?"); // Check DB for user based on email
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo 'Email already exists';
        } else {
            // Call the register method to store the user in the database
            $user->register($pdo);
            echo 'Registration successful';
        }
    }
}
?>

<!-- HTML registration form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Register">
</form>