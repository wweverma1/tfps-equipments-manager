<?php 

	include('../server/config.php');
	include('../server/category_add.php');

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
	<title>Manage Categories | Admin TFPS</title>
	<style>
  	table, th, td 
  	{
	    border: 1px solid black;
	    border-collapse: collapse;
  	}
  	</style>
</head>

<body>
	<h1 style="font-weight:bold;">Admin Panel | TFPS Equipments Manager</h1>

	<h3>Add a new category</h3>
	
	<form method="post" action="categories.php">
	<?php include('../server/errors.php'); ?>
			<input type="text" name="category" placeholder="Category Name">
			<button type="submit" class="btn" name="add_category">Add Category</button>
	</form>

	
	<?php 
     	$q = "SELECT * FROM categories ORDER BY id asc";
		$result = mysqli_query($conn,$q);
	?>
	<?php if (mysqli_num_rows($result) !='0') : ?>
		<h3>Avialable Categories</h3>
		<div style="overflow-x:auto; margin-top: 8px;">
		    <table id="myTable">
		      <thead>
			      <tr>
			      <th><strong>Category Name</strong></th>
			      <th><strong>Number of Equipments</strong></th>
			      <th><strong>Delete</strong></th>
			      </tr>
		    </thead>
		    <tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
		      <tr>
			      <td align="center"><?php echo $row["name"]; ?></td>
			      <td align="center"><?php echo $row["number_of_products"]; ?></td>
			      <td align="center"><a href="../server/delete_category.php?cID=<?php echo $row["id"]; ?>">Delete</a></td>
		      </tr>
		      <?php } ?>
		    </tbody>
		    </table>
 		</div>
	<?php endif ?>
	<?php if (mysqli_num_rows($result) =='0') : ?>
		<h3>No Category avialable.</h3>
	<?php endif ?>

	<h3><a href="dashboard.php">Back</a></h3>

	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>