<?php
/**
 * This script is used to delete an exist project in the database
 * Deletes the data of specific project (ID) (one row) in the `Projects` table using the id provided in the url using GET
 * 
 * php version 7.0.8
 * @version 2.0.0
 * @author Mustafa Kamel   May 5, 2017
 * @method GET
 * 
 * @param integer id        id of the project to be deleted
 */


require_once ("../../includes/courses_projects_model.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");
require_once("../../includes/form_functions.php");

confirm_logged_in();
confirm_admin();

global $connection;
if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be deleted
	$id = (int) $_GET['id'];
	$project = get_project_by_id ($id);
	if (count($project) > 0) { //project is found in the database then delete it 
		delete_project($id);
		$message = "Project has been deleted successfully";
	} else { //project is not found
		$message = "An error has been occurred, Project is not found!";
	}
} else {//wrong id
	$message = "Invalid ID, project is not found!";
}
?>

<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Delete Project</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
		</td>
	</tr>
</table>
<?php include("../../includes/footer.php"); ?>