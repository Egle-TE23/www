<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* Get user id */
$stmt = $dbconn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['user']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* Create empty quiz */
$stmt = $dbconn->prepare("INSERT INTO quizzes (title, description, owner_id)VALUES ('Untitled quiz', '', ?)");
$stmt->execute([$user['id']]);

$quizId = $dbconn->lastInsertId();

/* Redirect to editor */
header("Location: quiz_create.php?id=" . $quizId);
exit;
