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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script defer src="quiz_script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
        <h1><a href="main.php">LOGO</a></h1>
        <h1><?=$quiz['title'] ?></h1>
        <?php
        $username = "login";
        if (isset($_SESSION["user"])) {
            $username = $_SESSION["user"];
            echo "<h1 class='account'><a href='account.php'>" . $username . "</a></h1>";
        } else {
            echo "<h1 class='account'><a href='login.php'>" . $username . "</a></h1>";
        }
        ?>
    </div>
    <hr>
    <form action="quiz_logic.php" method="post" id="quiz-form">
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
                <h4><?= htmlspecialchars($question['question_text']) ?></h4>
                <?php
                $stmt = $dbconn->prepare("SELECT * FROM choices WHERE question_id = ?");
                $stmt->execute([$question['id']]);
                $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="quiz-options">
                    <?php foreach ($choices as $choice): ?>
                        <div class="quiz-option">
                            <input type="radio" class="form-check-input choice" name="choices[<?= $question['id'] ?>]"
                                value="<?= $choice['id'] ?>">
                            <label class="form-check-label"> <?= htmlspecialchars($choice['choice_text']) ?> </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-primary next-btn" style="display:none"> Next </button>
                <!--next question button not displayed until choice selected-->
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-success" id="submitBtn" style="display:none" onclick="stop()">Submit Quiz</button>
    </form>

</body>

</html>