<?php

require __DIR__ . '/../../envparser.php';

$envFilePath = __DIR__ . '/../../credentials.env'; // Replace with the actual path to your .env file
$envVars = parseEnvFile($envFilePath);

$dbname = 'antonlm';
// $dbname = 'quizdb';
$hostname = 'localhost';
$DB_USER = $envVars["user"];
$DB_PASSWORD = $envVars["password"];

$conn = new mysqli($hostname, $DB_USER, $DB_PASSWORD, $dbname);

// Check connection
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}