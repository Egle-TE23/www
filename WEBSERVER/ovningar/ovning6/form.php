<?php
session_start();

$error = "";
$succes ="";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $capital = "/^[A-Z][a-zA-Z]*$/";

    if (preg_match($capital,$_POST["fname"])==0) {
        $error = "name must start with capital letter!";
    } else {
        $succes = "all good";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
</head>
<body>
    <form action="form.php" method="post">
        <input type="text" name="fname">
        <label for="fname">NAME</label>
        <span style="color:red;"><?php echo $error; ?></span>
        <br>
        <input type="text" name="lname">
        <label for="fname">LAST NAME</label>
        <br>
        <input type="name" name="email">
        <label for="fname">EMAIL</label>
        <br>

        <button type="submit">CLICK</button>
    </form>
</body>
</html>