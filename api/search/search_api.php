<?php require_once("../../includes/session.php"); ?>
<?php 
	require_once("../../includes/db_connection.php");
	global $connection;
?>

<?php 
	//only works if user is logged in
	if (!logged_in_as()) {
		echo "[[Permission Denied!]]";
		exit;
	}
?>
<?php
	if (isset($_POST['q'])) {
			$q = $_POST['q'];
			$q = "%".$q."%";
	}else{
		echo "[[query can't be empty!]]";
		exit;
	}
	
	// Search for user
	$query = "SELECT username ";
	$query .= "FROM users ";
	$query .= "WHERE username LIKE ? ";
	$query .= "LIMIT 10";
	
	$search_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($search_stmt, "s", $q);
	mysqli_stmt_execute($search_stmt);
	$result_set = mysqli_stmt_get_result($search_stmt);
	mysqli_stmt_close($search_stmt);
	
	echo '[';
	for ( $i=0 ; $i<mysqli_num_rows($result_set) ; $i++) {
		echo ($i>0?',':'').json_encode(mysqli_fetch_row($result_set));
	}
	echo ']';
?>