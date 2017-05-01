<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../includes/session.php"); 
	confirm_logged_in(); 
?>

<?php 
	//database connection
	require_once("../../includes/db_connection.php");
	global $connection;
?>

<?php
	//html header
	include("../includes/header.php"); 
?>

<?php
	//get post id from query string
	if (isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}else{
		echo "invalid post id";
		exit;
	}
?>

<?php
	//get post from db
	$query = "SELECT * FROM posts WHERE postID = ? "
	$get_post_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($get_post_stmt, "i", $post_id);
	mysqli_stmt_execute($get_post_stmt);
	$result_set = mysqli_stmt_get_result($get_post_stmt);
	mysqli_stmt_close($get_post_stmt);

	for ( $row = mysqli_fetch_assoc($result)) {
		echo $row["time"];
		echo $row["userID"];
		echo $row["post"];
		echo $row["read?"]; //new or old notification
		mysqli_stmt_bind_param($set_read_stmt, "i", $row["notification_id"]);
		mysqli_stmt_execute($set_read_stmt);
	}
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>