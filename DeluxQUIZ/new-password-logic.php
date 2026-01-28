<?php
include 'dbconnection.php';

$token = $_POST['token'];
$pass  = $_POST['password'];
$conf  = $_POST['confirm'];

if ($pass !== $conf) {
    die("Passwords do not match.");
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $dbconn->prepare("UPDATE users SET password = ?,reset_token = NULL, reset_expires = NULL WHERE reset_token = ? AND reset_expires > NOW()");

$stmt->execute([$hash, $token]);

if ($stmt->rowCount() === 0) {
    die("Reset token expired.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include("scripts-links.php") ?>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div style="margin:50px;">
    <form action="loginlogic.php" method="post" class="login-form">
        <h1 style="color:blueviolet; width: fit-content;" class="m-auto ">Password updated. You can now log in.</h1>
        <button type="submit" class="btn btn-primary login-button">Login</button>
    </div>
</body>

</html>