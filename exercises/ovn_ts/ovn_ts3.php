<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning textsträng 3</title>
</head>

<body>
    <form action="" method="POST">
        <input type="number" name="number1" id="number1">
        <input type="number" name="number2" id="number2">
        <button type="submit">Skicka</button>
    </form>

    <?php
        if (!empty($_POST["number1"]) && !empty($_POST["number2"])) {
            echo round(($_POST["number1"] / $_POST["number2"]), 2);
        }
    ?>
</body>

</html>