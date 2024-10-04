<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning Cookie 2</title>
</head>

<body>
    <?php
    if (isset($_SESSION["time"])) {
        if (time() > $_SESSION["time"]) {
            $_SESSION["time"] = null;
        } else {
            echo 'Välkommen tillbaka';
        }
    } else {
        $_SESSION["time"] = (time() + 10);
        echo 'Kom tillbaka innan '. time() + 10;
    }
    ?>
</body>

</html>