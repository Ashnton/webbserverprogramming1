<?php
// db.php
$host = 'localhost';      // eller din server
$db   = 'quizdb';         // databasnamnet
$user = 'root';           // ditt db-användarnamn
$pass = '';               // ditt db-lösenord

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo "Kunde inte ansluta till databasen: " . $e->getMessage();
    exit;
}
