<?php 
	include('../server/update_profile.php');

	session_start();
	
	if ($_SESSION['user']['role'] != "M") 
	{
	    header('location: login.php');
	}

	$member_id = $_SESSION['user']['id'];
?>
<html>

<head>
	<title>TFPS | Complete your profile</title>
</head>

<body>

	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

	<h3>Your account has been successfully created.</h3>

	<h4>Complete your profile</h4>
	
	<form method="post" action="complete_profile.php" enctype="multipart/form-data">
		<?php include('../server/errors.php'); ?>
		<input type="text" name="name" placeholder="Your Name">
		<input type="file" name="image" accept="image/*">
		<input type="number" name="mobile" placeholder="Your Contact Number">
		<input type="text" name="rollnumber" placeholder="Institute Roll Number">
		<input type="hidden" name="memberID" value="<?php echo $member_id; ?>">
		<button type="submit" class="btn" name="update_profile">Update My Profile</button>
	</form>

</body>

</html>