<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

    echo "Amount of primes: ",HowManyPrimes(...range(100,1000,1));
    
    function HowManyPrimes(...$numbers){
        $manyPrimes =0;
        $numAmount = count($numbers);

        for($x =0; $x < $numAmount; $x++){
            $isPrime = true;

            if($x<=1) $isPrime = false;

            else if($numbers[$x] % $x ==0)
            {
                $isPrime=false;
            }
            if ($isPrime == true)$manyPrimes++;
            }
        return $manyPrimes;}

       
    ?>
</body>
</html>