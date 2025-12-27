<?php
session_start();

include('dbconnection.php');

if (isset($_POST["username"])) {
    $user = $_POST["username"];
}
if (isset($_POST["password"])) {
    $pass = $_POST["password"];
}

if (!(isset($pass) && isset($user))) {
    header("Location: signup.php");
}

$sql = "SELECT * FROM users WHERE username =?";
$stmt = $dbconn->prepare($sql);

// parameters in array, if empty we could skip the $data-variable
$data = array($user);
$stmt->execute($data);

$res = $stmt->fetch(PDO::FETCH_ASSOC);

if(!empty($res)){
    $_SESSION["signupError"] = "User already exists";
    header("Location: signup.php");
    die();
}

$sql = "INSERT INTO users (username,password) VALUES (?,?)";
$stmt = $dbconn->prepare($sql);

// parameters in array, if empty we could skip the $data-variable
$data = array($user, password_hash( $pass, PASSWORD_DEFAULT));
$stmt->execute($data);

$_SESSION["signupError"] = "User resistration succes!";

header("Location: signup.php");

?>