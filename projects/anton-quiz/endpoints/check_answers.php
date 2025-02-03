<?php
session_start();
if (!$_SESSION["id"]) {
    header('Location: ../index.php');
    die();
}

require_once __DIR__ . '/../dbconnect.php';

// Vi utgår från att test_id skickas via POST när användaren skickar in quizet
$test_id = $_POST["test_id"];

// Sätt in grundrad i results med score = 0
$zero = 0;
$stmt = $conn->prepare("
    INSERT INTO quizdb_results (user_id, test_id, score) 
    VALUES (?, ?, ?)
");
$stmt->bind_param("iii", $_SESSION["id"], $test_id, $zero);

if (!$stmt->execute()) {
    echo 'Kunde inte lägga till rad i results';
    die();
}

// Hämta det nyskapade id:t för results-raden
$result_id = $conn->insert_id;

// Hämta frågor som tillhör testet
$stmt = $conn->prepare("
    SELECT id 
    FROM quizdb_questions 
    WHERE test_id = ?
");
$stmt->bind_param("i", $test_id);
$stmt->execute();
$questionsResult = $stmt->get_result();

$score = 0; // Håll koll på antal rätta svar

// Loopar igenom varje fråga
while ($question = $questionsResult->fetch_assoc()) {
    $questionId = $question["id"];

    // Hämta alla *aktiva* svarsalternativ för denna fråga
    $stmtAnswers = $conn->prepare("
        SELECT id, answer_text, is_correct 
        FROM quizdb_answers 
        WHERE question_id = ? 
          AND is_enabled = 1
    ");
    $stmtAnswers->bind_param("i", $questionId);
    $stmtAnswers->execute();
    $answersDbResult = $stmtAnswers->get_result();

    // Hämta vilket svar användaren skickade in för denna fråga
    // (OBS! Om en fråga saknar $_POST-värde, ex. ej besvarats, ger det null/inget)
    $userPostedAnswer = $_POST["question-" . $questionId] ?? null;

    // Jämför användarens postade svar med varje möjligt svarsalternativ
    while ($answer = $answersDbResult->fetch_assoc()) {
        // Om användarens postade svar matchar texten i databasen
        if ($userPostedAnswer == $answer["answer_text"]) {
            // Infoga rad i user_answers
            $stmtUA = $conn->prepare("
                INSERT INTO quizdb_user_answers (result_id, question_id, answer_id, is_correct) 
                VALUES (?, ?, ?, ?)
            ");
            $stmtUA->bind_param("iiii", 
                $result_id, 
                $questionId, 
                $answer["id"], 
                $answer["is_correct"]
            );
            
            if (!$stmtUA->execute()) {
                echo 'Kunde inte lägga till användarens svar i tabellen user_answers';
                die();
            }

            // Öka poängen om svaret var korrekt
            if ($answer["is_correct"] == 1) {
                $score++;
            }

            // När vi väl har hittat användarens matchande svar 
            // kan vi bryta för denna fråga (förutsätter single-choice).
            break;
        }
    }
}

// Nu när vi har loopat igenom alla frågor och vet total score, uppdaterar vi results-raden
$stmtUpdate = $conn->prepare("
    UPDATE quizdb_results 
    SET score = ? 
    WHERE id = ?
");
$stmtUpdate->bind_param("ii", $score, $result_id);
$stmtUpdate->execute();

// Skicka användaren vidare när allt är färdigt
header('Location: ../logged-in/dashboard.php');
exit;
