<?php 
	include('config.php');
	session_start();


	$username = "";
	$password    = "";
	$errors = array(); 


	if (isset($_POST['login_admin'])) 
	{
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);

		if(empty($username)==1){array_push($errors, 'Enter Username');}
		if(empty($password)==1){array_push($errors, 'Enter Password');}
		
		if (count($errors) == 0) 
		{
			$password = md5($password);
			$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
			$results = mysqli_query($conn, $query);

			if (mysqli_num_rows($results) == 1)
			 {
				$reg_user_id = mysqli_fetch_assoc($results)['id']; 
				$_SESSION['user'] = GetById($reg_user_id); 
				if ( in_array($_SESSION['user']['role'], ["A"])) 
				{
					$_SESSION['message'] = "You are now logged in";
					header('location: home/dashboard.php');
			 	} 
			} 
			else 
			{
				array_push($errors, 'Wrong Credentials');
			}
		}
	}


	function GetById($id)
	{
		global $conn;
		$sql = "SELECT * FROM admin WHERE id = '$id' LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}
?>