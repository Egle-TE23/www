<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname =  htmlspecialchars($_POST["fname"]);
    $lastname =  htmlspecialchars($_POST["lname"]);
    $email =  htmlspecialchars($_POST["email"]);
    $error = [];
    if (!preg_match("/^[A-ZÅÄÖ][a-zåäö]+$/", $firstname)) {
        $error[] = "name must start with capital letter!";
    } 
     if (!preg_match("/^[A-ZÅÄÖ][a-zåäö]+$/", $lastname)) {
        $error[] = "last name must start with capital letter!";
    } 
     if (!preg_match("/([@])\w+/", $email)) {
        $error[] = "email must contain @!";
    } 
    
    if (empty($error)){
        echo "alll goooddd";
    }
    else{
    foreach ($error as $err) {
        echo "<p style='color:red;'>$err</p>";
    }}
}

?>