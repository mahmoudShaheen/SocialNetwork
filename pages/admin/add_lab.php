<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/crud_labs.php"); ?>
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

    if (isset($_POST['submit'])) {
        $errors = array();
        // perform validations on the form data
        $required_fields    = array('username', 'name', 'location', 'about');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('username' => 45, 'name' => 45, 'location' => 45, 'about' => 100);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('username' => 1, 'name' => 1, 'location' => 1, 'about' => 1);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

        $username = trim(mysql_prep($_POST['username']));                    // name for html input tag => username
        $name     = trim(mysql_prep($_POST['name']));                        // name for html input tag => name
        $location = trim(mysql_prep($_POST['location']));                    // name for html input tag => location
        $about    = trim(mysql_prep($_POST['about']));                       // name for html input tag => about

		$get_user_id = $connection->prepare("SELECT `user_id` FROM `user` WHERE `username` = ?");
		$get_user_id->bind_param("s", $username);
		$get_user_id->execute();
		$user_id_l   = $get_user_id->get_result();
		$user_id_a   = $user_id_l->fetch_assoc();
		$user_id     = $user_id_a['user_id'];
		$get_user_id->close();

        if (empty($errors)) {
            insert_lab($username, $name, $location, $about);
        }
    } else {
		$username = "";
		$name     = "";
		$location = "";
		$about    = "";
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
			<h2>Add New lab</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="add_lab.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="45" value="<?php echo htmlentities($username); ?>"/></td>
				</tr>
				<tr>
					<td>Lab Name:</td>
					<td><input type="text" name="name" maxlength="45" value="<?php echo htmlentities($name); ?>" /></td>
				</tr>
				<tr>
					<td>Location:</td>
					<td><input type="text" name="location" maxlength="45" value="<?php echo htmlentities($location); ?>" /></td>
				</tr>
				<tr>
					<td>About:</td>
					<td><input type="text" name="about" maxlength="45" value="<?php echo htmlentities($about); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Add Lab" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table></div></div>
<?php include("../../includes/footer_admin.php") ?>
