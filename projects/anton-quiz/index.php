<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
</head>

<body>

    <h2>Logga in</h2>
    <form action="endpoints/log-in.php" method="post">
        <label for="username">Användarnamn:</label>
        <input type="text" id="username" name="username">

        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password">

        <button type="submit">Logga in</button>
    </form>

    <h2>Skapa konto</h2>
    <form action="endpoints/create-account.php" method="post">
        <label for="username">Användarnamn:</label>
        <input type="text" id="username" name="username">

        <label for="password">Lösenord:</label>
        <input type="password" id="password" name="password">

        <button type="submit">Skapa konto</button>
    </form>

</body>

</html>