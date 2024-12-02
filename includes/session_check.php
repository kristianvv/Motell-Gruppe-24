<?php
// Start a session if one is not already running
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set denne ned når prosjektet er ferdig, brukes kun for testing
$timeout_duration = 3600;

//Sjekker om bruker er logget inn
if (isset($_SESSION['user_id'])) {
    // Sjekker om session har gått ut
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
        // Hvis den har gått ut, logg ut bruker ved å fjerne session variabler og send til login
        session_unset(); 
        session_destroy();
        header("Location: ../views/login.php?message=Sesjonen har gått ut, vennligst logg inn på nytt.");
        exit();
    }
    // Oppdaterer siste aktivitet. Dette skjer hver gang bruker gjør en handling eller laster en ny side
    $_SESSION['last_activity'] = time();
} else {
    //Bruker er ikke logget inn, send til login
    header("Location: ../views/login.php?message=Vennligst logg inn for å fortsette.");
    exit();
}
?>