<?php
// admin_dashboard.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

// Hämta alla test
$stmt = $pdo->query("SELECT * FROM tests ORDER BY created_at DESC");
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Välkommen, admin <?php echo $_SESSION['namn']; ?></h1>
    <p><a href="logout.php">Logga ut</a></p>

    <h2>Hantera test</h2>
    <p><a href="admin_create_test.php">Skapa nytt test</a></p>
    <ul>
        <?php foreach ($tests as $test): ?>
            <li>
                <?php echo htmlspecialchars($test['test_name']); ?>
                [ <a href="admin_view_results.php?test_id=<?php echo $test['id']; ?>">Se resultat</a> ]
                [ <a href="admin_charts.php?test_id=<?php echo $test['id']; ?>">Stapeldiagram</a> ]
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>