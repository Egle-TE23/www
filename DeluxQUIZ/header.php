<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<div id="header">
<h1><a href="main.php">LOGO</a></h1>
<h1><a href="quiz_create.php">+</a></h1>
<?php
$username = "login";
if (isset($_SESSION["user"])) {
    $username = $_SESSION["user"];
    echo "<h1 class='account'><a href='account.php'>".$username."</a></h1>";
}
else{
    echo "<h1 class='account'><a href='login.php'>".$username."</a></h1>";
}
?>
</div>
<hr>
