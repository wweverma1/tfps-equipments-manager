<?php
include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);

session_start();

$id = $_GET['id']; 
$query = "DELETE FROM notification WHERE id='$id'"; 
mysqli_query($conn ,$query);
header("Location: ../members/dashboard.php"); 
?>
