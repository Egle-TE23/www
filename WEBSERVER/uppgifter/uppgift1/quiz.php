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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>
    <?php include"header.php"?>
    
    <div class="container">
    <form action="results.php" method="post" class="main-form">
        <?php for($i=0; $i<count($questions); $i++)
        {
        echo '<div class="question'.($i==0 ? 'active':'').'" id="q'.$i.'">';
        echo '<h3>'.$questions[$i][0].'</h3>';

        for($ii=1; $ii<count($questions[$i])-1; $ii++)
        {   
        echo 
        '<label>
        <input type="radio" name="q'.$i.'" value="'.$ii.'">'.$questions[$i][$ii].'
        </label><br>';
        }
        
        if($i>0){
            echo '<button onclick="Previous('.$i.')" type="button">Förra</button>';
        }
         if($i<count($questions)-1){
            echo '<button onclick="Next('.$i.')" type="button";>Nästa</button>';
        }
        echo '</div>';
        }?>

        <input type="submit" value="Rätta">
    </form>
    </div>

</body>
</html>