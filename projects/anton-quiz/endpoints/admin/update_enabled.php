<?php
session_start();
if (!$_SESSION["is_admin"]) {
    header('Location: ../../index.php');
    die();
}

require_once __DIR__ . '/../../dbconnect.php';

// Hämta värden från formuläret
$test_id = $_POST["test_id"] ?? 0;
$is_enabled = $_POST["is_enabled"] ?? 0;

// Gör en enkel sanitetskontroll
$test_id = (int)$test_id;
$is_enabled = ($is_enabled == 1) ? 1 : 0;

// Uppdatera i databasen
$stmt = $conn->prepare("UPDATE quizdb_tests SET is_enabled = ? WHERE id = ?");
$stmt->bind_param("ii", $is_enabled, $test_id);
$stmt->execute();

// Skicka tillbaka till edit-sidan (eller var du vill)
header('Location: ../../admin/edit_quiz.php?test_id=' . $test_id);
exit;
