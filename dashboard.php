<?php 
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

echo "Hello: ".$_SESSION["username"];
?>

<a href="logout.php">logout</a>