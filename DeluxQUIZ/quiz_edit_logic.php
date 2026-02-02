<?php
session_start();
include 'dbconnection.php';

$quizId = $_GET['id'] ?? $_POST['quiz_id'] ?? null;

if ($quizId == null) {
    header("Location: account.php");
    exit;
}
// check if quiz has required fields
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE id = ?");
$stmt->execute([$quizId]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (
    empty($_POST['title']) ||
    empty($_POST['description'])
) {
    $_SESSION['editError'] = "Quiz must have title and description.";
    header("Location: quiz_edit.php?id=$quizId");
    exit;
}
// Each question has text
if (!empty($_POST['questions'])) {
    foreach ($_POST['questions'] as $questionId => $questionData) {
        if (
            !isset($questionData['text']) ||
            trim($questionData['text']) === ''
        ) {
            $_SESSION['editError'] = "Each question must have text.";
            header("Location: quiz_edit.php?id=$quizId");
            exit;
        }
    }
}


// At least one question exists
$stmt = $dbconn->prepare("SELECT COUNT(*) as count FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questionCount = $stmt->fetch(PDO::FETCH_ASSOC);

if ($questionCount['count'] === 0) {
    $_SESSION['editError'] = "Quiz must have at least one question.";
    header("Location: quiz_edit.php?id=$quizId");
    exit;
}

// Each question has a correct answer
$stmt = $dbconn->prepare("SELECT q.id FROM questions q WHERE q.quiz_id = ? AND NOT EXISTS (SELECT 1 FROM choices c WHERE c.question_id = q.id AND c.is_correct = 1)");//checks if each question has atleast 1 correct
$stmt->execute([$quizId]);
$questionsWithoutAnswers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($questionsWithoutAnswers)) {
    $_SESSION['editError'] = "Each question must have a correct answer.";
    header("Location: quiz_edit.php?id=$quizId");
    exit;
}

// quiz title
if (isset($_POST['title']) && isset($_POST['description'])) {
    $stmt = $dbconn->prepare("UPDATE quizzes SET title = ?, description = ? WHERE id = ?");
    $stmt->execute([$_POST['title'], $_POST['description'], $quizId]);
}
//image
if (!empty($_FILES['image']['name'])) {
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
    $tmp = $_FILES['image']['tmp_name'];
    $mime = mime_content_type($tmp);

    if (in_array($mime, $allowedMimes)) {

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $dir = "uploads/quiz_$quizId/";

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = "quiz_image.$ext";
        $path = $dir . $filename;

        move_uploaded_file($tmp, $path);

        $stmt = $dbconn->prepare(
            "UPDATE quizzes SET image = ? WHERE id = ?"
        );
        $stmt->execute([$path, $quizId]);
    }
}
// questions + choices
if (!empty($_POST['questions'])) {
    foreach ($_POST['questions'] as $questionId => $questionData) {
        if (empty($questionData['text'])) {
            continue;
        }
        if (!isset($questionData['correct'])) {
            $_SESSION['editError'] = "Each question must have a correct answer.";
            header("Location: quiz_edit.php?id=$quizId");
            exit;
        }
        //question text and media type
        $stmt = $dbconn->prepare("UPDATE questions SET question_text = ?, media_type = ? WHERE id = ?");
        $stmt->execute([$questionData['text'], $questionData['media_type'] ?: null, $questionId]);

        //media 
        $fileKey = 'media_' . $questionId;

        $fileKey = 'media_' . $questionId;

        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['name'] !== '') {

            $error = $_FILES[$fileKey]['error'];

            if ($error !== UPLOAD_ERR_OK) {
                switch ($error) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $_SESSION['editError'] = "File too large for question $questionId. Max size is " . ini_get('upload_max_filesize');
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $_SESSION['editError'] = "Upload was incomplete for question $questionId.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $_SESSION['editError'] = "No file uploaded for question $questionId.";
                        break;
                    default:
                        $_SESSION['editError'] = "Unknown upload error for question $questionId.";
                }

                header("Location: quiz_edit.php?id=$quizId");
                exit;
            }

            $tmp = $_FILES[$fileKey]['tmp_name'];
            if (!file_exists($tmp) || $tmp === '') {
                $_SESSION['editError'] = "Temporary file missing for question $questionId. File may be too large.";
                header("Location: quiz_edit.php?id=$quizId");
                exit;
            }

            $mediaType = $questionData['media_type'] ?? null;
            $allowed = [
                'image' => ['image/jpeg', 'image/png', 'image/webp'],
                'video' => ['video/mp4', 'video/webm'],
                'audio' => ['audio/mpeg', 'audio/ogg', 'audio/wav']
            ];

            if ($mediaType && isset($allowed[$mediaType])) {
                $mime = mime_content_type($tmp); // now safe
                if (!in_array($mime, $allowed[$mediaType])) {
                    $_SESSION['editError'] = "Invalid file type for question $questionId.";
                    header("Location: quiz_edit.php?id=$quizId");
                    exit;
                }

                $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
                $dir = "uploads/quiz_$quizId/";
                if (!is_dir($dir))
                    mkdir($dir, 0755, true);

                $filename = "q{$questionId}." . $ext;
                $path = $dir . $filename;

                move_uploaded_file($tmp, $path);

                $stmt = $dbconn->prepare("UPDATE questions SET media_path = ? WHERE id = ?");
                $stmt->execute([$path, $questionId]);
            }
        }

        //choices
        foreach ($questionData['choices'] as $choiceId => $choiceText) {
            $stmt = $dbconn->prepare(
                "UPDATE choices SET choice_text = ? WHERE id = ?"
            );
            $stmt->execute([$choiceText, $choiceId]);
        }

        //correct answer
        $stmt = $dbconn->prepare(
            "UPDATE choices SET is_correct = 0 WHERE question_id = ?"
        );
        $stmt->execute([$questionId]);

        if (isset($questionData['correct'])) {
            $stmt = $dbconn->prepare(
                "UPDATE choices SET is_correct = 1 WHERE id = ?"
            );
            $stmt->execute([$questionData['correct']]);
        }
    }
}

header("Location: quiz_edit.php?id=$quizId");
exit;
