<?php
session_start();
include 'dbconnection.php';
$totalscore = 0;

if (!empty($_POST["quiz_id"]) && !empty($_POST["choices"])) {
    $stmt = $dbconn->prepare("SELECT id FROM questions WHERE quiz_id = ?");
    $stmt->execute([$_POST["quiz_id"]]);
    $questions = $stmt->fetch(PDO::FETCH_ASSOC);

    foreach ($questions as $question) {
        $questionId = $question['id'];
        if (!isset($_POST["choices"][$questionId])) {
            continue;
        }
        $selectedChoiceId = $_POST["choices"][$questionId];

        $stmt = $dbconn->prepare( "SELECT is_correct FROM choices WHERE id = ? AND question_id = ?");
        $stmt->execute([$selectedChoiceId, $questionId]);
        $choice = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($choice && $choice['is_correct'] == 1) {
            $totalscore++;
        }
    }
    // user id 
    $stmt = $dbconn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // create score 
    $stmt = $dbconn->prepare("INSERT INTO scores (quiz_id, user_id, amount_correct, time_taken)VALUES (?,?,?,?)");
    $stmt->execute([$_POST["quiz_id"], $user['id'], $totalscore, 5]);
}

header("Location: quiz_result.php");

