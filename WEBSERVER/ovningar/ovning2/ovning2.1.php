<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php  
    $amount=5;
    Write($amount); 
    function Write($amount){
        for ($amount>=0; $amount--;)
        {
            echo "Tjaba Tjena Hallå! <br>";
        }
    }
    echo "<br><br> _3 <br>";
    $num1 =20;
    $num2 =10;
    $num3 = 0;
    $largest = Large($num1,$num2,$num3);
    echo $largest;
    function Large($num1,$num2,$num3){
        $biggest =$num1;
        if($biggest<$num2)$biggest=$num2;
        if($biggest<$num3)$biggest=$num3;
        return $biggest;
    }

    echo "<br><br> _4 <br>";
    $numarray =array(1,2,3,18);
    Median($numarray);
    function Median($array){
        sort($array);
        $arrayCount = count($array);
        if($arrayCount % 2 == 0){
           $num1=($array[($arrayCount/2)]);
           $num2=($array[(($arrayCount/2)-1)]);
           echo (($num1+$num2)/2);
        }
        else{
            echo ($array[($arrayCount/2)-0.5]);
        }
    }

        echo "<br><br> _5 <br>";
        $array2 = array();
        for($x=10; $x>=0; $x--){
            $array2[] = rand(1,100);
        }
        print_r($array2);
        Remove($array2);
        function Remove($array){
            for($x =10; $x>=0; $x--){
                if(($array[$x]) % 2 == 0){
                    $array[$x]=0;
                }
            }
            echo "<br>";
            print_r($array);
        }

        echo "<br><br> _6 <br>";
        $array3 = array();
        for($x=10; $x>=0; $x--){
            $array3[] = rand(1,100);
        }
        sort($array3);
        print_r($array3);
        echo"<br>";
        Median($array3);
        echo Medelvarde($array3);
        
        function Medelvarde($array){
            $sum =0;
            for($x=count($array); $x>=0; $x--){
                $sum += $array[$x];
            }
            return $sum/(count($array));
        }


    ?>
</body>
</html>
