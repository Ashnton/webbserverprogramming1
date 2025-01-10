<?php
// quiz.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: login.php");
    exit;
}

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;

// Hämta testinfo
$stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ?");
$stmt->execute([$test_id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$test) {
    echo "Ogiltigt test!";
    exit;
}

// Hämta frågor + svar
$stmt = $pdo->prepare("
    SELECT q.id as question_id, q.question_text, a.id as answer_id, a.answer_text
    FROM questions q
    JOIN answers a ON q.id = a.question_id
    WHERE q.test_id = ?
    ORDER BY q.id
");
$stmt->execute([$test_id]);
$data = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

// $data kommer då se ut som [ question_id => [ 0 => [...], 1 => [...], ... ] ]

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($test['test_name']); ?></title>
</head>

<body>
    <h1><?php echo htmlspecialchars($test['test_name']); ?></h1>
    <form action="save_quiz.php" method="post">
        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
        <?php foreach ($data as $question_id => $answersArray): ?>
            <?php
            // Alla poster i $answersArray har samma question_text men olika answer_id/answer_text
            $question_text = $answersArray[0]['question_text'];
            ?>
            <h3><?php echo $question_text; ?></h3>
            <?php foreach ($answersArray as $row): ?>
                <label>
                    <input type="radio" name="question_<?php echo $question_id; ?>"
                        value="<?php echo $row['answer_id']; ?>">
                    <?php echo $row['answer_text']; ?>
                </label><br>
            <?php endforeach; ?>
            <br>
        <?php endforeach; ?>
        <button type="submit">Skicka in svar</button>
    </form>
</body>

</html>