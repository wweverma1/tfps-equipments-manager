<?php 
  include('../server/login_register_reset.php'); 
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reset Password | TFPS</title>
</head>

<body>

  <h1 style="font-weight:bold;"><a style="text-decoration: none;" href="../index.html">TFPS</a></h1> 

	<form method="post" action="reset_password.php">
  	<?php include('../server/errors.php');?>
  	<input type="text" name="username_email" placeholder = "Username Or Email Address">
  	<button type="submit" class="btn" name="reset">Reset Password</button>
	<h5>In case you forgot everything contact the Admin of TFPS</h5>
  </form>
  <h4><a href="login.php">Go back</a></h4>

</body>

</html>