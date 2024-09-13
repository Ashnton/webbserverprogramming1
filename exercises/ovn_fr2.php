<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning formulär 2</title>
</head>
<body>
    <form action="" method="GET">
        <input type="text" name="namn" id="namn-input">
        <button type="submit">Skicka</button>
    </form>


    <?php 
        if (!empty($_GET["namn"])) {
            ?> 
            Hjärtligt välkommen <?php echo $_GET['namn']; ?>
            <?php
        }
    ?>
</body>
</html>