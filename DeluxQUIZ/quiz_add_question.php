<?php
include 'dbconnection.php';

$quizId = $_POST['quiz_id'] ?? null;
if (!$quizId) {
    header("Location: main.php");
}

// create question
$stmt = $dbconn->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, 'Question text')");
$stmt->execute([$quizId]);

$questionId = $dbconn->lastInsertId();

// create 4 choices
$stmt = $dbconn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, 'choice 1', 1)");
$stmt->execute([$questionId]);

$stmt = $dbconn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, ?, 0)");
for ($i = 0; $i < 3; $i++) {
    $stmt->execute([$questionId, 'choice ' . ($i + 2)]);
}

header("Location: quiz_edit.php?id=$quizId");