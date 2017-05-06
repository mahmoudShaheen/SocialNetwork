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
		$required_fields = array('username', 'college_role');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('username' => 30, 'college_role' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));

		$username = trim(mysql_prep($_POST['username']));
		$college_role = trim(mysql_prep($_POST['college_role']));
		
		
		if ( empty($errors) ) {
			
			//check if user already exist
			$query = "SELECT userID FROM users WHERE UserName = ?";
			
			$check_user_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_user_stmt, "s", $username);
			mysqli_stmt_execute($check_user_stmt);
			$result = mysqli_stmt_get_result($check_user_stmt);
			mysqli_stmt_close($check_user_stmt);
			
			$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$userID = $result["userID"];
			
			if ($userID == null) {
				$message = "Username isn't correct!.";
			} else {//username is correct
				$query = "UPDATE users SET collegeRole = ? WHERE userID = ?";
				
				$update_role_stmt = mysqli_prepare($connection, $query);
				mysqli_stmt_bind_param($update_role_stmt, "ss", $college_role, $userID);
				mysqli_stmt_execute($update_role_stmt);
				$result = mysqli_stmt_get_result($update_role_stmt);
				mysqli_stmt_close($update_role_stmt);
				
				if (mysqli_affected_rows($connection)) {
					$message = "College role was successfully changed.";
				} else {
					$message = "College role could not be changed.";
					$message .= "<br />";
				}
			}
		} else {
			$message = "There were " . count($errors) . " errors in the form.";
		}
	} else { // Form has not been submitted.
		$username = "";
		$college_role = "";
	}
?>
<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Change College Role</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="college_role.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td>College Role:</td>
					<td><input type="text" name="college_role" maxlength="30" value="<?php echo htmlentities($college_role); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Update College Role" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php include("../../includes/footer_admin.php"); ?>