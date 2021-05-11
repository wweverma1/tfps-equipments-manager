<?php
include('config.php');

$cID=$_REQUEST['cID'];

$query = "DELETE FROM categories WHERE id='$cID' LIMIT 1"; 
mysqli_query($conn,$query);

header("Location: ../home/categories.php"); 

?>