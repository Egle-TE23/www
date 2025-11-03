<?php
function Median($array){
$sum=0;
foreach($array as $num){
$sum+=$num;
}
$median= $sum/count($array);
return $median;
}
?>