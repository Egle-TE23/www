<?php
include 'dbconnection.php';
session_start();

$questionId = $_POST['question_id'] ?? null;
$quizId = $_POST['quiz_id'] ?? null;

if (!$questionId || !$quizId) {
    header("Location: main.php");
}

$stmt = $dbconn->prepare("SELECT COUNT(*) FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$count = $stmt->fetchColumn();

if ($count <= 1) {
    $_SESSION['editError'] = "A quiz must have at least one question.";
    header("Location: quiz_edit.php?id=$quizId");
    exit;
}

// delete choices
$stmt = $dbconn->prepare("DELETE FROM choices WHERE question_id = ?");
$stmt->execute([$questionId]);

// delete question
$stmt = $dbconn->prepare("DELETE FROM questions WHERE id = ?");
$stmt->execute([$questionId]);

header("Location: quiz_edit.php?id=$quizId");
