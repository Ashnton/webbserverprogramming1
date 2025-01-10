<?php
// show_result.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: login.php");
    exit;
}

$result_id = isset($_GET['result_id']) ? (int)$_GET['result_id'] : 0;

// Hämta resultat
$stmt = $pdo->prepare("
    SELECT r.score, r.taken_at, t.test_name
    FROM results r
    JOIN tests t ON r.test_id = t.id
    WHERE r.id = ?
");
$stmt->execute([$result_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Ogiltigt resultat-id.";
    exit;
}

// Hämta detaljerade svar
$stmt = $pdo->prepare("
    SELECT q.question_text, a.answer_text, ua.is_correct
    FROM user_answers ua
    JOIN questions q ON ua.question_id = q.id
    JOIN answers a ON ua.answer_id = a.id
    WHERE ua.result_id = ?
    ORDER BY q.id
");
$stmt->execute([$result_id]);
$userAnswers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// För att också kunna markera vilket svar som faktiskt är "rätt" om användaren svarat fel
// behöver vi hämta alla korrekta svar parallellt. Men här visar vi en enkel variant
// med "grön text om is_correct=1, annars röd".

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Resultat för <?php echo htmlspecialchars($result['test_name']); ?></title>
</head>

<body>
    <h1>Resultat</h1>
    <p>Test: <?php echo htmlspecialchars($result['test_name']); ?></p>
    <p>Datum: <?php echo $result['taken_at']; ?></p>
    <p>Poäng: <?php echo $result['score']; ?></p>

    <h2>Dina svar</h2>
    <?php foreach ($userAnswers as $ua): ?>
        <?php if ($ua['is_correct']) : ?>
            <p style="color:green;">
                <strong>Fråga:</strong> <?php echo $ua['question_text']; ?><br>
                <strong>Ditt svar (rätt):</strong> <?php echo $ua['answer_text']; ?>
            </p>
        <?php else: ?>
            <p style="color:red;">
                <strong>Fråga:</strong> <?php echo $ua['question_text']; ?><br>
                <strong>Ditt svar (fel):</strong> <?php echo $ua['answer_text']; ?>
            </p>
        <?php endif; ?>
        <hr>
    <?php endforeach; ?>

    <p><a href="select_test.php">Tillbaka till testval</a> |
        <a href="my_results.php">Se mina resultat</a>
    </p>
</body>

</html>