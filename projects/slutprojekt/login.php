<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
</head>
<body>
    <form action="endpoints/login.php">
        <input type="text">
        <input type="password">
    </form>

    <form action="endpoints/create_account.php">
        <input type="email" name="email">
        <input type="tel" name="phonenumber">
        <input type="password" name="password">
    </form>
</body>
</html>