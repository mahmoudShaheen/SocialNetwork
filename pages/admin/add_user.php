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
			
			if (mysqli_num_rows($result) >= 1) {
				$message = "User Already exist.";
			} else {//username is unique
				$query = "INSERT INTO user (username, password_hash) VALUES (?, ?)";
				
				$add_user_stmt = mysqli_prepare($connection, $query);
				mysqli_stmt_bind_param($add_user_stmt, "ss", $username, $hashed_password);
				mysqli_stmt_execute($add_user_stmt);
				$result = mysqli_stmt_get_result($add_user_stmt);
				mysqli_stmt_close($add_user_stmt);
				
				if (mysqli_affected_rows($connection)) {
					
					$message = '<div class="alert alert-success">The user was successfully created.</div>';

				} else {
					$message = '<div class="alet alert-danger">The user could not be created.</div>';
					$message .= "<br />";
				}
			}
		} else {
			$message = '<div class="alert alert-warning">There were '.count($errors). ' errors in the form.</div>' ;
		}
	} else { // Form has not been submitted.
		$username = "";
		$password = "";
	}
?>
<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>

		<!-- Page Content -->
		
				
			
		<div class="table">
			<div class="container">
			<table id="structure">
	<tr>
		<td id="page">
			<h2>Create New User</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="add_user.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
				</tr><br />
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Create user" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table></div></div>
<?php include("../../includes/footer_admin.php"); ?>