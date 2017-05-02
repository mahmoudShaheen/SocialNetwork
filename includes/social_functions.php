<?php
	//functions for retrieving social data
	//like: user data, posts, comments, etc...

	/* 
	*	all functions returns mysqli result set
	*	you can use this to fetch data from it
	*	for ( $row = mysqli_fetch_assoc($result)) {
	*	echo $row["key1"];
	*	echo $row["key2"];
	*	.........
	*	}
	*/

	//database connection
	require_once("db_connection.php");
	global $connection;
	
	//keys: userID, FirstName, MiddleName, LastName, UserName, PasswordHash, 
	//			PictureURL, about, lastActiveTime, collegeRole
	function get_user_data($user_id){
		$query = "SELECT * FROM Users WHERE userID = ? "
		$get_user_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_user_stmt, "i", $user_id);
		mysqli_stmt_execute($get_user_stmt);
		$result_set = mysqli_stmt_get_result($get_user_stmt);
		mysqli_stmt_close($get_user_stmt);
		return $result_set
	}

	//keys: user_id, email
	function get_user_emails($user_id){
		$query = "SELECT * FROM emails WHERE user_id = ? ORDER BY email DESC"
		$get_emails_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_emails_stmt, "i", $user_id);
		mysqli_stmt_execute($get_emails_stmt);
		$result_set = mysqli_stmt_get_result($get_emails_stmt);
		mysqli_stmt_close($get_emails_stmt);
		return $result_set
	}

	//keys: user_id, phone_number
	function get_user_phone_numbers($user_id){
		$query = "SELECT * FROM phone_numbers WHERE user_id = ? ORDER BY phone_number DESC"
		$get_numbers_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_numbers_stmt, "i", $user_id);
		mysqli_stmt_execute($get_numbers_stmt);
		$result_set = mysqli_stmt_get_result($get_numbers_stmt);
		mysqli_stmt_close($get_numbers_stmt);
		return $result_set
	}

	//keys: skillID, skill
	function get_user_skills($user_id){
		$query = "SELECT * FROM skills WHERE skillID = "
		$query .= "(SELECT skills_skillID FROM User_has_skills WHERE Users_userID = ?) ORDER BY skill DESC"
		$get_skills_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_skills_stmt, "i", $user_id);
		mysqli_stmt_execute($get_skills_stmt);
		$result_set = mysqli_stmt_get_result($get_skills_stmt);
		mysqli_stmt_close($get_skills_stmt);
		return $result_set
	}

	//keys: postID, userID, post, *tag, description, time
	function get_user_posts($user_id){
		$query = "SELECT * FROM posts WHERE userID = ? ORDER BY time DESC"
		$get_posts_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_posts_stmt, "i", $user_id);
		mysqli_stmt_execute($get_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_posts_stmt);
		mysqli_stmt_close($get_posts_stmt);
		return $result_set
	}

	//keys: userID, positionName, company
	function get_user_positions($user_id){
		$query = "SELECT * FROM position WHERE userID = ? ORDER BY positionName DESC"
		$get_positions_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_positions_stmt, "i", $user_id);
		mysqli_stmt_execute($get_positions_stmt);
		$result_set = mysqli_stmt_get_result($get_positions_stmt);
		mysqli_stmt_close($get_positions_stmt);
		return $result_set
	}

	//returns college role for user using user id
	function get_user_college_role($user_id){
		$result = get_user_data($user_id);
		if($row = mysqli_fetch_assoc($result)){
			return $row["collegeRole"];
		}
		return false;
	}

	//keys: idResearches, Title, Idea
	function get_user_researches($user_id){
		$query = "SELECT * FROM Researches WHERE idResearches = "
		$query .= "(SELECT Researches_idResearches FROM Professor_Working_On_Researches WHERE Professor/Teacher_id = ?) ORDER BY name DESC"
		$get_researches_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_researches_stmt, "i", $user_id);
		mysqli_stmt_execute($get_researches_stmt);
		$result_set = mysqli_stmt_get_result($get_researches_stmt);
		mysqli_stmt_close($get_researches_stmt);
		return $result_set
	}

	//keys: idProjects, Supervisor, Idea, name, abstract, Picture_URL, dateStarted, dateEnded, *tag
	function get_user_projects($user_id){
		$query = "SELECT * FROM Projects WHERE idProjects = "
		$query .= "(SELECT Projects_idProjects FROM student_has_Projects WHERE User_userID = ?)  ORDER BY name DESC"
		$get_projects_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_projects_stmt, "i", $user_id);
		mysqli_stmt_execute($get_projects_stmt);
		$result_set = mysqli_stmt_get_result($get_projects_stmt);
		mysqli_stmt_close($get_projects_stmt);
		return $result_set
	}
	
	//keys: projectID, uploaderID, uploadedTime, URL, description
	function get_project_files($project_id){
		$query = "SELECT * FROM projectFiles WHERE projectID = ? "
		$get_project_files_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_project_files_stmt, "i", $project_id);
		mysqli_stmt_execute($get_project_files_stmt);
		$result_set = mysqli_stmt_get_result($get_project_files_stmt);
		mysqli_stmt_close($get_project_files_stmt);
		return $result_set
	}

	//keys: idCourses, Name, about, department, Grading Schema
	function get_student_courses($user_id){
		$query = "SELECT * FROM Courses WHERE idCourses = "
		$query .= "(SELECT Project/Course_id FROM student_have_Courses WHERE student_idStudent = ?)  ORDER BY Name DESC"
		$get_student_courses_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_student_courses_stmt, "i", $user_id);
		mysqli_stmt_execute($get_student_courses_stmt);
		$result_set = mysqli_stmt_get_result($get_student_courses_stmt);
		mysqli_stmt_close($get_student_courses_stmt);
		return $result_set
	}

	//keys: idCourses, Name, about, department, Grading Schema
	function get_prof_courses($user_id){
		$query = "SELECT * FROM Courses WHERE idCourses = "
		$query .= "(SELECT Courses_idCourses FROM professor/teacher_can_teach_courses WHERE Professor/Teacher_idProfessor = ?) ORDER BY Name DESC"
		$get_prof_courses_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_prof_courses_stmt, "i", $user_id);
		mysqli_stmt_execute($get_prof_courses_stmt);
		$result_set = mysqli_stmt_get_result($get_prof_courses_stmt);
		mysqli_stmt_close($get_prof_courses_stmt);
		return $result_set
	}

	//keys: postID, userID, post, *tag, description, time
	function get_post_data($post_id){
		$query = "SELECT * FROM posts WHERE postID = ? LIMIT 1"
		$get_post_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_stmt);
		$result_set = mysqli_stmt_get_result($get_post_stmt);
		mysqli_stmt_close($get_post_stmt);
		return $result_set
	}

	//keys: postID, userID, time, comment
	function get_post_comments($post_id){
		$query = "SELECT * FROM Comments WHERE postID = ? ORDER BY time DESC"
		$get_post_comments_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_comments_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_comments_stmt);
		$result_set = mysqli_stmt_get_result($get_post_comments_stmt);
		mysqli_stmt_close($get_post_comments_stmt);
		return $result_set
	}

	//keys: tagID, tag
	function get_post_tags($post_id){
		$query = "SELECT * FROM tags WHERE tagID = "
		$query .= "(SELECT tags_tagID FROM posts_has_tags WHERE posts_postID = ?) ORDER BY tag DESC"
		$get_post_tags_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_tags_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_tags_stmt);
		$result_set = mysqli_stmt_get_result($get_post_tags_stmt);
		mysqli_stmt_close($get_post_tags_stmt);
		return $result_set
	}

	//keys: tagID, tag
	function get_project_tags($project_id){
		$query = "SELECT * FROM tags WHERE tagID = "
		$query .= "(SELECT tags_tagID FROM Projects_has_tags WHERE Projects_idProjects = ?) ORDER BY tag DESC"
		$get_project_tags_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_project_tags_stmt, "i", $project_id);
		mysqli_stmt_execute($get_project_tags_stmt);
		$result_set = mysqli_stmt_get_result($get_project_tags_stmt);
		mysqli_stmt_close($get_project_tags_stmt);
		return $result_set
	}

	//keys: postID, userID, post, *tag, description, time
	function get_tag_posts($tag){
		$query = "SELECT * FROM posts WHERE postID = "
		$query .= "(SELECT posts_postID FROM posts_has_tags WHERE tags_tagID = "
		$query .= "(SELECT tagID FROM tags WHERE tag = ?)) ORDER BY time DESC"
		$get_tag_posts_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_tag_posts_stmt, "s", $tag);
		mysqli_stmt_execute($get_tag_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_tag_posts_stmt);
		mysqli_stmt_close($get_tag_posts_stmt);
		return $result_set
	}

	//keys: idProjects, Supervisor, Idea, name, abstract, Picture_URL, dateStarted, dateEnded, *tag
	function get_tag_projects($tag){
		$query = "SELECT * FROM Projects WHERE idProjects = "
		$query .= "(SELECT Projects_idProjects FROM Projects_has_tags WHERE tags_tagID = "
		$query .= "(SELECT tagID FROM tags WHERE tag = ?)) ORDER BY name DESC"
		$get_tag_posts_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_tag_posts_stmt, "s", $tag);
		mysqli_stmt_execute($get_tag_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_tag_posts_stmt);
		mysqli_stmt_close($get_tag_posts_stmt);
		return $result_set
	}

?>