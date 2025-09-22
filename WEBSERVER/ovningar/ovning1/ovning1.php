<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php 
    $fahrenheit = 65;
    $celsius = (5/9)*($fahrenheit-32);
    echo $fahrenheit;
    echo "<br>".$celsius;

    $fnamn = "Kalle";
	$enamn = "Anka";
	$tal = 16;
	$road = "Ankvägen";
    echo "<br>$fnamn $enamn bor på $road $tal";
    echo '<br>$fnamn $enamn bor på $road $tal';
    echo "<br>".$fnamn." ".$enamn." bor på ".$road." ".$tal;

    $sum =0;
    for ($x=0; $x<=100;$x++)
    {
        $sum=$sum+$x;
    }
    echo "<br>".$sum;
    $sum2 =0;
    $x2=0;
    while ($x2<=100)
    {
        $sum2=$sum2+$x2;
        $x2++;
    }
    echo "<br>".$sum2;
    
    echo "<br><br>MANUAL";
    $Celsius = -20;
    $FahGrader = array();
    $CelGrader = array();
    while($Celsius <= 40)
    {
        echo "<br>".$Celsius;
        $Fahrenheit = (9/5)*$Celsius+32;
        echo " ".$Fahrenheit;
        $FahGrader[]=$Fahrenheit;
        $CelGrader[]=$Celsius;
        $Celsius=$Celsius+10;
    }

    echo "<br><br>FOR EACH";
    echo "<br>F<br>";
    foreach($FahGrader as $x)
    {
        echo "$x <br>";
    }
    echo "<br>C<br>";
    foreach($CelGrader as $x)
    {
        echo "$x <br>";
    }

    echo "<br><br>VAR_DUMP";
    echo "<br>F<br>";
    var_dump($FahGrader);
    echo "<br>C<br>";
    var_dump($CelGrader);

    echo "<br><br>PRINT_R";
    echo "<br>F<br>";
    print_r($FahGrader);
    echo "<br>C<br>";
    print_r($CelGrader);

    echo "<br><br>5 array";
    $numArray= array(1);
    for($x=1; $x<=10;$x++)
    {
        $numArray[$x]=($numArray[$x-1]*2);
    }
    var_dump($numArray);

    echo "<br><br>6 primtal";
    for($x=0; $x<=99;$x++)
    {
        if (isPrime($x))
        {
            echo "$x <div>";
        }
    }

    function isPrime($num){
    if ($num <= 1) {return false;}
    for ($x = 2; $x < $num; $x++;) {
        if ($num % $x == 0) {
            return = false; 
        }
                else
        {return true;}
    }
    }
    
    ?>
</body>
</html>