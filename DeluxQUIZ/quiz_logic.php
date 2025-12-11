<?php
session_start();

include('dbconnection.php');

if (isset($_POST["answer"])) {
    $answer = $_POST["answer"];
}

$sql = "SELECT * FROM quiz WHERE username =?";
$stmt = $dbconn->prepare($sql);

// parameters in array, if empty we could skip the $data-variable
$data = array($user);
$stmt->execute($data);

$res = $stmt->fetch(PDO::FETCH_ASSOC);


if (password_verify($pass, $res["password"])) {
    $_SESSION["user"] = $res["username"];
    header("Location: welcome.php");
} else {
    $_SESSION["loginError"] = "Wrong username or password";
    header("Location: login.php");
}