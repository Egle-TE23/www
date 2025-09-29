<?php
session_start();



include "questions.php";

$score=0;
$total=count($questions);
$results = [];
$name = isset($_SESSION['name'])? $_SESSION['name']: "INGEN";

for($i=0; $i<count($questions); $i++){
    $answer = isset($_POST["q".$i]) ? $_POST["q".$i] : null;
    $correctAnswer = $questions[$i][count($questions[$i])-1];

    if($answer==$correctAnswer){
        $score++;
        $results[$i]="Fråga ".($i+1).": Rätt!";
    }
    else{
        $results[$i]="Fråga ".($i+1).": Fel<br>Du svarade: ".$questions[$i][$answer]."<br>Rätt svar: ".$questions[$i][$correctAnswer];         
    }
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
    <?php include "header.php";?>

    <div class="container">
    <?php
    echo "<h4>Grattis ". htmlspecialchars($name)." du fick ".$score."/".$total." rätt</h4>";
    foreach($results as $result){
        echo "<br><h5>".$result."</h5>";
    }
    ?>
    </div>
</body>
</html>