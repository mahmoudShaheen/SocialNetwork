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
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('username' => 8, 'password' => 8);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		
		if ( empty($errors) ) {
			
			//check if user already exist
			$query = "SELECT user_id FROM user WHERE username = ?";
			
			$check_user_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_user_stmt, "s", $username);
			mysqli_stmt_execute($check_user_stmt);
			$result = mysqli_stmt_get_result($check_user_stmt);
			mysqli_stmt_close($check_user_stmt);
			
			$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$userID = $result["user_id"];
			
			if ($userID == null) {
				$message = "Username isn't correct!.";
			} else {//username is correct
				$query = "UPDATE user SET password_hash = ? WHERE user_id = ?";
				
				$update_password_stmt = mysqli_prepare($connection, $query);
				mysqli_stmt_bind_param($update_password_stmt, "ss", $hashed_password, $userID);
				mysqli_stmt_execute($update_password_stmt);
				$result = mysqli_stmt_get_result($update_password_stmt);
				mysqli_stmt_close($update_password_stmt);
				
				if (mysqli_affected_rows($connection)) {
					$message = "The password was successfully changed.";
				} else {
					$message = "The password could not be changed.";
					$message .= "<br />";
				}
			}
		} else {
			$message = "There were " . count($errors) . " errors in the form.";
		}
	} else { // Form has not been submitted.
		$username = "";
		$password = "";
	}
?>
<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Change Password</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="change_password.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Update Password" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php include("../../includes/footer_admin.php"); ?>