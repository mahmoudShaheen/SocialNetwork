<?php require_once("../../includes/session.php"); ?>
<?php 
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php 
	
	if (logged_in_as()) {
		redirect_to("index.php");
	}
	
	
	include_once("../../includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT userID, UserName ";
			$query .= "FROM users ";
			$query .= "WHERE UserName = ? ";
			$query .= "AND PasswordHash = ? ";
			$query .= "LIMIT 1";
			
			$login_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($login_stmt, "ss", $username, $hashed_password);
			mysqli_stmt_execute($login_stmt);
			$result_set = mysqli_stmt_get_result($login_stmt);
			mysqli_stmt_close($login_stmt);
			confirm_query($result_set);
			if (mysqli_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysqli_fetch_array($result_set);
				$_SESSION['user_id'] = $found_user['userID'];
				$_SESSION['username'] = $found_user['UserName'];
				$user_id = $found_user['userID'];
				
				//check if the user is admin
				$query = "SELECT userID ";
				$query .= "FROM Admin ";
				$query .= "WHERE userID = ? ";
				$query .= "LIMIT 1";
				$admin_stmt = mysqli_prepare($connection, $query);
				mysqli_stmt_bind_param($admin_stmt, "i", $user_id);
				mysqli_stmt_execute($admin_stmt);
				$result_set = mysqli_stmt_get_result($admin_stmt);
				confirm_query($result_set);
				if (mysqli_num_rows($result_set) == 1) {
					// user is admin
					// and only 1 match
					$found_admin = mysqli_fetch_array($result_set);
					$_SESSION['admin'] = "1";
				}else{
					$_SESSION['admin'] = "0";
				}
			redirect_to("index.php");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
			}
		} else { 
			$message = "There were " . count($errors) . " errors in the form.";
		}
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		$username = "";
		$password = "";
	}
?>
<?php
	include("../../includes/header_login.php");
?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Staff Login</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="login.php" method="post">
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
					<td colspan="2"><input type="submit" name="submit" value="Login" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php include("../../includes/footer_login.php"); ?>