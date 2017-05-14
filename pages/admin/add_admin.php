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
		$required_fields = array('username');
		$errors = array_merge($errors, check_required_fields($required_fields));

		$username = trim(mysql_prep($_POST['username']));
		
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
				$message = "Username isn't correct.";
			} else {//username found
				$query = "INSERT INTO admin (user_id) VALUES (?)";
				
				$add_admin_stmt = mysqli_prepare($connection, $query);
				mysqli_stmt_bind_param($add_admin_stmt, "i", $userID);
				mysqli_stmt_execute($add_admin_stmt);
				mysqli_stmt_close($add_admin_stmt);
				
				
				if (mysqli_affected_rows($connection) > 0) {
					$message = "The Admin was successfully added.";
				} else {
					$message = "The admin could not be added.";
					$message .= "<br />";
				}
			}
		} else {
			$message = "There were " . count($errors) . " errors in the form.";
		}
	} else { // Form has not been submitted.
		$username = "";
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
			<h2>Add Admin</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="add_admin.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" class="form-control" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Add Admin" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table></div></div>
<?php include("../../includes/footer_admin.php"); ?>