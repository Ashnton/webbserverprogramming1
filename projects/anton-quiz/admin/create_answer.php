<?php

session_start();
if (!$_SESSION["is_admin"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="../endpoints/admin/add_answer.php" method="post">
        <input type="hidden" name="question_id" value="<?php echo $_GET["question_id"];?>">

        <label for="answer">Lägg till svar:</label>
        <input type="text" name="answer">
        <label for="is_correct">Rätt</label>
        <input type="radio" name="is_correct" id="is_correct" value="1">
        <label for="is_correct">Fel</label>
        <input type="radio" name="is_correct" id="is_correct" value="0">

        <button type="submit">Spara fråga</button>
    </form>
</body>

</html>