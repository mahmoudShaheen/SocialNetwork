<?php
/**
 * This script is used to view single course if id provided in the url or view all courses if no id provided
 * Get the data of specific course from `Courses` table in the database by its ID (one row) if it is provided in the url
 * Otherwise [if no id provided in the url] get all the courses
 *
 * php version 7.0.8
 * @version 2.0.0
 * @author Mustafa Kamel   May 5, 2017
 * @method GET
 * 
 * @param integer id    id of the course to be viewed, may be null to view all courses
 */

require_once ("../../includes/courses_projects_model.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

confirm_logged_in();

global $connection;
if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be viewed
	$id = (int) $_GET['id'];
	$course = get_course_by_id ($id);
	if (!count($course) > 0) { //course is not found
        unset($course);
		$message = "An error has been occurred, Course is not found!";
	}
} else {//no id provided, get all the courses from the database
	$courses = get_courses ();
	if (!count($courses) > 0) { //courses table is empty
        unset($courses);
		$message = "An error has been occurred, No courses are found!";
	}
}
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
<table id="structure">
	<tr>
		<td id="page">
			<h2>View Courses</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="view_course.php" method="post">
			<table>
            <?php
            if (isset($course)){
				echo "<tr>
					      <td>Name:</td>
					      <td>{$course['Name']}</td>
					      <td>About:</td>
					      <td>{$course['about']}</td>
					      <td>Department:</td>
					      <td>{$course['department']}</td>
					      <td>Grading Schema:</td>
					      <td>{$course['Grading Schema']}</td>
					      <td><a href=\"update_course.php?id={$id}\" class=\"button\">Update</a></td>
					      <td><a href=\"delete_course.php?id={$id}\" class=\"button\">Delete</a></td>
				      </tr>";
            } elseif (isset($courses)) {
                while ($course = array_shift($courses)) {
                    echo "<tr>
					          <td>Name:</td>
					          <td>{$course['Name']}</td>
					          <td>About:</td>
					          <td>{$course['about']}</td>
					          <td>Department:</td>
					          <td>{$course['department']}</td>
					          <td>Grading Schema:</td>
					          <td>{$course['Grading Schema']}</td>
					      	  <td><a href=\"update_course.php?id={$course['idCourses']}\" class=\"button\">Update</a></td>
					      	  <td><a href=\"delete_course.php?id={$course['idCourses']}\" class=\"button\">Delete</a></td>
				          </tr>";
                }
            }
            ?>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>