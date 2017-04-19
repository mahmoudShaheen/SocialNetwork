<?php

	//file for functions handle database connection
	
	require("db_constants.php");

	//Create a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
	if(!$connection){
		die("Database connection failed" . mysqli_error());
}
	//Select a database to use 
	$db_select = mysqli_select_db($connection, DB_NAME);
	if(!$db_select){
		die("Database selection failed" . mysqli_error());
	}

?>
