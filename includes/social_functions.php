<?php
	//functions for retrieving social data
	//like: user data, posts, comments, etc...

	/* 
	*	all functions returns mysqli result set
	*	you can use this to fetch data from it
	*	while ( $row = mysqli_fetch_assoc($result)) {
	*	echo $row["key1"];
	*	echo $row["key2"];
	*	.........
	*	}
	*/

	//database connection
	require_once("db_connection.php");
	
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

	//keys: user_id, email
	function get_user_emails($user_id){
        global $connection;
		$query = "SELECT * FROM emails WHERE user_id = ? ORDER BY email DESC";
		$get_emails_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_emails_stmt, "i", $user_id);
		mysqli_stmt_execute($get_emails_stmt);
		$result_set = mysqli_stmt_get_result($get_emails_stmt);
		mysqli_stmt_close($get_emails_stmt);
		return $result_set;
	}

	//keys: user_id, phone_number
	function get_user_phone_numbers($user_id){
        global $connection;
		$query = "SELECT * FROM phone_number WHERE user_id = ? ORDER BY phone_number DESC";
		$get_numbers_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_numbers_stmt, "i", $user_id);
		mysqli_stmt_execute($get_numbers_stmt);
		$result_set = mysqli_stmt_get_result($get_numbers_stmt);
		mysqli_stmt_close($get_numbers_stmt);
		return $result_set;
	}

	//keys: skillID, skill
	function get_user_skills($user_id){
        global $connection;
		$query = "SELECT * FROM skill WHERE skill_id IN  ";
		$query .= "(SELECT skill_id FROM user_skill WHERE user_id = ?) ORDER BY skill DESC";
		$get_skills_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_skills_stmt, "i", $user_id);
		mysqli_stmt_execute($get_skills_stmt);
		$result_set = mysqli_stmt_get_result($get_skills_stmt);
		mysqli_stmt_close($get_skills_stmt);
		return $result_set;
	}

	//keys: postID, userID, post, *tag, description, time
	function get_user_posts($user_id, $page_number){
        global $connection;
		$offset = $page_number * 10;
		$query = "SELECT * FROM post WHERE user_id = ? ";
		if($offset != 0){
			$query .="OFFSET ? ";
		}
		$query .= "ORDER BY time DESC ";
		$query .="LIMIT 10 ";
		$get_posts_stmt =  mysqli_prepare($connection, $query);
		if($offset != 0){
			mysqli_stmt_bind_param($get_posts_stmt, "ii", $user_id, $offset);
		}else{
			mysqli_stmt_bind_param($get_posts_stmt, "i", $user_id);
		}
		mysqli_stmt_execute($get_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_posts_stmt);
		mysqli_stmt_close($get_posts_stmt);
		return $result_set;
	}

	//keys: userID, positionName, company
	function get_user_positions($user_id){
        global $connection;
		$query = "SELECT * FROM position WHERE user_id = ? ORDER BY position DESC";
		$get_positions_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_positions_stmt, "i", $user_id);
		mysqli_stmt_execute($get_positions_stmt);
		$result_set = mysqli_stmt_get_result($get_positions_stmt);
		mysqli_stmt_close($get_positions_stmt);
		return $result_set;
	}

	//returns college role for user using user id
	function get_user_college_role($user_id){
        global $connection;
		$result = get_user_data($user_id);
		if($row = mysqli_fetch_assoc($result)){
			return $row["college_role"];
		}
		return false;
	}

	//keys: idProjects, Supervisor, Idea, name, abstract, Picture_URL, dateStarted, dateEnded, *tag
	function get_user_projects($user_id){
        global $connection;
		$query = "SELECT * FROM project WHERE project_id IN  ";
		$query .= "(SELECT project_id FROM user_project WHERE user_id = ?)  ORDER BY name DESC";
		$get_projects_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_projects_stmt, "i", $user_id);
		mysqli_stmt_execute($get_projects_stmt);
		$result_set = mysqli_stmt_get_result($get_projects_stmt);
		mysqli_stmt_close($get_projects_stmt);
		return $result_set;
	}
	
	//keys: projectID, uploaderID, uploadedTime, URL, description
	function get_project_files($project_id){
        global $connection;
		$query = "SELECT * FROM project_file WHERE project_id = ? ";
		$get_project_files_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_project_files_stmt, "i", $project_id);
		mysqli_stmt_execute($get_project_files_stmt);
		$result_set = mysqli_stmt_get_result($get_project_files_stmt);
		mysqli_stmt_close($get_project_files_stmt);
		return $result_set;
	}

	//keys: idCourses, Name, about, department, Grading Schema
	function get_student_courses($user_id){
        global $connection;
		$query = "SELECT * FROM course WHERE course_id IN  ";
		$query .= "(SELECT course_id FROM student_course WHERE user_id = ?)  ORDER BY name DESC";
		$get_student_courses_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_student_courses_stmt, "i", $user_id);
		mysqli_stmt_execute($get_student_courses_stmt);
		$result_set = mysqli_stmt_get_result($get_student_courses_stmt);
		mysqli_stmt_close($get_student_courses_stmt);
		return $result_set;
	}

	//keys: idCourses, Name, about, department, Grading Schema
	function get_prof_courses($user_id){
        global $connection;
		$query = "SELECT * FROM course WHERE course_id IN  ";
		$query .= "(SELECT course_id FROM prof_course WHERE user_id = ?) ORDER BY name DESC";
		$get_prof_courses_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_prof_courses_stmt, "i", $user_id);
		mysqli_stmt_execute($get_prof_courses_stmt);
		$result_set = mysqli_stmt_get_result($get_prof_courses_stmt);
		mysqli_stmt_close($get_prof_courses_stmt);
		return $result_set;
	}

	//keys: postID, userID, post, *tag, description, time
	function get_post_data($post_id){
        global $connection;
		$query = "SELECT * FROM post WHERE post_id = ? LIMIT 1";
		$get_post_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_stmt);
		$result_set = mysqli_stmt_get_result($get_post_stmt);
		mysqli_stmt_close($get_post_stmt);
		return $result_set;
	}

	//keys: postID, userID, time, comment
	function get_post_comments($post_id){
        global $connection;
		$query = "SELECT * FROM comment WHERE post_id = ? ORDER BY time DESC";
		$get_post_comments_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_comments_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_comments_stmt);
		$result_set = mysqli_stmt_get_result($get_post_comments_stmt);
		mysqli_stmt_close($get_post_comments_stmt);
		return $result_set;
	}

	//keys: tagID, tag
	function get_post_tags($post_id){
        global $connection;
		$query = "SELECT * FROM tag WHERE tag_id IN  ";
		$query .= "(SELECT tag_id FROM post_tag WHERE post_id = ?) ORDER BY tag DESC";
		$get_post_tags_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_post_tags_stmt, "i", $post_id);
		mysqli_stmt_execute($get_post_tags_stmt);
		$result_set = mysqli_stmt_get_result($get_post_tags_stmt);
		mysqli_stmt_close($get_post_tags_stmt);
		return $result_set;
	}

	//keys: tagID, tag
	function get_project_tags($project_id){
        global $connection;
		$query = "SELECT * FROM tag WHERE tag_id IN  ";
		$query .= "(SELECT tag_id FROM project_tag WHERE project_id = ?) ORDER BY tag DESC";
		$get_project_tags_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_project_tags_stmt, "i", $project_id);
		mysqli_stmt_execute($get_project_tags_stmt);
		$result_set = mysqli_stmt_get_result($get_project_tags_stmt);
		mysqli_stmt_close($get_project_tags_stmt);
		return $result_set;
	}
	
	//keys: postID, userID, post, *tag, description, time
	function get_all_posts( $page_number){
        global $connection;
		$offset = $page_number * 10;
		$query = "SELECT * FROM post ";
		if($offset != 0){
			$query .="OFFSET ? ";
		}
		$query .= "ORDER BY time DESC ";
		$query .="LIMIT 10 ";
		$get_posts_stmt =  mysqli_prepare($connection, $query);
		if($offset != 0){
			mysqli_stmt_bind_param($get_posts_stmt, "i", $offset);
		}
		mysqli_stmt_execute($get_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_posts_stmt);
		mysqli_stmt_close($get_posts_stmt);
		return $result_set;
	}

	//keys: postID, userID, post, *tag, description, time
	function get_tag_posts($tag){
        global $connection;
		$query = "SELECT * FROM post WHERE post_id IN  ";
		$query .= "(SELECT post_id FROM post_tag WHERE tag_id IN  ";
		$query .= "(SELECT tag_id FROM tag WHERE tag = ?)) ORDER BY time DESC";
		$get_tag_posts_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_tag_posts_stmt, "s", $tag);
		mysqli_stmt_execute($get_tag_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_tag_posts_stmt);
		mysqli_stmt_close($get_tag_posts_stmt);
		return $result_set;
	}

	//keys: idProjects, Supervisor, Idea, name, abstract, Picture_URL, dateStarted, dateEnded, *tag
	function get_tag_projects($tag){
        global $connection;
		$query = "SELECT * FROM project WHERE project_id IN  ";
		$query .= "(SELECT project_id FROM project_tag WHERE tag_id IN  ";
		$query .= "(SELECT tag_id FROM tag WHERE tag = ?)) ORDER BY name DESC";
		$get_tag_posts_stmt =  mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($get_tag_posts_stmt, "s", $tag);
		mysqli_stmt_execute($get_tag_posts_stmt);
		$result_set = mysqli_stmt_get_result($get_tag_posts_stmt);
		mysqli_stmt_close($get_tag_posts_stmt);
		return $result_set;
	}

?>