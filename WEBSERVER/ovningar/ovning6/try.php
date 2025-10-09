<?php 
$error = "";
$success = "";


if($_POST["fname"]=="NAME"){
    $_SESSION['error'] = "NAME IS NAME!!";
    header("location:form.php");
    die();
}
?>