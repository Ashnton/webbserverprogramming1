<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
</head>

<body>
    <h2>
        Användare:
    </h2>
    <form action="endpoints/login.php" method="post">
        <label for="email_login">Epost</label>
        <input type="email" name="email" id="email_login">
        <label for="password_login">Lösenord</label>
        <input type="password" name="password" id="password_login">

        <button type="submit">Logga in</button>
    </form>

    <form action="endpoints/create_account.php" method="post">
        <label for="email_create">Epost</label>
        <input type="email" id="email_create" name="email">
        <label for="phonenumber_create">Telefonnummer</label>
        <input type="tel" id="phonenumber_create" name="phonenumber">
        <label for="password_create">Lösenord</label>
        <input type="password" id="password_create" name="password">

        <button type="submit">Skapa konto</button>
    </form>

    <h2>Restauranger:</h2>
    <form action="endpoints/restaurant_login.php" method="post">
        <label for="email_login">Epost</label>
        <input type="email" name="email" id="email_login">
        <label for="password_login">Lösenord</label>
        <input type="password" name="password" id="password_login">

        <button type="submit">Logga in</button>
    </form>

    <form action="endpoints/restaurant_create_account.php" method="post">
        <label for="email_create">Epost</label>
        <input type="email" id="email_create" name="email">
        <label for="password_create">Lösenord</label>
        <input type="password" id="password_create" name="password">

        <label for="restaurant">Vilken restaurang ska användaren vara kopplad till?</label>

        <select name="restaurant" id="restaurant">
        <?php 
            require __DIR__ . '/../../dbconnect.php';

            $stmt = $dbconn -> prepare("SELECT id, restaurant_name FROM slutprojekt_restaurants");
            $stmt -> execute();
            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <option value="<?php echo $res['id'];?>"><?php echo $res['restaurant_name'];?></option>
                <?php
            }
        ?>  
        </select>

        <button type="submit">Skapa konto</button>
    </form>
</body>

</html>