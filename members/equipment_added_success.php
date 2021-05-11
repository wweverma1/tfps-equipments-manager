<?php 
	include('../server/config.php');
  	$conn = mysqli_connect($host, $username, $password, $database);
	session_start(); 
	
	if ($_SESSION['user']['role']!='M')
    {
		$_SESSION['message'] = "You must log in first";
		header('location: login.php');
	}
	$eID = $_REQUEST['eID'];
	$uid = $_SESSION['user']['id'];
    $query = "SELECT * FROM equipments WHERE id='$eID' AND owner_id='$uid' LIMIT 1";
	$result = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($result);
?>
<html>
<head>
	<title><?php echo $row["name"]; ?> Added | TFPS</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
  	</style>	
</head>
<body>
	<h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 
	<h3>Equipment added successfully.</h3>
	<h3>Details of the Equipment:</h3>
		
	<div style="overflow-x:auto; margin-top: 8px;">
		<table>
			<thead>
		      <tr>
		      <th><strong>Equipment Name</strong></th>
		      <th><strong><?php echo $row["name"]; ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Category</strong></th>
		      <th><strong><?php echo $row["category_name"]; ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Download QR Code</strong></th>
		      <th>
		      	<a download="<?php echo $row["name"]; ?>.png" href="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $row["id"]; ?>" title="<?php echo $row["name"]; ?>" target="_blank"><img alt="Equipment Name" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $row["id"]; ?>">
				</a>
			  </th>
		      </tr>
		    </thead>
		</table>
 	</div>
 	
	<h3><a href="dashboard.php">Back to Dashboard</a></h3>	
  	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>

</html>
