<?php 
	include('config.php');
	$conn = mysqli_connect($host, $username, $password, $database);
	session_start();
	$errors = array();

if (isset($_POST['take'])) 
{
		$eID = mysqli_real_escape_string($conn, $_POST['eID']);
		$eName = mysqli_real_escape_string($conn, $_POST['eName']);
		$category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
		$owner_id = mysqli_real_escape_string($conn, $_POST['owner_id']);
		$taker_name = mysqli_real_escape_string($conn, $_POST['user_name']);
		$taker_id = mysqli_real_escape_string($conn, $_POST['user_id']);
		$taker_mobile = mysqli_real_escape_string($conn, $_POST['user_mobile']);
		$giver_name = mysqli_real_escape_string($conn, $_POST['currentlywith_name']);
		$giver_id = mysqli_real_escape_string($conn, $_POST['currentlywith_id']);
		$giver_mobile = mysqli_real_escape_string($conn, $_POST['currentlywith_mobile']);
		$remark = mysqli_real_escape_string($conn, $_POST['remark']);

		if (count($errors) == 0) 
		{
			date_default_timezone_set("Asia/Kolkata");
			$dated = date("Y-m-d H:i:s");

			if(empty($remark)=='1')
			{
				$q = "INSERT INTO borrow_history (equipment_id, equipment_name, category_name, owner_id, giver_id, giver_name, giver_number, taker_id, taker_name, taker_number, dated) VALUES ('$eID', '$eName', '$category_name', '$owner_id', '$giver_id', '$giver_name', '$giver_mobile', '$taker_id', '$taker_name', '$taker_mobile', '$dated' )";
			}
			else
			{
				$q = "INSERT INTO borrow_history (equipment_id, equipment_name, category_name, owner_id, giver_id, giver_name, giver_number, taker_id, taker_name, taker_number, dated, remark) VALUES ('$eID', '$eName', '$category_name', '$owner_id', '$giver_id', '$giver_name', '$giver_mobile', '$taker_id', '$taker_name', '$taker_mobile', '$dated', '$remark' )";			
			}
			mysqli_query($conn, $q);
			$q2 = "UPDATE equipments SET currentlywith_name='$taker_name', currentlywith_id='$taker_id', currentlywith_number='$taker_mobile' WHERE id='$eID'";
			mysqli_query($conn, $q2);

			if($taker_id==$owner_id)
			{
				$notification_owner = "Your Equipment ".$eName." has been returned by ".$giver_name.".";
				$notification_lender = "You have returned ".$eName." to ".$taker_name.".";
				$q3 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_owner', '$owner_id', '$dated')";
				mysqli_query($conn, $q3);
				$q4 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_lender', '$giver_id', '$dated')";
				mysqli_query($conn, $q4);
			}
			else if($giver_id==$owner_id)
			{
				$notification_lender = "You have lent ".$eName." to ".$taker_name.".";
				$notification_borrower = "You have borrowed ".$eName." from ".$giver_name.".";
				$q4 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_lender', '$giver_id', '$dated')";
				mysqli_query($conn, $q4);
				$q5 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_borrower', '$taker_id', '$dated')";
				mysqli_query($conn, $q5);
			}
			else
			{
				$notification_owner = "Your Equipment ".$eName." has been borrowed by ".$taker_name." from ".$giver_name.".";
				$notification_lender = "You have lent ".$eName." to ".$taker_name.".";
				$notification_borrower = "You have borrowed ".$eName." from ".$giver_name.".";
				$q3 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_owner', '$owner_id', '$dated')";
				mysqli_query($conn, $q3);
				$q4 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_lender', '$giver_id', '$dated')";
				mysqli_query($conn, $q4);
				$q5 = "INSERT INTO notification (notification, rid, dated) VALUES ('$notification_borrower', '$taker_id', '$dated')";
				mysqli_query($conn, $q5);
			}

			header('location: take_success.php');
		}
}

?>
