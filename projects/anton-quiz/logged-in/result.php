<?php

session_start();
if (!$_SESSION["id"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

$test_id = $_GET["test_id"];
$stmt = $conn->prepare("SELECT test_name FROM tests WHERE id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();

$test_name = $stmt->get_result()->fetch_all()[0][0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1><?php echo $test_name; ?></h1>

    <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

    <?php
    $one = 1;

    $stmt = $conn->prepare("SELECT id, score, taken_at FROM results WHERE user_id = ? AND test_id = ?");
    $stmt->bind_param("ii", $_SESSION["id"], $test_id);
    $stmt->execute();

    foreach ($stmt->get_result() as $result) {
        echo $result["taken_at"];

        $stmt = $conn->prepare("SELECT id, question_text FROM questions WHERE is_enabled = ? AND test_id = ?");
        $stmt->bind_param("ii", $one, $test_id);
        $stmt->execute();

        $questionsDbResult = $stmt->get_result();

        foreach ($questionsDbResult as $questions) {
            echo $questions['question_text'];

            $stmt = $conn->prepare("SELECT u.id as 'user_answer_id', u.result_id as 'result_id', u.question_id as 'question_id', u.is_correct as 'is_correct', a.id as 'answer_id', a.answer_text as 'answer_text' FROM user_answers u JOIN answers a ON u.answer_id = a.id WHERE u.question_id = ?");
            $stmt->bind_param("i", $questions["id"]);
            $stmt->execute();

            $answersDbResult = $stmt->get_result();
            foreach ($answersDbResult as $answers) {
                if ($answers["is_correct"]) {
                ?>
                    <label for="answer-<?php echo $answers["answer_id"]; ?>" style="color: green;"><?php echo $answers["answer_text"]; ?></label>
                    <input type="radio" id="answer-<?php echo $answers["answer_id"]; ?>" value="<?php echo $answers["answer_text"]; ?>" name="question-<?php $questions["id"]; ?>">
                <?php
                } else {
                ?>
                    <label for="answer-<?php echo $answers["answer_id"]; ?>" style="color: red;"><?php echo $answers["answer_text"]; ?></label>
                    <input type="radio" id="answer-<?php echo $answers["answer_id"]; ?>" value="<?php echo $answers["answer_text"]; ?>" name="question-<?php $questions["id"]; ?>">
                <?php

                }
            }
        }
    }
    ?>


</body>

</html>