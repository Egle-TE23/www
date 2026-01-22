<?php
session_start();

include 'dbconnection.php';

$quizId = $_GET['id'] ?? null;
//get quiz by id
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbconn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$quiz["owner_id"]]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbconn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_SESSION["user"]]);
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);

if($owner['id']!=$current_user['id']){
    header("Location:main.php");
}

//get quiz quesitons
$stmt = $dbconn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

function shorten($text, $maxLength = 100)
{
    $text = trim($text);

    if (mb_strlen($text) <= $maxLength) {
        return htmlspecialchars($text);
    }

    return htmlspecialchars(mb_substr($text, 0, $maxLength)) . '...';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz['title']) ?></title>
    <?php include("scripts-links.php")?>
</head>

<body>
    <?php include("header.php") ?>
    <form id="quiz-edit-form" class="create-form" action="quiz_edit_logic.php" method="POST"
        enctype="multipart/form-data">
        <div>
            <div class="create-questions-div">
                <?php foreach ($questions as $i => $question): ?>
                    <div class="create-question" data-question-id="<?= $question['id'] ?>">
                        <span onclick="showQuestion(<?= $question['id'] ?>)">
                            <?= ($i + 1) . '. ' . shorten($question['question_text'], 15) ?>
                        </span>

                        <button type="submit" form="delete-question-<?= $question['id'] ?>" class="btn btn-sm  delete-question-btn"
                            onclick="return confirm('Delete this question?')">x</button>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-sm add-question-btn" form="add-question">+</button>
            </div>
        </div>

        <div class="edit-question-container">
            <?php foreach ($questions as $i => $question): ?>
                <div class="edit-question-div" data-question-id="<?= $question['id'] ?>"
                    style="<?= $i === 0 ? '' : 'display:none' ?>">

                    <h4>Question <?= $i + 1 ?></h4>
                    <!-- media -->
                    <?php if (!empty($question['media_path'])): ?>
                        <?php if ($question['media_type'] === 'image'): ?>
                            <img src="<?= htmlspecialchars($question['media_path']) ?>" class="create-media">
                        <?php elseif ($question['media_type'] === 'video'): ?>
                            <video controls class="create-media">
                                <source src="<?= htmlspecialchars($question['media_path']) ?>">
                            </video>
                        <?php elseif ($question['media_type'] === 'audio'): ?>
                            <audio controls>
                                <source src="<?= htmlspecialchars($question['media_path']) ?>">
                            </audio>
                        <?php endif; ?>
                    <?php endif; ?>
                    <select class="form-select mb-2 media-type" data-question-id="<?= $question['id'] ?>"
                        name="questions[<?= $question['id'] ?>][media_type]" >
                        <option value="">No media</option>
                        <option value="image" <?php if($question['media_type']=="image")echo "selected"; ?>>Image</option>
                        <option value="video"<?php if($question['media_type']=="video")echo "selected"; ?>>Video</option>
                        <option value="audio"<?php if($question['media_type']=="audio")echo "selected"; ?>>Audio</option>
                    </select>

                    <input type="file" class="form-control mb-3 media-input" data-question-id="<?= $question['id'] ?>"
                        name="media_<?= $question['id'] ?>" accept="image/*,video/*,audio/*" disabled>

                    <!-- options -->
                    <input type="hidden" name="questions[<?= $question['id'] ?>][id]" value="<?= $question['id'] ?>">

                    <input type="text" class="form-control mb-3" name="questions[<?= $question['id'] ?>][text]"
                        value="<?= htmlspecialchars($question['question_text']) ?>" placeholder="Question Text">


                    <div class="quiz-options">
                        <?php
                        $stmt = $dbconn->prepare(
                            "SELECT * FROM choices WHERE question_id = ?"
                        );
                        $stmt->execute([$question['id']]);
                        $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($choices as $choice): ?>
                            <div class="input-group m-2" style="width:95%;">
                                <span class="input-group-text">
                                    <input type="radio" name="questions[<?= $question['id'] ?>][correct]"
                                        value="<?= $choice['id'] ?>" <?= $choice['is_correct'] ? 'checked' : '' ?>>
                                </span>
                                <input type="text" class="form-control"
                                    name="questions[<?= $question['id'] ?>][choices][<?= $choice['id'] ?>]"
                                    value="<?= htmlspecialchars($choice['choice_text']) ?>" placeholder="choice">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="edit-quiz-container">
            <h3>Quiz Settings</h3>
            <?php 
            if($quiz['image']!=null){
                echo '<img src="'. htmlspecialchars($quiz['image']).'"style="width: 100%" class="edit-quiz-div">';
            }
            ?>

            <input type="file" class="edit-quiz-div form-control mb-3" name="image" accept="image/*">

            <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
            <input class="form-control edit-quiz-div" type="text" name="title" placeholder="Quiz Title"
                value="<?= htmlspecialchars($quiz['title']) ?>">
            <textarea class="form-control edit-quiz-div" name="description" placeholder="Quiz Description"
                rows="4"><?= htmlspecialchars($quiz['description']) ?></textarea>

            <input type="submit" class="edit-quiz-div btn btn-primary save-quiz-btn" value="Save Quiz">
            <button form="quiz-delete" type="submit" class="edit-quiz-div btn delete-quiz-btn"> Delete Quiz </button>
        </div>
    </form>


    <!-- hidden form for delete quiz button-->
    <form id="quiz-delete" action="quiz_delete.php" method="POST"
        onsubmit="return confirm('Are you sure you want to delete this quiz? This cannot be undone.')" class="d-none">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
    </form>
    <!-- hidden forms for remove and add question button-->
    <?php foreach ($questions as $question): ?>
        <form id="delete-question-<?= $question['id'] ?>" action="quiz_remove_question.php" method="POST" class="d-none">
            <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
            <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
        </form>
    <?php endforeach; ?>

    <form id="add-question" action="quiz_add_question.php" method="POST" class="d-none">
        <input type="hidden" name="quiz_id" value="<?= $quizId ?>">
    </form>


</body>

</html>