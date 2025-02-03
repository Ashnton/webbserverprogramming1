<?php

require __DIR__ . '/../dbconnect.php';

// Array med alla tabellnamn som ska tas bort
$tables = [
    'quizdb_user_answers',
    'quizdb_results',
    'quizdb_answers',
    'quizdb_questions',
    'quizdb_tests',
    'quizdb_users'
];

// Loopar igenom tabellerna och tar bort dem en efter en
foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS `$table`";
    if ($conn->query($sql) === TRUE) {
        echo "Tabell '{$table}' är nu borttagen.<br>";
    } else {
        echo "Misslyckades att ta bort tabell '{$table}': " . $conn->error . "<br>";
    }
}

// Stäng anslutningen
$conn->close();
?>
