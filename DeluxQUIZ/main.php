<?php
session_start();
include 'dbconnection.php';
// quiz search
$search = trim($_GET['q'] ?? '');
$isSearch = $search !== '';

if ($isSearch) {
    $title = 'RESULTS FOR "' . htmlspecialchars($search) . '"';
    $stmt = $dbconn->prepare("SELECT * FROM quizzes WHERE title LIKE ? ORDER BY id DESC LIMIT 42");
    $stmt->execute(['%' . $search . '%']);
} else {
    $title = "RECENTLY CREATED QUIZZES";
    $stmt = $dbconn->prepare("SELECT * FROM quizzes ORDER BY id DESC LIMIT 24");
    $stmt->execute();
}

$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$quizChunks = array_chunk($quizzes, 3);


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
    <div>
        <div class="quiz-search-container">
            <form method="get" action="main.php" class="quiz-search">
                <input type="text" name="q" placeholder="Search quizzes..."
                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="form-control searchbar">

                <button type="submit" value="submit" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg></button>

            </form>
        </div>

        <h1 class="title"><?php echo $title; ?></h1>

        <?php if (count($quizzes) === 0): ?>

            <div class="text-center mt-5">
                <h3>No results found</h3>
                <?php if ($isSearch): ?>
                    <p class="no-results"> We couldn't find anything matching "<?= htmlspecialchars($search) ?>"</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <div id="quizCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php foreach ($quizChunks as $index => $chunk): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="d-flex justify-content-center gap-3">
                                <?php foreach ($chunk as $quiz): ?>
                                    <div class="card" style="width: 15rem;">
                                        <?php if (!empty($quiz['image'])): ?>
                                            <img class="card-img-top" src="<?= htmlspecialchars($quiz['image']) ?>" alt="quiz image">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?= htmlspecialchars($quiz['title']) ?>
                                            </h5>
                                            <p class="card-text">
                                                <?= shorten($quiz['description'], 80) ?>
                                            </p>
                                            <div class="mt-auto m-2 d-flex gap-2">
                                                <a href="quiz_start.php?id=<?= $quiz['id'] ?>" class="btn btn-primary btn-sm w-100">
                                                    Play
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($quizzes) > 3): ?>

                    <button class="carousel-control-prev" type="button" data-bs-target="#quizCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#quizCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    </div>

    <hr class="mt-5">
</body>

</html>