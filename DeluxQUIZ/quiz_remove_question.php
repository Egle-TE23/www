<?php
include 'dbconnection.php';

$questionId = $_POST['question_id'] ?? null;
$quizId = $_POST['quiz_id'] ?? null;

if (!$questionId || !$quizId) {
    header("Location: main.php");
}

// delete choices
$stmt = $dbconn->prepare("DELETE FROM choices WHERE question_id = ?");
$stmt->execute([$questionId]);

// delete question
$stmt = $dbconn->prepare("DELETE FROM questions WHERE id = ?");
$stmt->execute([$questionId]);

header("Location: quiz_edit.php?id=$quizId");
