<?php 
include('../server/update_profile.php');
session_start();

if ($_SESSION['user']['role'] != "M") 
{
    header('location: login.php');
}

$mid = $_SESSION['user']['id'];
?>

<html>
<head>
	<title>TFPS | Update Profile</title>
</head>
<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 
	<h3>Update your account details</h3>
	<form method="post" action="update_profile.php" enctype="multipart/form-data">
		<?php include('errors.php'); ?>
		<input type="file" name="image" accept="image/*">
		<input type="email" name="email" placeholder="Email Address">
		<input type="text" name="username" placeholder="Username">
		<input type="number" name="mobile" placeholder="Contact Number">
		<input type="password" name="password" placeholder="Password">
		<input type="hidden" name="mid" value="<?php echo $mid; ?>">
		<button type="submit" class="btn" name="re_update">Update My Profile</button>
	</form>

	<h3><a href="dashboard.php">Back</a></h3>
	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>