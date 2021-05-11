<?php 
	include('config.php');
	$conn = mysqli_connect($host, $username, $password, $database);
	//uncomment the code below for enabling php mailer
	/* 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/Exception.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/PHPMailer.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/SMTP.php';
	*/

	$username = "";
	$email    = "";
	$password = "";

	if (isset($_POST['reg_user'])) 
	{
		include('mailer_config.php');
		$errors = array(); 
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password = esc($_POST['password']);

		if (empty($username)) {  array_push($errors, "Select an Username."); }
		if (empty($email)) { array_push($errors, "Provide your Email Address"); }
		if (empty($password)) { array_push($errors, "Set a Password"); }

		$user_check_query = "SELECT * FROM members WHERE username='$username' OR email='$email' LIMIT 1";
		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) 
		{
			if ($user['username'] === $username) 
			{
			  array_push($errors, "Username already taken");
			}

			if ($user['email'] === $email) 
			{
			  array_push($errors, "An account linked to this email address already exists");
			}
		}

			if (count($errors) == 0) 
			{

			$password1 = $password;
			$password = md5($password);

			$myDate= date('Y-m-d');
			$validity = '1';
			$expirydate = date('Y-m-d', strtotime($myDate . "+$validity days") );

			$query = "INSERT INTO temp_members (username, email, password, expiry) 
					  VALUES('$username', '$email', '$password', '$expirydate')";
			mysqli_query($conn, $query);
			$reg_user_id = mysqli_insert_id($conn); 

			$generator = "1357902468"; 
			$otp = ""; 
			for ($i = '1'; $i <= '5'; $i++) 
			{ 
        		$otp .= substr($generator, (rand()%(strlen($generator))), '1'); 
  			}
  			$query1 = "INSERT INTO otp (otp, member_id) VALUES('$otp', '$reg_user_id')";
			mysqli_query($conn, $query1);
			$otp_id = mysqli_insert_id($conn); 
			
			//uncomment the code below for enabling php mailer
			/*
				$mail = new PHPMailer;
				$mail->isSMTP(); 
				$mail->SMTPDebug = 0;
				$mail->Host = "smtp.gmail.com"; 
				$mail->Port = 587; 
				$mail->SMTPSecure = 'tls'; 
				$mail->SMTPAuth = true;
				$mail->Username = $mailer_username; 
				$mail->Password = $mailer_password; 
				$mail->setFrom('system@tfps.com', 'TFPS'); 
				$mail->addAddress($email, $username);
				$mail->Subject = 'Signup Succesful';
				$mail->msgHTML("Hi ".$username.", you have successfully registered at <b>TFPS</b>.<br>Your account details are:<br>&nbsp;&nbsp;Username: <b>".$username."</b><br>&nbsp;&nbsp;Password: <b>".$password1."</b><br>The OTP for verifying your account is :<br>&nbsp;<b>".$otp."</b><br>Thank You,<br>TFPS Admin<br><b>TFPS, IIT KGP</b>");
				$mail->AltBody = 'HTML Texts Not Supported'; 
				$mail->SMTPOptions = array(
				                    'ssl' => array(
				                        'verify_peer' => false,
				                        'verify_peer_name' => false,
				                        'allow_self_signed' => true
				                    )
				                );
                $mail->send();
            */
            session_start();
			$_SESSION['user'] = GetTempMemberById($reg_user_id); 
			$_SESSION['message'] = "Verify yout account";
			
			header('location: verify_otp.php?otpID='.$otp_id);

		}
	}



	if (isset($_POST['login_user'])) 
	{
		$errors = array(); 
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);
		
		if (empty($username)) {  array_push($errors, "Enter your Username."); }
		if (empty($password)) { array_push($errors, "Enter your Password"); }
		if (empty($errors)) 
		{
			$password = md5($password);
			$query = "SELECT * FROM members WHERE username='$username' AND password='$password' LIMIT 1";
			$result = mysqli_query($conn, $query);

			if (mysqli_num_rows($result) > '0')
			{
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 
				session_start();
				$_SESSION['user'] = GetMemberById($reg_user_id); 
				if ( in_array($_SESSION['user']['role'], ["M"])) 
				{
					$_SESSION['message'] = "You are now logged in";
					header('location: dashboard.php');
				} 
			} 
			else 
			{
				array_push($errors, 'Wrong Credentials');
			}
		}
	}

	function esc(String $value)
	{	
		global $conn;

		$val = trim($value);
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}

	function GetTempMemberById($id)
	{
		global $conn;
		$sql = "SELECT * FROM temp_members WHERE id = '$id' LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}

	function GetMemberById($id)
	{
		global $conn;
		$sql = "SELECT * FROM members WHERE id = '$id' LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}

?>
