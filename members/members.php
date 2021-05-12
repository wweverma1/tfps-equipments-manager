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
?>
<html>

<head>
	<title>View Members | TFPS</title>	
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
	<?php 
			$uid = $_SESSION['user']['id'];
			$year = $_REQUEST['Y'];
			if($year <= date('Y')-5)
				$query = "SELECT * FROM members WHERE batch <= '$year' ORDER BY id asc";
			else
				$query = "SELECT * FROM members WHERE batch = '$year' ORDER BY id asc";
			$result = mysqli_query($conn, $query);
	?>
	<?php if (mysqli_num_rows($result) !='0') : ?>
		<div>
			<h3 style="margin-left: 20px; display: inline-block;">Members</h3>
			<input style="display: inline-block; float: right; margin: 12px;" type="text" id="myInput" onkeyup="myFunction1()" placeholder="&nbsp;Search Member">
		</div>
		<div style="overflow-x:auto; margin-top: 8px;">
		    <table id="myTable">
		      <thead>
			      <tr>
			      <th><strong>Profile Picture</strong></th>
			      <th><strong>Name</strong></th>
			      <th><strong>Contact Number</strong></th>
			      <th><strong>Email Address</strong></th>
			      </tr>
		    </thead>
		    <tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
			      <tr>
			      <td align="center">
			      	<img src="../images/members/<?php if(empty($row["image"])!='1') { echo $row["image"]; } else { echo "userlogo.png"; } ?>" style="height: 114px;"/>
	      		  </td>
			      <td align="center">
			      	<?php 
			      		echo $row["name"];
			      	?>
			      </td>
			      <td align="center">
			      	<?php echo $row["mobile"]; ?>&nbsp;|&nbsp;<a href="tel:<?php echo $row["mobile"]; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>&nbsp;|&nbsp;<a href="https://wa.me/91<?php echo $row["mobile"]; ?>?text=Hi <?php echo $row["name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a>
			      </td>
			      <td align="center"><?php echo $row["email"]; ?></td>
			      </tr>
		      <?php } ?>
		    </tbody>
		    </table>
 		</div>
 		<script>
        function myFunction1() 
        {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("myTable");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) 
          {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) 
            {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) 
              {
                tr[i].style.display = "";
              } 
              else 
              {
                tr[i].style.display = "none";
              }
            }       
          }
        }
		</script>
	<?php endif ?>

	<?php if (mysqli_num_rows($result) =='0') : ?>
		<h4>No Members in this batch.</h4>
	<?php endif ?>

	<h3>Invite Friends <a href="whatsapp://send?text=Hey! Register on TFPS Equipments Manager using this link:"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a></h3>

	<h3><a href="select_batch.php">Back</a></h3>
	<h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>
