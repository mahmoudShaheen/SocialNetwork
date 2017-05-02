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
<?php require_once("../../includes/functions.php"); ?>

<?php 
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		include_once("../../includes/form_functions.php");
		$errors = array();

		// perform validations on the form data
		$required_fields = array('first_name', 'last_name', 'about');
		$errors = array_merge($errors, check_required_fields($required_fields));

		$fields_max_lengths = array('first_name' => 45, 'last_name' => 45, 'middle_name' => 45, 'about' => 300);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('first_name' => 3, 'last_name' => 3);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		$first_name = trim(mysql_prep($_POST['first_name']));
		$middle_name = trim(mysql_prep($_POST['middle_name']));
		$last_name = trim(mysql_prep($_POST['last_name']));
		$about = trim(mysql_prep($_POST['about']));
		
		if ( empty($errors) ) {
			//add data to database
			$query = "UPDATE Users SET FirstName = ?, MiddleName = ?, LastName = ?, about = ? WHERE userID = ?";
			$update_profile_stmt =  mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($update_profile_stmt, "i", $first_name, $middle_name, $last_name, $about, $user_id);
			mysqli_stmt_execute($update_profile_stmt);
			$result_set = mysqli_stmt_get_result($update_profile_stmt);
			mysqli_stmt_close($update_profile_stmt);
			
			if (mysqli_affected_rows($connection)) {
				echo "[[Profile Updated!]]";
				exit;
			} else {
				echo "[[Error updating profile!]]";
				exit;
			}
		}
	} else { // Form has not been submitted.
		//get user data from db
		require_once("../includes/social_functions.php"); 
		$user = get_user_data($user_id);
		$college_role = "";
		if( $user_row = mysqli_fetch_assoc($user)) {
			$first_name = $user_row["FirstName"];
			$middle_name =  $user_row["MiddleName"];
			$last_name = $user_row["LastName"];
			$picture_url = $user_row["PictureURL"];
			$about = $user_row["about"];
		}
	}
?>
<?php include("../includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Staff Login</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="login.php" method="post">
			<table>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="first_name" maxlength="30" value="<?php echo htmlentities($first_name); ?>" /></td>
				</tr>
				<tr>
					<td>Middle Name:</td>
					<td><input type="text" name="middle_name" maxlength="30" value="<?php echo htmlentities($middle_name); ?>" /></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="last_name" maxlength="30" value="<?php echo htmlentities($last_name); ?>" /></td>
				</tr>
				<tr>
					<td>About:</td>
					<td><input type="text" name="about" maxlength="300" value="<?php echo htmlentities($about); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Login" />
						<input type="reset">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<?php 
//picture_url is always the same 
//it can be found here rootURL/uploads/user_images/{$user_id}.*
 ?>
<form action="upload_image.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
	//for calling API "edit_profile_api" using using JS
	//for adding or deleting email, skill, position
	$emails_results = get_user_emails($user_id);
	for( $email_row = mysqli_fetch_assoc($emails_results)) {
		echo htmlentities($email_row["email"]); 
	}
	 
	$phone_numbers_results = get_user_phone_numbers($user_id);
	for( $phone_row = mysqli_fetch_assoc($phone_numbers_results)) {
		echo htmlentities($phone_row["phone_number"]);
	}
	
	$skills_results = get_user_skills($user_id);
	for( $skill_row = mysqli_fetch_assoc($skills_results)) {
		echo htmlentities($skill_row["skill"]);
	}
	
	$positions_results = get_user_positions($user_id);
	for( $position_row = mysqli_fetch_assoc($positions_results)) {
		echo htmlentities($position_row["company"]);
		echo htmlentities($position_row["positionName"]);
	}
?>
<?php include("../includes/footer.php"); ?>