<?php
    $cookie_name = "message";
    $cookie_value = "Welcome back";
    setcookie($cookie_name, $cookie_value, time() + 10); 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <?php
        if(isset($_COOKIE[$cookie_name])){
            echo $cookie_value;
        }
        else{
            echo "Welcome";
        }
        if(isset($_SESSION["visisted"])){
            echo "<br>Welcome bakckkkk";
        }
        else{
            echo "<br> HI or whatever";
            $_SESSION["visisted"]=true;
        }
    ?>
    <a href="logout.php"><button>Log out</button></a>
</body>
</html>