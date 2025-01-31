<?php
session_start();
if (!$_SESSION["id"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

$test_id = $_GET["test_id"];
$stmt = $conn->prepare("SELECT test_name FROM tests WHERE id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();
$test_name = $stmt->get_result()->fetch_all()[0][0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resultat</title>
</head>

<body>

    <h1><?php echo $test_name; ?></h1>

    <?php
    // Hämta samtliga resultat (om användaren gjort quizet flera gånger)
    $stmt = $conn->prepare("
    SELECT id, score, taken_at 
    FROM results 
    WHERE user_id = ? 
      AND test_id = ?
    ORDER BY taken_at DESC
");
    $stmt->bind_param("ii", $_SESSION["id"], $test_id);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows === 0) {
        echo "<p>Inga gjorda testomgångar hittades för detta test.</p>";
    } else {
        // Gå igenom alla resultat (om man gjort testet flera gånger)
        while ($result = $results->fetch_assoc()) {
            echo "<hr>";
            echo "<h2>Test gjort: " . $result["taken_at"] . "</h2>";
            echo "<p>Poäng: " . $result["score"] . "</p>";

            // Hämta alla frågor för detta test
            $stmtQ = $conn->prepare("
            SELECT id, question_text
            FROM questions
            WHERE is_enabled = 1
              AND test_id = ?
        ");
            $stmtQ->bind_param("i", $test_id);
            $stmtQ->execute();
            $questionsDbResult = $stmtQ->get_result();

            // Skriv ut varje fråga och kolla om användaren svarade rätt eller fel
            while ($question = $questionsDbResult->fetch_assoc()) {
                echo "<h3>" . $question['question_text'] . "</h3>";

                // Hämta användarens svar för just denna fråga + result_id
                $stmtA = $conn->prepare("
                SELECT a.answer_text, ua.is_correct
                FROM user_answers ua
                JOIN answers a ON a.id = ua.answer_id
                WHERE ua.result_id = ?
                  AND ua.question_id = ?
            ");
                $stmtA->bind_param("ii", $result["id"], $question["id"]);
                $stmtA->execute();
                $userAnswerResult = $stmtA->get_result();

                // Om användaren svarade på frågan
                if ($userAnswer = $userAnswerResult->fetch_assoc()) {
                    // Kolla om användarens valda svar var rätt eller fel
                    if ($userAnswer["is_correct"] == 1) {
                        // Visar användarens svar i grönt
                        echo "<p style='color: green;'>Ditt svar: " . $userAnswer["answer_text"] . " (Rätt)</p>";
                    } else {
                        // Visar användarens svar i rött
                        echo "<p style='color: red;'>Ditt svar: " . $userAnswer["answer_text"] . " (Fel)</p>";
                    }
                } else {
                    // Om det saknas användarsvar kan man t.ex. skriva ut detta
                    echo "<p style='color: grey;'>Ingen svar angavs för denna fråga.</p>";
                }
            }
        }
    }
    ?>

    <a href="dashboard.php">Tillbaka</a>
</body>

</html>