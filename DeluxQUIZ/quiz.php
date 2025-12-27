<?php
include 'dbconnection.php';

$quizId = $_GET['id'] ?? 1;

$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <script defer src="quiz_sxript.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php echo "<h1>".htmlspecialchars($quiz['title'])."</h1>"; ?>
    <form action="quiz_logic.php" method="post" id="quizForm">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">

        <?php foreach ($questions as $i => $question): ?>
            <div class="question" data-index="<?= $i ?>" <?= $i !== 0 ? 'style="display:none"' : '' ?>>
                <h4><?= htmlspecialchars($question['question_text']) ?></h4>
                <?php
                $stmt = $dbconn->prepare("SELECT * FROM choices WHERE question_id = ?");
                $stmt->execute([$question['id']]);
                $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($choices as $choice): ?>
                    <div class="form-check">
                        <input type="radio" class="form-check-input choice" name="choices[<?= $question['id'] ?>]"
                            value="<?= $choice['id'] ?>">
                        <label class="form-check-label">
                            <?= htmlspecialchars($choice['choice_text']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <button type="button" class="btn btn-primary next-btn" style="display:none"> Next </button>

            </div>

        <?php endforeach; ?>

        <button type="submit" class="btn btn-success" id="submitBtn" style="display:none">
            Submit Quiz
        </button>

    </form>

</body>

</html>