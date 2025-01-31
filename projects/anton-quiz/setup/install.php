<?php
require __DIR__ . '/../../../envparser.php';

$envFilePath = __DIR__ . '/../../../credentials.env';
$envVars = parseEnvFile($envFilePath);

$hostname = 'localhost';
$username = $envVars["user"];
$password = $envVars["password"];
$db = "antonlm";

$conn = new mysqli($servername, $username, $password, $db);

// Kontrollera anslutning
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // 1) Skapa databasen om den inte redan finns
// $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS quizdb";
// if ($conn->query($sqlCreateDb) === false) {
//     die("Fel vid skapande av databasen: " . $conn->error);
// }
// echo "Databasen 'quizdb' säkerställdes.\n";

// // 2) Använd databasen
// $sqlUseDb = "USE quizdb";
// if ($conn->query($sqlUseDb) === false) {
//     die("Fel vid USE quizdb: " . $conn->error);
// }
// echo "Bytte till databasen 'quizdb'.\n";

// 3) Sätt samman alla CREATE TABLE-kommandon i en enda sträng (eller kör dem ett och ett).
// Ordningen i din kod är bra eftersom det inte uppstår FK-problem (users -> tests -> questions -> answers -> results -> user_answers).

$sqlTables = "
-- Tabell för användare
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    latest_login DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_admin TINYINT(1) NOT NULL DEFAULT 0
);

-- Tabell för frågetester
CREATE TABLE IF NOT EXISTS tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_name VARCHAR(100) NOT NULL,
    is_enabled TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabell för frågor
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_id INT NOT NULL,
    question_text VARCHAR(255) NOT NULL,
    is_enabled TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
);

-- Tabell för svarsalternativ
CREATE TABLE IF NOT EXISTS answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    answer_text VARCHAR(255) NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    is_enabled TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

-- Tabell för resultat
CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    test_id INT NOT NULL,
    score INT NOT NULL DEFAULT 0,
    taken_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
);

-- Tabell för användarens svar
CREATE TABLE IF NOT EXISTS user_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    result_id INT NOT NULL,
    question_id INT NOT NULL,
    answer_id INT NOT NULL,
    is_correct TINYINT(1) NOT NULL,
    FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES answers(id) ON DELETE CASCADE
);
";

// 4) Använd "multi_query" för att köra alla kommandon i en enda körning
if ($conn->multi_query($sqlTables) === false) {
    die("Fel vid skapande av tabeller: " . $conn->error);
}

// 5) Eftersom multi_query kan returnera flera resultat, loopar vi igenom dem (även om dessa CREATE statements inte returnerar data)
do {
    if ($result = $conn->store_result()) {
        $result->free();
    }
} while ($conn->next_result());

// Avsluta och meddela klart
echo "Tabeller har skapats/uppdaterats enligt scriptet.\n";

$conn->close();
