<?php
//echo 'Hello World! I am a database connection!' . '<br>'; (for testing purposes)

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'motell');

$dkn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

try {
   $pdo = new PDO($dkn, DB_USER, DB_PASS);
}
    catch (PDOException $e) {
        echo "Feil ved tilkobling til databasen: " . $e-> getMessage();
    }

    register_shutdown_function(function() use (&$pdo) {
        $pdo = null;
    });

?>