<?php 
    include('../server/config.php');
    include('../server/take.php');
    $conn = mysqli_connect($host, $username, $password, $database);
    session_start(); 

    if ($_SESSION['user']['role']!='M')
    {
        $_SESSION['message'] = "You must log in first";
        header('location: login.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Take Equipment | TFPS</title>
    <style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
    </style>
</head>
<body>
   <h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

   <h3>Please confirm the equipment you're taking</h3>            
    <?php
    $e_ID = $_POST['eID'];
    $uid = $_SESSION['user']['id'];
    $query = "SELECT * FROM equipments WHERE id='$e_ID' LIMIT 1";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    ?>

    <?php if (mysqli_num_rows($result) == '1') : ?>
        <table>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Equipment Name</th>
            <th>Category</th>
            <th>Taking From</th>
        </tr>
        <tr>
            <td><?php $myDate = date('d-m-Y'); echo $myDate; ?></td>
            <td>
                <?php 
                    if($row["owner_id"]==$uid)
                        echo "Taking Back";
                    else
                        echo "Borrowing";
                ?>
            </td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["currentlywith_name"]; ?></td>
        </tr>
        </table>
        
        <div style="margin-top: 10px;">
        <form method="POST" action="take.php"> 
            <input type="hidden" name="eID" value="<?php echo $row["id"]; ?>">
            <input type="hidden" name="eName" value="<?php echo $row["name"]; ?>">
            <input type="hidden" name="category_name" value="<?php echo $row["category_name"]; ?>">
            <input type="hidden" name="owner_id" value="<?php echo $row["owner_id"]; ?>">
            <input type="hidden" name="user_name" value="<?php echo $_SESSION['user']['name']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
            <input type="hidden" name="user_mobile" value="<?php echo $_SESSION['user']['mobile']; ?>">
            <input type="hidden" name="currentlywith_name" value="<?php echo $row['currentlywith_name']; ?>">
            <input type="hidden" name="currentlywith_id" value="<?php echo $row['currentlywith_id']; ?>">
            <input type="hidden" name="currentlywith_mobile" value="<?php echo $row['currentlywith_number']; ?>">
            <input type="text" name="remark" placeholder="Remark(If Any)">
            <button type="submit" class="btn" name="take">Take Equipment</button>
        </form> 
        </div>
    <?php endif ?>
    <?php if (mysqli_num_rows($result) != '1') : ?>
        <h4>No equipment found.</h4>
    <?php endif ?>

    <h3><a href="take_equipment/scan.php">Back</a></h3>
    <h3><a href="../server/logout.php" style="color: red;">Logout</a></h3>

</body>
</html>