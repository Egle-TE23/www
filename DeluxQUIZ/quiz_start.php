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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script defer src="quiz_script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("header.php") ?>  
    <div id="start-contianer">
        <?php if (!empty($quiz['image'])): ?>
            <img class="card-img-top" id="start-img" src="<?= htmlspecialchars($quiz['image']) ?>" alt="quiz image">
        <?php endif; ?>
        <h1><?= htmlspecialchars($quiz['title']) ?></h1>
        <a href="quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary" onclick="Start()">Start the quiz!</a>
        <div class="leaderboard-div">


        </div>
    </div>
</body>

</html>