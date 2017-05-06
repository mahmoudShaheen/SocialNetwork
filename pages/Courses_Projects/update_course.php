<?php
/**
 * This script is used to update an exist course in the database
 * Updates the data of specific course (ID) (one row) in the `Courses` table from the course form when the form is submitted
 *
 * 
 * php version 7.0.8
 * @version 2.0.0
 * @author Mustafa Kamel   May 5, 2017
 * @method POST
 * 
 * @param integer id        id of the course to be updated
 * @param string name       name of the course to be updated
 * @param string about      description of the course to be updated
 * @param string department       department of the course to be updated
 * @param string grading_schema    grading_schema of the course to be updated
 */

require_once ("../../includes/courses_projects_model.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

confirm_logged_in();
confirm_admin();

global $connection;
// START FORM PROCESSING
if (isset($_POST['submit'])) {// Form has been submitted.
	$errors = array();
	// perform validations on the form data
	$required_fields = array('id', 'name', 'about', 'department', 'grading_schema');
	$errors = array_merge($errors, check_required_fields($required_fields));
	$fields_max_lengths = array('name' => 45, 'department' => 45, 'grading_schema' => 45);
	$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
	$fields_min_lengths = array('name' => 3, 'department' => 3,  'grading_schema' => 5);
	$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));
	$id = trim(mysql_prep($_POST['id']));
	$name = trim(mysql_prep($_POST['name']));
	$about = trim(mysql_prep($_POST['about']));
	$department = trim(mysql_prep($_POST['department']));
	$grading_schema = trim(mysql_prep($_POST['grading_schema']));

	if ( empty($errors) ) {//check if course already exist
		$query = "SELECT `idCourses` FROM `Courses` WHERE `Name` = ?";
		$check_course_stmt = mysqli_prepare($connection, $query);
		mysqli_stmt_bind_param($check_course_stmt, "s", $name);
		mysqli_stmt_execute($check_course_stmt);
		$result = mysqli_stmt_get_result($check_course_stmt);
		mysqli_stmt_close($check_course_stmt);

		if (mysqli_num_rows($result) > 1) {//another course with the same name is found in the database
			$message = "Course Already exist.";
		} else {//course is unique, then update it
            if (update_course($id, $name, $about, $department, $grading_schema)) {
                $message = "Course data has been updated successfully";
            } else {
                $message = "An error has been occurred while updating the course data!";
            }
        }
	} else {
		$message = "There were " . count($errors) . " errors in the form.";
	}
} else {//Form has not been submitted.
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be updated
		$id = (int) $_GET['id'];
		$course = get_course_by_id ($id);
		if (count($course) > 0) { //course is found in the database then fill the form with its data to be updated 
            $name = $course['Name'];
            $about = $course['about'];
            $department = $course['department'];
            $grading_schema = $course['Grading Schema'];
		} else { //course is not found
			$message = "An error has been occurred, Course is not found!";
	        $name = "";
	        $about = "";
	        $department = "";
	        $grading_schema = "";
		}
	} else {//wrong id
		$message = "Invalid ID, course is not found!";
	    $name = "";
	    $about = "";
	    $department = "";
	    $grading_schema = "";
	}
}
?>
<?php include("../../includes/header_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Update Course</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="update_course.php" method="post">
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="name" maxlength="45" value="<?php echo htmlentities($name); ?>"/></td>
				</tr>
				<tr>
					<td>About:</td>
					<td><input type="text" name="about" maxlength="45" value="<?php echo htmlentities($about); ?>" /></td>
				</tr>
				<tr>
					<td>Department:</td>
					<td><input type="text" name="department" maxlength="45" value="<?php echo htmlentities($department); ?>" /></td>
				</tr>
				<tr>
					<td>Grading Schema:</td>
					<td><input type="text" name="grading_schema" maxlength="45" value="<?php echo htmlentities($grading_schema); ?>" /></td>
				</tr>
				<tr>
					<td><input type="hidden" name="id" value="<?php echo htmlentities($id); ?>" /></td>
					<td colspan="2"><input type="submit" name="submit" value="Update Course" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php include("../../includes/footer.php"); ?>