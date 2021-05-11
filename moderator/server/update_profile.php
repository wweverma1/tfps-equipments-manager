<?php 

include('config.php');

session_start();


if (isset($_POST['update'])) 
	{
		$errors = array();
		$username = esc($_POST['username']);
		$new_password = esc($_POST['new_password']);
		$password = esc($_POST['password']);
		$admin_id = 1;

		if(empty($username)=='1' AND empty($new_password)=='1')
		{
			array_push($errors, "Nothing to Update.");
		}

		if(empty($password)=='1')
		{
			array_push($errors, "Current password is required.");
		}

		$q = "SELECT * FROM admin WHERE id='$admin_id' LIMIT 1";
  		$result = mysqli_query($conn,$q);
 		$row = mysqli_fetch_assoc($result);

 		$password = md5($password);
		if($password!=$row["password"])
		{	
			array_push($errors, "Incorrect Password.");
		}

		if (count($errors) == 0) 
		{
			
				if(empty($username)!='1')
				{
					$q = "UPDATE admin SET username='$username' WHERE id='$admin_id'";
					mysqli_query($conn, $q);
				}
				if(empty($new_password)!='1')
				{
					$new_password = md5($new_password);
					$q = "UPDATE admin SET password='$new_password' WHERE id='$admin_id'";
					mysqli_query($conn, $q);
				}

				$_SESSION['user'] = GetById($admin_id);
				$_SESSION['message'] = "Profile Updated.";
				header('location: dashboard.php');
		}
	}


	function esc(String $value)
	{	
		global $conn;

		$val = trim($value);
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}

	function GetById($id)
	{
		global $conn;
		$sql = "SELECT * FROM admin WHERE id = '$id' LIMIT 1";

		$result1 = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result1);
		return $user; 
	}
?>