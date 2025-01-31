<?php

session_start();
if (!$_SESSION["id"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

$one = 1;
$zero = 0;
$test_id = $_POST["test_id"];

$stmt = $conn->prepare("INSERT INTO results (user_id, test_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $_SESSION["id"], $test_id, $zero);
if ($stmt->execute()) {
    $lastInsertId = $conn->insert_id;
    $result_id = $lastInsertId;

    $stmt = $conn->prepare("SELECT id FROM questions WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();

    foreach ($stmt->get_result() as $question) {
        $stmt = $conn->prepare("SELECT * FROM answers WHERE question_id = ? AND is_enabled = ?");
        $stmt->bind_param("ii", $question["id"], $one);
        $stmt->execute();

        foreach ($stmt->get_result() as $answer) {
            if ($_POST["question-$test_id"] == $answer["answer_text"]) {
                $stmt = $conn->prepare("INSERT INTO user_answers (result_id, question_id, answer_id, is_correct) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $result_id, $question["id"], $answer["id"], $answer["is_correct"]);
                if (!$stmt->execute()) {
                    echo 'Kunde inte lägga till användarens svar i tabellen user_answers';
                }
            }
        }
    }

    header('Location: ../logged_in/dashboard.php');
} else {
    echo 'Kunde inte lägga till rad i results';
}
