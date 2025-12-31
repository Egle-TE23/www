<?php
session_start();

include('dbconnection.php');

if (empty($_POST['title']) || empty($_POST['questions'][0]['text'])) {
    die("Missing quiz title or question");
}

$title = trim($_POST['title']);
$question = $_POST['questions'][0];

/* quiz */
$stmt = $dbconn->prepare("INSERT INTO quizzes (title) VALUES (?)");
$stmt->execute([$title]);
$quizId = $dbconn->lastInsertId();

/* media */
$mediaType = $_POST['media_type'] ?? null;
$mediaPath = null;

if (!empty($_FILES['media']['name']) && $mediaType) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid() . '_' . basename($_FILES['media']['name']);
    $targetPath = $uploadDir . $filename;

    move_uploaded_file($_FILES['media']['tmp_name'], $targetPath);
    $mediaPath = $targetPath;
}

/* questions */
$stmt = $dbconn->prepare("
    INSERT INTO questions (quiz_id, question_text, media_type, media_path)
    VALUES (?, ?, ?, ?)
");
$stmt->execute([
    $quizId,
    $question['text'],
    $mediaType,
    $mediaPath
]);

$questionId = $dbconn->lastInsertId();

/* answers */
$correctIndex = $question['correct'];

foreach ($question['choices'] as $index => $choiceText) {
    if (trim($choiceText) === '') continue;

    $isCorrect = ($index == $correctIndex) ? 1 : 0;

    $stmt = $dbconn->prepare("
        INSERT INTO choices (question_id, choice_text, is_correct)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $questionId,
        $choiceText,
        $isCorrect
    ]);
}

/* done */
header("Location: main.php");
exit;