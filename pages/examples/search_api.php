<?php require_once("../includes/session.php"); ?>
<?php 
	require_once("../includes/db_connection.php");
	global $connection;
?>

<?php 
	//only works if user is logged in
	if (!logged_in_as()) {
		echo "{Permission Denied!}";
		exit;
	}
?>
<?php
	if (isset($_GET['q'])) {
			$q = $_GET['q'];
	}else{
		echo "{query can't be empty!}";
		exit;
	}
	
	//TODO: prepared statements instead
	
	// Check database to see if username and the hashed password exist there.
	$query = "SELECT UserName ";
	$query .= "FROM user ";
	$query .= "WHERE userName LIKE '%";
	$query .=  "{$q}";
	$query .=  "%' "; 
	$query .= "LIMIT 10";
	$result_set = mysqli_query($connection, $query);
	confirm_query($result_set);
	//echo $result_set;
	echo '[';
	for ( $i=0 ; $i<mysqli_num_rows($result_set) ; $i++) {
		echo ($i>0?',':'').json_encode(mysqli_fetch_row($result_set));
	}
	echo ']';
?>