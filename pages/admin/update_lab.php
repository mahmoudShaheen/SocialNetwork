<?php
	require_once("../../includes/crud_labs.php");
?>
<?php require_once("../../includes/session.php"); ?>
<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>
<?php require_once("../../includes/social_functions.php"); ?>

<?php
	confirm_logged_in();
	confirm_admin();
?>

<?php

	include_once("../../includes/form_functions.php");

	if ($_GET['id']) {

		$lab_id   = $_GET['id'];

		// Old lab data to update
		$lab_data = read_lab_by_id($read_lab_stmt, $lab_id);

		$row = $lab_data->fetch_assoc();

		$result_set = get_user_data($row['user_id']);
		$user_data  = mysqli_fetch_assoc($result_set);

		/* echo htmlentities($user_data['username']);          // username entry
		echo htmlentities($row['name']);                    // name entry
        echo htmlentities($row['location']);                // location entry
        echo htmlentities($row['about']);                   // about entry */
    }

	if (isset($_POST['submit'])) {
		$errors = array();
        // perform validations on the form data
		$required_fields    = array('username', 'name', 'location', 'about');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('username' => 45, 'name' => 45, 'location' => 45, 'about' => 100);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('username' => 1, 'name' => 1, 'location' => 1, 'about' => 1);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

	    $lab_id   = $_GET['id'];
        $username = trim(mysql_prep($_POST['username']));                    // name for html input tag => username

		$get_user_id = $connection->prepare("SELECT `user_id` FROM `user` WHERE `username` = ?");
		$get_user_id->bind_param("s", $username);
		$get_user_id->execute();
		$user_id     = $get_user_id->get_result();
		$get_user_id->close();

        $name     = trim(mysql_prep($_POST['name']));                        // name for html input tag => name
        $location = trim(mysql_prep($_POST['location']));                    // name for html input tag => location
        $about    = trim(mysql_prep($_POST['about']));                       // name for html input tag => about

		if (empty($errors)) {
	        update_lab($user_id, $name, $location, $about, $lab_id);
		}
	}
 ?>

 <?php include("../../includes/header_admin.php") ?>
 <?php include("../../includes/sidebar_admin.php"); ?>
 		<!-- Page Content -->
		
				
			
		<div class="table">
			<div class="container">
 <table id="structure">
    <tr>
 	   <td id="page">
 		   <h2>Update lab</h2>
 		   <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
 		   <?php if (!empty($errors)) { display_errors($errors); } ?>
 		   <form action="edit.php?id=3" method="post">
 		   <table>
 			   <tr>
 				   <td>User Name:</td>
 				   <td><input type="text" name="username" maxlength="45" value="<?php echo htmlentities($user_data['username']); ?>"/></td>
 			   </tr>
 			   <tr>
 				   <td>Lab Name:</td>
 				   <td><input type="text" name="name" maxlength="45" value="<?php echo htmlentities($row['name']); ?>" /></td>
 			   </tr>
 			   <tr>
 				   <td>Location:</td>
 				   <td><input type="text" name="location" maxlength="45" value="<?php echo htmlentities($row['location']); ?>" /></td>
 			   </tr>
 			   <tr>
 				   <td>About:</td>
 				   <td><input type="text" name="about" maxlength="45" value="<?php echo htmlentities($row['about']); ?>" /></td>
 			   </tr>
 			   <tr>
 				   <td colspan="2"><input type="submit" name="submit" value="Update Lab" /></td>
 			   </tr>
 		   </table>
 		   </form>
 	   </td>
    </tr>
 </table></div></div>
 <?php include("../../includes/footer_admin.php") ?>
