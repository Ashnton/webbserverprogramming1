<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning formulär 7</title>
</head>
<body>
    <form action="" method="POST">
        <input type="number" name="number_1" id="number-1">
        <input type="number" name="number_2" id="number-2">
        <input type="number" name="number_3" id="number-3">

        <button type="submit">Beräkna</button>
    </form>

    <?php 
        if (!empty($_POST["number_1"])) {
            echo (($_POST["number_1"] + $_POST["number_2"] + $_POST["number_3"]) / count($_POST));
        }
    ?> 
</body>
</html>