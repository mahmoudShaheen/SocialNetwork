<?php
/**
 * This script is used to delete an exist course in the database
 * Deletes the data of specific course (ID) (one row) in the `Courses` table using the id provided in the url using GET
 * 
 * php version 7.0.8
 * @version 2.0.0
 * @author Mustafa Kamel   May 5, 2017
 * @method GET
 * 
 * @param integer id        id of the course to be deleted
 */


require_once ("../../includes/courses_projects_model.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

confirm_logged_in();
confirm_admin();

global $connection;
if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be deleted
	$id = (int) $_GET['id'];
	$course = get_course_by_id ($id);
	if (count($course) > 0) { //course is found in the database then delete it 
		delete_course($id);
		$message = "Course has been deleted successfully";
	} else { //course is not found
		$message = "An error has been occurred, Course is not found!";
	}
} else {//wrong id
	$message = "Invalid ID, course is not found!";
}
?>

<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Delete Course</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
		</td>
	</tr>
</table>
<?php include("../../includes/footer.php"); ?>