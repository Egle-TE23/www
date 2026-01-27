<?php
include 'dbconnection.php';

$token = $_POST['token'];
$pass  = $_POST['password'];
$conf  = $_POST['confirm'];

if ($pass !== $conf) {
    die("Passwords do not match.");
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $dbconn->prepare(
    "UPDATE users
     SET password = ?,
         reset_token = NULL,
         reset_expires = NULL
     WHERE reset_token = ?
     AND reset_expires > NOW()"
);

$stmt->execute([$hash, $token]);

if ($stmt->rowCount() === 0) {
    die("Reset token expired.");
}

echo "Password updated. You can now log in.";
