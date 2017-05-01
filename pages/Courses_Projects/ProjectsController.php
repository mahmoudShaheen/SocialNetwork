<?php
/**
 * @author Mustafa Kamel   May 1, 2017
 */

/* To deal with this script all you need is to create a file for each function and just write the two lines below
 * first step >> require the file from current path 
 * second step >> call the required function and it will do all the needed work
 * congrats you are done ;)
 */
 /* example:
				<?php
				require_once (PATH."ProjectsController.php");	// while PATH is the path of the file from current location
				project_view();
*/

require_once ("CoursesProjectsModel.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

//confirm_logged_in(); 
//confirm_admin();
/**
 * Inserts the contents of the project form as new entry (i.e new project) in the end of the `projects` table when the form is submitted
 * It is void and takes no parameters
 */
function project_insert () {
	global $connection;
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
		// perform validations on the form data
		$required_fields = array('supervisor', 'idea', 'name', 'abstract', 'pic', 'st_date', 'end_date', 'tag');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('idea' => 450, 'name' => 45, 'abstract' => 1000, 'pic' => 45);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('idea' => 10, 'name' => 3, 'abstract' => 20, 'pic' => 10, 'st_date'=> 6, 'end_date'=>6);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));
		
		if ( empty($errors) ) {
			//check if project already exist
			$supervisor = trim(mysql_prep($_POST['supervisor']));
			$idea = trim(mysql_prep($_POST['idea']));
			$name = trim(mysql_prep($_POST['name']));
			$abstract = trim(mysql_prep($_POST['abstract']));
			$pic = trim(mysql_prep($_POST['pic']));
			$st_date = trim(mysql_prep($_POST['st_date']));
			$end_date = trim(mysql_prep($_POST['end_date']));
			$tag = trim(mysql_prep($_POST['tag']));
			$query = "SELECT `idProjects` FROM `Projects` WHERE `name` = ?";
			$check_project_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_project_stmt, "s", $name);
			mysqli_stmt_execute($check_project_stmt);
			$result = mysqli_stmt_get_result($check_project_stmt);
			mysqli_stmt_close($check_project_stmt);

			if (mysqli_num_rows($result) >= 1) {//another project with the same name is found in the database
				echo $message = "project Already exist.";
			} else {//project is unique, then insert it
	            if (insert_project($supervisor, $idea, $name, $abstract, $pic, $st_date, $end_date, $tag)) {
	                echo $message = "project data has been inserted successfully";
	            } else {
	                echo $message = "An error has been occurred while inserting the project data!";
	            }
	        }
		} else {
			echo $message = "There were " . count($errors) . " errors in the form.";
		}
	} else { /************************************{front end} Form must be drawn here************************************/
	//Form has not been submitted.
		$supervisor = "";
		$idea = "";
		$name = "";
		$abstract = "";
		$pic = "";
		$st_date = "";
		$end_date = "";
		$tag = "";
	}
}

/**
 * Updates the data of specific project (ID) (one row) in the projects table from the project form when the form is submitted
 * It is void and takes no parameters
 */
function project_update () {
    global $connection;
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
		// perform validations on the form data
		$required_fields = array('supervisor', 'idea', 'name', 'abstract', 'pic', 'st_date', 'end_date', 'tag');
		$errors = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('idea' => 450, 'name' => 45, 'abstract' => 1000, 'pic' => 45);
		$errors = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('idea' => 10, 'name' => 3, 'abstract' => 20, 'pic' => 10, 'st_date'=> 6, 'end_date'=>6);
		$errors = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		if ( empty($errors) ) {
			//check if course already exist
			$pid = trim(mysql_prep($_POST['id']));				/*******{front ent} project id is found in input hidden type form element*******/
			$supervisor = trim(mysql_prep($_POST['supervisor']));
			$idea = trim(mysql_prep($_POST['idea']));
			$name = trim(mysql_prep($_POST['name']));
			$abstract = trim(mysql_prep($_POST['abstract']));
			$pic = trim(mysql_prep($_POST['pic']));
			$st_date = trim(mysql_prep($_POST['st_date']));
			$end_date = trim(mysql_prep($_POST['end_date']));
			$tag = trim(mysql_prep($_POST['tag']));
			$query = "SELECT `idProjects` FROM `Projects` WHERE `name` = ?";
			$check_project_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($check_project_stmt, "s", $name);
			mysqli_stmt_execute($check_project_stmt);
			$result = mysqli_stmt_get_result($check_project_stmt);
			mysqli_stmt_close($check_project_stmt);
			
			if (mysqli_num_rows($result) > 1) {//another project with the same name is found in the database
				echo $message = "project Already exist.";
			} else {//project is unique, then update it
	            if (update_project($pid, $supervisor, $idea, $name, $abstract, $pic, $st_date, $end_date, $tag)) {
	                echo $message = "project data has been updated successfully";
	            } else {
	                echo $message = "An error has been occurred while updating the project data!";
	            }
	        }
		} else {
			echo $message = "There were " . count($errors) . " errors in the form.";
		}
	} else { /************************************{front end will relate} Form must be drawn here************************************/
	//Form has not been submitted.
		if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be updated
			$id = $_GET['id'];
			$project = get_project ($id);
			if (count($project) > 0) { //project is found in the database then fill the form with its data to be updated 
				print_r($project);				/********************{front end will relate} fill the form with this content********************/
												/*************************use input type=hidden for the id of the project************************/
			} else { //project is not found
				echo $message = "An error has been occurred, project is not found!";
			}
		} else {//wrong id
			echo $message = "Invalid ID, project is not found!";
		}
	}
}


/**
 * Deletes the data of specific project (ID) (one row) in the Projects table using the id provided in the url using GET
 * It is void and takes no parameters
 */
function project_delete () {
	global $connection;
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be deleted
		$id = $_GET['id'];
		$project = get_project_by_id ($id);
		if (count($project) > 0) { //project is found in the database then delete it 
			delete_project($id);
			echo $message = "Project has been deleted successfully";
		} else { //project is not found
			echo $message = "An error has been occurred, Project is not found!";
		}
	} else {//wrong id
		echo $message = "Invalid ID, project is not found!";
	}
}

/**
 * Get the data of specific project from `Projects` table in the database by its ID (one row) if it is provided in the url
 * Otherwise [if no id provided in the url] get all the projects
 * It is void and takes no parameters
 */
function project_view () {
	global $connection;
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be viewed
		$id = $_GET['id'];
		$project = get_project_by_id ($id);
		if (count($project) > 0) { //project is found in the database then draw it
				print_r($project);				/********************{front end will relate} fill the form with this content********************/
		} else { //project is not found
			echo $message = "An error has been occurred, Project is not found!";
		}
	} else {//no id provided, get all the projects from the database
			$projects = get_projects ();
			if (count($projects) > 0) { //projects table contains entries
				print_r($projects);				/********************{front end will relate} fill the form with this content********************/
			} else { //projects table is empty
				echo $message = "An error has been occurred, No projects are found!";
			}
	}
}