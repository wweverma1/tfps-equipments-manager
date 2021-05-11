<?php 
	session_start(); 

	if ($_SESSION['user']['role']!='A') 
	{
		$_SESSION['message'] = "You must log in first";
		header('location: ../login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home | Admin TFPS</title>
</head>

<body>
	<h1 style="font-weight:bold;">Admin Panel | TFPS Equipments Manager</h1> 

	<h2>Available Options</h2>
	<h3><a href="users.php">Manage Members</a></h3>
	<h3><a href="categories.php">Manage Categories</a></h3>
	<h3><a href="equipments.php">Manage Equipments</a></h3>
	<h3><a href="profile.php">Update Profile</a></h3>

	</h3><a style="color: red;" href="../server/logout.php">Logout</a></h3>
</body>

</html>