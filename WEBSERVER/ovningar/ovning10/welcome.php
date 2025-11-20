<?php
session_start();
if (!(isset($_SESSION["user"]))) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ovning10.css">
</head>

<body>
    <div id="welcome">
        <h1 id="titel">WELCOME TO MY WEBSITE FELLOW LOGER INNER</h1>
        <button><a id="logoutbtn" href="logout.php">Logout</a></button>
    </div>

</body>

</html>