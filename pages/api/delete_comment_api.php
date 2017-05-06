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
	}else if(!admin_check()){//for users to be able to delete there own comments
		//get comment id
		if (isset($_POST['comment_id'])) {
			$comment_id = $_POST['comment_id'];
		}else{
			echo "[[Empty comment ID!]]";
			exit;
		}
		
		$logged_user_id = $_SESSION['user_id'];
		$query = "SELECT user_id ";
		$query .= "FROM comment ";
		$query .= "WHERE comment_id = ? ";
		
		$check_owner_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($check_owner_stmt, "i", $comment_id);
		mysqli_stmt_execute($check_owner_stmt);
		$result_set = mysqli_stmt_get_result($check_owner_stmt);
		mysqli_stmt_close($check_owner_stmt);
		$result_set = mysqli_fetch_array($result_set, MYSQLI_ASSOC);
		$user_id = $result_set["user_id"];
		if($user_id != $logged_user_id){ //if the logged user isn't the owner of the comment 
			echo "[[Permission Denied!]]";
			exit;
		}
	}else{//for admins to get comment id
		//get comment id
		if (isset($_POST['comment_id'])) {
			$comment_id = $_POST['comment_id'];
		}else{
			echo "[[Empty comment ID!]]";
			exit;
		}
	}
?>

<?php
	//check if user already exist
	$query = "SELECT comment_id FROM comment WHERE comment_id = ?";
	
	$check_comment_stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($check_comment_stmt, "i", $comment_id);
	mysqli_stmt_execute($check_comment_stmt);
	$result = mysqli_stmt_get_result($check_comment_stmt);
	mysqli_stmt_close($check_comment_stmt);
	
	if (mysqli_num_rows($result) < 1) {
		echo "[[comment ID is wrong]]";
		exit;
	} else {//comment exists
		// Delete comment
		$query = "DELETE FROM comment ";
		$query .= "WHERE comment_id = ? ";
		$query .= "LIMIT 1";
		
		$delete_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($delete_stmt, "i", $comment_id);
		mysqli_stmt_execute($delete_stmt);
		$result_set = mysqli_stmt_get_result($delete_stmt);
		mysqli_stmt_close($delete_stmt);
		
		if (mysqli_affected_rows($connection)) {
			echo "[[Comment Deleted!]]";
			exit;
		} else {
			echo "[[Error deleting comment!]]";
			exit;
		}
	}
?>
