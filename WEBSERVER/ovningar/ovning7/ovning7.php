
<?php 
class Ball{
    public $color;
    public $rad;

    function __constructor($color, $rad){
        $this->color =$color;
        $this->rad =$rad;}
    function get_info(){
        return "$this->color $this->rad";
    }
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
<?php 
$ball=new Ball("Blue", "12");
echo $ball->get_info();
?>
</body>
</html>