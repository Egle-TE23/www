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
    <form action="answers.php" method="post" class="main-form">
        <h2>Skriv in ditt namn och börja quizet!!!</h2>
        <label for="name">Name:</label>
        <input type="text" name="name">
        <input type="submit">
    </form>


</body>
</html>