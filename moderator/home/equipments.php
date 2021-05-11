<?php 
  include('../server/config.php');

	session_start(); 
	if ($_SESSION['user']['role']!='A')
  {
		$_SESSION['message'] = "You must log in first";
		header('location: ../login.php');
	}
?>
<html>

<head>
  <title>Manage Equipments | Admin TFPS</title>	
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
  </style>
</head>

<body>

  <h1 style="font-weight:bold;">Admin Panel | TFPS Equipments Manager</h1> 

  <?php 
      $q = "SELECT * FROM equipments ORDER BY id asc";
  		$result = mysqli_query($conn,$q);
  ?>

  <?php if (mysqli_num_rows($result) !='0') : ?>

  <h3>View Equipment Details</h3>
  
	<input style="display: inline-block; float: right; margin: 12px;" type="text" id="myInput" onkeyup="myFunction1()" placeholder="&nbsp;Search Equipment">
  
		    <table id="myTable">
		      <thead>
  		      <tr>
  		      <th>Category</th>
  		      <th>Equipment Name</th>
            <th>Owner Name</th>
  		      <th>Currently With</th>
  		      <th>Contact Number</th>
            <th>QR Code</th>
  		      </tr>
		    </thead>
		    <tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
		      <tr>
		      <td><?php echo $row["category_name"]; ?></td>
		      <td><?php echo $row["name"]; ?></td>
          <td><?php echo $row["owner_name"]; ?></td>
		      <td><?php echo $row["currentlywith_name"]; ?></td>
		      <td><?php echo $row["currentlywith_number"]; ?>&nbsp;|&nbsp;<a href="https://wa.me/91<?php echo $row["currentlywith_number"]; ?>?text=Hi <?php echo $row["currentlywith_name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a>&nbsp;|&nbsp;<a href="tel:<?php echo $row["currentlywith_number"]; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>
          </td>
          <td><a href="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $row["id"]; ?>" target="_blank" >Download</a></td>
		      </tr>
		      <?php } ?>
		    </tbody>
        </table>

  <?php endif ?>

  <?php if (mysqli_num_rows($result) =='0') : ?>
	      <h4>No Equipment added yet.</h4>
  <?php endif ?>
  

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
