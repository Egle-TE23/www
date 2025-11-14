<?php 

include ('dbconnection.php');

if(isset($_POST["username"]) ){
    $user =$_POST["username"];
}
if(isset($_POST["password"]) ){
    $pass =$_POST["password"];
}

if(!(isset($pass) && isset($user))){
    header("Location: ../login.php");
}
$sql = "SELECT * FROM users WHERE username =? AND password =?";
$stmt = $dbconn->prepare($sql);

// parameters in array, if empty we could skip the $data-variable
$data = array($user,$pass);
$stmt->execute($data);

$res = $stmt->fetchAll();
$output = htmlentities(print_r($res, 1));
echo "<pre>$output</pre>";
?>