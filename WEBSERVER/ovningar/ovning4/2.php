<?php
if(isset($_GET["num1"])){
    echo ($_GET["num1"] + $_GET["num2"] + $_GET["num3"])/3; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="GET"></form>
    <input type="number" name="num1">
    <input type="number" name="num2">
    <input type="number" name="num3">
    <input type="submit" value="Medelvärde">
</body>
</html>