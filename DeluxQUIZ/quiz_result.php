<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['last_score_id'])) {
    header("Location: main.php");
    exit;
}

$scoreId = $_SESSION['last_score_id'];
$stmt = $dbconn->prepare(
    "SELECT s.*, q.title AS quiz_title,u.username 
    FROM scores s JOIN quizzes q ON q.id = s.quiz_id JOIN users u ON u.id = s.user_id WHERE s.id = ?"
);
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
    <title><?= htmlspecialchars($result['quiz_title']) ?></title>
    <?php include("scripts-links.php") ?>
</head>

<body>

<?php include("header.php") ?>

<div class="result-div">

    <h1><?= htmlspecialchars($result['quiz_title']) ?></h1>

    <h2>
        <?= htmlspecialchars($result['username']) ?>
    </h2>

    <div id="quiz-result-div">

        <h3>
            Score:
            <?= $result['amount_correct'] ?>
            /
            <?= $result['total_questions'] ?>
        </h3>

        <h4>
            <?= $result['total_questions'] > 0
                ? round(($result['amount_correct'] / $result['total_questions']) * 100)
                : 0 ?>%
        </h4>

        <p>
            Time taken:
            <strong><?= $result['time_taken'] ?></strong> seconds
        </p>

    </div>

</div>

<hr>

<div class="leaderboard-div">

    <h2>Top 10 Leaderboard</h2>

    <?php if (count($leaderboard) === 0): ?>
        <p>No scores yet.</p>
    <?php else: ?>

        <table class="table table-striped text-center mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Score</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($leaderboard as $i => $row): ?>
                <tr <?= $row['username'] === $result['username'] ? 'class="table-warning"' : '' ?>>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td>
                        <?= $row['amount_correct'] ?>
                        /
                        <?= $row['total_questions'] ?>
                    </td>
                    <td><?= $row['time_taken'] ?>s</td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    <?php endif; ?>

</div>

<div class="text-center mt-4">
    <a href="main.php" class="btn btn-primary">Back to quizzes</a>
</div>
<canvas id="confetti"></canvas>
</body>
</html>
