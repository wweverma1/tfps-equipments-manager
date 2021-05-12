<?php
	session_start(); 
	if ($_SESSION['user']['role']!='M')
    {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
	}
	else if($_SESSION['user']['profile_completed']!='1')
  	{
	    $_SESSION['message'] = "You must complete your profile";
	    header('location: complete_profile.php');
  	}
?>

<html>

<head>
<title>Members | TFPS</title>
</head>

<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 
	<h3>Select Batch</h3>
	<?php
		$batch = array();
		$year= date('Y'); 
		for ($x = 0; $x <= 5; $x++) 
		{
		  $batch[$x]=$year-$x;
		}
	?>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[0]; ?>">First Year</a></h4>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[1]; ?>">Second Year</a></h4>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[2]; ?>">Third Year</a></h4>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[3]; ?>">Fourth Year</a></h4>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[4]; ?>">Fifth Year</a></h4>
	<h4><a style="text-decoration: none;" href="members.php?Y=<?php echo $batch[5]; ?>">Alumini ❤️</a></h4>


	<h3><a href="dashboard.php">Back</a></h3>
	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>
</body>
</html>	