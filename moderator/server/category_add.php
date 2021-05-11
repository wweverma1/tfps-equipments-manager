<?php 

	include('config.php');

	session_start();

	if (isset($_POST['add_category'])) 
	{
		$category_name = esc($_POST['category']);
	
		if (empty($category_name)) {  array_push($errors, "Enter category name."); }

		if (count($errors) == 0) 
		{
				$q2 = "INSERT INTO categories (name) VALUES ('$category_name')";
				mysqli_query($conn, $q2);
				header('Location: categories.php');
		}
	}

function esc(String $value)
	{	
		global $conn;

		$val = trim($value);
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
?>