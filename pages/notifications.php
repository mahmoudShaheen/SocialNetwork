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
	//get user id
	$user_id = $_SESSION['user_id'];
	//get notifications from db
	$query = "SELECT * FROM Notification WHERE to_userID = ? ";
	$query .= "ORDER BY time_created DESC LIMIT 50";
	$get_notifications_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($get_notifications_stmt, "i", $user_id);
	mysqli_stmt_execute($get_notifications_stmt);
	$result_set = mysqli_stmt_get_result($get_notifications_stmt);
	mysqli_stmt_close($get_notifications_stmt);

	$query = "UPDATE Notification SET read = 1 WHERE notification_id = ?";
	$set_read_stmt = mysqli_prepare($connection, $query);
	while ( $row = mysqli_fetch_assoc($result)) {
		echo htmlentities($row["time_created"]);
		echo htmlentities($row["payload"]);
		echo htmlentities($row["redirection_url"]); //to redirect user on click
		echo htmlentities($row["read?"]); //new or old notification
		mysqli_stmt_bind_param($set_read_stmt, "i", $row["notification_id"]);
		mysqli_stmt_execute($set_read_stmt);
	}
	mysqli_stmt_close($set_read_stmt);
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>