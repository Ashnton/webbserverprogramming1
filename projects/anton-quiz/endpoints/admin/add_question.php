<?php

session_start();

if (!$_SESSION["is_admin"]) {
    header('Location: ../../index.php');
    die();
}

require_once __DIR__ . '/../../dbconnect.php';

$stmt = $conn->prepare("INSERT INTO questions (test_id, question_text) VALUES (?, ?)");
$stmt->bind_param("is", $_POST["test_id"], $_POST["question"]);
if ($stmt->execute()) {
    $question_id = $conn->insert_id;
    header("Location: ../../admin/create_answer.php?question_id=$question_id");
} else {
    echo 'Kunde inte skapa frågan';
}
