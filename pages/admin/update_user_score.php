<?php require_once("../../includes/session.php"); ?>
<?php 
	require_once("../../includes/db_connection.php"); 
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php 
	confirm_logged_in(); 
	confirm_admin();
?>

<?php
	include_once("../../includes/form_functions.php");

	// START FORM PROCESSING
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if(isset($_POST['submit'])){
			$year = $_POST['year'];
			$query = "select * FROM subject WHERE year = '$year'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$resul_arr = array();
			while($row = mysqli_fetch_array($result)){
				$resul_arr[$row['name']] = $_POST[str_replace(' ', '_', $row['name'])];
			}
			$stored_result = serialize($resul_arr);
			//get user id, current time
			$user_id = $_POST['user_id'];
			$query = "UPDATE user set $year = '$stored_result' WHERE user_id = $user_id";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

			$message = '<div class="alert alert-success">Record sucessfully stored</div>';
			$_SESSION['message'] = $message;
			header("Location: get_user.php?id=$user_id");
			
		}

		$errors = array();
		
		$id = trim(mysql_prep($_GET['id']));
		
		if (($id) && !empty($id)) {
			$query = "SELECT * FROM user WHERE user_id = $id";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$row = mysqli_fetch_array($result);
		} else {
			
		}
	}
?>
		<!-- Page Content -->
