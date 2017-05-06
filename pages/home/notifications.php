<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
?>

<?php 
	//database connection
	require_once("../../includes/db_connection.php");
	global $connection;
?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/header_admin.php");
		include("../../includes/sidebar_admin.php");
	}else{ //normal user
		include("../../includes/header.php");
		include("../../includes/sidebar.php");
	}
?>

<?php
	//get user id
	$user_id = $_SESSION['user_id'];
	//get notifications from db
	$query = "SELECT * FROM notification WHERE header_id =  ";
	$query .= "(SELECT header_id FROM notification_header WHERE user_id = ? )";
	$query .= "ORDER BY time DESC LIMIT 50";
	$get_notifications_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($get_notifications_stmt, "i", $user_id);
	mysqli_stmt_execute($get_notifications_stmt);
	$result = mysqli_stmt_get_result($get_notifications_stmt);
	mysqli_stmt_close($get_notifications_stmt);

	$query = "UPDATE notification SET `read` = 1 WHERE notification_id = ?";
	$set_read_stmt = mysqli_prepare($connection, $query);
	while ( $row = mysqli_fetch_assoc($result)) {
		echo htmlentities($row["time"]);
		echo htmlentities($row["payload"]);
		echo htmlentities($row["redirection_url"]); //to redirect user on click
		echo htmlentities($row["read"]); //new or old notification
		mysqli_stmt_bind_param($set_read_stmt, "i", $row["notification_id"]);
		mysqli_stmt_execute($set_read_stmt);
	}
	mysqli_stmt_close($set_read_stmt);
?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>