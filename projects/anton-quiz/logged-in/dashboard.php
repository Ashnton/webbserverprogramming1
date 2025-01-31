<?php

session_start();
if (!$_SESSION["id"]) {
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
    <title>Dashboard</title>
</head>

<body>
    <h1>Startsida</h1>

    <div>
        <h2>Tester du kan göra:</h2>
        <?php
        $one = 1;

        $stmt = $conn->prepare('SELECT * FROM tests WHERE is_enabled = ?');
        $stmt->bind_param("i", $one);
        $stmt->execute();

        $testsDbResult = $stmt->get_result();

        foreach ($testsDbResult as $tests) {
        ?>

            <a href="test.php?id=<?php echo $tests['id']; ?>"><?php echo $tests["test_name"] ?></a>

            <?php
            // Kontrollera om användaren gjort ett test tidigare
            $stmt = $conn -> prepare('SELECT id FROM results WHERE user_id = ? AND test_id = ?');
            $stmt -> bind_param('ii', $_SESSION["id"], $tests["id"]);
            $stmt -> execute();

            $resultsDbResult =$stmt -> get_result();

            if (mysqli_num_rows($resultsDbResult) > 0) {
                ?>
                <h3>Resultat:</h3>
                <!-- Kolla user med session i result.php -->
                <a href="result.php?test_id=<?php echo $tests['id']?>"><?php echo $tests["test_name"] ?></a>
                <?php
            }
    
            ?>
        <?php
        }
        ?>
    </div>
</body>

</html>