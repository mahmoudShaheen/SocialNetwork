<?php

	//file for functions handle database connection
	
	require("db_constants.php");

	//Connect to database server
	//and Select the database 
	function db_connect(){
		//Create a database connection
		$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if (!$connection) {
			die("Database connection failed: " . mysql_error());
		}

		//Select a database to use 
		$db_select = mysql_select_db(DB_NAME,$connection);
		if (!$db_select) {
			die("Database selection failed: " . mysql_error());
		}	
	}

	//Close connection
	function db_disconnect(){
		mysql_close($connection);
	}

?>
