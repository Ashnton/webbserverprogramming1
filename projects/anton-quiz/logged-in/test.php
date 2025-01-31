<?php

session_start();
if (!$_SESSION["id"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

$test_id = $_GET["id"];
$stmt = $conn->prepare("SELECT test_name FROM tests WHERE id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();

foreach ($stmt->get_result() as $result_name) {
    $test_name = $result_name["test_name"];
}
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

    <form action="../endpoints/check_answers.php" method="post">

        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

        <?php
        $one = 1;

        $stmt = $conn->prepare("SELECT id, question_text FROM questions WHERE is_enabled = ? AND test_id = ?");
        $stmt->bind_param("ii", $one, $test_id);
        $stmt->execute();

        $questionsDbResult = $stmt->get_result();
        foreach ($questionsDbResult as $questions) {
            echo $questions['question_text'];

            $stmt = $conn->prepare("SELECT id, answer_text FROM answers WHERE is_enabled = ? AND question_id = ?");
            $stmt->bind_param("ii", $one, $questions["id"]);
            $stmt->execute();

            $answersDbResult = $stmt->get_result();
            foreach ($answersDbResult as $answers) {
        ?>
                <label for="answer-<?php echo $answers["id"]; ?>"><?php echo $answers["answer_text"]; ?></label>
                <input type="radio" id="answer-<?php echo $answers["id"]; ?>" value="<?php echo $answers["answer_text"]; ?>" name="question-<?php echo $questions["id"]; ?>">
        <?php
            }
        }
        ?>

        <button type="submit">Lämna in svar</button>

    </form>
</body>

</html>