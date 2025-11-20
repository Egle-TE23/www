<?php
session_start();

$errorMessage = "";
if (isset($_SESSION["signuperror"])) {
    $errorMessage = $_SESSION["signuperror"];
    unset($_SESSION["signuperror"]);
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
    <div id="logindiv">
        <?php
        if ($errorMessage != "") {
            echo "<p id='errormsg'>" . $errorMessage . "</p>";
        }
        ?>
        <form action="signuplogic.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <br>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <br>
            <br>
            <button type="submit">Sign up</button>
        </form>
    </div>

</body>

</html>