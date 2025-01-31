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
    <form action="../endpoints/admin/add_question.php" method="post">
        <input type="hidden" name="test_id" value="<?php $_GET["test_id"];?>">

        <label for="question">Lägg till fråga:</label>
        <input type="text" name="question">
    </form>
</body>

</html>