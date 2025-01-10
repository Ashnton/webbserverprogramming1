<?php
// login.php
session_start();
require_once 'db.php';

$message = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Spara senaste inloggning
            $stmt = $pdo->prepare("UPDATE customers SET senaste_inloggning = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);

            // Sätt session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['namn'] = $user['namn'];

            // Skicka vidare
            if ($user['is_admin'] == 1) {
                header("Location: admin_dashboard.php");
                exit;
            } else {
                header("Location: select_test.php");
                exit;
            }
        } else {
            $message = "Fel användarnamn eller lösenord!";
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
    <title>Logga in</title>
</head>

<body>
    <h1>Logga in</h1>
    <p style="color:red;"><?php echo $message; ?></p>
    <form method="post">
        <label>Användarnamn:</label><br>
        <input type="text" name="username"><br><br>

        <label>Lösenord:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit" name="login">Logga in</button>
    </form>
    <p><a href="register.php">Skapa nytt konto</a></p>
</body>

</html>