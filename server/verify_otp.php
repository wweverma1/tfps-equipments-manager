<?php 
include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);

session_start();

$otpinput = "";
$otpID = "";


if (isset($_POST['verify_otp'])) 
	{
		$errors = array(); 
		$otpinput = esc($_POST['input_otp']);
		$otpID = esc($_POST['otpID']);

		if (empty($otpinput)) {  array_push($errors, "Enter your 5 Digit OTP."); }

		$query = "SELECT * FROM otp WHERE id='$otpID' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$ans = mysqli_fetch_assoc($result);
		$correct_otp = $ans["otp"];
		$member_id = $ans["member_id"];
		if($otpinput==$correct_otp && $member_id==$_SESSION['user']['id'])
		{
			$query1 = "SELECT * FROM temp_members WHERE id='$member_id' LIMIT 1";
			$result1 = mysqli_query($conn, $query1);
			$ans1 = mysqli_fetch_assoc($result1);
			$username = $ans1["username"];
			$email = $ans1["email"];
			$password = $ans1["password"];

			$query2 = "INSERT INTO members (username, password, email) VALUES ('$username', '$password', '$email')";
			mysqli_query($conn, $query2);
			$reg_user_id = mysqli_insert_id($conn); 
			$_SESSION['user'] = getUserById($reg_user_id);
			$query3 = "DELETE FROM temp_members WHERE id='$member_id'"; 
			mysqli_query($conn,$query3);
			$_SESSION['message'] = "Verification Successful";
			date_default_timezone_set("Asia/Kolkata");
			$dated = date("Y-m-d H:i:s");
			$notification = "Welcome to TFPS, IIT KGP";
            $query4 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification', '$reg_user_id', '$dated')";
			mysqli_query($conn, $query4);
			header('location: complete_profile.php');
		}
		else
		{
			array_push($errors, "Incorrect OTP.");
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
		$query = "SELECT * FROM members WHERE id = '$id' LIMIT 1";

		$result = mysqli_query($conn, $query);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}
?>