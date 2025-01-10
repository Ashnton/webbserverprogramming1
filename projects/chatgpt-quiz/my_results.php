<?php
// my_results.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Hämta alla resultat för denna kund
$stmt = $pdo->prepare("
    SELECT r.id, t.test_name, r.score, r.taken_at
    FROM results r
    JOIN tests t ON r.test_id = t.id
    WHERE r.customer_id = ?
    ORDER BY r.taken_at DESC
");
$stmt->execute([$user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Mina resultat</title>
</head>

<body>
    <h1>Mina resultat</h1>
    <p>Inloggad som: <?php echo $_SESSION['namn']; ?> (<a href="logout.php">Logga ut</a>)</p>

    <?php if ($results): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Testnamn</th>
                <th>Poäng</th>
                <th>Datum</th>
                <th>Detaljer</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['test_name']); ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['taken_at']; ?></td>
                    <td><a href="show_result.php?result_id=<?php echo $row['id']; ?>">Visa svar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Inga resultat hittades.</p>
    <?php endif; ?>

    <p><a href="select_test.php">Tillbaka</a></p>
</body>

</html>