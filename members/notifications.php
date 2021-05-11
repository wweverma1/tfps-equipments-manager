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
<title>Notifications | TFPS</title>	
<style>
	table, th, td {
	  border: 1px solid black;
	  border-collapse: collapse;
	}
</style>
</head>

<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 
	<?php 
		$uid = $_SESSION['user']['id'];
     	$query = "SELECT * FROM notification WHERE rid = '$uid' ORDER BY id desc";
		$result = mysqli_query($conn,$query);
	?>

<?php if (mysqli_num_rows($result) !='0') : ?>
	<h3>Notifications</h3>
	<div style="overflow-x:auto;">
		<table>
		    <thead>
			    <tr>
			      <th><strong>Date</strong></th>
			      <th><strong>Notification</strong></th>
			      <th><strong>Action</strong></th>
			    </tr>
		    </thead>
		   	<tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
		      	<tr>
		      		<td align="center">
			      	<?php 
			      		$dt = new DateTime($row["dated"]);
	      				$date = $dt->format('d-m-Y');
	      				echo $date; 
	      			?>
      		  		</td>
			        <td align="center">
			      	<?php 
			      		echo $row["notification"];
			      	?>
			      	</td>
		      		<td align="center"><a href="../server/delete_notification.php?id=<?php echo $row["id"]; ?>">Mark as read</a></td>
		      	</tr>
		      <?php } ?>
		    </tbody>
		</table>
 	</div>
 
	<h3><a href="../server/delete_notifications.php">Clear all notifications</a></h3>
<?php endif ?>

<?php if (mysqli_num_rows($result) =='0') : ?>
		<h3>No new notifications.</h3>
<?php endif ?>


<h3><a href="dashboard.php">Back</a></h3>

<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>

</html>
