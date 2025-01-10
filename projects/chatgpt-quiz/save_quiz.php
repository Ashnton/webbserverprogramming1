<?php
// save_quiz.php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $test_id = (int)$_POST['test_id'];
    $customer_id = $_SESSION['user_id'];

    // 1. Hämta alla frågor och korrekta svar för detta test
    $stmt = $pdo->prepare("
        SELECT q.id AS question_id, a.id AS answer_id, a.is_correct
        FROM questions q
        JOIN answers a ON q.id = a.question_id
        WHERE q.test_id = ?
    ");
    $stmt->execute([$test_id]);
    $answersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Arrangera svaren i en form [question_id => [ answer_id => is_correct ]]
    $correctMap = [];
    foreach ($answersData as $row) {
        $qId = $row['question_id'];
        $aId = $row['answer_id'];
        $isCorrect = $row['is_correct'];
        $correctMap[$qId][$aId] = $isCorrect;
    }

    // 2. Räkna ut poäng
    $score = 0;

    // Samla ihop user-answers i en array för att sen spara
    $userAnswers = [];

    foreach ($correctMap as $qId => $answerArr) {
        if (isset($_POST["question_$qId"])) {
            $chosenAnswerId = (int)$_POST["question_$qId"];
            $isCorrect = $answerArr[$chosenAnswerId] ?? 0;
            if ($isCorrect == 1) {
                $score++;
            }
            // Lägg i userAnswers
            $userAnswers[] = [
                'question_id' => $qId,
                'answer_id' => $chosenAnswerId,
                'is_correct' => $isCorrect
            ];
        } else {
            // Om inget svarats på frågan
            $userAnswers[] = [
                'question_id' => $qId,
                'answer_id' => 0,
                'is_correct' => 0
            ];
        }
    }

    // 3. Spara resultat (score) i tabellen results
    $stmt = $pdo->prepare("INSERT INTO results (customer_id, test_id, score) VALUES (?, ?, ?)");
    $stmt->execute([$customer_id, $test_id, $score]);
    $result_id = $pdo->lastInsertId();

    // 4. Spara varje enskilt svar i user_answers
    $stmtUA = $pdo->prepare("INSERT INTO user_answers (result_id, question_id, answer_id, is_correct)
                            VALUES (?, ?, ?, ?)");
    foreach ($userAnswers as $ua) {
        $stmtUA->execute([$result_id, $ua['question_id'], $ua['answer_id'], $ua['is_correct']]);
    }

    // 5. Skicka användaren till en resultatsida (t.ex. show_result.php)
    header("Location: show_result.php?result_id=$result_id");
    exit;
} else {
    echo "Felaktig anropsmetod.";
    exit;
}
