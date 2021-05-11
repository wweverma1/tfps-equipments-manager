<?php 
	include('config.php');
	$conn = mysqli_connect($host, $username, $password, $database);
	session_start();

	if (isset($_POST['add'])) 
	{
		$name = esc($_POST['equipment_name']);
		$category_id = esc($_POST['category']);
		$remark = esc($_POST['remark']);
		$uid = $_SESSION['user']['id'];
	
		if (empty($name)) {  array_push($errors, "Enter Equipment Name."); }
		if (empty($category_id)) {  array_push($errors, "Choose Equipment's Category."); }

		if (count($errors) == 0) 
		{
				$q = "SELECT * FROM categories WHERE id='$category_id' LIMIT 1";
				$r = mysqli_query($conn, $q);
				$a = mysqli_fetch_assoc($r);
				$category_name = $a["name"];

				$q1 = "SELECT * FROM members WHERE id='$uid' LIMIT 1";
				$r1 = mysqli_query($conn, $q1);
				$a1 = mysqli_fetch_assoc($r1);
				$owner_name = $a1["name"];
				$owner_mobile = $a1["mobile"];

				if(empty($remark)=='1')
				{
					$q2 = "INSERT INTO equipments (category_id, category_name, name, owner_name, owner_id, owner_number, currentlywith_name, currentlywith_id, currentlywith_number) VALUES ('$category_id', '$category_name', '$name', '$owner_name', '$uid', '$owner_mobile', '$owner_name', '$uid', '$owner_mobile')";
				}
				else
				{
					$q2 = "INSERT INTO equipments (category_id, category_name, name, owner_name, owner_id, owner_number, currentlywith_name, currentlywith_id, currentlywith_number, remarks) VALUES ('$category_id', '$category_name', '$name', '$owner_name', '$uid', '$owner_mobile', '$owner_name', '$uid', '$owner_mobile', '$remark')";
				}
				mysqli_query($conn, $q2);
				$e_id = mysqli_insert_id($conn);
				$q3 = "UPDATE categories SET number_of_products=number_of_products+1 WHERE id='$category_id' LIMIT 1";
				mysqli_query($conn, $q3);
				$notification = $name." has been added to your inventory.";
				date_default_timezone_set("Asia/Kolkata");
				$dated = date("Y-m-d H:i:s");
				$q4 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification', '$owner_id', '$dated')";
				mysqli_query($conn, $q4);
				header('Location: equipment_added_success.php?eID='.$e_id);
		}
	}

function esc(String $value)
	{	
		global $conn;

		$val = trim($value);
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
?>