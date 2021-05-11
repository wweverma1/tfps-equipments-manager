<?php
include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);
session_start();
$mid = $_SESSION['user']['id']; 
$query = "DELETE FROM notification WHERE rid='$mid'"; 
mysqli_query($conn ,$query);
header("Location: ../members/notifications.php"); 
?>