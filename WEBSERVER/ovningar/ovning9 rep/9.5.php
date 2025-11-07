<?php 
session_start();  
if(!isset($_SESSION["guesses"])) $_SESSION["guesses"] =0;
if(!isset($_SESSION["randomNum"])) $_SESSION["randomNum"] = rand(0,10);
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="9.5.php" method="post">
    <label for="num">Enter a number</label>
    <input type="text" name="num" id="num">
    <br>
    <input type="submit" value="test">
    </form>
    <?php 
    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
    $_SESSION["num"] = htmlspecialchars($_POST["num"]);
    if(empty($_SESSION["num"])){echo "no number given";}
    if($_SESSION["num"]=="restart"){echo ""; $_SESSION["randomNum"] = rand(0,10);  $_SESSION['guesses']=0;}
    else if ($_SESSION["num"]> $_SESSION["randomNum"] ){ $_SESSION['guesses']+=1; echo "wrong, you have guessed ".$_SESSION['guesses']." times the answer is lower!";}
    else if ($_SESSION["num"]< $_SESSION["randomNum"] ){ $_SESSION['guesses']+=1;echo "wrong, you have guessed ".$_SESSION['guesses']." times the answer is higher!";}
    else if ($_SESSION["num"]== $_SESSION["randomNum"]){ $_SESSION['guesses']+=1; echo "WOW YOU GOT IT RIGHT";}
    }
    ?> 

</body>
</html>