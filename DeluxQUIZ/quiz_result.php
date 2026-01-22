<?php
include 'dbconnection.php';
if (!isset($_SESSION)) {
    session_start();
}

$quizId = $_GET['id'] ?? 1;//get id from GET in if null 1 (for testing)
//get quiz by id
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);
//get quiz quesitons
$stmt = $dbconn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz['title']) ?></title>
    <?php include("scripts-links.php") ?>
</head>

<body>
    <?php include("header.php") ?>
    <h1> <?= $quiz["title"] ?></h1>
    <div class="result-div">
        <h1> <?= $username ?></h1>
        <div id="quiz-result-div"></div>
        <div id="res-time"></div>
    </div>
    <div class="leaderboard-div">
        <h2>Leaderboard</h2>
        <div>
            <ul>
                <li></li>
            </ul>
        </div>
    </div>

</body>

</html>