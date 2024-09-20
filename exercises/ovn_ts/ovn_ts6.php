<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning textsträng 6</title>
</head>
<body>
    <form action="" method="POST">
        <textarea name="text" id="text"></textarea>
        <button type="submit">Skicka</button>
    </form>

    <?php 
        if (!empty($_POST["text"])) {
            // Processa texten
        }

    ?>
</body>
</html>