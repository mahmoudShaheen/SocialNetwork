<?php
	//file for sessions handling
	//and regulating pages access
	
	//for redirect function
	require("functions.php");
	
	// Find the session
	session_start();
	
	//returns user ID for currently logged in user
	function logged_in_as() {
		return isset($_SESSION['user_id']);
	}
	
	//checks whether a user logged in or not
	//if not redirect to login page
	function confirm_logged_in() {
		if (!logged_in_as()) {
			login_redirect();
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
	
	//function to log out user
	function log_out(){
		//Unset all the session variables
		$_SESSION = array();
		//Destroy the session cookie
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		//Destroy the session
		session_destroy();
		login_redirect();
	}
	
?>
