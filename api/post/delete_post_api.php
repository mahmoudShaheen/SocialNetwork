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
	}else if(!admin_check()){//for users to be able to delete there own posts
		//get post id
		if (isset($_POST['post_id'])) {
			$post_id = $_POST['post_id'];
		}else{
			echo "[[Empty post ID!]]";
			exit;
		}
		
		$logged_user_id = $_SESSION['user_id'];
		$query = "SELECT user_id ";
		$query .= "FROM post ";
		$query .= "WHERE post_id = ? ";
		
		$check_owner_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($check_owner_stmt, "i", $post_id);
		mysqli_stmt_execute($check_owner_stmt);
		$result_set = mysqli_stmt_get_result($check_owner_stmt);
		mysqli_stmt_close($check_owner_stmt);
		$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$user_id = $result["user_id"];
		if($user_id != $logged_user_id){ //if the logged user isn't the owner of the post 
			echo "[[Permission Denied!]]";
			exit;
		}
	}else{//for admins to get post id
		//get post id
		if (isset($_POST['post_id'])) {
			$post_id = $_POST['post_id'];
		}else{
			echo "[[Empty post ID!]]";
			exit;
		}
	}
?>

<?php
	//check if post exists
	$query = "SELECT post_id FROM post WHERE post_id = ?";
	
	$check_post_stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($check_post_stmt, "i", $post_id);
	mysqli_stmt_execute($check_post_stmt);
	$result = mysqli_stmt_get_result($check_post_stmt);
	mysqli_stmt_close($check_post_stmt);
	
	if (mysqli_num_rows($result) < 1) {
		echo "[[Post ID is wrong]]";
		exit;
	} else {//post exists
		// Delete post
		$query = "DELETE FROM post ";
		$query .= "WHERE post_id = ? ";
		$query .= "LIMIT 1";
		
		$delete_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($delete_stmt, "i", $post_id);
		mysqli_stmt_execute($delete_stmt);
		$result_set = mysqli_stmt_get_result($delete_stmt);
		mysqli_stmt_close($delete_stmt);
		
		if (mysqli_affected_rows($connection)) {
			echo "[[Post Deleted!]]";
			exit;
		} else {
			echo "[[Error deleting post!]]";
			exit;
		}
	}
?>
