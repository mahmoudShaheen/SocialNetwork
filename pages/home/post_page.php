<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
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
	//get post id from query string
	if (isset($_GET['id'])) {
		$post_id = $_GET['id'];
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
		 $post_user = get_user_data($post_row["user_id"]);
		 if( $post_user_row = mysqli_fetch_assoc($post_user)) {
			echo htmlentities($post_user_row["username"]);
			echo htmlentities($post_user_row["first_name"]);
			echo htmlentities($post_user_row["middle_name"]);
			echo htmlentities($post_user_row["last_name"]);
			echo htmlentities($post_user_row["college_role"]);
			
		 }
		 //post payload
		echo htmlentities($post_row["time"]);
		echo htmlentities($post_row["user_id"]);
		echo htmlentities($post_row["post"]);
		echo htmlentities($post_row["post_id"]);
		
		//get post tags
		$post_tags = get_post_tags($post_id);
		while( $post_tag_row = mysqli_fetch_assoc($post_tags)) {
			echo htmlentities($post_tag_row["tag"]);
		}
		
		//get post comments
		$post_comment = get_post_comments($post_row["post_id"]);
		 while( $post_comment_row = mysqli_fetch_assoc($post_comment)) {
			 //get comment owner data
			$comment_user = get_user_data($post_comment_row["user_id"]);
			 if( $comment_user_row = mysqli_fetch_assoc($comment_user)) {
				echo htmlentities($post_user_row["username"]);
				echo htmlentities($post_user_row["first_name"]);
				echo htmlentities($post_user_row["middle_name"]);
				echo htmlentities($post_user_row["last_name"]);
				echo htmlentities($post_user_row["college_role"]);
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
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>