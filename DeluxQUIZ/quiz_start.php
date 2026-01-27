<?php
include 'dbconnection.php';
session_start();
unset($_SESSION['last_score_id']);

$quizId = $_GET['id'] ?? null;

if (!$quizId) {
    header("Location: main.php");
    exit;
}
if(!$_SESSION['username']){
    header("Location: login.php");
    exit;
}


//get quiz by id
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    header("Location: main.php");
    exit;
}

$stmt = $dbconn->prepare("SELECT id FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$amountQuestions = count($questions);

if ($amountQuestions === 0) {
    header("Location: main.php");
    exit;
}

// Validate each question has a correct answer
$stmt = $dbconn->prepare("SELECT q.id FROM questions q WHERE q.quiz_id = ? AND NOT EXISTS (SELECT 1 FROM choices c WHERE c.question_id = q.id AND c.is_correct = 1)");
$stmt->execute([$quizId]);
$questionsWithoutAnswers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($questionsWithoutAnswers)) {
    header("Location: main.php");
    exit;
}

$_SESSION['quiz_started'] = $quizId;

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
        <div>
            <h5>Questions: <?= htmlspecialchars($amountQuestions) ?></h5>
            <h5>Description: 
                <?php 
                if($quiz["description"] != "")
                {echo htmlspecialchars($quiz["description"]);}
                else{
                    echo "No description to be found";
                } ?></h5>
        </div>
        <div class="leaderboard-div">


        </div>
    </div>
</body>

</html>