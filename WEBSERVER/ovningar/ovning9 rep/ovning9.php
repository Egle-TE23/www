<?php
//uppgift 1
$numarray =[];
for($x=1; $x<=10; $x++){
    if($x==1){
        $numarray[$x] =1;
    }
    else{
        $numarray[$x] = $numarray[$x-1]*2;}
echo $numarray[$x]." ";
}
$sum=0;
foreach($numarray as $num){
$sum+=$num;
}
echo "medelvärde = ".$sum/10;

//uppgift 2
function Smallest($num1, $num2, $num3){
$smallest = $num1;
if($smallest>$num2){
    $smallest = $num2;
}
if($smallest>$num3){
    $smallest =$num3;
}
return $smallest;
}

$smal = Smallest(1,3,2);
echo "<br>".$smal;

//uppgift 3
include("ovning9 func.php");
echo "<br>Medelvärdet= ".Median($numarray);
$_POST("");

//uppgift 4

?>