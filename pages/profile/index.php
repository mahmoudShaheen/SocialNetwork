<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
?>
<?php 
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
	//get user id from query string if no query string logged in user profile is shown
	if (isset($_GET['user_id']) ) {
		$user_id = $_GET['user_id'];
		echo $user_id;
	}else{
		$user_id = $_SESSION['user_id'];
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
	
	//check if user already exist
	$query = "SELECT user_id FROM user WHERE user_id = ?";
	
	$check_user_stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($check_user_stmt, "s", $user_id);
	mysqli_stmt_execute($check_user_stmt);
	$result = mysqli_stmt_get_result($check_user_stmt);
	mysqli_stmt_close($check_user_stmt);
	
	$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$userID = $result["user_id"];
	
	if ($userID == null) {//if user id from query string is wrong
		echo "Wrong user ID";
		exit;
	} else {//username is correct
		//get user data from db
		require_once("../../includes/social_functions.php"); 
		$user = get_user_data($user_id);
		$college_role = "";
		 if( $user_row = mysqli_fetch_assoc($user)) {
			echo htmlentities($user_row["first_name"]);
			echo htmlentities($user_row["middle_name"]);
			echo htmlentities($user_row["last_name"]);
			echo htmlentities($user_row["username"]);
			echo htmlentities($user_row["about"]);
			echo htmlentities($user_row["college_role"]);
			$college_role = $user_row["college_role"];
		 }
		 
		$emails = get_user_emails($user_id);
		 while( $email_row = mysqli_fetch_assoc($emails)) {
			echo htmlentities($email_row["email"]);
		 }
		 
		$phone_numbers = get_user_phone_numbers($user_id);
		while( $phone_row = mysqli_fetch_assoc($phone_numbers)) {
			echo htmlentities($phone_row["phone_number"]);
		 }
		
		$skills = get_user_skills($user_id);
		while( $skill_row = mysqli_fetch_assoc($skills)) {
			echo htmlentities($skill_row["skill"]);
		}
		
		$positions = get_user_positions($user_id);
		while( $position_row = mysqli_fetch_assoc($positions)) {
			echo htmlentities($position_row["company"]);
			echo htmlentities($position_row["position"]);
		}
		
		$projects = get_user_projects($user_id);
		while( $projects_row = mysqli_fetch_assoc($projects)) {
				echo htmlentities($projects_row["name"]);
				echo htmlentities($projects_row["idea"]);
				echo htmlentities($projects_row["project_id"]);
			}
		
		if($college_role == "student"){
			$student_courses = get_student_courses($user_id);
			while( $student_courses_row = mysqli_fetch_assoc($student_courses)) {
				echo htmlentities($student_courses_row["name"]);
				echo htmlentities($student_courses_row["about"]);
				echo htmlentities($student_courses_row["department"]);
				echo htmlentities($student_courses_row["course_id"]);
			}
		}
		
		if($college_role == "Professor" || $college_role == "TA"){
			$prof_courses = get_prof_courses($user_id);
			while( $prof_courses_row = mysqli_fetch_assoc($prof_courses)) {
					echo htmlentities($prof_courses_row["name"]);
					echo htmlentities($prof_courses_row["about"]);
					echo htmlentities($prof_courses_row["department"]);
					echo htmlentities($prof_courses_row["course_id"]);
			}
		}
		
		
		//get one page of user posts "10 posts" , use query string to choose another set of posts
		$posts = get_user_posts($user_id, $page_number);
		while( $post_row = mysqli_fetch_assoc($posts)) {
			//get post owner data
			 $post_user = get_user_data($post_row["user_id"]);
			 if( $post_user_row = mysqli_fetch_assoc($post_user)) {
				echo htmlentities($user_row["first_name"]);
				echo htmlentities($user_row["middle_name"]);
				echo htmlentities($user_row["last_name"]);
				echo htmlentities($user_row["username"]);
				echo htmlentities($user_row["about"]);
				echo htmlentities($user_row["college_role"]);
				
			 }
			 //post payload
			echo htmlentities($post_row["time"]);
			echo htmlentities($post_row["user_id"]);
			echo htmlentities($post_row["post"]);
			echo htmlentities($post_row["post_id"]);
			$post_id = $post_row["post_id"];
			
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
					echo htmlentities($user_row["first_name"]);
					echo htmlentities($user_row["middle_name"]);
					echo htmlentities($user_row["last_name"]);
					echo htmlentities($user_row["username"]);
					echo htmlentities($user_row["about"]);
					echo htmlentities($user_row["college_role"]);
				 }
				 //get comment time and payload
				echo htmlentities($post_comment_row["comment"]);
				echo htmlentities($post_comment_row["time"]);
			 }
		}
	}
?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>