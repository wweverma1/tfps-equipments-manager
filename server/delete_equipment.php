<?php
include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);

$eID=$_REQUEST['eID'];
$cID=$_REQUEST['cID'];

$query1 = "DELETE FROM equipments WHERE id='$eID'"; 
mysqli_query($conn,$query1);

$query2 = "UPDATE categories SET number_of_products=number_of_products-1 WHERE id='$cID' LIMIT 1"; 
mysqli_query($conn,$query2);

header("Location: ../members/myequipments.php"); 

?>