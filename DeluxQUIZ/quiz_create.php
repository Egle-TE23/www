<?php
include 'dbconnection.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script defer src="quiz_script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form class="create-form" action="quiz_create-logic.php" method="POST" enctype="multipart/form-data">
        <h1><a href="main.php">LOGO</a></h1>
        <div class="">
            <input type="text" name="title" placeholder="Quiz Title">
            <input type="submit" value="Save Quiz">
        </div>
        <div>
            <div class="create-questions-div">
                <div class="create-question">
                    <span class="create-question-text"> 1. Question...</span>
                    <button onclick="remonveThisQuestion()" class="btn">
                        x
                    </button>
                </div>
                <button onclick="addQuestion()" class="btn">
                    +
                </button>
            </div>
        </div>

        <div>
            <img src="images/placeholder.png" alt="" class="create-media">
            <select name="media_type">
                <option value="">No media</option>
                <option value="image">Image</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
            </select>
            <input type="file" name="media">

            <h4 id="questionNumber">Question 1</h4>
            <input type="text" class="form-control mb-3" name="questions[0][text]" placeholder="Question text">

            <div id="answers">
                <?php for ($i = 0; $i < 4; $i++): ?>
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="radio" name="questions[0][correct]" value="<?= $i ?>">
                        </span>
                        <input type="text" class="form-control" name="questions[0][choices][<?= $i ?>]"
                            placeholder="Choice <?= $i + 1 ?>">
                    </div>
                <?php endfor; ?>
            </div>

        </div>

    </form>

</body>

</html>