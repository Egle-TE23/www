<?php
session_start();
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
        <form action="reset-password-logic.php" method="POST" class="login-form">
            <h1 style="color:blueviolet; width: fit-content;" class="m-auto ">Reset password</h1>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="email" class="form-control" name="email" required placeholder="Your email">
            </div>

            <button type="submit" class="btn btn-primary login-button">Send reset link</button>

            <?php
            if (isset($_SESSION['reset_msg'])) {
                echo "<p>{$_SESSION['reset_msg']}</p>";
                unset($_SESSION['reset_msg']);
            }
            ?>
        </form>
</body>

</html>