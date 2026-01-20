<?php
session_start();
include 'dbconnection.php';

if (!isset($_POST['quiz_id'], $_POST['choices'], $_SESSION['user'])) {
    header("Location: main.php");
    exit;
}

$quizId = (int)$_POST['quiz_id'];
$choices = $_POST['choices'];
$totalScore = 0;

/* get all questions */
$stmt = $dbconn->prepare(
    "SELECT id FROM questions WHERE quiz_id = ?"
);
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuestions = count($questions);

/* check answers */
foreach ($questions as $question) {

    $questionId = $question['id'];

    if (!isset($choices[$questionId])) {
        continue;
    }

    $selectedChoiceId = (int)$choices[$questionId];

    $stmt = $dbconn->prepare(
        "SELECT is_correct 
         FROM choices 
         WHERE id = ? AND question_id = ?"
    );
    $stmt->execute([$selectedChoiceId, $questionId]);
    $choice = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($choice && $choice['is_correct'] == 1) {
        $totalScore++;
    }
}

/* get user id */
$stmt = $dbconn->prepare(
    "SELECT id FROM users WHERE username = ?"
);
$stmt->execute([$_SESSION['user']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* save score */
$stmt = $dbconn->prepare(
    "INSERT INTO scores 
    (quiz_id, user_id, amount_correct, total_questions, time_taken)
    VALUES (?, ?, ?, ?, ?)"
);

$stmt->execute([
    $quizId,
    $user['id'],
    $totalScore,
    $totalQuestions,
    5
]);

$scoreId = $dbconn->lastInsertId();

/* store for results page */
$_SESSION['last_score_id'] = $scoreId;

header("Location: quiz_result.php");
