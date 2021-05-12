<?php 
	
	include('../server/config.php');
  	$conn = mysqli_connect($host, $username, $password, $database);
	include('../server/add_equipment.php');

	session_start();
	if ($_SESSION['user']['role'] != "M") 
	{
	    header('location: login.php');
	}
	else if($_SESSION['user']['profile_completed']!='1')
  	{
	    $_SESSION['message'] = "You must complete your profile";
	    header('location: complete_profile.php');
  	}
	$back = $_REQUEST['route'];
?>

<html>
<head>
	<title>Add Equipment | TFPS</title>
</head>
<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

	<h3>Add your Equipment</h3>
	<form method="post" action="add_equipment.php">
	<?php include('../server/errors.php'); ?>
		<select name="category">
          <?php
          $select_query="SELECT * FROM categories ORDER BY id asc ";
          $result = mysqli_query($conn,$select_query);
          while($row = mysqli_fetch_assoc($result)) { ?>
          <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
          <?php } ?>
        </select>
		<input type="text" name="equipment_name" placeholder="Name of Equipment">
		<input type="text" name="remark" placeholder="Remark (If Any)">
		<button type="submit" class="btn" name="add">Add Equipment</button>
	</form>

	<?php if($back=='3') : ?>
		<h3><a href="dashboard.php">Back</a></h3>	
	<?php endif ?>
	<?php if($back=='2') : ?>
		<h3><a href="myequipments.php">Back</a></h3>	
	<?php endif ?>
	<?php if ($back=='1' && is_null($_SESSION['previous_category_id'])=='1') : ?>
		<h3><a href="equipments.php">Back</a></h3>	
	<?php endif ?>
	<?php if ($back=='1' && is_null($_SESSION['previous_category_id'])!='1') : ?>
		<h3><a href="equipments.php?C=<?php echo $_SESSION['previous_category_id']; ?>">Back</a></h3>
	<?php endif ?>

	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>
</body>
</html>