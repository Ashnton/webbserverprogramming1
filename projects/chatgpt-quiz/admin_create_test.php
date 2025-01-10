<?php
// admin_create_test.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

$message = '';
if (isset($_POST['create'])) {
    $test_name = trim($_POST['test_name']);
    if (!empty($test_name)) {
        $stmt = $pdo->prepare("INSERT INTO tests (test_name) VALUES (?)");
        $stmt->execute([$test_name]);
        $newTestId = $pdo->lastInsertId();

        // Skicka vidare för att lägga till frågor
        header("Location: admin_create_questions.php?test_id=$newTestId");
        exit;
    } else {
        $message = "Testnamn får inte vara tomt!";
    }
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Skapa nytt test</title>
</head>

<body>
    <h1>Skapa nytt test</h1>
    <p style="color:red;"><?php echo $message; ?></p>
    <form method="post">
        <label>Testnamn:</label><br>
        <input type="text" name="test_name"><br><br>
        <button type="submit" name="create">Skapa test</button>
    </form>
    <p><a href="admin_dashboard.php">Tillbaka</a></p>
</body>

</html>