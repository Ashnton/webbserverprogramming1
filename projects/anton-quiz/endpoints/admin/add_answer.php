<?php

session_start();

if (!$_SESSION["is_admin"]) {
    header('Location: ../../index.php');
    die();
}

require_once __DIR__ . '/../../dbconnect.php';

$stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $_POST["question_id"], $_POST["answer"], $_POST["is_correct"]);
if ($stmt->execute()) {
    // $question_id = $conn->insert_id;
    header("Location: ../../admin/create_answer.php?question_id=$question_id");
} else {
    echo 'Kunde inte skapa svaret';
}
