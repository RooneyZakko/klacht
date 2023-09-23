<?php
require_once '../vendor/autoload.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('klachtverwerking');
$log->pushHandler(new StreamHandler('logs/info.log', Logger::INFO));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['omschrijving'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $omschrijving = $_POST['omschrijving'];

        $log->info("Klacht ontvangen - Naam: $name, Email: $email, Omschrijving: $omschrijving");

        
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'jouw_email@example.com'; 
            $mail->Password = 'jouw_wachtwoord'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 587; 

            $mail->setFrom('jouw_email@example.com', 'Jouw Naam');
            $mail->addAddress($email);
            $mail->addCC('jouw_email@example.com'); 
            $mail->isHTML(true);
            $mail->Subject = 'Uw klacht is in behandeling';
            $mail->Body = "Beste $name,<br>Uw klacht is in behandeling.<br>Omschrijving klacht: $omschrijving";

            $mail->send();

            $log->info("Klacht ontvangen - Naam: $name, Email: $email, Omschrijving: $omschrijving");

            echo "<h2>Uw klacht is in behandeling</h2>";
            echo "<p><strong>Naam:</strong> $name</p>";
            echo "<p><strong>Email:</strong> $email</p>";
        } catch (Exception $e) {
            echo "Er is een fout opgetreden bij het versturen van de e-mail: {$mail->ErrorInfo}";

            $log->error("Fout bij het versturen van de e-mail: {$mail->ErrorInfo}");
        }
    } else {
        echo "<p>Er is een fout.</p>";
    }
}
?>
