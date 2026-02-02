<?php
session_start();
include 'dbconnection.php';

unset($_SESSION['quiz_started']);//again just to make sure
if (!isset($_SESSION['last_score_id'])) {
    header("Location: main.php");
    exit;
}

$scoreId = $_SESSION['last_score_id'];
$stmt = $dbconn->prepare("SELECT s.*, q.title AS quiz_title,u.username FROM scores s JOIN quizzes q ON q.id = s.quiz_id JOIN users u ON u.id = s.user_id WHERE s.id = ?");
$stmt->execute([$scoreId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$quizId = $result['quiz_id'];

/* leaderboard stuff*/
$stmt = $dbconn->prepare(
    "SELECT u.username,s.amount_correct,s.total_questions,s.time_taken
     FROM scores s JOIN users u ON u.id = s.user_id
     WHERE s.quiz_id = ? ORDER BY s.amount_correct DESC, s.time_taken ASC LIMIT 10"
);
$stmt->execute([$quizId]);
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($result['quiz_title']) ?></title>
    <?php include("scripts-links.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="conffeti-script.js" defer></script>
</head>

<body>
    <?php include("header.php") ?>

    <div id="result-div">

        <h1><?= htmlspecialchars($result['quiz_title']) ?></h1>
        <div class="start-container" id="quiz-result-div">

            <h3>
                Score: <?= $result['amount_correct'] ?> / <?= $result['total_questions'] ?>
            </h3>
            <script>
                const scorePercent = <?= $result['total_questions'] > 0 ? round(($result['amount_correct'] / $result['total_questions']) * 100) : 0 ?>;
            </script>
            
            <h4>
                <?= $result['total_questions'] > 0 ? round(($result['amount_correct'] / $result['total_questions']) * 100) : 0 ?>%
            </h4>

            <p class="yellow-text-sm">
                Time taken: <strong><?= $result['time_taken'] ?></strong> seconds
            </p>

        </div>
        <hr class="m-auto">

        <?php include 'leaderboard.php'; ?>

        <div class="text-center mt-4 results-btn-container">
            <a href="main.php" class="btn btn-primary">Back to quizzes</a>
            <a href=<?= "quiz_start.php?id=" . $quizId ?> class="btn btn-primary">Try again</a>
        </div>
    </div>

    <canvas id="confetti-canvas"></canvas>
</body>

</html>