
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
date_default_timezone_set("Europe/Stockholm");
$now = new DateTime();

$customFormatter = new IntlDateFormatter(
    'sv_SE',
    IntlDateFormatter::FULL,
    IntlDateFormatter::SHORT,
    'Europe/Stockholm',
    null,
);

echo "År ".date("Y"). " Månad ".date("m")." Dag ".date("d")." veckodag ". date("l");
echo "<br>";

echo "Hej och välkommen! Dagens datum är ".date("y:m:d")." och klockan är ". date("H:i:sa");
echo "<br>";

echo printDate($customFormatter, $now);

function printDate($customFormatter, $now){
    return "Hej och välkommen! Idag är det " . $customFormatter->format($now) . ".";
}   
?>  

</body>
</html>