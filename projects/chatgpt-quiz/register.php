<?php
// register.php
session_start();
require_once 'db.php';

$message = '';

if (isset($_POST['register'])) {
    $namn = trim($_POST['namn']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($namn) && !empty($username) && !empty($password)) {
        // Kolla om användarnamn redan finns
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $message = "Användarnamnet är upptaget!";
        } else {
            // Skapa användare
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO customers (namn, username, password, is_admin) 
                                    VALUES (?, ?, ?, 0)");
            $stmt->execute([$namn, $username, $hashed]);
            $message = "Registreringen lyckades! Du kan nu logga in.";
        }
    } else {
        $message = "Fyll i alla fält!";
    }
}
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Registrera ny kund</title>
</head>

<body>
    <h1>Registrera ny kund</h1>
    <p style="color:red;"><?php echo $message; ?></p>
    <form method="post">
        <label>Namn:</label><br>
        <input type="text" name="namn"><br><br>

        <label>Användarnamn:</label><br>
        <input type="text" name="username"><br><br>

        <label>Lösenord:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit" name="register">Registrera</button>
    </form>
    <p><a href="login.php">Tillbaka till inloggning</a></p>
</body>

</html>