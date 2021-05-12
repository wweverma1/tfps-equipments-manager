<?php 
	include('../server/config.php');
  	$conn = mysqli_connect($host, $username, $password, $database);
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
	$eID = $_REQUEST['eID'];
	$uid = $_SESSION['user']['id'];
    $query = "SELECT * FROM equipments WHERE id='$eID' LIMIT 1";
	$result = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($result);
?>
<html>
<head>
	<title><?php echo $row["name"]; ?> | TFPS</title>
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
	<h3>Equipment Details</h3>
		
	<div style="overflow-x:auto; margin-top: 8px;">
		<table>
			<thead>
		      <tr>
		      <th><strong>Category</strong></th>
		      <th><strong><?php echo $row["category_name"]; ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Equipment Name</strong></th>
		      <th><strong><?php echo $row["name"]; ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Owner</strong></th>
		      <th><strong><?php if($row["owner_id"]==$uid){ echo "You"; } else { echo $row["owner_name"]; } ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Owner Contact Number</strong></th>
		      <th><strong><strong><?php echo $row["owner_number"]; ?></strong>&nbsp;<a href="https://wa.me/91<?php echo $row["owner_number"]; ?>?text=Hi <?php echo $row["owner_name"]; ?>! I want to borrow your <?php echo $row["name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Currently With</strong></th>
		      <th><strong><?php if($row["currentlywith_id"]==$uid){ echo "You"; } else { echo $row["currentlywith_name"]; } ?></strong></th>
		      </tr>
		      <tr>
		      <th><strong>Contact Number</strong></th>
		      <th><strong><?php echo $row["currentlywith_number"]; ?></strong>&nbsp;<a href="https://wa.me/91<?php echo $row["currentlywith_number"]; ?>?text=Hi <?php echo $row["currentlywith_name"]; ?>! I want to borrow <?php echo $row["owner_name"]."'s ".$row["name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a></th>
		      </tr>
		      <tr>
		      <th><strong>Remarks</strong></th>
		      <th><strong><?php if(is_null($row["remarks"])=='1'){ echo "NA"; } else { echo $row["remarks"]; } ?></strong></th>
		      </tr>
		    </thead>
		</table>
 	</div>


 	<h3>Equipment History</h3>

 	<?php 
        $q = "SELECT * FROM borrow_history WHERE equipment_id='$eID' ORDER BY id asc";
  		$result1 = mysqli_query($conn,$q);
  	?>

  	<?php if (mysqli_num_rows($result1) !='0') : ?>

 	<table>
		<thead>
		  <tr>
		  <th>Date</th>
		  <th>Transaction Type</th>
		  <th>Transaction Summary</th>
		  <th>Remark (If any)</th>
      	  </tr>
		</thead>
		<tbody>
		      <?php
		      while($row1 = mysqli_fetch_assoc($result1)) { ?>
		      
		      <tr>
		      <td>
		      	<?php 
			      		$dt = new DateTime($row1["dated"]);
	      				$date = $dt->format('d-m-Y');
	      				echo $date; 
	      		?>
      		  </td>
      		  <td>
		      	<?php 
     				if($row1["taker_id"]==$row["owner_id"])
     				{
     					echo "Return";
     				}
     				else
     				{
     					echo "Borrow";
     				}
      			?>
      		  </td>
		      <td>
		      	<?php 
     				if($row1["taker_id"]==$row["owner_id"])
     				{
     					echo $row["owner_name"]." took back his equipment from ".$row1["giver_name"].".";
     				}
     				else
     				{
     					if($row1["giver_id"]==$row["owner_id"])
     					{
     						echo $row1["taker_name"]." took equipment from its owner ".$row["owner_name"].".";
     					}
     					else
     					{
     						echo $row1["taker_name"]." took ".$row["owner_name"]."'s equipment from ".$row1["giver_name"].".";
     					}
     				}
      			?>
      		  </td>
      		  <td>
		      	<?php 
      				if(is_null($row1["remark"])=='1')
      					echo "NA";
      				else
      					echo $row1["remark"];
      			?>
      		  </td>
		      </tr>
		      <?php } ?>
		</tbody>
	</table>

	<?php endif ?>

  	<?php if (mysqli_num_rows($result1) =='0') : ?>
  		<h4>No borrow history.</h4>
  	<?php endif ?>

 	
	<?php if (is_null($_SESSION['previous_category_id'])=='1') : ?>
		<h3><a href="equipments.php">Back</a></h3>	
	<?php endif ?>
	<?php if (is_null($_SESSION['previous_category_id'])!='1') : ?>
		<h3><a href="equipments.php?C=<?php echo $_SESSION['previous_category_id']; ?>">Back</a></h3>
	<?php endif ?>

  	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>

</html>
