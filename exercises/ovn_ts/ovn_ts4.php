<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Övningar textsträngar 1</title>
</head>
<body>
    <form action="" method="get">
        <input type="text" placeholder="Förnamn" id="förnamn" name="förnamn">
        <input type="text" placeholder="Efternamn" id="efternamn" name="efternamn">
        <input type="text" placeholder="Epostadress" id="epostadress" name="epostadress">
    
        <button type="submit">Skicka</button>
    </form>

    <?php
        if (!empty($_GET["förnamn"])) {
            $förnamn = mb_ucfirst(strtolower($_GET["förnamn"]));
            $efternamn = mb_ucfirst(strtolower($_GET["efternamn"]));
            $epostadress = strtolower($_GET["epostadress"]);
            
            echo $förnamn;
            echo $efternamn;

            if(!filter_var($epostadress, FILTER_VALIDATE_EMAIL) && strlen($epostadress) < 6) {
                echo 'Ej godkänd epostadress';
            } else {
                echo $epostadress;
            };
        }

        function mb_ucfirst($string) {
            return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        }
    ?>
</body>
</html>