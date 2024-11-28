<?php
include "config/dbConn.php";

// CALL: dev/db.php [arg] in CLI.
try {
    $pdo = getDbConnection();
    if ($argc > 1) {
        switch($argv[1]) {
            case 'trunc': // CLI ARG
                delContent($pdo);
                echo "All tables truncated successfully!\n";
                break;
            case 'drop': // CLI ARG
                dropTables($pdo);
                echo "All tables dropped successfully!\n";
                break;
            case 'create': // CLI ARG
                createTables($pdo);
                echo "Table creation success!\n";
                break;
            case 'add':
                addContent($pdo);
                echo "Table content creation success!\n";
                break;
            case 'update':
                updateContent($pdo);
                echo "Table content creation success!\n";
                break;
            default:
                echo "Invalid argument. Use 'add', 'trunc', 'create' or 'drop'.\n";
            }       
    } else {
        echo "Please provide an argument: 'add', 'trunc', 'create', or 'drop'.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Delete all content of all tables in db
function delContent(PDO $pdo): void {

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0"); // Disable foreign key checks
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN); // Get list of tables

    foreach ($tables as $table) { // Del content of tables in db
        $pdo->exec("TRUNCATE TABLE `$table`");
        echo "Truncated table: $table\n";
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1"); // Re-enable foreign key checks
}

// Delete all tables in db
function dropTables(PDO $pdo): void {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0"); // Disable foreign key checks
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN); // Get list of tables

    foreach ($tables as $table) { // Drop all tables in db
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
        echo "Dropped table: $table\n";
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1"); // Re-enable foreign key checks
}

// Create tables in db as defined here
function createTables(PDO $pdo): void {
    $newSchema = "
        CREATE TABLE IF NOT EXISTS `User` (
            `userID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) DEFAULT NULL,
            `email` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(10) DEFAULT NULL
        );

        CREATE TABLE IF NOT EXISTS `Rooms` (
            `roomID` INT AUTO_INCREMENT PRIMARY KEY,
            `roomType` VARCHAR(50) NOT NULL,
            `adults` INT NOT NULL,
            `children` INT NOT NULL,
            `description` VARCHAR(255) DEFAULT NULL
        );

        CREATE TABLE IF NOT EXISTS `Booking` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `checkInDate` DATE NOT NULL,
            `checkOutDate` DATE NOT NULL,
            `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `roomID` INT NOT NULL,
            `userID` INT NOT NULL,
            FOREIGN KEY (`roomID`) REFERENCES `Rooms`(`roomID`),
            FOREIGN KEY (`userID`) REFERENCES `User`(`userID`)
        );
    ";
    $pdo->exec($newSchema);
}

// Setup testing content for tables in db
function addContent(PDO $pdo): void {

    $adminPassword = password_hash('Password1!', PASSWORD_DEFAULT);
    $customerPassword = password_hash('Password2!', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO User (name, email, password, role) VALUES (:name, :email, :password, :role)");

    $insert = "
        INSERT INTO `Rooms` (`roomType`, `adults`, `children`) VALUES
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Enkeltrom', 1, 0),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Dobbeltrom', 2, 2),
            ('Juniorsuite', 4, 4),
            ('Juniorsuite', 4, 4),
            ('Juniorsuite', 4, 4),
            ('Juniorsuite', 4, 4),
            ('Juniorsuite', 4, 4);

        INSERT INTO `Booking` (userID, roomID, checkInDate, checkOutDate) VALUES 
            (1, 1, '2024-11-30', '2024-12-15'),
            (2, 2, '2024-11-30', '2024-12-15');
        ";
    
    try {
        $stmt->execute(['name' => 'Alice', 'email' => 'alice.anderson@example.com', 'password' => $adminPassword, 'role' => 'admin']);
        $stmt->execute(['name' => 'Bob', 'email' => 'bob.brown@example.com','password' => $customerPassword, 'role' => 'customer']);
        $pdo->exec($insert);
        echo "Setup in database successful.";
    } catch (PDOException $e) {
        echo "Error setting up content in database tables: " . $e->getMessage();
    }
}

// Create tables in db as defined here
function updateContent(PDO $pdo): void {
    $newSchema = "
        ALTER TABLE `Rooms` ADD COLUMN `price` INT NOT NULL DEFAULT 0;
            UPDATE `Rooms` SET `price` = 500 WHERE `roomType` = 'Enkeltrom';
            UPDATE `Rooms` SET `price` = 1000 WHERE `roomType` = 'Dobbeltrom';
            UPDATE `Rooms` SET `price` = 2000 WHERE `roomType` = 'Juniorsuite';
    ";
    $pdo->exec($newSchema);
}

?>