<?php
session_start();

// Kontroll: endast admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../dbconnect.php';

// 1) Hämta test_id från GET (via en länk t.ex. admin_test_results.php?test_id=2)
$test_id = $_GET["test_id"] ?? 0;
$test_id = (int)$test_id;

// 2) Hämta info om det specifika testet
$stmtTest = $conn->prepare("
    SELECT id, test_name, is_enabled
    FROM quizdb_tests
    WHERE id = ?
");
$stmtTest->bind_param("i", $test_id);
$stmtTest->execute();
$testResult = $stmtTest->get_result();
$test = $testResult->fetch_assoc();

// Om inget test hittades, avbryt
if (!$test) {
    echo "<p>Test med id=$test_id hittades ej.</p>";
    exit;
}

// 3) Hämta sammanställning för detta test: antal försök, medelpoäng, min och max
$stmtSummary = $conn->prepare("
    SELECT 
        COUNT(*) AS total_attempts,
        IFNULL(AVG(score), 0) AS average_score,
        IFNULL(MIN(score), 0) AS min_score,
        IFNULL(MAX(score), 0) AS max_score
    FROM quizdb_results
    WHERE test_id = ?
");
$stmtSummary->bind_param("i", $test_id);
$stmtSummary->execute();
$summaryResult = $stmtSummary->get_result();
$summary = $summaryResult->fetch_assoc();

// 4) Hämta alla individuella resultat för detta test
$stmtResults = $conn->prepare("
    SELECT r.id AS result_id,
           r.score,
           r.taken_at,
           u.username
    FROM quizdb_results r
    JOIN quizdb_users u ON r.user_id = u.id
    WHERE r.test_id = ?
    ORDER BY r.taken_at DESC
");
$stmtResults->bind_param("i", $test_id);
$stmtResults->execute();
$allResults = $stmtResults->get_result();
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Admin - Resultat för <?php echo htmlspecialchars($test["test_name"]); ?></title>
</head>

<body>
    <h1>Resultat för test: <?php echo htmlspecialchars($test["test_name"]); ?></h1>

    <p>
        <strong>Testets status:</strong>
        <?php echo ($test["is_enabled"] == 1) ? "Aktivt" : "Inaktivt"; ?>
    </p>

    <hr>
    <h2>Sammanställning</h2>
    <p>
        <strong>Antal gjorda försök:</strong> <?php echo $summary["total_attempts"]; ?><br>
        <strong>Medelpoäng:</strong> <?php echo round($summary["average_score"], 2); ?><br>
        <strong>Lägsta poäng:</strong> <?php echo $summary["min_score"]; ?><br>
        <strong>Högsta poäng:</strong> <?php echo $summary["max_score"]; ?>
    </p>

    <hr>
    <h2>Individuella resultat</h2>

    <?php if ($allResults->num_rows === 0) : ?>
        <p>Inga resultat registrerade ännu för detta test.</p>
    <?php else : ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Användare</th>
                    <th>Poäng</th>
                    <th>Genomförd</th>
                    <th>Mer info</th> <!-- Om du vill länka till en detaljsida -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $allResults->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["username"]); ?></td>
                        <td><?php echo (int)$row["score"]; ?></td>
                        <td><?php echo $row["taken_at"]; ?></td>
                        <td>
                            <!-- Exempel-länk, om du t.ex. vill visa detaljerade svar: -->
                            <a href="view_details.php?result_id=<?php echo $row["result_id"]; ?>">
                                Visa detaljer
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>