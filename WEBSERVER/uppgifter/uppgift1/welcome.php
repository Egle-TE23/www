<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>

<body>
    <?php include"header.php"?>
    <div class="container">
    <form action="quiz.php" method="post" class="main-form">
        <h2 class="titel">Skriv in ditt namn och börja quizet!!!</h2>
            <label for="name">Namn:</label>
            <input type="text" name="name">
            <input class="submit" type="submit" value="Börja">
    </form>
    </div>
</body>
</html>