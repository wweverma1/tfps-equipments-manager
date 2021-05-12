<?php 
include('../server/verify_otp.php');

session_start();

$otpID = $_REQUEST['otpID'];

$route = $_REQUEST['route'];

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
		<input type="hidden" name="route" value="<?php echo $route; ?>">
		<input type="number" name="input_otp" placeholder="Enter your 5 Digit OTP">
		<button type="submit" class="btn" name="verify_otp">Verify</button>
	</form>

	<?php if($route=='1') : ?>
		<h4>Something wrong? <a href="register.php">Go back</a></h4>
	<?php endif ?>
	<?php if($route=='2') : ?>
		<h4>Something wrong? <a href="reset_password.php">Go back</a></h4>
	<?php endif ?>

</body>

</html>