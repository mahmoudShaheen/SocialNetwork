<?php
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php");
	confirm_logged_in();
	$username = $_SESSION['username'];
	echo $username;
	//echo "ahmedpoto";
?>