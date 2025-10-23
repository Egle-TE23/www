<?php
    Class Ball{
        function __construct(public $color,
        public $radius){
            $this->color = $color;
            $this->radius = $radius;
        }
        function return_color(){
            return $this->color;
        }
        function return_radius(){
            return $this->radius;
        }
    }
    Class Football extends Ball{
        public function message(){
            echo "I am a Fotball!";
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
    $Ball = new Ball("Yellow" , "5cm");
    $Football = new Football("White", "20cm");

    echo $Football->return_color();
    echo "<br>";
    echo $Football->return_radius();
    echo "<br>";
    echo $Ball->return_color();
    echo "<br>";
    echo $Ball->return_radius();
    $Football->message();
?>
</body>
</html>