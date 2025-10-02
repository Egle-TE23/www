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
    else if($answer!=null){
        $results[$i]="Fråga ".($i+1).": Fel<br>Du svarade: ".$questions[$i][$answer]."<br>Rätt svar: ".$questions[$i][$correctAnswer];         
    }
    else{
         $results[$i]="Fråga ".($i+1).": Fel<br>Du svarade:  <br>Rätt svar: ".$questions[$i][$correctAnswer];         
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