<?php 
  include ('../server/login_register.php') 
?>


<!DOCTYPE html>
<html>

<head>
  <title>Sign up | TFPS</title>
</head>

<body>
  
  <h1 style="font-weight:bold;"><a style="text-decoration: none;" href="../index.html">TFPS</a></h1> 
	
  <form method="post" action="register.php">
	    <?php include('../server/errors.php'); ?>
			<input type="email" name="email" placeholder="Email Address">
			<input type="text" name="username" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
		  <button type="submit" class="btn" name="reg_user">Register</button>
		  <h4>Already a member? <a href="login.php">Log in</a> instead</h4>
	</form>

</body>

</html>