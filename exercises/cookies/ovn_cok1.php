<?php

    setcookie("myCookie", 1, time() + 10);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning Cookie 1</title>
</head>
<body>
    <?php
        if(isset($_COOKIE["myCookie"])) {
            ?>
                Cookie set
            <?php
        } else {
            ?>
                Cookie not set
            <?php
        }
    ?>
</body>
</html>