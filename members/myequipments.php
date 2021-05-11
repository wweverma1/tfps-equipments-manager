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
  <title>My Equipments | TFPS</title>	
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
      $q = "SELECT * FROM equipments WHERE owner_id = '$uid' ORDER BY id asc";
  		$result = mysqli_query($conn,$q);
  ?>

  <?php if (mysqli_num_rows($result) !='0') : ?>

  <h3>My Equipment</h3>
  
	<input style="display: inline-block; float: right; margin: 12px;" type="text" id="myInput" onkeyup="myFunction1()" placeholder="&nbsp;Search Equipment">
  
		    <table id="myTable">
		      <thead>
  		      <tr>
  		      <th>Category</th>
  		      <th>Equipment Name</th>
  		      <th>Currently With</th>
  		      <th>Contact Number</th>
            <th>QR Code</th>
            <th>Remove Equipment</th>
  		      </tr>
		    </thead>
		    <tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
		      <tr>
		      <td><?php echo $row["category_name"]; ?></td>
		      <td><a href="my_equipment_details.php?eID=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a></td>
		      <td><?php if($row["currentlywith_id"]==$uid){ echo "You"; } else { echo $row["currentlywith_name"]; } ?></td>
		      <td><?php echo $row["currentlywith_number"]; ?>&nbsp;|&nbsp;<a href="https://wa.me/91<?php echo $row["currentlywith_number"]; ?>?text=Hi <?php echo $row["currentlywith_name"]; ?>! I want to know status of my <?php echo $row["name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a>&nbsp;|&nbsp;<a href="tel:<?php echo $row["currentlywith_number"]; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a></td>
          <td><a href="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $row["id"]; ?>" target="_blank" >Download</a></td>
          <td>
            <?php 
              if ($row["currentlywith_id"]!=$uid) 
                echo "You can't delete your equipment while it is with someone.";
            ?>
            <?php if ($row["currentlywith_id"]==$uid) : ?>
              <a href="../server/delete_equipment.php?eID=<?php echo $row["id"]; ?>&cID=<?php echo $row["category_id"]; ?>">Delete</a>
            <?php endif ?>
          </td>
		      </tr>
		      <?php } ?>
		    </tbody>
        </table>

  <?php endif ?>

  <?php if (mysqli_num_rows($result) =='0') : ?>
	      <h4>No Equipments added yet.</h4>
  <?php endif ?>
  

  <h3><a href="add_equipment.php?route=2">Add Your Equipment</a></h3>
  <h3><a href="dashboard.php">Back</a></h3>
  <h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

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

</body>

</html>
