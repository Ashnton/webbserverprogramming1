<?php
session_start();

// Kontrollera att man är admin
if (!$_SESSION["is_admin"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

$test_id = $_GET["test_id"] ?? 0;

// 1) Hämta testets information
$stmt = $conn->prepare("SELECT id, test_name, is_enabled FROM quizdb_tests WHERE id=?");
$stmt->bind_param("i", $test_id);
$stmt->execute();
$test = $stmt->get_result()->fetch_assoc();

if (!$test) {
    echo "Testet hittades inte.";
    die();
}

$test_name = $test["test_name"];
$is_enabled = $test["is_enabled"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redigera test</title>
</head>
<body>
    <h1>Redigera test: <?php echo htmlspecialchars($test_name); ?></h1>

    <!-- FORM för att uppdatera is_enabled -->
    <form action="../endpoints/admin/update_enabled.php" method="POST">
        <input type="hidden" name="test_id" value="<?php echo $test["id"]; ?>">

        <h3>Testet är aktivt?</h3>
        <label>
            <input type="radio" name="is_enabled" value="1"
                <?php echo ($is_enabled == 1) ? 'checked' : ''; ?>>
            Ja
        </label>
        <label>
            <input type="radio" name="is_enabled" value="0"
                <?php echo ($is_enabled == 0) ? 'checked' : ''; ?>>
            Nej
        </label>
        <br><br>
        <input type="submit" value="Uppdatera status">
    </form>

    <hr>

    <h2>Frågor i testet</h2>
    <?php
    // 2) Hämta samtliga frågor som hör till test_id
    $stmt = $conn->prepare("SELECT id, question_text FROM quizdb_questions WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $questionsDbResult = $stmt->get_result();

    if ($questionsDbResult->num_rows === 0) {
        echo "<p>Inga frågor har lagts till i detta test ännu.</p>";
    } else {
        while ($question = $questionsDbResult->fetch_assoc()) {
            ?>
            <div style="margin-bottom: 20px;">
                <h3>Fråga: <?php echo htmlspecialchars($question["question_text"]); ?></h3>

                <?php
                // 3) Hämta de svarsalternativ som hör till frågan
                $stmtAnswers = $conn->prepare("
                    SELECT id, answer_text, is_correct, is_enabled
                    FROM quizdb_answers
                    WHERE question_id = ?
                ");
                $stmtAnswers->bind_param("i", $question["id"]);
                $stmtAnswers->execute();
                $answersDbResult = $stmtAnswers->get_result();

                if ($answersDbResult->num_rows === 0) {
                    echo "<p style='color: grey;'>Inga svarsalternativ skapade ännu.</p>";
                } else {
                    echo "<ul>";
                    while ($answer = $answersDbResult->fetch_assoc()) {
                        // Visa texten för svaret, markera om det är rätt
                        $correctText = $answer["is_correct"] ? " (Rätt svar)" : "";
                        $enabledText = $answer["is_enabled"] ? "" : " [Inaktivt]";
                        echo "<li>"
                           . htmlspecialchars($answer["answer_text"])
                           . $correctText
                           . $enabledText
                           . "</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
            <?php
        }
    }
    ?>

    <a href="dashboard.php">Tillbaka</a>
</body>
</html>
