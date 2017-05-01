<?php
/**
 * @author Mustafa Kamel   May 1, 2017
 */

/* To deal this script all you need is to create a file for each function and just write the two lines below
 * first step >> require the file from current path 
 * second step >> call the required function and it will do all the needed work
 * congrats you are done ;)
 */
 /* example:
				<?php
				require_once (PATH."CoursesController.php");	// while PATH is the path of the file from current location
				course_view();
*/

require_once ("CoursesProjectsModel.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

confirm_logged_in();
confirm_admin();
/**
 * Inserts the contents of the course form as new entry (i.e new course) in the end of the Courses table when the form is submitted
 * It is void and takes no parameters
 */
function course_insert () {
	global $connection;
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
		// perform validations on the form data
		$required_fields = array('name', 'about', 'department', 'grading_schema');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('name' => 45, 'department' => 45, 'grading_schema' => 45);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('name' => 3, 'department' => 3,  'grading_schema' => 5);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		if ( empty($errors) ) {
			//check if course already exist
			$name = trim(mysql_prep($_POST['name']));
			$about = trim(mysql_prep($_POST['about']));
			$department = trim(mysql_prep($_POST['department']));
			$grading_schema = trim(mysql_prep($_POST['grading_schema']));
			$query = "SELECT `idCourses` FROM `Courses` WHERE `Name` = ?";
			$check_course_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_course_stmt, "s", $name);
			mysqli_stmt_execute($check_course_stmt);
			$result = mysqli_stmt_get_result($check_course_stmt);
			mysqli_stmt_close($check_course_stmt);

			if (mysqli_num_rows($result) >= 1) {//another course with the same name is found in the database
				echo $message = "Course Already exist.";
			} else {//course is unique, then insert it
	            if (insert_course($name, $about, $department, $grading_schema)) {
	                echo $message = "Course data has been inserted successfully";
	            } else {
	                echo $message = "An error has been occurred while inserting the course data!";
	            }
	        }
		} else {
			echo $message = "There were " . count($errors) . " errors in the form.";
		}
	} else { /************************************{front end} Form must be drawn here************************************/
	//Form has not been submitted.
		$name = "";
		$about = "";
		$department = "";
		$grading_schema = "";
	}
}
/**
 * Updates the data of specific course (ID) (one row) in the Courses table from the course form when the form is submitted
 * It is void and takes no parameters
 */
function course_update () {
	global $connection;
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
		// perform validations on the form data
		$required_fields = array('name', 'about', 'department', 'grading_schema');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('name' => 45, 'department' => 45, 'grading_schema' => 45);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('name' => 3, 'department' => 3,  'grading_schema' => 5);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		if ( empty($errors) ) {
			//check if course already exist
			$id = trim(mysql_prep($_POST['id']));				/*******{front ent} course id is found in input hidden type form element*******/
			$name = trim(mysql_prep($_POST['name']));
			$about = trim(mysql_prep($_POST['about']));
			$department = trim(mysql_prep($_POST['department']));
			$grading_schema = trim(mysql_prep($_POST['grading_schema']));
			$query = "SELECT `idCourses` FROM `Courses` WHERE `Name` = ?";
			$check_course_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_course_stmt, "s", $name);
			mysqli_stmt_execute($check_course_stmt);
			$result = mysqli_stmt_get_result($check_course_stmt);
			mysqli_stmt_close($check_course_stmt);

			if (mysqli_num_rows($result) > 1) {//another course with the same name is found in the database
				echo $message = "Course Already exist.";
			} else {//course is unique, then update it
	            if (update_course($id, $name, $about, $department, $grading_schema)) {
	                echo $message = "Course data has been updated successfully";
	            } else {
	                echo $message = "An error has been occurred while updating the course data!";
	            }
	        }
		} else {
			echo $message = "There were " . count($errors) . " errors in the form.";
		}
	} else { /************************************{front end will relate} Form must be drawn here************************************/
	//Form has not been submitted.
		if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be updated
			$id = $_GET['id'];
			$course = get_course_by_id ($id);
			if (count($course) > 0) { //course is found in the database then fill the form with its data to be updated 
				print_r($course);				/********************{front end will relate} fill the form with this content********************/
												/*************************use input type=hidden for the id of the course************************/
			} else { //course is not found
				echo $message = "An error has been occurred, Course is not found!";
			}
		} else {//wrong id
			echo $message = "Invalid ID, course is not found!";
		}
	}
}

/**
 * Deletes the data of specific course (ID) (one row) in the Courses table using the id provided in the url using GET
 * It is void and takes no parameters
 */
function course_delete () {
	global $connection;
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be deleted
		$id = $_GET['id'];
		$course = get_course_by_id ($id);
		if (count($course) > 0) { //course is found in the database then delete it 
			delete_course($id);
			echo $message = "Course has been deleted successfully";
		} else { //course is not found
			echo $message = "An error has been occurred, Course is not found!";
		}
	} else {//wrong id
		echo $message = "Invalid ID, course is not found!";
	}
}

/**
 * Get the data of specific course from `Courses` table in the database by its ID (one row) if it is provided in the url
 * Otherwise [if no id provided in the url] get all the courses
 * It is void and takes no parameters
 */
function course_view () {
	global $connection;
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected course to be viewed
		$id = $_GET['id'];
		$course = get_course_by_id ($id);
		if (count($course) > 0) { //course is found in the database then draw it
				print_r($course);				/********************{front end will relate} fill the form with this content********************/
		} else { //course is not found
			echo $message = "An error has been occurred, Course is not found!";
		}
	} else {//no id provided, get all the courses from the database
			$courses = get_courses ();
			if (count($courses) > 0) { //courses table contains entries
				print_r($courses);				/********************{front end will relate} fill the form with this content********************/
			} else { //courses table is empty
				echo $message = "An error has been occurred, No courses are found!";
			}
	}
}