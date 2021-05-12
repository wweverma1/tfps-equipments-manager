<?php 
include('config.php');
$conn = mysqli_connect($host, $username, $password, $database);

/*
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/Exception.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/PHPMailer.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/server/phpMailer/SMTP.php';
*/

session_start();

$otpinput = "";
$route = "";
$otpID = "";


if (isset($_POST['verify_otp'])) 
	{

		$errors = array(); 
		$otpinput = esc($_POST['input_otp']);
		$route = esc($_POST['route']);
		$otpID = esc($_POST['otpID']);

		if (empty($otpinput)) {  array_push($errors, "Enter your 5 Digit OTP."); }

		$query = "SELECT * FROM otp WHERE id='$otpID' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$ans = mysqli_fetch_assoc($result);
		$correct_otp = $ans["otp"];
		$member_id = $ans["member_id"];
		
		if($route=='1')
		{
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
		else if($route=='2')
		{
			include('mailer_config.php');
			$uid = $_SESSION['reset_userid'];

			if($otpinput==$correct_otp && $member_id==$uid)
			{
				$generator = "1abc2defg4hij0klm3nop5qrs6tuv7wxy8z9"; 
				$password = ""; 
				for ($i = '1'; $i <= '8'; $i++) 
				{ 
	        		$password .= substr($generator, (rand()%(strlen($generator))), '1'); 
	  			}
				$user_check_query = "SELECT * FROM members WHERE id='$uid' LIMIT 1";
				$result = mysqli_query($conn, $user_check_query);
				$ans = mysqli_fetch_assoc($result);

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
					$mail->addAddress($ans["email"], $ans["username"]);
					$mail->Subject = 'Password reset successful';
					$mail->msgHTML("Hi ".$ans["name"].", your request for password reset has been processed successfully.<br>Your new password is:<br>&nbsp;<b>".$password."</b><br>It is advised that you login into your account and change your password in the "Update my Profile" section. Thank You,<br>TFPS Admin<br><b>TFPS, IIT KGP</b>");
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

	   			$password = md5($password);
	   			$q = "UPDATE members SET password='$password' WHERE id='$uid'";
				mysqli_query($conn, $q);
				session_destroy();
				header('location: password_reset_success.php');
			}
			else
			{
				array_push($errors, "Incorrect OTP.");
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

	function getUserById($id)
	{
		global $conn;
		$query = "SELECT * FROM members WHERE id = '$id' LIMIT 1";

		$result = mysqli_query($conn, $query);
		$user = mysqli_fetch_assoc($result);
		return $user; 
	}
?>