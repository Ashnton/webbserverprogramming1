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

    <form action="../endpoints/admin/add_quiz.php" method="post">
        <label for="test_name">Namn på test:</label>
        <input type="text" id="test_name" name="test_name">

        <button type="submit">Skapa quiz</button>
    </form>

</body>

</html>