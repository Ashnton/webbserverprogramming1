<?php

// show all error reporting
error_reporting(-1); // Report all type of errors
ini_set('display_errors', 1); // Display all errors 
ini_set('output_buffering', 0); // Do not buffer outputs, write directly

session_start();

if (!$_SESSION["is_admin"]) {
    header('Location: ../../index.php');
    die();
}

require_once __DIR__ . '/../../dbconnect.php';

$stmt = $conn->prepare("INSERT INTO quizdb_questions (test_id, question_text) VALUES (?, ?)");
$stmt->bind_param("is", $_POST["test_id"], $_POST["question"]);

if (!$stmt) {
    // Om själva prepare()-anropet misslyckades
    die("Förberedning av statement misslyckades: " . $conn->error);
}

if ($stmt->execute()) {
    $question_id = $conn->insert_id;
    header("Location: ../../admin/create_answer.php?question_id=$question_id&test_id=$test_id");
} else {
    // Visa det faktiska felmeddelandet från MySQLi
    die("Kunde inte skapa frågan: " . $stmt->error);
}
