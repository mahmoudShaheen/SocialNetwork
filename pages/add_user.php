<?php require_once("../includes/session.php"); ?>
<?php 
	require_once("../includes/db_connection.php"); 
	global $connection;
?>
<?php require_once("../includes/functions.php"); ?>

<?php 
	confirm_logged_in(); 
	confirm_admin();
?>

<?php
	include_once("../includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		//TODO:
		//add other fields
		//add user name already exists, minimum length checks 

		if ( empty($errors) ) {
			$query = "INSERT INTO user (
							userName, passwordHash
						) VALUES (
							'{$username}', '{$hashed_password}'
						)";
			$result = mysqli_query($connection, $query);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
	} else { // Form has not been submitted.
		$username = "";
		$password = "";
	}
?>
<?php include("../includes/header.php"); ?>
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
				</tr>
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
</table>
<?php include("../includes/footer.php"); ?>