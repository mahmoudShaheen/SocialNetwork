<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
	$user_id = logged_in_as();
?>
<?php 
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
	}else{
		echo "[[Empty action!]]";
		exit;
	}
	
	switch($action){
		case "add_email":
			if (isset($_POST['email'])) {
				$email = $_POST['email'];
			}else{
				echo "[[Empty email!]]";
				exit;
			}
			$query = "INSERT INTO email (user_id, email) VALUES (?, ?)";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "is", $user_id, $email);
			break;
			
		case "delete_email":
			if (isset($_POST['email'])) {
				$email = $_POST['email'];
			}else{
				echo "[[Empty email!]]";
				exit;
			}
			$query = "DELETE FROM email WHERE user_id = ? AND email = ? LIMIT 1";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "is", $user_id, $email);
			break;
			
		case "add_number":
			if (isset($_POST['number'])) {
				$number = $_POST['number'];
			}else{
				echo "[[Empty number!]]";
				exit;
			}
			$query =  "INSERT INTO phone_number (user_id, phone_number) VALUES (?, ?)";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "is", $user_id, $number);
			break;
			
		case "delete_number":
			if (isset($_POST['number'])) {
				$number = $_POST['number'];
			}else{
				echo "[[Empty number!]]";
				exit;
			}
			$query = "DELETE FROM phone_number WHERE user_id = ? AND phone_number = ? LIMIT 1";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "is", $user_id, $number);
			break;
			
		case "add_position":
			if (isset($_POST['position'])) {
				$position = $_POST['position'];
			}else{
				echo "[[Empty position!]]";
				exit;
			}
			if (isset($_POST['company'])) {
				$company = $_POST['company'];
			}else{
				echo "[[Empty company!]]";
				exit;
			}
			$query = "INSERT INTO position (user_id, position, company) VALUES (?, ?, ?)";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "iss", $user_id, $position, $company);
			break;
			
		case "delete_position":
			if (isset($_POST['position'])) {
				$position = $_POST['position'];
			}else{
				echo "[[Empty position!]]";
				exit;
			}
			if (isset($_POST['company'])) {
				$company = $_POST['company'];
			}else{
				echo "[[Empty company!]]";
				exit;
			}
			$query = "DELETE FROM position WHERE user_id = ? AND position = ? AND company = ? LIMIT 1";
			$stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, "iss", $user_id, $position, $company);
			break;
			
		default:
			break;
	}
	//execute statement and closes it   
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	//check if any change made in database
	if (mysqli_affected_rows($connection)) {
		echo "[[Data Change Done!]]";
		exit;
	} else {
		echo "[[Error changing data!]]";
		exit;
	}

?>