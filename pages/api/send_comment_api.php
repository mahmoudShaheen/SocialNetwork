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
	//get user id, current time
	$user_id = $_SESSION['user_id'];
	$time = date('Y-m-d H:i:s');
	//get post id
	if (isset($_POST['post_id'])) {
		$post_id = $_POST['post_id'];
	}else{
		echo "[[Empty post id!]]";
		exit;
	}
	//get comment
	if (isset($_POST['comment'])) {
		$comment = $_POST['comment'];
	}else{
		echo "[[Empty comment!]]";
		exit;
	}
	
	// add comment
	$query = "INSERT INTO comment (post_id, user_id, comment, time) VALUES (?, ?, ?, ?)";
	$comment_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($comment_stmt, "iiss", $post_id, $user_id, $comment, $time);
	mysqli_stmt_execute($comment_stmt);
	$result_set = mysqli_stmt_get_result($comment_stmt);
	mysqli_stmt_close($comment_stmt);
	
	if (mysqli_affected_rows($connection)) {
		echo "[[comment Added!]]";
		exit;
	} else {
		echo "[[Error adding comment!]]";
		exit;
	}
?>
