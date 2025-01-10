<?php
// admin_view_results.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;

// Hämta test
$stmt = $pdo->prepare("SELECT test_name FROM tests WHERE id = ?");
$stmt->execute([$test_id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$test) {
    echo "Ogiltigt test-id.";
    exit;
}

// a) Namn och poäng rakt upp och ner
$stmt = $pdo->prepare("
    SELECT c.namn, r.score
    FROM results r
    JOIN customers c ON r.customer_id = c.id
    WHERE r.test_id = ?
");
$stmt->execute([$test_id]);
$resultsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

// b) Sorterat efter poäng (desc) och namn (asc)
$stmt2 = $pdo->prepare("
    SELECT c.namn, r.score
    FROM results r
    JOIN customers c ON r.customer_id = c.id
    WHERE r.test_id = ?
    ORDER BY r.score DESC, c.namn ASC
");
$stmt2->execute([$test_id]);
$resultsSorted = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Resultat för <?php echo htmlspecialchars($test['test_name']); ?></title>
</head>

<body>
    <h1>Resultat för <?php echo htmlspecialchars($test['test_name']); ?></h1>
    <p><a href="admin_dashboard.php">Tillbaka</a></p>

    <h2>a) Namn och poäng, rakt upp och ner</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Namn</th>
            <th>Poäng</th>
        </tr>
        <?php foreach ($resultsRaw as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['namn']); ?></td>
                <td><?php echo $row['score']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>b) Sorterat efter poäng (desc) och namn (asc)</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Namn</th>
            <th>Poäng</th>
        </tr>
        <?php foreach ($resultsSorted as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['namn']); ?></td>
                <td><?php echo $row['score']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>