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
  <title>My History | TFPS</title>	
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
      $q = "SELECT * FROM borrow_history WHERE taker_id = '$uid' OR giver_id='$uid' ORDER BY id desc";
  		$result = mysqli_query($conn,$q);
  ?>
  <?php if (mysqli_num_rows($result) !='0') : ?>
		
    <h3>My History</h3> 
  
		<input style="display: inline-block; float: right; margin: 12px;" type="text" id="myInput" onkeyup="myFunction1()" placeholder="&nbsp;Search Equipment">
  
		<table id="myTable">
		  <thead>
		    <tr>
		      <th>Date</th>
          <th>Type</th>
		      <th>Equipment Name</th>
          <th>Category</th>
		      <th>Borrowed From</th>
          <th>Returned To</th>
		      <th>Remarks</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php
		    while($row = mysqli_fetch_assoc($result)) { 
        ?>
		    <tr>
		      <td>
		      	<?php 
		      		$dt = new DateTime($row["dated"]);
      				$date = $dt->format('d-m-Y');
      				echo $date; 
      			?>
      		</td>
          <td>
            <?php 
              if($row["giver_id"]==$uid)
                echo "Return";
              else
                echo "Borrow";
            ?>
          </td>
		      <td>
		      	<?php 
		      		echo $row["equipment_name"];
		      	?>
		      </td>
		      <td><?php echo $row["category_name"]; ?></td>
		      <td>
            <?php  
              if($row["taker_id"]==$uid)
                echo $row["giver_name"];
              else
                echo "-";
            ?>
          </td>
          <td>
            <?php
              if($row["giver_id"]==$uid)
                echo $row["taker_name"];
              else
                echo "-";
            ?>
          </td>
		      <td><?php if(is_null($row["remark"])=='1'){ echo "NA"; } else { echo $row["remark"]; } ?></td>

		    </tr>
		    <?php } ?>
		  </tbody>
		</table>

 		 
  <?php endif ?>
  <?php if (mysqli_num_rows($result) =='0') : ?>
  		<h4>No History.</h4>
  <?php endif ?>


  <h3><a href="take_equipment/scan.php?route=2">Take an Equipment</a></h3>

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

  <h3><a href="dashboard.php">Back</a></h3>
  <h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>

</html>
