<?php
session_start();

// Kontroll: endast admin
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../dbconnect.php';

// 1) Hämta result_id från GET
$result_id = $_GET['result_id'] ?? 0;
$result_id = (int)$result_id;
if ($result_id <= 0) {
    echo "<p>Ogiltigt resultat-id.</p>";
    exit;
}

// 2) Hämta övergripande info om resultatet (användare, test etc.)
$stmtResultInfo = $conn->prepare("
    SELECT r.id AS result_id,
           r.score,
           r.taken_at,
           t.test_name,
           u.username
    FROM results r
    JOIN tests t ON r.test_id = t.id
    JOIN users u ON r.user_id = u.id
    WHERE r.id = ?
");
$stmtResultInfo->bind_param("i", $result_id);
$stmtResultInfo->execute();
$resultInfoData = $stmtResultInfo->get_result();
$resultInfo = $resultInfoData->fetch_assoc();

if (!$resultInfo) {
    echo "<p>Resultatet kunde inte hittas.</p>";
    exit;
}

// 3) Hämta info om alla frågor + svarsalternativ som användaren valt
$stmtDetails = $conn->prepare("
    SELECT q.question_text, a.answer_text, ua.is_correct
    FROM user_answers ua
    JOIN questions q ON ua.question_id = q.id
    JOIN answers a ON ua.answer_id = a.id
    WHERE ua.result_id = ?
    ORDER BY q.id
");
$stmtDetails->bind_param("i", $result_id);
$stmtDetails->execute();
$detailsResult = $stmtDetails->get_result();
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8" />
    <title>Detaljer - Resultat</title>
</head>

<body>

    <h1>Detaljer för resultat #<?php echo $resultInfo["result_id"]; ?></h1>

    <p>
        <strong>Användare:</strong> <?php echo htmlspecialchars($resultInfo["username"]); ?><br>
        <strong>Testnamn:</strong> <?php echo htmlspecialchars($resultInfo["test_name"]); ?><br>
        <strong>Poäng:</strong> <?php echo (int)$resultInfo["score"]; ?><br>
        <strong>Genomförd:</strong> <?php echo $resultInfo["taken_at"]; ?>
    </p>

    <hr>

    <h2>Valda svar</h2>

    <?php if ($detailsResult->num_rows === 0) : ?>
        <p>Inga svar registrerade för detta resultat.</p>
    <?php else : ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Fråga</th>
                    <th>Användarens svar</th>
                    <th>Rätt/Fel</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $detailsResult->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["question_text"]); ?></td>
                        <td><?php echo htmlspecialchars($row["answer_text"]); ?></td>
                        <td style="<?php echo ($row["is_correct"] == 1) ? 'color:green;' : 'color:red;'; ?>">
                            <?php echo ($row["is_correct"] == 1) ? "Rätt" : "Fel"; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>