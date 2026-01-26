<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// user id 
$stmt = $dbconn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// empty quiz 
$stmt = $dbconn->prepare("INSERT INTO quizzes (title, description, owner_id)VALUES ('Untitled quiz', 'Quiz Description', ?)");
$stmt->execute([$user['id']]);

$quizId = $dbconn->lastInsertId();

// empty question 
$stmt = $dbconn->prepare("INSERT INTO questions (quiz_id, question_text)VALUES (?,'Question text')");
$stmt->execute([$quizId]);

$questionId = $dbconn->lastInsertId();
$stmt = $dbconn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, 'choice 1', 1)");
$stmt->execute([$questionId]);
$stmt = $dbconn->prepare("INSERT INTO choices (question_id, choice_text, is_correct) VALUES (?, ?, 0)");
//create 4 choices
for ($i = 0; $i < 3; $i++) {
    $stmt->execute([$questionId, 'choice ' . ($i + 2)]);
}
 
header("Location: quiz_edit.php?id=" . $quizId);

