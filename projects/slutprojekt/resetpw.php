<?php

session_start();

require __DIR__ . '/../../dbconnect.php';
require_once __DIR__ . '/functions/test_inputs.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $dbconn->prepare('SELECT email FROM slutprojekt_hungry_users WHERE login_token = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
?>
        <form method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">Nytt lösenord:</label>
            <input type="password" name="password" required>
            <label for="confirm_password">Bekräfta lösenord:</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">Återställ lösenord</button>
        </form>
<?php
    } else {
        echo 'Ogiltig token.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo 'Lösenorden matchar inte.';
        exit;
    }

    $stmt = $dbconn->prepare('SELECT email FROM slutprojekt_hungry_users WHERE login_token = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $dbconn->prepare('UPDATE slutprojekt_hungry_users SET password = ? WHERE login_token = ?');
        $stmt->execute([$hashed_password, $token]);

        header("Location: endpoints/login.php?token=$token");
    } else {
        echo 'Ogiltig token.';
    }
} else {
    echo 'Ogiltig begäran.';
}
