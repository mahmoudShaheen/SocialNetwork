<?php require_once("../../includes/session.php"); ?>
<?php 
	require_once("../../includes/db_connection.php");
	global $connection;

	// Eidarous Edit Start
	//keys: userID, FirstName, MiddleName, LastName, UserName, PasswordHash, 
	//			PictureURL, about, lastActiveTime, collegeRole
	function get_user_data($user_id){
		global $connection;
		$query = "SELECT * FROM user WHERE user_id = ? ";
		$get_user_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_user_stmt, "i", $user_id);
		mysqli_stmt_execute($get_user_stmt);
		$result_set = mysqli_stmt_get_result($get_user_stmt);
		mysqli_stmt_close($get_user_stmt);
		return $result_set;
	}
// Eidarous Edit end
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
	//get post
	if (isset($_POST['post'])) {
		$post = $_POST['post'];
	}else{
		 var_dump($_POST);
		//echo "[[Empty post!]]";
		exit;
	}
	//get tags
	if (isset($_POST['tags'])) {
		$tags = $_POST['tags'];
		$tags = explode(",", $tags);
	}
	
	// add post
	$query = "INSERT INTO post (user_id, post, time) VALUES (?, ?, ?)";
	$post_stmt =  mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($post_stmt, "iss", $user_id, $post, $time);
	mysqli_stmt_execute($post_stmt);
	$result_set = mysqli_stmt_get_result($post_stmt);
	mysqli_stmt_close($post_stmt);
	
	if (mysqli_affected_rows($connection)) {
		if(isset($tags)){ //if user added any tags
			//add tags
			$post_id = mysqli_insert_id($connection);
			//prepared statement 
			$query = "SELECT tag_id FROM tag WHERE tag = ?";
			$chk_tag_stmt =  mysqli_prepare($connection, $query);
			$query = "INSERT INTO post_tag (post_id, tag_id) VALUES (?, ?)";
			$post_tag_stmt =  mysqli_prepare($connection, $query);
			$query = "INSERT INTO tag (tag) VALUES (?)";
			$tag_stmt =  mysqli_prepare($connection, $query);
			
			foreach($tags as $tag){
				//check if tag already exists
				mysqli_stmt_bind_param($chk_tag_stmt, "s", $tag);
				mysqli_stmt_execute($chk_tag_stmt);
				$result_set = mysqli_stmt_get_result($chk_tag_stmt);
				$result_set = mysqli_fetch_assoc($result_set);
				$tag_id = mysqli_insert_id($connection);
				if($tag_id == null){//tag not exists
					//add tag
					mysqli_stmt_bind_param($tag_stmt, "s", $tag);
					mysqli_stmt_execute($tag_stmt);
					if (!mysqli_affected_rows($connection)) {//add tag failed
						echo "[[Error adding tag!]]";
						continue;
					}
					$tag_id = mysqli_insert_id($connection); //get inserted tag id
				}
				//connect post to tag
				mysqli_stmt_bind_param($post_tag_stmt, "ii", $post_id , $tag_id);
				mysqli_stmt_execute($post_tag_stmt);
				if (!mysqli_affected_rows($connection)) {//insert tag-post connection failed
					echo "[[Error adding tag to post!]]";
				}
			}
			//close prepared statements
			mysqli_stmt_close($chk_tag_stmt);
			mysqli_stmt_close($post_tag_stmt);
			mysqli_stmt_close($tag_stmt);
		}
		// Eidarous Edit Start
		// Get the user who made the post information
		$post_user = get_user_data($user_id);
		$post_user_row = mysqli_fetch_assoc($post_user);
		// prepare date to return
		$post_data = array('user_id' => $user_id, 'user_profile_image' => $post_user_row['profile_image'], 'user_name' => $post_user_row['username'], 'post' => $post, 'time' => $time );
		// Json encode post data. 
		$post_data = json_encode(array('post_data' => $post_data)); //json_encode is a php function that converts the array to JSON
		echo $post_data;
		exit;
		// Eidarous Edit end
	} else {
		echo "[[Error adding post!]]";
		exit;
	}


?>
