<?php
	include('../server/config.php');
  	$conn = mysqli_connect($host, $username, $password, $database);
	session_start(); 
	if ($_SESSION['user']['role']!='M')
    {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
	}
?>

<html>

<head>
<title>Equipment Categories | TFPS</title>
</head>

<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

	<h3>Select Category</h3>
	
	<?php
		$query = "SELECT * FROM categories ORDER BY id asc";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)) { 
	?>
	<h4><a style="text-decoration: none;" href="equipments.php?C=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?>&nbsp;&nbsp;&nbsp;( <?php echo $row["number_of_products"]; ?> )</a></h4>
	<?php } ?>
	<h4><a style="text-decoration: none;" href="equipments.php">View all Equipments</a></h4>

	<h3><a href="dashboard.php">Back</a></h3>
	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>
</body>
</html>	