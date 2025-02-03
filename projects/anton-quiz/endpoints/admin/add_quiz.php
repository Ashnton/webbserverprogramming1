<?php

session_start();

if (!$_SESSION["is_admin"]) {
    header('Location: ../../index.php');
    die();
}

require_once __DIR__ . '/../../dbconnect.php';

$stmt = $conn -> prepare("INSERT INTO quizdb_tests (test_name) VALUES (?)");
$stmt -> bind_param("s", $_POST["test_name"]);
if ($stmt -> execute()) {
    $test_id = $conn->insert_id;
    header("Location: ../../admin/create_question.php?test_id=$test_id");
} else {
    echo 'Kunde inte skapa testet';
}