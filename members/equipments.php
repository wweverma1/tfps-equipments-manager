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
  <title>View Equipments | TFPS</title>	
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
      $categoryID = $_REQUEST['C'];
      if(is_null($categoryID)=='1')
      {
        $q = "SELECT * FROM equipments ORDER BY id asc";
        $_SESSION['previous_category_id']=NULL;
      }
      else
      {
        $q = "SELECT * FROM equipments WHERE category_id='$categoryID' ORDER BY id asc";
        $_SESSION['previous_category_id']=$categoryID;
      }
  		$result = mysqli_query($conn,$q);
  ?>

  <?php if (mysqli_num_rows($result) !='0') : ?>
		
	<input style="display: inline-block; float: right; margin: 12px;" type="text" id="myInput" onkeyup="myFunction1()" placeholder="Search Equipment">
		
	<table id="myTable">
		<thead>
		  <tr>
		  <th>Category</th>
		  <th>Equipment Name</th>
		  <th>Owner</th>
      <th>Contact</th>
      </tr>
		</thead>
		<tbody>
		      <?php
		      while($row = mysqli_fetch_assoc($result)) { ?>
		      <tr>
		      <td>
		      	<?php 
      				echo $row["category_name"]; 
      			?>
      		  </td>
		      <td>
		      	<a href="equipment_details.php?eID=<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></a>	     
		      </td>
          <td>
            <?php 
              if($row["owner_id"]==$uid)
                echo "You"; 
              else
                echo $row["owner_name"];
            ?>       
          </td>
          <td>
            <h3><a href="tel:<?php echo $row["owner_number"]; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a> | <a href="https://wa.me/91<?php echo $row["owner_number"]; ?>?text=Hey <?php echo $row["owner_name"]; ?>! I want to borrow your <?php echo $row["name"]; ?>"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a>      
          </td>
		      </tr>
		      <?php } ?>
		</tbody>
	 </table>

			<h3><a href="add_equipment.php?route=1">Add Your Equipment</a></h3>

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
  		<h4>No Equipments added yet.</h4>
  <?php endif ?>

  <h3>Invite Friends <a href="whatsapp://send?text=Hey! Register on TFPS Equipments Manager and add your equipments to the inventory using this link:"><i class="fa fa-whatsapp" style="color: green;" aria-hidden="true"></i></a></h3>

  <h3><a href="select_category.php">Back</a></h3>
  <h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>
