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
			$query = "SELECT user_id, username ";
			$query .= "FROM user ";
			$query .= "WHERE username = ? ";
			$query .= "AND password_hash = ? ";
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
				$_SESSION['user_id'] = $found_user['user_id'];
				$_SESSION['username'] = $found_user['username'];
				$user_id = $found_user['user_id'];
				
				//check if the user is admin
				$query = "SELECT user_id ";
				$query .= "FROM admin ";
				$query .= "WHERE user_id = ? ";
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
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login - CSE Network</title>
  
  
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>

      <link rel="stylesheet" href="../../stylesheets/login-style.css">

  
</head>

<body>
  <div class="login-wrap">
	<div class="login-html">
		<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
		<!--input id="tab-2" type="radio" name="tab" class="sign-up"--><!--label for="tab-2" class="tab">Sign Up</label-->
		<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
		<?php if (!empty($errors)) { display_errors($errors); } ?>
		<form action="login.php" method="post">
		<div class="login-form">
			<div class="sign-in-htm">
				<div class="group">
					<label for="user" class="label">Username</label>
					<input id="user" type="text" class="input" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>">
				</div>
				<div class="group">
					<label for="pass" class="label">Password</label>
					<input id="pass" type="password" class="input" data-type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>">
				</div>
				<div class="group">
					<input id="check" type="checkbox" class="check" checked>
					<label for="check"><span class="icon"></span> Keep me Signed in</label>
				</div>
				<div class="group">
					<input type="submit" class="button" name="submit" value="Login">
				</div>
				<div class="hr"></div>
				<div class="foot-lnk">
					<a href="#forgot">Forgot Password?</a>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
  
  
</body>
</html>
