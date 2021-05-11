<?php 
	include('../server/update_profile.php');

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
	<title>Update Profile | Admin TFPS</title>
</head>

<body>
	<h1 style="font-weight:bold;">Admin Panel | TFPS Equipments Manager</h1>
	<h3>Update your profile</h3>
	
	<form method="post" action="profile.php">
	<?php include('../server/errors.php'); ?>
			<input type="text" name="username" placeholder="Username">
			<input type="password" name="new_password" placeholder="New Password">
			<input type="password" name="password" placeholder="Current Password">
			<button type="submit" class="btn" name="update">Update Profile</button>
	</form>

	<h3><a href="dashboard.php">Back</a></h3>

	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>