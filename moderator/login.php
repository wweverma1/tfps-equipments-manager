<?php  include('server/login.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Login | Admin TFPS</title>
</head>
<body>

  <h1 style="font-weight:bold;">TFPS</h1> 
	<h2>Welcome Admin</h2>

	<form method="post" action="login.php">
	<?php include('server/errors.php'); ?>
			
	<input type="text" name="username" placeholder = "Username">
	<input type="password" name="password" placeholder = "Password">
	<button type="submit" class="btn" name="login_admin">Login</button>
	
	</form>

	<h3><a href="../index.html">Goto Main site</a></h3>
</body>

</html>