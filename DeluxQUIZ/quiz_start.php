<?php
include 'dbconnection.php';

$quizId = $_GET['id'] ?? 1;//get id from GET in if null 1 (for testing)
//get quiz by id
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbconn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$quizId]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbconn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$quiz["owner_id"]]);
$creator = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <div id="start-contianer">
        <?php if (!empty($quiz['image'])): ?>
            <img class="card-img-top" id="start-img" src="<?= htmlspecialchars($quiz['image']) ?>" alt="quiz image">
        <?php endif; ?>
        <h1><?= htmlspecialchars($quiz['title']) ?></h1>
        <a href="quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary" onclick="Start()">Start the quiz!</a>
        <h6>created by: <?= htmlspecialchars($creator['username']) ?></h6>
        <div class="leaderboard-div">


        </div>
    </div>
</body>

</html>