<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../includes/session.php"); 
	confirm_logged_in(); 
?>

<?php
	//html header
	include("../includes/header.php"); 
?>

<?php
	//if user tries to enter admin area
	//user will be redirected here
	//with permission denied message
	if (isset($_GET['permission']) && $_GET['permission'] == 1) {
		$message = "Permission Denied!.";
		if (!empty($message)) {
			echo "<p class=\"message\">" . $message . "</p>";
		}
	}
?>
<?php
	//get page number from query string to show post 10 posts per page
	//page numbers starts from zero for first page
	if (isset($_GET['page']) ) {
		$page_number = $_GET['page'];
	}else{
		$page_number = 0; //first page
	}
?>
<?php
	//get post from db
	require_once("../includes/social_functions.php"); 
	
	$post = get_all_post($page_number);
	
	for( $post_row = mysqli_fetch_assoc($post)) {
		//get post owner data
		 $post_user = get_user_data($post_row["userID"]);
		 if( $post_user_row = mysqli_fetch_assoc($post_user)) {
			echo $post_user_row["UserName"];
			echo $post_user_row["FirstName"];
			echo $post_user_row["MiddleName"];
			echo $post_user_row["LastName"];
			echo $post_user_row["PictureURL"];
			echo $post_user_row["collegeRole"];
			
		 }
		 //post payload
		echo $post_row["time"];
		echo $post_row["userID"];
		echo $post_row["post"];
		echo $post_row["postID"];
		
		//get post tags
		$post_tags = get_post_tags($post_id);
		for( $post_tag_row = mysqli_fetch_assoc($post_tags)) {
			echo $post_tag_row["tag"];
		}
		
		//get post comments
		$post_comment = get_post_comments($post_row["postID"]);
		 for( $post_comment_row = mysqli_fetch_assoc($post_comment)) {
			 //get comment owner data
			$comment_user = get_user_data($post_comment_row["userID"]);
			 if( $comment_user_row = mysqli_fetch_assoc($comment_user)) {
				echo $comment_user_row["UserName"];
				echo $comment_user_row["FirstName"];
				echo $comment_user_row["MiddleName"];
				echo $comment_user_row["LastName"];
				echo $comment_user_row["PictureURL"];
				echo $comment_user_row["collegeRole"];
			 }
			 //get comment time and payload
			echo $post_comment_row["comment"];
			echo $post_comment_row["time"];
		 }
	}
?>

<?php 
	//html footer + close database connection if any
	include("../includes/footer.php"); 
?>