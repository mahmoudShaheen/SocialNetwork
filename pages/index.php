<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../includes/session.php"); 
	confirm_logged_in(); 
?>

<?php
	//html header
	include("../includes/header.php"); 
?>

<?php
	//if user tries to enter admin area
	//user will be redirected here
	//with permission denied message
	if (isset($_GET['permission']) && $_GET['permission'] == 1) {
		$message = "Permission Denied!.";
		if (!empty($message)) {
			echo "<p class=\"message\">" . $message . "</p>";
		}
	}
?>

<?php
	//dump data
	echo phpinfo(); 
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>