<?php
	$dbhost = 'localhost';
	$username = 'root';
	$password = '';
	$db = 'chatbox';
	$connect = mysqli_connect("$dbhost", "$username", "$password", "$db");

	$query = "SELECT * FROM logs ORDER by id DESC";
	$result1 = mysqli_query($connect , $query);
	
	while( $extract = mysqli_fetch_array($result1)){
		echo "<span class='uname'>" . $extract['username'] . " : </span> <span class='msg'>" . $extract['msg'] . "</span><br>";
	}
	mysqli_free_result($result1);
	mysqli_close($connect);
?>