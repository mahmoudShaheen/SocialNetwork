<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
?>

<?php
	//html header
	include("../../includes/header.php"); 
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
	require_once("../../includes/social_functions.php"); 
	
	$post = get_post_data($post_id);
	
	if( $post_row = mysqli_fetch_assoc($post)) {
		//get post owner data
		 $post_user = get_user_data($post_row["userID"]);
		 if( $post_user_row = mysqli_fetch_assoc($post_user)) {
			echo htmlentities($post_user_row["UserName"]);
			echo htmlentities($post_user_row["FirstName"]);
			echo htmlentities($post_user_row["MiddleName"]);
			echo htmlentities($post_user_row["LastName"]);
			echo htmlentities($post_user_row["PictureURL"]);
			echo htmlentities($post_user_row["collegeRole"]);
			
		 }
		 //post payload
		echo htmlentities($post_row["time"]);
		echo htmlentities($post_row["userID"]);
		echo htmlentities($post_row["post"]);
		echo htmlentities($post_row["postID"]);
		
		//get post tags
		$post_tags = get_post_tags($post_id);
		while( $post_tag_row = mysqli_fetch_assoc($post_tags)) {
			echo htmlentities($post_tag_row["tag"]);
		}
		
		//get post comments
		$post_comment = get_post_comments($post_row["postID"]);
		 while( $post_comment_row = mysqli_fetch_assoc($post_comment)) {
			 //get comment owner data
			$comment_user = get_user_data($post_comment_row["userID"]);
			 if( $comment_user_row = mysqli_fetch_assoc($comment_user)) {
				echo htmlentities($comment_user_row["UserName"]);
				echo htmlentities($comment_user_row["FirstName"]);
				echo htmlentities($comment_user_row["MiddleName"]);
				echo htmlentities($comment_user_row["LastName"]);
				echo htmlentities($comment_user_row["PictureURL"]);
				echo htmlentities($comment_user_row["collegeRole"]);
			 }
			 //get comment time and payload
			echo htmlentities($post_comment_row["comment"]);
			echo htmlentities($post_comment_row["time"]);
		 }
	}else{//post not found
		echo "post not found";
	}
?>

<?php 
	//html footer + close database connection if any
	include("../../includes/footer.php"); 
?>