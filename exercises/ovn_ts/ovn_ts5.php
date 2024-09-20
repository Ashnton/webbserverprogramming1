<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övning textsträng 2</title>
</head>

<body>
    <form action="" method="post">
        <input type="text" name="användarnamn" id="användarnamn">
        <input type="password" name="lösenord" id="lösenord">

        <button type="submit">Skicka</button>
    </form>

    <?php

        if (!empty($_POST["användarnamn"]) && !empty($_POST["lösenord"])) {
            if (str_contains(mb_strtoupper($_POST["användarnamn"]), "PHP")) {
                echo "Användarnamn OK\n";
            } else {
                echo "Användarnamn INTE OK\n";
            }

            if (strlen($_POST["lösenord"]) > 5 && preg_match('/\\d/', $_POST["lösenord"])) {
                echo "Lösenord OK\n";
            } else {
                echo "Lösenord INTE OK\n";
            }
        }

    ?>
</body>

</html>