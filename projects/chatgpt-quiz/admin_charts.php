<?php
// admin_charts.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;

// Hämta testnamn
$stmt = $pdo->prepare("SELECT test_name FROM tests WHERE id = ?");
$stmt->execute([$test_id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$test) {
    echo "Ogiltigt test-id.";
    exit;
}

// Räkna hur många som fått 0,1,2,3,4,5 poäng
$scoreCounts = [0, 0, 0, 0, 0, 0]; // index=poäng, value=antal

$stmt2 = $pdo->prepare("SELECT score, COUNT(*) as total FROM results WHERE test_id = ? GROUP BY score");
$stmt2->execute([$test_id]);
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $s = $row['score'];
    $cnt = $row['total'];
    if ($s >= 0 && $s <= 5) {
        $scoreCounts[$s] = $cnt;
    }
}

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Stapeldiagram - <?php echo htmlspecialchars($test['test_name']); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Stapeldiagram för <?php echo htmlspecialchars($test['test_name']); ?></h1>
    <p><a href="admin_dashboard.php">Tillbaka</a></p>

    <canvas id="scoreChart" width="600" height="400"></canvas>

    <script>
        const ctx = document.getElementById('scoreChart').getContext('2d');
        const scoreData = <?php echo json_encode($scoreCounts); ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['0', '1', '2', '3', '4', '5'],
                datasets: [{
                    label: 'Antal resultat',
                    data: scoreData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>

</body>

</html>