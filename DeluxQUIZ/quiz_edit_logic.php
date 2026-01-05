<?php
include 'dbconnection.php';

$quizId = $_GET['id'] ?? $_POST['quiz_id'] ?? null;

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

        //question text and media type
        $stmt = $dbconn->prepare(
            "UPDATE questions SET question_text = ?, media_type = ? WHERE id = ?"
        );
        $stmt->execute([
            $questionData['text'],
            $questionData['media_type'] ?: null,
            $questionId
        ]);

        //media 
        $fileKey = 'media_' . $questionId;

        if (!empty($_FILES[$fileKey]['name'])) {
            $allowed = [
                'image' => ['image/jpeg', 'image/png', 'image/webp'],
                'video' => ['video/mp4', 'video/webm'],
                'audio' => ['audio/mpeg', 'audio/ogg', 'audio/wav']
            ];

            $mediaType = $questionData['media_type'] ?? null;
            $tmp = $_FILES[$fileKey]['tmp_name'];

            if ($mediaType && isset($allowed[$mediaType])) {
                $mime = mime_content_type($tmp);

                if (in_array($mime, $allowed[$mediaType])) {

                    $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
                    $dir = "uploads/quiz_$quizId/";

                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    $filename = "q{$questionId}." . $ext;
                    $path = $dir . $filename;

                    move_uploaded_file($tmp, $path);

                    $stmt = $dbconn->prepare("UPDATE questions SET media_path = ? WHERE id = ?");
                    $stmt->execute([$path, $questionId]);
                }
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
