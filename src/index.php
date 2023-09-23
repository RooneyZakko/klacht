<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('problemen');
$logger->pushHandler(new StreamHandler(__DIR__ . '/app.log', Logger::DEBUG));

// $logger->info('this is log! ^ ^');
// $logger->wearing('this is a log waring ^ ^');
// $logger->error('This is a log error ^ ^');

// ini_set('display errors, 0');
// error_reporting(0);

function MaakError($error)
{
    throw new Exception($error);
}
try {
    MaakError('klote');
} catch (Exception $e){
    echo "een error gevonden: <span class='error'> " . $e->getMessage() . "</span>";
    // hier willen we de fout registeren

$logger->error('fout gevonden', [$e->getMessage()]);
} finally{
    echo"<p>ik mag nog even doorgaan</p>";
    $logger->info('en mag nog doorgaan');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen</title>
</head>
<body>
    <h1>Klachten</h1>
    
    <form method="POST" action="index.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="omschrijving">Omschrijving klacht:</label><br>
        <textarea id="omschrijving" name="omschrijving" required></textarea><br>
        
        <input type="submit" value="Versturen">
    </form>
</body>
</html>
