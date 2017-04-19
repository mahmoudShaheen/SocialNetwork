<?php

	//file for basic functions
	
	//encodes string for html
	 function html_encode($string){
		return htmlspecialchars($string);
	}
	
	//encodes URLs
	 function url_encode($string){
		return rawurlencode($string);
	}
	
	//accepts a URL and redirect user to it
	//requires output buffer to be ON
	//or call it in the first line of file before any html code
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	
	//prepares queries before sending it to database
	function mysql_prep( $value ) {
		global $connection;
		return mysqli_real_escape_string($connection, $value );
	}

	//check if the query went well
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed");
		}
	}
?>

