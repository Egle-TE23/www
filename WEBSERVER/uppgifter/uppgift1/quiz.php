<?php 
session_start(); 
include "questions.php";

if (isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
}
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
    <form action="results.php" method="post" class="main-form">
        <?php 
        for($i=0; $i<count($questions); $i++)
        {
        echo '<div class="question'.($i==0 ? ' active':'').'" id="q'.$i.'">';
        echo '<h3>'.$questions[$i][0].'</h3><div class="options">';

        for($ii=1; $ii<count($questions[$i])-1; $ii++)
        {   
        echo 
        '<label>
        <input class="radio" type="radio" name="q'.$i.'" value="'.$ii.'">'.$questions[$i][$ii].'
        </label>';
        }
        echo '</div>';
        if($i>0){
            echo '<button onclick="Previous('.$i.')" type="button">Förra</button>';
        }
         if($i<count($questions)-1){
            echo '<button onclick="Next('.$i.')" type="button";>Nästa</button>';
        }
        echo '</div>';
        }?>

        <input class="submit" id="submit" type="submit" value="RÄTTA">
    </form>
    </div>

</body>
</html>