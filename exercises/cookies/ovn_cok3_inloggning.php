<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning cookies 3</title>
</head>

<body>
    <form action="" method="post">
        <input type="password" name="password" id="password">
        <button type="submit">Skicka in</button>
    </form>

    <?php
    if (isset($_POST["password"])) {
        if (password_verify($_POST["password"], '$2y$10$FUnyKcPyEKHABYTBdJl7QeKNtS8JgqbjM4wHT38kyT1WYNy90KbmS')) {
            $_SESSION["tillåtelse"] = true;
            header("Location: ovn_cok3_hemligheter.php");
        }
    }
    ?>
</body>

</html>