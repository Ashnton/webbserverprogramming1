<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning Cookies 4</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="tal" id="tal">
        <button type="submit">Läs in tal</button>
    </form>

    <?php
        if (isset($_POST["tal"])) {
            $_SESSION["talen"][] = $_POST["tal"];

            for ($i=0; $i < count($_SESSION["talen"]); $i++) { 
                $summa += $_SESSION["talen"][$i];
            }

            echo "Medelvärde: " . $summa/$i; 
        }
    ?>
</body>
</html>