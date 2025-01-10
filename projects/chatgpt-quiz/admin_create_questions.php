<?php
// admin_create_questions.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : 0;

// Kolla om testet finns
$stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ?");
$stmt->execute([$test_id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$test) {
    echo "Ogiltigt test-id.";
    exit;
}

if (isset($_POST['save'])) {
    // I denna enkla variant lägger vi in en fråga i taget, eller alla på en gång.
    // Exempel: vi förväntar oss en form med 5 block av (fråga + 3 svar + 1 radioknapp).
    // Men här görs endast ETT block. Expandera efter behov.

    // Här är ett exempel på att spara EN fråga med 3 svar:
    $question_text = trim($_POST['question_text']);
    $answers = $_POST['answers'];       // array av text
    $correctIndex = $_POST['correct'];  // index (0,1,2) på rätt svar

    if (!empty($question_text) && !empty($answers)) {
        // 1. Skapa frågan
        $stmtQ = $pdo->prepare("INSERT INTO questions (test_id, question_text) VALUES (?, ?)");
        $stmtQ->execute([$test_id, $question_text]);
        $question_id = $pdo->lastInsertId();

        // 2. Skapa svarsalternativen
        for ($i = 0; $i < count($answers); $i++) {
            $isCorrect = ($i == $correctIndex) ? 1 : 0;
            $stmtA = $pdo->prepare("INSERT INTO answers (question_id, answer_text, is_correct) 
                                    VALUES (?, ?, ?)");
            $stmtA->execute([$question_id, $answers[$i], $isCorrect]);
        }

        $msg = "Fråga + svar skapade!";
    } else {
        $msg = "Alla fält krävs!";
    }
    echo "<p style='color:green;'>{$msg}</p>";
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Skapa frågor för <?php echo htmlspecialchars($test['test_name']); ?></title>
</head>

<body>
    <h1>Skapa frågor för <?php echo htmlspecialchars($test['test_name']); ?></h1>

    <form method="post">
        <label>Frågetext:</label><br>
        <input type="text" name="question_text" style="width:400px;"><br><br>

        <label>Svarsalternativ:</label><br>
        <p>
            <input type="text" name="answers[]" placeholder="Svar 1" style="width:300px;">
            <input type="radio" name="correct" value="0"> Rätt?
        </p>
        <p>
            <input type="text" name="answers[]" placeholder="Svar 2" style="width:300px;">
            <input type="radio" name="correct" value="1"> Rätt?
        </p>
        <p>
            <input type="text" name="answers[]" placeholder="Svar 3" style="width:300px;">
            <input type="radio" name="correct" value="2"> Rätt?
        </p>

        <button type="submit" name="save">Spara fråga</button>
    </form>

    <hr>
    <p>När du skapat alla frågor: <a href="admin_dashboard.php">Tillbaka till Admin Dashboard</a></p>
</body>

</html>