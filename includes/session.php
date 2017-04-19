<?php
	//file for sessions handling
	//and regulating pages access
	
	//for redirect function
	require("functions.php");
	
	session_start();
	
	//returns user ID for currently logged in user
	function logged_in_as() {
		return isset($_SESSION['user_id']);
	}
	
	//checks whether a user logged in or not
	//if not redirect to login page
	function confirm_logged_in() {
		if (!logged_in_as()) {
			
		}
	}
	
	//checks if the user is administrator
	function admin_check(){
		return isset($_SESSION['admin']);
	}
	
	//redirects user to login page
	function login_redirect(){
		redirect_to("login.php");
	}
	
?>
