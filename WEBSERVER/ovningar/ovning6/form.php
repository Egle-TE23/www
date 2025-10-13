<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['error'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
</head>
<body>
    <form action="try.php" method="post">
        <input type="text" name="fname">
        <label for="fname">NAME</label>
        <br>
        <input type="text" name="lname">
        <label for="fname">LAST NAME</label>
        <br>
        <input type="text" name="email">
        <label for="fname">EMAIL</label>
        <br>
        <button type="submit">CLICK</button>
    </form>
    <?php
    if (empty($error)){
    echo "alll goooddd";
    }
    else{
    foreach ($error as $err) {
        echo "<p style='color:red;'>$err</p>";
    }} 
    ?>
    <h1>2</h1>
    <form action="2.php" method="post">
        <input type="text" name="username">
        <label for="username">username</label>
        <br>
        <input type="text" name="password">
        <label for="password">password</label>
        <br>

        <button type="submit">CLICK</button>
    </form>
</body>
</html>