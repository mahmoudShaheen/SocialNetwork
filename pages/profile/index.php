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
	//html header
	include("../../includes/header.php"); 
?>
<?php
	//html sidebar
	include("../../includes/sidebar.php");
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
	$query = "SELECT userID FROM Users WHERE userID = ?";
	
	$check_user_stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($check_user_stmt, "s", $user_id);
	mysqli_stmt_execute($check_user_stmt);
	$result = mysqli_stmt_get_result($check_user_stmt);
	mysqli_stmt_close($check_user_stmt);
	
	$result = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$userID = $result["userID"];
	
	if ($userID == null) {//if user id from query string is wrong
		echo "Wrong user ID";
		exit;
	} else {//username is correct
		//get user data from db
		require_once("../../includes/social_functions.php"); 
		$user = get_user_data($user_id);
		$college_role = "";
		 if( $user_row = mysqli_fetch_assoc($user)) {
			echo htmlentities($user_row["FirstName"]);
			echo htmlentities($user_row["MiddleName"]);
			echo htmlentities($user_row["LastName"]);
			echo htmlentities($user_row["UserName"]);
			echo htmlentities($user_row["PictureURL"]);
			echo htmlentities($user_row["about"]);
			echo htmlentities($user_row["collegeRole"]);
			$college_role = $user_row["collegeRole"];
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
			echo htmlentities($position_row["positionName"]);
		}
		
		if($college_role == "Professor" || $college_role == "TA"){
			$researches = get_user_researches($user_id);
			while( $researches_row = mysqli_fetch_assoc($researches)) {
				echo htmlentities($researches_row["Title"]);
				echo htmlentities($researches_row["Idea"]);
				echo htmlentities($researches_row["idResearches"]);
			}
		}
		
		$projects = get_user_projects($user_id);
		while( $projects_row = mysqli_fetch_assoc($projects)) {
				echo htmlentities($projects_row["Picture_URL"]);
				echo htmlentities($projects_row["name"]);
				echo htmlentities($projects_row["Idea"]);
				echo htmlentities($projects_row["idProjects"]);
			}
		
		if($college_role == "student"){
			//keys: idCourses, Name, about, department, Grading Schema
			$student_courses = get_student_courses($user_id);
			while( $student_courses_row = mysqli_fetch_assoc($student_courses)) {
				echo htmlentities($student_courses_row["Name"]);
				echo htmlentities($student_courses_row["about"]);
				echo htmlentities($student_courses_row["department"]);
				echo htmlentities($student_courses_row["idCourses"]);
			}
		}
		
		if($college_role == "Professor" || $college_role == "TA"){
			$prof_courses = get_prof_courses($user_id);
			while( $prof_courses_row = mysqli_fetch_assoc($prof_courses)) {
					echo htmlentities($prof_courses_row["Name"]);
					echo htmlentities($prof_courses_row["about"]);
					echo htmlentities($prof_courses_row["department"]);
					echo htmlentities($prof_courses_row["idCourses"]);
			}
		}
		
		
		//get one page of user posts "10 posts" , use query string to choose another set of posts
		$posts = get_user_posts($user_id, $page_number);
		while( $post_row = mysqli_fetch_assoc($posts)) {
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
			$post_id = $post_row["postID"];
			
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
		}
	}
?>

<?php 
	//html footer + close database connection if any
	include("../../includes/footer.php"); 
?>