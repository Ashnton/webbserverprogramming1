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
    <title>Admin</title>
</head>

<body>

    <h1>Admin dashboard</h1>

    <a href="create_quiz.php">Skapa nytt test</a>

    <h2>Befintliga tester</h2>
    <div>
        <?php

        $stmt = $conn->prepare("SELECT * FROM quizdb_tests");
        $stmt->execute();
        $tests = $stmt->get_result();
        foreach ($tests as $test) {
            echo $test["test_name"];
        ?>
            <a href="edit_quiz.php?test_id=<?php echo $test["id"]; ?>">Redigera test</a> <br>
            <a href="show_results.php?test_id=<?php echo $test["id"]; ?>">Visa resultat</a> <br>
        <?php
        }
        ?>
    </div>

    <a href="../endpoints/log-out.php">Logga ut</a>
</body>

</html>