<?php 
  include('../server/login_register.php'); 
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login | TFPS</title>
</head>

<body>

  <h1 style="font-weight:bold;"><a style="text-decoration: none;" href="../index.html">TFPS</a></h1> 

	<form method="post" action="login.php">
  	<?php include('../server/errors.php');?>
  	<input type="text" name="username" placeholder = "Username">
  	<input type="password" name="password" placeholder = "Password">
  	<button type="submit" class="btn" name="login_user">Sign in</button>
    <h4>Not a member yet? <a href="register.php">Register</a> right now</h4>
	</form>

</body>

</html>