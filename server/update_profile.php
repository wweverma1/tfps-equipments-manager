<?php 

include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);

session_start();


if (isset($_POST['update_profile'])) 
	{
		$errors = array(); 
		$member_id = esc($_POST['memberID']);
		$name = esc($_POST['name']);
		$rollnumber = esc($_POST['rollnumber']);
		$mobile = esc($_POST['mobile']);
		$image = $_FILES['image']['name'];
		$target = "../images/members/" . basename($image);

		if (empty($name)) {  array_push($errors, "Enter Your Name."); }
		if (empty($rollnumber)) {  array_push($errors, "Enter your Roll Number."); }
		if (empty($mobile)) {  array_push($errors, "Enter your Mobile Number."); }

		$year = substr($rollnumber, 0, 2);
		$batch = '20'.$year;

		if (count($errors) == 0) 
		{
			if(empty($image)==1)
			{
				$query = "UPDATE members SET name='$name', rollnumber='$rollnumber', mobile='$mobile', batch='$batch' WHERE id='$member_id'";
				mysqli_query($conn, $query);

				$_SESSION['user'] = getUserById($member_id);
				$_SESSION['message'] = "Profile Successfully Updated.";

				header('location: dashboard.php');
			}
			
			else
			{
				$query = "UPDATE members SET name='$name', image='$image', rollnumber='$rollnumber', mobile='$mobile', batch='$batch' WHERE id='$member_id'";
				mysqli_query($conn, $query);
				
				if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
				{
		  		array_push($errors, "Failed to upload image.");
		  		}
		  		$_SESSION['user'] = getUserById($member_id);
		  		$_SESSION['message'] = "Profile Successfully Updated.";
		  		
				header('location: dashboard.php');
			}
		}
	}

	if (isset($_POST['re_update'])) 
	{
		$errors = array(); 
		$member_id = esc($_POST['mid']);
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password = esc($_POST['password']);
		$mobile = esc($_POST['mobile']);
		$image = $_FILES['image']['name'];
		$target = "../images/members/" . basename($image);

		if(empty($image)=='1' AND empty($mobile)=='1' AND empty($email)=='1' AND empty($username)=='1' AND empty($password)=='1')
		{
			array_push($errors, "Nothing to Update.");
		}

		if (count($errors) == 0) 
		{
			if(empty($image)!='1')
			{
				$q = "UPDATE members SET image='$image' WHERE id='$member_id'";
				mysqli_query($conn, $q);
				if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) 
				{
		  		array_push($errors, "Failed to upload image.");
		  		}
			}
			if(empty($mobile)!='1')
			{
				$q = "UPDATE members SET mobile='$mobile' WHERE id='$member_id'";
				mysqli_query($conn, $q);
			}
			if(empty($email)!='1')
			{
				$q = "UPDATE members SET email='$email' WHERE id='$member_id'";
				mysqli_query($conn, $q);
			}
			if(empty($username)!='1')
			{
				$q = "UPDATE members SET username='$username' WHERE id='$member_id'";
				mysqli_query($conn, $q);
			}
			if(empty($password)!='1')
			{
				$password = md5($password);
				$q = "UPDATE members SET password='$password' WHERE id='$member_id'";
				mysqli_query($conn, $q);
			}
			date_default_timezone_set("Asia/Kolkata");
			$dated = date("Y-m-d H:i:s");
			$notification = "Your profile has been updated.";
            $query = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification', '$member_id', '$dated')";
			mysqli_query($conn, $query);

			$_SESSION['user'] = getUserById($member_id);
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

	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM members WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}
?>