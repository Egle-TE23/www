<?php 
session_start(); 
include "questions.php";
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
    
    <form action="results.php" method="post" class="main-form">
        <?php for($i=0; $i<count($questions); $i++)
        {
        echo '<div class="question" id="q'.$i.'">';
        echo $questions[$i][0];
        for($ii=1; $ii<count($questions[$i])-1; $ii++)
        {
        echo '<br><label for="">'.$questions[$i][$ii].'</label>';
        echo '<input type="radio" name="q'.$i.'">';
        }
        echo '</div>';
        }?>

    </form>


</body>
</html>