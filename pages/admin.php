<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../includes/session.php"); 
	confirm_logged_in();
?>

<?php
	//check if the logged in user is an admin
	//if not redirect to home page with message "permission denied"
	confirm_admin();
?>

<?php
	//html header
	include("../includes/header.php"); 
?>

<?php
	//dump data
	echo phpinfo(); 
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>