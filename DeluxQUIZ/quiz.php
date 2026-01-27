<?php
include 'dbconnection.php';
session_start();

$quizId = $_GET['id'] ?? null;

if (!$quizId) {
    header("Location: main.php");
    exit;
}

if (!isset($_SESSION['quiz_started']) || $_SESSION['quiz_started'] != $quizId) {
    header("Location: quiz_start.php?id=" . $quizId);
    exit;
}

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
    <div class="bottom-sticky">
        <h1><?= $quiz['title'] ?></h1>
        <div id="timer">0:00</div>

    </div>


    <form action="quiz_logic.php" method="post" id="quiz-form">
        <input type="hidden" name="time_taken" id="time_taken" value="0"><!--quiz timer-->
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>"> <!--store quiz id for submit-->

        <?php foreach ($questions as $i => $question): ?>
            <div class="question" data-index="<?= $i ?>" <?php if ($i !== 0) {
                  echo 'style="display:none"';
              } ?>>

                <?php if ($question['media_type'] && $question['media_path']): ?>
                    <?php if ($question['media_type'] === 'image'): ?>
                        <img src="<?= htmlspecialchars($question['media_path']) ?>" class="quiz-media img-fluid"
                            alt="Question image">

                    <?php elseif ($question['media_type'] === 'video'): ?>
                        <video class="quiz-media" controls>
                            <source src="<?= htmlspecialchars($question['media_path']) ?>">
                        </video>

                    <?php elseif ($question['media_type'] === 'audio'): ?>
                        <audio class="quiz-media" controls>
                            <source src="<?= htmlspecialchars($question['media_path']) ?>">
                        </audio>
                    <?php endif; ?>

                <?php endif; ?>
                <h4 style="margin:10px;"><?= htmlspecialchars($question['question_text']) ?></h4>
                <?php
                $stmt = $dbconn->prepare("SELECT * FROM choices WHERE question_id = ?");
                $stmt->execute([$question['id']]);
                $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="quiz-options">
                    <?php foreach ($choices as $choice): ?>
                        <div class="quiz-option">
                            <input class="choice" type="radio" id="choice-<?= $choice['id'] ?>" name="choices[<?= $question['id'] ?>]"
                                value="<?= $choice['id'] ?>">

                            <label for="choice-<?= $choice['id'] ?>"> <?= htmlspecialchars($choice['choice_text']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-primary next-btn" style="display:none"> Next </button>
                <!--next question button not displayed until choice selected-->
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-success" id="submitBtn" style="display:none" onclick="stopTimer()">Submit
            Quiz</button>
    </form>

</body>

</html>