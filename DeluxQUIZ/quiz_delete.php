<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$quizId = $_POST['quiz_id'] ?? null;

if (!$quizId) {
    header("Location: main.php");
    exit;
}

//check if owner
$stmt = $dbconn->prepare(
    "SELECT owner_id FROM quizzes WHERE id = ?"
);
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    header("Location: main.php");
    exit;
}

//delete
$dbconn->beginTransaction();

$dbconn->prepare(
    "DELETE FROM choices WHERE question_id IN
     (SELECT id FROM questions WHERE quiz_id = ?)"
)->execute([$quizId]);

$dbconn->prepare(
    "DELETE FROM questions WHERE quiz_id = ?"
)->execute([$quizId]);

$dbconn->prepare(
    "DELETE FROM quizzes WHERE id = ?"
)->execute([$quizId]);

$dbconn->commit();

header("Location: account.php");
