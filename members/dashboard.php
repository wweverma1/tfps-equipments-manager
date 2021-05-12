<?php
  include('../server/config.php');
  $conn = mysqli_connect($host, $username, $password, $database);
	session_start(); 

	if($_SESSION['user']['role']!='M')
  {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
	}
  else if($_SESSION['user']['profile_completed']!='1')
  {
    $_SESSION['message'] = "You must complete your profile";
    header('location: complete_profile.php');
  }
	$uid = $_SESSION['user']['id'];
	$query = "SELECT * FROM notification WHERE rid='$uid'";
  $result = mysqli_query($conn, $query);
  $number_notification = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Dashboard | TFPS</title>

</head>

<body>
          <h3>Welcome <b><?php echo $_SESSION['user']['name'] ?></b></h3>
          <img src="../images/members/<?php if(empty($_SESSION['user']['image'])!='1') { echo $_SESSION['user']['image']; } else { echo "userlogo.png"; } ?> " alt="Profile Picture" style="height: 114px;">
          


          <h3>Notifications </h3>
          <?php if ($number_notification!='0') : ?>
            <a href="notifications.php" style="text-decoration: none;">
              <i class="fa fa-bell" style="color: gold;"></i>
              &nbsp;<strong><?php echo $number_notification; ?></strong> new notification<?php if ($number_notification>'1'){ echo "s"; } ?>
            </a>
          <?php endif ?>
          <?php if ($number_notification=='0') : ?>
            <a href="notifications.php" style="text-decoration: none;"><i class="fa fa-bell"></i>&nbsp;No new notification</a>
          <?php endif ?>

          
          <h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

              <h2>Dashboard</h2>
             
              <h3>Personal</h3>
                <h4><a href="add_equipment.php?route=3">Add a new Equipment</a></h4>
                <h4><a href="myequipments.php">My Equipments</a></h4>
                <h4><a href="myhistory.php">My History</a></h4>
              
           
              <h3>Equipments</h3>
                <h4><a href="select_category.php">View Equipments</a></h4>
                <h4><a href="take_equipment/scan.php">Take an Equipment</a></h4>
              
              <h3><a href="select_batch.php">View all Members</a></h3>
          
              <h3><a href="update_profile.php">Update my profile</a><h3>



              <h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>
        
</body>

</html>
