<?php 
include('../server/verify_otp.php');

session_start();

$otpID = $_REQUEST['otpID'];

?>

<html>

<head>
	<title>TFPS | Verify OTP</title>
</head>

<body>

  <h1 style="font-weight:bold;">TFPS Equipments Manager</h1> 

	<form method="post" action="verify_otp.php">
	  <?php include('../server/errors.php'); ?>
		<input type="hidden" name="otpID" value="<?php echo $otpID; ?>">
		<input type="number" name="input_otp" placeholder="Enter your 5 Digit OTP">
		<button type="submit" class="btn" name="verify_otp">Verify</button>
    <h4>Something wrong? <a href="register.php">Go back</a></h4>
	</form>

</body>

</html>