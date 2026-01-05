<?php
session_start();
include 'dbconnection.php';

//quiz search
$search = $_GET['q'] ?? '';
$title = "";
if ($search !== '') //display quizzes that match search
{
    $stmt = $dbconn->prepare(" SELECT *FROM quizzes WHERE title LIKE ? ORDER BY id DESC LIMIT 20");
    $stmt->execute(['%' . $search . '%']);
} else //display most recently created quizes
{
    $title = "RECENTLY CREATED QUIZES";
    $stmt = $dbconn->prepare(" SELECT * FROM quizzes ORDER BY id DESC LIMIT 12");
    $stmt->execute();
}
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

function shorten($text, $maxLength = 100)
{
    $text = trim($text);

    if (mb_strlen($text) <= $maxLength) {
        return htmlspecialchars($text);
    }

    return htmlspecialchars(mb_substr($text, 0, $maxLength)) . '...';
}

$quizChunks = array_chunk($quizzes, 3); //för att visa 3 av quizzen i taget
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
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
                                            <a href="quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary btn-sm w-100">
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

            <button class="carousel-control-prev" type="button" data-bs-target="#quizCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#quizCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>


    </div>
</body>

</html>