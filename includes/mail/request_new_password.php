<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
require '../dbconnect.inc.php';
require '../../classes/User.php';

if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $user = User::fetch_user_by_email($pdo, $email);

    if ($user != null) {
        $reset_token = bin2hex(random_bytes(32)) . hash('sha256', $user['email']);
        User::set_reset_token($pdo, $user['email'], $reset_token);
    }
    else {
        exit("Ingen bruker med denne e-postadressen ble funnet.");
    }

    try {

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'motellgruppe24@gmail.com';
    $mail->Password = 'zagq fpfl qhkb rifq';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Debug output
    //$mail->Debugoutput = 'html'; // Debug output format

    $mail->setFrom('motellgruppe24@gmail.com');

    $mail->addAddress($email);
    $mail->isHTML(true);

    $mail->Subject = 'Nytt passord';

    $mail->Body = "
        <h1>Hei, $email!</h1>
        <p>Du kan tilbakestille passordet ditt ved å følge denne lenken:</p>
        <a href='http://localhost/Motell-Gruppe-24/views/reset_password.php?token=$reset_token'>Tilbakestill passord</a>
        <p>Dersom du ikke har bedt om å tilbakestille passordet ditt, kan du ignorere denne e-posten.</p>
        <p>Med vennlig hilsen, Gruppe 24</p>
        ";

        $mail->send();
        //Send GET message to user if the mail was sent
        header("Location: ../../views/forgot_password.php?message=Mail sent");
        exit;

    } catch (Exception $e) {
        header("Location: ../../views/forgot_password.php?message=Error sending mail");
        exit;
    }
}