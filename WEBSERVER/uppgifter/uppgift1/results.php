<?php
session_start();



require "questions.php";

$score=0;
$total=count($questions);
$results = [];
$name = isset($_SESSION['name'])? $_SESSION['name']: "onämd person";
if ($name == ""){
    $name = "onämd person";
}

for($i=0; $i<count($questions); $i++){
    $answer = isset($_POST["q".$i]) ? $_POST["q".$i] : null;
    $correctAnswer = $questions[$i][count($questions[$i])-1];

    if($answer==$correctAnswer){
        $score++;
        $results[$i]="Fråga ".($i+1).": Rätt!<br>".$questions[$i][0]."<br>Du svarade: ".$questions[$i][$answer]."<br>Rätt svar: ".$questions[$i][$correctAnswer];
    }
    else if($answer!=null){
        $results[$i]="Fråga ".($i+1).": Fel<br>".$questions[$i][0]."<br>Du svarade: ".$questions[$i][$answer]."<br>Rätt svar: ".$questions[$i][$correctAnswer];         
    }
    else{
         $results[$i]="Fråga ".($i+1).": Fel<br>".$questions[$i][0]."<br>Du svarade:  <br>Rätt svar: ".$questions[$i][$correctAnswer];         
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
    if($score==0){echo "<h4>Ajsan bajsan ". htmlspecialchars($name).", du fick ".$score."/".$total."... inte ens en? ojsan</h4>";
    }
    else if($score<$total/2){echo "<h4>Ajsan ". htmlspecialchars($name).", du fick ".$score."/".$total." rätt... kunde ha vart bättre.</h4>";}
    else if($score==$total){echo "<h4>WOW PERFEKT ". htmlspecialchars($name)."! du fick ".$score."/".$total." rätt!!!!</h4>";}
    else{echo "<h4>Bra jobbat ". htmlspecialchars($name)."! du fick ".$score."/".$total." rätt!! Nästan bra!</h4>";}
    echo '<div class="results">';
        foreach($results as $result){
        echo "<br><h5>".$result."</h5>";
    }
    echo'</div>';

    ?>
    <button type="button"class="againbtn"><a href="welcome.php">SPELA IGEN!</a></button>
    </div>
</body>
</html>