<?php
session_start();

$errorMessage = "";
if (isset($_SESSION["loginError"])) {
    $errorMessage = $_SESSION["loginError"];
    unset($_SESSION["loginError"]);
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
        <h1 style="color:blueviolet; width: fit-content;" class="m-auto ">LOGIN</h1>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <?php
        if ($errorMessage != "") {
            echo "<p id='errormsg'>" . $errorMessage . "</p>";
        }
        ?>
        <button type="submit" class="btn btn-primary login-button">Login</button>
        <div><a href="signup.php" class="login-link">signup instead</a></div>
    </form>
    </div>



</body>

</html>