<?php
// select_test.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    // Endast inloggad "vanlig" kund får vara här
    header("Location: login.php");
    exit;
}

// Hämta alla test
$stmt = $pdo->query("SELECT * FROM tests");
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Välj frågetest</title>
</head>

<body>
    <h1>Välj frågetest</h1>
    <p>Inloggad som: <?php echo $_SESSION['namn']; ?> (<a href="logout.php">Logga ut</a>)</p>

    <ul>
        <?php foreach ($tests as $test): ?>
            <li>
                <?php echo htmlspecialchars($test['test_name']); ?>
                <a href="quiz.php?test_id=<?php echo $test['id']; ?>">Starta test</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><a href="my_results.php">Mina resultat</a></p>
</body>

</html>