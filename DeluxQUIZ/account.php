<?php
session_start();
include 'dbconnection.php';

//get user py username
$user = $_SESSION["user"];
$stmt = $dbconn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$user]);
$userId = $stmt->fetch(PDO::FETCH_ASSOC);
//get quiz by id
$stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE owner_id = ?");
$stmt->execute([$userId['id']]);
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Document</title>
    <?php include("scripts-links.php") ?>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <h1 class="title">Your Quizzes</h1>
    <div class="quiz-display">
        <?php foreach ($quizzes as $i => $quiz): ?>
            <div class="card" style="width: 15rem;">
                <?php if (($quiz['image']) != null) {
                    echo "<img class='card-img-top' src='" . htmlspecialchars($quiz['image']) . "' alt='quiz image'>";
                }
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($quiz['title']) ?></h5>
                    <p class="card-text"><?= shorten($quiz['description'], 80) ?></p>
                </div>
                
                <div class="mt-auto m-2 d-flex gap-2">
                    <a href="quiz_start.php?id=<?= $quiz['id'] ?>" class="btn btn-primary btn-sm w-100">
                        Play
                    </a>
                    <a href="quiz_edit.php?id=<?= $quiz['id'] ?>" class="btn btn-outline-secondary btn-sm w-100">
                        Edit
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="card create-card card" style="width: 15rem;">
            <form action="quiz_create.php" method="post" class="create-card-form">
                <button type="submit" class="create-card-btn card-body">
                    <span class="plus">+</span>
                </button>
            </form>
        </div>
    </div>
    <button class="btn btn-primary center-btn" id="logoutbtn"><a  href="logout.php">Logout</a></button>
</body>

</html>