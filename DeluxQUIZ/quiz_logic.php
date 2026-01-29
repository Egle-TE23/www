<?php
session_start();
include 'dbconnection.php';

$timeTaken = (int)($_POST['time_taken'] ?? 0);

if (!isset( $_SESSION['user_id'],$_SESSION['quiz_started'],$_POST['quiz_id'],$_POST['choices'],$_POST['time_taken'])) 
{
   header("Location: main.php");
    exit;
}

$quizId = (int)$_POST['quiz_id'];
$choices = $_POST['choices'];

// get user id
$stmt = $dbconn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//check this quiz is started
if ($_SESSION['quiz_started'] != $quizId) {
    header("Location: main.php");
    exit;
}
$timeTaken = max(1, min((int)$_POST['time_taken'], 3600));
$totalScore = 0;

// get all questions
$stmt = $dbconn->prepare("SELECT id FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuestions = count($questions);

// check answers
$stmt = $dbconn->prepare( "SELECT is_correct FROM choices WHERE id = ? AND question_id = ?");

foreach ($questions as $question) 
{
    $questionId = $question['id'];
    if (!isset($choices[$questionId])) {
        continue;
    }

    $choiceId = (int) $choices[$questionId];

    $stmt->execute([$choiceId, $questionId]);
    $choice = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($choice && $choice['is_correct'] == 1) {
        $totalScore++;
    }
}

// save (or uppdate) score 

$stmt = $dbconn->prepare(
"INSERT INTO scores (user_id, quiz_id, amount_correct, total_questions, time_taken) VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE amount_correct = VALUES(amount_correct), total_questions = VALUES(total_questions), time_taken = VALUES(time_taken);");
$stmt->execute([$_SESSION["user_id"],$quizId,$totalScore,$totalQuestions,$timeTaken]);

// get the score ID 
$stmt = $dbconn->prepare("SELECT id FROM scores WHERE user_id = ? AND quiz_id = ?");
$stmt->execute([$_SESSION["user_id"], $quizId]);
$scoreResult = $stmt->fetch(PDO::FETCH_ASSOC);
$scoreId = $scoreResult['id'] ?? 0;

// store for results page 
$_SESSION['last_score_id'] = $scoreId;

unset($_SESSION['quiz_started']);

header("Location: quiz_result.php");
