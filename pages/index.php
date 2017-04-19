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
	//dump data
	echo phpinfo(); 
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>